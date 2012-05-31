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
require_once("../../conect.php");
require_once("../../../funcoes/util.php");


if ($_GET['txtInscMunicipal']){
	$tomador_IM = $_GET['txtInscMunicipal'];
	$sql_IM_tomador=mysql_query("
		SELECT cnpj,cpf
		FROM cadastro
		WHERE inscrmunicipal='$tomador_IM'
	");
	if(!mysql_num_rows($sql_IM_tomador))	{
		echo "Inscrição Municipal não encontrada, verifique os dados ou tente pelo CNPJ/CPF";
		exit();
	}else{	
		list($tomador_CNPJ)=mysql_fetch_array($sql_IM_tomador);
	}

}

if($_GET['txtCNPJ']){
	$tomador_CNPJ = $_GET['txtCNPJ'];
}

$sql_emissor = mysql_query("SELECT codigo, cnpj,cpf, razaosocial, email, inscrmunicipal, logradouro,numero,complemento,bairro,cep FROM cadastro WHERE cnpj='$tomador_CNPJ' OR cpf='$tomador_CNPJ'");
if (!mysql_num_rows($sql_emissor)){
	echo "CPF/CNPJ não encontrado, verifique os dados";
	//Redireciona("des.php");
}else{

	list($cod_emissor,$cnpj_emissor,$cpf_emissor,$nome_emissor,$email_emissor,$inscrmunicipal_emissor,$logradouro_emissor,
	$numero_emissor,$complemento_emissor,$bairro_emissor,$cep_emissor)=mysql_fetch_array($sql_emissor);
	
	$sql_tomador=mysql_query("SELECT codigo, cnpj,cpf, nome, email FROM cadastro WHERE cnpj='$tomador_CNPJ' OR cpf='$tomador_CNPJ'");
	list($cod_tomador,$cnpj,$cpf,$TomadorNome,$TomadorEmail)=mysql_fetch_array($sql_tomador);
	
	listaRegrasMultaDes();
	
 
 
?>
	
	<table border="0" cellpadding="3" cellspacing="2" width="100%">
		<tr>
			<td width="30%" align="left" valign="middle">CNPJ/CPF:</td>
			<td width="70%" align="left" bgcolor="#FFFFFF">&nbsp;&nbsp;<b><?php echo $tomador_CNPJ;?></b>
			 <input type="hidden" value="<?php echo $tomador_CNPJ;?>" name="txtCNPJ" /></td>
		</tr>		
		<tr>
			<td align="left" valign="middle">Razão Social/Nome:</td>
			<td align="left" bgcolor="#FFFFFF"> &nbsp;&nbsp;<b><?php echo $TomadorNome;?></b>
				<input type="hidden" name="txtRazaoNome" value="<?php echo $TomadorNome;?>" id="txtRazaoNome" class="texto"  size="62"/>
			</td>
		</tr>			
		
		<tr>
			<td align="left" valign="middle">
				Compet&ecirc;ncia/Período:
			</td>
			<td align="left">&nbsp;&nbsp;  
				<select name="cmbMes" id="cmbMes" onchange="CalculaMultaDes();">					
					<option value="1">Janeiro</option>
					<option value="2">Fevereiro</option>
					<option value="3">Março</option>
					<option value="4">Abril</option>
					<option value="5">Maio</option>
					<option value="6">Junho</option>
					<option value="7">Julho</option>
					<option value="8">Agosto</option>
					<option value="9">Setembro</option>
					<option value="10">Outubro</option>
					<option value="11">Novembro</option>
					<option value="12">Dezembro</option>
				</select>
				<select name="cmbAno" id="cmbAno" onchange="CalculaMultaDes();">
					<?php
						$ano=date("Y");
						for($x=0; $x<=4; $x++){
							$year=$ano-$x;
							echo "<option value=\"$year\">$year</option>";
						}
					?>
					
				</select>
				
			</td>
		</tr>		
		<tr>
			<td colspan="2" align="center" valign="middle">
			 <br/>
			 <table width="100%" border="0" cellspacing="1">
			 	<tr>
				  <td colspan="4" align="center" bgcolor="#999999">
				    Dados dos Emissores:
				  </td>
				</tr> 				
				<tr>
				  <td width="24%" align="center" bgcolor="#999999">	
				    Cnpj/Cpf				  
				  </td>		
				  <td width="22%" align="center" bgcolor="#999999">		
   				    Número Nota				  
				  </td>									
				  <td width="29%" align="center" bgcolor="#999999">		
	
					Valor Nota			  
				  </td>											  
				  <td width="25%" align="center" bgcolor="#999999">					    
				    ISS Retido				  
				  </td>											  
				</tr>
			  </table>
				<div id="divEmissores" style="width:100%"> </div>
				
				<table align="right">	
				<tr>
				  <td align="right">
				    <input type="button" value="Remover" onclick="DesTomadores('deletar');" class="botao" id="btRemover" disabled="disabled"/>
					<input type="button" value="Nova Nota" onclick="DesTomadores('inserir');" class="botao"/>
				  </td>
				</tr>
				</table> 		
					
				
			 <br /><br />			
			 <table>
					<tr>
						<td align="left">Imposto Total:</td>
						<td>R$ <input type="text" name="txtImpostoTotal" id="txtImpostoTotal" value="0,00" style="text-align:right;" readonly="readonly" size="16" class="texto" /></td>
					</tr>
					<tr style="display:none">
						<td align="left">Multa e Juros de Mora:</td>
						<td>R$ <input type="text" name="txtMultaJuros" id="txtMultaJuros" value="0,00" style="text-align:right;" readonly="readonly" size="16" class="texto" /></td>
					</tr>
					<tr style="display:none">
						<td align="left"><b>Total a Pagar:</b></td>
						<td>R$ <input type="text" name="txtTotalPagar" id="txtTotalPagar" value="0,00" style="text-align:right;" readonly="readonly" size="16" class="texto" /></td>
					</tr>	
			</table>
			</br>
			</br>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center"><br /><input type="submit" value="Declarar" name="btDeclarar" onclick="document.getElementById('hdTotalInputs').value=totalemissores_des;return (ValidarDesIssRetido()) && (confirm('Confira seus dados antes de continuar'));" class="botao" /><br />*Confira seus dados antes de continuar</td>
		</tr>
	</table>

<?php
		
	}
?>