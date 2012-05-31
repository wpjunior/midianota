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

/* Não gravar em cache */
$gmtDate = gmdate("D, d M Y H:i:s");
header("Expires: {$gmtDate} GMT");
header("Last-Modified: {$gmtDate} GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-Type: text/html; charset=iso-8859-1");

include("../conect.php");
include("../../funcoes/util.php");


// Valor do campo que fez requisição
$valor = $_GET['cmbDes'];
$DataEmissao = DataMysql($_GET['txtDataEmissao']);
$mesComp = $_GET['cmbMesComp'];
$anoComp = $_GET['cmbAnoComp'];
if($mesComp)$mesComp .= "-"; 
$Competencia = "$anoComp-$mesComp";
$CnpjCpf = $_GET['txtCnpjCpfEmissor'];
$Nome = $_GET['txtNomeEmissor'];
$pago = $_GET['rbPago'];
$estado = $_GET['rbEstado'];
$estado_des = array( "N" => "Normal", "B" => "Boleto", "C" => "Cancelada" , "E" => "Escriturada");

if($_GET['hdRelatorio']){
	echo "<div align=left>";
	include 'relatorio_estatisticas.php';
	echo "</div><br>";
}


if($valor =='tomadores'){
	
	$sql=mysql_query("
		SELECT 
			tomadores.nome,
			des_tomadores_notas.nota,
			DATE_FORMAT(des_tomadores_notas.dataemissao,'%d/%m/%Y'),
			emissores.nome,
			des_tomadores_notas.valor,
			des_tomadores_notas.credito
		FROM 
			des_tomadores_notas 
		INNER JOIN 
			tomadores ON tomadores.codigo = des_tomadores_notas.cod_tomador
		INNER JOIN 
			emissores ON emissores.codigo = des_tomadores_notas.cod_emissor
		WHERE 
			tomadores.nome LIKE '$Nome%' AND 
			tomadores.cnpjcpf LIKE '$CnpjCpf%' AND
			des_tomadores_notas.dataemissao LIKE '%$DataEmissao%'
		ORDER BY dataemissao DESC
    ");  
	if(mysql_num_rows($sql)>=1){
		echo"
		  <table width=\"100%\"  cellspacing=\"1\" cellpadding=\"1\" align=\"center\" border=\"0\" id=\"tblResultado\">
		 	<tr>
				<td width=150px bgcolor=\"#AAAAAA\" align=\"center\">Tomador</td>
				<td width=40px bgcolor=\"#AAAAAA\" align=\"center\">Nro Nota</td>
				<td width=80px bgcolor=\"#AAAAAA\" align=\"center\">Data Emissão</td>
				<td width=150px bgcolor=\"#AAAAAA\" align=\"center\">Emissor</td>
				<td width=60px bgcolor=\"#AAAAAA\" align=\"center\">Valor(R$)</td>
				<td bgcolor=\"#AAAAAA\" align=\"center\">Crédito(R$)</td>		
		    </tr>
		  </table>
		  <div id=\"detalhes\" style=\"width:578px; height:200px; overflow:auto\">
		  <table width=\"100%\"  cellspacing=\"1\" cellpadding=\"1\" align=\"center\" border=\"0\" id=\"tblResultado\">";
		while(list($tomador,$nota,$dataemissao,$emissor,$valor,$credito)=mysql_fetch_array($sql)){
			echo" <tr>
					<td width=150px bgcolor=\"#FFFFFF\" align=left>$tomador</td>
					<td width=40px bgcolor=\"#FFFFFF\" align=right>$nota</td>
					<td width=80px bgcolor=\"#FFFFFF\" align=center>$dataemissao</td>
					<td width=150px bgcolor=\"#FFFFFF\" align=left>$emissor</td>
					<td width=60px bgcolor=\"#FFFFFF\" align=right>".DecToMoeda($valor)."</td>
					<td bgcolor=\"#FFFFFF\" align=right>".DecToMoeda($credito)."</td>		
			    </tr>";
		}
		echo"</table></div>";
	}else{
		echo "<center><b>Nenhum resultado encontrado</b></center>";
	}
} 

elseif($valor == 'issretido'){	
	$sqlquery=("
		SELECT
			tomadores.nome,
			des_issretido.valor,
			des_issretido.multa,
			DATE_FORMAT(des_issretido.competencia,'%m/%Y'),
			DATE_FORMAT(des_issretido.data_gerado,'%d/%m/%Y'),
			des_issretido.estado,
			des_issretido.codigo
		FROM 
			des_issretido 
		INNER JOIN 
			cadastro as tomadores ON des_issretido.codcadastro = tomadores.codigo
		WHERE 
			tomadores.nome LIKE '$Nome%' AND 
			(tomadores.cnpj LIKE '$CnpjCpf%' OR
			tomadores.cpf LIKE '$CnpjCpf%') AND
			des_issretido.competencia LIKE '%$Competencia%'AND
			des_issretido.data_gerado LIKE '%$DataEmissao%' AND
			des_issretido.estado = '$estado'
		ORDER BY 
			competencia DESC
    ");
	$sql=mysql_query($sqlquery);
	//echo $sqlquery;
	//echo mysql_error();
	
	if (mysql_num_rows($sql)>=1){
		echo"
		  <table width=\"100%\"  cellspacing=\"1\" cellpadding=\"1\" align=\"center\" border=\"0\" id=\"tblResultado\">
		 	<tr>
				<td width=230px bgcolor=\"#AAAAAA\" align=\"center\">Tomador</td>	
				<td width=90px bgcolor=\"#AAAAAA\" align=\"center\">Competência</td>	
				<td width=80px bgcolor=\"#AAAAAA\" align=\"center\">Emissão</td>	
				<td width=80px bgcolor=\"#AAAAAA\" align=\"center\">Total (R$)</td>
				<td bgcolor=\"#AAAAAA\" align=\"center\">Valor (R$)</td>
		    </tr>
		  </table>
		  <div id=\"detalhes\" style=\"width:578px; height:200px; overflow:auto\">
		  <table width=\"100%\"  cellspacing=\"1\" cellpadding=\"1\" align=\"center\" border=\"0\" id=\"tblResultado\">
		    ";
			
		while(list($tomador,$valor,$multa,$competencia,$emissao,$est,$des_codigo)=mysql_fetch_array($sql)){
			$sql2 = mysql_query("SELECT SUM(valor_nota) FROM des_issretido_notas WHERE coddes_issretido = '$des_codigo'");
			list($total) = mysql_fetch_array($sql2);
			$guia_pago = $guia_pago=="S" ? "sim" : "não";
			echo"    
				<tr>
					<td width=230px bgcolor=\"#FFFFFF\">$tomador</td>
					<td width=90px bgcolor=\"#FFFFFF\" align=center>$competencia</td>
					<td width=80px bgcolor=\"#FFFFFF\" align=center>$emissao</td>
					<td width=80px bgcolor=\"#FFFFFF\" align=right>".DecToMoeda($total)."</td>
					<td bgcolor=\"#FFFFFF\" align=right>".DecToMoeda($valor)."</td>
			    </tr>";
		} 
		echo"</table></div>";
	}else{
		echo "<center><b>Nenhum resultado encontrado</b></center>";
	}
}

elseif($valor == 'emissores'){
	
	$sql_string=("
		SELECT 
			emissores.nome,
			des.competencia,
			DATE_FORMAT(des.data_gerado,'%d/%m/%Y'),
			des.total,
			des.iss,
			des.estado
		FROM 
			des 
		LEFT JOIN 
			cadastro as emissores ON des.codcadastro=emissores.codigo
		WHERE 
			emissores.nome LIKE '$Nome%' AND 
			(emissores.cnpj LIKE '$CnpjCpf%' OR
			emissores.cpf LIKE '$CnpjCpf%') AND
		  	des.competencia LIKE '%$Competencia%'AND
		  	des.data_gerado LIKE '%$DataEmissao%' AND
			des.estado = '$estado'
		ORDER BY data_gerado DESC
	");
	$sql = mysql_query($sql_string);
	//echo $sql_string;
	//echo mysql_error();
					  
	if(mysql_num_rows($sql)>=1)	{			  
	    echo"
		  <table width=\"100%\"  cellspacing=\"1\" cellpadding=\"1\" align=\"center\" border=\"0\" id=\"tblTituloResultado\">
		    <tr>
		    	<td width=200px bgcolor=\"#AAAAAA\" align=\"center\">Prestador</td>
				<td width=90px bgcolor=\"#AAAAAA\" align=\"center\">Competência</td>
				<td width=80px bgcolor=\"#AAAAAA\" align=\"center\">Emissão</td>
				<td width=90px bgcolor=\"#AAAAAA\" align=\"center\">Total R$</td>
				<td bgcolor=\"#AAAAAA\" align=\"center\">Valor R$</td>
		    </tr>
		  </table>
		  <div id=\"detalhes\" style=\"width:578px; height:200px; overflow:auto\">
		  <table width=\"100%\"  cellspacing=\"1\" cellpadding=\"1\" align=\"center\" border=\"0\" id=\"tblResultado\">
		    ";
								  
	    while(list($emissor,$competencia,$dataemissao,$total,$valor,$est)=mysql_fetch_array($sql)){
			$guia_pago = $guia_pago=="S" ? "sim" : "não";
			$comp = explode("-",$competencia);
			$competencia = $comp[1]."/".$comp[0];
	    	echo"
				<tr>
					<td width=200px bgcolor=\"#FFFFFF\" align=left>$emissor</td>
					<td width=90px bgcolor=\"#FFFFFF\" align=center>$competencia</td>
					<td width=80px bgcolor=\"#FFFFFF\" align=center>$dataemissao</td>
					<td width=90px bgcolor=\"#FFFFFF\" align=right>".DecToMoeda($total)."</td>	
					<td bgcolor=\"#FFFFFF\" align=right>".DecToMoeda($valor)."</td>	
				</tr>";	 	  
		}
		echo "</table></div>";
	}else{
		echo "<center><b>Nenhum resultado encontrado</b></center>";
	}
} 


if($_GET['hdRelatorio']){
?><br>
<input type="submit" class="botao" name="btImprimir" value="Imprimir" id="Imprimir" >
<?php }?>