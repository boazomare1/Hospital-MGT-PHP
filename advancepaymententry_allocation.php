<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$suppliername="";

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
$docno1 = $_SESSION['docno'];
$locationdetails="select locationcode from login_locationdetails where username='$username' and docno='$docno1'";
$exeloc=mysqli_query($GLOBALS["___mysqli_ston"], $locationdetails);
$resloc=mysqli_fetch_array($exeloc);
$locationcode=$resloc['locationcode'];
$locationname=$companyname;


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

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }

if ($frm1submit1 == 'frm1submit1')
{
$docnum = $_REQUEST['docnumber'];
// $docname = $_REQUEST['docname'];
$billstatus='unpaid';

foreach($_POST['auto_number1'] as $key => $value)
		{
		$billnum2=$_POST['billnum2'][$key];
		$auto_number=$_POST['auto_number1'][$key];
		foreach($_POST['acknow_1'] as $check1)
		{
		$acknow_1=$check1;
		if($acknow_1==$auto_number)
		{
		  $query8="update advance_payment_allocation set recordstatus = 'deallocated' where  billnumber='$billnum2' and auto_number='$auto_number'";
		$exec8=mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		
		$query87="update billing_paylater set doctorstatus='$billstatus' where billno='$billnum2'";
								$exec87=mysqli_query($GLOBALS["___mysqli_ston"], $query87);
								$query88="update billing_paynow set doctorstatus='$billstatus' where billno='$billnum2'";
								$exec88=mysqli_query($GLOBALS["___mysqli_ston"], $query88);
								// $query90="update billing_ipprivatedoctor set doctorstatus='$billstatus' where docno='$billnum2' and description='$docname' and auto_number = '$billautonumber' ";
								// $exec90=mysql_query($query90);

		}
		}
		}
header("location:advancepaymententry_list.php?docno=$docnum");
// header("location:advancepaymententry_allocation.php?docno=$docnum");
exit;
}


/////////////// for allocation //////////////////////
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];
if ($frmflag2 == 'frmflag2')
{
			 
 
 			$docno  = $_REQUEST['docnumber'];
 			$docname = $_REQUEST['docname'];
 			$entrydate = $_REQUEST['entrydate'];
 			$transactionamount = $_REQUEST['transactionamount'];
 			$transactionmode = $_REQUEST['transactionmode'];
 			$check_mp_number = $_REQUEST['check_mp_number'];

			$bankname = $_REQUEST['bankname'];
			$bankcode = $_REQUEST['bankcode'];
			$billautonumber = '';
			 
			$doctorcode = $_REQUEST['docode'];
 
			$transactiontype = 'PAYMENT';
			 
			$ipaddress = $ipaddress;
			$updatedate = $updatedatetime;
			$recordstatus = 'allocated';


			/////////// for loops 
			$openingbalance=0;
			$closingbalance=0;

			$transactionmodule = 'PAYMENT';

			

			foreach($_POST['serialno'] as $key => $value)
					{
						//echo count($_POST['billnum']);
						 $billnum=$_POST['billnum'][$key];
						$patientname=$_POST['name'][$key];
						$accountname=$_POST['accountname'][$key];
						$patientcode=$_POST['patientcode'][$key];
						$visitcode=$_POST['visitcode'][$key];
						$doctorname=$_POST['doctorname'][$key];
						$serialno=$_POST['serialno'][$key];
						$transactiondate_bill=$_POST['billdate_transaction'][$key];
						$transactiondate=$entrydate;
						//echo $doctorname;
						$balanceamount=$_POST['balamount'][$key];
						//echo $balamount;
						if($balanceamount == 0.00)
						{
							$billstatus='paid';
						}
						else
						{
							$billstatus='unpaid';
						}
						//echo $billstatus;
						$adjamount=$_POST['adjamount'][$key];
						
						foreach($_POST['ack'] as $check)
						{
						$acknow=$check;
						if($acknow==$serialno)
						{

							if($adjamount>0 || $adjamount<0){
							$querychk1 = "select visitcode from advance_payment_allocation where visitcode = '$visitcode' and transactionamount = '$adjamount' and billnumber = '$billnum' and recordstatus='allocated' and doctorcode='$doctorcode'";
							$execchk1 = mysqli_query($GLOBALS["___mysqli_ston"], $querychk1) or die ("Error in querychk1".mysqli_error($GLOBALS["___mysqli_ston"]));
							$numchk = mysqli_num_rows($execchk1);
							if($numchk == 0)
							{
								$query87="update billing_paylater set doctorstatus='$billstatus' where billno='$billnum'";
								$exec87=mysqli_query($GLOBALS["___mysqli_ston"], $query87);
								$query88="update billing_paynow set doctorstatus='$billstatus' where billno='$billnum'";
								$exec88=mysqli_query($GLOBALS["___mysqli_ston"], $query88);
								$query90="update billing_ipprivatedoctor set doctorstatus='$billstatus' where docno='$billnum' and description='$doctorname' and auto_number = '$billautonumber'";
								$exec90=mysqli_query($GLOBALS["___mysqli_ston"], $query90);
								
								$netpayable=$adjamount;
								$billnumberprefix='';
								// $billnumber=$docno;

				if($transactionmode=='CASH'){
					$particulars = 'BY CASH '.$billnumberprefix.$docno.'';	
					$cashamount=$netpayable;
					$onlineamount='0';
					$chequeamount='0';
					$mpesaamount='0';
					$writeoffamount='0';
				}
				if($transactionmode=='CHEQUE'){
					$particulars = 'BY CHEQUE '.$billnumberprefix.$docno.'';	
					$cashamount='0';
					$onlineamount='0';
					$chequeamount=$netpayable;
					$mpesaamount='0';
					$writeoffamount='0';

					// $chequenumber=$chequenumber_mps;
				}
				if($transactionmode=='MPESA'){
					$particulars = 'BY MPESA '.$billnumberprefix.$docno.'';	
					$cashamount='0';
					$onlineamount='0';
					$chequeamount='0';
					$mpesaamount=$netpayable;
					$writeoffamount='0';

					 // $mpesanumber=$chequenumber_mps;
				}
				if($transactionmode=='ONLINE'){
					$particulars = 'BY ONLINE '.$billnumberprefix.$docno.'';	
					$cashamount='0';
					$onlineamount=$netpayable;
					$chequeamount='0';
					$mpesaamount='0';
					$writeoffamount='0';
				}
				if($transactionmode=='WRITEOFF'){
					$particulars = 'BY WRITEOFF '.$billnumberprefix.$docno.'';	
					$cashamount='0';
					$onlineamount='0';
					$chequeamount='0';
					$mpesaamount='0';
					$writeoffamount=$netpayable;
				}


			$query9="INSERT INTO `advance_payment_allocation`( `transactiondate`, `docno`, `particulars`, `patientcode`, `patientname`, `visitcode`, `accountname`, `doctorcode`, `transactionmode`, `transactiontype`, `transactionmodule`, `transactionamount`,

			 `cashamount`, `onlineamount`, `chequeamount`,  `mpesaamount`, `writeoffamount`, `balanceamount`, `billnumber`, `openingbalance`, `closingbalance`,

			  `bankname`, `ipaddress`, `updatedate`, `recordstatus`, `doctorname`, `billstatus`, `locationname`, `locationcode`, `acc_status`, `username`,`bankcode`) 
			VALUES ('$transactiondate_bill','$docno', '$particulars', '$patientcode', '$patientname', '$visitcode', '$accountname', '$doctorcode', '$transactionmode', '$transactiontype', '$transactionmodule', '$adjamount', 

				'$cashamount','$onlineamount','$chequeamount','$mpesaamount','$writeoffamount','$balanceamount','$billnum','$openingbalance','$closingbalance',

				'$bankname', '$ipaddress', '$updatedate', '$recordstatus', '$doctorname', '$billstatus', '$locationname', '$locationcode', '0', '$username','$bankcode')";
								$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query92".mysqli_error($GLOBALS["___mysqli_ston"]));
								
								// $query37 = "insert into paymentmodecredit(billnumber,billdate,ipaddress,username,cash,cashcoa,source,transactionamount)values('$billnumbercode','$transactiondate','$ipaddress','$username','$adjamount','$cashcoa','doctorpaymententry','$adjamount')";
								// $exec37 = mysql_query($query37) or die(mysql_error());

								// exit();
							}
						
						}	
					}
				} //aadjamount>0 loop
				}
			/////////// for loops 
		
		// header("location:advancepaymententry_allocation.php?docno=$docno");
		// header("location:advancepaymententry_list.php?docno=$docno"); 
		 echo "<script>window.open('print_advancedoctorremittances.php?docno=$docno', '_blank');</script>";
		echo "<script> window.location.href = 'advancepaymententry_list.php';</script>";
 
		exit;
		
}

