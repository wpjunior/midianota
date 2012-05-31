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
$file = $_GET['file']; // pega o endereço do arquivo
                       // ou o nome dele se o arquivo 
                       // estiver na mesma pagina!! 
foreach($_GET as $link => $nada);
$file = "..".str_replace("_",".",$link);
if(strpos($file,".csv")===false){//teste se o arquivo é a extenção esperada, para nao baixar arquivos php por exemplo
	echo "erro na importação do arquivo!";
}else{
	$nome_arquivo=array_reverse(explode("/",$file));
	$nome_arquivo=$nome_arquivo[0];
	header("Content-Type: application/save");
	header("Content-Length:".filesize($file)); 
	header('Content-Disposition: attachment; filename="' . $nome_arquivo . '"'); 
	header("Content-Transfer-Encoding: binary");
	header('Expires: 0'); 
	header('Pragma: no-cache'); 
	
	// nesse momento ele le o arquivo e envia
	$fp = fopen("$file", "r"); 
	fpassthru($fp); 
	fclose($fp); 
}
?>
