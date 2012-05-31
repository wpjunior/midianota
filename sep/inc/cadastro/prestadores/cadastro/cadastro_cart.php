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
<tr>
	<td align="left" width="90">Diretor<font color="#FF0000">*</font></td>
	<td align="left" width="160">
		<input name="txtDiretor" type="text" size="25" maxlength="100" class="texto" value="<?php echo $nome_responsavel;?>" />
	</td>
	<td align="left" width="98">Diretor CPF<font color="#FF0000">*</font></td>
	<td align="left" width="100">
		<input name="txtCPFDiretor" type="text" size="14" maxlength="14" class="texto" value="<?php echo $cpf_responsavel;?>" />
	</td>
</tr>
<tr>
	<td align="left" width="90">Adm.Publica<font color="#FF0000">*</font></td>
	<td align="left" width="160">
		<select name="cmbAdm">
			<option value=""></option>
			<option value="D"<?php if($admpublica_cart == "D"){ echo "selected=selected";}?>>Direta</option>
			<option value="I"<?php if($admpublica_cart == "I"){ echo "selected=selected";}?>>Indireta</option>
		</select>
	</td>
	<td align="left" width="98">Nível<font color="#FF0000">*</font></td>
	<td align="left" width="100">
		<select name="cmbNivel">
			<option value=""></option>
			<option value="M"<?php if($nivel_cart == "M"){ echo "selected=selected";}?>>Municipal</option>
			<option value="F"<?php if($nivel_cart == "F"){ echo "selected=selected";}?>>Federal</option>
			<option value="E"<?php if($nivel_cart == "E"){ echo "selected=selected";}?>>Estadual</option>
		</select>
	</td>
</tr>