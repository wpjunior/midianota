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
	$sql = mysql_query("SELECT cidade, estado FROM configuracoes");
	list($CIDADE,$ESTADO) = mysql_fetch_array($sql);
	
	// recebe os dados do formulario
	$cod             = $_POST["txtCodInst"];
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
	
	
	if($_POST["btCadastrar"]){
		include("inc/instfinanceiras/cadastro_inserir.php");
		?><script>LimpaCampos('frmCadastroInst');</script><?php
	}
	if($_POST['btDesativar']){
		$codigo = $_POST['hdDesativar'];
		mysql_query("UPDATE cadastro SET estado = 'I' WHERE codigo = '$codigo'");
		add_logs('Atualizou um Cadastro: Inativo');
		Mensagem("Instituição Financeira desativada!");
		?><script>LimpaCampos('frmCadastroInst');</script><?php
	}
	
	if($_POST['btAtivar']){
		$codigo = $_POST["hdDesativar"];
		mysql_query("UPDATE cadastro SET estado = 'A' WHERE codigo = '$codigo'");
		add_logs('Atualizou um Cadastro: Ativo');
		Mensagem("Instituição Financeira ativada!");
		?><script>LimpaCampos('frmCadastroInst');</script><?php
	}
					
	if($_POST['btExcluir'])
	{
	 $codigo=$_POST["hdDesativar"];
	 mysql_query("DELETE FROM cadastro WHERE codigo = $codigo");
	 add_logs('Excluiu um Cadastro');
	 Mensagem("Instituição Financeira excluída com sucesso!");
	 ?><script>LimpaCampos('frmCadastroInst');</script><?php
	}
