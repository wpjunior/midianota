<?php

session_name("emissor");
session_start();

if (!(isset($_SESSION["empresa"]))) {
    echo "
            <script>
                    alert('Acesso Negado!');
                    window.location='login.php';
            </script>
	";
} else {
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>    
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <title>e-Nota</title>
            <script src="../scripts/java_emissor.js" language="javascript" type="text/javascript"></script>
            <script src="../scripts/padrao.js" language="javascript" type="text/javascript"></script>
            <script src="../scripts/java_emissor_contador.js" language="javascript" type="text/javascript"></script>
            <link href="../css/padrao_emissor.css" rel="stylesheet" type="text/css" />
        </head>

        <body>
            <center>
                <table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
                    <tr>
                        <td><?php include("../include/topo.php"); ?></td>
                    </tr>
                    <tr>
                        <td bgcolor="#FFFFFF" height="400" valign="top" align="center">

                            <!-- frame central inicio --> 	
                            <table border="0" cellspacing="0" cellpadding="0" height="100%">
                                <tr>
                                    <td width="170" align="left" background="../img/menus/menu_fundo.jpg" valign="top"><?php include("inc/menu.php"); ?></td>
                                    <td width="590"bgcolor="#FFFFFF" valign="top">
                                        <img src="../img/cabecalhos/notas.jpg" />

                                        <!-- frame central lateral direita inicio -->	

    <?php include("inc/notas_principal.php"); ?>	


                                        <!-- frame central lateral direita fim -->	
                                    </td>
                                </tr>
                            </table>


                            <!-- frame central fim --> 	
                        </td>
                    </tr>
                    <tr>
                        <td><?php include("inc/rodape.php"); ?></td>
                    </tr>
                </table>
            </center>

        </body>
    </html>
<?php } ?>

