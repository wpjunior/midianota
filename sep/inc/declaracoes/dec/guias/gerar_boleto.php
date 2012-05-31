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
//recebe os dados
$totaliss = MoedaToDec($_POST['txtTotalIss']);

$codemissor=$_POST["txtEmissor"];
$multa=MoedaToDec($_POST["txtMultaJuros"]);
$total=MoedaToDec($_POST["txtTotalPagar"]);
$cont=$_POST["txtCont"];
$dataemissao    = date("Y-m-d");
$data           = explode("-",$dataemissao);
/*$datavencimento = mktime(24*5,0,0,$data[1],$data[2],$data[0]);
$datavencimento = date("Y-m-d",$datavencimento);*/
$datavencimento = UltDiaUtil($data[1],$data[0]);

// busca o codigo do banco e o arquivo q gera o boleto
$sql=mysql_query("SELECT bancos.boleto, 
				  boleto.tipo
				  FROM boleto
				  INNER JOIN bancos
				  ON bancos.codigo = boleto.codbanco");
list($boleto,$tipoboleto)=mysql_fetch_array($sql);

// inseri a guia de pagamento no db
mysql_query("
	INSERT INTO 
		guia_pagamento 
	SET 
		valor='$total', 
		valormulta='$multa', 
		dataemissao='$dataemissao',
		datavencimento='$datavencimento', 
		pago='N', 
		estado='N'
");

// busca o codigo da guia de pagamento recem inserida
$sql=mysql_query("SELECT MAX(codigo) FROM guia_pagamento");
list($codguia)=mysql_fetch_array($sql);


//Mensagem($cont);
// relaciona a guia de pagamento com as delcaracoes
for($i=0; $i<$cont; $i++){
	if($_POST["ckISS".$i]){
		//Mensagem($cont);
		$coddeclaracao=explode("|", $_POST["ckISS".$i]);
		
		mysql_query("INSERT INTO guias_declaracoes SET codguia='$codguia', codrelacionamento='$coddeclaracao[1]', relacionamento='cartorios_des'");
		mysql_query("UPDATE cartorios_des SET estado='B' WHERE codigo='$coddeclaracao[1]'");
	}
}

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

?>