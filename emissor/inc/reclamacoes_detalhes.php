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
		<td>Nº do RPS/NFe:</td>
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