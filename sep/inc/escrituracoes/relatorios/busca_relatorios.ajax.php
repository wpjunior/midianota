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


$sqltipo = ("SELECT guias_declaracoes.relacionamento, guia_pagamento.codigo, guia_pagamento.nossonumero FROM guia_pagamento INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia GROUP BY guia_pagamento.codigo ORDER BY guia_pagamento.dataemissao");
if(mysql_num_rows($sql)>0){
?>
			<fieldset style="width:800px"><legend>Resultado de Busca:</legend>
				<?php
                $sql=Paginacao($sqltipo,'frmRelatorio','divListar');
                $resultados=mysql_num_rows($sql);
                if(mysql_num_rows($sql)>0){
                ?>
				<table width="100%">
							<tr bgcolor="#999999">
								<td width="210" align="center">Nome</td>
								<td width="200" align="center">Nosso Número</td>
								<td width="80" align="center">Valor</td>
								<td width="80" align="center">Pagamento</td>
								<td width="95" align="center">Data Emissão</td>
								<td width="110"align="center">Data Vencimento</td>
							</tr>
						<?php
                        while(list($tipo, $codigo) = mysql_fetch_array($sql)){
						if($tipo=="des")
						{
							$relacionamento = mysql_query("
							SELECT cadastro.razaosocial, guia_pagamento.valor, guia_pagamento.pago, 
							guia_pagamento.dataemissao, guia_pagamento.datavencimento, guia_pagamento.nossonumero, guias_declaracoes.codguia
							FROM guia_pagamento 
							INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia 
							INNER JOIN des ON guias_declaracoes.codrelacionamento=des.codigo
							INNER JOIN cadastro ON des.codemissor=cadastro.codigo
							WHERE guia_pagamento.codigo = '$codigo' GROUP BY guia_pagamento.codigo");
						}
						elseif($tipo=="des_issretido")
						{
							$relacionamento = mysql_query("
							SELECT tomadores.nome, guia_pagamento.valor, guia_pagamento.pago, 
							guia_pagamento.dataemissao, guia_pagamento.datavencimento, guia_pagamento.nossonumero, guias_declaracoes.codguia
							FROM guia_pagamento 
							INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia 
							INNER JOIN des_issretido ON guias_declaracoes.codrelacionamento=des_issretido.codigo
							INNER JOIN tomadores ON des_issretido.codtomador=tomadores.codigo
							WHERE guia_pagamento.codigo = '$codigo' GROUP BY guia_pagamento.codigo");
						}
						elseif($tipo=="cartorios_des")
						{
							$relacionamento = mysql_query("
							SELECT cartorios.nome, guia_pagamento.valor, guia_pagamento.pago, 
							guia_pagamento.dataemissao, guia_pagamento.datavencimento, guia_pagamento.nossonumero, guias_declaracoes.codguia
							FROM guia_pagamento 
							INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia 
							INNER JOIN cartorios_des ON guias_declaracoes.codrelacionamento=cartorios_des.codigo
							INNER JOIN cartorios ON cartorios_des.codcartorio=cartorios.codigo
							WHERE guia_pagamento.codigo = '$codigo' GROUP BY guia_pagamento.codigo");
						}
						elseif($tipo=="dop_des")
						{
							$relacionamento = mysql_query("
							SELECT orgaospublicos.nome, guia_pagamento.valor, guia_pagamento.pago, 
							guia_pagamento.dataemissao, guia_pagamento.datavencimento, guia_pagamento.nossonumero, guias_declaracoes.codguia
							FROM guia_pagamento 
							INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia 
							INNER JOIN dop_des ON guias_declaracoes.codrelacionamento=dop_des.codigo
							INNER JOIN orgaospublicos ON dop_des.codorgaopublico=orgaospublicos.codigo
							WHERE guia_pagamento.codigo = '$codigo' GROUP BY guia_pagamento.codigo");
						}
						elseif($tipo=="dif_des")
						{
							$relacionamento = mysql_query("
							SELECT inst_financeiras.nome, guia_pagamento.valor, guia_pagamento.pago, 
							guia_pagamento.dataemissao, guia_pagamento.datavencimento, guia_pagamento.nossonumero, guias_declaracoes.codguia
							FROM guia_pagamento 
							INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia 
							INNER JOIN dif_des ON guias_declaracoes.codrelacionamento=dif_des.codigo
							INNER JOIN inst_financeiras ON dif_des.codinst_financeira=inst_financeiras.codigo
							WHERE guia_pagamento.codigo = '$codigo' GROUP BY guia_pagamento.codigo");
						}
						elseif($tipo=="decc_des")
						{
							$relacionamento = mysql_query("
							SELECT empreiteiras.nome, guia_pagamento.valor, guia_pagamento.pago, 
							guia_pagamento.dataemissao, guia_pagamento.datavencimento, guia_pagamento.nossonumero, guias_declaracoes.codguia
							FROM guia_pagamento 
							INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia 
							INNER JOIN decc_des ON guias_declaracoes.codrelacionamento=decc_des.codigo
							INNER JOIN empreiteiras ON decc_des.codempreiteira=empreiteiras.codigo
							WHERE guia_pagamento.codigo = '$codigo' GROUP BY guia_pagamento.codigo");
						}
						elseif($tipo=="doc_des")
						{
							$relacionamento = mysql_query("
							SELECT operadoras_creditos.nome, guia_pagamento.valor, guia_pagamento.pago, 
							guia_pagamento.dataemissao, guia_pagamento.datavencimento, guia_pagamento.nossonumero, guias_declaracoes.codguia
							FROM guia_pagamento 
							INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia 
							INNER JOIN doc_des ON guias_declaracoes.codrelacionamento=doc_des.codigo
							INNER JOIN operadoras_creditos ON doc_des.codopr_credito=operadoras_creditos.codigo
							WHERE guia_pagamento.codigo = '$codigo' GROUP BY guia_pagamento.codigo");
						}
						elseif($tipo=="nfe")
						{
							$relacionamento = mysql_query("
                            SELECT cadastro.razaosocial, guia_pagamento.valor, guia_pagamento.pago, 
							guia_pagamento.dataemissao, guia_pagamento.datavencimento, guia_pagamento.nossonumero, guias_declaracoes.codguia, guias_declaracoes.relacionamento
							FROM guia_pagamento
							INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia 
							INNER JOIN notas ON guias_declaracoes.codrelacionamento=notas.codigo
							INNER JOIN cadastro ON notas.codemissor=cadastro.codigo
                            WHERE guia_pagamento.codigo = '$codigo' GROUP BY guia_pagamento.codigo");
						}
						elseif($tipo =='des_temp')
						{
						 $relacionamento = mysql_query("SELECT emissores_temp.razaosocial, guia_pagamento.valor, guia_pagamento.pago, 
						 guia_pagamento.dataemissao, guia_pagamento.datavencimento, guia_pagamento.nossonumero, guias_declaracoes.codguia
						 FROM guia_pagamento 
						 INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia 
						 INNER JOIN des_temp ON guias_declaracoes.codrelacionamento=des_temp.codigo
						 INNER JOIN emissores_temp ON des_temp.codemissores_temp=emissores_temp.codigo
                         WHERE guia_pagamento.codigo = '$codigo' GROUP BY guia_pagamento.codigo");
						}
		
					while(list($razao, $valor, $pago, $dtemissao, $dtvenc, $nn, $codguia) = mysql_fetch_array($relacionamento)){
					$emissao = implode('/', array_reverse(explode('-', $dtemissao)));
					$vencimento = implode('/', array_reverse(explode('-', $dtvenc)));
					$nomerazao = ResumeString($razao,27);
					switch($pago)
					{
					case "S": $pago="Efetuado"; break;
					case "N": $pago="Não Efetuado"; break;
					}
					
					echo "
					<tr bgcolor=\"#FFFFFF\">
						<td align=\"center\" title=\"$razao\">$nomerazao</td>
						<td align=\"center\">$nn</td>
						<td align=\"center\">$valor</td>
						<td align=\"center\">$pago</td>
						<td align=\"center\">$emissao</td>
						<td align=\"center\">$vencimento</td>																		
					</tr>
					";	
					}
				}
				
				}					
					?>
				</table>
			</fieldset>
<?php
}
?>			