<?php
session_start();
//Called from sales1.php - autoitemsearch2.js
//Item rate called from previous bill entry is done here.

include ("db/db_connect.php");
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$companycode = $_SESSION['companycode'];
$receiptmainanum=$_REQUEST["receiptmainanum"];
	$searchresult = '';

	$query1 = "select * from master_receiptsub where receiptmainanum = '$receiptmainanum' and status <> 'deleted'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1.city".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res1 = mysqli_fetch_array($exec1))
	{
	 $receiptsubanum = $res1['auto_number'];
	 $receiptsubname = $res1['receiptsubname'];

	if ($searchresult == '')
	{
		 $searchresult = ''.$receiptsubanum.'||'.$receiptsubname.'';
	}
	else
	{
		$searchresult = $searchresult.'||^||'.$receiptsubanum.'||'.$receiptsubname.'';
	}
	}
	
	if ($searchresult != '')
	{
		echo  $searchresult;
	}

?>