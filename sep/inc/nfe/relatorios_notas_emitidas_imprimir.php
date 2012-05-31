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
	
$txtDataIni = implode("-",array_reverse(explode("/",$txtDataIni))); // formata a data para o padrao do banco
$txtDataFim = implode("-",array_reverse(explode("/",$txtDataFim)));

//pega a opção do combobox que o usuario escolheu e transforma em um valor que o banco aceite para a pesquisa sql

if($cmbEstado == "Emitida") 
	{
		$estado = "N";
	}
elseif($cmbEstado == "Boleto")
	{
		$estado = "B";
	}
elseif($cmbEstado == "Cancelada")
	{
		$estado = "C";
	}
elseif($cmbEstado == "Escriturada")
	{
		$estado = "E";
	}

	//FAZ TODOS OS TESTES DO FORMULARIO DOS TOMADORES
	
	if(($txtDataIni != "") && ($txtDataFim == "") && ($cmbEstado == "") && ($txtEmpresa == ""))
		{
			$querysql = "WHERE SUBSTRING(datahoraemissao,1,10) >= '$txtDataIni'";
		}
	elseif(($txtDataIni == "") && ($txtDataFim != "") && ($cmbEstado == "") && ($txtEmpresa == ""))
		{
			$querysql = "WHERE SUBSTRING(datahoraemissao,1,10) <= '$txtDataFim'";
		}
	elseif(($txtDataIni == "") && ($txtDataFim == "") && ($cmbEstado != "") && ($txtEmpresa == ""))
		{
			if($cmbEstado == "Emitidas") {
				$querysql = ""; }
			elseif($cmbEstado == "RPS") {
				$querysql = "WHERE notas.rps_numero != ''"; }
			else {
				$querysql = "WHERE notas.estado = '$estado'"; }
		}
	elseif(($txtDataIni == "") && ($txtDataFim == "") && ($cmbEstado == "") && ($txtEmpresa != ""))
		{
			$querysql = "WHERE emissores.nome LIKE '$txtEmpresa%'";
		}
	elseif(($txtDataIni != "") && ($txtDataFim != "") && ($cmbEstado == "") && ($txtEmpresa == ""))
		{
			$querysql = "WHERE SUBSTRING(datahoraemissao,1,10) >= '$txtDataIni' AND SUBSTRING(datahoraemissao,1,10) <= '$txtDataFim'";
		}
	elseif(($txtDataIni != "") && ($txtDataFim == "") && ($cmbEstado != "") && ($txtEmpresa == ""))
		{
			if($cmbEstado == "Emitidas") {
				$querysql = "WHERE SUBSTRING(datahoraemissao,1,10) >= '$txtDataIni'"; }
			elseif($cmbEstado == "RPS") {
				$querysql = "WHERE SUBSTRING(datahoraemissao,1,10) >= '$txtDataIni' AND notas.rps_numero != ''"; }
			else {
				$querysql = "WHERE SUBSTRING(datahoraemissao,1,10) >= '$txtDataIni' AND notas.estado = '$estado'"; }
		}
	elseif(($txtDataIni != "") && ($txtDataFim == "") && ($cmbEstado == "") && ($txtEmpresa != ""))
		{
			$querysql = "WHERE SUBSTRING(datahoraemissao,1,10) >= '$txtDataIni' AND emissores.nome LIKE '$txtEmpresa%'";
		}
	elseif(($txtDataIni == "") && ($txtDataFim != "") && ($cmbEstado != "") && ($txtEmpresa == ""))
		{
			if($cmbEstado == "Emitidas") {
				$querysql = "WHERE SUBSTRING(datahoraemissao,1,10) <= '$txtDataFim'"; }
			elseif($cmbEstado == "RPS") {
				$querysql = "WHERE SUBSTRING(datahoraemissao,1,10) <= '$txtDataFim' AND notas.rps_numero != ''"; }
			else {
				$querysql = "WHERE SUBSTRING(datahoraemissao,1,10) <= '$txtDataFim' AND notas.estado = '$estado'"; }
		}
	elseif(($txtDataIni == "") && ($txtDataFim != "") && ($cmbEstado == "") && ($txtEmpresa != ""))
		{
			$querysql = "WHERE SUBSTRING(datahoraemissao,1,10) <= '$txtDataFim' AND emissores.nome LIKE '$txtEmpresa%'";
		}
	elseif(($txtDataIni == "") && ($txtDataFim == "") && ($cmbEstado != "") && ($txtEmpresa != ""))
		{
			if($cmbEstado == "Emitidas") {
				$querysql = "WHERE emissores.nome LIKE '$txtEmpresa%'"; }
			elseif($cmbEstado == "RPS") {
				$querysql = "WHERE emissores.nome LIKE '$txtEmpresa%' AND notas.rps_numero != ''"; }
			else {
				$querysql = "WHERE emissores.nome LIKE '$txtEmpresa%' AND notas.estado = '$estado'"; }
		}
	elseif(($txtDataIni != "") && ($txtDataFim != "") && ($cmbEstado != "") && ($txtEmpresa == ""))
		{
			if($cmbEstado == "Emitidas") {
				$querysql = "WHERE SUBSTRING(datahoraemissao,1,10) >= '$txtDataIni' AND SUBSTRING(datahoraemissao,1,10) <= '$txtDataFim'"; }
			elseif($cmbEstado == "RPS") {
				$querysql = "WHERE SUBSTRING(datahoraemissao,1,10) >= '$txtDataIni' AND SUBSTRING(datahoraemissao,1,10) <= '$txtDataFim' AND notas.rps_numero != ''"; }
			else {
				$querysql = "WHERE SUBSTRING(datahoraemissao,1,10) >= '$txtDataIni' AND SUBSTRING(datahoraemissao,1,10) <= '$txtDataFim' AND notas.estado = '$estado'"; }
		}
	elseif(($txtDataIni != "") && ($txtDataFim != "") && ($cmbEstado == "") && ($txtEmpresa != ""))
		{
			$querysql = "WHERE SUBSTRING(datahoraemissao,1,10) >= '$txtDataIni' AND SUBSTRING(datahoraemissao,1,10) <= '$txtDataFim' AND emissores.nome LIKE '$txtEmpresa%'";
		}
	elseif(($txtDataIni != "") && ($txtDataFim == "") && ($cmbEstado != "") && ($txtEmpresa != ""))
		{
			if($cmbEstado == "Emitidas") {
				$querysql = "WHERE SUBSTRING(datahoraemissao,1,10) >= '$txtDataIni' AND emissores.nome LIKE '$txtEmpresa%'"; }
			elseif($cmbEstado == "RPS") {
				$querysql = "WHERE SUBSTRING(datahoraemissao,1,10) >= '$txtDataIni' AND notas.rps_numero != '' AND emissores.nome LIKE '$txtEmpresa%'"; }
			else {
				$querysql = "WHERE SUBSTRING(datahoraemissao,1,10) >= '$txtDataIni' AND notas.estado = '$estado' AND emissores.nome LIKE '$txtEmpresa%'"; }
		}
	elseif(($txtDataIni == "") && ($txtDataFim != "") && ($cmbEstado != "") && ($txtEmpresa != ""))
		{
			if($cmbEstado == "Emitidas") {
				$querysql = "WHERE SUBSTRING(datahoraemissao,1,10) <= '$txtDataFim' AND emissores.nome LIKE '$txtEmpresa%'"; }
			elseif($cmbEstado == "RPS") {
				$querysql = "WHERE SUBSTRING(datahoraemissao,1,10) <= '$txtDataFim' AND notas.rps_numero != '' AND emissores.nome LIKE '$txtEmpresa%'"; }
			else {
				$querysql = "WHERE SUBSTRING(datahoraemissao,1,10) <= '$txtDataFim' AND notas.estado = '$estado' AND emissores.nome LIKE '$txtEmpresa%'"; }
		}
	elseif(($txtDataIni != "") && ($txtDataFim != "") && ($cmbEstado != "") && ($txtEmpresa != ""))
		{
			if($cmbEstado == "Emitidas") {
				$querysql = "WHERE SUBSTRING(datahoraemissao,1,10) >= '$txtDataIni' AND SUBSTRING(datahoraemissao,1,10) <= '$txtDataFim' AND emissores.nome LIKE '$txtEmpresa%'"; }
			elseif($cmbEstado == "RPS") {
				$querysql = "WHERE SUBSTRING(datahoraemissao,1,10) >= '$txtDataIni' AND SUBSTRING(datahoraemissao,1,10) <= '$txtDataFim' AND notas.rps_numero != '' AND emissores.nome LIKE '$txtEmpresa%'"; }
			else {
				$querysql = "WHERE SUBSTRING(datahoraemissao,1,10) >= '$txtDataIni' AND SUBSTRING(datahoraemissao,1,10) <= '$txtDataFim' AND notas.estado = '$estado' AND emissores.nome LIKE '$txtEmpresa%'"; }
		}
	elseif(($txtDataIni == "") && ($txtDataFim == "") && ($cmbEstado == "") && ($txtEmpresa == ""))
		{
			$querysql = "";
		}
			
