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
	// SELECIONA OS BANCOS DISPONIVEIS DO BANCO DE DADOS
	$sqlbancos = mysql_query("SELECT banco FROM bancos");
	
	// TESTA SE O BOTÃO CONFIRMAR FOI CLICADO E REALIZA A OPERACAO
	if($_POST['btConfirmar']=="Confirmar")
		{
			if($txtNossoNumero == '')
			{
				echo"<script>alert('Preecha o campo * Nosso Numero')</script>";
			}
			else
			{
				if($txtValorBoleto == '')
				{
					echo"<script>alert('Preecha o campo * Valor')</script>";
				}
				else
				{
					$sql=mysql_query("SELECT pago, valor, codigo FROM guia_pagamento WHERE nossonumero='$txtNossoNumero'");
					list($pago, $valornossonumero) = mysql_fetch_array($sql);
					if(mysql_num_rows($sql)!=0)
					{
						if($pago == "N")
						{
							$valor = MoedaToDec($_POST['txtValorBoleto']);
							if($valornossonumero == $valor)
							{
								// ATUALIZA O BANCO DE DADOS ONDE O NOSSO NUMERO E O VALOR CORESPONDE AOS SEUS VALORES NO BANCO
								mysql_query("UPDATE guia_pagamento SET pago='S' WHERE nossonumero='$txtNossoNumero' AND valor=$valor");
								add_logs('Inseriu uma Guia de Pagamento');
								echo"<script>alert('Pagamento realizado com sucesso')</script>";
							}
							else
							{
								echo"<script>alert('Valor não corresponde ao valor da nota')</script>";
							} // FIM DO TESTE DA VARIAVEL VALORNOSSONUMERO COM VALOR
						}
						else
						{
							echo"<script>alert('Pagamento já efetuado')</script>";
						}
					} // FIM DO IF DE TESTE DA VARIAVEL PAGO
					else
					{
						echo"<script>alert('Nosso Número digitado não consta em nosso banco de dados ou o valor é diferente, favor verificar!')</script>";
					} // FIM DO IF NUMROWS
				} // FIM DO IF TXTVALORBOLETO
			} // FIM DO IF TXTNOSSOSNUMERO
		} // FIM DO IF BOTAO CONFIRMAR
?>

<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
	<tr>
		<td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
		<td width="700" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;Escritura&ccedil;&otilde;es - Processos</td>  
		<td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
	</tr>
	<tr>
		<td width="18" background="img/form/lateralesq.jpg"></td>
		<td align="center">
			<table width="730" bgcolor="#CCCCCC">
				<tr>
					<td>
						<form method="post"  enctype="multipart/form-data" id="frmEscrituracoes"name="frmEscrituracoes">
						<input type="hidden" name="include" id="include" value="<?php echo $_POST['include']; ?>">
							<fieldset><legend>Bancos</legend>	
								<table width="100%">
									<tr>
										<select name="slBancos">
											<option>=== Selecione um Banco ===</option>
											<?php
											// MONTA UMA CMB COM AS OPCOES PUXADAS DO BANCO
											while(list($bancos) = mysql_fetch_array($sqlbancos)){
										  		echo "<option value=\"$bancos\" onclick=\"acessoAjax('inc/escrituracoes/bancos.php','frmEscrituracoes','divSelecao');\">$bancos</option>";
										  		break;
											}
												?>
										</select>
									</tr>
								</table>
							</fieldset>
						<div id="divSelecao"></div>
							<div id="escrituracao"><fieldset><legend>Pagamento Manual</legend>
								<table>
									<tr>
										<td>Nosso Número*</td>
										<td><input type="text" class="texto" size="20" name="txtNossoNumero" id="txtNossoNumero"></td>
										<td rowspan="2"><input type="submit" class="botao" value="Confirmar" name="btConfirmar"></td>
									</tr>
									<tr>	
										<td>Valor *</td>
										<td><input type="text" class="texto" onkeyup="MaskMoeda(this)" size="20" name="txtValorBoleto"></td>
									</tr>
								</table>
							</fieldset></div>
						</form>
					</td>
				</tr>
			</table>

