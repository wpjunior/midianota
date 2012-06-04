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
<?php if ($btUpdate !="")
   {
     include("empresas_editar.php");
   }

 //Seleciona os dados da empresa para serem modificados
 $sql=mysql_query("SELECT nome, estado, razaosocial, cnpjcpf, inscrmunicipal, endereco, municipio, uf,email, estado,simplesnacional FROM emissores WHERE codigo = '$COD'");
   list($nome,$estado, $razaosocial, $cnpjcpf, $inscrmunicipal, $endereco, $municipio, $uf,$email, $estado,$simplesnacional)=mysql_fetch_array($sql);?>

  <table width="520" align="center">  
    <tr>
      <td>
<!----------------- LISTA  DADOS DA EMPRESA A SEREM EDITADOS ----------------------------------------------------------->	 
      
	  <fieldset><legend>Atualizar Empresa </legend>
      <form method="post" name="frmEditaEmpresa" id="frmEditaEmpresa">	    
      <table width="500" border="0" align="center" id="tblEmpresa">
	   
	   <tr>
	     <td align="left">Estado</td>
	     <td colspan="2" align="left">
		  <?php if($estado =="A")
		  { ?>
		  <input type="radio" name="txtEstado" value="A" checked="checked" />Ativa&nbsp;
		  <input type="radio" name="txtEstado" value="I" >Inativa
		  <?php
		  }else
		  { ?>
		  <input type="radio" name="txtEstado" value="A"/>Ativa&nbsp;
		  <input type="radio" name="txtEstado" value="I" checked="checked" >Inativa		  
		  <?php } ?>	  
		 </td>		  
        </tr>
	   <tr>
        <td width="135" align="left">
	     Nome</td>
        <td colspan="2" align="left">
	     <input type="text" size="60" maxlength="100" name="txtEditaNomeEmpresa" class="texto" value="<?php print $nome;?>" >		</td>
       </tr>
       <tr>
        <td width="135" align="left">
		 Razão Social</td>
        <td colspan="2" align="left">
	     <input type="text" size="60" maxlength="100" name="txtEditaRazaoSocial" class="texto" value="<?php print $razaosocial;?>">		        </td>
       </tr>	   	       
	   <!-- alterna input cpf/cnpj----------------------------------------->   
       <tr>
        <td align="left">
		 CNPJ/CPF</td> 
        <td colspan="2" align="left">

 
		 <input type="text" size="20" maxlength="18" name="txtEditaCnpjCpfEmpresa" id="txtEditaCnpjCpfEmpresa" class="texto" nkeydown="stopMsk( event );" onkeypress="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );" value="<?php print $cnpjcpf;?>">		
		 
       	</td>
       </tr>
	   <!-- alterna input cpf/cnpj FIM------------------------------------->   
       <tr>
        <td align="left">
		 Endere&ccedil;o</td>
        <td colspan="2" align="left">
		 <input type="text" size="60" maxlength="100" name="txtEditaEnderecoEmpresa" class="texto" value="<?php print $endereco;?>" />		</td>
       </tr>       
	   <tr>
        <td align="left">
		 Insc. Municipal		</td>
        <td colspan="2" align="left">
		 <input type="text" size="20" maxlength="20" name="txtEditaInscMunicipalEmpresa" class="texto" value="<?php print $inscrmunicipal;?>" />		</td>
       </tr>
       <tr>
        <td align="left">
		 Email		</td>
        <td colspan="2" align="left">
		  <input type="text" size="60" maxlength="100" name="txtEditaEmailEmpresa" class="email" value="<?php print $email;?>" />		        </td>
       </tr>
	   <tr>
	     <td colspan="3" align="left">
		  <?php
		  if ($simplesnacional == "S")
		  { 		  
		   print("<br /><input type=\"checkbox\" value=\"S\"  name=\"txtSimplesNacional\" checked=\"checked\"/>");
		  }
		  else	
		  {
		   print("<br /><input type=\"checkbox\" value=\"S\"  name=\"txtSimplesNacional\"/>");
		  }?>
		  <font size="-2">
	        Esta empresa esta enquadrada no Simples Nacional, conforme Lei Complementar n°123/2006	      
		  </font><br /><br />
		 </td>
       </tr>
	   <tr>
	     <td>&nbsp;</td>
	     <td>&nbsp;</td>
	     <td  style="font-size:10px;">&nbsp;		 </td>
	   </tr>  	   
       <tr>         
         <td>&nbsp;</td>
         <td align="right" colspan="2"><br />		 </td>
       </tr>
       <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td  style="font-size:10px;">&nbsp;</td>
       </tr>
	   <tr>
        <table width="480" border="0" cellspacing="1" cellpadding="2" align="left">
       
	
	   
