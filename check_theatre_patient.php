<?php
include ("db/db_connect.php");
$patientcode = $_REQUEST['state'];
$query_s = "SELECT * FROM master_theatre_booking WHERE patientcode ='$patientcode' AND approvalstatus = 'Pending' ORDER BY auto_number ASC";
$exec_s = mysqli_query($GLOBALS["___mysqli_ston"], $query_s) or die ("Error in Query_s".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res_s = mysqli_fetch_assoc($exec_s))
{  
	$id = $res_s['approvalstatus'];
	echo $id;
}
?>
