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

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

//This include updatation takes too long to load for hunge items database.
include ("autocompletebuild_supplier1.php");

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
//$cbfrmflag1 = $_POST['cbfrmflag1'];
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
		$openingbalance = $res1['openingbalance'];

		$cbsuppliername = $arraysuppliername;
		$suppliername = $arraysuppliername;
	}
	else
	{
		$cbsuppliername = $_REQUEST['cbsuppliername'];
		$suppliername = $_REQUEST['cbsuppliername'];
	}

	//$transactiondatefrom = $_REQUEST['ADate1'];
	//$transactiondateto = $_REQUEST['ADate2'];

}

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if ($frmflag2 == 'frmflag2')
{
	
	
		//For generating first code
		include ("transactioncodegenerate1.php");

		$query2 = "select * from settings_approval where modulename = 'collection' and status <> 'deleted'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$approvalrequired = $res2['approvalrequired'];
		if ($approvalrequired == 'YES')	{
			$approvalstatus = 'PENDING';
		}
		else {
			$approvalstatus = 'APPROVED';
		}
	
		$query8 = "select * from master_supplier where auto_number = '$cbfrmflag2'";
		$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res8 = mysqli_fetch_array($exec8);
		$res8suppliername = $res8['suppliername'];
		
		//echo "inside if";
		$paymententrydate = $_REQUEST['paymententrydate'];
		$paymentmode = $_REQUEST['paymentmode'];
		$chequenumber = $_REQUEST['chequenumber'];
		$chequedate = $_REQUEST['ADate1'];
		$bankname = $_REQUEST['bankname'];
		$bankbranch = $_REQUEST['bankbranch'];
		$remarks = $_REQUEST['remarks'];
		$paymentamount = $_REQUEST['paymentamount'];
		$pendingamount = $_REQUEST['pendingamount'];
		$remarks = $_REQUEST['remarks'];
			
		$balanceamount = $pendingamount - $paymentamount;
		$transactiondate = $paymententrydate;
		
		$transactionmode = $paymentmode;
		if ($transactionmode == 'TDS')
		{
			$transactiontype = 'TDS';
		}
		else
		{
			$transactiontype = 'PAYMENT';
		}
		
		$ipaddress = $ipaddress;
		$updatedate = $updatedatetime;
		
		$transactionmodule = 'PAYMENT';
		if ($paymentmode == 'CASH')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CASH';
		$particulars = 'BY CASH '.$billnumberprefix.$billnumber.'';	
		$cashamount = $paymentamount;
		//include ("transactioninsert1.php");
		$query9 = "insert into master_transactionpharmacy (transactioncode, transactiondate, particulars, supplieranum, suppliername, 
		transactionmode, transactiontype, transactionamount, cashamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule, approvalstatus) 
		values ('$transactioncode', '$transactiondate', '$particulars', '$cbfrmflag2', '$res8suppliername', 
		'$transactionmode', '$transactiontype', '$transactionamount', '$cashamount', 
		'$billnumber',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule', '$approvalstatus')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
	
		}
		if ($paymentmode == 'ONLINE')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'ONLINE';
		$particulars = 'BY ONLINE '.$billnumberprefix.$billnumber.'';	
		$onlineamount = $paymentamount;
		//include ("transactioninsert1.php");
		$query9 = "insert into master_transactionpharmacy (transactioncode, transactiondate, particulars, supplieranum, suppliername, 
		transactionmode, transactiontype, transactionamount, onlineamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule, approvalstatus) 
		values ('$transactioncode', '$transactiondate', '$particulars', '$cbfrmflag2', '$res8suppliername', 
		'$transactionmode', '$transactiontype', '$transactionamount', '$onlineamount', 
		'$billnumber',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule', '$approvalstatus')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
	
		}
		if ($paymentmode == 'CHEQUE')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CHEQUE';
		$particulars = 'BY CHEQUE '.$billnumberprefix.$billnumber;		
		$chequeamount = $paymentamount;
		//include ("transactioninsert1.php");
		$query9 = "insert into master_transactionpharmacy (transactioncode, transactiondate, particulars, supplieranum, suppliername, 
		transactionmode, transactiontype, transactionamount,
		chequeamount,chequenumber, billnumber, billanum, 
		chequedate, bankname, bankbranch, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule, approvalstatus) 
		values ('$transactioncode', '$transactiondate', '$particulars', '$cbfrmflag2', '$res8suppliername', 
		'$transactionmode', '$transactiontype', '$transactionamount',
		'$chequeamount','$chequenumber',  '$billnumber',  '$billanum', 
		'$chequedate', '$bankname', '$bankbranch','$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', 
		'$remarks', '$transactionmodule', '$approvalstatus')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		}
		
		if ($paymentmode == 'WRITEOFF')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'WRITEOFF';
		$particulars = 'BY WRITEOFF '.$billnumberprefix.$billnumber;		
		$writeoffamount = $paymentamount;
		//include ("transactioninsert1.php");
		$query9 = "insert into master_transactionpharmacy (transactioncode, transactiondate, particulars, supplieranum, suppliername, 
		transactionmode, transactiontype, transactionamount, writeoffamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule, approvalstatus) 
		values ('$transactioncode', '$transactiondate', '$particulars', '$cbfrmflag2', '$res8suppliername', 
		'$transactionmode', '$transactiontype', '$transactionamount', '$writeoffamount', 
		'$billnumber',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule', '$approvalstatus')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		
		header ("location:paymententry1.php?st=1");
		exit;
		
		//$errmsg = "Success. Payment Entry Updated.";

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == '1')
{
	$errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2')
{
	$errmsg = "Failed. Payment Entry Not Completed.";
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


function process1backkeypress1()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
}

function disableEnterKey()
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
		return false;
	}
	else
	{
		return true;
	}

}

