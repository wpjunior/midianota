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
	if($_POST["btLiberar"] == "Ativar"){
		//Ativa os usuarios mudando no banco de NL para A
		$codigo = $_POST["hdCodSolicitacaoCartorio"];
		mysql_query("UPDATE cartorios SET estado = 'A' WHERE codigo = '$codigo'");
		add_logs('Atualizou um Cartório: Ativado');
		Mensagem("Cadastro ativado");
	}
?>

<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
  <tr>
    <td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
    <td width="650" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;Cart&oacute;rios - Liberar </td>  
    <td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
  </tr>
  <tr>
    <td width="18" background="img/form/lateralesq.jpg"></td>
    <td align="center">
		<form method="post" id="frmLiberarCartorio">
			<input name="include" id="include" type="hidden" value="<?php echo $_POST["include"];?>">
			<fieldset><legend>Liberar Cadastro</legend>
				<table width="100%">
					<tr>
						<td width="24%" align="left">Número do Documento: </td>
					  	<td width="76%" align="left"><input type="text" class="texto" name="txtNumero" /></td>
					</tr>
					<tr>
						<td align="left" colspan="2">
							<input type="button" class="botao" name="btBuscar" value="Buscar" 
							onclick="acessoAjax('inc/cartorios/liberar_lista.ajax.php','frmLiberarCartorio','divlistaCartorio')" />
						</td>
					</tr>
				</table>
			</fieldset>
		<div id="divlistaCartorio"></div>
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
