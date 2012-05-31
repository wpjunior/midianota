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
	if($_POST["btLiberar"] == "Liberar"){
		$codigo = $_POST["hdCodSolicitacao"];
		mysql_query("UPDATE orgaospublicos SET estado = 'A' WHERE codigo = '$codigo'");
		Mensagem("Liberação de Órgão Ativada");
	}
?>

<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
  <tr>
    <td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
    <td width="800" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;&Oacute;rg&atilde;os P&uacute;blicos - Liberar </td>  
    <td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
  </tr>
  <tr>
    <td width="18" background="img/form/lateralesq.jpg"></td>
    <td align="center">
		<form method="post">
			<input name="include" id="include" type="hidden" value="<?php echo $_POST["include"];?>">
			<fieldset><legend>Liberar Cadastro</legend>
				<table width="790">
				<?php
					$sql_pedidos = mysql_query("SELECT codigo, nome, cnpj, razaosocial, nivel FROM orgaospublicos WHERE estado = 'NL' ORDER BY codigo");
					if(mysql_num_rows($sql_pedidos)>0){
				?>
					<tr bgcolor="#999999">
						<td width="180" align="center">Nome</td>
						<td width="130" align="center">Cnpj</td>
						<td width="200" align="center">Razão Social</td>
						<td width="130" align="center">Nível</td>
						<td align="center" width="50">Ações</td>
					</tr>
					<?php
						while(list($codigo,$nome,$cnpj, $razaosocial, $nivel, $estado) = mysql_fetch_array($sql_pedidos)){
					switch($nivel){
					case "E": $nivel = "Estadual"; break;
					case "M": $nivel = "Municipal"; break;
					case "F": $nivel = "Federal"; break;
					}
					?>
					<tr bgcolor="#FFFFFF">
						<td align="center" height="35"><?php echo $nome;?></td>
						<td align="center"><?php echo $cnpj;?></td>
						<td align="center"><?php echo $razaosocial;?></td>
						<td align="center"><?php echo $nivel;?></td>
						<td align="center">
						<input name="btLiberar" type="submit" value="Liberar" class="botao" onClick="document.getElementById('hdCodSolicitacao').value=<?php echo $codigo;?>">
						</td>
					</tr>
					<?php
						}//fim while
					}else{
						echo "
							<tr>
								<td align=\"center\">Não há solicitações de ativação</td>
							</tr>
						";
					}//fim if
					?>
				</table>
			</fieldset>
			<input name="hdCodSolicitacao" id="hdCodSolicitacao" type="hidden">
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