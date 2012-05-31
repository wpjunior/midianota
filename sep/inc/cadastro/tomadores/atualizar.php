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
	$nome           = trataString($_POST["txtNome"]);
	$cnpjcpf        = $_POST["txtCNPJCPF"];
	$inscrmunicipal = $_POST["txtINSCMUNICIPAL"];
	$logradouro     = trataString($_POST["txtLogradouro"]);
	$numero         = trataString($_POST["txtNumero"]);
	$cep            = $_POST["txtCEP"];
	$municipio      = $_POST["txtInsMunicipioEmpresa"];
	$uf             = $_POST["txtInsUfEmpresa"];
	$email          = trataString($_POST["txtEmail"]);
	$codigo         = $_POST["CODTOMADOR"];
	
	if($cnpjcpf == ""){
		$cnpjcpf = $_POST['hdCNPJCPF'];
	}
	$campo = tipoPessoa($cnpjcpf);
	//testa se ja existe algum registro no banco com o cnpjcpf informado se houver atualiza as informacoes se nao inseri novas informacoes
	$sql_tomador = mysql_query("SELECT $campo, inscrmunicipal, email FROM cadastro WHERE $campo = '$cnpjcpf'");
	list($CNPJCPF,$INSCRMUNICIPAL,$EMAIL) = mysql_fetch_array($sql_tomador);
	if($inscrmunicipal == ""){
		$inscrmunicipal = $INSCRMUNICIPAL;
	}//fim if
	if($email == ""){
		$email = $EMAIL;
	}//fim if
	if(mysql_num_rows($sql_tomador)>0){
		//sql que realiza a atualizacao na tabela
		mysql_query("UPDATE cadastro SET nome = '$nome', $campo = '$cnpjcpf', inscrmunicipal = '$inscrmunicipal', logradouro = '$logradouro', numero = '$numero', cep = '$cep', municipio = '$municipio', uf = '$uf', email = '$email' WHERE codigo = '$codigo'");
		add_logs('Atualizou os dados de Tomador');
		Mensagem_onload("Atualizado");
	}
?>