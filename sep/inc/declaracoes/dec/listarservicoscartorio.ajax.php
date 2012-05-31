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
	/* Não gravar em cache */
	$gmtDate = gmdate("D, d M Y H:i:s");
	header("Expires: {$gmtDate} GMT");
	header("Last-Modified: {$gmtDate} GMT");
	header("Cache-Control: no-cache, must-revalidate");
	header("Pragma: no-cache");
	header("Content-Type: text/html; charset=iso-8859-1");
	
	include("../../conect.php");
	$c = $_GET['contador'];
	?> 
	<select style="width:275px;" id="cmbCodCart<?php echo $c;?>" name="cmbCodCart<?php echo $c;?>" onchange="var temp = this.value.split('|'); getElementById('txtAliquota<?php echo $c;?>').value = temp[0];CalculaImpostoDes(txtBaseCalculo<?php echo $c;?>,txtAliquota<?php echo $c;?>,txtImposto<?php echo $c;?>);">
		<option value="">Tipo de servi&ccedil;o</option> 
	<?php
	
	
	$sql_servicos = mysql_query("SELECT cartorios_servicos.codigo, cartorios_servicos.servicos, cartorios_servicos.aliquota FROM cartorios_servicos WHERE cartorios_servicos.codtipo ='".$_GET["codigo"]."'");
	if(mysql_num_rows($sql_servicos)){
		while(list($codigoserv, $servicos, $aliq_serv) = mysql_fetch_array($sql_servicos))
		{
			echo "<option value=\"$aliq_serv|$codigoserv\" id=\"$aliq_serv\" >$servicos</option>\n";
		}
		echo "</select>";
	}
	?>