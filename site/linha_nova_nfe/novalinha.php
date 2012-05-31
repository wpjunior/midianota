<?php
	require_once("../../include/conect.php");
	$quantidade = $_GET['quantidade'];
	$codemissor = $_GET['codemissor'];
	
	$sql_servicos = mysql_query("
		SELECT 
			cadastro_servicos.codigo,
			servicos.codigo,
			servicos.codservico,
			servicos.descricao,
			servicos.aliquota, 
			servicos.aliquotair, 
			servicos.basecalculo 
		FROM 
			servicos
		INNER JOIN 
			cadastro_servicos ON servicos.codigo = cadastro_servicos.codservico
		WHERE 
			cadastro_servicos.codemissor = '$codemissor'
	");

?>
<table width="100%" id="tbl<?php echo $quantidade;?>">
	<tr bgcolor="#FFFFFF" align="center">
		<td width="33%">
		<select name="cmbCodServico<?php echo $quantidade;?>" style="width:200px;" id="cmbCodServico<?php echo $quantidade;?>" 
				onchange="MostraAliquota('txtAliqServico<?php echo $quantidade;?>','txtISSRetidoManual<?php echo $quantidade;?>','<?php echo $quantidade;?>');
				calculaISSNfe('hdInputs','<?php echo $quantidade;?>');" >
					<option value="0">Selecione o Serviço</option>	   	        
					<?php 
						while(list($codigo_empresas_servicos,$codigo,$codservico,$descricao,$aliquota,$issretido,$basecalculorpa)=mysql_fetch_array($sql_servicos))
							{	   
								print("<option value=\"$aliquota|$codigo|$issretido\"> $descricao </option>");
							}	
					?>
			</select>
		</td>
		<td width="20%">
			<input name="txtBaseCalcServico<?php echo $quantidade;?>" id="txtBaseCalcServico<?php echo $quantidade;?>" type="text" class="texto" size="10" 
			onkeyup="MaskMoeda(this);" onkeydown="return NumbersOnly(event);" 
			onblur="calculaISSNfe('hdInputs','<?php echo $quantidade;?>');" value="0,00" />
			<font color="#FF0000">*</font>
		</td>
		<td width="15%">
			<input name="txtAliqServico<?php echo $quantidade;?>" id="txtAliqServico<?php echo $quantidade;?>" type="text" class="texto" size="5" readonly="readonly" />
		</td>
		<td width="12%">
			<input name="txtValorIssServico<?php echo $quantidade;?>" id="txtValorIssServico<?php echo $quantidade;?>" type="text" class="texto" size="6" value="0,00" />
		</td>
		<td width="17%">
			<input name="txtISSRetidoManual<?php echo $quantidade;?>" id="txtISSRetidoManual<?php echo $quantidade;?>" type="text" class="texto" size="8" value="0,00" 
			onblur="calculaISSNfe('hdInputs','<?php echo $quantidade;?>')" onkeyup="MaskMoeda(this);" onkeydown="return NumbersOnly(event);" />
		</td>
	</tr>
</table>
