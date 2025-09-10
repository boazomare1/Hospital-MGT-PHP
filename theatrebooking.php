<?php 
session_start();
ob_start();
include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");

$errmsg = "";
$bgcolorcode = "";
$pagename = "";
$consultationfees1 = '';
$availablelimit = '';
$mrdno = '';
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$locationname='';
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$smartap = '0';
$photoavailable = '';
$subtypeanum = '';
$memberno = '';
$currentdate = date('Y-m-d H:i:s');
$overallplandue = 0;

if (isset($_REQUEST["errorcode"])) { $errorcode = $_REQUEST["errorcode"]; } else { $errorcode = ""; }
if (isset($_REQUEST["oppatientcode"])) { $oppatientcode = $_REQUEST["oppatientcode"]; } else { $oppatientcode = ""; }
$location =isset( $_REQUEST['location'])?$_REQUEST['location']:'';	
$locationcode1 =isset( $_REQUEST['locationcodenew'])?$_REQUEST['locationcodenew']:'';
//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_customer1.php");

if (isset($_REQUEST["apnum"])) { $apnum = $_REQUEST["apnum"]; } else { $apnum = ""; }

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

//print_r($_REQUEST["frmflag1"]);

if ($frmflag1 == 'frmflag1')
{
$ipaddress = $_SERVER["REMOTE_ADDR"];
$patientcode=$_REQUEST["patientcode"];
$apnum=$_REQUEST["apnum"];
$locationname1 = $_REQUEST['locationnamenew'];	
$locationcode1 = $_REQUEST['locationcodenew'];
$location = $_REQUEST['location'];
	
	$patientfirstname = $_REQUEST["patientfirstname"];
	$patientfirstname = strtoupper($patientfirstname);
	$patientmiddlename = $_REQUEST['patientmiddlename'];
	$patientmiddlename = strtoupper($patientmiddlename);
	$patientlastname = $_REQUEST["patientlastname"];
	$patientlastname = strtoupper($patientlastname);
	$patientfullname=$patientfirstname.' '.$patientmiddlename.' '.$patientlastname;
	$patientcode = $_REQUEST["patientcode"];
	$patientvisitcode = $_REQUEST["visitcode"];
	//$patientvisitcode = 'visitcode';
	$proceduretype = $_REQUEST["proceduretype"];
	$category = $_REQUEST["category"];
	$surgerydate = $_REQUEST["surgerydate"];
	$theatre = $_REQUEST["theatre"];
	$estimatedtime = $_REQUEST["estimatedtime"];
	$anesthesia = $_REQUEST["anesthesia"];
	$anesthesiatype = $_REQUEST["anesthesiatype"];
	$surgeon = $_REQUEST["surgeon"];
	$ward = $_REQUEST["ward"];
	$side = $_REQUEST["side"];
	$dateAdded = date('Y-m-d');
	$assistantsurg=$_REQUEST['assistant_surgeon'];
	$anaesthetisit_note=$_REQUEST['anaesthetisit_note'];
	$doctor_note=$_REQUEST['doctor_note'];
	$patient_type=$_REQUEST['patient_type'];

	// estimated end datetime
	$t = '+'.$estimatedtime.' minutes';
	$estimated_endtime = date('Y-m-d H:i:s', strtotime($t, strtotime($surgerydate)));

	$query_theatre_check = "SELECT * FROM master_theatre_booking WHERE patientcode = '$patientcode' and patientvisitcode='$patientvisitcode' AND (approvalstatus = 'Pending' OR approvalstatus = 'Inprogress') AND locationcode = '$locationcode1'";
	//echo $query_theatre_check;exit;
	$exec_theatre_check = mysqli_query($GLOBALS["___mysqli_ston"], $query_theatre_check) or die ("Error in query_theatre_check".mysqli_error($GLOBALS["___mysqli_ston"]));
	$check_rows = mysqli_num_rows($exec_theatre_check);
	if($check_rows > 0){
		// stop record exists
		$bgcolorcode = 'Error';	
	    $errmsg = "Patient already booked!";
	    header("Location: theatrebooking.php?patientcode=$patientcode&&st=failed&&err=$errmsg");	
	}
	else {
		$query_theatre = "INSERT INTO `master_theatre_booking`( `patientcode`, `patientvisitcode`, `theatrecode`, `proceduretype`, `category`, `surgerydatetime`, `estimated_endtime`, `estimatedtime`, `starttime`, `endtime`, `approvalstatus`, `assistant_surgeon`, `ipaddress`, `username`, `locationname`, `locationcode`, `date`, `recordstatus`,`anesthesia`,`anesthesiatype`,`ward`,`side`,`anaesthetisit_note`,`doctor_note`,`patientname`,`patient_type`) VALUES ('$patientcode','$patientvisitcode','$theatre','$proceduretype','$category','$surgerydate', '$estimated_endtime','$estimatedtime','','','Pending','$assistantsurg','$ipaddress','$username','$locationname1','$locationcode1','$dateAdded','','$anesthesia','$anesthesiatype','$ward','$side','$anaesthetisit_note','$doctor_note','$patientfullname','$patient_type')";
		$exec_theatre = mysqli_query($GLOBALS["___mysqli_ston"], $query_theatre) or die ("Error in query_theatre".mysqli_error($GLOBALS["___mysqli_ston"]));
        $theatrebookingcode = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
		
        //echo $theatrebookingcode.'<br>';
        // get all selected services and add to db
        //$services = $_REQUEST['servicescode1'];
		
        $service = $_REQUEST['serv_procedure'];
        $equipments = $_REQUEST['equipments'];
        //print_r($equipments[]);
		
        //services 
        //$query_theatre_serv = "INSERT INTO `master_theatre_procedures`(`itemcode`, `patientcode`, `patientvisitcode`, `theatrebookingcode`, `ipaddress`, `username`, `locationcode`, `locationname`, `date`) VALUES ('$service','$patientcode','','$theatrebookingcode','$ipaddress','$username','$locationcode1','$locationname1','$dateAdded')";
        //echo $query_theatre_serv.'<br>';
       // $exec_theatre_serv = mysql_query($query_theatre_serv) or die ("Error in query_serv_code".mysql_error());
        
        //equipments
      for ($n=1; $n < 30; $n++) { 
			# code...
			if(isset($_REQUEST['serv'.$n]) && $_REQUEST['serv'.$n]!=''){
			$procedurenameid= $_REQUEST['serv'.$n];
			$procedurenameanum= $_REQUEST['procedure'.$n];
			$postnewPname="INSERT INTO `theatre_booking_proceduretypes`(`booking_id`, `proceduretype_id`, `locationcode`, `username`, `ipaddress`,`proceduretype_anum`) VALUES ('$theatrebookingcode','$procedurenameid','$locationcode1', '$username','$ipaddress','$procedurenameanum')";
			$postnewPname = mysqli_query($GLOBALS["___mysqli_ston"], $postnewPname) or die ("Error in postnewPname".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}

        for ($i=1; $i < 30; $i++) { 
			# code...
			if(isset($_REQUEST['surgeon'.$i]) && $_REQUEST['surgeon'.$i]!=''){
			$surgeonId= $_REQUEST['surgeon'.$i];
			$posttonewDb="INSERT INTO `theatre_booking_surgeons`(`booking_id`, `surgeon_id`, `locationcode`, `username`, `ipaddress`) VALUES ('$theatrebookingcode','$surgeonId','$locationcode1', '$username','$ipaddress')";
			$posttonewDb = mysqli_query($GLOBALS["___mysqli_ston"], $posttonewDb) or die ("Error in posttonewDb".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}

        foreach ($equipments as $value) {
        	$get_equip_code = "SELECT * FROM master_equipments WHERE itemname = '$value'";
        	$query_equip = "INSERT INTO `master_theatre_equipments`(`itemcode`, `patientcode`, `patientvisitcode`, `theatrebookingcode`, `ipaddress`, `username`, `locationcode`, `locationname`, `date`) VALUES ('$value', '$patientcode','$patientvisitcode','$theatrebookingcode','$ipaddress','$username','$locationcode1','$locationname1','$dateAdded')";
        		//echo $query_equip;
        	$exec_equip = mysqli_query($GLOBALS["___mysqli_ston"], $query_equip) or die ("Error in query_equip".mysqli_error($GLOBALS["___mysqli_ston"]));
        }
		
		$bgcolorcode = 'Success';	
		$errmsg = "Theatre Booking Added Successfully";
		header("Location: theatrebooking.php?st=success");	
	}	
}

//set post values to empty
    $patientfirstname = '';
	$patientmiddlename = '';
	$patientlastname = '';
	$age = '';
	$gender = '';
	$subtype = '';
	$accountname = '';
?>
<?php

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if (isset($_REQUEST["err"])) { $err = $_REQUEST["err"]; } else { $err = ""; }
if ($st == 'success')
{
		$errmsg = "Success. New Theatre Booking Created.";
		if (isset($_REQUEST["cpynum"])) { $cpynum = $_REQUEST["cpynum"]; } else { $cpynum = ""; }
		if ($cpynum == 1) //for first company.
		{
			$errmsg = "Success. New Theatre Booking Created.";
		}
}
else if ($st == 'failed')
{
		//$errmsg = "Failed. Theatre Booking Already Exists.";
	      $errmsg = "Failed.".$err;
}
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1--".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
$res12location = $res["locationname"];
$locationcode=$res12locationcode = $res['locationcode'];
$res12locationanum = $res["auto_number"];

$query3 = "select * from master_location where status = '' and locationname='$res12location'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$visitcodeprefix = $res3['prefix'];
$visitcodeprefix1=strlen($visitcodeprefix);

//include ("autocomplete_services_theatre.php");
//include ("autocomplete_equipments_theatre.php");

?>
<script>

function locationform(frm,val)
{

<?php $query11 = "select * from master_location";
    $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res11 = mysqli_fetch_array($exec11))
	{
	$scriptlocationcode = $res11["locationcode"];
	$scriptlocationprefix = $res11["prefix"];
	?>
	if(document.getElementById("location").value=="<?php echo $scriptlocationcode; ?>")
		{
		document.getElementById("visitcode").value = "<?php echo $scriptlocationprefix.'-'.$maxanum; ?>";
		
		}
	<?php
	 }?>
	//document.form1.customercode.value='ok';
	funcLocationDepartmentChange();
}

</script>

<?php
$res11locationcode='';
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

$registrationdate = date('Y-m-d');
$consultationdate = date('Y-m-d');
$consultationtime = date('H:i');

if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
//$patientcode = 'MSS000000014';
//$consultationfees = '500';
if (isset($_REQUEST["errorcode"])) { $errorcode = $_REQUEST["errorcode"]; } else { $errorcode = ""; }
//$patientcode = 'MSS00000009';

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
.custom-header{
	background-color: #c3eeb7;
	color:#000;
	text-transform: bold;
	text-align: center;
}
</style>

<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script type="text/javascript" src="js/insertNewSurgeon.js"></script>
<script type="text/javascript" src="js/insertnewprocedure.js"></script>
<script type="text/javascript" src="js/membervalidation.js"></script>
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


function btnDeleteClick5(delID5)
{
	/*alert ("Inside btnDeleteClick.");*/
	//var newtotal2;
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
    var parent2 = document.getElementById('insertrow'); // tbody name.
	document.getElementById ('insertrow').removeChild(child2);
	
	console.log(parent2);
	var child2 = document.getElementById('surgeon_name'+varDeleteID2);  //tr name
    var parent2 = document.getElementById('insertrow'); // tbody name.
	//alert (child);
	if (child2 != null) 
	{
		alert ("Row Exsits.");
		//document.getElementById ('insertrow').removeChild(child2);
	}
		
}


function btnDeleteClick6(delID6)
{
	/*alert ("Inside btnDeleteClick.");*/
	//var newtotal2;
	//alert(radrate);
	var varDeleteID3= delID6;
	//alert (varDeleteID2);
	var fRet6; 
	fRet5 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet6 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child2= document.getElementById('idTR1'+varDeleteID3);  //tr name
    var parent2 = document.getElementById('insertrowProcedure'); // tbody name.
	document.getElementById ('insertrowProcedure').removeChild(child2);
	
	console.log(parent2);
	var child2 = document.getElementById('procedure_name'+varDeleteID3);  //tr name
    var parent2 = document.getElementById('insertrowProcedure'); // tbody name.
	//alert (child);
	if (child2 != null) 
	{
		alert ("Row Exsits.");
		//document.getElementById ('insertrow').removeChild(child2);
	}
	

}
</script>

<?php	
    $query1111 = "select * from master_employee where username = '$username'";
    $exec1111 = mysqli_query($GLOBALS["___mysqli_ston"], $query1111) or die ("Error in Query1111".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res1111 = mysqli_fetch_array($exec1111))
	{
		$username = $res1111["username"];
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

?>
<style type="text/css">
.ui-menu .ui-menu-item{ zoom:1 !important; }

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
</style>
</head>
<link href="autocomplete.css" rel="stylesheet">
<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/multi-select.css">
<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/bootstrap-datetimepicker.min.js"></script>
<script src="js/jquery.multi-select.js" type="text/javascript"></script>
<!--<script type="text/javascript" src="js/autocustomercodesearch2op_new1.js"></script>-->
<script type="text/javascript" src="js/autocustomercodesearchtheatre.js"></script>
<script type="text/javascript">
    /*$(".form_datetime").datetimepicker({
    	format: 'yyyy-mm-dd hh:ii', 
    	timepicker:false
    	step: 30
    });*/
</script> 
<script language="javascript">
function ajaxlocationfunction(val)
{ 
if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);
	xmlhttp.send();
}
					


function process1()
{   
	//document.getElementById('submit').disabled="true";
	//alert ("Before Function");
	//To validate patient is not registered for the current date.
	//funcVisitEntryPatientCodeValidation1();
	//return false;
    
	var patientcode = document.getElementById("patientcode").value;
	if(patientcode.length < 2)
	{
		 //alert("Please select patient");
		 Swal.fire({
		  title: 'Error!',
		  text: 'Please Select Patient',
		  type: 'warning',
		  confirmButtonText: 'Ok'
		});
		document.getElementById("customer").focus();
		return false;
	}

	/*var proceduretype = document.getElementById("proceduretype").value;
	if(proceduretype.length < 1)
	{
		alert("Please select procedure type");
		 document.getElementById("proceduretype").focus();
			return false;
	}*/

	var category = document.getElementById("category").value;
	if(category.length < 1)
	{
		alert("Please select category");
		 document.getElementById("category").focus();
			return false;
	}

	var anesthesia_na = document.getElementById("anaesthesia_name").value;
	if(anesthesia_na!='')
	{
	var anesthesia = document.getElementById("anesthesia").value;
	if(anesthesia.length < 1)
	{
		
		alert("Please select Anesthesia from DB Search");
		 document.getElementById("anaesthesia_name").focus();
			return false;
	}
	}
	
	
	/*var speaciality = document.getElementById("speaciality").value;
	if(speaciality.length < 1)
	{
		alert("Please select speaciality");NAM
		 document.getElementById("speaciality").focus();
			return false;
	}*/
    
    var theatre = document.getElementById("theatre").value;
	if(theatre.length < 1)
	{
		alert("Please select theatre");
		 document.getElementById("theatre").focus();
			return false;
	}

	var surgerydate = document.getElementById("surgerydate").value;
	if(surgerydate.length < 1)
	{
		alert("Please select surgery date and time");
		 document.getElementById("surgerydate").focus();
			return false;
	}

	var today_date = "<?php echo date('y-m-d H:m');?>";
	
	

	var estimatedtime = document.getElementById("estimatedtime").value;
	if(estimatedtime.length < 1)
	{
		alert("Please select estimated time");
		 document.getElementById("estimatedtime").focus();
			return false;
	}


	/*var serv = document.getElementById("serv").value;                  
	if(serv.length < 1)
	{
	    alert("Please select service procedure");
		 document.getElementById("serv").focus();
			return false;
	}*/

	//var check1 = document.getElementsByName("equip[]");   
	var check1 = document.getElementById("pre-selected-options");          
	if(check1.length < 1)
	{
	    alert("Please select equipments");
		 document.getElementById("pre-selected-options").focus();
			return false;
	}
	
    var result = confirm("Do you want to Save?");
	if (result) {
	    return true;
		document.getElementById("Submit222").disabled= true;
	}
	else
		return false;

}

function funcOnLoadBodyFunctionCall()
{ 
	//alert ("Inside Body On Load Fucntion.");
	
}

$(function() {
	
$('#customer').autocomplete({
		
	source:'ajaxcustomernewserach_theater.php', 
	//alert(source);
	minLength:3,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var code = ui.item.id;
			var customercode = ui.item.customercode;
			var accountname = ui.item.accountname;
			var visitcode = ui.item.visitcode;
			$('#customercode').val(customercode);
			$('#accountnamename').val(accountname);
			$('#patientcode').val(customercode);
			$('#visitcode').val(visitcode);
			
			funcCustomerSearch3();
			//funcCustomerSearch2();
			
			},
    });
});


//check if patient has pending surgery
function funcCustomerSearch3()
{
	if(document.getElementById("patientcode").value!="")
	{
		var varCustomerSearch = document.getElementById("patientcode").value;
		//alert (varCustomerSearch);
	
		$.ajax(
            {
                url:"check_theatre_patient.php",
                type:"post",
                data:{state:varCustomerSearch},
                success:function(response)
                {   
                	/*
                	console.log(response);
                	if(response == 'Pending'){
                		// clear
                		funcCustomerClear();
                		// alert
                		Swal.fire({
						  title: '',
						  text: 'Patient already booked',
						  type: 'error',
						  confirmButtonText: 'Ok'
						});
                	} else{
                		// continue with search
                		funcCustomerSearch2();
                	}*/
                	funcCustomerSearch2();
                }
            });
		
	}    
}

function funcCustomerClear()
{
	// clear form
	document.getElementById("customer").value ="";
	document.getElementById("customercode").value ="";
	document.getElementById("patientcode").value ="";
	document.getElementById("visitcode").value ="";
	document.getElementById("patientfirstname").value ="" 
	document.getElementById("patientmiddlename").value ="" 
	document.getElementById("patientlastname").value =""  
	document.getElementById("age").value ="" 
	document.getElementById("registrationdate").value ="" 
	document.getElementById("gender").value ="" 
	document.getElementById("subtype").value ="" 
	document.getElementById("accountnamename").value ="" 

}

function cleartime(){
	document.getElementById("estimatedtime").value = '';
}
//check if patient has pending surgery
function checkTheatreTime()
{

		var vartheatre= document.getElementById("theatre").value;
		var varsurgerydate= document.getElementById("surgerydate").value;
		var varestimatetime = document.getElementById("estimatedtime").value;
		var varpatientcode = document.getElementById("patientcode").value;
		//alert(vartheatre);
		$.ajax(
            {
                url:"check_theatre_time.php",
                type:"post",
                data:{theatre:vartheatre, date:varsurgerydate, time:varestimatetime, pcode: varpatientcode},
                success:function(response)
                {   
                	console.log(response);              	
                	if(response > 0){
                		// clear
                		document.getElementById("theatre").value = "";
                		document.getElementById("surgerydate").value = "";
                		document.getElementById("estimatedtime").value = "";
                		document.getElementById("surgerydate").disabled = true;
                		document.getElementById("estimatedtime").disabled = true;
                		// alert
                		Swal.fire({
						  title: 'Error!',
						  text: 'Theatre already booked',
						  type: 'error',
						  confirmButtonText: 'Ok'
						});
                	} 
                	
                }
            });
		   
}

</script>

<script type="text/javascript" src="js/autosuggestnew1.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_newcustomer.js"></script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script type="text/javascript" src="js/visitentrypatientcodevalidation1.js"></script>
<link href="css/jquery.datetimepicker.min.css" rel="stylesheet" type="text/css" />
<script src="js/jquery.datetimepicker.full.min.js"></script>
<script src="js/sweetalert.js"></script>
<script type="text/javascript">
 
var checkPastTime = function(currentDateTime) {

var d = new Date();
var todayDate = d.getDate();


if (currentDateTime.getDate() == todayDate) { // check today date
    this.setOptions({
        minTime: d.getHours() + ':00' //here pass current time hour
    });
} else
    this.setOptions({
        minTime: false
    });
};

$(document).ready(function(){
    jQuery('#surgerydate').datetimepicker({
    	step: 60,
    	minDate : 0,
        onChangeDateTime:checkPastTime,
        onShow:checkPastTime
    });
});


function ShowImage(imgval,flg)
{
	var imgval = document.getElementById('patientcode').value;
	if(imgval != '')
	{
		if(flg == 'Show Image') {
		var photoavailable = document.getElementById('photoavailable').value;
		if(photoavailable == 'YES') {
		document.getElementById('patientimage').src = 'patientphoto/'+imgval+'.jpg';
		} else {
		document.getElementById('patientimage').src = 'patientphoto/noimage.jpg';
		}
		document.getElementById('imgbtn').value = "Hide Image";
		} else {
		document.getElementById('patientimage').src = '';
		document.getElementById('imgbtn').value = "Show Image";
		}
	}
	else
	{
		alert("Patient Code is Empty");
	}
}

</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />  
<link rel="stylesheet" type="text/css" href="css/sweetalert.css" />      
<body onLoad="return funcOnLoadBodyFunctionCall();">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?>	</td>
  </tr>
  <tr>
  <td colspan="10" bgcolor="#ecf0f5">
  <!-- body -->
    <form name="form1" id="form1" method="post" action="theatrebooking.php" onKeyDown="return disableEnterKey(event)" >
       <table width="95%" border="0" cellspacing="0" cellpadding="0" style="margin-left:15px;margin-top:15px;">
       	<tr>
       		<td width="860">
       			<table width="100%" height="auto" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
       				<tbody>
       					<tr bgcolor="#011E6A">
       						<td bgcolor="#ecf0f5" class="bodytext3" colspan="2"><strong>Theatre Booking</strong></td>
       						<td colspan="5" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
       							<?php
									$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
									$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1000".mysqli_error($GLOBALS["___mysqli_ston"]));
									$res1 = mysqli_fetch_array($exec1);
									
									echo $res1location = $res1["locationname"];
									//$res1locationanum = $res1["locationcode"];
								?>
       						</td>
       						<td bgcolor="#ecf0f5" class="bodytext3"></td>
       					</tr>
       					<tr bgcolor="#011E6A">
                			 <td colspan="8" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Search Sequence : First Name | Middle Name | Last Name | Date of Birth | Location | Mobile Number | National ID | Registration No   (*Use "|" symbol to skip sequence)</strong>     
              			</tr>
              			<tr>
			                <td colspan="11" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#DFF2BF'; } ?>" class="bodytext3">
			                	<?php echo $errmsg;?>&nbsp;
			                </td>
			            </tr>
			            <tr>
			            	<td>&nbsp;</td>
			            </tr>
			            <tr>
						  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><font color='red'>Patient Search</font></td>
						  <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5">
							  <input type="hidden" name="photoavailable" id="photoavailable" size="10" autocomplete="off" value="<?php echo $photoavailable; ?>">
							  <input name="customer" id="customer" size="60" autocomplete="off">
							  <input name="customerhiddentextbox" id="customerhiddentextbox" value="" type="hidden">
							  <input name="customercode" id="customercode" value="" type="hidden">
							  <input name="nationalid" id="nationalid" value = "" type = "hidden">
							  <input name="accountnames" id="accountnames" value="" type="hidden">
							  <input name = "mobilenumber111" id="mobilenumber111" value="" type="hidden">
			 				  <input type="hidden" name="recordstatus" id="recordstatus">
							  <input type="hidden" name="billnumbercode" id="billnumbercode" value="<?php echo $billnumbercode; ?>" readonly style="border: 1px solid #001E6A;">	
							  <input name="apnum" id="apnum" value="<?php echo $apnum; ?>" type="hidden">
		                  </td>
						</tr>
						<tr>
							<td  class="bodytext3" ><strong> Location </strong></td>
							<td  class="bodytext3" >
								<select name="location" id="location" onChange="locationform(form1,this.value); ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;">
					                <?php
											
										$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
										$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1err".mysqli_error($GLOBALS["___mysqli_ston"]));
										while ($res1 = mysqli_fetch_array($exec1))
										{
										$res1location = $res1["locationname"];
										$res1locationanum = $res1["locationcode"];
									?>
										<option value="<?php echo $res1locationanum; ?>" <?php if($res11locationcode!=''){if($res11locationcode == $res1locationanum){echo "selected";}}?>><?php echo $res1location; ?></option>
									<?php
										}
									 ?>
					            </select>
					            <input type="hidden" name="locationnamenew" value="<?php echo $locationname; ?>">
                  				<input type="hidden" name="locationcodenew" id="locationcodenew" value="<?php echo $res1locationanum; ?>">
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
						  <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
						  	<strong><label>Patient Details</label></strong>
						  </td>
						</tr>
						<!-- patient details -->
						<tr>
							<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Patient</td>
							<td align="left" valign="middle"  bgcolor="#ecf0f5" colspan="2">
								 <input name="patientfirstname" id="patientfirstname" value="<?php echo $patientfirstname; ?>" readonly  size="30" />
								&nbsp;&nbsp;&nbsp;&nbsp; <input name="patientmiddlename" id="patientmiddlename" value="<?php echo $patientmiddlename; ?>" readonly size="15" />
							</span>
							</td>
							
							<td align="left" valign="middle"  bgcolor="#ecf0f5">
								<input name="patientlastname" id="patientlastname" value="<?php echo $patientlastname; ?>" readonly size="26" />
							</td>
							<td align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Age</td>
				  			<td align="left" valign="middle"  bgcolor="#ecf0f5">
				  				<input type="text" name="age" id="age" value="<?php echo $age; ?>" readonly>
				  			</td>
						</tr>
						<tr>
							<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Patient Reg ID </td>
							<td align="left" valign="middle"  bgcolor="#ecf0f5">
								<input name="patientcode" id="patientcode" size="30" value="<?php echo $patientcode; ?>" readonly/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input name="visitcode" id="visitcode" size="15" value="" readonly/>
							</td>
							<td align="right" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Registration Date </span></td>
							<td align="left" valign="middle"  bgcolor="#ecf0f5">
								<input type="text" name="registrationdate" id="registrationdate" size="26" value="<?php echo $consultationdate; ?>" >
							</td>
							<td align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Gender</td>
				  			<td align="left" valign="middle"  bgcolor="#ecf0f5">
				  				<input type="text" name="gender" value="<?php echo $gender; ?>" id="gender" readonly>
				  			</td>
						</tr>
						<tr>
							<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Sub Type </td>
							<td align="left" valign="middle"  bgcolor="#ecf0f5">
								<label>
								    <input type="text" name="subtypename" id="subtypename"  value="<?php echo $subtype;?>"  size="30" readonly="readonly"  >
								    <input type="hidden" name="subtype" id="subtype"  value="<?php echo $subtypeanum;?>"  readonly="readonly"  style="border: 1px solid #001E6A;">
								</label>
							</td>
							<td align="right" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Account</span></td>
						    <td align="left" valign="middle"  bgcolor="#ecf0f5">
						    	 <input type="text" name="accountnamename" id="accountnamename"  size="26" value="<?php echo $accountname;?>"  readonly="readonly" style="">
						   		 <input type="hidden" name="accountname" id="accountname"  value="<?php echo $accountnameanum;?>"  readonly="readonly"  style="border: 1px solid #001E6A;"></td>
						    <td align="right" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32"><!--Ward--></span></td>
							<td align="left" valign="middle"  bgcolor="#ecf0f5">
	                     		<!--<select name="ward" id="ward" style="border: 1px solid #001E6A;">
							  		<option value="">Select Ward</option>-->
							  		<?php
									$auto_number ='';
							  		 $query_th_1 = "SELECT * FROM master_ward ORDER BY auto_number ASC";
							  		 $exec_th_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_th_1) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
									 while ($res_th_1 = mysqli_fetch_array($exec_th_1))
									 {
									 	$auto_number = $res_th_1['auto_number'];
									 	$ward = $res_th_1['ward'];

							  		?>
							  			<!--<option value="<?php echo $auto_number;?>"><?php echo $ward;?></option>-->
							  	    <?php } ?>
							  	<!--</select>-->
								 <input type='hidden' name="ward" id="ward" value='<?php echo $auto_number;?>'>
	                     	</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
						  <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
						  	<strong><label>Booking Details</label></strong>
						  </td>
						</tr>
						<!-- booking details -->
						<tr>
							<td td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Procedure Type</span></td>
							<td align="left" valign="middle"  bgcolor="#ecf0f5">
							  	<select name="proceduretype" id="proceduretype" style="border: 1px solid #001E6A;">
							  		<option value="">Select Procedure</option>
							  		<option value="emergency">Emergency</option>
							  		<option value="elective">Elective</option>
							  	</select>
							</td>
							<td align="right" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32"><font color='red'>Category</font></span></td>
							<td align="left" valign="middle"  bgcolor="#ecf0f5">
							  	<select name="category" id="category" style="border: 1px solid #001E6A;">
							  		<option value="">Select Category</option>
							  		<option value="major">Major</option>
							  		<option value="minor">Minor</option>
							  	</select>
							</td>
							<td align="right"  valign="middle"  bgcolor="#ecf0f5"><!--<span class="bodytext32">Patient Type</span>--></td>
							<td align="left" valign="middle"  bgcolor="#ecf0f5">
							<input type='hidden' name="patient_type" id="patient_type" value=''>
							  	<!--<select name="patient_type" id="patient_type" style="border: 1px solid #001E6A;">
							  		<option value="">Select Type</option>
							  		<option value="New">New</option>
							  		<option value="Active IP">Active IP</option>
							  	</select>-->
							</td>
					</tr>
					<tr>
						<td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Surgeon</span></td>
						<td>
							
							<input type="hidden" name="serialnumber" id="serialnumber" value="1">
							<input type="hidden" name="auto_id" id="auto_id" value="0"/>
							<input type="text" name="surgeon_name[]" size="35" id="surgeon_name" autocomplete="off">
							<input type="hidden" name="surgeon" id="surgeon" autocomplete="off">
							<input type="button" name="addSurgeon" id="addSurgeon" onClick="return insertNewSurgeon()" value="Add" class="button" style="border: 1px solid #001E6A">
							<!-- insert -->
							<table id="insertrow">
										
							</table>
							<!--/insert-->
						</td>
						<td align="right" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32"><font color='red'>Anaesthetist</font></span></td>
						<td align="left" valign="middle"  bgcolor="#ecf0f5">
							<input type="text" name="anaesthesia_name" size="26" id="anaesthesia_name" autocomplete="off">
							<input type="hidden" name="anesthesia" id="anesthesia" autocomplete="off">
						</td>
						<td align="right" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Anaesthesia Type</span></td>
							<td align="left" valign="middle"  bgcolor="#ecf0f5">
								<select name="anesthesiatype" id="anesthesiatype" width="100" style="border: 1px solid #001E6A;">
							  		<option value="">Anaesthesia Type</option>
		                            <option value="General Anesthesia">General Anesthesia</option>
		                            <option value="Spinal Anesthesia">Spinal Anesthesia </option>
		                            <option value="Sedation Anesthesia">Sedation Anesthesia</option>
		                            <option value="Regional Block Anesthesia">Regional Block Anesthesia</option>
		                            <option value="Local Anesthesia">Local Anesthesia</option>
							  	</select>
							</td>
					</tr>

						<tr>
							<td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32"><font color='red'>Theatre</font></span></td>
							<td align="left" valign="middle"  bgcolor="#ecf0f5">
							  	<select name="theatre" id="theatre" style="border: 1px solid #001E6A;">
							  		<option value="">Select Theatre</option>
							  		<?php
							  		 $query_th_1 = "SELECT * FROM master_theatre ORDER BY auto_number ASC";
							  		 $exec_th_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_th_1) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
									 while ($res_th_1 = mysqli_fetch_array($exec_th_1))
									 {
									 	$auto_number = $res_th_1['auto_number'];
									 	$theatre_name = $res_th_1['theatrename'];

							  		?>
							  			<option value="<?php echo $auto_number;?>"><?php echo $theatre_name;?></option>
							  	    <?php } ?>
							  	</select>
							</td>
							<td align="right" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32"><font color='red'>Surgery Date</font></span></td>
							<td align="left" valign="middle"  bgcolor="#ecf0f5">
							  	<input id="surgerydate" name="surgerydate" size="26" autocomplete="off" readonly type="text" onChange="return cleartime()" >
							</td>
							<td align="right" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32"><font color='red'>Estimated Time</font></span></td>
						    <td align="left" valign="middle"  bgcolor="#ecf0f5">
						  		<input type="number" name="estimatedtime" id="estimatedtime"  placeholder="Minutes" value="" style="" onKeyUp="return checkTheatreTime()" >
						    </td>
						</tr>
						<tr>
							<input type="hidden" name="locationcode" id="locationcode" value="<?php echo $res11locationcode;?>">
							<input type="hidden" name="subtypeano" id="subtypeano">
							<input type="hidden" name="billtypes" id="billtypes">
							<input type="hidden" name="payment" id="payment">
						</tr>
						<tr>
							<td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Procedure</span></td>
							
							<td align="left" valign="middle">
							<input type="hidden" name="serialnumberProcedure" id="serialnumberProcedure" value="1">
							
								<input type="hidden" name="auto_idProcedure" id="auto_idProcedure" value="0"/>
								<input type="text" name="procedure_name[]" size="35" id="serv" autocomplete="off">
								<input type="hidden" name="serv_procedure" id="procedure" autocomplete="off">
								<input type="button" name="addProcedure" id="addProcedure" onClick="return insertNewProcedure()" value="Add" class="button" style="border: 1px solid #001E6A">
								
								<table id="insertrowProcedure"></table>

							</td>

						<td align="right" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Assistant surgeon</span></td>
						    <td align="left" valign="middle"  bgcolor="#ecf0f5">
						  		<input type="text" name="assistant_surgeon" size="26" id="assistant_surgeon" autocomplete="off">
						    </td>	

								 
                  
               </tr>
              
	                    <tr>
	                    	<td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Side</span></td>
							<td align="left" valign="middle"  bgcolor="#ecf0f5">
	                     		<select id="side" name="side" style="border: 1px solid #001E6A;width:250px;">
	                     			<option value="N/A" selected>N/A</option>
	                     			<option value="Left">LEFT</option>
	                     			<option value="Right">RIGHT</option>
	                     		</select>
	                     	</td>
	                    </tr>
	                    <tr>
	                    	<td>&nbsp;</td>
	                    </tr>
						
						<!--<tr>
							<td align="left" width="" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Anaesthetist Notes</span></td>
							<td><textarea rows="4" cols="40" name="anaesthetisit_note" id="anaesthetisit_note" ></textarea></td>
							<td align="right"  valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Doctor Notes</span></td>
							<td><textarea rows="4" cols="29" name="doctor_note" id="doctor_note" ></textarea></td>
						</tr>-->
						<input type='hidden'  name="anaesthetisit_note" id="anaesthetisit_note" value=''>
						<input type='hidden'  name="doctor_note" id="doctor_note" value=''>
						<tr>
	                    	<td>&nbsp;</td>
	                    </tr>
						
	                    <tr>
	                    	<td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Equipments</span></td>
							<td align="left" valign="middle"  bgcolor="#ecf0f5"colspan="2">
							   <select name="equipments[]" id='pre-selected-options' multiple='multiple'>
							   	  <?php 
							   	    // get equipments from masters
							   	     $query_equip= "SELECT * FROM master_equipments WHERE record_status <> 'deleted'";
										 $exec_equip= mysqli_query($GLOBALS["___mysqli_ston"], $query_equip) or die ("Error in Query_speac".mysqli_error($GLOBALS["___mysqli_ston"]));
										 while($res_equip = mysqli_fetch_array($exec_equip)){
											//
											$equip_id = $res_equip['auto_number'];
											$equip_name = $res_equip['equipment_name'];
							   	  ?>
								  <option value='<?php echo $equip_id;?>'><?php echo $equip_name;?></option>
								  <?php }?>
								</select>
							</td>

		                </tr>
		                <tr>
		                	<td>&nbsp;</td>
		                </tr>
		                <tr> 
		                	 <td>&nbsp;</td>
		                	 <td>
		                	 	<input type="hidden" name="frmflag1" value="frmflag1" />
                 			 	<input name="Submit222" type="submit"  value="Save Theatre Booking" accesskey="s" class="button" id="Submit222"  onclick="return process1(); confirm('Save Theatre Booking?');" style="background-color: #4CAF50;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;"/>
                 			 </td>
		                </tr>
       				</tbody>
       			</table>
       		</td>
       	</tr>
       </table>
	</form>
  </td>
       	</tr>
