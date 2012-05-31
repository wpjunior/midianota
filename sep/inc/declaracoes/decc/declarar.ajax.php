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
	include("../../conect.php");
	include("../../../funcoes/util.php");
	
	$cnpj = $_GET['txtCNPJ'];
    
    $sql = mysql_query("SELECT codigo FROM cadastro WHERE cnpj = '$cnpj'");
    list($codigo)=mysql_fetch_array($sql);

    $anosql = $_GET['cmbAno'];
    $messql = $_GET['cmbMes'];
    if($messql < 10){
        $messql = "0".$messql;
    }
    $data = $anosql."-".$messql."-31";
    
echo "
    <select name=\"cmbObra\" id=\"cmbObra\" style=\"width:145px;\">

    	<option></option>";
    $sql = mysql_query("SELECT codigo, obra FROM obras WHERE codcadastro='$codigo' AND dataini <= '$data'");
    if(mysql_num_rows($sql)>0){
        while($dados_obra = mysql_fetch_array($sql)){
            echo "<option value=\"".$dados_obra['codigo']."\">".$dados_obra['obra']."</option>";
        }
    }
echo "</select>";
?>
    