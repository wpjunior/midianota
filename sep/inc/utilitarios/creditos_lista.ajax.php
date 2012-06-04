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
<fieldset><legend>Lista de regras</legend>
<?php
	require_once("../conect.php");
	require_once("../../funcoes/util.php");
	$query = "SELECT codigo, credito, tipopessoa, issretido, valor, estado FROM nfe_creditos ORDER BY codigo DESC";
	$sql_creditos = Paginacao($query,'frmCreditos','divcreditos',10);
	
	if(mysql_num_rows($sql_creditos)>0){
?>
	<table width="100%">
		<tr bgcolor="#999999">
			<td width="3%" align="center">N°</td>
			<td width="22%" align="center">Tipo Pessoa</td>
			<td width="13%" align="center">ISS Retido</td>
			<td width="15%" align="center">Valor</td>
			<td width="17%" align="center">Crédito</td>
			<td width="14%" align="center">Estado</td>
			<td width="16%" align="center">Editar/Excluir</td>
		</tr>
		<?php
			$x = 0;
			while(list($codigo,$credito,$tipopessoa,$issretido,$valor,$estado) = mysql_fetch_array($sql_creditos)){
				switch($tipopessoa){
					case "PF":
						$tipopessoa = "Pessoa Fisica";
					  break;
					case "PJ":
						$tipopessoa = "Pessoa Jurídica";
					  break;
					case "PFPJ":
						$tipopessoa = "Ambas";
					  break;
				}
				switch($issretido){
					case "S":
						$issretido = "Sim";
					  break;
					case "N":
						$issretido = "Não";
					  break;
				}
				switch($estado){
					case "A":
						$estadostr = "Ativo";
						$bgcolor = "#FFFFFF";
					  break;
					case "I":
						$estadostr = "Inativo";
						$bgcolor = "#FFAC84";
					  break;
				}
		?>
		<tr bgcolor="#FFFFFF">
			<td align="center" bgcolor="<?php echo $bgcolor;?>"><?php echo $x+1;?></td>
			<td align="center" bgcolor="<?php echo $bgcolor;?>"><?php echo $tipopessoa;?></td>
			<td align="center" bgcolor="<?php echo $bgcolor;?>"><?php echo $issretido;?></td>
			<td align="center" bgcolor="<?php echo $bgcolor;?>"><?php echo DecToMoeda($valor);?></td>
			<td align="center" bgcolor="<?php echo $bgcolor;?>"><?php echo $credito;?></td>
			<td align="center" bgcolor="<?php echo $bgcolor;?>"><?php echo $estadostr;?></td>
			<td>
				<input name="btEditar" id="btEdit" value="" class="botao" type="button" onclick="VisualizarNovaLinha('<?php echo $codigo;?>','tdcreditos<?php echo $x;?>',this,'inc/utilitarios/creditos_editar.ajax.php');" title="Editar" /> 
				<input name="btExcluir" id="btX" value=" " class="botao" type="submit" 
				onclick="document.getElementById('hdCodCred').value = <?php echo $codigo;?>;return confirm('Deseja excluir esta regra?')" title="Excluir" /> 
			</td>
		</tr>
		<tr>
			<td colspan="7" id="tdcreditos<?php echo $x;?>"></td>
		</tr>
		<?php
				$x++;
			}//fim while
		?>
		<input type="hidden" name="hdCodCred" id="hdCodCred" />
	</table>
	<?php
	}else{
		echo "<center><b>Não foi encontrado nenhuma regra de crédito!</b></center>";
	}
	?>
</fieldset>
