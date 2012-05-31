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
	<table width="100%" height="100%" bgcolor="#CCCCCC" border="0" align="center" cellpadding="5" cellspacing="0">
		<tr height="10">&nbsp;</tr>
		<tr>
			<td colspan="2" align="center" valign="top">
				<table border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" width="100%">
					<tr align="center">
						<td> Per&iacute;odo:  Mês:
							<select name="cmbMes" id="cmbMes" onchange="SomaImpostosDes();CalculaMultaDes();">
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
							Ano:
							<select name="cmbAno" id="cmbAno" onchange="SomaImpostosDes();CalculaMultaDes();" >
								<?php $ano = date("Y");?>
								<option value=""> </option>
								<?php
								for($cont = 0; $contano <=4; $contano++){
									echo "<option value=\"$ano\">$ano</option>";
									$ano--;
								}
								?>
							</select>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<?php
			
			listaRegrasMultaDes();//cria os campos hidden com as regras pra multa da declaracao
			
			//pega o numero de servicos do emissor
			
			
			$num_servicos = 1;//quantos linhas vão aparecer pra preencher
			$num_serv_max = 20;// numero maximo de linhas que podem ser adicionadas
			
			campoHidden("hdServicos",$num_servicos);
			
			campoHidden("hdServMax",$num_serv_max-1);
			//cria a lista de campos para preenchimento da declaracao
			
			for($c=1;$c<$num_serv_max;$c++){
		?>
		<!--TR QUE VAI CONTER ID-->
		<tr id="trServ<?php echo $c;?>" style="<?php echo $trServStyle;?>" bgcolor="#999999">
			<td colspan="7">
				<table border="0" align="center" cellspacing="0" bordercolor="#FFFFFF" width="100%">
					<tr>
						<td align="left" colspan="2" >
							<select style="width:285px;" id="cmbEstabelecimento<?php echo $c;?>"  name="cmbEstabelecimento<?php echo $c;?>" onchange="buscaServicosCartorioTipo(this, 'tdListarServ<?php echo $c;?>',<?php echo $c;?>);">
								<option value="">Tipo de Estabelecimento</option>
								<?php
									$estabelecimento = mysql_query("SELECT cartorios_tipo.codigo, cartorios_tipo.tipocartorio FROM cartorios_tipo");
									while(list($codcart, $tipo) = mysql_fetch_array($estabelecimento))
									{
										echo "<option value=\"$codcart\" id=\"$tipo\">$tipo</option>";
									}
								?>
							</select>
						</td>
						<td align="left" id="tdListarServ<?php echo $c;?>" colspan="3">
							<select style="width:275px;" id="cmbCodCart<?php echo $c;?>"  name="cmbCodCart<?php echo $c;?>" >
								<option >Selecione o tipo de Estabelecimento</option>
							</select>
						</td>
					</tr>
					<tr height="1"></tr>
					<tr bgcolor="#FFFFFF" align="center">
						<td width="144" align="center">Base de C&aacute;lculo (R$)</td>
						<td align="center" width="156">Valor do Emolumento</td>
						<td align="center" width="69">ISS (R$)</td>
						<td width="57" align="center">Al&iacute;q (%)</td>
						<td align="center" width="119">N&ordm;. Documento</td>
					</tr>
					<tr bgcolor="#FFFFFF">
						<td align="center"><?php echo "<input name=\"txtBaseCalculo$c\" id=\"txtBaseCalculo$c\" name=\"txtBaseCalculo$c\" type=\"text\" onkeyup=\"MaskMoeda(this)\" value=\"0,00\" onkeydown=\"return NumbersOnly(event);\" onblur=\"CalculaImpostoDes(txtBaseCalculo$c, txtAliquota$c, txtImposto$c);\" maxlength=\"12\" size=\"12\" class=\"texto\" style=\"text-align:right\" />"; ?></td>
						<td align="center">
							<input name="txtEmo<?php echo $c;?>" id="txtEmo<?php echo $c;?>" onkeydown="return NumbersOnly(event);" style="text-align:right;" onkeyup="MaskMoeda(this)" value="0,00" onblur="CalculaImpostoDes(<?php echo "txtBaseCalculo$c, txtAliquota$c, txtImposto$c"; ?>);" type="text" size="10" class="texto" />
						</td>
						<td align="center">
							<input name="txtImposto<?php echo $c;?>" id="txtImposto<?php echo $c;?>" style="text-align:right;" type="text" value="0,00" readonly="readonly" size="10" class="texto" />
						</td>
						<td align="center">
							<input name="txtAliquota<?php echo $c;?>" id="txtAliquota<?php echo $c;?>" type="text" readonly="readonly" style="text-align:right;" size="4" class="texto" />
						</td>
						<td align="center">
							<input name="txtNroDoc<?php echo $c;?>" id="txtNroDoc<?php echo $c;?>" type="text" size="10" class="texto" />
						</td>
					</tr>
				</table>
			</td>
		</tr>
			<?php
					if ($c>=$num_servicos){
						$trServStyle = "display:none;";
					}
	
			}//fim while listagem dos campos pra declaracao
	
			?>
	<tr>
		<td colspan="2" align="right" valign="middle">
			<input name="btServRemover" id="btServRemover" type="button" value="Remover Serviço" class="botao" disabled="disabled" onclick="EmissorRemoverServ();">
			<input name="btServInserir" id="btServInserir" type="button" value="Inserir Serviço" class="botao" onclick="EmissorInserirServ();">
		</td>
	</tr>
	<tr>
		<td align="left" valign="middle">Imposto Total:</td>
		<td align="left" valign="middle">
			<input type="text" name="txtImpostoTotal" id="txtImpostoTotal" value="0,00"style="text-align:right;" readonly="readonly" size="16" class="texto" />
		</td>
	</tr>
	<tr style="display: none;">
		<td align="left" valign="middle">Multa e Juros de Mora:</td>
		<td align="left" valign="middle">
			<input type="text" name="txtMultaJuros" id="txtMultaJuros" value="0,00" style="text-align:right;" readonly="readonly" size="16" class="texto" />
		</td>
	</tr>
	<tr style="display: none;">
		<td align="left" valign="middle"><b>Total a Pagar:</b></td>
		<td align="left" valign="middle">
			<input type="text" name="txtTotalPagar" id="txtTotalPagar" value="0,00" style="text-align:right;" readonly="readonly" size="16" class="texto" />
		</td>
	</tr>
	<tr>
		<td align="right" valign="middle">&nbsp;</td>
		<td align="right" valign="middle"><em>* Confira seus dados antes de continuar<br>** Desabilite seu bloqueador de pop-up</em></td>
	</tr>
	<tr>
		<td align="right" valign="middle">
			<input type="submit" value="Declarar" name="btDeclarar" class="botao" 
			onclick="return (ValidaFormMsg('txtCNPJ|cmbMes|cmbAno|cmbCodCart1|txtBaseCalculo1|txtNroDoc1|cmbEstabelecimento1|cmbCodCart1','O Período e pelo menos um serviço devem ser preenchidos!')) && (confirm('Confira seus dados antes de continuar'));" />
			<input type="submit" name="btVoltar" class="botao" value="Voltar" />
		</td>
	</tr>
	</table>
