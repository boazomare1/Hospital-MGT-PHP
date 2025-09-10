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

$openingbalance = '0.00';
$customeranum = '';
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
$totalsalesamount = '0.00';
$totalsalesreturnamount = '0.00';
$netcollectionamount = '0.00';
$netpaymentamount = '0.00';

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

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
		
		$query1 = "select * from master_customer where customercode = '$arraycustomercode'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res1 = mysqli_fetch_array($exec1);
		$customeranum = $res1['auto_number'];
		$openingbalance = $res1['openingbalance'];

		$cbcustomername = $arraycustomername;
		$customername = $arraycustomername;
	}
	else
	{
		//$cbcustomername = $_REQUEST['cbcustomername'];
		//$customername = $_REQUEST['cbcustomername'];
		$customercode = $_REQUEST['customercode'];
		
		//$query101 = "select * from master_customer where customername = '$customername'";
		$query101 = "select * from master_customer where customercode = '$customercode'";
		$exec101 = mysqli_query($GLOBALS["___mysqli_ston"], $query101) or die ("Error in Query101".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res101 = mysqli_fetch_array($exec101);
		$customeranum = $res101['auto_number'];
		$openingbalance = $res101['openingbalance'];

	}

	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];

//}
//else
//{
	//exit;
//}


include ("reportcustomer1openingbalance.php");

