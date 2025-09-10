<?php

session_start();

include ("db/db_connect.php");
$username = $_SESSION["username"];


$customer = trim($_REQUEST['term']);

$query_sub = "select * from master_menusub where submenutext like '%$customer%' and status<>'deleted' ";

$exec_sub = mysqli_query($GLOBALS["___mysqli_ston"], $query_sub) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$stringbuild1 = "";

$a_json = array();

$a_json_row = array();

while ($res1 = mysqli_fetch_array($exec_sub))

{
$submenulink=$res1['submenulink'];

	$submenuid = $res1['submenuid'];
	
$query883 = "select * from master_employeerights where  username='$username' and submenuid='$submenuid'";

$exec883 = mysqli_query($GLOBALS["___mysqli_ston"], $query883) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$numb=mysqli_num_rows($exec883);
if($numb>0){
	$submenutext = $res1['submenutext'];

	$a_json_row["submenuid"] = $submenuid;
	$a_json_row["submenulink"] = $submenulink;


	$a_json_row["value"] = trim($submenutext);

	$a_json_row["label"] = trim($submenutext);

	array_push($a_json, $a_json_row);
	}

}

//echo $stringbuild1;

echo json_encode($a_json);

?>