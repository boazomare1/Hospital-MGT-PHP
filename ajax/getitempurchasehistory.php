<?php

//session_start();

include ("../db/db_connect.php");



$itemcode=$_POST['itemcode'];

$a_json = array();

$a_json_row = array();



if($itemcode !="")

{



 $queryitem = "select auto_number,itemcode,itemname,rate,quantity,entrydate,suppliername from purchase_details where itemcode='$itemcode' order by entrydate,auto_number desc limit 4";

}

$execitem = mysqli_query($GLOBALS["___mysqli_ston"], $queryitem) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($resitems = mysqli_fetch_array($execitem))

{

	

	$res1itemcode = $resitems['itemcode'];

	

	$res1itemname = $resitems['itemname'];

	$res1itemname = addslashes($res1itemname);

	

	$res1itemname = strtoupper($res1itemname);

	

	$res1itemname = trim($res1itemname);

	

	

	$res1itemname = preg_replace('/,/', ' ', $res1itemname);

	

	$item_rate = $resitems['rate'];

	$item_quantity = $resitems['quantity'];

	$item_entrydate = $resitems['entrydate'];

	$item_supplier = $resitems['suppliername'];

	

	$a_json_row["itemcode"] = $res1itemcode;

	$a_json_row["itemname"] = $res1itemname;

	$a_json_row["rate"]     = $item_rate;

	$a_json_row["quantity"] = number_format($item_quantity,'2','.',',');

	$a_json_row["entrydate"]     = $item_entrydate;

	$a_json_row["suppliername"]     = $item_supplier;

	

	array_push($a_json, $a_json_row);

}



echo json_encode($a_json);

flush();

?>