<?php

require_once dirname(__FILE__) . '/../../include/config.php';

$conectar_pref = mysql_connect($HOST, $USUARIO, $SENHA);
if (!$conectar_pref) {
    die('Não foi possível conectar: ' . mysql_error());
}

$db_selected_pref = mysql_select_db($BANCO, $conectar_pref);
if (!$db_selected_pref) {
    die('Não foi possível acessar a base: ' . mysql_error());
}

if ($_SESSION['login'] != "") {
    $NOME = $_SESSION['nome'];
    $sql_codigo_empresa = mysql_query("SELECT codigo, ultimanota, municipio, uf, logradouro, numero FROM cadastro WHERE nome = '$NOME'");
    list($CODIGO_DA_EMPRESA, $ULTIMA_NOTA, $MUNICIPIO_DA_EMPRESA, $ESTADO_DA_EMPRESA, $ENDERECO_DA_EMPRESA, $NUMERO_DA_EMPRESA) = mysql_fetch_array($sql_codigo_empresa);

    $sql_dadosprefeitura = mysql_query("SELECT cidade, estado, cnpj, endereco, topo_nfe, brasao_nfe, secretaria FROM configuracoes");
    list($NOME_MUNICIPIO, $UF_MUNICIPIO, $CNPJ_MUNICIPIO, $ENDERECO_DA_PREFEITURA, $TOPO, $BRASAO, $SECRETARIA) = mysql_fetch_array($sql_dadosprefeitura);
}
?>
