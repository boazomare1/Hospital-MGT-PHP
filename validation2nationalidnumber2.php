<?php
session_start();

include ("db/db_connect.php");
//include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly=date("Y-m-d");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
//$financialyear = $_SESSION["financialyear"];

if (isset($_REQUEST["nationalidnumber"])) { $nationalidnumber = $_REQUEST["nationalidnumber"]; } else { $nationalidnumber = ""; }
//$billnumber=$_REQUEST["billnumber"];

$query2 = "select * from master_customer where status = '' and nationalidnumber = '$nationalidnumber'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_num_rows($exec2);

if ($res2 == 0)
{
	$nationalidstatus = 'NOT IN RECORD';
}
else
{
	$nationalidstatus = 'ID FOUND';
}

echo $nationalidstatus;

?>
