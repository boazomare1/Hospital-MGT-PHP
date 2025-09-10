<?php 
session_start();
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");

$errmsg = "";
$bgcolorcode = "";
$pagename = "";
$consultationfees1 = '';
$availablelimit = '';
$admissionfees = '';
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

//This include updatation takes too long to load for hunge items database.
include ("autocompletebuild_customer1.php");

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
$ipaddress = $_SERVER["REMOTE_ADDR"];
$username = $_SESSION['username'];

	$patientcode=$_REQUEST["patientcode"];
	
	
	$query3 = "select * from master_company where companystatus = 'Active'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$visitcodeprefix = $res3['ipvisitcodeprefix'];
	
	$visitcodeprefix1=strlen($visitcodeprefix);
$query2 = "select * from master_ipvisitentry order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$res2visitcode = $res2["visitcode"];
$res2visitnum=strlen($res2visitcode);
 $vvcode6=str_split($res2visitcode);
				  $value6=arrayHasOnlyInts($vvcode6);
				  $visitcodepre6=$res2visitnum-$value6;
if ($res2visitcode == '')
{

	$visitcode =$visitcodeprefix.'1';
	$openingbalance = '0.00';
}
else
{

	$res2visitcode = $res2["visitcode"];
	$visitcode = substr($res2visitcode,$visitcodepre6,$res2visitnum);
	$visitcode = intval($visitcode);
	
	$visitcode = $visitcode + 1;
	$maxanum = $visitcode;
	
	
	$visitcode = $visitcodeprefix .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
	
	$patientfirstname = $_REQUEST["patientfirstname"];
	$patientfirstname = strtoupper($patientfirstname);
	$patientmiddlename = $_REQUEST['patientmiddlename'];
	$patientmiddlename = strtoupper($patientmiddlename);
	$patientlastname = $_REQUEST["patientlastname"];
	$patientlastname = strtoupper($patientlastname);
	$patientfullname=$patientfirstname.' '.$patientmiddlename.' '.$patientlastname;
	$consultingdoctor = $_REQUEST["consultingdoctor"];
	$querydoc=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_doctor where auto_number='$consultingdoctor'");
	$execdoc=mysqli_fetch_array($querydoc);
	$consultingdoctor1=$execdoc['doctorname'];
	$department = $_REQUEST["department"];
		$billnumbercode=$_REQUEST['billnumbercode'];
	
	$paymenttype = $_REQUEST["paymenttype"];
	$subtype = $_REQUEST["subtype"];
	$billtype = $_REQUEST["billtype"];
	if($billtype == 'PAY NOW')
	{
	$deposit = '';
	}
	else
	{
	$deposit = 'notapplicable';
	}
    $accountname = $_REQUEST["accountname"];
	
	$query87="select * from master_accountname where auto_number='$accountname'";
	$exec87=mysqli_query($GLOBALS["___mysqli_ston"], $query87);
	$res87=mysqli_fetch_array($exec87);
	$accname=$res87['accountname'];
	$accountexpirydate = $_REQUEST["accountexpirydate"];
	$planname = $_REQUEST["planname"];
	$planexpirydate = $_REQUEST["planexpirydate"];
	$consultationdate = $_REQUEST["consultationdate"];
	$consultationtime  = $_REQUEST["consultationtime"];
	$consultationtype = $_REQUEST["consultationtype"];
	$admissionfees  = $_REQUEST["admissionfees"];
	$referredby = $_REQUEST["referredby"];
	$consultationremarks = $_REQUEST["consultationremarks"];
	$complaint = $_REQUEST["complaint"];
	$registrationdate = $_REQUEST["registrationdate"];
	$visittype = $_REQUEST["visittype"];
	$visitlimit = $_REQUEST["visitlimit"];
	$overalllimit = $_REQUEST["overalllimit"];
	$visitcount = $_REQUEST["visitcount"];
	$planfixedamount = $_REQUEST["planfixedamount"];
	$planpercentageamount = $_REQUEST["planpercentageamount"];
	$updatedatetime = date('Y-m-d H:i:s');
	$age = $_REQUEST['age'];
	$gender = $_REQUEST['gender'];
	$packapp = $_POST['packapplicable'];
	$opadmissiondoctor = $_REQUEST['admissiondoctor'];
	$admissionnotes = $_REQUEST['admissionnotes'];
	
	$ack = $packapp;
	if($ack == '1')
	{
	$package = $_REQUEST['package'];
	$packcharge = $_REQUEST['packcharge'];
	$packchargeapply = $_POST['packchargeapply'];
	}
	else
	{
	$package = '';
	$packcharge = '';
	}
	
	$nhifapplicable = $_REQUEST['nhifapplicable'];
	if($nhifapplicable == 'yes')
	{
	$nhifid = $_REQUEST['nhifid'];
	$issuedate = $_REQUEST['issuedate'];
	$validtill = $_REQUEST['validtill'];
	$nhifrebate = $_REQUEST['nhifrebate'];
	}
	else
	{
	$nhifid = '';
	$issuedate = '';
	$validtill = '';
	$nhifrebate = '';
	}
	
	$patientspent=$_REQUEST['patientspent'];
	
		$query3 = "select * from master_ipvisitentry where patientcode = '$patientcode' and  registrationdate = '$registrationdate'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rowcount3 = mysqli_num_rows($exec3);
		if ($rowcount3 != 0)
		{
			header ("location:ipvisitentry.php?errorcode=errorcode1failed");
			exit();
		}	
		
		
		
	$query2 = "select * from master_ipvisitentry where visitcode = '$visitcode'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 == 0)
	{
		$query1 = "insert into master_ipvisitentry (patientcode, visitcode, patientfirstname,patientmiddlename, patientlastname,patientfullname, consultingdoctor,
		department,paymenttype,subtype,billtype,accountname,accountexpirydate,planname,planexpirydate,consultationdate,consultationtime,consultationtype,admissionfees,referredby,consultationremarks,complaint,registrationdate,visittype,visitlimit,overalllimit,visitcount,patientspent,planpercentage,planfixedamount,age,gender,accountfullname,itemrefund,package,packagecharge,nhifid,nhifissuedate,nhifvaliddate,nhifrebate,deposit,packchargeapply,username,opadmissiondoctor,admissionnotes) 
		values('$patientcode','$visitcode','$patientfirstname','$patientmiddlename','$patientlastname','$patientfullname','$consultingdoctor',
		'$department','$paymenttype','$subtype','$billtype','$accountname','$accountexpirydate','$planname','$planexpirydate','$consultationdate','$consultationtime','$consultationtype','$admissionfees','$referredby', '$consultationremarks','$complaint','$registrationdate','$visittype','$visitlimit','$overalllimit','$visitcount','$patientspent','$planpercentageamount','$planfixedamount','$age','$gender','$accname','torefund','$package','$packcharge','$nhifid','$issuedate','$validtill','$nhifrebate','$deposit','$packchargeapply','$username','$opadmissiondoctor','$admissionnotes')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query44 = "select * from consultation_ipadmission where patientcode='$patientcode'";
		$exec44 = mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num44 = mysqli_num_rows($exec44);
		if($num44>0)
		{
		$query11 = "update consultation_ipadmission set status='completed' where patientcode='$patientcode'";
		$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		//$patientcode = '';
		//$visitcode = '';
		$patientfirstname = '';
		$patientmiddlename = '';
		$patientlastname = '';
		$consultingdoctor = '';

		$department = '';
		$paymenttype = '';
		$subtype = '';
		$accountname = '';
		$accountexpirydate = '';
		$planname = '';
		$planexpirydate = '';
		$consultationdate = '';
		$consultationtime = '';
		$consultationtype = '';
		$consultationfees = '';
		$referredby = '';
		$consultationremarks = '';
		$complaint = '';
		$registrationdate = '';
		$visittype = '';
		$visitlimit ='';
		$overalllimit = '';
		$planfixedamount = '';
		$planpercentageamount = '';
		$billtype ='';
		$patientspent='';
		$visitcount='';
		$packapp='';
		header("location:ipvisitentry.php");
		exit();
		//header ("location:addcompany1.php?st=success&&cpynum=1");
		
	}
	else
	{
		header ("location:ipvisitentry.php?patientcode=$patientcode&&st=failed");
	}
	

}
else
{
	$patientcode = '';
	$visitcode = '';
	$patientfirstname = '';
	$patientmiddlename = '';
	$patientlastname = '';
	$consultingdoctor = '';
	$department = '';
	$paymenttype = '';
	$subtype = '';
	$accountname = '';
	$accountexpirydate = '';
	$planname = '';
	$planexpirydate = '';
	$consultationdate = '';
	$consultationtime = '';
	$consultationtype = '';
	$consultationfees = '';
	$referredby = '';
	$consultationremarks = '';
	$complaint = '';
	$registrationdate = '';
	$visittype = '';
	$visitlimit = '';
	$overalllimit = '';
	$planfixedamount = '';
	$planpercentageamount = '';
	$billtype = '';
	$patientspent='';
	$visitcount='';
	$age='';
	$gender='';
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
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$visitcodeprefix = $res3['ipvisitcodeprefix'];
$nhifrebate = $res3['nhifrebate'];
$ipadmissionfee = $res3['ipadmissionfees'];
$visitcodeprefix1=strlen($visitcodeprefix);
$query2 = "select * from master_ipvisitentry order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$res2visitcode = $res2["visitcode"];
$res2visitnum=strlen($res2visitcode);
 $vvcode6=str_split($res2visitcode);
				  $value6=arrayHasOnlyInts($vvcode6);
				  $visitcodepre6=$res2visitnum-$value6;
if ($res2visitcode == '')
{

	$visitcode =$visitcodeprefix.'1';
	$openingbalance = '0.00';
}
else
{

	$res2visitcode = $res2["visitcode"];
	$visitcode = substr($res2visitcode,$visitcodepre6,$res2visitnum);
	$visitcode = intval($visitcode);
	
	$visitcode = $visitcode + 1;
	$maxanum = $visitcode;
	
	
	$visitcode = $visitcodeprefix .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

$query31 = "select * from master_company where companystatus = 'Active'";
$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res31 = mysqli_fetch_array($exec31);
$consultationprefix = $res31['consultationprefix'];

$query21 = "select * from master_billing order by auto_number desc limit 0, 1";
$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res21 = mysqli_fetch_array($exec21);
$billnumber = $res21["billnumber"];
if ($billnumber == '')
{
	$billnumbercode =$consultationprefix.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res21["billnumber"];
	$billnumbercode = substr($billnumber, 3, 8);
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = $consultationprefix.$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
	function arrayHasOnlyInts($array)
{
$count=0;
$count1=0;
    foreach ($array as $key => $value)
    {
        if (is_numeric($value)) // there are several ways to do this
        {
		$count1++;    
		
        }
		else
		{
		$count=$count+1;
		
		}
    }
    return $count1; 
}	
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
//$patientcode = 'MSS000000014';

if ($patientcode != '')
{
	//echo 'Inside Patient Code Condition.';
	$query3 = "select * from master_customer where customercode = '$patientcode'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	
	$patientfirstname = $res3['customername'];
	$patientfirstname = strtoupper($patientfirstname);

	$patientmiddlename = $res3['customermiddlename'];
	$patientmiddlename = strtoupper($patientmiddlename);

	$patientlastname = $res3['customerlastname'];
	$patientlastname = strtoupper($patientlastname);
	
	$patientfullname = $res3['customerfullname'];
	$patientfullname = strtoupper($patientfullname);
     
    $pamenttype1 = $res3['paymenttype'];

	$paymenttype = $res3['paymenttype'];
	$query4 = "select * from master_paymenttype where auto_number = '$paymenttype'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$paymenttypeanum = $res4['auto_number'];
	$paymenttype = $res4['paymenttype'];
	
	$subtype = $res3['subtype'];
	$query4 = "select * from master_subtype where auto_number = '$subtype'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$subtypeanum = $res4['auto_number'];
	$subtype = $res4['subtype'];

	$billtype = $res3['billtype'];
	$age = $res3['age'];
	$gender = $res3['gender'];
	
	$query39 = "select * from master_company";
	$exec39 = mysqli_query($GLOBALS["___mysqli_ston"], $query39) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res39 = mysqli_fetch_array($exec39);
	$ipadmissionfees = $res39['ipadmissionfees'];
	$creditipadmissionfees = $res39['creditipadmissionfees'];
	
	if($billtype == 'PAY NOW')
	{
	$admissionfees = $ipadmissionfees;
	}
	else
	{
	$admissionfees = $creditipadmissionfees;
	}
	
	$accountname = $res3['accountname'];
	$query4 = "select * from master_accountname where auto_number = '$accountname'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$accountnameanum = $res4['auto_number'];
	$accountname = $res4['accountname'];
	
	
	
	$accountexpirydate = $res3['accountexpirydate'];
	
	 $planname = $res3['planname'];
	 $query4 = "select * from master_planname where auto_number = '$planname'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$plannameanum = $res4['auto_number'];
	$planname = $res4['planname'];
	$planfixedamount = $res4['planfixedamount'];
	$planpercentageamount = $res4['planpercentage'];
	
	$query5 = "select * from master_ipvisitentry where patientcode = '$patientcode' and recordstatus = ''";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rowcount5 = mysqli_num_rows($exec5);
	$visitcount = $rowcount5 + 1;
	
	$planexpirydate = $res3['planexpirydate'];
	$registrationdate = $res3['registrationdate'];
	
	$visitlimit = $res3['visitlimit'];	
	$overalllimit = $res3['overalllimit'];
	if($visitcount == 1)
	{
	$availablelimit=$overalllimit ;
	}
	else
	{
	$availablelimit=$overalllimit-$planfixedamount;
	}
	
	
	
}
if (isset($_REQUEST["opvisitcode"])) { $opvisitcode = $_REQUEST["opvisitcode"]; } else { $opvisitcode = ""; }

if($opvisitcode != '')
{
$query76 = "select * from consultation_ipadmission where visitcode='$opvisitcode'";
$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res76 = mysqli_fetch_array($exec76);
$admissiondoctor = $res76['admissiondoctor'];
$admissionnotes = $res76['notes'];
}
else
{
$admissiondoctor = '';
$admissionnotes = '';

}
$registrationdate = date('Y-m-d');
$consultationdate = date('Y-m-d');
$consultationtime = date('H:i');
//$consultationfees = '500';

if (isset($_REQUEST["errorcode"])) { $errorcode = $_REQUEST["errorcode"]; } else { $errorcode = ""; }
//$patientcode = 'MSS00000009';
if ($errorcode == 'errorcode1failed')
{
	$errmsg = 'Patient Already Visited Today. Cannot Proceed With Visit Entry. Save Not Completed.';	
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

function funcRegistrationIPLabel()
{
var patientcode = document.getElementById("patientcode").value;
var popWin; 
popWin = window.open("print_ipvisit_label.php?patientcode="+patientcode,"_blank");
return true;
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
-->
</style>
</head>
<script language="javascript">

function process1()
{
	
	//alert ("Before Function");
	//To validate patient is not registered for the current date.
	//funcVisitEntryPatientCodeValidation1();
	//return false;


	/*if (document.form1.patientcode.value == "")
	{
		alert ("Please Search & Select Patient To Proceed.");
		document.form1.visittype.focus();
		return false;
	}
	if (document.form1.patientfirstname.value == "")
	{
		alert ("Please Enter Patient First Name.");
		document.form1.patientfirstname.focus();
		return false;
	}
	if(document.getElementById("billtype").value = "PAY LATER")
	{
	  if(document.getElementById("accountname").value == "")
	   {
	    alert("Account Name Cannot be Empty");
		document.form1.accountname.focus();
		return false;
	   }
	}
	
	if(document.getElementById("billtype").value = "PAY LATER")
	 {
	  if(document.getElementById("planname").value == "")
	   {
	    alert("Plan Name Cannot be Empty");
		document.form1.planname.focus();
		return false;
		}
	}
	
	*/
/*	if (document.form1.visittype.value == "")
	{
		alert ("Please Select Visit Type.");
		document.form1.visittype.focus();
		return false;
	}*/
	//alert(document.getElementById("recordstatus").value);
	if(document.getElementById("recordstatus").value == 'DELETED')
	{
	alert("Account has been suspended.Please Contact Accounts.");
		document.getElementById("accountnamename").focus();
			return false;
	}
	if(document.getElementById("nhifapplicable").value == 'yes')
	{
	if(document.getElementById("nhifid").value == '')
	{
	alert("Please Enter NHIF ID");
	document.getElementById("nhifid").focus();
	return false;
	}
	}
	
	if(document.getElementById("packapplicable").checked == true)
	{
	if(document.getElementById("package").value == "")
	{
	alert("Please Select Package");
	document.getElementById("package").focus();
	return false;
	}
	}
	if(document.getElementById("paymenttypename").value != "CASH" && document.getElementById("subtypename").value !="CASH")
	{
		 var VarVisitLimit = document.getElementById("visitlimit").value;
		 var VarVisitCount = document.getElementById("visitcount").value;
		 
		/*<!-- if(VarVisitCount > VarVisitLimit)
		 {
			alert("Your Visit Limit Is Finished .You Cannot Proceed");
			document.getElementById("department").focus();
			return false;
		}-->
			*/
	if (document.form1.availablelimit.value == 0)
	  {
		alert ("Available Limit Cannot be Empty.");
		document.form1.availablelimit.focus();
		return false;
	  }		
  }
	
	if (document.form1.department.value == "")
	{
		alert ("Please Select Department.");
		document.form1.department.focus();
		return false;
	}
	
	if (document.form1.consultingdoctor.value == "")
	{
		alert ("Please Select Consulting Doctor.");
		document.form1.consultingdoctor.focus();
		return false;
	}	
	
	if (document.form1.consultationtype.value == "")
	{
		alert ("Please Select Consultation Type.");
		document.form1.consultationtype.focus();
		return false;
	}
	
	
	if (document.getElementById("accountexpirydate").value != "")
	{
		<?php $date = mktime(0,0,0,date("m"),date("d")-1,date("Y")); 
		$currentdate = date("Y/m/d",$date);
		?>
		var currentdate = "<?php echo $currentdate; ?>";
		var expirydate = document.getElementById("accountexpirydate").value; 
		var currentdate = Date.parse(currentdate);
		var expirydate = Date.parse(expirydate);
		
		if( expirydate < currentdate)
		{
			alert("Please Select Correct Account Expiry date");
			//document.getElementById("accountexpirydate").focus();
			return false;
		}
	}
	
    if(document.getElementById("paymenttypename").value != "CASH" && document.getElementById("subtypename").value != "CASH")
	   {
		 /*if (document.getElementById("planfixedamount").value == 0)
		  {
			alert ("For Consultation Visit Entry, Plan Fixed Amount Cannot Be Zero. Please Refer Your Plan Details.");
			return false;
		 }*/
		
		/*if (parseFloat(document.getElementById("visitlimit").value) < parseFloat(document.getElementById("consultationfees").value))
		 {
			alert ("Consultation Fees Crossed Visit Limit Amount Level. Cannot Proceed.");
			return false;
		 }*/
		//return false;
		 var VarVisitLimit = document.getElementById("visitlimit").value;
		 var VarVisitCount = document.getElementById("visitcount").value;
		 
		/* if(VarVisitCount > VarVisitLimit)
		  {
			alert("Your Visit Limit Is Finished .You Cannot Proceed");
			document.getElementById("department").focus();
			return false;
		 }
		*/
		
		var VarOverallLimit = document.getElementById("overalllimit").value;
		var Varavaliablelimit = document.getElementById("availablelimit").value;
		
		if(Varavaliablelimit == 0)
		{
			alert("You Cannot Proceed Because No Available Balance");
			document.getElementById("department").focus();
			return false;
		}	
	}
}


/*
function funcVisitLimt()
{
<?php
	$query11 = "select * from master_customer where status = 'ACTIVE'";
	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res11 = mysqli_fetch_array($exec11))
	{
	$res11customername = $res11["customername"];
	$res11visitlimit = $res11['visitlimit'];
	$res11patientfirstname=$res11patientfirstname['patientfirstname'];
		?>
		if(document.getElementById("customername").value == "<?php echo $res11customername; ?>")
		{
			document.getElementById("visitlimit").value = <?php echo $res11visitlimit; ?>;
			document.getElementById("patientfirstname").value = <?php echo $res11patientfirstname; ?>;
			document.getElementById("customername").value = <?php echo $res11customername; ?>;
	
			return false;
		}
	<?php
	}
	?>
}
*/

function funcDepartmentChange()
{



	<?php
	$query11 = "select * from master_department where recordstatus = ''";
    $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res11 = mysqli_fetch_array($exec11))
	{
	$res11departmentanum = $res11['auto_number'];
	$res11department = $res11["department"];
	?>
		if(document.getElementById("department").value == "<?php echo $res11departmentanum; ?>")
		{
		document.getElementById("consultingdoctor").options.length=null; 
		var combo = document.getElementById('consultingdoctor'); 
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Doctor Name", ""); 
		<?php
		$query10 = "select * from master_doctor where department = '$res11departmentanum' order by doctorname";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res10 = mysqli_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10doctoranum = $res10['auto_number'];
		$res10doctorcode = $res10["doctorcode"];
		$res10doctorname = $res10["doctorname"];
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10doctorname;?>", "<?php echo $res10doctoranum;?>"); 
		<?php 
		}
		?>
		}
	<?php
	}
	?>
	<?php
	$query11 = "select * from master_department where recordstatus = ''";
    $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res11 = mysqli_fetch_array($exec11))
	{
	$res11departmentanum = $res11['auto_number'];
	$res11department = $res11["department"];
	?>
		if(document.getElementById("department").value == "<?php echo $res11departmentanum; ?>")
		{
		document.getElementById("consultationtype").options.length=null; 
		var combo = document.getElementById('consultationtype'); 
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Consultation Type", ""); 
		<?php
		$query10 = "select * from master_consultationtype where department = '$res11departmentanum' order by consultationtype";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res10 = mysqli_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10consultationtypeanum = $res10['auto_number'];
		$res10consultationtype = $res10["consultationtype"];
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10consultationtype;?>", "<?php echo $res10consultationtypeanum;?>"); 
		<?php 
		}
		?>
		}
	<?php
	}
	?>
 

}
function funcConsultationTypeChange()
{
//alert("hi");
document.getElementById("consultationfees").value = '';
	<?php
	$query11 = "select * from master_consultationtype where recordstatus = ''";
    $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res11 = mysqli_fetch_array($exec11))
	{
	$res11consultationanum = $res11["auto_number"];
	$res11consultationtype = $res11["consultationtype"];
	$res11consultationfees = $res11["consultationfees"];
	?>
	var varconsultationanum =  "<?php echo $res11consultationanum; ?>";
	//alert(varconsultationanum);
	var varconsultationtype = document.getElementById("consultationtype").value;
	//alert(varconsultationtype);
		if(parseInt(varconsultationtype) == parseInt(varconsultationanum))
		{
		    //alert('hi');
			document.getElementById("consultationfees").value = <?php echo $res11consultationfees; ?>;
			document.getElementById("consultationfees").focus();
		}
	<?php
	}
	?>
}
function funcpackageChange()
{
//alert("hi");
document.getElementById("packcharge").value = '';
var paymenttypename = document.getElementById("paymenttypename").value;

	<?php
	 $query69 = "select * from master_ippackage where status=''";
				   $exec69 = mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				   while($res69 = mysqli_fetch_array($exec69))
				   {
				   $packageanum = $res69['auto_number'];
				   $packagename = $res69['packagename'];
				   $packcharge = $res69['rate'];
				   $threshold = $res69['threshold'];
				   $rate3 = $res69['rate3'];
				   $packcharge1 = $threshold;
				   $packcharge1 = number_format($packcharge1,2,'.','');
				   $packcharge = number_format($packcharge,2,'.','');
				   

	?>
	var varpackageanum=  "<?php echo $packageanum; ?>";
	//alert(varconsultationanum);
	var varpackage = document.getElementById("package").value;
	//alert(varconsultationtype);
		if(parseInt(varpackage) == parseInt(varpackageanum))
		{
		    //alert('hi');
			if(paymenttypename == 'INSURANCE')
			{
			document.getElementById("packcharge").value = <?php echo $packcharge1; ?>;
			}
			else if(paymenttypename == "MICRO INSURANCE")
			{
			document.getElementById("packcharge").value = <?php echo $rate3; ?>;
			}
			else
			{
			document.getElementById("packcharge").value = <?php echo $packcharge; ?>;
			}
			document.getElementById("packcharge").focus();
		}
	<?php
	}
	?>
}


