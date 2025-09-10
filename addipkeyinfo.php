<?php 
session_start();
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$pagename = "";
$username = $_SESSION['username'];


$query1111 = "select * from master_employee where username = '$username'";
    $exec1111 = mysqli_query($GLOBALS["___mysqli_ston"], $query1111) or die ("Error in Query1111".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res1111 = mysqli_fetch_array($exec1111))
	{
	$username = $res1111["username"];
	$locationnumber = $res1111["location"];
	$query1112 = "select * from master_location where auto_number = '$locationnumber'";
    $exec1112 = mysqli_query($GLOBALS["___mysqli_ston"], $query1112) or die ("Error in Query1112".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res1112 = mysqli_fetch_array($exec1112))
	{
		 $locationname = $res1112["locationname"];		  
		 $locationcode = $res1112["locationcode"];
		 $prefix = $res1112["prefix"];
		 $suffix = $res1112["suffix"];
	}
	}

//echo $username;
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	$patientcode=$_REQUEST["patientcode"];
	$visitcode = $_REQUEST["visitcode"];
	$autonumber = $_REQUEST["auto_number"];
	$patientfirstname = $_REQUEST["patientfirstname"];
	$patientfirstname = strtoupper($patientfirstname);
	$patientmiddlename = $_REQUEST['patientmiddlename'];
	$patientmiddlename = strtoupper($patientmiddlename);
	$patientlastname = $_REQUEST["patientlastname"];
	$patientlastname = strtoupper($patientlastname);
	$patientfullname= $patientfirstname.' '.$patientmiddlename.' '.$patientlastname;
	$billtype=$_REQUEST['billtype'];
    $drugallergy = $_REQUEST['drugallergy'];
	$privatedoctor = $_REQUEST['privatedoctor'];
	$emergencycontact = $_REQUEST['emergencycontact'];

	$consultationdate = date('Y-m-d H:i:s');
	$consultationtime  = date("H:i:s");
	//$consultationfees  = $_REQUEST["consultationfees"];
	$referredby = $_REQUEST["referredby"];
	$consultationremarks = $_REQUEST["consultationremarks"];
	$complaint = $_REQUEST["complaint"];
    $registrationdate = $_REQUEST["registrationdate"];
	$paymenttype = $_REQUEST['paymenttype'];
	$subtype = $_REQUEST['subtype'];
	$pulse = $_REQUEST["pulse"];
	$height = $_REQUEST["height"];
	$weight = $_REQUEST["weight"];
	$bmi = $_REQUEST["bmi"];
	$respiration = $_REQUEST["respiration"];
	$headcircumference = $_REQUEST["headcircumference"];
	$bsa = $_REQUEST["bsa"];
	$fahrenheit = $_REQUEST["fahrenheit"];
	$celsius = $_REQUEST["celsius"];
	$bpsystolic = $_REQUEST["bpsystolic"];
	$bpdiastolic = $_REQUEST["bpdiastolic"];
    $urgentstatus = $_REQUEST["urgentstatus"];	
	$urgentstatus = isset($_POST["urgentstatus"])? 1 : 0;
	$closevisit = $_REQUEST["closevisit"];
	$closevisit = isset($_POST["closevisit"])? 1: 0;  //checking the check box status	
    $drugallergy = $_REQUEST["drugallergy"];
	$complanits = $_REQUEST["complanits"];
	$privatedoctor = $_REQUEST['privatedoctor'];
	$emergencycontact = $_REQUEST['emergencycontact'];
	$foodallergy = $_REQUEST["foodallergy"];
	$accountname=$_REQUEST['accountname'];
	$notes=$_REQUEST['notes'];
	$user = $_REQUEST["user"];
	$buttonname = $_REQUEST['Submit222'];
	
	$query2 = "select * from master_iptriage where auto_number= '$autonumber'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec2);
	$res1patientcode = $res1["patientcode"];
	$res1visitcount = $res1["visitcount"];
	$serial = $_REQUEST['serialnumber'];
	$number = $serial - 1;
	
	$res2 = mysqli_num_rows($exec2);
	if ($res2 == 0)
	{
		$query3 = "select * from master_ipvisitentry where recordstatus = ''";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rowcount3 = mysqli_num_rows($exec3);
		if ($rowcount3 != 0)
		{
			//header ("location:addtriage2.php?errorcode=errorcode1failed");
			//exit;
		
        $query1 = "insert into master_iptriage (patientcode,patientfirstname,patientmiddlename,patientlastname,patientfullname,visitcode,consultingdoctor,consultationtype,department,consultationdate,consultationtime,consultationfees,referredby,consultationremarks,visitcount,complaint,registrationdate,recordstatus,pulse,height,weight,bmi,fahrenheit,celsius,bpsystolic,bpdiastolic,respiration,headcircumference,bsa,urgentstatus,triagestatus,drugallergy,complanits,foodallergy,user,consultation,billtype,accountname,notes,paracetalmol,closevisit,department_refer,paymenttype,subtype,privatedoctor,emergencycontact,locationname,locationcode) 
		values('$patientcode','$patientfirstname','$patientmiddlename','$patientlastname','$patientfullname','$visitcode','$consultingdoctor','$consultationtype','$department','$consultationdate','$consultationtime','$consultationfees','$referredby','$consultationremarks','$visitcount','$complaint','$registrationdate','$recordstatus','$pulse','$height','$weight','$bmi','$fahrenheit','$celsius','$bpsystolic','$bpdiastolic','$respiration','$headcircumference','$bsa','$urgentstatus','completed','$drugallergy','$complanits','$foodallergy','$user','incomplete','$billtype','$accountname','$notes','$paracetalmol','$closevisit','$res111department','$paymenttype','$subtype','$privatedoctor','$emergencycontact','$locationname','$locationcode')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		

	
		//$patientcode = '';
		//$visitcode = '';
		$patientcode = '';
		$patientfirstname = '';
		$patientmiddlename = '';
		$patientlastname = '';
		$consultingdoctor = '';
		$consultationtype = '';
		$department = '';
		$consultationdate = '';
		$consultationtime = '';
		$consultationfees = '';
		$referredby = '';
		$consultationremarks = '';
		$complaint = '';
		$registrationdate = '';
		$recordstatus = '';
		$pulse = '';
		$height = '';
		$weight = '';
		$bmi = '';
		$respiration = '';
		$headcircumference = '';
		$bsa = '';
		$fahrenheit = '';
		$celsius = '';
		$bpsystolic = '';
		$bpdiasystolic = '';
		$urgentstatus = '';
		$triagestatus = '';
		$drugallergy = '';
		$complanits = '';
		$foodallergy = '';
		$privatedoctor = '';
		$emergencycontact = '';
		$user = '';
		header ("location:addipkeyinfo.php?patientcode=$patientcode&&st=success");
		
	   exit;
		}
	}
	else
	{
		header ("location:addipkeyinfo.php?patientcode=$patientcode&&st=failed");
	}
    
}

