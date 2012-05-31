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
<form name="frmPrestadoresBox" method="post" id="frmPrestadoresBox">
	<input type="hidden" name="txtMenu" id="txtMenu" />
	<input type="hidden" name="txtCNPJ" id="txtCNPJ" />

<table border="0" cellspacing="5" cellpadding="0" align="left">
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
        <td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Acessar Sistema</font><br />
          <br />          
                    Emitente de NF-e,   acesse todas as funcionalidades do sistema.<br />
          <br />
          <div align="center"></div>          </td>
      </tr>
      <tr>
        <td height="1"></td>
      </tr>
      <tr>
        <td height="20" align="left" bgcolor="#859CAD">&nbsp;<img src="../img/box/web.png" width="14" height="14" /> <a href="../emissor/index.php" target="_blank">Servi&ccedil;o on-line</a></td>
      </tr>
    </table>    </td>
    <td width="190" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="3" bgcolor="#CCCCCC"></td>
      </tr>
      <tr>
        <td height="10" bgcolor="#999999"></td>
      </tr>
      <tr>
        <td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Cadastro</font><br />
            <br />
            Se voc&ecirc; n&atilde;o possui acesso ao sistema, &eacute; necess&aacute;rio realizar o seu cadastramento.<br />
          <br />
          <div align="center"></div></td>
      </tr>
      <tr>
        <td height="1"></td>
      </tr>
      <tr>
        <td height="20" align="left" bgcolor="#859CAD">&nbsp;<img src="../img/box/web.png" alt="" width="14" height="14" /><a onclick="document.getElementById('txtMenu').value='cadastro';frmPrestadoresBox.submit();" href="#" class="box">Servi&ccedil;o on-line</a></td>
      </tr>
    </table>
	
	<!-- Quadro do meio acima --></td>
    <td width="190" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="3" bgcolor="#CCCCCC"></td>
      </tr>
      <tr>
        <td height="10" bgcolor="#999999"></td>
      </tr>
      <tr>
        <td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Consulta</font><br />
            <br />
          Consulte se o seu cadastro j&aacute; foi liberado pela Prefeitura Municipal.<br />
          <br />
          <div align="center"></div></td>
      </tr>
      <tr>
        <td height="1"></td>
      </tr>
      <tr>
        <td height="20" align="left" bgcolor="#859CAD">&nbsp;<img src="../img/box/web.png" alt="" width="14" height="14" /><a onclick="document.getElementById('txtMenu').value='consulta';frmPrestadoresBox.submit();" href="#" class="box">Servi&ccedil;o on-line</a></td>
      </tr>
    </table>
	
	<!-- quadro direita acima --></td>
  </tr>   
    </table>
</form>