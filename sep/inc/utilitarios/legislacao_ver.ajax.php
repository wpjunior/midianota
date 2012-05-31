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
<fieldset><legend>Leis</legend>
<?php
	// Conexao ao banco MySQL e consulta
	require_once("../conect.php");
	require_once("../../funcoes/util.php");

	$query = ("
		SELECT 
			codigo, 
			titulo, 
			texto, 
			data, 
			arquivo,
			tipo 
		FROM 
			legislacao 
		WHERE 
			tipo = 'N'
		ORDER BY 
			codigo DESC
	");
	$sql_leis = Paginacao($query,'frmLegislacao','divLegislacao',10);
	$result = mysql_num_rows($sql_leis);
	if($result>0){
?>
	<table width="100%">
		<tr bgcolor="#999999">
			<td width="32%" align="center">Titulo</td>
			<td width="11%" align="center">Data</td>
			<td width="30%" align="center">Texto</td>
			<!--<td width="19%" align="center">Tipo</td>-->
			<td width="19%" align="center">Arquivo</td>
			<td width="8%" align="center"></td>
		</tr>
		<?php
		while(list($codigo,$titulo,$texto,$data,$arquivo,$tipo) = mysql_fetch_array($sql_leis)){
			switch($tipo){
				case 'N': 
					$tipo = 'NFe';
					break;
				case 'I':
					$tipo = 'ISS';
					break;
				default:
					$tipo = 'Todos';
					break;
			}
			$textocurto = ResumeString($texto,29);
		?>
		<tr bgcolor="#FFFFFF">
			<td align="center"><?php echo $titulo;?></td>
			<td align="center"><?php echo DataPt($data);?></td>
			<td align="left" title="<?php echo $texto;?>"><?php echo $textocurto;?></td>
			<!--<td align="center"><?php /*echo $tipo;*/?></td>-->
			<td align="center">
            	<a href="legislacao/<?php echo $BANCO."/".$arquivo;?>" target="_blank"><img src="img/pdf.jpg" border="0" title="Clique para vizualizar o pdf" width="90" height="20" /></a>
            </td>
			<td align="center">
				<input name="btDeletar" type="submit" class="botao" value="Excluir" 
				onclick="document.getElementById('hdCodLei').value=<?php echo $codigo;?>;return Confirma('Deseja excluir esta lei?');" />
			</td>
		</tr>
		<?php
		}//fim while
		?>
		<input name="hdCodLei" type="hidden" id="hdCodLei" />
	</table>
</fieldset>
<?php
	}else{
		echo "<center><b>Não há nenhuma lei cadastrada</b></center>";
	}
?>
