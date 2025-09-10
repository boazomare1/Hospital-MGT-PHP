
<?php 
session_start();

include ("db/db_connect.php");
$recorddate = date('Y-m-d');
$recordtime = date('H:i:s');
$updatetime = date('Y-m-d H:i:s');
$user = $_SESSION['username'];
$ipaddress = $_SERVER["REMOTE_ADDR"];
if(isset($_REQUEST['action'])){$action=$_REQUEST['action'];}else{$action='';}



if($action == 'deleteipcreditapproved')
{
		$patientcode = $_REQUEST['patientcode'];
		$ddocno = $_REQUEST['ddocno'];
		$visitcode = $_REQUEST['visitcode'];
		
		
		
	   $query12 = "DELETE FROM `ip_creditapproval` WHERE patientcode='$patientcode' and visitcode='$visitcode'";
       $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
	   
	   $query122 = "DELETE FROM `ip_creditapprovalformdata` WHERE patientcode='$patientcode' and visitcode='$visitcode'";
       $exec122 = mysqli_query($GLOBALS["___mysqli_ston"], $query122) or die ("Error in Query122".mysqli_error($GLOBALS["___mysqli_ston"]));
	   
	   $query88 = "update ip_bedallocation set creditapprovalstatus='' where patientcode='$patientcode' and visitcode='$visitcode'";
	   $exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	   $query881 = "update ip_discharge set creditapprovalstatus='' where patientcode='$patientcode' and visitcode='$visitcode'";
	   $exec881 = mysqli_query($GLOBALS["___mysqli_ston"], $query881) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  
	echo $ddocno;
	
}

?>