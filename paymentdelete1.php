<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION[username];
$companyanum = $_SESSION[companyanum];
$companyname = $_SESSION[companyname];

//$task = $_REQUEST[task];
//$anum = $_REQUEST[anum];

if (isset($_REQUEST["task"])) { $task1 = $_REQUEST["task"]; } else { $task1 = ""; }
if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }

if ($task1 == 'delete' && $anum != '')
{
	$query1 = "update master_transactionpharmacy set recordstatus = 'DELETED' where auto_number = '$anum'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
}

header ("location:paymentgiven1.php?task=deleted");

?>