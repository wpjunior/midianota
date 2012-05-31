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
$especificacao = $_POST['cmbEspecificacao']; 
$prestador_cnpj = $_POST['txtPrestadorCNPJ']; 
$tomador_cnpj = $_POST['txtTomadorCNPJ'];
$rps_numero = $_POST['txtRPSNumero'];
$rps_data = $_POST['txtRPSData'];
$rps_data = implode("-",array_reverse(explode("/", $rps_data))); echo $rps_data;
$rps_valor = $_POST['txtRPSValor'];
$estado = $_POST['rgEstado'];
$rps_valor = str_replace(",",".",$rps_valor); //Troca a virgula posta pela função javascript por um ponto para que se possa fazer a pesquisa no banco


//SQL de filtragem de reclamacoes
$sql = mysql_query("
SELECT codigo, especificacao, tomador_cnpj, datareclamacao, responsavel
FROM reclamacoes
WHERE
  `reclamacoes`.`especificacao` like '%$especificacao%' AND
  `reclamacoes`.`emissor_cnpjcpf` like '$prestador_cnpj%' AND   
  `reclamacoes`.`rps_numero` like '$rps_numero%' AND
  `reclamacoes`.`rps_data` like '$rps_data%' AND
  `reclamacoes`.`rps_valor` like '$rps_valor%' AND
  `reclamacoes`.`estado` like '$estado%' AND
  `reclamacoes`.`tomador_cnpj` like '$tomador_cnpj%'
");

?>
<table align="center" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td>
		
 
<fieldset style="width:730px;"><legend>Resultado da Pesquisa</legend>      
<form name="frmResultadoPesquisa" id="frmResultadoPesquisa" method="post">
	<input type="hidden" name="include" id="include" value="<?php echo $_POST['include'];?>">
	<input type="hidden" name="btEditar" id="btEditar">
	<input type="hidden" name="CODIGO" id="CODIGOresult">	
  <table width="100%" border="0" cellspacing="2" cellpadding="2">
    <tr bgcolor="#999999">
      <td width="230" align="center">Especificação</td>
      <td width="150" align="center">Tomador</td>
      <td width="150" align="center">Data Reclamação</td>
      <td width="100" align="center">Responsável</td>
	  <td width="100" align="center">Ações</td>
    </tr>
  <?php
  // lista o resultado do sql
  while(list($codigo, $especificacao, $tomador_cnpj, $datareclamacao, $responsavel) = mysql_fetch_array($sql)) {
  ?>
    <tr bgcolor="#FFFFFF" height="35">
      <td align="center"><?php echo $especificacao; ?></td>
      <td align="center"><?php echo $tomador_cnpj; ?></td>
      <td align="center"><?php echo substr($datareclamacao,8,2)."/".substr($datareclamacao,5,2)."/".substr($datareclamacao,2,2); ?></td>
      <td align="center"><?php echo $responsavel; ?></td>
      <td align="center"><a style="cursor:pointer" onclick="document.getElementById('btEditar').value='R';document.getElementById('CODIGOresult').value='<?php echo $codigo;?>';document.getElementById('frmResultadoPesquisa').submit();" ><img src="img/botoes/botao_editar.jpg" /></a></td>
    </tr>
	<?php
	} // fecha while
	?>
  </table>
</form>
</fieldset> 


		</td>
	</tr>
</table>