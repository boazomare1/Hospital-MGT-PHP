<?php
session_start();
set_time_limit(0);
include ("includes/loginverify.php");
include ("db/db_connect.php");
date_default_timezone_set('Asia/Calcutta'); 
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$errmsg = "";
$searchmedicinename = "";
$colorloopcount = '';
$openingbalance = 0;
$user = '';  
$snocount=0; 
$openingbalance_on_date1_final=0;
			$quantity1_purchase_final=0;
			$quantity1_preturn_final=0;
			$quantity1_receipts_final=0;
			$quantity2_transferout_final=0;
			$quantity2_sales_final=0;
			$quantity1_refunds_final=0;
			$quantity2_transferout_ownusage_final=0;
			$quantity1_excess_final=0;
			$quantity2_Short_final=0;
			$closingstock_on_date2_final=0;

//To populate the autocompetelist_services1.js
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="FullStockMovement.xls"');
header('Cache-Control: max-age=80');

$transactiondatefrom = date('Y-m-d', strtotime('-1 week'));
$transactiondateto = date('Y-m-d');

if (isset($_REQUEST["medicinecode"])) { $searchmedicinecode = $_REQUEST["medicinecode"]; } else { $searchmedicinecode = ""; }

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $transactiondatefrom; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $transactiondateto; }

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{
if (isset($_REQUEST["searchitemcode"])) { $searchmedicinecode = $_REQUEST["searchitemcode"]; } else { $searchmedicinecode = ""; }
//$medicinecode = $_REQUEST['medicinecode'];
if (isset($_REQUEST["itemname"])) { $searchmedicinename = $_REQUEST["itemname"]; } else { $searchmedicinename = ""; }
if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }
if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }
}

$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];
	 $res12locationanum = $res["auto_number"];
	 
  $locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #FFF;
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

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1000"
            align="left" border="0">
          <!-- <tbody>
          <tr>
                <td bgcolor="#FFF" colspan="8" class="bodytext3" align="left"><strong><?php echo 'Stock Movement Report ('.$ADate1.' to '.$ADate2.')'; ?></strong></td>
                </tr> -->
                <tbody>

		 <tr> <td colspan="13" align="center"><strong><u><h3>FULL STOCK MOVEMENT REPORT</h3></u></strong></td></tr>
         <!--  <tr ><td colspan="10" align="center"><strong>Type : <?php if($type=='') { echo 'All'; } echo $type; ?></strong></td></tr> -->
        <tr ><td colspan="13" align="center"><strong>Date From:    <?php echo $ADate1 ?>   To:  <?php echo $ADate2 ?></strong></td></tr>
   		 <tbody>
            
				<?php
				if (isset($_REQUEST["mainsearch"])) { $mainsearch = $_REQUEST["mainsearch"]; } else { $mainsearch = ""; }
				if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }
				if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{

if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }
if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }
if (isset($_REQUEST["mainsearch"])) { $mainsearch = $_REQUEST["mainsearch"]; } else { $mainsearch = ""; }

$noofdays=strtotime($ADate2) - strtotime($ADate1);
				$noofdays = $noofdays/(3600*24);
?>
<?php

