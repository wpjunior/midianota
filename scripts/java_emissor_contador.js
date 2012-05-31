
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

function calculaISSNfe(hidden, cont){
	
	var iss = (MoedaToDec(document.getElementById('txtBaseCalcServico'+cont).value) * MoedaToDec(document.getElementById('txtAliqServico'+cont).value))/100
	
	document.getElementById('txtValorIssServico'+cont).value = DecToMoeda(iss);
	
	var quantidade = document.getElementById(hidden).value;
	var valorISS = 0;
	var issRetido = 0;
	var valorISSRetido = 0;
	var totalAliquota = 0;
	var baseCalc = 0;

	for(var cont=1;cont <= quantidade; cont++){
		
		valorISS = valorISS + MoedaToDec(document.getElementById('txtValorIssServico'+cont).value);
		valorISSRetido = valorISSRetido + MoedaToDec(document.getElementById('txtISSRetidoManual'+cont).value);
		totalAliquota = parseFloat(totalAliquota) + parseFloat(document.getElementById('txtAliqServico'+cont).value);
		baseCalc = baseCalc + MoedaToDec(document.getElementById('txtBaseCalcServico'+cont).value);
		
		if(MoedaToDec(document.getElementById('txtBaseCalcServico'+cont).value) > 0){
			if(valorISSRetido > baseCalc){

				valorISSRetido = baseCalc;
				document.getElementById('txtISSRetidoManual'+cont).value = document.getElementById('txtBaseCalcServico'+cont).value;
			}
		}/*else if(MoedaToDec(document.getElementById('txtISSRetidoManual'+cont).value) > 0){
			if(MoedaToDec(document.getElementById('txtISSRetidoManual'+cont).value) >= MoedaToDec(document.getElementById('txtValTotal').value)){
				document.getElementById('txtISSRetidoManual'+cont).value = document.getElementById('txtValTotal').value;
				valorISSRetido = valorISSRetido + MoedaToDec(document.getElementById('txtISSRetidoManual'+cont).value);
			}
		}*/
	}
	document.getElementById('txtAliquota').value = totalAliquota;
	document.getElementById('txtBaseCalculo').value = DecToMoeda(baseCalc);
	document.getElementById('txtISS').value = DecToMoeda(valorISS);
	document.getElementById('txtIssRetido').value = DecToMoeda(valorISSRetido);

	
	document.getElementById('txtBaseCalculo').onblur();
}


/**
*Funcao para adicionar uma nova linha de servico para a nota
*@param id = Tabela onde vai ser inserido nova linha
*/
function adicionaLinhaNfe(id){  


	var quantidade = document.getElementById('hdInputs').value;
	
	var codemissor = document.getElementById('hdCodemissor').value;	
	
	var cont = quantidade;
	var valorSERVICO = new Array(quantidade);
	var valorBASECALC = new Array(quantidade);
	var valorALIQUOTA = new Array(quantidade);
	var valorISS = new Array(quantidade);
	var indiceCombos = [];
	var Combo;
	
	while(cont > 0){
		if (document.getElementById('cmbCodServico' + cont).value) {
			valorSERVICO[cont] = document.getElementById('cmbCodServico' + cont).selectedIndex;
		}
		if (document.getElementById('txtBaseCalcServico' + cont).value) {
			valorBASECALC[cont] = document.getElementById('txtBaseCalcServico' + cont).value;
		}
		if (document.getElementById('txtAliqServico' + cont).value) {
			valorALIQUOTA[cont] = document.getElementById('txtAliqServico' + cont).value;
		}
		if (document.getElementById('txtValorIssServico' + cont).value) {
			valorISS[cont] = document.getElementById('txtValorIssServico' + cont).value;
		}
		cont--;	
	}
	quantidade++;
	
	//Inseri mais uma linha
	ajax({
		url:'../site/linha_nova_nfe/novalinha.php?quantidade='+quantidade+'&codemissor='+codemissor+'&a=a',
		sucesso: function(){
			document.getElementById(id).innerHTML = document.getElementById(id).innerHTML + respostaAjax;	
			document.getElementById('hdInputs').value = quantidade;
			
			if (cont >= 0) {
				cont = cont + 1;
				while (cont <= quantidade) {
		
					if (valorSERVICO[cont]) {
						
						document.getElementById('cmbCodServico' + cont).selectedIndex = valorSERVICO[cont];
						Combo = document.getElementById('cmbCodServico' + cont);
						indiceCombos.push(Combo.options[Combo.selectedIndex].value);
					}
					if (valorBASECALC[cont]) {
						document.getElementById('txtBaseCalcServico' + cont).value = valorBASECALC[cont];
					}
			
					if (valorALIQUOTA[cont]) {
						document.getElementById('txtAliqServico' + cont).value = valorALIQUOTA[cont];
					}
			
					if (valorISS[cont]) {
						document.getElementById('txtValorIssServico' + cont).value = valorISS[cont];
					}
					cont++;
				}
			}
			
			tamCombo = document.getElementById('cmbCodServico' + quantidade).length-1;
			for(contador = tamCombo;contador >= 0;contador--){
				for(var contArray in indiceCombos){
					if(document.getElementById('cmbCodServico' + quantidade).options[contador].value == indiceCombos[contArray]){
						document.getElementById('cmbCodServico' + quantidade).remove(contador);
					}
				}
			}
			
			if (quantidade > 1) {
				if(document.getElementById('btRemover')){
					document.getElementById('btRemover').disabled = false;
				}
			}
			
			if(document.getElementById('hdLimite')){
				if(quantidade >= document.getElementById('hdLimite').value){
					if(document.getElementById('btAdicionar')){
						document.getElementById('btAdicionar').disabled = true;
					}
				}
			}

		}
	});
	
	
}  

