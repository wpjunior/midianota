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
//Utiliza a função para obter o codigo de verificação
$codverificacao = gera_codverificacao();

$cod_emissor = $_POST['hdCodEmissor'];
$dataCompetencia = DataMysql("01/".$_POST['cmbMes']."/".$_POST['cmbAno']);
$dataGerado = DataMysql($_POST['hdDataAtual']);
$num_servicos = $_POST['hdServicos'];
$total = 0;
$valor_iss_retido_soma = 0;

for($c=1;$c<=$num_servicos;$c++){
	$baseCalculo[$c] = MoedaToDec($_POST['txtBaseCalculo'.$c]);
	$total = $total + $baseCalculo[$c];
	$impostoServico[$c] = $_POST['txtImposto'.$c];
	$valor_iss_retido[$c] = MoedaToDec($_POST['txtIssRetido'.$c]);
	
	//soma o total de iss retido
	$valor_iss_retido_soma += MoedaToDec($_POST['txtIssRetido'.$c]);
	
	$temp = explode('|',$_POST['cmbCodServico'.$c]);
	$codigoServico[$c] = $temp[1];
}

$multaJuros = MoedaToDec($_POST['txtMultaJuros']);
$totalPagar = MoedaToDec($_POST['txtImpostoTotal']);

mysql_query("
	INSERT INTO des SET 
		codcadastro		='$cod_emissor', 
		competencia		='$dataCompetencia', 
		data_gerado		='$dataGerado', 
		total			='$total',
		iss_retido		='$valor_iss_retido_soma',
		iss				='$totalPagar', 
		tomador			='n',
		codverificacao	='$codverificacao'
") or die(mysql_error());
$sql_des = mysql_query("SELECT MAX(codigo) FROM des");
list($cod_des)=mysql_fetch_array($sql_des);

for($c=1;$c<=$num_servicos;$c++){
	if($baseCalculo[$c]!=""&&$codigoServico[$c]!=""){
		mysql_query("
			INSERT INTO des_servicos SET 
				coddes			='{$cod_des}',
				codservico		='{$codigoServico[$c]}',
				basedecalculo	='{$baseCalculo[$c]}',
				iss_retido		='{$valor_iss_retido[$c]}',
				iss				='{$impostoServico[$c]}'
		") or die(mysql_error());
	}
}

/*$dias_prazo = 5;
$data_venc = date("Y-m-d", time() + ($dias_prazo * 86400));

mysql_query("INSERT INTO guia_pagamento
			 SET codrelacionamento = '$cod_des',
				 relacionamento= 'des',
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

Mensagem("Declaração efetuada com sucesso!");
echo"<script>window.open('reports/des_prestadores_comprovante.php?COD=$cod_des');</script>"; 
/*		echo"<script>window.open('../../boleto/boleto_bb.php?COD=$cod_guia');</script>"; */
//Redireciona("../../boleto/boleto_bb.php?COD=$cod_guia");
?>

