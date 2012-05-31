 <br/>
<?php
	include("../../../include/conect.php"); 
	include("../../../funcoes/util.php");
	
	$cnpj = $_GET['cnpj'];
	$ano  = $_GET['cmbAno'];
	$mes  = $_GET['cmbMes'];
	
    $sql = mysql_query("
        SELECT 
            cadastro.cpf,
            cadastro.cnpj,
			notas.codigo,
            notas.numero,
            notas.valortotal,
            notas.issretido,
			notas.codemissor
        FROM
            notas
        INNER JOIN
            cadastro ON cadastro.codigo = notas.codemissor
        WHERE
            notas.tomador_cnpjcpf = '$cnpj' AND 
			notas.issretido > 0 AND 
			notas.estado != 'E' AND
			MONTH(notas.datahoraemissao) = '$mes' AND 
			YEAR(notas.datahoraemissao) = '$ano'
    ");
    if(mysql_num_rows($sql)){
 ?>
<table width="100%" border="0" cellspacing="1">
	<tr bgcolor="#999999">
		<td colspan="5" align="center" > Dados dos Emissores: </td>
	</tr>
	<tr bgcolor="#999999">
		<td align="center"> Cnpj/Cpf </td>
		<td align="center"> Número Nota </td>
		<td align="center"> Valor Nota </td>
		<td align="center"> ISS Retido </td>
		<td></td>
	</tr>
	<?php
    while(list($cad_cpf,$cad_cnpj,$codigo,$numero,$valortotal,$issretido,$codemissor) = mysql_fetch_array($sql)){
        $cad_cnpjcpf = $cad_cpf.$cad_cnpj;
		
		$bgcolor = "bgcolor=\"#FFFFFF\"";
		$sql_verifica_emissao = mysql_query("
			SELECT 
				des_issretido_notas.coddes_issretido 
			FROM 
				des_issretido_notas 
			INNER JOIN
				notas ON notas.codemissor = des_issretido_notas.codemissor
			WHERE
				des_issretido_notas.codemissor = '$codemissor' AND nota_nro = '$numero'
		");
		list($codigo_des_issretido) = mysql_fetch_array($sql_verifica_emissao);
		
		$sql_estado = mysql_query("SELECT estado FROM des_issretido WHERE codigo = '$codigo_des_issretido'");
		list($estado_des_issretido) = mysql_fetch_array($sql_estado);
		if($estado_des_issretido != "N"){
			$bgcolor = "bgcolor=\"#FFAC84\"";
			$display = "style=\"display:none\"";
		}else{
			$bgcolor = "bgcolor=\"#FFFFFF\"";
			$display = "";
		}
		
		
		
    ?>
	<tr <?php echo $bgcolor;?>>
		<td align="center"><?php echo $cad_cnpjcpf;?></td>
		<td align="center"><?php echo $numero;?></td>
		<td align="center"><?php echo DecToMoeda($valortotal);?></td>
		<td align="center"><?php echo DecToMoeda($issretido);?></td>
		<td align="center"><input name="btGerarGuia" type="submit" value="Guia" class="botao" onclick="document.getElementById('hdCodigoGuia').value='<?php echo $codigo;?>'" <?php echo $display;?> /></td>
	</tr>
	<?php
    }
  ?>
  <input name="hdCodigoGuia" id="hdCodigoGuia" type="hidden" />
</table>
<?php
    }else{
        echo "<center><b>Não há declarações de serviços tomados!</b></center>";
    }
  ?>
</br>
</br>
