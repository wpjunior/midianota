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
	//recebimento de variaveis por post
	$nome  = $_POST["txtNome"];
	$login = $_POST["txtLogin"];
	$nivel = $_POST["cmbNivel"];
	$senha = md5($_POST["txtSenha"]);
	if($_POST["btCadastrar"] == "Inserir"){
		mysql_query("INSERT INTO usuarios SET nome = '$nome', login = '$login', senha = '$senha', tipo = 'prefeitura', nivel = '$nivel'");
		Mensagem("Usuario inserido");
	}//fim if
	if($_POST["btEditar"] == "Editar"){
		//recebe os valores por post dos campos do formulario
		$nome = $_POST["txtNomeEdit"];
		$login = $_POST["txtLoginEdit"];
		$senha = md5($_POST["txtSenhaEdit"]);		
		$nivel = $_POST["cmbNivelEdit"];
		$codedit = $_POST["hdCodUser"];
		if($_POST["txtSenhaEdit"]){		
			$str="senha='$senha',";
		}
		//atualiza os campos do banco
		
		mysql_query("UPDATE usuarios SET nome = '$nome', login = '$login', $str nivel = '$nivel' WHERE codigo = '$codedit'");
		add_logs('Atualizou Configurações de um Usuário');
		Mensagem("Usuario atualizado");
	}//fim if
	if($_POST["btDeletar"] == "Excluir"){
		$coddel = $_POST["hdCodDel"];
		mysql_query("DELETE FROM usuarios WHERE codigo = '$coddel'");
		add_logs('Excluiu Configurações de um Usuário');
		Mensagem("Usuario excluido");
	}//fim if
?>
<form method="post" id="frmUsuario" name="frmUsuario">
	<input type="hidden" name="include" id="include" value="<?php echo $_POST["include"];?>" />
	<input type="hidden" name="btUsuarios" value="<?php echo $_POST["btUsuarios"];?>">
	<fieldset><legend>Cadastro de Usuários</legend>
		<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
			<tr>
				<td align="left" width="20%">Nome<font color="#FF0000">*</font></td>
				<td align="left" width="80%"><input type="text" size="50" maxlength="100" name="txtNome" id="txtNome" class="texto"></td>
			</tr>
			<tr>
				<td align="left">Login<font color="#FF0000">*</font></td>
				<td align="left"><input type="text" size="30" maxlength="100" name="txtLogin" id="txtLogin" class="texto"></td>
			</tr>
			<tr>
				<td align="left">Senha<font color="#FF0000">*</font></td>
				<td align="left"><input type="password" size="10" maxlength="10" name="txtSenha" id="txtSenha" class="texto">&nbsp;No máximo 10 caracteres</td>
			</tr>
			<tr>
				<td align="left">Nível de permissão</td>
				<td align="left">
					<select name="cmbNivel" id="cmbNivel">
						<option value=""></option>
						<option value="A">Alto</option>
						<option value="M">Médio</option>
						<option value="B">Baixo</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" value="Inserir" name="btCadastrar" class="botao" onclick="return ValidaFormulario('txtNome|txtLogin|txtSenha|cmbNivel')"></td>
				<td align="right"><font color="#FF0000">*</font>Campos Obrigat&oacute;rios</td>
			</tr>   
		</table>   
	</fieldset>
<?php
	$sql = mysql_query("SELECT codigo, nome, login, nivel, ultlogin	FROM usuarios WHERE tipo = 'prefeitura'	ORDER BY nome");
	$result = mysql_num_rows($sql);
	if($result>0){
?>
	<!-- cabeçalho da pesquisa --> 
	<fieldset><legend>Usuários Cadastrados: <?php echo $result; ?></legend>
		<table width="100%">  
			<tr bgcolor="#999999">
				<td width="136" align="center">Nome</td>
				<td width="138" align="center">Login</td>
				<td width="49" align="center">Nível</td>
				<td width="126" align="center">Últ login</td>
				<td width="49" align="center"></td>
				<td align="center"></td>
			</tr>
		</table>
	<div  <?php if($result >7){ echo "style=\"overflow:auto; height:250px;\""; }?>>
		<table width="100%" border="0" cellpadding="0" cellspacing="1">
			<?php 
				$x = 0;
				while(list($codigo,$nome,$login,$nivel,$ultlogin)=mysql_fetch_array($sql)) { 
					switch($nivel){
						case "A": $nivel = "Alto";  break;
						case "M": $nivel = "Medio"; break;
				        case "B": $nivel = "Baixo"; break;
					}
					$sql_ultlogin= mysql_query("SELECT data FROM logs WHERE codusuario ='$codigo' ORDER BY codigo DESC LIMIT 1");
					list($data)=mysql_fetch_array($sql_ultlogin);
						$datahora = explode(" ",$data);
						$data = $datahora[0];
						$hora = $datahora[1];
									
					?>
				<tr bgcolor="#FFFFFF">
					<td width="153" align="center"><?php echo $nome;?></td>
					<td width="152" align="center"><?php echo $login;?></td>
					<td width="54" align="center"><?php echo $nivel;?></td>
					<td width="139" align="center"><?php echo DataPt($data)." ".$hora;?></td>
					<td align="center">
					
						<input name="btEditar" type="button" class="botao" value="Editar" onClick="VisualizarNovaLinha('<?php echo $codigo;?>','<?php echo"tdusuario".$x;?>',this,'inc/utilitarios/usuarios_editar.ajax.php')">
				  </td>
					<td align="center">
						<input name="btDeletar" type="submit" class="botao" value="Excluir" 
						onclick="document.getElementById('hdCodDel').value=<?php echo $codigo;?>;return Confirma('Deseja excluir este usuario?');" />
					</td>
				</tr>
				<tr>
					<td id="<?php echo"tdusuario".$x; ?>" colspan="4" align="center"></td>
				</tr>
			<?php
					$x++;
				} // fim while
			?>
			<input type="hidden" name="hdCodDel" id="hdCodDel" />
		</table>
</div>
</fieldset> 
<?php
}else{
	echo "
		<table width=\"100%\">
			<tr>
				<td align=\"center\"><b>No results!</b></td>
			</tr>
		</table>";
}
?>
</form>