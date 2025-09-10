<?php

include ("includes/loginverify.php");
include ("db/db_connect.php");
			$totalpurchaseprice1 = '';
			$totalitemrate1 = '';
			$totalcurrentstock1  = '';
			$grandtotalcogs = '';
			$grandtotalcogs = '0.00';
			$purchaseprice = '';
			$totalinventoryvalue = '';
			$grandtotalinventoryvalue = '0.00';

			//$query2 = "select * from master_stock where itemcode like '%$itemcode%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";// and cstid='$custid' and cstname='$custname'";
			$query2 = "select * from master_itempharmacy where status <> 'DELETED'";// and companyanum = '$companyanum'";// and cstid='$custid' and cstname='$custname'";
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
		
			$query1 = "select sum(quantity) as sumsales from pharmacysales_details where itemcode = '$itemcode' and  recordstatus <> 'DELETED' and companyanum = '$companyanum'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$totalsales = $res1['sumsales'];
			
			$query1 = "select sum(quantity) as sumsalesreturn from pharmacysalesreturn_details where itemcode = '$itemcode' and  recordstatus <> 'DELETED' and companyanum = '$companyanum'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$totalsalesreturn = $res1['sumsalesreturn'];
			
			$query11 = "select sum(allpackagetotalquantity) as sumpurchase,sum(totalamount) as totalpurchaseamount from purchase_details where itemcode = '$itemcode' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res11 = mysqli_fetch_array($exec11);
			$num11 = mysqli_num_rows($exec11);
			$totalpurchase = $res11['sumpurchase'];
			$totalpurchaseamount = $res11['totalpurchaseamount'];
			
			$query1 = "select sum(quantity) as sumpurchasereturn from purchasereturn_details where itemcode = '$itemcode' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
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
			transactionmodule = 'ADJUSTMENT' and transactionparticular = 'BY ADJUSTMENT ADD' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$totalsumadjustmentadd = $res1['sumadjustmentadd'];
			
			$query1 = "select sum(quantity) as sumadjustmentminus from master_stock where itemcode = '$itemcode' and 
			transactionmodule = 'ADJUSTMENT' and transactionparticular = 'BY ADJUSTMENT MINUS' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$totalsumadjustmentminus = $res1['sumadjustmentminus'];
			
			$currentstock = $totalpurchase;
			$currentstock = $currentstock - $totalpurchasereturn;
			$currentstock = $currentstock - $totalsales;
			$currentstock = $currentstock + $totalsalesreturn;
			$currentstock = $currentstock - $totaldccustomer;
			$currentstock = $currentstock + $totaldcsupplier;
			$currentstock = $currentstock + $totalsumadjustmentadd;
			$currentstock = $currentstock - $totalsumadjustmentminus;
						if ($currentstock > 0)
			{
				//echo $customercode.'||'.$customername.'||'.$address.'||'.$location.'||'.$city.'||'.$state.'||'.$pincode.'||'.$title1.'||'.$contactperson1.'||'.$designation1.'||'.$department1.'||'.$res2anum.'||'.$tinnumber.'||'.$cstnumber;
				//echo $currentstock;
			}
			else
			{
				//echo '0';
			}
			
		
			
			
			
			$totalitemrate = $itemrate * $currentstock;
			$totalitemrate = number_format($totalitemrate, 2, '.', '');
			
			//$totalpurchaseprice = $purchaseprice * $currentstock;
			$totalpurchaseprice = $totalpurchaseamount;
			$totalpurchaseprice = number_format($totalpurchaseprice, 2, '.', '');
			
			$totalcurrentstock1 = $totalcurrentstock1 + $currentstock;
			if(($totalpurchaseprice != '')&&($totalpurchase != ''))
			{
			$purchaseprice = $totalpurchaseprice/intval($totalpurchase);
			$purchaseprice = number_format($purchaseprice, 2, '.', '');
			}
			$totalitemrate1 = $totalitemrate1 + $totalitemrate;
			$totalitemrate1 = number_format($totalitemrate1, 2, '.', '');
			if(($currentstock != '')&&($purchaseprice != ''))
			{
			$totalinventoryvalue = $currentstock * $purchaseprice;
			$totalinventoryvalue = number_format($totalinventoryvalue, 2, '.', '');
		}
			
			$totalpurchaseprice1 = $totalpurchaseprice1 + $totalinventoryvalue;
			$totalpurchaseprice1 = number_format($totalpurchaseprice1, 2, '.', '');
			
				
				
		$cogs = ($totalsales - $totalsalesreturn)*$purchaseprice;
			if($cogs < 0)
			{
			$cogs = 0;
			}
			$grandtotalcogs = $grandtotalcogs + $cogs;
			$cogs = number_format($cogs, 2, '.', '');		
			
			
			$grandtotalinventoryvalue = $grandtotalinventoryvalue + $totalinventoryvalue;
			$totalinventoryvalue = '';
			}	
			
	  $query661 = "select sum(costofsales) as labcogs from cogsentry where coa='02-2003' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec661 = mysqli_query($GLOBALS["___mysqli_ston"], $query661) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res661 = mysqli_fetch_array($exec661);
		  $labcogs = $res661['labcogs'];
		  
		  $query6611 = "select sum(costofsales) as labcogs from cogsentry where coa='02-2004' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6611 = mysqli_query($GLOBALS["___mysqli_ston"], $query6611) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6611 = mysqli_fetch_array($exec6611);
		  $labcogs1 = $res6611['labcogs'];
		  
		  $totallabcogs = $labcogs + $labcogs1;

		  
		  $query663 = "select sum(costofsales) as radiologycogs from cogsentry where coa='02-2007' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec663 = mysqli_query($GLOBALS["___mysqli_ston"], $query663) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res663 = mysqli_fetch_array($exec663);
		  $radiologycogs = $res663['radiologycogs'];
		  
		  $query6631 = "select sum(costofsales) as radiologycogs from cogsentry where coa='02-2008' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6631 = mysqli_query($GLOBALS["___mysqli_ston"], $query6631) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6631 = mysqli_fetch_array($exec6631);
		  $radiologycogs1 = $res6631['radiologycogs'];
		  
		  $totalradiologycogs = $radiologycogs + $radiologycogs1;


		  $query664 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2009' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec664 = mysqli_query($GLOBALS["___mysqli_ston"], $query664) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res664 = mysqli_fetch_array($exec664);
		  $servicecogs = $res664['servicecogs'];
		  
		   $query6641 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2002' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6641 = mysqli_query($GLOBALS["___mysqli_ston"], $query6641) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6641 = mysqli_fetch_array($exec6641);
		  $servicecogs1 = $res6641['servicecogs'];
		  
		   $query6642 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2006' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6642 = mysqli_query($GLOBALS["___mysqli_ston"], $query6642) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6642 = mysqli_fetch_array($exec6642);
		  $servicecogs2 = $res6642['servicecogs'];
		  
		  $query6643 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2008' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6643 = mysqli_query($GLOBALS["___mysqli_ston"], $query6643) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6643 = mysqli_fetch_array($exec6643);
		  $servicecogs3 = $res6643['servicecogs'];
		  
		  $query6644 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2010' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6644 = mysqli_query($GLOBALS["___mysqli_ston"], $query6644) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6644 = mysqli_fetch_array($exec6644);
		  $servicecogs4 = $res6644['servicecogs'];
		  
		  $query6645 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2011' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6645 = mysqli_query($GLOBALS["___mysqli_ston"], $query6645) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6645 = mysqli_fetch_array($exec6645);
		  $servicecogs5 = $res6645['servicecogs'];
		  
    	  $query6646 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2012' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6646 = mysqli_query($GLOBALS["___mysqli_ston"], $query6646) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6646 = mysqli_fetch_array($exec6646);
		  $servicecogs6 = $res6646['servicecogs'];
		  
		  $query6647 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2013' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6647 = mysqli_query($GLOBALS["___mysqli_ston"], $query6647) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6647 = mysqli_fetch_array($exec6647);
		  $servicecogs7 = $res6647['servicecogs'];
		  
		   $query6648 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2014' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6648 = mysqli_query($GLOBALS["___mysqli_ston"], $query6648) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6648 = mysqli_fetch_array($exec6648);
		  $servicecogs8 = $res6648['servicecogs'];
		  
		  $totalservicecogs = $servicecogs1 + $servicecogs2 + $servicecogs3 + $servicecogs4 + $servicecogs5 + $servicecogs6 + $servicecogs7 + $servicecogs8;

		  
		  $grandtotalinventoryvalue = $grandtotalinventoryvalue - $totallabcogs - $totalradiologycogs -$totalservicecogs;
			
?>