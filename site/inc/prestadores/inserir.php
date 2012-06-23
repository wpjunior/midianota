<?php 
require_once("../../../include/conect.php");
require_once("../../../funcoes/util.php");

$nome               = trataString($_POST['txtInsNomeEmpresa']);
$razaosocial        = trataString($_POST['txtInsRazaoSocial']);
$cpfcnpj            = $_POST['txtCNPJ'];
$logradouro         = trataString($_POST['txtLogradouro']);
$numero             = trataString($_POST['txtNumero']);
$complemento        = trataString($_POST['txtComplemento']);
$bairro             = trataString($_POST['txtBairro']);
$cep                = $_POST['txtCEP'];
$fone               = $_POST['txtFoneComercial'];
$celular            = $_POST['txtFoneCelular'];
$inscricaomunicipal = trataString($_POST['txtInsInscMunicipalEmpresa']);
$pispasep			= trataString($_POST['txtPispasep']);
$email              = trataString($_POST['txtInsEmailEmpresa']);
$tipopessoa         = $_POST['cmbTipoPessoaEmpresa'];
$municipio          = $_POST['txtInsMunicipioEmpresa'];
$login              = $_POST['txtCNPJ'];
$senha              = md5($_POST['txtSenha']);
$simplesnacional    = $_POST['txtSimplesNacional'];
$CODCAT             = $_POST['txtMAXCODIGOCAT'];
$nfe                = $_POST['txtNfe'];
$uf                 = $_POST['txtInsUfEmpresa'];

    $sql=mysql_query("SELECT MAX(codigo) FROM servicos_categorias");
	list($maxcodigo)=mysql_fetch_array($sql);
	$sql_categoria=mysql_query("SELECT codigo FROM servicos_categorias WHERE nome ='Contábil'");	
	list($codigocategoria)=mysql_fetch_array($sql_categoria);
	$categoria=1;
	$servico=1;
	$tipo="empresa";
	while($servico<=5){
		$nomecategoria=explode("|",$_POST['cmbCategoria'.$servico]);
		if($nomecategoria[0]=="$codigocategoria"){
				$tipo="contador";					
		}
				
		while($categoria<=$maxcodigo){
			if($_POST['cmbCodigo'.$categoria.$servico]!=""){$cmbCodigo="qualquercoisa";}
			$categoria++;	
		}	
		$servico++;	
	}
    if($tipo == "contador"){
        $sql = mysql_query("SELECT codigo FROM tipo WHERE tipo = 'contador'");
    }
    else{
        $sql = mysql_query("SELECT codigo FROM tipo WHERE tipo = 'prestador'");
    }
	
    list($codtipo)=mysql_fetch_array($sql);

    if($simplesnacional){
        $sql=mysql_query("SELECT codigo FROM declaracoes WHERE declaracao = 'Simples Nacional'");
    }else{
        $sql=mysql_query("SELECT codigo FROM declaracoes WHERE declaracao = 'DES Consolidada'");
    }
    list($codtipodeclaracao)=mysql_fetch_array($sql);


    if((strlen($cpfcnpj)!=14)&&(strlen($cpfcnpj)!=18)){
        echo "
			<script>
				alert('O CPF/CNPJ informado não é válido');
				window.location='../../prestadores.php';
			</script>
		";
    }


    $campo = tipoPessoa($cpfcnpj);
	$teste_nome        = mysql_query("SELECT codigo FROM cadastro WHERE nome = '$nome'");
	$teste_razaosocial = mysql_query("SELECT codigo FROM cadastro WHERE razaosocial = '$razaosocial'");
	$teste_cnpj        = mysql_query("SELECT codigo, codtipo FROM cadastro WHERE $campo = '$cpfcnpj'");
	
	$msg = "";
	$erro = 0;
	$codtipo_tomador = codtipo('tomador');
	
	if(mysql_num_rows($teste_cnpj)>0){
		$msg = "Já existe um prestador de serviços com este CPF/CNPJ";
		$erro = 2;
	}elseif(mysql_num_rows($teste_razaosocial)>0){
		$msg = "Já existe um prestador de serviços com esta razão social";
		$erro = 1;
	}elseif(mysql_num_rows($teste_nome)>0){
		$msg = "Já existe um prestador de serviços com este nome";
		$erro = 1;
	}
		//
		if($erro == 1){
			Mensagem($msg);
			Redireciona('../../prestadores.php');
		}elseif($erro == 2){
			list($codigo,$codtipo) = mysql_fetch_array($teste_cnpj);
			if($codtipo == $codtipo_tomador){
				$acao = "atualizar";
			}else{
				Mensagem($msg);
				Redireciona('../../prestadores.php');
			}
		}else{
			$acao = "inserir";
		}
		

        $codtipo = codtipo('prestador');
		if($acao == "inserir"){
			$sql = mysql_query("
				INSERT INTO 
					cadastro
				SET 
					nome = '$nome',
					senha = '$senha',
					razaosocial = '$razaosocial',
					$campo = '$cpfcnpj',
					logradouro = '$logradouro',
					numero = '$numero',
					complemento = '$complemento',
					bairro = '$bairro',
					cep = '$cep',
					inscrmunicipal = '$inscricaomunicipal',
					municipio ='$municipio',
					estado = 'NL',
					nfe = 'S',
					email = '$email',
					uf = '$uf',
					ultimanota = 0,
					fonecomercial = '$fone',
					fonecelular = '$celular',
					codtipo = '$codtipo',
					codtipodeclaracao = '$codtipodeclaracao',
					pispasep='$pispasep'
			") or die(mysql_error());
		}elseif($acao == "atualizar"){
			$sql = mysql_query("
				UPDATE 
					cadastro
				SET 
					nome = '$nome',
					senha = '$senha',
					razaosocial = '$razaosocial',
					$campo = '$cpfcnpj',
					logradouro = '$logradouro',
					numero = '$numero',
					complemento = '$complemento',
					bairro = '$bairro',
					cep = '$cep',
					inscrmunicipal = '$inscricaomunicipal',
					municipio ='$municipio',
					estado = 'NL',
					nfe = 'S',
					email = '$email',
					uf = '$uf',
					ultimanota = 0,
					fonecomercial = '$fone',
					fonecelular = '$celular',
					codtipo = '$codtipo',
					codtipodeclaracao = '$codtipodeclaracao',
					pispasep='$pispasep'
				WHERE
					codigo = '$codigo'
			") or die(mysql_error());
		}
		

		$sql_url_site = mysql_query("SELECT site, brasao_nfe FROM configuracoes");
		list($LINK_ACESSO) = mysql_fetch_array($sql_url_site);
		
		
		$imagemTratada = $_SERVER['HTTP_HOST']."/img/brasoes/".rawurlencode($CONF_BRASAO);
		$msg = "
		<a href=\"$LINK_ACESSO\" style=\"text-decoration:none\" ><img src=\"$imagemTratada\" alt=\"Brasão Prefeitura\" title=\"Brasão\" border=\"0\" width=\"100\" height=\"100\" /></a><br><br>
		O cadastro da empresa $nome foi efetuado com sucesso.<br>
		Dados da empresa:<br><br>
		Razão Social: $razaosocial<br>
		CPF/CNPJ: $cpfcnpj<br>
		Município: $municipio<br>
		Endereco: $logradouro, $numero<br><br>
		  
		Veja passo a passo como acessar o sistema:	<br><br>
		1- Acesse o site <a href=\"$LINK_ACESSO\"><b>NF-e</b></a><br>
		2- Entre em consulta, insira seu CNPJ/CPF e verifique se ja foi liberado seu acesso ao sistema<br>
		3- Clique no link Prestador<br>
		4- Entre em acessar o sistema<br>
		5- Em login insira o cpf/cnpf da empresa<br>
		6- Sua senha é <b><font color=\"RED\">$senha</font></b><br>
		7- Insira o código de verificação que aparece ao lado<br>";
		
		$assunto = "Acesso ao Sistema NF-e ($CONF_CIDADE).";
	
		$headers  = "MIME-Version: 1.0\r\n";
	
		$headers .= "Content-type: text/html; charset=UTF-8\r\n";
	
		$headers .= "From: $CONF_SECRETARIA de $CONF_CIDADE <$CONF_EMAIL>  \r\n";
	
		$headers .= "Cc: \r\n";
	
		$headers .= "Bcc: \r\n";
		
		mail("$email",$assunto,$msg,$headers);
		
		
			
		
		// busca empresa no banco --------------------------------------------------------------------------------------------------		
		$sql_empresa = mysql_query("SELECT codigo FROM cadastro WHERE $campo = '$cpfcnpj'");
		list($CODEMPRESA) = mysql_fetch_array($sql_empresa);
	
		
	
		// INSERCAO DE SERVICOS POR EMPRESA INICIO----------------------------------------------------------------------------------		
			$nroservicos = 5;
			//$vetor_servicos = array($cmbCodigo1,$cmbCodigo2,$cmbCodigo3,$cmbCodigo4,$cmbCodigo5);		
		//Insere os servicos no banco...		
			
			//vetores para adicionar servicos
			 $sql_categoria=mysql_query("SELECT codigo,nome FROM servicos_categorias");
			 
			 $contpos=0;
			 while(list($codcategoria)=mysql_fetch_array($sql_categoria)) {   
			   $conts=1;
			   for($conts=1;$conts<=5;$conts++) {    
					$vetor_insere_servico[$contpos]=$_POST['cmbCodigo'.$codcategoria.$conts];
					if($_POST['cmbCodigo'.$codcategoria.$conts]){
						$sql = mysql_query("INSERT INTO cadastro_servicos
                                            SET codservico = '".$_POST['cmbCodigo'.$codcategoria.$conts]."',
                                            codemissor='$CODEMPRESA'");
					} 
					$contpos++;	
			   }		
			 }			
			
			
		// INSERCAO DE SERVICOS POR EMPRESA FIM
	
		// INSERCAO DE RESP/SOCIOS POR EMPRESA INICIO-------------------------------------------------------------------------------
		$contsocios = 0;
		$nrosocios = 10;
		
		$vetor_sociosnomes = array($txtNomeSocio1,$txtNomeSocio2,$txtNomeSocio3,$txtNomeSocio4,$txtNomeSocio5,$txtNomeSocio6,$txtNomeSocio7,$txtNomeSocio8,$txtNomeSocio9,$txtNomeSocio10);	
		$vetor_socioscpf = array($txtCpfSocio1,$txtCpfSocio2,$txtCpfSocio3,$txtCpfSocio4,$txtCpfSocio5,$txtCpfSocio6,$txtCpfSocio7,$txtCpfSocio8,$txtCpfSocio9,$txtCpfSocio10);	
	   //insere os socios no banco
		while($contsocios < $nrosocios) {   
			if($vetor_sociosnomes[$contsocios] != "") {
				//Especifica que na primeira posição será inserido um responsavel
                if($contsocios == 0){
                    $sql_cargo = mysql_query("SELECT codigo FROM cargos WHERE cargo = 'Responsável'");
                }else{
                    $sql_cargo = mysql_query("SELECT codigo FROM cargos WHERE cargo = 'Sócio'");
                }
                list($codcargo)=mysql_fetch_array($sql_cargo);
				$sql = mysql_query("INSERT INTO cadastro_resp
                                    SET codemissor = '$CODEMPRESA',
                                    nome = '$vetor_sociosnomes[$contsocios]',
                                    cpf = '$vetor_socioscpf[$contsocios]',
                                    codcargo = '$codcargo'");
			} // fim if	
			$contsocios++;
	   } // fim while   
		// INSERCAO DE RESP/SOCIOS POR EMPRESA FIM
		
	   
		//gera o comprovante em pdf 
		$CodEmp = base64_encode($CODEMPRESA);
		
		print "
			<script language=JavaScript> 
				alert('Empresa cadastrada! Não esqueça de Imprimir o comprovante de cadastro que abrirá em uma nova janela!');
				window.open('../../../reports/cadastro_comprovante.php?COD=$CodEmp');
				window.location='../../prestadores.php';
			</script>
		"; 
?>
