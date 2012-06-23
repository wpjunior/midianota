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
<table width="760" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><?php include("inc/topo.php"); ?></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" height="400" valign="top" align="center">
	
<!-- frame central inicio --> 	
<table border="0" cellspacing="0" cellpadding="0" height="100%">
  <tr>
    <td width="170" align="left" background="../img/menus/menu_fundo.jpg" valign="top"><?php include("inc/menu.php"); ?></td>
    <td width="590" valign="top">

      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="530"><img src="../img/cabecalhos/legislacao.jpg" width="590" height="100" /></td>
        </tr>
        <tr>
          <td align="center"><br />
		  
		  
<table width="99%" border="0" cellspacing="0" cellpadding="0" style="padding:5px;">
      <tr>
        <td height="3" bgcolor="#CCCCCC"></td>
      </tr>
      <tr>
        <td height="10" bgcolor="#999999"></td>
      </tr>
  <tr>
    <td height="20" align="left" bgcolor="#CCCCCC">
	
Você pode visualizar os manuais fazendo o download dos arquivos em formato PDF.
	
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

$sql = mysql_query("
	SELECT 
		titulo,
		texto, 
		data, 
		arquivo 
	FROM 
		legislacao 
	WHERE 
		tipo = 'N' OR
		tipo = 'T'
	ORDER BY 
		codigo
");
?>
<table width="99%" border="0" cellspacing="0" cellpadding="0" style="padding:5px;">
      <tr>
        <td height="3" bgcolor="#CCCCCC"></td>
      </tr>
      <tr>
        <td height="10" bgcolor="#999999"></td>
      </tr>
  <tr>
    <td align="left" valign="top" bgcolor="#CCCCCC" >
<?php
if(mysql_num_rows($sql)>0){
	while(list($titulo, $texto, $data, $arquivo) = mysql_fetch_array($sql)) {
?>	  
	
<table width="95%" border="0" cellspacing="2" cellpadding="0">
  <tr>
    <td colspan="2"><strong><?php echo $titulo; ?></strong></td>
  </tr>
  <tr>
    <td colspan="2"><?php echo $texto; ?></td>
  </tr>
  <tr>
    <td>Data: <?php echo substr($data,8,2)."/".substr($data,5,2)."/".substr($data,0,4); ?></td>
    <td align="right"><a href="../legislacao/<?php echo $BANCO."/".$arquivo; ?>" target="_blank"><img src="../img/pdf.jpg" title="Download do pdf" /></a></td>
  </tr>
</table>
<?php
	}
}else{
	echo "
		<table width=\"95%\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\">
			<tr>
				<td>Não há nenhuma lei cadastrada</td>
			</tr>
		</table>
		";
}
?>	
	</td>
  </tr>
      <tr>
        <td height="1"></td>
      </tr>
      <tr>
        <td height="5" align="left" bgcolor="#859CAD"></td>
      </tr>
</table>


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
<?php 
include("inc/rodape.php");
?>

</body>
</html>
