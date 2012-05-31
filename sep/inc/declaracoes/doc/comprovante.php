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
	include("../conect.php");
	include("../../funcoes/util.php");
	$codigo = $_POST["hdCodOpr"];
	
	// busca os dados do municipio
	$sql = mysql_query("SELECT cidade, secretaria, logo FROM configuracoes");
	list($CIDADE,$SECRETARIA,$LOGO)=mysql_fetch_array($sql);
	// busca os dados da inst. financeira
	$sql_opr = mysql_query("SELECT cnpj, razaosocial, endereco FROM operadoras_creditos WHERE codigo = '$codigo'");
	list($cnpj,$razaosocial,$endereco)=mysql_fetch_array($sql_opr);
?>
<div id="imprimir">
	<input type="button" onClick="document.getElementById('imprimir').style.display='none'; print(); document.getElementById('imprimir').style.display='block';" value="Imprimir" />
</div>
<table width="800" border="0" cellspacing="0" cellpadding="5" align="center">
  <tr>
    <td height="100" colspan="4">
	<table border="0" cellspacing="0" cellpadding="5" style="border: 0px;">
      <tr>
        <td width="150" style="border:0px;" align="left"><img src="../../img/logos/<?php echo $LOGO; ?>"></td>
        <td width="520" style="border:0px;" align="left" valign="middle">
		<font class="prefeitura">Prefeitura Municipal de <?php echo $CIDADE; ?></font><br>
		<font class="secretaria"><?php echo $SECRETARIA; ?><br>
		Comprovante de Cadastro de Institui&ccedil;&atilde;o Financeira </font></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" width="50%" bgcolor="#CCCCCC" colspan="2"><strong>Número do Documento </strong></td>
    <td align="center" bgcolor="#CCCCCC" colspan="2"><strong>Data de Emiss&atilde;o </strong></td>
  </tr>
  <tr>
    <td align="center" colspan="2" width="50%"><font class="prefeitura"><?php echo $codigo ?></font></td>
    <td align="center" colspan="2"><font class="prefeitura"><?php echo DataPtExt(); ?></font></td>
  </tr>
  <tr>
    <td height="30" colspan="4" align="center" bgcolor="#CCCCCC"><strong>IDENTIFICA&Ccedil;&Atilde;O DO SUJEITO PASSIVO </strong></td>
  </tr>
  <tr>
    <td height="50" colspan="3" valign="top">Nome<br>
    <font class="prefeitura"><?php echo $razaosocial; ?></font></td>
    <td width="25%" valign="top">CNPJ<br>
    <font class="prefeitura"><?php echo $cnpj; ?></font></td>
  </tr>
  <tr>
    <td height="75" colspan="4" valign="top">Endere&ccedil;o<br>
    <font class="prefeitura"><?php echo $endereco; ?></font></td>
  </tr>
  <tr>
    <td height="30" colspan="4" align="center" bgcolor="#CCCCCC"><strong>CERTIFICA&Ccedil;&Atilde;O</strong></td>
  </tr>
  <tr>
    <td height="200" colspan="4" align="center" valign="middle"><span class="style1">A Prefeitura Municipal de <font class="prefeitura"><?php echo $CIDADE; ?></font> certifica que a Institui&ccedil;&atilde;o Financeira citada acima foi devidamente cadastrada no sistema de ISSDigital do município<font class="prefeitura"><?php e ?></font>.</span>   </td>
  </tr>
  <tr>
    <td height="30" colspan="4" align="center" bgcolor="#CCCCCC"><strong>OBSERVA&Ccedil;&Otilde;ES</strong></td>
  </tr>
  <tr>
    <td colspan="4"><p>- A senha de acesso da Instituição Financeira ao sistema de ISSDigital do município é de uso exclusivo e intransferível da Instituição Financeira, bem como a responsabilidade sobre o uso indevido da mesma.
    </p></td>
  </tr>
  <tr>
    <td height="50" colspan="4"><font class="prefeitura"><?php ?></font>.  </td>
  </tr>
</table>
