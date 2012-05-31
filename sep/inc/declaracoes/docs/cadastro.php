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
	$sql_cidadeuf = mysql_query("SELECT estado, cidade FROM configuracoes");
	list($UF,$CIDADE) = mysql_fetch_array($sql_cidadeuf);

	// recebe os dados do formulario
	$cod=				$_POST["txtCodCart"];
	$diretor_cpf=		$_POST["txtCpfDiretor"];
	$responsavel_cpf=	$_POST["txtCpfResponsavel"];
	$municipio=			$_POST["txtMunicipioEmpresa"];
	$uf=				$_POST["txtUfEmpresa"];
	$estado=			$_POST["rdbEstado"];
	$admpublica=		$_POST["cmbAdmPublica"];
	$nivel=				$_POST["cmbNivel"];
	$nome=				trataString($_POST["txtNome"]);
	$complemento=		trataString($_POST["txtComplemento"]);
	$razaosocial=		trataString($_POST["txtRazao"]);
	$cnpj=				trataString($_POST["txtCnpj"]);
	$diretor=			trataString($_POST["txtDiretor"]);
	$responsavel=		trataString($_POST["txtResponsavel"]);
	$inscmunicipal=		trataString($_POST["txtInscMunicipal"]);
	$logradouro=		trataString($_POST["txtLogradouro"]);
	$bairro=			trataString($_POST["txtBairro"]);
	$cep=				trataString($_POST["txtCEP"]);
	$numero=			trataString($_POST["txtLogradouroNro"]);
	$email=				trataString($_POST["txtEmail"]);
	$fonecomercial=		trataString($_POST["txtFoneComercial"]);
	$fonecelular=		trataString($_POST["txtFoneAdicional"]);
	$senha=				trataString($_POST["txtSenha"]);
	$senhaconf=			trataString($_POST["txtSenhaConf"]);
	
	//inclui a pagina quando o botao cadastrar for clicado
	if($_POST['btCadastrar']){
		include("inc/cartorios/cadastro_inserir.php");
		?><script>LimpaCampos('frmCadastroCart');</script><?php
	}
	if($_POST['btDesativar']){
		$codigo=$_POST['hdDesativar'];
		mysql_query("UPDATE cadastro SET estado = 'I' WHERE codigo='$codigo'");
		$codigo="";
		Mensagem("Cartório desativado!");
	}
	
	if($_POST['btAtivar']){
		$codigo=$_POST["hdDesativar"];
		mysql_query("UPDATE cadastro SET estado = 'A' WHERE codigo='$codigo'");
		$codigo="";
		Mensagem("Cartório ativado!");
	}
					
	if($_POST['btExcluir']){
		$codigo=$_POST["hdDesativar"];
		mysql_query("DELETE FROM cadastro WHERE codigo=$codigo");
		$codigo="";
		Mensagem("Cartório excluído com sucesso!");
	}
?>
<!--cria a div de consulta de cartorios-->
<style type="text/css">
<!--
#divBuscaCart {
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
<div id="divBuscaCart"  ><?php include("inc/cartorios/pesquisar.php"); ?></div>

