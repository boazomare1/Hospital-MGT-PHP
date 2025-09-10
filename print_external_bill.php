<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$res21radiologyitemrate = '';
$subtotal = '';
$res19amount1 = ''; 
$res20amount1 = ''; 
$res21amount1 = ''; 
$res22amount1 = '';
$res23amount1 = '';
$res18total  = '';
$colorloopcount = '';
$totallab = '';
$sno = 0;
$labrate ='';
$res34labitemrate='';
$res33rate='';
$res33quantity='';

	include('convert_currency_to_words.php');

//$financialyear = $_SESSION["financialyear"];
	$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
	
	$query6 = "select * from master_company where locationcode='$locationcode' and auto_number = '$companyanum'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res6 = mysqli_fetch_array($exec6);
	$res6companycode = $res6["companycode"];
	
	$query7 = "select * from master_settings where locationcode='$locationcode' and companycode = '$res6companycode' and modulename = 'SETTINGS' and 
	settingsname = 'CURRENT_FINANCIAL_YEAR'";
	$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res7 = mysqli_fetch_array($exec7);
	$financialyear = $res7["settingsvalue"];
	$_SESSION["financialyear"] = $financialyear;
	//echo $_SESSION['financialyear'];


if (isset($_REQUEST["billnumber"])) { $billnumber = $_REQUEST["billnumber"]; } else { $billnumber = ""; }

$query1 = "select * from master_company where locationcode='$locationcode' and auto_number = '$companyanum'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1companyname = $res1['companyname'];
$res1address1 = $res1['address1'];
$res1area = $res1['area'];
$res1city = $res1['city'];
$res1state = $res1['state'];
$res1country = $res1['country'];
$res1pincode = $res1['pincode'];
$res1phonenumber1 = $res1['phonenumber1'];

$query28 = "select * from billing_externalpharmacy where locationcode='$locationcode' and billnumber = '$billnumber' ";
$exec28 = mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die ("Error in Query28".mysqli_error($GLOBALS["___mysqli_ston"]));
$res28 = mysqli_fetch_array($exec28);
$res28patientname = $res28['patientname'];
$res28patientcode = $res28['patientcode'];
$res28visitcode = $res28['patientvisitcode'];
$res28billnumber = $res28['billnumber'];
$res28transactiondate = $res28['billdate'];


$query2 = "select * from billing_external where locationcode='$locationcode' and billno = '$billnumber'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$res2patientname = $res2['patientname'];
$res2patientcode = $res2['patientcode'];
$res2visitcode = $res2['visitcode'];
$res2billnumber = $res2['billno'];
$res2transactionamount = $res2['totalamount'];
$res2billdate = $res2['billdate'];
$res2username = $res2['username'];
$res2username = strtoupper($res2username);


$query26 = "select * from billing_externalpharmacy where locationcode='$locationcode' and billnumber = '$billnumber' ";
$exec26 = mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die ("Error in Query26".mysqli_error($GLOBALS["___mysqli_ston"]));
$res26 = mysqli_fetch_array($exec26);
$res26patientname = $res26['patientname'];
$res26patientcode = $res26['patientcode'];
$res26visitcode = $res26['patientvisitcode'];
$res26billnumber = $res26['billnumber'];
$res26quantity = $res26['quantity'];
$res26rate = $res26['rate'];
$res26transactionamount = $res26['amount'];
$res26transactiondate = $res26['billdate'];
$res26username = $res26['username'];
$res2username = strtoupper($res2username);

    $query11 = "select * from master_transactionexternal where locationcode='$locationcode' and billnumber = '$billnumber' ";
	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	mysqli_num_rows($exec11);
	$res11 = mysqli_fetch_array($exec11);
	$res11patientfirstname = $res11['patientname'];
	$res11patientcode = $res11['patientcode'];
	$res11visitcode = $res11['visitcode'];
	$res11billnumber = $res11['billnumber'];
	//$res11consultationfees = $res11['tr'];
	//$res11subtotalamount = $res11['subtotalamount'];
	$res11billingdatetime = $res11['transactiondate'];
	$res11patientpaymentmode = $res11['transactionmode'];
    $res11transactiontime = $res11['transactiontime'];
	$res11username = $res11['username'];
	$res11cashamount = $res11['cashamount'];
    $res11transactionamount = $res11['transactionamount'];
	$convertedwords = covert_currency_to_words($res11transactionamount);
	$res11chequeamount = $res11['chequeamount'];
	$res11cardamount = $res11['cardamount'];
	$res11onlineamount= $res11['onlineamount'];
	$res11creditamount= $res11['creditamount'];
	$res11updatetime= $res11['transactiontime'];
	$res11cashgivenbycustomer = $res11['cashgivenbycustomer'];
	$res11cashgiventocustomer = $res11['cashgiventocustomer'];
