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
<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
	<tr>
		<td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
		<td background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;Detalhes </td>
		<td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a onclick="document.getElementById('divDetalhes').style.display='none'"><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
	</tr>
	<tr>
		<td width="18" background="img/form/lateralesq.jpg"></td>
		<td align="center">
			<?php
				require_once("../conect.php");
				require_once("../../funcoes/util.php");
				require_once("../nocache.php");
				
				//Variavel vinda do arquivo liberar_lista.ajax.php
				$codigo = $_GET['cod'];
				
				$sql_detalhes = mysql_query("
					SELECT 
						codigo,
						codtipo,
						codtipodeclaracao,
						nome,
						razaosocial,
						cnpj,
						cpf,
						inscrmunicipal,
						logradouro,
						numero,
						complemento,
						bairro,
						cep,
						municipio,
						uf,
						email,
						fonecomercial,
						fonecelular
					FROM 
						cadastro
					WHERE
						codigo = '$codigo'
				");
				if(mysql_num_rows($sql_detalhes)){
					$cadastro = mysql_fetch_array($sql_detalhes);
					
					//Pega o nome por exetenso do tipo da tabela tipo
					$sql_tipo = mysql_query("SELECT nome FROM tipo WHERE codigo = '{$cadastro['codtipo']}'");
						$tipo = mysql_fetch_array($sql_tipo);
				?>
					<table width="100%" cellpadding="5" style="border:medium; border-bottom-color:#000000;">
						<tr bgcolor="#FFFFFF">
							<td><b>Nome:</b> </td>
							<td colspan="5"><?php echo $cadastro['nome'];?></td>
						</tr>
						<tr bgcolor="#FFFFFF">
							<td><b>Razão Social:</b></td>
							<td colspan="5"><?php echo $cadastro['razaosocial'];?></td>
						</tr>
						<tr bgcolor="#FFFFFF">
							<td><b>Tipo:</b></td>
							<td><?php echo $tipo['nome'];?></td>
							<td><b>CNPJ/CPF:</b></td>
							<td colspan="3"><?php echo $cadastro['cnpj'].$cadastro['cpf'];?></td>
						</tr>
						<tr bgcolor="#FFFFFF">
							<td><b>Inscr. Munic:</b></td>
							<td colspan="5"><?php echo verificacampo($cadastro['inscrmunicipal']);?></td>
						</tr>
						<tr bgcolor="#FFFFFF">
							<td><b>Logradouro:</b></td>
							<td colspan="5"><?php echo $cadastro['logradouro'];?></td>
						</tr>
						<tr bgcolor="#FFFFFF">
							<td><b>Número: </b></td>
							<td><?php echo $cadastro['numero'];?></td>
							<td><b>Complemento: </b></td>
							<td><?php echo verificacampo($cadastro['complemento']);?></td>
						</tr>
						<tr bgcolor="#FFFFFF">
							<td><b>Bairro:</b></td>
							<td><?php echo $cadastro['bairro'];?></td>
							<td><b>CEP:</b></td>
							<td colspan="3"><?php echo $cadastro['cep'];?></td>
						</tr>
						<tr bgcolor="#FFFFFF">
							<td><b>Municipio:</b></td>
							<td><?php echo $cadastro['municipio'];?></td>
							<td><b>UF:</b></td>
							<td colspan="3"><?php echo $cadastro['uf'];?></td>
						</tr>
						<tr bgcolor="#FFFFFF">
							<td><b>Email:</b></td>
							<td colspan="5"><?php echo $cadastro['email'];?></td>
						</tr>
						<tr bgcolor="#FFFFFF">
							<td><b>Fone:</b></td>
							<td><?php echo $cadastro['fonecomercial'];?></td>
							<td><b>Celular:</b></td>
							<td colspan="3"><?php echo verificacampo($cadastro['fonecelular']);?></td>
						</tr>
						<tr bgcolor="#FFFFFF">
							<td align="center">
								<input name="btAtivar" type="button" value="Ativar" class="botao" 
								onclick="ativarCadastro('<?php echo $codigo;?>','divlistanfe');" />
							</td>
							<td align="center">
								<input name="btRemover" type="button" value="Remover pedido*" class="botao" 
								onclick="removerCadastro('<?php echo $codigo;?>','divlistanfe');" />
							</td>
							<td colspan="4" align="right"><font color="#FF0000">*</font>Removerá o cadastro</td>
						</tr>
					</table>
				<?php
				}else{
					echo "<b>Não foram encontrados detalhes sobre este cadastro!<b>";
				}
			?>
		</td>
		<td width="19" background="img/form/lateraldir.jpg"></td>
	</tr>
	<tr>
		<td align="left" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantoesq.jpg" /></td>
		<td background="img/form/rodape_fundo.jpg"></td>
		<td align="right" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantodir.jpg" /></td>
	</tr>
</table>
