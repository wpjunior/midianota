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
 $nrosocios = 10;
 $cont = 1;
 
 while($cont <= $nrosocios) {
 
 ?>
<!------------------- SÓCIO <?php echo $cont; ?>------------------------------------------------------------------------------------------> 
  <tr id="linha01socio<?php echo $cont; ?>" style="display:none">	    	     	
	<td height="1" bgcolor="#CCCCCC"></td>
  </tr>
  <tr id="campossocio<?php echo $cont; ?>" style="display:none">	    
    <td align="left" bgcolor="#999999">&nbsp;<?php if($cont == 1){ echo "Nome do Responsável<br />";}else{ echo "Nome do Sócio<br>";}?>
	 <input type="text" size="40" maxlength="100" name="txtNomeSocio<?php echo $cont; ?>" id="txtNomeSocio<?php echo $cont; ?>" class="texto" /> CPF 
	 
	 <input type="text" size="14" maxlength="14" name="txtCpfSocio<?php echo $cont; ?>" id="txtCpfSocio<?php echo $cont; ?>" class="texto" />
	 <input type="button" name="btexcluiSocio<?php echo $cont; ?>" class="botao" value="X" onclick="excluirSocio();"/></td>       
  </tr>
  <tr id="linha02socio<?php echo $cont; ?>" style="display:none">	    	     	
	<td height="1" bgcolor="#CCCCCC"></td>
  </tr>  
<?php
	$cont++;
}
?>