function removerLinhasNfe(id){
	
	var quantidade = document.getElementById('hdInputs').value;
	var div = document.getElementById(id);
	
	if ((quantidade != 0) && (quantidade != 1)) {

			var ultimaLinhaDiv = document.getElementById('tbl' + quantidade);
			div.removeChild(ultimaLinhaDiv);
			quantidade--;
			document.getElementById('hdInputs').value = quantidade;
	}
	
	if (quantidade <= 1) {
		document.getElementById('btRemover').disabled = true;
	}
	
	if(document.getElementById('hdLimite')){
		if (quantidade < document.getElementById('hdLimite').value) {
			document.getElementById('btAdicionar').disabled = false;
		}
	}
	
	document.getElementById('txtBaseCalcServico1').onblur();
		
}


function servicoNota(tipo, div){
	
	if(tipo == 'adicionar'){
		
		adicionaLinhaNfe(div);
		
	}else if(tipo == 'remover'){
	
		removerLinhasNfe(div);
		
	}else{
	
		alert('Não foi informado parametro na função');
		
	}
	
}



// FUNÇÕES da GUIA DE PAGAMENTO

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
		  //document.getElementById('ckISS'+dados[1]).disabled=true;
		  
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
		  //document.getElementById('ckISS'+dados[1]).disabled=false;
		  document.getElementById('ckISS'+dados[1]).checked=false;
		  document.getElementById('txtCodNota'+dados[1]).value='';
		  dados[1]--;
		 }
		 document.getElementById('txtTotalIss').value=DecToMoeda(0);
		 if(document.getElementById('txtTotalPagar'))
			 CalculaMultaDes();
	}
}

function ValidaCkbDec(campo){
	var total = MoedaToDec(document.getElementById(campo).value);
	if(total>0){
		return true;
	}else{
		alert('É necessário que escolha ao menos uma declaração');
		return false;
	}
}//teste se tem pelo penos uma declaracao selecionada para gerar a guia

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




function GuiaPagamento_SomaISS(iss)
{
	var valor = iss.value.split("|");
	var numero = iss.id.split("ckISS");
	if(iss.checked == true)
    {		
		var total = MoedaToDec(document.getElementById('txtTotalIss').value);				
		total+= parseFloat(valor[0]);		
		total = total.toFixed(2);		
		document.getElementById('txtTotalIss').value=DecToMoeda(total);
		document.getElementById('txtCodNota'+numero[1]).value=valor[1];
		if(document.getElementById('txtTotalPagar'))
			CalculaMultaDes();
    }
	else
	{
		var total = MoedaToDec(document.getElementById('txtTotalIss').value);
		var valor = iss.value.split("|");
		total-= parseFloat(valor[0]);
		total = total.toFixed(2);
		document.getElementById('txtTotalIss').value=DecToMoeda(total);
		document.getElementById('txtCodNota'+numero[1]).value='';
		if(document.getElementById('txtTotalPagar'))
			CalculaMultaDes();
	}
		
}
// FUNÇÕES da GUIA DE PAGAMENTO fim




