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
session_name("contador");
session_start();
include("conect.php");
include("../../funcoes/util.php");
	$numero = $_GET['txtNumeroNota'];
	$codverificacao = $_GET['txtCodigoVerificacao'];
	$tomador_cnpjcpf = $_GET['txtTomadorCPF'];
	
	if($numero){
		$string = " AND `notas`.`numero` = '$numero'";
	}
	if($tomador_cnpjcpf){
		$string = " AND `notas`.`tomador_cnpjcpf` = '$tomador_cnpjcpf'";
	}
	$query=("
SELECT
  `notas`.`codigo`, `notas`.`numero`, `notas`.`codverificacao`,
  `notas`.`datahoraemissao`, `notas`.`codemissor`, `notas`.`tomador_nome`,
  `notas`.`tomador_cnpjcpf`, `notas`.`estado`
FROM
  `notas`
WHERE
  `notas`.`codemissor` = '$CODIGO_DA_EMPRESA' AND
  `notas`.`codverificacao` LIKE '$codverificacao%'  
  $string
  ORDER BY notas.codigo DESC
	"); // fim sql
?><form method="post" action="notas.php" id="frmCancelarNota" name="frmCancelarNota" onsubmit="return CancelarNota()">
	<input type="hidden" name="a" value="a" />
	<input type="hidden" name="txtNumeroNota" value="<?php echo $numero;?>" />
	<input type="hidden" name="txtCodigoVerificacao" value="<?php echo $codverificacao;?>" />
	<input type="hidden" name="txtTomadorCPF" value="<?php echo $tomador_cnpjcpf;?>" />
	<table border="0" align="center" cellpadding="0" cellspacing="1">
		<tr>
			<td width="10" height="10" bgcolor="#FFFFFF"></td>
			<td width="170" align="center" bgcolor="#FFFFFF" rowspan="3">Resultado de Pesquisa</td>
			<td width="400" bgcolor="#FFFFFF"></td>
		</tr>
		<tr>
			<td height="1" bgcolor="#CCCCCC"></td>
			<td bgcolor="#CCCCCC"></td>
		</tr>
		<tr>
			<td height="10" bgcolor="#FFFFFF"></td>
			<td bgcolor="#FFFFFF"></td>
		</tr>
		<tr>
			<td colspan="3" height="1" bgcolor="#CCCCCC"></td>
		</tr>
		<tr>
			<td height="60" colspan="3" bgcolor="#CCCCCC">
				<?php $sql = Paginacao($query,'frmCancelarNota','Container',10);?>
				<table width="100%" border="0" cellspacing="2" cellpadding="2">
					<?php
						if(mysql_num_rows($sql)>0){
					?>
					<tr>
						<td width="5%" align="center">N&ordm;</td>
						<td width="13%" align="center">Cód Verif</td>
						<td width="16%" align="center">D/H Emissão</td>
						<td width="40%" align="center">Tomador Nome </td>
						<td width="13%" align="center">Estado</td>
						<td width="4%"></td>
						<td width="9%"></td>
					</tr>
					<tr>
						<td colspan="7" height="1" bgcolor="#999999"></td>
					</tr>
					<?php	
						$x = 0;
						while(list($codigo, $numero, $codverificacao, $datahoraemissao, $codempresa, $tomador_nome, $tomador_cnpjcpf, $estado) = mysql_fetch_array($sql)) {
						
						// mascara o codigo com cripto base64 
						$crypto = base64_encode($codigo);
						 
						if($estado == "C"){
							$bgcolor = "#FFB895";
						}else{
							$bgcolor = "#FFFFFF";
						}
					?>
					<tr>
						<td align="center" bgcolor="<?php echo $bgcolor;?>"><?php echo $numero; ?></td>
						<td align="center" bgcolor="<?php echo $bgcolor;?>"><?php echo $codverificacao;  ?></td>
						<td align="center" bgcolor="<?php echo $bgcolor;?>"><?php echo substr($datahoraemissao,8,2)."/".substr($datahoraemissao,5,2)."/".substr($datahoraemissao,0,4); ?></td>
						<td bgcolor="<?php echo $bgcolor;?>"><?php echo $tomador_nome; ?></td>
						<td align="center" bgcolor="<?php echo $bgcolor;?>">
							<?php 
								switch ($estado) { 
									case "C": echo "Cancelado";     break;
									case "N": echo "Normal";        break;
									case "B": echo "Boleto Gerado"; break;
									case "E": echo "Escriturada";   break;
								} 
							?>
						</td>
						<td bgcolor="#FFFFFF" colspan="2">
							<input type="button" name="btImp" id="btImp" value="" title="Imprimir nota" onclick="window.open('imprimir.php?CODIGO=<?php echo $crypto; ?>')" />
							<?php
							if ($estado != "C") {
							?>
							<input name="btCanc" type="button" class="botao" value="" id="btX" 
							onclick="VisualizarNovaLinha('<?php echo $codigo;?>','<?php echo"tdnfecont".$x;?>',this,'inc/notas_motivo_cancelar.php')" 
							title="Cancelar nota"/>
							<?php }?>
						</td>
					</tr>
					<tr>
						<td colspan="7" id="<?php echo"tdnfecont".$x; ?>" height="1" bgcolor="#999999"></td>
					</tr>
					<?php	$x++;
						} // fim while 
					}else{
					?>
					<tr>
						<td align="center" colspan="9">Não houve nenhum resultado!</td>
					</tr>
					<?php
					}?>
				</table>
			</td>
		</tr>
		<tr>
			<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
		</tr>
	</table>
</form>