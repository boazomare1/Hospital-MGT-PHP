<?php
session_start();
include ("db/db_connect.php");
$suppliersearch=$_REQUEST['suppliersearch'];
$searchresult = "";

 $query2 = "select * from master_supplier where suppliercode = '$suppliersearch' order by suppliername";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
	$suppliercode = $res2['suppliercode'];
	$suppliername = $res2['suppliername'];
	$address1 = $res2['address1'];
	$area = $res2['area'];
	$city = $res2['city'];
	$pincode = $res2['pincode'];
	$tinnumber = $res2['tinnumber'];
	$cstnumber = $res2['cstnumber'];
	
	if ($searchresult == '')
	{
		$searchresult = ''.$suppliercode.'||'.$suppliername.'||'.$address1.'||'.$area.'||'.$city.'||'.$pincode.'||'.$tinnumber.'||'.$cstnumber.'';
	}
	else
	{
		$searchresult = $searchresult.'||^||'.$suppliercode.'||'.$suppliername.'||'.$address1.'||'.$area.'||'.$city.'||'.$pincode.'||'.$tinnumber.'||'.$cstnumber.'';
	}
	
}

if ($searchresult != '')
{
	echo $searchresult;
}

?>