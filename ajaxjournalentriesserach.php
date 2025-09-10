<?php
//session_start();
include ("db/db_connect.php");
$customer = trim($_REQUEST['term']);

$stringbuild1 = "";
$a_json = array();
$a_json_row = array();
$query1 = "select docno as id from master_journalentries where docno='$customer' and approve_je='0' group by docno";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$id = $res1["id"];
	$a_json_row["id"] = trim($id);
	$a_json_row["label"] = trim($id);
	array_push($a_json, $a_json_row);
}
//echo $stringbuild1;
echo json_encode($a_json);
?>