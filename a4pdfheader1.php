<?php
//session_start();
//error_reporting(0);
date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
//include ("includes/loginverify.php");
$query2 = "select * from master_company where auto_number = '$companyanum'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$companyname = $res2["companyname"];
$address1 = $res2["address1"];
$address2 = $res2["address2"];
$area = $res2["area"];
$city = $res2["city"];
$pincode = $res2["pincode"];
$emailid1 = $res2["emailid1"];
$phonenumber1 = $res2["phonenumber1"];
$phonenumber2 = $res2["phonenumber2"];
$faxnumber1 = $res2["faxnumber1"];
$faxnumber2 = $res2["faxnumber2"];
$emailid1 = $res2["emailid1"];
?>
<table width="500" border="0" cellspacing="0" cellpadding="2">
	     <tr>
		    <td width="83" rowspan="4">
			  <?php
			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec3showlogo = mysqli_query($GLOBALS["___mysqli_ston"], $query3showlogo) or die ("Error in Query3showlogo".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3showlogo = mysqli_fetch_array($exec3showlogo);
			$showlogo = $res3showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{
			?>
				
			<img src="logofiles/<?php echo $companyanum;?>.jpg" width="55" height="55" />
			
			<?php
			}
			?></td> 
			<td colspan="4" align="center" class="bodytext21">
	        <?php
			$strlen3 = strlen($address1);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address1 = ' '.$address1.' ';
			}
			?>
			<strong><?php echo $companyname; ?></strong></td>
		    <td width="82" rowspan="4" align="center" class="bodytext22">
			  <?php
			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec3showlogo = mysqli_query($GLOBALS["___mysqli_ston"], $query3showlogo) or die ("Error in Query3showlogo".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3showlogo = mysqli_fetch_array($exec3showlogo);
			$showlogo = $res3showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{
			?>
				
			<img src="logofiles/<?php echo $companyanum;?>.jpg" width="55" height="55" />
			
			<?php
			}
			?></td> 
        </tr>
		   <tr>
		     <td colspan="4" align="center" class="bodytext22"><strong>ISO 15189:2007 CERTIFIED</strong></td>
      </tr>
	    <tr>
		  <td colspan="4" align="center" class="bodytext23">
            <?php
			$address2 = $area.''.$pincode.' '.$city;
			$strlen3 = strlen($address2);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address2 = ' '.$address2.' ';
			}
			?>
			<?php
			$address3 = "Tel: ".$phonenumber1.', '.$phonenumber2;
			$strlen3 = strlen($address3);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address3 = ' '.$address3.' ';
			}
			?>
			<?php echo $address2.','.$address3; ?></td>
  </tr>
            
            <tr>
              <td colspan="4" align="center" class="bodytext24">
			<?php
			$address5 = "Fax: ".$faxnumber1;
			$strlen3 = strlen($address5);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address5 = ' '.$address5;
			}
			?>
			<?php
			$address4 = " E-Mail: ".$emailid1;
			$strlen3 = strlen($address4);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address4 = ' '.$address4.' ';
			}
			?>
            <?php echo $address5.', '.$address4; ?></td>
	    </tr>
			<tr>
			  <td colspan="6" align="center">&nbsp;</td>
			</tr>
</table>	  