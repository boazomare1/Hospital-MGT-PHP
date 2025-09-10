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
 
if (isset($_REQUEST["billnumber"])) { $billnumber = $_REQUEST["billnumber"]; } else { $billnumber = ""; }

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
	
	$query12 = "select * from master_transactionpaylater where docno= '$billnumber' and docno like 'AR-%' and transactionstatus='onaccount' ";
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
	mysqli_num_rows($exec12);
	$res12 = mysqli_fetch_array($exec12);
	$res12billnumber = $res12['docno'];
	$res12billingdatetime = $res12['transactiondate'];
	//$res12suppliercode = $res12['expensecoa'];
	//$res12suppliername = $res12['expenseaccount'];
	$res12bankname = $res12['bankname'];
	$accountname=$res12['accountname'];
	$res12branch = $res12['bankbranch'];
	$res12chequenumber = $res12['chequenumber'];
	$res12chequedate = $res12['chequedate'];
	 $transactionmode=$res12['transactionmode'];
	 $res11remarks= $res12['remarks'];
	 
	 $accountid=mysqli_query($GLOBALS["___mysqli_ston"], "select id from master_accountname where accountname ='$accountname'");
	 $resaccid=mysqli_fetch_array($accountid);
	 $accountidnum=$resaccid['id'];
	 
//$res12accnum = $res12['accnumber'];
	
	
	 
	 

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
	  <td width="172" colspan="2" class="bodytext32"><div align="left" style="font-size:18px;">&nbsp;</div></td>
  </tr>
		<tr>
			<td colspan="2" class="bodytext32"><div align="left"><?php echo $address1; ?>
		      <?php
			
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
			<td colspan="4" class="bodytext32"><div align="left">Tel: <?php echo $phonenumber1; ?>
		    </div></td>
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
<td colspan="5" align="center"><strong>PAYMENT RECEIPT</strong></td>
</tr> 
<tr>
<td colspan="5" align="center"><strong>&nbsp;</strong></td>
</tr> 
	<tr>
		<td colspan ="2" class="bodytext32"><?php if($res12bankname !=''){ echo $accountname; } else { echo $accountname; }?> </td>
		<td width="151" colspan="3" align="left" class="bodytext32"><?php echo $res12branch; ?></td>
  </tr>

  <tr>
		<td colspan ="2" class="bodytext32"><?php if($accountname !=''){ echo $accountidnum; } else { echo "&nbsp;";} ?></td>
        <?php if($transactionmode =="CHEQUE")
{?>
		<td width="151" colspan="3" align="left" class="bodytext32">Cheque No : <?php echo $res12chequenumber; ?></td>
	</tr>
	<tr>
		<td colspan ="2" class="bodytext32"></td>
		<td colspan="3" align="left" class="bodytext32">Cheque Date : <?php if($res12chequedate != '') { echo date('d-m-Y',strtotime($res12chequedate));} else { echo '';} ?>
        
	</tr>
   
	
	<tr>
   <?php }
   else
   {?>
	 <tr>
		<td colspan ="2" class="bodytext32">&nbsp;</td>
		<td colspan="3" align="left" class="bodytext32">&nbsp;
        </td>
        
        
	</tr>
   <?php }
   ?> 
	<tr>
    <td colspan="5">&nbsp;</td>
    </tr>	
	
</table>

<table width="523" border="0" align="center" cellpadding="0" cellspacing="0">
  
  <tr>
	  <td width="82" align="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF; border-right:none;"><strong>Date</strong></td>
	  <td width="136" align="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-left:none;border-right:none;">Bank Name</td>
      <td width="216" align="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-left:none;border-right:none;">Details</td>
	<td width="89" align="right" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-left:none;"><strong>Trans Amount</strong></td>
    
   
	
	 
  </tr>
  
   <?php
			$colorloopcount = '';
			$sno = '';
				
			$totalamount = '';
			$totalremittance = '';
			
			$query11 = "select * from master_transactionpaylater where docno = '$billnumber' and docno like 'AR-%' and transactionstatus='onaccount'";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			mysqli_num_rows($exec11);
			while($res11 = mysqli_fetch_array($exec11))
			{
			$res11billnumber = $res11['docno'];
			$res11billingdatetime = $res11['transactiondate'];
			$res11patientpaymentmode = $res11['transactionmode'];
			//$res11username = $res11['personname'];
			$res11bankname = $res11['bankname'];
			$res11transactionamount = $res11['transactionamount'];
			$res11fxrate = $res11['fxrate'];
			$res11receiptamount = ($res11transactionamount/$res11fxrate);
			//$convertedwords = covert_currency_to_words($res11transactionamount); 
			//$res11chequeamount = $res11['chequeamount'];
			$res11transactiontype = $res11['transactiontype'];
			//$res11onlineamount= $res11['onlineamount'];
		//	$res11creditamount= $res11['creditamount'];
			//$res11updatetime= $res11['updatedate'];
				//$res11remarks= $res11['remarks'];
			
			
			
		
			$totalamount = $totalamount + $res11receiptamount;
			
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
             
			   <td class="bodytext32" valign="center"  align="center" style="border-left:solid 1px #000000;"><?php echo date('d-M-Y', strtotime($res11billingdatetime)); ?></td>
				<td class="bodytext32" valign="center"  align="center"><?php if($res12bankname !=''){ echo $res12bankname; } else { echo $accountname; }?></td>
				<td class="bodytext32" valign="center"  align="center"><?php echo $res11transactiontype." by ".$transactionmode; ?></td>
				
               <td align="right" valign="center" class="bodytext32" style="border-right:solid 1px #000000;">
			  <?php echo number_format($res11receiptamount,2,'.',','); ?></td>
  </tr>
			  <?php
			
			}
			?>
			
    <tr>   
		<td colspan="2" align="left" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-right:none">&nbsp;</td>
		<td align="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-left:none;border-right:none;">Total:</td>
		<td width="89" align="right" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF; border-left:none;"><?php echo number_format($totalamount,2,'.',','); ?></td>      
				 
	</tr> 
	
 
	<tr>
	  <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
		<td colspan="4" class="bodytext32">Remarks : <?php echo $res11remarks; ?></td>
	</tr>
	<tr>
		<td colspan="4" class="bodytext32"><?php //echo $convertedwords; ?></td>
	</tr>
	<tr>
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4" align="left" class="bodytext32">Prepared By :   ---------------------------------------------------</td>
	</tr>
	<!--<tr>
		<td colspan="4" align="left" class="bodytext32">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4" align="left" class="bodytext32">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4" align="left" class="bodytext32">Examined By :   --------------------------------------------------</td>
	</tr> -->
	<tr>
		<td colspan="4" align="left" class="bodytext32">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4" align="left" class="bodytext32">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4" align="left" class="bodytext32">Cheque Verified By :   ------------------------------------------</td>
	</tr>
	<tr>
		<td colspan="4" align="left" class="bodytext32">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4" align="left" class="bodytext32">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4" align="left" class="bodytext32">Approved By :   --------------------------------------------------</td>
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