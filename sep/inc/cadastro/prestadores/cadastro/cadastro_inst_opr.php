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
	<td align="left" width="90">Gerente<font color="#FF0000">*</font></td>
	<td align="left" width="160">
		<input name="txtGerente" type="text" size="25" maxlength="100" class="texto" value="<?php echo $nome_responsavel;?>" />
	</td>
	<td align="left" width="98">Gerente CPF<font color="#FF0000">*</font></td>
	<td align="left" width="100">
		<input name="txtCPFGerente" type="text" size="14" maxlength="14" class="texto" value="<?php echo $cpf_responsavel;?>" />
	</td>
</tr>
<tr>
	<td align="left" width="90">Banco<font color="#FF0000">*</font></td>
	<td align="left" width="160">
		<select name="cmbBanco" id="cmbBanco" class="combo" style="width:150px">
			<option value=""></option>
			<?php
				if($codbanco_inst){
					$codbanco_sql = $codbanco_inst;
				}else{
					$codbanco_sql = $codbanco_opr;
				}
				$sql_banco = mysql_query("SELECT codigo, banco FROM bancos ORDER BY banco ASC");
				while(list($codigo_banco, $banco) = mysql_fetch_array($sql_banco)){
					echo "<option value=\"$codigo_banco\"";if($codbanco_sql == $codigo_banco){ echo "selected=selected"; } echo ">$banco</option>";
				}
			?>
		</select>
	</td>
	<td align="left" width="98">Agencia<font color="#FF0000">*</font></td>
	<td align="left" width="100">
		<input type="text" size="12" maxlength="10" name="txtAgenciaInst" id="txtAgenciaInst" class="texto" 
		value="<?php if($agencia_inst){ echo $agencia_inst;}else{ echo $agencia_opr;}?>" >
	</td>
</tr>
