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
// Inclusão da biblioteca
require_once ("../../../../jpgraph/src/jpgraph.php");    
require_once ("../../../../jpgraph/src/jpgraph_bar.php"); 
// Conexão ao banco MySQL e consulta
$valores = unserialize($_GET['valor']);
$titulos = unserialize($_GET['titulo']);

/*$query1="SELECT tomador_nome, SUM(valortotal), SUM(basecalculo) FROM notas GROUP BY tomador_nome ORDER BY SUM(valortotal) DESC LIMIT 5";
$query2="SELECT SUBSTRING(datahoraemissao,1,7), COUNT(*) FROM notas GROUP BY SUBSTRING(datahoraemissao,1,7) ORDER BY SUBSTRING(datahoraemissao,1,10) ASC LIMIT 10";

$sql = mysql_query($query2);
$cont=0;
while(list($mes, $valor)=mysql_fetch_array($sql)){
	switch(substr($mes,5,2)){
		case "01": $mes="Janeiro ".substr($mes,0,4); break;
		case "02": $mes="Fevereiro ".substr($mes,0,4); break;
		case "03": $mes="Marco ".substr($mes,0,4); break;
		case "04": $mes="Abril ".substr($mes,0,4); break;
		case "05": $mes="Maio ".substr($mes,0,4); break;
		case "06": $mes="Junho ".substr($mes,0,4); break;
		case "07": $mes="Julho ".substr($mes,0,4); break;
		case "08": $mes="Agosto ".substr($mes,0,4); break;
		case "09": $mes="Setembro ".substr($mes,0,4); break;
		case "10": $mes="Outubro ".substr($mes,0,4); break;
		case "11": $mes="Novembro ".substr($mes,0,4); break;
		case "12": $mes="Dezembro ".substr($mes,0,4); break;
	}
	$meses[$cont]   = $mes;
	$valores[$cont] = $valor;
	$cont++;
}*/
       

// margem das partes principais do gráfico (dados), o que está
// fora da margem fica separado para as labels, títulos, etc
$grafico = new graph(800,250,"png");
$grafico->img->SetMargin(60,30,30,30);


$grafico->SetScale("textlin");

$grafico->title->Set('Relatórios de Empreiteiras');
// definir sub-titulo
$grafico->subtitle->Set('');

// pedir para mostrar os grides no fundo do gráfico,
// o ygrid é marcado como true por padrão
$grafico->ygrid->Show(true);
$grafico->xgrid->Show(true);

$gBarras = new BarPlot($valores);
$gBarras->SetFillColor("blue");
$gBarras->SetShadow("darkblue"); 


// título dos vértices
$grafico->yaxis->title->Set("");
$grafico->xaxis->title->Set("");
// título das barras
$grafico->xaxis->SetTickLabels($titulos);
$gBarras->value->Show(); 
$gBarras->value->SetFormat('R$ %0.2f');		
$gBarras->value->SetColor("black","navy"); //Cores


$grafico->Add($gBarras);
$grafico->Stroke();
?>