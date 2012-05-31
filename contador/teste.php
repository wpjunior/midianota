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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="en" lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>e-Nota
  <!--<title>Msg Box - by tmferreira</title>-->
  <title>e-Nota</title>
  <style><!--
   * {
    margin: 0;
    padding: 0;
    list-style: none;
    font-family: Verdana, Arial, Helvetica, Sans-Serif;
    color: black;
    font-size: 12px;
    text-decoration: none;
   }
   #msgbox {
    border: 1px solid #072A66;
    position: absolute;
    left: 50%;
    top: 200px;;
    margin-left: -150px;
    width: 300px;
    text-align: center;
   }
   #msgbox.hidden {
    display: none;
   }
   #msgbox.visible {
    display: block;
   }
   #msgbox #titulo {
    border: 1px solid #FFF;
    background: url(tile_cat.gif) repeat-x;
    border-bottom: 1px solid #5176B5;
    height: 25px;
    text-align: left;
    padding-left: 3px;
   }
   #msgbox #titulo #tit_fechar {
    float: right;
    padding: 3px 3px 0 0;
   }
   #msgbox #titulo #tit_fechar a{
    font-size: 13px;
    color: #FFF;
    font-weight: bold;
   }
   #msgbox #titulo #tit p{
    font-size: 15px;
    font-weight: bold;
    color: #FFF;
    padding: 3px 0 0 0;
   }
   #msgbox #conteudo {
    background: #F9F9F9;
   }
   #msgbox #conteudo #mensagem {
    border: 1px solid #CCC;
    margin: 10px;
    overflow: auto;
    padding: 5px;
   }
   #msgbox #conteudo #mensagem p {
    color: #666;
   }
   #msgbox #conteudo #botoes {
    border: 1px solid #CCC;
    margin: 0 10px 10px 10px;
    padding: 5px;
   }
   #msgbox #conteudo #botoes p.hidden {
    display: none;
   }
   #msgbox #conteudo #botoes p.visible {
    display: block;
   }
   #msgbox #conteudo #botoes a {
    padding: 2px 10px 2px 10px;
    margin: 0 25px 0 25px;
    border: 1px solid #AAA;
    background: #FFF;
   }
  --></style>
  <script type="text/javascript"><!--
   function $(e) {
    return document.getElementById(e);
   }
   function addEvent(obj, evType, fn) { //Função adaptada da original de Christian Heilmann, em http://www.onlinetools.org/articles/unobtrusivejavascript/chapter4.html
    if (typeof obj == "string") {
     if (null == (obj = document.getElementById(obj))) {
      throw new Error("Elemento HTML não encontrado. Não foi possível adicionar o evento.");
     }
    }
    if (obj.attachEvent) {
     return obj.attachEvent(("on" + evType), fn);
    } else if (obj.addEventListener) {
     return obj.addEventListener(evType, fn, true);
    } else {
     throw new Error("Seu browser não suporta adição de eventos.");
    }
   }
   function init() {
    /*
    msgbox_show('Título', 'Data inválida!', 'alert'); //alert com função padrão
    msgbox_show('Título', 'Data inválida!', 'alert', funcao1); //alert passando a função que será executada no botão OK
    msgbox_show('Título', 'Data inválida!', 'confirm'); //confirm com botões padrão
    msgbox_show('Título', 'Data inválida!', 'confirm', funcao1); //confirm passando a função que será executada no botão SIM e deixando o botão NÃO padrão
    msgbox_show('Título', 'Data inválida!', 'confirm', funcao1, funcao2); //confirm passando a função que será executada no botão SIM (funcao1) e no botão NÃO (funcao2)
    */
    msgbox_show('Título', 'Data inválida!', 'alert'); //alert com função padrão
    $('fechar').href = '#';
    addEvent('fechar', 'click', msgbox_hide);
   }
   function msgbox_hide() {
    $('msgbox').className = 'hidden';
   }
   function msgbox_show(titulo, msg, tipo) {
    $('msgbox').className = 'visible';
    $('ptit').firstChild.data = titulo;
    $('pmsg').firstChild.data = msg;
    if (tipo == 'alert') {
     $('pOk').className = 'visible';
     $('pSN').className = 'hidden';
     $('btnOk').href = '#';
     if (arguments[3] == undefined) {
      addEvent('btnOk', 'click', msgbox_hide);
     } else {
      addEvent('btnOk', 'click', arguments[3]);
     }
    } else if (tipo == 'confirm') {
     $('pOk').className = 'hidden';
     $('pSN').className = 'visible';
     $('btnSim').href = '#';
     $('btnNao').href = '#';
     if (arguments[3] == undefined) {
      addEvent('btnSim', 'click', msgbox_hide);
     } else {
      addEvent('btnSim', 'click', arguments[3]);
      if (arguments[4] == undefined) {
       addEvent('btnNao', 'click', msgbox_hide);
      } else {
       addEvent('btnNao', 'click', arguments[3]);
      }
     }
    } else {
     $('msgbox').className = 'hidden';
    }
   }
   addEvent(window, 'load', init);
  --></script>
</head>
<body>
  <div id="msgbox" name="msgbox" class="hidden">
   <div id="titulo" name="titulo">
    <span id="tit_fechar" name="tit_fechar">
     <p><a href="" name="fechar" id="fechar" title="Fechar">[X]</a></p>
    </span>
    <span id="tit" name="tit">
     <p id="ptit" name="ptit">Título</p>
    </span>
   </div>
   <div id="conteudo" name="conteudo">
    <div id="mensagem" name="mensagem">
     <p id="pmsg" name="pmsg">Mensagem</p>
    </div>
    <div id="botoes" name="botoes">
     <p id="pOk" name="pOk" class="hidden"><a href="" name="btnOk" id="btnOk" title="OK">Ok</a></p>
     <p id="pSN" name="pSN" class="hidden"><a href="" name="btnSim" id="btnSim" title="Sim">Sim</a><a href="" name="btnNao" id="btnNao" title="Não">Não</a></p>
    </div>
   </div>
  </div>
</body>
</html>