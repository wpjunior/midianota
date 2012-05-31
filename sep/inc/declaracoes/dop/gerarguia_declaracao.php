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
if($mes<10){$mes="0".$mes;}
$dataCompetencia = DataMysql("01/".$mes."/".$_POST['cmbAno']);
$dataGerado = DataMysql($_POST['hdDataAtual']);
$num_servicos = $_POST['hdServicos'];
$total = 0;
$codverificacao = gera_codverificacao();

$sql_busca_cod = mysql_query("SELECT codigo FROM cadastro WHERE cnpj = '$cnpj'");
list($cod_orgao) = mysql_fetch_array($sql_busca_cod);

for($c=1;$c<=$num_servicos;$c++){
	$CNPJPrestador[$c] = $_POST['txtCNPJPrestador'.$c];
	$baseCalculo[$c] = MoedaToDec($_POST['txtBaseCalculo'.$c]);
	$total = $total + $baseCalculo[$c];
	$impostoServico[$c] = $_POST['txtImposto'.$c];
	$temp = explode('|',$_POST['cmbCodServico'.$c]);
	$codigoServico[$c] = $temp[1];
	$nroNota[$c] = $_POST['txtNroDoc'.$c];
}

$multaJuros = MoedaToDec($_POST['txtMultaJuros']);
$totalPagar = MoedaToDec($_POST['txtTotalPagar']);

mysql_query("INSERT INTO dop_des 
			 SET codorgaopublico='$cod_orgao', 
				 competencia='$dataCompetencia', 
				 data_gerado='$dataGerado', 
				 total='$total',
				 iss='$totalPagar',
				 codverificacao='$codverificacao'"); 
$sql_des = mysql_query("SELECT MAX(codigo) 
				  				 FROM dop_des");
list($cod_des)=mysql_fetch_array($sql_des);

for($c=1;$c<=$num_servicos;$c++){
	if($baseCalculo[$c]!=""&&$codigoServico[$c]!=""){
		mysql_query("
			 INSERT INTO dop_des_notas
			 SET coddop_des='$cod_des',
			 	 codemissor='".$CNPJPrestador[$c]."',
				 codservico='".$codigoServico[$c]."',
				 valornota='".$baseCalculo[$c]."',
				 nota_nro='".$nroNota[$c]."'
		");
	}
}

/*$data_venc = DataVencimento();

mysql_query("INSERT INTO guia_pagamento
			 SET codrelacionamento = '$cod_des',
			 	 relacionamento= 'dop_des',
				 dataemissao = '$dataGerado',
				 valor = '$totalPagar',
				 valormulta = '$multaJuros',
				 datavencimento = '$data_venc',
				 pago = 'N'");

$sql_guia = mysql_query("SELECT MAX(codigo) 
			  			 FROM guia_pagamento;");

list($cod_guia)=mysql_fetch_array($sql_guia);


$nossonumero = gerar_nossonumero($cod_guia);
$chavecontroledoc = gerar_chavecontrole($cod_des,$cod_guia);

mysql_query("UPDATE guia_pagamento SET nossonumero ='$nossonumero', chavecontroledoc='$chavecontroledoc' WHERE codigo=$cod_guia");
*/
$cod_guia =base64_encode($cod_guia);
$cod_des = base64_encode($cod_des);

echo"<script>window.open('reports/dop_des_comprovante.php?COD=$cod_des');</script>"; 
/*echo"<script>window.open('../../boleto/$BOLETO_BANCO?COD=$cod_guia');</script>"; */
Mensagem("Notas(s) declarada(s)!");
?>

