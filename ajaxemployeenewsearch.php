<?php
//session_start();
include ("db/db_connect.php");

$customer = trim($_REQUEST['term']);

$stringbuild1 = "";
$a_json = array();
$a_json_row = array();
$query3 = "select employeecode, employeename from master_employee where employeename like '%$customer%' and status <> 'deleted' limit 0,10";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res3 = mysqli_fetch_array($exec3))
{
	$res3employeecode = $res3['employeecode'];

	$employeecode = $res3['employeecode'];
	$employeename = $res3['employeename'];

	$employeename = strtoupper($employeename);
	$employeecode = strtoupper($employeecode);
	
	$employeename = trim($employeename);
	$employeecode = trim($employeecode);
	
	$a_json_row["employeecode"] = $employeecode;
	$a_json_row["employeename"] = $employeename;
	$a_json_row["value"] = trim($employeename);
	$a_json_row["label"] = trim($employeename);
	array_push($a_json, $a_json_row);
}
//echo $stringbuild1;
echo json_encode($a_json);
?>