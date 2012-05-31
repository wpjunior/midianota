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
<fieldset><legend>Resultado da Pesquisa</legend>
   <table width="100%">    
    <tr> 
	 <td width="40%" align="center">Nome</td>
	 <td width="20%" align="center">Cpf/Cnpj</td>
	 <td width="10%" align="center">Estado</td>
	 <td width="10%" align="center">Nro de Clientes</td>
    </tr>
	
	<?php 
	// Troca caractere do estado da empresa para a palavra completa
	while(list($codigo, $nome, $cpfcnpj, $estado)=mysql_fetch_array($sql_buscaempresa)) 
	{
	 if($estado == "A")
	  $estado = "Ativo";
	 else
	  $estado = "Inativo";
	
	
	 ?>
     <tr> 
	  <td align="left" bgcolor="#FFFFFF">     
	    &nbsp;<?php echo $nome; ?>      </td>
	  <td align="center" bgcolor="#FFFFFF"> 
	    <?php echo $cpfcnpj; ?>
      </td>
	  <td align="center" bgcolor="#FFFFFF">
	    <?php echo $estado; ?> 
	  </td>
	  <td align="center" bgcolor="#FFFFFF">  
	   <a onclick="document.getElementById('COD').value='<?php echo $codigo;?>';document.getElementById('frmClientes').submit();" style="cursor:pointer">
		<?php       
            $sql_nroclientes = mysql_query("SELECT Count(emissores.nome) FROM emissores WHERE emissores.codcontador = $codigo"); 
            list($nroclientes) = mysql_fetch_array($sql_nroclientes);
            echo $nroclientes;      
        ?>       
       </a></td>
     </tr>  
	 <?php
	 } 
	 ?> 
   	 
   </table>  
   </fieldset>