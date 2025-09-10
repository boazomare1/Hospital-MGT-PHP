<?php

//session_start();

include ("db/db_connect.php");

$tablenames = 'master_services';

$locationcode=trim($_REQUEST['loc']);

$term = $_REQUEST['term'];

$stringbuild100 = array();

$a_json = array();

$a_json_row = array();

//$query1 = "select * from $tablenames where itemname like'".$term."%' and status <> 'Deleted' AND locationcode = '".$locationcode."' AND rateperunit <> 0  order by itemname";

$query1 = "select * from $tablenames where itemname like'".$term."%' and status <> 'deleted'  AND rateperunit <> 0  order by itemname";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res1 = mysqli_fetch_array($exec1))

{

	//$res1autonumber = $res1['auto_number'];

	$res1itemcode=$res1['itemcode'];

	$res1itemname = $res1['itemname'];

	$category = $res1['categoryname'];

	$res1itemname = addslashes($res1itemname);

	$res1itemname = strtoupper($res1itemname);

	$res1itemname = trim($res1itemname);

	$a_json_row["code"] = $res1itemcode;

	$a_json_row["name"] = $res1itemname;

	$a_json_row["category"] = $category;

	$a_json_row["value"] = trim($res1itemname);

	$a_json_row["label"] = trim($res1itemname). ' || '. $category;

	array_push($a_json, $a_json_row);

}

//echo $stringbuild1;

echo json_encode($a_json);

?>