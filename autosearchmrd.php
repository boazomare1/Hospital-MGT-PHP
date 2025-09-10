<?php

include ("db/db_connect.php");

$process=$_REQUEST['term'];

$a_json = array();
$a_json_row = array();
$query1 = "select customerfullname, customercode, mrdno from master_customer where mrdno LIKE '%$process%' UNION ALL select patientname as customerfullname, patientcode as customercode ,mrdno from mrdmovement where mrdno LIKE '%$process' group by customercode LIMIT 0,15";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$customername = $res1['customerfullname'];
	$customercode = $res1['customercode'];
	$mrdno = $res1['mrdno'];
	
	$a_json_row["customername"] = trim($customername);
	$a_json_row["mrdno"] = trim($mrdno);
	$a_json_row["value"] = trim($mrdno);
	$a_json_row["label"] = $customername.' || '.$mrdno;
	
	
	array_push($a_json, $a_json_row);  
}

echo json_encode($a_json);


?>