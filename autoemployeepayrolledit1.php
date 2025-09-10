<?php
session_start();
include ("db/db_connect.php");
$username = $_SESSION['username'];
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');

if (isset($_REQUEST["employeesearch"])) { $employeesearch = $_REQUEST["employeesearch"]; } else { $employeesearch = ""; }

$searchresult = "";
$totalloanamount = "";
$loanbuild = "";
$totalmonthpaid = "";
$totalafterinstallment = "";

//include("autoemployeepayrollcalculation1.php");

$query80 = "select * from payroll_assign where status <> 'deleted' and employeecode = '$employeesearch'";
$exec80 = mysqli_query($GLOBALS["___mysqli_ston"], $query80) or die ("Error in Query80".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res80 = mysqli_fetch_array($exec80))
{
	$employeecode = $res80['employeecode'];
	
	$query33 = "select componentname, auto_number, typecode from master_payrollcomponent where recordstatus <> 'deleted'";
	$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res33 = mysqli_fetch_array($exec33))
	{
		$componentanum = $res33['auto_number'];
		$componentname = $res33['componentname'];
		$typecode = $res33['typecode'];
		
		$query34 = "select `$componentanum` as componentvalue from payroll_assign where employeecode = '$employeesearch'";
		$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die ("Error in Query34".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res34 = mysqli_fetch_array($exec34);
		$componentvalue = $res34['componentvalue'];
		if($componentvalue > 0)
		{
		
			if($searchresult == "")
			{
				$searchresult = ''.$employeecode.'||'.$componentanum.'||'.$componentname.'||'.$componentvalue.'||'.$typecode.'';
			}	
			else
			{
				$searchresult = $searchresult.'||^||'.$employeecode.'||'.$componentanum.'||'.$componentname.'||'.$componentvalue.'||'.$typecode.'';
			}
		}
	}
}	
	
if ($searchresult != '')
{
	echo $searchresult;
}

?>