function issmanual()
{
 var checado = document.getElementById('ISSManual').checked; 

 if(checado == true)
 {
  document.getElementById('DivISSRetido').style.display='block';
 }
 else
 {
  document.getElementById('txtPissretido').value='';  	 
  document.getElementById('DivISSRetido').style.display='none';	 
  document.getElementById('txtBaseCalculo').focus();
  document.getElementById('txtBaseCalculo').blur();
  //document.getElementById('txtBaseCalculo').blur;
 }
 //document.getElementById('txtIssRetido').readOnly=false;
 
 
}

function inssmanual()
	{
		var checado = document.getElementById('INSSManual').checked; 
		var base         = document.getElementById('txtBaseCalculoAux').value;
		//var valorinicial = document.getElementById('hdValorInicial').value;
		if(checado == true)
			{
				//document.getElementById('hdValorInicial').value = base;
				document.getElementById('DivINSSRetido').style.display='block';
			}
		else
			{
				document.getElementById('txtBaseCalculo').value = document.getElementById('hdCalculos').value;
				document.getElementById('txtPinssretido').value='';	  	 
				document.getElementById('DivINSSRetido').style.display='none';	 
				document.getElementById('txtBaseCalculo').focus();
				document.getElementById('txtBaseCalculo').blur();
			}
	}

function irmanual()
	{
		var checado      = document.getElementById('IRManual').checked;
		var base         = document.getElementById('txtBaseCalculoAux').value;
		//var valorinicial = document.getElementById('hdValorInicial').value;
		if(checado == true)
			{
				//document.getElementById('hdValorInicial').value = base;
				document.getElementById('DivIRRetido').style.display='block';
			}
		else
			{
				document.getElementById('txtBaseCalculo').value = document.getElementById('hdCalculos').value;
				document.getElementById('txtPirretido').value='';	  	 
				document.getElementById('DivIRRetido').style.display='none';	 
				document.getElementById('txtBaseCalculo').focus();
				document.getElementById('txtBaseCalculo').blur();
			}
	}

function baseCalcPct(tributo){
	
	var base_calculo = document.getElementById('txtBaseCalculo');
	var valor_baseCalculo = MoedaToDec(base_calculo.value);
	var campoPctBC = "";
	var campoValorBC = "";
	var aliqTributo = "";
	var valorTributo = "";
	
	if(tributo == "INSS"){
		
		campoPctBC = "txtINSSBCpct";
		campoValorBC = "txtINSSBC";
		aliqTributo = "txtAliquotaINSS";
		valorTributo = "txtValorINSS";
		
	}else if(tributo == "IRRF"){
		
		campoPctBC = "txtIRRFBCpct";
		campoValorBC = "txtIRRFBC";
		aliqTributo = "txtIRRF";
		valorTributo = "txtValorIRRF";
		
	}
	
	if(valor_baseCalculo > 0){
		
		var pctTributo = document.getElementById(campoPctBC).value;
		
		if(pctTributo > 100){
			pctTributo = 100;
			document.getElementById(campoPctBC).value = 100;
		}else if(pctTributo == ""){
			pctTributo = 0;
		}
		
		var calculo = (parseFloat(valor_baseCalculo) * parseFloat(pctTributo))/100;
		
		document.getElementById(campoValorBC).value = DecToMoeda(calculo);
		
		if((MoedaToDec(document.getElementById(campoValorBC).value) > 0) && (MoedaToDec(document.getElementById(campoPctBC).value) > 0)){
			
			//Habilita os campos

			document.getElementById(valorTributo).disabled = false;
			
			if(document.getElementById(aliqTributo).value > 0){
				document.getElementById('txtBaseCalculo').onblur();
			}
		}else{
			
			//Zera os valores
			document.getElementById(aliqTributo).value = 0;
			document.getElementById(valorTributo).value = 0; 
			
			//Desabilita os campos
			 
			document.getElementById(valorTributo).disabled = true;
			
			if(campoPctBC == "txtIRRFBCpct"){
				document.getElementById('txtDeducIRRF').value = 0;
				document.getElementById('txtValorFinalIRRF').value = 0;
				document.getElementById('txtDeducIRRF').disabled = true;
			}
			
			document.getElementById('txtBaseCalculo').onblur();
			
		}
		
	}else{
		alert('Insira a base de calculo');
		document.getElementById(aliqTributo).value = 0;
		document.getElementById(campoPctBC).value = 0;
		base_calculo.focus();
	}
}


