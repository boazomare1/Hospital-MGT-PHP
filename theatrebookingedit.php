<?php 
session_start();
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


if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }


if ($st == 'del')

{

	$delanum = $_REQUEST["anum"];

	/**/
	

	//$query3 = "update master_transactionpharmacy set recordstatus = 'deleted' where auto_number = '$delanum'";
	//$query3 = "DELETE FROM master_theatre_booking WHERE auto_number = '$delanum' ";
	$query3 = "DELETE FROM master_booking_surgeons WHERE auto_number='$delanum'";
	//$query4 = "DELETE FROM master_theatre_equipments WHERE theatrebookingcode = '$delanum' ";
    
	//echo $query3;

	//exit;

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
    
    header("Location: theatrebooking.php?st=success");	
}


if (isset($_REQUEST["errorcode"])) { $errorcode = $_REQUEST["errorcode"]; } else { $errorcode = ""; }
if (isset($_REQUEST["oppatientcode"])) { $oppatientcode = $_REQUEST["oppatientcode"]; } else { $oppatientcode = ""; }
$location =isset( $_REQUEST['location'])?$_REQUEST['location']:'';	
$locationcode1 =isset( $_REQUEST['locationcodenew'])?$_REQUEST['locationcodenew']:'';
//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_customer1.php");

if (isset($_REQUEST["apnum"])) { $apnum = $_REQUEST["apnum"]; } else { $apnum = ""; }

//if (isset($_REQUEST["id"])) { $banum = $_REQUEST["id"]; } else { $banum = ""; }

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

//print_r($_REQUEST["frmflag1"]);

