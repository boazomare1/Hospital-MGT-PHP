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
$visitcode1 = '';
$total = '';
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
$accountname = '';

if (isset($_REQUEST["accountname"])) { $accountname = $_REQUEST["accountname"]; } else { $accountname = ""; }

if (isset($_REQUEST["consultingdoctor"])) { $consultingdoctor = $_REQUEST["consultingdoctor"]; } else { $consultingdoctor = ""; }

$query111 = "select * from master_doctor where auto_number = '$consultingdoctor'";
$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in query111".mysqli_error($GLOBALS["___mysqli_ston"]));
$res111 = mysqli_fetch_array($exec111);
$res111doctorname = $res111['doctorname'];

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

	//$cbsuppliername = $_REQUEST['cbsuppliername'];
	//$suppliername = $_REQUEST['cbsuppliername'];
	$paymentreceiveddatefrom = $_REQUEST['ADate1'];
	$paymentreceiveddateto = $_REQUEST['ADate2'];
	$visitcode1 = 10;

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
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
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
<script>
function viewReport()
 {
window.open("<?php echo basename($_SERVER['PHP_SELF']); ?>","OriginalWindowA4",'width=922,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
  }
</script>
<script src="js/datetimepicker_css.js"></script>

<body>
<table width="1900" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="doctorutilizationreportuser.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Doctor Utilization Report</strong>&nbsp;&nbsp;&nbsp;<a href="#" onClick="viewReport();"><strong>W</strong></a></td>
                      <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                      <td bgcolor="#ecf0f5" class="bodytext3" colspan="2">&nbsp;</td>
                    </tr>
					<!--<tr>
			 <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Consulting Doctor </td>
				  <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><strong>
				    <select name="consultingdoctor" id="consultingdoctor">
                      <option value="">Select Doctor</option>
                      <?php
				     $query51 = "select * from master_doctor where status <> 'deleted' ";
				     $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				     while ($res51 = mysqli_fetch_array($exec51))
				       {
				       $res51anum = $res51["auto_number"];
				       $res51doctorname = $res51["doctorname"];
				       ?>
					  
                      <option value="<?php echo $res51anum; ?>" ><?php echo $res51doctorname; ?></option>
                      <?php
				     }
				  ?>
                    </select>
				  </strong></td>
			</tr>-->
                    <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
					  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="600" 
            align="left" border="0">
          <tbody>
            <!--<tr>
			<td width="5%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td colspan="30" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
            </tr>
			<tr>
			<td bgcolor="#ffffff">&nbsp;</td>
			</tr>-->
			<?php 
		  
		  
		  //print_r($paymenttypename); 
		  
		  ?>
		  
		  <?php 
		  if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
		  $query15 = "select * from master_consultationlist group by username";
		  $exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res15 = mysqli_fetch_array($exec15))
		  {
		  $doctorname = $res15['username'];
		  
		  ?>
		  <tr>
			<td width="5%" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo $doctorname; ?></strong></td>
              <td colspan="30" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
            </tr>
			<tr>
			<td bgcolor="#ffffff">&nbsp;</td>
		  <?php
		  
		  $paymenttypename = array();
		  
		  $query21 = "select * from master_paymenttype where recordstatus <> 'deleted'"; 
		  $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res21 = mysqli_fetch_array($exec21))
		  {
		  $res21paymenttype = $res21['paymenttype'];
		  array_push($paymenttypename, $res21paymenttype);
		  ?>
		 
		  <td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><strong><?php echo $res21paymenttype; ?></strong></td>
		  <?php 
		  }
?>	
		 </tr>
		  <tr>
		  <td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5"><strong>Revenue</strong></td> 
		  
		  <?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$totalcashamount = '0.00';
			$revenueamountfinal = '0.00';
			$billnumberamountfinal = '0.00';
			$averagecostfinal = '0.00';
			$billnumbercount ='0.00';
			