<!--  dialog jquery ------------------------------------------------->
<link rel="stylesheet" href="./jquery/themes/base/jquery.ui.all.css">
    <script src="./jquery/jquery-1.7.2.js"></script>
    <script src="./jquery/external/jquery.bgiframe-2.1.2.js"></script>
    <script src="./jquery/ui/jquery.ui.core.js"></script>
    <script src="./jquery/ui/jquery.ui.widget.js"></script>
    <script src="./jquery/ui/jquery.ui.mouse.js"></script>
    <script src="./jquery/ui/jquery.ui.button.js"></script>
    <script src="./jquery/ui/jquery.ui.draggable.js"></script>
    <script src="./jquery/ui/jquery.ui.position.js"></script>
    <script src="./jquery/ui/jquery.ui.dialog.js"></script>
    <link rel="stylesheet" href="./jquery/demos/demos.css">

        <script>
            function confirmar(){                  
                var rps = document.frmInserir.txtRpsNum.value;
                var txtDataRps = document.frmInserir.txtDataRps.value;
                var txtTomadorCNPJ = document.frmInserir.txtTomadorCNPJ.value;
                var txtTomadorNome = document.frmInserir.txtTomadorNome.value;
                var txtTomadorIM = document.frmInserir.txtTomadorIM.value;
                var txtTomadorLogradouro = document.frmInserir.txtTomadorLogradouro.value;
                var txtTomadorNumero = document.frmInserir.txtTomadorNumero.value;
                var txtTomadorComplemento = document.frmInserir.txtTomadorComplemento.value;
                var txtTomadorBairro = document.frmInserir.txtTomadorBairro.value;
                var txtTomadorCEP = document.frmInserir.txtTomadorCEP.value;
                var txtTomadorUF = document.frmInserir.txtTomadorUF.item(0).value;
                var txtTomadorMunicipio = document.frmInserir.txtTomadorMunicipio.item(0).value;
                var txtTomadorEmail = document.frmInserir.txtTomadorEmail.value;
                var txtNotaDiscriminacao = document.frmInserir.txtNotaDiscriminacao.value;
                var txtValorDeducoes = document.frmInserir.txtValorDeducoes.value;
                var txtBaseCalculo = document.frmInserir.txtBaseCalculo.value;
                var txtValTotalRetencao = document.frmInserir.txtValTotalRetencao.value;
                var txtnaturezaoperacao = document.frmInserir.txtnaturezaoperacao.value;
                var naturezaop = 0;
                var txtAliquota = document.frmInserir.txtAliquota.value;
                
                
                if ( rps.length < 3) {rps = "s/n";}
                if ( txtDataRps.length < 3) {txtDataRps = "s/n";} 
                
                if ( txtTomadorCNPJ.length < 3){ txtTomadorCNPJ = "s/n";}
                
                if ( txtTomadorNome.length < 3) {txtTomadorNome = "s/n";}
                if ( txtTomadorIM.length < 3) {txtTomadorIM = "s/n";}
                if ( txtTomadorLogradouro.length < 3) {txtTomadorLogradouro = "s/n";}
                if ( txtTomadorNumero.length < 3) {txtTomadorNumero = "s/n";}
                if ( txtTomadorComplemento.length < 3) {txtTomadorComplemento = "s/n";}
                if ( txtTomadorBairro.length < 3) {txtTomadorBairro = "s/n";}
                if ( txtTomadorCEP.length < 3) {txtTomadorCEP = "s/n";}
                if ( txtTomadorUF.length < 3) {txtTomadorUF = "s/n";}
                if ( txtTomadorMunicipio.length < 3) {txtTomadorMunicipio = "s/n";}
                if ( txtTomadorEmail.length < 3) {txtTomadorEmail = "s/n";}
                if ( txtNotaDiscriminacao.length < 3) {txtNotaDiscriminacao = "s/n";}
                if ( txtValorDeducoes.length < 3) {txtValorDeducoes = "s/n";}
                if ( txtBaseCalculo.length < 3) {txtBaseCalculo = "s/n";}
                if ( txtValTotalRetencao.length < 3) {txtValTotalRetencao = "s/n";}

                switch(txtnaturezaoperacao){
                           case '1' : naturezaop = "Tributação no município"; break;
                           case '2' : naturezaop = "Tributação fora do município"; break;
                           case '3' : naturezaop = "Isenção"; break;
                           case '4' : naturezaop = "Imune"; break;
                           case '5' : naturezaop = "Exigibilidade suspensa por decisão judicial"; break;
                           case '6' : naturezaop = "Exigibilidade suspensa por procedimento administrativo"; break;
                }
                
                document.all('a1').innerHTML = "<b>Número do RPS................</b> "+ rps;
                document.all('a2').innerHTML = "<b>Data do RPS.....................</b> "+ txtDataRps;
                document.all('a3').innerHTML = "<b>CPF/CNPJ.........................</b> "+ txtTomadorCNPJ;
                document.all('a4').innerHTML = "<b>Tomador..........................</b> "+ txtTomadorNome;
                document.all('a5').innerHTML = "<b>Inscrição Municipal.........</b> "+ txtTomadorIM;
                document.all('a6').innerHTML = "<b>Logradouro......................</b> "+ txtTomadorLogradouro;
                document.all('a7').innerHTML = "<b>Número............................</b> "+ txtTomadorNumero;
                document.all('a8').innerHTML = "<b>Complemento...................</b> "+ txtTomadorComplemento;
                document.all('a9').innerHTML = "<b>Bairro...............................</b> "+ txtTomadorBairro;
                document.all('a10').innerHTML = "<b>CEP...................................</b> "+ txtTomadorCEP;
                document.all('a11').innerHTML = "<b>UF.....................................</b> "+ txtTomadorUF;
                document.all('a12').innerHTML = "<b>Cidade..............................</b> "+ txtTomadorMunicipio;
                document.all('a13').innerHTML = "<b>Email................................</b> "+ txtTomadorEmail;
                document.all('a14').innerHTML = "<b>Discriminação..................</b> "+ txtNotaDiscriminacao;
                document.all('a15').innerHTML = "<b>Deduções.........................</b> "+ txtValorDeducoes;
                document.all('a16').innerHTML = "<b>Base de Cálculo...............</b> "+ txtBaseCalculo;
                document.all('a17').innerHTML = "<b>Valor total da retenção...</b> "+ txtValTotalRetencao;
                document.all('a18').innerHTML = "<b>Natureza da Operação......</b> "+ naturezaop;
                document.all('a19').innerHTML = "<b>Alíquota(%)..........</b> "+ txtAliquota;
                
                $(function() {
                    
                    $( "#dialog:ui-dialog" ).dialog( "destroy" );
	
                    $( "#dialogo" ).dialog({
                        resizable: false,
                        width:700,
                        height:500,
                        modal: true,
                        buttons: {
                            "Sim, emitir nota!": function() {
                                ValidaFormulario('txtBaseCalculo|txtTomadorCNPJ|txtTomadorNome');
                                ValidarInserirNota();
                                document.frmInserir.submit();
                                
                                $( this ).dialog( "close" );
                            },
                            "Não, desejo corrigir agora!": function() {
                                $( this ).dialog( "close" );
                            }
                        }
                    });
                });  
            }
        </script>

        <!-- dialogo confirmar dados -->
        <div id="dialogo" title="Os dados estão realmente corretos?">
            <p align="left">
                <div id="a1"></div>            
                <div id="a2"></div>   
                <br></br>
                <div id="a3"></div>            
                <div id="a4"></div>            
                <div id="a5"></div>            
                <div id="a6"></div>            
                <div id="a7"></div>            
                <div id="a8"></div>            
                <div id="a9"></div>            
                <div id="a10"></div>            
                <div id="a11"></div>            
                <div id="a12"></div>        
                <br></br>
                <div id="a13"></div>            
                <br></br>
                <div id="a14"></div>            
                <div id="a15"></div>            
                <div id="a16"></div>            
                <div id="a17"></div>            
                <br></br>
                <div id="a18"></div>            
                <div id="a19"></div>            
            </p>
        </div>

