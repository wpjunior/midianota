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
<fieldset><legend>Resultado</legend>
<?php
require_once("../conect.php");
require_once("../nocache.php");
require_once("../../funcoes/util.php");

$datainicial 	= dataMysql($_GET['txtDataIni']);
$datafinal 		= dataMysql($_GET['txtDataFim']);
$cnpjprestador 	= $_GET['txtCnpjPrestador'];
$nossonumero 	= $_GET['txtNossonumero'];

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

$query = ("
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
		$sql_where
	ORDER BY
		n.codigo DESC
");
$sql = Paginacao($query,'frmRelatorio','dvResultdoRelatorio');

if (mysql_num_rows($sql) < 1) {
	?><strong><center>Nenhum resultado encontrado.</center></strong><?php
} else {
	?>
		<table width="100%" border="0" cellspacing="2" cellpadding="2">
			<tr>
				<td bgcolor="#999999" align="center">N&ordm;</td>
				<td bgcolor="#999999" align="center">Data de emiss&atilde;o</td>
				<td bgcolor="#999999" align="center">CNPJ/CPF</td>
				<td bgcolor="#999999" align="center">Tomador</td>
				<td bgcolor="#999999" align="center">Valor</td>
				<td bgcolor="#999999" align="center">Iss</td>
				<td bgcolor="#999999" align="center">Nosso N&uacute;mero</td>
			</tr>
			<?php
			while ($dados = mysql_fetch_array($sql)){
			?>
			<tr>
				<td bgcolor="#FFFFFF" align="right"><?php echo $dados['numero']; ?></td>
				<td bgcolor="#FFFFFF" align="center"><?php echo $dados['datahoraemissao']; ?></td>
				<td bgcolor="#FFFFFF" align="center"><?php echo $dados['tomador_cnpjcpf']; ?></td>
				<td bgcolor="#FFFFFF" align="center"><?php echo $dados['tomador_nome']; ?></td>
				<td bgcolor="#FFFFFF" align="right"><?php echo DecToMoeda($dados['valortotal']); ?></td>
				<td bgcolor="#FFFFFF" align="right"><?php echo DecToMoeda($dados['valoriss']); ?></td>
				<td bgcolor="#FFFFFF" align="center"><?php echo $dados['nossonumero']; ?></td>
			</tr>
			<?php
			}//fim while
			?>
		</table>
	<?php
}
?>
</fieldset>