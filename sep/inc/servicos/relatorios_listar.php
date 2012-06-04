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
	if($codservico){
		$wherecodservico = "WHERE emissores_servicos.codservico='$codservico'";
	}
	$sql=mysql_query("SELECT emissores.razaosocial, emissores.endereco, emissores.email FROM emissores INNER JOIN emissores_servicos ON emissores.codigo=emissores_servicos.codemissor $wherecodservico");
	if(mysql_num_rows($sql)>0)
		{
			?>
				<fieldset><legend><?php echo mysql_num_rows($sql); ?> Prestadores deste serviço encontrados</legend>	
					<table width="100%">
						<tr bgcolor="#999999">
							<td width="33%">Emissor</td>
							<td width="33%">Endereço</td>
							<td width="33%">E-mail</td>
						</tr>
					</table>
					<div id="detalhes" style="height:250px; overflow:auto;">
						<table width="100%">
							<?php
								while(list($razaosocial,$endereco,$email)=mysql_fetch_array($sql))
									{
										echo "
											<tr bgcolor=\"#FFFFFF\">
												<td width=\"33%\">$razaosocial</td>
												<td width=\"33%\">$endereco</td>
												<td width=\"33%\">$email</td>
											</tr>
										";
									}
							?>
						</table>
					</div>
				</fieldset>	
	<?php
		}
	else
		{
			echo "Nenhum prestador deste serviço encontrado!";
		}		
	?>
