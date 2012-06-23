<?php
	include '../../include/nocache.php';
	include("../../include/conect.php");
	include("../../funcoes/util.php");

	if(isset($_GET['txtCNPJ'])){
		$cnpj   = $_GET['txtCNPJ'];
		$aux    = explode(".",$_GET['hdParametros']);
		$tabela = $aux[0];
		$campo  = $aux[1];
		if($cnpj == ""){
			echo "<font color=\"#FF0000\" size=\"-2\"><b>Preencha o CNPJ</b></font><input name=\"hdCNPJ\" type=\"hidden\" id=\"hdCNPJ\" value=\"F\">";
		}else{
			if((strlen($cnpj) == 18) || (strlen($cnpj) == 14)){
				if(strlen($cnpj) == 18){ 
					$msg   = "CNPJ";
					$campo = "cnpj";
				}else{
					$msg   = "CPF";
					$campo = "cpf";
				}
				
				$sql_testa_cnpj = mysql_query("SELECT codigo FROM cadastro WHERE $campo = '$cnpj'");
				
				if(mysql_num_rows($sql_testa_cnpj)>0){
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