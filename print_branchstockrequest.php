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
 
$username = $_SESSION['username'];
$docno_session = $_SESSION['docno'];
 
// $locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'LTC-1';
$query1 = "select * from login_locationdetails where username='$username' and docno='$docno_session' group by locationname order by locationname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1location = $res1["locationname"];
$locationcode = $res1["locationcode"];
if (isset($_REQUEST["docno"])) { $docno = $_REQUEST["docno"]; } else { $docno = ""; }
if (isset($_REQUEST["transdoc"])) { $transdoc = $_REQUEST["transdoc"]; } else { $transdoc = ""; }
$query43 = "select * from master_branchstockrequest where docno='$docno'";
$exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"])); 
$res43 = mysqli_fetch_array($exec43);
$from = $res43['fromstore'];
$to = $res43['tostore'];
$to_loc = $res43['to_location'];
$from_loc = $res43['from_location'];
$typetransfer = $res43['typetransfer'];
if($typetransfer=='0')
{
	$typetransfer='Transfer';
}
else
{
	$typetransfer='Consumable';
}
$queryfrom751 = "select store from master_store where storecode='$from'";
$execfrom751 = mysqli_query($GLOBALS["___mysqli_ston"], $queryfrom751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$resfrom751 = mysqli_fetch_array($execfrom751);
$fromname = $resfrom751['store'];
$query_location = "SELECT locationname from master_location WHERE locationcode = '".$from_loc."'";
$exec_location = mysqli_query($GLOBALS["___mysqli_ston"], $query_location) or die ("Error in Query_location".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_location = mysqli_fetch_array($exec_location);
$from_location_name = $res_location["locationname"];
$query_location_to = "SELECT locationname from master_location WHERE locationcode = '".$to_loc."'";
$exec_location_to = mysqli_query($GLOBALS["___mysqli_ston"], $query_location_to) or die ("Error in Query_location".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_location_to = mysqli_fetch_array($exec_location_to);
$to_location_name = $res_location_to["locationname"];
$queryto751 = "select store from master_store where storecode='$to'";
$execto751 = mysqli_query($GLOBALS["___mysqli_ston"], $queryto751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$resto751 = mysqli_fetch_array($execto751);
$toname = $resto751['store'];
	$query2 = "select * from master_company where locationcode='$locationcode' and auto_number = '$companyanum'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_fetch_array($exec2);
	$companyname = $res2["companyname"];
	$address1 = $res2["address1"];
	$area = $res2["area"];
	$city = 
	
	$res2["city"];
	$pincode = $res2["pincode"];
	$phonenumber1 = $res2["phonenumber1"];
	$phonenumber2 = $res2["phonenumber2"];
	$tinnumber1 = $res2["tinnumber"];
	$cstnumber1 = $res2["cstnumber"];
	
	include('convert_currency_to_words.php');
	
	
	$billamount=0;
?>
<?php 
$query2 = "select * from master_location where locationcode = '$locationcode'";
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
		$locationcode = $res2["locationcode"];
//		$phonenumber2 = $res2["phonenumber2"];
//		$tinnumber1 = $res2["tinnumber"];
//		$cstnumber1 = $res2["cstnumber"];
		$locationname =  $res2["locationname"];
		$prefix = $res2["prefix"];
		$suffix = $res2["suffix"];
?>
<style type="text/css">
.bodytext31 { FONT-SIZE: 8px; COLOR: #000000; }
.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #000000; }
.bodytext35 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; }
.bodytext34 { FONT-SIZE: 22px; COLOR: #000000; vertical-align:bottom;}
table {
   display: table;
   width: 100%;
   table-layout: fixed;
   border-collapse:collapse;
}
.tableborder{
   border-collapse:collapse;
   border:1px solid black;}
.bodytext33{FONT-WEIGHT: bold; FONT-SIZE: 14px; COLOR: #000000; text-decoration:underline;}
border{border:1px solid #000000; }
borderbottom{border-bottom:1px solid #000000;}
</style>
<?php include_once('print_header_pdf3.php'); ?>
<!-- <table width="400"  border="" align="center" cellpadding="0" cellspacing="0">
	<tr valign="middle"><td  width="270" class="bodytext32" align="center" >&nbsp;</td></tr>
		<tr valign="middle">
			<td  width="270" class="bodytext34" align="center" ><?php echo "".$locationname; ?>
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
            </td>
            </tr>
            <tr valign="middle"  >
			<td  width="270"  class="bodytext35" align="center" nowrap="nowrap" >
				<?php echo "TEL: ".$phonenumber1; ?>
		        <?php
			/*$address3 = "TEL: ".$phonenumber1;
			$strlen3 = strlen($address3);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address3 = ' '.$address3.' ';
			}*/
			?></td>
		</tr>
		 
		
  <tr>
    <td>&nbsp;</td>
  </tr>
  
</table> -->
<br>
<br>
<br>
 
<table width="800"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td colspan="6" align="center" class="bodytext33"><strong>Branch Stock Transfer Request</strong></td>
</tr>
<tr>
    <td colspan="6">&nbsp;</td>
  </tr>
				<tr>
                      <td width="35" align="left" valign=""  class="bodytext32"><strong>Doc No : </strong></td>
                      <td width="250" align="left"  class="bodytext32"><?php echo trim($transdoc); ?></td>
                      
                      <td  valign="top"><span class="bodytext32"><strong>Date : </strong></span></td>
					  <td width="225" align="left" valign="top"><span class="bodytext32"> <?php echo date("d/m/Y H:i:s", strtotime($updatedatetime)); ?>   </span></td>
					  
                </tr>
				<tr>
						<td width="50" align="left" valign="" class="bodytext32"><strong>From : </strong></td>
                      <td width="168" align="left" valign="" class="bodytext32"><?php echo $toname.'--'.$to_location_name; ?></td>
                      <td width="50" align="middle" valign="" class="bodytext32"><strong>To : </strong></td>
                      <td width="168" align="left" valign="" class="bodytext32"><?php echo $fromname.'--'.$from_location_name; ?></td>
				</tr>
			<tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="800"  border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
                      <td width="25" align="left" valign="middle" class="bodytext32" bgcolor="#ffffff"><strong>No</strong></td>
                      <td width="300" align="left" valign="middle" class="bodytext32" bgcolor="#ffffff"><strong>Item</strong></td>
                      <td width="50" align="center" valign="middle" class="bodytext32" bgcolor="#ffffff"><strong>Req.Qty</strong></td>
                      <td width="50" align="center" valign="middle" class="bodytext32" bgcolor="#ffffff"><strong>Batch</strong></td>
                      <td width="50" width="44" align="center" valign="middle" bgcolor="#ffffff" class="bodytext32"><strong>Trn.Qty</strong></td>
                      <td width="50" width="44" align="center" valign="middle" bgcolor="#ffffff" class="bodytext32"><strong>Rate</strong></td>
                      <td width="50" width="44" align="center" valign="middle" bgcolor="#ffffff" class="bodytext32"><strong>Amount</strong></td>
                      
					  </tr>
  
  		 <?php
				$sno ='';
				$grdtot=0;
				$transdoc = $_GET['transdoc'];

				$query34 = "select * from master_branchstockrequest where docno='$docno'";
				$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$nums34 = mysqli_num_rows($exec34);
				while($res34 = mysqli_fetch_array($exec34))
				{
				$itemname = $res34['itemname'];
				$itemcode = $res34['itemcode'];
				$reqquantity = $res34['quantity'];


				$query341 = "select * from branch_stock_transfer where requestdocno='$docno' and itemcode='$itemcode'";
				$exec341 = mysqli_query($GLOBALS["___mysqli_ston"], $query341) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$nums341 = mysqli_num_rows($exec341);
				$res341 = mysqli_fetch_array($exec341);
				$rate = $res341['rate'];
				$amount = $res341['amount'];
				$grdtot=$grdtot+$amount;

				$query3_transdoc = "SELECT * FROM `transaction_stock` WHERE entrydocno='$transdoc' and itemcode='$itemcode' and transactionfunction='0'";
				$exec3_transdoc = mysqli_query($GLOBALS["___mysqli_ston"], $query3_transdoc) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$nums_transdoc = mysqli_num_rows($exec3_transdoc);
				while($resdoc = mysqli_fetch_array($exec3_transdoc)){
				$batch = $resdoc['batchnumber'];
				$transaction_quantity = $resdoc['transaction_quantity'];
				$sno = $sno + 1;
			?>
			 <tr>
                      <td align="left" valign="middle" class="bodytext32"><?php echo $sno; ?></td>
             			 <td align="left" valign="middle" class="bodytext32"><?php echo $itemname; ?></td>
						  <td align="right" valign="middle" class="bodytext32"><?php echo $reqquantity; ?></td>
						  <td align="left" valign="middle" class="bodytext32"><?php echo $batch; ?></td>
						  <td align="right" valign="middle" class="bodytext32"><?php echo $transaction_quantity; ?></td>
						  <td align="right" valign="middle" class="bodytext32"><?php echo $rate; ?></td>
						  <td align="right" valign="middle" class="bodytext32"><?php echo number_format($amount,2,'.',','); ?></td>
						 <!--  <td>&nbsp;</td>
						  <td>&nbsp;</td> -->
						  </tr>
			  <?php }
			  }
			?>
			
			
	          <tr>
	            <td  colspan="6" align="right"><strong>Total:</strong></td>
	            <td align="right"><strong><?php echo number_format($grdtot,2,'.',','); ?></strong></td>
  </tr>
  </table>
  <style type="text/css">
  	.pad{
  		padding: 10px;
  	}
  </style>
 <table width="800"  border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top: 100px;">
  	<tr>
  		<td style="padding-right: 400px;">
  			<table>
  				<tr  > <td class="pad"><b>Issued By</b> </td> </tr>
  				<tr ><td class="pad" align="center"><b><?=ucwords($username);?></b></td></tr>
  			</table>
  		</td>
  		<td>
  			<table>
  				 <tr><td class="pad" align="center"><b>Received By</b></td></tr>
  				 <tr><td class="pad" align="center">______________________</td></tr>
  			</table>
  		</td>
  	</tr>
  </table>
  
<?php	
	$content = ob_get_clean();
   
    // convert to PDF
   
    try
    {	
		$width_in_inches = 3.38;
		$height_in_inches = 3.38;
		$width_in_mm = $width_in_inches * 25.4; 
		$height_in_mm = $height_in_inches * 25.4;
        $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(0, 0, 0,0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->setDefaultFont('Helvetica');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('print_consultationbill.pdf');
		
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
	
?>