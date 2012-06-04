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
<div id="DivAbas"></div>    
<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
  <tr>
    <td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
    <td width="700" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;Livro Digital - Consulta</td>  
    <td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
  </tr>
  <tr>
    <td width="18" background="img/form/lateralesq.jpg"></td>
    <td align="center">    
		<form method="post" id="frmLivro">
			<input type="hidden" name="include" id="include" value="<?php echo $_POST["include"];?>" />
			<fieldset>
				<legend>Consulta ao Livro Digital</legend>
			<table align="left">
				<tr>
					<td>CNPJ/CPF Prestador</td>
					<td><input type="text" name="txtCnpjPrestador" class="texto" /></td>
				</tr>
				<tr>
					<td>Periodo Inicial</td>
					<td>
						<?php
						$meses=array("1"=>"Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
						
						?>
						<select name="cmbMesIni" id="cmbMesIni">
							<option value=""></option>
							<?php
							for($ind=1;$ind<=12;$ind++){
								echo "<option value='$ind'>{$meses[$ind]}</option>";
							}
							?>
						</select>    
						<select name="cmbAnoIni" id="cmbAnoIni">
							<option value=""></option>
							<?php
							$year=date("Y");
							for ($h = 0; $h < 5; $h++) {
								$y = $year - $h;
								echo "<option value=\"$y\""; if($y == $ano){ echo " selected=\"selected\" ";} echo ">$y</option>";
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Periodo Final</td>
					<td>
						<select name="cmbMesFim" id="cmbMesFim">
							<option value=""></option>
							<?php
							for($ind=1;$ind<=12;$ind++){
								echo "<option value='$ind'>{$meses[$ind]}</option>";
							}
							?>
						</select>    
						<select name="cmbAnoFim" id="cmbAnoFim">
							<option value=""></option>
							<?php
							$year=date("Y");
							for ($h = 0; $h < 5; $h++) {
								$y = $year - $h;
								echo "<option value=\"$y\""; if($y == $ano){ echo " selected=\"selected\" ";} echo ">$y</option>";
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" name="btnBuscar" value="Buscar" class="botao" onclick="btnBuscar_click(); return false;" />
					</td>
				</tr>
			</table>
			</fieldset>
			<div id="dvResultdoLivro"></div>
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
<script type="text/javascript">
	function btnBuscar_click() {
		acessoAjax('../livro/sep_consultar.ajax.php','frmLivro','dvResultdoLivro');
	}
	
</script>