?>  



	<style type="text/css">
	<!--
	#divBuscaInst {
		position:absolute;
		left:40%;
		top:20%;
		width:298px;
		height:276px;
		z-index:1;
		visibility:<?php if(isset($_POST['btBuscarCliente'])){ echo"visible";}else{ echo"hidden";} ?>
	}
	-->
	</style>
	<div id="divBuscaInst"><?php include("inc/instfinanceiras/pesquisar.php"); ?></div> 
	<?php
		if($_POST["CODINST"]){
			$codigo = $_POST["CODINST"];
			$sql    = mysql_query("
				SELECT 
					cadastro.codigo, 
					cadastro.nome, 
					cadastro.razaosocial, 
					cadastro.senha, 
					cadastro.cnpj, 
					cadastro.inscrmunicipal, 
					cadastro.logradouro,
					cadastro.numero,
					cadastro.municipio,
					cadastro.bairro,
					cadastro.complemento,
					cadastro.uf, 
					cadastro.email, 
					cadastro.fonecomercial, 
					cadastro.fonecelular, 
					cadastro.estado,
					cadastro.cep,
					inst_financeiras.codbanco,
					inst_financeiras.agencia,
					gerente.nome, 
					gerente.cpf, 
					responsavel.nome, 
					responsavel.cpf
				FROM 
					cadastro 
				INNER JOIN
					inst_financeiras ON inst_financeiras.codcadastro = cadastro.codigo
				INNER JOIN
					cadastro_resp AS responsavel ON responsavel.codemissor = cadastro.codigo
				INNER JOIN
					cadastro_resp AS gerente ON gerente.codemissor = cadastro.codigo
				WHERE 
					cadastro.codigo = '$codigo' AND gerente.codcargo = '1' AND responsavel.codcargo = '2'
			");
				list($codigo,$nome,$razaosocial,$senha,$cnpj,$inscrmunicipal,$logradouro,$numero,$municipio,$bairro,$complemento,$uf,$email,$fonecomercial,$fonecelular,$estado,$cep,$codbanco,$agencia,$gerente,$gerente_cpf,$responsavel,$responsavel_cpf)=mysql_fetch_array($sql);
				$sqlbanco = mysql_query("SELECT banco FROM bancos WHERE codigo = '$codbanco'");
				list($banco) = mysql_fetch_array($sqlbanco);
				switch($estado){
					case "A" : $str_estado = "Ativo";        break;
					case "I" : $str_estado = "Inativo";      break;
					case "NL": $str_estado = "Não Liberado"; break;
				}
			}
	?>
<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
  <tr>
    <td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
    <td width="750" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">Institui&ccedil;&otilde;es Financeiras- Cadastro</td>  
    <td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
  </tr>
  <tr>
    <td width="18" background="img/form/lateralesq.jpg"></td>
    <td align="left">
        <form method="post" id="frmCadastroInst">
        <input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
        <input type="hidden" name="txtCodInst" value="<?php echo $codigo; ?>" />
            <fieldset><legend>Cadastro de Instituições Financeiras</legend>	
              <table width="100%" border="0" align="center">	   
                <tr>
                    <td width="135" align="left">Nome<font color="#FF0000">*</font></td>
                    <td align="left">
                    	<input type="text" size="60" maxlength="100" name="txtNome" id="txtNome"
                        class="texto" value="<?php echo $nome;?>">
                    </td>
                </tr>
                <tr>
                    <td width="135" align="left">Razão Social<font color="#FF0000">*</font></td>
                    <td align="left">
                    	<input type="text" size="60" maxlength="100" name="txtRazao" id="txtRazao" class="texto" 
                        value="<?php echo $razaosocial;?>">
                    </td>
                </tr>	   	
              
               <!-- alterna input cpf/cnpj-->
                <tr>
                <td align="left">CNPJ<font color="#FF0000">*</font></td> 
                <td align="left">
                    <input  id="txtCNPJ" type="text" size="20" maxlength="18"  name="txtCNPJ" class="texto" onkeydown="return NumbersOnly( event );" 
                    value="<?php echo $cnpj;?>"/>
                    <span id="spamdif"></span>
                </td>
                </tr>
               <!-- alterna input cpf/cnpj FIM-->   
                <tr>
                    <td align="left">Logradouro<font color="#FF0000">*</font></td>
                    <td align="left">
                    	<input type="text" size="60" maxlength="100" name="txtLogradouro" id="txtLogradouro" class="texto"
                        value="<?php echo $logradouro;?>"/>
                    </td>
                </tr>
                <tr>
                    <td align="left">Número<font color="#FF0000">*</font></td>
                    <td align="left">
                    	<input type="text" size="10" maxlength="10" class="texto" name="txtNumero" id="txtNumero" 
                        value="<?php echo $numero;?>"/>
                    </td>
                </tr>
                <tr>
                    <td align="left">Bairro<font color="#FF0000">*</font></td>
                    <td align="left">
                    	<input type="text" size="30" maxlength="100" class="texto" name="txtBairro" id="txtBairro"
                        value="<?php echo $bairro;?>" />
                    </td>
                </tr>
                <tr>
                    <td align="left">Complento</td>
                    <td align="left">
                    	<input type="text" size="10" maxlength="10" class="texto" name="txtComplemento" id="txtComplemento" 
                        value="<?php echo $complemento;?>"/>
                   	</td>
                </tr>
                <tr>
                    <td align="left">CEP<font color="#FF0000">*</font></td>
                    <td align="left">
                    	<input type="text" size="12" maxlength="9" class="texto" name="txtCEP" id="txtCEP" 
                        value="<?php echo $cep;?>"/>
                    </td>
                </tr>
                <tr>
                    <td align="left">Telefone Comercial<font color="#FF0000">*</font></td>
                    <td align="left">
                    	<input type="text" class="texto" size="20" maxlength="14" name="txtFoneComercial" id="txtFoneComercial"
                        value="<?php echo $fonecomercial;;?>"/>
                    </td>
                </tr>
                <tr>
                    <td align="left">Telefone Adcional</td>
                    <td align="left">
                    	<input type="text" class="texto" size="20" maxlength="14" name="txtFoneCelular" 
                        value="<?php echo $fonecelular;?>"/>
                    </td>
                </tr>
                <tr>
                    <td align="left">UF<font color="#FF0000">*</font></td>
                    <td align="left">
                        <!--ESTE SELECT ESTA COM A NOMENCLATTURA DE UM TEXT PARA MANTER A COMPATIBILIDADE DO ARQUIVO INSERIR.PHP COM TODOS OS ARQUIVOS DE CADASTRO DE EMPRESAS-->
                        <select name="txtInsUfEmpresa" id="txtInsUfEmpresa" onchange="buscaCidades(this,'txtInsMunicipioEmpresa',true)">
                            <option value=""></option>
                            <?php
                                $sql=mysql_query("SELECT uf FROM municipios GROUP BY uf ORDER BY uf");
                                while(list($uf_nome) = mysql_fetch_array($sql)){
                                    echo "<option value=\"$uf\"";if($uf_nome == $uf){ echo "selected = selected"; }echo ">$uf_nome</option>";
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="left">Município<font color="#FF0000">*</font></td>
                    <td align="left">
                        <div  id="txtInsMunicipioEmpresa">
                        	<?php
								if(!$uf){
									$uf = "SP";
								}
							?>
                            <select name="txtInsMunicipioEmpresa" class="combo">
                                <?php
                                    $sql_municipio = mysql_query("SELECT nome FROM municipios WHERE uf = '$uf'");
                                    while(list($nome) = mysql_fetch_array($sql_municipio)){
                                        echo "<option value=\"$nome\"";if($municipio == $nome){ echo "selected=selected";} echo ">$nome</option>";
                                    }//fim while 
                                ?>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="left">Insc. Municipal</td>
                    <td align="left">
                    	<input type="text" size="20" maxlength="20" name="txtInscrMunicipal" class="texto"
                        value="<?php echo $inscrmunicipal;?>"/>
                    </td>
                </tr>
                <tr>
                    <td align="left">Email<font color="#FF0000">*</font></td>
                    <td align="left">
                    	<input type="text" size="60" maxlength="100" name="txtInsEmailEmpresa" id="txtInsEmailEmpresa" class="texto"
                        value="<?php echo $email;?>"/>
                    </td>
                </tr>
            </table>
        </fieldset>
        <fieldset><legend>Dados Banco</legend>
            <table width="100%" border="0" align="center">
                <tr>
                    <td width="135" align="left">Gerente<font color="#FF0000">*</font></td>
                    <td align="left">
                    	<input type="text" size="60" maxlength="100" name="txtGerente" id="txtGerente" class="texto"
                        value="<?php echo $gerente;?>">
                    </td>
                </tr>
                <tr>
                    <td align="left">Gerente CPF<font color="#FF0000">*</font></td>
                    <td align="left">
                    	<input type="text" maxlength="13" size="20" name="txtGerenteCPF" id="txtGerenteCPF" class="texto"
                        value="<?php echo $gerente_cpf;?>">
                    </td>
                </tr>
                <tr>
                    <td align="left">Banco<font color="#FF0000">*</font></td>
                    <td align="left">
                        <select name="cmbBanco" id="cmbBanco" class="combo">
                            <option value=""></option>
                            <?php
                                $sql_banco = mysql_query("SELECT codigo, banco FROM bancos ORDER BY banco ASC");
                                while(list($codigo, $banco) = mysql_fetch_array($sql_banco)){
                                    echo "<option value=\"$codigo\"";if($codbanco == $codigo){ echo "selected = selected"; } echo ">$banco</option>";
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="left">Agencia<font color="#FF0000">*</font></td>
                    <td align="left">
                    	<input type="text" size="12" maxlength="10" name="txtAgencia" id="txtAgencia" class="texto"
                        value="<?php echo $agencia;?>">
                    </td>
                </tr>
             </table>
        </fieldset>
        <fieldset><legend>Dados responsável</legend>
             <table width="100%" border="0" align="center">
                <tr>
                    <td width="135" align="left">Responsável<font color="#FF0000">*</font></td>
                    <td align="left">
                    	<input type="text" size="60" maxlength="100" name="txtResponsavel" id="txtResponsavel" class="texto"
                        value="<?php echo $responsavel;?>">
                    </td>
                </tr>
                <tr>
                    <td align="left">Responsável CPF<font color="#FF0000">*</font></td>
                    <td align="left">
                    	<input type="text" maxlength="13" name="txtResponsavelCPF" id="txtResponsavelCPF" class="texto"
                        value="<?php echo $responsavel_cpf;?>">
                    </td>
                </tr>
            </table>
          </fieldset>
          <fieldset>
            <table>
            	<tr height="30" valign="bottom">
                	<?php if(!$_POST["CODINST"]){?>
                    	<td align="left">
                    		<input type="button" name="btCadastrar" value="Cadastrar" class="botao" onclick="return ValidaFormulario('txtNome|txtRazao|txtCNPJ|txtLogradouro|txtNumero|txtBairro|txtCEP|txtGerente|txtGerenteCPF|cmbBanco|txtAgencia|txtResponsavel|txtResponsavelCPF|txtFoneComercial|txtInsUfEmpresa|txtInsMunicipioEmpresa|txtInsEmailEmpresa','Preencha todos os campos obrigátorios!');" />
                        </td>
					<?php }?>
                    <td align="left">
                    	<input type="submit" name="btBuscarCliente" value="Buscar" class="botao"/>
                    </td>
                    <?php if($estado == "I"){?><td align="left"><input type="button" name="btAtivar" value="Ativar" class="botao" /></td><?php }?>
                    <?php if($estado == "A"){?><td align="left"><input type="button" name="btDesativar" value="Desativar" class="botao" /></td><?php }?>
                    <?php if($_POST["CODINST"]){?><td align="left"><input type="button" name="btExcluir" value="Excluir" class="botao" /></td><?php }?>
                    <?php if($estado == "A"){?><td align="left"><input type="button" name="btComprovante" value="Comprovante" class="botao" /></td><?php }?>
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