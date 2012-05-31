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
  if($btExportar !="")
  {   
   if(($cmbMes !="") || ($cmbAno !="")){
   		if($cmbMes<=9){
			$cmbMes="0".$cmbMes;
		}
	   $periodo = $cmbAno."-".$cmbMes;	   
	   $sql = mysql_query("
		SELECT 
			notas.numero,
			notas.codverificacao,
			notas.datahoraemissao,
			cadastro.nome,
			notas.rps_numero,
			notas.rps_data,
			notas.tomador_nome,
			notas.tomador_cnpjcpf,
			notas.tomador_inscrmunicipal,
			notas.tomador_logradouro,
			notas.tomador_numero,
			notas.tomador_complemento,
			notas.tomador_bairro,						
			notas.tomador_cep,
			notas.tomador_municipio,
			notas.tomador_uf,
			notas.tomador_email,
			notas.discriminacao,
			notas.valortotal,
			servicos.descricao,
			notas.valordeducoes,
			notas.basecalculo,
			notas.valoriss,
			notas.issretido,
			notas.credito,
			notas.estado	
		FROM 
			notas 
		INNER JOIN 
			notas_servicos ON notas.codigo = notas_servicos.codnota
		INNER JOIN 
			servicos ON servicos.codigo = notas_servicos.codservico
		INNER JOIN 
			cadastro  ON notas.codemissor = cadastro.codigo
		WHERE 
			datahoraemissao LIKE '%$periodo%' AND notas.codemissor = '$CODIGO_DA_EMPRESA' ORDER BY datahoraemissao");
	   
		// Gera o arquivo CSV para download
		$arquivo = $CODIGO_DA_EMPRESA."arquivo.csv";
		$fp = fopen("tmp/".$arquivo, "w");
		$cabecario = "Número da nota;Código de verificação;Data e hora de emissão;Número do  RPS;Data do RPS;Nome do Tomador de serviços;CPF/CNPJ do Tomador de serviços;Inscrição municipal do Tomador de serviços;Logradouro do Tomador de serviços;Número do Tomador de serviços;Complemento do Tomador de serviços;Bairro do Tomador de serviços;CEP do Tomador de serviços;Município do Tomador de serviços;UF do Tomador de serviços;Email do Tomador de serviços;Discriminação da nota;Valor total da nota;Valor de deduções;Base de Calculo;Valor ISS;ISS retido;Credito gerado;Estado da nota;Discriminação de Serviços\n";
		fwrite($fp, $cabecario);
		
		while($cadastro = mysql_fetch_array($sql)) {
			switch($cadastro["estado"]){
				case "C": $cadastro["estado"]= "Cancelada"; break;
				case "N": $cadastro["estado"]= "Normal"; break;
				case "B": $cadastro["estado"]= "Boleto Gerado"; break;
				case "E": $cadastro["estado"]= "Escriturada"; break;
			}
			
			$registros = $cadastro["numero"] . ";" . $cadastro["codverificacao"] .";" . $cadastro["datahoraemissao"] .";" . $cadastro["rps_numero"] .
			";" . DataPt($cadastro["rps_data"]) .";" . $cadastro["tomador_nome"] .";" . $cadastro["tomador_cnpjcpf"] .";" . $cadastro["tomador_inscrmunicipal"] .
			";" . $cadastro["tomador_logradouro"] .";". $cadastro["tomador_numero"] .";". $cadastro["tomador_complemento"] .";". $cadastro["tomador_bairro"] .
			";".$cadastro["tomador_cep"] .";" . $cadastro["tomador_municipio"] .";" . $cadastro["tomador_uf"] .
			";" . $cadastro["tomador_email"] .";" . $cadastro["discriminacao"] .";" . $cadastro["valortotal"] .";" . $cadastro["valordeducoes"] .
			";" . $cadastro["basecalculo"] .";" . $cadastro["valoriss"] .";" . $cadastro["issretido"] .";" . $cadastro["credito"] .";" . $cadastro["estado"] .
			";" . $cadastro["descricao"] . "\n";
			
			fwrite($fp, $registros); // Grava a linha no arquivo
		}
		fclose($fp);
		// Mensagem de concluído
		/*$display = "Arquivo gerado com sucesso.<bR>\n
		Clique com o botão direito do mouse em cima de &quot;CLIQUE AQUI&quot; e depois em salvar destino.<br>*/
	  }else{
	  	print("<script language=JavaScript>alert('Selecione um mes e um ano!!')</script>");
	  }
  }
  ?>

  <form action="exportar.php" method="post" name="frmPagamento" id="frmPagamento" >   
<table border="0" align="center" cellpadding="0" cellspacing="1">
    <tr>
      <td width="10" height="10" bgcolor="#FFFFFF"></td>
	  <td width="100" align="center" bgcolor="#FFFFFF" rowspan="3">Exportar Notas</td>
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
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">	       
   <tr>
	<td align="left" width="30%">Período das Notas</td>
	<td align="left" width="70%">
	<select name="cmbMes" class="combo">
	  <option value="">== Mês ==</option>
	  <?php
	  $meses=array(1 => "Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
	  foreach($meses as $num => $mes){
	  	echo "<option value='$num' "; 
		if($cmbMes==$num){echo "selected=selected";}
		echo ">$mes</option>";
	  }
	  ?>
	</select> / 
	<select name="cmbAno" class="combo">
		<option value="">==ANO==</option>
		<?php
			$ano = date("Y");
			for($x=0; $x<=4; $x++)
				{
					$year=$ano-$x;
					echo "<option value='$year' "; 
					if($cmbAno==$year){echo "selected=selected";}
					echo ">$year</option>";
				}
		?>
	</select>
	</td>
   </tr>	  
	<tr>
	  <td colspan="2" align="center"><input type="submit" value="Exportar" name="btExportar" class="botao" /></td>
	  </tr>
	<td colspan="2" align="center">
	<?php if(($btExportar !="") && ($cmbMes !="") && ($cmbAno !=""))
	{
	  print("Exportação concluída com sucesso!<br>
	  <a href='../download?/contador/tmp/$arquivo'><img src='../img/imgcsv.jpg' border='0'></a> &nbsp; 
	  <a href='../download?/contador/tmp/$arquivo'>Clique aqui</a> para baixar o arquivo");
	} ?>
	
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
