<?php
include("../include/conect.php");
$livro = base64_decode($_GET['livro']);

// busca livro
$sql_livro = mysql_query("
			SELECT 
				cad.nome,
				cad.inscrmunicipal, 
				cad.logo,
				if(cad.cnpj is null, cad.cpf, cad.cnpj) as cnpj, 
				livro.codcadastro,
				livro.periodo,
				DATE_FORMAT(livro.vencimento,'%d/%m/%Y') as vencimento,
				DATE_FORMAT(livro.geracao,'%d/%m/%Y') as geracao,
				livro.basecalculo,
				livro.reducaobc,
				livro.valoriss, 
				livro.valorissretido,
				livro.valorisstotal,
				livro.obs 				
				FROM livro
				INNER JOIN cadastro as cad ON cad.codigo=livro.codcadastro				
				WHERE livro.codigo = $livro");

$livro = mysql_fetch_object($sql_livro);
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Livro Digital - Controle de Arecadação</title>
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
	left:50%;
	top:250px;
	margin-left:-200px;
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
    <td width="150" rowspan="4" align="center"><?php if($livro->logo == NULL) { echo 'sem imagem'; } else { echo "<img src=../img/logos/$livro->logo >"; }; ?></td>
    <td width="800" colspan="4" align="center" class="titulo1">REGISTRO E APURAÇÃO DO ISS </td>
    <td width="150" rowspan="4" align="center"><?php if($CONF_BRASAO == NULL) {echo 'sem imagem';} else { echo "<img src=../img/brasoes/$CONF_BRASAO >";};?></td>
  </tr>
  <tr>
    <td width="150" class="field1">Contribuinte:</td>
    <td colspan="3" class="field1"><?php echo $livro->nome; ?>&nbsp;</td>
    </tr>
  <tr>
    <td class="field1">CNPJ/CPF:</td>
    <td width="250"><?php echo $livro->cnpj; ?>&nbsp;</td>
    <td width="150" class="field1">Período:</td>
    <td width="250"><?php 
						  $periodof = substr($livro->periodo,5,2);
						  $periodof = $periodof."/".substr($livro->periodo,0,4);
						  echo $periodof; ?>&nbsp;</td>
    </tr>
  <tr>
    <td class="field1">Inscr. Municipal: </td>
    <td colspan="3" ><?php echo $livro->inscrmunicipal; ?>&nbsp;</td>
    </tr>
  <tr>
    <td class="field1">Observações:</td>
    <td colspan="5"><?php echo $livro->obs; ?>&nbsp;</td>
    </tr>
  <tr>
    <td class="field1">Data da Geração: </td>
    <td colspan="5"><?php echo $livro->geracao; ?>&nbsp;</td>
    </tr>
</table>
	
	
	
	</div>
	<div class="titulo1" id="divTitulo">CONTROLE DE ARRECADAÇÃO DE ISS </div>
	<div id="divIss">
<table width="400" border="0" cellpadding="5" cellspacing="0">
  <tr>
    <td colspan="2" align="center" class="titulo1">ISSQN</td>
    </tr>
  <tr>
    <td colspan="2" align="center" class="field2">Imposto próprio a pagar </td>
    </tr>
  <tr>
    <td width="50%">Vencimento</td>
    <td width="50%"><?php echo $livro->vencimento; ?>&nbsp;</td>
  </tr>
  <tr>
    <td>Base de Cálculo </td>
    <td><?php echo $livro->basecalculo; ?>&nbsp;</td>
  </tr>
  <tr>
    <td>Redução da Base de Cálculo </td>
    <td><?php // echo  $livro->basecalculo; ?>&nbsp;</td>
  </tr>
  <tr>
    <td>Valor do ISS </td>
    <td><?php echo $livro->valoriss; ?>&nbsp;</td>
  </tr>
  <tr>
    <td>Valor do ISS Retido </td>
    <td><?php echo $livro->valorissretido; ?>&nbsp;</td>
  </tr>
  <tr>
    <td>Total</td>
    <td><?php echo $livro->valorisstotal; ?>&nbsp;</td>
  </tr>
</table>
	
	</div>
	

</div>

</body>

</html>

