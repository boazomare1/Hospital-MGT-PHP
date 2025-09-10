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

$subtotaldiscounttotal = '';
$showdiscountext = '';

if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }

$query1 = "select * from master_wishes";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$showontop = $res1["showontop"];
if ($showontop == 'yes')
{
	$wishesontop = $res1["wishesontop"];
}
$showonbottom = $res1["showonbottom"];
if ($showonbottom == 'yes')
{
	$wishesonbottom = $res1["wishesonbottom"];
}

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

$query3 = "select * from master_transactionpaynow where billnumber = '$billautonumber'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$res3patientname = $res3['patientname'];
$res3patientcode = $res3['patientcode'];
$res3visitcode = $res3['visitcode'];
$res3billnumber = $res3['billnumber'];
$res3transactionamount = $res3['transactionamount'];
$res3transactiondate = $res3['transactiondate'];
$res3transactionmode = $res3['transactionmode'];
$res3cashgiventocustomer = $res3['cashgiventocustomer'];
$res3cashgivenbycustomer = $res3['cashgivenbycustomer'];
$res3username = $res3['username'];
$res3username = strtoupper($res3username);
$res3transactiondate = $res3['transactiondate'];
$res3transactiontime = $res3['transactiontime'];
$res3transactiontime1 = explode(":",$res3transactiontime);
include ('convert_currency_to_words.php');

$query45 = "select * from master_transactionpaynow where billnumber = '$billautonumber' and transactionmode = 'CHEQUE'";
$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die ("Error in Query45".mysqli_error($GLOBALS["___mysqli_ston"]));
$res45 = mysqli_fetch_array($exec45);
$res45chequenumber = $res45['chequenumber'];
$res45chequedate = $res45['chequedate'];
$res45bankname = $res45['bankname'];

if($res3transactionmode == 'CHEQUE')
{
$res3transactionmode = 'Cheque'.' '.'('.$res45chequenumber.' '.$res45bankname.' '.$res45chequedate.')';
}

$query46 = "select * from master_transactionpaynow where billnumber = '$billautonumber' and transactionmode = 'CREDIT CARD'";
$exec46 = mysqli_query($GLOBALS["___mysqli_ston"], $query46) or die ("Error in Query46".mysqli_error($GLOBALS["___mysqli_ston"]));
$res46 = mysqli_fetch_array($exec46);
$res46creditcardname = $res46['creditcardname'];
$res46creditcardnumber = $res46['creditcardnumber'];
$res46creditcardbankname = $res46['creditcardbankname'];

if($res3transactionmode == 'CREDIT CARD')
{
$res3transactionmode = 'CREDIT CARD'.' '.'('.$res46creditcardname.' '.$res46creditcardnumber.' '.$res46creditcardbankname.')';
}

if ($res3transactionmode  == 'CASH')
{
$res3transactionmode = 'CASH';
}

$query11 = "select * from master_billing where billnumber = '$billautonumber' ";
$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_num_rows($exec11);
$res11 = mysqli_fetch_array($exec11);
$res11patientfirstname = $res11['patientfirstname'];
$res11patientcode = $res11['patientcode'];
$res11visitcode = $res11['visitcode'];
$res11billnumber = $res11['billnumber'];
$res11consultationfees = $res11['consultationfees'];
$res11copaypercentageamount = $res11['copaypercentageamount'];
$res11consultingdoctor = $res11['consultingdoctor'];
$res11totalamount = $res11['totalamount'];
$res11billingdatetime = $res11['billingdatetime'];
$res11patientpaymentmode = $res11['patientpaymentmode'];
$res11username = $res11['username'];
$res11cashgivenbycustomer = $res11['cashgivenbycustomer'];
$res11cashgiventocustomer = $res11['cashgiventocustomer'];
$convertedwords = covert_currency_to_words($res11totalamount); 
?>

	<table width="586" border="0" cellpadding="0" cellspacing="0" align="center">
	    
		<tr>
			<td colspan="6">
			  <div align="center">
			    <?php
			$strlen1 = strlen($wishesontop);
			$totalcharacterlength1 = 35;
			$totalblankspace1 = 35 - $strlen1;
			$splitblankspace1 = $totalblankspace1 / 2;
			for($i=1;$i<=$splitblankspace1;$i++)
			{
			$wishesontop = ' '.$wishesontop.' ';
			}
			?>
		    <?php echo $wishesontop; ?> </div></td>
		</tr>
		<tr>
			<td colspan="6">
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
			<td colspan="6"><div align="center"><?php echo $companyname; ?>
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
			<td colspan="6"><div align="center"><?php echo $address1; ?>
		      <?php
			$address2 = $area.', '.$city.' - '.$pincode.'';
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
			<td colspan="6">
			
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
		   <td width="62">&nbsp;</td>
	  </tr> 
		<tr>
			<td colspan="6"></td>
		</tr>
			<?php
			if ($tinnumber1 != '')
			{
			?>
		<tr>
			<td colspan="6"></td>
		</tr>
		<?php
		}
		?>
		<?php
		if ($cstnumber1 != '')
		{
		?>
		<tr>
			<td colspan="6">&nbsp;</td>
		</tr>
		<?php
		}
		?>
		
		<tr>
			<td colspan ="2" >Name :			</td>
			<td width="282" ><?php echo $res11patientfirstname; ?></td>
			<td colspan ="2" >Bill No: </td>
		    <td width="134" ><?php echo $res11billnumber; ?></td>
		</tr>
		<tr>
			<td colspan ="2" >Reg No :			</td>
			<td ><?php echo $res11patientcode; ?></td>
			<td colspan ="2" >Bill Date: </td>
		    <td width="134" ><?php echo $res11billingdatetime; ?></td>
		</tr>
		
		<tr>
			<td colspan ="2" a>Visit No: </td>
			<td ><?php echo $res11visitcode; ?></td>
			<td width="37">&nbsp;</td>
		</tr>
		<tr>
			<td height="20" colspan="5">&nbsp;
			<?php //echo 'DATE: '.substr($billdate, 0, 10).' '.$billtime; ?></td>
		</tr>
