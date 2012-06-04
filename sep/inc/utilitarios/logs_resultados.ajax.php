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
//recebimento de variaveis por get
$hidden = $_GET["hdCombo"];
$nome   = $_GET["txtNome"];
$data   = DataMysql($_GET["txtData"]);


//Muda o valor do tipo de acordo com o valor recebido
switch($hidden){
	case "C": $tipo = "contador";   break;
	case "E": $tipo = "empresa";    break;
	case "P": $tipo = "prefeitura"; break;
}//fim switch

//testa quais campos foram preenchidos e trata a variavel string
if(($nome != "") && ($data == "")){
	$string = "logs.usuario LIKE '$nome%' AND";
}elseif(($nome == "") && ($data != "")){
	$string = "SUBSTRING(logs.data,1,10) = '$data' AND";
}elseif(($nome != "") && ($data != "")){
	$string = "logs.usuario LIKE '$nome%' AND SUBSTRING(logs.data,1,10) = '$data' AND";
}//fim elseif

$query = ("SELECT usuarios.nome, logs.ip, logs.data, logs.acao FROM logs INNER JOIN usuarios ON logs.codusuario = usuarios.codigo WHERE ".$string." usuarios.tipo = '$tipo' ORDER BY logs.codigo DESC");

?>
<fieldset>
<legend>Resultado</legend>
<?php
$sql_logs = Paginacao($query,'frmLogs','divresultados',20);

$result = mysql_num_rows($sql_logs);
if($result>0){
?>
	<table width="100%">
		<tr bgcolor="#999999"> 
			<td width="180" align="center">Usuário</td>
			<td width="80" align="center">IP</td>
			<td width="140" align="center">Data e hora</td>
			<td align="center">Ação</td>   
		</tr>
		<?php
		while(list($user, $ip, $data, $acao) = mysql_fetch_array($sql_logs)){
			$datahora = explode(" ",$data);
			$data     = DataPt($datahora[0]);
			$hora     = $datahora[1];
		?>
		<tr bgcolor="#FFFFFF">
			<td align="center"><?php echo $user;?></td>
			<td align="center"><?php echo $ip;?></td>
			<td align="center"><?php echo $data." ".$hora;?></td>
			<td align="center"><?php echo $acao;?></td>
		</tr>
		<?php
		}//fim while
		?>
	</table>
	<?php
	}else{
	?>
	<table width="100%">
		<tr>
			<td><b>Não há nenhum log</b></td>
		</tr>
	</table>
	<?php
	}//fim else
	?>
	<table width="100%">
		<tr>
			<td><input type="submit" name="btImprimir" value="Imprimir" class="texto"  onclick="cancelaAction('frmLogs','inc/utilitarios/logs_imprimir.php','_blank');" /> </td>
		</tr>
	</table>
</fieldset>
