<?php
session_start();
include ("db/db_connect.php");
$username = $_SESSION['username'];
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');

if (isset($_REQUEST["employeesearch"])) { $employeesearch = $_REQUEST["employeesearch"]; } else { $employeesearch = ""; }
if (isset($_REQUEST["assignmonth"])) { $assignmonth = $_REQUEST["assignmonth"]; } else { $assignmonth = ""; }

$searchresult = "";
$totalloanamount = "";
$loanbuild = "";
$totalmonthpaid = "";
$totalafterinstallment = "";
$res23rate = '0.00';
$res23unit = '0.00';
$res23amount = '0.00';

include("autoemployeepayrollcalculation1.php");

$query21 = "select * from payroll_assign where employeecode = '$employeesearch' and monthly = 'Yes' and status <> 'deleted' order by type desc";
$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res21 = mysqli_fetch_array($exec21))
{
	$anum = $res21['auto_number'];
	$res21componentanum = $res21['componentanum'];
	$res21employeecode = $res21['employeecode'];
	$res21employeename = $res21['employeename'];
	$res21componentname = $res21['componentname'];
	$res21componentvalue = $res21['componentvalue'];
	$res21componentamount = $res21['componentamount'];
	$res21amounttype = $res21['amounttype'];
	$typecode = $res21['typecode'];
	if($typecode == 20)
	{
		$typecodebgcolor = "#FF0000";
		$type = 'D';
	}
	else
	{
		$typecodebgcolor = "#00CC00";
		$type = 'E';
	}	
		
	$query23 = "select * from payroll_assignmonthwise where employeecode = '$res21employeecode' and componentanum = '$res21componentanum' and assignmonth = '$assignmonth' and status <> 'deleted'";
	$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res23 = mysqli_fetch_array($exec23);
	$res23employeecode = $res23['employeecode'];
	if($res23employeecode != '')
	{
		$res23rate = $res23['rate'];
		$res23unit = $res23['unit'];
		$res23amount = $res23['amount'];
	}
		
	if ($searchresult == '')
	{
		$searchresult = ''.$res21componentanum.'||'.$res21employeecode.'||'.$res21employeename.'||'.$res21componentname.'||'.$res21componentamount.'||'.$res21amounttype.'||'.$typecodebgcolor.'||'.$type.'||'.$res23unit.'||'.$res23amount.'';
	}
	else
	{
		$searchresult = $searchresult.'||^||'.$res21componentanum.'||'.$res21employeecode.'||'.$res21employeename.'||'.$res21componentname.'||'.$res21componentamount.'||'.$res21amounttype.'||'.$typecodebgcolor.'||'.$type.'||'.$res23unit.'||'.$res23amount.'';
	}
	
}

if ($searchresult != '')
{
	echo $searchresult;
}

?>