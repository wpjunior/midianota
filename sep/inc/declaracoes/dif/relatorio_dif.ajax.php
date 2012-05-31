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

    //recebe os dados
    $razaosocial=strip_tags(addslashes($_GET['txtRazao']));
    $cnpj=$_GET['txtCnpj'];
    $competencia=$_GET['cmbAno']."-".$_GET['cmbMes'];
    $estado=$_GET['cmbEstado'];
    $dataini=DataMysql($_GET['txtDataIni']);
    $datafim=DataMysql($_GET['txtDataFim']);

    // trata o range de data
    if(($dataini)&&($datafim)){
        $string="AND dif_des.data BETWEEN '$dataini' AND '$datafim'";
    }elseif(($dataini)&&(!$datafim)){
        $string="AND dif_des.data>='$dataini'";
    }elseif((!$dataini)&&($datafim)){
        $string="AND dif_des.data<='$datafim'";
    }else{
        $string="";
    }

    //trata a competencia
    if($competencia=="-"){
        $competencia="";
    }

    //faz a query e busca os dados com paginacao
    $query=("SELECT dif_des.codigo,
             dif_des.codverificacao,
             DATE_FORMAT(dif_des.data, '%d/%m/%Y') AS data,
             DATE_FORMAT(dif_des.competencia, '%Y/%m') AS competencia,
             dif_des.total,
             inst_financeiras.razaosocial
             FROM dif_des
             INNER JOIN inst_financeiras
             ON dif_des.codinst_financeira=inst_financeiras.codigo
             WHERE inst_financeiras.razaosocial LIKE '$razaosocial%'
             AND inst_financeiras.cnpj LIKE '$cnpj%'
             AND dif_des.competencia LIKE '$competencia%'
             $string
             ORDER BY dif_des.data DESC"); 
    $sql=Paginacao($query,'frmRelatorio','detalhes_dif_des',10);
    
    if(mysql_num_rows($sql)>0){
        ?>
            <table width="100%" align="center">
                <tr align="center" bgcolor="999999">
                    <td>Cód. de Verificação</td>
                    <td>Instituição Financeira</td>
                    <td>Data de Emissão</td>
                    <td>Competência</td>
                    <td>Valor Total</td>
                    <td>ISS</td>
                </tr>
                <?php
                    while($dados=mysql_fetch_array($sql)){
                        $sql_iss=mysql_query("SELECT SUM(iss) FROM dif_des_contas WHERE coddif_des='".$dados['codigo']."'");
                        list($iss)=mysql_fetch_array($sql_iss);

                        echo "
                            <tr align=\"center\" bgcolor=\"FFFFFF\">
                                <td>".$dados['codverificacao']."</td>
                                <td>".$dados['razaosocial']."</td>
                                <td>".$dados['data']."</td>
                                <td>".$dados['competencia']."</td>
                                <td>".$dados['total']."</td>
                                <td>$iss</td>
                            </tr>
                        ";
                    }
                ?>
            </table>
        <?php
    }
?>