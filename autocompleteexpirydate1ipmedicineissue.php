<?php
session_start();
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$mrp = '0.00';

if (isset($_REQUEST["itemcode"])) { $itemcode = $_REQUEST["itemcode"]; } else { $itemcode = ""; }
//$itemcode = $_REQUEST["itemcode"];
if (isset($_REQUEST["batchnumber"])) { $batchnumber = $_REQUEST["batchnumber"]; } else { $batchnumber = ""; }
$batchnumber = trim($batchnumber);
//echo $batchnumber = $_REQUEST["batchnumber"];
if (isset($_REQUEST["rateapplyfrom"])) { $rateapplyfrom = $_REQUEST["rateapplyfrom"]; } else { $rateapplyfrom = ""; }
//$rateapplyfrom = $_REQUEST["rateapplyfrom"];
if (isset($_REQUEST["customercode"])) { $customercode = $_REQUEST["customercode"]; } else { $customercode = ""; }
//$customercode = $_REQUEST["customercode"];

$query2 = "select * from master_itempharmacy where itemcode = '$itemcode'";// and customerstatus = 'Active'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$res2anum = $res2["auto_number"];
$unitname = $res2["unitname_abbreviation"];
$itemcode = $res2["itemcode"];
$itemname = $res2["itemname"];
$categoryname = $res2["categoryname"];
$description = $res2["description"];
$res2taxanum = $res2["taxanum"];

$rateperunit = $res2["rateperunit"];
$mrp = $rateperunit;

	//Copied from autoitemsearch2.php / Called from autoitemsearch2.js / Stock alert in quotation is pending work.



$query5 = "select * from purchase_details where itemcode = '$itemcode' and batchnumber = '$batchnumber'";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
$res5 = mysqli_fetch_array($exec5);
$res5batchnumber = $res5['batchnumber'];
$res5expirydate = $res5['expirydate'];
$res5expirymonth = substr($res5expirydate, 5 , 2);
$res5expiryyear = substr($res5expirydate, 0, 4);
$expirydate = $res5expirymonth.'/'.$res5expiryyear;

if ($res2anum != '')
{
	//echo $rateperunit.'||'.$unitname.'||'.$itemcode.'||'.$res4taxpercent.'||'.$subtotal.'||'.$totalamount.'||'.$itemname.'||'.$categoryname.'||'.$description.'||'.$res2taxanum;
}

if ($res2anum != '')
{
	echo $expirydate;
}


?>