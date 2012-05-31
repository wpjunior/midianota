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
 $login=$_SESSION['login'];

 if($btAtualizar != "") 
 {
   include("usuarios_editar.php"); 
 }






?>
<!-- Formulário de inserção de usuarios  --->

<table width="500" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<fieldset style="width:500px">
			<legend>Atualização da senha do usuário <?php print ("<b><font color=RED>$NOME&nbsp;</font></b>");?></legend>
			<form action="usuarios.php" method="post" name="frmCadUsuarios" onsubmit="return ValidaSenha('txtSenha','txtSenhaConfirm')" >
				<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
					<tr>
						<td align="left" width="120">Senha</td>
						<td align="left">
							<input type="password" size="10" maxlength="10" name="txtSenha" id="txtSenha" value="<?php echo $_SESSION["empresa"]; ?>" class="texto">
							&nbsp;No máximo 10 caracteres
							</td>
					</tr>
					<tr>
						<td align="left">Comfirme a senha</td>
						<td align="left">
							<input type="password" size="10" maxlength="10" name="txtSenhaConfirm" id="txtSenhaConfirm" value="<?php echo $_SESSION["empresa"]; ?>" class="texto">
							</td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="submit" value="Atualizar" name="btAtualizar" class="botao">
						</td>
					</tr>
				</table>
			</form>
			</fieldset>
		</td>
	</tr>
</table>
<!-- Formulário de inserção de usuarios Fim--->
</td>
</tr>
<tr>
	<td>
		<!-- Formulário de Edição e Ativação de serviços --->
		<!-- Formulário de Edição e Ativação de serviços Fim --->
	</td>
</tr>
</table>
