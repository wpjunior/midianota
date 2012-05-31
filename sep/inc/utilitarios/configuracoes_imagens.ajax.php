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
include("../conect.php");
//recebimento por get da variavel do combo
$combo = $_GET["cmbImagem"];
//testa o valor de combo
if($combo){
	//verifica qual valor que veio e muda o campo da tabela configuracoes e o diretorio de onde esta a imagem
	switch($combo){
		case "B": 
			$campo     = "brasao_nfe";
			$diretorio = "brasoes"; 
		 break;
		case "L": 
			$campo     = "logo_nfe"; 
			$diretorio = "logos";
		 break;
		case "T":
			$campo     = "topo_nfe";
			$diretorio = "topos";
		 break;
	}//fim switch
	//sql que busca a imagem conforme o campo que veio por get
	$sql_imagem = mysql_query("SELECT ".$campo." FROM configuracoes");
	list($imagem) = mysql_fetch_array($sql_imagem);
	$result = mysql_num_rows($sql_imagem);
	if($imagem == ""){
		$imagem = "C";
	}
	if(($result>0) && ($imagem != "C")){
?>
<table width="100%">
	<tr>
		<td colspan="4"><img src="img/<?php echo $diretorio."/".rawurlencode($imagem);?>" height="100" width="100"></td>
	</tr>
</table>
<?php
	}else{?>
<table width="100%">
	<tr>
		<td><font color="#FF0000"><b>Não possui imagem!</b></font></td>
	</tr>
</table>
<?php
	}//fim else
}//fim if
?>