else
{
	$patientcode = '';
	$visitcode = '';
	$patientfirstname = '';
	$patientmiddlename = '';
	$patientlastname = '';
	$consultationtype = '';
	$consultingdoctor = '';
	$consultationdate = '';
	$consultationtime = '';
	$consultationfees = '';
	$referredby = '';
	$consultationremarks = '';
	$complaint = '';
	$registrationdate = '';
    $recordstatus = '';
	$pulse = '';
	$height = '';
	$weight = '';
	$bmi = '';
	$fahrenheit = '';
	$celsius = '';
	$bpsystolic = '';
	$bpdiasystolic = '';
	$urgentstatus = '';
	$triagestatus = '';
	$drugallergy = '';
	$privatedoctor = '';
	$emergencycontact = '';
	$complanits = '';
	$foodallergy = '';
	$user = '';
}

if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
     	$query2 = "select * from master_ipvisitentry where visitcode = '$visitcode'";//order by auto_number desc limit 0, 1";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$num2=mysqli_num_rows($exec2);
		
		$query12 = "select * from ip_bedallocation where visitcode = '$visitcode'";//order by auto_number desc limit 0, 1";
		$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res12 = mysqli_fetch_array($exec12);
		$num12=mysqli_num_rows($exec12);
        $bednumber = $res12['bed'];
		
		
		if($num2 > 0)
		{
		$patientcode = $res2['patientcode'];
		$patientfirstname = $res2['patientfirstname'];
		$patientfirstname = strtoupper($patientfirstname);
	    $patientmiddlename = $res2['patientmiddlename'];
		$patientmiddlename = strtoupper($patientmiddlename);
		$patientlastname = $res2['patientlastname'];
		$patientlastname = strtoupper($patientlastname);
		$registrationdate = date('Y-m-d');
		$consultingdoctoranum = $res2['consultingdoctor'];
		$billtype=$res2['billtype'];
		$planname=$res2['accountname'];
				
		$departmentanum = $res2['department'];
		$consultationtype = $res2["consultationtype"];
	    $consultationdate = $res2["consultationdate"];
		$consultationtime  = $res2["consultationtime"];

		$billamount = $consultationfees;
		$referredby = $res2["referredby"];
		$paymenttype = $res2["paymenttype"];
		$consultationremarks = $res2["consultationremarks"];
		//$complaint = $res2["complaint"];
		$consultationtypeanum = $res2["consultationtype"];
		
		$query3 = "select * from master_consultationtype where auto_number = '$consultationtypeanum'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res3 = mysqli_fetch_array($exec3);
	    $consultationtype = $res3["consultationtype"];
		$visitcount = $res2['visitcount'];
		}
		else
		{
		$query44="select * from master_visitentry where visitcode = '$visitcode'";
		$exec44=mysqli_query($GLOBALS["___mysqli_ston"], $query44);
		$res44=mysqli_fetch_array($exec44);
		$patientfirstname = $res44['patientfirstname'];
		 $patientfirstname = strtoupper($patientfirstname);
	    $patientmiddlename = $res44['patientmiddlename'];
		$patientmiddlename = strtoupper($patientmiddlename);
		$patientlastname = $res44['patientlastname'];
		 $patientlastname = strtoupper($patientlastname);
		 $patientfullname=$patientfirstname.' '.$patientmiddlename.' '.$patientlastname;

 $departmentname=$res44['department'];
 $billtype=$res44['billtype'];
 $query231="select * from master_department where auto_number='$departmentname'";
 $exec231=mysqli_query($GLOBALS["___mysqli_ston"], $query231) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
 $res231=mysqli_fetch_array($exec231);
$departmentanum=$res231['department'];
 
		$consultingdoctorname=$res44['consultingdoctor'];
  $query232="select * from master_doctor where auto_number='$consultingdoctorname'";
 $exec232=mysqli_query($GLOBALS["___mysqli_ston"], $query232) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
 $res232=mysqli_fetch_array($exec232);
 $consultingdoctoranum=$res232['doctorname'];

 $accountname=$res44['accountname'];

 $query233="select * from master_accountname where auto_number='$accountname'";
 $exec233=mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
 $res233=mysqli_fetch_array($exec233);
 
$planname = $res233['accountname'];
 
 $registrationdate = $res44["consultationdate"];
$consultationtime  = $res44["consultationtime"];
		}
	    //$pulse = $res2["pulse"];
	 
