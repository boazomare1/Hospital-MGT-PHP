<?php
//session_start();
include ("db/db_connect.php");

$term = trim($_REQUEST['term']);

$customersearch='';
//echo count($customersplit);

//echo $customersearch;
//$location = $_REQUEST['location'];
//echo $customer;
$stringbuild1 = "";
$a_json = array();
$a_json_row = array();
$query1 = "select entrydocno from transaction_stock where docstatus='New Batch' and batch_stockstatus = '1' and entrydocno LIKE '%$term%' and entrydocno NOT LIKE 'OPS-%' group by entrydocno";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$entrydocno = $res1["entrydocno"];
	
	$a_json_row["entrydocno"] = trim($entrydocno);
	$a_json_row["value"] = trim($entrydocno);
	$a_json_row["label"] = trim($entrydocno);
	array_push($a_json, $a_json_row);
}
//echo $stringbuild1;
echo json_encode($a_json);
?>