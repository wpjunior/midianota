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
  require_once("../../conect.php");
  require_once("../../nocache.php");
  require_once("../../../funcoes/util.php");

  $nome=$_GET["txtNome"];
  $cnpj=$_GET["txtCNPJ"];
  $nro_dop=$_GET["txtNro"];
  $comp_mes=$_GET["cmbMes"];
  $comp_ano=$_GET["cmbAno"];
  $estado=$_GET["cmbEstado"];
  $data=$_GET["txtData"];
  $canceladop=$_GET["hdCancelaDop"];
  $pagina=$_GET["hdPagina"];
  
  
  //se foi cancelada alguma declaração da o updade no banco e da um alert se der algum erro
  if($canceladop){
  	mysql_query("UPDATE dop_des SET estado='C' WHERE codigo='$canceladop'");
  }//fim if cacela
  
  //faz um where de acordo com oque foi preenchido no from
  $sql_where=" ";//comeca a var do where como um espaço
  if($cnpj){
	$sql_where.=" AND orgaospublicos.cnpj='$cnpj'";
  }//fim if cnpj
  if($nro_dop){
  	$sql_where.=" AND dop_des.codigo='$nro_dop'";
  }//fim if nro
  if($comp_mes){
	$sql_where.=" AND MONTH(dop_des.competencia)='$comp_mes'";
  }//fim if mes
  if($comp_ano){
	$sql_where.=" AND YEAR(dop_des.competencia)='$comp_ano'";
  }//fim if ano
  if($estado){
	$sql_where.=" AND dop_des.estado='$estado'";
  }//fim if estado
  if($data){
	$sql_where.=" AND DATE_FORMAT(dop_des.data_gerado,'%d/%m/%Y')='$data'";
  }//fim if data
  ?>
  <table width="100%">
	  <tr>
		<td align="center">
			<fieldset><legend>Resultado</legend>
				<div>
				<?php
				/*$sql_where dinamico de acordo com o que foi preenchido no form*/
					//query com limitação de paginas
					$query = ("
						SELECT 
							dop_des.codigo, 
							orgaospublicos.razaosocial, 
							DATE_FORMAT(dop_des.data_gerado,'%d/%m/%Y'), 
							DATE_FORMAT(dop_des.competencia,'%d/%m/%Y'),
							dop_des.estado
						FROM 
							dop_des
						INNER JOIN 
							cadastro as orgaospublicos ON orgaospublicos.codigo = dop_des.codorgaopublico
						WHERE
							(orgaospublicos.nome LIKE '%$nome%' OR orgaospublicos.razaosocial LIKE '%$nome%')
							$sql_where 
						ORDER BY 
							dop_des.codigo DESC
					");
					$sql=Paginacao($query,'frmDop','spanDop',10,true);//true para usar os botoes separados
					if(mysql_num_rows($sql['sql'])>0){//se tem resultado, mostra a tabela
					echo $sql['botoes'];
						?>
						<table width="725px">
							<tr bgcolor="#999999">
								<td width="45px" align="center">cod</td>
								<td width="360px" align="center">Razão</td>
								<td width="60px" align="center">Estado</td>
								<td width="80px" align="center">Data Gerado</td>
								<td width="80px" align="center">Competencia</td>
								<td width="" align="center">Ações</td>
							</tr>
							<?php
								$cont = 0;
								while(list($codigo,$razao,$data_gerado, $competencia, $estado) = mysql_fetch_array($sql['sql'])){
								switch($estado){
									case "N": $estado_dop="Normal";break;
									case "C": $estado_dop="Cancelada";break;
									case "B": $estado_dop="Boleto";break;
									case "E": $estado_dop="Escriturada";break;
								}//fim switch
								if($estado=="C"){
									$cor='bgcolor="#FFAC84"';
								}else{
									$cor='bgcolor="#FFFFFF"';
								}//se estiver cancelada deixa a linha destacada
								?>
								<tr bgcolor="#FFFFFF">
									<td width="45px" <?php echo $cor; ?> align="right"><?php echo $codigo; ?></td>
									<td width="360px" <?php echo $cor; ?> align="left"><?php echo $razao;?></td>
									<td width="60px" <?php echo $cor; ?> align="center"><?php echo $estado_dop;?></td>
									<td width="80px" <?php echo $cor; ?> align="center"><?php echo $data_gerado;?></td>
									<td width="80px" <?php echo $cor; ?> align="center"><?php echo $competencia;?></td>
									<td>
									<input name="btVizualizar" id="btLupa" title="Vizualizar Declaração" type="button" value="" class="botao" 
									onClick="VisualizarNovaLinha(
									'<?php echo $codigo;?>',
									'<?php echo"tdDop".$cont;?>',
									this,'inc/declaracoes/dop/declarar_vizualizar.ajax.php')" />
									<?php if($estado!="C"){//if mostra o botao cancelar se a declaração nao esta cancelada ?>
									<input name="btCancelar" id="btX" title="Cancelar Declaração" type="button" value="" class="botao" 
									onClick="document.getElementById('hdPrimeiro').value=1; dop.cancelarDeclaracao('<?php echo $codigo; ?>','<?php echo $razao; ?>');" />
									<?php }//fim if mostra o botao cancelar se ainda nao estiver cancelada ?>
									</td>
								</tr>
								<tr>
									<td colspan="6" id="tdDop<?php echo $cont; ?>"></td>
								</tr>
							<?php
							$cont++;
						}//fim while
						?>
						</table>
						<?php
					}else{
						echo "<b>Não há declarações de Orgãos Públicos com a pesquisa solicitada</b>";
					}//fim if
					?>
				</div>
			</fieldset>
		</td>
	  </tr>	
  </table>
