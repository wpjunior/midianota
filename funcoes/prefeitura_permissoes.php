<?php  
  
  include("../prefeitura/inc/funcao_logs.php");  
  include("util.php");  

  function PermissaoMenu($arquivo,$url){		
  	include("../$url/inc/conect.php");
	$sql=mysql_query("SELECT nivel FROM menus_prefeitura WHERE link='$arquivo'");
	list($permissao)=mysql_fetch_array($sql);
		if($_SESSION["nivel_de_acesso"]=="A"){$acesso="ok";}			
		elseif(($_SESSION["nivel_de_acesso"]=="M") &&(($permissao=="M")||($permissao=="B"))){$acesso="ok";}			
		elseif(($_SESSION["nivel_de_acesso"]=="B") &&($permissao=="B")){$acesso="ok";}			
		else{
			 Redireciona("../$url/login.php"); 
		}		
  }	
?>	