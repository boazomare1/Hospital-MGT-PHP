<?php
//session_start();
include ("db/db_connect.php");

$genericname1 = $_REQUEST['genericname1'];
//echo $searchsuppliername1;
$stringbuild1 = "";

$query2 = "select * from master_genericname where genericname like '%$genericname1%' and recordstatus = '' order by auto_number LIMIT 15";// order by subtype limit 0, 15";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
	$res2anum = $res2['auto_number'];
	$res2genericname = $res2['genericname'];
	$res2genericcode = $res2['genericcode'];
	$res2genericname = addslashes($res2genericname);
	$res2genericname = strtoupper($res2genericname);
	$res2genericname = trim($res2genericname);
	$res2genericname = preg_replace('/,/', ' ', $res2genericname); // To avoid comma from passing on to ajax url.
	
	if ($stringbuild1 == '')
	{
		//$stringbuild1 = '"'.$res1customername.' #'.$res1customercode.'"';
		$stringbuild1 = ''.$res2genericname.'';
	}
	else
	{
		//$stringbuild1 = $stringbuild1.',"'.$res1customername.' #'.$res1customercode.'"';
		$stringbuild1 = $stringbuild1.','.$res2genericname.'';
	}
}

echo $stringbuild1;



?>