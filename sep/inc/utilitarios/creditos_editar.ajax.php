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
	require_once("../conect.php");
	require_once("../../funcoes/util.php");
	$codigo = $_GET['hdcod'];
	
	$sql_cred = mysql_query("SELECT codigo, credito, tipopessoa, issretido, valor, estado FROM nfe_creditos WHERE codigo = '$codigo'");
	list($codigo,$credito,$tipopessoa,$issretido,$valor,$estado) = mysql_fetch_array($sql_cred);
?>
<input type="hidden" name="hdCodCredito" value="<?php echo $codigo;?>">
<table width="100%">
	<tr bgcolor="#FFFFFF">
		<td width="3%" bgcolor="#CCCCCC">&nbsp;</td>
		<td width="13%" align="center">
			<select name="cmbTipoPessoaEdit" class="combo">
				<option value="PF"<?php if($tipopessoa == "PF"){ echo "selected=selected";}?>>Pessoa Fisica</option>
				<option value="PJ"<?php if($tipopessoa == "PJ"){ echo "selected=selected";}?>>Pessoa Jurídica</option>
				<option value="PFPJ"<?php if($tipopessoa == "PFPJ"){ echo "selected=selected";}?>>Ambas</option>
			</select>
		</td>
		<td width="10%" align="center">
			<select name="cmbISSRetidoEdit">
				<option value="S"<?php if($issretido == "S"){ echo "selected=selected";}?>>Sim</option>
				<option value="N"<?php if($issretido == "N"){ echo "selected=selected";}?>>Não</option>
			</select>
		</td>
		<td width="13%" align="center">
		<input name="txtValorEdit" id="txtValorEdit" type="text" class="texto" value="<?php echo DecToMoeda($valor);?>" size="10" style="text-align:center" onkeyup="MaskMoeda(this)"></td>
		<td width="39%" align="center">
		<input name="txtCreditoEdit" id="txtCreditoEdit" type="text" class="texto" value="<?php echo $credito;?>" size="10" style="text-align:center" onkeyup="MaskPercent(this)"></td>
		<td width="13%" align="center">
			<select name="cmbEstadoEdit">
				<option value="A"<?php if($estado == "A"){ echo "selected=selected";}?>>Ativo</option>
				<option value="I"<?php if($estado == "I"){ echo "selected=selected";}?>>Inativo</option>
			</select>
		</td>
		<td width="9%">
			<input name="btSalvar" value="Salvar" class="botao" type="submit" onClick="return ValidaFormulario('txtValorEdit|txtCreditoEdit','Os campos devem estar preenchidos')" /> 
		</td>
	</tr>
</table>