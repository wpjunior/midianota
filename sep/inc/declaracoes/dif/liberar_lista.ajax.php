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
<fieldset>
<?php
	require_once("../conect.php");
	require_once("../../funcoes/util.php");
	
	if(isset($_GET["hdCodSolicitacao"])){
		//Ativa os usuarios mudando no banco de NL para A
		$codigo = $_GET["hdCodSolicitacao"];
		mysql_query("UPDATE cadastro SET estado = 'A' WHERE codigo = '$codigo'");
	}

	
	$busca = $_GET["txtNumero"];
	$codinst=codtipo("instituicao_financeira");
	if($busca){
		$string = "AND nome LIKE '$busca%' ";
	}
	$query = ("
		SELECT 
			codigo, 
			nome, 
			cnpj 
		FROM 
			cadastro
		WHERE 
			estado = 'NL' AND codtipo = '$codinst' $string
		ORDER BY 
			nome
		");
	$sql_pedidos = Paginacao($query,'frmLiberarDif','divlistadif',15);
	if(mysql_num_rows($sql_pedidos)>0){
?>
	<table width="100%">
        <tr bgcolor="#999999">
            <td width="260" align="center">Número do Documento</td>
            <td width="622" align="center">Nome</td>
            <td width="180" align="center">Cnpj</td>
            <td width="75" align="center"></td>
        </tr>
		<?php
			while(list($codigo,$nome,$cnpj,$estado) = mysql_fetch_array($sql_pedidos)){
		?>
		<tr bgcolor="#FFFFFF">
			<td width="260" align="center"><?php echo $codigo;?></td>
			<td width="622" align="left"><?php echo $nome;?></td>
			<td width="180" align="center" colspan=""><?php echo $cnpj;?></td>
			<td align="center">
				<input name="btLiberar" type="button" value="Ativar" class="botao" 
				onClick="document.getElementById('hdPrimeiro').value=1;document.getElementById('hdCodSolicitacao').value=<?php echo $codigo;?>;
				acessoAjax('inc/instfinanceiras/liberar_lista.ajax.php','frmLiberarDif','divlistadif');alert('Cadastro ativado')">
			</td>
		</tr>
		<?php
			}//fim while
		?>
		<input name="hdCodSolicitacao" id="hdCodSolicitacao" type="hidden">
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
</fieldset>
