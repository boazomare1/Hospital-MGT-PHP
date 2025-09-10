<?php
session_start();
include ("db/db_connect.php");
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$nationalidnumber = trim($_REQUEST["nationalidnumber"]);
$consultationdate = date('Y-m-d');
$numrows=0;

	$query5 = "select * from master_customer where nationalidnumber = '$nationalidnumber'";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$numrows = mysqli_num_rows($exec5);  
	
	$searchresult = ''.$numrows.'';
	
if ($searchresult != '')
{
	echo $searchresult;
}
?>