<?php

require_once("../../include/conect.php");
require_once("../../funcoes/util.php");

$cod_guia = $_GET['hdCodGuia'];

$sql = mysql_query("SELECT bancos.boleto, boleto.tipo FROM boleto INNER JOIN bancos ON bancos.codigo = boleto.codbanco");
list($boleto, $tipoboleto) = mysql_fetch_array($sql);
if ($tipoboleto == "R") {
    $tipoboleto = "recebimento";
    $boleto = "index.php";
} else {
    $tipoboleto = "pagamento";
}

imprimirGuia($cod_guia, true, true);

?>

