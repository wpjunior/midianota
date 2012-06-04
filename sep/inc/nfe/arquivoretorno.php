<?php
/**
 * classe para ler o arquivo de retorno enviado pelo banco
 * 
 * @author Jean Farias Roldao
 */
class ArquivoRetorno {
	function codigoGuiaPeloNossonumero($nossonumero){
		$sql = mysql_query("SELECT codigo FROM guia_pagamento WHERE nossonumero = '$nossonumero' ");
		if (mysql_num_rows($sql) == 0) {
			return false;
		}
		list($cod_guia) = mysql_fetch_array($sql);
		return $cod_guia;
	}
	
	function registrarPagamentoGuia($codguia) {
		
		mysql_query("UPDATE guia_pagamento SET pago = 'S' WHERE codigo = '$codguia'");
		
		$sql_codguia = mysql_query("
			SELECT 
				codrelacionamento 
			FROM 
				guias_declaracoes
			WHERE 
				codguia = '$codguia' AND 
				relacionamento = 'nfe'
		");
		
		while (list($cod_nota) = mysql_fetch_array($sql_codguia) ){
			//echo "$codguia - $cod_nota<br>";
			mysql_query("UPDATE notas SET estado = 'E' WHERE codigo = '$cod_nota'");
		}
		return mysql_num_rows($sql_codguia);
	}
	
	function registrarPagamentoManual($nossonumero, $valor){
		$valor = MoedaToDec($valor);
		$sql = mysql_query("SELECT codigo FROM guia_pagamento WHERE nossonumero = '$nossonumero' AND valor = $valor");
		if (mysql_num_rows($sql) == 0) {
			return false;
		} else {
			list($cod_guia) = mysql_fetch_array($sql);
			return self::registrarPagamentoGuia($cod_guia);
		}
	}
	
	function lerTxtRetorno($arquivo_txt_upload){
		$arquivo_txt = $_FILES[$arquivo_txt_upload];
		//pega o endereco da pasta para guardar o aruivo de retorno
		$target_path = dirname(__FILE__)."/arquivosretorno/";
		
		if (!is_dir($target_path)) {
			mkdir($target_path);
		}
		
		//monta o endereco onde vai ficar os arquivos de retorno
		$target_path = $target_path . basename( $arquivo_txt['name']); 
		$arquivo = $target_path;
		
		if (move_uploaded_file($arquivo_txt['tmp_name'], $target_path)) {
			//echo "The file ".  basename( $arquivo_txt['name']). " has been uploaded";
			//echo "Sucesso!";
		} else {
			echo "Ocorreu um erro durante o upload, favor tentar novamente!";
			//se ocorrer um erro para o script
			return;
		}
		
		//le o arquivo em forma de array
		$arq_array = file($target_path);
		
		//tira a primeira linha que é a identificacao do banco
		$dados_banco = array_shift($arq_array);
		
		//tira a ultima que nao sei para que serve
		$dados_foot = array_pop($arq_array);
		
		$total_guias = count($arq_array);
		
		$cont_guias = 0;
		
		$cont_notas = 0;
		
		foreach ($arq_array as $lin) if ($lin) {
			//o nosso numero esta na posisao 56 e tem 25 caracteres de tamanho
			$nossonumero = substr($lin,56,25);
			$cod_guia = self::codigoGuiaPeloNossonumero($nossonumero);
			
			//conta as guias atualizadas com sucesso
			$reg_guias = self::registrarPagamentoGuia($cod_guia);
			
			if ($reg_guias > 0) {
				$cont_guias++;
			}
			
			$cont_notas += $reg_guias;
		
		}
		//echo "<br>{$cont_guias}/{$total_guias} guias pagas <br>{$cont_notas} notas escrituradas";
		
		//retorna um resumo da operacao de leitura do arquivo
		return array(
			'guias' 		=> $cont_guias,
			'total_guias'	=> $total_guias,
			'notas'		=> $cont_notas
		);
	}
}
?>
