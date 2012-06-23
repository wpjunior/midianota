<fieldset><legend>Resultado</legend>
<?php
require_once("../sep/inc/conect.php");
require_once("../sep/inc/nocache.php");
require_once("../sep/funcoes/util.php");

$cnpj = $_GET['txtCnpjPrestador'];
$mes_ini = $_GET['cmbMes'] < 10? '0'.$_GET['cmbMes'] : $_GET['cmbMes'];
$ano_ini = $_GET['cmbAno'];
$mes_fim = $_GET['cmbMesFim'] < 10? '0'.$_GET['cmbMesFim'] : $_GET['cmbMesFim'];
$ano_fim = $_GET['cmbAnoFim'];

$sql_where = array();

if ($cnpj) {
	$sql_where[] = "(c.cpf = '$cnpj' OR c.cnpj = '$cnpj')";
}
if ($mes_ini && $ano_ini) {
	$sql_where[] = "l.periodo >= '$ano_ini-$mes_ini'";
}
if ($mes_fim && $ano_fim) {
	$sql_where[] = "l.periodo <= '$ano_fim-$mes_fim'";
}

if ($sql_where) {
	$WHERE = 'WHERE ' . implode(' AND ', $sql_where);
} else {
	$WHERE = '';
}

$query = ("
	SELECT
		l.codigo,
		c.cnpj,
		c.cpf,
		l.periodo,
		l.vencimento,
		l.geracao,
		l.basecalculo,
		l.reducaobc,
		l.valoriss,
		l.valorissretido,
		l.valorisstotal
	FROM
		livro as l
	INNER JOIN cadastro as c ON
		l.codcadastro = c.codigo
	$WHERE
	ORDER BY
		l.geracao DESC
");

$sql = Paginacao($query,'frmLivro','dvResultdoLivro');

if (mysql_num_rows($sql) == 0) {
	?><strong><center>Nenhum resultado encontrado!</center></strong><?php
} else {
	?>
	<table width="100%" border="0" cellspacing="2" cellpadding="2">
		<tr>
			<td bgcolor="#999999" align="center">Código</td>
			<td bgcolor="#999999" align="center">Período</td>
			<td bgcolor="#999999" align="center">CNPJ prestador</td>
			<td bgcolor="#999999" align="center">Base de cálculo</td>
			<td bgcolor="#999999" align="center">ISS</td>
			<td bgcolor="#999999" align="center">ISS retido</td>
			<td bgcolor="#999999" align="center">ISS total</td>
			<td bgcolor="#999999" align="center"></td>
		</tr>
		<?php
		while ($dados = mysql_fetch_array($sql)) {

		$dados['cnpj'] .= $dados['cpf'];
		?>
		<tr>
			<td bgcolor="#FFFFFF" align="right"><?php echo $dados['codigo']; ?></td>
			<td bgcolor="#FFFFFF" align="center"><?php echo implode('/', array_reverse(explode('-', $dados['periodo']))); ?></td>
			<td bgcolor="#FFFFFF" align="center"><?php echo $dados['cnpj']; ?></td>
			<td bgcolor="#FFFFFF" align="right"><?php echo DecToMoeda($dados['basecalculo']); ?></td>
			<td bgcolor="#FFFFFF" align="right"><?php echo DecToMoeda($dados['valoriss']); ?></td>
			<td bgcolor="#FFFFFF" align="right"><?php echo DecToMoeda($dados['valorissretido']); ?></td>
			<td bgcolor="#FFFFFF" align="right"><?php echo DecToMoeda($dados['valorisstotal']); ?></td>
			<td bgcolor="#FFFFFF" align="center">				
                <input type="button" class="botao" id="btnImprimirr" name="btnImprimir" value="Imprimir" onclick="DivMenuAbas('<?php echo base64_encode($dados['codigo']); ?>');"/>
              
			</td>
		</tr>
		<?php
		}//fim while
		?>
	</table>
<?php
}
?>
</fieldset>
