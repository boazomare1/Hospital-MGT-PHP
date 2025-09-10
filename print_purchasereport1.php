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
$sno = '';
$nettotalaftertax = '';

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

$cbsuppliername = '';
$cbbillnumber = '';
$suppliername = '';
$paymenttype = '';
$billstatus = '';
$res2loopcount = '';
$custid = '';
$custname = '';
$colorloopcount = '';

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

//$cbfrmflag1 = $_POST['cbfrmflag1'];
//if ($cbfrmflag1 == 'cbfrmflag1')
//if ($transactiondatefrom != '')
//{

	if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
	//$searchsuppliername = $_POST['searchsuppliername'];
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

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$ADate1 = $_REQUEST['ADate1'];
if ($ADate1 != '')
{
	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];
}
else
{
	$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
	$transactiondateto = date('Y-m-d');
}



if (isset($_REQUEST["paymenttype"])) { $paymenttype = $_REQUEST["paymenttype"]; } else { $paymenttype = ""; }
//$paymenttype = $_REQUEST['paymenttype'];


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
<body  onkeydown="escapekeypressed()">
<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="871" 
            align="left" border="1">
  <tbody>
    
            <tr>
              <td colspan="5" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Purchase Report</strong></div></td>
            </tr>
            <tr>
              <td colspan="5" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong><?php echo $companyname; ?></strong>&nbsp;</div></td>
            </tr>
            <tr>
              <td colspan="5" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong><?php echo 'Report Date From '.$transactiondatefrom.' To '.$transactiondateto; ?></strong></div></td>
            </tr>
           
            <tr>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><strong>SNo.</strong></td>
              <!--<td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><strong>PDF</strong></td>-->
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Date </strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Bill No. </strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><strong> Supplier Name </strong></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Total</strong></div></td>
            </tr>
            <?php
			
			$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

			$query2 = "select * from master_purchase where suppliername like '%$suppliername%' and billdate between '$transactiondatefrom' and '$transactiondateto' and companyanum = '$companyanum' and recordstatus <> 'DELETED'";//  order by transactiondate desc";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res2 = mysqli_fetch_array($exec2))
			{
			$res2suppliercode = $res2['suppliercode'];
			$query3 = "select * from master_supplier where auto_number = '$res2suppliercode'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$res3city = $res3['city'];
			$suppliername = $res2['suppliername'];
			$res2anum = $res2['auto_number'];
			$res2billdate = $res2['billdate'];
			$res2billdate = substr($res2billdate,0,10);
			$billdate = $res2billdate;
			$billnumberprefix = $res2['billnumberprefix'];
			$billnumber = $res2['billnumber'];
			$tinnumber = $res2['tinnumber'];
			$subtotal = $res2['subtotal'];
			//$totaltax = $res2['totaltax'];
			//$totalaftertax = $res2['totalaftertax'];
			
			$totalbillamount = $res2['totalamount'];
			  
	
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
		  
			?>
            <tr <?php //echo $colorcode; ?>>
              <td align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#FFFFFF" class="bodytext31"><?php echo $sno = $sno + 1; ?></td>
              <td align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#FFFFFF" class="bodytext31"><div align="left"> <?php echo $billdate; ?></div></td>
			  <td align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#FFFFFF" class="bodytext31"><div align="left"> <?php echo $billnumberprefix.' '.$billnumber; ?></div></td>
              <td align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#FFFFFF" class="bodytext31"><div class="bodytext31"> <?php echo $suppliername; ?></div></td>
              <td align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#FFFFFF" class="bodytext31"><div align="right"> <?php echo $totalbillamount; ?>&nbsp;</div></td>
            </tr>
				<?php
				$nettotalaftertax = $nettotalaftertax + $totalbillamount;
				}
				?>
            <tr>
             <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"><div align="right"><strong>Total : </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"><div align="right"><strong>
				<?php echo number_format($nettotalaftertax, 2, '.', ''); ?></strong></div></td>
            </tr>
  </tbody>
</table>
</body>