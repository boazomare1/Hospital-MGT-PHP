<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$errmsg = "";
$transferquantity2 = '';
$transferamount2 = '0';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Closingstock.xls"');
header('Cache-Control: max-age=80');

$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];
	 $res12locationanum = $res["auto_number"];
	 
  $locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
//To populate the autocompetelist_services1.js
//include ("autocompletebuild_item1pharmacy.php");

$transactiondatefrom = '2017-01-01';
$transactiondateto = date('Y-m-d');
	
if (isset($_REQUEST["ADate2"])) { $transactiondateto = $_REQUEST["ADate2"]; }

if (isset($_REQUEST["searchitemcode"])) { $searchitemcode = $_REQUEST["searchitemcode"]; } else { $searchitemcode = ""; }
//$itemcode = $_REQUEST['itemcode'];
if (isset($_REQUEST["servicename"])) { $servicename = $_REQUEST["servicename"]; } else { $servicename = ""; }
//$servicename = $_REQUEST['servicename'];

//if ($servicename == '') $servicename = 'ALL';

if (isset($_REQUEST["itemname"])) { $searchitemname = $_REQUEST["itemname"]; } else { $searchitemname = ""; }
if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }
//$searchitemname = $_REQUEST['itemname'];
if ($searchitemname != '')
{
	$arraysearchitemname = explode('||', $searchitemname);
	$itemcode = $arraysearchitemname[0];
	$itemcode = trim($itemcode);
}

?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #FFFFFF;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; }
-->
</style>
</head>

