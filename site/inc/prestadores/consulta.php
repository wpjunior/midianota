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
	if(!$_POST['txtCNPJ']){
	
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0">
	<tr>
		<td width="10" height="10" bgcolor="#FFFFFF"></td>
		<td width="400" align="center" bgcolor="#FFFFFF" rowspan="3">Consulta ao Cadastro do Prestador</td>
	  	<td width="405" bgcolor="#FFFFFF"></td>
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
        <form method="post" name="frmCNPJ">
    		<input type="hidden" value="<?php echo $_POST['txtMenu'];?>" name="txtMenu">
	            <table width="98%" height="100%" border="0" align="center" cellpadding="5" cellspacing="0">
    	            <tr>
        	            <td width="19%" align="left">CNPJ/CPF</td>
            	        <td width="81%" align="left" valign="middle"><em>
						<input class="texto" type="text" title="CNPJ" name="txtCNPJ"  id="txtCNPJ"  />
                    	Somente n&uacute;meros</em></td>
                	</tr>		
                	<tr>
                  		<td align="center">&nbsp;</td>
                  		<td align="left" valign="middle">
                  		<input name="btAvancar" type="submit" value="Avançar" class="botao" onclick="return verificaCnpjCpfIm();" />&nbsp;<input type="button" name="btVoltar" value="Voltar" class="botao" onClick="window.location='prestadores.php'">
                		</td>
            		</tr>
        		</table>
        </form>
        </td>	
    </tr>
    <tr>
        <td height="1" colspan="3" bgcolor="#CCCCCC"></td>
    </tr>
</table> 

<?php 
	}else{	
	
	$sql = mysql_query("SELECT codigo FROM tipo WHERE tipo = 'prestador'");
	list($codtipo) = mysql_fetch_array($sql);
	
	$cnpj = $_POST["txtCNPJ"];
	$sql_prestadorlogado = mysql_query("				
			SELECT 
				codigo, 
				nome, 
				razaosocial, 
				senha, 
				cnpj, 
				inscrmunicipal, 
				logradouro,
				numero,
				municipio,
				bairro, 
				cep,
				complemento,
				uf, 
				email, 
				fonecomercial, 
				fonecelular, 
				estado
			FROM 
				cadastro 
			WHERE 
				cadastro.cnpj = '$cnpj' AND cadastro.codtipo = '$codtipo'
");
	list($codigo,$nome,$razaosocial,$senha,$cnpj,$inscrmunicipal,$logradouro,$numero,$municipio,$bairro,$cep,$complemento,$uf,$email,$fonecomercial,$fonecelular,$estado) = mysql_fetch_array($sql_prestadorlogado);
		switch($estado){
			case "NL": $estado = '<b>Aguarde a liberação da prefeitura</b>';                                                  break;
			case "A" : $estado = '<font color="#006600"><b>Cadastro liberado</b></font>';                                     break;
			case "I" : $estado = '<font color="#FF0000"><b>Prestador inativo, entre em contato com a prefeitura.</b></font>'; break;
		}//fim switch estado
	
	//seleciona os responsaveis, socios e gerentes e mostra apenas o primeiro de cada
	$resp=codcargo('responsavel');
	$sql_resp= mysql_query("SELECT nome, cpf FROM cadastro_resp WHERE codemissor = '$codigo' AND codcargo = '$resp'");
		
	$socio=codcargo('socio');
	$sql_socio= mysql_query("SELECT nome, cpf FROM cadastro_resp WHERE codemissor = '$codigo' AND codcargo = '$socio'");
	
	if(mysql_num_rows($sql_prestadorlogado)){
?>
<table width="100%" border="0" cellpadding="0" cellspacing="1">
	<tr>
		<td width="5%" height="5" bgcolor="#FFFFFF"></td>
		<td width="30%" align="center" bgcolor="#FFFFFF" rowspan="3">Consulta ao Cadastro do Prestador</td>
		<td width="30%" bgcolor="#FFFFFF"></td>
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
			<form method="post" id="frmCadastroInst" action="inc/dec/inserir.php">
				<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
                    <table width="98%" height="100%" border="0" bgcolor="#CCCCCC" align="center" cellpadding="1" cellspacing="2">
                        <tr>
                            <td colspan="4" height="5"></td>
                        </tr>
                        <tr>
                            <td width="18%" align="left" >Nome Completo:</td>
                            <td colspan="3" bgcolor="#FFFFFF" align="left" valign="middle"><?php echo $nome; ?></td>
                        </tr>
                        <tr>
                            <td align="left" >Razão Social:</td>
                            <td align="left" bgcolor="#FFFFFF" colspan="3" valign="middle"><?php echo $razaosocial; ?></td>
                        </tr>
                        <tr>
                            <td align="left" >CNPJ:</td>
                            <td align="left" bgcolor="#FFFFFF" colspan="3" valign="middle"><?php echo $cnpj; ?></td>
                        </tr>
                        <tr>
                            <td align="left" >Insc Municipal:</td>
                            <td align="left" bgcolor="#FFFFFF" colspan="3" valign="middle"><?php echo verificaCampo($inscrmunicipal); ?></td>
                        </tr>
                        <tr>
                            <td align="left" >Endereço:</td>
                            <td align="left" bgcolor="#FFFFFF" colspan="3" valign="middle"><?php echo "$logradouro, n° $numero"; ?></td>
                        </tr>
                        <tr>
                            <td align="left" >Situacão:</td>
                            <td align="left" bgcolor="#FFFFFF" colspan="3" valign="middle"><?php echo $estado; ?></td>
                        </tr>  
                        <tr>
                            <td align="left" >Email:</td>
                            <td align="left" bgcolor="#FFFFFF" colspan="3" valign="middle"><?php echo $email; ?></td>
                        </tr>
                        <tr>
                            <td align="left" >Bairro:</td>
                            <td align="left" bgcolor="#FFFFFF" valign="middle"><?php echo $bairro; ?></td>
                            <td align="left" width="20%">CEP:</td>
                            <td align="left" width="20%" bgcolor="#FFFFFF" valign="middle"><?php echo $cep; ?></td>
                        </tr>
                        <tr>
                            <td align="left" >Municipio:</td>
                            <td align="left" bgcolor="#FFFFFF" valign="middle"><?php echo $municipio; ?></td>
                            <td width="16%" align="left" >Estado (UF):</td>
                            <td align="left" bgcolor="#FFFFFF" width="15%" valign="middle"><?php echo $uf; ?></td>
                        </tr>
                        <tr>
                            <td align="left" >Telefone:</td>
                            <td align="left" bgcolor="#FFFFFF" valign="middle"><?php echo $fonecomercial; ?></td>
                            <td align="left" >Telefone Adicional:</td>
                            <td align="left" bgcolor="#FFFFFF" valign="middle"><?php echo verificaCampo($fonecelular); ?></td>
                        </tr>
                        <tr>
                            <td width="100%" colspan="4" height="3"><hr /></td>
                        </tr>
						<?php
						while(list($nome_resp, $cpf_resp)=mysql_fetch_array($sql_resp)){
						?>
                        <tr>
                            <td align="left" >Responsável:</td>
                            <td align="left" bgcolor="#FFFFFF" valign="middle"><?php echo verificaCampo($nome_resp); ?></td>
                            <td align="left" width="20%">CPF Responsável:</td>
                            <td align="left" width="20%" bgcolor="#FFFFFF" valign="middle"><?php echo verificaCampo($cpf_resp); ?></td>
                        </tr>
						<?php
						}//fim while responsaveis
						
						while(list($nome_socio, $cpf_socio)=mysql_fetch_array($sql_socio)){
						?>
                        <tr>
                            <td align="left" >Sócio:</td>
                            <td align="left" bgcolor="#FFFFFF" valign="middle"><?php echo verificaCampo($nome_socio); ?></td>
                            <td align="left" width="20%">CPF Sócio:</td>
                            <td align="left" width="20%" bgcolor="#FFFFFF" valign="middle"><?php echo verificaCampo($cpf_socio); ?></td>
                        </tr>
						<?php
						}//fim while socios
						?>
                        <tr>
                            <td  height="25" colspan="4"><input type="button" name="btVoltar" value="Voltar" class="botao" 
                                onClick="window.location='prestadores.php'"></td>
                        </tr>
                    </table>
            </form>		
        </td>	
	</tr>
	<tr>
        <td height="1" colspan="3" bgcolor="#CCCCCC"></td>
	</tr>
</table>

<?php
	}else{
		Mensagem("Este CNPJ não está cadastrado no sistema");
		Redireciona("prestadores.php");
	}
}
?>