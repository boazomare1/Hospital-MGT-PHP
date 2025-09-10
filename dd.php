<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
?>
<!--<form action="testtab.php" method="post" name="form1">
First Name: <input name="firstname" size="40" />
Last Name: <input name="lastname" size="40" />
</form>-->
<?php	
$query = "select * from master_radiologytemplate where auto_number = 7";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
$content = $res['templatedata'];
print $content;
?>
