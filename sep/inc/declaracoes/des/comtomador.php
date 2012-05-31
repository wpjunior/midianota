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
// teste para aplicar regra de imposto RPA para cpf ou ISS normal para CNPJ
$tipopessoa = tipoPessoa($emissor_CNPJ);

$sql_tomador = mysql_query("
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
		(cnpj='$emissor_CNPJ' OR cpf='$emissor_CNPJ') AND
		estado = 'A'
");

if(mysql_num_rows($sql_tomador)<=0) {
	echo "<b>Este cnpj/cpf não está cadastrado ou não foi liberado!</b>";
}else{
	list($cod_emissor,$nome_emissor,$razao_emissor,$im_emissor,$logradouro_emissor,$numero_emissor,$complemento_emissor,
		$bairro_emissor,$cep_emissor,$municipio_emissor,$uf_emissor,$email_emissor)=mysql_fetch_array($sql_tomador);
		
	?>

	<form method="post" name="frmDesCemTomador">
	<input type="hidden" name="include" id="include" value="<?php echo $_GET['include'];?>" />
	<input type="hidden" name="hdCnpjComTomador" value="<?php echo $emissor_CNPJ; ?>" />
	<input type="hidden" name="hdCodEmissor" value="<?php echo $cod_emissor; ?>" />
		
	
			<table width="100%" height="100%" border="0" align="center" cellpadding="3" cellspacing="2">
<tr>
					<td colspan="2" align="left"><em><strong>C&aacute;lculo de Receita Bruta com Discrimina&ccedil;&atilde;o de Tomadores<br>
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
				  
				    <table border="0" align="center" cellpadding="2" cellspacing="1" bordercolor="#CCCCCC" bgcolor="#FFFFFF">
	                <tr>
	                  <td align="center" bgcolor="#CCCCCC"> Tomador (CPF/CNPJ)</td>
	                  <td align="center" bgcolor="#CCCCCC">Servi&ccedil;o / Atividade</td>
	                  <td align="center" bgcolor="#CCCCCC"><?php echo $tipopessoa=='cpf'?'RPA':'Al&iacute;q (%)'; ?></td>
	                  <td align="center" bgcolor="#CCCCCC">Base de C&aacute;lculo (R$)</td>
	                  <td align="center" bgcolor="#CCCCCC">ISS Retido (R$)</td>
	                  <td align="center" bgcolor="#CCCCCC">ISS (R$)</td>
	                  <td align="center" bgcolor="#CCCCCC">N&ordm;. Documento</td>
	                </tr>
                    <tr>
	<?php
	
	listaRegrasMultaDes();//cria os campos hidden com as regras pra multa da declaracao
	
	//pega o numero de servicos do emissor
	$sql_servicos = mysql_query("SELECT codservico 
								 FROM cadastro_servicos
								 WHERE codemissor='$cod_emissor'");
	$num_servicos = 1;//quantos linhas vão aparecer pra preencher
	$num_serv_max = 20;// numero maximo de linhas que podem ser adicionadas
	
	campoHidden("hdServicos",$num_servicos);
	campoHidden("hdServMax",$num_serv_max-1);
	//cria a lista de campos para preenchimento da declaracao
	for($c=1;$c<$num_serv_max;$c++){
	?>                
	                <tr id="trServ<?php echo $c;?>" style="<?php echo $trServStyle;?>">
	                  <td align="center">
	                  	<input name="txtTomadorCnpjCpf<?php echo $c;?>" id="txtTomadorCnpjCpf<?php echo $c;?>" size="18" maxlength="18" type="text" class="texto" onkeyup="CNPJCPFMsk(this);" onkeydown="return NumbersOnly(event);" onblur="verificaTomador(this,<?php echo $c;?>)" />
	                  </td>
	                  <td align="center">
		                  <select style="width:150px;" id="cmbCodServico<?php echo $c;?>"  name="cmbCodServico<?php echo $c;?>" 
								onchange="
								<?php
								if($tipopessoa=="cpf"){//var de teste tipopessoa que vem do comeco dessa pagina
								?>
								var temp = this.value.split('|'); 
								getElementById('txtAliquota<?php echo $c;?>').value = temp[2]; 
								CalculaImpostoRPA(document.getElementById('txtBaseCalculo<?php echo $c;?>'),('txtAliquota<?php echo $c;?>'),('txtImposto<?php echo $c;?>'));
								<?php
								}else{
								?>
								var temp = this.value.split('|'); 
								getElementById('txtAliquota<?php echo $c;?>').value = temp[0]; 
								CalculaImpostoDes(document.getElementById('txtBaseCalculo<?php echo $c;?>'),('txtAliquota<?php echo $c;?>'),('txtImposto<?php echo $c;?>'));
								<?php
								}
								?>
								" >
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
									$sql_servicos2 = mysql_query("SELECT servicos.codigo, servicos.descricao, servicos.aliquota, servicos.valor_rpa FROM servicos ORDER BY descricao");
								}
								while(list($cod_serv, $desc_serv, $aliq_serv, $valor_rpa) = mysql_fetch_array($sql_servicos2))
								{
									if(strlen($desc_serv)>100){
										$desc_serv = substr($desc_serv,0,100)."...";
									}
									echo "<option value=\"$aliq_serv|$cod_serv|$valor_rpa\" id=\"$aliq_serv\">$desc_serv</option>";
								}
								
								?>
		                  </select>
		              </td>
	                  <td align="center"><input name="txtAliquota<?php echo $c;?>" id="txtAliquota<?php echo $c;?>" type="text" readonly="readonly" style="text-align:right;" size="4" class="texto" /></td>
	                  <td align="center">
						<input name="txtBaseCalculo<?php echo $c ?>" id="txtBaseCalculo<?php echo $c ?>" type="text"
						onkeyup="MaskMoeda(this)" value="0,00" onkeydown="return NumbersOnly(event);" 
						onblur="
						<?php
						if($tipopessoa=="cpf"){ 
							echo "CalculaImpostoRPA(txtBaseCalculo$c, txtAliquota$c, txtImposto$c, txtIssRetido$c);";
						}else{
							echo "CalculaImpostoDes(txtBaseCalculo$c, txtAliquota$c, txtImposto$c, txtIssRetido$c);";
						} 
						?>
						" maxlength="12" size="12" class="texto" style="text-align:right" /> 
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
						  <input name="txtImposto<?php echo $c;?>" id="txtImposto<?php echo $c;?>" style="text-align:right;" type="text" value="0,00" readonly="readonly" size="10" class="texto" />
					  </td>
	                  <td align="center"><input name="txtNroDoc<?php echo $c;?>" id="txtNroDoc<?php echo $c;?>" type="text" size="10" class="texto" /></td>
	                </tr>
                    <tr id="trServb<?php echo $c;?>" style="<?php echo $trServStyle;?>">
                        <td id="tdServ<?php echo $c;?>" colspan="7" align="center" valign="top">&nbsp;</td>
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
	                  <input name="btServInserir" id="btServInserir" type="button" value="Inserir NF" class="botao" onclick="EmissorInserirServ();">
	                  <input name="btServRemover" id="btServRemover" type="button" value="Remover NF" class="botao" disabled="disabled" onclick="EmissorRemoverServ();">
                  </td>
			  </tr>
			  <tr>
				  <td align="left" valign="middle">Imposto Total:</td>
				  <td align="left" valign="middle"><input type="text" name="txtImpostoTotal" id="txtImpostoTotal" value="0,00" style="text-align:right;" readonly="readonly" size="16" class="texto" /></td>
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
				  <td align="right" valign="middle">
				  	<em>* Confira seus dados antes de continuar<br>** Desabilite seu bloqueador de pop-up</em>
				</td>
			  </tr>
			  <tr>
				  <td align="right" valign="middle">
				  	<input type="submit" value="Declarar" name="btDeclararComtomador" class="botao" 
					onclick="return (validadeclaracao()) && (confirm('Confira seus dados antes de continuar'));" />
				  </td>
				  <td align="left" valign="middle"><input type="submit" name="btVoltar" id="btVoltar" class="botao" value="Voltar" /></td>
			  </tr>
		  </table>		
	    
	    
    </form>
<?php
}//fim else se encontrou o cnpj no banco
?>
