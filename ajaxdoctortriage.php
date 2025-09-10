<?php
//session_start();
include ("db/db_connect.php");

$genericname1 = $_REQUEST['genericname1'];
//echo $searchsuppliername1;
$stringbuild1 = "";

$query2 = "select * from master_doctor where doctorname like '%$genericname1%' and status = '' order by auto_number LIMIT 15";// order by subtype limit 0, 15";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
	$res2anum = $res2['auto_number'];
	$res2genericname = $res2['doctorname'];
	
	$res2genericname = addslashes($res2genericname);
	$res2genericname = strtoupper($res2genericname);
	$res2genericname = trim($res2genericname);
	$res2genericname = preg_replace('/,/', ' ', $res2genericname); // To avoid comma from passing on to ajax url.
	
	$query33 = "select * from master_employee where employeename='$res2genericname'";
	$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res33 = mysqli_fetch_array($exec33);
	$res2genericcode = $res33['username'];
	if ($stringbuild1 == '')
	{
		//$stringbuild1 = '"'.$res1customername.' #'.$res1customercode.'"';
		$stringbuild1 = ''.$res2genericname.'||'.$res2genericcode.'';
	}
	else
	{
		//$stringbuild1 = $stringbuild1.',"'.$res1customername.' #'.$res1customercode.'"';
		$stringbuild1 = $stringbuild1.','.$res2genericname.'||'.$res2genericcode.'';
	}
}

echo $stringbuild1;



?>