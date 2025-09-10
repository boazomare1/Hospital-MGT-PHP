<?php 
session_start();
error_reporting(0);
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$pagename = "";
$username = $_SESSION['username'];
$todaysdate = date("Y-m-d");
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
	$consultationtype = $_REQUEST["doctorusername"];
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
	$intdrugs = $_REQUEST['intdrugs'];
	$drugdose = $_REQUEST['drugdose'];
	$route = $_REQUEST['route'];
	
	$query111 = "select * from master_department where auto_number = '$department1'";
	$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("erroe in query111".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res111 = mysqli_fetch_array($exec111);
	$res111department = $res111['department'];
	
	$query23 = "select * from master_triage where registrationdate = '$todaysdate' order by auto_number desc limit 0, 1";
	$exec23= mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res23 = mysqli_fetch_array($exec23);
	$token = $res23["token"];
	
	if ($token == '')
	{
		$billnumbercode1 = '1';
	}
	else
	{
		$billnumber1 = $res23["token"];
		$billnumbercode1 = $billnumber1;
		$billnumbercode1 = $billnumbercode1 + 1;
	}
	
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
    $urgentstatus = isset($_POST["urgentstatus"])? 1 : 0;
	$daycare = isset($_POST["daycare"])? 1 : 0; 
	$dm = isset($_POST["dm"])? 1 : 0;
	
	$cardiac = isset($_POST["cardiac"])? 1 : 0;
	
	$hypertension = isset($_POST["hypertension"])? 1 : 0;
	
	$epilepsy = isset($_POST["epilepsy"])? 1 : 0;
	
	$respiratory = isset($_POST["respiratory"])? 1 : 0;
	
	$renal = isset($_POST["renal"])? 1 : 0;
	
	$none = isset($_POST["none"])? 1 : 0;
	$other = $_REQUEST['other'];
	$gravida = $_REQUEST['gravida'];
	$para = $_REQUEST['para'];
	$abortion = $_REQUEST['abortion'];
	$familyhistory = $_REQUEST['familyhistory'];
	$surgicalhistory = $_REQUEST['surgicalhistory'];
	$transfusionhistory = $_REQUEST['transfusionhistory'];
	$smoking = isset($_POST["smoking"])? 1 : 0;
		
	$alcohol = isset($_POST["alcohol"])? 1 : 0;
	
	$drugs = isset($_POST["drugs"])? 1 : 0;
	
	$closevisit = isset($_POST["closevisit"])? 1 : 0;  //checking the check box status	
    $drugallergy = $_REQUEST["drugallergy"];
	$complanits = $_REQUEST["complanits"];
	$foodallergy = $_REQUEST["foodallergy"];
	$accountname=$_REQUEST['accountname'];
	$notes=$_REQUEST['notes'];
	$user = $_REQUEST["user"];
	$spo2 = $_REQUEST['spo2'];
	$lmp = $_REQUEST['lmp'];
	$edt = $_REQUEST['edt'];
	$bloodgroup = $_REQUEST['bloodgroup'];
	$hblevel = $_REQUEST['hblevel'];
	$vdrl = $_REQUEST['vdrl'];
	$pmtct = $_REQUEST['pmtct'];
	$urinalysis = $_REQUEST['urinalysis'];
	$gestationage = $_REQUEST['gestationage'];
	$noofvisit = $_REQUEST['noofvisit'];
	$urinedipstict = $_REQUEST['urinedipstict'];
	if($department=='MCH  CONSULTATION'){
	$closesvisits = isset($_POST["closesvisits"])? '': 'No';
	}
	else
	{
	$closesvisits = '';
	}
	//exit;
	$buttonname = $_REQUEST['Submit222'];
	
	$query2 = "select * from master_triage where visitcode='$visitcode' and closesvisits='' and consultationdate='$consultationdate'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec2);
	$res1patientcode = $res1["patientcode"];
	$res1visitcount = $res1["visitcount"];
	$serial = $_REQUEST['serialnumber'];
	$sysclr = $_REQUEST['sysclr'];
	$diaclr = $_REQUEST['diaclr'];
	$tempclr = $_REQUEST['tempclr'];
	$number = $serial - 1;
	
	$res2 = mysqli_num_rows($exec2);
	if ($res2 == 0)
	{
		$query13 = "insert into master_triage(patientcode,patientfirstname,patientmiddlename,patientlastname,patientfullname,visitcode,consultingdoctor,consultationtype,department,consultationdate,consultationtime,consultationfees,referredby,consultationremarks,visitcount,complaint,registrationdate,recordstatus,pulse,height,weight,bmi,fahrenheit,celsius,bpsystolic,bpdiastolic,respiration,headcircumference,bsa,urgentstatus,triagestatus,drugallergy,complanits,foodallergy,user,consultation,billtype,accountname,notes,closevisit,department_refer,paymenttype,subtype,token,dm,cardiac,hypertension,epilepsy,respiratory,renal,none,other,gravida,para,abortion,familyhistory,smoking,alcohol,drugs,surgicalhistory,transfusionhistory,spo2,lmp,edt,sysclr,diaclr,tempclr,intdrugs,dose,route,daycare,bloodgroup,hblevel,vdrl,pmtct,urinalysis,gestationage,noofvisit,urinedipstict,closesvisits)values('$patientcode','$patientfirstname','$patientmiddlename','$patientlastname','$patientfullname','$visitcode','$consultingdoctor','$consultationtype','$department','$consultationdate','$consultationtime','$consultationfees','$referredby','$consultationremarks','$visitcount','$complaint','$registrationdate','$recordstatus','$pulse','$height','$weight','$bmi','$fahrenheit','$celsius','$bpsystolic','$bpdiastolic','$respiration','$headcircumference','$bsa','$urgentstatus','completed','$drugallergy','$complanits','$foodallergy','$username','incomplete','$billtype','$accountname','$notes','$closevisit','$res111department','$paymenttype','$subtype','$billnumbercode1','$dm','$cardiac','$hypertension','$epilepsy','$respiratory','$renal','$none','$other','$gravida','$para','$abortion','$familyhistory','$smoking','$alcohol','$drugs','$surgicalhistory','$transfusionhistory','$spo2','$lmp','$edt','$sysclr','$diaclr','$tempclr','$intdrugs','$drugdose','$route','$daycare','$bloodgroup','$hblevel','$vdrl','$pmtct','$urinalysis','$gestationage','$noofvisit','$urinedipstict','$closesvisits')";
		$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		if($department == 'GENERAL')
		{
		$querytr13="update master_visitentry set triagestatus='completed' where visitcode='$visitcode'";
		$exectr13=mysqli_query($GLOBALS["___mysqli_ston"], $querytr13) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		
		if($closesvisits == '')
		{
		$querytr1="update master_visitentry set triagestatus='completed' where visitcode='$visitcode'";
		$exectr1=mysqli_query($GLOBALS["___mysqli_ston"], $querytr1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$querytr="update master_billing set triagestatus='completed' where visitcode='$visitcode'";
		$exectr=mysqli_query($GLOBALS["___mysqli_ston"], $querytr) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		}
		if($department != 'MCH  CONSULTATION')
		{
		$querytr11="update master_visitentry set triagestatus='completed' where visitcode='$visitcode'";
		$exectr11=mysqli_query($GLOBALS["___mysqli_ston"], $querytr11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$querytr1="update master_billing set triagestatus='completed' where visitcode='$visitcode'";
		$exectr1=mysqli_query($GLOBALS["___mysqli_ston"], $querytr1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		
		
		
		
		$query2 = "select * from master_consultationpharm where patientcode='$patientcode' and patientvisitcode='$visitcode' order by auto_number desc limit 0, 1";
        $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res2 = mysqli_fetch_array($exec2);
        $medrefnonumber = $res2["refno"];

			
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
		$daycare = '';
		$triagestatus = '';
		$drugallergy = '';
		$complanits = '';
		$foodallergy = '';
		$user = '';
		header ("location:triagebillinglist.php?patientcode=$patientcode&&st=success");
		
	   exit;
		
	}
	else
	{
		header ("location:triagelist1.php");
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

if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
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
$gender = $res111['gender'];
$dob = $res111['dateofbirth'];

$age = calculate_age($dob);

function calculate_age($birthday)
{
    $today = new DateTime();
    $diff = $today->diff(new DateTime($birthday));

    if ($diff->y)
    {
        return $diff->y . ' Years';
    }
    elseif ($diff->m)
    {
        return $diff->m . ' Months';
    }
    else
    {
        return $diff->d . ' Days';
    }
}

$query121 = "select * from master_paymenttype where auto_number = '$res111paymenttype'";
$exec121 = mysqli_query($GLOBALS["___mysqli_ston"], $query121) or die (mysqli_error($GLOBALS["___mysqli_ston"]));
$res121 = mysqli_fetch_array($exec121);
$res121paymenttype = $res121['paymenttype'];

$query131 = "select * from master_subtype where auto_number = '$res111subtype'";
$exec131 = mysqli_query($GLOBALS["___mysqli_ston"], $query131) or die ("Error in Query131".mysqli_error($GLOBALS["___mysqli_ston"]));
$res131 = mysqli_fetch_array($exec131);
$res131subtype = $res131['subtype'];

$query23 = "select * from master_triage where registrationdate = '$todaysdate' order by auto_number desc limit 0, 1";
$exec23= mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res23 = mysqli_fetch_array($exec23);
$token = $res23["token"];

$query651 = "update master_visitentry set triagestatus='Inprogress' where visitcode = '$visitcode'";
$exec651 = mysqli_query($GLOBALS["___mysqli_ston"], $query651) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

if ($token == '')
{
	$billnumbercode1 = '1';
}
else
{
	$billnumber1 = $res23["token"];
	$billnumbercode1 = $billnumber1;
	$billnumbercode1 = $billnumbercode1 + 1;
}

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

<?php include ("js/dropdownlist1doctortriage.php"); ?>
<script type="text/javascript" src="js/autocomplete_newdoctortriage.js"></script>
<script type="text/javascript" src="js/autosuggestdoctortriage.js"></script>

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
function closealert()
{
	if(document.getElementById('closesvisits').checked==true)
	{
		var cnfm = confirm("Now the Patient will move to MCH Consultation and clear Triage list. Do You want to Proceed?");
		 if (cnfm == false) {
				  document.getElementById('closesvisits').checked=false;
		}
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
.bodytext33 {FONT-WEIGHT: normal; FONT-SIZE: 15px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
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
	funcCustomerDropDownSearch1();
	funcCustomerDropDownSearch14();
	funcCustomerDropDownSearch141();
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
	
	/*if (document.form1.doctorusername.value == "")
	{
		alert ("Please Select Doctor");
		document.form1.doctor.focus();
		return false;
	}*/
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

function Tempcheck()
{
if(document.form1.celsius.value > 37.4 && document.form1.celsius.value !="")
	{
		document.form1.celsius.style.background="#FFFF66";
	}
	else
	{
		document.form1.celsius.style.background="#FFFFFF";
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
function checkvalid()
{
if(document.getElementById("dm").checked == false)
{
alert('h');
}
}
function funcsystolic()
{

document.getElementById("bpsystolic").style.borderColor="red";
document.getElementById("sysclr").value = "red";
}
function funcdiastolic()
{

document.getElementById("bpdiastolic").style.borderColor="red";
document.getElementById("diaclr").value = "red";
}

function functempc()
{

document.getElementById("celsius").style.borderColor="red";
document.getElementById("tempclr").value = "red";
}
function caps()
{
//alert("hi");
var bloodgroup = document.getElementById("bloodgroup").value ;
bloodgroup = bloodgroup.toUpperCase();
document.getElementById("bloodgroup").value = bloodgroup;
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
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">
     <form name="form1" id="form1" method="post" action="addretriage.php" onKeyDown="return disableEnterKey(event)" onSubmit="return process1();">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="860" align="right"><table width="1297" height="560" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr>
                <td colspan="6" align="left" class="bodytext32"><strong><?php echo $patientfirstname; ?> <?php echo $patientmiddlename; ?> <?php echo $patientlastname; ?> , <?php echo $gender; ?> , <?php echo $age; ?></strong></td>
                <td class="bodytext32" align="center">&nbsp;</td>
                <td class="bodytext32" align="center">&nbsp;</td>
                <td class="bodytext32" align="center">&nbsp;</td>
                <td class="bodytext32" align="center">&nbsp;</td>
                <td align="center" class="bodytext32">&nbsp;</td>
                <td class="bodytext32" align="center">&nbsp;</td>
                <td colspan="7" align="center" class="bodytext32">&nbsp;</td>
                <!--<td colspan="4" class="bodytext33" align="center"><strong>Token</strong> - <strong><?php echo $billnumbercode1; ?></strong></td>-->
              </tr>
              <tr>
                <td colspan="5" align="left" class="bodytext32"><strong> <?php echo $patientcode; ?> , <?php echo $visitcode; ?> , <?php echo $planname; ?></strong></td>
                <td align="center" class="bodytext32">&nbsp;</td>
                <td width="1%" align="center" class="bodytext32">&nbsp;</td>
                <td colspan="16" align="center" class="bodytext32">&nbsp;</td>
                </tr>
				
					<?php
					
					$query45 = "select * from master_triage where patientcode = '$patientcode' order by auto_number desc";
					$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$num45 = mysqli_num_rows($exec45);
					$res45 = mysqli_fetch_array($exec45);
					$dm = $res45['dm'];
					if($dm == '1')
					{
					$dm = 'YES';
					}
					else
					{
					$dm = '';
					}
					$cardiac = $res45['cardiac'];
					if($cardiac == '1')
					{
					$cardiac = 'YES';
					}
					else
					{
					$cardiac = '';
					}
					$hypertension = $res45['hypertension'];
					if($hypertension == '1')
					{
					$hypertension = 'YES';
					}
					else
					{
					$hypertension = '';
					}
					$epilepsy = $res45['epilepsy'];
					if($epilepsy == '1')
					{
					$epilepsy = 'YES';
					}
					else
					{
					$epilepsy = '';
					}
					$respiratory = $res45['respiratory'];
					if($respiratory == '1')
					{
					$respiratory = 'YES';
					}
					else
					{
					$respiratory = '';
					}
					$renal = $res45['renal'];
					if($renal == '1')
					{
					$renal = 'YES';
					}
					else
					{
					$renal = '';
					}
					$none = $res45['none'];
					if($none == '1')
					{
					$none = 'YES';
					}
					else
					{
					$none = '';
					}
					$other = $res45['other'];
					$triagedate = $res45['registrationdate'];
					$triageuser = $res45['user'];
					$smoking = $res45['smoking'];
					if($smoking == '1')
					{
					$smoking = 'YES';
					}
					else
					{
					$smoking = '';
					}
					$alcohol = $res45['alcohol'];
					if($alcohol == '1')
					{
					$alcohol = 'YES';
					}
					else
					{
					$alcohol = '';
					}
					$drugs = $res45['drugs'];
					if($drugs == '1')
					{
					$drugs = 'YES';
					}
					else
					{
					$drugs = '';
					}
					$gravida = $res45['gravida'];
					$para = $res45['para'];
					$abortion = $res45['abortion'];
					$familyhistory = $res45['familyhistory'];
					$surgicalhistory = $res45['surgicalhistory'];
					$transfusionhistory = $res45['transfusionhistory'];
					$height = $res45['height'];
					$weight = $res45['weight'];
					$bmi = $res45['bmi'];
					$bpsystolic = $res45['bpsystolic'];
					$bpdiastolic = $res45['bpdiastolic'];
					$respiration = $res45['respiration'];
					$pulse = $res45['pulse'];
					$tempc = $res45['celsius'];
					$spo2 = $res45['spo2'];
					$foodallergy = $res45['foodallergy'];
					$drugallergy = $res45['drugallergy'];
					$lmp = $res45['lmp'];
					$edt = $res45['edt'];
					$bloodgroup = $res45['bloodgroup'];
					$hblevel = $res45['hblevel'];
					$vdrl = $res45['vdrl'];
					$pmtct = $res45['pmtct'];
					$urinalysis = $res45['urinalysis'];
					$gestationage = $res45['gestationage'];
					$noofvisit = $res45['noofvisit'];
					$urinedipstict = $res45['urinedipstict'];
					$intdrugs = $res45['intdrugs'];
					$dose = $res45['dose'];
					$route = $res45['route'];
					$notes = $res45['notes'];
					?>
              <tr bgcolor="#011E6A">
                <td height="21" colspan="2" bgcolor="#ecf0f5" class="style2">Vitals</td>
                <td height="21" bgcolor="#ecf0f5" class="style2">&nbsp;</td>
                <td height="21" bgcolor="#ecf0f5" class="style2">&nbsp;</td>
                <td height="21" bgcolor="#ecf0f5" class="style2">&nbsp;</td>
                <td height="21" bgcolor="#ecf0f5" class="style2"><input type="text" name="bmicategory" id="bmicategory" class="bal" readonly="readonly" size="21" value=""></td>
                <td height="21" bgcolor="#ecf0f5" class="style2">&nbsp;</td>
                <td height="21" colspan="16" bgcolor="#ecf0f5" class="style2">Medical History</td>
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
                <td height="35" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Height(cms)</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><span class="style2">
                  <input name="height" type="text" id="height"   size="10" onKeyUp="return FunctionBMI()" onKeyPress="return isNumber(event)" style="border: 1px solid #001E6A;" value="<?php echo $height; ?>" tabindex="1">
                  <input type="hidden" name="billtype" value="<?php echo $billtype; ?>">
                  <input type="hidden" name="patientfirstname" id="patientfirstname"  value="<?php echo $patientfirstname; ?>" readonly="readonly"  style="border: 1px solid #001E6A;"  size="20">
                  <input type="hidden" name="patientmiddlename" id="patientmiddlename" value="<?php echo $patientmiddlename; ?>" readonly="readonly" style="border: 1px solid #001E6A;"  size="20" />
                  <input type = "hidden" name="patientlastname" id="patientlastname" value="<?php echo $patientlastname; ?>" readonly="readonly" style="border: 1px solid #001E6A;"  size="20" />
                </span></td>
                <td width="5%" align="left" valign="middle"  bgcolor="#ecf0f5" class="style2"><span class="bodytext32">Weight(kgs)
                  
                </span></td>
                <td width="5%" align="left" valign="middle"  bgcolor="#ecf0f5" class="style2"><span class="bodytext32">
                  <input name="weight" type="text" id="weight"  size="10"  onKeyUp="return FunctionBMI()" style="border: 1px solid #001E6A;" value="<?php echo $weight; ?>"  tabindex="2">
                </span></td>
                <td width="4%" align="left" valign="middle"  bgcolor="#ecf0f5" class="style2"><span class="bodytext32">BMI</span></td>
                <td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5" class="style2"><span class="bodytext32">
				<input name="bmi" type="text" id="bmi"  value="<?php echo $bmi; ?>" size="10"style="border: 1px solid #001E6A;" readonly="readonly">
                 
                </span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style2">&nbsp;</td>
                <td width="6%" align="left" valign="middle"  bgcolor="#ecf0f5" class="style2"><span class="bodytext32">DM
                    <input type = "hidden" name="paymenttype" id="paymenttype" value="<?php echo $res121paymenttype; ?>" readonly="readonly" style="border: 1px solid #001E6A;"  size="20" />
                </span></td>
                <td width="2%" align="left" valign="middle"  bgcolor="#ecf0f5" class="style2"><input type="checkbox" name="dm" id="dm" <?php if($dm == 'YES'){ ?> checked="checked"<?php } ?>value="Checked"></td>
                <td width="2%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Cardiac</td>
                <td width="1%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><input type="checkbox" name="cardiac" id="cardiac" <?php if($cardiac == 'YES'){ ?> checked="checked"<?php } ?>value="Checked"></td>
                <td height="35" colspan="12" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">
                    <input type = "hidden" name="subtype" id="subtype" value="<?php echo $res131subtype; ?>" readonly="readonly" style="border: 1px solid #001E6A;"  size="20" />
					<?php if($num45 > 0){
					?>
					DM (<label <?php if($dm =='YES'){?> style="color:red;" <?php } ?>><?php echo $dm; ?></label>), Cardiac (<label <?php if($cardiac =='YES'){?> style="color:red;" <?php } ?>><?php echo $cardiac; ?></label>), Hypertension (<label <?php if($hypertension =='YES'){?> style="color:red;" <?php } ?>><?php echo $hypertension; ?></label>)
					 
, Epilepsy (<label <?php if($epilepsy =='YES'){?> style="color:red;" <?php } ?>><?php echo $epilepsy; ?></label>), Renal (<label <?php if($renal =='YES'){?> style="color:red;" <?php } ?>><?php echo $renal; ?></label>) <?php } ?></td>
                </tr>
              <tr>
                <td width="5%" height="32" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><label onClick="return funcsystolic()">Systolic</label></td>
                <td width="17%" height="32" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">
				<input type="hidden" name="sysclr" id="sysclr">
				<input type="hidden" name="diaclr" id="diaclr">
				<input type="hidden" name="tempclr" id="tempclr"> 
                  <input name="patientcode" id="patientcode" type = "hidden" value="<?php echo $patientcode; ?>"  readonly="readonly" style="border: 1px solid #001E6A"  size="20" /><input name="bpsystolic" type="text" id="bpsystolic"  onBlur="return MinimumBP()" onKeyPress="return isNumber(event)" style="border: 1px solid #001E6A;" size="10"  tabindex="3" value="<?php echo $bpsystolic; ?>"></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><label onClick="return funcdiastolic()">Diastolic</label></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><input name="bpdiastolic" type="text" id="bpdiastolic" onBlur="return MaximumBP()" onKeyPress="return isNumber(event)" style="border: 1px solid #001E6A;" size="10"  tabindex="4" value="<?php echo $bpdiastolic; ?>"></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Resp</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><input name="respiration" type="text" id="respiration" onKeyPress="return isNumber(event)" style="border: 1px solid #001E6A;" size="10"  tabindex="5" value="<?php echo $respiration; ?>"></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Hypertension
                  <input type="hidden" name="registrationdate" id="registrationdate" value="<?php echo $registrationdate; ?>" style="border: 1px solid #001E6A" >
                  <input type="hidden" name="consultationfees" value="<?php echo $consultationfees ?>"></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><input type="checkbox" name="hypertension" id="hypertension" <?php if($hypertension == 'YES'){ ?> checked="checked"<?php } ?>value="Checked"></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Epilepsy</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><input type="checkbox" name="epilepsy" id="epilepsy" <?php if($epilepsy == 'YES'){ ?> checked="checked"<?php } ?>value="Checked"></td>
                <td height="32" colspan="12" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><label></label>                  <label>
                  <input type="hidden" name="department" value="<?php echo $departmentanum;?>" style="border: 1px solid #001E6A;">
                </label>
				<?php if($num45 > 0){
					?>
                  Respiratory (<label <?php if($respiratory =='YES'){?> style="color:red;" <?php } ?>><?php echo $respiratory; ?></label>), None (<label <?php if($none =='YES'){?> style="color:red;" <?php } ?>><?php echo $none; ?></label>), Other (<label <?php if($other =='YES'){?> style="color:red;" <?php } ?>><?php echo $other; ?></label>) - <?php echo $triagedate; ?>  by <?php echo $triageuser; ?>
				  <?php } ?></td>
                </tr>
              <tr>
                <td width="5%" height="34" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Pulse</td>
                <td width="17%" height="34" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">
                  <input type= "hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" readonly="readonly" style="border: 1px solid #001E6A;"  size="20" />
				   <input name="pulse" type="text" id="pulse" onKeyPress="return isNumber(event)" style="border: 1px solid #001E6A;" size="10"  tabindex="6" value="<?php echo $pulse; ?>"></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><strong>
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
                    <label onClick="return functempc()">Temp-C</label></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><input name="celsius" type="text" id="celsius" onKeyUp="return FunctionTemperature()" onBlur="return Tempcheck()" style="border: 1px solid #001E6A;" size="10"  tabindex="7" value="<?php echo $tempc; ?>"></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">SPO2</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><input type="text" name="spo2" id="spo2" size="10"  tabindex="8" value="<?php echo $spo2; ?>">
				<input type="hidden" name="fahrenheit" id="fahrenheit"  style="border: 1px solid #001E6A;" size="10"></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Respiratory
                  <input name="consultationtime" id="consultationtime" type = "hidden" value="<?php echo $consultationtime; ?>" readonly="readonly" style="border: 1px solid #001E6A"  size="20" /></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><input type="checkbox" name="respiratory" id="respiratory" <?php if($respiratory == 'YES'){ ?> checked="checked"<?php } ?>value="Checked"></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Renal</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><input type="checkbox" name="renal" id="renal" <?php if($renal == 'YES'){ ?> checked="checked"<?php } ?>value="Checked"></td>
                <td height="34" colspan="12" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><label></label>                
                  <!--<input type="hidden" name="department" id="department" value="<?php echo $department; ?>" style="border: 1px solid #001E6A;"  size="20" />-->
                    <label>
                    <input name="consultingdoctor" type="hidden" id="consultingdoctor" value="<?php echo $consultingdoctoranum;?>" style="border: 1px solid #001E6A;">
                      </label></td>
                </tr>
              <tr>
                <td height="32" colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Intrv.Drugs
                  <label>
                 <select name="intdrugs" id="intdrugs">
				 <?php if($intdrugs == '')
				 {
				 ?>
				 <option value="">Select</option>
				 <?php 
				 }
				 else
				 {
				 ?>
				  <option value="<?php echo $intdrugs; ?>"><?php echo $intdrugs; ?></option>
				  <?php
				  }
				  ?>
				 <option value="Paracetamol">Paracetamol</option>
				 <option value="Diclofenac">Diclofenac</option>
				 <option value="Tramadol">Tramadol</option>
				 <option value="Frusemide">Frusemide</option>
				 <option value="Hydrocortisone">Hydrocortisone</option>
				 </select>
                  <input type = "hidden" name="location" id="location" value="<?php //echo $patientcode; ?>"  readonly="readonly" style="border: 1px solid #001E6A"  size="20" />
                  </label>                    </td>
                <td height="32" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Dose</td>
                <td height="32" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><input name="drugdose" type="text" id="drugdose" onKeyPress="return isNumber(event)" style="border: 1px solid #001E6A;" size="10" value="<?php echo $dose; ?>"></td>
                <td height="32" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Route</td>
                <td height="32" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">
				<select name="route" id="route">
				<?php
				if($route == '')
				{
				?>
					   <option value="">Select Route</option>
					   <?php
					   }
					   else
					   {
					   ?>
					   <option value="<?php echo $route; ?>"><?php echo $route; ?></option>
					   <?php
					   }
					   ?>
					   <option value="Oral">Oral</option>
					   <option value="Sublingual">Sublingual</option>
					   <option value="Rectal">Rectal</option>
					   <option value="Vaginal">Vaginal</option>
					   <option value="Topical">Topical</option>
					   <option value="Intravenous">Intravenous</option>
					   <option value="Intramuscular">Intramuscular</option>
					   <option value="Subcutaneous">Subcutaneous</option>
					   </select></td>
                <td height="32" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="32" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">None
                  <input type="hidden" name="visittype" id="visittype" value="<?php echo $billtype; ?>"  readonly="readonly" style="border: 1px solid #001E6A"  size="20" /></td>
                <td height="32" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><input type="checkbox" name="none" id="none" <?php if($none == 'YES'){ ?> checked="checked"<?php } ?>value="Checked"></td>
                <td height="32" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Other</td>
                <td height="32" colspan="13" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">
				<textarea name="other" id="other"> <?php echo $other; ?> </textarea>
                  <label></label>                  <label>
                  <input type="hidden" name="accountname" id="accountname" value="<?php echo $planname; ?>" style="border: 1px solid #001E6A;">
                                                      </label>                </td>
                </tr>
              <tr>
                <td height="21" colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="style2">Other Details </td>
                <td height="21" align="left" valign="middle"  bgcolor="#ecf0f5" class="style2">&nbsp;</td>
                <td height="21" align="left" valign="middle"  bgcolor="#ecf0f5" class="style2">&nbsp;</td>
                <td height="21" align="left" valign="middle"  bgcolor="#ecf0f5" class="style2">&nbsp;</td>
                <td height="21" align="left" valign="middle"  bgcolor="#ecf0f5" class="style2">&nbsp;</td>
                <td height="21" align="left" valign="middle"  class="style2">&nbsp;</td>
                <td height="21" colspan="16" align="left" valign="middle"  bgcolor="#ecf0f5" class="style2">Obstetrical  History</td>
                </tr>
              <tr>
                <td height="27" colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Food Allergy</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Drug Allery</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Gravida</td>
                <td height="27" colspan="3" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><input type="text" name="gravida" id="gravida" value="<?php echo $gravida; ?>"></td>
                <td height="27" colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><label>LMP</label></td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><input type="text" name="lmp" id="lmp" size="10" value="<?php echo $lmp; ?>"></td>
              </tr>
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><input name="food" id="food" type="text" class="bodytext32" size="40"  autocomplete="off" style="border: 1px solid #001E6A;" >
                    <input name="autonumber" id="autonumber" type="hidden" /></td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><input name="drug" type="text" class="bodytext32" id="drug" autocomplete="off" style="border: 1px solid #001E6A;" size="40">
                  <input name = "drughidden1" id="drughidden1" type="hidden"></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Para</td>
                <td colspan="3" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><input type="text" name="para" id="para" value="<?php echo $para; ?>">
				<label style="padding-left:10px"></label></td>
                <td height="28" colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><label>EDD</label></td>
                <td height="28" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><input type="text" name="edt" id="edt" size="10" value="<?php echo $edt; ?>"></td>
              </tr>
              <tr>
                <td height="27" colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><textarea name="foodallergy" cols="40" rows="3" class="bodytext32" id="foodallergy" style="border:1px solid #001E6A;" ><?php echo $foodallergy; ?></textarea></td>
                <td height="27" colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><textarea name="drugallergy" cols="40" rows="3" class="bodytext32" id="drugallergy" style="border: 1px solid #001E6A;"><?php echo $drugallergy; ?></textarea>
                  <input type="hidden" name="genericname" class="bodytext32" id="genericname" value=""></td>
                <td height="27" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext32">Abortion</td>
                <td height="27" colspan="3" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext32"><input type="text" name="abortion" id="abortion" value="<?php echo $abortion; ?>"></td>
                <td height="27" colspan="12" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext32"><span class="bodytext32"></span><span class="bodytext32"> </span>                  
                  <label></label>                  <label><span class="bodytext32"> </span></label></td>
                </tr>
              <tr>
                <td height="27" colspan="2"  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Chief Complaints</td>
                <td height="27"  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Notes</td>
                <td height="27"  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27"  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27"  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27"  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" colspan="3"  align="left" valign="middle"   bgcolor="#ecf0f5" class="bodytext32"><strong>Family History</strong></td>
                <td height="27"  align="left" valign="middle"   bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" colspan="12"  align="left" valign="middle"   bgcolor="#ecf0f5" class="bodytext32"><strong>Surgical History</strong></td>
                </tr>
              <tr>
                <td height="27" colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><textarea name="complanits" cols="40" class="bodytext32" id="complanits" style="border: 1px solid #001E6A"></textarea></td>
                <td height="27" colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><textarea name="notes" cols="40" class="bodytext32" id="notes" style="border: 1px solid #001E6A"><?php echo $notes; ?></textarea></td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" colspan="16" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext32"><textarea name="familyhistory" cols="40" class="bodytext32" id="familyhistory" style="border: 1px solid #001E6A"><?php echo $familyhistory; ?></textarea>			
				
				&nbsp;&nbsp;&nbsp;<textarea name="surgicalhistory" cols="40" class="bodytext32" id="surgicalhistory" style="border: 1px solid #001E6A"><?php echo $surgicalhistory; ?></textarea>					 </td>
                </tr>
				<tr>
                <td height="27" colspan="2"  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27"  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27"  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27"  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27"  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27"  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" colspan="3"  align="left" valign="middle"   bgcolor="#ecf0f5" class="bodytext32"><strong>Transfusion History</strong></td>
                <td height="27"  align="left" valign="middle"   bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" colspan="12"  align="left" valign="middle"   bgcolor="#ecf0f5" class="bodytext32"><strong>&nbsp;</strong></td>
                </tr>
				<tr>
                
				<td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><strong>Doctor</strong></td>
                <td height="27" colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><input type="text" name="doctor" id="doctor" autocomplete="off" size="40">
				<input type="hidden" name="doctorhidden" id="doctorhidden">
				<input type="hidden" name="doctorusername" id="doctorusername"></td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" colspan="16" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext32"><textarea name="transfusionhistory" cols="40" class="bodytext32" id="transfusionhistory" style="border: 1px solid #001E6A"><?php echo $transfusionhistory; ?></textarea>				 </td>
                </tr>
			  <tr>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><label>Day Care</label></td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><input name="daycare" id="daycare" type="checkbox" value="Checked" ></td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                </tr>
              <tr>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><label></label>                  <label></label>                  <label>Urgent</label></td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><input name="urgentstatus" id="urgentstatus" type="checkbox" value="Checked" ></td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" colspan="16" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><strong>Intoxications</strong></td>
                </tr>			 
              <tr>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" ><span class="bodytext32">Nurse :</span></td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><?php echo $_SESSION['username']; ?></td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input name="Submit2222" type="submit"  value="Save Triage (Alt+S)" accesskey="s" class="button" id="submit" style="border: 1px solid #001E6A"/>
                  <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input type="hidden" name="frmflag1" value="frmflag1" />
                  <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
                  </font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></span></td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Smoking</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><input type="checkbox" name="smoking" id="smoking" <?php if($smoking == 'YES'){ ?> checked="checked"<?php } ?>value="Checked"></td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td height="27" colspan="12" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">
				<?php if($num45 > 0){?>
				Smoking (<label <?php if($smoking =='YES'){?> style="color:red;" <?php } ?>><?php echo $smoking; ?></label>), Alcohol (<label <?php if($alcohol =='YES'){?> style="color:red;" <?php } ?>><?php echo $alcohol; ?></label>), Drugs (<label <?php if($drugs =='YES'){?> style="color:red;" <?php } ?>><?php echo $drugs; ?></label>) - <?php echo $triagedate; ?> by <?php echo $triageuser; ?>
				<?php } ?>				</td>
                </tr>
			  <tr>
                <td height="27" colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><label></label></td>
                <td colspan="3" height="27" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Alcohol</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><input type="checkbox" name="alcohol" id="alcohol" <?php if($alcohol == 'YES'){ ?> checked="checked"<?php } ?>value="Checked"></td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td height="27" colspan="12" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                </tr>
			  <tr>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5"><label> </label></td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Drugs</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><input type="checkbox" name="drugs" id="drugs" <?php if($drugs == 'YES'){ ?> checked="checked"<?php } ?>value="Checked"></td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td height="27" colspan="12" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                </tr>
				<?php if(($departmentname == 'MCH  CONSULTATION') || ($departmentanum == 'MCH  CONSULTATION')){?>
				<tr>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" colspan="16" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><strong>ANC Profile</strong></td>
                </tr>
				<tr>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" colspan="16" align="left" valign="middle"  class="bodytext32">Blood Group&nbsp;&nbsp;<input type="text" id="bloodgroup" name="bloodgroup" size="10" onKeyUp="caps();" value="<?php echo $bloodgroup;?>">
				&nbsp;&nbsp;&nbsp;&nbsp;
				HB Level&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="hblevel" name="hblevel" size="10" value="<?php echo $hblevel;?>">
				&nbsp;&nbsp;&nbsp;&nbsp;
				VDRL&nbsp;&nbsp;<input type="text" id="vdrl" name="vdrl" size="10" value="<?php echo $vdrl;?>"></td>
                </tr>
				<tr>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" colspan="16" align="left" valign="middle"  class="bodytext32">PMTCT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="pmtct" name="pmtct" size="10" value="<?php echo $pmtct;?>">
				&nbsp;&nbsp;&nbsp;&nbsp;
				Urinalysis&nbsp;&nbsp;<input type="text" id="urinalysis" name="urinalysis" size="10" value="<?php echo $urinalysis;?>">				</td>
                </tr>
				<tr>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" colspan="16" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><strong>Subsequent Visit</strong></td>
                </tr>
				<tr>				
				<td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
				<td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" colspan="16" align="left" valign="middle"  class="bodytext32">Gestation Age&nbsp;&nbsp;<input type="text" id="gestationage" name="gestationage" size="10" value="<?php echo $gestationage;?>">
				&nbsp;&nbsp;&nbsp;&nbsp;
				No. Of Visit&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="noofvisit" name="noofvisit" size="10" value="<?php echo $noofvisit;?>">
				&nbsp;&nbsp;&nbsp;&nbsp;
				Urine Dipstick&nbsp;&nbsp;<input type="text" id="urinedipstict" name="urinedipstict" size="10" value="<?php echo $urinedipstict;?>"></td>
                </tr>
				<tr>				
				<td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
				<td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="27" colspan="16" align="left" valign="middle"  class="bodytext32">Close Triage &nbsp;<input name="closesvisits" id="closesvisits" type="checkbox" value="Checked" onChange="closealert();" ></td>
                </tr>
				<?php } 
				  $query11="select * from resultentry_lab where patientcode like '%$patientcode%' and patientvisitcode like '%$visitcode%' and resultstatus='completed' and publishstatus = 'completed' group by itemcode ";
				  $exec11=mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				  $num11=mysqli_num_rows($exec11);	   
	    		  while($res11=mysqli_fetch_array($exec11))
				  {
					$itemname='';
					$item=$res11['itemname'];
					$docnumber = $res11['docnumber'];
					$itemname=$item;   
					$itemcode = $res11['itemcode'];
				?>
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><div align="center"></div></td>
                <td height="28" colspan="21" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><a href="labresultsview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docnumber=<?php echo $docnumber; ?>" target="_blank"><?php echo $itemname; ?></a>              </tr>
			  <?php }?>
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><div align="center"></div></td>
                <td height="32" colspan="21" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td height="34" colspan="21" align="left" valign="middle"  bgcolor="#ecf0f5"><div align="right"></div></td>
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