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
<fieldset>
	<form  method="post" name="frmDif" id="frmDif" enctype="multipart/form-data">
		<input type="hidden" name="include" id="include" value="<?php echo $_GET['include'];?>" />
		<table width="100%" border="0" align="left" cellpadding="2" cellspacing="2">
			<tr>
				<td align="left">CNPJ <font color="#FF0000">*</font></td>
				<td align="left" colspan="2">
					<input type="text" class="texto" name="txtCNPJ" id="txtCNPJ" onkeyup="MaskCNPJ(this)" size="20" maxlength="18" />
				</td>
			</tr>
			<tr>
				<td  width="18%" align="left"> Competência <font color="#FF0000">*</font></td>
				<td align="left" colspan="2" > Mês
					<select name="cmbMes" id="cmbMes" class="combo">
						<option value=""></option>
						<option value="01">01</option>
						<option value="02">02</option>
						<option value="03">03</option>
						<option value="04">04</option>
						<option value="05">05</option>
						<option value="06">06</option>
						<option value="07">07</option>
						<option value="08">08</option>
						<option value="09">09</option>
						<option value="10">10</option>
						<option value="11">11</option>
						<option value="12">12</option>
					</select>
					Ano
					<select name="cmbAno" id="cmbAno" class="combo">
						<option value=""></option>
						<?php
							$year = date("Y");
							for($h=0; $h<5; $h++){
								$y = $year - $h;
								echo "<option value=\"$y\">$y</option>";
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td width="18%" align="left"> XML <font color="#FF0000">*</font></td>
				<td align="left" colspan="2">
					<input type="file" name="import" id="import" class="botao" />
				</td>
			</tr>
			<tr>
				<td align="right">
					<input type="submit" value="Enviar" name="btEnviar" class="botao" 
					onclick="return (ValidaFormulario('cmbMes|cmbAno|txtCNPJ','Preencha os campos!'))&&(VerificaArquivo());">
				</td>
				<td width="59%" align="left">
					<input type="submit" value="Voltar" class="botao" name="btVoltar" />
				</td>
				<td width="23%" align="left"><font color="#FF0000"><em>* Campos obragatórios</em></font></td>
			</tr>
		</table>
	</form>
</fieldset>
