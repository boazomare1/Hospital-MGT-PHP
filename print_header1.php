<style>
.bodytexthead {FONT-WEIGHT: normal; FONT-SIZE: 20px; COLOR: #000000; font-family: Times;}
.bodytextaddress {FONT-WEIGHT: bold; FONT-SIZE: 10px; COLOR: #000000; font-family: Times;}
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
?>
<table width="auto" border="" cellpadding="0" cellspacing="0" align="center">

  <tr>
    <td width="20%" rowspan="4"  align="right" valign="top" 
	 bgcolor="#ffffff" class="bodytext31">
      
      <?php
			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec3showlogo = mysqli_query($GLOBALS["___mysqli_ston"], $query3showlogo) or die ("Error in Query3showlogo".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3showlogo = mysqli_fetch_array($exec3showlogo);
			$showlogo = $res3showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{ 
			?>
      
      <img src="logofiles/1.jpg" width="75" height="auto" />
      
      <?php
			} 
			?>	</td>
            <td width="80%" align="center" valign="bottom" 
	 bgcolor="#ffffff" class="bodytexthead"><?php echo $res1companyname; ?></td></tr>
    <tr><td width="80%" align="center" valign="top" 
	 bgcolor="#ffffff" class="bodytextaddress"><?php echo $res1address1; ?></td></tr>
    <tr>
	<td width="50%" align="center" valign="top" 
	 bgcolor="#ffffff" class="bodytextaddress"><?php
	echo '<strong class="bodytextaddress"></strong>';?><?php
	//echo '<br>'.$res1address1.' '.$res1area.' '.$res1city;
	//echo '<br>'.$res1pincode;
    if($phonenumber1 != '')
	 {
	echo '<strong class="bodytextaddress"> Tel : '.$phonenumber1.'</strong>';
	 }
	 ?></td>
  </tr>
  <tr>
	<td width="50%" align="center" valign="top" 
	 bgcolor="#ffffff" class="bodytextaddress"><?php
	echo '<strong class=""> Email : '.$email.'</strong>';
	 ?></td>
  </tr>
  </table>