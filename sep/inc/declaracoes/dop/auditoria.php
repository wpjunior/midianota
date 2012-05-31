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
<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
  <tr>
    <td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
    <td width="600" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;Órgãos Públicos - Auditoria </td>  
    <td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
  </tr>
  <tr>
    <td width="18" background="img/form/lateralesq.jpg"></td>
    <td align="center">
		<form id="frmDOP" name="frmDOP" method="post" onsubmit="return false">
			<input name="include" id="include" type="hidden" value="<?php echo $_POST["include"];?>">
			<input name="hdCodSolicitacao" id="hdCodSolicitacao" type="hidden">
			<fieldset><legend>Auditoria</legend>
				<table>
					<tr>
						<td align="left">Nome/Raz&atilde;o Social</td>
					  	<td align="left"><input name="txtNome" type="text" class="texto" size="60" maxlength="100" /></td>
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
								$sql_ano = mysql_query("SELECT SUBSTRING(competencia,1,4) FROM decc_des GROUP BY SUBSTRING(competencia,1,4) ORDER BY SUBSTRING(competencia,1,4) DESC");
								while(list($ano) = mysql_fetch_array($sql_ano)){
									echo "<option value='$ano'>$ano</option>";
								}//while listando os anos que exitem declaracoes
								?>
							</select>
						<input type="submit" name="btConsultar" value="Consultar" class="botao" 
						onclick="acessoAjax('inc/orgaospublicos/auditoria_resultado.ajax.php','frmDOP','divResultado')" />
						</td>
					</tr>
				</table>
			</fieldset>
			<div id="divResultado">
			</div>
		</form>
	</td>
	<td width="19" background="img/form/lateraldir.jpg"></td>
  </tr>
  <tr>
    <td align="left" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantoesq.jpg" /></td>
    <td background="img/form/rodape_fundo.jpg"></td>
    <td align="right" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantodir.jpg" /></td>
  </tr>
</table>