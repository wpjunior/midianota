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

	$query=mysql_query("SELECT MAX(nota_nro) as maxnota FROM inconsistencias 
					    WHERE codemissor='{$cod_emissor}' AND tipo='sequencia'");			
	if(mysql_num_rows($query)>0){
		$min=mysql_fetch_object($query);	
		$minimo=$min->maxnota+1;				
	}else{
		$minimo = 1;
	}	

	$sql=mysql_query("SELECT cad.codigo,MIN(ds.nota_nro) as minnro,MAX(ds.nota_nro)as maxnro,des.codigo as coddec 
						 	 FROM cadastro as cad
						 	 INNER JOIN des ON des.codcadastro=cad.codigo
							 INNER JOIN des_servicos as ds ON ds.coddes=des.codigo							  
							 WHERE cad.codigo='{$cod_emissor}' 
							 GROUP BY des.codcadastro");				  
			
			while($dados=mysql_fetch_object($sql)){				
				for($cont = $minimo ;$cont < $dados->maxnro;$cont++){
					$query=mysql_query("SELECT cad.nome FROM cadastro as cad
					 					INNER JOIN des ON des.codcadastro=cad.codigo
					 					INNER JOIN des_servicos as ds ON ds.coddes=des.codigo					 					
					 					WHERE ds.nota_nro='$cont' AND cad.codigo={$cod_emissor}");
	
					
					if(mysql_num_rows($query)==0){											
						$query=mysql_query("INSERT INTO inconsistencias SET codemissor='{$cod_emissor}',
						nota_nro='{$cont}',estado='A',tipo='sequencia',datahorainconsistencia=NOW()");				
					}			
				}
			}							