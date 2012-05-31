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
	// busca a cidade e o estado do banco
	$sql=mysql_query("SELECT cidade, estado FROM configuracoes");
	list($CIDADE,$ESTADO)=mysql_fetch_array($sql);
	
	// recebe os dados do formulario
	$cod             = $_POST["hdCodOpr"];
	$codbanco        = $_POST["cmbBanco"];
	$nome            = strip_tags(addslashes($_POST["txtNome"]));
	$razaosocial     = strip_tags(addslashes($_POST["txtRazao"]));
	$agencia         = strip_tags(addslashes($_POST["txtAgencia"]));
	$cnpj            = strip_tags(addslashes($_POST["txtCnpj"]));
	$gerente         = strip_tags(addslashes($_POST["txtGerente"]));
	$gerente_cpf     = $_POST["txtCpfGerente"];
	$responsavel     = strip_tags(addslashes($_POST["txtResponsavel"]));
	$responsavel_cpf = $_POST["txtCpfResponsavel"];
	$insc_municipal  = strip_tags(addslashes($_POST["txtInscMunicipal"]));
	$endereco        = strip_tags(addslashes($_POST["txtEndereco"]));
	$municipio       = $_POST["txtMunicipio"];
	$uf              = $_POST["txtUf"];
	$email           = strip_tags(addslashes($_POST["txtEmail"]));
	$fone1           = strip_tags(addslashes($_POST["txtFone1"]));
	$fone2           = strip_tags(addslashes($_POST["txtFone2"]));
	$estado          = $_POST["rdbEstado"];
	$senha           = rand(000000,999999);
	
	//Faz o cadastro
	if($_POST["btCadastrar"]){
		include("inc/operadorascreditos/cadastro_inserir.php");
	}

