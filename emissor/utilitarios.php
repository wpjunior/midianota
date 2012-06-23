<?php 
session_name("emissor");
session_start();
if(!(isset($_SESSION["empresa"])))
{   
	echo "
		<script>
			alert('Acesso Negado!');
			window.location='login.php';
		</script>
	";
}else{?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>e-Nota</title><script src="../scripts/padrao.js" language="javascript" type="text/javascript"></script>
<link href="../css/padrao_emissor.css" rel="stylesheet" type="text/css" />
</head>

<body>
<center>
<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><?php include("../include/topo.php"); ?></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" height="400" valign="top" align="center">
	
<!-- frame central inicio --> 	
<table border="0" cellspacing="0" cellpadding="0" height="100%">
  <tr>
    <td width="170" align="left" background="../img/menus/menu_fundo.jpg" valign="top"><?php include("inc/menu.php"); ?></td>
    <td width="530" bgcolor="#FFFFFF" valign="top">
    <img src="../img/cabecalhos/utilitarios.jpg" />

<!-- frame central lateral direita inicio -->	
<?php include("inc/utilitarios_principal.php"); ?></td>
<!-- frame central lateral direita fim -->	
	</td>
  </tr>
</table>


<!-- frame central fim --> 	
	</td>
  </tr>
  <tr>
    <td><?php include("inc/rodape.php"); ?></td>
  </tr>
</table>
</center>

</body>
</html>
<?php }?>
