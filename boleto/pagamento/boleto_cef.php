
<?php
/* session_start();
// Pega os dados da sessao para realizar as consultas no conect.php
$_SESSION['login'] = $txtLogin; 
$_SESSION['nome'] = $txtNome;

include("../inc/conect.php");

$sql=mysql_query("SELECT endereco,cidade,estado,cnpj FROM configuracoes");
list($enderdco_pref,$cidade_pref,$estado_pref,$cnpj_pref)=mysql_fetch_array($sql);



$dados=explode("|",$txtTotalIssHidden); //cria um vetor com o valor total do boleto e  com a quantidade de notas
$cont = $dados[1];
$maior =0;



while($cont >= 0)
{  
  $codnota = $_POST['txtCodNota'.$cont];  
  $sql=mysql_query("SELECT numero FROM notas WHERE codigo ='$codnota'");  
  list($numeronota)=mysql_fetch_array($sql);
  
  mysql_query("UPDATE notas SET estado='B' WHERE codigo='$codnota'");  
  if($numeronota > $maior)
  {
    $maior=$numeronota;
  }  
  $cont--;
}
//seleiona os dados monetarios da prefeitura
$sql=mysql_query("SELECT agencia,contacorrente,convenio,contrato,carteira FROM boleto");
list($agencia,$contacorrente,$convenio,$contrato,$carteira)=mysql_fetch_array($sql);
$txtTotalIss = explode(".",$txtTotalIss);
$valor =implode(",",$txtTotalIss); 

//Gera o nossonumero com 4 caracteres para o numero da nota e 4 caracteres para o codigo do emiisor
while(strlen($maior) < 4)
{
 $maior = $maior . 0;
}

 
while(strlen($CODIGO_DA_EMPRESA)< 4)
 {
	$CODIGO_DA_EMPRESA = 0 . $CODIGO_DA_EMPRESA;
 }
 $NossoNumero = $maior.$CODIGO_DA_EMPRESA ; */

include("../inc/conect.php");

$sql01=mysql_query("SELECT agencia,contacorrente,convenio,contrato,carteira FROM boleto");
list($agencia,$contacorrente,$convenio,$contrato,$carteira)=mysql_fetch_array($sql01);

$sql=mysql_query("SELECT dataemissao,valor,chavecontroledoc,datavencimento FROM guia_pagamento WHERE chavecontroledoc='80$chave' GROUP BY chavecontroledoc");
list($DataEmissao,$Valor,$NossoNumero,$DataVenc)=mysql_fetch_array($sql);

// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)	//

// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = 5;
$taxa_boleto = 0;
$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006";
$valor_cobrado = $Valor; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

$dadosboleto["inicio_nosso_numero"] = "";  // Carteira SR: 80, 81 ou 82  -  Carteira CR: 90 (Confirmar com gerente qual usar)
$dadosboleto["nosso_numero"] =  $NossoNumero;  // Nosso numero sem o DV - REGRA: Máximo de 8 caracteres!
$dadosboleto["numero_documento"] =$NossoNumero;	// Num do pedido ou do documento
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = $NOME;
$dadosboleto["endereco1"] = $ENDERECO_DA_EMPRESA;
$dadosboleto["endereco2"] = $MUNICIPIO_DA_EMPRESA." - ".$ESTADO_DA_EMPRESA;

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "GUIA DE RECOLHIMENTO DE ISS";
$dadosboleto["demonstrativo2"] = "SISTEMA ISS DIGITAL ";
$dadosboleto["demonstrativo3"] = "PREFEITURA MUNICIPAL DE ".$PREFEITURA;

// INSTRUÇÕES PARA O CAIXA
$dadosboleto["instrucoes1"] = "";
$dadosboleto["instrucoes2"] = "";
$dadosboleto["instrucoes3"] = "- Em caso de dúvidas entre em contato com a Prefeitura Municipal.";
$dadosboleto["instrucoes4"] = "&nbsp; Emitido pelo sistema de ISS DIGITAL";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "";
$dadosboleto["valor_unitario"] = "";
$dadosboleto["aceite"] = "";		
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "";


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


// DADOS DA SUA CONTA - CEF
$dadosboleto["agencia"] = $agencia; // Num da agencia, sem digito
$dadosboleto["conta"] = $contacorrente; 	// Num da conta, sem digito
$dadosboleto["conta_dv"] = "3"; 	// Digito do Num da conta

// DADOS PERSONALIZADOS - CEF
$dadosboleto["conta_cedente"] = ""; // ContaCedente do Cliente, sem digito (Somente Números)
$dadosboleto["conta_cedente_dv"] = ""; // Digito da ContaCedente do Cliente
$dadosboleto["carteira"] = "SR";  // Código da Carteira: pode ser SR (Sem Registro) ou CR (Com Registro) - (Confirmar com gerente qual usar)

// SEUS DADOS
$dadosboleto["identificacao"] = "PREFEITURA MUNICIPAL DE ".$PREFEITURA;
$dadosboleto["cpf_cnpj"] = $cnpj_pref;
$dadosboleto["endereco"] = $enderdco_pref;
$dadosboleto["cidade_uf"] = $cidade_pref." / ".$estado_pref;									
$dadosboleto["cedente"] =  "PREFEITURA MUNICIPAL DE ".$PREFEITURA;
$DataEmissaoNota= date("d/m/Y");

$cont =$dados[1];
$valor = explode(",",$valor); 
$txtTotalIss = implode(".",$valor);

$DataEmissaoBoleto = implode('-', array_reverse(explode('/',$dadosboleto["data_documento"]))); 
$DataVencimentoBoleto = implode('-', array_reverse(explode('/',$dadosboleto["data_vencimento"]))); 






// NÃO ALTERAR!
include("include/funcoes_cef.php"); 
include("include/layout_cef.php");
?>
