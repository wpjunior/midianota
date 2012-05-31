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
require_once dirname(__FILE__).'/../../include/config.php';

// Conectar ao banco de dados das prefeituras
$conectar_pref = mysql_connect($HOST,$USUARIO, $SENHA); 
if (!$conectar_pref) { die('Não foi possível conectar: ' . mysql_error()); } 

// Seleciona o banco de dados
$db_selected_pref = mysql_select_db($BANCO, $conectar_pref);
if (!$db_selected_pref) {die ('Não foi possível acessar a base: ' . mysql_error());}
//if($dadospref!="true"){mysql_close($conectar);}

//SELECIONA O CODIGO DA EMPRESA

 if($_SESSION['login'] != "")
 {
  $NOME = $_SESSION['nome'];
  $sql_codigo_empresa = mysql_query("SELECT codigo, ultimanota,municipio,uf,logradouro,numero FROM cadastro WHERE nome = '$NOME'");
  list($CODIGO_DA_EMPRESA,$ULTIMA_NOTA,$MUNICIPIO_DA_EMPRESA,$ESTADO_DA_EMPRESA,$ENDERECO_DA_EMPRESA,$NUMERO_DA_EMPRESA) = mysql_fetch_array($sql_codigo_empresa);
  
  $sql_dadosprefeitura = mysql_query("SELECT cidade, estado, cnpj, endereco, topo_nfe, brasao_nfe, secretaria FROM configuracoes");
  list($NOME_MUNICIPIO,$UF_MUNICIPIO,$CNPJ_MUNICIPIO,$ENDERECO_DA_PREFEITURA,$TOPO,$BRASAO,$SECRETARIA)=mysql_fetch_array($sql_dadosprefeitura);
  
  //serve para manter o a compatibilidade com lugar que usam o nome antigo para as variaveis do conect.php
  $PREFEITURA = $MUNICIPIO = $CONF_MUNICIPIO = $NOME_MUNICIPIO;
 }


?>
