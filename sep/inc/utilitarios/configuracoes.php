<?php

if($_GET['d']){
	include 'regras_credito.php';
	exit;
}
if($_POST["btBoleto"] == "Boleto"){
	include 'inc/utilitarios/boleto.php';
}else{
	if($_POST["btAtualizar"] == "Atualizar"){
		require("inc/utilitarios/configuracoes_editar.php");
	}//fim if
	//pega as configuracoes da tabela
	$sql_configuracoes = mysql_query("SELECT codigo, endereco, cidade, estado, cnpj, email, secretaria, secretario, chefetributos, lei, decreto, topo_nfe, logo_nfe, brasao_nfe, codlayout, taxacorrecao, taxamulta, taxajuros, data_tributacao, declaracoes_atrazadas, gerar_guia_site FROM configuracoes");
	list($codigo,$endereco,$cidade,$estado,$cnpj,$email,$secretaria,$secretario,$chefetributos,$lei,$decreto,$topo,$logo,$brasao,$layout,$taxacorrecao,$taxamulta,$taxajuros,$data_tributacao,$declaracoes_atrazadas,$gerar_guia_site) = mysql_fetch_array($sql_configuracoes);
?>
<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
  <tr>
    <td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
    <td width="700" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;Utilit&aacute;rios - Configurações</td>  
    <td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
  </tr>
  <tr>
    <td width="18" background="img/form/lateralesq.jpg"></td>
    <td align="center">
		<form method="post" id="frmConfiguracoes" enctype="multipart/form-data">
			<input name="include" id="include" type="hidden" value="<?php echo $_POST["include"];?>" />
			<fieldset><legend>Configurações</legend>
				<table width="100%">
					<tr align="left">
						<td width="91" align="left"><label for="txtEndereco">Endereço:</label></td>
						<td width="218"><input name="txtEndereco" id="txtEndereco" type="text" class="texto" value="<?php echo $endereco;?>" ></td>
						<td width="244"><label for="txtCidade">Cidade: </label></td>
						<td colspan="2"><input name="txtCidade" id="txtCidade" type="text" class="texto" value="<?php echo $cidade;?>" ></td>
					</tr>
					<tr align="left">
						<td><label for="txtUF">Estado:</label></td>
						<td><input name="txtUF" id="txtUF" type="text" class="texto" size="3" maxlength="2" value="<?php echo $estado;?>" ></td>
						<td><label for="txtChefe">Chefe de tributos:</label></td>
						<td colspan="2"><input name="txtChefe" id="txtChefe" type="text" class="texto" value="<?php echo $chefetributos;?>" ></td>
					</tr>
					<tr align="left">
						<td><label for="txtCNPJ">CNPJ: </label></td>
						<td><input name="txtCNPJ" id="txtCNPJ" type="text" class="texto" value="<?php echo $cnpj;?>" ></td>
						<td><label for="txtEmail">E-mail:</label></td>
						<td colspan="2"><input name="txtEmail" id="txtEmail" type="text" class="texto" value="<?php echo $email;?>" ></td>
					</tr>
					<tr align="left">
						<td><label for="txtLei">Lei:</label></td>
						<td><input name="txtLei" id="txtLei" type="text" class="texto" value="<?php echo $lei;?>" ></td>
						<td><label for="txtDecreto">Decreto:</label></td>
						<td colspan="2"><input name="txtDecreto" id="txtDecreto" size="10" type="text" class="texto" value="<?php echo $decreto;?>" ></td>
					</tr>
					<tr align="left">
						<td><label for="txtSecretaria">Secretaria:</label></td>
						<td><input name="txtSecretaria" id="txtSecretaria" type="text" class="texto" value="<?php echo $secretaria;?>" ></td>
						<td><label for="txtSecretario">Secretário:</label></td>
						<td colspan="2"><input name="txtSecretario" id="txtSecretario" type="text" class="texto" value="<?php echo $secretario;?>" ></td>
					</tr>
					<tr align="left">
						<td><label for="txtMulta">Taxa Multa:</label></td>
						<td><input name="txtMulta" id="txtMulta" type="text" class="texto" size="6" value="<?php echo $taxamulta;?>" onkeyup="MaskPercent(this)" ></td>
						<td><label for="txtJuros">Taxa Juros: </label></td>
						<td colspan="2"><input name="txtJuros" id="txtJuros" type="text" class="texto" size="6" value="<?php echo $taxajuros;?>" onkeyup="MaskPercent(this)" ></td>
					</tr>
					<tr align="left">
						<td><label for="txtTaxaCorrecao">Taxa correção:</label></td>
						<td>
							<input name="txtTaxaCorrecao" id="txtTaxaCorrecao" type="text" class="texto" size="6" value="<?php echo $taxacorrecao;?>" 
							onkeyup="MaskPercent(this)" >
						</td>
						<td><label for="txtData">Dia tributação:</label></td>
						<td colspan="2">
							<input name="txtData" id="txtData" maxlength="2" size="3" type="text"  class="texto" value="<?php echo $data_tributacao;?>" />
							<label><input name="ckbData" type="checkbox" id="ckbData" onclick="DesabilitarDataTributo()" />Último dia do mês</label>
						</td>
					</tr>
					<tr align="left">
						<td><label for="flBrasao">Brasão</label></td>
						<td><input name="flBrasao" id="flBrasao" type="file" class="texto" ></td>
						<td>
							<label>Gerar guia para declarações pelo site</label>
						</td>
						<td>
							<label><input type="radio" name="rbGuias" id="rbGuiasS" value="t" <?php if($gerar_guia_site=='t'){echo 'checked="checked"';}?> /> Todas</label>
						</td>
						<td>
							<label><input type="radio" name="rbGuias" id="rbGuiasN" value="i" <?php if($gerar_guia_site=='i'){echo 'checked="checked"';}?> /> Individual</label>
						</td>
					</tr>
					<tr align="left">
						<td><label for="flTopo">Topo:</label></td>
						<td><input name="flTopo" id="flTopo" type="file" class="texto" ></td>
						<td><label>Permitir Declarações atrasadas pelo site:</label></td>
						<td width="151">
							<label><input type="radio" name="rbDec" id="rbDecS" value="s" <?php if($declaracoes_atrazadas=='s'){echo 'checked="checked"';}?> /> Sim</label>
						</td>
						<td>
							<label><input type="radio" name="rbDec" id="rbDecN" value="n" <?php if($declaracoes_atrazadas=='n'){echo 'checked="checked"';}?> /> N&atilde;o</label>
						</td>
					</tr>
					<tr>
						<td><label for="flLogo">Logo: </label></td>
						<td><input name="flLogo" id="flLogo" type="file" class="texto" ></td>
						<td style="visibility:hidden">Tipo de serviço: </td>
						<td style="visibility:hidden"><label><input name="rbTipoServico" value="CNAE" type="radio" /> CNAE</label></td>
						<td width="139" style="visibility:hidden">
							<label><input name="rbTipoServico" value="LC 116" type="radio" /> LC 116</label>
						</td>
					</tr>
					<tr>
						<td style="display:none">Layout:</td>
						<td style="display:none" colspan="4"><input name="txtLayout" type="hidden" class="texto" value="<?php echo $layout;?>" /></td>
					</tr>
					<tr>
						<td colspan="4"><label>Ver imagem atual de: </label>						
							<select name="cmbImagem" class="combo" onchange="acessoAjax('inc/utilitarios/configuracoes_imagens.ajax.php','frmConfiguracoes','divconfiguracoes')">
								<option value=""></option>
								<option value="B">Brasão</option>
								<option value="L">Logo</option>
								<option value="T">Topo</option>
							</select>
						</td>
						
					</tr>
					<tr>
						<td colspan="5"><div id="divconfiguracoes"><!-- (ajax)vizualizar imagem atual aqui --></div></td>
					</tr>
					<tr align="left">
						<td colspan="5">
							<input name="btAtualizar" type="submit" class="botao" value="Atualizar">
							<input name="btBoleto" type="submit" class="botao" value="Boleto" />
						</td>
					</tr>
				</table>
				<div id="teste"></div>
			</fieldset>
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
<?php 
}
?>

