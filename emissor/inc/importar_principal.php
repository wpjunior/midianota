<table border="0" align="center" cellpadding="0" cellspacing="1">
    <tr>
      <td width="10" height="10" bgcolor="#FFFFFF"></td>
	  <td width="170" align="center" bgcolor="#FFFFFF" rowspan="3">Arquivo para Importação</td>
      <td width="400" bgcolor="#FFFFFF"></td>
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
        
<table width="100%" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<?php
			$sql_ultimanota = mysql_query("SELECT ultimanota, notalimite FROM cadastro WHERE codigo = '$CODIGO_DA_EMPRESA'");
			list($ultimanota,$notalimite)=mysql_fetch_array($sql_ultimanota);
			$proximaNota = $ultimanota + 1;

			if(($proximaNota > $notalimite) && ($notalimite != 0)){ 
			  echo "<center><font color=\"#000000\"><b>Você excedeu o limite de AIDFe, por favor solicite um limite maior!</b></font></center>";
			?>
			
			<?php		
			}else{
			?>
			<form action="importar_verifica.php" method="post" name="frmPagamento" target="_blank"  enctype="multipart/form-data" onsubmit="window.location='importar.php'">
				<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
					<?php
						if($notalimite){
							$restante = $notalimite - $ultimanota;
					?>
					<tr>
						<td align="left"><font color="#FF0000">Você ainda pode gerar:</font> </td>
						<td align="left"><b><?php echo $restante;?></b> <font color="#FF0000"><?php if($restante == 1){ echo "nota"; }else{ echo "notas";}?></font>.</td>
					</tr>
					<?php
						}
					?>
					<tr>
						<td align="left" width="28%"> Arquivo de RPS </td>
						<td align="left" width="72%">
							<input type="file" name="import" class="botao" />
						</td>
					</tr>
					<td colspan="2" align="center">
							<input type="submit" value="Importar" name="btImportar" class="botao">
						</td>
					</tr>
				</table>
			</form>
			<?php
			}
			?>
			</fieldset>
		</td>
	</tr>
</table>

		</td>
	</tr>
	<tr>
    	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
	</tr>
</table>  


<table border="0" align="center" cellpadding="0" cellspacing="1">
    <tr>
      <td width="10" height="10" bgcolor="#FFFFFF"></td>
	  <td width="170" align="center" bgcolor="#FFFFFF" rowspan="3">Gerar Relatório</td>
      <td width="400" bgcolor="#FFFFFF"></td>
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
        
<form action="inc/importar_gerarelatorio.php" method="post" name="frmGeraRelatorio" target="_blank" id="frmGeraRelatorio">
    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
        <tr>
            <td align="left" width="30%"> Defina o período: </td>
            <td align="left" width="70%">
                <select name="cmbMes" class="combo">
                    <option value="">Selecione o Mês </option>
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
                /
                <select name="cmbAno" class="combo" id="cmbAno">
                    <option value=""> Selecione o Ano </option>
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
        </tr>
        <td colspan="2" align="center">
                <input name="btGerarRelatorio" type="submit" class="botao" id="btGerarRelatorio" value="Gerar Relat&oacute;rio">
            </td>
        </tr>
    </table>
</form>

		</td>
	</tr>
	<tr>
    	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
	</tr>
</table>    


<table border="0" align="center" cellpadding="0" cellspacing="1">
    <tr>
      <td width="10" height="10" bgcolor="#FFFFFF"></td>
	  <td width="170" align="center" bgcolor="#FFFFFF" rowspan="3">Padrão XML</td>
      <td width="400" bgcolor="#FFFFFF"></td>
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

<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
    <tr>
        <td align="center"> Documento referencial do arquivo XML, para importação do Sistema NF-e da Prefeitura Municipal.<br />
            <br />
            <a href="xml/padraoxml.pdf" target="_blank">Download</a> </td>
    </tr>
    <tr>
        <td align="center">Para fazer download de um exemplo de arquivo XML <a href="xml/exemplo_de_xml.php?arquivo=exemplo_notaxml.xml" target="_blank" >clique aqui</a></td>
    </tr>
</table>



		</td>
	</tr>
	<tr>
    	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
	</tr>
</table> 