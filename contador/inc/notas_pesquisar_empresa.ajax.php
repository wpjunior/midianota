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
	$cmbEmpresa = $_GET['cmbEmp'];	
	if($numero){
		$string = " AND `notas`.`numero` = '$numero' ";
	}
	if($tomador_cnpjcpf){
		$string .= " AND `notas`.`tomador_cnpjcpf` = '$tomador_cnpjcpf' ";
	}
	if($cmbEmpresaDefined){$cmbEmpresa=$cmbEmpresaDefined;}
	$query=("
		SELECT
			`notas`.`codigo`, 
			`notas`.`numero`, 
			`notas`.`codverificacao`,
			`notas`.`datahoraemissao`, 
			`notas`.`codemissor`, 
			`notas`.`tomador_nome`,
			`notas`.`tomador_cnpjcpf`, 
			`notas`.`estado`
			FROM
			`notas`
			WHERE
			`notas`.`codemissor` = '$cmbEmpresa' AND
			`notas`.`codverificacao` LIKE '$codverificacao%'   
			$string
			ORDER BY codigo DESC"); // fim sql
?>




<input type="hidden" name="cmbEmpresa" value="<?php echo $cmbEmpresa; ?>" />
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
    <tr>
      <td width="10" height="10" bgcolor="#FFFFFF"></td>
	  <td width="170" align="center" bgcolor="#FFFFFF" rowspan="3">Resultado de Pesquisa </td>
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
    <td width="14%" align="center">Cód Verif</td>
    <td width="15%" align="center">D/H Emissão</td>
    <td width="40%" align="center">Tomador Nome </td>
	<td width="14%" align="center">Estado</td>
    <td width="6%"></td>
    <td width="6%"></td>
  </tr>
  <tr>
    <td colspan="7" height="1" bgcolor="#999999"></td>
  </tr>
<?php	
	$x=0;
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
    <td align="center" bgcolor="<?php echo $bgcolor;?>"><?php 
		switch ($estado) { 
			case "C": echo "Cancelado"; break;
			case "N": echo "Normal"; break;
			case "B": echo "Boleto Gerado"; break;
			case "E": echo "Escriturada"; break;
		} 
	?></td>	
    <td bgcolor="#FFFFFF" colspan="2">
	<input type="button" name="btImp" id="btImp" value="" onclick="window.open('imprimir.php?CODIGO=<?php echo $crypto; ?>')" />
	<?php
	if ($estado != "C") {
	?>
	<?php /*?><a href="notas.php?btEmpresa=T&btPesquisar=Pesquisar&btCancelamento=T&y=<?php echo $crypto; ?>&emp=<?php echo base64_encode($cmbEmpresa);?>"><img title="Cancelar nota" src="../img/botoes/botao_cancelar.jpg" /></a><?php */?>
	<input name="btCanc" type="button" class="botao" value="" id="btX" onclick="VisualizarNovaLinha('<?php echo $codigo;?>','<?php echo"tdnfe".$x;?>',this,'inc/notas_motivo_cancelar.php?btEmpresa=T')" title="Cancelar nota"/>

	<?php
	} // fecha if
	?>
	</td>
  </tr>
  <tr>
    <td colspan="7" id="<?php echo"tdnfe".$x; ?>" height="1" bgcolor="#999999"></td>
  </tr> 
  <?php
  	$x++;
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
