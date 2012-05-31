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
	include("conect.php");
	$_SESSION['login'] = $txtLogin; 
	$_SESSION['nome'] = $txtNome;
	//Recebe a variavel enviada por post do arquivo pagamento_resultado
	$codbanco01 = $_POST["hdBanco"];

	$sql01=mysql_query("SELECT bancos.banco FROM bancos INNER JOIN boleto ON boleto.codbanco = bancos.codigo WHERE codbanco = '$codbanco01'");
    list($BANCOMONETARIO)=mysql_fetch_array($sql01);
	
	$sql02=mysql_query("SELECT boleto FROM bancos WHERE banco='$BANCOMONETARIO'");
	list($BOLETO)=mysql_fetch_array($sql02);
	
	$sql=mysql_query("SELECT endereco,cidade,estado,cnpj FROM configuracoes");
	list($enderdco_pref,$cidade_pref,$estado_pref,$cnpj_pref)=mysql_fetch_array($sql);	
	
	$dados=explode("|",$_POST["txtTotalIssHidden"]); //cria um vetor com o valor total do boleto e  com a quantidade de notas
	$cont = $dados[1];
	$maior =0;
	while($cont >= 0)
	{  
	  $codnota = $_POST['txtCodNota'.$cont];  
	  $sql=mysql_query("SELECT numero FROM notas WHERE codigo ='$codnota'");  
	  list($numeronota)=mysql_fetch_array($sql);
	  
	  //mysql_query("UPDATE notas SET estado='B' WHERE codigo='$codnota'");
	  if($numeronota > $maior)
	  {
		$maior=$numeronota;
	  }  
	  $cont--;
	}
	//seleiona os dados monetarios da prefeitura
	$sql=mysql_query("SELECT agencia,contacorrente,convenio,contrato,carteira FROM boleto");
	list($agencia,$contacorrente,$convenio,$contrato,$carteira)=mysql_fetch_array($sql);
	$txtTotalIss = explode(".",$txtTotalIss);
	$valor =implode(",",$txtTotalIss); 
	
	//Gera o nossonumero com 4 caracteres para o numero da nota e 4 caracteres para o codigo do emisor
	while(strlen($maior) < 4)
	{
	 $maior = $maior . 0;
	}	
	 
	while(strlen($CODIGO_DA_EMPRESA)< 4)
	{
	 $CODIGO_DA_EMPRESA = 0 . $CODIGO_DA_EMPRESA;
	}	
	$NossoNumero = $maior.$CODIGO_DA_EMPRESA ;
	
	
	
	$DataEmissaoBoleto = date("Y-m-d");
	
	$cont =$dados[1];
	
	$valor = explode(",",$valor); 	
	$txtTotalIss = implode(".",$valor);
	
	
	
	$DataVencimentoBoleto = date("Y-m-d", time() + (5 * 86400));
	
	
	while($cont >= 0)
	{  
	  $codnota = $_POST['txtCodNota'.$cont];  
	  if ($codnota !="")
	  {
		  mysql_query("
		  	INSERT INTO 
				guia_pagamento 
			SET 
				dataemissao='$DataEmissaoBoleto',
				datavencimento='$DataVencimentoBoleto', 
				valor='$txtTotalIss',
				chavecontroledoc='80$NossoNumero',
				pago='N'
			");
				/*
				codrelacionamento ='$codnota'
				*/
			$sql = mysql_query("SELECT codigo FROM guia_pagamento WHERE chavecontroledoc = '80$NossoNumero'");
			list($codigo) = mysql_fetch_array($sql);
			
			mysql_query("
				INSERT INTO 
					guias_declaracoes 
				SET
					codrelacionamento ='$codnota',
					relacionamento = 'des',
					codguia = '$codigo'
			");
	  }	  
	  $cont--;
	}
	add_logs('Gerou uma guia');
	print("<script>window.open(\"boleto/$BOLETO?chave=$NossoNumero\");</script>");
	
	
?>