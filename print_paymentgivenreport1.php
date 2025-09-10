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
if ($ADate1 != '')
{
	$paymentreceiveddatefrom = $_REQUEST['ADate1'];
	$paymentreceiveddateto = $_REQUEST['ADate2'];
}
else
{
	$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
	$paymentreceiveddateto = date('Y-m-d');
}


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
<body  onkeydown="escapekeypressed()">
<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="871" 
            align="left" border="1">
  <tbody>
    
            <tr>
              <td colspan="17" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext31">
			  <div align="center"><strong>Supplier Payment Given Report </strong></div></td>
            </tr>
            <tr>
              <td colspan="17" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong><?php echo $companyname; ?></strong>&nbsp;</div></td>
            </tr>
            <tr>
              <td colspan="17" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong><?php echo 'Report Date From '.$paymentreceiveddatefrom.' To '.$paymentreceiveddateto; ?></strong></div></td>
            </tr>
            <tr>
              <td width="5%" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td width="11%" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td width="21%" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td width="11%" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td width="11%" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td width="11%" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td width="11%" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td width="11%" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td width="11%" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td width="11%" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td width="11%" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td width="11%" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td width="11%" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td width="11%" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td width="11%" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td width="11%" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td width="11%" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>No.</strong></div></td>
              <!--<td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><strong>PDF</strong></td>-->
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong> Customer </strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong> Location </strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Particulars </strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Bill Amount</strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Paid Amount </strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Cash</strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Credit</strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Card</strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Online</strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Cheque</strong></div></td>
              <td align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Adjust</strong></div></td>
              <td align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>CollectionDate </strong></div></td>
              <td align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Mode </strong></div></td>
              <td align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Cheque No. </strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Cheque Date </strong></div></td>
              <td align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Remarks</strong></div></td>
            </tr>
			<?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

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
			
			
			$snocount = $snocount + 1;
			?>
            <tr <?php //echo $colorcode; ?>>
              <td align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#FFFFFF" class="bodytext31"><?php echo $snocount; ?></td>
              <td align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#FFFFFF" class="bodytext31"><div align="left"><?php echo $suppliername; ?></div></td>
              <td align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#FFFFFF" class="bodytext31"><div align="left"><?php echo $res3city; ?></div></td>
              <td align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#FFFFFF" class="bodytext31"><div class="bodytext31"><?php echo $typeofpayment; ?></div></td>
              <td align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#FFFFFF" class="bodytext31"><div align="right"><?php echo $totalamount; ?>&nbsp;</div></td>
              <td align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#FFFFFF" class="bodytext31"><div align="right"><?php echo $paymentamount; ?>&nbsp;</div></td>
              <td align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#FFFFFF" class="bodytext31"><div align="right"><?php echo $cashamount; ?>&nbsp;</div></td>
              <td align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#FFFFFF" class="bodytext31"><div align="right"><?php echo $creditamount; ?>&nbsp;</div></td>
              <td align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#FFFFFF" class="bodytext31"><div align="right"><?php echo $cardamount; ?>&nbsp;</div></td>
              <td align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#FFFFFF" class="bodytext31"><div align="right"><?php echo $onlineamount; ?>&nbsp;</div></td>
              <td align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#FFFFFF" class="bodytext31"><div align="right"><?php echo $chequeamount; ?>&nbsp;</div></td>
              <td align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#FFFFFF" class="bodytext31"><div align="right"><?php echo $writeoffamount; ?>&nbsp;</div></td>
              <td align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#FFFFFF" class="bodytext31"><div align="right"><?php echo substr($paymentdate, 0, 10); ?>&nbsp;</div></td>
              <td align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#FFFFFF" class="bodytext31"><div align="right"><?php echo $paymentmode; ?>&nbsp;</div></td>
              <td align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#FFFFFF" class="bodytext31"><div align="right"><?php echo $chequenumber; ?>&nbsp;</div></td>
              <td align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#FFFFFF" class="bodytext31"><div align="right"><?php echo $chequedate; ?>&nbsp;</div></td>
              <td align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#FFFFFF" class="bodytext31"><div align="left"><?php echo $remarks; ?></div></td>
            </tr>
			<?php
			
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
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF"><div align="right"><strong>Total : </strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF"><div align="right"><strong><?php echo $looptotalpaidamount; ?></strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF"><div align="right"><strong><?php echo $looptotalcashamount; ?></strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF"><div align="right"><strong><?php echo $looptotalcreditamount; ?></strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF"><div align="right"><strong><?php echo $looptotalcardamount; ?></strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF"><div align="right"><strong><?php echo $looptotalonlineamount; ?></strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF"><div align="right"><strong><?php echo $looptotalchequeamount; ?></strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF"><div align="right"><strong><?php echo $looptotalwriteoffamount; ?></strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
            </tr>
            
            <tr>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" bgcolor="#ffffff">&nbsp;</td>
              <td align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" bgcolor="#ffffff">&nbsp;</td>
            </tr>
  </tbody>
</table>
</body>