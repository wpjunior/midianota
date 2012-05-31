
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



/**
 * Parametros em objeto com chaves separados por virgula
 * a ordem dos parametros não altera o resultado, e os opcionais não precisam ser chamados
 * 
 * @url: string, obrigatorio
 * @tipo: string, GET ou POST, padrao GET
 * @parametros: string, se for POST, exemplo "var=1&cont=2&nome=alguem"
 * @espera: function, o que vai acontecer enquanto espera a resposta, se vazio não acontece nada
 * @sucesso: function, o que vai acontecer quando retornar o resultado, a resposta esta na variavel global respostaAjax
 * @erro: function, em caso de erro executa essa funcao
 * @assincrona: boolean, se for false o browser vai esperar resposta, usuario nao podera mexer, padrao TRUE;
 *
 *exemplo 
 * ajax({
 * 	 url:'exemplo.php',
 * 	 sucesso:function(){
 * 		alert(respostaAjax);
 * 	 }
 * });
 */
 
//-------------------------------Janelas com abas com jquery
function MontaDivAbas()
{
	$(function() {
		$('#container-1').tabs();
		$('#container-2').tabs(2);
		$('#container-3').tabs({ fxSlide: true });
		$('#container-4').tabs({ fxFade: true, fxSpeed: 'fast' });
		$('#container-5').tabs({ fxSlide: true, fxFade: true, fxSpeed: 'normal' });
		$('#container-6').tabs({
			fxFade: true,
			fxSpeed: 'fast',
			onClick: function() {
				alert('onClick');
			},
			onHide: function() {
				alert('onHide');
			},
			onShow: function() {
				alert('onShow');
			}
		});
		$('#container-7').tabs({ fxAutoHeight: true });
		$('#container-8').tabs({ fxShow: { height: 'show', opacity: 'show' }, fxSpeed: 'normal' });
		$('#container-9').tabs({ remote: true });
		$('#container-10').tabs();
		$('#container-11').tabs({ disabled: [3] });
	
		$('<p><a href="#">Disable third tab<\/a><\/p>').prependTo('#fragment-28').find('a').click(function() {
			$(this).parents('div').eq(1).disableTab(3);
			return false;
		});
		$('<p><a href="#">Activate third tab<\/a><\/p>').prependTo('#fragment-28').find('a').click(function() {
			$(this).parents('div').eq(1).triggerTab(3);
			return false;
		});
		$('<p><a href="#">Enable third tab<\/a><\/p>').prependTo('#fragment-28').find('a').click(function() {
			$(this).parents('div').eq(1).enableTab(3);
			return false;
		});
	
	});
}
//-------------------------------Janelas com abas com jquery           Fim

function DivMenuAbas(cod){	
	//$('#DivAbas').html('carregando');	
		$.ajax({			
			url: "../livro/escolha_docs.ajax.php?cod="+cod,			
			success: function(msg){
			  $('#DivAbas').html(msg);		
			  MontaDivAbas()
			}
	    });			
}

function msg_alert(msg){
	var func = function(){
		alert(msg);
	};
	loadEvent(func);
}

function loadEvent(func){
	//window.attachEvent('onload',func);
	if(window.onload)
		var load = window.onload || null;
	window.onload = function(){
		if(load)
			load();
		func();
	};
	//alert(func);
}
 
 
function ajax(p) {	
	if(typeof p.url!=="string")//se nao for string retorna
		return;
	var url = p.url;
	var tipo = p.tipo || "GET"; //se nao for informado usa o padrao GET
	var param = p.parametros || null; // se nao for informado não sera utilizado
	var a = p.assincrona || true; // se nao for informado padrao TRUE
	var espera = p.espera;
	var sucesso = p.sucesso;
	var erro = p.erro;
	
	var req;
	// Verificar o Browser
	// Firefox, Google Chrome, Safari e outros
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	}
	// Internet Explorer
	else if (window.ActiveXObject) {
		req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	req.open(tipo, p.url, a);

	// Quando o objeto recebe o retorno, chamamos a seguinte função;
	req.onreadystatechange = function() {

		// enquanto carrega
		if (req.readyState == 1&& espera) {
			espera();
		}
		// Verifica se o Ajax realizou todas as operações corretamente
		if (req.readyState == 4 && req.status == 200) {
			// Resposta retornada pelo ajax
			respostaAjax="";
			respostaAjax = req.responseText;
			if(sucesso)
				sucesso();
		}
		if(req.readyState == 4 && req.status == 404 && erro)
			erro();
	};
	req.send(param);
}


//  FUNCOES GERADAS POR ULTIMO ------------------------------------------------------------------------------------------------------------------>

/**Função desabilitaSN
*Parametros :
*obj  = campo de cnpj/cpf
*idSN = id do campo checkbox do simples nacional
*lbTexto = Label ou alguma tag que tenha o texto descritivo dentro ex: <font>Texto aqui</font>
*A função no evento onblur conta quantos caracteres foi passado para verificar se tem RPA, se tiver
*desabilita o campo simples nacional e muda a cor do texto
*/
function desabilitaSN(obj,idSN,lbTexto){
	if(obj.value.length == 14){
		if(document.getElementById(idSN).checked == true){
			document.getElementById(idSN).checked = false;
		}
		document.getElementById(idSN).disabled = true;
		document.getElementById(lbTexto).style.color = '#999999';
	}else{
		document.getElementById(idSN).disabled = false;
		document.getElementById(lbTexto).style.color = '#000000';
	}
}


function mudarpagina(valor,hdpag,url,form,retorno){
	var hdpagina  = document.getElementById(hdpag).value;
	if(valor == 'p'){
		hdpagina = parseInt(hdpagina) + 1;
	}else if(valor == 'a'){
		hdpagina = parseInt(hdpagina) - 1;
	}else if(typeof valor == "int"){
		hdpagina = valor;		
	}
	
	document.getElementById(hdpag).value = '';
	document.getElementById(hdpag).value = hdpagina;
	acessoAjax(url,form,retorno);
}

function cancelarNfe(codigo,nome,url,form,retorno,hdcanc){
	if(confirm('Deseja cancelar a declaracao N°'+codigo+' de '+nome+'?')){
		document.getElementById(hdcanc).value = codigo;
		acessoAjax(url,form,retorno);
		alert('Declaração cancelada!');
	}
}

function id(elementId){//atalho para pegar o elemento por ID
	return document.getElementById(elementId);
}

var hdtd = ''; //variavel que será usada na funçao VisualizarNovaLinha()
function VisualizarNovaLinha(cod,area,obj,url){
	if(hdtd){         										//verifica se o hidden da td ja tem valor
		var idtd = hdtd;									//recebe o valor da do input hidden com o id da td e manda para a variavel
		if(document.getElementById(idtd)){
			document.getElementById(idtd).innerHTML = '';	//define que o elemento do HTML receba vazio para que nao haja mais de um aberto
		}
	}
	hdtd = area;
	var form = obj.form.id;
	var url_parametro = url.split("?");
	if(url_parametro[1]){ 
		var nova_url = url_parametro[1].split("=");
		acessoAjax(url_parametro[0]+'?hdcod='+cod+'&'+nova_url[0]+'='+nova_url[1]+'&a=a',form,area);
	}else{
		acessoAjax(url_parametro[0]+'?hdcod='+cod+'&a=a',form,area);     //gera o acessoAjax
	}
}



