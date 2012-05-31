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
<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
  <tr>
    <td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
    <td background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;Servi&ccedil;os - Cadastro</td>  
    <td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
  </tr>
  <tr>
    <td width="18" background="img/form/lateralesq.jpg"></td>
    <td align="center">
		<?php
		//Mensagem($_POST['servicos']);
		if($_POST['servicos']!='Pesquisar') {
			include 'cadastrar.php';
		} else {
			include 'servicos.php';
		}
		?>
		<form method="post">
		<fieldset style="vertical-align:middle; text-align:left">
			<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
			<input type="submit" value="Novo" name="servicos" class="botao" />
			<input type="submit" value="Pesquisar" name="servicos" class="botao" />
			<input type="button" value="Excluir" name="btExcluir" id="btExcluir" class="botao" />
			<input type="button" value="Salvar" name="btCadastrar" id="btCadastrar" class="botao" />
    	</fieldset>
    	<script type="text/javascript">
		id('btExcluir').onclick = function() {
			var form = id('frmEditar');
			if(form){
				if(!confirm('Excluir este serviço?')) return;
				var cod = id('COD').value;
				alert('Serviço exluido!');
				id('COD').value = null;
				var input = document.createElement('input');
				input.setAttribute('type', 'hidden');
				input.setAttribute('name', 'excluir');
				input.setAttribute('value', cod);
				form.appendChild(input);
				form.submit();
			}
		};
		
    	id('btCadastrar').onclick = function() {
        	var form = id('frmCadastro')||id('frmEditar');
			if(form) {
				var input = document.createElement('input');
				input.setAttribute('type', 'hidden');
				input.setAttribute('name', 'btCadastrar');
				input.setAttribute('value', 'Salvar');
				form.appendChild(input);
				if(form.id=='frmCadastro')
					if(ValidaFormulario('cmbCategoria|txtInsDescServicos|cmbInsTipoPessoa|txtInsAliquota|txtInsAliquotaIR|cmbInsIncidencia|txtInsDiaVencimento|cmbInsDocFiscal'))
						form.submit();
				if(form.id=='frmEditar')
					form.submit();
			}
    	};
    	</script>
    	</form>
    	<br>
	</td>
	<td width="19" background="img/form/lateraldir.jpg"></td>
  </tr>
  <tr>
    <td align="left" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantoesq.jpg" /></td>
    <td background="img/form/rodape_fundo.jpg"></td>
    <td align="right" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantodir.jpg" /></td>
  </tr>
</table>
