<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');

$searchsuppliername = '';
$suppliername = '';
$cbsuppliername = '';
$cbcustomername = '';
$cbbillnumber = '';
$cbbillstatus = '';
$colorloopcount = '';
$sno = '';
$snocount = '';

$looptotalpaidamount = '0.00';
$looptotalpendingamount = '0.00';
$looptotalwriteoffamount = '0.00';
$looptotalcashamount = '0.00';
$looptotalcreditamount = '0.00';
$looptotalcardamount = '0.00';
$looptotalonlineamount = '0.00';
$looptotalchequeamount = '0.00';
$looptotaltdsamount = '0.00';
$looptotalwriteoffamount = '0.00';
$pendingamount = '0.00';

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$cbsuppliername = $_REQUEST['cbsuppliername'];
	$suppliername = $_REQUEST['cbsuppliername'];
	$paymentreceiveddatefrom = $_REQUEST['ADate1'];
	$paymentreceiveddateto = $_REQUEST['ADate2'];

}

if (isset($_REQUEST["task"])) { $task = $_REQUEST["task"]; } else { $task = ""; }
//$task = $_REQUEST['task'];
if ($task == 'deleted')
{
	$errmsg = 'Payment Entry Delete Completed.';
}

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//$billstatus = $_REQUEST['billstatus'];
if ($ADate1 != '' && $ADate2 != '')
{
	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];
}
else
{
	$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
	$transactiondateto = date('Y-m-d');
}



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
<script language="javascript">

function cbsuppliername1()
{
	document.cbform1.submit();
}

</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
<script language="javascript">

