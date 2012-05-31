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
	$cnpj = $_SESSION['login'];
	$sql_emissor = mysql_query("SELECT codigo FROM cadastro WHERE cnpj = '$cnpj' OR cpf = '$cnpj'");
	list($codemissor) = mysql_fetch_array($sql_emissor);
	$sql=mysql_query("SELECT inscrmunicipal, razaosocial, logradouro, numero, complemento, municipio, uf FROM cadastro WHERE codigo = '$codemissor'");
	list($inscrmunicipal,$razaosocial,$logradouro,$numero,$complemento,$municipio,$uf)=mysql_fetch_array($sql);
	$endereco = "$logradouro, $numero";
	if($complemento)
		$endereco .= ", $complemento";
	
?>
<form method="post" name="frmDesCemTomador" action="include/simples/geraguia.php" target="_parent" onsubmit="return confirm('Confira seus dados antes de continuar');">
<input type="hidden" name="hdCnpjComTomador" value="<?php echo $cnpj; ?>" />
<input type="hidden" name="hdCodEmissor" value="<?php echo $codemissor; ?>" />

<table width="580" border="0" cellpadding="0" cellspacing="1">
	<tr>
		<td width="5%" height="10" bgcolor="#FFFFFF"></td>
		<td width="65%" align="center" bgcolor="#FFFFFF" rowspan="3" class="fieldsetCab">DESN - Declaração Eletrônica do Simples Nacional</td>
		<td width="30%" bgcolor="#FFFFFF"></td>
	</tr>
	<tr>
	  <td height="1" bgcolor="#CCCCCC"></td>
	  <td bgcolor="#CCCCCC"></td>
	</tr>
	<tr>
	  <td height="10" bgcolor="#FFFFFF"></td>
	  <td bgcolor="#FFFFFF"></td>
	</tr>
	<tr>
		<td colspan="3" height="1" bgcolor="#CCCCCC"></td>
	</tr>
	<tr>
		<td height="60" colspan="3" bgcolor="#CCCCCC">

		<table width="100%" height="100%" border="0" align="center" cellpadding="3" cellspacing="2">
<tr>
				<td colspan="2" align="left"><strong>C&aacute;lculo de Receita Bruta com Discrimina&ccedil;&atilde;o de Tomadores</strong><br>
  <!--Guia destinada SOMENTE para tributa&ccedil;&atilde;o de receitas PR&Oacute;PRIAS. </strong></td>-->
		</tr>
		<tr>
			<td width="27%" align="left" valign="middle">CNPJ:</td>
			<td width="73%" align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $cnpj; ?></td>
		</tr>
		<!--<tr>
			<td align="left" valign="middle">Inscri&ccedil;&atilde;o Municipal:</td>
			<td align="left" valign="middle"><?php //echo $inscrmunicipal;?></td>
		</tr>-->
		<tr>
			<td align="left" valign="middle">Raz&atilde;o Social:</td>
			<td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $razaosocial;?></td>
		</tr>
		<tr>
			<td align="left" valign="middle">Endere&ccedil;o:</td>
			<td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo "$endereco - $municipio - $uf";?></td>
		</tr>
		<tr>
			<td align="left" valign="middle">&nbsp;</td>
			<td align="left" valign="middle">&nbsp;</td>
		</tr>
			<tr>
			  <td align="left" valign="middle">Per&iacute;odo</td>
			  <td align="left" valign="middle">
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
				  <select name="cmbAno" id="cmbAno" onchange="SomaImpostosDes();CalculaMultaDes();" >
					  <option value=""> </option>
					  <?php
					  	$ano=date("Y");
						for($x=0; $x<=4; $x++){
							$year=$ano-$x;
							echo "<option value=\"$year\">$year</option>";
						}
					  ?>
				  </select>
			  </td>
			</tr>
			<tr>
			  <td colspan="2" align="center" valign="top">
			  
				<table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" bordercolor="#CCCCCC" bgcolor="#FFFFFF">
				<tr>
				  <td align="center" bgcolor="#CCCCCC"> Tomador (CPF/CNPJ)</td>
				  <td align="center" bgcolor="#CCCCCC">Servi&ccedil;o / Atividade</td>
				  <td style="display: none;" align="center" bgcolor="#CCCCCC">Al&iacute;q (%)</td>
				  <td align="center" bgcolor="#CCCCCC">Base de C&aacute;lculo (R$)</td>
				  <td style="display: none" align="center" bgcolor="#CCCCCC">ISS (R$)</td>
				  <td align="center" bgcolor="#CCCCCC">N&ordm;. Documento</td>
				</tr>
				<tr>
<?php

listaRegrasMultaDes();//cria os campos hidden com as regras pra multa da declaracao

//pega o numero de servicos do emissor

