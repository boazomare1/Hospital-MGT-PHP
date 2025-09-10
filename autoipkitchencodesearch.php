<?php
session_start();
include ("db/db_connect.php");
$labsearch = $_REQUEST["typecode"];
//$patienttypesearch = $_REQUEST['patienttypesearch'];
//$varpaymenttype = $_REQUEST['varpaymenttype'];

$locationcode = $_REQUEST['locationcode'];
//$medicinesearch = strtoupper($medicinesearch);
$searchresult3 = "";
$query3 = "select * from master_ipkitchen where typecode = '$labsearch' and recordstatus <> 'deleted' AND locationcode = '".$locationcode."' order by typename";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res3 = mysqli_fetch_array($exec3))
{
	$itemcode1 = $res3["typecode"];
	$itemname1 = $res3["typename"];
    $itemname1 = strtoupper($itemname1);
	//$externallab = $res3['externallab'];
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
	$rateperunit1 = $res3["rate"];
	
	$description = $res3["description"];
	$calories = $res3["calories"];
	//$rateperunit1 = $res3["rate"];
	/*}*/
	
	
	if ($searchresult3 == '')
	{
	    $searchresult3 = ''.$itemcode1.'||'.$itemname1.'||'.$rateperunit1.'||'.$description.'||'.$calories.'||';
	}
	else
	{
		$searchresult3 = $searchresult3.'||^||'.$itemcode1.'||'.$itemname1.'||'.$rateperunit1.'||'.$description.'||'.$calories.'||';
	}
	
}
if ($searchresult3 != '')
{
 echo $searchresult3;
}
?>