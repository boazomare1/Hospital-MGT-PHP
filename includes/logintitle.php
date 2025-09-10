<?php

$titlestr = '';

include ("includes/pagetitle1.php");

?>

<style type="text/css">

<!--

.style4TM1 {font-size: 18px; font-family: Verdana, Arial, Helvetica, sans-serif; color: #ffffff;}

-->

</style>

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td width="0%" bgcolor="#3c8dbc">&nbsp;</td>

    <td colspan="4" bgcolor="#3c8dbc">

	<span class="style4TM1">

	<img src="images/medbot.png" />	</span></td>

    <td bgcolor="#3c8dbc"></td>

    <td width="27%" bgcolor="#3c8dbc" class="style4TM1" align="left">

	<?php if (isset($_SESSION["username"])) { echo strtoupper($_SESSION["username"]); } ?>

	&nbsp;</td>

    <td align="left" bgcolor="#3c8dbc" class="style4TM1"><?php echo date('D, M j, Y g:ia'); ?></td>

    <td width="26%" bgcolor="#3c8dbc" class="style4TM1"><img src="images/company.png" width="150" height="50" style="margin-left: 50%;"/></td>

  </tr>

</table>

