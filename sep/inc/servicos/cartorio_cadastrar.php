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
 if(isset($_POST['btCadastrar']))
 {   
   include("cartorio_inserir.php");
 }?>
<fieldset style="margin-left:10px; margin-right:10px;">
	<legend>Cadastro de Servi&ccedil;os</legend>
	<form method="post" id="frmCadastro">
	<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
		<table width="100%" align="left">
			<tr>
				<td align="left">Categoria</td>
				<td align="left">
					<select name="cmbCategoria" id="cmbCategoria">
                    	<option />
						<?php
							$sql=mysql_query("SELECT codigo ,tipocartorio FROM cartorios_tipo");
							while(list($codigo,$tipocartorio)=mysql_fetch_array($sql))
								{
									echo "<option value=\"$codigo\">$tipocartorio</option>";
								}
						?>
					</select>				</td>
			</tr>
			<tr>
				<td align="left">Descrição<font color="#FF0000"> *</font></td>
				<td align="left">
					<textarea cols="40" rows="5" name="txtInsDescServicos" id="txtInsDescServicos" class="texto"></textarea></td>
			</tr>
			<tr>
			  <td align="left">Aliquota<font color="#FF0000">*</font></td>
		      <td align="left"><input type="text" size="6" maxlength="5" name="txtInsAliquota" id="txtInsAliquota" class="texto" onkeyup="MaskPercent(this)" />
	          &nbsp;%&nbsp;&nbsp;Exemplo(0.00)&nbsp;&nbsp;<em>Para servi&ccedil;os em geral </em></td>
		  </tr>
		  <td>Estado</td>
				  <td colspan="">
					<select name="cmbEstado" class="combo">
						<option value=""></option>
						<option value="A">Ativo</option>
						<option value="I">Inativo</option>
					</select>
				  </td>
			  </tr>
		  <tr>
			  <td align="left">&nbsp;</td>
			  <td align="left"><font color="#FF0000">*</font>Campos Obrigat&oacute;rios</td>
		  </tr>
			<tr>
			  <td align="left"></td>
			  <td align="center">&nbsp;</td>
		  </tr>
		</table>
</form>
</fieldset>
<br>