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
//Conecta ao banco
include("../conect.php");
include("../../funcoes/util.php");

//Recebe as variaveis enviadas por post
$tipo      = $_POST["cmbTipo"];
$issretido = $_POST["cmbISSretido"];
$valor     = $_POST["cmbValor"];


?>
<body onLoad="window.resizeTo(500,600);">
<title>Imprimir</title>
<table width="800">
	<tr>
		<td>
			<table>
				<?php
					$sql = mysql_query("SELECT credito, tipopessoa, issretido, valor FROM nfe_creditos WHERE tipopessoa LIKE '$cmbTipo%' AND issretido LIKE '$issretido%' AND valor LIKE '$cmbValor%'");
					if(mysql_num_rows($sql)){
				?>
				<tr>
					<td align="center" width="20%">Crédito( % )</td>
					<td align="center" width="20%">Tipo</td>
					<td align="center" width="27%">ISS retido</td>
					<td align="center" width="33%">Valor</td>
				</tr>
				<tr>
					<td colspan="4"><hr size="1" color="#000000"></td>
				</tr>
				<?php
						while(list($credito,$tipopessoa,$issretido,$valor) = mysql_fetch_array($sql)){
							switch($issretido){
								case "S": $issretido = "Sim"; break;
								case "N": $issretido = "Não"; break;
							}
							switch($tipopessoa){
								case "PF": $tipopessoa = "Pessoa fisica";   break;
								case "PJ": $tipopessoa = "Pessoa juridica"; break;
							}
							$valor = DecToMoeda($valor);
				?>
				<tr>
					<td align="center"><?php echo $credito;?></td>
					<td align="center"><?php echo $tipopessoa;?></td>
					<td align="center"><?php echo $issretido;?></td>
					<td align="center"><?php echo $valor;?></td>
				</tr>
				<?php
						}//fim while
					}else{
				?>
				<tr>
					<td align="center" colspan="4"><b>Nenhuma regra de credito encontrada!</b></td>
				</tr>
				<?php
				}//fim else
				?>
			</table>
		</td>
	</tr>
</table>
</body>