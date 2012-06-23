<?php 
 
 $string=$_SESSION['autenticacao'];
 $cont=0; 
 $cont1 =0;
  for($cont=0;$cont<5;$cont++)
  {
   $aux = substr($string,$cont,1);
   for($cont1=0;$cont1<=9;$cont1++)
   {
     if($aux == $cont1)
	 {
	  print("<img src=\"img/nrosrandomicos/$cont1.jpg\" align=\"middle\">");
	 }
   } 
  } 
 
 ?>
 

  
 