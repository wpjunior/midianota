<?php

$cnpj = $_GET['valor'];
$valido='Emissor não cadastrado';

include ("../../include/nocache.php");
include("../../include/conect.php");

$sql_cnpj = mysql_query("
	SELECT codigo, razaosocial FROM cadastro WHERE cnpj='$cnpj' OR cpf='$cnpj'
");
if (mysql_num_rows($sql_cnpj))
	list($codigo,$valido)=mysql_fetch_array($sql_cnpj);
  
echo $valido; 


?>