function funcPrintReceipt1(varRecAnum)
{
	var varRecAnum = varRecAnum
	//alert (varRecAnum);
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php //echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_payment_receipt1.php?receiptanum="+varRecAnum+"","OriginalWindow<?php //echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}

function funcDeletePayment1(varPaymentSerialNumber)
{
	var varPaymentSerialNumber = varPaymentSerialNumber;
	var fRet;
	fRet = confirm('Are you sure want to delete this payment entry serial number '+varPaymentSerialNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Payment Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Payment Entry Delete Not Completed.");
		return false;
	}
	//return false;
}

</script>
</head>

<script src="js/datetimepicker_css.js"></script>

<body>
<table width="1900" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="paymentgiven1.php">
		<table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Payment Given Report     - Select Supplier </strong></td>
              <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
              <td bgcolor="#ecf0f5" class="bodytext3" colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td width="21%"  align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Select Supplier </td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input value="<?php echo $cbsuppliername; ?>" name="cbsuppliername" type="text" id="cbsuppliername" size="50" style="border: 1px solid #001E6A"></td>
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
              <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
			  <input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
				<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>				</td>
              <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
              <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
				<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
			  </span></td>
            </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" /></td>
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1700" 
            align="left" border="0">
          <tbody>
            <tr>
              <td bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
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
					
					$transactiondatefrom = $_REQUEST['ADate1'];
					$transactiondateto = $_REQUEST['ADate2'];
					
					//$paymenttype = $_REQUEST['paymenttype'];
					//$billstatus = $_REQUEST['billstatus'];
					
					$urlpath = "cbcustomername=$cbcustomername&&cbbillnumber=$cbbillnumber&&cbbillstatus=$cbbillstatus&&ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				else
				{
					$urlpath = "cbcustomername=$cbcustomername&&cbbillnumber=$cbbillnumber&&cbbillstatus=$cbbillstatus&&ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
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
              <input value="Print Report" onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" />
&nbsp;				<input value="Export Excel" onClick="javascript:printbillreport2()" name="resetbutton22" type="button" id="resetbutton22"  style="border: 1px solid #001E6A" />
</span></td>
              <td width="4%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="6%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="3%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="13%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="13%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="3%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Print</strong></div></td>
              <td width="7%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Supplier </strong></td>
              <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Location </strong></td>
              <td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Particulars </strong></div></td>
              <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Bill Amount</strong></div></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Paid Amount </strong></div></td>
              <td width="4%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Cash</strong></div></td>
              <td width="4%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Credit</strong></div></td>
              <td width="4%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Card</strong></div></td>
              <td width="4%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Online</strong></div></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Cheque</strong></div></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Adjust</strong></div></td>
              <td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date </strong></div></td>
              <td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="justify"><strong>Mode </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="justify"><strong>Cheque No. </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="justify"><strong>Cheque Date </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="justify"><strong>Bank Name </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Remarks</strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Delete</strong></div></td>
            </tr>
			<?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

		  //$query2 = "select * from master_transaction where suppliername like '%$suppliername%' and transactiontype = 'PAYMENT' and approvalstatus = 'APPROVED' and recordstatus <> 'DELETED' and customeranum = '0' and customername = '' and companyanum = '$companyanum' and transactiondate between '$paymentreceiveddatefrom' and '$paymentreceiveddateto' order by transactiondate desc"; // and transactiontype = 'PAYMENT'
		  $query2 = "select * from master_transactionpharmacy where suppliername like '%$suppliername%' and transactiontype = 'PAYMENT' and recordstatus <> 'DELETED' and customeranum = '0' and customername = '' and companyanum = '$companyanum' and transactiondate between '$paymentreceiveddatefrom' and '$paymentreceiveddateto' order by transactiondate desc"; // and transactiontype = 'PAYMENT'
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $rowcount2 = mysqli_num_rows($exec2);
		  if ($rowcount2 != 0)
		  {
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
     	  $receiptanum = $res2['auto_number'];
		  $paymentamount = '0.00';

		  $res2anum = $res2['supplieranum'];
		  $dateofpayment = $res2['transactiondate'];
		  $typeofpayment = $res2['particulars'];
		  $cashamount = $res2['cashamount'];
		  $creditamount = $res2['creditamount'];
		  $onlineamount = $res2['onlineamount'];
		  $cardamount = $res2['cardamount'];
		  $chequeamount = $res2['chequeamount'];
		  $tdsamount = $res2['tdsamount'];
		  $writeoffamount = $res2['writeoffamount'];
		  $balanceamount = $res2['balanceamount'];
		  $transactionamount = $res2['transactionamount'];
		  
			$suppliername = $res2['suppliername'];
			$totalamount = $res2['transactionamount'];
			$paymentdate = $res2['transactiondate'];
			$paymentmode = $res2['transactionmode'];
			$chequenumber = $res2['chequenumber'];
			$chequedate = $res2['chequedate'];
			$chequedate = substr($chequedate, 0, 11);
			$bankname = $res2['bankname'];
			$bankbranch = $res2['bankbranch'];
			$remarks = $res2['remarks'];
		  $snocount = $snocount + 1;
			$query3 = "select * from master_supplier where auto_number = '$res2anum'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$res3city = $res3['city'];

			//echo $cashamount;

		  if ($cashamount != '0.00') { $paymentamount = $cashamount; }
		  if ($creditamount != '0.00') { $paymentamount = $creditamount; }
		  if ($onlineamount != '0.00') { $paymentamount = $onlineamount; }
		  if ($cardamount != '0.00') { $paymentamount = $cardamount; }
		  if ($chequeamount != '0.00') { $paymentamount = $chequeamount; }
		  if ($tdsamount != '0.00') { $paymentamount = $tdsamount; }
		  if ($writeoffamount != '0.00') { $paymentamount = $writeoffamount; }
		
			
			if ($paymentamount != '0.00')
			{
			
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
			  <div align="center"> 
			  <a href="#" class="bodytext31" onClick="return funcPrintReceipt1('<?php echo $receiptanum; ?>')" >Print</a>			  </div>			  </td>
              <td class="bodytext31" valign="center"  align="left">
			  
                <div class="bodytext31"><?php echo $suppliername; ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res3city; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $typeofpayment; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo $totalamount; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $paymentamount; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $cashamount; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $creditamount; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $cardamount; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $onlineamount; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $chequeamount; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $writeoffamount; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="left"><?php echo $paymentdate; ?></a></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="left"><?php echo $paymentmode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div align="left"><?php echo $chequenumber; ?></a></div></td><td class="bodytext31" valign="center"  align="left">
				<div align="left"><?php echo $chequedate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="left"><?php echo $bankname.' '.$bankbranch; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="left"><?php echo $remarks; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="center">&nbsp;
                      <?php
			   $transactiontype = $res2['transactiontype'];
			   $transactionmodule = $res2['transactionmodule'];
			   if ($transactiontype == 'PAYMENT' && $transactionmodule == 'PAYMENT')
			   {
				$query1editdelete = "select * from master_employee where username = '$username'";
				$exec1editdelete = mysqli_query($GLOBALS["___mysqli_ston"], $query1editdelete) or die ("Error in Query1editdelete".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res1editdelete = mysqli_fetch_array($exec1editdelete);
				$option_edit_delete = $res1editdelete["option_edit_delete"];
				if ($option_edit_delete == 'Edit Delete Option Available' || $option_edit_delete == '')
				{
			   ?>
                      <a href="paymentdelete1.php?task=delete&&anum=<?php echo $receiptanum; ?>" onClick="return funcDeletePayment1(<?php echo $snocount;?>)" class="bodytext3"> <img src="images/b_drop.png" width="16" height="16" border="0"> </a>
                      <?php
					  }
			  }
			  ?>
              </div></td>
           </tr>
			<?php
			}
			
			$looptotalpaidamount = $paymentamount + $looptotalpaidamount;
			$looptotalpendingamount = $pendingamount + $looptotalpendingamount;
			$looptotalwriteoffamount = $writeoffamount + $looptotalwriteoffamount;
			$looptotalcashamount = $cashamount + $looptotalcashamount;
			$looptotalcreditamount = $creditamount + $looptotalcreditamount;
			$looptotalcardamount = $cardamount + $looptotalcardamount;
			$looptotalonlineamount = $onlineamount + $looptotalonlineamount;
			$looptotalchequeamount = $chequeamount + $looptotalchequeamount;
			$looptotaltdsamount = $tdsamount + $looptotaltdsamount;
			$looptotalwriteoffamount = $writeoffamount + $looptotalwriteoffamount;
			
			
			}
			}
		    
			$looptotalpaidamount = number_format($looptotalpaidamount, 2, '.', '');
			$looptotalpendingamount = number_format($looptotalpendingamount, 2, '.', '');
			$looptotalwriteoffamount = number_format($looptotalwriteoffamount, 2, '.', '');
			$looptotalcashamount = number_format($looptotalcashamount, 2, '.', '');
			$looptotalcreditamount = number_format($looptotalcreditamount, 2, '.', '');
			$looptotalcardamount = number_format($looptotalcardamount, 2, '.', '');
			$looptotalonlineamount = number_format($looptotalonlineamount, 2, '.', '');
			$looptotalchequeamount = number_format($looptotalchequeamount, 2, '.', '');
			$looptotaltdsamount = number_format($looptotaltdsamount, 2, '.', '');
			$looptotalwriteoffamount = number_format($looptotalwriteoffamount, 2, '.', '');

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

                bgcolor="#ecf0f5"><div align="right"><strong><!--Total--> </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php //echo $looptotalpaidamount; ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php //echo $looptotalcashamount; ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php //echo $looptotalcreditamount; ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php //echo $looptotalcardamount; ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php //echo $looptotalonlineamount; ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php //echo $looptotalchequeamount; ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php //echo $looptotalwriteoffamount; ?></strong></div></td>
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
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

