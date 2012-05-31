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
    <td width="600" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;Declara&ccedil;&otilde;es - Relatórios</td>  
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
<legend>Relatório DES</legend>
<form method="post" id="formDes" action="reports/relatorio_des.php" target="_blank	">
	<input type="hidden" name="hdRelatorio" id="hdRelatorio" value="true">
	<script type="text/javascript">
		var des = {
			EscondeCampos: function (){
				document.getElementById('divResultado').innerHTML='';
				if(document.getElementById('cmbDes').value!=''){
					document.getElementById('trPesquisar').style.display='';
					if(document.getElementById('cmbDes').value=='tomadores'){
						document.getElementById('trPago').style.display='none';
					}else{
						document.getElementById('trPago').style.display='';
					}
				}else{
					document.getElementById('trPago').style.display='none';
					document.getElementById('trPesquisar').style.display='none';
				}
			}
		};
	</script>
	<br />
	<table width="100%" align="center" border="0">
      <tr style="display: ">
        <td align="left" colspan="2"> Tipo
          <select name="cmbDes" id="cmbDes" onchange="des.EscondeCampos();">
            <option value=""></option>
            <option value="emissores">Emissores</option>
            <option value="tomadores">Tomadores</option>
            <option value="issretido">Tomadores Iss Retido</option>
          </select>
        </td>
      </tr>
	  <tr id="trPago" style="display: none">
	    <td colspan="2">
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
      <tr id="trPesquisar" style="display: none">
        <td width="59%" align="left" colspan="2" >
        	Competencia: 
        	<select name="cmbAnoComp" id="cmbAnoComp">
				<option/>
				<?php
					$ano=date("Y");
					for($x=0; $x<=5; $x++)
						{
							$year=$ano-$x;
							echo "<option value=\"$year\">$year</option>";
						}
				?>
			</select><br>
        	<input type="button" class="botao" name="btPesquisar" value="Pesquisar" id="btPesquisar" onclick="PesquisarDes();"  /><br>
        	
        </td>
      </tr>
    </table>
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