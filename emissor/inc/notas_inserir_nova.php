<?php
	$tomadorCnpj             = $_POST['txtTomadorCNPJ'];
	$tomadorNome             = $_POST['txtTomadorNome'];
	$tomadorInscMunic        = $_POST['txtTomadorIM'];
	$tomadorLogradouro       = $_POST['txtTomadorLogradouro'];
	$tomadorNumero           = $_POST['txtTomadorNumero'];
	$tomadorComplemento      = $_POST['txtTomadorComplemento'];
	$tomadorBairro           = $_POST['txtTomadorBairro'];
	$tomadorCep              = $_POST['txtTomadorCEP'];
	$naturezaOperacao        = $_POST['txtnaturezaoperacao'];
        
	if(!empty($_POST['txtTomadorMunicipio'])){
		$tomadorMunicipio = $_POST['txtTomadorMunicipio'];
	}elseif(!empty($_POST['txtInsMunicipioEmpresa'])){
		$tomadorMunicipio = $_POST['txtInsMunicipioEmpresa'];
	}
        
	$tomadorUF               = $_POST['txtTomadorUF'];
	$tomadorEmail            = $_POST['txtTomadorEmail'];
	$notaRpsNumero           = $_POST['txtRpsNum'];
	$notaRpsData             = DataMysql($_POST['txtDataRps']);
	$notaNumero              = $_POST['txtNotaNumero'];
	$notaDataHoraEmissao     = $_POST['txtNotaDataHoraEmissao'];
	$notaCodigoVerificacao   = $_POST['txtNotaCodigoVerificacao'];
	$notaDiscriminacao       = $_POST['txtNotaDiscriminacao'];
	$notaObservacao          = $_POST['txtObsNota'];
	$notaValorDeducoes       = MoedaToDec($_POST['txtValorDeducoes']);
	$notaTotalBasedeCalculo  = MoedaToDec($_POST['txtBaseCalculo']);
	$notaTotalValorISS       = MoedaToDec($_POST['txtISS']);
	$notaTotalValorISSRetido = MoedaToDec($_POST['txtIssRetido']);
	$notaAliquotaINSS        = $_POST['txtAliquotaINSS'];
	$notaValorINSS           = MoedaToDec($_POST['txtValorINSS']);
	$notaAliquotaIRRF        = $_POST['txtIRRF'];
	$notaDeducaoIRRF         = MoedaToDec($_POST['txtDeducIRRF']);
	$notaValorIRRF           = MoedaToDec($_POST['txtValorFinalIRRF']);
	$notaValorTotalRetencoes = MoedaToDec($_POST['txtValTotalRetencao']);
	$notaCredito             = MoedaToDec($_POST['txtCredito']);
	$notaValorTotal          = MoedaToDec($_POST['txtValTotal']);
	$cofins                   = MoedaToDec($_POST['txtCofins1']);
	$txtmunicipio_servico_prestado   = ($_POST['txtmunicipio_servico_prestado']);
	$necessita_iss_retido            = ($_POST['necessita_iss_retido']);
        

	
	$sql = mysql_query("SELECT ultimanota FROM cadastro WHERE codigo = '$CODIGO_DA_EMPRESA'");
	list($ultimanota)=mysql_fetch_array($sql);
	$ultimanota ++;
	
	$sql=mysql_query("SELECT notalimite FROM cadastro WHERE codigo = $CODIGO_DA_EMPRESA");
	list($notalimite)=mysql_fetch_array($sql);
	
	if(($ultimanota>$notalimite)&&($notalimite!=0)) {
	
		Mensagem('Voce nao pode emitir NFe por que ultrapassou seu limite estabelecido pelo AIDF. Entre em contato com a prefeitura.');
		Redireciona('notas.php');
		
	}elseif(($ultimanota<=$notalimite)||($notalimite==0)){  
		if(($tomadorNome !="") && ($tomadorCnpj !="") && ($notaTotalBasedeCalculo !="")){  
			
			$aux = explode(" ", $notaDataHoraEmissao);
			$notaEmissaoData = DataMysql($aux[0]);
			$notaEmissaoHora = $aux[1].":00";
			
	
			$sql = mysql_query("SELECT * FROM cadastro WHERE cnpj='$tomadorCnpj' or cpf='$tomadorCnpj'");
			$campo = tipoPessoa($tomadorCnpj);
						
			if(mysql_num_rows($sql)<=0){
			
				$codtipo = codtipo('tomador');
				$codtipodec = coddeclaracao('DES Simplificada');
				$diaatual = date("Y-m-d");
				mysql_query("
					INSERT INTO 
						cadastro
					SET 
						nome = '$tomadorNome',
						$campo = '$tomadorCnpj',
						inscrmunicipal = '$tomadorInscMunic',
						codtipo = '$codtipo', 
						codtipodeclaracao = '$codtipodec', 
						logradouro = '$tomadorLogradouro',
						numero = '$tomadorNumero',
						complemento = '$tomadorComplemento',
						bairro = '$tomadorBairro',
						cep = '$tomadorCep',
						municipio = '$tomadorMunicipio',
						uf = '$tomadorUF',
						email = '$tomadorEmail',
						estado = 'A',
						datainicio = '$diaatual'
				");
			}
		
			$sql = mysql_query("
				INSERT INTO 
					notas 
				SET 
					numero = '$ultimanota', 
					codverificacao = '$notaCodigoVerificacao', 
					codemissor = '$CODIGO_DA_EMPRESA', 
					rps_numero = '$notaRpsNumero', 
					rps_data = '$notaRpsData',
					tomador_nome = '$tomadorNome', 
					tomador_cnpjcpf = '$tomadorCnpj',
					tomador_inscrmunicipal = '$tomadorInscMunic',		
					tomador_logradouro = '$tomadorLogradouro',
					tomador_numero = '$tomadorNumero',
					tomador_complemento = '$tomadorComplemento',
					tomador_bairro = '$tomadorBairro',		 
					tomador_cep = '$tomadorCep', 
					tomador_municipio = '$tomadorMunicipio',
					tomador_uf = '$tomadorUF',
					tomador_email = '$tomadorEmail', 
					discriminacao = '$notaDiscriminacao',
					valortotal = '$notaValorTotal', 
					valordeducoes = '$notaValorDeducoes', 
					basecalculo = '$notaTotalBasedeCalculo',
					valoriss = '$notaTotalValorISS', 
					credito = '$notaCredito', 
					estado = 'N',
					datahoraemissao = '$notaEmissaoData $notaEmissaoHora', 
					issretido = '$notaTotalValorISSRetido', 
					valorinss = '$notaValorINSS', 
					aliqinss = '$notaAliquotaINSS',
					valorirrf = '$notaValorIRRF', 
					aliqirrf = '$notaAliquotaIRRF', 
					deducao_irrf = '$notaDeducaoIRRF', 
					total_retencao = '$notaValorTotalRetencoes',
					observacao = '$notaObservacao',
                                        natureza_operacao = '$naturezaOperacao',
                                        cofins = '$cofins',
                                        municipio_prestacao_servico = '$txtmunicipio_servico_prestado',
                                        necessita_iss_retido = '$necessita_iss_retido'
			");   
			
			
			$quantidadeInputs = $_POST['hdInputs'];
			$codigoUltimaNota = mysql_insert_id(); 
			$cont = 1;
			
			while($cont <= $quantidadeInputs){
				$aux = explode("|",$_POST['cmbCodServico'.$cont]);
				$servicoCodigo    = $aux[1];
				$servicoBaseCalc  = MoedaToDec($_POST['txtBaseCalcServico'.$cont]);
				$servicoValorISS  = MoedaToDec($_POST['txtValorIssServico'.$cont]);
				$servicoISSRetido = MoedaToDec($_POST['txtISSRetidoManual'.$cont]);
				
				$sql_servicos_notas = mysql_query("
					INSERT INTO 
						notas_servicos
					SET
						codnota = '$codigoUltimaNota',
						codservico = '$servicoCodigo',
						basecalculo = '$servicoBaseCalc',
						iss = '$servicoValorISS',
						issretido = '$servicoISSRetido'
				");
				$cont++;
			}
			
			$sql = mysql_query("UPDATE cadastro SET ultimanota= '$ultimanota' WHERE codigo = '$CODIGO_DA_EMPRESA'");
			add_logs('Emitiu nota fiscal');
			
			if($tomadorEmail){
				$email_enviado = "";				
				$email_enviado = notificaTomador($CODIGO_DA_EMPRESA,$ultimanota);
			}
			
			if($email_enviado){
				print("<script language=JavaScript>alert('Nota emitida com sucesso e tomador notificado!')</script>");
			}else{
				print("<script language=JavaScript>alert('Nota emitida com sucesso!')</script>");
			}
		}else{
			print("<script language=JavaScript>alert('Favor preencher campos obrigatórios!')</script>");
		}
	}
?>