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
$docnum = $_REQUEST['docno'];

foreach($_POST['billnum2'] as $key => $value)
		{
		$billnum2=$_POST['billnum2'][$key];
		
		foreach($_POST['acknow1'] as $check1)
		{
		$acknow1=$check1;
		
		if($acknow1==$billnum2)
		{
		 $query8="update master_transactionpharmacy set recordstatus = 'deallocated' where docno='$docnum' and billnumber='$billnum2'";
		$exec8=mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		}
		}
		}
header("location:supplierentry.php?docno=$docnum");
exit;
}

if (isset($_REQUEST["frmflag23"])) { $frmflag23 = $_REQUEST["frmflag23"]; } else { $frmflag23 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if ($frmflag23 == 'frmflag23')
{

$docnum1 = $_REQUEST['docno1'];
$date1 = $_REQUEST['date1'];
$bankname = $_REQUEST['bankname1'];
$number1 = $_REQUEST['number1'];
$paymentmode = $_REQUEST['paymentmode'];
$payableamount = $_REQUEST['payableamount1'];
$suppliername = $_REQUEST['suppliername'];
$paymentmode=str_replace(',', '', $paymentmode);
$payableamount=str_replace(',', '', $payableamount);
$query55 = "select * from master_accountname where accountname='$suppliername'";
$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res55 = mysqli_fetch_array($exec55);
$suppliercode = $res55['id'];
$suppliersubanum = $res55['accountssub'];

$query551 = "select * from master_accountssub where auto_number='$suppliersubanum'";
$exec551 = mysqli_query($GLOBALS["___mysqli_ston"], $query551) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res551 = mysqli_fetch_array($exec551);
$supplieranum = $res551['id'];


foreach($_POST['billnum'] as $key => $value)
		{
		$billnum=$_POST['billnum'][$key];
				//echo $doctorname;
		$balamount=$_POST['balamount'][$key];
		$balamount=str_replace(',', '', $balamount);
		//echo $balamount;
		if($balamount == 0.00)
		{
		$billstatus='paid';
		}
		else
		{
		$billstatus='unpaid';
		}
		//echo $billstatus;
		$adjamount=$_POST['adjamount'][$key];
		$adjamount=str_replace(',', '', $adjamount);
		foreach($_POST['ack'] as $check)
		{
		$acknow=$check;
		if($acknow==$billnum)
		{
	
		$query87 ="select * from master_transactionpharmacy where billnumber='$billnum' and transactiontype='PAYMENT' and docno='$docnum1' and recordstatus = 'allocated'";
		$exec87 = mysqli_query($GLOBALS["___mysqli_ston"], $query87) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num87 = mysqli_num_rows($exec87);
		if($num87 ==0)
		{
		
		if($adjamount != 0)
		{
		$transactionmodule = '';
		if ($paymentmode == 'CASH')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CASH';
		$particulars = 'BY CASH '.$billnumberprefix.$billnumber.'';	
		
		$query9 = "insert into master_transactionpharmacy (transactiondate, particulars, supplieranum, suppliername, 
		transactionmode, transactiontype, transactionamount, cashamount,taxamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule, approvalstatus,docno,suppliercode,recordstatus) 
		values ( '$transactiondateto', '$particulars', '$supplieranum', '$suppliername', 
		'$transactionmode', '$transactiontype', '$adjamount', '$adjamount', '$taxamount',
		'$billnum',  '$billanum', '$ipaddress', '$updatedate', '$balamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule', '$approvalstatus','$docnum1','$suppliercode','allocated')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		if ($paymentmode == 'ONLINE')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'ONLINE';
		$particulars = 'BY ONLINE '.$billnumberprefix.$billnumber.'';	
	
		$query9 = "insert into master_transactionpharmacy (transactiondate, particulars, supplieranum, suppliername, 
		transactionmode, transactiontype, transactionamount, onlineamount,taxamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule, approvalstatus,docno,suppliercode,recordstatus,bankname) 
		values ('$transactiondateto', '$particulars', '$supplieranum', '$suppliername', 
		'$transactionmode', '$transactiontype', '$adjamount', '$adjamount', '$taxamount',
		'$billnum',  '$billanum', '$ipaddress', '$updatedate', '$balamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule', '$approvalstatus','$docnum1','$suppliercode','allocated','$bankname')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

		}
		if ($paymentmode == 'CHEQUE')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CHEQUE';
		$particulars = 'BY CHEQUE '.$billnumberprefix.$billnumber;		
	
		$query9 = "insert into master_transactionpharmacy (transactiondate, particulars, supplieranum, suppliername, 
		transactionmode, transactiontype, transactionamount,
		chequeamount,taxamount,chequenumber, billnumber, billanum, 
		chequedate, bankname, bankbranch, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule, approvalstatus,docno,suppliercode,recordstatus) 
		values ('$transactiondateto', '$particulars', '$supplieranum', '$suppliername', 
		'$transactionmode', '$transactiontype', '$adjamount',
		'$adjamount', '$taxamount','$chequenumber',  '$billnum',  '$billanum', 
		'$chequedate', '$bankname', '$bankbranch','$ipaddress', '$updatedate', '$balamount', '$companyanum', '$companyname', 
		'$remarks', '$transactionmodule', '$approvalstatus','$docnum1','$suppliercode','allocated')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
	
		}
		if ($paymentmode == 'WRITEOFF')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'WRITEOFF';
		$particulars = 'BY WRITEOFF '.$billnumberprefix.$billnumber;		
		
		$query9 = "insert into master_transactionpharmacy (transactiondate, particulars, supplieranum, suppliername, 
		transactionmode, transactiontype, transactionamount, writeoffamount,taxamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule, approvalstatus,suppliercode,recordstatus) 
		values ('$transactiondateto', '$particulars', '$supplieranum', '$suppliername', 
		'$transactionmode', '$transactiontype', '$adjamount', '$adjamount', '$taxamount',
		'$billnum',  '$billanum', '$ipaddress', '$updatedate', '$balamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule', '$approvalstatus','$suppliercode','allocated')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

		}
		
		}
		}
		else
		{
		$totalaadjamount =0;
		$query67 = "select * from master_transactionpharmacy where billnumber='$billnum' and transactiontype='PAYMENT' and docno='$docnum1'";
		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res67 = mysqli_fetch_array($exec67))
		{
		$existingamt = $res67['transactionamount'];
		$totalaadjamount = $totalaadjamount + $existingamt;
		}
		$restotalaadjamount = $totalaadjamount + $adjamount;
		if ($paymentmode == 'CASH')
		{
		$query45 = "update master_transactionpharmacy set recordstatus='allocated',transactionamount='$restotalaadjamount',cashamount='$restotalaadjamount',balanceamount='$balamount',transactiondate='$updatedatetime' where billnumber='$billnum' and transactiontype='PAYMENT' and docno='$docnum1'";
		$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		
		if ($paymentmode == 'ONLINE')
		{
		$query45 = "update master_transactionpharmacy set recordstatus='allocated',transactionamount='$restotalaadjamount',onlineamount='$restotalaadjamount',balanceamount='$balamount',transactiondate='$updatedatetime' where billnumber='$billnum' and transactiontype='PAYMENT' and docno='$docnum1'";
		$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    	}
		if ($paymentmode == 'CHEQUE')
		{
		$query45 = "update master_transactionpharmacy set recordstatus='allocated',transactionamount='$restotalaadjamount',chequeamount='$restotalaadjamount',balanceamount='$balamount',transactiondate='$updatedatetime' where billnumber='$billnum' and transactiontype='PAYMENT' and docno='$docnum1'";
		$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    
		}
		if ($paymentmode == 'WRITEOFF')
		{
		$query45 = "update master_transactionpharmacy set recordstatus='allocated',transactionamount='$restotalaadjamount',writeoffamount='$restotalaadjamount',balanceamount='$balamount',transactiondate='$updatedatetime' where billnumber='$billnum' and transactiontype='PAYMENT' and docno='$docnum1'";
		$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    	
		}
		
		}
	}
	}
	}
	header("location:supplierentry.php?docno=$docnum1");
	exit;
}

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
$docno = $_REQUEST['docno'];
}
$totalamount=0;
$query5="select * from master_transactionpharmacy where docno='$docno'";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res5 = mysqli_fetch_array($exec5);
$entrydate = $res5['transactiondate'];

