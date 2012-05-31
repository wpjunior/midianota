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
<fieldset><legend>Notícias Inseridas</legend>
<?php
	// Conexao ao banco MySQL e consulta
	require_once("../conect.php");
	require_once("../../funcoes/util.php");

	//sql buscando as noticias do banco
	$query = ("SELECT codigo,titulo,texto,data FROM noticias ORDER BY data DESC");
	$sql = Paginacao($query,'frmNoticias','divnoticiaslista',10);
	if(mysql_num_rows($sql)>0){
?>
    <table width="100%">
        <tr bgcolor="#999999">
            <td width="32%" align="center">
                <b>Título</b>
			</td>
            <td width="45%" align="center">
                <b>Notícia</b>						
			</td>
            <td width="10%" align="center">
                <b>Data</b>						
			</td>
            <td align="center"></td>
			<td align="center"></td>
        </tr>
        <?php 
		$x = 0;
        while(list($codigo,$titulo,$texto,$data)=mysql_fetch_array($sql)){
            //pega somente 60 caracteres do texto original
            $textreduzido = substr($texto,0,60);
            //testa se tiver mais de 30 caracteres acrescenta reticencias a string
            if(strlen($textreduzido)>45){
                $textreduzido .= "...";
            }//fim if
        ?>
        <tr bgcolor="#FFFFFF">
            <td align="left"><?php echo $titulo;?></td>
            <td align="center"><?php echo $textreduzido;?></td>
            <td align="center"><?php echo DataPt($data);?></td>
            <td align="center"><input name="btVer" id="btLupa" value="" title="Ver Conteúdo completo" 
            	onclick="VisualizarNovaLinha('<?php echo $codigo;?>','tdnoticia<?php echo $x;?>',this,'inc/utilitarios/noticias_ver.ajax.php');" />
    			<input name="btExcluir" id="btX" value=" " class="botao" type="submit" 
				onclick="document.getElementById('hdCodNt').value = <?php echo $codigo;?>;return confirm('Deseja Excluir esta Notícia?')" />
			</td>
		</tr>
        <tr>
        	<td id="tdnoticia<?php echo $x;?>" colspan="5"></td>
        </tr>
        <?php 
			$x++;
        }//fim while
        ?>
        <input name="hdCodNt" id="hdCodNt" type="hidden" />
     </table>
</fieldset>
<?php
	}//fim if
?>
