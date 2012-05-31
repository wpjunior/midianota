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
require_once("../../conect.php");
require_once("../../../funcoes/util.php");
require_once("../../nocache.php");
//recebe as variaveis vindas por get
$nomePOST = $_GET['txtNome'];
$cnpjPOST = $_GET['txtCNPJ'];
$estadoPOST = $_GET['cmbEstado'];
$municipioPOST = $_GET['txtCidade'];
$ufPOST = $_GET['txtUF'];

//faz um where de acordo com oque foi preenchido no from
//cria uma array com os filtros existentes e implode usando AND

$WHERE="";
if($nomePOST){
	$WHERE[]="operadoras_creditos.nome LIKE '%$nome%' OR operadoras_creditos.razaosocial LIKE '%$nome%'";
}
if($cnpjPOST){
	$WHERE[]="operadoras_creditos.cnpj='$cnpjPOST'";
}//fim if cnpj
if($estadoPOST){
	$WHERE[]="operadoras_creditos.estado='$estadoPOST'";
}//fim if estado
if($municipioPOST){
	$WHERE[]="operadoras_creditos.municipio LIKE '$municipioPOST%'";//like porque pode ser tanto maisculo quanto minusculo
}//fim if estado
if($ufPOST){
	$WHERE[]="operadoras_creditos.uf LIKE '$ufPOST'";//like porque pode ser tanto maisculo quanto minusculo
}//fim if estado
if($WHERE){
	$WHERE="WHERE ".implode(" AND ",$WHERE);//implode nos filtros usados com AND
}//fim se existe WHERE



$query = ("
		SELECT 
			codigo,
			nome, 
			razaosocial, 
			cnpj, 
			municipio, 
			uf, 
			estado
		FROM 
			operadoras_creditos 
		$WHERE
		ORDER BY 
			nome
		");

?>
<fieldset>
<legend>Resultado</legend>
<?php
$sql=Paginacao($query,'frmRelatorio','divBuscar',10);//paginacao substitui o mysql query, pois volta o resultado limitado por pagina e com os botoes de paginacao
if(mysql_num_rows($sql)>0){
?>
<div align="left"><input type="submit" name="btImprimir" value="Imprimir" class="botao" onclick="cancelaAction('frmRelatorio','inc/operadoras_creditos/relatorios/imprimir_relatorios_operadoras_creditos.php','_blank')" /></div>
<table width="100%">
	<tr bgcolor="#999999">
		<td align="center" width="240">Nome</td>
		<td align="center" width="130">CNPJ</td>
		<td align="center" width="130">Município</td>
		<td align="center" width="30">UF</td>
		<td align="center">Situação</td>	
	</tr>
	<?php
	while(list($codigo,$nome,$razaosocial,$cnpj,$municipio,$uf,$estado) = mysql_fetch_array($sql)){										
		switch($estado){
			case "NL": $estado = "Não Liberado"; break;
			case "A" : $estado = "Ativo";   break;
			case "I" : $estado = "Inativo";    break;
		}//fim switch estado
	?>
	<tr bgcolor="#FFFFFF">
		<td align="center" width="240"><?php echo $nome;?></td>
		<td align="center" width="130"><?php echo $cnpj;?></td>
		<td align="center" width="130"><?php echo $municipio;?></td>
		<td align="center" width="30"><?php echo $uf;?></td>
		<td align="center"><?php echo $estado;?></td>
	</tr>
	<?php
	}//fim while
	?>
</table>
<?php

}else{
	echo "<center><b>Nenhum resultado encontrado</b></center>";
}//fim else se nao tem resultado

?>
</fieldset>