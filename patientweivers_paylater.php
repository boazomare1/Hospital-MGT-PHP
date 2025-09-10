<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");//echo $menu_id;include ("includes/check_user_access.php");
$updatedatetime = date("H:i:s");
$updatedatetime = date("Y-m-d H:i:s");  
$dateonly = date("Y-m-d");
$entrydate = date("Y-m-d");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$printbill = $_REQUEST["printbill"];
$docno=$_SESSION["docno"];
$totalcopayfixedamount='';
$totalcopay='';

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
$billno='';
 $ambcount=isset($_REQUEST['ambcount'])?$_REQUEST['ambcount']:'';
 $ambcount1=isset($_REQUEST['ambcount1'])?$_REQUEST['ambcount1']:'';
 $locationname=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
		 $locationcode=isset($_REQUEST['locationcodeget'])?$_REQUEST['locationcodeget']:'';
//$st = $_REQUEST['st'];
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["patientname"])) { $patientname = $_REQUEST["patientname"]; } else { $patientname = ""; }

if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }

if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }

$titlestr = 'SALES BILL';
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }

if ($frm1submit1 == 'frm1submit1')
{ 
    $visitcode=$_REQUEST["visitcode"];
	$patientcode = $_REQUEST["customercode"];
	$patientname = $_REQUEST["patientname"];
	$billtype = $_REQUEST['billtype'];
	$accountnameano = $_REQUEST['accountnameano'];
	$accountcode = $_REQUEST['accountcode'];
	$accountname = $_REQUEST['accountname'];
	
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);

$paylaterbillprefix = 'PW-';
$paylaterbillprefix1=strlen($paylaterbillprefix);
$query2 = "select docno from patientweivers where patientcode <> '' order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode =$paylaterbillprefix.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docno"];
	$billnumbercode = substr($billnumber,$paylaterbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = $paylaterbillprefix .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

	$consultation = $_REQUEST['consultation'];
	$consult_weiverpercent = $_REQUEST['consult_weiverpercent'];
	$consult_weiveramount = $_REQUEST['consult_weiveramount'];
	
	$pharmacy = $_REQUEST['pharmacy'];
	$pharmacy_weiverpercent = $_REQUEST['pharmacy_weiverpercent'];
	$pharmacy_weiveramount = $_REQUEST['pharmacy_weiveramount'];
	
	$lab = $_REQUEST['lab'];
	$lab_weiverpercent = $_REQUEST['lab_weiverpercent'];
	$lab_weiveramount = $_REQUEST['lab_weiveramount'];
	
	$radiology = $_REQUEST['radiology'];
	$radiology_weiverpercent = $_REQUEST['radiology_weiverpercent'];
	$radiology_weiveramount = $_REQUEST['radiology_weiveramount'];
	
	$services = $_REQUEST['services'];
	$services_weiverpercent = $_REQUEST['services_weiverpercent'];
	$services_weiveramount = $_REQUEST['services_weiveramount'];
	$remarks = $_REQUEST['remarks'];
	
	$query66 = "SELECT visitcode FROM patientweivers where visitcode = '$visitcode'";
	$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
	$row66 = mysqli_num_rows($exec66);
	//if($row66 == 0)
	//{
		$query67 = "INSERT INTO `patientweivers`(`docno`, `patientcode`, `visitcode`, `patientname`, `billtype`, `accountnameid`, `accountnameano`, `accountname`, `consultation`, 
		`consult_percent`, `consult_discamount`, `pharmacy`, `pharmacy_percent`, `pharmacy_discamount`, `lab`, `lab_percent`, `lab_discamount`, `radiology`, `radiology_percent`, 
		`radiology_discamount`, `services`, `services_percent`, `services_discamount`, `locationcode`, `locationname`, `username`, `ipaddress`, `updatedatetime`, `entrydate`,`remarks`) 
		VALUES('$billnumbercode','$patientcode','$visitcode','$patientname','$billtype','$accountcode','$accountnameano','$accountname','$consultation',
		'$consult_weiverpercent','$consult_weiveramount','$pharmacy','$pharmacy_weiverpercent','$pharmacy_weiveramount','$lab','$lab_weiverpercent','$lab_weiveramount','$radiology','$radiology_weiverpercent',
		'$radiology_weiveramount','$services','$services_weiverpercent','$services_weiveramount','$locationcode','$locationname','$username','$ipaddress','$updatedatetime','$entrydate','$remarks')";
		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die ("Error in Query67".mysqli_error($GLOBALS["___mysqli_ston"]));
	//}
	
	
	header("location:patientweiverslist.php?st=success");	
}

//To get default tax from autoitemsearch1.php and autoitemsearch2.php - for CST tax override.
if (isset($_REQUEST["defaulttax"])) { $defaulttax = $_REQUEST["defaulttax"]; } else { $defaulttax = ""; }
//$defaulttax = $_REQUEST["defaulttax"];
if ($defaulttax == '')
{
	$_SESSION["defaulttax"] = '';
}
else
{
	$_SESSION["defaulttax"] = $defaulttax;
}
if(isset($_REQUEST["patientcode"]))
{
$patientcode=$_REQUEST["patientcode"];
$visitcode=$_REQUEST["visitcode"];
}

//To verify the edition and manage the count of bills.
$thismonth = date('Y-m-');
$query77 = "select * from master_edition where status = 'ACTIVE'";
$exec77 =  mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
$res77 = mysqli_fetch_array($exec77);
$res77allowed = $res77["allowed"];


//To Edit Bill
if (isset($_REQUEST["delbillst"])) { $delbillst = $_REQUEST["delbillst"]; } else { $delbillst = ""; }
//$delbillst = $_REQUEST["delbillst"];
if (isset($_REQUEST["delbillautonumber"])) { $delbillautonumber = $_REQUEST["delbillautonumber"]; } else { $delbillautonumber = ""; }
//$delbillautonumber = $_REQUEST["delbillautonumber"];
if (isset($_REQUEST["delbillnumber"])) { $delbillnumber = $_REQUEST["delbillnumber"]; } else { $delbillnumber = ""; }
//$delbillnumber = $_REQUEST["delbillnumber"];

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
//$frm1submit1 = $_REQUEST["frm1submit1"];




if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST["st"];
if (isset($_REQUEST["banum"])) { $banum = $_REQUEST["banum"]; } else { $banum = ""; }
//$banum = $_REQUEST["banum"];
if ($st == '1')
{
	$errmsg = "Success. New Bill Updated. You May Continue To Add Another Bill.";
	$bgcolorcode = 'success';
}
if ($st == '2')
{
	$errmsg = "Failed. New Bill Cannot Be Completed.";
	$bgcolorcode = 'failed';
}
if ($st == '1' && $banum != '')
{
	$loadprintpage = 'onLoad="javascript:loadprintpage1()"';
}

if ($delbillst == "" && $delbillnumber == "")
{
	$res41customername = "";
	$res41customercode = "";
	$res41tinnumber = "";
	$res41cstnumber = "";
	$res41address1 = "";
	$res41deliveryaddress = "";
	$res41area = "";
	$res41city = "";
	$res41pincode = "";
	$res41billdate = "";
	$billnumberprefix = "";
	$billnumberpostfix = "";
}




?>

<?php
$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$execlab=mysqli_fetch_array($Querylab);
 $patientage=$execlab['age'];
 $patientgender=$execlab['gender'];

$patienttype=$execlab['maintype'];
$querytype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_paymenttype where auto_number='$patienttype'");
$exectype=mysqli_fetch_array($querytype);
$patienttype1=$exectype['paymenttype'];
$patientsubtype=$execlab['subtype'];
$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$patientsubtype'");
$execsubtype=mysqli_fetch_array($querysubtype);
$patientsubtype1=$execsubtype['subtype'];
$patientsubtypeano=$execsubtype['auto_number'];
$patientplan=$execlab['planname'];
$currency=$execsubtype['currency'];
$fxrate=$execsubtype['fxrate'];
if($currency=='')
{
	$currency='UGX';
}
$labtemplate = $execsubtype['labtemplate'];
if($labtemplate == '') { $labtemplate = 'master_lab'; }
$radtemplate = $execsubtype['radtemplate'];
if($radtemplate == '') { $radtemplate = 'master_radiology'; }
$sertemplate = $execsubtype['sertemplate'];
if($sertemplate == '') { $sertemplate = 'master_services'; }