$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

		  $revenueamountfinal = array();
		  $billnumberamountfinal = array();
		  $averagecostfinal = array();
	 

		  $query2 = "select * from master_paymenttype where recordstatus <> 'deleted'"; 
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
			  $res2auto_number = $res2['auto_number'];
			  $res2paymenttype = $res2['paymenttype'];
			  $res3transactionamount = '0';
			  $res4totalamount = '0';
			  $res5totalamount = '0';
			  $query16 = "select * from master_consultationlist where username = '$doctorname'";
			  $exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while ($res16 = mysqli_fetch_array($exec16))
			  {
			  $visitcode = $res16['visitcode'];
			  $query3 = "select sum(transactionamount) as transactionamount1, count(billnumber) as billnumber1 from master_transactionpaynow where paymenttype = '$res2paymenttype' and visitcode = '$visitcode' and transactionamount <>'0.00' and transactiondate between '$ADate1' and '$ADate2'"; 
			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res3 = mysqli_fetch_array($exec3);
			  $res3transactionamount += $res3['transactionamount1'];
			  $res3billnumber = $res3['billnumber1'];
			  
			  $query4 = "select sum(totalamount) as totalamount1, count(billnumber) as billnumber1 from master_billing where paymenttype = '$res2paymenttype' and visitcode = '$visitcode' and totalamount <> '0.00' and billingdatetime between '$ADate1' and '$ADate2'"; 
			  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res4 = mysqli_fetch_array($exec4);
			  $res4totalamount += $res4['totalamount1'];
			  $res4billnumber = $res4['billnumber1'];
			  
			  $query5 = "select sum(transactionamount) as transactionamount1, count(billnumber) as billnumber1 from master_transactionpaylater where paymenttype = '$res2paymenttype' and visitcode = '$visitcode' and transactiontype = 'finalize' and transactionamount <>'0.00' and transactiondate between '$ADate1' and '$ADate2'"; 
			  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res5 = mysqli_fetch_array($exec5);
			  $res5totalamount += $res5['transactionamount1'];
			  $res5billnumber = $res5['billnumber1'];
			  }
			  $revenueamount = $res3transactionamount + $res4totalamount + $res5totalamount;
			  $billnumbercount = $res3billnumber + $res4billnumber + $res5billnumber;
			  
			  if($billnumbercount != 0)
			  {
			  $averagecost = $revenueamount/$billnumbercount;
			  }
			  else 
			  {
			  $averagecost = $revenueamount/1;
			  }
			  array_push($revenueamountfinal, $revenueamount);
			  array_push($billnumberamountfinal, $billnumbercount);
			  array_push($averagecostfinal,$averagecost);
	
			 
		 
		  //print_r($revenueamountfinal);
		  
		  $snocount = $snocount + 1;
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
			
		  <td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5"><strong><?php  echo number_format($revenueamount,2,'.',','); ?></strong></td>			
		<!-- <tr>
		 <td class="bodytext31" valign="center"  align="left">Revenue</td>
		 </tr>-->
			<?php
			}
			
			?>
			</tr>
		    <tr>
		   <td class="bodytext31" valign="center"  align="left" bgcolor="#CBDBFA"><strong>Count</strong></td> 
		  <?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$totalcashamount = '0.00';
			$revenueamountfinal = '0.00';
			$billnumberamountfinal = '0.00';
			$averagecostfinal = '0.00';
			$billnumbercount ='0.00';
			
          $paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

		  $revenueamountfinal = array();
		  $billnumberamountfinal = array();
		  $averagecostfinal = array();
	  

		  $query2 = "select * from master_paymenttype where recordstatus <> 'deleted'"; 
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
			  $res2auto_number = $res2['auto_number'];
			  $res2paymenttype = $res2['paymenttype'];
			  $res3transactionamount = '0';
			  $res4totalamount = '0';
			  $res5totalamount = '0';
			  $res3billnumber = '0';
			  $res4billnumber = '0';
			  $res5billnumber = '0';
			  $query16 = "select * from master_consultationlist where username = '$doctorname'";
			  $exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while ($res16 = mysqli_fetch_array($exec16))
			  {
			  $visitcode = $res16['visitcode'];
			  $query3 = "select sum(transactionamount) as transactionamount1, count(billnumber) as billnumber1 from master_transactionpaynow where paymenttype = '$res2paymenttype' and visitcode = '$visitcode' and transactionamount <>'0.00' and transactiondate between '$ADate1' and '$ADate2'"; 
			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res3 = mysqli_fetch_array($exec3);
			  $res3transactionamount += $res3['transactionamount1'];
			  $res3billnumber += $res3['billnumber1'];
			  
			  $query4 = "select sum(totalamount) as totalamount1, count(billnumber) as billnumber1 from master_billing where paymenttype = '$res2paymenttype' and visitcode = '$visitcode' and totalamount <> '0.00' and billingdatetime between '$ADate1' and '$ADate2'"; 
			  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res4 = mysqli_fetch_array($exec4);
			  $res4totalamount += $res4['totalamount1'];
			  $res4billnumber += $res4['billnumber1'];
			  
			  $query5 = "select sum(transactionamount) as transactionamount1, count(billnumber) as billnumber1 from master_transactionpaylater where paymenttype = '$res2paymenttype' and visitcode = '$visitcode' and transactiontype = 'finalize' and transactionamount <>'0.00' and transactiondate between '$ADate1' and '$ADate2'"; 
			  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res5 = mysqli_fetch_array($exec5);
			  $res5totalamount += $res5['transactionamount1'];
			  $res5billnumber += $res5['billnumber1'];
			  }
			  $revenueamount = $res3transactionamount + $res4totalamount + $res5totalamount;
			  $billnumbercount = $res3billnumber + $res4billnumber + $res5billnumber;
			  
			  if($billnumbercount != 0)
			  {
			  $averagecost = $revenueamount/$billnumbercount;
			  }
			  else 
			  {
			  $averagecost = $revenueamount/1;
			  }
			  array_push($revenueamountfinal, $revenueamount);
			  array_push($billnumberamountfinal, $billnumbercount);
			  array_push($averagecostfinal,$averagecost);
			  
		  $snocount = $snocount + 1;
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
			  <td class="bodytext31" valign="center"  align="left" bgcolor="#CBDBFA"><strong><?php echo number_format($billnumbercount,2,'.',','); ?></strong></td>
			 
			<?php
			}
			?>
			  </tr>
			  <tr>
		   <td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5"><strong>Avg Cost</strong></td> 
		  <?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$totalcashamount = '0.00';
			$revenueamountfinal = '0.00';
			$billnumberamountfinal = '0.00';
			$averagecostfinal = '0.00';
			$billnumbercount ='0.00';
			
