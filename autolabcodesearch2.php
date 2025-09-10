<?php
session_start();
include ("db/db_connect.php");
$labsearch = $_REQUEST["labsearch"];
$patienttypesearch = $_REQUEST['patienttypesearch'];
$varpaymenttype = $_REQUEST['varpaymenttype'];

$locationcode = $_REQUEST['locationcode'];
//$medicinesearch = strtoupper($medicinesearch);
$searchresult3 = "";
$subtype = $_REQUEST['subtype'];
//$medicinesearch = strtoupper($medicinesearch);
$searchresult3 = "";
$query13 = "select labtemplate from master_subtype where auto_number = '$subtype' order by subtype";
$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));
$res13 = mysqli_fetch_array($exec13);
$tablename = $res13['labtemplate'];
if($tablename == '')
{
  $tablename = 'master_lab';
}

$query3 = "select * from $tablename where itemcode = '$labsearch' and status <> 'deleted'  order by itemname";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res3 = mysqli_fetch_array($exec3))
{
	$itemcode1 = $res3["itemcode"];
	$itemname1 = $res3["itemname"];
    $itemname1 = strtoupper($itemname1);
	$externallab = $res3['externallab'];
	
	$pkg = $res3['pkg'];
	/*if($varpaymenttype == 'INSURANCE')
	{
    $rateperunit1 = $res3["rate2"];
	}
	else if($varpaymenttype == 'MICRO INSURANCE')
	{
	 $rateperunit1 = $res3["rate3"];
	}
	else
	{*/
	$rateperunit1 = $res3["rateperunit"];
	/*}*/
	
	
	if ($searchresult3 == '')
	{
	    $searchresult3 = ''.$itemcode1.'||'.$itemname1.'||'.$rateperunit1.'||'.$pkg.'||';
	}
	else
	{
		$searchresult3 = $searchresult3.'||^||'.$itemcode1.'||'.$itemname1.'||'.$rateperunit1.'||'.$pkg.'||';
	}
	
}
if ($searchresult3 != '')
{
 echo $searchresult3;
}
?>