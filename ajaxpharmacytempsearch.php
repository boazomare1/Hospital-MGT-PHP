<?php
session_start();
include ("db/db_connect.php");

$templatename = trim($_REQUEST['term']);

$a_json = array();
$a_json_row = array();
$query1 = "SELECT auto_number,templatename FROM pharma_rate_template WHERE templatename LIKE '%$templatename%' AND recordstatus = '' ORDER BY auto_number LIMIT 20";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
		$itemautono = $res1["auto_number"];  
		$templatename = $res1["templatename"];

	$a_json_row["templatename"] = $templatename;
	$a_json_row["templateautono"] = $itemautono;
	$a_json_row["value"] = $templatename;
	$a_json_row["label"] = $itemautono." # ".$templatename;
	array_push($a_json, $a_json_row);
}

echo json_encode($a_json);
?>