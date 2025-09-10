<?php

require_once('html2pdf/html2pdf.class.php');

ob_start();

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");

include('convert_number.php');



$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];

$financialyear = $_SESSION["financialyear"];

$username = $_SESSION['username'];

$location=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';



if (isset($_REQUEST["billnumber"])) { $billnumber = $_REQUEST["billnumber"]; } else { $billnumber = ""; }



	 $query1 = "select * from materialreceiptnote_details where billnumber = '$billnumber' ";

	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

	mysqli_num_rows($exec1);

	$res1 = mysqli_fetch_array($exec1);

	$res1entrydate= $res1['entrydate'];

	$res1suppliername= $res1['suppliername'];

	$res1suppliercode= $res1['suppliercode'];

	$res1supplierbillnumber= $res1['supplierbillnumber'];

	$res1itemcode= $res1['itemcode'];

	//$res1locationname= $res1['location'];

	$res1locationcode= $res1['locationcode'];

	$res1store= $res1['store'];

	$res1po = $res1['ponumber'];

	$username = $res1['username'];

	

	$userfullname=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$username' and locationcode='$location'");

	$resquery=mysqli_fetch_array($userfullname);

	$username=$resquery['employeename'];



//supplier details

	$querysup = "SELECT * FROM master_accountname WHERE id='$res1suppliercode' and accountname = '$res1suppliername'";

	$execsup = mysqli_query($GLOBALS["___mysqli_ston"], $querysup) or die ("Error in querysup".mysqli_error($GLOBALS["___mysqli_ston"]));

	$ressup = mysqli_fetch_array($execsup);

	$suppliername = $ressup['accountname'];

	$supplieraddress = $ressup['address'];

	//$suppliercity = $ressup['city'];

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

		$website = $res2['website'];

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

table {

    border-collapse: collapse;

}

td{height:20px; }

</style>

<page backtop="5mm" backright="5mm" backleft="5mm">

  <?php include('convert_currency_to_words.php'); ?>

<table    border="0" align="left" cellpadding="0" cellspacing="0">

 <tr>

     <td width="300" rowspan="5"  align="left" valign="center" ><?php

			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";

			$exec3showlogo = mysqli_query($GLOBALS["___mysqli_ston"], $query3showlogo) or die ("Error in Query3showlogo".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res3showlogo = mysqli_fetch_array($exec3showlogo);

			$showlogo = $res3showlogo['showlogo'];

			if ($showlogo == 'SHOW LOGO')

			{ 

			?>

      <img src="logofiles/1.jpg" width="140" height="150" />

    <?php

			}

			?></td>

          

			<td  width="700" class="bodytext4"  align="right" valign="middle">

            <h1><?php echo $locationname; ?></h1>

            <p><?php echo $address1; ?><br />

            <?php echo $address2; ?><br />

      Tel : <?php echo $phonenumber1; ?><br />

      Website : <?php echo $website; ?></p>

            </td>

         </tr>

</table>



<table  border="0" cellpadding="0" cellspacing="0" align="center">

<tr>

<td colspan="5">&nbsp;</td>

</tr>

<tr>

<td colspan="5" class="bodyhead" align="center">MATERIAL RECEIVED NOTE</td>

</tr>

    <tr>

   	  <td width="140" class="bodytext4">Supplier: </td>

      <td width="326" class="bodytext3"><?php echo $res1suppliername; ?></td>

      <td width="221">&nbsp;</td>

      <td width="102" class="bodytext4">GRN No: </td>

      <td width="203" class="bodytext3"><?php echo $billnumber; ?></td>

	</tr>

    <tr>

   	  <td class="bodytext4">Address: </td>

        <td colspan="2" class="bodytext3"><?php echo $supplieraddress; ?></td>

      

      <td class="bodytext4">GRN Date:</td>

      <td class="bodytext3"><?php echo date('d/m/Y',strtotime($res1entrydate)); ?></td>

	</tr>

    <tr>

   	  <td class="bodytext4">Phone No:</td>

        <td class="bodytext3"><?php echo $supplierph; ?></td>

      <td>&nbsp;</td>

      <td class="bodytext4">Invoice No:</td>

      <td class="bodytext3"><?php echo $res1supplierbillnumber; ?></td>

	</tr>

   <!--  <tr>

   	  <td></td>

        <td></td>

      <td class="bodytext4">&nbsp;</td>

      <td class="bodytext4">L.P.O No:</td>

        <td class="bodytext3"><?php echo $res1po; ?></td>

	</tr> -->

    <tr>

    	<td></td>

        <td></td>

      <td>&nbsp;</td>

      <td class="bodytext4">Location:</td>

      <td class="bodytext3"><?php echo $locationname; ?></td>

	</tr>

    <tr>

    	<td class="bodytext4"></td>

        <td class="bodytext3"></td>

        <td class="bodytext4">&nbsp;</td>

      <td class="bodytext4">Time:</td>

        <td class="bodytext3"><?php echo date('g.m A',strtotime($updatedatetime)); ?></td>

	</tr>
	<?php 
	$ponumbers = array();
	$query1 = "SELECT ponumber FROM materialreceiptnote_details WHERE billnumber = '$billnumber' group by ponumber";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res1 = mysqli_fetch_array($exec1)){
		$res01ponumber = $res1['ponumber'];
		array_push($ponumbers, $res01ponumber);
	}		
	$ponumber = rtrim(implode(', ', $ponumbers), ',');
	
	?>
    <tr>

    	<td class="bodytext4"></td>

        <td class="bodytext3"></td>

        <td class="bodytext4">&nbsp;</td>

      <td class="bodytext4">LPOs:</td>

        <td class="bodytext3"><?php echo wordwrap($ponumber,25,"<br>\n");?></td>

	</tr>

    <tr>

        <td class="bodytext4" colspan="5">&nbsp;</td>

	</tr>

