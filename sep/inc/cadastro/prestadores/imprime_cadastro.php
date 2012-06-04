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
include("../../conect.php");
include("../../../funcoes/util.php");
//Recebe as variáveis 

//Seleciona o brasao da seguinte prefeitura
$sql_brs= mysql_query("SELECT brasao FROM configuracoes"); 
//lista a variável q receberá ao seguinte brasão
list($BRASAO) = mysql_fetch_array($sql_brs);

$codigo = $_POST['CODEMISSOR'];

$cnpj = $_POST["txtCNPJ"];
$sql_instituicaologada = mysql_query("
	SELECT 
		c.codigo, 
		c.nome, 
		c.razaosocial, 
		c.senha, 
		c.cnpj, 
		c.cpf, 
		c.inscrmunicipal, 
		c.logradouro,
		c.bairro,
		c.cep, 
		c.numero, 
		c.complemento, 
		c.municipio, 
		c.uf, 
		c.email, 
		c.fonecomercial, 
		c.fonecelular, 
		c.estado,
		c.codtipodeclaracao,
		c.nfe,
		t.nome,
		d.declaracao
	FROM 
		cadastro as c
	INNER JOIN
		tipo as t ON t.codigo = c.codtipo
	INNER JOIN
		declaracoes as d ON d.codigo = c.codtipodeclaracao
	WHERE 
		c.codigo = '$codigo'
");
//echo mysql_error();
list($codigo,$nome,$razao_soc,$senha,$cnpj,$cpf,$insc_municip,$logradouro,$bairro,$cep,$numero,$complemento,$municipio,$uf,
	$email,$fone_comercial,$fone_celular,$estado,$tipo_declaracao,$nfe,$tipo,$tipo_declaracao) = mysql_fetch_array($sql_instituicaologada);
$endereco = "$logradouro, $numero";
if($complemento)
	$endereco .= ", $complemento";
$cpf_cnpj = $cnpj . $cpf;

switch($estado){
		case "NL": $estado = "Aguardando a Liberação da prefeitura";		break;
		case "A" : $estado = "Liberado";									break;
		case "I" : $estado = "Empresa inativa";								break;
}//fim switch estado

//Pega o valor de qual tipo
//recebe as informacoes do form pelo post
/*$tipo = $_POST['cmbCodtipo'];
// separa o caracter especifico do tipo e cria array para mostrar somente o nome isolado
$tipo = explode('|',$tipo);
$sql_tipo = mysql_query("SELECT nome FROM tipo WHERE codigo='".$tipo[0]."'");
list($tipo) = mysql_fetch_array($sql_tipo);
$nome = $_POST['txtInsNomeEmpresa'];
$razao_soc = $_POST['txtInsRazaoSocial'];
$cpf_cnpj = $_POST['txtInsCpfCnpjEmpresa'];
$insc_municip = $_POST['txtInsInscMunicipalEmpresa'];
$logradouro = $_POST['txtInsEnderecoEmpresa'];
$numero = $_POST['txtNumero'];
$complemento = $_POST['txtComplemento'];
$bairro = $_POST['txtBairro'];
$cep = $_POST['txtCEP'];
$fone_comercial = $_POST['txtFoneComercial'];
$fone_celular = $_POST['txtFoneCelular'];
$uf = $_POST['txtInsUfEmpresa'];
$municipio = $_POST['txtInsMunicipioEmpresa'];
$email = $_POST['txtInsEmailEmpresa'];
$tipo_declaracao = $_POST['cmbTipoDec'];

// converte string em maiusculas
$nfe = strtoupper($_POST['txtNfe']);

// busca nome por extenso conforme codigo do tipo da declaracao
$busca_tipo_declaracao = mysql_query("SELECT declaracoes.declaracao FROM declaracoes INNER JOIN cadastro ON declaracoes.codigo = cadastro.codtipodeclaracao WHERE cadastro.codigo ='$codigo'");
list($tipo_declaracao_extens) = mysql_fetch_array($busca_tipo_declaracao);
*/
// converte 's' e 'n' para 'sim' e 'nao'
if($nfe == 's')
{$nfe = 'SIM';}
elseif ($nfe == 'n')
{$nfe = 'NÃO';}



/*if($estado == 'A')
{$estado = 'ATIVO';}
elseif($estado == 'I')
{$estado = 'INATIVO';}
elseif($estado == "")
{$estado = 'Não Informado';}
*/

// verifica se os campos nao obrigatorios estao vazios, caso estejam, mostra mensagem de valor Nao Informado
$insc_municip = verificacampo($insc_municip);
$fone_celular = verificacampo($fone_celular);
$complemento = verificacampo($complemento);
$nfe = verificacampo($nfe);

?>
<html>
<head>
<title>Imprimir Libera&ccedil;&atilde;o</title>
<style type="text/css">
<!--
.style1 {
	font-family: Georgia, "Times New Roman", Times, serif
}
.tabela {	
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	border-collapse:collapse;
	border: 1px solid #000000;
}
-->
</style>
</head>

<body> 
<div id="DivImprimir">
  <input name="button" type="button" onClick="print();this.style.display = 'none';" value="Imprimir" />
</div>
<table width="700px" height="120" border="2" align="center" cellspacing="0" class="tabela">
  <tr align="center">
    <td width="106"><center>
      <img src="../../../img/brasoes/<?php print $BRASAO; ?>" alt="cabecalho" width="96" height="105">
    </center></td>
    <td width="584" height="33" colspan="2">
	    <span class="style1">
			CADASTRO DE PRESTADOR<br /><br />
			PREFEITURA MUNICIPAL DE <?php print strtoupper($CONF_CIDADE); ?><br /><br />
			<?php print strtoupper($CONF_SECRETARIA); ?>
	    </span>
    </td>
  </tr>
</table>
<br>
<table width="700" border="1" align="center" cellpadding="0" cellspacing="0" class="tabela">
  <tr>
    <td colspan="2" bgcolor="#999999"><div align="center"><strong>Dados Cadastrais </strong></div></td>
  </tr>
  <tr><?php // comeca a disposicao dos dados na tela em uma tabela em forma de relatorio  
  ?>
    <td colspan="2"><div align="left"><strong>Tipo </strong>: <?php echo $tipo; ?></div></td>
  </tr>
  <tr>
    <td colspan="2"><strong>Nome </strong>:<?php echo $nome; ?></td>
  </tr>
  <tr>
    <td colspan="2"><strong>Raz&atilde;o Social </strong>:<?php echo $razao_soc; ?></td>
  </tr>
  <tr>
    <td colspan="2"><strong>CNPJ/CPF </strong>: <?php echo $cpf_cnpj; ?></td>
  </tr>
  <tr>
    <td colspan="2"><strong>Insc. Municipal </strong>: <?php echo $insc_municip; ?></td>
  </tr>
  <tr>
    <td colspan="2"><strong>Logradouro </strong>: <?php echo $logradouro; ?></td>
  </tr>
  <tr>
    <td colspan="2"><strong>N&uacute;mero </strong>: <?php echo $numero; ?></td>
  </tr>
  <tr>
    <td colspan="2"><strong>Complemento </strong>: <?php echo $complemento; ?></td>
  </tr>
  <tr>
    <td colspan="2"><strong>Bairro </strong>: <?php echo $bairro; ?></td>
  </tr>
  <tr>
    <td colspan="2"><strong>CEP </strong>: <?php echo $cep; ?></td>
  </tr>
  <tr>
    <td colspan="2"><strong>Telefone Comercial  </strong>: <?php echo $fone_comercial; ?></td>
  </tr>
  <tr>
    <td colspan="2"><strong>Telefone Celular  </strong>: <?php echo $fone_celular; ?></td>
  </tr>
  <tr>
    <td colspan="2"><strong>UF </strong>: <?php echo $uf; ?></td>
  </tr>
  <tr>
    <td colspan="2"><strong>Munic&iacute;pio </strong>: <?php echo $municipio; ?></td>
  </tr>
  <tr>
    <td colspan="2"><strong>E-mail </strong>: <?php echo $email; ?></td>
  </tr>
  <tr>
    <td colspan="2"><strong>Tipo de Declara&ccedil;&atilde;o  </strong>: <?php echo $tipo_declaracao_extens; ?></td>
  </tr>
  <tr>
    <td colspan="2"><strong>Emite NFe  </strong>: <?php echo $nfe; ?></td>
  </tr>
<tr>
    <td colspan="2"><strong>Estado </strong>:
	<?php echo $estado; ?></td>
  </tr>
  <tr>
  	<?php 
  	$codcargo = codcargo('Responsável');
  	$busca_resp = mysql_query("SELECT nome, cpf FROM cadastro_resp WHERE codemissor = '$codigo' AND codcargo=$codcargo");
  	list($responsavel,$cpf_resp) = mysql_fetch_array($busca_resp);
  	?>
    <td width="383"><strong>Respons&aacute;vel </strong>: <?php echo $responsavel;?>  </td>
    <td width="311"><strong>CPF </strong>: <?php echo $cpf_resp;?></td>
  </tr>
  
 <?php 
  $codcargo = codcargo('Sócio');
  $busca_socio = mysql_query("SELECT nome, cpf FROM cadastro_resp WHERE codemissor = '$cod_emissor' AND codcargo=$codcargo");
  // uso do while para exibir cada registro encontrado
  while(list ($nome_socio,$cpf_socio) = mysql_fetch_array($busca_socio)){
  ?>
  <tr>
    <td><strong>S&oacute;cio </strong>: <?php 
	
	
	echo $nome_socio; "<br>"?> </td>
    <td><strong>CPF </strong>: <?php echo $cpf_socio; ?></td>
  </tr>
  <?php
  }
  ?>
  <?php 
  $busca_categoria = mysql_query("
  	SELECT 
  		servicos_categorias.nome 
  	FROM 
  		servicos_categorias 
  	INNER JOIN 
  		servicos ON servicos_categorias.codigo = servicos.codcategoria 
  	INNER JOIN 
  		cadastro_servicos ON cadastro_servicos.codservico = servicos.codigo 
  	WHERE 
  		cadastro_servicos.codemissor = '$cod_emissor' 
  	GROUP BY 
  		servicos_categorias.nome 
  	ORDER BY 
  		servicos_categorias.nome;");
  // uso do while para exibir cada registro encontrado
  while(list($categoria) = mysql_fetch_array($busca_categoria)){
  ?>
  <tr>
    <td colspan="2"><strong>Categoria </strong>: <?php 
	echo $categoria ;  "<br>" ?>
	</td>
  
  </tr>
  <?php
  }
  // fim do relatorio
  ?>
 
</table>
<br>
</body>
</html>
