<?php 
session_start();
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");

error_reporting(0);
$errmsg = "";
$bgcolorcode = "";
$pagename = "";
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	$patientcode=$_REQUEST["patientcode"];
	$consultationid=$_REQUEST["consultationid"];
	$visitcode = $_REQUEST["visitcodenum"];
	$queryy=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_visitentry where visitcode='$visitcode'");
	$res6=mysqli_fetch_array($queryy);
	$patientvisit=$res6['auto_number'];
	$autonumber = $_REQUEST["auto_number"];
	$patientfirstname = $_REQUEST["patientfirstname"];
	$patientfirstname = strtoupper($patientfirstname);
	$patientmiddlename = $_REQUEST['patientmiddlename'];
	$patientmiddlename = strtoupper($patientmiddlename);
	$patientlastname = $_REQUEST["patientlastname"];
	$patientlastname = strtoupper($patientlastname);
	$patientfullname=$patientfirstname.' '.$patientmiddlename.' '.$patientlastname;
	$patientauto_number=$_REQUEST['patientauto_number'];
	$consultingdoctor = $_REQUEST["consultingdoctor"];
	$consultationtype = $_REQUEST["consultationtype"];
	$department = $_REQUEST["department"];
	 $billtype=$_REQUEST['visittype'];
	 $accountname=$_REQUEST['accountname'];

	$consultationdate = $_REQUEST["consultationdate"];
	$consultationtime  = $_REQUEST["consultationtime"];
	$consultationfees  = $_REQUEST["consultationfees"];
	$referredby = $_REQUEST["referredby"];
	$consultationremarks = $_REQUEST["consultationremarks"];
	$complaint = $_REQUEST["complanits"];
	$registrationdate = $_REQUEST["registrationdate"];
	$nursename = $_REQUEST["nursename"];
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
	$drugallergy = $_REQUEST["drugallergy"];
	$complanits = $_REQUEST["complanits"];
	$foodallergy = $_REQUEST["foodallergy"];	
	$consultation = $_REQUEST["consultation"];
	$labitems = $_REQUEST["labitems"];
	$radiologyitems = $_REQUEST["radiologyitems"];
	$serviceitems = $_REQUEST["serviceitems"];
	$refferal = $_REQUEST["refferal"];
    $consultationstatus	= $_REQUEST["consultationstatus"];
	$ipaddress = $_SERVER["REMOTE_ADDR"];
    $updatedatetime = date('Y-m-d H:i:s');
	$consultationdate= date('Y-m-d');
    $query2 = "select * from master_triage where auto_number= '$autonumber'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec2);
	$res1patientcode = $res1["patientcode"];
	$res1visitcount = $res1["visitcount"];
	$res2 = mysqli_num_rows($exec2);
	if ($res2 == 0)
	{
		$query3 = "select * from master_triage where recordstatus = ''";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rowcount3 = mysqli_num_rows($exec3);
		if ($rowcount3 != 0)
		{
			//header ("location:addtriage1.php?errorcode=errorcode1failed");
			//exit;
		
        $query1 = "insert into master_consultationlist (patientcode,patientfirstname,patientmiddlename,patientlastname,consultingdoctor,consultationtype,department,consultationdate,consultationtime,consultationfees,referredby,consultationremarks,visitcount,complaints,registrationdate,recordstatus,pulse,consultation,labitems,radiologyitems,serviceitems,refferal,consultationstatus) 
		values('$patientcode','$patientfirstname','$patientmiddlename','$patientlastname','$consultingdoctor','$consultationtype','$department','$consultationdate','$consultationtime','$consultationfees','$referredby','$consultationremarks','$visitcount','$complaints','$registrationdate','$recordstatus','$pulse','$consultation','$labitems','$radiologyitems','$serviceitems','$refferal','completed')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$rad= $_POST['radiology'];
		$rat=$_POST['rate8'];
		$items = array_combine($rad,$rat);
		$pairs = array();
		
		foreach($_POST['radiology'] as $key=>$value){	
			//echo '<br>'.
		
		$pairs= $_POST['radiology'][$key];
		$pairvar= $pairs;
	    $pairs1= $_POST['rate8'][$key];
		$pairvar1= $pairs1;
		
		$radiologyquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_radiology where itemname='$pairvar'");
		$execradiology=mysqli_fetch_array($radiologyquery);
		$radiologycode=$execradiology['itemcode'];
		
		
		if($pairvar!="")
		{
		$radiologyquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into consultation_radiology(consultationid,patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,billtype,accountname,consultationdate,paymentstatus)values('$consultationid','$patientcode','$patientfullname','$visitcode','$radiologycode','$pairvar','$pairvar1','$billtype','$accountname','$consultationdate','pending')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$radiologyquery2=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set radiologybill='pending' where visitcode='$visitcode'");
		}
		}
		
		
		for ($p=1;$p<=20;$p++)
		{	
		    //echo '<br>'.$i;
			//echo '<br>'.
			$autonumber = $_REQUEST['autonumber'.$p];	
			//echo '<br>'.
		    $medicinename = $_REQUEST['medicinename'.$p];
			$query77="select * from master_medicine where itemname='$medicinename'";
			$exec77=mysqli_query($GLOBALS["___mysqli_ston"], $query77);
			$res77=mysqli_fetch_array($exec77);
			$medicinecode=$res77['itemcode'];
			$dose = $_REQUEST['dose'.$p];
		    $frequency = $_REQUEST['frequency'.$p];
			$sele=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_frequency where frequencycode='$frequency'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$ress=mysqli_fetch_array($sele);
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
		        $query2 = "insert into master_consultationpharm(consultation_id,patientcode,patientauto_number,patientname,patientvisitauto_number,patientvisitcode,medicinename,dose,frequencyauto_number,frequencycode,frequencynumber,days,quantity,instructions,rate,amount,recordstatus,recorddate,ipaddress,consultingdoctor,billtype,accountname,paymentstatus,medicinecode) 
				values('$consultationid','$patientcode','$patientauto_number','$patientfullname','$patientvisit','$visitcode','$medicinename','$dose','$frequencyautonumber','$frequencycode','$frequencynumber','$days','$quantity','$instructions','$rate','$amount','completed','$consultationdate','$ipaddress','$consultingdoctor','$billtype','$accountname','pending','$medicinecode')";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$newquery=mysqli_query($GLOBALS["___mysqli_ston"], "update master_triage set consultation='completed' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$medicinequery2=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set pharmacybill='pending' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					
			}
			
			
			
			
			
			
		}
		$query88 = "insert into master_consultation(consultation_id,patientcode,patientauto_number,patientname,patientvisitauto_number,patientvisitcode,recordstatus,recorddate,ipaddress,consultingdoctor,billtype,accountname,paymentstatus,sys,dia,pulse,temp,complaint,drugallergy,foodallergy) 
				values('$consultationid','$patientcode','$patientauto_number','$patientfullname','$patientvisit','$visitcode','completed','$consultationdate','$ipaddress','$consultingdoctor','$billtype','$accountname','pending','$bpsystolic','$bpdiastolic','$pulse','$celsius','$complaint','$drugallergy','$foodallergy')";
				$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]));
			
		foreach($_POST['lab'] as $key => $value)
		{
				    //echo '<br>'.$k;

		$labname=$_POST['lab'][$key];
		$labquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_lab where itemname='$labname'");
		$execlab=mysqli_fetch_array($labquery);
		$labcode=$execlab['itemcode'];
		$labrate=$_POST['rate5'][$key];
		
		if($labname!="")
		{
		$labquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into consultation_lab(consultationid,patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,billtype,accountname,consultationdate,paymentstatus)values('$consultationid','$patientcode','$patientfullname','$visitcode','$labcode','$labname','$labrate','$billtype','$accountname','$consultationdate','pending')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$labquery2=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set labbill='pending' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		}
		foreach($_POST['services'] as $key => $value)
		{
				    //echo '<br>'.$k;

		$servicesname=$_POST["services"][$key];
		$servicequery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_services where itemname='$servicesname'");
		$execservice=mysqli_fetch_array($servicequery);
		$servicescode=$execservice['itemcode'];
		
		$servicesrate=$_POST["rate3"][$key];
		
		if($servicesname!="")
		{
		$servicesquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into consultation_services(consultationid,patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,billtype,accountname,consultationdate,paymentstatus)values('$consultationid','$patientcode','$patientfullname','$visitcode','$servicescode','$servicesname','$servicesrate','$billtype','$accountname','$consultationdate','pending')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$servicesquery2=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set servicebill='pending' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		}
		foreach($_POST['referal'] as $key=>$value)
		{
		$pairs2= $_POST['referal'][$key];
		$pairvar2= $pairs2;
	    $pairs3= $_POST['rate4'][$key];
		$pairvar3= $pairs3;
		
		$referalquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_doctor where doctorname='$pairvar2'");
		$execreferal=mysqli_fetch_array($referalquery);
		$referalcode=$execreferal['doctorcode'];
		
		
		if($pairvar2!="")
		{
		$referalquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into consultation_referal(consultationid,patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,billtype,accountname,consultationdate,paymentstatus)values('$consultationid','$patientcode','$patientfullname','$visitcode','$referalcode','$pairvar2','$pairvar3','$billtype','$accountname','$consultationdate','pending')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$referalquery2=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set referalbill='pending' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		}

		$newquery1=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set doctorconsultation='completed' where visitcode='$visitcode'");
		
		
			
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
		$complaints = '';
		$registrationdate = '';
		$recordstatus = '';
		$nursename = '';
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
		$bpdiastolic = '';
		$drugallergy = '';
		$foodallergy = '';
		$consultation = '';
		$labitems = '';
		$radiologyitems = '';
		$serviceitems = '';
		$refferal = '';	
		$sno = '';
     	$code = '';
	    $name = '';
	    $dose = '';
	    $frequency = '';
	    $days = '';
	    $quantity = '';
	    $instructions = '';
	    $rate = '';
	    $amount = '';
		$consultationstatus = '';
		
		header ("location:consultationlist1.php?patientcode=$patientcode&&st=success");
		exit;
		}
	}
	else
	{
		header ("location:addtriage1.php?patientcode=$patientcode&&st=failed");
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
	$complaints = '';
	$registrationdate = '';
    $recordstatus = '';
	$nursename = '';
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
	$bpdiastolic = '';
	$drugallergy = '';
	$foodallergy = '';
	$consultation = '';
	$labitems = '';
	$radiologyitems = '';
	$serviceitems = '';
	$refferal = '';	
	$sno = '';
	$code = '';
	$name = '';
	$dose = '';
	$frequency = '';
	$days = '';
	$quantity = '';
	$instructions = '';
	$rate = '';
	$amount = '';
	$consultationstatus = '';
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
    $query2 = "select * from master_triage where patientcode = '$patientcode'";//order by auto_number desc limit 0, 1";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$patientcode = $res2['patientcode'];
		$res2patientaccountname = $res2['accountname'];
		 
		$patientfirstname = $res2['patientfirstname'];
		 $patientfirstname = strtoupper($patientfirstname);
	    $patientmiddlename = $res2['patientmiddlename'];
		$patientmiddlename = strtoupper($patientmiddlename);
		$patientlastname = $res2['patientlastname'];
		 $patientlastname = strtoupper($patientlastname);
		 $patientfullname=$patientfirstname.' '.$patientmiddlename.' '.$patientlastname;
		$registrationdate = $res2["registrationdate"];
		$consultingdoctor = $res2['consultingdoctor'];
		$department = $res2['department'];
		$consultationtype = $res2["consultationtype"];
		$consultationdate = $res2["consultationdate"];
		$consultationtime  = $res2["consultationtime"];
		$consultationfees  = $res2["consultationfees"];
		$billamount = $consultationfees;
		$referredby = $res2["referredby"];
		$paymenttype = $res2["paymenttype"];
		$consultationremarks = $res2["consultationremarks"];
		$complaint = $res2["complaint"];
		$visitcount = $res2['visitcount'];
		$visitcodenum=$res2['visitcode'];
	    $nursename = $res2["nursename"];
	    $pulse = $res2["pulse"];
		$height = $res2["height"];
		$weight = $res2["weight"];
		$bmi = $res2["bmi"];
		$respiration = $res2["respiration"];
		$headcircumference =$res2["headcircumference"];
		$bsa = $res2["bsa"];
		$fahrenheit = $res2["fahrenheit"];
		$celsius = $res2["celsius"];
		$bpsystolic = $res2["bpsystolic"];
		$bpdiastolic = $res2["bpdiastolic"];
		$drugallergy = $res2["drugallergy"];
		$foodallergy = $res2["foodallergy"];
		$complanits = $res2["complanits"];
		$consultation = $res2["consultation"];
	    $labitems = $res2["labitems"];
	    $radiologyitems = $res2["radiologyitems"];
	    $serviceitems = $res2["serviceitems"];
	    $refferal = $res2["refferal"];	
	     $res2billtype = $res2['billtype'];
		$quer=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
		$result=mysqli_fetch_array($quer);
		$patientauto_number=$result['auto_number'];
	

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

include ("autocompletebuild_lab1.php");
include ("autocompletebuild_radiology1.php");
include ("autocompletebuild_services1.php");
include ("autocompletebuild_referal.php");
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
<script type="text/javascript" src="js/insertnewitem1.js"></script>
<script type="text/javascript" src="js/insertnewitem2.js"></script>
<script type="text/javascript" src="js/insertnewitem3.js"></script>
<script type="text/javascript" src="js/insertnewitem4.js"></script>
<script type="text/javascript" src="js/insertnewitem5.js"></script>
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
function btnDeleteClick1(delID1,vrate1)
{
	//alert ("Inside btnDeleteClick.");
	var newtotal3;
	//alert(vrate1);
	var varDeleteID1 = delID1;
	//alert(varDeleteID1);
	var fRet4; 
	fRet4 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet4); 
	if (fRet4 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child1 = document.getElementById('idTR'+varDeleteID1);  //tr name
    var parent1 = document.getElementById('insertrow1'); // tbody name.
	document.getElementById ('insertrow1').removeChild(child1);
	
	var child1= document.getElementById('idTRaddtxt'+varDeleteID1);  //tr name
    var parent1= document.getElementById('insertrow1'); // tbody name.
	//alert (child);
	if (child1 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow1').removeChild(child1);
	}
	
	var currenttotal3=document.getElementById('total1').value;
	//alert(currenttotal);
	newtotal3= currenttotal3-vrate1;
	
	//alert(newtotal3);
	
	document.getElementById('total1').value=newtotal3;
	if(document.getElementById('total').value=='')
	{
	 totalamount11=0;
	//alert(totalamount11);
	}
	else
	{
	totalamount11=document.getElementById('total').value;
	}
	if(document.getElementById('total2').value=='')
	{
	 totalamount21=0;
	//alert(totalamount21);
	}
	else
	{
	totalamount2=document.getElementById('total2').value;
	}
	if(document.getElementById('total3').value=='')
	{
	 totalamount31=0;
	//alert(totalamount31);
	}
	else
	{
	 totalamount31=document.getElementById('total3').value;
	}
	if(document.getElementById('total5').value=='')
	{
	 totalamount41=0;
	//alert(totalamount41);
	}
	else
	{
	 totalamount41=document.getElementById('total5').value;
	}
	
	 newgrandtotal3=parseInt(totalamount11)+parseInt(newtotal3)+parseInt(totalamount21)+parseInt(totalamount31)+parseInt(totalamount41);
	
	//alert(newgrandtotal3);
	
	document.getElementById('total4').value=newgrandtotal3.toFixed(2);
	
	

}
function btnDeleteClick5(delID5,radrate)
{
	//alert ("Inside btnDeleteClick.");
	var newtotal2;
	//alert(radrate);
	var varDeleteID2= delID5;
	//alert (varDeleteID2);
	var fRet5; 
	fRet5 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet5 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child2= document.getElementById('idTR'+varDeleteID2);  //tr name
    var parent2 = document.getElementById('insertrow2'); // tbody name.
	document.getElementById ('insertrow2').removeChild(child2);
	
	var child2 = document.getElementById('idTRaddtxt'+varDeleteID2);  //tr name
    var parent2 = document.getElementById('insertrow2'); // tbody name.
	//alert (child);
	if (child2 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow2').removeChild(child2);
	}
	
	var currenttotal2=document.getElementById('total2').value;
	//alert(currenttotal);
	newtotal2= currenttotal2-radrate;
	
	//alert(newtotal);
	
	document.getElementById('total2').value=newtotal2;
	if(document.getElementById('total').value=='')
	{
	totalamount11=0;
	}
	else
	{
	totalamount11=document.getElementById('total').value;
	}
	if(document.getElementById('total1').value=='')
	{
	totalamount21=0;
	}
	else
	{
	totalamount21=document.getElementById('total1').value;
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
	
	
    var newgrandtotal2=parseInt(totalamount11)+parseInt(totalamount21)+parseInt(newtotal2)+parseInt(totalamount31)+parseInt(totalamount41);
	
	//alert(newgrandtotal4);
	
	document.getElementById('total4').value=newgrandtotal2.toFixed(2);
	
	
	

	
}
function btnDeleteClick3(delID3,vrate3)
{
	//alert ("Inside btnDeleteClick.");
	var newtotal1;
	var varDeleteID3= delID3;
	//alert (varDeleteID3);
	//alert(vrate3);
	var fRet6; 
	fRet6 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet6 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child3 = document.getElementById('idTR'+varDeleteID3);  
	//alert (child3);//tr name
    var parent3 = document.getElementById('insertrow3'); // tbody name.
	document.getElementById ('insertrow3').removeChild(child3);
	
	var child3= document.getElementById('idTRaddtxt'+varDeleteID3);  //tr name
    var parent3 = document.getElementById('insertrow3'); // tbody name.
	
	if (child3 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow3').removeChild(child3);
	}
var currenttotal1=document.getElementById('total3').value;
	//alert(currenttotal);
	newtotal1= currenttotal1-vrate3;
	
	//alert(newtotal);
	
	document.getElementById('total3').value=newtotal1;
	if(document.getElementById('total').value=='')
	{
	totalamount11=0;
	}
	else
	{
	totalamount11=document.getElementById('total').value;
	}
	if(document.getElementById('total1').value=='')
	{
	totalamount21=0;
	}
	else
	{
	totalamount21=document.getElementById('total1').value;
	}
	if(document.getElementById('total2').value=='')
	{
	totalamount31=0;
	}
	else
	{
	totalamount31=document.getElementById('total2').value;
	}
	if(document.getElementById('total5').value=='')
	{
	totalamount41=0;
	}
	else
	{
	totalamount41=document.getElementById('total5').value;
	}
	
	var newgrandtotal1=parseInt(totalamount11)+parseInt(totalamount21)+parseInt(totalamount31)+parseInt(newtotal1)+parseInt(totalamount41);
	
	//alert(newgrandtotal4);
	
	document.getElementById('total4').value=newgrandtotal1.toFixed(2);	
	
}

function btnDeleteClick4(delID4,vrate4)
{
	//alert ("Inside btnDeleteClick.");
	var newtotal;
	//alert(delID4);
	var varDeleteID4= delID4;
	//alert(vrate4);
	
	//alert(rateref);
	//alert (varDeleteID3);
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

	var currenttotal=document.getElementById('total5').value;
	//alert(currenttotal);
	newtotal= currenttotal-vrate4;
	
	//alert(newtotal);
	
	document.getElementById('total5').value=newtotal;
	if(document.getElementById('total').value=='')
	{
	totalamount11=0;
	}
	else
	{
	totalamount11=document.getElementById('total').value;
	}
	if(document.getElementById('total1').value=='')
	{
	totalamount21=0;
	}
	else
	{
	totalamount21=document.getElementById('total1').value;
	}
	if(document.getElementById('total2').value=='')
	{
	totalamount31=0;
	}
	else
	{
	totalamount31=document.getElementById('total2').value;
	}
	if(document.getElementById('total3').value=='')
	{
	totalamount41=0;
	}
	else
	{
	totalamount41=document.getElementById('total3').value;
	}
	var newgrandtotal=parseInt(totalamount11)+parseInt(totalamount21)+parseInt(totalamount31)+parseInt(totalamount41)+parseInt(newtotal);
	
	//alert(newgrandtotal4);
	
	document.getElementById('total4').value=newgrandtotal.toFixed(2);	
}

</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
#drugallergy
{

}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style2 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
</head>
<script language="javascript">

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

function process1()
{
	
	}

<?php /*?> /*  <?php $date = mktime(0,0,0,date("m"),date("d")-1,date("Y")); 
	$currentdate = date("Y/m/d",$date);
	?>*/
/*	var currentdate = "<?php echo $currentdate; ?>";<?php */?>
/*	var expirydate = document.getElementById("accountexpirydate").value; 
	var currentdate = Date.parse(currentdate);
	var expirydate = Date.parse(expirydate);
	
	if( expirydate > currentdate)
	{
		alert("Please Select Correct Account Expiry date");
		//document.getElementById("accountexpirydate").focus();
		//return false;
	}*/
	
	

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
	$res11patientfirstname = $res11patientfirstname['patientfirstname'];
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
	<?php
	$query11 = "select * from master_consultationtype where recordstatus = ''";
    $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res11 = mysqli_fetch_array($exec11))
	{
	$res11consultationanum = $res11["auto_number"];
	$res11consultationtype = $res11["consultationtype"];
	$res11consultationfees = $res11["consultationfees"];
	?>
		if(document.getElementById("consultationtype").value == "<?php echo $res11consultationanum; ?>")
		{
			document.getElementById("consultationfees").value = <?php echo $res11consultationfees; ?>;
			document.getElementById("consultationfees").focus();
		}
	<?php
	}
	?>
}


function funcOnLoadBodyFunctionCall()
{ 
	//alert ("Inside Body On Load Fucntion.");
	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	funcCustomerDropDownSearch1();
	funcCustomerDropDownSearch2();
	funcCustomerDropDownSearch3();
	funcCustomerDropDownSearch4(); 
	funcCustomerDropDownSearch7();//To handle ajax dropdown list.
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
	
if( expirydate < currentdate)
  {
	alert("Please Select Correct Account Expiry date");
	document.getElementById("expirydate").focus();
	return false;
  }
}
if (document.getElementById("consltid") != null) 
{
	document.getElementById("consltid").style.display = 'none';
}

function funcShowView()
{
  if (document.getElementById("consltid") != null) 
     {
	 document.getElementById("consltid").style.display = 'none';
	}
	if (document.getElementById("consltid") != null) 
	  {
	  document.getElementById("consltid").style.display = '';
	 }
}
function funcHideView()
{		
 if (document.getElementById("consltid") != null) 
	{
	document.getElementById("consltid").style.display = 'none';
	}	
}
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
function funcLabShowView()
{
  if (document.getElementById("labid") != null) 
     {
	 document.getElementById("labid").style.display = 'none';
	}
	if (document.getElementById("labid") != null) 
	  {
	  document.getElementById("labid").style.display = '';
	 }
}
	
function funcLabHideView()
{		
 if (document.getElementById("labid") != null) 
	{
	document.getElementById("labid").style.display = 'none';
	}			
}

function funcRadShowView()
{
  if (document.getElementById("radid") != null) 
     {
	 document.getElementById("radid").style.display = 'none';
	}
	if (document.getElementById("radid") != null) 
	  {
	  document.getElementById("radid").style.display = '';
	 }
}
	
function funcSerHideView()
{		
 if (document.getElementById("serid") != null) 
	{
	document.getElementById("serid").style.display = 'none';
	}			
}
function funcSerShowView()
{
  if (document.getElementById("serid") != null) 
     {
	 document.getElementById("serid").style.display = 'none';
	}
	if (document.getElementById("serid") != null) 
	  {
	  document.getElementById("serid").style.display = '';
	 }
}
	
function funcRadHideView()
{		
 if (document.getElementById("radid") != null) 
	{
	document.getElementById("radid").style.display = 'none';
	}			
}
function funcRefferalShowView()
{
  if (document.getElementById("reffid") != null) 
     {
	 document.getElementById("reffid").style.display = 'none';
	}
	if (document.getElementById("reffid") != null) 
	  {
	  document.getElementById("reffid").style.display = '';
	 }
}
	
function funcRefferalHideView()
{		
 if (document.getElementById("reffid") != null) 
	{
	document.getElementById("reffid").style.display = 'none';
	}			
}
</script>
<?php
	$query21 = "select * from master_consultation order by auto_number desc limit 0, 1";
	 $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	 $rowcount21 = mysqli_num_rows($exec21);
	if ($rowcount21 == 0)
	{
		$consultationcode = 'CON001';
	}
	else
	{
		$res21 = mysqli_fetch_array($exec21);
		 $consultationcode = $res21['consultation_id'];
		 $consultationcode = substr($consultationcode, 3, 7);
		$consultationcode= intval($consultationcode);
		$consultationcode = $consultationcode + 1;
	
		
		
		
		if (strlen($consultationcode) == 2)
		{
			$consultationcode= '0'.$consultationcode;
		}
		if (strlen($consultationcode) == 1)
		{
			$consultationcode= '00'.$consultationcode;
		}
		$consultationcode = 'CON'.$consultationcode;
		}
	
?>

<?php include ("js/dropdownlist1scriptingmedicine1.php"); ?>
<script type="text/javascript" src="js/autosuggestmedicine1.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_medicine1.js"></script>
<script type="text/javascript" src="js/automedicinecodesearch2.js"></script>


<?php include ("js/dropdownlist1scriptinglab1.php"); ?>
<script type="text/javascript" src="js/autocomplete_lab1.js"></script>
<script type="text/javascript" src="js/autosuggestlab1.js"></script> 
<script type="text/javascript" src="js/autolabcodesearch2.js"></script>


<?php include ("js/dropdownlist1scriptingradiology1.php"); ?>
<script type="text/javascript" src="js/autocomplete_radiology1.js"></script>
<script type="text/javascript" src="js/autosuggestradiology1.js"></script> 
<script type="text/javascript" src="js/autoradiologycodesearch2.js"></script>


<?php include ("js/dropdownlist1scriptingservices1.php"); ?>
<script type="text/javascript" src="js/autocomplete_services1.js"></script>
<script type="text/javascript" src="js/autosuggestservices1.js"></script>
<script type="text/javascript" src="js/autoservicescodesearch2.js"></script>

<?php include ("js/dropdownlist1scriptingreferal.php"); ?>
<script type="text/javascript" src="js/autocomplete_referal.js"></script>
<script type="text/javascript" src="js/autosuggestreferal1.js"></script>
<script type="text/javascript" src="js/autoreferalcodesearch2.js"></script>


<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
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
    <td width="1%" height="1426">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">


      	  <form name="form1" id="form1" method="post" action="addconsultation1.php" onKeyDown="return disableEnterKey(event)" onSubmit="return process1();">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="103%"><table width="1100" height="579" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
                <td colspan="4" bgcolor="#ecf0f5" class="style2">Consultation</td>
				 <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Quick Glance</strong></td>
                <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                </tr>
              <tr>
                <td colspan="4" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo ''; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
              <td colspan="4" align="left" valign="middle" class="bodytext3">Previous Visits</td>
			  </tr>
              <!--<tr bordercolor="#000000" >
                  <td  align="left" valign="middle"  class="bodytext3"  colspan="4"><strong>Registration</strong></font></div></td>
                </tr>-->
              <!--<tr>
                  <tr  bordercolor="#000000" >
                  <td  align="left" valign="middle"  class="bodytext3" colspan="4"><div align="right">* Indicates Mandatory</div></td>
                </tr>-->
				
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">
				  <input type="hidden" name="billtype" value="<?php echo $billtype; ?>">
				    <input name="customercode" id="customercode" value="" type="hidden">
				  </span></td>
				  <td align="left" valign="middle" bgcolor="#ecf0f5"><span class="bodytext32"> First Name </span></td>
				  <td align="left" valign="middle" bgcolor="#ecf0f5"><span class="bodytext32">Middle Name </span></td>
				  <td align="left" valign="middle" bgcolor="#ecf0f5"><span class="bodytext32">Last Name </span></td>
				  <td rowspan="3" width="400" align="left" valign="middle" bgcolor="#ecf0f5" >
				  <table width="400" height="40">
				  <tr >
				  <td width="16%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5" >
				  <span class="bodytext32">Date </span></td>
				  <td width="19%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext32">Visit.No</span></td>
				  <td width="12%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext32">SYS</span></td>
				   <td width="12%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext32">DIA</span></td>
				  <td width="12%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext32">PULSE</span></td>
				 <td width="12%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext32">TEMP</span></td>
				  </tr>
				  <?php 
				  $colorloopcount = '';
				 $queryglance="select * from master_consultation where patientcode='$patientcode' order by recorddate DESC limit 0,3";
				  $execglance=mysqli_query($GLOBALS["___mysqli_ston"], $queryglance) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				  while($resglance=mysqli_fetch_array($execglance))
				  {
				  $date=$resglance['recorddate'];
				  $vcode=$resglance['patientvisitcode'];
				  $sys=$resglance['sys'];
				   $dia=$resglance['dia'];
				   $pulse=$resglance['pulse'];
				   $temp=$resglance['temp'];
				   $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
				  ?>
				  <tr <?php echo $colorcode; ?>>
				   <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $date; ?></div> </td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $vcode; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sys; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $dia; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pulse; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $temp; ?></div></td>
				</tr>
				  <?php
				  }
				  ?>
				  
				  </table>
				  </td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5">
				  <input type="hidden" name="consultationid" value="<?php echo $consultationcode; ?>">
				  <input type="hidden" name="patientauto_number" value="<?php echo $patientauto_number; ?>">
				  <?php $code=$_REQUEST['visitcode']; ?>
				  <input type="hidden" name="visitcode" value="<?php echo $code; ?>">
				  <input name="patientfirstname" id="patientfirstname" value="<?php echo $patientfirstname; ?>" readonly size="20" /></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5">
				  <input name="patientmiddlename" id="patientmiddlename" value="<?php echo $patientmiddlename; ?>" readonly size="20" /></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5">
				  <input name="patientlastname" id="patientlastname" value="<?php echo $patientlastname; ?>" readonly size="20" /></td>
				  </tr>
				<tr>
				  <td width="4%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Reg N0 </td>
				  <td  align="left" valign="middle"  bgcolor="#ecf0f5">
				  <input name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>"  readonly="readonly"  size="20" /></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" width="50"><span class="bodytext32">Department</span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="department" name="department" value="<?php echo $department;?>" ></td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">OP Visit </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><label>
				    <input name="visitcodenum" type="text" size="20" value="<?php echo $visitcodenum; ?>">
				  </label></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Consulting Doctor </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="consultingdoctor" type="text" id="consultingdoctor" value="<?php echo $consultingdoctor;?>" size="20"></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Past Complaints</td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">OP Date </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="registrationdate" type="text" id="registrationdate" value="<?php echo $registrationdate; ?>" size="20" ></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Visit Type </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><strong>
				    <input name="visittype" id="visittype" value="<?php echo $res2billtype; ?>" size="20" >
				  </strong></td>
				  <td rowspan="3" width="400" align="left" valign="middle" bgcolor="#ecf0f5" >
				  <table width="400" height="40">
				  <tr >
				  <td width="5%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext32">Date </span></td>
				  <td width="2%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext32">Visit.No</span></td>
				  <td width="15%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext32">Complaints</span></td>
				  
				  </tr>
				  <?php 
				  $colorloopcount = '';
				 $querycom="select * from master_consultation where patientcode='$patientcode' order by recorddate DESC limit 0,3";
				  $execcom=mysqli_query($GLOBALS["___mysqli_ston"], $querycom) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				  while($rescom=mysqli_fetch_array($execcom))
				  {
				  $date=$rescom['recorddate'];
				  $vcode=$rescom['patientvisitcode'];
				  $comp=$rescom['complaint'];
				  
				  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
				  ?>
				  <tr <?php echo $colorcode; ?>>
				   <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $date; ?></div> </td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $vcode; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $comp; ?></div></td>
			   	</tr>
				  <?php
				  }
				  ?>
				  
				  </table>
				  </td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Time </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="consultationtime" id="consultationtime" value="<?php echo $consultationtime; ?>" readonly   size="20" /></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Account Name</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><strong><input name="accountname" type="text" id="accountname"  value="<?php echo $res2patientaccountname; ?>" size="20"></strong></td>
				 
				  </tr>
				<tr>
				  <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="style2"><strong><!--				   
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
				    <!--<input type="hidden" name="department" id="department" value="<?php echo $department; ?>" style="border: 1px solid #001E6A;"  size="20" />-->
				    <label>Triage Details </label></td>
					 
				  </tr>
				
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Height </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><label>
                     <input name="height" type="text" id="height" value="<?php echo $height;?>" readonly size="10">
                   </label></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Weight</span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">
				     <input name="weight" type="text" id="weight" value="<?php echo $weight?>" readonly  size="10">
				   </span></td>
				     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Drug Allergy</td>
				  
			      </tr>
				  <tr>
				    <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp; </td>
					  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp; </td>
					  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">BMI</span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">
				     <input name="bmi" type="text" id="bmi"  value="<?php echo $bmi?>" onBlur="return FunctionBMI()" readonly  size="10">
				   </span></td>
				   <td width="400" align="left" valign="middle" bgcolor="#ecf0f5" >
				  <table width="400" height="40">
				  <tr >
				  <td width="5%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext32">Date </span></td>
				  <td width="2%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext32">Visit.No</span></td>
				  <td width="15%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext32">Drug Allergy</span></td>
				  
				  </tr>
				  <?php 
				  $colorloopcount = '';
				 $queryfood="select * from master_consultation where patientcode='$patientcode' order by recorddate DESC limit 0,1";
				  $execfood=mysqli_query($GLOBALS["___mysqli_ston"], $queryfood) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				  while($resfood=mysqli_fetch_array($execfood))
				  {
				  $date=$resfood['recorddate'];
				  $vcode=$resfood['patientvisitcode'];
				  $food=$resfood['drugallergy'];
				  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
				  ?>
				  <tr <?php echo $colorcode; ?>>
				   <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $date; ?></div> </td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $vcode; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $food; ?></div></td>
			   	</tr>
				  <?php
				  }
				  ?>
				  
				  </table>
				  </td>
				  </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Systolic</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="bpsystolic" type="text" id="bpsystolic"  readonly="readonly" value="<?php echo $bpsystolic;?>" onBlur="return MinimumBP()" size="10"></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">
				 
			         <label></label>
                     <span class="bodytext32">Diastolic</span>
                    <label class="bodytext3"></label></td>
			       <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="bpdiastolic" type="text" id="bpdiastolic" readonly value="<?php echo $bpdiastolic;?>"onBlur="return MaximumBP()" size="10"></td>
			      <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Food Allergy</td>
				 </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Pulse</span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><label><span class="bodytext32">
				     <input name="pulse" type="text" id="pulse" readonly  value="<?php echo $pulse;?>" size="10">
				   </span></label></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Respiration</span></td>
			       <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="respiration" type="text" value="<?php echo $respiration;?>" readonly id="respiration" size="10"></td>
			     <td width="400" align="left" valign="middle" bgcolor="#ecf0f5" >
				  <table width="400" height="40">
				  <tr >
				  <td width="5%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext32">Date </span></td>
				  <td width="2%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext32">Visit.No</span></td>
				  <td width="15%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext32">Food Allergy</span></td>
				  
				  </tr>
				  <?php 
				  $colorloopcount = '';
				 $queryfood="select * from master_consultation where patientcode='$patientcode' order by recorddate DESC limit 0,1";
				  $execfood=mysqli_query($GLOBALS["___mysqli_ston"], $queryfood) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				  while($resfood=mysqli_fetch_array($execfood))
				  {
				  $date=$resfood['recorddate'];
				  $vcode=$resfood['patientvisitcode'];
				  $food=$resfood['foodallergy'];
				  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
				  ?>
				  <tr <?php echo $colorcode; ?>>
				   <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $date; ?></div> </td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $vcode; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $food; ?></div></td>
			   	</tr>
				  <?php
				  }
				  ?>
				  
				  </table>
				  </td>
				 </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><label class="bodytext32">Temp-C</label></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="celsius" type="text" id="celsius" readonly value="<?php echo $celsius;?>" size="10"></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><label class="bodytext32">Temp-F</label></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="fahrenheit" id="fahrenheit" value="<?php echo $fahrenheit;?>" readonly  onBlur="return FunctionTemperature()" size="10"></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Previous Medication</td>
			      </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">BSA</span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="bsa" type="text" id="bsa" readonly value="<?php echo $bsa;?>" size="10"></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Head Circumfirance </span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="headcircumference" type="text" readonly  value="<?php echo $headcircumference;?>" id="headcircumference" size="10"></td>
				  <td width="400" align="left" valign="middle" bgcolor="#ecf0f5" >
				  <table width="400" height="40">
				  <tr >
				  <td width="5%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext32">Date </span></td>
				  <td width="2%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext32">Visit.No</span></td>
				  <td width="15%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext32">Previous Medication</span></td>
				  
				  </tr>
				  <?php 
				  $medname='';
				  $colorloopcount = '';
				 $querymed="select * from master_consultationpharm where patientcode='$patientcode' order by recorddate DESC limit 0,1";
				  $execmed=mysqli_query($GLOBALS["___mysqli_ston"], $querymed) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				  while($resmed=mysqli_fetch_array($execmed))
				  {
				  $date=$resmed['recorddate'];
				  $vcode=$resmed['patientvisitcode'];
				  $querymed1="select * from master_consultationpharm where patientcode='$patientcode' and recorddate='$date'";
				  $execmed1=mysqli_query($GLOBALS["___mysqli_ston"], $querymed1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				  
				  while($resmed1=mysqli_fetch_array($execmed1))
				 {
				 $med=$resmed1['medicinename'];
				 $medname=$medname.','.$med;
				
				 }
				  ?>
				  <tr <?php echo $colorcode; ?>>
				   <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $date; ?></div> </td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $vcode; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $medname; ?></div></td>
			   	</tr>
				  <?php
				  }
				  ?>
				  
				  </table>
				  </td>
				   </tr>
				<tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                
                </tr>
				<tr>
				 <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				
                       <td width="30" class="bodytext3" align="center">Food Allergy</td>
					    
                       <td width="15" class="bodytext3" align="center">Drug Allergy</td>
                       <td width="15" class="bodytext3" align="center">Complaints</td>
                  </tr>
           
              <tr>
               
				 <td height="55" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				 
                <td height="55" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><label>
                  <textarea name="foodallergy" id="foodallergy" cols="30" rows="5" class="bodytext32"  ><?php echo $foodallergy;  ?></textarea>
                </label></td> 
				
                <td height="55" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><label>
                  <textarea name="drugallergy" cols="30" rows="5" class="bodytext32" id="drugallergy" s><?php echo  $drugallergy; ?></textarea>
                </label></td> 
               
                <td height="55" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><label>
                  <textarea name="complanits" id="complanits" cols="30" rows="5" class="bodytext32"  ><?php echo $complanits; ?> </textarea>
                </label></td>
                </tr>
				 
				
				
				 <tr>
				   <td colspan="9" align="left" valign="middle"  bgcolor="#ecf0f5" class="style2">
				   Consultation 
				   <span class="bodytext32">
				   <img src="images/plus1.gif" width="13" height="13" onClick="return funcHideView()"  onDblClick="return funcShowView()">
				   </span>
				   </td>
			      </tr>
				 <tr id="consltid">
				   <td colspan="9" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><textarea name="consultation"  id="consultation" cols="75"></textarea></td>
			      </tr>
				 <tr>
				   <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				   <td colspan="3" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			      </tr>
				 <tr>
				   <td colspan="9" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Prescription <span class="bodytext32"> <img src="images/plus1.gif" width="13" height="13"  onClick="return funcpresHideView()"  onDblClick="return funcpresShowView()"> </span></td>
			      </tr>
				 <tr id="pressid">
				   <td colspan="9" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				   <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="150" class="bodytext3">Medicine Name</td>
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
                       <td><input name="medicinename" type="text" id="medicinename" size="25" autocomplete="off"></td>
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
                       <td><label>
                       <input type="button" name="Add" id="Add" value="Add" onClick="return insertitem1()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
                     
					 <input type="hidden" name="h" id="h" value="0">
                   </table>				  </td>
			       </tr>
				 <tr>
				   <td colspan="9" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total Amount</span><input type="text" id="total" readonly size="7"></td>
			      </tr>
			  
				 <tr>
				   <td colspan="9" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><span class="style2">Lab <img src="images/plus1.gif" width="13" height="13" onClick="return funcLabHideView()"  onDblClick="return funcLabShowView()"> </span></span></td>
			      </tr>
				 <tr id="labid">
				   <td colspan="9" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				     <table width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="30" class="bodytext3">Laboratory Test</td>
                       <td class="bodytext3">Rate</td>
                       <td width="30" class="bodytext3">&nbsp;</td>
                     </tr>
					  <tr>
					 <div id="insertrow1">					 </div></tr>
					  <tr>
					  <input type="hidden" name="serialnumber1" id="serialnumber1" value="1">
					  <input type="hidden" name="labcode" id="labcode" value="">
				      <td width="30"><input name="lab[]" id="lab" type="text" size="69" autocomplete="off" ></td>
				      <td width="30"><input name="rate5[]" type="text" id="rate5" readonly size="8"></td>
					  <td><label>
                       <input type="button" name="Add1" id="Add1" value="Add" onClick="return insertitem2()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
					    </table>	  </td> 
					
				  </tr>   
				 <tr>
				   <td colspan="6" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total Amount</span><input type="text" id="total1" readonly size="7"></td>
				  </tr> 
		        
				 <tr>
				   <td colspan="9" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><span class="style2">Radiology <img src="images/plus1.gif" width="13" height="13" onClick="return funcRadHideView()"  onDblClick="return funcRadShowView()"> </span></span></td>
		        </tr>
				 <tr id="radid">
				   <td colspan="9" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				    <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="30" class="bodytext3">Radiology Test</td>
                       <td class="bodytext3">Rate</td>
                       <td width="30" class="bodytext3">&nbsp;</td>
                     </tr>
					  <tr>
					 <div id="insertrow2">					 </div></tr>
					  <tr>
					  <input type="hidden" name="serialnumber2" id="serialnumber2" value="1">
					  <input type="hidden" name="radiologycode" id="radiologycode" value="">
				   <td width="30"> <input name="radiology[]" id="radiology" type="text" size="69" autocomplete="off"></td>
				      <td width="30"><input name="rate8[]" type="text" id="rate8" readonly size="8"></td>
					   <td><label>
                       <input type="button" name="Add2" id="Add2" value="Add" onClick="return insertitem3()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
					    </table>
						</td>
						
		        </tr>
				
				 <tr>
				   <td colspan="6" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total Amount</span><input type="text" id="total2" readonly size="7"></td>
				   </tr>
		       
				
				 <tr>
				   <td colspan="9" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><span class="style2">Services <img src="images/plus1.gif" width="13" height="13" onClick="return funcSerHideView()" onDblClick="return funcSerShowView()"> </span></span></td>
		        </tr>
				 <tr id="serid">
				   <td colspan="9" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				    <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="30" class="bodytext3">Services</td>
                       <td class="bodytext3">Rate</td>
                       <td width="30" class="bodytext3">&nbsp;</td>
                     </tr>
					  <tr>
					 <div id="insertrow3">					 </div></tr>
					  <tr>
					  <input type="hidden" name="serialnumber3" id="serialnumber3" value="1">
					  <input type="hidden" name="servicescode" id="servicescode" value="">
				   <td width="30"><input name="services[]" type="text" id="services" size="69"></td>
				    <td width="30"><input name="rate3[]" type="text" id="rate3" readonly size="8"></td>
					   <td><label>
                       <input type="button" name="Add3" id="Add3" value="Add" onClick="return insertitem4()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
					    </table></td>
		       </tr>
				 
				 <tr>
				   <td colspan="6" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total Amount</span><input type="text" id="total3" readonly size="7"></td>
				   </tr>
		        
				 <tr>
				   <td colspan="9" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><span class="style2">Referrel <img src="images/plus1.gif" width="13" height="13"  onClick="return  funcRefferalHideView()" onDblClick="return funcRefferalShowView()"> </span></span></td>
		        </tr>
				 <tr id="reffid">
				    <td colspan="9" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				    <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="30" class="bodytext3">Department</td>
                       <td class="bodytext3">Rate</td>
                       <td width="30" class="bodytext3">&nbsp;</td>
                     </tr>
					  <tr>
					 <div id="insertrow4">					 </div></tr>
					  <tr>
					  <input type="hidden" name="serialnumber4" id="serialnumber4" value="1">
					  <input type="hidden" name="referalcode" id="referalcode" value="">
				   <td width="30"><input name="referal[]" type="text" id="referal" size="69"></td>
				    <td width="30"><input name="rate4[]" type="text" id="rate4" readonly size="8"></td>
					   <td><label>
                       <input type="button" name="Add4" id="Add4" value="Add" onClick="return insertitem5()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
					    </table></td>
		        </tr>
				 <tr>
				   <td colspan="6" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total Amount</span><input type="text" id="total5" readonly size="7"></td>
				    <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"></td>
		        </tr>
				
				 <tr>
				   <td colspan="9" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				    <td colspan="9" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
		        </tr> 
                 <tr>
				 <td><span class="style2">Grand Total Amount</span><input type="text" id="total4" readonly size="7"> </td>
                <td colspan="9" align="middle"  bgcolor="#ecf0f5"><div align="right"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input type="hidden" name="frmflag1" value="frmflag1" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
                  <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input name="Submit222" type="submit"  value="Save Consultation" class="button" style="border: 1px solid #001E6A"/>
                  </font></font></font></font></font></font></font></font></font></div></td>
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
</td>
</tr>
</table>

<?php include ("includes/footer1.php"); ?>
</body>
</html>