<form name="frmPrestadoresBox" method="post" id="frmPrestadoresBox">
	<input type="hidden" name="txtMenu" id="txtMenu" />
	<input type="hidden" name="txtCNPJ" id="txtCNPJ" />

<table border="0" cellspacing="5" cellpadding="0" align="left">
  <tr>
    <td width="190" align="center" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="3" bgcolor="#CCCCCC"></td>
      </tr>
      <tr>
        <td height="10" bgcolor="#999999"></td>
      </tr>
      <tr>
        <td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Acessar Sistema</font><br />
          <br />          
                    Emitente de NF-e, acesse todas as funcionalidades do sistema.<br />
          <br />
          <div align="center"></div>          </td>
      </tr>
      <tr>
        <td height="1"></td>
      </tr>
      <tr>
        <td height="20" align="left" bgcolor="#859CAD">&nbsp;<img src="../img/box/web.png" width="14" height="14" /> <a href="../emissor/index.php" target="_blank">Serviço on-line</a></td>
      </tr>
    </table>    </td>
    <td width="190" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="3" bgcolor="#CCCCCC"></td>
      </tr>
      <tr>
        <td height="10" bgcolor="#999999"></td>
      </tr>
      <tr>
        <td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Cadastro</font><br />
            <br />
            Se você não possui acesso ao sistema, é necessário realizar o seu cadastramento.<br />
          <br />
          <div align="center"></div></td>
      </tr>
      <tr>
        <td height="1"></td>
      </tr>
      <tr>
        <td height="20" align="left" bgcolor="#859CAD">&nbsp;<img src="../img/box/web.png" alt="" width="14" height="14" /><a onclick="document.getElementById('txtMenu').value='cadastro';frmPrestadoresBox.submit();" href="#" class="box">Serviço on-line</a></td>
      </tr>
    </table>
	
	<!-- Quadro do meio acima --></td>
    <td width="190" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="3" bgcolor="#CCCCCC"></td>
      </tr>
      <tr>
        <td height="10" bgcolor="#999999"></td>
      </tr>
      <tr>
        <td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Consulta</font><br />
            <br />
          Consulte se o seu cadastro já foi liberado pela Prefeitura Municipal.<br />
          <br />
          <div align="center"></div></td>
      </tr>
      <tr>
        <td height="1"></td>
      </tr>
      <tr>
        <td height="20" align="left" bgcolor="#859CAD">&nbsp;<img src="../img/box/web.png" alt="" width="14" height="14" /><a onclick="document.getElementById('txtMenu').value='consulta';frmPrestadoresBox.submit();" href="#" class="box">Serviço on-line</a></td>
      </tr>
    </table>
	</td>
  </tr>   
    </table>
</form>