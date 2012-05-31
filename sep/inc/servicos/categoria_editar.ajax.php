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

//recebe o include que mantem a pagina
$include = $_GET['include'];
//conecta ao banco
include("../conect.php");
//recebe o codigo que veio por get
$codigo = $_GET['hdcod'];

//sql buscando informacoes sobre o usuario
$sql_info = mysql_query("SELECT nome FROM servicos_categorias WHERE codigo = '$codigo'");
list($descricao) = mysql_fetch_array($sql_info);
?>
<input type="hidden" name="hdCodServ" value="<?php echo $codigo;?>">
<table width="100%">
	<tr bgcolor="#FFFFFF">
		<td align="left"><input name="txtServicoEdit" type="text" class="texto" size="95" value="<?php echo $descricao;?>"></td>
	</tr>
	<tr>
		<td align="left"><input name="btSalvar" type="submit" class="botao" value="Salvar"></td>
	</tr>
</table>
