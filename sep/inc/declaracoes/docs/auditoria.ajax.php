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
    include('../conect.php');
    include('../../funcoes/util.php');

    $codcartorio=$_GET['cmbCartorios'];
	$cartorio= codtipo('cartorio');
    $query=("SELECT cartorios_des.codigo,
             DATE_FORMAT(cartorios_des.data_gerado,'%d/%m/%Y') AS data,
             DATE_FORMAT(cartorios_des.competencia, '%Y/%m') AS competencia,
             cartorios_des.codverificacao,
             cartorios_des.total,
             cartorios_des.iss_emo AS iss,
             cartorios_des.estado,
             cartorios_des.motivo_cancelamento AS motivo
             FROM cartorios_des
             INNER JOIN cadastro
             ON cadastro.codigo = cartorios_des.codcartorio
             WHERE cadastro.codigo='$codcartorio' AND cadastro.codtipo='$cartorio'
             ORDER BY cartorios_des.competencia DESC");

    $sql_cartorio=Paginacao($query,'frmAuditoria','detalhes_dec');
    if(mysql_num_rows($sql_cartorio)>0){
        ?>
            <table align="center" width="100%">
                <tr align="center" bgcolor="999999">
                    <td>Cód. Verificacao</td>
                    <td>Competencia</td>
                    <td>Data</td>
                    <td>Total</td>
                    <td>ISS</td>
                    <td>Estado</td>
                    <td>Motivo Cancelamento</td>
                    <td></td>
                </tr>
                <?php
                    while($dados=mysql_fetch_array($sql_cartorio)){
                        if($dados['estado']=="N"){
                            $dados['estado']="Normal";
                            $motivo="";
                        }elseif($dados['estado']=="B"){
                            $dados['estado']="Boleto";
                            $motivo="";
                        }elseif($dados['estado']=="E"){
                            $dados['estado']="Escriturada";
                            $motivo="";
                        }else{
                            $dados['estado']="Cancelada";
                            $motivo=ResumeString($dados['motivo'],35);
                        }
                        echo "
                            <tr align=\"center\" bgcolor=\"FFFFFF\">
                                <td>".$dados['codverificacao']."</td>
                                <td>".$dados['competencia']."</td>
                                <td>".$dados['data']."</td>
                                <td>".$dados['total']."</td>
                                <td>".$dados['iss']."</td>
                                <td>".$dados['estado']."</td>
                                <td title='".$dados['motivo']."'>$motivo</td>
                                <td><input type=\"button\" class=\"botao\" value=\"Auditar\" onclick='alert(".$dados['codigo'].")'</td>
                            </tr>
                        ";
                    }
                ?>
            </table>
        <?php
    }else{
        if($codcartorio){
            echo "<b>Nenhum resultado encontrado!</b>";
        }
    }
?>
<div id="detalhes_dec"></div>