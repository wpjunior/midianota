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
require_once("../../../include/conect.php");
require_once("../../../funcoes/util.php"); 
	
if($_POST){

	$codverificacao = gera_codverificacao();
	
	
	if($_POST['hdCnpjComTomador']!=""){//des com discriminacao de tomador
		include 'gerarguia_comtomador.php';
	}
	if($_POST['hdCNPJ']!=""){//des sem tomador e o cnpj do emissor nao cadastrado
		include 'gerarguia_semtom_cnpjnaocad.php';
	}
	if($_POST['hdCNPJsemTomador']!=""){//des sem tomador e emissor cadastrado
		include 'gerarguia_semtomador.php';
	}
	if($_POST['hdTotalInputs']!=""){//declaracao de iss retido
		include 'gerarguia_issretido.php';
	}
	
	Mensagem("Serviço(s) declarado(s)!");
	Redireciona("../../tomadores.php");
	//Redireciona("../../boleto/boleto_bb.php?COD=$cod_guia");
}
?>