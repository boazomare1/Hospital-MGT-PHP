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
	
	$query231 = "select * from master_employeelocation where username='$username' and defaultstore='default'";
$exec231 = mysqli_query($GLOBALS["___mysqli_ston"], $query231) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res231 = mysqli_fetch_array($exec231);
$res7locationanum1 = $res231['locationcode'];

/*$query551 = "select * from master_location where auto_number='$res7locationanum1'";
$exec551 = mysql_query($query551) or die(mysql_error());
$res551 = mysql_fetch_array($exec551);*/
$location = $res231['locationname'];

$res7storeanum1 = $res231['storecode'];

$query751 = "select * from master_store where auto_number='$res7storeanum1'";
$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res751 = mysqli_fetch_array($exec751);
$store = $res751['store'];
	
	$itemcode = $itemcode;
//	include ('autocompletestockcount1include1.php');

if($location!="" && $res7storeanum1!=""){
  $querybatstock2 = "select sum(batch_quantity) as batch_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$location' and storecode ='$res7storeanum1'";	
}else{
	$querybatstock2 = "select sum(batch_quantity) as batch_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode'";
}
$execbatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querybatstock2) or die ("Error in batQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
$resbatstock2 = mysqli_fetch_array($execbatstock2);
$bat_quantity = $resbatstock2["batch_quantity"];

	$currentstock = $bat_quantity;
	
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