$sql_servicos = mysql_query("
	SELECT codservico 
	FROM cadastro_servicos
	WHERE codemissor='$codemissor'
");
$num_servicos = 1;//quantos linhas vão aparecer pra preencher
$num_serv_max = 20;// numero maximo de linhas que podem ser adicionadas

campoHidden("hdServicos",$num_servicos);
campoHidden("hdServMax",$num_serv_max-1);
//cria a lista de campos para preenchimento da declaracao
for($c=1;$c<$num_serv_max;$c++){
?>                
				<tr id="trServ<?php echo $c;?>" style="<?php echo $trServStyle;?>">
				  <td align="center">
					<input name="txtTomadorCnpjCpf<?php echo $c;?>" id="txtTomadorCnpjCpf<?php echo $c;?>" size="18" maxlength="18" type="text" class="texto" onkeyup="CNPJCPFMsk(this);" onkeydown="return NumbersOnly(event);" />
				  </td>
				  <td align="center">
					  <select style="width:133px;" id="cmbCodServico<?php echo $c;?>"  name="cmbCodServico<?php echo $c;?>" 
							 onchange="var temp = this.value.split('|'); getElementById('txtAliquota<?php echo $c;?>').value = temp[0]; 
									CalculaImpostoDes(txtBaseCalculo<?php echo $c;?>,txtAliquota<?php echo $c;?>,txtImposto<?php echo $c;?>);">
						<option></option>
						<?php
							
							$sql_servicos2 = mysql_query("
								SELECT servicos.codigo, servicos.descricao, servicos.aliquota FROM servicos 
								INNER JOIN cadastro_servicos ON servicos.codigo=cadastro_servicos.codservico
								INNER JOIN cadastro ON cadastro_servicos.codemissor=cadastro.codigo 
								WHERE cadastro.codigo='$codemissor'
							");
							while(list($cod_serv, $desc_serv, $aliq_serv) = mysql_fetch_array($sql_servicos2))
							{
								if(strlen($desc_serv)>100)
									$desc_serv = substr($desc_serv,0,100)."...";
								echo "<option value=\"$aliq_serv|$cod_serv\" id=\"$aliq_serv\">$desc_serv</option>";
							}
							
							?>
					  </select>
				  </td>
				  <td style="display: none;" align="center"><input name="txtAliquota<?php echo $c;?>" id="txtAliquota<?php echo $c;?>" type="text" readonly="readonly" style="text-align:right;" size="4" class="texto" /></td>
				  <td align="center"><?php echo "<input name=\"txtBaseCalculo$c\" id=\"txtBaseCalculo$c\" name=\"txtBaseCalculo$c\" type=\"text\" onkeyup=\"MaskMoeda(this)\" value=\"0,00\" onkeydown=\"return NumbersOnly(event);\" onblur=\"CalculaImpostoDes(txtBaseCalculo$c, txtAliquota$c, txtImposto$c);\" maxlength=\"12\" size=\"12\" class=\"texto\" style=\"text-align:right\" />"; ?></td>
				  <td style="display: none" align="center"><input name="txtImposto<?php echo $c;?>" id="txtImposto<?php echo $c;?>" style="text-align:right;" type="text" value="0,00" readonly="readonly" size="10" class="texto" /></td>
				  <td align="center"><input name="txtNroDoc<?php echo $c;?>" id="txtNroDoc<?php echo $c;?>" type="text" size="10" class="texto" /></td>
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
				  <input name="btServRemover" id="btServRemover" type="button" value="Remover NF" class="botao" disabled="disabled" onclick="EmissorRemoverServ();">
				  <input name="btServInserir" id="btServInserir" type="button" value="Inserir NF" class="botao" onclick="EmissorInserirServ();">
			  </td>
		  </tr>
		  <tr style="display: none">
			  <td align="left" valign="middle">Imposto Total:</td>
			  <td align="left" valign="middle"><input type="text" name="txtImpostoTotal" id="txtImpostoTotal" value="0,00"style="text-align:right;" readonly="readonly" size="16" class="texto" /></td>
		  </tr>
		  <tr style="display: none">
			  <td align="left" valign="middle">Multa e Juros de Mora:</td>
			  <td align="left" valign="middle"><input type="text" name="txtMultaJuros" id="txtMultaJuros" value="0,00" style="text-align:right;" readonly="readonly" size="16" class="texto" /></td>
		  </tr>
		  <tr style="display: none">
			  <td align="left" valign="middle"><b>Total a Pagar:</b></td>
			  <td align="left" valign="middle"><input type="text" name="txtTotalPagar" id="txtTotalPagar" value="0,00" style="text-align:right;" readonly="readonly" size="16" class="texto" /></td>
		  </tr>
		  <tr>
			  <td align="left" valign="middle">&nbsp;</td>
			  <td align="left" valign="middle"><em>* Confira seus dados antes de continuar<br>
			  ** Desabilite seu bloqueador de pop-up</em></td>
		  </tr>
		  <tr>
			  <td align="left" valign="middle">&nbsp;</td>
			  <td align="left" valign="middle"><input type="submit" value="Declarar" class="botao" onclick="return ValidaFormMsg('cmbMes|cmbAno|txtTomadorCnpjCpf1|cmbCodServico1|txtBaseCalculo1|txtNroDoc1','O Período e pelo menos um serviço devem ser preenchidos!');" /></td>
		  </tr>
	  </table>		
	  </td>
	</tr>
	<tr>
		<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
	</tr>
</table>    
	
	
</form>