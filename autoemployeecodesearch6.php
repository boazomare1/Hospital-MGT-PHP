<?php
session_start();
include ("db/db_connect.php");

if (isset($_REQUEST["employeesearch"])) { $employeesearch = $_REQUEST["employeesearch"]; } else { $employeesearch = ""; }
if (isset($_REQUEST["assignmonth"])) { $assignmonth = $_REQUEST["assignmonth"]; } else { $assignmonth = ""; }
$searchresult = "";


$query3 = "select * from details_employeepayroll where (employeecode like '%$employeesearch%' or employeename like '%$employeesearch%') and paymonth = '$assignmonth' and status <> 'deleted' group by employeecode";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res3 = mysqli_fetch_array($exec3))
{
	$res3employeecode = $res3['employeecode'];

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
	

if ($searchresult != '')
{
	echo $searchresult;
}

?>