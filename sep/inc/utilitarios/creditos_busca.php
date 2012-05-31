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
<script>
  function MostraDiv(iddiv1,iddiv2,inputshidden,inputs,display,cod)
  {   
   /*   
     EXEMPLO DE COMO CHAMAR A FUNCAO PARA ATUALIZACAO DE LISTAS
   MostraDiv('DIVOCULTA','DIVBLOCK','HIDDENS SEPARADOS POR |','CAMPOS SEPARADOS POR |','DISPLAY DA DIV','CODIGO|HIDDEN QUE GUARDA O CODIGO')
   */
   
   cod=cod.split("|");   
   document.getElementById(cod[1]).value=cod[0];
   inputshidden=inputshidden.split("|");
   var cont = inputshidden.length;   
   inputs=inputs.split("|");
      
   if(display =='block')
   {
    if(document.getElementById(inputshidden[0]).value)
	{
	  var div = document.getElementById(inputshidden[0]).value;
	  div =div.split('|');	  
	  document.getElementById(div[0]).style.display='none';
	  document.getElementById(div[1]).style.display='block';
	  for(x=1;x<cont;x++)
	  { 	      
	   document.getElementById(document.getElementById(inputshidden[x]).value).disabled=true;
	  } 
	}	
	  document.getElementById(inputshidden[0]).value =iddiv1+'|'+iddiv2+'|'+cont;
	  	  
	  for(x=1;x<cont;x++)
	  {   
	   document.getElementById(inputshidden[x]).value = inputs[x-1];
	   document.getElementById(inputs[x-1]).disabled=false;
	  } 
   }    
   document.getElementById(iddiv1).style.display=display;      
   if(display == 'block'){display='none';}else{display='block';}   
   document.getElementById(iddiv2).style.display=display;
  }
</script>

<?php 

if($_POST['btSalvarRegra'])
{
	$nro = explode("|",$_POST['hdDiv']);
	for($cont =0;$cont<$nro[2];$cont++)
	{
	  if(($_POST['txtCredito'.$cont])&&($_POST['rdTipoPessoa'.$cont])&&($_POST['rdIssRetido'.$cont])&&($_POST['txtValor'.$cont])&&($_POST['hdCodRegra']))
	  {
		$sql =mysql_query("UPDATE nfe_creditos SET credito='".$_POST['txtCredito'.$cont]."',tipopessoa='".$_POST['rdTipoPessoa'.$cont]."',issretido='".$_POST['rdIssRetido'.$cont]."',valor='".$_POST['txtValor'.$cont]."',estado='A' WHERE codigo='".$_POST['hdCodRegra']."'");	
		Mensagem("Regra atualizada com sucesso!!");
	  }
	
	}
}
elseif($_POST['btExcluirRegra'])
{
 mysql_query("DELETE FROM nfe_creditos WHERE codigo='".$_POST['hdCodRegra']."'");
 Mensagem("Regra excluida com sucesso !!");
}?>
<fieldset style="margin-left:10px; margin-right:10px;">
<legend>Lista de Regras</legend>
<br>
<form method="post"> 
<table width="100%" border="0">	
	<tr>
		<td align="center" width="13%">		  Crédito (%) </td>
    <td align="center" width="20%">	    Tipo Pessoa		</td>
    <td align="center" width="15%">	    ISS Retido		</td>
    <td align="center" width="20%">	    Valor	(R$)	</td>
	  <td align="center" width="16%">
		  
		</td>
		<td align="center" width="15%">
		  
		</td>
	</tr>