function ValorIss(regras_de_credito)
{
	var aux = document.getElementById('cmbCodServico1').value;  
	var basecalculorpa = aux.split("|"); 
	var basecalculorpa= basecalculorpa[3];
	
	var credito_final;	
	var credito = 0;	 
	var int;
	var float; 
	var tipopessoa = document.getElementById('txtTomadorCNPJ').value.length;
	
	var basecalc = MoedaToDec(document.getElementById('txtBaseCalculo').value);
	
	var valdeduc = MoedaToDec(document.getElementById('txtValorDeducoes').value);
	
	var aliquota = document.getElementById('txtAliquota').value;
	
	document.getElementById('txtBaseCalculoAux').value = DecToMoeda(basecalc);
	
	document.getElementById('txtBaseCalculo').value = DecToMoeda(basecalc);
	
	if((basecalculorpa != undefined) && (basecalculorpa>0)){		
		basecalc = basecalculorpa;	
	}
	var base = document.getElementById('txtBaseCalculo').value;
	document.getElementById('hdCalculos').value = base;
	
	
	//--------------------------------------------------------------------------------------
	//Verifica se foi mudado o valor da base de calculo, para que possa corrigir os percentuais dos tributos
	if((MoedaToDec(document.getElementById('hdValorInicial').value) == 0) || (document.getElementById('hdValorInicial').value == "")){
	
		document.getElementById('hdValorInicial').value = base;	
	
	}else if((document.getElementById('hdValorInicial').value != base)&&((basecalculorpa == undefined ) || (basecalculorpa<=0))){
	
		document.getElementById('hdValorInicial').value = base;
		document.getElementById('txtIRRFBCpct').onblur();
		document.getElementById('txtINSSBCpct').onblur();
	
	}
	//---------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------
	//Verifica e calcula o IRRF da nota
	if(document.getElementById('txtIRRF').value > 0){
	
		if((!document.getElementById('txtIRRFBCpct').value) || (document.getElementById('txtIRRFBCpct').value < 1)){
			document.getElementById('txtIRRFBCpct').value = 100;
			document.getElementById('txtIRRFBCpct').onblur();
		}
		var deducoes = 0;
		var baseCalcPct = MoedaToDec(document.getElementById('txtIRRFBC').value);
		var IRRF = document.getElementById('txtIRRF').value;
		if(IRRF > 100){
			IRRF = 100;
			document.getElementById('txtIRRF').value = 100;
		}
		var campoIRRF = (baseCalcPct*IRRF)/100;
		document.getElementById('txtValorIRRF').value = DecToMoeda(campoIRRF);
		if(document.getElementById('txtDeducIRRF').disabled == true){
			document.getElementById('txtDeducIRRF').disabled = false;
		}
		
		if(MoedaToDec(document.getElementById('txtDeducIRRF').value) > 0){
			deducoes = MoedaToDec(document.getElementById('txtDeducIRRF').value);
		}
		if(deducoes > campoIRRF){
			deducoes = campoIRRF;
			document.getElementById('txtDeducIRRF').value = DecToMoeda(deducoes);
		}
		var valorIRRFfinal = parseFloat(campoIRRF) - parseFloat(deducoes);
		document.getElementById('txtValorFinalIRRF').value = DecToMoeda(valorIRRFfinal);
	
	}else{
		document.getElementById('txtValorIRRF').value = 0;
		document.getElementById('txtValorFinalIRRF').value = 0;
		document.getElementById('txtDeducIRRF').value = 0;
		document.getElementById('txtDeducIRRF').disabled = true;
	}
	//------------------------------------------------------------------------------------
	
	//------------------------------------------------------------------------------------
	//Verifica e calcula o INSS da nota
	if(document.getElementById('txtAliquotaINSS').value > 0){
	
		if((!document.getElementById('txtINSSBCpct').value) || (document.getElementById('txtINSSBCpct').value < 1)){
			document.getElementById('txtINSSBCpct').value = 100;
			document.getElementById('txtINSSBCpct').onblur();
		} 
		var baseCalcPct = MoedaToDec(document.getElementById('txtINSSBC').value);
		var INSS = document.getElementById('txtAliquotaINSS').value;
		if(INSS > 100){ 
			INSS = 100;
			document.getElementById('txtAliquotaINSS').value = 100;
		}
		var campoINSS = (baseCalcPct*INSS)/100;
		document.getElementById('txtValorINSS').value = DecToMoeda(campoINSS);
	
	}else{
		document.getElementById('txtValorINSS').value = 0;
	}
	//-------------------------------------------------------------------------------------
	
	if((tipopessoa == 14) || (tipopessoa == 18)){
		
		if(aliquota != ""){
			
			if(basecalc != ""){
				
				//calcula o valor total da nota
				var total = parseFloat(basecalc) + parseFloat(valdeduc);
				
				var qual_tipopessoa = (tipopessoa == 14) ? "PF" : "PJ";
				
				var issretido = MoedaToDec(document.getElementById('txtIssRetido').value);
				var tem_issretido   = (issretido > 0) ? "S" : "N";
				
				var array_regras_credito = regras_de_credito.split("-");
				for(var cont in array_regras_credito){
					var array_campos_nfecredito = array_regras_credito[cont].split("|");
					if(array_campos_nfecredito[0] == qual_tipopessoa){
						if(array_campos_nfecredito[1] == tem_issretido){
							if(total <= array_campos_nfecredito[2]){
								credito = array_campos_nfecredito[3];
							}
						}
					}
				}				
				
				var valor_issretido = MoedaToDec(document.getElementById('txtIssRetido').value);
				total = total - valor_issretido;
				document.getElementById('txtValTotal').value=DecToMoeda(total);
				
				//calcula o crédito final que o tomador receberá ao emitir a nota
				var iss = document.getElementById('txtISS').value;
				
				credito_final = (MoedaToDec(iss) * parseFloat(credito))/100;
				//credito_final = credito_final.toFixed(2);
				document.getElementById('txtCredito').value=DecToMoeda(credito_final);
				
				//-------------------------------------------------------------------------------------
				//Soma todos os campos de rentencao e mostra para o usuario
				var campoISSRetido = 0;
				var campoINSS = 0;
				var campoIRRF = 0;
				var TotalRentencao = 0;
				
				campoISSRetido = MoedaToDec(document.getElementById('txtIssRetido').value);
				campoINSS = MoedaToDec(document.getElementById('txtValorINSS').value);
				campoIRRF = MoedaToDec(document.getElementById('txtValorFinalIRRF').value);
				
				TotalRentencao = parseFloat(campoISSRetido) + parseFloat(campoINSS) + parseFloat(campoIRRF);
				document.getElementById('txtValTotalRetencao').value = DecToMoeda(TotalRentencao);
				//--------------------------------------------------------------------------------------
				
				
				}//fim if
		}//fim if aliquota
	}else{
		alert("CPF/CNPJ inválido!");
	}//fim else
}//fim da funcao

