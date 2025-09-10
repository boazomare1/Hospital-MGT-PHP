<?php
session_start();
include ("db/db_connect.php");

$subtypename = trim($_REQUEST['term']);

$a_json = array();
$a_json_row = array();
$query1 = "SELECT auto_number,subtype FROM master_subtype WHERE subtype LIKE '%$subtypename%' AND recordstatus = '' ORDER BY auto_number LIMIT 20";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
		$itemauto_number = $res1["auto_number"];  
		$subtypename = $res1["subtype"];

	$a_json_row["subtypename"] = $subtypename;
	$a_json_row["subtypeautono"] = $itemauto_number;
	$a_json_row["value"] = $subtypename;
	$a_json_row["label"] = $itemauto_number." # ".$subtypename;
	array_push($a_json, $a_json_row);
}

echo json_encode($a_json);
?>