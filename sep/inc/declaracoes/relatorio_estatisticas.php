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
//conecta ao banco e chama as funcoes

	
//recebimento de variaveis por get


$combo = $valor;
//testa o valor do combo

if($combo == "issretido"){
	$ctom = 0; //contador de tomadores;
	$totaldeclaracoes = 0;
	$declaracoes[]=0;
	$sql_nro_tomadores = mysql_query("SELECT codtomador,tomadores.nome 
									  FROM des_issretido
									  INNER JOIN tomadores ON des_issretido.codtomador = tomadores.codigo
									  GROUP BY codtomador");
	while(list($cod_tomador,$nome_tomador)=mysql_fetch_array($sql_nro_tomadores)) {
		$tomadores[$ctom]=$cod_tomador;
		$nometomadores[$ctom]=$nome_tomador;
		$sql_des_tomador = mysql_query("SELECT codigo FROM des_issretido WHERE codtomador='$cod_tomador'");
		while(list($cod_des_tomador)=mysql_fetch_array($sql_des_tomador)) {
			$sql_conta_notas = mysql_query("SELECT COUNT(codigo) FROM des_issretido_notas WHERE coddes_issretido='$cod_des_tomador'");
			list($nro_notas)=mysql_fetch_array($sql_conta_notas);
			$totalnotas = $totalnotas + $nro_notas;
			$totaldeclaracoes++;
			$declaracoes[$ctom]++;
			$notas[$ctom] += $nro_notas;
		}
		$ctom++;
	}
	$maior_declaracoes = $declaracoes[0];
	$tom_maior_declaracoes = $tomadores [0];
	$nome_maior_declaracoes = $nometomadores [0];
	$menor_declaracoes = $declaracoes[0];
	$tom_menor_declaracoes = $tomadores [0];
	$nome_menor_declaracoes = $nometomadores [0];
	for($x=0;$x<count($declaracoes);$x++){
		//testa se o valor da variavel maior e menor 
		if($maior_declaracoes<$declaracoes[$x]){
			$maior_declaracoes     = $declaracoes[$x];
			$tom_maior_declaracoes = $tomadores[$x];
			$nome_maior_declaracoes = $nometomadores[$x];
		}//fim if
		//testa se o valor da variavel menor e maior
		if($menor_declaracoes>$declaracoes[$x]){
			$menor_declaracoes     = $declaracoes[$x];
			$tom_menor_declaracoes = $tomadores[$x];
			$nome_menor_declaracoes = $nometomadores[$x];
		}//fim if
	}//fim for
	
	$maior_notas = $notas[0];
	$tom_maior_notas = $tomadores[0];
	$nome_maior_notas = $nometomadores[0];
	$menor_notas = $notas[0];
	$tom_menor_notas = $tomadores[0];
	$nome_menor_notas = $nometomadores[0];
	for($x=0;$x<count($notas);$x++){
		//testa se o valor da variavel maior e menor 
		if($maior_notas<$notas[$x]){
			$maior_notas     = $notas[$x];
			$tom_maior_notas = $tomadores[$x];
			$nome_maior_notas = $nometomadores[$x];
		}//fim if
		//testa se o valor da variavel menor e maior
		if($menor_notas>$notas[$x]){
			$menor_notas     = $notas[$x];
			$tom_menor_notas = $tomadores[$x];
			$nome_menor_notas = $nometomadores[$x];
		}//fim if
	}//fim for
	echo "Total de tomadores: ".count($tomadores)."<br>";
	echo "Total de notas: $totalnotas<br>";
	echo "Total de declarações: $totaldeclaracoes<br>";
	
	echo"<br>Media de notas por declaração: ".round($totalnotas/$totaldeclaracoes);
	echo"<br> Maior número de declarações: $maior_declaracoes por $nome_maior_declaracoes";
	echo"<br> Menor número de declarações: $menor_declaracoes por $nome_menor_declaracoes";
}
if($combo == "tomadores"){
	$ctom = 0; //contador de tomadores;
	$sql_nro_tomadores = mysql_query("SELECT cod_tomador,tomadores.nome 
									  FROM des_tomadores_notas
									  INNER JOIN tomadores ON des_tomadores_notas.cod_tomador = tomadores.codigo
									  GROUP BY cod_tomador");
	while(list($cod_tomador,$nome_tomador)=mysql_fetch_array($sql_nro_tomadores)) {
		$tomadores[$ctom]=$cod_tomador;
		$nometomadores[$ctom]=$nome_tomador;
		$sql_des_tomador = mysql_query("SELECT COUNT(codigo) FROM des_issretido WHERE codtomador='$cod_tomador'");
		list($nro_notas) = mysql_fetch_array($sql_des_tomador);
		$totalnotas   += $nro_notas;
		$notas[$ctom] += $nro_notas;
		$ctom++;
	}
	$maior_declaracoes = $declaracoes[0];
	$tom_maior_declaracoes = $tomadores [0];
	$nome_maior_declaracoes = $nometomadores [0];
	$menor_declaracoes = $declaracoes[0];
	$tom_menor_declaracoes = $tomadores [0];
	$nome_menor_declaracoes = $nometomadores [0];
	for($x=0;$x<count($declaracoes);$x++){
		//testa se o valor da variavel maior e menor 
		if($maior_declaracoes<$declaracoes[$x]){
			$maior_declaracoes     = $declaracoes[$x];
			$tom_maior_declaracoes = $tomadores[$x];
			$nome_maior_declaracoes = $nometomadores[$x];
		}//fim if
		//testa se o valor da variavel menor e maior
		if($menor_declaracoes>$declaracoes[$x]){
			$menor_declaracoes      = $declaracoes[$x];
			$tom_menor_declaracoes  = $tomadores[$x];
			$nome_menor_declaracoes = $nometomadores[$x];
		}//fim if
	}//fim for
	
	$maior_notas = $notas[0];
	$tom_maior_notas = $tomadores[0];
	$nome_maior_notas = $nometomadores[0];
	$menor_notas = $notas[0];
	$tom_menor_notas = $tomadores[0];
	$nome_menor_notas = $nometomadores[0];
	for($x=0;$x<count($notas);$x++){
		//testa se o valor da variavel maior e menor 
		if($maior_notas<$notas[$x]){
			$maior_notas     = $notas[$x];
			$tom_maior_notas = $tomadores[$x];
			$nome_maior_notas = $nometomadores[$x];
		}//fim if
		//testa se o valor da variavel menor e maior
		if($menor_notas>$notas[$x]){
			$menor_notas     = $notas[$x];
			$tom_menor_notas = $tomadores[$x];
			$nome_menor_notas = $nometomadores[$x];
		}//fim if
	}//fim for
	echo "Total de tomadores: ".count($tomadores)."<br>";
	echo "Total de notas: $totalnotas<br>";
	
	echo"<br> Maior número de notas: $maior_notas por $nome_maior_notas";
	echo"<br> Menor número de notas: $menor_notas por $nome_menor_notas";
}
if($combo == "emissores"){
	$c_emi = 0;//contador dos emissores
	$sql_nro_emissores = mysql_query("SELECT codemissor,emissores.razaosocial,emissores.cnpjcpf
									  FROM des
									  INNER JOIN emissores ON des.codemissor = emissores.codigo
									  GROUP BY codemissor");
	while(list($cod_emissor,$razao_emissor,$cnpjcpf_emissor)=mysql_fetch_array($sql_nro_emissores)) {
		$emissores[$c_emi]=$cod_emissor;
		$nomeemissores[$c_emi]=$razao_emissor;
		$cnpjemissores[$c_emi]=$cnpjcpf_emissor;
		$sql_des_emissor = mysql_query("SELECT codigo FROM des WHERE codemissor='$cod_emissor'");
		while(list($cod_des_emissor)=mysql_fetch_array($sql_des_emissor)) {
			$sql_conta_notas = mysql_query("SELECT COUNT(codigo) 
											FROM des_servicos WHERE coddes='$cod_des_emissor'");
			list($nro_notas)=mysql_fetch_array($sql_conta_notas);
			$totalnotas = $totalnotas + $nro_notas;
			$totaldeclaracoes++;
			$declaracoes[$c_emi]++;
			$notas[$c_emi] += $nro_notas;
		}
		$sql_declaracoes_temp = mysql_query("
			SELECT 
				COUNT(des_temp.codigo) 
			FROM 
				des_temp 
			INNER JOIN
				emissores_temp ON emissores_temp.codigo = des_temp.codemissores_temp
			WHERE 
				emissores_temp.cnpj='$cnpjcpf_emissor'
		");
		list($declaracoes_temp)=mysql_fetch_array($sql_declaracoes_temp);
		$declaracoes[$c_emi]+=$declaracoes_temp;
		$notas[$c_emi]+=$declaracoes_temp;		
		$totalnotas+=$declaracoes_temp;
		$totaldeclaracoes += $declaracoes_temp;
		$c_emi++;
	}
	$maior_declaracoes = $declaracoes[0];
	$emi_maior_declaracoes = $emissores[0];
	$nome_maior_declaracoes = $nomeemissores[0];
	$menor_declaracoes = $declaracoes[0];
	$emi_menor_declaracoes = $emissores[0];
	$nome_menor_declaracoes = $nometemissores[0];
	for($x=0;$x<count($declaracoes);$x++){
		//testa se o valor da variavel maior e menor 
		if($maior_declaracoes<$declaracoes[$x]){
			$maior_declaracoes     = $declaracoes[$x];
			$emi_maior_declaracoes = $emissores[$x];
			$nome_maior_declaracoes = $nomeemissores[$x];
		}//fim if
		//testa se o valor da variavel menor e maior
		if($menor_declaracoes>$declaracoes[$x]){
			$menor_declaracoes     = $declaracoes[$x];
			$emi_menor_declaracoes = $emissores[$x];
			$nome_menor_declaracoes = $nomeemissores[$x];
		}//fim if
	}//fim for
	
	$maior_notas = $notas[0];
	$emi_maior_notas = $emissores[0];
	$nome_maior_notas = $nomeemissores [0];
	$menor_notas = $notas[0];
	$emi_menor_notas = $tomadores [0];
	$nome_menor_notas = $nometomadores [0];
	for($x=0;$x<count($notas);$x++){
		//testa se o valor da variavel maior e menor 
		if($maior_notas<$notas[$x]){
			$maior_notas     = $notas[$x];
			$emi_maior_notas = $emissores[$x];
			$nome_maior_notas = $nomeemissores[$x];
		}//fim if
		//testa se o valor da variavel menor e maior
		if($menor_notas>$notas[$x]){
			$menor_notas     = $notas[$x];
			$emi_menor_notas = $emissores[$x];
			$nome_menor_notas = $nomeemissores[$x];
		}//fim if
	}//fim for
	$sql_emissores_temp = mysql_query("
		SELECT 
			emissores_temp.cnpj
		FROM 
			emissores_temp
		LEFT JOIN
			emissores on emissores.cnpjcpf = emissores_temp.cnpj
		WHERE 
			emissores.codigo is NULL
		GROUP BY 
			cnpj
	");
	$emissores_temp = mysql_num_rows($sql_emissores_temp);
	echo "Total de prestadores: ".(count($emissores)+$emissores_temp)."<br>";
	echo "Total de notas: $totalnotas<br>";
	echo "Total de declarações: $totaldeclaracoes<br>";
	
	echo"<br>Media de notas por declaração: ".round($totalnotas/$totaldeclaracoes);
	echo"<br> Maior número de declarações: $maior_declaracoes por $nome_maior_declaracoes";
	echo"<br> Menor número de declarações: $menor_declaracoes por $nome_menor_declaracoes";
}

?>
