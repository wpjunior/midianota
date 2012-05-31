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
    <td width="150" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;SEPISS - Pesquisar</td>  
    <td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" onclick="document.getElementById('divBuscaInst').style.visibility='hidden'" /></td>
  </tr>
  <tr>
    <td width="18" background="img/form/lateralesq.jpg"></td>
    <td align="center">
<form method="post"  name="frmBuscaInst" id="frmBuscaInst">
		<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
	<table width="100%">
		<tr>
			<td><input name="txtBuscaNomeInst" id="txtBuscaNomeInst" type="text" class="texto" size="39" style="background-color:#255b8f; color:#FFFFFF; text-transform:uppercase"  >	
				<input name="btBuscarCliente" type="submit" value="" id="btBuscarCliente"></td>
	  	</tr>
	  <tr>
		<td background="img/busca_fundo.jpg" align="center">	
		<select name="CODINST" id="CODINST" size="13" style="width:277px; background-color:#255b8f;color:#FFFFFF;" class="combo" onchange="document.frmBuscaInst.submit();">   		
			<?php						
				if(isset($_POST['txtBuscaNomeInst']))
					{
						$nome = $_POST["txtBuscaNomeInst"];
						$sql_busca = mysql_query("
							SELECT 
								cadastro.codigo, 
								cadastro.nome, 
								cadastro.razaosocial, 
								cadastro.senha, 
								cadastro.cnpj, 
								cadastro.inscrmunicipal, 
								cadastro.logradouro,
								cadastro.numero,
								cadastro.municipio,
								cadastro.bairro, 
								cadastro.uf, 
								cadastro.email, 
								cadastro.fonecomercial, 
								cadastro.fonecelular, 
								cadastro.estado,
								inst_financeiras.codbanco,
								inst_financeiras.agencia,
								gerente.nome, 
								gerente.cpf, 
								responsavel.nome, 
								responsavel.cpf
							FROM 
								cadastro 
							INNER JOIN
								inst_financeiras ON inst_financeiras.codcadastro = cadastro.codigo
							INNER JOIN
								cadastro_resp AS responsavel ON responsavel.codemissor = cadastro.codigo
							INNER JOIN
								cadastro_resp AS gerente ON gerente.codemissor = cadastro.codigo
							WHERE 
								gerente.codcargo = '1' AND responsavel.codcargo = '2' AND estado <> 'NL'
						");
						while(list($codigo,$nome,$razaosocial,$senha,$cnpj,$inscrmunicipal,$logradouro,$numero,$municipio,$bairro,$uf,$email,$fonecomercial,$fonecelular,$estado,$codbanco,$agencia,$gerente,$gerente_cpf,$responsavel,$responsavel_cpf)=mysql_fetch_array($sql_busca))
							{		
								switch($estado){
									case "A": $estado = "Ativo";  break;
									case "I": $estado = "Inativo"; break;
								}//fim switch
								
								echo "<option value=\"$codigo\">".$nome."</option>";
							}
					}
				?>
		</select>
		</td>
	</tr>
</table>
</form>
	</td>
	<td width="19" background="img/form/lateraldir.jpg"></td>
  </tr>
  <tr>
    <td align="left" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantoesq.jpg" /></td>
    <td background="img/form/rodape_fundo.jpg"></td>
    <td align="right" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantodir.jpg" /></td>
  </tr>
</table>

<map name="Map"><area shape="rect" coords="277,4,294,18" onclick="document.getElementById('divBuscaInst').style.visibility='hidden';" alt="Fechar">
</map>