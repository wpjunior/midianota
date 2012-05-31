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
	// verifica se já há alguma inst. financeira cadastrada com o cnpj indicado. caso ñ haja, faz o cadastro 
	$sql_verifica=mysql_query("SELECT cnpj FROM inst_financeiras WHERE cnpj='$cnpj'");
	if(mysql_num_rows($sql_verifica)>0)
		{
			Mensagem("Já existe uma Instituição Financeira cadastrada com este CNPJ");
		}
	else
		{
			mysql_query("INSERT INTO inst_financeiras 
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
							senha='$senha',
							estado='$estado'
			");
			
			//monta o corpo do email
			$assunto="ISSDigital";
			$corpo="
				A Prefeitura Municipal de $CIDADE informa que esta instituição financeira foi cadastrada no sitema de ISSDigital do municipio.<br>
				Para acessar o o sistema do ISSDigital acesse o site $Link, o login é próprio CNPJ da instituição. A senha, gerada pelo sistema, é: $senha<br>
				Para sua maior segurança, altere sua senha.
			";
			
			//envia a senha por email
			mail("$email","$assunto","$corpo");
			
			Mensagem("Cadastro efetuado com sucesso!");
		}	
?>
