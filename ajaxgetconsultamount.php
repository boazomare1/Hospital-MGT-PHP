<?php
session_start();
if (!isset($_SESSION["username"])) header("location:index.php");
include "db/db_connect.php";
if (isset($_REQUEST["depid"])) { $depid = $_REQUEST["depid"]; } else { $depid = ""; }
$query10 ="select consultationfees from master_consultationtype where auto_number='$depid'";
$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
$res10 = mysqli_fetch_array($exec10);
$consultationfees = $res10['consultationfees'];
echo $consultationfees;

?>

