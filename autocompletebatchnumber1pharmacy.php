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
//echo $batchnumber = $_REQUEST["batchnumber"];
if (isset($_REQUEST["rateapplyfrom"])) { $rateapplyfrom = $_REQUEST["rateapplyfrom"]; } else { $rateapplyfrom = ""; }
//$rateapplyfrom = $_REQUEST["rateapplyfrom"];
if (isset($_REQUEST["customercode"])) { $customercode = $_REQUEST["customercode"]; } else { $customercode = ""; }
//$customercode = $_REQUEST["customercode"];
$query23 = "select * from master_employee where username='$username'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res23 = mysqli_fetch_array($exec23);
$res7locationanum = $res23['location'];

$query55 = "select * from master_location where auto_number='$res7locationanum'";
$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res55 = mysqli_fetch_array($exec55);
$location = $res55['locationname'];

$res7storeanum = $res23['store'];

$query75 = "select * from master_store where auto_number='$res7storeanum'";
$exec75 = mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res75 = mysqli_fetch_array($exec75);
$store = $res75['store'];

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

	$itemcode = $itemcode;
	include ('autocompletestockcount1include1.php');
	$currentstock = $currentstock;

	$query4 = "select * from master_settings where modulename = 'SALES' and settingsname = 'SALES_ENTRY_STOCK_ALERT' and status <> 'deleted'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$settingsvalue = $res4["settingsvalue"];
	if ($settingsvalue == 'SHOW ALERT')
	{
		$itemstock = $currentstock;
	
	}
	else
	{
		$itemstock = 'HIDE ALERT';
	}

	//To get default tax values
	if (isset($_REQUEST["defaulttax"])) { $defaulttax = $_SESSION["defaulttax"]; } else { $defaulttax = ""; }
	//$defaulttax = $_SESSION["defaulttax"];
	if ($defaulttax == '')
	{
		$query3 = "select * from master_tax where auto_number = '$res2taxanum'";
	}
	else
	{
		$query3 = "select * from master_tax where auto_number = '$defaulttax'";
		$taxanum = $defaulttax;
	}
	/*
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	$taxname = $res3["taxname"];
	$taxpercent = $res3["taxpercent"];
	*/
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$taxparentanum = $res3["auto_number"];
	$taxname = $res3['taxname'];
	$taxpercent = $res3['taxpercent'];
	$taxpercentcalc = $taxpercent;
	
	$taxsubpercenttotal = '';
	$query5 = "select * from master_taxsub where taxparentanum = '$taxparentanum'";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res5 = mysqli_fetch_array($exec5))
	{
		$taxsubanum = $res5["auto_number"];
		$taxsubname = $res5["taxsubname"];
		$taxsubpercent = $res5["taxsubpercent"];
		
		$taxsubpercenttotal = $taxsubpercenttotal + $taxsubpercent;
	}
	
	if ($taxsubpercenttotal != '')
	{
		//$taxpercentcalc = '10.30';
		$taxsubpercenttotal = $taxsubpercenttotal;
		$taxsubpercenttotal = $taxsubpercenttotal / 10;
		
		$taxpercentcalc = $taxpercentcalc + $taxsubpercenttotal;
	}
	
	
	//To calculate reverse tax for the item rate.
	//http://answers.yahoo.com/question/index?qid=20080914103752AAzQ6nk
	//If the item costs 100 including 6.75% tax, then 100 represents 106.75% of the original price. 
	//So you divide 100 by 106.75 and get 93.68 (rounded to the nearest cent).
	//Original Price = Total Price / (1 + Tax Rate)
	//2750 / 2887.5 / 95.24 / 2619.1 / 130.95 / 2750
	//$taxpercent = 10;  //testing value.
	//To avoid conflict with existing customer installations
	
	/*
	$query4 = "select * from master_settings where modulename = 'SALES' and settingsname = 'SALES_TAX_CALCULATE' and status <> 'deleted'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	$res4 = mysql_fetch_array($exec4);
	$settingsvalue1 = $res4["settingsvalue"];
	if ($settingsvalue1 == 'REVERSE CALCULATE')
	{
		//$amountwithtax = $taxpercent / 100;
		$taxpercentcalc = $taxpercentcalc;
		$amountwithtax = $taxpercentcalc / 100;
		$amountwithtax = $amountwithtax * $mrp;
		$amountwithtax = $amountwithtax + $mrp;
		$amountwithouttax = $mrp;
		$reversetaxpercent = $amountwithouttax / $amountwithtax;
		$reverseitemamount = $amountwithouttax * $reversetaxpercent;
		$reverseitemamount = round($reverseitemamount, 2);
		$mrp = $reverseitemamount;
	}
	*/

$rateperunit = $mrp;
$subtotal = $rateperunit;
$totalamount = $rateperunit;

$i=0;
$stringbuild1 = '';
$query5 = "select * from purchase_details where itemcode = '$itemcode' group by batchnumber";// and batchnumber = '$batchnumber'";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res5 = mysqli_fetch_array($exec5))
{
	$batchnumber = $res5['batchnumber'];
	
	$itemcode = $itemcode;
			$batchname = $batchnumber;
			include ('autocompletestockbatch.php');
	$currentstock = $currentstock;
	if($currentstock > 0)
	{
	
	if ($stringbuild1 == '')
	{
		//$stringbuild1 = '"'.$citemcode.' || '.$citemname.' || '.$citemstock.'"';
		//$stringbuild1 = '"'.$citemcode.' || '.$citemname. '"'; //.' || '.$citemstock.'"';
		$stringbuild1 = $batchnumber; //.' || '.$citemstock.'"';
	}
	else
	{
		$stringbuild1 = $stringbuild1.'||'.$batchnumber.'';
	}
	}
}
echo $stringbuild1;

?>