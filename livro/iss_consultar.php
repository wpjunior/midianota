<br />
 <form method="post" id="frmLivro">
<table border="0" align="center" cellpadding="0" cellspacing="1">
		<tr>
			<td width="10" height="10" bgcolor="#FFFFFF"></td>
			<td width="120" align="center" bgcolor="#FFFFFF" rowspan="3">Consultar Livro</td>
			<td width="450" bgcolor="#FFFFFF"></td>
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
                <?php			
                    $sqlemp=mysql_query("SELECT if(cnpj is null, cpf, cnpj) as cnpj,datainicio,datafim,codigo FROM cadastro WHERE codigo='{$_SESSION['codempresa']}'");				
                    $empcnpj=mysql_fetch_object($sqlemp);
                 ?>
                        <div id="DivAbas"></div>                           
                        <input type="hidden"  name="txtCnpjPrestador" value="<?php echo $empcnpj->cnpj; ?>"/>
                        <table align="left">					
                            <tr>
                                <td width="150">Período Inicial</td>
                                <td>
                                    <?php
                                    $anoatual=date("Y");
									$diaatual=date("Y-m-d");

									if($empcnpj->datainicio==NULL || $empcnpj->datainicio==0000-00-00){
										$empcnpj->datainicio = $diaatual;
									}

                                    $anoempresa=substr($empcnpj->datainicio,0,-6);
                                    $anofimempresa=substr($empcnpj->datafim,0,-6);
                                    $meses=array("1"=>"Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
                                    
                                    ?>
                                    <table cellpadding="0" cellspacing="0"><tr><td>
                                    <select name="cmbAno" id="cmbAno" onchange="acessoAjax('./listaperiodo.ajax.php','frmLivro','divSelectIni');" >
                                        <option value="">Escolha o ano</option>
                                        <?php
                                        if($datafim==NULL){
                                            for($ano=$anoatual;$ano>=$anoempresa;$ano--){
                                                echo "<option value=\"$ano\">$ano</option>";
                                            }
                                        }else{
                                            for($ano=$anoempresa;$ano<=$anofimempresa;$ano++){
                                                echo "<option value=\"$ano\">$ano</option>";
                                            }
                                        }
                                    ?>
                                    </select>
                                    </td><td id="divSelectIni" style="float:left">
                                    <select name="cmbMes" id="cmbMes">
                                        <option value=""></option>
                                    </select>
                                    </td></tr></table>   
                                </td>
                            </tr>
                            <tr>
                                <td>Período Final</td>
                                <td>
                                	<table cellpadding="0" cellspacing="0"><tr><td>
                                    <select name="cmbAnoFim" id="cmbAnoFim"  onchange="acessoAjax('./listaperiodofim.ajax.php','frmLivro','divSelectFim');">
                                        <option value="">Escolha o ano</option>
                                       <?php
                                        if($datafim==NULL){
                                            for($ano=$anoatual;$ano>=$anoempresa;$ano--){
                                                echo "<option value=\"$ano\">$ano</option>";
                                            }
                                        }else{
                                            for($ano=$anoempresa;$ano<=$anofimempresa;$ano++){
                                                echo "<option value=\"$ano\">$ano</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                    </td><td id="divSelectFim" style="float:left">
                                    <select name="cmbMesFim" id="cmbMesFim">
                                       <option value=""></option>
                                    </select>
                                    </td></tr></table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <br />
                                    <input type="submit" name="btnBuscar" value="Buscar" class="botao" onclick="btnBuscar_click(); return false;" />
                                    <br />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"> 
                                    <div id="dvResultdoLivro" ></div>
                                </td>
                            </tr>
                        </table>
                                
   				</td>
            </tr>
            <tr>
                <td height="1" colspan="3" bgcolor="#CCCCCC"></td>
            </tr>
        </table>    
              </form>   
        
<script type="text/javascript">
	function btnBuscar_click() {
		acessoAjax('../livro/sep_consultar.ajax.php','frmLivro','dvResultdoLivro');		
	}
</script>
