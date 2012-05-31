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
<fieldset><legend><label>Resultado</label></legend>
<?php
	require_once("../conect.php");
	require_once("../../funcoes/util.php");
	require_once("../nocache.php");
	
	$busca = $_GET["txtNumero"];
	$codprest=codtipo("prestador");//codtipo busca no banco o codigo do tipo de cadastro
	$codsimples=codtipo("simples");
	$codgraf=codtipo("grafica");
	$codcontador=codtipo("contador");
	
	if($busca){$string=" AND codigo = '$busca'";}
	$query = ("
		SELECT 
			codigo, 
			nome, 
			cnpj, 
			cpf,
			codtipo
		FROM 
			cadastro 
		WHERE 
			nfe = 's' AND estado = 'NL' AND 
			(	
				codtipo='$codprest' OR 
				codtipo='$codsimples' OR
				codtipo='$codgraf' OR
				codtipo='$codcontador'
			)
		$string 
		ORDER BY 
			nome
		");
	$sql_pedidos = Paginacao($query,'frmLiberarPrestNfe','divlistanfe',15);
	if(mysql_num_rows($sql_pedidos)>0){
?>
	<table width="100%">
        <tr bgcolor="#999999">
            <td width="102" align="center">Número</td>
            <td width="102" align="center">Tipo</td>
            <td width="767" align="center">Nome</td>
            <td width="192" align="center">Cnpj</td>
            <td width="202" align="center">Ações</td>
        </tr>
		<?php
			while(list($codigo,$nome,$cnpj,$cpf,$codtipo) = mysql_fetch_array($sql_pedidos)){
			if(!$cnpj){$cnpj=$cpf;}
			switch($codtipo){
				case $codprest 	  : $codtipo = "Prestador"; break;
				case $codsimples  : $codtipo = "Simples";   break;
				case $codgraf 	  : $codtipo = "Gráfica";   break;
				case $codcontador : $codtipo = "Contador";  break;
			}
			$nome_curto = ResumeString($nome,60);
		?>
		<tr bgcolor="#FFFFFF">
			<td width="102" align="center"><?php echo $codigo;?></td>
			<td width="102" align="center"><?php echo $codtipo;?></td>
			<td width="767" align="left" title="<?php echo $nome;?>"><?php echo $nome_curto;?></td>
			<td width="192" align="center" colspan=""><?php echo $cnpj;?></td>
			<td align="center">
				<input name="btDetalhes" type="button" value="Detalhes" class="botao" onclick="mostraDetalhes('<?php echo $codigo;?>','divDetalhes')" />
				<input name="btLiberar" type="button" value="Ativar" class="botao" 
				onClick="ativarCadastro('<?php echo $codigo;?>','divlistanfe');">
			</td>
		</tr>
		<?php
			}//fim while
		?>
	</table>
	<?php
		}else{
			echo "
				<table width=\"\">
					<tr>
						<td align=\"center\"><label>Não há solicitações de ativação</label></td>
					</tr>
				</table>
			";
		}//fim if
		?>
</fieldset>