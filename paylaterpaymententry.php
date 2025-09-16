<?php
// Enable strict error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session and include security files
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

// Set timezone
date_default_timezone_set('Asia/Calcutta');

// Security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

// Initialize variables with proper sanitization
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$timeonly = date("H:i:s");
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$companyanum = isset($_SESSION['companyanum']) ? $_SESSION['companyanum'] : '';
$companyname = isset($_SESSION['companyname']) ? $_SESSION['companyname'] : '';
$docno = isset($_SESSION['docno']) ? $_SESSION['docno'] : '';

// Date range defaults
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

// Initialize form variables
$suppliername = "";
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

// Input sanitization function
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// CSRF Token generation
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(32));
}

// CSRF Token validation function
function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && $_SESSION['csrf_token'] === $token;
}

// Handle form submissions with CSRF protection
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
        die('CSRF token validation failed');
    }
    
    // Sanitize POST data
    $searchsuppliername = isset($_POST['searchsuppliername']) ? sanitizeInput($_POST['searchsuppliername']) : $searchsuppliername;
    $cbsuppliername = isset($_POST['cbsuppliername']) ? sanitizeInput($_POST['cbsuppliername']) : $cbsuppliername;
}



$query31 = "select fromyear,toyear from master_financialyear where status = 'Active' order by auto_number desc";

$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));

$res31 = mysqli_fetch_array($exec31);

$finfromyear = $res31['fromyear']; 

$fintoyear = $res31['toyear'];



$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

	

$locationname = $res["locationname"];

$locationcode = $res["locationcode"];



//This include updatation takes too long to load for hunge items database.

//include ("autocompletebuild_accounts.php");



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



if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }

if (isset($_REQUEST["searchsupplieranum"])) { $searchsupplieranum = $_REQUEST["searchsupplieranum"]; } else { $searchsupplieranum = ""; }

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_POST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{



	$searchsuppliername = $_POST['searchsuppliername'];

	if ($searchsuppliername != '')

	{

		//$arraysupplier = explode("#", $searchsuppliername);

		$arraysuppliername = $searchsuppliername;

		$arraysuppliercode = $searchsuppliercode;

		

		$query1 = "select * from master_supplier where suppliercode = '$arraysuppliercode'";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res1 = mysqli_fetch_array($exec1);

		$supplieranum = $res1['auto_number'];

		$openingbalance = $res1['openingbalance'];



		

		$suppliername = $arraysuppliername;

		$suppliercode = $arraysuppliercode;

	}

	else

	{

		$cbsuppliername = $_REQUEST['searchsuppliername'];

		$suppliername = $_REQUEST['searchsuppliername'];

	}



}



if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];

if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

//$frmflag2 = $_POST['frmflag2'];



if ($frmflag2 == 'frmflag2')

