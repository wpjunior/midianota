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
include("../conect.php"); 
include("../../funcoes/util.php");
$tipo = $_GET["cmbTipo"];
$issretido = $_GET["cmbISSretido"];
?>
<select style="width: 60px" name="cmbValor" id="cmbValor" class="combo">
	<option value=""></option>
<?php
$sql = mysql_query("SELECT codigo, valor FROM nfe_creditos WHERE tipopessoa='$tipo' AND issretido='$issretido' ORDER BY valor ASC");
while(list($codigo,$valor) = mysql_fetch_array($sql)){
	echo "<option value=\"$valor\">$valor</option>";
}
?>
</select>