/////////////// for allocation ////////////////////// closed
include ("autocompletebuild_accounts1.php");


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

if(isset($_REQUEST['docno']))

{

$docno_get = $_REQUEST['docno'];

}

$totalamount=0;





$query2="select * from advance_payment_entry where docno='$docno_get'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);

$transactionamount = $res2['transactionamount'];
			 	  $transactiondate = $res2['transactiondate'];
				  // $date = explode(" ",$transactiondate);

				  $docno = $res2['docno'];
				  $transactionmode = $res2['transactionmode'];
				  $bankcode=$res2['bankcode'];
				  $bankname=$res2['bankname'];
				  $docname = $res2['ledger_name'];
				  $doccode = $res2['ledger_code'];

				  $whtamount = $res2['wht_amount'];
				  $netamount = $res2['bank_amount'];
				  $bankcharges = $res2['bankcharges'];

				  
				  $number='';
				  $name_chq_mpesa='';
				  $chequeamount=$res2['chequeamount'];
				  $mpesaamount=$res2['mpesaamount'];

				  if($chequeamount>0){
				  	$number=$res2['chequenumber'];
				  	$name_chq_mpesa='Cheque Number';
				  }
				  if($mpesaamount>0){
				  	$number=$res2['mpesanumber'];
				  	$name_chq_mpesa='MPESA Number';
				  }

// ------ for total amountallocated for the doc-----------
$query_adp = "SELECT sum(transactionamount) as transactionamount FROM `advance_payment_allocation` WHERE   docno='$docno_get'  and recordstatus='allocated'  ";
								$exec_adp = mysqli_query($GLOBALS["___mysqli_ston"], $query_adp) or die ("Error in Query_adp".mysqli_error($GLOBALS["___mysqli_ston"]));
								$num_adp=mysqli_num_rows($exec_adp);
								// while($res_adp = mysql_fetch_array($exec_adp)){
								$res_adp = mysqli_fetch_array($exec_adp);
								$total_adp_transactioamount = $res_adp['transactionamount'];
								
	$pending_amount_doc=$transactionamount-$total_adp_transactioamount;					
// ------ for total amountallocated for the doc-----------		   

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



<script>

function updatebox(varSerialNumber,billamt,totalcount1)
{
// var adjamount1;
var pending_amount_doc=document.getElementById("pending_amount_doc").value;

var grandtotaladjamt2=0;
var varSerialNumber = varSerialNumber;
var totalcount1=document.getElementById("totcount").value;
var billamt = billamt;
  var textbox = document.getElementById("adjamount"+varSerialNumber+"");
    textbox.value = "";
if(document.getElementById("acknow"+varSerialNumber+"").checked == true)
{
    if(document.getElementById("acknow"+varSerialNumber+"").checked) {
        textbox.value = billamt;
    }
		var balanceamt=parseFloat(billamt)-parseFloat(billamt);
		document.getElementById("balamount"+varSerialNumber+"").value=balanceamt.toFixed(2);
	var totalbillamt=document.getElementById("totaladjamt").value;
	totalbillamt=totalbillamt.replace(/,/g,'');


	var check_pendtoz = parseFloat(pending_amount_doc)-parseFloat(totalbillamt);
	if(check_pendtoz==0){
		alert('Amount Exceeds!');
		// document.getElementById("adjamount"+varSerialNumber+"").focus();
		document.getElementById("adjamount"+varSerialNumber+"").value='';
		document.getElementById("balamount"+varSerialNumber+"").value='';
		document.getElementById("acknow"+varSerialNumber+"").checked = false;
		return false();
	}

		var checktotal = parseFloat(billamt)+parseFloat(totalbillamt);
		// var check_pend = parseFloat(pending_amount_doc)-parseFloat(totalbillamt);
		// if($check_pend<0){
			// alert(checktotal);
		// 		return false;
		// }
		if(checktotal>pending_amount_doc){
				// alert("Please enter the amount");
				// var checkadj = parseFloat(billamt)-(parseFloat(pending_amount_doc)+parseFloat(totalbillamt));
				var checkadj = parseFloat(pending_amount_doc)-parseFloat(totalbillamt);
				if(checkadj<0){
						alert('Amount Exceeds!');
						return false;
				}

				if(checkadj>0){
						var checkbalamount = parseFloat(billamt)-parseFloat(checkadj);
						document.getElementById("adjamount"+varSerialNumber+"").focus();
						document.getElementById("adjamount"+varSerialNumber+"").value=checkadj.toFixed(2);
						document.getElementById("balamount"+varSerialNumber+"").value=checkbalamount.toFixed(2);
						var j;
						var totalcount12=document.getElementById("totcount").value;
						for(j=1;j<=totalcount12;j++)
						{
						var totaladjamount2=document.getElementById("adjamount"+j+"").value;
						if(totaladjamount2 == "")
						{
						totaladjamount2=0;
						}
						grandtotaladjamt2=parseFloat(grandtotaladjamt2)+parseFloat(totaladjamount2);
						}
						grandtotaladjamt2=grandtotaladjamt2.toFixed(2);
						grandtotaladjamt2 = grandtotaladjamt2.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
						document.getElementById("totaladjamt").value=grandtotaladjamt2;
						return false;
				}
				
			return false;	
		}

	

			if(totalbillamt == 0.00)
			{
			totalbillamt=0;
			}
			totalbillamt=parseFloat(totalbillamt)+parseFloat(billamt);
			// alert(totalbillamt);
			totalbillamt1=totalbillamt.toFixed(2);
			totalbillamt1 = totalbillamt1.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
			document.getElementById("totaladjamt").value=totalbillamt1;
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
// document.getElementById("paymentamount").value = grandtotaladjamt2.toFixed(2);
// document.getElementById("netpayable").value = grandtotaladjamt2.toFixed(2);
// document.getElementById("totaladjamt").value=grandtotaladjamt2.toFixed(2);

grandtotaladjamt2=grandtotaladjamt2.toFixed(2);
			grandtotaladjamt2 = grandtotaladjamt2.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
			document.getElementById("totaladjamt").value=grandtotaladjamt2;
 }  
}

