<table width="100%" border="0" cellspacing="0" cellpadding="0" height="130">
  <tr>
    <td width="15%" align="left" valign="middle">
	<a href="index.php" class="menuTopo">
		<?php if($CONF_BRASAO){ echo "<img src=../img/brasoes/".rawurlencode($CONF_BRASAO)." height='100' width='100'>";} ?>
	</a>
    </td>
    <td width="85%" align="left" valign="middle">
	<font class="prefeituraTitulo" color="#FFFFFF" size="-1"><b><?php echo "Prefeitura Municipal de ".$CONF_CIDADE; ?></b></font><br />
	<font class="secretariaTitulo" color="#FFFFFF" size="+1"><b><?php echo $CONF_SECRETARIA; ?></b></font></td>
  </tr>
</table>