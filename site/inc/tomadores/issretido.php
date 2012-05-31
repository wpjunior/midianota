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
	
if(!$_POST['txtCNPJ']&&!$_POST['txtInscMunicipal']){
	$_SESSION['autenticacao'] = rand(10000,99999);
	
	if($_POST['txtMenu']=='semtomador'||
	 	$_POST['txtMenu']=='comtomador'||
	 	$_POST['txtMenu']=='segundavia_prestador'||
	 	$_POST['txtMenu']=='guia_pagamento'||
	 	$_POST['txtMenu']=='prestadores_cancelardes'||
	 	$_POST['txtMenu']=='guia_pagamento_issretido') {
	 	
	 	$login_seguro = true;
	 }
?>
	<form method="post" name="frmCNPJ">
	<input type="hidden" value="<?php echo $_POST['txtMenu'];?>" name="txtMenu">
<table border="0" cellspacing="1" cellpadding="0">
<tr>
		<td width="10" height="10" bgcolor="#FFFFFF"></td>
	    <td width="165" align="center" bgcolor="#FFFFFF" rowspan="3">Gerar guia</td>
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

		<table width="98%" height="100%" border="0" align="center" cellpadding="5" cellspacing="0">
			<tr>
				<td width="19%" align="left">CNPJ/CPF</td>
			    <td width="81%" align="left" valign="middle"><em>
			      <input class="texto" type="text" title="CNPJ" name="txtCNPJ"  id="txtCNPJ"  tabindex="1"/>
			    Somente n&uacute;meros</em></td>
			</tr>
		<?php if($login_seguro) {
		?>
			<tr>
				<td align="left">Senha</td>
				<td align="left">
					<input class="texto" type="password" title="Senha" name="txtSenha" id="txtSenha" tabindex="2" />
					<a href="recuperarsenha.php" tabindex="9">Recuperar Senha</a>
				</td>
			</tr>
			<tr>
				<td align="left">Cod Verificação</td>
				<td align="left">
					<input class="texto" type="text" title="IM" name="codseguranca" id="codseguranca" size="5" maxlength="5" tabindex="3" />
					<img style="cursor: pointer;" onclick="mostrar_teclado();" src="../img/botoes/num_key.jpg" title="Teclado Virtual" >&nbsp;
					<?php include("inc/cod_verificacao.php");?>
				</td>
			</tr>
			
		<?php } else {?>
			<tr>
			  <td align="left">ou</td>
			  <td align="left" valign="middle">&nbsp;</td>
		  	</tr>
			<tr>
			  <td align="left">Insc. Municipal</td>
			  <td align="left" valign="middle">
			    <input class="texto" type="text" title="IM" name="txtInscMunicipal" id="txtInscMunicipal" tabindex="4" />
			  </td>
		  	</tr>
		<?php } ?>
			<tr>
			  <td align="center">&nbsp;</td>
			  <td align="left" valign="middle">
				  <input type="submit" value="Avançar" class="botao" onclick="return verificaCnpjCpfIm();" tabindex="5" />
				  <input class="botao" value="Voltar" type="button" onclick="parent.location = 'tomadores.php';" tabindex="6" />
			  </td>
		  </tr>
	  </table>		</td>
	</tr>
	<tr>
    	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
	</tr>
</table>    
	</form>
	
<?php 

}else{

if ($_POST['txtInscMunicipal']){
	$tomador_IM = $_POST['txtInscMunicipal'];
	$sql_IM_tomador=mysql_query("
		SELECT cnpj,cpf
		FROM cadastro
		WHERE inscrmunicipal='$tomador_IM'
	");
	if(!mysql_num_rows($sql_IM_tomador))	{
		Mensagem("Inscrição Municipal não encontrada, verifique os dados ou tente pelo CNPJ/CPF");
		Redireciona("tomadores.php");
	}else{
		list($tomador_CNPJ,$tomador_CPF)=mysql_fetch_array($sql_IM_tomador);
		$tomador_CNPJ = $tomador_CNPJ.$tomador_CPF;
	}
}
if ($_POST['txtCNPJ']){
	$tomador_CNPJ = $_POST['txtCNPJ'];
}
$sql_emissor = mysql_query("SELECT codigo, cnpj,cpf, razaosocial, email, inscrmunicipal, logradouro,numero,complemento,bairro,cep FROM cadastro WHERE cnpj='$tomador_CNPJ' OR cpf='$tomador_CNPJ'");
if (mysql_num_rows($sql_emissor)){
	list($cod_emissor,$cnpj_emissor,$cpf_emissor,$nome_emissor,$email_emissor,$inscrmunicipal_emissor,$logradouro_emissor,
		$numero_emissor,$complemento_emissor,$bairro_emissor,$cep_emissor)=mysql_fetch_array($sql_emissor);
}
$sql_tomador=mysql_query("SELECT codigo, cnpj,cpf, nome, email FROM cadastro WHERE cnpj='$tomador_CNPJ' OR cpf='$tomador_CNPJ'");

if(!mysql_num_rows($sql_tomador)){
	$tipopessoa = strlen($tomador_CNPJ)==18? 'cnpj':'cpf';
	$codtipo = codtipo('tomador');
	$codtipodec = coddeclaracao('DES Simplificada');
	mysql_query("
		INSERT INTO 
			cadastro 
		SET 
			$tipopessoa = '$tomador_CNPJ',
			codtipo = '$codtipo',
			codtipodeclaracao = '$codtipodec'
	");
	
	$sql_tomador=mysql_query("SELECT codigo, cnpj, cpf, nome, email FROM cadastro WHERE cnpj='$tomador_CNPJ' OR cpf='$tomador_CNPJ'");
	//Mensagem("Tomador não cadastrado no sistema, preencha os campos obrigatórios");
}			  
	
list($cod_tomador,$cnpj,$cpf,$TomadorNome,$TomadorEmail)=mysql_fetch_array($sql_tomador);
$cnpj = $cnpj.$cpf;
listaRegrasMultaDes();


 
?>
<form method="post" name="frmDesSemTomador" action="inc/tomadores/gerarguia.php" onsubmit="document.getElementById('hdTotalInputs').value=totalemissores_des;return confirm('Confira seus dados antes de continuar');">	
<input type="hidden" name="hdTotalInputs" id="hdTotalInputs" />
<table border="0" cellspacing="1" cellpadding="0">
<tr>
		<td width="10" height="10" bgcolor="#FFFFFF"></td>
	    <td width="250" align="center" bgcolor="#FFFFFF" rowspan="3" class="fieldsetCab">Gerar guia - Serviços Tomados</td>
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
		<td height="60" colspan="4" bgcolor="#CCCCCC">



	<table border="0" cellpadding="3" cellspacing="2" width="100%">
		<tr>
			<td width="22%" align="left" valign="middle">CNPJ/CPF:</td>
			<td align="left" bgcolor="#FFFFFF" colspan="3">&nbsp;&nbsp;<b><?php echo $_POST['txtCNPJ'];?></b>
			 <input type="hidden" value="<?php echo $_POST['txtCNPJ'];?>" name="txtCNPJ" /></td>
		</tr>		
		<tr>
			<td align="left" valign="middle">Razão Social/Nome:</td>
			<td align="left" colspan="3"><font color="#FF0000">*</font> <input type="text" name="txtRazaoNome" value="<?php echo $TomadorNome;?>" id="txtRazaoNome" class="texto"  size="62"/></td>
		</tr>			
		
		<tr>
			<td align="left" valign="middle">
				Compet&ecirc;ncia/Período:
			</td>
			<td align="left">&nbsp;&nbsp;  
        <?php
				$meses=array("1"=>"Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
				$mes=date("n");
				$ano=date("Y");						
				if($DEC_ATRAZADAS == 'n'){//var que vem do conect.php
					echo "<b>{$meses[$mes]}/{$ano}</b>";
				?><br />
				Declarações atrasadas entre em contato com a prefeitura
				<input type="hidden" name="cmbMes" id="cmbMes" value="<?php echo $mes; ?>" />
				<input type="hidden" name="cmbAno" id="cmbAno" value="<?php echo $ano; ?>" />
				<?php 
				}else{
				?>
				  <select name="cmbMes" id="cmbMes" onchange="CalculaMultaDes();">
					  <?php
					  for($ind=1;$ind<=12;$ind++){
					  echo "<option value='$ind'>{$meses[$ind]}</option>";
					  }
					  ?>
				  </select>
				  <select name="cmbAno" id="cmbAno" onchange="CalculaMultaDes();" >
						<?php
							$year=date("Y");
							for($h=0; $h<5; $h++){
								$y=$year-$h;
								echo "<option value=\"$y\">$y</option>";
							}
						?>
				  </select>
				<?php
				}//else se é permitudo declaracões atrazadas
				?>
				&nbsp;&nbsp;
				<input name="btBuscar" type="button" class="botao" value="Buscar" 
                onclick="buscaGuiasIssRetido('<?php echo $_POST['txtCNPJ'];?>','cmbMes','cmbAno','tdConteudo')" />
			</td>
		</tr>
		<tr>
			<td colspan="3" align="center" valign="middle" id="tdConteudo">
			</td>
		</tr>
        <tr>
        	<td colspan="3" align="left"><input name="btVoltar" type="button" value="Voltar" class="botao" onclick="window.location='tomadores.php'" /></td>
        </tr>
	</table>

		</td>
	</tr>
	<tr>
    	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
	</tr>
</table>    
	</form>
<script type="text/javascript">
	//DesTomadores('inserir');
</script>
<?php
	
}
?>
