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

$tcDadosPrestador = $dom->createElement("tc:PrestadorServico");

$tcIdentificacaoPrestador = $dom->createElement("tc:IdentificacaoPrestador");

$tcCpfCnpj = $dom->createElement("tc:CpfCnpj");
$tcCpfCnpj->appendChild($dom->createElement("tc:Cnpj", 5920100)); //TODO CNPJ ou CPF
$tcCpfCnpj->appendChild($dom->createElement("tc:Cpf", 5920100)); //TODO CNPJ ou CPF
$tcIdentificacaoPrestador->appendChild($tcCpfCnpj);
$tcIdentificacaoPrestador->appendChild($dom->createElement("tc:InscricaoMunicipal", 5920100)); //TODO Inscrição Municipal


$tcDadosPrestador->appendChild($tcIdentificacaoPrestador);
$tcDadosPrestador->appendChild($dom->createElement("tc:RazaoSocial", 5920100));
$tcDadosPrestador->appendChild($dom->createElement("tc:NomeFantasia", 5920100));

$tcEndereco = $dom->createElement("tc:Endereco");
$tcEndereco->appendChild($dom->createElement("tc:Endereco", "Rua 02 de Julho"));
$tcEndereco->appendChild($dom->createElement("tc:Numero", 28));
$tcEndereco->appendChild($dom->createElement("tc:Complemento", 28));
$tcEndereco->appendChild($dom->createElement("tc:Bairro", 28));
$tcEndereco->appendChild($dom->createElement("tc:Cidade", 28));
$tcEndereco->appendChild($dom->createElement("tc:Estado", 28));
$tcEndereco->appendChild($dom->createElement("tc:Cep", 28));

$tcDadosPrestador->appendChild($tcEndereco);

$tcContato = $dom->createElement("tc:Contato");
$tcContato->appendChild($dom->createElement("tc:Telefone", "6230994110"));
$tcContato->appendChild($dom->createElement("tc:Email", "wilsonpjunior@gmail.com"));
$tcDadosPrestador->appendChild($tcContato);

$infNfse->appendChild($tcDadosPrestador);


$tcDadosTomador = $dom->createElement("tc:TomadorServico");

$tcIdentificacaoTomador = $dom->createElement("tc:IdentificacaoTomador");

$tcCpfCnpj = $dom->createElement("tc:CpfCnpj");
$tcCpfCnpj->appendChild($dom->createElement("tc:Cnpj", 5920100)); //TODO CNPJ ou CPF
$tcCpfCnpj->appendChild($dom->createElement("tc:Cpf", 5920100)); //TODO CNPJ ou CPF
$tcIdentificacaoTomador->appendChild($tcCpfCnpj);

$tcDadosTomador->appendChild($tcIdentificacaoTomador);
$tcDadosTomador->appendChild($dom->createElement("tc:RazaoSocial", "kk kak"));

$tcEndereco = $dom->createElement("tc:Endereco");
$tcEndereco->appendChild($dom->createElement("tc:Endereco", "Rua 02 de Julho"));
$tcEndereco->appendChild($dom->createElement("tc:Numero", 28));
$tcEndereco->appendChild($dom->createElement("tc:Complemento", 28));
$tcEndereco->appendChild($dom->createElement("tc:Bairro", 28));
$tcEndereco->appendChild($dom->createElement("tc:Cidade", 28));
$tcEndereco->appendChild($dom->createElement("tc:Estado", 28));
$tcEndereco->appendChild($dom->createElement("tc:Cep", 28));

$tcDadosTomador->appendChild($tcEndereco);

$tcContato = $dom->createElement("tc:Contato");
$tcContato->appendChild($dom->createElement("tc:Telefone", "6230994110"));
$tcContato->appendChild($dom->createElement("tc:Email", "wilsonpjunior@gmail.com"));
$tcDadosTomador->appendChild($tcContato);

$infNfse->appendChild($tcDadosTomador);