{

	

	

		//For generating first code

		//include ("transactioncodegenerate1pharmacy.php");



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

		$bankname1 = $_REQUEST['bankname'];

		$banknamesplit = explode('||',$bankname1);

		$bankcode = $banknamesplit[0];

		$bankname = $banknamesplit[1];
		$bankbranch = $banknamesplit[2];

		//$bankbranch = $_REQUEST['bankbranch'];

		$remarks = $_REQUEST['remarks'];

		$currency_mode_amount= ($_REQUEST['currency']>0)?$_REQUEST['currency']:1;

		$paymentamount = str_replace(',', '', $_REQUEST['paymentamount'])*$currency_mode_amount;

		$pendingamount = $_REQUEST['pendingamount'];

		$remarks = $_REQUEST['remarks'];
		
			$bankcharges = $_REQUEST['bankcharges'];

		$docno = $_REQUEST['docno'];

		$transactionamount = $paymentamount;

		$acccode = $_REQUEST['acccode'];

		$accname = $_REQUEST['accname'];

		$accanum = $_REQUEST['accanum'];	

		$cashcoa = $_REQUEST['cashcoa'];

		$chequecoa = $_REQUEST['chequecoa'];

		$cardcoa = $_REQUEST['cardcoa'];

		$mpesacoa = $_REQUEST['mpesacoa'];

		$onlinecoa = $_REQUEST['onlinecoa'];

		 $paymentamount=str_replace(',', '', $paymentamount);

		$pendingamount=str_replace(',', '', $pendingamount);	

		$balanceamount = $pendingamount - $paymentamount;

		$transactiondate = $paymententrydate;

		$balanceamount=str_replace(',', '', $balanceamount);

		$transactionmode = $paymentmode;

		

	

		$currency = 'Kenya Shillings';

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

		

		$paynowbillprefix = 'AR-';

		$paynowbillprefix1=strlen($paynowbillprefix);

		

		$query2 = "select paylaterdocno from master_transactionpaylater where transactiontype='PAYMENT' and paylaterdocno <>'' order by auto_number desc 							limit 0, 1";

		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res2 = mysqli_fetch_array($exec2);

		$billnumber = $res2["paylaterdocno"];

		$billdigit=strlen($billnumber);

		if ($billnumber == '')

		{

			$billnumbercode ='AR-'.'1';

			$openingbalance = '0.00';

		}

		else

		{

			$billnumber = $res2["paylaterdocno"];

			$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);

			//echo $billnumbercode;

			$billnumbercode = intval($billnumbercode);

			$billnumbercode = $billnumbercode + 1;

		

			$maxanum = $billnumbercode;

			

			

			$billnumbercode = 'AR-' .$maxanum;

			$openingbalance = '0.00';

			//echo $companycode;

		}

		$docno = $billnumbercode;

		

		$transactionmodule = 'PAYMENT';

		if(isset($_POST['onaccount']))

		{

		

		$query55 = "select * from master_accountname where accountname='$accname'";

		$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$res55 = mysqli_fetch_array($exec55);

		$paytype = $res55['paymenttype'];

		$subpaytype = $res55['subtype'];

		

		$querytype1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_paymenttype where auto_number='$paytype'");

		$exectype1=mysqli_fetch_array($querytype1);

		$patienttype11=$exectype1['paymenttype'];

		

		$querysubtype1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$subpaytype'");

		$execsubtype1=mysqli_fetch_array($querysubtype1);

		$patientsubtype11=$execsubtype1['subtype'];

		$subtypeano = $execsubtype1['auto_number'];

			

		$query2dup = "select paylaterdocno from master_transactionpaylater where paylaterdocno='$docno'";

		$exec2dup = mysqli_query($GLOBALS["___mysqli_ston"], $query2dup) or die ("Error in query2dup".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num2dup = mysqli_num_rows($exec2dup);

		if($num2dup=='0')

		{

		

	if ($paymentmode == 'CASH')

		{

		$transactiontype = 'PAYMENT';

		$transactionmode = 'CASH';

		$particulars = 'BY CASH '.$billnumberprefix.$billnumber.'';	

		

		$query9 = "insert into master_transactionpaylater (transactiondate, particulars, 

		transactionmode, transactiontype,ipaddress, updatedate, companyanum, companyname, remarks, 

		transactionmodule,accountname,docno,recordstatus,receivableamount,paylaterdocno,transactionamount,cashamount,transactionstatus,paymenttype,subtype,username,accountcode,locationcode,locationname,acc_flag,subtypeano,accountnameid,accountnameano,bankcode,currency,fxrate,fxamount,bankname,bankbranch,transactiontime) 

		values ('$transactiondate', '$particulars', 

		'$transactionmode', '$transactiontype','$ipaddress', '$updatedate','$companyanum', '$companyname', '$remarks', 

		'$transactionmodule','$accname','$docno','','$paymentamount','$docno','$paymentamount','$paymentamount','onaccount','$patienttype11','$patientsubtype11','$username','$acccode','$locationcode','$locationname','2','$subtypeano','$acccode','$accanum','$bankcode','$currency','1','$paymentamount','$bankname','$bankbranch','$timeonly')";

		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

		

		$queryon = "insert into master_transactiononaccount (`transactiondate`, `docno`, `particulars`, `paymenttype`, `subtype`, `accountcode`, `accountname`, `transactionmode`, `transactiontype`, `transactionmodule`, `transactionstatus`, 

		`transactionamount`, `adjamount`, `balanceamount`, `ipaddress`, `updatedate`, `recordstatus`, `companyanum`, `companyname`,`locationcode`,`locationname`,`cashamount`, `bankcode`,`bankname`,bankbranch,bank_charge,remarks)

		values('$transactiondate','$docno','onaccount','$patienttype11','$patientsubtype11','$acccode','$accname','$transactionmode','$transactiontype','$transactionmodule','onaccount',

		'$paymentamount','$paymentamount','0.00','$ipaddress','$transactiondate','','$companyanum', '$companyname','$locationcode','$locationname','$paymentamount','$bankcode','$bankname','$bankbranch','$bankcharges','$remarks')";

		$execon = mysqli_query($GLOBALS["___mysqli_ston"], $queryon) or die ("Error in Queryon".mysqli_error($GLOBALS["___mysqli_ston"]));

		

		$query37 = "insert into paymentmodedebit(accountname,billnumber,billdate,ipaddress,username,cash,cashcoa,source,locationcode,locationname)values('$accname','$docno','$transactiondate','$ipaddress','$username','$paymentamount','$cashcoa','accountreceivable','$locationcode','$locationname')";

        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	

		}

		if ($paymentmode == 'ONLINE')

		{

		$transactiontype = 'PAYMENT';

		$transactionmode = 'ONLINE';

		$particulars = 'BY ONLINE '.$billnumberprefix.$billnumber.'';	

		

		$query9 = "insert into master_transactionpaylater (transactiondate, particulars, 

		transactionmode, transactiontype,ipaddress, updatedate, companyanum, companyname, remarks, 

		transactionmodule,accountname,docno,recordstatus,receivableamount,paylaterdocno,transactionamount,onlineamount,transactionstatus,chequenumber,paymenttype,subtype,username, accountcode,locationcode,locationname,acc_flag,subtypeano,accountnameid,accountnameano,bankcode,currency,fxrate,fxamount,bankname,bankbranch,transactiontime) 

		values ('$transactiondate', '$particulars', 

		'$transactionmode', '$transactiontype','$ipaddress', '$updatedate','$companyanum', '$companyname', '$remarks', 

		'$transactionmodule','$accname','$docno','','$paymentamount','$docno','$paymentamount','$paymentamount','onaccount','$chequenumber','$patienttype11','$patientsubtype11','$username','$acccode','$locationcode','$locationname','2','$subtypeano','$acccode','$accanum','$bankcode','$currency','1','$paymentamount','$bankname','$bankbranch','$timeonly')";

		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

		

		$queryon = "insert into master_transactiononaccount (`transactiondate`, `docno`, `particulars`, `paymenttype`, `subtype`, `accountcode`, `accountname`, `transactionmode`, `transactiontype`, `transactionmodule`, `transactionstatus`, 

		`transactionamount`, `adjamount`, `balanceamount`, `ipaddress`, `updatedate`, `recordstatus`, `companyanum`, `companyname`,`locationcode`,`locationname`,`onlineamount`, `bankcode`,bankname,bankbranch,bank_charge,remarks)

		values('$transactiondate','$docno','onaccount','$patienttype11','$patientsubtype11','$acccode','$accname','$transactionmode','$transactiontype','$transactionmodule','onaccount',

		'$paymentamount','$paymentamount','0.00','$ipaddress','$transactiondate','','$companyanum', '$companyname','$locationcode','$locationname','$paymentamount','$bankcode','$bankname','$bankbranch','$bankcharges','$remarks')";

		$execon = mysqli_query($GLOBALS["___mysqli_ston"], $queryon) or die ("Error in Queryon".mysqli_error($GLOBALS["___mysqli_ston"]));

		

		

		$query37 = "insert into paymentmodedebit(accountname,billnumber,billdate,ipaddress,username,online,onlinecoa,source,locationcode,locationname)values('$accname','$docno','$transactiondate','$ipaddress','$username','$paymentamount','$onlinecoa','accountreceivable','$locationcode','$locationname')";

        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	

		}

		if ($paymentmode == 'CHEQUE')

		{

		$transactiontype = 'PAYMENT';

		$transactionmode = 'CHEQUE';

		$particulars = 'BY CHEQUE '.$billnumberprefix.$billnumber;		



	

	     $query9 = "insert into master_transactionpaylater (transactiondate, particulars, 

		transactionmode, transactiontype,ipaddress, updatedate, companyanum, companyname, remarks, 

		transactionmodule,accountname,docno,recordstatus,receivableamount,paylaterdocno,transactionamount,chequeamount,chequenumber,chequedate,bankname,transactionstatus,paymenttype,subtype,username, accountcode,locationcode,locationname,acc_flag,subtypeano,accountnameid,accountnameano,bankcode,currency,fxrate,fxamount,bankbranch,transactiontime) 

		values ('$transactiondate', '$particulars', '$transactionmode', '$transactiontype','$ipaddress', '$updatedate','$companyanum', '$companyname', '$remarks','$transactionmodule','$accname','$docno','','$paymentamount','$docno','$paymentamount','$paymentamount','$chequenumber','$chequedate','$bankname','onaccount','$patienttype11','$patientsubtype11','$username','$acccode','$locationcode','$locationname','2','$subtypeano','$acccode','$accanum','$bankcode','$currency','1','$paymentamount','$bankbranch','$timeonly')";

		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

		

		$queryon = "insert into master_transactiononaccount (`transactiondate`, `docno`, `particulars`, `paymenttype`, `subtype`, `accountcode`, `accountname`, `transactionmode`, `transactiontype`, `transactionmodule`, `transactionstatus`, `transactionamount`, `adjamount`, `balanceamount`, `ipaddress`, `updatedate`, `recordstatus`, `companyanum`, `companyname`,`locationcode`,`locationname`,`chequeamount`, `bankcode`,bankname,bankbranch,chequenumber,chequedate,bank_charge,remarks)
		values('$transactiondate','$docno','onaccount','$patienttype11','$patientsubtype11','$acccode','$accname','$transactionmode','$transactiontype','$transactionmodule','onaccount',
		'$paymentamount','$paymentamount','0.00','$ipaddress','$transactiondate','','$companyanum', '$companyname','$locationcode','$locationname','$paymentamount','$bankcode','$bankname','$bankbranch','$chequenumber','$chequedate','$bankcharges','$remarks')";
		$execon = mysqli_query($GLOBALS["___mysqli_ston"], $queryon) or die ("Error in Queryon".mysqli_error($GLOBALS["___mysqli_ston"]));

		$query37 = "insert into paymentmodedebit(accountname,billnumber,billdate,ipaddress,username,cheque,chequecoa,source,locationcode,locationname)values('$accname','$docno','$transactiondate','$ipaddress','$username','$paymentamount','$chequecoa','accountreceivable','$locationcode','$locationname')";

        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	

		}

		if ($paymentmode == 'WRITEOFF')

		{

		$transactiontype = 'PAYMENT';

		$transactionmode = 'WRITEOFF';

		$particulars = 'BY WRITEOFF '.$billnumberprefix.$billnumber;		

		

		$query9 = "insert into master_transactionpaylater (transactiondate, particulars, 

		transactionmode, transactiontype,ipaddress, updatedate, companyanum, companyname, remarks, 

		transactionmodule,accountname,docno,recordstatus,receivableamount,paylaterdocno,transactionamount,writeoffamount,transactionstatus,paymenttype,subtype,username,accountcode,locationcode,locationname,acc_flag,subtypeano,accountnameid,accountnameano,bankcode,currency,fxrate,fxamount,bankname,bankbranch,transactiontime) 

		values ('$transactiondate', '$particulars', 

		'$transactionmode', '$transactiontype','$ipaddress', '$updatedate','$companyanum', '$companyname', '$remarks', 

		'$transactionmodule','$accname','$docno','','$paymentamount','$docno','$paymentamount','$paymentamount','onaccount','$patienttype11','$patientsubtype11','$username','$acccode','$locationcode','$locationname','2','$subtypeano','$acccode','$accanum','$bankcode','$currency','1','$paymentamount','$bankname','$bankbranch','$timeonly')";

		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

		

		}

		}

		

		}

		

		header ("location:paylaterpaymententry.php?st=1&doc_bill_number=$docno");

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



