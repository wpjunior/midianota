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
$sql_municipio=mysql_query("SELECT cidade, estado FROM configuracoes");
$dados_municipio=mysql_fetch_array($sql_municipio);

//Verifica se foi inserido alguma empresa nova, se for vai para o arquivo de inserção
 if(($_POST['btCadastrar'] =="Salvar")&&($_POST['hdAtualizar'] ==''))
 {   
   include("inserir.php");
 }
 if(($_POST['btCadastrar'] =="Salvar")&&($_POST['hdAtualizar']=='sim'))
 { 
 	include("editar.php"); 
 }
?>
	 <!-- Formulário de inserção de empresa  -----------------------------------------------------------------------------> 
	<style type="text/css">
	<!--
	#divBusca {
		position:absolute;
		left:40%;
		top:20%;
		width:298px;
		height:276px;
		z-index:1;
		visibility:<?php if(isset($btBuscarCliente)){ echo"visible";}else{ echo"hidden";} ?>
	}
	-->
	</style>
	<div id="divBusca"  ><?php include("inc/prestadores/busca.php"); ?></div> 
	 
	<?php	
	if(($_POST['CODEMISSOR'])){		   
		$codigo=$_POST['CODEMISSOR'];	
		$sql=mysql_query("
						SELECT 
							codigo,
							nome, 
							razaosocial,
							cnpjcpf,
							inscrmunicipal,						
							endereco, 
							municipio, 
							uf, 
							logo,
							email,
							ultimanota, 						
							notalimite,						
							estado, 
							simplesnacional,
							codcontador,
							nfe					
						FROM 
							emissores 					
						WHERE
							codigo='$codigo'
						");
		list($codigo,$nome,$razaosocial,$cnpjcpf,$inscrmunicipal,$endereco,$municipio,$uf,$logo,$email,$ultima,$notalimite,$estado,$simplesnaconal,$codcontador,$nfe)= mysql_fetch_array($sql);	
	}?>
<table border="0" cellspacing="0" cellpadding="0" class="form">
  <tr>
    <td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
    <td width="600" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;Empreiteiras - Cadastro</td>
    <td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
  </tr>
  <tr>
    <td width="18" background="img/form/lateralesq.jpg"></td>
    <td align="center">
	  <form  method="post" name="frmCadastroEmpresa" id="frmCadastroEmpresa">
		  <input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
		  <input type="hidden" name="hdAtualizar" id="hdAtualizar" value="<?php if($_POST['CODEMISSOR']){echo 'sim';}?>" />
		  <?php if($_POST['CODEMISSOR']){?> <input type="hidden" name="CODEMISSOR" id="CODEMISSOR" value="<?php echo $_POST['CODEMISSOR']?>" /><?php }?>
      <fieldset><legend>Prestadores Inserir</legend>      
	    <input type="hidden" name="btCadastrarEmpresa" value="Cadastrar" />
      <table border="0" align="center" id="tblEmpresa">	   
	   <tr>
        <td align="left">
	     Nome<font color="#FF0000">*</font>		</td>
        <td align="left">
	     <input type="text" size="70" maxlength="100" name="txtEmpresa" class="texto" value="<?php echo $nome; ?>" >		</td>
       </tr>
       <tr>
        <td align="left">
		 Razão Social<font color="#FF0000">*</font>		</td>
        <td align="left">
	     <input type="text" size="70" maxlength="100" name="txtRazao" class="texto" value="<?php if(isset($razaosocial)){echo $razaosocial;} ?>">		</td>
       </tr>	   	
      
	   <!-- alterna input cpf/cnpj-->   
       <tr>
        <td align="left">
		 CNPJ/CPF<font color="#FF0000">*</font>		</td> 
        <td align="left">			
		 <input  id="txtInsCpfCnpjEmpresa" type="text" size="20"  name="txtCNPJ" class="texto" onkeydown="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );" value="<?php if(isset($cnpjcpf)){echo $cnpjcpf;} ?>" />
		 <em>Somente n&uacute;meros</em> </td>
       </tr>
	   <!-- alterna input cpf/cnpj FIM-->   
       <tr>
        <td align="left">
		 Endere&ccedil;o<font color="#FF0000">*</font>		</td>
        <td align="left">
		 <input type="text" size="70" maxlength="100" name="txtEndereco" class="texto" value="<?php if(isset($endereco)){echo $endereco;} ?>" />		</td>
       </tr>
       <tr>
	     <td align="left">
		  Município<font color="#FF0000">*</font>		 </td>
	     <td align="left">
          <input type="text" size="30" maxlength="100" name="txtMunicipio" class="texto" value="<?php if(isset($municipio)){echo $municipio;} else{echo $dados_municipio['cidade'];} ?>" />		 </td>
	     </tr>
       <tr>
         <td align="left">UF<font color="#FF0000">*</font></td>
         <td align="left"><input type="text" size="3" maxlength="2" name="txtUf" class="texto" value="<?php if(isset($uf)){echo $uf;} else{echo $dados_municipio['estado'];} ?>" /></td>
       </tr>
	   <tr>
        <td align="left">
		 Insc. Municipal		</td>
        <td align="left">
		 <input type="text" size="20" maxlength="20" name="txtInscMunicipal" class="texto" value="<?php if(isset($inscrmunicipal)){echo $inscrmunicipal;} ?>" />		</td>
       </tr>
       <tr>
        <td align="left">
		 Email<font color="#FF0000">*</font>		</td>
        <td align="left">
		  <input type="text" size="30" maxlength="100" name="txtEmail" class="texto" value="<?php if(isset($email)){echo $email;} ?>" /> 
		  <em>Informar somente 01	(um)	e-mail</em></td>
       </tr>
	   <tr>
	     <td align="left">NFe</td>
	     <td align="left"><input type="checkbox" value="s"  name="txtNfe" id="txtNfe" <?php if($nfe =='s'){echo "checked=\"checked\"";} ?>/>
           <em>Esta empresa emite Nota Fiscal eletr&ocirc;nica</em></td>
	   </tr>
	   <?php if($_POST['CODEMISSOR']){?>
	   <tr>
	     <td align="left">Estado</td>
	     <td align="left"><input type="radio" name="rgEstado" value="A" id="rgEstado_0"  <?php if($estado =='A'){echo "checked=\"checked\"";} ?> />&nbsp;Ativo
	     <input type="radio" name="rgEstado" value="I" id="rgEstado_1" <?php if($estado =='I'){echo "checked=\"checked\"";} ?>/>&nbsp;Inativo
         </td>
	   </tr>       
	   <?php }?>
	   <tr>
	     <td colspan="2" align="left">&nbsp;</td>
	     </tr>
		 <tr>
		 	<td colspan="2" align="left">
				
				<table width="500" border="0" cellspacing="1" cellpadding="2" align="left">		
				<?php 
				if(($_POST['CODEMISSOR'])){
					$COD = $_POST['CODEMISSOR'];	   	
					$sql=mysql_query("SELECT codigo, nome, cpf FROM emissores_socios WHERE codemissor = '$COD'");	
					$contsocios = mysql_num_rows($sql);
					$cont_aux_socios = $contsocios;	  
					print("<tr>
							  <td colspan=4 align=left>
							   <b>Resposável/Socio</b>
							  </td>
							 </tr>
							");
					while(list($CodigoSocio,$nomesocio,$cpfsocio)=mysql_fetch_array($sql))
					{
						print("	    
						<tr>
						   <td align=left colspan=4>
							<input type=hidden name=txtCodigoSocio$contsocios value=$CodigoSocio>
							Nome&nbsp; <input type=text name=txtnomesocio$contsocios value=\"$nomesocio\" size=40 maxlength=100 class=texto>&nbsp;
							CPF&nbsp;<input type=text name=txtcpfsocio$contsocios value=$cpfsocio size=14 maxlength=14 class=texto onkeypress=\"formatar(this,'000.000.000-000')\">");
							if($contsocios != $cont_aux_socios)
							{
							print("<input type=checkbox name=checkExcluiSocio$contsocios value=$CodigoSocio>Excluir"); 
							}				
						print("</td>		   
						</tr> ");
						$contsocios--;		  
				  } 
				}	?>	 
				 	
		</table>  
		
			</td>
		 </tr>
	   <tr>
         <td colspan="2" align="left">
		   <!-- botão que chama a função JS e mostra + um sócio-->
		  <input type="button" value="Adicionar Responsável/Sócio" name="btAddSocio" class="botao" onclick="incluirSocio()" /> 
		  <font color="#FF0000">*</font></td>
       </tr>
	   <tr>
	     <td colspan="2" align="center">		  
		  
			<!--CAMPO SÓCIOS --------------------------------------------------------------------------->	   
			<table width="100%" border="0" cellspacing="1" cellpadding="2">       
				 <?php include("cadastro_socios.php")?>
			</table>
			<!-- CAMPO SÒCIOS FIM -->   	     
		</td>
	   </tr>
	   <tr>
	   	<td colspan="2" align="left">
		 	<?php if($_POST['CODEMISSOR'])		
			{ ?>
				<table width="100%" border="0" cellspacing="1" cellpadding="2">  
					<tr>	
						   <td align="left" colspan="4" align="left">
							<b>Serviços</b>	<br />	    
						   </td>     
						   <td></td>		  
						 </tr>								
					 <!---------------- LISTAGEM DOS SERVICOS A SEREM EDITADOS ------------------------------------------------------->	  
					 <?php
					  $COD = $_POST['CODEMISSOR'];
					  $sql_servicos=mysql_query("
					  SELECT emissores_servicos.codigo,servicos.codigo,servicos.codservico,servicos.descricao,servicos.aliquota 
					  FROM servicos
					  INNER JOIN emissores_servicos ON servicos.codigo = emissores_servicos.codservico
					  WHERE emissores_servicos.codemissor = '$COD'");
					  
					 $contservicos = mysql_num_rows($sql_servicos);
					 $cont_aux_servicos = $contservicos;				 
					 $numservicos = $contservicos;	 				 
					 $sql_all_servicos=mysql_query("SELECT codigo,codservico,descricao,aliquota FROM servicos WHERE estado= 'A'");?>
					 
							
				 <?php while(list($codigo_empresas_servicos,$codigo,$codservico,$descricao,$aliquota)=mysql_fetch_array($sql_servicos))
					  {
						print("	 
						 <tr>	
						   <td align=left >
							 <input type=hidden value=$codigo_empresas_servicos name=servico$contservicos >	
							 <select name=cmbEditaServico$contservicos style=width:400px;>
							   <option value=$codigo>$codservico | $descricao | $aliquota</option>");	
									 
							  while(list($CODigo,$CODservico,$Descricao,$Aliquota)=mysql_fetch_array($sql_all_servicos))			    
							  {
							   if ($codigo != $CODigo)
							   {
								print("<option value=$CODigo>$CODservico |$Descricao | $Aliquota</option>");
							   }
							  }	
						print("</select>&nbsp;");
							  if($contservicos != $cont_aux_servicos )
							  {
							   print("<input type=checkbox name=checkExcluiServico$contservicos value=$codigo>Excluir");
							  } 
					  print("</td>		  	  
						  </tr> ");
						$contservicos--;  
					  } ?>	
				</table>	
			<?php } ?>			
		</td>
	   </tr>	   
	   <tr>
         <td colspan="2" align="left">
		  <!-- botão que chama a função JS e mostra + um serviço-->
		  <input type="button" value="Adicionar Serviços" name="btAddServicos" class="botao" onclick="incluirServico()" /> 
		  <font color="#FF0000">*</font></td>
       </tr>	   
	   <tr>
	     <td colspan="2" align="center">	 
	      
		<!--CAMPO SERVICOS -->	   
		<table width="100%" border="0" cellspacing="1" cellpadding="2">
			   
			 <?php include("cadastro_servicos.php")?>
		</table>
		
		<!-- CAMPO SERVICOS FIM -->  
		</td>
	   </tr>	         
	  
       <tr>
         <td colspan="2" align="right"><font color="#FF0000">*</font> Campos Obrigat&oacute;rios<br /> </td>
         </tr>
      </table>       
      </fieldset>
      <fieldset style="vertical-align:middle; text-align:left">
      <input type="button" value="Novo" name="btCadastrar" class="botao" onclick="LimpaCampos('frmCadastroEmpresa')"  />
      <input type="button" value="Pesquisar" name="btCadastrar" class="botao" onclick="document.getElementById('divBusca').style.visibility='visible'" />
      <input type="submit" value="Excluir" name="btCadastrar" class="botao" />
      <input type="submit" value="Salvar" name="btCadastrar" class="botao" />
      </fieldset>
      </form>
	</td>
	<td width="19" background="img/form/lateraldir.jpg"></td>
  </tr>
  <tr>
    <td align="left" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantoesq.jpg" /></td>
    <td background="img/form/rodape_fundo.jpg"></td>
    <td align="right" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantodir.jpg" /></td>
  </tr>
</table>
<!-- Formulário de inserção de serviços Fim-->       
		 		
  

