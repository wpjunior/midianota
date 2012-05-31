<?php
function modulo_11($num, $base=9, $r=0)  {
    /**
     *   Autor:
     *           Pablo Costa <pablo@users.sourceforge.net>
     *
     *   Função:
     *    Calculo do Modulo 11 para geracao do digito verificador 
     *    de boletos bancarios conforme documentos obtidos 
     *    da Febraban - www.febraban.org.br 
     *
     *   Entrada:
     *     $num: string numérica para a qual se deseja calcularo digito verificador;
     *     $base: valor maximo de multiplicacao [2-$base]
     *     $r: quando especificado um devolve somente o resto
     *
     *   Saída:
     *     Retorna o Digito verificador.
     *
     *   Observações:
     *     - Script desenvolvido sem nenhum reaproveitamento de código pré existente.
     *     - Assume-se que a verificação do formato das variáveis de entrada é feita antes da execução deste script.
     */                                        

    $soma = 0;
    $fator = 2;

    /* Separacao dos numeros */
    for ($i = strlen($num); $i > 0; $i--) {
        // pega cada numero isoladamente
        $numeros[$i] = substr($num,$i-1,1);
        // Efetua multiplicacao do numero pelo falor
        $parcial[$i] = $numeros[$i] * $fator;
        // Soma dos digitos
        $soma += $parcial[$i];
        if ($fator == $base) {
            // restaura fator de multiplicacao para 2 
            $fator = 1;
        }
        $fator++;
    }

    /* Calculo do modulo 11 */
    if ($r == 0) {
        $soma *= 10;
        $digito = $soma % 11;
        if ($digito == 10) {
            $digito = 0;
        }
        return $digito;
    } elseif ($r == 1){
        $resto = $soma % 11;
        return $resto;
    }
}
    function modulo_10($str)
    {
        if (is_string($str))
        {
            for ($i=0;$i<strlen($str); $i++)
            {
                $out = $out . Ord(substr($str,$i,1));
            }
        }
        else
            $out=$str;

        // is the length odd or even
        if ((int)(strlen($out)/2)    == (int)((strlen($out)/2)+0.9))
            $m=0;
        else
            $m=1;

        // sum the values for each digit, take care of values > 9
        for ($i=0;$i<strlen($out); $i++)
        {
            $m=($m==1)?2:1;
            $v=$m*substr($out, $i, 1);
            if ($v>9)
                $v=(substr($v, 0, 1)+substr($v, 1, 1));
            $sum = $sum + $v;
        }

        // what is the check digit??
        $cd=(round($sum/10+0.49)*10) - $sum;

            return $cd;
    }

	
	echo modulo_10("5555555555");
?>