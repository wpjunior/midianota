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
//rawurlencode($CONF_BRASAO);
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" height="130">
  <tr>
    <td width="15%" align="left" valign="middle">
	<a href="index.php" class="menuTopo">
		<?php if($CONF_BRASAO){ echo "<img src=../img/brasoes/".rawurlencode($CONF_BRASAO)." height='100' width='100'>";} ?>
	</a>
    </td>
    <td width="85%" align="left" valign="middle">
	<font class="prefeituraTitulo" color="#FFFFFF" size="-1"><b><?php echo "Prefeitura Municipal de ".$CONF_CIDADE; ?></b></font><br />
	<font class="secretariaTitulo" color="#FFFFFF" size="+1"><b><?php echo $CONF_SECRETARIA; ?></b></font></td>
  </tr>
</table>