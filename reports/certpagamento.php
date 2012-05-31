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
session_start();
include("../include/conect.php");
include("../funcoes/util.php");
if (!$_GET['CODV']){
	Mensagem(" COD Inválido");
	Redireciona("../site/certidoes.php");
}
if (!$_SESSION['SESSAO_cnpj_emissor']){
	Mensagem(" CNPJ Inválido");
	Redireciona("../site/certidoes.php");
}

$cnpjcpf_empresa =$_SESSION['SESSAO_cnpj_emissor'];
$codverif = base64_decode($_GET['CODV']);

$sql_banco = mysql_query (" SELECT bancos.banco
							FROM bancos
							INNER JOIN boleto ON bancos.codigo = boleto.codbanco");

list($nome_banco) = mysql_fetch_array($sql_banco);

$sql=mysql_query("
			SELECT 
				certidoes_pagamento.codigo,
				certidoes_pagamento.codverificacao,
				certidoes_pagamento.dataemissao,
				certidoes_pagamento.datavalidade,
				emissores.nome,
				emissores.cnpjcpf,
				emissores.endereco,
				emissores.codigo
			FROM 
				certidoes_pagamento
			INNER JOIN 
				emissores ON certidoes_pagamento.codemissor=emissores.codigo
			WHERE 
				emissores.cnpjcpf='$cnpjcpf_empresa' AND
				certidoes_pagamento.codigo = '$codverif'");	

list($nrodoc,$codverificacao,$certemissao,$certvalidade,$nomeempresa,$cnpjcpf,$endereco,$codemissor)=mysql_fetch_array($sql);
$temp_emissao = explode("-",$certemissao);
$anoemissao = $temp_emissao[0];
$anoemissao--;
$certemissao2 = $anoemissao."-".$temp_emissao[1]."-".$temp_emissao[2];

$tomador_CNPJ = $cnpjcpf_empresa;

//verifica se tem o emissor cadastrado
$sql_emissor=mysql_query("SELECT codigo, nome, razaosocial, inscrmunicipal, endereco, municipio, uf, email 
				  FROM emissores 
				  WHERE cnpjcpf='$tomador_CNPJ'");
if(mysql_num_rows($sql_emissor)) {
	$resultado = "s";
	$existe_emissor = "s";
}

$sql_tomador = mysql_query ("SELECT codigo, 
									nome, 
									inscrmunicipal, 
									endereco, 
									municipio, 
									uf, 
									email 
							FROM tomadores 
							WHERE cnpjcpf='$tomador_CNPJ'");
if (mysql_num_rows($sql_tomador)){
	$resultado = "s";
	$existe_tomador = "s";
}

if ($resultado){
	
	if ($existe_emissor){
		$stringSql[0] = ("(
			SELECT
				guia_pagamento.codigo, 
				guia_pagamento.dataemissao,
				guia_pagamento.valor, 
				guia_pagamento.datavencimento,
				guia_pagamento.pago
			FROM
				guia_pagamento 
			INNER JOIN
				guias_declaracoes ON guia_pagamento.codigo = guias_declaracoes.codguia
			INNER JOIN
				des ON des.codigo = guias_declaracoes.codrelacionamento 
			INNER JOIN
				emissores ON emissores.codigo = des.codemissor
			WHERE
				guia_pagamento.pago = 'S'  AND
				emissores.cnpjcpf = '$tomador_CNPJ' AND
				guias_declaracoes.relacionamento = 'des'
		)"); 
	}
	if ($existe_tomador) {
		$stringSql[2] = ("
			(SELECT
			  guia_pagamento.codigo, 
			  guia_pagamento.dataemissao,
			  guia_pagamento.valor, 
			  guia_pagamento.datavencimento,
			  guia_pagamento.pago
			FROM
			  guia_pagamento 
			INNER JOIN
			  guias_declaracoes ON guias_declaracoes.codguia = guia_pagamento.codigo
			INNER JOIN
			  des_issretido ON des_issretido.codigo = guias_declaracoes.codrelacionamento 
			INNER JOIN
			  tomadores ON tomadores.codigo = des_issretido.codtomador
			WHERE
			  guia_pagamento.pago = 'S'  AND
			  tomadores.cnpjcpf = '$tomador_CNPJ' AND
			  guias_declaracoes.relacionamento = 'des_issretido')"); 
	}
	$string_Sql = implode(" UNION ",$stringSql)." ORDER BY datavencimento";
	$sql_guias = mysql_query($string_Sql);
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Certid&atilde;o de Pagamento de ISS</title>
<link href="../css/imprimir_certidoes.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="800" border="0" cellspacing="0" cellpadding="5" align="center">
  <tr>
    <td height="100" colspan="4">
	<table border="0" cellspacing="0" cellpadding="5" style="border: 0px;">
      <tr>
        <td width="150" style="border:0px;" align="left"><?php if($CONF_BRASAO){?><img src="../img/brasoes/<?php echo rawurlencode($CONF_BRASAO); ?>"><?php }?></td>
        <td width="520" style="border:0px;" align="left" valign="middle">
		<font class="prefeitura">Prefeitura Municipal de <?php echo $CONF_CIDADE; ?></font><br>
		<font class="secretaria"><?php echo $CONF_SECRETARIA; ?><br>
		Demonstrativo de Pagamentos do ISS		</font></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="25%" height="30" align="center" bgcolor="#CCCCCC"><strong>Documento N&ordm;.</strong></td>
    <td width="25%" align="center" bgcolor="#CCCCCC"><strong>C&oacute;digo de Verifica&ccedil;&atilde;o </strong></td>
    <td width="25%" align="center" bgcolor="#CCCCCC"><strong>Data de Emiss&atilde;o </strong></td>
    <td width="25%" align="center" bgcolor="#CCCCCC"><strong>Data de Validade</strong></td>
  </tr>
  <tr>
    <td height="30" align="center"><font class="prefeitura"><?php echo $nrodoc; ?></font></td>
    <td align="center"><font class="prefeitura"><?php echo $codverificacao; ?></font></td>
    <td align="center"><font class="prefeitura"><?php echo DataPt($certemissao); ?></font></td>
    <td align="center"><font class="prefeitura"><?php echo DataPt($certvalidade); ?></font></td>
  </tr>
  <tr>
    <td height="30" colspan="4" align="center" bgcolor="#CCCCCC"><strong>IDENTIFICA&Ccedil;&Atilde;O DO SUJEITO PASSIVO </strong></td>
  </tr>
  <tr>
    <td height="50" colspan="3" valign="top">Nome<br>
    <font class="prefeitura"><?php echo $nomeempresa; ?></font></td>
    <td valign="top">CNPJ/CPF<br>
    <font class="prefeitura"><?php echo $cnpjcpf; ?></font></td>
  </tr>
  <tr>
    <td height="75" colspan="4" valign="top">Endere&ccedil;o<br>
    <font class="prefeitura"><?php echo $endereco; ?></font></td>
  </tr>
  <tr>
    <td height="30" colspan="4" align="center" bgcolor="#CCCCCC"><strong>PAGAMENTOS EFETUADOS </strong></td>
  </tr>
  <tr>
    <td height="20" align="center" valign="middle"><strong>Guia</strong></td>
    <td height="20" align="center" valign="middle"><strong>Data</strong></td>
    <td height="20" align="center" valign="middle"><strong>Banco</strong></td>
    <td height="20" align="center" valign="middle"><strong>Valor Pago (R$) </strong></td>
  </tr>
	<?php 
	while(list($codigo_guia, $dataemissao_guia, $valor_guia, $datavencimento_guia, $pago_guia) = mysql_fetch_array($sql_guias)){
  		$valor_total += $valor_guia;
		?>
	  <tr>
	    <td height="20" align="center" valign="middle"><?php echo $codigo_guia; ?></td>
	    <td height="20" align="center" valign="middle"><?php echo DataPt($dataemissao_guia); ?></td>
	    <td height="20" align="center" valign="middle"><?php echo $nome_banco; ?></td>
	    <td height="20" align="center" valign="middle"><?php echo DecToMoeda($valor_guia); ?></td>
	  </tr>
		<?php 
	}
	?>
  <tr>
    <td height="20" colspan="3" align="right" valign="middle"><strong>Valor Total (R$)</strong>&nbsp;&nbsp;</td>
    <td height="20" align="center" valign="middle"><?php echo DecToMoeda($valor_total); ?></td>
  </tr>
  <tr>
    <td height="100" colspan="4" align="center" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td height="30" colspan="4" align="center" bgcolor="#CCCCCC"><strong>OBSERVA&Ccedil;&Otilde;ES</strong></td>
  </tr>
  <tr>
    <td colspan="4"><p>- O presente documento somente tem validade:<br>
	&nbsp;&nbsp;&nbsp;&nbsp;a. Quando n&atilde;o apresentar rasuras;<br>
	&nbsp;&nbsp;&nbsp;&nbsp;b. At&eacute; a data de validade exposta acima;</p>
    </td>
  </tr>
  <tr>
    <td height="50" colspan="4">A aceita&ccedil;&atilde;o deste documento esta condicionada &agrave; verifica&ccedil;&atilde;o de sua validade, de forma exclusiva pelo aceitante junto &agrave; Prefeitura Municipal de <font class="prefeitura"><?php echo $CONF_CIDADE; ?></font>.  </td>
  </tr>
</table>
</body>
</html>
