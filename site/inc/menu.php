<?php

$menus = array(
	'Prestadores' 			=> 'prestadores.php',
	'Contadores' 			=> 'contadores.php',
	'Tomadores' 			=> 'tomadores.php',
	'RPS' 					=> 'rps.php',
	'Benefícios' 			=> 'beneficios.php',
	'Perguntas e Respostas' => 'faq.php',
	'Reclamações' 			=> 'ouvidoria.php',
	'Notícias'				=> 'noticias.php',
	'Manuais de Ajuda'		=> 'manuais.php',
	'Legislação'			=> 'legislacao.php'
);

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php
foreach($menus as $menu => $link){
?>
	<tr>
		<td height="20" class="menu">
			<a class="menu" href=<?php echo $link; ?>>&nbsp;<?php echo $menu; ?></a>
		</td>
	</tr>
	<tr>
		<td height="1" bgcolor="#CCCCCC"></td>
	</tr>
<?php
}
?>
</table>
