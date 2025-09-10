<?php
session_start();
include ("db/db_connect.php");
$companyanum = $_SESSION['companyanum'];
$username = $_SESSION['username'];
$searchmedicinename1 = $_REQUEST['searchmedicinename1'];

$stringbuild1 = "";
/*$query23 = "select * from master_employee where username='$username'";
$exec23 = mysql_query($query23) or die(mysql_error());
$res23 = mysql_fetch_array($exec23);
$res7locationanum = $res23['location'];*/
/*$query23 = "select * from master_employeelocation where username='$username'";
$exec23 = mysql_query($query23) or die(mysql_error());
$res23 = mysql_fetch_array($exec23);
$res7locationanum = $res23['locationcode'];
$locationcode=$res23['locationcode'];


$query55 = "select * from master_location where auto_number='$res7locationanum'";
$exec55 = mysql_query($query55) or die(mysql_error());
$res55 = mysql_fetch_array($exec55);
$location = $res55['locationname'];

$res7storeanum = $res23['storecode'];*/
$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
$storecode=isset($_REQUEST['storecode'])?$_REQUEST['storecode']:'';
$res7storeanum=$storecode;
$query75 = "select * from master_store where auto_number='$res7storeanum'";
$exec75 = mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res75 = mysqli_fetch_array($exec75);
$store = $res75['store'];
$query222 = "select * from master_medicine where itemname like '%$searchmedicinename1%' and pkg='yes' and status <> 'Deleted'";
$exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res222 = mysqli_fetch_array($exec222))
{
	$res2itemcode = $res222['itemcode'];
	$res2medicine = $res222['itemname'];
	$disease = $res222['disease'];
	$itemcode = $res2itemcode;
	include ('autocompletestockcount1include1.php');
	$currentstock = $currentstock;
	
	$res2medicine = addslashes($res2medicine);

	$res2medicine = strtoupper($res2medicine);
	
	$res2medicine = trim($res2medicine);
	
	$res2medicine = preg_replace('/,/', ' ', $res2medicine); // To avoid comma from passing on to ajax url.
	
	if ($stringbuild1 == '')
	{
		//$stringbuild1 = '"'.$res1customername.' #'.$res1customercode.'"';
		$stringbuild1 = ''.$res2itemcode.' ||'.$res2medicine.' ||'.$currentstock.'';
	}
	else
	{
		//$stringbuild1 = $stringbuild1.',"'.$res1customername.' #'.$res1customercode.'"';
		$stringbuild1 = $stringbuild1.','.$res2itemcode.' ||'.$res2medicine.' ||'.$currentstock.'';
	}
}

echo $stringbuild1;



?>