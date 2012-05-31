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
<fieldset>
<?php
	include("../../conect.php");
	include("../../../funcoes/util.php");
	
	$query = ("SELECT codigo, dias, multa, juros_mora, estado FROM des_multas_atraso");
	$sql_lista = Paginacao($query,'formMultas','divMultasLista',10);
	if(mysql_num_rows($sql_lista)){
?>
<table width="100%">
	<tr bgcolor="#999999">
		<td width="10%" align="center">Dias</td>
		<td width="30%" align="center">Multa</td>
		<td width="30%" align="center">Juros de mora(%)</td>
		<td width="16%" align="center">Estado</td>
		<td width="14%" align="center"></td>
	</tr>
	<?php
	$x = 0;
	while(list($codigo,$dias,$multa,$juros,$estado) = mysql_fetch_array($sql_lista)){
		switch($estado){
			case "A": $estado_str = "Ativo";   break;
			case "I": $estado_str = "Inativo"; break;
		}
		
		if($estado == "A"){
			$color = "#FFFFFF";
		}else{
			$color = "#FFAC84";
		}
	?>
	<tr bgcolor="<?php echo $color;?>">
		<td align="center"><?php echo $dias;?></td>
		<td align="center"><?php echo DecToMoeda($multa);?></td>
		<td align="center"><?php echo $juros;?></td>
		<td align="center"><?php echo $estado_str;?></td>
		<td bgcolor="#FFFFFF" align="left">
			<input name="btEditar" id="btEdit" value="" class="botao" type="button" 
			onclick="VisualizarNovaLinha('<?php echo $codigo;?>','tdMulta<?php echo $x;?>',this,'inc/utilitarios/regras/regras_visualizar.ajax.php');" title="Editar" /> 
			<input name="btExcluir" id="btX" value=" " class="botao" type="submit" 
			onclick="document.getElementById('hdCodMulta').value = <?php echo $codigo;?>;return confirm('Deseja excluir esta regra?')" title="Excluir" /> 
		</td>
	</tr>
    <tr>
        <td id="<?php echo"tdMulta".$x; ?>" colspan="7" align="center"></td>
    </tr>
	<?php
		$x++;
	}
	?>
	<input type="hidden" name="hdCodMulta" id="hdCodMulta">
</table>
<?php
	}else{
		echo "<center><b>Não há regras cadastradas!</b></center>";
	}
?>
</fieldset>