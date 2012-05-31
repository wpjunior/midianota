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
    <td width="800" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;Servi&ccedil;os - Relatórios</td>  
    <td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
  </tr>
  <tr>
    <td width="18" background="img/form/lateralesq.jpg"></td>
    <td align="left">
			<fieldset><legend>Relatórios de Serviços</legend>
				<div id="teste"></div>
				<form method="post" id="frmServicos">	
					<table>
						<tr>
							<td>Categoria:</td>
							<td>
								<select name="cmbCategoria" style="width:200" onchange="acessoAjax('inc/servicos/relatorios_listaservico.ajax.php','frmServicos','cmbServico')">
									<option value=""></option>
									<?php
										$sql=mysql_query("SELECT codigo, nome FROM servicos_categorias");
										while(list($codcategoria,$categoria)=mysql_fetch_array($sql))
											{
												echo "<option value=\"$codcategoria\">$categoria</option>";
											}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td>Serviço:</td>
							<td>
								<select name="cmbServico" style="width:200" id="cmbServico">
								</select>
							</td>
						</tr>	
						<tr>
							<td>Data Inicial:</td>
							<td><input type="text" class="texto" name="txtDataIni" id="txtDataIni" maxlength="10" onkeypress="formataData(this)" /></td>
						</tr>	
						<tr>
							<td>Data Final:</td>
							<td><input type="text" class="texto" name="txtDataFim" id="txtDataFim" maxlength="10" onkeypress="formataData(this)" /></td>
						</tr>
					</table>
					<table>
						<tr>
							<td><input type="submit" class="botao" name="btBuscar" value="Buscar" /></td>
							<td><input type="submit" class="botao" name="btServico" value="Prestadores por serviço" /></td>
							<td><input type="submit" class="botao" name="btCategoria" value="Prestadores por categoria" /></td>
						</tr>
					</table>
					<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
				</form>	
				<?php
					$codservico=$_POST["cmbServico"];
					$dataini = DataMysql($_POST["txtDataIni"]);
					$datafim = DataMysql($_POST["txtDataFim"]);
					if(!$dataini){$dataini="0000-00-00";}
					if(!$datafim){$datafim="9999-99-99";}
					$issretido=$_POST["cmbIssRetido"];
					if($_POST["btBuscar"] == "Buscar")
						{
							include("inc/servicos/relatorios_detalhes.php");
						}
					elseif($_POST["btServico"] == "Prestadores por serviço")
						{
							include("inc/servicos/relatorios_listar.php");
						}
					elseif($_POST["btCategoria"] == "Prestadores por categoria")
						{
							include("inc/servicos/relatorios_categorias.php");
						}		
				?>
			</fieldset>
	</td>
	<td width="19" background="img/form/lateraldir.jpg"></td>
  </tr>
  <tr>
    <td align="left" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantoesq.jpg" /></td>
    <td background="img/form/rodape_fundo.jpg"></td>
    <td align="right" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantodir.jpg" /></td>
  </tr>
</table>

