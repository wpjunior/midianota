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
	if(isset($_POST)){
		$nomeobra = $_POST['txtNomeObra'];
		$alvara   = $_POST['txtAlvara'];
		$estado   = $_POST['cmbEstado'];
		$dataini  = $_POST['txtDataIni'];
		$datafim  = $_POST['txtDataFim'];
	}
	
	switch($estado){
		case "A" : $str_estado = "Aberto";    break;
		case "C" : $str_estado = "Concluido"; break;
		case "I" : $str_estado = "Inativo";   break;
	}
	
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
	}
	
	
	
	$sql_obras = mysql_query("SELECT codempreiteira, obra, alvara, endereco, proprietario, proprietario_cnpjcpf, dataini, datafim, estado FROM obras WHERE obra LIKE '$nomeobra%' $str_where ");
	if(mysql_num_rows($sql_obras)>0){
?>
<link href="../../../css/padrao.css" rel="stylesheet" type="text/css">
<title>Imprimir</title><input name="btImprimir" id="btImprimir" type="button" class="botao" value="Imprimir" onClick="document.getElementById('btImprimir').style.display = 'none';print();">
	<table width="850">
    	<tr>
        	<td><b><font size="4">Relatório de Obras</font></b></td>
        </tr>
        <?php
			if($nomeobra){
		?>
        <tr>
        	<td width="132"><b>Nome da Obra: </b><?php echo $nomeobra;?></td>
        </tr>
        <?php
        	}
			if($alvara){
		?>
        <tr>
        	<td width="132"><b>Alvara: </b><?php echo $alvara;?></td>
        </tr>
        <?php
        	}
			if($estado){
		?>
        <tr>
        	<td width="132"><b>Estado: </b><?php echo $str_estado;?></td>
        </tr>
        <?php
        	}
			if($dataini){
		?>
        <tr>
        	<td width="132"><b>Data de inicio: </b><?php echo $dataini;?></td>
        </tr>
        <?php
        	}
			if($datafim){
		?>
        <tr>
        	<td width="132"><b>Data de termino: </b><?php echo $datafim;?></td>
        </tr>
        <?php
        	}
		?>
    </table>
    <table width="850" bordercolor="#000000" border="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; border-width:thin;">
        <tr>
            <td width="15%" align="center"><b>Nome</b></td>
            <td width="6%"  align="center"><b>Alvara</b></td>
            <td width="19%" align="center"><b>Endereco</b></td>
            <td width="19%" align="center"><b>Propietário</b></td>
            <td width="15%" align="center"><b>CNPJCPF</b></td>
            <td width="9%"  align="center"><b>Data inicio</b></td>	
            <td width="10%" align="center"><b>Data termino</b></td>
            <td width="7%"  align="center"><b>Estado</b></td>
      </tr>
      <tr>
      		<td colspan="8"><hr color="#000000" size="2" /></td>
      </tr>
        <?php
		while($dados_obra = mysql_fetch_array($sql_obras)){
            switch($dados_obra['estado']){
                case "A" : $estado = "Aberto";    break;
                case "C" : $estado = "Concluido"; break;
                case "I" : $estado = "Inativo";   break;
            }
        ?>
        <tr>
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
<?php

	}else{
		echo "<center><b>Não há empreiteiras cadastradas</b></center>";
	}

?>