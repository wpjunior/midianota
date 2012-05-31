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
<form method="post" action="tomadores.php">
<input type="hidden" value="<?php echo $_POST['txtMenu'];?>" name="txtMenu">
	<table width="580" border="0" cellpadding="0" cellspacing="1">
        <tr>
			<td width="5%" height="10" bgcolor="#FFFFFF"></td>
	        <td width="35%" align="center" bgcolor="#FFFFFF" rowspan="3">Consulta de Autenticidade de NFe</td>
	        <td width="60%" bgcolor="#FFFFFF"></td>
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

<table width="99%" border="0" align="center" cellpadding="5" cellspacing="0">
 <tr>
  <td width="30%" align="left">
   N&uacute;mero da NFe<font color="#FF0000">*</font>  </td>
  <td width="70%"  align="left">
   <input type="text" name="txtNFe" id="txtNFe" size="20" class="texto"  onkeydown="stopMsk( event ); return NumbersOnly( event );"> 
   <em>Somente n&uacute;meros  </em></td> 
 </tr>
  <tr> 
  <td align="left">Prestador CNPJ/CPF<font color="#FF0000">*</font></td> 
  <td align="left"><input type="text" name="txtCPFCNPJ" id="txtCPFCNPJ" size="20" class="texto"  onkeydown="stopMsk( event ); return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );"/>     <em>Somente n&uacute;meros</em></td>
  </tr>
  <tr>
    <td align="left">C&oacute;digo de Verifica&ccedil;&atilde;o<font color="#FF0000">*</font></td>
    <td align="left"><input type="text" name="txtCodigo" id="txtCodigo" size="20" class="texto" style="text-transform:uppercase"/>       </td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left"><font color="#FF0000">*</font> Dados obrigat&oacute;rios</td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left"><input type="submit" name="btAutenticidade" value="Consultar" class="botao" /></td>
  </tr>
</table>

		  </td>
		</tr>
		<tr>
	    	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
		</tr>
	</table> 
</form>
<?php
	if($_POST['btAutenticidade']){
		if(($txtNFe !="")&&($txtCPFCNPJ !="")&&($txtCodigo !="")){
			$campo = tipoPessoa($txtCPFCNPJ);
			if($campo){
				$sql=mysql_query("SELECT notas.codigo FROM notas INNER JOIN cadastro ON notas.codemissor = cadastro.codigo WHERE notas.codverificacao='$txtCodigo' AND notas.numero='$txtNFe' AND cadastro.$campo ='$txtCPFCNPJ'");
				$registros=mysql_num_rows($sql);
				if($registros >0){
					list($cod_nota)=mysql_fetch_array($sql);
					$codigo = base64_encode($cod_nota);
					print("<script language=\"javascript\">window.open('../reports/nfe_imprimir.php?CODIGO=$codigo&CAMPO=$txtCPFCNPJ');</script>");
				}
				else{
					Mensagem('Nota não autêntica');
				}
			}
			else{
				print("<script language=JavaScript>alert('Não existe nota cadastrada com estes dados!');parent.location='tomadores.php';</script>");
			}
		}
		else{
			print("<script language=JavaScript>alert('Todos os campos devem ser preenchidos para realizar a consulta.');</script>");
		}
	}
?>