function paymententry1process2()
{
	if (document.getElementById("cbfrmflag1").value == "")
	{
		alert ("Search Bill Number Cannot Be Empty.");
		document.getElementById("cbfrmflag1").focus();
		document.getElementById("cbfrmflag1").value = "<?php echo $cbfrmflag1; ?>";
		return false;
	}
}

function paymententry1process1()
{
	//alert ("inside if");
	if (document.getElementById("paymentamount").value == "")
	{
		alert ("Payment Amount Cannot Be Empty.");
		document.getElementById("paymentamount").focus();
		document.getElementById("paymentamount").value = "0.00"
		return false;
	}
	if (document.getElementById("paymentamount").value == "0.00")
	{
		alert ("Payment Amount Cannot Be Empty.");
		document.getElementById("paymentamount").focus();
		document.getElementById("paymentamount").value = "0.00"
		return false;
	}
	if (isNaN(document.getElementById("paymentamount").value))
	{
		alert ("Payment Amount Can Only Be Numbers.");
		document.getElementById("paymentamount").focus();
		return false;
	}
	if (document.getElementById("paymentmode").value == "")
	{
		alert ("Please Select Payment Mode.");
		document.getElementById("paymentmode").focus();
		return false;
	}
	if (document.getElementById("paymentmode").value == "CHEQUE")
	{
		if(document.getElementById("chequenumber").value == "")
		{
			alert ("If Payment By Cheque, Then Cheque Number Cannot Be Empty.");
			document.getElementById("chequenumber").focus();
			return false;
		} 
		else if (document.getElementById("bankname").value == "")
		{
			alert ("If Payment By Cheque, Then Bank Name Cannot Be Empty.");
			document.getElementById("bankname").focus();
			return false;
		}
	}
	
	var fRet; 
	fRet = confirm('Are you sure want to save this payment entry?'); 
	//alert(fRet); 
	//alert(document.getElementById("paymentamount").value); 
	//alert(document.getElementById("pendingamounthidden").value); 
	if (fRet == true)
	{
		var varPaymentAmount = document.getElementById("paymentamount").value; 
		var varPaymentAmount = varPaymentAmount * 1;
		var varPendingAmount = document.getElementById("pendingamounthidden").value; 
		var varPendingAmount = parseInt(varPendingAmount);
		var varPendingAmount = varPendingAmount * 1;
		//alert (varPendingAmount);
		/*
		if (varPaymentAmount > varPendingAmount)
		{
			alert('Payment Amount Is Greater Than Pending Amount. Entry Cannot Be Saved.'); 
			alert ("Payment Entry Not Completed.");
			return false;
		}
		*/
	}
	if (fRet == false)
	{
		alert ("Payment Entry Not Completed.");
		return false;
	}
		
	//return false;
	
}

