<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$searchsuppliername = '';
$suppliername = '';
$cbsuppliername = '';
$cbcustomername = '';
$cbbillnumber = '';
$cbbillstatus = '';
$colorloopcount = '';
$sno = '';

$cashamount2 = '0.00';
$creditamount2 = '0.00';
$cardamount2 = '0.00';
$onlineamount2 = '0.00';
$chequeamount2 = '0.00';
$tdsamount2 = '0.00';
$writeoffamount2 = '0.00';

$totalsales = '0.00';
$totalbalance = '0.00';

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

}

//echo $arraysuppliercode;
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
<script type="text/javascript" src="js/autocomplete_supplier1.js"></script>
<script type="text/javascript" src="js/autosuggest2supplier1.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
}


function disableEnterKey(varPassed)
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}

	if(key == 13) // if enter key press
	{
		//alert ("Enter Key Press2");
		return false;
	}
	else
	{
		return true;
	}
}




</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>

<body>
<table width="1150" border="0" cellspacing="0" cellpadding="2">
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
        <td>
		
		
              <form name="cbform1" method="post" action="paymentpending1.php">
		<table width="500" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Payment Pending Report     - By Supplier </strong></td>
              <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
              </tr>
            <tr>
              <td width="17%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Supplier </td>
              <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="searchsuppliername" type="text" id="searchsuppliername" style="border: 1px solid #001E6A;" value="<?php echo $searchsuppliername; ?>" size="50">
                <input value="<?php //echo $cbsuppliername; ?>" name="cbsuppliername" type="hidden" id="cbsuppliername" readonly="readonly" onKeyDown="return disableEnterKey()" size="50" style="border: 1px solid #001E6A">
              </span></td>
              </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="border: 1px solid #001E6A; text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="925" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="3%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td colspan="5" bgcolor="#ecf0f5" class="bodytext31">
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
					
					//$transactiondatefrom = $_REQUEST['ADate1'];
					//$transactiondateto = $_REQUEST['ADate2'];
					
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
				$filename1 = "print_paymentpendingreport1.php?$urlpath";
				$fileurl = $applocation1."/".$filename1;
				$filecontent1 = @file_get_contents($fileurl);
				
				$indiatimecheck = date('d-M-Y-H-i-s');
				$foldername = "dbexcelfiles";
				$fp = fopen($foldername.'/PaymentPendingBySupplier.xls', 'w+');
				fwrite($fp, $filecontent1);
				fclose($fp);

				?>
                <script language="javascript">
				function printbillreport1()
				{
					window.open("print_paymentpendingreport1.php?<?php echo $urlpath; ?>","Window1",'width=900,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
					//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
				}
				function printbillreport2()
				{
					window.location = "dbexcelfiles/PaymentPendingBySupplier.xls"
				}
				</script>
                <input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />
&nbsp;				<input value="Export Excel" onClick="javascript:printbillreport2()" name="resetbutton22" type="button" id="resetbutton22"  style="border: 1px solid #001E6A" />
</td>
              <td width="12%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>No.</strong></div></td>
              <td width="36%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Supplier </strong></div></td>
              <td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong><!--Opening Balance--> </strong></div></td>
              <td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>By Purchase </strong></div></td>
              <td width="11%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>By Payments </strong></div></td>
              <td width="11%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>By Adjustment </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"><strong>By Balance </strong></div></td>
            </tr>
			<?php
			/*
			$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			*/
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
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res2suppliername; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php //echo number_format($openingbalance, 2); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($totalsales, 2); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($totalpayments, 2); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($writeoffamount2, 2); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($balanceamount, 2); ?></div></td>
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
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php //echo number_format($totalsalesamount, 2); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php //echo number_format($netpaymentamount, 2); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php //echo number_format($netpaymentamount, 2); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totalbalance, 2); ?></strong></div></td>
            </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