function funcOnLoadBodyFunctionCall()
{ 
	alert ("Inside Body On Load Fucntion.");
	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	funcCustomerDropDownSearch1(); //To handle ajax dropdown list.
	funcpackHideView();
	funcnhifHideView();
}

function funcpackShowView()
{
  if (document.getElementById("pack") != null) 
     {
	 document.getElementById("pack").style.display = 'none';
	}
	if (document.getElementById("pack") != null) 
	  {
	  document.getElementById("pack").style.display = '';
	 }
}
function funcpackHideView()
{		
 if (document.getElementById("pack") != null) 
	{
	document.getElementById("pack").style.display = 'none';
	}	
}

function funcnhifShowView()
{

  if (document.getElementById("nhif") != null) 
     {
	 document.getElementById("nhif").style.display = 'none';
	}
	if (document.getElementById("nhif") != null) 
	  {
	  document.getElementById("nhif").style.display = '';
	 }
}
function funcnhifHideView()
{		
 if (document.getElementById("nhif") != null) 
	{
	document.getElementById("nhif").style.display = 'none';
	}	
}

function funcnhifcheck()
{

if(document.getElementById("nhifapplicable").value == 'yes')
{
funcnhifShowView();
}
if(document.getElementById("nhifapplicable").value == 'no')
{
funcnhifHideView();
}
}
function funcpackcheck()
{
if(document.getElementById("packapplicable").checked == true)
{
funcpackShowView();
}
if(document.getElementById("packapplicable").checked == false)
{
funcpackHideView();
}
}
function funcaccountexpiry()
{
    <?php $date = mktime(0,0,0,date("m"),date("d")-1,date("Y")); 
	$currentdate = date("Y/m/d",$date);
	?>
	var currentdate = "<?php echo $currentdate; ?>";
	var expirydate = document.getElementById("expirydate").value; 
	var currentdate = Date.parse(currentdate);
	var expirydate = Date.parse(expirydate);
	
	if( expirydate > currentdate)
	{
	alert("Please Select Correct Account Expiry date");
	document.getElementById("expirydate").focus();
	return false;
	}
}

