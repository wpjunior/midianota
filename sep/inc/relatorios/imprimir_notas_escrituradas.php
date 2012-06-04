<?php
require_once("../conect.php");
require_once("../../funcoes/util.php");

$datainicial 	= dataMysql($_POST['txtDataIni']);
$datafinal 		= dataMysql($_POST['txtDataFim']);
$cnpjprestador 	= $_POST['txtCnpjPrestador'];
$nossonumero 	= $_POST['txtNossonumero'];

$sql_where = array();

//where para notas escrituradas
$sql_where[] = "n.estado = 'E'";

if ($datainicial) {
	$sql_where[] = "DATE(n.datahoraemissao) >= '$datainicial'";
}
if ($datafinal) {
	$sql_where[] = "DATE(n.datahoraemissao) <= '$datafinal'";
}
if ($cnpjprestador) {
	$sql_where[] = "n.tomador_cnpjcpf = '$cnpjprestador'";
}
if ($nossonumero) {
	$sql_where[] = "p.nossonumero = '$nossonumero'";
}

$sql_where = implode(' AND ', $sql_where);

$sql = mysql_query("
	SELECT 
		n.codigo, 
		n.numero, 
		DATE_FORMAT(n.datahoraemissao, '%d/%m/%Y') as 'datahoraemissao',
		n.tomador_nome, 
		n.tomador_cnpjcpf,
		n.valortotal, 
		n.valoriss,
		p.nossonumero
	FROM 
		notas as n
	INNER JOIN guias_declaracoes as g ON
		n.codigo = g.codrelacionamento
	INNER JOIN guia_pagamento as p ON
		g.codguia = p.codigo
	WHERE 
		{$sql_where}
	ORDER BY
		n.codigo DESC
");

if (mysql_num_rows($sql) <= 0) {
	?><strong><center>Nenhum resultado encontrado.</center></strong><?php
	exit();
}
?>
<html>
<head>
<title>Relat&oacute;rio de Notas escrituradas</title>
<style type="text/css">
@media print {
	#DivImprimir {
		display:none;
	}
}
@media all {
	table.relatorio {
		font-size:10px; 
		font-family:Verdana, Arial, Helvetica, sans-serif; border:thick;
		border-collapse:collapse;
	}
	table.relatorio tr td {
		border:1px solid #000000;
	}
}

</style>
</head>
<body>
<div id="DivImprimir"><input type="button" onClick="print();" value="Imprimir" /></div>
<span style="font:Verdana, Arial, Helvetica, sans-serif; font-size:20px"><b>Relat&oacute;rio de Notas escrituradas</b></span>
<table>
	<?php if($_POST["txtNossonumero"]){?>
	<tr>
		<td><strong>Nosso N&uacute;mero:</strong></td>
		<td><?php echo $_POST["txtNossonumero"]; ?></td>
	</tr>
	<?php } if($_POST["txtDataIni"]){ ?>
	<tr>
		<td><strong>A partir da data:</strong></td>
		<td><?php echo $_POST["txtDataIni"]; ?></td>
	</tr>
	<?php } if($_POST["txtDataFim"]){ ?>
	<tr>
		<td><strong>Até a data:</strong></td>
		<td><?php echo $_POST["txtDataFim"]; ?></td>
	</tr>
	<?php } if($_POST["txtCnpjPrestador"]) {?>
	<tr>
		<td><strong>CNPJ/CPF:</strong></td>
		<td><?php echo $_POST["txtCnpjPrestador"]; ?></td>
	</tr>
	<?php }//fim if mostrar os dados usados no filtro ?>
	<tr>
		<td colspan="2"><b><?php echo mysql_num_rows($sql); ?> notas escrituradas</b></td>
	</tr>
</table>
<table width="100%" class="relatorio">
	<tr>
		<td align="center"><b>N&ordm;</b></td>
		<td align="center"><b>Data de emiss&atilde;o</b></td>
		<td align="center"><b>CNPJ/CPF</b></td>
		<td align="center"><b>Tomador</b></td>
		<td align="center"><b>Valor</b></td>
		<td align="center"><b>Iss</b></td>
		<td align="center"><b>Nosso N&uacute;mero</b></td>
	</tr>
	<?php
	while ($dados = mysql_fetch_array($sql)){
	?>
	<tr>
		<td align="center"><?php echo $dados['numero']; ?></td>
		<td align="center"><?php echo $dados['datahoraemissao']; ?></td>
		<td align="center"><?php echo $dados['tomador_cnpjcpf']; ?></td>
		<td align="center"><?php echo $dados['tomador_nome']; ?></td>
		<td align="center"><?php echo DecToMoeda($dados['valortotal']); ?></td>
		<td align="center"><?php echo DecToMoeda($dados['valoriss']); ?></td>
		<td align="center"><?php echo $dados['nossonumero']; ?></td>
	</tr>
	<?php
	}//fim while
	?>
</table>
</body>
