<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");  
$entrydate = date("Y-m-d");  
$timeonly = date("H:i:s");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];

$query1111 = "select * from master_employee where username = '$username'";
			$exec1111 = mysqli_query($GLOBALS["___mysqli_ston"], $query1111) or die ("Error in Query1111".mysqli_error($GLOBALS["___mysqli_ston"]));
			 while ($res1111 = mysqli_fetch_array($exec1111))
			 {
			   $locationnumber = $res1111["location"];
			   $query1112 = "select * from master_location where auto_number = '$locationnumber' and status<>'deleted'";
				$exec1112 = mysqli_query($GLOBALS["___mysqli_ston"], $query1112) or die ("Error in Query1112".mysqli_error($GLOBALS["___mysqli_ston"]));
			 while ($res1112 = mysqli_fetch_array($exec1112))
			 {
			   $locationname = $res1112["locationname"];    
				$locationcode = $res1112["locationcode"];
			 }
			 }

			
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }

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
	$locationcode = $_REQUEST['locationcodeget'];
	$locationname = $_REQUEST['locationnameget'];
	
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

	$consultation = 0;
	$consult_weiverpercent = 0;
	$consult_weiveramount = 0;
	
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
	
	$query66 = "SELECT visitcode FROM patientweivers where visitcode = '$visitcode'";
	$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
	$row66 = mysqli_num_rows($exec66);
	if($row66 == 0 || $row66 == 1)
	{
		$query67 = "INSERT INTO `patientweivers`(`docno`, `patientcode`, `visitcode`, `patientname`, `billtype`, `accountnameid`, `accountnameano`, `accountname`, `consultation`, 
		`consult_percent`, `consult_discamount`, `pharmacy`, `pharmacy_percent`, `pharmacy_discamount`, `lab`, `lab_percent`, `lab_discamount`, `radiology`, `radiology_percent`, 
		`radiology_discamount`, `services`, `services_percent`, `services_discamount`, `locationcode`, `locationname`, `username`, `ipaddress`, `updatedatetime`, `entrydate`,`remarks`) 
		VALUES('$billnumbercode','$patientcode','$visitcode','$patientname','$billtype','$accountcode','$accountnameano','$accountname','$consultation',
		'$consult_weiverpercent','$consult_weiveramount','$pharmacy','$pharmacy_weiverpercent','$pharmacy_weiveramount','$lab','$lab_weiverpercent','$lab_weiveramount','$radiology','$radiology_weiverpercent',
		'$radiology_weiveramount','$services','$services_weiverpercent','$services_weiveramount','$locationcode','$locationname','$username','$ipaddress','$updatedatetime','$entrydate','$remarks')";
		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die ("Error in Query67".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	
	header("location:patientweiverslist.php?st=success");	
}


//to redirect if there is no entry in masters category or item or customer or settings



//To get default tax from autoitemsearch1.php and autoitemsearch2.php - for CST tax override.
if (isset($_REQUEST["defaulttax"])) { $defaulttax = $_REQUEST["defaulttax"]; } else { $defaulttax = ""; }
if(isset($_REQUEST['delete']))
{

}



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


//This include updatation takes too long to load for hunge items database.


//To populate the autocompetelist_services1.js


//To verify the edition and manage the count of bills.
$thismonth = date('Y-m-');
$query77 = "select * from master_edition where status = 'ACTIVE'";
$exec77 =  mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
$res77 = mysqli_fetch_array($exec77);
$res77allowed = $res77["allowed"];




/*
$query99 = "select count(auto_number) as cntanum from master_quotation where quotationdate like '$thismonth%'";
$exec99 = mysql_query($query99) or die ("Error in Query99".mysql_error());
$res99 = mysql_fetch_array($exec99);
$res99cntanum = $res99["cntanum"];
$totalbillandquote = $res88cntanum + $res99cntanum; //total of bill and quote in current month.
if ($totalbillandquote > $res77allowed)
{
	//header ("location:usagelimit1.php"); // redirecting.
	//exit;
}
*/

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
$patientpaymenttype = $execlab['billtype'];


