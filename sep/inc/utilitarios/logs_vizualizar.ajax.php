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
include("../conect.php");
include("../../funcoes/util.php");
//recebimento por get das variaveis
$combo = $_GET["cmbLogs"];

//altera o valor da legenda do fildset
if($combo == "C"){
	$legend = "Contadores";
}elseif($combo == "E"){
	$legend = "Emissores";
}elseif($combo == "P"){
	$legend = "Prefeitura";
}//fim elseif
//testa se o combo tem valor
if($combo){
?>
<fieldset><legend>Logs <?php echo $legend;?></legend>
	<table width="100%">
		<tr>
		  <td width="91">Usuário:</td>
		  <td width="1286"><input name="txtNome" id="txtNome" type="text" class="texto" size="30" /></td>
		</tr>
		<tr>
		  <td>Data:</td>
		  <td><input name="txtData" id="txtData" type="text" class="texto" maxlength="10" size="12" onkeyup="MaskData(this)" ></td>
		</tr>
		<tr>
			<td colspan="2">
				<br /><input name="btProcurar" type="button" value="Procurar" class="botao" 
				onClick="acessoAjax('inc/utilitarios/logs_resultados.ajax.php','frmLogs','divresultados')" />
				<input name="btLimpar" type="button" class="botao" value="Limpar" 
                onclick="document.getElementById('txtNome').value='';document.getElementById('txtData').value='';">
			</td>
		</tr>
	</table>
	<input type="hidden" name="hdCombo" value="<?php echo $combo;?>">
</fieldset>
<div id="divresultados"></div>
<?php
}//fim if
?>