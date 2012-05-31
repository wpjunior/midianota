
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

/*
*Função que trata a porcentagem
*/
function MaskPercent(campo){
	campo.maxLength = 6;
	valor = campo.value;
	if (valor==''){
		valor = '0';
	}
	valor=valor.replaceAll(',','');
	valor=valor.replaceAll('.','');
	valor = parseFloat(valor);
	valor/=100;
	campo.value = valor;
	
	valor = campo.value;
	if(valor==""){
		valor = 0;
	}
	valor = parseFloat(valor);
	campo.value = number_format(valor, 2, ".","");

}

	String.prototype.replaceAll = function(de, para){
		var str = this;
		var pos = str.indexOf(de);
		while (pos > -1){
			str = str.replace(de, para);
			pos = str.indexOf(de);
		}
		return (str);
	};



//CPF E CNPJ EM UM INPUT

var NUM_DIGITOS_CPF=11;
var NUM_DIGITOS_CNPJ=14;
var NUM_DGT_CNPJ_BASE=8;
var mskFlag = "blank";

// FUNÇÕES da GUIA DE PAGAMENTO


function ValidaCkbDec(campo){
	var total = parseInt(document.getElementById(campo).value);
	if(total>0){
		return true;
	}else{
		alert('É necessário que escolha ao menos uma declaração');
		return false;
	}
}//teste se tem pelo penos uma declaracao selecionada para gerar a guia

function GuiaPagamento_TotalISS()
{
	if(document.getElementById('ckTodos').checked ==true)
	{
		 var aux = document.getElementById('txtTotalIssHidden').value;
		 var dados = aux.split("|");
		 var soma = 0;
		 
		 while(dados[1] >= 0)
		 {
		  document.getElementById('ckISS'+dados[1]).checked=true;
		  
		  aux= document.getElementById('ckISS'+dados[1]).value;
		  valor = aux.split("|");
		  document.getElementById('txtCodNota'+dados[1]).value=valor[1];
		  soma=parseFloat(soma)+parseFloat(valor[0]);
		  dados[1]--;
		 }
		 document.getElementById('txtTotalIss').value= DecToMoeda(soma);
		 if(document.getElementById('txtTotalPagar'))
			 CalculaMultaDes();
	}
	else
	{
		 var aux = document.getElementById('txtTotalIssHidden').value;
		 var dados = aux.split("|");
		 while(dados[1] >= 0)
		 {
		  document.getElementById('ckISS'+dados[1]).checked=false;
		  document.getElementById('txtCodNota'+dados[1]).value='';
		  dados[1]--;
		 }
		 document.getElementById('txtTotalIss').value=DecToMoeda(0);
		 if(document.getElementById('txtTotalPagar'))
			 CalculaMultaDes();
	}
}


function GuiaPagamento_SomaISS(iss)
{
	var valor = iss.value.split("|");
	var numero = iss.id.split("ckISS");
	if(iss.checked == true)
    {		
		var total = parseFloat(document.getElementById('txtTotalIss').value);				
		total+= parseFloat(valor[0]);		
		total = total.toFixed(2);		
		document.getElementById('txtTotalIss').value=total;
		document.getElementById('txtCodNota'+numero[1]).value=valor[1];
		
    }
	else
	{
		var total = parseFloat(document.getElementById('txtTotalIss').value);
		var valor = iss.value.split("|");
		total-= parseFloat(valor[0]);
		total = total.toFixed(2);
		document.getElementById('txtTotalIss').value=total;
		document.getElementById('txtCodNota'+numero[1]).value='';
	}
		
}



