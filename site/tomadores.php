<?php
  
  include("../include/conect.php"); 
  include("../funcoes/util.php");

?>
<script type="text/javascript">
	function buscaGuiasIssRetido(cnpj,cmbMes,cmbAno,retorno){
		var mes = document.getElementById(cmbMes).value;
		var ano = document.getElementById(cmbAno).value;
		
		ajax({
			url:'inc/tomadores/issretido_dec.ajax.php?cnpj='+cnpj+'&cmbAno='+ano+'&cmbMes='+mes+'&a=a',
			espera: function(){
				document.getElementById(retorno).innerHTML = 'Verificando...';
			},
			sucesso: function(){
				document.getElementById(retorno).innerHTML = respostaAjax;		
			}
		});
	}	

</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>e-Nota</title>
<script src="../scripts/java_site.js" language="javascript" type="text/javascript"></script>
<script src="../scripts/padrao.js" language="javascript" type="text/javascript"></script>
<script type="text/javascript" src="../scripts/java.js"></script>
<script type="text/javascript" src="../scripts/prototype.js"></script>
<script type="text/javascript" src="../scripts/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="../scripts/lightbox.js"></script>
<link href="../css/padrao_site.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="760" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><?php include("inc/topo.php"); ?></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" valign="top" align="center">
	
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="170" rowspan="2" align="left" valign="top" background="../img/menus/menu_fundo.jpg"><?php include("inc/menu.php"); ?></td>
    <td align="right" valign="top" width="590"><img src="../img/cabecalhos/tomadores.jpg" width="590" height="100" /></td>
  </tr>
  <tr>
    <td align="center" valign="top">
    
    
<?php
 	if($_POST["txtMenu"])
		{
			include("inc/tomadores/".$_POST["txtMenu"].".php");
		}
	else {
		include("inc/tomadores/links.php");
	
	}
 ?>    
    </td>
  </tr>
</table>
	</td>
  </tr>
</table>
<?php include("inc/rodape.php"); ?>

</body>
</html>
