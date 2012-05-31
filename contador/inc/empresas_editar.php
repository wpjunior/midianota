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
$senha  = $_POST['txtSenha'];
$email  = $_POST['txtEmail'];
$codigo = $_POST['hdCod'];
if($arquivo !=""){
// Upload e redimensionamento da Imagem------------------------------------------
	$arquivo = Uploadimagem("arquivo","../img/logos/",$codigo,1);
	if(!is_null($arquivo)){
		//Cria uma copia do arquivo pdf na pasta do issdigital
		$file = "../img/logos/$arquivo";
		$newfile = "../sep/img/logos/$arquivo";
		
		if(!copy($file, $newfile)) {
			echo "falha ao copiar $file...\n";
		}
		$sql = mysql_query("UPDATE cadastro SET logo = '$arquivo' WHERE nome = '$NOME'");
		$imagem = "Atualizada";
	}else{
		Mensagem("O logo deve ter, no máximo 100 pixels de altura por 100 pixels de largura");
		Redireciona("empresas.php");
	}
} 
//--------------------Update------------------------------  
$sql_mudanca = mysql_query("SELECT email, senha FROM cadastro WHERE codigo = '$codigo'");
list($email_mysql,$senha_mysql) = mysql_fetch_array($sql_mudanca);
if(($email != $email_mysql) || ($senha != $senha_mysql) || ($imagem == "Atualizada")){
	
	$query = "UPDATE cadastro SET email = '$email'";
	
	if ($senha) {
		$query .= ", senha = md5('$senha') ";
	}
	
	$query .= "WHERE nome = '$NOME'";
	
	$sql = mysql_query($query);
	echo "<script>alert('Empresa atualizada com sucesso');</script>";
	add_logs('Atualizou empresa');
}
?>
