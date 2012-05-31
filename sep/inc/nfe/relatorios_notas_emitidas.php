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
	INNER JOIN emissores ON notas.codemissor = emissores.codigo ".$querysql);

if(mysql_num_rows($sql)>0){	//mostra se os resultados existem
?>


<form method="post" name="frmRelatorio" id="frmRelatorio" action="inc/nfe/relatorios_notas_emitidas_imprimir.php" target="_blank">
	<input type="submit" name="btImprimir" value="Imprimir Relatório" class="botao" />
	<input type="hidden" name="txtDataIni" value="<?php echo $_POST["txtDataIni"]; ?>" />
	<input type="hidden" name="txtDataFim" value="<?php echo $_POST["txtDataFim"]; ?>" />
	<input type="hidden" name="cmbEstado" value="<?php echo $_POST["cmbEstado"]; ?>" />
	<input type="hidden" name="txtEmpresa" value="<?php echo $_POST["txtEmpresa"]; ?>" />
</form>

<?php echo "Resultados Encontrados: ".mysql_num_rows($sql); ?>
<table>
	<tr>
		<td>
			<table width="700" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif">
				<tr>
					<td width="50" align="center" bgcolor="#999999"><b>Nº</b></td>
					<td width="90" align="center" bgcolor="#999999"><b>Cód Verif</b></td>
					<td width="75" align="center" bgcolor="#999999"><b>D/H Emissão</b></td>
					<td width="200" align="center" bgcolor="#999999"><b>Nome Emissor</b></td>
					<td width="200" align="center" bgcolor="#999999"><b>Nome Tomador</b></td>
					<td align="center" bgcolor="#999999"><b>Estado</b></td>
					<?php if($cmbEstado == "RPS") { echo "<td align=\"center\" bgcolor=\"#666666\"><b>RPS</b></td>"; } ?>
				</tr>
			</table>
		<div <?php if(mysql_num_rows($sql)>15){echo "style=\"width:717; height:273px; overflow:auto\"";} ?> >	
			<table width="700" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif">
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
						if($tipo == "Cancelada"){$cor = "#FFAC84";}else{$cor = "#FFFFFF";}
			?>
				<tr bgcolor="<?php echo $cor;?>">
					<td width="50" align="right" bgcolor="<?php echo $cor;?>"><?php echo $numero;?></td>
					<td width="90" align="center" bgcolor="<?php echo $cor;?>"><?php echo $codverif;?></td>
					<td width="75" align="center" bgcolor="<?php echo $cor;?>"><?php echo DataPt($data);?></td>
					<td width="200" align="center" bgcolor="<?php echo $cor;?>"><?php echo $emissor;?></td>
					<td width="200" align="center" bgcolor="<?php echo $cor;?>"><?php echo $tomador_nome;?></td>
					<td align="center" bgcolor="<?php echo $cor;?>"><?php echo $tipo;?></td>
					<?php if($cmbEstado == "RPS") { echo "<td align=\"center\" bgcolor=\"#FFFFFF\">$rps</td>"; }?>
				</tr>
			<?php
					}//fim while
			?>
			</table>
			</div>
		</td>
	</tr>
</table>
<?php }else{//ifm if se tem resultados
?>
<strong>Nenhum resultado encontrado.</strong>
<?php }//fim if se NAO tem resultados ?>
