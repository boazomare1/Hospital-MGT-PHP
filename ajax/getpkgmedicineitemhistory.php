<?php
//session_start();
include ("../db/db_connect.php");
$visitcode=$_POST['visitcode'];
$viewname=$_POST['viewname'];
$a_json = array();
$a_json_row = array();

if($visitcode !="")
{
if($viewname =="Medicine")
{
	$queryitem = "select * from addpkgitems where visitcode='$visitcode' and package_item_type='MI' and recordstatus<>''";
}elseif($viewname =="Lab"){
	$queryitem = "select * from addpkgitems where visitcode='$visitcode' and package_item_type='LI' and recordstatus<>''";
}elseif($viewname =="Radiology"){
	$queryitem = "select * from addpkgitems where visitcode='$visitcode' and package_item_type='RI' and recordstatus<>''";
}elseif($viewname =="Service"){
	$queryitem = "select * from addpkgitems where visitcode='$visitcode' and package_item_type='SI' and recordstatus<>''";
}
}
$execitem = mysqli_query($GLOBALS["___mysqli_ston"], $queryitem) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($resitems = mysqli_fetch_array($execitem))
{
	$res1patientname = $resitems['patientname'];
	$res1itemcode = $resitems['itemcode'];
	$res1itemname = $resitems['itemname'];
	$res1itemname = addslashes($res1itemname);
	$res1itemname = strtoupper($res1itemname);
	$res1itemname = trim($res1itemname);
	$res1itemname = preg_replace('/,/', ' ', $res1itemname);
	$item_rate = $resitems['rate'];
	$item_quantity = $resitems['quantity'];
	$item_entrydate = date('d-m-Y', strtotime($resitems['createdon']));
	$item_amount = $resitems['amount'];
	$recordstatus = $resitems['recordstatus'];
	
	$a_json_row["patientname"] = $res1patientname;
	$a_json_row["itemcode"] = $res1itemcode;
	$a_json_row["itemname"] = $res1itemname;
	$a_json_row["rate"]     = $item_rate;
	$a_json_row["quantity"] = number_format($item_quantity,'2','.',',');
	$a_json_row["entrydate"]     = $item_entrydate;
	$a_json_row["amount"]     = $item_amount;
	$a_json_row["recordstatus"]     = $recordstatus;
	
	array_push($a_json, $a_json_row);
}

echo json_encode($a_json);
flush();
?>