<?php
	//transforma as variaveis com apenas um caractere em informação completa para o usuario
	switch($nivel){
	case "M": $nivel ="Municipal"; break;
	case "E": $nivel ="Estadual"; break;
	case "F": $nivel ="Federal"; break;
	}
	
	switch($admpublica){
	case "I": $admpublica ="Indireta"; break;
	case "D": $admpublica ="Direta"; break;
	}
	
	switch($estado){
	case "A": $estado ="Ativo"; break;
	case "I": $estado ="Inativo"; break;
	case "NL": $estado ="Não Liberado"; break;
	}
	//testa se tem o codigo e coloca numa variavel
	if($_POST["CODCART"]){
		$codigo=$_POST["CODCART"];
		
		//seleciona no banco o cartorio com o codigo do cartorio e monta as variaveis
		$sql=mysql_query("SELECT cadastro.codigo, cadastro.nome, cadastro.razaosocial, cadastro.cnpj, cadastro.municipio, cadastro.uf, cadastro.logradouro, cadastro.numero, cadastro.bairro, cadastro.complemento, cadastro.email, cadastro.fonecomercial, cadastro.fonecelular, cadastro.estado, cartorios.admpublica, cartorios.nivel, cadastro.cep, cadastro.inscrmunicipal, cadastro.senha FROM cadastro INNER JOIN cadastro_resp ON cadastro_resp.codemissor=cadastro.codigo INNER JOIN cartorios ON cartorios.codcadastro=cadastro.codigo WHERE cadastro.codigo='$codigo'");
		list($codcart, $nome, $razaosocial, $cnpj, $municipio, $uf, $logradouro, $numero, $numero, $complemento, $email, $fonecomercial, $fonecelular, $estado, $admpublica, $nivel, $cep, $inscrmunicipal, $senha)=mysql_fetch_array($sql);

		$resp=codcargo('responsavel');
		$diret=codcargo('diretor');
		$sql_resp= mysql_query("SELECT nome, cpf FROM cadastro_resp WHERE codemissor='$codigo' AND codcargo='$resp' LIMIT 1");
		$sql_diretor= mysql_query("SELECT nome, cpf FROM cadastro_resp WHERE codemissor='$codigo' AND codcargo='$diret' LIMIT 1");
		list($responsavel, $responsavel_cpf)=mysql_fetch_array($sql_resp);
		list($diretor, $diretor_cpf)=mysql_fetch_array($sql_diretor);

		//transforma as variaveis com apenas um caractere em informação completa para o usuario
		switch($nivel){
		case "M": $nivel ="Municipal"; break;
		case "E": $nivel ="Estadual"; break;
		case "F": $nivel ="Federal"; break;
		}
		
		switch($admpublica){
		case "I": $admpublica ="Indireta"; break;
		case "D": $admpublica ="Direta"; break;
		}
		
		switch($estado){
		case "A": $estado ="Ativo"; break;
		case "I": $estado ="Inativo"; break;
		case "NL": $estado ="Não Liberado"; break;
		}
	}//fim do if post
