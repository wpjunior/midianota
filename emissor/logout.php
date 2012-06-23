<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php 
 include("inc/conect.php");

 session_name("emissor");
 session_start();  
 session_destroy();
 print("<script language=JavaScript>parent.location.href='login.php'</script>"); ?>

