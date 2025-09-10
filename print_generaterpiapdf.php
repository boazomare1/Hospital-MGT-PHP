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

if (isset($_REQUEST["docnumber"])) { $docnumber = $_REQUEST["docnumber"]; } else { $docnumber = ""; }

 $query1 = "select * from purchase_indent where docno='$docnumber' and approvalstatus=''";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	mysqli_num_rows($exec1);
	$res1 = mysqli_fetch_array($exec1);
	$res1entrydate= $res1['date'];
	$res1suppliername= $res1['suppliername'];
	$res1suppliercode= $res1['suppliercode'];
	$res1itemcode= $res1['medicinecode'];
	//$res1locationname= $res1['location'];
	$res1locationcode= $res1['locationcode'];
	$username = $res1['username'];
	$billnumber = $res1['docno'];
	
	$userfullname=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$username' and username <> ''");
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
<page backtop="10mm" backright="10mm" backleft="10mm">
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
<td colspan="5" class="bodyhead" align="center">PURCHASE INDENT</td>
</tr>
    <tr>
   	  <td width="140" class="bodytext4">Supplier: </td>
      <td width="326" class="bodytext3"><?php echo $res1suppliername; ?></td>
      <td width="221">&nbsp;</td>
      <td width="102" class="bodytext4">PI No: </td>
      <td width="203" class="bodytext3"><?php echo $billnumber; ?></td>
	</tr>
    <tr>
   	  <td class="bodytext4">Address: </td>
        <td class="bodytext3"><?php echo $supplieraddress; ?></td>
      <td>&nbsp;</td>
      <td class="bodytext4">PI Date:</td>
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
      <td class="bodytext4">Time:</td>
        <td class="bodytext3"><?php echo date('g.m A',strtotime($updatedatetime)); ?></td>
	</tr>
    <tr>
        <td class="bodytext4" colspan="5">&nbsp;</td>
	</tr>
