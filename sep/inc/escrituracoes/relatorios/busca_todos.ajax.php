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
include('../../conect.php');
include("../../../funcoes/util.php");

//SELECIONA TODOS OS GUIAS E GRAVA EM UMA VARIAVEL
$sqltodos = mysql_query("SELECT guia_pagamento.datavencimento FROM guia_pagamento INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia GROUP BY guia_pagamento.codigo");
$todos = mysql_num_rows($sqltodos);

//SELECIONA OS CAMPOS QUE FORAM PAGOS E GRAVA EM UMA VARIAVEL O RESULTADO
$sqlpago = mysql_query("SELECT guia_pagamento.datavencimento FROM guia_pagamento INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia WHERE guia_pagamento.pago = 'S' GROUP BY guia_pagamento.codigo");
$pagos = mysql_num_rows($sqlpago);

//SELECIONA OS CAMPOS QUE NAO FORAM PAGOS E GRAVA EM UMA VARIAVEL O RESULTADO
$sqlnaopago = mysql_query("SELECT guia_pagamento.datavencimento FROM guia_pagamento INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia WHERE guia_pagamento.pago = 'N' GROUP BY guia_pagamento.codigo");
$naopagos = mysql_num_rows($sqlnaopago);

$dataatual = date('Y-m-d');
//SELECIONA OS CAMPOS QUE NAO FORAM PAGOS E ESTAO ATRASADOS E GRAVA EM UMA VARIAVEL O RESULTADO
$sqlatrasado = mysql_query("SELECT guias_declaracoes.relacionamento, guia_pagamento.codigo FROM guia_pagamento INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia WHERE guia_pagamento.pago = 'N'AND datavencimento<'$dataatual' GROUP BY guia_pagamento.codigo");
$atrasados = mysql_num_rows($sqlatrasado);

$sqlcartorios=mysql_query("SELECT guia_pagamento.codigo FROM guia_pagamento INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia WHERE guias_declaracoes.relacionamento='cartorios_des'");
$sqldestemp=mysql_query("SELECT guia_pagamento.codigo FROM guia_pagamento INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia WHERE guias_declaracoes.relacionamento='des_temp'");
$sqlorgaos=mysql_query("SELECT guia_pagamento.codigo FROM guia_pagamento INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia WHERE guias_declaracoes.relacionamento='dop_des'");
$sqlfinanceiras=mysql_query("SELECT guia_pagamento.codigo FROM guia_pagamento INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia WHERE guias_declaracoes.relacionamento='dif_des'");
$sqlempreiteiras=mysql_query("SELECT guia_pagamento.codigo FROM guia_pagamento INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia WHERE guias_declaracoes.relacionamento='decc_des'");
$sqlopcreditos=mysql_query("SELECT guia_pagamento.codigo FROM guia_pagamento INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia WHERE guias_declaracoes.relacionamento='doc_des'");
$sqldesnotas=mysql_query("SELECT guia_pagamento.codigo FROM guia_pagamento INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia WHERE guias_declaracoes.relacionamento='nfe'");
$sqldes=mysql_query("SELECT guia_pagamento.codigo FROM guia_pagamento INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia WHERE guias_declaracoes.relacionamento='des'");
$sqldesissretido=mysql_query("SELECT guia_pagamento.codigo FROM guia_pagamento INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia WHERE guias_declaracoes.relacionamento='des_issretido'");
?>
	<fieldset style="width:800px"><legend>Relatório de Escriturações</legend>
        <table width="100%">
            <tr>
                <td width="195">Total de Guias:</td>
                <td><?php echo "$todos"; ?></td>
          </tr>
            <tr>
                <td width="195">Total de Guias Pagas:</td>
              <td><?php echo "$pagos"; ?></td>
            </tr>
            <tr>
                <td>Total de Guias Não Pagas:</td>
                <td><?php echo "$naopagos"; ?></td>
            </tr>
            <tr>
                <td>Total de Guias Atrasadas:</td>
                <td><?php echo "$atrasados"; ?></td>
            </tr>
		</table>
        <table width="100%">
            <tr>
            <td>
<input type="radio" name="RGListar" value="T" checked="checked" id="RBTipoT" onchange="acessoAjax('inc/escrituracoes/relatorios/tipos_relatorios.ajax.php','frmListando','divListar')" /><label for="RBTipoT">Todas</label>
<input type="radio" name="RGListar" value="P" id="RBTipoP" onchange="acessoAjax('inc/escrituracoes/relatorios/tipos_relatorios.ajax.php','frmRelatorio','divListar')"/><label for="RBTipoP">Pagas</label>
<input type="radio" name="RGListar" value="NP" id="RBTipoNP" onchange="acessoAjax('inc/escrituracoes/relatorios/tipos_relatorios.ajax.php','frmRelatorio','divListar')"/><label for="RBTipoNP">Não Pagas</label>
<input type="radio" name="RGListar" value="A" id="RBTipoA" onchange="acessoAjax('inc/escrituracoes/relatorios/tipos_relatorios.ajax.php','frmRelatorio','divListar')"/><label for="RBTipoA">Atrasadas</label>
			</td>
            </tr>
        </table>
        <table width="100%">
            <tr>
            	<td>
                <input type="hidden" name="hdTipo" id="hdTipo" value="<?php $_POST['RGListar'] ?>" />
                	<select name="CmbTipos" class="combo" onchange="acessoAjax('inc/escrituracoes/relatorios/tipos_relatorios.ajax.php','frmRelatorio','divListar')">
                        <option value="S">Selecione um Tipo</option>
						<?php if(mysql_num_rows($sqldes)>0){ echo "<option value=\"DES\">DES</option>"; }
                         if(mysql_num_rows($sqlcartorios)>0){ echo "<option value=\"DEC\">DEC</option>"; }
                         if(mysql_num_rows($sqldestemp)>0){ echo "<option value=\"DESTemp\">DESTemp</option>"; }
                         if(mysql_num_rows($sqlorgaos)>0){ echo "<option value=\"DOP\">DOP</option>"; }
                         if(mysql_num_rows($sqlfinanceiras)>0){ echo "<option value=\"DIF\">DIF</option>"; }
                         if(mysql_num_rows($sqlempreiteiras)>0){ echo "<option value=\"DECC\">DECC</option>"; }
                         if(mysql_num_rows($sqlopcreditos)>0){ echo "<option value=\"DOC\">DOC</option>"; }
                         if(mysql_num_rows($sqldesnotas)>0){ echo "<option value=\"NFE\">NFE</option>"; }
                         if(mysql_num_rows($sqldesissretido)>0){ echo "<option value=\"DESISSRetido\">DESISSRetido</option>"; }?>
                    </select>
                </td>
            </tr>
            <tr>
            	<td align="right">
                	<input type="button" name="btnTodos" id="btnTodos" value="Mostrar Todos" class="botao" onclick="acessoAjax('inc/escrituracoes/relatorios/busca_relatorios.ajax.php','frmRelatorio','divListar');" />
                </td>
            </tr>
       </table>
    </fieldset>
<div id="divListar"></div>
