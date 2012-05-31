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
<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
	<tr>
		<td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
		<td width="800" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;Escritura&ccedil;&otilde;es - Relat&oacute;rios </td>  
		<td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
	</tr>
	<tr>
		<td width="18" background="img/form/lateralesq.jpg"></td>
		<td align="center">
			<table width="800" bgcolor="#CCCCCC">
				<tr>
					<td>
						<form method="post" id="frmRelatorio" name="frmRelatorio" onsubmit="return false">						
                        <fieldset style="width:800px"  ><legend>Buscar Escrituração por Nosso Número:</legend>
						<input type="hidden" name="include" id="include" value="<?php echo $_POST['include']; ?>">
							<table width="100%" border="0" cellpadding="0"align="center">
								<tr>
									<td width="100">Nosso Número:</td>
									<td>
										<input type="text" name="txtNossonumero" onkeydown="return NumbersOnly(event);" class="texto" size="30" maxlength="30">
										<input type="submit" name="btnNossoNumero" id="btnNossoNumero" value="Consulta" class="botao" onclick="acessoAjax('inc/escrituracoes/relatorios/busca_relatorios.ajax.php','frmRelatorio','divBuscar');" >
									</td>
								</tr>								
								<tr>
									<td colspan="2"><br />					
										<input type="button" name="btnTodos" id="btnTodos" value="Relatório" class="botao" onclick="acessoAjax('inc/escrituracoes/relatorios/busca_todos.ajax.php','frmRelatorio','divBuscar');"/>					
									</td>
								</tr>
							</table>
						</fieldset>
						<div id="divBuscar"></div>
						</form>
					</td>
				</tr>
			</table>
		<td width="19" background="img/form/lateraldir.jpg"></td>
	</tr>
	<tr>
		<td align="left" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantoesq.jpg" /></td>
		<td background="img/form/rodape_fundo.jpg"></td>
		<td align="right" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantodir.jpg" /></td>
	</tr>
</table>