<?php
session_start();
include ("db/db_connect.php");   

if (isset($_REQUEST["employeesearch"])) { $employeesearch = $_REQUEST["employeesearch"]; } else { $employeesearch = ""; }
if (isset($_REQUEST["assignmonth"])) { $assignmonth = $_REQUEST["assignmonth"]; } else { $assignmonth = ""; }
$searchresult = "";

$query2 = "select * from master_employee where (employeename like '%$employeesearch%' or employeecode like '%$employeesearch%') and payrollstatus = 'Prorata'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
		$employeecode = $res2['employeecode'];
		$employeename = $res2['employeename'];
		$payrollstatus = $res2['payrollstatus'];
		$doj = $res2['dateofjoining'];
		$enddate = date('Y-m-t', strtotime($doj));
		$from=date_create($doj);
		$to=date_create($enddate);
		$diff=date_diff($to,$from);
		//print_r($diff);
		$workdays = $diff->d;
		
	
		if ($searchresult == '')
		{
			$searchresult = ''.$employeecode.'||'.$employeename.'||'.$workdays;
		}
		else
		{
			$searchresult = $searchresult.'||^||'.$employeecode.'||'.$employeename.'||'.$workdays;
		}
	
	//}
	
}

if ($searchresult != '')
{
	echo $searchresult;
}

?>