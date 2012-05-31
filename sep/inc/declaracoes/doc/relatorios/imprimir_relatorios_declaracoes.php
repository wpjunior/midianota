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
require_once("../../conect.php");
require_once("../../../funcoes/util.php");
require_once("../../nocache.php");

//Recebe as variaveis enviadas pelo form por get
$nome    = $_POST['txtNome'];
$cnpj    = $_POST['txtCNPJ'];
$compmes = $_POST['cmbMes'];
$compano = $_POST['cmbAno'];
$dataini = $_POST['txtDataIni'];
$datafim = $_POST['txtDataFim'];
$estado  = $_POST['cmbEstado'];
$numero  = $_POST['txtNroDop'];


//verifica quais campos foram preenchidos e concatena na variavel str_where
if($compmes){
	$str_where = " AND MONTH(doc_des.competencia) = '$compmes'";
}
if($compano){
	$str_where .= " AND YEAR(doc_des.competencia) = '$compano'";
}
if($dataini){
	$dataini = DataMysql($dataini);
	$str_where .= " AND doc_des.data_gerado >= '$dataini'";
}
if($datafim){
	$datafim = DataMysql($datafim);
	$str_where .= " AND doc_des.data <= '$datafim'";
}
if($cnpj){
	$str_where .= " AND operadoras_creditos.cnpj = '$cnpj'";
}
if($estado){
	$str_where .= " AND doc_des.estado = '$estado'";
}
if($numero){
	$str_where .= " AND doc_des.codigo = '$numero'";
}
	
$sql = mysql_query("
			SELECT 
				doc_des.codigo,
				DATE_FORMAT(doc_des.data,'%d/%m/%Y'),
				doc_des.total,
				doc_des.codverificacao,
				doc_des.estado,
				DATE_FORMAT(doc_des.competencia,'%m/%Y'),
				operadoras_creditos.nome
			FROM 
				doc_des
			INNER JOIN
				operadoras_creditos ON doc_des.codopr_credito = operadoras_creditos.codigo
			WHERE 
				(operadoras_creditos.nome LIKE '$nome%' OR operadoras_creditos.razaosocial LIKE '$nome%') $str_where
			ORDER BY 
				doc_des.codigo
			DESC
		");
	
switch($estado){
	case "B": $estado = "Boleto";      break;
	case "N": $estado = "Normal";      break;
	case "C": $estado = "Cancelada";   break;
	case "E": $estado = "Escriturada"; break;		
}
?>
<link href="../../../css/padrao.css" rel="stylesheet" type="text/css">
<script src="../../scripts/padrao.js" type="text/javascript"></script>
<title>Relatorios - Operadoras de Cr&eacute;ditos</title>
<input name="btImprimir" id="btImprimir" type="button" class="botao" value="Imprimir" onClick="document.getElementById('btImprimir').style.display = 'none';print();">
<p style="font:Verdana, Arial, Helvetica, sans-serif; font-size:20px"><b>Relatório de Declara&ccedil;&otilde;es de Operadoras de Cr&eacute;ditos</b></p>
<table>
	<?php if($nome){?>
	<tr>
		<td><b>Nome:</b></td>
		<td><?php echo $nome; ?></td>
	</tr>
	<?php } if($cnpj){ ?>
	<tr>
		<td><b>CNPJ:</b></td>
		<td><?php echo $cnpj; ?></td>
	</tr>
	<?php } 
	if($compmes&&$compano){
	?>
	<tr>
		<td><b>Competência:</b></td>
		<td><?php echo "$compmes/$compano"; ?></td>
	</tr>
	<?php
	}else{
		if($compmes){ ?>
	<tr>
		<td><b>Mês de competência:</b></td>
		<td><?php echo $compmes; ?></td>
	</tr>
	<?php } if($compano){ ?>
	<tr>
		<td><b>Ano de competência:</b></td>
		<td><?php echo $compano; ?></td>
	</tr>
	<?php }
	}//fim if compmes e compano
	if($dataini){ ?>
	<tr>
		<td><b>A partir da data:</b></td>
		<td><?php echo DataPt($dataini); ?></td>
	</tr>
	<?php } if($datafim){ ?>
	<tr>
		<td><b>Até a data:</b></td>
		<td><?php echo DataPt($datafim); ?></td>
	</tr>
	<?php } if($estado){ ?>
	<tr>
		<td><b>Estado:</b></td>
		<td><?php echo $estado; ?></td>
	</tr>
	<?php } if($numero){ ?>
	<tr>
		<td><b>N° DOC:</b></td>
		<td><?php echo $numero; ?></td>
	</tr>
	<?php }?>
	<tr>
		<td colspan="2"><strong>
		<?php 
		if(mysql_num_rows($sql)>1){
		echo mysql_num_rows($sql); ?> Declarações registradas
		<?php }else{
			echo "1 Declaração encontrada";
		} ?>
		</strong></td>
	</tr>
</table>
<br />
<table width="750" bordercolor="#000000" border="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
    <tr>
        <td width="6%" align="center">N&deg; Dec</td>
        <td width="12%" align="center">Cod verificação</td>
        <td width="35%" align="center">Nome</td>
        <td width="8%" align="center">Total</td>
        <td width="11%" align="center">Data</td>
        <td width="11%" align="center">Competencia</td>
        <td width="10%" align="center">Estado</td>
    </tr>
    <tr>
    	<td colspan="8"><hr color="#000000" size="2" /></td>
    </tr>
    <?php
		while(list($codigo,$data,$total,$codverificacao,$estado,$competencia,$nome) = mysql_fetch_array($sql)){
			switch($estado){
				case "B": $estado = "Boleto";      break;
				case "N": $estado = "Normal";      break;
				case "C": $estado = "Cancelada";   break;
				case "E": $estado = "Escriturada"; break;		
			}
	?>
    <tr bgcolor="#FFFFFF">
        <td align="center"><?php echo $codigo;?></td>
        <td align="center"><?php echo $codverificacao;?></td>
        <td align="left"><?php echo $nome;?></td>
        <td align="center"><?php echo DecToMoeda($total);?></td>
        <td align="center"><?php echo $data;?></td>
        <td align="center"><?php echo $competencia;?></td>
        <td align="center"><?php echo $estado;?></td>
    </tr>
    <?php
		}//fim while
	?>
</table>
