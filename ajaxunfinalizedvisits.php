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
$query1 = "select * from master_ipvisitentry where (visitcode NOT IN (select visitcode from billing_ip) OR visitcode NOT IN (select visitcode from billing_ipcreditapproved)) and (patientfullname like '%$customer%' or patientcode like '%$customer%' or visitcode like '%$customer%')";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$customercode = $res1["patientcode"];
	$customername = $res1["patientfullname"];
	$visitcode = $res1['visitcode'];
	$a_json_row["customercode"] = trim($customercode);
	$a_json_row["visitcode"] = trim($visitcode);
	$a_json_row["value"] = trim($customername);
	$a_json_row["label"] = trim($customername)."#".$customercode."#".$visitcode;
	array_push($a_json, $a_json_row);
}
//echo $stringbuild1;
echo json_encode($a_json);
?>