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
	//Conecta ao banco
	require_once('../../conect.php');
	require_once('../../../funcoes/util.php');
	
	//Recebe as variaveis enviadas pelo form por get
	$nome        = $_GET['txtNome'];
	$cnpj        = $_GET['txtCNPJ'];
	$compmes     = $_GET['cmbMes'];
	$compano     = $_GET['cmbAno'];
	$data        = $_GET['txtData'];
	$estado      = $_GET['cmbEstado'];
	$numero      = $_GET['txtNroDoc'];
	$cancelaDoc  = $_GET['hdCancelaDoc'];
	
	//se foi cancelada alguma declaração da o updade no banco e da um alert se der algum erro
	if($cancelaDoc){
		mysql_query("UPDATE doc_des SET estado = 'C' WHERE codigo = '$cancelaDoc'");
		add_logs('Atualizou uma Declaração: Cancelada');
	}//fim if cacela
	
	//verifica quais campos foram preenchidos e concatena na variavel str_where
	if($compmes){
		$str_where = " AND MONTH(doc_des.competencia) = '$compmes'";
	}
	if($compano){
		$str_where .= " AND YEAR(doc_des.competencia) = '$compano'";
	}
	if($data){
		$data = DataMysql($data);
		$str_where .= " AND doc_des.data = '$data'";
	}
	if($cnpj){
		$str_where .= " AND operadoras_creditos.cnpj = '$cnpj'";
	}
	if($estado){
		$str_where .= " AND doc_des.estado = '$estado'";
	}
	if($numero){
		$str_where .= " AND doc_des.codigo = '$numero'";
	}
	
	//Sql buscando as informações que o usuario pediu e com o limit estipulado pela função
	$query = ("
		SELECT
			doc_des.codigo, 
			DATE_FORMAT(doc_des.data,'%d/%m/%Y') as 'data',
			DATE_FORMAT(doc_des.competencia, '%m/%Y') as 'competencia',
			doc_des.estado,
			doc_des_contas.iss,
			operadoras_creditos.nome
		FROM
			doc_des 
		INNER JOIN
			cadastro as operadoras_creditos ON operadoras_creditos.codigo = doc_des.codopr_credito
		INNER JOIN
			doc_des_contas ON doc_des.codigo = doc_des_contas.coddoc_des
		INNER JOIN
			cadastro ON doc_des.codopr_credito = cadastro.codigo
		WHERE 
			(cadastro.nome LIKE '$nome%' OR cadastro.razaosocial LIKE '$nome%') $str_where
		GROUP BY
			codigo
		ORDER BY
			codigo
		DESC
		");
	$sql_pesquisa = Paginacao($query,'frmOperadoras','divDeclaracoesOperadoras',10);
if(mysql_num_rows($sql_pesquisa)){
?>
<table width="100%">
	<tr bgcolor="#999999">
    	<td width="7%" align="center">N&deg; Dec</td>
        <td width="38%" align="center">Nome</td>
        <td width="15%" align="center">Data</td>
        <td width="13%" align="center">Competencia</td>
        <td width="13%" align="center">Estado</td>
        <td width="14%" colspan="2" align="center"></td>
  </tr>
    <?php
		$x = 0;
		while($dados_pesquisa = mysql_fetch_array($sql_pesquisa)){
			//alterna o valor da variavel pelo seu valor por extenso
			switch($dados_pesquisa['estado']){
				case "B": $str_estado = "Boleto";      break;
				case "N": $str_estado = "Normal";      break;
				case "C": $str_estado = "Cancelada";   break;
				case "E": $str_estado = "Escriturada"; break;		
			}
			if($dados_pesquisa['estado'] == "C"){
				$bgcolor = "#FFAC84";
			}else{
				$bgcolor = "#FFFFFF";
			}
	?>
    <input type="hidden" name="txtCodigoGuia<?php echo $x;?>" id="txtCodigoGuia<?php echo $x;?>" value="<?php echo $dados_pesquisa['codigo'];?>" />
    <tr id="trDecc<?php echo $x;?>">
    	<td bgcolor="<?php echo $bgcolor;?>" align="center"><?php echo $dados_pesquisa['codigo'];?></td>
        <td bgcolor="<?php echo $bgcolor;?>" align="left"><?php echo $dados_pesquisa['nome'];?></td>
     	<td bgcolor="<?php echo $bgcolor;?>" align="center"><?php echo $dados_pesquisa['data'];?></td>
        <td bgcolor="<?php echo $bgcolor;?>" align="center"><?php echo $dados_pesquisa['competencia'];?></td>
        <td bgcolor="<?php echo $bgcolor;?>" align="center"><?php echo $str_estado;?></td>
<td bgcolor="#FFFFFF" align="left" colspan="2">&nbsp;
        	<label title="Ver Detalhes">
        		<input name="btDetalhesDecc" id="btLupa" type="button" class="botao" value="" 
            	onClick="VisualizarNovaLinha('<?php echo $dados_pesquisa['codigo'];?>','<?php echo"tddoc".$x;?>',this,'inc/declaracoes/doc/declarar_vizualizar.ajax.php')">
            </label>
            &nbsp;
            <?php if($dados_pesquisa['estado'] != "C"){?>
            <label title="Cancelar Declaração" id="lbCancelar<?php echo $x;?>">
            	<input name="btCancelarDoc" id="btX" type="button" class="botao" value=""
                onClick="return cancelarDeclaracao('<?php echo $dados_pesquisa['codigo'];?>','<?php echo $dados_pesquisa['nome'];?>','inc/declaracoes/doc/declarar_pesquisa.ajax.php','frmOperadoras','divDeclaracoesOperadoras','hdCancelaDoc');">
            </label>
            <?php }?>
        </td>
    </tr>
    <tr>
        <td id="<?php echo"tddoc".$x; ?>" colspan="7" align="center"></td>
    </tr>
    <?php
			$x++;
		}//fim while
	?>
    <input name="hdCodDelDoc" id="hdCodDelDoc" type="hidden">
</table>
<?php
}else{
	echo "<center><b>Não há resultados!</b></center>";
}

?>