</script>
<?php include ("js/dropdownlist1newscripting1.php"); ?>
<script type="text/javascript" src="js/autosuggestnew1.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_newcustomer.js"></script>
<script type="text/javascript" src="js/autocustomercodesearch2.js"></script>

<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script type="text/javascript" src="js/visitentrypatientcodevalidation1.js"></script>

<script src="js/datetimepicker_css.js"></script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall()">
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


      	  <form name="form1" id="form1" method="post" action="ipvisitentry.php" onKeyDown="return disableEnterKey(event)" onSubmit="return process1()">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="860"><table width="1258" height="282" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
                <td bgcolor="#ecf0f5" class="bodytext3" colspan="2"><strong>IP Visit Entry </strong></td>
                <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                <td bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"></td>
              </tr>
              <!--<tr>
                <td colspan="12" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo 'red'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
              </tr>-->
              <!--<tr bordercolor="#000000" >
                  <td  align="left" valign="middle"  class="bodytext3"  colspan="4"><strong>Registration</strong></font></div></td>
                </tr>-->
              <!--<tr>
                  <tr  bordercolor="#000000" >
                  <td  align="left" valign="middle"  class="bodytext3" colspan="4"><div align="right">* Indicates Mandatory</div></td>
                </tr>-->
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Patient Search </td>
				  <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5">
				  <input name="customer" id="customer" size="60" autocomplete="off">
				  	  <input name="customerhiddentextbox" id="customerhiddentextbox" value="" type="hidden">
				  <input name="customercode" id="customercode" value="" type="hidden">
				<input type="hidden" name="recordstatus" id="recordstatus">
				  <input type="hidden" name="billnumbercode" id="billnumbercode" value="<?php echo $billnumbercode; ?>" readonly ></td>
				  </tr>
				
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  <td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				  <td width="12%" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				  <td width="13%" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				  <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				  <td width="15%" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				  <td colspan="2" rowspan="6" align="center" valign="middle"  bgcolor="#ecf0f5"><img width="150" height="150" src="patientphoto/<?php echo $patientcode; ?>.jpg" id="img"></td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Patient</td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5">
				  <input name="patientfirstname" id="patientfirstname" value="<?php echo $patientfirstname; ?>" readonly="readonly"  size="20" /></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5">
				  <input name="patientmiddlename" id="patientmiddlename" value="<?php echo $patientmiddlename; ?>" readonly="readonly" size="20" /></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="patientlastname" id="patientlastname" value="<?php echo $patientlastname; ?>" readonly="readonly" size="20" /></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Age</td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="age" id="age" value="<?php echo $age; ?>" readonly="readonly"></td>
				  <td width="1%" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				 </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Patient Reg ID </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5">
				  <input name="patientcode" id="patientcode" size="20" value="<?php echo $patientcode; ?>"/></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Registration Date </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="registrationdate" id="registrationdate" value="<?php echo $consultationdate; ?>"></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Gender</td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="gender" value="<?php echo $gender; ?>" id="gender" readonly="readonly"></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Type</td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5">
				    <input type="text" name="paymenttypename" id="paymenttypename"  value="<?php echo $paymenttype;?>" readonly="readonly">				
				    <input type="hidden" name="paymenttype" id="paymenttype"  value="<?php echo $paymenttypeanum;?>" readonly="readonly">					</td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Visit ID </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" readonly="readonly" size="20" /></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Account Name </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="accountnamename" id="accountnamename"  value="<?php echo $accountname;?>"  readonly="readonly">
				    <input type="hidden" name="accountname" id="accountname"  value="<?php echo $accountnameanum;?>"  readonly="readonly" ></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				</tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Sub Type </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><label>
                    <input type="text" name="subtypename" id="subtypename"  value="<?php echo $subtype;?>"  readonly="readonly" >
				    <input type="hidden" name="subtype" id="subtype"  value="<?php echo $subtypeanum;?>"  readonly="readonly" >
				  </label></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Bill Type </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="billtype" id="billtype"  value="<?php echo $billtype;?>"  readonly="readonly"  
				  ></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Account Expiry</span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="accountexpirydate" id="accountexpirydate"  value="<?php echo $accountexpirydate;?>"  readonly="readonly"></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				  </tr>
				
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Plan Name </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><label>
                    <input type="text" name="plannamename" id="plannamename"  value="<?php echo $planname;?>"   readonly="readonly">
                    <input type="hidden" name="planname" id="planname"  value="<?php echo $plannameanum;?>"   readonly="readonly">
                  </label></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Plan Expiry </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="planexpirydate" id="planexpirydate"  value="<?php echo $planexpirydate;?>"   readonly="readonly" ></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Visit Limit</span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="visitlimit" id="visitlimit"  value="<?php echo $visitlimit;?>"   readonly="readonly"></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><label></label></td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Fixed Amount </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><label>
				  <input type="text" name="planfixedamount" id="planfixedamount"  value="<?php echo $planfixedamount;?>"   readonly="readonly">
				  </label></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Overall Limit </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="overalllimit" id="overalllimit"  value="<?php echo $overalllimit;?>"   readonly="readonly" ></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Patient Due</span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="patientspent" id="patientspent"  value="<?php echo $patientspent;?>"   readonly="readonly"></td>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><label></label></td>
				  </tr>
				
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Percentage</td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><label>
				 <input type="text" name="planpercentageamount" id="planpercentageamount"  value="<?php echo $planpercentageamount;?>"   readonly="readonly" ></label> </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Available Limit </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="availablelimit" id="availablelimit"  value="<?php echo $availablelimit;?>"   readonly="readonly" ></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Member_No </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><strong>
				  <input name="memberno" id="memberno" value="" size="20" />
				    <input type="hidden" name="visitcount" id="visitcount"  value="<?php echo $visitcount;?>"   readonly="readonly">
				    <input name="visittype" id="visittype" value="" type="hidden">
				  </strong></td>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><label></label></td>
				</tr>
				
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">OP Admission Doctor</span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="admissiondoctor" id="admissiondoctor" value="<?php echo $admissiondoctor; ?>"></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Admission Doctor </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><strong>
				    <select name="consultingdoctor" id="consultingdoctor">
                      <!--<option value="">Select Consulting Doctor</option>-->
                      <?php
				     $query51 = "select * from master_doctor where auto_number = 4 ";
				     $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				     while ($res51 = mysqli_fetch_array($exec51))
				       {
				       $res51anum = $res51["auto_number"];
				       $res51doctorname = $res51["doctorname"];
				       ?>
                      <option value="<?php echo $res51anum; ?>" selected="selected"><?php echo $res51doctorname; ?></option>
                      <?php
				     }
				  ?>
                      <?php
				     $query51 = "select * from master_doctor where status = '' and doctorcode <> 'DTC00000004' order by doctorcode";
				     $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				     while ($res51 = mysqli_fetch_array($exec51))
				       {
				       $res51anum = $res51["auto_number"];
				       $res51doctorname = $res51["doctorname"];
				       ?>
                      <option value="<?php echo $res51anum; ?>" ><?php echo $res51doctorname; ?></option>
                      <?php
				     }
				  ?>
                    </select>
				  </strong></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Admission Notes</span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><textarea name="admissionnotes" id="admissionnotes" ><?php echo $admissionnotes; ?></textarea></td>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">
				  <!--<input type="hidden" name="department" id="department" value="<?php echo $department; ?>" style="border: 1px solid #001E6A;"  size="20" />--></td>
				</tr>
				<tr>
                <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Consultation Date </span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="consultationdate" id="consultationdate" value="<?php echo $consultationdate; ?>" readonly="readonly" ></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32"> Consultation Time </span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="consultationtime" id="consultationtime" value="<?php echo $consultationtime; ?>" readonly="readonly" size="8" />
                  <span class="bodytext32">(Ex: HH:MM)</span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Admission Fees </span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="admissionfees" id="admissionfees" onFocus="return funcVisitEntryPatientCodeValidation1()" size="20" value="<?php echo $admissionfees; ?>"/></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				</tr>
				 			 
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"> Package Applicable</span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="packapplicable" id="packapplicable" onClick="return funcpackcheck();" value="1"></td>
				   
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				   <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				 </tr>
				 <tr id="pack">
				 	   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"> Package </span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" id="pack"><select name="package" id="package" onChange="return funcpackageChange()">
				    <option value="">Select Package</option>
				   <?php
				   $query66 = "select * from master_ippackage where status=''";
				   $exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				   while($res66 = mysqli_fetch_array($exec66))
				   {
				   $packageanum = $res66['auto_number'];
				   $packagename = $res66['packagename'];
				   ?>
				   <option value="<?php echo $packageanum; ?>"><?php echo $packagename; ?></option>
				   <?php
				   }
				   
				   ?>
				   </select></td>
				   
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Package Charges</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="packcharge" id="packcharge" value="" size="20" /></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Apply Admn Fee</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="packchargeapply" id="packchargeapply" value="1"></td>
				   <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				 </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">NHIF Applicable </span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><select name="nhifapplicable" id="nhifapplicable" onChange="return funcnhifcheck();">
				    <option value="no">Select</option>
				   <option value="yes">YES</option>
				   <option value="no">NO</option>
				   </select></td>
				   
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" >&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				   <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				 </tr>
				 <tr id="nhif">
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">NHIF ID</span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="nhifid" id="nhifid" ></td>
				   
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Issue Date </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="text" name="issuedate" id="issuedate" size="10"> <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('issuedate')" style="cursor:pointer"/> </span></strong></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Valid Till</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="text" name="validtill" id="validtill" size="10"> <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('validtill')" style="cursor:pointer"/> </span></strong></td>
				   <td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">NHIF Rebate</td>
				   <td width="18%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="text" name="nhifrebate" id="nhifrebate" value="<?php echo $nhifrebate; ?>" readonly="readonly"></td>
				 </tr>
<!--				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Complaint</td>
				   <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5"><input name="complaint" id="complaint" value="<?php echo $complaint; ?>" style="border: 1px solid #001E6A;"  size="75" /></td>
			      </tr>
-->				 
				 
                 <tr>
                <td colspan="8" align="middle"  bgcolor="#ecf0f5" style="padding-right:200px;"><div align="right"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input type="hidden" name="frmflag1" value="frmflag1" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
                  <input name="Submit222" type="submit"  value="Save Visit Entry (Alt+S)" accesskey="s" class="button" id="submit" onClick="return funcRegistrationIPLabel()"/>
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