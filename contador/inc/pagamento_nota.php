<?php
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
?>
<?php 
	//recebe os dados
	$cnpj = $_SESSION["login"];
	
	$campo = tipoPessoa($cnpj);
	
	//determina o emissor
	$sql_login = mysql_query("SELECT codigo FROM cadastro WHERE $campo = '$cnpj'");
	list($codemissor) = mysql_fetch_array($sql_login);
	
	// carrega as regras de multa por atraso
	listaRegrasMultaDes();
?>
<table border="0" align="center" cellpadding="0" cellspacing="1">
    <tr>
      <td width="10" height="10" bgcolor="#FFFFFF"></td>
	  <td width="100" align="center" bgcolor="#FFFFFF" rowspan="3">Gerar Guia</td>
      <td width="470" bgcolor="#FFFFFF"></td>
	</tr>
	<tr>
	  <td height="1" bgcolor="#CCCCCC"></td>
      <td bgcolor="#CCCCCC"></td>
	</tr>
	<tr>
	  <td height="10" bgcolor="#FFFFFF"></td>
      <td bgcolor="#FFFFFF"></td>
	</tr>
	<tr>
		<td colspan="3" height="1" bgcolor="#CCCCCC"></td>
	</tr>
	<tr>
		<td height="60" colspan="3" bgcolor="#CCCCCC">
    <form method="post">
         <input type="hidden" name="btOp" value="Gerar Guia"/>
        <table align="center">
            <tr>
                <td>
                    <select name="cmbMes" id="_mes">
                        <option value="">==MÊS==</option>
                        <option value="01">Janeiro</option>
                        <option value="02">Fevereiro</option>
                        <option value="03">Março</option>
                        <option value="04">Abril</option>
                        <option value="05">Maio</option>
                        <option value="06">Junho</option>
                        <option value="07">Julho</option>
                        <option value="08">Agosto</option>
                        <option value="09">Setembro</option>
                        <option value="10">Outubro</option>
                        <option value="11">Novembro</option>
                        <option value="12">Dezembro</option>
                    </select>
                </td>
                <td>
                    <select name="cmbAno" id="_ano">
                        <option value="">==ANO==</option>
                        <?php
                            $ano = date("Y");
                            for($x=0; $x<=4; $x++)
                                {
                                    $year=$ano-$x;
                                    echo "<option value=\"$year\">$year</option>";
                                }
                        ?>
                    </select>
                </td>
                <td><input type="submit" class="botao" name="btBuscar" value="Buscar" onclick="return ValidaFormulario('_mes|_ano','Por favor selecione um mês e um ano!')"/></td>
            </tr>
        </table>
    </form>