function funcPrintReceipt1()
{
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}

</script>
<script>
function updatebox(varSerialNumber,billamt)
{
var adjamount1;
var varSerialNumber = varSerialNumber;

var billamt = billamt;
  var textbox = document.getElementById("adjamount"+varSerialNumber+"");
    textbox.value = "";

    if(document.getElementById("acknow"+varSerialNumber+"").checked) {
        textbox.value = billamt;
    }
	var balanceamt=billamt-billamt;
	document.getElementById("balamount"+varSerialNumber+"").value=balanceamt.toFixed(2);
	var totalbillamt=document.getElementById("paymentamount").value;
	if(totalbillamt == 0.00)
{
totalbillamt=0;
}
				totalbillamt=parseInt(totalbillamt)+parseInt(billamt);
			
		
			//alert(totalbillamt);


document.getElementById("paymentamount").value = totalbillamt.toFixed(2);

   
}
fuction balancecalc(varSerialNumber1,billamt1)
{
var varSerialNumber1 = varSerialNumber1;
var billamt1 = billamt1;
var adjamount=document.getElementById("adjamount"+varSerialNumber1+"").value;
var balanceamount=parseInt(billamt1)-parseInt(adjamount);
document.getElementById("balamount"+varSerialNumber+"").value=balanceamount.toFixed(2);
}

</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="paymententry1.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Payment Entry     - Select Supplier </strong></td>
              </tr>
            <tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 
                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 
				</td>
              </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Supplier </td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="searchsuppliername" type="text" id="searchsuppliername" style="border: 1px solid #001E6A;" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
              </span></td>
              </tr>
            <tr>
              <td width="18%"  align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> Supplier </td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input value="<?php echo $cbsuppliername; ?>" name="cbsuppliername" type="text" id="cbsuppliername" readonly="readonly" onKeyDown="return disableEnterKey()" size="50" style="border: 1px solid #001E6A"></td>
              </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="border: 1px solid #001E6A; text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="4%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="30%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="14%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="14%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="13%" bgcolor="#ecf0f5" class="bodytext31"><strong>Opening Balance </strong></td>
              <td width="12%" bgcolor="#ecf0f5" class="bodytext31"><div align="right">
                <?php 
			  echo number_format($openingbalance, 2); 
			  ?>
              </div></td>
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong> Supplier </strong></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>By Purchase </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>By Payments </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>By Adjustment </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>By Balance </strong></div></td>
            </tr>
			<?php
			
