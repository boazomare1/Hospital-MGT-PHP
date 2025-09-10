<?php
session_start();

include ("db/db_connect.php");
include ("includes/loginverify.php");

$insure = "";

if (isset($_REQUEST["membernos"])) { 

$memberno = $_REQUEST["membernos"]; 

$queryvalid = "select * from member_insurance where membernumber = '$memberno';";
$execvalid = mysqli_query($GLOBALS["___mysqli_ston"], $queryvalid) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$resvaild = mysqli_fetch_array($execvalid);

$insure = $resvaild['insurance'];
$fname = $resvaild['firstname'];
$lname = $resvaild['lastname'];
$poilcy = $resvaild['policyholder'];

$values = $insure.'||'.$fname.' '.$lname.'||'.$poilcy;

echo $values;

}
?>