<!-- LISTA SOCIOS A SEREM EDITADOS -------------------------------------------------------------------------------->	   
<?php $sql=mysql_query("SELECT codigo, nome, cpf FROM emissores_socios WHERE codemissor = '$COD'");

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
			print("<input type=checkbox name=checkExcluiSocio$contsocios value=$CodigoSocio>Exluir"); 
			}
			
	 print("</td>		   
		 </tr> ");
		 $contsocios--;		  
	  }?> 
<!---------------- LISTAGEM DOS SOCIOS A SEREM EDITADOS FIM ------------------------------------------------------->


<!---------------- LISTAGEM DOS SERVICOS A SEREM EDITADOS ------------------------------------------------------->	  
	 <?php
	 $sql_servicos=mysql_query("
	  SELECT emissores_servicos.codigo,servicos.codigo,servicos.codservico,servicos.descricao,servicos.aliquota 
	  FROM servicos
	  INNER JOIN emissores_servicos ON servicos.codigo = emissores_servicos.codservico
	  WHERE emissores_servicos.codemissor = '$COD'");
	  
	 $contservicos = mysql_num_rows($sql_servicos);
	 $cont_aux_servicos = $contservicos;
	 
	 $numservicos = $contservicos;	 
	 
	 
	 $sql_all_servicos=mysql_query("SELECT codigo,codservico,descricao,aliquota FROM servicos WHERE estado= 'A'");	 
	  ?>
	 
	 	 <tr>	
		   <td align="left" colspan="4" align="left"><br><br><br>
		    <b>Serviços</b>	<br />	    
		   </td>     
		   <td>		   </td>		  
		 </tr>	

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
<!------------------------------ Lista os serviços a serem editados FIM--------------------------------------->	  
	     <tr>
	      <td align="left" colspan="4">
		    <table width="500" border="0">
             <br><br>	  
             <tr>
              <td colspan="2">
	           <input type="button" value="Adicionar Responsável/Sócio" name="btEditar" class="botao" onClick="incluirSocio();" />	          </td>
             </tr>
		   <!-- SOCIOS A SEREM INSERIDOS--------------------------------->
		   <?php include("empresas_socios.php");?>	
		   </table>		  </td>			  
		 </tr> 
		 <tr>
		  <!-- SERVICOS A SEREM INSERIDOS--------------------------------->
		  <td align="left" colspan="4">
		   <table width="500" border="0">
            <br><br>	 
            <tr>
             <td colspan="2">
	          <input type="button" value="Adicionar Serviço" name="btEditar" class="botao" onClick="incluirServico();" />	         </td>
            </tr>	      
		    <?php include("empresas_servicos.php");?>		  
		    </table>		 </td>			  
		</tr> 
	    <tr>
	      <td align="left"><br>
		   <input type="hidden" name="txtCodServico" value="<?php print $COD;?>" />
		   <input type="hidden" name="txtCodEmpresa" value="<?php print $COD;?>" />
		   <input type="submit" value="Atualizar" name="btUpdate" class="botao" /><br><br>		  </td>
		 </tr> 
	     </table>	  
      </form>
      </fieldset>
     </td>
    </tr>  
   </table>    
