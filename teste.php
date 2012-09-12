<?php

$dom = new DOMDocument("1.0", "ISO-8859-1");
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$root = $dom->createElement("ConsultarNfseRpsResposta");
$root->setAttribute("xmlns:tc", "http://www.issnetonline.com.br/webserviceabrasf/vsd/tipos_complexos.xsd");
$root->setAttribute("xmlns:ts", "http://www.issnetonline.com.br/webserviceabrasf/vsd/tipos_simples.xsd");
$root->setAttribute("xmlns", "http://www.issnetonline.com.br/webserviceabrasf/vsd/servico_consultar_nfse_rps_resposta.xsd");

$CompNfse = $dom->createElement("CompNfse");

$tcNfse = $dom->createElement("tc:Nfse");
$infNfse = $dom->createElement("tc:InfNfse");

$infNfse->appendChild($dom->createElement("tc:Numero", 7));  //TODO: substituir pelo id
$infNfse->appendChild($dom->createElement("tc:CodigoVerificacao", "B 5F 3 FC"));  //TODO: substituir pelo codigo de verificação
$infNfse->appendChild($dom->createElement("tc:DataEmissao", "2012-06-11T14:22:01"));  //TODO: substituir pela data de emissão
$infNfse->appendChild($dom->createElement("tc:NaturezaOperacao", 1));  //TODO: estudar a natureza da operação
$infNfse->appendChild($dom->createElement("tc:OptanteSimplesNacional", 1));  //TODO: 1 para sim 2 para não
$infNfse->appendChild($dom->createElement("tc:Competencia", "201206"));  //TODO: estudar competencia
$infNfse->appendChild($dom->createElement("tc:NfseSubstituida", "201206"));  //TODO: estudar substituida
$infNfse->appendChild($dom->createElement("tc:OutrasInformacoes", "201206"));  //TODO: estudar OutrasInformacoes

$servico = $dom->createElement("tc:Servico");

$tcValores = $dom->createElement("tc:Valores");
$tcValores->appendChild($dom->createElement("tc:ValorServicos", "50")); //TODO: ajustar para valor dos serviços
$tcValores->appendChild($dom->createElement("tc:ValorDeducoes", "50")); //TODO: ajustar para valor de deduções
$tcValores->appendChild($dom->createElement("tc:ValorPis", "50")); //TODO: ajustar para valor do pis
$tcValores->appendChild($dom->createElement("tc:ValorCofins", "50")); //TODO: ajustar para valor do cofins
$tcValores->appendChild($dom->createElement("tc:ValorCofins", "50")); //TODO: ajustar para valor do cofins
$tcValores->appendChild($dom->createElement("tc:ValorInss", "50")); //TODO: ajustar para valor do Inss
$tcValores->appendChild($dom->createElement("tc:ValorIr", "50")); //TODO: ajustar para valor do Ir
$tcValores->appendChild($dom->createElement("tc:ValorCsll", "50")); //TODO: ajustar para valor do Csll
$tcValores->appendChild($dom->createElement("tc:IssRetido", "1")); //TODO: ajustar para se o iss foi retido
$tcValores->appendChild($dom->createElement("tc:ValorIss", "100")); //TODO: ajustar para o valor que o iss foi redito
$tcValores->appendChild($dom->createElement("tc:ValorIssRetido", "100")); //TODO: ajustar para o valor que o iss foi redito
$tcValores->appendChild($dom->createElement("tc:OutrasRetencoes", "100")); //TODO: ajustar para o valor das outras retenções
$tcValores->appendChild($dom->createElement("tc:BaseCalculo", "100")); //TODO: ajustar para o valor das outras retenções
$tcValores->appendChild($dom->createElement("tc:Aliquota", "100")); //TODO: ajustar para o valor das outras retenções
$tcValores->appendChild($dom->createElement("tc:ValorLiquidoNfse", "100")); //TODO: ajustar para o valor das outras retenções
$tcValores->appendChild($dom->createElement("tc:DescontoIncondicionado", "100")); //TODO: ajustar para o valor das outras retenções
$tcValores->appendChild($dom->createElement("tc:DescontoCondicionado", "100")); //TODO: ajustar para o valor das outras retenções
$servico->appendChild($tcValores);

$servico->appendChild($dom->createElement("tc:ItemListaServico", "10")); //TODO: ajustar para o valor das outras retenções
$servico->appendChild($dom->createElement("tc:CodigoCnae", 5920100)); //TODO: ajustar para o valor das outras retenções
$servico->appendChild($dom->createElement("tc:CodigoTributacaoMunicipio", 5920100)); //TODO: ajustar para o valor das outras retenções
$servico->appendChild($dom->createElement("tc:Discriminacao", "Servicos referente ao Marnei")); //TODO: ajustar para o valor das outras retenções
$servico->appendChild($dom->createElement("tc:MunicipioPrestacaoServico", 5920100)); //TODO: ajustar para o valor das outras retenções

$infNfse->appendChild($servico);


$infNfse->appendChild($dom->createElement("tc:ValorCredito", 59)); //TODO: ajustar para o valor das outras retenções
/*
  <xsd:element name="IdentificacaoPrestador" type="tcIdentificacaoPrestador" minOccurs="1" maxOccurs="1"/>
  <xsd:element name="RazaoSocial" type="ts:tsRazaoSocial" minOccurs="1" maxOccurs="1"/>
  <xsd:element name="NomeFantasia" type="ts:tsNomeFantasia" minOccurs="0" maxOccurs="1"/>
  <xsd:element name="Endereco" type="tcEndereco" minOccurs="1" maxOccurs="1"/>
  <xsd:element name="Contato" type="tcContato" minOccurs="0" maxOccurs="1"/>
*/
$tcDadosPrestador = $dom->createElement("tc:PrestadorServico");
$infNfse->appendChild($tcDadosPrestador);

/*
<xsd:element name="PrestadorServico" type="tcDadosPrestador" minOccurs="1" maxOccurs="1"/>
<xsd:element name="TomadorServico" type="tcDadosTomador" minOccurs="1" maxOccurs="1"/>
<xsd:element name="IntermediarioServico" type="tcIdentificacaoIntermediarioServico" minOccurs="0" maxOccurs="1"/>
<xsd:element name="OrgaoGerador" type="tcIdentificacaoOrgaoGerador" minOccurs="1" maxOccurs="1"/>
<xsd:element name="ContrucaoCivil" type="tcDadosConstrucaoCivil" minOccurs="0" maxOccurs="1"/>
*/


$tcNfse->appendChild($infNfse);
$CompNfse->appendChild($tcNfse);
$root->appendChild($CompNfse);
$dom->appendChild($root);

print $dom->saveXML();

?>
