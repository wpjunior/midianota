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
	if($_POST['btSalvar'] == "Salvar"){
		include("inc/utilitarios/regras/regras_salvar.php");
	}
	if($_POST['btEditar'] == "Salvar"){
		include("inc/utilitarios/regras/regras_editar.php");
	}
	if($_POST['btExcluir'] == " "){
		include("inc/utilitarios/regras/regras_excluir.php");
	}
?>
<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
	<tr>
		<td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
		<td width="500" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;Regras de multa</td>
		<td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
	</tr>
	<tr>
		<td width="18" background="img/form/lateralesq.jpg"></td>
		<td align="left">
		
			<form method="post" name="formMultas" id="formMultas">
				<input name="include" id="include" value="<?php echo $_POST['include'];?>" type="hidden" />
				<fieldset>
				<legend>Regras de multa para emissão de guia</legend>
				<table width="100%">
					<tr>
						<td width="27%" align="left">Dias de tolerância<font color="#FF0000">*</font></td>
						<td align="left" colspan="2"><input name="txtDias" id="txtDias" type="text" maxlength="2" size="3" class="texto"></td>
					</tr>
					<tr>
						<td align="left">Multa fixa<font color="#FF0000">*</font></td>
						<td width="19%" align="left">R$<input type="text" name="txtMulta" id="txtMulta" class="texto" maxlength="10" size="8" onkeyup="MaskMoeda(this)"></td>
						<td width="20%" align="right">Juros de mora<font color="#FF0000">*</font></td>
						<td width="34%" align="left">
							<input type="text" name="txtJurosMora" id="txtJurosMora" class="texto" maxlength="3" size="4" onkeyup="MaskPercent(this)" 
							onblur="limitePct('txtJurosMora')" >%
						</td>
					</tr>
					<tr>
						<td align="left">Estado<font color="#FF0000">*</font></td>
						<td align="left" colspan="2">
							<select name="cmbEstado" id="cmbEstado" class="combo">
								<option value=""></option>
								<option value="A">Ativo</option>
								<option value="I">Inativo</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="left" colspan="4">
							<input name="btNovo" class="botao" type="button" value="Novo">
							<input name="btPesquisar" type="button" class="botao" value="Pesquisar" 
							onclick="acessoAjax('inc/utilitarios/regras/regra_lista.ajax.php','formMultas','divMultasLista')">
							<input name="btSalvar" type="submit" class="botao" value="Salvar" 
                            onclick="return (ValidaFormulario('txtDias|txtMulta|txtJurosMora|cmbEstado','Preencha os dados obrigatórios') && (limitePct('txtJurosMora')))">
						</td>
					</tr>
				</table>
				</fieldset>
				<div id="divMultasLista"></div>
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
