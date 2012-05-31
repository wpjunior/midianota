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
<form method="post" id="frmConsultaRps">
	<input type="hidden" value="<?php echo $_POST['txtMenu'];?>" name="txtMenu">
	<table width="580" border="0" cellpadding="0" cellspacing="1">
        <tr>
			<td width="5%" height="10" bgcolor="#FFFFFF"></td>
	        <td width="50%" align="center" bgcolor="#FFFFFF" rowspan="3">Consulta Recibo Provis&oacute;rio de Servi&ccedil;os (RPS)</td>
	        <td width="45%" bgcolor="#FFFFFF"></td>
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

<table width="99%" border="0" align="center" cellpadding="5" cellspacing="0">
 <tr>
  <td width="30%" align="left">
   Número do RPS<font color="#FF0000">*</font>  </td>
  <td width="70%" align="left">
   <input type="text" name="txtNumeroRps" size="20" class="texto" />  </td>
 </tr>
 <tr> 
  <td align="left">
   Data do RPS<font color="#FF0000">*</font>  </td>
  <td align="left">
   <input type="text" name="txtDataRps" size="10" class="texto" maxlength="10" /> 
   (dd/mm/aaaa)  </td> 
 </tr>  
 <tr>
  <td align="left">
   Prestador CPF/CNPJ<font color="#FF0000">*</font>  </td>
  <td align="left">
   <input type="text" name="txtPrestCpfCnpj" id="txtPrestCpfCnpj" size="20" class="texto"  onkeydown="stopMsk( event ); return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );" />  </td> 
 </tr>
 <tr>
  <td align="left">
   Tomador CPF/CNPJ<font color="#FF0000">*</font>  </td>
  <td  align="left">
   <input type="text" name="txtTomCpfCnpj" id="txtTomCpfCnpj" size="20" class="texto"  onkeydown="stopMsk( event ); return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );"/>  </td> 
 </tr>
  <tr> 
  <td align="center">&nbsp;</td> 
  <td align="left"><font color="#FF0000">*</font> Dados obrigat&oacute;rios</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="left"><input type="submit" name="btConsulta" id="btConsulta" value="Consultar" class="botao" /></td>
  </tr>
</table>

		  </td>
		</tr>
		<tr>
	    	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
		</tr>
	</table> 
</form>
<?php 
	if($_POST['btConsulta'])
	{
		include('rps_consulta.php');		
	}
?>