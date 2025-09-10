<?php
include ("db/db_connect.php");
$amount1 = 0;
$amount2 = 0;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = "2016-11-01"; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = "2016-11-30"; }
if (isset($_REQUEST["billno"])) { $billno = $_REQUEST["billno"]; } else { $billno = ""; }

if($billno != '')
{
	$query1 = "UPDATE `billing_ip` SET totalamount = '0', totalrevenue = '0', discount = '0', deposit = '0', totalamountuhx = '0' WHERE billno = '$billno'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query2 = "UPDATE `master_transactionip` SET transactionamount = '0', totalamountuhx = '0' WHERE billnumber = '$billno' and transactiontype = 'finalize'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query3 = "UPDATE `master_transactionpaylater` SET transactionamount = '0', billbalanceamount = '0', billamount = '0', fxamount = '0' WHERE billnumber = '$billno' and transactiontype = 'finalize'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query = "DELETE FROM `billing_ipadmissioncharge` WHERE docno = '$billno'";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in query".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query = "DELETE FROM `billing_ipambulance` WHERE docno = '$billno'";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in query".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query = "DELETE FROM `billing_ipbedcharges` WHERE docno = '$billno'";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in query".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query = "DELETE FROM `billing_iplab` WHERE billnumber = '$billno'";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in query".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query = "DELETE FROM `billing_ipmiscbilling` WHERE docno = '$billno'";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in query".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query = "DELETE FROM `billing_iphomecare` WHERE docno = '$billno'";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in query".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query = "DELETE FROM `billing_ippharmacy` WHERE billnumber = '$billno'";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in query".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query = "DELETE FROM `billing_ipprivatedoctor` WHERE docno = '$billno'";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in query".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query = "DELETE FROM `billing_ipradiology` WHERE billnumber = '$billno'";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in query".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query = "DELETE FROM `billing_ipservices` WHERE billnumber = '$billno'";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in query".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query = "DELETE FROM `billing_ipnhif` WHERE docno = '$billno'";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in query".mysqli_error($GLOBALS["___mysqli_ston"]));
}
?>