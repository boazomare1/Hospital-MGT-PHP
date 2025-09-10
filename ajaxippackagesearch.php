<?php
session_start();
include ("db/db_connect.php");
$logiddocno = $_SESSION["docno"];
$term = trim($_REQUEST['term']);
$a_json = array();
$a_json_row = array();  
$stringbuild1 = "";
$query66 = "select * from master_ippackage where packagename like '%$term%' and status=''";
$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($res66 = mysqli_fetch_array($exec66))
{
	$packageanum = $res66['auto_number'];
	$packagename = $res66['packagename'];
	$a_json_row["anum"] = trim($packageanum);
	$a_json_row["value"] = trim($packagename);
	$a_json_row["label"] = trim($packagename);
	array_push($a_json, $a_json_row);
}
echo json_encode($a_json);
?>