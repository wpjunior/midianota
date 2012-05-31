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
<fieldset>
<?php
	//conecta aos principais arquivos
	require_once("../conect.php");
	require_once("../../funcoes/util.php");
	
	//recebe o codigo do registro a ser auditado
	$codigo = $_GET['hdCodSolicitacao'];
	
	$sql_info = mysql_query("
			SELECT
				doc_des.codigo,
				doc_des.codverificacao,
				doc_des.total,
				doc_des.estado,
				DATE_FORMAT(doc_des.competencia,'%d/%m/%Y'),
				DATE_FORMAT(doc_des.data,'%d/%m/%Y'),
				doc_des_contas.contaoficial,
				doc_des_contas.contacontabil,
				doc_des_contas.titulo,
				doc_des_contas.saldo_mesanterior,
				doc_des_contas.saldo_mesatual,
				doc_des_contas.receita,
				doc_des_contas.aliquota,
				doc_des_contas.iss,
				operadoras_creditos.nome
			FROM
				doc_des
			INNER JOIN
				doc_des_contas ON doc_des_contas.coddoc_des = doc_des.codigo
			INNER JOIN	
				operadoras_creditos ON doc_des.codopr_credito = operadoras_creditos.codigo
			WHERE
				doc_des.codigo = '$codigo'
	");
		list($codigo,$codverificacao,$total,$estado,$competencia,$data,$contaoficial,$contacontabil,$titulo,$saldo_mesanterior,$saldo_mesatual,$receita,$aliquota,$iss,$nomeporextenso) = mysql_fetch_array($sql_info);
		
		$nome = ResumeString($nomeporextenso,27);
		
		switch($estado){
			case "B": $estado = "Boleto";      break;
			case "N": $estado = "Normal";      break;
			case "C": $estado = "Cancelada";   break;
			case "E": $estado = "Escriturada"; break;		
		}
		
?>
<table width="100%">
	<tr>
    	<td align="left">Titulo: </td>
        <td align="left" colspan="3"><?php echo $titulo;?></td>
    </tr>
    <tr>
    	<td align="left">Cod. verificação</td>
        <td align="left" colspan="3"><?php echo $codverificacao;?></td>
    </tr>
	<tr>
    	<td align="left">Conta oficial</td>
        <td align="left"><?php echo $contaoficial;?></td>
        <td align="left">Conta contábil</td>
        <td align="left"><?php echo $contacontabil;?></td>
    </tr>
    <tr>
    	<td align="left">Saldo mês anterior</td>
        <td align="left"><?php echo "R$ ".DecToMoeda($saldo_mesanterior);?></td>
        <td align="left">Saldo mês atual</td>
        <td align="left"><?php echo "R$ ".DecToMoeda($saldo_mesatual);?></td>
    </tr>
    <tr>
    	<td align="left">Competencia:</td>
        <td align="left" colspan="3"><?php echo $competencia;?></td>
    </tr>
    <tr>
    	<td align="left">Data de geração:</td>
        <td align="left" colspan="3"><?php echo $data;?></td>
    </tr>
    <tr>
    	<td align="left">Estado: </td>
        <td align="left"><?php echo $estado;?></td>
    </tr>
</table>
</fieldset>
<fieldset><legend>Nota</legend>
	<table width="100%">
    	<tr bgcolor="#999999">
        	<td align="center">Número</td>
            <td align="center">Valor</td>
            <td align="center">Emissor</td>
        </tr>
        <tr bgcolor="#FFFFFF">
        	<td align="center"><?php echo $codigo;?></td>
            <td align="center"><?php echo $total;?></td>
            <td align="left" title="<?php echo $nomeporextenso;?>"><?php echo $nome;?></td>
        </tr>
    </table>
</fieldset>
<table width="100%">
    <tr>
        <td>
        	<input name="btVoltar" type="button" value="Voltar" class="botao" 
        	onclick="acessoAjax('inc/operadorascreditos/auditoria_lista.ajax.php','frmAudDoc','divauditoriadoc')" />
        </td>
    </tr>
</table>