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
	
	$dados['codigo'] = $codigo;
?>
	<table width="100%" height="100%" border="0" align="center" cellpadding="5" cellspacing="0" >
		<tr>
			<td width="15%" align="left" valign="middle">&nbsp;</td>
			<td width="85%" align="left" valign="middle">&nbsp;</td>
		</tr>
		<tr>
			<td align="left" valign="middle">Per&iacute;odo</td>
			<td align="left" valign="middle">
				<!--
				 Função para verificar obras pela competencia
				 acessoAjax('inc/declaracoes/decc/declarar.ajax.php','frmDesSemTomador','tdObra'); 
				-->
				<select name="cmbMes" id="cmbMes" onChange="decc.SomaImpostos();decc.CalculaMulta();">
					<option value=""> </option>
					<option value="1">Janeiro</option>
					<option value="2">Fevereiro</option>
					<option value="3">Março</option>
					<option value="4">Abril</option>
					<option value="5">Maio</option>
					<option value="6">Junho</option>
					<option value="7">Julho</option>
					<option value="8">Agosto</option>
					<option value="9">Setembro</option>
					<option value="10">Outubro</option>
					<option value="11">Novembro</option>
					<option value="12">Dezembro</option>
				</select>
				<select name="cmbAno" id="cmbAno" onChange="decc.SomaImpostos();decc.CalculaMulta();" >
					<option value=""> </option>
					<?php
						$year=date("Y");
						for($h=0; $h<5; $h++){
							$y=$year-$h;
							echo "<option value=\"$y\">$y</option>";
						}
					  ?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Obra</td>
			<td id="tdObra">
				<?php 
				$sql_obras=mysql_query("SELECT codigo, obra FROM obras WHERE codcadastro='{$dados['codigo']}'");
				if(mysql_num_rows($sql_obras)>0){
					?>
					<select name="cmbObra" id="cmbObra" style="width:145px;">
						<option></option>
						<?php
						while($dados_obra=mysql_fetch_array($sql_obras)){
							echo "<option value=\"".$dados_obra['codigo']."\">".$dados_obra['obra']."</option>";
						}
					?>
					</select>
					<?php 
				}else{
					echo "<b>Sem obras cadastradas</b>";
				}
				?>
            </td>
		</tr>
		<tr>
			<td colspan="2" align="center" valign="top">
				<table border="0" align="center" cellpadding="2" cellspacing="1" bordercolor="#CCCCCC" bgcolor="#FFFFFF">
					<tr>
						<td align="center" bgcolor="#CCCCCC">Servi&ccedil;o / Atividade</td>
						<td align="center" bgcolor="#CCCCCC">Al&iacute;q (%)</td>
						<td align="center" bgcolor="#CCCCCC">Base de C&aacute;lculo (R$)</td>
						<td align="center" bgcolor="#CCCCCC">ISS (R$)</td>
						<td align="center" bgcolor="#CCCCCC">N&ordm;. Documento</td>
					</tr>
					<?php

					listaRegrasMultaDes();//cria os campos hidden com as regras pra multa da declaracao
					
					//pega o numero de servicos do emissor
					$sql_servicos = mysql_query("SELECT codservico 
												 FROM cadastro_servicos
												 WHERE codemissor='".$dados['codigo']."'");
					$num_servicos = 1;//quantos linhas vão aparecer pra preencher
					$num_serv_max = 20;// numero maximo de linhas que podem ser adicionadas
					
					campoHidden("hdServicos",$num_servicos);
					campoHidden("hdServMax",$num_serv_max-1);
					//cria a lista de campos para preenchimento da declaracao
					$trServStyle = "";
			
					for($c=1;$c<$num_serv_max;$c++){
					?>
					<tr id="trServ<?php echo $c;?>" style="<?php echo $trServStyle;?>">
						<td align="center" id="tdCmbServ<?php echo $c;?>">
							<select style="width:150px;" id="cmbCodServico<?php echo $c;?>"  name="cmbCodServico<?php echo $c;?>" 
									 onchange="var temp = this.value.split('|'); getElementById('txtAliquota<?php echo $c;?>').value = temp[0]; 
											decc.CalculaImposto(txtBaseCalculo<?php echo $c;?>,txtAliquota<?php echo $c;?>,txtImposto<?php echo $c;?>);">
								<option></option>
								<?php
									
									$sql_servicos2 = mysql_query("SELECT servicos.codigo, 
                                                                  servicos.descricao,
                                                                  servicos.aliquota
                                                                  FROM servicos
                                                                  INNER JOIN cadastro_servicos
                                                                  ON servicos.codigo=cadastro_servicos.codservico
                                                                  INNER JOIN cadastro
                                                                  ON cadastro_servicos.codemissor=cadastro.codigo
                                                                  WHERE cadastro.codigo='".$dados['codigo']."'");
									while(list($cod_serv, $desc_serv, $aliq_serv) = mysql_fetch_array($sql_servicos2))
									{
										if(strlen($desc_serv)>100)
											$desc_serv = substr($desc_serv,0,100)."...";
										echo "<option value=\"$aliq_serv|$cod_serv\" id=\"$aliq_serv\">$desc_serv</option>";
									}

									
								?>
							</select>
						</td>
						<td align="center">
							<input name="txtAliquota<?php echo $c;?>" id="txtAliquota<?php echo $c;?>" type="text" readonly="readonly" style="text-align:right;" size="4" class="texto" />
						</td>
						<td align="center"><?php echo "<input name=\"txtBaseCalculo$c\" id=\"txtBaseCalculo$c\" name=\"txtBaseCalculo$c\" type=\"text\" onkeyup=\"MaskMoeda(this)\" value=\"0,00\" onkeydown=\"return NumbersOnly(event);\" onblur=\"decc.CalculaImposto(txtBaseCalculo$c, txtAliquota$c, txtImposto$c);\" maxlength=\"12\" size=\"12\" class=\"texto\" style=\"text-align:right\" />"; ?></td>
						<td align="center">
							<input name="txtImposto<?php echo $c;?>" id="txtImposto<?php echo $c;?>" style="text-align:right;" type="text" value="0,00" readonly="readonly" size="10" class="texto" />
						</td>
						<td align="center">
							<input name="txtNroDoc<?php echo $c;?>" id="txtNroDoc<?php echo $c;?>" type="text" size="10" class="texto" />
						</td>
					</tr>
					<tr id="trServb<?php echo $c;?>" style="<?php echo $trServStyle;?>">
						<td id="tdServ<?php echo $c;?>" colspan="6" align="center" valign="top">&nbsp;</td>
					</tr>
					<?php
						if ($c>=$num_servicos){
							$trServStyle = "display:none;";
						}
						
					}//fim while listagem dos campos pra declaracao
					
					?>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right" valign="middle">
				<input name="btServRemover" id="btServRemover" type="button" value="Remover Serviço" class="botao" disabled="disabled" onClick="decc.RemoverServ();">
				<input name="btServInserir" id="btServInserir" type="button" value="Inserir Serviço" class="botao" onClick="decc.InserirServ();montaCombo();">
			</td>
		</tr>
		<tr>
			<td align="left" valign="middle">Imposto Total:</td>
			<td align="left" valign="middle">
				<input type="text" name="txtImpostoTotal" id="txtImpostoTotal" value="0,00"style="text-align:right;" readonly="readonly" size="16" class="texto" />
			</td>
		</tr>
		<tr style="display:none;">
			<td align="left" valign="middle">Multa e Juros de Mora:</td>
			<td align="left" valign="middle">
				<input type="text" name="txtMultaJuros" id="txtMultaJuros" value="0,00" style="text-align:right;" readonly="readonly" size="16" class="texto" />
			</td>
		</tr>
		<tr style="display:none;">
			<td align="left" valign="middle"><b>Total a Pagar:</b></td>
			<td align="left" valign="middle">
				<input type="text" name="txtTotalPagar" id="txtTotalPagar" value="0,00" style="text-align:right;" readonly="readonly" size="16" class="texto" />
			</td>
		</tr>
		<tr>
			<td align="left" valign="middle">&nbsp;</td>
			<td align="right" valign="middle"><em>* Confira seus dados antes de continuar<br>
				** Desabilite seu bloqueador de pop-up</em></td>
		</tr>
		<tr>
			<td align="left" valign="middle">&nbsp;</td>
			<td align="left" valign="middle">
				<input type="submit" value="Declarar" name="btDeclarar" class="botao" onClick="return (ValidaFormulario('cmbMes|cmbAno|cmbCodServico1|txtBaseCalculo1|txtNroDoc1|cmbObra','O Período, uma obra e pelo menos um serviço devem ser preenchidos!')) && (confirm('Confira seus dados antes de continuar'));" />
				<input type="submit" name="btVoltar" class="botao" value="Voltar" />
			</td>
		</tr>
	</table>