if($mainsearch=='1'){

?>

          	<tr>
             <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Sl. No</strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Description</strong></td>
             <!--  <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Batch</strong></td> -->
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Opg.Stock</strong></div></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Purchase</strong></div></td>

                 <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Purchase Returns</strong></div></td>

                  <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Receipts</strong></div></td>

              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Issued To Dept</strong></div></td>

                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Sales</strong></div></td>


              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Refunds</strong></div></td>

                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Own Usage</strong></div></td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Phy.Excess</strong></div></td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Phy.Short</strong></div></td>

              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Closing Stock</strong></div></td>
				<!-- <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Username</strong></div></td> -->
				</tr>

<?php

 $query_store = "SELECT * FROM `master_store`"; 
if($store!=''){ 
  $query_store .= " where storecode='$store'  " ; 
	}
$exec_store = mysqli_query($GLOBALS["___mysqli_ston"], $query_store) or die ("Error in query_store".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res_store = mysqli_fetch_array($exec_store))
				{ 
					$store=$res_store['storecode'];
					
					 $storename=$res_store['store']; 
                ////////////////////FIRST //////////////////
                // echo $openingbalance_on_date; 
                // $ADate12 = date('Y-m-d', strtotime('-1 day', strtotime($ADate1)));
                   $query1a = "SELECT sum(transaction_quantity) as addstock from transaction_stock where locationcode='$location' and storecode ='$store' and transaction_date < '$ADate1' and transactionfunction='1' order by auto_number desc  ";
                 // echo $query1a = "SELECT sum(transaction_quantity) as addstock from transaction_stock where itemcode='$medicinecode' and locationcode='$location' and storecode ='$store' and transaction_date between '$ADate1' and '$ADate2' and transactionfunction='1' order by auto_number desc  ";
				$exec1a = mysqli_query($GLOBALS["___mysqli_ston"], $query1a) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	 
				$res1a = mysqli_fetch_array($exec1a);
				 $totaladdstock = $res1a['addstock'];
				
				$query1m = "SELECT sum(transaction_quantity) as minusstock from transaction_stock where  locationcode='$location' and storecode ='$store' and transaction_date < '$ADate1' and transactionfunction='0' order by auto_number desc  ";
				$exec1m = mysqli_query($GLOBALS["___mysqli_ston"], $query1m) or die(mysqli_error($GLOBALS["___mysqli_ston"]));		 
				$res1m = mysqli_fetch_array($exec1m);
				 $totalminusstock = $res1m['minusstock'];
				
				 $openingbalance_on_date1 = $totaladdstock-$totalminusstock;
				// $balance_close_stock1 = $openingbalance;
				 ///////////////////////second//////////////////
				 $quantity1_purchase=0;  //PURCHASE
                   $query1_purchase = "SELECT transaction_quantity from transaction_stock where locationcode = '".$locationcode."'  and transactionfunction='1' and (description='Purchase' or description='OPENINGSTOCK' or description='".$storename."' ) and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec1_purchase = mysqli_query($GLOBALS["___mysqli_ston"], $query1_purchase) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res1_purchase = mysqli_fetch_array($exec1_purchase))
				{
				
				  $quantity1_purchase += $res1_purchase['transaction_quantity'];

				} 
				//////////////////////THIRD /////////////////
				$quantity1_preturn=0;  //PURCHASE RETURN
                  $query1_pr = "SELECT transaction_quantity from transaction_stock where locationcode = '".$locationcode."' and transactionfunction='0' and description='Purchase Return' and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec1_pr = mysqli_query($GLOBALS["___mysqli_ston"], $query1_pr) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res1_pr = mysqli_fetch_array($exec1_pr))
				{
				
				  $quantity1_preturn += $res1_pr['transaction_quantity'];

				} 
				/////////////////// FOURTH //////////////////
				$quantity2_transferout_ownusage=0;
				$quantity1_receipts=0; //	Receipts --> Transfer IN
				$quantity1_receipts_1=0;
				$quantity1_receipts_2=0;
				
                   $query1_receipts = "SELECT transaction_quantity,entrydocno, storecode, itemcode from transaction_stock where locationcode = '".$locationcode."' and transactionfunction='1' and description='Stock Transfer To'   and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec1_receipts = mysqli_query($GLOBALS["___mysqli_ston"], $query1_receipts) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res1_receipts = mysqli_fetch_array($exec1_receipts))
				{
				  // $quantity1_receipts += $res1_receipts['transaction_quantity'];

				  	$docno=$res1_receipts['entrydocno'];
					$storecode_fet=$res1_receipts['storecode'];
					$itemcode_fet=$res1_receipts['itemcode'];

					// SELECT sum(`transferquantity`) FROM `master_stock_transfer` WHERE `fromstore`='STO1' and `typetransfer`='Transfer' and `entrydate` between '2019-03-01' and '2019-05-02'

						// $quantity1_receipts += $res1_receipts['transaction_quantity'];
					 
                    $query1_receipts2 = "SELECT typetransfer from master_stock_transfer where `docno`='$docno' and itemcode='$itemcode_fet' and locationcode = '".$locationcode."' ";
					$exec_receipts2 = mysqli_query($GLOBALS["___mysqli_ston"], $query1_receipts2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
					$res_receipts2 = mysqli_fetch_array($exec_receipts2);
					
						$typetransfer=$res_receipts2['typetransfer'];
						if($typetransfer=='Transfer'){
					  			$quantity1_receipts += $res1_receipts['transaction_quantity'];
					  		}else{
					  			$quantity2_transferout_ownusage += $res1_receipts['transaction_quantity'];
					  		}
				  	
				  	// $quantity1_receipts_1 = $quantity1_receipts+$quantity1_receipts1;
				  	// $quantity2_transferout_ownusage += $quantity2_transferout_ownusage1;
				} 
				//  $query1_receipts_2 = "SELECT transaction_quantity,entrydocno, storecode from transaction_stock where locationcode = '".$locationcode."' AND  transactionfunction='1' and  description='Stock Adj Add Stock'  and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				// $exec1_receipts_2 = mysql_query($query1_receipts_2) or die(mysql_error());			
				// while($res1_receipts_2 = mysql_fetch_array($exec1_receipts_2))
				// {
				// 	  			$quantity1_receipts_2 += $res1_receipts_2['transaction_quantity'];
				// } 
				// $quantity1_receipts=$quantity1_receipts_1+$quantity1_receipts_2;

				//////////////// fifth ///////////////////////////////////
				 $quantity2_transferout=0;  //Transfer out
				 $quantity2_transferout_1=0;   
				 $quantity2_transferout_2=0; 

				 $quantity2_transferout_11=0; 
				 $quantity2_transferout_22=0;
				 $quantity2_transferout_ownusage1=0; 
				 
                    $query12_transferout = "SELECT transaction_quantity,storecode, entrydocno ,itemcode from transaction_stock where locationcode = '".$locationcode."' AND  transactionfunction='0' and description='Stock Transfer From'  and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec12_transferout = mysqli_query($GLOBALS["___mysqli_ston"], $query12_transferout) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res12_transferout = mysqli_fetch_array($exec12_transferout))
				{

					$docno=$res12_transferout['entrydocno'];
					$storecode_fet=$res12_transferout['storecode'];
					$itemcode_fet=$res12_transferout['itemcode'];

					 // SELECT sum(`transferquantity`) FROM `master_stock_transfer` WHERE `fromstore`='STO1' and `typetransfer`='Transfer' and `entrydate` between '2019-03-01' and '2019-05-02'

                    $query12_transferout2 = "SELECT typetransfer ,transferquantity from master_stock_transfer where `docno`='$docno' and itemcode='$itemcode_fet' and locationcode = '".$locationcode."' ";
                    // AND  fromstore = '$storecode_fet'
					$exec12_transferout2 = mysqli_query($GLOBALS["___mysqli_ston"], $query12_transferout2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
					$res12_transferout2 = mysqli_fetch_array($exec12_transferout2);
					
						$typetransfer=$res12_transferout2['typetransfer'];
						// $transferquantity=$res12_transferout2['transferquantity'];
						if($typetransfer=='Consumable'){
					  			// $quantity2_transferout_ownusage += $transferquantity;
					  			$quantity2_transferout_ownusage += $res12_transferout['transaction_quantity'];
					  		}elseif($typetransfer=='Transfer'){
					  		// }else{
					  			// $quantity2_transferout += $transferquantity;
					  			$quantity2_transferout += $res12_transferout['transaction_quantity'];
					  		}
				  	// }
				  	
				  	// $quantity2_transferout = $quantity2_transferout+$quantity2_transferout_11;
				  	// $quantity2_transferout_ownusage=$quantity2_transferout_ownusage+$quantity2_transferout_ownusage1;
				} 

				 

				////////////////////////// SIXTH ///////////////
				$quantity2_sales=0;   // Sales
                    $query12_sales = "SELECT transaction_quantity from transaction_stock where locationcode = '".$locationcode."' AND transactionfunction='0' and (description='Sales' or description='Package' or description='IP Direct Sales' or description='IP Sales' or description='Process' ) and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec12_sales = mysqli_query($GLOBALS["___mysqli_ston"], $query12_sales) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res12_sales = mysqli_fetch_array($exec12_sales))
				{
				
				  $quantity2_sales += $res12_sales['transaction_quantity'];

				} 
				////////////////// SEVENTH ///////////////////////////
				$quantity1_refunds=0;   // Refunds
                  $query1_refunds = "SELECT transaction_quantity from transaction_stock where locationcode = '".$locationcode."' AND  transactionfunction='1' and (description='Sales Return' or description='IP Sales Return' or description='Sales Return' ) and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec1_refunds = mysqli_query($GLOBALS["___mysqli_ston"], $query1_refunds) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res1_refunds = mysqli_fetch_array($exec1_refunds))
				{
				
				  $quantity1_refunds += $res1_refunds['transaction_quantity'];

				} 
				/////////////////////////// eight CLOSING STOCK ///////////////////

				$query1a_closingstock = "SELECT sum(transaction_quantity) as addstock from transaction_stock where  locationcode='$location' and storecode ='$store' and transaction_date <= '$ADate2' and transactionfunction='1' order by auto_number desc  ";
                 // echo $query1a = "SELECT sum(transaction_quantity) as addstock from transaction_stock where itemcode='$medicinecode' and locationcode='$location' and storecode ='$store' and transaction_date between '$ADate1' and '$ADate2' and transactionfunction='1' order by auto_number desc  ";
				$exec1a_closingstock = mysqli_query($GLOBALS["___mysqli_ston"], $query1a_closingstock) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	 
				$res1a_closingstock = mysqli_fetch_array($exec1a_closingstock);
				 $totaladdstock_closingstock = $res1a_closingstock['addstock'];
				
				$query1m_closingstock = "SELECT sum(transaction_quantity) as minusstock from transaction_stock where locationcode='$location' and storecode ='$store' and transaction_date <= '$ADate2' and transactionfunction='0' order by auto_number desc  ";
				$exec1m_closingstock = mysqli_query($GLOBALS["___mysqli_ston"], $query1m_closingstock) or die(mysqli_error($GLOBALS["___mysqli_ston"]));		 
				$res1m_closingstock = mysqli_fetch_array($exec1m_closingstock);
				 $totalminusstock_closingstock = $res1m_closingstock['minusstock'];
				
				 $closingstock_on_date2 = $totaladdstock_closingstock-$totalminusstock_closingstock;
				///////////////////////////phy excess///////////////////////////
				 $quantity1_excess=0;
				 $query1_excess = "SELECT transaction_quantity,entrydocno, storecode from transaction_stock where locationcode = '".$locationcode."' AND  transactionfunction='1' and  description='Stock Adj Add Stock'  and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec1_excess = mysqli_query($GLOBALS["___mysqli_ston"], $query1_excess) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res1_excess = mysqli_fetch_array($exec1_excess))
				{
					  			$quantity1_excess += $res1_excess['transaction_quantity'];
				} 
				 /////////////////////  Phy.Short /////////
				 $quantity2_Short=0;
				 $query12_Short = "SELECT transaction_quantity,storecode, entrydocno from transaction_stock where locationcode = '".$locationcode."' AND  transactionfunction='0' and (description='Stock Damaged Minus Stock' or description='Stock Expired Minus Stock' or description='Stock Adj Minus Stock' ) and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec12_Short = mysqli_query($GLOBALS["___mysqli_ston"], $query12_Short) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res12_Short = mysqli_fetch_array($exec12_Short))
				{
					$quantity2_Short += $res12_Short['transaction_quantity'];
				} 
				// $quantity2_Short_2=$quantity2_Short_2+$quantity2_Short_22;

				// $quantity2_Short=$quantity2_Short_1+$quantity2_Short_2;

				// if($openingbalance_on_date1==0 && $quantity1_purchase==0 && $quantity1_preturn==0 && $quantity1_receipts==0 && $quantity2_transferout==0 && $quantity2_sales==0 && $quantity1_refunds==0 && $closingstock_on_date2==0 && $quantity2_transferout_ownusage==0){

				// }else{

					$snocount = $snocount + 1;
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
				} ?>
				 <tr <?php echo $colorcode; ?>>
				 	<td class="bodytext31" valign="center"  align="center"><?php echo $snocount; ?></td>
					<td class="bodytext31" valign="center"  align="left" ><strong><?=$storename;?></strong></td>
				
            	
            		   <td align="right" valign="right"  
                 class="bodytext31"><div align="right"><strong><?php echo number_format($openingbalance_on_date1,0,'.',','); ?></strong></div></td>

				<td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity1_purchase,0,'.',',');  ?>  </strong></td>

                 <td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity1_preturn,0,'.',','); ?>  </strong></td>
				
				<td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity1_receipts,0,'.',','); ?>  </strong></td>
       			
       			<td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity2_transferout,0,'.',',');   ?>  </strong></td>


            <td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity2_sales,0,'.',',');  ?>  </strong></td>
               
			<td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity1_refunds,0,'.',',');?>  </strong></td>

       			 <!-- <td align="left" valign="center"  
                 class="bodytext31"><strong> <?php //echo intval($balance);?> </strong></td> -->

                 <td align="right" valign="right"  
                 class="bodytext31"><strong> <?php echo number_format($quantity2_transferout_ownusage,0,'.',','); ?> </strong></td>
                   <td align="right" valign="right"  
                 class="bodytext31"><strong> <?php echo number_format($quantity1_excess,0,'.',',');  ?> </strong></td>
                   <td align="right" valign="right"  
                 class="bodytext31"><strong> <?php echo number_format($quantity2_Short,0,'.',','); ?> </strong></td>


                <td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($closingstock_on_date2,0,'.',','); ?>  </strong></td>
				 
			</tr>

