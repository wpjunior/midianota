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
		include("cartorio_servico_editar.php");
		
	}else{
		if($_POST['excluir']){
			$codigo = $_POST['excluir'];
			//Mensagem('Serviço excluido!');
			mysql_query("DELETE FROM cartorios_servicos WHERE codigo='$codigo'");
			add_logs('Excluiu um serviço de Cartório');
			unset($codigo);
		}
	?>
	<form name="frmBusca" method="post" id="frmBusca" onsubmit="acessoAjax('inc/servicos/cartorio_servico_busca.ajax.php','frmBusca','dvResult'); return false;">
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
						$sql_categorias = mysql_query("SELECT codigo, tipocartorio FROM cartorios_tipo ORDER BY tipocartorio");
						while(list($codigo,$tipocartorio) = mysql_fetch_array($sql_categorias)){               
						?>
					  		<option value="<?php echo $codigo; ?>"><?php echo $tipocartorio; ?></option>				
						<?php
						} // fim while
						?>
					</select></td>
					</tr>
					<tr>
					<td>Descri&ccedil;&atilde;o</td>
				  <td colspan="3"><input type="text" size="50" maxlength="50" name="txtBuscaDescServicos" class="texto" /></td>
				</tr>
				<tr>
				  <td align="left">Aliquota</td>
				  <td align="left"><input type="text" size="5" maxlength="3" name="txtBuscaAliquota" class="texto" onkeyup="MaskPercent(this);" />
					&nbsp;%&nbsp;&nbsp;<em>Exemplo(0.00)</em></td>
				  <td>Estado</td>
				  <td colspan="">
					<select name="cmbEstado" class="combo">
						<option value=""></option>
						<option value="A">Ativo</option>
						<option value="I">Inativo</option>
					</select>
				  </td>
			  </tr>
				<tr>
				  <td><input type="submit" name="btFiltro" value="Buscar" class="botao" /></td>
				  <td><input type="reset" name="" value="Limpar" class="botao" /></td>
				  <td colspan="2">&nbsp;</td>
			  </tr>
			</table>
	</fieldset>
	<?php
		if($_POST["btFiltro"] == "Pesquisar"){
			include("cartorio_servicos_busca.php");
		}
	}
	?>
	<div id="dvResult"></div>
	</form>