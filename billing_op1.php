<?php
session_start();

//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$username = $_SESSION['username'];
$updatedatetime = date('Y-m-d H:i:s');
$billdatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$pagename = "";
$patientlessedamount = '';
$patientpayment = '';
$billamountpatient = '';
$percentageamount = '';
$percentagebalanceamount = '';
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	$patientcode = $_REQUEST["patientcode"];
	$visitcode = $_REQUEST["visitcode"];
	$patientfirstname = $_REQUEST['patientfirstname'];
	$patientmiddlename=$_REQUEST['patientmiddlename'];
	$patientlastname = $_REQUEST["patientlastname"];
	$billnumbercode = $_REQUEST['billnumbercode'];
	//echo $billnumbercode;
	$consultationtype = $_REQUEST["consultationtype"];
	$billingdatetime  = $_REQUEST["billingdatetime"];
	$consultingdoctor = $_REQUEST["consultingdoctor"];
	$accountname = $_REQUEST["accountname"];
	$accountexpirydate = $_REQUEST["accountexpirydate"];
	$paymenttype = $_REQUEST["paymenttype"];
	$subtype = $_REQUEST["subtype"];
	$planname = $_REQUEST["planname"];
	$fixedamountbalance = $_REQUEST["fixedamountbalance"];
	$planexpirydate = $_REQUEST["planexpirydate"];
	$visitlimit = $_REQUEST["visitlimit"];
	$overalllimit = $_REQUEST["overalllimit"];
	$billtype = $_REQUEST['billingtype'];
	$billamount  = $_REQUEST["billamount"];
	$consultationremarks = $_REQUEST["consultationremarks"];
	$billentryby = $_REQUEST["billentryby"];
	$visitcount = $_REQUEST['visittype'];
	$patientpaymentmode = $_REQUEST['patientpaymentmode'];
	$patientbillamount = $_REQUEST['patientbillamount'];
	$department = $_REQUEST['department'];
	$consultationdate = $_REQUEST['consultationdate'];
	$consultationtime = $_REQUEST['consultationtime'];
	$consultationfees = $_REQUEST['consultationfees'];
	$referredby = $_REQUEST['referredby'];
	
	$subtotalamount = $_REQUEST['subtotalamount'];
	$copayfixedamount = $_REQUEST['copayfixedamount'];
	$copaypercentageamount = $_REQUEST['copaypercentageamount'];
	$totalamountbeforediscount = $_REQUEST['totalamountbeforediscount'];
	$discountamount = $_REQUEST['discountamount'];
	$totalamount = $_REQUEST['totalamount'];
	
	$recordstatus = '';
	
	 $query2 = "select * from master_billing where billnumber = '$billnumbercode'";
	 $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
     $res2 = mysqli_num_rows($exec2);
	
	if ($res2 == 0)
	{
		$query1 = "insert into master_billing (patientcode, visitcode, patientfirstname,patientmiddlename, patientlastname, billnumber,
		consultationtype, billingdatetime, consultingdoctor,accountname,accountexpirydate,paymenttype,subtype,planname,planexpirydate,visitlimit,
		overalllimit,billtype,billamount,billentryby,consultationremarks,
		ipaddress, username, recordstatus,paymentstatus,visitcount,patientbillamount,patientpaymentmode,department,consultationdate,consultationtime,
		consultationfees,referredby,fixedamountbalance, 
		subtotalamount, copayfixedamount, copaypercentageamount, totalamountbeforediscount, discountamount, totalamount,triagestatus) 
		values('$patientcode','$visitcode','$patientfirstname','$patientmiddlename','$patientlastname','$billnumbercode',
		'$consultationtype', '$billingdatetime', '$consultingdoctor','$accountname','$accountexpirydate','$paymenttype','$subtype','$planname','$planexpirydate','$visitlimit',
		'$overalllimit','$billtype','$billamount', '$billentryby','$consultationremarks',  
		'$ipaddress','$username','$recordstatus','completed','$visitcount','$patientbillamount','$patientpaymentmode','$department','$consultationdate','$consultationtime',
		'$consultationfees','$referredby','$fixedamountbalance', 
		'$subtotalamount', '$copayfixedamount', '$copaypercentageamount', '$totalamountbeforediscount', '$discountamount', '$totalamount','pending')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		
		$query22 = "update master_visitentry set paymentstatus = 'completed' where visitcode = '$visitcode' and patientcode = '$patientcode' ";
		$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		
		
		$query3 = "select * from master_billing where patientcode = '$patientcode' and billingdatetime = '$billingdatetime'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res3 = mysqli_fetch_array($exec3);
		$res3billanum = $res3['auto_number'];
			
		$patientcode = '';
		$visitcode = '';
		$patientfirstname = '';
		$patientlastname = '';
		$consultationtype = '';
		$billingdatetime = '';
		$consultingdoctor = '';
		$accountname = '';
		$accountexpirydate = '';
		$paymenttype = '';
		$subtype = '';
		$planname = '';
		$planexpirydate = '';
		$visitlimit = '';
		$overalllimit = '';
		$paymenttype = '';
		$paymentmode = '';
		$billtype = '';
		$billamount = '';
		$billentryby = '';
		$consultationremarks = '';
		$visittype = '';	
		
		header("location:billing_pending_op1.php?billautonumber=$res3billanum&&st=success");
		exit;
	}
	else
	{
		header("location:billing_op1.php?patientcode=$patientcode&&st=failed");
	}

}
else
{
	$patientcode = '';
	$visitcode = '';
	$patientfirstname = '';
	$patientlastname = '';
	$billnumber = '';
	$consultationtype = '';
	$billingdatetime = '';
	$consultingdoctor = '';
	$accountname = '';
	$accountexpirydate = '';
	$paymenttype = '';
	$subtype = '';
	$planname = '';
	$planexpirydate = '';
	$visitlimit = '';
	$overalllimit = '';
	$paymenttype = '';
	$paymentmode = '';
	$billtype = '';
	$billamount = '';
	$billentryby = '';
	$consultationremarks = '';
	$visittype = '';
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'success')
{
		$errmsg = "Success. New Visit Updated.";
		if (isset($_REQUEST["cpynum"])) { $cpynum = $_REQUEST["cpynum"]; } else { $cpynum = ""; }
		if ($cpynum == 1) //for first company.
		{
			$errmsg = "Success. New Visit Updated.";
		}
}
else if ($st == 'failed')
{
		$errmsg = "Failed. Visit Code Already Exists.";
}

