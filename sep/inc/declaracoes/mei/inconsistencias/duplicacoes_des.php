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
	$query=mysql_query("
	SELECT  cad.codigo,cad.nome, ds.tomador_cnpjcpf ,COUNT(ds.nota_nro) as nronotas,ds.nota_nro  
	FROM cadastro as cad
	INNER JOIN simples_des ON simples_des.codemissor=cad.codigo 			
	INNER JOIN simples_des_servicos as ds ON ds.codsimples_des=simples_des.codigo
	WHERE cad.codigo = '{$cod_emissor}' 		
	GROUP BY ds.nota_nro, cad.codigo 
	HAVING nronotas >1 AND COUNT(distinct ds.tomador_cnpjcpf)<>1");	
	
	while($dados = mysql_fetch_object($query)){		
	  $sql=mysql_query("SELECT nota_nro FROM  inconsistencias WHERE codemissor ='{$dados->codigo}' AND nota_nro='{$dados->nota_nro}'");	  
	  if(mysql_num_rows($sql)==0){	  
		mysql_query("INSERT INTO inconsistencias 
					 SET codemissor='{$dados->codigo}',nota_nro='{$dados->nota_nro}',estado='A',tipo='duplicadas',datahorainconsistencia=NOW()");
	  }
	}	