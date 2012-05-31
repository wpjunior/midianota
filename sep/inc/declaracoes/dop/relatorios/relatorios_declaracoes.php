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
<fieldset><legend>Relatório de Declaração de Órgaos Públicos</legend>
	<table width="100%">
		<tr>
			<td width="17%" align="left">Nome/Raz&atilde;o Social</td>
		  	<td width="83%" align="left"><input name="txtNome" type="text" class="texto" size="60" maxlength="100" /></td>
	  	</tr>
		<tr>
			<td align="left">CNPJ</td>
			<td align="left"><input name="txtCNPJ" type="text" class="texto" size="20" maxlength="18" /></td>
		</tr>
		<tr>
			<td align="left">N° da DOP</td>
			<td align="left"><input name="txtNroDop" type="text" class="texto" size="10" maxlength="10" /></td>
		</tr>
		<tr>
			<td align="left">Compet&ecirc;cia</td>
			<td align="left">
				<select name="cmbMes" class="combo">
					<option value=""></option>
					<?php
					//array dos meses comecando na posição 1 ate 12 e faz um for listando os meses no combo
					$meses = array(1=>"Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
					for($x=1;$x<=12;$x++){
						echo "<option value='$x'>$meses[$x]</option>";
					}//fim for meses
					?>
				</select>
				<select name="cmbAno" class="combo">
					<option value=""></option>
					<?php
					//lista os anos que existem declaracoes
					$sql_ano = mysql_query("SELECT SUBSTRING(competencia,1,4) FROM dop_des GROUP BY SUBSTRING(competencia,1,4) ORDER BY SUBSTRING(competencia,1,4) DESC");
					while(list($ano) = mysql_fetch_array($sql_ano)){
						echo "<option value='$ano'>$ano</option>";
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td align="left">Estado</td>
			<td align="left">
				<select name="cmbEstado" class="combo">
					<option value=""></option>
					<option value="B">Boleto</option>
					<option value="C">Cancelado</option>
					<option value="E">Escriturado</option>
					<option value="N">Normal</option>
				</select>
			</td>
		</tr>
		<tr>
			<td align="left">Data Inicial</td>
			<td align="left"><input name="txtDataIni" type="text" class="texto" size="12" maxlength="10" onkeyup="MaskData(this)" /></td>
		</tr>
		<tr>
			<td align="left">Data Final</td>
			<td align="left"><input name="txtDataFim" type="text" class="texto" size="12" maxlength="10" onkeyup="MaskData(this)" /></td>
		</tr>
		<tr>
			<td align="left" colspan="2">
				<input type="submit" name="btConsultar" value="Consultar" class="botao" 
				onclick="acessoAjax('inc/orgaospublicos/relatorios/busca_resultado_declaracoes.ajax.php','frmRelatorio','divBuscar');" />
			</td>
		</tr>
	</table>
</fieldset>
<div id="divBuscar"></div>
