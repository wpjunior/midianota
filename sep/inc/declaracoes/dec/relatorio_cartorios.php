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
    $sql_total=mysql_query("SELECT codigo FROM cartorios");
    $sql_ativos=mysql_query("SELECT codigo FROM cartorios WHERE estado='A'");
    $sql_inativos=mysql_query("SELECT codigo FROM cartorios WHERE estado='I'");
    $sql_pendentes=mysql_query("SELECT codigo FROM cartorios WHERE estado='NL'");
?>
<fieldset><legend>Informações dos Cartórios</legend>
    <table align="left">
        <tr align="left">
            <td>Cadastrados:</td>
            <td><?php echo mysql_num_rows($sql_total); ?></td>
        </tr>
        <tr align="left">
            <td>Ativos:</td>
            <td><?php echo mysql_num_rows($sql_ativos); ?></td>
        </tr>
        <tr align="left">
            <td>Inativos:</td>
            <td><?php echo mysql_num_rows($sql_inativos); ?></td>
        </tr>
        <tr align="left">
            <td>Não Liberados:</td>
            <td><?php echo mysql_num_rows($sql_pendentes); ?></td>
        </tr>
    </table>
</fieldset>
<fieldset>
    <table width="100%">
        <tr align="left">
            <td>Nome:</td>
            <td><input type="text" class="texto" name="txtNome" /></td>
        </tr>
        <tr>
            <td width="10%">CNPJ:</td>
            <td>
                <input type="text" size="20" name="txtCNPJ" class="texto" onkeydown="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );" />
            </td>
        </tr>
        <tr align="left">
            <td>Estado:</td>
            <td>
                <select name="cmbEstado">
                    <option></option>
                    <option value="A">Ativo</option>
                    <option value="I">Inativo</option>
                    <option value="NL">Não Liberado</option>
                </select>
            </td>
        </tr>
        <tr align="left">
            <td colspan="2">
                <input type="button" value="Pesquisar" class="botao"
                    onclick="acessoAjax('inc/cartorios/relatorio_cartorios.ajax.php','frmRelatorio','detalhes_cartorios')" />
            </td>
        </tr>
    </table>
</fieldset>
<div id="detalhes_cartorios"></div>