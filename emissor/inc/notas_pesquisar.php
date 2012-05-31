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
 <br>
 <?php
	$numero    = $_POST['txtNumeroNota'];
	$codverifi = $_POST['txtCodigoVerificacao'];
	$tomador   = $_POST['txtTomadorCPF'];
	if(($numero) || ($codverifi) || ($tomador)){
		$cancelamento = "C";
	}else{
		$cancelamento = "";
	}
 ?>
<form name="frmPesquisar" id="frmPesquisar" method="post" onsubmit="return false">
	<table border="0" align="center" cellpadding="0" cellspacing="1">
		<tr>
			<td width="10" height="10" bgcolor="#FFFFFF"></td>
			<td width="120" align="center" bgcolor="#FFFFFF" rowspan="3">Pesquisar Notas</td>
			<td width="450" bgcolor="#FFFFFF"></td>
		</tr>
		<tr>
			<td height="1" bgcolor="#CCCCCC"></td>
			<td bgcolor="#CCCCCC"></td>
		</tr>
		<tr>
			<td height="10" bgcolor="#FFFFFF"></td>
			<td bgcolor="#FFFFFF"></td>
		</tr>
		<tr>
			<td colspan="3" height="1" bgcolor="#CCCCCC"></td>
		</tr>
		<tr>
			<td height="60" colspan="3" bgcolor="#CCCCCC">
				<table width="100%" border="0" cellspacing="2" cellpadding="2">
					<tr>
						<td align="left" width="30%">Número da Nota</td>
						<td align="left" width="70%">
							<input name="txtNumeroNota" type="text" size="10" class="botao" value="<?php echo $numero;?>" />
						</td>
					</tr>
					<tr>
						<td align="left">Código de Verificação</td>
						<td align="left">
							<input name="txtCodigoVerificacao" type="text" size="10" class="botao" value="<?php echo $codverifi;?>"/>
						</td>
					</tr>
					<tr>
						<td align="left">Tomador - CNPJ/CPF</td>
						<td align="left">
							<input name="txtTomadorCPF" type="text" size="20" class="botao" maxlength="18" 
							onkeyup="CNPJCPFMsk( this );return NumbersOnly( event );" onkeydown="stopMsk( event );" value="<?php echo $tomador;?>" />
						</td>
					</tr>
					<tr>
						<td align="left" colspan="2">
							<input name="btPesquisar" id="btPesquisar" type="submit" value="Pesquisar" class="botao" 
							onclick="acessoAjax('inc/notas_pesquisar.ajax.php','frmPesquisar','Container');" >
							<input type="reset" value="Limpar" name="btLimpar" class="botao" />
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
		</tr>
	</table>
	<div id="Container">
		<?php echo $cancelamento; if($cancelamento == "C"){?><script>document.getElementById('btPesquisar').click();<?php }?></script>
	</div>
</form>
