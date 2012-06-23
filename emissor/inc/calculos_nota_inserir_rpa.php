<?php						
$regra_cred_rpa = "'$cred_pf_n','$val_pf_n','$cred_pf_s','$val_pf_s','$cred_pj_n','$val_pj_n','$cred_pj_s','$val_pj_s'";

if(false){?><table><?php }
?>
  <tr>
    <td align="left">Valor Total das Deduções</td>
    <td align="left">R$ 
	    <input name="txtValorDeducoes" type="text" size="12" class="texto" id="txtValorDeducoes"  style="text-align:right;" value="0"
    	 onkeydown="MaskMoeda(this); return NumbersOnly(event);" <?php print "onblur=\"ValorIssRPA($regra_cred_rpa)\"";?> > 		
	<em>exemplo: 1.912,55</em></td>
  </tr>


  <tr>
    <td align="left">Base de Cálculo<font color="#FF0000">*</font></td>
    <td align="left">R$
		<?php print("<input name=\"txtBaseCalculo\" type=\"text\" size=\"10\" class=\"texto\" id=\"txtBaseCalculo\" style=\"text-align:right;\" onkeyup=\"MaskMoeda(this);\" onkeydown=\"return NumbersOnly(event);\" value=\"0\"
		onblur=\"ValorIssRPA($regra_cred_rpa)\">");?>
		<em>exemplo: 1912.55</em>
		<input name="txtBaseCalculoAux" type="hidden" id="txtBaseCalculoAux" />
		<input name="hdCalculos" id="hdCalculos" type="hidden" />
		<input name="hdValorInicial" id="hdValorInicial" type="hidden" />
	</td>
  </tr>
  <tr>
   	<td colspan="8">
		<fieldset><legend><b>ISS</b></legend>
			<table width="100%">
				<tr>
					<td align="left">Código do Serviço</td>
					<td align="left">	  
						<!-- busca a relacao dos servicos por empresa -->
						<select name="cmbCodServico" size="1" style="width:295px;" id="cmbCodServico" onchange="MostraValorRPA(); 
						<?php print "ValorIssRPA($regra_cred_rpa)";?>" >
						<option value="0">Selecione o Serviço</option>	   	        
						<?php while(list($codigo_empresas_servicos,$codigo,$codservico,$descricao,$aliquota,$issretido,$valor_rpa)=mysql_fetch_array($sql_servicos))
						{	   
							print("<option value=\"$valor_rpa|$codigo|$issretido\"> $descricao </option>");
						}	
						?>
						</select>
					</td>
				</tr>
				<tr style="display:none;">    	
					<td align="left">
						Alíquota
					</td>
					<td align="left">	
						 <input  id="txtAliquota" name="txtAliquota" type="text" size="5" class="texto" readonly="yes" style="text-align:right;" value="0.00">
					</td>
				</tr>  
			    <tr>
				  <td align="left">Valor do ISS</td>
				  <td align="left">R$ <input name="txtISS" type="text" size="10" class="texto" readonly="yes" style="text-align:right;" value="0" id="txtISS">
				  <em>Valor fixo de RPA</em></td>
			    </tr>
				<tr>
					<td align="left"> 
						Valor do ISS Retido 
					</td>
					<td align="left">
						R$	 
						<input id="txtIssRetido" name="txtIssRetido" type="text" size="10" class="texto" readonly="yes" value="0" style="text-align:right;"/>	 
					</td>
				</tr>
			   <tr> 
				<td width="32%" align="left"><input type="checkbox" id="ISSManual" onclick="issmanual()" value="8" />Reter ISS manualmente</td>
				<td width="68%" align="left">
				 <div id="DivISSRetido" style="display:none;">  
				  <input type="text" class="texto" size="4" id="txtPissretido" 
				  <?php print "onblur=\"CalculaISS()\"";?> />%
				  
				 </div>
				</td>
			  </tr>
			 </table>
		  </fieldset>	 
		  <fieldset><legend><b>INSS</b></legend>
		  	<table width="100%">
				<tr>
					<td width="31%" align="left">
						 <font color="#FF0000">**</font>% base de cálculo
					</td>
					<td width="69%">
						<input name="txtINSSBCpct" id="txtINSSBCpct" type="text" size="4" class="texto" onblur="baseCalcPct('INSS')" onkeyup="MaskPercent(this)" /> % 
						= 
						R$ <input name="txtINSSBC" id="txtINSSBC" type="text" class="texto" size="10" readonly="readonly" style="text-align:right;" />
					</td>
				</tr>
				<tr>
					<td>INSS sobre a base de cálculo</td>
					<td align="left">	
						<input name="txtAliquotaINSS" id="txtAliquotaINSS" type="text" size="4" class="texto" style="text-align:right;" disabled="disabled" onkeyup="MaskPercent(this)" 
						onblur="document.getElementById('txtBaseCalculo').onblur();" > %
						= 
						R$	 
						<input id="txtValorINSS" name="txtValorINSS" type="text" size="10" class="texto" readonly="yes" value="0" style="text-align:right;" disabled="disabled"/>	 
					</td>
					
				</tr> 
				<tr> 
					<td align="left"><input type="checkbox" id="INSSManual" onclick="inssmanual()" value="8" />Reter INSS manualmente</td>
					<td align="left">
						<div id="DivINSSRetido" style="display:none;">  
						<input type="text" class="texto" size="4" id="txtPinssretido" <?php print"onblur=\"CalculaINSS()\"";?> />%
						
						</div>
					</td>
				</tr>			
			  </table>
			</fieldset>
			<fieldset><legend><b>IRRF</b></legend>
				<table width="100%">
					<tr>
						<td width="31%" align="left">
							 <font color="#FF0000">**</font>% base de calculo
						</td>
						<td width="69%">
							<input name="txtIRRFBCpct" id="txtIRRFBCpct" type="text" size="4" class="texto" onblur="baseCalcPct('IRRF')" onkeyup="MaskPercent(this)" /> % 
							= 
							R$ <input name="txtIRRFBC" id="txtIRRFBC" type="text" class="texto" size="10" style="text-align:right;" readonly="readonly" />
						</td>
					</tr>
					<tr>
						<td width="31%" align="left">
							Alíquota de IRRF
						</td>
						<td width="69%" align="left">	

							<input name="txtIRRF" id="txtIRRF" type="text" size="4" class="texto" style="text-align:right;" onkeyup="MaskPercent(this)" 
							onblur="document.getElementById('txtBaseCalculo').onblur();" disabled="disabled" > % = 
							
							R$	 
							<input id="txtValorIRRF" name="txtValorIRRF" type="text" size="10" class="texto" readonly="yes" value="0" style="text-align:right;" disabled="disabled"/>	 
						</td>
					</tr>
					<tr>
						<td width="31%" align="left">
							Dedução de 
						</td>
						<td width="69%" align="left">	
							R$
							<input name="txtDeducIRRF" id="txtDeducIRRF" type="text" size="10" class="texto" style="text-align:right;" onkeyup="MaskMoeda(this);"
							onblur="document.getElementById('txtBaseCalculo').onblur();" disabled="disabled" >  = 
							
							R$	 
							<input id="txtValorFinalIRRF" name="txtValorFinalIRRF" type="text" size="10" class="texto" style="text-align:right;" readonly="readonly"/>	 
						</td>
					</tr>
				</table>
			</fieldset> 
			<fieldset><legend><b>IR</b></legend>
				<table width="100%">
				   <tr> 
					<td align="left"><input type="checkbox" id="IRManual" onclick="irmanual()" value="8" />Reter IR manualmente</td>
					<td align="left">
					 <div id="DivIRRetido" style="display:none;"> 
					  <input type="text" class="texto" size="4" id="txtPirretido" <?php print"onblur=\"CalculaIR()\"";?> />%
					 </div>
					</td>
				  </tr>
			  </table>
		  </fieldset>

	</td>
  </tr>
  <?php /* ?>
  <tr>
    <td>
		<?php
		$regra_cred_rpa = "'$cred_pf_n','$val_pf_n','$cred_pf_s','$val_pf_s','$cred_pj_n','$val_pj_n','$cred_pj_s','$val_pj_s'";
		?>
		<!-- busca a relacao dos servicos por empresa -->
		<select name="cmbCodServico" size="1" style="width:295px;" id="cmbCodServico" onchange="MostraValorRPA(); 
		<?php print "ValorIssRPA($regra_cred_rpa)";?>" >
		<option value="0">Selecione o Serviço</option>	   	        
		<?php while(list($codigo_empresas_servicos,$codigo,$codservico,$descricao,$aliquota,$issretido,$valor_rpa)=mysql_fetch_array($sql_servicos))
		{	   
			print("<option value=\"$valor_rpa|$codigo|$issretido\"> $descricao </option>");
		}	
		?>
		</select>
	</td>
  </tr>
  <tr style="display:none">    	
    <td align="left">
	  Valor RPA
	</td>
    <td align="left">	
 	 R$
	 <input  id="txtAliquota" name="txtAliquota" type="text" size="5" class="texto" readonly="yes" style="text-align:right;" value="0.00">
	</td>
  </tr>  
  <tr>    
  <tr>
    <td align="left">
	  Alíquota de INSS
	</td>
    <td align="left">	
 	 <input name="txtAliquotaINSS" id="txtAliquotaINSS" type="text" size="5" class="texto" style="text-align:right;" onkeyup="MaskPercent(this)" 
	 onblur="document.getElementById('hdValorInicial').disabled = true;document.getElementById('txtBaseCalculo').onblur();" > %
	 = 
	 R$	 
	 <input id="txtValorINSS" name="txtValorINSS" type="text" size="10" class="texto" readonly="yes" value="0" style="text-align:right;"/>	 
	</td>

  </tr> 
  <tr>
    <td align="left">
	  Alíquota de IRRF
	</td>
    <td align="left">	
 	 <input name="txtIRRF" id="txtIRRF" type="text" size="5" class="texto" style="text-align:right;" onkeyup="MaskPercent(this)" 
	 onblur="document.getElementById('hdValorInicial').disabled = true;document.getElementById('txtBaseCalculo').onblur();" > % = 
	
	  R$	 
	 <input id="txtValorIRRF" name="txtValorIRRF" type="text" size="10" class="texto" readonly="yes" value="0" style="text-align:right;"/>	 
	</td>
  </tr>  
  <tr>
    <td align="left">Valor do ISS</td>
    <td align="left">R$ <input name="txtISS" type="text" size="10" class="texto" readonly="yes" style="text-align:right;" value="0" id="txtISS"> <em>Valor fixo de RPA</em></td>
  </tr>
  
   <tr style="display:none">
    <td align="left"> 
	 Valor do ISS Retido   
	</td>
    <td align="left">
	 R$	 
	 <input id="txtIssRetido" name="txtIssRetido" type="text" size="10" class="texto" readonly="yes" value="0" style="text-align:right;"/>	 
	</td>
   </tr>
   
   <tr> 
    <td align="left"><input type="checkbox" id="ISSManual" onclick="issmanual()" value="8" />Reter ISS manualmente</td>
    <td align="left">
	 <div id="DivISSRetido" style="display:none;">%  &nbsp;
	  <input type="text" class="texto" size="4" id="txtPissretido" 
	  <?php print "onblur=\"ValorIssRPA($regra_cred_rpa)\"";?> />
	  
	 </div>
	</td>
  </tr>	 
   <tr> 
    <td align="left"><input type="checkbox" id="INSSManual" onclick="inssmanual()" value="8" />Reter INSS manualmente</td>
    <td align="left">
	 <div id="DivINSSRetido" style="display:none;">%  &nbsp;
	  <input type="text" class="texto" size="4" id="txtPinssretido" <?php print"onblur=\"CalculaINSS()\"";?> />
	  
	 </div>
	</td>
  </tr>	 
   <tr> 
    <td align="left"><input type="checkbox" id="IRManual" onclick="irmanual()" value="8" />Reter IR manualmente</td>
    <td align="left">
	 <div id="DivIRRetido" style="display:none;">%  &nbsp;
	  <input type="text" class="texto" size="4" id="txtPirretido" <?php print"onblur=\"CalculaIR()\"";?> />
	 </div>
	</td>
  </tr>
  <?php */ ?>
  <?php
  	$sql_verifica_creditos = mysql_query("SELECT ativar_creditos FROM configuracoes");
	list($ativar_creditos) = mysql_fetch_array($sql_verifica_creditos);
	
	if($ativar_creditos == "n"){
		$display = "style=\"display:none\"";
	}else{
		$display = "";
	}
  ?>
  <tr <?php echo $display;?>>
    <td align="left">Crédito p/ Abatimento</td>
    <td align="left">R$ <input name="txtCredito" id="txtCredito" type="text" size="10" class="texto" readonly="yes" style="text-align:right" ></td>
  </tr>
  <tr>
    <td align="left"><b>Valor Total da Nota</b></td>
    <td align="left">R$ <input name="txtValTotal" id="txtValTotal" type="text" size="10" class="texto" readonly="yes" style="text-align:right;" >
	Valor total da retenção R$ <input name="txtValTotalRetencao" id="txtValTotalRetencao" type="text" class="texto" size="10" readonly="readonly" style="text-align:right" />
	</td>
  </tr>
  <tr>
    <td  align="left">
		<input name="btInserirNota" type="submit" value="Emitir" class="botao" onclick="return ValidaFormulario('txtBaseCalculo|txtTomadorCNPJ|txtTomadorNome')" >
	</td>
	<td align="right">
		<font color="#FF0000">*</font>Campos obrigatórios<br />
		<font color="#FF0000">**</font>Percentual da base de cálculo a qual será afetada pelo imposto
	</td>
  </tr>  
</table>
</form>
</fieldset>