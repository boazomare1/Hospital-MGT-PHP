<?php

session_start();

include ("db/db_connect.php");

$username = $_REQUEST['username'];
$department=$_REQUEST['department'];
$a_json = array();

$a_json_row = array();

$query1 = "select department from master_employeedepartment where username='$username' and department like '%$department%'";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res1 = mysqli_fetch_array($exec1))

{

$department = $res1["department"];

    $a_json_row["department"] = $department;

	$a_json_row["value"] = $department;

	$a_json_row["label"] = $department;

	array_push($a_json, $a_json_row);

}


echo json_encode($a_json);

?>

