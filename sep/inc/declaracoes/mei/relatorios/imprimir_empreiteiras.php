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

//recebe as variaveis vindas por get
$estado = $_POST['cmbEstado'];
$nome   = $_POST['txtNome'];
$cnpj   = $_POST['txtCNPJ'];

switch($estado){
	case "NL": $estado_emp = "Aguardando"; break;
	case "A" : $estado_emp = "Liberado";   break;
	case "I" : $estado_emp = "Inativo";    break;
}

//verifica quais variaveis tem valor
if($estado){
	$str_where = " AND estado = '$estado'";
}
if($cnpj){
	$str_where .= " AND cnpj = '$cnpj'";
}

	$sql_empreiteiras = mysql_query("SELECT nome, razaosocial, cnpj, municipio, uf, estado, codigo FROM empreiteiras WHERE nome LIKE '$nome%' $str_where ORDER BY nome ASC");
	
if(mysql_num_rows($sql_empreiteiras)>0){
?>
<title>Imprimir</title>
<link href="../../../css/padrao.css" rel="stylesheet" type="text/css">
<title>Imprimir</title><input name="btImprimir" id="btImprimir" type="button" class="botao" value="Imprimir" onClick="document.getElementById('btImprimir').style.display = 'none';print();">
<table width="750">
	<tr>
    	<td><b><font size="4">Relatório de Declarações</font></b></td>
    </tr>
<?php
	if($nome){
?>
	<tr>
    	<td width="49"><b>Nome:</b> <?php echo $nome;?></td>
    </tr>
<?php
	}
	if($cnpj){
?>
	<tr>
    	<td><b>CNPJ:</b> <?php echo $cnpj;?></td>
    </tr>
<?php
	}
	if($estado){
?>
	<tr>
    	<td><b>Estado:</b> <?php echo $estado_emp;?></td>
    </tr>
<?php
	}
?>
</table>
<table width="750"  bordercolor="#000000" border="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; border-width:thin;">
    <tr>
        <td align="center" width="170"><b>Nome</b></td>
        <td align="center" width="110"><b>CNPJ</b></td>
        <td align="center" width="130"><b>Município</b></td>
        <td align="center" width="30"><b>UF</b></td>
        <?php if(!$estado){?><td align="center" width="90"><b>Liberação</b></td><?php }?>
    </tr>
    <tr>
    	<td colspan="5"><hr color="#000000" size="2"></td>
    </tr>
    <?php
    while(list($nome,$razaosocial,$cnpj,$municipio,$uf,$estado_emp,$codigo) = mysql_fetch_array($sql_empreiteiras)){										
        switch($estado_emp){
            case "NL": $estado_emp = "Aguardando"; break;
            case "A" : $estado_emp = "Liberado";   break;
            case "I" : $estado_emp = "Inativo";    break;
        }
    ?>
    <tr>
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


















