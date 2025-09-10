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
$username = $_SESSION['username'];

if (isset($_REQUEST["grt"])) { $grt = $_REQUEST["grt"]; } else { $grt = ""; }

	

	include('convert_currency_to_words.php');
	
	$query1 = "select * from purchasereturn_details where billnumber = '$grt' ";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	mysqli_num_rows($exec1);
	$res1 = mysqli_fetch_array($exec1);
 	$res1entrydate= $res1['entrydate'];
	$res1suppliername= $res1['suppliername'];
	$res1suppliercode= $res1['suppliercode'];
//	$res1supplierbillnumber= $res1['supplierbillnumber'];
	$res1itemcode= $res1['itemcode'];
	$res1locationcode= $res1['locationcode'];
	$res1store= $res1['store'];
	$res1grn = $res1['grnbillnumber'];
//supplier details
	$querysup = "SELECT * FROM master_accountname WHERE id='$res1suppliercode'";
	$execsup = mysqli_query($GLOBALS["___mysqli_ston"], $querysup) or die ("Error in querysup".mysqli_error($GLOBALS["___mysqli_ston"]));
	$ressup = mysqli_fetch_array($execsup);
	$suppliername = $ressup['accountname'];
	$supplieraddress = $ressup['address'];
	$supplierph = $ressup['contact'];
	
	$query2 = "select * from master_location where locationcode = '$res1locationcode'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		//$companyname = $res2["companyname"];
		$address1 = $res2["address1"];
		$address2 = $res2["address2"];
//		$area = $res2["area"];
//		$city = $res2["city"];
//		$pincode = $res2["pincode"];
		$emailid1 = $res2["email"];
		$phonenumber1 = $res2["phone"];
//		$phonenumber2 = $res2["phonenumber2"];
//		$tinnumber1 = $res2["tinnumber"];
//		$cstnumber1 = $res2["cstnumber"];
		$locationname =  $res2["locationname"];
		$prefix = $res2["prefix"];
		$suffix = $res2["suffix"];
