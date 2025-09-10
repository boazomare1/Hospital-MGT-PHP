<style>
.bodytexthead {FONT-WEIGHT: normal; FONT-SIZE: 18px; COLOR: #000000; font-family: calibri;}
.bodytexttin {FONT-WEIGHT: bold; FONT-SIZE: 10px; COLOR: #000000; font-family: calibri;}
.bodytextaddress {FONT-WEIGHT: none; FONT-SIZE: 12px; COLOR: #000000; font-family: calibri;}
</style>
<?php

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
<table width="" border="0" cellpadding="0" cellspacing="0" align="center">

  <tr>
    <td width="70" rowspan="3"  align="left" valign="center" 
	 bgcolor="#ffffff" class="bodytext31"><?php
			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec3showlogo = mysqli_query($GLOBALS["___mysqli_ston"], $query3showlogo) or die ("Error in Query3showlogo".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3showlogo = mysqli_fetch_array($exec3showlogo);
			$showlogo = $res3showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{ 
			?>
      <img src="logofiles/1.jpg" width="80" height="80" />
    <?php
			}
			?></td>
    <td width="275" align="center" valign="middle" 
	 bgcolor="#ffffff" class="bodytexthead"><?php echo $locationname; ?></td>
  </tr>
    <tr>
      <td align="center" valign="top" 
	 bgcolor="#ffffff" class="bodytextaddress"><?php echo $address1; ?><br />
        <?php echo $address2; ?><br />
      Tel : <?php echo $phone; ?><br />
      Email : <?php echo $email; ?></td>
    </tr>
    <tr>
      <td align="center" valign="top" 
	 bgcolor="#ffffff" class="bodytextaddress">Website : <?php echo $website; ?></td>
  </tr>
</table>
