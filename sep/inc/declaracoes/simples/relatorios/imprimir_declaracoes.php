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
	//da include dos principais arquivos
	require_once("../../conect.php");
	require_once("../../../funcoes/util.php");
	require_once("../../nocache.php");
	
	if(isset($_POST)){
		$nome    = $_POST['txtNome'];
		$cnpj    = $_POST['txtCNPJ'];
		$compmes = $_POST['cmbMes'];
		$compano = $_POST['cmbAno'];
		$dataini = $_POST['txtDataIni'];
		$datafim = $_POST['txtDataFim'];
		$estado  = $_POST['cmbEstado'];
		$numero  = $_POST['txtNroDecc'];
	}
	switch($estado){
		case "B": $str_estado = "Boleto";      break;
		case "N": $str_estado = "Normal";      break;
		case "C": $str_estado = "Cancelada";   break;
		case "E": $str_estado = "Escriturada"; break;		
	}
	
	
	//verifica quais campos foram preenchidos e concatena na variavel str_where
	if($compmes){
		$str_where = " AND MONTH(decc_des.competencia) = '$compmes'";
	}
	if($compano){
		$str_where .= " AND YEAR(decc_des.competencia) = '$compano'";
	}
	if($dataini){
		$dataini = DataMysql($dataini);
		$str_where .= " AND decc_des.data >= '$dataini'";
	}
	if($datafim){
		$datafim = DataMysql($datafim);
		$str_where .= " AND decc_des.data <= '$datafim'";
	}
	if($cnpj){
		$str_where .= " AND empreiteiras.cnpj = '$cnpj'";
	}
	if($estado){
		$str_where .= " AND decc_des.estado = '$estado'";
	}
	if($numero){
		$str_where .= " AND decc_des.codigo = '$numero'";
	}
	
	
?>
<link href="../../../css/padrao.css" rel="stylesheet" type="text/css">
<title>Imprimir</title><input name="btImprimir" id="btImprimir" type="button" class="botao" value="Imprimir" onClick="document.getElementById('btImprimir').style.display = 'none';print();">
	<table width="850">
    	<tr>
        	<td><b><font size="4">Relatório de Declarações</font></b></td>
        </tr>
        <?php
			if($nome){
		?>
        <tr>
        	<td width="132"><b>Nome da Obra: </b><?php echo $nome;?></td>
        </tr>
        <?php
        	}
			if($cnpj){
		?>
        <tr>
        	<td width="132"><b>CNPJ: </b><?php echo $cnpj;?></td>
        </tr>
        <?php
        	}
		if(($compmes)&&($compano)){
		?>
		<tr>
			<td><b>Competência:</b> <?php echo "$compmes/$compano"; ?></td>
		</tr>
		<?php
		}else{
			if($compmes){ ?>
		<tr>
			<td><b>Mês de competência:</b> <?php echo $compmes; ?></td>
		</tr>
		<?php } if($compano){ ?>
		<tr>
			<td><b>Ano de competência:</b> <?php echo $compano; ?></td>
		</tr>
		<?php }
		}//fim if compmes e compano
			if($dataini){
		?>
        <tr>
        	<td width="132"><b>Data de inicio: </b><?php echo $dataini;?></td>
        </tr>
        <?php
        	}
			if($datafim){
		?>
        <tr>
        	<td width="132"><b>Data de termino: </b><?php echo $datafim;?></td>
        </tr>
        <?php
        	}
			if($estado){
		?>
        <tr>
        	<td width="132"><b>Estado: </b><?php echo $str_estado;?></td>
        </tr>
        <?php
        	}
			if($numero){
		?>
        <tr>
        	<td width="132"><b>Número Decc: </b><?php echo $numero;?></td>
        </tr>
        <?php
        	}
		?>
    </table>
    <?php
	$sql_pesquisa = mysql_query("
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
						
if(mysql_num_rows($sql_pesquisa)){
?>
<table width="850" bordercolor="#000000" border="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; border-width:thin;">
    <tr>
        <td width="6%" align="center"><b>N&deg; Dec</b></td>
        <td width="14%" align="center"><b>Cod verificação</b></td>
        <td width="33%" align="center"><b>Nome</b></td>
        <td width="8%" align="center"><b>Total</b></td>
        <td width="7%" align="center"><b>Iss</b></td>
        <td width="11%" align="center"><b>Data</b></td>
        <td width="11%" align="center"><b>Competencia</b></td>
        <td width="10%" align="center"><b>Estado</b></td>
    </tr>
    <tr>
    	<td colspan="8"><hr color="#000000" size="2" /></td>
    </tr>
    <?php
		while(list($codigo,$data,$total,$iss,$codverificacao,$estado,$competencia,$nome) = mysql_fetch_array($sql_pesquisa)){
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

