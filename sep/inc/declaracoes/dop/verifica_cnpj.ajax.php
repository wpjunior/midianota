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
	/*$orgao_CNPJ = $_SESSION['login'];
	
	$sql_orgao = mysql_query("
		SELECT codigo, 
			   nome, 
			   razaosocial, 
			   logradouro,
			   numero, 
			   municipio, 
			   uf, 
			   email, 
			   estado,
			   senha
		FROM cadastro 
		WHERE cnpj='$orgao_CNPJ'
	");
					  
		list($cod_orgao,$nome_orgao,$razao_orgao,$logradouro_orgao,$numero_orgao,$municipio_orgao,$uf_orgao,$email_orgao,$orgao_senha)=mysql_fetch_array($sql_orgao);*/
		?>
<fieldset>
<form method="post" name="frmDesSemTomador">
	<input type="hidden" name="include" id="include" value="<?php echo $_GET['include'];?>" />
	<input type="hidden" name="hdCnpjOrgao" value="<?php echo $orgao_CNPJ; ?>" />
	<input type="hidden" name="hdCodOrgao" value="<?php echo $cod_orgao; ?>" />
	<table width="100%" height="100%" border="0" align="center" cellpadding="5" cellspacing="0">
		<tr>
			<td colspan="3" align="left"><strong>Calculo para declaração dos documentos obrigatórios. </strong></td>
		</tr>
		<tr>
			<td width="15%" align="left" valign="middle">CNPJ:</td>
			<td width="10%" align="left" valign="middle">
				<input type="text" name="txtCNPJ" id="txtCNPJ" 
				onkeyup="MaskCNPJ(this);" maxlength="18" size="20" class="texto" />
			</td>
			<td width="75%" align="left">
				<input name="btOk" type="button" value="Verificar" class="botao" onclick="contaTeclas('txtCNPJ','orgao_publico','divInfos')" />
			</td>
		</tr>
		<tr>
			<td colspan="3" align="left"><input type="submit" name="btVoltar" id="btVoltar" class="botao" value="Voltar" /></td>
		</tr>
	</table>
	<div id="divInfos" style="width:100%;">
	</div>
</form>
</fieldset>