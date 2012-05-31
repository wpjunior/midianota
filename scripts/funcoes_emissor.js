
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


