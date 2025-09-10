
<?php 
session_start();

include ("db/db_connect.php");
$recorddate = date('Y-m-d');
$recordtime = date('H:i:s');
$updatetime = date('Y-m-d H:i:s');
$user = $_SESSION['username'];
$ipaddress = $_SERVER["REMOTE_ADDR"];
if(isset($_REQUEST['action'])){$action=$_REQUEST['action'];}else{$action='';}



if($action == 'update_theaterbookingapprovalstatus')
{
		$docno = $_REQUEST['docno'];
		$ddocno = $_REQUEST['ddocno'];
		$type = $_REQUEST['type'];
	   $query1222 = "update master_theatre_booking set theater_approvalstatus = '$type' WHERE auto_number = '$docno'";
       $exec1222 = mysqli_query($GLOBALS["___mysqli_ston"], $query1222) or die ("Error in Query1222".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	echo $ddocno;
	
}

if($action == 'update_theaterbookingapprovalstatus_schedule')
{
		$docno = $_REQUEST['docno'];
		$ddocno = $_REQUEST['ddocno'];
		$type = $_REQUEST['type'];
		$scheduledatetime = $_REQUEST['scheduledatetime'];
		$surgerytime = $_REQUEST['surgerytime'];
		$schedule_datetime=$scheduledatetime .' '.$surgerytime;
		$durationtime = $_REQUEST['durationtime'];
		$t = '+'.$durationtime.' minutes';
		$estimated_endtime = date('Y-m-d H:i:s', strtotime($t, strtotime($schedule_datetime)));
	if($scheduledatetime<>''){
		$query1222 = "update master_theatre_booking set theater_approvalstatus = '$type',surgerydatetime='$schedule_datetime',estimated_endtime='$estimated_endtime',estimatedtime='$durationtime'  WHERE auto_number = '$docno'";
       $exec1222 = mysqli_query($GLOBALS["___mysqli_ston"], $query1222) or die ("Error in Query1222".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	echo $ddocno;
	} else {
		
		echo 0;
	}
	
}

?>