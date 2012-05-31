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
 $nroservicos = 5;
 $contservico = 1;
 
 while($contservico <= $nroservicos) {
 	// sql para consultar o servico 
 ?>
<!------------------- SERVICO <?php print $contservico; ?> ------------------------------------------------------> 
  <tr id="linha01servico<?php echo $contservico; ?>" style="display:none">	    	     	
	<td height="0"></td>
  </tr>
  <tr id="camposservico<?php echo $contservico; ?>" style="display:none">	    
    <td align="left" bgcolor="#999999">
	 <?php
	  $sql_maxcodcat=mysql_query("SELECT MAX(codigo) FROM servicos_categorias");
	  list($maxcodcat)=mysql_fetch_array($sql_maxcodcat);
	  ?>
	  
	 <select name="cmbCategoria<?php echo $contservico; ?>" id="cmbCategoria<?php echo $contservico; ?>" onchange="ServicosCategorias(this);">
     <option value=""></option>
	  <?php	    
	  
	  
	  $sql_categoria=mysql_query("SELECT codigo,nome FROM servicos_categorias WHERE codigo = '32'");
	  while(list($codcat,$nomecat)=mysql_fetch_array($sql_categoria))
	  {	  
	    print("<option value=\"$codcat|$contservico|$maxcodcat\">$nomecat</option>");
	  }
	  ?>	
	 </select>
	 
	 <input type="button" name="btexcluiServico<?php echo "|".$maxcodcat."|".$contservico; ?>" class="botao" value="X" onclick="excluirServico(this);"/>
	 
	 <?php
	 $sql_categoria=mysql_query("SELECT codigo,nome FROM servicos_categorias");
	 while(list($codcategoria)=mysql_fetch_array($sql_categoria))
	 {?>
		 <div id="div<?php echo $codcategoria.$contservico;?>" style="display:none">
		 <?php
			$sql_servicos = mysql_query("SELECT codigo, codservico, descricao, aliquota, estado FROM servicos WHERE estado = 'A' AND codcategoria='$codcategoria'
			ORDER BY codservico"); 
		 ?>
		 <select name="cmbCodigo<?php echo $codcategoria.$contservico; ?>" id="cmbCodigo<?php echo $codcategoria.$contservico; ?>" style="width:440px">
		   <option value="">Código | Descrição | Aliquota %</option>
		   <?php	   
		   // laco para display das opcoes no combo
		   while(list($codigo, $codservico, $descricao, $aliquota, $estado) = mysql_fetch_array($sql_servicos)) {
				print("<option value=$codigo>$codservico | ".substr($descricao,0,70)."... | $aliquota</option>");
		   } // fecha while
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