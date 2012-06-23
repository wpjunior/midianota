<?php
	include '../../include/nocache.php';
	
	include("../../include/conect.php");
	echo "<select name=\"txtInsMunicipioEmpresa\" class=\"combo\">";
	$sql = mysql_query("SELECT nome FROM municipios WHERE uf='".$_GET["UF"]."' ORDER BY nome");
	while(list($municipio) = mysql_fetch_array($sql)) {
		echo "<option value=\"$municipio\">$municipio</option>";
	}
	echo "</select>";
?>