$queryplan=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_planname where auto_number='$patientplan'");
$execplan=mysqli_fetch_array($queryplan);
$patientplan1=$execplan['planname'];
$smartap=$execplan['smartap'];

?>
<?php
$querylab1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$execlab1=mysqli_fetch_array($querylab1);
$patientname=$execlab1['customerfullname'];
$patientaccount=$execlab1['accountname'];

$querylab2=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_accountname where auto_number='$patientaccount'");
$execlab2=mysqli_fetch_array($querylab2);
$patientaccount1=$execlab2['accountname'];
$patientaccountid1=$execlab2['id'];
$accountnameano=$execlab2['auto_number'];

$query76 = "select * from master_financialintegration where field='labpaylater'";
$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res76 = mysqli_fetch_array($exec76);
$labcoa = $res76['code'];

$query761 = "select * from master_financialintegration where field='radiologypaylater'";
$exec761 = mysqli_query($GLOBALS["___mysqli_ston"], $query761) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res761 = mysqli_fetch_array($exec761);

$radiologycoa = $res761['code'];

$query762 = "select * from master_financialintegration where field='servicepaylater'";
$exec762 = mysqli_query($GLOBALS["___mysqli_ston"], $query762) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res762 = mysqli_fetch_array($exec762);

$servicecoa = $res762['code'];

$query763 = "select * from master_financialintegration where field='referalpaylater'";
$exec763 = mysqli_query($GLOBALS["___mysqli_ston"], $query763) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res763 = mysqli_fetch_array($exec763);

$referalcoa = $res763['code'];

$query764 = "select * from master_financialintegration where field='pharmacypaylater'";
$exec764 = mysqli_query($GLOBALS["___mysqli_ston"], $query764) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res764 = mysqli_fetch_array($exec764);

$pharmacycoa = $res764['code'];

$query76 = "select * from master_financialintegration where field='consultationfee'";
$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res76 = mysqli_fetch_array($exec76);
$consultationcoa = $res76['code'];

?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);