?>

<style type="text/css">
.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000; 
}
.bodytext33 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000;
}
.bodytext34 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000;
}
.bodytext35 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000;
}
.bodytext36 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000;
}
.bodytext37 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000;
}
.bodytext38 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000;
}
.bodytext39 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000;
}
.bodytext40 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000;
}
.bodytext41 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000;
}
.bodytext42 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000;
}
.bodytext43 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000;
}
.bodytext44 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000;
}
</style>
			 
<script language="javascript">
window.onload = function() {
    if(!window.location.hash) {
        window.location = window.location + '#externalbill';
        window.location.reload();
    }
}
</script>

<script language="javascript">

function escapekeypressed()
{
	//alert(event.keyCode);
	if(event.keyCode=='27'){ window.close(); }
}
</script>

<body onkeydown="escapekeypressed()">
<table width="538" border="0" cellpadding="0" cellspacing="0" align="center">
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
$emailid1 = $res2["emailid1"];
$phonenumber1 = $res2["phonenumber1"];
$phonenumber2 = $res2["phonenumber2"];
$tinnumber1 = $res2["tinnumber"];
$cstnumber1 = $res2["cstnumber"];
?>
    <td width="107" rowspan="4"><?php
			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec3showlogo = mysqli_query($GLOBALS["___mysqli_ston"], $query3showlogo) or die ("Error in Query3showlogo".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3showlogo = mysqli_fetch_array($exec3showlogo);
			$showlogo = $res3showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{
			?>
<!--        <img src="logofiles/<?php echo $companyanum;?>.jpg" width="91" height="80" />
-->        <?php
			}
			?></td>
    <td colspan="2" align="left" class="bodytext33"><?php
			$strlen2 = strlen($companyname);
			$totalcharacterlength2 = 35;
			$totalblankspace2 = 35 - $strlen2;
			$splitblankspace2 = $totalblankspace2 / 2;
			for($i=1;$i<=$splitblankspace2;$i++)
			{
			$companyname = ' '.$companyname.' ';
			}
			?>
        <strong><?php echo $companyname; ?></strong></td>
  </tr>
  <!--<tr>
			<td align="left" class="bodytext32">
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
			<strong><?php echo $address1; ?></strong></td>
		</tr>
		<tr>
		  <td align="left" class="bodytext32">
            <?php
			$address2 = $area.''.$city.'  '.$pincode.'';
			$strlen3 = strlen($address2);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address2 = ' '.$address2.' ';
			}
			?>
			<strong><?php echo $address2; ?></strong></td>
  </tr>-->
  <tr>
    <td width="307" align="center" class="bodytext34"><?php
			$address3 = "PHONE: ".$phonenumber1;
			$strlen3 = strlen($address3);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address3 = ' '.$address3.' ';
			}
			?>
        <strong><?php echo $address3; ?></strong></td>
    <td width="124" align="left" class="bodytext32">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" class="bodytext35"><?php
			$address4 = " E-Mail: ".$emailid1;
			$strlen3 = strlen($address4);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address4 = ' '.$address4.' ';
			}
			?>
        <strong><?php echo $address4; ?></strong></td>
  </tr>
</table>
<table width="514" border="0" cellpadding="0" cellspacing="0" align="center" style="margin-left:-13px;">
  
  <tr>
    <td colspan="5" align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext36"><strong>Bill No: <?php echo $res2billnumber; ?></strong></td>
    <td colspan="3" align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext36"><strong>Bill Date: <?php echo date("d/m/Y", strtotime($res2billdate)); ?></strong></td>
    <td align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext36">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext37"><strong><?php echo $res2patientname; ?></strong></td>
  </tr>
  <tr>
    <td colspan="5" align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
  </tr>
  <tr>
    
    <td width="290" align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext38"><strong>Description</strong></td>
    <td align="center" valign="center" 
		bgcolor="#ffffff" class="bodytext38"><strong>Qty </strong></td>
    <td align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext38"><strong>Rate</strong></td>
    <td align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext38"><strong>Amount</strong></td>
  </tr>
  <?php 
