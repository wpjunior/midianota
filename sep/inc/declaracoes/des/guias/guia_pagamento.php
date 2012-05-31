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
	include("../../../conect.php");
	include("../../../../funcoes/util.php");
	
	//recebe os dados
	$cnpj = $_GET["txtCNPJ"];
	
	//determina o emissor
	$codtipo = codtipo("prestador");
	$sql_login = mysql_query("SELECT codigo FROM cadastro WHERE cnpj = '$cnpj' AND codtipo = '$codtipo'");
	list($codemissor) = mysql_fetch_array($sql_login);
	
	if(mysql_num_rows($sql_login)){
		// carrega as regras de multa por ataso
		listaRegrasMultaDes();
?>
<input type="hidden" value="<?php echo $codemissor;?>" name="CODEMISSOR" id="CODEMISSOR" />
<p align="center">Escolha o período</p>
<table>
    <tr>
        <td>
    <?php
    //array de meses comencando em 1 ate 12
    $meses=array("1"=>"Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
    $mes = date("n");
    $ano = date("Y");						
    ?>
      <select name="cmbMes" id="_mes">
          <option value=""></option>
          <?php
          for($ind=1;$ind<=12;$ind++){
            echo "<option value='$ind'";if($ind == $mes){ echo "selected=\"selected\"";}echo ">{$meses[$ind]}</option>";
          }
          ?>
      </select>
      </td>
      <td>
      <select name="cmbAno" id="_ano">
          <option value=""> </option>
            <?php
                $year=date("Y");
                for($h=0; $h<5; $h++){
                    $y=$year-$h;
                    echo "<option value=\"$y\"";if($y == $ano){ echo "selected=\"selected\"";}echo ">$y</option>";
                }
            ?>
      </select>
        </td>
        <td><input type="button" class="botao" name="btBuscar" value="Buscar" onclick="return btBuscar_click('CODEMISSOR','divBuscarGuias')"/></td>
    </tr>
</table>
<div id="divBuscarGuias"></div>
<?php
	}else{
		echo "<b>Este cnpj não é um prestador ou não está cadastrado!</b>";
	}
?>