if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
$query2 = "select * from master_visitentry where visitcode = '$visitcode'";//order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$visitcode = $res2["visitcode"];
$consultingdoctoranum = $res2['consultingdoctor'];

$query21 = "select * from master_doctor where auto_number = '$consultingdoctoranum'";
$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res21 = mysqli_fetch_array($exec21);
$consultingdoctor = $res21['doctorname'];



$accountnameanum = $res2['accountname'];
$query5 = "select * from master_accountname where auto_number = '$accountnameanum'";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res5 = mysqli_fetch_array($exec5);
$accountname = $res5['accountname'];

$accountexpirydate = $res2['accountexpirydate'];
$paymenttypeanum = $res2['paymenttype'];
$query3 = "select * from master_paymenttype where auto_number ='$paymenttypeanum'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 =  mysqli_fetch_array($exec3);
$paymenttype = $res3['paymenttype'];
$subtypeanum = $res2['subtype'];
$query4 = "select * from master_subtype where auto_number = '$subtypeanum'";
$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res4 = mysqli_fetch_array($exec4);
$subtype  = $res4['subtype'];


$plannameanum = $res2['planname'];
$query7 = "select * from master_planname where auto_number = '$plannameanum'";
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res7 = mysqli_fetch_array($exec7);
$planname = $res7['planname'];
$planpercentage = $res7["planpercentage"];
//echo $planpercentage;
$planfixedamount = $res7["planfixedamount"]; 
//echo $planfixedamount ;


$planexpirydate = $res2['planexpirydate'];
$visitlimit = $res2['visitlimit'];
$overalllimit = $res2['overalllimit'];
$departmentanum = $res2['department'];

$query5 = "select * from master_department where auto_number = '$departmentanum'";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res5 = mysqli_fetch_array($exec5);
$department = $res5['department'];

$subtype  = $res4['subtype'];
$consultationdate = $res2["consultationdate"];
$consultationtime  = $res2["consultationtime"];
$consultationfees  = $res2["consultationfees"];
$billamount = $consultationfees;
$billentryby = strtoupper($username);
$referredby = $res2["referredby"];
$paymenttypeanum = $res2["paymenttype"];

$query6 = "select * from master_paymenttype where auto_number = '$paymenttypeanum'";
$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res6 = mysqli_fetch_array($exec6);
$paymenttype = $res6['paymenttype'];


$consultationremarks = $res2["consultationremarks"];
$complaint = $res2["complaint"];
$billtype = $res2["billtype"];
$visittype = $res2['visittype'];
$consultationtype = $res2['consultationtype'];
$visitcount = $res2["visitcount"];


if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
$query3 = "select * from master_customer where customercode = '$patientcode'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$patientfirstname = $res3['customername'];
$patientmiddlename=$res3['customermiddlename'];
$patientlastname = $res3['customerlastname'];

if($billtype == 'PAY NOW')
{
	$billamountpatient = $billamount;
}


