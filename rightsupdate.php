<?php
session_start();
include ("db/db_connect.php");
$errmsg1 = '';
$errmsg2 = '';
$errmsg3 = '';

$query5 = "select * from master_employee where auto_number > '201'";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($res5 = mysqli_fetch_array($exec5))
{
$usernam = $res5['username'];
$password = $res5['password'];
$password1 = base64_encode($password);

$query51 = "update master_employee set password ='$password1' where username='$usernam'";
$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
}


?>
