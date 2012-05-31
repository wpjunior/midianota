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
<!-- Formulário com o filtro de empresas------------------------->
<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
  <tr>
    <td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
    <td width="800" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;Prestadores - Contadores</td>  
    <td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
  </tr>
  <tr>
    <td width="18" background="img/form/lateralesq.jpg"></td>
    <td align="center">
   <form action="" method="post" name="frmPesquisar">
   <input type="hidden" name="include" id="include" value="<?php echo $_POST['include']; ?>">
   <fieldset>
   <legend>Pesquisa</legend>
   <table width="100%">
    <tr> 
	 <td align="left">
      Nome     </td> 
     <td align="left">
      <input type="text" name="txtBuscaNome" class="texto" >     </td> 
	</tr>
	<tr> 
	 <td align="left">
	  Cnpj/Cpf     </td>
     <td align="left">
      <input name="txtBuscaCnpj" type="text" maxlength="18" size="20" id="txtBuscaCnpj" class="texto"  onkeydown="stopMsk( event );" onkeypress="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );" /> 
      <em>Somente n&uacute;meros</em> </td>
	</tr>
	<tr>       
     <td align="left" colspan="2">
      <input type="submit" value="Procurar" class="botao" name="btPesquisarEmpresa" >     </td>
    </tr>
   </table>
   </fieldset>
   </form>


<?php 
//Verifica se o botao de busca empresa foi acionado, se for mostra o resultado da pesquisa
if($_POST['btPesquisarEmpresa'] == "Procurar")
{  
 $sql_buscaempresa=mysql_query("SELECT emissores.codigo, emissores.nome, emissores.cnpjcpf, emissores.estado FROM emissores 
 INNER JOIN usuarios ON emissores.cnpjcpf=usuarios.login WHERE emissores.nome LIKE '$txtBuscaNome%' AND emissores.cnpjcpf LIKE '$txtBuscaCnpj%' AND usuarios.tipo='contador' ORDER BY emissores.nome ASC ");
?>
   <form id="frmClientes" method="post"> 
   	<input type="hidden" name="include" id="include" value="<?php echo $_POST['include']; ?>">
	<input type="hidden" name="COD" id="COD">
   </form> 
<?php 
	include("inc/prestadores/contadores_lista.php");
}
if($_POST['COD']){	
	include('inc/prestadores/contadores_listacliente.php');
}	
?>



     
	</td>
	<td width="19" background="img/form/lateraldir.jpg"></td>
  </tr>
  <tr>
    <td align="left" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantoesq.jpg" /></td>
    <td background="img/form/rodape_fundo.jpg"></td>
    <td align="right" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantodir.jpg" /></td>
  </tr>
</table>


