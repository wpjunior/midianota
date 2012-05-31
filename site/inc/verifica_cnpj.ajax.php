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
	
	//conecta o banco
	include '../../include/nocache.php';
	include("../../include/conect.php");
	include("../../funcoes/util.php");
	
	//Aqui recebe os inputs por get com as informacoes sobre tabela e campo do BD
	if(isset($_GET['txtCNPJ'])){
		$cnpj   = $_GET['txtCNPJ'];
		$aux    = explode(".",$_GET['hdParametros']);
		$tabela = $aux[0];
		$campo  = $aux[1];
		if($cnpj == ""){
			echo "<font color=\"#FF0000\" size=\"-2\"><b>Preencha o CNPJ</b></font><input name=\"hdCNPJ\" type=\"hidden\" id=\"hdCNPJ\" value=\"F\">";
		}else{
			//testa se o valor enviado é valido
			if((strlen($cnpj) == 18) || (strlen($cnpj) == 14)){
				//testa se o valor enviado é cnpj ou cpf
				if(strlen($cnpj) == 18){ 
					$msg   = "CNPJ";
					$campo = "cnpj";
				}else{
					$msg   = "CPF";
					$campo = "cpf";
				}
				
				//sql que verifica se já existe algum registro com o valor enviado
				$sql_testa_cnpj = mysql_query("SELECT codigo FROM cadastro WHERE $campo = '$cnpj'");
				
				//$sql_testa_cnpj = mysql_query("SELECT codigo FROM $tabela WHERE $campo = '$cnpj'");
				if(mysql_num_rows($sql_testa_cnpj)>0){
					//Este trecho verifica se o cnpj que existe no banco eh de um tomador podendo assim ser inserido
					$codtipo_tomador = codtipo('tomador');
					$sql_testa_tomador = mysql_query("SELECT codigo FROM cadastro WHERE $campo = '$cnpj' AND codtipo = '$codtipo_tomador'");
					if(mysql_num_rows($sql_testa_tomador)){
						echo "<font color=\"#00CC33\" size=\"-2\"><b>$msg valido!</b></font>";	
					}else{
						echo "<font color=\"#FF0000\" size=\"-2\"><b>Este $msg já existe!</b></font><input name=\"hdCNPJ\" type=\"hidden\" id=\"hdCNPJ\" value=\"F\">";
					}
				}else{
					echo "<font color=\"#00CC33\" size=\"-2\"><b>$msg valido!</b></font>";
				}
			}else{
				echo "<font color=\"#FF0000\" size=\"-2\"><b>Formato invalido!</b></font><input name=\"hdCNPJ\" type=\"hidden\" id=\"hdCNPJ\" value=\"F\">";
			}
		}
	}
?>