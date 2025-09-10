<?php
//session_start();
//include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = '';
$companyanum = '';
$companyname = '';
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
$nettotal = '0.00';
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

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="oprevenue.xls"');
header('Cache-Control: max-age=80');


 $locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
if ($companyanum == '') //For print view.
{
	if (isset($_SESSION["username"])) { $username = $_SESSION["username"]; } else { $username = ""; }
	//$username = $_SESSION['username'];
	if (isset($_SESSION["companyanum"])) { $companyanum = $_SESSION["companyanum"]; } else { $companyanum = ""; }
	//$companyanum = $_SESSION['companyanum'];
	if (isset($_SESSION["companyname"])) { $companyname = $_SESSION["companyname"]; } else { $companyname = ""; }
	//$companyname = $_SESSION['companyname'];
	if (isset($_SESSION["financialyear"])) { $financialyear = $_SESSION["financialyear"]; } else { $financialyear = ""; }
	//$financialyear = $_SESSION['financialyear'];
}
if ($companyanum == '')  // For excel export.
{
	if (isset($_REQUEST["username"])) { $username = $_REQUEST["username"]; } else { $username = ""; }
	//$username = $_REQUEST['username'];
	if (isset($_REQUEST["companyanum"])) { $companyanum = $_REQUEST["companyanum"]; } else { $companyanum = ""; }
	//$companyanum = $_REQUEST['companyanum'];
	if (isset($_REQUEST["companyname"])) { $companyname = $_REQUEST["companyname"]; } else { $companyname = ""; }
	//$companyname = $_REQUEST['companyname'];
	if (isset($_REQUEST["financialyear"])) { $financialyear = $_REQUEST["financialyear"]; } else { $financialyear = ""; }
	//$financialyear = $_REQUEST['financialyear'];
}

if (isset($_REQUEST["accountname"])) { $accountname = $_REQUEST["accountname"]; } else { $accountname = ""; }

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
</head>


