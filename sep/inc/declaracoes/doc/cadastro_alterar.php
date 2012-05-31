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
	mysql_query("UPDATE inst_financeiras 
					SET codbanco='$codbanco',
					nome='$nome',
					razaosocial='$razaosocial',
					agencia='$agencia',
					cnpj='$cnpj',
					gerente='$gerente',
					gerente_cpf='$gerente_cpf',
					responsavel='$responsavel',
					responsavel_cpf='$responsavel_cpf',
					inscrmunicipal='$insc_municipal',
					endereco='$endereco',
					municipio='$municipio',
					uf='$uf',
					email='$email',
					fone1='$fone1',
					fone2='$fone2',
					estado='$estado'
				WHERE codigo='$cod'	
	");
	add_logs('Atualizou dados de uma Instituição Finaceira');
	Mensagem("Dados alterados com sucesso!");				
?>