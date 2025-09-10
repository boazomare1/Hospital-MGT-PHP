<?php
session_start();
include ("db/db_connect.php");
$radiologysearch = $_REQUEST["radiologysearch"];
$patienttypesearch = $_REQUEST['patienttypesearch'];
$varpaymenttype = $_REQUEST['varpaymenttype'];

$locationcode = $_REQUEST['locationcode'];
//$medicinesearch = strtoupper($medicinesearch);
$subtype = $_REQUEST['subtype'];
//$medicinesearch = strtoupper($medicinesearch);
$searchresult3 = "";
$query13r = "select radtemplate from master_subtype where auto_number = '$subtype' order by subtype";
$exec13r = mysqli_query($GLOBALS["___mysqli_ston"], $query13r) or die ("Error in Query13r".mysqli_error($GLOBALS["___mysqli_ston"]));
$res13r = mysqli_fetch_array($exec13r);
$tablename = $res13r['radtemplate'];
if($tablename == '')
{
  $tablename = 'master_radiology';
}
$searchresult4 = "";
$query4 = "select * from $tablename where itemcode = '$radiologysearch'  order by itemname";
$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res4 = mysqli_fetch_array($exec4))
{
	$itemcode4 = $res4["itemcode"];
	$itemname4 = $res4["itemname"];
    $itemname4 = strtoupper($itemname4);
	$pkg = $res4['pkg'];
   /*if($varpaymenttype == 'INSURANCE')
	{
    $rateperunit4 = $res4["rate2"];
	}
	else if($varpaymenttype == 'MICRO INSURANCE')
	{
	$rateperunit4 = $res4["rate3"];
	}
	else
	{*/
	$rateperunit4 = $res4["rateperunit"];
	/*}*/
	
	if ($searchresult4 == '')
	{
	    $searchresult4 = ''.$itemcode4.'||'.$itemname4.'||'.$rateperunit4.'||'.$pkg.'||';
	}
	else
	{
		$searchresult4 = $searchresult4.'||^||'.$itemcode4.'||'.$itemname4.'||'.$rateperunit4.'||'.$pkg.'||';
	}
	
}
if ($searchresult4 != '')
{
 echo $searchresult4;
}
?>