$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

		  $revenueamountfinal = array();
		  $billnumberamountfinal = array();
		  $averagecostfinal = array();
	  

		  $query2 = "select * from master_paymenttype where recordstatus <> 'deleted'"; 
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
			  $res2auto_number = $res2['auto_number'];
			  $res2paymenttype = $res2['paymenttype'];
			  $res3transactionamount = '0';
			  $res4totalamount = '0';
			  $res5totalamount = '0';
			  $query16 = "select * from master_consultationlist where username = '$doctorname'";
			  $exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while ($res16 = mysqli_fetch_array($exec16))
			  {
			  $visitcode = $res16['visitcode'];
			  $query3 = "select sum(transactionamount) as transactionamount1, count(billnumber) as billnumber1 from master_transactionpaynow where paymenttype = '$res2paymenttype' and visitcode = '$visitcode' and transactionamount <>'0.00' and transactiondate between '$ADate1' and '$ADate2'"; 
			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res3 = mysqli_fetch_array($exec3);
			  $res3transactionamount += $res3['transactionamount1'];
			  $res3billnumber = $res3['billnumber1'];
			  
			  $query4 = "select sum(totalamount) as totalamount1, count(billnumber) as billnumber1 from master_billing where paymenttype = '$res2paymenttype' and visitcode = '$visitcode' and totalamount <> '0.00' and billingdatetime between '$ADate1' and '$ADate2'"; 
			  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res4 = mysqli_fetch_array($exec4);
			  $res4totalamount += $res4['totalamount1'];
			  $res4billnumber = $res4['billnumber1'];
			  
			  $query5 = "select sum(transactionamount) as transactionamount1, count(billnumber) as billnumber1 from master_transactionpaylater where paymenttype = '$res2paymenttype' and visitcode = '$visitcode' and transactiontype = 'finalize' and transactionamount <>'0.00' and transactiondate between '$ADate1' and '$ADate2'"; 
			  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res5 = mysqli_fetch_array($exec5);
			  $res5totalamount += $res5['transactionamount1'];
			  $res5billnumber = $res5['billnumber1'];
			  }
			  $revenueamount = $res3transactionamount + $res4totalamount + $res5totalamount;
			  $billnumbercount = $res3billnumber + $res4billnumber + $res5billnumber;
			  
			  if($billnumbercount != 0)
			  {
			  $averagecost = $revenueamount/$billnumbercount;
			  }
			  else 
			  {
			  $averagecost = $revenueamount/1;
			  }
			  array_push($revenueamountfinal, $revenueamount);
			  array_push($billnumberamountfinal, $billnumbercount);
			  array_push($averagecostfinal,$averagecost);
			  
		  $snocount = $snocount + 1;
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
			
           
			  <td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5"><strong><?php echo number_format($averagecost, 2, '.',','); ?></strong></td>
			<?php
			}
			?>
			</tr>
			<?php
			}
			}
			?>
			
            <tr>
              <td colspan="30" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
            </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

