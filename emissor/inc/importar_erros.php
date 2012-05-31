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