<body>
<table width="25%" border="0" cellspacing="0" cellpadding="0">
          <tbody>
            <tr>
              <td width="10%" bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
              <td colspan="2" bgcolor="#FFFFFF" class="bodytext31">
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
				}	
					?> 			</td>
            </tr>
            
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
				?>
			<?php
			
			$query1 = "select sum(billamount) as billamount1 from master_billing where locationcode='$locationcode' and billingdatetime between '$transactiondatefrom' and '$transactiondateto'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$res1consultationamount = $res1['billamount1'];
			
			 $snocount = $snocount + 1;
			 $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
			?>
             <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>No.</strong></td>
              <td align="left" valign="center" bgcolor="#FFFFFF" class="style3"><strong>Head</strong></td>
              <td align="right" valign="center" bgcolor="#FFFFFF" class="style3"><strong>Value</strong></td>
            </tr>
            
            <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left">
                <div class="bodytext31">Consultation</div>              </td>
               <td align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31"><div class="bodytext31"><?php echo number_format($res1consultationamount,2,'.',','); ?></div></td>
            </tr>
		   <?php
			
			$query2 = "select sum(labitemrate) as labitemrate1 from billing_paylaterlab where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2 = mysqli_fetch_array($exec2);
			$res2labitemrate = $res2['labitemrate1'];
			
			$query3 = "select sum(labitemrate) as labitemrate1 from billing_paynowlab where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$res3labitemrate = $res3['labitemrate1'];
			
			$query14 = "select sum(labitemrate) as labitemrate1 from billing_externallab where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";

			$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in query14".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res14 = mysqli_fetch_array($exec14);
			$res14labitemrate = $res14['labitemrate1'];
			
			$totallabitemrate = $res2labitemrate + $res3labitemrate + $res14labitemrate;
			
			$snocount = $snocount + 1;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
			?>
           <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left">
                <div class="bodytext31">Lab</div>              </td>
               <td align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31"><div class="bodytext31"><?php echo number_format($totallabitemrate,2,'.',','); ?></div></td>
            </tr>
		   <?php
			
			$query4 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paylaterradiology where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res4 = mysqli_fetch_array($exec4);
			$res4radiologyitemrate = $res4['radiologyitemrate1'];
			
			$query5 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paynowradiology where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res5 = mysqli_fetch_array($exec5);
			$res5radiologyitemrate = $res5['radiologyitemrate1'];
			
			$query15 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_externalradiology where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res15 = mysqli_fetch_array($exec15);
			$res15radiologyitemrate = $res15['radiologyitemrate1'];
			
			$totalradiologyitemrate = $res4radiologyitemrate + $res5radiologyitemrate + $res15radiologyitemrate;
			
			$snocount = $snocount + 1;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
			?>
           <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left">
                <div class="bodytext31">Radiology</div>              </td>
               <td align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31"><div class="bodytext31"><?php echo number_format($totalradiologyitemrate,2,'.',','); ?></div></td>
            </tr>
		   
		   <?php
			
			$query6 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paylaterservices where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res6 = mysqli_fetch_array($exec6);
			$res6servicesitemrate = $res6['servicesitemrate1'];
			
			$query7 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paynowservices where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res7 = mysqli_fetch_array($exec7);
			$res7servicesitemrate = $res7['servicesitemrate1'];
			
			$query16 = "select sum(servicesitemrate) as servicesitemrate1 from billing_externalservices where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res16 = mysqli_fetch_array($exec16);
			$res16servicesitemrate = $res16['servicesitemrate1'];
			
			$totalservicesitemrate = $res6servicesitemrate + $res7servicesitemrate + $res16servicesitemrate ;
			
			$snocount = $snocount + 1;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
			?>
           <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left">
                <div class="bodytext31">Service</div>              </td>
               <td align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31"><div class="bodytext31"><?php echo number_format($totalservicesitemrate,2,'.',','); ?></div></td>
            </tr>
		   
		   <?php
			
			$query8 = "select sum(amount) as amount1 from billing_paylaterpharmacy where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res8 = mysqli_fetch_array($exec8);
			$res8pharmacyitemrate = $res8['amount1'];
			
			$query9 = "select sum(amount) as amount1 from billing_paynowpharmacy where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res9 = mysqli_fetch_array($exec9);
			$res9pharmacyitemrate = $res9['amount1'];
			
			$query17 = "select sum(amount) as amount1 from billing_externalpharmacy where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query17".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res17 = mysqli_fetch_array($exec17);
			$res17pharmacyitemrate = $res17['amount1'];
			
			$totalpharmacyitemrate = $res8pharmacyitemrate + $res9pharmacyitemrate + $res17pharmacyitemrate;
			
			$snocount = $snocount + 1;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
			?>
           <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left">
                <div class="bodytext31">Pharmacy</div>              </td>
               <td align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31"><div class="bodytext31"><?php echo number_format($totalpharmacyitemrate,2,'.',','); ?></div></td>
            </tr>
		   
		   <?php
			
			$query10 = "select sum(referalrate) as referalrate1 from billing_paylaterreferal where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res10 = mysqli_fetch_array($exec10);
			$res10referalitemrate = $res10['referalrate1'];
			
			$query11 = "select sum(referalrate) as referalrate1 from billing_paynowreferal where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res11 = mysqli_fetch_array($exec11);
			$res11referalitemrate = $res11['referalrate1'];
			
			$totalreferalitemrate = $res10referalitemrate + $res11referalitemrate;
			
			$snocount = $snocount + 1;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
			?>
           <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left">
                <div class="bodytext31">Referral</div>              </td>
               <td align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31"><div class="bodytext31"><?php echo number_format($totalreferalitemrate,2,'.',','); ?></div></td>
            </tr>
		   <?php
			$nettotal = $res1consultationamount + $totallabitemrate + $totalradiologyitemrate + $totalservicesitemrate + $totalpharmacyitemrate + $totalreferalitemrate;
			?>
		
		   <?php 
		   }
		   ?>
            <tr>
              <td colspan="2"  class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF"><strong>Net Revenue:</strong></td>
              <td align="right" valign="center" 
                bgcolor="#FFFFFF" class="bodytext31"><strong><?php echo number_format($nettotal,2,'.',','); ?></strong></td>
		    </tr>
          </tbody>
</table>
</body>
</html>

