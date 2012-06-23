<?php 

include("../../inc/conect.php");
include("../../funcoes/util.php");

$sql_categ = mysql_query("SELECT
						  servicos.codcategoria, servicos_categorias.nome, COUNT(servicos_categorias.nome)
						 FROM
						  servicos_categorias 
						 INNER JOIN
						  servicos
						 ON servicos.codcategoria = servicos_categorias.codigo
						 GROUP BY servicos.codcategoria"); 
$cont=0;
while(list($nome,$qtd) = mysql_fetch_array($sql_categ)){

echo"$nome: ]  $qtd";
								
	$cont=$cont+$qtd;							}

?>
