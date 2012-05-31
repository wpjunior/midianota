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

$sql=mysql_query("
				SELECT 
					codigo,numero,tomador_nome,valoriss,estado, 
					DATE_FORMAT(datahoraemissao,'%d/%m/%Y')
				FROM 
					notas 
				WHERE 
					YEAR(datahoraemissao)='$cmbAno' AND 
					MONTH(datahoraemissao)='$cmbMes' AND 
					codemissor='$CODIGO_DA_EMPRESA' AND 
					estado != 'C' AND
					estado != 'E'
				");

$sql01=mysql_query("SELECT codbanco FROM boleto");
list($BANCOMONETARIO)=mysql_fetch_array($sql01);
 
if($BANCOMONETARIO ==""){
	print("<center>a Prefeitura não definiu qual o banco monetário, favor entre em contato com a prefeitura</center>");
}elseif(mysql_num_rows($sql) ==""){
	print("<center>Sem resultados</center>");
}else{
	   
	   echo"<form  method=\"post\" onsubmit=\"return ConfirmaForm(); \">";	?>
	   
		<table width="450" align="center" cellpadding="0" cellspacing="1" border="0">
			<tr>
				<td colspan="3" align="right"><font color="#FF0000">Selecionar todas as notas</font></td>
				<td><input type="checkbox" name="ckTodos" id="ckTodos" onclick="GuiaPagamento_TotalISS()"></td>
			</tr>
			<tr >    	
				<td bgcolor="#999999">
				  <b>Data:</b>
				</td>
				<td bgcolor="#999999">
				  <b>Tomador</b>
				</td>
				<td bgcolor="#999999">
				  <b>ISS</b>
				</td>
				<td bgcolor="#999999">
				  
				</td>
			</tr>
			
			<?php
			$total_iss=0;
			$cont=0;
			while(list($codigo,$numero,$tomador,$iss,$estadoNota,$data)=mysql_fetch_array($sql))
			{
				
				print"
				 <tr bgcolor='#FFFFFF'>			
					<td align=\"left\">
					  $data
					</td>
					<td align=\"left\">
					  $tomador
					</td>
					<td>
					  $iss
					</td>
					<td>";
					  if($estadoNota == "N")
					  {
					    print"<input type=\"checkbox\" name=\"ckISS\" id=\"ckISS$cont\" value=\"$iss|$codigo\" onclick=\"GuiaPagamento_SomaISS(this)\">
					         <input type=\"hidden\" name=\"txtCodNota$cont\" id=\"txtCodNota$cont\" />";
					    $total_iss += $iss;	
						$cont++;	 
					  }
					  elseif($estadoNota == "B")		  
					  {
					    print "<font color=\"red\">Pendente</font>";
					  }
					 print" 
					</td>
				 </tr>";
				 
			}
			$total_iss = number_format($total_iss,2, ',', '.'); ?>	
		</table>
		
		<br>
		
		 <table width="350" align="center" cellpadding="0" cellspacing="0" border="0">	
			<tr>
				<td colspan="2" align="right">Total:</td>
				<td align="letf" width="62%">				 
				 <input type="hidden" value="<?php echo $total_iss."|".($cont-1); ?>" name="txtTotalIssHidden" id="txtTotalIssHidden"/>
				 <input type="hidden" class="texto" name="txtLogin" value="<?php print $_SESSION['login'];?>">
				 <input type="hidden" class="texto" name="txtNome" value="<?php print $_SESSION['nome'];?>">
				 <input type="text" class="texto" name="txtTotalIss" id="txtTotalIss" value="0" readonly="yes" >
				 <input type="submit" class="botao" value="Boleto" name="btEnviaBoleto" />
			   </td>				
			</tr>
		</table>
		</form>
<?php

}

?>	