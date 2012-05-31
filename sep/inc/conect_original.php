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
// Conectar ao banco de dados gerenciador das demais bases
$conectar = mysql_connect("10.0.0.4","issdigital","issdigital"); 
if (!$conectar) { die('Não foi possível conectar: ' . mysql_error()); } 

// Seleciona o banco de dados
$db_selected = mysql_select_db("issdigital", $conectar);
if (!$db_selected) {die ('Não foi possível acessar a base: ' . mysql_error());}


$Link = $_SERVER['HTTP_HOST'];

// CONDICIONAL PARA ATUALIZACAO DA REGRA DE CREDITOS DA PREFEITURA
if($btAtualizarCreditos == "Atualizar") {	
	mysql_query("UPDATE prefeituras SET credito01='$txtCredito01', credito02='$txtCredito02', credito03='$txtCredito03', credito04='$txtCredito04' WHERE codigo=$txtcodPrefeitura");
	echo "<script language=JavaScript>alert('Créditos atualizados com sucesso');parent.location='creditos.php';</script>";   
	add_logs('Atualizou regras de credito');
} // fim if
 

$sql=mysql_query("SELECT codigo,usuario,senha,banco,link FROM prefeituras WHERE link = '$Link' ");
list($CODPREF,$USUARIO,$SENHA,$BANCO,$LINK)=mysql_fetch_array($sql);

//Verifica o dominio para enviar o link para 
$dominio = explode(".",$LINK);
array_shift($dominio);
$novo_dominio = implode(".",$dominio);

$sql_link = mysql_query("SELECT link FROM prefeituras WHERE link LIKE '%$novo_dominio%' AND link LIKE 'iss%'");
list($LINK_ACESSO) = mysql_fetch_array($sql_link);

// Conectar ao banco de dados das prefeituras
$conectar_pref = mysql_connect("10.0.0.4",$USUARIO, $SENHA); 
if (!$conectar_pref) { die('Não foi possível conectar: ' . mysql_error()); } 

// Seleciona o banco de dados
$db_selected_pref = mysql_select_db($BANCO, $conectar_pref);
if (!$db_selected_pref) {die ('Não foi possível acessar a base: ' . mysql_error());}

// lista confguracoes
$sql_configuracoes = mysql_query("
	SELECT 
		endereco, 
		cidade, 
		estado, 
		cnpj, 
		email, 
		secretaria, 
		lei, 
		decreto, 
		topo, 
		logo,
		brasao, 
		codlayout,
		declaracoes_atrazadas, 
		gerar_guia_site 
	FROM  
		configuracoes
");
list($CONF_ENDERECO, $CONF_CIDADE, $CONF_ESTADO, $CONF_CNPJ, $CONF_EMAIL, $CONF_SECRETARIA, $CONF_LEI, $CONF_DECRETO, $CONF_TOPO, $CONF_LOGO,$CONF_BRASAO, $CONF_CODLAYOUT,$DEC_ATRAZADAS,$GERAR_GUIA_SITE) = mysql_fetch_array($sql_configuracoes);

if($CNF !="t")
{
 mysql_close($conectar);
}

?>
