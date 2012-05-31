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
	//Recebe as variaveis da busca
	$tipopessoa = $_POST['cmbTipoPessoa'];
	$issretido  = $_POST['cmbISSRetido'];
	$valor      = $_POST['txtValor'];
	$credito    = $_POST['txtCredito'];
	
	
	
	if($_POST['btInserir'] == "Inserir regra"){
		if(($tipopessoa) && ($issretido) && ($valor) && ($credito)){
			$valor = MoedaToDec($valor);
			mysql_query("INSERT INTO nfe_creditos SET credito = '$credito', tipopessoa = '$tipopessoa', issretido = '$issretido', valor = '$valor', estado = 'A'");
			add_logs('Inseriu uma Regra');
			Mensagem("Regra inserida com sucesso!");
		}else{
			Mensagem("Preencha os campos obrigatórios!");
		}		
	}
	
	if($_POST['btSalvar'] == "Salvar"){
		$codigoedit     = $_POST['hdCodCredito'];
		$tipopessoaedit = $_POST['cmbTipoPessoaEdit'];
		$issretidoedit  = $_POST['cmbISSRetidoEdit'];
		$valoredit      = MoedaToDec($_POST['txtValorEdit']);
		$creditoedit    = $_POST['txtCreditoEdit'];
		$estadoedit     = $_POST['cmbEstadoEdit'];
		mysql_query("UPDATE nfe_creditos SET credito = '$creditoedit', tipopessoa = '$tipopessoaedit', issretido = '$issretidoedit', valor = '$valoredit', estado = '$estadoedit' WHERE codigo = '$codigoedit'");
		add_logs('Atualizou uma regra');
		Mensagem("Informações da regra atualizadas!");
	}
	
	if($_POST['btExcluir'] != ""){
		$cod = $_POST['hdCodCred'];
		mysql_query("DELETE FROM nfe_creditos WHERE codigo = '$cod'");
		add_logs('Exclui uma regra');
		Mensagem("Regra Excluida!");
	}
	
	if($_POST['btAtivarSistema']){
		if($_POST['rbCreditos'] == 'sim'){
			mysql_query("UPDATE configuracoes SET ativar_creditos = 's'") or die(mysql_error());
			Mensagem_onload("Sistema de regras ativado");
		}else{
			mysql_query("UPDATE configuracoes SET ativar_creditos = 'n'") or die(mysql_error());
			Mensagem_onload("Sistema de regras desativado");
		}
	}
	
	//pega se esta ativado os creditos
	$ativar_creditos = mysql_result(mysql_query("SELECT ativar_creditos FROM configuracoes"),0);

?>
<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
	<tr>
		<td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
		<td width="500" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;Regras de crédito</td>
		<td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
	</tr>
	<tr>
		<td width="18" background="img/form/lateralesq.jpg"></td>
		<td align="left">
			<form method="post">
				<input type="hidden" name="include" id="include" value="<?php echo $_POST["include"];?>" />
				<fieldset>
				<legend>Sistema de Créditos</legend>
					<table>
						<tr>
							<td>Ativar sistema de créditos</td>
							<td>
								<label><input type="radio" name="rbCreditos" id="rbCreditosS" value="sim" <?php if($ativar_creditos=='s'){echo 'checked="checked"';}?> /> Sim</label>
								<label><input type="radio" name="rbCreditos" id="rbCreditosN" value="nao" <?php if($ativar_creditos=='n'){echo 'checked="checked"';}?> /> Não</label>
							</td>
						</tr>
						<tr>
							<td colspan="2"><input type="submit" value="Salvar" name="btAtivarSistema" id="btAtivarSistema" class="botao" /></td>
						</tr>
					</table>
				</fieldset>
			</form>
			<form method="post" name="frmCreditos" id="frmCreditos">
				<input type="hidden" name="include" id="include" value="<?php echo $_POST["include"];?>" />
				<fieldset><legend>Inserção de regras de créditos</legend>
					<table width="100%">
						<tr>
							<td width="17%" align="left">Tipo Pessoa<font color="#FF0000">*</font></td>
							<td align="left" colspan="3">
								<select name="cmbTipoPessoa" id="cmbTipoPessoa" class="combo">
									<option value=""></option>
									<option value="PF"<?php if($tipopessoa == "PF"){ echo "selected=selected";}?>>Pessoa Fisica</option>
									<option value="PJ"<?php if($tipopessoa == "PJ"){ echo "selected=selected";}?>>Pessoa Jurídica</option>
									<option value="PFPJ"<?php if($tipopessoa == "PFPJ"){ echo "selected=selected";}?>>Ambas</option>
								</select>
							</td>
						</tr>
						<tr>
							<td align="left">ISS Retido<font color="#FF0000">*</font></td>
							<td align="left" colspan="3">
								<select name="cmbISSRetido" id="cmbISSRetido" class="combo">
									<option value=""></option>
									<option value="S"<?php if($issretido == "S"){ echo "selected=selected";}?>>Sim</option>
									<option value="N"<?php if($issretido == "N"){ echo "selected=selected";}?>>Não</option>
								</select>
							</td>
						</tr>
						<tr>
							<td align="left">Valor<font color="#FF0000">*</font></td>
							<td width="23%" align="left">
							<input type="text" name="txtValor" id="txtValor" size="15" onkeyup="MaskMoeda(this)" class="texto" value="<?php echo DecToMoeda($valor);?>" ></td>
							<td width="10%" align="left">Crédito<font color="#FF0000">*</font></td>
							<td width="50%" align="left">
							<input type="text" name="txtCredito" id="txtCredito" size="6" onkeyup="MaskPercent(this)" class="texto" value="<?php echo $credito;?>" ></td>
						</tr>
						<tr>
							<td align="left">
								<input name="btInserir" type="submit" value="Inserir regra" 
								onClick="return ValidaFormulario('cmbTipoPessoa|cmbISSRetido|txtValor|txtCredito')" class="botao" >
							</td>
							<td align="left">
								<input name="btVer" id="btVer" type="button" value="Vizualizar Regras" 
								onClick="acessoAjax('inc/utilitarios/creditos_lista.ajax.php','frmCreditos','divcreditos')" class="botao" >
							</td>
							<td align="left">
								<input name="btLimpar" type="button" value="Limpar" class="botao" onclick="LimpaCampos('frmCreditos')" />
							</td>
						</tr>
					</table>
				</fieldset>
				<div id="divcreditos">
					<?php
					if(($tipopessoa) || ($issretido) || ($valor) || ($credito)){
					?>
					<script>
						document.getElementById('btVer').click();
					</script>
					<?php
					}
					?>
				</div>
			</form>		
				
		</td>
		<td width="19" background="img/form/lateraldir.jpg"></td>
	</tr>
	<tr>
		<td align="left" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantoesq.jpg" /></td>
		<td background="img/form/rodape_fundo.jpg"></td>
		<td align="right" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantodir.jpg" /></td>
	</tr>
</table>