$query33 = "select * from billing_externalpharmacy where locationcode='$locationcode' and billnumber = '$billnumber' ";
$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res33 = mysqli_fetch_array($exec33))
 {
$res33medicinename =$res33['medicinename'];
$res33quantity=$res33['quantity'];
$res33rate=$res33['rate'];
$res33amount=$res33['amount'];
$totallab=$totallab+$res33amount;

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
  <tr>
   
    <td align="left" valign="center" bgcolor="#ffffff" class="bodytext39" width="290"><?php echo $res33medicinename; ?></td>
    <td class="bodytext39" valign="center"  align="center"><?php echo $res33quantity; ?></td>
    <td class="bodytext39" valign="center"  align="right"><?php echo $res33rate; ?></td>
    <td  align="right" valign="center" bgcolor="#ffffff" class="bodytext39"><?php echo $res33amount; ?></td>
  </tr>
  <?php
		 }
		 ?>
  <?php 
$query134 = "select * from billing_externallab where locationcode='$locationcode' and billnumber = '$billnumber' ";
$exec134 = mysqli_query($GLOBALS["___mysqli_ston"], $query134) or die ("Error in Query134".mysqli_error($GLOBALS["___mysqli_ston"]));
$count134 = mysqli_num_rows($exec134);

while($res134 = mysqli_fetch_array($exec134))
 {
$count = mysqli_num_rows($exec134);
$res134labitemname =$res134['labitemname'];
$res134labitemrate=$res134['labitemrate'];
$totallab=$totallab+$res134labitemrate;

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
  <tr>
   
    <td  align="left" valign="center" bgcolor="#ffffff" class="bodytext39" width="290"><?php echo $res134labitemname; ?></td>
    <td  align="center" valign="center" bgcolor="#ffffff" class="bodytext39">1</td>
    <td  align="right" valign="center" bgcolor="#ffffff" class="bodytext39"><?php echo $res134labitemrate; ?></td>
    <td  align="right" valign="center" bgcolor="#ffffff" class="bodytext39"><?php echo $res134labitemrate; ?></td>
  </tr>
  <?php
		  }
		 ?>
  <?php 
$query135 = "select * from billing_externalradiology where locationcode='$locationcode' and billnumber = '$billnumber' ";
$exec135 = mysqli_query($GLOBALS["___mysqli_ston"], $query135) or die ("Error in Query135".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res135 = mysqli_fetch_array($exec135))
 {
$count = mysqli_num_rows($exec135);
   if($count>0)
     {
$res135radiologyitemname =$res135['radiologyitemname'];
$res135radiologyitemrate=$res135['radiologyitemrate'];
$totallab=$totallab+$res135radiologyitemrate;

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
  <tr>
   
    <td  align="left" valign="center" bgcolor="#ffffff" class="bodytext39" width="290"><?php echo $res135radiologyitemname; ?></td>
    <td  align="center" valign="center" bgcolor="#ffffff" class="bodytext39">1</td>
    <td  align="right" valign="center" bgcolor="#ffffff" class="bodytext39"><?php echo $res135radiologyitemrate; ?></td>
    <td  align="right" valign="center" bgcolor="#ffffff" class="bodytext39"><?php echo $res135radiologyitemrate; ?></td>
  </tr>
  <?php
     }
}
?>
  <?php 
