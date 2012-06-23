<?php

    if(($rps_numero == "")||($rps_data =="")||($tomador_nome  =="")||($tomador_cnpjcpf =="")||($tomador_logradouro =="")
	||($tomador_numero  =="")||($tomador_bairro =="")||($tomador_municipio =="")||($tomador_uf  =="")||($tomador_email =="")
	||($discriminacao =="")||($valordeducoes =="")||($estado ==""))
	{    
	  $erro =1;	
	}

	if ((strlen($tomador_cnpjcpf) != 14) && (strlen($tomador_cnpjcpf) != 18))	
	{
	 $erro = 4;	
	}
	else
	{
	  if(strlen($tomador_cnpjcpf) == 14)
	  {
	    if((substr($tomador_cnpjcpf,3,1) != ".") ||(substr($tomador_cnpjcpf,7,1) != ".")||(substr($tomador_cnpjcpf,11,1) != "-"))
		{
		  $erro = 4;
		}
	  }
	  
	  if(strlen($tomador_cnpjcpf) == 18)
	  {
	    if((substr($tomador_cnpjcpf,2,1) != ".") ||(substr($tomador_cnpjcpf,6,1) != ".")||(substr($tomador_cnpjcpf,10,1) != "/")||(substr($tomador_cnpjcpf,15,1) != "-"))
		{
		  $erro = 4;
		}
	  
	  }
	}
	
	if(strlen($rps_data) !="10")
	{
	  $erro =5;
	}
	else
	{
	  if((substr($rps_data,4,1)!= "-")|| (substr($rps_data,7,1)!= "-"))
	  {
	    $erro =5 ;
	  }
	}

	if(strlen($tomador_cep) != "9")
	{
	  $erro =6;
	}
	else
	{
	  if(substr($tomador_cep,5,1)!= "-")
	  {
	    $erro =6 ;
	  }
	}
	
	$sql_verifica_rps = mysql_query("SELECT codigo FROM notas WHERE rps_numero = '$rps_numero' AND codemissor = '$CODIGO_DA_EMPRESA'");
	if(mysql_num_rows($sql_verifica_rps)){
		$erro = 7;
	}
	
	
?>