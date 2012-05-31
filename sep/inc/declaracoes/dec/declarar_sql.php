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

$cnpj            = $_POST['txtCNPJ'];
$dataCompetencia = DataMysql("01/".$_POST['cmbMes']."/".$_POST['cmbAno']);
$dataGerado      = DataMysql($_POST['hdDataAtual']);
$num_servicos    = $_POST['hdServicos'];
$total           = 0;
$codverificacao  = gera_codverificacao();
$cnpjdec         = $_POST['hdCnpjDec'];
$iss_emo         = MoedaToDec($_POST['txtImpostoTotal']);

$sql_busca_cod = mysql_query("SELECT codigo FROM cadastro WHERE cnpj = '$cnpj'");
list($codigo) = mysql_fetch_array($sql_busca_cod);

for($c=1;$c<=$num_servicos;$c++){
	$baseCalculo[$c]    = MoedaToDec($_POST['txtBaseCalculo'.$c]);
	$total              = $total + $baseCalculo[$c];
	$emo[$c]            = MoedaToDec($_POST['txtEmo'.$c]);
	$impostoServico[$c] = MoedaToDec($_POST['txtImposto'.$c]);
	$temp               = explode('|',$_POST['cmbCodCart'.$c]);
	$codigoServico[$c]  = $temp[1];
	$nroNota[$c]        = $_POST['txtNroDoc'.$c];
}

$multaJuros = MoedaToDec($_POST['txtMultaJuros']);
$totalPagar = MoedaToDec($_POST['txtTotalPagar']);

mysql_query("
	INSERT INTO cartorios_des 
	SET codcartorio='$codigo', 
		competencia='$dataCompetencia', 
		data_gerado='$dataGerado', 
		total='$total',
		iss_emo='$iss_emo',
		codverificacao='$codverificacao'
");
$sql_des = mysql_query("SELECT MAX(codigo) FROM cartorios_des WHERE codcartorio = '$codigo'");
list($cod_des) = mysql_fetch_array($sql_des);

for($c=1;$c<=$num_servicos;$c++){
	if($baseCalculo[$c]!=""&&$codigoServico[$c]!=""){
		mysql_query("
			 INSERT INTO cartorios_des_notas
			 SET coddec_des='$cod_des',
				 emolumento='".$emo[$c]."',
				 codservico='".$codigoServico[$c]."',
				 valornota='".$baseCalculo[$c]."',
				 iss='".$impostoServico[$c]."',
				 nota_nro='".$nroNota[$c]."'
		");
	}
}

$cod_des = base64_encode($cod_des);

echo"<script>window.open('reports/dec_des_comprovante.php?COD=$cod_des');</script>"; 
Mensagem("Notas(s) declarada(s)!");
?>