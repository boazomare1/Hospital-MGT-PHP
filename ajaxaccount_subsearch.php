<?php
//session_start();
include ("db/db_connect.php");

$term = trim($_REQUEST['term']);
$sub =	trim($_REQUEST['sub']);
//echo $customersearch;
//$location = $_REQUEST['location'];
//echo $customer;
//$stringbuild1 = "";
$a_json = array();
$a_json_row = array();
 $query1 = "select accountname,id,auto_number from master_accountname where accountname like '%$term%' and accountssub='$sub' and recordstatus ='ACTIVE' order by accountname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$accountname = $res1['accountname'];
	$accountid=$res1['id'];
	$auto_number = $res1['auto_number'];
	
	$a_json_row["id"] = trim($accountid);
	$a_json_row["value"] = trim($accountname);
	$a_json_row["label"] = trim($accountname);
	$a_json_row["anum"] = trim($auto_number);
	array_push($a_json, $a_json_row);
}
//echo $stringbuild1;
echo json_encode($a_json);
?>