<?php
// TESTA SE O BOTAO IMPORTAR FOI CLICADO
if($_POST['btnImportar'] =="Importar"){
	$arquivo=$_FILES['Arquivo_bb']["name"];
	$arquivo_tmp=$_FILES['Arquivo_bb']["tmp_name"];
	
	$extencao = array_reverse(explode('.',$arquivo));
	if($extencao[0]!='txt'){
		$arquivo = '';
	}
	if($arquivo!=""){
		$nro=rand(00000,99999);
		$arquivo=$nro.".txt"; 
		move_uploaded_file($arquivo_tmp,"/dados/sepiss/docs/".$arquivo);
		$ponteiro=fopen("/dados/sepiss/docs/$arquivo", "r");
		$x=0; $y=0;
	 	?>
        <table width="730" bgcolor="#CCCCCC">
         <tr>
          <td>
           <fieldset>
            <table width="100%">
             <tr>
              <td align="center" bgcolor="#999999">Nome</td>
              <td align="center" bgcolor="#999999">Boleto N°</td>
              <td align="center" bgcolor="#999999">Pagamento</td>
             </tr>
<?php

    $contents = fread($ponteiro, filesize("/dados/sepiss/docs/$arquivo")); 
    //echo("<pre>$contents</pre>");
    $row = explode("\n",$contents);

    for($contlinha=21;$contlinha<(count($row)-3);$contlinha++){
    	$content .= $row[$contlinha]."\n";
		$nossonum[]=substr($row[$contlinha], 13, 21);
    }

	//while(!feof($ponteiro)){
	while($x<count($nossonum)){
	    //$linha[$x]=fgets($ponteiro, 4096);
	    //$nossonumero=substr($linha[$x], 13, 21);
	    $nossonumero = $nossonum[$x];
	    //echo $nossonumero.'<br>';
		$relacionamento = mysql_query("
			SELECT 
				guias_declaracoes.relacionamento 
			FROM 
				guia_pagamento
			INNER JOIN 
				guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia  
			WHERE 
				nossonumero='$nossonumero'
		");
		 $sql=mysql_query("
		 	SELECT 
		 		codigo, 
		 	pago, 
		 		nossonumero 
		 	FROM 
		 		guia_pagamento 
		 	WHERE 
		 		nossonumero='$nossonumero'
		 ");
	
		 
		 if(mysql_num_rows($sql)){
		 	list($codigo, $pago)=mysql_fetch_array($sql);
			$update=mysql_query("UPDATE guia_pagamento SET pago='S' WHERE codigo='$codigo'");
			//echo mysql_error();
			// SELECIONA O TIPO DE RELACIONAMENTO
			list($tipo) = mysql_fetch_array($relacionamento);
			if($tipo=="des")
			{
				$sqlnome = mysql_query("
				SELECT emissores.razaosocial, guia_pagamento.pago, guia_pagamento.nossonumero
				FROM guia_pagamento 
				INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia 
				INNER JOIN des ON guias_declaracoes.codrelacionamento=des.codigo
				INNER JOIN cadastro as emissores ON des.codemissor=emissores.codigo
				WHERE guia_pagamento.nossonumero = '$nossonumero' GROUP BY guia_pagamento.datavencimento");
			}
			elseif($tipo=="des_issretido")
			{
				$sqlnome = mysql_query("
				SELECT tomadores.nome, guia_pagamento.pago, guia_pagamento.nossonumero
				FROM guia_pagamento 
				INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia 
				INNER JOIN des_issretido ON guias_declaracoes.codrelacionamento=des_issretido.codigo
				INNER JOIN cadastro as tomadores ON des_issretido.codtomador=tomadores.codigo
				WHERE guia_pagamento.nossonumero = '$nossonumero' GROUP BY guia_pagamento.datavencimento");
			}
			elseif($tipo=="cartorios_des")
			{
				$sqlnome = mysql_query("
				SELECT cartorios.nome, guia_pagamento.pago, guia_pagamento.nossonumero
				FROM guia_pagamento 
				INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia 
				INNER JOIN cartorios_des ON guias_declaracoes.codrelacionamento=cartorios_des.codigo
				INNER JOIN cadastro as cartorios ON cartorios_des.codcartorio=cartorios.codigo
				WHERE guia_pagamento.nossonumero = '$nossonumero' GROUP BY guia_pagamento.datavencimento");
			}
			elseif($tipo=="dop_des")
			{
				$sqlnome = mysql_query("
				SELECT orgaospublicos.nome, guia_pagamento.pago, guia_pagamento.nossonumero
				FROM guia_pagamento 
				INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia 
				INNER JOIN dop_des ON guias_declaracoes.codrelacionamento=dop_des.codigo
				INNER JOIN cadastro as orgaospublicos ON dop_des.codorgaopublico=orgaospublicos.codigo
				WHERE guia_pagamento.nossonumero = '$nossonumero' GROUP BY guia_pagamento.datavencimento");
			}
			elseif($tipo=="dif_des")
			{
				$sqlnome = mysql_query("
				SELECT inst_financeiras.nome, guia_pagamento.pago, guia_pagamento.nossonumero
				FROM guia_pagamento 
				INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia 
				INNER JOIN dif_des ON guias_declaracoes.codrelacionamento=dif_des.codigo
				INNER JOIN cadastro as inst_financeiras ON dif_des.codinst_financeira=inst_financeiras.codigo
				WHERE guia_pagamento.nossonumero = '$nossonumero' GROUP BY guia_pagamento.datavencimento");
			}
			elseif($tipo=="decc_des")
			{
				$sqlnome = mysql_query("
				SELECT empreiteiras.nome, guia_pagamento.pago, guia_pagamento.nossonumero
				FROM guia_pagamento 
				INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia 
				INNER JOIN decc_des ON guias_declaracoes.codrelacionamento=decc_des.codigo
				INNER JOIN cadastro as empreiteiras ON decc_des.codempreiteira=empreiteiras.codigo
				WHERE guia_pagamento.nossonumero = '$nossonumero' GROUP BY guia_pagamento.datavencimento");
			}
			elseif($tipo=="doc_des")
			{
				$sqlnome = mysql_query("
				SELECT operadoras_creditos.nome, guia_pagamento.pago, guia_pagamento.nossonumero
				FROM guia_pagamento 
				INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia 
				INNER JOIN doc_des ON guias_declaracoes.codrelacionamento=doc_des.codigo
				INNER JOIN cadastro as operadoras_creditos ON doc_des.codopr_credito=operadoras_creditos.codigo
				WHERE guia_pagamento.nossonumero = '$nossonumero' GROUP BY guia_pagamento.datavencimento");
			}
			elseif($tipo=="nfe")
			{
				$sqlnome = mysql_query("
                           SELECT emissores.razaosocial, guia_pagamento.pago, guia_pagamento.nossonumero
				FROM guia_pagamento
				INNER JOIN guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia 
				INNER JOIN notas ON guias_declaracoes.codrelacionamento=notas.codigo
				INNER JOIN cadastro as emissores ON notas.codemissor=emissores.codigo
                           WHERE guia_pagamento.codigo = '$codigo' GROUP BY guia_pagamento.codigo");
			}
			/*$sqlnome = mysql_query("
				SELECT 
					emissores.razaosocial, 
					guia_pagamento.pago, 
					guia_pagamento.nossonumero
				FROM 
				guia_pagamento
				INNER JOIN 
					guias_declaracoes ON guia_pagamento.codigo=guias_declaracoes.codguia 
				INNER JOIN 
					notas ON guias_declaracoes.codrelacionamento=notas.codigo
				INNER JOIN 
					cadastro ON notas.codemissor=emissores.codigo
				WHERE 
					guia_pagamento.codigo = '$codigo' 
				GROUP BY guia_pagamento.codigo
			");*/
			list($nome, $pago, $nossonumero)=mysql_fetch_array($sqlnome);
			// TRANSFORMA A VARIAVEL PAGO
			switch($pago)
			{
				case 'S': $pago = "Pago"; break;
				case 'N': $pago = "Não Pago"; break;
			}
			
			echo "
					<tr>
						<td align=\"center\" bgcolor=\"FFFFFF\">$nome</td>
						<td align=\"center\" bgcolor=\"FFFFFF\">$nossonumero</td>
						<td align=\"center\" bgcolor=\"FFFFFF\">$pago</td>
					</tr>
			";
		}else{ // FIM DO if existe
			echo "
					<tr>
						<td align=\"center\" bgcolor=\"#ffac84\">não encontrada</td>
						<td align=\"center\" bgcolor=\"#ffac84\">$nossonumero</td>
						<td align=\"center\" bgcolor=\"#ffac84\"></td>
					</tr>
			";
		}
		$x++;		
	} // FIM DO WHILE PONTEIRO
	fclose($ponteiro);
	unlink("/dados/sepiss/docs/$arquivo");
	//echo "<tr><td colspan=\"2\"><input type=\"button\" class=\"botao\" value=\"Voltar\" onClick=\"window.location='importar.php';\" /></td></tr>";
	echo "
		   <script>
		    alert('Importação de dados concluída com sucesso!');
		   </script>
	";
  } //FIM DO IF ARQUIVO
  else
  {
   echo "
	<script>
 	 alert('Insira o documento texto enviado pelo Banco do Brasil');
	</script>
		";
  } //FIM DO ELSE
?>
							</table>
						</fieldset> 	
					</td>
				</tr>
			</table>
<?php
} //FIM DO BOTAO IF BOTAO IMPORTAR
?>


		<td width="19" background="img/form/lateraldir.jpg"></td>
	</tr>
	<tr>
		<td align="left" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantoesq.jpg" /></td>
		<td background="img/form/rodape_fundo.jpg"></td>
		<td align="right" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantodir.jpg" /></td>
	  </tr>
</table>