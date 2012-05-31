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
if(!(isset($_SESSION["empresa"]))){   
	echo "
		<script>
		alert('Acesso Negado!');
		window.location='login.php';
		</script>
	";
}else{
	$botao = $_POST['btImportarXML'];  
	$arquivo_xml = $_POST['txtArquivoNome'];
	if($botao == "Importar Arquivo"){
		include("../include/conect.php");
		include("../funcoes/util.php");
		include("inc/funcao_logs.php");
		$sql=mysql_query("SELECT ultimanota FROM cadastro WHERE codigo = '$CODIGO_DA_EMPRESA'");
		list($UltimaNota)=mysql_fetch_array($sql);  
		
		$sql=mysql_query("SELECT codigo FROM cadastro WHERE codigo = '$CODIGO_DA_EMPRESA'"); 
		list($codigoEmpresa)=mysql_fetch_array($sql);  
		
		$xml = simplexml_load_file("importar/$arquivo_xml"); // lê o arquivo XML 
		$cont = 0; 
		$inserir_tomador = "N";
		foreach($xml->children() as $elemento => $valor){   
					
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
				$inserir_tomador        = "S";
			}
			$discriminacao = $xml->nota[$cont]->discriminacao;
			$observacao    = $xml->nota[$cont]->observacao;
			$aliqinss      = $xml->nota[$cont]->aliqinss;
			$aliqirrf      = $xml->nota[$cont]->aliqirrf;
			$valordeducoes = $xml->nota[$cont]->valordeducoes;
			$rps_numero    = $xml->nota[$cont]->rps_numero;
			$rps_data	   = $xml->nota[$cont]->rps_data;
			$estado        = $xml->nota[$cont]->estado;
			$deducaoirrf   = $xml->nota[$cont]->deducaoirrf;
			
			$sql_verifica_rps = mysql_query("SELECT codigo FROM notas WHERE rps_numero = '$rps_numero' AND codemissor = '$CODIGO_DA_EMPRESA'");
			if(mysql_num_rows($sql_verifica_rps)){
				Mensagem('A nota com o número de RPS $rps_numero, já foi emitida!');
				exit;
			}
			
			switch(strtolower($estado)){
				case "normal":
					$estado = "N";
				  break;
				case "escriturado":
					$estado = "E";
				  break;
				case "cancelado":
					$estado = "C";
				  break;
				case "boleto":
					$estado = "B";
				  break;
			}
			
			//GERA O CÓDIGO DE VERIFICAÇÃO
			$CaracteresAceitos = 'ABCDEFGHIJKLMNOPQRXTUVWXYZ';	
			$max = strlen($CaracteresAceitos)-1;
			$password = null;
			for($i=0; $i < 8; $i++){
				$password .= $CaracteresAceitos{mt_rand(0, $max)}; 
				$carac = strlen($password); 
				if($carac ==4){ 
					$password .= "-";
				} 
			}
			
			if($inserir_tomador == "S"){
				$campo = tipoPessoa($tomador_cnpjcpf);
				$codTipoTomador = codtipo('tomador');
				$codTipoDec = coddeclaracao('DES Consolidada');
				$datainicio = date("Y-m-d");
				mysql_query("
					INSERT INTO
						cadastro
					SET
						nome              = '$tomador_nome',
						codtipo           = '$codTipoTomador',
						codtipodeclaracao = '$codTipoDec',
						razaosocial       = '$tomador_nome',
						$campo            = '$tomador_cnpjcpf',
						inscrmunicipal    = '$tomador_inscrmunicipal',
						logradouro        = '$tomador_logradouro',
						numero            = '$tomador_numero',
						complemento       = '$tomador_complemento',
						bairro            = '$tomador_bairro',
						cep               = '$tomador_cep',
						uf                = '$tomador_uf',
						email             = '$tomador_email',
						municipio         = '$tomador_municipio',
						estado            = 'A',
						datainicio        = '$datainicio'
				")or die(mysql_error());
			}
			
			//Pega a data e a hora da emissao
			$dataAtual = date("Y-m-d");
			$horaAtual = date("H:i:s");
			
			//Pega o numero da ultima nota
			$sql_numero = mysql_query("SELECT ultimanota FROM cadastro WHERE codigo = '$CODIGO_DA_EMPRESA'");
			list($max_numero) = mysql_fetch_array($sql_numero);
			$max_numero++;
			
			//Insere os dados no banco
			mysql_query("
				INSERT INTO 
					notas 
				SET 
					numero = '$max_numero', 
					codverificacao = '$password', 
					codemissor = '$CODIGO_DA_EMPRESA', 
					rps_numero = '$rps_numero', 
					rps_data = '$rps_data',
					tomador_nome = '$tomador_nome', 
					tomador_cnpjcpf = '$tomador_cnpjcpf',
					tomador_inscrmunicipal = '$tomador_inscrmunicipal',		
					tomador_logradouro = '$tomador_logradouro',
					tomador_numero = '$tomador_numero',
					tomador_complemento = '$tomador_complemento',
					tomador_bairro = '$tomador_bairro',		 
					tomador_cep = '$tomador_cep', 
					tomador_municipio = '$tomador_municipio',
					tomador_uf = '$tomador_uf',
					tomador_email = '$tomador_email', 
					discriminacao = '$discriminacao',
					valortotal = NULL, 
					valordeducoes = '$valordeducoes', 
					basecalculo = NULL,
					valoriss = NULL, 
					credito = NULL, 
					estado = '$estado',
					datahoraemissao = '$dataAtual $horaAtual', 
					issretido = NULL, 
					valorinss = NULL, 
					aliqinss = '$aliqinss',
					valorirrf = NULL, 
					aliqirrf = '$aliqirrf', 
					deducao_irrf = '$deducaoirrf',
					total_retencao = NULL,
					observacao = '$observacao',
					tipoemissao = 'importada'
			")or die(mysql_error());
			//Pega o codigo da ultima nota inserida no banco
			$codUltimaNota = mysql_insert_id();
			
			$contServicos     = 0;
			$totalBaseCalculo = 0;
			$totalISS         = 0;
			$totalISSRetido   = 0;
			foreach($xml->nota[$cont]->codservico[$contServicos]->children() as $elemento2 => $valor2) {   
				$codservico  = $xml->nota[$cont]->codservico[$contServicos]->codservico;
				$basecalculo = $xml->nota[$cont]->codservico[$contServicos]->basecalculo;
				$issretido   = $xml->nota[$cont]->codservico[$contServicos]->issretido;
				
				//Pega dados do serviço pelo banco
				$sql_servicos = mysql_query("SELECT codigo, descricao, aliquota FROM servicos WHERE codservico = '$codservico'");
				list($servicoCodigo,$servicosDescricao,$servicoAliquota) = mysql_fetch_array($sql_servicos);
				
				//Calcula o ISS
				if($basecalculo > 0){
					$iss = ($basecalculo * $servicoAliquota) / 100;
					if($issretido > 0){
						if($issretido > $iss){
							$issretido = $iss;
						}
					}
				}
				
				//Verifica se ha um servico nessa volta do foreach
				if($servicosDescricao){
					$curtaDescricao = ResumeString($servicosDescricao,50);
					
					mysql_query("
						INSERT INTO
							notas_servicos
						SET
							codnota     = '$codUltimaNota',
							codservico  = '$servicoCodigo',
							basecalculo = '$basecalculo',
							issretido   = '$issretido',
							iss         = '$iss'
					")or die(mysql_error());
					
					//Calcula a base de calculo total da nota
					$totalBaseCalculo += floatval($basecalculo);
					$totalISS += floatval($iss);
					$totalISSRetido += floatval($issretido);
					
				}//fim if testa se tem descricao
				$contServicos++;
			}
			
			$valorINSS = ($totalBaseCalculo * $aliqinss) / 100;
			$valorIRRF = ($totalBaseCalculo * $aliqirrf) / 100;
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

			//Atualiza a nota com os dados que faltavam
			mysql_query("
				UPDATE 
					notas 
				SET
					valortotal     = '$valorTotalNota', 
					basecalculo    = '$totalBaseCalculo',
					valoriss       = '$totalISS', 
					credito        = '$valorCredito', 
					issretido      = '$totalISSRetido', 
					valorinss      = '$valorINSS', 
					valorirrf      = '$valorIRRF', 
					total_retencao = '$valorTotalRetencoes'
				WHERE
					codigo = '$codUltimaNota' 
			")or die(mysql_error());	
			
			//Atualiza a ultima nota
			$sql = mysql_query("SELECT ultimanota FROM cadastro WHERE codigo = '$CODIGO_DA_EMPRESA'");
			list($ultimaNota) = mysql_fetch_array($sql);
			$ultimaNota += 1;
			
			$sql = mysql_query("UPDATE cadastro SET ultimanota = '$ultimaNota' WHERE codigo = '$CODIGO_DA_EMPRESA'")or die(mysql_error());
			
			$cont++;
		}// foreach
		unlink("importar/$arquivo_xml");
		add_logs('Importou Arquivo');
		print("<script language=JavaScript>alert('Importação efetuada com sucesso !');window.close();</script>");
	}else{
		print("Acesso Negado!!"); 
	}	
}?>