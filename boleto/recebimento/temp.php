<?php
 	include("funcoes.php");
	include("inc/conect.php");
	$sql=mysql_query("SELECT agencia,contacorrente,convenio,contrato,carteira FROM boleto");
	list($agencia,$contacorrente,$convenio,$contrato,$carteira)=mysql_fetch_array($sql);
    $codigoboleto=base64_decode($_GET['COD']);   
    echo $codigoboleto;
    //$codigoboleto=529;
	if($codigoboleto) 
	{

	    $sql_tipo_guia=mysql_query("
			SELECT 
				guias_declaracoes.codrelacionamento, 
				guias_declaracoes.relacionamento, 
				DATE_FORMAT(guia_pagamento.dataemissao,'%d/%m/%Y'), 
				guia_pagamento.valor, 
				guia_pagamento.nossonumero, 
				DATE_FORMAT(guia_pagamento.datavencimento,'%d/%m/%Y'), 
				guia_pagamento.valormulta 
			FROM 
				guia_pagamento 
			INNER JOIN 
				guias_declaracoes ON guias_declaracoes.codguia = guia_pagamento.codigo
			WHERE 
				guia_pagamento.codigo='$codigoboleto'
		");	
		
		list($codrel,$tipoguia,$emissao,$valorbl,$nossonumero,$vencimento,$ValMulta)=mysql_fetch_array($sql_tipo_guia);    
		
		switch ($tipoguia){	
			case 'des':	
				$sql_des=mysql_query("
					SELECT emissores.cnpjcpf , 
						   emissores.razaosocial,
						   emissores.endereco,
						   DATE_FORMAT(des.competencia,'%m%/%Y')				   
					FROM emissores 
					INNER JOIN des ON des.codemissor = emissores.codigo					
					WHERE des.codigo='$codrel'
				");	
				list($Cnpj,$RazaoSocial,$EndSacado,$Competencia)=mysql_fetch_array($sql_des);		
				$Atividades="Prestação de serviço(s)";

				$sql_receita=mysql_query("
					SELECT
						sum(des.total) 
					FROM
						guias_declaracoes
				    INNER JOIN 
				    	des ON guias_declaracoes.codrelacionamento= des.codigo
				    WHERE 
				    	guias_declaracoes.codguia=$codigoboleto AND
				    	guias_declaracoes.relacionamento = 'des'
				");
				list($Receita)=mysql_fetch_array($sql_receita);
				break;	
				
			case 'des_temp':	
				$sql_des=mysql_query("
					SELECT 
						emissores_temp.cnpj , 
						emissores_temp.razaosocial,
						emissores_temp.endereco,
						DATE_FORMAT(des_temp.competencia,'%m%/%Y')				   
					FROM 
						emissores_temp
					INNER JOIN 
						des_temp ON des_temp.codemissores_temp = emissores_temp.codigo					
					WHERE 
						des_temp.codigo='$codrel'
				");	
				list($Cnpj,$RazaoSocial,$EndSacado,$Competencia)=mysql_fetch_array($sql_des);		
				$Atividades="Prestação de serviço(s)";

				$sql_receita=mysql_query("
					SELECT
						des_temp.base 
					FROM
						guias_declaracoes
				    INNER JOIN 
				    	des_temp ON guias_declaracoes.codrelacionamento = des_temp.codigo
				    WHERE 
				    	guias_declaracoes.codguia=$codigoboleto AND
				    	guias_declaracoes.relacionamento = 'des_temp'
				");
				list($Receita)=mysql_fetch_array($sql_receita);
				break;	
					
			case 'des_issretido':	
				$sql_des=mysql_query("
					SELECT tomadores.cnpjcpf , 
						   tomadores.nome,
						   tomadores.endereco,
						   DATE_FORMAT(des_issretido.competencia,'%m%/%Y')
						      
					FROM tomadores 
					INNER JOIN des_issretido ON des_issretido.codtomador = tomadores.codigo
					WHERE des_issretido.codigo='$codrel'
				");			
				list($Cnpj,$RazaoSocial,$EndSacado,$Competencia)=mysql_fetch_array($sql_des);
				
				$sql_receita=mysql_query("
					SELECT
						sum(des_issretido.total) 
					FROM
						guias_declaracoes
					INNER JOIN 
						des_issretido ON guias_declaracoes.codrelacionamento= des_issretido.codigo
					WHERE 
						guias_declaracoes.codguia=$codigoboleto AND
					    guias_declaracoes.relacionamento = 'des_issretido'
				");
				
				list($Receita)=mysql_fetch_array($sql_receita);
				$Atividades="Serviço Tomado";
							
				break;	
				
				
				break;	
					
			case 'dif_des':	
				$sql_des=mysql_query("
					SELECT inst_financeiras.cnpj , 
						   inst_financeiras.razaosocial,
						   inst_financeiras.endereco,
						   DATE_FORMAT(dif_des.competencia,'%m%/%Y')   
					FROM inst_financeiras 
					INNER JOIN dif_des ON dif_des.codinst_financeira = inst_financeiras.codigo
					WHERE dif_des.codigo='$codrel'");		
				$Atividades="Instituição financeira";								
				list($Cnpj,$RazaoSocial,$EndSacado,$Competencia)=mysql_fetch_array($sql_des);
				
				$sql_receita=mysql_query("
					SELECT
						sum(dif_des.total) 
					FROM
						guias_declaracoes
					INNER JOIN 
						dif_des ON guias_declaracoes.codrelacionamento= dif_des.codigo
					WHERE 
						guias_declaracoes.codguia=$codigoboleto AND
					    guias_declaracoes.relacionamento = 'dif_des'
				");
				
				list($Receita)=mysql_fetch_array($sql_receita);
							
				break;	
				
				
			case 'dop_des':
				$sql_des=mysql_query("
					SELECT
						   orgaospublicos.cnpj, 
						   orgaospublicos.razaosocial,
						   orgaospublicos.endereco,
						   DATE_FORMAT(dop_des.competencia,'%m%/%Y')   
					FROM 
						   orgaospublicos 
					INNER JOIN
						   dop_des ON dop_des.codorgaopublico = orgaospublicos.codigo
					WHERE 
						   dop_des.codigo='$codrel'
				");		
				$Atividades="Operadora de crédito";	
				list($Cnpj,$RazaoSocial,$EndSacado,$Competencia)=mysql_fetch_array($sql_des);
				
				$sql_receita=mysql_query("
					SELECT
						sum(dop_des.total) 
					FROM
						guias_declaracoes
					INNER JOIN 
						dop_des ON guias_declaracoes.codrelacionamento= dop_des.codigo
					WHERE 
						guias_declaracoes.codguia=$codigoboleto AND
					    guias_declaracoes.relacionamento = 'dop_des'
				");
				
				list($Receita)=mysql_fetch_array($sql_receita);

				
				
				break;									
			
			case 'nfe':	 		
				//precisa fazer	
			 	break;	
			 	
			 	
			case 'doc_des':
				$sql_des=mysql_query("
					SELECT operadoras_creditos.cnpj, 
						   operadoras_creditos.razaosocial,
						   operadoras_creditos.endereco,
						   DATE_FORMAT(doc_des.competencia,'%m%/%Y')   
					FROM operadoras_creditos 
					INNER JOIN doc_des ON doc_des.codopr_credito = operadoras_creditos.codigo
					WHERE doc_des.codigo='$codrel'
				");		
				$Atividades="Operação de cartório";	
				list($Cnpj,$RazaoSocial,$EndSacado,$Competencia)=mysql_fetch_array($sql_des);	

				$sql_receita=mysql_query("
					SELECT
						 sum(doc_des.total) 
					FROM
						guias_declaracoes
					INNER JOIN 
						doc_des ON guias_declaracoes.codrelacionamento= doc_des.codigo
					WHERE 
						guias_declaracoes.codguia=$codigoboleto AND
					    guias_declaracoes.relacionamento = 'doc_des'
				");
				
				list($Receita)=mysql_fetch_array($sql_receita);
				
				break;			

				

				
			case 'decc_des':
				$sql_des=mysql_query("
					SELECT empreiteiras.cnpj, 
						   empreiteiras.razaosocial,
						   empreiteiras.endereco,
						   DATE_FORMAT(decc_des.competencia,'%m%/%Y')   
					FROM empreiteiras 
					INNER JOIN decc_des ON decc_des.codempreiteira = decc_des.codigo
					WHERE decc_des.codigo='$codrel'
				");		
				
				$Atividades="Empreiteira";	
				list($Cnpj,$RazaoSocial,$EndSacado,$Competencia)=mysql_fetch_array($sql_des);	

				$sql_receita=mysql_query("
					SELECT
						sum(decc_des.total) 
					FROM
						guias_declaracoes
					INNER JOIN 
						decc_des ON guias_declaracoes.codrelacionamento= decc_des.codigo
					WHERE 
						guias_declaracoes.codguia = $codigoboleto AND
					    guias_declaracoes.relacionamento = 'decc_des'
				");
				
				list($Receita)=mysql_fetch_array($sql_receita);
				
				break;						
		}
	}
	
	$taxa_boleto =0;	
	
	//DEFINE OS 3 PRIMEIROS CARACTERES DA LINHA DIGITAVEL
	$tipoProduto="8"; // para definir como arrecadação
	$tipoSegmento="1"; //para definir como prefeitura
	$tipoValor="9"; // Define o modulo de geração do digito verificador
		
	
	//$CONF_CNPJ
	//$CONF_ENDERECO
	//$CONF_CIDADE
	//$CONF_ESTADO
	
	
	//FORMATA O VALOR DO BOLETO
	$valor= $valorbl; //variavel do banco;	
	$valor = str_replace(",", ".",$valor);	
	$valor_boleto=number_format($valor+$taxa_boleto, 2, ',', '');
	$valor = formata_numero($valor_boleto,11,0,"valor");

	
	
	// FORMATA O CNPJ DEIXANDO-O SOMENTE COM NUMEROS
	$identificacao= $CONF_CNPJ; //variavel do banco cnpj pref
	$identificacao = str_replace(".", "",$identificacao);
	$identificacao = str_replace("/", "",$identificacao);
	$identificacao = str_replace("-", "",$identificacao);
	$identificacao= substr($identificacao,0,8);
			
	
	
	//$nossonumero=$nossonumero; // convenio + zeros + codguia	
	
	//GERA O DIGITO VERIFICADOR 
	$dv= modulo_11($tipoProduto.$tipoSegmento.$tipoValor.$valor.$identificacao.$nossonumero);	
	
	//MONTA A LINHA DIGITAVEL
	$linha = $tipoProduto.$tipoSegmento.$tipoValor.$dv.$valor.$identificacao.$nossonumero;	
	
	
	//MOSTRA O CODIGO DE BARRAS
	$linha01= substr($linha,0,11);
		$dv01=modulo_11($linha01);
		
	$linha02= substr($linha,11,11);
		$dv02=modulo_11($linha02);
		
	$linha03= substr($linha,22,11);
		$dv03=modulo_11($linha03);
		
	$linha04= substr($linha,33,11);
		$dv04=modulo_11($linha04);
		
	$linhad = $linha01.'-'.$dv01.' '.$linha02.'-'.$dv02.' '.$linha03.'-'.$dv03.' '.$linha04.'-'.$dv04."<br>";
	
	//echo$nossonumero."<br>";
	//echo strlen($nossonumero)."<br>";
	//geraCodigoDeBarras($linha);
	
	// INCLUDE DO LAYOUT	
	include("layout.php");
?>	



		 