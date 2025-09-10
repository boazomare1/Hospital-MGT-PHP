<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatetime = date("H:i:s");
$updatedatetime = date ("Y-m-d H:i:s");  
$dateonly = date("Y-m-d");
$currentdate = date("Y-m-d");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];

$docno=$_SESSION["docno"];

?>

<body>
<form name="drugs" action="biilingippharmacyupdate.php" method="post" onKeyDown="return disableEnterKey()" >
<table width="110%" border="0" cellspacing="0" cellpadding="2">
<tbody id="foo">
        <tr>
		<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Update</td>
					  <td colspan="5" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
						 <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
		  <input  type="submit" value="Submit" name="Submit" />
					  </span></td>
		</tr>
		</form>	
		
      <tr>
        <td>

<?php
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

if ($cbfrmflag1 == 'cbfrmflag1')
{	

 $query291 = "select * from billing_ippharmacy where billnumber='IPFCA58-20'   ";
$exec291 = mysqli_query($GLOBALS["___mysqli_ston"], $query291) or die ("Error in Query291".mysqli_error($GLOBALS["___mysqli_ston"]));
$num291 = mysqli_num_rows($exec291);
while($res291 = mysqli_fetch_array($exec291))
{
 $medicinecode = $res291["medicinecode"];
echo $medicinename = $res291["medicinename"];
 $patientvisitcode = $res291["patientvisitcode"];
 $patientcode = $res291["patientcode"];
 $billnumber = $res291["billnumber"];
 $quantity = $res291["quantity"];
 echo "</br>";

 $query29 = "SELECT rate from pharmacysales_details where visitcode='$patientvisitcode' and patientcode='$patientcode' and itemcode='$medicinecode'  ";
$exec29 = mysqli_query($GLOBALS["___mysqli_ston"], $query29) or die ("Error in Query29".mysqli_error($GLOBALS["___mysqli_ston"]));
$num29 = mysqli_num_rows($exec29);
$res29 = mysqli_fetch_array($exec29);
 $rate = $res29["rate"];
 
 $amount1=$quantity*$rate;
 
 echo $query76910="update billing_ippharmacy set rate='$rate',amount='$amount1',rateuhx='$rate',amountuhx='$amount1' where   billnumber='$billnumber' and medicinecode='$medicinecode' and quantity='$quantity'";
	$exec76910 = mysqli_query($GLOBALS["___mysqli_ston"], $query76910) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	
echo "</br>"; 
 
}
}






?>

		</td>
	 </tr>

</tbody>
</table>
</body>