<body>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1000" 
            align="left" border="1">
          <tbody>
		  <tr>
              <td colspan="9" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>Closing Stock Report</strong></td>
		  </tr>		
           <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Item Code </strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Item Name </strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Category</strong></td>
				<td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Formula</strong></td>
                 <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Batch Number</strong></td>
				      <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>CP</strong></div></td>
   
                  <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Current Stock </strong></div></td>
                             <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Inv.Val </strong></div></td>
				   <!--<td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>COGS </strong></div></td>-->
        
            </tr>
            <?php
			if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }
			if (isset($_REQUEST["store"]) && $_REQUEST["store"]!='') { $store = $_REQUEST["store"]; } else { $store = ""; }
			//$categoryname = $_REQUEST['categoryname'];
			if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = "frmflag1"; }
			//$frmflag1 = $_REQUEST['frmflag1'];
			if ($frmflag1 == 'frmflag1')
			{
			$colorloopcount = '';
			$sno = '';
			$totalquantity = '';
			$stockdate = '';
			$transactionparticular = '';
			$stockremarks = '';

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
			
			$totalpurchaseprice1 = '';
			$totalitemrate1 = '';
			$totalcurrentstock1  = '';
			$grandtotalcogs = '';
			$grandtotalcogs = '0.00';
			$freeqtytot =0;
			
			if($searchitemcode == ''){ $searchcode = $servicename; } else { $searchcode = $searchitemcode; }
			//$query2 = "select * from master_stock where itemcode like '%$itemcode%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";// and cstid='$custid' and cstname='$custname'";
			$rateperunitvar = $location.'_rateperunit';
			if($store=='')
               $store_search = "like '%$store%'";
			else
               $store_search = "='$store'";

			if($categoryname=='')
				$cate_search = "like '%$categoryname%'";
			else
               $cate_search = "='$categoryname'";

			if($searchcode=='')
			{

				$query2 = "select a.auto_number,a.itemcode,a.itemname,a.categoryname,a.`$rateperunitvar`,a.packageanum,a.packagename,a.purchaseprice from master_medicine as a JOIN transaction_stock as b ON a.itemcode = b.itemcode where b.storecode $store_search and a.categoryname $cate_search and  b.recorddate <= '$transactiondateto' group by a.itemcode";
				
				// and companyanum = '$companyanum'";// and cstid='$custid' and cstname='$custname'";
/*				$query2 = "select auto_number,itemcode,itemname,categoryname,`$rateperunitvar`,packageanum,packagename,purchaseprice from master_medicine where categoryname like '%$categoryname%' and status <> 'DELETED'";// and companyanum = '$companyanum'";// and cstid='$custid' and cstname='$custname'";
	*/
			}
			else
			{
				
$query2 = "select a.auto_number,a.itemcode,a.itemname,a.categoryname,a.`$rateperunitvar`,a.packageanum,a.packagename,a.purchaseprice from master_medicine as a JOIN transaction_stock as b ON a.itemcode = b.itemcode where b.storecode $store_search and a.itemcode = '$searchcode' and a.categoryname $cate_search  and b.recorddate <= '$transactiondateto' group by a.itemcode";
				/*
				$query2 = "select auto_number,itemcode,itemname,categoryname,`$rateperunitvar`,packageanum,packagename,purchaseprice from master_medicine where itemcode = '$searchcode' and categoryname like '%$categoryname%' and status <> 'DELETED'";
		*/
			}
			if($searchcode=='' && $store=='' && $transactiondateto>='2020-01-01')
			{
				$chkfree="SELECT sum(free*costprice) as totfree FROM `materialreceiptnote_details` where itemcode!='' and entrydate <= '$transactiondateto' and free>0 and locationcode='$location'";
				$exec2f = mysqli_query($GLOBALS["___mysqli_ston"], $chkfree) or die ("Error in chkfree".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res2f = mysqli_fetch_array($exec2f);
				$freeqtytot =$res2f['totfree'];
			}
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num2 = mysqli_num_rows($exec2);
			while ($res2 = mysqli_fetch_array($exec2))
			{
			$res2anum = $res2['auto_number'];
			$itemcode = $res2['itemcode'];
			//$itemname = $res2['itemname'];
			$costprice = $res2['purchaseprice'];
			$res2categoryname = $res2['categoryname'];
			
			$query123 = "SELECT itemname,formula FROM master_medicine WHERE itemcode = '$itemcode'";
			$exec123 = mysqli_query($GLOBALS["___mysqli_ston"], $query123) or die ("Error in Query123".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res123 = mysqli_fetch_array($exec123);
			$itemname = "<pre class='bodytext31'>".$res123['itemname']."</pre>";
			
			
			$itemrate = $res2[$location.'_rateperunit']; //Unit price is calculated below.
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
			
			
			$itempackageanum = '14';
			//To calculate price for packaged items to divide by number of items count.
			$query31 = "select quantityperpackage from master_packagepharmacy where auto_number = '$itempackageanum'";
			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res31 = mysqli_fetch_array($exec31);
			$quantityperpackage = $res31['quantityperpackage']; //Value called for purchase calc.
			
			@$itemrate = $itemrate / $quantityperpackage;
			$itemrate = number_format($itemrate, 2, '.', '');
			@$itempurchaserate = $purchaseprice / $quantityperpackage;
			$itempurchaserate = number_format($itempurchaserate, 2, '.', '');
			
			$query77 = "select batchnumber from transaction_stock where itemcode='$itemcode' and locationcode='$location' and storecode $store_search and recorddate <= '$transactiondateto' group by batchnumber";
			$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res77 = mysqli_fetch_array($exec77))
			{
			$batchnumber = $res77['batchnumber'];
		
			/*$query1 = "select sum(batch_quantity) as currentstock from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$location' and storecode $store_search and batchnumber = '$batchnumber' and recorddate <= '$transactiondateto'";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			$res1 = mysql_fetch_array($exec1);
			$currentstock = $res1['currentstock'];*/

			

			$query33 = "select rate,fifo_code from transaction_stock where itemcode='$itemcode' and locationcode='$location' and batchnumber='$batchnumber' and recorddate <= '$transactiondateto' and storecode $store_search group by rate";
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in query33".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numLab1 = mysqli_num_rows($exec33);
			
			$totalcprate=0;
			$currentstock=0;
			$currentstock1 =0;

            if($numLab1>1){
                
                $query33_fifo = "select fifo_code,rate from transaction_stock where itemcode='$itemcode' and locationcode='$location' and batchnumber='$batchnumber' and recorddate <= '$transactiondateto' and storecode $store_search group by fifo_code";
			    $exec33_fifo = mysqli_query($GLOBALS["___mysqli_ston"], $query33_fifo) or die ("Error in query33_fifo".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res33_fifo = mysqli_fetch_array($exec33_fifo))
			    {
                     $fifostocks=0;
					 $fifocode=$res33_fifo["fifo_code"];
					 $rate=$res33_fifo["rate"];

					    $query1 = "select sum(transaction_quantity) as currentstock from transaction_stock where  itemcode='$itemcode' and locationcode='$location' and storecode $store_search and batchnumber = '$batchnumber' and recorddate <= '$transactiondateto' and transactionfunction='1' and fifo_code='".$fifocode."'";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						$currentstock1 = $res1['currentstock'];

						$query1 = "select sum(transaction_quantity) as currentstock from transaction_stock where  itemcode='$itemcode' and locationcode='$location' and storecode $store_search and batchnumber = '$batchnumber' and recorddate <= '$transactiondateto' and transactionfunction='0' and fifo_code='".$fifocode."'";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						$currentstock2 = $res1['currentstock'];

				        $fifostocks = $currentstock1-$currentstock2;
						$currentstock=$currentstock+$fifostocks;

						if($fifostocks>0){
							$cptotal=$fifostocks * $rate;
							$totalcprate=$totalcprate+$cptotal;
						}


				}

				if($currentstock>0)
                   $costprice = $totalcprate/$currentstock;
				else{
					//echo "<br>".$itemcode."-".$batchnumber."-".$totalcprate."-".$currentstock;
					$costprice = 0;

				}

			}else{
				
				$query1 = "select sum(transaction_quantity) as currentstock from transaction_stock where  itemcode='$itemcode' and locationcode='$location' and storecode $store_search and batchnumber = '$batchnumber' and recorddate <= '$transactiondateto' and transactionfunction='1'";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res1 = mysqli_fetch_array($exec1);
				$currentstock1 = $res1['currentstock'];

				$query1 = "select sum(transaction_quantity) as currentstock from transaction_stock where  itemcode='$itemcode' and locationcode='$location' and storecode $store_search and batchnumber = '$batchnumber' and recorddate <= '$transactiondateto' and transactionfunction='0'";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res1 = mysqli_fetch_array($exec1);
				$currentstock2 = $res1['currentstock'];

				$currentstock= $currentstock1-$currentstock2;

				$res33 = mysqli_fetch_array($exec33);
			   
			    $costprice = $res33['rate'];
			}

			$transferamount =$transferquantity =$totalpurchase =$totalpurchaseamount =$totalsalesquantity =$totalsalesreturn =0;
			
			/*$query1 = "select sum(transaction_quantity) as sumpurchase,sum(totalprice) as totalpurchaseamount from transaction_stock where locationcode = '".$location."' AND itemcode = '$itemcode' and storecode $store_search and docstatus='New Batch' and batchnumber = '$batchnumber' and recorddate <= '$transactiondateto'";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			$res1 = mysql_fetch_array($exec1);
			$totalpurchase = $res1['sumpurchase'];
			$totalpurchaseamount = $res1['totalpurchaseamount'];
			
			$query1 = "select sum(transaction_quantity) as sumsales from transaction_stock where locationcode = '".$location."' AND itemcode = '$itemcode' and storecode $store_search and description in('Sales','IP Direct Sales','IP Sales') and batchnumber = '$batchnumber' and recorddate <= '$transactiondateto'";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			$res1 = mysql_fetch_array($exec1);
			$totalsalesquantity = $res1['sumsales'];
			//$totalpurchaseamount = $res1['totalpurchaseamount'];
			
			$query1 = "select sum(transaction_quantity) as sumreturn from transaction_stock where locationcode = '".$location."' AND itemcode = '$itemcode' and storecode $store_search and description in('Sales Return','IP Sales Return') and batchnumber = '$batchnumber' and recorddate <= '$transactiondateto'";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			$res1 = mysql_fetch_array($exec1);
			$totalsalesreturn = $res1['sumreturn'];
			//$totalpurchaseamountreturn = $res1['totalpurchaseamount'];			
			
			$query34 = "select sum(transaction_quantity) as transferquantity,sum(totalprice) as transferamount from transaction_stock where locationcode = '".$location."' AND itemcode = '$itemcode' and storecode $store_search and description = 'Stock Transfer To' and batchnumber = '$batchnumber' and recorddate <= '$transactiondateto'";
			$exec34 = mysql_query($query34) or die(mysql_error());
			$res34 = mysql_fetch_array($exec34);
		    $transferquantity = $res34['transferquantity'];	
			$transferamount = $res34['transferamount'];*/
			
//echo $totalpurchase.'<br>'.$totalsalesquantity.'<br>'.$totalsalesreturn.'<br>'.$transferquantityfrom;
			
			
			
			//$currentstock = $totalpurchase;
			//$currentstock = $currentstock - $totalpurchasereturn;
			//$currentstock = $totalsales;
			/*$currentstock = $currentstock + $totalsalesreturn;
			$currentstock = $currentstock - $totaldccustomer;
			$currentstock = $currentstock + $totaldcsupplier;
			$currentstock = $currentstock + $totalsumadjustmentadd;
			$currentstock = $currentstock - $totalsumadjustmentminus;
			$currentstock = $currentstock - $transferquantity;
			$currentstock = $currentstock + $transferquantity1;
			$currentstock = $currentstock + $transferquantity2;*/
			
			
			if(($totalpurchase == '') && ($transferquantity != ''))
			{
			$totalpurchase = $transferquantity + $transferquantity;
			$totalpurchaseamount = $transferamount + $transferamount;
			}
			
			if ($currentstock > 0)
			{			
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#ecf0f5"';
			}
			
			$sno = $sno + 1;
			//echo $itemrate;
			$totalitemrate = $itemrate * $currentstock;
			$totalitemrate = number_format($totalitemrate, 2, '.', '');
			
			//$totalpurchaseprice = $purchaseprice * $currentstock;
			$totalpurchaseprice = $totalpurchaseamount;
			$totalpurchaseprice = number_format($totalpurchaseprice, 2, '.', '');
			
			$totalcurrentstock1 = $totalcurrentstock1 + $currentstock;
			
			
			if($totalpurchase==0)
			{$purchaseprice= number_format($totalpurchaseprice, 2, '.', '');}
			else
			{
				$purchaseprice = $totalpurchaseprice/intval($totalpurchase);
				$purchaseprice = number_format($purchaseprice, 2, '.', '');
			}
			
			$totalitemrate1 = $totalitemrate1 + $totalitemrate;
			$totalitemrate1 = number_format($totalitemrate1, 2, '.', '');
			
			$totalinventoryvalue = $currentstock * $costprice;
			$totalinventoryvalue = number_format($totalinventoryvalue, 2, '.', '');
		
			
			$totalpurchaseprice1 = $totalpurchaseprice1 + $totalinventoryvalue;
			$totalpurchaseprice1 = number_format($totalpurchaseprice1, 2, '.', '');
			
				
			$cogs = ($totalsalesquantity - $totalsalesreturn)*$costprice;
			
				  
			if($cogs < 0)
			{
			$cogs = 0;
			}
			$grandtotalcogs = $grandtotalcogs + $cogs;
			$cogs = number_format($cogs, 2, '.', '');
			

			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $itemcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $itemname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
                  <div align="left"><?php echo $res2categoryname; ?></div>
              </div></td>
			  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
                  <div align="left"><?php echo $res123['formula']; ?></div>
              </div></td>
			   <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
                  <div align="left"><?php echo $batchnumber; ?></div>
              </div></td>
			    <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
                  <div align="right"><?php echo number_format($costprice,2,'.',','); ?></div>
              </div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31">
			    <div align="right"><?php echo $currentstock; ?></div>
			  </div></td>
             
             
                      <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
                  <div align="right"><?php echo number_format($totalinventoryvalue,2,'.',','); ?></div>
              </div></td>
			    <!--<td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
                  <div align="right"><?php //echo number_format($cogs,2,'.',','); ?>&nbsp;</div>-->
              </div></td>
            </tr>
            <?php
			$currentstock = '';
			$itemrate = '';
			$totalitemrate = '';
			
			}
			}
			}
			$grandtotalcogs = number_format($grandtotalcogs, 2, '.', '');
			if($totalpurchaseprice1 == '')
			{
			$totalpurchaseprice1 = 0;
			}
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"><div align="right"><strong>&nbsp; </strong></div></td>
                        <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"><div align="right"><strong><?php //echo $totalcurrentstock1; ?>&nbsp;</strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"><div align="right"><strong>&nbsp;</strong></div></td>
                   <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"><div align="right"><strong><?php echo number_format($totalpurchaseprice1,2,'.',','); ?></strong></div></td>
				  <!-- <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"><div align="right"><strong><?php //echo number_format($grandtotalcogs,2,'.',','); ?>&nbsp;</strong></div></td>-->
            </tr><?php if($freeqtytot>0){ ?>
			<tr>
			 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5" colspan='7'><strong>Free/Bonus Qty Value</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong>-<?php echo number_format($freeqtytot,2,'.',',');?></strong></td>
			</tr>
			<tr>
			 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5" colspan='7'><strong>Total</strong></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong><?php echo number_format(($totalpurchaseprice1-$freeqtytot),2,'.',',');?></strong></td>
			</tr>
			<?php
			}
			}
			?>
          </tbody>
        </table>
</body>
</html>
