<?php
session_start();
include ("db/db_connect.php");
$categorylabsearch = $_REQUEST["categorylabsearch"];
$categoryrate=0;
//$medicinesearch = strtoupper($medicinesearch);
$searchresult33 = "";
$query3 = "select * from master_categorylab where auto_number = '$categorylabsearch' order by categoryname";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res3 = mysqli_fetch_array($exec3))
{
	
	$itemcode33 = $res3["auto_number"];
	$itemname33= $res3["categoryname"];
    $itemname33= strtoupper($itemname33);
	$query33="select * from master_lab where categoryname='$itemname33' and status <> 'deleted'";
	$exec33=mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res33=mysqli_fetch_array($exec33))
	{
	$itemrate=$res33['rateperunit'];
	$categoryrate=$categoryrate+$itemrate;
	}
    $rateperunit33 = $categoryrate;
	$rateperunit33=number_format($rateperunit33,2,'.','');
	
	if ($searchresult33 == '')
	{
	    $searchresult33 = ''.$itemcode33.'||'.$itemname33.'||'.$rateperunit33.'||';
	}
	else
	{
		$searchresult33 = $searchresult33.'||^||'.$itemcode33.'||'.$itemname33.'||'.$rateperunit33.'||';
	}
	
}
if ($searchresult33 != '')
{
 echo $searchresult33;
}
?>