function balancecalc(varSerialNumber1,billamt1,totalcount)
{
var varSerialNumber1 = varSerialNumber1;
var billamt1 = billamt1;
var totalcount=document.getElementById("totcount").value;
var grandtotaladjamt=0;
var grandtotaladjamt2=0;
var adjamount=document.getElementById("adjamount"+varSerialNumber1+"").value;
var adjamount3=parseFloat(adjamount);

if(document.getElementById("acknow"+varSerialNumber1+"").checked == false){
	alert('Please Check the checkbox!');
	document.getElementById("acknow"+varSerialNumber1+"").focus();
	document.getElementById("adjamount"+varSerialNumber1+"").value='';
	document.getElementById("balamount"+varSerialNumber1+"").value='';
	return false;
}

var totalbillamt=document.getElementById("totaladjamt").value;
	totalbillamt=totalbillamt.replace(/,/g,'');
var pending_amount_doc=document.getElementById("pending_amount_doc").value;
var pending_amount_doc1=parseFloat(pending_amount_doc);
 // var checkpendg = parseFloat(pending_amount_doc)-(parseFloat(totalbillamt)-parseFloat(adjamount));

	// if((adjamount3 > billamt1) || (totalbillamt>pending_amount_doc))
	if(adjamount3 > billamt1)
	{
	alert("Please enter correct amount");
	document.getElementById("adjamount"+varSerialNumber1+"").focus();
	document.getElementById("adjamount"+varSerialNumber1+"").value='0.00';
	document.getElementById("balamount"+varSerialNumber1+"").value='0.00';
	var totalcount12=document.getElementById("totcount").value;
	// alert(totalcount12);
		var j;
		for(j=1;j<=totalcount12;j++)
				{
				var totaladjamount2=document.getElementById("adjamount"+j+"").value;
				if(totaladjamount2 == "")
				{
					totaladjamount2=0;
				}
				 grandtotaladjamt2=parseFloat(grandtotaladjamt2)+parseFloat(totaladjamount2);
				}
				// alert(grandtotaladjamt2);
				grandtotaladjamt2=grandtotaladjamt2.toFixed(2);
							grandtotaladjamt2 = grandtotaladjamt2.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
							document.getElementById("totaladjamt").value=grandtotaladjamt2;
	
	return false;
	}
var balanceamount=parseFloat(billamt1)-parseFloat(adjamount);
	balanceamount=balanceamount.toFixed(2);
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
//alert(grandtotaladjamt);

	grandtotaladjamt1=grandtotaladjamt.toFixed(2);
	grandtotaladjamt1 = grandtotaladjamt1.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

// document.getElementById("paymentamount").value = grandtotaladjamt.toFixed(2);
document.getElementById("totaladjamt").value=grandtotaladjamt1;
 
var check_pendtoz = parseFloat(grandtotaladjamt)-parseFloat(pending_amount_doc);
// alert(check_pendtoz);
	if(check_pendtoz>0){
	alert("Please enter correct amount");
	document.getElementById("adjamount"+varSerialNumber1+"").focus();
	document.getElementById("adjamount"+varSerialNumber1+"").value='0.00';
	document.getElementById("balamount"+varSerialNumber1+"").value='0.00';
	var totalcount12=document.getElementById("totcount").value;
	// alert(totalcount12);
		var j;
		for(j=1;j<=totalcount12;j++)
				{
				var totaladjamount2=document.getElementById("adjamount"+j+"").value;
				if(totaladjamount2 == "")
				{
					totaladjamount2=0;
				}
				 grandtotaladjamt2=parseFloat(grandtotaladjamt2)+parseFloat(totaladjamount2);
				}
				// alert(grandtotaladjamt2);
				grandtotaladjamt2=grandtotaladjamt2.toFixed(2);
							grandtotaladjamt2 = grandtotaladjamt2.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
							document.getElementById("totaladjamt").value=grandtotaladjamt2;
	
	return false;
	 
}

}

////////////////// fro deallocation //////////
function updatebox1(varSerialNumber6,billamt6,totalcount6)
{
var grandtotalamt = 0;
var varSerialNumber6 = varSerialNumber6;
var totalcount6=totalcount6;
var billamt6 = billamt6;

  document.getElementById("amt"+varSerialNumber6+"").value='';
if(document.getElementById("acknow_1"+varSerialNumber6+"").checked == true)
{
		var totalbillamt6=document.getElementById("totaladjamt1").value;
	if(totalbillamt6 == 0.00)
{
totalbillamt6=0;
}
				totalbillamt6=parseFloat(totalbillamt6)+parseFloat(billamt6);
			document.getElementById("amt"+varSerialNumber6+"").value=billamt6;
document.getElementById("totaladjamt1").value=totalbillamt6.toFixed(2);
}
else
{
for(j=1;j<=totalcount6;j++)
{
var totalamt=document.getElementById("amt"+j+"").value;
if(totalamt == "")
{
totalamt=0;
}
grandtotalamt=grandtotalamt+parseFloat(totalamt);
}
document.getElementById("totaladjamt1").value=grandtotalamt.toFixed(2);
 }  
}
////////////////// fro deallocation //////////

