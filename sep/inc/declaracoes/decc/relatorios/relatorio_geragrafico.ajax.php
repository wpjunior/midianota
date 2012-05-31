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
	//Inclui os principais arquivos
	require_once("../../conect.php");
	require_once("../../../funcoes/util.php");
	require_once("../../nocache.php");
	
	//Recebe as variaveis enviadas pelo form por get
	if(isset($_GET)){
		$nome    = $_GET['txtNome'];
		$cnpj    = $_GET['txtCNPJ'];
		$compmes = $_GET['cmbMes'];
		$compano = $_GET['cmbAno'];
		$data    = $_GET['txtData'];
		$estado  = $_GET['cmbEstado'];
		$numero  = $_GET['txtNroDecc'];
	}
	
	//verifica quais campos foram preenchidos e concatena na variavel str_where
	if($compmes){
		$str_where = " AND MONTH(decc_des.competencia) = '$compmes'";
	}
	if($compano){
		$str_where .= " AND YEAR(decc_des.competencia) = '$compano'";
	}
	if($data){
		$data = DataMysql($data);
		$str_where .= " AND decc_des.data = '$data'";
	}
	if($cnpj){
		$str_where .= " AND empreiteiras.cnpj = '$cnpj'";
	}
	if($estado){
		$str_where .= " AND decc_des.estado = '$estado'";
	}else{
		$str_where .= " AND decc_des.estado != 'C'";
	}
	if($numero){
		$str_where .= " AND decc_des.codigo = '$numero'";
	}
	
	//Gera a pesquisa conforme os dados enviados pelo usuario utilizando as variaveis string
	$sql_pesquisa = mysql_query("
						SELECT 
							DATE_FORMAT(decc_des.competencia,'%m/%Y'),
							SUM(decc_des.total)
						FROM 
							decc_des
						INNER JOIN
							empreiteiras ON decc_des.codempreiteira = empreiteiras.codigo
						WHERE 
							(empreiteiras.nome LIKE '$nome%' AND empreiteiras.razaosocial LIKE '$nome%') $str_where
						GROUP BY 
							DATE_FORMAT(decc_des.competencia,'%m/%Y')
						ORDER BY 
							decc_des.codigo
						DESC
						");
	$cont = 0;
	while(list($data,$total) = mysql_fetch_array($sql_pesquisa)){
		$arraytotal[$cont] = $total; 
		$arraydata[$cont]  = $data;
		$cont++;
	}
	
	//Aqui transforma os arrays em uma string para enviar para o arquivo que tem o grafico
	$valores = serialize($arraytotal);
	$titulos = serialize($arraydata);
?>
<link href="css/padrao.css" rel="stylesheet" type="text/css">
<fieldset><legend>Gráfico</legend>
<table width="100%">
	<tr>
    	<td><input name="btImprimir" type="button" class="botao" value="Imprimir"></td>
    </tr>
	<tr>
		<td><img src='inc/empreiteiras/relatorios/grafico.php?titulo=<?php echo $titulos;?>&valor=<?php echo $valores;?>' /></td>
	</tr>
</table>
</fieldset>
