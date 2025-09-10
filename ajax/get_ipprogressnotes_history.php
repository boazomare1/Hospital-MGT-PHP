<?php

//session_start();

include ("../db/db_connect.php");
$loc=isset($_REQUEST['loc'])?$_REQUEST['loc']:'';
$itemcode=$_POST['itemcode'];
$a_json = array();
$a_json_row = array();
if($itemcode !="")
{
 $queryitem = "select * from ip_progressnotes where docno='$itemcode'  order by auto_number desc";
}
//$execitem = mysql_query($queryitem) or die ("Error in Query".mysql_error());
$execitem = mysqli_query($GLOBALS["___mysqli_ston"], $queryitem) or die ("Error in Queryitem".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($resitems = mysqli_fetch_array($execitem))
{
	$pastmed = $resitems['pastmed'];
	$presentmed = $resitems['presentmed'];
	$familyhistory = $resitems['familyhistory'];
	$notes = $resitems['notes'];
	$diagnosis = $resitems['diagnosis'];
	$procedure1 = $resitems['procedure1'];
	$dop = $resitems['dop'];
	$weightofbaby = $resitems['weightofbaby'];
	$notification = $resitems['notification'];
	$condition1 = $resitems['condition1'];
	$docno = $resitems['docno'];

	$a_json_row["pastmed"] = $pastmed;
	$a_json_row["presentmed"] = $presentmed;
	$a_json_row["familyhistory"]     = $familyhistory;
	$a_json_row["notes"]     = $notes;
	$a_json_row["diagnosis"]     = $diagnosis;
	$a_json_row["procedure1"]     = $procedure1;
	$a_json_row["dop"]     = $dop;
	$a_json_row["weightofbaby"]     = $weightofbaby;
	$a_json_row["notification"]     = $notification;
	$a_json_row["condition1"]     = $condition1;
	$a_json_row["docno"]     = $docno;
	array_push($a_json, $a_json_row);
}
echo json_encode($a_json);

flush();

?>