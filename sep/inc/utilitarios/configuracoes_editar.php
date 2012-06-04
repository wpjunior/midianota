<?php

//recebimento de variaveis por post
$endereco        = $_POST["txtEndereco"];
$cidade          = $_POST["txtCidade"];
$uf              = $_POST["txtUF"];
$chefetributos   = $_POST["txtChefe"];
$cnpj            = $_POST["txtCNPJ"];
$email           = $_POST["txtEmail"];
$lei             = $_POST["txtLei"];
$decreto         = $_POST["txtDecreto"];
$secretaria      = $_POST["txtSecretaria"];
$secretario      = $_POST["txtSecretario"];
$taxamulta       = $_POST["txtMulta"];
$taxajuros       = $_POST["txtJuros"];	
$taxacorrecao    = $_POST["txtTaxaCorrecao"];
$data_tributacao = $_POST["txtData"];
$layout          = $_POST["txtLayout"];
$dec_atrazadas   = $_POST["rbDec"];//dec_atrazadas serve para definir se a prefeitura aceita declaracoes atrazadas pelo site, se nao aceita, somente com a prefeitura pelo sepiss
$gerar_guia_site = $_POST["rbGuias"];

if( strlen($_FILES['flTopo']['name']) > 3 )
    $topo = Uploadimagem('flTopo','/var/www/prd/sep/img/topos/', 'rand', 1);

 
if( strlen($_FILES['flBrasao']['name']) > 3 )
    $brasao = Uploadimagem('flBrasao','/var/www/prd/sep/img/brasoes/', 'rand', 1);


if( strlen($_FILES['flLogo']['name']) > 3 )
    $logo = Uploadimagem('flLogo','/var/www/prd/sep/img/logos/', 'rand', 1);
	
//fim if 
//--------------------Update------------------------------  
//testa quais arquivos foram upados e tem retorno para atualizar no banco, para nao subescrever arquivos anteriores
if(($brasao != "") && ($logo == "") && ($topo == "")){
	$string = ",brasao_nfe = '$brasao'";
}elseif(($brasao == "") && ($logo != "") && ($topo == "")){
	$string = ",logo_nfe = '$logo'";
}elseif(($brasao == "") && ($logo == "") && ($topo != "")){
	$string = ",topo_nfe = '$topo'";
}elseif(($brasao != "") && ($logo != "") && ($topo == "")){
	$string = ",brasao_nfe = '$brasao', logo_nfe = '$logo'";
}elseif(($brasao != "") && ($logo == "") && ($topo != "")){
	$string = ",brasao_nfe = '$brasao', topo_nfe = '$topo'";
}elseif(($brasao == "") && ($logo != "") && ($topo != "")){
	$string = ",logo_nfe = '$logo', topo_nfe = '$topo'";
}elseif(($brasao != "") && ($logo != "") && ($topo != "")){
	$string = ",brasao_nfe = '$brasao', logo_nfe = '$logo', topo_nfe = '$topo'";
}//fim elseif

mysql_query("
	UPDATE configuracoes SET 
		endereco = '$endereco', 
		cidade = '$cidade', 
		estado = '$uf', 
		cnpj = '$cnpj', 
		email = '$email', 
		secretaria = '$secretaria', 
		secretario = '$secretario', 
		chefetributos = '$chefetributos', 
		lei = '$lei', 
		decreto = '$decreto'". $string .", 
		codlayout = '$layout', 
		taxacorrecao = '$taxacorrecao', 
		taxamulta = '$taxamulta', 
		taxajuros = '$taxajuros', 
		data_tributacao = '$data_tributacao', 
		declaracoes_atrazadas='$dec_atrazadas' , 
		gerar_guia_site='$gerar_guia_site'
");
add_logs('Atualizou uma Configuração');
if($alerta != 1){
	Mensagem_onload("Dados atualizados");
}else{
	Mensagem_onload("O Logo, Brasão e Topo devem ter, no máximo, 100 pixels de altura por 100 pixels de largura cada.");
}
?>
