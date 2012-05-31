<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Guia de Recebimento</title>
<link href="css/padrao.css" rel="stylesheet" type="text/css">
</head>
<body> 
<table width="500" border="0" align="center" cellpadding="0" cellspacing="5">
  <tr>
    <td align="center" height="100">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left"><?php if($CONF_BRASAO){?><img src="../../img/brasoes/<?php echo rawurlencode($CONF_BRASAO); ?>" width="60" height="60"><?php }?></td>
        <td align="left">
        <span class="cab01">PREFEITURA DE <?php echo strtoupper($CONF_CIDADE); ?></span><br>
        <span class="cab01"><?php echo $CONF_SECRETARIA; ?></span><br><br>
        <span class="cab02">ISSQN - Guia para Pagamento</span></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td style="border:#000000 solid 2px;">CNPJ/Inscr. Municipal/CPF:<br><?php echo $Cnpj; ?></td>
        <td></td>
        <td style="border:#000000 solid 2px;">Código da Arrecadação<br><?php echo $codigoboleto; ?></td>
      </tr>
    </table>    
    </td>
  </tr>
  <tr>
    <td align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td style="border:#000000 solid 2px;">NOME:<br><?php echo strtoupper($RazaoSocial); ?></td>
      </tr>
    </table>   
    </td>
  </tr>
  <tr>
    <td align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td style="border:#000000 solid 2px;">ENDEREÇO:<br><?php echo strtoupper($EndSacado.", ".$Numero); ?></td>
      </tr>
    </table>       
    </td>
  </tr>
  <tr>
    <td align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td style="border:#000000 solid 2px;">ATIVADE(S):<br><?php echo strtoupper($Atividades); ?></td>
      </tr>
    </table>           
    </td>
  </tr>
  <tr>
    <td align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td style="border:#000000 solid 2px;" align="center"><span class="cab02">INSTRUÇÕES PARA RECEBIMENTO</span><br><br>
		<?php echo $Instrucoes_boleto;?>
		<br><br>
        VALOR VÁLIDO PARA PAGAMENTO ATÉ <?php echo $vencimento;?>.<br>
		APÓS ESSA DATA, EMITA UMA GUIA ATUALIZADA.
        </td>
      </tr>
    </table>           
    </td>
  </tr>  
  <tr>
    <td align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td style="border:#000000 solid 2px;" align="center"><span class="cab02">GUIA PARA PAGAMENTO DE ISSQN</span><br><br>
        Competência: <?php echo $Competencia;?>&nbsp;&nbsp;&nbsp;&nbsp;
		Vencimento: <?php echo $vencimento;?></td>
      </tr>
    </table>           
    </td>
  </tr>
  <tr>
    <td align="center">
        <table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td style="border:#000000 solid 2px;" align="center">
        <table width="100%" border="0" cellspacing="3" cellpadding="0">
          <tr>
            <td align="center">Receita Bruta</td>
            <td align="center">Imposto</td>
          </tr>
          <tr>
            <td align="center">R$ <?php echo $Receita;?></td>
            <td align="center">R$ <?php echo $valorbl;?></td>
          </tr>
        </table>        
        </td>
      </tr>
    </table>           
	</td>
  </tr>
  <tr>
    <td align="center">
	<table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td></td>
        <td class="cab02" align="right">VALOR A PAGAR&nbsp;&nbsp;</td>
        <td class="cab02" height="40" align="right" bgcolor="#CCCCCC" style="border:1px solid;">R$ <?php echo $valorbl; ?></td>
      </tr>
    </table>    
    </td>
  </tr>
  <tr>
    <td align="center">
	<table width="100%" border="0" cellspacing="0" cellpadding="2" align="center" style="border:#000000 solid 2px;">
		<tr>
		<td><?php if($CONF_BRASAO){?><img src="../../img/brasoes/<?php echo rawurlencode($CONF_BRASAO); ?>" width="60" height="60"><?php }?></td>
        <td align="right">
		  <table width="100%" border="0" cellspacing="2" cellpadding="0">		
		  <tr>
            <td align="center">Autentica&ccedil;&atilde;o Mec&acirc;nica<br><?php echo $linhad; ?></td>
          </tr>
          <tr>
            <td align="center"><?php geraCodigoDeBarras($linha); ?></td>
          </tr>
		  </table>
		</td>
    </table>        
    </td>
  </tr>
  <tr>
    <td align="center">
	<table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td align="right">
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
        		<td>
        			<img src="img/cortar.gif" width="450" height="60">
				</td>		
      		</tr>
        </table>        
        </td>
      </tr>
    </table>    
    </td>
  </tr>
  <tr>
    <td align="center">
    </td>
  </tr>
  <tr>
    <td align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td style="border:#000000 solid 2px;">CNPJ/Inscr. Municipal/CPF:<br>
            <?php echo $Cnpj; ?></td>
        <td></td>
        <td style="border:#000000 solid 2px;">C&oacute;digo da Arrecada&ccedil;&atilde;o<br>
            <?php echo $codigoboleto; ?></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td style="border:#000000 solid 2px;" align="center">
          <table width="100%" border="0" cellspacing="0" cellpadding="2">
            <tr>
              <td>Vencimento: <?php echo $vencimento;?></td>
              <td class="cab02" align="right">VALOR A PAGAR&nbsp;&nbsp;</td>
              <td class="cab02" align="right" style="border:1px solid;" bgcolor="#CCCCCC">R$ <?php echo $valorbl; ?></td>
            </tr>
          </table></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="2" style="border:#000000 solid 2px;">
      <tr>
		<td><?php if($CONF_BRASAO){?><img src="../../img/brasoes/<?php echo rawurlencode($CONF_BRASAO); ?>" width="60" height="60"><?php }?></td>
        <td align="right">
		  <table width="100%" border="0" cellspacing="2" cellpadding="0">		
		  <tr>
            <td align="center">Autentica&ccedil;&atilde;o Mec&acirc;nica<br><?php echo $linhad; ?></td>
          </tr>
          <tr>
            <td align="center"><?php geraCodigoDeBarras($linha); ?></td>
          </tr>
		  </table>
		</td>
    </table></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
</table>

</body>
</html>
