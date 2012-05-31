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
    <td width="750" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;NFe - Relat&oacute;rios </td>  
    <td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
  </tr>
  <tr>
    <td width="18" background="img/form/lateralesq.jpg"></td>
    <td align="center"><form method="post" name="frmRelatorios" id="frmRelatorios">
<input type="hidden" name="include" id="include" value="<?php echo $_POST["include"]; ?>" />
<input type="hidden" name="btNotas" value="Notas" >
</form>

	<table width="760" align="left">
		<tr>
			<td>
				<fieldset><legend>Relatório geral</legend>
				<?php  
				//pega o numero total de notas emitidas
				$sql_relatorios = mysql_query("SELECT * FROM notas");
				$notas = mysql_num_rows($sql_relatorios);
				
				//pega o numero de notas canceladas
				$sql_relatorios = mysql_query("SELECT * FROM notas WHERE estado = 'C'");
				$notas_C = mysql_num_rows($sql_relatorios);
				
				//pega o nome do emissor que emitiu mais notas e o numero de notas emitidas por ele
				$sql_relatorio = mysql_query("SELECT nome, ultimanota FROM emissores WHERE nfe='S' ORDER BY ultimanota DESC LIMIT 1");
				list($maior_emissor, $maior_emissor_notas) = mysql_fetch_array($sql_relatorio);
				
				//procura no banco quem foi o tomador que recebeu mais notas e quantas notas recebeu.  count(*) serve para contar quantos tem no grupo do GROUP BY.
				$sql_relatorio = mysql_query("SELECT tomador_nome, count(*) FROM notas GROUP BY tomador_nome ORDER BY count(*) DESC LIMIT 1");
				list($maior_tomador, $maior_tomador_notas) = mysql_fetch_array($sql_relatorio);
				?>
					<table>
					<tr>
					<td>
					<table>
						<tr>
							<td>Numero total de notas emitidas:</td>
							<td><?php echo "$notas emitidas, $notas_C canceladas"; ?></td>
						</tr>
						<tr>
							<td>Maior emissor de notas:</td>
							<td><?php echo "$maior_emissor, $maior_emissor_notas notas "; ?></td>
						</tr>
						<tr>
							<td>Maior tomador de notas:</td>
							<td><?php echo "$maior_tomador, $maior_tomador_notas notas "; ?></td>
						</tr>
					</table>
					</td>
					<?php /*
					<td>
						<table>
							<tr>
								<td>
									<img src="inc/nfe/grafico2.php" />
								</td>
							</tr>
						</table>
					</td>
					*/?>
					</tr>
					</table>
				</fieldset>
				<fieldset><legend>Relatório de notas</legend>
					<form method="post" name="frmNotas">
					<input type="hidden" name="include" id="include" value="<?php echo $_POST["include"]; ?>" />
					<input type="hidden" name="btNotas" id="btNotas" value="<?php echo $_POST["btNotas"]; ?>" />
	
						<table width="550" height="100%">
							<tr>
								<td align="left">Estado</td>
								<td align="left">
									<select name="cmbEstado" class="combo">
										<option value="">Todos</option>
										<?php //Pega o estado do banco e muda a descricao para a vizualização do usuario no combobox
											$sql = mysql_query("SELECT estado FROM notas GROUP BY estado");
											while(list($estado) = mysql_fetch_array($sql))
												{
													switch($estado)
														{
															case "N": $estado = "Emitida";		break;
															case "B": $estado = "Boleto";   	break;
															case "C": $estado = "Cancelada";	break;
															case "E": $estado = "Escriturada";	break;										
														}
													echo "<option value=\"$estado\""; if($_POST["cmbEstado"]==$estado){echo "selected";} echo ">$estado</option>";
												}
										?>
										<option value="RPS"<?php if($_POST["cmbEstado"] =="RPS"){ echo "selected";} ?>>RPS</option>
									</select>
								</td>
							</tr>
							<tr>
								<td width="93" align="left">Periodo inicial</td>
								<td width="375" align="left"><input name="txtDataIni" type="text" maxlength="10" size="18" onKeyUp="MaskData(this)" class="texto" value="<?php echo $_POST["txtDataIni"]; ?>" >
									<font color="#999999">*data no formato 00/00/0000</font></td>
							</tr>
							<tr>
								<td align="left">Periodo final</td> 
								<td align="left"><input name="txtDataFim" type="text" maxlength="10" size="18" onKeyUp="MaskData(this)" class="texto" value="<?php echo $_POST["txtDataFim"]; ?>">
									<font color="#999999"> *data no formato 00/00/0000</font></td>
							</tr>
							<tr>
								<td align="left">Emissor</td>
								<td align="left"><input name="txtEmpresa" type="text" class="texto" size="19" value="<?php echo $_POST["txtEmpresa"]; ?>" /></td>
							</tr>
							<tr>
								<td align="left" colspan="2">
									<input type="submit" class="botao" name="btProcurar" value="Procurar" />
								</td>
							</tr>
						</table> 
					</form>
				</fieldset>
				<?php if($_POST["btProcurar"]) {?>
				<fieldset><legend>Relatório</legend>
					<table align="center">
						<tr>
							<td>
								<?php include("relatorios_notas_emitidas.php"); ?>
							</td>
						</tr>
					</table>
				</fieldset>
				<?php }// fim if de relatorios ?>
			</td>
		</tr>
	</table>
</td>
<td width="19" background="img/form/lateraldir.jpg"></td>
  </tr>
  <tr>
    <td align="left" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantoesq.jpg" /></td>
    <td background="img/form/rodape_fundo.jpg"></td>
    <td align="right" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantodir.jpg" /></td>
  </tr>
</table>