?>
<style type="text/css">
<!--
.style1 {font-size: 10px}
.style12 {font-size: 12px; font-weight: bold; }
.style13 {font-size: 12px}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="960" 
            align="left" border="1">
  <tbody>
    <tr>
      <td align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
      <td align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
      <td colspan="5" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Statement By Customer </strong></div></td>
      <td align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
      <td align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
      <td align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
      <td colspan="5" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong><?php echo $companyname; ?></strong>&nbsp;</div></td>
      <td align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
      <td align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
      <td align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
      <td colspan="5" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong><?php echo 'Report Date From '.$transactiondatefrom.' To '.$transactiondateto; ?></strong></div></td>
      <td align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
      <td align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
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
      <td colspan="2" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Opening Balance </strong></div></td>
      <td align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong><?php echo number_format($openingbalance, 2, '.', '') ?></strong></div></td>
    </tr>
    <tr>
      <td width="3%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
      <td width="9%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31"><strong>Date</strong></td>
      <td width="26%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31"><strong> Customer </strong></td>
      <td width="19%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31"><strong> Particulars </strong></td>
      <td width="12%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>By Sales </strong></div></td>
      <td width="11%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>By Collections </strong></div></td>
      <td width="11%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>By Sales Return </strong></div></td>
      <td width="9%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>By Payments </strong></div></td>
      <td width="9%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>ByBalance </strong></div></td>
    </tr>
			<?php
			
			$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

			//$query2 = "select * from master_transaction where customername like '%$customername%' and 
			$query2 = "select * from master_transaction where customeranum = '$customeranum' and 
			transactiondate between '$transactiondatefrom' and '$transactiondateto' and supplieranum = '0' and 
			suppliername = '' and companyanum = '$companyanum' and recordstatus <> 'DELETED' order by transactiondate";// desc";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res2 = mysqli_fetch_array($exec2))
			{
			$res2anum = $res2['customeranum'];
			
			$query3 = "select * from master_customer where auto_number = '$res2anum'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$res3city = $res3['city'];
			
			$customername = $res2['customername'];
			//$city = $res2['city'];
			//$contact = $res2['contactperson'];
			$totalamount = $res2['transactionamount'];
			$paymentdate = $res2['transactiondate'];
			$paymentmode = $res2['transactionmode'];
			$chequenumber = $res2['chequenumber'];
			//$openingbalance = $res2['openingbalance'];
			//$closingbalance = $res2['closingbalance'];
			$chequenumber = $res2['chequenumber'];
			$chequedate = $res2['chequedate'];
			$chequedate = substr($chequedate, 0, 11);
			$bankname = $res2['bankname'];
			$bankbranch = $res2['bankbranch'];
			$remarks = $res2['remarks'];
			$particulars = $res2['particulars'];
			$transactiontype = $res2['transactiontype'];
			$transactionmode = $res2['transactionmode'];
			$res2creditamount = $res2['creditamount'];
			
			if ($res2creditamount == '0.00') // To avoid black credit record insert.
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
    <tr <?php //echo $colorcode; ?>>
      <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $sno = $sno + 1; ?></td>
      <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left"><div class="bodytext31"><?php echo substr($paymentdate, 0, 10); ?></div></td>
      <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left"><div class="bodytext31"><?php echo $customername; ?></div></td>
      <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left"><div class="bodytext31"><?php echo $particulars; ?></div></td>
      <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
        <?php 
			  if ($transactiontype == 'SALES')
			  {
				  echo $totalamount; 
				  $totalsalesamount = $totalsalesamount + $totalamount; 
				  $openingbalance = $openingbalance + $totalamount;
		      }
			  ?>
      </div></td>
      <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
          <?php 
			  if ($transactiontype == 'COLLECTION')
			  {
				  if ($transactionmode == 'CASH')
				  {
					  echo $totalcollectionamount = $res2['cashamount']; 
				  }
				  if ($transactionmode == 'CHEQUE')
				  {
					  echo $totalcollectionamount = $res2['chequeamount']; 
				  }
				  if ($transactionmode == 'CREDIT CARD')
				  {
					  echo $totalcollectionamount = $res2['cardamount']; 
				  }
				  if ($transactionmode == 'ONLINE')
				  {
					  echo $totalcollectionamount = $res2['onlineamount']; 
				  }
				  if ($transactionmode == 'TDS')
				  {
					  echo $totalcollectionamount = $res2['tdsamount']; 
				  }
				  if ($transactionmode == 'WRITEOFF')
				  {
					  echo $totalcollectionamount = $res2['writeoffamount']; 
				  }
				  $netcollectionamount = $totalcollectionamount + $netcollectionamount;
				  $openingbalance = $openingbalance - $totalcollectionamount;
		      }
			  ?>
      </div></td>
      <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
          <?php 
			  if ($transactiontype == 'SALES RETURN')
			  {
				  echo $totalamount; 
				  $totalsalesreturnamount = $totalsalesreturnamount + $totalamount; 
				  $openingbalance = $openingbalance - $totalamount;
		      }
			  ?>
      </div></td>
      <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
        <?php 
			  if ($transactiontype == 'PAYMENT')
			  {
				  if ($transactionmode == 'CASH')
				  {
					  echo $totalpaymentamount = $res2['cashamount']; 
				  }
				  if ($transactionmode == 'CHEQUE')
				  {
					  echo $totalpaymentamount = $res2['chequeamount']; 
				  }
				  if ($transactionmode == 'CREDIT CARD')
				  {
					  echo $totalpaymentamount = $res2['cardamount']; 
				  }
				  if ($transactionmode == 'ONLINE')
				  {
					  echo $totalpaymentamount = $res2['onlineamount']; 
				  }
				  if ($transactionmode == 'TDS')
				  {
					  echo $totalpaymentamount = $res2['tdsamount']; 
				  }
				  if ($transactionmode == 'WRITEOFF')
				  {
					  echo $totalpaymentamount = $res2['writeoffamount']; 
				  }
				  $netpaymentamount = $totalpaymentamount + $netpaymentamount;
				  $openingbalance = $openingbalance + $totalpaymentamount;
		      }
			  ?>
      </div></td>
      <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left"><div align="right"><?php echo number_format($openingbalance, 2, '.', ''); ?></div></td>
    </tr>
    <?php
			}
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
                bgcolor="#FFFFFF"><div align="right"><strong>Total : </strong></div></td>
      <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF"><div align="right"><strong><?php echo number_format($totalsalesamount, 2,'.',''); ?></strong></div></td>
      <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF"><div align="right"><strong><?php echo number_format($netcollectionamount, 2, '.', ''); ?></strong></div></td>
      <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF"><div align="right"><strong><?php echo number_format($totalsalesreturnamount, 2, '.', ''); ?></strong></div></td>
      <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF"><div align="right"><strong><?php echo number_format($netpaymentamount, 2,'.',''); ?></strong></div></td>
      <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr>
      <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
      <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
      <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
      <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF"><div align="right"></div></td>
      <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
      <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF"><div align="right"></div></td>
      <td colspan="2" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#FFFFFF" class="bodytext31"><div align="right"><strong>Closing Balance </strong></div></td>
      <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF"><div align="right"><strong><?php echo number_format($openingbalance, 2, '.', '') ?></strong></div></td>
    </tr>
  </tbody>
</table>
</body>