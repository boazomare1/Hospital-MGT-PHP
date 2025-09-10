<?php

//session_start();

include ("db/db_connect.php");



$customer = trim($_REQUEST['term']);
//$location = $_REQUEST['location'];


$stringbuild1 = "";

$a_json = array();

$a_json_row = array();

$query1 = "select id,accountname from master_accountname where accountname like '%$customer%' and recordstatus <> 'deleted' and accountssub IN ('13') order by accountname";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res1 = mysqli_fetch_array($exec1))

{
    $acc_id=$res1['id'];

	$accountname = $res1['accountname'];

	

	

	$acc_id = addslashes($acc_id);

	$accountname = addslashes($accountname);

	$a_json_row["id"] = $acc_id;

	$a_json_row["accountname"] = $accountname;

	$a_json_row["value"] = trim($accountname);

	$a_json_row["label"] = strtoupper(trim($accountname));

	array_push($a_json, $a_json_row);

}

//echo $stringbuild1;

echo json_encode($a_json);

?>