?>
	<style type="text/css">
	<!--
	#divBuscaOpr {
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
	<div id="divBuscaOpr"><?php include("inc/operadorascreditos/pesquisar.php"); ?></div> 
	<?php
		if($_POST["CODOPR"])
			{
				$codigo = $_POST["CODOPR"];
				$sql = mysql_query("
					SELECT 
						codigo,
						nome, 
						razaosocial, 
						agencia, 
						cnpj, 
						gerente, 
						gerente_cpf, 
						responsavel, 
						responsavel_cpf, 
						inscrmunicipal,  
						endereco, 
						municipio,
						uf,
						fone1, 
						fone2,
						codbanco,
						senha,
						email,
						estado
					FROM 
						operadoras_creditos
					WHERE 
						codigo = $codigo");
				list($codopr,$nome,$razaosocial,$agencia,$cnpj,$gerente,$gerente_cpf,$responsavel,$responsavel_cpf,$inscrmunicipal,$endereco, $munic, $uf, $fone1,$fone2,$codbanco,$senha,$email,$estado)=mysql_fetch_array($sql);
				$sqlbanco = mysql_query("SELECT banco FROM bancos WHERE codigo = '$codbanco'");
				list($banco) = mysql_fetch_array($sqlbanco);
				switch($estado){
					case "A"  : $estado = "Ativo";        break;
					case "I"  : $estado = "Inativo";      break;
					case "NL" : $estado = "Não Liberado"; break;
				}
			}
	?>
<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
  <tr>
    <td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
    <td width="750" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">Operadoras de cr&eacute;dito- Cadastro</td>  
    <td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
  </tr>
  <tr>
    <td width="18" background="img/form/lateralesq.jpg"></td>
    <td align="left">
					<fieldset><legend>Cadastro de Operadora de crédito</legend>	
						<table align="left">
                            <form method="post" id="frmCadastroOpr">
							<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
							<input type="hidden" name="hdCodOpr" value="<?php echo $codopr; ?>" />
								<tr align="left">
									<td> Banco:<font color="#FF0000">*</font></td>
									<td colspan="2">
                                    	<?php if ($codigo) echo "<input type=\"text\" readonly=\"true\" class=\"texto\" size=\"40\" maxlength=\"15\" value=\"$banco\" />";?>
										<select name="cmbBanco" id="cmbBanco" <?php if($codigo) echo "style=\"visibility:hidden\"" ?>>
											<?php
												$sql_banco=mysql_query("SELECT codigo, banco FROM bancos");
												while(list($codbanco,$banco) = mysql_fetch_array($sql_banco))
													{
														echo "<option value=\"$codbanco\">$banco</option>";
													}
											?>
										</select>
									</td>
								</tr>
								<tr align="left">
									<td>Nome:<font color="#FF0000">*</font></td>
									<td colspan="2"><input <?php if($codigo) echo "readonly=\"true\""; ?> type="text" class="texto" size="60" name="txtNome" id="txtNome" value="<?php echo $nome; ?>" /></td>
								</tr>
								<tr align="left">
									<td>Razão Social:<font color="#FF0000">*</font> </td>
									<td colspan="2"><input <?php if($codigo) echo "readonly=\"true\""; ?> type="text" class="texto" size="60" name="txtRazao" id="txtRazao" value="<?php echo $razaosocial; ?>" /></td>
								</tr>
								<tr align="left">
									<td>CNPJ:<font color="#FF0000">*</font> </td>
									<td colspan="2"><input <?php if($codigo) echo "readonly=\"true\""; ?> type="text" class="texto" size="25" name="txtCnpj" onkeydown="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );" maxlength="18" id="txtCnpj" value="<?php echo $cnpj; ?>" /></td>
								</tr>
								<tr align="left">
									<td>Insc. Municipal:</td>
									<td colspan="2"><input <?php if($codigo) echo "readonly=\"true\""; ?> type="text" class="texto" size="30" name="txtInscMunicipal" value="<?php echo $inscrmunicipal; ?>" /></td>
								</tr>
								<tr align="left">
									<td>Endereço:<font color="#FF0000">*</font></td>
									<td><input <?php if($codigo) echo "readonly=\"true\""; ?> type="text" class="texto" name="txtEndereco" size="40" id="txtEndereco" value="<?php echo $endereco; ?>" /></td>
								</tr>
								<tr align="left">
									<td>Município:<font color="#FF0000">*</font></td>
									<td colspan="2"><input type="text" class="texto" size="40" name="txtMunicipio" <?php if($codigo){ echo "value=\"$munic\" readonly=\"true\"";} else { echo "value=\"$CIDADE\"";}?>/></td>
								</tr>
								<tr align="left">
									<td>UF:<font color="#FF0000">*</font> </td>
									<td colspan="2"><input type="text" class="texto" size="40" name="txtUf" <?php if($codigo){ echo "value=\"$uf\" readonly=\"true\"";} else { echo "value=\"$ESTADO\"";}?>/></td>
								</tr>
								<tr align="left">
									<td>Gerente:<font color="#FF0000">*</font></td>
									<td colspan="2"><input <?php if($codigo) echo "readonly=\"true\""; ?> type="text" class="texto" size="40" name="txtGerente" id="txtGerente" value="<?php echo $gerente; ?>" /></td>
								</tr>
								<tr align="left">
									<td>CPF Gerente:<font color="#FF0000">*</font></td>
									<td colspan="2"><input <?php if($codigo) echo "readonly=\"true\""; ?> type="text" class="texto" size="30" name="txtCpfGerente" onkeydown="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );" maxlength="14" id="txtCpfGerente" value="<?php echo $gerente_cpf; ?>" /></td>
								</tr>
								<tr align="left">
									<td>Agência:<font color="#FF0000">*</font></td>
									<td colspan="2"><input <?php if($codigo) echo "readonly=\"true\""; ?> type="text" class="texto" size="40" name="txtAgencia" id="txtAgencia" value="<?php echo $agencia; ?>" /></td>
								</tr>
								<tr align="left">
									<td>Responsável:<font color="#FF0000">*</font></td>
									<td colspan="2"><input <?php if($codigo) echo "readonly=\"true\""; ?> type="text" class="texto" size="40" name="txtResponsavel" id="txtResponsavel" value="<?php echo $responsavel; ?>" /></td>
								</tr>
								<tr align="left">
									<td>CPF Responsável:<font color="#FF0000">*</font></td>
									<td colspan="2"><input <?php if($codigo) echo "readonly=\"true\""; ?> type="text" class="texto" size="30" name="txtCpfResponsavel" onkeydown="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );" maxlength="14" id="txtCpfResponsavel" value="<?php echo $responsavel_cpf; ?>" /></td>
								</tr>
								<tr align="left">
									<td>Email:<font color="#FF0000">*</font></td>
									<td colspan="2"><input <?php if($codigo) echo "readonly=\"true\""; ?> type="text" class="texto" size="30" name="txtEmail" id="txtEmail" value="<?php echo $email; ?>" /></td>
								</tr>
								<tr align="left">
									<td>Telefone 01:<font color="#FF0000">*</font></td>
									<td colspan="2"><input <?php if($codigo) echo "readonly=\"true\""; ?> type="text" class="texto" name="txtFone1" id="txtFone1" value="<?php echo $fone1; ?>" /></td>
								</tr>
								<tr align="left">
									<td>Telefone 02:</td>
									<td colspan="2"><input <?php if($codigo) echo "readonly=\"true\""; ?> type="text" class="texto" name="txtFone2" value="<?php echo $fone2; ?>" /></td>
								</tr>
                                <?php if($codigo){ echo" 
								<tr>
                                	<td>Estado:</td>
									<td>
										<input type=\"text\" readonly=\"true\" class=\"texto\" size=\"15\" maxlength=\"15\" value=\"$estado\" />
                                	</td>
                                </tr>";
								}?>
								<tr <?php if($codigo) echo "style=\"visibility:hidden\"" ?> align="left">
									<td><input type="radio"  name="rdbEstado" value="A"<?php if(($estado=="")||($estado=="A")){echo "checked=\"checked\"";} ?> />Ativo</td>
									<td colspan="2"><input type="radio" name="rdbEstado" value="I"<?php if($estado=="I"){echo "checked=\"checked\"";} ?> />Inativo</td>
								</tr>
								<tr align="left"><td colspan="2"><font color="#FF0000">* Campos Obrigatórios</font></td></tr>
								<tr align="left">
									<td colspan="2">
                                        <input type="submit" <?php if($codigo){echo "style=\"visibility:hidden\"";} ?> class="botao" name="btCadastrar" value="Cadastrar" onclick="return ValidaFormulario('txtNome|txtRazao|txtAgencia|txtCnpj|txtGerente|txtCpfGerente|txtResponsavel|txtCpfResponsavel|txtEndereco|txtEmail|txtFone1|txtSenha|txtConfirmaSenha', 'Preencha todos os campos obrigatórios.');" />&nbsp;                                        <?php 
										if ($codigo){ echo "<input type=\"submit\" class=\"botao\" value=\"Voltar\" onclick=\"LimpaCampos('frmCadastroOpr');Redireciona('cadastro.php');\" />&nbsp;";
										}
										if($codigo){
											echo "<input type=\"hidden\" name=\"hdDesativar\" id=\"hdDesativar\" value=\"$codigo\"/>";
											if($estado == "Ativo"){
												echo "<input type=\"submit\" class=\"botao\" name=\"btDesativar\" id=\"btDesativar\" value=\"Desativar Operadora\"/>&nbsp;";
											}
											elseif($estado == "Inativo"){
											echo "<input type=\"submit\" class=\"botao\" name=\"btAtivar\" id=\"btAtivar\" value=\"Ativar Operadora\"/>&nbsp;";
											}
										}
										if ($codigo){ echo "<input type=\"submit\" class=\"botao\" name=\"btExcluir\" id=\"btExcluir\" value=\"Excluir Operadora\" onclick=\"return Confirma('Deseja Excluir essa Operadora de crédito?');\" />";
										}
				?>						
										<input type="submit" name="btBuscarCliente" value="Buscar" class="botao" />
									</td>
                                </tr>
                                </form>
                                <tr>
									<td>
									<form id="frmGeraComprovante" target="_blank" action="inc/operadorascreditos/comprovante.php" method="post">
										<input type="hidden" name="hdCodOpr" id="hdCodOpr" value="<?php echo $codopr; ?>" />
										<input type="submit" name="btComprovante" value="Comprovante" class="botao" onclick="return ValidaFormulario('hdCodOpr', 'Busque por uma Instituição Financeira antes de gerar o comprovante')" />
									</form>
									</td>
								</tr>
							</table>
					</fieldset>
	</td>
	<td width="19" background="img/form/lateraldir.jpg"></td>
  </tr>
  <tr>
    <td align="left" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantoesq.jpg" /></td>
    <td background="img/form/rodape_fundo.jpg"></td>
    <td align="right" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantodir.jpg" /></td>
  </tr>
</table>
				<?php
				if($_POST["btCadastrar"]){
				?>		
					<script>LimpaCampos('frmCadastroOpr');</script>
				<?php
				}
                if($_POST['btDesativar']){
                	$codigo = $_POST['hdDesativar'];
                	mysql_query("UPDATE operadoras_creditos SET estado = 'I' WHERE codigo = '$codigo'");
					add_logs('Atualizou uma Instituição: Desativada');
					Mensagem("Instituição Financeira desativada!");
				?>
					<script>LimpaCampos('frmCadastroOpr');</script>
				<?php
				}
                
                if($_POST['btAtivar']){
                	$codigo = $_POST["hdDesativar"];
                	mysql_query("UPDATE operadoras_creditos SET estado = 'A' WHERE codigo = '$codigo'");
                	add_logs('Atualizou uma Instituição: Ativada');
					Mensagem("Instituição Financeira ativada!");
				?>
					<script>LimpaCampos('frmCadastroOpr');</script>
				<?php
				}
                                
                if($_POST['btExcluir']){
                	$codigo = $_POST["hdDesativar"];
                	mysql_query("DELETE FROM operadoras_creditos WHERE codigo = $codigo");
                	add_logs('Excluiu uma Instituição: Desativada');
					Mensagem("Instituição Financeira excluída com sucesso!");
				?>
					<script>LimpaCampos('frmCadastroOpr');</script>
				<?php
                }
                ?>  