if($planfixedamount != 0)
{
	if($planfixedamount >= $billamount)
	{
		 $billamountpatient =  $billamount ;
		
	}
	else 
	{
		 $billamountpatient = $planfixedamount;
		 
	}
}

if($planpercentage != 0)
{
	//echo "hi";
	$percentageamount = $planpercentage /100;
	$percentagebalanceamount = $billamount * $percentageamount ;
	$billamountpatient = $percentagebalanceamount;
}

//$consultationdate = date('Y-m-d');
//$consultationtime = date('H:i');
//$consultationfees = '500';

//bill number for bill save.
//$query2 = "select max(billnumber) as maxbillnumber from master_billing where companyanum = '$companyanum' and financialyear = '$financialyear'";// order by auto_number desc limit 0, 1";

//echo $billnumber;


?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$consultationprefix = $res3['consultationprefix'];

$query2 = "select * from master_billing order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billnumber"];
if ($billnumber == '')
{
	$billnumbercode =$consultationprefix.'00000001';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billnumber"];
	$billnumbercode = substr($billnumber, 3, 8);
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	if (strlen($maxanum) == 1)
	{
		$maxanum1 = '0000000'.$maxanum;
	}
	else if (strlen($maxanum) == 2)
	{
		$maxanum1 = '000000'.$maxanum;
	}
	else if (strlen($maxanum) == 3)
	{
		$maxanum1 = '00000'.$maxanum;
	}
	else if (strlen($maxanum) == 4)
	{
		$maxanum1 = '0000'.$maxanum;
	}
	else if (strlen($maxanum) == 5)
	{
		$maxanum1 = '000'.$maxanum;
	}
	else if (strlen($maxanum) == 6)
	{
		$maxanum1 = '00'.$maxanum;
	}
	else if (strlen($maxanum) == 7)
	{
		$maxanum1 = '0'.$maxanum;
	}
	else if (strlen($maxanum) == 8)
	{
		$maxanum1 = $maxanum;
	}
	
	$billnumbercode = $consultationprefix.$maxanum1;
	$openingbalance = '0.00';
	//echo $companycode;
}
//echo $billnumbercode;
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
<script type="text/javascript" src="js/disablebackenterkey.js"></script>

<script language="javascript">


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

function onloadfunction1()
{
	document.form1.doctorname.focus();	
}

/*
function processflowitem(varstate)
{
	//alert ("Hello World.");
	var varProcessID = varstate;
	//alert (varProcessID);
	var varItemNameSelected = document.getElementById("state").value;
	//alert (varItemNameSelected);
	ajaxprocess5(varProcessID);
	//totalcalculation();
}

function processflowitem1()
{
}

*/
</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {font-family: Tahoma}
.style2 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
</head>
<?php include ("js/sales1scripting1.php"); ?>
<script language="javascript">

