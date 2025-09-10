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
include('convert_currency_to_words.php');
if (isset($_REQUEST["suppliercode"])) { $suppliercode = $_REQUEST["suppliercode"]; } else { $suppliercode = ""; }
if (isset($_REQUEST["voucherno"])) { $voucherno = $_REQUEST["voucherno"]; } else { $voucherno = ""; }
if (isset($_REQUEST["docno"])) { $docno = $_REQUEST["docno"]; } else { $docno = ""; }
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
	//$cstnumber1 = $res2["cstnumber"];
	
	//include('convert_currency_to_words.php');
	
	$query12 = "select * from supplier_debits where invoice_id = '$docno' order by auto_number desc limit 0, 1 ";
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
	mysqli_num_rows($exec12);
	$res12 = mysqli_fetch_array($exec12);
	$res12billnumber = $res12['invoice_id'];
	$res12billingdatetime = $res12['invoice_date'];
	$res12suppliercode = $res12['supplier_id'];
	//$res12suppliername = $res12['suppliername'];
	//$res12bankname = $res12['appvdbank'];
	//$res12chequenumber = $res12['appvdcheque'];
	//$res12chequedate = $res12['appvdchequedt'];
	//$res12transactionmode = $res12['transactionmode'];
	
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
$mpesaamount21='';
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
//$cstnumber1 = $res2["cstnumber"];
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
	  <td width="172" colspan="2" class="bodytext32"><div align="left" style="font-size:18px;">SUPPLIER DEBIT NOTE</div></td>
  </tr>
		<tr>
			<td colspan="2" class="bodytext32"><div align="left"><?php echo $address1; ?>
		      <?php
			
			?>			
		    </div></td>
			<td colspan="2" class="bodytext32"><div align="left">Doc No : <?php echo $res12billnumber; ?></div></td>
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
</table>


<table width="530" border="0" cellpadding="0" cellspacing="0" align="center"> 
	<?php
		$query10 = "select *,sum(total_amount) as total_amount from supplier_debits where invoice_id = '$docno'";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res10 = mysqli_fetch_array($exec10);
		$docno = $res10['invoice_id'];
		$entrydate = $res10['invoice_date'];
		//$accountname = $res10['accountname'];
		$supplier_id = $res10['supplier_id'];
		$supplieramount = $res10['total_amount'];
		$ref_number = $res10['ref_number'];
		
		$query14 = "select * from master_accountname where id='$supplier_id'";
		$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res14 = mysqli_fetch_array($exec14);
		$accountname = $res14['accountname'];
	
		
	?> 	
	<tr>
		<td colspan="5" style="border-bottom:solid 1px #000000;">&nbsp;</td>
	</tr>
	<tr>
		<td colspan ="2" class="bodytext32">Docno : <?php echo $docno; ?></td>
		<td width="206" colspan="3" align="left" class="bodytext32">Entrydate : <?php echo $entrydate; ?></td>
	</tr>
	<tr>
		<td colspan="2" align="left" class="bodytext32">Account : <?php echo $accountname; ?></td>
		<td colspan="3" align="left" class="bodytext32">Supplier Amount : <?php echo number_format($supplieramount,2); ?></td>
	</tr>
	<tr>
		<td colspan="2" align="left" class="bodytext32">Ref : <?php echo $ref_number; ?></td>
	
	</tr>
	
	
	<tr>
		<td colspan="5">&nbsp;</td> 
	</tr>
</table>


