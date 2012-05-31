
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

function ValidarDesIssRetido() {
	var total = totalemissores_des;

	if ((!(document.getElementById('cmbAno').value))
			|| (!(document.getElementById('cmbMes').value))) {
		alert('Informe a competência da declaração !');
		return false;
	}

	if (!(document.getElementById('txtRazaoNome').value)) {
		alert('Informe sua RazãoSocial/Nome!');
		return false;
	}
	for (c = 1; total >= c; total--) {

		if ((!(document.getElementById('txtcnpjcpf' + total).value))
				|| (!(document.getElementById('txtNroNota' + total).value))
				|| (!(document.getElementById('txtValIssRetido' + total).value))) {
			alert('Preencha os campos Obrigatórios para realizar a declaração!');
			return false;
		}
		if (document.getElementById('hdvalidar' + total).value == 'n') {
			alert('Emissor Digitado não consta em nosso sistema, Favor verifique os dados !');
			document.getElementById('txtcnpjcpf' + total).focus();
			return false;
		}
		return true;

	}
}

function SomaIssRetido() {
	var soma = 0;
	var total = totalemissores_des;
	for (c = 1; total >= c; total--) {
		soma += MoedaToDec(document.getElementById('txtValIssRetido' + total).value);
	}
	document.getElementById('txtImpostoTotal').value = DecToMoeda(soma);
}

function ConsultaCnpj(campo, cont) {
	
	ajax({
		url: 'inc/verificaprestadorcnpj.ajax.php?valor=' + campo.value,
		espera: function(){
			document.getElementById('divtxtcnpjcpf' + cont).innerHTML = '<font color="gray">Verificando...</font>';
		},
		sucesso: function() {
			var resposta = respostaAjax;
			if (resposta == 'Emissor não cadastrado') {
				document.getElementById('hdvalidar' + cont).value = 'n';
				resposta = '<font color=#ff0000>' + resposta + '</font>';
			} else {
				document.getElementById('hdvalidar' + cont).value = 's';
			}
			// Abaixo colocamos a resposta na div do campo que fez a requisição
			document.getElementById('divtxtcnpjcpf' + cont).innerHTML = resposta;
		}
	});/*
	// Verificar o Browser
	// Firefox, Google Chrome, Safari e outros
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	}
	// Internet Explorer
	else if (window.ActiveXObject) {
		req = new ActiveXObject("Microsoft.XMLHTTP");
	}

	var url = 'inc/verificaprestadorcnpj.ajax.php?valor=' + campo.value;

	req.open("Get", url, true);

	// Quando o objeto recebe o retorno, chamamos a seguinte função;
	req.onreadystatechange = function() {

		// Exibe a mensagem "Verificando" enquanto carrega
		if (req.readyState == 1) {
			document.getElementById('divtxtcnpjcpf' + cont).innerHTML = '<font color="gray">Verificando...</font>';
		}

		// Verifica se o Ajax realizou todas as operações corretamente
		// (essencial)
		if (req.readyState == 4 && req.status == 200) {
			// Resposta retornada pelo validacao.php
			var resposta = req.responseText;
			if (resposta == 'Emissor não cadastrado') {
				document.getElementById('hdvalidar' + cont).value = 'n';
				resposta = '<font color=#ff0000>' + resposta + '</font>';
			} else {
				document.getElementById('hdvalidar' + cont).value = 's';
			}
			// Abaixo colocamos a resposta na div do campo que fez a requisição
			document.getElementById('divtxtcnpjcpf' + cont).innerHTML = resposta;
		}

	};
	req.send(null);*/
}

var cont = 0, contservicos = 1, conttbl = 0, totalemissores_des = 0;


