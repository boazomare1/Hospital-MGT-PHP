<?php
session_start();
//include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');

$username = '';
$companyanum = '';
$companyname = '';
$financialyear = '';

//Session Not Working on excel export. To get values from request below change is necessary.
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

$query1 = "select * from master_company where auto_number = '$companyanum'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$companyname = $res1['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$searchsuppliername = '';
$suppliername = '';
$totalsales = '0.00';
$colorloopcount = '';
$sno = '';
$totalbalance = '0.00';

$cashamount2 = '0.00';
$creditamount2 = '0.00';
$cardamount2 = '0.00';
$onlineamount2 = '0.00';
$chequeamount2 = '0.00';
$tdsamount2 = '0.00';
$writeoffamount2 = '0.00';

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

	$searchsuppliername = $_POST['searchsuppliername'];
	if ($searchsuppliername != '')
	{
		$arraysupplier = explode("#", $searchsuppliername);
		$arraysuppliername = $arraysupplier[0];
		$arraysuppliername = trim($arraysuppliername);
		$arraysuppliercode = $arraysupplier[1];

		$cbsuppliername = $arraysuppliername;
		$suppliername = $arraysuppliername;
	}
	else
	{
		$cbsuppliername = $_REQUEST['cbsuppliername'];
		$suppliername = $_REQUEST['cbsuppliername'];
	}


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

//echo $arraysuppliercode;
?>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
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
<body  onkeydown="escapekeypressed()">
<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="871" 
            align="left" border="1">
  <tbody>
    
            <tr>
              <td colspan="7" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Payment Pending  Report</strong></div></td>
            </tr>
            <tr>
              <td colspan="7" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong><?php echo $companyname; ?></strong>&nbsp;</div></td>
            </tr>
            <tr>
              <td colspan="7" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong><?php //echo 'Report Date From '.$transactiondatefrom.' To '.$transactiondateto; ?></strong></div></td>
            </tr>
            <tr>
              <td align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td width="7%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>No.</strong></div></td>
              <td width="18%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Supplier </strong></div></td>
              <td width="16%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Opening Balance </strong></div></td>
              <td width="20%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>By Purchase </strong></div></td>
              <td width="13%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>By Payments </strong></div></td>
              <td width="14%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>By Adjustment </strong></div></td>
              <td width="12%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>By Balance </strong></div></td>
            </tr>
			<?php
			
			$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$totalsales1=0;
			$query2 = "select * from master_transactionpharmacy where suppliername like '%$suppliername%' and recordstatus = '' and customeranum = '0' and customername = '' and companyanum = '$companyanum' group by supplieranum";//  order by transactiondate desc";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res2 = mysqli_fetch_array($exec2))
			{
			$res2anum = $res2['supplieranum'];
			$res2suppliername = $res2['suppliername'];
			
			$query4 = "select * from master_supplier where auto_number = '$res2anum'";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res4 = mysqli_fetch_array($exec4);
			$openingbalance = $res4['openingbalance'];
			
			$query3 = "select * from master_transactionpharmacy where transactiontype = 'PURCHASE' and supplieranum = '$res2anum' and recordstatus = '' and customeranum = '0' and customername = '' and companyanum = '$companyanum'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			while ($res3 = mysqli_fetch_array($exec3))
			{
				$transactionamount = $res3['transactionamount'];
				$totalsales = $totalsales + $transactionamount;
				$totalsales1=$totalsales1+$totalsales;
			}
			
			$query3 = "select * from master_transactionpharmacy where transactiontype = 'PAYMENT' and supplieranum = '$res2anum' and recordstatus = '' and customeranum = '0' and customername = '' and companyanum = '$companyanum'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res3 = mysqli_fetch_array($exec3))
			{
				$cashamount1 = $res3['cashamount'];
				$creditamount1 = $res3['creditamount'];
				$cardamount1 = $res3['cardamount'];
				$onlineamount1 = $res3['onlineamount'];
				$chequeamount1 = $res3['chequeamount'];
				$tdsamount1 = $res3['tdsamount'];
				$writeoffamount1 = $res3['writeoffamount'];
				
				$cashamount2 = $cashamount2 + $cashamount1;
				$creditamount2 = $creditamount2 + $creditamount1;
				$cardamount2 = $cardamount2 + $cardamount1;
				$onlineamount2 = $onlineamount2 + $onlineamount1;
				$chequeamount2 = $chequeamount2 + $chequeamount1;
				$tdsamount2 = $tdsamount2 + $tdsamount1;
				$writeoffamount2 = $writeoffamount2 + $writeoffamount1;
			}
			
			$totalpayments = $cashamount2 + $chequeamount2 + $onlineamount2 + $cardamount2;
			$netpayments = $totalpayments + $tdsamount2 + $writeoffamount2;
			$balanceamount = $totalsales - $netpayments;
			$balanceamount = $balanceamount + $openingbalance;
			
			$totalbalance=$totalbalance+$balanceamount;
			
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

			if ($balanceamount != 0.00)
			{
			?>
                <tr>
                  <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
                  <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF"><div class="bodytext311"><?php echo $res2suppliername; ?></div></td>
                  <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF"><div align="right"><?php echo number_format($openingbalance, 2); ?></div></td>
                  <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF"><div align="right"><?php echo number_format($totalsales, 2); ?></div></td>
                  <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF"><div align="right"><?php echo number_format($totalpayments, 2); ?></div></td>
                  <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF"><div align="right"><?php echo number_format($writeoffamount2, 2); ?></div></td>
                  <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF"><div align="right"><?php echo number_format($balanceamount, 2); ?></div></td>
                </tr>
			<?php
			}
				$transactionamount = '0';
				$totalsales = '0';

				$cashamount1 = '0';
				$creditamount1 = '0';
				$cardamount1 = '0';
				$onlineamount1 = '0';
				$chequeamount1 = '0';
				$tdsamount1 = '0';
				$writeoffamount1 = '0';
				
				$cashamount2 = '0';
				$creditamount2 = '0';
				$cardamount2 = '0';
				$onlineamount2 = '0';
				$chequeamount2 = '0';
				$tdsamount2 = '0';
				$writeoffamount2 = '0';
			
				$totalpayments = '0';
				$netpayments = '0';
				$balanceamount = '0';
				$openingbalance = '0';

			}
			
			?>
            <tr>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF"><div align="right"><strong>
                <?php //echo number_format($totalsalesamount, 2); ?>
              </strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF"><div align="right"><strong>
                <?php //echo number_format($netpaymentamount, 2); ?>
              </strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF"><div align="right"><strong>
                <?php //echo number_format($netpaymentamount, 2); ?>
              </strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF"><div align="right"><strong><?php echo number_format($totalbalance, 2); ?></strong></div></td>
            </tr>
            
            <tr>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" bgcolor="#ffffff">&nbsp;</td>
              <td align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" bgcolor="#ffffff">&nbsp;</td>
            </tr>
  </tbody>
</table>
</body>