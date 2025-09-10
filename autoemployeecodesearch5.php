<?php
session_start();
include ("db/db_connect.php"); 

$docno = $_SESSION['docno'];
$username = $_SESSION['username'];

$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$locationname = $res1["locationname"];
$locationcode = $res1["locationcode"];  

if (isset($_REQUEST["employeesearch"])) { $employeesearch = $_REQUEST["employeesearch"]; } else { $employeesearch = ""; }
if (isset($_REQUEST["assignmonth"])) { $assignmonth = $_REQUEST["assignmonth"]; } else { $assignmonth = ""; }
$searchresult = "";

/*$query2 = "select * from master_employeelocation where locationcode = '$locationcode' group by employeecode";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
while ($res2 = mysql_fetch_array($exec2))
{
	$res2employeecode = $res2['employeecode'];
	//$res2employeename = $res2['employeename'];
*/	
$query3 = "select * from master_employee where employeename like '%$employeesearch%' and payrollstatus <> 'Inactive'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res3 = mysqli_fetch_array($exec3))
{
	$res3employeecode = $res3['employeecode'];
	if($res3employeecode != '')	
	{
		$employeecode = $res3['employeecode'];
		$employeename = $res3['employeename'];
	
	
		if ($searchresult == '')
		{
			$searchresult = ''.$employeecode.'||'.$employeename.'';
		}
		else
		{
			$searchresult = $searchresult.'||^||'.$employeecode.'||'.$employeename.'';
		}
	
	}
	
}

if ($searchresult != '')
{
	echo $searchresult;
}

?>