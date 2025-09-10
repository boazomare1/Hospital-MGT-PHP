<?php
//session_start();
//include ("includes/loginverify.php");
include ("db/db_connect.php");


$totalquantity = '';
$stockdate = '';
$transactionparticular = '';
$stockremarks = '';
$itemrate = '';
$salesquantity = '';
$salesreturnquantity = '';
$purchasequantity = '';
$purchasereturnquantity = '';
$adjustmentaddquantity = '';
$adjustmentminusquantity = '';
$totalsalesquantity = '';
$totalsalesreturnquantity = '';
$totalpurchasequantity = '';
$totalpurchasereturnquantity = '';
$totaladjustmentaddquantity = '';
$totaladjustmentminusquantity = '';
$transferquantity1 = '';
$transferquantity = '';
$currentstock = '';
$counter = 0;

$totalpurchaseprice1 = '';
$totalitemrate1 = '';
$totalcurrentstock1  = '';
$grandtotalcogs = '';
$grandtotalcogs = '0.00';
//echo $itemcode;

$query2 = "select * from master_itempharmacy where itemcode like '%$itemcode%' and categoryname like '%$categoryname%' and status <> 'DELETED'";// and companyanum = '$companyanum'";// and cstid='$custid' and cstname='$custname'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$num2 = mysqli_num_rows($exec2);
while ($res2 = mysqli_fetch_array($exec2))
{
	$res2anum = $res2['auto_number'];
	$itemcode = $res2['itemcode'];
	$itemname = $res2['itemname'];
	$res2categoryname = $res2['categoryname'];
	
	
	$itemrate = $res2['rateperunit']; //Unit price is calculated below.
	//$stockdate = $res2['transactiondate'];
	//$stockremarks = $res2['remarks'];
	//$transactionparticular = $res2['transactionparticular'];
	$itempackageanum = $res2['packageanum'];
	$res2packagename = $res2['packagename'];
	if($res2packagename == '')
	{
	$res2packagename='1S';
	}
	$res2packagename = stripslashes($res2packagename);
	
	//To calculate price for packaged items to divide by number of items count.
	$query31 = "select * from master_packagepharmacy where auto_number = '$itempackageanum'";
	$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res31 = mysqli_fetch_array($exec31);
	$quantityperpackage = $res31['quantityperpackage']; //Value called for purchase calc.
	
	@$itemrate = $itemrate / $quantityperpackage;
	$itemrate = number_format($itemrate, 2, '.', '');
	@$itempurchaserate = $purchaseprice / $quantityperpackage;
	$itempurchaserate = number_format($itempurchaserate, 2, '.', '');

	/*$query11 = "select sum(quantity) as sumsales from pharmacysales_details where locationcode = '".$locationcode."' AND itemcode = '$itemcode' and  recordstatus <> 'DELETED' and companyanum = '$companyanum' and store like '%$store%'";
	$exec11 = mysql_query($query11) or die ("Error in Query1".mysql_error());
	$res11 = mysql_fetch_array($exec11);
	$totalsales = $res11['sumsales'];*/
	$query11 = "select sum(quantity) as sumsales from pharmacysales_details where locationcode = '".$locationcode."' AND itemcode = '$itemcode' and  recordstatus <> 'DELETED' and companyanum = '$companyanum'";
	
	if($store!='')
	{
	$query11 .= " AND store='".$store."'";
	}
	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res11 = mysqli_fetch_array($exec11);
	$totalsales = $res11['sumsales'];
	
	$query1 = "select sum(quantity) as sumsalesreturn from pharmacysalesreturn_details where itemcode = '$itemcode' and  recordstatus <> 'DELETED' and companyanum = '$companyanum' and store like '%$store%'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
	$totalsalesreturn = $res1['sumsalesreturn'];
	
	$query1 = "select sum(allpackagetotalquantity) as sumpurchase,sum(totalamount) as totalpurchaseamount from purchase_details where itemcode = '$itemcode' and recordstatus <> 'DELETED' and companyanum = '$companyanum' and store like '%$store%'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
	$totalpurchase = $res1['sumpurchase'];
	$totalpurchaseamount = $res1['totalpurchaseamount'];
	
	$query1 = "select sum(quantity) as sumpurchasereturn from purchasereturn_details where itemcode = '$itemcode' and recordstatus <> 'DELETED' and companyanum = '$companyanum' and store like '%$store%'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
	$totalpurchasereturn = $res1['sumpurchasereturn'];
	
	$query1 = "select sum(quantity) as sumdccustomer from dccustomer_details where itemcode = '$itemcode' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
	$totaldccustomer = $res1['sumdccustomer'];
	
	$query1 = "select sum(quantity) as sumdcsupplier from dcsupplier_details where itemcode = '$itemcode' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
	$totaldcsupplier = $res1['sumdcsupplier'];
	
	$query1 = "select sum(quantity) as sumadjustmentadd from master_stock where itemcode = '$itemcode' and 
	transactionmodule = 'ADJUSTMENT' and transactionparticular = 'BY ADJUSTMENT ADD' and recordstatus <> 'DELETED' and companyanum = '$companyanum' and store like '%$store%'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
	$totalsumadjustmentadd = $res1['sumadjustmentadd'];
	
	$query1 = "select sum(quantity) as sumadjustmentminus from master_stock where itemcode = '$itemcode' and 
	transactionmodule = 'ADJUSTMENT' and transactionparticular = 'BY ADJUSTMENT MINUS' and recordstatus <> 'DELETED' and companyanum = '$companyanum' and store like '%$store%'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
	$totalsumadjustmentminus = $res1['sumadjustmentminus'];
	
	$query33 = "select sum(transferquantity) as transferquantity from master_stock_transfer where itemcode = '$itemcode' and fromstore = '$store'";
	$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res33 = mysqli_fetch_array($exec33);
	$transferquantity = $res33['transferquantity'];	
	
	$query34 = "select sum(transferquantity) as transferquantity,sum(amount) as transferamount from master_stock_transfer where itemcode = '$itemcode' and tostore = '$store'";
	$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res34 = mysqli_fetch_array($exec34);
	$transferquantity1 = $res34['transferquantity'];	
	$transferamount = $res34['transferamount'];
	
	//echo $store;
	
	$currentstock = $totalpurchase;
	$currentstock = $currentstock - $totalpurchasereturn;
	$currentstock = $currentstock - $totalsales;
	$currentstock = $currentstock + $totalsalesreturn;
	$currentstock = $currentstock - $totaldccustomer;
	$currentstock = $currentstock + $totaldcsupplier;
	$currentstock = $currentstock + $totalsumadjustmentadd;
	$currentstock = $currentstock - $totalsumadjustmentminus;
	$currentstock = $currentstock - $transferquantity;
	$currentstocks = $currentstock + $transferquantity1;
	
	
	if(($totalpurchase == '') && ($transferquantity1 != ''))
	{
	$totalpurchase = $transferquantity1;
	$totalpurchaseamount = $transferamount;
	}
	if($currentstocks > 0)
	{
	$counter =$counter+1;
	}
}
//echo $counter;
?>