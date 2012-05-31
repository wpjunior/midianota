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

if($_POST['hdCodTomador']){
	
	$cod_tomador = $_POST['hdCodTomador'];
	$tomadorCNPJCPF = $_POST['hdTomadorCNPJCPF'];
	$tomadorNome = $_POST['txtNome'];
	$tomadorEmail = $_POST['txtEmail'];
	
	$sql_test = mysql_query("SELECT nome, logradouro FROM cadastro WHERE cnpj='$txtCNPJ' OR cpf='$txtCNPJ'");
	list($nome_test,$endereco_test) = mysql_fetch_array($sql_test);
	/*if(!$endereco_test){
		mysql_query("UPDATE cadastro SET nome='$tomadorNome', email='$tomadorEmail' WHERE codigo='$cod_tomador'");
	}*/
	if(!mysql_num_rows($sql_test)){
		Mensagem("O tomador precisa estar cadastrado no sistema!");
	}else{
		if (strlen($tomadorCNPJCPF)==14)
			$tipo_tomador = "PF";
		if (strlen($tomadorCNPJCPF)==18)
			$tipo_tomador = "PJ";
		$sql_regras = mysql_query("
			SELECT 
				credito, 
				valor 
			FROM 
				nfe_creditos 
			WHERE 
				tipopessoa = '$tipo_tomador' AND 
				issretido = 'N' AND 
				estado = 'A' 
			ORDER BY valor
		");
		$contr=0;
		while(list($regra_credito,$regra_valor)=mysql_fetch_array($sql_regras)) {
			$regra_cred[$contr] = $regra_credito;
			$regra_val[$contr] = $regra_valor;
			$contr++;
		}
		
		$total_credito = 0;
		$num_notas = $_POST['hdUltima'];
		for($c=1;$c<=$num_notas;$c++){
			if($_POST['txtPrestador'.$c]!=""&&$_POST['txtValor'.$c]){
				$num_guia = $_POST['txtCodigoGuia'.$c];
				$data_emissao = DataMysql($_POST['txtDataEmissao'.$c]);
				$prestador = $_POST['txtPrestador'.$c];
				$valor = MoedaToDec($_POST['txtValor'.$c]);
				$codtipo = codtipo("prestador");
				$sql_emissor = mysql_query("SELECT codigo FROM cadastro WHERE (cnpj='$prestador' OR cpf='$prestador') AND codtipo = '$codtipo'");
				list($cod_emissor)=mysql_fetch_array($sql_emissor);
	
				$sql_nota = mysql_query("
					SELECT n.codigo, n.codservico, s.aliquota, s.aliquotair, n.basedecalculo
					FROM des_servicos as n 
					INNER JOIN des as d ON n.coddes = d.codigo
					INNER JOIN cadastro as e ON e.codigo = d.codcadastro
					INNER JOIN servicos as s ON s.codigo = n.codservico
					WHERE 
						(e.cnpj='$prestador' OR	e.cpf = '$prestador') AND
						n.tomador_cnpjcpf = '$tomadorCNPJCPF' AND
						n.nota_nro = '$num_guia'
				");
				if (!mysql_num_rows($sql_nota)) {
					Mensagem("Nota $num_guia do prestador $prestador não encontrada! verifique os dados ou entre em contato com o prestador.");
					/*Redireciona("../../site/des.php");
					exit;*/
				}else{
				
					list($cod_nota,$cod_serv,$aliq_serv,$aliqir_serv,$valor_nota)=mysql_fetch_array($sql_nota);
					//echo mysql_error();
					
					if (floatval($valor_nota)!=floatval($valor)) {
						Mensagem("Valor diferente da nota original! verifique os dados ou entre em contato com o prestador.");
						/*Redireciona("../../site/des.php");
						exit;*/			
					}else{
						$regra_aplicada = 0;
						$imposto = $valor * ($aliq_serv/100);
						for ($cr=0;$cr<count($regra_cred);$cr++) {
							if ($imposto>$regra_val[$cr]) {
								$regra_aplicada = $cr;
							}
						}
						$credito_gerado = $imposto * ($regra_cred[$regra_aplicada] / 100);
						$total_credito += $credito_gerado;
						
						mysql_query("
							INSERT INTO des_tomadores_notas 
							SET cod_tomador='$cod_tomador', 
								nota='$num_guia', 
								dataemissao='$data_emissao', 
								cod_emissor='$cod_emissor', 
								valor='$valor', 
								credito='$credito_gerado'
						");
						Mensagem("Notas declaradas! credito: R$ ".DecToMoeda($total_credito));
					}//fim else verifica valor da nota original
				}//fim else verifica notas de prestadores
			}//fim if campos preenchidos
		}//fim for numero de notas
	}
}//fim if POST
//Redireciona("../../site/des.php");
?>