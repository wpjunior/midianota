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
//trata as letras acentuadas para nao causar erros, 
//serve se tiver comparacao de strings com acentuacao,
//assim reduz muita a chance de dar um erros,
//e isso esta aki no util porque tem que estar em todas as paginas
setlocale(LC_CTYPE, 'pt_BR');

function ResumeString($var,$quantidade){
	$string = substr(trim($var),0,$quantidade);
	if(strlen(trim($var)) > $quantidade){
		$string .= "...";
	}
	return $string;
}

// verifica se e cpf ou se e cnpj
function tipoPessoa($cnpjcpf){
    if(strlen($cnpjcpf)==14){
        $campo="cpf";
    }elseif(strlen($cnpjcpf)==18){
        $campo="cnpj";
    }
    return $campo;
}

// escapa as aspas e apostrofes e retira todas as tags html
function trataString($texto){
    return addslashes(strip_tags(trim($texto)));
}


// Alert
function Mensagem($texto){
	echo "<script type=\"text/javascript\">
			alert('$texto');
		  </script>";
}

/**
 * window.alert() que seja executado apos o onload do script
 * @param $texto
 */
function Mensagem_onload($texto){
	echo "<script type=\"text/javascript\">
			msg_alert('$texto');
		  </script>";
}


//Parent.Location  
function Redireciona($url){
	echo "<script type=\"text/javascript\">
			parent.location='$url';
		  </script>";
}

//Parent.close
function FecharJanela(){
	echo "<script type=\"text/javascript\">
			parent.close();
		  </script>";
}
  
function campoHidden($nome,$valor){
	echo "<input type=\"hidden\" name=\"$nome\" id=\"$nome\" value=\"$valor\">\n";
}

//Entra no formato DD/MM/AAAA e sai AAAA-MM-DD
function DataMysql($data){
	return implode('-',array_reverse(explode('/',$data)));
}
  

//Entra no formato AAAA-MM-DD  e sai DD/MM/AAAA  
function DataPt($data){
	return implode('/',array_reverse(explode('-',$data)));
}

function DataVencimento() {
	$dias_prazo = 5;
	return date("Y-m-d", time() + ($dias_prazo * 86400));
}
// funcao pra converter de moeda pra decimal
function MoedaToDec($valor){
	$valor = str_replace(".","",$valor);
	$valor = str_replace(",","",$valor);
	$valor = $valor/100;
	return $valor;
}

function DecToMoeda($valor){
	return number_format($valor, 2, ',', '.');
}

//gera nossonumero de acordo com o banco da prefeitura
function gerar_nossonumero($codigo){
	$sql_boleto = mysql_query("SELECT codbanco, IF(convenio <> '', convenio, codfebraban) FROM boleto");
	list($codbanco,$convenio)=mysql_fetch_array($sql_boleto);
	$vencimento = DataVencimento();
	$vencimento = DataMysql($vencimento);
	$vencimento = str_replace("-","","$vencimento");
	
	
		$numero = $codigo;
		while(strlen($numero)< 13)
			$numero = 0 . $numero;
		$nossonumero = $vencimento.$convenio.$numero;
	
	return $nossonumero;
}

//gera chavecontroledoc
function gerar_chavecontrole($cod_des,$cod_guia){
	$chavenum = rand(10,99);
	$cod_des_guia = $cod_des;
	while(strlen($cod_des_guia)< 4)
		$cod_des_guia = 0 . $cod_des_guia;
	$cod_doc = $cod_guia;
	while(strlen($cod_doc)< 4)
		$cod_doc = 0 . $cod_doc;
	$chavecontroledoc = $chavenum.$cod_des_guia.$cod_doc; 
	return $chavecontroledoc;
}

function diasDecorridos($dataInicio,$dataFim){
	//define data inicio
	$dataInicio = explode("/",$dataInicio);
	$ano1 = $dataInicio[2];
	$mes1 = $dataInicio[1];
	$dia1 = $dataInicio[0];
	
	//define data fim
	$dataFim = explode("/",$dataFim);
	$ano2 = $dataFim[2];
	$mes2 = $dataFim[1];
	$dia2 = $dataFim[0];
	
	//calcula timestam das duas datas
	$timestamp1 = mktime(0,0,0,$mes1,$dia1,$ano1);
	$timestamp2 = mktime(0,0,0,$mes2,$dia2,$ano2);
	
	//diminue a uma data a outra
	$segundos_diferenca = $timestamp2 - $timestamp1;
	//echo $segundos_diferenca;
	
	//converte segundos em dias
	$dias_diferenca = $segundos_diferenca / (60 * 60 * 24);
	
	//tira os decimais aos dias de diferenca
	$dias_diferenca = floor($dias_diferenca);
	
	return $dias_diferenca; 
}

