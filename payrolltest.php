<?php
session_start();
$pagename = '';
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION['username'])) header ("location:index.php");
include ("db/db_connect.php");

$query = "select * from payroll_assign1 where employeecode <> '' group by employeecode";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query);
while($res = mysqli_fetch_array($exec))
{
	$empcode = $res['employeecode'];
	$empname = $res['employeename'];
	
	//$query6 = "insert into payroll_assign (employeecode, employeename) values ('$empcode','$empname')";
	//$exec6 = mysql_query($query6);
	
	$query1 = "select * from payroll_assign1 where employeecode = '$empcode'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	while($res1 = mysqli_fetch_array($exec1))
	{
		$anum = $res1['componentanum'];
		$amount = $res1['componentvalue'];
		
		$anum.' => '.$amount;
		
		echo '<br>'.$query6 = "update payroll_assign set `$anum` = '$amount' where employeecode = '$empcode'";
		//$exec6 = mysql_query($query6);
	}
}
?>