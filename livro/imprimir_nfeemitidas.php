<?php
include("../include/conect.php");
$livro = base64_decode($_GET['livro']);

$sql_cabecalho = mysql_query(" 
				 SELECT
  				 cadastro.razaosocial, 
				 cadastro.cnpj, 
				 cadastro.cpf,
  				 cadastro.inscrmunicipal, 
				 cadastro.logo,
				 livro.periodo,
			     livro.obs, 
				 DATE_FORMAT(livro.geracao, '%d/%m/%Y') as geracao
				 FROM cadastro			 
				 INNER JOIN livro ON livro.codcadastro = cadastro.codigo
				 WHERE livro.codigo = $livro"); 

$cabecalho = mysql_fetch_object($sql_cabecalho);

$sql_notas = mysql_query("
SELECT
  	`livro`.`codigo`, DATE_FORMAT(`notas`.`datahoraemissao`, '%d/%m/%Y') as datahoraemissao, `notas`.`numero`, `notas`.`estado`, `notas`.`tomador_cnpjcpf`, 
  	`notas`.`tomador_inscrmunicipal`,`servicos`.`codservico`, `notas`.`basecalculo`, `notas`.`valortotal`,`notas`.`valoriss`, 
  	`notas`.`issretido`
	 FROM
	 		`notas` 
	 INNER JOIN 
	 		 notas_servicos ON notas.codigo = notas_servicos.codnota
			 			 		 
	 INNER JOIN
	 		`livro_notas` ON `notas`.`codigo` = `livro_notas`.`codnota` INNER JOIN `livro` ON `livro_notas`.`codlivro` = `livro`.`codigo`
	 INNER JOIN
  	`servicos` ON `servicos`.`codigo` = `notas_servicos`.`codservico`
	 WHERE`livro`.`codigo` = $livro and livro_notas.tipo = 'E'
	 
ORDER BY `notas`.`datahoraemissao`
");	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Livro Digital - NFEletr&ocirc;nicas Emitidas</title>
<link href="../css/livrodigital.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
#divPrincipal {
	position:absolute;
	left:10px;
	top:10px;
	width:1100px;
	height:500px;
	z-index:1;
}
#divCabecalho {
	position:absolute;
	left:0px;
	top:0px;
	height:100px;
}
#divTitulo {
	position:absolute;
	left:50%;
	top:180px;
	margin-left:-200px;
	width:400px;
	height:30px;
	text-align:center;
}
#divIss {
	position:absolute;
	left:0;
	top:180px;
	width:400px;
	height:300px;
}
-->
</style>
</head>

<body>
<div id="divPrincipal">
	<div id="divCabecalho">
<table border="0" cellpadding="5" cellspacing="0">
  <tr>
    <td width="150" rowspan="4" align="center"><?php echo $livro->codcadastro;?> <?php if($cabecalho->logo==NULL) {echo 'sem imagem';} else {echo "<img src=../img/logos/$cabecalho->logo>";}; ?> </td>
	
    <td width="800" colspan="4" align="center" class="titulo1">REGISTRO E APURA&Ccedil;&Atilde;O DO ISS </td>
    <td width="150" rowspan="4" align="center"><?php if($CONF_BRASAO ==NULL) {echo 'sem imagem';} else {echo "<img src=../img/brasoes/$CONF_BRASAO>";}; ?>  &nbsp; </td>
  </tr>
  <tr>
    <td width="150" class="field1">Contribuinte:</td>
    <td colspan="3" class="field1"><?php echo $cabecalho->razaosocial; ?>&nbsp;</td>
    </tr>
  <tr>
    <td class="field1">CNPJ/CPF:</td>
    <td width="250"><?php echo $cabecalho->cnpj; ?>&nbsp;</td>
    <td width="150" class="field1">Per&iacute;odo:</td>
    <td width="250">
			<?php
			$periodof = substr($cabecalho->periodo,5,2); 
			$periodof = $periodof."/".substr($cabecalho->periodo,0,4);
			echo $periodof; ?>&nbsp;
	</td>
    </tr>
  <tr>
    <td class="field1">Inscr. Municipal: </td>
    <td colspan="3" class="field1"><?php echo $cabecalho->inscrmunicipal; ?> &nbsp;</td>
    </tr>
  <tr>
    <td class="field1">Observa&ccedil;&otilde;es:</td>
    <td colspan="5"><?php echo $cabecalho->obs; ?>&nbsp;</td>
    </tr>
  <tr>
    <td class="field1">Data da Gera&ccedil;&atilde;o: </td>
    <td colspan="5"><?php echo $cabecalho->geracao; ?>&nbsp;</td>
    </tr>