function CalculaMultaDes() {
	var mesComp = window.document.getElementById('cmbMes').value;
	var anoComp = window.document.getElementById('cmbAno').value;
	if (mesComp == '' || anoComp == '')
		return false;

	var dataServ = window.document.getElementById('hdDataAtual').value
			.split('/');
	var diaAtual = dataServ[0];
	var mesAtual = dataServ[1];
	var anoAtual = dataServ[2];

	var diaComp = window.document.getElementById('hdDia').value;
	mesComp = parseFloat(mesComp) + 1;

	var dataAtual = new Date(mesAtual + '/' + diaAtual + '/' + anoAtual);
	var dataComp = new Date(mesComp + '/' + diaComp + '/' + anoComp);
	var diasDec = diasDecorridos(dataComp, dataAtual);

	var nroMultas = window.document.getElementById('hdNroMultas').value;

	if (diasDec > 0)
		var multa = 0;
	else
		var multa = -1;

	for ( var c = 0; c < nroMultas; c++) {
		var diasMulta = window.document.getElementById('hdMulta_dias' + c).value;
		if (diasDec > diasMulta) {
			var multa = c;
			if (multa < nroMultas - 1)
				multa++;
		}// end if
	}// end for

	if (document.getElementById('txtTotalIss'))
		var impostototal = MoedaToDec(window.document
				.getElementById('txtTotalIss').value);
	else
		var impostototal = MoedaToDec(window.document
				.getElementById('txtImpostoTotal').value);
	if (multa >= 0) {
		var multavalor = 0;
		var multajuros = 0;
		if(window.document.getElementById('hdMulta_valor'+multa)){
			multavalor = MoedaToDec(window.document.getElementById('hdMulta_valor'+multa).value);
		}
		if(window.document.getElementById('hdMulta_juros'+multa)){
			multajuros = parseFloat(window.document.getElementById('hdMulta_juros'+multa).value);
		}
		var jurosvalor = impostototal * multajuros / 100;
		var multatotal = jurosvalor + multavalor;
		var totalpagar = multatotal + impostototal;
		window.document.getElementById('txtMultaJuros').value = DecToMoeda(multatotal);
		window.document.getElementById('txtTotalPagar').value = DecToMoeda(totalpagar);
	} else {
		window.document.getElementById('txtMultaJuros').value = '0,00';
		window.document.getElementById('txtTotalPagar').value = DecToMoeda(impostototal);
	}
}

function DesTomadores(i) {

	var div = document.getElementById('divEmissores');

	if (i == 'inserir') {
		var contador = conttbl;
		var valorCPF = new Array(conttbl);
		var valorNRONOTA = new Array(conttbl);
		var valorISSRETIDO = new Array(conttbl);
		var valorVALNOTA = new Array(conttbl);

		while (contador > 0) {
			if (document.getElementById('txtcnpjcpf' + contador).value) {
				valorCPF[contador] = document
						.getElementById('txtcnpjcpf' + contador).value;
			}

			if (document.getElementById('txtNroNota' + contador).value) {
				valorNRONOTA[contador] = document
						.getElementById('txtNroNota' + contador).value;
			}

			if (document.getElementById('txtValNota' + contador).value) {
				valorVALNOTA[contador] = document
						.getElementById('txtValNota' + contador).value;
			}

			if (document.getElementById('txtValIssRetido' + contador).value) {
				valorISSRETIDO[contador] = document
						.getElementById('txtValIssRetido' + contador).value;
			}
			contador--;

		}

		conttbl++;
		totalemissores_des++;

		var div = document.getElementById('divEmissores');
		div.innerHTML = div.innerHTML
				+ "<table id='tbl"
				+ conttbl+ "' width='100%' border='0'><tr><td width='24%' align=center><font color='#FF0000'>*</font><input onkeydown='return NumbersOnly( event );' onkeyup='CNPJCPFMsk( this );' onblur='ConsultaCnpj(txtcnpjcpf"
				+ conttbl+ ","+ conttbl+ ");' size='18' id='txtcnpjcpf"+ conttbl+ "' name='txtcnpjcpf"
				+ conttbl+ "' class='texto' type='text'></font></td><td width='22%' align=center><font color='#FF0000'>*</font><input name='txtNroNota"
				+ conttbl+ "' id='txtNroNota"
				+ conttbl+ "' size='14' class='texto' type='text'><input type='hidden' id='hdvalidar"
				+ conttbl+ "'></td><td width='29%' align=center><font color='#FF0000'>*</font><input type='text' class='texto' id='txtValNota"
				+ conttbl+ "' name='txtValNota"	+ conttbl+ "' onkeyup='MaskMoeda(this)' size='14'></td><td width='25%' align=center><font color='#FF0000'>*</font><input name='txtValIssRetido"
				+ conttbl+ "' onkeyup='MaskMoeda(this)' onblur='SomaIssRetido();CalculaMultaDes();' id='txtValIssRetido"
				+ conttbl+ "' class='texto' type='text' size='14'></td></tr><tr><td colspan='4'><div id='divtxtcnpjcpf"
				+ conttbl + "' align='center'> </div></td></tr></table>";

		if (contador >= 0) {
			while (contador < conttbl) {
				if (valorCPF[contador]) {
					document.getElementById('txtcnpjcpf' + contador).value = valorCPF[contador];
				}

				if (valorNRONOTA[contador]) {
					document.getElementById('txtNroNota' + contador).value = valorNRONOTA[contador];
				}

				if (valorVALNOTA[contador]) {
					document.getElementById('txtValNota' + contador).value = valorVALNOTA[contador];
				}

				if (valorISSRETIDO[contador]) {
					document.getElementById('txtValIssRetido' + contador).value = valorISSRETIDO[contador];
				}
				contador++;
			}
		}

		if (conttbl > 1) {
			document.getElementById('btRemover').disabled = false;
		}

	}

	else if (i == 'deletar') {
		if ((conttbl != 0) && (conttbl != 1)) {
			var tabela = document.getElementById('tbl' + conttbl);
			div.removeChild(tabela);
			conttbl--;
			totalemissores_des--;
		}
		if (conttbl <= 1) {
			document.getElementById('btRemover').disabled = true;
		}
	}

}


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


