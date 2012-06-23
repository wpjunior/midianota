<?php
  session_start();	

  include("conect.php"); 
  include("../funcoes/util.php");
  include("../funcoes/funcao_logs.php"); 
  
  print("<a href=index.php target=_parent><img src=../img/topos/$CONF_TOPO></a>");
  
?>