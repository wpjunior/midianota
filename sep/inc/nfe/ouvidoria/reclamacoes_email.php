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
// inicia a sessão verificando se jah esta com o usuario logado, se estiver entra na página admin
session_start();
if(!(isset($_SESSION["logado"]))) {   
	print("Acesso Negado!!");
}
else {
	include("../../conect.php");
	include("../../../funcoes/util.php");

// variaveis globais vindas do conect.php
// $CODPREF,$PREFEITURA,$USUARIO,$SENHA,$BANCO,$TOPO,$FUNDO,$SECRETARIA,$LEI,$DECRETO,$CREDITO,$UF	

// descriptografa o codigo
$CODIGO = base64_decode($CODIGO);

// sql feito na nota
$sql = mysql_query("
SELECT
  `reclamacoes`.`codigo`, `reclamacoes`.`assunto`,
  `reclamacoes`.`especificacao`, `reclamacoes`.`tomador_cnpj`,
  `reclamacoes`.`tomador_email`, `reclamacoes`.`rps_numero`,
  `reclamacoes`.`rps_data`, `reclamacoes`.`rps_valor`, `cadastro`.`nome`,
  IF(`cadastro`.`cnpj` <> '',`cadastro`.`cnpj`,`cadastro`.`cpf`), `reclamacoes`.`datareclamacao`,
  `reclamacoes`.`estado`, `reclamacoes`.`dataatendimento`,cadastro.email
FROM
  `reclamacoes` INNER JOIN
  `cadastro` ON `reclamacoes`.`emissor_cnpjcpf` = IF(`cadastro`.`cnpj` <> '',`cadastro`.`cnpj`,`cadastro`.`cpf`)
WHERE
  `reclamacoes`.`codigo` = '$CODIGO'") ;
  
  
list($codigo, $assunto, $especificacao, $tomador_cnpj, $tomador_email, $rps_numero, $rps_data, $rps_valor, $empresa_nome, $empresa_cnpjcpf, $datareclamacao, $estado, $dataatendimento,
$prest_email) = mysql_fetch_array($sql);


$sql_config = mysql_query("SELECT cidade, secretaria, brasao FROM configuracoes");
list($CIDADE,$SECRETARIA,$BRASAO) = mysql_fetch_array($sql_config);

$PREFEITURA = "Prefeitura Municipal de ".$CIDADE;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $PREFEITURA; ?> - NFe ISS - Comunicado</title>
</head>

<body>
<center>
<table width="800" border="1" cellspacing="0" cellpadding="2" style="border:#000000 solid">
  <tr>
    <td colspan="4" rowspan="3" width="75%" style="border:#000000 solid" align="center">
<!-- tabela prefeitura inicio -->	
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td rowspan="4" width="20%" align="center" valign="top"><img src="../../../img/brasoes/<?php print $BRASAO; ?>" width="100" height="100" /><br />
	<font class="codnota"><?php print $codigo; ?></font></td>
    <td width="80%" class="cab01"><?php print strtoupper($PREFEITURA); ?></td>
  </tr>
  <tr>
    <td class="cab03"><?php print strtoupper($SECRETARIA); ?></td>
  </tr>
  <tr>
    <td class="cab02">NOTA FISCAL ELETRÔNICA DE SERVIÇOS - NF-e</td>
  </tr>
  <tr>
    <td><strong>COMUNICADO DE NOTIFICAÇÃO ENTRE PARTES</strong></td>
  </tr>
</table>

<!-- tabela prefeitura fim -->	</td>
    <td width="25%" align="left" style="border:#000000 solid">Número da Reclamação<br /><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="3"><strong><?php print $CODIGO; ?></strong></font></div></td>
  </tr>
  <tr>
    <td align="left" style="border:#000000 solid">Data da Reclamação<br /><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="3"><strong><?php print (substr($datareclamacao,8,2)."/".substr($datareclamacao,5,2)."/".substr($datareclamacao,0,4)); ?></strong></font></div></td>
  </tr>
  <tr>
    <td align="left" style="border:#000000 solid">Estado da Reclamação<br /><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="3"><strong><?php print $estado; ?></strong></font></div></td>
  </tr>
  <tr>
    <td colspan="5" align="center" style="border:#000000 solid">
<!-- tabela tomador inicio -->	

<table width="95%" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td colspan="2" class="cab03" align="center"><?php echo strtoupper($especificacao); ?></td>
    </tr>
  <tr>
    <td align="left" width="15%">RPS - Número:</td>
    <td align="left" width="85%"><strong><?php print $rps_numero; ?></strong></td>
    </tr>
  <tr>
    <td align="left">RPS - Data:</td>
    <td align="left"><strong><?php print DataPt($rps_data); ?></strong></td>
  </tr>
  <tr>
    <td align="left">RPS - Valor:</td>
    <td align="left"><strong><?php print DecToMoeda($rps_valor); ?></strong></td>
    </tr>
</table>
		
<!-- tabela tomador fim -->	</td>
    </tr>
  <tr>
    <td colspan="5" align="center" style="border:#000000 solid">
	
<!-- tabela discrimacao dos servicos -->	
	
<table width="95%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td class="cab03">A T E N Ç Ã O</td>
  </tr>
  <tr>
    <td height="200" align="left" valign="top"><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A <strong><?php echo $PREFEITURA; ?></strong>, através deste e-mail, entra em contato com a empresa <strong><?php echo $empresa_nome; ?></strong>, registrada nesta Prefeitura Municipal com CNPJ/CPF <strong><?php echo $empresa_cnpjcpf; ?></strong>, na qual está cadastrada e registrada como emissora de NFe - ISS (Nota Fiscal Eletrônica de Serviços), para comunicar que foi enviado uma notificação de reclamação quanto a <strong><?php echo $especificacao; ?></strong> por parte do seguinte tomador:<br /><br />
	- Tomador CNPJ/CPF: <strong><?php print $tomador_cnpj; ?></strong><br /><br />
	- Tomador e-mail: <strong><?php print $tomador_email; ?></strong></td>
  </tr>
</table>
	
	
<!-- tabela discrimacao dos servicos -->
	</td>
    </tr>  
</table>
</center>
</body>
<?php

// envia por email

	$msg  = "

	
<table width=95% border=0 cellspacing=0 cellpadding=2>
  <tr>
    <td class=cab03>A T E N Ç Ã O</td>
  </tr>
  <tr>
    <td height=200 align=left valign=top><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A <strong>$PREFEITURA</strong>, através deste e-mail, entra em contato com a empresa <strong>$empresa_nome</strong>, registrada nesta Prefeitura Municipal com CNPJ/CPF <strong>$empresa_cnpjcpf;</strong>, na qual está cadastrada e registrada como emissora de NFe - ISS (Nota Fiscal Eletrônica de Serviços), para comunicar que foi enviado uma notificação de reclamação quanto a <strong>$especificacao</strong> por parte do seguinte tomador:<br /><br />
	- Tomador CNPJ/CPF: <strong>$tomador_cnpj</strong><br /><br />
	- Tomador e-mail: <strong>$tomador_email</strong></td>
  </tr>
</table>	
	";

	$assunto = "$PREFEITURA entra em contato.";

	

	$headers  = "MIME-Version: 1.0\r\n";

	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

	$headers .= "From: $EMAIL \r\n";

	$headers .= "Cc: \r\n";

	$headers .= "Bcc: \r\n";

	
	if(!mail($prest_email,$assunto,$msg,$headers)){ $erro = 1;}
	
	if(!mail($tomador_email,$assunto,$msg,$headers)){ $erro = 1;}
	
	if($erro){
		Mensagem("Ocorreu um erro no envio dos e-mail!");
	}else{
		Mensagem("Contato realizado com sucesso!");
		echo "<script>window.close();</script>";
	}
	

		/*echo "<script language=JavaScript> alert('Contato realizado com sucesso !'); parent.location='../reclamacoes.php';</script>";*/







	

	}

?> 