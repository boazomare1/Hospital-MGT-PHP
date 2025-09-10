<?php
// Security headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");

session_start();
error_reporting(0);
include ("includes/loginverify.php");
include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
ob_start();
$docno1 = $_SESSION['docno'];
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
$username_auto_number="";
$queryuser = "SELECT employeename, auto_number FROM master_employee WHERE username = ?";
$stmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $queryuser);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result && $resuser = mysqli_fetch_array($result)) {
        $username_auto_number = $resuser['auto_number'];
    }
    mysqli_stmt_close($stmt);
}
//This include updatation takes too long to load for hunge items database.
include ("autocompletebuild_doctor.php");
if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
if (isset($_REQUEST["cbsuppliername"])) { $cbsuppliername = $_REQUEST["cbsuppliername"]; } else { $cbsuppliername = ""; }
if (isset($_REQUEST["billnumbercode"])) { $billnumbercode = $_REQUEST["billnumbercode"]; } else { $billnumbercode = ""; }
$locationdetails = "SELECT locationcode FROM login_locationdetails WHERE username = ? AND docno = ?";
$stmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $locationdetails);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ss", $username, $docno1);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result && $resloc = mysqli_fetch_array($result)) {
        $locationcode = $resloc['locationcode'];
    }
    mysqli_stmt_close($stmt);
}
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "SELECT * FROM master_supplier WHERE auto_number = ?";
	$stmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $query4);
	if ($stmt) {
		mysqli_stmt_bind_param($stmt, "s", $getcanum);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		if ($result && $res4 = mysqli_fetch_array($result)) {
			$cbsuppliername = $res4['suppliername'];
			$suppliername = $res4['suppliername'];
		}
		mysqli_stmt_close($stmt);
	}
}
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }
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
		
		$query1 = "SELECT * FROM master_supplier WHERE suppliercode = ?";
		$stmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $query1);
		if ($stmt) {
			mysqli_stmt_bind_param($stmt, "s", $arraysuppliercode);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
			if ($result && $res1 = mysqli_fetch_array($result)) {
				$supplieranum = $res1['auto_number'];
				$openingbalance = $res1['openingbalance'];
				$cbsuppliername = $arraysuppliername;
				$suppliername = $arraysuppliername;
				$doctorcode = $arraysuppliercode;
			}
			mysqli_stmt_close($stmt);
		}
	}
	else
	{
		$cbsuppliername = $_REQUEST['cbsuppliername'];
		$cbsuppliername = strtoupper($cbsuppliername);
		$suppliername = $_REQUEST['cbsuppliername'];
		$suppliername = strtoupper($suppliername);
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
			
			$paynowbillprefix1 = 'ADP-';
			$paynowbillprefix12=strlen($paynowbillprefix1);
			$query23 = "select * from advance_payment_entry order by auto_number desc limit 0, 1";
			$exec23= mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res23 = mysqli_fetch_array($exec23);
			$billnumber1 = $res23["docno"];
			$billdigit1=strlen($billnumber1);
			if ($billnumber1 == '')
			{
				$billnumbercode1 ='ADP-'.'1';
			}
			else
			{
				$billnumber1 = $res23["docno"];
				$billnumbercode1 = substr($billnumber1,$paynowbillprefix12, $billdigit1);
				//echo $billnumbercode;
				$billnumbercode1 = intval($billnumbercode1);
				$billnumbercode1 = $billnumbercode1 + 1;
				$maxanum1 = $billnumbercode1;
				$billnumbercode1 = 'ADP-'.$maxanum1;
				//echo $companycode;
			}


 			// $paymententrydate = $_REQUEST['paymententrydate'];
			$paymentmode = trim($_REQUEST['paymentmode']);
			$chequenumber_mps = trim($_REQUEST['chequenumber']);
			$chequedate = trim($_REQUEST['ADate1']);
			
			// Validate payment mode
			if (!in_array($paymentmode, ['CASH', 'CHEQUE', 'MPESA', 'ONLINE', 'WRITEOFF'])) {
				$errmsg = "Invalid payment mode selected.";
			}
			
			// Validate required fields based on payment mode
			if ($paymentmode == 'CHEQUE' && empty($chequenumber_mps)) {
				$errmsg = "Cheque number is required for cheque payments.";
			}
			if ($paymentmode == 'CHEQUE' && empty($bankname)) {
				$errmsg = "Bank name is required for cheque payments.";
			}
			if ($paymentmode == 'MPESA' && empty($chequenumber_mps)) {
				$errmsg = "MPESA number is required for MPESA payments.";
			}

			$bankname1 = trim($_REQUEST['bankname']);
			$banknamesp = explode('||', $bankname1);
			$bankcode = isset($banknamesp[0]) ? trim($banknamesp[0]) : '';
			$bankname = isset($banknamesp[1]) ? trim($banknamesp[1]) : '';

			// $bankbranch = $_REQUEST['bankbranch'];
			$remarks = trim($_REQUEST['remarks']);
			// $paymentamount = $_REQUEST['paymentamount'];
			 // $netpayable = $_REQUEST['netpayable'];
      		  $netpayable = str_replace(',','',trim($_REQUEST['netpayable'])) ;
      		  $bankcharges = str_replace(',','',trim($_REQUEST['bankcharges'])) ;
      		  
      		  // Validate amounts
      		  if (!is_numeric($netpayable) || $netpayable <= 0) {
      		  	$errmsg = "Invalid net payable amount.";
      		  }
      		  if (!is_numeric($bankcharges) || $bankcharges < 0) {
      		  	$errmsg = "Invalid bank charges amount.";
      		  }
      		  
      		  // Check if there are validation errors
      		  if (!empty($errmsg)) {
      		  	header("location: doctoradvancepaymententry.php?st=error&msg=" . urlencode($errmsg));
      		  	exit();
      		  }

			// $cashcoa = $_REQUEST['cashcoa'];
			// $chequecoa = $_REQUEST['chequecoa'];
			// $cardcoa = $_REQUEST['cardcoa'];
			// $mpesacoa = $_REQUEST['mpesacoa'];
			// $onlinecoa = $_REQUEST['onlinecoa'];
			// $doctorcode = $_REQUEST['doctorcode'];
			 
			
			$searchsuppliercode1 = trim($_REQUEST["searchsuppliercode1"]);
			 $searchsuppliername1 = trim($_REQUEST['searchsuppliername1']);
			//  $searchsuppliername1 = $_REQUEST['cbsuppliername'];
			 $searchsuppliername1 = strtoupper($searchsuppliername1);

			 $suppliercode_new = trim($_REQUEST['suppliercode_new']);	
			 $suppliername_new = trim($_REQUEST['suppliername_new']);	
			 $suppliername_new = strtoupper($suppliername_new);



			 $taxanum = trim($_REQUEST['taxanum']);
			 // $taxamount1 = $_REQUEST['taxamount'];
			 $querytax = "SELECT * FROM master_withholding_tax WHERE record_status = '1' AND auto_number = ?";
			$stmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $querytax);
			if ($stmt) {
				mysqli_stmt_bind_param($stmt, "s", $taxanum);
				mysqli_stmt_execute($stmt);
				$result = mysqli_stmt_get_result($stmt);
				if ($result && $restax = mysqli_fetch_array($result)) {
					$taxpercent = $restax['tax_percent'];
					$wht_id = $restax['tax_id'];
					$wht_anum = $restax['auto_number'];
				}
				mysqli_stmt_close($stmt);
			}
			 $taxamount = ($netpayable*$taxpercent)/100;
			 $bankamount = $netpayable - $taxamount;
			
			// exit();

			
				$mpesanumber='';
				$chequenumber='';
			 
			
			$ipaddress = $ipaddress;
			$updatedate = $updatedatetime;
				$transactiontype='PAYMENT';
				$transactionmodule='PAYMENT';
				$transactionamount=$netpayable;
				$openingbalance = str_replace(',','',trim($_REQUEST['ledgeramount']));
				$closingbalance=0;
				$transactionmode = $paymentmode;

				if($transactionmode=='CASH'){
					$particulars = 'BY CASH '.$billnumberprefix.$billnumber.'';	
					$cashamount=$netpayable;
					$onlineamount='0';
					$chequeamount='0';
					$mpesaamount='0';
					$writeoffamount='0';
				}
				if($transactionmode=='CHEQUE'){
					$particulars = 'BY CHEQUE '.$billnumberprefix.$billnumber.'';	
					$cashamount='0';
					$onlineamount='0';
					$chequeamount=$netpayable;
					$mpesaamount='0';
					$writeoffamount='0';

					$chequenumber=$chequenumber_mps;
				}
				if($transactionmode=='MPESA'){
					$particulars = 'BY MPESA '.$billnumberprefix.$billnumber.'';	
					$cashamount='0';
					$onlineamount='0';
					$chequeamount='0';
					$mpesaamount=$netpayable;
					$writeoffamount='0';

					 $mpesanumber=$chequenumber_mps;
				}
				if($transactionmode=='ONLINE'){
					$particulars = 'BY ONLINE '.$billnumberprefix.$billnumber.'';	
					$cashamount='0';
					$onlineamount=$netpayable;
					$chequeamount='0';
					$mpesaamount='0';
					$writeoffamount='0';
				}
				if($transactionmode=='WRITEOFF'){
					$particulars = 'BY WRITEOFF '.$billnumberprefix.$billnumber.'';	
					$cashamount='0';
					$onlineamount='0';
					$chequeamount='0';
					$mpesaamount='0';
					$writeoffamount=$netpayable;
				}

				  $query9 = "INSERT INTO `advance_payment_entry`(`transactiondate`, `docno`, `particulars`, `ledger_name`, `ledger_code`, `transactionmode`, `transactiontype`, `transactionmodule`, `transactionamount`, `cashamount`, `onlineamount`, `chequeamount`, `mpesaamount`, `writeoffamount`, `openingbalance`, `closingbalance`, `chequenumber`, `chequedate`, `mpesanumber`, `bankname`, `bankcode`, `remarks`, `ipaddress`, `updatedate`, `recordstatus`, `locationname`, `locationcode`, `username`,`wht_id`, `wht_perc`, `wht_amount`, `bank_amount`,`bankcharges`) 
					VALUES ('$chequedate', '$billnumbercode1', '$particulars', '$suppliername_new', '$suppliercode_new', '$transactionmode', '$transactiontype', '$transactionmodule', '$transactionamount', '$cashamount', '$onlineamount', '$chequeamount', '$mpesaamount', '$writeoffamount', '$openingbalance', '$closingbalance', '$chequenumber', '$chequedate', '$mpesanumber', '$bankname', '$bankcode', '$remarks', '$ipaddress', '$updatedate','','$companyname','$locationcode','$username','$wht_id','$taxpercent','$taxamount','$bankamount','$bankcharges' )";
					//   '$particulars', '$searchsuppliername1', '$searchsuppliercode1' 

					$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query91".mysqli_error($GLOBALS["___mysqli_ston"]));
		header("location:doctoradvancepaymententry.php?st=success&msg=" . urlencode("Payment processed successfully!"));
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
if ($st == 'success')
{
	$errmsg = "Payment processed successfully!";
}
if ($st == 'error')
{
	$errmsg = isset($_GET['msg']) ? $_GET['msg'] : "An error occurred.";
}


