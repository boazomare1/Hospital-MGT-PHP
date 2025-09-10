<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

$openingbalance = '0.00';
$supplieranum = '';
$searchsuppliername = '';
$suppliername = '';
$cbsuppliername = '';
$cbbillnumber = '';
$cbbillstatus = '';
$suppliername = '';
$paymenttype = '';
$billstatus = '';
$res2loopcount = '';
$custid = '';
$custname = '';
$colorloopcount = '';
$sno = '';
$totalsalesamount = '0.00';
$totalsalesreturnamount = '0.00';
$totalpurchaseamount = '0.00';
$totalpurchasereturnamount = '0.00';
$netcollectionamount = '0.00';
$netpaymentamount = '0.00';

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

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
		
		$query1 = "select * from master_supplier where suppliercode = '$arraysuppliercode'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res1 = mysqli_fetch_array($exec1);
		$supplieranum = $res1['auto_number'];
		$suppliercode = $res1['suppliercode'];
		$openingbalance = $res1['openingbalance'];

		$cbsuppliername = $arraysuppliername;
		$suppliername = $arraysuppliername;
	}
	else
	{
		$cbsuppliername = $_REQUEST['cbsuppliername'];
		$suppliername = $_REQUEST['cbsuppliername'];
		
		$query1 = "select * from master_supplier where suppliername = '$suppliername'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res1 = mysqli_fetch_array($exec1);
		$suppliercode = $res1['suppliercode'];
		$supplieranum = $res1['supplieranum'];
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

}


include ("reportsupplier1openingbalance.php");

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
<?php
/*session_start();
$auto_number=$_SESSION['session_auto_number_post_job'];//post job auto number
*/
?>
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

<script src="js/datetimepicker_css.js"></script>

<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
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
        <td width="860">
		
		
              <form name="cbform1" method="post" action="reportsupplier1.php">
		<table width="791" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Statement - By Supplier</strong></td>
              <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
              <td bgcolor="#ecf0f5" class="bodytext3" colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Supplier </td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="searchsuppliername" type="text" id="searchsuppliername" style="border: 1px solid #001E6A;" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
              </span><span class="bodytext3">
                <input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="border: 1px solid #001E6A; text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" />
              </span></td>
              </tr>
            <tr>
              <td width="17%"  align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Select Supplier </td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input value="<?php echo $cbsuppliername; ?>" name="cbsuppliername" type="text" id="cbsuppliername" readonly="readonly" onKeyDown="return disableEnterKey()" size="50" style="border: 1px solid #001E6A"></td>
              </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
              <td width="28%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
			  <input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
				<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>				</td>
              <td width="11%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
              <td width="44%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
				<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
			  </span></td>
            </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
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
        <td>
		
		
		
		
		
		
		
