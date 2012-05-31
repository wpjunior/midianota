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
<fieldset><legend>Resultado</legend>
	<?php
	require_once("../conect.php");
	require_once('../../funcoes/util.php');
	
	$nome=$_GET['txtNome'];
	$compmes=$_GET['cmbMes'];
	$compano=$_GET['cmbAno'];
	
	$str_where= "";
	//cria uma array com os filtros existentes e implode usando AND
	
if($nome){
	$str_where[]="nome LIKE '$nome' OR razaosocial LIKE '$nome'";
}
if($compmes){
	$str_where[]= "MONTH(dop_des.competencia) = '$compmes'";
}
if($compano){
	$str_where[]= "YEAR(dop_des.competencia) = '$compano'";
}
if($str_where){
	$str_where="WHERE ".implode($str_where," AND ");
}
	
	$query=("
		SELECT 
			dop_des.codigo, 
			orgaospublicos.razaosocial, 
			DATE_FORMAT(dop_des.data_gerado,'%d/%m/%Y'), 
			DATE_FORMAT(dop_des.competencia, '%m/%Y')
		FROM 
			dop_des
		INNER JOIN 
			orgaospublicos ON orgaospublicos.codigo = dop_des.codorgaopublico
		$str_where
		ORDER BY 
			dop_des.competencia
		DESC						
	");
	$sql=Paginacao($query,'frmDOP','divResultado',10);
	if(mysql_num_rows($sql)){?>
		<table width="100%">
			<tr bgcolor="#999999">
				<td width="50px" align="right">cod</td>
				<td width="320px" align="center">Razão</td>
				<td width="80px" align="center">Data Gerado</td>
				<td width="80px" align="center">Competencia</td>
				<td width="" align="center">Ações</td>
			</tr>
			<?php
				$cont = 1;
				while(list($codigo,$razao,$data_gerado, $competencia) = mysql_fetch_array($sql)){
	
				?>
				<tr bgcolor="#FFFFFF">
					<td width="50px" align="right"><?php echo $codigo; ?></td>
					<td width="320px" align="left"><?php echo $razao;?></td>
					<td width="80px" align="center"><?php echo $data_gerado;?></td>
					<td width="80" align="center"><?php echo $competencia;?></td>
					<td align="center">
					<input name="btAuditar" id="btAuditar" type="submit" value="Auditar" class="botao" 
					onClick="document.getElementById('hdCodSolicitacao').value=<?php echo $codigo;?>;
					acessoAjax('inc/orgaospublicos/auditar.ajax.php','frmDOP','divResultado')">
					</td>
				</tr>
				<tr>
					<td></td>
				</tr>
				<?php
				}//fim while
				?>
		</table>
		</div>
		<?php
	}else{
		echo "
			<table width='100%'>
				<tr>
					<td align=\"center\"><b>Não há declarações para auditar em Orgãos Públicos</b></td>
				</tr>
			</table>
		";
	}//fim if
	?>
</fieldset>