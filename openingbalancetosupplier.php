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
$bgcolorcode = '';
$docno5 = $_SESSION['docno'];

$query1 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno5' group by locationname order by locationname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$locationcode = $res1['locationcode'];
$locationname = $res1['locationname'];

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{
//print_r($_POST);exit;
	

	$expensedate = $_REQUEST['expensedate'];
	$expenseentrydate = $_REQUEST['expenseentrydate'];
	$expenseamount = $_REQUEST['expenseamount'];
	
	

$paynowbillprefix = 'SOP-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from openingbalancesupplier order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='SOP-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'SOP-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
	$docnumber = $billnumbercode;
	
		$expenseentrycoa = $_REQUEST['paynowlabcode5'];
		$accountname = $_REQUEST['paynowlabcoa5'];
		$accountcode = $_REQUEST['paynowlabcode5'];
		
		
	
	$query1 = "select * from master_accountname where id = '$accountcode'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
	$subtype = $res1['subtype'];
	$paymenttype = $res1['paymenttype'];
	$accountssub = $res1['accountssub'];
	
	$query11 = "select * from master_subtype where auto_number = '$subtype'";
	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res11 = mysqli_fetch_array($exec11);
	$subtypename = $res11['subtype'];
	
	$query12 = "select * from master_paymenttype where auto_number = '$paymenttype'";
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res12 = mysqli_fetch_array($exec12);
	$paymenttypename = $res12['paymenttype'];
	
	$query13 = "select * from master_accountssub where auto_number = '$accountssub'";
	$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res13 = mysqli_fetch_array($exec13);
	$supplieranum = $res13['id'];

	
	$entrydate = $expenseentrydate;
	$entrytime = date('H:i:s');
	$amount = $expenseamount;
	$remarks = $_REQUEST['remarks'];
	$ipaddress = $ipaddress;
	$updatedate = $updatedatetime;
	
	$query41 = "select * from master_financialintegration where field='openingbalancesupplier'";
	$exec41 = mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res41 = mysqli_fetch_array($exec41);
	$coa = $res41['code'];
	
	//to update transaction master form transaction report.
	
	$query9 = "insert into openingbalancesupplier (docno, accountname, accountcode, openbalanceamount, 
	amount, entrydate, entrytime, remarks, username, ipaddress, companyname, companyanum,coa,locationcode,locationname)  
	values ('$docnumber', '$accountname', '$accountcode', '$amount', '$amount', '$entrydate',  
	'$entrytime', '$remarks', '$username', '$ipaddress', '$companyname', '$companyanum','$coa','$locationcode','$locationname')";
	$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query91 = "insert into master_purchase (billnumber, suppliername, suppliercode,  
	totalamount, billdate,supplierbillnumber,companyanum,username,ipaddress,locationcode,locationname) 
	values ('$docnumber', '$accountname', '$accountcode', '$amount', '$entrydate','Opening Balance','$companyanum','$username','$ipaddress','$locationcode','$locationname')";
	$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die ("Error in Query91".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query92 = "insert into master_transactionpharmacy (billnumber, suppliername,suppliercode,  
	transactionamount, transactiondate, remarks, ipaddress, companyname, companyanum,transactiontype,transactionmode,creditamount,supplieranum,locationcode,locationname) 
	values ('$docnumber', '$accountname', '$accountcode', '$amount', '$entrydate',  
	'$remarks', '$ipaddress', '$companyname', '$companyanum','PAYMENT','CREDIT','$amount','$supplieranum','$locationcode','$locationname')";
	$exec92 = mysqli_query($GLOBALS["___mysqli_ston"], $query92) or die ("Error in Query92".mysqli_error($GLOBALS["___mysqli_ston"]));


	
	header ("location:openingbalancetosupplier.php?st=1");
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == '1')
{
	$errmsg = "Success. Expense Payment Entry Updated.";
	$bgcolorcode = 'failed';
}

?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'SOP-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from openingbalancesupplier order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='SOP-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'SOP-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
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

function cbcustomername1()
{
	document.cbform1.submit();
}

</script>
<script type="text/javascript" src="js/autocomplete_customer1.js"></script>
<script type="text/javascript" src="js/autosuggest3.js"></script>
<script type="text/javascript" src="js/expensefunction.js"></script>

<script type="text/javascript">


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


function paymententry1process1()
{
	//alert ("inside if");
	/*
	if (document.getElementById("expensename").value == "")
	{
		alert ("Please Select Expense Name.");
		document.getElementById("expensename").focus();
		return false;
	}
	*/
	if (document.getElementById("paynowreferalcode").value == "")
	{
		alert ("Please Select an Account");
		document.getElementById("paynowreferalcode").focus();
		return false;
	}
	
	if (document.getElementById("expenseamount").value == "")
	{
		alert ("Expense Amount Cannot Be Empty.");
		document.getElementById("expenseamount").focus();
		document.getElementById("expenseamount").value = "0.00"
		return false;
	}
	if (document.getElementById("expenseamount").value == "0.00")
	{
		alert ("Expense Amount Cannot Be Empty.");
		document.getElementById("expenseamount").focus();
		document.getElementById("expenseamount").value = "0.00"
		return false;
	}
	if (isNaN(document.getElementById("expenseamount").value))
	{
		alert ("Expense Amount Can Only Be Numbers.");
		document.getElementById("expenseamount").focus();
		return false;
	}
	
	
		
	var varUserChoice; 
	varUserChoice = confirm('Are You Sure Want To Save This Entry?'); 
	//alert(fRet); 
	if (varUserChoice == false)
	{
		alert ("Entry Not Saved.");
		return false;
	}

	
}

