
//drag n drop de div ----------------------------------------------------
//by tmferreira - http://www.webly.com.br/tutorial/javascript-e-ajax/7045/drag-and-drop.htm
//corrigida 30/01/2008 por Micox - http://forum.ievolutionweb.com/index.php?s=&showtopic=7045&view=findpost&p=139679

var objSelecionado = null;
var mouseOffset = null;
function addEvent(obj, evType, fn) {
//Função adaptada da original de Christian Heilmann, em
//http://www.onlinetools.org/articles/unobtrusivejavascript/chapter4.html
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
  throw new Error("Seu browser não suporta adição de eventos. Senta, chora e pega um navegador mais recente.");
}
}
function mouseCoords(ev){
    if(typeof(ev.pageX)!=="undefined"){
      return {x:ev.pageX, y:ev.pageY};
    }else{
        return {
          x:ev.clientX + document.body.scrollLeft - document.body.clientLeft,
          y:ev.clientY + document.body.scrollTop  - document.body.clientTop
        };
    }
}
function getPosition(e, ev){
    var ev = ev || window.event;
    if(e.constructor==String){ e = document.getElementById(e);}
    var left = 0, top  = 0;
    var coords = mouseCoords(ev);    

    while (e.offsetParent){
      left += e.offsetLeft;
      top  += e.offsetTop;
      e     = e.offsetParent;
    }
    left += e.offsetLeft;
    top  += e.offsetTop;
    return {x: coords.x - left, y: coords.y - top};
}

function dragdrop(local_click, caixa_movida) {
//local click indica quem é o cara que quando movido, move o caixa_movida
    if(local_click.constructor==String){ local_click = document.getElementById(local_click);}
    if(caixa_movida.constructor==String){ caixa_movida = document.getElementById(caixa_movida);}

    local_click.style.cursor = 'move';
    if(!caixa_movida.style.position || caixa_movida.style.position=='static'){
        caixa_movida.style.position='relative'
    }
    local_click.onmousedown = function(ev) {
        objSelecionado = caixa_movida;
        mouseOffset = getPosition(objSelecionado, ev);
    };
    document.onmouseup = function() {
        objSelecionado = null;
    }
    document.onmousemove = function(ev) {
        if (objSelecionado) {
            var ev = ev || window.event;
            var mousePos = mouseCoords(ev);
            var pai = objSelecionado.parentNode;
            objSelecionado.style.left = (mousePos.x - mouseOffset.x - pai.offsetLeft) + 'px';
            objSelecionado.style.top = (mousePos.y - mouseOffset.y - pai.offsetTop) + 'px';
            objSelecionado.style.margin = '0px';
            return false;
        }
    }
}
