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
<!-- box de conteúdos -->
<form name="frmTomadoresBox" method="post" action="tomadores.php" id="frmTomadoresBox">
	<input type="hidden" name="txtMenu" id="txtMenu" />
	<input type="hidden" name="txtCNPJ" id="txtCNPJ" />

<table border="0" cellspacing="5" cellpadding="0">
  <tr>
    <td width="190" align="center" valign="top">
    <!-- quadro da esquerda acima -->
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="3" bgcolor="#CCCCCC"></td>
      </tr>
      <tr>
        <td height="10" bgcolor="#999999"></td>
      </tr>
      <tr>
        <td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Consulta RPS</font><br />
          <br />
          Permite que o tomador de servi&ccedil;os que recebeu um  Recibo Provis&oacute;rio de Servi&ccedil;os &ndash; RPS consulte a sua convers&atilde;o em NFe.<br />
          <br />
          <div align="center"></div>          </td>
      </tr>
      <tr>
        <td height="1"></td>
      </tr>
      <tr>
        <td height="20" align="left" bgcolor="#859CAD">&nbsp;<img src="../img/box/web.png" width="14" height="14" /> <a onclick="document.getElementById('txtMenu').value='rps';frmTomadoresBox.submit();" href="#" class="box">Servi&ccedil;o on-line</a><a href="../contador/index.php" target="_blank"></a></td>
      </tr>
    </table>    </td>
    <td width="190" align="center" valign="top">
	
	<!-- Quadro do meio acima -->

    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="3" bgcolor="#CCCCCC"></td>
      </tr>
      <tr>
        <td height="10" bgcolor="#999999"></td>
      </tr>
      <tr>
        <td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Consulta Cr&eacute;ditos</font><br />
          <br />
          Veja o v&iacute;deo da campanha da NFeletr&ocirc;nica de ISS.<br />
          <br /></td>
      </tr>
      <tr>
        <td height="1"></td>
      </tr>
      <tr>
        <td height="20" align="left" bgcolor="#859CAD"><img src="../img/box/web.png" alt="" width="14" height="14" /><a onclick="document.getElementById('txtMenu').value='creditos';frmTomadoresBox.submit();" href="#" class="box">Servi&ccedil;o on-line</a></td>
      </tr>
    </table>    </td>
    <td width="190" align="center" valign="top">
	
	<!-- quadro direita acima -->
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="3" bgcolor="#CCCCCC"></td>
      </tr>
      <tr>
        <td height="10" bgcolor="#999999"></td>
      </tr>
      <tr>
        <td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo"> Autenticidade de NFe</font>
          <br />
          <br />
          Acesse e compare os n&uacute;meros de aprova&ccedil;&atilde;o da NFe de ISS.<br />
          <br /></td>
      </tr>
      <tr>
        <td height="1"></td>
      </tr>
      <tr>
        <td height="20" align="left" bgcolor="#859CAD"><img src="../img/box/web.png" alt="" width="14" height="14" /><a onclick="document.getElementById('txtMenu').value='autenticidade';frmTomadoresBox.submit();" href="#" class="box">Servi&ccedil;o on-line</a></td>
      </tr>
    </table>	
    </td>
  </tr>
  <tr>
  	<td>
    
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="3" bgcolor="#CCCCCC"></td>
          </tr>
          <tr>
            <td height="10" bgcolor="#999999"></td>
          </tr>
          <tr>
            <td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Tomadores: Gerar guia </font><br />
                <br />
              	Gerar guia de declara&ccedil;&otilde;es com ISS retido.</td>
          </tr>
          <tr>
            <td height="1"></td>
          </tr>
          <tr>
            <td height="20" align="left" bgcolor="#859CAD"><a onclick="document.getElementById('txtMenu').value='issretido';frmTomadoresBox.submit();" href="#" class="box">&nbsp;<img src="../img/box/web.png" alt="ISS Retido" width="14" height="14" /> Servi&ccedil;o on-line</a></td>
          </tr>
        </table>

    
    </td>   
  </tr>
    </table>
    </form>