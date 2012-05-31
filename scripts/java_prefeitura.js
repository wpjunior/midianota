
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

/*Exemplo de utilização:
<input type="text" name="valor"  onKeyPress="return(MascaraMoeda(this,'.',',',event))">*/

/*var focused;
onload=function() {
	for(var c=0;c<document.forms.length;c++) {
		var el = document.forms[c].elements;
		for(var i=0;i<el.length;i++) {
			el[i].onfocus=function(){focused=this.id;};
			if (el[i].name.substring(0,8)=='txtValor') {
				el[i].onkeyup= function() {MaskMoeda(this);};
				//el[i].onkeydown=function() {return NumbersOnly(event);};
			}
			if (el[i].name.substring(0,10)=='txtCNPJCPF' || el[i].name.substring(0,7)=='txtCNPJ' || el[i].name.substring(0,6)=='txtCPF') {
				el[i].onkeyup= function() {CNPJCPFMsk(this);};
				//el[i].onkeydown=function() {return NumbersOnly(event);};
			}
			if (el[i].name.substring(0,7)=='txtData') {
				el[i].onkeyup= function() {MaskData(this);};
				//el[i].onkeydown=function() {return NumbersOnly(event);};
			}
		}
	}
};

	function MaskMoeda(campo){
		campo.value = MoedaToDec(campo.value);
		campo.value = DecToMoeda(campo.value);		
	}
	
	function MoedaToDec(valor)
	{
		if (valor=='')
			valor = '0';
		valor=valor.replaceAll(',','');
		valor=valor.replaceAll('.','');
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

	function MaskData(campo){
		var data = campo.value+'';
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
	}*/