$patienttype=$execlab['maintype'];
$querytype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_paymenttype where auto_number='$patienttype'");
$exectype=mysqli_fetch_array($querytype);
$patienttype1=$exectype['paymenttype'];
$patientsubtype=$execlab['subtype'];
$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$patientsubtype'");
$execsubtype=mysqli_fetch_array($querysubtype);
$patientsubtype1=$execsubtype['subtype'];
$currency=$execsubtype['currency'];
//$fxrate=$execsubtype['fxrate'];
if($currency=='')
{
	$currency='UGX';
}
if($currency != 'UGX')
{
	$query = mysqli_query($GLOBALS["___mysqli_ston"], "select rate from master_currency where currency = '$currency'");
	$res = mysqli_fetch_array($query);
	$num = mysqli_num_rows($query);
	if($num > 0){
	$currconvertrate = $res['rate'];
	$fxrate= $res['rate'];
	} else {
	$currconvertrate = '1';
	$fxrate= '1';
	}
}

?>
<?php
$querylab1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$execlab1=mysqli_fetch_array($querylab1);
 $patientname=$execlab1['customerfullname'];
 
 $patientfirstname=$execlab1['customername'];
 $patientmiddlename=$execlab1['customermiddlename'];
 $patientlastname=$execlab1['customerlastname'];
 
$patientaccount=$execlab1['accountname'];

//location get here
 $locationcode=$execlab1['locationcode'];
//get locationname from location code
$querylab2=mysqli_query($GLOBALS["___mysqli_ston"], "select locationname from master_location where locationcode='".$locationcode."'");
$execlab2=mysqli_fetch_array($querylab2);
 $locationname=$execlab2['locationname'];


$querylab2=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_accountname where auto_number='$patientaccount'");
$execlab2=mysqli_fetch_array($querylab2);
$patientaccount1=$execlab2['accountname'];
$accountcode = $execlab2['id'];
$accountnameano = $execlab2['auto_number'];

$query76 = "select * from master_financialintegration where field='labpaynow'";
$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res76 = mysqli_fetch_array($exec76);
$labcoa = $res76['code'];

$query761 = "select * from master_financialintegration where field='radiologypaynow'";
$exec761 = mysqli_query($GLOBALS["___mysqli_ston"], $query761) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res761 = mysqli_fetch_array($exec761);

$radiologycoa = $res761['code'];

$query762 = "select * from master_financialintegration where field='servicepaynow'";
$exec762 = mysqli_query($GLOBALS["___mysqli_ston"], $query762) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res762 = mysqli_fetch_array($exec762);

$servicecoa = $res762['code'];

$query763 = "select * from master_financialintegration where field='referalpaynow'";
$exec763 = mysqli_query($GLOBALS["___mysqli_ston"], $query763) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res763 = mysqli_fetch_array($exec763);

$referalcoa = $res763['code'];

$query764 = "select * from master_financialintegration where field='pharmacypaynow'";
$exec764 = mysqli_query($GLOBALS["___mysqli_ston"], $query764) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res764 = mysqli_fetch_array($exec764);

$pharmacycoa = $res764['code'];

$query765 = "select * from master_financialintegration where field='cashpaynow'";
$exec765 = mysqli_query($GLOBALS["___mysqli_ston"], $query765) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res765= mysqli_fetch_array($exec765);

$cashcoa = $res765['code'];


$query766 = "select * from master_financialintegration where field='chequepaynow'";
$exec766 = mysqli_query($GLOBALS["___mysqli_ston"], $query766) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res766 = mysqli_fetch_array($exec766);

$chequecoa = $res766['code'];


$query767 = "select * from master_financialintegration where field='mpesapaynow'";
$exec767 = mysqli_query($GLOBALS["___mysqli_ston"], $query767) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res767 = mysqli_fetch_array($exec767);

$mpesacoa = $res767['code'];