<table width="530" border="0" align="center" cellpadding="0" cellspacing="0">
  
  <tr>
		<td width="25" align="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF; border-right:none;"><strong>Ref No</strong></td>
		<td width="50" align="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-left:none;border-right:none;"><strong>Date</strong></td>
		<td  width="60" align="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-left:none;border-right:none;"><strong>Item Description</strong></td>
		<td width="45" align="right" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-left:none;border-right:none;"><strong>Rate</strong></td>
		<td width="30" align="right" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-left:none;border-right:none;"><strong>Tax%</strong></td>
		<td width="50" align="right" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-left:none;border-right:none;"><strong>Tax Amount</strong></td>
		<td width="50" align="right" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-left:none;border-right:none;"><strong>Amount</strong></td>
		<td width="70" align="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-left:none;"><strong>Ledger</strong></td>
  </tr>
  
   <?php
			$colorloopcount = '';
			$sno = '';
			$remarks = '';	
			$totalamount = '0.00';
			$totalremittance = '0.00';
			$sumwithholdingamount = 0.00;
			$sumvatamount = 0.00;
			
			$query11 = "select * from supplier_debits where invoice_id = '$docno' order by auto_number desc";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			mysqli_num_rows($exec11);
			while($res11 = mysqli_fetch_array($exec11))
			{
			$res11billingdatetime = $res11['invoice_date'];
			$res11suppliercode = $res11['supplier_id'];
			$item_name = $res11['item_name'];
			$total_amount = $res11['total_amount'];
			$rate = $res11['rate'];
			$tax_percent = $res11['tax_percent'];
			$tax_amount = $res11['tax_amount'];
			$ledger_id = $res11['ledger_id'];
			
			
			$query131 = "select * from master_accountname where id = '$ledger_id'";
			$exec131 = mysqli_query($GLOBALS["___mysqli_ston"], $query131) or die ("Error in Query131".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res131 = mysqli_fetch_array($exec131);
			$res11ledgername = $res131['accountname'];
		
			$sumvatamount += $total_amount;
			$totalamount += $total_amount;
			
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
			<td class="bodytext32" valign="center"  align="center" style="border-left:solid 1px #000000;"><?php echo $colorloopcount; ?></td>
			<td class="bodytext32" valign="center"  align="left"><?php echo date('d-M-Y', strtotime($res11billingdatetime)); ?></td>
			<td width="60" align="center" valign="center" class="bodytext32"><?php echo $item_name; ?></td>
			<td align="right" valign="center" class="bodytext32"><?php echo number_format($rate,2); ?></td>
			<td align="right" valign="center" class="bodytext32"><?php echo number_format($tax_percent,2); ?></td>
			<td align="right" valign="center" class="bodytext32"><?php echo number_format($tax_amount,2); ?></td>
			<td align="right" valign="center" class="bodytext32"><?php echo number_format($total_amount,2); ?></td>
			<td align="center" valign="center" class="bodytext32" style="border-right:solid 1px #000000;"><?php echo $res11ledgername; ?></td>
			</tr>
			  <?php
			
			}
			
			
			$convertedwords = covert_currency_to_words($totalamount);
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
		 <td align="right" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF; border-left:none;border-right:none;"><?php echo number_format($sumwithholdingamount,2); ?></td>
		 <td align="right" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF; border-left:none;border-right:none;"><?php echo number_format($sumvatamount,2); ?></td>
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
		<td colspan="8" class="bodytext32">Amount : &nbsp;&nbsp;<?php echo str_replace('Kenya Shillings','',$convertedwords); ?></td>
	</tr>
	<tr>
	  <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
		<td colspan="8">&nbsp;</td>
  </tr>
	<tr>
		<td colspan="8" class="bodytext32">CONFIRMATION : I have checked  the payment voucher and confirmed that the description , rates ,prices and additions are correct.</td>
	</tr>
	<tr>
		<td colspan="4">&nbsp;</td>
		<td colspan="3">SIGNATURE</td>
		<td colspan="1">DATE</td>
	</tr>
	<tr>
		<td colspan="8">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="8">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4" align="left" class="bodytext32">Prepared By :   ---------------------------------------------------</td>
		<td colspan="3" align="left" class="bodytext32"> ---------------------------------------------</td>
		<td colspan="1" align="left" class="bodytext32">  ---------------------------</td>
	</tr>
	<tr>
		<td colspan="8" align="left" class="bodytext32">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="8" align="left" class="bodytext32">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4" align="left" class="bodytext32">Examined By :   --------------------------------------------------</td>
		<td colspan="3" align="left" class="bodytext32"> ---------------------------------------------</td>
		<td colspan="1" align="left" class="bodytext32">  ---------------------------</td>
	</tr>
	<tr>
		<td colspan="8" align="left" class="bodytext32">&nbsp;</td>
	</tr>
	
	<tr>
		<td colspan="8" align="left" class="bodytext32">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4" align="left" class="bodytext32">CFO By :   ---------------------------------------------------------</td>
		<td colspan="3" align="left" class="bodytext32"> ---------------------------------------------</td>
		<td colspan="1" align="left" class="bodytext32">  ---------------------------</td>
	</tr>
	<tr>
		<td colspan="8" align="left" class="bodytext32">&nbsp;</td>
	</tr>
	
	<tr>
		<td colspan="8" align="left" class="bodytext32">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4" align="left" class="bodytext32">CEO By :   ---------------------------------------------------------</td>
		<td colspan="3" align="left" class="bodytext32"> ---------------------------------------------</td>
		<td colspan="1" align="left" class="bodytext32">  ---------------------------</td>
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
$dompdf->stream("Supplier Debit Note.pdf", array("Attachment" => 0)); 
?>