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

//recebe o include que mantem a pagina
$include = $_GET['include'];
//conecta ao banco
include("../conect.php");
//recebe o codigo que veio por get
$codigo = $_GET['hdcod'];

//sql buscando informacoes sobre o usuario
$sql_info = mysql_query("SELECT nome, login, senha, nivel FROM usuarios WHERE codigo = '$codigo'");
list($nome,$login,$senha,$nivel) = mysql_fetch_array($sql_info);
?>
<input type="hidden" name="hdCodUser" value="<?php echo $codigo;?>">
<table width="100%" style="text-indent:25px;" border="0">
	<tr bgcolor="#FFFFFF">
		<td width="136">Nome: </td>			
        <td width="1013" colspan="3"><input name="txtNomeEdit" type="text" class="texto" value="<?php echo $nome;?>"></td>
    </tr>	
	<tr bgcolor="#FFFFFF">
		<td>Login: </td>			
		<td colspan="3"><input name="txtLoginEdit" type="text" class="texto" value="<?php echo $login;?>"></td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td>Senha: </td>
		<td colspan="3"><input name="txtSenhaEdit" type="password" class="texto" value=""></td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td>Nivel:</td>
		<td colspan="3">
			<select name="cmbNivelEdit" class="combo">
				<option value="A" <?php if($nivel == "A"){ echo "selected=selected";}?>>Alto</option>
				<option value="M" <?php if($nivel == "M"){ echo "selected=selected";}?>>Medio</option>
				<option value="B" <?php if($nivel == "B"){ echo "selected=selected";}?>>Baixo</option>
			</select>	
		</td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td colspan="4" align="center"><input name="btEditar" type="submit" value="Editar" class="botao"></td>
	</tr>
</table>