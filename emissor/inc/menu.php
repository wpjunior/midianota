<?php
$codDaSessao = $_SESSION['codempresa'];
$sql_tipo_declaracao = mysql_query("SELECT codtipodeclaracao FROM cadastro WHERE codigo = '$codDaSessao'");
list($codtipodeclaracao) = mysql_fetch_array($sql_tipo_declaracao);
$codtipodec = coddeclaracao('Simples Nacional');

if ($codtipodeclaracao == $codtipodec) {
    $menu = array("Notas Eletrônicas", "Cadastro", "Contador", "Tomadores", "Livro Digital", "AIDF Eletrônico", "Importar RPS", "Exportar Notas", "Ouvidoria", "Utilitários", "Sair");
    $links = array("notas.php", "empresas.php", "definir_contador.php", "cadastro_tomador", "livro.php", "aidf.php", "importar.php", "exportar.php", "reclamacoes.php", "utilitarios.php", "logout.php");
} else {
    $menu = array("Notas Eletrônicas", "Cadastro", "Contador",  "cadastro_tomador", "Livro Digital", "AIDF Eletrônico", "Importar RPS", "Exportar Notas", "Ouvidoria", "Utilitários", "Sair");
    $links = array("notas.php", "empresas.php", "definir_contador.php", "livro.php", "aidf.php", "importar.php", "exportar.php", "reclamacoes.php", "utilitarios.php", "logout.php");
}
$cont = count($menu);
$aux = 0;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <?php
    while ($aux < $cont) {
        ?>
        <tr>
            <td height="20" class="menu">
                <?php
                print(" <a class=\"menu\" href=$links[$aux] target=_parent>&nbsp;$menu[$aux]</a>");
                ?>
            </td>
        </tr>
        <tr>
            <td height="1" bgcolor="#CCCCCC"></td>
        </tr>
        <?php
        $aux++;
    }
    ?>
</table>