<?php
$openingbalance_on_date1_final        += $openingbalance_on_date1;
			$quantity1_purchase_final        +=$quantity1_purchase;
			$quantity1_preturn_final        +=$quantity1_preturn;
			$quantity1_receipts_final        +=$quantity1_receipts;
			$quantity2_transferout_final        +=$quantity2_transferout;
			$quantity2_sales_final        +=$quantity2_sales;
			$quantity1_refunds_final        +=$quantity1_refunds;
			$quantity2_transferout_ownusage_final        +=$quantity2_transferout_ownusage;
			$quantity1_excess_final        +=$quantity1_excess;
			$quantity2_Short_final        +=$quantity2_Short;
			$closingstock_on_date2_final  +=$closingstock_on_date2;
// } // else of ==0 condition
}//if condition
}else if($mainsearch=='2'){

?>

          	<tr>
             <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Sl. No</strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Description</strong></td>
             <!--  <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Batch</strong></td> -->
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Opg.Stock</strong></div></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Purchase</strong></div></td>

                 <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Purchase Returns</strong></div></td>

                  <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Receipts</strong></div></td>

              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Issued To Dept</strong></div></td>

                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Sales</strong></div></td>


              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Refunds</strong></div></td>

                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Own Usage</strong></div></td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Phy.Excess</strong></div></td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Phy.Short</strong></div></td>

              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Closing Stock</strong></div></td>
				<!-- <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Username</strong></div></td> -->
				</tr>

<?php

$query_store = "SELECT * FROM `master_store`"; 
if($store!=''){ 
$query_store .= " where storecode='$store'  " ; 
	}
$exec_store = mysqli_query($GLOBALS["___mysqli_ston"], $query_store) or die ("Error in query_store".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res_store = mysqli_fetch_array($exec_store))
				{ 
					$store=$res_store['storecode'];
					 $storename=$res_store['store']; 
					?>
					<tr>
                <td bgcolor="#FF9900" colspan="14" class="bodytext3" align="left"><strong><?php echo $res_store['store']; ?></strong></td>
                </tr>
                <?php

// $query991 = "select itemcode, categoryname, itemname from master_medicine where categoryname like '%$categoryname%' and itemcode like '%$searchmedicinecode%' and status <> 'deleted' group by categoryname order by categoryname, itemname";
// $exec991 = mysql_query($query991) or die ("Error in Query991".mysql_error());
// 				while ($res991 = mysql_fetch_array($exec991))
// 				{
// 					$categoryname2 = $res991['categoryname'];
// 					$itemname = $res991['itemname'];
				?>
               <!--  <tr>
                <td bgcolor="#FF9900" colspan="8" class="bodytext3" align="left"><strong><?php echo $categoryname2; ?></strong></td>
                </tr> -->
                <?php
				$sno = 0;
				$query99 = "SELECT itemcode, categoryname, itemname from master_medicine where categoryname like '%$categoryname%' and itemcode like '%$searchmedicinecode%' order by itemname";
				// $query99 = "select itemcode, categoryname, itemname from master_medicine where categoryname = '$categoryname2' and itemcode like '%$searchmedicinecode%' and status <> 'deleted' order by itemname";
$exec99 = mysqli_query($GLOBALS["___mysqli_ston"], $query99) or die ("Error in Query99".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res99 = mysqli_fetch_array($exec99))
				{
					$categoryname2 = $res99['categoryname'];
					$medicinecode = $res99['itemcode'];
					$itemname = $res99['itemname'];
				?>
				
                <?php
				//get store for location
// 	$loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';
// $username=isset($_REQUEST['username'])?$_REQUEST['username']:'';
//   $query5ll = "select ms.auto_number,ms.storecode,ms.store from master_employeelocation as me LEFT JOIN master_store as ms ON me.storecode=ms.auto_number where me.locationcode = '".$loc."' AND me.username= '".$username."'";
// if($store!='')
// {
// 	$query5ll .=" and ms.storecode='".$store."' group by ms.storecode";
// 	}
// 				$exec5ll = mysql_query($query5ll) or die ("Error in Query5ll".mysql_error());
// 				while ($res5ll = mysql_fetch_array($exec5ll))
// 				{
			
// 				}
                
				
				?>
				 
                
                <?php
                ////////////////////FIRST //////////////////
                // echo $openingbalance_on_date; 
                // $ADate12 = date('Y-m-d', strtotime('-1 day', strtotime($ADate1)));
                   $query1a = "SELECT sum(transaction_quantity) as addstock from transaction_stock where itemcode='$medicinecode' and locationcode='$location' and storecode ='$store' and transaction_date < '$ADate1' and transactionfunction='1' order by auto_number desc  ";
                 // echo $query1a = "SELECT sum(transaction_quantity) as addstock from transaction_stock where itemcode='$medicinecode' and locationcode='$location' and storecode ='$store' and transaction_date between '$ADate1' and '$ADate2' and transactionfunction='1' order by auto_number desc  ";
				$exec1a = mysqli_query($GLOBALS["___mysqli_ston"], $query1a) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	 
				$res1a = mysqli_fetch_array($exec1a);
				 $totaladdstock = $res1a['addstock'];
				
				$query1m = "SELECT sum(transaction_quantity) as minusstock from transaction_stock where itemcode='$medicinecode' and locationcode='$location' and storecode ='$store' and transaction_date < '$ADate1' and transactionfunction='0' order by auto_number desc  ";
				$exec1m = mysqli_query($GLOBALS["___mysqli_ston"], $query1m) or die(mysqli_error($GLOBALS["___mysqli_ston"]));		 
				$res1m = mysqli_fetch_array($exec1m);
				 $totalminusstock = $res1m['minusstock'];
				
				 $openingbalance_on_date1 = $totaladdstock-$totalminusstock;
				// $balance_close_stock1 = $openingbalance;
				 ///////////////////////second//////////////////
				 $quantity1_purchase=0;  //PURCHASE
                   $query1_purchase = "SELECT transaction_quantity from transaction_stock where locationcode = '".$locationcode."' AND itemcode = '$medicinecode' and transactionfunction='1' and (description='Purchase' or description='OPENINGSTOCK' or description='".$storename."' ) and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec1_purchase = mysqli_query($GLOBALS["___mysqli_ston"], $query1_purchase) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res1_purchase = mysqli_fetch_array($exec1_purchase))
				{
				
				  $quantity1_purchase += $res1_purchase['transaction_quantity'];

				} 
				//////////////////////THIRD /////////////////
				$quantity1_preturn=0;  //PURCHASE RETURN
                  $query1_pr = "SELECT transaction_quantity from transaction_stock where locationcode = '".$locationcode."' AND itemcode = '$medicinecode' and transactionfunction='0' and description='Purchase Return' and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec1_pr = mysqli_query($GLOBALS["___mysqli_ston"], $query1_pr) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res1_pr = mysqli_fetch_array($exec1_pr))
				{
				
				  $quantity1_preturn += $res1_pr['transaction_quantity'];

				} 
				/////////////////// FOURTH //////////////////
				$quantity2_transferout_ownusage=0;
				$quantity1_receipts=0; //	Receipts --> Transfer IN
				$quantity1_receipts_1=0;
				$quantity1_receipts_2=0;
				
                   $query1_receipts = "SELECT transaction_quantity,entrydocno, storecode from transaction_stock where locationcode = '".$locationcode."' AND itemcode = '$medicinecode' and transactionfunction='1' and description='Stock Transfer To'   and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec1_receipts = mysqli_query($GLOBALS["___mysqli_ston"], $query1_receipts) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res1_receipts = mysqli_fetch_array($exec1_receipts))
				{
				  // $quantity1_receipts += $res1_receipts['transaction_quantity'];

				  	$docno=$res1_receipts['entrydocno'];
					$storecode_fet=$res1_receipts['storecode'];

					 
                    $query1_receipts2 = "SELECT typetransfer from master_stock_transfer where `docno`='$docno' and locationcode = '".$locationcode."' AND itemcode = '$medicinecode'";
					$exec_receipts2 = mysqli_query($GLOBALS["___mysqli_ston"], $query1_receipts2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
					$res_receipts2 = mysqli_fetch_array($exec_receipts2);
					
						$typetransfer=$res_receipts2['typetransfer'];
						if($typetransfer=='Transfer'){
					  			$quantity1_receipts += $res1_receipts['transaction_quantity'];
					  		}else{
					  			$quantity2_transferout_ownusage += $res1_receipts['transaction_quantity'];
					  		}
				  	
				  	// $quantity1_receipts_1 = $quantity1_receipts+$quantity1_receipts1;
				  	// $quantity2_transferout_ownusage += $quantity2_transferout_ownusage1;
				} 
				//  $query1_receipts_2 = "SELECT transaction_quantity,entrydocno, storecode from transaction_stock where locationcode = '".$locationcode."' AND itemcode = '$medicinecode' and transactionfunction='1' and  description='Stock Adj Add Stock'  and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				// $exec1_receipts_2 = mysql_query($query1_receipts_2) or die(mysql_error());			
				// while($res1_receipts_2 = mysql_fetch_array($exec1_receipts_2))
				// {
				// 	  			$quantity1_receipts_2 += $res1_receipts_2['transaction_quantity'];
				// } 
				// $quantity1_receipts=$quantity1_receipts_1+$quantity1_receipts_2;

				//////////////// fifth ///////////////////////////////////
				 $quantity2_transferout=0;  //Transfer out
				 $quantity2_transferout_1=0;   
				 $quantity2_transferout_2=0;   
				 
                    $query12_transferout = "SELECT transaction_quantity,storecode, entrydocno from transaction_stock where locationcode = '".$locationcode."' AND itemcode = '$medicinecode' and transactionfunction='0' and description='Stock Transfer From'  and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec12_transferout = mysqli_query($GLOBALS["___mysqli_ston"], $query12_transferout) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res12_transferout = mysqli_fetch_array($exec12_transferout))
				{

					$docno=$res12_transferout['entrydocno'];
					$storecode_fet=$res12_transferout['storecode'];

					 
                    $query12_transferout2 = "SELECT typetransfer from master_stock_transfer where `docno`='$docno' and locationcode = '".$locationcode."' AND itemcode = '$medicinecode'  and fromstore = '$storecode_fet'";
					$exec12_transferout2 = mysqli_query($GLOBALS["___mysqli_ston"], $query12_transferout2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
					$res12_transferout2 = mysqli_fetch_array($exec12_transferout2);
					
						$typetransfer=$res12_transferout2['typetransfer'];
						if($typetransfer=='Transfer'){
					  			$quantity2_transferout += $res12_transferout['transaction_quantity'];
					  		}else{
					  			$quantity2_transferout_ownusage += $res12_transferout['transaction_quantity'];
					  		}
				  	

				} 

				//  $query12_transferout = "SELECT transaction_quantity,storecode, entrydocno from transaction_stock where locationcode = '".$locationcode."' AND itemcode = '$medicinecode' and transactionfunction='0' and (description='Stock Damaged Minus Stock' or description='Stock Expired Minus Stock' or description='Stock Adj Minus Stock' ) and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				// $exec12_transferout = mysql_query($query12_transferout) or die(mysql_error());			
				// while($res12_transferout = mysql_fetch_array($exec12_transferout))
				// {
				// 	$quantity2_transferout_2 += $res12_transferout['transaction_quantity'];
				// } 
				// $quantity2_transferout=$quantity2_transferout_1+$quantity2_transferout_2;

				////////////////////////// SIXTH ///////////////
				$quantity2_sales=0;   // Sales
                    $query12_sales = "SELECT transaction_quantity from transaction_stock where locationcode = '".$locationcode."' AND itemcode = '$medicinecode' and transactionfunction='0' and (description='Sales' or description='Package' or description='IP Direct Sales' or description='IP Sales' or description='Process' ) and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec12_sales = mysqli_query($GLOBALS["___mysqli_ston"], $query12_sales) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res12_sales = mysqli_fetch_array($exec12_sales))
				{
				
				  $quantity2_sales += $res12_sales['transaction_quantity'];

				} 
				////////////////// SEVENTH ///////////////////////////
				$quantity1_refunds=0;   // Refunds
                  $query1_refunds = "SELECT transaction_quantity from transaction_stock where locationcode = '".$locationcode."' AND itemcode = '$medicinecode' and transactionfunction='1' and (description='Sales Return' or description='IP Sales Return' or description='Sales Return' ) and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec1_refunds = mysqli_query($GLOBALS["___mysqli_ston"], $query1_refunds) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res1_refunds = mysqli_fetch_array($exec1_refunds))
				{
				
				  $quantity1_refunds += $res1_refunds['transaction_quantity'];

				} 
				/////////////////////////// eight CLOSING STOCK ///////////////////

				$query1a_closingstock = "SELECT sum(transaction_quantity) as addstock from transaction_stock where itemcode='$medicinecode' and locationcode='$location' and storecode ='$store' and transaction_date <= '$ADate2' and transactionfunction='1' order by auto_number desc  ";
                 // echo $query1a = "SELECT sum(transaction_quantity) as addstock from transaction_stock where itemcode='$medicinecode' and locationcode='$location' and storecode ='$store' and transaction_date between '$ADate1' and '$ADate2' and transactionfunction='1' order by auto_number desc  ";
				$exec1a_closingstock = mysqli_query($GLOBALS["___mysqli_ston"], $query1a_closingstock) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	 
				$res1a_closingstock = mysqli_fetch_array($exec1a_closingstock);
				 $totaladdstock_closingstock = $res1a_closingstock['addstock'];
				
				$query1m_closingstock = "SELECT sum(transaction_quantity) as minusstock from transaction_stock where itemcode='$medicinecode' and locationcode='$location' and storecode ='$store' and transaction_date <= '$ADate2' and transactionfunction='0' order by auto_number desc  ";
				$exec1m_closingstock = mysqli_query($GLOBALS["___mysqli_ston"], $query1m_closingstock) or die(mysqli_error($GLOBALS["___mysqli_ston"]));		 
				$res1m_closingstock = mysqli_fetch_array($exec1m_closingstock);
				 $totalminusstock_closingstock = $res1m_closingstock['minusstock'];
				
				 $closingstock_on_date2 = $totaladdstock_closingstock-$totalminusstock_closingstock;

				 ///////////////////////////phy excess///////////////////////////
				 $quantity1_excess=0;
				 $query1_excess = "SELECT transaction_quantity,entrydocno, storecode from transaction_stock where locationcode = '".$locationcode."' AND itemcode = '$medicinecode' AND  transactionfunction='1' and  description='Stock Adj Add Stock'  and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec1_excess = mysqli_query($GLOBALS["___mysqli_ston"], $query1_excess) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res1_excess = mysqli_fetch_array($exec1_excess))
				{
					  			$quantity1_excess += $res1_excess['transaction_quantity'];
				} 
				 /////////////////////  Phy.Short /////////
				 $quantity2_Short=0;
				 $query12_Short = "SELECT transaction_quantity,storecode, entrydocno from transaction_stock where locationcode = '".$locationcode."' AND itemcode = '$medicinecode' AND  transactionfunction='0' and (description='Stock Damaged Minus Stock' or description='Stock Expired Minus Stock' or description='Stock Adj Minus Stock' ) and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec12_Short = mysqli_query($GLOBALS["___mysqli_ston"], $query12_Short) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res12_Short = mysqli_fetch_array($exec12_Short))
				{
					$quantity2_Short += $res12_Short['transaction_quantity'];
				} 
				//////////////////////////////////////////////////////

				if($openingbalance_on_date1==0 && $quantity1_purchase==0 && $quantity1_preturn==0 && $quantity1_receipts==0 && $quantity2_transferout==0 && $quantity2_sales==0 && $quantity1_refunds==0 && $closingstock_on_date2==0 && $quantity2_transferout_ownusage==0 && $quantity1_excess==0 && $quantity2_Short==0){

				}else{

					$snocount = $snocount + 1;
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
				} ?>
				 <tr <?php echo $colorcode; ?>>
				 	<td class="bodytext31" valign="center"  align="center"><?php echo $snocount; ?></td>
					<td class="bodytext31" valign="center"  align="left" ><strong><?=$itemname;?></strong></td>
				
            
            		  <td align="right" valign="right"  
                 class="bodytext31"><div align="right"><strong><?php echo number_format($openingbalance_on_date1,0,'.',',');?></strong></div></td>

				<td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity1_purchase,0,'.',','); ?>  </strong></td>

                 <td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity1_preturn,0,'.',','); ?>  </strong></td>
				
				<td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity1_receipts,0,'.',','); ?>  </strong></td>
       			
       			<td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity2_transferout,0,'.',','); ?>  </strong></td>


            <td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity2_sales,0,'.',',') ;  ?>  </strong></td>
               
			<td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity1_refunds,0,'.',','); ?>  </strong></td>

       			 <!-- <td align="left" valign="center"  
                 class="bodytext31"><strong> <?php //echo number_format($quantity1_purchase,0,'.',',') intval($balance);?> </strong></td> -->

                 <td align="right" valign="right"  
                 class="bodytext31"><strong> <?php echo number_format($quantity2_transferout_ownusage,0,'.',',');?> </strong></td>
                   <td align="right" valign="right"  
                 class="bodytext31"><strong> <?php echo number_format($quantity1_excess,0,'.',',');?> </strong></td>
                   <td align="right" valign="right"  
                 class="bodytext31"><strong> <?php echo number_format($quantity2_Short,0,'.',',');?> </strong></td>


                <td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($closingstock_on_date2,0,'.',','); ?>  </strong></td>
				 
				 
			</tr>
				<?php
				$openingbalance_on_date1_final        += $openingbalance_on_date1;
			$quantity1_purchase_final        +=$quantity1_purchase;
			$quantity1_preturn_final        +=$quantity1_preturn;
			$quantity1_receipts_final        +=$quantity1_receipts;
			$quantity2_transferout_final        +=$quantity2_transferout;
			$quantity2_sales_final        +=$quantity2_sales;
			$quantity1_refunds_final        +=$quantity1_refunds;
			$quantity2_transferout_ownusage_final        +=$quantity2_transferout_ownusage;
			$quantity1_excess_final        +=$quantity1_excess;
			$quantity2_Short_final        +=$quantity2_Short;
			$closingstock_on_date2_final  +=$closingstock_on_date2;
			} // if loop for all zeros has closed
				}
				// } // FIRST WHILE LOOP AFTER ELSE
}
}

