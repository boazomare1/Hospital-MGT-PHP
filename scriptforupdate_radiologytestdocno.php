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
<form name="drugs" action="scriptforupdate_radiologytestdocno.php" method="post" onKeyDown="return disableEnterKey()" >
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

 $query291 = "select * from ipconsultation_radiology where resultentry='completed'   ";
$exec291 = mysqli_query($GLOBALS["___mysqli_ston"], $query291) or die ("Error in Query291".mysqli_error($GLOBALS["___mysqli_ston"]));
$num291 = mysqli_num_rows($exec291);
while($res291 = mysqli_fetch_array($exec291))
{
 $res291patientcode = $res291["patientcode"];
 $res291auto_number = $res291["auto_number"];
$res291patientvisitcode = $res291["patientvisitcode"];
echo $res291itemcode = $res291["radiologyitemcode"];
$res291reporting_datetime = $res291["reporting_datetime"];

$time_add1 = date('Y-m-d H:i:s', strtotime('-5 minutes', strtotime($res291["reporting_datetime"])));
$time_add2 = date('Y-m-d H:i:s', strtotime('+5 minutes', strtotime($res291["reporting_datetime"])));

echo $res291docnumber = $res291["docnumber"];
echo "</br>";
				
				$query001 = "select * from ipresultentry_radiology where  patientcode='$res291patientcode' and patientvisitcode='$res291patientvisitcode' and itemcode='$res291itemcode' and  CONCAT(`recorddate`,' ',`recordtime`)  between '$time_add1' and '$time_add2' and docnumber='$res291docnumber' ";
				$exec001 = mysqli_query($GLOBALS["___mysqli_ston"], $query001) or die ("Error in Query001".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num001 = mysqli_num_rows($exec001);
				if($num001>0){
					
				} else {
				  $query00 = "select * from ipresultentry_radiology where  patientcode='$res291patientcode' and patientvisitcode='$res291patientvisitcode' and itemcode='$res291itemcode' and CONCAT(`recorddate`,' ',`recordtime`) between '$time_add1' and '$time_add2' ";
				$exec00 = mysqli_query($GLOBALS["___mysqli_ston"], $query00) or die ("Error in Query00".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num00 = mysqli_num_rows($exec00);
				if($num00>0){
				$res00 = mysqli_fetch_array($exec00);
				$res00patientcode = $res00["patientcode"];
				$res00patientvisitcode = $res00["patientvisitcode"];
				$res00itemcode = $res00["itemcode"];
				$res00docnumber = $res00["docnumber"];
				echo "</br>";
				

				echo $query76910="update ipconsultation_radiology set docnumber='$res00docnumber' where patientcode='$res00patientcode' and patientvisitcode='$res00patientvisitcode' and auto_number='$res291auto_number' and reporting_datetime='$res291reporting_datetime' and resultentry='completed' and radiologyitemcode='$res00itemcode' ";
				$exec76910 = mysqli_query($GLOBALS["___mysqli_ston"], $query76910) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	
				echo "</br>"; 
				}
				}
 
}
}






?>

		</td>
	 </tr>

</tbody>
</table>
</body>