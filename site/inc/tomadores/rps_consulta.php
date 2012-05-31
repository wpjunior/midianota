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

	if(($txtNumeroRps !="")&&($txtDataRps !="") &&($txtPrestCpfCnpj !="")&&($txtTomCpfCnpj !=""))
	{

		$campo = tipoPessoa($txtPrestCpfCnpj);
		$datarps = implode("-",array_reverse(explode("/", $txtDataRps)));
		if($campo)
		{

			$sql=mysql_query("SELECT notas.codigo FROM notas INNER JOIN cadastro ON
			`notas`.`codemissor` = `cadastro`.`codigo` WHERE notas.rps_numero='$txtNumeroRps' AND notas.rps_data='$datarps' AND 
			notas.tomador_cnpjcpf='$txtTomCpfCnpj' AND cadastro.$campo ='$txtPrestCpfCnpj'"); 		
			$registros=mysql_num_rows($sql);
				if($registros >0)
				{
					list($cod_nota)=mysql_fetch_array($sql);
					$codigo = base64_encode($cod_nota); 
					print("<script language=\"javascript\">  window.open('../reports/nfe_imprimir.php?CODIGO=$codigo&CAMPO=$txtPrestCpfCnpj');</script>");
				}		
				else{			
					print("<script language=JavaScript>alert('Não existe nota cadastrada com estes dados!');parent.location='tomadores.php';</script>");
				}
		}else{
		 		print("<script language=JavaScript>alert('Não existe nota cadastrada com estes dados!');parent.location='tomadores.php';</script>");		  		 
		}
		 		
	}else{
		print("<script language=JavaScript>alert('Todos os campos devem ser preenchidos para realizar a consulta.');</script>"); 
	}
?>