function ValorIssRPA(cred_pf_n,val_pf_n,cred_pf_s,val_pf_s,cred_pj_n,val_pj_n,cred_pj_s,val_pj_s)
{
	
	if(document.getElementById('txtPissretido').value>100){ 
	 	document.getElementById('txtPissretido').value = 100; 
		alert('Não é possível reter mais de 100% de ISS');
	}
	 else{
	 var credito_final;	
	 var credito = 0;	 
	 var int;
	 var float; 
	 var tipopessoa = document.getElementById('frmInserir').txtTomadorCNPJ.value.length;
	 

	 var basecalc = MoedaToDec(document.getElementById('txtBaseCalculo').value);



	 	 
	 var valdeduc = MoedaToDec(document.getElementById('txtValorDeducoes').value);
	 
	 var aliquota = document.getElementById('txtAliquota').value;
	 
	 document.getElementById('txtBaseCalculoAux').value = DecToMoeda(basecalc);
	 
	 document.getElementById('txtBaseCalculo').value = DecToMoeda(basecalc);
	 
	 var base = document.getElementById('txtBaseCalculo').value;
	 document.getElementById('hdCalculos').value = base;

	 //--------------------------------------------------------------------------------------
	 //Verifica se foi mudado o valor da base de calculo, para que possa corrigir os percentuais dos tributos
	 if((MoedaToDec(document.getElementById('hdValorInicial').value) == 0) || (document.getElementById('hdValorInicial').value == "")){
		 
	 	document.getElementById('hdValorInicial').value = base;	
		
	 }else if(document.getElementById('hdValorInicial').value != base){
		 
		document.getElementById('hdValorInicial').value = base;
		document.getElementById('txtIRRFBCpct').onblur();
		document.getElementById('txtINSSBCpct').onblur();
		
	 }
	 //---------------------------------------------------------------------------------------
	 
	 //----------------------------------------------------------------------------------
	 //Verifica e calcula o IRRF da nota
	 if(document.getElementById('txtIRRF').value > 0){
		 
		var deducoes = 0;
		var baseCalcPct = MoedaToDec(document.getElementById('txtIRRFBC').value);
	 	var IRRF = document.getElementById('txtIRRF').value;
		var campoIRRF = (baseCalcPct*IRRF)/100;
		document.getElementById('txtValorIRRF').value = DecToMoeda(campoIRRF);
		if(document.getElementById('txtDeducIRRF').disabled == true){
			document.getElementById('txtDeducIRRF').disabled = false;
		}
		
		if(MoedaToDec(document.getElementById('txtDeducIRRF').value) > 0){
			deducoes = MoedaToDec(document.getElementById('txtDeducIRRF').value);
		}
		if(deducoes > campoIRRF){
			deducoes = campoIRRF;
			document.getElementById('txtDeducIRRF').value = DecToMoeda(deducoes);	
		}
		var valorIRRFfinal = parseFloat(campoIRRF) - parseFloat(deducoes);
		document.getElementById('txtValorFinalIRRF').value = DecToMoeda(valorIRRFfinal);
		
	 }
	 //------------------------------------------------------------------------------------
	 
	 //------------------------------------------------------------------------------------
	 //Verifica e calcula o INSS da nota
	 if(document.getElementById('txtAliquotaINSS').value > 0){
		 
		var baseCalcPct = MoedaToDec(document.getElementById('txtINSSBC').value);
	 	var INSS = document.getElementById('txtAliquotaINSS').value;
		var campoINSS = (baseCalcPct*INSS)/100;
		document.getElementById('txtValorINSS').value = DecToMoeda(campoINSS);
		
	 }
	 //-------------------------------------------------------------------------------------

	 //-------------------------------------------------------------------------------------
	 //Soma todos os campos de rentencao e mostra para o usuario
	 var campoISSRetido = 0;
	 var campoINSS = 0;
	 var campoIRRF = 0;
	 var TotalRentencao = 0;

	 campoISSRetido = MoedaToDec(document.getElementById('txtIssRetido').value);
	 campoINSS = MoedaToDec(document.getElementById('txtValorINSS').value);
	 campoIRRF = MoedaToDec(document.getElementById('txtValorFinalIRRF').value);
	 
	 TotalRentencao = parseFloat(campoISSRetido) + parseFloat(campoINSS) + parseFloat(campoIRRF);
	 
	 document.getElementById('txtValTotalRetencao').value = DecToMoeda(TotalRentencao);
	 //--------------------------------------------------------------------------------------

	 
	 //calcula o valor total que a nota tem para comparacoes com as regras inseridas no banco
	 
	 var valortotaldanota = parseFloat(valdeduc) + parseFloat(basecalc);
	 
	 //Transforma a string recebida por parametro em um array com n posicoes
	 //---
	 var cred_pf_n = cred_pf_n.split("|");
	 var val_pf_n  = val_pf_n.split("|");
	 var cred_pf_s = cred_pf_s.split("|");
	 var val_pf_s  = val_pf_s.split("|");
	 var cred_pj_n = cred_pj_n.split("|");
	 var val_pj_n  = val_pj_n.split("|");
	 var cred_pj_s = cred_pj_s.split("|");
	 var val_pj_s  = val_pj_s.split("|");
	 //---
	 //var vetor_valor = string_valor.split("|");
	 //var vetor_cred = string_cred.split("|");
	 
	 if((tipopessoa == 14) || (tipopessoa == 18))
	 {
		 
		 if(aliquota != "")
		 { 
			  //separa os valores do combo e pega o valor do crédito
			  var aux = document.getElementById('cmbCodServico').value;  
			  var issretido = aux.split("|"); 
		  
		      /*
			  var verificaissretido= document.getElementById('txtPissretido').value;
			  
			  if (verificaissretido !='')
			  {
			   issretido[2] = verificaissretido ; 	 
			  }//fim if 
	 		  */

			  if(basecalc != "")
			  {
			   //calcula o iss
			   
			   var iss = parseFloat(aliquota);  //rpa o calculo é direto e nao por porcetagem 

			   /*a = Math.sqrt(iss);*/
			   iss = iss.toFixed(2);
			   document.getElementById('txtISS').value=DecToMoeda(iss);	  
			  
				  //verifica a quantidade de créditos que o tomador receberá, baseando-se no tipo de pessoa e se tem iss retido ou não.
				  if( tipopessoa == 14)
				   {	   
					 if (issretido[2] != 0)
					 {
					    //verifica quantas posicoes tem o vetor e testa o valor com o recebido por parametro
						for(var cont in val_pf_s)
						{
							if(valortotaldanota<=val_pf_s[cont])
							{
								credito = cred_pf_s[cont];	
							}//fim if
						}//fim for
						//ao sair do foreach testa se a variavel e maior que a ultima posicao do array se for imprime o ultimo credito
						if(valortotaldanota>val_pj_n[cont]){
							credito = cred_pj_n[cont];
						}
					 }//fim if
					 else
					 {
					   //verifica quantas posicoes tem o vetor e testa o valor com o recebido por parametro
						for(var cont in val_pf_n)
						{
							if(valortotaldanota<=val_pf_n[cont])
							{
								credito = cred_pf_n[cont];	
							}//fim if
						}//fim for
						//ao sair do foreach testa se a variavel e maior que a ultima posicao do array se for imprime o ultimo credito
						if(valortotaldanota>val_pf_n[cont]){
							credito = cred_pf_n[cont];
						}
					 }//fim else
				   }//fim if
	  
				   else
				   if( tipopessoa == 18 )
				   {
					 if (issretido[2] != 0)
					 {
					   //verifica quantas posicoes tem o vetor e testa o valor com o recebido por parametro
						for(var cont in val_pj_s)
						{
							if(valortotaldanota<=val_pj_s[cont])
							{
								credito = cred_pj_s[cont];	
							}//fim if
						}//fim for
						//ao sair do foreach testa se a variavel e maior que a ultima posicao do array se for imprime o ultimo credito
						if(valortotaldanota>val_pj_s[cont]){
							credito = cred_pj_s[cont];
						}
					 }//fim if
					 else
					 {
					   //verifica quantas posicoes tem o vetor e testa o valor com o recebido por parametro
						for(var cont in val_pj_n)
						{
							if(valortotaldanota<=val_pj_n[cont])
							{
								credito = cred_pj_n[cont];	
							}//fim if
						}//fim for
						//ao sair do foreach testa se a variavel e maior que a ultima posicao do array se for imprime o ultimo credito
						if(valortotaldanota>val_pj_n[cont]){
							credito = cred_pj_n[cont];
						}
					 }//fim else
				   }//fim else if
				   
		

			//calcula o valor do ISS que será retido
			var valor_issretido = parseFloat(basecalc) * parseFloat(issretido[2])/100;
			
			//valor_issretido = valor_issretido.toFixed(2);
			document.getElementById('txtIssRetido').value=DecToMoeda(valor_issretido);
		   
			//calcula o valor total da nota
			var total = parseFloat(basecalc) + parseFloat(valdeduc);
			
			total = (total) + parseFloat(iss); // var iss é do valor do rpa que deve ser somado com o valor total da nota

			//   a = Math.sqrt(total);
			//   total = a.toFixed(2);
			document.getElementById('txtValTotal').value=DecToMoeda(total);
		   
			//calcula o crédito final que o tomador receberá ao emitir a nota
			credito_final = (parseFloat(iss) * parseFloat(credito))/100;
			//credito_final = credito_final.toFixed(2);
			document.getElementById('txtCredito').value=DecToMoeda(credito_final);
			
			var inss = document.getElementById('txtPinssretido').value;
			var ir   = document.getElementById('txtPirretido').value;
			var iss  = document.getElementById('txtPissretido').value;
			
			if(inss){
				CalculaINSS();
			}else if(iss){
				CalculaISS();
			}else if(ir){
				CalculaIR();
			}
			
		  }//fim if
	 }//fim if aliquota
		 else
			 {
			  alert("Selecione o serviço!");
			 }//fim else
	 }//fim if cpf/cnpj
	 else
	 {
	  alert("CPF/CNPJ inválido!");
	 }//fim else
	}//fim if issretido
}//fim da funcao



