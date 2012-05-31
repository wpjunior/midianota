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
<html>
<head>
<?php 
include("../inc/conect.php");
include("../funcoes/util.php");
include("../funcoes/funcao_logs.php");
$valor = $_POST['cmbDes'];
if($valor == 'tomadores') {
	$Des = "Tomadores";
}
if($valor == 'issretido') {
	$Des = "ISS Retido";
}
if($valor == 'emissores') {
	$Des = "Emissores";
}
echo "<title>SEP - Relatório $Des</title>";
?>
</head>
<body style="margin-left: 5%;" >

<form name="formDes" id="formDes">
<input type="button" name="btImprimir" id="btImprimir" value="Imprimir" onClick="print();" >
<input type="hidden" name="hdRelatorio" id="hdRelatorio" value="true">
<input type="hidden" name="cmbDes" id="cmbDes" value="tomadores">
<?php 


$DataEmissao = DataMysql($_POST['txtDataEmissao']);
$mesComp = $_POST['cmbMesComp'];
$anoComp = $_POST['cmbAnoComp'];
$mesComp = $mesComp=="" ? "" : "$mesComp-";
$Competencia = "$anoComp-$mesComp";
$CnpjCpf = $_POST['txtCnpjCpfEmissor'];
$Nome = $_POST['txtNomeEmissor'];
$pago = $_POST['rbPago'];


echo "<div align=left>";
//include 'relatorio_estatisticas.php';
echo "</div><br>";
?>
<div id="divResultado" style="width:800px">
<?php 

echo"<center><h1>Relatório $Des $anoComp</h1></center>";