$paylaterbillprefix = 'PW-';
$paylaterbillprefix1=strlen($paylaterbillprefix);
$query2 = "select docno from patientweivers where patientcode <> '' order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode =$paylaterbillprefix.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docno"];
	$billnumbercode = substr($billnumber,$paylaterbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = $paylaterbillprefix .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

$query85 = "select * from master_visitentry where visitcode='$visitcode' and patientcode='$patientcode'";
$exec85 = mysqli_query($GLOBALS["___mysqli_ston"], $query85) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res85 = mysqli_fetch_array($exec85);
$consultationfee=$res85['consultationfees'];
$consultationfee = number_format($consultationfee,2,'.','');
$viscode=$res85['visitcode'];
$billtype = $res85['billtype'];
$consultationdate=$res85['consultationdate'];
?>

<script language="javascript">



<?php
if ($delbillst != 'billedit') // Not in edit mode or other mode.
{
?>
	//Function call from billnumber onBlur and Save button click.
	function billvalidation()
	{
		billnovalidation1();
	}
<?php
}
?>


function funcOnLoadBodyFunctionCall()
{


	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	 //To handle ajax dropdown list.
	
	funcPopupPrintFunctionCall();
	
}

function funcPopupPrintFunctionCall()
{

	///*
	//alert ("Auto Print Function Runs Here.");
	<?php
	if (isset($_REQUEST["src"])) { $src = $_REQUEST["src"]; } else { $src = ""; }
	//$src = $_REQUEST["src"];
	if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
	//$st = $_REQUEST["st"];
	if (isset($_REQUEST["billnumber"])) { $previousbillnumber = $_REQUEST["billnumber"]; } else { $previousbillnumber = ""; }
	//$previousbillnumber = $_REQUEST["billnumber"];
	if (isset($_REQUEST["billautonumber"])) { $previousbillautonumber = $_REQUEST["billautonumber"]; } else { $previousbillautonumber = ""; }
	//$previousbillautonumber = $_REQUEST["billautonumber"];
	if (isset($_REQUEST["companyanum"])) { $previouscompanyanum = $_REQUEST["companyanum"]; } else { $previouscompanyanum = ""; }
	//$previouscompanyanum = $_REQUEST["companyanum"];
	if ($src == 'frm1submit1' && $st == 'success')
	{
	$query1print = "select * from master_printer where defaultstatus = 'default' and status <> 'deleted'";
	$exec1print = mysqli_query($GLOBALS["___mysqli_ston"], $query1print) or die ("Error in Query1print.".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1print = mysqli_fetch_array($exec1print);
	$papersize = $res1print["papersize"];
	$paperanum = $res1print["auto_number"];
	$printdefaultstatus = $res1print["defaultstatus"];
	if ($paperanum == '1') //For 40 Column paper
	{
	?>
		//quickprintbill1();
		quickprintbill1sales();
	<?php
	}
	else if ($paperanum == '2') //For A4 Size paper
	{
	?>
		loadprintpage1('A4');
	<?php
	}
	else if ($paperanum == '3') //For A4 Size paper
	{
	?>
		loadprintpage1('A5');
	<?php
	}
	}
	?>
	//*/


}

//Print() is at bottom of this page.

</script>
<?php include ("js/sales1scripting1.php"); ?>
<script type="text/javascript">

function loadprintpage1(varPaperSizeCatch)
{
	//var varBillNumber = document.getElementById("billnumber").value;
	var varPaperSize = varPaperSizeCatch;
	//alert (varPaperSize);
	//return false;
	<?php
	//To previous js error if empty. 
	if ($previousbillnumber == '') 
	{ 
		$previousbillnumber = 1; 
		$previousbillautonumber = 1; 
		$previouscompanyanum = 1; 
	} 
	?>
	var varBillNumber = document.getElementById("quickprintbill").value;
	var varBillAutoNumber = "<?php //echo $previousbillautonumber; ?>";
	var varBillCompanyAnum = "<?php echo $_SESSION["companyanum"]; ?>";
	if (varBillNumber == "")
	{
		alert ("Bill Number Cannot Be Empty.");//quickprintbill
		document.getElementById("quickprintbill").focus();
		return false;
	}
	
	var varPrintHeader = "INVOICE";
	var varTitleHeader = "ORIGINAL";
	if (varTitleHeader == "")
	{
		alert ("Please Select Print Title.");
		document.getElementById("titleheader").focus();
		return false;
	}
	
	//alert (varBillNumber);
	//alert (varPrintHeader);
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');

	if (varPaperSize == "A4")
	{
		window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&billnumber="+varBillNumber+"","OriginalWindowA4<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	}
	if (varPaperSize == "A5")
	{
		window.open("print_bill1_a5.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&billnumber="+varBillNumber+"","OriginalWindowA5<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	}
}



function funcDefaultTax1() //Function to CST Taxes if required.
{
	//alert ("Default Tax");
	<?php
	//delbillst=billedit&&delbillautonumber=13&&delbillnumber=1
	//To avoid change of bill number on edit option after selecting default tax.
	if (isset($_REQUEST["delbillst"])) { $delBillSt = $_REQUEST["delbillst"]; } else { $delBillSt = ""; }
	//$delBillSt = $_REQUEST["delbillst"];
	if (isset($_REQUEST["delbillautonumber"])) { $delBillAutonumber = $_REQUEST["delbillautonumber"]; } else { $delBillAutonumber = ""; }
	//$delBillAutonumber = $_REQUEST["delbillautonumber"];
	if (isset($_REQUEST["delbillnumber"])) { $delBillNumber = $_REQUEST["delbillnumber"]; } else { $delBillNumber = ""; }
	//$delBillNumber = $_REQUEST["delbillnumber"];
	
	?>
	var varDefaultTax = document.getElementById("defaulttax").value;
	if (varDefaultTax != "")
	{
		<?php
		if ($delBillSt == 'billedit')
		{
		?>
		window.location="sales1.php?defaulttax="+varDefaultTax+"&&delbillst=<?php echo $delBillSt; ?>&&delbillautonumber="+<?php echo $delBillAutonumber; ?>+"&&delbillnumber="+<?php echo $delBillNumber; ?>+"";
		<?php
		}
		else
		{
		?>
		window.location="sales1.php?defaulttax="+varDefaultTax+"";
		<?php
		}
		?>
	}
	else
	{
		window.location="sales1.php";
	}
	//return false;
}



</script>
<script type="text/javascript" src="js/insertnewitem7.js"></script>
<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.bali{ text-align:right; }
</style>

<script src="js/datetimepicker_css.js"></script>
<script>
function loadprintpage1(banum)
{
	var banum = banum;
	window.open("print_paylater_summary.php?billautonumber="+banum+"","Window"+banum+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}

function funcSaveBill1()
{
	if(document.getElementById("consult_weiveramount").value == "" && document.getElementById("pharmacy_weiveramount").value == "" && document.getElementById("lab_weiveramount").value == "" && document.getElementById("radiology_weiveramount").value == "" && document.getElementById("services_weiveramount").value == "")
	{
		alert("Enter Discount Percent or Discount amount");
		document.getElementById("consult_weiveramount").focus();
		return false;
	}

	if(document.getElementById("remarks").value == "")
	{
		alert("Please enter the remarks");
		document.getElementById("remarks").focus();
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
	else
	{
		//alert ("Entry Saved.");
		document.frmsales.submit();
		//return true;
	}
	}
</script>
<script src="js/autocustomersmartsearch.js"></script>
<script type="text/javascript">
function WeiverCalc(id, val)
{
	var val = val;
	//alert(val);
	if(id == 'consult')
	{
		var consultation = document.getElementById("consultation").value;
		var consultation_percent = val;
		var consultation_disc = parseFloat(consultation) * (parseFloat(consultation_percent)/100);
		document.getElementById("consult_weiveramount").value = consultation_disc.toFixed(2);
		var consult_nett = parseFloat(consultation) - parseFloat(consultation_disc);
		document.getElementById("consult_weivernett").value = consult_nett.toFixed(2);
		if(val == '' || val > 100)
		{
			document.getElementById("consult_weiveramount").value = "";
			document.getElementById("consult_weivernett").value = "";
		}
	}
	//alert(val);
	if(id == 'pharmacy')
	{
		var pharmacy = document.getElementById("pharmacy").value;
		var pharmacy_percent = val;
		var pharmacy_disc = parseFloat(pharmacy) * (parseFloat(pharmacy_percent)/100);
		document.getElementById("pharmacy_weiveramount").value = pharmacy_disc.toFixed(2);
		var pharmacy_nett = parseFloat(pharmacy) - parseFloat(pharmacy_disc);
		document.getElementById("pharmacy_weivernett").value = pharmacy_nett.toFixed(2);
		if(val == '' || val > 100)
		{
			document.getElementById("pharmacy_weiveramount").value = "";
			document.getElementById("pharmacy_weivernett").value = "";
		}
	}
	if(id == 'lab')
	{
		var lab = document.getElementById("lab").value;
		var lab_percent = val;
		var lab_disc = parseFloat(lab) * (parseFloat(lab_percent)/100);
		document.getElementById("lab_weiveramount").value = lab_disc.toFixed(2);
		var lab_nett = parseFloat(lab) - parseFloat(lab_disc);
		document.getElementById("lab_weivernett").value = lab_nett.toFixed(2);
		if(val == '' || val > 100)
		{
			document.getElementById("lab_weiveramount").value = "";
			document.getElementById("lab_weivernett").value = "";
		}
	}
	if(id == 'radiology')
	{
		var radiology = document.getElementById("radiology").value;
		var radiology_percent = val;
		var radiology_disc = parseFloat(radiology) * (parseFloat(radiology_percent)/100);
		document.getElementById("radiology_weiveramount").value = radiology_disc.toFixed(2);
		var radiology_nett = parseFloat(radiology) - parseFloat(radiology_disc);
		document.getElementById("radiology_weivernett").value = radiology_nett.toFixed(2);
		if(val == '' || val > 100)
		{
			document.getElementById("radiology_weiveramount").value = "";
			document.getElementById("radiology_weivernett").value = "";
		}
	}
	if(id == 'services')
	{
		var services = document.getElementById("services").value;
		var services_percent = val;
		var services_disc = parseFloat(services) * (parseFloat(services_percent)/100);
		document.getElementById("services_weiveramount").value = services_disc.toFixed(2);
		var services_nett = parseFloat(services) - parseFloat(services_disc);
		document.getElementById("services_weivernett").value = services_nett.toFixed(2);
		if(val == '' || val > 100)
		{
			document.getElementById("services_weiveramount").value = "";
			document.getElementById("services_weivernett").value = "";
		}
	}
}

function WeiverCalcamt(id, val)
{
	var val = val;
	if(val=='')
		val =0 ;
	//alert(val);
	if(id == 'consult')
	{
		var consultation = document.getElementById("consultation").value;
		if(consultation > 0) {
			var consultation_disc = val;
			var consultation_percent = (parseFloat(consultation_disc)/ parseFloat(consultation) ) * 100;
			document.getElementById("consult_weiverpercent").value = consultation_percent;
			var consult_nett = parseFloat(consultation) - parseFloat(consultation_disc);
			document.getElementById("consult_weivernett").value = consult_nett.toFixed(2);
			if(consultation_percent == '' || consultation_percent > 100)
			{
				document.getElementById("consult_weiveramount").value = "";
				document.getElementById("consult_weivernett").value = "";
				document.getElementById("consult_weiverpercent").value ='';
			}
		}else{
			document.getElementById("consult_weiveramount").value = "";
				document.getElementById("consult_weivernett").value = "";
				document.getElementById("consult_weiverpercent").value ='';

		}
	}
	//alert(val);
	if(id == 'pharmacy')
	{
		var pharmacy = document.getElementById("pharmacy").value;
		if(pharmacy > 0) {
			var pharmacy_disc = val;
			var pharmacy_percent = (parseFloat(pharmacy_disc)/ parseFloat(pharmacy) ) * 100;
			document.getElementById("pharmacy_weiverpercent").value = pharmacy_percent;
			var pharmacy_nett = parseFloat(pharmacy) - parseFloat(pharmacy_disc);
			document.getElementById("pharmacy_weivernett").value = pharmacy_nett.toFixed(2);
			if(pharmacy_percent == '' || pharmacy_percent > 100)
			{
				document.getElementById("pharmacy_weiveramount").value = "";
				document.getElementById("pharmacy_weivernett").value = "";
				document.getElementById("pharmacy_weiverpercent").value ='';
			}
		}else{
			   document.getElementById("pharmacy_weiveramount").value = "";
				document.getElementById("pharmacy_weivernett").value = "";
				document.getElementById("pharmacy_weiverpercent").value ='';
		}
	}
	if(id == 'lab' )
	{
		var lab = document.getElementById("lab").value;
		if(lab > 0) {
			var lab_disc = val;
			var lab_percent = (parseFloat(lab_disc)/ parseFloat(lab) ) * 100;
			document.getElementById("lab_weiverpercent").value = lab_percent;
			var lab_nett = parseFloat(lab) - parseFloat(lab_disc);
			document.getElementById("lab_weivernett").value = lab_nett.toFixed(2);
			if(lab_percent == '' || lab_percent > 100)
			{
				document.getElementById("lab_weiveramount").value = "";
				document.getElementById("lab_weivernett").value = "";
				document.getElementById("lab_weiverpercent").value ='';
			}
		}else{
			document.getElementById("lab_weiveramount").value = "";
				document.getElementById("lab_weivernett").value = "";
				document.getElementById("lab_weiverpercent").value ='';

		}
	}
	if(id == 'radiology' )
	{
		var radiology = document.getElementById("radiology").value;
		if(radiology > 0) {
			var radiology_disc = val;
			
			var radiology_percent = (parseFloat(radiology_disc)/ parseFloat(radiology) ) * 100;
			document.getElementById("radiology_weiverpercent").value = radiology_percent;
			var radiology_nett = parseFloat(radiology) - parseFloat(radiology_disc);
			document.getElementById("radiology_weivernett").value = radiology_nett.toFixed(2);
			if(radiology_percent == '' || radiology_percent > 100)
			{
				document.getElementById("radiology_weiveramount").value = "";
				document.getElementById("radiology_weivernett").value = "";
				document.getElementById("radiology_weiverpercent").value ='';
			}
		}else{
			document.getElementById("radiology_weiveramount").value = "";
				document.getElementById("radiology_weivernett").value = "";
				document.getElementById("radiology_weiverpercent").value ='';

		}
	}
	if(id == 'services' )
	{
		var services = document.getElementById("services").value;
		if(services > 0) {
			var services_disc = val;
			var services_percent = (parseFloat(services_disc)/ parseFloat(services) ) * 100;
			document.getElementById("services_weiverpercent").value = services_percent;
			var services_nett = parseFloat(services) - parseFloat(services_disc);
			document.getElementById("services_weivernett").value = services_nett.toFixed(2);
			if(services_percent == '' || services_percent > 100)
			{
				document.getElementById("services_weiveramount").value = "";
				document.getElementById("services_weivernett").value = "";
				document.getElementById("services_weiverpercent").value ='';
			}
		}else{
			document.getElementById("services_weiveramount").value = "";
				document.getElementById("services_weivernett").value = "";
				document.getElementById("services_weiverpercent").value ='';
		}
	}
}
</script>
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="form1" id="frmsales" method="post" onSubmit="return funcSaveBill1()">
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
<!--  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
-->
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="980" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
            
                  <?php
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						
						$locationname = $res1["locationname"];
						$locationcode = $res1["locationcode"];
						?>
						<option value="<?php echo $res1locationanum; ?>" <?php if($location!='')if($location==$res1locationanum){echo "selected";}?>><?php echo $res1location; ?></option>
						
                <tr bgcolor="#011E6A">
                <td colspan="4" bgcolor="#ecf0f5" class="bodytext32"><strong>Pay Later Patient Details</strong></td>
                <td  colspan="4" bgcolor="#ecf0f5" class="bodytext32"><strong>Location:&nbsp;&nbsp;<?php echo $locationname ?> </strong></td>
                 <input type="hidden" name="locationcodeget" value="<?php echo $locationcode;?>">
                 <input type="hidden" name="locationnameget" value="<?php echo $locationname;?>">
			 </tr>
			 
		<?php
			if ($st == 'success' && $billautonumber != '' && $patientname != '' && $patientcode !='' && $visitcode !='')
			{
			?>
            <tr>
              <td colspan="8"  align="left" valign="center" bgcolor="#FFFF00" class="bodytext31">&nbsp;
			  * Success. Bill Saved. &nbsp;&nbsp;&nbsp;
			  <input name="billprint" type="button" onClick="return loadprintpage1('<?php echo $billautonumber; ?>')" value="Click Here To Print Summary" class="button" style="border: 1px solid #001E6A"/>
			  <input name="billprint" type="button" onClick="return loadprintpage2('<?php echo $billautonumber; ?>')" value="Click Here To Print Detailed" class="button" style="border: 1px solid #001E6A"/>
			  </td>
              
            </tr>
			<?php
			}
			?>
			
			  <tr>
			    <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient  </strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo $patientname; ?>
				<input type="hidden" name="patientname" id="customer" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/>                  </td>
                 
             <td width="12%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Type</strong></td>
                <td width="28%" colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $patienttype1; ?>
								</td>
		      </tr>
			   <tr>
			    <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="style4">Reg.No</td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo $patientcode; ?>
				<input type="hidden" name="customercode" id="customercode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input type="hidden" name="registrationdate" id="registrationdate" value="<?php echo date('Y-m-d'); ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input type="hidden" name="labcoa" value="<?php echo $labcoa; ?>">
				<input type="hidden" name="radiologycoa" value="<?php echo $radiologycoa; ?>">
				<input type="hidden" name="servicecoa" value="<?php echo $servicecoa; ?>">
				<input type="hidden" name="pharmacycoa" value="<?php echo $pharmacycoa; ?>">
				<input type="hidden" name="referalcoa" value="<?php echo $referalcoa; ?>">
				<input type="hidden" name="consultationcoa" value="<?php echo $consultationcoa; ?>">
				<input type="hidden" name="billtype" id="billtype" value="<?php echo $billtype; ?>">
		
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
				    <td width="12%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Sub Type</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $patientsubtype1; ?>
				<input type="hidden" name="subtype" id="subtype" value="<?php echo $patientsubtype1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input type="hidden" name="subtypeano" id="subtypeano" value="<?php echo $patientsubtypeano; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
				<input type="hidden" name="paymenttype" id="paymenttype" value="<?php echo $patienttype1; ?>">			</td>
			  </tr>
				  <tr>
				  <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit No </strong></td>
                  <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo $visitcode; ?>
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
                 <td width="12%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $patientaccount1; ?>
				<input type="hidden" name="accountname" id="accountname" value="<?php echo $patientaccount1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input type="hidden" name="accountcode" id="accountcode" value="<?php echo $patientaccountid1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input type="hidden" name="accountnameano" id="accountnameano" value="<?php echo $accountnameano; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				</td>
				  </tr>
                   <tr>
				  <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Doc No</strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo $billnumbercode; ?>
				<input type="hidden" name="billno" id="billno" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
                 <td width="12%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Plan Name</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $patientplan1; ?>
				<input type="hidden" name="account1" id="account1" value="<?php echo $patientplan1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
				  </tr>
                   <tr>
				  <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Entry Date</strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo $dateonly; ?>
				<input type="hidden" name="billdate" id="billdate" value="<?php echo $dateonly; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
                 <td width="12%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Currency/Fx Rate</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $currency.'/'.$fxrate; ?>
                <input type="hidden" name="currency" id="currency" value="<?php echo $currency; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
                <input type="hidden" name="fxrate" id="fxrate" value="<?php echo $fxrate; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
				  </tr>
				  	<tr>
                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
			 </tr>
            </tbody>
        </table></td>
      </tr>
      
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
           
			<?php
			$admitid='';
			$colorloopcount = '';
			$totalcopayconsult='';
			$sno = '';
			$totalamount=0;
			$totalfxamount=0;
			$totalfxcopay=0;
			$consfxrate=0;
			$conscopayfxrate=0;
			
			$query77 = "select * from billing_paylater where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rows77 = mysqli_num_rows($exec77);
			if($rows77 == 0)
			{
			
			
			$query17 = "select * from master_visitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res17 = mysqli_fetch_array($exec17);
			$consultationfee=$res17['consultationfees'];
			$consultationfee = number_format($consultationfee,2,'.','');
			$viscode=$res17['visitcode'];
			$consultationdate=$res17['consultationdate'];
			$plannumber = $res17['planname'];
			$consultingdoctor = $res17['consultingdoctor'];
			
			$admitid = $res17['admitid'];
			$availablelimit = $res17['availablelimit'];
			
			$queryplanname = "select forall from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execplanname = mysqli_query($GLOBALS["___mysqli_ston"], $queryplanname) or die ("Error in Queryplanname".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resplanname = mysqli_fetch_array($execplanname);
		 	$planforall = $resplanname['forall'];
			
			 $planpercentage=$res17['planpercentage'];
			 $planfixedamount=$res17['planfixedamount'];
			 $copay=($consultationfee/100)*$planpercentage;
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
			$consultationfee = number_format($consultationfee,2,'.','');
			$consfxrate=$consultationfee*$fxrate;
			$conscopayfxrate=$copay*$fxrate;
			
			$query33 = "select consultation from billing_consultation where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			 $exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $row33 = mysqli_num_rows($exec33);
 
			if($planpercentage!=0.00)
			{
			 $totalop=$consultationfee; 
			 $totalcopay=$totalcopay+$copay;
			 $totalcopayconsult=$totalcopayconsult+$copay;
			 $totalfxamount=$totalfxamount+$consfxrate;
			 $totalfxcopay=$totalfxcopay+$conscopayfxrate;
			}
			else
			{
				$totalop=$consultationfee; 
	        	$totalcopay=$totalcopay+$copay;
				$totalcopayconsult=$totalcopayconsult+$copay;
				$totalfxamount=$totalfxamount+$consfxrate;
				$totalfxcopay=$totalfxcopay+$conscopayfxrate;
			}
			
			?>
			
               <?php if(($planpercentage!=0.00)){
					 $totalfxamount-=$conscopayfxrate;
					 $consfxrate-=$conscopayfxrate;
					?>
                
			<?php 
			}
			$query18 = "select * from master_billing where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res18 = mysqli_fetch_array($exec18);
			$billingdatetime=$res18['billingdatetime'];
			$billno=$res18['billnumber'];
			$copayfixed=$planfixedamount;
			if($copayfixed > 0)
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
			 $conscopayfxrate=$copayfixed*$fxrate;
			 $totalcopayfixedamount=$copayfixed;
			 $totalfxcopay=$totalfxcopay+$conscopayfxrate;
			 ?>
			
			  <?php 
			} 
			$consfxrefund=0;
			$query11 = "select * from refund_consultation where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num=mysqli_num_rows($exec11);
			$res11 = mysqli_fetch_array($exec11);
			$res11billnumber = $res11['billnumber'];
	
			if($num > 0)
			{
			$consultationrefund = $copay;
			$res11transactiondate= $res11['billdate'];
			$res11transactiontime= $res11['transactiontime'];
			$consfxrefund=$consultationrefund*$fxrate;
			$totalfxcopay=$totalfxcopay-$consfxrefund;
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
			
			  <?php 
			} 
			
			
			  $totallab=0;
			  $labfxrate=0;
			  $labfxcopay=0;
			  $totalfxlab=0;
			  $labfxcopay=0;
			  $query19 = "select * from consultation_lab where labitemcode NOT IN (SELECT labitemcode FROM billing_paynowlab WHERE patientvisitcode='$visitcode' and patientcode='$patientcode') AND  patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> '' and freestatus <> 'yes'  AND labrefund <> 'completed' AND labrefund <> 'refund' and  paymentstatus = 'completed' and sampleid <> ''"; //and approvalstatus <> '2' and approvalstatus = '1'";
			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res19 = mysqli_fetch_array($exec19))
			{
				$labdate=$res19['consultationdate'];
				$labname=$res19['labitemname'];
				$labcode=$res19['labitemcode'];
				//$labrate=$res19['labitemrate'];
				$labrefno=$res19['refno'];
				
				$queryfx = "select rateperunit from $labtemplate where itemcode = '$labcode'";
				$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));
				$resfx = mysqli_fetch_array($execfx);
				$labrate=$resfx['rateperunit'];
		
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$labrate = number_format($labrate,2,'.','');
			$labfxrate=($labrate*$fxrate);
			$copay=($labrate/100)*$planpercentage;
			$labfxcopay=$copay*$fxrate;
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
              <?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			    $totallab=$totallab+$labrate; 
				$totalcopaylab=$totalcopaylab+$copay;
				$totalfxcopay=$totalfxcopay+$labfxcopay;
				$totalfxlab=$totalfxlab+$labfxrate;
				$totalfxcopaylab=$totalfxcopaylab+$labfxcopay; 
				$totalfxamount=$totalfxamount+$labfxrate;
			   }
			   else
			  {$totallab=$totallab+$labrate;$totalfxamount=$totalfxamount+$labfxrate;$totalfxlab=$totalfxlab+$labfxrate; }
			  ?>
             
              <?php if(($planpercentage!=0.00)&&($planforall=='yes')){ $totalcopay=$totalcopay+$copay;
			   $totalfxamount-=$labfxcopay;
			    $totalfxlab-=$labfxcopay;
			  ?>
             
				<?php }?>
			  
			  <?php } 
			
			  //copay
			   //$totallab=0;
			  $query19 = "select * from consultation_lab where labitemcode  IN (SELECT labitemcode FROM billing_paynowlab WHERE patientvisitcode='$visitcode' and patientcode='$patientcode') AND  patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> '' and freestatus <> 'yes'  AND labrefund <> 'completed' AND labrefund <> 'refund' and  paymentstatus = 'completed' and sampleid <> ''"; //and approvalstatus <> '2' and approvalstatus = '1'";
			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res19 = mysqli_fetch_array($exec19))
			{
				$labdate=$res19['consultationdate'];
				$labname=$res19['labitemname'];
				$labcode=$res19['labitemcode'];
				//$labrate=$res19['labitemrate'];
				$labrefno=$res19['refno'];
				
				$queryfx = "select rateperunit from $labtemplate where itemcode = '$labcode'";
				$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));
				$resfx = mysqli_fetch_array($execfx);
				$labrate=$resfx['rateperunit'];
				
				$labfxrate=($labrate*$fxrate);
				
			
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			
			$copay=($labrate/100)*$planpercentage;
			$labfxcopay=$copay*$fxrate;
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
              <?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			    $totallab=$totallab+$labrate; 
				$totalcopaylab=$totalcopaylab+$copay;
				$totalfxamount=$totalfxamount+$labfxrate;
				$totalfxcopay=$totalfxcopay+$labfxcopay;
				$totalfxlab=$totalfxlab+$labfxrate;
				$totalfxcopaylab=$totalfxcopaylab+$labfxcopay; 
			   }
			   else
			  {$totallab=$totallab+$labrate;$totalfxamount=$totalfxamount+$labfxrate;$totalfxlab=$totalfxlab+$labfxrate;}
			  ?>
            
              <?php if(($planpercentage!=0.00)&&($planforall=='yes')){ 
			  $totalcopay=$totalcopay+$copay;
			   $totalfxamount-=$labfxcopay;
			     $totalfxlab-=$labfxcopay;
			  ?>
             
				<?php }?>
			  
			  <?php } 
			  ?>
			  
			   <?php 
			   $totalpharm=0;
			   $totalfxpharm=0;
			   $totalfxcopaypharm=0;
			  $query23 = "select * from pharmacysales_details where  visitcode='$visitcode' and patientcode='$patientcode' group by itemcode";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$pharno = mysqli_num_rows($exec23);
			while($res23 = mysqli_fetch_array($exec23))
			{
				$phaquantity=0;
			$phaamount=0;
			$totalrefquantity=0;
			$reftotalamount=0;
			$phadate=$res23['entrydate'];
			$phaname=$res23['itemname'];
			$phaitemcode=$res23['itemcode'];
			$pharate=$res23['rate'];
			$pharno1=0;
				 $queryphar = "select auto_number from billing_paynowpharmacy where medicinecode='".$phaitemcode."' and patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$execphar = mysqli_query($GLOBALS["___mysqli_ston"], $queryphar) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$pharno1 = mysqli_num_rows($execphar);
				if($pharno1==0){
			
			$query33 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		    while($res33 = mysqli_fetch_array($exec33))
			{
			$quantity=$res33['quantity'];
			$phaquantity=$phaquantity+$quantity;
			$amount=$res33['totalamount'];
			$phaamount=$phaamount+$amount;
			}
			
			$query47 = "select * from pharmacysalesreturn_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
			$exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res47 = mysqli_fetch_array($exec47))
			{
			$refquantity = $res47['quantity'];
			$refamount = $res47['totalamount'];
			$totalrefquantity =  $totalrefquantity + $refquantity;
			$reftotalamount = $reftotalamount + $refamount;
			}
			
			$realquantity = $phaquantity - $totalrefquantity;
			$phaamount = $phaamount - $reftotalamount;
			$pharfxrate=$pharate;
			$pharfxamount=$phaamount;
			$pharate=number_format($pharate/$fxrate,2,'.','');
			$phaamount=number_format($pharate*$realquantity,2,'.','');
			$phaamount=number_format($phaamount,2,'.','');
			 $query28 = "select * from master_consultationpharm where   patientvisitcode='$visitcode' and patientcode='$patientcode' and medicinecode='$phaitemcode'";
			$exec28 = mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res28 = mysqli_fetch_array($exec28);
			$pharefno=$res28['refno'];
			$excludestatus=$res28['excludestatus'];
			$approvalstatus = $res28['approvalstatus'];
			
			
			if($excludestatus == '')
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
			//$totalpharm=$totalpharm+$phaamount;
			?>
            <?php 
			$copayfxamount=(($pharate*$realquantity)/100)*$planpercentage;
			$copay=($copayfxamount/$fxrate);
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			    $totalpharm=$totalpharm+$phaamount;
				$totalcopaypharm=$totalcopaypharm+$copay;
				
				$totalpharm=$totalpharm+$phaamount;
				$totalcopaypharm=$totalcopaypharm+$copay;
				$totalfxpharm=$totalfxpharm+$pharfxamount;
				$totalfxcopaypharm=$totalfxcopaypharm+$copayfxamount;
				$totalfxcopay=$totalfxcopay+$copayfxamount;

				$totalfxamount=$totalfxamount+$pharfxamount;
			   }
			   else
			  {$totalpharm=$totalpharm+$phaamount;$totalfxamount=$totalfxamount+$pharfxamount;$totalfxpharm=$totalfxpharm+$pharfxamount;}
			  ?>
			
             <?php if(($planpercentage!=0.00)&&($planforall=='yes')){ $totalcopay=$totalcopay+$copay;
			  $totalfxamount-=$copay*$realquantity;
			    $totalfxpharm-=$copay*$realquantity;
			 ?>
             
				<?php }?>
			  
			  <?php }
			  }}
			  ?>
              
              <!--copay-->
               <?php 
			   //$totalpharm=0;
			  $query23 = "select * from pharmacysales_details where  visitcode='$visitcode' and patientcode='$patientcode' group by itemcode";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$pharno = mysqli_num_rows($exec23);
			while($res23 = mysqli_fetch_array($exec23))
			{
				$phaquantity=0;
			$phaamount=0;
			$totalrefquantity=0;
			$reftotalamount=0;
			$phadate=$res23['entrydate'];
			$phaname=$res23['itemname'];
			$phaitemcode=$res23['itemcode'];
			$pharate=$res23['rate'];
			$pharno1=0;
				 $queryphar = "select auto_number from billing_paynowpharmacy where medicinecode='".$phaitemcode."' and patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$execphar = mysqli_query($GLOBALS["___mysqli_ston"], $queryphar) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$pharno1 = mysqli_num_rows($execphar);
				if($pharno1>0){
			
			$query33 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		    while($res33 = mysqli_fetch_array($exec33))
			{
			$quantity=$res33['quantity'];
			$phaquantity=$phaquantity+$quantity;
			$amount=$res33['totalamount'];
			$phaamount=$phaamount+$amount;
			}
			
			$query47 = "select * from pharmacysalesreturn_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
			$exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res47 = mysqli_fetch_array($exec47))
			{
			$refquantity = $res47['quantity'];
			$refamount = $res47['totalamount'];
			$totalrefquantity =  $totalrefquantity + $refquantity;
			$reftotalamount = $reftotalamount + $refamount;
			}
			$realquantity = $phaquantity - $totalrefquantity;
			$phaamount = $phaamount - $reftotalamount;
			$pharfxrate=$pharate;
			$pharfxamount=$phaamount;
			$pharate=number_format($pharate/$fxrate,2,'.','');
			$phaamount=number_format($pharate*$realquantity,2,'.','');
			$phaamount=number_format($phaamount,2,'.','');
			 $query28 = "select * from master_consultationpharm where   patientvisitcode='$visitcode' and patientcode='$patientcode' and medicinecode='$phaitemcode'";
			$exec28 = mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res28 = mysqli_fetch_array($exec28);
			$pharefno=$res28['refno'];
			$excludestatus=$res28['excludestatus'];
			$approvalstatus = $res28['approvalstatus'];
			
			
			if($excludestatus == '')
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
			//$totalpharm=$totalpharm+$phaamount;
			?>
            <?php 
			$copayfxamount=(($pharate*$realquantity)/100)*$planpercentage;
				
			 $copay=(($pharate)/100)*$planpercentage;
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			   $totalpharm=$totalpharm+$phaamount;
				$totalcopaypharm=$totalcopaypharm+$copay*$realquantity;
				 $totalfxpharm=$totalfxpharm+$pharfxamount;
				$totalfxcopaypharm=$totalfxcopaypharm+$copayfxamount;
				$totalfxcopay=$totalfxcopay+$copayfxamount;

				$totalfxamount=$totalfxamount+$pharfxamount;
				
			   }
			   else
			  {$totalpharm=$totalpharm+$phaamount;$totalfxamount=$totalfxamount+$pharfxamount;$totalfxpharm=$totalfxpharm+$pharfxamount;}
			  ?>
			 
             <?php if(($planpercentage!=0.00)&&($planforall=='yes')){
				 			 $pharfxrate=number_format($copay*$fxrate,5,'.','');
				 			 $pharfxamount=number_format($pharfxrate*$realquantity,5,'.','');
							 $copay*$realquantity;
							 $totalcopay=$totalcopay+($copay*$realquantity);
							 	$totalfxamount-=$pharfxamount;
								$totalfxpharm-=$pharfxamount;
			 ?>
           
				<?php }?>
			  
			  <?php }
			  }}
			  ?>
                <?php 
				if($pharno>0){
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
			$desprate=0;
			$despratetotal=0;
			$totalcopaydesp=0;
			 if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			    $desprate=($desprate/100)*$planpercentage;
				$totalcopaydesp=$desprate;
			   }
			  ?>
			
              <?php if(($planpercentage!=0.00)&&($planforall=='yes')){ $copay=$desprate; $totalcopay=$totalcopay+$copay;
			   $totalfxamount-=$copay;
			    $totalfxpharm-=$copay;
			   ?>
              
			  <?php }}
			  ?>
			    <?php 
				$totalrad=0;
				$totalcopayrad='';
				$radfxrate=0;
				$totalfxrad=0;
				$totalfxcopayrad=0;
				$radfxcopay=0;
			  $query20 = "select * from consultation_radiology where radiologyitemcode NOT IN (SELECT radiologyitemcode FROM billing_paynowradiology WHERE patientvisitcode='$visitcode' and patientcode='$patientcode') AND patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> '' and radiologyrefund <> 'refund' and radiologyrefund <> 'completed' and  paymentstatus = 'completed'"; //and approvalstatus <> '2' and approvalstatus = '1'";
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res20 = mysqli_fetch_array($exec20))
			{
			$raddate=$res20['consultationdate'];
			$radname=$res20['radiologyitemname'];
			$radcode=$res20['radiologyitemcode'];
			
			$queryfx = "select rateperunit from $radtemplate where itemcode = '$radcode'";
			$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resfx = mysqli_fetch_array($execfx);
			$radrate=$resfx['rateperunit'];
				
			//$radrate=$res20['radiologyitemrate'];
			$radref=$res20['refno'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$radrate = number_format($radrate,2,'.','');
			$copay=($radrate/100)*$planpercentage;
			$radfxrate=($radrate*$fxrate);
			$radfxcopay=$copay*$fxrate;
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
			
			//$totalrad=$totalrad+$radrate;
			?>
            <?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			    $totalrad=$totalrad+$radrate; 
				$totalcopayrad=$totalcopayrad+$copay;
				$totalfxcopay=$totalfxcopay+$radfxcopay;
				$totalfxamount=$totalfxamount+$radfxrate;				
				$totalfxrad=$totalfxrad+$radfxrate;
				$totalfxcopayrad=$totalfxcopayrad+$radfxcopay; 
			   }
			   else
			  {$totalrad=$totalrad+$radrate;$totalfxamount=$totalfxamount+$radfxrate;$totalfxrad=$totalfxrad+$radfxrate;}
			  ?>
			
              <?php if(($planpercentage!=0.00)&&($planforall=='yes')){  $totalcopay=$totalcopay+$copay;
			  							 	$totalfxamount-=$radfxcopay;
											  $totalfxrad-=$radfxcopay;
 	
			  ?>
            
				<?php }?>
			  
			  <?php }
			  ?>
              <!--copay-->
                <?php 
				//$totalrad=0;
				//$totalcopayrad='';
			  $query20 = "select * from consultation_radiology where radiologyitemcode  IN (SELECT radiologyitemcode FROM billing_paynowradiology WHERE patientvisitcode='$visitcode' and patientcode='$patientcode') AND patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> '' and radiologyrefund <> 'refund' and radiologyrefund <> 'completed' and  paymentstatus = 'completed'"; //and approvalstatus <> '2' and approvalstatus = '1'";
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res20 = mysqli_fetch_array($exec20))
			{
			$raddate=$res20['consultationdate'];
			$radname=$res20['radiologyitemname'];
			$radcode=$res20['radiologyitemcode'];
			
			$queryfx = "select rateperunit from $radtemplate where itemcode = '$radcode'";
			$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resfx = mysqli_fetch_array($execfx);
			$radrate=$resfx['rateperunit'];
			
			//$radrate=$res20['radiologyitemrate'];
			$radref=$res20['refno'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			$copay=($radrate/100)*$planpercentage;
			$radfxrate=($radrate*$fxrate);
			$radfxcopay=$copay*$fxrate;
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
			
			//$totalrad=$totalrad+$radrate;
			?>
            <?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			    $totalrad=$totalrad+$radrate; 
				$totalcopayrad=$totalcopayrad+$copay;
				$totalfxcopay=$totalfxcopay+$radfxcopay;
				$totalfxamount=$totalfxamount+$radfxrate;				
				$totalfxrad=$totalfxrad+$radfxrate;
				$totalfxcopayrad=$totalfxcopayrad+$radfxcopay; 
			   }
			   else
			  {$totalrad=$totalrad+$radrate;$totalfxamount=$totalfxamount+$radfxrate;$totalfxrad=$totalfxrad+$radfxrate;}
			  ?>
			 
              <?php if(($planpercentage!=0.00)&&($planforall=='yes')){ $totalcopay=$totalcopay+$copay;
			  	$totalfxamount-=$radfxcopay;
				  $totalfxrad-=$radfxcopay;
				
			  ?>
             
				<?php }?>
			  
			  <?php }
			  ?>
			  	    <?php 
					
					$totalser=0;
					$serfxrate=0;
					$serfxcopay=0;
					$totalfxser=0;
					$totalfxcopayser=0;
					$serfxcopayqty=0;
					$serfxrateqty=0;
			  $query21 = "select * from consultation_services where servicesitemcode NOT IN (SELECT servicesitemcode FROM billing_paynowservices WHERE patientvisitcode='$visitcode' and patientcode='$patientcode') AND patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> ''   and  paymentstatus = 'completed'  group by servicesitemcode";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res21 = mysqli_fetch_array($exec21))
			{
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			//$serrate=$res21['servicesitemrate'];
			$sercode=$res21['servicesitemcode'];
			
			$queryfx = "select rateperunit from $sertemplate where itemcode = '$sercode'";
			$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resfx = mysqli_fetch_array($execfx);
			$serrate=$resfx['rateperunit'];
			
			$serref=$res21['refno'];
			
			$query2111 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' ";//and approvalstatus <> '2' and approvalstatus = '1'";
			$exec2111 = mysqli_query($GLOBALS["___mysqli_ston"], $query2111) or die ("Error in Query2111".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numrow2111 = mysqli_num_rows($exec2111);
			$resqty = mysqli_fetch_array($exec2111);
			$serqty=$resqty['serviceqty'];
			$serrefqty=$resqty['refundquantity'];
			
			$serqty = $serqty-$serrefqty;
			$totserrate=$resqty['amount'];
		    //$perrate=$resqty['servicesitemrate'];
			$perrate = $serrate;
			//$totserrate=$serrate*$serqty;
			//echo $serrate;
			$serrate = number_format($serrate,2,'.','');
			$perrate = number_format($perrate,2,'.','');
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$copay=(($serrate*$serqty)/100)*$planpercentage;
			$copaysingle=($serrate/100)*$planpercentage;
		 	$copayperservice=$copay/$serqty;
			$totamt=$perrate*$serqty;
			$serfxrate=($perrate*$fxrate);
			$serfxcopay=$copaysingle*$fxrate;
			$serfxcopayqty=$serfxcopay*$serqty;
			$serfxrateqty = $serfxrate*$serqty;
			$totserrate=$totamt;
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
			//$totalser=$totalser+$totserrate;
			?>
             <?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			   
				$serratetot=$serrate;
				//$totalser=$totalser+$serratetot; 
				$totserrate = $totamt-$copay;
				$totalser=$totalser+$totamt;
				
				$totalcopayser=$totalcopayser+$copay;
				$totalfxcopay=$totalfxcopay+$serfxcopayqty;
				$totalfxamount=$totalfxamount+$serfxrateqty;
				$totalfxser=$totalfxser+$serfxrateqty;
				$totalfxcopayser=$totalfxcopayser+$serfxcopayqty;
			   }
			   else if(($planpercentage!=0.00)&&($planforall==''))
			  { 
			    $serratetot=$serrate;
				//$totamt=$perrate*$numrow2111;
			    $totalser=$totalser+$totamt; 
				//$totalcopayser=$totalcopayser+$copay;
				
				$totalfxcopay=$totalfxcopay+$serfxcopayqty;
				$totalfxamount=$totalfxamount+$serfxrateqty;
				$totalfxser=$totalfxser+$serfxrateqty;
				$totalfxcopayser=$totalfxcopayser+$serfxcopayqty;
			   }
			   
			   else
			  {
				   	$serratetot=$serrate;
				  	$totalser=$totalser+$totamt;
				  	$totalfxamount=$totalfxamount+$serfxrateqty;
					$totalfxser=$totalfxser+$serfxrateqty;
			  }
			  ?>
			
              <?php if(($planpercentage!=0.00)&&($planforall=='yes')){  $totalcopay=$totalcopay+$copay;  $copayperser=$copay/$serqty;
			  	$totalfxamount-=$serfxcopayqty;
			    $totalfxser-=$serfxcopayqty;
			  ?>
             
				<?php }?>
			  
			  <?php }
			  ?>
              <!--copay-->
              <?php 
					
					//$totalser=0;
			  $query21 = "select * from consultation_services where servicesitemcode  IN (SELECT servicesitemcode FROM billing_paynowservices WHERE patientvisitcode='$visitcode' and patientcode='$patientcode') AND patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> ''   and  paymentstatus = 'completed'  group by servicesitemcode";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res21 = mysqli_fetch_array($exec21))
			{
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			$serrate=$res21['servicesitemrate'];
			$sercode=$res21['servicesitemcode'];
			$serref=$res21['refno'];
			
			$query2111 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' ";//and approvalstatus <> '2' and approvalstatus = '1'";
			$exec2111 = mysqli_query($GLOBALS["___mysqli_ston"], $query2111) or die ("Error in Query2111".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numrow2111 = mysqli_num_rows($exec2111);
			$resqty = mysqli_fetch_array($exec2111);
			$serqty=$resqty['serviceqty'];
			$serrefqty=$resqty['refundquantity'];
			
			$serqty = $serqty-$serrefqty;
			$totserrate=$resqty['amount'];
		    $perrate=$resqty['servicesitemrate'];
			//$totserrate=$serrate*$serqty;
			
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$copay=(($serrate*$serqty)/100)*$planpercentage;
			$copaysingle=($serrate/100)*$planpercentage;
		 	$copayperservice=$copay/$serqty;
			$totamt=$perrate*$serqty;
			$serfxrate=($perrate*$fxrate);
			$serfxcopay=$copaysingle*$fxrate;
			$serfxcopayqty=$serfxcopay*$serqty;
			$serfxrateqty = $serfxrate*$serqty;
			$totserrate=$totamt;
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
			//$totalser=$totalser+$totserrate;
			?>
             <?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			   
				$serratetot=$serrate;
				//$totalser=$totalser+$serratetot; 
				$totserrate = $totamt-$copay;
				$totalser=$totalser+$totamt;
				
				$totalcopayser=$totalcopayser+$copay;
				$totalfxcopay=$totalfxcopay+$serfxcopayqty;
				$totalfxamount=$totalfxamount+$serfxrateqty;
				$totalfxser=$totalfxser+$serfxrateqty;
				$totalfxcopayser=$totalfxcopayser+$serfxcopayqty;
			   }
			   else if(($planpercentage!=0.00)&&($planforall==''))
			  { 
			    $serratetot=$serrate;
				//$totamt=$perrate*$numrow2111;
			    $totalser=$totalser+$totamt; 
				//$totalcopayser=$totalcopayser+$copay;
				$totalfxcopay=$totalfxcopay+$serfxcopayqty;
				$totalfxamount=$totalfxamount+$serfxrateqty;
				$totalfxser=$totalfxser+$serfxrateqty;
				$totalfxcopayser=$totalfxcopayser+$serfxcopayqty;
			   }
			   
			   else
			  {
				   $serratetot=$serrate;
				  	$totalser=$totalser+$totamt;
				  	$totalfxamount=$totalfxamount+$serfxrateqty;
					$totalfxser=$totalfxser+$serfxrateqty;
				}
			  ?>
			 
              <?php if(($planpercentage!=0.00)&&($planforall=='yes')){ $totalcopay=$totalcopay+$copay;  $copayperser=$copay/$serqty;
			  $totalfxamount-=$serfxcopayqty;
			  			  $totalfxser-=$serfxcopayqty;
	
			  ?>
              
				<?php }?>
			  
			  <?php
			   }
			  
			  ?>
			  <?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes')){ 
			  $consultationtotal=$totalop-$totalcopayconsult+$consultationrefund-$totalcopayfixedamount;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			  }
			 else if(($planpercentage!=0.00)&&($planforall=='')){
			  $consultationtotal=$totalop-$totalcopayconsult+$consultationrefund-$totalcopayfixedamount;
			  $consultationtotal=number_format($consultationtotal,2,'.','');
			  }
			  else{
			  $consultationtotal=$totalop-$totalcopayconsult+$consultationrefund-$totalcopayfixedamount;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			  }
			  ?>
			  <?php
			  }   //for checking whether patient finalized
			  ?>
			 
          </tbody>
        </table>		
		</td>
		<tr>
		<td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="5" cellpadding="5" width="99%" 
            align="left" border="0">
          <tbody id="foo">
		  <tr bgcolor="#CCC">
		  <td align="left" class="bodytext3"><strong>Transactions</strong></td>
		  <td align="center" class="bodytext3"><strong>Amount</strong></td>
		  <td align="center" class="bodytext3"><strong>Discount Percent</strong></td>
		  <td align="center" class="bodytext3"><strong>Discount Amt</strong></td>
		  <td align="center" class="bodytext3"><strong>Nett Amount</strong></td>
		  </tr>
		  <tr>
		  <td align="left" class="bodytext3"><strong>Consultation</strong></td>
		  <td align="center" class="bodytext3"><input type="text" class="bali" name="consultation" id="consultation" readonly value="<?php echo number_format($consultationtotal,2,'.',''); ?>"></td>
		  <td align="center" class="bodytext3"><input type="text" name="consult_weiverpercent" id="consult_weiverpercent" size="5" onKeyUp="return WeiverCalc('consult',this.value);"></td>
		  <td align="center" class="bodytext3"><input type="text" class="bali" name="consult_weiveramount" id="consult_weiveramount"  size="10" onKeyUp="return WeiverCalcamt('consult',this.value);"></td>
		  <td align="center" class="bodytext3"><input type="text" class="bali" name="consult_weivernett" id="consult_weivernett" readonly></td>
		  </tr>
		  <tr>
		  <td align="left" class="bodytext3"><strong>Pharmacy</strong></td>
		  <td align="center" class="bodytext3"><input type="text" class="bali" name="pharmacy" id="pharmacy" readonly value="<?php echo number_format($totalpharm-$totalcopaypharm,2,'.',''); ?>"></td>
		  <td align="center" class="bodytext3"><input type="text" name="pharmacy_weiverpercent" id="pharmacy_weiverpercent" size="5" onKeyUp="return WeiverCalc('pharmacy',this.value);"></td>
		  <td align="center" class="bodytext3"><input type="text" class="bali" name="pharmacy_weiveramount" id="pharmacy_weiveramount"  onKeyUp="return WeiverCalcamt('pharmacy',this.value);" size="10"></td>
		  <td align="center" class="bodytext3"><input type="text" class="bali" name="pharmacy_weivernett" id="pharmacy_weivernett" readonly ></td>
		  </tr>
		  <tr>
		  <td align="left" class="bodytext3"><strong>Lab</strong></td>
		  <td align="center" class="bodytext3"><input type="text" class="bali" name="lab" id="lab" readonly value="<?php echo number_format($totallab-$totalcopaylab,2,'.',''); ?>"></td>
		  <td align="center" class="bodytext3"><input type="text" name="lab_weiverpercent" id="lab_weiverpercent" size="5" onKeyUp="return WeiverCalc('lab',this.value);"></td>
		  <td align="center" class="bodytext3"><input type="text" class="bali" name="lab_weiveramount" id="lab_weiveramount" onKeyUp="return WeiverCalcamt('lab',this.value);" size="10"></td>
		  <td align="center" class="bodytext3"><input type="text" class="bali" name="lab_weivernett" id="lab_weivernett" readonly></td>
		  </tr>
		  <tr>
		  <td align="left" class="bodytext3"><strong>Radiology</strong></td>
		  <td align="center" class="bodytext3"><input type="text" class="bali" name="radiology" id="radiology" readonly value="<?php echo number_format($totalrad-$totalcopayrad,2,'.',''); ?>"></td>
		  <td align="center" class="bodytext3"><input type="text" name="radiology_weiverpercent" id="radiology_weiverpercent" size="5" onKeyUp="return WeiverCalc('radiology',this.value);"></td>
		  <td align="center" class="bodytext3"><input type="text" class="bali" name="radiology_weiveramount" id="radiology_weiveramount" onKeyUp="return WeiverCalcamt('radiology',this.value);" size="10"></td>
		  <td align="center" class="bodytext3"><input type="text" class="bali" name="radiology_weivernett" id="radiology_weivernett" readonly ></td>
		  </tr>
		  <tr>
		  <td align="left" class="bodytext3"><strong>Services</strong></td>
		  <td align="center" class="bodytext3"><input type="text" class="bali" name="services" id="services" readonly value="<?php echo number_format($totalser-$totalcopayser,2,'.',''); ?>"></td>
		  <td align="center" class="bodytext3"><input type="text" name="services_weiverpercent" id="services_weiverpercent" size="5" onKeyUp="return WeiverCalc('services',this.value);"></td>
		  <td align="center" class="bodytext3"><input type="text" class="bali" name="services_weiveramount" id="services_weiveramount" onKeyUp="return WeiverCalcamt('services',this.value);" size="10"></td>
		  <td align="center" class="bodytext3"><input type="text" class="bali" name="services_weivernett" id="services_weivernett" readonly ></td>
		  </tr>
		  <tr bgcolor="#ecf0f5">
		 <td align="left">&nbsp;</td>
		 <td align="left">&nbsp;</td>
		 <td align="right" class="bodytext3"><font color='red' >*Remarks</font></td>
		 <td align="left"><input type="text" name="remarks" id="remarks" /></td>
		 <td align="center" valign="middle" class="bodytext3">
		<input type="hidden" name="frm1submit1" value="frm1submit1" />
		<input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
		<input name="Submit222" type="submit" value="Submit" class="button"/>
		</td>		 
        </tr>	
         
				  </tbody>
				  </table>				 
				   </td>
				   </tr>
    </table>

</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>
