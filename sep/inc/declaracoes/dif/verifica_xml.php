<?php
/*
COPYRIGHT 2008 - 2010 DO PORTAL PUBLICO INFORMATICA LTDA

Este arquivo e parte do programa E-ISS / SEP-ISS

O E-ISS / SEP-ISS e um software livre; voce pode redistribui-lo e/ou modifica-lo
dentro dos termos da Licenca Publica Geral GNU como publicada pela Fundacao do
Software Livre - FSF; na versao 2 da Licenca

Este sistema e distribuido na esperanca de ser util, mas SEM NENHUMA GARANTIA,
sem uma garantia implicita de ADEQUACAO a qualquer MERCADO ou APLICACAO EM PARTICULAR
Veja a Licenca Publica Geral GNU/GPL em portugues para maiores detalhes

Voce deve ter recebido uma copia da Licenca Publica Geral GNU, sob o titulo LICENCA.txt,
junto com este sistema, se nao, acesse o Portal do Software Publico Brasileiro no endereco
www.softwarepublico.gov.br, ou escreva para a Fundacao do Software Livre Inc., 51 Franklin St,
Fith Floor, Boston, MA 02110-1301, USA
*/
?>
<?php  
	libxml_use_internal_errors(true);
	$competencia    = $_POST['cmbMes']."/".$_POST['cmbAno'];
	$codverificacao = gera_codverificacao();
	$inst           = $_POST['txtCNPJ']; 
	$arq            = $_FILES["import"]['name'];
	$arq_tmp        = $_FILES['import']['tmp_name'];  				
	$data           = date("dmY");
	$CompMes        = $_POST['cmbMes'];
	$CompAno        = $_POST['cmbAno'];
	$competencia    = "$CompAno-$CompMes-01";
	$codtipo        = codtipo("instituicao_financeira");
	$sql = mysql_query("SELECT razaosocial FROM cadastro WHERE cnpj = '$inst' AND codtipo = '$codtipo'");
	list($razao) = mysql_fetch_array($sql);
	
	if(mysql_num_rows($sql)>0){
		$arq = $razao.$data.'.xml';		
		move_uploaded_file($arq_tmp,"xmls/dif/".$arq);   	   	
		$xml = simplexml_load_file("xmls/dif/".$arq); // lê o arquivo XML      							   	   	   
	
		if($xml){
			$verifica=0;
			foreach($xml ->CONTA as $conta) {
				$sql=mysql_query("SELECT conta FROM dif_contas");
				while(list($difconta)=mysql_fetch_array($sql)){			
					if($difconta == $conta->CONTAOFICIAL) {	
						$verifica=1;						
						$total_boleto +=$conta->VALORISS;
					 }				
				}	
			}
			if($verifica ==1)		   {
						
			//$competencia=date("Y-m-d");
			$sql=mysql_query("SELECT codigo FROM cadastro WHERE cnpj = '$inst'");
			list($codinst)=mysql_fetch_array($sql);		   
			mysql_query("
				INSERT INTO 
					dif_des 
				SET 
					codinst_financeira = '$codinst',
					data = NOW(),
					competencia = '$competencia',
					codverificacao = '$codverificacao'
			");
			$totalreceita = 0.00;
			$sql = mysql_query("SELECT MAX(codigo) FROM dif_des WHERE codinst_financeira = '$codinst'");
			list($CodDifDes) = mysql_fetch_array($sql);		   
			foreach($xml ->CONTA as $conta)	{
				$sql=mysql_query("SELECT conta FROM dif_contas");
				while(list($difconta)=mysql_fetch_array($sql)){			
					if($difconta == $conta->CONTAOFICIAL){	
						
						$CONTAOFICIAL = $conta->CONTAOFICIAL;	   
						$CONTACONTABIL = $conta->CONTACONTABIL;	   
						$TITULO = $conta->TITULO;
						$ITEM = $conta->ITEM;
						$SALDOMESANTERIOR = $conta->SALDOMESANTERIOR;
						$DEBITOMESATUAL = $conta->DEBITOMESATUAL;
						$CREDITOMESATUAL = $conta->CREDITOMESATUAL;
						$SALDOMESATUAL = $conta->SALDOMESATUAL;
						$RECEITADOMES = $conta->RECEITADOMES;
						$ALIQUOTA = $conta->ALIQUOTA;
						$VALORISS = $conta->VALORISS;
						mysql_query("
							INSERT INTO dif_des_contas 
							 SET
							 coddif_des = '$CodDifDes',
							 contaoficial = '$CONTAOFICIAL',
							 contacontabil = '$CONTACONTABIL',
							 titulo = '$TITULO',
							 item = '$ITEM',
							 saldo_mesanterior = '$SALDOMESANTERIOR',
							 debito = '$DEBITOMESATUAL',
							 credito = '$CREDITOMESATUAL',
							 saldo_mesatual = '$SALDOMESATUAL',
							 receita = '$RECEITADOMES',
							 aliquota = '$ALIQUOTA',
							 iss = '$VALORISS'
						");
						$totalreceita += (float)$RECEITADOMES;
					}				
				}				
			}
			mysql_query("
				UPDATE  
					dif_des 
				SET 
					total = '$totalreceita'
				WHERE
					codigo = '$CodDifDes'
			");
	
					
			 Mensagem("Declaração efetuada com sucesso!!");
			 /*$vencimento = DataVencimento();
			 mysql_query("
				INSERT INTO 
					guia_pagamento 
				SET 
					dataemissao = NOW(),
					valor = '$total_boleto',
					valormulta = '0.00',
					datavencimento = '$vencimento',
					pago = 'N'");
					
			 $sql_guia = mysql_query("SELECT MAX(codigo) FROM guia_pagamento");
			 list($CodGuia)=mysql_fetch_array($sql_guia);
			 $nossonumero = gerar_nossonumero($CodGuia);
			 $chave = gerar_chavecontrole($CodDifDes,$CodGuia); 
			 $sql_guia_update = mysql_query("UPDATE guia_pagamento SET nossonumero='$nossonumero', chavecontroledoc='$chave' WHERE codigo = '$CodGuia'");
			 mysql_query("INSERT INTO guias_declaracoes SET codguia = '$CodGuia', codrelacionamento = '$CodDifDes', relacionamento = 'dif_des'");
			 $COD = base64_encode($CodGuia);
			 
			 NovaJanela("boleto/$BOLETO_BANCO?COD=$COD");
			 */
			 //Deleta o arquivo.xml da pasta xmls
			 unlink("xmls/dif/".$arq);
			 
			 //Abre o comprovante de declaracao para o usuario
			 $CodDifDes = base64_encode($CodDifDes);
			 NovaJanela("reports/dif_comprovante.php?COD=$CodDifDes");
			 }else{		 
				Mensagem("Conteúdo do arquivo não contém Conta Oficial válida.");
			 }	 
		}else{
			Mensagem("O arquivo enviado contém erros. Favor verificar!");
		}
	}else{
		Mensagem("Este cnpj não está cadastrado ou não é uma instituição financeira!");
	}
?>