<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];


$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }

	include('convert_currency_to_words.php');
	
	$query11 = "select * from refund_paynow where locationcode='$locationcode' and billnumber = '$billautonumber' ";
	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	mysqli_num_rows($exec11);
	$res11 = mysqli_fetch_array($exec11);
	$res11patientfirstname = $res11['patientname'];
	$res11patientcode = $res11['patientcode'];
	$res11visitcode = $res11['visitcode'];
	$res11billnumber = $res11['billnumber'];
	$res11transactionamount = $res11['transactionamount'];
	$convertedwords = covert_currency_to_words($res11transactionamount);
	$res11transactiondate= $res11['transactiondate'];
    $res11transactiontime= $res11['transactiontime'];
	$res11username = $res11['username'];
	$res11cashamount = $res11['cashamount'];
	$res11chequeamount = $res11['chequeamount'];
	$res11cardamount = $res11['cardamount'];
	$res11onlineamount= $res11['onlineamount'];
	$res11creditamount= $res11['creditamount'];
	$res11cashgivenbycustomer = $res11['cashgivenbycustomer'];
	$res11cashgiventocustomer = $res11['cashgiventocustomer'];
	
	$queryuser="select employeename from master_employee where username='$res11username'";
		$execuser = mysqli_query($GLOBALS["___mysqli_ston"], $queryuser) or die ("Error in queryuser".mysqli_error($GLOBALS["___mysqli_ston"]));
		$resuser = mysqli_fetch_array($execuser);
		$username=$resuser['employeename'];
?>
<style type="text/css">
.bodytext3 {	FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000; 
}
.bodytext31 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000; 
}
.bodytext311 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000;  text-decoration:none
}
.bodytext365 {FONT-WEIGHT: bold; FONT-SIZE: 14px; COLOR: #000000;  text-decoration:none
}
.bodytext366 {FONT-WEIGHT: bold; FONT-SIZE: 13px; COLOR: #000000;  text-decoration:none
}
.bodytext311 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000; 
}
.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000; 
}
.bodytext36 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000; 
}
.bodytext37 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000; 
}
.bodytext38 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000; 
}
.bodytext40 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000; 
}
.bodytext41 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000; 
}
.style2 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000; 
}
.bodytext33{FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000; }
.bodytext312 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000; 
}

.bodytext332{FONT-WEIGHT: bold; FONT-SIZE: 25px; COLOR: #000000; }
.bodytext30 { FONT-SIZE: 18px; FONT-WEIGHT: bold; COLOR: #000000; }
.bodytext{ text-decoration: underline; line-height:14px}
</style>
<?php include('print_header80x80.php'); ?>
<table width="" border="0" align="center" cellpadding="0" cellspacing="0">
  
  <tr>
    <td colspan="3" class="bodytext32">&nbsp;</td>
  </tr>
  <tr>
    <td class="bodytext36"><strong>Bill No: <?php echo $res11billnumber; ?></strong></td>
    <td width=""  align="right" class="bodytext36">&nbsp;</td>
    <td width=""  align="left" class="bodytext36"><strong>Bill Date: <?php echo date("d/m/Y", strtotime($res11transactiontime)); ?></strong></td>
  </tr>
  <tr>
    <td class="bodytext32">&nbsp;</td>
    <td colspan="2"  align="right" class="bodytext32">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="bodytext37"><strong><?php echo $res11patientfirstname; ?> (<?php echo $res11patientcode; ?>, <?php echo $res11visitcode; ?>)</strong></td>
  </tr>
  <tr>
    <td class="bodytext32">&nbsp;</td>
    <td colspan="2"  align="right" class="bodytext32">&nbsp;</td>
  </tr>
  <tr>
    <td width="" class="bodytext38"><strong>Refund Consultation:</strong></td>
    <td colspan="2"  align="right" class="bodytext38"><strong><?php echo $res11transactionamount; ?></strong></td>
  </tr>

  <tr>
    <td >&nbsp;</td>
    <td colspan="2" align="right">&nbsp;</td>
  </tr>
     <?php if($res11cashgivenbycustomer != 0.00) { ?> 	
	<tr>
		<td class="bodytext32"><strong>Cash Received:</strong></td>
		
		<td align="right">&nbsp;</td>
		<td align="right" class="bodytext32"><strong><?php echo number_format($res11cashgivenbycustomer,2,'.',','); ?></strong></td>
	</tr>
	<tr>
		<td width="" class="bodytext32"><strong>CashReturned:</strong></td>
		<td align="right">&nbsp;</td>
		
		<td align="right" class="bodytext32"><strong><?php echo number_format($res11cashgiventocustomer,2,'.',','); ?></strong></td>
	</tr>
	<?php } ?>
	<?php if($res11chequeamount != 0.00) { ?> 
	<tr>
		<td width="" class="bodytext32"><strong>Cheque Amount</strong></td>
		<td align="right">&nbsp;</td>
		
		<td align="right" class="bodytext32"><strong><?php echo number_format($res11chequeamount,2,'.',','); ?></strong></td>
	</tr>
	<?php } ?>
	<?php if($res11onlineamount != 0.00) { ?> 
	<tr>
		<td width="" class="bodytext32"><strong>Online Amount</strong></td>
		<td align="right">&nbsp;</td>
		
		<td align="right" class="bodytext32"><strong><?php echo number_format($res11onlineamount,2,'.',','); ?></strong></td>
	</tr>
	<?php } ?>
	<?php if($res11cardamount != 0.00) { ?> 
	<tr>
		<td width="" class="bodytext32"><strong>Credit Amount</strong></td>
		<td align="right">&nbsp;</td>
		
		<td align="right" class="bodytext32"><strong><?php echo number_format($res11cardamount,2,'.',','); ?></strong></td>
	</tr>
	<?php } ?>
	
    <?php if($res11creditamount != 0.00) { ?> 
	<tr>
		<td width="" class="bodytext32"><strong>MPESA</strong></td>
		<td align="right">&nbsp;</td>
		
		<td align="right" class="bodytext32"><strong><?php echo number_format($res11creditamount,2,'.',','); ?></strong></td>
	</tr>
	<?php } ?>	


  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="bodytext40"><strong><?php echo $convertedwords; ?></strong></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td  colspan="3" align="right" class="bodytext41"><strong>Served By: <?php echo strtoupper($username); ?></strong></td>
  </tr>
  <tr>
    <td  colspan="3" align="right" class="bodytext41"><strong><?php echo strtoupper($res11transactiontime); ?></strong> </td>
  </tr>
</table>
<?php	
$content = ob_get_clean();

// convert in PDF

try
{
$width_in_inches = 4.39;
		$height_in_inches = 6.2;
		$width_in_mm = $width_in_inches * 25.4; 
		$height_in_mm = $height_in_inches * 25.4;
        $html2pdf = new HTML2PDF('P', array($width_in_mm,$height_in_mm), 'en', true, 'UTF-8', array(0, 0, 0,0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
		//$html2pdf->setDefaultFont('Helvetica');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
$html2pdf->Output('print_consultationrefund.pdf');
}
catch(HTML2PDF_exception $e) {
echo $e;
exit;
}
?>
