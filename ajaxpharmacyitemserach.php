<?php
//session_start();
include ("db/db_connect.php");

$searchmedicine = trim($_REQUEST['term']);
//$customersplit = explode('|',$customer);
//$customersearch='';
//echo count($customersplit);

//echo $customersearch;
//$location = $_REQUEST['location'];
//echo $customer;
$stringbuild1 = "";
$a_json = array();
$a_json_row = array();
$qrymedicineitem = "SELECT  itemcode,itemname FROM master_medicine WHERE itemname LIKE '%$searchmedicine%' and status <> 'Deleted'  ORDER BY auto_number LIMIT 20";
$execmedicineitem = mysqli_query($GLOBALS["___mysqli_ston"], $qrymedicineitem) or die ("Error in qrymedicineitem".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($resmadicineitem = mysqli_fetch_array($execmedicineitem))
{
	$itemcode = $resmadicineitem['itemcode'];
	$itemname = $resmadicineitem['itemname'];
	
	
	
	$itemcode = addslashes($itemcode);
	$itemcode = strtoupper($itemcode);
	
	$itemname = addslashes($itemname);
	$itemname = strtoupper($itemname);
	

	
	$itemcode = preg_replace('/,/', ' ', $itemcode);
	$itemname = preg_replace('/,/', ' ', $itemname);
	
	
	$a_json_row["itemcode"] = $itemcode;
	$a_json_row["itemname"] = $itemname;
	$a_json_row["value"] = trim($itemname);
	$a_json_row["label"] = trim($itemname);
	array_push($a_json, $a_json_row);
}
//echo $stringbuild1;
echo json_encode($a_json);
?>