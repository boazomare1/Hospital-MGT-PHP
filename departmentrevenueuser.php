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
$total = '0.00';
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

if (isset($_REQUEST["department"])) { $department = $_REQUEST["department"]; } else { $department = ""; }
//echo $department;
$query111 = "select * from master_department where auto_number = '$department'";
$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in query111".mysqli_error($GLOBALS["___mysqli_ston"]));
$res111 = mysqli_fetch_array($exec111);
$res111department = $res111['department'];

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
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
             <form name="cbform1" method="post" action="departmentrevenueuser.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Department Revenue</strong>&nbsp;&nbsp;&nbsp;<a href="#" onClick="viewReport();"><strong>W</strong></a></td>
                      <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                      <td bgcolor="#ecf0f5" class="bodytext3" colspan="2">&nbsp;</td>
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
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
					  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Search" name="Submit" />
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="602" 
            align="left" border="0">
          <tbody>
		  <?php
            if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
		    if ($cbfrmflag1 == 'cbfrmflag1')
			{
			?>
            <tr>
              <td width="108"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>&nbsp;</strong></td>
              <td width="154" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Laboratory</strong></div></td>
              <td width="154" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Radiology</strong></div></td>
				 <td width="154" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Services</strong></div></td>

            </tr>
			
			<?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			
			
		 
		  include("labrevenuecalculation.php");
		  include("radiologyrevenuecalculation.php");
		  include("servicerevenuecalculation.php");
		  
		  
		  $query661 = "select sum(costofsales) as labcogs from cogsentry where coa='02-2003' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec661 = mysqli_query($GLOBALS["___mysqli_ston"], $query661) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res661 = mysqli_fetch_array($exec661);
		  $labcogs = $res661['labcogs'];
		  
		  $query6611 = "select sum(costofsales) as labcogs from cogsentry where coa='02-2004' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6611 = mysqli_query($GLOBALS["___mysqli_ston"], $query6611) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6611 = mysqli_fetch_array($exec6611);
		  $labcogs1 = $res6611['labcogs'];
		  
		  $totallabcogs = $labcogs + $labcogs1;
		  
		   $query663 = "select sum(costofsales) as radiologycogs from cogsentry where coa='02-2007' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec663 = mysqli_query($GLOBALS["___mysqli_ston"], $query663) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res663 = mysqli_fetch_array($exec663);
		  $radiologycogs = $res663['radiologycogs'];
		  
		  $query6631 = "select sum(costofsales) as radiologycogs from cogsentry where coa='02-2008' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6631 = mysqli_query($GLOBALS["___mysqli_ston"], $query6631) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6631 = mysqli_fetch_array($exec6631);
		  $radiologycogs1 = $res6631['radiologycogs'];
		  
		  $totalradiologycogs = $radiologycogs + $radiologycogs1;
		  
		   $query664 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2009' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec664 = mysqli_query($GLOBALS["___mysqli_ston"], $query664) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res664 = mysqli_fetch_array($exec664);
		  $servicecogs = $res664['servicecogs'];
		  
		   $query6641 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2002' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6641 = mysqli_query($GLOBALS["___mysqli_ston"], $query6641) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6641 = mysqli_fetch_array($exec6641);
		  $servicecogs1 = $res6641['servicecogs'];
		  
		   $query6642 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2006' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6642 = mysqli_query($GLOBALS["___mysqli_ston"], $query6642) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6642 = mysqli_fetch_array($exec6642);
		  $servicecogs2 = $res6642['servicecogs'];
		  
		  $query6643 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2008' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6643 = mysqli_query($GLOBALS["___mysqli_ston"], $query6643) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6643 = mysqli_fetch_array($exec6643);
		  $servicecogs3 = $res6643['servicecogs'];
		  
		  $query6644 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2010' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6644 = mysqli_query($GLOBALS["___mysqli_ston"], $query6644) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6644 = mysqli_fetch_array($exec6644);
		  $servicecogs4 = $res6644['servicecogs'];
		  
		  $query6645 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2011' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6645 = mysqli_query($GLOBALS["___mysqli_ston"], $query6645) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6645 = mysqli_fetch_array($exec6645);
		  $servicecogs5 = $res6645['servicecogs'];
		  
    	  $query6646 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2012' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6646 = mysqli_query($GLOBALS["___mysqli_ston"], $query6646) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6646 = mysqli_fetch_array($exec6646);
		  $servicecogs6 = $res6646['servicecogs'];
		  
		  $query6647 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2013' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6647 = mysqli_query($GLOBALS["___mysqli_ston"], $query6647) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6647 = mysqli_fetch_array($exec6647);
		  $servicecogs7 = $res6647['servicecogs'];
		  
		   $query6648 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2014' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6648 = mysqli_query($GLOBALS["___mysqli_ston"], $query6648) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6648 = mysqli_fetch_array($exec6648);
		  $servicecogs8 = $res6648['servicecogs'];
		  
		  $totalservicecogs = $servicecogs1 + $servicecogs2 + $servicecogs3 + $servicecogs4 + $servicecogs5 + $servicecogs6 + $servicecogs7 + $servicecogs8;
		  
		  $nettlab = $total - $totallabcogs;
		  $nettradiology = $totalradiology - $totalradiologycogs;
		  $nettservice = $totalservice - $totalservicecogs;





		  
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
              <td class="bodytext31" valign="center"  align="left"><strong>Income</strong></td>
               <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($total,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($totalradiology,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($totalservice,2,'.',','); ?></div></td>

             
           </tr>
			<?php
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
              <td class="bodytext31" valign="center"  align="left"><strong>COGS</strong></td>
               <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($totallabcogs,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($totalradiologycogs,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($totalservicecogs,2,'.',','); ?></div></td>

             
           </tr>
		   <?php
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
              <td class="bodytext31" valign="center"  align="left"><strong>Nett</strong></td>
               <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong><?php echo number_format($nettlab,2,'.',','); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong><?php echo number_format($nettradiology,2,'.',','); ?></strong></div></td>
				  <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong><?php echo number_format($nettservice,2,'.',','); ?></strong></div></td>

             
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

             
            </tr>
			<?php
			
			}
			?>
            
          </tbody>
        </table></td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

