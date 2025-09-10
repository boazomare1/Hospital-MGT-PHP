<?php
//WARNING//
//*****************************************************************
//This file is called as file_get_contents from autoitemsearch2.php
//*****************************************************************

$totalpurchase = "";
$totalpurchasereturn = "";
$totalsales = "";
$totalsalesreturn = "";
$totaldccustomer = "";
$totaldcsupplier = "";
$totalsumadjustmentadd = "";
$totalsumadjustmentminus = "";
$totalsumtransferadd = "";
$totalsumtransferminus = "";

 
$query1 = "select * from master_itempharmacy where itemcode = '$itemcode'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1itemcode = $res1['itemcode'];
$res1itemname = $res1['itemname'];

$query1 = "select sum(quantity) as sumsales from pharmacysales_details where itemcode = '$itemcode' and  recordstatus <> 'DELETED' and companyanum = '$companyanum' and batchnumber = '$batchname' and locationcode = '$locationcode'";
if($storecode!='')
 {
	 $query1 .="  AND store = '".$storecode."'";
	 }
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$totalsales = $res1['sumsales'];

$query1 = "select sum(quantity) as sumsalesreturn from pharmacysalesreturn_details where itemcode = '$itemcode' and  recordstatus <> 'DELETED' and companyanum = '$companyanum' and batchnumber = '$batchname' and locationcode = '$locationcode' ";
if($storecode!='')
 {
	 $query1 .="  AND store = '".$storecode."'";
	 }
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$totalsalesreturn = $res1['sumsalesreturn'];

//$query1 = "select sum(quantity) as sumpurchase from purchase_details where itemcode = '$itemcode' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
 $query1 = "select sum(allpackagetotalquantity) as sumpurchase from purchase_details where itemcode = '$itemcode' and recordstatus <> 'DELETED' and companyanum = '$companyanum' and batchnumber = '$batchname' and locationcode = '$locationcode' ";
if($storecode!='')
 {
	 $query1 .="  AND store = '".$storecode."'";
	 }
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
 $num = mysqli_num_rows($exec1);
$res1 = mysqli_fetch_array($exec1);
$totalpurchase = $res1['sumpurchase'];
 
 //to get current stock for that store
 $query1 = "select allpackagetotalquantity from purchase_details where itemcode = '$itemcode' and recordstatus <> 'DELETED' and companyanum = '$companyanum' and batchnumber = '$batchname' and locationcode = '$locationcode' ";
 if($storecode!='')
 {
	 $query1 .="  AND store = '".$storecode."'";
	 }
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
 $num = mysqli_num_rows($exec1);
$res1 = mysqli_fetch_array($exec1);
$currentstockforloc = $res1['allpackagetotalquantity'];
//ends here
 

$query1 = "select sum(quantity) as sumpurchasereturn from purchasereturn_details where itemcode = '$itemcode' and recordstatus <> 'DELETED' and companyanum = '$companyanum' and batchnumber = '$batchname' and locationcode = '$locationcode' ";
if($storecode!='')
 {
	 $query1 .="  AND store = '".$storecode."'";
	 }
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
transactionmodule = 'ADJUSTMENT' and transactionparticular = 'BY ADJUSTMENT ADD' and recordstatus <> 'DELETED' and companyanum = '$companyanum' and batchnumber = '$batchname' and locationcode = '$locationcode' ";
if($storecode!='')
 {
	 $query1 .="  AND store = '".$storecode."'";
	 }
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$totalsumadjustmentadd = $res1['sumadjustmentadd'];





$query1 = "select sum(quantity) as sumadjustmentminus from master_stock where itemcode = '$itemcode' and 
transactionmodule = 'ADJUSTMENT' and transactionparticular = 'BY ADJUSTMENT MINUS' and recordstatus <> 'DELETED' and companyanum = '$companyanum' and batchnumber = '$batchname' and locationcode = '$locationcode' ";
if($storecode!='')
 {
	 $query1 .="  AND store = '".$storecode."'";
	 }
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$totalsumadjustmentminus = $res1['sumadjustmentminus'];

 $query2 = "select sum(transferquantity) as sumtransferadd from master_stock_transfer where itemcode = '$itemcode' and companyanum = '$companyanum' and batch = '$batchname' and tolocationcode = '$locationcode' ";
 if($storecode!='')
 {
	 $query2 .="  AND tostore = '".$storecode."'";
	 }
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$totalsumtransferadd = $res2['sumtransferadd'];

$query21 = "select sum(transferquantity) as sumtransferminus from master_stock_transfer where itemcode = '$itemcode' and companyanum = '$companyanum' and batch = '$batchname' and locationcode = '$locationcode'";
if($storecode!='')
 {
	 $query21 .="  AND tostore = '".$storecode."'";
	 }
$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res21 = mysqli_fetch_array($exec21);
$totalsumtransferminus = $res21['sumtransferminus'];

$currentstock = $totalpurchase;
$currentstock = $currentstock - $totalpurchasereturn;
$currentstock = $currentstock - $totalsales;
$currentstock = $currentstock + $totalsalesreturn;
$currentstock = $currentstock - $totaldccustomer;
$currentstock = $currentstock + $totaldcsupplier;
$currentstock = $currentstock + $totalsumadjustmentadd;
$currentstock = $currentstock - $totalsumadjustmentminus;
$currentstock = $currentstock + $totalsumtransferadd;
$currentstock = $currentstock - $totalsumtransferminus;

$i=$i+1;



?>
