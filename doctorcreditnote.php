<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$timeonly = date("H:i:s");
$username = $_SESSION["username"];
$docno = $_SESSION['docno'];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$currentdate = date("Y-m-d");
$updatedate=date("Y-m-d");
$titlestr = 'SALES BILL';

$query01="select locationcode from login_locationdetails where docno ='$docno' and username='$username' order by auto_number desc";
$exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
$res01=mysqli_fetch_array($exc01);
$main_locationcode = $res01['locationcode'];


if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
	
$query771 = "select ledger_id from finance_ledger_mapping where map_anum = '28'";
$exec771 =  mysqli_query($GLOBALS["___mysqli_ston"], $query771) or die ("Error in Query771".mysqli_error($GLOBALS["___mysqli_ston"]));
$res771 = mysqli_fetch_array($exec771);
$coaledg = $res771["ledger_id"];	
	
	
	
$query3 = "select * from bill_formats where description = 'doctorcreditnote'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = $res3['prefix'];
$paynowbillprefix=$paynowbillprefix.'-';
$paynowbillprefix2=$paynowbillprefix;
	//$paynowbillprefix = 'IPD-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from privatedoctor_billing order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode =$paynowbillprefix2.'1';
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
	
	
	$billnumbercode = $paynowbillprefix2 .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
	$billdate=$_REQUEST['billdate'];
	$frompage = $_REQUEST['frompage'];
	$paymentmode = $_REQUEST['billtype'];
	$visit_type=$_REQUEST['visit_type'];
		$patientfullname = $_REQUEST['customername'];
		$patientcode = $_REQUEST['patientcode'];
		$visitcode = $_REQUEST['visitcode'];
		$billtype = $_REQUEST['billtypes'];
		$locationcode=$_REQUEST['locationcode'];
		$age=$_REQUEST['age'];
		$gender=$_REQUEST['gender'];
		$account = $_REQUEST['account'];
	
		
		foreach($_POST['referal1'] as $key=>$value){	
			//echo '<br>'.
		
		$pairs= $_POST['referal1'][$key];
		$pairvar= $pairs;
	    $pairs1= $_POST['rate4'][$key];
		$pairvar1= $pairs1;
		
		$units = 1;
		$amount = $_POST['amount'][$key];
		$pairvar1 = $amount;
		$description = $_POST['description'][$key];
		$servicecode = $_POST['descriptioncode'][$key];
		$doccoa= $_POST['referalcode'][$key];
		$billtype='Pay Later';
			
		if($pairvar!="")
		{
			
			
	$referalquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into privatedoctor_billing(docno,quantity,amount,patientcode,patientname,visitcode,doctorcode,rate,billtype,accountname,recorddate,billstatus,recordtime,username,ipaddress,description, locationcode)values('$billnumbercode','$units','$amount','$patientcode','$patientfullname','$visitcode','$doccoa','$pairvar1','$billtype','$account','$billdate','pending','$timeonly','$username','$ipaddress','$description', '$locationcode')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$referalquery2=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_ipprivatedoctor(docno,quantity,amount,patientcode,visitcode,doccoa,rate,billtype,accountname,recorddate,billstatus,recordtime,username,ipaddress,description, locationcode,visittype,original_amt,sharingamount,percentage,transactionamount,patientname,coa)values('$billnumbercode','$units','$amount','$patientcode','$visitcode','$doccoa','$pairvar1','$billtype','$account','$billdate','pending','$timeonly','$username','$ipaddress','$description', '$locationcode','$visit_type','$amount','$amount','100','$amount','$description','$coaledg')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
		}
} 
	
