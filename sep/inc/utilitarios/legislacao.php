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
//recebimento das variaveis do form
$titulo  = $_POST["txtTitulo"];
$data    = $_POST["txtData"];
$texto   = $_POST["txtTexto"];

//testa se o botao tem valor
if($_POST["btInserir"] == "Inserir"){
	//testa se todos os campos foram preenchidos || inc/utilitarios/legislacao/<?php echo $BANCO."/".$arquivo;
	if(($titulo) && ($data) && ($_FILES["txtArq"]) && ($texto)){
		
		//Cria o diretorio para armazenar os arquivos pdf separados por nome da prefeitura
		if(!is_dir("legislacao/$BANCO")){
			mkdir("legislacao/$BANCO");
		}
				
		//funcao que faz o upload e testa se o arquivo realmente e um pdf e se tem tamanho menor que 2mb
		$arquivo = UploadGenerico("legislacao/$BANCO/","txtArq","pdf");
		
		//inseri no banco os dados submetidos
		if($arquivo){
			//Cria uma copia do arquivo pdf na pasta do issdigital
			if(!is_dir("../legislacao/$BANCO")){
				mkdir("../legislacao/$BANCO");
			}
					
			$file = "legislacao/$BANCO/$arquivo";
			$newfile = "../legislacao/$BANCO/$arquivo";
			
			if(file_exists($file)){
				copy($file, $newfile);
			}
				
			//muda a data de 00/00/0000 para 0000-00-00
			$data = DataMysql($data);
			
			switch($_POST['hdTipo']){
				case 'nfe': 
					$tipo = 'N';
					break;
				case 'iss':
					$tipo = 'I';
					break;
				default:
					$tipo = 'T';
					break;
			}
			
			$sql = mysql_query("
				INSERT INTO legislacao SET 
					titulo = '$titulo', 
					data = '$data',
					texto = '$texto',
					arquivo = '$arquivo',
					tipo = '$tipo'
			");
			add_logs('Inseriu uma Lei');
			Mensagem("Lei inserida!");
		}//fim if
	}else{
		Mensagem("Preencher todos os campos para realizar a inserção");	
	}//fim else   
}//fim if

if($_POST["btDeletar"] == "Excluir"){
	$codlei = $_POST["hdCodLei"];
	$sql_busca_arquivo = mysql_query("SELECT arquivo FROM legislacao WHERE codigo = '$codlei'");
	list($exc_arquivo) = mysql_fetch_array($sql_busca_arquivo);
	excluiArquivo("legislacao/$BANCO",$exc_arquivo);
	excluiArquivo("../legislacao/$BANCO",$exc_arquivo);
	mysql_query("DELETE FROM legislacao WHERE codigo = '$codlei'"); 
	Mensagem("Lei excluida!");
}//fim if


?>
<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
  <tr>
    <td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
    <td width="700" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;Utilit&aacute;rios - Legisla&ccedil;&atilde;o</td>  
    <td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
  </tr>
  <tr>
    <td width="18" background="img/form/lateralesq.jpg"></td>
    <td align="left">
		<form method="post" id="frmLegislacao" enctype="multipart/form-data">
			<input type="hidden" name="include" id="include" value="<?php echo $_POST["include"];?>" />
			<input type="hidden" name="hdTipo" value="nfe" />
			<fieldset><legend>Inserção de Lei</legend>
				<table border="0" cellspacing="2" cellpadding="2" width="95%">
					<tr>
						<td width="12%" align="left">Titulo</td>
						<td width="88%" align="left"><input type="text" name="txtTitulo" id="txtTitulo" size="50" class="texto" /></td>
					</tr>  
					<tr>
						<td align="left">Data</td>
						<td align="left"><input name="txtData" id="txtData" type="text" class="texto" onKeyPress="formataData(this)" size="12" maxlength="10" /></td>
					</tr>  
					<tr><br /><br />
						<td align="left">Documento</td>
						<td align="left">
                        	<input type="file" name="txtArq" id="txtArq" size="31" class="texto"/>
                            	<font color="#FF0000">
                                	<br />O arquivo PDF não poderá estar nomeado com acentos , ç e caracteres especias.
                                </font>
                        </td>
					</tr>     
					<tr>
						<td align="left" colspan="2">Descrição:</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td align="left"><textarea name="txtTexto" id="txtTexto" cols="49" rows="6" class="texto"></textarea></td>
					</tr>
					<tr>       
						<td align="left"><input type="submit" name="btInserir" class="botao" value="Inserir" onclick="return ValidaFormulario('txtTitulo|txtData|txtArq|txtTexto')" /></td>
                        <td align="left">
                        	<input type="button" name="btVer" class="botao" value="Ver todas as leis" 
                            onclick="acessoAjax('inc/utilitarios/legislacao_ver.ajax.php','frmLegislacao','divLegislacao');" />
                        </td>
					</tr>
				</table>
            </fieldset>
            <div id="divLegislacao"></div>
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