function Loadingpage()
{

window.open("print_bill1opvisit.php?patientcode=",'','width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
window.focus();

}

function funcRedirectWindow1()
{
window.location = "billing_op1.php";
}

function process1()
{
	if (document.form1.patientpaymentmode.value == "")
	{
		alert ("Please Select Payment Mode. If Amount Is Zero, Please Select NIL.");
		document.form1.patientpaymentmode.focus();
		return false;
	}
	
/*
	if (document.form1.doctorname.value == "")
	{
		alert ("Doctor Name Cannot Be Empty.");
		document.form1.doctorname.focus();
		return false;
	}
	else if (document.form1.address1.value == "")
	{
		alert ("Address1  Cannot Be Empty.");
		document.form1.address1.focus();
		return false;
	}

	else if (document.form1.state.value == "")
	{
		alert ("State Cannot Be Empty.");
		document.form1.state.focus();
		return false;
	}
	else if (document.form1.city.value == "")
	{
		alert ("City Cannot Be Empty.");
		document.form1.city.focus();
		return false;
	}
/*
	else if (isNaN(document.getElementById("pincode").value))
	{
		alert ("Pincode Can Only Be Numbers");
		return false;
	}
	else if (document.form1.emailid1.value != "")
	{
		if (document.form1.emailid1.value.indexOf('@')<= 0 || document.form1.emailid1.value.indexOf('.')<= 0)
		{
			window.alert ("Please Enter valid Mail Id");
			document.form1.emailid1.value = "";
			document.form1.emailid1.focus();
			return false;
		}
	}
	else if (document.form1.emailid2.value != "")
	{
		if (document.form1.emailid2.value.indexOf('@')<= 0 || document.form1.emailid2.value.indexOf('.')<= 0)
		{
			window.alert ("Please Enter valid Mail Id");
			document.form1.emailid2.value = "";
			document.form1.emailid2.focus();
			return false;
		}
	}
*/
/*
	if (document.form1.openingbalance.value == "")
	{
		alert ("Opening Balance Cannot Be Empty.");
		document.form1.openingbalance.value = "0.00";
		document.form1.openingbalance.focus();
		return false;
	}
	if (isNaN(document.form1.openingbalance.value))
	{
		alert ("Opening Balance Can Only Be Numbers.");
		document.form1.openingbalance.focus();
		return false;
	}
	//return false;
*/
}

function funcDiscountAmountCalc1()
{
	if (document.form1.discountamount.value == "")
	{
		alert ("Discount Cannot Be Empty.");
		document.form1.discountamount.value = "0.00";
		return false;
	}
	if (isNaN(document.form1.discountamount.value))
	{
		alert ("Discount Amount Can Only Be Numbers.");
		//document.form1.discountamount.focus();
		return false;
	}
	if (parseFloat(document.form1.discountamount.value) > parseFloat(document.form1.totalamountbeforediscount.value))
	{
		alert ("Discount Amount Cannot Be More Than Total Amount.");
		document.form1.discountamount.value = "0.00";
		return false;
	}
	if (document.form1.discountamount.value != "")
	{
		var varTotalAmountBeforeDiscount = document.getElementById("totalamountbeforediscount").value;
		var varDiscountAmount = document.getElementById("discountamount").value;
		var varTotalAmountBeforeDiscount = parseFloat(varTotalAmountBeforeDiscount);
		var varDiscountAmount = parseFloat(varDiscountAmount);
		var varTotalAmount = varTotalAmountBeforeDiscount - varDiscountAmount;
		document.getElementById("totalamount").value = varTotalAmount.toFixed(2);
		return false;
	}
}
function funcOnLoadBodyFunctionCall()
{
	funcBodyOnLoad();
}
function cashentryonfocus1()
{
	if (document.getElementById("cashgivenbycustomer").value == "0.00")
	{
		document.getElementById("cashgivenbycustomer").value = "";
		document.getElementById("cashgivenbycustomer").focus();
	}
}

</script>
<body onLoad="return funcOnLoadBodyFunctionCall();">
<table width="103%" border="0" cellspacing="0" cellpadding="2">
  <tr>
	<td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
	<td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
	<td colspan="10" bgcolor="#ecf0f5">
	<?php 
	
		include ("includes/menu1.php"); 
	
	//	include ("includes/menu2.php"); 
	
	?>	</td>
  </tr>
  <tr>
	<td colspan="10">&nbsp;</td>
  </tr>
  <tr>
	<td width="1%">&nbsp;</td>
	<td width="2%" valign="top">&nbsp;</td>
	<td width="97%" valign="top">


		  <form name="form1" id="form1" method="post" onKeyDown="return disableEnterKey()" action="billing_op1.php" >
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		  <td width="860"><table width="800" height="282" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
			<tbody>
			  <tr bgcolor="#011E6A">
				<td bgcolor="#ecf0f5" class="bodytext3" colspan="2"><strong>Billing - OP Consultation </strong></td>
				<!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
				<td bgcolor="#ecf0f5" class="bodytext3" colspan="2">&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan="8" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
			  </tr>
			  <!--<tr bordercolor="#000000" >
				  <td  align="left" valign="middle"  class="bodytext3"  colspan="4"><strong>Registration</strong></font></div></td>
				</tr>-->
			  <!--<tr>
				  <tr  bordercolor="#000000" >
				  <td  align="left" valign="middle"  class="bodytext3" colspan="4"><div align="right">* Indicates Mandatory</div></td>
				</tr>-->
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Patient Reg ID </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>
				  <?php echo $patientcode; ?>
					  <input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>" readonly style="border: 1px solid #001E6A"  size="20" /></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Visit ID </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>
				  <?php echo $visitcode; ?>
					  <input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" readonly style="border: 1px solid #001E6A;"  size="20" />
					 <input type="hidden" name="fixedamountbalance" id="fixedamountbalance" value="<?php echo $patientlessedamount; ?>" readonly style="border: 1px solid #001E6A;"  size="20" />					  </td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Patient First Name </td>
				  <td width="25%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>
				  <?php echo $patientfirstname; ?>
				  <input type="hidden" name="patientfirstname" id="patientfirstname" value="<?php echo $patientfirstname; ?>" style="border: 1px solid #001E6A;"  size="20" /></td>
				  <td width="30%" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Patient Last Name </span></td>
				  <td width="29%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>
				  <?php echo $patientlastname; ?>
				  <input type="hidden" name="patientlastname" id="patientlastname" value="<?php echo $patientlastname; ?>" style="border: 1px solid #001E6A;"  size="20" /></td>
				  <input type="hidden" name="patientmiddlename" value="<?php echo $patientmiddlename; ?>">
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Visit Count </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong> 
				  <?php echo $visitcount; ?>
					  <input type="hidden" name="visittype" id="visittype" value="<?php echo $visitcount; ?>">						</td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Consultation Type </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong> 
				<?php 
				
				//echo $consultationtype; 
				$query1 = "select * from master_consultationtype where auto_number = '$consultationtype'";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res1 = mysqli_fetch_array($exec1);
				$res1consultationtypename = $res1['consultationtype'];
				echo $res1consultationtypename;
				
				?>
					  <input type="hidden" name="consultationtype" id="consultationtype" value="<?php echo $consultationtype; ?>" style="border: 1px solid #001E6A;"  size="20" />					  </td>
				</tr>
				<tr>
				<td width="16%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				<span class="bodytext32">Consulting Doctor </span></td>
				<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>
				<?php 
				echo $consultingdoctor; 
				?>
				<input type="hidden" name="consultingdoctor" id="consultingdoctor" value="<?php echo $consultingdoctor; ?>">
<!--                  <select name="consultingdoctor" id="consultingdoctor">
					<?php
				if ($consultingdoctor == '')
				{
					echo '<option value="" selected="selected">Select Doctor Name</option>';
				}
				else
				{
					$query51 = "select * from master_doctor where doctorname = '$consultingdoctor'";
					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res51 = mysqli_fetch_array($exec51);
					$res51doctorcode = $res51["doctorcode"];
					$res51doctorname = $res51["doctorname"];
					//echo '<option value="">Select Normal Tax</option>';
					echo '<option value="'.$res51consultingdoctor.'" selected="selected">'.$res51consultingdoctor.'</option>';
				}
				
				$query5 = "select * from master_doctor where status = '' order by doctorname";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5 = mysqli_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5doctorname = $res5["doctorname"];
				$res5doctorcode = $res5["doctorcode"];
				?>
					<option value="<?php echo $res5doctorcode; ?>"><?php echo $res5doctorname; ?></option>
					<?php
				}
				?>
									</select>
