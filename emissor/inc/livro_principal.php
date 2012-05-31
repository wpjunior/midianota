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
<script type="text/javascript" language="javascript" src="../scripts/jquery.js"></script>
<script src="../scripts/padrao.js" language="javascript" type="text/javascript"></script>
<script src="../scripts/jquery-1.1.3.1.pack.js" type="text/javascript"></script>
<script src="../scripts/jquery.history_remote.pack.js" type="text/javascript"></script>
<script src="../scripts/jquery.tabs.pack.js" type="text/javascript"></script>
<script src="../scripts/java_site.js" language="javascript" type="text/javascript"></script>
<script src="../scripts/java_emissor_contador.js" language="javascript" type="text/javascript"></script>
<link rel="stylesheet" href="../css/jquery.tabs.css" type="text/css" media="print, projection, screen">
<link href="../css/padrao_emissor.css" rel="stylesheet" type="text/css" />



<form action="livro.php" id="FormNotas" method="post" >
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td align="center">
	<input name="btInserir" id="btInserir" type="submit" value="Gerar Livro" class="botao" />
	<input name="btPesquisar" type="submit" value="Consultar Livro" class="botao" /></td>
  </tr>
</table>
</form>

<?php 
$btInserir   = $_POST['btInserir'];
$btPesquisar = $_REQUEST['btPesquisar'];

if($_POST['btGerar']){
	include("../livro/inserir.php");
}

if($btInserir !="")	{
	include("../livro/iss_gerar.php");
}
if($btPesquisar !="") {
	include("../livro/iss_consultar.php");
}
	
?>