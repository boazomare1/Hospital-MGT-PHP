<?php

//session_start();

include ("db/db_connect.php");

$term = trim($_REQUEST['term']);

$a_json = array();

$a_json_row = array();

$query1 = "select * from master_services where itemname like'%".$term."%' and status <> 'deleted'  AND rateperunit <> 0 group by itemname order by itemcode";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$numb=mysqli_num_rows($exec1);

while ($res1 = mysqli_fetch_array($exec1))

{

	

	$res1itemcode=$res1['itemcode'];

	$res1itemname = $res1['itemname'];

	$a_json_row["id"] = $res1itemcode;

	$a_json_row["value"] = trim($res1itemname);

	$a_json_row["label"] = '#'.trim($res1itemcode).' || '.trim($res1itemname);

	array_push($a_json, $a_json_row);

	



}

echo json_encode($a_json);



?>