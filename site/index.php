<?php

include("../include/conect.php");
include("../funcoes/util.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>e-Nota</title>

        <script src="../scripts/java_site.js" language="javascript" type="text/javascript"></script>

        <script type="text/javascript" src="../scripts/lightbox/prototype.js"></script>
        <script type="text/javascript" src="../scripts/lightbox/scriptaculous.js?load=effects,builder"></script>
        <script type="text/javascript" src="../scripts/lightbox/lightbox.js"></script>
        <script type="text/javascript" src="../scripts/padrao.js"></script>
        <link rel="stylesheet" href="../css/lightbox.css" type="text/css" media="screen" />

        <link href="../css/padrao_site.css" rel="stylesheet" type="text/css" />
        <style type="text/css">
            <!--
            #apDiv1 {
                position:absolute;
                left:40%;
                top:45%;
                width:400px;
                height:160px;
                z-index:1;
                background-image: url(../img/index/indicativos.jpg);
            }
            .style1 {
                font-size: 12pt;
                color: #FF0000;
                font-weight: bold;
            }
            -->
        </style>
    </head>

    <body>
        <div id="apDiv1" style="visibility:hidden" onclick="javascript:changeProp('apDiv1','','visibility','hidden','DIV')"><br />
            <br />
            <br />
            <br />
            <br />
            <br />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php
$sql = mysql_query("SELECT COUNT(codigo) FROM cadastro WHERE estado = 'A'");
list($empresas_ativas) = mysql_fetch_array($sql);
echo "<font color=#FF0000 size=4><strong>$empresas_ativas</strong></font>";
?>
            <br />
            <br />
            <br />

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php
$sql = mysql_query("SELECT COUNT(codigo) FROM notas");
list($notas_emitidas) = mysql_fetch_array($sql);
echo "<font color=#FF0000 size=4><strong>$notas_emitidas</strong></font>";
?>
        </div>
        <table width="760" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
                <td align="left"><?php include("inc/topo.php"); ?></td>
            </tr>
            <tr>
                <td bgcolor="#FFFFFF" height="400" valign="top" align="center">

                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="170" rowspan="2" align="left" valign="top" background="../img/menus/menu_fundo.jpg"><?php include("inc/menu.php"); ?></td>
                            <td align="right" valign="top" width="590"><img src="../img/nfelogo.jpg" width="590" height="161" /></td>
                        </tr>
                        <tr>
                            <td align="center" valign="top">  

                                <table border="0" cellspacing="5" cellpadding="0">
                                    <tr>
                                        <td width="190" align="center" valign="top">
                                            <!-- quadro da esquerda acima -->
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td height="3" bgcolor="#CCCCCC"></td>
                                                </tr>
                                                <tr>
                                                    <td height="10" bgcolor="#999999"></td>
                                                </tr>
                                                <tr>
                                                    <td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Como funciona?</font><br />
                                                        <br />          
                                                        Clique e veja o funcionamento da NFeletrônica de ISS.<br />
                                                        <br />
                                                        <div align="center"><a href="../img/como_funciona.jpg" rel="lightbox[roadtrip]"><img src="../img/index/iconehowto.jpg" width="170" height="50" /></a></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="1"></td>
                                                </tr>
                                                <tr>
                                                    <td height="5" align="left" bgcolor="#859CAD"></td>
                                                </tr>
                                            </table>    </td>
                                        <td width="190" align="center" valign="top">

                                            <!-- Quadro do meio acima -->

                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td height="3" bgcolor="#CCCCCC"></td>
                                                </tr>
                                                <tr>
                                                    <td height="10" bgcolor="#999999"></td>
                                                </tr>
                                                <tr>
                                                    <td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Emita sua NFe</font><br />
                                                        <br />         
                                                        Acessa o sistema e emita suas Notas Fiscais Eletrônicas.<br />
                                                        <br />
                                                        <div align="center"><a href="prestadores.php"><img src="../img/index/iconeemitirnf.jpg" width="170" height="50" /></a></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="1"></td>
                                                </tr>
                                                <tr>
                                                    <td height="5" align="left" bgcolor="#859CAD"></td>
                                                </tr>
                                            </table>    </td>
                                        <td width="190" align="center" valign="top">

                                            <!-- quadro direita acima -->
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td height="3" bgcolor="#CCCCCC"></td>
                                                </tr>
                                                <tr>
                                                    <td height="10" bgcolor="#999999"></td>
                                                </tr>
                                                <tr>
                                                    <td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo"> Indicativos</font>
                                                        <br />
                                                        <br />
                                                        Acesse e compare os números de aprovação da NFe de ISS.<br />
                                                        <br />
                                                        <div align="center"><a href="javascript:changeProp('apDiv1','','visibility','visible','DIV')"><img src="../img/index/iconeindicativos.jpg" /></a></div></td>
                                                </tr>
                                                <tr>
                                                    <td height="1"></td>
                                                </tr>
                                                <tr>
                                                    <td height="5" align="left" bgcolor="#859CAD"></td>
                                                </tr>
                                            </table>	</td>
                                    </tr> 
                                    <tr>
                                        <td width="190" align="center" valign="top">
                                            <!-- quadro da esquerda acima -->
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td height="3" bgcolor="#CCCCCC"></td>
                                                </tr>
                                                <tr>
                                                    <td height="10" bgcolor="#999999"></td>
                                                </tr>
                                                <tr>
                                                    <td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Autenticade de NF</font>e<br />
                                                        <br />
                                                        Verifique a autenticidade da sua NFe.<br />
                                                        <br />
                                                        <div align="center"><a href="tomadores.php"><img src="../img/index/iconeautenticidade.jpg" alt="" width="170" height="50" /></a></div></td>
                                                </tr>
                                                <tr>
                                                    <td height="1"></td>
                                                </tr>
                                                <tr>
                                                    <td height="5" align="left" bgcolor="#859CAD"></td>
                                                </tr>
                                            </table>    </td>
<?php
$ativar_creditos = mysql_result(mysql_query("SELECT ativar_creditos FROM configuracoes"), 0);
if ($ativar_creditos == 's') {
    ?>
                                            <td width="190" align="center" valign="top">

                                                <!-- Quadro do meio acima -->

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td height="3" bgcolor="#CCCCCC"></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="10" bgcolor="#999999"></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Publicidade</font><br />
                                                            <br />
                                                            Veja o vídeo da campanha da NFeletrônica de ISS.<br />
                                                            <br />
                                                            <div align="center"><img src="../img/index/iconemidia.jpg" alt="" width="170" height="50" /></div></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="1"></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="5" align="left" bgcolor="#859CAD"></td>
                                                    </tr>
                                                </table>    </td>
                                            <td width="190" align="center" valign="top">

                                                <!-- quadro direita acima -->
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td height="3" bgcolor="#CCCCCC"></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="10" bgcolor="#999999"></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo"> Seus Cr&eacute;ditos</font>
                                                            <br />
                                                            <br />
                                                            Consulte seus créditos obtidos até o momento.<br />
                                                            <br />
                                                            <div align="center"><a href="tomadores.php"><img src="../img/index/iconecreditos.jpg" alt="" width="170" height="50" /></a></div></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="1"></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="5" align="left" bgcolor="#859CAD"></td>
                                                    </tr>
                                                </table>	</td>
    <?php
}//fom if ativar_creditos
?>
                                    </tr>   
                                </table>    







                            </td>
                        </tr>
                    </table>



                </td>
            </tr>
        </table>
<?php include("inc/rodape.php"); ?>

    </body>
</html>
