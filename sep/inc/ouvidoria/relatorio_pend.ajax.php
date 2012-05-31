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
	include('../conect.php');
	include("../../funcoes/util.php");
	$sql=mysql_query("SELECT assunto, especificacao, tomador_cnpj, tomador_email, datareclamacao, estado, responsavel FROM reclamacoes WHERE estado='pendente'");
?>

<table width="800" bgcolor="#CCCCCC" cellpadding="0" cellspacing="0">
	<tr>
		<td>			
			<fieldset style="width:800px"><legend>Busca de Escriturações Pagas</legend>
				<table width="100%">
					<tr bgcolor="#999999">
						<td align="center" width="200">Assunto</td>
						<td align="center" width="160">Especificação</td>
						<td align="center" width="100">Tomador</td>
						<td align="center" width="140">E-mail</td>
						<td align="center" width="110">Data Reclamação</td>
						<td align="center" width="100">Responsável</td>
					</tr>
			<?php
			while(list($assunto, $especificacao, $tomador, $email, $data, $estado, $responsavel)=mysql_fetch_array($sql)){
				echo "
					<tr bgcolor=\"#FFFFFF\" height=\"30\">
						<td align=\"center\">$assunto</td>
						<td align=\"center\">$especificacao</td>
						<td align=\"center\">$tomador</td>
						<td align=\"center\">$email</td>
						<td align=\"center\">$data</td>
						<td align=\"center\">$responsavel</td>
					<tr>
					";
					}	
			?>	
				</table>
			</fieldset>
		</td>
	</tr>
</table>