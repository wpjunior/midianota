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
if($_POST['btAtualizar'] == "Atualizar"){
	include("empresas_editar.php");
}


 $sql = mysql_query("SELECT codigo, email, senha FROM cadastro WHERE nome = '$NOME'");
 list($codigo,$email,$senha) = mysql_fetch_array($sql); 
?>

			
<form method="post" name="frmCadUsuarios" enctype="multipart/form-data" onsubmit="return ((ValidaFormulario('txtEmail','Preencha os campos obrigatórios'))&&(validaExtencao('arquivo')));">
<input name="hdCod" type="hidden" value="<?php echo $codigo;?>" />
    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
    	<tr>
        	<td align="left">Nome</td>
            <td align="left"><b><?php echo $NOME;?></b></td>
        </tr>
        <tr>
            <td align="left">Email<font color="#FF0000">*</font></td>
            <td align="left">
                <input type="text" size="50" maxlength="50" name="txtEmail" id="txtEmail" class="texto" value="<?php print $email;?>">
            </td>
        </tr>
        <tr>
            <td align="left">Senha</td>
            <td align="left">
                <input type="password" size="18" maxlength="18" name="txtSenha" id="txtSenha" value="" 
                class="texto"> <font size="-2" color="#FF0000">Preencha somente se for alterar a senha</font>
            </td>
        </tr>
        <tr>
            <td align="left">Confirmar senha</td>
            <td align="left">
                <input type="password" size="18" maxlength="18" name="txtConfirmacao" id="txtConfirmacao" value="" 
                class="texto">
            </td>
        </tr>
        <tr>
            <td align="left"><br />
                Logomarca atual</td>
            <td align="left"><br />
                <?php
					$sql_logo = mysql_query("SELECT logo FROM cadastro WHERE nome = '$NOME'");
					list($logo) = mysql_fetch_array($sql_logo);
                   if ($logo !="")
                     {
				?>
                       <img src="../img/logos/<?php echo $logo; ?>" style="border:#FFFFFF 1px solid">
                <?php }
                   else		
                     {	   
                       print("<font color=red>Não possui logomarca</font>");
                     }
                  ?>
                  <input name="bt" type="button" value="Alterar imagem" class="botao" onclick="document.getElementById('trempresa').style.visibility='visible'" />
            </td>
        </tr>
        <tr id="trempresa" style="visibility:hidden">
            <td align="left">Logomarca</td>
            <td align="left">
                <input type="file" size="50" maxlength="50" name="arquivo" id="arquivo" class="botao">
                <br />
                <font size="-2" color="#FF0000">A imagem do logo deverá estar no formato JPG.</font></td>
        </tr>
        <tr>
            <td>
                <input type="submit" value="Atualizar" name="btAtualizar" class="botao" onclick="return ValidaSenha('txtSenha','txtConfirmacao')">
            </td>
            <td> </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
function ValidaSenha(txtSenha, txtConfirmacao) {
	if (document.getElementById('txtSenha').value == document.getElementById('txtConfirmacao').value) {
		return true;
	} else {
		alert('Verifique a senha');
		return false;
	}
}
</script>