//aplica as mascaras de acordo com o nome e pega o input que estiver com o focus
var focused;
onload=function() {
	for(var c=0;c<document.forms.length;c++) {
		var el = document.forms[c].elements;
		for(var i=0;i<el.length;i++) {
			el[i].onfocus=function(){focused=this;};
			if(el[i].id){
				if(el[i].id.substring(0,7)=='txtCNPJ'){
					el[i].onkeyup= function() {CNPJCPFMsk(this);};
				}
			}
			if(el[i].name){
				if (el[i].name.substring(0,8)=='txtValor'||
					el[i].name.substring(0,7)=='txtBase') 
				{
					el[i].onkeyup= function() {MaskMoeda(this);};
					el[i].onfocus= function() {this.select();};
					el[i].onclick= function() {setCursor(this,this.value.length);};
					//el[i].onkeydown=function() {return NumbersOnly(event);};
				}
				if (el[i].name.substring(0,7)=='txtCNPJ' || 
					el[i].name.substring(0,7)=='txtCnpj' ||
					el[i].name.substring(0,6)=='txtCpf' || 
					el[i].name.substring(0,6)=='txtCPF' ||
					el[i].name.substring(0,6)=='txtTomadorCNPJ') 
				{
					el[i].onkeyup= function() {CNPJCPFMsk(this);};
					//el[i].onkeydown= function() {NumberOnly(event);};
				}
				if (el[i].name.substring(0,7)=='txtData') {
					el[i].onkeyup= function() {MaskData(this);};
				}
				if (el[i].name.substring(0,7)=='txtFone') {
					el[i].onkeyup= function() {MaskFone(this);};
				}
				if (el[i].name.substring(0,6)=='txtCEP') {
					el[i].onkeyup= function() {MaskCEP(this);};
				}
				if (el[i].name.substring(0,13)=='txtTomadorCEP') {
					el[i].onkeyup= function() {MaskCEP(this);};
				}
				if(el[i].name == 'txtSenha'){
					var elemento = el[i];
					criaSpanSenha(elemento);
				}
			}
		}
	}
};


function ValidaSenha(campo1,campo2){
	var senha = document.getElementById(campo1).value;
	var confirmacao = document.getElementById(campo2).value;
	if(senha){
		if(confirmacao){
			if(senha == confirmacao){
				if(senha.length < 5){
					alert('Sua senha deve ter entre 5 e 15 caracteres');
					document.getElementById(campo1).focus();
					return false;
				}
			}else{
				alert('As senhas não conferem');
				document.getElementById(campo1).value = '';
				document.getElementById(campo2).value = '';
				document.getElementById(campo1).focus();
				return false;
			}
		}else{
			alert('Digite a confirmação da senha');
			document.getElementById(campo2).focus();
			return false;
		}
	}else{
		alert('Digite uma senha!');	
		document.getElementById(campo1).focus();
		return false;
	}
	return true;
}

/*function ValidaCNPJ(obj,idretorno){
	var form = obj.form.id;
	acessoAjax('inc/verifica_cnpj.ajax.php',form,idretorno);
}*/
//Função que verifica o CNPJ no banco de dados
function ValidaCNPJ(obj,idretorno){
	var form = obj.form.id;
	var cnpj = id('txtCNPJ').value;
	ajax({
		url:'inc/verifica_cnpj.ajax.php?txtCNPJ='+cnpj+'&a=a',
		sucesso: function(){
			id(idretorno).innerHTML = respostaAjax;	
		}
	});
//	acessoAjax('inc/verifica_cnpj.ajax.php?txtCNPJ='+cnpj+'&a=a',form,idretorno);
}


//Função que valida se o CNPJ foi inserido corretamente ou não
function ConfereCNPJ(obj){
	if(document.getElementById('hdCNPJ')){
		alert('Verifique os campos!');
		return false;
	}else{
		return true;	
	}
}

function criaSpanSenha(elemento) {
	if(!id('span_forca')){
		var span = document.createElement('span');
		span.setAttribute('id','span_forca');
		var text = document.createTextNode('');
		span.appendChild(text);
		var conteudo =  elemento.parentNode;  // document.getElementById('conteudo');
		conteudo.appendChild(span);
	}
}

