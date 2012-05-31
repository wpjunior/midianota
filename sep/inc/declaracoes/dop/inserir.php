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
$nome           = $_POST["txtNome"];
$cnpj        	= $_POST["txtCnpj"];
$endereco       = $_POST["txtEndereco"];
$cep            = $_POST["txtCep"];
$municipio      = $_POST["txtInsMunicipioOrgao"];
$uf	        = $_POST["txtUfOrgao"];
$email          = $_POST["txtEmail"];
$razaosocial    = $_POST["txtRazaoSocial"];
$fone  			= $_POST["txtFoneComercial"];
$fone_adicional = $_POST["txtFoneAdicional"];
$nivel			= $_POST["cmbNivel"];
$admpublica		= $_POST["cmbAdmPublica"];
$estado			= "A";						
$nomediretor     = $_POST["txtNomeDiretor"];
$cpfdiretor      = $_POST["txtCpfDiretor"];
$nomeresponsavel = $_POST["txtNomeResponsavel"];
$cpfresponsavel  = $_POST["txtCpfResponsavel"];
$senha			 = rand(000000,999999);
	
$teste_nome=mysql_query("SELECT codigo FROM orgaospublicos WHERE nome='$nome'");
$teste_razaosocial=mysql_query("SELECT codigo FROM orgaospublicos where razaosocial='$razaosocial'");
$teste_cnpj=mysql_query("SELECT codigo FROM orgaospublicos WHERE cnpj='$cnpj'");

if(mysql_num_rows($teste_nome)>0)
{echo "<script>alert('Já existe uma empresa com este nome');</script>";}	
elseif(mysql_num_rows($teste_razaosocial)>0)
{echo "<script>alert('Já existe uma empresa com esta razão social');</script>";}	
elseif(mysql_num_rows($teste_cnpj)>0)
{echo "<script>alert('Já existe uma empresa com este CPF/CNPJ');</script>";}
else{
mysql_query("
INSERT INTO orgaospublicos SET 
nome='$nome', 
razaosocial='$razaosocial', 
cnpj='$cnpj', 
endereco='$endereco', 
municipio='$municipio', 
uf='$uf', 
email='$email', 
telefone='$fone', 
telefone_adicional='$fone_adicional', 
responsavel_nome='$nomeresponsavel', 
responsavel_cpf='$cpfresponsavel', 
diretor_nome='$nomediretor', 
diretor_cpf='$cpfdiretor',
admpublica='$admpublica',
nivel='$nivel',
senha='$senha',
estado='$estado'
");

Mensagem('Dados Cadastrados com sucesso');

}

?>