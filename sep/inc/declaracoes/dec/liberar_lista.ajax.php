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
	include("../conect.php");
	$busca = $_GET["txtNumero"];
	if($busca){
		$string = "AND codigo = '$busca' ";
	}
	$sql_pedidos = mysql_query("SELECT codigo, nome, cnpj FROM cartorios WHERE estado = 'NL' $string ORDER BY nome");
	if(mysql_num_rows($sql_pedidos)>0){
?>
<fieldset><legend>Resultados encontrados: <?php echo mysql_num_rows($sql_pedidos);?></legend>
	<table width="100%">
		<tr bgcolor="#999999">
			<td width="150" align="center">Número do Documento</td>
			<td width="230" align="center">Nome</td>
			<td width="150" align="center">Cnpj</td>
			<td align="center"></td>
		</tr>
	</table>
<div <?php if(mysql_num_rows($sql_pedidos)>15){ echo "style=\"overflow:auto; height:250px\"";}?>>
	<table width="100%">
		<?php
			while(list($codigo,$nome,$cnpj,$estado) = mysql_fetch_array($sql_pedidos)){
		?>
		<tr bgcolor="#FFFFFF">
			<td width="150" align="center"><?php echo $codigo;?></td>
			<td width="230" align="left"><?php echo $nome;?></td>
			<td width="150" align="center" colspan=""><?php echo $cnpj;?></td>
			<td align="center">
				<input name="btLiberar" type="submit" value="Ativar" class="botao" onClick="document.getElementById('hdCodSolicitacaoCartorio').value=<?php echo $codigo;?>">
			</td>
		</tr>
		<?php
			}//fim while
		?>
		<input name="hdCodSolicitacaoCartorio" id="hdCodSolicitacaoCartorio" type="hidden">
	</table>
	<?php
		}else{
			echo "
				<table width=\"\">
					<tr>
						<td align=\"center\">Não há solicitações de ativação</td>
					</tr>
				</table>
			";
		}//fim if
		?>
</div>
</fieldset>
