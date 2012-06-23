 <?php
 
 $nroservicos = 5;
 $contservico = 1;
 
 while($contservico <= $nroservicos) {

 ?>

  <tr id="linha01servico<?php echo $contservico; ?>" style="display:none">	    	     	
	<td height="0"></td>
  </tr>
  <tr id="camposservico<?php echo $contservico; ?>" style="display:none">	    
    <td align="left" bgcolor="#999999">
	 <?php
	  $sql_maxcodcat=mysql_query("SELECT MAX(codigo) FROM servicos_categorias");
	  list($maxcodcat)=mysql_fetch_array($sql_maxcodcat);
	  ?>
	  
	 <select name="cmbCategoria<?php echo $contservico; ?>" id="cmbCategoria<?php echo $contservico; ?>" onchange="ServicosCategorias(this);" style="width:440px;">
     <option value=""></option>
	  <?php	    
	  
	  
	  $sql_categoria = mysql_query("SELECT codigo, nome FROM servicos_categorias");
	  while(list($codcat,$nomecat)=mysql_fetch_array($sql_categoria))
	  {	  
	    print("<option value=\"$codcat|$contservico|$maxcodcat\">$nomecat</option>");
	  }
	  ?>	
	 </select>
	 
	 <input type="button" name="btexcluiServico<?php echo "|".$maxcodcat."|".$contservico; ?>" class="botao" value="X" onclick="excluirServico(this);"/>
	 
	 <?php
	 $sql_categoria = mysql_query("SELECT codigo,nome FROM servicos_categorias");
	 while(list($codcategoria)=mysql_fetch_array($sql_categoria))
	 {?>
		 <div id="div<?php echo $codcategoria.$contservico;?>" style="display:none">
		 <?php
			$sql_servicos = mysql_query("
					SELECT 
						codigo,
						codservico,
						descricao,
						aliquota,
						estado
					FROM 
						servicos
					WHERE 
						estado = 'A' AND codcategoria = '$codcategoria' 
					ORDER BY 
						codservico
						");
		 ?>
		 <select name="cmbCodigo<?php echo $codcategoria.$contservico; ?>" id="cmbCodigo<?php echo $codcategoria.$contservico; ?>" style="width:440px">
		   <option value="">Código | Descrição | Aliquota %</option>
		   <?php	   
		   while(list($codigo, $codservico, $descricao, $aliquota, $estado) = mysql_fetch_array($sql_servicos)) {
				print("<option value=$codigo>$codservico | ".substr($descricao,0,70)."... | $aliquota</option>");
		   }
		   ?>
		 </select>
		 </div>
	 <?php 
	 } ?>	 	 
	 
	 <input type="hidden" value="<?php print $maxcodcat?>" name="txtMAXCODIGOCAT" />
	 <input type="hidden" value="<?php print $nroservicos?>" name="txtNumeroServicos" />
	 <input type="hidden" value="<?php print $contservico?>" name="txtContServicos" />	 
	</td>       
  </tr>
  <tr id="linha02socio<?php echo $contservico; ?>" style="display:none">	    	     	
	<td height="0"></td>
  </tr>  
<?php
	$contservico++;
}

?>