?>
<style type="text/css">
.bodytext3 {FONT-WEIGHT:lighter; FONT-SIZE: 16px; COLOR: #000000;  vertical-align:middle;
}
.bodytext4 {FONT-WEIGHT: bold; FONT-SIZE: 16px; COLOR: #000000; vertical-align:middle;
}
.bodyhead{ FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000; border-top: 1px #000000;border-bottom: 1px #000000;
}
.border{border: 1px #000000; border-collapse:collapse;}
body {
	line-height:50px;
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
td{height:20px; }
</style>
<page backtop="10mm" backbottom="10mm" backright="10mm" backleft="10mm">
<table  border="" cellpadding="0" cellspacing="0" align="center">
	<tr>
			<td colspan="5" class="bodytext4" align="center" valign="middle"><?php echo "Avenue Hospital - ".$locationname; ?>
			<?php echo "Tel: ".$phonenumber1; ?>
		    </td>
		</tr>

<tr>
<td colspan="5" class="bodyhead" align="center">GOODS RETURNED NOTE</td>
</tr>
    <tr>
   	  <td width="140" class="bodytext4">Supplier: </td>
      <td width="326" class="bodytext3"><?php echo $suppliername; ?></td>
      <td width="221">&nbsp;</td>
      <td width="102" class="bodytext4">Ret. NO: </td>
      <td width="203" class="bodytext3"><?php echo $grt; ?></td>
	</tr>
    <tr>
   	  <td class="bodytext4">Address: </td>
        <td class="bodytext3"><?php echo $supplieraddress; ?></td>
      <td>&nbsp;</td>
      <td class="bodytext4">Ret. Date:</td>
      <td class="bodytext3"><?php echo date('d/m/Y',strtotime($res1entrydate)); ?></td>
	</tr>
    <tr>
   	  <td class="bodytext4">Phone No:</td>
        <td class="bodytext3"><?php echo $supplierph; ?></td>
      <td>&nbsp;</td>
      <td class="bodytext4">Location:</td>
      <td class="bodytext3"><?php echo $locationname; ?></td>
	</tr>
    <tr>
   	  <td class="bodytext4"></td>
        <td class="bodytext3"></td>
      <td class="bodytext4">&nbsp;</td>
      <td class="bodytext4">GRN.No:</td>
        <td class="bodytext3"><?php echo $res1grn; ?></td>
	</tr>
    <tr>
    	<td class="bodytext4"></td>
        <td class="bodytext3"></td>
        <td class="bodytext4">&nbsp;</td>
      <td class="bodytext4">Time:</td>
        <td class="bodytext3"><?php echo date('g.m A',strtotime($updatedatetime)); ?></td>
	</tr>
    <tr>
        <td class="bodytext4" colspan="5">&nbsp;</td>
	</tr>
</table>
<table border="" align="center" cellpadding="5" cellspacing="">

	<tr>
    	<td  align="center"  bgcolor="#ffffff" class="bodytext4 border" >S.No.</td>
        <td  align="center"  bgcolor="#ffffff" class="bodytext4 border" >Medicine Name</td>
        <td   align="center"  bgcolor="#ffffff" class="bodytext4 border">Batch No</td>
        <td   align="center"  bgcolor="#ffffff" class="bodytext4 border">EXP Dt</td>
        <td   align="center"  bgcolor="#ffffff" class="bodytext4 border">Pack Size</td>
        <td   align="center"  bgcolor="#ffffff" class="bodytext4 border">Qty</td>
        <td   align="right"  bgcolor="#ffffff" class="bodytext4 border">Rate</td>
      	<td width="60"   align="center" v bgcolor="#ffffff" class="bodytext4 border">Disc Amount</td>
        <td   align="right" bgcolor="#ffffff" class="bodytext4 border">Amount </td>
	</tr>
     <?php
			$colorloopcount = '';
			$sno = '';
			$grandtotalamount = 0;
			$totaldiscount = 0;
			$totalamount = 0;
			$temp = 0;
			$query11 = "select * from purchasereturn_details where billnumber = '$grt' ";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			mysqli_num_rows($exec11);
			while($res11 = mysqli_fetch_array($exec11))
			 {
			$res11itemname= $res11['itemname'];
			$res11quantity = $res11['quantity'];
			//$res11itemquantity = $res11['itemquantity'];
//			$res11itemfreequantity = $res11['itemfreequantity'];
			$res11batchnumber = $res11['batchnumber'];
			$res11expirydate = $res11['expirydate'];
			$res11packagequantity= $res11['packagequantity'];
//			$res11itemfreequantity= $res11['itemfreequantity'];
//			$res11itemtotalquantity= $res11['itemtotalquantity'];
			$res11quantity= $res11['quantity'];
			$res11quantityperpackage= $res11['packagequantity'];
			$res11rate= $res11['rate'];
			$res11totalamount= $res11['totalamount'];
			$discountamount= $res11['discountamount'];
			$res11itemtaxpercentage= $res11['itemtaxpercentage'];
			$res11subtotal= $res11['subtotal'];
//			$res11costprice= $res11['costprice'];
//			$res11salesprice= $res11['salesprice'];
//			$res11ponumber= $res11['ponumber'];
			$grandtotalamount = $grandtotalamount + $res11totalamount;
			$totaldiscount = $totaldiscount + $discountamount;
			$temp = $res11quantity;
			$temp = $temp*$res11rate;
			$totalamount = $totalamount+ $temp;
			$sno = $sno +1;
			//$balanceqty = $orderedquantity - $res11quantity;
			
		    /*$query76 = "select * from materialreceiptnote_details where billnumber='$res11ponumber' and itemstatus=''";
			$exec76 = mysql_query($query76) or die(mysql_error());
			$number = mysql_num_rows($exec76);
		    $res76 = mysql_fetch_array($exec76);
			$itemname = $res76['itemname'];*/
			
			/*$query761 = "select * from master_rfq where suppliercode='$suppliercode' and medicinecode='$itemcode' and status = 'generated' order by auto_number desc";
			$exec761 = mysql_query($query761) or die(mysql_error());
			$res761 = mysql_fetch_array($exec761);
			$orderedquantity = $res761['packagequantity'];*/
			
	
		 ?>
    <tr>
    	<td class="bodytext3 border"  align="left"><?php echo $sno; ?></td>
        <td class="bodytext3 border"  align="left"><?php echo $res11itemname; ?></td>
        <td class="bodytext3 border" align="center"><?php echo $res11batchnumber; ?></td>
        <td class="bodytext3 border"  align="center"><?php echo date('m/y',strtotime($res11expirydate)); ?></td>
        <td class="bodytext3 border" align="center"><?php echo $res11packagequantity; ?></td>
        <td class="bodytext3 border" align="center"><?php echo $res11quantity; ?></td>
        <td class="bodytext3 border"  align="right"><?php echo number_format($res11rate,2,'.',','); ?></td>
        <td class="bodytext3 border"  align="right"><?php echo $discountamount; ?></td>
        <td class="bodytext3 border"  align="right"><?php echo number_format($res11totalamount,2,'.',','); ?></td>
    </tr>
    <?php 
		}
		$totalamountinwords = $transactionamountinwords = covert_currency_to_words($grandtotalamount); 
		?>
	<tr>
    	<td align="right" class="bodytext4" colspan="8">Total Amount:</td>
		<td align="right" class="bodytext3"><?php echo number_format($totalamount,2,'.',',');?></td>
    </tr>
    <tr>
    	<td align="right" class="bodytext4" colspan="8">Disc Amount:</td>
		<td align="right" class="bodytext3"><?php echo number_format($totaldiscount,2,'.',','); ?></td>
    </tr>
    <tr>
    	<td align="right" class="bodytext4" colspan="8">Net Amount:</td>
		<td align="right" class="bodytext3"><?php echo number_format($grandtotalamount,2,'.',','); ?></td>
    </tr>
    <tr>
    	<td width="1000" class="bodytext3" colspan="9"><strong>Amount In Words: </strong><?php echo str_replace('Kenya Shillings','',$totalamountinwords); ?></td>
    </tr>
    <tr>
    	<td width="1000" class="bodytext3" colspan="9"><strong>Prepared By: </strong><?php echo $username; ?></td>
    </tr>
</table>
</page>
<!----------------------------------------------unwanted------------------------------------>

<?php	
$content = ob_get_clean();

// convert in PDF

try
{
$html2pdf = new HTML2PDF('L', 'A4', 'en');
//      $html2pdf->setModeDebug();
$html2pdf->setDefaultFont('Arial');
$html2pdf->writeHTML($content, isset($_GET['vuehtml']));

$html2pdf->Output('print_grnview.pdf');
}
catch(HTML2PDF_exception $e) {
echo $e;
exit;
}
?>
