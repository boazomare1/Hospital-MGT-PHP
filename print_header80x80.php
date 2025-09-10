<style>
.bodytexthead {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000;}
.bodytextaddress {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;}
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
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td align="center" valign="middle" 
	 bgcolor="#ffffff" class="bodytexthead"><?php echo $locationname; ?></td>
  </tr>
    <tr>
      <td align="center" valign="top" 
	 bgcolor="#ffffff" class="style2"><?php echo $address1; ?></td>
    </tr>
	<tr>
      <td align="center" valign="top" 
	 bgcolor="#ffffff" class="style2"><?php echo $address2; ?></td>
    </tr>
	<tr>
      <td align="center" valign="top" 
	 bgcolor="#ffffff" class="style2">TEL: <?php echo $phone; ?></td>
    </tr>
	<tr>
      <td align="center" valign="top" 
	 bgcolor="#ffffff" class="style2">Email: <?php echo $email; ?></td>
    </tr>
</table>
