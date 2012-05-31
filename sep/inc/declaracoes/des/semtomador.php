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
//$emissor_CNPJ vem do gerarguia.php

$sql_emissor = mysql_query ("
		SELECT 
			codigo, 
			nome, 
			razaosocial, 
			inscrmunicipal, 
			logradouro, 
			numero, 
			complemento, 
			bairro, 
			cep, 
			municipio, 
			uf, 
			email 
		FROM 
			cadastro 
		WHERE 
			(cnpj = '$emissor_CNPJ' OR cpf = '$emissor_CNPJ') AND 
			estado = 'A'
");

$tipopessoa = tipoPessoa($emissor_CNPJ);

list($cod_emissor,$nome_emissor,$razao_emissor,$im_emissor,$logradouro_emissor,$numero_emissor,$complemento_emissor,
		$bairro_emissor,$cep_emissor,$municipio_emissor,$uf_emissor,$email_emissor)=mysql_fetch_array($sql_emissor);

if(mysql_num_rows($sql_emissor)){
?>

<form method="post" name="frmDesSemTomador">
	<input type="hidden" name="include" id="include" value="<?php echo $_GET['include'];?>" />
	<input type="hidden" name="hdCNPJsemTomador" value="<?php echo $emissor_CNPJ; ?>" />
	<input type="hidden" name="hdCodEmissor" value="<?php echo $cod_emissor; ?>" />
	

		<table width="100%" height="100%" border="0" align="center" cellpadding="3" cellspacing="2">
<tr>
				<td colspan="2" align="left"><em><strong>C&aacute;lculo de Receita Bruta sem Discrimina&ccedil;&atilde;o de Tomadores<br>
  Guia destinada SOMENTE para tributa&ccedil;&atilde;o de receitas PR&Oacute;PRIAS. </strong></em></td>
		</tr>
			<tr>
				<td width="27%" align="left" valign="middle">CNPJ:</td>
			    <td width="73%" align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $emissor_CNPJ; ?></td>
		  </tr>
			<tr>
			  <td align="left" valign="middle">Inscri&ccedil;&atilde;o Municipal:</td>
			  <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $im_emissor;?></td>
		  </tr>
			<tr>
			  <td align="left" valign="middle">Raz&atilde;o Social:</td>
			  <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $razao_emissor;?></td>
		  </tr>
			<tr>
			  <td align="left" valign="middle">Endere&ccedil;o:</td>
			  <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo "$logradouro_emissor - $numero_emissor - $complemento_emissor - $municipio_emissor - $uf_emissor";?></td>
		  </tr>
			<tr>
			  <td align="left" valign="middle">&nbsp;</td>
			  <td align="left" valign="middle">&nbsp;</td>
		  </tr>
			<tr>
			  <td align="left" valign="middle">Per&iacute;odo</td>
			  <td align="left" valign="middle">
				  	<?php
					$mes_atual = date('n');
					$ano_atual = date('Y');
					//array de meses comencando em 1 ate 12
					$meses=array("1"=>"Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
					?>
					  <select name="cmbMes" id="cmbMes" onchange="SomaImpostosDes();CalculaMultaDes();">
						  <option value=""></option>
			              <?php
						  for($ind=1;$ind<=12;$ind++){
							  echo "<option value='$ind'"; if($ind == $mes_atual){echo ' selected="selected"';} echo ">{$meses[$ind]}</option>";
						  }
						  ?>
		              </select>
	                  <select name="cmbAno" id="cmbAno" onchange="SomaImpostosDes();CalculaMultaDes();" >
		              	  	<option value=""></option>
							<?php
							$year=date("Y");
							for($h=0; $h<5; $h++){
								$y=$year-$h;
								echo "<option value=\"$y\""; if($y == $ano_atual){echo ' selected="selected"';} echo ">$y</option>";
							}
							?>
	                  </select>
              </td>
		    </tr>
			<tr>
			  <td colspan="2" align="center" valign="top">
<?php
//pega o dia pra tributacao do mes da tabela configucacoes
$sql_data_trib = mysql_query("SELECT data_tributacao FROM configuracoes");

list($dia_mes)=mysql_fetch_array($sql_data_trib);
campoHidden("hdDia",$dia_mes);

$dataatual = date("d/m/Y");
campoHidden("hdDataAtual",$dataatual);
//pega a regra de multas do banco
$sql_multas = mysql_query(" SELECT codigo, dias, multa, juros_mora
							FROM des_multas_atraso 
							WHERE estado='A'
							ORDER BY dias ASC");
$nroMultas = mysql_num_rows($sql_multas);
echo "<input type=\"hidden\" name=\"hdnroMultas\" id=\"hdNroMultas\" value=\"$nroMultas\" />\n";
$n = 0;
while(list($multa_cod, $multa_dias, $multa_valor, $multa_juros) = mysql_fetch_array($sql_multas)){
	echo "<input type=\"hidden\" name=\"hdMulta_dias$n\" id=\"hdMulta_dias$n\" value=\"$multa_dias\" />
		  <input type=\"hidden\" name=\"hdMulta_valor$n\" id=\"hdMulta_valor$n\" value=\"$multa_valor\" />
		  <input type=\"hidden\" name=\"hdMulta_juros$n\" id=\"hdMulta_juros$n\" value=\"$multa_juros\" />\n";
	$n++;
}
unset($n);


//pega o numero de servicos do emissor
$sql_servicos = mysql_query("SELECT codservico 
							 FROM cadastro_servicos
							 WHERE codemissor='$cod_emissor'");
$num_servicos = mysql_num_rows($sql_servicos);

?>
			    <table border="0" align="center" cellpadding="2" cellspacing="1" bordercolor="#CCCCCC" bgcolor="#FFFFFF">
                <tr>
                  <td width="200" align="center" bgcolor="#CCCCCC">Servi&ccedil;o</td>
                  <td width="70" align="center" bgcolor="#CCCCCC">Al&iacute;q (%)</td>
                  <td width="150" align="center" bgcolor="#CCCCCC">Base de C&aacute;lculo (R$)</td>
				  <td align="center" bgcolor="#CCCCCC">ISS Retido (R$)</td>
                  <td width="150" align="center" bgcolor="#CCCCCC">Imposto (R$)</td>
                </tr>
<?php

//cria a lista de campos para preenchimento da declaracao

if(!$num_servicos){
	$num_servicos = 5;
}

campoHidden("hdServicos",$num_servicos);
for($c=1;$c<=$num_servicos;$c++){
?>                
                <tr>
                  <td align="center"><select style="width:180px;" id="cmbCodServico<?php echo $c;?>"  name="cmbCodServico<?php echo $c;?>" 
						 onchange="var temp = this.value.split('|'); getElementById('txtAliquota<?php echo $c;?>').value = temp[0]; 
								CalculaImpostoDes(txtBaseCalculo<?php echo $c;?>,txtAliquota<?php echo $c;?>,txtImposto<?php echo $c;?>);">
                    <option></option>
                    <?php
						$sql_servicos2 = mysql_query("
							SELECT 
								servicos.codigo, 
								servicos.descricao, 
								servicos.aliquota 
							FROM 
								servicos 
							INNER JOIN cadastro_servicos ON 
								servicos.codigo=cadastro_servicos.codservico
							INNER JOIN cadastro ON 
								cadastro_servicos.codemissor=cadastro.codigo 
							WHERE 
								cadastro.codigo='$cod_emissor'
						");
						
						
						if(!mysql_num_rows($sql_servicos2)){					
							$sql_servicos2 = mysql_query("SELECT servicos.codigo, servicos.descricao, servicos.aliquota FROM servicos ORDER BY descricao");
						}				 
										 
						while(list($cod_serv, $desc_serv, $aliq_serv) = mysql_fetch_array($sql_servicos2))
						{
							if(strlen($desc_serv)>100)
								$desc_serv = substr($desc_serv,0,100)."...";
							echo "<option value=\"$aliq_serv|$cod_serv\" id=\"$aliq_serv\">$desc_serv</option>";
						}
						
						?>
                  </select></td>
                  <td align="center">
					  <input name="txtAliquota<?php echo $c;?>" id="txtAliquota<?php echo $c;?>" type="text" readonly="readonly" style="text-align:right;" size="4" class="texto" />
				  </td>
                  <td align="center">
					<input id="txtBaseCalculo<?php echo $c ?>" name="txtBaseCalculo<?php echo $c ?>" type="text" onkeyup="MaskMoeda(this)" value="0,00" onkeydown="return NumbersOnly(event);" onblur="
					<?php
					if($tipopessoa=="cpf"){ 
						echo "CalculaImpostoRPA(txtBaseCalculo$c, txtAliquota$c, txtImposto$c, txtIssRetido$c);";
					}else{
						echo "CalculaImpostoDes(txtBaseCalculo$c, txtAliquota$c, txtImposto$c, txtIssRetido$c);";
					} 
					?>
					" maxlength="14" size="16" class="texto" style="text-align:right" />
				  </td>
				  <td>
					<input name="txtIssRetido<?php echo $c;?>" id="txtIssRetido<?php echo $c;?>" style="text-align:right;" type="text" value="0,00" size="7" class="texto"
					onblur="
					<?php
					if($tipopessoa=="cpf"){ 
						echo "CalculaImpostoRPA(txtBaseCalculo$c, txtAliquota$c, txtImposto$c, txtIssRetido$c);";
					}else{
						echo "CalculaImpostoDes(txtBaseCalculo$c, txtAliquota$c, txtImposto$c, txtIssRetido$c);";
					} 
					?>
					" onkeydown="return NumbersOnly(event);" onkeyup="MaskMoeda(this);" />
				  </td>
                  <td align="center">
				  	<input name="txtImposto<?php echo $c;?>" id="txtImposto<?php echo $c;?>" style="text-align:right;" type="text" value="0,00" readonly="readonly" size="12" class="texto" />
				  </td>
                </tr>
<?php

}//fim listagem dos campos pra declaracao

?>                  
              </table>              
              </td>
		  </tr>
		  <tr>
			  <td align="left" valign="middle">Imposto Total:</td>
			  <td align="left" valign="middle"><input type="text" name="txtImpostoTotal" id="txtImpostoTotal" value="0,00"style="text-align:right;" readonly="readonly" size="16" class="texto" /></td>
		  </tr>
		  <tr style="display: none;">
			  <td align="left" valign="middle">Multa e Juros de Mora:</td>
			  <td align="left" valign="middle"><input type="text" name="txtMultaJuros" id="txtMultaJuros" value="0,00" style="text-align:right;" readonly="readonly" size="16" class="texto" /></td>
		  </tr>
		  <tr style="display: none;">
			  <td align="left" valign="middle"><b>Total a Pagar:</b></td>
			  <td align="left" valign="middle"><input type="text" name="txtTotalPagar" id="txtTotalPagar" value="0,00" style="text-align:right;" readonly="readonly" size="16" class="texto" /></td>
		  </tr>
		  <tr>
			  <td align="left" valign="middle">&nbsp;</td>
			  <td align="left" valign="middle"><em>* Confira seus dados antes de continuar<br>
              ** Desabilite seu bloqueador de pop-up</em></td>
		  </tr>
		  <tr>
			  <td align="right" valign="middle">
			  	<input type="submit" value="Declarar" name="btDeclararSemtomador" class="botao" onclick="return (ValidaFormulario('cmbMes|cmbAno|cmbCodServico1|txtBaseCalculo1','O Período e pelo menos um serviço devem ser preenchidos!')) && (confirm('Confira seus dados antes de continuar'));" />
			  </td>
			  <td align="left" valign="middle"><input type="submit" name="btVoltar" id="btVoltar" class="botao" value="Voltar" /></td>
		  </tr>
	  </table>		
    
</form>
<?php
}else{
	echo "<b>CNPJ/CPF não cadastrado ou não foi liberado!</b>";
}
?>