<?php
session_start();
include ("db/db_connect.php");
$depreciationsearch = $_REQUEST["depreciationsearch"];

$searchresult3 = "";
$query3 = "select * from assetpurchase_details where auto_number = '$depreciationsearch'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res3 = mysqli_fetch_array($exec3))
{
	$fixedassets = $res3["asset"];
	$fixedassetscode = $res3["assetcode"];
	$itemname = $res3["itemname"];
	$category = '';
	
	$query31 = "select * from master_assetcategory where auto_number = '$category'";
	$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res31 = mysqli_fetch_array($exec31);
	$categoryname = $res31['category'];
	$salvagevalue = $res31['salvage'];
	
	$query34 = "select sum(accdepreciation) as accdepreciation from accumulateddepreciation where fixedassetscode = '$fixedassetscode'";
	$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res34 = mysqli_fetch_array($exec34);
	$accdepreciation = $res34['accdepreciation'];
	$accdepreciation = number_format($accdepreciation,2,'.','');
	
	$assetvalue = $res3['totalamount'];
	$assetlife = '0';
	//$salvagevalue = $res3['salvagevalue'];
	//$salvageamount = 0.00;
	$salvageamount = number_format($salvagevalue,2,'.','');
	
	//$depreciation = ($assetvalue - $accdepreciation) * ($salvageamount / 100);	
	
	$depreciation = number_format(0.00,2,'.','');
	
	if ($searchresult3 == '')
	{
	    $searchresult3 = ''.$itemname.'||'.$categoryname.'||'.$assetvalue.'||'.$assetlife.'||'.$salvageamount.'||'.$depreciation.'||'.$depreciationsearch.'||'.$accdepreciation.'||'.$fixedassets.'||'.$fixedassetscode.'||';
	}
	else
	{
		$searchresult3 = $searchresult3.'||^||'.$itemname.'||'.$categoryname.'||'.$assetvalue.'||'.$assetlife.'||'.$salvageamount.'||'.$depreciation.'||'.$depreciationsearch.'||'.$accdepreciation.'||'.$fixedassets.'||'.$fixedassetscode.'||';
	}
	
}
if ($searchresult3 != '')
{
 echo $searchresult3;
}
?>