<?php

	if(isset($_REQUEST['doc_bill_number'])){

?>

	<script>

	window.open('printaccountrecievable.php?billnumber=<?= $_REQUEST['doc_bill_number'] ?>','OriginalWindow','width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

	</script>

<?php

	}



?>

<script language="javascript">



function cbsuppliername1()

{

	document.cbform1.submit();

}


</script>

<!--<script type="text/javascript" src="js/autocomplete_accounts.js"></script>

<script type="text/javascript" src="js/autosuggest2accounts.js"></script>

<script type="text/javascript">

window.onload = function () 

{

	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        

}

</script>-->



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
	if (document.getElementById("paymententrydate").value == "")

	{

		alert ("Please Select Receipt Date ");

		document.getElementById("paymententrydate").focus();

		return false;

	}

	if (document.getElementById("searchsuppliercode").value == "")

	{

		alert ("Please Select Proper Receivable account ");

		document.getElementById("searchsuppliername").focus();

		document.getElementById("searchsuppliername").value = ""

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

	var numbers =/^[a-zA-Z]+$/;

	if ((document.getElementById("paymentamount").value.match(numbers)))

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

	}	

	if (document.getElementById("bankname").value == "")

	{

		alert ("Account Name Cannot Be Empty.");

		document.getElementById("bankname").focus();

		return false;

	}	
	
	if (document.getElementById("remarks").value == "")

	{

		alert ("Remarks Cannot Be Empty.");

		document.getElementById("remarks").focus();

		return false;

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


function isNumberKey(evt, element) {
  var charCode = (evt.which) ? evt.which : event.keyCode
  if (charCode > 31 && (charCode < 48 || charCode > 57) && !(charCode == 46 || charCode == 8))
    return false;
  else {
    var len = $(element).val().length;
    var index = $(element).val().indexOf('.');
    if (index > 0 && charCode == 46) {
      return false;
    }
    if (index > 0) {
      var charAfterdot = (len + 1) - index;
      if (charAfterdot > 3) {
        return false;
      }
    }

  }
  return true;
}
</script>

<script>

function updatebox(varSerialNumber,billamt,totalcount1)

{

if(document.getElementById("onaccount").checked == true)

{

alert("Dont Select Invoice");

document.getElementById("acknow"+varSerialNumber+"").checked = false;

return false;

}

var adjamount1;

var grandtotaladjamt2=0;

var varSerialNumber = varSerialNumber;

var totalcount1=totalcount1;

var billamt = billamt;

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

	totalbillamt=totalbillamt.replace(/,/g,'');

	if(totalbillamt == 0.00)

{

totalbillamt=0;

}

				totalbillamt=parseFloat(totalbillamt)+parseFloat(billamt);

			

			//alert(totalbillamt);

totalbillamt = totalbillamt.toFixed(2);

totalbillamt = totalbillamt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

document.getElementById("paymentamount").value = totalbillamt;

document.getElementById("totaladjamt").value = totalbillamt;

}

else

{

//alert(totalcount1);

for(j=1;j<=totalcount1;j++)

{

var totaladjamount2=document.getElementById("adjamount"+j+"").value;



if(totaladjamount2 == "")

{

totaladjamount2=0;

}

grandtotaladjamt2=grandtotaladjamt2+parseFloat(totaladjamount2);

}

//alert(grandtotaladjamt);

document.getElementById("paymentamount").value = grandtotaladjamt2.toFixed(2);

document.getElementById("totaladjamt").value=grandtotaladjamt2.toFixed(2);



 }  

}

function checkboxcheck(varSerialNumber5)

{



if(document.getElementById("acknow"+varSerialNumber5+"").checked == false)

{

alert("Please click on the Select check box");

return false;

}

return true;

}



function checkvalid(totcount)

{

var totcount=totcount;



for(j=1;j<=totcount;j++)

{

if(document.getElementById("acknow"+j+"").checked == true)

{

alert("Please deselect invoice");



return false;

}

}

return true;



}



function checkboxvalidat()

{

var accname = document.getElementById("searchsuppliername").value;

if(accname == '')

{

alert('Please Select the Account');

document.getElementById("searchsuppliername").focus();

return false;

}

var chks = document.getElementsByName('onaccount');

var hasChecked = false;

for (var i = 0; i < chks.length; i++)

{

if (chks[i].checked)

{

hasChecked = true;

}

}



var chks1 = document.getElementsByName('ack[]');

hasChecked1 = false;

for(var j = 0; j < chks1.length; j++)

{

if(chks1[j].checked)

{

hasChecked1 = true;

}

}



if (hasChecked == false && hasChecked1 == false)

{

alert("Please Select OnAccount or Invoice");

return false;

}

return true;

}


function bankamountbal()

{
	
	var paymentamount=document.getElementById("paymentamount").value;
	var paymentamount=parseFloat(paymentamount);
	var bankcharges=document.getElementById("bankcharges").value;
	var bankcharges=parseFloat(bankcharges);
	
	if(paymentamount<bankcharges){
		
		alert("Bank charges can't be more than receipt amount");

document.getElementById("bankcharges").value = '';
		
	}
}

function balancecalc(varSerialNumber1,billamt1,totalcount)

{

var varSerialNumber1 = varSerialNumber1;

var billamt1 = billamt1;

var totalcount=totalcount;

var grandtotaladjamt=0;



var adjamount=document.getElementById("adjamount"+varSerialNumber1+"").value;

var adjamount3=parseFloat(adjamount);

if(adjamount3 > billamt1)

{

alert("Please enter correct amount");

document.getElementById("paymentamount").value = '0.00';

document.getElementById("totaladjamt").value = '0.00';

document.getElementById("adjamount"+varSerialNumber1+"").value = '0.00';

document.getElementById("balamount"+varSerialNumber1+"").value = billamt1;

document.getElementById("adjamount"+varSerialNumber1+"").focus();

return false;

}

var balanceamount=parseFloat(billamt1)-parseFloat(adjamount);

balanceamount = balanceamount.toFixed(2);

balanceamount = balanceamount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

document.getElementById("balamount"+varSerialNumber1+"").value=balanceamount;

for(i=1;i<=totalcount;i++)

{

var totaladjamount=document.getElementById("adjamount"+i+"").value;

if(totaladjamount == "")

{

totaladjamount=0;

}

grandtotaladjamt=grandtotaladjamt+parseFloat(totaladjamount);



}

grandtotaladjamt = grandtotaladjamt.toFixed(2);

grandtotaladjamt = grandtotaladjamt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

document.getElementById("paymentamount").value = grandtotaladjamt;

document.getElementById("totaladjamt").value=grandtotaladjamt;



}



</script>

<?php



$query765 = "select code from master_financialintegration where field='cashaccountreceivable'";

$exec765 = mysqli_query($GLOBALS["___mysqli_ston"], $query765) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res765= mysqli_fetch_array($exec765);



$cashcoa = $res765['code'];





$query766 = "select code from master_financialintegration where field='chequeaccountreceivable'";

$exec766 = mysqli_query($GLOBALS["___mysqli_ston"], $query766) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res766 = mysqli_fetch_array($exec766);



$chequecoa = $res766['code'];





$query767 = "select code from master_financialintegration where field='mpesaaccountreceivable'";

$exec767 = mysqli_query($GLOBALS["___mysqli_ston"], $query767) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res767 = mysqli_fetch_array($exec767);



$mpesacoa = $res767['code'];



$query768 = "select code from master_financialintegration where field='cardaccountreceivable'";

$exec768 = mysqli_query($GLOBALS["___mysqli_ston"], $query768) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res768 = mysqli_fetch_array($exec768);



$cardcoa = $res768['code'];



$query769 = "select code from master_financialintegration where field='onlineaccountreceivable'";

$exec769 = mysqli_query($GLOBALS["___mysqli_ston"], $query769) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res769 = mysqli_fetch_array($exec769);



$onlinecoa = $res769['code'];



/*$query3 = "select * from master_company where companystatus = 'Active'";

$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());

$res3 = mysql_fetch_array($exec3);*/

$paynowbillprefix = 'AR-';

$paynowbillprefix1=strlen($paynowbillprefix);



$query2 = "select paylaterdocno from master_transactionpaylater where transactiontype='PAYMENT' and paylaterdocno <>'' order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$billnumber = $res2["paylaterdocno"];

$billdigit=strlen($billnumber);

if ($billnumber == '')

{

	$billnumbercode ='AR-'.'1';

	$openingbalance = '0.00';

}

else

{

	$billnumber = $res2["paylaterdocno"];

	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);

	//echo $billnumbercode;

	$billnumbercode = intval($billnumbercode);

	$billnumbercode = $billnumbercode + 1;



	$maxanum = $billnumbercode;

	

	

	$billnumbercode = 'AR-' .$maxanum;

	$openingbalance = '0.00';

	//echo $companycode;

}

