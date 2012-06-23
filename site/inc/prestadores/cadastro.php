<?php
	$sql=mysql_query("SELECT cidade, estado FROM configuracoes");
	list($CIDADE,$UF)=mysql_fetch_array($sql);
?>
	<table width="580" border="0" cellpadding="0" cellspacing="1">
        <tr>
			<td width="5%" height="10" bgcolor="#FFFFFF"></td>
	        <td width="30%" align="center" bgcolor="#FFFFFF" rowspan="3">Cadastro de Prestadores</td>
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

<br />
<br />
<strong>Prezado Contribuinte</strong>
<br /><br />
A nossa Prefeitura Municipal vem empreendendo esforços para aprimorar continuamente a qualidade dos serviços oferecidos aos contribuintes. Neste sentido, a internet apresenta-se como um importante instrumento capaz de atendê-los com agilidade e segurança.
<br /><br />
E por falar em segurança, o contribuinte deverá cadastrar uma senha individual que permitirá o acesso á área restrita, de seu exclusivo interesse, no endereço eletrônico da Prefeitura. 
<br /><br />
A senha cadastrada é intransferível e configura a assinatura eletrônica da pessoa física ou jurídica que a cadastrou.
<br /><br />
<strong>ALERTAMOS QUE CABERÁ EXCLUSIVAMENTE AO CONTRIBUINTE TODA RESPONSABILIDADE DECORRENTE DO USO INDEVIDO DA SENHA, QUE DEVERÁ SER GUARDADA EM TOTAL SEGURANÇA.</strong>
<br /><br />
<form action="inc/prestadores/inserir.php" method="post" name="frmCadastroEmpresa" id="frmCadastroEmpresa">
      <table width="480" border="0" align="center" id="tblEmpresa">	   
		<tr>
			<td width="135" align="left">Nome<font color="#FF0000">*</font></td>
			<td align="left"><input type="text" size="60" maxlength="100" name="txtInsNomeEmpresa" id="txtInsNomeEmpresa" class="texto" ></td>
		</tr>
		<tr>
			<td width="135" align="left">Razão Social<font color="#FF0000">*</font></td>
			<td align="left"><input type="text" size="60" maxlength="100" name="txtInsRazaoSocial" id="txtInsRazaoSocial" class="texto"></td>
		</tr>	   	
      
	   <!-- alterna input cpf/cnpj-->   
		<tr>
            <td align="left">CNPJ/CPF<font color="#FF0000">*</font></td> 
            <td align="left">
                <input type="text" size="20" maxlength="18"  name="txtCNPJ" id="txtCNPJ" class="texto"
                onblur="ValidaCNPJ(this,'spanprestador');desabilitaSN(this,'txtSimplesNacional','ftDesc')" /><span id="spanprestador"></span>
            </td>
		</tr>
	   <!-- alterna input cpf/cnpj FIM-->   
        <tr>
            <td align="left">Logradouro<font color="#FF0000">*</font></td>
            <td align="left"><input type="text" size="40" maxlength="100" name="txtLogradouro" id="txtLogradouro" class="texto" /></td>
        </tr>
        <tr>
            <td align="left">Número<font color="#FF0000">*</font></td>
            <td align="left"><input type="text" size="10" maxlength="10" name="txtNumero" id="txtNumero" class="texto" /></td>
        </tr>
        <tr>
            <td align="left">Complemento</td>
            <td align="left"><input type="text" size="10" maxlength="10" name="txtComplemento" id="txtComplemento" class="texto" /></td>
        </tr>
        <tr>
            <td align="left">Bairro<font color="#FF0000">*</font></td>
            <td align="left"><input type="text" size="30" maxlength="100" name="txtBairro" id="txtBairro" class="texto" /></td>
        </tr>
        <tr>
            <td align="left">CEP<font color="#FF0000">*</font></td>
            <td align="left"><input type="text" size="10" maxlength="9" name="txtCEP" id="txtCEP" class="texto" /></td>
        </tr>
		<tr>
			<td align="left">Telefone Comercial<font color="#FF0000">*</font></td>
			<td align="left"><input type="text" class="texto" size="20" maxlength="15" name="txtFoneComercial" id="txtFoneComercial" /></td>
		</tr>
		<tr>
			<td align="left">Telefone Celular</td>
			<td align="left"><input type="text" class="texto" size="20" maxlength="15" name="txtFoneCelular" /></td>
		</tr>
        <tr>
            <td align="left">UF<font color="#FF0000">*</font></td>
            <td align="left">
            <!--ESTE SELECT ESTA COM A NOMENCLATTURA DE UM TEXT PARA MANTER A COMPATIBILIDADE DO ARQUIVO INSERIR.PHP COM TODOS OS ARQUIVOS DE CADASTRO DE EMPRESAS-->
                <select name="txtInsUfEmpresa" id="txtInsUfEmpresa" onchange="buscaCidades(this,'txtInsMunicipioEmpresa')">
                    <option value=""></option>
                    <?php
                    	$sql=mysql_query("SELECT uf FROM municipios GROUP BY uf ORDER BY uf");
                    	while(list($uf_busca)=mysql_fetch_array($sql)){
                    		echo "<option value=\"$uf_busca\"";if($uf_busca == $UF){ echo "selected=selected"; }echo ">$uf_busca</option>";
                    	}
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td align="left">Município<font color="#FF0000">*</font></td>
            <td align="left">
                <div  id="txtInsMunicipioEmpresa">
                    <select name="txtInsMunicipioEmpresa" id="txtInsMunicipioEmpresa" class="combo">
						<?php
                       		$sql_municipio = mysql_query("SELECT nome FROM municipios WHERE uf = '$UF'");
                        	while(list($nome) = mysql_fetch_array($sql_municipio)){
                        		echo "<option value=\"$nome\"";if(strtolower($nome) == strtolower($CIDADE)){ echo "selected=selected";} echo ">$nome</option>";
                        	}//fim while 
                        ?>
                    </select>
                </div>
            </td>
        </tr>
		<tr>
			<td align="left">Insc. Municipal</td>
			<td align="left"><input type="text" size="20" maxlength="20" name="txtInsInscMunicipalEmpresa" id="txtInsInscMunicipalEmpresa" class="texto" /></td>
		</tr>
		<tr>
			<td align="left">PIS/PASEP</td>
			<td align="left"><input type="text" size="20" maxlength="20" name="txtPispasep" id="txtPispasep" class="texto" /></td>
		</tr>
		<tr>
			<td align="left">Email<font color="#FF0000">*</font></td>
			<td align="left"><input type="text" size="30" maxlength="100" name="txtInsEmailEmpresa" id="txtInsEmailEmpresa" class="email" /></td>
		</tr>
		<tr>
			<td align="left">Senha<font color="#FF0000">*</font></td>
			<td align="left"><input type="password" size="18" maxlength="18" name="txtSenha" id="txtSenha" class="texto" onkeyup="verificaForca(this)" /></td>
		</tr>
		<tr>
			<td align="left">Confirma Senha<font color="#FF0000">*</font></td>
			<td align="left"><input type="password" size="18" maxlength="18" name="txtSenhaConf" id="txtSenhaConf" class="texto" /></td>
		</tr>	   
		<tr>
			<td colspan="3" align="left">
				<br /><input type="checkbox" value="S"  name="txtSimplesNacional" id="txtSimplesNacional"/>
				<font size="-2" id="ftDesc">
					Esta empresa está enquadrada no Simples Nacional.	  
				</font> 
				<br /><br />		 
			</td>
		</tr>
	   <tr>
	     <td colspan="2" align="left">&nbsp;</td>
	     </tr>
	   <tr>
         <td colspan="2" align="left">		   
		  <input type="button" value="Adicionar Responsável/Sócio" name="btAddSocio" class="botao" onclick="incluirSocio()" /> 
		  <font color="#FF0000">*</font></td>
       </tr>
	   <tr>
	     <td colspan="2" align="center">	  		  
