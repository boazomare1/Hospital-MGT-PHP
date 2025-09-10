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

if (isset($_REQUEST["account"])) { $account = $_REQUEST["account"]; } else { $account = ""; }
//$billnumber=$_REQUEST["billnumber"];
$query4 = "select * from master_accountname where auto_number = '$account'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	//$accountnameanum = $res4['auto_number'];
	$res4accountname = $res4['accountname'];

$query2 = "select * from master_accountname where recordstatus = 'DELETED' and accountname = '$res4accountname'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_num_rows($exec2);

if ($res2 == 0)
{
	$accountstatus = 'NOT IN RECORD';
}
else
{
	$accountstatus = 'ID FOUND';
}

echo $accountstatus;

?>
