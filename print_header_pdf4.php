<style>

.bodytexthead {FONT-WEIGHT: normal; FONT-SIZE: 22px; COLOR: #000000; font-family: calibri;}

.bodytexttin {FONT-WEIGHT: bold; FONT-SIZE: 16px; COLOR: #000000; font-family: calibri;}

.bodytextaddress {FONT-WEIGHT: none; FONT-SIZE: 14px; COLOR: #000000; font-family: calibri;}

</style>

<?php
if(isset($locationcode) and $locationcode!='')
   $locationcode = $locationcode;
else
  $locationcode = 'LTC-1';

$queryloc = "select * from master_location where locationcode = '$locationcode'";

$execloc = mysqli_query($GLOBALS["___mysqli_ston"], $queryloc) or die ("Error in Queryloc".mysqli_error($GLOBALS["___mysqli_ston"]));

$resloc = mysqli_fetch_array($execloc);

$locationname = $resloc['locationname'];

$address1 = $resloc['address1'];

$address2 = $resloc['address2'];

$phone = $resloc['phone'];

$email = $resloc['email'];

$website = $resloc['website'];



$queryloc = "select tinnumber from master_company";

$execloc = mysqli_query($GLOBALS["___mysqli_ston"], $queryloc) or die ("Error in Queryloc".mysqli_error($GLOBALS["___mysqli_ston"]));

$resloc = mysqli_fetch_array($execloc);

$tinnumber = $resloc['tinnumber'];

?>

<table width="1000" border="0" cellpadding="0" cellspacing="0" style="margin: 22px 30px 0px 40px;">

  <tr>

    <td width="800" rowspan="7"  align="left" valign="center" 

	 bgcolor="#ffffff" class="bodytext31"><?php

			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";

			$exec3showlogo = mysqli_query($GLOBALS["___mysqli_ston"], $query3showlogo) or die ("Error in Query3showlogo".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res3showlogo = mysqli_fetch_array($exec3showlogo);

			$showlogo = $res3showlogo['showlogo'];

			if ($showlogo == 'SHOW LOGO')

			{ 

			?>

      <img src="logofiles/1.jpg" width="250" height="130" />

    <?php

			}

			?></td>

    <td width="275" align="left" valign="middle" 

	 bgcolor="#ffffff" class="bodytexthead"><?php echo $locationname; ?></td>

  </tr>

   <!--  <tr align="right">

      <td height="16" align="left" valign="top" 

	 bgcolor="#ffffff" class="bodytexttin"><strong>Tin Number: <?= $tinnumber;?></strong></td>

    </tr> --> <tr>

      <td align="left" valign="top" 

	 bgcolor="#ffffff" class="bodytextaddress"><?php echo $address1; ?><br />

        <?php echo $address2; ?><br />

      Tel : <?php echo $phone; ?><br />

      Email : <?php echo $email; ?></td>

    </tr>

    <tr>

      <td align="left" valign="top" 

	 bgcolor="#ffffff" class="bodytextaddress">Website : <?php echo $website; ?></td>

  </tr>

</table>
<div style="margin: 0px 30px 0px 60px;"> <hr></div>

