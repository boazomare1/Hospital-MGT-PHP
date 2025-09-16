<?php
session_start();
include ("includes/loginverify.php");
include ("includes/check_user_access.php");
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");

// Initialize variables
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$pagename = "";
$docno = $_SESSION['docno'];
$username = $_SESSION["username"];
$query = "select * from master_location where  status <> 'deleted' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
	
$locationname  = $res["locationname"];
$locationcode = $res["locationcode"];
$res12locationanum = $res["auto_number"];
	 
// Handle location parameters
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
if($location != '') {
    $locationcode = $location;
}

// Handle form parameters with modern isset() checks
$searchdoctor = isset($_REQUEST["searchdoctor"]) ? $_REQUEST["searchdoctor"] : "";
$frmflag1 = isset($_REQUEST["frmflag1"]) ? $_REQUEST["frmflag1"] : "";

// Pagination parameters
$page = isset($_REQUEST["page"]) ? (int)$_REQUEST["page"] : 1;
$records_per_page = 5;
$offset = ($page - 1) * $records_per_page;
if ($frmflag1 == 'frmflag1')
{
	$doctorcode=$_REQUEST["doctorcode"];
	$locationcode =$_REQUEST['location'];
	$query = "select * from master_location where locationcode = '$locationcode'";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res = mysqli_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 
	$doctorname = $_REQUEST["doctorname"];
	$doctorname = strtoupper($doctorname);
	$doctorname = trim($doctorname);
	$typeofdoctor=$_REQUEST["typeofdoctor"];
	$address1=$_REQUEST["address1"];
	$address2=$_REQUEST["address2"];
	$area = $_REQUEST["area"];
	$city  = $_REQUEST["city"];
	$state  = $_REQUEST["state"];
	$pincode = $_REQUEST["pincode"];
	$country = $_REQUEST["country"];
	$phonenumber1 = $_REQUEST["phonenumber1"];
	$phonenumber2 = $_REQUEST["phonenumber2"];
	$emailid1  = $_REQUEST["emailid1"];
	$emailid2 = $_REQUEST["emailid2"];
	$faxnumber = $_REQUEST["faxnumber"];
	$mobilenumber  = $_REQUEST["mobilenumber"];
	$remarks=$_REQUEST["remarks"];
	$tinnumber=$_REQUEST["tinnumber"];
	$cstnumber=$_REQUEST["cstnumber"];
	$ipdoctor=$_REQUEST["ipdoctor"];
	$isstaff = 0;
	if(isset($_REQUEST["isstaff"]))
	{
		$isstaff = $_REQUEST["isstaff"];
	}

	if(isset($_REQUEST["ipresdoctor"]))
	{
		$ipresdoctor = $_REQUEST["ipresdoctor"];
		$resdoclimit = $_REQUEST["resdoclimit"];
		$resdoclimitext = $_REQUEST["resdoclimitext"];
		$resdocshar = $_REQUEST["resdocshar"];
		$resdocsharext = $_REQUEST["resdocsharext"];
	}else{

       $ipresdoctor = 0;
	   $resdoclimit = 0;
		$resdoclimitext = 0;
		$resdocshar = 0;
		$resdocsharext = 0;

	}

	$excludeallocation=isset($_REQUEST['excludeallocation'])?$_REQUEST['excludeallocation']:'0';
	$openingbalance = $_REQUEST["openingbalance"];
	$department = $_REQUEST["department"];
	$consultationfees = $_REQUEST["consultationfees"];
	$hospitalfees = $_REQUEST['hospitalfees'];
	$doctorfees = $_REQUEST['doctorfees'];
	$consultationperc = $_REQUEST['consultationpercentage'];
	$ipserperc = $_REQUEST['ipserpercentage'];
	$pvtdrperc = $_REQUEST['pvtdrpercentage'];
	$max_appt = $_REQUEST['max_appt'];

	$ippvtdrperc = $_REQUEST['ippvtdrpercentage'];
	$pvtconsultationperc = $_REQUEST['pvtconsultationpercentage'];
	
	$resdoccharge = isset($_REQUEST["resdoccharge"])?$_REQUEST["resdoccharge"]:'';
	$pridoccharge = isset($_REQUEST["pridoccharge"])?$_REQUEST["pridoccharge"]:'';
		
	$query2 = "select * from master_doctor where doctorcode = '$doctorcode' AND locationcode = '".$locationcode."'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 == 0)
	{
		$query1 = "INSERT into master_doctor (doctorcode,doctorname,typeofdoctor,address1,address2,
		area,city,state,country,pincode,phonenumber1,phonenumber2,faxnumber,mobilenumber,emailid1, emailid2,
		remarks, status, tinnumber, cstnumber, openingbalance, department, consultationfees, ipdoctor,locationcode,locationname,resdoc_charge,pridoc_charge,hospitalfees,doctorfees, consultation_percentage, ipservice_percentage, pvtdr_percentage,is_staff,max_appt,excludeallocation,op_consultation_private_sharing,ip_consultation_private_sharing,is_resdoc,resdoc_limit,res_limit_ext,res_start_per,res_per_ext,username) 
		values('$doctorcode','$doctorname','$typeofdoctor','$address1','$address2','$area','$city',
		'$state','$country','$pincode','$phonenumber1','$phonenumber2','$faxnumber','$mobilenumber','$emailid1',
		'$emailid2','$remarks','$status', '$tinnumber', '$cstnumber', '$openingbalance', '$department', '$consultationfees', '$ipdoctor','".$locationcode."','".$locationname."','".$resdoccharge."','".$pridoccharge."','$hospitalfees','$doctorfees', '$consultationperc', '$ipserperc','$pvtdrperc','$isstaff','$max_appt','$excludeallocation','$pvtconsultationperc','$ippvtdrperc','$ipresdoctor','$resdoclimit','$resdoclimitext','$resdocshar','$resdocsharext','$username')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$doctor_ins_id = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
		if($doctor_ins_id)
		{
			if(!empty($_POST['weekday'])){
				
				foreach($_POST['weekday'] as $weekdayid){
					//echo $weekdayid."</br>";
					$inser_qry = "INSERT INTO `doctor_weekdays` (`id`, `doctor_code`, `weekday_id`, `created_on`, `updated_on`) VALUES (NULL, '".$doctorcode."', $weekdayid, CURRENT_TIMESTAMP, '".$updatedatetime."'); ";
					
					$exec_weekdays = mysqli_query($GLOBALS["___mysqli_ston"], $inser_qry) or die ("Error in Insert Doctor Weekdays Query".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		}
		
		
		foreach($_REQUEST['employee'] as $key => $value)
		{
		$employeename= $_REQUEST['employee'][$key];
		$employeecode= $_REQUEST['employeecode'][$key];
		$docusername= $_REQUEST['docusername'][$key];
		$employeename = addslashes($employeename);
	$employeecode = addslashes($employeecode);
	$docusername = addslashes($docusername);
		if($docusername !='')
		{
		$query11 = "insert into doctor_mapping (doctorname,doctorcode,employeename,employeecode,docusername,ipaddress,created_at,locationcode,locationname)
		values('$doctorname','$doctorcode','$employeename','$employeecode','$docusername','$ipaddress','$updatedatetime','$locationcode','$locationname')";
		$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		}
		
		$companyname = '';
		$title1  = '';
		$title2  = '';
		$contactperson1  = '';
		$contactperson2 = '';
		$designation1 = '';
		$designation2  = '';
		$phonenumber1 = '';
		$phonenumber2 = '';
		$emailid1  = '';
		$emailid2 = '';
		$faxnumber1 = '';
		$faxnumber2  = '';
		$address = '';
		$location = '';
		$city  = '';
		$state = '';
		$pincode = '';
		$country = '';
		$tinnumber = '';
		$cstnumber = '';
		$companystatus  = '';
		$openingbalance = '0.00';
		$consultationpercentage = '0.00';
		$dateposted = $updatedatetime;
		$department = '';
		$consultationfees = '';
		
		header("location:adddoctor1.php?st=success");
		//header ("location:addcompany1.php?st=success&&cpynum=1");
	}
	else
	{
		header ("location:adddoctor1.php?st=failed");
	}
}
else
{
	$companyname = "";
	$title1  = "";
	$title2  = "";
	$contactperson1  = "";
	$contactperson2 = "";
	$designation1 = "";
	$designation2  = "";
	$phonenumber1 = "";
	$phonenumber2 = "";
	$emailid1  = "";
	$emailid2 = "";
	$faxnumber1 = "";
	$faxnumber2  = "";
	$address1 = "";
	$address2 = "";
	$location = "";
	$city  = "";
	$pincode = "";
	$country = "";
	$state = "";
	$tinnumber = "";
	$cstnumber = "";
	$companystatus  = "";
	$openingbalance = "";
	$consultationpercentage = "";
	$department = '';
	$consultationfees = '';
	
	$dateposted = $updatedatetime;
}
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'success')
{
		$errmsg = "Success. New Doctor Updated.";
		if (isset($_REQUEST["cpynum"])) { $cpynum = $_REQUEST["cpynum"]; } else { $cpynum = ""; }
		if ($cpynum == 1) //for first company.
		{
			$errmsg = "Success. New Doctor Updated.";
		}
}
else if ($st == 'failed')
{
		$errmsg = "Failed. Doctor Already Exists.";
}
if (isset($_REQUEST["cpycount"])) { $cpycount = $_REQUEST["cpycount"]; } else { $cpycount = ""; }
if ($cpycount == 'firstcompany')
{
	$errmsg = "Welcome. You Need To Add Your Company Details Before Proceeding.";
}
$query2 = "select * from master_doctor order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$res2doctorcode = $res2["doctorcode"];
if ($res2doctorcode == '')
{
	$doctorcode = 'DTC00000001';
	$openingbalance = '0.00';
	$consultationpercentage = '0.00';
	$ipserpercentage = '0.00';
	$pvtdrpercentage = '0.00';
}
else
{
	$res2doctorcode = $res2["doctorcode"];
	$doctorcode = substr($res2doctorcode, 3, 8);
	$doctorcode = intval($doctorcode);
	$doctorcode = $doctorcode + 1;
	$maxanum = $doctorcode;
	if (strlen($maxanum) == 1)
	{
		$maxanum1 = '0000000'.$maxanum;
	}
	else if (strlen($maxanum) == 2)
	{
		$maxanum1 = '000000'.$maxanum;
	}
	else if (strlen($maxanum) == 3)
	{
		$maxanum1 = '00000'.$maxanum;
	}
	else if (strlen($maxanum) == 4)
	{
		$maxanum1 = '0000'.$maxanum;
	}
	else if (strlen($maxanum) == 5)
	{
		$maxanum1 = '000'.$maxanum;
	}
	else if (strlen($maxanum) == 6)
	{
		$maxanum1 = '00'.$maxanum;
	}
	else if (strlen($maxanum) == 7)
	{
		$maxanum1 = '0'.$maxanum;
	}
	else if (strlen($maxanum) == 8)
	{
		$maxanum1 = $maxanum;
	}
	
	$doctorcode = 'DTC'.$maxanum1;
	$openingbalance = '0.00';
	$consultationpercentage = '0.00';
	$ipserpercentage = '0.00';
	$pvtdrpercentage = '0.00';
	//echo $companycode;
}
if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add Doctor To Proceed For Billing.";
	$bgcolorcode = 'failed';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Doctor - MedStar Hospital Management</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/vat-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Additional CSS -->
    <link href="css/autocomplete.css" rel="stylesheet"/>
    <link href="js/jquery-ui.css" rel="stylesheet">
    
    <style>
        th {
            background-color: #ffffff;
            position: sticky;
            top: 0;
            z-index: 1;
        }
        .ui-menu .ui-menu-item {
            zoom: 1 !important;
        }
        .bodytext31:hover { font-size:14px; }
    </style>
</head>
<body>
    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Advanced Healthcare Management Platform</p>
    </header>

    <!-- User Information Bar -->
    <div class="user-info-bar">
        <div class="user-welcome">
            <span class="welcome-text">Welcome, <strong><?php echo htmlspecialchars($username); ?></strong></span>
            <span class="location-info">📍 Company: <?php echo htmlspecialchars($companyname); ?></span>
        </div>
        <div class="user-actions">
            <a href="mainmenu1.php" class="btn btn-outline">🏠 Main Menu</a>
            <a href="logout.php" class="btn btn-outline">🚪 Logout</a>
        </div>
    </div>

    <!-- Navigation Breadcrumb -->
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Home</a>
        <span>→</span>
        <span>Master Data</span>
        <span>→</span>
        <span>Add Doctor</span>
    </nav>

    <!-- Floating Menu Toggle -->
    <div id="menuToggle" class="floating-menu-toggle">
        <i class="fas fa-bars"></i>
    </div>

    <!-- Main Container with Sidebar -->
    <div class="main-container-with-sidebar">
        <!-- Left Sidebar -->
        <aside id="leftSidebar" class="left-sidebar">
            <div class="sidebar-header">
                <h3>Quick Navigation</h3>
                <button id="sidebarToggle" class="sidebar-toggle">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            
            <nav class="sidebar-nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="mainmenu1.php" class="nav-link">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="masterdata.php" class="nav-link">
                            <i class="fas fa-database"></i>
                            <span>Master Data</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="adddoctor1.php" class="nav-link">
                            <i class="fas fa-user-md"></i>
                            <span>Add Doctor</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="doctorlist.php" class="nav-link">
                            <i class="fas fa-list"></i>
                            <span>Doctor List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billing.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>Billing</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="reports.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Reports</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer">
                <?php include ("includes/alertmessages1.php"); ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Add Doctor</h2>
                    <p>Add new doctors to the hospital management system with comprehensive details and settings.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="resetForm()">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                </div>
            </div>

    <script type="text/javascript" src="js/disablebackenterkey.js"></script>
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
					
//ajax to get location which is selected ends here
function functionaddemp()
{
	employeename=$('#employee').val();
	employeecode=$('#employeecode').val();
	docusername=$('#docusername').val();
	if(employeecode == '' || docusername=='')
	{
		alert('Select a Proper User');
	}
	else{
		varHTML = '<tr id="'+employeecode+'"><td><input type="text" name="employee[]" readonly value="'+employeename+'"></td><td><input type="text" name="employeecode[]" readonly value="'+employeecode+'"></td><td><input type="text" name="docusername[]" readonly value="'+docusername+'"></td><td><input type="button" onclick="'+"delemp('"+employeecode+"')"+'" readonly value="Del"></td></tr>';
		$('#emptbody').append(varHTML);
		$('#employee').val('');
		$('#employeecode').val('');
		$('#docusername').val('');
	}
	
}	
function delemp(el)
{
	$('#'+el+'').remove();
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
function onloadfunction1()
{
	document.form1.doctorname.focus();	
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
-->
</style>
<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="js/jquery-ui.js" type="text/javascript"></script>
<link href="js/jquery-ui.css" rel="stylesheet">
<link href="css/autocomplete.css" rel="stylesheet"/>
</head>
<script language="javascript">
$(function() {
	
$('#employee').autocomplete({
	source:'ajaxemployeesearch.php', 
	//alert(source);
	delay: 0,
	html: true, 
		select: function(event,ui){
			var docusername = ui.item.docusername;
			var employeecode = ui.item.employeecode;
			$('#employee').val(ui.item.value);
			$('#employeecode').val(employeecode);
			$('#docusername').val(docusername);
			},
    }).keydown(function(){
		$('#employeecode').val('');
			$('#docusername').val('');
		
	});
	
		$('#doctorname').autocomplete({
		source:'search_doctor.php', 
		//alert(source);
		delay: 0,
		html: true, 
		select: function(event,ui){
		$('#doctorcode').val(ui.item.id);
		},
		}).keydown(function(){
		$('#doctorcode').val(ui.item.id);
		});
		
		$('#searchdoctor').autocomplete({
		source:'get_doctor.php', 
		delay: 0,
		html: true, 
		select: function(event,ui){
		$('#searchdoctor').val(ui.item.accountname);
		},
		});
});
function process1()
{
	if (document.form1.doctorcode.value == "")
	{
		alert ("Doctor Code Cannot Be Empty.");
		document.form1.doctorcode.focus();
		return false;
	}
	if (document.form1.doctorname.value == "")
	{
		alert ("Doctor Name Cannot Be Empty.");
		document.form1.doctorname.focus();
		return false;
	}
/*	else if (document.form1.address1.value == "")
	{
		alert ("Address1  Cannot Be Empty.");
		document.form1.address1.focus();
		return false;
	}
*/
/*
	else if (document.form1.state.value == "")
	{
		alert ("State Cannot Be Empty.");
		document.form1.state.focus();
		return false;
	}
	else if (document.form1.city.value == "")
	{
		alert ("City Cannot Be Empty.");
		document.form1.city.focus();
		return false;
	}
*/
/*
	else if (isNaN(document.getElementById("pincode").value))
	{
		alert ("Pincode Can Only Be Numbers");
		return false;
	}
	else if (document.form1.emailid1.value != "")
	{
		if (document.form1.emailid1.value.indexOf('@')<= 0 || document.form1.emailid1.value.indexOf('.')<= 0)
		{
			window.alert ("Please Enter valid Mail Id");
			document.form1.emailid1.value = "";
			document.form1.emailid1.focus();
			return false;
		}
	}
	else if (document.form1.emailid2.value != "")
	{
		if (document.form1.emailid2.value.indexOf('@')<= 0 || document.form1.emailid2.value.indexOf('.')<= 0)
		{
			window.alert ("Please Enter valid Mail Id");
			document.form1.emailid2.value = "";
			document.form1.emailid2.focus();
			return false;
		}
	}
*/
/*
	if (document.form1.openingbalance.value == "")
	{
		alert ("Opening Balance Cannot Be Empty.");
		document.form1.openingbalance.value = "0.00";
		document.form1.openingbalance.focus();
		return false;
	}
	if (isNaN(document.form1.openingbalance.value))
	{
		alert ("Opening Balance Can Only Be Numbers.");
		document.form1.openingbalance.focus();
		return false;
	}
*/
	/*if (document.form1.consultationfees.value == "")
	{
		alert ("Consultation Fees Cannot Be Empty.");
		document.form1.consultationfees.value = "0.00";
		document.form1.consultationfees.focus();
		return false;
	}
	if (isNaN(document.form1.consultationfees.value))
	{
		alert ("Consultation Fees Can Only Be Numbers.");
		document.form1.consultationfees.focus();
		return false;
	} */
	if (document.form1.department.value == "")
	{
		alert ("Department Cannot Be Empty.");
		document.form1.department.value = "0.00";
		document.form1.department.focus();
		return false;
	}

	/*if(document.getElementById("ipresdoctor").checked==true)
    {
		 if (document.form1.resdoclimit.value == "")
		{
			alert ("Resident Doctor Limit Cannot Be Empty.");
			document.form1.resdoclimit.value = "0.00";
			document.form1.resdoclimit.focus();
			return false;
		}
		 if (document.form1.resdoclimitext.value == "")
		{
			alert ("Resident Doctor Limit Ext. Cannot Be Empty.");
			document.form1.resdoclimitext.value = "0.00";
			document.form1.resdoclimitext.focus();
			return false;
		}
		 if (document.form1.resdocshar.value == "")
		{
			alert ("Starting Share Per. Cannot Be Empty.");
			document.form1.resdocshar.value = "0";
			document.form1.resdocshar.focus();
			return false;
		}
		 if (document.form1.resdocsharext.value == "")
		{
			alert ("Ext. Sharing Per. Cannot Be Empty.");
			document.form1.resdocsharext.value = "0";
			document.form1.resdocsharext.focus();
			return false;
		}
	}*/

	//return false;
}
</script>
<script>

function showrescharge()
   {
	    if(document.getElementById("ipresdoctor").checked==true)
		 {
	     	document.getElementById("residentarea").hidden=false;
		    document.getElementById("residentareaper").hidden=false;
		 }else{

            document.getElementById("residentarea").hidden=true;
		    document.getElementById("residentareaper").hidden=true;
		 }
   }
                 function showdoctorscharge()
				 {
					 if(document.getElementById("ipdoctor").checked==true)
					 {
					document.getElementById("residentdoc").hidden=false;
					document.getElementById("privatedoc").hidden=false;
					 }
					 else
					 {
					document.getElementById("residentdoc").hidden=true;
					document.getElementById("privatedoc").hidden=true;
					document.getElementById("resdoccharge").value='';
					document.getElementById("pridoccharge").value='';
						 }
					 }
					 
					 function selectcharge(val)
				 {
					 if(val=='res')
					 {
						 document.getElementById("pridoccharge").disabled=true;
						 document.getElementById("pridoccharge").value='';
						 document.getElementById("resdoccharge").disabled=false;
						 }
						 
						 else
					 {
						 document.getElementById("pridoccharge").disabled=false;
						 document.getElementById("resdoccharge").disabled=true;
						 document.getElementById("resdoccharge").value='';
						 }
					 
					 }
                 </script>
<script>
function coasearch(varCallFrom)
{
	var varCallFrom = varCallFrom;
	window.open("popup_coasearchdoctor.php?callfrom="+varCallFrom,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}
function ajaxdepartment(str)
{
var xmlhttp;
if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
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
    document.getElementById("department").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","ajax/ajaxdepartment.php?loc="+str,true);
xmlhttp.send();
}
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
					
//ajax to get location which is selected ends here
function consult()
{
	var drfees = document.getElementById("hospitalfees").value;
	if(drfees == "") { drfees = "0.00"; }
	var hospfees = document.getElementById("doctorfees").value;
	if(hospfees == "") { hospfees = "0.00"; }
	var consultation = parseFloat(drfees) + parseFloat(hospfees);
	var consultation = consultation.toFixed(2);
	document.getElementById("consultationfees").value = consultation;
}

function checkConsPercentage(){
	var percentage = document.getElementById('consultationpercentage').value;
	if(percentage > 100){
		alert('Consultation percentage cannot be greater than 100');
		document.getElementById('consultationpercentage').value = '';
	}
}
function pvtcheckConsPercentage(){
	var percentage = document.getElementById('pvtconsultationpercentage').value;
	if(percentage > 100){
		alert('Consultation percentage cannot be greater than 100');
		document.getElementById('pvtconsultationpercentage').value = '';
	}
}

function checkServPercentage(){
	var percentage = document.getElementById('ipserpercentage').value;
	if(percentage > 100){
		alert('IP Service percentage cannot be greater than 100');
		document.getElementById('ipserpercentage').value = '';
	}
}

function checkPvtDrPercentage(){
	var percentage = document.getElementById('pvtdrpercentage').value;
	if(percentage > 100){
		alert('Pvt. Dr percentage cannot be greater than 100');
		document.getElementById('pvtdrpercentage').value = '';
	}
}
function pvtcheckPvtDrPercentage(){
	var percentage = document.getElementById('ippvtdrpercentage').value;
	if(percentage > 100){
		alert('Pvt. Dr percentage cannot be greater than 100');
		document.getElementById('ippvtdrpercentage').value = '';
	}
}

</script>
            <!-- Error Message Display -->
            <?php if ($errmsg != '') { ?>
            <div class="alert alert-<?php echo ($st == 'success') ? 'success' : (($st == 'failed') ? 'danger' : 'info'); ?>">
                <i class="fas fa-<?php echo ($st == 'success') ? 'check-circle' : (($st == 'failed') ? 'exclamation-triangle' : 'info-circle'); ?>"></i>
                <?php echo $errmsg; ?>
            </div>
            <?php } ?>

            <!-- Add Doctor Form -->
            <form name="form1" id="form1" method="post" onKeyDown="return disableEnterKey()" action="adddoctor1.php" onSubmit="return process1()">
                <div class="form-section">
                    <div class="form-section-header">
                        <i class="fas fa-user-md form-section-icon"></i>
                        <h3 class="form-section-title">Add New Doctor</h3>
                        <span class="form-section-subtitle">* Indicates Mandatory Fields</span>
                    </div>
                    
                    <div class="form-section-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="location" class="form-label">Location *</label>
                                <select name="location" id="location" class="form-input" onChange="ajaxdepartment(this.value);ajaxlocationfunction(this.value);">
                                    <option value="">-Select Location-</option>
                                    <?php
                                    $query1 = "select * from master_location where status <> 'deleted' order by locationname";
                                    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while ($res1 = mysqli_fetch_array($exec1)) {
                                        $res1location = $res1["locationname"];
                                        $res1locationanum = $res1["locationcode"];
                                    ?>
                                        <option value="<?php echo $res1locationanum; ?>"><?php echo $res1location; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="doctorname" class="form-label">Doctor Name *</label>
                                <input type="text" name="doctorname" id="doctorname" class="form-input" autocomplete="off" placeholder="Enter doctor name" />
                                <input type="hidden" name="paynowlabtype6" id="paynowcashtype" />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="department" class="form-label">Department *</label>
                                <select name="department" id="department" class="form-input">
                                    <option value="" selected="selected">Select Department</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="doctorcode" class="form-label">Doctor Code</label>
                                <input name="doctorcode" id="doctorcode" value="" class="form-input" readonly style="background-color:#f8f9fa;" />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="consultationfees" class="form-label">Consultation Fees</label>
                                <input name="consultationfees" id="consultationfees" readonly value="<?php echo $consultationfees; ?>" class="form-input" style="background-color:#f8f9fa;" />
                            </div>
                        </div>
                        
                        <!-- Hospital and Doctor Fees -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="hospitalfees" class="form-label">Hospital Fee</label>
                                <input name="hospitalfees" id="hospitalfees" onKeyUp="return consult();" value="" class="form-input" placeholder="Enter hospital fee" />
                            </div>
                            <div class="form-group">
                                <label for="doctorfees" class="form-label">Doctor Fee</label>
                                <input name="doctorfees" id="doctorfees" onKeyUp="return consult();" value="" class="form-input" placeholder="Enter doctor fee" />
                            </div>
                        </div>
                        <!-- Address Information -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="address1" class="form-label">Address 1</label>
                                <input name="address1" id="address1" value="<?php echo $address1; ?>" class="form-input" placeholder="Enter address line 1" />
                            </div>
                            <div class="form-group">
                                <label for="address2" class="form-label">Address 2</label>
                                <input name="address2" id="address2" value="<?php echo $address2; ?>" class="form-input" placeholder="Enter address line 2" />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="area" class="form-label">Area</label>
                                <input name="area" id="area" value="<?php echo $location; ?>" class="form-input" placeholder="Enter area" />
                            </div>
                            <div class="form-group">
                                <label for="city" class="form-label">City</label>
                                <input name="city" id="city" value="<?php echo $city; ?>" class="form-input" placeholder="Enter city" />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="state" class="form-label">State/County</label>
                                <input name="state" id="state" value="<?php echo $state; ?>" class="form-input" placeholder="Enter state/county" />
                            </div>
                            <div class="form-group">
                                <label for="country" class="form-label">Country</label>
                                <input name="country" id="country" value="<?php echo $country; ?>" class="form-input" placeholder="Enter country" />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="pincode" class="form-label">Postal Code</label>
                                <input name="pincode" id="pincode" value="<?php echo $pincode; ?>" class="form-input" placeholder="Enter postal code" />
                            </div>
                            <div class="form-group">
                                <label for="mobilenumber" class="form-label">Mobile Number</label>
                                <input name="mobilenumber" id="mobilenumber" value="<?php echo $faxnumber2; ?>" class="form-input" placeholder="Enter mobile number" />
                            </div>
                        </div>
                        
                        <!-- Contact Information -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="phonenumber1" class="form-label">Phone Number 1</label>
                                <input name="phonenumber1" id="phonenumber1" value="<?php echo $phonenumber1; ?>" class="form-input" placeholder="Enter phone number 1" />
                            </div>
                            <div class="form-group">
                                <label for="phonenumber2" class="form-label">Phone Number 2</label>
                                <input name="phonenumber2" id="phonenumber2" value="<?php echo $phonenumber2; ?>" class="form-input" placeholder="Enter phone number 2" />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="emailid1" class="form-label">Email Id 1</label>
                                <input name="emailid1" id="emailid1" value="<?php echo $emailid1; ?>" class="form-input" placeholder="Enter email address 1" />
                            </div>
                            <div class="form-group">
                                <label for="emailid2" class="form-label">Email Id 2</label>
                                <input name="emailid2" id="emailid2" value="<?php echo $emailid2; ?>" class="form-input" placeholder="Enter email address 2" />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="tinnumber" class="form-label">TIN Number</label>
                                <input name="tinnumber" id="tinnumber" value="<?php echo $tinnumber; ?>" class="form-input" placeholder="Enter TIN number" />
                            </div>
                            <div class="form-group">
                                <label for="cstnumber" class="form-label">CST Number</label>
                                <input name="cstnumber" id="cstnumber" value="<?php echo $cstnumber; ?>" class="form-input" placeholder="Enter CST number" />
                            </div>
                        </div>
                        <!-- Opening Balance -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="openingbalance" class="form-label">Opening Balance</label>
                                <input type="text" name="openingbalance" id="openingbalance" value="<?php echo $openingbalance; ?>" class="form-input" style="text-align:right" placeholder="0.00" />
                            </div>
                        </div>
                        
                        <!-- OP Consultation Percentage -->
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">OP Consultation %</label>
                                <div class="form-input-group">
                                    <label class="radio-label">
                                        <input type="radio" name="consultation_type" value="hospital" checked>
                                        <span class="radio-text">Hospital</span>
                                    </label>
                                    <input type="text" onKeyUp="checkConsPercentage()" name="consultationpercentage" id="consultationpercentage" value="<?php echo $consultationpercentage; ?>" class="form-input" style="width: 100px; text-align:right" placeholder="0.00" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">&nbsp;</label>
                                <div class="form-input-group">
                                    <label class="radio-label">
                                        <input type="radio" name="consultation_type" value="private">
                                        <span class="radio-text">Private</span>
                                    </label>
                                    <input type="text" onKeyUp="pvtcheckConsPercentage()" name="pvtconsultationpercentage" id="pvtconsultationpercentage" value="0.00" class="form-input" style="width: 100px; text-align:right" placeholder="0.00" />
                                </div>
                            </div>
                        </div>
                        <!-- IP Service and Private Doctor Percentage -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="ipserpercentage" class="form-label">IP Service Percentage</label>
                                <input type="text" onKeyUp="checkServPercentage()" name="ipserpercentage" id="ipserpercentage" value="<?php echo $ipserpercentage; ?>" class="form-input" style="text-align:right" placeholder="0.00" />
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">IP Pvt. Dr Percentage</label>
                                <div class="form-input-group">
                                    <label class="radio-label">
                                        <input type="radio" name="ip_dr_type" value="hospital" checked>
                                        <span class="radio-text">Hospital</span>
                                    </label>
                                    <input type="text" onKeyUp="checkPvtDrPercentage()" name="pvtdrpercentage" id="pvtdrpercentage" value="<?php echo $pvtdrpercentage; ?>" class="form-input" style="width: 100px; text-align:right" placeholder="0.00" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">&nbsp;</label>
                                <div class="form-input-group">
                                    <label class="radio-label">
                                        <input type="radio" name="ip_dr_type" value="private">
                                        <span class="radio-text">Private</span>
                                    </label>
                                    <input type="text" onKeyUp="pvtcheckPvtDrPercentage()" name="ippvtdrpercentage" id="ippvtdrpercentage" value="0.00" class="form-input" style="width: 100px; text-align:right" placeholder="0.00" />
                                </div>
                            </div>
                        </div>
                        <!-- Doctor Settings -->
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Doctor Settings</label>
                                <div class="form-input-group">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="ipdoctor" id="ipdoctor" value="1" onClick="showdoctorscharge()">
                                        <span class="checkbox-text">Is IP Doctor?</span>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="max_appt" class="form-label">Max. Appointments</label>
                                <input type="text" name="max_appt" id="max_appt" class="form-input" placeholder="Enter max appointments" />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Staff Settings</label>
                                <div class="form-input-group">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="isstaff" id="isstaff" value="1">
                                        <span class="checkbox-text">Is Staff?</span>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Allocation Settings</label>
                                <div class="form-input-group">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="excludeallocation" id="excludeallocation" value="1">
                                        <span class="checkbox-text">Exclude Allocation</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- Resident Doctor Settings -->
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Resident Doctor Settings</label>
                                <div class="form-input-group">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="ipresdoctor" id="ipresdoctor" value="1" onClick="showrescharge()">
                                        <span class="checkbox-text">Is Resident Doctor?</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Resident Doctor Limits (Hidden by default) -->
                        <div id="residentarea" style="display:none;">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="resdoclimit" class="form-label">Resident Doctor Limit</label>
                                    <input type="text" name="resdoclimit" id="resdoclimit" class="form-input" style="text-align:right" placeholder="0" />
                                </div>
                                <div class="form-group">
                                    <label for="resdoclimitext" class="form-label">Resident Limit Ext</label>
                                    <input type="text" name="resdoclimitext" id="resdoclimitext" class="form-input" style="text-align:right" placeholder="0" />
                                </div>
                            </div>
                        </div>
                        
                        <!-- Resident Doctor Sharing (Hidden by default) -->
                        <div id="residentareaper" style="display:none;">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="resdocshar" class="form-label">Resident Doc. Sharing Start %</label>
                                    <input type="text" name="resdocshar" id="resdocshar" class="form-input" style="text-align:right" placeholder="0" />
                                </div>
                                <div class="form-group">
                                    <label for="resdocsharext" class="form-label">Resident Doc. Sharing Ext %</label>
                                    <input type="text" name="resdocsharext" id="resdocsharext" class="form-input" style="text-align:right" placeholder="0" />
                                </div>
                            </div>
                        </div>
                        
                        <!-- Available Week Days -->
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Available Week Days</label>
                                <div class="form-input-group">
                                    <?php  
                                    $weekdays_qry = "select id,weekday from weekdays where status = 1";
                                    $weekdays_exec = mysqli_query($GLOBALS["___mysqli_ston"], $weekdays_qry) or die ("Error in Weekdays Query".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while($weekdays_res = mysqli_fetch_assoc($weekdays_exec)) { 
                                    ?>
                                        <label class="checkbox-label">
                                            <input type="checkbox" name="weekday[]" id="weekday_<?php echo $weekdays_res['id'] ?>" value="<?php echo $weekdays_res['id'] ?>">
                                            <span class="checkbox-text"><?php echo $weekdays_res['weekday']; ?></span>
                                        </label>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <!-- Doctor Charge Settings (Hidden by default) -->
                        <div id="residentdoc" style="display:none;">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="resdoccharge" class="form-label">Resident Doctor Charge</label>
                                    <div class="form-input-group">
                                        <input type="text" name="resdoccharge" id="resdoccharge" class="form-input" style="text-align:right" placeholder="0.00" />
                                        <label class="radio-label">
                                            <input name="chargerad" type="radio" onClick="selectcharge('res')" checked>
                                            <span class="radio-text">Select</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="privatedoc" style="display:none;">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="pridoccharge" class="form-label">Private Doctor Charge</label>
                                    <div class="form-input-group">
                                        <input type="text" name="pridoccharge" id="pridoccharge" class="form-input" style="text-align:right" disabled placeholder="0.00" />
                                        <label class="radio-label">
                                            <input type="radio" name="chargerad" onClick="selectcharge('pri')">
                                            <span class="radio-text">Select</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Employee Mapping Section -->
                        <div class="form-section">
                            <div class="form-section-header">
                                <i class="fas fa-users form-section-icon"></i>
                                <h3 class="form-section-title">Employee Mapping</h3>
                            </div>
                            
                            <div class="form-section-form">
                                <div class="table-container">
                                    <table class="data-table">
                                        <thead class="table-header">
                                            <tr>
                                                <th class="table-header-cell">Employee Name</th>
                                                <th class="table-header-cell">Employee Code</th>
                                                <th class="table-header-cell">Employee Username</th>
                                                <th class="table-header-cell text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="emptbody">
                                            <?php
                                            $i=1;
                                            $query11 = "select * from doctor_mapping where status <> 'deleted' and doctorcode = '$doctorcode'";
                                            $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                            while($res11 = mysqli_fetch_array($exec11))
                                            {
                                                $employeename = $res11['employeename'];
                                                $employeecode = $res11['employeecode'];
                                                $docusername = $res11['docusername'];
                                            ?>
                                            <tr id="<?= $employeecode?>">
                                                <td class="table-cell">
                                                    <input type="text" name="employee[]" value="<?= $employeename?>" class="form-input" readonly />
                                                </td>
                                                <td class="table-cell">
                                                    <input type="text" name="employeecode[]" value="<?= $employeecode?>" class="form-input" readonly />
                                                </td>
                                                <td class="table-cell">
                                                    <input type="text" name="docusername[]" value="<?= $docusername?>" class="form-input" readonly />
                                                </td>
                                                <td class="table-cell text-center">
                                                    <button type="button" class="btn btn-sm btn-danger" onClick="return delemp('<?= $employeecode?>');">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </td>
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                            <!-- Add new employee row -->
                                            <tr>
                                                <td class="table-cell">
                                                    <input type="text" name="employee[]" id="employee" value="" class="form-input" placeholder="Enter employee name" />
                                                </td>
                                                <td class="table-cell">
                                                    <input type="text" name="employeecode[]" id="employeecode" value="" class="form-input" readonly />
                                                </td>
                                                <td class="table-cell">
                                                    <input type="text" name="docusername[]" id="docusername" value="" class="form-input" readonly />
                                                </td>
                                                <td class="table-cell text-center">
                                                    <button type="button" class="btn btn-sm btn-primary" onClick="functionaddemp();">
                                                        <i class="fas fa-plus"></i> Add
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Form Actions -->
                        <div class="form-actions">
                            <input type="hidden" name="frmflag1" value="frmflag1" />
                            <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
                            <button type="submit" name="Submit222" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Doctor
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="resetForm()">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Existing Doctors Section -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <h3 class="data-table-title">Master Doctor - Existing</h3>
                </div>
                
                <!-- Search Form -->
                <form method="post" action="adddoctor1.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <input type="text" name="searchdoctor" id="searchdoctor" class="form-input" value="<?php echo $searchdoctor; ?>" placeholder="Search doctors..." />
                        </div>
                        <div class="form-group">
                            <button type="submit" name="submit345" class="btn btn-primary">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </div>
                </form>
                
                <!-- Doctors Table -->
                <div class="table-container">
                    <table class="data-table">
                        <thead class="table-header">
                            <tr>
                                <th class="table-header-cell">S.No</th>
                                <th class="table-header-cell">Doctor Code</th>
                                <th class="table-header-cell">Doctor Name</th>
                                <th class="table-header-cell">Department</th>
                                <th class="table-header-cell text-right">Consultation Fee</th>
                                <th class="table-header-cell">Location</th>
                                <th class="table-header-cell text-center">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sno = $offset;
                            $colorloopcount = 0;
                            
                            // Get total count for pagination
                            $count_query = "select COUNT(*) as total from master_doctor where doctorname like '%$searchdoctor%' and status <> 'deleted'";
                            $count_exec = mysqli_query($GLOBALS["___mysqli_ston"], $count_query) or die ("Error in Count Query".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $count_res = mysqli_fetch_array($count_exec);
                            $total_records = $count_res['total'];
                            $total_pages = ceil($total_records / $records_per_page);
                            
                            // Modified query with pagination
                            $query11 = "select * from master_doctor where doctorname like '%$searchdoctor%' and status <> 'deleted' order by doctorname LIMIT $offset, $records_per_page";
                            $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($res11 = mysqli_fetch_array($exec11))
                            {
                                $sno = $sno + 1;
                                $doctorcode = $res11['doctorcode'];
                                $doctorname = $res11['doctorname'];
                                $consultationfees = $res11['consultationfees'];
                                $locationname = $res11['locationname'];
                                
                                $department = $res11['department'];
                                
                                $query110 = "select * from master_department where auto_number = '$department' and recordstatus <> 'deleted'";
                                $exec110= mysqli_query($GLOBALS["___mysqli_ston"], $query110) or die ("Error in Query110".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res110 = mysqli_fetch_array($exec110);
                                $res110department = $res110['department'];
                                
                                $colorloopcount = $colorloopcount + 1;
                            ?>
                            <tr class="<?php echo ($colorloopcount % 2 == 0) ? 'table-row-even' : 'table-row-odd'; ?>">
                                <td class="table-cell"><?php echo $sno; ?></td>
                                <td class="table-cell"><?php echo $doctorcode; ?></td>
                                <td class="table-cell"><?php echo $doctorname; ?></td>
                                <td class="table-cell"><?php echo $res110department; ?></td>
                                <td class="table-cell text-right"><?php echo number_format($consultationfees, 2, '.', ','); ?></td>
                                <td class="table-cell"><?php echo $locationname; ?></td>
                                <td class="table-cell text-center">
                                    <a href="editdoctor1.php?st=edit&&doctorcode=<?php echo $doctorcode; ?>&&menuid=<?php echo $menu_id; ?>" class="btn btn-sm btn-outline">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </td>
                            </tr>
                            <?php
                            } 
                            ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination Controls -->
                <?php if ($total_pages > 1) { ?>
                <div class="pagination-container">
                    <div class="pagination-info">
                        Showing <?php echo $offset + 1; ?> to <?php echo min($offset + $records_per_page, $total_records); ?> of <?php echo $total_records; ?> records
                    </div>
                    
                    <div class="pagination-controls">
                        <?php if ($page > 1) { ?>
                            <a href="adddoctor1.php?page=<?php echo $page - 1; ?>&searchdoctor=<?php echo urlencode($searchdoctor); ?>" class="btn btn-outline">
                                <i class="fas fa-chevron-left"></i> Previous
                            </a>
                        <?php } ?>
                        
                        <?php
                        $start_page = max(1, $page - 2);
                        $end_page = min($total_pages, $page + 2);
                        
                        for ($i = $start_page; $i <= $end_page; $i++) {
                            if ($i == $page) {
                                echo '<span class="btn btn-primary">' . $i . '</span>';
                            } else {
                                echo '<a href="adddoctor1.php?page=' . $i . '&searchdoctor=' . urlencode($searchdoctor) . '" class="btn btn-outline">' . $i . '</a>';
                            }
                        }
                        ?>
                        
                        <?php if ($page < $total_pages) { ?>
                            <a href="adddoctor1.php?page=<?php echo $page + 1; ?>&searchdoctor=<?php echo urlencode($searchdoctor); ?>" class="btn btn-outline">
                                Next <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript Functions -->
    <script>
        // Sidebar toggle functionality
        function toggleSidebar() {
            const sidebar = document.getElementById('leftSidebar');
            const toggle = document.querySelector('.sidebar-toggle i');
            
            sidebar.classList.toggle('collapsed');
            toggle.classList.toggle('fa-chevron-left');
            toggle.classList.toggle('fa-chevron-right');
        }

        // Page refresh function
        function refreshPage() {
            window.location.reload();
        }

        // Reset form function
        function resetForm() {
            document.getElementById('form1').reset();
        }

        // Initialize sidebar toggle on menu button click
        document.getElementById('menuToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('leftSidebar');
            sidebar.classList.toggle('show');
        });

        // Close sidebar when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('leftSidebar');
            const menuToggle = document.getElementById('menuToggle');
            
            if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                sidebar.classList.remove('show');
            }
        });

        // Initialize page on load
        window.onload = function() {
            onloadfunction1();
        };
    </script>

    <!-- Include Required JavaScript Files -->
    <script src="js/jquery-ui.js" type="text/javascript"></script>

</body>
</html>
