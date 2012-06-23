<?php
	$codtipo = codtipo('contador');
	$sql = mysql_query("
		SELECT 
			codigo,
			nome
		FROM 
			cadastro
		WHERE
			codtipo = '$codtipo' AND (nome LIKE '$txtNome%' OR $campo = '$txtCNPJ')
		ORDER BY
			cadastro.nome
		");
	if(mysql_num_rows($sql)>0){			  
?>
<table width="100%" border="0" cellpadding="2" cellspacing="2" align="left">
		<tr>
			<td width="150">Defina o contador</td>
			<td width="2%">
				<select name="cmbContador">
					<?php
						while(list($codcontador,$nomecontador)=mysql_fetch_array($sql))
							{
								echo "<option value=\"$codcontador\">$nomecontador</option>";
							}				  
					?>	
				</select>
			</td>
			<td align="left"><input type="submit" name="btDefinirContador" class="botao" value="Definir" /></td>
		</tr>
</table>
<?php
}
	else{
		echo "<center>Nenhum contador cadastrado</center>";
	}
?>