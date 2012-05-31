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
	$emp = $_POST['cmbEmpresa'];
	if(($numero) || ($codverificacao) || ($tomador_cnpjcpf) || ($emp)){
		$cancelamento = "C";
	}else{
		$cancelamento = "";
	}
	
	$login = $_SESSION['login'];
	if($btSelecionarEmpresa==""){
	$campo = tipoPessoa($login);
	$sql=mysql_query("SELECT codigo FROM cadastro WHERE $campo='$login'");
	list($codcontador)=mysql_fetch_array($sql);
	$sql=mysql_query("SELECT codigo, razaosocial FROM cadastro WHERE codcontador='$codcontador'");
	if(mysql_num_rows($sql)>0){
?>	
<form method="post" action="notas.php" id="frmCancelarNota" name="frmCancelarNota" onsubmit="return CancelarNota()">
<fieldset style="width:500px"><legend>Pesquisar Nota</legend>
	<table>
		<tr>
			<td>Selecione uma empresa</td>
			<td>&nbsp;
				<select name="cmbEmp">
					<?php
						while(list($codigo,$razaosocial)=mysql_fetch_array($sql))
							{
								
								echo "<option value=\"$codigo\"";if($emp == $codigo){echo "selected=\"selected\"";}echo">$razaosocial</option>";
							}
					?>
				</select>
			</td>
		</tr>
	</table>
    <table width="100%" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td align="left" width="30%">Número da Nota</td>
        <td align="left" width="70%"><input name="txtNumeroNota" type="text" size="10" class="botao" value="<?php echo $numero;?>" /></td>
      </tr>
      <tr>
        <td align="left">Código de Verificação</td>
        <td align="left"><input name="txtCodigoVerificacao" type="text" size="10" class="botao" value="<?php echo $codverificacao;?>" style="text-transform:uppercase" /></td>
      </tr>
      <tr>
        <td align="left">Tomador - CNPJ/CP</td>
        <td align="left"><input name="txtTomadorCPF" type="text" size="20" class="botao" onkeydown="stopMsk( event );" onkeypress="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );" value="<?php echo $tomador_cnpjcpf;?>" /></td>
      </tr>
      <tr>
    <td align="left" colspan="2"><input name="btPesquisar" id="btPesquisar" type="button" value="Pesquisar" class="botao" 
	onclick="acessoAjax('inc/notas_pesquisar_empresa.ajax.php','frmCancelarNota','Container');" ></td>
  </tr>
    </table>
</fieldset>
<div id="Container" style="width:100%">
	<?php
	if($cancelamento == "C"){
	?>
	<script>			
		document.getElementById('btPesquisar').click();
	</script>
	<?php
	}
	?>
</div>
</form>
<?php
}
	else{echo "Nenhuma empresa cadastrada";}
}?>
