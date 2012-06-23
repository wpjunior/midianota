<?
//session_name('nfe');
session_start(); 
include("../funcoes/funcao_logs.php");

$autenticacao  = $_SESSION['autenticacao'];
$cod_seguranca = $_POST['codseguranca'];

if($cod_seguranca == $_SESSION['autenticacao'] && $cod_seguranca){
	include("conect.php");
	include("../funcoes/util.php");
	$campologin = $_POST['txtLogin'];
	$campo = tipoPessoa($campologin);
	$sql = mysql_query("SELECT * FROM cadastro WHERE $campo = '$campologin'");	
	if($campo&&mysql_num_rows($sql) > 0){ 
		$dados = mysql_fetch_array($sql);

		$login = $dados[$campo];

		$estado = $dados['estado'];
		

		if($estado == "A"){	
			if(md5($txtSenha) == $dados['senha']){	
				if($dados['codtipo'] == 1){ 
					$_SESSION['empresa'] = $dados['senha'];
					$_SESSION['login'] = $login;
					$_SESSION['nome'] = $dados['nome'];
					$nome = $dados['nome'];
					print("<script language=JavaScript>parent.location='../login.php';</script>");
				}else{
					print("<script language=JavaScript>alert('Somente prestadores podem se logar no sistema.');
					parent.location='../login.php';</script>");	
				}
			}else{
				print("<script language=JavaScript>alert('Senha não confere com a cadastrada no sistema! Favor verificar a senha.');
				parent.location='../login.php';</script>");	
			}
		}else{
			print("<script language=JavaScript>alert('Empresa desativada! Contate a Prefeitura.');parent.location='../login.php';</script>");
		}

	}else {
		print("<script language=JavaScript>alert('CPF/CNPJ não cadastrado no sistema! Favor verificar usuario.');parent.location='../login.php';</script>");
	} 

}else{
	print("<script language=JavaScript>alert('Favor verificar código de segurança!');parent.location='../login.php';</script>");
}
?>