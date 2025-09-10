<?php
session_start();
include ("db/db_connect.php");
date_default_timezone_set('Asia/Calcutta'); 
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];

ob_start();
if (isset($_REQUEST["suppliercode"])) { $suppliercode = $_REQUEST["suppliercode"]; } else { $suppliercode = ""; }

if (isset($_REQUEST["billnumber"])) { $billnumber = $_REQUEST["billnumber"]; } else { $billnumber = ""; }
//echo "hii".$billnumber;
	$query2 = "select * from master_company where auto_number = '$companyanum'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_fetch_array($exec2);
	$companyname = $res2["companyname"];
	$address1 = $res2["address1"];   
	$area = $res2["area"];
	$city = $res2["city"];
	$pincode = $res2["pincode"];
	$phonenumber1 = $res2["phonenumber1"];
	$phonenumber2 = $res2["phonenumber2"];
	$tinnumber1 = $res2["tinnumber"];
	$cstnumber1 = $res2["cstnumber"];
	
	//include('convert_currency_to_words.php');
	if($suppliercode==""){
	$query12 = "select * from master_transactionpharmacy where docno = '$billnumber' order by auto_number desc limit 0, 1 ";
		}else{
	$query12 = "select * from master_transactionpharmacy where docno = '$billnumber' and `suppliercode`  = '".$suppliercode."' order by auto_number desc limit 0, 1 ";
		}
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
	mysqli_num_rows($exec12);
	$res12 = mysqli_fetch_array($exec12);
	$res12billnumber = $res12['docno'];
	$res12billingdatetime = $res12['transactiondate'];
	$res12suppliercode = $res12['suppliercode'];
	$res12suppliername = $res12['suppliername'];
	$res12bankname = $res12['appvdbank'];
	$res12chequenumber = $res12['appvdcheque'];
	$res12chequedate = $res12['appvdchequedt'];
	
	$query14 = "select * from master_accountname where id='$res12suppliercode'";
	$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res14 = mysqli_fetch_array($exec14);
	$res14accountname = $res14['accountname'];
	$res14address = $res14['address'];
	$res14contact = $res14['contact'];
	
$cashamount21 = '';
$cardamount21 = '';
$onlineamount21 = '';
$chequeamount21 = '';
$tdsamount21 = '';
$writeoffamount21 = '';
$taxamount21 = '';
?>
<style type="text/css">
.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 14px; COLOR: #000000; 
}
</style>

