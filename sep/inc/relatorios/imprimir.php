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

include("../../inc/conect.php");
include("../../funcoes/util.php");
// variaveis vindas do conect.php
// $CODPREF,$PREFEITURA,$USUARIO,$SENHA,$BANCO,$TOPO,$FUNDO,$SECRETARIA,$LEI,$DECRETO,$CREDITO,$UF	



$sql_brasao = mysql_query("SELECT brasao FROM configuracoes");
//preenche a variavel com os valores vindos do banco
list($BRASAO) = mysql_fetch_array($sql_brasao);




?>

<title>Imprimir Relat&oacute;rio</title>


<style type="text/css">
<!--
.style1 {font-family: Georgia, "Times New Roman", Times, serif}

.tabela {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	border-collapse:collapse;
	border: 1px solid #000000;
}
.tabelameio {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	border-collapse:collapse;
	border: 1px solid #000000;
}
.tabela tr td{
	border: 1px solid #000000;
}
.fonte{
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style>
</head>

<body>

<div id="DivImprimir">
<input type="button" onClick="print();this.style.display = 'none';" value="Imprimir" /></div>
<center>

<table width="700px" height="120" border="2" cellspacing="0" class="tabela">
  <tr>
    <td width="106"><center><img src="../../img/brasoes/<?php print $BRASAO; ?>" width="96" height="105"   />
    </center></td>
    <td width="584" height="33" colspan="2"><span class="style1">
      <center>
             <p>RELAT&Oacute;RIO DE PRESTADORES </p>
             <p>PREFEITURA MUNICIPAL DE <?php print strtoupper($CONF_CIDADE); ?> </p>
             <p><?php print strtoupper($CONF_SECRETARIA); ?> </p>
      </center>
    
    
    </span></td>
  </tr>
  </table>
<br>



<table width="700px" border="1" cellspacing="0" class="tabelameio"  > 

<tr>
  
		<td width="32%" >
<table>
							<?php
							//Comando sql que selecionara do banco os tipos de prestadores e a quantidade de cada e o total geral

							$sql_tipo = mysql_query("
								SELECT 
									tipo.nome, 
									COUNT(cadastro.codigo) 
								FROM 
									cadastro 
								INNER JOIN 
									tipo ON tipo.codigo = cadastro.codtipo 
								WHERE
									(tipo = 'prestador' OR tipo = 'tomador' OR tipo = 'contador')
								GROUP BY 
									tipo.nome
							");
							echo "<b><center><font class=\"fonte\">Tipos de Prestadores</center></b> <br>";
							
							$qtdtotal=0;
							while(list($nome,$qtd)=mysql_fetch_array($sql_tipo)){
								echo"<tr><td align=\"center\"><font class=\"fonte\">$nome:</font></td><td align=\"center\"><font class=\"fonte\">$qtd</font></td></tr>";
								$qtdtotal=$qtdtotal+$qtd;
								}
							?>
							<tr>
								<td align="center"><font class="fonte"> Total:</font></td><td><?php echo "<font class=\"fonte\"> $qtdtotal<font>"; ?></td>
					 		</tr>
		  </table>
	  	
		<td width="34%" valign="top">
		  <table  border="0" > 
        
       <tr >
<?php

//Comando sql que selecionará do banco a quantidade de prestadores por estado
$sql = mysql_query ("
	SELECT 
		uf , 
		COUNT(*) 
	FROM 
		cadastro 
	INNER JOIN
		tipo ON cadastro.codtipo = tipo.codigo
	WHERE 
		uf != '' AND codtipo > 0  AND (tipo = 'prestador' OR tipo = 'tomador' OR tipo = 'contador')
	GROUP BY 
		uf
");

echo "<b><center>Qnt. de Prestadores por Estado (UF)</center></b> <br>";

$qtdtotal=0;
$cont = 0;
while(list($uf,$qtd)=mysql_fetch_array($sql)){
if($cont == '5'){
echo "</tr><tr>";

$cont = 0;  
}
echo"<td align=\"center\" ><font class=\"fonte\">$uf:</td><td align=\"center\"><font class=\"fonte\">$qtd</font></td>";
$qtdtotal=$qtdtotal+$qtd;

$cont++;
}
								
?>
</tr>
    <tr>
        <td align="left"><font class="fonte">Total:</font></td><td><?php echo "<font class=\"fonte\">$qtdtotal</font>"; ?></td>
    </tr>
      </table>
      </td>
		<td width="34%" valign="top">
			<table>
            <?php 
			//Comando sql que selecionará do banco os tipos de declaracoes e quantidade de cada
			$sql_tipodec = mysql_query("SELECT declaracoes.declaracao, COUNT(*)
										FROM
										  declaracoes 
										INNER JOIN
										  cadastro ON cadastro.codtipodeclaracao = declaracoes.codigo
										INNER JOIN 
										  tipo ON cadastro.codtipo = tipo.codigo
										WHERE 
										  (tipo = 'prestador' OR tipo = 'tomador' OR tipo = 'contador')
										GROUP BY
										  declaracoes.declaracao");
			
			echo "<b><center>Tipos de Declarações</center></b> <br>";  
										  
			$qtdtotal=0;							  
			while(list($declaracoes,$qtd)=mysql_fetch_array ($sql_tipodec)){
			echo"<tr><td align=\"center\"><font class=\"fonte\">$declaracoes:</td><td align=\"center\"><font class=\"fonte\">$qtd</td></tr>";
			$qtdtotal=$qtdtotal+$qtd;
			}
			?>  
                            <tr>
								<td align="left"><font class="fonte">Total:</font></td><td><?php echo "<font class=\"fonte\"> $qtdtotal</font>"; ?></td>
					 		</tr>          
   			</table>
	  </td>
	</tr>	
		

					  

   	

<?php
	
	
	//Recebe as variaveis enviadas pelo form por post

	$nome        = trataString($_POST['txtNome']);
	$razao       = trataString($_POST['txtRazao']);
	$cnpj        = $_POST['txtCNPJCPF'];
	$uf          = trataString($_POST['cmbEstado']);
	$municipio   = trataString($_POST['txtInsMunicipioEmpresa']);
	$declaracao  = $_POST['cmbTipoDec'];
	$codtipo     = $_POST['cmbCodtipo'];
	$str_where   = "";
	

	
	
	//verifica quais campos foram preenchidos e concatena na variavel str_where
	if($codtipo){
		$str_where .= " AND cadastro.codtipo = '$codtipo'";
	}else{
		$str_where .= " AND (tipo = 'prestador' OR tipo = 'tomador' OR tipo = 'contador') ";
	}
	if($cnpj){
		$str_where .= " AND (cadastro.cnpj = '$cnpj' OR cadastro.cpf = '$cnpj')";
	}
	if($declaracao){
		$str_where .= " AND cadastro.codtipodeclaracao = '$declaracao'";
	}
	if($municipio){
		$str_where .= " AND cadastro.municipio = '$municipio'";
	}
	if($uf){
		$str_where .= " AND cadastro.uf = '$uf'";
	}
	if($razao){
		$str_where .= " AND cadastro.razaosocial LIKE '%$razao%'";
	}
	
//Sql buscando as informações que o usuario pediu e com o limit estipulado pela função
	$query = ("
			SELECT
			  `cadastro`.`razaosocial`, `cadastro`.`cnpj`, `cadastro`.`cpf`,
			  `cadastro`.`municipio`, `cadastro`.`uf`, `cadastro`.`nome`,
			  `cadastro`.`codigo`, `cadastro`.`codtipo`, `tipo`.`tipo`, `cadastro`.`codtipodeclaracao`,
			  declaracoes.declaracao
			FROM
			  `cadastro` 
			INNER JOIN
			  `tipo` ON `tipo`.`codigo` = `cadastro`.`codtipo`
			LEFT JOIN
				declaracoes ON declaracoes.codigo = cadastro.codtipodeclaracao
			WHERE
			 	cadastro.nome LIKE '%$nome%'  $str_where
			ORDER BY
			  `cadastro`.`codigo`
			");
	$sql_pesquisa = mysql_query ($query);
	$result = mysql_num_rows($sql_pesquisa);
	
	
	
if(mysql_num_rows($sql_pesquisa)){
?>


<table width="700px" class="tabela">
	<tr style="background-color:#999999">
    <?php echo "<b>Foram encontrados $result  Resultados</b>"; ?>
    	<td width="14%" align="center"><strong>Tipo</strong></td>
      <td width="38%" align="center"><strong>Nome</strong></td>
      <td width="28%" align="center"><strong>CPF/CNPJ</strong></td>
      <td width="20%" align="center"><strong>Tipo Dec</strong></td>

  </tr>
  <?php
  		
		$x = 0;
		$tipos_extenso = array(
			"prestador"              => "Prestador",
			"empreiteira"            => "Empreiteira",
			"instituicao_financeira" => "Instituição Financeira",
			"cartorio"               => "Cartório",
			"operadora_credito"      => "Operadora de Crédito",
			"grafica"                => "Gráfica",
			"contador"               => "Contador",
			"tomador"                => "Tomador",
			"orgao_publico"          => "Orgão Público",
			"simples"                => "Simples"
		);
		while($dados_pesquisa = mysql_fetch_array($sql_pesquisa)){
			$declaracoes = $dados_pesquisa['declaracao']
		//print_array($dados_pesquisa);
 ?>
<input type="hidden" name="txtCodigoGuia<?php echo $x;?>" id="txtCodigoGuia<?php echo $x;?>" value="<?php echo $dados_pesquisa['tipo'];?>" />

    <tr id="trDecc<?php echo $x;?>">
    	<td bgcolor="white"  align="center"><?php echo $tipos_extenso[$dados_pesquisa['tipo']];	?></td>
        <td bgcolor="white"  align="left"><?php echo $dados_pesquisa['nome'];?></td>
     	<td bgcolor="white" align="center"><?php echo $dados_pesquisa['cnpj'].$dados_pesquisa['cpf'];?></td>
        <td bgcolor="white"  align="center"><?php echo $declaracoes;?></td>

  </tr>
      
 
  <?php
			$x++;
		}//fim while
	?>
</table>
<?php
 }else{
 //caso não encontre resultados, a mensagem 'Não há resultados!' será mostrada na tela
	echo "<center><b><font class=\"fonte\">Não há resultados!</font></b></center>";
	
}

?></table>
</body>
</html>

