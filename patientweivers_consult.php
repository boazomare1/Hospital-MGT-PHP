 <?php
session_start();
error_reporting(0);
include ("includes/loginverify.php");
include ("db/db_connect.php");


$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$entrydate = date("Y-m-d");
$timeonly = date("H:i:s");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$errmsg = 0;

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
 
$titlestr = 'SALES BILL';
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
//	$balanceamt = $_REQUEST["balanceamt"];
	
	$patientcode = $_REQUEST["customercode"];
	$visitcode = $_REQUEST["visitcode"];
	$patientname = $_REQUEST['customername'];
	$patientfirstname = $_REQUEST['patientfirstname'];
	$patientmiddlename=$_REQUEST['patientmiddlename'];
	$patientlastname = $_REQUEST["patientlastname"];
	$patientname = $patientfirstname.' '.$patientmiddlename.' '.$patientlastname;
	$locationcode = $_REQUEST['locationcode'];
	$locationname = $_REQUEST['locationname'];
	$billtype = $_REQUEST['patientbilltype'];
		
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

	$accountnameano = $_REQUEST['accountnameano'];
	$accountcode = $_REQUEST['accountcode'];
	$accountname = $_REQUEST['accountname'];
	$consultation = $_REQUEST['consultation'];
	$consult_weiverpercent = $_REQUEST['consult_weiverpercent'];
	$consult_weiveramount = $_REQUEST['consult_weiveramount'];

	$query66 = "SELECT visitcode FROM patientweivers where visitcode = '$visitcode'";
	$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
	$row66 = mysqli_num_rows($exec66);
	if($row66 == 0)
	{
		$query67 = "INSERT INTO `patientweivers`(`docno`, `patientcode`, `visitcode`, `patientname`, `billtype`, `accountnameid`, `accountnameano`, `accountname`, `consultation`, 
		`consult_percent`, `consult_discamount`, `locationcode`, `locationname`, `username`, `ipaddress`, `updatedatetime`, `entrydate`,`remarks`) 
		VALUES('$billnumbercode','$patientcode','$visitcode','$patientname','$billtype','$accountcode','$accountnameano','$accountname','$consultation',
		'$consult_weiverpercent','$consult_weiveramount','$locationcode','$locationname','$username','$ipaddress','$updatedatetime','$entrydate','$remarks')";
		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die ("Error in Query67".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	
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


//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_customer1.php");
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
 
 
?>
<?php
$querylab1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'");
$execlab1=mysqli_fetch_array($querylab1);
$patientname=$execlab1['patientfullname'];
$patientfirstname = $execlab1['patientfirstname'];
	$patientmiddlename=$execlab1['patientmiddlename'];
	$patientlastname = $execlab1["patientlastname"];
	$locationcode=$execlab1['locationcode'];
$patientaccount=$execlab1['accountname'];
$patientbilltype = $execlab1['billtype'];

$planpercentage = $execlab1["planpercentage"];
//echo $planpercentage;
$planfixedamount = $execlab1["planfixedamount"]; 

$query5 = "select * from master_accountname where auto_number = '$patientaccount'";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res5 = mysqli_fetch_array($exec5);
$accountname = $res5['accountname'];
$accountcode= $res5['id'];
$accountnameano=$res5['auto_number'];
$plan=$execlab1['planname'];
$type=$execlab1['paymenttype'];
$subtype=$execlab1['subtype'];
$opdate=$execlab1['consultationdate'];
$consultationfees  = $execlab1["consultationfees"];
$billamount = $consultationfees;
$billentryby = strtoupper($username);
$consultationtype = $execlab1['consultationtype'];
$query26 = "select * from master_consultationtype where auto_number = '$consultationtype'";
$exec26 = mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res26 = mysqli_fetch_array($exec26);
$consultationtypes = $res26['consultationtype'];


$consultingdoctor= $execlab1['consultingdoctor'];
//echo $consultingdoctoranum;



$departmentanum = $execlab1['department'];
//echo $departmentanum;

$query5 = "select * from master_department where auto_number = '$departmentanum'";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res5 = mysqli_fetch_array($exec5);
$department = $res5['department'];

//echo $department;

$query45="select * from master_planname where auto_number='$plan'";
$exec45=mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res45=mysqli_fetch_array($exec45);
$planname=$res45['planname'];



$query46="select * from master_paymenttype where auto_number='$type'";
$exec46=mysqli_query($GLOBALS["___mysqli_ston"], $query46) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res46=mysqli_fetch_array($exec46);
$paymenttype=$res46['paymenttype'];

$query47="select * from master_subtype where auto_number='$subtype'";
$exec47=mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res47=mysqli_fetch_array($exec47);
$subtype=$res47['subtype'];
$fxrate = $res47['fxrate'];
$currency = $res47['currency'];

$query76 = "select * from master_financialintegration where field='consultationfee'";
$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res76 = mysqli_fetch_array($exec76);
$consultationcoa = $res76['code'];

$query761 = "select * from master_financialintegration where field='copay'";
$exec761 = mysqli_query($GLOBALS["___mysqli_ston"], $query761) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res761 = mysqli_fetch_array($exec761);

$copaycoa = $res761['code'];

$query765 = "select * from master_financialintegration where field='cashconsultation'";
$exec765 = mysqli_query($GLOBALS["___mysqli_ston"], $query765) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res765= mysqli_fetch_array($exec765);

$cashcoa = $res765['code'];


$query766 = "select * from master_financialintegration where field='chequeconsultation'";
$exec766 = mysqli_query($GLOBALS["___mysqli_ston"], $query766) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res766 = mysqli_fetch_array($exec766);

$chequecoa = $res766['code'];


$query767 = "select * from master_financialintegration where field='mpesaconsultation'";
$exec767 = mysqli_query($GLOBALS["___mysqli_ston"], $query767) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res767 = mysqli_fetch_array($exec767);

$mpesacoa = $res767['code'];

$query768 = "select * from master_financialintegration where field='cardconsultation'";
$exec768 = mysqli_query($GLOBALS["___mysqli_ston"], $query768) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res768 = mysqli_fetch_array($exec768);

$cardcoa = $res768['code'];

$query769 = "select * from master_financialintegration where field='onlineconsultation'";
$exec769 = mysqli_query($GLOBALS["___mysqli_ston"], $query769) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res769 = mysqli_fetch_array($exec769);

$onlinecoa = $res769['code'];


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
?>
<?php 
if($patientbilltype == 'PAY NOW')
{
	$billamountpatient = $billamount;
	$billamountpatient = number_format($billamountpatient,2,'.','');
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

if($currency != 'UGX')
{
	$query = mysqli_query($GLOBALS["___mysqli_ston"], "select rate from master_currency where currency = '$currency'");
	$res = mysqli_fetch_array($query);
	$num = mysqli_num_rows($query);
	if($num > 0){
	$rate = $res['rate'];
	} else {
	$rate = '1';
	}
	
	$billamountpatient = $billamountpatient * $rate;
	$billamountpatient = number_format($billamountpatient,2,'.','');
}

?>
<style>
.bali{ text-align:right; }
</style>
<script>
function printConsultationBill()
 {
var popWin; 
popWin = window.open("print_consultationbill_dmp4inch1.php?patientcode=<?php echo $patientcode; ?>&&billautonumber=<?php echo $billnumbercode; ?>","OriginalWindowA4",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
 }
</script>

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

<?php //include ("js/sales1scripting_new.php"); ?>
<script type="text/javascript">

function quickprintbill2sales()
{
   
	var varBillNumber1 = document.getElementById("quickprintbill").value;
	
	window.open("print_consultationbill_dmp4inch1.php?billautonumber="+varBillNumber1+"","OriginalWindowA4<?php echo $banum; ?>",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}

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
		window.open("print_consultation_billa4.php?printsource=billpage&&billautonumber="+varBillNumber+"","OriginalWindowA4<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	}
	if (varPaperSize == "A5")
	{
		window.open("print_consultation_billa5.php?printsource=billpage&&billautonumber="+varBillNumber+"","OriginalWindowA5<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
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

function balancecalc(mode)
{}

</script>

<script>

function functioncurrencyfx(val)
{	

	var myarr = val.split(",");
	var currate=myarr[0];
	var currency=myarr[1];
	
	var ledgername=myarr[2];
	var ledgercode=myarr[3];
	//alert(currate);
	//alert(currency);
	document.getElementById("fxamount").value=  currate;
	
	document.getElementById("ledgername").value=  ledgername;
	document.getElementById("ledgercode").value=  ledgercode;
	
	document.getElementById("amounttot").value='';
	document.getElementById("currencyamt").value='';
	
	
}


function funcamountcalc()
{

if(document.getElementById("currencyamt").value != '')
{
var currency = document.getElementById("currencyamt").value;
var rate = document.getElementById("fxamount").value;
var amount = currency * rate;

document.getElementById("amounttot").value = amount.toFixed(2);
}
}
</script>

<script>

function FrmValid()
{
	if(document.getElementById("consult_weiveramount").value == "")
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
	
	var con = confirm("Are you sure to Submit ?");
	if(con == false)
	{
		alert("Entry not saved");
		return false;
	}
}

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
}	

function WeiverCalcamt(id, val)
{
	var val = val;
	if(val=='')
		val =0 ;
	//alert(val);
	if(id == 'consult' && document.getElementById("consultation").value > 0)
	{
		var consultation = document.getElementById("consultation").value;
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
</script>



<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext4 {	FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
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

</style>

<script src="js/datetimepicker_css.js"></script>
<script src="js/jquery-1.11.1.min.js"></script>
<script>
$( document ).ready(function() {
});
</script>
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body>
<form name="frmsales" id="frmsales" method="post" action="patientweivers_consult.php" onSubmit="return FrmValid();">
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
			<tr>
			<td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext4"><strong>Patient Details</strong>			</td>
			</tr>
              <tr>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                </tr>
                <?php $query="select locationcode,locationname from master_location where locationcode = '".$locationcode."' and status = ''";
			 
			 $exec1print = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1print.".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res1print = mysqli_fetch_array($exec1print);
				$locationname = $res1print["locationname"];
	?>
                <tr><td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Location </td>
              <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> <?php  echo $locationname; ?></td>
			  
                </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient  * </strong></td>
                <td align="left" valign="middle" class="bodytext3">
				<input name="customername" id="customer" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly type="hidden"/><?php echo $patientname; ?>
                <input type="hidden" name="patientfirstname" value="<?php echo $patientfirstname; ?>">
				<input type="hidden" name="patientmiddlename" value="<?php echo $patientmiddlename; ?>">
				<input type="hidden" name="patientlastname" value="<?php echo $patientlastname; ?>">				  </td>
                    
                 <input type="hidden" name="consultationcoa" value="<?php echo $consultationcoa; ?>">
				<input type="hidden" name="copaycoa" value="<?php echo $copaycoa; ?>">
				<input type="hidden" name="cashcoa" value="<?php echo $cashcoa; ?>">
				<input type="hidden" name="chequecoa" value="<?php echo $chequecoa; ?>">
				<input type="hidden" name="mpesacoa" value="<?php echo $mpesacoa; ?>">
				<input type="hidden" name="cardcoa" value="<?php echo $cardcoa; ?>">
				<input type="hidden" name="onlinecoa" value="<?php echo $onlinecoa; ?>">
				<input type="hidden" name="locationcode" value="<?php echo $locationcode; ?>">
                <input type="hidden" name="locationname" value="<?php  echo $locationname; ?>">
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Type</strong></td>
                <td class="bodytext3" align="left" valign="middle" >
				<input name="paymenttype" id="paymenttype" type="hidden" value="<?php echo $paymenttype; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $paymenttype; ?>				</td>
              </tr>
			 
		
			  <tr>
			   
                 <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient code </strong></td>
                <td align="left" valign="middle" class="bodytext3">
				<input name="customercode" id="customercode" type="hidden" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientcode; ?>
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
               <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Sub Type</strong></td>
                <td align="left" valign="top" class="bodytext3">
				<input name="subtype" id="subtype" type="hidden" value="<?php echo $subtype; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $subtype; ?>				</td>
			    </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code</strong></td>
                <td align="left" valign="middle" class="bodytext3">
				<input name="visitcode" id="visitcode" type="hidden" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $visitcode; ?>				</td>
					    <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>
                <td class="bodytext3" align="left" valign="middle" >
				<input name="accountname" id="accountname" type="hidden" value="<?php echo $accountname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input name="accountcode" id="accountcode" type="hidden" value="<?php echo $accountcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input name="accountnameano" id="accountnameano" type="hidden" value="<?php echo $accountnameano; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<?php echo $accountname; ?></td>
				  </tr>
				  <tr>
				     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>OP Date</strong></td>
                <td align="left" valign="middle" class="bodytext3">
				<input name="opdate" id="opdate" type="hidden" value="<?php echo $opdate; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $opdate; ?>				</td>
			
				    
     	<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Plan Name</strong></td>
                <td class="bodytext3" align="left" valign="top" >
				<input name="planname" id="planname" type="hidden" value="<?php echo $planname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $planname; ?>				</td>
				  </tr>
				  <tr>
				    <td class="bodytext3"><strong>    Doc No. </strong></td>
	 <td class="bodytext3"> <input name="billnumber" id="billnumber" value="<?php echo $billnumbercode; ?>" <?php echo $billnumbertextboxvalidation; ?> style="border: 1px solid #001E6A; text-align:left" size="18" readonly type="hidden"/><?php echo $billnumbercode; ?></td>
                  <td class="bodytext3"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Bill Date </strong></td>
				
                  <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />
             
				     <td class="bodytext3">
               
                  <input name="ADate" id="ADate" style="border: 1px solid #001E6A" value="<?php echo date('Y-m-d'); ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                  </td>
				  </tr>
            </tbody>
        </table></td>
      </tr>
      <tr>
			<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext4"><strong>Transaction Details</strong>
			</td>
			</tr>
			
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
            <tr>
              <td width="16%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Dept</strong></div></td>
				<td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Consulting Doctor </strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Consultation Type</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Consultation Fees </strong></div></td>
					<td width="13%"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Copay Amount </strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Copay% </strong></div></td>
              
                  </tr>
	
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $department; ?></div></td>
			 <input type="hidden" name="department" value="<?php echo $department; ?>">
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultingdoctor; ?></div></td>
				<input type="hidden" name="consultingdoctor" value="<?php echo $consultingdoctor; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationtypes; ?></div></td>
			 <input type="hidden" name="consultationtype" value="<?php echo $consultationtypes; ?>">
			    <td class="bodytext31" valign="center"  align="left"><div align="center"> <?= number_format($consultationfees,2,'.',','); ?></div></td>
				<input type="hidden" name="consultationfees" value="<?php echo $consultationfees; ?>">
				<input type="hidden" name="patientbilltype" value="<?php echo $patientbilltype; ?>">
				<input type="hidden" name="billamount" value="<?php echo $consultationfees; ?>">
				<input type="hidden" name="patientbillamount" value="<?php echo $billamountpatient; ?>">
				 <input type="hidden" name="billentryby" id="billentryby" value="<?php echo $billentryby; ?>" readonly style="border: 1px solid #001E6A;">
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $planfixedamount; ?></div></td>
				 <input type="hidden" name="copayfixedamount" value="<?php echo $planfixedamount; ?>">
				  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $planpercentage; ?></div></td>
				  <input type="hidden" name="copaypercentageamount" value="<?php echo $planpercentage; ?>">
				   <input name="totalamountbeforediscount" type="hidden" id="totalamountbeforediscount" value="<?php echo $billamountpatient; ?>" readonly style="border: 1px solid #001E6A; background-color:#ecf0f5; text-align:right" size="10">
				<input type="hidden" name="totalamount" value="<?php echo $billamountpatient; ?>">
				</tr>
			 <?php
				$originalamount = $billamountpatient;
			  $billamountpatient = round($billamountpatient/5,2)*5;
			  $roundoffamount = $originalamount - $billamountpatient;
			  $roundoffamount = number_format($roundoffamount,2,'.','');
			  $roundoffamount = -($roundoffamount);
			  $billamountpatient = number_format($billamountpatient,2,'.','');
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
            
             </tr>
           
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
		  <td align="left" class="bodytext3"><strong>Consultation</strong></td>
		  <td align="center" class="bodytext3"><input type="text" class="bali" name="consultation" id="consultation" readonly value="<?php echo number_format($billamountpatient,2,'.',''); ?>"></td>
		  <td align="center" class="bodytext3"><input type="text" name="consult_weiverpercent" id="consult_weiverpercent" size="5" onKeyUp="return WeiverCalc('consult',this.value);"></td>
		  <td align="center" class="bodytext3"><input type="text" class="bali" name="consult_weiveramount" id="consult_weiveramount"  size="10" onKeyUp="return WeiverCalcamt('consult',this.value);"></td>
		  <td align="center" class="bodytext3"><input type="text" class="bali" name="consult_weivernett" id="consult_weivernett" readonly></td>
		  </tr>
		  </tbody>
		  <tr bgcolor="#ecf0f5">
		 <td align="left">&nbsp;</td>
		 <td align="left">&nbsp;</td>
		 <td align="right" class="bodytext3"><font color='red' >*Remarks</font></td>
		 <td align="left"><input type="text" name="remarks" id="remarks" /></td>
		 <td align="center" valign="middle" class="bodytext3">
		<input type="hidden" name="frm1submit1" value="frm1submit1" />
		<input name="Submit222" type="submit" value="Submit" class="button"/>
		</td>		 
        </tr>	
		  </table>
	  </td>
	  </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
     
    </table>
  </table>
</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>