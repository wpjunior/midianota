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
	//recebimento de variaveis por post
	$titulo = $_POST["txtTitulo"];
	$texto  = $_POST["txtText"];
	if($_POST["btInserir"] == "Inserir Nova"){
		mysql_query("INSERT INTO noticias SET titulo = '$titulo', texto = '$texto', data = NOW()");
		add_logs('Inseriu uma Notícia');
		Mensagem("Notícia inserida");
	}//fim if
	 if($_POST["btExcluir"] == " "){
		$cod_nt= $_POST['hdCodNt'];
		$sql_busca_nt = mysql_query("SELECT texto FROM noticias WHERE codigo = '$cod_nt'");
		list($exc_nt) = mysql_fetch_array($sql_busca_nt);
		mysql_query("DELETE FROM noticias WHERE codigo ='$cod_nt'"); 
		add_logs('Excluiu uma Notícia');
		Mensagem("Notícia excluida!");
		}		
?>
<div id="divnoticias" style="position:absolute; left:30%; top:40%; display:none"></div>
<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
  <tr>
    <td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
    <td width="730" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;Utilit&aacute;rios - Not&iacute;cias</td>  
    <td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
  </tr>
  <tr>
    <td width="18" background="img/form/lateralesq.jpg"></td>
    <td align="center">
		<form method="post" id="frmNoticias">
			<input name="include" id="include" type="hidden" value="<?php echo $_POST["include"];?>" />
				<fieldset><legend>Notícias</legend>
					<table width="100%">
						<tr>
							<td width="12%" align="left">Título</td>
							<td width="88%" align="left"><input type="text" name="txtTitulo" id="txtTitulo" size="50" class="texto" /></td>
						</tr>
						<tr>
							<td colspan="2" align="left">Conteúdo</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td align="left"><textarea name="txtText" id="txtText" cols="50" rows="6" class="texto"></textarea></td>
						</tr>
						<tr>
							<td align="left">
                            	<input type="submit" name="btInserir" class="botao" value="Inserir Nova" 
                            	onclick="return ValidaFormulario('txtTitulo|txtText','Os campos titulo e noticia devem ser preenchidos!')" />
                            </td>
                            <td align="left">
                            	<input type="button" name="btInserir" class="botao" value="Mostrar Noticias" 
                            	onclick="acessoAjax('inc/utilitarios/noticias_lista.ajax.php','frmNoticias','divnoticiaslista')" />
                            </td>
						</tr>
					</table>
				</fieldset>	
                <div id="divnoticiaslista"></div>
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
