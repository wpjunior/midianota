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
	$sql=mysql_query("SELECT estado FROM reclamacoes WHERE estado='pendente'");
	$pendentes=mysql_num_rows($sql);
	
	$sql=mysql_query("SELECT estado FROM reclamacoes WHERE estado='atendida'");
	$atendidas=mysql_num_rows($sql);
?>
<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
  <tr>
    <td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
    <td width="820" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;Ouvidoria - Relatório</td>  
    <td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
  </tr>
  <tr>
    <td width="18" background="img/form/lateralesq.jpg"></td>
    <td align="center">
	<form method="post" id="frmReclamacoes" name="frmReclamacoes">
			<fieldset><legend>Relatório de Reclamações</legend>
				<table width="100%">
					<tr>
						<td width="23%">Reclamações Pendentes:</td>
						<td width="77%"><?php echo $pendentes; ?></td>
					</tr>
					<tr>
						<td>Reclamações Atendidas:</td>
						<td><?php echo $atendidas; ?></td>
					</tr>
					<td height="15"></td>
				</table>
				<table>
				<tr>
				<td>
				<input name="btAtendidas" type="button" class="botao" value="Listar Atendidas" onclick="acessoAjax('inc/ouvidoria/relatorio_atend.ajax.php','frmReclamacoes','divReclamacoes');" />
				</td>
				<td>
				<input name="btAtendidas" type="button" class="botao" value="Listar Pendentes" onclick="acessoAjax('inc/ouvidoria/relatorio_pend.ajax.php','frmReclamacoes','divReclamacoes');"/>
				<td>
				<tr>
				</table>
			</fieldset>
		<div id="divReclamacoes"></div>
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