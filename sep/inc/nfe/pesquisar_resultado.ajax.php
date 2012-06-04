<?php
/*
LICENÇA PÚBLICA GERAL GNU
Versão 3, 29 de junho de 2007
    Copyright (C) <2010>  <PORTAL PÚBLICO INFORMÁTICA LTDA>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

Este programa é software livre: você pode redistribuí-lo e / ou modificar sob os termos da GNU General Public License como publicado pela Free Software Foundation, tanto a versão 3 da Licença, ou (por sua opção) qualquer versão posterior.

Este programa é distribuído na esperança que possa ser útil, mas SEM QUALQUER GARANTIA, sem mesmo a garantia implícita de COMERCIALIZAÇÃO ou ADEQUAÇÃO A UM DETERMINADO PROPÓSITO. Veja a GNU General Public License para mais detalhes.

Você deve ter recebido uma cópia da GNU General Public License  junto com este programa. Se não, veja <http://www.gnu.org/licenses/>.


This is an unofficial translation of the GNU General Public License into Portuguese. It was not published by the Free Software Foundation, and does not legally state the distribution terms for software that uses the GNU GPL  only the original English text of the GNU GPL does that. However, we hope that this translation will help Portuguese speakers understand the GNU GPL better.

Esta é uma tradução não oficial em português da Licença Pública Geral GNU (da sigla em inglês GNU GPL). Ela não é publicada pela Free Software Foundation e não declara legalmente os termos de distribuição para softwares que a utilizam  somente o texto original da licença, escrita em inglês, faz isto. Entretanto, acreditamos que esta tradução ajudará aos falantes do português a entendê-la melhor.


// Originado do Projeto ISS Digital  Portal Público que tiveram colaborações de Vinícius Kampff, 
// Rafael Romeu, Lucas dos Santos, Guilherme Flores, Maikon Farias, Jean Farias e Daniel Bohn
// Acesse o site do Projeto www.portalpublico.com.br             |
// Equipe Coordenação Projeto ISS Digital: <informatica@portalpublico.com.br>   |

*/
?>



<fieldset style="width:800px"><legend>Resultado da Pesquisa</legend>
<?php
require_once("../conect.php");
require_once("../nocache.php");
require_once("../../funcoes/util.php");

//ve se alguma nota foi cancelada
if($_GET["txtCodigoCancela"]){ 
	$codigo_nota = base64_decode($_GET["txtCodigoCancela"]);
	mysql_query("UPDATE notas SET estado = 'C' WHERE codigo = '$codigo_nota'"); 
}//fim if se cancela uma nota.

$numero            = $_GET['txtNumeroNota'];
$codverificacao    = $_GET['txtCodigoVerificacao'];
$prestador_cnpjcpf = $_GET['txtCNPJPrestador'];
$tomador_cnpjcpf   = $_GET['txtCNPJ'];
$string = "";
if($numero){
	$string .= " AND notas.numero = '$numero'";
}

if($prestador_cnpjcpf){
	$string .= " AND cadastro.cnpj = '$prestador_cnpjcpf'";
}

if($tomador_cnpjcpf){
	$string .= " AND notas.tomador_cnpjcpf = '$tomador_cnpjcpf'";
}

$query=("
	SELECT
		`notas`.`codigo`, `notas`.`numero`, `notas`.`codverificacao`,
		`notas`.`datahoraemissao`, `notas`.`codemissor`, `notas`.`tomador_nome`,
		`notas`.`tomador_cnpjcpf`, `notas`.`estado`, cadastro.nome
	FROM
		`notas`
	INNER JOIN 
		cadastro ON notas.codemissor = cadastro.codigo	
	WHERE
		`notas`.`codverificacao` LIKE '$codverificacao%' $string
	ORDER BY 
		notas.datahoraemissao DESC
"); // fim sql

$sql=Paginacao($query,'frmNfe','divResultado');
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
	<?php 
	if(mysql_num_rows($sql)>0){ ?>
	  <tr>
		<td width="45" align="center">N&ordm;</td>
		<td width="80" align="center">Cód Verif</td>
		<td width="70" align="center">D/H Emissão</td>
		<td width="200" align="center">Nome Emissor</td>
		<td width="200" align="center">Nome Tomador</td>
		<td width="70" align="center">Estado</td>
		<td width="75">&nbsp;</td>
	  </tr>
	  <tr>
		<td colspan="7" height="1" bgcolor="#999999"></td>
	  </tr>
	<?php
	while(list($codigo, $numero, $codverificacao, $datahoraemissao, $codempresa, $tomador_nome, $tomador_cnpjcpf, $estado, $emissor_nome) = mysql_fetch_array($sql)) {
	
	// mascara o codigo com cripto base64 
	$crypto = base64_encode($codigo);
	if($estado == "C"){$cor = "#FFAC84";}else{$cor = "#FFFFFF";}
	 
	
	?>    
	  <tr>
		<td bgcolor="<?php echo $cor;?>" width="45" align="right"><?php echo $numero; ?></td>
		<td width="80" align="center" bgcolor="<?php echo $cor;?>"><?php echo $codverificacao;  ?></td>	
		<td width="70" bgcolor="<?php echo $cor;?>" align="center"><?php echo substr($datahoraemissao,8,2)."/".substr($datahoraemissao,5,2)."/".substr($datahoraemissao,0,4)." ".substr($datahoraemissao,11,5); ?></td>
		<td width="200" align="left" bgcolor="<?php echo $cor;?>"><?php echo $emissor_nome; ?></td>
		<td width="200" align="left" bgcolor="<?php echo $cor;?>"><?php echo $tomador_nome; ?></td>
		<td width="75" align="center" bgcolor="<?php echo $cor;?>"><?php 
		switch ($estado) { 
		case "C": echo "Cancelado"; break;
		case "N": echo "Normal"; break;
		case "B": echo "Boleto Gerado"; break;
		case "E": echo "Escriturada"; break;
		} 
		
		?></td>	
		<td bgcolor="#FFFFFF" width="60"><img  style="cursor:pointer;" title="Imprimir Nota" src="img/botoes/botao_imprimir.jpg" onclick="document.getElementById('CODIGO').value='<?php echo $crypto;?>';cancelaAction('frmNfe','inc/nfe/imprimir.php','_blank')" />
		<?php
		if ($estado !== "C") {
		?>
		
		<img style="cursor:pointer;" title="Cancelar Nota" src="img/botoes/botao_cancelar.jpg" 
		onclick="CancelaNota('<?php echo $crypto;?>','Cancelar nota N° <?php echo "$numero de $emissor_nome"; ?>?');" />
		<?php
		} // fecha if
		?>
		</td>
	  </tr>
	  <?php
		} // fim while  
	}else{//fim if se tem resultados
	?>
	<tr>
		<td><strong><center>Nenhum resultado encontrado.</center></strong></td>
	</tr>
	<?php
	}//else se nao tem resultados da busca
  ?> 
</table>
<input type="hidden" name="CODIGO" id="CODIGO" />
<input type="hidden" name="txtCodigoCancela" id="txtCodigoCancela" />	
</fieldset>