function amountcheck(){
var a=document.getElementById("totaladjamt").value;
a=a.replace(/,/g,'');
	if(a=='0.00'){
		alert('Please Allocate the amount!');
		return false;
	}
	// var b=document.getElementById("billamount_adp2").value;
	var b=document.getElementById("pending_amount_doc").value;
	var c = parseFloat(a)-parseFloat(b);
	if(c=='0.00'){
				var check = confirm("Are you sure you want to Save?");
        if (check == true) {
            return true;
        }
        else {
            return false;
        }
			
	}else{
		alert('Please Allocate the Advance Amount Fully to Save the Form.');
		return false;
	}

}

function acknowledgevalid(){
var aaa=document.getElementById("totaladjamt1").value;
	if(aaa==''){
		alert('Please Check the checkbox!');
		return false;
	}
	var check = confirm("Are you sure you want to Deallocate?");
        if (check == true) {
            return true;
        }
        else {
            return false;
        }
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

    <td width="97%" valign="top"><table border="0" cellspacing="0" cellpadding="0">

	

	

	

      <tr>

        <td width="709">

		

		

              <form name="cbform1" method="post" action="advancepaymententry_allocation.php" onSubmit="disablebuttonfunc()">

			<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="709" 

            align="left" border="0">

          <tbody>

		  

		  <tr>

	<td class="bodytext31" valign="center"  align="left" width="12%"><strong>DOC No

	  

	</strong></td>

	<td class="bodytext31" valign="center"  align="left"><?php echo $docno; ?></td>

	
<input type="hidden" name="docnumber" value="<?php echo $docno; ?>" size="6" class="bal">
<input type="hidden" name="docname" value="<?php echo $docname; ?>" size="6" class="bal">
<input type="hidden" name="docode" value="<?php echo $doccode; ?>" size="6" class="bal">
<input type="hidden" name="bankcode" value="<?php echo $bankcode; ?>" size="6" class="bal">
<input type="hidden" name="pending_amount_doc" id ="pending_amount_doc" value="<?php echo $pending_amount_doc; ?>" size="6" class="bal">
<input type="hidden" name="entrydate" value="<?php echo $transactiondate; ?>" size="6" class="bal">
<input type="hidden" name="transactionamount" id="transactionamount" value="<?php echo $transactionamount; ?>" size="6" class="bal">
<input type="hidden" name="transactionmode" value="<?php echo $transactionmode; ?>" size="6" class="bal">
<input type="hidden" name="bankname" value="<?php echo $bankname; ?>" size="6" class="bal">
<input type="hidden" name="check_mp_number" value="<?php echo $number; ?>" size="6" class="bal">

<input type="hidden" name="date" value="<?php echo $transactiondate; ?>" size="6" class="bal">



	<td class="bodytext31" valign="center"  align="left"><strong>Doctor Name</strong></td>
	<td class="bodytext31" valign="center"  align="left" colspan="1"><?php echo $docname; ?></td>

	<td class="bodytext31" valign="center"  align="left"><strong>Pending Amount</strong></td>
	<td class="bodytext31" valign="center"  align="left" colspan="1"><b><?php echo number_format($pending_amount_doc,2,'.',','); ?></b></td>
	</tr>
 

	<tr>

	<td class="bodytext31" valign="center"  align="left" width="12%"><strong>Entry Date</strong></td>

	<td class="bodytext31" valign="center"  align="left"><?php echo $transactiondate; ?></td>

	<td class="bodytext31" valign="center"  align="left" width="14%"><strong>Amount</strong></td>

	<td class="bodytext31" valign="center"  align="left">
		<?php echo number_format($transactionamount,2,'.',','); ?>
	</td>

	<td class="bodytext31" valign="center"  align="left" width="14%"><strong>Transaction Mode</strong></td>

	<td class="bodytext31" valign="center"  align="left"><?php echo $transactionmode; ?></td>



	</tr>




	<tr>

	

	<td class="bodytext31" valign="center"  align="left" width="14%"><strong>Date</strong></td>

	<td class="bodytext31" valign="center"  align="left"><?php echo $transactiondate; ?></td>

	<td class="bodytext31" valign="center"  align="left" width="14%"><strong>Bank Name</strong></td>

	<td class="bodytext31" valign="center"  align="left"><?php echo $bankname; ?></td>

	<td class="bodytext31" valign="center"  align="left" width="12%"><strong><?=$name_chq_mpesa;?></strong></td>

	<td class="bodytext31" valign="center"  align="left"><?php echo $number; ?></td>

	</tr>

	<tr>
	<td class="bodytext31" valign="center"  align="left" width="14%"><strong>WHT Amount</strong></td>
	<td class="bodytext31" valign="center"  align="left"><?php echo number_format($whtamount,2,'.',',');  ?></td>
	<td class="bodytext31" valign="center"  align="left" width="14%"><strong>Bank Charges</strong></td>
	<td class="bodytext31" valign="center"  align="left"><?php echo number_format($bankcharges,2,'.',',');  ?></td>
	<td class="bodytext31" valign="center"  align="left" width="12%"><strong>Net Amount</strong></td>
	<td class="bodytext31" valign="center"  align="left"><?php echo number_format($netamount,2,'.',',');  ?></td>

	<!-- <td class="bodytext31" valign="center"  align="left" width="12%"><strong>&nbsp;</strong></td>
	<td class="bodytext31" valign="center"  align="left">&nbsp;</td> -->

	</tr>
	


      <!-- //////////// ALLCOATED INVOICES ////////////////////////// -->
       <tr>
       		<td colspan="6">&nbsp; 
       	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
            <tr>

			 <td colspan="9" bgcolor="#ecf0f5" class="bodytext311"><strong>Allocated Invoices</strong></td>

			 </tr>

           <tr>

                <td width="4%" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><strong>S.No</strong></td>

                <td width="19%" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><strong>Patient</strong></td>

			                <td width="14%"align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bill No</strong></div></td>

                <td width="10%"align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bill Date</strong></div></td>

                <td width="15%"align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Bill Amt</strong></td>

				<td width="14%"align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Adj Amt</strong></td>

				<!-- <td width="20%"align="right" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Bal Amt</strong></td> -->

				  <td width="16%" align="center" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Select</strong></td>

                </tr>

			  <?php 

			  $colorloopcount_adp = 0;

			  $totamount_adp = 0;

            $query2 = "select * from advance_payment_allocation where docno='$docno' and recordstatus='allocated' order by transactiondate ";
			  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $num2_adp = mysqli_num_rows($exec2);
			 // echo $num2;
			  while ($res2 = mysqli_fetch_array($exec2))
			  {
			 	  $billnumber_adp = $res2['billnumber'];
			 	  $auto_number_adp = $res2['auto_number'];

				  $query23 = "select * from advance_payment_allocation where billnumber='$billnumber_adp'";
				  $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				  $res23 = mysqli_fetch_array($exec23);
				  $patientname_adp = $res23['patientname'];
				  $billamount_adp = $res23['transactionamount'];
				  $transactiondate_adp = $res2['transactiondate'];
				  $amount_adp = $res2['transactionamount'];
				  $balanceamount_adp = $res2['balanceamount'];
			  $totamount_adp = $totamount_adp + $amount_adp;


			  $query2_2 = "select description as doctorname,patientname,patientcode,visitcode,accountname,docno as billnumber,recorddate as transactiondate,original_amt,amount,sum(transactionamount) as transactionamount,sum(sharingamount) as transactionamount1,doccoa,visittype from billing_ipprivatedoctor where docno = '$billnumber_adp' and doccoa = '$doccode' group by billnumber,doccoa order by recorddate";
			   $exec2_2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2_2) or die ("Error in Query2_2".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $num2_2 = mysqli_num_rows($exec2_2);
			  while ($res2_2 = mysqli_fetch_array($exec2_2))
			  {
			  	 $billamount_adp = $res2_2['transactionamount'];

			  }
 
			  $colorloopcount_adp = $colorloopcount_adp + 1;
			  $showcolor_adp = ($colorloopcount_adp & 1); 
			  $colorcode = '';
				if ($showcolor_adp == 0)
				{
					$colorcode_adp = 'bgcolor="#CBDBFA"';
				}
				else
				{
					$colorcode_adp = 'bgcolor="#ecf0f5"';
				}
			  ?>

              <tr <?php echo $colorcode_adp; ?>>
                <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount_adp; ?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $patientname_adp; ?></td>
                    <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="center"><span class="bodytext32"><?php echo $billnumber_adp; ?></span></div>
                </div></td>
                <input type="hidden" name="billnum2[]" value="<?php echo $billnumber_adp; ?>">
				<!-- <input type="hidden" name="docno_adp" value="<?php echo $docno_adp; ?>"> -->
				<input type="hidden" name="auto_number1[]" value="<?php echo $auto_number_adp; ?>">


				  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="center"><span class="bodytext32"><?php echo $transactiondate_adp; ?></span></div>

                </div></td>

				<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="right"><span class="bodytext32"><?php echo number_format($billamount_adp,2,'.',','); ?></span></div>
                </div></td>
					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="right"><span class="bodytext32"><?php echo number_format($amount_adp,2,'.',','); ?></span></div>

                </div></td><input type="hidden" name="amt" id="amt<?php echo $colorloopcount_adp; ?>">

          <!--  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="right"><span class="bodytext32"><?php echo number_format($balanceamount,2,'.',','); ?></span></div>

                </div></td> -->

                   <td class="bodytext31" valign="center"  align="left">

				  <div align="center"><input type="checkbox" name="acknow_1[]" id="acknow_1<?php echo $colorloopcount_adp; ?>" value="<?php echo $auto_number_adp; ?>" onClick="updatebox1('<?php echo $colorloopcount_adp; ?>','<?php echo $amount_adp; ?>','<?php echo $num2_adp; ?>')"></div></td>

                </tr>

			  <?php

			  }

			  //}

			  ?>

              <tr>

                    				

                     <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				            <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

        

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				  <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

             

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

           	</tr>

			<tr>

			<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><strong>Total</strong>			</td>

			<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input type="text" name="totaladjamt1" id="totaladjamt1" size="7" readonly=""></td>

			<!-- </tr>

			

			<tr> -->

              <td class="bodytext31" align="right" valign="top" colspan="5">

                     <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">

             	  
             	  <input name="Submit2223" type="submit" id="Submit2223" value="Save " onClick="return acknowledgevalid()" accesskey="b" class="button" style="border: 1px solid #001E6A"/>               </td>

            <!-- <td class="bodytext31" align="right" valign="top" colspan="7"><a target="_blank" href="print_supplierremittances.php?docno=<?php echo $docno; ?>"> <img src="images/pdfdownload.jpg" width="30" height="30"></a></td>  -->


		    </tr>
          </tbody>
        </table>
		</form>		
	</td></tr>
	<tr>
        <td>&nbsp;</td>
      </tr>

      <!-- //////////// ALLCOATED INVOICES ////////////////////////// -->

<input type="hidden"  id="billamount_adp2" value="<?php echo $transactionamount; ?>"   >
<form name="cbform1" method="post" action="advancepaymententry_allocation.php" onSubmit="disablebuttonfunc()">

<input type="hidden" name="docnumber" value="<?php echo $docno; ?>"  class="bal">
<input type="hidden" name="docname" value="<?php echo $docname; ?>"  class="bal">
<input type="hidden" name="docode" value="<?php echo $doccode; ?>"  class="bal">
<input type="hidden" name="bankcode" value="<?php echo $bankcode; ?>"  class="bal">
<input type="hidden" name="pending_amount_doc" value="<?php echo $pending_amount_doc; ?>"  class="bal">
<input type="hidden" name="entrydate" value="<?php echo $transactiondate; ?>"  class="bal">
<input type="hidden" name="transactionamount" id="transactionamount" value="<?php echo $transactionamount; ?>"  class="bal">
<input type="hidden" name="transactionmode" value="<?php echo $transactionmode; ?>"  class="bal">
<input type="hidden" name="bankname" value="<?php echo $bankname; ?>"  class="bal">
<input type="hidden" name="check_mp_number" value="<?php echo $number; ?>"  class="bal">

	<tr>
		<td colspan="6">

<?php

	if ($doccode!='')
{

// $docno = $res2['docno'];
// 				  $transactionmode = $res2['transactionmode'];
// 				  $bankcode=$res2['bankcode'];
// 				  $bankname=$res2['bankname'];
// 				  $docname = $res2['ledger_name'];
// 				  $doccode = $res2['ledger_code'];

	$searchsuppliername = $docname;
	if ($searchsuppliername != '')
	{
		 
		$arraysuppliername = trim($docname);
		$arraysuppliercode = $doccode;
		$suppliercode = $doccode;
		
		// $query1 = "select * from master_supplier where suppliercode = '$arraysuppliercode'";
		// $exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		// $res1 = mysql_fetch_array($exec1);
		// $supplieranum = $res1['auto_number'];
		// $openingbalance = $res1['openingbalance'];
		// $cbsuppliername = $arraysuppliername;
		$suppliername = $arraysuppliername;
		// $suppliercode = $arraysuppliercode;
	}
	 
	
	
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
            <tr>
              <!-- <td colspan="3" bgcolor="#ecf0f5" class="bodytext311"><strong><?php echo $suppliername; ?></strong></td> -->
              <td colspan="3" bgcolor="#ecf0f5" class="bodytext311"><strong>Pending Invocies</strong></td>
              <td width="6%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="7%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
			  <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
         <td width="7%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
          <td width="7%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
            </tr>
            <tr>
              <td width="5%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><strong>No.</strong></td>
				  <td width="6%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><strong>Select</strong></td>
              <td width="15%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><strong>Patient</strong></td>
              <td width="5%" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Bill No </strong></div></td>
              <td width="5%" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Bill Date </strong></div></td>
              <td width="5%" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Bill Amt </strong></div></td>
              <td width="5%" class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong> After Bill </strong></div></td>
              <td width="5%" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Paid</strong></div></td>
              <td width="5%" class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Last Pmt </strong></div></td>
              <td width="5%"class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong> After Pmt </strong></div></td>
              <td width="5%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><div align="right"><strong>Pending</strong></div></td>
				  <td width="5%" class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong> Adj Amt</strong></div></td>
              <td width="5%" align="left" valign="center" bordercolor="#f3f3f3" 
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
			$mpesaamount21='';
			$totalnumbr='';
			$totalnumb=0;
			//$cashamount21 = '0.00';
				$cashamount21 = 0;
				//$cardamount21 = '0.00';
				$cardamount21 = 0;
				//$onlineamount21 = '0.00';
				$onlineamount21 = 0;
				//$chequeamount21 = '0.00';
				$chequeamount21 = 0;
				//$tdsamount21 = '0.00';
				$tdsamount21 = 0;
				//$writeoffamount21 = '0.00';
				$writeoffamount21 = 0;
				//$taxamount21 = '0.00';
				$taxamount21 = 0;
				//$totalpayment = '0.00';
				$totalpayment = 0;
				//$netpayment = '0.00';
				$netpayment = 0;
				//$balanceamount = '0.00';
				$balanceamount = 0;
				
				//$billtotalamount = '0.00';
				$billtotalamount = 0;
				//$netpayment = '0.00';
				$netpayment = 0;
				//$balanceamount = '0.00';
				$balanceamount = 0;
				
				//$billstatus = '0.00';
				$billstatus = 0;
			//include("doctorcount.php");
			$number = 0;
			$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$totalpurchase1=0;
			$colorloopcount=0;
			if (isset($_REQUEST["showbilltype"])) { $showbilltype = $_REQUEST["showbilltype"]; } else { $showbilltype = ""; }
			if ($showbilltype == 'All Bills')
			{
				$showbilltype = '';
			}
			
			?>
				
				<!-- Billing Start -->
			<?php
			//$query2 = "select patientname,patientcode,visitcode,accountname,billanum,billnumber,transactiondate from doctorsharing where doctorcode = '$suppliercode' ";
			// $query2 = "select description as doctorname,patientname,patientcode,visitcode,accountname,docno as billnumber,recorddate as transactiondate,original_amt,amount,sum(transactionamount) as transactionamount,sum(sharingamount) as transactionamount1,doccoa,visittype from billing_ipprivatedoctor where doccoa = '$suppliercode' group by billnumber,doccoa order by recorddate";

			$query2 = "
			(select description as doctorname,patientname,patientcode,visitcode as visitcode,accountname,docno as billnumber,recorddate as transactiondate,original_amt as original_amt,amount,sum(transactionamount) as transactionamount,sum(sharingamount) as transactionamount1,doccoa as doccoa,billtype as visittype,docno as docno_c from billing_ipprivatedoctor where doccoa = '$suppliercode' group by billnumber,doccoa order by transactiondate)
				
			union
				(SELECT billingaccountname as doctorname,patientname,patientcode,patientvisitcode as  visitcode,accountname,docno as billnumber,consultationdate as transactiondate, amount as original_amt,amount,sum(amount) as transactionamount,sum(amount) as transactionamount1,billingaccountcode as doccoa,billtype as visittype,ref_no as docno_c  from adhoc_debitnote where billingaccountcode = '$suppliercode' group by billnumber,doccoa order by transactiondate ) 

				order by transactiondate
			";
			//echo $query2;
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowcount2 = mysqli_num_rows($exec2);
			$number123=$rowcount2;
			while ($res2 = mysqli_fetch_array($exec2))
			{
				$suppliername1 = $res2['patientname'];
				$patientcode = $res2['patientcode'];
				$visitcode = $res2['visitcode'];
				//$billautonumber=$res2['billanum'];
				$billnumber = $res2['billnumber'];
				$billdate = $res2['transactiondate'];
				$billdate_transaction = $res2['transactiondate'];
				$suppliername = $res2['accountname'];
				$doctorname=$res2['doctorname'];
				$doccode=$res2['doccoa'];
				//$amount_topay_doc = $res2['amount'];

				//////////new code
				$visittype=$res2['visittype'];
				$docno_c=$res2['docno_c'];
			$visittype='';	
		$typebill='';
		$query21="select * from master_visitentry where visitcode='$visitcode'";
		$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$row21 = mysqli_num_rows($exec21);
			$res21 = mysqli_fetch_array($exec21);
			$typebill = 'OP';
			$visittype=$res21['billtype'];
				if($row21==0){
					$query21="select * from master_ipvisitentry where visitcode='$visitcode'";
		$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$row21 = mysqli_num_rows($exec21);
			$res21 = mysqli_fetch_array($exec21);
			$typebill = 'IP';
			$visittype=$res21['billtype'];
					
				}
				
				if($typebill=='OP') {
				  $amount_topay_doc = $res2['transactionamount'];
				}	else {
				  $amount_topay_doc = $res2['transactionamount1'];
				}
				$name = $res2['patientname'];
				$billtotalamount = $amount_topay_doc;
				//////////new code
				// if($res2['visittype']=='OP')
				//   $amount_topay_doc = $res2['transactionamount'];
				// else
				//   $amount_topay_doc = $res2['transactionamount1'];

				/*$query66="select * from consultation_referal where patientvisitcode='$visitcode'";
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
*/
				
				/*$query67="select * from master_customer where customercode='$patientcode'";
				$exec67=mysql_query($query67);
				$res67=mysql_fetch_array($exec67);
				$firstname=$res67['customername'];
				$lastname=$res67['customerlastname'];
				$name=$firstname.$lastname;*/
				// $name = $res2['patientname'];
				/*$query761="select transactionamount from doctorsharing where billnumber = '$billnumber' and billanum = '$billautonumber' AND visitcode ='$visitcode' ";
				$exec761=mysql_query($query761) or die("Error in query761".mysql_error());
				$res761=mysql_fetch_array($exec761);
				$billtotalamount = $res761['transactionamount'];*/
				//$billtotalamount = $res2['original_amt'];
				//$billtotalamount = $res2['amount'];
				// $billtotalamount = $amount_topay_doc;
				
				$totalpayment =0;
				$netpayment =0;
				$cashamount21 = 0;
				//$cardamount21 = '0.00';
				$cardamount21 = 0;
				$mpesaamount21 = 0;
				$onlineamount21 = 0;
				//$chequeamount21 = '0.00';
				$chequeamount21 = 0;
				//$tdsamount21 = '0.00';
				$tdsamount21 = 0;
				//$writeoffamount21 = '0.00';
				$writeoffamount21 = 0;
				//$taxamount21 = '0.00';
				$taxamount21 = 0;
				
				//$query3 = "select * from master_transactiondoctor where billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = '' and billautonumber='$billautonumber' and acc_status <> 'deallocated'";
				$query3 = "select * from master_transactiondoctor where billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = ''  and acc_status <> 'deallocated' and doctorcode='$doccode'";
				$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
				$numb=mysqli_num_rows($exec3);
				if($numb>0){
				while ($res3 = mysqli_fetch_array($exec3))
				{
					//echo $res3['auto_number'];
					$cashamount1 = $res3['cashamount'];
					$onlineamount1 = $res3['onlineamount'];
					$chequeamount1 = $res3['chequeamount'];
					$cardamount1 = $res3['cardamount'];
					$tdsamount1 = $res3['tdsamount'];
					$mpesaamount1 = $res3['mpesaamount'];
					$writeoffamount1 = $res3['writeoffamount'];
					
					
					$cashamount21 = $cashamount21 + $cashamount1;
					$mpesaamount21 = $mpesaamount21 + $mpesaamount1;
					$cardamount21 = $cardamount21 + $cardamount1;
					$onlineamount21 = $onlineamount21 + $onlineamount1;
					$chequeamount21 = $chequeamount21 + $chequeamount1;
					$tdsamount21 = $tdsamount21 + $tdsamount1;
					$writeoffamount21 = $writeoffamount21 + $writeoffamount1;
					
				}
				}else
				{
					$cashamount21 = 0;
					$mpesaamount21 = 0;
					$cardamount21 = 0;
					$onlineamount21 = 0;
					$chequeamount21 = 0;
					$tdsamount21 = 0;
					$writeoffamount21 = 0;
				}
			
				$totalpayment = $cashamount21 + $chequeamount21 + $onlineamount21 + $cardamount21+$mpesaamount21;
				$netpayment1 = $totalpayment + $tdsamount21 + $writeoffamount21;

				 ///////////// CASH REFUNDS/////////////
				 $query234 = "SELECT sum(sharingamount) as sharingamount, sum(transactionamount) as transactionamount, docno, percentage, pvtdr_percentage, visittype FROM `billing_ipprivatedoctor_refund` WHERE doccoa='$suppliercode'  AND `visitcode` =  '$visitcode' and against_refbill='$billnumber' group by docno, visitcode ";
		  $exec234 = mysqli_query($GLOBALS["___mysqli_ston"], $query234) or die ("Error in Query234".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num234=mysqli_num_rows($exec234);
			// while($res234 = mysql_fetch_array($exec234)){
		  $res234 = mysqli_fetch_array($exec234);
		  $ref_doc = $res234['docno'];
		  $res45vistype = $res234['visittype'];
		  $res45transactionamount = $res234['sharingamount'];
		  if($res45vistype == "OP")
		  {
			$res45doctorperecentage = $res234['percentage'];
			 $res45transactionamount = $res234['transactionamount'];
		  }
		  else
		  {
			$res45doctorperecentage = $res234['pvtdr_percentage'];
		  }
		 // }
         ///////////// CASH REFUNDS/////////////
		  ///credit_note 
		$credit_amount=0;
		$query23 = "SELECT sum(amount) as amount FROM `adhoc_creditnote` WHERE ref_no='$billnumber'  AND `patientvisitcode` =  '$visitcode' and  billingaccountcode = '$doccode' ";
		$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num23=mysqli_num_rows($exec23);
		$res23= mysqli_fetch_array($exec23);
	    $credit_amount = $res23['amount'];
				              ////////////////// from allocation of ADJUST PAYMENT ENTRIES//
								$query_adp = "SELECT sum(transactionamount) as transactionamount FROM `advance_payment_allocation` WHERE doctorcode='$suppliercode'  AND `visitcode` =  '$visitcode' and billnumber='$billnumber' and recordstatus='allocated' group by billnumber, visitcode order by auto_number desc";
								$exec_adp = mysqli_query($GLOBALS["___mysqli_ston"], $query_adp) or die ("Error in Query_adp".mysqli_error($GLOBALS["___mysqli_ston"]));
								$num_adp=mysqli_num_rows($exec_adp);
								// while($res_adp = mysql_fetch_array($exec_adp)){
								$res_adp = mysqli_fetch_array($exec_adp);
								$res_adp_transactioamount = $res_adp['transactionamount'];

								$query_adp2 = "SELECT transactionamount, transactiondate,updatedate FROM `advance_payment_allocation` WHERE doctorcode='$suppliercode'  AND `visitcode` =  '$visitcode' and billnumber='$billnumber' and recordstatus='allocated' group by billnumber, visitcode order by auto_number desc limit 1";
								$exec_adp2 = mysqli_query($GLOBALS["___mysqli_ston"], $query_adp2) or die ("Error in Query_adp2".mysqli_error($GLOBALS["___mysqli_ston"]));
								$num_adp2=mysqli_num_rows($exec_adp2);
								// while($res_adp2 = mysql_fetch_array($exec_adp2)){
								$res_adp2 = mysqli_fetch_array($exec_adp2);
								 $res_adp2_transactioamount = $res_adp2['transactionamount'];
								 $res_adp2_transactiondate = $res_adp2['updatedate'];
				              ////////////////// from allocation of ADJUST PAYMENT ENTRIES//

				$balanceamount = $amount_topay_doc - $netpayment1 - $res45transactionamount -$credit_amount - $res_adp_transactioamount;
				
				$netpayment=$netpayment1+$res_adp_transactioamount;

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

			if ($balanceamount != '0.00')
			{
				// FOR PAYLATER
				////fro paylater allocation checking
			
		$query00 = "SELECT * FROM `master_doctor` WHERE doctorcode='$doccode'   ";
		$exec00 = mysqli_query($GLOBALS["___mysqli_ston"], $query00) or die ("Error in Query00".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num00=mysqli_num_rows($exec00);
		$res00= mysqli_fetch_array($exec00);
		$excludeallocation = $res00['excludeallocation'];
			
		   $alloted_status='';
		   
		   if($visittype == 'PAY LATER'  && $excludeallocation=='0' )
		   {
				
			$query27 = "select billbalanceamount from master_transactionpaylater where billnumber='$billnumber' and (recordstatus='allocated') and transactionstatus <> 'onaccount' and acc_flag = '0'  and transactiontype='PAYMENT' order by auto_number desc limit 0,1";
			$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query27".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num2 = mysqli_num_rows($exec27);
					if($num2==0)
					{
						$alloted_status = "No";
					}
					else
					{
						$res27 = mysqli_fetch_array($exec27);
						$transc_amt_bal = $res27['billbalanceamount'];
							if($transc_amt_bal>0 )
							{
								$alloted_status = "Partly";
							}
							else
							{
							$alloted_status = "Fully";
							}
					 }	
						
			}
				
			if($alloted_status=='Fully' || $alloted_status==''){
				// FOR PAYLATER
			$date1 = $date1;
			$date2 = date("Y-m-d");  
			$diff = abs(strtotime($date2) - strtotime($date1));  
			$days = floor($diff / (60*60*24));  
			$daysafterbilldate = $days;
			
			//$query3 = "select * from master_transactiondoctor where billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = '' and billautonumber='$billautonumber' and acc_status <> 'deallocated' order by auto_number desc";
			$query3 = "select * from master_transactiondoctor where billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = ''  and acc_status <> 'deallocated' and doctorcode='$doccode' order by auto_number desc";
			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res31 = mysqli_fetch_array($exec31);
			 $numb1=mysqli_num_rows($exec31);
			 $totalnumb=$totalnumb+$numb1;
			 
			$lastpaymentdate = $res31['transactiondate'];
			

				// $lastpaymentdate = date('d-m-Y',strtotime($lastpaymentdate));
				// $res_adp2_transactiondate = date('d-m-Y',strtotime($res_adp2_transactiondate));
				// $date1=date_create($lastpaymentdate);
				// $date2=date_create($res_adp2_transactiondate);
				// $diff=date_diff($date1,$date2);
				//  $diff->format("%R%a days");

				 $date1 =  strtotime($lastpaymentdate);
				$date2 =  strtotime($res_adp2_transactiondate); // Can use date/string just like strtotime.
				// echo $diff=var_dump($date1 > $date2);
				 if($date1 < $date2){
				 	 $lastpaymentdate=$res_adp2_transactiondate;
				 }
				

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
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">
			  <input type="checkbox" name="ack[]" id="acknow<?php echo $sno; ?>" value="<?php echo $sno; ?>" onClick="updatebox('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number123; ?>')"></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div class="bodytext311"><?php echo $name; ?>(<?php echo $visitcode; ?>)</div></td>
			  <input type="hidden" name="patientcode[]" id="patientcode<?=$sno;?>" value="<?php echo $patientcode; ?>">
			  <input type="hidden" name="visitcode[]" id="visitcode<?=$sno;?>" value="<?php echo $visitcode; ?>">
			  <input type="hidden" name="accountname[]" id="accountname<?=$sno;?>" value="<?php echo $suppliername; ?>">
			  <input type="hidden" name="doctorname[]" value="<?php echo $doctorname; ?>">
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billnumber; ?></div></td>
              <input type="hidden" name="billnum[]" value="<?php echo $billnumber; ?>">
			  <input type="hidden" name="name[]" value="<?php echo $name; ?>">
              <input type="hidden" name="serialno[]" value="<?php echo $sno; ?>">
              <input type="hidden" name="billdate_transaction[]" value="<?php echo $billdate_transaction; ?>">
              <input type="hidden" name="billautonumber[]" value="<?php echo $billautonumber; ?>">
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billdate; ?></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
                <?php if ($billtotalamount != '0.00') echo number_format($billtotalamount,2,'.',','); ?>
              </div></td><input type="hidden" name="billamount" id="bill<?=$sno;?>" value="<?php if ($billtotalamount != '0.00') echo $billtotalamount; ?>">
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left"><div align="right"><?php echo $daysafterbilldate.' Days'; ?></div>
                  <div align="right"></div>
                <div align="right"></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
                <?php if ($netpayment != '0.00') echo number_format($netpayment,2,'.',','); ?>
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
                <?php if ($balanceamount != '0.00') echo  number_format($balanceamount,2,'.',','); ?>
              </div></td>
			      <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">
					<input class="bali" type="text" name="adjamount[]" id="adjamount<?php echo $sno; ?>" size="7" onKeyUp="balancecalc('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number123; ?>')"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" autocomplete='off'>
					</td>
            <td class="bodytext311" valign="center" bordercolor="#f3f3f3"><input type="text" class="bal" name="balamount[]" id="balamount<?php echo $sno; ?>" size="7" readonly></td>
            </tr>
            <?php
				$totalbalance = $totalbalance + $balanceamount;
			} // FOR PAYLATER
				}else{
                  $totalpayment =0;
				$netpayment =0;
				}
				 $credit_amount=0;
				//$cashamount21 = '0.00';
				$cashamount21 = 0;
				//$cardamount21 = '0.00';
				$cardamount21 = 0;
				//$onlineamount21 = '0.00';
				$onlineamount21 = 0;
				//$chequeamount21 = '0.00';
				$chequeamount21 = 0;
				//$tdsamount21 = '0.00';
				$tdsamount21 = 0;
				//$writeoffamount21 = '0.00';
				$writeoffamount21 = 0;
				//$taxamount21 = '0.00';
				$taxamount21 = 0;
				//$totalpayment = '0.00';
				$totalpayment = 0;
				//$netpayment = '0.00';
				$netpayment = 0;
				//$balanceamount = '0.00';
				$balanceamount = 0;
				
				//$billtotalamount = '0.00';
				$billtotalamount = 0;
				//$netpayment = '0.00';
				$netpayment = 0;
				//$balanceamount = '0.00';
				$balanceamount = 0;
				
				//$billstatus = '0.00';
				$billstatus = 0;
			}
			?>
				<!-- Billing End -->
			
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
                bgcolor="#ecf0f5"><div align="right"><strong><?php if ($totalbalance != '') echo number_format($totalbalance,2,'.',','); ?></strong></div></td>
             <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">
				<input type="hidden" name="totcount" id="totcount" value="<?php echo $sno; ?>">
				<input type="text" name="totaladjamt" id="totaladjamt" readonly size="7" class="bal" value="0.00"></td>
             <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
			</tr>

			<tr>
                    <!-- <td  align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td> -->
                     
                    <td colspan="13" align="right" valign="top"  bgcolor="#FFFFFF"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                      <!-- <input type="hidden" name="cbfrmflag2" value="<?php echo $supplieranum; ?>"> -->
                      <input type="hidden" name="frmflag2" value="frmflag2">
                      <input name="Submit" type="submit"  id="form1button"  value="Save Payment" class="button" onClick="return amountcheck()"  style="border: 1px solid #001E6A"/>
                      <!-- onClick="return amountcheck()" -->
                    </font></td>
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
	
 
  
</tbody>
</table>
</form>
</td>
</tr>
</table>
</td>
</tr>
</table>



<?php include ("includes/footer1.php"); ?>

</body>

</html>



