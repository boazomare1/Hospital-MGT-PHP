<?php
//session_start();
include ("db/db_connect.php");
$customer = trim($_REQUEST['term']);
$customersearch='';

$stringbuild1 = "";
$a_json = array();
$a_json_row = array();
$query1 = "select * from allocation_reasons where reason like '$customer%' and status <> 'deleted' order by reason";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$id = $res1["auto_number"];
	$accountname = $res1["reason"];
	$a_json_row["id"] = trim($id);
	$a_json_row["value"] = trim($accountname);
	$a_json_row["label"] = trim($accountname);
	array_push($a_json, $a_json_row);
}
//echo $stringbuild1;
echo json_encode($a_json);
?>