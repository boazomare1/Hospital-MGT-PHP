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
	$cstnumber1 = $res2["cstnumber"];
	
	//include('convert_currency_to_words.php');
	
	$query12 = "select * from master_transactiondoctor where docno = '$docno' order by auto_number desc limit 0, 1 ";
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
	mysqli_num_rows($exec12);
	$res12 = mysqli_fetch_array($exec12);
	$res12billnumber = $res12['docno'];
	$res12billingdatetime = $res12['transactiondate'];
	$res12particulars = $res12['particulars'];
	$res12transactionmode = $res12['transactionmode'];
	$res12transactiontype = $res12['transactiontype'];
	$res12transactionmodule = $res12['transactionmodule'];
	$res12transactionamount = $res12['transactionamount'];
	$res12taxamount = $res12['taxamount'];
	$res12chequenumber = $res12['chequenumber'];
	$res12chequedate = $res12['chequedate'];
	$res12bankname = $res12['bankname'];
	$res12remarks = $res12['remarks'];
	$res12doctorname = $res12['doctorname'];
	$res12wht = $res12['wht_perc'];
	$res12netpayable = $res12['netpayable'];
	
$cashamount21 = '';
$cardamount21 = '';
$onlineamount21 = '';
$chequeamount21 = '';
$tdsamount21 = '';
$writeoffamount21 = '';
$taxamount21 = '';
?>
<style type="text/css">
.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 13px; COLOR: #000000; 
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
	  <td width="172" colspan="2" class="bodytext32"><div align="left" style="font-size:18px;">DOCTOR REMITTANCES</div></td>
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
		$query12 = "select *, sum(transactionamount) as totalamount, sum(taxamount) as totaltax, sum(netpayable) as totalpayable from master_transactiondoctor where docno = '$docno' order by auto_number desc limit 0, 1 ";
		$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
		mysqli_num_rows($exec12);
		$res12 = mysqli_fetch_array($exec12);
		$res12billnumber = $res12['docno'];
		$res12billingdatetime = $res12['transactiondate'];
		$res12particulars = $res12['particulars'];
		$res12transactionmode = $res12['transactionmode'];
		$res12transactiontype = $res12['transactiontype'];
		$res12transactionmodule = $res12['transactionmodule'];
		$res12transactionamount = $res12['totalamount'];
		$res12taxamount = $res12['totaltax'];
        if($res12transactionmode=='MPESA')
		 $res12chequenumber = $res12['mpesanumber'];
		else
		 $res12chequenumber = $res12['chequenumber'];

		$res12chequedate = $res12['chequedate'];
		$res12bankname = $res12['bankname'];
		$res12remarks = $res12['remarks'];
		$res12doctorname = $res12['doctorname'];
		$res12wht = $res12['wht_perc'];
		$res12netpayable = $res12['totalpayable'];
		$bankcharges = $res12['bankcharges'];
	?> 	
	<tr>
		<td colspan="5" style="border-bottom:solid 1px #000000;">&nbsp;</td>
	</tr>
	<tr>
		<td colspan ="2" class="bodytext32">Docno : <?php echo $docno; ?></td>
		<td width="206" colspan="3" align="left" class="bodytext32">Entrydate : <?php echo $res12billingdatetime; ?></td>
	</tr>
	<tr>
		<td colspan ="2" class="bodytext32">Payment Mode : <?php echo $res12transactionmode; ?></td>
		<td colspan="3" align="left" class="bodytext32">Bank : <?php echo $res12bankname; ?></td>
	</tr>
	
	<tr>
		<td colspan ="2" class="bodytext32">Transaction amount : <?php echo number_format($res12transactionamount,2); ?></td>
		<td colspan="3" align="left" class="bodytext32">Tax amount : <?php echo number_format($res12taxamount,2); ?></td>
	</tr>
	<tr>
		<td colspan ="2" class="bodytext32">Net Payable : <?php echo number_format($res12netpayable,2); ?></td>
		<td colspan="3" align="left" class="bodytext32">Cheque/Mpesa Number : <?php echo $res12chequenumber; ?></td>
	</tr>
	<tr>
		<td colspan ="2" class="bodytext32">Payment Date : <?php echo $res12chequedate; ?></td>
		<td colspan="3" align="left" class="bodytext32">Remarks : <?php echo strtoupper($res12remarks); ?></td>
	</tr>
	<tr>
		<td colspan ="2" class="bodytext32">Doctor : <?php echo strtoupper($res12doctorname); ?></td>
		<td colspan="3" align="left" class="bodytext32">Bank Charges : <?php echo number_format($bankcharges,2); ?></td>
	</tr>
	<tr>
		<td colspan="5">&nbsp;</td> 
	</tr>
