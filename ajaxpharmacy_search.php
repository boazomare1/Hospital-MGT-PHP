<?php
//session_start();
include ("db/db_connect.php");

$term = trim($_REQUEST['term']);

//$stringbuild1 = "";
$a_json = array();
$a_json_row = array();
 $query1 = "select itemname,itemcode,auto_number from master_medicine where itemname like '%$term%' and status <> 'deleted' group by itemcode";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$itemname = $res1['itemname'];
	$itemcode=$res1['itemcode'];
	$auto_number = $res1['auto_number'];
	
	$a_json_row["id"] = trim($itemcode);
	$a_json_row["value"] = trim($itemname);
	$a_json_row["label"] = trim($itemname);
	$a_json_row["anum"] = trim($auto_number);
	array_push($a_json, $a_json_row);
}
//echo $stringbuild1;
echo json_encode($a_json);
?>