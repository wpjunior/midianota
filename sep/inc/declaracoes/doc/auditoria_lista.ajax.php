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
<fieldset>
<?php
	//conecta aos principais arquivos
	require_once("../conect.php");
	require_once("../../funcoes/util.php");
	
	$codigo = $_GET['cmbOperadoras'];
    $query = ("
        SELECT 
            doc_des.codigo, 
			doc_des.codverificacao,
            operadoras_creditos.razaosocial, 
            DATE_FORMAT(doc_des.data,'%d/%m/%Y'), 
            DATE_FORMAT(doc_des.competencia,'%d/%d/%Y')
        FROM 
            doc_des
        INNER JOIN 
            operadoras_creditos ON operadoras_creditos.codigo = doc_des.codopr_credito
		WHERE
			operadoras_creditos.codigo = '$codigo'
        ORDER BY 
            doc_des.codigo
        DESC						
    ");
	$sql_operadora = Paginacao($query,'frmAudDoc','divauditoriadoc',15);
    if(mysql_num_rows($sql_operadora)){
    ?>
<table width="100%">
    <tr bgcolor="#999999">
        <td width="688" align="center">Cod. de verificação</td>
        <td width="197" align="center">Data Gerado</td>
        <td width="143" align="center">Competencia</td>
        <td width="111" align="center">Ações</td>
    </tr>
    <?php
        $cont = 1;
        while(list($codigo,$codverificacao,$razao,$data_gerado,$competencia) = mysql_fetch_array($sql_operadora)){

        ?>
    <tr bgcolor="#FFFFFF">
        <td align="center"><?php echo $codverificacao;?></td>
        <td align="center"><?php echo $data_gerado;?></td>
        <td align="center"><?php echo $competencia;?></td>
        <td align="center">
        	<input name="btAuditar" id="btAuditar" type="button" value="Auditar" class="botao" 
            onClick="document.getElementById('hdCodSolicitacao').value=<?php echo $codigo;?>;
            acessoAjax('inc/operadorascreditos/auditoria_visualizar.ajax.php','frmAudDoc','divauditoriadoc');">
        </td>
    </tr>
    <?php
	        }//fim while
	?>
    <input name="hdCodSolicitacao" id="hdCodSolicitacao" type="hidden">
</table>
        <?php
    }else{
        echo "
			<table width=\"100%\">
				<tr>
					<td align=\"center\"><b>Não há declarações de Cartórios</b></td>
				</tr>
			</table>
        ";
    }//fim if
    ?>
</fieldset>
