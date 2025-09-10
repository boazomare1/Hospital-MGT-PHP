<?php
session_start();
//error_reporting(0);
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
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
$billnumberprefix = "";
//$billdate = "0000-00-00";

//This include updatation takes too long to load for hunge items database.
include ("autocompletebuild_doctor.php");

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
if (isset($_REQUEST["cbsuppliername"])) { $cbsuppliername = $_REQUEST["cbsuppliername"]; } else { $cbsuppliername = ""; }
if (isset($_REQUEST["cbsuppliername"])) { $searchsuppliername = $_REQUEST["cbsuppliername"]; } else { $searchsuppliername = ""; }
if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = date('Y-m-d'); }
$paymentreceiveddatefrom=$ADate1;

//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date('Y-m-d'); }
$paymentreceiveddateto=$ADate2;
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
		$doctorcode = $arraysuppliercode;
	}
	else
	{
		$cbsuppliername = $_REQUEST['searchsuppliername'];
		$cbsuppliername = strtoupper($cbsuppliername);
		$suppliername = $_REQUEST['searchsuppliername'];
		$suppliername = strtoupper($suppliername);
		$doctorcode = $_REQUEST['searchsuppliercode'];
	}

	//$transactiondatefrom = $_REQUEST['ADate1'];
	//$transactiondateto = $_REQUEST['ADate2'];

}


if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if ($frmflag2 == 'frmflag2')
{
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'DP-';
$paynowbillprefix1=strlen($paynowbillprefix);

$query2 = "select * from doctorsharing where transactiontype='PAYMENT' and transactionmodule ='PAYMENT' order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='DS-'.'1';
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
	
	
	$billnumbercode = 'DS-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
		$paymententrydate = date('Y-m-d');
		$paymentmode = 'CASH';
		$chequenumber = '';
		$chequedate = '';
		$bankname = '';
		$bankbranch = '';
		$remarks = '';
		$paymentamount = $_REQUEST['paymentamount'];
		$netpayable = $_REQUEST['netpayable'];
		$taxamount = '';
		$cashcoa = '';
		$chequecoa = '';
		$cardcoa = '';
		$mpesacoa = '';
		$onlinecoa = '';
		$doctorcode = $_REQUEST['doctorcode'];
		
		
		$searchsuppliercode1 = $_REQUEST["searchsuppliercode1"];
		$searchsuppliername1 = $_REQUEST['searchsuppliername1'];
		$searchsuppliername1 = strtoupper($searchsuppliername1);
	
		$pendingamount = $_REQUEST['pendingamount'];
		$remarks = '';
		$shiftid = '';
			
		$balanceamount =  $paymentamount-$pendingamount;
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
		//$cashamount = $paymentamount;
		//include ("transactioninsert1.php");
		//print_r($_POST['billnum']);
		foreach($_POST['billnum'] as $key => $value)
		{
		$billnum=$_POST['billnum'][$key];
		$name=$_POST['name'][$key];
		$accountname=$_POST['accountname'][$key];
		$patientcode=$_POST['patientcode'][$key];
		$visitcode=$_POST['visitcode'][$key];
		$doctorname=$_POST['doctorname'][$key];
		//echo $doctorname;
		$balamount=$_POST['balamount'][$key];
		$billdate=$_POST['billdate'][$key];
		$billanum = $_REQUEST['billanum'][$key];
		//echo $balamount;
		if($balamount == 0.00)
		{
		$billstatus='paid';
		}
		else
		{
		$billstatus='paid';
		}
		//echo $billstatus;
		$adjamount=$_POST['adjamount'][$key];
		$hospamount=$_POST['hospamount'][$key];
		$taxanum='';
		$transactionamount=$adjamount;
		if($taxanum!='')
			{
				
				$taxamount=($adjamount/100)*$taxanum;
				$transactionamount=$adjamount-$taxamount;
				}
		foreach($_POST['ack'] as $check)
		{
		$acknow=$check;
		if($acknow==$billnum.'|'.$billanum)
		{
	
		$query9 = "insert into doctorsharing (transactiondate, particulars, 
		transactionmode, transactiontype, transactionamount, cashamount,taxamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,docno,doctorcode,shiftid,hosp_amount) 
		values ('$billdate', '$particulars', 
		'$transactionmode', '$transactiontype', '$transactionamount', '$adjamount', '$taxamount', 
		'$billnum',  '$billanum', '$ipaddress', '$paymententrydate', '$balamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$name','$patientcode','$visitcode','$accountname','$doctorname','$billstatus','$billnumbercode','$doctorcode','$shiftid','$hospamount')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
	}	
	}
	}
	}
	//echo $query9;
	header("location:doctorsharing.php?st1=success");
	exit;
	
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
<script type="text/javascript">
<?php
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if (isset($_REQUEST["billnumber"])) { $billnumber = $_REQUEST["billnumber"]; } else { $billnumber = ""; }

//$st = $_REQUEST['st'];
if ($st == 'success' && $billnumber != '')
{
?>
var billnumber = '<?php echo $billnumber; ?>';
window.open("print_doctorpayment1.php?billnumber="+billnumber, "OriginalWindow1", "width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25");
<?php
}
?>
</script>
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


function amountcheck()
{

}
</script>
<script type="text/javascript" src="js/autocomplete_doctor.js"></script>
<script type="text/javascript" src="js/autosuggestdoctor.js"></script>
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
	
	if (document.getElementById("cbsuppliername").value == "")
	{
		alert ("Enter Doctor Name");
		document.getElementById("cbsuppliername").focus();
		return false;
	}
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

function Saveform()
{
	var fRet; 
	fRet = confirm('Are you sure want to save this form entry?'); 
	//alert(fRet); 
	//alert(document.getElementById("paymentamount").value); 
	//alert(document.getElementById("pendingamounthidden").value); 
	if (fRet == true)
	{
	
	}
	if (fRet == false)
	{
		alert ("Payment Entry Not Completed.");
		return false;
	}
}

function funcPrintReceipt1()
{
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}

function FillNetpay()
{
	var Payment = document.getElementById("paymentamount").value;
	if(isNaN(Payment))
	{
		alert("Enter Numbers");
		document.getElementById("paymentamount").value = "";
		document.getElementById("netpayable").value = "";
		document.getElementById("paymentamount").focus();
	}
	else
	{
		if(Payment != "")
		{	
			var Payment = parseFloat(Payment);
			document.getElementById("netpayable").value = Payment.toFixed(2);
		}
	}
}

function FillDoctor()
{
	var Doctor = document.getElementById("cbsuppliername").value;
	document.getElementById("searchsuppliername1").value = Doctor;
}

</script>
<script>
function updatebox(varSerialNumber,billamt,totalcount1)
{
var adjamount1;
var grandtotaladjamt2=0;
var varSerialNumber = varSerialNumber;
var totalcount1=document.getElementById("totcount").value;
var billamt = billamt;
//alert(billamt);
  var textbox = document.getElementById("adjamount"+varSerialNumber+"");
    textbox.value = "";
if(document.getElementById("acknow"+varSerialNumber+"").checked == true)
{
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
				totalbillamt=parseFloat(totalbillamt)+parseFloat(billamt);
			
		  // alert('true');
			//alert(totalbillamt);


document.getElementById("paymentamount").value = totalbillamt.toFixed(2);
document.getElementById("netpayable").value = totalbillamt.toFixed(2);
document.getElementById("totaladjamt").value=totalbillamt.toFixed(2);
}
else
{// alert('else');
var grandtotaladjamt2=document.getElementById("paymentamount").value
grandtotaladjamt2=grandtotaladjamt2-billamt;
//alert(grandtotaladjamt2);
document.getElementById("paymentamount").value = grandtotaladjamt2.toFixed(2);
document.getElementById("netpayable").value = grandtotaladjamt2.toFixed(2);
document.getElementById("totaladjamt").value=grandtotaladjamt2.toFixed(2);

//alert(totalcount1);
/*for(j=1;j<=totalcount1;j++)
{
var totaladjamount2=document.getElementById("adjamount"+j+"").value;

if(totaladjamount2 == "")
{
totaladjamount2=0;
}
grandtotaladjamt2=grandtotaladjamt2+parseFloat(totaladjamount2);

}
grandtotaladjamt2=grandtotaladjamt2-billamt;
alert(grandtotaladjamt);
document.getElementById("paymentamount").value = grandtotaladjamt2.toFixed(2);
document.getElementById("netpayable").value = grandtotaladjamt2.toFixed(2);
document.getElementById("totaladjamt").value=grandtotaladjamt2.toFixed(2);*/

 }  
}
function balancecalc(varSerialNumber1,billamt1,totalcount)
{
var varSerialNumber1 = varSerialNumber1;
var billamt1 = document.getElementById("billamount"+varSerialNumber1+"").value;
var totalcount=document.getElementById("totcount").value;
//alert(totalcount);
var grandtotaladjamt=0;
var adjamount=document.getElementById("adjamount"+varSerialNumber1+"").value;
var adjamount3=parseFloat(adjamount);
var hospamount=document.getElementById("hospamount"+varSerialNumber1+"").value;
if(hospamount == '') { hospamount = "0.00"; }
var hospamount3=parseFloat(hospamount);
var tothosp = parseFloat(hospamount) + parseFloat(adjamount3);
if(parseFloat(tothosp) > parseFloat(billamt1))
{
alert("Please enter correct amount");
document.getElementById("adjamount"+varSerialNumber1+"").value = "0";
document.getElementById("hospamount"+varSerialNumber1+"").value = "0";
document.getElementById("adjamount"+varSerialNumber1+"").focus();
return false;
}
var balanceamount=parseFloat(billamt1)-parseFloat(tothosp);

document.getElementById("balamount"+varSerialNumber1+"").value=balanceamount.toFixed(2);

for(i=1;i<=totalcount;i++)
{
var totaladjamount=document.getElementById("adjamount"+i+"").value;
if(totaladjamount == "")
{
totaladjamount=0;
}
grandtotaladjamt=grandtotaladjamt+parseFloat(totaladjamount);
}
//alert(grandtotaladjamt);
document.getElementById("paymentamount").value = grandtotaladjamt.toFixed(2);
document.getElementById("netpayable").value = grandtotaladjamt.toFixed(2);
document.getElementById("totaladjamt").value=grandtotaladjamt.toFixed(2);
}

