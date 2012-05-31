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
		include("../conect.php");
		include("../../funcoes/util.php");
		
		$CaracteresAceitos = 'ABCDEFGHIJKLMNOPQRXTUVWXYZ';
		for($i=0; $i < 4; $i++) 
			{
				$position=mt_rand(0, 25);
				$codverificacao .= substr($CaracteresAceitos, $position, 1);
			} 
		$codverificacao.="-";	
		for($i=0; $i < 4; $i++) 
			{
				$position=mt_rand(0, 25);
				$codverificacao .= substr($CaracteresAceitos, $position, 1);
			} 
		echo $codverificacao;	
		$cod_emissor = $_POST['hdCodEmissor'];
		$dataCompetencia = DataMysql("01/".$_POST['cmbMes']."/".$_POST['cmbAno']);
		$dataGerado = DataMysql($_POST['hdDataAtual']);
		$num_servicos = $_POST['hdServicos'];
		$total = 0;
		for($c=1;$c<=$num_servicos;$c++){
			$tomadorCnpjCpf[$c] = $_POST['txtTomadorCnpjCpf'.$c];
			$baseCalculo[$c] = MoedaToDec($_POST['txtBaseCalculo'.$c]);
			$total = $total + $baseCalculo[$c];
			$impostoServico[$c] = $_POST['txtImposto'.$c];
			$temp = explode('|',$_POST['cmbCodServico'.$c]);
			$codigoServico[$c] = $temp[1];
			$nroNota[$c] = $_POST['txtNroDoc'.$c];
		}
		
		$multaJuros = MoedaToDec($_POST['txtMultaJuros']);
		$totalPagar = MoedaToDec($_POST['txtTotalPagar']);
		
		mysql_query("INSERT INTO simples_des 
					 SET codemissor='$cod_emissor', 
						 competencia='$dataCompetencia', 
						 data_gerado='$dataGerado', 
						 total='$total', 
						 tomador='s',
						 codverificacao='$codverificacao'");
		$sql_des = mysql_query("SELECT MAX(codigo) 
						  				 FROM simples_des");
		list($codsimples_des)=mysql_fetch_array($sql_des);
		
		for($c=1;$c<=$num_servicos;$c++){
			if($baseCalculo[$c]!=""&&$codigoServico[$c]!=""){
				mysql_query("INSERT INTO simples_des_servicos
							 SET codsimples_des='$codsimples_des',
								 codservico='".$codigoServico[$c]."',
								 basedecalculo='".$baseCalculo[$c]."',
								 tomador_cnpjcpf='".$tomadorCnpjCpf[$c]."',
								 nota_nro='".$nroNota[$c]."'");
			}
		}
		
		require("inconsistencias/sequenciamento_des.php");
		require("inconsistencias/duplicacoes_des.php");	
		
		
		$codsimples_des = base64_encode($codsimples_des);
		NovaJanela("../../reports/simples_des_comprovante.php?COD=$codsimples_des");
		Redireciona('../../principal.php');
		

?>

