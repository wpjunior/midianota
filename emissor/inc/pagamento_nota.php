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
<?php $login=$_SESSION['login']; ?>

   <!-- Formulario de pesquisa de pagamento  --->   
<table width="500" align="center" cellpadding="0" cellspacing="0">
<tr>
 <td>
  <fieldset style="width:500px"><legend>Informe</legend>
  <form  method="post" name="frmPagamento">   
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">	       
   <tr>
	<td align="left" width="30%">Período do Imposto</td>
	<td align="left" width="70%">
	<select name="cmbMes" id="cmbMes" class="combo">
	  <option value="">== Mês ==</option>
	  <option value="01">Janeiro</option>
	  <option value="02">Fevereiro</option>
	  <option value="03">Março</option>
	  <option value="04">Abril</option>
	  <option value="05">Maio</option>
	  <option value="06">Junho</option>
	  <option value="07">Julho</option>
	  <option value="08">Agosto</option>
	  <option value="09">Setembro</option>
	  <option value="10">Outubro</option>
	  <option value="11">Novembro</option>
	  <option value="12">Dezembro</option>
	</select> / 
	<select name="cmbAno" id="cmbAno" class="combo">
		<option value="">== Ano ==</option>
		<?php
			$year = date("Y");
			for($h=0; $h<5; $h++){
				$y = $year - $h;
				echo "<option value=\"$y\">$y</option>";
			}
		?>
	</select>
	</td>
   </tr>
   <tr>
     <td align="left">Escolha o banco: </td>
     <td align="left">
	 	<select name="cmbBanco" class="combo">
			<?php
				$sql_bancos = mysql_query("SELECT boleto.codbanco, bancos.banco FROM boleto INNER JOIN bancos ON boleto.codbanco = bancos.codigo");
				while(list($codbanco,$nomebanco) = mysql_fetch_array($sql_bancos)){
					echo "<option value=\"$codbanco\">$nomebanco</option>";
				}
			?>
		</select>
	 </td>
   </tr>
   <tr>	  
	<td colspan="2" align="center">
	 <input type="hidden" name="btOp" value="Gerar Guia"/>
	 <input type="submit" value="Pesquisar" name="btPesquisar" class="botao" onclick="return ValidaFormulario('cmbMes|cmbAno','Defina o mês e o ano')"></td>
   </tr>   
  </table>   
  </form>
  
  <?php  if($btPesquisar =="Pesquisar"){include("pagamento_resultado.php");} ?>  
  
  </fieldset>
 </td>
</tr>  
</table> 

<!-- Formulario de pesquisa de pagamento  --->
<!-- formulario gerado -->
<?php

     
?>   
<!-- formulario gerado -->  