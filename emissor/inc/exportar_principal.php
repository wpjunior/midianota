<?php

if ($btExportar != "") {
    if (($cmbMes != "") || ($cmbAno != "")) {
        if ($cmbMes <= 9) {
            $cmbMes = "0" . $cmbMes;
        }
        $periodo = $cmbAno . "-" . $cmbMes;
        $sql = mysql_query("
                -- 5.1 Nota Fiscal de Serviços Eletrônica
		SELECT 
			'' as assinatura,
                        notas.numero as numero_nfe,
			notas.codverificacao as codigo_verificacao,
			notas.datahoraemissao as data_emissao_nfe,
			replace(substring( notas.datahoraemissao, 1, 7), '-', '') as competencia,
                        '' as numero_nfe_substituida,
			notas.rps_numero as numero_rps,        
			notas.rps_data as data_emissao_rps,
			'' as serie_rps,
                        '' as tipo_rps,
                        '' as outras_informacoes,
                        if(cadastro.codtipodeclaracao = 3, 1, 2) as optante_simples_nacional,                        
                        '2' as incentivador_cultural,
                        '' as regime_especial_tributacao,
                        natureza_operacao as natureza_da_operacao
                		
		FROM 
			notas 
		INNER JOIN 
			notas_servicos ON notas_servicos.codnota = notas.codigo
				
		INNER JOIN 
			servicos ON notas_servicos.codservico = servicos.codigo				
		INNER JOIN 
			cadastro  ON notas.codemissor = cadastro.codigo
		WHERE 
			datahoraemissao LIKE '%$periodo%' AND notas.codemissor = '$CODIGO_DA_EMPRESA' ORDER BY datahoraemissao");

        // Gera o arquivo CSV para download
        $arquivo = $CODIGO_DA_EMPRESA . "arquivo.csv";
        $fp = fopen("tmp/" . $arquivo, "w");
        $cabecario = "assinatura;numero_nfe;codigo_verificacao;data_emissao_nfe;".
                    "competencia;numero_nfe_substituida;numero_rps;data_emissao_rps;".
                "serie_rps;tipo_rps;outras_informacoes;optante_simples_nacional;".
                "incentivador_cultural;regime_especial_tributacao;natureza_da_operacao\n";
        
        fwrite($fp, $cabecario);

        while ($cadastro = mysql_fetch_array($sql)) {
          
             $registros = $cadastro["assinatura"] . ";"
                        . $cadastro["numero_nfe"] . ";"
                        . $cadastro["codigo_verificacao"] . ";"
                        . $cadastro["data_emissao_nfe"] . ";"
                        . $cadastro["competencia"] . ";"
                        . $cadastro["numero_nfe_substituida"] . ";"
                        . $cadastro["numero_rps"] . ";"
                        . $cadastro["data_emissao_rps"] . ";"
                        . $cadastro["serie_rps"] . ";"
                        . $cadastro["tipo_rps"] . ";"
                        . $cadastro["outras_informacoes"] . ";"
                        . $cadastro["optante_simples_nacional"] . ";"
                        . $cadastro["incentivador_cultural"] . ";"
                        . $cadastro["regime_especial_tributacao"] . ";"
                        . $cadastro["natureza_da_operacao"] . "\n";

            fwrite($fp, $registros); // Grava a linha no arquivo
        }
        fclose($fp);
    } else {
        print("<script language=JavaScript>alert('Selecione um mês e um ano!!')</script>");
    }
}
?>

<form action="exportar.php" method="post" name="frmPagamento" >   
    <table border="0" align="center" cellpadding="0" cellspacing="1">
        <tr>
            <td width="10" height="10" bgcolor="#FFFFFF"></td>
            <td width="100" align="center" bgcolor="#FFFFFF" rowspan="3">Exportar Notas</td>
            <td width="470" bgcolor="#FFFFFF"></td>
        </tr>
        <tr>
            <td height="1" bgcolor="#CCCCCC"></td>
            <td bgcolor="#CCCCCC"></td>
        </tr>
        <tr>
            <td height="10" bgcolor="#FFFFFF"></td>
            <td bgcolor="#FFFFFF"></td>
        </tr>
        <tr>
            <td colspan="3" height="1" bgcolor="#CCCCCC"></td>
        </tr>
        <tr>
            <td height="60" colspan="3" bgcolor="#CCCCCC">
                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">	       
                    <tr>
                        <td align="left" width="30%">Período das Notas</td>
                        <td align="left" width="70%">
                            <select name="cmbMes" class="combo">
                                <option value="">== Mês ==</option>
                                <?php
                                $meses = array(1 => "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");
                                foreach ($meses as $num => $mes) {
                                    echo "<option value='$num' ";
                                    if ($cmbMes == $num) {
                                        echo "selected=selected";
                                    }
                                    echo ">$mes</option>";
                                }
                                ?>
                            </select> / 
                            <select name="cmbAno" class="combo">
                                <option value="">==ANO==</option>
                                <?php
                                $ano = date("Y");
                                for ($x = 0; $x <= 4; $x++) {
                                    $year = $ano - $x;
                                    echo "<option value='$year' ";
                                    if ($cmbAno == $year) {
                                        echo "selected=selected";
                                    }
                                    echo ">$year</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>	  
                    <tr>
                        <td colspan="2" align="center"><input type="submit" value="Exportar" name="btExportar" class="botao" /></td>
                    </tr>
                    <td colspan="2" align="center">
                        <?php
                        if (($btExportar != "") && ($cmbMes != "") && ($cmbAno != "")) {
                            print("Exportação concluída com sucesso!<br>
	  <a href='../download?/emissor/tmp/$arquivo'><img src='../img/imgcsv.jpg' border='0'></a> &nbsp; 
	  <a href='../download?/emissor/tmp/$arquivo'>Clique aqui</a> para baixar o arquivo");
                        }
                        ?>

                    </td>
        </tr>   
    </table> 

</td>
</tr>
<tr>
    <td height="1" colspan="3" bgcolor="#CCCCCC"></td>
</tr>
</table>      
</form>
