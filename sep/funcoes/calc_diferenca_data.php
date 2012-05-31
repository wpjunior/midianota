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
	function calculaData($databanco,$data){
	  // Pega a data do banco
	  $data_calc = $databanco;
	  // Pega o ano da variavel $data
	  $ano_banco = substr($data_calc,0,4);
	  // Pega o mês da variavel $data
	  $mes_banco = substr($data_calc,5,2);
	  // Pega o dia da variavel $data
	  $dia_banco = substr($data_calc,8,2);
	  // Concatena as partes da data no formato dd-mm-aaaa
	  $data_calculo = $dia_banco."-".$mes_banco."-".$ano_banco;
	  
	  
	  // Pega a data atual
	  $data_atual = $data;
	  // Pega o ano da variavel $data_atual
	  $ano_atual = substr($data_atual,0,4);
	  // Pega o mês da variavel $data_atual
	  $mes_atual = substr($data_atual,5,2);
	  // Pega o dia da variavel $data_atual
	  $dia_atual = substr($data_atual,8,2);
	  // Concatena as partes da data atual no formato dd-mm-aaaa
	  $data_atual = $dia_atual."-".$mes_atual."-".$ano_atual;
	  
	  // Obtém um timestamp Unix para a data do banco onde o 0
	  // ( zero ) são respectivamente horas , minutos , segundos
	  $data_calc = mktime(0,0,0,$mes_banco,$dia_banco,$ano_banco);
	  // Obtém um timestamp Unix para a data atual onde os 0
	  // ( zeros ) são respectivamente horas , minutos , segundos
	  $data_atual = mktime(0,0,0,$mes_atual,$dia_atual,$ano_atual);
	  
	  
	  // Faz o calculo da diferença em dias entre as duas datas
	  //24 horas * 60 Min * 60 seg = 86400
	  $dias = ($data_atual - $data_calc)/86400;
	  // Pega a parte inteira da variavel $dias
	  $dias = ceil($dias);
	  return $dias;
	}
?>