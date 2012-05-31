
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

//  FUNCOES GERADAS POR ULTIMO ------------------------------------------------------------------------------------------------------------------>

function acessoAjax(url,form,retorno){	  	

	form = document.getElementById(form);
	var parametros='';
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
			if(form.elements[i].type=='radio')
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
		  
		  document.getElementById(retorno).innerHTML = 'Pesquisando....';
		  
		}
		
		// Verifica se o Ajax realizou todas as operações corretamente (essencial)
		if(req.readyState == 4 && req.status == 200) {			
		// Resposta retornada pelo validacao.php
		var resposta = req.responseText;			
		// Abaixo colocamos a resposta na div do campo que fez a requisição			    	     
		 	document.getElementById(retorno).innerHTML = resposta;
		}
		
		 
	}		 
	req.send(null);
}