header('doctorcreditnote.php');
}
//to redirect if there is no entry in masters category or item or customer or settings
//To get default tax from autoitemsearch1.php and autoitemsearch2.php - for CST tax override.
if (isset($_REQUEST["defaulttax"])) { $defaulttax = $_REQUEST["defaulttax"]; } else { $defaulttax = ""; }
if(isset($_REQUEST['delete']))
{
$radiologyname=$_REQUEST['delete'];
mysqli_query($GLOBALS["___mysqli_ston"], "delete from consultation_radiology where radiologyitemname='$radiologyname'");
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
$searchlocationcode=$_REQUEST["searchlocation"];
}
if(isset($_REQUEST["frompage"])){$frompage = $_REQUEST["frompage"]; }else{$frompage ='';}
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
/*$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$execlab=mysqli_fetch_array($Querylab);
 $patientage=$execlab['age'];
 $patientgender=$execlab['gender'];
 $patientname = $execlab['customerfullname'];
$Queryloc=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'");
$execloc2=mysqli_fetch_array($Queryloc);
 $subtype=  $execlab2['subtype'];
 $patientaccount=$execloc2['accountname'];
  $billtype = $execlab2['billtype'];
 $visitlimit=$execloc2['visitlimit'];
 $patienttype=$execlab['maintype'];*/
 $searchlocationcode=$main_locationcode;
 $query1 = "select * from master_location where locationcode='$searchlocationcode' and status='' order by locationname";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			
						 $locationname = $res1["locationname"];
						 $locationcode = $res1["locationcode"];

/*$querytype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_paymenttype where auto_number='$patienttype'");
$exectype=mysqli_fetch_array($querytype);
$patienttype1=$exectype['paymenttype'];
$patientsubtype=$execlab['subtype'];
$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$patientsubtype'");
$execsubtype=mysqli_fetch_array($querysubtype);
$patientsubtype1=$execsubtype['subtype'];
$patientplan=$execlab['planname'];
$queryplan=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_planname where auto_number='$patientplan'");
$execplan=mysqli_fetch_array($queryplan);
$patientplan1=$execplan['planname'];*/
?>
<?php
/*$querylab1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$execlab1=mysqli_fetch_array($querylab1);
$patientname=$execlab1['customerfullname'];
$querylab2=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_accountname where auto_number='$patientaccount'");
$execlab2=mysqli_fetch_array($querylab2);
$patientaccount1=$execlab2['accountname'];
$query2 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$admissiondate = $res2['recorddate'];*/
?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);


$query3 = "select * from bill_formats where description = 'doctorcreditnote'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = $res3['prefix'];
$paynowbillprefix=$paynowbillprefix.'-';
$paynowbillprefix1=strlen($paynowbillprefix);

$query2 = "select * from privatedoctor_billing order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode =$paynowbillprefix.'1';
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
	
	
	$billnumbercode = $paynowbillprefix .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}?>
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
 //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	 //To handle ajax dropdown list.
	funcPopupPrintFunctionCall();
funcCustomerDropDownSearch7();		
		
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
<?php include ("autocompletebuild_ipprivatedoctor.php"); ?>
<?php include ("js/dropdownlist1scriptingipprivatedoctor.php"); ?>
<script src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />      
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">      
<script type="text/javascript" src="js/autocomplete_ipprivatedoctor2.js"></script>
<script type="text/javascript" src="js/autosuggestipprivatedoctor.js"></script>
<script type="text/javascript" src="js/insertnewitemipdoctor1.js?v=4"></script>
<script language="javascript">
var totalamount=0;
var totalamount1=0;
var totalamount2=0;
var totalamount3=0;
var totalamount4=0;
var totalamount11;
var totalamount21;
var totalamount31;
var totalamount41;
var grandtotal=0;
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
function frequencyitem()
{
if(document.form1.frequency.value=="select")
{
alert("please select a frequency");
document.form1.frequency.focus();
return false;
}
return true;
}
function Functionfrequency()
{
var ResultFrequency;
 var frequencyanum = document.getElementById("frequency").value;
var medicinedose=document.getElementById("dose").value;
 var VarDays = document.getElementById("days").value; 
 if((frequencyanum != '') && (VarDays != ''))
 {
  ResultFrequency = medicinedose*frequencyanum * VarDays;
 }
 else
 {
 ResultFrequency =0;
 }
 document.getElementById("quantity").value = ResultFrequency;
var VarRate = document.getElementById("rate").value;
var ResultAmount = parseFloat(VarRate * ResultFrequency);
  document.getElementById("amount").value = ResultAmount.toFixed(2);
}
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
function btnDeleteClick4(delID4,varamount1)
{
	//alert ("Inside btnDeleteClick.");
	var iprate = varamount1;
	
	var newtotal;
	
	var varDeleteID4= delID4;
	//alert(varDeleteID4);
	var fRet7; 
	fRet7 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet7 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}
	var child4 = document.getElementById('idTR'+varDeleteID4);  
	//alert (child3);//tr name
    var parent4 = document.getElementById('insertrow4'); // tbody name.
	document.getElementById ('insertrow4').removeChild(child4);
	
	var child4= document.getElementById('idTRaddtxt'+varDeleteID4);  //tr name
    var parent4 = document.getElementById('insertrow4'); // tbody name.
	
	if (child4 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow4').removeChild(child4);
	}
	
	var currenttotal2=Number(document.getElementById("total_amt").value.replace(/[^0-9\.]+/g,""));
	//alert(currenttotal);
	newtotal2= parseFloat(currenttotal2)-parseFloat(iprate);
	
	var availableamount_org=Number(document.getElementById("availableamount_org").value.replace(/[^0-9\.]+/g,""));
	document.getElementById('availableamount_org').value=formatMoney(parseFloat(availableamount_org)+parseFloat(iprate));
	
	document.getElementById('total_amt').value=formatMoney(newtotal2);
	
	document.getElementById('grand_total').value=formatMoney(newtotal2);	
	
	document.getElementById("Add4").style.display = '';
	
    document.getElementById("Add4").disabled = false;
	
}
function funcamountcalc()
{
var units = 1;
var rate = document.getElementById("rate4").value;
docfee = 0;
var amount = units * rate;
var totalamount = parseFloat(docfee) + parseFloat(amount);
document.getElementById("amount").value = totalamount.toFixed(2);
}
 function clearcode(id)
 {
	document.getElementById(id).value='';
 }
					 
