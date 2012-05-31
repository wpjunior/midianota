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
<fieldset style="margin-left:10px; margin-right:10px;"><legend>Consulta de RPS</legend>
	<form method="post" action="tomadores.php?btRPS=RPS&btConsultaRPS=Consultar">
		<table align="center">
			<tr align="left">
				<td>CPF/CNPJ do tomador<font color="#FF0000">*</font></td>
				<td><input type="text" class="texto" name="txtCNPJCPF" onkeypress="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );" /></td>
			</tr>
			<tr align="left">
				<td>Número do RPS<font color="#FF0000">*</font></td>
				<td><input type="text" class="texto" name="txtNroRPS" onkeypress="return NumbersOnly( event );" /></td>
			</tr>
			<tr align="left">
				<td>Data do RPS<font color="#FF0000">*</font></td>
				<td>
					<input type="text" class="texto" name="txtDataRPS" onkeypress="formatar(this,'00/00/0000');" maxlength="10" />
				</td>
			</tr>
			<tr align="left">
				<td><input type="submit" class="botao" name="btConsultaRPS" value="Consultar" /></td>
				<td><font color="#FF0000">* Dados obrigatórios</font></td>
			</tr>
		</table>
	</form>
<?php
	if($btConsultaRPS=="Consultar")
		{
			if(($txtCNPJCPF=="")||($txtNroRPS=="")||($btConsultaRPS==""))
				{
					echo "
						<script>
							alert('informe os dados do tomador');
							window.location='tomadores.php?btRPS=RPS';
						</script>
					";
				}
			else
				{
					$txtDataRPS=implode("-",array_reverse(explode("/",$txtDataRPS)));
					$sql_tomador=mysql_query("SELECT tomador_nome FROM notas WHERE tomador_cnpjcpf='$txtCNPJCPF' LIMIT 1");
					list($tomador)=mysql_fetch_array($sql_tomador);
					$sql=mysql_query("
						SELECT notas.numero, 
						notas.valortotal, 
						notas.estado, 
						emissores.razaosocial
						FROM notas 
						INNER JOIN 
						emissores ON notas.codemissor=emissores.codigo
						WHERE tomador_cnpjcpf='$txtCNPJCPF'
						AND rps_data='$txtDataRPS'
						AND rps_numero='$txtNroRPS'
					");
					if(mysql_num_rows($sql)>0)
						{
							echo "
								<table align=\"center\" width=\"100%\">
									<tr align=\"left\" bgcolor=\"#999999\">
										<td colspan=\"4\">Recibos Provisórios de Serviço do tomador $tomador</td>
									</tr>
									<tr align=\"left\" bgcolor=\"#999999\">
										<td>Número da Nota</td>
										<td>Valor total da Nota</td>
										<td>Estado da Nota</td>
										<td>Emissor</td>
									</tr>
							";
							list($nro,$valor,$estado,$emissor)=mysql_fetch_array($sql);
							if($estado=="N"){$estado="Normal";}
							elseif($estado=="C"){$estado="Cancelada";}
							elseif($estado=="B"){$estado="Boleto";}
							elseif($estado=="E"){$estado="Escriturada";}
							echo "
									<tr align=\"left\" bgcolor=\"#FFFFFF\">
										<td>$nro</td>
										<td>$valor</td>
										<td>$estado</td>
										<td>$emissor</td>
									</tr>
								</table>
							";	
						}
					else
						{
							echo "
								<script>
									alert('Nenhum registro encontrado');
									window.location='tomadores.php?btRPS=RPS';
								</script>
							";
						}		
				}	
		}
?>	
</fieldset>