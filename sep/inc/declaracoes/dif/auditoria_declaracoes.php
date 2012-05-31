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
	//conecta ao banco
	require_once('../conect.php');
	require_once('../../funcoes/util.php');

    $codempreiteira = $_GET['cmbInstFinanceira'];
    $query = ("SELECT codigo,
               DATE_FORMAT(data,'%d/%m/%Y') AS data,
               DATE_FORMAT(competencia, '%Y/%m') AS competencia,
               codverificacao
               FROM dif_des
               WHERE codinst_financeira = '$codempreiteira'
               ORDER BY competencia DESC");

	$sql_decc = Paginacao($query,'frmAuditoria','divauditoria',10);
	if(mysql_num_rows($sql_decc)){
?>
        <table width="100%">
            <tr bgcolor="#999999">
                <td width="320px" align="center">Código de Verificação</td>
                <td width="80px" align="center">Data Gerado</td>
                <td width="80px" align="center">Competencia</td>
                <td width="" align="center">Ações</td>
            </tr>
            <?php
                $cont = 1;
                while(list($codigo,$data_gerado, $competencia, $codverificacao) = mysql_fetch_array($sql_decc)){
                    ?>
                    <tr bgcolor="#FFFFFF">
                        <td align="left"><?php echo $codverificacao;?></td>
                        <td align="center"><?php echo $data_gerado;?></td>
                        <td align="center"><?php echo $competencia;?></td>
                        <td align="center">
                            <input name="btAuditar" type="button" value="Auditar" class="botao"
                            onClick="document.getElementById('hdCodSolicitacao').value=<?php echo $codigo;?>;
                            acessoAjax('inc/instfinanceiras/auditar.php','frmAuditoria','divauditoria')">
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
                    <tr>
                        <td align=\"center\"><b>Não há declarações de Instituições Financeiras</b></td>
                    </tr>
                ";
            }//fim if

         ?>
<!--if($_GET['btAuditar']=="Auditar"){
             include("inc/empreiteiras/auditar.php");
         }-->