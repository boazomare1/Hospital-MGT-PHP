<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
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
include ("autocompletebuild_account2.php");

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

 if (isset($_REQUEST["st"])) { $starttime = $_REQUEST["st"]; } else { $starttime = ""; }
 if (isset($_REQUEST["ed"])) { $outtime = $_REQUEST["ed"]; } else { $outtime = ""; }
 
 if($locationcode=='All')
{
$pass_location = "locationcode !=''";
}
else
{
$pass_location = "locationcode ='$locationcode'";
}	
 
 $query31 = "select st.shiftstarttime,st.shiftouttime,st.username,st.physical_cash from shift_tracking as st LEFT JOIN master_employeelocation as mel ON st.username = mel.username where mel.$pass_location and st.auto_number='$anum'";
$exe31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
$res31 = mysqli_fetch_array($exe31);
if($starttime=='')
  $starttime = $res31['shiftstarttime'];
if($outtime=='')
  $outtime = $res31['shiftouttime'];

$user = $res31['username'];

$physical_cash = $res31['physical_cash'];


 $query32 = "select * from master_employee where locationcode='$locationcode' and username='$user'";
$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res32 = mysqli_fetch_array($exec32);
$employeename = $res32['employeename'];

?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
}
.bali
{
text-align:right;
}
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="3">
		
		
              <form name="cbform1" method="post" action="cashflowstatement.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            
            <!--<tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 
                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 
				</td>
              </tr>-->
          </tbody>
        </table>
		</form>		</td>
      </tr>
	  <tr>
        <td align="center" valign="center" class="bodytext31">&nbsp;</td>
		<td align="center" valign="center" class="bodytext31">&nbsp;</td>
		<td align="left" valign="center" class="bodytext31"><ins><strong><?php echo $employeename; ?> </strong></ins></td>
      </tr>
      <tr>
        <td align="center" valign="center" class="bodytext31">&nbsp;</td>
		<td align="center" valign="center" class="bodytext31">&nbsp;</td>
		<td align="left" valign="center" class="bodytext31"><ins><strong> Shift Report between <?php echo $starttime; ?> and <?php echo $outtime; ?> for Shift ID: <?php echo $anum; ?></strong></ins></td>
      </tr>
	  <tr>
	  <td>&nbsp;</td>
	  </tr>
       <tr>
        <td colspan="3"><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" 
            align="left" border="0">
          <tbody>
		  <tr>
		  <td colspan ="9" align="center" valign="center" class="bodytext31"><strong>Voucher Transactions</strong></td>
		  <td colspan ="9" align="center" valign="center" class="bodytext31"><strong>Refund Voucher Transactions</strong></td>
		   <td width="1" align="center" valign="center" class="bodytext31">&nbsp;</td>
		   <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right"> 
                 <a target="_blank" href="printshiftwisereport.php?anum=<?php echo $anum; ?>&&locationcode=<?php echo $locationcode; ?>"> <img src="images/pdfdownload.jpg" width="30" height="30"></a>           </td>	
		  </tr>
            		<?php
		
			
		  $query48 = "select * from paymentmodecredit where locationcode='$locationcode' and billdatetime between '$starttime' and '$outtime' order by auto_number desc";
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
              <td width="37"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
              <td width="76" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
				  <td width="82" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bill </strong></div></td>
              <td width="220" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Description </strong></td>
              <td width="102" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Cash</strong></td>
				<td width="47" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Card</strong></td>
		 <td width="51" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Cheque</strong></td>
		 <td width="47" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Mpesa</strong></td>
				<td width="47" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Online</strong></td>
		
				<td colspan="2" rowspan="1000"  align="left" valign="top" bgcolor="#ecf0f5" >
			
				  <table width="649" id="AutoNumber3" style="BORDER-COLLAPSE: collapse; margin-top:-3px;" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" 
            align="left" border="0">
				  <tr>
				  <td width="51"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
              <td width="66" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
				 <td width="64" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bill </strong></div></td>
              <td width="193" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Description </strong></td>
            <td width="54" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Cash</strong></td>
				<td width="55" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Card</strong></td>
		 <td width="55" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Cheque</strong></td>
		 <td width="47" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Mpesa</strong></td>
				<td width="47" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Online</strong></td>		
				  </tr>
				<?php
			$colorcode1 = '';
			$totalcashamount = 0;
			$totalcardamount = 0;
			$totalchequeamount = 0;
			$totalmpesaamount = 0; 
			$totalonlineamount = 0; 
		   $query281 = "select * from paymentmodecredit where billdatetime between '$starttime' and '$outtime' and username = '$user' group by billnumber order by auto_number desc";
		  $exec281 = mysqli_query($GLOBALS["___mysqli_ston"], $query281) or die ("Error in Query281".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res281= mysqli_fetch_array($exec281))
		  {
			  $res2billnumber81= $res281['billnumber'];
			  $patientcode1 = $res281['patientcode'];
			  $patientvisitcode = $res281['patientvisitcode'];
			  $source = $res281['source'];
		  if($source =='paynowrefund' || $source =='consultationrefund')
		  {
			  $res2billnumber8= $res281['billnumber'];
			  $patientcode = $res281['patientcode'];
			  $res2transactiondate8 = $res281['billdate'];
			  $res2accountname = $res281['accountname'];
			  $patientname = $res281['patientname'];
			  $patientvisitcode = $res281['patientvisitcode'];
			  
			  $cashamount28 = $res281['cash']; 
			  $cardamount28 = $res281['card'];
			  $chequeamount28 = $res281['cheque'];
			  $onlineamount28 = $res281['online'];
			  $mpesaamount28 = $res281['mpesa'];


		  }else{
		  $detailedqry="select * from deposit_refund where docno='$res2billnumber81' and patientcode='$patientcode1'";
		  $exeqry=mysqli_query($GLOBALS["___mysqli_ston"], $detailedqry);
		  $res28=mysqli_fetch_array($exeqry);
		  $res2billnumber8= $res28['docno'];
		  $patientcode = $res28['patientcode'];
     	  $res2transactiondate8 = $res28['recorddate'];
		  $res2accountname = $res28['accountname'];
		  $patientname = $res28['patientname'];
		  $patientvisitcode = $res28['visitcode'];
		  
		  $cashamount28 = $res28['cashamount']; 
		  $cardamount28 = $res28['cardamount'];
		  $chequeamount28 = $res28['chequeamount'];
		  $onlineamount28 = $res28['onlineamount'];
		  $mpesaamount28 = $res28['creditamount'];
		  }


		  if($cashamount28 <> 0 ||$cardamount28 <>0 ||$chequeamount28<>0 || $onlineamount28 <>0 || $mpesaamount28 <>0)
		  {
		  $query282 = "select cashcoa from paymentmodecredit where billnumber='$res2billnumber8' and cashcoa<>'' order by auto_number desc";
		  $exec282 = mysqli_query($GLOBALS["___mysqli_ston"], $query282) or die ("Error in Query282".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res282= mysqli_fetch_array($exec282);
		  $cashcoa =  $res282['cashcoa'];
		  if($cashcoa =='')
		  {
			$query282 = "select cardcoa from paymentmodecredit where billnumber='$res2billnumber8' and cardcoa<>'' order by auto_number desc";
		  $exec282 = mysqli_query($GLOBALS["___mysqli_ston"], $query282) or die ("Error in Query282".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res282= mysqli_fetch_array($exec282); 
		  $cardcoa =  $res282['cardcoa'];
		  }
		   if($cardcoa =='')
		  {
			  $query282 = "select chequecoa from paymentmodecredit where billnumber='$res2billnumber8' and chequecoa<>'' order by auto_number desc";
		  $exec282 = mysqli_query($GLOBALS["___mysqli_ston"], $query282) or die ("Error in Query282".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res282= mysqli_fetch_array($exec282); 
		  $chequecoa =  $res282['chequecoa'];
		  }
		  if($chequecoa =='')
		  {
			  $query282 = "select onlinecoa from paymentmodecredit where billnumber='$res2billnumber8' and onlinecoa<>'' order by auto_number desc";
		  $exec282 = mysqli_query($GLOBALS["___mysqli_ston"], $query282) or die ("Error in Query282".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res282= mysqli_fetch_array($exec282); 
		  $onlinecoa =  $res282['onlinecoa'];
		  }
		  if($onlinecoa =='')
		  {
			  $query282 = "select mpesacoa from paymentmodecredit where billnumber='$res2billnumber8' and mpesacoa<>'' order by auto_number desc";
		  $exec282 = mysqli_query($GLOBALS["___mysqli_ston"], $query282) or die ("Error in Query282".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res282= mysqli_fetch_array($exec282); 
		  $mpesacoa =  $res282['mpesacoa'];
		  }
		  
		 
		//  $source = $res28['source'];
		  
		  	   if($source == 'expenseentry')
		   {
		   $patientname=$res2accountname;
		   $patientvisitcode='Expense';
		   }
		  
		  if($res2accountname == '')
		  {
		  $query213 = "select accountssub from master_accountname where locationcode='$locationcode' and id='$cashcoa' or id='$cardcoa' or id='$chequecoa' or id='$onlinecoa' or id='$mpesacoa'";
		  $exec213 = mysqli_query($GLOBALS["___mysqli_ston"], $query213) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res213 = mysqli_fetch_array($exec213);
		  $accountssub = $res213['accountssub'];
		  
		  $query214 = "select accountssub from master_accountssub where locationcode='$locationcode' and auto_number='$accountssub'";
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
		  <tr <?php echo $colorcode1; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate8; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber8; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientname; ?>(<?php echo $patientvisitcode; ?>) </div></td>
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
		  }}
			
			?>
				  <tr>
			<!-- <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
			  <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
			   <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
-->			    <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
			 <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
			 <td class="bodytext31" valign="center"  align="right"><strong>Total</strong></td>
			 <td class="bodytext31" valign="center"  align="right"> <strong><?php echo number_format($totalcashamount,2,'.',','); ?></strong></td>
			 <td class="bodytext31" valign="center"  align="right"> <strong><?php echo number_format($totalcardamount,2,'.',','); ?></strong></td>
			 <td class="bodytext31" valign="center"  align="right"> <strong><?php echo number_format($totalchequeamount,2,'.',','); ?></strong></td>
			 <td class="bodytext31" valign="center"  align="right"> <strong><?php echo number_format($totalmpesaamount,2,'.',','); ?></strong></td>
			 <td class="bodytext31" valign="center"  align="right"> <strong><?php echo number_format($totalonlineamount,2,'.',','); ?></strong></td>
			</tr>
				  </table>				</td>
                </tr>
				
			
	
			
			<?php
			$totalcashamount1 = 0;
			$totalcardamount1 = 0;
			$totalchequeamount1 = 0;
			$totalmpesaamount1 = 0;
			$totalonlineamount1 = 0;
			
		  $query2 = "select * from paymentmodedebit where billdatetime between '$starttime' and '$outtime' and username = '$user' order by auto_number desc";
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
		   $source = $res2['source'];
		   
		   if($source == 'receiptentry')
		   {
		   $query51= "select * from receiptsub_details where locationcode='$locationcode' and docnumber='$res2billnumber'";
		   $exec51=mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res51=mysqli_fetch_array($exec51);
		   $receiptcoa = $res51['receiptcoa'];
		   
		    $query511= "select * from master_accountname where locationcode='$locationcode' and id='$receiptcoa'";
		   $exec511=mysqli_query($GLOBALS["___mysqli_ston"], $query511) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res511=mysqli_fetch_array($exec511);
		   $receiptname = $res511['accountname'];
		   
		   $patientname=$receiptname;
		   $patientvisitcode='Receipt';
		   }
		   else if($source == 'billingpaynow')
		   {
			   $query51= "select cashamount,onlineamount,creditamount,chequeamount,cardamount from master_transactionpaynow where locationcode='$locationcode' and billnumber='$res2billnumber'";
			   $exec51=mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			   $res51=mysqli_fetch_array($exec51);
			   $cashamount2 = $res51['cashamount'];
			   $onlineamount2 = $res51['onlineamount'];
			   $mpesaamount2 = $res51['creditamount'];
			   $chequeamount2 = $res51['chequeamount'];
			   $cardamount2 = $res51['cardamount'];
		   }
		   
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
			
         <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientname; ?>(<?php echo $patientvisitcode; ?>) </div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($cashamount2,2,'.',','); ?></td>
			 <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($cardamount2,2,'.',','); ?></td>
			   <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($chequeamount2,2,'.',','); ?></td>
			   <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($mpesaamount2,2,'.',','); ?></td>
			  <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($onlineamount2,2,'.',','); ?></td>
	         </tr>
			<?php
			}
			$grandtotal = $grandtotal + $openingbalance
			?>
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
			  </tbody>
        </table></td>
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
        <td colspan="3"  align="left" valign="center" class="bodytext31">&nbsp;</td>
      </tr>
	   <tr>
	   <td width="160"  align="left" valign="center" class="bodytext31">Total Bill Amount</td>
        <td width="63"  align="right" valign="center" class="bodytext31"><?php echo number_format($grandtotal,2,'.',','); ?></td>
        <td width="1041"  align="left" valign="center" class="bodytext31">&nbsp;</td>
        <td width="23"  align="left" valign="center" class="bodytext31">&nbsp;</td>
      </tr>
	   <tr>
	   <td width="160"  align="left" valign="center" class="bodytext31">Total Refund Amount(Less)</td>
        <td width="63"  align="right" valign="center" class="bodytext31"><?php echo number_format($grandtotal1,2,'.',','); ?></td>
        <td width="1041"  align="left" valign="center" class="bodytext31">&nbsp;</td>
        <td width="23"  align="left" valign="center" class="bodytext31">&nbsp;</td>
      </tr>
	  <tr>
	   <td width="160"  align="left" valign="center" class="bodytext31">Total Cash In Hand</td>
        <td width="63"  align="right" valign="center" class="bodytext31"><?php echo number_format($grandcash,2,'.',','); ?></td>
        <td width="1041"  align="left" valign="center" class="bodytext31"></td>
        <td width="23"  align="left" valign="center" class="bodytext31"></td>
      </tr>
	   <tr>
	   <td width="160"  align="left" valign="center" class="bodytext31">Total Card</td>
        <td  align="right" valign="center" class="bodytext31"> <?php echo number_format($grandcard,2,'.',','); ?></td>
        <td  align="left" valign="center" class="bodytext31">&nbsp;</td>
        <td width="23"  align="left" valign="center" class="bodytext31">&nbsp;</td>
      </tr>
	   <tr>
	   <td width="160"  align="left" valign="center" class="bodytext31">Total Cheque</td>
        <td  align="right" valign="center" class="bodytext31"> <?php echo number_format($grandcheque,2,'.',','); ?></td>
        <td  align="left" valign="center" class="bodytext31">&nbsp;</td>
        <td width="23"  align="left" valign="center" class="bodytext31">&nbsp;</td>
      </tr>
	   <tr>
	   <td width="160"  align="left" valign="center" class="bodytext31">Total Mpesa</td>
        <td  align="right" valign="center" class="bodytext31"> <?php echo number_format($grandmpesa,2,'.',','); ?></td>
        <td  align="left" valign="center" class="bodytext31">&nbsp;</td>
        <td width="23"  align="left" valign="center" class="bodytext31">&nbsp;</td>
      </tr>
	  <tr>
	   <td width="160"  align="left" valign="center" class="bodytext31">Total Online</td>
        <td  align="right" valign="center" class="bodytext31"> <?php echo number_format($grandonline,2,'.',','); ?></td>
        <td  align="left" valign="center" class="bodytext31">&nbsp;</td>
        <td width="23"  align="left" valign="center" class="bodytext31">&nbsp;</td>
      </tr>
   
			<tr>
        <td  align="left" valign="center" class="bodytext31"><strong>Total For Submission</strong> </td>
        <td  align="right" valign="center" class="bodytext31"><strong><?php echo number_format($grandtot,2,'.',','); ?></strong></td>
        <td  align="left" valign="center" class="bodytext31">&nbsp;</td>
		</tr>

	<tr>
	   <td width="160"  align="left" valign="center" class="bodytext31"><strong>Cash Submitted</strong></td>
        <td width="63"  align="right" valign="center" class="bodytext31"><strong><?php echo number_format($physical_cash,2,'.',','); ?></strong></td>
        <td width="1041"  align="left" valign="center" class="bodytext31"></td>
        <td width="23"  align="left" valign="center" class="bodytext31"></td>
      </tr>

	  <tr>
	   <td width="160"  align="left" valign="center" class="bodytext31"><strong>Cash Variation</strong></td>
        <td width="63"  align="right" valign="center" class="bodytext31"><strong><?php echo number_format($grandcash-$physical_cash,2,'.',','); ?></strong></td>
        <td width="1041"  align="left" valign="center" class="bodytext31"></td>
        <td width="23"  align="left" valign="center" class="bodytext31"></td>
      </tr>

			
         
</table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
