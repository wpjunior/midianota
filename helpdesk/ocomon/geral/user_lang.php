<?php   
        session_start();

	include ("../../includes/include_geral.inc.php");
	include ("../../includes/include_geral_II.inc.php");

// 	if ($_SESSION['s_allow_change_theme'] == 0){
// 		print "<script>mensagem('".TRANS('MSG_SORRY')."\\n".TRANS('MSG_ALTER_LANG_DISABLE_ADMIN')."'); history.back();</script>";
// 		exit;
// 	}

	print "<HTML>";
	print "<head>";
	print "</head>";
	print "<BODY bgcolor=".BODY_COLOR.">";

	$auth = new auth;
	$auth->testa_user($_SESSION['s_usuario'],$_SESSION['s_nivel'],$_SESSION['s_nivel_desc'],4);

	$sqlUserLang = "SELECT * FROM uprefs WHERE upref_uid = ".$_SESSION['s_uid']."";
	$execUserLang = mysql_query($sqlUserLang) or die (TRANS('MSG_ERR_RESCUE_INFO_THEME_USER'));
	$rowUL = mysql_fetch_array($execUserLang);
	$hasUL = mysql_num_rows($execUserLang);


	print "<BR><B>".TRANS('TTL_THEME').": &nbsp;</b><BR>";
	print "<form name='form1' method='post' action='".$_SERVER['PHP_SELF']."' >"; //onSubmit=\"return valida()\"
	print "<TABLE border='0' cellpadding='5' cellspacing='0'  width='60%' >";

	if (!isset($_POST['submit'])) {


		$files = array();
		$files = getDirFileNames('../../includes/languages/');
		print "<tr><td><b>".TRANS('OPT_LANG','ARQUIVO DE IDIOMA')."</b></td>";
		print "<td><select name='lang' id='idLang' class='select'>"; //<input type='text' name='lang' id='idLang' class='text' value='".$row['conf_language']."'></td>";
			//print "<option value=''><>";
			for ($i=0; $i<count($files); $i++){
				print "<option value='".$files[$i]."' ";
				if ($files[$i]==$rowUL['upref_lang'])
					print " selected";
				print ">".$files[$i]."</option>";
			}
		print "</select>";
		print "</td>";
		print "</tr>";
		//print "</tr><tr><td colspan='2'>&nbsp;</td></tr>";
		print "<tr>";
		print "<tr>";
		//print "<input type='hidden' name='marca' value='".$rowTema['tm_color_marca']."'>";
		//print "<input type='hidden' name='destaca' value='".$rowTema['tm_color_destaca']."'>";
		print "<td align='center'><input type='submit' name='submit' class='button' value='".TRANS('BT_LOAD','',0)."'></td>".
				"<td align='center'><input type='button' name='cancelar' class='button' value='".TRANS('BT_CANCEL')."' onClick=\"javascript:history.back();\"></td>";
		print "</tr>";

	} else
	if (isset($_POST['submit']) ) {
		//dump($_REQUEST); exit;

		if (!empty($hasUL)){
		//update
			$qry = "UPDATE uprefs SET upref_lang = '".$_POST['lang']."' WHERE upref_uid = ".$_SESSION['s_uid']."";
		} else {
		//insert
			$qry = "INSERT INTO uprefs (upref_uid, upref_lang) values (".$_SESSION['s_uid'].", '".$_POST['lang']."')";
		}
		
		$execQry = mysql_query($qry) or die ($qry);

		$_SESSION['s_language'] = $_POST['lang'];
		print "<script>mensagem('".TRANS('MSG_LANG_LOAD_SUCESS','sucesso',0)."'); window.open('../../index.php','_parent','');  </script>"; //?LOAD=ADMIN

	}


	print "<table>";
	print "</form>";


	?>
<script type="text/javascript">
<!--
	function valida(){

		var ok = validaForm('idLang','COMBO','<?php print TRANS('OPT_LANG'); ?>',1);

		return ok;
	}
-->
</script>
	<?php 

	print "</body>";
	print "</html>";
?>