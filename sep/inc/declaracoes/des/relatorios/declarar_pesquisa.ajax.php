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
	//Conecta ao banco
	require_once('../../conect.php');
	require_once('../../../funcoes/util.php');
	
	//Recebe as variaveis enviadas pelo form por get
	$nome    = $_GET['txtNome'];
	$cnpj    = $_GET['txtCNPJ'];
	$compmes = $_GET['cmbMes'];
	$compano = $_GET['cmbAno'];
	$dataini = $_GET['txtDataIni'];
	$datafim = $_GET['txtDataFim'];
	$estado  = $_GET['cmbEstado'];
	$numero  = $_GET['txtNroDecc'];
	
	
	//verifica quais campos foram preenchidos e concatena na variavel str_where
	if($compmes){
		$str_where = " AND MONTH(decc_des.competencia) = '$compmes'";
	}
	if($compano){
		$str_where .= " AND YEAR(decc_des.competencia) = '$compano'";
	}
	if($data){
		$data = DataMysql($data);
		$str_where .= " AND decc_des.data = '$data'";
	}
	if($cnpj){
		$str_where .= " AND empreiteiras.cnpj = '$cnpj'";
	}
	if($estado){
		$str_where .= " AND decc_des.estado = '$estado'";
	}
	if($numero){
		$str_where .= " AND decc_des.codigo = '$numero'";
	}?>
    
<fieldset><legend>Resultados</legend>
<?php	
	//Sql buscando as informações que o usuario pediu e com o limit estipulado pela função
	$query = ("
			SELECT 
				decc_des.codigo,
				decc_des.data,
				decc_des.total,
				decc_des.iss,
				decc_des.codverificacao,
				decc_des.estado,
				decc_des.competencia,
				empreiteiras.nome
			FROM 
				decc_des
			INNER JOIN
				empreiteiras ON decc_des.codempreiteira = empreiteiras.codigo
			WHERE 
				(empreiteiras.nome LIKE '$nome%' OR empreiteiras.razaosocial LIKE '$nome%') $str_where
			ORDER BY 
				decc_des.codigo
			DESC
			");
		
		$sql_declaracoes = Paginacao($query,'frmRelatorio','divgraficoDecc',10);
						
if(mysql_num_rows($sql_declaracoes)){
?>
	<table width="100%">
    	<tr>
        	<td align="left">
            	<input name="btImprimir" type="submit" class="botao" value="Imprimir" 
                onclick="cancelaAction('frmRelatorio','inc/empreiteiras/relatorios/imprimir_declaracoes.php','_blank')" />
            </td>
        </tr>
    </table>
<table width="100%">
    <tr bgcolor="#999999">
        <td width="6%" align="center">N&deg; Dec</td>
        <td width="12%" align="center">Cod verificação</td>
        <td width="35%" align="center">Nome</td>
        <td width="8%" align="center">Total</td>
        <td width="7%" align="center">Iss</td>
        <td width="11%" align="center">Data</td>
        <td width="11%" align="center">Competencia</td>
        <td width="10%" align="center">Estado</td>
    </tr>
    <?php
		while(list($codigo,$data,$total,$iss,$codverificacao,$estado,$competencia,$nome) = mysql_fetch_array($sql_declaracoes)){
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
        <td align="center"><?php echo DecToMoeda($iss);?></td>       
        <td align="center"><?php echo DataPt($data);?></td>
        <td align="center"><?php echo DataPt($competencia);?></td>
        <td align="center"><?php echo $estado;?></td>
    </tr>
    <?php
		}//fim while
	?>
</table>
<?php
}else{
	echo "<center><b>Não há resultados!</b></center>";
}
?>
</fieldset>