/**Função verificaForca
*Parametro:
*obj = campo de tipo senha
*Esta função verifica a quantidade de caracteres e a força da senha inserida pelo usuario
*/
function verificaForca(obj) {
	var valor    = obj.value;
	var Numeros  = /[0-9]/;
	var Letras   = /[a-z]/;
	var Especial = /[!,@,#,$,%,^,&,*,?,_,~]/;
	var LetrasM  = /[A-Z]/;
	var cont     = 0;
	var msg      = "";
	
	if (Numeros.test(valor))  { cont++ }
	if (Letras.test(valor))   { cont++ }
	if (Especial.test(valor)) { cont++ }
	if (LetrasM.test(valor))  { cont++ }
	
	if (valor.length >= 5) {
		switch (cont) {
			case 1:  msg = "<b>Nivel: <font color=\"#009933\">Fraco</font></b>";  break;
			case 2:  msg = "<b>Nivel: <font color=\"#FFFF00\">Medio</font></b>";  break;
			case 3:  msg = "<b>Nivel: <font color=\"#FF0000\">Forte!</font></b>"; break;
			case 4:  
				if(valor.length >= 10){
					msg = "<b>Nivel: <font color=\"#FF0000\">Muito Forte!</font></b>";
				}else{
					msg = "<b>Nivel: <font color=\"#FF0000\">Forte!</font></b>";
				}
			   break;
			default: msg = "<font color=\"#FF0000\"><b>Nivel: Desculpe-nos ocorreu um erro, por favor contate o responsavel</b></font>"; break;
		}
	}else{
		msg = "Minimo de 5 caracteres";
	}
	if(document.getElementById('span_forca')){
		document.getElementById('span_forca').innerHTML = msg;
	}
}
 


function setCursor(obj, pos) {// coloca o cursor no fim da selecao 
    if(obj.createTextRange) { //IE
        var range = obj.createTextRange(); 
        range.move("character", pos); 
        range.select(); 
    } else if(obj.selectionStart) { // Firefox, chrome etc
        obj.focus(); 
        obj.setSelectionRange(pos, pos); 
    } 
}

function Trim(str){
	return str.replace(/^\s+|\s+$/g,"");
}

function acessoAjax(url,form,retorno,retorna){	  	

	form = document.getElementById(form);
	var parametros='';
	var req;
	// Verificar o Browser	
	// Firefox, Google Chrome, Safari e outros
	if(window.XMLHttpRequest) {
	   req = new XMLHttpRequest();
	}	
	// Internet Explorer
	else if(window.ActiveXObject) {
	   req = new ActiveXObject("Microsoft.XMLHTTP");
	}	
	//tratamento dos parametros	
	for(var i=0;i<form.length;i++)
	{	  
	  
		if((form.elements[i].type !='button')&&(form.elements[i].type !='submit'))
		{
			if(parametros)
			{
				parametros+='&';
			}	 
			if(form.elements[i].type=='radio'||form.elements[i].type=='checkbox')
			{
				if(form.elements[i].checked)
				{
					parametros += form.elements[i].name+'='+form.elements[i].value;  
				}
			}
			else
			{
				parametros += form.elements[i].name+'='+form.elements[i].value;
			} 
		}
	}	
   	var url= url+'?'+parametros;	
	req.open("Get", url, true);		 
	// Quando o objeto recebe o retorno, chamamos a seguinte função;
	req.onreadystatechange = function() {			
		if(req.readyState == 1) {				
  	      //document.getElementById('').innerHTML = '<font color="gray">Verificando...</font>';
		  if(!retorna)
		  {
		   document.getElementById(retorno).innerHTML = 'Pesquisando...';
		  }
		  
		}
		
		// Verifica se o Ajax realizou todas as operações corretamente (essencial)
		if(req.readyState == 4 && req.status == 200) {			
		// Resposta retornada pelo validacao.php
		var resposta = Trim(req.responseText);			
		// Abaixo colocamos a resposta na div do campo que fez a requisição			    	     
		 	document.getElementById(retorno).innerHTML = resposta;
		}
		
		 
	};		 
	req.send(null);
}


	function foo(){}
	String.prototype.replaceAll = function(de, para){
		var str = this;
		var pos = str.indexOf(de);
		while (pos > -1){
			str = str.replace(de, para);
			pos = str.indexOf(de);
		}
		return (str);
	};
	
	function MaskData(campo){
		var data = campo.value+'';
		data = data.replaceAll('/','');		
		var cont = 0;
		var teste='';
		while(cont < data.length) {			
			if(!(data.charAt(cont)>=0 && data.charAt(cont)<=9)){
				teste+='';					
			}
			else
			{
				teste+=data.charAt(cont);			 
			}
			cont++;
		}
		data = teste;				
		var tam = data.length;
		if ( tam >= 3 && tam <= 4)
			campo.value = data.substring(0,2)+'/'+data.substring(2);
		else if ( tam >= 5)
			campo.value = data.substring(0,2)+'/'+data.substring(2,4)+'/'+data.substring(4,8);
		else
			campo.value=data;
	}
	
	function MaskFone(campo){
		var fone = campo.value+'';	
		fone = fone.replaceAll(' ','');
		var cont = 0;
		var teste='';
		while(cont < fone.length) {			
			if(!(fone.charAt(cont)>=0 && fone.charAt(cont)<=9)){
				teste+='';					
			}
			else
			{
				teste+=fone.charAt(cont);			 
			}
			cont++;
		}
		fone = teste;				
		var tam = fone.length;
		if ( tam >= 3 && tam <= 6)
			campo.value = '('+fone.substring(0,2)+') '+fone.substring(2);
		else if ( tam >= 7)
			campo.value = '('+fone.substring(0,2)+') '+fone.substring(2,6)+'-'+fone.substring(6,10);
		else if ( tam == 0)
			campo.value = '';
		else
			campo.value = '('+fone;
	}
	
	
	function MaskCEP(campo){
		var data = campo.value+'';
		data = data.replaceAll('/','');		
		var cont = 0;
		var teste='';
		while(cont < data.length) {			
			if(!(data.charAt(cont)>=0 && data.charAt(cont)<=9)){
				teste+='';					
			}
			else
			{
				teste+=data.charAt(cont);			 
			}
			cont++;
		}
		data = teste;				
		var tam = data.length;
		if ( tam >= 6)
			campo.value = data.substring(0,5)+'-'+data.substring(5,8);
		else
			campo.value=data;
	}
	
	
	
	function MaskPct(campo){
		var valor = document.getElementById(campo).value;
		if(valor=="")
			valor = 0;
		valor = parseFloat(valor);
		document.getElementById(campo).value =  number_format(valor, 2, ".","");
	}
	
	function MaskMoeda(campo){
		campo.value = MoedaToDec(campo.value);
		campo.value = DecToMoeda(campo.value);		
	}
	
	function MoedaToDec(valor)
	{
		if (valor=='')
			valor = '0';
		valor = valor.replaceAll(',','');
		valor = valor.replaceAll('.','');
		valor = parseFloat(valor);
		valor/=100;
		return valor;
	}
	
	function DecToMoeda(valor){
		if(valor=="")
			valor = 0;
		valor = parseFloat(valor);
		return number_format(valor, 2, ",",".");
	}
	function DecToMoeda2(valor)
	{
		if (valor=='')
			valor = '0';
		valor = parseFloat(valor);
		//alert(valor + '-' + valor1);
		//valor*=100;
		valor = (Math.round(valor*100))
		//valor = toString(valor);
		valor = '' + valor;
		tam = valor.length;
		//alert(valor+' - '+tam);
		if (tam==1)
			result = '0,0'+valor;
		if (tam==2)
			result = '0,'+valor;
		if (tam>2)
		{
			inteiro = valor.substring(0,tam-2);
			resto = valor.substring(tam-2);
			//alert(inteiro +' - '+ resto);
			result = inteiro + ',' + resto;	
		}
		if (tam>5)
		{
			inteiro = valor.substring(0,tam-2);
			resto = valor.substring(tam-2);
			inteiro1 = inteiro.substring(0,inteiro.length-3);
			inteiro2 = inteiro.substring(inteiro.length-3);
			//alert(inteiro+ ' - ' + inteiro1+ ' - ' + inteiro2 +' - '+ resto);
			result = inteiro1 + '.' + inteiro2 + ',' + resto;	
		}
		if (tam>8)
		{
			inteiro = valor.substring(0,tam-2);
			resto = valor.substring(tam-2);
			inteiro1 = inteiro.substring(0,inteiro.length-3);
			inteiro2 = inteiro.substring(inteiro.length-3);
			
			inteiro0 = inteiro1.substring(0,inteiro1.length-3)
			inteiro1 = inteiro1.substring(inteiro1.length-3)
			result = inteiro0 + '.' + inteiro1 + '.' + inteiro2 + ',' + resto;
		}
		
		return result;
	}
	
	function MoedaToDecimalSubmit(inputs)
	{
    	var aux;
        var falso=0;
		var aux= inputs.split("|");
		var valor;
		for(cont=0;cont<aux.length;cont++)
		{		
		  valor=document.getElementById(aux[cont]).value.replaceAll('.','');
  		  valor= valor.replace(',','');
		  valor = parseFloat(valor);
          valor /= 100;
		  document.getElementById(aux[cont]).value=valor;
		}
	}
	
	function ValidaFormulario(inputs,mensagem)
	{
		var msg = mensagem === undefined ? "Favor preencher todos os campos obrigatórios!" : mensagem;
    	var aux;
        var falso=0;
		var aux= inputs.split("|");		
		for(cont=0;cont<aux.length;cont++){
			if(document.getElementById(aux[cont])){
				if(document.getElementById(aux[cont]).value ==''){
					alert(msg);
					document.getElementById(aux[cont]).focus();
					return false;
				}
			}else{
				//alert('Verifique os campos!' + aux[cont]);	
				//return false;
			}
		}
		return true;
	}
	
	function ValidaFormMsg(inputs,mensagem)
	{
		
    	var aux;
        var falso=0;
		var aux= inputs.split("|");		
		for(cont=0;cont<aux.length;cont++)
		{
		   
           if(document.getElementById(aux[cont]).value =='')
		   {
			 falso=1;
			 if(falso ==1)		
		     {
		      alert(mensagem);
			  document.getElementById(aux[cont]).focus();
		      return false;
			 }
		   }
		}		
		return true;
	}
	
	//Funcao pára limpar os campos da tabela
	function LimpaFormulario(inputs)
	{
		var aux;
		var aux= inputs.split("|");		
		for(cont=0;cont<aux.length;cont++)
			{
			   document.getElementById(aux[cont]).value = "";
			}
		return true;
	}

	
	// Funcao para corrigir os valores invalidos de percentagem		
	function ControlePercentatagem(input)
	{
	  if(document.getElementById(input).value > 100)
	  {
		document.getElementById(input).value=100;
	  }
	  else	  
		if(document.getElementById(input).value < 0)
		{
		  document.getElementById(input).value = 0;		 
		}
	  
	}
	
	
	
	function number_format (number, decimals, dec_point, thousands_sep) {
	    var n = number, prec = decimals;
	 
	    var toFixedFix = function (n,prec) {
	        var k = Math.pow(10,prec);
	        return (Math.round(n*k)/k).toString();
	    };
	 
	    n = !isFinite(+n) ? 0 : +n;
	    prec = !isFinite(+prec) ? 0 : Math.abs(prec);
	    var sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep;
	    var dec = (typeof dec_point === 'undefined') ? '.' : dec_point;
	 
	    var s = (prec > 0) ? toFixedFix(n, prec) : toFixedFix(Math.round(n), prec); //fix for IE parseFloat(0.55).toFixed(0) = 0;
	 
	    var abs = toFixedFix(Math.abs(n), prec);
	    var _, i;
	 
	    if (abs >= 1000) {
	        _ = abs.split(/\D/);
	        i = _[0].length % 3 || 3;
	 
	        _[0] = s.slice(0,i + (n < 0)) +
	              _[0].slice(i).replace(/(\d{3})/g, sep+'$1');
	        s = _.join(dec);
	    } else {
	        s = s.replace('.', dec);
	    }
	 
	    var decPos = s.indexOf(dec);
	    if (prec >= 1 && decPos !== -1 && (s.length-decPos-1) < prec) {
	        s += new Array(prec-(s.length-decPos-1)).join(0)+'0';
	    }
	    else if (prec >= 1 && decPos === -1) {
	        s += dec+new Array(prec).join(0)+'0';
	    }
	    return s;
	}

//  FUNCOES GERADAS POR ULTIMO FIM ------------------------------------------------------------------------------------------------------------------>


var NUM_DIGITOS_CPF=11;
var NUM_DIGITOS_CNPJ=14;
var NUM_DGT_CNPJ_BASE=8;
var mskFlag = "blank";



function formatar(src, mask) {
		var i = src.value.length;
		var saida = mask.substring(i,i+1);
		var ascii = (document.all)? event.keycode : Event.which;
		/*if(document.all)
			var ascii = event.keyCode;
		else
			var ascii = ev.which;*/
		if (saida == "A") {
			if ((ascii >=97) && (ascii <= 122)) { event.keyCode -= 32; }
			else { event.keyCode = 0; }
		} else if (saida == "0") {
			if ((ascii >= 18) && (ascii <= 57)) { return }
			else { event.keyCode = 0 }
		} else if (saida == "#") {
			return;
		} else {
			src.value += saida;
			i += 1
			saida = mask.substring(i,i+1);
			if (saida == "A") {
				if ((ascii >=97) && (ascii <= 122)) { event.keyCode -= 32; }
				else { event.keyCode = 0; }
			} else if (saida == "0") {
				if ((ascii >= 18) && (ascii <= 57)) { return }
				else { event.keyCode = 0 }
			} else { return; }
		}
	}


/* Conversao */
function convertDate(data)
{
    var partes;
    var d;
    partes=data.split("/")
    if (partes.length=3)
        d=new Date(partes[2],partes[1],partes[0])
    else
        d=new date();
    return d
}
/* Validações */
function FmtValorMonetario(Dado)
{
      var Result, i;
      Dado = PassaDominio(Dado,"0123456789");
      if (Dado.length > 2)
      {
            Result = "," + Dado.substr(Dado.length-2, 2);
            for (i=5; i<=Dado.length; i+=3)
            {
                  Result = Dado.substr(Dado.length-i, 3) + Result;
                  if (Dado.length > i) Result = "." + Result;
            }
            Result = Dado.substr(0, Dado.length-i+3) + Result;
      }
      else
      {
             Result = Dado;
      }

      if (Result.indexOf("-") > -1)
      {
            if (Result.substring(1,2) == ".")
            {
                  Result = Result.substring(0,1) + Result.substring(2,Result.length)
            }
      }     
      return Result;
}

function PassaDominio(StrDado, Dominio)
{
      var i, j, c;
      var Result;

      Result = "";
      for (i=0; i<StrDado.length; i++)
            {
            c = StrDado.substr(i,1);
            for (j=0; j<Dominio.length; j++)
                  {
                  if (c == Dominio.substr(j,1)) break;
                  }
            if (j < Dominio.length)
                  {
                  Result = Result + c;
                  }
            }
      return Result;
}

function Moeda(key){

if ( document.all )
      var aKey = key.keyCode;
else
      var aKey = key.which;
//alert( aKey );
 if ( !( aKey == 0 || aKey == 37 || aKey == 9 || aKey == 8 || (aKey > 43 && aKey < 45 ) || (aKey > 45 && aKey < 47 ) || (aKey > 47 && aKey < 58 ) ) ) {
      if (document.all)
            key.returnValue = false;
      else
            return false;
      }
}

function NumbersOnly(e){//mascara somente numeros, libera copiar e colar
	var aKey;

	if (window.event)
		aKey = e.keyCode;
	else 
		aKey = e.which;
	
	//if das teclas precionadas
	if(!(((aKey==67)&&(e.ctrlKey))||((aKey==86)&&(e.ctrlKey))||(aKey==8)||(aKey==9)||(aKey==13)||(aKey==16)||(aKey==17)||(aKey==92)
	||((aKey>=96)&&(aKey<=105))||((aKey>=48)&&(aKey<=57))||((aKey>=37)&&(aKey<=40))||((aKey>=112)&&(aKey<=123))))
	{		  
  		return false;	
	}
}


function isData(campo)
{
	if (campo.value == "")
		return true;
	
    situacao = true;
    var msg = "Data invalida (" + campo.value + ").";

	if (campo.value.length < 10) {
		msg = "Data invalida (" + campo.value + "). Informe a data no formato: dd/mm/aaaa.";
		situacao = false;	
	} else {
		var dtaux = campo.value.split("/");
		if (dtaux[0].length != 2 || dtaux[1].length != 2 || dtaux[2].length != 4) {
			msg = "Data invalida (" + campo.value + "). Informe a data no formato: dd/mm/aaaa.";
			situacao = false;
		}
	}
	
	if (situacao)
	{
		dia = (campo.value.substring(0,2));
		mes = (campo.value.substring(3,5));
		ano = (campo.value.substring(6,10));
	
		// verifica o dia valido para cada mes
		if ((dia < "01")||(dia < "01" || dia > "30") &&
			(  mes == "04" || mes == "06" || mes == "09" || mes == "11" ) || dia > 31) {
			situacao = false;
		}

		// verifica se o mes e valido
		if (mes < 01 || mes > 12 ) {
			situacao = false;
		}

		// verifica se e ano bissexto
		if (mes == 2 && ( dia < 01 || dia > 29 || ( dia > 28 && (parseInt(ano / 4) != ano / 4)))) {
			situacao = false;
		}
   
		if (campo.value == "") {
			situacao = false;
		}
	}
	
   	if (!situacao) {
		alert(msg);
		campo.value = "";
	}
}

function unformatNumber(pNum)
{
	return String(pNum).replace(/\D/g, "").replace(/^0+/, "");
}

function formatCpfCnpj(pCpfCnpj, pUseSepar, pIsCnpj)
{
	if (pIsCnpj==null) pIsCnpj = false;
	if (pUseSepar==null) pUseSepar = true;
	var maxDigitos = pIsCnpj? NUM_DIGITOS_CNPJ: NUM_DIGITOS_CPF;
	var numero = unformatNumber(pCpfCnpj);

	tam = numero.length;
	var aux = "";
	for (var i = tam; i<maxDigitos; i++)
		aux += 0;
	//numero = numero.lpad(maxDigitos, "0");
	if (!pUseSepar) return numero;

	if (pIsCnpj)
	{
		reCnpj = /(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/;
		numero = numero.replace(reCnpj, "$1.$2.$3/$4-$5");
	}
	else
	{
		reCpf  = /(\d{3})(\d{3})(\d{3})(\d{2})$/;
		numero = numero.replace(reCpf, "$1.$2.$3-$4");
	}
	return numero;
}

function dvCpfCnpj(pEfetivo, pIsCnpj)
{
	if (pIsCnpj==null) pIsCnpj = false;
	var i, j, k, soma, dv;
	var cicloPeso = pIsCnpj? 8: 10;
	var maxDigitos = pIsCnpj? NUM_DIGITOS_CNPJ: NUM_DIGITOS_CPF;
	var calculado = formatCpfCnpj(pEfetivo, false, pIsCnpj);
	var result = "";

	for(j = 1; j <= 2; j++)
	{
		k = 2;
		soma = 0;
		for (i = calculado.length-1; i >= 0; i--)
		{
			soma += (calculado.charAt(i) - '0') * k;
			k = (k-1) % cicloPeso + 2;
		}
		dv = 11 - (soma % 11);
		if (dv > 9) dv = 0;
		calculado += dv;
		result += dv
	}

	return result;
} 

function isCpf(elem, msgbox)
{
	var pCpf ;
    if (elem.value)
        pCpf=elem.value;
    else
	    pCpf=elem;
	if (pCpf == "")
		return true;
	if (pCpf.length < 14) {
	    if (msgbox)
		    alert ('CPF invalido (' + pCpf + ').');
		//elem.value = "";
		return false;
	}
	var numero = formatCpfCnpj(pCpf, false, false);
	while (numero.length < 11) {
	  numero = '0' + numero;
	}	
	var base = numero.substring(0, numero.length - 2);
	var digitos = dvCpfCnpj(base, false);
	var algUnico, i;

	// Valida dígitos verificadores
	
	if (numero != base + digitos) {
	    if (msgbox)
		    alert ('CPF invalido (' + pCpf + ').');
		//elem.value = "";
		return false;
	}

	/* Não serão considerados válidos os seguintes CPF:
	 * 000.000.000-00, 111.111.111-11, 222.222.222-22, 333.333.333-33, 444.444.444-44,
	 * 555.555.555-55, 666.666.666-66, 777.777.777-77, 888.888.888-88, 999.999.999-99.
	 */
	algUnico = true;
	for (i=1; i<NUM_DIGITOS_CPF; i++)
	{
		algUnico = algUnico && (numero.charAt(i-1) == numero.charAt(i));
	}
	if (algUnico)
	{
	    if (msgbox)
	        alert ('CPF invalido (' + pCpf + ').');
		//elem.value = "";
		return false;
	}
	return true;
}

function isCnpj(elem, msgbox)
{
    if (elem.value)
        pCnpj=elem.value;
    else
	    pCnpj = elem;
	if (pCnpj == "")
		return true;
	if (pCnpj.length < 18)
	{
	    if (msgbox)
		    alert ('CNPJ invalido (' + pCnpj + ').');
		//elem.value = "";
		return false;
	}
	var numero = formatCpfCnpj(pCnpj, false, true);
	while (numero.length < 14) {
	  numero = '0' + numero;
	}
	var base = numero.substring(0, NUM_DGT_CNPJ_BASE);
	var ordem = numero.substring(NUM_DGT_CNPJ_BASE, 12);
	var digitos = dvCpfCnpj(base + ordem, true);
	var algUnico;

	// Valida dígitos verificadores
	if (numero != base + ordem + digitos)
	{
	    if (msgbox)
		    alert ('CNPJ invalido (' + pCnpj + ').');
		//elem.value = "";
		return false;
	}


	/* Não serão considerados válidos os CNPJ com os seguintes números BÁSICOS:
	 * 11.111.111, 22.222.222, 33.333.333, 44.444.444, 55.555.555,
	 * 66.666.666, 77.777.777, 88.888.888, 99.999.999.
	 */
	
	algUnico = numero.charAt(0) != '0';
	for (i=1; i<NUM_DGT_CNPJ_BASE; i++)
	{
		algUnico = algUnico && (numero.charAt(i-1) == numero.charAt(i));
	}
	if (algUnico) 
	{
	    if (msgbox)
		    alert ('CNPJ invalido (' + pCnpj + ').');
		//elem.value = "";
		return false;
	}


	/* Não será considerado válido CNPJ com número de ORDEM igual a 0000.
	 * Esta crítica não será feita quando o BÁSICO do CNPJ for igual a 00.000.000.
	*/ 
	if (ordem == "0000")
	{
	    if (msgbox)
		    alert ('CNPJ invalido (' + pCnpj + ').');
		//elem.value = "";
		return false;
	}
	
/*	if (!(base == "00000000" || base.substring(0, 3) != "000"))
	{
		alert ('CNPJ (' + pCnpj + ') inválido.');
		alert('base : ' + base);
		elem.value = "";
		return false;
	}
*/
    return true;
}


function isCpfCnpj(elem, msgbox)
{
	var pCpfCnpj;
    if (elem.value)
        pCpfCnpj=elem.value;
    else
	    pCpfCnpj=elem;
	var numero = pCpfCnpj.replace(/\D/g, '');
	if (numero == '') 
		return true;	
	if (numero.length > NUM_DIGITOS_CPF)
		return isCnpj(elem, msgbox);
	else
		return isCpf(elem, msgbox);
}

function validaCpfCnpj(source, args)
{
   if (args.Value)
       if (isCpfCnpj(args.Value,false)) 
           {
           args.IsValid=true;
           return true;
           }
       else
           {
           args.IsValid=false;
           return false;
           }
    else
       if (isCpfCnpj(args,false)) 
           {
           source.style.display='none';
           return true;
           }
       else
           { 
           source.style.display='inline';     
           return false;
           }
}

function validaCpf(source, args)
{
   if (args.Value)
       if (isCpf(args.Value,false)) 
           {
           args.IsValid=true;
           return true;
           }
       else
           {
           args.IsValid=false;
           return false;
           }
    else
       if (isCpf(args,false)) 
           {
           source.style.display='none';
           return true;
           }
       else
           { 
           source.style.display='inline';     
           return false;
           }  
}

function validaCnpj(source, args)
{
   if (args.Value)
       if (isCnpj(args.Value,false)) 
           {
           args.IsValid=true;
           return true;
           }
       else
           {
           args.IsValid=false;
           return false;
           }
    else
       if (isCnpj(args,false)) 
           {
           source.style.display='none';
           return true;
           }
       else
           { 
           source.style.display='inline';     
           return false;
           }
}


/* Máscaras */
function strip( str, c ) {
	var tmp = str.split( c );
	return tmp.join("");
	
	}


function CEPMsk ( aWidget ) {
	if ( mskFlag == "getOut" ) return true;
	var tmp = strip( aWidget.value , "-");
	if ( 5 < tmp.length ) aWidget.value = tmp.substr( 0 , 5 ) + '-' + tmp.substr( 5 , 3 );
		else aWidget.value = tmp;
}

function stopMskVerificacao(key){
	mskFlag = "blank";
	
	if ( document.all )
		var aKey = key.keyCode;
	else
		var aKey = key.which;

	if ( !(( aKey > 47 && aKey < 58 ) || ( aKey > 64 && aKey < 91 ) || ( aKey > 96 && aKey < 123 )) ) mskFlag = "getOut";
	
}

function stopMsk(key){
	mskFlag = "blank";
	
	if ( document.all )
		var aKey = key.keyCode;
	else
		var aKey = key.which;

	if ( !(( aKey > 47 && aKey < 58 ) || ( aKey > 95 && aKey < 106 )) ) mskFlag = "getOut";
	
}

function dateMsk( aWidget ){
	if ( mskFlag == "getOut" ) return true;
	var tmp = strip( aWidget.value , "/");
	if ( 4 < tmp.length ) aWidget.value = tmp.substr(0,2) + '/' + tmp.substr(2,2) + '/' + tmp.substr(4,4);
		else if ( 2 < tmp.length ) aWidget.value = tmp.substr(0,2) + '/' + tmp.substr(2,2);
			else aWidget.value = tmp;
}

function CPFMsk ( aWidget ) {
	if ( mskFlag == "getOut" ) return true;
	var tmp = strip( aWidget.value , "." );
	tmp = strip( tmp , "-" );
	
	if ( 9 < tmp.length ) aWidget.value = tmp.substr(0,3) + '.' + tmp.substr(3,3) + '.' + tmp.substr(6,3) + '-' + tmp.substr(9,2);
		else if ( 6 < tmp.length ) aWidget.value = tmp.substr(0,3) + '.' + tmp.substr(3,3) + '.' + tmp.substr(6,3);
			else if ( 3 < tmp.length )  aWidget.value = tmp.substr(0,3) + '.' + tmp.substr(3,3);
				else aWidget.value = tmp;
	}

function CNPJMsk ( aWidget ) {
	if ( mskFlag == "getOut" ) return true;
	var tmp = strip( aWidget.value , "." );
	tmp = strip( tmp , "/" );
	tmp = strip( tmp , "-" );
	if ( 12 < tmp.length ) aWidget.value = tmp.substr(0,2) + '.' + tmp.substr(2,3) + '.' + tmp.substr(5,3) + '/' + tmp.substr(8,4)+ '-'  + tmp.substr(12,2);
		else if ( 8 < tmp.length ) aWidget.value = tmp.substr(0,2) + '.' + tmp.substr(2,3) + '.' + tmp.substr(5,3) + '/' + tmp.substr(8,4);
			else if ( 5 < tmp.length ) aWidget.value = tmp.substr(0,2) + '.' + tmp.substr(2,3) + '.' + tmp.substr(5,3);
				else if ( 2 < tmp.length ) aWidget.value = tmp.substr(0,2) + '.' + tmp.substr(2,3);
					else aWidget.value = tmp;
	}

function CNPJCPFMsk( aWidget ) {
	if ( mskFlag == "getOut" ) return true;
	var tmp = strip( aWidget.value , "." );
	tmp = strip( tmp , "/" );
	tmp = strip( tmp , "-" );
	
	var cont = 0;
	var teste='';
	while(cont < tmp.length) {			
		if(!(tmp.charAt(cont)>=0 && tmp.charAt(cont)<=9)){
			teste+='';					
		}
		else
		{
			teste+=tmp.charAt(cont);			 
		}
		cont++;
	}
	tmp = teste;	
	
	if ( 12 < tmp.length ) aWidget.value = tmp.substr(0,2) + '.' + tmp.substr(2,3) + '.' + tmp.substr(5,3) + '/' + tmp.substr(8,4)+ '-'  + tmp.substr(12,2);
		else if ( 9 < tmp.length ) aWidget.value = tmp.substr(0,3) + '.' + tmp.substr(3,3) + '.' + tmp.substr(6,3) + '-' + tmp.substr(9,3);
			else if ( 6 < tmp.length ) aWidget.value = tmp.substr(0,3) + '.' + tmp.substr(3,3) + '.' + tmp.substr(6,3);
				else if ( 3 < tmp.length )  aWidget.value = tmp.substr(0,3) + '.' + tmp.substr(3,3);
					else aWidget.value = tmp;
	}
	
function CCMMsk( aWidget ) {
    if ( mskFlag == "getOut" ) return true;
    var tmp = strip( aWidget.value , "." );
    tmp = strip( tmp , "-" );
    if ( 7 < tmp.length ) aWidget.value = tmp.substr(0, 1) + '.' + tmp.substr(1, 3) + '.' + tmp.substr(4, 3) + '-' + tmp.substr(7);
        else if ( 4 < tmp.length ) aWidget.value = tmp.substr(0, 1) + '.' + tmp.substr(1, 3) + '.' + tmp.substr(4, 3);
            else if ( 1 < tmp.length ) aWidget.value = tmp.substr(0, 1) + '.' + tmp.substr(1, 3);
                else aWidget.value = tmp;    
    }

function SQLNMsk ( aWidget ) {

      if ( mskFlag == "getOut" ) return true;

      var tmp = strip( aWidget.value , "." );

      tmp = strip( tmp , "/" );

      tmp = strip( tmp , "-" );

      if ( 10 < tmp.length ) aWidget.value = tmp.substr(0,3) + '.' + tmp.substr(3,3) + '.' + tmp.substr(6,4) + '-' + tmp.substr(10,1);

            else if ( 6 < tmp.length ) aWidget.value = tmp.substr(0,3) + '.' + tmp.substr(3,3) + '.' + tmp.substr(6,4);

                  else if ( 3 < tmp.length ) aWidget.value = tmp.substr(0,3) + '.' + tmp.substr(3,3);

                        else aWidget.value = tmp;

      }


    
function VerificacaoMsk( aWidget )
{
    if ( mskFlag == "getOut" ) return true;
    var tmp = strip( aWidget.value , "-" );
    if ( 4 < tmp.length ) aWidget.value = tmp.substr(0, 4) + '-' + tmp.substr(4, 4);
    else aWidget.value = tmp;    
   }


/*Exemplo de utilização:
<input type="text" name="valor"  onKeyPress="return(MascaraMoeda(this,'.',',',event))">*/




function backspace2(obj,e){
var whichCode = (window.event) ? e.keyCode : e.which;
var parte1;
var parte2;

if (whichCode == 8) {	
	var valor = obj.value;
	var valor = valor.substring(0,valor.length-1);    
	return false;
	}// end if		
}// end backspace

//Mascara de moeda
function MascaraMoeda(objTextBox, SeparadorMilesimo, SeparadorDecimal, e){	
	var sep = 0;
    var key = '';
    var i = j = 0;
    var len = len2 = 0;
    var strCheck = '0123456789';
    var aux = aux2 = '';
    var whichCode = (window.event) ? e.keyCode : e.which;
    if ((whichCode == 13)||(whichCode == 8)||(whichCode == 0)) return true;
    key = String.fromCharCode(whichCode); // Valor para o código da Chave
    if (strCheck.indexOf(key) == -1) return false; // Chave inválida
    len = objTextBox.value.length;
    for(i = 0; i < len; i++)
        if ((objTextBox.value.charAt(i) != '0') && (objTextBox.value.charAt(i) != SeparadorDecimal)) break;
    aux = '';
    for(; i < len; i++)
        if (strCheck.indexOf(objTextBox.value.charAt(i))!=-1) aux += objTextBox.value.charAt(i);
    aux += key;
    len = aux.length;
    if (len == 0) objTextBox.value = '';
    if (len == 1) objTextBox.value = '0'+ SeparadorDecimal + '0' + aux;
    if (len == 2) objTextBox.value = '0'+ SeparadorDecimal + aux;
    if (len > 2) {
        aux2 = '';
        for (j = 0, i = len - 3; i >= 0; i--) {
            if (j == 3) {
                aux2 += SeparadorMilesimo;
                j = 0;
            }
            aux2 += aux.charAt(i);
            j++;
        }
        objTextBox.value = '';
        len2 = aux2.length;
        for (i = len2 - 1; i >= 0; i--)
        objTextBox.value += aux2.charAt(i);
        objTextBox.value += SeparadorDecimal + aux.substr(len - 2, len);
    }
    return false;
}

// limpa todos os caracteres especiais do campo solicitado
function filtraCampo(campo){
	var s = "";
	var cp = "";
	vr = campo.value;
	tam = vr.length;
	for (i = 0; i < tam ; i++) {  
		if (vr.substring(i,i + 1) != "/" && vr.substring(i,i + 1) != "-" && vr.substring(i,i + 1) != "."  && vr.substring(i,i + 1) != "," ){
		 	s = s + vr.substring(i,i + 1);}
	}
	campo.value = s;
	return cp = campo.value
}

function validaNumKey ()
{
	if (document.all) {
		var inputKey =  event.keyCode;
		var returnCode = true;
		if(inputKey==8) var backspace = 's';
		if ((inputKey==8)||(inputKey==9)||(inputKey==13)||(inputKey==16)||(inputKey==17)||
			(inputKey==92)||((inputKey>=96)&&(inputKey<=105))||((inputKey>=48)&&(inputKey<=57))||
			((inputKey>=37)&&(inputKey<=40))||((inputKey>=112)&&(aKey<=123)))
			// numbers 
			{
				return;
			}
		else
			{
				returnCode = false;
				event.keyCode = 0;
			}
		event.returnValue = returnCode;
	} else {
		var inputKey =  Event.which;
		var returnCode = true;
	 
		if ((inputKey==8)||(inputKey==9)||(inputKey==13)||(inputKey==16)||(inputKey==17)||
			(inputKey==92)||((inputKey>=96)&&(inputKey<=105))||((inputKey>=48)&&(inputKey<=57))||
			((inputKey>=37)&&(inputKey<=40))||((inputKey>=112)&&(aKey<=123)))
			// numbers 
			{
				return;
			}
		else
			{
				returnCode = false;
				Event.which = 0;
			}
		Event.returnValue = returnCode;
	
	}
}

// Formata data no padrao DDMMAAAA
function formataData(campo){
	validaNumKey();
	//campo.value = filtraCampo(campo);
	vr = campo.value;
	tam = vr.length;
	if ( tam == 2)
		campo.value = campo.value+'/';
	if ( tam == 5)
		campo.value = campo.value+'/';
	/*if ( tam > 2 && tam < 5 )
		campo.value = vr.substr( 0, tam - 2  ) + '/' + vr.substr( tam - 2, tam );
	if ( tam >= 5 && tam <= 10 )
		campo.value = vr.substr( 0, 2 ) + '/' + vr.substr( 2, 2 ) + '/' + vr.substr( 4, 4 ); */

}


function get(frm, input01, input02, cmb){   	
	var combo = cmb;
	var id = document.getElementById(combo);
	var nome = id.options[id.selectedIndex].value;  
	
	if(nome == 'PF')
	{  
	   eval("document." + frm +"." + input01 + ".style.display = 'none'");
	   eval("document." + frm +"." + input02 + ".style.display = 'block'");
	}
	else
	 if(nome == 'PJ')
	 {  	 
  	   eval("document." + frm +"." + input01 + ".style.display = 'block'");
	   eval("document." + frm +"." + input02 + ".style.display = 'none'");
    }    
}
//-->


// JavaScript Document

	
// Verifica CNPJ

// script coloca os pontos do cnpj

function SomenteNumeros(input)
	{
	if ((event.keyCode<48)||(event.keyCode>57))
		event.returnValue = false;
	}
//-------------------------------
function FormataValor(campo,tammax,teclapres) {

	var tecla = teclapres.keyCode;
	var vr = campo.value;
	vr = vr.replace( "-", "" );
	vr = vr.replace( "/", "" );
	vr = vr.replace( ".", "" );
	vr = vr.replace( ".", "" );
	tam = vr.length;

	if (tam < tammax && tecla != 13){ tam = vr.length + 1 ; }

	if (tecla == 13 ){	tam = tam - 1 ; }
		
	if ( tecla == 13 || (tecla >= 48 && tecla <= 57) || (tecla >= 96 && tecla <= 105) ){
		if ( tam <= 2 ){ 
	 		campo.value = vr ; }
	 	tam = tam - 1;
	 	if ( (tam > 2) && (tam <= 5) ){
	 		campo.value = vr.substr( 0, tam - 2 ) + '-' + vr.substr( tam - 2, tam ) ; }
	 	if ( (tam >= 6) && (tam <= 8) ){
	 		campo.value = vr.substr( 0, tam - 6 ) + '/' + vr.substr( tam - 6, 4 ) + '-' + vr.substr( tam - 2, tam ) ; }
	 	if ( (tam >= 9) && (tam <= 11) ){
	 		campo.value = vr.substr( 0, tam - 9 ) + '.' + vr.substr( tam - 9, 3 ) + '/' + vr.substr( tam - 6, 4 ) + '-' + vr.substr( tam - 2, tam ) ; }
	 	if ( (tam >= 12) && (tam <= 14) ){
	 		campo.value = vr.substr( 0, tam - 12 ) + '.' + vr.substr( tam - 12, 3 ) + '.' + vr.substr( tam - 9, 3 ) + '/' + vr.substr( tam - 6, 4 ) + '-' + vr.substr( tam - 2, tam ) ; }
	 	
	}
}

// -------------------------------------------- DINHEIRO -----------------------------------------

function FormataValor1(campo,tammax,teclapres) 
{
    //uso:
    //<input type="Text" name="fat_vr_bruto" maxlength="17" onKeyDown="FormataValor(this,17,event)">

    var tecla = teclapres.keyCode;
    vr = campo.value;
    vr = vr.replace( "/", "" );
    vr = vr.replace( "/", "" );
    vr = vr.replace( ",", "" );
    vr = vr.replace( ".", "" );
    vr = vr.replace( ".", "" );
    vr = vr.replace( ".", "" );
    vr = vr.replace( ".", "" );
    tam = vr.length;

    if (tam < tammax && tecla != 8){ tam = vr.length + 1; }

    if (tecla == 8 ){    tam = tam - 1; }
        
    if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 ){
        if ( tam <= 2 ){ 
             campo.value = vr; }
         if ( (tam > 3) && (tam <= 5) ){
             campo.value = vr.substr( 0, tam - 3 ) + '.' + vr.substr( tam - 3, tam ); }
         if ( (tam >= 6) && (tam <= 6) ){
             campo.value = vr.substr( 0, tam - 3 ) + '.' + vr.substr( tam - 3, tam )  + vr.substr( tam -1, tam ); }
         if ( (tam >= 9) && (tam <= 11) ){
             campo.value = vr.substr( 0, tam - 8 ) + '.' + vr.substr( tam - 8, 3 ) + '.' + vr.substr( tam - 5, 3 ) + vr.substr( tam - 2, tam ); }
         if ( (tam >= 12) && (tam <= 14) ){
             campo.value = vr.substr( 0, tam - 11 ) + '.' + vr.substr( tam - 11, 3 ) + '.' + vr.substr( tam - 8, 3 ) + '.' + vr.substr( tam - 5, 3 )  + vr.substr( tam - 2, tam ); }
         if ( (tam >= 15) && (tam <= 17) ){
             campo.value = vr.substr( 0, tam - 14 ) + '.' + vr.substr( tam - 14, 3 ) + '.' + vr.substr( tam - 11, 3 ) + '.' + vr.substr( tam - 8, 3 ) + '.' + vr.substr( tam - 5, 3 )  + vr.substr( tam - 2, tam );}
    }            
}

// -------------------------------- Money 2 ----------------------------------

function diasDecorridos(dt1, dt2){
	// variáveis auxiliares
	var minuto = 60000; 
	var dia = minuto * 60 * 24;
	var horarioVerao = 0;
	
	// ajusta o horario de cada objeto Date
	dt1.setHours(0);
	dt1.setMinutes(0);
	dt1.setSeconds(0);
	dt2.setHours(0);
	dt2.setMinutes(0);
	dt2.setSeconds(0);
	
	// determina o fuso horário de cada objeto Date
	var fh1 = dt1.getTimezoneOffset();
	var fh2 = dt2.getTimezoneOffset(); 
	
	// retira a diferença do horário de verão
	if(dt2 > dt1){
	  horarioVerao = (fh2 - fh1) * minuto;
	} 
	else{
	  horarioVerao = (fh1 - fh2) * minuto;    
	}

	var dif = Math.abs(dt2.getTime() - dt1.getTime()) - horarioVerao;
	result = Math.ceil(dif / dia);
	if(dt1>dt2)
		result = result * (-1);
	return result;
}



function Confirmacao(msg,caminho)	
    {
		if (confirm(msg))
			{
				window.location=caminho;	
			}
	}
	


function Confirma(pergunta)
	{
		if(confirm(pergunta))
			{
				return true;
			}
		return false;
	}
	
	
function MostraAliquota(campoAliq, campoISSRetido, cont){ 	 
	var aux = document.getElementById('cmbCodServico'+cont).value;
	var aux = aux.split("|");
	aliquota = aux[0];
	issretido = aux[2];
	if(issretido >= MoedaToDec(document.getElementById('txtValTotal').value)){
		issretido = MoedaToDec(document.getElementById('txtValTotal').value);
	}
	document.getElementById(campoISSRetido).value = DecToMoeda(issretido);
	document.getElementById(campoAliq).value = aliquota;
}

function ActionDinamico(form,action)
	{
		document.getElementById(form).action=action;
	}

function MostraDiv(id)
	{
		document.getElementById(id).style.display='block';
	}

function EscondeDiv(id)
	{
		documente.getElement.ById(id).style.display='none';
	}
	
//funcao para buscar o mes de acordo com o ano selecionado baseado na data de inicio e fim de empresa
function buscaPeriodo(codigo, ano, resultado) {
	var url = 'listaperiodo.ajax.php?cod=' + codigo +'&ano=' + ano;
	if (ano != '') {
		
		ajax({
			url:url,
			espera: function() {document.getElementById(resultado).innerHTML = '';},
			sucesso: function() {document.getElementById(resultado).innerHTML = respostaAjax;}
		});
	} else {
		document.getElementById(resultado).innerHTML = '';
	}
}

// funcao para validar a extencao de um arquivo
function validaExtencao(file){
	var extencao = document.getElementById(file).value.split('.');
	var key = (extencao.length-1);
	if(extencao[key] == ''){
		return true;
	}else if((extencao[key] != 'jpg')&&(extencao[key] != 'jpeg')&&(extencao[key] != 'gif')&&(extencao[key] != 'png')&&(extencao[key] != 'JPG')&&(extencao[key] != 'JPEG')&&(extencao[key] != 'GIF')&&(extencao[key] != 'PNG')){
		alert("A extenção "+extencao[key]+" não é válida");
		return false;
	}
	return true;
}