if ($frmflag1 == 'frmflag1')
{
$ipaddress = $_SERVER["REMOTE_ADDR"];
$patientcode=$_REQUEST["patientcode"];
//$apnum=$_REQUEST["apnum"];
//$locationname1 = $_REQUEST['locationnamenew'];	
//$locationcode1 = $_REQUEST['locationcodenew'];
//$location = $_REQUEST['location'];
    $banum = $_REQUEST['banum'];
	
	$patientfirstname = $_REQUEST["patientfirstname"];
	$patientfirstname = strtoupper($patientfirstname);
	$patientmiddlename = $_REQUEST['patientmiddlename'];
	$patientmiddlename = strtoupper($patientmiddlename);
	$patientlastname = $_REQUEST["patientlastname"];
	$patientlastname = strtoupper($patientlastname);
	$patientfullname=$patientfirstname.' '.$patientmiddlename.' '.$patientlastname;
	
	$patientcode = $_REQUEST["patientcode"];
	$patientcode_old = $_REQUEST["patientcode_old"];


	//$patientvisitcode = $_REQUEST["patientvisitcode"];
	//$patientvisitcode = 'visitcode';
	$proceduretype = $_REQUEST["proceduretype"];
	$category = $_REQUEST["category"];
	/*$speaciality = $_REQUEST["speaciality"];*/
	$surgerydate = $_REQUEST["surgerydate"];
	$theatre = $_REQUEST["theatre"];
	$estimatedtime = $_REQUEST["estimatedtime"];
	$anesthesia = $_REQUEST["anesthesia"];
	$anesthesiatype = $_REQUEST["anesthesiatype"];
	$surgeon = $_REQUEST["surgeon"];
	$ward = $_REQUEST["ward"];

	$side = $_REQUEST["side"];
	$assistant_surgeon = $_REQUEST["assistant_surgeon"];
	$anaesthetisit_note = $_REQUEST["anaesthetisit_note"];
	$patient_type = $_REQUEST["patient_type"];

	/*$service = $_REQUEST['service_procedure'];*/

	//print_r($_REQUEST);

    //$equipments = $_REQUEST['equipments'];

    /*$procedure=$_REQUEST['service_procedure_init'];*/
    

	$dateAdded = date('Y-m-d');

	// estimated end datetime
	$t = '+'.$estimatedtime.' minutes';
	$estimated_endtime = date('Y-m-d H:i:s', strtotime($t, strtotime($surgerydate)));

	$query_theatre_check = "SELECT * FROM master_theatre_booking WHERE patientcode = '$patientcode' AND approvalstatus = 'Pending' OR approvalstatus = 'Inprogress' AND locationcode = '$locationcode1'";
	$exec_theatre_check = mysqli_query($GLOBALS["___mysqli_ston"], $query_theatre_check) or die ("Error in query_theatre_check".mysqli_error($GLOBALS["___mysqli_ston"]));
	$check_rows = mysqli_num_rows($exec_theatre_check);

	// check if there is another operation
	

		$query_theatre = "UPDATE master_theatre_booking SET `patientcode` = '$patientcode',`theatrecode` = '$theatre', `proceduretype` = '$proceduretype', `category` = '$category',`surgerydatetime` = '$surgerydate', `estimated_endtime` = '$estimated_endtime' ,`estimatedtime` = '$estimatedtime', `starttime` = '', `endtime` = '', `approvalstatus` = 'Pending', `ipaddress` = '$ipaddress', `username` = '$username', `date` = '$dateAdded', `anesthesia` = '$anesthesia',`surgeon` = '$surgeon',`anesthesiatype` = '$anesthesiatype', `ward` = '$ward', `side` = '$side', `assistant_surgeon` = '$assistant_surgeon', `anaesthetisit_note` = '$anaesthetisit_note', `patient_type` = '$patient_type' WHERE auto_number = '$banum'";

		$exec_theatre = mysqli_query($GLOBALS["___mysqli_ston"], $query_theatre) or die ("Error in query_theatre".mysqli_error($GLOBALS["___mysqli_ston"]));
        $theatrebookingcode = $banum;


        for ($n=1; $n < 30; $n++) { 
			# code...
			if(isset($_REQUEST['serv'.$n]) && $_REQUEST['serv'.$n]!=''){
			 $procedurenameid= $_REQUEST['serv'.$n];
			 $procedurenameanum= $_REQUEST['procedure'.$n];
			/* print_r($procedurenameid);
			 exit();*/
		$postnewPname="INSERT INTO `theatre_booking_proceduretypes`(`booking_id`, `proceduretype_id`, `locationcode`, `username`, `ipaddress`,`proceduretype_anum`) VALUES ('$theatrebookingcode','$procedurenameid','$locationcode1', '$username','$ipaddress','$procedurenameanum')";
		        $postnewPname = mysqli_query($GLOBALS["___mysqli_ston"], $postnewPname) or die ("Error in postnewPname".mysqli_error($GLOBALS["___mysqli_ston"]));

			}
		}
		/*print_r($_REQUEST);
		exit();*/
        for ($i=1; $i < 30; $i++) { 
			# code...
			if(isset($_REQUEST['surgeon'.$i]) && $_REQUEST['surgeon'.$i]!=''){
			$surgeonId= $_REQUEST['surgeon'.$i];

		$posttonewDb="INSERT INTO `theatre_booking_surgeons`(`booking_id`, `surgeon_id`, `locationcode`, `username`, `ipaddress`) VALUES ('$theatrebookingcode','$surgeonId','$locationcode1', '$username','$ipaddress')";
		        $posttonewDb = mysqli_query($GLOBALS["___mysqli_ston"], $posttonewDb) or die ("Error in posttonewDb".mysqli_error($GLOBALS["___mysqli_ston"]));

			}
		}

        //$query_theatre_serv = "UPDATE master_theatre_procedures SET itemcode = '$service', patientcode='$patientcode' WHERE patientcode = '$patientcode_old' and theatrebookingcode = '$banum'";
        //echo $query_theatre_serv.'<br>';exit;
        //$exec_theatre_serv = mysql_query($query_theatre_serv) or die ("Error in query_serv_code".mysql_error());

        //print_r($equipments);echo '<br>';
        //equipments
        foreach ($equipments as $key => $value) {
        	$get_equip_code = "SELECT * FROM master_equipments WHERE itemname = '$value'";
        	//$query_equip = "INSERT INTO `master_theatre_equipments`(`itemcode`, `patientcode`, `patientvisitcode`, `theatrebookingcode`, `ipaddress`, `username`, `locationcode`, `locationname`, `date`) VALUES ('$value', '$patientcode','','$theatrebookingcode','$ipaddress','$username','$locationcode1','$locationname1','$dateAdded')";

        	//check if item is already in db
        	$query_eq_check = "SELECT * FROM master_theatre_equipments WHERE itemcode = '$value' AND patientcode = '$patientcode' AND theatrebookingcode = '$banum'";
            $exec_eq_check = mysqli_query($GLOBALS["___mysqli_ston"], $query_eq_check) or die ("Error in query_eq_check".mysqli_error($GLOBALS["___mysqli_ston"]));
            $check_rows_eq = mysqli_num_rows($exec_eq_check);

            //print_r($equipments); echo $value;exit;
            //echo $check_rows_eq;exit;

            if($check_rows_eq > 0){
            	// update
            	$query_equip = "UPDATE master_theatre_equipments SET itemcode = '$value' WHERE patientcode = '$patientcode' and theatrebookingcode = '$banum'";
        		//echo $query_equip;
        		$exec_equip = mysqli_query($GLOBALS["___mysqli_ston"], $query_equip) or die ("Error in query_equip".mysqli_error($GLOBALS["___mysqli_ston"]));
            }else{
            	// get loc code
            	$locationcode1 = 'LTC-1';
	            $locationname1 = '';
            	// insert
            	$query_equip = "INSERT INTO `master_theatre_equipments`(`itemcode`, `patientcode`, `patientvisitcode`, `theatrebookingcode`, `ipaddress`, `username`, `locationcode`, `locationname`, `date`) VALUES ('$value', '$patientcode','','$banum','$ipaddress','$username','$locationcode1','$locationname1','$dateAdded')";
            	
            	$exec_equip = mysqli_query($GLOBALS["___mysqli_ston"], $query_equip) or die ("Error in query_equip".mysqli_error($GLOBALS["___mysqli_ston"]));
            }

            

        } 
        //print_r($equipments);
        //echo $banum.'<br>';
        //echo $query_equip;exit;
		$bgcolorcode = 'Success';	
		$errmsg = "Theatre Booking Updated Successfully";

		header("Location: theatrebookinglist.php?st=success");	
	/*}*/

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
	

$registrationdate = date('Y-m-d');
$consultationdate = date('Y-m-d');
$consultationtime = date('H:i');

//if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }

if (isset($_REQUEST["id"])) { $booking_id = $_REQUEST["id"]; } else { $booking_id = ""; }

//$patientcode = 'MSS000000014';
if ($booking_id != '')
{    

	// get booking details
	$query3_0 = "select * from master_theatre_booking where auto_number = '$booking_id'";
	$exec3_0 = mysqli_query($GLOBALS["___mysqli_ston"], $query3_0) or die ("Error in Query3_0".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3_0 = mysqli_fetch_array($exec3_0);
	
	$patientcode = $res3_0['patientcode'];

	// other 
	$query3_01 = "select * from master_theatre_booking where auto_number = '$booking_id'";
	$exec3_01 = mysqli_query($GLOBALS["___mysqli_ston"], $query3_01) or die ("Error in Query3_0".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res3_01 = mysqli_fetch_array($exec3_01)){
		//
		$patientcode = $res3_01['patientcode'];
		$visitcode = $res3_01['patientvisitcode'];
		$procedure_type =$res3_01['proceduretype'];
		$theatre_code =$res3_01['theatrecode'];
		$category =$res3_01['category'];
		$speaciality =$res3_01['speaciality'];
		$surgerydatetime =$res3_01['surgerydatetime'];
		$estimatedtime =$res3_01['estimatedtime'];
		$surgeon =$res3_01['surgeon'];
		$anesthesia =$res3_01['anesthesia'];
		$anesthesiatype =$res3_01['anesthesiatype'];
		$ward = $res3_01['ward'];
		
		$assistant_surgeon = $res3_01['assistant_surgeon'];
		$anaesthetisit_note = $res3_01['anaesthetisit_note'];
		$doctor_note = $res3_01['doctor_note'];
		$patient_type = $res3_01['patient_type'];
	}

	$query3_012 = "select * from master_theatre_procedures where theatrebookingcode = '$booking_id'";
	//echo $query3_012;exit;
	$exec3_012 = mysqli_query($GLOBALS["___mysqli_ston"], $query3_012) or die ("Error in Query3_012".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res3_012 = mysqli_fetch_array($exec3_012)){
		//
		$procedure_id = $res3_012['itemcode'];

		$query3_013 = "select * from master_theatrespeaciality_subtype WHERE auto_number  = '$procedure_id'";
		$exec3_013 = mysqli_query($GLOBALS["___mysqli_ston"], $query3_013) or die ("Error in Query3_013".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res3_013 = mysqli_fetch_array($exec3_013);
		$procedure = $res3_013['speaciality_subtype_name'];


	
	}

	
	//echo 'Inside Patient Code Condition.';
	
	
	$query3 = "select * from master_customer where customercode = '$patientcode'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	
	$patientfirstname = $res3['customername'];
	$patientfirstname = strtoupper($patientfirstname);

	$patientmiddlename = $res3['customermiddlename'];
	$patientmiddlename = strtoupper($patientmiddlename);

	$patientlastname = $res3['customerlastname'];
	$patientlastname = strtoupper($patientlastname);
	
	$patientfullname = $res3['customerfullname'];
	$patientfullname = strtoupper($patientfullname);

    $paymenttype1 = $res3['paymenttype'];
	
	$paymenttype = $res3['paymenttype'];
	
	$mrdno = $res3['mrdno'];
	$memberno = $res3['memberno'];
	$photoavailable = $res3['photoavailable'];
	
	$res11locationcode=$res3['locationcode'];
	$patientspent=$res3['opdue'];
	
	$query4 = "select * from master_paymenttype where auto_number = '$paymenttype'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$paymenttypeanum = $res4['auto_number'];
	$paymenttype = $res4['paymenttype'];
	
	$subtype = $res3['subtype'];
	$query4 = "select * from master_location where auto_number = '$subtype'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	 
	//$subtype = $res4['subtype'];

	$billtype = $res3['billtype'];
	$age = $res3['age'];
	$dateofbirth = $res3["dateofbirth"];
	$todate = date("Y-m-d");
	$diff = abs(strtotime($todate) - strtotime($dateofbirth));
	
	$years = floor($diff / (365*60*60*24));
	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	if($years == 0 && $months == 0)
	{
	$age = $days.' '.'Days';
	}
	if($years == 0 && $months != 0)
	{
	$age = $months.' '.'Months';
	}
	else 
	{
	$age = $years.' '.'Years';
	}
	$gender = $res3['gender'];
	
	//get subtype name
	$query24 = "select subtype,auto_number from master_subtype where auto_number = '$subtype'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	 $subtype = $res4['subtype'];
	 $subtypeanum = $res4['auto_number'];
	 $is_savannah='';
	 //end of get subtype name
	
	$accountname = $res3['accountname'];
	
	$query4 = "select * from master_accountname where auto_number = '$accountname'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$accountnameanum = $res4['auto_number'];
	$accountname = $res4['accountname'];

	$accountexpirydate = $res3['accountexpirydate'];	
	 $planname = $res3['planname'];
	
}

//$consultationfees = '500';

if (isset($_REQUEST["errorcode"])) { $errorcode = $_REQUEST["errorcode"]; } else { $errorcode = ""; }

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
<script type="text/javascript" src="js/insertnewprocedure.js"></script>
<script type="text/javascript" src="js/insertNewSurgeon.js"></script>
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
	
	var anesthesia = document.getElementById("anesthesia").value;
	if(anesthesia.length < 1)
	{
		alert("Please select Anesthesia");
		 document.getElementById("anaesthesia_name").focus();
			return false;
	}

	var speaciality = document.getElementById("speaciality").value;
	if(speaciality.length < 1)
	{
		alert("Please select speaciality");
		 document.getElementById("speaciality").focus();
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
	
	var theatre = document.getElementById("theatre").value;
	if(theatre.length < 1)
	{
		alert("Please select theatre");
		 document.getElementById("theatre").focus();
			return false;
	}

	var estimatedtime = document.getElementById("estimatedtime").value;
	if(estimatedtime.length < 1)
	{
		alert("Please select estimated time");
		 document.getElementById("estimatedtime").focus();
			return false;
	}


	var check = document.getElementsById("serv").value;                  
	if(check.length < 1)
	{
	    alert("Please select service procedure");
		 document.getElementById("serv").focus();
			return false;
	}

	var check1 = document.getElementsByName("equip[]");                  //here status
	if(check1.length == 0)
	{
	    alert("Please select equipments");
		 document.getElementById("equipment").focus();
			return false;
	}

	var result = confirm("Do you want to Save?");
	if (result) {
	    return true;
	}

}



function funcOnLoadBodyFunctionCall()
{ 
	//alert ("Inside Body On Load Fucntion.");
	
}

$(function() {
	
$('#customer').autocomplete({
		
	source:'ajaxcustomernewserach.php', 
	//alert(source);
	minLength:3,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var code = ui.item.id;
			var customercode = ui.item.customercode;
			var accountname = ui.item.accountname;
			$('#customercode').val(customercode);
			$('#accountnamename').val(accountname);
			$('#patientcode').val(customercode);
			
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
                url:"check_theatre_time1.php",
                type:"post",
                data:{theatre:vartheatre, date:varsurgerydate, time:varestimatetime, pcode: varpatientcode },
                success:function(response)
                {   
                	console.log(response);                	
                	if(response == 'Pending'){
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


 
 var now = new Date().toLocaleTimeString();;

$(document).ready(function(){
    jQuery('#surgerydate').datetimepicker({
    	step: 30,
    	minDate: new Date(),
    	//minTime: now,
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
    <td colspan="10" bgcolor="#ecf0f5">
	<?php 
	
		include ("includes/menu1.php"); 
	
	
	?>	</td>
  </tr>
  <tr>
  <td colspan="10" bgcolor="#ecf0f5">
    <form name="form1" id="form1" method="post" action="theatrebookingedit.php" onKeyDown="return disableEnterKey(event)" onSubmit="return process1()">
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
						  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Patient Search </td>
						  <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5">
							  <input type="hidden" name="photoavailable" id="photoavailable" size="10" autocomplete="off" value="<?php echo $photoavailable; ?>">
							  <input name="customer" id="customer" value="" size="60" autocomplete="off" readonly>
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
								 &nbsp;
								 &nbsp;
								 <input name="patientmiddlename" id="patientmiddlename" value="<?php echo $patientmiddlename; ?>" readonly size="22" />
							</td>
							
							<td align="left" valign="middle"  bgcolor="#ecf0f5">
								<input name="patientlastname" id="patientlastname" value="<?php echo $patientlastname; ?>" readonly size="30" />
							</td>
							<td align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Age</td>
				  			<td align="left" valign="middle"  bgcolor="#ecf0f5">
				  				<input type="text" name="age" id="age" value="<?php echo $age; ?>" readonly>
				  			</td>
						</tr>
						<tr>
							<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Patient Reg ID </td>
							<td align="left" valign="middle"  bgcolor="#ecf0f5">
								<input name="patientcode" id="patientcode" size="20" value="<?php echo $patientcode; ?>" readonly/>
								<input name="visitcode" id="visitcode" size="20" value="<?php echo $visitcode; ?>" readonly/>
								<input name="patientcode_old" id="patientcode_old" type="hidden" size="30" value="<?php echo $patientcode; ?>" readonly/>
							</td>
							<td align="right" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Registration Date </span></td>
							<td align="left" valign="middle"  bgcolor="#ecf0f5">
								<input type="text" name="registrationdate" id="registrationdate" size="30" value="<?php echo $consultationdate; ?>" >
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
						    	 <input type="text" name="accountnamename" id="accountnamename"  size="30" value="<?php echo $accountname;?>"  readonly="readonly" style="">
						   		 <input type="hidden" name="accountname" id="accountname"  value="<?php echo $accountnameanum;?>"  readonly="readonly"  style="border: 1px solid #001E6A;"></td>
						    <td align="right" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32"><!--Ward--></span></td>
							<td align="left" valign="middle"  bgcolor="#ecf0f5">
	                     		<!--<select name="ward" id="ward" style="border: 1px solid #001E6A;">
							  		<option value="">Select Ward</option>-->
							  		<?php
							  		 $query_th_1 = "SELECT * FROM master_ward ORDER BY auto_number ASC";
							  		 $exec_th_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_th_1) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
									 while ($res_th_1 = mysqli_fetch_array($exec_th_1))
									 {
									 	$auto_number = $res_th_1['auto_number'];
									 	$ward_name = $res_th_1['ward'];

							  		?>
							  			<!--<option value="<?php echo $auto_number;?>" <?php if($ward == $auto_number){ echo "selected"; }?> ><?php echo $ward_name;?></option>-->
							  	    <?php } ?>
									<input type='hidden' name="ward" id="ward" value='<?php echo $auto_number;?>'>
							  	<!--</select>-->
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
							<td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Procedure Type</span></td>
							<td align="left" valign="middle"  bgcolor="#ecf0f5">
							  	<select name="proceduretype" id="proceduretype" style="border: 1px solid #001E6A;">
							  		<option value="">Select Procedure</option>
							  		<option value="emergency" <?php if($procedure_type == 'emergency'){ echo "selected";}?> >Emergency</option>
							  		<option value="elective" <?php if($procedure_type == 'elective'){ echo "selected";}?> >Elective</option>
							  	</select>
							</td>
							<td align="right" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32"><font color='red'>Category</font></span></td>
							<td align="left" valign="middle"  bgcolor="#ecf0f5">
							  	<select name="category" id="category" style="border: 1px solid #001E6A;">
							  		<option value="">Select Category</option>
							  		<option value="major" <?php if($category == 'major'){ echo "selected";}?>>Major</option>
							  		<option value="minor" <?php if($category == 'minor'){ echo "selected";}?> >Minor</option>
							  	</select>
							</td>
							<td align="right"  valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32"><1--Patient Type--></span></td>
							<td align="left" valign="middle"  bgcolor="#ecf0f5">
							  <!--	<select name="patient_type" id="patient_type" style="border: 1px solid #001E6A;">
							  		<option value="">Select Type</option>
							  		<option value="New" <?php if($patient_type == 'New'){ echo "selected";}?>>New</option>
							  		<option value="Active IP" <?php if($patient_type == 'Active IP'){ echo "selected";}?>>Active IP</option>
							  	</select>-->
								<input type='hidden' name="patient_type" id="patient_type" value=''>
							</td>
						</tr>
						
						
						<tr>
						<td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Surgeon</span></td>
						<td width="30%">
							
							<input type="hidden" name="serialnumber" id="serialnumber" value="1">
							<input type="hidden" name="auto_id" id="auto_id" value="0"/>
							<input type="text" name="surgeon_name[]" size="32" id="surgeon_name" autocomplete="off">
							<input type="hidden" name="surgeon" id="surgeon" autocomplete="off">
							<input type="button" name="addSurgeon" id="addSurgeon" onClick="return insertNewSurgeon()" value="Add" class="button" style="border: 1px solid #001E6A">
							<table>
                      <?php 
						$query_surg_doc = "select * from theatre_booking_surgeons WHERE booking_id  = '$booking_id'";
						$exec_surg_doc = mysqli_query($GLOBALS["___mysqli_ston"], $query_surg_doc) or die ("Error in query_surg_doc".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($res_surg_doc = mysqli_fetch_array($exec_surg_doc)){
						$surg_id = $res_surg_doc['surgeon_id'];
                        $idtodel= $res_surg_doc['auto_number'];
						$query_t = "SELECT * FROM master_doctor WHERE doctorcode= '$surg_id'";
				        $exec_t = mysqli_query($GLOBALS["___mysqli_ston"], $query_t) or die ("Error in Query_s".mysqli_error($GLOBALS["___mysqli_ston"]));
				        while ($res_t = mysqli_fetch_assoc($exec_t))
				        {  
					    $newdoctorname=$res_t['doctorname'];
				        } 
				
				?>
				<tr>
					<td width="300" style="border: 0px solid #001E6A; background-color: #FFFFFF; text-align: left;"> <div >
						<?php echo  $newdoctorname;?>		
       <span class="action" id="divid"><a href="#" id="<?php echo $idtodel; ?>" class="delete" title="Delete" style="color:red;">&nbsp;X</a></span>
                   </div> </td>
				</tr>
								

							<?php } ?>
							</table>
							<!-- insert -->
							<table id="insertrow">
										
							</table>
							<!--/insert-->
						</td>
						<td align="right" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Anaesthetist</span></td>
						<td align="left" valign="middle"  bgcolor="#ecf0f5">
						
						<?php
								    $docname1 = '';
									$doccode1='';
									 $query_sg_1 = "
								  		 SELECT doctorcode, doctorname FROM master_doctor 
								  		 WHERE doctorcode = '$anesthesia' AND status <> 'deleted' AND doctorname <> '' ";
								  		 //
								  		 $exec_sg_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_sg_1) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
										 while ($res_sg_1 = mysqli_fetch_array($exec_sg_1))
										 {
											$doccode1 = $res_sg_1["doctorcode"]; 
											$docname1 = $res_sg_1["doctorname"];
											//$doctitle = $res_sg_1["doctorname"]; 
										 }
								?>
						
						
							<input type="text" name="anaesthesia_name" size="35" id="anaesthesia_name" autocomplete="off" value="<?php echo $docname1; ?>">
							<input type="hidden" name="anesthesia" id="anesthesia" autocomplete="off" value="<?php echo $doccode1; ?>">
						</td>
					
							
							<td align="right" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Anaesthesia Type</span></td>
							<td align="left" valign="middle"  bgcolor="#ecf0f5">
								<select name="anesthesiatype" id="anesthesiatype" width="100" style="border: 1px solid #001E6A;">
							  		<option value="">Anaesthesia Type</option>
		                            <option value="General Anesthesia" <?php if($anesthesiatype == 'General Anesthesia'){ echo "selected"; } ?> >General Anesthesia</option>
		                            <option value="Spinal Anesthesia" <?php if($anesthesiatype == 'Spinal Anesthesia'){ echo "selected"; } ?> >Spinal Anesthesia </option>
		                            <option value="Sedation Anesthesia" <?php if($anesthesiatype == 'Sedation Anesthesia'){ echo "selected"; } ?> >Sedation Anesthesia</option>
		                            <option value="Regional Block Anesthesia" <?php if($anesthesiatype == 'Regional Block Anesthesia'){ echo "selected"; } ?> >Regional Block Anesthesia</option>
		                            <option value="Local Anesthesia" <?php if($anesthesiatype == 'Local Anesthesia'){ echo "selected"; } ?> >Local Anesthesia</option>
							  	</select>
							</td>
						</tr>
					

					<tr>
							<td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Theatre</span></td>
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
							  			<option value="<?php echo $auto_number;?>" <?php if($theatre_code == $auto_number){ echo "selected";}?> ><?php echo $theatre_name;?></option>
							  	    <?php } ?>
							  	</select>
							</td>
							<td align="right" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Surgery Date</span></td>
							<td align="left" valign="middle"  bgcolor="#ecf0f5">
								<?php
								  //$now = date('yyyy-mm-dd H:i:s');
								  $now = date('Y-m-d');
								  $b_str = strtotime($surgerydatetime);
								  $b_date = date('Y-m-d', $b_str);
								  //echo $b_date;exit;
								  if($now > $b_date){
								?>
								<input id="surgerydate" name="surgerydate" size="35" autocomplete="off" readonly type="text" value="" onChange="return cleartime()">
							<?php }else{?>
							  	<input id="surgerydate" name="surgerydate" size="35" autocomplete="off" readonly type="text" value="<?php echo $surgerydatetime; ?>" onChange="return cleartime()">
							 <?php } ?>
							</td>
							<td align="right" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Estimated Time</span></td>
						    <td align="left" valign="middle"  bgcolor="#ecf0f5">
						  		<input type="number" name="estimatedtime" id="estimatedtime"  placeholder="Minutes" value="<?php echo $estimatedtime; ?>" style="" onKeyUp="return checkTheatreTime()" >
						    </td>
						</tr>
						<tr>
							<input type="hidden" name="locationcode" id="locationcode" value="<?php echo $res11locationcode;?>">
							<input type="hidden" name="subtypeano" id="subtypeano">
							<input type="hidden" name="billtypes" id="billtypes">
							<input type="hidden" name="payment" id="payment">
							<input type="hidden" name="banum" id="banum" value="<?php echo $booking_id;?>">
						</tr>
						<tr>
							<td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Procedure</span></td>
							
							<td  align="left" valign="middle">									
								<input type="hidden" name="serialnumberProcedure" id="serialnumberProcedure" value="1">						
								<input type="hidden" name="auto_idProcedure" id="auto_idProcedure" value="0"/>
								<input type="text" name="procedure_name[]" size="25" id="serv" autocomplete="off">
								<input type="hidden" name="serv_procedure" id="procedure" autocomplete="off">
								<input type="button" name="addProcedure" id="addProcedure" onClick="return insertNewProcedure()" value="Add" class="button" style="border: 1px solid #001E6A">
								<table>
									<?php 

									//echo $speacialityname; 
						$query3_012 = "select * from theatre_booking_proceduretypes where booking_id = '$booking_id'";
						$exec3_012 = mysqli_query($GLOBALS["___mysqli_ston"], $query3_012) or die ("Error in Query3_012".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($res3_012 = mysqli_fetch_array($exec3_012)){
							$proceduretypename = $res3_012['proceduretype_id'];
							$idtodelp=$res3_012['auto_number'];
									?>
									<tr>
										<td width="300" style="border: 0px solid #001E6A; background-color: #FFFFFF; text-align: left;">
										 <?php echo  $proceduretypename;?>
		                    <span class="action"><a href="#" id="<?php echo $idtodelp; ?>" class="deletep" title="Delete" style="color:red;">&nbsp;X</a></span>
								       </td>

									</tr>
									<?php } ?>
								</table>

								<table id="insertrowProcedure"></table>

								
							</td>
							
							
							
							<td align="right" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Assistant surgeon</span></td>
						    <td align="left" valign="middle"  bgcolor="#ecf0f5">
						  		<input type="text" name="assistant_surgeon" size="35" id="assistant_surgeon" autocomplete="off" value="<?php echo $assistant_surgeon; ?>">
						    </td>	
							
							
							
							
	                    	<td align="right" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Side</span></td>
							<td align="left" valign="middle"  bgcolor="#ecf0f5">
								<?php
								$query_ss = "SELECT * FROM master_theatre_booking WHERE auto_number ='$booking_id' AND  recordstatus <> 'deleted' ORDER BY auto_number ASC";
										$exec_ss = mysqli_query($GLOBALS["___mysqli_ston"], $query_ss) or die ("Error in Query_ss".mysqli_error($GLOBALS["___mysqli_ston"]));
										//echo "<option value=''>Select Services</option>";
										while ($res_ss = mysqli_fetch_assoc($exec_ss))
										{  
											$s_side = $res_ss['side'];
											
										}
								?>
	                     		<select id="side" name="side" style="border: 1px solid #001E6A;width:250px;">
	                     			<option value="N/A" <?php if($s_side == 'N/A'){ echo "selected"; } ?> >N/A</option>
	                     			<option value="Left" <?php if($s_side == 'Left'){ echo "selected"; } ?>>LEFT</option>
	                     			<option value="Right" <?php if($s_side == 'Right'){ echo "selected"; } ?>>RIGHT</option>
	                     		</select>
	                     	</td>
	                    </tr>
	                    <tr>
	                    	<td>&nbsp;</td>
	                    </tr>
						<!--<tr>
							<td align="left" width="" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Anaesthetist Notes</span></td>
							<td><textarea rows="4" cols="40" name="anaesthetisit_note" id="anaesthetisit_note" ><?php echo $anaesthetisit_note; ?></textarea></td>
							<td align="right"  valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Doctor Notes</span></td>
							<td><textarea rows="4" cols="35" name="doctor_note" id="doctor_note" ><?php echo $doctor_note; ?></textarea></td>
						</tr>
						<tr>
	                    	<td>&nbsp;</td>
	                    </tr>-->
	                    <tr>
	                    	<td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Equipments</span></td>
							<td align="left" valign="middle"  bgcolor="#ecf0f5">
							   <select name="equipments[]" id='pre-selected-options' multiple='multiple'>
							   	  <?php 
							   	    // get equipments from masters
							   	     $query_equip= "SELECT * FROM master_equipments WHERE record_status <> 'deleted'";
										 $exec_equip= mysqli_query($GLOBALS["___mysqli_ston"], $query_equip) or die ("Error in Query_speac".mysqli_error($GLOBALS["___mysqli_ston"]));
										 while($res_equip = mysqli_fetch_array($exec_equip)){
											//
											$equip_id = $res_equip['auto_number'];
											$equip_name = $res_equip['equipment_name'];
											     $query2_ = "select * from master_theatre_equipments where theatrebookingcode='$booking_id' and patientcode='$patientcode' and itemcode = '$equip_id' order by auto_number desc";
								                 $exec2_ = mysqli_query($GLOBALS["___mysqli_ston"], $query2_) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
								                 while($res2_ = mysqli_fetch_array($exec2_))
								                 {
								                 	$equipment_id1= $res2_['itemcode'];
					                             }

					                              if ($equipment_id1 != '' ){$e_id = $equipment_id1;}else{$e_id = '';}
												   	  ?>
					                              }
					                              }
								  <option value='<?php echo $equip_id;?>' <?php if($e_id == $equip_id){echo "selected"; } ?> ><?php echo $equip_name;?></option>
								  <?php }?>
								</select>
							</td>
							
		                </tr>
						<input type='hidden'  name="anaesthetisit_note" id="anaesthetisit_note" value=''>
						<input type='hidden'  name="doctor_note" id="doctor_note" value=''>
		                <tr>
		                	<td>&nbsp;</td>
		                </tr>
		                <tr> 
		                	 <td>&nbsp;</td>
						
<?php

			$query2 = "select * from master_theatre_booking where auto_number='$booking_id' and approvalstatus='Pending'";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num2=mysqli_num_rows($exec2);
if($num2>0){
?>						
							 
		                	 <td>
		                	 	<input type="hidden" name="frmflag1" value="frmflag1" />
                 			 	<input name="Submit222" type="submit"  value="Update Theatre Booking" accesskey="s" class="button" id="submit"  onclick="return process1(); confirm('Save Theatre Booking?');" style="background-color: #4CAF50;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;"/>
                 			 </td>
							 
<?php } ?>							 
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
	
function deleteSurgeon(delid){


	 var delid = delid;

	 var fRet;

	fRet = confirm('Are you sure want to delete this surgeon '+delid+'?');

	//alert(fRet);

	if (fRet == true)

	{
        
        // prompt

		 /*var reason_value = prompt('Please enter reason for cancellation?');*/

		 /*if(reason_value == ''){
		 	// alert enter reason
		 	alert("Please provide reason for cancellation!");
		 	return false;
		 }*/
		//alert ("Theatre Booking Delete Completed.");

		/*booking_id = document.getElementById("b_id").value;*/
		//console.log(booking_id);
		// pass href
		window.location.href = "theatrebookingedit.php?anum="+delid+"&&st=del";

	}

	if (fRet == false)

	{

		alert ("Failed");

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
	
	/*
	var currenttotal2=document.getElementById('total2').value;
	var current=Number(currenttotal2.replace(/[^0-9\.]+/g,""));
	//alert(currenttotal);
	newtotal2= current-radrate;
	
	//alert(newtotal);
	
	document.getElementById('total2').value=formatMoney(newtotal2);
	if(document.getElementById('total').value=='')
	{
	totalamount11=0;
	}
	else
	{
	total11=document.getElementById('total').value;
	totalamount11=Number(total11.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total1').value=='')
	{
	totalamount21=0;
	}
	else
	{
	total21=document.getElementById('total1').value;
	totalamount21=Number(total21.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total3').value=='')
	{
	totalamount31=0;
	}
	else
	{
	total31=document.getElementById('total3').value;
	totalamount31=Number(total31.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total5').value=='')
	{
	totalamount41=0;
	}
	else
	{
	total41=document.getElementById('total5').value;
	totalamount41=Number(total41.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('totalr').value=='')
	{
	totalamountrr=0;
	}
	else
	{
	totalrr=document.getElementById('totalr').value;
	totalamountrr=Number(totalrr.replace(/[^0-9\.]+/g,""));
	}
	
    var newgrandtotal2=parseFloat(totalamount11)+parseFloat(totalamount21)+parseFloat(newtotal2)+parseFloat(totalamount31)+parseFloat(totalamount41)+parseFloat(totalamountrr);
	
	//alert(newgrandtotal4);
	
	document.getElementById('total4').value=formatMoney(newgrandtotal2);
	*/
	
	
	

	
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
	
	/*
	var currenttotal2=document.getElementById('total2').value;
	var current=Number(currenttotal2.replace(/[^0-9\.]+/g,""));
	//alert(currenttotal);
	newtotal2= current-radrate;
	
	//alert(newtotal);
	
	document.getElementById('total2').value=formatMoney(newtotal2);
	if(document.getElementById('total').value=='')
	{
	totalamount11=0;
	}
	else
	{
	total11=document.getElementById('total').value;
	totalamount11=Number(total11.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total1').value=='')
	{
	totalamount21=0;
	}
	else
	{
	total21=document.getElementById('total1').value;
	totalamount21=Number(total21.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total3').value=='')
	{
	totalamount31=0;
	}
	else
	{
	total31=document.getElementById('total3').value;
	totalamount31=Number(total31.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total5').value=='')
	{
	totalamount41=0;
	}
	else
	{
	total41=document.getElementById('total5').value;
	totalamount41=Number(total41.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('totalr').value=='')
	{
	totalamountrr=0;
	}
	else
	{
	totalrr=document.getElementById('totalr').value;
	totalamountrr=Number(totalrr.replace(/[^0-9\.]+/g,""));
	}
	
    var newgrandtotal2=parseFloat(totalamount11)+parseFloat(totalamount21)+parseFloat(newtotal2)+parseFloat(totalamount31)+parseFloat(totalamount41)+parseFloat(totalamountrr);
	
	//alert(newgrandtotal4);
	
	document.getElementById('total4').value=formatMoney(newgrandtotal2);
	*/
	
	
	

	
}

</script>
<script type="text/javascript">

	/*function deleteSurgeon(){


		alert(are you sure you sure . '?');


	}*/
	/*//document.getElementById("serv").style.display="none";
	document.getElementById("serv_init").setAttribute('name', 'service_procedure');
	document.getElementById("serv").setAttribute('name', 'service_procedure_null');
*/
	// sepaciality tie
	/*$(document).ready(function()
        {
            $("#speaciality").change(function()
            {   
            	document.getElementById("serv_init").value="";
            	document.getElementById("serv_init").style.display="none";
            	document.getElementById("serv").style.display="block";
            	document.getElementById("serv").setAttribute('name', 'service_procedure');
            	document.getElementById("serv_init").setAttribute('name', 'service_procedure_init');
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
	// instantiate
	$('#pre-selected-options').multiSelect({
		  selectableHeader: "<div class='custom-header'>Equipments</div>",
		  selectionHeader: "<div class='custom-header'>Selected Equipments</div>",
	});
	/*document.getElementById("serv").disabled = true;*/
	// self executing function here
	


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


    $(function() {
$(".delete").click(function(){
//alert("delete");
var element = $(this);
var del_id = element.attr("id");
var info = 'id=' + del_id;
if(confirm("Are you sure you want to delete this?"))
{
 $.ajax({
   type: "POST",
   url: "deletesurgeon.php",
   data: info,
   success: function(){
var idf=document.getElementById('banum').value;

  window.location.href= "theatrebookingedit.php?id="+idf;
    
 }
});
  $(this).parents(".show").animate({ backgroundColor: "blue" }, "slow")
  .animate({ opacity: "hide" }, "slow");
 }
return false;
});
});



    $(function() {
$(".deletep").click(function(){
var element = $(this);
var del_id = element.attr("id");
var info = 'id=' + del_id;
if(confirm("Are you sure you want to delete this procedure?"+ info))
{
 $.ajax({
   type: "POST",
   url: "deleteprocedure.php",
   data: info,
   success: function(){
var idf=document.getElementById('banum').value;

  window.location.href= "theatrebookingedit.php?id="+idf;
    
 }
});
  $(this).parents(".show").animate({ backgroundColor: "blue" }, "slow")
  .animate({ opacity: "hide" }, "slow");
 }
return false;
});
});
</script>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
