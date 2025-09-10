<?php
//session_start();
include ("../db/db_connect.php");
$packageid=$_REQUEST['packageid'];
$locationcode=$_REQUEST['locationcode'];
	
$rate='0.00';
$num_rows = 0;

$query10 = "select rate,days from `master_ippackage` where auto_number = '$packageid'";
$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res10 = mysqli_fetch_array($exec10))
{	
		$rate = $res10['rate'];
		$days = $res10['days'];
}
$query11 = "select id from `package_items` where package_id = '$packageid' and locationcode='$locationcode'";
$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
$num_rows = mysqli_num_rows($exec11);
	
	echo $rate.'||'.$days.'||'.$num_rows;
?>
