<?php
session_start();
//include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
//$username = $_SESSION['username'];
//$companyanum = $_SESSION['companyanum'];
//$companyname = $_SESSION['companyname'];
//$companycode = $_SESSION['companycode'];

$username = '';
$companyanum = '';
$companyname = '';
$financialyear = '';

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

$cbcustomername = '';
$cbbillnumber = '';
$customername = '';
$paymenttype = '';
$billstatus = '';
$res2loopcount = '';
$custid = '';
$custname = '';
$colorloopcount = '';
$sno = '';
$docnumber = '';

$totalsumtotalamount1  = '';
$totalsumcashamount1  = '';
$totalsumchequeamount1  = '';
$totalsumonlineamount1  = '';
$totalsumcardamount1 = '';
$totalsumcreditamount1 = '';
$totalsumbalancebillamount1 = '';
$totalsumsubtotal1 = '';
$totalsumtotaltax1 = '';
$totalpackaging1 = '';
$totaldelivery1 = '';

if ($companyanum == '')
{
	$companyanum = $_GET['companyanum'];
	$companyname = $_GET['companyname'];
}
//echo $companyanum;
//echo $companyname;

$query1 = "select * from master_company where auto_number = '$companyanum'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$companyname = $res1['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

if (isset($_REQUEST["paymenttype"])) { $paymenttype = $_REQUEST["paymenttype"]; } else { $paymenttype = ""; }
//$paymenttype = $_REQUEST['paymenttype'];

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_customer where auto_number = '$getcanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbcustomername = $res4['customername'];
	$customername = $res4['customername'];
}



//$cbfrmflag1 = $_POST['cbfrmflag1'];
//if ($cbfrmflag1 == 'cbfrmflag1')
//if ($transactiondatefrom != '')
//{

	if (isset($_REQUEST["searchcustomername"])) { $searchcustomername = $_REQUEST["searchcustomername"]; } else { $searchcustomername = ""; }
	//$searchcustomername = $_POST['searchcustomername'];
	if ($searchcustomername != '')
	{
		$arraycustomer = explode("#", $searchcustomername);
		$arraycustomername = $arraycustomer[0];
		$arraycustomername = trim($arraycustomername);
		$arraycustomercode = $arraycustomer[1];

		$cbcustomername = $arraycustomername;
		$customername = $arraycustomername;
	}
	else
	{
		$cbcustomername = $_REQUEST['cbcustomername'];
		$customername = $_REQUEST['cbcustomername'];
	}

	if ($_REQUEST['ADate1'] != '' && $_REQUEST['ADate2'] != '')
	{
		$transactiondatefrom = $_REQUEST['ADate1'];
		$transactiondateto = $_REQUEST['ADate2'];
	}
	else
	{
		$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
		$transactiondateto = date('Y-m-d');
	}

//}
//else
//{
	//exit;
//}


?>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
<script language="javascript">

function escapekeypressed()
{
	//alert(event.keyCode);
	if(event.keyCode=='27'){ window.close(); }
}

</script>
<!--onLoad="window.print();"-->

