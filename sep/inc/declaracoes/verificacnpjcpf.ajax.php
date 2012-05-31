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
$campo = $_GET['campo'];
// Valor do campo que fez requisição
$valor = $_GET['valor'];
$valido='Emissor não cadastrado';
include("../conect.php");
$sql=mysql_query("SELECT razaosocial FROM cadastro WHERE cnpj='$valor' OR cpf='$valor'");
if(mysql_num_rows($sql)){
	$valido=mysql_result($sql,0); //mysql_result pega um unico resultado da linha 0 do mysql
}
echo $valido; 
// Acentuação
header("Content-Type: text/html; charset=ISO-8859-1",true);
?>
