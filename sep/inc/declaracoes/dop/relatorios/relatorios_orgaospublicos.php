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
	//query que verifica todos os cadastrados, ativos, inativos e nao liberados
	$sql = mysql_query("
		SELECT COUNT(codigo) FROM orgaospublicos
		UNION ALL
		SELECT COUNT(codigo) FROM orgaospublicos WHERE estado = 'A'
		UNION ALL
		SELECT COUNT(codigo) FROM orgaospublicos WHERE estado = 'I'
		UNION ALL
		SELECT COUNT(codigo) FROM orgaospublicos WHERE estado = 'NL'
	");
	
	//mysql_result pega um unico resultado da linha solicitada
	$cadastradas=mysql_result($sql,0);
	$ativas=mysql_result($sql,1);
	$inativas=mysql_result($sql,2);
	$nl=mysql_result($sql,3);
	
?>
<fieldset><legend>Informações sobre Órgãos Públicos</legend>
<table width="100%" border="0" cellpadding="0">
    <tr>
        <td width="15%" align="left">Cadastradas:</td>
      <td align="left"><?php if($cadastradas != 0){ echo $cadastradas;}else{ echo "Não há órgãos públicos cadastrados";}?></td>
    </tr>
    <tr>
        <td align="left">Ativas:</td>
        <td align="left"><?php if($ativas != 0){ echo $ativas;}else{ echo "Não há órgãos públicos ativos";}?></td>
    </tr>
    <tr>
        <td align="left">Inativas:</td>
        <td align="left"><?php if($inativas != 0){ echo $inativas;}else{ echo "Não há órgãos públicos inativos";}?></td>
    </tr>
    <tr>
        <td align="left">Não Liberadas:</td>
        <td width="85%" align="left"><?php if($nl != 0){ echo $nl;}else{ echo "Não há órgãos públicos não liberados";}?></td>
  </tr>
</table>
</fieldset>
<fieldset>
<legend>Relat&oacute;rios de &Oacute;rg&atilde;os P&uacute;blicos</legend>
	<table align="left" border="0" cellpadding="0">
		<tr>
			<td>Nome:</td>
			<td colspan="3"><input type="text" name="txtNome" class="texto" size="30" maxlength="100"></td>
		</tr>
		<tr>
			<td>CNPJ:</td>
			<td><input type="text" name="txtCNPJ" class="texto" maxlength="18" onkeyup="MaskCNPJ(this);"  /></td>
			<td>Estado:</td>
			<td>
				<select name="cmbEstado" class="combo">
					<option value=""></option>
					<option value="A">Ativos</option>
					<option value="I">Inativos</option>
					<option value="NL">Não Liberados</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Município:</td>
			<td><input type="text" name="txtCidade" class="texto" /></td>
			<td>UF:</td>
			<td><input type="text" name="txtUF" class="texto" maxlength="2" size="2" /></td>
		</tr>
		<tr>
			<td>Administração:</td>
			<td>
				<select name="cmbAdmin" class="combo">
					<option value=""></option>
					<option value="D">Direta</option>
					<option value="I">Indireta</option>
				</select>
			</td>
			<td>Nivel:</td>
			<td>
				<select name="cmbNivel" class="combo">
					<option value=""></option>
					<option value="M">Municipal</option>
					<option value="E">Estadual</option>
					<option value="F">Federal</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<input type="submit" name="btConsultar" value="Consultar" class="botao" 
				onclick="acessoAjax('inc/orgaospublicos/relatorios/busca_resultado_orgaospublicos.ajax.php','frmRelatorio','divBuscar');" />
			</td>
		</tr>
	</table>
</fieldset>
<div id="divBuscar"></div>
