<?php

session_name("emissor");
session_start();
$login = $_SESSION['login'];
$campo = tipoPessoa($login);
$sql = mysql_query("UPDATE notas SET estado = 'C', motivo_cancelamento = '$txtMotivoCancelar' WHERE codigo = '$txtCodigo'");

$sql = mysql_query("
 SELECT notas.tomador_email,notas.numero,notas.rps_numero,cadastro.nome,cadastro.$campo,DATE_FORMAT(notas.datahoraemissao,'%d/%m/%Y %h:%i:%s'),notas.codverificacao,cadastro.email 
 FROM notas 
 INNER JOIN cadastro ON notas.codemissor = cadastro.codigo 
 WHERE notas.codigo = '$CODIGO'");

list($email, $num_nota, $num_rps, $nome_empresa, $cpfcnpf_empresa, $dataehora, $codverificacao, $empresa_email) = mysql_fetch_array($sql);

$msg = "Comunicamos que a NFE com os seguintes dados foi cancelada pela empresa prestadora de serviço: <br><br>
	- Número da nota: $num_nota;<br>
	- Com data e hora de emissão de: $dataehora ;<br>
	- Código de verificação: $codverificacao ;<br>
	- RPS Número: $num_rps <br>	
	- Prestador de serviço: $nome_empresa ;<br>
	- CPF/CNPJ do prestador de serviço: $cpfcnpf_empresa ;<br>  ";


$assunto = "$nome_empresa (NF-e $PREFEITURA).";

$headers = "MIME-Version: 1.0\r\n";

$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

$headers .= "From: $empresa_email \r\n";

$headers .= "Cc: \r\n";

$headers .= "Bcc: \r\n";

@mail("$email", $assunto, $msg, $headers);

add_logs('Cancelou nota');
print("<script language=JavaScript>
			alert('Nota cancelada com sucesso!');						
 		</script>");



