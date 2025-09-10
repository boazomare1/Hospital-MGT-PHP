<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$sno = 0;
$totalrate = 0.00;
$colorloopcount = '';

if (isset($_REQUEST["docnumber"])) { $docnumber = $_REQUEST["docnumber"]; } else { $docnumber = ""; }
if (isset($_REQUEST["ADate1"])) { $fromdate = $_REQUEST["ADate1"]; } else { $fromdate = ""; }
if (isset($_REQUEST["ADate2"])) { $todate = $_REQUEST["ADate2"]; } else { $todate = ""; }
if (isset($_REQUEST["store"])) { $store1 = $_REQUEST["store"]; } else { $store = ""; }
if (isset($_REQUEST["location"])) { $location1 = $_REQUEST["location"]; } else { $location1 = ""; }
$query6 = "select store from master_store where storecode='$store1'";
$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
$num6 = mysqli_num_rows($exec6);		
$res6 = mysqli_fetch_array($exec6);
$res1storename =$res6['store'];
$query5 = "select locationname from master_location where locationcode='$location1'";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
$num5 = mysqli_num_rows($exec5);		
$res5 = mysqli_fetch_array($exec5);
$res1locationname =$res5['locationname'];
?>

	  <table cellspacing="0" cellpadding="4" width="1002" 
            align="left" border="0">
			 <tr>
             <td colspan="9">&nbsp;</td>
           </tr>
           <tr>
             <td colspan="9">&nbsp;</td>
           </tr>
           <tr>
