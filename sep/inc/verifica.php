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

session_start();
include("../funcoes/util.php");
// recebe a variavel que contem o n�mero de verifica��o e a variavel que cont�m o n�mero que o usu�rio digitou.
$autenticacao = $_SESSION['autenticacao'];
$cod_seguranca = $_POST['codseguranca'];

if ($cod_seguranca == $_SESSION['autenticacao'] && $cod_seguranca) {

    include("conect.php");
    $sql = mysql_query("SELECT * FROM usuarios WHERE login = '" . $_POST['txtLogin'] . "' and tipo = 'prefeitura' ");
    if (mysql_num_rows($sql) > 0) {
        $dados = mysql_fetch_array($sql);
        //verifica se a senha digitada confere com a que est� armazenada no banco	
        if (md5($_POST['txtSenha']) == $dados['senha']) {
            // inicia a sess�o e direciona para index.		
            $_SESSION['logado'] = $dados['codigo'];
            $_SESSION['login'] = $dados['login'];
            $_SESSION['nivel_de_acesso'] = $dados['nivel'];
            add_logs('Efetuou o Login');
            $nome = $dados['nome'];
            //Salva no banco o ultimo login do usuario
            $sql = mysql_query("UPDATE usuarios SET ultlogin= NOW()  WHERE nome = '$nome'");
            print("<script language=JavaScript>parent.location='../login.php';</script>");
        } else {
            print("<script language=JavaScript>alert('Senha n�o confere com a cadastrada no sistema! Favor verificar a senha.');parent.location='../login.php';</script>");
        }
    } else {
        print("<script language=JavaScript>alert('Usu�rio inexistente! Favor verificar usuario.');parent.location='../login.php';</script>");
    }
} else {
    print("<script language=JavaScript>alert('Favor verificar c�digo de seguran�a!');parent.location='../login.php';</script>");
}
?> 