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


<link href="css/teclado.css" rel="stylesheet" type="text/css" >
<script src="scripts/teclado.js" type="text/javascript"></script>
<script src="scripts/drag.js" type="text/javascript"></script>	
	
<div style="position:absolute; left: 50%; top: 60%; visibility: hidden" id="teclado">

	<table border="0" cellspacing="0" cellpadding="0" class="form">
		<tr>
			<td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
			<td id="titulo_teclado" width="" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;Teclado</td>  
			<td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><img style="cursor: pointer;" onclick="mostrar_teclado();" src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></td>
		</tr>
		<tr>
		    <td width="18" background="img/form/lateralesq.jpg"></td>
		    <td align="center">
		    	<br>
		    	<table>
			    	<tr>
			    		<td>
							<table id="teclas2" style="display: none">
							    <tr>
								    <td align="center"><button class="tecla">q</button></td>
								    <td align="center"><button class="tecla">w</button></td>
								    <td align="center"><button class="tecla">e</button></td>
								    <td align="center"><button class="tecla">r</button></td>
								    <td align="center"><button class="tecla">t</button></td>
								    <td align="center"><button class="tecla">y</button></td>
								    <td align="center"><button class="tecla">u</button></td>
								    <td align="center"><button class="tecla">i</button></td>
								    <td align="center"><button class="tecla">o</button></td>
								    <td align="center"><button class="tecla">p</button></td>
								    
							    </tr>
							    <tr>
								    <td align="center"><button class="tecla">a</button></td>
								    <td align="center"><button class="tecla">s</button></td>
								    <td align="center"><button class="tecla">d</button></td>
								    <td align="center"><button class="tecla">f</button></td>
								    <td align="center"><button class="tecla">g</button></td>
								    <td align="center"><button class="tecla">h</button></td>
								    <td align="center"><button class="tecla">j</button></td>
								    <td align="center"><button class="tecla">k</button></td>
								    <td align="center"><button class="tecla">l</button></td>
								    <td align="center"><button class="tecla">ç</button></td>
							    </tr>
							    <tr>
								    <td align="center"><button class="tecla">z</button></td>
								    <td align="center"><button class="tecla">x</button></td>
								    <td align="center"><button class="tecla">c</button></td>
								    <td align="center"><button class="tecla">v</button></td>
								    <td align="center"><button class="tecla">b</button></td>
								    <td align="center"><button class="tecla">n</button></td>
								    <td align="center"><button class="tecla">m</button></td>
								    <td align="center"><button class="tecla">,</button></td>
								    <td align="center"><button class="tecla">.</button></td>
								    <td align="center"><button class="tecla">:</button></td>
							    </tr>
							    <tr>
							     	<td colspan="10" align="center">
							     		<input style="width: 200px;" type="button" class="tecla" value="Espaço" onclick="if((focused.value.length < focused.maxLength||focused.maxLength == -1)&&!focused.readOnly)focused.value+=' ';focused.focus();" >
							     		
							     	</td>
							    </tr>
						    </table>
			    		</td>
				    	<td align="center">
							<table id="teclas">
							    <tr>
								    <td align="center"><button class="tecla">7</button></td>
								    <td align="center"><button class="tecla">8</button></td>
								    <td align="center"><button class="tecla">9</button></td>
							    </tr>
							    <tr>
								    <td align="center"><button class="tecla">4</button></td>
								    <td align="center"><button class="tecla">5</button></td>
								    <td align="center"><button class="tecla">6</button></td>
							    </tr>
							    <tr>
								    <td align="center"><button class="tecla">1</button></td>
								    <td align="center"><button class="tecla">2</button></td>
								    <td align="center"><button class="tecla">3</button></td>
							    </tr>
							    <tr>
							     	<td colspan="3" align="center">
							     		<button class="tecla">0</button>
							     	</td>
							    </tr>
						    </table>
					   		<input style="width: 70px" type="button" value="Limpar" class="tecla" id="teclado_limpar" onclick="if(!focused.readOnly)focused.value='';focused.focus()" >
				   		</td>
			   		</tr>
		   		</table>
		   		<br>
			</td>
			<td width="19" background="img/form/lateraldir.jpg"></td>
		  </tr>
		  <tr>
		    <td align="left" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantoesq.jpg" /></td>
		    <td background="img/form/rodape_fundo.jpg"></td>
		    <td align="right" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantodir.jpg" /></td>
		  </tr>
	</table>
</div>
  
<script type="text/javascript">dragdrop('titulo_teclado','teclado');</script>