if(isset($_REQUEST['docno'])) { $docno = $_REQUEST['docno']; } else { $docno = ''; }
if($docno != "") { ?>
<script>
// window.open("print_doctorremittances.php?docno=<?php echo $docno; ?>","OriginalWindow<?php echo '1'; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
</script>
<?php
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

<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<link href="css/doctoradvancepayment-modern.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">
function amountcheck()
{
}
</script>
<script type="text/javascript" src="js/autocomplete_doctor.js"></script>
<!-- <script type="text/javascript" src="js/autocomplete_doc_supplier.js"></script> -->
<script type="text/javascript" src="js/autosuggestdoctor.js"></script>
<script type="text/javascript" src="js/doctoradvancepayment-modern.js"></script>
<!-- <link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> -->
<!-- <link rel="stylesheet" type="text/css" href="css/autocomplete.css" />   -->

<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
}


function checkledgeramount(){
	if (document.getElementById("cbsuppliername").value == "")
	{
		alert ("Enter Doctor Name");
		document.getElementById("netpayable").value = "0.00";
		document.getElementById("searchsuppliername").focus();
		return false;
	}

	document.getElementById("bankcharges").value='0.00';

var ledgeramount = document.getElementById("ledgeramount").value;
var netpayable12 = document.getElementById("netpayable").value;
netpayable12 = netpayable12.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
document.getElementById("netpayable").value = netpayable12;

if(netpayable12==''){
document.getElementById("taxamount").value = "0.00";
document.getElementById("netpayable_wht").value = "0.00";
return false;
}

var taxamount;
	var taxpercent;
	var paymentamount = document.getElementById("netpayable").value;
	var tax = document.getElementById("taxanum").value;
var tax = document.getElementById("taxanum").value;

paymentamount=paymentamount.replace(/,/g,''); 
// alert(tax);
if(tax != '')
	{
		// amount=amount.replace(/,/g,'');
	<?php
	$query1 = "select * from master_withholding_tax where record_status = '1' order by auto_number";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res1 = mysqli_fetch_array($exec1))
	{
	$res1taxname = $res1["name"];
	$res1taxpercent = $res1["tax_percent"];
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

		taxamount = parseFloat(taxamount).toFixed(2);
		taxamount = taxamount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"); 

		netpayable = parseFloat(netpayable).toFixed(2);
		netpayable = netpayable.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"); 


		document.getElementById("taxamount").value = taxamount;
		document.getElementById("netpayable_wht").value = netpayable;
	}else{

		paymentamount12 = parseFloat(paymentamount).toFixed(2);
		paymentamount12 = paymentamount12.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"); 
		document.getElementById("netpayable_wht").value = paymentamount12;
		document.getElementById("taxamount").value = '';
	}


	if (parseFloat(parseFloat(paymentamount).toFixed(2)) > parseFloat(parseFloat(ledgeramount).toFixed(2))){
			alert('Advance Amount is higher than the Ledger Balance!');
			document.getElementById("netpayable").value = "0.00";
			document.getElementById("netpayable_wht").value = "0.00";
			document.getElementById("taxamount").value = "0.00";
			document.getElementById("netpayable").focus();
	}


// if (parseFloat(checkamount.toFixed(2)) > parseFloat(amounttodisp.toFixed(2))) 
}

