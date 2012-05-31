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
$codDaSessao = $_SESSION['codempresa'];
$sql_tipo_declaracao = mysql_query("SELECT codtipodeclaracao FROM cadastro WHERE codigo = '$codDaSessao'");
list($codtipodeclaracao) = mysql_fetch_array($sql_tipo_declaracao);
$codtipodec = coddeclaracao('Simples Nacional');

if($codtipodeclaracao == $codtipodec){
	// itens de menu
	$menu = array("Notas Eletrônicas","Cadastro","Contador","Livro Digital","AIDF Eletrônico","Importar RPS","Exportar Notas","Ouvidoria","Utilitários","Sair");
	$links = array("notas.php","empresas.php","definir_contador.php","livro.php","aidf.php","importar.php","exportar.php","reclamacoes.php","utilitarios.php","logout.php");
}else{
	// itens de menu
	$menu = array("Notas Eletrônicas","Cadastro","Contador","Guia de Pagamento","Livro Digital","AIDF Eletrônico","Importar RPS","Exportar Notas","Ouvidoria","Utilitários","Sair");
	$links = array("notas.php","empresas.php","definir_contador.php","pagamento.php","livro.php","aidf.php","importar.php","exportar.php","reclamacoes.php","utilitarios.php","logout.php");
}
// contador do vetor
$cont = count($menu);
// variavel auxiliar
$aux = 0;

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php
// lista itens de menu
while($aux < $cont) {
	// imprime html
	
?>
  <tr>
    <td height="20" class="menu">
		<?php 
			print(" <a class=\"menu\" href=$links[$aux] target=_parent>&nbsp;$menu[$aux]</a>"); 
		?>
	</td>
  </tr>
  <tr>
    <td height="1" bgcolor="#CCCCCC"></td>
  </tr>
<?php
	$aux++;
// fecha while
}
?>
</table>
