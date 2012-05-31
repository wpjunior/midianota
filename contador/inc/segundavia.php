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
require_once("../../include/conect.php");
require_once("../../funcoes/util.php"); 
	

$cod_guia = $_GET['hdCodGuia'];
//$cod_guia = base64_encode($cod_guia);
//$cod_des_temp = base64_encode($cod_des_temp);

// busca o codigo do banco e o arquivo q gera o boleto
$sql = mysql_query("SELECT bancos.boleto, boleto.tipo FROM boleto INNER JOIN bancos ON bancos.codigo = boleto.codbanco");
list($boleto,$tipoboleto) = mysql_fetch_array($sql);
if($tipoboleto == "R"){
	$tipoboleto = "recebimento";
	$boleto     = "index.php";
}else{
	$tipoboleto = "pagamento";
}



imprimirGuia($cod_guia,true,true);
?>

