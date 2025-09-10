<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');

$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$total = '0.00';
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$sno = "";
$colorloopcount1="";
$grandtotal = '';
$grandtotal1 = "0.00";
//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_account2.php");

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];
$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
//$locationcode=$anum;


 $query31 = "select * from shift_tracking where auto_number='$anum'";
$exe31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
$res31 = mysqli_fetch_array($exe31);
$starttime = $res31['shiftstarttime'];
$outtime = $res31['shiftouttime'];
$username = $res31['username'];
$physical_cash = $res31['physical_cash'];

$query40 = "select locationcode from master_employeelocation where username='$username' group by locationcode";
$exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res40 = mysqli_fetch_array($exec40);
$locationcode = $res40['locationcode'];
$query32 = "select * from master_employee where  username='$username'";
$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res32 = mysqli_fetch_array($exec32);
$employeename = $res32['employeename'];
$location=$res32['locationcode'];
?>
<table width="500" border="0" cellspacing="0" cellpadding="0" align="center">
  
           <tr>
             <td colspan="9">&nbsp;</td>
           </tr>
           <tr>
<?php 
$query2 = "select * from master_company where locationcode='$locationcode' and auto_number = '$companyanum'";
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
			<td colspan="9">
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
			<td colspan="9"><div align="center"><?php echo $companyname; ?>
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
			<td colspan="9"><div align="center"><?php echo $address1; ?>
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
			<td colspan="9">
			
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
          <td colspan="9" align="center" valign="center" class="bodytext31">&nbsp;</td>
        </tr>
  <tr>
    <td colspan="9" align="center" valign="center" class="bodytext31"><strong><strong><?php echo $employeename; ?>
   </strong></strong></td>
  </tr>
  <tr>
    <td colspan="9" align="center" valign="center" class="bodytext31"><strong> Shift Report between <?php echo $starttime; ?> and <?php echo $outtime; ?> for Shift ID: <?php echo $anum; ?></strong></td>
  </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="9" align="center" valign="center" class="bodytext31"><strong>Voucher Transactions </strong></td>
  </tr>
  <?php
		
			
		  $query48 = "select * from paymentmodecredit where locationcode='$locationcode' and billdatetime between '$starttime' and '$outtime' and billnumber not like 'SP-%' order by auto_number desc";
		  $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num48 = mysqli_num_rows($exec48);
		  
	      $query49 = "select * from paymentmodedebit where locationcode='$locationcode' and billdatetime between '$starttime' and '$outtime' order by auto_number desc";
		  $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num49 = mysqli_num_rows($exec49);
	
		
		  
		  if($num48 > $num49)
		  {
		  $rowspancount = $num48;
		  }
		  else
		  {
		  $rowspancount = $num49;
		  }
		  $rowspancount;
		 
		  ?>
  <tr>
    <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
    <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
    <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
    <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
    <td align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
				<td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
    <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
    <td align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
				<td align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
  </tr>
  <tr>
    <td width="35"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
    <td width="80" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Date</strong></td>
    <td width="65" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Bill </strong></td>
    <td width="270" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Description </strong></td>
    <td width="77" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Cash</strong></td>
				<td width="77" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Card</strong></td>
				<td width="77" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Cheque</strong></td>
				<td width="77" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Moblie Money</strong></td>
				<td width="77" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Online</strong></td>
  </tr>
  <?php
			$totalcashamount1 = 0;
			$totalcardamount1 = 0;
			$totalchequeamount1 = 0;
			$totalmpesaamount1 = 0;
			$totalonlineamount1 = 0;
			
			
		  $query2 = "select * from paymentmodedebit where billdatetime between '$starttime' and '$outtime' and username = '$username' order by auto_number desc";
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
     	  $res2transactiondate = $res2['billdate'];
		  $res2billnumber = $res2['billnumber'];
		  $patientcode = $res2['patientcode'];
		  $patientname = $res2['patientname'];
		  $patientvisitcode = $res2['patientvisitcode'];
		  $source = $res2['source'];
		  if($source == 'advancedeposit')
		  {
		  $patientvisitcode = $patientcode;
		  }
		  if($patientvisitcode == 'walkinvis')
		  {
		  $patientvisitcode = 'External';
		  }

		   if($source == 'receiptentry')
		   {
		   $query51= "select * from receiptsub_details where docnumber='$res2billnumber'";
		   $exec51=mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res51=mysqli_fetch_array($exec51);
		   $receiptcoa = $res51['receiptcoa'];
		   
		    $query511= "select * from master_accountname where id='$receiptcoa'";
		   $exec511=mysqli_query($GLOBALS["___mysqli_ston"], $query511) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res511=mysqli_fetch_array($exec511);
		   $receiptname = $res511['accountname'];
		   
		   $patientname=$receiptname;
		   $patientvisitcode='Receipt';
		   }
		   if($source == 'accountreceivable'){
		   	 $patientname = $res2['accountname'];
			   $patientvisitcode='Account Receivable';
		   }

		  $cashamount2 = $res2['cash'];
		  $cashcoa =  $res2['cashcoa'];
		  $cardamount2 = $res2['card'];
		  $cardcoa =  $res2['cardcoa'];
		  $chequeamount2 = $res2['cheque'];
		  $chequecoa =  $res2['chequecoa'];
		  $onlineamount2 = $res2['online'];
		  $onlinecoa =  $res2['onlinecoa'];
		  $mpesaamount2 = $res2['mpesa'];
		  $mpesacoa =  $res2['mpesacoa'];
		  $query21 = "select * from master_accountname where locationcode='$locationcode' and id='$cashcoa' or id='$cardcoa' or id='$chequecoa' or id='$onlinecoa' or id='$mpesacoa'";
		  $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
		  $res21 = mysqli_fetch_array($exec21);
		  $accountssub = $res21['accountssub'];
		  
		  $query212 = "select * from master_accountssub where locationcode='$locationcode' and auto_number='$accountssub'";
		  $exec212 = mysqli_query($GLOBALS["___mysqli_ston"], $query212) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res212 = mysqli_fetch_array($exec212);
		  $accountssubname = $res212['accountssub'];
		  
		   $totalamount3 = $cashamount2 + $cardamount2 + $chequeamount2 + $onlineamount2 + $mpesaamount2;
		
		  $snocount = $snocount + 1;
		  
		  $totalcashamount1 = $totalcashamount1 + $cashamount2;
		  $totalcardamount1 = $totalcardamount1 + $cardamount2;
		  $totalchequeamount1 = $totalchequeamount1 + $chequeamount2;
		  $totalmpesaamount1 = $totalmpesaamount1 + $mpesaamount2;
		  $totalonlineamount1 = $totalonlineamount1 + $onlineamount2;
				
			//echo $cashamount;
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
			$grandtotal = $grandtotal + $totalamount3;
	
			?>
  <tr>
    <td class="bodytext31" valign="center"  align="left"><?php echo $snocount;  ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $res2transactiondate; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $res2billnumber; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $patientname; ?>(<?php echo $patientvisitcode; ?>)</td>
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($cashamount2,2,'.',','); ?></td>
	<td class="bodytext31" valign="center"  align="right"><?php echo number_format($cardamount2,2,'.',','); ?></td>
	<td class="bodytext31" valign="center"  align="right"><?php echo number_format($chequeamount2,2,'.',','); ?></td>
	<td class="bodytext31" valign="center"  align="right"><?php echo number_format($mpesaamount2,2,'.',','); ?></td>
	<td class="bodytext31" valign="center"  align="right"><?php echo number_format($onlineamount2,2,'.',','); ?></td>
  </tr>
  <?php
			}
			$grandtotal = $grandtotal + $openingbalance
			?>
  <tr>
    <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
	<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
	<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
  </tr>
  <tr>
    <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right"><strong>Total</strong></td>
    <td class="bodytext31" valign="center"  align="right"> <strong><?php echo number_format($totalcashamount1,2,'.',','); ?></strong></td>
	<td class="bodytext31" valign="center"  align="right"> <strong><?php echo number_format($totalcardamount1,2,'.',','); ?></strong></td>
	<td class="bodytext31" valign="center"  align="right"> <strong><?php echo number_format($totalchequeamount1,2,'.',','); ?></strong></td>
	<td class="bodytext31" valign="center"  align="right"> <strong><?php echo number_format($totalmpesaamount1,2,'.',','); ?></strong></td>
	<td class="bodytext31" valign="center"  align="right"> <strong><?php echo number_format($totalonlineamount1,2,'.',','); ?></strong></td>
  </tr>
	
	 <tr>
	   <td colspan="9"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
  </tr>
	 <tr>
	   <td colspan="9"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Refund Voucher Transactions</strong></td>
  </tr>
	 <tr>
	   <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
	   <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
	   <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
	   <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
	   <td align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
				<td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
	   <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
	   <td align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
				<td align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
  </tr>
	 <tr>
    <td width="35"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
    <td width="62" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Date</strong></td>
    <td width="56" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Bill </strong></td>
    <td width="270" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Description </strong></td>
    <td width="77" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Cash</strong></td>
				<td width="77" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Card</strong></td>
				<td width="77" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Cheque</strong></td>
				<td width="77" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Mobile Money</strong></td>
				<td width="77" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Online</strong></td>
  </tr>
				<?php
			$colorcode1 = '';
			$totalcashamount = 0;
			$totalcardamount = 0;
			$totalchequeamount = 0;
			$totalmpesaamount = 0;
			$totalonlineamount = 0;
			
		  $query28 = "select * from paymentmodecredit where billdatetime between '$starttime' and '$outtime' and username = '$username'  and billnumber not like 'SP-%' order by auto_number desc";
		  $exec28 = mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res28= mysqli_fetch_array($exec28))
		  {
     	  $res2transactiondate8 = $res28['billdate'];
		  $res2billnumber8 = $res28['billnumber'];
		  $res2accountname = $res28['accountname'];
		  $patientcode = $res28['patientcode'];
		  $patientname = $res28['patientname'];
		  $patientvisitcode = $res28['patientvisitcode'];
		  
		  $cashamount28 = $res28['cash']; 
		  $cardamount28 = $res28['card'];
		  $chequeamount28 = $res28['cheque'];
		  $onlineamount28 = $res28['online'];
		  $mpesaamount28 = $res28['mpesa'];
		  $cashcoa =  $res28['cashcoa'];
		  $cardcoa =  $res28['cardcoa'];
		  $chequecoa =  $res28['chequecoa'];
		  $onlinecoa =  $res28['onlinecoa'];
		  $mpesacoa =  $res28['mpesacoa'];
		  if($res2accountname == '')
		  {
		  $query213 = "select * from master_accountname where locationcode='$locationcode' and id='$cashcoa' or id='$cardcoa' or id='$chequecoa' or id='$onlinecoa' or id='$mpesacoa'";
		  $exec213 = mysqli_query($GLOBALS["___mysqli_ston"], $query213) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res213 = mysqli_fetch_array($exec213);
		  $accountssub = $res213['accountssub'];
		  
		  $query214 = "select * from master_accountssub where locationcode='$locationcode' and auto_number='$accountssub'";
		  $exec214 = mysqli_query($GLOBALS["___mysqli_ston"], $query214) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res214 = mysqli_fetch_array($exec214);
		  $accountssubname = $res214['accountssub'];
		  $res2accountname = $accountssubname;
		  }
		   $totalamount38 = $cashamount28 + $cardamount28 + $chequeamount28 + $onlineamount28 + $mpesaamount28;
		  $sno = $sno + 1;
		  $totalcashamount = $totalcashamount + $cashamount28;
		  $totalcardamount = $totalcardamount + $cardamount28;
		  $totalchequeamount = $totalchequeamount + $chequeamount28;
		  $totalmpesaamount = $totalmpesaamount + $mpesaamount28;
		  $totalonlineamount = $totalonlineamount + $onlineamount28;
		  
		  $colorloopcount1 = $colorloopcount1 + 1;
			$showcolor1 = ($colorloopcount1 & 1); 
			if ($showcolor1 == 0)
			{
				//echo "if";
				$colorcode1 = 'bgcolor="#ecf0f5"';
			}
			else
			{
				//echo "else";
				$colorcode1 = 'bgcolor="#CBDBFA"';
			}
			$grandtotal1 = $grandtotal1 + $totalamount38;
		  ?>
		  <tr>
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno; ?></td>
               <td class="bodytext31" valign="center"  align="left">
             <?php echo $res2transactiondate8; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res2billnumber8; ?></td>
				  <td class="bodytext31" valign="center"  align="left"><?php echo $patientname; ?>(<?php echo $patientvisitcode; ?>)</td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($cashamount28,2,'.',','); ?></td>
			  <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($cardamount28,2,'.',','); ?></td>
			   <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($chequeamount28,2,'.',','); ?></td>
			   <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($mpesaamount28,2,'.',','); ?></td>
			  <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($onlineamount28,2,'.',','); ?></td>
           </tr>
		   <?php
			}
			
			?>
		   <tr>
		     <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
		     <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
		     <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
		     <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
		     <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
			 <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
		     <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
		     <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
			 <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
  </tr>
	    <tr>
			<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="right"><strong>Total</strong></td>
			<td class="bodytext31" valign="center"  align="right"> <strong><?php echo number_format($totalcashamount,2,'.',','); ?></strong></td>
			 <td class="bodytext31" valign="center"  align="right"> <strong><?php echo number_format($totalcardamount,2,'.',','); ?></strong></td>
			 <td class="bodytext31" valign="center"  align="right"> <strong><?php echo number_format($totalchequeamount,2,'.',','); ?></strong></td>
			 <td class="bodytext31" valign="center"  align="right"> <strong><?php echo number_format($totalmpesaamount,2,'.',','); ?></strong></td>
			 <td class="bodytext31" valign="center"  align="right"> <strong><?php echo number_format($totalonlineamount,2,'.',','); ?></strong></td>
		</tr>

  <?php
	 $grandtot = $grandtotal - $grandtotal1;
	  $grandcash = $totalcashamount1 - $totalcashamount;
	  $grandcard = $totalcardamount1 - $totalcardamount;
	  $grandcheque = $totalchequeamount1 - $totalchequeamount;
	  $grandmpesa = $totalmpesaamount1 - $totalmpesaamount;
	  $grandonline = $totalonlineamount1 - $totalonlineamount;
	  ?>
	  
	  <tr>
			<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
		<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
		<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
		<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
		<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
  </tr>
	   <tr>
	     <td colspan="3" class="bodytext31" valign="center"  align="right">&nbsp;</td>
	     <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
	     <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
	     <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
		 <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
		<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
		<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
  </tr>
	   <tr>
	     <td colspan="3" class="bodytext31" valign="center"  align="right">Total Cash In Hand: </td>
	     <td class="bodytext31" valign="center"  align="right"><?php echo number_format($grandcash,2,'.',','); ?></td>
	     <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
	     <td colspan="3" class="bodytext31" valign="center"  align="right">&nbsp;</td>
		 <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
  </tr>
	   <tr>
	     <td colspan="3" class="bodytext31" valign="center"  align="right">Total Card:</td>
	     <td class="bodytext31" valign="center"  align="right"><?php echo number_format($grandcard,2,'.',','); ?></td>
	     <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
	     <td colspan="3" class="bodytext31" valign="center"  align="right">&nbsp;</td>
		 <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
  </tr>
	   <tr>
	     <td colspan="3" class="bodytext31" valign="center"  align="right">Total Cheque:</td>
	     <td class="bodytext31" valign="center"  align="right"><?php echo number_format($grandcheque,2,'.',','); ?></td>
	     <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
	     <td colspan="3" class="bodytext31" valign="center"  align="right">&nbsp;</td>
		 <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
  </tr>
	   <tr>
	     <td colspan="3" class="bodytext31" valign="center"  align="right">Total Mpesa:</td>
	     <td class="bodytext31" valign="center"  align="right"><?php echo number_format($grandmpesa,2,'.',','); ?></td>
	     <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
	     <td colspan="3" class="bodytext31" valign="center"  align="right">&nbsp;</td>
		 <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
  </tr>
  		<tr>
	     <td colspan="3" class="bodytext31" valign="center"  align="right">Total Online:</td>
	     <td class="bodytext31" valign="center"  align="right"><?php echo number_format($grandonline,2,'.',','); ?></td>
	     <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
	     <td colspan="3" class="bodytext31" valign="center"  align="right">&nbsp;</td>
		 <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
  </tr>
	   <tr>
	     <td colspan="3" class="bodytext31" valign="center"  align="right">Grand Total:</td>
	     <td class="bodytext31" valign="center"  align="right"><strong><?php echo number_format($grandtot,2,'.',','); ?></strong></td>
	     <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
	     <td colspan="3" class="bodytext31" valign="center"  align="right">&nbsp;</td>
		 <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
  </tr>
  <tr>
	     <td colspan="3" class="bodytext31" valign="center"  align="right">Cash Submitted:</td>
	     <td class="bodytext31" valign="center"  align="right"><strong><?php echo number_format($physical_cash,2,'.',','); ?></strong></td>
	     <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
	     <td colspan="3" class="bodytext31" valign="center"  align="right">&nbsp;</td>
		 <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
  </tr>

<tr>
	     <td colspan="3" class="bodytext31" valign="center"  align="right">Cash Variation:</td>
	     <td class="bodytext31" valign="center"  align="right"><strong><?php echo number_format($grandcash-$physical_cash,2,'.',','); ?></strong></td>
	     <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
	     <td colspan="3" class="bodytext31" valign="center"  align="right">&nbsp;</td>
		 <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
  </tr>

</table>
<?php

    $content = ob_get_clean();

    // convert in PDF
    require_once('html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('L', 'A4', 'en');
//      $html2pdf->setModeDebug();
        //$html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('shiftwisereport.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
