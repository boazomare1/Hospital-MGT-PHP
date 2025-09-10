<?php
header('Content-Type: application/vnd.ms-excel');
// header('Content-Disposition: attachment;filename="Sales_dump_.xls"');
header('Cache-Control: max-age=80');

session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$total = '0.00';
$refund_total = '0.00';
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$grandtotal = 0;
$refund_gtotal = 0;
$total_price1 = 0;





if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }
if (isset($_REQUEST["store"]) ) { $store = $_REQUEST["store"]; } else { $store = ""; }
if (isset($_REQUEST["days"]) ) { $days = $_REQUEST["days"]; } else { $days = ""; }
//$categoryname = $_REQUEST['categoryname'];
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_REQUEST['frmflag1'];

//This include updatation takes too long to load for hunge items database.
include ("autocompletebuild_account2.php");
 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';


header('Content-Disposition: attachment;filename="Non_Moving_Stock_"'.$store.'"_"'.$days.'".xls"');


?>
<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1546" 
            align="left" border="1">
          <tbody>
          	<tr> <td colspan="10" align="center"><strong><u><h3>Non Moving Stock REPORT</h3></u></strong></td></tr>
          	 
          	<?php
          	$query156 = "SELECT * from master_store where storecode='$store'";
				$exec156 = mysqli_query($GLOBALS["___mysqli_ston"], $query156) or die ("Error in Query156".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res156 = mysqli_fetch_array($exec156);
						 $store_name_1=$res156['store'];
						?>
          
        <tr ><td colspan="10" align="center"><strong>Store is <?php echo $store_name_1; ?>,&nbsp;&nbsp;&nbsp;&nbsp;Non Moving Days Are :  <?php echo $days; ?></strong></td></tr>
        <tbody>
 			<tr>
             <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Item Code </strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Item Name </strong></td>
				
				<td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Category </strong></td>
				
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Last Transaction Date</strong></td>

                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Non Moving Days</strong></td>

                <!--  <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Batch Number</strong></td> -->
				      <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Current Stock</strong></div></td>

                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Cost Price</strong></div></td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
   
                  <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Store</strong></div></td>
            </tr>
			<?php
			
			if ($days!="")
			{

			// $query2 = "SELECT * FROM `transaction_stock` WHERE `batch_stockstatus`='1' and storecode='$store'  group by itemcode ";
				
				
			// $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			//   while ($res2 = mysql_fetch_array($exec2))
			//   {
		  	 // $res2['storecode'];
				$query2 = "SELECT sum(batch_quantity) as qty,storecode,transaction_date, itemcode, itemname  FROM `transaction_stock` WHERE `batch_stockstatus`='1' and storecode='$store' group by itemcode order by transaction_date asc";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while ($res2 = mysqli_fetch_array($exec2))
			  {
			  	$qty=$res2['qty'];
				  	$storecode=$res2['storecode'];

				  	$itemcode=$res2['itemcode'];
					$query3 = "SELECT * FROM `transaction_stock` WHERE itemcode='$itemcode' and `batch_stockstatus`='1' and storecode='$store' order by transaction_date desc limit 1  ";
					$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			  		while ($res3 = mysqli_fetch_array($exec3)){
			  			$trans_date=$res3['transaction_date'];
			  		}
				  	
				  	//$trans_date1=strtotime($res2['transaction_date']);
					$trans_date1=strtotime($trans_date);
				  	$today_date=strtotime($transactiondateto);

					$datediff = $today_date - $trans_date1;

					$diff_days = round($datediff / (60 * 60 * 24));
					
					
					
			$query72 = "select categoryname from master_medicine where itemcode='$itemcode' order by auto_number desc";

			$exec72 = mysqli_query($GLOBALS["___mysqli_ston"], $query72) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));	

			$num2 = mysqli_num_rows($exec72);

			$res72=mysqli_fetch_array($exec72);

			$categoryname = $res72['categoryname'];

					// $earlier = new DateTime($trans_date);
					// $later = new DateTime($transactiondateto);
					//  $diff = $later->diff($earlier)->format("%a")."--";
					if($days!=""){
						$noofdays_old=$days;
					}else{
						$noofdays_old="90";
					}
					
					// $qty=$res2['batch_quantity'];
					// $qty="0";
					// $itemcode=$res2['itemcode'];
					// $query3 = "SELECT * FROM `transaction_stock` WHERE itemcode='$itemcode'  ";
					// $exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
			  // 		while ($res3 = mysql_fetch_array($exec3)){
			  // 			$qty=$qty+$res3['batch_quantity'];
			  // 		}

					if(($diff_days>=$noofdays_old) && ($qty>0)){


					  	$snocount = $snocount + 1;
					    $colorloopcount = $colorloopcount + 1;
						$showcolor = ($colorloopcount & 1); 
						if ($showcolor == 0)
						{
							$colorcode = 'bgcolor="#CBDBFA"';
						}
						else
						{
							$colorcode = 'bgcolor="#ecf0f5"';
						}


					?>

		  <tr >
		  	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2['itemcode']; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2['itemname']; ?></div></td>
				
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $categoryname; ?></div></td>
				
				
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2['transaction_date']; ?></td>
			  
              <td class="bodytext31" valign="center"  align="center">
			    <div align="center"><?php echo $diff_days; ?></div></td>
				
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo $numb=$qty;
			      // echo number_format($numb,2,'.',',');
			       //echo number_format($res2['batch_quantity'],2,'.',','); ?></div></td>

				<!-- <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php //echo $res2['storecode']; ?></div></td> -->

			    <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php 
			    $itemcode=$res2['itemcode'];
			     $query112 = "SELECT * from master_medicine where itemcode='$itemcode'";
				$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res112 = mysqli_fetch_array($exec112);
						echo $pprice=$res112['purchaseprice'];
			     ?></div></td>

			     <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php 
			     $total_price=$pprice*$qty;
			     echo number_format($total_price,2,'.',','); 
			     ?></div></td>
				

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 

			    $query11 = "SELECT * from master_store where storecode='$storecode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						echo $store_name=$res11['store'];
												
			     ?></div></td>


           </tr>
		  <?php $total_price1=$total_price1+$total_price;
		  } // if condition
		   } //while
		  
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor=""><div align="right"><strong>&nbsp; </strong></div></td>
                        <td class="bodytext31" valign="center"  align="left" 
                bgcolor=""><div align="right"><strong><?php //echo $totalcurrentstock1; ?>&nbsp;</strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="">&nbsp;</td>

                 <td class="bodytext31" valign="center"  align="left" 
                bgcolor=""><div align="right"><strong>&nbsp;</strong></div></td>

                <td class="bodytext31" valign="center"  align="left" 
                bgcolor=""><div align="right"><strong><?php echo number_format($total_price1,2,'.',','); ?></strong></div></td>
               

              <td class="bodytext31" valign="center"  align="left" 
                bgcolor=""><div align="right"><strong>&nbsp;</strong></div></td>
                
                   <!-- <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php //echo number_format($totalpurchaseprice1,2,'.',','); ?>&nbsp;</strong></div></td>
				   <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php //echo number_format($grandtotalcogs,2,'.',','); ?>&nbsp;</strong></div></td>
       <td align="right" colspan="7"> <a target="_blank" href="xl_non_moving_stock.php?categoryname=<?= $categoryname; ?>&&store=<?= $store;?>&&location=<?= $reslocationanum;?>&&searchitemcode=<?= $searchcode;?>&&servicename=<?= $servicename;?>&ADate2=<?php echo $transactiondateto;?>"> <img src="images/excel-xls-icon.png" width="30" height="30"></a> </td> -->
            </tr>   
			<?php
			}
			?>
          </tbody>
        </table></td>
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
			

