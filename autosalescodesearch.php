<?php
session_start();
include ("db/db_connect.php");
$medicinesearch = $_REQUEST["medicinesearch"];

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
	$formula = $res2['formula'];
	$strength = $res2['roq'];
	$genericname = $res2['genericname'];
	if ($searchresult2 == '')
	{
	    $searchresult2 = ''.$itemcode.'||'.$itemname.'||'.$rateperunit.'||'.$formula.'||'.$strength.'||'.$genericname.'||';
	}
	else
	{
		$searchresult2 = $searchresult2.'||^||'.$itemcode.'||'.$itemname.'||'.$rateperunit.'||'.$formula.'||'.$strength.'||'.$genericname.'||';
	}
	
}
if ($searchresult2 != '')
{
 echo $searchresult2;
}
?>