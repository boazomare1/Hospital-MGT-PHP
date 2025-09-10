<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
date_default_timezone_set('Asia/Calcutta'); 
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];

$totalamount = 0;

if (isset($_REQUEST["billnumber"])) { $billnumber = $_REQUEST["billnumber"]; } else { $billnumber = ""; }
	
	include('convert_currency_to_words.php');

$query3 = "select * from master_transactionexternal where billnumber = '$billnumber' ";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_num_rows($exec3);	
$res3 = mysqli_fetch_array($exec3);
$res11chequeamount = $res3['chequeamount'];
	$res11cardamount = $res3['cardamount'];
	$res11onlineamount= $res3['onlineamount'];
	$res11creditamount= $res3['creditamount'];
	
	$res11cashgivenbycustomer = $res3['cashgivenbycustomer'];
	$res11cashgiventocustomer = $res3['cashgiventocustomer'];
$res3transactionamount = $res3['transactionamount'];

$convertedwords = covert_currency_to_words($res3transactionamount);
$res3username = $res3['username'];
$res3transactiontime= $res3['transactiontime'];
?>

<table width="499" border="0" cellpadding="0" cellspacing="0" align="center">
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
			<td colspan="4">
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
			<td colspan="4"><div align="center"><?php echo $companyname; ?>
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
			<td colspan="4"><div align="center"><?php echo $address1; ?>
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
			<td colspan="4">
			
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
<td colspan="3">&nbsp;</td>
</tr>
	<tr>
	<?php
	$query1 = "select * from billing_externalpharmacy where billnumber = '$billnumber' ";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	mysqli_num_rows($exec1);
	$res1 = mysqli_fetch_array($exec1);
	$res1patientfirstname = $res1['patientname'];
	$res1medicinename = $res1['medicinename'];
    $res1billdate = $res1['billdate'];
	?>
	  <td width="347" >Bill No: <?php echo $billnumber; ?></td>
		<td width="120" >Bill Date: <?php echo date("d/m/Y", strtotime($res1billdate)); ?></td>
	</tr>
	<tr>
		<td colspan ="2" ><?php echo $res1patientfirstname; ?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>

<table width="289" border="0" align="center" cellpadding="0" cellspacing="0">
  <!--<tr>
    <td>Consultation Charges:</td>
    <td width="125" align="right"><strong><?php //echo $res11subtotalamount; ?></strong></td>
  </tr>-->
  <tr>
	  <td width="123" >Description</td>
	  <td width="48" ><div align="center">Qty</div></td>
	  <td width="76" ><div align="right">Rate</div></td>
    <td width="72" ><div align="right">Amount</div></td>
  </tr>
  <?php
	$query2 = "select * from billing_externalpharmacy where billnumber = '$billnumber' ";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	mysqli_num_rows($exec2);
	while($res2 = mysqli_fetch_array($exec2)) 
	 {
	$res2quantity = $res2['quantity'];
	$res2medicinename = $res2['medicinename'];
    $res2rate = $res2['rate'];
	$res2amount= $res2['amount'];
	$totalamount = $totalamount + $res2amount;
	?>
              
			  <tr>
	            <td width="123"><?php echo $res2medicinename; ?></td>
	            <td width="48" align="center"><?php echo $res2quantity; ?></td>
	            <td width="76" align="right"><?php echo number_format($res2rate,2,'.',','); ?></td>
	            <td width="72" align="right"><?php echo number_format($res2amount,2,'.',','); ?></td>
             </tr>
    <?php } ?>
	          <tr>
	            <td></td>
	            <td align="right">&nbsp;</td>
	            <td align="right">&nbsp;</td>
	            <td align="right">&nbsp;</td>
             </tr>
    <tr>
		<td><div align="right"> </div></td>
		<td align="right">&nbsp;</td>
		<td align="right">Total:</td>
		<td align="right"><?php echo number_format($totalamount,2,'.',','); ?></td>
	</tr> 
	<tr>
		<td>&nbsp;</td>
	</tr>
	
  <?php if($res11cashgivenbycustomer != 0.00) { ?> 	
	<tr>
		<td class="bodytext32"><strong>Cash Received:</strong></td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right" class="bodytext32"><strong><?php echo number_format($res11cashgivenbycustomer,2,'.',','); ?></strong></td>
	</tr>
	<tr>
		<td width="203" class="bodytext32"><strong>CashReturned:</strong></td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right" class="bodytext32"><strong><?php echo number_format($res11cashgiventocustomer,2,'.',','); ?></strong></td>
	</tr>
	<?php } ?>
	<?php if($res11chequeamount != 0.00) { ?> 
	<tr>
		<td width="203" class="bodytext32"><strong>Cheque Amount</strong></td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right" class="bodytext32"><strong><?php echo number_format($res11chequeamount,2,'.',','); ?></strong></td>
	</tr>
	<?php } ?>
	<?php if($res11onlineamount != 0.00) { ?> 
	<tr>
		<td width="203" class="bodytext32"><strong>Online Amount</strong></td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right" class="bodytext32"><strong><?php echo number_format($res11onlineamount,2,'.',','); ?></strong></td>
	</tr>
	<?php } ?>
	<?php if($res11cardamount != 0.00) { ?> 
	<tr>
		<td width="203" class="bodytext32"><strong>Credit Amount</strong></td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right" class="bodytext32"><strong><?php echo number_format($res11cardamount,2,'.',','); ?></strong></td>
	</tr>
	<?php } ?>
	
    <?php if($res11creditamount != 0.00) { ?> 
	<tr>
		<td width="203" class="bodytext32"><strong>MPESA</strong></td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right" class="bodytext32"><strong><?php echo number_format($res11creditamount,2,'.',','); ?></strong></td>
	</tr>
	<?php } ?>				   
	<tr>
	  <td colspan="4">&nbsp;</td>
  </tr>
	<tr>
		<td colspan="4"><?php echo $convertedwords; ?></td>
	</tr>
	<tr>
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4" align="right">Served By: <?php echo strtoupper($res3username); ?> </td>
	</tr>
	<tr>
		<td colspan="4" align="right"><?php echo strtoupper($res3transactiontime); ?> </td>
	</tr>
</table> 
	


<?php	
$content = ob_get_clean();

// convert in PDF

try
{
$html2pdf = new HTML2PDF('P', 'A5', 'en');
//      $html2pdf->setModeDebug();
$html2pdf->setDefaultFont('Arial');
$html2pdf->writeHTML($content, isset($_GET['vuehtml']));

$html2pdf->Output('print_billpaynowbill.pdf');
}
catch(HTML2PDF_exception $e) {
echo $e;
exit;
}
?>
