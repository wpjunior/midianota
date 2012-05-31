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
$codcontador=$_POST['COD'];
$sql_contador=mysql_query("SELECT nome FROM emissores WHERE codigo='$codcontador'");
list($nome)=mysql_fetch_array($sql_contador);

?>   
   <fieldset><legend>Contador: <font color="#FF0000"><?php echo $nome; ?></font></legend>
   <table width="100%">    
    <tr>
		<td colspan="2" align="center" bgcolor="#FFFFFF">Clientes</td>
	</tr>
    <tr> 
	 <td width="40%" align="center">Nome</td>
	 <td width="20%" align="center">Cpf/Cnpj</td>
    </tr>	
	<?php 
	$sql=mysql_query("SELECT nome,cnpjcpf FROM emissores WHERE codcontador='$codcontador'");
	while(list($nome,$cpfcnpj)=mysql_fetch_array($sql)) 
	{	
	 ?>
     <tr> 
	  <td align="left" bgcolor="#FFFFFF">     
	    &nbsp;<?php echo $nome; ?>      </td>
	  <td align="center" bgcolor="#FFFFFF"> 
	    <?php echo $cpfcnpj; ?>
      </td>	  
     </tr>  
	 <?php
	 } 
	 ?>    	 
   </table>  
   </fieldset>