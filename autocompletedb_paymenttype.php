<?php
//session_start();
include ("db/db_connect.php");

$paymenttypesearch=isset($_REQUEST['paymenttypesearch'])?$_REQUEST['paymenttypesearch']:'';

$stringbuild1 = "";
$query1 = "select * from master_paymenttype where  paymenttype like '%$paymenttypesearch%' and recordstatus = ''";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$res1paymenttype = $res1['paymenttype'];
	$res1autonumber = $res1['auto_number'];
	
	
	$res1paymenttype = addslashes($res1paymenttype);
	$res1autonumber = addslashes($res1autonumber);
	
	
	$res1paymenttype = strtoupper($res1paymenttype);
	$res1autonumber = strtoupper($res1autonumber);
	
	
	$res1paymenttype = trim($res1paymenttype);
	$res1autonumber = trim($res1autonumber);
	
	$res1paymenttype = preg_replace('/,/', ' ', $res1paymenttype);
	$res1autonumber = preg_replace('/,/', ' ', $res1autonumber);
	
	if ($stringbuild1 == '')
	{
		$stringbuild1 = '"'.$res1autonumber.'#'.$res1paymenttype.' "';
	}
	else
	{
		$stringbuild1 = $stringbuild1.',"'.$res1autonumber.'#'.$res1paymenttype.' "';
	}
}
echo $stringbuild1;







?>