<?php

include ("db/db_connect.php");

 $process=$_REQUEST['term'];

$a_json = array();
$a_json_row = array();
$query1 = "select itemname,itemcode,rateperunit,pkg from master_radiology where itemname like '%$process%' and status <> 'Deleted' GROUP BY itemcode";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$itemname = $res1['itemname'];
	$itemcode = $res1['itemcode'];
	$itemrate = $res1['rateperunit'];
	$a_json_row["itemcode"] = trim($itemcode);
	$a_json_row["value"] = trim($itemname);
	$a_json_row["rate"] = trim($itemrate);
	$a_json_row["pkg"] = trim($res1['pkg']);
	$a_json_row["label"] = trim($itemcode).'||'.trim($itemname).'||'.$itemrate;
	array_push($a_json, $a_json_row);
}

echo json_encode($a_json);


?>