// SQL CONCATENANDO COM A VARIAVEL $querysql QUE ESTÁ DENTRO DE ALGUMA CONDIÇÃO DOS IF'S
			
$sql = mysql_query("
	SELECT 
	notas.numero, 
	notas.codverificacao, 
	SUBSTRING(notas.datahoraemissao,1,10), 
	notas.tomador_nome, 
	notas.estado, 
	notas.rps_numero,
	emissores.nome
	FROM notas 
	INNER JOIN emissores ON notas.codemissor = emissores.codigo ".$querysql);//sql de busca com filtros.
?>
<script src="../../scripts/padrao.js" type="text/javascript"></script><title>Relatorios - Notas</title>
<div id="DivImprimir"><input type="button" onClick="EscondeDiv('DivImprimir'); print();" value="Imprimir" /></div>
<p style="font:Verdana, Arial, Helvetica, sans-serif; font-size:20px"><b>Relatório de Notas eletrônicas</b></p>
<table>
	<?php if($_POST["cmbEstado"]){?>
	<tr>
		<td><strong>Notas:</strong></td>
		<td><?php echo $_POST["cmbEstado"]; ?>s</td>
	</tr>
	<?php } if($_POST["txtDataIni"]){ ?>
	<tr>
		<td><strong>A partir da data:</strong></td>
		<td><?php echo $_POST["txtDataIni"]; ?></td>
	</tr>
	<?php } if($_POST["txtDataFim"]){ ?>
	<tr>
		<td><strong>Até a data:</strong></td>
		<td><?php echo $_POST["txtDataFim"]; ?></td>
	</tr>
	<?php } if($_POST["txtEmpresa"]) {?>
	<tr>
		<td><strong>Empresa:</strong></td>
		<td><?php echo $_POST["txtEmpresa"]; ?></td>
	</tr>
	<?php }//fim if mostrar os dados usados no filtro ?>
	<tr>
		<td colspan="2"><strong><?php echo mysql_num_rows($sql); ?> notas registradas</strong></td>
	</tr>
</table>

<table>
	<tr>
		<td>
			<table width="700" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif">
				<tr>
					<td width="50" align="center"><b>Nº</b></td>
					<td width="90" align="center"><b>Cód Verif</b></td>
					<td width="75" align="center"><b>D/H Emissão</b></td>
					<td width="270" align="center"><b>Nome Emissor</b></td>
					<td width="270" align="center"><b>Nome Tomador</b></td>
					<td width="270" align="center"><b>Estado</b></td>
					<td align="center"><b><?php if($cmbEstado == "RPS") { echo "RPS"; } ?></b></td>
				</tr>
				<tr>
					<td colspan="6"><hr size="1px" color="#000000"/></td>
				</tr>
				<?php
				while(list($numero, $codverif, $data, $tomador_nome, $estado, $rps, $emissor) = mysql_fetch_array($sql))
					{
						switch($estado) //transforma o valor que veio do banco para uma melhor vizualização do usuario na impressão
							{
								case "N": $tipo = "Emitida"; 	 break;
								case "B": $tipo = "Boleto";   	 break;
								case "C": $tipo = "Cancelada";	 break;
								case "E": $tipo = "Escriturada"; break;										
							}//fim switch
				?>
				<tr>
					<td align="center"><?php echo $numero;?></td>
					<td align="center"><?php echo $codverif;?></td>
					<td align="center"><?php echo implode("/",array_reverse(explode("-",$data)));?></td>
					<td align="center"><?php echo $emissor;?></td>
					<td align="center"><?php echo $tomador_nome;?></td>
					<td align="center"><?php echo $tipo;?></td>
					<td align="center"><?php if($cmbEstado == "RPS") { echo $rps; }?></td>
				</tr>
			<?php
					}//fim while
			?>
			</table>
		</td>
	</tr>
</table>