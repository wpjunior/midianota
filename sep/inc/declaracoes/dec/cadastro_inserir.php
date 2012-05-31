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
	// verifica se já há algum cartorio cadastrado com o cnpj indicado. caso ñ haja, faz o cadastro 
	$sql_verifica=mysql_query("SELECT cnpj FROM cadastro WHERE cnpj='$cnpj'");
	if(mysql_num_rows($sql_verifica)>0)
		{
			Mensagem("Já existe um Cartório cadastrado com este CNPJ");
		}
	else
		{
			$tipocartorio=codtipo('cartorio');
			mysql_query("INSERT INTO cadastro 
							SET 
							codtipo='$tipocartorio',
							nome='$nome',
							razaosocial='$razaosocial',
							cnpj='$cnpj',
							inscrmunicipal='$inscmunicipal',
							numero='$numero',
							bairro='$bairro',
							complemento='$complemento',
							cep='$cep',
							logradouro='$logradouro',
							municipio='$municipio',
							uf='$uf',
							email='$email',
							fonecomercial='$fonecomercial',
							fonecelular='$fonecelular',
							senha='$senha',
							estado='NL'
			"); 
			
			// seleciona o cartorio adicionado
			$sql_busca=mysql_query("SELECT codigo FROM cadastro WHERE cnpj='$cnpj'");
			list($codigo)=mysql_fetch_array($sql_busca);
			// insere nas outras tabelas s dados restantes do cadastro
			$resp=codcargo('responsavel');
			$diret=codcargo('diretor');
			mysql_query("INSERT INTO cartorios SET codcadastro='$codigo', admpublica='$admpublica', nivel='$nivel'");
			mysql_query("INSERT INTO cadastro_resp SET codemissor='$codigo', codcargo='$diret', nome='$diretor', cpf='$diretor_cpf'");
			mysql_query("INSERT INTO cadastro_resp SET codemissor='$codigo', codcargo='$resp', nome='$responsavel', cpf='$responsavel_cpf'");
			
			//monta o corpo do email
			$assunto="ISSDigital";
			$corpo="
				A Prefeitura Municipal de $CIDADE informa que este cartório foi cadastrad no sitema de ISSDigital do municipio.<br>
				Para acessar o o sistema do ISSDigital acesse o site $Link, o login é próprio CNPJ do cartório. A senha, gerada pelo sistema, é: $senha<br>
				Para sua maior segurança, altere sua senha.
			";
			
			//envia a senha por email
			mail("$email","$assunto","$corpo");
			
			Mensagem("Cadastro efetuado com sucesso!");
/*			$sql_cadastrado= mysql_query("SELECT codigo FROM cadastro WHERE cnpj='cnpj'");
			list($codigo)=mysql_fetch_array($sql_cadastrado);
*/		
		}	
?>
