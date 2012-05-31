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
	include("conect.php");
	include("../funcoes/util.php");
	
	$cnpj    = $_GET['txtCNPJ'];
	$tipo    = $_GET['tipo'];
	$tipodeclaracao = $_GET['codtipodec'];
	$codtipo = codtipo($tipo);
	$tipodec = codtipodeclaracao($tipodeclaracao);
	
	if($tipodec){
		$string = " AND codtipodeclaracao = '$tipodec'";
	}
	
	$sql_infos = mysql_query("
		SELECT 
			codigo, 
			razaosocial, 
			logradouro, 
			municipio, 
			uf
		FROM 
			cadastro 
		WHERE 
			(cnpj = '$cnpj' OR cpf = '$cnpj') AND 
			codtipo = '$codtipo' $string
	");
	list($codigo,$razaosocial,$endereco,$municipio,$uf) = mysql_fetch_array($sql_infos);
	
	if(mysql_num_rows($sql_infos) > 0){
?>
<table width="100%">
	<tr>
		<td width="17%" align="left" valign="middle">Raz&atilde;o Social:</td>
		<td width="83%" align="left" valign="middle"><b><?php echo $razaosocial;?></b></td>
	</tr>
	<tr>
		<td align="left" valign="middle">Endere&ccedil;o:</td>
		<td align="left" valign="middle"><b><?php echo "$endereco - $municipio - $uf";?></b></td>
	</tr>
</table>
<?php
	//Verifica qual o tipo que foi passado por parametro
	switch($tipo){
		case "cartorio":      $pasta = "dec";  break;
		case "empreiteira":   $pasta = "decc"; break;
		case "orgao_publico": $pasta = "dop";  break;
		case "prestador":
			if($tipodec == ''){
				$pasta = "des";
			}else if($tipodeclaracao == "mei"){
				$pasta = "mei";
			}else{
				$pasta = "simples";
			}
		  break;
	}
	
	
		

	
	//Da include do arquivo para a insercao de nota
	include("declaracoes/$pasta/declarar_inserir.ajax.php");
	}else{
		
		switch($tipo){
			case "cartorio":      $nometipo = "ou não é um cartório";      break;
			case "empreiteira":   $nometipo = "ou não é uma empreiteira";  break;
			case "orgao_publico": $nometipo = "ou não é um orgão publico"; break;
			case "prestador":
				if($tipodec == ""){
					$nometipo = "ou não é um prestador";
				}else if($tipodeclaracao == "mei"){
					$nometipo = "ou não é um prestador MEI";
				}else{
					$nometipo = "ou não é um prestador simples nacional";
				}          
			  break;
		}
	?>
		<table width="100%">
			<tr>
				<td align="center"><b>Este cnpj/cpf não esta cadastrado <?php echo $nometipo;?>!</b></td>
			</tr>
			<tr>
				<td align="left"><input type="submit" name="btVoltar" class="botao" value="Voltar" /></td>
			</tr>
		</table>
		<?php
	}
?>
