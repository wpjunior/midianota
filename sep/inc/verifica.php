<?php

session_start();
include("../funcoes/util.php");

$autenticacao = $_SESSION['autenticacao'];
$cod_seguranca = $_POST['codseguranca'];

if ($cod_seguranca == $_SESSION['autenticacao'] && $cod_seguranca) {

    include("conect.php");
    $sql = mysql_query("SELECT * FROM usuarios WHERE login = '" . $_POST['txtLogin'] . "' and tipo = 'prefeitura' ");
    if (mysql_num_rows($sql) > 0) {
        $dados = mysql_fetch_array($sql);

        if (md5($_POST['txtSenha']) == $dados['senha']) {
	
            $_SESSION['logado'] = $dados['codigo'];
            $_SESSION['login'] = $dados['login'];
            $_SESSION['nivel_de_acesso'] = $dados['nivel'];
            add_logs('Efetuou o Login');
            $nome = $dados['nome'];

            $sql = mysql_query("UPDATE usuarios SET ultlogin= NOW()  WHERE nome = '$nome'");
            print("<script language=JavaScript>parent.location='../login.php';</script>");
        } else {
            print("<script language=JavaScript>alert('Senha não confere com a cadastrada no sistema! Favor verificar a senha.');parent.location='../login.php';</script>");
        }
    } else {
        print("<script language=JavaScript>alert('Usuário inexistente! Favor verificar usuario.');parent.location='../login.php';</script>");
    }
} else {
    print("<script language=JavaScript>alert('Favor verificar código de segurança!');parent.location='../login.php';</script>");
}
?> 