$query51="select sum(transactionamount) as transactionamount from paymentmodecredit where billnumber='$docno'";
$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res51 = mysqli_fetch_array($exec51);
$totalamount = $res51['transactionamount'];
	  
$payableamount = $totalamount;
$paymentmode = $res5['transactionmode'];

$number = $res5['chequenumber'];
$date = $res5['chequedate'];
$bankname = $res5['bankname'];
$suppliername = $res5['suppliername'];
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

function disablebuttonfunc()
{
	
	document.getElementById("Submit2223").disabled=true;
		
}

function validcheck()
{
if(confirm("Do You Want To Save The Record? ")==false) {return false;}	
}

function updatebox1(varSerialNumber6,billamt6,totalcount6)
{

var grandtotalamt = 0;
var varSerialNumber6 = varSerialNumber6;
var totalcount6=totalcount6;
var billamt6 = billamt6;
  
  document.getElementById("amt"+varSerialNumber6+"").value='';
if(document.getElementById("acknow1"+varSerialNumber6+"").checked == true)
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
//alert(totalcount1);
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

function updatebox(varSerialNumber,billamt,totalcount1)
{

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
	if(balanceamt == 0.00)
	{
	balanceamt=0;
	}
	
	document.getElementById("balamount"+varSerialNumber+"").value=balanceamt.toFixed(2);
	
	var totalbillamt=document.getElementById("totaladjamt").value;
	
	if(totalbillamt == 0.00)
{
totalbillamt=0;
}
				totalbillamt=parseFloat(totalbillamt)+parseFloat(billamt);

document.getElementById("totaladjamt").value = totalbillamt.toFixed(2);

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
grandtotaladjamt2 = grandtotaladjamt2.toFixed(2);
grandtotaladjamt2 = grandtotaladjamt2.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
document.getElementById("totaladjamt").value=grandtotaladjamt2;
return false;

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

document.getElementById("totaladjamt").value=grandtotaladjamt2.toFixed(2);

 }  
}