?>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />      

<script src="js/jquery-1.11.1.min.js"></script>

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/autocomplete.css">      

<script>

$(document).ready(function(e) {

   

		$('#searchsuppliername').autocomplete({

		

	source:"ajaxaccount_search_new.php",

	//alert(source);

	matchContains: true,

	minLength:1,

	html: true, 

		select: function(event,ui){
			var accountname=ui.item.value;
			var accountid=ui.item.id;
			var accountanum=ui.item.anum;
			$("#searchsuppliercode").val(accountid);
			$("#searchsupplieranum").val(accountanum);
			$("#cbsuppliername").val(accountname);
			$('#searchsuppliername').val(accountname);
			//cbsuppliername1();
			document.cbform1.submit();
			},

    

	});

		

});

function change_currency(){

var cashamount = document.getElementById("paymentamount").value;

 

	$.ajax({
		  url: 'getcurrencytowords.php',
		  type: 'POST',
		  //async: false,
		  dataType: 'json',
		  //processData: false,    
		  data: { 
		      amount: cashamount
		  },
		  success: function (data) { 
		  	
		  	var currencyword = data.msg;
		  	//$('#amount_in_words').html('');
		  	$('#amount_in_words').text(currencyword);
		  	console.log('@wording@'+currencyword);
		  }
		});
	
//document.getElementById("tdShowTotal").value = newbalance;
document.getElementById("tdShowTotal").value = formatMoney(cashamount);
}