</script>
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
.style1 {
	font-size: 30px;
	font-weight: bold;
}
.style2 {
	font-size: 18px;
	font-weight: bold;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
.bal
{
border-style:none;
background:none;
text-align:right;
font-size: 30px;
	font-weight: bold;
	FONT-FAMILY: Tahoma
}
.ui-menu .ui-menu-item{ 
zoom:.7 !important;
 }
</style>
</head>
<link href="autocomplete.css" rel="stylesheet">
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script>
$( function() {
	var admissiondt  = new Date(document.getElementById('admissiondate').value);
    $( "#billdate1" ).datepicker({
	 dateFormat: 'yy-mm-dd',
	 minDate: admissiondt,
	 maxDate: new Date() 
      
	});
  } );
$(document).ready(function(e) {
//alert();
var subtype= document.getElementById('subtypenum').value;
		
$(function() {
$('#description').autocomplete({
		
	source:'descriptionsearch.php?subtype="+subtype+"',
	minLength:3,
	delay: 0,
	html: true, 
		select: function(event,ui){
			  var description = ui.item.itemname;	
			  var decriptioncode=ui.item.itemcode;
			 //alert(decriptioncode);
			  document.getElementById('descriptioncode').value=decriptioncode;
			 
			},
    });
});
    
});
function frmvalidation()
{
	if(document.getElementById('billdate').value=="" || document.getElementById('billdate').value=="0000-00-00")
	{
		alert("Please select date");
		return false;
	}
	if(document.getElementById('referal').value!="" && document.getElementById('referalcode').value==""){
        alert("Please select doctor name from list");
		var varreferal = document.getElementById("referal").value = '';
		var varrefRate = document.getElementById("rate4").value = '';
		var varunits = document.getElementById("units").value = '';
		var varamount = document.getElementById("amount").value = '';
		var vardescription = document.getElementById("description").value = '';
		var vardescription = document.getElementById("descriptioncode").value = '';
		var vardescriptioncode = document.getElementById("referalcode").value = '';
		document.form1.referal.focus();
		return false;
 
	}
	if(document.getElementById('referalcode').value!=''){
       if(document.form1.rate4.value<1)
		{
			alert("Please enter rate");
			document.form1.rate4.focus();
			return false;
		}
		if(document.form1.amount.value=="")
		{
			alert("Please enter amount");
			return false;
		}
		
		/*if(document.form1.descriptioncode.value=="")
		{
			alert("Please select Description from list");
			document.getElementById("description").value="";
			document.form1.descriptioncode.focus();
			return false;
		}*/
	}
	fRet = confirm('Do you want to save?');
    if (fRet == false)
	{
		return false;
	}
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

</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="form1" id="frmsales" method="post" action="doctorcreditnote.php" >
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
 <tr><td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="980" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="792"><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
                <tr bgcolor="#011E6A">
                <td colspan="7" bgcolor="#ecf0f5" class="bodytext32"><strong>Patient Details</strong></td>
			 </tr>
		<tr>
                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
			 </tr>
			
				<?php  //include ('ipcreditaccountreport3_ipcredit.php'); ?>
				      
               			   
				  <tr>
                  
                  <td align="left" valign="middle" class="bodytext3"><strong>Doc No</strong></td>
				<td class="bodytext3"><input type="hidden" name="billno" id="billno" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
				<?php echo $billnumbercode; ?></td>
                
					<td align="left" valign="middle" class="bodytext3"><strong> Date</strong></td>
                     <td width="30%" align="left" valign="center"  class="bodytext31"><input name="billdate" id="billdate" value="<?php echo date('Y-m-d');?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('billdate')" style="cursor:pointer"/> </td>
				
				 <td width="17%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Type</strong></td>
                <td align="left" valign="top" class="bodytext3">
				<select name="visit_type" id="visit_type">
				   <option value="OP">OP</option>
				   <option value="IP">IP</option>
				   </select>	
                   </td>	
			
                
                
                				  </tr>
                  <tr>
                  <td align="left" valign="middle" class="bodytext3"><strong>Location</strong></td>
				<td class="bodytext3"><input type="hidden" name="locationcode" id="locationcode" value="<?php echo $searchlocationcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
				<?php echo $locationname; ?></td>
				
				<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" >
				<strong>Grand Total</strong></td>
                <td align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" >
				<input type="text" size="6"  id="grand_total" value="0" readonly style="border: 1px solid red;"></td>
<input type="hidden" size="6" id="availableamount" value="" readonly>
<input type="hidden" size="6" id="availableamount_org" value="" readonly>
<input type="hidden" size="6"  id="usedamount" value="" readonly>
<input type="hidden" id="visitlimit" size="6" value="" readonly>
<input type="hidden" name="account" id="account" value="" style="border: 1px solid #001E6A" size="18" rsize="20" />		
<input type="hidden" name="billtypes" id="billtypes" value="" />
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
          
				        <tr>
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><strong>IP Private Doctor </strong> </span></td>
		        </tr>
				<tr id="reffid">
				    <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				    <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="30" class="bodytext3">Doctor</td>
					   <!--<td class="bodytext3">Visit  Fee</td>-->
					     <td class="bodytext3">Procedure Fee</td>
						  <td class="bodytext3">Description</td>
						  <td class="bodytext3">Amount</td>
                     </tr>
                     
					  <tr>
					 <div id="insertrow4"></div></tr>
					  <tr>
					  <input type="hidden" name="serialnumber4" id="serialnumber4" value="1">
					  <input type="hidden" name="referalcode[]" id="referalcode" value="">
				   <td width="30"><input name="referal[]" type="text" id="referal" size="30" autocomplete="off"></td>
				  <!--<td width="30"><select name="docfee[]" id="docfee" onChange="return funcamountcalc()">
				   <option value="">Select</option>
				   <option value="2500">2500</option>
				   <option value="4000">4000</option>
				   </select></td>-->
				    <input name="units[]" type="hidden" id="units" size="8" value="1">
				    <td width="30"><input name="rate4[]" type="text" id="rate4" size="8" onKeyUp="return funcamountcalc()" ></td>
					 <td width="30"><input name="description[]" type="text" id="description" size="30">
                     <input type="hidden" name="subtypenum" id="subtypenum" value="<?php echo $subtype;?>">
                     <input type="hidden" name="descriptioncode[]" id="descriptioncode" value=""></td>
					  <td width="30"><input name="amount[]" type="text" id="amount" readonly size="8"></td>
					   <td><label>
                       <input type="button" name="Add4" id="Add4" value="Add" onClick="return insertitem5()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
					    </table></td>
		        </tr>
			
		
          </tbody>
        </table>		</td></tr>
		
		<tr>
		<td>&nbsp;		</td>
		</tr>
		<tr>
	   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Total</strong><input type="text" id="total_amt" readonly size="7"></td>
	   </tr>
		
		<tr>
		<td>&nbsp;		</td>
		</tr>
             
               <tr>
	  <td colspan="7" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
	   <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
	    <input name="Submit2223" type="submit" value="Save" accesskey="b" class="button" style="border: 1px solid #001E6A" onclick='return frmvalidation();'/>		</td>
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