function CalculaMultaDes(){
	var mesComp = window.document.getElementById('cmbMes').value;
	var anoComp = window.document.getElementById('cmbAno').value;
	if (mesComp==''||anoComp=='')
		return false;
		
	var dataServ = window.document.getElementById('hdDataAtual').value.split('/');	
	var diaAtual = dataServ[0];
	var mesAtual = dataServ[1];
	var anoAtual = dataServ[2];
	
	var diaComp = window.document.getElementById('hdDia').value;
	mesComp = parseFloat(mesComp);
	mesComp++;
	
	var dataAtual = new Date(mesAtual+'/'+diaAtual+'/'+anoAtual);
	var dataComp = new Date(mesComp+'/'+diaComp+'/'+anoComp);
	var diasDec = diasDecorridos(dataComp,dataAtual);
	
	
	var nroMultas = window.document.getElementById('hdNroMultas').value;
	
	if(diasDec>0)
		var multa = 0;
	else
		var multa = -1;
		
	for(var c=0;c < nroMultas; c++){
		var diasMulta = window.document.getElementById('hdMulta_dias'+c).value;
		if(diasDec>diasMulta){
			var multa = c;	
			if(multa<nroMultas-1)
				multa++;
		}//end if
	}//end for
	
	if(document.getElementById('txtTotalIss'))
		var impostototal = MoedaToDec(window.document.getElementById('txtTotalIss').value);
	else
		var impostototal = MoedaToDec(window.document.getElementById('txtImpostoTotal').value);
	if(multa>=0){
		var multavalor = MoedaToDec(window.document.getElementById('hdMulta_valor'+multa).value);
		var multajuros = parseFloat(window.document.getElementById('hdMulta_juros'+multa).value);
		var jurosvalor = impostototal*multajuros/100;
		var multatotal = jurosvalor + multavalor;
		var totalpagar = multatotal + impostototal;
		window.document.getElementById('txtMultaJuros').value = DecToMoeda(multatotal);
		window.document.getElementById('txtTotalPagar').value = DecToMoeda(totalpagar);
	}
	else{
		window.document.getElementById('txtMultaJuros').value = '0,00';
		window.document.getElementById('txtTotalPagar').value = DecToMoeda(impostototal);
	}
}






// FUNÇÕES da GUIA DE PAGAMENTO fim

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






//mascara moeda
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



// JavaScript Document

<!-- 	 
var cont =0, contservicos =0;
 




function CancelarNota() //emissor
{
	if(!document.getElementById('txtMotivoCancelar').value)
		{
			alert("Informe o motivo do cancelamento.");
			return false;
		}	
	else
		{
			if (confirm('Tem certeza que deseja cancelar esta nota ?'))
				{
					return true;
				}
			else
				{ 
					return false;
				}
		}
}


function MostraAliquota()
{ 	 
 var aux = document.getElementById('cmbCodServico').value;
 var aliquota = aux.split("|");
 document.getElementById('txtAliquota').value=aliquota[0]; 
}

function MostraValorRPA()
{ 	 
 var aux = document.getElementById('cmbCodServico').value;
 var aliquota = aux.split("|");
 document.getElementById('txtAliquota').value=aliquota[0]; 
 document.getElementById('txtISS').value=DecToMoeda(aliquota[0]); 
}

function issmanual()
{
 var checado = document.getElementById('ISSManual').checked; 

 if(checado == true)
 {
   
  document.getElementById('DivISSRetido').style.display='block';
 
  
 }
 else
 {
  document.getElementById('txtPissretido').value=''	  	 
  document.getElementById('DivISSRetido').style.display='none';	 
  document.getElementById('txtBaseCalculo').focus();
  document.getElementById('txtBaseCalculo').blur();
  //document.getElementById('txtBaseCalculo').blur;
 }
 //document.getElementById('txtIssRetido').readOnly=false;
}//fim issmanual()

function inssmanual()
	{
		var checado = document.getElementById('INSSManual').checked; 
		if(checado == true)
			{
				document.getElementById('DivINSSRetido').style.display='block';
			}
		else
			{
				document.getElementById('txtPinssretido').value=''	  	 
				document.getElementById('DivINSSRetido').style.display='none';	 
				document.getElementById('txtBaseCalculo').focus();
				document.getElementById('txtBaseCalculo').blur();
			}
	}

function irmanual()
	{
		var checado = document.getElementById('IRManual').checked; 
		if(checado == true)
			{
				document.getElementById('DivIRRetido').style.display='block';
			}
		else
			{
				document.getElementById('txtPirretido').value=''	  	 
				document.getElementById('DivIRRetido').style.display='none';	 
				document.getElementById('txtBaseCalculo').focus();
				document.getElementById('txtBaseCalculo').blur();
			}
	}


