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


$emissor_CNPJ = $_GET['txtCNPJ'];
$tipo         = $_GET['cmbTipo'];



if($emissor_CNPJ){
	if($tipo){
		if($tipo == "P"){
			if((strlen($emissor_CNPJ) == 18) || (strlen($emissor_CNPJ) == 14)){
				//Verifica qual o codigo para prestadores
				$codtipo = codtipo("prestador");
				//Verifica qual o tipo de declaração este prestador possui
				$sql_verifica_coddectipo = mysql_query("
					SELECT 
						codtipodeclaracao 
					FROM 
						cadastro 
					WHERE 
						(cnpj = '$emissor_CNPJ' OR cpf = '$emissor_CNPJ') AND codtipo = '$codtipo' AND estado = 'A'");
				list($codtipodec_sql) = mysql_fetch_array($sql_verifica_coddectipo);
				
				if(mysql_num_rows($sql_verifica_coddectipo)){
					//Pega o codigo dos tipos de verificação possiveis
					$codtipodec_consolidada  = codtipodeclaracao("DES Consolidada");
					$codtipodec_simplificada = codtipodeclaracao("DES Simplificada");
					
					//Testa o tipo de declaração do prestador dependendo do tipo da include em paginas diferentes
					if($codtipodec_sql == $codtipodec_consolidada){
						include("comtomador.php");
					}elseif($codtipodec_sql == $codtipodec_simplificada){
						include("semtomador.php");
					}else{
						echo "<b>O tipo de declaração deste prestador é simples nacional!</b>";
					}
				}else{
					echo "<b>Este cnpj/cpf não está cadastrado ou não foi liberado!</b>";
				}
			}else{
				echo "<b>O CNPJ/CPF está em um formato inválido</b>";
			}
		}elseif($tipo == "T"){
			include("tomadores.php");
		}
	}else{
		echo "<b>Você deve selecionar um tipo!</b>";
	}
}else{
	echo "<b>Você deve digitar um cnpj/cpf!</b>";
}


/*
if($_POST){

	$codverificacao = gera_codverificacao();
	
	
	if($_POST['hdCnpjComTomador']!=""){//des com discriminacao de tomador
		include 'gerarguia_comtomador.php';
	}
	if($_POST['hdCNPJ']!=""){//des sem tomador e o cnpj do emissor nao cadastrado
		include 'gerarguia_semtom_cnpjnaocad.php';
	}
	if($_POST['hdCNPJsemTomador']!=""){//des sem tomador e emissor cadastrado
		include 'gerarguia_semtomador.php';
	}
	if($_POST['hdTotalInputs']!=""){//declaracao de iss retido
		include 'gerarguia_issretido.php';
	}
	
	Mensagem("Serviço(s) declarado(s)!");
}*/
?>