$query136 = "select * from billing_externalservices where locationcode='$locationcode' and billnumber = '$billnumber' ";
$exec136 = mysqli_query($GLOBALS["___mysqli_ston"], $query136) or die ("Error in Query136".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res136 = mysqli_fetch_array($exec136))
 {
$count = mysqli_num_rows($exec136);
   if($count>0)
     {
$res136labitemname =$res136['servicesitemname'];
$res136labitemrate=$res136['servicesitemrate'];
$totallab=$totallab+$res136labitemrate;

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
  <tr>
   
    <td  align="left" valign="center" bgcolor="#ffffff" class="bodytext39" width="290"><?php echo $res136labitemname; ?></td>
    <td  align="center" valign="center" bgcolor="#ffffff" class="bodytext39">1</td>
    <td  align="right" valign="center" bgcolor="#ffffff" class="bodytext39"><?php echo $res136labitemrate; ?></td>
    <td  align="right" valign="center" bgcolor="#ffffff" class="bodytext39"><?php echo $res136labitemrate; ?></td>
  </tr>
  <?php
     }
}
?>
  <tr>
   
	 <td>&nbsp;</td>
	  <td>&nbsp;</td>
	   <td>&nbsp;</td>
	    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
    <td  align="left" valign="center" nowrap class="bodytext31">&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" nowrap="nowrap"><span class="bodytext40"><strong><?php echo 'Net Total'; ?></strong></span></td>
    <td class="bodytext40" valign="center"  align="right"><strong><?php echo number_format($totallab,2,'.',''); ?></strong></td>
    <td class="bodytext40" valign="center"  align="right">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5"  align="left" valign="center" class="bodytext31"><table width="519" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="7">&nbsp;</td>
      </tr>
     <?php if($res11cashgivenbycustomer != 0.00 || $res11cashamount != 0.00) { ?> 	
	 <?php if($res11cashgivenbycustomer != 0.00) { ?>
	<tr>
		<td class="bodytext32"><strong>Cash Received:</strong></td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right" class="bodytext32"><strong><?php echo number_format($res11cashgivenbycustomer,2,'.',','); ?></strong></td>
	</tr>
	<?php } else if($res11cashamount != '0.00') { ?>
	<tr>
		<td class="bodytext32"><strong>Cash Received:</strong></td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right" class="bodytext32"><strong><?php echo number_format($res11cashamount,2,'.',','); ?></strong></td>
	</tr>
	<?php } ?>
	<tr>
		<td width="203" class="bodytext32"><strong>CashReturned:</strong></td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right" class="bodytext32"><strong><?php echo number_format($res11cashgiventocustomer,2,'.',','); ?></strong></td>
	</tr>
	<?php } ?>
	
	<?php if($res11chequeamount != 0.00) { ?> 
	<tr>
		<td width="203" class="bodytext32"><strong>Cheque Amount</strong></td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right" class="bodytext32"><strong><?php echo number_format($res11chequeamount,2,'.',','); ?></strong></td>
	</tr>
	<?php } ?>
	<?php if($res11onlineamount != 0.00) { ?> 
	<tr>
		<td width="203" class="bodytext32"><strong>Online Amount</strong></td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right" class="bodytext32"><strong><?php echo number_format($res11onlineamount,2,'.',','); ?></strong></td>
	</tr>
	<?php } ?>
	<?php if($res11cardamount != 0.00) { ?> 
	<tr>
		<td width="203" class="bodytext32"><strong>Card Amount</strong></td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right" class="bodytext32"><strong><?php echo number_format($res11cardamount,2,'.',','); ?></strong></td>
	</tr>
	<?php } ?>
	
    <?php if($res11creditamount != 0.00) { ?> 
	<tr>
		<td width="203" class="bodytext32"><strong>Mobile Money:</strong></td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right" class="bodytext32"><strong><?php echo number_format($res11creditamount,2,'.',','); ?></strong></td>
	</tr>
	<?php } ?>		   
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" class="bodytext42"><strong><?php echo $convertedwords; ?></strong></td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="right" class="bodytext43"><strong>Served By: <?php echo strtoupper($res11username); ?></strong> </td>
      </tr>
      <tr>
        <td colspan="4" align="right" class="bodytext44"><strong><?php echo strtoupper($res11transactiontime); ?></strong> </td>
      </tr>
    </table></td>
  </tr>
  
  
  <!--<tr>
     <td align="right" colspan="2">Cheque Amount:</td>
    <td width="125" align="right"><?php echo number_format($res11chequeamount,2,'.',','); ?></td>
  </tr>
  
   <tr>
     <td align="right" colspan="2">MPESA Amount:</td>
    <td width="125" align="right"><?php echo number_format($res11creditamount,2,'.',','); ?></td>
  </tr>
  <tr>
    <td align="right" colspan="2">Card Amount:</td>
    <td width="125" align="right"><?php echo number_format($res11cardamount,2,'.',','); ?></td>
  </tr>
  <tr>
    <td align="right" colspan="2">Online Amount:</td>
    <td width="125" align="right"><?php echo number_format($res11onlineamount,2,'.',','); ?></td>
  </tr>-->
</table>

<?php

    $content = ob_get_clean();

    // convert in PDF
    try
    {
        $html2pdf = new HTML2PDF('P', 'A5', 'en');
//      $html2pdf->setModeDebug();
        //$html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('printexternalbill.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    } 
?>