<?php	
if (isset($_REQUEST["cbsuppliername"])) { $cbsuppliername = $_REQUEST["cbsuppliername"]; } else { $cbsuppliername = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbsuppliername != '')
{
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="3%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td colspan="6" bgcolor="#ecf0f5" class="bodytext31">
                <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					$cbsuppliername = $_REQUEST['cbsuppliername'];
					$suppliername = $_REQUEST['cbsuppliername'];
					
					if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					$transactiondatefrom = $_REQUEST['ADate1'];
					$transactiondateto = $_REQUEST['ADate2'];
					
					//$urlpath = "suppliercode=$suppliercode&&cbsuppliername=$cbsuppliername&&cbbillnumber=$cbbillnumber&&cbbillstatus=$cbbillstatus&&ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&financialyear=$financialyear&&companyanum=$companyanum";//&&companyname=$companyname";
					$urlpath = "suppliercode=$suppliercode&&cbbillnumber=$cbbillnumber&&cbbillstatus=$cbbillstatus&&ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				else
				{
					//$urlpath = "suppliercode=$suppliercode&&cbsuppliername=$cbsuppliername&&cbbillnumber=$cbbillnumber&&cbbillstatus=$cbbillstatus&&ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&financialyear=$financialyear&&companyanum=$companyanum";//&&companyname=$companyname";
					$urlpath = "suppliercode=$suppliercode&&cbbillnumber=$cbbillnumber&&cbbillstatus=$cbbillstatus&&ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				?>
 				<?php
				//For excel file creation.
				
				$applocation1 = $applocation1; //Value from db_connect.php file giving application path.
				$filename1 = "print_salessupplierreport1.php?$urlpath";
				$fileurl = $applocation1."/".$filename1;
				$filecontent1 = @file_get_contents($fileurl);
				
				$indiatimecheck = date('d-M-Y-H-i-s');
				$foldername = "dbexcelfiles";
				$fp = fopen($foldername.'/StatementBySupplier.xls', 'w+');
				fwrite($fp, $filecontent1);
				fclose($fp);

				?>
                <script language="javascript">
				function printbillreport1()
				{
					window.open("print_salessupplierreport1.php?<?php echo $urlpath; ?>","Window1",'width=1000,height=600,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
					//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
				}
				function printbillreport2()
				{
					window.location = "dbexcelfiles/StatementBySupplier.xls"
				}
				</script>
                <input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />
&nbsp;				<input value="Export Excel" onClick="javascript:printbillreport2()" name="resetbutton22" type="button" id="resetbutton22"  style="border: 1px solid #001E6A" /></td>
              <td width="11%" bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Opening Balance</strong></div></td>
              <td width="12%" bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong><?php echo number_format($openingbalance, 2, '.', '') ?></strong></div></td>
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Date</strong></td>
              <td width="18%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Supplier </strong></td>
              <td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong> Particulars </strong></td>
              <td width="11%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>By Purchase </strong></div></td>
              <td width="11%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>By Payments </strong></div></td>
              <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>By  Return </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"><strong>By Collections </strong></div></td>
              <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>By Balance </strong></div></td>
            </tr>
			<?php
			
			$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

			$query2 = "select * from master_transactionpharmacy where supplieranum = '$supplieranum' and 
			transactiondate between '$transactiondatefrom' and '$transactiondateto' and customeranum = '0' and customername = '' 
			and companyanum = '$companyanum' and recordstatus <> 'DELETED' order by transactiondate";// desc";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res2 = mysqli_fetch_array($exec2))
			{
			$res2anum = $res2['supplieranum'];
			
			$query3 = "select * from master_supplier where auto_number = '$res2anum'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$res3city = $res3['city'];
			
			$suppliername = $res2['suppliername'];
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
			
			$paymentdate = substr($paymentdate, 0, 10);
			$dotarray = explode("-", $paymentdate);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentdate = strtoupper(date("d-M-Y", mktime(0, 0, 0, $dotmonth, $dotday, $dotyear)));

			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo substr($paymentdate, 0, 11); ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $suppliername; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $particulars; ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left"><div align="right">
                  <?php 
			  if ($transactiontype == 'PURCHASE')
			  {
				  echo $totalamount; 
				  $totalsalesamount = $totalsalesamount + $totalamount; 
				  $openingbalance = $openingbalance + $totalamount;
		      }
			  ?>
              </div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right">
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
				  $openingbalance = $openingbalance - $totalpaymentamount;
		      }
			  ?>
              </div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right">
                  <?php 
			  if ($transactiontype == 'PURCHASE RETURN')
			  {
				  echo $totalamount; 
				  $totalsalesreturnamount = $totalsalesreturnamount + $totalamount; 
				  $openingbalance = $openingbalance - $totalamount;
		      }
			  ?>
              </div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right">
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
				  $openingbalance = $openingbalance + $totalcollectionamount;
		      }
			  ?>
              </div></td>
              <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($openingbalance, 2, '.', ''); ?></div></td>
            </tr>
			<?php
			}
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
                bgcolor="#ecf0f5"><div align="right"><strong>Total : </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totalsalesamount, 2, '.', ''); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($netpaymentamount, 2, '.', ''); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totalsalesreturnamount, 2, '.', ''); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($netcollectionamount, 2, '.', ''); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><!--Balance : --></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td  align="left" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Closing Balance </strong></div></td>
              <td  align="left" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong><?php echo number_format($openingbalance, 2, '.', ''); ?></strong></div></td>
            </tr>
          </tbody>
        </table>
<?php
}
?>
		</td>
      </tr>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

