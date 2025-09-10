<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");

$username = $_SESSION["username"];

$companyanum = $_SESSION["companyanum"];

$companycode = $_SESSION['companycode'];

$companyname = $_SESSION["companyname"];



if(isset($_REQUEST['callfrom'])) { $callfrom = $_REQUEST['callfrom']; } else { $callfrom = ''; }

if(isset($_REQUEST['assignmonth'])) { $assignmonth = $_REQUEST['assignmonth']; } else { $assignmonth = ''; }





$query777 = "select * from details_employeepayroll where paymonth = '$assignmonth' and status <> 'deleted'";

$exec777 = mysqli_query($GLOBALS["___mysqli_ston"], $query777) or die ("Error in Query777".mysqli_error($GLOBALS["___mysqli_ston"]));

$res777 = mysqli_fetch_array($exec777);

$res777paymonth = $res777['paymonth'];



if($res777paymonth == '')

{  

	echo $result = "Process||".$callfrom."";

}

else

{
	echo $result = "Process||".$callfrom."";
	//echo $result = "Denied||".$callfrom.""; 

}