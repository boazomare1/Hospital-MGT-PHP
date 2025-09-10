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

	$query11 = "select * from master_transactionpaynow where billnumber = '$billautonumber' ";
	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	mysqli_num_rows($exec11);
	$res11 = mysqli_fetch_array($exec11);
	$res11patientfirstname = $res11['patientname'];
	$res11patientcode = $res11['patientcode'];
	$res11visitcode = $res11['visitcode'];
	$res11billnumber = $res11['billnumber'];
	//$res11consultationfees = $res11['consultationfees'];
	//$res11subtotalamount = $res11['subtotalamount'];
	$res11billingdatetime = $res11['transactiondate'];
	$res11patientpaymentmode = $res11['transactionmode'];
	$res11username = $res11['username'];
	$res11cashamount = $res11['cashamount'];
	$res11transactionamount = $res11['transactionamount'];
    $res11chequeamount = $res11['chequeamount'];
	$res11cardamount = $res11['cardamount'];
	$res11onlineamount= $res11['onlineamount'];
	$res11creditamount= $res11['creditamount'];
	$res11updatetime= $res11['transactiontime'];
	$res11cashgivenbycustomer = $res11['cashgivenbycustomer'];
	$res11cashgiventocustomer = $res11['cashgiventocustomer'];
?>

<table width="359" border="0" cellpadding="0" cellspacing="0" align="center">
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
	  <td width="221" >Bill No: <?php echo $res11billnumber; ?></td>
		<td width="138" >Bill Date: <?php echo date("d/m/Y", strtotime($res11billingdatetime)); ?></td>
	</tr>
	<tr>
		<td colspan ="2" ><?php echo $res11patientfirstname; ?> (<?php echo $res11patientcode; ?>, <?php echo $res11visitcode; ?>)</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	
	
</table>
    	<?php
	include('convert_currency_to_words.php');
	$convertedwords = covert_currency_to_words($res11transactionamount); ?>
<script>
window.onload = function() {
    if(!window.location.hash) {
        window.location = window.location + '#externalbill';
        window.location.reload();
    }
}
</script>
<table width="360" border="0" align="center" cellpadding="0" cellspacing="0">
  

  <!--<tr>
    <td>Consultation Charges:</td>
    <td width="125" align="right"><strong><?php //echo $res11subtotalamount; ?></strong></td>
  </tr>-->
  <tr>
	  <td width="203" >Description</td>
	  <td width="34" ><div align="center">Qty</div></td>
	  <td width="54" ><div align="right">Rate</div></td>
    <td width="69" ><div align="right">Amount</div></td>
  </tr>
  
  <?php
			$colorloopcount = '';
			$sno = '';
			
			$query1 = "select * from consultation_lab where patientvisitcode = '$res11visitcode' and patientcode = '$res11patientcode' and paymentstatus = 'completed'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
		    $res1labitemname = $res1['labitemname'];
			$res1labitemrate = $res1['labitemrate'];
			
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
             
			   <td class="bodytext31" valign="center"  align="left">
			   <?php echo $res1labitemname; ?></td>
				<td class="bodytext31" valign="center"  align="center">
			   <?php echo 1; ?></td>
				<td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($res1labitemrate,2,'.',','); ?></td>
				<td width="69"  align="right" valign="center" class="bodytext31">
			   <?php echo number_format($res1labitemrate,2,'.',','); ?></td>
              </tr>
			  <?php
			}
			?>
			
			<?php
			$colorloopcount = '';
			
			
			$query2 = "select * from consultation_radiology where patientvisitcode = '$res11visitcode' and patientcode = '$res11patientcode' and paymentstatus = 'completed'";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res2 = mysqli_fetch_array($exec2))
			{
		    $res2radiologyitemname = $res2['radiologyitemname'];
			$res2radiologyitemrate = $res2['radiologyitemrate'];
			
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
			   <td class="bodytext31" valign="center"  align="left">
			 <?php echo $res2radiologyitemname; ?></td>
				<td class="bodytext31" valign="center"  align="center">
			<?php echo 1; ?></td>
				<td class="bodytext31" valign="center"  align="right">
			   <?php echo number_format($res2radiologyitemrate,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right">
			   <?php echo number_format($res2radiologyitemrate,2,'.',','); ?></td>
              </tr>
			  <?php
			}
			?>
			
			<?php
			$colorloopcount = '';
			
			
			$query3 = "select * from consultation_services where patientvisitcode = '$res11visitcode' and patientcode = '$res11patientcode' and paymentstatus = 'completed'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res3 = mysqli_fetch_array($exec3))
			{
		    $res3servicesitemname = $res3['servicesitemname'];
			$res3servicesitemrate = $res3['servicesitemrate'];
			
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
			   <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res3servicesitemname; ?></td>
				<td class="bodytext31" valign="center"  align="center">
			  <?php echo 1; ?></td>
				<td class="bodytext31" valign="center"  align="right">
			 <?php echo number_format($res3servicesitemrate,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right">
			 <?php echo number_format($res3servicesitemrate,2,'.',','); ?></td>
              </tr>
			  <?php
			}
			?>
			
			<?php
			$colorloopcount = '';
			
			
			$query4 = "select * from master_consultationpharmissue where patientvisitcode = '$res11visitcode' and patientcode = '$res11patientcode' and recordstatus = 'completed'";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res4 = mysqli_fetch_array($exec4))
			{
		    $res4medicinename = $res4['medicinename'];
			$res4amount = $res4['amount'];
			$res4prescribed_quantity = $res4['prescribed_quantity'];
			$res4rate = $res4['rate'];
			
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
			    <td class="bodytext31" valign="center"  align="left"><?php echo $res4medicinename; ?></td>
			    <td class="bodytext31" valign="center"  align="center"><?php echo $res4prescribed_quantity; ?></td>
			    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($res4rate,2,'.',','); ?></td>
			    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($res4amount,2,'.',','); ?></td>
              
			  <?php
			}

			?>
			<tr>
				<td colspan="3"><div align="right">Total: </div></td>
				<td colspan="4" align="right"><?php echo number_format($res11transactionamount,2,'.',','); ?></td>
			</tr> 
<tr>
<td colspan="4">&nbsp;</td>
</tr>

   
  <tr>
    <td>Cash Received:</td>
    <td colspan="4" align="right"><?php echo number_format($res11cashgivenbycustomer,2,'.',','); ?></td>
  </tr>
  <tr>
    <td width="203" >CashReturned:</td>
    
    <td colspan="4" align="right"><?php echo number_format($res11cashgiventocustomer,2,'.',','); ?></td>
  </tr>

  

  <tr>
    <td>Cheque Amount:</td>
    <td colspan="4" align="right"><?php echo number_format($res11chequeamount,2,'.',','); ?></td>
  </tr>
  
  <tr>
    <td>MPESA Amount:</td>
    <td colspan="4" align="right"><?php echo number_format($res11creditamount,2,'.',','); ?></td>
  </tr>
  <tr>
    <td>Card Amount:</td>
    <td colspan="4" align="right"><?php echo number_format($res11cardamount,2,'.',','); ?></td>
  </tr>
  <tr>
    <td>Online Amount:</td>
    <td colspan="4" align="right"><?php echo number_format($res11onlineamount,2,'.',','); ?></td>
  </tr>



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
    <td  colspan="4" align="right">Served By: <?php echo strtoupper($res11username); ?> </td>
  </tr>
  <tr>
    <td  colspan="4" align="right"><?php echo strtoupper($res11updatetime); ?> </td>
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
