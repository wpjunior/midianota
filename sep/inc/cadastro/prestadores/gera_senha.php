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
	$novasenha  = rand(000000,999999);
	$senhamd5 = MD5($novasenha);
	$CODEMISSOR = $_POST['CODEMISSOR'];
	mysql_query("UPDATE cadastro SET senha = '$senhamd5' WHERE codigo = '$CODEMISSOR'");
	$sql_nome = mysql_query("SELECT nome, email FROM cadastro WHERE codigo = '$CODEMISSOR'");
	list($nome_prestador, $email) = mysql_fetch_array($sql_nome);
	//depois de cadastrada a empresa envia-se um passo a passo com  senha para a empresa cadastrada
	
	$msg = "
		$nome_prestador,<br>
		<br>
		Foi gerado uma nova senha de acesso ao sistema.<br>
		Sua senha é : $novasenha<br>
		<br>
		Caso não tenha solicitado uma renovação de senha, favor entrar em contato com a prefeitura.
	";	
	
	$assunto = "Nova senha de acesso ao sistema de NF-e.";

	$headers  = "MIME-Version: 1.0\r\n";

	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

	$headers .= "From: $CONF_SECRETARIA de $CONF_CIDADE <$CONF_EMAIL>  \r\n";

	$headers .= "Cc: \r\n";

	$headers .= "Bcc: \r\n";
	
	mail("$email",$assunto,$msg,$headers);
	Mensagem_onload("Foi gerada uma nova senha para $nome_prestador");
?>