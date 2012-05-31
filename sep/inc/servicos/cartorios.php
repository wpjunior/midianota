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
	if($_POST["btInserirCategoria"] == "Inserir")
		{
			$categoria = $_POST["txtCategoria"];
			if($categoria != "")
				{
					$sql_verifica = mysql_query("SELECT codigo FROM cartorios_tipo WHERE tipocartorio='$categoria'");
					if(mysql_num_rows($sql_verifica)>0)
						{
							Mensagem("Já existe uma categoria com esse nome!");
						}
					else
						{	
							$sql = mysql_query("INSERT INTO cartorios_tipo SET tipocartorio='$categoria'");
							add_logs('Inseriu uma categoria de Cartório');
							Mensagem("Categoria inserida com sucesso!");
						}	
				}
			else
				{
					Mensagem("Informe uma categoria");
				}		
		}//fim if
	if($_POST["btSalvar"] == "Salvar"){
		$desc = $_POST["txtServicoEdit"];
		$codserv = $_POST["hdCodServ"];
		mysql_query("UPDATE cartorios_tipo SET tipocartorio = '$desc' WHERE codigo = '$codserv'");
		Mensagem("Serviço atualizado");
	}//fim if
?>
<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
  <tr>
    <td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
    <td width="700" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;Servi&ccedil;os - Cart&oacute;rios</td>  
    <td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
  </tr>
  <tr>
    <td width="18" background="img/form/lateralesq.jpg"></td>
    <td align="center">
		<form method="post" name="frmInsereCat" id="frmInsereCat">
			<input type="hidden" name="include" id="include" value="<?php echo $_POST["include"];?>" />
			<fieldset style="margin-left:10px; margin-right:10px;">
			<legend>Cadastro de Servi&ccedil;os de Cart&oacute;rios</legend>
				<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
					<table>
						<tr>
							<td>Categoria</td>
							<td><input type="text" class="texto" name="txtCategoria" size="50" /></td>
							<td><input type="submit" class="botao" name="btInserirCategoria" value="Inserir" /></td>
						</tr>
					</table>
			</fieldset>
			<fieldset style="margin-left:10px; margin-right:10px;">
			<legend>Categorias Lista</legend>
				<br />
				<table width="100%" border="0" cellspacing="0" cellpadding="1">
						<?php
							$sql = mysql_query("SELECT codigo, tipocartorio FROM cartorios_tipo");
							$x = 0;
							while(list($codigo,$nome) = mysql_fetch_array($sql))
								{
						?>			<tr>	
										<td width="86%" bgcolor="#FFFFFF"><?php echo $nome;?></td>
										<td width="14%" align="center" bgcolor="#FFFFFF">
											<input type="button" class="botao" name="btEditarCategoria" value="Editar" onClick="VisualizarNovaLinha('<?php echo $codigo;?>','<?php echo"tdservicos".$x;?>',this,'inc/servicos/cartorio_categoria_editar.ajax.php')"/>
						  				</td>
									</tr>
									<tr>
										<td id="<?php echo"tdservicos".$x; ?>" colspan="4" align="center"></td>
									</tr>
							<?php
									$x++;
								} // fim while
							?>
				</table>
			</fieldset>
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
