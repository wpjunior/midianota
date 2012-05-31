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
<table border="0" cellspacing="0" cellpadding="0" class="form">
  <tr>
    <td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
    <td width="600" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;Declara&ccedil;&otilde;es - Prestadores</td>  
    <td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
  </tr>
  <tr>
    <td width="18" background="img/form/lateralesq.jpg"></td>
    <td align="center">



<script>
	function PesquisarDes()
	{
	  acessoAjax('inc/declaracoes/relatorio_resultado.ajax.php','formDes','divResultado');	  
	}	
	
</script>

<div style="visibility:visible;" id="divPesquisar">

<fieldset>
<legend>Pesquisar Prestadores</legend>
<form method="post" id="formDes">
	<br />
	<input type="hidden" name="cmbDes" id="cmbDes" value="emissores">
	<table width="100%" align="center" border="0">
	  <tr id="trPago">
		<td>
		  Estado
	    </td>
	    <td>
		  <input name="rbEstado" id="rbEstadoNormal" type="radio" value="N" checked="checked" />
		  	<label for="rbEstadoNormal">Normal</label><br>
		  <input name="rbEstado" id="rbEstadoCancelada" type="radio" value="C" />
		  	<label for="rbEstadoCancelada">Cancelada</label><br>
		  <input name="rbEstado" id="rbEstadoBoleto" type="radio" value="B" />
		  	<label for="rbEstadoBoleto">Boleto</label><br>
		  <input name="rbEstado" id="rbEstadoEscriturada" type="radio" value="E" />
		  	<label for="rbEstadoEscriturada">Escriturada</label><br>
	    </td>
	  </tr>
      <tr>
        <td width="26%" align="left"> Nome/RazãoSocial </td>
        <td align="left" colspan="2"><input type="text" class="texto" name="txtNomeEmissor" id="txtNomeEmissor" />
        </td>
      </tr>
      <tr>
        <td align="left"> CNPJ/CPF </td>
        <td align="left" colspan="2"><input type="text" class="texto" name="txtCnpjCpfEmissor" id="txtCnpjCpfEmissor" />
        </td>
      </tr>
      <tr id="trComp">
        <td align="left"> Competência </td>
        <td align="left" colspan="2">
		  <select name="cmbMesComp" id="cmbMesComp">
              <option value=""> </option>
              <option value="01">Janeiro</option>
              <option value="02">Fevereiro</option>
              <option value="03">Março</option>
              <option value="04">Abril</option>
              <option value="05">Maio</option>
              <option value="06">Junho</option>
              <option value="07">Julho</option>
              <option value="08">Agosto</option>
              <option value="09">Setembro</option>
              <option value="10">Outubro</option>
              <option value="11">Novembro</option>
              <option value="12">Dezembro</option>
            </select>
			<select name="cmbAnoComp" id="cmbAnoComp">
			  <option value=""> </option>
			  <?php 
			  //busca todos os anos das declaracoes pra jogar no comp
			  $sql_ano = mysql_query (" 
					SELECT SUBSTRING(competencia,1,4) as c FROM des 
					UNION
					SELECT SUBSTRING(competencia,1,4) as c FROM des_temp
					UNION
					SELECT SUBSTRING(competencia,1,4) as c FROM des_issretido
					GROUP BY c
					ORDER BY c DESC
				");
			  while (list($ano)=mysql_fetch_array($sql_ano)){
			  	echo "<option value=\"$ano\">$ano</option>";
			  }
			  ?>
			</select>
        </td>
      </tr>
      <tr>
        <td align="left"> Data da Emissão </td>
        <td width="15%" align="left" >
        	<input type="text" class="texto" name="txtDataEmissao" id="txtDataEmissao" maxlength="10" size="10"/>
        </td>
        <td width="59%" align="left" colspan="2" >
        	<input type="button" class="botao" name="btPesquisar" value="Pesquisar" onclick="PesquisarDes();" />
        </td>
      </tr>
    </table>
	<br />
	<div id="divResultado"> </div>
	
</form>	
</fieldset>
</div>		
	
	
	
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