//Mascara de moeda
function MascaraMoeda(objTextBox, SeparadorMilesimo, SeparadorDecimal, e){
    var sep = 0;
    var key = '';
    var i = j = 0;
    var len = len2 = 0;
    var strCheck = '0123456789';
    var aux = aux2 = '';
    var whichCode = (window.Event) ? e.which : e.keyCode;
    if (whichCode == 13) return true;
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


//Função que envia os dados do form para uma pagina em branco do formulario dos prestadores
function enviaFormPrestadores(btn)
{
	if(btn.name == "rdCompleta")	
		{
			document.frmPrestadoresBtn.target = "_blank";
			document.frmPrestadoresBtn.action = "inc/relatorios_prestadores_lista.php";
		}
	else
		{
			document.frmPrestadoresBtn.target = "_parent";
			document.frmPrestadoresBtn.action = "relatorios.php?btPrestadores=B";
		}
	document.frmPrestadoresBtn.submit();
}

//Função que envia os dados do form para uma pagina em branco do formulario dos serviços
function enviaFormServicos(btn)
{
	if(btn.name == "rdAtivos")	
		{
			document.frmServicos.target = "_blank";
			document.frmServicos.action = "inc/relatorios_servicos_ativos.php";
		}
	else
		{
			document.frmServicos.target = "_blank";
			document.frmServicos.action = "inc/relatorios_servicos_inativos.php";
		}
	document.frmServicos.submit();
}

//Função para escoinder a div apos o clique
function EscondeDiv(div)
{
 document.getElementById(div).style.display='none';
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
	var inputKey =  event.keyCode;
	var returnCode = true;
 
	if ( inputKey > 47 && inputKey < 58 ) // numbers 
		{
			return;
		}
	else
		{
			returnCode = false;
			event.keyCode = 0;
		}
	event.returnValue = returnCode;
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


//CPF E CNPJ EM UM INPUT

var NUM_DIGITOS_CPF=11;
var NUM_DIGITOS_CNPJ=14;
var NUM_DGT_CNPJ_BASE=8;
var mskFlag = "blank";

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

function NumbersOnly(key){
	if ( document.all )
		var aKey = key.keyCode;
	else
		var aKey = key.which;

	//alert( aKey );
	if ( !( aKey == 0 || aKey == 37 || aKey == 9 || aKey == 8 ||  ( aKey > 47 && aKey < 58 )  ) ) {
			if (document.all)
				key.returnValue = false;
			else
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


    
function VerificacaoMsk( aWidget ) {
    if ( mskFlag == "getOut" ) return true;
    var tmp = strip( aWidget.value , "-" );
    if ( 4 < tmp.length ) aWidget.value = tmp.substr(0, 4) + '-' + tmp.substr(4, 4);
    else aWidget.value = tmp;    
    }







































// JavaScript Document

<!-- 	 
var cont =0, contservicos =0;


function MostraAliquota()
{ 	 
 var aux = document.getElementById('cmbCodServico').value;
 var aliquota = aux.split("|");
 document.getElementById('txtAliquota').value=aliquota[0]; 
}




function ValorIss(cred1,reg1,cred2,reg2,cred3)
{
 var credito_final ;	
 var credito = 0;	
 var credito1= cred1;
 var credito2= cred2;
 var credito3= cred3;
 var regra1= reg1;
 var regra2= reg1;

  
 var basecalc = document.getElementById('txtBaseCalculo').value;
 var valdeduc = document.getElementById('txtValorDeducoes').value;
 var aliquota = document.getElementById('cmbCodServico').value; 
 if((basecalc != "") && (valdeduc !=""))
 {
  var iss = parseFloat(basecalc) * parseFloat(aliquota)/100;
  document.getElementById('txtISS').value=iss;	
  
  var total = parseFloat(basecalc) + parseFloat(valdeduc);
  document.getElementById('txtValTotal').value=total;
  
  if(total<regra1)
  {
   credito = credito1;
  }
  else
   if(total<regra2)
   {
    credito = credito2;    
   }
  else
   {
    credito = credito3; 
   }
   
   credito_final = (parseFloat(iss) * parseFloat(credito))/100; 
   document.getElementById('txtCredito').value=credito_final;
 }
 
}




//txtNomeSocio txtCpfSocio
function excluirSocio() 
{
  
  document.getElementById('campossocio'+cont).style.display='none';
  document.getElementById('linha01socio'+cont).style.display='none';
  document.getElementById('linha02socio'+cont).style.display='none'; 
  document.getElementById('txtCpfSocio'+cont).value="";
  document.getElementById('txtNomeSocio'+cont).value="";


  cont--;
}
	
	
function incluirSocio() 
{ 
   if (cont < 10)
   {
    cont++;     
    document.getElementById('campossocio'+cont).style.display='block';
    document.getElementById('linha01socio'+cont).style.display='block';
    document.getElementById('linha02socio'+cont).style.display='block';   
   }
   
}


function ServicosCategorias(categoria)
	{
		var dados;		
			dados=categoria.value;
		if(dados !="")
		{	
			dados = dados.split("|");					
			while(dados[2] > 0)
			{				 
			 document.getElementById('div'+dados[2]+dados[1]).style.display='none';
			 document.getElementById('cmbCodigo'+dados[2]+dados[1]).value='';
			 dados[2]--;
			}			
			document.getElementById('div'+dados[0]+dados[1]).style.display='block';			
		}
		
		
	}


function excluirServico(cod) 
{  
  dados=cod.name;
  dados= dados.split("|");
  document.getElementById('camposservico'+dados[2]).style.display='none';
  document.getElementById('linha01servico'+dados[2]).style.display='none'; 
  //document.getElementById('linha02servico'+contservicos).style.display='none';
  while(dados[1] > 0)
  {
   document.getElementById('cmbCodigo'+dados[1]+dados[2]).value='';
   document.getElementById('cmbCategoria'+dados[2]).value='';
   document.getElementById('div'+dados[1]+dados[2]).style.display='none';
   dados[1]--;
  }
  contservicos--;
}
	


function incluirServico()
{ 
   if (contservicos < 5)
   {
    contservicos++;  
    document.getElementById('camposservico'+contservicos).style.display='block';
    document.getElementById('linha01servico'+contservicos).style.display='block';
    //document.getElementById('linha02servico'+contservicos).style.display='block';   
   }
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

// FUNÇÃO PARA MARCAR TODOS OS CHECKBOX DE EMISSORES QUE TENEHAM O AIDF LIBERADO
function MarcaCheckboxAIDF(cb,txt,x)
	{
		var cb=cb+x;
		var txt=txt+x;
		document.getElementById(cb).checked=true;
		document.getElementById(txt).disabled=true;
	}
	
// FUNÇÃO PARA TRATAR O FORMULÁRIO DO AIDF	
function AIDF(txt,cb,x)	
	{
		var txt=txt+x;
		var cb=cb+x;
		if(document.getElementById(cb).checked)
			{
				document.getElementById(txt).disabled=true;
				document.getElementById(txt).value=0;
			}
		else
			{
				document.getElementById(txt).disabled=false;
				document.getElementById(txt).value="";
				document.getElementById(txt).focus();
			}
	}

// FUNÇÃO PARA CONFIRMAÇÃO DA ESCRITURAÇÃO DE NOTAS 
function ConfirmaEscriturar(boleto)
	{
		if(confirm("Deseja escrituras as notas contidas no boleto "+boleto+"?"))
			{window.location="inc/escrituracao_inserir.php?boleto="+boleto;}
	}

// FUNÇÃO DE TRATAMENTO DO FORMULÁRIO DE PESQUISA DE BOLETOS
function ValidarBuscaBoleto()
	{
		if(document.frmBuscaBoleto.txtNroBoleto.value=="")
			{
				alert("Informe a chave de controle do boleto");
				return false;
			}
	}
	
//FUNÇÃO PARA TRATAMENDO DO FORMULÁRIO DE DELEGAÇÃO DE NIVEL DE USUARIO	
function MarcaNivel(x)
	{
		var baixo="baixo"+x;
		var medio="medio"+x;
		if(document.getElementById(baixo).checked)
			{
				document.getElementById(medio).checked=true;	
				document.getElementById(medio).disabled=true;	
			}
		else
			{
				document.getElementById(medio).disabled=false;	
			}
	}
	
// FUNÇÃO PARA MARCAR PERMISSÕES DOS USUARIOS DE NIVEL BAIXO
function MarcaCheckboxBaixo(x)
	{
		var baixo="baixo"+x;
		var medio="medio"+x;
		document.getElementById(baixo).checked=true;
		document.getElementById(medio).checked=true;
		document.getElementById(medio).disabled=true;
	}

// FUNÇÃO PARA MARCAR PERMISSÕES DOS USUÁRIOS DE NIVEL MÉDIO
function MarcaCheckboxMedio(x)
	{
		var medio="medio"+x;
		document.getElementById(medio).checked=true;
	}