function verificaCnpjCpfIm(){
	if(document.getElementById('txtInscMunicipal')&&(document.getElementById('txtCNPJ'))){
		if(!document.getElementById('txtCNPJ').value&&!document.getElementById('txtInscMunicipal').value) {
			alert('Favor preencher um dos campos para avançar!');
			document.getElementById('txtCNPJ').focus();
			return false;
		}
		if(document.getElementById('txtCNPJ').value&&document.getElementById('txtInscMunicipal').value) {
			alert('Preencher apenas um dos campos!');
			document.getElementById('txtCNPJ').focus();
			return false;
		}
		if (!document.getElementById('txtInscMunicipal').value&&(document.getElementById('txtCNPJ').value.length!=14)&&(document.getElementById('txtCNPJ').value.length!=18)) {
			alert('CNPJ/CPF inválido! Favor verificar');
			document.getElementById('txtCNPJ').focus();
			return false;
		}
	}else{
		if((!document.getElementById('txtCNPJ').value)||(!document.getElementById('txtSenha').value)) {
			alert('Favor preencher os campos para avançar!');
			document.getElementById('txtCNPJ').focus();
			return false;
		}
		if ((document.getElementById('txtCNPJ').value.length!=14)&&(document.getElementById('txtCNPJ').value.length!=18)) {
			alert('CNPJ/CPF inválido! Favor verificar');
			document.getElementById('txtCNPJ').focus();
			return false;
		}
	}
}


function buscaCidades(campo, resultado, cadastro) {
	if(cadastro === undefined) cadastro = true;
	
	if(campo.value!=''){
		var url = cadastro ? 'inc/listamunicipio.ajax.php?UF='+campo.value :'../inc/listamunicipio.ajax.php?UF='+campo.value;
		
		ajax({
			url:url,
			espera: function(){
				document.getElementById(resultado).innerHTML = '<select style="width:150px;"><option/></select>';
			},
			sucesso: function() {
				document.getElementById(resultado).innerHTML = respostaAjax;
			},
			erro: function() {
				ajax({
					url:'../'+url,
					espera: function(){
						document.getElementById(resultado).innerHTML = '<select style="width:150px;"><option/></select>';
					},
					sucesso: function() {
						document.getElementById(resultado).innerHTML = respostaAjax;
					}
				});
			}
		});
	}else{
		document.getElementById(resultado).innerHTML = '<select style="width:150px;"><option/></select>';
	}
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
    partes=data.split("/");
    if (partes.length=3)
        d=new Date(partes[2],partes[1],partes[0])
    else
        d=new date();
    return d;
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

function CancelarNota(id)
{
    if (confirm('Tem certeza que deseja cancelar esta nota ?'))
   {
    window.location.href='inc/notas_cancelar.php?CODIGO='+ id;
   }
   else
   { window.alert("Operação não realizada!")
	 history.go(-2);  
   }
}


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
		var ascii = event.keyCode;
		if (saida == "A") {
			if ((ascii >=97) && (ascii <= 122)) { event.keyCode -= 32; }
			else { event.keyCode = 0; }
		} else if (saida == "0") {
			if ((ascii >= 18) && (ascii <= 57)) { return }
			else { event.keyCode = 0 };
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

function ServicosCategorias(categoria)
	{
		var dados;		
			dados=categoria.value;
		if(dados !="")
		{	
			dados = dados.split("|");					
			while(dados[2] > 0)
			{				 
			 if(document.getElementById('div'+dados[2]+dados[1])){
				document.getElementById('div'+dados[2]+dados[1]).style.display='none';
			 }
			 
			 if(document.getElementById('cmbCodigo'+dados[2]+dados[1])){
			 	document.getElementById('cmbCodigo'+dados[2]+dados[1]).value='';
			 }
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
   //document.getElementById('cmbCodigo'+dados[1]+dados[2]).value='';
   document.getElementById('cmbCategoria'+dados[2]).value='';
   //document.getElementById('div'+dados[1]+dados[2]).style.display='none';
   dados[1]--;
  }
  contservicos--;
}

<!-- muda propriedade de uma div
function changeProp(objId,x,theProp,theValue) { //v9.0
  var obj = null; with (document){ if (getElementById)
  obj = getElementById(objId); }
  if (obj){
    if (theValue == true || theValue == false)
      eval("obj.style."+theProp+"="+theValue);
    else eval("obj.style."+theProp+"='"+theValue+"'");
  }
}
//-->
