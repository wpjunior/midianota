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