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
include("../../../conect.php");
include("../../../../funcoes/util.php");

$ano = $_GET["cmbAno"];
$mes = $_GET["cmbMes"];
$codemissor = $_GET['codemissor'];
$sql = mysql_query("
	SELECT 
		cartorios_des.codigo,
		cartorios_des.data_gerado,
		cartorios_des.codverificacao,
		SUM(cartorios_des.iss_emo),
		DATE_FORMAT(cartorios_des.competencia,'%m/%Y')
	FROM 
		cartorios_des
	INNER JOIN 
		cartorios_des_notas ON cartorios_des.codigo = cartorios_des_notas.coddec_des
	WHERE 
		MONTH(cartorios_des.competencia) = '$mes' AND 
		YEAR(cartorios_des.competencia) = '$ano' AND 
		cartorios_des.codcartorio = '$codemissor' AND 
		cartorios_des.estado = 'N'
	GROUP BY 
		cartorios_des.codigo
");
if(mysql_num_rows($sql) > 0)
	{
		?>
			<form method="post">	
				<input type="hidden" name="txtMenu" value="guia_pagamento/index.php" />
				<input type="hidden" name="btBuscar" value="Buscar" />
				<input type="hidden" name="cmbAno" id="cmbAno" value="<?php echo $ano; ?>" />
				<input type="hidden" name="cmbMes" id="cmbMes" value="<?php echo $mes; ?>" />
				<input type="hidden" name="txtEmissor" value="<?php echo $codemissor;?>" />
				<table width="70%">
					<tr bgcolor="#999999">
						<td colspan="4" align="right">Selecionar tudo</td>
						<td align="center">
							<input type="checkbox" name="ckTodos" id="ckTodos" onclick="GuiaPagamento_TotalISS()">
						</td>
					</tr>
					<tr bgcolor="#FFFFFF">
						<td width="100" align="center">Data Gerado</td>
						<td width="90" align="center">Compet&ecirc;ncia</td>
						<td width="110" align="center">Cod. Verifica&ccedil;&atilde;o</td>
						<td width="60" align="center">Valor</td>
						<td align="center"></td>
					</tr>
				</table>
			   <div style=" width:70%; <?php if(mysql_num_rows($sql)>13){ echo "height:300px; overflow:auto";}?>">
				<table width="100%">
					<?php
						$cont = 0;
						while(list($codigo,$data,$codverificacao,$total,$data_comp) = mysql_fetch_array($sql)){
							$datahora = explode(" ",$data);
							$data = DataPt($datahora[0]);
							$hora = $datahora[1];
							echo "
								<tr bgcolor=\"#FFFFEA\">
									<td width=\"100\" align=\"center\">$data</td>
									<td width=\"90\" align=\"center\">$data_comp</td>
									<td width=\"110\" align=\"center\">$codverificacao</td>
									<td width=\"60\" align=\"right\">".DecToMoeda($total)."</td>
									<td align=\"center\">
										<input type=\"checkbox\" name=\"ckISS$cont\" id=\"ckISS$cont\" value=\"$total|$codigo\" onclick=\"GuiaPagamento_SomaISS(this)\">
										<input type=\"hidden\" name=\"txtCodNota$cont\" id=\"txtCodNota$cont\" />													
									</td>
								</tr>
							";
							$cont++;
						}
					?>
				</table>
			  </div>
				<input type="hidden" value="<?php echo $total_iss."|".($cont-1); ?>" name="txtTotalIssHidden" id="txtTotalIssHidden"/>
				<table>
					<tr>
						<td>Imposto</td>
						<td>
							<input type="text" class="texto" style="text-align: right" name="txtTotalIss" id="txtTotalIss" value="0,00" readonly="readonly" >
						</td>
					</tr>
					<tr>
						<td>Multa</td>
						<td>
							<input type="text" class="texto" style="text-align: right" name="txtMultaJuros" id="txtMultaJuros" value="0,00" readonly="readonly" >
						</td>
					</tr>
					<tr>
						<td>Total</td>
						<td>
							<input type="text" class="texto" style="text-align: right" name="txtTotalPagar" id="txtTotalPagar" value="0,00" readonly="readonly" >
						</td>
					</tr>
					<tr>
						<td>
						</td>
						<td>
							<input type="hidden" class="texto" name="txtMultaJuros" id="txtMultaJuros" value="0" readonly="yes" >
						</td>
					</tr>
				</table>	
				<input type="submit" class="botao" value="Gerar Boleto" name="btBoleto" id="btBoleto" onclick="document.getElementById('btBoleto').disabled; return (ValidaCkbDec('txtTotalIss')) && (Confirma('Deseja gerar esta guia?'))"/>
				<input type="hidden" name="txtCont" value="<?php echo $cont; ?>" />
				
			</form>	
			
		<?php
}else{
	echo "<center>Nenhum Resultado Encontrado!</center>";
}	
?>
		