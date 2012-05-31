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

//testa se tem algum filtro do where
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
	?><strong><center>Nenhum resultado encontrado.</center></strong><?php
} else {
	?>
	<table width="100%" border="0" cellspacing="2" cellpadding="2">
		<tr>
			<td bgcolor="#999999" align="center">C&oacute;digo</td>
			<td bgcolor="#999999" align="center">Per&iacute;odo</td>
			<td bgcolor="#999999" align="center">CNPJ prestador</td>
			<td bgcolor="#999999" align="center">Base de calculo</td>
			<td bgcolor="#999999" align="center">Iss</td>
			<td bgcolor="#999999" align="center">Iss retido</td>
			<td bgcolor="#999999" align="center">Iss total</td>
			<td bgcolor="#999999" align="center">A&ccedil;&atilde;o</td>
		</tr>
		<?php
		while ($dados = mysql_fetch_array($sql)) {
		//junta o cnpj com o cpf para ficar no mesmo campo
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
}//fim else se tem resultado
?>
</fieldset>
