<?php
//session_start();
include ("db/db_connect.php");

$itemname = $_REQUEST['itemname'];

$stringbuild2 = "";
$query1 = "select * from master_medicine where itemname like '%$itemname%' and status <> 'deleted' order by categoryname limit 0,20";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$citemcode = $res1["itemcode"];
	$citemcode = strtoupper($citemcode);
	$citemname = $res1["itemname"];
	$citemname = strtoupper($citemname);

	$ccategoryname = $res1["categoryname"];
	$citemname = stripslashes($citemname);
	$citemname = preg_replace('/,/', ' ', $citemname);
	$citemname = preg_replace ('/["]/i','\"', $citemname);
	$citemname = preg_replace ("/[']/i","\'", $citemname);
	if ($stringbuild2 == '')
	{
		//$stringbuild2 = '"'.$citemcode.' || '.$citemname.' || '.$citemstock.'"';
		$stringbuild2 = $citemcode.'||'.$citemname.''; //.' || '.$citemstock.'"';
	}
	else
	{
		$stringbuild2 = $stringbuild2.','.$citemcode.'||'.$citemname.'';
	}
}

echo $stringbuild2;

?>