</table>

<table width="100%" border=""  align="center" cellpadding="0" cellspacing="">



	<tr>

        <td  align="center" width="210"  class="bodytext4 border" >Medicine Name</td>

        <td width="82"   align="center"   class="bodytext4 border">Batch No</td>

        <td width="67"   align="center"   class="bodytext4 border">EXP Dt</td>

        <td width="74"   align="center"  class="bodytext4 border">Pack Size</td>

        <td width="70"   align="center"   class="bodytext4 border">Pur.Qty</td>

        <td width="70"   align="center"   class="bodytext4 border">Tot.Qty</td>

        <td width="60"   align="center"   class="bodytext4 border">Bonus</td>

        <td width="90"   align="right"   class="bodytext4 border">Rate</td>

      	<td width="63"   align="center"   class="bodytext4 border">Discount %</td>
      	<td width="25"   align="center"   class="bodytext4 border">Tax %</td>

        <td width="100"   align="right" class="bodytext4 border">Amount </td>

	</tr>

     <?php

			$colorloopcount = '';

			$sno = '';

			$grandtotalamount = 0;

			$totaldiscount = 0;

			$totalamount = 0;

			$temp = 0;
			$total_tax_amount = 0;

			$query11 = "select * from materialreceiptnote_details where billnumber = '$billnumber' ";

			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

			mysqli_num_rows($exec11);

			while($res11 = mysqli_fetch_array($exec11))

			 {

			$res11itemname= $res11['itemname'];

			$res11quantity = $res11['quantity'];

			//$res11itemquantity = $res11['itemquantity'];

			$res11itemfreequantity = $res11['itemfreequantity'];

			$res11batchnumber = $res11['batchnumber'];

			$res11expirydate = $res11['expirydate'];

			$res11packagename= $res11['packagename'];

			$res11itemfreequantity= $res11['itemfreequantity'];

			$res11itemtotalquantity= $res11['itemtotalquantity'];

			$res11allpackagetotalquantity= $res11['allpackagetotalquantity'];

			$res11quantityperpackage= $res11['quantityperpackage'];

			$res11rate= $res11['rate'];

			$res11totalamount= $res11['totalamount'];

			$res11discountpercentage= $res11['discountpercentage'];

			$res11itemtaxpercentage= $res11['itemtaxpercentage'];

			$res11subtotal= $res11['subtotal'];

			//$res11costprice= $res11['costprice'];

			$res11costprice= $res11['fxpkrate'];

			$res11salesprice= $res11['salesprice'];

			$res11ponumber= $res11['ponumber'];

			$amount = $res11costprice * $res11allpackagetotalquantity;

			

			$temp = $res11allpackagetotalquantity - $res11itemfreequantity;

			$temp = $temp*$res11rate;

			$totalamount += $amount;

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

			$tax_amount = $res11['itemtaxamount'];
			$tax_percentage = $res11['itemtaxpercentage'];

		$total_tax_amount = $total_tax_amount + $tax_amount;

		 ?>

    <tr>

        <td class="bodytext3 border"  width="210" nowrap="nowrap" align="left"><?php echo $res11itemname; ?></td>

        <td class="bodytext3 border" width="82" align="center"><?php echo $res11batchnumber; ?></td>

        <td class="bodytext3 border" width="67" align="center"><?php echo date('m/y',strtotime($res11expirydate)); ?></td>

        <td class="bodytext3 border" width="74" align="center"><?php echo $res11packagename; ?></td>

        <td class="bodytext3 border" width="70" align="center"><?php echo $res11itemtotalquantity; ?></td>

        <td class="bodytext3 border" width="70" align="center"><?php echo $res11allpackagetotalquantity; ?></td>

        <td class="bodytext3 border" width="60" align="center"><?php echo $res11itemfreequantity; ?></td>

        <td class="bodytext3 border" width="90" align="right"><?php echo number_format($res11costprice,2,'.',','); ?></td>
        
        <td class="bodytext3 border" width="60" align="right"><?php echo $res11discountpercentage; ?></td>

        <td class="bodytext3 border" width="50" align="right"><?php echo $res11itemtaxpercentage; ?></td>

        <td class="bodytext3 border" width="100" align="right"><?php echo number_format($res11totalamount,2,'.',','); ?></td>

    </tr>

    <?php 

		$discountcal = ($amount*$res11discountpercentage)/100;

		$totaldiscount = $totaldiscount + $discountcal;

		//$grandtotalamount = $grandtotalamount + $amount - $discountcal;

		$grandtotalamount = ($grandtotalamount + $res11totalamount) - $discountcal;

			

	}

	  //$grandtotalamou=explode(".", (string) $grandtotalamount);

	//$totalamountinwords = $transactionamountinwords = covert_currency_to_words($grandtotalamount); 

		$totalamountinwords =convertNumber($grandtotalamount);

			

		?>

	<tr>

    	<td align="right" class="bodytext4" colspan="10">Total Amount:</td>

		<td align="right" class="bodytext3"><?php echo number_format($totalamount,2,'.',',');?></td>

    </tr>

    <tr>

    	<td align="right" class="bodytext4" colspan="10">Disc Amount:</td>

		<td align="right" class="bodytext3"><?php echo number_format($totaldiscount,2,'.',','); ?></td>

    </tr>

     <tr>

    	<td align="right" class="bodytext4" colspan="10">Tax Amount:</td>

		<td align="right" class="bodytext3"><?php echo number_format($total_tax_amount,2,'.',','); ?></td>

    </tr>
    <tr>

    	<td align="right" class="bodytext4" colspan="10">Net Amount:</td>

		<td align="right" class="bodytext3"><?php echo number_format($grandtotalamount,2,'.',','); ?></td>

    </tr>

    <tr>

    	<td class="bodytext3" colspan="10"><strong>Amount In Words: </strong><?php echo str_replace('Kenya Shillings','',$totalamountinwords); ?></td>

    </tr>

    <tr>

    	<td class="bodytext3" colspan="10"><strong>Prepared By&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong>&nbsp;<?php echo $username; ?></td>

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