-->                </td>
				<td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Department</span></td>
				<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>
				<?php echo $department; ?>
				<input type="hidden" name="department" id="department" value="<?php echo $department; ?>" style="border: 1px solid #001E6A;"  size="20" />
				<strong>
<!--				
				<select name="department" id="department">
				  <?php
				if ($department == '')
				{
					echo '<option value="" selected="selected">Select Department</option>';
				}
				else
				{
					$query51 = "select * from master_department where recordstatus = ''";
					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res51 = mysqli_fetch_array($exec51);
					$res51department = $res51["department"];
					//echo '<option value="">Select Normal Tax</option>';
					echo '<option value="'.$res51department.'" selected="selected">'.$res51department.'</option>';
				}
				
				$query5 = "select * from master_department where recordstatus = '' order by department";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5 = mysqli_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5department = $res5["department"];
				?>
				  <option value="<?php echo $res5department; ?>"><?php echo $res5department; ?></option>
				  <?php
				}
				?>
				</select>
-->				
				</strong></td>
				</tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Consultation Date </span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>
				   <?php echo $consultationdate; ?>
				   <input type="hidden" name="consultationdate" id="consultationdate" value="<?php echo $consultationdate; ?>" readonly style="border: 1px solid #001E6A;">
					 <strong><span class="bodytext312"> 
					 <!--<img src="images2/cal.gif" onClick="javascript:NewCssCal('consultationdate')" style="cursor:pointer"/>--> 
					 </span></strong></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Consultation Time </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>
				   <?php echo $consultationtime; ?>
				<input type="hidden" name="consultationtime" id="consultationtime" value="<?php echo $consultationtime; ?>" readonly style="border: 1px solid #001E6A"  size="20" />
<!--				
				<select name="country" id="select">
					<?php
			if ($country != '') 
			{
			  echo '<option value="'.$country.'" selected="selected">'.$country.'</option>';
			}
			else
			{
			  echo '<option value="" selected="selected">Select</option>';
			}
		
			$query1 = "select * from master_country where status <> 'deleted' order by country";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1.country".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$country = $res1["country"];
			if ($country == 'India') { $selectedcountry = 'selected="selected"'; }
			?>
					<option <?php echo $selectedcountry; ?> value="<?php echo $country; ?>"><?php echo $country; ?></option>
					<?php
			  $selectedcountry = '';
				  
			  }
			  ?>
				  </select>                