<table width="530" border="0" cellpadding="0" cellspacing="0" align="center">  
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

    <td width="100" rowspan="4" align="left" valign="center" 
	 bgcolor="#ffffff" class="bodytext31">
	
	<?php
			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec3showlogo = mysqli_query($GLOBALS["___mysqli_ston"], $query3showlogo) or die ("Error in Query3showlogo".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3showlogo = mysqli_fetch_array($exec3showlogo);
			$showlogo = $res3showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{
			?>
				
			<img src="logofiles/<?php echo $companyanum;?>.jpg" width="100" height="100" />
			
			<?php
			}
			?>	</td>
			
 
			<td colspan="2" class="bodytext32"><div align="left"><?php echo $companyname; ?>
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
	  <td width="172" colspan="2" class="bodytext32"><div align="left" style="font-size:18px;">PAYMENT VOUCHER</div></td>
  </tr>
		<tr>
			<td colspan="2" class="bodytext32"><div align="left"><?php echo $address1; ?>
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
			<td colspan="2" class="bodytext32"><div align="left">Remittance : <?php echo $res12billnumber; ?></div></td>
		</tr>
		<tr>
			<td colspan="2" class="bodytext32">
			
			  <div align="left"><?php echo $address2; ?>
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
			<td colspan="2" class="bodytext32"><div align="left">Date :  <?php echo date("d-M-Y", strtotime($res12billingdatetime)); ?></div></td>
		</tr>

<tr>
<td colspan="4" style="">&nbsp;</td>
</tr>
<tr>
<td colspan="5" style="border-bottom:solid 1px #000000;">&nbsp;</td>
</tr>
</table>
<table width="530" border="0" cellpadding="0" cellspacing="0" align="center">  
	<tr>
		<td colspan ="2" class="bodytext32"><?php echo $res12suppliername; ?> (<?php echo $res12suppliercode; ?>)</td>
		<td width="206" colspan="3" align="left" class="bodytext32">Bank : <?php echo $res12bankname; ?></td>
	</tr>
	<tr>
		<td colspan ="2" class="bodytext32"><?php echo $res14address; ?></td>
		<td colspan="3" align="left" class="bodytext32">Cheque No : <?php echo $res12chequenumber; ?></td>
	</tr>
	<tr>
		<td colspan ="2" class="bodytext32"><?php echo $res14contact; ?></td>
		<td colspan="3" align="left" class="bodytext32">Cheque Date : <?php if($res12chequedate != '') { echo date('d-m-Y',strtotime($res12chequedate));} else { echo '';} ?></td>
	</tr>
	<tr>
		<td colspan="5">&nbsp;</td> 
	</tr>
</table>

<table width="530" border="0" align="center" cellpadding="0" cellspacing="0">
  
  <tr>
	  <td width="25" align="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF; border-right:none;"><strong>Ref No</strong></td>
	  <td width="50" align="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-left:none;border-right:none;"><strong>Date</strong></td>
	  <td colspan="2" width="60" align="left" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-left:none;border-right:none;"><strong>Details</strong></td>
    <td width="50" align="right" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-left:none;border-right:none;"><strong>Voucher Amount</strong></td>
	 <!--<td width="30" align="right" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-left:none;border-right:none;"><strong>Remittance</strong></td>-->
	  <td width="30" align="right" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-left:none;border-right:none;"><strong>Withholding</strong></td>
	   <td width="50" align="right" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-left:none;border-right:none;"><strong>VAT Amount</strong></td>
	    <td width="70" align="right" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-left:none;"><strong>Balance</strong></td>
  </tr>
  
   <?php
			$colorloopcount = '';
			$sno = '';
				
			$totalamount = '0.00';
			$totalremittance = '0.00';
			
			$query11 = "select * from master_transactionpharmacy where docno = '$billnumber' and transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and recordstatus = 'allocated' order by auto_number desc";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			mysqli_num_rows($exec11);
			while($res11 = mysqli_fetch_array($exec11))
			{
			$res11billnumber = $res11['billnumber'];
			$res11billingdatetime = $res11['transactiondate'];
			$res11patientpaymentmode = $res11['transactionmode'];
			$res11username = $res11['username'];
			$res11cashamount = $res11['cashamount'];
			$res11transactionamount = $res11['transactionamount'];
			//$convertedwords = covert_currency_to_words($res11transactionamount); 
			$res11chequeamount = $res11['chequeamount'];
			$res11cardamount = $res11['cardamount'];
			$res11onlineamount= $res11['onlineamount'];
			$res11creditamount= $res11['creditamount'];
			$res11updatetime= $res11['updatedate'];
			$res11suppliercode = $res11['suppliercode'];
			$res11suppliername = $res11['suppliername'];
			$res11balanceamount = $res11['balanceamount'];
			$remarks = $res11['remarks'];
			$billnumber1 = $res11billnumber;
			
			$query13 = "select * from master_purchase where billnumber = '$res11billnumber'";
			$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res13 = mysqli_fetch_array($exec13);
			$res13totalamount = $res13['totalamount'];
			$mrnno = $res13['mrnno'];
			//if($res12billnumber==''){$res11transactionamount=0;}
			$approved_amount = 0;

			$query34 = "select sum(approved_amount) as approved_amount from master_transactionpharmacy where transactiontype = 'PURCHASE' and transactionmode <> 'CREDIT' and billnumber = '$billnumber1' and companyanum='$companyanum' and  approved_payment = '1'";
			$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die ("Error in Query34".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num=mysqli_num_rows($exec34);
			while ($res34 = mysqli_fetch_array($exec34))
			{
				//$approved_amount = $res34['approved_amount'];
			}
			
			$query3 = "select * from master_transactionpharmacy where transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and billnumber = '$billnumber1' and companyanum='$companyanum' and recordstatus = 'allocated'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num=mysqli_num_rows($exec3);
			while ($res3 = mysqli_fetch_array($exec3))
			{
				//echo $res3['auto_number'];
				$cashamount1 = $res3['cashamount'];
				$onlineamount1 = $res3['onlineamount'];
				$chequeamount1 = $res3['chequeamount'];
				$cardamount1 = $res3['cardamount'];
				$tdsamount1 = $res3['tdsamount'];
				$writeoffamount1 = $res3['writeoffamount'];
				$taxamount1 = $res3['taxamount'];
				
				$cashamount21 = $cashamount21 + $cashamount1;
				$cardamount21 = $cardamount21 + $cardamount1;
				$onlineamount21 = $onlineamount21 + $onlineamount1;
				$chequeamount21 = $chequeamount21 + $chequeamount1;
				$tdsamount21 = $tdsamount21 + $tdsamount1;
				$writeoffamount21 = $writeoffamount21 + $writeoffamount1;
				$taxamount21 = $taxamount21 + $taxamount1;
			}
			
			$totalreturn = 0;			
			$query38 = "select totalamount from purchasereturn_details where grnbillnumber = '$mrnno'";
			$exec38 = mysqli_query($GLOBALS["___mysqli_ston"], $query38) or die ("Error in Query38".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num=mysqli_num_rows($exec38);
			while ($res38 = mysqli_fetch_array($exec38))
			{
				$return = $res38['totalamount'];
				$totalreturn = $totalreturn + $return;
			}
			
			$totalpayment = $cashamount21 + $chequeamount21 + $onlineamount21 + $cardamount21 + $taxamount21;
			$netpayment = $totalpayment + $tdsamount21 + $writeoffamount21;
							
			$balanceamount = $res13totalamount - $netpayment - $approved_amount - $totalreturn;
			$balanceamount = number_format($balanceamount, 2, '.', '');	

			//$res11balanceamount = $balanceamount;
			
			$totalremittance = $totalremittance + $res13totalamount;
			$totalamount = $totalamount + $res11transactionamount;
			
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
			
			?>
			  <tr <?php //echo $colorcode; ?>>
             
			   <td class="bodytext32" valign="center"  align="center" style="border-left:solid 1px #000000;">
			   <?php echo $colorloopcount; ?></td>
				<td class="bodytext32" valign="center"  align="left">
			   <?php echo date('d-M-Y', strtotime($res11billingdatetime)); ?></td>
				<td colspan="2" class="bodytext32" valign="center"  align="left">
			  <?php echo 'Invoice : '.$res11billnumber; ?></td>
				<td align="right" valign="center" class="bodytext32">
			   <?php echo number_format($res11transactionamount,2,'.',','); ?></td>
			   <td align="right" valign="center" class="bodytext32">
			   <?php echo '0.00'; ?></td>
			    <td align="right" valign="center" class="bodytext32">
			   <?php echo '0.00'; ?></td>
			   	<td align="right" valign="center" class="bodytext32" style="border-right:solid 1px #000000;">
			   <?php if($res12billnumber==''){ echo number_format($res11balanceamount,2,'.',',');} else{echo number_format($res11balanceamount,2,'.',',');} ?></td>
              </tr>
			  <?php
			
			}
			?>
			
			   <tr>
	            <td style="border-left:solid 1px #000000;">&nbsp;</td>
	            <td align="right">&nbsp;</td>
	            <td align="right">&nbsp;</td>
				<td align="right">&nbsp;</td>
				 <td align="right">&nbsp;</td>
	            <td align="right">&nbsp;</td>
				 <td align="right">&nbsp;</td>
	            <td align="right" style="border-right:solid 1px #000000;">&nbsp;</td>
  </tr>
    <tr>   
		<td colspan="4" align="left" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-right:none;">Total:</td>
		<td align="right" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF; border-left:none;border-right:none;"><?php echo number_format($totalamount,2,'.',','); ?></td>
		 <td align="right" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF; border-left:none;border-right:none;">0.00</td>
	            <td align="right" style="border:solid 1px #000000; background:#FFFFFF; border-left:none;border-right:none;">&nbsp;</td>
				 <td align="right" style="border:solid 1px #000000; background:#FFFFFF; border-left:none;">&nbsp;</td>
	</tr> 
	 <tr>
	            <td>&nbsp;</td>
	            <td align="right">&nbsp;</td>
	            <td align="right">&nbsp;</td>
	            <td align="right">&nbsp;</td>
				 <td align="right">&nbsp;</td>
	            <td align="right">&nbsp;</td>
				 <td align="right">&nbsp;</td>
	            <td align="right">&nbsp;</td>
  </tr>
	<tr>
	  <td colspan="8">&nbsp;</td>
  </tr>
	<tr>
		<td colspan="8" class="bodytext32">Remarks : <?php echo $remarks; ?></td>
	</tr>
	<tr>
		<td colspan="8">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="8">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="8" align="left" class="bodytext32">Prepared By :   ---------------------------------------------------</td>
	</tr>
	<tr>
		<td colspan="8" align="left" class="bodytext32">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="8" align="left" class="bodytext32">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="8" align="left" class="bodytext32">Examined By :   --------------------------------------------------</td>
	</tr>
	<tr>
		<td colspan="8" align="left" class="bodytext32">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="8" align="left" class="bodytext32">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="8" align="left" class="bodytext32">Cheque Verified By :   ------------------------------------------</td>
	</tr>
	<tr>
		<td colspan="8" align="left" class="bodytext32">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="8" align="left" class="bodytext32">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="8" align="left" class="bodytext32">Approved By :   --------------------------------------------------</td>
	</tr>
</table> 
	
<?php	
require_once("dompdf/dompdf_config.inc.php");
$html =ob_get_clean();
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper("A4");
$dompdf->render();
$canvas = $dompdf->get_canvas();
//$canvas->line(10,800,800,800,array(0,0,0),1);
$font = Font_Metrics::get_font("times-roman", "normal");
$canvas->page_text(272, 814, "Page {PAGE_NUM}/{PAGE_COUNT}", $font, 10, array(0,0,0));
$dompdf->stream("PaymentReport.pdf", array("Attachment" => 0)); 
?>