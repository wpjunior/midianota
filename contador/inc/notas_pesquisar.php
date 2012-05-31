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
	$numero = $_POST['txtNumeroNota'];
	$codverificacao = $_POST['txtCodigoVerificacao'];
	$tomador_cnpjcpf = $_POST['txtTomadorCPF'];
	if(($numero) || ($codverificacao) || ($tomador_cnpjcpf)){
		$cancelamento = "C";
	}else{
		$cancelamento = "";
	}
	
?>
<form name="frmPesquisar" id="frmPesquisar" method="post">
<fieldset style="width:500px"><legend>Pesquisar Nota</legend>
<br>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td align="left" width="30%">Número da Nota</td>
    <td align="left" width="70%"><input name="txtNumeroNota" type="text" size="10" class="botao" value="<?php echo $numero;?>" /></td>
  </tr>
  <tr>
    <td align="left">Código de Verificação</td>
    <td align="left"><input name="txtCodigoVerificacao" type="text" size="10" class="botao" value="<?php echo $codverificacao;?>" /></td>
  </tr>
   <tr>
    <td align="left">Tomador - CNPJ/CPF</td>
    <td align="left"><input name="txtTomadorCPF" type="text" size="20" class="botao" maxlength="18" onkeyup="CNPJCPFMsk( this );return NumbersOnly( event );" onkeydown="stopMsk( event );" value="<?php echo $tomador_cnpjcpf;?>" /></td>
  </tr>
  <?php
  $pagina=$_GET['hdPagina'];
  ?>
  <tr>
    <td align="left" colspan="2"><input name="btPesquisar" id="btPesquisar" type="button" value="Pesquisar" class="botao" onclick="acessoAjax('inc/notas_pesquisar.ajax.php<?php if($_GET['btCancelamento']=='T'){$_GET['btCancelamento']=='F'; echo"?btPropria=T&btCancelamento=T&y={$_GET['y']}&hdPagina={$hdPagina}&hdPrimeiro=1";}?>','frmPesquisar','Container');" >
        </td>
	</tr>
	<tr>
    	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
	</tr>
</table>   
</fieldset>
<div id="Container">
	<?php
	if($cancelamento == "C"){
	?>
	<script>			
		document.getElementById('btPesquisar').onclick();
	</script>
	<?php
	}
	?>
</div>
</form>

