<?php

include ("db/db_connect.php");

$process=$_REQUEST['term'];

$a_json = array();
$a_json_row = array();
$query1 = "select employeename, employeecode, departmentname, departmentunit from master_employeeinfo where employeename LIKE '%$process%' LIMIT 0,15";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$employeename = $res1['employeename'];
	$employeecode = $res1['employeecode'];
	$departmentname = $res1['departmentname'];
	$departmentunit = $res1['departmentunit'];
	
	$a_json_row["employeename"] = trim($employeename);
	$a_json_row["employeecode"] = trim($employeecode);
	$a_json_row["departmentname"] = trim($departmentname);
	$a_json_row["departmentunit"] = trim($departmentunit);
	$a_json_row["value"] = trim($employeename);
	$a_json_row["label"] = $employeename;
	
	
	array_push($a_json, $a_json_row);  
}

echo json_encode($a_json);


?>	