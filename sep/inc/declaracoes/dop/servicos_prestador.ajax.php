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
/* Não gravar em cache */
include '../../nocache.php';

include("../../conect.php");
include("../../../funcoes/util.php");

$prestador_cnpj = $_GET['cnpj'];
$c = $_GET['contador'];
$sql_servicos2 = mysql_query("
	SELECT servicos.codigo, 
		   servicos.descricao, 
		   servicos.aliquota 
	FROM servicos 
	INNER JOIN cadastro_servicos ON servicos.codigo=cadastro_servicos.codservico
	INNER JOIN cadastro ON cadastro_servicos.codemissor=cadastro.codigo 
	WHERE (cadastro.cpf='$prestador_cnpj' OR cadastro.cnpj='$prestador_cnpj') AND 
		  cadastro.estado = 'A';
") or die(mysql_error());
if(mysql_num_rows($sql_servicos2)){
	echo "
	<select style=\"width:150px;\" id=\"cmbCodServico$c\" name=\"cmbCodServico$c\" 
	 onchange=\"var temp = this.value.split('|'); getElementById('txtAliquota$c').value = temp[0]; 
	 dop.CalculaImposto(txtBaseCalculo$c,txtAliquota$c,txtImposto$c);\">
    <option/>";
	
	while(list($cod_serv, $desc_serv, $aliq_serv) = mysql_fetch_array($sql_servicos2)) {
		if(strlen($desc_serv)>100)
			$desc_serv = substr($desc_serv,0,100)."...";
		echo "<option value=\"$aliq_serv|$cod_serv\" id=\"$aliq_serv\">$desc_serv</option>";
	}
	echo "</select>";
} else {
	echo "<select style=\"width:150px;\" id=\"cmbCodServico$c\" name=\"cmbCodServico$c\"><option/></select>";
}
?>