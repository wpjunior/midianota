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
//verifica se ousuario logou com cnpj ou com cpf
$cnpjcpf = $_SESSION['login'];
$campo   = tipoPessoa($cnpjcpf);

$sql = mysql_query("SELECT $campo FROM cadastro WHERE codigo = '$CODIGO_DA_EMPRESA'");
list($prestador_cnpjcpf) = mysql_fetch_array($sql);
//SQL de filtragem de serviços
$sql_listaPendentes = mysql_query("SELECT codigo, especificacao, datareclamacao, responsavel, tomador_cnpj FROM reclamacoes WHERE estado = 'pendente' AND emissor_cnpjcpf = '$prestador_cnpjcpf' ORDER BY datareclamacao DESC LIMIT 0,10");

?>
 
<!-- cabeçalho da pesquisa --> 
<?php
if(mysql_num_rows($sql_listaPendentes)>0){
?>   
<form name="frmListaReclamacoesPendentes" method="post" action="reclamacoes.php">
<table border="0" align="center" cellpadding="0" cellspacing="1">
    <tr>
      <td width="10" height="10" bgcolor="#FFFFFF"></td>
	  <td width="170" align="center" bgcolor="#FFFFFF" rowspan="3">10 últimas pendentes</td>
      <td width="400" bgcolor="#FFFFFF"></td>
	</tr>
	<tr>
	  <td height="1" bgcolor="#CCCCCC"></td>
      <td bgcolor="#CCCCCC"></td>
	</tr>
	<tr>
	  <td height="10" bgcolor="#FFFFFF"></td>
      <td bgcolor="#FFFFFF"></td>
	</tr>
	<tr>
		<td colspan="3" height="1" bgcolor="#CCCCCC"></td>
	</tr>
	<tr>
		<td height="60" colspan="3" bgcolor="#CCCCCC">
        
        
    <table width="100%" border="0" cellspacing="2" cellpadding="2">
    <tr>
      <td width="30%">Especificação</td>
      <td width="40%">Tomador</td>
      <td width="5%">Dta Recl</td>
      <td width="20%">Responsável</td>
      <td width="5%"></td>
    </tr>
    <tr>
      <td colspan="5" height="1" bgcolor="#999999"></td>
    </tr>
    <?php
    // lista o resultado do sql
    while(list($codigo, $especificacao, $datareclamacao, $responsavel, $tomador_cnpj) = mysql_fetch_array($sql_listaPendentes)) {
    ?>
    <tr>
      <td bgcolor="#FFFFFF"><?php echo $especificacao; ?></td>
      <td bgcolor="#FFFFFF"><?php echo $tomador_cnpj; ?></td>
      <td bgcolor="#FFFFFF"><?php echo substr($datareclamacao,8,2)."/".substr($datareclamacao,5,2)."/".substr($datareclamacao,2,2); ?></td>
      <td bgcolor="#FFFFFF"><?php echo $responsavel; ?></td>
      <td><input type="button" class="botao" name="btDetalhes" value="Detalhes" onClick="window.location='reclamacoes.php?btDetalhes=Detalhes&y=<?php echo $codigo; ?>'" /></td>
    </tr>
    <?php
        if(($btDetalhes=="Detalhes")&&($codigo==$y))
            {
                echo "<tr><td colspan=\"5\">";
                include("inc/reclamacoes_detalhes.php");
                echo "</td></tr>";
            }
    ?>
    <tr>
      <td colspan="5" height="1" bgcolor="#999999"></td>
    </tr>
    <?php
    } // fecha while
    ?>
    </table>
    

		</td>
	</tr>
	<tr>
    	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
	</tr>
</table>      
</form>
<?php
}else{
	echo "<center>Não há reclamações pendentes</center>";
}
?>
<?php


//SQL de filtragem de reclamacoes atendidas
$sql_listaAtendidas = mysql_query("
SELECT codigo, especificacao, dataatendimento, responsavel, tomador_cnpj
FROM reclamacoes
WHERE estado = 'atendida' AND emissor_cnpjcpf = '$prestador_cnpjcpf'
ORDER BY datareclamacao DESC
LIMIT 0,10");

?>
 
<!-- cabeçalho da pesquisa --> 
<?php
if(mysql_num_rows($sql_listaAtendidas)>0){
?>
<form name="frmListaReclamacoesAtendidas" method="post" action="reclamacoes.php">
<table border="0" align="center" cellpadding="0" cellspacing="1">
    <tr>
      <td width="10" height="10" bgcolor="#FFFFFF"></td>
	  <td width="170" align="center" bgcolor="#FFFFFF" rowspan="3">10 últimas atendidas</td>
      <td width="400" bgcolor="#FFFFFF"></td>
	</tr>
	<tr>
	  <td height="1" bgcolor="#CCCCCC"></td>
      <td bgcolor="#CCCCCC"></td>
	</tr>
	<tr>
	  <td height="10" bgcolor="#FFFFFF"></td>
      <td bgcolor="#FFFFFF"></td>
	</tr>
	<tr>
		<td colspan="3" height="1" bgcolor="#CCCCCC"></td>
	</tr>
	<tr>
		<td height="60" colspan="3" bgcolor="#CCCCCC">
  <table width="99%" border="0" cellspacing="2" cellpadding="2">
    <tr>
      <td width="30%">Especificação</td>
      <td width="40%">Tomador</td>
      <td width="5%">Dta Atend</td>
      <td width="20%">Responsável</td>
      <td width="5%"></td>
    </tr>
    <tr>
      <td colspan="5" height="1" bgcolor="#999999"></td>
    </tr>
  <?php
  // lista o resultado do sql
  while(list($codigo, $especificacao, $dataatendimento, $responsavel, $tomador_cnpj) = mysql_fetch_array($sql_listaAtendidas)) {
  ?>
    <tr>
      <td bgcolor="#FFFFFF"><?php echo $especificacao; ?></td>
      <td bgcolor="#FFFFFF"><?php echo $tomador_cnpj; ?></td>
      <td bgcolor="#FFFFFF"><?php echo substr($dataatendimento,8,2)."/".substr($dataatendimento,5,2)."/".substr($dataatendimento,2,2); ?></td>
      <td bgcolor="#FFFFFF"><?php echo $responsavel; ?></td>
      <td><input type="button" class="botao" name="btDetalhes" value="Detalhes" onClick="window.location='reclamacoes.php?btDetalhes=Detalhes&y=<?php echo $codigo; ?>'" /></td>
    </tr>
	<?php
		if(($btDetalhes=="Detalhes")&&($codigo==$y))
			{
				echo "<tr><td colspan=\"5\">";
				include("inc/reclamacoes_detalhes.php");
				echo "</td></tr>";
			}
	?>
    <tr>
      <td colspan="5" height="1" bgcolor="#999999"></td>
    </tr>
	<?php
	} // fecha while
	?>
  </table>
		</td>
	</tr>
	<tr>
    	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
	</tr>
</table>     
</form>
<?php
}else{
	echo "<center>Não há reclamações atendidas</center>";
}
?>
