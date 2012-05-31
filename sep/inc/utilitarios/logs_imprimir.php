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
require_once("../conect.php");
require_once("../../funcoes/util.php"); 
/*if(isset($_POST['btImprimir'])){
	include("../../../../sepiss/inc/utilitarios/logs_imprimir.php");
}*/

if(isset($_POST)){
$data  = DataMysql($_POST["txtData"]);
}

if(isset($_POST)){
 $hidden = $_POST["hdCombo"];
}

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

$query = mysql_query("SELECT usuarios.nome, logs.ip, logs.data , logs.acao FROM logs INNER JOIN usuarios ON logs.codusuario = usuarios.codigo WHERE ".$string." usuarios.tipo ='$tipo' ORDER BY logs.codigo DESC");

?>

<?php
$sql_logs = mysql_fetch_row($query);

$result = mysql_num_rows($query);
if($result>0){
?><head>
<link href="../../css/imprimir_aidf.css" rel="stylesheet" type="text/css">
</head>


<div id="div">
	<input name="btImprimir" id="btImprimir" type="button" value="Imprimir" onClick="document.getElementById('div').style.display='none';print()" />
</div>
<table width="890" border="0" align="center" cellpadding="0" cellspacing="5">
	<tr>
		<td align="center">
	</tr>
	<tr>
		<td align="center">
			<table width="885" border="0" cellpadding="4" cellspacing="2" style="border:dotted thin">
				<tr>
					<td height="25" colspan="5" align="center" valign="middle" bgcolor="#CCCCCC" class="tblTitulo">REGISTRO DE A&Ccedil;&Otilde;ES</td>
				</tr>
				<tr bgcolor="#999999"> 
					<td width="156" align="center">Usuário</td>
					<td width="130" align="center">IP</td>
					<td width="155" align="center">Data e Hora</td>
					<td align="center">Ação</td>   
				</tr>
					<?php
					while(list($usuario, $ip,$data, $acao) = mysql_fetch_array($query)){
								$datahora = explode(" ",$data);
								$data     = DataPt($datahora[0]);
								$hora     = $datahora[1];
					   			
					?>
				<tr>
					<td width="156" align="center"><span class="tblCampo"><?php echo $usuario; ?> </span></td>
					<td width="130" align="center"><span class="tblCampo"><?php echo $ip; ?> </span></td>
					<td width="155" align="center"><span class="tblCampo"><?php echo $data." ".$hora; ?> </span></td>
					<td width="398" align="center"><span class="tblCampo"><?php echo $acao; ?> </span></td>
				</tr>
				<?php
				}// fim do while
				?>
		  </table>
	  </table>
			<?php 
			}
			?>	
	</table>

