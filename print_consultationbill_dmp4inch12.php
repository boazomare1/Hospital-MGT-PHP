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

if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }

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

	include('convert_currency_to_words.php');
	
	$query11 = "select * from master_billing where billnumber = '$billautonumber' ";
	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	mysqli_num_rows($exec11);
	$res11 = mysqli_fetch_array($exec11);
	$res11patientfirstname = $res11['patientfirstname'];
	$res11patientcode = $res11['patientcode'];
	$res11visitcode = $res11['visitcode'];
	$res11billnumber = $res11['billnumber'];
	$res11consultationfees = $res11['consultationfees'];
	$res11subtotalamount = $res11['subtotalamount'];
	$convertedwords = covert_currency_to_words($res11subtotalamount);
	$res11billingdatetime = $res11['billingdatetime'];
	$res11patientpaymentmode = $res11['patientpaymentmode'];
	$res11username = $res11['username'];
	$res11cashamount = $res11['cashamount'];
	$res11chequeamount = $res11['chequeamount'];
	$res11cardamount = $res11['cardamount'];
	$res11onlineamount= $res11['onlineamount'];
	$res11creditamount= $res11['creditamount'];
	$res11cashgivenbycustomer = $res11['cashgivenbycustomer'];
	$res11cashgiventocustomer = $res11['cashgiventocustomer'];
?>

<table width="386" border="0" cellpadding="0" cellspacing="0" align="center">
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
			$address2 = $area.''.$city.' - '.$pincode.'';
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
	  <td width="226" >Bill No: <?php echo $res11billnumber; ?></td>
		<td width="129" >Bill Date: <?php echo date("d/m/Y", strtotime($res11billingdatetime)); ?></td>
	</tr>
	<tr>
		<td colspan ="2" ><?php echo $res11patientfirstname; ?> (<?php echo $res11patientcode; ?>, <?php echo $res11visitcode; ?>)</td>
	</tr>
</table>

<table width="382" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="7">&nbsp;</td>
    <td colspan="7">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="8">Consultation Charges:</td>
    <td width="78" ><strong><?php echo $res11subtotalamount; ?></strong></td>
  </tr>
 <?php if($res11patientpaymentmode == 'CASH' || $res11patientpaymentmode == 'SPLIT') { ?>
  <tr>
    <td colspan="8">Cash Received:</td>
   <td><?php echo number_format($res11cashgivenbycustomer,2,'.',','); ?></td>
  </tr>
  <?php } ?>
  
    <?php if($res11cashamount != '0.00') { ?>
  <tr>
    <td width="211" >Cash Returned:</td>
    
    <td colspan="4"><?php echo number_format($res11cashgiventocustomer,2,'.',','); ?></td>
  </tr>
   <?php } ?>
  
  <?php if($res11onlineamount != 0.00) { ?>
  <tr>
    <td colspan="8">Online Amount:</td>
    <td><?php echo number_format($res11onlineamount,2,'.',','); ?></td>
  </tr>
  <?php } ?>
  
  <?php if($res11chequeamount != 0.00) { ?>
  <tr>
    <td colspan="7">Cheque</td>
    <td width="22">&nbsp;</td>
    <td><?php echo number_format($res11chequeamount,2,'.',','); ?></td>
  </tr>
  <?php } ?>
  
  <?php if($res11cardamount != 0.00) { ?>
  <tr>
    <td colspan="7">Card Amount</td>
    <td>&nbsp;</td>
    <td><?php echo number_format($res11cardamount,2,'.',','); ?></td>
  </tr>
  <?php } ?>
  
   <?php if($res11cardamount != 0.00) { ?>
  <tr>
    <td colspan="7">Card Amount</td>
    <td>&nbsp;</td>
    <td><?php echo number_format($res11cardamount,2,'.',','); ?></td>
  </tr>
  <?php } ?>
  
   <?php if($res11creditamount != 0.00) { ?>
  <tr>
    <td colspan="7">MPESA Amount</td>
    <td>&nbsp;</td>
    <td><?php echo number_format($res11creditamount,2,'.',','); ?></td>
  </tr>
  <?php } ?>

  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="9"><?php echo $convertedwords; ?></td>
  </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td height="47" colspan="9">Served By: <?php echo strtoupper($res11username); ?> </td>
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

$html2pdf->Output('print_consultationbill.pdf');
}
catch(HTML2PDF_exception $e) {
echo $e;
exit;
}
?>
