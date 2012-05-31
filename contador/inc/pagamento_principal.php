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
	require_once("../funcoes/util.php");
    $login=$_SESSION['login']; //$publicarBtn = array("s" => "Não Publicar", "n" => "Publicar");
	
	?>    
	<form method="post">
    	<table align="center">
			<tr>
				<td><input type="submit" class="botao" name="btOp" value="Gerar Guia"></td>
				<td><input type="submit" name="btOp" class="botao" value="Guias Emitidas"></td>
			</tr>
		</table>		
	</form>
	
	
 	<?php
	if($_POST['btOp'] == "Gerar Guia")
	{
	  include("pagamento_nota.php");
	}
	
	elseif($_POST['btOp'] == "Guias Emitidas")
	{
	  include("pagamento_emitidas.php");
	
	}
	
	
	//codigo para impressao do boleto
    if($btEnviaBoleto =="Boleto")
    {
      include("pagamento_boleto.php");
    } 

	?>