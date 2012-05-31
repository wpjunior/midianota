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
	
    // recebe os dados
    $codempreiteira=$_POST['cmbEmpreiteira'];

    if($_POST["btDetalhes"]!="Detalhes"){
        ?>
            <form method="post">
                <input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
                <input type="hidden" name="txtCodObra" id="txtCodObra" />
                <input type="hidden" name="btObras" value="Listar Obras" />
                <table align=\"center\">
                    <?php
                        $sql_busca=mysql_query("SELECT codigo, obra FROM obras WHERE codempreiteira=$codempreiteira");
                        while($dados=mysql_fetch_array($sql_busca)){
                            ?>
                                <tr align="left">
                                    <td><?php echo $dados['obra']; ?></td>
                                    <td>
                                        <input type="submit" class="botao" name="btDetalhes" value="Detalhes" onclick="document.getElementById('txtCodObra').value='<?php echo $dados['codigo']; ?>'" />
                                    </td>
                                </tr>
                            <?php
                        }
                    ?>
                </table>
            </form>
        <?php
    }

    if($_POST["btDetalhes"]=="Detalhes"){
        include("inc/empreiteiras/obras_detalhes.php");
    }
?>