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
	require_once("../../../funcoes/util.php");
	//Pega o codigo passado do arquivo regra_lista.ajax.php
	$codigo = $_GET['hdcod'];
	
	$sql_multa = mysql_query("SELECT codigo, dias, multa, juros_mora, estado FROM des_multas_atraso WHERE codigo = '$codigo'");
	list($codigo,$dias,$multa,$juros,$estado) = mysql_fetch_array($sql_multa);
?>
<input name="hdCodMultaAtualizar" value="<?php echo $codigo;?>" type="hidden">
<table width="100%">
	<tr bgcolor="#FFFFFF">
		<td width="7%" align="center"><input name="txtDiasEdit" id="txtDiasEdit" type="text" class="texto" value="<?php echo $dias;?>" size="4" maxlength="4" style="text-align:center" ></td>
		<td width="32%" align="center">
			<input name="txtMultaEdit" id="txtMultaEdit" type="text" class="texto" value="<?php echo $multa;?>" size="16" maxlength="10" style="text-align:center" 
			onkeyup="MaskMoeda(this)" >
		</td>
		<td width="31%" align="center">
			<input name="txtJurosEdit" id="txtJurosEdit" type="text" class="texto" value="<?php echo $juros;?>" size="16" maxlength="4" style="text-align:center" onkeyup="MaskPercent(this)" 
			onblur="limitePct('txtJurosEdit')" >
		</td>
		<td width="16%" align="center">
			<select name="cmbEstadoEdit" id="cmbEstadoEdit" class="combo">
				<option value="A"<?php if($estado == "A"){ echo "selected=\"selected\"";}?> >Ativo</option>
				<option value="I"<?php if($estado == "I"){ echo "selected=\"selected\"";}?>>Inativo</option>
			</select>
		</td>
		<td width="14%" bgcolor="#CCCCCC">
			<input name="btEditar" type="submit" value="Salvar" class="botao" 
			onclick="return (ValidaFormulario('txtDiasEdit|txtMultaEdit|txtJurosEdit|cmbEstadoEdit','Os campos não podem estar vazios!') && (limitePct('txtJurosEdit')))">
		</td>
	</tr>
</table>