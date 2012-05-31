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
	// Conexao ao banco MySQL e consulta
	require_once("../../conect.php");
	require_once("../../../funcoes/util.php");
	
	//recebe a variavel que veio por get
	if(isset($_GET)){
		$relatorio = $_GET['cmbRelatorios'];
	}
	
//testa qual foi o valor passado pelo usuario e mostra a tabela conforme o valor
if($relatorio == "E"){ 
	//query que verifica todos os cadastrados, ativos, inativos e nao liberados
	$sql_cadastradas = mysql_query("
		SELECT COUNT(codigo) FROM empreiteiras
		UNION ALL
		SELECT COUNT(codigo) FROM empreiteiras WHERE estado = 'A'
		UNION ALL
		SELECT COUNT(codigo) FROM empreiteiras WHERE estado = 'I'
		UNION ALL
		SELECT COUNT(codigo) FROM empreiteiras WHERE estado = 'NL'
	");
	$cont = 0;
	//Recebe o array gerado pelo sql e recebe em uma variavel para imprimir os dados na tela
	while(list($quantidade) = mysql_fetch_array($sql_cadastradas)){
		$result[$cont] = $quantidade;
		$cont++;
	}
?>
<fieldset><legend>Informações sobre as Empreiteiras</legend>
<table width="100%" border="0" cellpadding="0">
    <tr>
        <td width="15%" align="left">Cadastradas:</td>
        <td align="left"><?php if($result[0] != 0){ echo $result[0];}else{ echo "Não há empreiteiras cadastradas";}?></td>
    </tr>
    <tr>
        <td align="left">Ativas:</td>
        <td align="left"><?php if($result[1] != 0){ echo $result[1];}else{ echo "Não há empreiteiras ativas";}?></td>
    </tr>
    <tr>
        <td align="left">Inativas:</td>
        <td align="left"><?php if($result[2] != 0){ echo $result[2];}else{ echo "Não há empreiteiras inativas";}?></td>
    </tr>
    <tr>
        <td align="left">Não Liberadas:</td>
        <td width="85%" align="left"><?php if($result[3] != 0){ echo $result[3];}else{ echo "Não há empreiteiras não liberadas";}?></td>
  </tr>
</table>
</fieldset>
<fieldset>
<table width="100%" border="0" cellpadding="0">
    <tr>
        <td width="8%" align="left">Nome:</td>
        <td width="92%" align="left"><input type="text" name="txtNome" id="txtNome" class="texto" size="60" maxlength="100"></td>
  </tr>
    <tr>
    	<td align="left">CNPJ</td>
        <td align="left"><input type="text" name="txtCNPJ" id="txtCNPJ" class="texto" size="20" maxlength="18"></td>
    </tr>
    <tr>
    	<td align="left">Estado:</td>
        <td align="left">
        	<select name="cmbEstado" id="cmbEstado" class="combo">
            	<option value=""></option>
                <option value="A">Ativos</option>
                <option value="I">Inativos</option>
                <option value="NL">Não liberados</option>
            </select>
        </td>
    </tr>
    <tr>								
        <td align="left">
            <input type="button" name="btNome" value="Consulta" class="botao" 
            onclick="document.getElementById('hdBt').value='';
            acessoAjax('inc/empreiteiras/relatorios/busca_resultado.ajax.php','frmRelatorio','divBuscar');" >
        </td>
        <td align="left">
        	<input type="button" name="btLimpar" value="Limpar" class="botao" 
            onclick="document.getElementById('txtNome').value='';document.getElementById('txtCNPJ').value='';document.getElementById('cmbEstado').value='';"  />
        </td>
    </tr>
</table>
<input type="hidden" name="hdBt" id="hdBt" />
<div id="divBuscar"></div>
</fieldset>
<?php
}elseif($relatorio == "D"){
?>
<fieldset><legend>Filtro</legend>
<table width="100%">
    <tr>
        <td width="17%" align="left">Nome/Raz&atilde;o Social</td>
      <td width="83%" align="left"><input name="txtNome" type="text" class="texto" size="60" maxlength="100" /></td>
  </tr>
    <tr>
        <td align="left">CNPJ</td>
        <td align="left"><input name="txtCNPJ" type="text" class="texto" size="20" maxlength="18" /></td>
    </tr>
    <tr>
        <td align="left">N° da Decc</td>
        <td align="left"><input name="txtNroDecc" type="text" class="texto" size="10" maxlength="10" /></td>
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
                <option value=""></option>
                <?php
                $sql_ano = mysql_query("SELECT SUBSTRING(competencia,1,4) FROM decc_des GROUP BY SUBSTRING(competencia,1,4) ORDER BY SUBSTRING(competencia,1,4) DESC");
                while(list($ano) = mysql_fetch_array($sql_ano)){
                    echo "<option value=\"$ano\">$ano</option>";
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
    	<td align="left">Data inicial</td>
        <td align="left"><input name="txtDataIni" onkeyup="MaskData(this)" type="text" class="texto" size="12" maxlength="10" /></td>
    </tr>
    <tr>
    	<td align="left">Data final</td>
        <td align="left"><input name="txtDataFim" onkeyup="MaskData(this)" type="text" class="texto" size="12" maxlength="10" /></td>
    </tr>
    <tr>
        <td align="left" colspan="2">
        	<input name="btConsulta" type="submit" class="botao" value="Consulta" 
            onclick="acessoAjax('inc/empreiteiras/relatorios/declarar_pesquisa.ajax.php','frmRelatorio','divgraficoDecc')" />
            <input name="btGerarGrafico" type="submit" class="botao" value="Gerar Grafico"
            onclick="acessoAjax('inc/empreiteiras/relatorios/relatorio_geragrafico.ajax.php','frmRelatorio','divgraficoDecc')" />
        </td>
    </tr>
</table>
</fieldset>
<div id="divgraficoDecc"></div>
<?php
}elseif($relatorio == "O"){
	$sql_obras = mysql_query("
		SELECT COUNT(codigo) FROM obras
			UNION ALL
		SELECT COUNT(codigo) FROM obras WHERE estado = 'A'
			UNION ALL
		SELECT COUNT(codigo) FROM obras WHERE estado = 'C'");
	$cont = 0;
	//Recebe o array gerado pelo sql e recebe em uma variavel para imprimir os dados na tela
	while(list($quantidade) = mysql_fetch_array($sql_obras)){
		$result[$cont] = $quantidade;
		$cont++;
	}
?>
<fieldset>
<table width="100%">
	<tr>
    	<td align="left" colspan="2"><b>Informações das Obras</b></td>
    </tr>
    <tr>
    	<td width="16%" align="left">Cadastradas</td>
        <td width="84%" align="left"><?php if($result[0] != 0){ echo $result[0];}else{ echo "Não há obras cadastradas";}?></td>
    </tr>
    <tr>
    	<td align="left">Abertas</td>
        <td align="left"><?php if($result[1] != 0){ echo $result[1];}else{ echo "Não há obras cadastradas";}?></td>
    </tr>
    <tr>
    	<td align="left">Concluidas</td>
        <td align="left"><?php if($result[2] != 0){ echo $result[2];}else{ echo "Não há obras cadastradas";}?></td>
    </tr>
</table>
</fieldset>
<fieldset>
<table width="100%" border="0" cellpadding="0">
    <tr>
        <td width="17%" align="left">Nome da Obra:</td>
        <td width="83%" align="left"><input type="text" name="txtNomeObra" class="texto" size="30" maxlength="30"></td>
    </tr>
    <tr>
    	<td align="left">Alvara</td>
        <td align="left"><input name="txtAlvara" type="text" class="texto" size="20" maxlength="20" /></td>
    </tr>
    <tr>
    	<td align="left">Estado</td>
        <td align="left">
       		<select name="cmbEstado" class="combo">
            	<option value=""></option>
                <option value="A">Abertas</option>
                <option value="C">Concluidas</option>
            </select>
        </td>
    </tr>
    <tr>
    	<td align="left">Data de Inicio</td>
        <td align="left"><input name="txtDataIni" onkeyup="MaskData(this)" type="text" class="texto" size="12" maxlength="10" /></td>
    </tr>
    <tr>
    	<td align="left">Data de termino</td>
        <td align="left"><input name="txtDataFim" onkeyup="MaskData(this)" type="text" class="texto" size="12" maxlength="10" /></td>
    </tr>
    <tr>
    	<td align="left">
        	<input type="submit" name="btConsulta" value="Consulta" class="botao" 
            onclick="document.getElementById('hdBtObra').value='';
            acessoAjax('inc/empreiteiras/relatorios/busca_resultado_obras.ajax.php','frmRelatorio','divBuscar');" >
        </td>
    </tr>
</table>
<input type="hidden" name="hdBtObra" id="hdBtObra" />
</fieldset>
<div id="divBuscar"></div>
<?php
}
?>
