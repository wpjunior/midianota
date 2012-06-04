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
	//verifica se ha o valor de post do campo oculto do cadastro se houver atribui o valor do cnpjcpf
	if($_POST["hdCNPJCPF"]){
		$cnpjcpf = $_POST["hdCNPJCPF"];
	}//fim if
	if(!$cnpjcpf){
		$cnpjcpf = $_POST['txtCNPJCPF'];
	}
	$periodo = $_POST["cmbPeriodo"];
?>
<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
  <tr>
    <td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
    <td width="800" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;Tomadores - Créditos</td>  
    <td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
  </tr>
  <tr>
    <td width="18" background="img/form/lateralesq.jpg"></td>
    <td align="center">
			<fieldset><legend>Consulta de Créditos</legend>
				<form method="post">	
					<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
					<table align="left">
						<tr align="left">
							<td>CNPJ/CPF do Tomador<font color="#FF0000">*</font></td>
							<td><input type="text" class="texto" name="txtCNPJCPF" maxlength="18" onkeypress="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );" value="<?php echo $cnpjcpf;?>" /></td>
						</tr>
						<tr align="left">
							<td>Periodo</td>
							<td>
								<select name="cmbPeriodo">
									<?php
										$year = date("Y");
										for($h=0; $h<2; $h++){
											$y = $year - $h;
											echo "<option value=\"$y\"";if($y == $periodo){ echo "selected=selected";}echo ">$y</option>";
										}
									?>
								</select>
							</td>
						</tr>
						<tr align="left">
							<td><input type="submit" class="botao" name="btConsultaCreditos" value="Consultar" /></td>
							<td><font color="#FF0000">* Dados obrigatórios</font></td>
						</tr>
					</table>
				</form>
			<?php
				//testa se o botao tem valor ou se veio um valor por post para a variavel cnpjcpf
				if(($_POST["btConsultaCreditos"] == "Consultar") || ($cnpjcpf != ""))
					{
						//testa se cnpjcpf continuar vazio recebe o valor do campo do form
						if($cnpjcpf == ""){
							$cnpjcpf = $_POST["txtCNPJCPF"];
						}//fim if
						$campo = tipoPessoa($cnpjcpf);
						//testa se o periodo estiver vazio pega o ano atual para teste
						if($periodo == ""){
							$periodo = date("Y");
						}//fim if
						//se o cnpjcpf continuar vazio mostra uma mensagem para o usuario pedindo que preencha o cnpjcpf
						if($cnpjcpf==""){
							Mensagem("Informe o CNPJ/CPF do tomador");
						}else{	
							//Soma os creditos do tomador sobre as nfe correspondente ao cnpjcpf informado
							$sql_credito_nfe = mysql_query("SELECT SUM(credito) FROM notas 
							WHERE tomador_cnpjcpf='$cnpjcpf' AND SUBSTRING(datahoraemissao,1,10)>='$periodo-01-01' AND SUBSTRING(datahoraemissao,1,10)<='$periodo-12-31'");
							list($credito_nfe) = mysql_fetch_array($sql_credito_nfe);
							//soma os creditos do tomador das notas via des correspondentes ao cnpjcpf informado
							$sql_credito_des = mysql_query("SELECT SUM(des_tomadores_notas.credito) FROM des_tomadores_notas 
							INNER JOIN cadastro ON cadastro.codigo = des_tomadores_notas.cod_tomador WHERE cadastro.$campo = '$cnpjcpf' 
							AND dataemissao >= '$periodo-01-01' AND dataemissao <= '$periodo-12-31'");
							list($credito_des) = mysql_fetch_array($sql_credito_des);
							//soma os dois resultados para saber o valor total de creditos que o tomador possui
							$result = $credito_nfe + $credito_des;
							//verifica o nome deste mesmo tomador
							$sql_tomador = mysql_query("SELECT nome FROM cadastro WHERE $campo='$cnpjcpf'");
							list($tomador) = mysql_fetch_array($sql_tomador);
							if(mysql_num_rows($sql_tomador)>0){
							?>
								<table align="center" width="100%">
									<tr align="center" bgcolor="#999999">
										<td>CNPJ/CPF do tomador</td>
										<td>Nome do tomador</td>
										<td>Crédito acumulado durante o período</td>
									</tr>
									<tr align="center" bgcolor="#FFFFFF">
										<td><?php echo $cnpjcpf;?></td>
										<td><?php echo $tomador;?></td>
										<td><?php if($result == ""){ echo "Não possui creditos"; }else{ echo "R$".DecToMoeda($result); }?></td>
									</tr>
								</table>
							<?php	
							}else{
								//mensagem de erro ao tentar verificar um CNPJCPF que nao esteja cadastrado
								echo "<table width=\"100%\">
											<tr>
												<td align=\"center\">Náo nenhum tomador com este CNPJ/CPF</td>
											</tr>
										</table>
									";
							}//fim else
						}//fim else
					}//fim if
			?>		
			</fieldset>
	</td>
	<td width="19" background="img/form/lateraldir.jpg"></td>
  </tr>
  <tr>
    <td align="left" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantoesq.jpg" /></td>
    <td background="img/form/rodape_fundo.jpg"></td>
    <td align="right" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantodir.jpg" /></td>
  </tr>
</table>