if($valor =='tomadores'){
	$campo = tipoPessoa($CnpjCpf);
	$string = "";
	if($CnpjCpf){
		$string = "cadastro.$campo LIKE '$CnpjCpf%'";
	}
	
	$sql=mysql_query("SELECT tomadores.nome,
 						  des_tomadores_notas.nota,
 						  DATE_FORMAT(des_tomadores_notas.dataemissao,'%d/%m/%Y'),
				   		  emissores.nome,
				   		  des_tomadores_notas.valor,
				   		  des_tomadores_notas.credito
 				   FROM des_tomadores_notas 
 				   INNER JOIN tomadores ON tomadores.codigo = des_tomadores_notas.cod_tomador
				   INNER JOIN emissores ON emissores.codigo = des_tomadores_notas.cod_emissor
                   WHERE cadastro.nome LIKE '$Nome%' AND
                      	 des_tomadores_notas.dataemissao LIKE '%$DataEmissao%'
                   ORDER BY dataemissao DESC");  
	if(mysql_num_rows($sql)>=1){
		echo"
		  <table width=\"100%\"  cellspacing=\"1\" cellpadding=\"1\" align=\"center\" border=\"0\" id=\"tblResultado\">
		 	<tr>
				<td bgcolor=\"#AAAAAA\" align=\"center\">Tomador</td>
				<td bgcolor=\"#AAAAAA\" align=\"center\">Nro Nota</td>
				<td bgcolor=\"#AAAAAA\" align=\"center\">Data Emissão</td>
				<td bgcolor=\"#AAAAAA\" align=\"center\">Emissor</td>
				<td bgcolor=\"#AAAAAA\" align=\"center\">Valor(R$)</td>
				<td bgcolor=\"#AAAAAA\" align=\"center\">Crédito(R$)</td>		
		    </tr>";
		while(list($tomador,$nota,$dataemissao,$emissor,$valor,$credito)=mysql_fetch_array($sql)){
			$sql_busca_tomador = mysql_query("SELECT nome FROM cadastro WHERE codigo = '$codtomador'");
			
			$bgcor = $contcor%2==0? "#FFFFFF" : "#DDDDDD";
			echo" <tr>
					<td bgcolor=\"$bgcor\" align=left>$tomador</td>
					<td bgcolor=\"$bgcor\" align=left>$nota</td>
					<td bgcolor=\"$bgcor\" align=center>$dataemissao</td>
					<td bgcolor=\"$bgcor\" align=left>$emissor</td>
					<td bgcolor=\"$bgcor\" align=right>".DecToMoeda($valor)."</td>
					<td bgcolor=\"$bgcor\" align=right>".DecToMoeda($credito)."</td>		
			    </tr>";
			$contcor++;
		}
		echo"</table>";
	}else{
		echo "<center><b>Nenhum resultado encontrado</b></center>";
	}
} 

elseif($valor == 'issretido'){	

	$sql=mysql_query("SELECT tomadores.nome,
  							 des_issretido.valor,
  						     des_issretido.multa,
  						     DATE_FORMAT(des_issretido.competencia,'%m/%Y'),
  						     DATE_FORMAT(guia_pagamento.dataemissao,'%d/%m/%Y'),
  						     guia_pagamento.pago,
  						     des_issretido.codigo
  					  FROM des_issretido 
                      INNER JOIN tomadores ON des_issretido.codtomador = tomadores.codigo
                      INNER JOIN guia_pagamento ON des_issretido.codigo = guia_pagamento.codrelacionamento
                      WHERE guia_pagamento.relacionamento = 'des_issretido' AND
                      		tomadores.nome LIKE '$Nome%' AND 
                      		tomadores.cnpjcpf LIKE '$CnpjCpf%' AND
                      		des_issretido.competencia LIKE '%$Competencia%'AND
                      		guia_pagamento.dataemissao LIKE '%$DataEmissao%' AND
                      		guia_pagamento.pago = '$pago' AND
                      		guia_pagamento.relacionamento = 'des_issretido'
                      ORDER BY competencia DESC");

	if (mysql_num_rows($sql)>=1){
		echo"
		  <table width=\"100%\"  cellspacing=\"1\" cellpadding=\"1\" align=\"center\" border=\"0\" id=\"tblResultado\">
		 	<tr>
				<td width=32% bgcolor=\"#AAAAAA\" align=\"center\">Tomador</td>	
				<td width=15% bgcolor=\"#AAAAAA\" align=\"center\">Competência</td>	
				<td width=15% bgcolor=\"#AAAAAA\" align=\"center\">Emissão</td>	
				<td width=15% bgcolor=\"#AAAAAA\" align=\"center\">Total (R$)</td>
				<td width=13% bgcolor=\"#AAAAAA\" align=\"center\">Valor (R$)</td>	
				<td bgcolor=\"#AAAAAA\" align=\"center\">Pago</td>
		    </tr>
		    ";
			
		while(list($tomador,$valor,$multa,$competencia,$emissao,$guia_pago,$des_codigo)=mysql_fetch_array($sql)){
			$sql2 = mysql_query("SELECT SUM(valor_nota) FROM des_issretido_notas WHERE coddes_issretido = '$des_codigo'");
			list($total) = mysql_fetch_array($sql2);
			$guia_pago = $guia_pago=="S" ? "sim" : "não";
			$bgcor = $contcor%2==0? "#FFFFFF" : "#DDDDDD";
			echo"    
				<tr>
					<td width=32% bgcolor=\"$bgcor\">$tomador</td>
					<td width=15% bgcolor=\"$bgcor\" align=center>$competencia</td>
					<td width=15% bgcolor=\"$bgcor\" align=center>$emissao</td>
					<td width=15% bgcolor=\"$bgcor\" align=right>".DecToMoeda($total)."</td>
					<td width=13% bgcolor=\"$bgcor\" align=right>".DecToMoeda($valor)."</td>		
					<td bgcolor=\"$bgcor\" align=center>$guia_pago</td>
			    </tr>";
			$contcor++;
		}
		echo"</table>";
	}else{
		echo "<center><b>Nenhum resultado encontrado</b></center>";
	}
}

elseif($valor == 'emissores'){
	
	$sql=mysql_query("
		(
			SELECT 
				emissores_temp.razaosocial,
				des_temp.competencia,
				DATE_FORMAT(guia_pagamento.dataemissao,'%d/%m/%Y'),
				des_temp.base,
				guia_pagamento.valor,
				guia_pagamento.pago
			FROM 
				des_temp
			INNER JOIN
				emissores_temp ON emissores_temp.codigo = des_temp.codemissores_temp
			INNER JOIN 
				guia_pagamento ON des_temp.codigo = guia_pagamento.codrelacionamento
			WHERE 
				des_temp.razaosocial LIKE '$Nome%' AND 
			   	des_temp.competencia LIKE '%$Competencia%'AND
			   	guia_pagamento.dataemissao LIKE '%$DataEmissao%' AND
				guia_pagamento.pago = '$pago' AND
				guia_pagamento.relacionamento = 'des_temp'
		) UNION (
			SELECT 
				emissores.nome,
				des.competencia,
				DATE_FORMAT(guia_pagamento.dataemissao,'%d/%m/%Y'),
				des.total,
				guia_pagamento.valor,
				guia_pagamento.pago
			FROM 
				des 
			INNER JOIN 
				emissores ON des.codemissor=emissores.codigo
			INNER JOIN 
				guia_pagamento ON des.codigo = guia_pagamento.codrelacionamento
			WHERE 
				emissores.nome LIKE '$Nome%' AND 
			   	des.competencia LIKE '%$Competencia%'AND
			   	guia_pagamento.dataemissao LIKE '%$DataEmissao%' AND
				guia_pagamento.pago = '$pago' AND
				guia_pagamento.relacionamento = 'des'
		)
		ORDER BY competencia DESC"
	);
					  
	if(mysql_num_rows($sql)>=1)	{			  
	    echo"
		  <table width=\"100%\"  cellspacing=\"1\" cellpadding=\"1\" align=\"center\" border=\"0\" id=\"tblTituloResultado\">
		    <tr>
				<td width=32% bgcolor=\"#AAAAAA\" align=\"center\">Prestador</td>
				<td width=15% bgcolor=\"#AAAAAA\" align=\"center\">Competência</td>
				<td width=15% bgcolor=\"#AAAAAA\" align=\"center\">Emissão</td>
				<td width=15% bgcolor=\"#AAAAAA\" align=\"center\">Total R$</td>
				<td width=13% bgcolor=\"#AAAAAA\" align=\"center\">Valor R$</td>
				<td bgcolor=\"#AAAAAA\" align=\"center\">Pago</td>		
		    </tr>
		    ";
								  
	    while(list($emissor,$competencia,$dataemissao,$total,$valor,$guia_pago)=mysql_fetch_array($sql)){
			$guia_pago = $guia_pago=="S" ? "sim" : "não";
			$comp = explode("-",$competencia);
			$competencia = $comp[1]."/".$comp[0];
			
			$bgcor = $contcor%2==0? "#FFFFFF" : "#DDDDDD";
	    	
			echo"
				<tr>
					<td width=180px bgcolor=\"$bgcor\" align=left>$emissor</td>
					<td width=90px bgcolor=\"$bgcor\" align=center>$competencia</td>
					<td width=80px bgcolor=\"$bgcor\" align=center>$dataemissao</td>
					<td width=80px bgcolor=\"$bgcor\" align=right>".DecToMoeda($total)."</td>	
					<td width=70px bgcolor=\"$bgcor\" align=right>".DecToMoeda($valor)."</td>	
					<td bgcolor=\"$bgcor\" align=center>$guia_pago</td>	
				</tr>";	 
	    	$contcor++;	  
		}
		echo "</table>";
	}else{
		echo "<center><b>Nenhum resultado encontrado.</b></center>";
	}
} ?>

</div>
</form>


</body>
</html>