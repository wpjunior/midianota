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
$cpfcnpj_tomador   = $_POST['txtCpfCnpjTomador'];
$numero_rps        = $_POST['txtRpsNumero'];
$data_rps          = $_POST['txtDataRps'];
$valor_rps         = $_POST['txtValorRps'];
$cpfcnpj_prestador = $_POST['txtCpfCnpjPrestador'];
$email_tomador     = $_POST['txtEmailtomador'];
$especificacao     = $_POST['cmbEspecificacao'];
$descricao		   = $_POST['txtDescricao'];

if($_POST['btCadastrar'] == "Cadastrar"){
	if((strlen($cpfcnpj_prestador) == 18) || (strlen($cpfcnpj_prestador) == 14)){
		$campo = tipoPessoa($cpfcnpj_prestador);
		$sql_verifica_prestador = mysql_query("SELECT codigo FROM cadastro WHERE $campo = '$cpfcnpj_prestador'");
		if(mysql_num_rows($sql_verifica_prestador)>0){
			$data = DataMysql($data_rps);
			mysql_query("INSERT INTO reclamacoes SET assunto = 'Nota Fiscal Eletrônica de Serviços', descricao='$descricao', especificacao = '$especificacao',
			tomador_cnpj = '$cpfcnpj_tomador', rps_numero = '$numero_rps', rps_data = '$data', rps_valor = '$valor_rps',
			emissor_cnpjcpf = '$cpfcnpj_prestador', estado = 'pendente', datareclamacao = NOW(),tomador_email = '$email_tomador'");
			Mensagem("Sua reclamação foi enviada com sucesso!");
			Redireciona("ouvidoria.php");
		}else{
			Mensagem("Prestador de serviços inexistente! Certifique-se de que o CPF/CNPJ do prestador de serviços está correto");
		}
	}else{
		Mensagem("Digite um CPF/CNPJ de prestador valido!");
	}
}
?>

<form method="post">
	<input type="hidden" name="txtMenu" value="<?php echo $_POST['txtMenu'];?>" />
	<table width="580" border="0" cellpadding="0" cellspacing="1">
		<tr>
			<td width="5%" height="10" bgcolor="#FFFFFF"></td>
			<td width="30%" align="center" bgcolor="#FFFFFF" rowspan="3">Cadastro de Reclama&ccedil;&otilde;es</td>
			<td width="65%" bgcolor="#FFFFFF"></td>
		</tr>
		<tr>
			<td height="1" bgcolor="#CCCCCC"></td>
			<td bgcolor="#CCCCCC"></td>
		</tr>
		<tr>
			<td height="10" bgcolor="#FFFFFF"></td>
			<td bgcolor="#FFFFFF"></td>
		</tr>
		<tr>
			<td colspan="3" height="1" bgcolor="#CCCCCC"></td>
		</tr>
		<tr>
			<td height="60" colspan="3" bgcolor="#CCCCCC">
				<table width="99%" border="0" align="center" cellpadding="5" cellspacing="0">
					<tr>
						<td align="left" background="../../img/index/index_oquee_fundo.jpg" > Assunto </td>
						<td align="left" background="../../img/index/index_oquee_fundo.jpg"> Nota Fiscal Eletrônica de Serviços </td>
					</tr>
					<tr>
						<td align="left" background="../../img/index/index_oquee_fundo.jpg" > Especificação </td>
						<td align="left" background="../../img/index/index_oquee_fundo.jpg">
							<select name="cmbEspecificacao" id="cmbEspecificacao" class="combo">
								<option value="Conversão de NFE">N&atilde;o convers&atilde;o de RPS</option>
								<option value="Diferen&ccedil;a de valores RPS/NFE">Diferen&ccedil;a de valores RPS/NFE</option>
								<option value="Nota Cancelada">Nota Cancelada</option>
							</select>
						</td>
					</tr>
					<tr>
						<td background="../../img/index/index_oquee_fundo.jpg" align="left">Descri&ccedil;&atilde;o <b><font color="#FF0000">*</font></b></td>
						<td  background="../../img/index/index_oquee_fundo.jpg" align="left">
							<textarea name="txtDescricao" id="txtDescricao" rows="4" cols="25"></textarea>
					</tr>
					<tr>
						<td width="222" align="left" background="../../img/index/index_oquee_fundo.jpg"> Cpf/Cnpj do Tomador de serviços<font color="#FF0000">*</font> </td>
						<td width="258" align="left" background="../../img/index/index_oquee_fundo.jpg">
							<input type="text" name="txtCpfCnpjTomador" id="txtCpfCnpjTomador" class="texto"  onkeydown="stopMsk( event ); return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );">
					</tr>
					<tr>
						<td background="../../img/index/index_oquee_fundo.jpg" align="left"> Tomador Email<b><font color="#FF0000">*</font></b> </td>
						<td  background="../../img/index/index_oquee_fundo.jpg" align="left">
							<input type="text" class="email" name="txtEmailtomador" id="txtEmailtomador">
						</td>
					</tr>
					<tr>
						<td background="../../img/index/index_oquee_fundo.jpg" align="left"> Número do RPS ou NFe<b><font color="#FF0000">*</font></b> </td>
						<td  background="../../img/index/index_oquee_fundo.jpg" align="left">
							<input type="text" class="texto" name="txtRpsNumero" id="txtRpsNumero">
					</tr>
					<tr>
						<td background="../../img/index/index_oquee_fundo.jpg" align="left"> Data de Emissão do RPS ou NFe<b><font color="#FF0000">*</font></b> </td>
						<td  background="../../img/index/index_oquee_fundo.jpg" align="left">
							<input type="text" class="texto" name="txtDataRps" id="txtDataRps" maxlength="10">
					</tr>
					<tr>
						<td background="../../img/index/index_oquee_fundo.jpg" align="left"> Valor do RPS ou NFe<b><font color="#FF0000">*</font></b> </td>
						<td  background="../../img/index/index_oquee_fundo.jpg" align="left">
							<input type="text" class="texto" name="txtValorRps" id="txtValorRps">
					</tr>
					<tr>
						<td background="../../img/index/index_oquee_fundo.jpg" align="left"> CPF/CNPJ do Prestador de serviços<b><font color="#FF0000">*</font></b> </td>
						<td  background="../../img/index/index_oquee_fundo.jpg" align="left">
							<input type="text" class="texto" name="txtCpfCnpjPrestador" id="txtCpfCnpjPrestador" onkeydown="stopMsk( event );" onkeypress="return NumbersOnly( event );">
					</tr>
					<tr>
						<td align="center" background="../../img/index/index_oquee_fundo.jpg">
							<input type="submit" name="btCadastrar" value="Cadastrar" class="botao" 
	  onclick="return ValidaFormulario('cmbEspecificacao|txtCpfCnpjTomador|txtEmailtomador|txtRpsNumero|txtDataRps|txtValorRps|txtCpfCnpjPrestador|txtDescricao')">
						</td>
						<td align="right" background="../../img/index/index_oquee_fundo.jpg"> <b><font color="#FF0000">*</font></b> Campos com preenchimento obrigátorio. </td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
		</tr>
	</table>
</form>
