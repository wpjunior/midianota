<?php
$campo = $_GET['campo'];

$valor = $_GET['valor'];
$valido='Emissor não cadastrado!';
include("../../include/conect.php");

$sql=mysql_query("SELECT cnpjcpf ,razaosocial FROM emissores");

while(list($CNPJCPF,$RazaoSocial)=mysql_fetch_array($sql))
{
  
  if($CNPJCPF == $valor)
  {
    $valido = $RazaoSocial;
  }  
} 
  
echo $valido; 

header("Content-Type: text/html; charset=UTF-8",true);

?>
