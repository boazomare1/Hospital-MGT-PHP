<?php
session_start();
//Called from purchase1.php - autoitemsearch2.js
//Item rate called from previous bill entry is done here.

include ("db/db_connect.php");
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$companycode = $_SESSION['companycode'];
$username = $_SESSION['username'];
$itemcode = $_REQUEST['itemcode'];
$searchresult = "";

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

	//$financialyear = $_SESSION["financialyear"];
	$query6 = "select * from master_company where auto_number = '$companyanum'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res6 = mysqli_fetch_array($exec6);
	$res6companycode = $res6["companycode"];
	
	$query7 = "select * from master_settings where companycode = '$res6companycode' and modulename = 'SETTINGS' and 
	settingsname = 'CURRENT_FINANCIAL_YEAR'";
	$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res7 = mysqli_fetch_array($exec7);
	$financialyear = $res7["settingsvalue"];
	$_SESSION["financialyear"] = $financialyear;
	//echo $_SESSION['financialyear'];


	$query2 = "select * from master_itempharmacy where itemcode = '$itemcode'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_fetch_array($exec2);
	$itemcode = $res2['itemcode'];
	$itemname = $res2['itemname'];
	//$mrp = $res2['rateperunit'];
	$query1021 = "select * from purchase_details where itemcode = '$itemcode' order by auto_number desc";
		$exec1021 = mysqli_query($GLOBALS["___mysqli_ston"], $query1021) or die ("Error in Query102".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res1021 = mysqli_fetch_array($exec1021);
		$mrp = $res1021['costprice'];

	$taxanum = $res2['taxanum'];
	$itemdescription = $res2['description'];
	
	$packagename = $res2['packagename'];
	$packagename = stripslashes($packagename);
	//$packagename = addslashes($packagename);
	$packageanum = $res2['packageanum'];
	$salesprice = $res2['rateperunit'];
	$manufacturername = $res2['manufacturername'];
	$spmarkup = $res2['spmarkup'];
	
	//To Get Price From Previous Bills For Selected supplier.
	//GET PRICE FROM PREVIOUS INVOICE
	$query100 = "select * from master_settings where modulename = 'SETTINGS' and settingsname = 'ITEM_PRICE_SETTING' 
	and status <> 'deleted' and companyanum = '$companyanum' and companycode = '$companycode'";
	$exec100 = mysqli_query($GLOBALS["___mysqli_ston"], $query100) or die ("Error in Query100".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res100 = mysqli_fetch_array($exec100);
	$res100settingsvalue = $res100['settingsvalue'];
	if ($res100settingsvalue == 'GET PRICE FROM PREVIOUS INVOICE')
	{
		if (isset($_REQUEST["suppliercode"])) { $suppliercode = $_REQUEST["suppliercode"]; } else { $suppliercode = ""; }
		//$suppliercode = $_REQUEST['suppliercode'];
		$query101 = "select * from master_purchase where suppliercode = '$suppliercode' and recordstatus <> 'deleted' and companyanum = '$companyanum' order by billdate desc";// and financialyear = '$financialyear' order by billdate desc";
		$exec101 = mysqli_query($GLOBALS["___mysqli_ston"], $query101) or die ("Error in Query101".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res101 = mysqli_fetch_array($exec101);
		$res101billautonumber = $res101['auto_number'];
		
		$query102 = "select * from purchase_details where itemcode = '$itemcode' and bill_autonumber = '$res101billautonumber' and companyanum = '$companyanum' and recordstatus <> 'deleted'";// and financialyear = '$financialyear' and recordstatus <> 'deleted'";
		$exec102 = mysqli_query($GLOBALS["___mysqli_ston"], $query102) or die ("Error in Query102".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res102 = mysqli_fetch_array($exec102);
		$res102rate = $res102['costprice'];
		if ($res102rate != '')
		{
			$mrp = $res102rate;
		}
		//$mrp = '0.00';
	}
	//$mrp = '0.00';
	
	$itemcode = $itemcode;
	include ('autocompletestockcount1include1.php');
	$currentstock = $currentstock;
	/*
	$query4 = "select * from master_settings where modulename = 'SALES' and settingsname = 'SALES_ENTRY_STOCK_ALERT' and status <> 'deleted' 
	and companyanum = '$companyanum' and companycode = '$companycode'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	$res4 = mysql_fetch_array($exec4);
	$settingsvalue = $res4["settingsvalue"];
	if ($settingsvalue == 'SHOW ALERT')
	{
		$itemstock = $currentstock;
	
	}
	else
	{
		$itemstock = 'HIDE ALERT';
	}
	*/
	$itemstock = '';
	
	//To get default tax values
	$defaulttax = $_SESSION['defaulttax'];
	if ($defaulttax == '')
	{
		$query3 = "select * from master_tax where auto_number = '$taxanum'";
	}
	else
	{
		$query3 = "select * from master_tax where auto_number = '$defaulttax'";
		$taxanum = $defaulttax;
	}
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
	

	

	if ($searchresult == '')
	{
		$searchresult = ''.$itemcode.'||'.$itemname.'||'.$mrp.'||'.$taxname.'||'.$taxpercent.'||'.$taxanum.'||'.$itemdescription.'||'.$itemstock.'||'.$currentstock.'||'.$packageanum.'||'.$packagename.'||'.$salesprice.'||'.$manufacturername.'||'.$spmarkup.'';
	}
		
	
	if ($searchresult != '')
	{
		echo $searchresult;
	}

?>