else if($mainsearch=='3'){
?>

          	<tr>
             <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Sl. No</strong></td>   
				<td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Code</strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Description</strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Batch</strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Expiry</strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Opg.Stock</strong></div></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Purchase</strong></div></td>

                 <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Purchase Returns</strong></div></td>

                  <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Receipts</strong></div></td>

              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Issued To Dept</strong></div></td>

                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Sales</strong></div></td>


              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Refunds</strong></div></td>

                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Own Usage</strong></div></td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Phy.Excess</strong></div></td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Phy.Short</strong></div></td>

              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Closing Stock</strong></div></td>
				<!-- <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Username</strong></div></td> -->
				</tr>


<?php
$query_store = "SELECT * FROM `master_store`"; 
if($store!=''){ 
$query_store .= " where storecode='$store'  " ; 
	}
$exec_store = mysqli_query($GLOBALS["___mysqli_ston"], $query_store) or die ("Error in query_store".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res_store = mysqli_fetch_array($exec_store))
				{ 
					$store=$res_store['storecode'];
					 $storename=$res_store['store']; 
					?>
					<tr>
                <td bgcolor="#FF9900" colspan="15" class="bodytext3" align="left"><strong><?php echo $res_store['store']; ?></strong></td>
                </tr>
                <?php
				// $query991 = "select itemcode, categoryname, itemname from master_medicine where categoryname like '%$categoryname%' and itemcode like '%$searchmedicinecode%' and status <> 'deleted' group by categoryname order by categoryname, itemname";
				// $exec991 = mysql_query($query991) or die ("Error in Query991".mysql_error());
				// 				while ($res991 = mysql_fetch_array($exec991))
				// 				{
				// 					$categoryname2 = $res991['categoryname'];
				// 					$itemname = $res991['itemname'];
				?>
	            <!--  <tr>
       	        <td bgcolor="#FF9900" colspan="8" class="bodytext3" align="left"><strong><?php echo $categoryname2; ?></strong></td>
                </tr> -->
                <?php
				$sno = 0;
					$query99 = "SELECT b.itemcode, b.categoryname, b.itemname, a.batchnumber  from transaction_stock as a JOIN master_medicine as b on b.itemcode = a.itemcode where b.categoryname like '%$categoryname%' and b.itemcode like '%$searchmedicinecode%' group by a.itemcode,a.batchnumber order by b.itemname";
				// $query99 = "select itemcode, categoryname, itemname from master_medicine where categoryname = '$categoryname2' and itemcode like '%$searchmedicinecode%' and status <> 'deleted' order by itemname";
$exec99 = mysqli_query($GLOBALS["___mysqli_ston"], $query99) or die ("Error in Query99".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res99 = mysqli_fetch_array($exec99))
				{
					$categoryname2 = $res99['categoryname'];
					$medicinecode = $res99['itemcode'];
					$itemname = $res99['itemname'];
					$batchnumber = $res99['batchnumber'];
					$expiry_date = '';

			 $query_inner = "select expirydate from purchase_details where batchnumber = '$batchnumber' and itemcode='$medicinecode' 
			 union all select expirydate from materialreceiptnote_details where batchnumber = '$batchnumber' and itemcode='$medicinecode' limit 0,1 ";
				$exec_inner = mysqli_query($GLOBALS["___mysqli_ston"], $query_inner) or die ("Error in Query_inner".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res_inner = mysqli_fetch_array($exec_inner))
				{
					$expiry_date = $res_inner['expirydate'];
				}

				?>
				
                <?php
				//get store for location
// 	$loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';
// $username=isset($_REQUEST['username'])?$_REQUEST['username']:'';
//   $query5ll = "select ms.auto_number,ms.storecode,ms.store from master_employeelocation as me LEFT JOIN master_store as ms ON me.storecode=ms.auto_number where me.locationcode = '".$loc."' AND me.username= '".$username."'";
// if($store!='')
// {
// 	$query5ll .=" and ms.storecode='".$store."' group by ms.storecode";
// 	}
// 				$exec5ll = mysql_query($query5ll) or die ("Error in Query5ll".mysql_error());
// 				while ($res5ll = mysql_fetch_array($exec5ll))
// 				{
			
// 				}
                
				
				?>
				 
                
                <?php
                ////////////////////FIRST //////////////////
                // echo $openingbalance_on_date; 
                // $ADate12 = date('Y-m-d', strtotime('-1 day', strtotime($ADate1)));
                   $query1a = "SELECT sum(transaction_quantity) as addstock from transaction_stock where batchnumber='$batchnumber' and itemcode='$medicinecode' and locationcode='$location' and storecode ='$store' and transaction_date < '$ADate1' and transactionfunction='1'   ";
                 // echo $query1a = "SELECT sum(transaction_quantity) as addstock from transaction_stock where batchnumber='$batchnumber' and itemcode='$medicinecode' and locationcode='$location' and storecode ='$store' and transaction_date between '$ADate1' and '$ADate2' and transactionfunction='1' order by auto_number desc  ";
				$exec1a = mysqli_query($GLOBALS["___mysqli_ston"], $query1a) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	 
				$res1a = mysqli_fetch_array($exec1a);
				 $totaladdstock = $res1a['addstock'];
				
				$query1m = "SELECT sum(transaction_quantity) as minusstock from transaction_stock where batchnumber='$batchnumber' and itemcode='$medicinecode' and locationcode='$location' and storecode ='$store' and transaction_date < '$ADate1' and transactionfunction='0'   ";
				$exec1m = mysqli_query($GLOBALS["___mysqli_ston"], $query1m) or die(mysqli_error($GLOBALS["___mysqli_ston"]));		 
				$res1m = mysqli_fetch_array($exec1m);
				 $totalminusstock = $res1m['minusstock'];
				
				 $openingbalance_on_date1 = $totaladdstock-$totalminusstock;
				// $balance_close_stock1 = $openingbalance;
				 ///////////////////////second//////////////////
				 $quantity1_purchase=0;  //PURCHASE
                   $query1_purchase = "SELECT transaction_quantity from transaction_stock where locationcode = '".$locationcode."' AND batchnumber='$batchnumber' and itemcode = '$medicinecode' and transactionfunction='1' and (description='Purchase' or description='OPENINGSTOCK' or description='".$storename."' ) and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec1_purchase = mysqli_query($GLOBALS["___mysqli_ston"], $query1_purchase) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res1_purchase = mysqli_fetch_array($exec1_purchase))
				{
				
				  $quantity1_purchase += $res1_purchase['transaction_quantity'];

				} 
				//////////////////////THIRD /////////////////
				$quantity1_preturn=0;  //PURCHASE RETURN
                  $query1_pr = "SELECT transaction_quantity from transaction_stock where locationcode = '".$locationcode."' AND batchnumber='$batchnumber' and itemcode = '$medicinecode' and transactionfunction='0' and description='Purchase Return' and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec1_pr = mysqli_query($GLOBALS["___mysqli_ston"], $query1_pr) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res1_pr = mysqli_fetch_array($exec1_pr))
				{
				
				  $quantity1_preturn += $res1_pr['transaction_quantity'];

				} 
				/////////////////// FOURTH //////////////////
				$quantity2_transferout_ownusage=0;
				$quantity1_receipts=0; //	Receipts --> Transfer IN
				$quantity1_receipts_1=0;
				$quantity1_receipts_2=0;
				
                   $query1_receipts = "SELECT transaction_quantity,entrydocno, storecode from transaction_stock where locationcode = '".$locationcode."' AND batchnumber='$batchnumber' and itemcode = '$medicinecode' and transactionfunction='1' and description='Stock Transfer To'   and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec1_receipts = mysqli_query($GLOBALS["___mysqli_ston"], $query1_receipts) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res1_receipts = mysqli_fetch_array($exec1_receipts))
				{
				  // $quantity1_receipts += $res1_receipts['transaction_quantity'];

				  	$docno=$res1_receipts['entrydocno'];
					$storecode_fet=$res1_receipts['storecode'];

					 
                    $query1_receipts2 = "SELECT typetransfer from master_stock_transfer where `docno`='$docno' and itemcode = '$medicinecode' limit 0,1";
					$exec_receipts2 = mysqli_query($GLOBALS["___mysqli_ston"], $query1_receipts2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
					$res_receipts2 = mysqli_fetch_array($exec_receipts2);
					
						$typetransfer=$res_receipts2['typetransfer'];
						if($typetransfer=='Transfer'){
					  			$quantity1_receipts += $res1_receipts['transaction_quantity'];
					  		}else{
					  			$quantity2_transferout_ownusage += $res1_receipts['transaction_quantity'];
					  		}
				  	
				  	// $quantity1_receipts_1 = $quantity1_receipts+$quantity1_receipts1;
				  	// $quantity2_transferout_ownusage += $quantity2_transferout_ownusage1;
				} 
				//  $query1_receipts_2 = "SELECT transaction_quantity,entrydocno, storecode from transaction_stock where locationcode = '".$locationcode."' AND batchnumber='$batchnumber' and itemcode = '$medicinecode' and transactionfunction='1' and  description='Stock Adj Add Stock'  and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				// $exec1_receipts_2 = mysql_query($query1_receipts_2) or die(mysql_error());			
				// while($res1_receipts_2 = mysql_fetch_array($exec1_receipts_2))
				// {
				// 	  			$quantity1_receipts_2 += $res1_receipts_2['transaction_quantity'];
				// } 
				// $quantity1_receipts=$quantity1_receipts_1+$quantity1_receipts_2;

				//////////////// fifth ///////////////////////////////////
				 $quantity2_transferout=0;  //Transfer out
				 $quantity2_transferout_1=0;   
				 $quantity2_transferout_2=0;   
				 
                    $query12_transferout = "SELECT transaction_quantity,storecode, entrydocno from transaction_stock where locationcode = '".$locationcode."' AND batchnumber='$batchnumber' and itemcode = '$medicinecode' and transactionfunction='0' and description='Stock Transfer From'  and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec12_transferout = mysqli_query($GLOBALS["___mysqli_ston"], $query12_transferout) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res12_transferout = mysqli_fetch_array($exec12_transferout))
				{

					$docno=$res12_transferout['entrydocno'];
					$storecode_fet=$res12_transferout['storecode'];

					 
                    $query12_transferout2 = "SELECT typetransfer from master_stock_transfer where `docno`='$docno' and locationcode = '".$locationcode."' and itemcode = '$medicinecode'  and fromstore = '$storecode_fet'";
					$exec12_transferout2 = mysqli_query($GLOBALS["___mysqli_ston"], $query12_transferout2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
					$res12_transferout2 = mysqli_fetch_array($exec12_transferout2);
					
						$typetransfer=$res12_transferout2['typetransfer'];
						if($typetransfer=='Transfer'){
					  			$quantity2_transferout += $res12_transferout['transaction_quantity'];
					  		}else{
					  			$quantity2_transferout_ownusage += $res12_transferout['transaction_quantity'];
					  		}
				  	

				} 

				//  $query12_transferout = "SELECT transaction_quantity,storecode, entrydocno from transaction_stock where locationcode = '".$locationcode."' AND batchnumber='$batchnumber' and itemcode = '$medicinecode' and transactionfunction='0' and (description='Stock Damaged Minus Stock' or description='Stock Expired Minus Stock' or description='Stock Adj Minus Stock' ) and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				// $exec12_transferout = mysql_query($query12_transferout) or die(mysql_error());			
				// while($res12_transferout = mysql_fetch_array($exec12_transferout))
				// {
				// 	$quantity2_transferout_2 += $res12_transferout['transaction_quantity'];
				// } 
				// $quantity2_transferout=$quantity2_transferout_1+$quantity2_transferout_2;

				////////////////////////// SIXTH ///////////////
				$quantity2_sales=0;   // Sales
                    $query12_sales = "SELECT transaction_quantity from transaction_stock where locationcode = '".$locationcode."' AND batchnumber='$batchnumber' and itemcode = '$medicinecode' and transactionfunction='0' and (description='Sales' or description='Package' or description='IP Direct Sales' or description='IP Sales' or description='Process' ) and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec12_sales = mysqli_query($GLOBALS["___mysqli_ston"], $query12_sales) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res12_sales = mysqli_fetch_array($exec12_sales))
				{
				
				  $quantity2_sales += $res12_sales['transaction_quantity'];

				} 
				////////////////// SEVENTH ///////////////////////////
				$quantity1_refunds=0;   // Refunds
                  $query1_refunds = "SELECT transaction_quantity from transaction_stock where locationcode = '".$locationcode."' AND batchnumber='$batchnumber' and itemcode = '$medicinecode' and transactionfunction='1' and (description='Sales Return' or description='IP Sales Return' or description='Sales Return' ) and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec1_refunds = mysqli_query($GLOBALS["___mysqli_ston"], $query1_refunds) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res1_refunds = mysqli_fetch_array($exec1_refunds))
				{
				
				  $quantity1_refunds += $res1_refunds['transaction_quantity'];

				} 
				/////////////////////////// eight CLOSING STOCK ///////////////////

				$query1a_closingstock = "SELECT sum(transaction_quantity) as addstock from transaction_stock where batchnumber='$batchnumber' and itemcode='$medicinecode' and locationcode='$location' and storecode ='$store' and transaction_date <= '$ADate2' and transactionfunction='1' order by auto_number desc  ";
                 // echo $query1a = "SELECT sum(transaction_quantity) as addstock from transaction_stock where batchnumber='$batchnumber' and itemcode='$medicinecode' and locationcode='$location' and storecode ='$store' and transaction_date between '$ADate1' and '$ADate2' and transactionfunction='1' order by auto_number desc  ";
				$exec1a_closingstock = mysqli_query($GLOBALS["___mysqli_ston"], $query1a_closingstock) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	 
				$res1a_closingstock = mysqli_fetch_array($exec1a_closingstock);
				 $totaladdstock_closingstock = $res1a_closingstock['addstock'];
				
				$query1m_closingstock = "SELECT sum(transaction_quantity) as minusstock from transaction_stock where batchnumber='$batchnumber' and itemcode='$medicinecode' and locationcode='$location' and storecode ='$store' and transaction_date <= '$ADate2' and transactionfunction='0' order by auto_number desc  ";
				$exec1m_closingstock = mysqli_query($GLOBALS["___mysqli_ston"], $query1m_closingstock) or die(mysqli_error($GLOBALS["___mysqli_ston"]));		 
				$res1m_closingstock = mysqli_fetch_array($exec1m_closingstock);
				 $totalminusstock_closingstock = $res1m_closingstock['minusstock'];
				
				 $closingstock_on_date2 = $totaladdstock_closingstock-$totalminusstock_closingstock;

				 ///////////////////////////phy excess///////////////////////////
				 $quantity1_excess=0;
				 $query1_excess = "SELECT transaction_quantity,entrydocno, storecode from transaction_stock where locationcode = '".$locationcode."' AND batchnumber='$batchnumber' and itemcode = '$medicinecode' AND  transactionfunction='1' and  description='Stock Adj Add Stock'  and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec1_excess = mysqli_query($GLOBALS["___mysqli_ston"], $query1_excess) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res1_excess = mysqli_fetch_array($exec1_excess))
				{
					  			$quantity1_excess += $res1_excess['transaction_quantity'];
				} 
				 /////////////////////  Phy.Short /////////
				 $quantity2_Short=0;
				 $query12_Short = "SELECT transaction_quantity,storecode, entrydocno from transaction_stock where locationcode = '".$locationcode."' AND batchnumber='$batchnumber' and itemcode = '$medicinecode' AND  transactionfunction='0' and (description='Stock Damaged Minus Stock' or description='Stock Expired Minus Stock' or description='Stock Adj Minus Stock' ) and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec12_Short = mysqli_query($GLOBALS["___mysqli_ston"], $query12_Short) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res12_Short = mysqli_fetch_array($exec12_Short))
				{
					$quantity2_Short += $res12_Short['transaction_quantity'];
				} 
				//////////////////////////////////////////////////////

				if($openingbalance_on_date1==0 && $quantity1_purchase==0 && $quantity1_preturn==0 && $quantity1_receipts==0 && $quantity2_transferout==0 && $quantity2_sales==0 && $quantity1_refunds==0 && $closingstock_on_date2==0 && $quantity2_transferout_ownusage==0 && $quantity1_excess==0 && $quantity2_Short==0){

				}else{

					$snocount = $snocount + 1;
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
				} ?>
				 <tr <?php echo $colorcode; ?>>
				 	<td class="bodytext31" valign="center"  align="center"><?php echo $snocount; ?></td>
					<td class="bodytext31" valign="center"  align="left" ><strong><?=$medicinecode;?></strong></td>
					<td class="bodytext31" valign="center"  align="left" ><strong><?=$itemname;?></strong></td>
				
					<td class="bodytext31" valign="center"  align="left" ><strong><?=$batchnumber;?></strong></td>
				
					<td class="bodytext31" valign="center"  align="left" width="10px" ><strong><?php echo "'".$expiry_date; ?></strong></td>
					<!--<td class="bodytext31" valign="center"  align="left" width="10px" ><strong><?php echo ' '.date('Y',strtotime($expiry_date)).'/'.date('m',strtotime($expiry_date)).'/'.date('d',strtotime($expiry_date)).' '; ?></strong></td>-->
				
            
            		  <td align="right" valign="right"  
                 class="bodytext31"><div align="right"><strong><?php echo number_format($openingbalance_on_date1,0,'.',',');?></strong></div></td>

				<td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity1_purchase,0,'.',','); ?>  </strong></td>

                 <td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity1_preturn,0,'.',','); ?>  </strong></td>
				
				<td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity1_receipts,0,'.',','); ?>  </strong></td>
       			
       			<td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity2_transferout,0,'.',','); ?>  </strong></td>


            <td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity2_sales,0,'.',',') ;  ?>  </strong></td>
               
			<td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity1_refunds,0,'.',','); ?>  </strong></td>

       			 <!-- <td align="left" valign="center"  
                 class="bodytext31"><strong> <?php //echo number_format($quantity1_purchase,0,'.',',') intval($balance);?> </strong></td> -->

                 <td align="right" valign="right"  
                 class="bodytext31"><strong> <?php echo number_format($quantity2_transferout_ownusage,0,'.',',');?> </strong></td>
                   <td align="right" valign="right"  
                 class="bodytext31"><strong> <?php echo number_format($quantity1_excess,0,'.',',');?> </strong></td>
                   <td align="right" valign="right"  
                 class="bodytext31"><strong> <?php echo number_format($quantity2_Short,0,'.',',');?> </strong></td>


                <td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($closingstock_on_date2,0,'.',','); ?>  </strong></td>
				 
			</tr>
				<?php
				   $openingbalance_on_date1_final        += $openingbalance_on_date1;
			$quantity1_purchase_final        +=$quantity1_purchase;
			$quantity1_preturn_final        +=$quantity1_preturn;
			$quantity1_receipts_final        +=$quantity1_receipts;
			$quantity2_transferout_final        +=$quantity2_transferout;
			$quantity2_sales_final        +=$quantity2_sales;
			$quantity1_refunds_final        +=$quantity1_refunds;
			$quantity2_transferout_ownusage_final        +=$quantity2_transferout_ownusage;
			$quantity1_excess_final        +=$quantity1_excess;
			$quantity2_Short_final        +=$quantity2_Short;
			$closingstock_on_date2_final  +=$closingstock_on_date2;

			} // if loop for all zeros has closed
			

			     
			// $openingbalance_on_date1=
			// $quantity1_purchase=
			// $quantity1_preturn=
			// $quantity1_receipts=
			// $quantity2_transferout=
			// $quantity2_sales=
			// $quantity1_refunds=
			// $quantity2_transferout_ownusage=
			// $quantity1_excess=
			// $quantity2_Short=
			// $closingstock_on_date2=
				}
				// } // FIRST WHILE LOOP AFTER ELSE

				} // fetch_store close
			} // main if loop
}// main else for the main search ended				

				?>
				

		  </tbody>
		  <tfoot style="background-color: #FF9900;" >

		  		<td class="bodytext31" valign="center"  align="center"><?php echo ""; ?></td>
				<?php if($mainsearch=='3'){
				?>
		  			<td class="bodytext31" valign="center"  align="center"><?php echo ""; ?></td>
		  			<td class="bodytext31" valign="center"  align="center"><?php echo ""; ?></td>
		  			<td class="bodytext31" valign="center"  align="center"><?php echo ""; ?></td>
				<?php 
				}
				?>
				<td class="bodytext31" valign="center"  align="left" ><strong><?="Total";?></strong></td>
				<td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($openingbalance_on_date1_final,0,'.',',');?></strong></td>
				<td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($quantity1_purchase_final,0,'.',',');?></strong></td>
				<td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($quantity1_preturn_final,0,'.',',');?></strong></td>
				<td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($quantity1_receipts_final,0,'.',',');?></strong></td>
				<td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($quantity2_transferout_final,0,'.',',');?></strong></td>
				<td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($quantity2_sales_final,0,'.',',');?></strong></td>
				<td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($quantity1_refunds_final,0,'.',',');?></strong></td>
				<td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($quantity2_transferout_ownusage_final,0,'.',',');?></strong></td>
				<td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($quantity1_excess_final,0,'.',',');?></strong></td>
				<td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($quantity2_Short_final,0,'.',',');?></strong></td>
				<td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($closingstock_on_date2_final,0,'.',',');?></strong></td>
		  </tfoot>
		  </table>
          
          </td>
		  
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>    
  <tr>
    <td valign="top">    
  <tr>
    <td width="97%" valign="top">    
</table>