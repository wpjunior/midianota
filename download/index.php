<?php

$file = $_GET['file']; 
                       
foreach($_GET as $link => $nada);
$file = "..".str_replace("_",".",$link);
if(strpos($file,".csv")===false){
	echo "Erro na importação do arquivo!";
}else{
	$nome_arquivo=array_reverse(explode("/",$file));
	$nome_arquivo=$nome_arquivo[0];
	header("Content-Type: application/save");
	header("Content-Length:".filesize($file)); 
	header('Content-Disposition: attachment; filename="' . $nome_arquivo . '"'); 
	header("Content-Transfer-Encoding: binary");
	header('Expires: 0'); 
	header('Pragma: no-cache'); 
	
	$fp = fopen("$file", "r"); 
	fpassthru($fp); 
	fclose($fp); 
}

?>
