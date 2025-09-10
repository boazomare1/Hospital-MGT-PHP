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
<form name="drugs" action="scriptforupdateresulyentry.php" method="post" onKeyDown="return disableEnterKey()" >
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

 $query291 = "select * from consultation_lab where consultationdate between '2021-01-01' and '2021-03-08' and resultentry='pending' and labsamplecoll='completed' and labrefund<>'refund'";
$exec291 = mysqli_query($GLOBALS["___mysqli_ston"], $query291) or die ("Error in Query291".mysqli_error($GLOBALS["___mysqli_ston"]));
$num291 = mysqli_num_rows($exec291);
while($res291 = mysqli_fetch_array($exec291))
{
echo "visit =====>".$res291visitcode = $res291["patientvisitcode"];
 echo "count =====>".$res291labitemcode = $res291["labitemcode"];
$res291patientcode = $res291["patientcode"];

 echo "</br>";

 $cccount=0;
  $query2910 = "select * from resultentry_lab where patientvisitcode = '$res291visitcode' and itemcode='$res291labitemcode'  ";
  $exec2910 = mysqli_query($GLOBALS["___mysqli_ston"], $query2910) or die ("Error in Query2910".mysqli_error($GLOBALS["___mysqli_ston"]));
  $num2910 = mysqli_num_rows($exec2910);
 $res2910 = mysqli_fetch_array($exec2910);
 if($num2910>0){
 
$res291sampleid= $res2910["sampleid"];

	echo $query76910="update consultation_lab set resultentry='completed' where patientvisitcode='$res291visitcode' and labitemcode='$res291labitemcode' and sampleid='$res291sampleid'";
	//$exec76910 = mysql_query($query76910) or die(mysql_error());
	echo "</br>"; 

 }
}
   
   
}

?>

		</td>
	 </tr>

</tbody>
</table>
</body>