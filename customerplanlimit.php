<?php
session_start();
include ("db/db_connect.php");
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$planname = $_REQUEST["planname"];

$consultationdate = date('Y-m-d');
//$customersearch = strtoupper($customersearch);
$searchresult = "";
$availablelimit = "";

	
	$query5 = "select * from master_planname where auto_number = '$planname'";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res5 = mysqli_fetch_array($exec5);  
	//$plannameanum = $res4['auto_number'];
	$res4planname = $res5['planname'];
	$res4planstatus = $res5['recordstatus'];
	$res4planfixedamount = $res5['planfixedamount'];
	$res4planpercentage = $res5['planpercentage'];
	$res4smartap = $res5['smartap'];
	$planapplicable = $res5['planapplicable'];

	$planstartdate = $res5["planstartdate"];
	$planexpirydate = $res5["planexpirydate"];
	$opvisitlimit = $res5["opvisitlimit"];
	$opoveralllimit = $res5["overalllimitop"];
	$ipvisitlimit = $res5["ipvisitlimit"];
	$ipoveralllimit = $res5["overalllimitip"];
	
	$searchresult = ''.$planexpirydate.'|'.$res4planfixedamount.'|'.$res4planpercentage.'|'.$opvisitlimit.'|'.$opoveralllimit.'|'.$ipvisitlimit.'|'.$ipoveralllimit.'|'.$res4planstatus.'';

	
if ($searchresult != '')
{
	echo $searchresult;
}

?>
