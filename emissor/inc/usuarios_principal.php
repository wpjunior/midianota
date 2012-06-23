<?php
 $login = $_SESSION['login'];

 if($btAtualizar != "") 
 {
   include("usuarios_editar.php"); 
 }

?>  
   <table width="500" align="center" cellpadding="0" cellspacing="0">
    <tr>
     <td>
      <fieldset style="width:500px"><legend>Atualização da senha do usuário <?php print ("<b><font color=RED>$NOME&nbsp;</font></b>");?></legend>
      <form action="usuarios.php" method="post" name="frmCadUsuarios" >   
      <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">	       
       <tr>
        <td align="left">Senha</td>
        <td align="left"><input type="password" size="10" maxlength="10" name="txtSenha" class="texto">&nbsp;No máximo 10 caracteres        </td>
       </tr>	  
        <td>
	     <input type="submit" value="Atualizar" name="btAtualizar" class="botao"></td>
        <td>		 
		  </td>
        </tr>   
      </table>   
      </form>
      </fieldset>
     </td>
    </tr>  
   </table> 

    </td>
  </tr>
  <tr>
    <td> 

    </td>
  </tr>  
</table>    
     
   
  