$query111  = "select * from master_customer where customercode = '$patientcode'";
$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
$res111 = mysqli_fetch_array($exec111);
$res111paymenttype = $res111['paymenttype'];
$res111maintype = $res111['maintype'];
$res111subtype = $res111['subtype'];	   

$query121 = "select * from master_paymenttype where auto_number = '$res111paymenttype'";
$exec121 = mysqli_query($GLOBALS["___mysqli_ston"], $query121) or die (mysqli_error($GLOBALS["___mysqli_ston"]));
$res121 = mysqli_fetch_array($exec121);
$res121paymenttype = $res121['paymenttype'];

$query131 = "select * from master_subtype where auto_number = '$res111subtype'";
$exec131 = mysqli_query($GLOBALS["___mysqli_ston"], $query131) or die ("Error in Query131".mysqli_error($GLOBALS["___mysqli_ston"]));
$res131 = mysqli_fetch_array($exec131);
$res131subtype = $res131['subtype'];

if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
//$patientcode = 'MSS00000009';

if ($patientcode != '')
{
	//echo 'Inside Patient Code Condition.';
	//$query3 = "select * from master_billing where recordstatus = ''";
	//$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	//$res3 = mysql_fetch_array($exec3);
	//$registrationdate = $res['registrationdate'];
	//$consultingdoctor = $res2['consultingdoctor'];
	//$department = $res2['department'];
	//$visitcount = $res2['visitcount'];
	//$consultationremarks = $res2["consultationremarks"];
	//$complaint = $res2["complaint"];
	//$consultationtype = $res2['consultationtype'];
	//$referredby = $res2["referredby"];

}
//$registrationdate = date('Y-m-d');
//$consultationdate = date('Y-m-d');
//$consultationtime = date('H:i');
//$consultationfees = '500';

