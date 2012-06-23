<?php

if ($txtSenha != "") {
    $campo = tipoPessoa($login);
    $sql = mysql_query("UPDATE cadastro SET senha = '$txtSenha' WHERE $campo = '$login'");
    print("<script language=JavaScript>alert('Usuário atualizado com sucesso!!')</script>");
    add_logs('Alterou a senha');
}
else
    print("<script language=JavaScript>alert('O campo senha deve ser preenchido!!')</script>");
?>