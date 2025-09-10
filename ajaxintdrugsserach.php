<?php

include ("db/db_connect.php");

 $process=$_REQUEST['term'];
 
$a_json = array();
$a_json_row = array();
   $query1 = "select itemname,itemcode from master_medicine where type='drugs' and status <> 'deleted' and (itemname like '%$process%' or itemcode like'%$process%') GROUP BY itemcode limit 0,15";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$itemname = $res1['itemname'];
	$itemcode = $res1['itemcode'];
	
	$a_json_row["itemcode"] = trim($itemcode);
	$a_json_row["value"] = trim($itemname);
	$a_json_row["label"] = trim($itemname);
	
	
	array_push($a_json, $a_json_row);
}

echo json_encode($a_json);

?>