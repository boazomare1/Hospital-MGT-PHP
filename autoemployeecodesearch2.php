<?php
session_start();
include ("db/db_connect.php");

if (isset($_REQUEST["employeesearch"])) { $employeesearch = $_REQUEST["employeesearch"]; } else { $employeesearch = ""; }
$searchresult = "";

$query2 = "select * from master_employee where employeecode = '$employeesearch'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
	$employeecode = $res2['employeecode'];
	$employeename = $res2['employeename'];
	$locationanum = $res2['location'];
	$storeanum = $res2['store'];
	$shift = $res2['shift'];
	$jobdescription = $res2['jobdescription'];
	$gender = '';
	$dob = '';
	$doj = '';
	$employmenttype = '';
	$firstjobinkenya = '';
	$overtime = '';
	$nationality = '';
	$category = '';
	
	$query3 = "select * from master_location where auto_number = '$locationanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$location = $res3['locationname'];
	
	$query4 = "select * from master_store where auto_number = '$storeanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$store = $res4['store'];
	
	if ($searchresult == '')
	{
		$searchresult = ''.$employeecode.'||'.$employeename.'||'.$location.'||'.$store.'||'.$shift.'||'.$jobdescription.'||'.$gender.'||'.$dob.'||'.$doj.'||'.$employmenttype.'||'.$firstjobinkenya.'||'.$overtime.'||'.$nationality.'||'.$category.'';
	}
	else
	{
		$searchresult = $searchresult.'||^||'.$employeecode.'||'.$employeename.'||'.$location.'||'.$store.'||'.$shift.'||'.$jobdescription.'||'.$gender.'||'.$dob.'||'.$doj.'||'.$employmenttype.'||'.$firstjobinkenya.'||'.$overtime.'||'.$nationality.'||'.$category.'';
	}
	
}

if ($searchresult != '')
{
	echo $searchresult;
}

?>