//if (isset($_REQUEST["errorcode"])) { $errorcode = $_REQUEST["errorcode"]; } else { $errorcode = ""; }
//$patientcode = 'MSS00000009';
//if ($errorcode == 'errorcode1failed')
//{
	//$errmsg = 'Patient Already Visited Today. Cannot Proceed With Visit Entry. Save Not Completed.';	
//}

include ("autocompletebuild_foodallergy1.php");
include ("autocompletebuild_drugallergy1.php");
?>

<?php include ("js/dropdownlist1scriptingfood1.php"); ?>
<script type="text/javascript" src="js/autocomplete_foodallergy1.js"></script>
<script type="text/javascript" src="js/autosuggestfood1.js"></script>

 <!-- For searching customer -->
<!--<script type="text/javascript" src="js/autofoodearch2.js"></script>-->

<?php /*?><?php include ("js/dropdownlist1scriptingdrug1.php"); ?><?php */?>
<!--<script type="text/javascript" src="js/autocomplete_drugallergy1.js"></script>
<script type="text/javascript" src="js/autosuggestdrug1.js"></script>-->

<?php include ("js/dropdownlist1drug1.php"); ?>
<script type="text/javascript" src="js/autocomplete_newdrug.js"></script>
<script type="text/javascript" src="js/autosuggestnewdrug.js"></script>

<?php include ("js/dropdownlist1newscriptingmedicine1.php"); ?>
<script type="text/javascript" src="js/autosuggestnewmedicine1.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_newmedicineq.js"></script>
<script type="text/javascript" src="js/automedicinecodesearch2.js"></script>

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
 <!-- For searching customer -->

<!--<script type="text/javascript" src="js/autoitemcodesearch2.js"></script>-->

<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script language="javascript">
function funcpresShowView()
{
  if (document.getElementById("pressid") != null) 
     {
	 document.getElementById("pressid").style.display = 'none';
	}
	if (document.getElementById("pressid") != null) 
	  {
	  document.getElementById("pressid").style.display = '';
	 }
}

function funcpresHideView()
{		
 if (document.getElementById("pressid") != null) 
	{
	document.getElementById("pressid").style.display = 'none';
	}	
}