function netpayablecalc()
{
var taxamount;
var taxpercent;
var paymentamount = document.getElementById("paymentamount").value;
var tax = '';
//alert(tax);
if(tax != '')
{
<?php
$query1 = "select * from master_tax where status <> 'deleted' order by taxname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1taxname = $res1["taxname"];
						$res1taxpercent = $res1["taxpercent"];
						$res1anum = $res1["auto_number"];
						?>
						if(tax == "<?php echo $res1anum; ?>")
						{
						taxpercent = "<?php echo $res1taxpercent; ?>";
						}
						<?php
	}
	
	?>
	
	taxamount = (paymentamount * taxpercent)/100;
	var netpayable = paymentamount - taxamount;
	document.getElementById("taxamount").value = taxamount.toFixed(2);
	document.getElementById("netpayable").value = netpayable.toFixed(2);
}
else
{
	document.getElementById("taxamount").value = 0.00;
	document.getElementById("netpayable").value = paymentamount;
}	
	
}

function funccheckall()
{
	var countall = document.getElementById('totcount').value;
	var totadjamount = '0';
	for(var i=1;i<=countall;i++)
	{
		if(document.getElementById('acknow'+i).checked == true)
		{
		var adjamount = document.getElementById('adjamount'+i).value;
		var totadjamount = parseFloat(totadjamount) + parseFloat(adjamount);
		document.getElementById('totaladjamt').value = totadjamount.toFixed(2);
		document.getElementById("paymentamount").value = totadjamount.toFixed(2);
		document.getElementById("netpayable").value = totadjamount.toFixed(2);
		}
	}
}

function chkall()
{
	var countall = document.getElementById('totcount').value;
	for(var i=1;i<=countall;i++)
	{
		var cck = document.getElementById('cck').innerHTML;
		if(cck == 'Check all')
		{
			document.getElementById('acknow'+i).checked = true;
		}
		else
		{
			document.getElementById('acknow'+i).checked = false;
		}	
	}
	
	var cck = document.getElementById('cck').innerHTML;
	if(cck == 'Check all')
	{
		document.getElementById('cck').innerHTML = "Uncheck all";
	}
	else
	{
		document.getElementById('cck').innerHTML = "Check all";
	}
	
	funccheckall()
}
</script>
<?php

$query765 = "select * from master_financialintegration where field='cashdoctorpaymententry'";
$exec765 = mysqli_query($GLOBALS["___mysqli_ston"], $query765) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res765= mysqli_fetch_array($exec765);

$cashcoa = $res765['code'];


$query766 = "select * from master_financialintegration where field='chequedoctorpaymententry'";
$exec766 = mysqli_query($GLOBALS["___mysqli_ston"], $query766) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res766 = mysqli_fetch_array($exec766);

$chequecoa = $res766['code'];


$query767 = "select * from master_financialintegration where field='mpesadoctorpaymententry'";
$exec767 = mysqli_query($GLOBALS["___mysqli_ston"], $query767) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res767 = mysqli_fetch_array($exec767);

$mpesacoa = $res767['code'];

$query768 = "select * from master_financialintegration where field='carddoctorpaymententry'";
$exec768 = mysqli_query($GLOBALS["___mysqli_ston"], $query768) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res768 = mysqli_fetch_array($exec768);

$cardcoa = $res768['code'];

$query769 = "select * from master_financialintegration where field='onlinedoctorpaymententry'";
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
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
}
.bali
{
text-align:right;
}
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
    <td width="97%" valign="top"><table width="70%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="895">
		
		
              <form name="cbform2" method="post" action="doctorsharing.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Doctor Sharing - Select Doctor </strong></td>
              </tr>
            
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Doctor </td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="searchsuppliername" type="text" id="searchsuppliername" style="border: 1px solid #001E6A;" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
              </span></td>
              </tr>
            <tr>
              <td width="18%"  align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> Doctor </td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input value="<?php echo $cbsuppliername; ?>" name="cbsuppliername" type="text" id="cbsuppliername" onKeyDown="return disableEnterKey()" onKeyUp="return FillDoctor()" size="50" style="border: 1px solid #001E6A; text-transform:uppercase;" <?php if($searchsuppliername != "") { ?> readonly <?php } ?>></td>
              </tr>
			
			  <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>	
					
			
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="border: 1px solid #001E6A; text-transform:uppercase" value="<?php if($searchsuppliercode != '') { echo $searchsuppliercode; } else { echo '04-4602'; } ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="hidden" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" /></td>
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
		if ($cbfrmflag1 == 'cbfrmflag1')
{
			$searchsuppliername = $_POST['cbsuppliername'];
			
	if ($searchsuppliername != '')
	{
		$arraysupplier = explode("#", $searchsuppliername);
		$arraysuppliername = $arraysupplier[0];
		$arraysuppliername = trim($arraysuppliername);
		//$arraysuppliercode = $arraysupplier[1];
		
		$query1 = "select * from master_doctor where doctorcode = '$searchsuppliercode'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res1 = mysqli_fetch_array($exec1);
		$supplieranum = $res1['auto_number'];
		$openingbalance = $res1['openingbalance'];
		//echo $openingbalance;

		$cbsuppliername = $arraysuppliername;
		$suppliername = $arraysuppliername;
		$suppliercode = $searchsuppliercode;
	}
	else
	{
		$cbsuppliername = $_REQUEST['cbsuppliername'];
		$suppliername = $_REQUEST['cbsuppliername'];
		$suppliercode = $_REQUEST['searchsuppliercode'];
		
	}
	}
		 ?>
		
				<form name="form1" id="form1" method="post" action="doctorsharing.php?cbfrmflag1=<?php echo $cbfrmflag1; ?>" onSubmit="return Saveform()">
			  
			 	</td>
				
      </tr>
     
	  <tr>
        <td>
		
		
		
		
		
		
