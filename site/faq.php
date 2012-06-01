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
.style2 {	font-size: 10pt;
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
    <td bgcolor="#FFFFFF" height="400" valign="top" align="center">
	
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="170" rowspan="2" align="left" valign="top" background="../img/menus/menu_fundo.jpg"><?php include("inc/menu.php"); ?></td>
    <td align="right" valign="top" width="590"><img src="../img/cabecalhos/faq.jpg" width="590" height="100" /></td>
  </tr>
  <tr>
    <td align="center" valign="top">
    
    
<table width="100%" border="0" cellpadding="0" cellspacing="5">
  <tr>
    <td align="center" valign="top">
    <!-- quadro da esquerda acima -->
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="3" bgcolor="#CCCCCC"></td>
      </tr>
      <tr>
        <td height="10" bgcolor="#999999"></td>
      </tr>
      <tr>
        <td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;">
        <table width="500" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td align="left" background="../img/index/index_comofunciona_fundo.jpg"><p><span class="style2">01 - CONCEITOS</span><br />
                    <br />
                    <a href="#101">1.01. O que &eacute; Nota Fiscal Eletr&ocirc;nica de Servi&ccedil;os (NF-e)?</a> <br />
                    <br />
                    <a href="#102">1.02. O que &eacute; Nota Fiscal Convencional?</a> <br />
                    <a href="#103"><br />
                      1.03. O que &eacute; Recibo Provis&oacute;rio de Servi&ccedil;os (RPS)? </a><br />
              <br />
              <span class="style2">02 - RECIBO PROVIS&Oacute;RIO DE SERVI&Ccedil;OS (RPS)</span><br />
              <br />
              <a href="#201">2.01. Como gerar o RPS?</a> <br />
              <a href="#202"><br />
                2.02. O RPS deve ser confeccionado por gr&aacute;fica credenciada pela Prefeitura?</a> <br />
              <br />
              <a href="#203">2.03. O RPS deve ter numera&ccedil;&atilde;o seq&uuml;encial espec&iacute;fica? <br />
                </a><br />
              <a href="#204">2.04. O que fazer com as notas fiscais convencionais j&aacute; confeccionadas?</a> <br />
              <br />
              <a href="#205">2.05. Em quantas vias deve-se emitir o RPS?</a> <br />
              <br />
              <a href="#202">2.06. &Eacute; necess&aacute;rio substituir o RPS ou a nota fiscal convencional por NF-e?</a> <br />
              <br />
              <a href="#207">2.07. Qual o prazo para substituir o RPS ou a nota fiscal convencional por NF-e?</a> <br />
              <br />
              <a href="#208">2.08. O que acontece no caso de n&atilde;o convers&atilde;o do RPS ou da nota fiscal convencional em NF-e?</a> <br />
              <br />
              <a href="#209">2.09. O que acontece no caso de convers&atilde;o fora do prazo do RPS ou da nota fiscal convencional em NF-e?</a> <br />
              <br />
              <a href="#210">2.10. &Eacute; permitido o uso de notas fiscais convencionais conjugadas (mercadorias e servi&ccedil;os) no lugar do RPS?</a> <br />
              <a href="#211"><br />
                2.11. &Eacute; permitido o uso de cupons fiscais no lugar do RPS?</a> <br />
              <br />
              <a href="#209">2.12. Qual o procedimento a ser adotado no caso de cancelamento de RPS antes da convers&atilde;o em NF-e?<br />
                </a><a href="#212"><br />
                  2.13. Como proceder no caso do prestador n&atilde;o converter o RPS em NF-e?</a> <br />
              <br />
              <span class="style2">03 - OBRIGATORIEDADE DE EMISS&Atilde;O DE NF-e</span><br />
              <br />
              <a href="#301">3.01. Quem est&aacute; obrigado &agrave; emiss&atilde;o da NF-e?</a> <br />
              <br />
              <a href="#302">3.02. A partir de quando a emiss&atilde;o de NF-e &eacute; obrigat&oacute;ria?</a> <br />
              <br />
              <a href="#303">3.03. Como devo apurar meu faturamento para saber se devo emitir a NF-e?</a> <br />
              <br />
              <a href="#304">3.04. Quem iniciou a atividade de presta&ccedil;&atilde;o de servi&ccedil;os durante um determinado exerc&iacute;cio (a partir de 2008) est&aacute; obrigado &agrave; emiss&atilde;o de NF-e no exerc&iacute;cio seguinte?</a> <br />
              <br />
              <a href="#303">3.05. Como fica a obrigatoriedade de emiss&atilde;o de NF-e, considerando a data de in&iacute;cio de atividade de presta&ccedil;&atilde;o de servi&ccedil;o? </a><br />
              <br />
              <a href="#306">3.06. Se o prestador de servi&ccedil;os obrigado &agrave; emiss&atilde;o de NF-e auferir, em determinado exerc&iacute;cio, receita bruta de servi&ccedil;os inferior ao valor determinado, poder&aacute; voltar a emitir nota fiscal convencional? </a><br />
              <br />
              <a href="#307">3.07. O contribuinte enquadrado em mais de um c&oacute;digo de presta&ccedil;&atilde;o de servi&ccedil;os dever&aacute; emitir NF-e para todos os servi&ccedil;os?</a> <br />
              <br />
              <a href="#308">3.08. O contribuinte enquadrado em mais de um c&oacute;digo de presta&ccedil;&atilde;o de servi&ccedil;os dever&aacute; obedecer ao cronograma de emiss&atilde;o de NF-e para cada c&oacute;digo de servi&ccedil;o?</a> <br />
              <br />
              <a href="#309">3.09. Somente quem est&aacute; obrigado poder&aacute; emitir NF-e?</a> <br />
              <br />
              <a href="#310">3.10. A op&ccedil;&atilde;o pela emiss&atilde;o de NF-e depende de requerimento do interessado?</a> <br />
              <br />
              <a href="#311">3.11. A op&ccedil;&atilde;o pela emiss&atilde;o de NF-e, uma vez deferida, vigora a partir de quando?</a> <br />
              <br />
              <a href="#312">3.12. A partir de quando uma empresa rec&eacute;m-aberta, que opte pela utiliza&ccedil;&atilde;o de NF-e, pode emitir RPS ou utilizar NF-e?</a> <br />
              <br />
              <a href="#313">3.13. O prestador de servi&ccedil;os, desobrigado da emiss&atilde;o de NF-e, que optar pela NF-e, poder&aacute; voltar a emitir nota fiscal convencional?</a> <br />
              <br />
              <a href="#314">3.14. Uma vez deferida a autoriza&ccedil;&atilde;o para emiss&atilde;o de NF-e, qual o prazo para substituir as notas fiscais convencionais emitidas at&eacute; a data do deferimento da autoriza&ccedil;&atilde;o?</a> <br />
              <a href="#315"><br />
                3.15. As entidades imunes ao ISS est&atilde;o obrigadas &agrave; emiss&atilde;o da NF-e?</a> <br />
              <br />
              <a href="#316">3.16. As entidades isentas do ISS est&atilde;o obrigadas &agrave; emiss&atilde;o da NF-e?</a> <br />
              <br />
              <span class="style2">04 - BENEF&Iacute;CIOS</span><br />
              <br />
              <a href="#401">4.01. Quais os benef&iacute;cios para quem emite NF-e?</a> <br />
              <br />
              <a href="#402">4.02. Quais os benef&iacute;cios para quem recebe NF-e?</a> <br />
              <span class="style2"><br />
                05 - EMISS&Atilde;O, CANCELAMENTO E RETIFICA&Ccedil;&Atilde;O DE NF-e</span><br />
              <br />
              <a href="#501">5.01. Como deve ser emitida a NF-e?</a> <br />
              <br />
              <a href="#502">5.02. O que fazer em caso de eventual impedimento da emiss&atilde;o &ldquo;on line&rdquo; da NF-e? <br />
                </a><br />
              <a href="#503">5.03. &Eacute; obrigat&oacute;ria a emiss&atilde;o de NF-e &ldquo;on line&rdquo;? <br />
                </a><br />
              <a href="#504">5.04. Em quantas vias deve-se imprimir a NF-e?</a> <br />
              <br />
              <a href="#505">5.05. Pode-se enviar a NF-e por e-mail para o tomador de servi&ccedil;os? </a><br />
              <br />
              <a href="#506">5.06. A NF-e poder&aacute; ser impressa em modelo diverso do estabelecido em regulamento?</a> <br />
              <br />
              <a href="#507">5.07. A NF-e ter&aacute; numera&ccedil;&atilde;o seq&uuml;encial espec&iacute;fica?</a> <br />
              <br />
              <a href="#508">5.08. At&eacute; quando &eacute; poss&iacute;vel consultar a NF-e, ap&oacute;s sua emiss&atilde;o? <br />
                </a><br />
              <a href="#509">5.09. Pode-se utilizar uma NF-e para registrar mais de um tipo de servi&ccedil;o prestado?</a> <br />
              <br />
              <a href="#510">5.10. Pode-se cancelar uma NF-e emitida? Em quais situa&ccedil;&otilde;es? <br />
                </a><br />
              <a href="#511">5.11. Ap&oacute;s a emiss&atilde;o da NF-e, pode-se alter&aacute;-la?</a> <br />
              <br />
              <a href="#512">5.12. A emiss&atilde;o de NF-e permite o registro de opera&ccedil;&otilde;es conjugadas (mercadorias e servi&ccedil;os)?</a> <br />
              <br />
              <a href="#513">5.13. A emiss&atilde;o de NF-e permite o registro dos dados referentes aos tributos federais? </a><br />
              <br />
              <a href="#514">5.14. Considerado o cronograma constante da Portaria SF n&ordm; 72/2006, quem estiver obrigado &agrave; utiliza&ccedil;&atilde;o de NF-e dever&aacute; requerer autoriza&ccedil;&atilde;o para sua emiss&atilde;o?</a> <br />
              <br />
              <a href="#515">5.15. Como obter a autoriza&ccedil;&atilde;o para emiss&atilde;o de NF-e?</a> <br />
              <br />
              <a href="#516">5.16. A NF-e poder&aacute; ser emitida englobando v&aacute;rios tipos de servi&ccedil;os?</a> <br />
              <br />
              <a href="#517">5.17. Como alterar a data de emiss&atilde;o da NF-e quando esta for emitida em data posterior a da presta&ccedil;&atilde;o dos servi&ccedil;os? </a><br />
              <br />
              <a href="#518">5.18. Como emitir NF-e para tomador de servi&ccedil;os (PJ) estabelecido em outro pa&iacute;s?</a> <br />
              <br />
              <a href="#519">5.19. Emiti uma NF-e com dados incorretos. Posso corrigi-la por meio de carta de corre&ccedil;&atilde;o?</a> <br />
              <br />
              <a href="#517">5.20. Onde pode ser inclu&iacute;do o campo de aceite dos servi&ccedil;os na NF-e?</a> <br />
              <br />
              <a href="#521">5.21. Acessei o sistema da NF-e, mas a op&ccedil;&atilde;o de solicita&ccedil;&atilde;o de autoriza&ccedil;&atilde;o para emiss&atilde;o de NF-e n&atilde;o est&aacute; dispon&iacute;vel? Como devo proceder? </a><br />
              <br />
              <a href="#522">5.22. Estou enquadrado no Simples Nacional, institu&iacute;do pela Lei Complementar n&ordm; 123/2006. Por que minhas NF-e n&atilde;o apresentam al&iacute;quota e valor do ISS? <br />
                </a><br />
              <a href="#523">5.23. Estou enquadrado em regime de tributa&ccedil;&atilde;o diferente do que consta no sistema da NF-e (Simples Nacional ou tributa&ccedil;&atilde;o normal), e quero corrigir a situa&ccedil;&atilde;o para as pr&oacute;ximas NF-e e para as existentes. O que devo fazer? </a><br />
              <br />
              <span class="style2">06 - EMISS&Atilde;O DE GUIA DE RECOLHIMENTO</span><br />
              <br />
              <a href="#601">6.01. Existe uma guia de recolhimento de ISS espec&iacute;fica para a NF-e?</a> <br />
              <br />
              <a href="#602">6.02. Quando a guia de recolhimento de ISS fica dispon&iacute;vel para emiss&atilde;o?</a> <br />
              <br />
              <a href="#603">6.03. Quem fica dispensado da emiss&atilde;o da guia de recolhimento pelo sistema da NF-e?</a> <br />
              <br />
              <a href="#604">6.04. Qual &eacute; a data de vencimento do ISS referente &agrave;s NF-e? <br />
                </a><br />
              <a href="#605">6.05. &Eacute; poss&iacute;vel emitir a guia de recolhimento ap&oacute;s o vencimento do ISS?</a> <br />
              <br />
              <a href="#606">6.06. &Eacute; poss&iacute;vel cancelar guia de recolhimento emitida? </a><br />
              <br />
              <a href="#607">6.07. Os contribuintes sujeitos ao regime de recolhimento do ISS por estimativa dever&atilde;o emitir a guia de recolhimento no aplicativo da NF-e? </a><br />
              <br />
              <a href="#608">6.08. Os contribuintes que possuem regime especial de recolhimento do ISS, individual ou coletivo, dever&atilde;o emitir a guia de recolhimento no aplicativo da NF-e?</a> <br />
              <br />
              <a href="#609">6.09. As microempresas estabelecidas no Munic&iacute;pio de S&atilde;o Paulo, n&atilde;o enquadradas no Simples Nacional, dever&atilde;o emitir a guia de recolhimento no aplicativo da NF-e? <br />
                </a><br />
              <a href="#610">6.10. As microempresas enquadradas no Simples Nacional dever&atilde;o emitir a guia de recolhimento no aplicativo da NF-e? </a><br />
              <br />
              <span class="style2">07 - GERA&Ccedil;&Atilde;O DE CR&Eacute;DITO</span><br />
              <br />
              <a href="#701">7.01. Quem far&aacute; jus ao cr&eacute;dito gerado pela NF-e?</a> <br />
              <br />
              <a href="#702">7.02. Quanto &eacute; gerado de cr&eacute;dito por NF-e?</a> <br />
              <br />
              <a href="#703">7.03. Como o tomador de servi&ccedil;os ser&aacute; informado sobre os cr&eacute;ditos gerados? </a><br />
              <br />
              <a href="#704">7.04. Quando o cr&eacute;dito fica dispon&iacute;vel para utiliza&ccedil;&atilde;o? <br />
                </a><br />
              <a href="#705">7.05. Quem n&atilde;o far&aacute; jus ao cr&eacute;dito gerado?</a> <br />
              <br />
              <a href="#706">7.06. Quais os procedimentos para se obter o cr&eacute;dito?</a> <br />
              <br />
              <a href="#707">7.07.  Emito Nota Fiscal Eletr&ocirc;nica (NF-e) e estou enquadrado no Simples Nacional. NF-e emitidas por mim dar&atilde;o ao tomador do servi&ccedil;o direito a cr&eacute;dito de parcela do ISS? </a><br />
              <br />
              <span class="style2">08 - UTILIZA&Ccedil;&Atilde;O DE CR&Eacute;DITO</span><br />
              <br />
              <a href="#801">8.01. Quando o tomador de servi&ccedil;os dever&aacute; indicar os im&oacute;veis que aproveitar&atilde;o os cr&eacute;ditos gerados?</a> <br />
              <br />
              <a href="#802">8.02. Pode-se indicar im&oacute;vel em nome de terceiros? <br />
                </a><br />
              <a href="#803">8.03. Pode-se indicar im&oacute;vel com d&eacute;bito de IPTU?</a> <br />
              <br />
              <a href="#804">8.04. Como o cr&eacute;dito gerado poder&aacute; ser utilizado?</a> <br />
              <a href="#805"><br />
                8.05. Como &eacute; calculado o valor do abatimento do IPTU?</a> <br />
              <a href="#806"><br />
                8.06. Ap&oacute;s a utiliza&ccedil;&atilde;o do cr&eacute;dito, como ser&aacute; pago o saldo do IPTU? </a><br />
              <br />
              <a href="#807">8.07. O que acontece no caso de n&atilde;o pagamento do saldo restante do IPTU?</a> <br />
              <br />
              <a href="#808">8.08. Qual &eacute; a validade dos cr&eacute;ditos?</a> <br />
              <br />
              <a href="#809">8.09. Quem n&atilde;o poder&aacute; utilizar o cr&eacute;dito gerado?</a> <br />
              <br />
              <a href="#810">8.10. O tomador de servi&ccedil;os que estiver com o seu nome inclu&iacute;do no Cadin Municipal perder&aacute; os cr&eacute;ditos gerados?</a> <br />
              <br />
              <span class="style2">09 - ASPECTOS GERAIS</span><br />
              <br />
              <a href="#901">9.01. Qual a garantia de que a NF-e recebida &eacute; aut&ecirc;ntica?</a> <br />
              <br />
              <a href="#902">9.02.  O programa da NF-e permite a importa&ccedil;&atilde;o de arquivo?</a> <br />
              <br />
              <a href="#903">9.03. O programa da NF-e permite a exporta&ccedil;&atilde;o de arquivo? <br />
                </a><br />
              <a href="#904">9.04. O prestador de servi&ccedil;os poder&aacute; cadastrar o contador para acessar o aplicativo NF-e? </a><br />
              <br />
              <a href="#905">9.05. O contador poder&aacute; acessar o aplicativo NF-e de seus clientes?</a> <br />
              <br />
              <span class="style2">10 - SISTEMA DA NF-e</span><br />
              <br />
              <a href="#1001">10.01. Quem ter&aacute; acesso ao sistema NF-e? <br />
                </a><br />
              <a href="#1002">10.02. O programa da NF-e permite a importa&ccedil;&atilde;o de arquivo? <br />
                </a><br />
              <a href="#1003">10.03. Quem n&atilde;o possui autoriza&ccedil;&atilde;o para emiss&atilde;o de NF-e poder&aacute; testar a valida&ccedil;&atilde;o do arquivo?</a> <br />
              <br />
              <a href="#1004">10.04. O programa da NF-e permite a exporta&ccedil;&atilde;o de arquivo?</a> <br />
              <br />
              <a href="#1005">10.05. Onde posso obter um documento contendo as instru&ccedil;&otilde;es e os layouts de importa&ccedil;&atilde;o e exporta&ccedil;&atilde;o de arquivos?</a> <br />
              <br />
              <a href="#1006">10.06. Existe um programa espec&iacute;fico para transmiss&atilde;o do arquivo?</a> <br />
              <br />
              <a href="#1007">10.07. Ap&oacute;s a transmiss&atilde;o do arquivo ser&aacute; gerado algum relat&oacute;rio?</a> <br />
              <br />
              <a href="#1008">10.08. Ap&oacute;s a transmiss&atilde;o do arquivo ser&aacute; disponibilizado algum arquivo de retorno? Neste arquivo posso obter os n&uacute;meros das NF-e geradas? </a><br />
              <br />
              <a href="#1009">10.09. O que ocorre no caso de transmiss&atilde;o de arquivo contendo RPS j&aacute; transmitido anteriormente?</a> <br />
              <br />
              <a href="#1010">10.10. O que ocorre no caso de transmiss&atilde;o de arquivo contendo RPS j&aacute; convertido &ldquo;on line&rdquo; em NF-e? </a><br />
              <br />
              <a href="#1011">10.11. O que ocorre no caso de convers&atilde;o &ldquo;on line&rdquo; de RPS j&aacute; convertido em NF-e por meio de transmiss&atilde;o de arquivo?</a> <br />
              <br />
              <a href="#1012">10.12. Qual o nome do arquivo de transmiss&atilde;o dos RPS?</a> <br />
              <br />
              <a href="#1013">10.13. O que fazer em caso de erro no arquivo de transmiss&atilde;o dos RPS? </a><br />
              <br />
              <a href="#1014">10.14. Ap&oacute;s o envio do arquivo, em quanto tempo o RPS ser&aacute; convertido em NF-e? </a><br />
              <br />
              <a href="#1015">10.15. &Eacute; poss&iacute;vel a integra&ccedil;&atilde;o em tempo real do sistema de faturamento da empresa com o sistema da NF-e? </a></p></td>
          </tr>
        </table>
          <br />
          <br /></td>
      </tr>
      <tr>
        <td height="1"></td>
      </tr>
      <tr>
        <td height="5" align="left" bgcolor="#859CAD"></td>
      </tr>
    </table>    
	
	<!-- Quadro do meio acima -->
	
	<!-- quadro direita acima --></td>
    </tr>
  <tr>
    <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="3" bgcolor="#CCCCCC"></td>
      </tr>
      <tr>
        <td height="10" bgcolor="#999999"></td>
      </tr>
      <tr>
        <td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><table width="500" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td align="left" background="img/index_oquee_fundo.jpg"><span class="style2">01 - CONCEITOS </span><br />
                <br />
              1.01. O que &eacute; Nota Fiscal Eletr&ocirc;nica de Servi&ccedil;os (NF-e)?<a name="101" id="101"></a><br />
              <br />
              Nota Fiscal Eletr&ocirc;nica de Servi&ccedil;os (NF-e) &eacute; o documento emitido e armazenado eletronicamente em sistema pr&oacute;prio da Prefeitura Municipal, com o objetivo de registrar as opera&ccedil;&otilde;es relativas &agrave; presta&ccedil;&atilde;o de servi&ccedil;os. A NF-e n&atilde;o deve ser confundida com a Nota Fiscal de ICMS, de responsabilidade do Governo Estadual, que registra opera&ccedil;&otilde;es relativas &agrave; circula&ccedil;&atilde;o de mercadorias: supermercados, lojas, restaurantes etc. <br />
              <br />
              1.02. O que &eacute; Nota Fiscal Convencional?<a name="102" id="102"></a><br />
              <br />
              &Eacute; qualquer uma das notas fiscais de servi&ccedil;os emitidas na conformidade do que disp&otilde;em as leis j&aacute; envigor. A nota fiscal convencional s&oacute; poder&aacute; ser emitida por prestadores de servi&ccedil;os desobrigados da emiss&atilde;o de NF-e. Veja no item 3.01 quais s&atilde;o os prestadores obrigados a emitir NF-e. <br />
              <br />
              1.03. O que &eacute; Recibo Provis&oacute;rio de Servi&ccedil;os (RPS)?<a name="103" id="103"></a><br />
              <br />
              &Eacute; o documento que dever&aacute; ser usado por emitentes da NF-e no eventual impedimento da emiss&atilde;o &ldquo;on-line&rdquo; da Nota. Tamb&eacute;m poder&aacute; ser utilizado pelos prestadores sujeitos &agrave; emiss&atilde;o de grande quantidade de NF-e (exemplo: estacionamentos). Nesse caso, o prestador emitir&aacute; o RPS para cada transa&ccedil;&atilde;o e providenciar&aacute; sua convers&atilde;o em NF-e mediante o envio de arquivos (processamento em lote). <br />
              <br />
              <span class="style2">02 - RECIBO PROVIS&Oacute;RIO DE SERVI&Ccedil;OS (RPS)</span><br />
              <br />
              2.01. Como gerar o RPS?<a name="201" id="201"></a><br />
              <br />
              N&atilde;o h&aacute; modelo padr&atilde;o para o RPS, ele dever&aacute; ser confeccionado ou impresso contendo todos os dados que permitam a sua convers&atilde;o em NF-e, em especial o CPF ou o CNPJ do tomador de servi&ccedil;os. <br />
              <br />
              2.02. O RPS deve ser confeccionado por gr&aacute;fica credenciada pela Prefeitura? <a name="202" id="202"></a><br />
              <br />
              N&atilde;o h&aacute; essa necessidade. O RPS poder&aacute; ser confeccionado ou impresso em sistema pr&oacute;prio do contribuinte, sem a necessidade de solicita&ccedil;&atilde;o da Autoriza&ccedil;&atilde;o de Impress&atilde;o de Documento Fiscal (AIDF). <br />
              <br />
              2.03. O RPS deve ter numera&ccedil;&atilde;o seq&uuml;encial espec&iacute;fica?<a name="203" id="203"></a><br />
              <br />
              Sim. O RPS deve ser numerado obrigatoriamente em ordem crescente seq&uuml;encial, a partir do n&uacute;mero 1 (um), em cada s&eacute;rie de emiss&atilde;o (ver item 2.06). Para quem j&aacute; &eacute; emitente de nota fiscal convencional, o RPS dever&aacute; manter a seq&uuml;&ecirc;ncia num&eacute;rica do &uacute;ltimo documento fiscal emitido. <br />
              <br />
              2.04. O que fazer com as notas fiscais convencionais j&aacute; confeccionadas? <a name="204" id="204"></a><br />
              <br />
              As notas fiscais convencionais j&aacute; confeccionadas poder&atilde;o ser utilizadas at&eacute; o t&eacute;rmino dos blocos impressos ou inutilizadas pela unidade competente da Secretaria Municipal de Finan&ccedil;as, a crit&eacute;rio do contribuinte. Leia tamb&eacute;m o item 2.07.
              
              Se a op&ccedil;&atilde;o for pela emiss&atilde;o &ldquo;on-line&rdquo; de NF-e, existem duas op&ccedil;&otilde;es: <br />
              <br />
              1&ordf;) Guardar os blocos impressos das notas fiscais j&aacute; confeccionadas para uso no caso de eventual impedimento da emiss&atilde;o &ldquo;on-line&rdquo;. Tais notas fiscais passam a ser utilizadas como RPS. Ap&oacute;s o t&eacute;rmino do &uacute;ltimo bloco impresso, o RPS dever&aacute; manter a seq&uuml;&ecirc;ncia num&eacute;rica do &uacute;ltimo documento do bloco. <br />
              <br />
              2&ordf;) Inutilizar as notas fiscais j&aacute; confeccionadas e, em caso de eventual impedimento da emiss&atilde;o &ldquo;on-line&rdquo; da NF-e, utilizar o RPS, mantendo a seq&uuml;&ecirc;ncia num&eacute;rica do &uacute;ltimo documento fiscal emitido.
              
              Observa&ccedil;&atilde;o: Para inutilizar as notas fiscais j&aacute; confeccionadas, comparecer a Prefeitura Municipal, munido de todos os blocos de notas a serem cancelados e do livro fiscal. <br />
              <br />
              2.05. Em quantas vias deve-se emitir o RPS?<a name="205" id="205"></a><br />
              <br />
              O RPS deve ser emitido em duas vias. A 1&ordf; ser&aacute; entregue ao tomador de servi&ccedil;os, ficando a 2&ordf; em poder do prestador dos servi&ccedil;os. Ap&oacute;s a convers&atilde;o do RPS em NF-e, a 2&ordf; via do RPS pode ser descartada. Os RPS n&atilde;o convertidos ou cancelados devem ser guardados por cinco anos contados do dia 1&ordm; de janeiro do ano seguinte ao da emiss&atilde;o. <br />
              <br />
              2.06. &Eacute; necess&aacute;rio substituir o RPS ou a nota fiscal convencional por NF-e? <a name="206" id="206"></a><br />
              <br />
              Sim. Os RPS ou as notas fiscais convencionais emitidas perder&atilde;o a validade, para todos os fins de direito, depois de transcorrido o prazo de convers&atilde;o em NF-e. <br />
              <br />
              2.07. Qual o prazo para substituir o RPS ou a nota fiscal convencional por NF-e?<a name="207" id="207"></a><br />
              <br />
              Os RPS ou as notas fiscais convencionais dever&atilde;o ser substitu&iacute;dos por NF-e at&eacute; o d&eacute;cimo dia subseq&uuml;ente ao de sua emiss&atilde;o, n&atilde;o podendo ultrapassar o dia 5 (cinco) do m&ecirc;s subseq&uuml;ente ao da presta&ccedil;&atilde;o de servi&ccedil;os (o prazo inicia-se no dia seguinte ao da emiss&atilde;o do RPS, n&atilde;o podendo ser postergado caso ven&ccedil;a em dia n&atilde;o-&uacute;til). <br />
              <br />
              2.08. O que acontece no caso de n&atilde;o convers&atilde;o do RPS ou da nota fiscal convencional em NF-e?<a name="208" id="208"></a><br />
              <br />
              A n&atilde;o-convers&atilde;o do RPS ou da nota fiscal convencional em NF-e equipara-se a n&atilde;o-emiss&atilde;o de documento fiscal e sujeitar&aacute; o prestador de servi&ccedil;os &agrave;s penalidades previstas na legisla&ccedil;&atilde;o. <br />
              <br />
              2.09. O que acontece no caso de convers&atilde;o fora do prazo do RPS ou da nota fiscal convencional em NF-e? <a name="209" id="209"></a><br />
              <br />
              A convers&atilde;o fora do prazo do RPS ou da nota fiscal convencional em NF-e sujeitar&aacute; o prestador de servi&ccedil;os &agrave;s penalidades previstas na legisla&ccedil;&atilde;o.<br />
              <br />
              2.10. &Eacute; permitido o uso de notas fiscais convencionais conjugadas (mercadorias e servi&ccedil;os) no lugar do RPS? <a name="210" id="210"></a><br />
              <br />
              Sim, o contribuinte poder&aacute; optar por:<br />
              <br />
              1) Emitir &ldquo;on-line&rdquo; a NF-e para os servi&ccedil;os prestados e utilizar as notas convencionais apenas para registrar as opera&ccedil;&otilde;es mercantis; ou <br />
              <br />
              2) Emitir RPS a cada presta&ccedil;&atilde;o de servi&ccedil;os e utilizar as notas convencionais apenas para registrar as opera&ccedil;&otilde;es mercantis, convertendo os RPS em NF-e (individualmente ou mediante transmiss&atilde;o em lote). Nesse caso, a numera&ccedil;&atilde;o do RPS dever&aacute; iniciar do n&ordm; 1; ou<br />
              <br />
              3) Emitir as notas fiscais convencionais conjugadas (mercadorias e servi&ccedil;os) sem a necessidade de solicita&ccedil;&atilde;o da Autoriza&ccedil;&atilde;o de Impress&atilde;o de Documento Fiscal &ndash; AIDF municipal. A parte referente a servi&ccedil;os dever&aacute; ser convertida em NF-e (individualmente ou mediante transmiss&atilde;o em lote). No campo referente &agrave; discrimina&ccedil;&atilde;o dos servi&ccedil;os, dever&aacute; ser impressa a seguinte frase: <em>&ldquo;O REGISTRO DAS OPERA&Ccedil;&Otilde;ES RELATIVAS &Agrave; PRESTA&Ccedil;&Atilde;O DE SERVI&Ccedil;OS, CONSTANTE DESTE DOCUMENTO, SER&Aacute; CONVERTIDO EM NOTA FISCAL ELETR&Ocirc;NICA DE SERVI&Ccedil;OS &ndash; NF-E.&rdquo;</em> <br />
              <br />
              <strong>2.11. &Eacute; permitido o uso de cupons fiscais no lugar do RPS? <a name="211" id="211"></a></strong><br />
              <br />
              Sim. O prestador de servi&ccedil;os dever&aacute; adequar o sistema de emiss&atilde;o dos cupons fiscais de maneira a permitir o registro do n&ordm; do CPF/CNPJ do tomador dos servi&ccedil;os.
              
              Em seguida, os cupons fiscais emitidos dever&atilde;o ser convertidos em NF-e, individualmente ou mediante transmiss&atilde;o em lote. <br />
              <br />
              <strong>2.12. Qual o procedimento a ser adotado no caso de cancelamento de RPS antes da convers&atilde;o em NF-e? <a name="212" id="212"></a></strong><br />
              <br />
              O contribuinte poder&aacute;: <br />
              <br />
              1) Converter o RPS cancelado e cancelar a respectiva NF-e; ou <br />
              <br />
              2) Optar pela n&atilde;o convers&atilde;o do RPS cancelado. Nesse caso, dever&aacute; manter em arquivo, por cinco anos, todas as vias do RPS com a indica&ccedil;&atilde;o de &ldquo;cancelado&rdquo;. Caso contr&aacute;rio, seu cancelamento n&atilde;o ser&aacute; considerado. 
              
              
              O sistema da NF-e controla a seq&uuml;&ecirc;ncia num&eacute;rica dos RPS convertidos. <br />
              <strong><br />
                2.13. Como proceder no caso do prestador n&atilde;o converter o RPS em NF-e?<a name="213" id="213"></a></strong><br />
              <br />
              Se o seu prestador n&atilde;o efetuar a convers&atilde;o do Recibo Provis&oacute;rio de Servi&ccedil;os (RPS) em NF-e informe o fato &agrave; Prefeitura Municipal da Cidade  no campo &quot;Reclama&ccedil;&otilde;es&quot; dispon&iacute;vel no website da NFe da Cidade. <br />
              <hr />
              <br />
              <span class="style2">03 - OBRIGATORIEDADE DE EMISS&Atilde;O DE NF-e </span><br />
              <br />
              <strong>3.01. Quem est&aacute; obrigado &agrave; emiss&atilde;o da NF-e? <a name="301" id="301"></a></strong><br />
              <br />
              Todos os prestadores dos servi&ccedil;os constantes em lei, que auferirem receita bruta de servi&ccedil;os igual ou superior ao que consta em lei, considerando-se todos os estabelecimentos da pessoa jur&iacute;dica situados no nosso munic&iacute;pio. Mas, prestadores desobrigados tamb&eacute;m podem optar pela utiliza&ccedil;&atilde;o de NF-e. Leia o item 3.09. <br />
              <hr />
              <br />
              <strong>3.02. A partir de quando a emiss&atilde;o de NF-e &eacute; obrigat&oacute;ria? <a name="302" id="302"></a></strong><br />
              <br />
              A NF-e dever&aacute; ser emitida na conformidade do cronograma constante lei posta em vigor. <br />
              <hr />
              <br />
              <strong>3.03. Como devo apurar meu faturamento para saber se devo emitir a NF-e?<a name="303" id="303"></a></strong><br />
              <br />
              Os prestadores dos servi&ccedil;os constantes em lei devem apurar, em janeiro de cada exerc&iacute;cio, a receita bruta de servi&ccedil;os do exerc&iacute;cio anterior, considerando todos os estabelecimentos da empresa situados no munic&iacute;pio. Caso a receita bruta de servi&ccedil;os apurada seja igual ou superior a que consta em lei, todos os estabelecimentos da empresa considerados na apura&ccedil;&atilde;o estar&atilde;o obrigados a utilizar NF-e, a partir do m&ecirc;s da apura&ccedil;&atilde;o. <br />
              <hr />
              <br />
              <strong>3.04. Quem iniciou a atividade de presta&ccedil;&atilde;o de servi&ccedil;os durante um determinado exerc&iacute;cio (a partir de 2005) est&aacute; obrigado &agrave; emiss&atilde;o de NF-e no exerc&iacute;cio seguinte?<a name="304" id="304"></a><br />
                </strong><br />
              Estar&aacute; obrigada a utilizar NF-e, a partir de 1&ordm; de janeiro do exerc&iacute;cio seguinte, a empresa cuja receita bruta de servi&ccedil;os mensal m&eacute;dia seja igual ou superior ao que consta em lei, no exerc&iacute;cio em que iniciou sua atividade. Para apurar essa receita mensal m&eacute;dia, deve-se considerar a receita de servi&ccedil;os total de todos os estabelecimentos da empresa no munic&iacute;pio  e a quantidade de meses de atividade do primeiro estabelecimento da empresa no exerc&iacute;cio em que come&ccedil;ou a operar. <br />
              <hr />
              <br />
              <strong>3.05. Como fica a obrigatoriedade de emiss&atilde;o de NF-e, considerando a data de in&iacute;cio de atividade de presta&ccedil;&atilde;o de servi&ccedil;o?<a name="305" id="305"></a></strong><br />
              <br />
              Exerc&iacute;cio Receita Bruta Total de Servi&ccedil;os 
              Receita Bruta M&eacute;dia de Servi&ccedil;os In&iacute;cio de utiliza&ccedil;&atilde;o obrigat&oacute;ria da NF-e 
              Total igual ou superior ao que consta na lei, 
              M&eacute;dia igual ou maior que ao valor que consta em lei. <br />
              <br />
              <strong><em> * O apuramento vale j&aacute; a partir do exerc&iacute;cio de in&iacute;cio de atividades de presta&ccedil;&atilde;o de servi&ccedil;o. Para quem iniciou atividades em exerc&iacute;cios anteriores ao ano que a lei entrou em vigor, vale o faturamento apurado a partir do exerc&iacute;cio que a lei entrou em vigor.<br />
                </em></strong>
              <hr />
              <strong><em><br />
                </em></strong> <strong>3.06. Se o prestador de servi&ccedil;os obrigado &agrave; emiss&atilde;o de NF-e auferir, em determinado exerc&iacute;cio, receita bruta de servi&ccedil;os inferior ao valor deteminado poder&aacute; voltar a emitir nota fiscal convencional?<a name="306" id="306"></a></strong><br />
              <br />
              N&atilde;o. A obrigatoriedade da emiss&atilde;o de NF-e n&atilde;o cessa caso o prestador venha a auferir, em determinado exerc&iacute;cio, receita bruta de servi&ccedil;os inferior aos limites estabelecidos na legisla&ccedil;&atilde;o. <br />
              <hr />
              <br />
              <strong>3.07. O contribuinte enquadrado em mais de um c&oacute;digo de presta&ccedil;&atilde;o de servi&ccedil;os dever&aacute; emitir NF-e para todos os servi&ccedil;os? </strong><br />
              <a name="307" id="307"></a><br />
              Sim. O contribuinte que emitir NF-e dever&aacute; faz&ecirc;-lo para todos os servi&ccedil;os prestados. <br />
              <hr />
              <strong><br />
                3.08. O contribuinte enquadrado em mais de um c&oacute;digo de presta&ccedil;&atilde;o de servi&ccedil;os  dever&aacute; obedecer ao cronograma de emiss&atilde;o de NF-e para cada c&oacute;digo de servi&ccedil;o?<a name="308" id="308"></a></strong><br />
              <br />
              N&atilde;o. Na hip&oacute;tese do contribuinte se enquadrar em mais de um c&oacute;digo de presta&ccedil;&atilde;o de servi&ccedil;os, dever&aacute; adotar, para todos os c&oacute;digos, a mesma data de in&iacute;cio, assim considerada a mais pr&oacute;xima da data de publica&ccedil;&atilde;o dessa portaria. <br />
              <hr />
              <br />
              <strong>3.09. Somente quem est&aacute; obrigado poder&aacute; emitir NF-e? </strong><a name="309" id="309"></a><br />
              <br />
              N&atilde;o. Todos os prestadores de servi&ccedil;os inscritos no Cadastro de Emissor da NFe, desobrigados da emiss&atilde;o de NF-e, poder&atilde;o optar por sua emiss&atilde;o. <br />
              <hr />
              <br />
              <strong>3.10. A op&ccedil;&atilde;o pela emiss&atilde;o de NF-e depende de requerimento do interessado?</strong><a name="310" id="310"></a><br />
              <br />
              Sim. A autoriza&ccedil;&atilde;o para emiss&atilde;o de NF-e deve ser solicitada atrav&eacute;s do website da NFe da Prefeitura Municipal. A Secretaria Municipal de Finan&ccedil;as/Fazenda comunicar&aacute; aos interessados, por &ldquo;e-mail&rdquo;, a delibera&ccedil;&atilde;o do pedido de autoriza&ccedil;&atilde;o. <br />
              <hr />
              <br />
              <strong>3.11. A op&ccedil;&atilde;o pela emiss&atilde;o de NF-e, uma vez deferida, vigora a partir de quando?<a name="311" id="311"></a></strong><br />
              <br />
              Os prestadores de servi&ccedil;os que optarem pela NF-e iniciar&atilde;o sua emiss&atilde;o no dia seguinte ao do deferimento da autoriza&ccedil;&atilde;o, devendo substituir todas as notas fiscais convencionais emitidas no respectivo m&ecirc;s. <br />
              <hr />
              <br />
              <strong>3.12. A partir de quando uma empresa rec&eacute;m-aberta, que opte pela utiliza&ccedil;&atilde;o de NF-e, pode emitir RPS ou utilizar NF-e? </strong><a name="312" id="312"></a><br />
              <br />
              Uma empresa rec&eacute;m-aberta, que n&atilde;o disponha de blocos de notas fiscais convencionais, s&oacute; poder&aacute; prestar servi&ccedil;os depois de obter a autoriza&ccedil;&atilde;o para utiliza&ccedil;&atilde;o de NF-e. N&atilde;o &eacute; poss&iacute;vel a emiss&atilde;o de NF-e, ou a substitui&ccedil;&atilde;o de RPS por NF-e, com data anterior &agrave; data de autoriza&ccedil;&atilde;o para utilizar NF-e. <br />
              <hr />
              <br />
              <strong>3.13. O prestador de servi&ccedil;os, desobrigado da emiss&atilde;o de NF-e, que optar pela NF-e, poder&aacute; voltar a emitir nota fiscal convencional?</strong><a name="313" id="313"></a><br />
              <br />
              N&atilde;o. A op&ccedil;&atilde;o pela emiss&atilde;o de NF-e, uma vez deferida, &eacute; irretrat&aacute;vel. <br />
              <hr />
              <br />
              <strong>3.14. Uma vez deferida a autoriza&ccedil;&atilde;o para emiss&atilde;o de NF-e, qual o prazo para substituir as notas fiscais convencionais emitidas at&eacute; a data do deferimento da autoriza&ccedil;&atilde;o?</strong><a name="314" id="314"></a><br />
              <br />
              As notas fiscais convencionais, emitidas a partir do primeiro dia do m&ecirc;s da autoriza&ccedil;&atilde;o para utiliza&ccedil;&atilde;o de NF-e at&eacute; a data do deferimento dessa autoriza&ccedil;&atilde;o, devem ser substitu&iacute;das at&eacute; o d&eacute;cimo dia subseq&uuml;ente ao do deferimento, n&atilde;o podendo ultrapassar o dia 5 (cinco) do m&ecirc;s subseq&uuml;ente.
              
              
              O prazo inicia-se no dia seguinte ao do deferimento da autoriza&ccedil;&atilde;o para emiss&atilde;o de NF-e, n&atilde;o podendo ser postergado caso ven&ccedil;a em dia n&atilde;o-&uacute;til. Consulte, tamb&eacute;m, o item 3.11. <br />
              <hr />
              <br />
              <strong>3.15. As entidades imunes ao ISS est&atilde;o obrigadas &agrave; emiss&atilde;o da NF-e?</strong><a name="315" id="315"></a><br />
              <br />
              As entidades imunes ao ISS, enumeradas pelo art. 150, VI, da Constitui&ccedil;&atilde;o Federal, est&atilde;o dispensadas da emiss&atilde;o de documento fiscal. No entanto, se optarem pela emiss&atilde;o de documento fiscal e se enquadrarem nas disposi&ccedil;&otilde;es lei, dever&atilde;o se adequar &agrave;s exig&ecirc;ncias da NF-e. O sistema da NF-e permite a sele&ccedil;&atilde;o do tipo de tributa&ccedil;&atilde;o do servi&ccedil;o, que, no caso em quest&atilde;o, seria &ldquo;imune&rdquo;.
              Nesse caso, n&atilde;o ser&aacute; gerado cr&eacute;dito para o tomador dos servi&ccedil;os. <br />
              <hr />
              <br />
              <strong>3.16. As entidades isentas do ISS est&atilde;o obrigadas &agrave; emiss&atilde;o da NF-e?</strong><a name="316" id="316"></a><br />
              <br />
              As entidades isentas do ISS est&atilde;o obrigadas &agrave; emiss&atilde;o de documento fiscal. Portanto, caso se enquadrem nas disposi&ccedil;&otilde;es da Lei, dever&atilde;o se adequar &agrave;s exig&ecirc;ncias da NF-e. O sistema da NF-e permite a sele&ccedil;&atilde;o do tipo de tributa&ccedil;&atilde;o do servi&ccedil;o, que, no caso, seria &ldquo;isento&rdquo;. Nesse caso, n&atilde;o ser&aacute; gerado cr&eacute;dito para o tomador dos servi&ccedil;os. <br />
              <hr />
              <br />
              <span class="style2">04 - BENEF&Iacute;CIOS</span> <br />
              <br />
              <strong>4.01. Quais os benef&iacute;cios para quem emite NF-e?</strong><a name="401" id="401"></a><br />
              <br />
              Redu&ccedil;&atilde;o de custos de impress&atilde;o e de armazenagem de documentos fiscais (a NF-e &eacute; um documento emitido e armazenado eletronicamente em sistema pr&oacute;prio da Prefeitura de S&atilde;o Paulo); 
              Dispensa de Autoriza&ccedil;&atilde;o para Impress&atilde;o de Documentos Fiscais (AIDF) para a NF-e; 
              Emiss&atilde;o de NF-e por meio da internet; 
              Gera&ccedil;&atilde;o autom&aacute;tica da guia de recolhimento por meio da internet; 
              Possibilidade de envio de NF-e por e-mail; 
              Maior efici&ecirc;ncia no controle gerencial de emiss&atilde;o de NF-e; 
              Dispensa de lan&ccedil;amento das NF-e na Declara&ccedil;&atilde;o Eletr&ocirc;nica de Servi&ccedil;os (DES). <br />
              <hr />
              <br />
              <strong>4.02. Quais os benef&iacute;cios para quem recebe NF-e? <br />
                </strong><a name="402" id="402"></a><br />
              1. Quem recebe NF-e poder&aacute; utilizar como cr&eacute;dito para abatimento de uma porcentagem do valor do imposto determinado em Lei: <br />
              <br />
              2. Gera&ccedil;&atilde;o autom&aacute;tica da guia de recolhimento por meio da internet, no caso de respons&aacute;vel tribut&aacute;rio; <br />
              <br />
              3. Possibilidade de recebimento de NF-e por e-mail; <br />
              <br />
              4. Maior efici&ecirc;ncia no controle gerencial de recebimento de NF-e; <br />
              <br />
              5. Dispensa de lan&ccedil;amento das NF-e na Declara&ccedil;&atilde;o Eletr&ocirc;nica de Servi&ccedil;os (DES). <br />
              <hr />
              <span class="style2"><br />
                05 - EMISS&Atilde;O, CANCELAMENTO E RETIFICA&Ccedil;&Atilde;O DE NF-e </span><br />
              <strong><br />
                5.01. Como deve ser emitida a NF-e?</strong><a name="501" id="501"></a><br />
              <br />
              A NF-e deve ser emitida &ldquo;on-line&rdquo;, por meio da internet, no endere&ccedil;o eletr&ocirc;nico da Prefeitura Municipal, somente pelos prestadores de servi&ccedil;os estabelecidos no munic&iacute;pio, mediante a utiliza&ccedil;&atilde;o de senha. <br />
              <hr />
              <br />
              <strong>5.02. O que fazer em caso de eventual impedimento da emiss&atilde;o &ldquo;on line&rdquo; da NF-e?</strong><a name="502" id="502"></a><br />
              <br />
              No caso de eventual impedimento da emiss&atilde;o &ldquo;on-line&rdquo; da NF-e, o prestador de servi&ccedil;os emitir&aacute; RPS, registrando todos os dados que permitam sua substitui&ccedil;&atilde;o por NF-e. <br />
              <hr />
              <br />
              <strong>5.03. &Eacute; obrigat&oacute;ria a emiss&atilde;o de NF-e &ldquo;on line&rdquo;? </strong><a name="503" id="503"></a><br />
              <br />
              N&atilde;o. O prestador de servi&ccedil;os poder&aacute; emitir RPS a cada presta&ccedil;&atilde;o de servi&ccedil;os, podendo, nesse caso, efetuar a sua substitui&ccedil;&atilde;o por NF-e, mediante a transmiss&atilde;o em lote dos RPS emitidos. <br />
              <hr />
              <br />
              <strong>5.04. Em quantas vias deve-se imprimir a NF-e?</strong><a name="504" id="504"></a><br />
              <br />
              A NF-e dever&aacute; ser impressa por ocasi&atilde;o da presta&ccedil;&atilde;o de servi&ccedil;os em via &uacute;nica. Sua impress&atilde;o poder&aacute; ser dispensada na hip&oacute;tese do tomador solicitar seu envio por &ldquo;e-mail&rdquo;. <br />
              <hr />
              <br />
              <strong>5.05. Pode-se enviar a NF-e por e-mail para o tomador de servi&ccedil;os? </strong><a name="505" id="505"></a><br />
              <br />
              Sim. A NF-e poder&aacute; ser enviada por &ldquo;e-mail&rdquo; ao tomador de servi&ccedil;os, desde que por sua solicita&ccedil;&atilde;o. Nesse caso, o tomador pode dispensar a emiss&atilde;o da NF-e. O prestador de servi&ccedil;os poder&aacute;, inclusive, adicionar coment&aacute;rios ao e-mail. <br />
              <hr />
              <br />
              <strong>5.06. A NF-e poder&aacute; ser impressa em modelo diverso do estabelecido em regulamento? </strong><a name="506" id="506"></a><br />
              <br />
              Sim. A Secretaria Municipal de Finan&ccedil;as poder&aacute; autorizar, por regime especial, a impress&atilde;o da NF-e em modelo definido pelo prestador de servi&ccedil;os, tendo por base a integra&ccedil;&atilde;o de seu sistema de emiss&atilde;o de notas fiscais com o sistema da Prefeitura da Cidade. <br />
              <hr />
              <br />
              <strong>5.07. A NF-e ter&aacute; numera&ccedil;&atilde;o seq&uuml;encial espec&iacute;fica? </strong><a name="507" id="507"></a><br />
              <br />
              Sim. O n&uacute;mero da NF-e ser&aacute; gerado pelo sistema, em ordem seq&uuml;encial, sendo &uacute;nico para cada estabelecimento da empresa prestadora de servi&ccedil;os. <br />
              <hr />
              <strong>5.08. At&eacute; quando &eacute; poss&iacute;vel consultar a NF-e, ap&oacute;s sua emiss&atilde;o? </strong><a name="508" id="508"></a><br />
              <br />
              As NF-e emitidas poder&atilde;o ser consultadas e impressas &quot;on-line&quot; por 5 anos. Depois de transcorrido tal prazo, a consulta &agrave;s NF-e emitidas somente poder&aacute; ser realizada mediante a solicita&ccedil;&atilde;o de envio de arquivo em meio magn&eacute;tico. <br />
              <hr />
              <strong>5.09. Pode-se utilizar uma NF-e para registrar mais de um tipo de servi&ccedil;o prestado? </strong><a name="509" id="509"></a><br />
              <br />
              N&atilde;o. Para cada tipo de servi&ccedil;o prestado (c&oacute;digo de servi&ccedil;o) dever&aacute; ser emitida uma NF-e. Ou seja, uma NF-e registra apenas um tipo de servi&ccedil;o. <br />
              <hr />
              <strong>5.10. Pode-se cancelar uma NF-e emitida? Em quais situa&ccedil;&otilde;es? </strong><a name="510" id="510"></a><br />
              <br />
              A NF-e poder&aacute; ser cancelada pelo emitente, por meio do sistema, nas seguintes situa&ccedil;&otilde;es:<br />
              <br />
              1. Cancelamento da NF-e quando o ISS ainda n&atilde;o foi recolhido:<br />
              <br />
              1.1. Cancelamento de NF-e por n&atilde;o ter sido prestado o servi&ccedil;o
              
              
              Lembramos que o fato gerador do ISS &eacute; a presta&ccedil;&atilde;o do servi&ccedil;o. Dessa forma, n&atilde;o havendo presta&ccedil;&atilde;o de servi&ccedil;o, n&atilde;o h&aacute; ISS a recolher e a NF-e pode ser cancelada. Entretanto, caso tenha havido presta&ccedil;&atilde;o de servi&ccedil;o, o ISS correspondente deve ser recolhido independentemente de ter ou n&atilde;o sido efetuado o pagamento pelo servi&ccedil;o prestado. Nesse caso a NF-e n&atilde;o poder&aacute; ser cancelada. <br />
              <br />
              1.2. Cancelamento de NF-e emitida com dados incorretos.
              
              Dados incorretos do tomador dos servi&ccedil;os, quando este for pessoa jur&iacute;dica estabelecida no munic&iacute;pio, n&atilde;o podem ser retificados pelo prestador dos servi&ccedil;os. 
              
              
              Para corrigir dados da NF-e, inclusive os dados de tomador pessoa f&iacute;sica ou pessoa jur&iacute;dica n&atilde;o estabelecida no munic&iacute;pio, o prestador de servi&ccedil;os dever&aacute; cancelar a NF-e e emitir outra, via RPS, em substitui&ccedil;&atilde;o &agrave; NF-e incorreta, conforme instru&ccedil;&otilde;es a seguir. Observar que a data de emiss&atilde;o do RPS dever&aacute; observar a data da ocorr&ecirc;ncia do fato gerador, ou seja, a data da efetiva presta&ccedil;&atilde;o do servi&ccedil;o.
              
              NF-e com data retroativa:
              
              Caso t&iacute;pico: uma NF-e foi emitida no dia 20/09. No dia 04/10, constatou-se que essa NF-e foi emitida incorretamente, sendo necess&aacute;rio o seu cancelamento e posterior substitui&ccedil;&atilde;o por outra NF-e. O contribuinte, nesse caso, dever&aacute;: <br />
              a) Verificar se a NF-e emitida incorretamente consta de guia de recolhimento e, se for o caso, cancelar essa guia; <br />
              b) Cancelar a NF-e; <br />
              c) Emitir um RPS com a data de 20/09, com os dados corretos; <br />
              d) Efetuar a substitui&ccedil;&atilde;o do RPS com os dados corretos em NF-e. No formul&aacute;rio da NF-e, preencha o campo &quot;n&ordm; do RPS&quot;, &quot;S&eacute;rie do RPS&quot; e &quot;Data de Emiss&atilde;o do RPS&quot; com os dados desse RPS. <br />
              e) Emitir uma nova guia de recolhimento, se for o caso. <br />
              <br />
              Observa&ccedil;&otilde;es:<br />
              <br />
              - Para mais informa&ccedil;&otilde;es sobre o cancelamento de NF-e, consulte o manual de acesso ao sistema da NF-e (vers&atilde;o para download); <br />
              - Se a NF-e j&aacute; tiver sido inclu&iacute;da em uma guia de recolhimento emitida, o status da NF-e aparecer&aacute; como &ldquo;Normal&rdquo;. Nesse caso, efetue o cancelamento da referida guia para que seja poss&iacute;vel o cancelamento da NF-e. <br />
              <br />
              2. Cancelamento de NF-e com ISS j&aacute; recolhido:
              
              Ap&oacute;s o recolhimento do imposto, a NF-e somente poder&aacute; ser cancelada por meio de processo administrativo. <br />
              <br />
              2.1. Cancelamento de NF-e por n&atilde;o ter sido prestado o servi&ccedil;o
              
              Lembramos que o fato gerador do ISS &eacute; a presta&ccedil;&atilde;o do servi&ccedil;o. Dessa forma, n&atilde;o havendo presta&ccedil;&atilde;o de servi&ccedil;o, n&atilde;o h&aacute; ISS a recolher e a NF-e pode ser cancelada. Entretanto, caso tenha havido presta&ccedil;&atilde;o de servi&ccedil;o, o ISS correspondente deve ser recolhido independentemente de ter ou n&atilde;o sido efetuado o pagamento pelo servi&ccedil;o prestado. Nesse caso, a NF-e n&atilde;o poder&aacute; ser cancelada.
              
              A NF-e dever&aacute; ser cancelada e o ISS recolhido restitu&iacute;do mediante processo administrativo, ao qual dever&atilde;o ser juntados os seguintes documentos: <br />
              - requerimento do interessado, em que conste o nome ou raz&atilde;o social, n&uacute;mero de inscri&ccedil;&atilde;o no CCM, n&uacute;mero de inscri&ccedil;&atilde;o no CNPJ ou CPF, endere&ccedil;o completo, telefone para contato, exposi&ccedil;&atilde;o clara do pedido e todos os elementos necess&aacute;rios &agrave; sua prova; <br />
              - contrato social; <br />
              - RG e CPF do signat&aacute;rio; <br />
              - identifica&ccedil;&atilde;o da NF-e a ser cancelada. <br />
              <br />
              2.2. Cancelamento de NF-e emitida com dados incorretos.
              
              Dados incorretos do tomador dos servi&ccedil;os, quando este for pessoa jur&iacute;dica estabelecida no munic&iacute;pio, n&atilde;o podem ser retificados pelo prestador dos servi&ccedil;os. Nesse caso, antes de emitir NF-e em substitui&ccedil;&atilde;o &agrave; cancelada, o prestador deve solicitar ao tomador dos servi&ccedil;os que verifique seus dados. 
              
              O prestador de servi&ccedil;os dever&aacute; emitir outra NF-e, via RPS, em substitui&ccedil;&atilde;o &agrave; cancelada. Note-se que a data de emiss&atilde;o do RPS dever&aacute; ser a data da ocorr&ecirc;ncia do fato gerador, ou seja, a data da efetiva presta&ccedil;&atilde;o do servi&ccedil;o.
              
              A NF-e dever&aacute; ser cancelada mediante processo administrativo, ao qual dever&atilde;o ser juntados os seguintes documentos: <br />
              - requerimento do interessado, constando o nome ou raz&atilde;o social,  n&uacute;mero de inscri&ccedil;&atilde;o no CNPJ ou CPF, endere&ccedil;o completo, telefone para contato, exposi&ccedil;&atilde;o clara do pedido e todos os elementos necess&aacute;rios &agrave; sua prova; <br />
              - contrato social; <br />
              - RG e CPF do signat&aacute;rio; <br />
              - identifica&ccedil;&atilde;o da NF-e a ser cancelada bem como da NF-e que a substituiu. <br />
              <br />
              O prestador de servi&ccedil;os poder&aacute; solicitar que o pagamento do ISS da NF-e cancelada seja realocado para o da NF-e que a substituiu ou solicitar a restitui&ccedil;&atilde;o do valor recolhido. <br />
              <br />
              Observa&ccedil;&atilde;o: o prestador dos servi&ccedil;os que solicitar restitui&ccedil;&atilde;o de ISS que tenha sido recolhido pelo tomador dos servi&ccedil;os, dever&aacute; obter deste a autoriza&ccedil;&atilde;o para receb&ecirc;-la e juntar essa autoriza&ccedil;&atilde;o ao requerimento. <strong>Verificar com a Prefeitura Municipal o local de entrega do requerimento bem como hor&aacute;rios</strong>. <br />
              <br />
              Observa&ccedil;&otilde;es: <br />
              - a NF-e que foi cancelada aparecer&aacute; com situa&ccedil;&atilde;o <em>&ldquo;cancelada&rdquo;</em> tanto para o prestador quanto para o tomador dos servi&ccedil;os; <br />
              - o tomador dos servi&ccedil;os, desde que tenha cadastrado seu &quot;e-mail&quot; para recebimento da NF-e, receber&aacute; um aviso informando que a NF-e foi cancelada. <br />
              <hr />
              <strong>5.11. Ap&oacute;s a emiss&atilde;o da NF-e, pode-se alter&aacute;-la? </strong><a name="511" id="511"></a><br />
              <br />
              N&atilde;o. Se houver necessidade de retificar dados incorretos da NF-e, leia o item 5.10. <br />
              <hr />
              <strong>5.12. A emiss&atilde;o de NF-e permite o registro de opera&ccedil;&otilde;es conjugadas (mercadorias e servi&ccedil;os)?<br />
                </strong><a name="512" id="512"></a><br />
              N&atilde;o. A NF-e destina-se exclusivamente ao registro de presta&ccedil;&atilde;o de servi&ccedil;os. Consulte, tamb&eacute;m, o item 2.11. <br />
              <hr />
              <strong>5.13. A emiss&atilde;o de NF-e permite o registro dos dados referentes aos tributos federais?</strong><a name="513" id="513"></a><br />
              <br />
              Sim. O campo destinado &agrave; discrimina&ccedil;&atilde;o dos servi&ccedil;os &eacute; de livre preenchimento e pode ser utilizado para o registro de impostos e contribui&ccedil;&otilde;es federais. Lembramos que a base de c&aacute;lculo do ISS &eacute; o pre&ccedil;o do servi&ccedil;o, que inclui os impostos e contribui&ccedil;&otilde;es federais. Dessa forma, tais impostos e contribui&ccedil;&otilde;es n&atilde;o podem ser considerados como redu&ccedil;&atilde;o da base de c&aacute;lculo do ISS. <br />
              <hr />
              <strong>5.14. Considerado o cronograma constante em lei, quem estiver obrigado &agrave; utiliza&ccedil;&atilde;o de NF-e dever&aacute; requerer autoriza&ccedil;&atilde;o para sua emiss&atilde;o? </strong><a name="514" id="514"></a><br />
              <br />
              Sim. Tanto as empresas obrigadas como as que optem pela utiliza&ccedil;&atilde;o de NF-e devem solicitar a correspondente autoriza&ccedil;&atilde;o. <br />
              <hr />
              <strong>5.15. Como obter a autoriza&ccedil;&atilde;o para emiss&atilde;o de NF-e?</strong><a name="515" id="515"></a><br />
              <br />
              No Portal da Prefeitura  utilize o link &quot;Prestadores&quot; para solicitar uma senha que permite o acesso a &aacute;reas restritas desse &ldquo;site&rdquo;. <br />
              <br />
              <hr />
              <strong>5.16. A NF-e poder&aacute; ser emitida englobando v&aacute;rios tipos de servi&ccedil;os? <a name="516" id="516"></a></strong><br />
              <br />
              N&atilde;o. O prestador de servi&ccedil;os dever&aacute; emitir uma NF-e para cada servi&ccedil;o prestado, sendo vedada a emiss&atilde;o de uma mesma NF-e que englobe servi&ccedil;os enquadrados em mais de um c&oacute;digo de servi&ccedil;o. <br />
              <br />
              <hr />
              <strong>5.17. Como alterar a data de emiss&atilde;o da NF-e quando esta for emitida em data posterior a da presta&ccedil;&atilde;o dos servi&ccedil;os?</strong><a name="517" id="517"></a><br />
              <br />
              De acordo com a legisla&ccedil;&atilde;o, por ocasi&atilde;o da presta&ccedil;&atilde;o de cada servi&ccedil;o (fato gerador) dever&aacute; ser emitida Nota Fiscal, Nota Fiscal-Fatura de Servi&ccedil;os, Cupom Fiscal ou outro documento exigido pela Administra&ccedil;&atilde;o. Portanto, n&atilde;o deve ocorrer emiss&atilde;o de NF-e em data posterior a da ocorr&ecirc;ncia do fato gerador do ISS. 
              
              Mesmo no caso de convers&atilde;o de RPS em NF-e, embora a NF-e possa ser emitida em data posterior, o sistema considera a data de emiss&atilde;o do RPS como a data do fato gerador para efeito de c&aacute;lculo do imposto. <br />
              <br />
              <hr />
              <strong>5.18. Como emitir NF-e para tomador de servi&ccedil;os (PJ) estabelecido em outro pa&iacute;s? <br />
                </strong><a name="518" id="518"></a><br />
              No caso de exporta&ccedil;&atilde;o de servi&ccedil;os, ou seja, servi&ccedil;os cujos resultados se verifiquem no exterior: <br />
              <br />
              - N&atilde;o informe o n&ordm; do CNPJ, Inscri&ccedil;&atilde;o Municipal, CEP e UF; <br />
              - No campo Endere&ccedil;os dever&atilde;o ser colocados os dados referentes ao Estado e no campo Munic&iacute;pio o Pa&iacute;s; <br />
              - Nos demais campos dever&atilde;o ser preenchidos normalmente.
              
              No caso de os resultados dos servi&ccedil;os se verificarem no Brasil, mesmo que o pagamento seja feito no exterior, os servi&ccedil;os ser&atilde;o tributados no nosso munic&iacute;pio <br />
              <br />
              <hr />
              <strong>5.19. Emiti uma NF-e com dados incorretos. Posso corrigi-la por meio de carta de corre&ccedil;&atilde;o? </strong><a name="519" id="519"></a><br />
              <br />
              N&atilde;o &eacute; permitida a utiliza&ccedil;&atilde;o de carta de corre&ccedil;&atilde;o para retificar a &ldquo;Discrimina&ccedil;&atilde;o dos Servi&ccedil;os&rdquo;. 
              
              Para mais informa&ccedil;&otilde;es, consulte o manual de acesso ao sistema da NF-e para pessoas jur&iacute;dicas. <br />
              <br />
              <hr />
              <strong>5.20. Onde pode ser inclu&iacute;do o campo de aceite dos servi&ccedil;os na NF-e? </strong><a name="520" id="520"></a><br />
              <br />
              O &quot;canhoto&quot; para aceite dos servi&ccedil;os prestados n&atilde;o &eacute; previsto nos documentos fiscais emitidos &quot;on-line&quot;.
              
              Caso a formalidade de aceite seja necess&aacute;ria, redija os termos do &ldquo;aceite&rdquo; no campo &quot;Discrimina&ccedil;&atilde;o de Servi&ccedil;os&quot;, depois da descri&ccedil;&atilde;o dos servi&ccedil;os prestados. Impressa a NF-e, o tomador dos servi&ccedil;os poder&aacute; aceit&aacute;-los apondo sua assinatura no local indicado no corpo da nota fiscal. <br />
              <br />
              <hr />
              <strong>5.21. Estou enquadrado no Simples Nacional, institu&iacute;do pela Lei Complementar n&ordm; 123/2006. Por que minhas NF-e n&atilde;o apresentam al&iacute;quota e valor do ISS?<a name="521" id="521"></a> </strong><br />
              <br />
              Para contribuinte enquadrado no Simples Nacional, quando a responsabilidade pelo recolhimento do ISS &eacute; do prestador dos servi&ccedil;os, os campos referentes &agrave; base de c&aacute;lculo, al&iacute;quota e valor do ISS n&atilde;o s&atilde;o utilizados na NF-e.
              
              Nessa situa&ccedil;&atilde;o, o recolhimento dos tributos dever&aacute; ser feito mensalmente, mediante Documento de Arrecada&ccedil;&atilde;o do Simples Nacional (DAS), conforme orienta&ccedil;&atilde;o dispon&iacute;vel em http://www.receita.fazenda.gov.br/SimplesNacional. <br />
              <br />
              <hr />
              <strong>5.22. Estou enquadrado no Simples Nacional e emito Nota Fiscal Eletr&ocirc;nica (NF-e). Como ser&aacute; a emiss&atilde;o das NF-e, quando o tomador dos servi&ccedil;os for respons&aacute;vel pelo recolhimento do ISS? </strong><a name="522" id="522"></a><br />
              <br />
              Quando o tomador dos servi&ccedil;os for respons&aacute;vel pelo recolhimento do ISS, a nota fiscal ser&aacute; emitida com tributa&ccedil;&atilde;o normal e o tomador dever&aacute; emitir a guia de recolhimento pelo sistema da NF-e.<br />
              <br />
              <hr />
              <strong>5.23. Estou enquadrado em regime de tributa&ccedil;&atilde;o diferente do que consta no sistema da NF-e (Simples Nacional ou tributa&ccedil;&atilde;o normal), e quero corrigir a situa&ccedil;&atilde;o para as pr&oacute;ximas NF-e e para as existentes. O que devo fazer?</strong><a name="523" id="523"></a> <br />
              <br />
              As NF-e emitidas com regime de tributa&ccedil;&atilde;o incorreto n&atilde;o poder&atilde;o ser retificadas. Por&eacute;m as pr&oacute;ximas NF-e emitidas poder&atilde;o ser corrigidas mediante
              
              
              contado com a Prefeitura Municipal e solicitando altera&ccedil;&atilde;o do cadastro da empresa emissora de NF-e <br />
              <hr />
              <br />
              <span class="style2">06 - EMISS&Atilde;O DE GUIA DE RECOLHIMENTO</span><br />
              <br />
              <strong>6.01. Existe uma guia de recolhimento de ISS espec&iacute;fica para a NF-e?</strong><a name="601" id="601"></a><br />
              <br />
              Sim. O recolhimento do ISS, referente &agrave;s NF-e, dever&aacute; ser feito exclusivamente por meio de documento de arrecada&ccedil;&atilde;o emitido pelo aplicativo da NF-e no menu &quot;Guia de Pagamento&quot; para os prestadores de servi&ccedil;os. <br />
              <br />
              Os tomadores de servi&ccedil;os n&atilde;o emitentes de NF-e devem acessar o menu &quot;Tomadores&quot;, item &quot;Guia de Pagamento&quot; no sistema para poder emitir guia de recolhimento quando o ISS deve ser retido e recolhido pelo tomador. <br />
              <br />
              <hr />
              <strong>6.02. Quando a guia de recolhimento de ISS fica dispon&iacute;vel para emiss&atilde;o?</strong><a name="602" id="602"></a><br />
              <br />
              A partir da emiss&atilde;o da primeira NF-e dentro do m&ecirc;s. <br />
              <br />
              <hr />
              <strong>6.03. Quem fica dispensado da emiss&atilde;o da guia de recolhimento pelo sistema da NF-e? </strong><a name="603" id="603"></a><br />
              <br />
              1) Os tomadores dos servi&ccedil;os respons&aacute;veis pela reten&ccedil;&atilde;o e recolhimento do ISS, quando o prestador de servi&ccedil;os n&atilde;o efetuar a substitui&ccedil;&atilde;o do RPS por NF-e.<br />
              <br />
              2) Os &oacute;rg&atilde;os da administra&ccedil;&atilde;o p&uacute;blica direta da Uni&atilde;o, dos Estados e do Munic&iacute;pio de S&atilde;o Paulo, bem como suas autarquias, funda&ccedil;&otilde;es, empresas p&uacute;blicas, sociedades de economia mista e demais entidades controladas direta ou indiretamente pela Uni&atilde;o, pelos Estados ou pelo Munic&iacute;pio, que recolherem o ISS retido na fonte por meio dos sistemas or&ccedil;ament&aacute;rio e financeiro dos governos federal, estadual e municipal. <br />
              <br />
              3) As microempresas estabelecidas no Munic&iacute;pio e enquadradas no Simples Nacional. <br />
              <br />
              <hr />
              <strong>6.04. Qual &eacute; a data de vencimento do ISS referente &agrave;s NF-e?<a name="604" id="604"></a></strong><br />
              <br />
              O vencimento segue a legisla&ccedil;&atilde;o vigente do ISS. <br />
              <br />
              <hr />
              <strong>6.05. &Eacute; poss&iacute;vel emitir a guia de recolhimento ap&oacute;s o vencimento do ISS?</strong><a name="605" id="605"></a><br />
              <br />
              Sim. Cancele a guia vencida e emita nova guia com valor e vencimento atualizados. A nova guia ser&aacute; emitida com os acr&eacute;scimos legais. <br />
              <br />
              <hr />
              <strong>6.06. &Eacute; poss&iacute;vel cancelar guia de recolhimento emitida?</strong><a name="606" id="606"></a><br />
              <br />
              Sim, desde que o ISS n&atilde;o tenha sido recolhido. <br />
              <br />
              <hr />
              <strong>6.07. Os contribuintes sujeitos ao regime de recolhimento do ISS por estimativa dever&atilde;o emitir a guia de recolhimento no aplicativo da NF-e?</strong><a name="607" id="607"></a><br />
              <br />
              Sim. Todos os contribuintes que optarem ou forem obrigados &agrave; emiss&atilde;o de NF-e passam a recolher o ISS com base no movimento econ&ocirc;mico. <br />
              <br />
              <hr />
              <strong> 6.08. Os contribuintes que possuem regime especial de recolhimento do ISS, individual ou coletivo, dever&atilde;o emitir a guia de recolhimento no aplicativo da NF-e? </strong><a name="608" id="608"></a><br />
              <br />
              Sim. Todos os contribuintes que optarem ou forem obrigados &agrave; emiss&atilde;o de NF-e passam a recolher o ISS com base no movimento econ&ocirc;mico. <br />
              <br />
              <hr />
              <strong>6.09. As microempresas estabelecidas no Munic&iacute;pio, n&atilde;o enquadradas no Simples Nacional, dever&atilde;o emitir a guia de recolhimento no aplicativo da NF-e?<a name="609" id="609"></a></strong><br />
              <br />
              Sim. As microempresas estabelecidas no Munic&iacute;pio, n&atilde;o enquadradas no Simples Nacional, que optarem pela emiss&atilde;o de NF-e dever&atilde;o informar no campo &ldquo;Valor Total das Dedu&ccedil;&otilde;es&rdquo;, da NF-e, o valor correspondente ao percentual de desconto que fazem jus, nos termos da legisla&ccedil;&atilde;o espec&iacute;fica. <br />
              <br />
              <hr />
              <strong>6.10. As microempresas enquadradas no Simples Nacional dever&atilde;o emitir a guia de recolhimento no aplicativo da NF-e? </strong><a name="610" id="610"></a><br />
              <br />
              N&atilde;o. As microempresas enquadradas no Simples Nacional dever&atilde;o recolher tributos utilizando o Documento de Arrecada&ccedil;&atilde;o do Simples Nacional (DAS), conforme orienta&ccedil;&atilde;o dispon&iacute;vel em: http://www.receita.fazenda.gov.br/SimplesNacional. <br />
              <hr />
              <br />
              <span class="style2">07 - GERA&Ccedil;&Atilde;O DE CR&Eacute;DITO</span><br />
              <br />
              <strong>7.01. Quem far&aacute; jus ao cr&eacute;dito gerado pela NF-e?</strong><a name="701" id="701"></a><br />
              <br />
              O tomador dos servi&ccedil;os far&aacute; jus a cr&eacute;dito proveniente de parcela do ISS, devidamente recolhido, incidente sobre os servi&ccedil;os constantes deste Munic&iacute;pio. <br />
              <br />
              <hr />
              <strong>7.02. Quanto &eacute; gerado de cr&eacute;dito por NF-e? </strong><a name="702" id="702"></a><br />
              <br />
              S&atilde;o gerados, por NF-e, os seguintes cr&eacute;ditos: <br />
              <br />
              - <?php echo $CREDITO01; ?>% do ISS recolhido, no caso de pessoa f&iacute;sica; <br />
              <br />
              - <?php echo $CREDITO02; ?>% do ISS recolhido, no caso de pessoa jur&iacute;dica; <br />
              <br />
              - <?php echo $CREDITO03; ?>% do ISS recolhido, no caso de pessoa f&iacute;sica respons&aacute;vel por sua reten&ccedil;&atilde;o;<br />
              <br />
              - <?php echo $CREDITO04; ?>% do ISS recolhido, no caso de pessoa jur&iacute;dica respons&aacute;vel por sua reten&ccedil;&atilde;o. <br />
              <hr />
              <strong>7.03. Como o tomador de servi&ccedil;os ser&aacute; informado sobre os cr&eacute;ditos gerados?</strong><a name="703" id="703"></a><br />
              <br />
              O tomador de servi&ccedil;os poder&aacute; consultar o valor dos cr&eacute;ditos a que faz jus no Portal da NF-e, no endere&ccedil;o eletr&ocirc;nico do Municipio. <br />
              <br />
              <hr />
              <strong> 7.04. Quando o cr&eacute;dito fica dispon&iacute;vel para utiliza&ccedil;&atilde;o? </strong><a name="704" id="704"></a><br />
              <br />
              Os cr&eacute;ditos gerados s&atilde;o totalizados no final de cada exerc&iacute;cio, e ficam dispon&iacute;veis para utiliza&ccedil;&atilde;o no per&iacute;odo indicado pela Prefeitura Municipal. Nesse per&iacute;odo, o tomador de servi&ccedil;os dever&aacute; indicar os im&oacute;veis que far&atilde;o jus aos cr&eacute;ditos. <br />
              <br />
              <hr />
              <strong>7.05. Quem n&atilde;o far&aacute; jus ao cr&eacute;dito gerado?</strong><a name="705" id="705"></a><br />
              <br />
              Os seguintes tomadores de servi&ccedil;os n&atilde;o far&atilde;o jus ao cr&eacute;dito, mesmo que recebam uma NF-e: <br />
              <br />
              - as pessoas f&iacute;sicas e jur&iacute;dicas domiciliadas ou estabelecidas fora do territ&oacute;rio do Munic&iacute;pio;<br />
              <br />
              - os &oacute;rg&atilde;os da administra&ccedil;&atilde;o p&uacute;blica direta da Uni&atilde;o, dos Estados e do Munic&iacute;pio, bem como suas autarquias, funda&ccedil;&otilde;es, empresas p&uacute;blicas, sociedades de economia mista e demais entidades controladas direta ou indiretamente pela Uni&atilde;o, pelos Estados ou pelo Munic&iacute;pio;<br />
              <br />
              - os tomadores de servi&ccedil;os prestados pelas microempresas e empresas de pequeno porte optantes pelo Simples Nacional, institu&iacute;do pela Lei Complementar n&ordm; 123, de 14 de dezembro de 2006. <br />
              <br />
              <hr />
              <strong>7.06. Quais os procedimentos para se obter o cr&eacute;dito? </strong><a name="706" id="706"></a><br />
              <br />
              Ao contratar qualquer servi&ccedil;o constante da tabela divulgada pela Prefeitura Municipal, basta informar o CPF ou CNPJ ao prestador dos servi&ccedil;os emitente de NF-e. Automaticamente, o sistema lan&ccedil;ar&aacute; no CPF ou no CNPJ do tomador dos servi&ccedil;os o valor do cr&eacute;dito gerado, que estar&aacute; dispon&iacute;vel ap&oacute;s o pagamento do imposto constante da referida NF-e.
              
              O tomador de servi&ccedil;os dever&aacute; acessar o aplicativo da NF-e para consultar seus cr&eacute;ditos. <br />
              <br />
              <hr />
              <br />
              <strong>7.07. Emito Nota Fiscal Eletr&ocirc;nica (NF-e) e estou enquadrado no Simples Nacional. NF-e emitidas por mim dar&atilde;o ao tomador do servi&ccedil;o direito a cr&eacute;dito de parcela do ISS?<br />
                </strong><a name="707" id="707"></a><br />
              N&atilde;o. O tomador dos servi&ccedil;os n&atilde;o far&aacute; jus a cr&eacute;dito proveniente de parcela do ISS por NF-e emitidas por prestadores enquadrados no regime de tributa&ccedil;&atilde;o do Simples Nacional. <br />
              <br />
              <hr />
              <span class="style2">08 - UTILIZA&Ccedil;&Atilde;O DE CR&Eacute;DITO</span><br />
              <br />
              <strong>8.01. Quando o tomador de servi&ccedil;os dever&aacute; indicar os im&oacute;veis que aproveitar&atilde;o os cr&eacute;ditos gerados?<a name="801" id="801"></a> </strong><br />
              <br />
              No per&iacute;odo determinado pela Prefeitura Municipal, o tomador de servi&ccedil;os dever&aacute; indicar os im&oacute;veis que far&atilde;o jus ao cr&eacute;dito gerado. O sistema n&atilde;o assume automaticamente o im&oacute;vel do endere&ccedil;o do tomador como o beneficiado pelo desconto do IPTU. Se o tomador de servi&ccedil;os, detentor dos cr&eacute;ditos, n&atilde;o indicar nenhum im&oacute;vel para efeito de abatimento do IPTU, os cr&eacute;ditos ficar&atilde;o dispon&iacute;veis para o exerc&iacute;cio seguinte. <br />
              <br />
              <hr />
              <strong>8.02. Pode-se indicar im&oacute;vel em nome de terceiros?</strong><a name="802" id="802"></a><br />
              <br />
              Sim. N&atilde;o ser&aacute; exigido nenhum v&iacute;nculo legal do tomador do servi&ccedil;o com os im&oacute;veis por ele indicados. <br />
              <br />
              <hr />
              <strong>8.03. Pode-se indicar im&oacute;vel com d&eacute;bito de IPTU? </strong><a name="803" id="803"></a><br />
              <br />
              N&atilde;o poder&aacute; ser indicado nenhum im&oacute;vel que conste em d&eacute;bito com a Prefeitura Municipal na data da indica&ccedil;&atilde;o. <br />
              <strong><br />
                </strong>
              <hr />
              <strong>8.04. Como o cr&eacute;dito gerado poder&aacute; ser utilizado? </strong><a name="804" id="804"></a><br />
              <br />
              O cr&eacute;dito gerado poder&aacute; ser utilizado exclusivamente para abatimento de at&eacute; 50% do valor do IPTU do exerc&iacute;cio seguinte, relativo aos im&oacute;veis indicados. <br />
              <br />
              <hr />
              <strong>8.05. Como &eacute; calculado o valor do abatimento do IPTU? </strong><a name="805" id="805"></a><br />
              <br />
              O valor do abatimento ser&aacute; limitado a 50% do IPTU do exerc&iacute;cio corrente, referente a cada im&oacute;vel indicado pelo tomador dos servi&ccedil;os. <br />
              <br />
              <hr />
              <strong>8.06. Ap&oacute;s a utiliza&ccedil;&atilde;o do cr&eacute;dito, como ser&aacute; pago o saldo do IPTU?</strong><br />
              <br />
              O valor restante dever&aacute; ser recolhido na forma da legisla&ccedil;&atilde;o vigente do IPTU. Consulte, tamb&eacute;m, o item 8.07. <br />
              <br />
              <hr />
              <strong>8.07. O que acontece no caso de n&atilde;o pagamento do saldo restante do IPTU?</strong><a name="807" id="807"></a><br />
              <br />
              A n&atilde;o-quita&ccedil;&atilde;o integral do IPTU, dentro do respectivo exerc&iacute;cio de cobran&ccedil;a, implicar&aacute; a inscri&ccedil;&atilde;o do d&eacute;bito na d&iacute;vida ativa, desconsiderando-se qualquer abatimento obtido com o cr&eacute;dito indicado pelo tomador. Consulte, tamb&eacute;m, o item 8.10. <br />
              <br />
              <hr />
              <strong>8.08. Qual &eacute; a validade dos cr&eacute;ditos?</strong><a name="808" id="808"></a><br />
              <br />
              A validade dos cr&eacute;ditos ser&aacute; de 5 anos contados a partir do 1&ordm; dia do exerc&iacute;cio seguinte ao da emiss&atilde;o das respectivas NF-e. <br />
              <br />
              <hr />
              <strong>8.09. Quem n&atilde;o poder&aacute; utilizar o cr&eacute;dito gerado?</strong><a name="809" id="809"></a><br />
              <br />
              Os tomadores de servi&ccedil;os que tenham pend&ecirc;ncias quanto ao imposto junto &agrave; Prefeitura Municipal n&atilde;o poder&atilde;o utilizar os cr&eacute;ditos gerados. <br />
              <br />
              <hr />
              <strong>8.10. O tomador de servi&ccedil;os que estiver com pend&ecirc;ncias quanto ao imposto junto &agrave; Prefeitura Municipal perder&aacute; os cr&eacute;ditos gerados? <br />
                </strong><a name="810" id="810"></a><br />
              N&atilde;o. Uma vez regularizadas as pend&ecirc;ncias existentes na Prefeitura Municipal, os cr&eacute;ditos poder&atilde;o ser utilizados, obedecidos os prazos e demais condi&ccedil;&otilde;es do regulamento. <br />
              <br />
              <hr />
              <span class="style2">09 - ASPECTOS GERAIS</span><br />
              <br />
              <strong>9.01. Qual a garantia de que a NF-e recebida &eacute; aut&ecirc;ntica?</strong><a name="901" id="901"></a><br />
              <br />
              Na op&ccedil;&atilde;o &ldquo;Verifique a Autenticidade&rdquo;, dentro do menu &quot;Tomadores&quot;, dispon&iacute;vel no site da NF-e, basta digitar o n&uacute;mero da NF-e, o n&uacute;mero da inscri&ccedil;&atilde;o no CNPJ do emitente e o c&oacute;digo de verifica&ccedil;&atilde;o existente na NF-e. Se a NF-e for aut&ecirc;ntica, sua imagem ser&aacute; visualizada na tela do computador, podendo, inclusive, ser imprimida. <br />
              <strong><br />
                </strong>
              <hr />
              <strong>9.02. O programa da NF-e permite a importa&ccedil;&atilde;o de arquivo?</strong><a name="902" id="902"></a><br />
              <br />
              Consulte o item 10.2. <br />
              <br />
              <hr />
              <strong>9.03. O programa da NF-e permite a exporta&ccedil;&atilde;o de arquivo?<a name="903" id="903"></a></strong> <br />
              <br />
              Consulte o item 10.4. <br />
              <br />
              <strong>9.04. O prestador de servi&ccedil;os poder&aacute; cadastrar o contador para acessar o aplicativo NF-e?<a name="904" id="904"></a></strong><br />
              <br />
              Sim. O prestador de servi&ccedil;os poder&aacute; informar no link &ldquo;Contador&rdquo; o n&ordm; do CPF ou do CNPJ do contador. 
              
              Ao informar o n&ordm; do CPF ou do CNPJ do contador, o sistema preencher&aacute; automaticamente o nome ou raz&atilde;o social, se este possuir inscri&ccedil;&atilde;o junto &agrave; Prefeitura Municipal. Caso contr&aacute;rio, o campo ficar&aacute; em branco e o contador dever&aacute; preencher a ficha de cadastro para acesso ao sistema no menu &quot;Contadores&quot;. <br />
              <br />
              <hr />
              <strong>9.05. O contador poder&aacute; acessar o aplicativo NF-e de seus clientes?<a name="905" id="905"></a> </strong><br />
              <br />
              Sim,  o contador poder&aacute; acessar os dados de todos os contribuintes que o cadastraram como contador respons&aacute;vel. <br />
              <br />
              <hr />
              <span class="style2">10 - SISTEMA DA NF-e</span><br />
              <strong><br />
                10.01. Quem ter&aacute; acesso ao sistema NF-e?</strong><a name="1001" id="1001"></a><br />
              <br />
              Pessoa Jur&iacute;dica/F&iacute;sica inscrita poder&aacute; acessar todas as funcionalidades do sistema, 
              depois de obter autoriza&ccedil;&atilde;o para utilizar NF-e. 
              Pessoa Jur&iacute;dica/F&iacute;sica n&atilde;o inscrita  (estabelecida em outro Munic&iacute;pio) poder&aacute; consultar as NF-e recebidas. 
              
              Contador (PF ou PJ) poder&aacute; acessar informa&ccedil;&otilde;es de todos os contribuintes que o cadastraram como contador respons&aacute;vel. <br />
              <hr />
              <strong>10.02. O programa da NF-e permite a importa&ccedil;&atilde;o de arquivo?</strong> <a name="1002" id="1002"></a><br />
              <br />
              Sim. A NF-e possui um layout padr&atilde;o de arquivo que poder&aacute; ser gerado pelo sistema do contribuinte e importado no sistema NF-e, convertendo os dados do arquivo em Notas Fiscais Eletr&ocirc;nicas. O pr&oacute;prio sistema NF-e valida o arquivo. Ap&oacute;s a valida&ccedil;&atilde;o, o sistema solicita a confirma&ccedil;&atilde;o da grava&ccedil;&atilde;o. <br />
              <hr />
              <strong>10.03. Quem n&atilde;o possui autoriza&ccedil;&atilde;o para emiss&atilde;o de NF-e poder&aacute; testar a valida&ccedil;&atilde;o do arquivo?</strong><a name="1003" id="1003"></a> <br />
              <br />
              N&atilde;o. Nesse caso, o sistema n&atilde;o permitir&aacute; acesso a funcionalidade sem cadastramento de usu&aacute;rio. Para testar o arquivo &eacute; necess&aacute;rio acessar o sistema com um n&ordm; de CNPJ de empresa estabelecida e com permiss&atilde;o de acesso pelo Munic&iacute;pio. <br />
              <hr />
              <strong>10.04. O programa da NF-e permite a exporta&ccedil;&atilde;o de arquivo?</strong><a name="1004" id="1004"></a> <br />
              <br />
              Sim. A NF-e possui um layout padr&atilde;o de arquivo que poder&aacute; ser gerado pelo sistema, permitindo a transfer&ecirc;ncia eletr&ocirc;nica das informa&ccedil;&otilde;es referentes &agrave; NF-e da base de dados da Prefeitura da Cidade para o contribuinte. <br />
              <hr />
              <strong>10.05. Onde posso obter um documento contendo as instru&ccedil;&otilde;es e os layouts de importa&ccedil;&atilde;o e exporta&ccedil;&atilde;o de arquivos?</strong><a name="1005" id="1005"></a><br />
              <br />
              Nos menu &quot;Manuais de Ajuda&quot;, nos arquivos &quot;<strong>Layout de arquivo para convers&atilde;o de RPS em NF-e</strong>&quot; 
              
              
              
              e &quot;<strong>Layout de arquivo de exporta&ccedil;&atilde;o de NF-e</strong>&quot;.<br />
              <hr />
              <br />
              <strong>10.06. Existe um programa espec&iacute;fico para transmiss&atilde;o do arquivo?</strong><a name="1006" id="1006"></a><br />
              <br />
              N&atilde;o h&aacute; um programa espec&iacute;fico para transmiss&atilde;o dos lotes. O arquivo gerado pelo contribuinte poder&aacute; ser transmitido diretamente pelo sistema da NF-e.<br />
              <hr />
              <strong>10.07. Ap&oacute;s a transmiss&atilde;o do arquivo ser&aacute; gerado algum relat&oacute;rio?</strong><a name="1007" id="1007"></a> <br />
              <br />
              Sim. Ap&oacute;s o envio e valida&ccedil;&atilde;o do arquivo contendo todos os RPS emitidos, ser&aacute; apresentado um relat&oacute;rio resumindo o processo. Se n&atilde;o houver erros no arquivo, este poder&aacute; ser gravado e todos os RPS ser&atilde;o convertidos em NF-e imediatamente ap&oacute;s a grava&ccedil;&atilde;o. <br />
              <hr />
              <strong>10.08. Ap&oacute;s a transmiss&atilde;o do arquivo ser&aacute; disponibilizado algum arquivo de retorno? Neste arquivo posso obter os n&uacute;meros das NF-e geradas? <a name="1008" id="1008"></a></strong><br />
              <br />
              Sim. Ap&oacute;s o envio, valida&ccedil;&atilde;o e grava&ccedil;&atilde;o do arquivo contendo todos os RPS emitidos, basta acessar o menu &quot;Importar RPS&quot;, escolher a op&ccedil;&atilde;o &quot;NF-e emitidas&quot; e informar o per&iacute;odo desejado. Em seguida, o sistema ir&aacute; gerar um relat&oacute;rio. Esse relat&oacute;rio relaciona o n&uacute;mero da NF-e gerada com o n&uacute;mero do RPS enviado. Poder&aacute; ser gerado a qualquer momento, acessando o menu &quot;Importar RPS&quot; e escolhendo o per&iacute;odo desejado e a op&ccedil;&atilde;o &quot;NF-e Emitidas&quot;. <br />
              <hr />
              <strong>10.09. O que ocorre no caso de transmiss&atilde;o de arquivo contendo RPS j&aacute; transmitido anteriormente? </strong><a name="1009" id="1009"></a><br />
              <br />
              Caso um RPS j&aacute; convertido em NF-e seja novamente transmitido em arquivo, o sistema ir&aacute; comparar o RPS convertido com o atual. Se n&atilde;o houver altera&ccedil;&atilde;o, o RPS atual ser&aacute; ignorado e n&atilde;o ser&aacute; processado.
              
              Caso contr&aacute;rio, a NF-e anterior ser&aacute; cancelada automaticamente e o RPS atual ser&aacute; processado e convertido em uma nova NF-e. <br />
              <hr />
              <strong>10.10. O que ocorre no caso de transmiss&atilde;o de arquivo contendo RPS j&aacute; convertido &ldquo;on line&rdquo; em NF-e? </strong><a name="1010" id="1010"></a><br />
              <br />
              Caso um RPS j&aacute; convertido &ldquo;on line&rdquo; em NF-e seja enviado em arquivo, o RPS enviado ser&aacute; ignorado e n&atilde;o ser&aacute; processado. <br />
              <hr />
              <strong>10.11. O que ocorre no caso de convers&atilde;o &ldquo;on line&rdquo; de RPS j&aacute; convertido em NF-e por meio de transmiss&atilde;o de arquivo?</strong><a name="1011" id="1011"></a><br />
              <br />
              Neste caso, a convers&atilde;o &ldquo;on line&rdquo; do RPS s&oacute; ser&aacute; poss&iacute;vel ap&oacute;s o cancelamento da NF-e correspondente ao RPS convertido. <br />
              <hr />
              <strong> 10.12. Qual o nome do arquivo de transmiss&atilde;o dos RPS? </strong><a name="1012" id="1012"></a><br />
              <br />
              O arquivo contendo os RPS enviados para convers&atilde;o em NF-e poder&aacute; ser &quot;batizado&quot; com qualquer nome. <br />
              <hr />
              <strong>10.13. O que fazer em caso de erro no arquivo de transmiss&atilde;o dos RPS?<a name="1013" id="1013"></a></strong><br />
              <br />
              Em caso de erro na valida&ccedil;&atilde;o do arquivo, o usu&aacute;rio dever&aacute; verificar o relat&oacute;rio gerado e ap&oacute;s corre&ccedil;&atilde;o gerar novo arquivo. <br />
              <hr />
              <strong>10.14. Ap&oacute;s o envio do arquivo, em quanto tempo o RPS ser&aacute; convertido em NF-e?</strong><a name="1014" id="1014"></a><br />
              <br />
              A gera&ccedil;&atilde;o de NF-e, ap&oacute;s a importa&ccedil;&atilde;o do arquivo de RPS, &eacute; imediata. <br />
              <hr />
              <br />
              <strong>10.15. &Eacute; poss&iacute;vel a integra&ccedil;&atilde;o em tempo real do sistema de faturamento da empresa com o sistema da NF-e?</strong><a name="1015" id="1015"></a><br />
              <br />
              Atualmente, n&atilde;o. Somente ap&oacute;s a implanta&ccedil;&atilde;o do aplicativo Web Service, que est&aacute; em desenvolvimento, ser&aacute; poss&iacute;vel integrar em tempo real o sistema de faturamento da empresa com a NF-e, sem a necessidade de envio de lote.</td>
          </tr>
        </table>
          <br />
          <br /></td>
      </tr>
      <tr>
        <td height="1"></td>
      </tr>
      <tr>
        <td height="5" align="left" bgcolor="#859CAD"></td>
      </tr>
    </table></td>
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
