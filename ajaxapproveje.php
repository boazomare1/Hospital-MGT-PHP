<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$docno = $_SESSION['docno'];
$companyname = $_SESSION['companyname'];
$colorloopcount = 0;

if(isset($_REQUEST['code'])){$code = $_REQUEST['code'];}else{$code='';}


		$query67 = "update master_journalentries set approve_je='1' where docno = '$code' ";
		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die ("Error in Query67".mysqli_error($GLOBALS["___mysqli_ston"]));
		echo "Approved successfully.";

?>