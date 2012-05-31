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
  if($_POST['btCadastrar'])
  {
	$TipoPessoa = $_POST['rdTipoPessoa'];
	$ISSRetido =  $_POST['rdISSRetido'];
	$ValorNota =  $_POST['txtValorNota'];
	$Valor = 	  $_POST['txtValor'];
		if(($ValorNota)	&& ($Valor)){
			mysql_query("INSERT INTO nfe_creditos SET credito='$Valor',tipopessoa='$TipoPessoa',issretido='$ISSRetido',valor='$ValorNota'");
			add_logs('Inseriu uma Nota de Crédito');
			Mensagem("Crédito Cadastrado com sucesso !!");
		}else{
			Mensagem("Informe o valor da nota");
		}
  }//fim if
?>


<form method="post" onsubmit="return MoedaToDecimal('txtValorNota');return ValidaForm('ckTipoPessoa|ckISSRetido|txtValorNota|txtValor');">
<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
<fieldset style="margin-left:10px; margin-right:10px;">
<legend>Inser&ccedil;&atilde;o de Regras </legend>
<br>
<table width="100%" border="0">	
	<tr>
		<td width="23%" align="left">	      Tipo de Pessoa:		 </td>
   <td align="left">  
		   <input type="hidden" name="btRegra" value="Inserir Regra">
		   <input type="radio" name="rdTipoPessoa" id="rdTipoPessoa" value="PF">Pessoa Física&nbsp;		
		   <input type="radio" name="rdTipoPessoa" id="rdTipoPessoa" value="PJ" checked="checked">Pessoa Jurídica&nbsp;
		</td>	
	</tr>
	<tr>
		<td width="23%" align="left">	      Iss Retido:		</td>  
   <td align="left">
		   <input type="radio" name="rdISSRetido" id="rdISSRetido" value="S">Sim&nbsp;
		   <input type="radio" name="rdISSRetido" id="rdISSRetido" value="N" checked="checked">Não&nbsp;
		</td>	
	</tr>
	<tr>
		<td width="23%" align="left">	      Valor da Nota		</td>	
   <td align="left">
		   <input type="text" name="txtValorNota" size="10" class="texto" id="txtValorNota" onkeypress="return MascaraMoeda(this,'.',',',event)"> 
		   <em>(somente n&uacute;meros)</em> </td>	
	</tr>
	<tr>
		<td width="23%" align="left">	      % de crédito </td>	
   <td align="left">
		   <input type="text" name="txtValor" id="txtValor" size="5" class="texto" onBlur="ControlePercentatagem('txtValor')">&nbsp;<em>(Exemplo: 2.5 %)
        </em></td>	
	</tr>
	<tr>
		<td  colspan="2" align="left">		 
		   <input type="submit" name="btCadastrar" id="btCadastrar" class="botao" value="Cadastrar Regras">
		</td>	
	</tr>
</table>
</fieldset>
</form>