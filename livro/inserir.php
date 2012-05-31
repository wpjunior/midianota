<?php 	
	$codcadastro= $_POST['txtCodCadastro'];
	$cnpjcpf=$_POST['txtCnpjLivro'];
	$mes= $_POST['cmbMes'];
	$ano= $_POST['cmbAno'];
	$vencimento= DataMysql($_POST['txtDataVencimento']);
	$obs = $_POST['txtObs'];	
	$mes <=9 ? $mes='0'.$mes:NULL;
	$periodo= $ano.'-'.$mes;
    $periodomysql=$ano."-".$mes;
	
	
	
	$basecalculo=0;
	$reducaobc=0;
	$valoriss=0;
	$valorissretido=0;
	$valorisstotal=0;
	
	$sql=mysql_query("SELECT * FROM livro WHERE codcadastro='$codcadastro' AND periodo='$periodo'");
	if(mysql_num_rows($sql)==0)
	{
		mysql_query("INSERT INTO livro (codcadastro,periodo,vencimento,geracao,obs) VALUES('$codcadastro','$periodo','$vencimento',NOW(),'$obs')");
		
		$sql=mysql_query("SELECT MAX(codigo) as codigo FROM livro WHERE codcadastro='$codcadastro'");
		
		$livro=mysql_fetch_object($sql);	
		
		$sql=mysql_query("SELECT codigo,tomador_cnpjcpf,basecalculo,valoriss,issretido,estado FROM notas WHERE (codemissor='$codcadastro' OR tomador_cnpjcpf='$cnpjcpf') AND datahoraemissao LIKE '$periodomysql%'");
		while($nota=mysql_fetch_object($sql)){
				
			if($nota->estado!='C')
			{
				$basecalculo+=$nota->basecalculo;
				$valoriss+=$nota->valoriss;
				$valorissretido+=$nota->issretido;
			}	
				
				if($cnpjcpf==$nota->tomador_cnpjcpf){
					mysql_query("INSERT INTO livro_notas (codnota,codlivro,tipo,nfe) VALUES('{$nota->codigo}','{$livro->codigo}','T','S')");			
				}else{	
					mysql_query("INSERT INTO livro_notas (codnota,codlivro,tipo,nfe) VALUES('{$nota->codigo}','{$livro->codigo}','E','S')");			
				}
		}		
		$valorisstotal=$valorissretido+$valoriss;
		mysql_query("UPDATE livro SET basecalculo='$basecalculo' , valoriss='$valoriss',  valorissretido='$valorissretido' ,valorisstotal='$valorisstotal'");
		$codlivro=base64_encode($livro->codigo);
		Mensagem("Livro gerado com sucesso!");
		
		NovaJanela("../livro/imprimir_controlearrec.php?livro=$codlivro");
	}else{
		Mensagem("Livro deste contribuinte neste período já foi gerado anteriormente. Informe outro contribuinte ou outra período");
	}	
	

	
?>