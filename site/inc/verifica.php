<?php
 session_start(); 

$autenticacao = $_SESSION['autenticacao'];
$cod_seguranca= $_POST['codseguranca'];

if($cod_seguranca == $_SESSION['autenticacao'] && $cod_seguranca)
{

include("conect.php");
$sql = mysql_query("SELECT * FROM cadastro WHERE login = '".$_POST['txtLogin']."' and tipo = 'empresa'");	
 if(mysql_num_rows($sql) > 0) 
 { 
 	$dados = mysql_fetch_array($sql);
	
	$login = $dados['login'];
	
	$sql=mysql_query("SELECT estado FROM emissores WHERE cpf ='$login' OR cnpj='$login'");
	
	list($estado)=mysql_fetch_array($sql);
	if($estado == "A")
	{	
	 if(md5($txtSenha) == $dados['senha'])
	  {	   
		$_SESSION['empresa'] = $dados['senha'];
		$_SESSION['login'] = $login;
		$_SESSION['nome'] = $dados['nome'];
		print("<script language=JavaScript>parent.location='../login.php';</script>");
     }	 
	 else
	 {
	  print("<script language=JavaScript>alert('Senha no confere com a cadastrada no sistema! Favor verificar a senha.');parent.location='../login.php';</script>");	
	 }
	} 
    else
    {
    print("<script language=JavaScript>alert('Empresa desativada! Contate a Prefeitura.');parent.location='../login.php';</script>");
    }
  	 
} 

 else {
  print("<script language=JavaScript>alert('CPF/CNPJ não cadastrado no sistema! Favor verificar usuario.');parent.location='../login.php';</script>");
 } 

}else{
  print("<script language=JavaScript>alert('Favor verificar código de segurança!');parent.location='../login.php';</script>");
} 
?> 