// $(function() {
// $('#searchsuppliername').autocomplete({
// 	source:'ajaxsuppliernewserach.php', 
// 	select: function(event,ui){
// 			var code = ui.item.id;
// 			var anum = ui.item.anum;
// 			$('#searchsuppliercode').val(code);
// 			$('#searchsupplieranum').val(anum);
// 			},
// 	  open: function( event, ui ) {
// 			$("#searchsuppliercode").val('');
// 	   },
// 	html: true
//     });
// });




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
		document.getElementById("searchsuppliername").focus();
		return false;
	}
	if (document.getElementById("netpayable").value == "")
	{
		alert ("Payment Amount Cannot Be Empty.");
		document.getElementById("netpayable").focus();
		document.getElementById("netpayable").value = "0.00"
		return false;
	}
	if (document.getElementById("netpayable").value == "0.00")
	{
		alert ("Payment Amount Cannot Be Empty.");
		document.getElementById("netpayable").focus();
		document.getElementById("netpayable").value = "0.00"
		return false;
	}
	// if (isNaN(document.getElementById("netpayable").value))
	// {
	// 	alert ("Payment Amount Can Only Be Numbers.");
	// 	document.getElementById("netpayable").focus();
	// 	return false;
	// }
	if (document.getElementById("paymentmode").value == "")
	{
		alert ("Please Select Payment Mode.");
		document.getElementById("paymentmode").focus();
		return false;
	}
	///////
	if(document.getElementById("bankname").value == "")
	{
		alert ("Please select Bank.");
		document.getElementById("bankname").focus();
		return false;
	} 
	//////////////////
	if(document.getElementById("ADate1").value == "")
	{
		alert ("Please select paymentdate.");
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
	else if (document.getElementById("paymentmode").value == "MPESA")
	{
		if(document.getElementById("chequenumber").value == "")
		{
			alert ("If Payment By Mpesa, Then Mpesa Number Cannot Be Empty.");
			document.getElementById("chequenumber").focus();
			return false;
		}
		else if (document.getElementById("bankname").value == "")
		{
			alert ("If Payment By Mpesa, Then Mpesa Bank Name Cannot Be Empty.");
			document.getElementById("bankname").focus();
			return false;
		}
		
	}


	if (document.getElementById("taxanum").value == "")
	{
		fRet1 = confirm('Do You Like to Select WITHHOLDING TAX ?'); 
		// if (fRet1 == false)
		// 	{
		//  			// document.getElementById("form1button").disabled=false;
		// 			// alert ("Payment Entry Not Completed.");
		// 			return true;
		// 	}
			if (fRet1 == true)
			{
		 			document.getElementById("taxanum").focus();
					return false;
			}
	}


	if (document.getElementById("bankcharges").value == "" || document.getElementById("bankcharges").value == "0.00")
	{
	var fRet1; 
	fRet1 = confirm('Do you like to enter Bank Charges? '); 
		if (fRet1 == true)
		{
			document.getElementById("bankcharges").focus();
			return false;
		}
	}

	
	 document.getElementById("form1button").disabled=true;
	
	var fRet; 
	fRet = confirm('Are you sure want to save this payment entry?'); 
	//alert(fRet); 
	//alert(document.getElementById("paymentamount").value); 
	//alert(document.getElementById("pendingamounthidden").value); 
	if (fRet == true)
	{
		var varPaymentAmount = document.getElementById("netpayable").value; 
		var varPaymentAmount = varPaymentAmount * 1;
		// var varPendingAmount = document.getElementById("pendingamounthidden").value; 
		// var varPendingAmount = parseInt(varPendingAmount);
		// var varPendingAmount = varPendingAmount * 1;
	
		FuncPopup();
		document.form1.submit();
		
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
		 document.getElementById("form1button").disabled=false;
		alert ("Payment Entry Not Completed.");
		return false;
	}
		
	//return false;
	
}
function funcPrintReceipt1()
{
	var docno = "<?php echo $docno;?>";
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_doctorremittances.php?docno="+docno,"OriginalWindow<?php echo '1'; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
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
// function updatebox(varSerialNumber,billamt,totalcount1)
// {
// var adjamount1;
// var grandtotaladjamt2=0;
// var varSerialNumber = varSerialNumber;
// var totalcount1=document.getElementById("totcount").value;
// var billamt = billamt;
//   var textbox = document.getElementById("adjamount"+varSerialNumber+"");
//     textbox.value = "";
// if(document.getElementById("acknow"+varSerialNumber+"").checked == true)
// {
//     if(document.getElementById("acknow"+varSerialNumber+"").checked) {
//         textbox.value = billamt;
//     }
// 	var balanceamt=billamt-billamt;
// 	document.getElementById("balamount"+varSerialNumber+"").value=balanceamt.toFixed(2);
// 	var totalbillamt=document.getElementById("paymentamount").value;
// 	if(totalbillamt == 0.00)
// {
// totalbillamt=0;
// }
// 				totalbillamt=parseFloat(totalbillamt)+parseFloat(billamt);
			
// 		totalbillamt1=totalbillamt.toFixed(2);
// 		totalbillamt1 = totalbillamt1.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
// 			//alert(totalbillamt);
// document.getElementById("paymentamount").value = totalbillamt.toFixed(2);
// document.getElementById("netpayable").value = totalbillamt.toFixed(2);
// document.getElementById("totaladjamt").value=totalbillamt1;
// }
// else
// {
// //alert(totalcount1);
// for(j=1;j<=totalcount1;j++)
// {
// var totaladjamount2=document.getElementById("adjamount"+j+"").value;
// if(totaladjamount2 == "")
// {
// totaladjamount2=0;
// }
// grandtotaladjamt2=grandtotaladjamt2+parseFloat(totaladjamount2);
// }
// //alert(grandtotaladjamt);
// document.getElementById("paymentamount").value = grandtotaladjamt2.toFixed(2);
// document.getElementById("netpayable").value = grandtotaladjamt2.toFixed(2);
// document.getElementById("totaladjamt").value=grandtotaladjamt2.toFixed(2);
//  }  
// }
// =============================
// function balancecalc(varSerialNumber1,billamt1,totalcount)
// {
// var varSerialNumber1 = varSerialNumber1;
// var billamt1 = billamt1;
// var totalcount=document.getElementById("totcount").value;
// var grandtotaladjamt=0;
// var adjamount=document.getElementById("adjamount"+varSerialNumber1+"").value;
// var adjamount3=parseFloat(adjamount);
// if(adjamount3 > billamt1)
// {
// alert("Please enter correct amount");
// document.getElementById("adjamount"+varSerialNumber1+"").focus();
// return false;
// }
// var balanceamount=parseFloat(billamt1)-parseFloat(adjamount);
// 	balanceamount=balanceamount.toFixed(2);
// 	balanceamount = balanceamount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
// document.getElementById("balamount"+varSerialNumber1+"").value=balanceamount;
// for(i=1;i<=totalcount;i++)
// {
// var totaladjamount=document.getElementById("adjamount"+i+"").value;
// if(totaladjamount == "")
// {
// totaladjamount=0;
// }
// grandtotaladjamt=grandtotaladjamt+parseFloat(totaladjamount);
// }
// //alert(grandtotaladjamt);

// 	grandtotaladjamt1=grandtotaladjamt.toFixed(2);
// 	grandtotaladjamt1 = grandtotaladjamt1.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

// document.getElementById("paymentamount").value = grandtotaladjamt.toFixed(2);
// document.getElementById("netpayable").value = grandtotaladjamt.toFixed(2);
// document.getElementById("totaladjamt").value=grandtotaladjamt1;
// var tax = document.getElementById("taxanum").value;
// if(tax != '')
// {
// var paymentamount = document.getElementById("paymentamount").value;
// <?php
// $query1 = "select * from master_tax where status <> 'deleted' order by taxname";
// 						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
// 						while ($res1 = mysql_fetch_array($exec1))
// 						{
// 						$res1taxname = $res1["taxname"];
// 						$res1taxpercent = $res1["taxpercent"];
// 						$res1anum = $res1["auto_number"];
// 						?>
// 						if(tax == "<?php echo $res1anum; ?>")
// 						{
// 						taxpercent = "<?php echo $res1taxpercent; ?>";
// 						}
// 						<?php
// 	}
	
// 	?>
	
// 	taxamount = (paymentamount * taxpercent)/100;
// 	var netpayable = paymentamount - taxamount;
// 	document.getElementById("taxamount").value = taxamount.toFixed(2);
// 	document.getElementById("netpayable").value = netpayable.toFixed(2);
// }
// }
// ======================

function bankCharges()
{
	paymentamount = document.getElementById("netpayable").value;
	paymentamount=paymentamount.replace(/,/g,''); 
	if(paymentamount=='0.00'){
			alert('Payment Amount Cannot Be Empty.');
			document.getElementById("bankcharges").value='0.00';
			return false;
	}

	taxamount = document.getElementById("taxamount").value;
	taxamount=taxamount.replace(/,/g,''); 
	bank_charges = document.getElementById("bankcharges").value;
	bank_charges=bank_charges.replace(/,/g,''); 
	 // var adj=paymentamount-bank_charges;
	 if(taxamount==''){
	 		taxamount=0;
	 }
	 if(bank_charges==''){
	 		bank_charges=0;
	 }
	 var adj1=parseFloat(paymentamount)-parseFloat(taxamount);
	 var adj=parseFloat(adj1)-parseFloat(bank_charges);
	 if(adj<0){
	 	adj1 = parseFloat(adj1).toFixed(2);
		adj1 = adj1.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	 	document.getElementById("netpayable_wht").value=adj1;
	 	alert('Amount Entered is Higher Than the Net Payable.');
	 	document.getElementById("bankcharges").value='0.00';
	 	return false;
	 }

	 // document.getElementById("netpayable_wht").value=adj.toFixed(2);
	 paymentamount = parseFloat(adj).toFixed(2);
		paymentamount = paymentamount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"); 
		document.getElementById("netpayable_wht").value = paymentamount;

		bankcharges = document.getElementById("bankcharges").value;
		bankcharges = bankcharges.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
		document.getElementById("bankcharges").value = bankcharges;
}

function netpayablecalc()
{
	var taxamount;
	var taxpercent;
	var paymentamount = document.getElementById("netpayable").value;
	var tax = document.getElementById("taxanum").value;
	//alert(tax);
	paymentamount=paymentamount.replace(/,/g,''); 

	if (document.getElementById("netpayable").value == "")
	{
		alert ("Payment Amount Cannot Be Empty.");
		document.getElementById("netpayable").focus();
		document.getElementById("netpayable").value = "0.00"
		document.getElementById("taxanum").value = "";
		return false;
	}
	if (document.getElementById("netpayable").value == "0.00")
	{
		alert ("Payment Amount Cannot Be Empty.");
		document.getElementById("netpayable").focus();
		document.getElementById("netpayable").value = "0.00"
		document.getElementById("taxanum").value = "";
		return false;
	}

	if(tax != '')
	{
	<?php
	$query1 = "select * from master_withholding_tax where record_status = '1' order by auto_number";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res1 = mysqli_fetch_array($exec1))
	{
	$res1taxname = $res1["name"];
	$res1taxpercent = $res1["tax_percent"];
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

		taxamount = parseFloat(taxamount).toFixed(2);
		taxamount = taxamount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"); 

		netpayable = parseFloat(netpayable).toFixed(2);
		netpayable = netpayable.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"); 


		document.getElementById("taxamount").value = taxamount;
		document.getElementById("netpayable_wht").value = netpayable;
		// document.getElementById("taxamount").value = taxamount.toFixed(2);
		// document.getElementById("netpayable_wht").value = netpayable.toFixed(2);
	}
	else
	{
		document.getElementById("taxamount").value = 0.00;

		paymentamount = parseFloat(paymentamount).toFixed(2);
		paymentamount = paymentamount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"); 
		document.getElementById("netpayable_wht").value = paymentamount;
	}	
	
}
// function FuncPopup()
// {
// 	window.scrollTo(0,0);
// 	document.getElementById("imgloader").style.display = "";
// 	document.body.style.overflow='auto';
// 	//return false;
// }



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
.imgloader { background-color:#FFFFFF; }
#imgloader1 {
    position: absolute;
    top: 158px;
    left: 487px;
    width: 28%;
    height: 24%;
}
</style>
</head>
<!--<script src="js/datetimepicker_css.js"></script>-->
<script src="js/datepicker_doctor.js"></script>
<body>
    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Advanced Healthcare Management Platform</p>
    </header>

    <!-- User Information Bar -->
    <div class="user-info-bar">
        <div class="user-welcome">
            <span class="welcome-text">Welcome, <strong><?php echo htmlspecialchars($username); ?></strong></span>
            <span class="location-info">📍 Company: <?php echo htmlspecialchars($companyname); ?></span>
        </div>
        <div class="user-actions">
            <a href="mainmenu1.php" class="btn btn-outline">🏠 Main Menu</a>
            <a href="logout.php" class="btn btn-outline">🚪 Logout</a>
        </div>
    </div>

    <!-- Navigation Breadcrumb -->
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Home</a>
        <span>→</span>
        <span>Doctor Advance Payment Entry</span>
    </nav>

    <!-- Floating Menu Toggle -->
    <div id="menuToggle" class="floating-menu-toggle">
        <i class="fas fa-bars"></i>
    </div>

    <!-- Main Container with Sidebar -->
    <div class="main-container-with-sidebar">
        <!-- Left Sidebar -->
        <aside id="leftSidebar" class="left-sidebar">
            <div class="sidebar-header">
                <h3>Quick Navigation</h3>
                <button id="sidebarToggle" class="sidebar-toggle">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            
            <nav class="sidebar-nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="mainmenu1.php" class="nav-link">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="labitem1master.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Items</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="openingstockentry_master.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Opening Stock</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addward.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Wards</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountreceivableentrylist.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>Account Receivable</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="corporateoutstanding.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Corporate Outstanding</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountstatement.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Account Statement</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountsmain.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Accounts Main</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountssub.php" class="nav-link">
                            <i class="fas fa-chart-pie"></i>
                            <span>Accounts Sub Type</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="fixedasset_acquisition_report.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Fixed Asset Acquisition</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeinpatientlist.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Active Inpatient List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeusersreport.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Active Users Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chartofaccounts_upload.php" class="nav-link">
                            <i class="fas fa-upload"></i>
                            <span>Chart of Accounts Upload</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chartaccountsmaindataimport.php" class="nav-link">
                            <i class="fas fa-database"></i>
                            <span>Chart of Accounts Main Import</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chartaccountssubdataimport.php" class="nav-link">
                            <i class="fas fa-database"></i>
                            <span>Chart of Accounts Sub Import</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addbloodgroup.php" class="nav-link">
                            <i class="fas fa-tint"></i>
                            <span>Blood Group Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addfoodallergy1.php" class="nav-link">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Food Allergy Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addgenericname.php" class="nav-link">
                            <i class="fas fa-pills"></i>
                            <span>Generic Name Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addpromotion.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            <span>Promotion Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addsalutation1.php" class="nav-link">
                            <i class="fas fa-user-tie"></i>
                            <span>Salutation Master</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="doctoradvancepaymententry.php" class="nav-link">
                            <i class="fas fa-user-md"></i>
                            <span>Doctor Advance Payment</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer">
                <?php if (!empty($errmsg)): ?>
                    <div class="alert alert-<?php echo $bgcolorcode === 'success' ? 'success' : ($bgcolorcode === 'failed' ? 'error' : 'info'); ?>">
                        <i class="fas fa-<?php echo $bgcolorcode === 'success' ? 'check-circle' : ($bgcolorcode === 'failed' ? 'exclamation-triangle' : 'info-circle'); ?> alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>
              
            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Doctor Advance Payment Entry</h2>
                    <p>Manage and process advance payments for doctors with comprehensive tracking and validation</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>
            </div>

            <!-- Doctor Search Form Section -->
            <div class="add-form-section">
                <div class="add-form-header">
                    <i class="fas fa-user-md add-form-icon"></i>
                    <h3 class="add-form-title">Search and Select Doctor</h3>
                </div>
                
                <form name="cbform1" method="post" action="doctoradvancepaymententry.php" id="doctorSearchForm" class="add-form">
                    <div class="form-group">
                        <label for="doctorSearch" class="form-label">Search Doctor</label>
                        <input name="searchsuppliername" type="text" id="doctorSearch" class="form-input search-input" 
                               value="<?php echo htmlspecialchars($searchsuppliername); ?>" 
                               autocomplete="off" placeholder="Enter doctor name to search...">
                    </div>

                    <div class="form-group">
                        <label for="doctorSelect" class="form-label">Doctor</label>
                        <input value="<?php echo htmlspecialchars($cbsuppliername); ?>" name="cbsuppliername" type="text" 
                               id="doctorSelect" onKeyDown="return disableEnterKey()" onKeyUp="return FillDoctor()" 
                               class="form-input" style="text-transform:uppercase;" 
                               <?php if($searchsuppliername != "") { ?> readonly <?php } ?> 
                               placeholder="Doctor name will appear here after search">
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" 
                               onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" 
                               value="<?php if($searchsuppliercode != '') { echo htmlspecialchars($searchsuppliercode); } ?>" />
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        
                        <button type="submit" id="searchButton" class="submit-btn">
                            <i class="fas fa-search"></i>
                            Search Doctor
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <?php

		$paynowbillprefix1 = 'ADP-';
			$paynowbillprefix12=strlen($paynowbillprefix1);
			$query23 = "select * from advance_payment_entry order by auto_number desc limit 0, 1";
			$exec23= mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res23 = mysqli_fetch_array($exec23);
			$billnumber1 = $res23["docno"];
			$billdigit1=strlen($billnumber1);
			if ($billnumber1 == '')
			{
				$billnumbercode1 ='ADP-'.'1';
			}
			else
			{
				$billnumber1 = $res23["docno"];
				$billnumbercode1 = substr($billnumber1,$paynowbillprefix12, $billdigit1);
				//echo $billnumbercode;
				$billnumbercode1 = intval($billnumbercode1);
				$billnumbercode1 = $billnumbercode1 + 1;
				$maxanum1 = $billnumbercode1;
				$billnumbercode1 = 'ADP-'.$maxanum1;
				//echo $companycode;
			}

		if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
		if ($cbfrmflag1 == 'cbfrmflag1')
		{
			$searchsuppliername = $_POST['searchsuppliername'];
			
	if ($searchsuppliername != '')
	{
		$arraysupplier = explode("#", $searchsuppliername);
		$arraysuppliername = $arraysupplier[0];
		$arraysuppliername = trim($arraysuppliername);
		$arraysuppliercode = $arraysupplier[1];
		
		// $query1 = "select * from master_doctor where doctorcode = '$arraysuppliercode'";
		$query1 = "SELECT sum(IF(transaction_type='C',-1*transaction_amount,transaction_amount)) as amount, ledger_id FROM `tb` WHERE ledger_id = '$arraysuppliercode'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res1 = mysqli_fetch_array($exec1);
		// $supplieranum = $res1['auto_number'];
		$openingbalance = $res1['amount'];
		//echo $openingbalance;
		$cbsuppliername = $arraysuppliername;
		$suppliername_new = $arraysuppliername;
		$suppliercode_new = $arraysuppliercode;

		if ($openingbalance < 1) { 
						  	$r = 'Cr';
						  	$openingbalance = $openingbalance * -1;
						  }else{
						   $r = 'Dr';
						   $openingbalance = $openingbalance * 1; 
						  }
	}
	else
	{
		$cbsuppliername = $_REQUEST['cbsuppliername'];
		$suppliername = $_REQUEST['cbsuppliername'];
	}
	}
		 ?>

		 <div class="alert alert-warning">
			<span class="alert-icon">⚠</span>
			<span><b>Please Select Withholding Tax % for this entry, if applicable.</b></span>
		</div>
		
		<form name="form1" id="paymentEntryForm" method="post" action="doctoradvancepaymententry.php?cbfrmflag1=<?php echo $cbfrmflag1; ?>" onSubmit="return paymententry1process1()">
			<div class="form-section">
				<div class="form-section-header">
					<span class="form-section-icon">💰</span>
					<h3 class="form-section-title">Advance Payment Entry - Details</h3>
				</div>
				
				<!-- Hidden inputs -->
				<input type="hidden" name="searchsuppliercode1" id="searchsuppliercode1" value="<?php if($searchsuppliercode != '') { echo htmlspecialchars($searchsuppliercode); } ?>" />
				<input type="hidden" name="searchsuppliername1" id="searchsuppliername1" value="<?php if($searchsuppliername != '') { echo htmlspecialchars($searchsuppliername); } ?>" />
				<input type="hidden" name="suppliername_new" id="suppliername_new" value="<?php if($suppliername_new != '') { echo htmlspecialchars($suppliername_new); } ?>" />
				<input type="hidden" name="suppliercode_new" id="suppliercode_new" value="<?php if($suppliercode_new != '') { echo htmlspecialchars($suppliercode_new); } ?>" />
				
				<!-- Ledger Balance Display -->
				<div class="ledger-balance-row">
					<div class="ledger-balance">
						<h4>Current Ledger Balance</h4>
						<div class="ledger-amount" id="ledgerBalanceDisplay"><?php echo $r.' '.number_format($openingbalance,2,'.',',');?></div>
					</div>
				</div>
				
				<!-- Amount Display Elements -->
				<div class="amount-display-row">
					<div class="amount-display" id="amountDisplay">
						<div class="label">Amount</div>
						<div class="value">$0.00</div>
					</div>
					<div class="amount-display" id="netPayableDisplay">
						<div class="label">Net Payable</div>
						<div class="value">$0.00</div>
					</div>
				</div>
				
				<div class="amount-display-row">
					<div class="amount-display" id="whtDisplay">
						<div class="label">WHT Amount</div>
						<div class="value">$0.00</div>
					</div>
					<div class="amount-display">&nbsp;</div>
				</div>
				
				<input type="hidden" name="ledgeramount" id="ledgeramount" value="<?=$openingbalance;?>">
				
				<?php if (!empty($errmsg)) { ?>
				<div class="alert alert-<?php echo ($st == 'success' || $st == '1') ? 'success' : (($st == 'error' || $st == '2') ? 'error' : 'warning'); ?>">
					<span class="alert-icon"><?php echo ($st == 'success' || $st == '1') ? '✓' : (($st == 'error' || $st == '2') ? '✗' : '⚠'); ?></span>
					<span><?php echo htmlspecialchars($errmsg); ?></span>
				</div>
				<?php } ?>
				
				<input type="hidden" name="cashcoa" value="<?php echo $cashcoa; ?>">
				<input type="hidden" name="chequecoa" value="<?php echo $chequecoa; ?>">
				<input type="hidden" name="mpesacoa" value="<?php echo $mpesacoa; ?>">
				<input type="hidden" name="cardcoa" value="<?php echo $cardcoa; ?>">
				<input type="hidden" name="onlinecoa" value="<?php echo $onlinecoa; ?>">
				<input type="hidden" name="doctorcode" value="<?php echo $doctorcode; ?>">

				<div class="form-row">
					<div class="form-label">Doc No.</div>
					<div class="form-input">
						<div class="amount-display">
							<div class="label">Document Number</div>
							<div class="value"><?=$billnumbercode1; ?></div>
						</div>
					</div>
					<div class="form-label">&nbsp;</div>
					<div class="form-input">&nbsp;</div>
				</div>
				
				<div class="form-row">
					<div class="form-label">Advance Amount</div>
					<div class="form-input">
						<input name="netpayable" onKeyup="return checkledgeramount();" id="amount" class="form-input" style="text-align:right" value="0.00" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" size="20" autocomplete="off" placeholder="Enter amount" />
					</div>
					<div class="form-label">Payment Mode</div>
					<div class="form-input">
						<select name="paymentmode" id="paymentMode" class="form-select">
							<option value="" selected="selected">SELECT</option>
							<option value="CHEQUE">CHEQUE</option>
							<option value="CASH">CASH</option>
							<option value="MPESA">MPESA</option>
							<option value="ONLINE">ONLINE</option>
							<option value="WRITEOFF">ADJUSTMENT</option>
						</select>
					</div>
				</div>

				<div class="form-row">
					<div class="form-label">Select Applicable WHT</div>
					<div class="form-input">
						<select id="whtRate" name="taxanum" onChange="return netpayablecalc()" class="form-select">
							<option value="">Select Tax</option>
							<?php
							$query1 = "SELECT * FROM master_withholding_tax WHERE record_status = '1' ORDER BY auto_number";
							$stmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $query1);
							if ($stmt) {
								mysqli_stmt_execute($stmt);
								$result = mysqli_stmt_get_result($stmt);
								while ($res1 = mysqli_fetch_array($result)) {
									$res1taxname = $res1["name"];
									$res1taxpercent = $res1["tax_percent"];
									$res1anum = $res1["auto_number"];
									?>
							<option value="<?php echo htmlspecialchars($res1anum); ?>"><?php echo htmlspecialchars($res1taxname).' ( '.htmlspecialchars($res1taxpercent).'% ) '; ?></option>
									<?php
								}
								mysqli_stmt_close($stmt);
							}
							?>
						</select>
					</div>
					<div class="form-label">WHT Amount</div>
					<div class="form-input">
						<input name="taxamount" id="whtAmount" class="form-input" style="text-align:right" size="20" readonly/>
					</div>
				</div>

				<div class="form-row">
					<div class="form-label">Net Payable</div>
					<div class="form-input">
						<input name="netpayable_wht" id="netPayable" class="form-input" style="text-align:right" value="0.00" size="20" readonly/>
					</div>
					<div class="form-label">&nbsp;</div>
					<div class="form-input">&nbsp;</div>
				</div>

				<div class="form-row">
					<div class="form-label">Cheque/MPESA Number</div>
					<div class="form-input">
						<input name="chequenumber" id="chequeNumber" class="form-input" value="" size="20" autocomplete="off" placeholder="Enter cheque or MPESA number"/>
					</div>
					<div class="form-label">Bank Name</div>
					<div class="form-input">
						<input type="hidden" name="bankbranch" id="bankbranch">
						<select name="bankname" id="bankName" class="form-select">
							<option value="">Select Bank</option>
							<?php 
							$querybankname = "SELECT * FROM master_bank WHERE bankstatus <> 'deleted'";
							$stmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $querybankname);
							if ($stmt) {
								mysqli_stmt_execute($stmt);
								$result = mysqli_stmt_get_result($stmt);
								while($resbankname = mysqli_fetch_array($result)) {
									?>
								<option value="<?php echo htmlspecialchars($resbankname['bankcode']).'||'.htmlspecialchars($resbankname['bankname']); ?>"><?php echo htmlspecialchars($resbankname['bankname']);?></option>
									<?php
								}
								mysqli_stmt_close($stmt);
							}
							?>
						</select>
					</div>
				</div>
                  
                  				<!-- Additional payment mode specific fields -->
				<div class="form-row payment-field mpesa-field" style="display: none;">
					<div class="form-label">MPESA Number</div>
					<div class="form-input">
						<input name="mpesanumber" id="mpesaNumber" class="form-input" value="" size="20" autocomplete="off" placeholder="Enter MPESA number"/>
					</div>
					<div class="form-label">&nbsp;</div>
					<div class="form-input">&nbsp;</div>
				</div>
				
				<div class="form-row payment-field online-field" style="display: none;">
					<div class="form-label">Online Reference</div>
					<div class="form-input">
						<input name="onlinereference" id="onlineReference" class="form-input" value="" size="20" autocomplete="off" placeholder="Enter online reference"/>
					</div>
					<div class="form-label">&nbsp;</div>
					<div class="form-input">&nbsp;</div>
				</div>
				
				<div class="form-row">
					<div class="form-label">Payment Date</div>
					<div class="form-input">
						<input name="ADate1" id="ADate1" class="form-input" value="" size="20" readonly="readonly" onKeyDown="return disableEnterKey()" placeholder="Select payment date"/>
						<!-- <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> -->
						<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1','','','','','','past','','<?=$updatedatetime;?>')" style="cursor:pointer" class="calendar-icon"/>
					</div>
					<div class="form-label">Remarks</div>
					<div class="form-input">
						<input name="remarks" id="remarks" class="form-input" value="" size="20" autocomplete="off" placeholder="Enter any additional remarks"/>
					</div>
				</div>

				<div class="form-row">
					<div class="form-label">Bank Charges</div>
					<div class="form-input">
						<input name="bankcharges" id="bankCharges" class="form-input" style="text-align:right" value="0.00" size="20" oninput="this.value = this.value.replace(/[0-9.]/g, '').replace(/(\..*)\./g, '$1');" onKeyUp="bankCharges()" autocomplete="off" placeholder="Enter bank charges if any"/>
						<!-- onBlur="return fixed_value()" onFocus="return cashentryonfocus12()"   -->
					</div>
					<div class="form-label">&nbsp;&nbsp;</div>
					<div class="form-input">&nbsp;&nbsp;</div>
				</div>

				<div class="form-row">
					<div class="form-label">&nbsp;</div>
					<div class="form-input">&nbsp;</div>
					<div class="form-label">&nbsp;</div>
					<div class="form-input">
						<input type="hidden" name="cbfrmflag2" value="<?php echo htmlspecialchars($supplieranum); ?>">
						<input type="hidden" name="frmflag2" value="frmflag2">
						<div class="action-buttons">
							<button name="save" type="submit" id="saveButton" class="btn btn-primary" onClick="return amountcheck()">Save Payment</button>
							<button name="reset" type="reset" id="resetButton" class="btn btn-secondary">Reset</button>
						</div>
					</div>
				</div>
			</div>
		</form>
		
		<!-- Payment History Section -->
		<div class="payment-history-section" style="margin-top: 2rem;">
			<h3>Payment History</h3>
			<table class="data-table">
				<thead>
					<tr>
						<th>Date</th>
						<th>Doctor Name</th>
						<th>Amount</th>
						<th>Payment Mode</th>
						<th>Reference</th>
						<th>Net Payable</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<!-- Payment history will be populated by JavaScript -->
				</tbody>
			</table>
			
			<!-- Pagination Controls -->
			<div class="pagination-controls">
				<div class="pagination-info">Showing 0-0 of 0 payments</div>
				<div class="pagination-buttons">
					<!-- Pagination buttons will be populated by JavaScript -->
				</div>
			</div>
		</div>
		
	</div> <!-- End main-content -->
</div> <!-- End main-container-with-sidebar -->

<?php include ("includes/footer1.php"); ?>
</body>
</html>
