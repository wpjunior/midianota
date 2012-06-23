<?php
  session_start();

  include("../include/conect.php"); 
  include("../funcoes/util.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>e-Nota</title>
<script src="../scripts/java_site.js" language="javascript" type="text/javascript"></script>
<link href="../css/padrao_site.css" rel="stylesheet" type="text/css" />
</head>

<body>
<center>
<table width="760" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><?php include("inc/topo.php"); ?></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" height="400" valign="top" align="center">
	
<!-- frame central inicio --> 	
<table border="0" cellspacing="0" cellpadding="0" height="100%" >
  <tr>
    <td width="170" align="left" background="../img/menus/menu_fundo.jpg" valign="top"><?php include("inc/menu.php"); ?></td>
    <td width="590" height="100" bgcolor="#FFFFFF" valign="top" align="center">

      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="590"><img src="../img/cabecalhos/noticias.jpg" width="590" height="100" /></td>
        </tr>
        <tr>
          <td align="center" valign="top"><br />
		  
		  
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding:5px;">
      <tr>
        <td height="3" bgcolor="#CCCCCC"></td>
      </tr>
      <tr>
        <td height="10" bgcolor="#999999"></td>
      </tr>
  <tr>
    <td align="center" bgcolor="#CCCCCC">
		<table width="98%" border="0" cellspacing="2" cellpadding="0">

<?php 	
$sql = mysql_query("SELECT codigo, titulo, texto, data FROM noticias ORDER BY codigo DESC LIMIT 0,10");
while(list($codigo, $titulo, $texto, $data) = mysql_fetch_array($sql)) {
?>
  <tr>
    <td width="20%"><a href="noticias.php?CODIGO=<?php echo $codigo; ?>"><?php echo substr($data,8,2)."/".substr($data,5,2)."/".substr($data,0,4); ?></a></td>
    <td width="80%" align="left"><a href="noticias.php?CODIGO=<?php echo $codigo; ?>"><?php echo $titulo; ?></a></td>
  </tr>
<?php
}
?>
		</table>

	</td>
    </tr>
      <tr>
        <td height="1"></td>
      </tr>
      <tr>
        <td height="5" align="left" bgcolor="#859CAD"></td>
      </tr>
</table>
<br />

<?php

if(isset($_GET['CODIGO'])) {
	$CODIGO = $_GET['CODIGO'];
	$sql = mysql_query("SELECT titulo, texto, data FROM noticias WHERE codigo = '$CODIGO'");
	list($titulo, $texto, $data) = mysql_fetch_array($sql);

?>	  
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding:5px;">
      <tr>
        <td height="3" bgcolor="#CCCCCC"></td>
      </tr>
      <tr>
        <td height="10" bgcolor="#999999"></td>
      </tr>
    <td height="76" align="left" bgcolor="#CCCCCC">
	
<table width="100%" border="0" cellspacing="2" cellpadding="0">
  <tr>
    <td><strong><?php echo $titulo; ?></strong></td>
  </tr>
  <tr>
    <td><?php echo $texto; ?></td>
  </tr>
  <tr>
    <td><?php echo substr($data,8,2)."/".substr($data,5,2)."/".substr($data,0,4); ?></td>
  </tr>
</table>
	
	
	</td>
  </tr>
      <tr>
        <td height="1"></td>
      </tr>
      <tr>
        <td height="5" align="left" bgcolor="#859CAD"></td>
      </tr>
</table>
<?php
}
?>
<br /></td>
        </tr>		
      </table>	
	
	</td>
  </tr>
</table>
<!-- frame central fim --> 	

	</td>
  </tr>
</table>
<?php include("inc/rodape.php");?>

</body>
</html>