function totalamountcheck(totalcount7,grandtotalamt1)
{
	document.getElementById('Submit001').disabled =true;
var totalcount7=totalcount7;
var grandtotalamt1=grandtotalamt1;

var checkamount= document.getElementById("totaladjamt").value;
var receivableamount = document.getElementById("payableamount").value;
checkamount = checkamount.replace(/,/g,'');
receivableamount = receivableamount.replace(/,/g,'');
//alert(receivableamount);
//alert(checkamount);
if(checkamount == 0.00)
{
alert("Adjustable amount cannot be Zero");

	document.getElementById('Submit001').disabled =false;
return false;
}
if(parseFloat(checkamount) > parseFloat(receivableamount))
{
alert("Allocated amount is greater than Receivable amount");

	document.getElementById('Submit001').disabled =false;
return false;
}
var checkamount2 = parseInt(checkamount) + parseInt(grandtotalamt1);
var checkamount1= document.getElementById("payableamount").value;
if(parseInt(checkamount2) > parseInt(checkamount1))
{
alert("Allocated amount is greater than Payable amount");

	document.getElementById('Submit001').disabled =false;
return false;

}
return true;
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
function balancecalc(varSerialNumber1,billamt1,totalcount)
{
var varSerialNumber1 = varSerialNumber1;
var billamt1 = billamt1;
var totalcount=totalcount;
var grandtotaladjamt=0;

var adjamount=document.getElementById("adjamount"+varSerialNumber1+"").value;
var adjamount3=parseFloat(adjamount);
adjamount3 = adjamount3.replace(/,/g,'');
billamt1 = billamt1.replace(/,/g,'');
if(parseFloat(adjamount3) > parseFloat(billamt1))
{
alert("Please enter correct amount");
document.getElementById("totaladjamt").value = '0.00';
document.getElementById("adjamount"+varSerialNumber1+"").value = '0.00';
document.getElementById("balamount"+varSerialNumber1+"").value = billamt1;
document.getElementById("adjamount"+varSerialNumber1+"").focus();
return false;
}
var balanceamount=parseFloat(billamt1)-parseFloat(adjamount);

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
grandtotaladjamt = grandtotaladjamt.toFixed(2);
grandtotaladjamt = grandtotaladjamt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

document.getElementById("totaladjamt").value=grandtotaladjamt;

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
document.getElementById("totaladjamt").value=grandtotaladjamt;

}

</script>
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


function funcPrintReceipt1()
{
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
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
		
		
              <form name="cbform1" method="post" action="supplierentry.php" onSubmit="disablebuttonfunc()">
			<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="709" 
            align="left" border="0">
          <tbody>
		  
		  <tr>
	<td class="bodytext31" valign="center"  align="left" width="12%"><strong>DOC No
	  
	</strong></td>
	<td class="bodytext31" valign="center"  align="left"><input type="hidden" name="docnumbers" value="<?php echo $docno; ?>" size="6" class="bal"><?php echo $docno; ?></td>
	
	<td class="bodytext31" valign="center"  align="left"><strong>Supplier Name</strong></td>
	<td class="bodytext31" valign="center"  align="left" colspan="4"><?php echo $suppliername; ?></td>
	</tr>
	<tr>
	<td class="bodytext31" valign="center"  align="left" width="12%"><strong>Entry Date</strong></td>
	<td class="bodytext31" valign="center"  align="left"><input type="hidden" name="entrydate" value="<?php echo $entrydate; ?>" size="6" class="bal"><?php echo $entrydate; ?></td>
	<td class="bodytext31" valign="center"  align="left" width="14%"><strong>Amount</strong></td>
	<td class="bodytext31" valign="center"  align="left"><input type="hidden" name="payableamount" id="payableamount" value="<?php echo $payableamount; ?>" size="6" class="bal"><?php echo number_format($payableamount,2,'.',','); ?></td>
	<td class="bodytext31" valign="center"  align="left" width="14%"><strong>Payment Mode</strong></td>
	<td class="bodytext31" valign="center"  align="left"><input type="hidden" name="paymentmode" value="<?php echo $paymentmode; ?>" size="6" class="bal"><?php echo $paymentmode; ?></td>

	</tr>
	<tr>
	<td class="bodytext31" valign="center"  align="left" width="12%"><strong>Number</strong></td>
	<td class="bodytext31" valign="center"  align="left"><input type="hidden" name="number" value="<?php echo $number; ?>" size="6" class="bal"><?php echo $number; ?></td>
	<td class="bodytext31" valign="center"  align="left" width="14%"><strong>Date</strong></td>
	<td class="bodytext31" valign="center"  align="left"><input type="hidden" name="date" value="<?php echo $date; ?>" size="6" class="bal"><?php echo $date; ?></td>
	<td class="bodytext31" valign="center"  align="left" width="14%"><strong>Bank Name</strong></td>
	<td class="bodytext31" valign="center"  align="left"><input type="hidden" name="bankname" value="<?php echo $bankname; ?>" size="6" class="bal"><?php echo $bankname; ?></td>

	</tr>
	
             <tr>
			 <td colspan="7" bgcolor="#ecf0f5" class="bodytext311"><strong>Allocated Invoices</strong></td>
			 </tr>
           <tr>
                <td width="12%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>S.No</strong></td>
			                <td width="14%"align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bill No</strong></div></td>
                <td width="10%"align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bill Date</strong></div></td>
                <td width="15%"align="center" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Bill Amt</strong></td>
				<td width="14%"align="center" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Adj Amt</strong></td>
				<td width="20%"align="center" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Bal Amt</strong></td>
				  <td width="16%" align="center" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Select</strong></td>
                </tr>
			  <?php 
			  $colorloopcount = 0;
			  $totamount = 0;
            $query2 = "select * from master_transactionpharmacy where docno='$docno' and recordstatus='allocated'";
			  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $num2 = mysqli_num_rows($exec2);
			 // echo $num2;
			  while ($res2 = mysqli_fetch_array($exec2))
			  {
			 	  $billnumber = $res2['billnumber'];
				
				  
				  $query23 = "select * from master_transactionpharmacy where billnumber='$billnumber' and transactiontype='PURCHASE'";
				  $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				  $res23 = mysqli_fetch_array($exec23);
				  $billamount = $res23['transactionamount'];
				  $transactiondate = $res2['transactiondate'];
				  $amount = $res2['transactionamount'];
				  $balanceamount = $res2['balanceamount'];
			  $totamount = $totamount + $amount;
			  
			  //$query3 = "select * from master_patientadmission where patientcode = '$res2customercode' order by auto_number desc limit 0, 1";
			  //$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
			  //$res3 = mysql_fetch_array($exec3);
			  //$res3ipnumber = $res3['ipnumber'];
			  
			  
			  $colorloopcount = $colorloopcount + 1;
			  $showcolor = ($colorloopcount & 1); 
			  $colorcode = '';
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
                <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
              
                    <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="center"><span class="bodytext32"><?php echo $billnumber; ?></span></div>
                </div></td><input type="hidden" name="billnum2[]" value="<?php echo $billnumber; ?>">
				<input type="hidden" name="docno" value="<?php echo $docno; ?>">
				  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="center"><span class="bodytext32"><?php echo $transactiondate; ?></span></div>
                </div></td>
				<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="right"><span class="bodytext32"><?php echo number_format($billamount,2,'.',','); ?></span></div>
                </div></td>
					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="right"><span class="bodytext32"><?php echo number_format($amount,2,'.',','); ?></span></div>
                </div></td><input type="hidden" name="amt" id="amt<?php echo $colorloopcount; ?>">
           <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="right"><span class="bodytext32"><?php echo number_format($balanceamount,2,'.',','); ?></span></div>
                </div></td>
                   <td class="bodytext31" valign="center"  align="left">
				  <div align="center"><input type="checkbox" name="acknow1[]" id="acknow1<?php echo $colorloopcount; ?>" value="<?php echo $billnumber; ?>" onClick="updatebox1('<?php echo $colorloopcount; ?>','<?php echo $amount; ?>','<?php echo $num2; ?>')"></div></td>
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
			<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input type="text" name="totaladjamt1" id="totaladjamt1" size="7"></td>
			</tr>
			
			<tr>
              <td class="bodytext31" align="right" valign="top" colspan="7">
                     <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
             	  <input name="Submit2223" type="submit" id="Submit2223" value="Save " onClick="return acknowledgevalid()" accesskey="b" class="button" style="border: 1px solid #001E6A"/>               </td>
            <td class="bodytext31" align="right" valign="top" colspan="7"><a target="_blank" href="print_supplierremittances.php?docno=<?php echo $docno; ?>"> <img src="images/pdfdownload.jpg" width="30" height="30"></a></td> 
                                
		    </tr>
          </tbody>
        </table>
		</form>		</td></tr>
	  <tr>
	  <td>
	  <form action="supplierentry.php" method="post"  onSubmit="return validcheck()">
	  <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
            <tr>
              <td colspan="3" bgcolor="#ecf0f5" class="bodytext311"><strong><?php echo $suppliername; ?></strong></td>
			   <input type="hidden" name="suppliername" value="<?php echo $suppliername; ?>" size="6" class="bal">
			    <input type="hidden" name="paymentmode" value="<?php echo $paymentmode; ?>" size="6" class="bal">
			    <input type="hidden" name="docno1" value="<?php echo $docno; ?>">
			  <input type="hidden" name="paymentmode1" value="<?php echo $paymentmode; ?>" size="6" class="bal">
			  <input type="hidden" name="date1" value="<?php echo $date; ?>" size="6" class="bal">
			  <input type="hidden" name="number1" value="<?php echo $number; ?>" size="6" class="bal">
			  <input type="hidden" name="bankname1" value="<?php echo $bankname; ?>" size="6" class="bal">
			  <input type="hidden" name="payableamount1" id="payableamount" value="<?php echo $payableamount; ?>" size="6" class="bal">

              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
			  <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
         <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
          <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
            </tr>
            <tr>
              <td width="5%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><strong>No.</strong></td>
				  <td width="6%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><strong>Select</strong></td>
              <td width="9%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><strong> Supplier Inv No</strong></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Doc No </strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Bill Date </strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Bill Amt </strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong> After Bill </strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Paid</strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Last Pmt </strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong> After Pmt </strong></div></td>
              <td width="8%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><div align="right"><strong>Pending</strong></div></td>
				  <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong> Adj Amt</strong></div></td>
              <td width="8%" align="left" valign="center" bordercolor="#f3f3f3" 
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
			$taxamount21 = '';
			$totalnumbr='';
			$totalnumb=0;
			$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$totalpurchase1=0;
			$ss=0;
			if (isset($_REQUEST["showbilltype"])) { $showbilltype = $_REQUEST["showbilltype"]; } else { $showbilltype = ""; }
			if ($showbilltype == 'All Bills')
			{
				$showbilltype = '';
			}			
	include("rowcount.php");
			 //echo $number=mysql_num_rows($exec25);
							$query2 = "select suppliername,billnumber,supplierbillnumber,billnumberprefix,billnumberpostfix,billdate,sum(totalamount) as totalamount from master_purchase where suppliername like '%$suppliername%' and recordstatus <> 'deleted' and companyanum = '$companyanum' group by billnumber";
			//$query2 = "select * from master_transaction where transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and transactionmodule = 'SALES' and billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = ''";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowcount2 = mysqli_num_rows($exec2);
			
			while ($res2 = mysqli_fetch_array($exec2))
			{
				$suppliername = $res2['suppliername'];
				$billnumber = $res2['billnumber'];
				$supplierbillnumber=$res2['supplierbillnumber'];
				$billnumberprefix = $res2['billnumberprefix'];
				$billnumberpostfix = $res2['billnumberpostfix'];
				$billdate = $res2['billdate'];
				$billtotalamount = $res2['totalamount'];
				
				$query44 = "select * from purchase_details where billnumber='$billnumber'";
				$exec44 = mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res44 = mysqli_fetch_array($exec44);
				$ponumber = $res44['ponumber'];
				$subponumber = substr($ponumber,0,1);
				if($subponumber == 'M')
				{
				$query45 = "select * from materialreceiptnote_details where billnumber='$ponumber'";
				$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res45 = mysqli_fetch_array($exec45);
				$ponumber = $res45['ponumber'];
				}
				
	
				$query3 = "select * from master_transactionpharmacy where transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and billnumber = '$billnumber' and recordstatus = 'allocated'";
				$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num=mysqli_num_rows($exec3);
				$drnotetotal=0;
				while ($res3 = mysqli_fetch_array($exec3))
				{
					//echo $res3['auto_number'];
				    $cashamount1 = $res3['cashamount'];
					$onlineamount1 = $res3['onlineamount'];
					$chequeamount1 = $res3['chequeamount'];
					$cardamount1 = $res3['cardamount'];
					$tdsamount1 = $res3['tdsamount'];
					$writeoffamount1 = $res3['writeoffamount'];
					$taxamount1 = $res3['taxamount'];

					if(strpos($res3['docno'], 'SDBT-') !== false)
						$drnote = $res3['transactionamount'];
					else
						$drnote =0;

					
					$cashamount21 = $cashamount21 + $cashamount1;
					$cardamount21 = $cardamount21 + $cardamount1;
					$onlineamount21 = $onlineamount21 + $onlineamount1;
					$chequeamount21 = $chequeamount21 + $chequeamount1;
					$tdsamount21 = $tdsamount21 + $tdsamount1;
					$writeoffamount21 = $writeoffamount21 + $writeoffamount1;
					$taxamount21 = $taxamount21 + $taxamount1;
					
                    $drnotetotal=$drnotetotal+$drnote;
					
				}
			    $billtotalamount=$billtotalamount-$drnotetotal;
			    $totalpayment = $cashamount21 + $chequeamount21 + $onlineamount21 + $cardamount21 + $taxamount21;
				$netpayment = $totalpayment + $tdsamount21 + $writeoffamount21;


				$balanceamount = $billtotalamount - $netpayment;
				
				$billtotalamount = number_format($billtotalamount, 2, '.', '');
				$netpayment = number_format($netpayment, 2, '.', '');
				$balanceamount = number_format($balanceamount, 2, '.', '');
				
				$billstatus = $billtotalamount.'||'.$netpayment.'||'.$balanceamount;

			//echo $balanceamount;
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
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $sno = $sno + 1; ?><?php $ss = $ss + 1; ?></td>
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">
			  <input type="checkbox" name="ack[]" id="acknow<?php echo $sno; ?>" value="<?php echo $billnumber; ?>" onClick="updatebox('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div class="bodytext311"><?php echo $supplierbillnumber; ?> , <?php echo $ponumber; ?></div></td>
			  <input type="hidden" name="supplierbillnumber[]" value="<?php echo $supplierbillnumber; ?>">
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billnumberprefix.$billnumber.$billnumberpostfix; ?></div></td>
              <input type="hidden" name="billnum[]" value="<?php echo $billnumber; ?>">
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billdate; ?></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
                <?php if ($billtotalamount != '0.00') echo number_format($billtotalamount,2,'.',','); //echo number_format($billtotalamount, 2); ?>
              </div></td><input type="hidden" name="billamount" id="bill" value="<?php if ($billtotalamount != '0.00') echo $billtotalamount; ?>">
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left"><div align="right"><?php echo $daysafterbilldate.' Days'; ?></div>
                  <div align="right"></div>
                <div align="right"></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
                <?php if ($netpayment != '0.00') echo number_format($netpayment,2,'.',','); //echo number_format($netpayment, 2); ?>
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
                <?php if ($balanceamount != '0.00') echo number_format($balanceamount,2,'.',','); //echo number_format($balanceamount, 2); ?>
              </div></td>
			      <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input class="bali" type="text" name="adjamount[]" id="adjamount<?php echo $sno; ?>" size="7"  onClick="checkboxcheck('<?php echo $sno; ?>')" onKeyUp="balancecalc('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
            <td class="bodytext311" valign="center" bordercolor="#f3f3f3"><input type="text" class="bal" name="balamount[]" id="balamount<?php echo $sno; ?>" value="" size="7" readonly></td>
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
				$taxamount21 = '0.00';

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
                bgcolor="#ecf0f5"><div align="right"><strong><?php if ($totalbalance != '') echo number_format($totalbalance, 2, '.', ','); ?></strong></div></td>
             <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5"><input type="text" name="totaladjamt" id="totaladjamt" size="7" class="bal"></td>
             <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
			</tr>
          </tbody>
        </table>
	  
	  
	  <tr>
	  <td>&nbsp;	  </td>
	  </tr>
	  <tr>
	  <td width="709"align="right" valign="top"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                      
                      <input type="hidden" name="frmflag23" value="frmflag23">
                      <input name="Submit" type="submit" id="Submit001"  value="Save" class="button" onClick="return totalamountcheck('<?php echo $num2; ?>','<?php echo $totamount; ?>');"style="border: 1px solid #001E6A"/>
        </font></td>
	  </tr>
	 
	  </table>
	
	</td>
	</tr>
  </table>
  
<?php include ("includes/footer1.php"); ?>
</body>
</html>

