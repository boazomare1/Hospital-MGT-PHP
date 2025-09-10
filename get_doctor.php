<?php

//session_start();

include ("db/db_connect.php");



$customer = trim($_REQUEST['term']);

$stringbuild1 = "";

$a_json = array();

$a_json_row = array();

$query1 = "select doctorname from master_doctor where doctorname like '%$customer%' and status='' order by doctorname";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res1 = mysqli_fetch_array($exec1))

{
	$accountname = $res1['doctorname'];

	$accountname = addslashes($accountname);


	$a_json_row["accountname"] = $accountname;

	$a_json_row["value"] = trim($accountname);

	$a_json_row["label"] = strtoupper(trim($accountname));

	array_push($a_json, $a_json_row);

}

//echo $stringbuild1;

echo json_encode($a_json);

?>