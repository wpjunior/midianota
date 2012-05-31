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
   
?>
<fieldset><legend>Informações sobre as declarações</legend>
    <table width="100%">
        <tr>
            <td width="30%">Razão Social:</td>
            <td><input type="text" class="texto" name="txtRazao" size="40" /></td>
        </tr>
        <tr align="left">
            <td width="30%">CNPJ:</td>
            <td>
                <input type="text" class="texto" name="txtCnpj" maxlength="18" onkeydown="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );" />
            </td>
        </tr>
        <tr align="left">
            <td width="30%">Competência:</td>
            <td>
                <select name="cmbMes">
                    <option></option>
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
                <select name="cmbAno">
                    <option></option>
                    <?php
                        $y=date("Y");
                        for($i=0; $i<5; $i++){
                            $year=$y-$i;
                            echo "<option value=\"$year\">$year</option>";
                        }
                    ?>
                </select>
            </td>
        </tr>
        <tr align="left">
            <td width="30%">Estado:</td>
            <td>
                <select cmbEstado>
                    <option></option>
                    <option value="N">Normal</option>
                    <option value="B">Boleto</option>
                    <option value="E">Escriturada</option>
                    <option value="C">Cancelada</option>
                </select>
            </td>
        </tr>
        <tr align="left">
            <td width="30%">Data Inicial:</td>
            <td><input type="text" class="texto" name="txtDataIni" onkeydown="formataData(this);return NumbersOnly( event );" maxlength="10" size="10" /></td>
        </tr>
        <tr align="left">
            <td width="30%">Data Final:</td>
            <td><input type="text" class="texto" name="txtDataFim" onkeydown="formataData(this);return NumbersOnly( event );" maxlength="10" size="10" /></td>
        </tr>
        <tr align="left">
            <td width="30%">
                <input type="button" value="Consulta" class="botao" onclick="acessoAjax('inc/instfinanceiras/relatorio_dif.ajax.php','frmRelatorio','detalhes_dif_des');" />
            </td>
        </tr>
    </table>
    <div id="detalhes_dif_des"></div>
</fieldset>