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
	if($_POST["cmbCategoria"]){
		$wherecmbcategoria = "WHERE servicos_categorias.codigo='".$_POST["cmbCategoria"]."'";
	}
	$sql=mysql_query("SELECT emissores.razaosocial, emissores.endereco, emissores.email FROM emissores INNER JOIN emissores_servicos ON emissores.codigo=emissores_servicos.codemissor INNER JOIN servicos ON emissores_servicos.codservico=servicos.codigo INNER JOIN servicos_categorias ON servicos.codcategoria=servicos_categorias.codigo $wherecmbcategoria");	
	if(mysql_num_rows($sql)>0)
		{
			?>
				<fieldset><legend><?php echo mysql_num_rows($sql); ?> Prestadores desta categoria encontrados</legend>	
					<table width="100%">
						<tr bgcolor="#999999" align="center">
							<td width="33%">Emissor</td>
							<td width="33%">Endereço</td>
							<td width="33%">Email</td>
						</tr>
					</table>	
					<div style="height:250px; overflow:auto">
						<table width="100%">
							<?php
								while(list($emissor,$endereco,$email)=mysql_fetch_array($sql))
									{
										?>
											<tr bgcolor="#FFFFFF" align="center">
												<td width="33%"><?php echo $emissor; ?></td>
												<td width="33%"><?php echo $endereco; ?></td>
												<td width="33%"><?php echo $email; ?></td>
											</tr>
										<?php	
									}
							?>			
						</table>
					</div>	
				</fieldset>	
			<?php
		}
	else
		{
			echo "Nenhum prestador desta categoria foi encontrado!";
		}			?>
