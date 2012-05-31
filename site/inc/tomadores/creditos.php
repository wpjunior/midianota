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
<form method="post" action="tomadores.php"  >
<input type="hidden" value="<?php echo $_POST['txtMenu'];?>" name="txtMenu">
	<table width="580" border="0" cellpadding="0" cellspacing="1">
        <tr>
			<td width="5%" height="10" bgcolor="#FFFFFF"></td>
	        <td width="25%" align="center" bgcolor="#FFFFFF" rowspan="3">Consulta Cr&eacute;ditos</td>
	        <td width="70%" bgcolor="#FFFFFF"></td>
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
                        <td width="30%" align="left">Tomador CPF/CNPJ<font color="#FF0000">*</font></td>
                        <td width="70%"  align="left"><input type="text" name="txtTomCpfCnpj" id="txtTomCpfCnpj" size="20" class="texto"  onkeydown="stopMsk( event );" onkeypress="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );"/></td> 
                    </tr>
                    <tr> 
                        <td align="left">Per&iacute;odo<font color="#FF0000">*</font></td> 
                        <td align="left">
                        <select name="cmbPeriodo" id="cmbPeriodo">
						<?php
							for($d=(date("Y")); $d>(date("Y")-3); $d--)
									echo "<option value=$d>$d</option>";
                        ?>
                        </select></td>
                    </tr>
                    <tr>
                        <td align="center">&nbsp;</td>
                        <td align="left"><font color="#FF0000">*</font> Dados obrigat&oacute;rios</td>
                    </tr>
                    <tr>
                        <td align="left" colspan="2"><input type="submit" name="btConsultarCreditos" id="btConsultarCreditos" value="Consultar" class="botao" /></td>
                    </tr>
                </table>
				<?php
                    if($_POST['btConsultarCreditos']){
                        if($txtTomCpfCnpj !=""){
                            $data = $_POST['cmbPeriodo'];
							$sql = mysql_query("SELECT tomador_cnpjcpf, credito, numero FROM notas WHERE YEAR(datahoraemissao) = '$data' AND tomador_cnpjcpf = '$txtTomCpfCnpj'");
							if(mysql_num_rows($sql)>0){
								$nrocreditos=mysql_num_rows($sql);
									?>
                                        <table width="99%" border="0" align="center" cellpadding="2" cellspacing="2">
                                            <tr bgcolor="#999999">
                                                <td align="center">N° da Nota</td>
                                                <td align="center">CPF/CNPJ</td>
                                                <td align="center">Créditos</td>
                                            </tr>
									<?php
									while(list($cpfcnpj, $credito, $nro)=mysql_fetch_array($sql)){
									$crd_tomador = DecToMoeda($credito);
									echo "
										<tr bgcolor=\"#FFFFFF\">
											<td align=\"center\">$nro</td>
											<td align=\"center\">$cpfcnpj</td>
											<td align=\"left\">R$ $crd_tomador</td>
										</tr>
									";
								}
									echo "
										<tr>
											<td colspan=\"3\" bgcolor=\"#999999\" align=\"right\">N° de notas encontradas: $nrocreditos</td>
										</tr>
									</table>";
							}
							else{
								Mensagem('Nenhum crédito relacionado a este tomador');
							}
                        }	
                        else{
                            Mensagem('O campo CPF/CNPJ deve ser preenchido');
                        }
                    }
                ?>
            </td>
        </tr>
        <tr>
            <td height="1" colspan="3" bgcolor="#CCCCCC"></td>
        </tr>
	</table> 
</form>