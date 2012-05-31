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
if ($_GET['txtInscMunicipal']){
	$tomador_IM = $_GET['txtInscMunicipal'];
	$codtipo = codtipo("prestador");
	$sql_IM_tomador = mysql_query("SELECT cnpj,cpf
								  FROM cadastro 
								  WHERE inscrmunicipal = '$tomador_IM' AND codtipo = $codtipo");
	if(!mysql_num_rows($sql_IM_tomador)){
		Mensagem("Inscrição Municipal não encontrada, verifique os dados ou tente pelo CNPJ/CPF");
	}else{
		list($tomador_CNPJ,$tomador_CPF) = mysql_fetch_array($sql_IM_tomador);
	}
}
if ($_GET['txtCNPJ']){
	$tomador_CNPJ = $_GET['txtCNPJ'];
}
$sql_emissor = mysql_query("
	SELECT 
		codigo, 
		cnpj,
		cpf, 
		razaosocial, 
		email, 
		inscrmunicipal, 
		logradouro,
		numero,
		complemento,
		bairro,
		cep, 
		municipio, 
		uf 
	FROM 
		cadastro 
	WHERE 
		cnpj='$tomador_CNPJ' OR 
		cpf='$tomador_CNPJ'
");
if (mysql_num_rows($sql_emissor)){
	list($cod_emissor,$cnpj_emissor,$cpf_emissor,$nome_emissor,$email_emissor,$inscrmunicipal_emissor,$logradouro_emissor,$numero_emissor,$complemento_emissor,
		$bairro_emissor,$cep_emissor,$municipio_emissor,$uf_emissor)=mysql_fetch_array($sql_emissor);
}
$sql_tomador=mysql_query("SELECT codigo, cnpj,cpf, nome, email FROM cadastro WHERE cnpj='$tomador_CNPJ' OR cpf='$tomador_CNPJ'");

if(mysql_num_rows($sql_tomador)<=0){
	/*$tipopessoa = strlen($tomador_CNPJ)==18? 'cnpj':'cpf';
	mysql_query("
		INSERT INTO 
			cadastro 
		SET 
			$tipopessoa = '$tomador_CNPJ'
	");
	$sql_tomador=mysql_query("SELECT codigo, cnpj,cpf, nome, email FROM cadastro WHERE cnpj='$tomador_CNPJ' OR cpf='$tomador_CNPJ'");
	//Mensagem("Tomador não cadastrado no sistema, preencha os campos obrigatórios");
	*/
	echo ("<b>Tomador não cadastrado</b>");
}else{				  
	
	list($cod_tomador,$cnpj,$cpf,$nome,$email)=mysql_fetch_array($sql_tomador);
	?>

<form method="post" name="frmDesTomadores">
	<input name="include" id="include" type="hidden" value="<?php echo $_GET['include'];?>"/>
	<?php campoHidden("hdCodTomador",$cod_tomador);?>
	<table width="98%" height="100%" border="0" align="center" cellpadding="5" cellspacing="0">
		<tr>
			<td colspan="2" align="left"><strong>TOMADOR: Declare suas Notas Fiscais de servi&ccedil;os tomados, para aquisi&ccedil;&atilde;o de cr&eacute;ditos no IPTU.</strong></td>
		</tr>
		<tr>
			<td width="27%" align="left" valign="middle">CNPJ/CPF:</td>
			<td width="73%" align="left" valign="middle"><font color="#FF0000">*</font>&nbsp;<b><?php echo $tomador_CNPJ;?></b></td>
		</tr>
		<tr>
			<td align="left" valign="middle">Raz&atilde;o Social/Nome:</td>
			<td align="left" valign="middle"><font color="#FF0000">*</font>
				<input name="txtNome" class="texto" id="txtNome" value="<?php echo $nome;?>" size="50">
			</td>
		</tr>
		<tr>
			<td align="left" valign="middle">E-mail:</td>
			<td align="left" valign="middle"><font color="#FF0000">*</font>
				<input name="txtEmail" class="texto" id="txtEmail" value="<?php echo $email;?>" size="30" />
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center" valign="top">
				<table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" bordercolor="#CCCCCC" bgcolor="#FFFFFF">
					<tr>
						<td width="20%" align="center" bgcolor="#CCCCCC">N&ordm; do Documento</td>
						<td width="16%" align="center" bgcolor="#CCCCCC">Data Emissão</td>
						<td width="30%" align="center" bgcolor="#CCCCCC">Prestador (CNPJ/CPF)</td>
						<td width="15%" align="center" bgcolor="#CCCCCC">Valor</td>
						<td width="19%" align="center" bgcolor="#CCCCCC" style="display: none">Crédito</td>
					</tr>
					<?php 
	                 	campoHidden("hdTomadorCNPJCPF",$tomador_CNPJ);
	                 	$num_notas = 1;//quantas notas vao aparecer no inicio
	                 	$num_notas_max = 1;//maximo de notas que podem ser insiridas
	                 	
	                 	campoHidden("hdNum_notas",$num_notas_max);
	                 	campoHidden("hdUltima",$num_notas);
	                 	$trNotaStyle = "";
	                 	for($c=1;$c<=$num_notas_max;$c++){
		                ?>
					<tr id="trNota<?php echo $c;?>" style="<?php echo $trNotaStyle;?>">
						<td align="center">
							<input name="txtCodigoGuia<?php echo $c;?>" type="text" class="texto" id="txtCodigoGuia<?php echo $c;?>" value="" size="10" style="text-align:center" />
						</td>
						<td align="center">
							<input name="txtDataEmissao<?php echo $c;?>" type="text" class="texto" id="txtDataEmissao<?php echo $c;?>" size="10" maxlength="10" style="text-align:center" onkeyup="MaskData(this);" onkeydown="return NumbersOnly(event)"/>
						</td>
						<td align="center">
							<input name="txtPrestador<?php echo $c;?>" type="text" class="texto" id="txtPrestador<?php echo $c;?>" value="" size="20" style="text-align:center" onkeyup="CNPJCPFMsk(this);" onkeydown="return NumbersOnly(event);" onblur="ConsultaCnpj2(this,<?php echo $c;?>);"  />
						</td>
						<td align="center">
							<input name="txtValor<?php echo $c;?>" type="text" onkeyup="MaskMoeda(this)" class="texto" id="txtValor<?php echo $c;?>" size="10" style="text-align:center" />
						</td>
						<td align="center" style="display: none">
							<input name="txtCredito<?php echo $c;?>" type="text" class="texto" id="txtCredito<?php echo $c;?>" size="10" style="text-align:center" value="" readonly="readonly" />
						</td>
					</tr>
					<tr id="trNotab<?php echo $c;?>" style="<?php echo $trNotaStyle;?>">
						<td id="tdNota<?php echo $c;?>" colspan="4" align="center" valign="top"></td>
					</tr>
					<?php 
		                    
		  					if ($c>=$num_notas){
		                 		$trNotaStyle = "display:none;";
		  					}
	                 	}
	                 	?>
				</table>
			</td>
		</tr>
		<tr style="display: none">
			<td colspan="2" align="right" valign="middle">
				<input name="btNotaRemover" id="btNotaRemover" type="button" value="Remover NF" class="botao" disabled="disabled" onclick="TomadorRemoverNF();">
				<input name="btNotaInserir" id="btNotaInserir" type="button" value="Inserir NF" class="botao" onclick="TomadorInserirNF();">
			</td>
		</tr>
		<tr>
			<td colspan="2" align="left" valign="middle"><font color="#FF0000">*</font><em> Campos com preenchimento obrigatório<br />
				** Desabilite seu bloqueador de pop-up</em></td>
		</tr>
		<tr>
			<td align="right" valign="middle">
				<input name="btDeclararTomador" type="submit" value="Declarar" class="botao" onclick="return (ValidarDesTomador()) && (confirm('Confira seus dados antes de continuar'));">
			</td>
		  <td align="left" valign="middle"><input type="submit" name="btVoltar" id="btVoltar" class="botao" value="Voltar" /></td>
		</tr>
	</table>
</form>
<?php
	}
?>