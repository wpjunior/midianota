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
		$wherecodserviconfe = "notas.codservico='$codservico' AND";
		$wherecodservicodes = "des_servicos.codservico='$codservico' AND";
	}
	// busca os dados na tabela notas
	$sql_notas=mysql_query("SELECT notas.datahoraemissao, notas.tomador_nome, notas.valoriss, emissores.nome FROM notas INNER JOIN emissores ON notas.codemissor=emissores.codigo WHERE $wherecodservico notas.datahoraemissao>='$dataini' AND notas.datahoraemissao<='$datafim'");
	
	// busca os dados na tabela des
	$sql_des=mysql_query("SELECT des.data_gerado, des.total, emissores.razaosocial, tomadores.nome FROM des INNER JOIN emissores ON des.codemissor=emissores.codigo INNER JOIN des_servicos ON des.codigo=des_servicos.coddes INNER JOIN tomadores ON des_servicos.tomador_cnpjcpf=tomadores.cnpjcpf WHERE $wherecodservicodes des.data_gerado>='2009-07-01' AND des.data_gerado<='2009-09-28'"); 
	
	if((mysql_num_rows($sql_notas)>0)||(mysql_num_rows($sql_des)>0))
		{
			$qtd=mysql_num_rows($sql_notas)+mysql_num_rows($sql_des);
			?>
				<fieldset><legend><?php echo $qtd; ?> Prestações do serviço durante o período</legend>	
					<table width="100%">
						<tr bgcolor="#999999">
							<td width="25%">Data</td>
							<td width="25%">Prestador</td>
							<td width="25%">Tomador</td>
							<td width="25%">ISS Gerado</td>
						</tr>
					</table>
					<div id="detalhes" style="height:250px; overflow:auto">
						<table width="100%">
							<?php
								while(list($emissao,$tomador,$iss,$emissor)=mysql_fetch_array($sql_notas))
									{
										$data=explode(" ",$emissao);
										$data[0]=DataPt($data[0]);
										echo "
											<tr bgcolor=\"#FFFFFF\">
												<td width=\"25%\">$data[0]</td>
												<td width=\"25%\">$emissor</td>
												<td width=\"25%\">$tomador</td>
												<td width=\"25%\">$iss</td>
											</tr>
										";
									}
								while(list($data,$iss,$emissor,$tomador)=mysql_fetch_array($sql_des))
									{
										$data=DataPt($data);
										echo "
											<tr bgcolor=\"#FFFFFF\">
												<td width=\"25%\">$data[0]</td>
												<td width=\"25%\">$emissor</td>
												<td width=\"25%\">$tomador</td>
												<td width=\"25%\">$iss</td>
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
			echo "Nenhuma prestação deste serviço foi realizada durante o período!";
		}		?>
