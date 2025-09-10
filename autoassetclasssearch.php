<?php

include ("db/db_connect.php");



$asset_class = trim(strtoupper($_REQUEST['term']));

$a_json = array();

$a_json_row = array();



$query2 = "select * from master_assetcategory where category like '%$asset_class%' and recordstatus <> 'deleted'";



$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res2 = mysqli_fetch_array($exec2))

{

	$id = $res2["id"];

	$idlen = strlen($id);

	$asset_class = $res2["category"];

	$asset_classanum = $res2['auto_number'];

	$salvage = $res2['salvage'];

	$noofyears = $res2['noofyears']; 

	

	$query7 = "select asset_id from assets_register where asset_id LIKE '$id%' order by asset_id desc limit 1";

	$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res7 = mysqli_fetch_array($exec7);

	$asset_id = $res7['asset_id'];

	$asset_idlen = strlen($asset_id);

	$assetid = substr($asset_id,$idlen,$asset_idlen);

	$assetid = intval($assetid) + 1;

	$anumlen = strlen($assetid);

	if($anumlen == 1) { $assetid = '000'.$assetid; }

	else if($anumlen == 2) { $assetid = '00'.$assetid; }

	else if($anumlen == 3) { $assetid = '0'.$assetid; }

	else { $assetid = $assetid; }

	$asset_id = $id.$assetid;

		

	$a_json_row["id"] = trim($id);

	$a_json_row["asset_id"] = trim($asset_id);

	$a_json_row["anum"] = trim($asset_classanum);

	$a_json_row["salvage"] = trim($salvage);

	$a_json_row["value"] = trim($asset_class);

	$a_json_row["label"] = trim($asset_class.' || '.$id);

	$a_json_row["noofyears"] = trim($noofyears);
	array_push($a_json, $a_json_row);

}

echo json_encode($a_json);

 

?>

