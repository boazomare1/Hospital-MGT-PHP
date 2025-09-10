<?php
session_start();
include ("db/db_connect.php");
$errmsg1 = '';
$errmsg2 = '';
$errmsg3 = '';



	
$query1 = "select * from consultation_icd where age='0'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($res1=mysqli_fetch_array($exec1))
{
$visitcode = $res1['patientvisitcode'];

$query11 = "select * from master_visitentry where visitcode='$visitcode'";
$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res11 = mysqli_fetch_array($exec11);
$age = $res11['age'];

$query12 = "update consultation_icd set age='$age' where patientvisitcode='$visitcode'";
$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

}	


?>

