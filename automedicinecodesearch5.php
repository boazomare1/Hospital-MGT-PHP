<?php
session_start();
include ("db/db_connect.php");
$medicinesearch = $_REQUEST["medicinesearch"];
$companyanum = $_SESSION['companyanum'];
$username = $_SESSION['username'];

//$medicinesearch = strtoupper($medicinesearch);
$searchresult2 = "";
$query2 = "select * from master_medicine where itemcode = '$medicinesearch' order by itemname";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
	$itemcode = $res2["itemcode"];
	$itemname = $res2["itemname"];
    $itemname = strtoupper($itemname);
    $rateperunit = $res2["rateperunit"];
	$costprice = $res2["purchaseprice"];
	$packagename = $res2["packagename"];
	$strength = $res2["roq"];
	$categoryname = $res2["categoryname"];
	
	$query231 = "select * from master_employee where username='$username'";
$exec231 = mysqli_query($GLOBALS["___mysqli_ston"], $query231) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res231 = mysqli_fetch_array($exec231);
$res7locationanum1 = $res231['location'];

$query551 = "select * from master_location where auto_number='$res7locationanum1'";
$exec551 = mysqli_query($GLOBALS["___mysqli_ston"], $query551) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res551 = mysqli_fetch_array($exec551);
$location = $res551['locationname'];

$res7storeanum1 = $res231['store'];

$query751 = "select * from master_store where auto_number='$res7storeanum1'";
$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res751 = mysqli_fetch_array($exec751);
$store = $res751['store'];
	
	$itemcode = $itemcode;
	include ('autocompletestockcount1include1.php');
	$currentstock = $currentstock;
	
	if ($searchresult2 == '')
	{
	    $searchresult2 = ''.$itemcode.'||'.$itemname.'||'.$costprice.'||'.$currentstock.'||'.$packagename.'||'.$categoryname.'||'.$strength.'||';
	}
	else
	{
		$searchresult2 = $searchresult2.'||^||'.$itemcode.'||'.$itemname.'||'.$costprice.'||'.$currentstock.'||'.$packagename.'||'.$categoryname.'||'.$strength.'||';
	}
	
}
if ($searchresult2 != '')
{
 echo $searchresult2;
}
?>