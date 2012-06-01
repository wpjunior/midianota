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
// inicia a sessão verificando se jah esta com o usuario logado, se estiver entra na página admin
session_name("contador");
session_start();
$_SESSION['autenticacao'] = rand(10000,99999);

if(!(isset($_SESSION["empresa"])))
{   ?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>e-Nota</title>
<script src="../scripts/padrao.js" language="javascript" type="text/javascript"></script>
<script src="../scripts/java_site.js" language="javascript" type="text/javascript"></script>
<link href="../css/padrao_emissor.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="javascript" src="../scripts/funcoes_emissor.js"></script>
</head>

<body>
<center>
<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><?php include("../include/topo.php"); ?></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" height="400" background="../img/fundos/login.jpg" style="background-repeat:repeat-x">
	
 
 
<!-- formulario de login --> 
<form action="inc/verifica.php" method="post" onsubmit="return ValidaFormulario('txtLogin|txtSenha|codseguranca');" >
<table border="0" align="center" cellpadding="0" cellspacing="1">
    <tr>
      <td width="10" height="10" bgcolor="#FFFFFF"></td>
	  <td width="100" align="center" bgcolor="#FFFFFF" rowspan="3">Acesso Restrito</td>
      <td width="200" bgcolor="#FFFFFF"></td>
	</tr>
	<tr>
	  <td height="1" bgcolor="#CCCCCC"></td>
      <td bgcolor="#CCCCCC"></td>
	</tr>
	<tr>
	  <td height="10" bgcolor="#FFFFFF"></td>
      <td bgcolor="#FFFFFF"></td>
	</tr>
	<tr>
		<td colspan="3" height="1" bgcolor="#CCCCCC"></td>
	</tr>
	<tr>
		<td height="60" colspan="3" bgcolor="#CCCCCC">

    <table border="0" align="center">
	 <tr> 
	  <td align="left">
	    CPF/CNPJ
	  </td>
	  <td>	   	   
	   <input type="text" name="txtLogin" id="txtLogin" size="30" class="texto" onkeyup="CNPJCPFMsk( this )"/>
	  </td>
	 </tr>
	 <tr> 
	  <td align="left">
	    Senha
	  </td>
	  <td>	 
	   <input type="password" name="txtSenha" id="txtSenha" size="30" class="texto" />
	  </td>
	 </tr>
	 <tr valign="baseline"> 
	  <td style="font-size:9px">
	    Cód. Verificação
	  </td>
	  <td align="left" >	 
	   <input type="text" name="codseguranca" id="codseguranca" size="6" class="texto" />  &nbsp;
	   <img style="cursor: pointer;" onclick="mostrar_teclado();" src="../img/botoes/num_key.jpg" title="Teclado Virtual" /> &nbsp;
	   <?php include("inc/cod_verificacao.php"); ?></td>
	 </tr>
	 <tr>	 
	  <td align="center" colspan="2">
	   <input type="submit" name="btEntrar" size="30" value="Entrar" class="botao" />
	  </td>
	 </tr>
     <tr>
      <td align="center" colspan="2"><a href="../site/recuperarsenha.php">Recuperar Senha</a></td>
     </tr>
	</table>			
		</td>
	</tr>
	<tr>
    	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
	</tr>
</table>    
</form>  
<!-- formulario de login Fim -->	 
	
	
	</td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" background="../img/rodapes/fundo.jpg">
  <tr>
    <td align="center"><img src="../img/rodapes/rodape_login.jpg" alt="" /></td>
  </tr>
</table>
</center>

</body>
</html>

<?php 

}else {

print("<script language=JavaScript>parent.location='aplic.php';</script>");
 
} 

?>  