/*
function ValorIss(cred1,cred2,cred3,cred4)
{
 	
 if(document.getElementById('txtPissretido').value>100){alert('Não é possível reter mais de 100% de ISS');}
 else{
 var credito_final ;	
 var credito = 0;	 
 var int;
 var float; 
 var tipopessoa = document.getElementById('frmInserir').txtTomadorCNPJ.value.length ; 
 
 var basecalc = document.getElementById('txtBaseCalculo').value;
 
 var valdeduc = document.getElementById('txtValorDeducoes').value;
 
 var aliquota = document.getElementById('txtAliquota').value; 
 
 if((tipopessoa ==14) || (tipopessoa ==18))
 {
	 
 if(aliquota != "")
 { 
  //separa os valores do combo e pega o valor do crédito
  var aux = document.getElementById('cmbCodServico').value;  
  var issretido = aux.split("|"); 
  
  
  var verificaissretido= document.getElementById('txtPissretido').value;
  if (verificaissretido !='')
  {
   issretido[2] = verificaissretido ; 	 
  } 
 
  if((basecalc != "") && (valdeduc !=""))
  {
   //calcula o iss
   var iss = parseFloat(basecalc) * parseFloat(aliquota)/100;  
   //a = Math.sqrt(iss);
   iss = iss.toFixed(2);
   document.getElementById('txtISS').value=iss;	   
  
   
   //verifica a quantidade de créditos que o tomador receberá, baseando-se no tipo de pessoa e se tem iss retido ou não.
   if( tipopessoa == 14)
   {	   
     if (issretido[2] != 0)
	 {
	  credito = cred3; 	 
	 }
	 else
	 {
	  credito = cred1;  	
	 }
   }
  
   else
   if( tipopessoa == 18 )
   {
     if (issretido[2] != 0)
	 {
	  credito = cred4; 	 
	 }
	 else
	 {
	  credito = cred2;  	
	 }
   }	
    
    //calcula o valor do ISS que será retido	
    var valor_issretido = parseFloat(basecalc) * parseFloat(issretido[2])/100;     
    
    valor_issretido = valor_issretido.toFixed(2);
	document.getElementById('txtIssRetido').value=valor_issretido;
   
    //calcula o valor total da nota
    var total = parseFloat(basecalc) + parseFloat(valdeduc);
    total = total - valor_issretido;
 //   a = Math.sqrt(total);
 //   total = a.toFixed(2);
    document.getElementById('txtValTotal').value=total;  
   
    //calcula o crédito final que o tomador receberá ao emitir a nota
    credito_final = (parseFloat(iss) * parseFloat(credito))/100;      
    credito_final = credito_final.toFixed(2);   
    document.getElementById('txtCredito').value=credito_final;
  }
 }
 else
 {
  alert("Selecione o serviço!");	 
 }
 }
 else
 {
  alert("CPF/CNPJ inválido!");	  
 }
}
}//fim valoriss()
*/


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


function excluirServico() 
{
  
  document.getElementById('camposservico'+contservicos).style.display='none';
  document.getElementById('linha01servico'+contservicos).style.display='none';
  //document.getElementById('linha02servico'+contservicos).style.display='none';
  document.getElementById('cmbCodigo'+contservicos).value="";
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

function ValidarInserirNota()
	{
		if((document.frmInserir.txtTomadorNome.value=="")||(document.frmInserir.txtTomadorCNPJ.value==""))
			{
				alert("Preencha corretamente o Nome/Razão Social e o CNPJ/CPF do tomador");
				return false;
			}
	}
	
//função genérica que requisita confirmação de envio
function Confirmacao(msg,caminho)	
    {
		if (confirm(msg))
			{
				window.location=caminho;	
			}
	}




function ConfirmaForm()
	{
		if (confirm('Deseja gerar esta guia?'))
			{   
			  return true;
			}
		else
		    {
			  return false;	 
			}
	}	
	
function CalculaINSS()
	{
		var base=document.getElementById('txtBaseCalculo').value;		
		var baseaux=document.getElementById('txtBaseCalculoAux').value;
		var inss=document.getElementById('txtPinssretido').value;
		if((base!="")&&(inss!=""))
			{
				if (inss<=100)
					{   
					    if(!(baseaux)){
						    document.getElementById('txtBaseCalculoAux').value=document.getElementById('txtBaseCalculo').value;
						}
						
						baseaux=document.getElementById('txtBaseCalculoAux').value;
						var x=(inss*100)/baseaux;
						base=baseaux-x;
						document.getElementById('txtBaseCalculo').value=base;
						document.getElementById('txtBaseCalculo').onblur();
					}
				else{alert('Não é possível reter um valor de INSS maior que 100%');}	
			}
	}
function CalculaIR()
	{
		var base=document.getElementById('txtBaseCalculo').value;
		var ir=document.getElementById('txtPirretido').value;
		if((base!="")&&(ir!=""))
			{
				if (ir<=100)
					{
						var x=(ir*100)/base;
						base=base-x;
						document.getElementById('txtBaseCalculo').value=base;
						document.getElementById('txtBaseCalculo').onblur();
					}
				else{alert('Não é possível reter um valor de IR maior que 100%');}	
			}
	}