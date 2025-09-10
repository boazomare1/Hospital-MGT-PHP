<?php
session_start();
include ("db/db_connect.php");
$companyanum = $_SESSION['companyanum'];
$username = $_SESSION["username"];
$searchbed1 = $_REQUEST['searchbed1'];
$searchward = $_REQUEST['ward'];

$stringbuild1 = "";

$query2 = "select * from master_bed where ward='$searchward' and recordstatus <> 'Deleted' order by bed limit 0, 15";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
	
	$bed = $res2['bed'];
	
	$bed = addslashes($bed);

	$bed = strtoupper($bed);
	
	$bed = trim($bed);
	
	$bed = preg_replace('/,/', ' ', $bed); // To avoid comma from passing on to ajax url.
	
	if ($stringbuild1 == '')
	{
		//$stringbuild1 = '"'.$res1customername.' #'.$res1customercode.'"';
		$stringbuild1 = ''.$bed.'';
	}
	else
	{
		//$stringbuild1 = $stringbuild1.',"'.$res1customername.' #'.$res1customercode.'"';
		$stringbuild1 = $stringbuild1.','.$bed.'';
	}
}

echo $stringbuild1;



?>