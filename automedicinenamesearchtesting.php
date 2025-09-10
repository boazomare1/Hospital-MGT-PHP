<?php
session_start();
include ("db/db_connect.php");
$medicinenamesearch = $_REQUEST["medicinenamesearch"];
$searchresult41 = "";
$query41="select * from master_medicine where itemname like '%$medicinenamesearch%' order by itemname";
$exec41=mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($res41=mysqli_fetch_array($exec41))
{
	$itemcode41 = $res41["itemcode"];
	$itemname41 = $res41["itemname"];
    $itemname41 = strtoupper($itemname41);
    $rateperunit41 = $res41["rateperunit"];
	
	if ($searchresult41 == '')
	{
	    $searchresult41 = ''.$itemcode41.'||'.$itemname41.'||'.$rateperunit41.'||';
	}
	else
	{
		$searchresult41 = $searchresult41.'||^||'.$itemcode41.'||'.$itemname41.'||'.$rateperunit41.'||';
	}
	
}
if ($searchresult41 != '')
{
 echo $searchresult41;
}
?>