/*			$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
*/

			$totalpurchase = "0.00";
			$cashamount2 = "0.00";
			$cardamount2 = "0.00";
			$onlineamount2 = "0.00";
			$chequeamount2 = "0.00";
			$tdsamount2 = "0.00";
			$writeoffamount2 = "0.00";
			$colorloopcount = "0";
			$sno = "0";
			
			$query2 = "select * from master_transactionpharmacy where supplieranum = '$supplieranum' and recordstatus = '' group by supplieranum";// and approvalstatus =  'APPROVED' and cstid='$custid' and cstname='$custname'";//  order by transactiondate desc";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res2 = mysqli_fetch_array($exec2))
			{
			$res2anum = $res2['supplieranum'];
			$res2suppliername = $res2['suppliername'];
			
			$query3 = "select * from master_transactionpharmacy where transactiontype = 'PURCHASE' and supplieranum = '$res2anum'  and recordstatus = ''";// and approvalstatus =  'APPROVED' and cstid='$custid' and cstname='$custname'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res3 = mysqli_fetch_array($exec3))
			{
				$transactionamount = $res3['transactionamount'];
				$totalpurchase = $totalpurchase + $transactionamount;
			}
		
			$query3 = "select * from master_transactionpharmacy where transactiontype = 'PAYMENT' and supplieranum = '$res2anum' and recordstatus = ''";// and approvalstatus =  'APPROVED' and cstid='$custid' and cstname='$custname'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res3 = mysqli_fetch_array($exec3))
			{
				//echo $res3['auto_number'];
				$cashamount1 = $res3['cashamount'];
				$onlineamount1 = $res3['onlineamount'];
				$chequeamount1 = $res3['chequeamount'];
				$cardamount1 = $res3['cardamount'];
				$tdsamount1 = $res3['tdsamount'];
				$writeoffamount1 = $res3['writeoffamount'];
				
				$cashamount2 = $cashamount2 + $cashamount1;
				$cardamount2 = $cardamount2 + $cardamount1;
				$onlineamount2 = $onlineamount2 + $onlineamount1;
				$chequeamount2 = $chequeamount2 + $chequeamount1;
				$tdsamount2 = $tdsamount2 + $tdsamount1;
				$writeoffamount2 = $writeoffamount2 + $writeoffamount1;
			}
			
			$totalpayments = $cashamount2 + $chequeamount2 + $onlineamount2 + $cardamount2;
			$netpayments = $totalpayments + $tdsamount2 + $writeoffamount2;
			$balanceamount = $totalpurchase - $netpayments;
			
			if ($res2suppliername != '')
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
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res2suppliername; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($totalpurchase, 2); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($totalpayments, 2); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($writeoffamount2, 2); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($balanceamount, 2); ?></div></td>
            </tr>
			<?php
			}
			}
			$purchasebalance = $balanceamount;
			?>
          </tbody>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="4%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="30%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="14%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="14%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="13%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="12%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong> Supplier </strong></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>By Purchase Return </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>By Payments </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>By Adjustment </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>By Balance </strong></div></td>
            </tr>
            <?php
			