</table>
<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
<input type="hidden" name="btRegra" value="Pesquisar Regras" />
<input type="hidden" id="hddiv" name="hdDiv" />
<input type="hidden" id="hdcredito" />
<input type="hidden" id="hdtipopessoapj"/>
<input type="hidden" id="hdtipopessoapf"/>
<input type="hidden" id="hdissretidos"/>
<input type="hidden" id="hdissretidon"/>
<input type="hidden" id="hdvalor"/>
<input type="hidden" id="hdCodRegra" name="hdCodRegra"/>


	
 <?php 
 
   $sql=mysql_query("SELECT codigo,credito,tipopessoa,issretido,valor FROM nfe_creditos");
   $cont=0;
   while(list($codigo,$credito,$tipopessoa,$issretido,$valor)=mysql_fetch_array($sql))      
   {
     $issretidodisplay = $issretido=="S"?"Sim":"Não";     
	 $tipopessoadisplay = $tipopessoa == 'PF' ? 'Pessoa Física' : 'Pessoa Jurídica';   
	  echo"
	   
	   <div style=\"display:block\" id=\"DivBusca$cont\">	       
			   <table width=\"100%\" border=\"0\" cellspacing=\"1\">
				<tr>
					<td bgcolor=\"#ffffff\" align=\"center\"  width=\"13%\">
					  $credito 
					</td>
					<td bgcolor=\"#ffffff\" align=\"center\" width=\"20%\">
					  $tipopessoadisplay
					</td>
					<td bgcolor=\"#ffffff\" align=\"center\" width=\"15%\">
					  $issretidodisplay 
					</td>
					<td bgcolor=\"#ffffff\" align=\"right\" width=\"20%\">
					  ";echo DecToMoeda($valor); echo "&nbsp;
					</td>
					<td bgcolor=\"#ffffff\" align=\"center\" width=\"16%\">		  
					  <input type=\"button\" class=\"botao\" value=\"Atualizar\" name=\"btAtualizar\" id=\"btAtualizar\"					   onclick=\"MostraDiv('Div$cont','DivBusca$cont','hddiv|hdcredito|hdtipopessoapf|hdtipopessoapj|hdissretidos|hdissretidon|hdvalor','txtCredito$cont|rdTipoPessoaPF$cont|rdTipoPessoaPJ$cont|rdIssRetidoS$cont|rdIssRetidoN$cont|txtValor$cont','block','$codigo|hdCodRegra')\">
					</td>
					<td bgcolor=\"#ffffff\" align=\"center\" width=\"15%\">		  
					  <input type=\"submit\" class=\"botao\" name=\"btExcluirRegra\" value=\"Excluir\" onclick=\"document.getElementById('hdCodRegra').value='$codigo';return Confirma('Deseja excluir esta regra ?');\">
					</td>
				</tr>
				</table>
		</div>
		
		<div style=\"display:none\" id=\"Div$cont\">		        
				<table width=\"100%\" cellspacing=\"1\">
					<tr>
						<td bgcolor=\"#999999\" align=\"center\" width=\"13%\">
						  <input type=\"text\" class=\"texto\" value=\"$credito\" name=\"txtCredito$cont\" id=\"txtCredito$cont\" size=\"8\"
						  disabled=\"disabled\">
						</td>						
						<td bgcolor=\"#999999\" align=\"center\" width=\"20%\">
						  <input type=\"radio\" name=\"rdTipoPessoa$cont\" id=\"rdTipoPessoaPF$cont\" value=\"PF\" disabled=\"disabled\"";
						   if($tipopessoa =='PF'){echo" checked=\"checked\"";}echo">PF	
		   				  <input type=\"radio\" name=\"rdTipoPessoa$cont\" id=\"rdTipoPessoaPJ$cont\" value=\"PJ\" disabled=\"disabled\"";
						   if($tipopessoa =='PJ'){echo" checked=\"checked\"";}echo">PJ
						</td>
						<td bgcolor=\"#999999\" align=\"center\" width=\"15%\">
						  <input type=\"radio\" name=\"rdIssRetido$cont\" id=\"rdIssRetidoS$cont\" value=\"S\" disabled=\"disabled\"";
						   if($issretido =='S'){echo" checked=\"checked\"";}echo">S	
		   				  <input type=\"radio\" name=\"rdIssRetido$cont\" id=\"rdIssRetidoN$cont\" value=\"N\" disabled=\"disabled\"";
						   if($issretido =='N'){echo" checked=\"checked\"";}echo">N 
						</td>
						<td bgcolor=\"#999999\" align=\"center\" width=\"20%\">
						  <input type=\"text\" class=\"texto\" value=\"$valor\" size=\"13\" name=\"txtValor$cont\" id=\"txtValor$cont\" disabled=\"disabled\">
						</td>
						<td bgcolor=\"#999999\" align=\"center\" width=\"16%\">		  
						  <input type=\"submit\" name=\"btSalvarRegra\" class=\"botao\" value=\"Salvar\">
						</td>
						<td bgcolor=\"#999999\" align=\"center\" width=\"15%\">		  
						  <input type=\"button\" class=\"botao\" value=\"Cancelar\"						  onclick=\"MostraDiv('Div$cont','DivBusca$cont','hddiv|hdcredito|hdtipopessoapf|hdtipopessoapj|hdissretidos|hdissretidn|hdvalor','txtCredito$cont|rdTipoPessoaPF$cont|rdTipoPessoaPJ$cont|rdIssRetidoS$cont|rdIssRetidoN$cont|txtValor$cont','none','$codigo|hdCodRegra')\">
						</td>
			   		</tr> 
				</table>				
		</div>";
	 $cont++;	
	}	
  ?>
	
</form>
</fieldset>












