<?php 
require_once dirname(__FILE__).'/config.php';

$conectar_pref = mysql_connect($HOST,$USUARIO, $SENHA); 
if (!$conectar_pref) { die('Não foi possível conectar: ' . mysql_error()); } 

$db_selected_pref = mysql_select_db($BANCO, $conectar_pref);
if (!$db_selected_pref) {die ('Não foi possível acessar a base: ' . mysql_error());}


 if($_SESSION['login'] != "")
 {
  $NOME =$_SESSION['nome'];
    
  $sql_codigo_empresa=mysql_query("SELECT codigo, ultimanota, senha FROM cadastro WHERE nome = '$NOME'");
  list($CODIGO_DA_EMPRESA,$ULTIMA_NOTA,$SENHA_EMPRESA)=mysql_fetch_array($sql_codigo_empresa);
 }

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
		topo_nfe, 
		logo_nfe,
		brasao_nfe, 
		codlayout, 
		declaracoes_atrazadas, 
		gerar_guia_site 
	FROM  
		configuracoes
");
list($CONF_ENDERECO, $CONF_CIDADE, $CONF_ESTADO, $CONF_CNPJ, $CONF_EMAIL, $CONF_SECRETARIA, $CONF_LEI, $CONF_DECRETO, $CONF_TOPO, $CONF_LOGO,$CONF_BRASAO, $CONF_CODLAYOUT, $DEC_ATRAZADAS,$GERAR_GUIA_SITE) = mysql_fetch_array($sql_configuracoes);
	


$sql_boleto_banco = mysql_query("
	SELECT bancos.boleto
	FROM boleto
	INNER JOIN bancos ON bancos.codigo = boleto.codbanco
");
list($BOLETO_BANCO)=mysql_fetch_array($sql_boleto_banco);
?>