<?php 
$query2 = "select * from master_company where auto_number = '$companyanum'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$companyname = $res2["companyname"];
$address1 = $res2["address1"];
$address2 = $res2["address2"];
$area = $res2["area"];
$city = $res2["city"];
$pincode = $res2["pincode"];
$phonenumber1 = $res2["phonenumber1"];
$phonenumber2 = $res2["phonenumber2"];
$tinnumber1 = $res2["tinnumber"];
$cstnumber1 = $res2["cstnumber"];
?>
			<td colspan="9">
			  <div align="center">
			    <?php
			$strlen2 = strlen($companyname);
			$totalcharacterlength2 = 35;
			$totalblankspace2 = 35 - $strlen2;
			$splitblankspace2 = $totalblankspace2 / 2;
			for($i=1;$i<=$splitblankspace2;$i++)
			{
			$companyname = ' '.$companyname.' ';
			}
			?>			
	        </div></td>
  </tr>
		<tr>
			<td colspan="9"><div align="center"><?php echo $companyname; ?>
		      <?php
			$strlen3 = strlen($address1);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address1 = ' '.$address1.' ';
			}
			?>			
		    </div></td>
		</tr>
		<tr>
			<td colspan="9"><div align="center"><?php echo $address1; ?>
		      <?php
			$address2 = $area.''.$city.' '.$pincode.'';
			$strlen3 = strlen($address2);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address2 = ' '.$address2.' ';
			}
			?>			
		    </div></td>
		</tr>
		<tr>
			<td colspan="9">
			
			  <div align="center"><?php echo $address2; ?>
		        <?php
			$address3 = "PHONE: ".$phonenumber1.' '.$phonenumber2;
			$strlen3 = strlen($address3);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address3 = ' '.$address3.' ';
			}
			?>			
	        </div></td>
		</tr>
             <tr>
               <td colspan="9"  align="left" valign="middle">&nbsp;</td>
             </tr>
             <tr>
			 <td colspan="9"  align="left" valign="middle"><strong>Opening Stock Entry: <?php echo $docnumber.'/'.$res1storename.'/'.$res1locationname; ?></strong></td>
			 </tr>
			  <tr>
			    <td  valign="center"  align="left" 
					bgcolor="#ffffff">&nbsp;</td>
			    <td  align="left" valign="center" 
					bgcolor="#ffffff" class="style2">&nbsp;</td>
			    <td  align="right" valign="center" 
					bgcolor="#ffffff" class="style2">&nbsp;</td>
			    <td  align="right" valign="center" 
					bgcolor="#ffffff" class="style2">&nbsp;</td>
			    <td  align="right" valign="center" 
					bgcolor="#ffffff" >&nbsp;</td>
			    <td  align="right" valign="center" 
					bgcolor="#ffffff" >&nbsp;</td>
                    <td  align="right" valign="center" 
					bgcolor="#ffffff" class="style2">&nbsp;</td>
			    <td  align="right" valign="center" 
					bgcolor="#ffffff" >&nbsp;</td>
	    </tr>
			  <tr>
			    <td width="41"  valign="center"  align="left" 
					bgcolor="#ffffff"><strong>S.No.</strong></td>
				  				  <td width="172"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><strong>Item</strong></td>
				  				  <td width="75"  align="right" valign="center" 
					bgcolor="#ffffff" class="style2"><strong>Cost Price </strong></td>
				  				 <td width="102"  align="right" valign="center" 
					bgcolor="#ffffff" class="style2"><strong>Sales Price</strong> </td>
				  				  <td width="149"  align="right" valign="center" 
					bgcolor="#ffffff" class="style2"><strong>Upload Qty</strong></td>
				  				  <td width="142"  align="right" valign="center" 
					bgcolor="#ffffff" class="style2"><strong>Qty</strong></td>
                    <td width="144"  align="right" valign="center" 
					bgcolor="#ffffff" class="style2"><strong>Cost Of Upload Qty</strong></td>
				  				  <td width="113"  align="right" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><strong>Expiry Date </strong></td>
		    </tr>					
           <?php
		   $totalcost=0;
		   $totalsales=0;
		$query1 = "select entrydocno,itemname,itemcode,transaction_date,transaction_quantity,fifo_code from transaction_stock where entrydocno='$docnumber' and description='OPENINGSTOCK'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
		
		while($res1 = mysqli_fetch_array($exec1))
		{
			$res1billnumber =$res1['entrydocno'];
			$res1itemname =$res1['itemname'];
			$res1itemcode =$res1['itemcode'];
			$res1transactiondate =$res1['transaction_date'];
			$res1expirydate ='';
			$res1quantity =$res1['transaction_quantity'];
			$res1fifo_code =$res1['fifo_code'];
			//$res1rateperunit ='0';
			$res1totalrate ='0';
			
			
			$query2 = "select purchaseprice,rateperunit from master_medicine where itemcode='$res1itemcode'";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num2=mysqli_num_rows($exec2);		
			$res2 = mysqli_fetch_array($exec2);
			$res1rateperunit =$res2['purchaseprice'];
			$res1sells =$res2['rateperunit'];
			$totalcost = $totalcost + $res1rateperunit;
			$totalsales = $totalsales + $res1sells;
			$colorloopcount = $colorloopcount + 1;
			
			$query3 = "select sum(transaction_quantity) as qty from transaction_stock where itemcode='$res1itemcode' and description in ('IP Direct Sales','Sales')";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num3 = mysqli_num_rows($exec3);		
			$res3 = mysqli_fetch_array($exec3);
			$res3qty =$res3['qty'];
			$cogs = $res1quantity*$res1rateperunit;
			$query4 = "select expirydate from purchase_details where itemcode='$res1itemcode' and fifo_code ='$res1fifo_code'";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num4 = mysqli_num_rows($exec4);		
			$res4 = mysqli_fetch_array($exec4);
			$res1expirydate =$res4['expirydate'];
			$totalcogs = $totalsales + $cogs;
		 ?>
		 	<tr>
		 	  <td align="left" valign="center" ><?php echo $sno= $sno + 1; ?></td>
	        	<td align="left" valign="center" ><?php echo $res1itemname; ?></td>
				<td align="right" valign="center" ><?php echo number_format($res1rateperunit,2,'.',','); ?></td>
				<td align="right" valign="center" class="bodytext31"><?php echo number_format($res1sells,2,'.',','); ?></td>
				<td align="right" valign="center" class="bodytext31"><?php echo number_format($res1quantity,2,'.',','); ?></td>
				<td align="right" valign="center" class="bodytext31"><?php echo number_format($res3qty,2,'.',','); ?></td>
                <td align="right" valign="center" class="bodytext31"><?php echo number_format($cogs,2,'.',','); ?></td>
				<td align="right" valign="center" ><?php echo $res1expirydate; ?></td>
			</tr>	
	      <?php } ?>		
		
			 <tr>
			   <td  valign="center" bordercolor="#f3f3f3" align="left">&nbsp;</td>
			   <td align="right" valign="center" bordercolor="#f3f3f3" >&nbsp;</td>
			   <td align="right" valign="center" bordercolor="#f3f3f3" >&nbsp;</td>
			   <td align="left" valign="center" bordercolor="#f3f3f3" >&nbsp;</td>
			   <td align="left" valign="center" bordercolor="#f3f3f3" >&nbsp;</td>
			   <td align="left" valign="center" bordercolor="#f3f3f3" >&nbsp;</td>
               <td align="right" valign="center" bordercolor="#f3f3f3" >&nbsp;</td>
			   <td align="left" valign="center" bordercolor="#f3f3f3" >&nbsp;</td>
	    </tr>
			 <tr>
				<td  valign="center" bordercolor="#f3f3f3" align="left">&nbsp;</td>
				<td align="right" valign="center" bordercolor="#f3f3f3" ><strong>Total</strong></td>
				<td align="right" valign="center" bordercolor="#f3f3f3" ><strong><?php echo number_format($totalcost,2,'.',','); ?></strong></td>
				<td align="right" valign="center" bordercolor="#f3f3f3" ><strong><?php echo number_format($totalsales,2,'.',','); ?></strong></td>
				<td align="left" valign="center" bordercolor="#f3f3f3" >&nbsp;</td>
				<td align="left" valign="center" bordercolor="#f3f3f3" >&nbsp;</td>
                <td align="right" valign="center" bordercolor="#f3f3f3" ><strong><?php echo number_format($totalcogs,2,'.',','); ?></strong></td>
			   <td align="left" valign="center" bordercolor="#f3f3f3" >&nbsp;</td>
			</tr>		
</table>
<?php

    $content = ob_get_clean();

    // convert in PDF
    require_once('html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('L', 'A4', 'en');
//      $html2pdf->setModeDebug();
        //$html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('viewopeningstockentry.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>


