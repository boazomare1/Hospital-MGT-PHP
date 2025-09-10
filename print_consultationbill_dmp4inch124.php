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
	
	$query11 = "select * from refund_paynow where billnumber = '$billautonumber' ";
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
	$res11cashgivenbycustomer = $res11['cashgivenbycustomer'];
	$res11cashgiventocustomer = $res11['cashgiventocustomer'];
?>

<table width="550" border="0" cellpadding="0" cellspacing="0" align="center">
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
	  <td width="295" >Bill No: <?php echo $res11billnumber; ?></td>
		<td width="114" >Bill Date: <?php echo date("d/m/Y", strtotime($res11transactiontime)); ?></td>
	</tr>
	<tr>
		<td colspan ="2" ><?php echo $res11patientfirstname; ?> (<?php echo $res11patientcode; ?>, <?php echo $res11visitcode; ?>)</td>
	</tr>
</table>

<table width="549" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="7">&nbsp;</td>
  </tr>
  <tr>
    <td>Refund Consultation:</td>
    <td width="263" align="right"><strong><?php echo $res11transactionamount; ?></strong></td>
  </tr>

  <tr>
    <td >&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td width="214" >Cash Returned:</td>
    
    <td width="263" align="right"><?php echo number_format($res11cashamount,2,'.',','); ?></td>
  </tr>

  

  <!--<tr>
    <td>Cheque Amount:</td>
    <td width="125" align="right"><?php echo number_format($res11chequeamount,2,'.',','); ?></td>
  </tr>
  
  <tr>
    <td>MPESA Amount:</td>
    <td width="125" align="right"><?php echo number_format($res11creditamount,2,'.',','); ?></td>
  </tr>
  <tr>
    <td>Card Amount:</td>
    <td width="125" align="right"><?php echo number_format($res11cardamount,2,'.',','); ?></td>
  </tr>
  <tr>
    <td>Online Amount:</td>
    <td width="125" align="right"><?php echo number_format($res11onlineamount,2,'.',','); ?></td>
  </tr>-->



  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><?php echo $convertedwords; ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td  colspan="2" align="right">Served By: <?php echo strtoupper($res11username); ?> </td>
  </tr>
  <tr>
    <td  colspan="2" align="right"><?php echo strtoupper($res11transactiontime); ?> </td>
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
