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
    // recebe o codigo da obra que sera exibida
	$codobra=$_POST["txtCodObra"];
	
	//busca os dados e exibe na tela
	$sql_obra=mysql_query("SELECT codempreiteira, obra, alvara, endereco, proprietario, proprietario_cnpjcpf, dataini, datafim, estado FROM obras WHERE codigo=$codobra");
	$dados_obra=mysql_fetch_array($sql_obra);
	$dados_obra['dataini']=DataPt($dados_obra['dataini']);
    if($dados_obra['estado']=="C"){
        $dados_obra['datafim']=DataPt($dados_obra['datafim']);
    }
?>
<table align="center">
	<tr align="left">
		<td>Obra:</td>
		<td><?php echo $dados_obra['obra']; ?></td>
	</tr>
	<tr align="left">
		<td>Alvará Nº:</td>
		<td><?php echo $dados_obra['alvara']; ?></td>
	</tr>
	<tr align="left">
		<td>Endereço:</td>
		<td><?php echo $dados_obra['endereco']; ?></td>
	</tr>
	<tr align="left">
		<td>Proprietário:</td>
		<td><?php echo $dados_obra['proprietario']; ?></td>
	</tr>
	<tr align="left">
		<td>CNPJ/CPF Proprietário:</td>
		<td><?php echo $dados_obra['proprietario_cnpjcpf']; ?></td>
	</tr>
	<tr align="left">
		<td>Data de Inicio:</td>
		<td><?php echo $dados_obra['dataini']; ?></td>
	</tr>
    <tr align="left">
        <td>Data de Conclusão</td>
        <td>
            <?php
                if($dados_obra['estado']=="C"){
                    echo $dados_obra['datafim'];
                }
                else{
                    echo "Em andamento";
                }
            ?>
        </td>
    </tr>
    <tr align="left">
        <td colspan="2">
            <form method="post" id="frmVoltar">
                <input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
                <input type="hidden" name="cmbEmpreiteira" value="<?php echo (int)$dados_obra['codempreiteira']; ?>" />
                <input type="hidden" name="btObras" value="Listar Obras" />
                <input type="submit" class="botao" name="btVoltar" value="Voltar" />
            </form>
        </td>
    </tr>
</table>