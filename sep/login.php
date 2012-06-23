<?php 

session_start();
$_SESSION['autenticacao'] = rand(10000,99999);
if(!(isset($_SESSION["logado"])))
{
    
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>SEP-ISS</title>
<link href="css/padrao.css" rel="stylesheet" type="text/css" >
<script src="scripts/padrao.js" type="text/javascript"></script>

</head>

<body class="principal" onLoad="window.toolbar.visible='false';">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" align="center" valign="middle">
  <tr>
  	<td height="30%">&nbsp</td>
  </tr>
  <tr>
    <td align="center" valign="middle" height="40%">
<form name="frmLogin" action="inc/verifica.php" method="post">
<table border="0" cellspacing="0" cellpadding="1">
      <tr>
        <td colspan="3" height="1" bgcolor="#FFFFFF"></td>
        </tr>

      <tr>
        <td colspan="3" height="25" bgcolor="#CCCCCC">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="3" align="center" bgcolor="#FFFFFF"><img src="img/logosep.jpg" width="370" height="70"></td>
        </tr>
      <tr>
        <td width="118" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="182" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="100" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td height="28" align="right" bgcolor="#FFFFFF"><strong>Usu&aacute;rio</strong></td>
        <td align="center" bgcolor="#FFFFFF"><input name="txtLogin" type="text" id="txtLogin" class="texto" tabindex="1"></td>
        <td rowspan="3" bgcolor="#FFFFFF"><input type="image" name="imageField" src="img/chave.jpg" tabindex="4"></td>
      </tr>
      <tr>
        <td height="29" align="right" bgcolor="#FFFFFF"><strong>Senha</strong></td>
        <td align="center" bgcolor="#FFFFFF"><input name="txtSenha" type="password" id="txtSenha" class="texto" tabindex="2"></td>
      </tr>
	  <tr>
        <td height="29" align="right" bgcolor="#FFFFFF"><strong>Cód Verificação</strong></td>
        <td align="center" valign="middle" bgcolor="#FFFFFF">
        	<input name="codseguranca" type="text" id="codseguranca" class="texto" size="5" maxlength="5" tabindex="3"> 
        	<img style="cursor: pointer;" onClick="mostrar_teclado();" src="img/botoes/num_key.jpg" title="Teclado Virtual" >&nbsp; 
        	<?php include("inc/cod_verificacao.php");?>
        </td>		
      </tr>	
      <tr>	  
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
      </tr>	  
      <tr>
        <td colspan="3" height="25" bgcolor="#CCCCCC"></td>
      </tr>
      <tr>
        <td colspan="3" height="1" bgcolor="#FFFFFF"></td>
      </tr>
      <tr>
        <td colspan="3" height="1" bgcolor="#FFFFFF"></td>
      </tr>
    </table>
	</form>
	
	
  
	</td>
  </tr>
  <tr>
  	<td height="30%">&nbsp</td>
  </tr>
</table>


<?php include 'inc/teclado.php';?>
</body>
</html>

<?php 
}else {
header('Location: principal.php') ;
} 

?>