function funcPrintReceipt1()
{
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_expense_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}

</script>
<script>
function coasearch(varCallFrom)
{
	var varCallFrom = varCallFrom;
	window.open("popup_openingbalacesuppliersearch.php?callfrom="+varCallFrom,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}
</script>
<?php

$query765 = "select * from master_financialintegration where field='cashexpenseentry'";
$exec765 = mysqli_query($GLOBALS["___mysqli_ston"], $query765) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res765= mysqli_fetch_array($exec765);

$cashcoa = $res765['code'];


$query766 = "select * from master_financialintegration where field='chequeexpenseentry'";
$exec766 = mysqli_query($GLOBALS["___mysqli_ston"], $query766) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res766 = mysqli_fetch_array($exec766);

$chequecoa = $res766['code'];


$query767 = "select * from master_financialintegration where field='mpesaexpenseentry'";
$exec767 = mysqli_query($GLOBALS["___mysqli_ston"], $query767) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res767 = mysqli_fetch_array($exec767);

$mpesacoa = $res767['code'];

$query768 = "select * from master_financialintegration where field='cardexpenseentry'";
$exec768 = mysqli_query($GLOBALS["___mysqli_ston"], $query768) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res768 = mysqli_fetch_array($exec768);

$cardcoa = $res768['code'];

$query769 = "select * from master_financialintegration where field='onlineexpenseentry'";
$exec769 = mysqli_query($GLOBALS["___mysqli_ston"], $query769) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res769 = mysqli_fetch_array($exec769);

$onlinecoa = $res769['code'];


?>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
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
        <td >
		
		
		
				<form name="form1" id="form1" method="post" action="openingbalancetosupplier.php" onSubmit="return paymententry1process1()">
			  <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                <tbody>
                  <tr bgcolor="#011E6A">
                    <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Opening Balance Supplier Entry - Details </strong></td>
                    <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                    <td bgcolor="#ecf0f5" class="bodytext3" colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="8" align="left" valign="middle"  
					bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?></td>
                  </tr>
                  <!--<tr>
                    <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">
                    <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Expense Entry" />
*To Print Other Receipts Please Go To Menu:	Reports	-&gt; Expense Report </span></td>
                  </tr>-->
                  <tr>
                    <td colspan="2" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="text" name="paynowlabcoa5" id="paynowreferalcoa" size="40"/>
						 <input type="button" onClick="javascript:coasearch('4')" value="Select Supplier" accesskey="m" style="border: 1px solid #001E6A"> 
						 <input type="hidden" name="paynowlabtype5" id="paynowreferaltype" size="10"/>
						 	<input type="hidden" name="cashcoa" value="<?php echo $cashcoa; ?>">
				<input type="hidden" name="chequecoa" value="<?php echo $chequecoa; ?>">
				<input type="hidden" name="mpesacoa" value="<?php echo $mpesacoa; ?>">
				<input type="hidden" name="cardcoa" value="<?php echo $cardcoa; ?>">
				<input type="hidden" name="onlinecoa" value="<?php echo $onlinecoa; ?>">
	
						 <input type="hidden" name="paynowlabcode5" id="paynowreferalcode" size="10"/></td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><b id="balamount" style="display:none"></b></td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"></td>
                  </tr>
                  <tr>
                         <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Doc No</td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input type="text" name="docnumber" value="<?php echo $billnumbercode; ?>" size="8"></td>
            
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Entry Date (YYYY-MM-DD) </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
					<input name="expenseentrydate" id="expenseentrydate" style="border: 1px solid #001E6A" value="<?php echo date('Y-m-d'); ?>"  readonly="readonly" onKeyDown="return disableEnterKey()" size="20" />
					<img src="images2/cal.gif" onClick="javascript:NewCssCal('expenseentrydate')" style="cursor:pointer"/>					</td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Amount </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
					<input name="expenseamount" id="expenseamount" style="border: 1px solid #001E6A" value="0.00"  size="20" /></td>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Remarks</td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="remarks" id="remarks" style="border: 1px solid #001E6A" value=""  size="20" /></td>
					
                  </tr>
                  <!--<tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Cheque Number </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
					<input name="chequenumber" id="chequenumber" style="border: 1px solid #001E6A" value=""  size="20" /></td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Bank Name </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="bankname" id="bankname" style="border: 1px solid #001E6A" value=""  size="20" /></td>
                  </tr>-->
                  <!--<tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
										  </td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Remarks</td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="remarks" id="remarks" style="border: 1px solid #001E6A" value=""  size="20" /></td>
                  </tr>-->
                  <tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">&nbsp;</td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                      <input type="hidden" name="cbfrmflag2" value="<?php echo $customeranum; ?>">
                      <input type="hidden" name="frmflag1" value="frmflag1">
                      <input name="Submit" type="submit"  value="Save" class="button" style="border: 1px solid #001E6A"/>
                    </font></td>
                  </tr>
                </tbody>
              </table>
			  </form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

