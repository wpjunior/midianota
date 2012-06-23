<?php 

include("../../inc/conect.php");
include("../../funcoes/util.php");
// variaveis vindas do conect.php
// $CODPREF,$PREFEITURA,$USUARIO,$SENHA,$BANCO,$TOPO,$FUNDO,$SECRETARIA,$LEI,$DECRETO,$CREDITO,$UF

$sql_brasao = mysql_query("SELECT brasao FROM configuracoes");
//preenche a variavel com os valores vindos do banco
list($BRASAO) = mysql_fetch_array($sql_brasao);


?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<title>Listagem por Categoria</title>

<style type="text/css">

.tabela {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	border-collapse:collapse;
	border: 1px solid #000000;
}
</style>


<div id="DivImprimir">
<input type="button" onClick="print();this.style.display = 'none';" value="Imprimir" /></div>
<center>

<table width="700px" height="120" border="2" cellspacing="0" class="tabela">
  <tr>
    <td width="106"><center><img src="../../img/brasoes/<?php print $BRASAO; ?>" width="96" height="105"   />
    </center></td>
    <td width="584" height="33" colspan="2"><span class="style1">
      <center>
             <p>LISTA ESTATÍSTICA DE SERVIÇOS POR CATEGORIA</p>
             <p>PREFEITURA MUNICIPAL DE <?php print strtoupper($CONF_CIDADE); ?> </p>
        <p><?php print strtoupper($CONF_SECRETARIA); ?> </p>
      </center>
    
    
    </span></td>
  </tr>
  </table>
  <table width="700px" height="120" border="2" cellspacing="0" class="tabela">
  <?php  //comando sql que mostrará as categorias e a quantidade de cada um (Lista Estatística)

echo "<tr bgcolor=\"grey\"><td align=\"center\">Nome da Categoria</td><td align=\"center\">Quantidade</td></tr>";
$sql_categ = mysql_query("SELECT
						  servicos.codcategoria, servicos_categorias.nome, COUNT(servicos_categorias.nome)
						 FROM
						  servicos_categorias 
						 INNER JOIN
						  servicos
						 ON servicos.codcategoria = servicos_categorias.codigo
						 GROUP BY servicos_categorias.nome");
						 $cont=0;
							
							while(list($cod,$nome,$qtd)=mysql_fetch_array($sql_categ)){
								echo"<tr><td align=\"center\">$nome</td><td align=\"center\">$qtd</td></tr>";
								$cont++;
								}				

?>

  </table>
