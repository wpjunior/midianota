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
        $string="AND cartorios_des.data_gerado BETWEEN '$dataini' AND '$datafim'";
    }elseif(($dataini)&&(!$datafim)){
        $string="AND cartorios_des.data_gerado>='$dataini'";
    }elseif((!$dataini)&&($datafim)){
        $string="AND cartorios_des.data_gerado<='$datafim'";
    }else{
        $string="";
    }

    //trata a competencia
    if($competencia=="-"){
        $competencia="";
    }

    //faz a query e busca os dados com paginacao
    $query=("SELECT cartorios_des.competencia,
             DATE_FORMAT(cartorios_des.data_gerado, '%d/%m/%Y') AS data,
             cartorios_des.total,
             cartorios_des.iss_emo AS iss,
             cartorios_des.codverificacao,
             cartorios_des.estado,
             cartorios_des.motivo_cancelamento AS motivo,
             cartorios.nome
             FROM cartorios_des
             INNER JOIN cartorios
             ON cartorios_des.codcartorio=cartorios.codigo
             WHERE cartorios.nome LIKE '$razaosocial%'
             AND cartorios.cnpj LIKE '$cnpj%'
             AND cartorios_des.competencia LIKE '$competencia%'
             AND cartorios_des.estado LIKE '$estado%'
             $string
             ORDER BY cartorios_des.data_gerado DESC");
    $sql=Paginacao($query,'frmRelatorio','detalhes_dec',10);

    if(mysql_num_rows($sql)>0){
        ?>
            <table width="100%" align="center">
                <tr align="center" bgcolor="999999">
                    <td>Cód. de Verificação</td>
                    <td>Cartório</td>                    
                    <td>Data de Emissão</td>
                    <td>Competência</td>
                    <td>Valor Total</td>
                    <td>ISS</td>
                    <td>Estado</td>
                    <td>Motivo Cancelamento</td>
                </tr>
               <?php
                   while($dados=mysql_fetch_array($sql)){
                       if($dados['estado']=="N"){
                           $dados['estado']="Normal";
                       }elseif($dados['estado']=="B"){
                           $dados['estado']="Boleto";
                       }elseif($dados['estado']=="E"){
                           $dados['estado']="Escriturado";
                       }else{
                           $dados['estado']="Cancelado";
                       }
                       $motivo=ResumeString($dados['motivo'],20);
                       echo "
                           <tr align=\"center\" bgcolor=\"FFFFFF\">
                                <td>".$dados['codverificacao']."</td>
                                <td>".$dados['nome']."</td>
                                <td>".$dados['data']."</td>
                                <td>".$dados['competencia']."</td>
                                <td>".$dados['total']."</td>
                                <td>".$dados['iss']."</td>
                                <td>".$dados['estado']."</td>
                                <td title='".$dados['motivo']."'>$motivo</td>
                            </tr>
                       ";
                   }
               ?>
            </table>
        <?php
    }else{
        echo "<font color=\"000000\"><b>Nenhum Resultado encontrado!</b></font>";
    }
?>