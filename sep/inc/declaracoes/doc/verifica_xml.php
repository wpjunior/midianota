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
	   $competencia= $_POST['cmbMes']."/".$_POST['cmbAno'];
	   $codverificacao= gera_codverificacao();
	   $opr_creditos = $_POST['txtCNPJ'];  
	   $arq = $_FILES["import"]['name'];
	   $arq_tmp = $_FILES['import']['tmp_name'];  				
	   $data=date("dmY");
	   $CompMes = $_POST['cmbMes'];
	   $CompAno = $_POST['cmbAno'];
	   $competencia = "$CompAno-$CompMes-01";
	   $codtipo = codtipo("operadora_credito");
	   $sql=mysql_query("SELECT razaosocial FROM cadastro WHERE cnpj = '$opr_creditos' AND codtipo = '$codtipo'");
	   list($razao)=mysql_fetch_array($sql);
	   
	   if(mysql_num_rows($sql)>0){
		   $arq = $razao.$data.'.xml';		
		   move_uploaded_file($arq_tmp,"xmls/doc/".$arq);   	   	
		   $xml = simplexml_load_file("xmls/doc/".$arq); // lê o arquivo XML      							   	   	   
	
		   if($xml){
			   $verifica=0;
			   foreach($xml ->CONTA as $conta)
			   {
					$sql=mysql_query("SELECT conta FROM doc_contas");
					while(list($docconta)=mysql_fetch_array($sql)){	
						if($docconta == $conta->CONTAOFICIAL)
						{	
							$verifica=1;						
							$total_boleto +=$conta->VALORISS;
						 }				
					}			
				}
			   if($verifica ==1)
			   {
				   //$competencia=date('Y-m-d');
				   $sql=mysql_query("SELECT codigo FROM cadastro WHERE cnpj = '$opr_creditos'");
				   list($codopr)=mysql_fetch_array($sql);		   
				   mysql_query("
						INSERT INTO 
							doc_des 
						SET 
							codopr_credito = '$codopr', 
							data = NOW(), 
							competencia = '$competencia', 
							codverificacao = '$codverificacao'
				   ");
				   $sql=mysql_query("SELECT MAX(codigo) FROM doc_des WHERE codopr_credito = '$codopr'");
				   list($CodDocDes)=mysql_fetch_array($sql);		   
				   foreach($xml ->CONTA as $conta)
				   {
						$sql=mysql_query("SELECT conta FROM doc_contas");
						while(list($docconta)=mysql_fetch_array($sql)){			
							if($docconta == $conta->CONTAOFICIAL){	
								
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
									INSERT INTO 
										doc_des_contas 
									SET
										coddoc_des = '$CodDocDes',
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
							doc_des 
						SET 
							total='$totalreceita'
						WHERE
							codigo='$CodDocDes'
					");
					
				 Mensagem("Declaração efetuada com sucesso!!")			 	;
				 /*$vencimento = DataVencimento();
				 mysql_query("
					INSERT INTO 
						guia_pagamento 
					SET 
						dataemissao = NOW(),
						valor = '$total_boleto',
						valormulta = '0.0',
						datavencimento = '$vencimento',
						pago = 'N'");
						
				 $sql_guia = mysql_query("SELECT MAX(codigo) FROM guia_pagamento");
				 list($CodGuia)=mysql_fetch_array($sql_guia);
				 $nossonumero = gerar_nossonumero($CodGuia);
				 $chave = gerar_chavecontrole($CodDocDes,$CodGuia); 
				 $sql_guia_update = mysql_query("UPDATE guia_pagamento SET nossonumero='$nossonumero', chavecontroledoc='$chave' WHERE codigo = '$CodGuia'");
				 mysql_query("INSERT INTO guias_declaracoes SET codguia = '$CodGuia', codrelacionamento = '$CodDocDes', relacionamento = 'doc_des'");
				 */
				 
				 $COD = base64_encode($CodGuia);
				 $CodDocDes = base64_encode($CodDocDes);
				 
				 //Deleta o arquivo.xml da pasta xmls
				 unlink("xmls/doc/".$arq);
	
				 // busca o codigo do banco e o arquivo q gera o boleto
						$sql=mysql_query("
							SELECT 
								bancos.boleto, 
								boleto.tipo 
							FROM 
								boleto 
							INNER JOIN 
								bancos ON bancos.codigo = boleto.codbanco
						");
						list($boleto,$tipoboleto)=mysql_fetch_array($sql);
						if($tipoboleto=="R"){
							$tipoboleto="recebimento";
							$boleto="index.php";
						}else{
							$tipoboleto="pagamento";
						}
	
				 //Abre o comprovante de declaracao para o usuario
				 //NovaJanela("boleto/$tipoboleto/$boleto?COD=$COD");
				 NovaJanela("reports/doc_comprovante.php?COD=$CodDocDes");
				 
				 }else{		 
					Mensagem("Conteúdo do arquivo não contém Conta Oficial válida.");
				 }			 
			}else{		 
				Mensagem("O arquivo enviado contém erros. Favor verificar!!");
			}		
	}else{
		Mensagem("Este cnpj não está cadastrado ou não é uma operadora de crédito!");
	}
?>		 