<?php
/*
COPYRIGHT 2008 - 2010 DO PORTAL PUBLICO INFORMATICA LTDA

Este arquivo e parte do programa E-ISS / SEP-ISS

O E-ISS / SEP-ISS e um software livre; voce pode redistribui-lo e/ou modifica-lo
dentro dos termos da Licenca Publica Geral GNU como publicada pela Fundacao do
Software Livre - FSF; na versao 2 da Licenca

Este sistema e distribuido na esperanca de ser util, mas SEM NENHUMA GARANTIA,
sem uma garantia implicita de ADEQUACAO a qualquer MERCADO ou APLICACAO EM PARTICULAR
Veja a Licenca Publica Geral GNU/GPL em portugues para maiores detalhes

Voce deve ter recebido uma copia da Licenca Publica Geral GNU, sob o titulo LICENCA.txt,
junto com este sistema, se nao, acesse o Portal do Software Publico Brasileiro no endereco
www.softwarepublico.gov.br, ou escreva para a Fundacao do Software Livre Inc., 51 Franklin St,
Fith Floor, Boston, MA 02110-1301, USA
*/
?>
<?php
require_once("../../conect.php");

//recebe as variaveis vindas por get
$nomePOST = $_POST['txtNome'];
$cnpjPOST = $_POST['txtCNPJ'];
$estadoPOST = $_POST['cmbEstado'];
$municipioPOST = $_POST['txtCidade'];
$ufPOST = $_POST['txtUF'];
$adminPOST = $_POST['cmbAdmin'];
$nivelPOST = $_POST['cmbNivel'];

switch($adminPOST){
	case 'D': $admpublica = "Direta";break;
	case 'I': $admpublica = "Indireta";break;
}//fim switch admpublica
switch($nivelPOST){
	case 'M': $nivel = "Municipal";break;
	case 'E': $nivel = "Estadual";break;
	case 'F': $nivel = "Federal";break;
}//fim switch nivel
switch($estadoPOST){
	case "NL": $estado = "Não Liberado"; break;
	case "A" : $estado = "Ativo";   break;
	case "I" : $estado = "Inativo";    break;
}//fim switch estado

//faz um where de acordo com oque foi preenchido no from
$sql_where=" ";//comeca a var do where como um espaço
if($cnpjPOST){
	$sql_where.=" AND orgaospublicos.cnpj='$cnpjPOST'";
}//fim if cnpj
if($estadoPOST){
	$sql_where.=" AND orgaospublicos.estado='$estadoPOST'";
}//fim if estado
if($municipioPOST){
	$sql_where.=" AND orgaospublicos.municipio LIKE '$municipioPOST'";//like porque pode ser tanto maisculo quanto minusculo
}//fim if estado
if($ufPOST){
	$sql_where.=" AND orgaospublicos.uf LIKE '$ufPOST'";//like porque pode ser tanto maisculo quanto minusculo
}//fim if estado
if($adminPOST){
	$sql_where.=" AND orgaospublicos.admpublica='$adminPOST'";
}//fim if estado
if($nivelPOST){
	$sql_where.=" AND orgaospublicos.nivel='$nivelPOST'";
}//fim if estado

$sql = mysql_query("
				SELECT 
					nome, 
					razaosocial, 
					cnpj, 
					municipio, 
					uf, 
					admpublica,
					nivel,
					estado
				FROM 
					orgaospublicos 
				WHERE
					nome LIKE '%$nomePOST%'
					$sql_where
				ORDER BY 
					nome
				");

?>
<script src="../../scripts/padrao.js" type="text/javascript"></script><title>Relatorios - Órgãos Públicos</title>
<div id="DivImprimir"><input type="button" onClick="EscondeDiv('DivImprimir'); print();" value="Imprimir" /></div>
<p style="font:Verdana, Arial, Helvetica, sans-serif; font-size:20px"><b>Relatório de Órgãos Públicos</b></p>
<table>
	<?php if($nomePOST){?>
	<tr>
		<td><b>Nome:</b></td>
		<td><?php echo $nomePOST; ?></td>
	</tr>
	<?php } if($cnpjPOST){ ?>
	<tr>
		<td><b>CNPJ:</b></td>
		<td><?php echo $cnpjPOST; ?></td>
	</tr>
	<?php } if($estadoPOST){ ?>
	<tr>
		<td><b>Estado:</b></td>
		<td><?php echo $estado; ?></td>
	</tr>
	<?php } if($municipioPOST){ ?>
	<tr>
		<td><b>Municipio:</b></td>
		<td><?php echo $municipioPOST; ?></td>
	</tr>
	<?php } if($ufPOST){ ?>
	<tr>
		<td><b>UF:</b></td>
		<td><?php echo $ufPOST; ?></td>
	</tr>
	<?php } if($adminPOST){ ?>
	<tr>
		<td><b>Administração:</b></td>
		<td><?php echo $admpublica; ?></td>
	</tr>
	<?php } if($nivelPOST){ ?>
	<tr>
		<td><b>Nivel:</b></td>
		<td><?php echo $nivel; ?></td>
	</tr>
	<?php }?>
</table>
<table>
	<tr>
		<td colspan="2"><strong><?php echo mysql_num_rows($sql); ?> Órgãos Públicos registrados</strong></td>
	</tr>
</table>
<table width="700" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif">
	<tr>
		<td align="center" width="240"><b>Nome</b></td>
		<td align="center" width="130"><b>CNPJ</b></td>
		<td align="center" width="130"><b>Município</b></td>
		<td align="center" width="30"><b>UF</b></td>
		<td align="center" width="100"><b>Administração</b></td>
		<td align="center" width="60"><b>Nível</b></td>
		<td align="center"><b>Situação</b></td>	
	</tr>
	<tr>
		<td colspan="7"><hr size="1px" color="#000000"/></td>
	</tr>
	<?php
	while(list($nome, $razao, $cnpj, $municipio, $uf, $admpublica, $nivel, $estado)=mysql_fetch_array($sql)){
		switch($admpublica){
			case 'D': $admpublica = "Direta";break;
			case 'I': $admpublica = "Indireta";break;
		}//fim switch admpublica
		switch($nivel){
			case 'M': $nivel = "Municipal";break;
			case 'E': $nivel = "Estadual";break;
			case 'F': $nivel = "Federal";break;
		}//fim switch nivel
		switch($estado){
			case "NL": $estado = "Não Liberado"; break;
			case "A" : $estado = "Ativo";   break;
			case "I" : $estado = "Inativo";    break;
		}//fim switch estado
	?>
	<tr>
		<td align="center" width="240"><?php echo $nome;?></td>
		<td align="center" width="130"><?php echo $cnpj;?></td>
		<td align="center" width="130"><?php echo $municipio;?></td>
		<td align="center" width="30"><?php echo $uf;?></td>
		<td align="center" width="100"><?php echo $admpublica; ?></td>
		<td align="center" width="60"><?php echo $nivel; ?></td>
		<td align="center"><?php echo $estado;?></td>
	</tr>
	<?php
	}//fim while list
	?>
</table>