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
<table width="800" bgcolor="#CCCCCC">
	<tr>
		<td>
			<fieldset><legend>Relatórios Creditos</legend>
				<form method="post" id="frmRelatorioCred" name="frmRelatorioCred" target="_blank" action="inc/creditos/imprimir.php">
					<table width="100%">
						<tr>
							<td width="11%" align="left">Tipo Pessoa: </td>
							<td width="89%" align="left">
								<select name="cmbTipo" id="cmbTipo" class="combo" onchange="testaValor('cmbTipo','cmbISSretido')">
									<option value="">Selecione</option>
									<option value="PF">Pessoa Fisica</option>
									<option value="PJ">Pessoa Juridica</option>
								</select>
						  </td>
						</tr>
						<tr>
							<td align="left">ISS Retido: </td>
							<td align="left">
								<select name="cmbISSretido" id="cmbISSretido" class="combo" onchange="testaValor('cmbTipo','cmbISSretido')">
									<option value="">Selecione</option>
									<option value="S">Sim</option>
									<option value="N">Não</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Valor:</td>
							<td id="tdValor">
								<select style="width: 60px" name="cmbValor" id="cmbValor" class="combo">
									<option value=""></option>
								</select>
							</td>
						</tr>
						<tr>
							<td><br /><label title="Imprimir regra de crédito"><input name="btRelatorio" type="submit" class="botao" value="Relatório" /></label></td>
							<td><br /><label title="Limpar"><input name="btRelatorio" type="reset" class="botao" value="Limpar" /></label></td>
						</tr>
					</table> 
				</form>
			</fieldset>
		</td>
	</tr>
</table>