</table>


<table width="530" border="0" align="center" cellpadding="0" cellspacing="0">
  
 	 <tr>
		<td width="15" align="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF; border-right:none;"><strong>Sno</strong></td>
		<td width="40" align="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-left:none;border-right:none;"><strong>Date</strong></td>
		<td  width="60" align="left" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-left:none;border-right:none;"><strong>Patient Name</strong></td>
		<td  width="60" align="left" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-left:none;border-right:none;"><strong>Payer</strong></td>
		<td width="40" align="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-left:none;border-right:none;"><strong>Bill No</strong></td>
		<td width="50" align="right" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-left:none;border-right:none;"><strong>Payment Amount</strong></td>
		<td width="30" align="right" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-left:none;border-right:none;"><strong>Withholding</strong></td>
		<td width="50" align="right" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-left:none;"><strong>Net Payable</strong></td>
  	</tr>
  	<?php 
  	$sno = '';
  	$totalnetpayabale = $totalwithholding = $totalpaymentamount = 0;
  	$query11 = "select * from master_transactiondoctor where docno = '$docno' order by auto_number";
	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	mysqli_num_rows($exec11);
	while($res11 = mysqli_fetch_array($exec11))
	{
		$res11billnumber = $res11['docno'];
		$res11billingdatetime = $res11['transactiondate'];
		$res11particulars = $res11['particulars'];
		$res11transactionmode = $res11['transactionmode'];
		$res11transactiontype = $res11['transactiontype'];
		$res11transactionmodule = $res11['transactionmodule'];
		$res11transactionamount = $res11['transactionamount'];
		$res11taxamount = $res11['taxamount'];
		$res11chequenumber = $res11['chequenumber'];
		$res11chequedate = $res11['chequedate'];
		$res11bankname = $res11['bankname'];
		$res11remarks = $res11['remarks'];
		$res11doctorname = $res11['doctorname'];
		$res11wht = $res11['wht_perc'];
		$res11netpayable = $res11['netpayable'];
		$res11patientname = $res11['patientname'];
		$res11billnumber = $res11['billnumber'];
		$visitcode = $res11['visitcode'];
        $payer='';
		if( strpos( $visitcode, 'IPV' ) !== false) {
           $sqlpayer="select b.subtype as subtype from master_ipvisitentry as a,master_subtype as b where a.subtype=b.auto_number and a.visitcode='$visitcode'";
		   $execpayer = mysqli_query($GLOBALS["___mysqli_ston"], $sqlpayer) or die ("Error in sqlpayer".mysqli_error($GLOBALS["___mysqli_ston"]));
		   $respayer = mysqli_fetch_array($execpayer);
		   $payer=$respayer['subtype'];
		}else{
           $sqlpayer="select b.subtype as subtype from master_visitentry as a,master_subtype as b where a.subtype=b.auto_number and a.visitcode='$visitcode'";
		   $execpayer = mysqli_query($GLOBALS["___mysqli_ston"], $sqlpayer) or die ("Error in sqlpayer".mysqli_error($GLOBALS["___mysqli_ston"]));
		   $respayer = mysqli_fetch_array($execpayer);
		   $payer=$respayer['subtype'];
		}
		
		/*if( strpos( $res11billnumber, 'CF-' ) !== false) {

			$query112 = "select billingdatetime from master_billing where billnumber = '$res11billnumber' ";
			$exec112 = mysql_query($query112);
			$res112 = mysql_fetch_array($exec112);
			$res11billingdatetime = date("Y-m-d", strtotime($res112['transactiondate']));

		}elseif( strpos( $res11billnumber, 'CB-' ) !== false) {

			$query112 = "select transactiondate from master_transactionpaylater where billnumber = '$res11billnumber' ";
			$exec112 = mysql_query($query112);
			$res112 = mysql_fetch_array($exec112);
			$res11billingdatetime = date("Y-m-d", strtotime($res112['transactiondate']));

		}elseif( strpos( $res11billnumber, 'CB-' ) !== false) {

			$query112 = "select transactiondate from master_transactionpaylater where billnumber = '$res11billnumber' ";
			$exec112 = mysql_query($query112);
			$res112 = mysql_fetch_array($exec112);
			$res11billingdatetime = date("Y-m-d", strtotime($res112['transactiondate']));

		}elseif( strpos( $res11billnumber, 'IPF-' ) !== false) {

			$query112 = "select billdate from billing_ip where  billno = '$res11billnumber'";
			$exec112 = mysql_query($query112);
			$res112 = mysql_fetch_array($exec112);
			$res11billingdatetime = date("Y-m-d", strtotime($res112['billdate']));

		}elseif( strpos( $res11billnumber, 'IPFCA' ) !== false) {

			$query112 = "select billdate from billing_ipcreditapproved where billno = '$res11billnumber'";
			$exec112 = mysql_query($query112);
			$res112 = mysql_fetch_array($exec112);
			$res11billingdatetime = date("Y-m-d", strtotime($res112['billdate']));

		}*/

		$query112 = "select transaction_date from tb where doc_number = '$res11billnumber' ";
		$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112);
		$res112 = mysqli_fetch_array($exec112);
		$res11billingdatetime = $res112['transaction_date'];




		$totalpaymentamount += $res11transactionamount;
		$totalwithholding += $res11taxamount;
		$totalnetpayabale += $res11netpayable;

		$sno = $sno + 1;
	?>
	<tr>
		<td class="bodytext32" valign="middle"  align="center" style="border-left:solid 1px #000000;"><?php echo $sno; ?></td>
		<td class="bodytext32" valign="middle"  align="center" ><?php echo $res11billingdatetime; ?></td>
		<td class="bodytext32" valign="middle"   align="left" ><?php echo $res11patientname; ?></td>
		<td class="bodytext32" valign="middle"   align="left" ><?php echo $payer; ?></td>
		<td class="bodytext32" valign="middle"  align="center" ><?php echo $res11billnumber; ?></td>
		<td class="bodytext32" valign="middle"  align="right" ><?php echo number_format($res11transactionamount,2); ?></td>
		<td class="bodytext32" valign="middle"  align="right" ><?php echo number_format($res11taxamount,2); ?></td>
		<td class="bodytext32" valign="middle"  align="right" style="border-right:solid 1px #000000;"><?php echo number_format($res11netpayable,2); ?></td>
	</tr>
	<?php } ?>
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
		<td colspan="5" align="right" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-right:none;">TOTAL:</td>
		<td align="right" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF; border-left:none;border-right:none;"><?php echo number_format($totalpaymentamount,2); ?></td>
		<td align="right" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF; border-left:none;border-right:none;"><?php echo number_format($totalwithholding,2); ?></td>
		<td align="right" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF; border-left:none;"><?php echo number_format($totalnetpayabale,2); ?></td>
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
	<!-- <tr>
		<td colspan="8" class="bodytext32">Remarks : <?php echo $remarks; ?></td>
	</tr> -->
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