function ValidarInserirNota()
	{
		if((document.frmInserir.txtTomadorNome.value=="")||(document.frmInserir.txtTomadorCNPJ.value==""))
			{
				alert("Preencha corretamente o Nome/Razão Social e o CNPJ/CPF do tomador");
				return false;
			}
	}
	
//função genérica que requisita confirmação de envio

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
	
	
/*function CalculaINSS()
	{
		var base    = MoedaToDec(document.getElementById('txtBaseCalculo').value);
		var baseaux = document.getElementById('txtBaseCalculoAux').value;
		var inss    = document.getElementById('txtPinssretido').value;
		if((base!="")&&(inss!=""))
			{
				if (inss<=100)
					{   
					    if(!(baseaux)){
						    document.getElementById('txtBaseCalculoAux').value = MoedaToDec(document.getElementById('txtBaseCalculo').value);
						}
						
						baseaux = document.getElementById('txtBaseCalculoAux').value;
						var x=(inss*baseaux)/100;
						base=baseaux-x;
						document.getElementById('txtBaseCalculo').value = DecToMoeda(base);
						document.getElementById('txtBaseCalculo').onblur();
					}
				else{alert('Não é possível reter um valor de INSS maior que 100%');}	
			}
	}*/
	
function CalculaISS(){
	var base = MoedaToDec(document.getElementById('txtBaseCalculo').value);
	var ir   = document.getElementById('txtPirretido').value;
	var inss = document.getElementById('txtPinssretido').value;
	var iss  = document.getElementById('txtPissretido').value;
	
	var iss_servico = MoedaToDec(document.getElementById('txtIssRetido').value);
	var baseAux = MoedaToDec(document.getElementById('txtBaseCalculo').value);
	if((base!="")&&(iss!="")){
		if (iss<=100){
			var x = (ir*baseAux)/100;
			base = parseFloat(base) - parseFloat(x);
			
			var y = (inss*baseAux)/100;
			base = parseFloat(base) - parseFloat(y);
			
			var z = (iss*baseAux)/100;
			base = parseFloat(base) - parseFloat(z);
			
			base = parseFloat(base) - parseFloat(iss_servico);
			base = parseFloat(base) + parseFloat(document.getElementById('txtValorDeducoes').value);
			document.getElementById('txtValTotal').value = DecToMoeda(base);
			
			//document.getElementById('txtBaseCalculo').onblur();
		}else{
			alert('Não é possível reter um valor de ISS maior que 100%');
		}	
	}else{
		document.getElementById('txtBaseCalculo').value = DecToMoeda(base);	
		document.getElementById('txtBaseCalculoAux').value = DecToMoeda(base);
	}
}	
	
