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
	//recebe o codigo que veio por get
	$codigo = $_GET['hdcod'];
	$empresa = $_GET['btEmpresa'];
?>
<input type="hidden" name="CODIGO_DA_EMPRESA" value="<?php echo "$CODIGO_DA_EMPRESA"?>" />

	<table width="100%" bgcolor="#CCCCCC">
		<tr>
			<td align="center">Informe o motivo do canelamento da nota</td>
		</tr>
		<tr>
			<td align="center"><textarea name="txtMotivoCancelar" class="texto" rows="10" cols="40"></textarea></td>
		</tr>
		<tr>
			<td align="center">
				<input type="hidden" name="txtCodigo" value="<?php echo $codigo; ?>" />
				<input type="hidden" name="txtTipoCanc" <?php if($empresa){ echo "value=\"$CODIGO_DA_EMPRESA\"";}else{echo "value=\"pro\"";}?> />
				<input type="submit" name="btCancel" value="Cancelar Nota" class="botao" />
			</td>
		</tr>
	</table>
<!--contador-->