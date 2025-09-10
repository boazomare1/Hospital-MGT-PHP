<?php
//session_start();
include ("db/db_connect.php");

$doctorname = trim($_REQUEST['term']); 

//echo $customersearch;
$subtype = $_REQUEST['subtype'];
//echo $customer;
$stringbuild1 = "";
$a_json = array();
$a_json_row = array();
 $query13s = "select sertemplate from master_subtype where auto_number = '$subtype' order by subtype limit 0,20";
$exec13s = mysqli_query($GLOBALS["___mysqli_ston"], $query13s) or die ("Error in Query13s".mysqli_error($GLOBALS["___mysqli_ston"]));
$res13s = mysqli_fetch_array($exec13s);
$tablenames = $res13s['sertemplate'];
if($tablenames == '')
{
  $tablenames = 'master_services';
}

$stringbuild1 = "";
$query11 = "select * from $tablenames where itemname like '%$doctorname%' and status <> 'Deleted'  AND rateperunit <> 0 order by itemname limit 0,20";
$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res11 = mysqli_fetch_array($exec11))
{
	$itemname=$res11['itemname'];
	$itemcode=$res11['itemcode'];
	
	$a_json_row["itemname"] = $itemname;
	$a_json_row["itemcode"] = $itemcode;
	
	$a_json_row["value"] = trim($itemname);
	$a_json_row["label"] = trim($itemname);
	array_push($a_json, $a_json_row);
}
//echo $stringbuild1;
echo json_encode($a_json);
?>