function CalculaIR(){
	var base = MoedaToDec(document.getElementById('txtBaseCalculo').value);
	var ir   = document.getElementById('txtPirretido').value;
	var inss = document.getElementById('txtPinssretido').value;
	var iss  = document.getElementById('txtPissretido').value;
	
	var iss_servico = MoedaToDec(document.getElementById('txtIssRetido').value);
	var baseAux = MoedaToDec(document.getElementById('txtBaseCalculo').value);
	if((base!="")&&(ir!="")){
		if (ir<=100){
			var x = (ir*baseAux)/100;
			base = parseFloat(base) - parseFloat(x);
			
			var y = (inss*baseAux)/100;
			base = parseFloat(base) - parseFloat(y);
			
			var z = (iss*baseAux)/100;
			base = parseFloat(base) - parseFloat(z);
			
			base = parseFloat(base) - parseFloat(iss_servico);
			base = parseFloat(base) + parseFloat(document.getElementById('txtValorDeducoes').value);
			document.getElementById('txtValTotal').value = DecToMoeda(base);
			//document.getElementById('txtBaseCalculo').onblur();
		}else{
			alert('Não é possível reter um valor de IR maior que 100%');
		}	
	}else{
		document.getElementById('txtBaseCalculo').value = DecToMoeda(base);	
		document.getElementById('txtBaseCalculoAux').value = DecToMoeda(base);
	}
}	
	
