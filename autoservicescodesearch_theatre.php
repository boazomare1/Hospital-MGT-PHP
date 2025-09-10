<?php
session_start();
include ("db/db_connect.php");
$servicessearch = $_REQUEST["servicessearch"];
$patienttypesearch = $_REQUEST['patienttypesearch'];
$varpaymenttype = $_REQUEST['varpaymenttype'];
//$medicinesearch = strtoupper($medicinesearch);

$patientcode = $_REQUEST['patientcode'];
$locationcode = $_REQUEST['locationcode'];
$searchresult5 = "";

$subtype = $_REQUEST['subtype'];
//$medicinesearch = strtoupper($medicinesearch);
$searchresult3 = "";

$query12s = "select sertemplate from master_subtype where auto_number = '$subtype' order by subtype";
$exec12s = mysqli_query($GLOBALS["___mysqli_ston"], $query12s) or die ("Error in Query12s".mysqli_error($GLOBALS["___mysqli_ston"]));
$res12s = mysqli_fetch_array($exec12s);
//$tablenames = $res12s['sertemplate'];


$query13s = "select sertemplate from master_subtype where auto_number = '$subtype' order by subtype";
$exec13s = mysqli_query($GLOBALS["___mysqli_ston"], $query13s) or die ("Error in Query13s".mysqli_error($GLOBALS["___mysqli_ston"]));
$res13s = mysqli_fetch_array($exec13s);
$tablenames = $res13s['sertemplate'];
if($tablenames == '')
{
  $tablenames = 'master_services';
}

$query5 = "select * from $tablenames where itemcode = '$servicessearch' AND locationcode = '".$locationcode."' order by itemname";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res5 = mysqli_fetch_array($exec5))
{
	$itemcode5 = $res5["itemcode"];
	$itemname5 = $res5["itemname"];
    $itemname5 = strtoupper($itemname5);
	
	$pkg = $res5['pkg'];
  /* if($varpaymenttype == 'INSURANCE')
	{
    $rateperunit5 = $res5["rate2"];
	}
	else if($varpaymenttype == 'MICRO INSURANCE')
	{
	 $rateperunit5 = $res5["rate3"];
	}
	else
	{*/
	$rateperunit5 = $res5["rateperunit"];
	$baseunit5 = $res5["baseunit"];
	$incrementalquantity5 = $res5["incrementalquantity"];
	$incrementalrate5 = $res5["incrementalrate"];
	$slab5 = $res5["slab"];
	/*}*/
	
	
	if ($searchresult5 == '')
	{
	    $searchresult5 = ''.$itemcode5.'||'.$itemname5.'||'.$rateperunit5.'||'.$baseunit5.'||'.$incrementalquantity5.'||'.$incrementalrate5.'||'.$slab5.'||'.$pkg.'||';
	}
	else
	{
		$searchresult5 = $searchresult5.'||^||'.$itemcode5.'||'.$itemname5.'||'.$rateperunit5.'||'.$baseunit5.'||'.$incrementalquantity5.'||'.$incrementalrate5.'||'.$slab5.'||'.$pkg.'||';
	}
	
}
if ($searchresult5 != '')
{
 echo $searchresult5;
}
?>