$query768 = "select * from master_financialintegration where field='cardpaynow'";
$exec768 = mysqli_query($GLOBALS["___mysqli_ston"], $query768) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res768 = mysqli_fetch_array($exec768);

$cardcoa = $res768['code'];

$query769 = "select * from master_financialintegration where field='onlinepaynow'";
$exec769 = mysqli_query($GLOBALS["___mysqli_ston"], $query769) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res769 = mysqli_fetch_array($exec769);

$onlinecoa = $res769['code'];

$querylab2=mysqli_query($GLOBALS["___mysqli_ston"], "select locationcode from master_visitentry where visitcode='$visitcode'");
$execlab2=mysqli_fetch_array($querylab2);

 $locationcode=$execlab2['locationcode'];
$query768 = "select locationname from master_location where locationcode='$locationcode'";
$exec768 = mysqli_query($GLOBALS["___mysqli_ston"], $query768) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res768 = mysqli_fetch_array($exec768);

 $locationname = $res768['locationname'];


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

$query3 = "select count(auto_number) as counts from billing_pharmacy where patientcode = '".$patientcode."' AND patientvisitcode='".$visitcode."'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$dispensingcount = $res3['counts'];

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

	funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	funcPopupPrintFunctionCall();
	//alert ("Auto Print Function Runs Here.");	
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
	//alert ("Auto Print Function Runs Here.");
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
	//alert(varBillNumber);
	var varBillAutoNumber ="<?php //echo $previousbillautonumber; ?>" ;
	//alert(varBillAutoNumber);
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
		window.open("print_paynow.php?printsource=billpage&&billautonumber="+varBillNumber+"","OriginalWindowA4<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	}
	if (varPaperSize == "A5")
	{
		window.open("print_paynow_a5.php?printsource=billpage&&billautonumber="+varBillNumber+"","OriginalWindowA5<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	}
}

function cashentryonfocus1()
{
	if (document.getElementById("cashgivenbycustomer").value == "0.00")
	{
		document.getElementById("cashgivenbycustomer").value = "";
		document.getElementById("cashgivenbycustomer").focus();
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
		window.location="billing_paynow.php?defaulttax="+varDefaultTax+"&&delbillst=<?php echo $delBillSt; ?>&&delbillautonumber="+<?php echo $delBillAutonumber; ?>+"&&delbillnumber="+<?php echo $delBillNumber; ?>+"";
		<?php
		}
		else
		{
		?>
		window.location="billing_paynow.php?defaulttax="+varDefaultTax+"";
		<?php
		}
		?>
	}
	else
	{
		window.location="billing_paynow.php";
	}
	//return false;
}



</script>
<?php include ("js/sales1scripting_new.php"); ?>
<script type="text/javascript" src="js/insertitemcurrencyfx.js"></script>

<script type="text/javascript" src="js/insertnewitem7.js"></script>
<style type="text/css">
.bodytext3 {
	FONT-WEIGHT: normal;
	FONT-SIZE: 11px;
	/* [disabled]COLOR: #3B3B3C; */
	FONT-FAMILY: Tahoma
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
.style1 {
	font-size: 36px;
	font-weight: bold;
}
.style2 {
	font-size: 18px;
	font-weight: bold;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
.bali{ text-align:right; }
</style>

<script src="js/datetimepicker_css.js"></script>

<script>
function funcSaveBill13()
{
	if(document.getElementById("pharmacy_weiveramount").value == "" && document.getElementById("lab_weiveramount").value == "" && document.getElementById("radiology_weiveramount").value == "" && document.getElementById("services_weiveramount").value == "")
	{
		alert("Enter Discount Percent or Discount amount");
		document.getElementById("pharmacy_weiveramount").focus();
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
</head>
<script type="text/javascript">
function WeiverCalc(id, val)
{
	var val = val;
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
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body>
<form name="frmsales" id="frmsales" method="post" action="patientweivers_paynow.php" onSubmit="return funcSaveBill13()">
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
                <tr >
                <td colspan="6" bgcolor="#ecf0f5" class="bodytext32"><strong>Pay Now Patient Details</strong></td>
                
                <td  bgcolor="#ecf0f5" class="bodytext32"><strong>Location:&nbsp;&nbsp;<?php echo $locationname ?> </strong></td>
                 <input type="hidden" name="locationcodeget" value="<?php echo $locationcode;?>">
                <input type="hidden" name="locationnameget" value="<?php echo $locationname;?>">
			 </tr>
			 <?php
			 if (isset($_REQUEST["src"])) { $src = $_REQUEST["src"]; } else { $src = ""; }
			 if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
				//$st = $_REQUEST["st"];
				
     		 if (isset($_REQUEST["billnumber"])) { $previousbillnumber = $_REQUEST["billnumber"]; } else { $previousbillnumber = ""; }
			if ($st == 'success' && $billautonumber != '')
			{
			?>
            <tr>
             
              <td colspan="8"  align="left" valign="center" bgcolor="#FFFF00" class="bodytext31">&nbsp;
			  * Success. Bill Saved. &nbsp;&nbsp;&nbsp;
			  <input name="billprint" type="button" onClick="return loadprintpage3()" value="Click Here To Print Invoice" class="button" style="border: 1px solid #001E6A"/>			  </td>
            </tr>
			<?php
			}
			?>
		<tr>
                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
			 </tr>
			  <tr>
			    <td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient  </strong></td>
                <td width="20%" align="left" valign="top" class="bodytext3"><?php echo $patientname; ?>
				<input type="hidden" name="patientname" id="customer" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/>                  
                <input type="hidden" name="patientfirstname" value="<?php echo $patientfirstname;?>">
                <input type="hidden" name="patientmiddlename" value="<?php echo $patientmiddlename;?>">
                <input type="hidden" name="patientlastname" value="<?php echo $patientlastname;?>">
                </td>
                 
                <td width="17%" align="left" valign="top" class="bodytext3"><strong>Reg.No</strong></td>
                <td width="15%" align="left" valign="top" class="bodytext3"><?php echo $patientcode; ?></td>
                <td width="15%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code</strong></td>
                <td width="22%" colspan="3" align="left" valign="middle" class="bodytext3">
				<input type="hidden" name="billno" id="billno" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input type="hidden" name="paymenttype" id="paymenttype" value="<?php echo $patienttype1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
				<input type="hidden" name="subtype" id="subtype" value="<?php echo $patientsubtype1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>			<?php echo $visitcode; ?></td>
		      </tr>
			   <tr>
			    <td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Bill No</strong></td>
                <td align="left" valign="top" class="bodytext3">
				<input type="hidden" name="customercode" id="customercode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input type="hidden" name="labcoa" value="<?php echo $labcoa; ?>">
				<input type="hidden" name="radiologycoa" value="<?php echo $radiologycoa; ?>">
				<input type="hidden" name="servicecoa" value="<?php echo $servicecoa; ?>">
				<input type="hidden" name="pharmacycoa" value="<?php echo $pharmacycoa; ?>">
				<input type="hidden" name="referalcoa" value="<?php echo $referalcoa; ?>">
				<input type="hidden" name="cashcoa" value="<?php echo $cashcoa; ?>">
				<input type="hidden" name="chequecoa" value="<?php echo $chequecoa; ?>">
				<input type="hidden" name="mpesacoa" value="<?php echo $mpesacoa; ?>">
				<input type="hidden" name="cardcoa" value="<?php echo $cardcoa; ?>">
				<input type="hidden" name="onlinecoa" value="<?php echo $onlinecoa; ?>">
                <input type="hidden" name="patientage" value="<?php echo $patientage; ?>">
                <input type="hidden" name="patientgender" value="<?php echo $patientgender; ?>">
				<?php echo $billnumbercode; ?>
				
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
				    <td align="left" valign="top" class="bodytext3"><strong>Bill Date</strong></td>
				    <td align="left" valign="top" class="bodytext3"><?php echo $dateonly; ?></td>
				    <td width="15%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3">
				<input type="hidden" name="billdate" id="billdate" value="<?php echo $dateonly; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				<?php echo $patientaccount1; ?></td>
              	<input type="hidden" name="accountname" id="accountname" value="<?php echo $patientaccount1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
				<input type="hidden" name="accountcode" id="accountcode" value="<?php echo $accountcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
				<input type="hidden" name="accountnameano" id="accountnameano" value="<?php echo $accountnameano; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				
			  </tr>
				 	<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>								<input type="hidden" name="accountname" id="account" value="<?php echo $patientaccount1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				
				 
                  <input type="hidden" name="account" id="account" value="<?php echo $patientplan1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>			
				  <input type="hidden" name="fxrate" id="fxrate" value="<?php echo $fxrate; ?>">
				   <input type="hidden" name="billtype" id="billtype" value="<?php echo 'PAY NOW'; ?>">
				  	<tr>
                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
			 </tr>
            </tbody>
        </table>
   </td>
      </tr>
	  
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
          	 <?php 
			  $totallab=0;
			  $query19 = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending' and approvalstatus !='0' ";
			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res19 = mysqli_fetch_array($exec19))
			{
			$labdate=$res19['consultationdate'];
			$labname=$res19['labitemname'];
			$labrate=$res19['labitemrate'];
			$labcode=$res19['labitemcode'];
			$labrefno=$res19['refno'];
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
			$totallab=$totallab+$labrate; 
			
		   }
			 
		
			   $totalpharm=0;
			   $pharmno=0;
			$query23 = "select * from master_consultationpharm where patientvisitcode='$visitcode' and patientcode='$patientcode' and pharmacybill='pending' and medicineissue='pending' and billing='' and approvalstatus !='0' and (amendstatus='1' OR amendstatus=2)";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$pharmtotalno=mysqli_num_rows($exec23);
			while($res23 = mysqli_fetch_array($exec23))
			{
			$phadate=$res23['recorddate'];
			$phaname=$res23['medicinename'];
			$phaquantity=$res23['quantity'];
			$pharate=$res23['rate'];
			
			if($pharate=='0.00'){
				$query77="select rateperunit from master_medicine where itemname='$phaname'";
				$exec77=mysqli_query($GLOBALS["___mysqli_ston"], $query77);
				$res77=mysqli_fetch_array($exec77);
				$pharate=$res77['rateperunit'];
			}
	
			$amendstatus=$res23['amendstatus'];
			if($amendstatus=='2')
			{
			$phaamount=$phaquantity * $pharate;
			}
			$pharefno=$res23['refno'];
			$billtype=$res23['billtype'];
			$excludestatus=$res23['excludestatus'];
			$excludebill = $res23['excludebill'];
			$approvalstatus = $res23['approvalstatus'];
			if($billtype == 'PAY LATER')
			{
			if(($excludestatus == 'excluded')&&($excludebill == '') || $approvalstatus=='2')
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
			$totalpharm=$totalpharm+$phaamount;
			
			 }
			  }
			  if($billtype == 'PAY NOW')
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
			$totalpharm=$totalpharm+$phaamount;
			$pharmno=$pharmno+1;
			
			  }
			  }
			  
			  ?>
			  
			    <?php 
				$totalrad=0;
			  $query20 = "select * from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending' and approvalstatus !='0' ";
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res20 = mysqli_fetch_array($exec20))
			{
			$raddate=$res20['consultationdate'];
			$radname=$res20['radiologyitemname'];
			$radrate=$res20['radiologyitemrate'];
			$radref=$res20['refno'];
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
			$totalrad=$totalrad+$radrate;
			}
			
			$totalser=0;
			$query21 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending' and approvalstatus !='0' group by servicesitemcode";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res21 = mysqli_fetch_array($exec21))
			{
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			$sercode=$res21['servicesitemcode'];
			 $serrate=$res21['servicesitemrate'];
			$serref=$res21['refno'];
			
			 $quantity=$res21['serviceqty'];
			 $totserrate=$res21['amount'];
			
			$query2111 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' and paymentstatus='pending' and approvalstatus !='0'";
			$exec2111 = mysqli_query($GLOBALS["___mysqli_ston"], $query2111) or die ("Error in Query2111".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numrow2111 = mysqli_num_rows($exec2111);
			
			
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
			$totalser=$totalser+$totserrate;
			}
			 
			  $overalltotal=($totalop+$totallab+$totalpharm+$totalrad+$totalser+$totalampref+$totalhomref+$totalconref+$totalref+$totaldepartmentref+$dispensingfee)-$totalcopay;
			  $overalltotal=number_format($overalltotal,2,'.','');
			  $consultationtotal=$totalop-$totalcopay;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $consultationtotal+$totallab+$totalpharm+$totalrad+$totalser+$totalref+$totaldepartmentref+$dispensingfee;
			   $netpay=number_format($netpay,2,'.','');
			   $totalamount=$overalltotal;
			  ?>
          </tbody>
        </table>		
		</td>
		</tr>
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
		  <td align="left" class="bodytext3"><strong>Pharmacy</strong></td>
		  <td align="center" class="bodytext3"><input type="text" class="bali" name="pharmacy" id="pharmacy" readonly value="<?php echo number_format($totalpharm,2,'.',''); ?>"></td>
		  <td align="center" class="bodytext3"><input type="text" name="pharmacy_weiverpercent" id="pharmacy_weiverpercent" size="5" onKeyUp="return WeiverCalc('pharmacy',this.value);"></td>
		  <td align="center" class="bodytext3"><input type="text" class="bali" name="pharmacy_weiveramount" id="pharmacy_weiveramount" onKeyUp="return WeiverCalcamt('pharmacy',this.value);" size="10"></td>
		  <td align="center" class="bodytext3"><input type="text" class="bali" name="pharmacy_weivernett" id="pharmacy_weivernett" readonly ></td>
		  </tr>
		  <tr>
		  <td align="left" class="bodytext3"><strong>Lab</strong></td>
		  <td align="center" class="bodytext3"><input type="text" class="bali" name="lab" id="lab" readonly value="<?php echo number_format($totallab,2,'.',''); ?>"></td>
		  <td align="center" class="bodytext3"><input type="text" name="lab_weiverpercent" id="lab_weiverpercent" size="5" onKeyUp="return WeiverCalc('lab',this.value);"></td>
		  <td align="center" class="bodytext3"><input type="text" class="bali" name="lab_weiveramount" id="lab_weiveramount" onKeyUp="return WeiverCalcamt('lab',this.value);" size="10"></td>
		  <td align="center" class="bodytext3"><input type="text" class="bali" name="lab_weivernett" id="lab_weivernett" readonly></td>
		  </tr>
		  <tr>
		  <td align="left" class="bodytext3"><strong>Radiology</strong></td>
		  <td align="center" class="bodytext3"><input type="text" class="bali" name="radiology" id="radiology" readonly value="<?php echo number_format($totalrad,2,'.',''); ?>"></td>
		  <td align="center" class="bodytext3"><input type="text" name="radiology_weiverpercent" id="radiology_weiverpercent" size="5" onKeyUp="return WeiverCalc('radiology',this.value);"></td>
		  <td align="center" class="bodytext3"><input type="text" class="bali" name="radiology_weiveramount" id="radiology_weiveramount" onKeyUp="return WeiverCalcamt('radiology',this.value);" size="10"></td>
		  <td align="center" class="bodytext3"><input type="text" class="bali" name="radiology_weivernett" id="radiology_weivernett" readonly ></td>
		  </tr>
		  <tr>
		  <td align="left" class="bodytext3"><strong>Services</strong></td>
		  <td align="center" class="bodytext3"><input type="text" class="bali" name="services" id="services" readonly value="<?php echo number_format($totalser,2,'.',''); ?>"></td>
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