<?php
	
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$searchsuppliername = $_POST['cbsuppliername'];
			
	if ($searchsuppliername != '')
	{
		$arraysupplier = explode("#", $searchsuppliername);
		$arraysuppliername = $arraysupplier[0];
		$arraysuppliername = trim($arraysuppliername);
		//$arraysuppliercode = $arraysupplier[1];
		
		$query1 = "select * from master_doctor where doctorcode = '$searchsuppliercode'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res1 = mysqli_fetch_array($exec1);
		$supplieranum = $res1['auto_number'];
		$openingbalance = $res1['openingbalance'];
		//echo $openingbalance;

		$cbsuppliername = $arraysuppliername;
		$suppliername = $arraysuppliername;
		$suppliercode = $searchsuppliercode;
	}
	else
	{
		$cbsuppliername = $_REQUEST['cbsuppliername'];
		$suppliername = $_REQUEST['cbsuppliername'];
		$suppliercode = $_REQUEST['searchsuppliercode'];
		
	}
	
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="878" 
            align="left" border="0">
          <tbody>
            <tr>
              <td colspan="3" bgcolor="#ecf0f5" class="bodytext311"><strong><?php echo $suppliername; ?></strong></td>
              <td width="11%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="13%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="10%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="10%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="10%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="12%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              
            </tr>
            <tr>
              <td width="3%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><strong>No.</strong></td>
				  <td width="9%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><strong><a href="#" onClick="return chkall()"><span id="cck">Check all</span></a></strong></td>
              <td width="22%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><strong>Patient</strong></td>
              <td width="11%" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Bill No </strong></div></td>
              <td width="13%" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Bill Date </strong></div></td>
              <td width="10%" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Bill Amt </strong></div></td>
               <td width="10%" class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong> Doctor Share</strong></div></td>
				<td width="10%" class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong> HOSP Share</strong></div></td>
              <td width="12%" align="left" valign="center" bordercolor="#f3f3f3" 
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
			$taxamount21 = '';
			$writeoffamount21 = '';
			$hospamount21 = '0.00';
			$totalnumbr='';
			$totalnumb=0;
			//include("doctorcount.php");
			
			$number = 0;
			$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$totalpurchase1=0;
			$colorloopcount=0;
				
				$hosp_amt = '0.00';
				$hosp_amt1 = '0.00';
				$hosp_amt2 = '0.00';
				//echo $number;
			/*
			$query2235 = "select * from openingbalancesupplier where accountcode='$suppliercode' AND entrydate between '$ADate1' and '$ADate2' ";
			$exec2235 = mysql_query($query2235) or die ("Error in Query2".mysql_error());
			$rowcount2 = mysql_num_rows($exec2235);
			//echo $rowcount2;
			while ($res2235 = mysql_fetch_array($exec2235))
			{
				$suppliername1 = $res2235['accountname'];
				$patientcode = $res2235['accountcode'];
				$visitcode = $res2235['docno'];
				$description = 'Opening Balance';
				
				$name='Opening Balance';
				$billnumber = $res2235['docno'];
				$billdate = $res2235['entrydate'];
				$referalname='Opening Balance';
				$billtotalamount = $res2235['amount'];
				$billanum = $res2235['auto_number'];
				$balanceamount = $billtotalamount;
				
				$query778 = "select sum(transactionamount) as dramount from doctorsharing where billnumber = '$billnumber' and billanum = '$billanum'";
				$exec778 = mysql_query($query778) or die ("Error in Query778".mysql_error());
				$row778 = mysql_num_rows($exec778);
				$row778 = mysql_num_rows($exec778);
				$res778 = mysql_fetch_array($exec778);
				$dramount = $res778['dramount'];
				
			if($row778 =='0')
			{	
				
				$sqlmasterdr = "SELECT hospshare,doctorshare FROM master_doctor WHERE doctorcode = '$suppliercode' AND status <> 'deleted' ";
				$execmasterdr = mysql_query($sqlmasterdr) or die("Error in sqlmasterdr ".mysql_error());
				$resmasterdr = mysql_fetch_array($execmasterdr);
				$doctorshareper = $resmasterdr['doctorshare'];
				$hospshareper = $resmasterdr['hospshare']; 
				if($doctorshareper =='0.00' && $hospshareper =='0.00' ){
					$balanceamount = '0.00';
					$hospamount = $billtotalamount;
				}else{
					$balanceamount = ($doctorshareper/100)*$billtotalamount;
					$hospamount = ($hospshareper/100)*$billtotalamount;
				}
				
			if($billtotalamount > '0'){
				
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
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $sno = $sno + 1; ?> </td>
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">
			  <input type="checkbox" name="ack[]" id="acknow<?php echo $sno; ?>" value="<?php echo $billnumber.'|'.$billanum; ?>" onClick="updatebox('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div class="bodytext311"><?php echo $name; ?>(<?php echo $visitcode; ?>)</div></td>
			  <input type="hidden" name="patientcode[]" id="patientcode" value="<?php echo $patientcode; ?>">
			  <input type="hidden" name="visitcode[]" id="visitcode" value="<?php echo $visitcode; ?>">
			  <input type="hidden" name="accountname[]" id="accountname" value="<?php echo $suppliername1; ?>">
			  <input type="hidden" name="doctorname[]" value="<?php echo $referalname; ?>">
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billnumber; ?></div></td>
              <input type="hidden" name="billnum[]" value="<?php echo $billnumber; ?>">
			  <input type="hidden" name="name[]" value="<?php echo $name; ?>">
			  <input type="hidden" name="billdate[]" value="<?php echo $billdate; ?>">
			  <input type="hidden" name="billanum[]" value="<?php echo $billanum; ?>">
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billdate; ?></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
                <?php if ($billtotalamount != '0.00') echo $billtotalamount; //echo number_format($billtotalamount, 2); ?>
              </div></td><input type="hidden" name="billamount" id="billamount<?php echo $sno; ?>" value="<?php if ($billtotalamount != '0.00') echo $billtotalamount; ?>">
              
			 <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input class="bali" type="text" name="adjamount[]" value="<?php echo $balanceamount; ?>" id="adjamount<?php echo $sno; ?>" size="7" <?php if($balanceamount == '0') { echo "readonly"; } ?> onKeyUp="balancecalc('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
             <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input class="bali" type="text" name="hospamount[]" value="<?php echo $hospamount; ?>" id="hospamount<?php echo $sno; ?>" size="7" onKeyUp="balancecalc('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
			<td class="bodytext311" valign="center" bordercolor="#f3f3f3"><input type="text" class="bal" name="balamount[]" id="balamount<?php echo $sno; ?>" size="7" readonly></td>
            </tr>
            <?php
				$totalbalance = $totalbalance + $balanceamount;
			}
			}
				}
				
			$cashamount21 = '';
			$cardamount21 = '';
			$onlineamount21 = '';
			$chequeamount21 = '';
			$tdsamount21 = '';
			$writeoffamount21 = '';
			$hospamount21 = '0.00';
			$taxamount21 = '';
			$totalnumbr='';
			$totalnumb=0;
			$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$totalpurchase1=0;
			$colorloopcount=0;
			//echo $number;
	/*
			$query2 = "select * from billing_paynow where referalname like '%$suppliername%' and billstatus='paid'  AND billdate between '$ADate1' and '$ADate2' ";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			$rowcount2 = mysql_num_rows($exec2);
			//echo $rowcount2;
			while ($res2 = mysql_fetch_array($exec2))
			{
				$suppliername1 = $res2['patientname'];
				$patientcode = $res2['patientcode'];
				$visitcode = $res2['visitcode'];
				$accountname = $res2['accountname'];
				$billnumber = $res2['billno'];
				$billdate = $res2['billdate'];
				$referalname=$res2['referalname'];
				$billanum = $res2['auto_number'];
				
				$query66="select * from consultation_referal where patientvisitcode='$visitcode'";
				$exec66=mysql_query($query66);
				$res66=mysql_fetch_array($exec66);
				$num66=mysql_num_rows($exec66);
				if($num66 == 0)
				{
				$doctorname='';
				}
				else
				{
				$doctorname=$res66['referalname'];
				}
				$query67="select * from master_customer where customercode='$patientcode'";
				$exec67=mysql_query($query67);
				$res67=mysql_fetch_array($exec67);
				$firstname=$res67['customername'];
				$lastname=$res67['customerlastname'];
				$name=$firstname.$lastname;

			
				$query77="select * from master_doctor where doctorname='$referalname'";
				$exec77=mysql_query($query77) or die(mysql_error());
				$res77=mysql_fetch_array($exec77);
				$billtotalamount = $res77['consultationfees'];
				$balanceamount = $billtotalamount;
				
				$query778 = "select billnumber from doctorsharing where billnumber = '$billnumber' and billanum = '$billanum'";
				$exec778 = mysql_query($query778) or die("Error in Query778".mysql_error());
				$row778 = mysql_num_rows($exec778);
				
			if($row778 ==  '0')
			{	
				$sqlmasterdr = "SELECT hospshare,doctorshare FROM master_doctor WHERE doctorcode = '$suppliercode' AND status <> 'deleted' ";
				$execmasterdr = mysql_query($sqlmasterdr) or die("Error in sqlmasterdr ".mysql_error());
				$resmasterdr = mysql_fetch_array($execmasterdr);
				$doctorshareper = $resmasterdr['doctorshare'];
				$hospshareper = $resmasterdr['hospshare']; 
				if($doctorshareper =='0.00' && $hospshareper =='0.00' ){
					$balanceamount = '0.00';
					$hospamount = $billtotalamount;
				}else{
					$balanceamount = ($doctorshareper/100)*$billtotalamount;
					$hospamount = ($hospshareper/100)*$billtotalamount;
				}
				
			if($billtotalamount > '0'){
				
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
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $sno = $sno + 1; ?> 2</td>
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">
			  <input type="checkbox" name="ack[]" id="acknow<?php echo $sno; ?>" value="<?php echo $billnumber.'|'.$billanum; ?>" onClick="updatebox('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div class="bodytext311"><?php echo $name; ?>(<?php echo $visitcode; ?>)</div></td>
			  <input type="hidden" name="patientcode[]" id="patientcode" value="<?php echo $patientcode; ?>">
			  <input type="hidden" name="visitcode[]" id="visitcode" value="<?php echo $visitcode; ?>">
			  <input type="hidden" name="accountname[]" id="accountname" value="<?php echo $accountname; ?>">
			  <input type="hidden" name="doctorname[]" value="<?php echo $doctorname; ?>">
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billnumber; ?></div></td>
              <input type="hidden" name="billnum[]" value="<?php echo $billnumber; ?>">
			  <input type="hidden" name="name[]" value="<?php echo $name; ?>">
			  <input type="hidden" name="billdate[]" value="<?php echo $billdate; ?>">
			  <input type="hidden" name="billanum[]" value="<?php echo $billanum; ?>">
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billdate; ?></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
                <?php if ($billtotalamount != '0.00') echo $billtotalamount; //echo number_format($billtotalamount, 2); ?>
              </div></td><input type="hidden" name="billamount" id="billamount<?php echo $sno; ?>" value="<?php if ($billtotalamount != '0.00') echo $billtotalamount; ?>">
              
			      <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input class="bali" type="text" name="adjamount[]" value="<?php echo $balanceamount; ?>" id="adjamount<?php echo $sno; ?>" size="7" onKeyUp="balancecalc('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
            <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input class="bali" type="text" name="hospamount[]" value="<?php echo $hospamount; ?>" id="hospamount<?php echo $sno; ?>" size="7" onKeyUp="balancecalc('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
		    <td class="bodytext311" valign="center" bordercolor="#f3f3f3"><input type="text" class="bal" name="balamount[]" id="balamount<?php echo $sno; ?>" size="7" readonly></td>
            </tr>
            <?php
				$totalbalance = $totalbalance+ $balanceamount;
			}
			}
				$cashamount21 = '0.00';
				$cardamount21 = '0.00';
				$onlineamount21 = '0.00';
				$chequeamount21 = '0.00';
				$tdsamount21 = '0.00';
				$writeoffamount21 = '0.00';
				$taxamount21 = '0.00';
				$hospamount21 = '0.00';

				$totalpayment = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billtotalamount = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billstatus = '0.00';
			}
			
			*/
			// billing_ipprivatedoctor Start
			
			$query212 = "select * from billing_ipprivatedoctor where doccoa = '$suppliercode' and billstatus='paid' AND recorddate between '$ADate1' and '$ADate2' ";
			$exec212 = mysqli_query($GLOBALS["___mysqli_ston"], $query212) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowcount2 = mysqli_num_rows($exec212);
			//echo $rowcount2;
			while ($res212 = mysqli_fetch_array($exec212))
			{
				$suppliername1 = $res212['patientname'];
				$patientcode = $res212['patientcode'];
				$visitcode = $res212['visitcode'];
				$billnumber = $res212['docno'];
				$billdate = $res212['recorddate'];
				$referalname=$res212['description'];
				$billtotalamount = $res212['amount'];
				$billanum = $res212['auto_number'];
				$description = $res212['description'];
				$accountname = $res212['accountname'];
				
				$len = strlen($suppliername1);
				$desc = substr($description,0,$len);
				if(true)
				{
				
				$query67="select * from master_customer where customercode='$patientcode'";
				$exec67=mysqli_query($GLOBALS["___mysqli_ston"], $query67);
				$res67=mysqli_fetch_array($exec67);
				$firstname=$res67['customername'];
				$lastname=$res67['customerlastname'];
				$name=$firstname.$lastname;
				
				$balanceamount = $billtotalamount;
				
				$query778 = "select billnumber from doctorsharing where billnumber = '$billnumber' and billanum = '$billanum'";
				$exec778 = mysqli_query($GLOBALS["___mysqli_ston"], $query778) or die ("Error in Query778".mysqli_error($GLOBALS["___mysqli_ston"]));
				$row778 = mysqli_num_rows($exec778);
				
			if($row778 == '0')
			{	
				$sqlmasterdr = "SELECT hospshare,doctorshare FROM master_doctor WHERE doctorcode = '$suppliercode' AND status <> 'deleted' ";
				$execmasterdr = mysqli_query($GLOBALS["___mysqli_ston"], $sqlmasterdr) or die("Error in sqlmasterdr ".mysqli_error($GLOBALS["___mysqli_ston"]));
				$resmasterdr = mysqli_fetch_array($execmasterdr);
				$doctorshareper = $resmasterdr['doctorshare'];
				$hospshareper = $resmasterdr['hospshare']; 
				if($doctorshareper =='0.00' && $hospshareper =='0.00' ){
					$balanceamount = '0.00';
					$hospamount = $billtotalamount;
				}else{
					$balanceamount = ($doctorshareper/100)*$billtotalamount;
					$hospamount = ($hospshareper/100)*$billtotalamount;
				}
				
			if($billtotalamount > '0'){
				
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
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $sno = $sno + 1; ?> </td>
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">
			  <input type="checkbox" name="ack[]" id="acknow<?php echo $sno; ?>" value="<?php echo $billnumber.'|'.$billanum; ?>" onClick="updatebox('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div class="bodytext311"><?php echo $name; ?>(<?php echo $visitcode; ?>)</div></td>
			  <input type="hidden" name="patientcode[]" id="patientcode" value="<?php echo $patientcode; ?>">
			  <input type="hidden" name="visitcode[]" id="visitcode" value="<?php echo $visitcode; ?>">
			  <input type="hidden" name="accountname[]" id="accountname" value="<?php echo $accountname; ?>">
			  <input type="hidden" name="doctorname[]" value="<?php echo $referalname; ?>">
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billnumber; ?></div></td>
              <input type="hidden" name="billnum[]" value="<?php echo $billnumber; ?>">
			  <input type="hidden" name="name[]" value="<?php echo $name; ?>">
			  <input type="hidden" name="billdate[]" value="<?php echo $billdate; ?>">
			  <input type="hidden" name="billanum[]" value="<?php echo $billanum; ?>">
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billdate; ?></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
                <?php if ($billtotalamount != '0.00') echo $billtotalamount; //echo number_format($billtotalamount, 2); ?>
              </div></td><input type="hidden" name="billamount" id="billamount<?php echo $sno; ?>" value="<?php if ($billtotalamount != '0.00') echo $billtotalamount; ?>">
              
			      <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input class="bali" type="text" name="adjamount[]" value="<?php echo $balanceamount; ?>" id="adjamount<?php echo $sno; ?>" size="7" onKeyUp="balancecalc('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
             <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input class="bali" type="text" name="hospamount[]" value="<?php echo $hospamount; ?>" id="hospamount<?php echo $sno; ?>" size="7" onKeyUp="balancecalc('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
			<td class="bodytext311" valign="center" bordercolor="#f3f3f3"><input type="text" class="bal" name="balamount[]" id="balamount<?php echo $sno; ?>" size="7" readonly></td>
            </tr>
            <?php
				$totalbalance = $totalbalance + $balanceamount;
				
			}
			}	
				}
					$cashamount21 = '0.00';
				$cardamount21 = '0.00';
				$onlineamount21 = '0.00';
				$chequeamount21 = '0.00';
				$tdsamount21 = '0.00';
				$writeoffamount21 = '0.00';
				$taxamount21 = '0.00';
				$hospamount21 = '0.00';

				$totalpayment = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billtotalamount = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billstatus = '0.00';
			}
			
			// billing_ipprivatedoctor End
			
			?>
			
			
			
			<?php
			
			//billing_ipservices Start
			
			$query213 = "select * from billing_ipservices where doctorcode = '$suppliercode' and billstatus='paid' AND wellnessitem <> '1' AND billdate between '$ADate1' and '$ADate2' ";
			$exec213 = mysqli_query($GLOBALS["___mysqli_ston"], $query213) or die ("Error in Query213".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowcount2 = mysqli_num_rows($exec213);
			//echo $rowcount2;
			while ($res213 = mysqli_fetch_array($exec213))
			{
				$suppliername1 = $res213['patientname'];
				$patientcode = $res213['patientcode'];
				$visitcode = $res213['patientvisitcode'];
				$billnumber = $res213['billnumber'];
				$billdate = $res213['billdate'];
				$referalname=$res213['doctorname'];
				$billtotalamount = $res213['servicesitemrate'];
				$billanum = $res213['auto_number'];
				$accountname = $res213['accountname'];
				
				$query673="select * from master_customer where customercode='$patientcode'";
				$exec673=mysqli_query($GLOBALS["___mysqli_ston"], $query673);
				$res673=mysqli_fetch_array($exec673);
				$firstname=$res673['customername'];
				$lastname=$res673['customerlastname'];
				$name=$firstname.$lastname;
				
				$balanceamount = $billtotalamount;
				
				$query778 = "select billnumber from doctorsharing where billnumber = '$billnumber' and billanum = '$billanum'";
				$exec778 = mysqli_query($GLOBALS["___mysqli_ston"], $query778) or die ("Error in Query778".mysqli_error($GLOBALS["___mysqli_ston"]));
				$row778 = mysqli_num_rows($exec778);
				
			if($row778 == '0')
			{	
				$sqlmasterdr = "SELECT hospshare,doctorshare FROM master_doctor WHERE doctorcode = '$suppliercode' AND status <> 'deleted' ";
				$execmasterdr = mysqli_query($GLOBALS["___mysqli_ston"], $sqlmasterdr) or die("Error in sqlmasterdr ".mysqli_error($GLOBALS["___mysqli_ston"]));
				$resmasterdr = mysqli_fetch_array($execmasterdr);
				$doctorshareper = $resmasterdr['doctorshare'];
				$hospshareper = $resmasterdr['hospshare']; 
				if($doctorshareper =='0.00' && $hospshareper =='0.00' ){
					$balanceamount = '0.00';
					$hospamount = $billtotalamount;
				}else{
					$balanceamount = ($doctorshareper/100)*$billtotalamount;
					$hospamount = ($hospshareper/100)*$billtotalamount;
				}
				
			if($billtotalamount > '0'){
				
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
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $sno = $sno + 1; ?> </td>
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">
			  <input type="checkbox" name="ack[]" id="acknow<?php echo $sno; ?>" value="<?php echo $billnumber.'|'.$billanum; ?>" onClick="updatebox('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div class="bodytext311"><?php echo $name; ?>(<?php echo $visitcode; ?>)</div></td>
			  <input type="hidden" name="patientcode[]" id="patientcode" value="<?php echo $patientcode; ?>">
			  <input type="hidden" name="visitcode[]" id="visitcode" value="<?php echo $visitcode; ?>">
			  <input type="hidden" name="accountname[]" id="accountname" value="<?php echo $accountname; ?>">
			  <input type="hidden" name="doctorname[]" value="<?php echo $referalname; ?>">
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billnumber; ?></div></td>
              <input type="hidden" name="billnum[]" value="<?php echo $billnumber; ?>">
			  <input type="hidden" name="name[]" value="<?php echo $name; ?>">
			  <input type="hidden" name="billdate[]" value="<?php echo $billdate; ?>">
			  <input type="hidden" name="billanum[]" value="<?php echo $billanum; ?>">
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billdate; ?></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
                <?php if ($billtotalamount != '0.00') echo $billtotalamount; //echo number_format($billtotalamount, 2); ?>
              </div></td><input type="hidden" name="billamount" id="billamount<?php echo $sno; ?>" value="<?php if ($billtotalamount != '0.00') echo $billtotalamount; ?>">
              
			      <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input class="bali" type="text" name="adjamount[]" value="<?php echo $balanceamount; ?>" id="adjamount<?php echo $sno; ?>" size="7" onKeyUp="balancecalc('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
             <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input class="bali" type="text" name="hospamount[]" value="<?php echo $hospamount; ?>" id="hospamount<?php echo $sno; ?>" size="7" onKeyUp="balancecalc('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
			<td class="bodytext311" valign="center" bordercolor="#f3f3f3"><input type="text" class="bal" name="balamount[]" id="balamount<?php echo $sno; ?>" size="7" readonly></td>
            </tr>
            <?php
				$totalbalance = $totalbalance + $balanceamount;
			
			}	
				}
					$cashamount21 = '0.00';
				$cardamount21 = '0.00';
				$onlineamount21 = '0.00';
				$chequeamount21 = '0.00';
				$tdsamount21 = '0.00';
				$writeoffamount21 = '0.00';
				$taxamount21 = '0.00';
				$hospamount21 = '0.00';

				$totalpayment = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billtotalamount = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billstatus = '0.00';
			}
			//billing_ipservices End
			?>
			
			<?php
			/*
			//ipconsultation_services Start
			
			$query213 = "select * from ipconsultation_services where doctorcode = '$suppliercode' and servicerefund <> 'refund' AND consultationdate between '$ADate1' and '$ADate2' ";
			$exec213 = mysql_query($query213) or die ("Error in Query213".mysql_error());
			$rowcount2 = mysql_num_rows($exec213);
			//echo $rowcount2;
			while ($res213 = mysql_fetch_array($exec213))
			{
				$suppliername1 = $res213['patientname'];
				$patientcode = $res213['patientcode'];
				$visitcode = $res213['patientvisitcode'];
				$billnumber = $res213['iptestdocno'];
				$billdate = $res213['consultationdate'];
				$referalname=$res213['doctorname'];
				$billtotalamount = $res213['amount'];
				$billanum = $res213['auto_number'];
				$accountname = $res213['accountname'];
				
				
				
				$sqlchk = "SELECT visitcode FROM billing_ip WHERE visitcode = '$visitcode'";
				$quechk = mysql_query($sqlchk) or die("SQL error sqlchk".mysql_error());
				$numchk = mysql_num_rows($quechk);
				
				$sqlchk1 = "SELECT visitcode FROM billing_ipcreditapproved WHERE visitcode = '$visitcode'";
				$quechk1 = mysql_query($sqlchk1) or die("SQL error sqlchk1".mysql_error());
				$numchk1 = mysql_num_rows($quechk1);
				
				$numcount = $numchk + $numchk1;
				//echo $visitcode." -> ".$numcount." / ".$numchk." / ".$numchk1."<br>";
				
				if($numcount > 0)
				{
				
				$query673="select * from master_customer where customercode='$patientcode'";
				$exec673=mysql_query($query673);
				$res673=mysql_fetch_array($exec673);
				$firstname=$res673['customername'];
				$lastname=$res673['customerlastname'];
				$name=$firstname.$lastname;
				
				$balanceamount = $billtotalamount;
				
				$query778 = "select billnumber from doctorsharing where billnumber = '$billnumber' and billanum = '$billanum'";
				$exec778 = mysql_query($query778) or die ("Error in Query778".mysql_error());
				$row778 = mysql_num_rows($exec778);
				
			if($row778 == '0')
			{	
				$sqlmasterdr = "SELECT hospshare,doctorshare FROM master_doctor WHERE doctorcode = '$suppliercode' AND status <> 'deleted' ";
				$execmasterdr = mysql_query($sqlmasterdr) or die("Error in sqlmasterdr ".mysql_error());
				$resmasterdr = mysql_fetch_array($execmasterdr);
				$doctorshareper = $resmasterdr['doctorshare'];
				$hospshareper = $resmasterdr['hospshare']; 
				if($doctorshareper =='0.00' && $hospshareper =='0.00' ){
					$balanceamount = '0.00';
					$hospamount = $billtotalamount;
				}else{
					$balanceamount = ($doctorshareper/100)*$billtotalamount;
					$hospamount = ($hospshareper/100)*$billtotalamount;
				}
				
			if($billtotalamount > '0'){
				
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
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $sno = $sno + 1; ?> </td>
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">
			  <input type="checkbox" name="ack[]" id="acknow<?php echo $sno; ?>" value="<?php echo $billnumber.'|'.$billanum; ?>" onClick="updatebox('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div class="bodytext311"><?php echo $name; ?>(<?php echo $visitcode; ?>)</div></td>
			  <input type="hidden" name="patientcode[]" id="patientcode" value="<?php echo $patientcode; ?>">
			  <input type="hidden" name="visitcode[]" id="visitcode" value="<?php echo $visitcode; ?>">
			  <input type="hidden" name="accountname[]" id="accountname" value="<?php echo $accountname; ?>">
			  <input type="hidden" name="doctorname[]" value="<?php echo $referalname; ?>">
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billnumber; ?></div></td>
              <input type="hidden" name="billnum[]" value="<?php echo $billnumber; ?>">
			  <input type="hidden" name="name[]" value="<?php echo $name; ?>">
			  <input type="hidden" name="billdate[]" value="<?php echo $billdate; ?>">
			  <input type="hidden" name="billanum[]" value="<?php echo $billanum; ?>">
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billdate; ?></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
                <?php if ($billtotalamount != '0.00') echo $billtotalamount; //echo number_format($billtotalamount, 2); ?>
              </div></td><input type="hidden" name="billamount" id="billamount<?php echo $sno; ?>" value="<?php if ($billtotalamount != '0.00') echo $billtotalamount; ?>">
              
			      <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input class="bali" type="text" name="adjamount[]" value="<?php echo $balanceamount; ?>" id="adjamount<?php echo $sno; ?>" size="7" onKeyUp="balancecalc('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
             <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input class="bali" type="text" name="hospamount[]" value="<?php echo $hospamount; ?>" id="hospamount<?php echo $sno; ?>" size="7" onKeyUp="balancecalc('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
			<td class="bodytext311" valign="center" bordercolor="#f3f3f3"><input type="text" class="bal" name="balamount[]" id="balamount<?php echo $sno; ?>" size="7" readonly></td>
            </tr>
            <?php
				$totalbalance = $totalbalance + $balanceamount;
				
			}
			}	
				}
					$cashamount21 = '0.00';
				$cardamount21 = '0.00';
				$onlineamount21 = '0.00';
				$chequeamount21 = '0.00';
				$tdsamount21 = '0.00';
				$writeoffamount21 = '0.00';
				$taxamount21 = '0.00';
				$hospamount21 = '0.00';

				$totalpayment = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billtotalamount = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billstatus = '0.00';
			}*/
			//ipconsultation_services End
			?>
			
			<!-- Billing Paylater Referal Start -->
				
			<?php
			
			$billnumbers2 = array();
			$query45 = "select billnumber,patientvisitcode from billing_paylaterreferal  where referalcode='$suppliercode' AND billdate between '$ADate1' and '$ADate2' group by billnumber";
			$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die ("Error in Query45".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num45 = mysqli_num_rows($exec45);
			while ($res45 = mysqli_fetch_array($exec45))
			{
				$resvis=$res45['patientvisitcode'];
				//echo "select visitcode from billing_paylater where visitcode='$resvis' and billstatus='paid'";
				$query5=mysqli_query($GLOBALS["___mysqli_ston"], "select visitcode from billing_paylater where visitcode='$resvis'and billstatus='paid'");
				$num05=mysqli_num_rows($query5);
				if($num05 > 0)
				{
					array_push($billnumbers2, $res45['billnumber']);
					
				}
				
			} 
				//print_r($billnumbers2);
				$totalbillnumbers21 = "'".implode("','", $billnumbers2)."'";
				if($totalbillnumbers21 =='')
				{
					$totalbillnumbers21 ="''";
				}
			$query451 = "select auto_number,billdate as groupdate,patientname,patientcode,patientvisitcode,billnumber,sum(referalrate) as referalrate,accountname from billing_paylaterreferal  where referalcode='$suppliercode' and  billnumber in ($totalbillnumbers21)  AND billdate between '$ADate1' and '$ADate2' group by billnumber,patientvisitcode";
					
			$exec451 = mysqli_query($GLOBALS["___mysqli_ston"], $query451) or die ("Error in Query451 ".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num451 = mysqli_num_rows($exec451);
			while ($res451 = mysqli_fetch_array($exec451))
			{
			
			$billdate = $res451['groupdate'];
			$patientname = $res451['patientname'];
			$patientcode = $res451['patientcode'];
			$visitcode = $res451['patientvisitcode'];
			$res45billnumber = $res451['billnumber'];
			$billtotalamount = $res451['referalrate'];
			$accountname = $res451['accountname'];
			$suppliername = $res451['accountname'];
			$billanum=$res451['auto_number'];
			$referalname = $res451['accountname'];
			
			$billnumber = $res451['billnumber'];
			$visitcode = $res451['patientvisitcode']; 
			
				$query67="select * from master_customer where customercode='$patientcode'";
				$exec67=mysqli_query($GLOBALS["___mysqli_ston"], $query67);
				$res67=mysqli_fetch_array($exec67);
				$firstname=$res67['customername'];
				$lastname=$res67['customerlastname'];
				$name=$firstname.$lastname;
			
			
			$query778 = "select billnumber from doctorsharing where billnumber = '$billnumber' and billanum = '$billanum'";
			$exec778 = mysqli_query($GLOBALS["___mysqli_ston"], $query778) or die ("Error in Query778".mysqli_error($GLOBALS["___mysqli_ston"]));
			$row778 = mysqli_num_rows($exec778);
				
			if($row778 == '0')
			{	
				$sqlmasterdr = "SELECT hospshare,doctorshare FROM master_doctor WHERE doctorcode = '$suppliercode' AND status <> 'deleted' ";
				$execmasterdr = mysqli_query($GLOBALS["___mysqli_ston"], $sqlmasterdr) or die("Error in sqlmasterdr ".mysqli_error($GLOBALS["___mysqli_ston"]));
				$resmasterdr = mysqli_fetch_array($execmasterdr);
				$doctorshareper = $resmasterdr['doctorshare'];
				$hospshareper = $resmasterdr['hospshare']; 
				if($doctorshareper =='0.00' && $hospshareper =='0.00' ){
					$balanceamount = '0.00';
					$hospamount = $billtotalamount;
				}else{
					$balanceamount = ($doctorshareper/100)*$billtotalamount;
					$hospamount = ($hospshareper/100)*$billtotalamount;
				}
				
			if($billtotalamount > '0'){
				
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
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $sno = $sno + 1; ?> </td>
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">
			  <input type="checkbox" name="ack[]" id="acknow<?php echo $sno; ?>" value="<?php echo $billnumber.'|'.$billanum; ?>" onClick="updatebox('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div class="bodytext311"><?php echo $name; ?>(<?php echo $visitcode; ?>)</div></td>
			  <input type="hidden" name="patientcode[]" id="patientcode" value="<?php echo $patientcode; ?>">
			  <input type="hidden" name="visitcode[]" id="visitcode" value="<?php echo $visitcode; ?>">
			  <input type="hidden" name="accountname[]" id="accountname" value="<?php echo $accountname; ?>">
			  <input type="hidden" name="doctorname[]" value="<?php echo $referalname; ?>">
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billnumber; ?></div></td>
              <input type="hidden" name="billnum[]" value="<?php echo $billnumber; ?>">
			  <input type="hidden" name="name[]" value="<?php echo $name; ?>">
			  <input type="hidden" name="billdate[]" value="<?php echo $billdate; ?>">
			  <input type="hidden" name="billanum[]" value="<?php echo $billanum; ?>">
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billdate; ?></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
                <?php if ($billtotalamount != '0.00') echo $billtotalamount; //echo number_format($billtotalamount, 2); ?>
              </div></td><input type="hidden" name="billamount" id="billamount<?php echo $sno; ?>" value="<?php if ($billtotalamount != '0.00') echo $billtotalamount; ?>">
              
			      <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input class="bali" type="text" name="adjamount[]" value="<?php echo $balanceamount; ?>" id="adjamount<?php echo $sno; ?>" size="7" onKeyUp="balancecalc('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
             <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input class="bali" type="text" name="hospamount[]" value="<?php echo $hospamount; ?>" id="hospamount<?php echo $sno; ?>" size="7" onKeyUp="balancecalc('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
			<td class="bodytext311" valign="center" bordercolor="#f3f3f3"><input type="text" class="bal" name="balamount[]" id="balamount<?php echo $sno; ?>" size="7" readonly></td>
            </tr>
            <?php
				$totalbalance = $totalbalance + $balanceamount;
			}
			}
					$cashamount21 = '0.00';
				$cardamount21 = '0.00';
				$onlineamount21 = '0.00';
				$chequeamount21 = '0.00';
				$tdsamount21 = '0.00';
				$writeoffamount21 = '0.00';
				$taxamount21 = '0.00';
				$hospamount21 = '0.00';

				$totalpayment = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billtotalamount = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billstatus = '0.00';
			}
			?>
					<!-- Billing Paylater Referal End -->
				
					<!-- Billing Paynow Referal Start -->
			<?php
			$billnumbers3 = array();
			$query452 = "select billnumber,patientvisitcode from billing_paynowreferal  where referalcode='$suppliercode' AND billdate between '$ADate1' and '$ADate2'  group by billnumber";
			$exec452 = mysqli_query($GLOBALS["___mysqli_ston"], $query452) or die ("Error in Query452".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num452 = mysqli_num_rows($exec452);
			while ($res452 = mysqli_fetch_array($exec452))
			{
				$resvis=$res452['patientvisitcode'];
				//echo "select visitcode from billing_paynow where visitcode='$resvis' and billstatus='paid'";
				$query5=mysqli_query($GLOBALS["___mysqli_ston"], "select visitcode from billing_paynow where visitcode='$resvis'and billstatus='paid'");
				$num05=mysqli_num_rows($query5);
				if($num05 > 0)
				{
					array_push($billnumbers3, $res452['billnumber']);
					
				}
				
			} 
				//print_r($billnumbers2);
				$totalbillnumbers11 = "'".implode("','", $billnumbers3)."'";
				if($totalbillnumbers11 =='')
				{
					$totalbillnumbers11 ="''";
				}
			$query453 = "select auto_number,billdate as groupdate,patientname,patientcode,patientvisitcode,billnumber,sum(referalrate) as referalrate,accountname from billing_paynowreferal  where referalcode='$suppliercode' and  billnumber in ($totalbillnumbers11) AND billdate between '$ADate1' and '$ADate2' group by billnumber,patientvisitcode";
					
			$exec453 = mysqli_query($GLOBALS["___mysqli_ston"], $query453) or die ("Error in Query453 ".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num453 = mysqli_num_rows($exec453);
			while ($res453 = mysqli_fetch_array($exec453))
			{
		
			$billdate = $res453['groupdate'];
			$patientname = $res453['patientname'];
			$patientcode = $res453['patientcode'];
			$visitcode = $res453['patientvisitcode'];
			$res45billnumber = $res453['billnumber'];
			$billtotalamount = $res453['referalrate'];
			$accountname = $res453['accountname'];
			$suppliername = $res453['accountname'];
			$billanum=$res453['auto_number'];
			$referalname = $res453['accountname'];
			
			$billnumber = $res453['billnumber'];
			$visitcode = $res453['patientvisitcode']; 
			
				$query67="select * from master_customer where customercode='$patientcode'";
				$exec67=mysqli_query($GLOBALS["___mysqli_ston"], $query67);
				$res67=mysqli_fetch_array($exec67);
				$firstname=$res67['customername'];
				$lastname=$res67['customerlastname'];
				$name=$firstname.$lastname;
			
			
			$query778 = "select billnumber from doctorsharing where billnumber = '$billnumber' and billanum = '$billanum'";
			$exec778 = mysqli_query($GLOBALS["___mysqli_ston"], $query778) or die ("Error in Query778".mysqli_error($GLOBALS["___mysqli_ston"]));
			$row778 = mysqli_num_rows($exec778);
				
			if($row778 == '0')
			{	
				$sqlmasterdr = "SELECT hospshare,doctorshare FROM master_doctor WHERE doctorcode = '$suppliercode' AND status <> 'deleted' ";
				$execmasterdr = mysqli_query($GLOBALS["___mysqli_ston"], $sqlmasterdr) or die("Error in sqlmasterdr ".mysqli_error($GLOBALS["___mysqli_ston"]));
				$resmasterdr = mysqli_fetch_array($execmasterdr);
				$doctorshareper = $resmasterdr['doctorshare'];
				$hospshareper = $resmasterdr['hospshare']; 
				if($doctorshareper =='0.00' && $hospshareper =='0.00' ){
					$balanceamount = '0.00';
					$hospamount = $billtotalamount;
				}else{
					$balanceamount = ($doctorshareper/100)*$billtotalamount;
					$hospamount = ($hospshareper/100)*$billtotalamount;
				}
				
			if($billtotalamount > '0'){
				
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
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $sno = $sno + 1; ?> </td>
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">
			  <input type="checkbox" name="ack[]" id="acknow<?php echo $sno; ?>" value="<?php echo $billnumber.'|'.$billanum; ?>" onClick="updatebox('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div class="bodytext311"><?php echo $name; ?>(<?php echo $visitcode; ?>)</div></td>
			  <input type="hidden" name="patientcode[]" id="patientcode" value="<?php echo $patientcode; ?>">
			  <input type="hidden" name="visitcode[]" id="visitcode" value="<?php echo $visitcode; ?>">
			  <input type="hidden" name="accountname[]" id="accountname" value="<?php echo $accountname; ?>">
			  <input type="hidden" name="doctorname[]" value="<?php echo $referalname; ?>">
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billnumber; ?></div></td>
              <input type="hidden" name="billnum[]" value="<?php echo $billnumber; ?>">
			  <input type="hidden" name="name[]" value="<?php echo $name; ?>">
			  <input type="hidden" name="billdate[]" value="<?php echo $billdate; ?>">
			  <input type="hidden" name="billanum[]" value="<?php echo $billanum; ?>">
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billdate; ?></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
                <?php if ($billtotalamount != '0.00') echo $billtotalamount; //echo number_format($billtotalamount, 2); ?>
              </div></td><input type="hidden" name="billamount" id="billamount<?php echo $sno; ?>" value="<?php if ($billtotalamount != '0.00') echo $billtotalamount; ?>">
              
			      <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input class="bali" type="text" name="adjamount[]" value="<?php echo $balanceamount; ?>" id="adjamount<?php echo $sno; ?>" size="7" onKeyUp="balancecalc('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
             <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input class="bali" type="text" name="hospamount[]" value="<?php echo $hospamount; ?>" id="hospamount<?php echo $sno; ?>" size="7" onKeyUp="balancecalc('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
			<td class="bodytext311" valign="center" bordercolor="#f3f3f3"><input type="text" class="bal" name="balamount[]" id="balamount<?php echo $sno; ?>" size="7" readonly></td>
            </tr>
            <?php
				$totalbalance = $totalbalance + $balanceamount;
				}
			}
					$cashamount21 = '0.00';
				$cardamount21 = '0.00';
				$onlineamount21 = '0.00';
				$chequeamount21 = '0.00';
				$tdsamount21 = '0.00';
				$writeoffamount21 = '0.00';
				$taxamount21 = '0.00';
				$hospamount21 = '0.00';

				$totalpayment = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billtotalamount = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billstatus = '0.00';
			}
			?>
				<!-- Billing Paynow Referal End -->
				
				<!-- Billing master_consultationlist Start -->
		<?php
			
			$consdrusername = array();
			$consdrvisitcode = array();
			
			$sqlconsult = "SELECT doctorcode,doctorname FROM master_doctor WHERE doctorcode = '$suppliercode' AND status <>'deleted' ";
			$execonsult = mysqli_query($GLOBALS["___mysqli_ston"], $sqlconsult) or die("Error in sqlconsult ".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($resconsult = mysqli_fetch_array($execonsult)){
				
				$doctorcode = $resconsult['doctorcode'];
				$doctorname = $resconsult['doctorname'];
				$execonsult1=mysqli_query($GLOBALS["___mysqli_ston"], "select docusername from doctor_mapping where doctorcode='$doctorcode'and status <> 'deleted' ORDER BY docusername ASC");
				$numconsult1=mysqli_num_rows($execonsult1);
				while($resconsult1 = mysqli_fetch_array($execonsult1)){
					if($numconsult1 > 0)
					{
						array_push($consdrusername, $resconsult1['docusername']);
						
					}	
				}		
						
			}
			//print_r($consdrusername);
			$totalconsdrusername = "'".implode("','", $consdrusername)."'";
			if($totalconsdrusername =='')
			{
				$totalconsdrusername ="''";
			}
			//print_r($totalconsdrusername); consultationdate
			
			$sqlconsult2 = "SELECT visitcode FROM master_consultationlist WHERE username IN ($totalconsdrusername) AND formflag IN (2,3) AND username <> '' AND consultationdate between '$ADate1' and '$ADate2' GROUP BY visitcode";
			$execonsult2 = mysqli_query($GLOBALS["___mysqli_ston"], $sqlconsult2) or die("Error in sqlconsult2 ".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numconsult2 = mysqli_num_rows($execonsult2);

			while($resconsult2 = mysqli_fetch_array($execonsult2)){
				array_push($consdrvisitcode, $resconsult2['visitcode']);
			}
			//print_r($consdrvisitcode);
			$totalvisitcodes = "'".implode("','", $consdrvisitcode)."'";
			if($totalvisitcodes =='')
			{
				$totalvisitcodes ="''";
			}
			
			$sqlconsult3 = "SELECT visitcode FROM master_consultationlist WHERE username IN ($totalconsdrusername) AND formflag IN (1) AND username <> '' AND visitcode NOT IN ($totalvisitcodes) ";
			$execonsult3 = mysqli_query($GLOBALS["___mysqli_ston"], $sqlconsult3) or die("Error in sqlconsult3 ".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($resconsult3 = mysqli_fetch_array($execonsult3)){
				array_push($consdrvisitcode, $resconsult3['visitcode']);
			}
			
			$totalvisitcode = "'".implode("','", $consdrvisitcode)."'";
			if($totalvisitcode =='')
			{
				$totalvisitcode ="''";
			}
			
			$query415 = "select * from master_visitentry where visitcode IN ($totalvisitcode)";
			$exec415 = mysqli_query($GLOBALS["___mysqli_ston"], $query415) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowcount2 = mysqli_num_rows($exec415);
			while ($res415 = mysqli_fetch_array($exec415))
			{
				$suppliername1 = $res415['patientfullname'];
				$patientcode = $res415['patientcode'];
				$visitcode = $res415['visitcode'];
				$accountname1 = $res415['accountname'];
				$billtype = $res415['billtype'];
				$referalname=$res415['consultingdoctor'];
				
				
				$query = mysqli_query($GLOBALS["___mysqli_ston"], "select accountname from master_accountname where auto_number = '$accountname1'");
				$res = mysqli_fetch_array($query);
				$accountname = $res['accountname'];
				
				$query67="select * from master_customer where customercode='$patientcode'";
				$exec67=mysqli_query($GLOBALS["___mysqli_ston"], $query67);
				$res67=mysqli_fetch_array($exec67);
				$firstname=$res67['customername'];
				$lastname=$res67['customerlastname'];
				$name=$firstname.$lastname;
				if($billtype =='PAY LATER'){
					$query30 = "select billno,billdate,auto_number,totalamount from billing_paylaterconsultation where patientcode = '$patientcode' and visitcode = '$visitcode' AND billdate between '$ADate1' and '$ADate2' ";
				}
				if($billtype =='PAY NOW'){
					$query30 = "select billnumber as billno,billdate,auto_number,transactionamount as totalamount from billing_consultation where patientcode = '$patientcode' and patientvisitcode = '$visitcode' AND billdate between '$ADate1' and '$ADate2' ";
				}
				//echo $query30;
				$exec30 = mysqli_query($GLOBALS["___mysqli_ston"], $query30) or die ("Error in Query30".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res30 = mysqli_fetch_array($exec30);
				
				
				$billnumber = $res30['billno'];
				$billdate = $res30['billdate'];
				$billanum = $res30['auto_number'];
				
				$billtotalamount = $res30['totalamount'];
				$balanceamount = $billtotalamount;

				$query778 = "select billnumber from doctorsharing where billnumber = '$billnumber' and billanum = '$billanum'";
				$exec778 = mysqli_query($GLOBALS["___mysqli_ston"], $query778) or die("Error in Query778".mysqli_error($GLOBALS["___mysqli_ston"]));
				$row778 = mysqli_num_rows($exec778);
				
			if($row778 ==  '0')
			{	
				
				$sqlmasterdr = "SELECT hospshare,doctorshare FROM master_doctor WHERE doctorcode = '$suppliercode' AND status <> 'deleted' ";
				$execmasterdr = mysqli_query($GLOBALS["___mysqli_ston"], $sqlmasterdr) or die("Error in sqlmasterdr ".mysqli_error($GLOBALS["___mysqli_ston"]));
				$resmasterdr = mysqli_fetch_array($execmasterdr);
				$doctorshareper = $resmasterdr['doctorshare'];
				$hospshareper = $resmasterdr['hospshare']; 
				if($doctorshareper =='0.00' && $hospshareper =='0.00' ){
					$balanceamount = '0.00';
					$hospamount = $billtotalamount;
				}else{
					$balanceamount = ($doctorshareper/100)*$billtotalamount;
					$hospamount = ($hospshareper/100)*$billtotalamount;
				}
				
			if($billtotalamount > '0'){
				
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
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $sno = $sno + 1; ?> </td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">
					<input type="checkbox" name="ack[]" id="acknow<?php echo $sno; ?>" value="<?php echo $billnumber.'|'.$billanum; ?>" onClick="updatebox('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')">
				</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div class="bodytext311"><?php echo $name; ?>(<?php echo $visitcode; ?>)</div></td>
				<input type="hidden" name="patientcode[]" id="patientcode" value="<?php echo $patientcode; ?>">
				<input type="hidden" name="visitcode[]" id="visitcode" value="<?php echo $visitcode; ?>">
				<input type="hidden" name="accountname[]" id="accountname" value="<?php echo $accountname; ?>">
				<input type="hidden" name="doctorname[]" value="<?php echo $referalname; ?>">
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billnumber; ?></div></td>
				<input type="hidden" name="billnum[]" value="<?php echo $billnumber; ?>">
				<input type="hidden" name="name[]" value="<?php echo $name; ?>">
				<input type="hidden" name="billdate[]" value="<?php echo $billdate; ?>">
				<input type="hidden" name="billanum[]" value="<?php echo $billanum; ?>">
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billdate; ?></div></td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
					<?php if ($billtotalamount != '0.00') echo $billtotalamount; //echo number_format($billtotalamount, 2); ?>
				</div></td><input type="hidden" name="billamount" id="billamount<?php echo $sno; ?>" value="<?php if ($billtotalamount != '0.00') echo $billtotalamount; ?>">
				
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input class="bali" type="text" name="adjamount[]" value="<?php echo $balanceamount; ?>" id="adjamount<?php echo $sno; ?>" size="7" onKeyUp="balancecalc('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input class="bali" type="text" name="hospamount[]" value="<?php echo $hospamount; ?>" id="hospamount<?php echo $sno; ?>" size="7" onKeyUp="balancecalc('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3"><input type="text" class="bal" name="balamount[]" id="balamount<?php echo $sno; ?>" size="7" readonly></td>
			</tr>
		<?php
				$totalbalance = $totalbalance + $balanceamount;
			}
			}
				$cashamount21 = '0.00';
				$cardamount21 = '0.00';
				$onlineamount21 = '0.00';
				$chequeamount21 = '0.00';
				$tdsamount21 = '0.00';
				$writeoffamount21 = '0.00';
				$taxamount21 = '0.00';
				$hospamount21 = '0.00';

				$totalpayment = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billtotalamount = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billstatus = '0.00';
			}
		?>
				<!-- Billing master_consultationlist End -->
				
			<?php
			/*
			$query411 = "select * from master_visitentry where consultingdoctor like '%$suppliername%' and billtype = 'PAY NOW' ";
			//$query2 = "select * from master_transaction where transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and transactionmodule = 'SALES' and billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = ''";
			$exec411 = mysql_query($query411) or die ("Error in Query2".mysql_error());
			$rowcount2 = mysql_num_rows($exec411);
			//echo $rowcount2;
			while ($res411 = mysql_fetch_array($exec411))
			{
				$suppliername1 = $res411['patientfullname'];
				$patientcode = $res411['patientcode'];
				$visitcode = $res411['visitcode'];
				$accountname1 = $res411['accountname'];
				
				$query = mysql_query("select accountname from master_accountname where auto_number = '$accountname1'");
				$res = mysql_fetch_array($query);
				$accountname = $res['accountname'];
				
				$query67="select * from master_customer where customercode='$patientcode'";
				$exec67=mysql_query($query67);
				$res67=mysql_fetch_array($exec67);
				$firstname=$res67['customername'];
				$lastname=$res67['customerlastname'];
				$name=$firstname.$lastname;
				
				$query29 = "select * from billing_consultation where patientcode = '$patientcode' and patientvisitcode = '$visitcode' AND billdate between '$ADate1' and '$ADate2' ";
				$exec29 = mysql_query($query29) or die ("Error in Query29".mysql_error());
				$res29 = mysql_fetch_array($exec29);
				
				
				$billnumber = $res29['billnumber'];
				$billdate = $res29['billdate'];
				$referalname=$res411['consultingdoctor'];
				
				$billtotalamount = $res29['consultation'];
				$billanum = $res29['auto_number'];
				$balanceamount = $billtotalamount;
				
				$query778 = "select billnumber from doctorsharing where billnumber = '$billnumber' and billanum = '$billanum'";
				$exec778 = mysql_query($query778) or die("Error in Query778".mysql_error());
				$row778 = mysql_num_rows($exec778);
				
			if($row778 ==  '0')
			{	
				$sqlmasterdr = "SELECT hospshare,doctorshare FROM master_doctor WHERE doctorcode = '$suppliercode' AND status <> 'deleted' ";
				$execmasterdr = mysql_query($sqlmasterdr) or die("Error in sqlmasterdr ".mysql_error());
				$resmasterdr = mysql_fetch_array($execmasterdr);
				$doctorshareper = $resmasterdr['doctorshare'];
				$hospshareper = $resmasterdr['hospshare']; 
				if($doctorshareper =='0.00' && $hospshareper =='0.00' ){
					$balanceamount = '0.00';
					$hospamount = $billtotalamount;
				}else{
					$balanceamount = ($doctorshareper/100)*$billtotalamount;
					$hospamount = ($hospshareper/100)*$billtotalamount;
				}
				
			if($billtotalamount > '0'){
				
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
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $sno = $sno + 1; ?> </td>
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">
			  <input type="checkbox" name="ack[]" id="acknow<?php echo $sno; ?>" value="<?php echo $billnumber.'|'.$billanum; ?>" onClick="updatebox('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div class="bodytext311"><?php echo $name; ?>(<?php echo $visitcode; ?>)</div></td>
			  <input type="hidden" name="patientcode[]" id="patientcode" value="<?php echo $patientcode; ?>">
			  <input type="hidden" name="visitcode[]" id="visitcode" value="<?php echo $visitcode; ?>">
			  <input type="hidden" name="accountname[]" id="accountname" value="<?php echo $accountname; ?>">
			  <input type="hidden" name="doctorname[]" value="<?php echo $referalname; ?>">
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billnumber; ?></div></td>
              <input type="hidden" name="billnum[]" value="<?php echo $billnumber; ?>">
			  <input type="hidden" name="name[]" value="<?php echo $name; ?>">
			  <input type="hidden" name="billdate[]" value="<?php echo $billdate; ?>">
			  <input type="hidden" name="billanum[]" value="<?php echo $billanum; ?>">
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billdate; ?></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
                <?php if ($billtotalamount != '0.00') echo $billtotalamount; //echo number_format($billtotalamount, 2); ?>
              </div></td><input type="hidden" name="billamount" id="billamount<?php echo $sno; ?>" value="<?php if ($billtotalamount != '0.00') echo $billtotalamount; ?>">
              
			      <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input class="bali" type="text" name="adjamount[]" value="<?php echo $balanceamount; ?>" id="adjamount<?php echo $sno; ?>" size="7" onKeyUp="balancecalc('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
             <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input class="bali" type="text" name="hospamount[]" value="<?php echo $hospamount; ?>" id="hospamount<?php echo $sno; ?>" size="7" onKeyUp="balancecalc('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
			<td class="bodytext311" valign="center" bordercolor="#f3f3f3"><input type="text" class="bal" name="balamount[]" id="balamount<?php echo $sno; ?>" size="7" readonly></td>
            </tr>
            <?php
				$totalbalance = $totalbalance + $balanceamount;
			}
			}
				$cashamount21 = '0.00';
				$cardamount21 = '0.00';
				$onlineamount21 = '0.00';
				$chequeamount21 = '0.00';
				$tdsamount21 = '0.00';
				$writeoffamount21 = '0.00';
				$taxamount21 = '0.00';
				$hospamount21 = '0.00';

				$totalpayment = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billtotalamount = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billstatus = '0.00';
			}
			?>
				
			<?php
			
			//$billdate = '0000-00-00';
			$query412 = "select * from master_visitentry where consultingdoctor like '%$suppliername%' and billtype = 'PAY LATER'";
			//$query2 = "select * from master_transaction where transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and transactionmodule = 'SALES' and billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = ''";
			$exec412 = mysql_query($query412) or die ("Error in Query2".mysql_error());
			$rowcount2 = mysql_num_rows($exec412);
			//echo $rowcount2;
			while ($res412 = mysql_fetch_array($exec412))
			{
				$suppliername1 = $res412['patientfullname'];
				$patientcode = $res412['patientcode'];
				$visitcode = $res412['visitcode'];
				$accountname1 = $res412['accountname'];
				
				$query = mysql_query("select accountname from master_accountname where auto_number = '$accountname1'");
				$res = mysql_fetch_array($query);
				$accountname = $res['accountname'];
				
				$query67="select * from master_customer where customercode='$patientcode'";
				$exec67=mysql_query($query67);
				$res67=mysql_fetch_array($exec67);
				$firstname=$res67['customername'];
				$lastname=$res67['customerlastname'];
				$name=$firstname.$lastname;
				
				$query30 = "select * from billing_paylaterconsultation where patientcode = '$patientcode' and visitcode = '$visitcode' AND billdate between '$ADate1' and '$ADate2' ";
				$exec30 = mysql_query($query30) or die ("Error in Query30".mysql_error());
				$res30 = mysql_fetch_array($exec30);
				
				
				$billnumber = $res30['billno'];
				$billdate = $res30['billdate'];
				$referalname=$res412['consultingdoctor'];
				$billanum = $res30['auto_number'];
				
				$billtotalamount = $res30['totalamount'];
				$balanceamount = $billtotalamount;
				
				$query778 = "select billnumber from doctorsharing where billnumber = '$billnumber' and billanum = '$billanum'";
				$exec778 = mysql_query($query778) or die("Error in Query778".mysql_error());
				$row778 = mysql_num_rows($exec778);
				
			if($row778 ==  '0')
			{	
				$sqlmasterdr = "SELECT hospshare,doctorshare FROM master_doctor WHERE doctorcode = '$suppliercode' AND status <> 'deleted' ";
				$execmasterdr = mysql_query($sqlmasterdr) or die("Error in sqlmasterdr ".mysql_error());
				$resmasterdr = mysql_fetch_array($execmasterdr);
				$doctorshareper = $resmasterdr['doctorshare'];
				$hospshareper = $resmasterdr['hospshare']; 
				if($doctorshareper =='0.00' && $hospshareper =='0.00' ){
					$balanceamount = '0.00';
					$hospamount = $billtotalamount;
				}else{
					$balanceamount = ($doctorshareper/100)*$billtotalamount;
					$hospamount = ($hospshareper/100)*$billtotalamount;
				}
				
			if($billtotalamount > '0'){
				
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
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $sno = $sno + 1; ?> 8</td>
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">
			  <input type="checkbox" name="ack[]" id="acknow<?php echo $sno; ?>" value="<?php echo $billnumber.'|'.$billanum; ?>" onClick="updatebox('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div class="bodytext311"><?php echo $name; ?>(<?php echo $visitcode; ?>)</div></td>
			  <input type="hidden" name="patientcode[]" id="patientcode" value="<?php echo $patientcode; ?>">
			  <input type="hidden" name="visitcode[]" id="visitcode" value="<?php echo $visitcode; ?>">
			  <input type="hidden" name="accountname[]" id="accountname" value="<?php echo $accountname; ?>">
			  <input type="hidden" name="doctorname[]" value="<?php echo $referalname; ?>">
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billnumber; ?></div></td>
              <input type="hidden" name="billnum[]" value="<?php echo $billnumber; ?>">
			  <input type="hidden" name="name[]" value="<?php echo $name; ?>">
			  <input type="hidden" name="billdate[]" value="<?php echo $billdate; ?>">
			  <input type="hidden" name="billanum[]" value="<?php echo $billanum; ?>">
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billdate; ?></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
                <?php if ($billtotalamount != '0.00') echo $billtotalamount; //echo number_format($billtotalamount, 2); ?>
              </div></td><input type="hidden" name="billamount" id="billamount<?php echo $sno; ?>" value="<?php if ($billtotalamount != '0.00') echo $billtotalamount; ?>">
              
			      <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input class="bali" type="text" name="adjamount[]" value="<?php echo $balanceamount; ?>" id="adjamount<?php echo $sno; ?>" size="7" onKeyUp="balancecalc('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
             <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input class="bali" type="text" name="hospamount[]" value="<?php echo $hospamount; ?>" id="hospamount<?php echo $sno; ?>" size="7" onKeyUp="balancecalc('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
			<td class="bodytext311" valign="center" bordercolor="#f3f3f3"><input type="text" class="bal" name="balamount[]" id="balamount<?php echo $sno; ?>" size="7" readonly></td>
            </tr>
            <?php
				$totalbalance = $totalbalance + $balanceamount;
			}
			}
				$cashamount21 = '0.00';
				$cardamount21 = '0.00';
				$onlineamount21 = '0.00';
				$chequeamount21 = '0.00';
				$tdsamount21 = '0.00';
				$writeoffamount21 = '0.00';
				$taxamount21 = '0.00';
				$hospamount21 = '0.00';

				$totalpayment = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billtotalamount = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billstatus = '0.00';
			}*/
			?>
            <tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5"><input type="hidden" name="totcount" id="totcount" value="<?php echo $sno; ?>" /></td>
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
                bgcolor="#ecf0f5"><div align="right"><strong><?php if ($totalbalance != '') echo number_format($totalbalance, 2, '.', ''); ?></strong></div></td>
             <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">
				<input type="hidden" name="paymentamount" id="paymentamount">
				<input type="hidden" name="netpayable" id="netpayable">
				<input type="hidden" name="totcount" id="totcount" value="<?php echo $sno; ?>">
				<input type="text" name="totaladjamt" id="totaladjamt" size="7" class="bal"></td>
             <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
			</tr>
			<tr>
			<td colspan="5" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="">
				<input type="hidden" name="frmflag2" id="frmflag2" value="frmflag2">
				<input type="hidden" name="doctorcode" id="doctorcode" value="<?php echo $suppliercode; ?>">
				<input type="submit" name="submit5" id="submit5" value="Submit" /></td>
			</tr>
			<script>
			funccheckall();
			</script>	
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
	  
	  </form>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

