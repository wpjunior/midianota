<?php
/*
COPYRIGHT 2008 - 2010 DO PORTAL PUBLICO INFORMATICA LTDA

Este arquivo e parte do programa E-ISS / SEP-ISS

O E-ISS / SEP-ISS e um software livre; voce pode redistribui-lo e/ou modifica-lo
dentro dos termos da Licenca Publica Geral GNU como publicada pela Fundacao do
Software Livre - FSF; na versao 2 da Licenca

Este sistema e distribuido na esperanca de ser util, mas SEM NENHUMA GARANTIA,
sem uma garantia implicita de ADEQUACAO a qualquer MERCADO ou APLICACAO EM PARTICULAR
Veja a Licenca Publica Geral GNU/GPL em portugues para maiores detalhes

Voce deve ter recebido uma copia da Licenca Publica Geral GNU, sob o titulo LICENCA.txt,
junto com este sistema, se nao, acesse o Portal do Software Publico Brasileiro no endereco
www.softwarepublico.gov.br, ou escreva para a Fundacao do Software Livre Inc., 51 Franklin St,
Fith Floor, Boston, MA 02110-1301, USA
*/
?>
<?php 
$sql_test = mysql_query("SELECT nome, logradouro FROM cadastro WHERE cnpj='$txtCNPJ' OR cpf='$txtCNPJ'");
list($nome_test,$endereco_test) = mysql_fetch_array($sql_test);
if(!$endereco_test){
	mysql_query("UPDATE cadastro SET nome='$txtRazaoNome' WHERE cnpj='$txtCNPJ' OR cpf='$txtCNPJ'");
}
$sql=mysql_query("SELECT codigo FROM cadastro WHERE cnpj='$txtCNPJ' OR cpf='$txtCNPJ'");
list($CodTomador)=mysql_fetch_array($sql);

$inputs=$_POST['hdTotalInputs'];  
$total = MoedaToDec($_POST['txtTotalPagar']);  
$multa = MoedaToDec($_POST['txtMultaJuros']);  
$cnpfcpf=$_POST['txtCNPJ'];  
$razaonome=$_POST['txtRazaoNome'];
$mes = $_POST['cmbMes'];
$ano = $_POST['cmbAno'];
$competencia= $ano."-".$mes."-01";
    
mysql_query("
	INSERT INTO des_issretido 
	SET valor='$total',
		iss='$total',
		multa='$multa',
	 	codcadastro='$CodTomador',
	 	competencia='$competencia', 
	 	data_gerado=NOW(),
	 	codverificacao='$codverificacao',
	 	estado='B'
");
$sql=mysql_query("SELECT MAX(codigo) FROM des_issretido");
list($CodDes)=mysql_fetch_array($sql);

$sql=mysql_query("SELECT valor, multa FROM des_issretido WHERE codigo='$CodDes'");
list($ValorGuia,$ValorMulta)=mysql_fetch_array($sql);

$TotalDeclaracao = 0.00;
for($cont=1;$cont<=$inputs;$cont++) {
	$CnpjCpf = $_POST['txtcnpjcpf'.$cont];
	$sqlCodEmissor=mysql_query("SELECT codigo FROM cadastro WHERE cnpj='$CnpjCpf' OR cpf='$CnpjCpf'");
	list($codEmissor)=mysql_fetch_array($sqlCodEmissor); 
	
	$NroNota = $_POST['txtNroNota'.$cont];
	$ValIss = MoedaToDec($_POST['txtValIssRetido'.$cont]);
	$ValNota = MoedaToDec($_POST['txtValNota'.$cont]); 
	//Mensagem("ISS:$ValIss VALOR:$ValNota");
	mysql_query("
		INSERT INTO des_issretido_notas 
		SET coddes_issretido='$CodDes', 
			valor_nota='$ValNota', 
			codemissor='$codEmissor',	
			issretido='$ValIss',
			nota_nro='$NroNota'
	");
	$TotalDeclaracao += $ValNota;
}
mysql_query("
	UPDATE des_issretido
	SET total = '$TotalDeclaracao'
	WHERE codigo='$CodDes'
");
mysql_query("
	INSERT INTO guia_pagamento 
	SET dataemissao=NOW(),
		datavencimento='".DataVencimento()."',
		valor='$ValorGuia',
		valormulta='$ValorMulta'
");
$sql=mysql_query("SELECT MAX(codigo) FROM guia_pagamento");
list($CodGuia)=mysql_fetch_array($sql);

$nossonumero=gerar_nossonumero($CodGuia);

//echo($nossonumero);

$chave=gerar_chavecontrole($CodDes,$CodGuia);
mysql_query("
	UPDATE guia_pagamento 
	SET nossonumero='$nossonumero',
		chavecontroledoc='$chave'
	WHERE codigo='$CodGuia'	
");

mysql_query("
	INSERT INTO guias_declaracoes 
	SET codguia='$CodGuia',
		codrelacionamento='$CodDes',
		relacionamento='des_issretido'
");

$cod_guia= base64_encode($CodGuia);
$cod_des = base64_encode($CodDes);


// busca o codigo do banco e o arquivo q gera o boleto
$sql=mysql_query("SELECT bancos.boleto, boleto.tipo FROM boleto INNER JOIN bancos ON bancos.codigo = boleto.codbanco");
list($boleto,$tipoboleto)=mysql_fetch_array($sql);
if($tipoboleto=="R"){
    $tipoboleto="recebimento";
    $boleto="index.php";
}else{
    $tipoboleto="pagamento";
}
echo"<script>window.open('../../../boleto/$tipoboleto/$boleto?COD=$cod_guia');</script>";

//NovaJanela("../../../boleto/pagamento/$BOLETO_BANCO?COD=$cod_guia");
NovaJanela("../../reports/des_prestadores_comprovante.php?CODI=$cod_des");
?>




