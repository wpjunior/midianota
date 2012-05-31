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
<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
  <tr>
    <td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
    <td width="700" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;Relat&oacute;rios - Servi&ccedil;os</td>  
    <td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
  </tr>
  <tr>
    <td width="18" background="img/form/lateralesq.jpg"></td>
    <td align="center">

<fieldset>
<legend><strong>Pesquisa de Servi&ccedil;os</strong></legend>
<p>
  <label></label>
  <span style="vertical-align:middle; text-align:left"></span>
  <center>
  <span style="vertical-align:middle; text-align:left"></span>
  </center>
</p>
<table width="271" height="36" border="0" cellspacing="0">
  <tr>
    <td width="164" >
    <form id="frmServ" method="post" target="_blank" action="inc/relatorios/area.php">
    	<input name="btPesquisar" type="submit" id="button1" class="botao" value="Lista por Categoria e Serviço"   />
	</form>
    </td>
     <td width="179">
     <form id="frmServ" method="post" target="_blank" action="inc/relatorios/categ.php">
		 <input type="submit" name="btLimpar" id="button2" value="Lista Estatística" class="botao" />
     </form>
     </td> 
  </tr>
</table>
<table align="left" width="4">
<tbody>
</tbody>
</table>

</fieldset>
<div id="divRelatPrestadores"></div>
	</td>
		<td width="19" background="img/form/lateraldir.jpg"></td>
  </tr>
  <tr>
    <td align="left" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantoesq.jpg" /></td>
    <td background="img/form/rodape_fundo.jpg"></td>
    <td align="right" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantodir.jpg" /></td>
  </tr>
</table>

