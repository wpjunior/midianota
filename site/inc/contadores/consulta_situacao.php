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
	$cnpj = $_POST["txtCNPJ"];
	
	$resp = codcargo('responsavel');
	$diretor = codcargo('diretor');

	$campo=tipoPessoa($cnpj);
	
	if(!$campo){//se digitou o campo em um formato incorreto
		Mensagem("Este CNPJ não está cadastrado no sistema");
		RedirecionaPost($_SERVER['PHP_SELF']."?txtMenu=".$_POST['txtMenu']);
		//volta para a pagina de consulta com o post txtMenu necessario
	}else{
		$sql=mysql_query("
				SELECT 
					cadastro.codigo,
					cadastro.nome, 
					cadastro.razaosocial, 
					cadastro.logradouro,
					cadastro.bairro,
					cadastro.numero,
					cadastro.municipio, 
					cadastro.uf, 
					cadastro.cep,
					cadastro.fonecomercial, 
					cadastro.fonecelular, 
					cadastro.email, 
					cadastro.estado
				FROM 
					cadastro 
				WHERE 
					cadastro.$campo = '$cnpj'
		");
	
		
		//se verifica se tem o cnpj no banco
		if(mysql_num_rows($sql) == 0){
			Mensagem("Este CNPJ não está cadastrado no sistema");
			RedirecionaPost($_SERVER['PHP_SELF']."?txtMenu=".$_POST['txtMenu']);
		}else{//fim if se existe o cnpj no banco
			list($codigo, $nome, $razaosocial, $logradouro, $bairro, $numero, $municipio, $uf, $cep, $telefone, $telefone2, $email, $estado) = mysql_fetch_array($sql);
			switch($estado){
				case "NL": $estado = '<b>Aguarde a liberação da prefeitura</b>'; break;
				case "A": $estado = '<font color="#006600"><b>Cadastro liberado</b></font>'; break;
				case "I": $estado = '<font color="#FF0000"><b>Contador inativo, entre em contato com a prefeitura.</b></font>'; break;
			}//fim switch estado
			
		//seleciona os responsaveis, socios e gerentes e mostra apenas o primeiro de cada
		$resp = codcargo('responsavel');
		$sql_resp = mysql_query("SELECT nome, cpf FROM cadastro_resp WHERE codemissor = '$codigo' AND codcargo = '$resp'");
			
		$socio = codcargo('socio');
		$sql_socio = mysql_query("SELECT nome, cpf FROM cadastro_resp WHERE codemissor = '$codigo' AND codcargo = '$socio'");
			?>
	<table width="100%" border="0" cellpadding="0" cellspacing="1">
		<tr>
			<td width="5%" height="5" bgcolor="#FFFFFF"></td>
			<td width="30%" align="center" bgcolor="#FFFFFF" rowspan="3">Consulta ao Cadastro de Contador </td>
			<td width="30%" bgcolor="#FFFFFF"></td>
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
			
						<table width="98%" height="100%" border="0" bgcolor="#CCCCCC" align="center" cellpadding="1" cellspacing="2">
							<tr>
								<td colspan="4" height="5"></td>
							</tr>
							<tr>
								<td width="18%" align="left" >Nome Completo:</td>
								<td colspan="3" bgcolor="#FFFFFF" align="left" valign="middle"><?php echo $nome; ?></td>
							</tr>
							<tr>
								<td align="left" >Razão Social:</td>
								<td align="left" bgcolor="#FFFFFF" colspan="3" valign="middle"><?php echo $razaosocial; ?></td>
							</tr>
							<tr>
								<td align="left" >CNPJ:</td>
								<td align="left" bgcolor="#FFFFFF" colspan="3" valign="middle"><?php echo $cnpj; ?></td>
							</tr>
							<tr>
								<td align="left" >Insc Municipal:</td>
								<td align="left" bgcolor="#FFFFFF" colspan="3" valign="middle"><?php echo verificaCampo($inscrmunic); ?></td>
							</tr>
							<tr>
								<td align="left" >Email:</td>
								<td align="left" bgcolor="#FFFFFF" colspan="3" valign="middle"><?php echo $email; ?></td>
							</tr>
							<tr>
								<td align="left" >Situacão:</td>
								<td align="left" bgcolor="#FFFFFF" colspan="3" valign="middle"><?php echo $estado; ?></td>
							</tr>
							<tr>
								<td align="left" >Endereço:</td>
								<td align="left" bgcolor="#FFFFFF" colspan="3" valign="middle"><?php echo "$logradouro, n° $numero"; ?></td>
							</tr>
							<tr>
								<td align="left" >Bairro:</td>
								<td align="left" bgcolor="#FFFFFF" valign="middle"><?php echo $bairro; ?></td>
								<td align="left" width="20%">CEP:</td>
								<td align="left" width="20%" bgcolor="#FFFFFF" valign="middle"><?php echo $cep; ?></td>
							</tr>
							<tr>
								<td align="left" >Municipio:</td>
								<td align="left" bgcolor="#FFFFFF" valign="middle"><?php echo $municipio; ?></td>
								<td width="16%" align="left" >Estado (UF):</td>
								<td align="left" bgcolor="#FFFFFF" width="15%" valign="middle">&nbsp;<?php echo $uf; ?></td>
							</tr>
							<tr>
								<td align="left" >Telefone:</td>
								<td align="left" bgcolor="#FFFFFF" valign="middle"><?php echo $telefone; ?></td>
								<td align="left" >Telefone Adicional:</td>
								<td align="left" bgcolor="#FFFFFF" valign="middle">&nbsp;<?php echo verificaCampo($telefone2); ?></td>
							</tr>
                        <tr>
                            <td width="100%" colspan="4" height="3"><hr /></td>
                        </tr>
						<?php
						while(list($nome_resp, $cpf_resp)=mysql_fetch_array($sql_resp)){
						?>
                        <tr>
                            <td align="left" >Responsável:</td>
                            <td align="left" bgcolor="#FFFFFF" valign="middle"><?php echo verificaCampo($nome_resp); ?></td>
                            <td align="left" width="20%">CPF Responsável:</td>
                            <td align="left" width="20%" bgcolor="#FFFFFF" valign="middle"><?php echo verificaCampo($cpf_resp); ?></td>
                        </tr>
						<?php
						}//fim while responsaveis
						
						while(list($nome_socio, $cpf_socio)=mysql_fetch_array($sql_socio)){
						?>
                        <tr>
                            <td align="left" >Sócio:</td>
                            <td align="left" bgcolor="#FFFFFF" valign="middle"><?php echo verificaCampo($nome_socio); ?></td>
                            <td align="left" width="20%">CPF Sócio:</td>
                            <td align="left" width="20%" bgcolor="#FFFFFF" valign="middle"><?php echo verificaCampo($cpf_socio); ?></td>
                        </tr>
						<?php
						}//fim while socios
						?>
                        <tr>
                            <td  height="25" colspan="4"><input type="button" name="btVoltar" value="Voltar" class="botao" 
                                onClick="window.location='contadores.php'"></td>
                        </tr>
						</table>
			</td>	
		</tr>
		<tr>
			<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
		</tr>
	</table> 
		<?php
		}//fim else se nao existe o cnpj ou senha incorreta.
	}//se digitou em um formato incorreto

?>	