</table>

	<table width="586" border="0" cellpadding="0" cellspacing="0" align="center">
	<?php
	$sno = '';		
	$query5 = "select * from consultation_lab where patientvisitcode = '$res3visitcode' and patientcode = '$res3patientcode' and paymentstatus = 'completed'";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res5 = mysqli_fetch_array($exec5))
	{
	$res5labitemname = $res5['labitemname'];
	$res5labitemrate = $res5['labitemrate'];
	
	$printitem = substr($res5labitemname, 0, 8);
	
	$printrate = $res5labitemrate;
	
	$strlenprintrate = strlen($printrate);
	if ($strlenprintrate == 7) { $printrate = $printrate; }
	if ($strlenprintrate == 6) { $printrate = ' '.$printrate; }
	if ($strlenprintrate == 5) { $printrate = '  '.$printrate; }
	if ($strlenprintrate == 4) { $printrate = '   '.$printrate; }
	
	?>
	<?php
	}
	?>
	<?php		
	$query6 = "select * from consultation_radiology where patientvisitcode = '$res3visitcode' and patientcode = '$res3patientcode' and paymentstatus = 'completed'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res6 = mysqli_fetch_array($exec6))
	{
	$res6radiologyitemname = $res6['radiologyitemname'];
	$res6radiologyitemrate = $res6['radiologyitemrate'];
	
	$printitem1 = substr($res6radiologyitemname, 0, 8);
	
	$printrate1 = $res6radiologyitemrate;
	
	$strlenprintrate = strlen($printrate1);
	if ($strlenprintrate == 7) { $printrate = $printrate; }
	if ($strlenprintrate == 6) { $printrate = ' '.$printrate; }
	if ($strlenprintrate == 5) { $printrate = '  '.$printrate; }
	if ($strlenprintrate == 4) { $printrate = '   '.$printrate; }
	
	?>
	<?php
	}
	?>
	<?php		
	$query7 = "select * from consultation_services where patientvisitcode = '$res3visitcode' and patientcode = '$res3patientcode' and paymentstatus = 'completed'";
	$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res7 = mysqli_fetch_array($exec7))
	{
	$res7servicesitemname = $res7['servicesitemname'];
	$res7servicesitemrate = $res7['servicesitemrate'];
	
	$printitem2 = substr($res7servicesitemname, 0, 8);
	
	$printrate2 = $res7servicesitemrate;
	
	$strlenprintrate = strlen($printrate2);
	if ($strlenprintrate == 7) { $printrate = $printrate; }
	if ($strlenprintrate == 6) { $printrate = ' '.$printrate; }
	if ($strlenprintrate == 5) { $printrate = '  '.$printrate; }
	if ($strlenprintrate == 4) { $printrate = '   '.$printrate; }
	
	?>
	<?php
	}
	?>
	<?php		
	$query8 = "select * from master_consultationpharmissue where patientvisitcode = '$res3visitcode' and patientcode = '$res3patientcode' and recordstatus = 'completed'";
	$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res8 = mysqli_fetch_array($exec8))
	{
	$res8medicinename = $res8['medicinename'];
	$res8amount = $res8['amount'];
	$res8prescribed_quantity = $res8['prescribed_quantity'];
	$res8rate = $res8['rate'];
	
	$printitem3 = substr($res8medicinename, 0, 8);
	
	$printrate3 = $res8rate;
	
	$strlenprintrate = strlen($printrate3);
	if ($strlenprintrate == 7) { $printrate = $printrate; }
	if ($strlenprintrate == 6) { $printrate = ' '.$printrate; }
	if ($strlenprintrate == 5) { $printrate = '  '.$printrate; }
	if ($strlenprintrate == 4) { $printrate = '   '.$printrate; }
	
	$printrate4 = $res8amount;
	
	$strlenprintrate = strlen($printrate4);
	if ($strlenprintrate == 7) { $printrate = $printrate; }
	if ($strlenprintrate == 6) { $printrate = ' '.$printrate; }
	if ($strlenprintrate == 5) { $printrate = '  '.$printrate; }
	if ($strlenprintrate == 4) { $printrate = '   '.$printrate; }
	
	
	?>
	<?php
	
	}
	?>
	</table>
	   <table width="553" border="0" align="center" cellpadding="0" cellspacing="0"> 
		<tr>
			<td colspan="5" align="center">
			----------------------------------------------------------------------------------------</td>
		</tr>
		
		<tr>
			<td width="77">&nbsp;</td>
		</tr>	
			
	     <tr>
			<td colspan ="2">Description :   </td>
			<td width="205"><?php echo $res11consultingdoctor; ?></td>
			<td colspan ="2">Copay :    </td>
		    <td width="92"><?php echo $res11copaypercentageamount; ?></td>
		</tr>
		<tr>
			<td colspan ="2">NetAmount :     </td>
			<td width="205"><?php echo $res11totalamount; ?></td>
			<td colspan ="2" >Bill Date : &nbsp;    </td>
		    <td width="92"><?php echo $res11billingdatetime; ?></td>
		</tr>
		
		<tr>
			<td>&nbsp;</td>
		</tr>
		
	<tr>
		<td colspan="5">
		  <div align="center">-------------------------------------------------------</div></td>
	</tr>
	
	<tr>
		<td>&nbsp;</td>
	</tr>
		
	<tr>
		<td colspan="4">&nbsp;</td>
		<td width="124">Total: <?php echo number_format($res11totalamount,2,'.',','); ?></td>
	</tr>
	
	<tr>
		<td colspan="4">&nbsp;</td>
		<td>Cash Given: <?php echo number_format($res11cashgivenbycustomer,2,'.',','); ?></td>
	</tr>
	
	<tr>
		<td colspan="4">&nbsp;</td>
		<td>Cash Returned: <?php echo number_format($res11cashgiventocustomer,2,'.',','); ?> </td>
	</tr>
	
	<tr>
		<td>&nbsp;</td>
	</tr>
		
	<tr>
		<td colspan="5">Payment Mode: <?php echo $res11patientpaymentmode; ?></td>
	</tr>
	
	<tr>
		<td colspan="5">&nbsp;</td>
	</tr>
	
	<tr>
		<td colspan="5">
		<?php echo $convertedwords; ?>	</td>
	</tr>
	
	<tr>
		<td colspan="5">&nbsp;</td>
	</tr>
	
	<tr>
		<td colspan="4">&nbsp;</td>
		<td>Served By: <?php echo strtoupper($res11username); ?> </td>
	</tr>
	
	<tr>
		<td colspan="4">&nbsp;</td>
		<td><?php echo $res11billingdatetime; ?> </td>
	</tr>
	
	<tr>
	   <td>&nbsp;</td>
	 </tr>  
	<tr>
		<td colspan="5" align="center">
		<?php echo $wishesonbottom; ?></td>
	</tr>
	<tr>
		<td colspan="5">
		<?php echo ''; ?></td>
	</tr>
	<tr>
		<td colspan="5">
		<?php 
		$query7 = "select * from master_edition where status = 'ACTIVE'";
		$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res7 = mysqli_fetch_array($exec7);
		$res7edition = $res7["edition"];
		if ($res7edition == 'FREE' or $res7edition == 'SPONSORED')
		{
		?>
		<?php echo "Software By: WWW.SIMPLEINDIA.COM"; ?>
		<?php
		}
		?></td>
	</tr>
</table>

	<?php	

    $content = ob_get_clean();

    // convert in PDF
 
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
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
				