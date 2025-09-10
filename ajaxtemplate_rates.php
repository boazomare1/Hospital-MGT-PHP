<?php
session_start();

if (!isset($_SESSION["username"])) header("location:index.php");

include "db/db_connect.php";

$username = $_SESSION['username'];
$docno1 = $_SESSION['docno'];

if (isset($_REQUEST["tablename"])) { $tablename = $_REQUEST["tablename"]; } else { $tablename = ""; }
if (isset($_REQUEST["get_rate"])) { $get_rate = $_REQUEST["get_rate"]; } else { $get_rate = ""; }
if (isset($_REQUEST["sno"])) { $sno = $_REQUEST["sno"]; } else { $sno = ""; }
if (isset($_REQUEST["itemcode"])) { $itemcode = $_REQUEST["itemcode"]; } else { $itemcode = ""; }
if (isset($_REQUEST["source"])) { $source = $_REQUEST["source"]; } else { $source = ""; }
if($source=='lab')
{
$query79 = "update $tablename set rateperunit = '$get_rate' where itemcode='$itemcode'";
$exec79 = mysqli_query($GLOBALS["___mysqli_ston"], $query79) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
}
?>

