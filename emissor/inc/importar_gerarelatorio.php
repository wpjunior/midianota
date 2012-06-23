<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>RPS convertidos em NF-e</title>
        <link href="../../css/imprimir_emissor.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <?php
        session_name("emissor");
        session_start();
        if (!(isset($_SESSION["empresa"]))) {
            echo "
		<script>
		alert('Acesso Negado!');
		window.location='../login.php';
		</script>
	";
        } else {

            // conecta ao banco
            include("../../include/conect.php");

            $mes = $_POST["cmbMes"];
            $ano = $_POST["cmbAno"];
            $string = "";
            // cosulta notas geradas pelo importar
            if ($mes) {
                $string = " AND MONTH(datahoraemissao) = '$mes'";
            }
            if ($ano) {
                $string .= " AND YEAR(datahoraemissao) = '$ano'";
            }

            $sql = mysql_query("
		SELECT 
			numero, 
			codverificacao, 
			datahoraemissao, 
			rps_numero, 
			rps_data, 
			tomador_nome, 
			tomador_cnpjcpf, 
			tomador_municipio, 
			tomador_uf, 
			valortotal
		FROM 
			notas
		WHERE 
			codemissor = '$CODIGO_DA_EMPRESA' AND tipoemissao = 'importada' $string
		ORDER BY
			numero
	");
            ?>
            <table width="100%" border="0" cellpadding="2" cellspacing="2">
                <?php
                if (mysql_num_rows($sql) > 0) {
                    ?>
                    <tr>
                        <td colspan="10" align="left" class="cab01">RPS CONVERTIDOS EM NFE <?php if ($string) {
                echo "- Período: $mes/$ano";
            } ?></td>
                    </tr>
                    <tr>
                        <td>Total de RPS convertidos: <?php echo mysql_num_rows($sql); ?></td>
                    </tr>
                    <tr>
                        <td class="cab02" align="center">Número da NFe </td>
                        <td class="cab02" align="center">Cód. Verificação </td>
                        <td class="cab02" align="center">Data/Hora Emissão </td>
                        <td class="cab02" align="center">RPS - Número </td>
                        <td class="cab02" align="center">RPS - Data </td>
                        <td class="cab02" align="center">Tomador - Nome </td>
                        <td class="cab02" align="center">Tomador - CNPJ/CPF </td>
                        <td class="cab02" align="center">Tomador - Município </td>
                        <td class="cab02" align="center">Tomador - UF </td>
                        <td class="cab02" align="center">Valor Total </td>
                    </tr>
                    <tr>
                        <td colspan="10" height="1" class="linha"></td>
                    </tr>
                    <?php
                    while (list($numero, $codverificacao, $datahoraemissao, $rps_numero, $rps_data, $tomador_nome, $tomador_cnpjcpf, $tomador_municipio, $tomador_uf, $valortotal) = mysql_fetch_array($sql)) {
                        ?>
                        <tr>
                            <td align="center"><?php echo $numero; ?></td>
                            <td align="center"><?php echo $codverificacao; ?></td>
                            <td align="center"><?php echo substr($datahoraemissao, 8, 2) . "/" . substr($datahoraemissao, 5, 2) . "/" . substr($datahoraemissao, 0, 4); ?></td>
                            <td align="center"><?php echo $rps_numero; ?></td>
                            <td align="center"><?php echo substr($rps_data, 8, 2) . "/" . substr($rps_data, 5, 2) . "/" . substr($rps_data, 0, 4); ?></td>
                            <td align="left"><?php echo $tomador_nome; ?></td>
                            <td align="center"><?php echo $tomador_cnpjcpf; ?></td>
                            <td align="center"><?php echo $tomador_municipio; ?></td>
                            <td align="center"><?php echo $tomador_uf; ?></td>
                            <td align="center">R$ <?php echo $valortotal; ?></td>
                        </tr>
                        <tr>
                            <td colspan="10" height="1" class="linha"></td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td colspan="10" align="right">Sistema e-Nota da Prefeitura Municipal de <?php echo $CONF_CIDADE; ?></td>
                    </tr>
                    <?php
                } else {
                    ?>
                    <tr>
                        <td align="center"><b>Não há rps convertidos nesse período!</b></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <?php
        }
        ?>
    </body>
</html>
