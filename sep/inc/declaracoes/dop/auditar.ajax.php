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
include("../conect.php");
include("../../funcoes/util.php");

$cod_dop=$_GET['hdCodSolicitacao'];

$sql=mysql_query("
			SELECT 
				orgaospublicos.nome,
				orgaospublicos.razaosocial,
				orgaospublicos.cnpj,
				orgaospublicos.municipio,
				orgaospublicos.uf,
				DATE_FORMAT(dop_des.competencia,'%m/%Y'),
				DATE_FORMAT(dop_des.data_gerado,'%d/%m/%Y'),
				dop_des.total,
				dop_des.iss,
				dop_des.codverificacao,
				dop_des.estado
			FROM
				dop_des
			INNER JOIN orgaospublicos ON
				orgaospublicos.codigo=dop_des.codorgaopublico
			WHERE
				dop_des.codigo='$cod_dop'
			");


//lista os dados da declaracao e do oegao publico
list($nome,$razaosocial,$cnpj,$municipio,$uf,$competencia,$data,$total,$iss,$codverificacao,$estado)=mysql_fetch_array($sql);
switch($estado){
	case "N": $estado="Normal";break;
	case "C": $estado="Cancelada";break;
	case "B": $estado="Boleto";break;
	case "E": $estado="Escriturada";break;
}//fim switch
?>

<fieldset>
<legend>DOP</legend>
<table align="left">
	<tr>
		<td>Nome</td>
		<td><?php echo $nome; ?></td>
	</tr>
	<tr>
		<td>Razao Social</td>
		<td><?php echo $razaosocial; ?></td>
	</tr>
	<tr>
		<td>CNPJ</td>
		<td><?php echo $cnpj; ?></td>
	</tr>
	<tr>
		<td>Municipio</td>
		<td><?php echo $municipio; ?></td>
	</tr>
	<tr>
		<td>UF</td>
		<td><?php echo $uf; ?></td>
	</tr>
	<tr>
		<td>Compet&ecirc;ncia</td>
		<td><?php echo $competencia; ?></td>
	</tr>
	<tr>
		<td>Data da declara&ccedil;&atilde;o</td>
		<td><?php echo $data; ?></td>
	</tr>
	<tr>
		<td>Total</td>
		<td><?php echo "R$ ".DecToMoeda($total); ?></td>
	</tr>
	<tr>
		<td>ISS</td>
		<td><?php echo "R$ ".DecToMoeda($iss); ?></td>
	</tr>
	<tr>
		<td>Codigo de Verifica&ccedil;&atilde;o</td>
		<td><?php echo $codverificacao; ?></td>
	</tr>
	<tr>
		<td>Estado</td>
		<td><?php echo $estado; ?></td>
	</tr>
</table>
</fieldset>
<fieldset>
<legend>Notas declaradas</legend>
	<table>
		<tr bgcolor="#999999">
			<td>N° da nota</td>
			<td>Valor da nota</td>
			<td>Emissor</td>
			<td>Serviço</td>
		</tr>
		<?php
		$sql_notas=mysql_query("
							SELECT 
								servicos.descricao,
								dop_des_notas.valornota,
								dop_des_notas.nota_nro,
								emissores.nome
							FROM 
								dop_des_notas
							INNER JOIN 
								servicos ON servicos.codigo = dop_des_notas.codservico
							INNER JOIN
								emissores ON emissores.codigo=dop_des_notas.codemissor
							WHERE 
								coddop_des='$cod_dop'
							");
	
		while(list($servico, $valor, $nro, $emissor)=mysql_fetch_array($sql_notas)){
		?>
		<tr bgcolor="#FFFFFF">
			<td align="right"><?php echo $nro; ?></td>
			<td align="right"><?php echo "R$ ".DecToMoeda($valor); ?></td>
			<td><?php echo $emissor; ?></td>
			<td><?php echo $servico; ?></td>
		</tr>
		<?php
		}//fim while
		?>
	</table>
</fieldset>