function fixed_value(){
	if(document.getElementById("paymentamount").value==""){
			document.getElementById("paymentamount").value ='0.00';
}
document.getElementById("paymentamount").value = parseFloat(document.getElementById("paymentamount").value).toFixed(2);

if(document.getElementById("bankcharges").value==""){
			document.getElementById("bankcharges").value ='0.00';
}
document.getElementById("bankcharges").value = parseFloat(document.getElementById("bankcharges").value).toFixed(2);




}

function formatMoney(number, places, thousand, decimal) {
	number = number || 0;
	places = !isNaN(places = Math.abs(places)) ? places : 2;
	
	thousand = thousand || ",";
	decimal = decimal || ".";
	var negative = number < 0 ? "-" : "",
	    i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",
	    j = (j = i.length) > 3 ? j % 3 : 0;
	return  negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "");

}


function cashentryonfocus1()

{

	if (document.getElementById("paymentamount").value == "0.00")

	{

		document.getElementById("paymentamount").value = "";

		document.getElementById("paymentamount").focus();

	}
	
}
function cashentryonfocus12()

{
	
	if (document.getElementById("bankcharges").value == "0.00")

	{

		document.getElementById("bankcharges").value = "";

		document.getElementById("bankcharges").focus();

	}

	 
}

</script>

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



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pay Later Payment Entry - MedStar Hospital Management System">
    <meta name="robots" content="noindex, nofollow">
    <title>Pay Later Payment Entry - MedStar Hospital</title>
    
    <!-- Preload critical resources -->
    <link rel="preload" href="css/paylaterpayment-modern.css" as="style">
    <link rel="preload" href="js/paylaterpayment-modern.js" as="script">
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/paylaterpayment-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebApplication",
        "name": "MedStar Hospital Management System",
        "description": "Advanced Healthcare Management Platform - Pay Later Payment Entry",
        "url": "<?php echo $_SERVER['REQUEST_URI']; ?>",
        "applicationCategory": "BusinessApplication",
        "operatingSystem": "Web Browser"
    }
    </script>
    
    <!-- Legacy Scripts -->
    <script src="js/datetimepicker_css.js"></script>
