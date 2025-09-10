<?php
//session_start();
include ("db/db_connect.php");

$term = trim($_REQUEST['term']);
$data_from = trim($_REQUEST['data_from']);

$a_json = array();
$a_json_row = array();

if($data_from=="account"){
$query1 = "select * from master_accountname where accountname like '%$term%' and paymenttype NOT IN ('6','7','8','0') and recordstatus <> 'DELETED' limit 0,50";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$res1customercode = $res1['auto_number'];
	$res1accountname = $res1['accountname'];
	$a_json_row["auto_number"] = $res1['auto_number'];
	$a_json_row["accountname"] = $res1['accountname'];
	$a_json_row["value"] = $res1accountname;
	$a_json_row["label"] = $res1accountname;
	array_push($a_json, $a_json_row);
}

}else{
$query2 = "select * from master_subtype where subtype like '%$term%' and recordstatus <> 'Deleted' limit 0,50";// order by subtype limit 0, 15";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
	$res2anum = $res2['auto_number'];
	$res2subtype = $res2['subtype'];
	$a_json_row["auto_number"] = $res2['auto_number'];
	$a_json_row["accountname"] = $res2['subtype'];
	$a_json_row["value"] = $res2subtype;
	$a_json_row["label"] = $res2subtype;
	array_push($a_json, $a_json_row);

}
}
echo json_encode($a_json);
?>