<table width="480" border="0" cellspacing="1" cellpadding="2">
       
	 <?php include("inc/prestadores/cadastro_socios.php")?>
</table>

     </td>
	   </tr>
	   <tr>
	     <td colspan="2" align="left">&nbsp;</td>
	     </tr>
	   <tr>
         <td colspan="2" align="left">		  
		  <input type="button" value="Adicionar Serviços" name="btAddServicos" class="botao" onclick="incluirServico()" /> 
		  <font color="#FF0000">*</font></td>
       </tr>	   
	   <tr>
	     <td colspan="2" align="center">	 
	      

<table width="480" border="0" cellspacing="1" cellpadding="2">
       
	 <?php include("inc/prestadores/cadastro_servicos.php")?>
</table>

        </td>
	   </tr>	         
       <tr>
         <td align="left" height="15"></td>
         <td align="right"></td>
         </tr> 	  
       <tr>
         <td align="left"><input type="submit" value="Cadastrar" name="btCadastrar" class="botao" onclick="return (ConfereCNPJ(this)) && (ValidaSenha('txtSenha','txtSenhaConf') && (ValidaFormulario('txtInsNomeEmpresa|txtInsRazaoSocial|txtCNPJ|txtLogradouro|txtNumero|txtBairro|txtCEP|txtFoneComercial|txtInsUfEmpresa|txtInsMunicipioEmpresa|txtInsEmailEmpresa')))" /></td>
         <td></td>
         </tr>
         <tr>
         	<td align="right" colspan="2"><font color="#FF0000">*</font> Campos Obrigatórios<br /> <strong><font color="#FF0000">**</font> Voce deve desligar o bloqueador de pop-ups para cadastrar</strong></td>
         </tr>   
      </table>   
      </form>



		  </td>
		</tr>
		<tr>
	    	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
		</tr>
	</table>          
