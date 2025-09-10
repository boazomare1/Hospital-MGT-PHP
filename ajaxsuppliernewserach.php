<?php
//session_start();
include ("db/db_connect.php");

$customer = trim($_REQUEST['term']);

$customersearch='';
//echo count($customersplit);

//echo $customersearch;
//$location = $_REQUEST['location'];
//echo $customer;
$stringbuild1 = "";
$a_json = array();
$a_json_row = array();
$query1 = "select * from master_accountname where accountssub IN ('12') and (accountname like '$customer%' or accountname like '% $customer%')and recordstatus <> 'deleted' order by accountname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$id = $res1["id"];
	$accountname = $res1["accountname"];
	$accountsmain = $res1["accountsmain"];
	$acccountanum = $res1['auto_number'];
	$a_json_row["id"] = trim($id);
	$a_json_row["anum"] = trim($acccountanum);
	$a_json_row["value"] = trim($accountname);
	$a_json_row["label"] = trim($accountname);
	array_push($a_json, $a_json_row);
}
//echo $stringbuild1;
echo json_encode($a_json);
?>