</head>

<body>
    <!-- Modern MedStar Hospital Management Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Advanced Healthcare Management Platform</p>
    </header>

    <!-- Navigation Breadcrumb -->
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Dashboard</a>
        <span>→</span>
        <span>Accounts</span>
        <span>→</span>
        <span>Accounts Receivables</span>
        <span>→</span>
        <span>Pay Later Payment Entry</span>
    </nav>

    <!-- Floating Menu Toggle -->
    <button class="floating-menu-toggle" id="mobileMenuToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Main Container with Sidebar -->
    <div class="main-container-with-sidebar" id="mainContainer">
        <!-- Left Sidebar -->
        <aside id="leftSidebar" class="left-sidebar">
            <div class="sidebar-header">
                <h3>🏥 MedStar</h3>
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="sidebar-nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="mainmenu1.php" class="nav-link">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountsmain.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Account Main Types</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountssub.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Account Sub Types</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountname1.php" class="nav-link">
                            <i class="fas fa-tags"></i>
                            <span>Account Names</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountstatement.php" class="nav-link">
                            <i class="fas fa-file-invoice"></i>
                            <span>Account Statement</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountreceivable.php" class="nav-link">
                            <i class="fas fa-hand-holding-usd"></i>
                            <span>Receivables</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountwiseoutstandingreport.php" class="nav-link">
                            <i class="fas fa-chart-pie"></i>
                            <span>Account Wise Outstanding</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="paylaterpaymententry.php" class="nav-link active">
                            <i class="fas fa-credit-card"></i>
                            <span>Pay Later Payment Entry</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="expenses.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>Expenses</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="income.php" class="nav-link">
                            <i class="fas fa-dollar-sign"></i>
                            <span>Income</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addbank1.php" class="nav-link">
                            <i class="fas fa-university"></i>
                            <span>Bank Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="patientmanagement.php" class="nav-link">
                            <i class="fas fa-user-injured"></i>
                            <span>Patient Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="consultation.php" class="nav-link">
                            <i class="fas fa-stethoscope"></i>
                            <span>Consultation</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="labitems.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Items</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="radiology.php" class="nav-link">
                            <i class="fas fa-x-ray"></i>
                            <span>Radiology</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="employeemanagement.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Employee Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="departmentmanagement.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Department Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="rightsaccess.php" class="nav-link">
                            <i class="fas fa-shield-alt"></i>
                            <span>Employee Rights Access</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content">
            <!-- Alert Messages -->
            <?php include ("includes/alertmessages1.php"); ?>
            
            <!-- Success/Error Messages -->
            <?php if ($errmsg != ''): ?>
                <div class="alert alert-<?php echo (strpos($errmsg, 'success') !== false) ? 'success' : 'error'; ?>">
                    <i class="fas fa-<?php echo (strpos($errmsg, 'success') !== false) ? 'check-circle' : 'exclamation-triangle'; ?> alert-icon"></i>
                    <span><?php echo $errmsg; ?></span>
                </div>
            <?php endif; ?>
            
            <!-- Account Search Section -->
            <section class="account-search-section">
                <div class="section-header">
                    <span class="section-icon">🔍</span>
                    <h3 class="section-title">Receivable Entry - Select Account</h3>
                </div>
                
                <form name="cbform1" method="post" action="paylaterpaymententry.php" class="search-form">
                    <!-- CSRF Token -->
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                    
                    <div class="form-layout">
                        <div class="form-group">
                            <label for="searchsuppliername" class="form-label">Search Account *</label>
                            <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo htmlspecialchars($searchsuppliername); ?>" class="form-input" placeholder="Type account name to search..." autocomplete="off" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="cbsuppliername" class="form-label">Account</label>
                            <input name="cbsuppliername" type="text" id="cbsuppliername" value="<?php echo htmlspecialchars($cbsuppliername); ?>" class="form-input" placeholder="Selected account name..." autocomplete="off">
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" onClick="return funcAccount();" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </section>
            
            <!-- Legacy table structure for now -->
            <table width="116%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="860">

		

		

              <form name="cbform1" method="post" action="paylaterpaymententry.php">

		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Receivable Entry     - Select Account </strong></td>

              </tr>

            <tr>

              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

              </tr>

            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Account </td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">

				<input type="hidden" name="searchsuppliercode" id="searchsuppliercode" value="<?php echo $searchsuppliercode; ?>" size="20" />

				<input type="hidden" name="searchsupplieranum" id="searchsupplieranum" value="<?php echo $searchsupplieranum; ?>" size="20" />

              </span></td>

              </tr>

            <tr>

              <td width="18%"  align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> Account </td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

			  

			  <input value="<?php echo $searchsuppliername; ?>" name="cbsuppliername" type="text" id="cbsuppliername" readonly onKeyDown="return disableEnterKey()" size="50" ></td>

              </tr>

            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                  <input  type="submit" value="Search" name="Submit" />

                  <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>

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

		

		

		

				<form name="form1" id="form1" method="post" action="paylaterpaymententry.php?cbfrmflag1=<?php echo $cbfrmflag1; ?>" onSubmit="return paymententry1process1()">

			  <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                <tbody>

				<?php

				// include("rowcount1.php");

				 

				?>

                  <tr bgcolor="#011E6A">

                    <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Receipt Entry - Details </strong></td>

                    <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->

                    <td bgcolor="#ecf0f5" class="bodytext3" colspan="2">

					</td>

                  </tr>

                  <tr>

                    <td colspan="8" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#FFFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>

                  </tr>
                  <tr>
                  	<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Amount </td>
                  	<td width="219" align="left" valign="top"  bgcolor="#FFFFFF">
                  		<input type="text" id="tdShowTotal" name="tdShowTotal" readonly  size="20" value="0.00" style="border:none;background:none;color:#000;font:bold 20px/20px Arial, Helvetica, sans-serif">
                  	</td>
                  	
                  	<td align="left" valign="center" class="bodytext31" colspan="8" bgcolor="#FFFFFF"> <span class="bodytext31" id="amount_in_words" style="border:none;background:none;color:#000;font:bold 15px/15px Arial, Helvetica, sans-serif"></span></td>
                  </tr> 

                  <tr>

                    

                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Receipt Date (YYYY-MM-DD) </td>

                    <td align="left" valign="top"  bgcolor="#FFFFFF">

					<input name="paymententrydate" id="paymententrydate" style="border: 1px solid #001E6A" value=""  readonly="readonly" onKeyDown="return disableEnterKey()" size="20" />

                    <img src="images2/cal.gif" onClick="javascript:NewCssCal('paymententrydate','','','','','','past')" style="cursor:pointer"/>

                    </td>

                     <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>

                    <td align="left" valign="top"  bgcolor="#FFFFFF"></td>

                    <!-- <td width="17%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Total Pending Amount </td>

                    <td width="29%" align="left" valign="top"  bgcolor="#FFFFFF"> -->

					<!-- <input name="pendingamount" id="pendingamount" style="border: 1px solid #001E6A; text-align:right" value=""  size="20" readonly onKeyDown="return disableEnterKey()" /> -->

					<input name="pendingamounthidden" id="pendingamounthidden" type="hidden" value="<?php echo $balanceamount; ?>"  size="20" readonly onKeyDown="return disableEnterKey()" />					</td>

                  </tr>

                  <tr>



                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Currency </td>

                    <td align="left" valign="top"  bgcolor="#FFFFFF">

					<select name="currency" id="currency" style="width: 130px;">

                       <?php  $query_currency=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT rate,currency,defaultcurr FROM master_currency where recordstatus=''") or die("Error ".mysqli_error($GLOBALS["___mysqli_ston"])); 

								while($exec_currency=mysqli_fetch_array($query_currency)){

									?>

									<option value="<?= $exec_currency['rate'] ?>" <?= ($exec_currency['defaultcurr']=="yes")?"selected='selected'":""; ?> > <?= $exec_currency['currency'] ?></option>

						<?php		}

						

						?>

						

                    </select></td>



                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Receivable Amount </td>

                    <td align="left" valign="top"  bgcolor="#FFFFFF">

					<!-- <input name="paymentamount" id="paymentamount" style="border: 1px solid #001E6A; text-align:right" value="0.00"  size="20" onkeypress="return isNumberKey(event,this)" onKeyUp="return change_currency()" onBlur="return fixed_value()" onFocus="return cashentryonfocus1()" /> -->
					
					<input name="paymentamount" id="paymentamount" style="border: 1px solid #001E6A; text-align:right" value="0.00"  size="20" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" onKeyUp="return change_currency()" onBlur="return fixed_value()" onFocus="return cashentryonfocus1()"  />

					<input type="hidden" name="cashcoa" value="<?php echo $cashcoa; ?>">

				<input type="hidden" name="chequecoa" value="<?php echo $chequecoa; ?>">

				<input type="hidden" name="mpesacoa" value="<?php echo $mpesacoa; ?>">

				<input type="hidden" name="cardcoa" value="<?php echo $cardcoa; ?>">

				<input type="hidden" name="onlinecoa" value="<?php echo $onlinecoa; ?>">

				<input type="hidden" name="accname" value="<?php echo $searchsuppliername; ?>">

				<input type="hidden" name="acccode" value="<?php echo $searchsuppliercode; ?>">

				<input type="hidden" name="accanum" value="<?php echo $searchsupplieranum; ?>">

		</td>

                  </tr>

                  <tr>

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

					

	                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Cheque Number </td>

                    <td align="left" valign="top"  bgcolor="#FFFFFF">

					<input name="chequenumber" id="chequenumber" style="border: 1px solid #001E6A" value=""  size="20" /></td>

                  </tr>

                  <tr>

                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Account Name </td>

                    <td align="left" valign="top"  bgcolor="#FFFFFF"><!--<input name="bankname" id="bankname" style="border: 1px solid #001E6A" value=""  size="20" />-->

					<select name="bankname" id="bankname">

					<option value="">Select Account</option>

					<?php 

					$querybankname = "select bankcode as bankcode,bankname as bankname,branchname as branchname from master_bank where bankstatus!='Deleted' and branchcode!=''
					                  union all
									  select id as bankcode,accountname as bankname,'' as branchname from master_accountname where recordstatus!='Deleted' and accountssub IN ('7') and id!='02-5000-5' and accountsmain='2'

					";

					$execbankname = mysqli_query($GLOBALS["___mysqli_ston"], $querybankname) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

					while($resbankname = mysqli_fetch_array($execbankname))

					{?>

						<option value="<?php echo $resbankname['bankcode'].'||'.$resbankname['bankname'].'||'.$resbankname['branchname']; ?>"><?php echo $resbankname['bankname']; ?></option>

					<?php

					}

					?>

					</select>

					</td>

                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Cheque Date </td>

                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value=""  size="20"  readonly="readonly" onKeyDown="return disableEnterKey()" />

					<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>

				    </td>

                  </tr>

                  <tr>

                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Remarks</td>

                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="remarks" id="remarks" style="border: 1px solid #001E6A" value=""  size="20" />

					 <input type="hidden" name="docno" value="<?php echo $billnumbercode; ?>"></td>
				
				<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Bank Charges</td>

                    <td align="left" valign="top"  bgcolor="#FFFFFF">

					<input name="bankcharges" id="bankcharges" style="border: 1px solid #001E6A; text-align:right" value="0.00"  size="20" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  onBlur="return fixed_value()" onFocus="return cashentryonfocus12()" onKeyUp="return bankamountbal()"  />
					
					</td>
				</tr>
				<tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">ON Account</td>

                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input type="checkbox" name="onaccount" id="onaccount" onClick="return checkvalid('<?php echo $number; ?>');" checked></td>
				
				<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
				
                     </tr>

                  <tr>

				  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                    <td align="left" valign="top"  bgcolor="#FFFFFF"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">

                      <input type="hidden" name="cbfrmflag2" value="<?php echo $supplieranum; ?>">

                      <input type="hidden" name="frmflag2" value="frmflag2">

                      <input name="Submit" type="submit"  value="Save Payment" class="button" onClick="return checkboxvalidat();"style="border: 1px solid #001E6A"/>

                    </font></td>

                  </tr>

                </tbody>

              </table>

			 	</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

	  <tr>

        <td>

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

    <!-- Modern JavaScript -->
    <script src="js/paylaterpayment-modern.js?v=<?php echo time(); ?>"></script>

<?php include ("includes/footer1.php"); ?>
</body>
</html>



