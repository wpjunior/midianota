<?php
	if($_POST['btCancelarGuia'] != ""){
		$sql = mysql_query("
			SELECT 
			guias_declaracoes.codrelacionamento,
			guias_declaracoes.codguia
			FROM 
			guias_declaracoes 
			INNER JOIN 
			guia_pagamento ON guia_pagamento.codigo = guias_declaracoes.codguia
			WHERE 
			guia_pagamento.chavecontroledoc = '".$_POST['txtCodGuia']."'
		");
		list($COD_NOTA,$COD_GUIA) = mysql_fetch_array($sql);

		mysql_query("UPDATE notas SET estado = 'N' WHERE codigo = '$COD_NOTA'");

		mysql_query("DELETE FROM guia_pagamento WHERE codigo = '$COD_GUIA'");
		mysql_query("DELETE FROM guias_declaracoes WHERE codguia = '$COD_GUIA'");
		echo "<script>alert('Guia Cancelada');</script>";
		add_logs('Cancelou uma guia');
	}
  $sql=mysql_query("
  	SELECT 
		guia_pagamento.codigo,
		guia_pagamento.datavencimento,
		guia_pagamento.valor,
		guia_pagamento.chavecontroledoc,
		guia_pagamento.pago,
		guia_pagamento.nossonumero
	FROM 
		guia_pagamento 
	INNER JOIN
      guias_declaracoes ON guias_declaracoes.codguia = guia_pagamento.codigo
	INNER JOIN 
		notas ON notas.codigo = guias_declaracoes.codrelacionamento 
	WHERE 
		notas.codemissor = '$CODIGO_DA_EMPRESA' AND guias_declaracoes.relacionamento = 'nfe' 
	GROUP BY 
		guia_pagamento.chavecontroledoc 
	ORDER BY 
		guia_pagamento.pago ASC
	
	");
 ?>
 
<form method="post" onsubmit="return ConfirmaForm();">
<input type="hidden" name="btOp" value="Guias Emitidas" />
<input type="hidden" name="txtCodGuia" id="txtCodGuia" />
<table border="0" align="center" cellpadding="0" cellspacing="1">
    <tr>
      <td width="10" height="10" bgcolor="#FFFFFF"></td>
	  <td width="150" align="center" bgcolor="#FFFFFF" rowspan="3">Guias Emitidas</td>
      <td width="420" bgcolor="#FFFFFF"></td>
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

<table border="0" width="100%" cellpadding="2" cellspacing="2">
<?php
if(mysql_num_rows($sql)>0){
?>
 <tr bgcolor="#999999">
   <td width="217" align="center">
      <b>Vencimento</b>   </td>
   <td width="85" align="center">
      <b>Valor</b>   </td>
   <td width="109" align="center">
      <b>Nosso número</b>   </td>
   <td width="84">   </td>  
 </tr>
 <?php
 while(list($codigo,$data,$valor,$chavecontroledoc,$pago,$nossonumero)=mysql_fetch_array($sql))
 {
 ?>
 <tr <?php if($pago == "S"){ echo "bgcolor=\"#FFAC84\"";}else{ echo "bgcolor=\"#FFFFFF\"";}?>>
   <td align="center">
      <?php
	   $data = implode('/',array_reverse(explode("-",$data)));
	   echo $data; ?>
   </td>
   <td align="center">
     <?php echo DecToMoeda($valor); ?>
   </td>
   <td align="center">
     <?php echo $nossonumero; ?>
   </td>  
   <td align="center" bgcolor="#FFFFFF">
   		<input name="btImprimir" type="button" id="btImp" value=" " onclick="window.open('inc/segundavia.php?hdCodGuia=<?php echo $codigo;?>')" />
      <?php
	   if($pago =="N"){echo"<input type=\"submit\" value=' ' class=\"botao\" name=\"btCancelarGuia\" id=\"btX\"
	   onclick=\"document.getElementById('txtCodGuia').value='$chavecontroledoc'; \" ";}
	   elseif($pago =="S"){echo"<b><font color='red'>pago</font></b>";}
      ?>
   </td>
 </tr>
 <?php 
 }//fim while
}else{
?>
	<tr>
		<td align="center" colspan="4">Nao existem guias emitidas</td>
	</tr>
<?php
}
 ?>
</table>
	  </td>
	</tr>
	<tr>
    	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
	</tr>
</table>
</form>