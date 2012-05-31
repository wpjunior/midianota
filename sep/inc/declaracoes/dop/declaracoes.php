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
<script>
/*
function mudarpagina(valor){
	var hdpagina = document.getElementById('hdPagina').value;
	var maxpagina = document.getElementById('hdMaxPagina').value;
	if(valor=='p'){
		if(hdpagina < maxpagina){
			hdpagina = parseInt(hdpagina) + 1;
		}
	}else{
		hdpagina = parseInt(hdpagina) - 1;
	}
	document.getElementById('hdPagina').value = '';
	document.getElementById('hdPagina').value = hdpagina;
	acessoAjax('inc/orgaospublicos/declarar_pesquisa.ajax.php','frmDop','spanDop');
}
*/
</script>
<table border="0" cellspacing="0" cellpadding="0" class="form">
  <tr>
    <td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
    <td width="760" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;Declara&ccedil;&atilde;o de Orgãos Públicos (DOP)<br /></td>  
    <td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
  </tr>
  <tr>
    <td width="18" background="img/form/lateralesq.jpg"></td>
    <td align="center">
		<form name="frmDop" id="frmDop" method="post" onsubmit="return false">
			<input type="hidden" name="hdCancelaDop" id="hdCancelaDop" />
			<table width="100%">
				<tr>
					<td>
						<fieldset>
							<legend>Dados</legend>
								<table width="100%">
									<tr>
										<td align="left" width="150">Nome/Raz&atilde;o Social</td>
										<td align="left"><input name="txtNome" id="txtNome" type="text" class="texto" size="60" maxlength="100" /></td>
									</tr>
									<tr>
										<td align="left">CNPJ</td>
										<td align="left"><input name="txtCNPJ" id="txtCNPJ" type="text" class="texto" size="20" maxlength="18" /></td>
									</tr>
									<tr>
										<td align="left">N&deg; DOP</td>
										<td align="left"><input name="txtNro" id="txtNro" type="text" class="texto" size="10" /></td>
									</tr>
									<tr>
										<td align="left">Compet&ecirc;cia</td>
										<td align="left">
											<select name="cmbMes" id="cmbMes" class="combo">
												<option value=""></option>
												<?php
												//array dos meses comecando na posição 1 ate 12 e faz um for listando os meses no combo
												$meses= array(1=>"Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
												for($i=1;$i<=12;$i++){
													echo "<option value='$i'>$meses[$i]</option>";
												}//fim for meses
												?>
											</select>
											<select name="cmbAno" id="cmbAno" class="combo">
												<option value=""></option>
												<?php
												//verifica quais anos que tem declarcoes de orgaos publicos
												$sql_ano = mysql_query("SELECT YEAR(competencia) FROM dop_des GROUP BY YEAR(competencia) ORDER BY YEAR(competencia) DESC");
												while(list($ano) = mysql_fetch_array($sql_ano)){
													echo "<option value='$ano'>$ano</option>";
												}//while para listar os anos que existem declarações
												?>
											</select>
										</td>
									</tr>
									<tr>
										<td align="left">Estado</td>
										<td align="left">
											<select name="cmbEstado" id="cmbEstado" class="combo">
												<option value=""></option>
												<option value="B">Boleto</option>
												<option value="C">Cancelado</option>
												<option value="E">Escriturado</option>
												<option value="N">Normal</option>
											</select>
										</td>
									</tr>
									<tr>
										<td align="left">Data Emissão</td>
										<td align="left"><input name="txtData" id="txtData" type="text" class="texto" size="12" maxlength="10" /></td>
									</tr>
									<tr>
										<td>
										<input name="btPesquisar" id="btPesquisar" type="submit" value="Pesquisar" class="botao" onclick="
										acessoAjax('inc/orgaospublicos/declarar_pesquisa.ajax.php','frmDop','spanDop')" />
										<input name="btLimpar" type="reset" value="Limpar" class="botao" />
										</td>
									</tr>
								</table>
						</fieldset>
					</td>
				</tr>
				<tr>
					<td><span id="spanDop"></span></td>
				</tr>
			</table>
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
