<?php
session_start();
include ("db/db_connect.php");
$companyanum = $_SESSION['companyanum'];
$searchtostore1 = $_REQUEST['searchtostore1'];
$locationanum = $_REQUEST['location'];

$stringbuild1 = "";
$query2 = "select * from master_store where location = '$locationanum' and recordstatus <> 'Deleted' order by store limit 0, 15";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
	//$res2itemcode = $res2['itemcode'];
	$res2store = $res2['store'];
	
	$res2store = addslashes($res2store);

	$res2store = strtoupper($res2store);
	
	$res2store = trim($res2store);
	
	$res2store = preg_replace('/,/', ' ', $res2store); // To avoid comma from passing on to ajax url.
	
	if ($stringbuild1 == '')
	{
		//$stringbuild1 = '"'.$res1customername.' #'.$res1customercode.'"';
		$stringbuild1 = ''.$res2store.'';
	}
	else
	{
		//$stringbuild1 = $stringbuild1.',"'.$res1customername.' #'.$res1customercode.'"';
		$stringbuild1 = $stringbuild1.','.$res2store.'';
	}
}

echo $stringbuild1;



?>