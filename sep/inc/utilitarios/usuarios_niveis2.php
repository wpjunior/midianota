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
	if($_POST["btDefinir"] == "Definir")
		{
			for($i=0; $i<=$x; $i++)
				{
					$baixo  = $_POST['baixo'.$i];
					$medio  = $_POST['medio'.$i];
					$codigo = $_POST['txtCodigo'.$i];
					if($baixo != ""){$valor = "B";}
					elseif(($baixo == "") && ($medio != "")){$valor = "M";}
					elseif(($baixo == "")&&($medio == "")){$valor = "A";}
					$sql = mysql_query("UPDATE menus_prefeitura SET nivel='$valor' WHERE codigo='$codigo'");
				}
			add_logs('Atualizou o Nível de Usuários');
			echo "<script>alert('Dados alterados com sucesso');</script>";
		}
?>
<fieldset><legend>Defina as opções do menu para cada nível de usuário</legend>
	<p align="center">Os usários com nível de permissão Alto tem acesso a todos os menus </p>
	<?php
		$sql = mysql_query("SELECT codigo, menu, nivel FROM menus_prefeitura WHERE menu<>'Sair' AND menu<>'Manuais de Ajuda' ORDER BY ordem");
		$x=0;
		?>
		<form method="post">
			<input type="hidden" name="include" id="include" value="<?php echo $_POST["include"];?>" />
			<input type="hidden" name="btNivel" value="<?php echo $_POST["btNivel"];?>">
			<table width="100%">
		<?php
		while(list($codigo,$menu,$nivel)=mysql_fetch_array($sql))
			{
				echo "
					<tr>
						<td align=\"left\">$menu</td>
						<td align=\"left\">
							<input type=\"checkbox\" id=\"medio$x\" name=\"medio$x\" value=\"M\" />Médio
							<input type=\"hidden\" name=\"txtCodigo$x\" value=\"$codigo\" />
						</td>
						<td align=\"left\">
							<input type=\"checkbox\" name=\"baixo$x\" id=\"baixo$x\" value=\"B\" onclick=\"MarcaNivel($x)\" />Baixo
						</td>
					</tr>
				";
				if($nivel == "B"){echo "<script>MarcaCheckboxBaixo($x)</script>";}
				elseif($nivel == "M"){echo "<script>MarcaCheckboxMedio($x)</script>";}
				$x++;	
			}
	?>
				<tr>
					<td colspan="3" align="left">
						<input type="hidden" name="x" value="<?php echo $x; ?>" />
						<input type="submit" name="btDefinir" value="Definir" class="botao" />
					</td>
				</tr>
			</table>
		</form>
</fieldset>			