function btnDeleteClick(delID,pharmamount)
{
	//alert ("Inside btnDeleteClick.");
	var newtotal4;
	//alert(pharmamount);
	var varDeleteID = delID;
	//alert (varDeleteID);
	var fRet3; 
	fRet3 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet3 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child = document.getElementById('idTR'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
	document.getElementById ('insertrow').removeChild(child);
	
	var child = document.getElementById('idTRaddtxt'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
	//alert (child);
	if (child != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow').removeChild(child);
		
		
	}
	var currenttotal4=document.getElementById('total').value;
	//alert(currenttotal);
	newtotal4= currenttotal4-pharmamount;
	
	//alert(newtotal);
	
	document.getElementById('total').value=newtotal4;
	
	var currentgrandtotal4=document.getElementById('total4').value;
	
	if(document.getElementById('total1').value=='')
	{
	totalamount11=0;
	}
	else
	{
	totalamount11=document.getElementById('total1').value;
	}
	if(document.getElementById('total2').value=='')
	{
	totalamount21=0;
	}
	else
	{
	totalamount21=document.getElementById('total2').value;
	}
	if(document.getElementById('total3').value=='')
	{
	totalamount31=0;
	}
	else
	{
	totalamount31=document.getElementById('total3').value;
	}
	if(document.getElementById('total5').value=='')
	{
	totalamount41=0;
	}
	else
	{
	totalamount41=document.getElementById('total5').value;
	}
	
	var newgrandtotal4=parseInt(newtotal4)+parseInt(totalamount11)+parseInt(totalamount21)+parseInt(totalamount31)+parseInt(totalamount41);
	
	//alert(newgrandtotal4);
	
	document.getElementById('total4').value=newgrandtotal4.toFixed(2);	
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
</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
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
.style2 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
.bal
{
border-style:none;
background:none;
text-align:left;
FONT-FAMILY: Tahoma;
FONT-SIZE: 11px;
font-weight:bolder;
}
-->
</style>
</head>
<script type="text/javascript" src="js/insertnewitem10.js"></script>
<script type="text/javascript">
function funcOnLoadBodyFunctionCall1()
{

	funcpresHideView();
}	
function funcOnLoadBodyFunctionCall2()
{ 
	//alert ("Inside Body On Load Fucntion.");
	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	funcCustomerDropDownSearch14();
	funcCustomerDropDownSearch4();
	funcCustomerDropDownSearch1();
	funcCustomerDropDownSearch2();
	

	funcOnLoadBodyFunctionCall1();//To handle ajax dropdown list.
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
var formula = document.getElementById("formula").value;
//alert(formula);
if(formula == 'INCREMENT')
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
else if(formula == 'CONSTANT')
{
var ResultFrequency;
var strength = document.getElementById("strength").value;
//alert(strength);
 var frequencyanum = document.getElementById("frequency").value;
var medicinedose=document.getElementById("dose").value;
 var VarDays = document.getElementById("days").value; 
 if((frequencyanum != '') && (VarDays != ''))
 {
  ResultFrequency = medicinedose*frequencyanum*VarDays/strength;
 }
 else
 {
 ResultFrequency =0;
 }
 //ResultFrequency = parseInt(ResultFrequency);

 ResultFrequency = Math.ceil(ResultFrequency);
 //alert(ResultFrequency);
 document.getElementById("quantity").value = ResultFrequency;
 
 
var VarRate = document.getElementById("rate").value;
var ResultAmount = parseFloat(VarRate * ResultFrequency);
  document.getElementById("amount").value = ResultAmount.toFixed(2);
}
}
</script>

<script language="javascript">
function process1()
{
//alert("hi");

		if (document.form1.complanits.value == "")
	{
		alert ("Please Enter complaint");
		document.form1.complanits.focus();
		return false;
	}
	return true;
 }
	


function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        alert("Please enter a whole number");
		return false;
    }
    return true;
}
function FunctionBMI()
{	
 
	if(document.form1.height.value != "" && document.form1.weight.value != "")
	{
	    var height = document.getElementById("height").value;
		var weight = document.getElementById("weight").value;
		var bmi = (weight/(height/100*height/100));
		//alert(bmi);
		bmi=(bmi).toFixed(2);
		document.getElementById("bmi").value = bmi;	
		
		if(bmi < 18.5)
		{
		
		document.getElementById("bmicategory").value ="Under Weight(<18.5)";
		}
		if((bmi >= 18.5)&&(bmi <= 24.9))
		{
		document.getElementById("bmicategory").value ="Normal Weight(18.5-24.9)";
		}
		if((bmi >= 25)&&(bmi <= 29.9))
		{
		document.getElementById("bmicategory").value ="Over Weight(25-29.9)";
		}
		if((bmi) >= 30)
		{
		document.getElementById("bmicategory").value ="Obesity(>=30)";
		}
	}
	//else
//	{
//		document.form1.value == "";
//		alert("Please Enter Height and Weight");
//	}
}	

function functiondecimal(id)
{
if(document.getElementById(id).value!='')
{
//alert(document.getElementById(id).value);
document.getElementById(id).value=document.getElementById(id).value.replace(/[^0-9.]/g,"");
}
}
function FunctionTemperature()
{
	if(document.form1.celsius.value != "" )
	{
		var fahrenheit = document.getElementById("fahrenheit").value;
		var celsius = document.getElementById("celsius").value;
		var fahrenheit = Math.round(1.8 * celsius + 32);
		document.getElementById("fahrenheit").value = fahrenheit;
	}
	else
	{
	document.getElementById("fahrenheit").value ='';
	}
	
}
function FunctionTemperature1()
{
	if(document.form1.fahrenheit.value != "" )
	{
		var fahrenheit = document.getElementById("fahrenheit").value;
		var celsius = document.getElementById("celsius").value;
		var celsius = Math.round((fahrenheit - 32)/1.8);
		document.getElementById("celsius").value = celsius;
	}
	else
	{
	document.getElementById("celsius").value ='';
	}
	
}

function MinimumBP()
{
	if(document.form1.bpsystolic.value > 120 && document.form1.bpsystolic.value !="")
	{
		document.form1.bpsystolic.style.background="#FFFF66";
	}
	else
	{
		document.form1.bpsystolic.style.background="#FFFFFF";
	}
}
function MaximumBP()
{
	if(document.form1.bpdiastolic.value < 80)
	{
		document.form1.bpdiastolic.style.background="#FFFF66";
	}
	else
	{
		document.form1.bpdiastolic.style.background="#FFFFFF";
	}
}
 
</script>

<script>
function btnDeleteClick10(delID,pharmamount)
{
	//alert ("Inside btnDeleteClick.");
	var newtotal4;
	//alert(pharmamount);
	var varDeleteID = delID;
	//alert (varDeleteID);
	var fRet3; 
	fRet3 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet3 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child = document.getElementById('idTR'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
	document.getElementById ('insertrow').removeChild(child);
	
	var child = document.getElementById('idTRaddtxt'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
	//alert (child);
	if (child != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow').removeChild(child);
		
		
	}
	var currenttotal4=document.getElementById('total').value;
	//alert(currenttotal);
	newtotal4= currenttotal4-pharmamount;
	
	//alert(newtotal);
	
	document.getElementById('total').value=newtotal4;
}
</script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script src="js/datetimepicker_css.js"></script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return dd();">
<table width="103%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php 
	
		include ("includes/menu1.php"); 
	
	//	include ("includes/menu2.php"); 
	
	?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
	
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">
     <form name="form1" id="form1" method="post" action="addipkeyinfo.php" onKeyDown="return disableEnterKey(event)" onSubmit="return process();">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="860" align="right"><table width="1267" height="457" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
                <td height="21" colspan="15" bgcolor="#ecf0f5" class="style2">Details</td>
                <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                </tr>
              <!--<tr bordercolor="#000000" >
                  <td  align="left" valign="middle"  class="bodytext3"  colspan="4"><strong>Registration</strong></font></div></td>
                </tr>-->
              <!--<tr>
                  <tr  bordercolor="#000000" >
                  <td  align="left" valign="middle"  class="bodytext3" colspan="4"><div align="right">* Indicates Mandatory</div></td>
                </tr>-->
				<tr>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Patient Name </td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="style2">
                  <?php echo $patientfirstname; ?> <?php echo $patientmiddlename; ?> <?php echo $patientlastname; ?>
				  <input type="hidden" name="billtype" value="<?php echo $billtype; ?>">
                  <input type="hidden" name="patientfirstname" id="patientfirstname"  value="<?php echo $patientfirstname; ?>" readonly  style="border: 1px solid #001E6A;"  size="20">
                 <input type="hidden" name="patientmiddlename" id="patientmiddlename" value="<?php echo $patientmiddlename; ?>" readonly style="border: 1px solid #001E6A;"  size="20" />
                  <input type = "hidden" name="patientlastname" id="patientlastname" value="<?php echo $patientlastname; ?>" readonly style="border: 1px solid #001E6A;"  size="20" /></td>
				   <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">OP Visit </td>
                   <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Reg No </td>
                   <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Bed No </td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
              </tr>
             
				
              <tr>
                <td width="7%" height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><label></label></td>
				<td width="18%" height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><?php echo $visitcode; ?>
                  <input type= "hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" readonly style="border: 1px solid #001E6A;"  size="20" /></td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><?php echo $patientcode; ?>
                  <input name="patientcode" id="patientcode" type = "hidden" value="<?php echo $patientcode; ?>"  readonly="readonly" style="border: 1px solid #001E6A"  size="20" /></td>
				
                <td width="6%" height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><?php echo $bednumber; ?></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
              </tr>
			  
              <tr>
                <td height="21" colspan="15" align="left" valign="middle"  bgcolor="#ecf0f5" class="style2">Key Notes </td>
                </tr>
              <tr>
                <td height="32" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Weight (kgs) </td>
                <td width="12%" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">
                  <input name="weight" type="text" id="weight" TABINDEX=1 size="10"  onKeyUp="functiondecimal(this.id);return FunctionBMI()" onKeyPress="" style="border: 1px solid #001E6A;">
                </span></td>
                <td width="4%" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Systolic</span></td>
                <td width="7%" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">
                  <input name="bpsystolic" TABINDEX=3 type="text" id="bpsystolic"  onBlur="return MinimumBP()" onKeyPress="return isNumber(event)" style="border: 1px solid #001E6A;" size="10">
                </span></td>
                <td width="6%" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Pulse</span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><input name="pulse" TABINDEX=5 type="text" id="pulse" onKeyPress="return isNumber(event)" style="border: 1px solid #001E6A;" size="10"></td>
                <td width="4%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Temp-C</td>
                <td colspan="10" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><input name="celsius" type="text" TABINDEX=7 id="celsius" onKeyUp="functiondecimal(this.id);return FunctionTemperature()" style="border: 1px solid #001E6A;" size="10"></td>
                </tr>
			  	
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Height (cms)</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="height" TABINDEX=2 type="text" id="height"   size="10" onKeyUp="functiondecimal(this.id);return FunctionBMI()" onKeyPress="" style="border: 1px solid #001E6A;"></td>
                <td  align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Diastolic</span></td>
                <td  align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">
                  <input name="bpdiastolic" TABINDEX=3 type="text" id="bpdiastolic" onBlur="return MaximumBP()" onKeyPress="return isNumber(event)" style="border: 1px solid #001E6A;" size="10">
                </span></td>
                <td  align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Respiration</span></td>
                <td  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><input name="respiration" TABINDEX=6 type="text" id="respiration" onKeyPress="return isNumber(event)" style="border: 1px solid #001E6A;" size="10"></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Temp-F</span></td>
                <td height="32" colspan="10" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">
                  <input name="fahrenheit" id="fahrenheit" onKeyUp="functiondecimal(this.id);return FunctionTemperature1()" TABINDEX=8 style="border: 1px solid #001E6A;" size="10">
                </span></td>
                </tr>
				
				 <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">BMI</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">
                  <input name="bmi" type="text" id="bmi" TABINDEX=9 value="" size="10"style="border: 1px solid #001E6A;">
                </span></td>
                <td  align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td  align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td  align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td height="32" colspan="10" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                </tr>
				
				<tr>
				  <td height="10" colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Chief Complaints</td>
				  <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><textarea name="complanits" cols="40" TABINDEX=10 class="bodytext32" id="complanits1" style="border: 1px solid #001E6A"></textarea></td>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Notes</span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><textarea name="notes" cols="40" TABINDEX=11 class="bodytext32" id="notes" style="border: 1px solid #001E6A"></textarea></td>
				  <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				  </tr>
				<tr>
				  <td height="52" colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Food Allergy</td>
				  <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><p>
                      <textarea name="foodallergy" cols="40" rows="3" class="bodytext32" id="foodallergy" style="border:1px solid #001E6A;" ></textarea>
                    </p></td>
				  <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				  <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				  </tr>
				<tr>
				<td height="52" colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Drug Allery</td>
				<td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><p>
				    <textarea name="drugallergy" cols="40" rows="3" class="bodytext32" id="drugallergy" style="border: 1px solid #001E6A;"></textarea>
</p></td>
				<td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                </tr>
				
				<tr>
				<td height="28" colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Private Doctor </td>
				 <td height="28" colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><label>
				 <input name="privatedoctor" type="text" class="bodytext32" id="privatedoctor" autocomplete="off" style="border: 1px solid #001E6A;" size="40">
				   
				 </label></td>
				 
                <td height="28" colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><label></label></td>
                <td height="28" colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><label></label></td>
				 </tr>
				<tr>
			      <td height="28" colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
                  <label>Emergency Contact </label></td>
				  <td height="28" colspan="8" align="left" valign="middle"  bgcolor="#ecf0f5"><input name="emergencycontact" type="text" class="bodytext32" id="emergencycontact" autocomplete="off" style="border: 1px solid #001E6A;" size="40"></td>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  <td width="12%" height="28" colspan="3" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  </tr>
				  
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><div align="left">User Name </div></td>
                <td height="32" colspan="1" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="hidden" name="user" id="user" style="border: 1px solid #001E6A" value="">
                  <strong><?php echo strtoupper($username); ?></strong></td>
                </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="34" colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5"><div align="right"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input type="hidden" name="frmflag1" value="frmflag1" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
                  <input name="Submit222" type="submit"  value="Save (Alt+S)" accesskey="s" class="button" id="submit" style="border: 1px solid #001E6A"/>
				  <input name="Submit222" type="reset"  value="Reset (Alt+R)" accesskey="r" class="button" style="border: 1px solid #001E6A"/>
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
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>