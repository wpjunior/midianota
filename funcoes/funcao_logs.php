<?php 
function add_logs($acao)
{
 
 
 $usuario=$_SESSION["nome"];
 $ip=getenv("REMOTE_ADDR");  
 $sql=mysql_query("INSERT INTO logs SET usuario='$usuario', ip='$ip', datas=NOW(),acao = '$acao'");


} ?>