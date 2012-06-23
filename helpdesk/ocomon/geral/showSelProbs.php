<?php 
        session_start();

	include ("../../includes/include_geral.inc.php");
	include ("../../includes/include_geral_II.inc.php");

	//print "<HTML>";
	//print "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'/>";
	$auth = new auth;
	$auth->testa_user_hidden($_SESSION['s_usuario'],$_SESSION['s_nivel'],$_SESSION['s_nivel_desc'],4);


	##A DIV "divProblema" DEVE SER UTILIZADA PARA A EXIBICAO DAS CATEGORIAS DE PROBLEMAS
	//------------------------------------------------------------- INICIO ALTERACAO --------------------------------------------------------------
	//print "<SELECT class='select' name='problema' id='idProblema' onChange=\"ajaxFunction('divProblema', 'showProbs.php', 'idLoad', 'prob=idProblema', 'area_cod=idArea')\">";
	
	if (isset($_GET['pathAdmin'])) { //se o script estiver sendo c
		print "<input type='hidden' name='pathAdmin' id='idPathAdmin' value='fromPathAdmin'>";
		print "<SELECT class='select' name='problema' id='idProblema' onChange=\"ajaxFunction('divProblema', '../../ocomon/geral/showProbs.php', 'idLoad', 'prob=idProblema', 'area_cod=idArea', 'pathAdmin=idPathAdmin'); ajaxFunction('divInformacaoProblema', '../../ocomon/geral/showInformacaoProb.php', 'idLoad', 'prob=idProblema', 'area_cod=idArea'); ajaxFunction('divSla', 'sla_standalone.php', 'idLoad', 'numero=idSlaNumero', 'popup=idSlaNumero', 'SCHEDULED=idScheduled', 'new_prob=idProblema'); habilitarBancoSolucao();\">";
	} else {
		print "<SELECT class='select' name='problema' id='idProblema' onChange=\"ajaxFunction('divProblema', 'showProbs.php', 'idLoad', 'prob=idProblema', 'area_cod=idArea'); ajaxFunction('divInformacaoProblema', 'showInformacaoProb.php', 'idLoad', 'prob=idProblema', 'area_cod=idArea'); ajaxFunction('divSla', 'sla_standalone.php', 'idLoad', 'numero=idSlaNumero', 'popup=idSlaNumero', 'SCHEDULED=idScheduled', 'new_prob=idProblema'); habilitarBancoSolucao();\">";//'SCHEDULED=idScheduled', 'new_prob=idProblema'
	}
	//------------------------------------------------------------- FIM ALTERACAO --------------------------------------------------------------
	$query = "";
	if(@$_GET['area_habilitada']=='sim'){
		if($_GET['area_cod']=="" || $_GET['area_cod']==-1){
			print "<option value='-1'>".TRANS('OCO_SEL_AREA')."</option>";
		}else{
			$query = "
                SELECT * 
                FROM problemas 
                WHERE 
                	prob_area = ".$_GET['area_cod']." OR 
                	prob_area IS NULL OR 
                	prob_area = -1
                GROUP BY problema 
                ORDER BY problema
                ";
			$exec_prob = mysql_query($query);
			print "<option value='-1'>".TRANS('OCO_SEL_PROB')."</option>";
			while ($row_prob = mysql_fetch_array($exec_prob)) {
				print "<option value=".$row_prob['prob_id']."";
				if ($row_prob['prob_id'] == $_GET['prob']) {
					print " selected";
				}
			print " >".$row_prob['problema']." </option>";
			}
		}
	} else {
		$query = "
                SELECT * 
                FROM problemas
                GROUP BY problema 
                ORDER BY problema
                ";
		$exec_prob = mysql_query($query);
		print "<option value='-1'>".TRANS('OCO_SEL_PROB')."</option>";
		while ($row_prob = mysql_fetch_array($exec_prob)) {
			print "<option value=".$row_prob['prob_id']."";
				if ($row_prob['prob_id'] == @$_GET['prob']) {
					print " selected";
				}
			print " >".$row_prob['problema']." </option>";
		}
	}
	print "</select>";
?>
