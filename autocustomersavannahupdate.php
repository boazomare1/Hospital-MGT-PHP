<?php
$hostname = '127.0.0.1';
$hostlogin = 'root';
$hostpassword = '';
$databasename = 'policyplus';
date_default_timezone_set('Africa/Nairobi'); 
//Folder Name Change Only Necessary
$result = array();
$link = ($GLOBALS["___mysqli_ston"] = mysqli_connect($hostname, $hostlogin, $hostpassword)) or die('Could not connect Database : ' . mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($GLOBALS["___mysqli_ston"], $databasename) or die('Could not select database'. mysqli_error($GLOBALS["___mysqli_ston"]));
$customersearch = $_REQUEST['memberno'];
$status = $_REQUEST['status'];

$query1 = "select * from exchange_files where Member_Nr = '$customersearch' and Progress_Flag = '1'";
//$query1 = "select * from exchange_files where Progress_Flag = '1'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$num = mysqli_num_rows($exec1);
	
	if($num > 0)
	{
	$sql = "UPDATE exchange_files SET Progress_Flag = '$status' WHERE Member_Nr = '$customersearch' AND Progress_Flag = '1'";
	}
	else
	{
	$sql = "UPDATE exchange_files SET Progress_Flag = '$status' WHERE Member_Nr = '$customersearch' AND Progress_Flag = '1'";
	}
	$update_id = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
	//echo json_encode($result);
?>