?>
<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC" width="700">
	<tr>
		<td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
		<td width="671" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;Cartórios - Cadastro</td>  
		<td width="30" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
	</tr>
	<tr>
		<td width="18" background="img/form/lateralesq.jpg"></td>
		<td>
            <table width="718">
                <tr>
                    <td>
                        <form method="post" id="frmCadastroCart">
                        <input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
                        <input type="hidden" name="txtCodCart" value="<?php echo $codcart; ?>" />
                        <fieldset><legend>Cadastro de Cartórios</legend>
                            <table align="left">
                                <tr align="left">
                                    <td width="150"><font color="#FF0000">*</font> Nome:</td>
                                    <td colspan="2"><input type="text" class="texto" <?php if($codigo) echo "disabled=\"disabled\""; ?> name="txtNome" size="60" id="txtNome" value="<?php echo $nome; ?>" /></td>
                                </tr>
                                <tr align="left">
                                    <td><font color="#FF0000">*</font> Razão Social:</td>
                                    <td colspan="2"><input type="text" class="texto" <?php if($codigo) echo "disabled=\"disabled\""; ?> name="txtRazao" size="60" id="txtRazao" value="<?php echo $razaosocial; ?>" /></td>
                                </tr>
                                <tr align="left">
                                    <td><font color="#FF0000">*</font> CNPJ:</td>
                                    <td colspan="2"><input type="text" class="texto" <?php if($codigo) echo "disabled=\"disabled\""; ?> name="txtCnpj" size="25" nkeydown="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );" maxlength="18" id="txtCnpj" value="<?php echo $cnpj; ?>" /></td>
                                </tr>
                                <tr align="left">
                                    <td>&nbsp;&nbsp;&nbsp;Inscrição Municipal:</td>
                                    <td colspan="2"><input type="text" class="texto" <?php if($codigo) echo "disabled=\"disabled\""; ?> name="txtInscMunicipal" size="60" id="txtInscMunicipal" value="<?php echo $inscmunicipal; ?>" /></td>
                                </tr>
                                <tr align="left">
                                    <td><font color="#FF0000">*</font> CEP:</td>
                                    <td colspan="2"><input type="text" maxlength="9" <?php if($codigo) echo "disabled=\"disabled\""; ?> class="texto" onkeydown="return NumbersOnly( event );" onkeyup="CEPMsk( this );" name="txtCEP" id="txtCEP" value="<?php echo $cep; ?>" /></td>
                                </tr>
                                <tr align="left">
                                    <td><font color="#FF0000">*</font> Logradouro:</td>
                                    <td><input type="text" class="texto" name="txtLogradouro" <?php if($codigo) echo "disabled=\"disabled\""; ?> id="txtLogradouro" size="60" value="<?php echo $logradouro; ?>" /></td>
                                </tr>
                                <tr align="left">
                                    <td><font color="#FF0000">*</font> Bairro:</td>
                                    <td><input type="text" class="texto" name="txtBairro" <?php if($codigo) echo "disabled=\"disabled\""; ?> id="txtBairro" size="40" value="<?php echo $bairro; ?>" /></td>
                                </tr>
                                <tr align="left">
                                    <td><font color="#FF0000">*</font> Número:</td>
                                    <td><input type="text" class="texto" size="9" maxlength="9" <?php if($codigo) echo "disabled=\"disabled\""; ?> name="txtLogradouroNro" id="txtLogradouroNro" value="<?php echo $numero; ?>"/></td>
                                </tr>
                                <tr align="left">
                                    <td>&nbsp;&nbsp;&nbsp;Complemento:</td>
                                    <td><input type="text" class="texto" size="20" maxlength="20" <?php if($codigo) echo "disabled=\"disabled\""; ?> name="txtComplemento" id="txtComplemento" value="<?php echo $complemento; ?>"/></td>
                                </tr>
                                <tr align="left">
                                    <td><font color="#FF0000">*</font> UF:</td>
                                    <td align="left" colspan="2" <?php if($codigo) echo "style=\"display:none\"" ?>>
                                        <select name="txtUfEmpresa" id="txtUfEmpresa" onchange="buscaCidades(this,'txtMunicipioEmpresa')" class="combo">
                                            <?php
                                                $sql=mysql_query("SELECT uf FROM municipios GROUP BY uf ORDER BY uf");
                                                while(list($uf_busca)=mysql_fetch_array($sql)){
                                                echo "<option value=\"$uf_busca\"";if($uf_busca == $UF){ echo "selected=selected"; }echo ">$uf_busca</option>";
                                                }
                                            ?>
                                        </select>
                                        <?php 
                                            if ($codigo){
                                                echo "<td align=\"left\" colspan=\"2\"><input type=\"text\" disabled=\"disabled\" class=\"texto\" size=\"40\" maxlength=\"15\" value=\"$uf\" />";
                                            }
                                        ?>          
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left"><font color="#FF0000">*</font> Município</td>
                                    <td align="left" colspan="2" <?php if($codigo) echo "style=\"display:none\"" ?>>
                                        <div  id="txtMunicipioEmpresa" >
                                            <select name="txtMunicipioEmpresa" id="txtMunicipioEmpresa" class="combo">
												<?php
                                                $sql_municipio = mysql_query("SELECT nome FROM municipios WHERE uf = '$UF'");
                                                while(list($nome) = mysql_fetch_array($sql_municipio)){
                                                echo "<option value=\"$nome\"";if(strtolower($nome) == strtolower($CIDADE)){ echo "selected=selected";} echo ">$nome</option>";
                                                }//fim while 
                                                ?>
                                            </select>
                                        </div>
                                        <?php
                                            if ($codigo){
                                                echo "<td align=\"left\" colspan=\"2\"><input type=\"text\" disabled=\"disabled\" class=\"texto\" size=\"40\" maxlength=\"15\" value=\"$municipio\" />";
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <tr align="left">
                                    <td><font color="#FF0000">*</font> Email:</td>
                                    <td colspan="2"><input type="text" class="texto" <?php if($codigo) echo "disabled=\"disabled\""; ?> name="txtEmail" size="30" id="txtEmail" value="<?php echo $email; ?>" /></td>
                                </tr>
                                <tr align="left">
                                    <td><font color="#FF0000">*</font> Telefone Comercial:</td>
                                    <td colspan="2"><input type="text" class="texto" <?php if($codigo) echo "disabled=\"disabled\""; ?> name="txtFoneComercial" id="txtFoneComercial" value="<?php echo $fonecomercial; ?>" /></td>
                                </tr>
                                <tr align="left">
                                    <td>&nbsp;&nbsp;&nbsp;Telefone Adicional:</td>
                                    <td colspan="2"><input type="text" class="texto" <?php if($codigo) echo "disabled=\"disabled\""; ?> name="txtFoneAdicional" value="<?php echo $fonecelular; ?>" /></td>
                                </tr>
                                <tr><td colspan="3"><hr /></td></tr>
                                <tr align="left">
                                    <td><font color="#FF0000">*</font> Diretor:</td>
                                    <td colspan="2"><input type="text" class="texto" <?php if($codigo) echo "disabled=\"disabled\""; ?> name="txtDiretor" size="30" id="txtDiretor" value="<?php echo $diretor; ?>" /></td>
                                </tr>
                                <tr align="left">
                                    <td><font color="#FF0000">*</font> CPF Diretor:</td>
                                    <td colspan="2"><input type="text" class="texto" <?php if($codigo) echo "disabled=\"disabled\""; ?> name="txtCpfDiretor" size="40" onkeydown="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );" maxlength="14" id="txtCpfDiretor" value="<?php echo $diretor_cpf; ?>" /></td> 
                                </tr>
                                <tr align="left">
                                    <td><font color="#FF0000">*</font> Responsável:</td>
                                    <td colspan="2"><input type="text" class="texto" <?php if($codigo) echo "disabled=\"disabled\""; ?> name="txtResponsavel" size="40" id="txtResponsavel" value="<?php echo $responsavel; ?>" /></td>
                                </tr>
                                <tr align="left">
                                    <td><font color="#FF0000">*</font> CPF Responsável:</td>
                                    <td colspan="2"><input type="text" class="texto" <?php if($codigo) echo "disabled=\"disabled\""; ?> name="txtCpfResponsavel" size="30" onkeydown="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );" maxlength="14" id="txtCpfResponsavel" value="<?php echo $responsavel_cpf; ?>" /></td>
                                </tr>
                                <tr><td colspan="3"><hr /></td></tr>
                                <tr align="left">
                                    <td><font color="#FF0000">*</font> Adm. Pública</td>
                                    <td colspan="2">
                                        <select name="cmbAdmPublica" id="cmbAdmPublica" <?php if($codigo) echo "style=\"display:none\"" ?>>
                                            <?php
                                                if($admpublica=="D"){echo "<option value=\"$admpublica\">Direta</option>";}
                                                elseif($admpublica=="I"){echo "<option value=\"$admpublica\">Indireta</option>";}
                                            ?>
                                        <option value="D">Direta</option>
                                        <option value="I">Indireta</option>
                                        </select>
                                        <?php 
                                            if ($codigo){ 
                                                echo "<input type=\"text\" disabled=\"disabled\" class=\"texto\" size=\"40\" maxlength=\"15\" value=\"$admpublica\" />";
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <tr align="left">
                                    <td><font color="#FF0000">*</font> Nível</td>
                                    <td colspan="2">
                                        <select name="cmbNivel" id="cmbNivel" <?php if($codigo) echo "style=\"display:none\"" ?>>
                                            <?php
                                                if($nivel=="M"){echo "<option value=\"$nivel\">Municipal</option>";}
                                                elseif($admpublica=="E"){echo "<option value=\"$nivel\">Estadual</option>";}
                                                elseif($admpublica=="F"){echo "<option value=\"$nivel\">Federal</option>";}
                                            ?>
                                        <option value="M">Municipal</option>
                                        <option value="E">Estadual</option>
                                        <option value="F">Federal</option>
                                        </select>
                                        <?php 
                                            if ($codigo){
                                                echo "<input type=\"text\" disabled=\"disabled\" class=\"texto\" size=\"40\" maxlength=\"15\" value=\"$nivel\" />";
                                            }
                                        ?>
                                    </td>
									</tr>
                                    <tr align="left">
                                        <td><font color="#FF0000">*</font> Senha:</td>
                                        <td colspan="2"><input type="password" maxlength="14" <?php if($codigo) echo "disabled=\"disabled\""; ?> class="texto" name="txtSenha" value="<?php echo $senha; ?>" id="txtSenha" /></td>
                                    </tr>
                                    <tr>
                                        <td align="left"><font color="#FF0000">*</font> Confirma Senha:</td>
                                        <td align="left">
                                            <input type="password" size="12" maxlength="10" <?php if($codigo) echo "disabled=\"disabled\""; ?> name="txtSenhaConf" id="txtSenhaConf" value="<?php echo $senha; ?>" class="texto" />
                                        </td>
                                    </tr>
                                <tr align="left"  <?php if($codigo) echo "style=\"display:none\"" ?>>
                                    <td><input type="radio" name="rdbEstado" value="A"<?php if(($estado=="")||($estado=="A")){echo "checked=\"checked\"";} ?> />Ativo</td>
                                    <td colspan="2"><input type="radio" name="rdbEstado" value="I"<?php if($estado=="I"){echo "checked=\"checked\"";} ?> />Inativo</td>
                                </tr>
                                    <?php 
                                        if($codigo){ echo" 
                                            <tr>
                                                <td><font color=\"#FF0000\">*</font> Estado:</td>
                                                <td><input type=\"text\" disabled=\"disabled\" class=\"texto\" size=\"15\" maxlength=\"15\" value=\"$estado\" /></td>
                                            </tr>";
                                        }
                                    ?>
                                <tr align="left"><td colspan="2"><font color="#FF0000">* Campos Obrigatórios</font></td></tr>
                                <tr align="left">
                                    <td colspan="2">
                                        <input type="submit" name="btBuscarCliente" value="Buscar" class="botao" />
                                            <?php 
                                                if ($codigo){
                                                    echo "<input type=\"submit\" class=\"botao\" value=\"Voltar\" onclick=\"LimpaCampos('frmCadastroCart');Redireciona('cadastro.php');\" />&nbsp;<input type=\"hidden\" name=\"hdDesativar\" id=\"hdDesativar\" value=\"$codigo\"/><input type=\"submit\" name=\"btComprovante\" value=\"Comprovante\" class=\"botao\" onclick=\"return ValidaFormulario('txtCodCart', 'Busque por uma Instituição Financeira antes de gerar o comprovante')\" />&nbsp;";
                                                }
												/*<input type=\"submit\" class=\"botao\" name=\"btExcluir\" id=\"btExcluir\" value=\"Excluir Cartório\" onclick=\"return Confirma('Deseja Excluir Cartório?');\" />&nbsp;*/
                                                if($estado == "Ativo"){
                                                    echo "<input type=\"submit\" class=\"botao\" name=\"btDesativar\" id=\"btDesativar\" value=\"Desativar Cartório\"/>&nbsp;";
                                                }
                                                elseif($estado == "Inativo"){
                                                    echo "<input type=\"submit\" class=\"botao\" name=\"btAtivar\" id=\"btAtivar\" value=\"Ativar Cartório\"/>&nbsp;";
                                                }
                                            ?>
                                        <input type="submit" class="botao" name="btCadastrar" <?php if($codigo){echo "style=\"display:none\"";} ?> value="Cadastrar" onclick="return ValidaFormulario('txtCpfDiretor|txtCpfResponsavel|txtMunicipioEmpresa|txtUfEmpresa|rdbEstado|cmbAdmPublica|cmbNivel|txtNome|txtComplemento|txtRazao|txtCnpj|txtDiretor|txtResponsavel|txtInscMunicipal|txtLogradouro|txtBairro|txtCEP|txtLogradouroNro|txtEmail|txtFoneComercial|txtFoneAdicional|txtSenha|txtSenhaConf', 'Preencha todos os campos obrigatórios.')" />&nbsp;
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                        </form>
					</td>
				</tr>
			</table>
		</td>
		<td width="1" height="0" background="img/form/lateraldir.jpg"></td>
	</tr>
	<tr>
		<td align="left" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantoesq.jpg" /></td>
		<td background="img/form/rodape_fundo.jpg"></td>
		<td align="right" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantodir.jpg" /></td>
	</tr>
</table>