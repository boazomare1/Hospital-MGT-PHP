<?php

include ("db/db_connect.php");

 $process=$_REQUEST['term'];

$a_json = array();
$a_json_row = array();
 $query1 = "select itemname, itemcode, categoryname from master_services where itemname like '%$process%' and status <> 'deleted' order by itemname limit 15";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$itemcode = $res1['itemcode'];
	$itemname = $res1['itemname'];
	$categoryname = $res1['categoryname'];
	
	$a_json_row["itemcode"] = trim($itemcode);
	$a_json_row["itemname"] = trim($itemname);
	$a_json_row["categoryname"] = trim($categoryname);
	$a_json_row["value"] = trim($itemname .' || '. $itemcode);
	$a_json_row["label"] = $itemname.' || '.$itemcode;
	
	
	array_push($a_json, $a_json_row);  
}

echo json_encode($a_json);


?>