//GERA O CÓDIGO DE VERIFICAÇÃO
function gera_codverificacao(){
	$CaracteresAceitos = 'ABCDEFGHIJKLMNOPQRXTUVWXYZ';
	$max = strlen($CaracteresAceitos)-1;
	$codverificacao = null;
	for($i=0; $i < 8; $i++) {
		$codverificacao .= $CaracteresAceitos{mt_rand(0, $max)}; 
		$carac = strlen($codverificacao); 
		if($carac ==4)
			$codverificacao .= "-";
	}
	return $codverificacao;
}

function calculaMultaDes($diasDec,$valor){
	$sql_multas = mysql_query(" 
					SELECT 
						codigo, 
						dias, 
						multa, 
						juros_mora
					FROM 
						des_multas_atraso 
					WHERE 
						estado='A'
					ORDER BY 
						dias 
					ASC
				");
	$nroMultas = mysql_num_rows($sql_multas);
	$n = 0;
	while(list($multa_cod, $multa_dias, $multa_valor, $multa_juros) = mysql_fetch_array($sql_multas)){
		$multadias[$n] = $multa_dias;
		$multavalor[$n] = $multa_valor;
		$multajuros[$n] = $multa_juros;
		$n++;
	}
	if($diasDec>0)
		$multa = 0;
	else
		$multa = -1;
		
	for($c=0;$c < $nroMultas; $c++){
		if($diasDec>$multadias[$c]){
			$multa = $c;	
			if($multa<$nroMultas-1)
				$multa++;
		}//end if
	}//end for

	if($multa>=0){
		$jurosvalor = $valor*($multajuros[$multa]/100);
		$multatotal = $jurosvalor + $multavalor[$multa];
		$totalpagar = $multatotal + $valor;
		return $multatotal;
	}
	else{
		return "";
	}
}

function listaRegrasMultaDes(){
	//pega o dia pra tributacao do mes da tabela configucacoes
	$sql_data_trib = mysql_query("SELECT data_tributacao FROM configuracoes");
	
	list($dia_mes)=mysql_fetch_array($sql_data_trib);
	campoHidden("hdDia",$dia_mes);
	//echo "<input type=\"hidden\" name=\"hdDia\" id=\"hdDia\" value=\"$dia_mes\" />";
	
	$dataatual = date("d/m/Y");
	campoHidden("hdDataAtual",$dataatual);
	//echo "<input type=\"hidden\" name=\"hdDataAtual\" id=\"hdDataAtual\" value=\"$dataatual\" />\n";
	//pega a regra de multas do banco
	$sql_multas = mysql_query(" SELECT codigo, dias, multa, juros_mora
								FROM des_multas_atraso 
								WHERE estado='A'
								ORDER BY dias ASC");
	$nroMultas = mysql_num_rows($sql_multas);
	echo "<input type=\"hidden\" name=\"hdnroMultas\" id=\"hdNroMultas\" value=\"$nroMultas\" />\n";
	$n = 0;
	while(list($multa_cod, $multa_dias, $multa_valor, $multa_juros) = mysql_fetch_array($sql_multas)){
		campoHidden("hdMulta_dias$n",$multa_dias);
		campoHidden("hdMulta_valor$n",$multa_valor);
		campoHidden("hdMulta_juros$n",$multa_juros);
		$n++;
	}
}


function DataPtExt(){
	$s = date("D");   //pega dia da semana em ingles
	$dia = date("d"); //pega dia do mes
	$m = date("n");   //pega o mes em numero
	$ano = date("Y"); //pega o ano atual
	$semana = array("Sun" => "Domingo", "Mon" => "Segunda-feira", "Tue" => "Terça-feira", "Wed" => "Quarta-feira", "Thu" => "Quinta-feira", "Fri" => "Sexta-feira", "Sat" => "Sábado"); 
	/* Dias da Semana.  troca o valor da semana em ingles para portugues*/
	$mes = array(1 =>"Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"); 
	/* Meses troca o valor de numero pelo seu valor por extenso*/
	return $semana[$s].", ".$dia." de ".$mes[$m]." de ".$ano; //imprime na tela a data concatenada por extenso  
}//by lucas.

function print_array($array){
	echo '<div align="left"><pre>';
	print_r($array);
	echo '</pre></div>';
}//print_r com pre e alinhamento

function codcargo($cargo){
	$sql_cargo = mysql_query("SELECT codigo FROM cargos WHERE cargo LIKE '$cargo'");
	return mysql_result($sql_cargo,0);
}//pega o codigo do cargo solicitado de acordo com o banco

function codtipo($tipo){
	$sql_cargo = mysql_query("SELECT codigo FROM tipo WHERE tipo LIKE '$tipo'");
	return mysql_result($sql_cargo,0);
}//pega o codigo do tipo solicitado de acordo com o banco

function coddeclaracao($dec){
	$sql_cargo = mysql_query("SELECT codigo FROM declaracoes WHERE declaracao LIKE '$dec'");
	return mysql_result($sql_cargo,0);
}//pega o codigo do tipo solicitado de acordo com o banco

function verificacampo($campo){
	if($campo == ""){$campo = "<b>Não Informado</b>";}
return $campo;
}//verifica o resultado do banco se esta vazio, se estiver, acrescenta informação

//redireciona para o link indicado sem os parametros de get adicionais
//e criando um form com hiddens baseado nos parametros de get
function RedirecionaPost($url,$target=NULL){
	if($target==NULL)$target="_parent";
	$url_full=explode("?",$url,2);
	$action=$url_full[0];
	$post_vars=explode("&",$url_full[1]);
	$redir="<form name='redirPost' id='redirPost' action='$action' method='post' target='$target'>";
	foreach($post_vars as $var){
		list($var_name,$var_value)=explode("=",$var,2);
		$redir.="<input type='hidden' name='$var_name' value='$var_value' />";
	}
	$redir.="</form>";
	$redir.="<script>document.getElementById('redirPost').submit();</script>";
	echo $redir;
}//fim function RedirecionaPost()


function Uploadimagem($campo,$destino,$cod=NULL,$redimensionar=NULL){
	if($campo != ""){
		//Mensagem($_FILES[$campo]['type']);
		//pega o nome da imagem
		$imagem['nome'] = $_FILES[$campo]['name'];
		//pega o nome temporario
		$imagem['temp'] = $_FILES[$campo]['tmp_name'];
		
		$imagem['destino'] = $destino;
		
		//especifica  quais extensoes serao permitidas
		$extpermitidas = array("jpg","JPG","jpeg","JPEG","gif","GIF","png","PNG");
		$imagem['extensao'] = strtolower(end(explode('.', $_FILES[$campo]['name'])));
		//varre o array verificando se a variavel extensao entra na condicional
		if(array_search($imagem['extensao'], $extpermitidas) === false){
			Mensagem("Por favor, envie arquivos com as seguintes extensões: jpeg, jpg, gif");
		}else{
			//Verifica qual metodo de upload veio pelo parametro
			if($cod == "rand"){
				$rand = rand(00000,99999);
				$imagem['nome'] = $rand.".".$imagem['extensao'];
			}elseif($cod){	
				$imagem['nome'] = $cod.".".$imagem['extensao'];
			}
			//move o arquivo para o destino informado
			if($redimensionar == 1){
				list($w,$h) = getimagesize($_FILES[$campo]['tmp_name']);
				if(($w<=100)&&($h<=100)){
					$destiny = $destino.$imagem['nome'];
					//resize($_FILES[$campo],$destiny);
				}else{
					return NULL;
				}	
			}else{
				move_uploaded_file($imagem['temp'],$imagem['destino'].$imagem['nome']);
			}	
			return $imagem['nome'];
		}
	}else{
		Mensagem("Campo vazio!");
	}
}


function UploadGenerico($destino,$campo,$extensoes=NULL){
	// Pasta onde o arquivo vai ser salvo
	$array_upload['pasta'] = $destino;
	 
	// Tamanho maximo do arquivo (em Bytes)
	$array_upload['tamanho'] = 1024 * 1024 * 2; // 2Mb limite do propio php
	 
	 //testa se a variavel extensoes recebeu algum valor se tiver valor recebe esse valor no array
	 if($extensoes){
		// Array com as extensoes permitidas
		$array_upload['extensoes'] = explode("|",$extensoes);
	}//fim if
	 
	// Array com os tipos de erros de upload do PHP
	$array_upload['erros'][0] = 'Não houve erro';
	$array_upload['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
	$array_upload['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
	$array_upload['erros'][3] = 'O upload do arquivo foi feito parcialmente';
	$array_upload['erros'][4] = 'Não foi feito o upload do arquivo';
	 
	// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
	if($_FILES[$campo]['error'] != 0) {
		Mensagem("Não foi possível fazer o upload, erro: ". $array_upload['erros'][$_FILES[$campo]['error']]);
		exit; // Para a execucao do script
	}//fim if
	
	// Se a varivel vinda por parametro tiver valor, faz a verificacao da extensao do arquivo
	 if($array_upload['extensoes']){
		$extensao = strtolower(end(explode('.', $_FILES[$campo]['name'])));
		//varre o array verificando se a variavel extensao entra na condicional
		if(array_search($extensao, $array_upload['extensoes']) === false){
			Mensagem("Por favor, envie arquivos com as seguintes extensões: ". str_replace("|",", ",$extensoes));
		}//fim if
	
	 
		// Faz a verificacao do tamanho do arquivo
		elseif($array_upload['tamanho'] < $_FILES[$campo]['size']){
			Mensagem("O arquivo enviado é muito grande, envie arquivos de até 2Mb.");
		}else{ 
			// O arquivo passou em todas as verificações, agora tenta movelo para a pasta
			//acrescenta numeros randomicos ao nome do arquivo
			$rand = rand(00000,99999);
			$ext = explode(".",$_FILES[$campo]['name']);
			$nome_final = $rand.".".$ext[1];
			
			// Depois verifica se e possível mover o arquivo para a pasta escolhida
			if(move_uploaded_file($_FILES[$campo]['tmp_name'], $array_upload['pasta'] .$nome_final)){
				//se tudo der certo retorna o nome do arquivo que foi salvo no diretorio informado
				return $nome_final;
			}else{
			// Não foi possível fazer o upload, provavelmente a pasta está incorreta
			Mensagem("Não foi possível enviar o arquivo, tente novamente");
			}//fim else
		}//fim else
	}//fim if
}

function Paginacao($query,$form,$retorno,$quant=NULL,$test=false){// $test é para os botoes
	if($_GET["hdPagina"]&&$_GET["hdPrimeiro"]){
		$pagina = $_GET["hdPagina"];
	}else{
		$pagina = 1;
	}
	
	//testa se a variavel de quantidade por pagina estiver vazia ela recebera o valor de 10
	if(!isset($quant)){
		$quant = 10;
	}
	
	//Executa o sql que foi enviado por parametro para que se possa fazer os calculos de paginas e quantidade
	$sql_pesquisa = mysql_query("$query");
	

	//Verifica se há erros de sintaxe
	if(!$sql_pesquisa){ 
		return $sql_pesquisa;
	}
	
	$quantporpagina = $quant;	                        //Define o limite de resultados por pagina
	$total_sql      = mysql_num_rows($sql_pesquisa);    //Recebe o total de resultados gerados pelo sql
	$total_paginas  = ceil($total_sql/$quantporpagina); //Usa o total para calcular quantas paginas de resultado tera a pesquisa sql
	
	//Verifica se não tem a variavel pagina, ou se ela é menor que o total ou se ela é menor que 1
	if((!isset($pagina)) || ($pagina > $total_paginas) || ($pagina < 1)){
		$pagina = 1;
	}
	
	$pagina_sql = ($pagina-1)*$quantporpagina;          //Calcula a variavel que vai ter o incio do limit
	$pagina_sql .= ",$quantporpagina";                  //Concatena a quantidade de paginas escolhida com o inicio do limit do sql
	
	//Sql buscando as informações e o limit estipulado pela função
	$sql_pesquisa = mysql_query("$query LIMIT $pagina_sql");
	if(!$sql_pesquisa){ 
		return $sql_pesquisa;
	}
	
	//Aqui identifica em qual arquivo está localizado para que o ajax possa voltar para o mesmo
	$arquivo = $_SERVER['PHP_SELF'];
	
	$GLOBALS['pagina']=$pagina;
	//Monta a table com os botoes onde chamou a função
	if(mysql_num_rows($sql_pesquisa)>0){
		$botoes= "
		<table width=\"100%\">
			<tr>
				<td align=\"center\">
					<b>";if($total_sql == 1){ $botoes.= "1 Resultado";}else{ $botoes.= "$total_sql Resultados";} $botoes.= ", página: $pagina de $total_paginas</b>
					<input type=\"button\" name=\"btAnterior\" value=\"Anterior\" class=\"botao\" 
					onclick=\"document.getElementById('hdPrimeiro').value=1;
					mudarpagina('a','hdPagina','$arquivo','$form','$retorno');\" "; if($pagina == 1){ $botoes.= "disabled = disabled";} $botoes.= " />
					<input type=\"button\" name=\"btProximo\" value=\"Próximo\" class=\"botao\" 
					onclick=\"document.getElementById('hdPrimeiro').value=1;
					mudarpagina('p','hdPagina','$arquivo','$form','$retorno');\" "; if($pagina == $total_paginas){ $botoes.= "disabled = disabled";} $botoes.= " />
					<input type=\"hidden\" name=\"hdPagina\" id=\"hdPagina\" value=\"$pagina\" />
					<input type=\"hidden\" name=\"hdPrimeiro\" id=\"hdPrimeiro\" />
				</td>
			 </tr>
		</table>";
	}//fim if se existe resultado
	
	if($test==false){//test para botar os botoes direto com echo ou passar para uma array com o return
		echo $botoes;
		return $sql_pesquisa;
	}else{
		$return['sql']=$sql_pesquisa;
		$return['botoes']=$botoes;
		return $return;
	}
		
		
}//fim function Paginacao()

/**
*funcao UltDiaUtil
*@param $mes = mes no formato de numero
*@param $ano = o numero do ano atual ou o que for desejado
*@return Ultimo dia util do mes subsequente e ano informados
*/
function UltDiaUtil($mes,$ano){
  	//$mes = date("m");
  	//$ano = date("Y");
	$mes = $mes + 1;
	while($mes > 12){
		$mes -= 12;
		$ano = $ano + 1;
	}
  	$dias = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
  	$ultimo = mktime(0, 0, 0, $mes, $dias, $ano); 
  	$dia = date("j", $ultimo);
  	$dia_semana = date("w", $ultimo);
  
  	// domingo = 0;
  	// sÃ¡bado = 6;
  	// verifica sÃ¡bado e domingo
  
  	if($dia_semana == 0){
    	$dia--;
		$dia--;
  	}
  	if($dia_semana == 6){
    	$dia--;
	}
  	
	$ultimo = mktime(0, 0, 0, $mes, $dia, $ano);

	/*
	switch($dia_semana){  
		case"0": $dia_semana = "Domingo";       break;  
		case"1": $dia_semana = "Segunda-Feira"; break;  
		case"2": $dia_semana = "TerÃ§a-Feira";   break;  
		case"3": $dia_semana = "Quarta-Feira";  break;  
		case"4": $dia_semana = "Quinta-Feira";  break;  
		case"5": $dia_semana = "Sexta-Feira";   break;  
		case"6": $dia_semana = "SÃ¡bado";        break;  
	}
	*/

  return date("Y-m-d", $ultimo);
}

function imprimirGuia($codguia,$pasta=NULL,$mesmajanela=NULL){
	if($pasta === true){
		$pasta = '../';
	}
	
	$codguia=base64_encode($codguia);
	$sql_tipo_boleto=mysql_query("SELECT tipo FROM boleto");
	$result=mysql_fetch_object($sql_tipo_boleto);
	if($mesmajanela==true){
		if($result->tipo =="R"){
		
			echo "<script>window.location = ('{$pasta}../boleto/recebimento/index.php?COD=$codguia')</script>";	
		}else{
			echo "<script>window.location = ('{$pasta}../boleto/pagamento/$boleto?COD=$codguia')</script>";
		}
		exit;
	}else{
		if($result->tipo =="R"){
			echo "<script>window.open('{$pasta}../boleto/recebimento/index.php?COD=$codguia')</script>";	
		}else{
			echo "<script>window.open('{$pasta}../boleto/pagamento/$boleto?COD=$codguia')</script>";
		}
	}
}

function NovaJanela($url){
	echo "\n<script type=\"text/javascript\">
			window.open('$url');
		  </script>\n";
}
/**
 * funcao para pegar o ultima dia para o vencimento
 *
 */
function proximoDiaVencimento(){
	$dataemissao    = date("Y-m-20");
	$datavencimento = strtotime("$dataemissao +1 month");
	return date('Y-m-d',$datavencimento);
}


function notificaTomador($codigo_empresa,$ultimanota){
	$tomador_email_enviado = "";
	
	//Pega o link do site da prefeitura que foi inserido no banco
	$sql_url_site = mysql_query("SELECT site, cidade, email, secretaria, brasao  FROM configuracoes");
	list($LINK_ACESSO, $CONF_CIDADE, $CONF_EMAIL, $CONF_SECRETARIA, $CONF_BRASAO) = mysql_fetch_array($sql_url_site);
	
	//Busca a razao social da empresa que emitiu a nota
	$sql_dados_empresa = mysql_query("SELECT razaosocial FROM cadastro WHERE codigo = '$codigo_empresa'");
	list($empresa_razaosocial) = mysql_fetch_array($sql_dados_empresa);
	
	//Pega o codigo da nota e gera o link de acesso externo para que o tomador possa visualizar a nota
	$sql_codigo_nota = mysql_query("SELECT codigo, tomador_nome, tomador_email FROM notas WHERE codemissor = '$codigo_empresa' AND numero = '$ultimanota'");
	list($codigo_nota_visualizar, $tomador_nome, $tomador_email) = mysql_fetch_array($sql_codigo_nota);
	
	$crypto = base64_encode($codigo_nota_visualizar);
	$link = $_SERVER['HTTP_HOST']."/site/imprimir_nota.php?cod=$crypto";
	
	$imagemTratada = $_SERVER['HTTP_HOST']."/img/brasoes/".rawurlencode($CONF_BRASAO);
	$msg = ("
	<a href=\"$LINK_ACESSO\" style=\"text-decoration:none\" ><img src=\"$imagemTratada\" alt=\"Brasão Prefeitura\" title=\"Brasão\" border=\"0\" width=\"100\" height=\"100\" /></a><br><br>
	Este e-mail foi enviado, para notificar que a empresa ". strtoupper($empresa_razaosocial) .",<br>
	emitiu uma NF-e com ". strtoupper($tomador_nome) .", como tomador.<br>
	Abaixo segue o link para visualizar esta NF-e:<br>
	<br>
	<a href=\"$link\" target=\"blank\">$link</a><br><br>
	Caso o link não funcione copie e cole no navegador.<br>
	<br>
	$CONF_SECRETARIA de $CONF_CIDADE.
	");
	
	$assunto = "Notificação de emissão de NF-e.";

	$headers  = "MIME-Version: 1.0\r\n";

	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

	$headers .= "From: $CONF_SECRETARIA de $CONF_CIDADE <$CONF_EMAIL>  \r\n";

	$headers .= "Cc: \r\n";

	$headers .= "Bcc: \r\n";
	
	if(mail($tomador_email,$assunto,$msg,$headers)){
		$tomador_email_enviado = true;
	}
	
	return $tomador_email_enviado;
	
}
//resize($_FILES['input'],'img/logo.jpg',350);
function resize($arquivo,$caminho,$largura=NULL){
	list($w,$h) = getimagesize($arquivo['tmp_name']);
	if($largura !== NULL){
		$altura = ($largura*$h)/$w;
	}else{
		$largura = 100;
		$altura = 100;
	}
	$extension = end(explode('.', $arquivo['name']));
	switch($extension){
		case "JPEG":
		case "jpeg":
		case "JPG":
		case "jpg":
			$img = imagecreatefromjpeg($arquivo['tmp_name']);
			$nova = imagecreatetruecolor($largura,$altura);
			imagecopyresampled($nova,$img,0,0,0,0,$largura,$altura,$w,$h);
			imagejpeg($nova,$caminho,100);
			break;
		case "GIF":
		case "gif":
			$img = imagecreatefromgif($arquivo['tmp_name']);
			$nova = imagecreatetruecolor($largura,$altura);
			imagecopyresampled($nova,$img,0,0,0,0,$largura,$altura,$w,$h);
			imagegif($nova,$caminho);
			break;
		case "PNG":
		case "png":
			$img = imagecreatefrompng($arquivo['tmp_name']);
			$nova = imagecreatetruecolor($largura,$altura);
			imagecopyresampled($nova,$img,0,0,0,0,$largura,$altura,$w,$h);
			imagepng($nova,$caminho);
			break;
	}
	imagedestroy($img);
	imagedestroy($nova);
}

?>

