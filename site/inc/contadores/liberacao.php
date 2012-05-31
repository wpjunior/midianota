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
if(!$_POST['txtCNPJ']){
?>
<form method="post" name="frmCNPJ">
	<input type="hidden" value="<?php echo $_POST['txtMenu'];?>" name="txtMenu">
	<table width="100%" border="0" cellspacing="1" cellpadding="0">
		<tr>
			<td width="10" height="10" bgcolor="#FFFFFF"></td>
			<td width="185" align="center" bgcolor="#FFFFFF" rowspan="3">Contador - Informe seu dados</td>
			<td width="385" bgcolor="#FFFFFF"></td>
		</tr>
		<tr>
			<td height="1" bgcolor="#CCCCCC"></td>
			<td bgcolor="#CCCCCC"></td>
		</tr>
		<tr>
			<td height="10" bgcolor="#FFFFFF"></td>
			<td bgcolor="#FFFFFF"></td>
		</tr>
		<tr>
			<td colspan="3" height="1" bgcolor="#CCCCCC"></td>
		</tr>
		<tr>
			<td height="60" colspan="3" bgcolor="#CCCCCC"><table width="98%" height="100%" border="0" align="center" cellpadding="5" cellspacing="0">
					<tr>
						<td width="19%" align="left">CNPJ/CPF</td>
						<td width="81%" align="left" valign="middle"><em>
							<input class="texto" type="text" title="CNPJ" name="txtCNPJ"  id="txtCNPJ"  />
							Somente n&uacute;meros</em></td>
					</tr>
					<tr>
						<td align="center">&nbsp;</td>
						<td align="left" valign="middle"><input name="btAvancar" type="submit" value="Avançar" class="botao" />
							&nbsp;
							<input type="button" name="btVoltar" value="Voltar" class="botao" onClick="window.location='contadores.php'"></td>
					</tr>
				</table></td>
		</tr>
		<tr>
			<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
		</tr>
	</table>
</form>
<?php
}else{
	include("consulta_situacao.php");
}
?>