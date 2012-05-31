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
	//da include dos principais arquivos
	require_once("../../conect.php");
	require_once("../../../funcoes/util.php");
	require_once("../../nocache.php");
	
	
	//Recebe as variaveis vindas por post
	$nomeobra  = $_GET['txtNomeObra'];
	$alvara    = $_GET['txtAlvara'];
	$estado    = $_GET['cmbEstado'];
	$dataini   = $_GET['txtDataIni'];
	$datafim   = $_GET['txtDataFim'];
	
	//Testa quais campos foram preenchidos e acrescenta na str_where
	if($alvara){
		$str_where .= " AND alvara = '$alvara'";
	}
	if($estado){
		$str_where .= " AND estado = '$estado'";
	}
	if($dataini){
		$data = DataPt($dataini);
		$str_where .= " AND dataini >= '$data'";
	}
	if($datafim){
		$data = DataPt($datafim);
		$str_where .= " AND datafim <= '$data'";
	}?>
	
<fieldset><legend>Resultados</legend>
 <?php
	$query = ("SELECT codempreiteira, obra, alvara, endereco, proprietario, proprietario_cnpjcpf, dataini, datafim, estado FROM obras WHERE obra LIKE '$nomeobra%' $str_where");
	$sql_obras = Paginacao($query,'frmRelatorio','divBuscar',10);
	
	if(mysql_num_rows($sql_obras)>0){
?>
	<table width="100%">
    	<tr>
        	<td align="left">
            	<input name="btImprimir" type="submit" class="botao" value="Imprimir" 
            	onclick="cancelaAction('frmRelatorio','inc/empreiteiras/relatorios/imprimir.php','_blank')" />
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr bgcolor="#999999">
            <td width="15%" align="center">Nome</td>
            <td width="6%"  align="center">Alvara</td>
            <td width="19%" align="center">Endereco</td>
            <td width="19%" align="center">Propietário</td>
            <td width="15%" align="center">CNPJCPF</td>
            <td width="9%"  align="center">Data inicio</td>	
            <td width="10%" align="center">Data termino</td>
            <td width="7%"  align="center">Estado</td>
      </tr>
        <?php
		while($dados_obra = mysql_fetch_array($sql_obras)){
            switch($dados_obra['estado']){
                case "A" : $estado = "Aberto";    break;
                case "C" : $estado = "Concluido"; break;
                case "I" : $estado = "Inativo";   break;
            }
        ?>
        <tr bgcolor="#FFFFFF">
            <td align="center"><?php echo $dados_obra['obra']?></td>
            <td align="center"><?php echo $dados_obra['alvara'];?></td>
            <td align="center"><?php echo $dados_obra['endereco']?></td>
            <td align="center"><?php echo $dados_obra['proprietario']?></td>
            <td align="center"><?php echo $dados_obra['proprietario_cnpjcpf'];?></td>
            <td align="center"><?php echo DataPt($dados_obra['dataini']);?></td>
            <td align="center"><?php echo DataPt($dados_obra['datafim']);?></td>
            <td align="center"><?php echo $estado;?></td>
        </tr>
        <?php
        }
        ?>
    </table>
</fieldset>
<?php

	}else{
		echo "<center><b>Não há empreiteiras cadastradas</b></center>";
	}

?>