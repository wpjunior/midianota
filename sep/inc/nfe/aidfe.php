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
	$sql=mysql_query("SELECT cadastro.codigo, cadastro.nome, cadastro.ultimanota, cadastro.notalimite FROM cadastro 
INNER JOIN aidfe_solicitacoes ON cadastro.codigo = aidfe_solicitacoes.solicitante");
?>

<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
  <tr>
    <td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
    <td width="700" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;Prestadores - AIDF eletrônica</td>  
    <td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
  </tr>
  <tr>
    <td width="18" background="img/form/lateralesq.jpg"></td>
    <td align="center">


<fieldset style="margin-left:10px; margin-right:10px;">
	<legend>Solicitações</legend>
	<?php
	if(mysql_num_rows($sql)){
	?>
	<table width="100%">
		<tr bgcolor="#999999">
			<td>Prestador</td>
			<td>Nota Atual</td>
			<td>AIDF</td>
			<td></td>	
		</tr>
	<?php
		$x=0;
		while(list($codigo,$nome,$ultimanota,$notalimite)=mysql_fetch_array($sql)){
			?>
			<tr bgcolor="FFFFFF">
				<td><?php echo $nome; ?></td>
				<td><?php echo $ultimanota; ?></td>
				<td><?php echo $notalimite; ?></td>
				<td>
					<input type="submit" name="btLiberar" value="Liberar AIDF" class="botao" onclick="document.getElementById('cod1').value='<?php echo $codigo ?>';document.getElementById('frmAIDF').submit();" />
				</td>
			</tr>
			<?php
			$x++;
		}
	?>	
	</table>
	<?php
	}else{?>
		<center><b>Não há solicitações</b></center>
	<?php
	}
	?>
</fieldset>	
<?php
	if($btLiberar!="")
	{   
		$sql=mysql_query("SELECT razaosocial, notalimite FROM cadastro WHERE codigo='$cod'");
		list($razaosocial,$notalimite)=mysql_fetch_array($sql);
		?>
		<fieldset style="margin-left:10px; margin-right:10px;">	
			<legend>Controle do AIDFe</legend>
			<form name="frmAIDF" method="post">
				<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
				<input type="hidden" name="cod" id="cod" value="<?php echo $_POST['cod'];?>"  />
				<input type="hidden" name="btSolicitacoes" id="btSolicitacoes" value="T"  />
				<input type="hidden" name="btAtualiza" id="btAtualiza" value="T"  />
				<table align="left" width="100%">
					<tr align="left" bgcolor="#999999">
						<td>Prestador</td>
						<td>Limite Atual</td>
						<td>Novo Limite</td>
					</tr>
					<tr align="left" bgcolor="#FFFFFF">
						<td><?php echo $razaosocial; ?></td>
						<td width="20%"><?php echo $notalimite; ?></td>
						<td width="20%"><input type="text" name="txtAIDF" id="txtAIDF" class="texto" size="5" value="<?php echo $notalimite; ?>" /></td>
					</tr>
					<tr align="left">
						<td colspan="3"><input type="submit" name="btAtualiza" value="Atualizar" class="botao" /></td>
					</tr>
				</table>
				<input type="hidden" name="txtCodigo" value="<?php echo $cod; ?>" />
			</form>
		</fieldset>				
		<?php
	}
	if($btAtualiza!="")
	{?>
		<form name="frmAIDFat" method="post" id="frmAIDFat">
			<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
			<input type="hidden" name="cod" id="cod" value="<?php echo $_POST['cod'];?>"  />
			<input type="hidden" name="btSolicitacoes" id="btSolicitacoes" value="T"  />
		</form>	
			
	<?php	
		$sql=mysql_query("UPDATE cadastro SET notalimite='$txtAIDF' WHERE codigo='$txtCodigo'");
		$sql=mysql_query("DELETE FROM aidfe_solicitacoes WHERE solicitante='$txtCodigo'");
		add_logs('Liberou nota limite de AIDF');
		echo "
			<script>
				alert('Novo limite de AIDF liberado com sucesso');
				document.getElementById('frmAIDFat').submit();
			</script>
		";
	}
?>



<!--Cria um filtro para buscar empresas-->
<form method="post" action="">
	<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
	<fieldset style="margin-left:10px; margin-right:10px;"><legend>Filtro</legend>	
	<table width="100%">
		<tr>
			<td>Nome do Prestador</td>
			<td><input name="txtEmissor" type="text" class="texto" size="60" /></td>
		</tr>
		<tr>
			<td>CNPJ / CPF</td>
			<td>
				<input name="txtCNPJ" type="text" class="texto" onkeypress="return NumbersOnly( event );" onkeydown="stopMsk( event );" onkeyup="CNPJCPFMsk( this );" size="20" /> 
				<em>Somente n&uacute;meros</em> </td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" name="btBusca" value="Buscar" class="botao" /></td>
		</tr>
	</table>
    </fieldset>
</form>	
<?php
	if($btBusca!=""){// Verifica se a busca foi feita
	if($btAtualizar!="")// Se a atualização foi feita, registra as informações no banco
		{?>
			<form name="frmAIDF" method="post" id="frmAIDF">
			<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
			<input type="hidden" name="btBusca" id="btBusca" value="T" />
			<input name="txtEmissor" type="hidden" value="<?php echo $_POST['txtEmissor'];?>" />
			<input name="txtCNPJ" type="hidden" value="<?php echo $_POST['txtCNPJ'];?>"/> 
			</form>
		<?php	
			$x=0;
			while($x<=$txtLoop)
				{
					$sql=mysql_query("UPDATE cadastro SET notalimite='".$_POST['txtAIDF'.$x]."' WHERE codigo='".$_POST['txtCodigo'.$x]."'");
					$x++;
				}
			add_logs('Alterou dados AIDF');
			echo "
				<script>
					alert('Dados alterados com sucesso!');
					document.getElementById('frmAIDF').submit();
				</script>
			";	
		}
?>
<!--Cria a tela de controle do AIDF-->
<fieldset style="margin-left:10px; margin-right:10px;">
	<legend>AIDF Digital</legend>
<?php
	$sql=mysql_query("
			SELECT
				codigo, 
				razaosocial, 
				notalimite 
			FROM 
				cadastro 
			WHERE 
				razaosocial LIKE '$txtEmissor%' AND 
				nfe='s' AND 
				estado='A' AND
				(cnpj LIKE '$txtCNPJ%' OR cpf LIKE '$txtCNPJ%')
			
	");
?>
<form name="frmAIDF" method="post">
	<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
	<input type="hidden" name="btBusca" id="btBusca" value="T" />
	<input name="txtEmissor" type="hidden" value="<?php echo $_POST['txtEmissor'];?>" />
	<input name="txtCNPJ" type="hidden" value="<?php echo $_POST['txtCNPJ'];?>"/> 
	<?php
	if(mysql_num_rows($sql)==0){
		echo "<center><b>Não há solicitações</b></center>";
	}else{
		?>
		<table align="left" width="100%">
			<tr align="left" bgcolor="#999999">
				<td>Empresa</td>
				<td>AIDF</td>
				<td>Liberar AIDF</td>
			</tr>
			<?php
			$x=0;
			while(list($codigo,$razaosocial,$notalimite)=mysql_fetch_array($sql)){
				?>
					<tr align="left" bgcolor="#FFFFFF">
						<td><?php echo $razaosocial ?></td>
						<td>
							<input type="text" name="txtAIDF<?php echo $x ?>" id="txtAIDF<?php echo $x ?>" class="texto" size="5" value="<?php echo $notalimite ?>" />
						</td>
						<td>
							<input type="checkbox" name="cbAIDF<?php echo $x ?>" id="cbAIDF<?php echo $x ?>" onclick="AIDF('txtAIDF','cbAIDF','<?php echo $x ?>')" />
						</td>
					</tr>
				<?php
				if($notalimite==0)
					{
						echo "<script>MarcaCheckboxAIDF('cbAIDF','txtAIDF','$x')</script>";
					}
				echo "<input type=\"hidden\" name=\"txtCodigo$x\" value=\"$codigo\" />";
				$x++;
			}
			echo "<input type=\"hidden\" name=\"txtLoop\" value=\"$x\" />";	
			?>
			<tr align="left">
				<td colspan="3"><input type="submit" name="btAtualizar" value="Atualizar" class="botao" /></td>
			</tr>	
		</table>
	<?php 
	} // fim if mysql_num_rows
	?>
</form>
</fieldset>
<?php } ?>




	</td>
	<td width="19" background="img/form/lateraldir.jpg"></td>
  </tr>
  <tr>
    <td align="left" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantoesq.jpg" /></td>
    <td background="img/form/rodape_fundo.jpg"></td>
    <td align="right" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantodir.jpg" /></td>
  </tr>
</table>
<form id="frmAIDF" method="post">
	<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
	<input type="hidden" name="cod" id="cod1"  />
	<input type="hidden" name="btSolicitacoes" id="btSolicitacoes" value="T"  />
	<input type="hidden" name="btLiberar" id="btLiberar" value="T"  />
</form>
