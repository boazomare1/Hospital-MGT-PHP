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
//echo $username;
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	$patientcode=$_REQUEST["patientcode"];
	$visitcode = $_REQUEST["visitcode"];
	$autonumber = $_REQUEST["auto_number"];
	$paracetalmol = $_REQUEST['paracetalmol'];
	$patientfirstname = $_REQUEST["patientfirstname"];
	$patientfirstname = strtoupper($patientfirstname);
	$patientmiddlename = $_REQUEST['patientmiddlename'];
	$patientmiddlename = strtoupper($patientmiddlename);
	$patientlastname = $_REQUEST["patientlastname"];
	$patientlastname = strtoupper($patientlastname);
	$patientfullname= $patientfirstname.' '.$patientmiddlename.' '.$patientlastname;
	$consultingdoctor = $_REQUEST["consultingdoctor"];
	$consultationtype = $_REQUEST["consultationtype"];
	$department = $_REQUEST["department"];
	$billtype=$_REQUEST['billtype'];
    $medicinename = $_REQUEST['medicinename'];
	$dose = $_REQUEST['dose'];
	$frequency = $_REQUEST['frequency'];
	$days = $_REQUEST['days'];
	$quantity = $_REQUEST['quantity'];
	$instructions = $_REQUEST['instructions'];
	$rate = $_REQUEST['rate'];
	$amount = $_REQUEST['amount'];
	$total = $_REQUEST['total'];
	$department1 = $_REQUEST['department1'];
	$drugallergy = $_REQUEST['drugallergy'];
	
	$query111 = "select * from master_department where auto_number = '$department1'";
	$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("erroe in query111".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res111 = mysqli_fetch_array($exec111);
	$res111department = $res111['department'];
	
	$consultationdate = date('Y-m-d H:i:s');
	$consultationtime  = date("H:i:s");
	$consultationfees  = $_REQUEST["consultationfees"];
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
	$foodallergy = $_REQUEST["foodallergy"];
	$accountname=$_REQUEST['accountname'];
	$notes=$_REQUEST['notes'];
	$user = $_REQUEST["user"];
	$buttonname = $_REQUEST['Submit222'];
	
	$query2 = "select * from master_triage where auto_number= '$autonumber'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec2);
	$res1patientcode = $res1["patientcode"];
	$res1visitcount = $res1["visitcount"];
	$serial = $_REQUEST['serialnumber'];
	$number = $serial - 1;
	
	$res2 = mysqli_num_rows($exec2);
	if ($res2 == 0)
	{
		$query3 = "select * from master_visitentry where recordstatus = ''";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rowcount3 = mysqli_num_rows($exec3);
		if ($rowcount3 != 0)
		{
			//header ("location:addtriage2.php?errorcode=errorcode1failed");
			//exit;
		
        $query1 = "insert into master_triage (patientcode,patientfirstname,patientmiddlename,patientlastname,patientfullname,visitcode,consultingdoctor,consultationtype,department,consultationdate,consultationtime,consultationfees,referredby,consultationremarks,visitcount,complaint,registrationdate,recordstatus,pulse,height,weight,bmi,fahrenheit,celsius,bpsystolic,bpdiastolic,respiration,headcircumference,bsa,urgentstatus,triagestatus,drugallergy,complanits,foodallergy,user,consultation,billtype,accountname,notes,paracetalmol,closevisit,department_refer,paymenttype,subtype) 
		values('$patientcode','$patientfirstname','$patientmiddlename','$patientlastname','$patientfullname','$visitcode','$consultingdoctor','$consultationtype','$department','$consultationdate','$consultationtime','$consultationfees','$referredby','$consultationremarks','$visitcount','$complaint','$registrationdate','$recordstatus','$pulse','$height','$weight','$bmi','$fahrenheit','$celsius','$bpsystolic','$bpdiastolic','$respiration','$headcircumference','$bsa','$urgentstatus','completed','$drugallergy','$complanits','$foodallergy','$user','incomplete','$billtype','$accountname','$notes','$paracetalmol','$closevisit','$res111department','$paymenttype','$subtype')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$querytr="update master_billing set triagestatus='completed' where visitcode='$visitcode'";
		$exectr=mysqli_query($GLOBALS["___mysqli_ston"], $querytr) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$querytr1="update master_visitentry set triagestatus='completed' where visitcode='$visitcode'";
		$exectr1=mysqli_query($GLOBALS["___mysqli_ston"], $querytr1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query2 = "select * from master_consultationpharm where patientcode='$patientcode' and patientvisitcode='$visitcode' order by auto_number desc limit 0, 1";
        $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res2 = mysqli_fetch_array($exec2);
        $medrefnonumber = $res2["refno"];

	/*	for ($p=1;$p<=$number;$p++)
		{	
		    //echo '<br>'.$i;
			//echo '<br>'.
			//$autonumber = $_REQUEST['autonumber'.$p];	
			//echo '<br>'.
		    $medicinename = $_REQUEST['medicinename'.$p];
			$query77="select * from master_medicine where itemname='$medicinename'";
			$exec77=mysql_query($query77);
			$res77=mysql_fetch_array($exec77);
			$medicinecode=$res77['itemcode'];
			$dose = $_REQUEST['dose'.$p];
		    $frequency = $_REQUEST['frequency'.$p];
			$sele=mysql_query("select * from master_frequency where frequencycode='$frequency'") or die(mysql_error());
			$ress=mysql_fetch_array($sele);
			$frequencyautonumber=$ress['auto_number'];
			$frequencycode=$ress['frequencycode'];
			$frequencynumber=$ress['frequencynumber'];
			$days = $_REQUEST['days'.$p];
			$quantity = $_REQUEST['quantity'.$p];
			$instructions = $_REQUEST['instructions'.$p];
			$rate = $_REQUEST['rate'.$p];
			$amount = $_REQUEST['amount'.$p];
			
			//if ($medicinename != "" && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
			if ($medicinename != "")// && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
			{
		        //echo '<br>'. 
		       $query2 = "insert into master_consultationpharm(consultation_id,patientcode,patientauto_number,patientname,patientvisitauto_number,patientvisitcode,medicinename,dose,frequencyauto_number,frequencycode,frequencynumber,days,quantity,instructions,rate,amount,recordstatus,recorddate,ipaddress,consultingdoctor,billtype,accountname,paymentstatus,medicinecode,refno,pharmacybill,medicineissue,source) 
				values('$consultationid','$patientcode','$patientauto_number','$patientfullname','$patientvisit','$visitcode','$medicinename','$dose','$frequencyautonumber','$frequencycode','$frequencynumber','$days','$quantity','$instructions','$rate','$amount','completed','$consultationdate','$ipaddress','$consultingdoctor','$billtype','$accountname','pending','$medicinecode','$medrefnonumber','$status','pending','triage')";
				$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
				
				$query29 = "insert into master_consultationpharmissue(consultation_id,patientcode,patientauto_number,patientname,patientvisitauto_number,patientvisitcode,medicinename,dose,frequencyauto_number,frequencycode,frequencynumber,days,quantity,instructions,rate,amount,recordstatus,recorddate,ipaddress,consultingdoctor,billtype,accountname,paymentstatus,medicinecode,refno,prescribed_quantity,source) 
				values('$consultationid','$patientcode','$patientauto_number','$patientfullname','$patientvisit','$visitcode','$medicinename','$dose','$frequencyautonumber','$frequencycode','$frequencynumber','$days','$quantity','$instructions','$rate','$amount','completed','$consultationdate','$ipaddress','$consultingdoctor','$billtype','$accountname','$status','$medicinecode','$medrefnonumber','$quantity','triage')";
				$exec29 = mysql_query($query29) or die ("Error in Query29".mysql_error());
			
				}
				
}	*/	

	
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
		$user = '';
		header ("location:triagelist1.php?patientcode=$patientcode&&st=success");
		
	   exit;
		}
	}
	else
	{
		header ("location:addtriage2.php?patientcode=$patientcode&&st=failed");
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
	$complanits = '';
	$foodallergy = '';
	$user = '';
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
     	$query2 = "select * from master_billing where visitcode = '$visitcode'";//order by auto_number desc limit 0, 1";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$num2=mysqli_num_rows($exec2);
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
		$consultationfees  = $res2["consultationfees"];
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
<script type="text/javascript" src="js/autosuggestfood1.js"></script> <!-- For searching customer -->
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
.style5 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration: none; }
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

function FunctionTemperature()
{
	if(document.form1.celsius.value != "" )
	{
		var fahrenheit = document.getElementById("fahrenheit").value;
		var celsius = document.getElementById("celsius").value;
		var fahrenheit = Math.round(1.8 * celsius + 32);
		document.getElementById("fahrenheit").value = fahrenheit;
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
<body onLoad="return funcOnLoadBodyFunctionCall2();">
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
     <form name="form1" id="form1" method="post" action="addtriage2.php" onKeyDown="return disableEnterKey(event)" onSubmit="return process1();">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="860" align="right"><table width="1267" height="684" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
                <td height="21" colspan="10" bgcolor="#ecf0f5" class="style2">Details</td>
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
                <td height="35" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Patient Name </td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="style2">
                  <?php echo $patientfirstname; ?> <?php echo $patientmiddlename; ?> <?php echo $patientlastname; ?>
				  <input type="hidden" name="billtype" value="<?php echo $billtype; ?>">
                  <input type="hidden" name="patientfirstname" id="patientfirstname"  value="<?php echo $patientfirstname; ?>" readonly="readonly"  style="border: 1px solid #001E6A;"  size="20">
                 <input type="hidden" name="patientmiddlename" id="patientmiddlename" value="<?php echo $patientmiddlename; ?>" readonly="readonly" style="border: 1px solid #001E6A;"  size="20" />
                  <input type = "hidden" name="patientlastname" id="patientlastname" value="<?php echo $patientlastname; ?>" readonly="readonly" style="border: 1px solid #001E6A;"  size="20" /></td>
				   <td height="35" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Type </td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><lable><?php echo $res121paymenttype; ?></lable>
				<input type = "hidden" name="paymenttype" id="paymenttype" value="<?php echo $res121paymenttype; ?>" readonly="readonly" style="border: 1px solid #001E6A;"  size="20" /></td>
				<td height="35" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Sub Type </td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><lable><?php echo $res131subtype; ?></lable>
				<input type = "hidden" name="subtype" id="subtype" value="<?php echo $res131subtype; ?>" readonly="readonly" style="border: 1px solid #001E6A;"  size="20" /></td>
              </tr>
             
				
              <tr>
                <td width="9%" height="37" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Reg No </td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><label><?php echo $patientcode; ?>
                  <input name="patientcode" id="patientcode" type = "hidden" value="<?php echo $patientcode; ?>"  readonly="readonly" style="border: 1px solid #001E6A"  size="20" />
                </label></td>
				<td width="9%" height="37" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">OP Date </td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><label><?php echo $registrationdate; ?>
                  <input type="hidden" name="registrationdate" id="registrationdate" value="<?php echo $registrationdate; ?>" style="border: 1px solid #001E6A" >
                <input type="hidden" name="consultationfees" value="<?php echo $consultationfees ?>">
				</label></td>
				
                <td width="12%" height="37" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Department</td>
                <td width="24%" colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><label><?php echo $departmentanum;?>
                  <input type="hidden" name="department" value="<?php echo $departmentanum;?>" style="border: 1px solid #001E6A;">
                </label></td>
              </tr>
			  
              <tr>
                <td width="9%" height="35" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">OP Visit </td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><strong>
                  <!--				   
				    <select name="hidden" id="visittype" >
                      <?php
				if ($visittype == '')
				{
					echo '<option value="" selected="selected">Select Visit Type</option>';
				}
				else
				{
					$query51 = "select * from master_visittype where recordstatus = ''";
					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res51 = mysqli_fetch_array($exec51);
					$res51visittype = $res51["visittype"];
					//echo '<option value="">Select Normal Tax</option>';
					echo '<option value="'.$res51visittype.'" selected="selected">'.$res51visittype.'</option>';
				}
				
				$query5 = "select * from master_visittype where recordstatus = '' order by visittype";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5 = mysqli_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5visittype = $res5["visittype"];
				?>
                      <option value="<?php echo $res5visittype; ?>"><?php echo $res5visittype; ?></option>
                      <?php
				}
				?>
                    </select>
-->
                  </strong>
                    <label><?php echo $visitcode; ?>
                    <input type= "hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" readonly="readonly" style="border: 1px solid #001E6A;"  size="20" />
                    </label></td>
					<td width="9%" height="35" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"> Time </td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><label><?php echo $consultationtime; ?>
                  <input name="consultationtime" id="consultationtime" type = "hidden" value="<?php echo $consultationtime; ?>" readonly="readonly" style="border: 1px solid #001E6A"  size="20" />
                </label>				</td>
                <td width="12%" height="35" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Consulting Doctor </td>
                <td colspan="3" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><!--<input type="hidden" name="department" id="department" value="<?php echo $department; ?>" style="border: 1px solid #001E6A;"  size="20" />-->
                    <label><?php echo $consultingdoctoranum;?>
                    <input name="consultingdoctor" type="hidden" id="consultingdoctor" value="<?php echo $consultingdoctoranum;?>" style="border: 1px solid #001E6A;">
                  </label></td>
              </tr>
              <tr>
               <td width="9%" height="35" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Location</td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><label><?php //echo $patientcode; ?>
                  <input type = "hidden" name="location" id="location" value="<?php //echo $patientcode; ?>"  readonly="readonly" style="border: 1px solid #001E6A"  size="20" />
                </label></td>
				
				<td width="9%" height="35" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Visit Type</td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><label><?php echo $billtype; ?>
                  <input type="hidden" name="visittype" id="visittype" value="<?php echo $billtype; ?>"  readonly="readonly" style="border: 1px solid #001E6A"  size="20" />
                </label></td>
	
				<td width="12%" height="35" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Account Name </td>
                <td colspan="3" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">
                  <label><?php echo $planname; ?>
                  <input type="hidden" name="accountname" id="accountname" value="<?php echo $planname; ?>" style="border: 1px solid #001E6A;">
                  </label>
                </td>
              </tr>
              <tr>
                <td height="21" colspan="10" align="left" valign="middle"  bgcolor="#ecf0f5" class="style2">Triage Details </td>
                </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Height (cms)</td>
                <td width="12%" align="left" valign="middle"  bgcolor="#ecf0f5"><input name="height" type="text" id="height"   size="10" onKeyUp="return FunctionBMI()" onKeyPress="return isNumber(event)" style="border: 1px solid #001E6A;"></td>
                <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Weight (kgs)</span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><input name="weight" type="text" id="weight"  size="10"  onKeyUp="return FunctionBMI()" onKeyPress="return isNumber(event)" style="border: 1px solid #001E6A;"></td>
                <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">BMI</td>
                <td width="15%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><input name="bmi" type="text" id="bmi"  value="" size="10"style="border: 1px solid #001E6A;"></td>
				<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Paracetalmol Syrup(mls)</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><input name="paracetalmol" type="text" id="paracetalmol"  size="10"  onKeyUp="return FunctionBMI()" onKeyPress="return isNumber(event)" style="border: 1px solid #001E6A;"></td>
              </tr>
			  	
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Systolic</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">
                  <input name="bpsystolic" type="text" id="bpsystolic"  onBlur="return MinimumBP()" onKeyPress="return isNumber(event)" style="border: 1px solid #001E6A;" size="10">
                </span></td>
                <td  align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Diastolic</span></td>
                <td  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><input name="bpdiastolic" type="text" id="bpdiastolic" onBlur="return MaximumBP()" onKeyPress="return isNumber(event)" style="border: 1px solid #001E6A;" size="10"></td>
                <td height="35" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Pulse</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">
                  <input name="pulse" type="text" id="pulse" onKeyPress="return isNumber(event)" style="border: 1px solid #001E6A;" size="10">
                </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Respiration</span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><input name="respiration" type="text" id="respiration" onKeyPress="return isNumber(event)" style="border: 1px solid #001E6A;" size="10"></td>
           
       
			                  </tr>
				
              <tr>
                   <td height="35" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Temp-C</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">
                  <input name="celsius" type="text" id="celsius" onKeyUp="return FunctionTemperature()" onKeyPress="return isNumber(event)" style="border: 1px solid #001E6A;" size="10">
                </span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Temp-F</span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><input name="fahrenheit" id="fahrenheit"  style="border: 1px solid #001E6A;" size="10"></td>
               <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">BSA</span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">
                  <input name="bsa" type="text" id="bsa" onKeyPress="return isNumber(event)" style="border: 1px solid #001E6A;" size="10">
                </span></td>
       
			    <td height="35" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><label>Head Circumference</label></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><label><span class="bodytext32">
                  <input name="headcircumference" type="text" id="headcircumference" onKeyPress="return isNumber(event)" style="border: 1px solid #001E6A;" size="10">
                </span></label></td>
              </tr>
              <tr>
                <td  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">BMI Category</td>
                <td  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><div align="left">
                    <input type="text" name="bmicategory" id="bmicategory" class="bal" readonly="readonly" size="21">
                </div></td>
                <td  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
              </tr>
				
				<tr>
				<td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Food Allergy</td>
				<td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Drug Allery</td>
				<td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Cheif Complaints</span></td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Notes</span></td>
                </tr>
				
				<tr>
				<td height="55" colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="food" id="food" type="text" class="bodytext3" size="40"  autocomplete="off" style="border: 1px solid #001E6A;" >
                  <input name="autonumber" id="autonumber" type="hidden" /></td>
				 <td height="55" colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><label>
                  <input name="drug" type="text" class="bodytext3" id="drug" autocomplete="off" style="border: 1px solid #001E6A;" size="40">
				  <input name = "drughidden1" id="drughidden1" type="hidden">
                 </label></td>
				 
                <td height="55" colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><label>
                  <textarea name="complanits" cols="40" class="bodytext32" id="complanits" style="border: 1px solid #001E6A"></textarea>
                </label></td>
                <td height="55" colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><label>
                  <textarea name="notes" cols="40" class="bodytext32" id="notes" style="border: 1px solid #001E6A"></textarea>
                </label></td>
                 
				 </tr>
				<tr>
				<td height="59" colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><label></label>
                <label></label>
                <label>
                  <textarea name="foodallergy" cols="40" rows="3" class="bodytext32" id="foodallergy" style="border:1px solid #001E6A;" ></textarea>
                </label>
                  <label></label></td>
				  <td height="59" colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5">
				  <textarea name="drugallergy" cols="40" rows="3" class="bodytext32" id="drugallergy" style="border: 1px solid #001E6A;"></textarea>
				  <input type="hidden" name="genericname" class="bodytext32" id="genericname" value=""></td>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  <td height="59" colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  </tr>
				  
                 <!-- <tr>
				   <td height="21" colspan="10" align="left" valign="middle"  bgcolor="#ecf0f5" class="style2"><strong>Prescription</strong> <span class="bodytext32"> <img src="images/plus1.gif" width="13" height="13"   onDblClick="return funcpresHideView()" onClick="return funcpresShowView()"> </span></td>
			      </tr>-->
				 <!--<tr id="pressid">
				   <td colspan="10" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				   <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="200" class="bodytext3">Medicine Name</td>
                       <td width="48" class="bodytext3">Dose</td>
                       <td width="41" class="bodytext3">Freq</td>
                       <td width="48" class="bodytext3">Days</td>
                       <td width="48" class="bodytext3">Quantity</td>
                       <td width="120" class="bodytext3">Instructions</td>
                       <td class="bodytext3">Rate</td>
                       <td width="48" class="bodytext3">Amount</td>
                       <td width="42" class="bodytext3">&nbsp;</td>
                     </tr>
					 <tr>
					 <div id="insertrow">					 </div></tr>
                     <tr>
					  <input type="hidden" name="serialnumber" id="serialnumber" value="1">
					  <input type="hidden" name="medicinecode" id="medicinecode" value="">
					   <input name="searchmedicinename1hiddentextbox" id="searchmedicinename1hiddentextbox" type="hidden" value="">
			  <input name="searchmedicineanum1" id="searchmedicineanum1" value="" type="hidden">
			
                       <td><input name="medicinename" type="text" id="medicinename" size="40" autocomplete="off"></td>
                       <td><input name="dose" type="text" id="dose" size="8" onKeyUp="return Functionfrequency()"></td>
                       <td>
					   <select name="frequency" id="frequency" onChange="return Functionfrequency()">
					     <?php
				if ($frequncy == '')
				{
					echo '<option value="select" selected="selected">Select frequency</option>';
				}
				else
				{
					$query51 = "select * from master_frequency where recordstatus = ''";
					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res51 = mysqli_fetch_array($exec51);
					$res51code = $res51["frequencycode"];
					$res51num = $res51['frequencynumber'];
					echo '<option value="'.$res51num.'" selected="selected">'.$res51code.'</option>';
				}
				$query5 = "select * from master_frequency where recordstatus = '' order by auto_number";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5 = mysqli_fetch_array($exec5))
				{
				$res5num = $res5["auto_number"];
				$res5code = $res5["frequencycode"];
				?>
                <option value="<?php echo $res5num; ?>"><?php echo $res5code; ?></option>
                 <?php
				}
				?>
               </select>				</td>	
                       <td><input name="days" type="text" id="days" size="8" onKeyUp="return Functionfrequency()" onFocus="return frequencyitem()"></td>
                       <td><input name="quantity" type="text" id="quantity" size="8" readonly></td>
                       <td><input name="instructions" type="text" id="instructions" size="20"></td>
                       <td width="48"><input name="rate" type="text" id="rate" readonly size="8"></td>
                       <td>
                         <input name="amount" type="text" id="amount" readonly size="8"></td>
						 <td>
                         <input name="formula" type="hidden" id="formula" readonly size="8"></td>
						  <td>
                         <input name="strength" type="hidden" id="strength" readonly size="8"></td>
                       <td><label>
                       <input type="button" name="Add" id="Add" value="Add" onClick="return insertitem10()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
                     
					 <input type="hidden" name="h" id="h" value="0">
                   </table>				  </td>
			       </tr>-->
				 <!--<tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total</span><input type="text" id="total" name="total" readonly size="7"></td>
			      </tr>-->
			  
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><div align="center">Urgent</div></td>
                <td height="28" colspan="1" align="left" valign="middle"  bgcolor="#ecf0f5">
				  <input name="urgentstatus" id="urgentstatus" type="checkbox" value="Checked" ></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><div align="center">close Visit</div></td>
                <td height="28" colspan="1" align="left" valign="middle"  bgcolor="#ecf0f5">
				  <input name="closevisit" id="closevisit" type="checkbox" value="Checked" ></td>
				 <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><div align="center">Refer</div></td>
				 <td height="28" colspan="1" align="left" valign="middle"  bgcolor="#ecf0f5">
				 <select name="department1" id="department1" style="border: 1px solid #001E6A;">
                          <?php
				if ($department == '')
				{
					echo '<option value="" selected="selected">Select department</option>';
				}
				else
				{
					$query51 = "select * from master_department where recordstatus = ''";
					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res51 = mysqli_fetch_array($exec51);
					$res51department = $res51["department"];
					$res51anum = $res51['auto_number'];
					echo '<option value="'.$res51anum.'" selected="selected">'.$res51department.'</option>';
				}
				
				$query5 = "select * from master_department where recordstatus = '' order by department";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5 = mysqli_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5department = $res5["department"];
				?>
                          <option value="<?php echo $res5anum; ?>"><?php echo $res5department; ?></option>
                          <?php
				}
				?>
                        </select></td>
                </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><div align="center">User Name </div></td>
                <td height="32" colspan="1" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="text" name="user" id="user" style="border: 1px solid #001E6A" value="<?php echo $_SESSION['username']; ?>"></td>
                </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="34" colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5"><div align="right"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input type="hidden" name="frmflag1" value="frmflag1" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
                  <input name="Submit222" type="submit"  value="Save Triage (Alt+S)" accesskey="s" class="button" id="submit" style="border: 1px solid #001E6A"/>
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