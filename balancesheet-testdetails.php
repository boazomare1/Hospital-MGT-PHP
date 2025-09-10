<?php
session_start();
set_time_limit(0);
include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$currentdate = date('d-m-Y');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$paymentreceiveddateto1 = "2014-01-01";
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
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

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
        <td width="860">
		
		
              <form name="cbform1" method="post" action="balancesheet-testdetails.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong> Balance Sheet</strong></td>
              </tr>
            <!--<tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 
                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 
				</td>
              </tr>-->
            
		   
			  <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> <strong>Date From</strong> </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddateto1; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> <strong>Date To</strong> </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>	
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" onClick="return funcAccount();" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
       <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" 
            align="left" border="0">
          <tbody>
            		
           
		
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			
		 include("currentassetcalculation.php");
		  include("profitlosscalculation.php");
		  include("costofgoodssoldcalculation.php");
		  
		  $grandtot = $grandtot + $grandtotalinventoryvalue;
		 $noncurrentassets = "0.00";
		 $totalassets = $noncurrentassets + $grandtot + $netexpense;
	     $currentliabilities = $taxamount;
		 $totalreceiptcreditamount81 = '0.00';
		    $query881 = "select * from receiptsub_details";
			$exec881 = mysqli_query($GLOBALS["___mysqli_ston"], $query881) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res881 = mysqli_fetch_array($exec881))
			{
			$receiptdocno = $res881['docnumber'];
			$receiptamountdetail = $res881['transactionamount'];
		
			$totalreceiptcreditamount81 = $totalreceiptcreditamount81 + $receiptamountdetail;
			
			}
			
		 $currentliabilities = $currentliabilities + $balanceamount1;
		 
		 $totalipdepositamount8 = '0.00';
			
			$query8831 = "select * from master_transactionipdeposit where transactionmodule <> 'Adjustment' and transactiondate between '$ADate1' and '$ADate2' group by docno";
			$exec8831 = mysqli_query($GLOBALS["___mysqli_ston"], $query8831) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res8831 = mysqli_fetch_array($exec8831))
			{
			$ipdepositdocno = $res8831['docno'];
			$ipdepositamountdetail = $res8831['transactionamount'];
		
			$totalipdepositamount8 = $totalipdepositamount8 + $ipdepositamountdetail;
			
			}
			
			$totaladvancedepositamount8 = '0.00';
			
			$query8832 = "select * from master_transactionadvancedeposit where transactiondate between '$ADate1' and '$ADate2' group by docno";
			$exec8832 = mysqli_query($GLOBALS["___mysqli_ston"], $query8832) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res8832 = mysqli_fetch_array($exec8832))
			{
			$advancedepositdocno = $res8832['docno'];
			$advancedepositamountdetail = $res8832['transactionamount'];
		
			$totaladvancedepositamount8 = $totaladvancedepositamount8 + $advancedepositamountdetail;
			
			}
			$patientdeposts = $totalipdepositamount8 + $totaladvancedepositamount8;
			
			
			$query657 = "select sum(deposit) as totalbilldeposit from billing_ip";
			$exec657 = mysqli_query($GLOBALS["___mysqli_ston"], $query657) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res657 = mysqli_fetch_array($exec657);
			$totalbilldeposit = $res657['totalbilldeposit'];
			$patientdeposts = $patientdeposts - $totalbilldeposit;
			
			$query6571 = "select sum(deposit) as totalbilldeposit from billing_ipcreditapproved";
			$exec6571 = mysqli_query($GLOBALS["___mysqli_ston"], $query6571) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res6571 = mysqli_fetch_array($exec6571);
			$totalbilldepositapprovedcredit = $res6571['totalbilldeposit'];
			$patientdeposts = $patientdeposts - $totalbilldepositapprovedcredit;
			
			$query13 = "select sum(totalamount) as totalreturnamount from purchasereturn_details where entrydate between '$ADate1' and '$ADate2'";
			$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res13 = mysqli_fetch_array($exec13);
			$totalreturnamount = $res13['totalreturnamount'];
			
			$query61 = "select sum(totalrate) as openingstockamount from openingstock_entry where transactiondate between '$ADate1' and '$ADate2'";
			$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res61 = mysqli_fetch_array($exec61);
			$openingstockamount = $res61['openingstockamount'];
			
		 $longtermliabilities = "0.00";
		 $commonstock = "0.00";
		 $capital = $totalfixedassets;
		 $totalliabilities = $currentliabilities + $longtermliabilities + $commonstock + $capital + $netincome + $patientdeposts + $ipfinalprivatedoctoramount - $totalreturnamount + $openingstockamount;
		 
		 if($totalbalanceamount == '')
		 {
		 $totalbalanceamount = '0.00';
		 }
		 
		 if($balanceamount1 == '')
		 {
		 $balanceamount1 = '0.00';
		 }
		 $balanceamount1 = $balanceamount1 + $ipfinalprivatedoctoramount;
		 
		  $balanceamount1 = $balanceamount1 - $totalreturnamount;
		
		 $newtotalbalanceamount = $totalbalanceamount - $totalpaylaterpharmrefundamount + $paylaterrefundamount;
				?>
			
           <tr bgcolor="#CBDBFA">
              <td width="249"  align="left" valign="center" class="bodytext31"><strong>Current Assets</strong></td>
              <td width="71"  align="left" valign="center" class="bodytext31"></td>
           </tr>
		   <tr bgcolor="#ecf0f5">
              <td width="249"  align="left" valign="center" class="bodytext31"><strong>Inventory</strong></td>
              <td width="71"  align="right" valign="center" class="bodytext31"><?php echo number_format($grandtotalinventoryvalue,2,'.',','); ?></td>
           </tr>
		    <tr bgcolor="#CBDBFA">
              <td width="249"  align="left" valign="center" class="bodytext31"><strong>Accounts Receivable</strong></td>
              <td width="71"  align="right" valign="center" class="bodytext31"><?php echo number_format($newtotalbalanceamount,2,'.',','); ?></td>
           </tr>	
		   <?php $query2tp = "select transactionamount as tamount,billnumber,accountname from master_transactionpaylater where transactiontype = 'finalize'";
			$exec2tp = mysqli_query($GLOBALS["___mysqli_ston"], $query2tp) or die ("Error in Query2tp".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res2tp = mysqli_fetch_array($exec2tp))
			{
				$toot='';
				$billnumbertp = $res2tp['billnumber'];
				$billtotalamounttp = $res2tp['tamount'];
				$accountname = $res2tp['accountname'];
				
				$query72tp = "select sum(transactionamount) as amount,accountname from master_transactionpaylater where accountname = '$accountname' and transactionstatus = 'onaccount' and transactiondate between '$ADate1' and '$ADate2' order by auto_number desc";
				$exec72tp = mysqli_query($GLOBALS["___mysqli_ston"], $query72tp) or die ("Error in Query75tp".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res72tp = mysqli_fetch_array($exec72tp);
				$toot=-$res72tp['amount'];
			  
				$query3tp = "select sum(transactionamount) as amount,accountname from master_transactionpaylater where billnumber = '$billnumbertp' and transactiontype = 'PAYMENT' and transactionmodule = 'PAYMENT' and companyanum='$companyanum' and recordstatus <>'deallocated'";
				$exec3tp = mysqli_query($GLOBALS["___mysqli_ston"], $query3tp) or die ("Error in Query3tp".mysqli_error($GLOBALS["___mysqli_ston"]));
				$numbrtp=mysqli_num_rows($exec3tp);
				$res3tp = mysqli_fetch_array($exec3tp);
				$toot+=$billtotalamounttp-$res3tp['amount']; 
				
				
			   
			  
			  
				$query22tp = "select totalamount as paylaterrefundamount,accountname from refund_paylater where finalizationbillno = '$billnumbertp' and billdate between '$ADate1' and '$ADate2' order by auto_number desc";
				$exec22tp = mysqli_query($GLOBALS["___mysqli_ston"], $query22tp) or die ("Error in Query22tp".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res22tp = mysqli_fetch_array($exec22tp);
				//while ($res22tp = mysql_fetch_array($exec22tp)){
				$toot=$toot+$res22tp['paylaterrefundamount'];
		  ?>
		  <tr bgcolor="#CBDBFA">
              <td width="249"  align="left" valign="center" class="bodytext31"><strong><?php echo $accountname; ?></strong></td>
              <td width="71"  align="right" valign="center" class="bodytext31"><?php echo number_format($toot,2,'.',','); ?></td>
          </tr>  
		  <?php 
		  //}
			}
			/*$query72tp = "select transactionamount,accountname from master_transactionpaylater where transactionstatus = 'onaccount' and transactiondate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec72tp = mysql_query($query72tp) or die ("Error in Query72tp".mysql_error());
		  while ($res72tp = mysql_fetch_array($exec72tp))
		  {?>
		  <tr bgcolor="#CBDBFA">
              <td width="249"  align="left" valign="center" class="bodytext31"><strong><?php echo $res72tp['accountname']; ?></strong></td>
              <td width="71"  align="right" valign="center" class="bodytext31"><?php echo "-".number_format($res72tp['transactionamount'],2,'.',','); ?></td>
           </tr> */
		  
		  $query23 = "select * from pharmacysalesreturn_details where billstatus = 'completed' and entrydate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res23 = mysqli_fetch_array($exec23))
		  {
			  $paylaterpharmrefundpatientcode = $res23['patientcode'];
			  
			  $query231 = "select * from master_customer where customercode = '$paylaterpharmrefundpatientcode'";
			  $exec231 = mysqli_query($GLOBALS["___mysqli_ston"], $query231) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res231 = mysqli_fetch_array($exec231);
			  $patientrefundtype = $res231['billtype'];
			  
			  $query722tp = "select patientcode,accountname from master_transactionpaylater where patientcode = '$paylaterpharmrefundpatientcode' group by patientcode ";
			  $exec722tp = mysqli_query($GLOBALS["___mysqli_ston"], $query722tp) or die ("Error in Query722tp".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res722tp = mysqli_fetch_array($exec722tp);
			  
			  if($patientrefundtype == 'PAY LATER')
			  {
		  //$paylaterpharmrefundamount = $res23['totalamount'];
		  //$totalpaylaterpharmrefundamount = $totalpaylaterpharmrefundamount + $paylaterpharmrefundamount;?>
		  <tr bgcolor="#CBDBFA">
              <td width="249"  align="left" valign="center" class="bodytext31"><strong><?php echo $res722tp['accountname']; ?></strong></td>
              <td width="71"  align="right" valign="center" class="bodytext31"><?php echo number_format($res23['totalamount'],2,'.',','); ?></td>
           </tr> 
		  <?php }
		  }
		   ?>
		    <tr bgcolor="#ecf0f5">
              <td width="249"  align="left" valign="center" class="bodytext31"><strong>NHIF Receivable</strong></td>
              <td width="71"  align="right" valign="center" class="bodytext31"><?php echo number_format($totalnhif,2,'.',','); ?></td>
           </tr>
		   <tr bgcolor="#CBDBFA">
              <td width="249"  align="left" valign="center" class="bodytext31"><strong>Bank and Cash</strong></td>
              <td width="71"  align="right" valign="center" class="bodytext31"><?php echo number_format($cashflowamount,2,'.',','); ?></td>
           </tr>
		  <tr bgcolor="#ecf0f5">
              <td class="bodytext31" valign="center"  align="left"><strong>Fixed Assets</strong></td>
              <td class="bodytext31" valign="center"  align="right"><?php echo number_format($totalfixedassets,2,'.',','); ?> </td>
           </tr>
		    <tr bgcolor="#ecf0f5">
              <td class="bodytext31" valign="center"  align="left"><strong>Less Accumulated Depreciation</strong></td>
              <td class="bodytext31" valign="center"  align="right"><?php echo number_format($totaldepreciation,2,'.',','); ?> </td>
           </tr>
		    <tr bgcolor="#ecf0f5">
              <td class="bodytext31" valign="center"  align="left"><strong>Net Fixed Asset Value</strong></td>
              <td class="bodytext31" valign="center"  align="right"><?php echo number_format($netexpense,2,'.',','); ?> </td>
           </tr>
			<tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"><strong>Total Assets</strong></td>
              <td class="bodytext31" valign="center"  align="right"><?php echo number_format($totalassets,2,'.',','); ?> </td>
           </tr>
		   <tr bgcolor="#ecf0f5">
              <td class="bodytext31" valign="center"  align="left"></td>
              <td class="bodytext31" valign="center"  align="right"></td>
           </tr>
		   <tr bgcolor="#ecf0f5">
              <td class="bodytext31" valign="center"  align="left"></td>
              <td class="bodytext31" valign="center"  align="right"></td>
           </tr>
		    <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"><strong>Current Liabilities</strong></td>
              <td class="bodytext31" valign="center"  align="right"> </td>
           </tr>
		    <tr bgcolor="#ecf0f5">
              <td class="bodytext31" valign="center"  align="left"><strong>Accounts Payable</strong></td>
              <td class="bodytext31" valign="center"  align="right"><?php echo number_format($balanceamount1,2,'.',','); ?> </td>
           </tr>
		   <?php
	  		$query2pay = "select * from master_purchase where recordstatus <> 'deleted' and companyanum = '$companyanum';";			
			$exec2pay = mysqli_query($GLOBALS["___mysqli_ston"], $query2pay) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowcount2pay = mysqli_num_rows($exec2pay);
			
			while ($res2pay = mysqli_fetch_array($exec2pay))
			{
						
				$suppliername = $res2pay['suppliername'];
				$billnumber = $res2pay['billnumber'];
				$billtotalamount = $res2pay['totalamount'];
	
				$query33pay = "select transactionamount from master_transactionpharmacy where transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = ''";
				$exec33pay = mysqli_query($GLOBALS["___mysqli_ston"], $query33pay) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num=mysqli_num_rows($exec33pay);
				$res33pay = mysqli_fetch_array($exec33pay);
				$amountpayable = $billtotalamount - $res33pay['transactionamount'];
				
				$query13pay = "select sum(totalamount) as totalreturnamount from purchasereturn_details where grnbillnumber = '$billnumber' and entrydate between '$ADate1' and '$ADate2'";
				$exec13pay = mysqli_query($GLOBALS["___mysqli_ston"], $query13pay) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res13pay = mysqli_fetch_array($exec13pay);
				$totalreturnamountpay = $res13pay['totalreturnamount'];
				$amountpayable-=$totalreturnamountpay;
?>
			 <tr bgcolor="#ecf0f5">
            				<td class="bodytext31" valign="center"  align="left"><strong><?php echo $suppliername; ?></strong></td>
			              <td class="bodytext31" valign="center"  align="right"><?php echo number_format($amountpayable,2,'.',','); ?> </td>
			 </tr>
<?php
			}
			$query36pay = "select amount as ipfinalprivatedoctoramount from billing_ipprivatedoctor where recorddate between '$ADate1' and '$ADate2' order by auto_number desc";
		  	$exec36pay = mysqli_query($GLOBALS["___mysqli_ston"], $query36pay) or die ("Error in Query36pay".mysqli_error($GLOBALS["___mysqli_ston"]));
			$nums=mysqli_num_rows($exec36pay);
			
		  	while($res36pay = mysqli_fetch_array($exec36pay))
			{
			$ipfinalprivatedoctoramounts = $res36pay['ipfinalprivatedoctoramount'];
			?>
			<tr bgcolor="#ecf0f5">
            	  <td class="bodytext31" valign="center"  align="left"><strong> IP Private Doctors</strong></td>
			      <td class="bodytext31" valign="center"  align="right"><?php echo number_format($ipfinalprivatedoctoramounts,2,'.',','); ?> </td>
			 </tr>
			
			<?php 
			
		  	
			}
?>
		    <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"><strong>Tax Liability</strong></td>
              <td class="bodytext31" valign="center"  align="right"><?php echo number_format($taxamount,2,'.',','); ?> </td>
           </tr>
		   <tr bgcolor="#ecf0f5">
              <td class="bodytext31" valign="center"  align="left"><strong>Patient Deposits</strong></td>
              <td class="bodytext31" valign="center"  align="right"><?php echo number_format($patientdeposts,2,'.',','); ?> </td>
           </tr>
		    <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"><strong>Opening Stock</strong></td>
              <td class="bodytext31" valign="center"  align="right"><?php echo number_format($openingstockamount,2,'.',','); ?> </td>
           </tr>
		   <tr bgcolor="#ecf0f5">
              <td  align="left" valign="center" class="bodytext31"><strong>Equity</strong></td>
              <td class="bodytext31" valign="center"  align="right"><?php echo number_format($capital,2,'.',','); ?> </td>
           </tr>
		  <!-- <tr bgcolor="#CBDBFA">
              <td width="249"  align="left" valign="center" class="bodytext31"><strong>Other Incomes</strong></td>
              <td width="71"  align="left" valign="center" class="bodytext31"><?php echo number_format($totalreceiptcreditamount81,2,'.',','); ?> </td>
           </tr>-->
		   <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"><strong>Profit & Loss</strong></td>
              <td class="bodytext31" valign="center"  align="right"><?php echo number_format($netincome,2,'.',','); ?> </td>
           </tr>
		    <tr bgcolor="#ecf0f5">
              <td class="bodytext31" valign="center"  align="left"><strong>Total Liabilities</strong></td>
              <td class="bodytext31" valign="center"  align="right"><?php echo number_format($totalliabilities,2,'.',','); ?> </td>
           </tr>
		   <tr bgcolor="">
            <td class="bodytext31" valign="center"  align="left"><strong></strong></td>
		    <td class="bodytext31" valign="center"  align="right"><a href="print_balancesheet.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>"><img  width="40" height="40" src="images/excel-xls-icon.png" style="cursor:pointer;"></a></td>
			 </tr>
			 </tbody>
        </table></td>
      </tr>
		<?php
			}
			?>
         
</table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
