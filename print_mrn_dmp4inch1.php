<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$dateonly = date("Y-m-d");
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];

if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }

if (isset($_REQUEST["billnum"])) { $billnum = $_REQUEST["billnum"]; } else { $billnum = ""; }

if (isset($_REQUEST["supplierbillno"])) { $supplierbillno = $_REQUEST["supplierbillno"]; } else { $supplierbillno = ""; }

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
    $sno = 0;       

	include('convert_currency_to_words.php');
?>

<table width="1076" border="0" cellpadding="0" cellspacing="0" align="center">
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
		  <td colspan="6"><div align="center"><?php echo $address2; ?>
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
			?></div></td>
  </tr>
		<tr>
		  <td colspan="6">&nbsp;</td>
  </tr>
		<tr>
			<td colspan="6">
			
			  <div align="center"></div></td>
		</tr>

	     <tr>
		 <?php
			$query56 = "select * from master_rfqpurchaseorder where billnumber = '$billnum' and recordstatus='generated' order by billnumber";
			$exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die ("Error in Query56".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res56 = mysqli_fetch_array($exec56);
		    $billdate = $res56['billdate'];
			
			$query23 = "select * from master_employee where username='$username'";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res23 = mysqli_fetch_array($exec23);
			$res7locationanum = $res23['location'];
			
			$query55 = "select * from master_location where auto_number='$res7locationanum'";
			$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res55 = mysqli_fetch_array($exec55);
			$location = $res55['locationname'];
			
			$query55 = "select * from master_location where auto_number='$res7locationanum'";
			$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res55 = mysqli_fetch_array($exec55);
			$location = $res55['locationname'];
			
			$res7storeanum = $res23['store'];
			
			$query75 = "select * from master_store where auto_number='$res7storeanum'";
			$exec75 = mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res75 = mysqli_fetch_array($exec75);
			$store = $res75['store'];

				$query5 = "select * from master_rfqpurchaseorder where billnumber = '$billnum' and recordstatus='generated' order by billnumber";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res5 = mysqli_fetch_array($exec5);
				$totalreceivedqty = 0;
			
				$billnum = $res5["billnumber"];
				$suppliername = $res5['suppliername'];
				$suppliercode = $res5['suppliercode'];

				//$totalreceivedqty = 0;
				$itemname = $res5['itemname'];
				$itemcode = $res5['itemcode'];
				$suppliername = strtoupper($suppliername);
				$billdate = $res5['billdate'];
				
				
				
				$query57 = "select * from master_rfq where suppliercode='$suppliercode' and medicinecode='$itemcode' and status = 'generated' order by auto_number desc";
			$exec57 = mysqli_query($GLOBALS["___mysqli_ston"], $query57) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res57 = mysqli_fetch_array($exec57);
			$rate = $res57['rate'];
			$amount = $res57['amount'];
			$packagequantity = $res57['packagequantity'];
			$packsize = $res57['packsize'];
			$packsizelen = strlen($packsize);
			$unitquantity = substr($packsize,0,$packsizelen-1);
			$quotedprice = $amount/($unitquantity * $packagequantity);
			
			$query444 = "select * from materialreceiptnote_details where itemcode='$itemcode' and ponumber='$billnum'";
				$exec444 = mysqli_query($GLOBALS["___mysqli_ston"], $query444) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$num444 = mysqli_num_rows($exec444);
				while($res444 = mysqli_fetch_array($exec444))
				{
				$receivedqty = $res444['quantity'];
				$totalreceivedqty = $totalreceivedqty+$receivedqty;
				}
				
				$balanceqty = $packagequantity - $totalreceivedqty;

			$query12 = "select * from materialreceiptnote_details where billnumber = '$billautonumber' ";
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));	
			$res12= mysqli_fetch_array($exec12);	
			$res12location = $res12["location"];
			$res12store = $res12["store"];
			$res12supplierbillnumber= $res12['supplierbillnumber'];

         ?>
			 
			    <td width="89"><strong>DOC No</strong></td>
                <td width="370"><?php echo $billautonumber; ?></td>
                <td width="110"><strong>Select PO</strong></td>
                <td width="333"><?php echo $billnum; ?></td>
           <td width="86"><strong>LPO Date </strong></td>
                <td width="88"><?php echo $billdate; ?></td>
	    </tr>
		<tr>
			    <td><strong>Supplier</strong></td>
                <td><?php echo $suppliername; ?></td>
                <td><strong>Invoice No</strong></td>
                <td><?php echo $res12supplierbillnumber; ?></td>
                <td><strong>MRN Date </strong></td>
                <td><?php echo $dateonly;?></td>
	   </tr>
	   
	    <tr>
	      <td><strong>Location</strong></td>
	      <td><?php echo $res12location; ?></td>
	      <td><strong>Store</strong></td>
	      <td><?php echo $res12store; ?></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
  </tr>
     <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
	</tr>
