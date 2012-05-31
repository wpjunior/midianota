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
<fieldset><legend>Informações sobre as Int. Fiinanceiras</legend>
    <?php
        // chama os dados por estado para relatórios mais detalhados
        $sql_ativas=mysql_query("SELECT razaosocial FROM inst_financeiras WHERE estado='A'");
        $sql_inativas=mysql_query("SELECT razaosocial FROM inst_financeiras WHERE estado='I'");
        $sql_nl=mysql_query("SELECT razaosocial FROM inst_financeiras WHERE estado='NL'");
        $sql_todas=mysql_query("SELECT razaosocial FROM inst_financeiras");
    ?>
    <table width="30%" align="left">
        <tr align="left">
            <td>Cadastradas:</td>
            <td><?php echo mysql_num_rows($sql_todas); ?></td>
        </tr>
        <tr align="left">
            <td>Ativas:</td>
            <td><?php echo mysql_num_rows($sql_ativas); ?></td>
        </tr>
        <tr align="left">
            <td>Inativas:</td>
            <td><?php echo mysql_num_rows($sql_inativas); ?></td>
        </tr>
        <tr align="left">
            <td>Aguardando Liberação:</td>
            <td><?php echo mysql_num_rows($sql_nl); ?></td>
        </tr>
    </table>
</fieldset>
<fieldset><legend>Pesquisa</legend>
    <table width="100%">
        <tr align="left">
            <td width="15%">Razao Social:</td>
            <td><input type="text" class="texto" name="txtInstFinanceiras" /></td>
        </tr>
        <tr align="left">
            <td width="15%">Estado:</td>
            <td>
                <select name="cmbEstado">
                    <option value=""></option>
                    <option value="A">Ativos</option>
                    <option value="I">Inativos</option>
                    <option value="NL">Não Liberados</option>
                </select>
            </td>
        </tr>
        <tr align="left">
            <td width="15%">Municipio:</td>
            <td>
                <select name="cmbMunicipio">
                    <option value=""></option>
                    <?php
                        $sql=mysql_query("SELECT municipio FROM inst_financeiras GROUP BY municipio ORDER BY municipio");
                        while($dados=mysql_fetch_array($sql)){
                            echo "<option value=\"".$dados['municipio']."\">".$dados['municipio']."</option>";
                        }
                    ?>
                </select>
            </td>
        </tr>
        <tr align="left">
            <td width="15%">UF:</td>
            <td>
                <select name="cmbUf">
                    <option value=""></option>
                    <?php
                        $sql=mysql_query("SELECT uf FROM inst_financeiras GROUP BY uf ORDER BY uf");
                        while($dados=mysql_fetch_array($sql)){
                            echo "<option value=\"".$dados['uf']."\">".$dados['uf']."</option>";
                        }
                    ?>
                </select>
            </td>
        </tr>
        <tr align="left">
            <td width="15%">CNPJ:</td>
            <td>
                <input type="text" class="texto" name="txtCnpj" maxlength="18" onkeydown="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );" />
            </td>
        </tr>
        <tr align="left">
            <td colspan="2">
                <input type="button" class="botao" name="btPesquisar" value="Pesquisar"
                       onclick="acessoAjax('inc/instfinanceiras/relatorio_instfinanceira.ajax.php','frmRelatorio','detalhes_instfinanceiras')" />
            </td>
        </tr>
    </table>
    <div id="detalhes_instfinanceiras"></div>
</fieldset>