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
	if($_POST["btDefinir"] == "Definir"){
		for($cMenu=0;$cMenu<$_POST['hdCont']; $cMenu++){
			$ordMenu = $_POST['cmbOrdMenu'.$cMenu];
			$codMenu = $_POST['hdCodMenu'.$cMenu];
			$sql_menu = mysql_query("UPDATE menus_prefeitura SET ordem = '$ordMenu' WHERE codigo='$codMenu'");
			
		}
		for($i=0; $i<$_POST['x']; $i++){
			$ord  = $_POST['cmbOrdem'.$i];
			$codigo = $_POST['txtCodigo'.$i];
			$sql_submenu = mysql_query("UPDATE menus_prefeitura_submenus SET ordem = '$ord' WHERE codigo='$codigo'");
		}
		add_logs('Atualizou a Ordem dos Menus');
		echo "<script>alert('Ordem dos menus alterada!');</script>";
	}
?>
<fieldset><legend>Defina a ordem em que os menus irão aparecer</legend>
<?php
$sql = mysql_query("
	SELECT 
		m.codigo, 
		m.menu,
		m.ordem,
		COUNT(s.codigo) AS submenus
	FROM 
		menus_prefeitura m
	INNER JOIN
		menus_prefeitura_submenus s ON m.codigo = s.codmenu
	WHERE 
		menu <> 'Sair' AND 
		menu <> 'Ajuda' AND
		nfe = 'S'
	GROUP BY
		m.codigo
	ORDER BY 
		ordem
");
?>

<form method="post" name="frmMenus" id="frmMenus">
	<input type="hidden" name="include" id="include" value="<?php echo $_POST["include"];?>" />
	<input type="hidden" name="btOrdem" value="<?php echo $_POST["btOrdem"];?>">
	<table width="100%">
	<?php
	$cont = 0;
	$linhas = mysql_num_rows($sql);
	while(list($codigo,$menu,$nivel,$ordem)=mysql_fetch_array($sql)){
	?>
		<tr id="conteudo<?php echo $cont?>">
			<td>
				<input type="hidden" name="hdCodMenu<?php echo $cont; ?>" value="<?php echo $codigo;?>" />
				<select name="cmbOrdMenu<?php echo $cont; ?>">
				<?php 
				for($c=1;$c<=$linhas;$c++){
					if($c==$cont+1)
						echo "<option selected=selected>$c</option>";
					else
						echo "<option>$c</option>";
				}
				?>
				</select>
			</td>
			<td width="15%" align="left">
				<b><?php echo $menu;?></b>
			</td>
			<td width="85%" align="left">
				<input name="btVer" id="btDescer" type="button" class="botao" value=" " 
				onclick="NovaLinha(this,'tdMenus<?php echo $cont;?>','inc/utilitarios/menus_submenus.ajax.php?hdcod=<?php echo $codigo;?>');" />
			</td>
		</tr>
		<tr id="conteudoTd<?php echo $cont;?>">
			<td id="tdMenus<?php echo $cont;?>" colspan="3" bgcolor="#999999"></td>
		</tr>
		<?php
		$cont++;
	}
	?>
		<tr>
			<td colspan="3" align="left">
				<input type="hidden" name="hdCont" value="<?php echo $cont; ?>" />
				<input type="submit" name="btDefinir" value="Definir" class="botao" />
			</td>
		</tr>
	</table>
</form>
</fieldset>
<br />