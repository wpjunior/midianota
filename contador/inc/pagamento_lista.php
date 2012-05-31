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
		//usa o codigo encontrado com a pesquisa sql e efetua a a tualizacao
		mysql_query("UPDATE notas SET estado = 'N' WHERE codigo = '$COD_NOTA'");
		//deleta a guia de pagamento	
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
		guia_pagamento.pago 
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
		guia_pagamento.pago 
	ASC
	");
 ?>
 
<br />
<form method="post" onsubmit="return ConfirmaForm();">
<input type="hidden" name="btOp" value="Guias Emitidas" />
<input type="hidden" name="txtCodGuia" id="txtCodGuia" />

<table border="0" width="500" cellpadding="0" cellspacing="1">
<?php
if(mysql_num_rows($sql)>0){
?>
 <tr bgcolor="#999999">
   <td width="217" align="center">
      <b>Vencimento</b>   </td>
   <td width="85" align="center">
      <b>Valor</b>   </td>
   <td width="109" align="center">
      <b>N° controle</b>   </td>
   <td width="84">   </td>  
 </tr>
 <?php
 while(list($codigo,$data,$valor,$chavecontroledoc,$pago)=mysql_fetch_array($sql))
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
     <?php echo $chavecontroledoc; ?>
   </td>  
   <td align="center" bgcolor="#FFFFFF">
   	  <input name="btImprimir" type="button" id="btImp" value=" " onclick="window.open('inc/segundavia.php?hdCodGuia=<?php echo $codigo;?>')" 
	  title="Imprimir segunda via" />
      <?php
	   if($pago =="N"){
		   echo"<input type=\"submit\" value=' ' class=\"botao\" name=\"btCancelarGuia\" id=\"btX\"
		   onclick=\"document.getElementById('txtCodGuia').value='$chavecontroledoc';\" title=\"Cancelar guia\"> ";
	   }elseif($pago =="S"){
		   echo"<b><font color='red'>pago</font></b>";
	   }
      ?>
   </td>
 </tr>
 <?php 
 }//fim while
}else{
?>
	<tr>
		<td align="center" colspan="4">Não há guias emitidas</td>
	</tr>
<?php
}
 ?>
</table>
</form>