<script type="text/javascript" src="../scripts/padrao.js"></script>
<?php 
include("../include/conect.php");
	$sql=mysql_query("SELECT codigo,nome,datainicio,datafim FROM cadastro WHERE cnpj='".$_POST['txtCnpjLivro']."' OR cpf='".$_POST['txtCnpjLivro']."'");
	if(mysql_num_rows($sql)!=0){
		$dado= mysql_fetch_object($sql);		
		echo $dado->nome."<br><br>";
		$meses=array("1"=>"Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");		
		 ?>
         <form name="frmSep" id="frmSep">
         <input type="hidden" name="txtCodCadastro" value="<?php echo $dado->codigo; ?>" id="txtCodCadastro">
		 <table>
			<tr>
				<td>
				 Período
				</td>
				<td>
				<?php
                $anoatual=date("Y");
				$diaatual=date("Y-m-d");
				if($dado->datainicio==NULL || $dado->datainicio==0000-00-00){ $dado->datainicio = $diaatual; }
				
				$anoempresa=substr($dado->datainicio,0,-6);
				
				if($dado->datafim<$dado->datainicio){ $dado->datafim=NULL; } if($dado->datafim>$diaatual){ $dado->datafim=NULL; }
				
				$anofimempresa=substr($dado->datafim,0,-6);
				?>
                  <input type="hidden" name="codempresa" id="codempresa" value="<?php echo $dado->codigo; ?>" />
                  <div style="float:left">
				  <select name="cmbAno" id="cmbAno" onchange="acessoAjax('./listaperiodo.ajax.php','frmSep','divSelect');" >
                      <option value=""> </option>
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
                  </div>
                  <div id="divSelect">
                  <select name="cmbMes" id="cmbMes">
                      <option value="">Escolha o ano</option>
                  </select>
                  </div>
                  </div>
				</td>
			</tr>
			<tr>
				<td>
				 Vencimento
				</td>
				<td>
				 <input type="text" name="txtDataVencimento" id="txtDataVencimento" class="texto"  ><font style="color:#FF0000">*</font>        
				</td>
			</tr>
            <tr>
				<td>
				 Obs
				</td>
				<td>
				 <textarea class="texto" name="txtObs" rows="10" cols="40"></textarea><font style="color:#FF0000">*</font>        
				</td>
			</tr>
            <tr>
				<td>
					<input type="submit" name="btGerar" value="Gerar Livro" class="botao">
				</td>
			</tr>
		</table>
        </form>
<?php
}else{		
		echo "<font style=\"color:#FF0000\">Contribuinte inválido, Informe um Cnpj ou CPF válido para gerar o livro do contribuinte</font>";
}?>            
<!--<font style="font-size:10px;font-family:Verdana, Arial, Helvetica, sans-serif"><?php echo $retorno;?></font> -->
