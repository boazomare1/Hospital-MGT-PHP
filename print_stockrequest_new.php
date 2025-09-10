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

$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'LTC-1';
if (isset($_REQUEST["docno"])) { $docno = $_REQUEST["docno"]; } else { $docno = ""; }
$query43 = "select * from master_internalstockrequest where docno='$docno'";
$exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"])); 
$res43 = mysqli_fetch_array($exec43);
$from = $res43['fromstore'];
$to = $res43['tostore'];
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

.ridge {border-style: ridge;}
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

<table width="400"  border="" align="center" cellpadding="0" cellspacing="0">
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
		<!--<tr>
			<td colspan="4" class="bodytext32"><div align="center"><?php //echo $address1; ?>
		      <?php
/*			$address2 = $area.''.$city.' - '.$pincode.'';
			$strlen3 = strlen($address2);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address2 = ' '.$address2.' ';
			}*/
			?>		
		    </div></td>
		</tr>-->
		

  <tr>
    <td>&nbsp;</td>
  </tr>
  
</table>
<table width="800"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td colspan="6" align="center" class="bodytext33"><strong> Stock transfer  Request</strong></td>
</tr>
<tr>
    <td>&nbsp;</td>
  </tr>
<tr>
                      <td width="35" align="left" valign=""  class="bodytext32"><strong>Doc No</strong></td>
                      <td width="80" align="left"  class="bodytext32"><?php echo trim($docno); ?></td>
                      <td width="50" align="left" valign="" class="bodytext32"><strong>From </strong></td>
                      <td width="168" align="left" valign="" class="bodytext32"><?php echo $toname; ?></td>
                      <td width="50" align="middle" valign="" class="bodytext32"><strong>To </strong></td>
                      <td width="168" align="left" valign="" class="bodytext32"><?php echo $fromname; ?></td>
                      
					  
                    </tr>
<tr>
                      <td align="left" valign="top" class="bodytext32"><strong>Type Transfer:</strong></td>
                      <td align="left" valign="top" class="bodytext32"><?php echo $typetransfer; ?></td>
					  <td colspan="2"></td>
					   <td  valign="top"><span class="bodytext32"><strong>Date</strong></span></td>
					  <td align="left" valign="top"><span class="bodytext32"> <?php echo $updatedatetime; ?>  </span></td>
			</tr>
			<tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="800"  border="1" align="center" cellpadding="4" cellspacing="0">
  <tr>
  <td width="20" align="left" valign="middle" class="bodytext32" bgcolor="#ffffff"><strong>S.No</strong></td>
                      <td width="70" align="left" valign="middle" class="bodytext32" bgcolor="#ffffff"><strong>Item Code</strong></td>
                      <td width="250" align="left" valign="middle" class="bodytext32" bgcolor="#ffffff"><strong>Name</strong></td>
                      <td width="50" align="left" valign="middle" class="bodytext32" bgcolor="#ffffff"><strong>Req.Qty</strong></td>
                      
                      
					  </tr>
  
  		 <?php
		 		$sno ='';
				
				$transdoc = $_GET['transdoc'];
  				$query34 = "select * from master_internalstockrequest where docno='$docno' and recordstatus = 'completed'";
			
					$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$nums34 = mysqli_num_rows($exec34);
					while($res34 = mysqli_fetch_array($exec34)){
					
					$itemname = $res34['itemname'];
					$reqquantity = $res34['quantity'];
					$itemcode = $res34['itemcode'];
						
						$total_tranqyt=0;
					$query3_transdoc = "SELECT * FROM `transaction_stock` WHERE entrydocno='$transdoc' and itemcode='$itemcode' and transactionfunction='0'";
		 			$exec3_transdoc = mysqli_query($GLOBALS["___mysqli_ston"], $query3_transdoc) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					 $nums_transdoc = mysqli_num_rows($exec3_transdoc);
					 if($nums_transdoc>0){
					 $sno = $sno + 1;
					?>
					
					<tr>
						<td align="left" valign="middle" class="bodytext32"><?php echo $sno; ?></td>
					<td align="left" valign="middle" class="bodytext32"><?php echo $itemcode; ?></td>
             			 <td align="left" valign="middle" class="bodytext32"><?php echo $itemname; ?></td>
						  <td align="left" valign="middle" class="bodytext32"><?php echo $reqquantity; ?></td>
						  </tr>
						 
						  <tr>
						  <td colspan="4">
						<table width="1000"  border="0"  align="center" cellpadding="0" cellspacing="0"  >
						  <tr>
					<td width="200" align="left" valign="middle" bgcolor="#ffffff" ><strong>Batch</strong></td>
					<td width="200" align="left" valign="middle" bgcolor="#ffffff" ><strong>Exp.Date</strong></td>
                      <td  width="200" align="left" valign="middle" bgcolor="#ffffff" ><strong>Trn.Qty</strong></td>
					  
					</tr>
					<?php
					
					 
					 
					 
					 
					while($resdoc = mysqli_fetch_array($exec3_transdoc)){

						$batch = $resdoc['batchnumber'];
						$transaction_quantity = $resdoc['transaction_quantity'];
						$fifo_code = $resdoc['fifo_code'];
						$itemcode = $resdoc['itemcode'];
						$transaction_quantity= $resdoc['transaction_quantity'];
						$total_tranqyt=$total_tranqyt+$transaction_quantity;
					
					$query31 = "SELECT * FROM `purchase_details` WHERE batchnumber='$batch' and itemcode='$itemcode' and fifo_code='$fifo_code'";
		 			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$resdoc12 = mysqli_fetch_array($exec31);
					$expirydate = $resdoc12['expirydate'];
					
					
			?>
			 <tr border="1" >
                      
						  <td align="left" valign="middle"  ><?php echo $batch; ?></td>
						  <td align="left" valign="middle"  ><?php echo $expirydate; ?></td>
						  <td align="left" valign="middle"   ><?php echo $transaction_quantity; ?></td>
						  
						  </tr>
			  <?php
			        }
					
			?>  
			
			 <tr>
                      
						<td align="left" valign="middle"  ></td>
						  <td align="left" valign="middle"  ><strong>Total</strong></td>
						  <td align="left"  valign="middle"   ><strong><?php echo $total_tranqyt; ?></strong></td>
						
						  
						  </tr>
			</table>
			</td>
			</tr>
			
						<?php } }?>
	          <!--<tr>
	            <td>&nbsp;</td>
	            <td align="right">&nbsp;</td>
	            <td align="right">&nbsp;</td>
	            <td align="right">&nbsp;</td>
  </tr>-->
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
