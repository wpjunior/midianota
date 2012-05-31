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
<form action="notas.php" id="FormNotas" method="post" >
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td align="center">
	<input name="btInserir" id="btInserir" type="submit" value="Emitir Nota" class="botao" />
	<input name="btPesquisar" type="submit" value="Pesquisar Nota" class="botao" /></td>
  </tr>
</table>
</form>

<?php 
$btInserir   = $_POST['btInserir'];
$btPesquisar = $_REQUEST['btPesquisar'];

if($_POST['btCancel']){
	include("inc/notas_cancelar.php");
	$btPesquisar='T';
}


if($btInserir !="")	{
	include("inc/notas_inserir.php");
}
if($btPesquisar !="") {
	include("inc/notas_pesquisar.php");
}
	
?>