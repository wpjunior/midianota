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
<style type="text/css" media="all">
<!--
	#divBuscaPrestador {
		position:absolute;
		left:40%;
		top:20%;
		width:298px;
		height:276px;
		z-index:1;
	 visibility:<?php if(isset($btBuscarPrestador)) { echo"visible"; }else { echo"hidden";}?>
	}
	
	#divBuscaContador {
		position:absolute;
		left:40%;
		top:20%;
		width:298px;
		height:276px;
		z-index:1;
	 visibility:<?php if(isset($btBuscarContador)) { echo"visible"; }else { echo"hidden"; }?>
	}
	
	
	input[type*="text"]{
		text-transform:uppercase;
	}
 -->
</style>
<div id="divBuscaPrestador"  >
	<?php include("inc/cadastro/prestadores/busca_prestador_cont.php"); ?>
</div>
<div id="divBuscaContador"  >
	<?php include("inc/cadastro/prestadores/busca_contador.php"); ?>
</div>
<?php
	//Testa se o usuario acionou o botao de inserção de novo contador se sim direciona para o cadastro de prestadores
	if($_POST['btNovoContador']){
		RedirecionaPost("principal.php?include=inc/cadastro/prestadores/cadastro.php");
		die();
	}


	//Testa se algum dos botões foi acionado
	if(($_POST['btAdcionar'] == "Adcionar Contador") || ($_POST['btAtualizar'] == "Atualizar Contador")){
		$cod_prest = $_POST['CODPRESTADOR'];
		$cod_cont  = $_POST['CODCONTADOR'];
		mysql_query("UPDATE cadastro SET codcontador = '$cod_cont' WHERE codigo = '$cod_prest'");
		if($_POST['btAdcionar'] == "Adcionar Contador"){
			add_logs('Inseriu Contador para uma Empresa');
			Mensagem("Inserido contador para a empresa!");
		}else{
			add_logs('Atualizou Contador para uma Empresa');
			Mensagem("Contador da empresa atualizado!");
		}
	}
		
	//Verifica se foi feita uma busca pelo prestador se sim traz as informações do banco sobre o mesmo
	if($_POST['CODPRESTADOR']){
		$codigo_prestador = $_POST['CODPRESTADOR'];
		$codigo_contador  = $_POST['CODCONTADOR'];
		$sql_prestador = mysql_query("
			SELECT
				nome,
				razaosocial,
				IF(cnpj <> '',cnpj,cpf) AS cnpjcpf,
				codcontador
			FROM
				cadastro
			WHERE 
				codigo = '$codigo_prestador'
		");
		list($nome,$razaosocial,$cnpjcpf,$codcontador) = mysql_fetch_array($sql_prestador);
		
		//testa se o prestador ja possui um contador
		if(!$codigo_contador){
			$codigo_contador = $codcontador;
		}
		
		//busca as informações do contador referente ao prestador ou informações referentes ao contador buscado pelo usuario
		$sql_contador = mysql_query("
			SELECT
				nome,
				IF(cnpj <> '',cnpj,cpf) AS cnpjcpf,
				fonecomercial
			FROM
				cadastro
			WHERE 
				codigo = '$codigo_contador'
		");
		list($nome_cont,$cnpjcpf_cont,$fone_cont) = mysql_fetch_array($sql_contador);
	}
?>
<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
	<tr>
		<td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
		<td width="600" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;Prestadores / Contadores</td>
		<td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
	</tr>
	<tr>
		<td width="18" background="img/form/lateralesq.jpg"></td>
		<td align="center">
		
			<form method="post">
				<input type="hidden" name="include" id="include" value="<?php echo $_POST['include'];?>" />
				<input type="hidden" name="CODPRESTADOR" value="<?php echo $_POST['CODPRESTADOR'];?>" />
				<input type="hidden" name="CODCONTADOR" value="<?php echo $_POST['CODCONTADOR'];?>" />
				<fieldset><legend>Inserção do contador para o Prestador</legend>
					<table width="100%">
						<tr>
							<td align="left" colspan="2"><b>Informações da Empresa</b></td>
						</tr>
						<tr>
							<td align="left"> Nome </td>
							<td align="left">
								<input type="text" size="70" maxlength="100" name="txtNomeEmp" class="texto" value="<?php if(isset($nome)){echo $nome;} ?>">
							</td>
						</tr>
						<tr>
							<td align="left"> Razão Social </td>
							<td align="left">
								<input type="text" size="70" maxlength="100" name="txtRazaoEmp" class="texto" 
								value="<?php if(isset($razaosocial)){echo $razaosocial;} ?>">
							</td>
						</tr>
						<tr>
							<td align="left"> CNPJ/CPF </td>
							<td align="left">
								<input type="text" size="20"  name="txtCNPJEmp" class="texto" 
								value="<?php if(isset($cnpjcpf)){echo $cnpjcpf;} ?>" maxlength="18" />
							</td>
						</tr>
						<tr>
							<td align="left" colspan="2">
								<input name="btPesquisar" type="button" class="botao" value="Buscar Prestador" 
								onclick="document.getElementById('divBuscaPrestador').style.visibility='visible';document.getElementById('divBuscaContador').style.visibility='hidden'">
							</td>
						</tr>
						<tr>
							<td colspan="2"><hr size="1" color="#000000"></td>
						</tr>
						<tr>
							<td align="left" colspan="2"><b>Informações do Contador</b></td>
						</tr>
						<tr>
							<td align="left"> Nome<font color="#FF0000">*</font> </td>
							<td align="left">
								<input type="text" size="70" maxlength="100" name="txtNomeCont" id="txtNomeCont" class="texto"  
								value="<?php if(isset($nome_cont)){echo $nome_cont;} ?>" <?php if(!isset($nome_cont)){ echo "disabled=\"disabled\"";}?>>
							</td>
						</tr>
						<tr>
							<td align="left"> CNPJ/CPF<font color="#FF0000">*</font> </td>
							<td align="left">
								<input type="text" size="20"  name="txtCNPJEmp" id="txtCNPJEmp" class="texto" 
								value="<?php if(isset($cnpjcpf_cont)){echo $cnpjcpf_cont;} ?>" maxlength="18" <?php if(!isset($cnpjcpf_cont)){echo "disabled=\"disabled\"";}?> />
							</td>
						</tr>
						<tr>
							<td align="left"> Telefone<font color="#FF0000">*</font> </td>
							<td align="left">
								<input type="text" class="texto" size="20" maxlength="15" name="txtFoneComercial" id="txtFoneComercial"
								 value="<?php if(isset($fone_cont)){ echo $fone_cont;} ?>" <?php if(!isset($fone_cont)){ echo "disabled=\"disabled\"";}?>/>
							</td>
						</tr>
					</table>
				</fieldset>
				<fieldset>
					<table width="100%">
						<tr>
							<td width="23%" align="left">
								<?php if(!isset($codcontador)){?>
									<input name="btAdcionar" type="submit" class="botao" value="Adcionar Contador" <?php if(!isset($_POST['CODPRESTADOR'])){ echo "disabled=\"disabled\"";}?>
									onclick="return ValidaFormulario('txtNomeCont|txtCNPJEmp|txtFoneComercial','Você deve buscar algum contador cadastrado no sistema!')">
								<?php }?>
								<?php if(isset($codcontador)){?><input name="btAtualizar" type="submit" class="botao" value="Atualizar Contador" /><?php }?>
							</td>
							<td width="77%" align="left">
								<?php
									if(isset($_POST['CODPRESTADOR'])){
								?>
									<input name="btPesquisar" type="button" class="botao" value="Buscar Contador" 
									onclick="document.getElementById('divBuscaPrestador').style.visibility='hidden';document.getElementById('divBuscaContador').style.visibility='visible'">
									<input name="btNovoContador" type="submit" class="botao" value="Novo Contador" />
								<?php
									}
								?>
							</td>
						</tr>
					</table>
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
