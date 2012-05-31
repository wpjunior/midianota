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

include("../../inc/conect.php");
include("../../funcoes/util.php");
// variaveis vindas do conect.php
// $CODPREF,$PREFEITURA,$USUARIO,$SENHA,$BANCO,$TOPO,$FUNDO,$SECRETARIA,$LEI,$DECRETO,$CREDITO,$UF


?>


  <?php  //comando sql que mostrará as categorias e a quantidade de cada um (Lista Estatística)

$sql_categ = mysql_query("SELECT
						  servicos.codcategoria, servicos_categorias.nome, COUNT(servicos_categorias.nome)
						 FROM
						  servicos_categorias 
						 INNER JOIN
						  servicos
						 ON servicos.codcategoria = servicos_categorias.codigo
						 GROUP BY servicos.codcategoria"); 
$cont=0;
while(list($nome,$qtd) = mysql_fetch_array($sql_categ)){

echo"$nome: ]  $qtd";
								
	$cont=$cont+$qtd;							}

?>