$tcIdentificacaoIntermediarioServico = $dom->createElement("tc:IntermediarioServico");
$tcIdentificacaoIntermediarioServico->appendChild($dom->createElement("tc:RazaoSocial", "oi"));
$tcCpfCnpj = $dom->createElement("tc:CpfCnpj");
$tcCpfCnpj->appendChild($dom->createElement("tc:Cnpj", 5920100)); //TODO CNPJ ou CPF
$tcCpfCnpj->appendChild($dom->createElement("tc:Cpf", 5920100)); //TODO CNPJ ou CPF
$tcIdentificacaoIntermediarioServico->appendChild($tcCpfCnpj);

$tcIdentificacaoIntermediarioServico->appendChild($dom->createElement("tc:InscricaoMunicipal", "oi"));
$infNfse->appendChild($tcIdentificacaoIntermediarioServico);

$tcIdentificacaoOrgaoGerador = $dom->createElement("tc:OrgaoGerador");
$tcIdentificacaoOrgaoGerador->appendChild($dom->createElement("tc:CodigoMunicipio", 5920100)); //TODO CNPJ ou CPF
$tcIdentificacaoOrgaoGerador->appendChild($dom->createElement("tc:Uf", 5920100)); //TODO CNPJ ou CPF
$infNfse->appendChild($tcIdentificacaoOrgaoGerador);

$tcDadosConstrucaoCivil = $dom->createElement("tc:ContrucaoCivil");
$tcDadosConstrucaoCivil->appendChild($dom->createElement("tc:CodigoObra", 5920100)); //TODO CNPJ ou CPF
$tcDadosConstrucaoCivil->appendChild($dom->createElement("tc:Art", 5920100)); //TODO CNPJ ou CPF
$infNfse->appendChild($tcDadosConstrucaoCivil);

$tcNfse->appendChild($infNfse);

$Signature = $dom->createElement("Signature");
$Signature->setAttribute("xmlns", "http://www.w3.org/2000/09/xmldsig#");

$SignedInfo = $dom->createElement("SignedInfo");

$CanonicalizationMethod = $dom->createElement("CanonicalizationMethod");
$CanonicalizationMethod->setAttribute("Algorithm", "http://www.w3.org/TR/2001/REC-xml-c14n-20010315");
$SignedInfo->appendChild($CanonicalizationMethod);

$SignatureMethod = $dom->createElement("SignatureMethod");
$SignatureMethod->setAttribute("Algorithm", "http://www.w3.org/2000/09/xmldsig#rsa-sha1");
$SignedInfo->appendChild($SignatureMethod);

$Reference = $dom->createElement("Reference");
$Reference->setAttribute("URI", "http://www.w3.org/TR/2000/REC-xhtml1-20000126/");

$Transforms = $dom->createElement("Transforms");

$Transform = $dom->createElement("Transform");
$Transform->setAttribute("Algorithm", "http://www.w3.org/2000/09/xmldsig#enveloped-signature");
$Transforms->appendChild($Transform);

$Reference->appendChild($Transforms);

$DigestMethod = $dom->createElement("DigestMethod");
$DigestMethod->setAttribute("Algorithm", "http://www.w3.org/2000/09/xmldsig#sha1");
$Reference->appendChild($DigestMethod);

$Reference->appendChild($dom->createElement("DigestValue", "0gATjt6OsAoeV5ree86qnoa1Wds="));
$SignedInfo->appendChild($Reference);
$Signature->appendChild($SignedInfo);

$Signature->appendChild($dom->createElement("SignatureValue"));

$KeyInfo = $dom->createElement("KeyInfo");

$X509Data = $dom->createElement("X509Data");
$X509Data->appendChild($dom->createElement("X509Certificate"));
$KeyInfo->appendChild($X509Data);

$Signature->appendChild($KeyInfo);

$tcNfse->appendChild($Signature);




$CompNfse->appendChild($tcNfse);
$root->appendChild($CompNfse);
$dom->appendChild($root);

print $dom->saveXML();

?>
