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
	<table width="580" border="0" cellpadding="0" cellspacing="1">
        <tr>
			<td width="5%" height="10" bgcolor="#FFFFFF"></td>
	        <td width="30%" align="center" bgcolor="#FFFFFF" rowspan="3">Consulta de Reclamações</td>
	        <td width="65%" bgcolor="#FFFFFF"></td>
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

<form method="post">
	<input type="hidden" name="txtMenu" value="<?php echo $_POST['txtMenu'];?>" />
<table width="500" border="0" cellspacing="0" cellpadding="5">  
  <tr>
    <td align="left" width="300" background="../../img/index/index_oquee_fundo.jpg">
	 CPF/CNPJ do Tomador
	</td>   
	<td align="left" width="300" background="../../img/index/index_oquee_fundo.jpg">
	 <input type="text" name="txtCpfCnpjTomador" id="txtCpfCnpjTomador"  onkeydown="stopMsk( event );" onkeypress="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );" class="texto" >
	</td>   
  </tr>
   <tr>
    <td align="center"  background="../../img/index/index_oquee_fundo.jpg" colspan="2">
	  <input type="submit" name="btConsultar" value="Consultar" class="botao">
	</td> 	 
  </tr>	
</table>
</form>

<?php if($_POST['btConsultar'] !="")
{
  $sql=mysql_query("SELECT rps_numero,datareclamacao,estado FROM reclamacoes WHERE  tomador_cnpj='$txtCpfCnpjTomador'");
  $verifica = mysql_num_rows($sql);
  
 
  if($verifica >0)
  { 
?>
   <table width="500" border="0" cellspacing="0" cellpadding="5">
     <tr>
       <td background="../../img/index/index_oquee_fundo.jpg" align="center">
	     <b>Número RPS</b>
	   </td> 
	   <td background="../../img/index/index_oquee_fundo.jpg" align="center">
	     <b>Data da reclamação</b>
	   </td>
	   <td background="../../img/index/index_oquee_fundo.jpg" align="center">
	     <b>Estado da reclamação</b>
	   </td>  	 
     </tr>  
<?php
    while(list($numerorps,$data,$estado)=mysql_fetch_array($sql))
    { 
	 $data = implode("/",array_reverse(explode("-", $data)));?>
     
     <tr>
       <td background="../../img/index/index_oquee_fundo.jpg" align="center">
	     <?php echo $numerorps;?>
	   </td> 
	   <td background="../../img/index/index_oquee_fundo.jpg" align="center">
	     <?php echo $data;?>
	   </td>
	   <td background="../../img/index/index_oquee_fundo.jpg" align="center">
	     <?php echo $estado;?>
	   </td>  	 
     </tr>
	 <?php
    } 
	?>
	</table>
  
<?php
  }
  else
  {?>
    <table width="500" border="0" cellspacing="0" cellpadding="5">
	 <tr>
       <td background="../../img/index/index_oquee_fundo.jpg">
 	     <b>Reclamações não encontradas! Verifique os dados.</b>
	   </td>
     </tr>
	 </table>
	 <?php
  }
 










 
 }?>



		  </td>
		</tr>
		<tr>
	    	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
		</tr>
	</table>    









