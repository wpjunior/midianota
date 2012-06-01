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
  
  // arquivo de conexão com o banco
  include("../include/conect.php"); 
  
  // arquivo com funcoes uteis
  include("../funcoes/util.php");
  //print("<a href=index.php target=_parent><img src=../img/topos/$TOPO></a>");
  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>e-Nota</title>

<script src="../scripts/java_site.js" language="javascript" type="text/javascript"></script>

<script type="text/javascript" src="../scripts/lightbox/prototype.js"></script>
<script type="text/javascript" src="../scripts/lightbox/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="../scripts/lightbox/lightbox.js"></script>
<link rel="stylesheet" href="../css/lightbox.css" type="text/css" media="screen" />

<link href="../css/padrao_site.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
#apDiv1 {
	position:absolute;
	left:40%;
	top:45%;
	width:400px;
	height:160px;
	z-index:1;
	background-image: url(../img/index/indicativos.jpg);
}
.style1 {
	font-size: 12pt;
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<div id="apDiv1" style="visibility:hidden" onclick="javascript:changeProp('apDiv1','','visibility','hidden','DIV')"><br />
  <br />
  <br />
  <br />
  <br />
  <br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php
$sql = mysql_query("SELECT COUNT(codigo) FROM emissores WHERE estado = 'A'");
list($empresas_ativas) = mysql_fetch_array($sql);
echo "<font color=#FF0000 size=4><strong>$empresas_ativas</strong></font>";
	
?>
<br />
<br />
<br />

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php
$sql = mysql_query("SELECT COUNT(codigo) FROM notas");
list($notas_emitidas) = mysql_fetch_array($sql);
echo "<font color=#FF0000 size=4><strong>$notas_emitidas</strong></font>";
	
	?>
</div>
<table width="760" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><?php include("inc/topo.php"); ?></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" valign="top" align="center">
	
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="170" rowspan="2" align="left" valign="top" background="../img/menus/menu_fundo.jpg"><?php include("inc/menu.php"); ?></td>
    <td align="right" valign="top" width="590"><img src="../img/cabecalhos/beneficios.jpg" width="590" height="100" /></td>
  </tr>
  <tr>
    <td align="center" valign="top">
    
    
<table border="0" cellspacing="5" cellpadding="0">
  <tr>
    <td width="190" align="center" valign="top">
    <!-- quadro da esquerda acima -->
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="3" bgcolor="#CCCCCC"></td>
      </tr>
      <tr>
        <td height="10" bgcolor="#999999"></td>
      </tr>
      <tr>
        <td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Prestador Emissor</font><br />
          <br />          
          Clique e veja os benef&iacute;cios da NFeletr&ocirc;nica de ISS.<br />
          <br />
          <div align="center"><a href="../img/beneficios/emissor_txt.jpg" rel="lightbox[roadtrip]"><img src="../img/beneficios/emissor.jpg" width="170" height="50" /></a></div>          </td>
      </tr>
      <tr>
        <td height="1"></td>
      </tr>
      <tr>
        <td height="5" align="left" bgcolor="#859CAD"></td>
      </tr>
    </table>    </td>
    <td width="190" align="center" valign="top">
	
	<!-- Quadro do meio acima -->

    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="3" bgcolor="#CCCCCC"></td>
      </tr>
      <tr>
        <td height="10" bgcolor="#999999"></td>
      </tr>
      <tr>
        <td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Tomador de Servi&ccedil;os</font><br />
          <br />
          Veja o v&iacute;deo da campanha da NFeletr&ocirc;nica de ISS.<br />
          <br />
          <div align="center"><a href="../img/beneficios/tomador_txt.jpg" rel="lightbox[roadtrip]"><img src="../img/beneficios/tomador.jpg" alt="" width="170" height="50" /></a></div></td>
      </tr>
      <tr>
        <td height="1"></td>
      </tr>
      <tr>
        <td height="5" align="left" bgcolor="#859CAD"></td>
      </tr>
    </table>    </td>
    <td width="190" align="center" valign="top">
	
	<!-- quadro direita acima -->
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="3" bgcolor="#CCCCCC"></td>
      </tr>
      <tr>
        <td height="10" bgcolor="#999999"></td>
      </tr>
      <tr>
        <td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo"> Prefeitura Municipal</font>
          <br />
          <br />
          Acesse e compare os n&uacute;meros de aprova&ccedil;&atilde;o da NFe de ISS.<br />
          <br />
          <div align="center"><a href="../img/beneficios/prefeitura_txt.jpg" rel="lightbox[roadtrip]"><img src="../img/beneficios/prefeitura.jpg" /></a></div></td>
      </tr>
      <tr>
        <td height="1"></td>
      </tr>
      <tr>
        <td height="5" align="left" bgcolor="#859CAD"></td>
      </tr>
    </table>	</td>
  </tr>   
    </table>    
    
    
    
    
    
    
    
    </td>
  </tr>
</table>



	</td>
  </tr>
</table>
<?php include("inc/rodape.php"); ?>

</body>
</html>
