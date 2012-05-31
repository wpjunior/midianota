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