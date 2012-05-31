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
require_once("../../conect.php");
require_once("../../../funcoes/util.php");
require_once("../../nocache.php");
	
	if(isset($_GET)){
		$tipo = $_GET['CmbTipos'];
		$pago = $_GET['RGListar'];
	}
	if($pago == 'NP'){
		$str_and = " AND guia_pagamento.pago = 'N' ";
	}
	elseif($pago == 'P'){
		$str_and = " AND guia_pagamento.pago = 'S' ";
	}
	elseif($pago == 'A'){
		$dataatual = date('Y-m-d');
		$str_and = " AND guia_pagamento.datavencimento<'$dataatual' AND guia_pagamento.pago = 'N' ";
	}
	elseif($pago == 'T'){
		$str_and = " ";
	}
	
	if($tipo == 'DES')
	{
	 $sqltodos = 
	 ("SELECT cadastro.razaosocial, guia_pagamento.valor, guia_pagamento.pago, 
	 guia_pagamento.dataemissao, guia_pagamento.datavencimento, guia_pagamento.nossonumero, guias_declaracoes.codguia
	 FROM guia_pagamento 
	 INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia 
	 INNER JOIN des ON guias_declaracoes.codrelacionamento=des.codigo
	 INNER JOIN cadastro ON des.codemissor=cadastro.codigo
	 WHERE guias_declaracoes.relacionamento = 'des' $str_and GROUP BY guia_pagamento.codigo");
	}
	elseif($tipo == 'DEC')
	{
	 $sqltodos = 
 	 ("SELECT cartorios.nome, guia_pagamento.valor, guia_pagamento.pago, 
	 guia_pagamento.dataemissao, guia_pagamento.datavencimento, guia_pagamento.nossonumero, guias_declaracoes.codguia
	 FROM guia_pagamento 
	 INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia 
	 INNER JOIN cartorios_des ON guias_declaracoes.codrelacionamento=cartorios_des.codigo
	 INNER JOIN cartorios ON cartorios_des.codcartorio=cartorios.codigo
	 WHERE guias_declaracoes.relacionamento = 'cartorios_des' $str_and GROUP BY guia_pagamento.codigo");
	}
	elseif($tipo =='DESTemp')
	{
	 $sqltodos = 
	 ("SELECT emissores_temp.razaosocial, guia_pagamento.valor, guia_pagamento.pago, 
	 guia_pagamento.dataemissao, guia_pagamento.datavencimento, guia_pagamento.nossonumero, guias_declaracoes.codguia
	 FROM guia_pagamento 
	 INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia 
	 INNER JOIN des_temp ON guias_declaracoes.codrelacionamento=des_temp.codigo
	 INNER JOIN emissores_temp ON des_temp.codemissores_temp=emissores_temp.codigo
	 WHERE guias_declaracoes.relacionamento = 'des_temp' $str_and GROUP BY guia_pagamento.codigo");
	}
	elseif($tipo =='DOP')
	{
	 $sqltodos = 
	 ("SELECT orgaospublicos.nome, guia_pagamento.valor, guia_pagamento.pago, 
	 guia_pagamento.dataemissao, guia_pagamento.datavencimento, guia_pagamento.nossonumero, guias_declaracoes.codguia
	 FROM guia_pagamento 
	 INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia 
	 INNER JOIN dop_des ON guias_declaracoes.codrelacionamento=dop_des.codigo
	 INNER JOIN orgaospublicos ON dop_des.codorgaopublico=orgaospublicos.codigo
	 WHERE guias_declaracoes.relacionamento = 'dop_des' $str_and GROUP BY guia_pagamento.codigo");
	}
	elseif($tipo =='DIF')
	{
	 $sqltodos = 
	 ("SELECT inst_financeiras.nome, guia_pagamento.valor, guia_pagamento.pago, 
	 guia_pagamento.dataemissao, guia_pagamento.datavencimento, guia_pagamento.nossonumero, guias_declaracoes.codguia
	 FROM guia_pagamento 
	 INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia 
	 INNER JOIN dif_des ON guias_declaracoes.codrelacionamento=dif_des.codigo
	 INNER JOIN inst_financeiras ON dif_des.codinst_financeira=inst_financeiras.codigo
	 WHERE guias_declaracoes.relacionamento = 'dif_des' $str_and GROUP BY guia_pagamento.codigo");
	}
	elseif($tipo =='DECC')
	{
	 $sqltodos = 
	 ("SELECT empreiteiras.nome, guia_pagamento.valor, guia_pagamento.pago, 
	 guia_pagamento.dataemissao, guia_pagamento.datavencimento, guia_pagamento.nossonumero, guias_declaracoes.codguia
	 FROM guia_pagamento 
	 INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia 
	 INNER JOIN decc_des ON guias_declaracoes.codrelacionamento=decc_des.codigo
	 INNER JOIN empreiteiras ON decc_des.codempreiteira=empreiteiras.codigo
	 WHERE guias_declaracoes.relacionamento = 'decc_des' $str_and GROUP BY guia_pagamento.codigo");
	}
	elseif($tipo =='DOC')
	{
	 $sqltodos = 
	 ("SELECT operadoras_creditos.nome, guia_pagamento.valor, guia_pagamento.pago, 
	 guia_pagamento.dataemissao, guia_pagamento.datavencimento, guia_pagamento.nossonumero, guias_declaracoes.codguia
	 FROM guia_pagamento 
	 INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia 
	 INNER JOIN doc_des ON guias_declaracoes.codrelacionamento=doc_des.codigo
	 INNER JOIN operadoras_creditos ON doc_des.codopr_credito=operadoras_creditos.codigo
	 WHERE guias_declaracoes.relacionamento = 'doc_des' $str_and GROUP BY guia_pagamento.codigo");
	}
	elseif($tipo =='NFE')
	{
	 $sqltodos = 
	 ("SELECT cadastro.razaosocial, guia_pagamento.valor, guia_pagamento.pago, 
	 guia_pagamento.dataemissao, guia_pagamento.datavencimento, guia_pagamento.nossonumero, guias_declaracoes.codguia, guias_declaracoes.relacionamento
	 FROM guia_pagamento
	 INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia 
	 INNER JOIN notas ON guias_declaracoes.codrelacionamento=notas.codigo
	 INNER JOIN cadastro ON notas.codemissor=cadastro.codigo
	 WHERE guias_declaracoes.relacionamento = 'nfe' $str_and GROUP BY guia_pagamento.codigo");
	}
	elseif($tipo =='DESISSRetido')
	{
	 $sqltodos = 
	 ("SELECT tomadores.nome, guia_pagamento.valor, guia_pagamento.pago, 
	 guia_pagamento.dataemissao, guia_pagamento.datavencimento, guia_pagamento.nossonumero, guias_declaracoes.codguia
	 FROM guia_pagamento 
	 INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia 
	 INNER JOIN des_issretido ON guias_declaracoes.codrelacionamento=des_issretido.codigo
	 INNER JOIN tomadores ON des_issretido.codtomador=tomadores.codigo
	 WHERE guias_declaracoes.relacionamento = 'des_issretido' $str_and GROUP BY guia_pagamento.codigo");
	}
	?>
		
			<fieldset style="width:800px"><legend><?php if($tipo!='S'){echo "Escriturações  $tipo";} ?></legend>    
					<?php
					if($tipo!='S'){
					$sql=Paginacao($sqltodos,'frmRelatorio','divListar');
                    $resultados=mysql_num_rows($sql);
						if(mysql_num_rows($sql)>0){
						?>
						<table width="800">
                            <tr bgcolor="#999999">
                                <td width="210" align="center">Nome</td>
                                <td width="200" align="center">Nosso Número</td>
                                <td width="80" align="center">Valor</td>
                                <td width="80" align="center">Pagamento</td>
                                <td width="95" align="center">Data Emissão</td>
                                <td width="110"align="center">Data Vencimento</td>
                            </tr>
							<?php
							while(list($razao, $valor, $pago, $dtemissao, $dtvenc, $nossonumero) = mysql_fetch_array($sql))
							{
							$nomerazao = ResumeString($razao,27);
							$dtemissao = DataPt($dtemissao);
							$dtvenc = DataPt($dtvenc);
							$valor = DecToMoeda($valor);
							
							switch($pago)
							{
							case "S": $pago="Efetuado"; break;
							case "N": $pago="Não Efetuado"; break;
							}
							echo "
							<tr bgcolor=\"#FFFFFF\" title=\"$razao\">
								<td align=\"center\">$nomerazao</td>
								<td align=\"center\">$nossonumero</td>
								<td align=\"right\">$valor</td>
								<td align=\"center\">$pago</td>
								<td align=\"center\">$dtemissao</td>
								<td align=\"center\">$dtvenc</td>																		
							</tr>
							";	

							}
						}
						else
						{
						 echo "&nbsp;&nbsp;Nenhuma Guia Encontrada";
						}
							
					}
					else
					{
						echo "&nbsp;&nbsp;Escolha um Tipo";
					}
							?>
                    	</table>
					</fieldset>