</table>

<table width="1046" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
	<td width="40"><strong>S.No</strong></td>
	<td width="204"><strong>Item</strong></td>
	<td width="61" align="center"><strong>Ord.Qty</strong></td>
	<td width="65" align="center"><strong>Recd.Qty</strong></td>
	<td width="61" align="center"><strong>Bal.Qty</strong></td>
	<td width="61" align="center"><strong>Batch</strong></td>
	<td width="61" align="center"><strong>Exp.Dt</strong></td>
	<td width="61" align="center"><strong>Pkg.Size</strong></td>
	<td width="61" align="center"><strong>Free</strong></td>	  
	<td width="61" align="center"><strong>Tot.Qty</strong></td>
	<td width="61" align="center"><strong>QP/PK</strong></td>
	<td width="56" align="right"><strong>Price/Pk</strong></td>
	<td width="58" align="center"><strong>Disc %</strong></td>
	<td width="38" align="center"><strong>Tax</strong></td>
	<td width="78" align="right"><strong>Total Value</strong></td>
  </tr>
  
  <?php
    $query11 = "select * from materialreceiptnote_details where billnumber = '$billautonumber' ";
	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	mysqli_num_rows($exec11);
	while($res11 = mysqli_fetch_array($exec11)) 
	 {
	$res11ponumber = $res11['ponumber'];
	//$res11patientcode = $res11['patientcode'];
	$res11entrydate = $res11['entrydate'];
	$res11suppliername = $res11['suppliername'];
	$res11location= $res11['location'];
    $res11store= $res11['store'];
	$res11rate= $res11['rate'];
	$res11itemname= $res11['itemname'];
    $res11itemfreequantity= $res11['itemfreequantity'];
	$res11itemtotalquantity= $res11['itemtotalquantity'];
    $res11batchnumber= $res11['batchnumber'];
	$res11expirydate= $res11['expirydate'];
    $res11priceperpack= $res11['priceperpack'];
	$res11discountpercentage= $res11['discountpercentage'];
	$res11itemtaxamount= $res11['itemtaxamount'];
	$res11allpackagetotalquantity= $res11['allpackagetotalquantity'];
	$res11totalamount= $res11['totalamount'];
    $res11free= $res11['free'];
	$res11unit_abbreviation= $res11['unit_abbreviation'];
    $res11unit_abbreviation= $res11['unit_abbreviation'];
	$res11username = $res11['username'];
	?>
	<tr>
		<td><?php echo $sno= $sno + 1; ?></td>
		<td><?php echo $res11itemname; ?></td>
		<td align="center"><?php echo $packagequantity; ?></td>
		<td align="center"><?php echo intval($res11itemtotalquantity); ?></td>
		<td align="center"><?php echo intval($balanceqty); ?></td>
		<td align="center"><?php echo $res11batchnumber; ?></td>
		<td align="center"><?php echo date('m/y',strtotime($res11expirydate)); ?></td>
		<td align="center"><?php echo $res11unit_abbreviation; ?></td>
		<td align="center"><?php echo $res11free; ?></td>	  
		<td align="center"><?php echo $res11allpackagetotalquantity; ?></td>
		<td align="center"><?php echo $res11rate; ?></td>
		<td align="center"><?php echo $res11priceperpack; ?></td>
		<td align="center"><?php echo $res11itemtaxamount; ?></td>
		<td align="right"><?php echo $res11itemtaxamount; ?></td>
		<td align="right"><?php echo $res11totalamount; ?></td>
	</tr>
	<?php
	  }
	  ?>
</table>
<?php	
$content = ob_get_clean();

// convert in PDF

try
{
$html2pdf = new HTML2PDF('L', 'A4', 'en');
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