<?php
if($_POST["btBuscar"] == "Buscar")
{
    $ano = $_POST["cmbAno"];
    $mes = $_POST["cmbMes"];
    $sql = mysql_query("
        SELECT 
            codigo,
            datahoraemissao,
            codverificacao,
            valoriss
        FROM 
            notas
        WHERE 
            SUBSTRING(datahoraemissao,6,2) = '$mes' AND 
            SUBSTRING(datahoraemissao,1,4) = '$ano' AND 
            codemissor = '$codemissor' AND 
            estado = 'N'
        GROUP BY 
            codigo
    ");
    if(mysql_num_rows($sql) > 0)
        {
            ?>
                <form method="post">	
                     <input type="hidden" name="btOp" value="Gerar Guia"/>
                    <input type="hidden" name="btBuscar" value="Buscar" />
                    <input type="hidden" name="cmbAno" id="cmbAno" value="<?php echo $ano; ?>" />
                    <input type="hidden" name="cmbMes" id="cmbMes" value="<?php echo $mes; ?>" />
                    <input type="hidden" name="txtEmissor" value="1" />
                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
                        <tr>
                            <td>
						<table border="0" align="center" cellpadding="2" cellspacing="2">
<tr bgcolor="#999999">
                            <td colspan="3" align="right">Selecionar tudo</td>
                            <td align="center">
                                <input type="checkbox" name="ckTodos" id="ckTodos" onclick="GuiaPagamento_TotalISS()">
                            </td>
                        </tr>
                        <tr bgcolor="#FFFFFF" align="center">
                          <td width="100" align="center">Data Gerado</td>
                          <td width="100" align="center">Cod. Verificação</td>
                          <td width="100" align="center">Valor</td>
                          <td align="center"></td>
                        </tr>
                    </table>
                   <div style=" width:100%; <?php if(mysql_num_rows($sql)>13){ echo "height:300px; overflow:auto";}?>">
                    <table border="0" align="center" cellpadding="2" cellspacing="2">
                        <?php
                            $cont = 0;
                            while(list($codigo,$data,$codverificacao,$total) = mysql_fetch_array($sql)){
                                $datahora = explode(" ",$data);
                                $data = DataPt($datahora[0]);
                                $hora = $datahora[1];
                                echo "
                                    <tr bgcolor=\"#FFFFEA\" align=\"center\">

                                        <td width=\"100\" align=\"center\">$data</td>
                                        <td width=\"100\" align=\"center\">$codverificacao</td>
                                        <td width=\"100\" align=\"right\">".DecToMoeda($total)."</td>
                                        <td align=\"center\">
                                            <input type=\"checkbox\" name=\"ckISS$cont\" id=\"ckISS$cont\" value=\"$total|$codigo\" onclick=\"GuiaPagamento_SomaISS(this)\">
                                            <input type=\"hidden\" name=\"txtCodNota$cont\" id=\"txtCodNota$cont\" />													
                                        </td>
                                    </tr>
                                ";
                                $cont++;
                            }
                        ?>
                    </table>
                  </div>
                        </td>
                    </tr>
                </table>
                    <input type="hidden" value="<?php echo $total_iss."|".($cont-1); ?>" name="txtTotalIssHidden" id="txtTotalIssHidden"/>
                    <table align="center">
                        <tr>
                            <td>Imposto</td>
                            <td>
                                <input type="text" class="texto" style="text-align: right" name="txtTotalIss" id="txtTotalIss" value="0,00" readonly="readonly" >
                            </td>
                        </tr>
                        <tr>
                            <td>Multa</td>
                            <td>
                                <input type="text" class="texto" style="text-align: right" name="txtMultaJuros" id="txtMultaJuros" value="0,00" readonly="readonly" >
                            </td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td>
                                <input type="text" class="texto" style="text-align: right" name="txtTotalPagar" id="txtTotalPagar" value="0,00" readonly="readonly" >
                            </td>
                        </tr>
                        <tr>
                            <td>
                            </td>
                            <td>
                                <input type="hidden" class="texto" name="txtMultaJuros" id="txtMultaJuros" value="0" readonly="yes" >
                            </td>
                        </tr>
                    </table>
                    <center>	
                    <input type="submit" class="botao" value="Gerar Boleto" name="btBoleto" id="btBoleto" onclick="document.getElementById('btBoleto').disabled; return (ValidaCkbDec('txtTotalIss')) && (Confirma('Deseja gerar esta guia?'))"/>
                    <input type="hidden" name="txtCont" value="<?php echo $cont; ?>" />
                    </center>
                    
                </form>	
                </fieldset>
                        
					<?php
			}else{
				echo "<center>Nenhum Resultado Encontrado!</center>";
			}
			if($_POST["btBoleto"] == "Gerar Boleto"){
				//recebe os dados
				$codemissor     = $_POST["txtEmissor"];
				$multa          = MoedaToDec($_POST["txtMultaJuros"]);
				$total          = MoedaToDec($_POST["txtTotalPagar"]);
				$cont           = $_POST["txtCont"];
				$dataemissao    = date("Y-m-d");
				$data           = explode("-",$dataemissao);
				/*$datavencimento = mktime(24*5,0,0,$data[1],$data[2],$data[0]);
				$datavencimento = date("Y-m-d",$datavencimento);*/
				$datavencimento = UltDiaUtil($data[1],$data[0]);
				
				// busca o codigo do banco e o arquivo q gera o boleto
				$sql = mysql_query("SELECT bancos.boleto, boleto.tipo FROM boleto INNER JOIN bancos ON bancos.codigo = boleto.codbanco");
				list($boleto,$tipoboleto) = mysql_fetch_array($sql);
				if($tipoboleto == "R"){
					$tipoboleto = "recebimento";
					$boleto     = "index.php";
				}else{
					$tipoboleto = "pagamento";
				}
				
				// inseri a guia de pagamento no db
				mysql_query("INSERT INTO guia_pagamento SET valor = '$total', valormulta = '$multa', dataemissao = '$dataemissao', datavencimento = '$datavencimento', pago='N'");
				
				// busca o codigo da guia de pagamento recem inserida
				$sql=mysql_query("SELECT MAX(codigo) FROM guia_pagamento");
				list($codguia) = mysql_fetch_array($sql);
				
				// relaciona a guia de pagamento com as delcaracoes
				for($i=0; $i<$cont; $i++) {
					if($_POST["ckISS".$i]) {
						$coddeclaracao = explode("|", $_POST["ckISS".$i]);
						mysql_query("INSERT INTO guias_declaracoes SET codguia = '$codguia', codrelacionamento = '$coddeclaracao[1]', relacionamento = 'nfe'");
						mysql_query("UPDATE notas SET estado = 'B' WHERE codigo = '$coddeclaracao[1]'");
					}
				}
				
				// retorna o codigo do ultimo relacionamento
				$sql = mysql_query("SELECT MAX(codigo) FROM guias_declaracoes");
				list($codrelacionamento)=mysql_fetch_array($sql);
				
				// gera o nossonumero e chavecontroledoc
				$nossonumero = gerar_nossonumero($codguia);
				$chavecontroledoc = gerar_chavecontrole($codrelacionamento,$codguia);
				
				// seta o nossonumero e a chavecontroledoc no banco
				mysql_query("UPDATE guia_pagamento SET nossonumero='$nossonumero', chavecontroledoc='$chavecontroledoc' WHERE codigo='$codguia'");
				
				// gera o boleto
				Mensagem("Boleto gerado com sucesso");
				//$codguia = base64_encode($codguia);
				
				imprimirGuia($codguia);
				Redireciona("pagamento.php");
			}		
		}
		
?>
		</td>
	</tr>
	<tr>
    	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
	</tr>
</table>       

<script type="text/javascript">
	document.getElementById('_mes').value = '<?php echo $_POST['cmbMes']; ?>';
	document.getElementById('_ano').value = '<?php echo $_POST['cmbAno']; ?>';
	if(document.getElementById('cmbMes'))
		CalculaMultaDes();
</script>