</table>
<table width="800" border="1"  align="center" cellpadding="5" cellspacing="">

	<tr>
				<td width="30"  align="left" valign="center" class="bodytext31"><strong>S.No</strong></td>
                <td width="20"  align="left" valign="center" class="bodytext31"><strong>Medicine Code</strong></td>
				<td width="30"  align="left" valign="center" class="bodytext31"><strong>Medicine Name</strong></td>
				<td width="60"  align="left" valign="center" class="bodytext31"><strong>MED's/ Supplier Code</strong></td>
				<td width="100"  align="left" valign="center" class="bodytext31"><strong>Supplier Mapped </strong></td>
				<td width="83"  align="left" valign="center" class="bodytext31"><strong>Avl Qty</strong></td>
				<td width="57"  align="left" valign="center" class="bodytext31"><strong>Req Qty</strong></td>
				<td width="64"  align="left" valign="center" class="bodytext31"><strong>Pack Size</strong></td>
				<td width="55"  align="left" valign="center" class="bodytext31"><strong>Pkg Qty</strong></td>
				<td width="37"  align="left" valign="center" class="bodytext31"><strong>Rate</strong></td>
				<td width="30"  align="left" valign="center" class="bodytext31"><strong>Amount</strong></td>
				
			</tr>
     	  		<?php
			$colorloopcount = '';
			$sno = 0;
			$totalamount=0;			
			$query12 = "select * from purchase_indent where docno='$docnumber' and (approvalstatus='' or approvalstatus='rejected1')";
			$exec12= mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numb=mysqli_num_rows($exec12);
			
			while($res12 = mysqli_fetch_array($exec12))
         {
		$medicinename = $res12['medicinename'];
		$itemcode = $res12['medicinecode'];
		$purchasetype = $res12['purchasetype'];
		$reqqty = $res12['quantity'];
		$originalqty= $res12['originalqty'];
		$originalamt=$res12['originalamt'];
		if(strtolower(trim($purchasetype))==strtolower('Expenses') || strtolower(trim($purchasetype))==strtolower('Others'))
		{
			$itemcode = $res12['auto_number'];
		}
		$query231 = "select * from master_employeelocation where username='$username' and defaultstore='default'";
		$exec231 = mysqli_query($GLOBALS["___mysqli_ston"], $query231) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res231 = mysqli_fetch_array($exec231);
		 $res7locationanum1 = $res231['locationcode'];
		
		/*$query551 = "select * from master_location where auto_number='$res7locationanum1'";
		$exec551 = mysql_query($query551) or die(mysql_error());
		$res551 = mysql_fetch_array($exec551);
		$location = $res231['locationname'];*/
		
		 $res7storeanum1 = $res231['storecode'];
		
		$query751 = "select * from master_store where auto_number='$res7storeanum1'";
		$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res751 = mysqli_fetch_array($exec751);
		$store = $res751['store'];
		$storecode = $res751['storecode'];
		
	
		
			$query2 = "select * from master_medicine where itemcode = '$itemcode'";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2 = mysqli_fetch_array($exec2);
			$package = $res2['packagename'];
			$meds_code = $res2['itemcode'];
			
			$packagequantity = $res12['packagequantity'];
			$rate = $res12['rate'];
			$amount = $res12['amount']; 
			$itemcode = $itemcode;
		//include ('autocompletestockcount1include1.php');
		//$querystock1 = "select sum(batch_quantity) as currentstock from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$locationcode' and storecode ='$storecode'";
//		$execstock1 = mysql_query($querystock1) or die ("Error in Querystock1".mysql_error());
//		$resstock1 = mysql_fetch_array($execstock1);
//		$currentstock = $resstock1['currentstock'];
//		$currentstock = $currentstock;
		
		$totalamount= $totalamount + $amount;
		$sno = $sno + 1;
		$query7512 = "select * from master_itemtosupplier where itemcode='$itemcode' and storecode='$storecode'";
		$exec7512 = mysqli_query($GLOBALS["___mysqli_ston"], $query7512) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res7512 = mysqli_fetch_array($exec7512);
		$mappedsuppliername = $res7512['suppliername'];
?>
  <tr>
				<td class="bodytext31" valign="center"  align="left"><?php echo $sno;?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $itemcode;?></td>

		<td class="bodytext31" valign="center"  align="left"><?php echo $medicinename;?>
			</td>
		<td class="bodytext31" valign="center"  align="left"><?php echo $meds_code;?></td>
		<td class="bodytext31" valign="center"  align="left"><?php echo $mappedsuppliername;?></td>

		<td class="bodytext31" valign="center"  align="left"><?php echo $originalqty;?></td>
		<td class="bodytext31" valign="center"  align="left"><?php echo number_format($reqqty);?></td>
		<td class="bodytext31" valign="center"  align="left"><?php echo $package;?></td>
		<td class="bodytext31" valign="center"  align="left"><?php echo $packagequantity;?></td>
		<td class="bodytext31" valign="center"  align="left"><?php echo number_format($rate,'2','.',',');?></td>
		<td class="bodytext31" valign="center"  align="left"><?php echo number_format($originalamt,'2','.',',');?></td>
        
				</tr>
			<?php 
		
			}
		
	 $grandtotalamount = '0';
	//$totalamountinwords = $transactionamountinwords = covert_currency_to_words($grandtotalamount); 
		$totalamountinwords =convertNumber($totalamount);
			
		?>
	<tr>
    	<td align="right" class="bodytext4" colspan="10">Total Amount:</td>
		<td align="right" class="bodytext3"><?php echo number_format($totalamount,2,'.',',');?></td>
    </tr>
    
    <tr>
    	<td class="bodytext3" colspan="11"><strong>Amount In Words: </strong><?php echo str_replace('Kenya Shillings','',$totalamountinwords); ?></td>
    </tr>
    <tr>
    	<td class="bodytext3" colspan="11"><strong>Prepared By&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong>&nbsp;<?php echo $username; ?></td>
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
