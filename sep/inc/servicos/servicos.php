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
	if($_POST['COD']){
		include("editar.php");
	}else{
		if($_POST['excluir']){
			$codigo = $_POST['excluir'];
			//Mensagem('Serviço excluido!');
			mysql_query("DELETE FROM servicos WHERE codigo='$codigo'");
			add_logs('Excluiu um Serviço');
			unset($codigo);
		}
	?>
	<form name="frmBusca" method="post" id="frmBusca">
	<fieldset style="margin-left:10px; margin-right:10px;">
		<legend>Filtros</legend>
		<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
			<table width="100%">
				<tr>
					<td>Categoria</td>
					<td colspan="3">
					<select name="cmbCategorias" id="cmbCategorias" class="combo">
						<option value=""></option>
						<?php                
						$sql_categorias = mysql_query("SELECT codigo, nome FROM servicos_categorias ORDER BY nome");
						while(list($categoriacodigo,$categorianome) = mysql_fetch_array($sql_categorias)){               
						?>
					  		<option value="<?php echo $categoriacodigo; ?>"><?php echo ResumeString($categorianome,50); ?></option>				
						<?php
						} // fim while
						?>
					</select>                </td>
				</tr>
				<tr>
					<td>Descri&ccedil;&atilde;o</td>
					<td colspan="3"><input type="text" size="50" maxlength="50" name="txtBuscaDescServicos" class="texto" /></td>
				</tr>
				<tr>
				  <td>C&oacute;digo Servi&ccedil;o</td>
				  <td><input type="text" size="20" maxlength="20" name="txtBuscaCodServicos" class="texto" /></td>
				<td>Tipo Pessoa</td>
				<td>
					<select name="cmbTipoPessoa" id="cmbTipoPessoa" class="combo">
						<option value=""></option>
						<option value="PJ">Pessoa Jurídica</option>
						<option value="PF">Pessoa Física</option>
						<option value="PJPF">Ambas</option>
					</select>
				</td>
				</tr>
				<tr>
				  <td align="left">Aliquota</td>
				  <td align="left"><input type="text" size="5" maxlength="4" name="txtBuscaAliquota" class="texto" />
					&nbsp;%&nbsp;&nbsp;<em>Exemplo(0.00)</em></td>
			  <td align="left">Reten&ccedil;&atilde;o ISS</td>
			  <td align="left">
				<input name="txtBuscaAliquotaIR" type="text" class="texto" id="txtBuscaAliquotaIR" size="5" maxlength="4" />
	&nbsp;%&nbsp;&nbsp;<em>Exemplo(0.00)&nbsp;</em></td>
				</tr>
				<tr>
				  <td align="left">Base de C&aacute;lculo</td>
				  <td align="left">
					<input name="txtBuscaBaseCalculo" type="text" class="texto" id="txtBuscaBaseCalculo" onkeyup="MaskMoeda(this)" onkeydown="return NumbersOnly(event)" size="10" maxlength="9" />
				  </td>
			  <td align="left">Incid&ecirc;ncia</td>
			  <td align="left">
				<select name="cmbBuscaIncidencia" id="cmbBuscaIncidencia" class="combo">
					<option value=""></option>
					<option value="mensal">Mensal</option>
					<option value="anual">Anual</option>
				</select>
			  </td>
				</tr>
				<tr>
				  <td align="left">Dia do Vencimento</td>
				  <td align="left"><input name="txtBuscaDiaVencimento" type="text" class="texto" id="txtBuscaDiaVencimento" size="3" maxlength="2" /></td>
			  <td align="left">Documento Fiscal</td>
			  <td align="left">
				<select name="cmbBuscaDocFiscal" id="cmbBuscaDocFiscal" class="combo">
					<option value=""></option>
					<option value="NF">Nota Fiscal</option>
					<option value="CF">Cupom Fiscal</option>
				</select>
			  </td>
				</tr>
				
				<tr>
				  <td>Estado</td>
				  <td colspan="3">
					<select name="cmbEstado" class="combo">
						<option value=""></option>
						<option value="A">Ativo</option>
						<option value="I">Inativo</option>
					</select>
				  </td>
			  </tr>
				<tr>
				  <td>
				  	<input type="button" name="btFiltro" value="Buscar" class="botao" onclick="acessoAjax('inc/servicos/busca.ajax.php','frmBusca','dvResult');"/>
				  </td>
				  <td colspan="3">&nbsp;</td>
			  </tr>
			</table>
	</fieldset>
	<?php
		if($_POST["btFiltro"] == "Pesquisar"){
			include("busca.php");
		}
	}
	?>
	<div id="dvResult"></div>
	</form>
