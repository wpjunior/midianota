<?php
	include("conect.php");
	$_SESSION['login'] = $txtLogin; 
	$_SESSION['nome'] = $txtNome;

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
	  
	  if($numeronota > $maior)
	  {
		$maior=$numeronota;
	  }  
	  $cont--;
	}

	$sql=mysql_query("SELECT agencia,contacorrente,convenio,contrato,carteira FROM boleto");
	list($agencia,$contacorrente,$convenio,$contrato,$carteira)=mysql_fetch_array($sql);
	$txtTotalIss = explode(".",$txtTotalIss);
	$valor =implode(",",$txtTotalIss); 
	
        
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