<?php
//session_start();
include ("db/db_connect.php");

$customer = trim($_REQUEST['term']);
$stringbuild1 = "";
$a_json = array();
$a_json_row = array();
$query1 = "select * from master_employee where employeename like '%$customer%' and is_user like 'yes' and username <> '' order by auto_number limit 20";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	//$res1employeecode = $res1['employeecode'];
	$res1employeename=$res1['employeename'];
	$res1username = $res1['username'];
	
	
	//$res1employeecode = addslashes($res1employeecode);
	$res1employeename = addslashes($res1employeename);
	$res1username = addslashes($res1username);
	
	$a_json_row["username"] = $res1username;
	$a_json_row["value"] = trim($res1employeename);
	$a_json_row["label"] = strtoupper(trim($res1employeename));
	array_push($a_json, $a_json_row);
}
//echo $stringbuild1;
echo json_encode($a_json);
?>