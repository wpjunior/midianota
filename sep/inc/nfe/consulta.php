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



<script>
  function CancelaNota(codnota,msg)
  {	
	if(confirm(msg)){
		document.getElementById('hdPrimeiro').value=1; //mantem a paginacao na mesma pagina
		document.getElementById('txtCodigoCancela').value=codnota;
		acessoAjax('inc/nfe/pesquisar_resultado.ajax.php','frmNfe','divResultado');
		alert('Nota cancelada!');
	}
  }			
</script>

<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
	<tr>
		<td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
		<td width="600" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;NFe - Pesquisa </td>
		<td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
	</tr>
	<tr>
		<td width="18" background="img/form/lateralesq.jpg"></td>
		<td align="center">
			<form method="post" name="frmNfe" id="frmNfe" onsubmit="return false">
				<input type="hidden" name="include" id="include" value="<?php echo $_POST["include"]; ?>" />
				<fieldset style="width:800px">
				<legend>Pesquisar Nota</legend>
				<table width="100%" border="0" cellspacing="2" cellpadding="2">
					<tr>
						<td align="left" width="30%">Número da Nota</td>
						<td align="left" width="70%">
							<input name="txtNumeroNota" type="text" size="10" class="texto" />
						</td>
					</tr>
					<tr>
						<td align="left">Código de Verificação</td>
						<td align="left">
							<input name="txtCodigoVerificacao" type="text" size="10" class="texto" style="text-transform:uppercase;" />
						</td>
					</tr>
					<tr>
						<td align="left">Prestador - CNPJ/CPF</td>
						<td align="left">
							<input name="txtCNPJPrestador" id="txtCNPJPrestador" maxlength="18" type="text" size="20" class="texto" />
						</td>
					</tr>
					<tr>
						<td align="left">Tomador - CNPJ/CPF</td>
						<td align="left">
							<input name="txtCNPJ" id="txtCNPJ" type="text" size="20" class="texto" maxlength="18" />
						</td>
					</tr>
					<tr>
						<td align="left" colspan="2">
							<input name="btPesquisar" type="submit" value="Pesquisar" class="botao" onclick="
							acessoAjax('inc/nfe/pesquisar_resultado.ajax.php','frmNfe','divResultado')">
						</td>
					</tr>
				</table>
				</fieldset>
				<div id="divResultado"></div>
			</form>
		</td>
		<td width="19" background="img/form/lateraldir.jpg"></td>
	</tr>
	<tr>
		<td align="left" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantoesq.jpg" /></td>
		<td background="img/form/rodape_fundo.jpg"></td>
		<td align="right" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantodir.jpg" /></td>
	</tr>
</table>