/*			$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
*/
			$transactionamount = "0.00";
			$totalpurchase = "0.00";
			$cashamount1 = "0.00";
			$onlineamount1 = "0.00";
			$chequeamount1 = "0.00";
			$cardamount1 = "0.00";
			$tdsamount1 = "0.00";
			$writeoffamount1 = "0.00";
			$cashamount2 = "0.00";
			$cardamount2 = "0.00";
			$onlineamount2 = "0.00";
			$chequeamount2 = "0.00";
			$tdsamount2 = "0.00";
			$writeoffamount2 = "0.00";
			$totalpayments = "0.00";
			$netpayments = "0.00";
			$balanceamount = "0.00";
			
			
			$query2 = "select * from master_transactionpharmacy where supplieranum = '$supplieranum' and recordstatus = '' group by supplieranum";// and cstid='$custid' and cstname='$custname'";//  order by transactiondate desc";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res2 = mysqli_fetch_array($exec2))
			{
			$res2anum = $res2['supplieranum'];
			$res2suppliername = $res2['suppliername'];
			if ($supplieranum != 0)
			{
			$query3 = "select * from master_transactionpharmacy where transactiontype = 'PURCHASE RETURN' and transactionmodule = 'PURCHASE RETURN' and supplieranum = '$res2anum' and recordstatus = ''";// and cstid='$custid' and cstname='$custname'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res3 = mysqli_fetch_array($exec3))
			{
				$transactionamount = $res3['transactionamount'];
				$totalpurchase = $totalpurchase + $transactionamount;
			}
		
			$query3 = "select * from master_transactionpharmacy where transactiontype = 'COLLECTION' and transactionmodule = 'PURCHASE RETURN' and supplieranum = '$res2anum' and recordstatus = ''";// and cstid='$custid' and cstname='$custname'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res3 = mysqli_fetch_array($exec3))
			{
				$cashamount1 = $res3['cashamount'];
				$onlineamount1 = $res3['onlineamount'];
				$chequeamount1 = $res3['chequeamount'];
				$cardamount1 = $res3['cardamount'];
				$tdsamount1 = $res3['tdsamount'];
				$writeoffamount1 = $res3['writeoffamount'];
				
				$cashamount2 = $cashamount2 + $cashamount1;
				$cardamount2 = $cardamount2 + $cardamount1;
				$onlineamount2 = $onlineamount2 + $onlineamount1;
				$chequeamount2 = $chequeamount2 + $chequeamount1;
				$tdsamount2 = $tdsamount2 + $tdsamount1;
				$writeoffamount2 = $writeoffamount2 + $writeoffamount1;
			}
			
			$totalpayments = $cashamount2 + $chequeamount2 + $onlineamount2 + $cardamount2;
			$netpayments = $totalpayments + $tdsamount2 + $writeoffamount2;
			$balanceamount = $totalpurchase - $netpayments;
			
			
			if ($res2suppliername != '')
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
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2suppliername; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalpurchase, 2); ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalpayments, 2); ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($writeoffamount2, 2); ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($balanceamount, 2); ?></div></td>
            </tr>
            <?php
			}
			}
			}
			$purchasereturnbalance = $balanceamount;
			
			$actualbalance = $purchasebalance - $purchasereturnbalance;
			?>
          </tbody>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>
		
		
		
				<form name="form1" id="form1" method="post" action="paymententry1.php?cbfrmflag1=<?php echo $cbfrmflag1; ?>" onSubmit="return paymententry1process1()">
			  <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                <tbody>
                  <tr bgcolor="#011E6A">
                    <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Payment  Entry - Details </strong></td>
                    <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                    <td bgcolor="#ecf0f5" class="bodytext3" colspan="2">
					<strong>Actual Balance : <?php echo number_format($openingbalance, 2).' + '.number_format($purchasebalance, 2).' - '.number_format($purchasereturnbalance, 2).' = '.number_format($actualbalance + $openingbalance, 2); ?></strong></td>
                  </tr>
                  <tr>
                    <td colspan="8" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#FFFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="17%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Total Pending Amount </td>
                    <td width="29%" align="left" valign="top"  bgcolor="#FFFFFF">
					<input name="pendingamount" id="pendingamount" style="border: 1px solid #001E6A; text-align:right" value="<?php echo number_format($actualbalance + $openingbalance, 2, '.', ''); ?>"  size="20" readonly="readonly" onKeyDown="return disableEnterKey()" />
					<input name="pendingamounthidden" id="pendingamounthidden" type="hidden" value="<?php echo $balanceamount; ?>"  size="20" readonly="readonly" onKeyDown="return disableEnterKey()" />					</td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Entry Date (YYYY-MM-DD) </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
					<input name="paymententrydate" id="paymententrydate" style="border: 1px solid #001E6A" value="<?php echo $updatedatetime; ?>"  readonly="readonly" onKeyDown="return disableEnterKey()" size="20" /></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Payment Amount </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
					<input name="paymentamount" id="paymentamount" style="border: 1px solid #001E6A; text-align:right" value="0.00"  size="20" /></td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Payment Mode </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
					<select name="paymentmode" id="paymentmode" style="width: 130px;">
                        <option value="" selected="selected">SELECT</option>
                        <option value="CHEQUE">CHEQUE</option>
                        <option value="CASH">CASH</option>
                        <!--<option value="TDS">TDS</option>-->
                        <option value="ONLINE">ONLINE</option>
                        <option value="WRITEOFF">ADJUSTMENT</option>
                    </select></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Cheque Number </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
					<input name="chequenumber" id="chequenumber" style="border: 1px solid #001E6A" value=""  size="20" /></td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Bank Name </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="bankname" id="bankname" style="border: 1px solid #001E6A" value=""  size="20" /></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Cheque  Date </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo date('Y-m-d'); ?>"  size="20"  readonly="readonly" onKeyDown="return disableEnterKey()"/>
					<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>
				    </td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Remarks</td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="remarks" id="remarks" style="border: 1px solid #001E6A" value=""  size="20" /></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">&nbsp;</td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                      <input type="hidden" name="cbfrmflag2" value="<?php echo $supplieranum; ?>">
                      <input type="hidden" name="frmflag2" value="frmflag2">
                      <input name="Submit" type="submit"  value="Save Payment" class="button" style="border: 1px solid #001E6A"/>
                    </font></td>
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
	
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
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
		$openingbalance = $res1['openingbalance'];

		$cbsuppliername = $arraysuppliername;
		$suppliername = $arraysuppliername;
	}
	else
	{
		$cbsuppliername = $_REQUEST['cbsuppliername'];
		$suppliername = $_REQUEST['cbsuppliername'];
	}
	
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="2%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="4%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="26%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="6%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="6%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="6%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="6%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="6%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="6%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
			  <td width="6%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
         <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
          <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
         
            </tr>
            <tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
				  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><strong>Select</strong></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><strong> Supplier </strong></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Bill No. </strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Bill Date </strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Bill Amt </strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong> After Bill </strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Paid</strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Last Pmt </strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong> After Pmt </strong></div></td>
              <td width="8%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><div align="right"><strong>Pending</strong></div></td>
				  <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong> Adj Amt</strong></div></td>
              <td width="3%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong> Bal Amt</strong></div></td>
            
				
            </tr>
            <?php
			$totalbalance = '';
			$sno = 0;
			$cashamount21 = '';
			$cardamount21 = '';
			$onlineamount21 = '';
			$chequeamount21 = '';
			$tdsamount21 = '';
			$writeoffamount21 = '';
			$totalnumb=0;
			$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$totalpurchase1=0;
			
			if (isset($_REQUEST["showbilltype"])) { $showbilltype = $_REQUEST["showbilltype"]; } else { $showbilltype = ""; }
			if ($showbilltype == 'All Bills')
			{
				$showbilltype = '';
			}			
			
			
			
			$query2 = "select * from master_purchase where suppliername like '%$suppliername%' and recordstatus <> 'deleted' and companyanum = '$companyanum';";
			//$query2 = "select * from master_transaction where transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and transactionmodule = 'SALES' and billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = ''";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowcount2 = mysqli_num_rows($exec2);
			//echo $rowcount2;
			while ($res2 = mysqli_fetch_array($exec2))
			{
				$suppliername = $res2['suppliername'];
				$billnumber = $res2['billnumber'];
				$billnumberprefix = $res2['billnumberprefix'];
				$billnumberpostfix = $res2['billnumberpostfix'];
				$billdate = $res2['billdate'];
				$billtotalamount = $res2['totalamount'];
	
				$query3 = "select * from master_transactionpharmacy where transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = ''";
				$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res3 = mysqli_fetch_array($exec3))
				{
					//echo $res3['auto_number'];
					$cashamount1 = $res3['cashamount'];
					$onlineamount1 = $res3['onlineamount'];
					$chequeamount1 = $res3['chequeamount'];
					$cardamount1 = $res3['cardamount'];
					$tdsamount1 = $res3['tdsamount'];
					$writeoffamount1 = $res3['writeoffamount'];
					
					$cashamount21 = $cashamount21 + $cashamount1;
					$cardamount21 = $cardamount21 + $cardamount1;
					$onlineamount21 = $onlineamount21 + $onlineamount1;
					$chequeamount21 = $chequeamount21 + $chequeamount1;
					$tdsamount21 = $tdsamount21 + $tdsamount1;
					$writeoffamount21 = $writeoffamount21 + $writeoffamount1;
				}
			
				$totalpayment = $cashamount21 + $chequeamount21 + $onlineamount21 + $cardamount21;
				$netpayment = $totalpayment + $tdsamount21 + $writeoffamount21;
				$balanceamount = $billtotalamount - $netpayment;
				
				$billtotalamount = number_format($billtotalamount, 2, '.', '');
				$netpayment = number_format($netpayment, 2, '.', '');
				$balanceamount = number_format($balanceamount, 2, '.', '');
				
				$billstatus = $billtotalamount.'||'.$netpayment.'||'.$balanceamount;

			
			$billdate = substr($billdate, 0, 10);
			$date1 = $billdate;

			$dotarray = explode("-", $billdate);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$billdate = strtoupper(date("d-M-Y", mktime(0, 0, 0, $dotmonth, $dotday, $dotyear)));

			$billtotalamount = number_format($billtotalamount, 2, '.', '');
			$netpayment = number_format($netpayment, 2, '.', '');
			$balanceamount = number_format($balanceamount, 2, '.', '');
			
			$date1 = $date1;
			$date2 = date("Y-m-d");  
			$diff = abs(strtotime($date2) - strtotime($date1));  
			$days = floor($diff / (60*60*24));  
			$daysafterbilldate = $days;
			
			$query3 = "select * from master_transactionpharmacy where transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = '' order by auto_number desc";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			 $numb=mysqli_num_rows($exec3);
			 $totalnumb=$totalnumb+$numb;
			 //echo $totalnumb;
			$lastpaymentdate = $res3['transactiondate'];
			$lastpaymentdate = substr($lastpaymentdate, 0, 10);
			
			if ($lastpaymentdate != '')
			{
				$date1 = $lastpaymentdate;
				$date2 = date("Y-m-d");  
				$diff = abs(strtotime($date2) - strtotime($date1));  
				$days = floor($diff / (60*60*24));  
				$daysafterpaymentdate = $days;
				
				$dotarray = explode("-", $lastpaymentdate);
				$dotyear = $dotarray[0];
				$dotmonth = $dotarray[1];
				$dotday = $dotarray[2];
				$lastpaymentdate = strtoupper(date("d-M-Y", mktime(0, 0, 0, $dotmonth, $dotday, $dotyear)));
			}
			else
			{
				$daysafterpaymentdate = '';
				$lastpaymentdate = '';
			}			

			//echo $balanceamount;
			if ($balanceamount != '0.00')
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

			//if ($balanceamount != 0.00)
			//{
			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">
			  <input type="checkbox" name="ack[]" id="acknow<?php echo $sno; ?>" value="<?php if ($billtotalamount != '0.00') echo $billtotalamount; ?>" onClick="updatebox('<?php echo $sno; ?>','<?php echo $billtotalamount; ?>')"></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div class="bodytext311"><?php echo $suppliername; ?></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billnumberprefix.$billnumber.$billnumberpostfix; ?></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billdate; ?></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
                <?php if ($billtotalamount != '0.00') echo $billtotalamount; //echo number_format($billtotalamount, 2); ?>
              </div></td><input type="hidden" name="billamount" id="bill" value="<?php if ($billtotalamount != '0.00') echo $billtotalamount; ?>">
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left"><div align="right"><?php echo $daysafterbilldate.' Days'; ?></div>
                  <div align="right"></div>
                <div align="right"></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
                <?php if ($netpayment != '0.00') echo $netpayment; //echo number_format($netpayment, 2); ?>
              </div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left"><div align="right"> <?php echo $lastpaymentdate; ?> </div>
                  <div align="right"></div>
                <div align="right"></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
                  <?php if ($daysafterpaymentdate != '') echo $daysafterpaymentdate.' Days'; ?>
                </div>
                  <div align="right"></div>
                <div align="right"></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
                <?php if ($balanceamount != '0.00') echo $balanceamount; //echo number_format($balanceamount, 2); ?>
              </div></td>
			      <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input type="text" name="adjamount" id="adjamount<?php echo $sno; ?>" value="" size="7" onBlur="balancecalc('<?php echo $sno; ?>','<?php echo $billtotalamount; ?>')"></td>
            <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input type="text" name="balamount" id="balamount<?php echo $sno; ?>" value=""></td>
          
            </tr>
            <?php
				$totalbalance = $totalbalance + $balanceamount;
				}
				
				$cashamount21 = '0.00';
				$cardamount21 = '0.00';
				$onlineamount21 = '0.00';
				$chequeamount21 = '0.00';
				$tdsamount21 = '0.00';
				$writeoffamount21 = '0.00';

				$totalpayment = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billtotalamount = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billstatus = '0.00';
			}
			
			?>
            <tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
             
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>
                <?php //echo number_format($totalpurchaseamount, 2); ?>
              </strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>
                <?php //echo number_format($netpaymentamount, 2); ?>
              </strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>
                <?php //echo number_format($netpaymentamount, 2); ?>
              </strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php if ($totalbalance != '') echo number_format($totalbalance, 2, '.', ''); ?></strong></div></td>
             <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
             <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
            
			</tr>
          </tbody>
        </table>
<?php
}
?>	
		
		
		
		
		
		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	  
	  
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

