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
	if($_POST['btDeclararComtomador'] == "Declarar"){
		include("inc/declaracoes/des/gerarguia_comtomador.php");
	}
	if($_POST['btDeclararSemtomador'] == "Declarar"){
		include("inc/declaracoes/des/gerarguia_semtomador.php");
	}
	if($_POST['btDeclararTomador'] == "Declarar"){
		include("inc/declaracoes/des/tomadores_sql.php");
	}
	if($_POST["btBoleto"] == "Gerar Boleto"){
		include("inc/declaracoes/des/guias/gerar_boleto.php");
	}
?>
<script language="javascript">
<!--
	function ConsultaCnpj2(campo,cont){
		if(campo.value!=''){
			var req;
			// Verificar o Browser
			// Firefox, Google Chrome, Safari e outros
			if(window.XMLHttpRequest){
			   req = new XMLHttpRequest();
			}
			// Internet Explorer
			else if(window.ActiveXObject) {
			   req = new ActiveXObject("Microsoft.XMLHTTP");
			}
			
			var url='inc/verificaprestadorcnpj.ajax.php?valor='+campo.value;
			
			req.open("Get", url, true);
				 
			// Quando o objeto recebe o retorno, chamamos a seguinte função;
			req.onreadystatechange = function() {
			 
				// Exibe a mensagem "Verificando" enquanto carrega
				if(req.readyState == 1) {				
					document.getElementById('tdNota'+cont).innerHTML = 'Verificando...';
				}
			 
				// Verifica se o Ajax realizou todas as operações corretamente (essencial)
				if(req.readyState == 4 && req.status == 200) {
					// Resposta retornada pelo validacao.php
					var resposta = req.responseText;
					if(resposta == 'Emissor não cadastrado'){
						//document.getElementById('hdvalidar'+cont).value='n';
						resposta= '<font color=#ff0000>'+resposta+'</font>';
					}else{
						//document.getElementById('hdvalidar'+cont).value='s';
					}
					// Abaixo colocamos a resposta na div do campo que fez a requisição
					document.getElementById('tdNota'+cont).innerHTML = resposta;
				}
			 
			};
			req.send(null);
		}else{
			document.getElementById('tdNota'+cont).innerHTML = '&nbsp';
		}
	}


	function validadeclaracao(){
		if(ValidaFormMsg('cmbMes|cmbAno|txtTomadorCnpjCpf1|cmbCodServico1|txtBaseCalculo1|txtNroDoc1','O Período e pelo menos um serviço devem ser preenchidos!')){
			var txtImpostoTotal=document.getElementById('txtImpostoTotal');
			var total = MoedaToDec(txtImpostoTotal.value);
			if(total != 0){
				return true;
			}else{
				alert('Informe a base de calculo do serviço');
				return false;
			}
			return false;
		}else{
			return false;
		}
	}//fim function para validacao de campos
	
	function verificaModalidade(){
		var cnpj = document.getElementById('txtCNPJ').value;
		var tipo = document.getElementById('cmbTipo').value;
		
		if(!tipo){
			alert("Informe o tipo");
		}else{
			if(!cnpj){
				alert("Digite uma cnpj/cpf!");
			}else{
				document.getElementById('btVoltar').style.display = 'none';
				acessoAjax('inc/declaracoes/des/gerarguia.php','formVerifica','divTipo');
			}   
		}
	}
	
	
	function btBuscar_click(codemissor,retorno){
		if(ValidaFormulario('_mes|_ano','Por favor selecione um mês e um ano!')){
			var codigo_emissor = document.getElementById(codemissor).value;
			var ano = document.getElementById('_ano').value;
			var mes = document.getElementById('_mes').value;
			ajax({
				url:'inc/declaracoes/des/guias/guia_pagamento_lista.ajax.php?codemissor='+codigo_emissor+'&cmbAno='+ano+'&cmbMes='+mes+'&a=a',
				espera: function(){
					document.getElementById(retorno).innerHTML = 'Verificando...';
				},
				sucesso: function(){
					id(retorno).innerHTML = respostaAjax;		
					CalculaMultaDes();
				}
			});		
		}
		
	}
	
//-->	
	
</script>


<table border="0" cellspacing="0" cellpadding="0" class="form">
	<tr>
		<td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
		<td width="650" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;Prestadores/Ordem de Serviço<br />
		</td>
		<td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
	</tr>
	<tr>
		<td width="18" background="img/form/lateralesq.jpg"></td>
		<td align="center">
			<div id="divDes">
			<form name="frmDes" id="frmDes" method="post" onsubmit="return false">
				<input type="hidden" name="include" id="include" value="<?php echo $_POST['include'];?>" />
				<input type="hidden" name="abertdes" id="abertdes">
				<input type="hidden" name="hdCancelaDes" id="hdCancelaDes" />
				<fieldset>
				<legend>Pesquisa de declarações</legend>
				<table width="100%">
					<tr>
						<td align="left">Nome/Raz&atilde;o Social</td>
						<td align="left">
							<input name="txtNome" type="text" class="texto" size="60" maxlength="100" />
						</td>
					</tr>
					<tr>
						<td align="left">CNPJ</td>
						<td align="left">
							<input name="txtCNPJ" type="text" class="texto" size="20" maxlength="18" />
						</td>
					</tr>
					<tr>
						<td align="left">N° da Des</td>
						<td align="left">
							<input name="txtNroDes" type="text" class="texto" size="10" maxlength="10" />
						</td>
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
								<option/>
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
						<td align="left">Data Emissão</td>
						<td align="left">
							<input name="txtData" type="text" class="texto" size="12" maxlength="10" />
						</td>
					</tr>
					<tr>
						<td align="left" colspan="2">
							<input name="btPesquisar" type="submit" class="botao" value="Pesquisar" 
                    		onclick="acessoAjax('inc/declaracoes/des/declarar_pesquisa.ajax.php','frmDes','divDeclaracoesSimples')" />
							<input name="btNova" type="submit" class="botao" value="Nova declaração" 
                    		onclick="acessoAjax('inc/declaracoes/des/verifica_cnpj.ajax.php','frmDes','divDes')" />
							<input name="btGuia" value="Guias" type="submit" class="botao"
                            onclick="acessoAjax('inc/declaracoes/des/guias/verifica_cnpj_guias.ajax.php','frmDes','divDes')" />
							&nbsp;
							<input name="btLimpar" type="reset" class="botao" value="Limpar" />
						</td>
					</tr>
				</table>
				<div id="divDeclaracoesSimples"></div>
				</fieldset>
			</form>
			</div>
		</td>
		<td width="19" background="img/form/lateraldir.jpg"></td>
	</tr>
	<tr>
		<td align="left" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantoesq.jpg" /></td>
		<td background="img/form/rodape_fundo.jpg"></td>
		<td align="right" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantodir.jpg" /></td>
	</tr>
</table>
