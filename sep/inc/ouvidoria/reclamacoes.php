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


$btSalvar = $_POST['btSalvar'];

if($btSalvar == "Salvar") 
 {?>
 	<form name="frmRedireciona" id="frmRedireciona" method="post">
			<input type="hidden" name="include" id="include" value="<?php echo $_POST['include'];?>">
	</form>
  <?php			
	$CODIGO = $_POST['txtCodigo'];
	$txtEstado = $_POST['rgEstado'];
	$txtResponsavel = $_POST['txtResponsavel'];
	$txtDataAtndimento = $_POST['txtDataAtendimento'];
	$txtDataAtndimento = implode('-', array_reverse(explode('/', $txtDataAtndimento)));	
	// executa o btSalvar
	$sql = mysql_query("UPDATE `reclamacoes` SET `estado`='$txtEstado', `responsavel`='$txtResponsavel', `dataatendimento`= '$txtDataAtndimento' WHERE `codigo`=$CODIGO");
	echo "<script language=JavaScript>alert('Reclamação atualizada.');document.getElementById('frmRedireciona').submit();</script>";
	add_logs('Atualizou reclamação');
 }?>	
<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
  <tr>
    <td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
    <td width="800" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;Ouvidoria - Reclama&ccedil;&otilde;es</td>  
    <td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
  </tr>
  <tr>
    <td width="18" background="img/form/lateralesq.jpg"></td>
    <td align="center">
			<table width="600" bgcolor="#CCCCCC" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td>
			<?php		 
			if(isset($_POST['btEditar']) == "R") 
			 {
				include("reclamacoes_editar.php");
			 } 
			else
			 {
			
			?>
			
			
						   <!-- Formulário de pesquisa de usuarios  --->
						   <table width="100%" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
							<tr>
							 <td>
							  <fieldset style="width:730px"><legend>Pesquisa de Reclamações</legend>
							  <form method="post" name="frmReclamacoesPesquisa">   
								<input type="hidden" name="include" id="include" value="<?php echo $_POST['include'];?>">
							  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
							   <tr>
								<td align="left" width="30%">Especificação</td>
								<td width="2"align="right"></td>
								<td align=left width=70% colspan="2"><select name="cmbEspecificacao" style="width:340px;">
								<option value="">===== Selecione aqui =====</option>
								<?php
								// cria combo com os assuntos ja postados no banco de forma agrupada
								$sql = mysql_query("SELECT especificacao FROM reclamacoes GROUP BY especificacao ORDER BY especificacao ASC");
								while(list($especificacao) = mysql_fetch_array($sql)) {
									print("<option value=\"$especificacao\">$especificacao</option>");
								} // fim while
								?>
								</select>
								</td>
							   </tr>
							   <tr>
								<td align="left">Prestador - CPF/CNPJ</td>
								<td width="2"align="right"></td>
								<td align="left">
								
								 <input name="txtPrestadorCNPJ" type="text" maxlength="18" size="20" id="txtPrestadorCNPJ" class="texto"  onkeydown="stopMsk( event );" onkeypress="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );" />
								
								</td>      
							   </tr>
							   <tr>
								<td align="left">Tomador - CPF/CNPJ</td>
								<td width="2"align="right"></td>
								<td align="left">
								 <input name="txtTomadorCNPJ" type="text" maxlength="18" size="20" id="txtTomadorCNPJ" class="texto"  onkeydown="stopMsk( event );" onkeypress="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );" />
								
								</td>
							   </tr>
							   <tr>
								<td align="left">RPS - Número</td>
								<td width="2"align="right"></td>
								<td align="left"><input type="text" size="20" maxlength="20" name="txtRPSNumero" class="texto"></td>
							   </tr>
							   <tr>
								<td align="left">RPS - Data</td>
								<td width="2"align="right"></td>
								<td align="left"><input type="text" size="20" maxlength="20" name="txtRPSData" class="texto" onkeypress="formatar(this,'00/00/0000')"></td>
							   </tr>
							   <tr>
								<td align="left">RPS - Valor</td>
								<td width="2"align="right">R$</td>
								<td align="left"><input type="text" size="20" maxlength="20" name="txtRPSValor" class="texto" onKeyPress="return(MascaraMoeda(this,'.',',',event))"><em>(Exemplo 1900,12)</em></td>
							   </tr>
							   <tr>
								<td align="left">Estado</td>
								<td width="2"align="right"></td>
								<td align="left"><label><input type="radio" name="rgEstado" value="atendida" />Atendida</label>
								<label><input type="radio" name="rgEstado" value="pendente" />Pendente</label></td>
							   </tr>
							   <tr>
								<td align="left"><input type="submit" value="Pesquisar" name="btPesquisar" class="botao"></td>
								<td></td>
								</tr>   
							  </table>   
							  </form>
							  </fieldset>
							 </td>
							</tr>  
						   </table> 
						<? } ?> 
						<!-- Formulário de pesquisa de reclamacoes Fim--->
						
							</td>
						  </tr>
						  <tr>
							<td> 
						
						<!-- Formulário de resultado de pesquisa inicio --->
						
						<?php 
						
						if(isset($_POST['btPesquisar'])){
							include("reclamacoes_resultadopesquisa.php");
						}
						else{
							include("reclamacoes_busca.php"); 	
						}
						
						
						
						?>
						
						<!-- Formulário de resultado de pesquisa Fim --->
						
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
  