--></td>
				  </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Consultation Fees </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>
				   <?php echo number_format($consultationfees, 2, '.', ''); ?>
				   <input type="hidden" name="consultationfees" id="consultationfees" value="<?php echo $consultationfees; ?>" style="border: 1px solid #001E6A;"  size="20" /></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Referred By </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>
				   <?php echo $referredby; ?>
				   <input type="hidden" name="referredby" id="referredby" value="<?php echo $referredby; ?>" style="border: 1px solid #001E6A;"  size="20" /></td>
				 </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				   <td colspan="3" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				  </tr>
				 
				 

				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Type</span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style1"><strong><?php echo $paymenttype; ?></strong>
				   <input type="hidden" name="paymenttype" id="paymenttype"  value="<?php echo $paymenttype;?>" readonly   style="border: 1px solid #001E6A;">    
				   </span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style1"><span class="bodytext32">Sub Type</span></span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style1"><strong><?php echo $subtype;?>
					 <input type="hidden" name="subtype" id="subtype"  value="<?php echo $subtype;?>"  readonly="readonly"  style="border: 1px solid #001E6A;">
				   </strong></span></td>
			  </tr>
				 
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Account Name </span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style1"><strong><?php echo $accountname;?></strong>
				   <input type="hidden" name="accountname" id="accountname"  value="<?php echo $accountname;?>"  readonly="readonly"  style="border: 1px solid #001E6A;">
				   </span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Account Expiry </span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style1"><strong><?php echo $accountexpirydate;?></strong>
				   <input type="hidden" name="accountexpirydate" id="accountexpirydate"  value="<?php echo $accountexpirydate;?>"  readonly="readonly"  style="border: 1px solid #001E6A;">
				   </span></td>
			  </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Plan Name</span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style1"><strong><?php echo $planname;?></strong>
				   <input type="hidden" name="planname" id="planname"  value="<?php echo $planname;?>"   readonly="readonly" style="border: 1px solid #001E6A;">
				   </span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Plan Expiry</span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style1"><strong><?php echo $planexpirydate;?></strong>
				   <input type="hidden" name="planexpirydate" id="planexpirydate"  value="<?php echo $planexpirydate;?>"   readonly="readonly" style="border: 1px solid #001E6A;">
				   </span></td>
			  </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Visit Limit </span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style1"><strong><?php echo $visitlimit;?></strong>
				   <input type="hidden" name="visitlimit" id="visitlimit"  value="<?php echo $visitlimit;?>"   readonly="readonly" style="border: 1px solid #001E6A;">
				   </span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Overall Limit </span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style1"><strong>
				   <?php echo number_format($overalllimit, 2, '.', ''); ?></strong>  
				   <input type="hidden" name="overalllimit" id="overalllimit"  value="<?php echo $overalllimit;?>"   readonly="readonly" style="border: 1px solid #001E6A;">
				   </span></td>
			  </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				   <td colspan="3" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style1"></span></td>
				  </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Bill Number </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style1"><strong><?php echo $billnumbercode;?></strong>
				   <input type="hidden" name="billnumbercode" id="billnumbercode" value="<?php echo $billnumbercode; ?>" readonly style="border: 1px solid #001E6A;">
				   </span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Bill Type </span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style1"><strong><?php echo $billtype;?></strong>
				   <input type="hidden" name="billingtype" id="billingtype"  value="<?php echo $billtype;?>"  readonly="readonly"  style="border: 1px solid #001E6A;">
				   </span></td>
				  </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Payment Mode </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> <span class="style1"><strong><?php echo $paymenttype;?></strong>
				   <input type="hidden" name="paymenttype" id="paymenttype" value="<?php echo $paymenttype; ?>" readonly style="border: 1px solid #001E6A;">
				   </span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Bill Amount </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style1"><strong>
				   <?php echo number_format($billamount, 2, '.', ''); ?>
				   </strong>
				   <input type="hidden" name="billamount" id="billamount" value="<?php echo $billamount; ?>" readonly style="border: 1px solid #001E6A;">
				   </span></td>
				 </tr>
				 
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Bill  Date Time </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style1"><strong><?php echo $billdatetime; ?></strong>
				   <input type="hidden" name="billingdatetime" id="billingdatetime" value="<?php echo $billdatetime; ?>" readonly style="border: 1px solid #001E6A;">
				   </span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Patient </span><span class="bodytext32">Bill Amount </span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><strong>
				   <?php echo  number_format($billamountpatient, 2, '.', ''); ?></strong></span>&nbsp;
                       <input type="hidden" name="patientbillamount" id="patientbillamount" value="<?php echo $billamountpatient; ?>" readonly style="border: 1px solid #001E6A;">                   </td>
				 </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Bill Entry By </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext3"><strong><?php echo $billentryby; ?></strong>
                         <input type="hidden" name="billentryby" id="billentryby" value="<?php echo $billentryby; ?>" readonly style="border: 1px solid #001E6A;">
                   </span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			       <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				 </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Sub Total Amount </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><label>
                     <input name="subtotalamount" type="text" id="subtotalamount" value="<?php echo number_format($consultationfees, 2, '.', ''); ?>" readonly style="border: 1px solid #001E6A; background-color:#ecf0f5; text-align:right" size="10">
                   </label></td>
				 </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Copay Fixed Amount </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><label>
                     <input name="copayfixedamount" type="text" id="copayfixedamount" value="<?php echo $planfixedamount; ?>" readonly style="border: 1px solid #001E6A; background-color:#ecf0f5; text-align:right" size="10">
                   </label></td>
				 </tr>
				  <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Copay Percentage </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><label>
                     <input name="copaypercentage" type="text" id="copaypercentage" value="<?php echo $planpercentage; ?>" readonly style="border: 1px solid #001E6A; background-color:#ecf0f5; text-align:right" size="10">
                   </label></td>
				 </tr>
				 <!--<tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Copay Percentage Amount </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">
				   <input name="copaypercentageamount" type="text" id="copaypercentageamount" readonly="readonly" style="border: 1px solid #001E6A; background-color:#ecf0f5;" size="10"> </td>
				 </tr>-->
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> Total Amount Before Discount </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><label>
                     <input name="totalamountbeforediscount" type="text" id="totalamountbeforediscount" value="<?php echo number_format($billamountpatient, 2, '.', ''); ?>" readonly style="border: 1px solid #001E6A; background-color:#ecf0f5; text-align:right" size="10">
                   </label></td>
				 </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Discount Amount </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><label>
                     <input name="discountamount" type="text" id="discountamount" value="0.00" onBlur="return funcDiscountAmountCalc1()" style="border: 1px solid #001E6A; text-align:right" size="10">
                   </label></td>
				 </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> Total Amount </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><label>
                     <input name="totalamount" type="text" id="totalamount" value="<?php echo number_format($billamountpatient, 2, '.', ''); ?>" readonly style="border: 1px solid #001E6A; background-color:#ecf0f5; text-align:right" size="10">
                   </label></td>
				 </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Patient Payment Mode </span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><select name="billtype" id="billtype" onChange="return paymentinfo()">
                      <option value="">SELECT BILL TYPE</option>
					<?php
					$query1billtype = "select * from master_billtype order by listorder";
					$exec1billtype = mysqli_query($GLOBALS["___mysqli_ston"], $query1billtype) or die ("Error in Query1billtype".mysqli_error($GLOBALS["___mysqli_ston"]));
					while ($res1billtype = mysqli_fetch_array($exec1billtype))
					{
					$billtype = $res1billtype["billtype"];
					?>
                    <option value="<?php echo $billtype; ?>"><?php echo $billtype; ?></option>
					<?php
					}
					?>
                     </select>
  &nbsp;</td>
				 </tr>
                          <tr id="cashamounttr">
                <td colspan="7" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Cash Amount </strong></div></td>
                <td align="left" valign="top" ><span class="bodytext31">
                  <input name="cashamount" id="cashamount" onBlur="return funcbillamountcalc1()" tabindex="1" value="0.00" style="border: 1px solid #001E6A; text-align:right" size="8"  readonly="readonly" />
                </span></td>
              </tr>
			  
              <tr id="cashamounttr2">
                <td colspan="7" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Cash Given By Customer </strong></div></td>
                <td align="left" valign="top" ><span class="bodytext31">
                  <input name="cashgivenbycustomer" id="cashgivenbycustomer" onBlur="return funcbillamountcalc1()" onFocus="return cashentryonfocus1()" tabindex="2" value="0.00" style="border: 1px solid #001E6A; text-align:right" size="8" autocomplete="off"  />
                </span></td>
              </tr>
              <tr id="cashamounttr3">
                <td colspan="7" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Cash To Be Returned To Customer </strong></div></td>
                <td align="left" valign="top" ><span class="bodytext31">
                  <input name="cashgiventocustomer" id="cashgiventocustomer" onBlur="return funcbillamountcalc1()" value="0.00" style="border: 1px solid #001E6A; text-align:right" size="8" readonly  />
                </span></td>
              </tr>
			  
              <tr id="creditamounttr">
                <td colspan="7" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Credit Amount </strong></div></td>
                <td align="left" valign="top" ><span class="bodytext31">
                  <input name="creditamount" id="creditamount" onBlur="return funcbillamountcalc1()" value="0.00" style="border: 1px solid #001E6A; text-align:right" size="8"  readonly="readonly" />
                </span></td>
              </tr>
              <tr id="chequeamounttr">
				   <td align="left" valign="center" colspan="6"  
                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Chq Date  </strong></div></td>
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><span class="bodytext311">
                  <input name="chequedate" id="chequedate" value="" style="border: 1px solid #001E6A; text-align:left; text-transform:uppercase" size="8"  />
                </span></td>
                <td align="left" valign="center" colspan="6"  
                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Chq No. </strong></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><input name="chequenumber" id="chequenumber" value="" style="border: 1px solid #001E6A; text-align:left; text-transform:uppercase" size="8"  /></td>
               </tr>
			   	<tr id="chequeamounttr1">
			    <td align="left" valign="center" colspan="6"  
                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Bank  </strong></div></td>
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><!--				<input name="bankname" id="bankname" value="" style="border: 1px solid #001E6A; text-align:left; text-transform:uppercase"  size="8"  />
-->
                  <span class="bodytext311">
                  <input name="chequebank" id="chequebank" value="" style="border: 1px solid #001E6A; text-align:left; text-transform:uppercase" size="8"  />
                  </span></td>
                <td align="left" valign="center" colspan="6"  
                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Cheque Amount </strong></div></td>
                <td align="left" valign="top" ><span class="bodytext31">
                  <input name="chequeamount" id="chequeamount" onBlur="return funcbillamountcalc1()" value="0.00" style="border: 1px solid #001E6A; text-align:right" size="8"  readonly="readonly" />
                </span></td>
              </tr>
              <tr id="cardamounttr">
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Card  </strong></div></td>
                <td width="13%" align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31">
				<select name="cardname" id="cardname">
				<option value="">SELECT CARD</option>
                  <?php
				$querycom="select * from master_creditcard where status <> 'deleted'";
				$execcom=mysqli_query($GLOBALS["___mysqli_ston"], $querycom) or die("Error in querycom".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($rescom=mysqli_fetch_array($execcom))
				{
				$creditcardname=$rescom["creditcardname"];
				?>
                  <option value="<?php echo $creditcardname;?>"><?php echo $creditcardname;?></option>
                  <?php
				}
				?>
                </select></td>
                <td width="6%" align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Number </strong></div></td>
                <td width="6%" align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><input name="cardnumber" id="cardnumber" value="" style="border: 1px solid #001E6A; text-align:left; text-transform:uppercase" size="8"  /></td>
                <td width="17%" align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Bank  </strong></div></td>
				<td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31">
                 <input name="bankname" id="bankname" value="" style="border: 1px solid #001E6A; text-align:left; text-transform:uppercase"  size="8"  />
				 </td>
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Card Amount </strong></div></td>
                <td align="left" valign="top" ><span class="bodytext31">
                  <input name="cardamount" id="cardamount" onBlur="return funcbillamountcalc1()" value="0.00" style="border: 1px solid #001E6A; text-align:right" size="8"  readonly="readonly" />
                </span></td>
              </tr>



              <tr id="onlineamounttr">
                <td colspan="7" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Online Amount </strong></div></td>
                <td align="left" valign="top" ><span class="bodytext31">
                  <input name="onlineamount" id="onlineamount" onBlur="return funcbillamountcalc1()" value="0.00" style="border: 1px solid #001E6A; text-align:right" size="8" readonly />
                </span></td>
              </tr>
              <tr id="nettamounttr">
                <td colspan="5" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><span class="bodytext32"><strong></strong></span>
                                  
                  <span class="bodytext32"><strong></strong></span>                  </td>
                <td colspan="2" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Nett Amount</strong></div></td>
                <td align="left" valign="top" ><span class="bodytext31">
                  <input name="nettamount" id="nettamount" value="0.00" style="border: 1px solid #001E6A; text-align:right" size="8" readonly />
                </span></td>
              </tr>
              
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
			       <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
			       <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				 </tr>
				 <!--<tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				   <td colspan="3" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
			  </tr>-->
				 <!--<tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Consultation Remarks </span></td>
				   <td colspan="3" align="left" valign="middle"  bgcolor="#ecf0f5"><input name="consultationremarks" id="consultationremarks" value="<?php //echo $consultationremarks; ?>" style="border: 1px solid #001E6A;"  size="75" /></td>
				  </tr>-->
				 
				 <!--<tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Complaint</span></td>
				   <td colspan="3" align="left" valign="middle"  bgcolor="#ecf0f5"><input name="complaint2" id="complaint2" value="<?php //echo $complaint; ?>" style="border: 1px solid #001E6A;"  size="75" /></td>
			  </tr>-->
				 <tr>
				   <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			  </tr>
				 
				 <tr>
				<td colspan="4" align="middle"  bgcolor="#ecf0f5"><div align="right"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
				  <input type="hidden" name="frmflag1" value="frmflag1" />
				  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
				  <input name="Submit222" type="submit"  value="Save Bill Entry" class="button" onClick="return funcSaveBill1()" style="border: 1px solid #001E6A"/>
				</font></font></font></font></font></div></td>
			  </tr>
			</tbody>
		  </table></td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
		</tr>
	</table>
	</form>
<script language="javascript">	
</script>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

