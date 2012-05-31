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
  
  //arquivo com a funcao de gerar logs
  include("../prefeitura/inc/funcao_logs.php");  
  // arquivo com funcoes uteis 
  include("util.php");  
  //Verifica qual o nivel de permissao que a pagina requere e qual o nivel do usuario logado
  function PermissaoMenu($arquivo,$url){		
  	//arquivo de conexao com o banco de dados, endereco muda de prefeitura, emissor ou contador
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