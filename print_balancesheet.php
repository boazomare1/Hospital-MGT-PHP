<?php
session_start();
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

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="BalanceSheet.xls"');
header('Cache-Control: max-age=80');

?>
</head>

<script src="js/datetimepicker_css.js"></script>

<body>
           <table width="292" border="0" 
            align="left" cellpadding="4" cellspacing="0" 
            bordercolor="#666666" id="AutoNumber3" style="BORDER-COLLAPSE: collapse">
          <tbody>
		  <tr>
              <td colspan="4" bgcolor="#FFFFFF" class="bodytext3" align="center"><strong> Balance Sheet</strong></td>
              </tr>
		
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
			
			$query51 = "select sum(amount) as totaldepositrefund from deposit_refund where recorddate between '$ADate1' and '$ADate2'";
			$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res51 = mysqli_fetch_array($exec51);
			$totaldepositrefund = $res51['totaldepositrefund'];
			 

			$patientdeposts = $totalipdepositamount8 + $totaladvancedepositamount8 -$totaldepositrefund;
			
			
			$query657 = "select sum(deposit) as totalbilldeposit from billing_ip where billdate between '$ADate1' and '$ADate2'";
			$exec657 = mysqli_query($GLOBALS["___mysqli_ston"], $query657) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res657 = mysqli_fetch_array($exec657);
			$totalbilldeposit = $res657['totalbilldeposit'];
			
			
			$query6571 = "select sum(deposit) as totalbilldeposit from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2'";
			$exec6571 = mysqli_query($GLOBALS["___mysqli_ston"], $query6571) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res6571 = mysqli_fetch_array($exec6571);
			$totalbilldepositapprovedcredit = $res6571['totalbilldeposit'];
			$patientdeposts1 = $totalbilldeposit + $totalbilldepositapprovedcredit;
			
			$patientdeposts = $patientdeposts - $patientdeposts1;
			
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
			
           <tr>
              <td width="249"  align="left" valign="center" class="bodytext31"><strong>Current Assets</strong></td>
              <td width="71"  align="left" valign="center" class="bodytext31"></td>
           </tr>
		   <tr >
              <td width="249"  align="left" valign="center" class="bodytext31"><strong>Inventory</strong></td>
              <td width="71"  align="right" valign="center" class="bodytext31" style="mso-number-format:'\@' "><?php echo number_format($grandtotalinventoryvalue,2,'.',','); ?></td>
           </tr>
		    <tr >
              <td width="249"  align="left" valign="center" class="bodytext31"><strong>Accounts Receivable</strong></td>
              <td width="71"  align="right" valign="center" class="bodytext31" style="mso-number-format:'\@' "><?php echo number_format($newtotalbalanceamount,2,'.',','); ?></td>
           </tr>
		    <tr >
              <td width="249"  align="left" valign="center" class="bodytext31"><strong>NHIF Receivable</strong></td>
              <td width="71"  align="right" valign="center" class="bodytext31" style="mso-number-format:'\@' "><?php echo number_format($totalnhif,2,'.',','); ?></td>
           </tr>
		   <tr >
              <td width="249"  align="left" valign="center" class="bodytext31"><strong>Bank and Cash</strong></td>
              <td width="71"  align="right" valign="center" class="bodytext31" style="mso-number-format:'\@' "><?php echo number_format($cashflowamount,2,'.',','); ?></td>
           </tr>
		  <tr >
              <td class="bodytext31" valign="center"  align="left"><strong>Fixed Assets</strong></td>
              <td class="bodytext31" valign="center"  align="right" style="mso-number-format:'\@' "><?php echo number_format($totalfixedassets,2,'.',','); ?> </td>
           </tr>
		    <tr >
              <td class="bodytext31" valign="center"  align="left"><strong>Less Accumulated Depreciation</strong></td>
              <td class="bodytext31" valign="center"  align="right" style="mso-number-format:'\@' "><?php echo number_format($totaldepreciation,2,'.',','); ?> </td>
           </tr>
		    <tr >
              <td class="bodytext31" valign="center"  align="left"><strong>Net Fixed Asset Value</strong></td>
              <td class="bodytext31" valign="center"  align="right" style="mso-number-format:'\@' "><?php echo number_format($netexpense,2,'.',','); ?> </td>
           </tr>
			<tr >
              <td class="bodytext31" valign="center"  align="left"><strong>Total Assets</strong></td>
              <td class="bodytext31" valign="center"  align="right" style="mso-number-format:'\@' "><?php echo number_format($totalassets,2,'.',','); ?> </td>
           </tr>
		   <tr >
              <td class="bodytext31" valign="center"  align="left"></td>
              <td class="bodytext31" valign="center"  align="right"></td>
           </tr>
		   <tr >
              <td class="bodytext31" valign="center"  align="left"></td>
              <td class="bodytext31" valign="center"  align="right"></td>
           </tr>
		    <tr >
              <td class="bodytext31" valign="center"  align="left"><strong>Current Liabilities</strong></td>
              <td class="bodytext31" valign="center"  align="right"> </td>
           </tr>
		    <tr >
              <td class="bodytext31" valign="center"  align="left"><strong>Accounts Payable</strong></td>
              <td class="bodytext31" valign="center"  align="right" style="mso-number-format:'\@' "><?php echo number_format($balanceamount1,2,'.',','); ?> </td>
           </tr>
		    <tr >
              <td class="bodytext31" valign="center"  align="left"><strong>Tax Liability</strong></td>
              <td class="bodytext31" valign="center"  align="right" style="mso-number-format:'\@' "><?php echo number_format($taxamount,2,'.',','); ?> </td>
           </tr>
		   <tr >
              <td class="bodytext31" valign="center"  align="left"><strong>Patient Deposits</strong></td>
              <td class="bodytext31" valign="center"  align="right" style="mso-number-format:'\@' "><?php echo number_format($patientdeposts,2,'.',','); ?> </td>
           </tr>
		    <tr >
              <td class="bodytext31" valign="center"  align="left"><strong>Opening Stock</strong></td>
              <td class="bodytext31" valign="center"  align="right" style="mso-number-format:'\@' "><?php echo number_format($openingstockamount,2,'.',','); ?> </td>
           </tr>
		   <tr >
              <td class="bodytext31" valign="center"  align="left"><strong>Equity</strong></td>
              <td class="bodytext31" valign="center"  align="right" style="mso-number-format:'\@' "><?php echo number_format($capital,2,'.',','); ?> </td>
           </tr>
		  <!-- <tr >
              <td width="249"  align="left" valign="center" class="bodytext31"><strong>Other Incomes</strong></td>
              <td width="71"  align="left" valign="center" class="bodytext31"><?php echo number_format($totalreceiptcreditamount81,2,'.',','); ?> </td>
           </tr>-->
		   <tr >
              <td class="bodytext31" valign="center"  align="left"><strong>Profit & Loss</strong></td>
              <td class="bodytext31" valign="center"  align="right" style="mso-number-format:'\@' "><?php echo number_format($netincome,2,'.',','); ?> </td>
           </tr>
		    <tr >
              <td class="bodytext31" valign="center"  align="left"><strong>Total Liabilities</strong></td>
              <td class="bodytext31" valign="center"  align="right" style="mso-number-format:'\@' "><?php echo number_format($totalliabilities,2,'.',','); ?> </td>
           </tr>
		      		  </tbody>
        </table></td>
      </tr>
		<?php
			}
			?>
         
</table>
</body>
</html>
