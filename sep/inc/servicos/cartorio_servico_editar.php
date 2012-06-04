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
//Recebe os dados do Formulário de alteração e faz o UPDATE no banco
if ($_POST['btCadastrar'] !=""){
	$Cod = $_POST['COD'];
	$Servicos =$_POST['txtEdDescServicos'];      
	$Aliquota = $_POST['txtEdAliquota'];
	$Estado = $_POST['TxtEstado'];   
   
	
	   
	$sql=mysql_query("
		SELECT 
			servicos,
			aliquota,
			estado
		FROM 
			cartorios_servicos
		WHERE 
			codigo ='$Cod'
	"); 
   
   list($servicos,$aliquota,$estado)=mysql_fetch_array($sql);
	if(($servicos != $Servicos) || 
		($aliquota != $Aliquota) || 
		($estado != $Estado)){   
	    $sql=mysql_query("
		    UPDATE 
		    	cartorios_servicos
		    SET 
			    servicos = '$Servicos', 
			    aliquota ='$Aliquota', 
			    estado ='$Estado'
			WHERE 
				codigo= '$Cod'
		");
		add_logs('Atualizou Serviço de Cartório');	
		Mensagem("Alterações concluídas com sucesso!"); 
	} else {
		/*print "<script language=JavaScript> alert('É necessário no mínimo uma alteração nos campos.');</script>";*/
		Mensagem('É necessário no mínimo uma alteração nos campos');
	}  
	
}
$nossonumero = $_POST['COD'];
 
$sqlEditar=mysql_query("SELECT servicos,aliquota,estado FROM cartorios_servicos WHERE codigo ='$nossonumero'"); 
list($servicos,$aliquota,$estado)=mysql_fetch_array($sqlEditar); 
 
?>
<table width="98%" align="center">
    <tr>
     <td>
      <fieldset><legend>Edição de Serviços</legend>
      <form  method="post" id="frmEditar">   
		  <input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
		  <input type="hidden" name="COD" id="COD" value="<?php echo  $_POST['COD'];?>" />
		  <input type="hidden" name="servicos" id="servicos" value="Pesquisar" />
		  <table width="100%" border="0" align="center">
		   <tr>
		   <tr>
			<td width="94">Descri&ccedil;&atilde;o</td>
			<td colspan="2" align="left">
			 <textarea cols="40" rows="5" name="txtEdDescServicos" class="texto"><?php print $servicos; ?></textarea>
			</td>
		   </tr>
		   <tr>
			 <td>Aliquota</td>
			 <td align="left">
			  <input type="text" size="5" maxlength="5" name="txtEdAliquota" class="texto" value="<?php print $aliquota; ?>" onkeyup="MaskPercent(this)"/>
			   &nbsp;%&nbsp;&nbsp;Exemplo(0.00)</td>
			 <td align="left"><em>Para servi&ccedil;os em geral </em></td>
		   </tr>
		   <tr>
			<td>Estado</td>
			<td colspan="2"  align="left">		  
			   Ativo<input type="radio" name="TxtEstado"  value="A" title="Ativo" <? if ($estado == "A") print("checked=checked"); ?>/>			   
			   Inativo
			   <input type="radio" name="TxtEstado"  value="I" title="Inativo" <? if ($estado == "I") print("checked=checked"); ?>/>		</td> 
			</tr>
		   <tr>
			<td>
			 <?php 
			 /*
			  * <input type="submit" value="Salvar" name="btSalvar" class="botao">
			  * <input type="button" value="Voltar" name="btVoltar" class="botao" onclick="document.getElementById('frmVoltar').submit();">
			  */
			?>
			</td>
			<td width="169">&nbsp;		</td>
			<td width="223"  style="font-size:10px;" align="right">
			 <font color="#FF0000">*</font>Campos Obrigat&oacute;rios		</td>
		   </tr>   
		  </table>   
      </form>
	  <form method="post" id="frmVoltar">
	  	<input type="hidden" name="include" value="<?php echo $_POST['include']; ?>" />
	  </form>
      </fieldset>
     </td>
    </tr>  
</table> 
