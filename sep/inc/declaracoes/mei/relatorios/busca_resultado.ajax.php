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
require_once("../../conect.php");
require_once("../../../funcoes/util.php");
require_once("../../nocache.php");
//recebe as variaveis vindas por get
$estado = $_GET['cmbEstado'];
$nome   = $_GET['txtNome'];
$cnpj   = $_GET['txtCNPJ'];

//verifica quais variaveis tem valor
if($estado){
	$str_where = " AND estado = '$estado'";
}
if($cnpj){
	$str_where .= " AND cnpj = '$cnpj'";
}

	$query = ("SELECT nome, razaosocial, cnpj, municipio, uf, estado, codigo FROM empreiteiras WHERE nome LIKE '$nome%' $str_where ORDER BY nome ASC");
	$sql_empreiteiras = Paginacao($query,'frmRelatorio','divBuscar',10);
if(mysql_num_rows($sql_empreiteiras)>0)
{
?>
<table width="100%">
	<tr>
    	<td align="left" colspan="5">
        	<input name="btImprimir" type="submit" value="Imprimir" class="botao" 
        	onclick="cancelaAction('frmRelatorio','inc/empreiteiras/relatorios/imprimir_empreiteiras.php','_blank')" />
        </td>
    </tr>
    <tr bgcolor="#999999">
        <td align="center" width="170">Nome</td>
        <td align="center" width="110">CNPJ</td>
        <td align="center" width="130">Município</td>
        <td align="center" width="30">UF</td>
        <?php if(!$estado){?><td align="center" width="90">Liberação</td><?php }?>
    </tr>
    <?php
    while(list($nome,$razaosocial,$cnpj,$municipio,$uf,$estado_emp,$codigo) = mysql_fetch_array($sql_empreiteiras)){										
        switch($estado_emp){
            case "NL": $estado_emp = "Aguardando"; break;
            case "A" : $estado_emp = "Liberado";   break;
            case "I" : $estado_emp = "Inativo";    break;
        }
    ?>
    <tr bgcolor="#FFFFFF">
        <td align="left" width="170"><?php echo $nome;?></td>
        <td align="center" width="110"><?php echo $cnpj;?></td>
        <td align="center" width="130"><?php echo $municipio;?></td>
        <td align="center" width="30"><?php echo $uf;?></td>
        <?php if(!$estado){?><td align="center" width="90"><?php echo $estado_emp;?></td><?php }?>
    </tr>
    <?php
    }
    ?>
</table>
<?php

	}else{
		echo "<center><b>Não há empreiteiras cadastradas</b></center>";
	}

?>