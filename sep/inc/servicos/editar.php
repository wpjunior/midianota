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
//Recebe os dados do Formulário de alteração e faz o UPDADE no banco
if ($_POST['btCadastrar'] !=""){
	$Cod = $_POST['txtCODIGO'];
	$codServico=$_POST['txtEdCodServico'];
	$descServico=$_POST['txtEdDescServicos'];      
	$Aliquota = $_POST['txtEdAliquota'];
	$AliquotaIR = $_POST['txtEdAliquotaIR'];
	$Estado = $_POST['TxtEstado'];   
   
	$tipopessoa=$_POST['cmbEdTipoPessoa'];
	$basecalc=MoedaToDec($_POST['txtEdBaseCalculo']);
	$incidencia=$_POST['cmbEdIncidencia'];
	$venc=$_POST['txtEdDiaVencimento'];
	$docfiscal=$_POST['cmbEdDocFiscal'];
	$valor_rpa_novo=MoedaToDec($_POST['txtRPA']);
   
	$sql=mysql_query("
		SELECT 
			codservico, 
			descricao,
			aliquota,
			aliquotair,
			estado,
			tipopessoa,
			basecalculo,
			incidencia,
			datavenc,
			docfiscal,
			valor_rpa 
		FROM 
			servicos 
		WHERE 
			codigo ='$Cod'
	"); 
	list($codservico,$descricao,$aliquota,$aliquotair,$estado,$Tipopessoa,$Basecalculo,$Incidencia,$Datavenc,$Doc,$Valor_RPA)=mysql_fetch_array($sql);
	if(($codservico != $codServico) || 
		($descricao != $descServico) || 
		($aliquota != $Aliquota) || 
		($aliquotair != $AliquotaIR) || 
		($estado != $Estado)||
		($Tipopessoa !=$tipopessoa)||
		($Basecalculo !=$basecalc)||
		($Incidencia !=$incidencia)||
		($Datavenc !=$venc)||
		($Doc !=$docfiscal)||
		($Valor_RPA !=$valor_rpa_novo)){   
	    $sql=mysql_query("
		    UPDATE 
		    	servicos 
		    SET 
			    codservico= '$codServico', 
			    descricao= '$descServico', 
			    aliquota ='$Aliquota', 
			    aliquotair ='$AliquotaIR', 
			    estado ='$Estado',
				tipopessoa='$tipopessoa',
				basecalculo='$basecalc',
				incidencia='$incidencia',
				datavenc='$venc',
				docfiscal='$docfiscal', 
				valor_rpa='$valor_rpa_novo'
			WHERE 
				codigo= '$Cod'
		");
		add_logs('Atualizou Serviço');	
		Mensagem("Alterações concluídas com sucesso!"); 
	} else {
		/*print "<script language=JavaScript> alert('É necessário no mínimo uma alteração nos campos.');</script>";*/
		Mensagem('É necessário no mínimo uma alteração nos campos');
	}  
	
}
$nossonumero = $_POST['COD'];
 
$sqlEditar=mysql_query("SELECT codservico, descricao,aliquota,aliquotair,estado,tipopessoa,basecalculo,incidencia,datavenc,docfiscal,valor_rpa FROM servicos WHERE codigo ='$nossonumero'"); 
list($codservico,$descricao,$aliquota,$aliquotair,$estado,$tipopessoa,$basecalculo,$incidencia,$datavenc,$doc,$valorRPA)=mysql_fetch_array($sqlEditar); 
 
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
			<td width="94">Cód. Serviço</td>
			<td colspan="2" align="left">
			 <input type="hidden" name="txtCODIGO" value="<?php print $nossonumero; ?>" />
			 <input type="text" size="20" maxlength="20" name="txtEdCodServico" class="texto" value="<?php print $codservico; ?>">	    
			</td>
		   </tr>
		   <tr>
			<td width="94">Descri&ccedil;&atilde;o</td>
			<td colspan="2" align="left">
			 <textarea cols="40" rows="5" name="txtEdDescServicos" class="texto"><?php print $descricao; ?></textarea>
			</td>
		   </tr>
		   <tr>
				<td align="left">Tipo de Pessoa</td>
				<td align="left" colspan="2">
				<select name="cmbEdTipoPessoa" id="cmbInsTipoPessoa" class="combo">
                  <option value="PJ" <?php if($tipopessoa =='PJ'){echo"selected=\"selected\"";}?>>Pessoa Jur&iacute;dica</option>
                  <option value="PF" <?php if($tipopessoa =='PF'){echo"selected=\"selected\"";}?>>Pessoa F&iacute;sica</option>
                  <option value="PJPF" <?php if($tipopessoa =='PJPF'){echo"selected=\"selected\"";}?>>Ambas</option>
                </select></td>
		   </tr>
		   <tr>
			 <td>Aliquota</td>
			 <td align="left">
			  <input type="text" size="5" maxlength="5" name="txtEdAliquota" class="texto" value="<?php print $aliquota; ?>" onkeyup="MaskPercent(this)" />
			   &nbsp;%&nbsp;&nbsp;Exemplo(0.00)</td>
			 <td align="left"><em>Para servi&ccedil;os em geral </em></td>
		   </tr>
		   <tr>
			 <td>Reten&ccedil;&atilde;o ISS </td>
			 <td align="left">
			  <input type="text" size="5" maxlength="5" name="txtEdAliquotaIR" class="texto" value="<?php print $aliquotair; ?>" onkeyup="MaskPercent(this)" />
			   &nbsp;%&nbsp;&nbsp;Exemplo(0.00)		  </td>
			 <td align="left"><em>Para servi&ccedil;os com ISS Retido</em></td>
		   </tr>	  
		   <tr>
				<td align="left" >Base de C&aacute;lculo</td>
				<td align="left"colspan="2"><input name="txtEdBaseCalculo" type="text" class="texto" id="txtInsBaseCalculo" onkeyup="MaskMoeda(this)" size="10" maxlength="9" value="<?php echo DecToMoeda($basecalculo);?>" /></td>
			</tr> 	 
			<tr>
			  <td align="left">Incid&ecirc;ncia <font color="#FF0000">*</font></td>
			  <td align="left">
			  <select name="cmbEdIncidencia" id="cmbEdIncidencia" class="combo">
			    <option value="mensal" <?php if($incidencia =="mensal"){echo"selected=\"selected\"";}?>>Mensal</option>
			    <option value="anual" <?php if($incidencia =="anual"){echo"selected=\"selected\"";}?>>Anual</option>
              </select>
			  </td>
		  </tr>
		  <tr>
			<td align="left">Valor RPA</td>
			<td align="left" colspan="2">
				<input name="txtRPA" type="text" class="texto" id="txtRPA" onkeyup="MaskMoeda(this)" onkeydown="return NumbersOnly(event)" value="<?php echo DecToMoeda($valorRPA); ?>" size="10" maxlength="9" />
				* Valor para Declara&ccedil;&atilde;o de Aut&ocirc;nomo
			</td>
		  </tr>
		  <tr>
			  <td align="left">Dia do Vencimento <font color="#FF0000">*</font></td>
			  <td align="left"><input name="txtEdDiaVencimento" type="text" class="texto" id="txtInsDiaVencimento" value="<?php echo $datavenc;?>" size="3" maxlength="2"  /></td>
		  </tr>
			<tr>
			  <td align="left">Documento Fiscal <font color="#FF0000">*</font></td>
			  <td align="left">
			    <select name="cmbEdDocFiscal" id="cmbInsDocFiscal" class="combo">
			      <option value="NF"<?php if($doc =="NF"){echo"selected=\"selected\"";}?>>Nota Fiscal</option>
			      <option value="CF"<?php if($doc =="CF"){echo"selected=\"selected\"";}?>>Cupom Fiscal</option>
                </select>
              </td>
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