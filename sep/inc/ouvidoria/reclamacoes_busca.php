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


//SQL de filtragem de serviços
$sql_listaPendentes = mysql_query("
SELECT codigo, especificacao, datareclamacao, responsavel, tomador_cnpj
FROM reclamacoes
WHERE estado = 'pendente'
ORDER BY datareclamacao DESC
LIMIT 0,10");

?>
<table align="center" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td>
		
		
<!-- cabeçalho da pesquisa-----> 
<fieldset style="width:730px;"><legend>Dez Últimas Reclamações Pendentes</legend>      
<form name="frmListaReclamacoesPendentes" method="post" id="frmListaReclamacoesPendentes" >
	<input type="hidden" name="include" id="include" value="<?php echo $_POST['include'];?>">
	<input type="hidden" name="btEditar" id="btEditar">
	<input type="hidden" name="CODIGO" id="CODIGOlista">	
  <table width="730" border="0">
    <tr bgcolor="#999999">
      <td width="230" align="center">Especificação</td>
      <td width="150" align="center">Tomador</td>
      <td width="150" align="center">Data Reclamação</td>
      <td width="100" align="center">Responsável</td>
	  <td width="100" align="center">Ações</td>
    </tr>
  <?php
  // lista o resultado do sql
  while(list($codigo, $especificacao, $datareclamacao, $responsavel, $tomador_cnpj) = mysql_fetch_array($sql_listaPendentes)) {
  ?>
    <tr bgcolor="#FFFFFF" height="35">
      <td align="center"><?php echo $especificacao; ?></td>
      <td align="center"><?php echo $tomador_cnpj; ?></td>
      <td align="center"><?php echo substr($datareclamacao,8,2)."/".substr($datareclamacao,5,2)."/".substr($datareclamacao,2,2); ?></td>
      <td align="center"><?php echo $responsavel; ?></td>
      <td align="center"><a style="cursor:pointer" onclick="document.getElementById('btEditar').value='R';document.getElementById('CODIGOlista').value='<?php echo $codigo;?>';document.getElementById('frmListaReclamacoesPendentes').submit();" ><img src="img/botoes/botao_editar.jpg" /></a></td>
    </tr>
	<?php
	} // fecha while
	?>
  </table>
</form>
</fieldset> 
<?php


//SQL de filtragem de reclamacoes atendidas
$sql_listaAtendidas = mysql_query("
SELECT codigo, especificacao, dataatendimento, responsavel, tomador_cnpj
FROM reclamacoes
WHERE estado = 'atendida'
ORDER BY datareclamacao DESC
LIMIT 0,10");

?>
 
<!-- cabeçalho da pesquisa-----> 
<fieldset style="width:730px;"><legend>Dez Últimas Reclamações Atendidas</legend>      
<form name="frmListaReclamacoesAtendidas" method="post" id="frmListaReclamacoesAtendidas">
	<input type="hidden" name="include" id="include" value="<?php echo $_POST['include'];?>">
	<input type="hidden" name="btEditar" id="btEditar">
	<input type="hidden" name="CODIGO" id="CODIGObusca">	
  <table width="730" border="0">
    <tr bgcolor="#999999">
      <td width="230" align="center">Especificação</td>
      <td width="150" align="center">Tomador</td>
      <td width="150" align="center">Data Atendimento</td>
      <td width="100" align="center">Responsável</td>
	  <td width="100" align="center">Ações</td>
    </tr>
  <?php
  // lista o resultado do sql
  while(list($codigo, $especificacao, $dataatendimento, $responsavel, $tomador_cnpj) = mysql_fetch_array($sql_listaAtendidas)) {
  ?>
    <tr bgcolor="#FFFFFF" height="35">
      <td align="center"><?php echo $especificacao; ?></td>
      <td align="center"><?php echo $tomador_cnpj; ?></td>
      <td align="center"><?php echo substr($dataatendimento,8,2)."/".substr($dataatendimento,5,2)."/".substr($dataatendimento,2,2); ?></td>
      <td align="center"><?php echo $responsavel; ?></td>
      <td align="center"><a style="cursor:pointer" onclick="document.getElementById('btEditar').value='R';document.getElementById('CODIGObusca').value='<?php echo $codigo;?>';document.getElementById('frmListaReclamacoesAtendidas').submit();" ><img src="img/botoes/botao_editar.jpg" /></a></td>
    </tr>
	<?php
	} // fecha while
	?>
  </table>
</form>
</fieldset> <br />


		</td>
	</tr>
</table>