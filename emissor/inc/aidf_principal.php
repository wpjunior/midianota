<?php
	if($btSolicitar!="")
		{
			$sql=mysql_query("INSERT INTO aidfe_solicitacoes SET solicitante = '$CODIGO_DA_EMPRESA'");
			echo "<script>alert('Uma solicitação de aumento de AIDF foi enviada á prefeitura!');</script>";
			add_logs('Solicitou um aumento no AIDF');
		}
	$sql=mysql_query("SELECT ultimanota, notalimite FROM cadastro WHERE codigo = '$CODIGO_DA_EMPRESA'");
	list($ultimanota,$notalimite)=mysql_fetch_array($sql);
	if($notalimite==0){$notalimite="Liberado";}
	
	$sql_aidfe = mysql_query("SELECT codigo FROM aidfe_solicitacoes WHERE solicitante = '$CODIGO_DA_EMPRESA'");
	$numero_de_solicitacoes = mysql_num_rows($sql_aidfe);
?>
<form method="post">
<table border="0" align="center" cellpadding="0" cellspacing="1">
    <tr>
      <td width="10" height="10" bgcolor="#FFFFFF"></td>
	  <td width="100" align="center" bgcolor="#FFFFFF" rowspan="3">AIDF Eletrônico</td>
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

<table align="center" width="100%">
    <tr align="left" bgcolor="#FFFFFF">
        <td>Número da última nota emitida:</td>
        <td><?php echo $ultimanota; ?></td>
    </tr>
    <tr align="left" bgcolor="#FFFFFF">
        <td>Nota limite / AIDF:</td>
        <td><?php echo $notalimite; ?></td>
    </tr>
    <tr align="left">
        <?php
        if($notalimite != "Liberado"){
        ?>	
            <td colspan="2">
                <input type="submit" name="btSolicitar" value="Solicitar mais notas" class="botao" 
                <?php if($numero_de_solicitacoes>0){ echo "disabled=disabled";} ?>> 
                <?php 
                    if($numero_de_solicitacoes>0){ 
                        echo "<b>Sua solicitação já foi enviada a prefeitura.</b>";
                    } 
                ?>
            </td>
        <?php 
        } 
        ?>
    </tr>
</table>

		</td>
	</tr>
	<tr>
    	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
	</tr>
</table>   
</form>	