</table>
	
	
	
	</div>
	<div id="divIss">
<table width="1100" border="0" cellpadding="5" cellspacing="0">
  <tr>
    <td colspan="12" align="center" class="titulo1">NOTAS FISCAIS ELETR&Ocirc;NICAS EMITIDAS </td>
    </tr>
  <tr>
    <td width="40%" colspan="3" align="center" class="field2">NFEletr&ocirc;nica</td>
    <td colspan="2" align="center" class="field2">Tomador</td>
    <td colspan="3" align="center" class="field2">Servi&ccedil;os</td>
    <td width="35%"colspan="2" align="center" class="field2">Imposto Pr&oacute;prio </td>
    <td width="40%" colspan="2" align="center" class="field2">Imposto Retido </td>
  </tr>
  <tr align="center">
    <td>Data</td>
    <td>N&uacute;mero</td>
    <td>Estado</td>
    <td>CNPJ/CPF</td>
    <td>Inscr. Municipal </td>
    <td>C&oacute;d. Servi&ccedil;o </td>
    <td>Valor Servi&ccedil;os </td>
    <td>Valor L&iacute;quido </td>
    <td>Base C&aacute;lculo </td>
    <td>Valor ISS </td>
    <td>Base C&aacute;lculo </td>
    <td width="25%">Valor ISS </td>
  </tr>
<?php while($notas = mysql_fetch_object($sql_notas)) { ?>
  <tr>
    <td class="field3" align="center"><?php echo $notas->datahoraemissao; ?> </td>
    <td class="field3" align="center"><?php echo $notas->numero; ?></td>
    <td class="field3" align="center"><?php if($notas->estado == N) {echo 'Normal';} 
								elseif($notas->estado=='E') {echo 'Escriturada';}
								elseif($notas->estado == 'B' ){echo 'Boleto';} 
									elseif($notas->estado=='C'){echo 'Cancelada';} 
										else{echo 'Erro';} ;?></td>
    <td class="field3" align="center"><?php echo $notas->tomador_cnpjcpf; ?></td>
    <td class="field3" align="center"><?php echo $notas->tomador_inscrmunicipal; ?></td>
    <td class="field3" align="center"><?php echo $notas->codservico ;?></td>
    <td class="field3" align="center"><?php echo $notas->basecalculo; ?></td>
    <td class="field3" align="center"><?php echo $notas->valortotal; ?> </td>
    <td class="field3" align="center"><?php echo $notas->basecalculo; ?></td>
    <td class="field3" align="center"><?php echo $notas->valoriss; ?></td>
    <td class="field3" align="center"><?php echo $notas->basecalculo; ?></td>
    <td class="field3" align="center"><?php echo $notas->issretido; ?></td>
  </tr>
<?php } // fecha while 


$sql_totais = mysql_query("
SELECT
  `livro`.`codigo`, 
  Sum(`notas`.`basecalculo`) as basecalculo,
  Sum(`notas`.`valoriss`) as valoriss,
  Sum(`notas`.`issretido`) as issretido
FROM
  `notas` INNER JOIN
  `livro_notas` ON `notas`.`codigo` = `livro_notas`.`codnota` INNER JOIN
  `livro` ON `livro_notas`.`codlivro` = `livro`.`codigo`
WHERE
  `livro`.`codigo` = '$livro' AND
  `livro_notas`.`tipo` = 'E'
			  ");
			 	
		 
$totais= mysql_fetch_object($sql_totais);


?> 
 
  
  <tr>
    <td colspan="8" align="right" class="field4">Total Geral </td>
    <td class="field4" align="center"><?php echo $totais->basecalculo; ?></td>
    <td class="field4" align="center"><?php echo $totais->valoriss; ?></td>
    <td class="field4" align="center"><?php echo $totais->basecalculo; ?></td>
    <td class="field4" align="center"><?php echo $totais->issretido; ?></td>
  </tr>
</table>
	
  </div>
	

</div>

</body>
</html>
