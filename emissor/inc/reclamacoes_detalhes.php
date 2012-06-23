<?php  
	include("../include/conect.php");
	$sql=mysql_query("
					SELECT 
					 especificacao, 
					 tomador_cnpj, 
					 tomador_email, 
					 rps_numero, 
					 rps_data, 
					 rps_valor, 
					 datareclamacao, 
					 responsavel, 
					 dataatendimento,
					 descricao
					FROM 
					 reclamacoes 
					WHERE 
					 codigo = '$codigo'
					");
	list($especificacao,$cnpj,$email,$nro,$data,$valor,$reclamacao,$responsavel,$atendimento,$descricao) = mysql_fetch_array($sql);
	$data = implode("/",array_reverse(explode("-",$data)));
	$reclamacao = implode("/",array_reverse(explode("-",$reclamacao)));
	$atendimento = implode("/",array_reverse(explode("-",$atendimento)));
?>
<table width="100%">
	<tr align="left">
		<td>Especificação:</td>
		<td><?php echo $especificacao; ?></td>
	</tr>
	<tr align="left">
		<td>Descrição:</td>
		<td><?php echo $descricao; ?></td>
	</tr>
	<tr align="left">
		<td>CPF/CNPJ do tomador:</td>
		<td><?php echo $cnpj; ?></td>
	</tr>
	<tr align="left">
		<td>E-mail do Tomador:</td>
		<td><?php echo $email; ?></td>
	</tr>
	<tr align="left">
		<td>N° do RPS/NFe:</td>
		<td><?php echo $nro; ?></td>
	</tr>
	<tr align="left">
		<td>Data do RPS/NFe:</td>
		<td><?php echo $data; ?></td>
	</tr>
	<tr align="left">
		<td>Valor do RPS/NFe:</td>
		<td><?php echo "R$ ".$valor; ?></td>
	</tr>
	<tr align="left">
		<td>Data da Reclamação:</td>
		<td><?php echo $reclamacao; ?></td>
	</tr>
	<tr align="left">
		<td>Responsável:</td>
		<td><?php echo $responsavel; ?></td>
	</tr>
	<tr align="left">
		<td>Atendimento:</td>
		<td><?php echo $atendimento; ?></td>
	</tr>
</table>