function CalculaINSS(){
	var base = MoedaToDec(document.getElementById('txtBaseCalculo').value);
	var inss = document.getElementById('txtPinssretido').value;
	var ir   = document.getElementById('txtPirretido').value;
	var iss  = document.getElementById('txtPissretido').value;
	
	var iss_servico = MoedaToDec(document.getElementById('txtIssRetido').value);
	var baseAux = MoedaToDec(document.getElementById('txtBaseCalculo').value);
	if((base!="")&&(inss!="")){
		if (inss<=100){
			var x = (ir*baseAux)/100;
			base = parseFloat(base) - parseFloat(x);
			
			var y = (inss*baseAux)/100;
			base = parseFloat(base) - parseFloat(y);
			
			var z = (iss*baseAux)/100;
			base = parseFloat(base) - parseFloat(z);
			
			base = parseFloat(base) - parseFloat(iss_servico);
			base = parseFloat(base) + parseFloat(document.getElementById('txtValorDeducoes').value);
			document.getElementById('txtValTotal').value = DecToMoeda(base);
			//document.getElementById('txtBaseCalculo').onblur();
		}else{
			alert('Não é possível reter um valor de INSS maior que 100%');
		}	
	}else{
		document.getElementById('txtBaseCalculo').value = DecToMoeda(base);	
		document.getElementById('txtBaseCalculoAux').value = DecToMoeda(base);
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
