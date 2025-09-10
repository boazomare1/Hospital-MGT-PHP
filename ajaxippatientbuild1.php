<?php
//session_start();
include ("db/db_connect.php");

$searchsuppliername1 = $_REQUEST['searchsuppliername'];

$stringbuild1 = "";
$query1 = "select * from master_ipvisitentry where patientfullname like '%$searchsuppliername1%' or patientcode like '%$searchsuppliername1%' or visitcode like '%$searchsuppliername1' and recordstatus = '' group by visitcode order by auto_number desc limit 0,10";// order by subtype limit 0, 15";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$res1customercode = $res1['patientcode'];
	$res1visitcode = $res1['visitcode'];
	$res1customername = $res1['patientfirstname'];
	$res1customerfullname=$res1['patientfullname'];
	
	$res1customercode = addslashes($res1customercode);
	$res1visitcode = addslashes($res1visitcode);
	$res1customername = addslashes($res1customername);
	$res1customerfullname=addslashes($res1customerfullname);
	
	$res1customercode = strtoupper($res1customercode);
	$res1visitcode = strtoupper($res1visitcode);
	$res1customername = strtoupper($res1customername);
	$res1customerfullname=strtoupper($res1customerfullname);
	
	$res1customercode = trim($res1customercode);
	$res1visitcode = trim($res1visitcode);
	$res1customername = trim($res1customername);
	
	$res1customercode = preg_replace('/,/', ' ', $res1customercode);
	$res1visitcode = preg_replace('/,/', ' ', $res1visitcode);
	$res1customername = preg_replace('/,/', ' ', $res1customername);
	
	if ($stringbuild1 == '')
	{
		$stringbuild1 = $res1customerfullname.'#'.$res1customercode.'#'.$res1visitcode;
	}
	else
	{
		$stringbuild1 = $stringbuild1.','.$res1customerfullname.'#'.$res1customercode.'#'.$res1visitcode;
	}
	
}

echo $stringbuild1;



?>