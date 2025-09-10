<?php
session_start();
error_reporting(0);
include ("db/db_connect.php");

if (isset($_REQUEST["storecode"])) {  $storecode = $_REQUEST["storecode"]; } else { $storecode = ""; }
if (isset($_REQUEST["locationcode"])) {  $locationcode = $_REQUEST["locationcode"]; } else { $locationcode = ""; }

//$query = "select storecode from master_store  where locationcode = '".$locationcode."' and storecode='".$storecode."' and is_freeze=1";
$query = "select storecode from master_store  where storecode='".$storecode."' and is_freeze=1";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$num1 = mysqli_num_rows($exec); 
if($num1>0)
  echo '1';
else
  echo '0';
?>