</table>
<script type="text/javascript">
	$(function() {
    	var procedurename = document.getElementById('serv');
	    $('#serv').autocomplete({		
			source:'get_theatre_procedures.php',
			minLength:2,
			delay: 0,
			html: true, 
				select: function(event,ui){
					var procedurenameid=ui.item.docid;
					var specname=ui.item.spname;
					$('#procedure').val(procedurenameid);	
				}
		    });
	 });
	// sepaciality tie
	/*$(document).ready(function()
        {
            $("#speaciality").change(function()
            {
                var state = $(this).val();//get select value
                $.ajax(
                {
                    url:"get_theatre_procedures.php",
                    type:"post",
                    data:{state:$(this).val()},
                    success:function(response)
                    {   
                    	//console.log(response);
                    	document.getElementById("serv").disabled = false;
                        $("#serv").html(response);
                    }
                });
            });
     });*/
	// instantiate
	$('#pre-selected-options').multiSelect({
		  selectableHeader: "<div class='custom-header'>Equipments</div>",
		  selectionHeader: "<div class='custom-header'>Selected Equipments</div>",
	});
	//document.getElementById("serv").disabled = true;
	// self executing function here
	var varpatientcode = document.getElementById("patientcode").value;
	if(varpatientcode != ''){
		// if patient not empty
		Swal.fire({
		  title: 'Error!',
		  text: 'Please Select Patient',
		  type: 'warning',
		  confirmButtonText: 'Ok'
		});
	}


	/*var varspeaciality = document.getElementById("speaciality").value;
	if(speaciality == ''){
		document.getElementById("services").disabled = true;
		//document.getElementById("serviceqty").disabled = true;
		//document.getElementById("Add3").disabled = true;
	}*/

	// theatre
	var vartheatre = document.getElementById("theatre").value;
	if(vartheatre == ''){
		document.getElementById("surgerydate").disabled = true;
		document.getElementById("estimatedtime").disabled = true;
	}

	$('#theatre').on('input', function() { 
       //$(this).val() // get the current value of the input field.
       //checkTheatreTime();
       document.getElementById("surgerydate").disabled = false;
       document.getElementById("estimatedtime").disabled = false;
    });

    // DB Searches
    $(function() {
    	var surgeonname = document.getElementById('surgeon_name');
	    $('#surgeon_name').autocomplete({		
			source:'ajaxtheatredoctor.php?term='+surgeonname, 
			
			minLength:2,
			delay: 0,
			html: true, 
				select: function(event,ui){
					var surgeonid=ui.item.docid;
					$('#surgeon').val(surgeonid);	
				}
		    });
	 });

    $(function() {
    	var anaesthesianame = document.getElementById('anaesthesia_name');
	    $('#anaesthesia_name').autocomplete({		
			source:'ajaxtheatreanaesthesia.php?term='+anaesthesianame, 
			
			minLength:2,
			delay: 0,
			html: true, 
				select: function(event,ui){
					var ana_id=ui.item.docid;
					$('#anesthesia').val(ana_id);	
				}
		    });
	 });
</script>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
