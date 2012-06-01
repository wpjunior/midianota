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
session_name("contador");
session_start(); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>e-Nota</title>
<link href="../css/imprimir_emissor.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
if(!(isset($_SESSION["empresa"]))) {   
	echo "
		<script>
			alert('Acesso Negado!');
			window.location='login.php';
		</script>
	";
} // fim if
else {   
	//conecta a base de dados e pega as variaveis globais
	include("../include/conect.php");   
	include("../funcoes/util.php");
	//verifica se foi inserido o XML para UPLOAD
	if($import != "") {
		$arq = $_FILES["import"]['name'];
		$arq_tmp = $_FILES['import']['tmp_name'];   
		$extensao = substr($arq,-3);// pega a extensão do arquivo 
  		//$randomico = rand(00000,99999);
		$arq = $CODIGO_DA_EMPRESA.$arq;
		if(($extensao =="xml")||($extensao =="XML")) {
   
			move_uploaded_file($arq_tmp,"importar/".$arq);
    		//verifica se o upload funcionou   
    		if(file_exists('importar/'.$arq)) {    
	 			$sql=mysql_query("SELECT ultimanota FROM cadastro WHERE codigo = '$CODIGO_DA_EMPRESA'");
	 			list($UltimaNota)=mysql_fetch_array($sql);
     			$xml = simplexml_load_file("importar/$arq"); // lê o arquivo XML 
     			$cont =0; 
	 			$erro =0; 
				$contServicos = 0;
				$rps_invalidos = "";
	 			
				//Verifica se os creditos estao ativos
				$sql_creditos_ativos = mysql_query("SELECT ativar_creditos FROM configuracoes");
				list($situacaoCreditos) = mysql_fetch_array($sql_creditos_ativos);
				
				$sql = mysql_query("SELECT ultimanota FROM cadastro WHERE codigo = '$CODIGO_DA_EMPRESA'");
				list($notaNumero) = mysql_fetch_array($sql);
				$notaNumero++;
				//busca os dados do arquivo XML 
    			foreach($xml->children() as $elemento => $valor) {   
				
					$rps_numero      = $xml->nota[$cont]->rps_numero;
					$rps_data	     = $xml->nota[$cont]->rps_data;
					
					$tomador_cnpjcpf = $xml->nota[$cont]->tomador_cnpjcpf;
					
					$sql_verifica_tomador = mysql_query("
						SELECT 
							nome,
							inscrmunicipal,
							logradouro,
							numero,
							complemento,
							bairro,
							cep,
							municipio,
							uf,
							email
						FROM 
							cadastro 
						WHERE 
							(cpf = '$tomador_cnpjcpf' OR cnpj = '$tomador_cnpjcpf')
					");
					if(mysql_num_rows($sql_verifica_tomador)){
						$dadosTomador = mysql_fetch_array($sql_verifica_tomador);
						$tomador_inscrmunicipal = $dadosTomador['inscrmunicipal'];
						$tomador_nome           = $dadosTomador['nome'];
						$tomador_logradouro     = $dadosTomador['logradouro'];
						$tomador_numero         = $dadosTomador['numero'];
						$tomador_complemento    = $dadosTomador['complemento'];
						$tomador_bairro         = $dadosTomador['bairro'];
						$tomador_cep            = $dadosTomador['cep'];
						$tomador_municipio      = $dadosTomador['municipio'];
						$tomador_uf             = $dadosTomador['uf'];
						$tomador_email          = $dadosTomador['email'];
					}else{
						$tomador_inscrmunicipal = $xml->nota[$cont]->tomador_inscrmunicipal;
						$tomador_nome           = $xml->nota[$cont]->tomador_nome;
						$tomador_logradouro     = $xml->nota[$cont]->tomador_logradouro;
						$tomador_numero         = $xml->nota[$cont]->tomador_numero;
						$tomador_complemento    = $xml->nota[$cont]->tomador_complemento;
						$tomador_bairro         = $xml->nota[$cont]->tomador_bairro;						
						$tomador_cep            = $xml->nota[$cont]->tomador_cep;
						$tomador_municipio      = $xml->nota[$cont]->tomador_municipio;
						$tomador_uf             = $xml->nota[$cont]->tomador_uf;
						$tomador_email          = $xml->nota[$cont]->tomador_email;
					}
					$discriminacao = $xml->nota[$cont]->discriminacao;
					$observacao    = $xml->nota[$cont]->observacao;
					$aliqinss      = $xml->nota[$cont]->aliqinss;
					$aliqirrf      = $xml->nota[$cont]->aliqirrf;
					$valordeducoes = $xml->nota[$cont]->valordeducoes;
					$estado        = $xml->nota[$cont]->estado;
					$deducaoirrf   = $xml->nota[$cont]->deducaoirrf;
					
					//Verifica a validação do XML
					include("inc/importar_erros.php") ;
					$sql_verifica_rps = mysql_query("SELECT codigo FROM notas WHERE rps_numero = '$rps_numero' AND codemissor = '$CODIGO_DA_EMPRESA'");
					if(mysql_num_rows($sql_verifica_rps)){
						echo "<center><b>A nota com o número de RPS $rps_numero, já foi emitida!</b></center>";
						exit;
					}
					$cont++;
				}
				
				$sql_verifica_ultimanota = mysql_query("SELECT ultimanota, notalimite, nome, razaosocial FROM cadastro WHERE codigo = '$CODIGO_DA_EMPRESA'");
				list($ultimaNota,$limite,$nomePrestador,$razaoPrestador) = mysql_fetch_array($sql_verifica_ultimanota);
				if(($limite != 0) && ($limite)){
					$proximoUltimanota = $ultimaNota + $cont;
					if($proximoUltimanota > $limite){
						$erro = 8;
						
						if(!$razaoPrestador){
							$razaoPrestador = $nomePrestador;
						}
					}
				}
				
				if($erro > 0){
					unlink("importar/$arquivo_xml");
				}
				// verifica a formatação do arquivo XML
	 			if($erro ==1){
					print ("<center><b>Arquivo contém dados inconsistentes fora do padrão</b></center>");
				}	
	 			elseif($erro ==2){
	  				print ("<center><b>Arquivo contém código de servico inválido </b></center>");
	 			} // fim elseif
				elseif($erro ==3){
	  				print ("<center><b>Arquivo contém um código de serviço que a empresa não pode emitir nota</b></center>");
				}
	 			elseif($erro ==4){
	  				print ("<center><b>CPF/CNPJ não contém uma formatação válida </b></center>");
	 			} 
	 			elseif($erro ==5){
					print ("<center><b>Data do RPS não contém uma formatação válida </b></center>");
	 			} 
	 			elseif($erro ==6){
					print ("<center><b>CEP do tomador não contém uma formatação válida </b></center>");
	 			}elseif($erro == 7){
					echo "<center><b>A nota com o número de RPS $rps_numero, já foi emitida!</b></center>";
				}elseif($erro == 8){
					echo "<center><b>O prestador <b>$razaoPrestador</b> já emitiu $ultimaNota nota(s), o xml contém $cont nota(s) e seu limite de AIDFe é de $limite nota(s)! Por favor solicite um limite de AIDFe maior.</b></center>";
				}
				else {
	  				$cont =0; 
      				//tabela que mostra os dados que vieram no XML 	 
      ?>
<table border="0" style="border:1px solid #999;" align="left" cellpadding="2" cellspacing="2">
	<tr>
		<td>
			<table width="100%"> 
				<tr>
					<td colspan="20" class="cab01">
						Verificação de dados do  arquivo XML da  empresa  <?php echo $NOME; ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
	<?php	
		
					//pega os dados do XML	 
	 				foreach($xml->children() as $elemento => $valor){   
					
						$rps_numero      = $xml->nota[$cont]->rps_numero;
						$rps_data	     = $xml->nota[$cont]->rps_data;
						
						$tomador_cnpjcpf = $xml->nota[$cont]->tomador_cnpjcpf;
						
						$sql_verifica_tomador = mysql_query("
							SELECT 
								nome,
								inscrmunicipal,
								logradouro,
								numero,
								complemento,
								bairro,
								cep,
								municipio,
								uf,
								email
							FROM 
								cadastro 
							WHERE 
								(cpf = '$tomador_cnpjcpf' OR cnpj = '$tomador_cnpjcpf')
						");
						if(mysql_num_rows($sql_verifica_tomador)){
							$dadosTomador = mysql_fetch_array($sql_verifica_tomador);
							$tomador_inscrmunicipal = $dadosTomador['inscrmunicipal'];
							$tomador_nome           = $dadosTomador['nome'];
							$tomador_logradouro     = $dadosTomador['logradouro'];
							$tomador_numero         = $dadosTomador['numero'];
							$tomador_complemento    = $dadosTomador['complemento'];
							$tomador_bairro         = $dadosTomador['bairro'];
							$tomador_cep            = $dadosTomador['cep'];
							$tomador_municipio      = $dadosTomador['municipio'];
							$tomador_uf             = $dadosTomador['uf'];
							$tomador_email          = $dadosTomador['email'];
						}else{
							$tomador_inscrmunicipal = $xml->nota[$cont]->tomador_inscrmunicipal;
							$tomador_nome           = $xml->nota[$cont]->tomador_nome;
							$tomador_logradouro     = $xml->nota[$cont]->tomador_logradouro;
							$tomador_numero         = $xml->nota[$cont]->tomador_numero;
							$tomador_complemento    = $xml->nota[$cont]->tomador_complemento;
							$tomador_bairro         = $xml->nota[$cont]->tomador_bairro;						
							$tomador_cep            = $xml->nota[$cont]->tomador_cep;
							$tomador_municipio      = $xml->nota[$cont]->tomador_municipio;
							$tomador_uf             = $xml->nota[$cont]->tomador_uf;
							$tomador_email          = $xml->nota[$cont]->tomador_email;
						}
						$discriminacao = $xml->nota[$cont]->discriminacao;
						$observacao    = $xml->nota[$cont]->observacao;
						$aliqinss      = $xml->nota[$cont]->aliqinss;
						$aliqirrf      = $xml->nota[$cont]->aliqirrf;
						$valordeducoes = $xml->nota[$cont]->valordeducoes;
						$estado        = $xml->nota[$cont]->estado;
						$deducaoirrf   = $xml->nota[$cont]->deducaoirrf;
						
						
						switch(strtoupper($estado)){
							case "N":
								$estado = "Normal";
							  break;
							case "E":
								$estado = "Escriturado";
							  break;
							case "C":
								$estado = "Cancelado";
							  break;
							case "B":
								$estado = "Boleto";
							  break;
						}
						
						 	 
	  					$string = "";
						
						//---Complementa o endereco-----------
						if($tomador_numero){
							$string = ", $tomador_numero";
						}
						
						if($tomador_bairro){
							$string .= ", $tomador_bairro";
						}
						
						if($tomador_complemento){
							$string .= ", $tomador_complemento";
						}
						//------------------------------------
	 ?>
<table width="100%" class="cab06" cellspacing="0"> 
	<tr>
		<td class="cab01" align="left" colspan="4">Nota <?php echo $cont+1;?></td>
	</tr>
	<tr class="cab04">
		<td align="center">N&uacute;mero da nota:</td>
		<td align="center">RPS</td>
		<td align="center">Data RPS</td>
		<td align="center">Estado</td>
	</tr>
	<tr>
		<td align="center"><?php echo $notaNumero;?></td>
		<td align="center"><?php echo $rps_numero;?></td>
		<td align="center"><?php echo DataPt($rps_data);?></td>
		<td align="center"><?php echo $estado;?></td>
	</tr>
	
	<tr>
		<td colspan="4" align="center" class="cab01">Dados do tomador</td>
	</tr>
	<tr>
		<td align="left">Nome: </td>
		<td align="left"><?php echo $tomador_nome;?></td>
	</tr>
	<tr>
		<td align="left">CNPJ/CPF: </td>
		<td align="left"><?php echo $tomador_cnpjcpf;?></td>
	</tr>
	<tr>
		<td align="left">Insrc. Munic.: </td>
		<td align="left"><?php echo $tomador_inscrmunicipal;?></td>
	</tr>
	<tr>
		<td align="left">Logradouro: </td>
		<td align="left"><?php echo $tomador_logradouro.$string;?></td>
	</tr>
	<tr>
		<td align="left">Estado: </td>
		<td align="left"><?php echo $tomador_uf;?></td>
		<td align="left">Munic&iacute;pio: </td>
		<td align="left"><?php echo strtoupper($tomador_municipio);?></td>
	</tr>
	<tr>
		<td align="left">Email:</td>
		<td align="left"><?php echo $tomador_email;?></td>
	</tr>
</table>
<br />
<table width="100%" style="border:1px solid #000" cellspacing="0">
	<tr>
		<td colspan="6" align="center" class="cab01">Serviço(s)</td>
	</tr>
	<tr class="cab04">
		<td align="center">Descrição</td>
		<td align="center">Al&iacute;quota</td>
		<td align="center">Base de C&aacute;lc.</td>
		<td align="center">ISS</td>
		<td align="center">ISS Retido</td>
	</tr>
	<?php
	$contServicos     = 0;
	$totalBaseCalculo = 0;
	$totalISS         = 0;
	$totalISSRetido   = 0;
foreach($xml->nota[$cont]->codservico[$contServicos]->children() as $elemento2 => $valor2) {   
	$codservico  = $xml->nota[$cont]->codservico[$contServicos]->codservico;
	$basecalculo = $xml->nota[$cont]->codservico[$contServicos]->basecalculo;
	$issretido   = $xml->nota[$cont]->codservico[$contServicos]->issretido;
	
	//Pega dados do serviço pelo banco
	$sql_servicos = mysql_query("SELECT descricao, aliquota FROM servicos WHERE codservico = '$codservico'");
	list($servicosDescricao,$servicoAliquota) = mysql_fetch_array($sql_servicos);
	
	//Calcula o ISS
	if($basecalculo > 0){
		$iss = ($basecalculo * $servicoAliquota) / 100;
		if($issretido > 0){
			if($issretido > $iss){
				$issretido = $iss;
			}
		}
	}
	
	if($servicosDescricao){
		$curtaDescricao = ResumeString($servicosDescricao,50);
		if(mysql_num_rows($sql_servicos)){
	?>
	<tr>
		<td align="left" title="<?php echo $servicosDescricao;?>"><?php echo $curtaDescricao;?></td>
		<td align="center"><?php echo $servicoAliquota;?></td>
		<td align="center"><?php echo DecToMoeda($basecalculo);?></td>
		<td align="center"><?php echo DecToMoeda($iss);?></td>
		<td align="center"><?php echo DecToMoeda($issretido);?></td>
	</tr>
	<?php
		//Calcula a base de calculo total da nota
		$totalBaseCalculo += floatval($basecalculo);
		$totalISS += floatval($iss);
		$totalISSRetido += floatval($issretido);
		
		}else{
			echo "O arquivo contém codigo de serviços inválidos!";
		}
	}//fim if testa se tem descricao
	
	$contServicos++;
}
		
		$valorINSS = ($totalBaseCalculo * $aliqinss) / 100;
		$valorIRRF = ($totalBaseCalculo * $aliqirrf) / 100;
		if($deducaoirrf > 0){
			if($deducaoirrf > $valorIRRF){
				$deducaoirrf = $valorIRRF;
			}
			$valorIRRF = $valorIRRF - $deducaoirrf;
		}
		
		$valorTotalRetencoes = ($valorINSS + $valorIRRF) + $totalISSRetido;
		$valorTotalNota = ($totalBaseCalculo - $totalISSRetido) + $valordeducoes;
		
		//Testa em quais modalidades de credito o tomador se encaixa
		if (strlen($tomador_cnpjcpf) == 14){
			if($totalISSRetido > 0){
				$tipo_pessoa = "PF";
				$iss_retido = "S";
			}
			else{
				$tipo_pessoa = "PF";
				$iss_retido = "N";
			} // fim else
		} // fim if
		elseif(strlen($tomador_cnpjcpf) == 18){
			if($totalISSRetido > 0){
				$tipo_pessoa = "PJ";
				$iss_retido = "S";
			}
			else{
				$tipo_pessoa = "PJ";
				$iss_retido = "N";
			}
		} // fim else if
		
		//Busca os creditos e os valores pra testar e verificar os creditos para essa nota
		$sql = mysql_query("SELECT credito, valor FROM nfe_creditos WHERE estado = 'A' AND tipopessoa LIKE '%$tipo_pessoa%' AND issretido = '$iss_retido' ORDER BY valor DESC");
		if(mysql_num_rows($sql)>0){
			while(list($nfe_cred,$nfe_valor) = mysql_fetch_array($sql)){
				if($valortotal<=$nfe_valor){
					$credito = $nfe_cred;
				}
			}
			//Verifica se o valor não foi menor que todos os valores do banco, sendo assim se encaixa na regra de maior valor do banco
			if($credito == ""){
				$sql_max_cred = mysql_query("SELECT credito FROM nfe_creditos WHERE estado = 'A' ORDER BY valor DESC LIMIT 1");
				list($cred_max) = mysql_fetch_array($sql_max_cred);
				$credito = $cred_max;
			}
		}else{
			$credito = 0;
		}
		
		//Calcula o valor do credito
		$valorCredito = ($totalISS * $credito) / 100;
		
	?>
</table>
<br />
<table width="100%" class="cab06">
	<tr>
		<td align="center" class="cab01" colspan="6">Dados da nota</td>
	</tr>
	<tr>
		<td colspan="8">Discriminação:</td>
	</tr>
	<tr>
		<td colspan="8" align="left" class="cab05"><?php echo nl2br($discriminacao);?></td>
	</tr>
	<tr>
		<td colspan="8">Observações:</td>
	</tr>
	<tr>
		<td colspan="8" align="left" class="cab05"><?php echo nl2br($observacao);?></td>
	</tr>
	<tr>
		<td height="5">&nbsp;</td>
	</tr>
	<tr>
		<td>Base de c&aacute;lculo da nota:</td>
		<td><?php echo DecToMoeda($totalBaseCalculo);?></td>
		<td>Deduções da nota:</td>
		<td><?php echo DecToMoeda($valordeducoes);?></td>
	</tr>
	<tr>
		<td>ISS da nota:</td>
		<td><?php echo DecToMoeda($totalISS);?></td>
	</tr>
	<tr>
		<td>ISS Retido:</td>
		<td><?php echo DecToMoeda($totalISSRetido);?></td>
	</tr>
	<tr>
		<td>Al&iacute;quota de INSS:</td>
		<td align="left"><?php echo $aliqinss;?></td>
		<td></td>
		<td></td>
		<td>Valor INSS:</td>
		<td align="left"><?php echo DecToMoeda($valorINSS);?></td>
	</tr>
	<tr>
		<td>Al&iacute;quota de IRRF:</td>
		<td align="left"><?php echo $aliqirrf;?></td>
		<td>Dedução de IRRF:</td>
		<td align="left"><?php echo DecToMoeda($deducaoirrf);?></td>
		<td>Valor IRRF:</td>
		<td align="left"><?php echo DecToMoeda($valorIRRF);?></td>
	</tr>
	<tr>
		<td>Valor Nota:</td>
		<td><?php echo DecToMoeda($valorTotalNota);?></td>
		<td>Retenções da nota:</td>
		<td><?php echo DecToMoeda($valorTotalRetencoes);?></td>
	</tr>
	<?php
		if(($situacaoCreditos == "s") || ($situacaoCreditos == "S")){
	?>
	<tr>
		<td align="left">Créditos:</td>
		<td><?php echo DecToMoeda($valorCredito);?></td>
		<td align="center">
			<?php 
				if($credito == 0){ 
					echo "Não foi gerado crédito, pois esta nota não se enquadra em <br>
					nenhuma regra de crédito do sistema de e-Nota <br>
					da prefeitura de ".strtoupper($CONF_CIDADE);
				}
			?>
		</td>
	</tr>
	<?php
		}
	?>
	<tr>
		<td bgcolor="#000000" colspan="8"></td>
	</tr>
	<tr>
		<td colspan="8"><br /></td>
	</tr>
</table>
	  <?php
	  		$notaNumero++;
			$cont++;	
		} //fim foreach lista dados 
		
	 ?>
<table width="100%">
      <tr>
	   <td colspan="20" align="left">
		<form action="importar_inserir.php" method="post">
		 <input type="hidden" value="<?php print $arq;?>" name="txtArquivoNome" />
         <input type="submit" name="btImportarXML" value="Importar Arquivo" class="botao" onclick="return confirm('Deseja gerar está(s) nota(s)?')"/>
	    </form>
	   </td>
	  </tr>
  </table> 
  		</td>
	</tr>
</table>
<?php   	    
				}// If se não deu erro
			}// end if exists    
			else{
				print("<center><b>Falha ao tentar abrir o arquivo XML</b></center>");     
			}
		}// if entensão do arquivo
		else{
			print("<center><b>O arquivo Importado não tem a extensão XML</b></center>");    
		}   
	}// end if campo text import
	else {
		print("<center><b>Insira o arquivo para a importação</b></center>");
	}
}  

?>

</body>
</html>
