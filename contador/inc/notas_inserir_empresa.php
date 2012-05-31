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
		$login = $_SESSION['login'];
	
	if($btSelecionarEmpresa==""){
		$cmbEmpresa=$_POST['cmbEmpresa'];
		$campo = tipoPessoa($login);
		$sql=mysql_query("SELECT codigo FROM cadastro WHERE $campo='$login'");
		list($codcontador)=mysql_fetch_array($sql);
		$declaracao = coddeclaracao('Simples Nacional');
		$sql=mysql_query("SELECT codigo, razaosocial FROM cadastro WHERE codcontador='$codcontador'");
		if(mysql_num_rows($sql)>0){
?>	
<form method="post" action="notas.php?btEmpresa=T&btInserir=T">
	<table>
		<tr>
			<td>
				Selecione uma empresa
			</td>
			<td>
				<select name="cmbEmpresa" id="cmbEmpresa">
					<?php
						while(list($codigo,$razaosocial)=mysql_fetch_array($sql))
							{
								echo "<option value=\"$codigo\">$razaosocial</option>";
							}
					?>
				</select>
			</td>
			<td>
				<input type="submit" name="btSelecionarEmpresa" value="Selecionar" class="botao" />
			</td>
		</tr>
	</table>
</form>
<?php
}
	else{echo "Nenhuma empresa cadastrada";}
}
if($btSelecionarEmpresa!=""){
 if($btInserirNota !="")
 {
 	$CODIGO_DA_EMPRESA = $_POST['cmbEmpresa'];
	//Variaveis com os valores preenchidos da nota
	$tomadorCnpj             = $_POST['txtTomadorCNPJ'];
	$tomadorNome             = $_POST['txtTomadorNome'];
	$tomadorInscMunic        = $_POST['txtTomadorIM'];
	$tomadorLogradouro       = $_POST['txtTomadorLogradouro'];
	$tomadorNumero           = $_POST['txtTomadorNumero'];
	$tomadorComplemento      = $_POST['txtTomadorComplemento'];
	$tomadorBairro           = $_POST['txtTomadorBairro'];
	$tomadorCep              = $_POST['txtTomadorCEP'];
	if(!empty($_POST['txtTomadorMunicipio'])){
		$tomadorMunicipio    = $_POST['txtTomadorMunicipio'];
	}else{
		$tomadorMunicipio    = $_POST['txtInsMunicipioEmpresa'];
	}
	$tomadorUF               = $_POST['txtTomadorUF'];
	$tomadorEmail            = $_POST['txtTomadorEmail'];
	$notaRpsNumero           = $_POST['txtRpsNum'];
	$notaRpsData             = DataMysql($_POST['txtDataRps']);
	$notaNumero              = $_POST['txtNotaNumero'];
	$notaDataHoraEmissao     = $_POST['txtNotaDataHoraEmissao'];
	$notaCodigoVerificacao   = $_POST['txtNotaCodigoVerificacao'];
	$notaDiscriminacao       = $_POST['txtNotaDiscriminacao'];
	$notaObservacao          = $_POST['txtObsNota'];
	$notaValorDeducoes       = MoedaToDec($_POST['txtValorDeducoes']);
	$notaTotalBasedeCalculo  = MoedaToDec($_POST['txtBaseCalculo']);
	//$notaAliquota            = MoedaToDec($_POST['txtAliquota']);
	$notaTotalValorISS       = MoedaToDec($_POST['txtISS']);
	$notaTotalValorISSRetido = MoedaToDec($_POST['txtIssRetido']);
	$notaAliquotaINSS        = $_POST['txtAliquotaINSS'];
	$notaValorINSS           = MoedaToDec($_POST['txtValorINSS']);
	$notaAliquotaIRRF        = $_POST['txtIRRF'];
	$notaDeducaoIRRF         = MoedaToDec($_POST['txtDeducIRRF']);
	$notaValorIRRF           = MoedaToDec($_POST['txtValorFinalIRRF']);
	$notaValorTotalRetencoes = MoedaToDec($_POST['txtValTotalRetencao']);
	$notaCredito             = MoedaToDec($_POST['txtCredito']);
	$notaValorTotal          = MoedaToDec($_POST['txtValTotal']);
	
	//Seleciona a ultima nota inserida pela empresa
	$sql = mysql_query("SELECT ultimanota FROM cadastro WHERE codigo = '$CODIGO_DA_EMPRESA'");
	list($ultimanota)=mysql_fetch_array($sql);
	$ultimanota ++;
	
	//busca o limite de notas desse emissor
	$sql=mysql_query("SELECT notalimite FROM cadastro WHERE codigo = $CODIGO_DA_EMPRESA");
	list($notalimite)=mysql_fetch_array($sql);
	
	//testa se o numero de notas limites ja foi ultrapassado se ja tiver ultrapassado avisa-o
	if(($ultimanota>$notalimite)&&($notalimite!=0)) {
	
		Mensagem('Voc&ecirc; n&atilde;o pode emitir NFe por que ultrapassou seu limite estabelecido pelo AIDF. Entre em contato com a prefeitura.');
		Redireciona('notas.php');
		
	}elseif(($ultimanota<=$notalimite)||($notalimite==0)){  
		if(($tomadorNome !="") && ($tomadorCnpj !="") && ($notaTotalBasedeCalculo !="")){  
			
			$aux = explode(" ", $notaDataHoraEmissao);
			$notaEmissaoData = DataMysql($aux[0]);
			$notaEmissaoHora = $aux[1].":00";
			
	
			//Faz uma busca pelo tomador
			$sql = mysql_query("SELECT * FROM cadastro WHERE cnpj='$tomadorCnpj' or cpf='$tomadorCnpj'");
			//Testa se o tomador o pessoa fisica ou pessoa juridica
			$campo = tipoPessoa($tomadorCnpj);
						
			//Testa se o tomador existe caso nao exista cria-o no banco
			if(mysql_num_rows($sql)<=0){
			
				$codtipo = codtipo('tomador');
				$codtipodec = coddeclaracao('DES Simplificada');
				mysql_query("
					INSERT INTO 
						cadastro
					SET 
						nome = '$tomadorNome',
						$campo = '$tomadorCnpj',
						inscrmunicipal = '$tomadorInscMunic',
						codtipo = '$codtipo', 
						codtipodeclaracao = '$codtipodec', 
						logradouro = '$tomadorLogradouro',
						numero = '$tomadorNumero',
						complemento = '$tomadorComplemento',
						bairro = '$tomadorBairro',
						cep = '$tomadorCep',
						municipio = '$tomadorMunicipio',
						uf = '$tomadorUF',
						email = '$tomadorEmail',
						estado = 'A'
				");
			}
		
			//Sql que insere os dados da nota emitida no banco
			$sql = mysql_query("
				INSERT INTO 
					notas 
				SET 
					numero = '$ultimanota', 
					codverificacao = '$notaCodigoVerificacao', 
					codemissor = '$CODIGO_DA_EMPRESA', 
					rps_numero = '$notaRpsNumero', 
					rps_data = '$notaRpsData',
					tomador_nome = '$tomadorNome', 
					tomador_cnpjcpf = '$tomadorCnpj',
					tomador_inscrmunicipal = '$tomadorInscMunic',		
					tomador_logradouro = '$tomadorLogradouro',
					tomador_numero = '$tomadorNumero',
					tomador_complemento = '$tomadorComplemento',
					tomador_bairro = '$tomadorBairro',		 
					tomador_cep = '$tomadorCep', 
					tomador_municipio = '$tomadorMunicipio',
					tomador_uf = '$tomadorUF',
					tomador_email = '$tomadorEmail', 
					discriminacao = '$notaDiscriminacao',
					valortotal = '$notaValorTotal', 
					valordeducoes = '$notaValorDeducoes', 
					basecalculo = '$notaTotalBasedeCalculo',
					valoriss = '$notaTotalValorISS', 
					credito = '$notaCredito', 
					estado = 'N',
					datahoraemissao = '$notaEmissaoData $notaEmissaoHora', 
					issretido = '$notaTotalValorISSRetido', 
					valorinss = '$notaValorINSS', 
					aliqinss = '$notaAliquotaINSS',
					valorirrf = '$notaValorIRRF', 
					aliqirrf = '$notaAliquotaIRRF', 
					deducao_irrf = '$notaDeducaoIRRF', 
					total_retencao = '$notaValorTotalRetencoes',
					observacao = '$notaObservacao'
			");   
			
			
			
			//Variaveis com relecao aos servicos da nota
			$quantidadeInputs = $_POST['hdInputs']; //numero de inputs de servicos
			$codigoUltimaNota = mysql_insert_id(); //ultimo codigo que foi inserido no mysql
			$cont = 1;
			
			while($cont <= $quantidadeInputs){
				$aux = explode("|",$_POST['cmbCodServico'.$cont]);
				$servicoCodigo = $aux[1];
				$servicoBaseCalc = MoedaToDec($_POST['txtBaseCalcServico'.$cont]);
				$servicoValorISS = MoedaToDec($_POST['txtValorIssServico'.$cont]);
				$servicoISSRetido = MoedaToDec($_POST['txtISSRetidoManual'.$cont]);
				
				$sql_servicos_notas = mysql_query("
					INSERT INTO 
						notas_servicos
					SET
						codnota = '$codigoUltimaNota',
						codservico = '$servicoCodigo',
						basecalculo = '$servicoBaseCalc',
						iss = '$servicoValorISS',
						issretido = '$servicoISSRetido'
				");
				$cont++;
			}
			
			$sql = mysql_query("UPDATE cadastro SET ultimanota= '$ultimanota' WHERE codigo = '$CODIGO_DA_EMPRESA'");
			add_logs('Emitiu nota fiscal');
			
			//Envia o email informando o tomador que foi inserida uma nfe
			if($tomadorEmail){
			
				$email_enviado = "";				
				//Chama a funcao que envia o email para o tomador
				$email_enviado = notificaTomador($CODIGO_DA_EMPRESA,$ultimanota);
			
			}
			//------------------------------------------------------------
			
			if($email_enviado){
			
				print("<script language=JavaScript>alert('Nota Emitida com sucesso e tomador notificado!!')</script>");
			}else{
				print("<script language=JavaScript>alert('Nota Emitida com sucesso!!')</script>");
			}
		}else{
			print("<script language=JavaScript>alert('Favor preencher campos obrigatórios')</script>");
		}
 }
}


// SELECIONA A ULTIMA NOTA INSERIDA PELA EMPRESA
$sql=mysql_query("SELECT ultimanota, codtipodeclaracao, cpf, cnpj FROM cadastro WHERE codigo ='$cmbEmpresa'");
list($ultimanota,$codtipodeclaracao,$emp_cpf,$emp_cnpj)=mysql_fetch_array($sql);
$ultimanota += 1;

$emp_cnpj.=$emp_cpf;

//GERA O CÓDIGO DE VERIFICAÇÃO
$CaracteresAceitos = 'ABCDEFGHIJKLMNOPQRXTUVWXYZ';
$max = strlen($CaracteresAceitos)-1;
$password = null;
 for($i=0; $i < 8; $i++) {
 $password .= $CaracteresAceitos{mt_rand(0, $max)}; 
 $carac = strlen($password); 
 if($carac ==4)
 { 
 $password .= "-";
 } 
}

$sql_servicos=mysql_query("
	  SELECT 
		  cadastro_servicos.codigo,
		  servicos.codigo,
		  servicos.codservico,
		  servicos.descricao,
		  servicos.aliquota, 
		  servicos.aliquotair,
		  servicos.basecalculo 
	  FROM servicos
	  INNER JOIN cadastro_servicos ON servicos.codigo = cadastro_servicos.codservico
	  WHERE cadastro_servicos.codemissor = '$cmbEmpresa'");

$sql_lista_regrasdecredito = mysql_query("SELECT credito, tipopessoa, issretido, valor FROM nfe_creditos WHERE estado = 'A' ORDER BY valor DESC");
while(list($nfe_cred,$nfe_tipo_pessoa,$nfe_issretido,$nfe_valor) = mysql_fetch_array($sql_lista_regrasdecredito)){
	$array_regras_credito[] = $nfe_tipo_pessoa."|".$nfe_issretido."|".$nfe_valor."|".$nfe_cred;
}

$regras_credito = implode("-",$array_regras_credito);

 ?>

<br>
<form name="frmInserir" method="post" action="notas.php?btEmpresa=T&btInserir=T&btSelecionarEmpresa=T&btInserirNota=T" id="frmInserir" onsubmit="return ValidarInserirNota()">

<table border="0" align="center" cellpadding="0" cellspacing="1">
    <tr>
      <td width="10" height="10" bgcolor="#FFFFFF"></td>
	  <td width="100" align="center" bgcolor="#FFFFFF" rowspan="3">Inserir Nota</td>
      <td width="470" bgcolor="#FFFFFF"></td>
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

<table width="100%" border="0" cellspacing="2" cellpadding="2" align="center">
  <tr>    
	<td  align="left" colspan="3"><font color="#FF0000" size="-2">OBS: Não utilizar a tecla Enter para alternar entre os campos.</font>  </td>
  </tr>
  <tr>
    <td colspan="3"><strong><br />
      Informações da Nota</strong>
	</td>
  </tr>
  <tr>
   <td colspan="3">
    
   </td>
  </tr>  
  <tr>
    <td align="center">Número</td>
    <td align="center">Data e Hora de Emissão</td>
    <td align="center">Código de Verificação</td>
  </tr>
  <tr>
    <td align="center"><input name="txtNotaNumero" style="text-align:center;" type="text" size="10" class="texto" readonly="yes" value="<?php print $ultimanota;?> "></td>
    <td align="center">
		<input name="txtNotaDataHoraEmissao" style="text-align:center;" type="text" size="20" class="texto" readonly="yes" 
		value="<?php print date('d/m/Y H:i'); ?>">
	</td>
    <td align="center"><input name="txtNotaCodigoVerificacao" style="text-align:center;" type="text" size="20" class="texto" readonly="yes" value="<?php print $password;?>"></td>
  </tr>  
   <tr>
    <td align="left">Número do RPS</td>
	<td align="left" colspan="2"><input name="txtRpsNum" style="text-align:center;" onkeydown="return NumbersOnly( event );" type="text" size="20" class="texto"></td>
  </tr>
  <tr>
    <td align="left">Data do RPS</td>
	<td align="left" colspan="2"><input name="txtDataRps" style="text-align:center;" onkeydown="return NumbersOnly( event );" type="text" size="10" maxlength="10" class="texto">
	(dd/mm/aaaa) <em>Somente n&uacute;meros</em></td>
  </tr>
</table><br />


<table width="100%" border="0" cellspacing="2" cellpadding="2"> 
  <tr>
    <td colspan="2"><strong>Tomador de Serviços</strong></td>
  </tr>
  <tr>
    <td align="left" width="25%">CPF/CNPJ<font color="#FF0000">*</font></td>
    <td align="left"><input name="txtTomadorCNPJ" type="text" size="20" class="texto" onkeydown="stopMsk( event );return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );"  maxlength="18" id="txtTomadorCNPJ" onblur="acessoAjax('inc/tomador_nota.ajax.php','frmInserir','divContainer',true);"></td>
  </tr>
 </table>   
<div id="divContainer">
<table width="100%" border="0" cellspacing="2" cellpadding="2"> 
<tr>
    <td width="25%" align="left">Nome/Razão Social<font color="#FF0000">*</font></td>
    <td width="75%" align="left"><input name="txtTomadorNome" id="txtTomadorNome" type="text" size="55" class="texto">
</td>
  </tr>  
  <tr>
    <td align="left">Inscrição Municipal</td>
    <td align="left"><input name="txtTomadorIM" type="text" onkeydown="return NumbersOnly( event );" size="30" class="texto" ></td>
  </tr>
  <tr>
    <td align="left">Logradouro</td>
    <td align="left"><input name="txtTomadorLogradouro" type="text" size="30" class="texto">
     &nbsp;&nbsp;Número <input name="txtTomadorNumero" type="text" onkeydown="return NumbersOnly( event );" size="5" class="texto" maxlength="5"  />
	</td>
  </tr>  
  <tr>
    <td align="left">Complemento</td>
    <td align="left"><input name="txtTomadorComplemento" type="text" size="30" class="texto">
	</td>
  </tr>
  <tr>
    <td align="left">Bairro</td>
    <td align="left"><input name="txtTomadorBairro" type="text" size="30" class="texto"></td>
  </tr>
  <tr>
    <td align="left">CEP</td>
    <td align="left">
	 <input name="txtTomadorCEP" type="text" size="15" class="texto" onkeydown="return NumbersOnly( event );" maxlength="9"  onkeyup="MaskCEP(this);" >
	</td>
  </tr>
  <tr>
    <td align="left">UF<font color="#FF0000">*</font></td>
    <td align="left">
    <!--ESTE SELECT ESTA COM A NOMENCLATTURA DE UM TEXT PARA MANTER A COMPATIBILIDADE DO ARQUIVO INSERIR.PHP COM TODOS OS ARQUIVOS DE CADASTRO DE EMPRESAS-->
        <select name="txtTomadorUF" id="txtTomadorUF" onchange="buscaCidades(this,'txtTomadorMunicipio')">
            <option value=""></option>
            <?php
                $sqlcidades=mysql_query("SELECT uf FROM municipios GROUP BY uf ORDER BY uf");
                while(list($uf_busca)=mysql_fetch_array($sqlcidades)){
                    echo "<option value=\"$uf_busca\"";if($uf_busca == $UF_MUNICIPIO){ echo "selected=selected"; }echo ">$uf_busca</option>";
                }
            ?>
        </select>
    </td>
  </tr>
  <tr>
    <td>
		Município<font color="#FF0000">*</font></td>
    <td>
        <div  id="txtTomadorMunicipio">
            <select name="txtTomadorMunicipio" id="txtTomadorMunicipio" class="combo">
                <?php
                    $sql_municipio = mysql_query("SELECT nome FROM municipios WHERE uf = '$uf_busca'");
                    while(list($nome_municipio) = mysql_fetch_array($sql_municipio)){
                        echo "<option value=\"$nome_municipio\"";if(strtolower($nome_municipio) == strtolower($NOME_MUNICIPIO)){ echo "selected=selected";} echo ">$nome_municipio</option>";
                    }//fim while 
                ?>
            </select>
        </div>
    </td>
  </tr>
  <tr>
    <td align="left">E-mail</td>
    <td align="left"><input name="txtTomadorEmail" type="text" size="30" class="email"><font color="#FF0000">**</font></td>
  </tr>
  <tr>
  	<td colspan="8" align="right"><font color="#FF0000">**</font><i>Digite o e-mail do tomador para que o mesmo seja notificado sobre a emissão.</i></td>
  </tr>
</table>  
</div>

<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><strong>Discriminação dos Serviços e/ou Deduções</strong></td>
  </tr>
  <tr>
   <td align="center">
	<textarea name="txtNotaDiscriminacao" cols="53" rows="5" class="texto" ></textarea>
	<input type="hidden" name="cmbEmpresa" value="<?php echo $cmbEmpresa; ?>" />
   </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td colspan="2"><strong>C&aacute;lculos da Nota </strong></td>
  </tr>
  <tr>
  	<td colspan="18">
    <?php
	$CODIGO_DA_EMPRESA = $cmbEmpresa;
	$codtipodec_teste = coddeclaracao('Simples Nacional');
	//echo $codtipodec."<br>";
	//echo $codtipodec_teste;
	//if($tipopessoa == 'cpf'){
		// include("calculos_nota_inserir_rpa.php");
	if($codtipodeclaracao == $codtipodec_teste){
		include("calculos_nota_inserir_simplesnacional.php");	
	}else{
		include("calculos_nota_inserir.php");
	}
	
	?>
	</td>
  </tr>
	  
	<tr>
    	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
	</tr>
</table>
</td></tr></table></form>
<?php
}
?>