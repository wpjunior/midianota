<?php
$login = $_SESSION['login'];
?>
<form method="post">
    <table width="100%">
        <tr>
            <td align="center"><input type="submit" class="botao" name="btOp" value="Gerar Guia">&nbsp;<input type="submit" name="btOp" class="botao" value="Guias Emitidas"></td>
        </tr>
    </table>
</form>
<?php
if ($_POST['btOp'] == "Gerar Guia") {
    include("guia_pagamento.php");
} elseif ($_POST['btOp'] == "Guias Emitidas") {
    include("pagamento_emitidas.php");
}

if ($btEnviaBoleto == "Boleto") {
    include("pagamento_boleto.php");
}
?>