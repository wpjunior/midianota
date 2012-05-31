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
require_once("../conect.php");
require_once("../nocache.php");
require_once("../../funcoes/util.php");
//Recebe as variaveis do formulário
$buscadescservicos = $_GET['txtBuscaDescServicos'];
$buscacodservicos =  $_GET['txtBuscaCodServicos'];
$buscacategoria=$_GET['cmbCategorias'];
$buscatipopessoa=$_GET['cmbTipoPessoa'];
$buscaaliq=$_GET['txtBuscaAliquota'];
$buscaaliqir=$_GET['txtBuscaAliquotaIR'];
$buscabase=$_GET['txtBuscaBaseCalculo'];
$buscainc=$_GET['cmbBuscaIncidencia'];
$buscadiavenc=$_GET['txtBuscaDiaVencimento'];
$buscadoc=$_GET['cmbBuscaDocFiscal'];
$estado=$_GET['cmbEstado'];

//testa se os campos tem valor, se tiver acrescenta a pesquisa sql e uni tudo com implode
$sql_where="";
if($buscadescservicos){
	$sql_where[]="descricao LIKE '%$buscadescservicos%'";
}
if($buscacodservicos){
	$sql_where[]="codservico LIKE '$buscacodservicos'";
}
if($buscacategoria){
	$sql_where[]="codcategoria='$buscacategoria'";
}
if($buscatipopessoa){
	$sql_where[]="tipopessoa='$buscatipopessoa'";
}
if($buscaaliq){
	$sql_where[]="aliquota='$buscaaliq'";
}
if($buscaaliqir){
	$sql_where[]="aliquotair='$buscaaliqir'";
}
if($buscabase){
	$sql_where[]="basecalculo='$buscabase'";
}
if($buscainc){
	$sql_where[]="incidencia='$buscainc'";
}
if($buscadiavenc){
	$sql_where[]="datavenc='$buscadiavenc'";
}
if($buscadoc){
	$sql_where[]="docfiscal='$buscadoc'";
}
if($estado){
	$sql_where[]="estado='$estado'";
}

if($sql_where){
	$sql_where="WHERE ".implode($sql_where," AND ");
}
?>
<fieldset><legend>Resultado da Pesquisa</legend>      
<?php
$query=("
				SELECT
					estado,
					codservico,
					descricao,
					aliquota,
					aliquotair,
					codigo
				FROM
					servicos
				$sql_where
				ORDER BY
					descricao
				");
$sql=Paginacao($query,'frmBusca','dvResult',10);
if(mysql_num_rows($sql)>0){
?> 
<input type="hidden" name="include" id="include" value="<?php echo  $_GET['include'];?>" />
<input type="hidden" name="COD" id="COD" />
 <table width="100%" border="0" cellpadding="0" cellspacing="0" >  
  <tr>
    <td align="center"><b>Código</b></td>
    <td align="center"><b>Serviço</b></td>
    <td align="center"><b>Aliq %</b></td>
	<td align="center"><b>Aliq IR%</b></td>
    <td align="center"><b>Estado</b></td>
    <td align="center"><b>Editar</b></td>
  </tr>
  <tr>
  	<td colspan="6" bgcolor="#999999" height="1">  </tr> 

<?php 


while(list($estado,$codservico,$descricao,$aliquota,$aliquotair,$codigo)=mysql_fetch_array($sql)){ 
	//Renomeia o estado do serviço 
	if($estado == 'A'){
	 $estado = "Ativo";
	}
	else{
	 $estado = "Inativo"; 
	}
	 
	?>
	  <tr>
		<td align="center"  bgcolor="#FFFFFF"><?php echo $codservico; ?></td>
		<td align="left"  bgcolor="#FFFFFF"><?php echo ResumeString($descricao,55); ?></td>
		<td align="center"  bgcolor="#FFFFFF"><?php echo $aliquota; ?></td>
		<td align="center"  bgcolor="#FFFFFF"><?php echo $aliquotair; ?></td>	
		<td align="center"  bgcolor="#FFFFFF"><?php echo $estado; ?></td>
		<td align="center">
			<a onclick="
				document.getElementById('COD').value='<?php echo $codigo; ?>';
				var input = document.createElement('input');
				input.setAttribute('type', 'hidden');
				input.setAttribute('name', 'servicos');
				input.setAttribute('value', 'Pesquisar');
				document.getElementById('frmBusca').appendChild(input);
				document.getElementById('frmBusca').submit();
			">
				<img src="img/botoes/botao_editar.jpg" style="border:none"/>
			</a>
		</td>
	  </tr>
	  <tr>
		<td colspan=6 bgcolor=#999999 height=1></td>
	  </tr>     
	 <?php
}
?> 
 </table>
</form>
</fieldset>
<?php
}else{
	echo "
		<table width=\"100%\">
			<tr>
				<td align=\"center\"><b>Não houve resultados</b></td>
			</tr>
		</table>";
}
?>
