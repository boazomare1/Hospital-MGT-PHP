<?php
session_start();
error_reporting(0);
include ("includes/loginverify.php");
include ("db/db_connect.php");


$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$timeonly = date("H:i:s");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$errmsg = 0;

$giventoken=isset($_REQUEST["token"])?$_REQUEST["token"]:'';

	$query1111 = "select * from master_employee where username = '$username'";
    $exec1111 = mysqli_query($GLOBALS["___mysqli_ston"], $query1111) or die ("Error in Query1111".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res1111 = mysqli_fetch_array($exec1111))
	{
	$username = $res1111["username"];
	$employeename=$res1111["employeename"];
	$locationnumber = $res1111["location"];
	$query1112 = "select * from master_location where auto_number = '$locationnumber' and status <> 'deleted'";
    $exec1112 = mysqli_query($GLOBALS["___mysqli_ston"], $query1112) or die ("Error in Query1112".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res1112 = mysqli_fetch_array($exec1112))
	{
		 $locationname = $res1112["locationname"];		  
		 $locationcode = $res1112["locationcode"];
		 $prefix = $res1112["prefix"];
		 $suffix = $res1112["suffix"];
	}
	}


if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

$titlestr = 'SALES BILL';
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{

	
		

			  
			 
				
$consultationprefix='PW-';
$query2 = "select docno from patientwaivers order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
if ($billnumber == '')
{
	$billnumbercode =$consultationprefix.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docno"];
	$billnumbercode = substr($billnumber, 3, 8);
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = $consultationprefix.$maxanum;
	$openingbalance = '0.00';
	
}	
	
	$patientcode = $_REQUEST["customercode"];
	$visitcode = $_REQUEST["visitcode"];
	$patientname = $_REQUEST['customername'];	
	$locationcode = $_REQUEST['locationcode'];
	$locationname = $_REQUEST['locationname'];
	$consultationid = $_REQUEST['consultationid'];
	
	$accountname = $_REQUEST["account"];	
	$subtype = $_REQUEST["subtype"];	
	$paymenttype = $_REQUEST["paymenttype"];	
	$remarks = $_REQUEST['remarks'];
	$lab  = $_REQUEST["labwaiver"];
	$radiology = $_REQUEST["radwaiver"];	
	$services = $_REQUEST["serwaiver"];
	$pharmacy = $_REQUEST["pharmwaiver"];	
	$others = $_REQUEST['others'];
	 $conwaiver = $_REQUEST["conwaiver"];
	$totalamount=$_REQUEST["totalamount"];
	$bankrefamount = $_REQUEST['totwaiver'];
	
		
			
	//	$bankrefamount=str_replace(',','',$_POST['bankrefamount'][$key1]); 
			
		
		
		
		
		$discountamount=floatval($exec001['transactionamount']);
		
		
		
		
	
	
	 $query2 = "select auto_number from patientwaivers where consultation_id='$consultationid' and patientcode = '$patientcode' and patientvisitcode = '$visitcode'";
	 $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
     $res2 = mysqli_num_rows($exec2);
	
	 	$query22 = "insert into patientwaivers(entrydate,patientcode,patientname,patientvisitcode,type,subtype,accountname,docno,ipaddress,username,locationname,locationcode,remarks,lab,radiology,services,others,recordstatus,consultation_id,pharmacy,consultation,totaldiscount)values('$dateonly','$patientcode','$patientname','$visitcode','$paymenttype','$subtype','$accountname','$billnumbercode','$ipaddress','$username','$locationname','$locationcode','$remarks','$lab','$radiology','$services','$others','1','$consultationid','$pharmacy','$conwaiver','$bankrefamount')";  
		$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		header("location:patientwaiversearchlist.php");



//header("location:patientwaiversearchlist.php");

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

//to redirect if there is no entry in masters category or item or customer or settings



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
$planname1=$execlab1["planname"]; 
$accountname1=$execlab1["accountname"]; 



$query5 = "select * from master_accountname where auto_number = '$patientaccount'";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res5 = mysqli_fetch_array($exec5);
$accountname = $res5['accountname'];
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

$query5 = "select department from master_department where auto_number = '$departmentanum'";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res5 = mysqli_fetch_array($exec5);
$department = $res5['department'];

//echo $department;

$query45="select planname,planfixedamount,planpercentage,forall from master_planname where auto_number='$plan' and accountname ='$accountname1'";
$exec45=mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res45=mysqli_fetch_array($exec45);
$planname=$res45['planname'];
 $forall=$res45['forall'];
$planpercentage1=$res45['planpercentage'];
$planfixedamount1=$res45['planfixedamount'];



$query46="select paymenttype from master_paymenttype where auto_number='$type'";
$exec46=mysqli_query($GLOBALS["___mysqli_ston"], $query46) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res46=mysqli_fetch_array($exec46);
$paymenttype=$res46['paymenttype'];

$query47="select subtype from master_subtype where auto_number='$subtype'";
$exec47=mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res47=mysqli_fetch_array($exec47);
$subtype=$res47['subtype'];

$query76 = "select code from master_financialintegration where field='consultationfee'";
$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res76 = mysqli_fetch_array($exec76);
$consultationcoa = $res76['code'];

$query761 = "select code from master_financialintegration where field='copay'";
$exec761 = mysqli_query($GLOBALS["___mysqli_ston"], $query761) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res761 = mysqli_fetch_array($exec761);

$copaycoa = $res761['code'];

$query765 = "select code from master_financialintegration where field='cashconsultation'";
$exec765 = mysqli_query($GLOBALS["___mysqli_ston"], $query765) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res765= mysqli_fetch_array($exec765);

$cashcoa = $res765['code'];


$query766 = "select * from master_financialintegration where field='chequeconsultation'";
$exec766 = mysqli_query($GLOBALS["___mysqli_ston"], $query766) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res766 = mysqli_fetch_array($exec766);

$chequecoa = $res766['code'];


$query767 = "select code from master_financialintegration where field='mpesaconsultation'";
$exec767 = mysqli_query($GLOBALS["___mysqli_ston"], $query767) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res767 = mysqli_fetch_array($exec767);

$mpesacoa = $res767['code'];

$query768 = "select code from master_financialintegration where field='cardconsultation'";
$exec768 = mysqli_query($GLOBALS["___mysqli_ston"], $query768) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res768 = mysqli_fetch_array($exec768);

$cardcoa = $res768['code'];

$query769 = "select code from master_financialintegration where field='onlineconsultation'";
$exec769 = mysqli_query($GLOBALS["___mysqli_ston"], $query769) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res769 = mysqli_fetch_array($exec769);

$onlinecoa = $res769['code'];


?>


<?php

?>

<?php

$consultationprefix='PW-';
$query2 = "select docno from patientwaivers order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
if ($billnumber == '')
{
	$billnumbercode =$consultationprefix.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docno"];
	$billnumbercode = substr($billnumber, 3, 8);
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = $consultationprefix.$maxanum;
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

?>

<script>
function printConsultationBill()
 {}
</script>

<script language="javascript">

function funcOnLoadBodyFunctionCall()
{

	funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	funcCustomerDropDownSearch1(); //To handle ajax dropdown list.
	
	funcPopupPrintFunctionCall();
	
}

function funcPopupPrintFunctionCall()
{}

//Print() is at bottom of this page.

</script>
<script type="text/javascript">

function quickprintbill2sales()
{
}

function loadprintpage1(varPaperSizeCatch)
{}

function cashentryonfocus1()
{}

function funcDefaultTax1() //Function to CST Taxes if required.
{}

function balancecalc()
{
	var Disc = document.getElementById("discamount").value;
	var stot = document.getElementById("subtotal").value;
	if(Disc == '') { Disc = '0.00'; }
	if(parseFloat(Disc) > parseFloat(stot))
	{
		alert("Discount amount greater than Bill amount");
		document.getElementById("totalamount").value = stot;
		document.getElementById("discamount").value = '0.00';
		return false;
	}
	var tot = parseFloat(stot) - parseFloat(Disc); 
	var tot = parseFloat(tot);
	document.getElementById("totalamount").value = tot.toFixed(2);
}

function Process1()
{

	/*if(document.getElementById("netconnection").value != '1')
	{
		alert(" No internet, Bill can not be amended");
		FuncPopup();
		window.location('patientwaiversearchlist.php');
		return false;
	}*/

	if(document.getElementById("remarks").value == '')
	{
		alert("Please Enter Remarks");
		document.getElementById("remarks").focus();
		return false;
	}
	
		var varUserChoice; 
	varUserChoice = confirm('Are You Sure Want To Save This Entry?'); 
	//alert(fRet); 
	document.getElementById("Submit222").disabled=true;
	if (varUserChoice == false)
	{
		document.getElementById("Submit222").disabled=false;
	//	alert ("Entry Not Saved.");
		return false;
	}
	else
	{
		//alert ("Entry Saved.");
		FuncPopup();
		document.form1.submit();
		//return true;
	}
}

function FuncPopup()
{
	window.scrollTo(0,0);
	document.body.style.overflow='auto';
	document.getElementById("imgloader").style.display = "";
	//return false;
}


</script>
<script src="js/jquery-1.11.1.min.js"></script>
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
<script>
$(document).ready(function(){
	
	$('#labdescper').hide();
	$('#labdescamt').hide();
	$('#raddescper').hide();
	$('#raddescamt').hide();
	$('#serdescper').hide();
	$('#serdescamt').hide();
	$('#pharmdescper').hide();
	$('#pharmdescamt').hide();
	$('#condescper').hide();
	$('#condescamt').hide();
	$('#totdescper').hide();
	$('#totdescamt').hide();

$("#labdescper").keyup(function(){
	var labdes = $(this).val();
	var laborgamt = $("#lab").val();	
	var percent=(parseFloat(laborgamt)*parseFloat(labdes))/(100)
	$('#labwaiver').val(percent);
});
$("#labdescamt").keyup(function(){
	var labdes = $(this).val();
	$('#labwaiver').val(labdes);
});

$("#raddescper").keyup(function(){
	var raddes = $(this).val();
	var radorgamt = $("#radiology").val();	
	var percent=(parseFloat(radorgamt)*parseFloat(raddes))/(100)
	$('#radwaiver').val(percent);
});
$("#raddescamt").keyup(function(){
	var raddes = $(this).val();
	$('#radwaiver').val(raddes);
});

$("#serdescper").keyup(function(){
	var serdes = $(this).val();
	var serorgamt = $("#services").val();	
	var percent=(parseFloat(serorgamt)*parseFloat(serdes))/(100)
	$('#serwaiver').val(percent);
});
$("#serdescamt").keyup(function(){
	var serdes = $(this).val();
	$('#serwaiver').val(serdes);
});

$("#pharmdescper").keyup(function(){
	var pharmdes = $(this).val();
	var pharmorgamt = $("#pharmacy").val();	
	var percent=(parseFloat(pharmorgamt)*parseFloat(pharmdes))/(100)
	$('#pharmwaiver').val(percent);
});
$("#pharmdescamt").keyup(function(){
	var pharmdes = $(this).val();
	$('#pharmwaiver').val(pharmdes);
});
$("#condescper").keyup(function(){
	var condes = $(this).val();
	var conamt = $("#consultation").val();	
	var percent=(parseFloat(conamt)*parseFloat(condes))/(100)
	$('#conwaiver').val(percent);
});
$("#condescamt").keyup(function(){
	var condes = $(this).val();
	$('#conwaiver').val(condes);
});

$("#totdescper").keyup(function(){
	var totdes = $(this).val();
	var totamt = $("#totalamount").val();	
	var percent=(parseFloat(totamt)*parseFloat(totdes))/(100)
	$('#totwaiver').val(percent);
});
$("#totdescamt").keyup(function(){
	var totdes = $(this).val();
	$('#totwaiver').val(totdes);
});

});

$(document).on('change','.radioclass', function() {
    var showid = $(this).val();
   if(showid=='L1')
   {
	   $('#labdescper').show();
	   $('#labdescamt').hide();
	   $('#labdescamt').val('');
	   $('#labwaiver').val('');
   }
   if(showid=='L2')
   {
	   $('#labdescamt').show();
	   $('#labdescper').hide();
	   $('#labdescper').val('');
	   $('#labwaiver').val('');
   }
   if(showid=='R1')
   {
	   $('#raddescper').show();
	   $('#raddescamt').hide();
	   $('#raddescamt').val('');
	   $('#radwaiver').val('');
   }
   if(showid=='R2')
   {
	   $('#raddescamt').show();
	   $('#raddescper').hide();
	   $('#raddescper').val('');
	   $('#radwaiver').val('');
   }
   if(showid=='S1')
   {
	   $('#serdescper').show();
	   $('#serdescamt').hide();
	   $('#serdescamt').val('');
	   $('#serwaiver').val('');
   }
   if(showid=='S2')
   {
	   $('#serdescamt').show();
	   $('#serdescper').hide();
	   $('#serdescper').val('');
	   $('#serwaiver').val('');
   }
    if(showid=='P1')
   {
	   $('#pharmdescper').show();
	   $('#pharmdescamt').hide();
	   $('#pharmdescamt').val('');
	   $('#pharmwaiver').val('');
   }
   if(showid=='P2')
   {
	   $('#pharmdescamt').show();
	   $('#pharmdescper').hide();
	   $('#pharmdescper').val('');
	   $('#pharmwaiver').val('');
   }
     if(showid=='c1')
   {
	   $('#condescper').show();
	   $('#condescamt').hide();
	   $('#condescamt').val('');
	   $('#conwaiver').val('');
   }
   if(showid=='c2')
   {
	   $('#condescamt').show();
	   $('#condescper').hide();
	   $('#condescper').val('');
	   $('#conwaiver').val('');
   }
    if(showid=='t1')
   {
	   $('#totdescper').show();
	   $('#totdescamt').hide();
	   $('#totdescamt').val('');
	   $('#totwaiver').val('');
   }
   if(showid=='t2')
   {
	   $('#totdescamt').show();
	   $('#totdescper').hide();
	   $('#totdescper').val('');
	   $('#totwaiver').val('');
   }
   
   
	});
	
	
	
</script>



<style>
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



<script>
function CalcAmount(idname,amountid,type){

	if(type=='p')
	{
		
		if(parseFloat(document.getElementById(amountid).value)>100){
		alert("Shounld be below 100");
		document.getElementById(amountid).value=0;
		
		}
	}
	//alert();
	if(Add()>parseFloat(document.getElementById('totalamount').value) || parseFloat(document.getElementById(amountid).value)>parseFloat(document.getElementById(idname).value)){
				document.getElementById(amountid).value=0; 
				
				document.getElementById('bankrefamount').value=(parseFloat(document.getElementById('totalamount').value)-Add()).toFixed(2);
		}
	else{
	document.getElementById('bankrefamount').value=(parseFloat(document.getElementById('totalamount').value)-Add()).toFixed(2);
	

		}
}

function CalcAmount1(idname){

	document.getElementById(idname).value=0.00;
	//document.getElementById('bankrefamount').value=(parseFloat(document.getElementById('totalamount').value)-Add()).toFixed(2);
	var amt=document.getElementById('totalamount').value;
	document.getElementById('totdesc').checked = false;
	document.getElementById('totdescper').style.display='none';
	document.getElementById('totdescper').value="";
	document.getElementById('totwaiver').value="";
	document.getElementById('bankrefamount').value=amt;
	
	
}
function CalcAmount11(idname){

 var amt=document.getElementById('totalamount').value;

	document.getElementById(idname).value=0.00;
	document.getElementById('bankrefamount').value=(parseFloat(document.getElementById('totalamount').value)-Add()).toFixed(2);
	document.getElementById('condescp').checked = false;
	document.getElementById('condesca').checked = false;
	document.getElementById('condescper').style.display='none';
	document.getElementById('condescper').value="";
	document.getElementById('conwaiver').value="";
	
	
	document.getElementById('pharmdescp').checked = false;
	document.getElementById('pharmdesca').checked = false;
	document.getElementById('pharmdescper').style.display='none';
	document.getElementById('pharmdescper').value="";
	document.getElementById('pharmwaiver').value="";

	document.getElementById('labdescp').checked = false;
	document.getElementById('labdesca').checked = false;
	document.getElementById('labdescper').style.display='none';
	document.getElementById('labdescper').value="";
	document.getElementById('labwaiver').value="";
	
	document.getElementById('raddescp').checked = false;
	document.getElementById('raddesca').checked = false;
	document.getElementById('raddescper').style.display='none';
	document.getElementById('raddescper').value="";
	document.getElementById('radwaiver').value="";
	
	document.getElementById('serdesc').checked = false;
	document.getElementById('serdescper').style.display='none';
	document.getElementById('serdescper').value="";
	document.getElementById('serwaiver').value="";
	
	document.getElementById('bankrefamount').value=amt;
	
}

function Add(){
	//alert();
		var v1=0;
		var v2=0;
		var v3=0;
		var v4=0;
		var v5=0;
	
				v1=(document.getElementById('labdescamt').value!='')?parseFloat(document.getElementById('labdescamt').value):0.00;
				v2=(document.getElementById('raddescamt').value!='')?parseFloat(document.getElementById('raddescamt').value):0.00;
				v3=(document.getElementById('serdescamt').value!='')?parseFloat(document.getElementById('serdescamt').value):0.00;
				//v4=(document.getElementById('others').value!='')?parseFloat(document.getElementById('others').value):0.00;
			
				v9=(document.getElementById('pharmdescamt').value!='')?parseFloat(document.getElementById('pharmdescamt').value):0.00;
				v10=(document.getElementById('condescamt').value!='')?parseFloat(document.getElementById('condescamt').value):0.00;
				v12=(document.getElementById('totdescamt').value!='')?parseFloat(document.getElementById('totdescamt').value):0.00;
				
				v5=(document.getElementById('labdescper').value!='')?parseFloat(document.getElementById('labdescper').value):0.00;
				v6=(document.getElementById('raddescper').value!='')?parseFloat(document.getElementById('raddescper').value):0.00;
				v7=(document.getElementById('serdescper').value!='')?parseFloat(document.getElementById('serdescper').value):0.00;
				v8=(document.getElementById('pharmdescper').value!='')?parseFloat(document.getElementById('pharmdescper').value):0.00;
				v11=(document.getElementById('condescper').value!='')?parseFloat(document.getElementById('condescper').value):0.00;
				v13=(document.getElementById('totdescper').value!='')?parseFloat(document.getElementById('totdescper').value):0.00;


				p1=(document.getElementById('lab').value!='')?parseFloat(document.getElementById('lab').value):0.00;
				v5=(v5*p1)/100;
				p2=(document.getElementById('radiology').value!='')?parseFloat(document.getElementById('radiology').value):0.00;
				v6=(v6*p2)/100;
				p3=(document.getElementById('services').value!='')?parseFloat(document.getElementById('services').value):0.00;
				v7=(v7*p3)/100;
				p4=(document.getElementById('pharmacy').value!='')?parseFloat(document.getElementById('pharmacy').value):0.00;
				v8=(v8*p4)/100;
				p5=(document.getElementById('consultation').value!='')?parseFloat(document.getElementById('consultation').value):0.00;
				v11=(v11*p5)/100;
				p6=(document.getElementById('totalamount').value!='')?parseFloat(document.getElementById('totalamount').value):0.00;
				v13=(v13*p6)/100;
			
				return (v1+v2+v3+v4+v5+v6+v7+v8+v9+v10+v11+v13);

}

</script>


<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">

<div align="center" class="imgloader" id="imgloader" style="display:none;">
<div align="center" class="imgloader" id="imgloader1" style="display:;">
<p style="text-align:center;"><strong>Saving <br><br> Please Wait...</strong></p>
<img src="images/ajaxloader.gif">
</div>
</div>
<?php 
			if($patientbilltype=='PAY NOW')
			{
				$sql1 = "select sum(labitemrate) as labrate,consultationid from consultation_lab where patientcode='$patientcode' and patientvisitcode='$visitcode' and billtype ='PAY NOW' and paymentstatus='pending'";
			}
			else if($patientbilltype=='PAY LATER')
			{
				$sql1 = "select sum(labitemrate) as labrate,consultationid from consultation_lab where patientcode='$patientcode' and patientvisitcode='$visitcode' and billtype ='PAY LATER' and paymentstatus='completed'";
			}
			$result = mysqli_query($GLOBALS["___mysqli_ston"], $sql1);
			$exec = mysqli_fetch_array($result);
			$labamount=$exec['labrate'];
			$consultationid1=$exec['consultationid'];
			
			if($patientbilltype=='PAY NOW')
			{
				$sql12 = "select sum(radiologyitemrate) as radrate,consultationid from consultation_radiology where patientcode='$patientcode' and patientvisitcode='$visitcode' and billtype ='PAY NOW' and paymentstatus='pending'";
			}
			else if($patientbilltype=='PAY LATER')
			{
				$sql12 = "select sum(radiologyitemrate) as radrate,consultationid from consultation_radiology where patientcode='$patientcode' and patientvisitcode='$visitcode' and billtype ='PAY LATER' and paymentstatus='completed'";
			}
			$result2 = mysqli_query($GLOBALS["___mysqli_ston"], $sql12);
			$exec2 = mysqli_fetch_array($result2);
			$radamount=$exec2['radrate'];
			$consultationid2=$exec2['consultationid'];
			
			if($patientbilltype=='PAY NOW')
			{
				$sql13 = "select sum(amount) as serrate,consultationid from consultation_services where patientcode='$patientcode' and patientvisitcode='$visitcode' and billtype ='PAY NOW' and paymentstatus='pending'";
			}
			else if($patientbilltype=='PAY LATER')
			{
				$sql13 = "select sum(amount) as serrate,consultationid from consultation_services where patientcode='$patientcode' and patientvisitcode='$visitcode' and billtype ='PAY LATER' and paymentstatus='completed'";
			}
			$result3 = mysqli_query($GLOBALS["___mysqli_ston"], $sql13);
			$exec3 = mysqli_fetch_array($result3);
			$seramount=$exec3['serrate'];
			$consultationid3=$exec3['consultationid'];
			
			if($patientbilltype=='PAY NOW')
			{
				$sql133 = "select sum(amount) as pharmrate,consultation_id from master_consultationpharm where patientcode='$patientcode' and patientvisitcode='$visitcode' and billtype ='PAY NOW' and pharmacybill='pending' and amendstatus='2'";
			}
			else if($patientbilltype=='PAY LATER')
			{
				$sql133 = "select sum(amount) as pharmrate,consultation_id from master_consultationpharm where patientcode='$patientcode' and patientvisitcode='$visitcode' and billtype ='PAY LATER' and pharmacybill='completed' and amendstatus='2'";
			}
			$result33 = mysqli_query($GLOBALS["___mysqli_ston"], $sql133);
			$exec33 = mysqli_fetch_array($result33);
			$pharmamount=$exec33['pharmrate'];
			$consultationid33=$exec33['consultation_id'];
			
			
			if($patientbilltype=='PAY NOW')
			{
				 $sqln = "select sum(consultationfees) as conrate from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode' and billtype ='PAY NOW' and paymentstatus<>'completed'";
			}
			else if($patientbilltype=='PAY LATER')
			{
				$sqln = "select sum(consultationfees) as conrate from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode' and billtype ='PAY LATER' and paymentstatus='completed'";
			}
			$resultn = mysqli_query($GLOBALS["___mysqli_ston"], $sqln);
			$execn = mysqli_fetch_array($resultn);
			
			$conamount=$execn['conrate'];
			
			if($planpercentage1 >'0.00' && $forall =="yes")
			{
			 $conamount =$conamount -($conamount * $planpercentage1/100 );
			$pharmamount =$pharmamount -($pharmamount * $planpercentage1/100 );
			$seramount =$seramount -($seramount * $planpercentage1/100 );
			$radamount =$radamount -($radamount * $planpercentage1/100 );
			$labamount =$labamount -($labamount * $planpercentage1/100 );
			}
			else if($planpercentage1 >'0.00' && $forall =="")
			{
			$conamount =$conamount -($conamount * $planpercentage1/100 );	
			}
			else if($planpercentage1 <='0.00' && $forall=="yes")
			{
			$conamount =$conamount - $planfixedamount1;
			$pharmamount =$pharmamount - $planfixedamount1;
			$seramount =$seramount - $planfixedamount1;
			$radamount =$radamount - $planfixedamount1;
			$labamount =$labamount - $planfixedamount1;
				
			}
			else if($planpercentage1 <='0.00' && $forall=="")
			{
				$conamount=$conamount -$planfixedamount1;
			}
			
			
			
			
			
?>
<form name="frmsales" id="frmsales" method="post" action="patientwaivers.php" onKeyDown="return disableEnterKey(event);" onSubmit="return Process1()">
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
			<td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext4"><strong>Patient Details</strong>			</td>
			</tr>
             <?php $query="select locationcode,locationname from master_location where locationcode = '".$locationcode."' and status = ''";
			 
			 $exec1print = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1print.".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res1print = mysqli_fetch_array($exec1print);
				$locationname = $res1print["locationname"];
	?>
                <tr><td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Location </strong></td>
              <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> <?php  echo $locationname; ?></td>
			   <td class="bodytext3"><strong>    Ref No. </strong></td>
	 <td class="bodytext3"> <input name="billnumber" id="billnumber" value="<?php echo $billnumbercode; ?>" <?php echo $billnumbertextboxvalidation; ?> style="border: 1px solid #001E6A; text-align:left" size="18" readonly type="hidden"/><?php echo $billnumbercode; ?></td>
 
 				    
                </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient  * </strong></td>
                <td align="left" valign="middle" class="bodytext3">
				<input name="customername" id="customer" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly type="hidden"/><?php echo $patientname; ?>
                <input type="hidden" name="patientfirstname" value="<?php echo $patientfirstname; ?>">
				<input type="hidden" name="patientmiddlename" value="<?php echo $patientmiddlename; ?>">
				<input type="hidden" name="patientlastname" value="<?php echo $patientlastname; ?>">
                	<input type="hidden" name="bankrefno" value="<?php echo $giventoken; ?>">
                
                				  </td>
                    
                 <input type="hidden" name="consultationcoa" value="<?php echo $consultationcoa; ?>">
				<input type="hidden" name="copaycoa" value="<?php echo $copaycoa; ?>">
				<input type="hidden" name="cashcoa" value="<?php echo $cashcoa; ?>">
				<input type="hidden" name="chequecoa" value="<?php echo $chequecoa; ?>">
				<input type="hidden" name="mpesacoa" value="<?php echo $mpesacoa; ?>">
				<input type="hidden" name="cardcoa" value="<?php echo $cardcoa; ?>">
				<input type="hidden" name="onlinecoa" value="<?php echo $onlinecoa; ?>">
                <input type="hidden" name="locationcode" value="<?php echo $locationcode; ?>">
                <input type="hidden" name="locationname" value="<?php  echo $locationname; ?>">

                <input type="hidden" name="netconnection" id="netconnection" value="">
		
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Type</strong></td>
                <td class="bodytext3" align="left" valign="middle" >
				<input name="paymenttype" id="paymenttype" type="hidden" value="<?php echo $paymenttype; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $paymenttype; ?>				</td>
              </tr>
			 
		
			  <tr>
			   
                 <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient code </strong></td>
                <td align="left" valign="middle" class="bodytext3">
				<input name="customercode" id="customercode" type="hidden" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientcode; ?>
				
				
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
				<input name="account" id="account" type="hidden" value="<?php echo $accountname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $accountname; ?></td>
				  </tr>
				  <tr>
				     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>OP Date</strong></td>
                <td align="left" valign="middle" class="bodytext3">
				<input name="opdate" id="opdate" type="hidden" value="<?php echo $opdate; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $opdate; ?>				</td>
		<td class="bodytext3"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong> Date </strong></td>
				
                  <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />
             
				     <td class="bodytext3">
               
                 <?php echo $dateonly; ?>
                 				</td>	
				    
     	
				  </tr>
                   <tr>
				     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
                <td align="left" valign="middle" class="bodytext3">&nbsp;
				</td>
		<td class="bodytext3"><strong>Plan Name</strong></td>
				
                 
             
				     <td class="bodytext3"><?= $planname; ?></td>	
				    
     	
				  </tr>
	            </tbody>
        </table></td>
      </tr>
      	 	
            
      <tr >
			<td align="left" colspan="" valign="middle"  bgcolor="#ecf0f5" class="bodytext4"><strong>Patient Waivers</strong>
			</td>
			</tr>
	       	

			
            		
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
          
                      <tr bgcolor="#ecf0f5" >
        	<td  width="9%"  align="left" valign="middle"   class="bodytext3"> </td>
            <td  width="9%" align="left" valign="middle"   class="bodytext3"> <strong> </strong> </td>
            <td  width="9%" align="left" valign="middle"   class="bodytext3"> Total Amount </td>
            <td  width="9%" align="left" valign="middle"   class="bodytext3"> <strong> <?= number_format($labamount+$radamount+$seramount+$pharmamount+$conamount,2) ?>  </strong> </td>
            <td  width="9%" align="left" valign="middle"   class="bodytext3"> Revised Amount </td>
            <td  width="9%" align="left" valign="middle"   class="bodytext3"> <strong> <input type="text" name="bankrefamount"  size="10" readonly id="bankrefamount" value="<?= ($labamount+$radamount+$seramount+$pharmamount+$conamount); ?>" >
            
				<input type="hidden"  name="bankref[<?= $sno01 ?>]"  readonly value="<?= $bankrefno; ?>" >            
              </strong>  </td>
              
        </tr>
        
            <tr>
              <td width="16%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Dept</strong></div></td>
				<td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Un Billed Amount </strong></div></td>
				<td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Disc by %</strong></div></td>
				<td width="19%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong></strong>
                </div></td>
				<td width="29%"  align="left" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Waiver </strong></div></td>
				
              
             </tr>
			<?php
			
			
			if($consultationid1!='')
			{
				$consultationid=$consultationid1;
			}
			elseif($consultationid2!='')
			{
				$consultationid=$consultationid2;
			}
			elseif($consultationid3!='')
			{
				$consultationid=$consultationid3;
			}
			elseif($consultationid33!='')
			{
				$consultationid=$consultationid33;
			}
			$totalamount=$labamount+$radamount+$seramount+$pharmamount+$conamount;
			?>
           <input type="hidden" name="consultationid" id="consultationid" value="<?php echo $consultationid; ?>" >
        <!--    <tr bgcolor="#ecf0f5">
			  <td class="bodytext31" style="padding:15px;" valign="center"  align="left"><div align="center">Consultation</div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="center">
              <input style="height:25px" type="text" name="consultation" id="consultation" value="<?php echo $conamount; ?>"  readonly></div></td>      
              <td class="bodytext31" valign="center"  align="left"><div align="center">
              <input  type="radio" name="condesc" id="condescp"  class="radioclass" onClick="CalcAmount1('condescper')"  value="c1" <?php if($conamount<=0 || $conamount==''){ echo 'disabled'; } ?>   >
              <input style="height:25px" type="text" name="condescper" id="condescper" onKeyUp="return CalcAmount('consultation','condescper','p')" size="10"  ></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="center">
               <input style="display:none" type="radio" name="condesc" id="condesca" class="radioclass"  onClick="CalcAmount1('condescamt')"  value="c2" <?php if($conamount<=0 || $conamount==''){ echo 'disabled'; } ?>>
              <input style="height:25px;display:none" type="text" name="condescamt" id="condescamt" onKeyUp="return CalcAmount('consultation','condescamt','a')"  size="10"  ></div></td> 
              <td class="bodytext31" valign="center"  align="left"><div align="center">
              <input style="height:25px" type="text" name="conwaiver" id="conwaiver" readonly ></div></td>
				</tr> 
                -->
              <tr bgcolor="#ecf0f5">
			  <td class="bodytext31" style="padding:15px;" valign="center"  align="left"><div align="center">Pharmacy</div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="center">
              <input style="height:25px" type="text" name="pharmacy" id="pharmacy" value="<?php echo $pharmamount; ?>" readonly></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="center">
              <input  type="radio" name="pharmdesc" id="pharmdescp"  class="radioclass" onClick="CalcAmount1('pharmdescamt')"  value="P1" <?php if($pharmamount<=0 || $pharmamount==''){ echo 'disabled'; } ?>   >
              <input style="height:25px" type="text" name="pharmdescper" id="pharmdescper" onKeyUp="return CalcAmount('pharmacy','pharmdescper','p')" size="10"  ></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="center">
               <input style="display:none" type="radio" name="pharmdesc" id="pharmdesca" class="radioclass"  onClick="CalcAmount1('pharmdescper')"  value="P2" <?php if($pharmamount<=0 || $pharmamount==''){ echo 'disabled'; } ?>>
              <input style="height:25px;display:none" type="text" name="pharmdescamt" id="pharmdescamt" onKeyUp="return CalcAmount('pharmacy','pharmdescamt','a')"  size="10"  ></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center">
              <input style="height:25px" type="text" name="pharmwaiver" id="pharmwaiver" readonly ></div></td>
				</tr>	
			  <tr bgcolor="#ecf0f5">
			  <td class="bodytext31" style="padding:15px;" valign="center"  align="left"><div align="center">Lab</div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="center">
              <input style="height:25px" type="text" name="lab" id="lab" value="<?php echo $labamount; ?>" readonly></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="center">
              <input  type="radio" name="labdesc" id="labdescp"  class="radioclass" onClick="CalcAmount1('labdescamt')"  value="L1" <?php if($labamount<=0 || $labamount==''){ echo 'disabled'; } ?>   >
              <input style="height:25px" type="text" name="labdescper" id="labdescper" onKeyUp="return CalcAmount('lab','labdescper','p')" size="10"  ></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="center">
               <input  type="radio" name="labdesc" id="labdesca" class="radioclass"  onClick="CalcAmount1('labdescper')"  value="L2" <?php if($labamount<=0 || $labamount==''){ echo 'disabled'; } ?> style="display:none">
              <input style="height:25px; display:none;" type="text" name="labdescamt" id="labdescamt" onKeyUp="return CalcAmount('lab','labdescamt','a')"  size="10"  ></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center">
              <input style="height:25px" type="text" name="labwaiver" id="labwaiver" readonly ></div></td>
				</tr>
                
                 <tr bgcolor="#ecf0f5">
			  <td height="46"  align="left" valign="center" class="bodytext31" style="padding:15px;"><div align="center">Radiology</div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="center">
              <input style="height:25px" type="text" name="radiology" id="radiology" value="<?php echo $radamount; ?>" readonly></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="center">
              <input  type="radio" name="raddesc" id="raddescp" class="radioclass"  onClick="CalcAmount1('raddescamt')"  value="R1" <?php if($radamount<=0 || $radamount==''){ echo 'disabled'; } ?> >
              <input style="height:25px" type="text" name="raddescper" id="raddescper" size="10" onKeyUp="return CalcAmount('radiology','raddescper','p')"  ></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="center">
               <input  type="radio" name="raddesc" id="raddesca" class="radioclass"  onClick="CalcAmount1('raddescper')"  value="R2" <?php if($radamount<=0 || $radamount==''){ echo 'disabled'; } ?> style="display:none">
              <input style="height:25px; display:none;" type="text" name="raddescamt" id="raddescamt" size="10"  onKeyUp="return CalcAmount('radiology','raddescamt','a')"  ></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center">
              <input style="height:25px" type="text" name="radwaiver" id="radwaiver" readonly></div></td>
			</tr>
                
                
                  <tr bgcolor="#ecf0f5">
			  <td class="bodytext31" style="padding:15px;" valign="center"  align="left"><div align="center">Services</div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="center">
              <input style="height:25px" type="text" name="services" id="services" value="<?php echo $seramount; ?>" readonly></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="center">
              <input  type="radio" name="serdesc" id="serdesc"  class="radioclass"  onClick="CalcAmount1('serdescamt')"  value="S1" <?php if($seramount<=0 || $seramount==''){ echo 'disabled'; } ?>  >
              <input style="height:25px" type="text" name="serdescper" id="serdescper" size="10" onKeyUp="return CalcAmount('services','serdescper','p')"></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="center">
               <input  type="radio" name="serdesc" id="serdesc" class="radioclass"  onClick="CalcAmount1('serdescper')"  value="S2" <?php if($seramount<=0 || $seramount==''){ echo 'disabled'; } ?> style="display:none" >
              <input style="height:25px; display:none;" type="text" name="serdescamt" id="serdescamt" size="10"  onKeyUp="return CalcAmount('services','serdescamt','a')"  ></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center">
              <input style="height:25px" type="text" name="serwaiver" id="serwaiver" readonly ></div></td>
				</tr>
                
                
                
                
                
                <tr bgcolor="#ecf0f5"> 
			  <td class="bodytext31" style="padding:15px;" valign="center"  align="left"><div align="center">Total</div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="center">             
              <input style="height:25px" type="text" name="totalamount" id="totalamount" value="<?php echo ($totalamount); ?>" readonly></div></td>
              
              
              <td class="bodytext31" valign="center"  align="left"><div align="center">
              <input  type="radio" name="totdesc" id="totdesc"  class="radioclass"  onClick="CalcAmount11('totdescamt')"  value="t1" <?php if($totalamount<=0 || $totalamount==''){ echo 'disabled'; } ?>  >
              <input style="height:25px" type="text" name="totdescper" id="totdescper" size="10" onKeyUp="return CalcAmount('totalamount','totdescper','p')"></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="center">
               <input  type="radio" name="totdesc" id="totdesc" class="radioclass"  onClick="CalcAmount11('totdescper')"  value="t2" <?php if($totalamount<=0 || $totalamount==''){ echo 'disabled'; } ?> style="display:none" >
              <input style="height:25px; display:none;" type="text" name="totdescamt" id="totdescamt" size="10"  onKeyUp="return CalcAmount('totalamount','totdescamt','a')"  ></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center">
              <input style="height:25px" type="text" name="totwaiver" id="totwaiver" readonly ></div></td>
				</tr>
               
				
                
                
                
			<!-- <tr bgcolor="#ecf0f5">
			  <td class="bodytext31" style="padding:15px;" valign="center"  align="left"><div align="center">Others</div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="center">
              <input style="height:25px" type="text" name="others" id="others" value="<?php echo $lab; ?>" onKeyUp="return CalcAmount('others','others','a')" ></div></td>
              <td class="bodytext31" valign="center"  align="left">         
             </td>
              <td class="bodytext31" valign="center"  align="left">             
             </td>
			  <td class="bodytext31" valign="center"  align="left">
            	</td>
				</tr>-->
			  <tr>
              
              <td class="bodytext31" valign="center"  align="center" 
                bgcolor="#ecf0f5"><strong>Comments</strong></td>
                
              <td colspan="3" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><textarea cols="40" rows="4" name="remarks" id="remarks"></textarea></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>            
             <td width="0%"  align="left" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
			 </tr>
           
          </tbody>
        </table>		</td>
      </tr>
     
      <tr>
        <td>
		<table width="99%" border="0" 
            align="left" cellpadding="2" cellspacing="0" 
            bordercolor="#666666" bgcolor="" id="AutoNumber3" style="BORDER-COLLAPSE: collapse">
            <tbody id="foo">
              <tr>
                <td colspan="14" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
                  <input name="delbillst" id="delbillst" type="hidden" value="billedit">
                  <input name="delbillautonumber" id="delbillautonumber" type="hidden" value="<?php echo $delbillautonumber;?>">
                  <input name="delbillnumber" id="delbillnumber" type="hidden" value="<?php echo $delbillnumber;?>">

				  <input name="Submit2223" type="submit" id="Submit222" value="Save Waivers" accesskey="s" class="button"/>
                </font></font></font></font></font></div></td>
              </tr>
			  
            </tbody>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr>
              <td width="54%" align="left" valign="top" ><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
               <strong>Approved By</strong><input type="text" name="username" value="<?php echo $employeename; ?>" size="15" readonly>
			    <input name="Button1" type="hidden" class="button" id="Button1" accesskey="c" style="border: 1px solid #001E6A" onClick="return funcRedirectWindow1()" value="Clear All"/>
                <input type="hidden" name="customersearch2" onClick="javascript:customersearch1('sales')" value="Customer Alt+M" accesskey="m" style="border: 1px solid #001E6A">
                <span class="bodytext31">
                <input type="hidden" name="itemsearch22" onClick="javascript:itemsearch1('sales')" style="border: 1px solid #001E6A">
                <span class="bodytext3">
				<?php
				if (isset($_REQUEST["src"])) { $src = $_REQUEST["src"]; } else { $src = ""; }
				//$src = $_REQUEST["src"];
				if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
				//$st = $_REQUEST["st"];
				if (isset($_REQUEST["billnumber"])) { $previousbillnumber = $_REQUEST["billnumber"]; } else { $previousbillnumber = ""; }
				//$previousbillnumber = $_REQUEST["billnumber"];
				
				if ($src == 'frm1submit1' && $st == 'success')
				{
				?>
				<!--
                <input onClick="return loadprintpage1('<?php echo $previousbillnumber; ?>')" value="A4 View Bill <?php echo $previousbillnumber; ?>" name="Button12" type="button" class="button" id="Button12" style="border: 1px solid #001E6A"/>
				-->
				<?php
				}
				?>
                </span></span></font></font></font></font></font></td>
            
			
            </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
  </table>
</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>