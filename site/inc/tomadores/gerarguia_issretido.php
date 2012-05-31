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

$cnpj = $_POST['txtCNPJ'];
$mes = $_POST['cmbMes'];
$ano = $_POST['cmbAno'];
$codigo_nota = $_POST['hdCodigoGuia'];
$razao_social = $_POST['txtRazaoNome'];

$sql_test = mysql_query("SELECT nome, logradouro FROM cadastro WHERE cnpj='$cnpj' OR cpf='$cnpj'");
list($nome_test,$endereco_test) = mysql_fetch_array($sql_test);
if(!$endereco_test){
	mysql_query("UPDATE cadastro SET nome='$razao_social' WHERE cnpj='$cnpj' OR cpf='$cnpj'");
}
$sql=mysql_query("SELECT codigo FROM cadastro WHERE cnpj='$cnpj' OR cpf='$cnpj'");
list($CodTomador)=mysql_fetch_array($sql);

$sql_guia_prestador = mysql_query("
	SELECT 
		numero,
		valortotal,
		valoriss,
		issretido,
		codemissor
	FROM
		notas
	WHERE
		codigo = '$codigo_nota'
");
list($numero,$total,$iss,$issretido,$codprestador) = mysql_fetch_array($sql_guia_prestador);

$competencia    = $ano."-".$mes."-01";
$dataemissao    = date("Y-m-d");
$data           = explode("-",$dataemissao);
/*$datavencimento = mktime(24*5,0,0,$data[1],$data[2],$data[0]);
$datavencimento = date("Y-m-d",$datavencimento);*/
$datavencimento = UltDiaUtil($data[1],$data[0]);


mysql_query("
	INSERT INTO 
		des_issretido 
	SET 
		valor='$issretido',
		iss='$iss',
		multa='0',
	 	codcadastro='$CodTomador',
	 	competencia='$competencia', 
	 	data_gerado=NOW(),
	 	codverificacao='$codverificacao',
		total = '$total',
	 	estado='B'
");
$sql=mysql_query("SELECT MAX(codigo) FROM des_issretido");
list($CodDes)=mysql_fetch_array($sql);

$sql=mysql_query("SELECT valor, multa FROM des_issretido WHERE codigo='$CodDes'");
list($ValorGuia,$ValorMulta)=mysql_fetch_array($sql);

mysql_query("
	INSERT INTO 
		des_issretido_notas 
	SET 
		coddes_issretido='$CodDes', 
		valor_nota='$total', 
		codemissor='$codprestador',	
		issretido='$issretido',
		nota_nro='$numero'
");

/* --- Separacao da insercao da des com issretido para a emissao de guia --- */

// busca o codigo do banco e o arquivo q gera o boleto
$sql=mysql_query("SELECT bancos.codigo, bancos.boleto FROM bancos INNER JOIN boleto ON bancos.codigo=boleto.codbanco");
list($codbanco,$boleto)=mysql_fetch_array($sql);

// inseri a guia de pagamento no db

//require_once("../../../midware/conecta.pg.php");
//$pg_sql_cod = pg_query("SELECT MAX(numero_conhecimto) FROM smafinan");
//list($pg_last_id) = pg_fetch_array($pg_sql_cod);
//$pg_codigo = $pg_last_id + 1;
mysql_query("
	INSERT INTO 
		guia_pagamento 
	SET  
		valor='$ValorGuia', 
		valormulta='$ValorMulta', 
		dataemissao='$dataemissao',
		datavencimento='$datavencimento', 
		pago='N', 
		estado='N'
");

// busca o codigo da guia de pagamento recem inserida
$sql=mysql_query("SELECT MAX(codigo) FROM guia_pagamento");
list($codguia)=mysql_fetch_array($sql);
//include_once('../guia_pg/postgre_sql.php');

mysql_query("
	INSERT INTO 
		guias_declaracoes 
	SET 
		codguia='$codguia',
		codrelacionamento='$CodDes',
		relacionamento='des_issretido'
");
mysql_query("UPDATE des_issretido SET estado='B' WHERE codigo='$CodDes'");

// retorna o codigo do ultimo relacionamento
$sql=mysql_query("SELECT MAX(codigo) FROM guias_declaracoes");
list($codrelacionamento)=mysql_fetch_array($sql);

// gera o nossonumero e chavecontroledoc
$nossonumero = gerar_nossonumero($codguia);
$chavecontroledoc = gerar_chavecontrole($codrelacionamento,$codguia);

// seta o nossonumero e a chavecontroledoc no banco
mysql_query("UPDATE guia_pagamento SET nossonumero='$nossonumero', chavecontroledoc='$chavecontroledoc' WHERE codigo='$codguia'");

// gera o boleto
Mensagem("Boleto gerado com sucesso");
imprimirGuia($codguia);


$cod_des = base64_encode($CodDes);
NovaJanela("../../../reports/des_prestadores_comprovante.php?CODI=$cod_des");

Redireciona("../../tomadores.php");

?>