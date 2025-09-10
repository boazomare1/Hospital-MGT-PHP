<?php
session_start();

if (!isset($_SESSION["username"])) header("location:index.php");

include "db/db_connect.php";
$updatedate = date('Y-m-d');
$ipaddress = $_SERVER['REMOTE_ADDR'];
$username = $_SESSION['username'];
$docsession = $_SESSION['docno'];
if (isset($_REQUEST["auto_number"])) {$auto_number = $_REQUEST["auto_number"]; } else { $auto_number = ""; }
if (isset($_REQUEST["avail_limit"])) {$avail_limit = $_REQUEST["avail_limit"]; } else { $avail_limit = ""; }
if (isset($_REQUEST["visit_limit"])) {$visit_limit = $_REQUEST["visit_limit"]; } else { $visit_limit = ""; }
$medicinequery2="update master_visitentry set availablelimit='$avail_limit',visitlimit='$visit_limit' where auto_number='$auto_number'";
$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
?>

