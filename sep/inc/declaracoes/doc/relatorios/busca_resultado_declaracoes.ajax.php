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
require_once('../../conect.php');
require_once('../../../funcoes/util.php');
require_once("../../nocache.php");

//Recebe as variaveis enviadas pelo form por get
$nome    = $_GET['txtNome'];
$cnpj    = $_GET['txtCNPJ'];
$compmes = $_GET['cmbMes'];
$compano = $_GET['cmbAno'];
$dataini = $_GET['txtDataIni'];
$datafim = $_GET['txtDataFim'];
$estado  = $_GET['cmbEstado'];
$numero  = $_GET['txtNroDop'];


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
}?>
    
<fieldset>
<legend>Resultado</legend>
<?php	
	//Sql buscando as informações que o usuario pediu e com o limit estipulado pela função
	$query=("
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
		
$sql = Paginacao($query,'frmRelatorio','divBuscar',10);
if(mysql_num_rows($sql)>0){
?>
	<table width="100%">
    	<tr>
        	<td align="left">
            	<input name="btImprimir" type="submit" class="botao" value="Imprimir" 
                onclick="cancelaAction('frmRelatorio','inc/operadorascreditos/relatorios/imprimir_relatorios_declaracoes.php','_blank')" />
            </td>
        </tr>
    </table>
<table width="100%">
    <tr bgcolor="#999999">
        <td width="6%" align="center">N&deg; Dec</td>
        <td width="12%" align="center">Cod verificação</td>
        <td width="35%" align="center">Nome</td>
        <td width="8%" align="center">Total</td>
        <td width="11%" align="center">Data</td>
        <td width="11%" align="center">Competencia</td>
        <td width="10%" align="center">Estado</td>
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
<?php
}else{
	echo "<center><b>Nenhum resultado encontrado</b></center>";
}
?>
</fieldset>
