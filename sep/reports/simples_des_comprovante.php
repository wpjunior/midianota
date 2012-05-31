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
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Comprovante de DES</title>
<link href="../css/imprimir_descomprovantes.css" rel="stylesheet" type="text/css"></head>
<?php 
    session_start();    
	include("../inc/conect.php");
	include("../funcoes/util.php");
	if($_GET['COD']){
		$CODDES = $_GET['COD'];
		$CODDES = base64_decode($CODDES);
		
		$cnpjcpf_empresa =$_SESSION['SESSAO_cnpj_emissor'];
		$sql=mysql_query("
			SELECT
			  simples_des.codigo, 
			  cadastro.razaosocial, 
			  cadastro.cnpj,
			  cadastro.cpf,
			  cadastro.inscrmunicipal,
			  cadastro.logradouro, 
			  cadastro.numero, 
			  cadastro.complemento, 
			  DATE_FORMAT(simples_des.competencia,'%m/%Y'), 
			  simples_des.data_gerado,
			  simples_des.total, 
			  simples_des.codverificacao
			FROM
			  simples_des INNER JOIN
			  cadastro ON cadastro.codigo = simples_des.codemissor
			WHERE
			  simples_des.codigo = '$CODDES'
		");	
		list($codigo, $razaosocial, $cnpj, $cpf, $inscrmunicipal, $logradouro, $numero, $complemento, $competencia, $data_gerado, $total, $codverificacao)=mysql_fetch_array($sql);
		$cnpjcpf = $cnpj . $cpf;
		$endereco = "$logradouro, $numero";
		if($complemento)
			$endereco .= ", $complemento";
	} 
	
?>
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
		Comprovante de Declara&ccedil;&atilde;o Eletr&ocirc;nica de Servi&ccedil;os de ISS</font></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="25%" height="30" align="center" bgcolor="#CCCCCC"><strong>Documento N&ordm;.</strong></td>
    <td width="25%" align="center" bgcolor="#CCCCCC"><strong>C&oacute;digo de Verifica&ccedil;&atilde;o</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>Data de Emiss&atilde;o </strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>Per&iacute;odo</strong></td>
  </tr>
  <tr>
    <td height="30" align="center"><font class="prefeitura"><?php echo $codigo; ?></font></td>
    <td align="center"><font class="prefeitura"><?php echo $codverificacao; ?></font></td>
    <td align="center"><font class="prefeitura"><?php echo DataPt($data_gerado); ?></font></td>
    <td align="center"><font class="prefeitura"><?php echo $competencia; ?></font></td>
  </tr>
  <tr>
    <td height="30" colspan="4" align="center" bgcolor="#CCCCCC"><strong>IDENTIFICA&Ccedil;&Atilde;O DO SUJEITO PASSIVO </strong></td>
  </tr>
  <tr>
    <td height="50" colspan="3" valign="top">Nome<br>
    <font class="prefeitura"><?php echo $razaosocial; ?></font></td>
    <td width="25%" valign="top">CNPJ/CPF<br>
    <font class="prefeitura"><?php echo $cnpjcpf; ?></font></td>
  </tr>
  <tr>
    <td height="75" colspan="4" valign="top">Endere&ccedil;o<br>
    <font class="prefeitura"><?php echo $endereco; ?></font></td>
  </tr>
  <tr>
    <td height="30" colspan="4" align="center" bgcolor="#CCCCCC"><strong>CERTIFICA&Ccedil;&Atilde;O</strong></td>
  </tr>
  <tr>
    <td height="200" colspan="4" align="center" valign="middle"><span class="style1">A Prefeitura Municipal de <font class="prefeitura"><?php echo $CONF_CIDADE; ?></font> certifica que a empresa citada acima concluiu o processo de Declara&ccedil;&atilde;o Eletr&ocirc;nica de Servi&ccedil;os de ISS, referente ao per&iacute;odo <font class="prefeitura"><?php echo DataPt($competencia); ?></font>.</span>   </td>
  </tr>
  <tr>
    <td height="30" colspan="4" align="center" bgcolor="#CCCCCC"><strong>OBSERVA&Ccedil;&Otilde;ES</strong></td>
  </tr>
  <tr>
    <td colspan="4"><p>- Fica assegurado ao Munic&iacute;pio a cobran&ccedil;a de qualquer d&eacute;bito que possa ser verificado posteriormente; </p>
    <p>- O presente documento somente tem validade:<br>
	&nbsp;&nbsp;&nbsp;&nbsp;a. Quando nao apresentar rasuras;<br>
    </p></td>
  </tr>
  <tr>
    <td height="50" colspan="4">A aceita&ccedil;&atilde;o deste documento esta condicionada &agrave; verifica&ccedil;&atilde;o de sua validade, de forma exclusiva pela  Prefeitura Municipal de <font class="prefeitura"><?php echo $CONF_CIDADE; ?></font>.  </td>
  </tr>
</table>
</body>
</html>