<body  onkeydown= "escapekeypressed()">
<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="1">
  <tbody>
  <tr>
              <td colspan="8" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Pharmacy Invoice Report</strong></div></td>
            </tr>
            <tr>
              <td colspan="8" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong><?php echo $companyname; ?></strong>&nbsp;</div></td>
            </tr>
            <tr>
              <td colspan="8" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong><?php echo 'Report Date From '.$transactiondatefrom.' To '.$transactiondateto; ?></strong></div></td>
            </tr>
        
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              
              <!--<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>PDF</strong></td>-->
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Doc No</strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Date </strong></div></td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong> Patient</strong></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Reg. No</strong></div></td>
             <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Visit</strong></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Account</strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Nett</strong></div></td>
              </tr>
           <?php
			
			if (isset($_REQUEST["approvalstatus"])) { $approvalstatus = $_REQUEST["approvalstatus"]; } else { $approvalstatus = ""; }
			//$approvalstatus = $_REQUEST['approvalstatus'];
			
			
			if ($billstatus == 'CONFIRMED')
			{
				$billstatusquery1 = " recordstatus <> 'deleted' ";
			}
			else if ($billstatus == '')
			{
				$billstatusquery1 = " recordstatus <> 'deleted' ";
			}
			else
			{
				$billstatusquery1 = " recordstatus = 'deleted' ";
			}

			/*
			if ($approvalstatus == '')
			{
				$approvalstatusquery1 = "and approvalstatus =  'APPROVED'";
			}
			if ($approvalstatus == 'ALL')
			{
				$approvalstatusquery1 = "";
			}
			else if ($approvalstatus == 'APPROVED')
			{
				$approvalstatusquery1 = "and approvalstatus =  'APPROVED'";
			}
			else if ($approvalstatus == 'PENDING')
			{
				$approvalstatusquery1 = "and approvalstatus =  'PENDING'";
			}
			else if ($approvalstatus == 'DENIED')
			{
				$approvalstatusquery1 = "and approvalstatus =  'DENIED'";
			}
			*/

			$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			//$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday, $dotyear));

			$billnumarray = explode('-', $cbbillnumber);
			//print_r($billnumarray);
			if (count($billnumarray) == 0)
			{
				$billnumberprefix = $billnumarray[0];
				$cbbillnumber = $billnumarray[1];
			}
			else
			{
				$billnumberprefix = '';
				$cbbillnumber = '';
			}
			if ($cbbillnumber == '') $cbbillnumber = $billnumberprefix;
			//echo $billnumber;
			//$cbbillnumber = $cbbillnumber;

			if (isset($_REQUEST["discountgiven"])) { $discountgiven = $_REQUEST["discountgiven"]; } else { $discountgiven = ""; }
			//$discountgiven = $_REQUEST['discountgiven'];
			if ($discountgiven == '') $discountgivensql = "";
			if ($discountgiven == 'DISCOUNT GIVEN') $discountgivensql = "subtotaldiscountpercentapply1 <> '0.00' and ";
			if ($discountgiven == 'DISCOUNT NOT GIVEN') $discountgivensql = "subtotaldiscountpercentapply1 = '0.00' and ";
			
           
			//$patientname1 = $res21['patientname'];
			$query2 = "select * from pharmacysales_details where patientname like '%$cbcustomername%' and docnumber like '%$docnumber%' and entrydate between '$transactiondatefrom' and '$transactiondateto' and $billstatusquery1";
			
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res2 = mysqli_fetch_array($exec2))
			{
			$res2anum = $res2['auto_number'];
			$billautonumber = $res2['auto_number'];
			$patientcode = $res2['patientcode'];
			$patientname = $res2['patientname'];
			$entrydate = $res2['entrydate'];
			$docnumber = $res2['docnumber'];
			$visitcode = $res2['visitcode'];
			$accountname = $res2['accountname'];
			$totalamount = $res2['totalamount'];
			$totalsumtotalamount1  = $totalsumtotalamount1 + $totalamount;
			
			
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				$colorcode = 'bgcolor="#ecf0f5"';
			}
		     $sno = $sno +1;
			?>
            <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $sno; ?></td>
              
              <td class="bodytext31" valign="center"  align="left"><div align="left"> 
			  <?php echo $docnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="left">
              <?php echo $entrydate; ?>
              </div></td>
			   <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
			  <?php echo $patientname; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
			  <?php echo $patientcode; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
			  <?php echo $visitcode; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
			  <?php echo $accountname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $totalamount; ?>&nbsp;</div></td>
              </tr>
				<?php
				}
				?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
               <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
				
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Total : </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"><strong><?php echo number_format($totalsumtotalamount1, 2, '.', '');; ?></strong></div></td>
              </tr>
          </tbody>
        </table>


<blockquote>&nbsp;</blockquote>
</body>


