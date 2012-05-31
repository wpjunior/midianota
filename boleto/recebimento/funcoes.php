<?

function geraCodigoDeBarras($valor){
$fino = 1 ;
$largo = 3 ;
$altura = 50 ;
  $barcodes[0] = "00110" ;
  $barcodes[1] = "10001" ;
  $barcodes[2] = "01001" ;
  $barcodes[3] = "11000" ;
  $barcodes[4] = "00101" ;
  $barcodes[5] = "10100" ;
  $barcodes[6] = "01100" ;
  $barcodes[7] = "00011" ;
  $barcodes[8] = "10010" ;
  $barcodes[9] = "01010" ;
  for($f1=9;$f1>=0;$f1--){ 
    for($f2=9;$f2>=0;$f2--){  
      $f = ($f1 * 10) + $f2 ;
      $texto = "" ;
      for($i=1;$i<6;$i++){ 
        $texto .=  substr($barcodes[$f1],($i-1),1) . substr($barcodes[$f2],($i-1),1);
      }
      $barcodes[$f] = $texto;
    }
  }
//Desenho da barra
//Guarda inicial
?>
    <img src=img/p.gif width=<?=$fino?> height=<?=$altura?> border=0><img 
	src=img/b.gif width=<?=$fino?> height=<?=$altura?> border=0><img 
	src=img/p.gif width=<?=$fino?> height=<?=$altura?> border=0><img 
	src=img/b.gif width=<?=$fino?> height=<?=$altura?> border=0><img 
<?php

$texto = $valor ;
if((strlen($texto) % 2) <> 0){
	$texto = "0" . $texto;
}

// Draw dos dados
while (strlen($texto) > 0) {
  $i = round(esquerda($texto,2));
  $texto = direita($texto,strlen($texto)-2);
  $f = $barcodes[$i];
  for($i=1;$i<11;$i+=2){
    if (substr($f,($i-1),1) == "0") {
      $f1 = $fino ;
    }else{
      $f1 = $largo ;
    }
?>
    src=img/p.gif width=<?=$f1?> height=<?=$altura?> border=0><img 
<?
    if (substr($f,$i,1) == "0") {
      $f2 = $fino ;
    }else{
      $f2 = $largo ;
    }
?>
    src=img/b.gif width=<?=$f2?> height=<?=$altura?> border=0><img 
<?
  }
}

// Draw guarda final
?>
src=img/p.gif width=<?=$largo?> height=<?=$altura?> border=0><img 
src=img/b.gif width=<?=$fino?> height=<?=$altura?> border=0><img 
src=img/p.gif width=<?=1?> height=<?=$altura?> border=0> 
  <?
} //Fim da função

function esquerda($entra,$comp){
	return substr($entra,0,$comp);
}

function direita($entra,$comp){
	return substr($entra,strlen($entra)-$comp,$comp);
}

function modulo_11($num, $base=9, $r=0) {
	$soma = 0;
	$fator = 2; 
	for ($i = strlen($num); $i > 0; $i--) {
		$numeros[$i] = substr($num,$i-1,1);
		$parcial[$i] = $numeros[$i] * $fator;
		$soma += $parcial[$i];
		if ($fator == $base) {
			$fator = 1;
		}
		$fator++;
	}
	if ($r == 0) {
		$soma *= 10;
		$digito = $soma % 11;
		
		//corrigido
		if ($digito == 10) {
			$digito = "X";
		}

		/*
		Vamos explicar:
		O módulo 11 só gera os digitos verificadores do nossonumero,
		agencia, conta e digito verificador com codigo de barras (aquele que fica sozinho e triste na linha digitável)
		só que é foi um rolo...pq ele nao podia resultar em 0, e o pessoal do phpboleto se esqueceu disso...
		
		No BB, os dígitos verificadores podem ser X ou 0 (zero) para agencia, conta e nosso numero,
		mas nunca pode ser X ou 0 (zero) para a linha digitável, justamente por ser totalmente numérica.

		Quando passamos os dados para a função, fica assim:

		Agencia = sempre 4 digitos
		Conta = até 8 dígitos
		Nosso número = de 1 a 17 digitos

		A unica variável que passa 17 digitos é a da linha digitada, justamente por ter 43 caracteres

		Entao vamos definir ai embaixo o seguinte...

		se (strlen($num) == 43) { não deixar dar digito X ou 0 }
		*/
		
		if (strlen($num) == "43") {
			//então estamos checando a linha digitável
			if ($digito == "0" or $digito == "X" or $digito > 9) {
					$digito = 1;
			}
		}
		return $digito;
	} 
	elseif ($r == 1){
		$resto = $soma % 11;
		return $resto;
	}
}



function formata_numero($numero,$loop,$insert,$tipo = "geral") {
	if ($tipo == "geral") {
		$numero = str_replace(",","",$numero);
		while(strlen($numero)<$loop){
			$numero = $insert . $numero;
		}
	}
	if ($tipo == "valor") {
		/*
		retira as virgulas
		formata o numero
		preenche com zeros
		*/
		$numero = str_replace(",","",$numero);
		while(strlen($numero)<$loop){
			$numero = $insert . $numero;
		}
	}
	if ($tipo == "convenio") {
		while(strlen($numero)<$loop){
			$numero = $numero . $insert;
		}
	}
	return $numero;
}

function gerar_nossonumero($convenio,$codigo,$loop){
	$numero = $codigo;
	while(strlen($numero)+strlen($convenio)< $loop) {
		$numero = 0 . $numero;
	}
	$nossonumero = $convenio.$numero;
	return $nossonumero;
}



?>
