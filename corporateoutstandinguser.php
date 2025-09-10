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
<script>
function funcAccount()
{
if((document.getElementById("searchsuppliername").value == "")||(document.getElementById("searchsuppliername").value == " "))
{
alert('Please Select Account Name');
return false;
}
}
</script>
<script type="text/javascript" src="js/autocomplete_accounts2.js"></script>
<script type="text/javascript" src="js/autosuggest4accounts.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
}
</script>
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
<script>
function viewReport()
 {
window.open("<?php echo basename($_SERVER['PHP_SELF']); ?>","OriginalWindowA4",'width=922,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
  }
</script>
<script src="js/datetimepicker_css.js"></script>

<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="corporateoutstandinguser.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong>Corporate Outstanding</strong>&nbsp;&nbsp;&nbsp;<a href="#" onClick="viewReport();"><strong>W</strong></a></td>
			  			  <td bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>

              </tr>
            <!--<tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 
                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 
				</td>
              </tr>-->
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Account </td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
              </span></td>
           </tr>
		   
			  <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>	
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input type="submit" onClick="return funcAccount();" value="Search" name="Submit" />
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1200" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="4%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td colspan="14" bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311">
              <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					if (isset($_REQUEST["cbcustomername"])) { $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["customername"])) { $customername = $_REQUEST["customername"]; } else { $customername = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					//$transactiondatefrom = $_REQUEST['ADate1'];
					//$transactiondateto = $_REQUEST['ADate2'];
					
					//$paymenttype = $_REQUEST['paymenttype'];
					//$billstatus = $_REQUEST['billstatus'];
					
					$urlpath = "ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				else
				{
					$urlpath = "ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				?>
 				<?php
				//For excel file creation.
				
				$applocation1 = $applocation1; //Value from db_connect.php file giving application path.
				$filename1 = "print_paymentgivenreport1.php?$urlpath";
				$fileurl = $applocation1."/".$filename1;
				$filecontent1 = @file_get_contents($fileurl);
				
				$indiatimecheck = date('d-M-Y-H-i-s');
				$foldername = "dbexcelfiles";
				$fp = fopen($foldername.'/PaymentGivenToSupplier.xls', 'w+');
				fwrite($fp, $filecontent1);
				fclose($fp);

				?>
              <script language="javascript">
				function printbillreport1()
				{
					window.open("print_paymentgivenreport1.php?<?php echo $urlpath; ?>","Window1",'width=900,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
					//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
				}
				function printbillreport2()
				{
					window.location = "dbexcelfiles/PaymentGivenToSupplier.xls"
				}
				</script>
              <!--<input  value="Print Report" onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" />
&nbsp;				<input  value="Export Excel" onClick="javascript:printbillreport2()" name="resetbutton22" type="button" id="resetbutton22"  style="border: 1px solid #001E6A" />-->
</span></td>  
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="9%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
              <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Description </strong></td>
              <td width="20%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Debit</strong></td>
              <td width="16%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Credit</strong></div></td>
				<td width="16%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Days</strong></div></td>
				<td width="16%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Current Balance</strong></div></td>
            </tr>
			<?php
			
		  $query1 = "select sum(transactionamount) as transactionamount1 from master_transactionpaylater where accountname like '%$searchsuppliername%' and transactiontype = 'finalize' and transactiondate < '$ADate1'";
		  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res1 = mysqli_fetch_array($exec1);
		  $res1transactionamount1 = $res1['transactionamount1'];
		  
		  $query4 = "select sum(transactionamount) as transactionamount1 from master_transactionpaylater where accountname like '%$searchsuppliername%' and transactiontype = 'PAYMENT' and transactiondate < '$ADate1'";
		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res4 = mysqli_fetch_array($exec4);
		  $res4transactionamount1 = $res4['transactionamount1'];	
		  
		  $openingbalance = $res1transactionamount1 - $res4transactionamount1;
		  ?>
			<tr>
			<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong>&nbsp;</strong></td>
				
              <td width="9%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>&nbsp;</strong></div></td>
              <td width="35%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><strong> Opening Balance </strong></td>
              <td width="20%" align="right" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><strong>&nbsp;</strong></td>
              <td width="16%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
			 <td width="16%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>	
				<td width="16%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong><?php echo number_format($openingbalance,2,'.',''); ?></strong></div></td>
			</tr>
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			$query21 = "select * from master_transactionpaylater where accountname like '%$searchsuppliername%' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'finalize' group by accountname order by accountname desc ";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res21 = mysqli_fetch_array($exec21))
			{
			$res21accountname = $res21['accountname'];
			
			$query22 = "select * from master_accountname where accountname = '$res21accountname' and recordstatus <>'DELETED' ";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res22 = mysqli_fetch_array($exec22);
			$res22accountname = $res22['accountname'];

			if( $res21accountname != '')
			{
			?>
			<tr bgcolor="#ffffff">
            <td colspan="15"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong><?php echo $res22accountname;?> (Date From: <?php echo $ADate1; ?> Date To: <?php echo $ADate2; ?>)</strong></td>
            </tr>
			
			<?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$totalamount30 = 0;
			$totalamount60 = 0;
			$totalamount90 = 0;
			$totalamount120 = 0;
			$totalamount180 = 0;
			$totalamountgreater = 0;
			
		  
		      
		  $query2 = "select * from master_transactionpaylater where accountname like '%$res21accountname%' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'finalize' order by accountname desc";
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
		  $totalpayment = 0;
     	  $res2transactiondate = $res2['transactiondate'];
	      $res2patientname = $res2['patientname'];
		  $res2visitcode = $res2['visitcode'];
		  $res2billnumber = $res2['billnumber'];
		  $res2transactionamount = $res2['transactionamount'];
		  $res2patientcode = $res2['patientcode'];
		  
		  
		  $query98 = "select * from master_transactionpaylater where visitcode='$res2visitcode' and transactiontype = 'PAYMENT' and billnumber='$res2billnumber' and recordstatus = 'allocated'";
		  $exec98 = mysqli_query($GLOBALS["___mysqli_ston"], $query98) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num98 = mysqli_num_rows($exec98);
		  while($res98 = mysqli_fetch_array($exec98))
		  {
		  $payment = $res98['transactionamount'];
		  $totalpayment = $totalpayment + $payment;
		  }
		 $resamount = $res2transactionamount - $totalpayment;
		  if($resamount != 0)
		  {
		  $snocount = $snocount + 1;
		  $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res2transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		 
		  
		  if($snocount == 1)
		  {
		  $total = $openingbalance + $resamount;
		  }
		  else
		  {
		  $total = $total + $resamount;
		  }
		
		  
		  if($days_between <= 30)
		  {
		  if($snocount == 1)
		  {
		  $totalamount30 = $openingbalance + $resamount;
		  }
		  else
		  {
		  $totalamount30 = $totalamount30 + $resamount;
		  }
		  }
		  else if(($days_between >30) && ($days_between <=60))
		  {
		  if($snocount == 1)
		  {
		  $totalamount60 = $openingbalance + $resamount;
		  }
		  else
		  {
		  $totalamount60 = $totalamount60 + $resamount;
		  }
		  }
		  else if(($days_between >60) && ($days_between <=90))
		  {
		  if($snocount == 1)
		  {
		  $totalamount90 = $openingbalance + $resamount;
		  }
		  else
		  {
		  $totalamount90 = $totalamount90 + $resamount;
		  }
		  }
		  else if(($days_between >90) && ($days_between <=120))
		  {
		  if($snocount == 1)
		  {
		  $totalamount120 = $openingbalance + $resamount;
		  }
		  else
		  {
		  $totalamount120 = $totalamount120 + $resamount;
		  }
		  }
		  else if(($days_between >120) && ($days_between <=180))
		  {
		    if($snocount == 1)
		  {
		  $totalamount180 = $openingbalance + $resamount;
		  }
		  else
		  {
		  $totalamount180 = $totalamount180 + $resamount;
		  }
		  }
		  else
		  {
		      if($snocount == 1)
		  {
		  $totalamountgreater = $openingbalance + $resamount;
		  }
		  else
		  {
		  $totalamountgreater = $totalamountgreater + $resamount;
		  }
		  }
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
	
			?>
			
           <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2patientname; ?> (<?php echo $res2patientcode; ?>, <?php echo $res2visitcode; ?>, <?php echo $res2billnumber; ?>)</div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($resamount,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php //echo $days_between; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $days_between; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
           </tr>
			<?php
			}
			}
			?>
          <?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			
			
		      
		  $query3 = "select * from master_transactionpaylater where accountname like '$res21accountname' and transactiondate between '$ADate1' and '$ADate2' and transactionstatus = 'onaccount' order by accountname desc";
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		 // echo $num3 = mysql_num_rows($exec3);
		  while ($res3 = mysqli_fetch_array($exec3))
		  {
		  $totalonaccountpayment = 0;
     	  $res3transactiondate = $res3['transactiondate'];
	      $res3patientname = $res3['patientname'];
		  $res3patientcode = $res3['patientcode'];
		  $res3visitcode = $res3['visitcode'];
		  $res3billnumber = $res3['billnumber'];
		  $res3docno = $res3['docno'];
		  $res3transactionamount = $res3['transactionamount'];
		  $res3transactionmode = $res3['transactionmode'];
		  $res3transactionnumber = $res3['chequenumber'];
		  
		  $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res3transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		  
		  $query67 = "select * from master_transactionpaylater where docno='$res3docno' and transactionstatus <> 'onaccount' and recordstatus = 'allocated'";
		  $exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res67 = mysqli_fetch_array($exec67))
		  {
		   $onaccountpayment = $res67['transactionamount'];
		  $totalonaccountpayment = $totalonaccountpayment + $onaccountpayment;
		  }
		  
		  $resonaccountpayment = $res3transactionamount - $totalonaccountpayment;
		 
		  if($resonaccountpayment != 0)
		  {
		
		  $total = $total - $resonaccountpayment;
		  
		  if($days_between <= 30)
		  {
		 
		  $totalamount30 = $totalamount30 - $resonaccountpayment;
		  
		  }
		  else if(($days_between >30) && ($days_between <=60))
		  {
		
		  $totalamount60 = $totalamount60 - $resonaccountpayment;
		  
		  }
		  else if(($days_between >60) && ($days_between <=90))
		  {
		 
		  $totalamount90 = $totalamount90 - $resonaccountpayment;
		 
		  }
		  else if(($days_between >90) && ($days_between <=120))
		  {
		 
		  $totalamount120 = $totalamount120 - $resonaccountpayment;
		  
		  }
		  else if(($days_between >120) && ($days_between <=180))
		  {
		
		  $totalamount180 = $totalamount180 - $resonaccountpayment;
		  
		  }
		  else
		  {
		
		  $totalamountgreater = $totalamountgreater - $resonaccountpayment;
		 
		  }
		  $snocount = $snocount + 1;
			
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
	
			?>
           <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res3transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res3transactionmode; ?> <?php echo $res3transactionnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php //echo number_format($res3transactionamount,2,'.',''); ?></td>
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($resonaccountpayment,2,'.',',');?></div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="center"><?php echo $days_between;?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
           </tr>
			<?php
			}
			}
			?>
			<?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			
			
		      
		  $query34 = "select * from master_transactionpaylater where accountname like '$res21accountname' and transactiondate between '$ADate1' and '$ADate2' and transactionstatus <> 'onaccount' and transactiontype = 'PAYMENT' and transactionmodule = 'PAYMENT' order by accountname desc";
		  $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die ("Error in Query34".mysqli_error($GLOBALS["___mysqli_ston"]));
		   $num34 = mysqli_num_rows($exec34);
		  while ($res34 = mysqli_fetch_array($exec34))
		  {
		  $totalonlinepayment = 0;
     	  $res34transactiondate = $res34['transactiondate'];
	      $res34patientname = $res34['patientname'];
		  $res34patientcode = $res34['patientcode'];
		  $res34visitcode = $res34['visitcode'];
		  $res34billnumber = $res34['billnumber'];
		  $res34docno = $res34['docno'];
		  $res34transactionamount = $res34['transactionamount'];
		  $res34transactionmode = $res34['transactionmode'];
		  $res34transactionnumber = $res34['chequenumber'];
		  $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res34transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		  
		  $query66 = "select sum(transactionamount) as tottransactionamount from master_transactionpaylater where transactionstatus <> 'onaccount' and transactiontype = 'PAYMENT' and transactionmodule = 'PAYMENT' and docno ='$res34docno'";
		  $exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res66 = mysqli_fetch_array($exec66);
		  $tottransactionamount = $res66['tottransactionamount'];
		  
		  $query674 = "select * from master_transactionpaylater where docno='$res34docno' and transactionstatus <> 'onaccount' and recordstatus = 'allocated'";
		  $exec674 = mysqli_query($GLOBALS["___mysqli_ston"], $query674) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $num674 = mysqli_num_rows($exec674);
		  while($res674 = mysqli_fetch_array($exec674))
		  {
		  $onlinepayment = $res674['transactionamount'];
		  $totalonlinepayment = $totalonlinepayment + $onlinepayment;
		  }
		 
		  $resonlinepayment = $tottransactionamount - $totalonlinepayment;
		 
		  if($resonlinepayment != 0)
		  {
		
		  $total = $total - $resonlinepayment;
		  
		  if($days_between <= 30)
		  {
		 
		  $totalamount30 = $totalamount30 - $resonlinepayment;
		  
		  }
		  else if(($days_between >30) && ($days_between <=60))
		  {
		
		  $totalamount60 = $totalamount60 - $resonlinepayment;
		  
		  }
		  else if(($days_between >60) && ($days_between <=90))
		  {
		 
		  $totalamount90 = $totalamount90 - $resonlinepayment;
		 
		  }
		  else if(($days_between >90) && ($days_between <=120))
		  {
		 
		  $totalamount120 = $totalamount120 - $resonlinepayment;
		  
		  }
		  else if(($days_between >120) && ($days_between <=180))
		  {
		
		  $totalamount180 = $totalamount180 - $resonlinepayment;
		  
		  }
		  else
		  {
		
		  $totalamountgreater = $totalamountgreater - $resonlinepayment;
		 
		  }
		  $snocount = $snocount + 1;
			
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
	
			?>
           <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res34transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res34transactionmode; ?> <?php echo $res34transactionnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php //echo number_format($res3transactionamount,2,'.',''); ?></td>
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($resonlinepayment,2,'.',',');?></div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="center"><?php echo $days_between;?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
           </tr>
			<?php
			}
			}
			?> 
			<?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			
		      
		  $query5 = "select * from master_transactionpaylater where accountname = '$searchsuppliername' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'pharmacycredit' order by transactiondate desc";
		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  //echo $num = mysql_num_rows($exec3);
		  while ($res5 = mysqli_fetch_array($exec5))
		  {
		  $totalpharmacreditpayment = 0;
     	  $res5transactiondate = $res5['transactiondate'];
	      $res5patientname = $res5['patientname'];
		  $res5patientcode = $res5['patientcode'];
		  $res5visitcode = $res5['visitcode'];
		  $res5docno = $res5['docno'];
		  
		  $query78 = "select * from billing_paylater where visitcode='$res5visitcode'";
		  $exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78);
		  $res78 = mysqli_fetch_array($exec78);
		  $finalizedbillno = $res78['billno'];
		  $res5billnumber = $res5['billnumber'];
		  $res5transactionamount = $res5['transactionamount'];
		  $res5transactionmode = $res5['transactionmode'];
		  
		 
		  $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res5transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		  $query77 = "select * from master_transactionpaylater where visitcode='$res5visitcode' and docno='$res5docno' and transactiontype <> 'pharmacycredit' and recordstatus = 'allocated'";
		  $exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res77 = mysqli_fetch_array($exec77))
		  {
		   $pharmacreditpayment = $res77['transactionamount'];
		   
		  $totalpharmacreditpayment = $totalpharmacreditpayment + $pharmacreditpayment;
		  }
		  
		  $respharmacreditpayment = $res5transactionamount - $totalpharmacreditpayment;
		
		  if($respharmacreditpayment != 0)
		  {
		  $total = $total - $respharmacreditpayment;
		 
		 	  
		  if($days_between <= 30)
		  {
		 
		  $totalamount30 = $totalamount30 - $respharmacreditpayment;
		 
		  }
		  else if(($days_between >30) && ($days_between <=60))
		  {
		 
		  $totalamount60 = $totalamount60 - $respharmacreditpayment;
		  
		  }
		  else if(($days_between >60) && ($days_between <=90))
		  {
		
		  $totalamount90 = $totalamount90 - $respharmacreditpayment;
		 
		  }
		  else if(($days_between >90) && ($days_between <=120))
		  {
		 
		  $totalamount120 = $totalamount120 - $respharmacreditpayment;
		  
		  }
		  else if(($days_between >120) && ($days_between <=180))
		  {
		 
		  $totalamount180 = $totalamount180 - $respharmacreditpayment;
		  
		  }
		  else
		  {
		
		  $totalamountgreater = $totalamountgreater - $respharmacreditpayment;
		  
		  }
		  $snocount = $snocount + 1;
			
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
	
			?>
           <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res5transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res5patientname; ?> (<?php echo $res5patientcode; ?>,<?php echo $res5visitcode; ?>,<?php echo $finalizedbillno; ?>)- Cr.Note : Pharma</div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php //echo number_format($res3transactionamount,2,'.',''); ?></td>
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($respharmacreditpayment,2,'.',',');?></div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="center"><?php echo $days_between;?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
           </tr>
		   <?php
		   }
		   }
		   ?>
		    <?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			
		      
		  $query6 = "select * from master_transactionpaylater where accountname = '$searchsuppliername' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'paylatercredit' order by transactiondate desc";
		  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		  //echo $num = mysql_num_rows($exec3);
		  while ($res6 = mysqli_fetch_array($exec6))
		  {
		  $totalpaylatercreditpayment = 0;
     	  $res6transactiondate = $res6['transactiondate'];
	      $res6patientname = $res6['patientname'];
		  $res6patientcode = $res6['patientcode'];
		  $res6visitcode = $res6['visitcode'];
		  $res6billnumber = $res6['billnumber'];
		  $res6transactionamount = $res6['transactionamount'];
		  $res6transactionmode = $res6['transactionmode'];
		  $res6docno = $res6['docno'];
		  
		  $query56 = "select * from billing_paylater where visitcode='$res6visitcode'";
		  $exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res56 = mysqli_fetch_array($exec56);
		  $billnos = $res56['billno'];
		  
		  $query57 = "select * from consultation_lab where patientvisitcode='$res6visitcode' and labrefund='refund'";
		  $exec57 = mysqli_query($GLOBALS["___mysqli_ston"], $query57) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num57 = mysqli_num_rows($exec57);
		  
		  if($num57 != 0)
		  {
		  $lab = "Lab";
		  }
		  else
		  {
		  $lab = "";
		  }
		  
		  $query58 = "select * from consultation_radiology where patientvisitcode='$res6visitcode' and radiologyrefund='refund'";
		  $exec58 = mysqli_query($GLOBALS["___mysqli_ston"], $query58) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num58 = mysqli_num_rows($exec58);
		 
		  if($num58 != 0)
		  {
		  $rad = "Rad";
		  }
		  else
		  {
		  $rad = "";
		  }
		  
		  $query59 = "select * from consultation_services where patientvisitcode='$res6visitcode' and servicerefund='refund'";
		  $exec59 = mysqli_query($GLOBALS["___mysqli_ston"], $query59) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num59 = mysqli_num_rows($exec59);
	
	      if($num59 != 0)
		  {
		  $ser = "Services";
		  }
		  else
		  {
		  $ser = "";
		  }
		  
		  $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res6transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		  
		   $query47 = "select * from master_transactionpaylater where visitcode='$res6visitcode' and docno='$res6docno' and transactiontype <> 'paylatercredit' and recordstatus = 'allocated'";
		  $exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res47 = mysqli_fetch_array($exec47))
		  {
		   $paylatercreditpayment = $res47['transactionamount'];
		   
		  $totalpaylatercreditpayment = $totalpaylatercreditpayment + $paylatercreditpayment;
		  }
		  
		  $respaylatercreditpayment = $res6transactionamount - $totalpaylatercreditpayment;
		
		  if($respaylatercreditpayment != 0)
		  {
		  $total = $total - $respaylatercreditpayment;
		 
				  
		  if($days_between <= 30)
		  {
		  
		  $totalamount30 = $totalamount30 - $respaylatercreditpayment;
		  
		  }
		  else if(($days_between >30) && ($days_between <=60))
		  {
		  
		  $totalamount60 = $totalamount60 - $respaylatercreditpayment;
		  
		  }
		  else if(($days_between >60) && ($days_between <=90))
		  {
		  
		  $totalamount90 = $totalamount90 - $respaylatercreditpayment;
		 
		  }
		  else if(($days_between >90) && ($days_between <=120))
		  {
		  
		  $totalamount120 = $totalamount120 - $respaylatercreditpayment;
		 
		  }
		  else if(($days_between >120) && ($days_between <=180))
		  {
		  
		  $totalamount180 = $totalamount180 - $respaylatercreditpayment;
		  
		  }
		  else
		  {
		      
		  $totalamountgreater = $totalamountgreater - $respaylatercreditpayment;
		  
		  }
		  $snocount = $snocount + 1;
			
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
	
			?>
           <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res6transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res6patientname; ?> (<?php echo $res6patientcode; ?>,<?php echo $res6visitcode; ?>,<?php echo $billnos; ?>)- Cr.Note : <?php echo $lab; ?>&nbsp;<?php echo $rad; ?>&nbsp;<?php echo $ser; ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php //echo number_format($res3transactionamount,2,'.',''); ?></td>
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($respaylatercreditpayment,2,'.',',');?></div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="center"><?php echo $days_between;?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
           </tr>
			
			<?php
			}
			}
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
            </tr>
				 </tbody>
        </table></td>
      </tr>
	  
   
			<tr>
        <td>&nbsp;</td>
      </tr>
		
			<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
			<tr>
              <td width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td  width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td  width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
					<td  width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
            
				<td  width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
            
            	 </tr>
						<tr>
               <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>30 days</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>60 days</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>90 days</strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>120 days</strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>180 days</strong></td>
           <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>180+ days</strong></td>
           
             	 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>Total Due</strong></td>
            </tr>
			<?php 
			$grandtotal = $totalamount30 + $totalamount60 + $totalamount90 + $totalamount120 + $totalamount180 + $totalamountgreater;
			?>
			<tr>
               <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><?php echo number_format($totalamount30,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><?php echo number_format($totalamount60,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><?php echo number_format($totalamount90,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><?php echo number_format($totalamount120,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><?php echo number_format($totalamount180,2,'.',','); ?></td>
            <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><?php echo number_format($totalamountgreater,2,'.',','); ?></td>
            
             	 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><?php echo number_format($grandtotal,2,'.',','); ?></td>
            </tr>
			
		    <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
					<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
           <?php
			
				$urlpath = "cbfrmflag1=cbfrmflag1&&ADate1=$ADate1&&ADate2=$ADate2&&searchsuppliername=$searchsuppliername";
			
			?>
		   	 <td class="bodytext31" valign="center"  align="right"><a href="print_corporateoutstanding.php?<?php echo $urlpath; ?>"><img  width="40" height="40" src="images/excel-xls-icon.png" style="cursor:pointer;"></a></td>
			            
               </tr>
			  </table>
			  
			<?php
			}
			}
			}
			?>
         
</table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
