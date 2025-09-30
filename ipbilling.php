<?php
// Inpatient Billing - Modernized Version
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include required files
include("includes/loginverify.php");
include("db/db_connect.php");
include("includes/check_user_access.php");
include("autocompletebuild_customeripbilling.php");

// Initialize variables
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

// Location handling
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';

// Initialize other variables
$errmsg = "";
$bgcolorcode = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

// Request parameter handling
if (isset($_REQUEST["canum"])) { 
    $getcanum = $_REQUEST["canum"]; 
} else { 
    $getcanum = ""; 
}

if (isset($_REQUEST["cbfrmflag2"])) { 
    $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; 
} else { 
    $cbfrmflag2 = ""; 
}

if (isset($_REQUEST["frmflag2"])) { 
    $frmflag2 = $_REQUEST["frmflag2"]; 
} else { 
    $frmflag2 = ""; 
}

// Form processing and error handling
if (isset($_REQUEST["cbfrmflag1"]) && $_REQUEST["cbfrmflag1"] == 'cbfrmflag1') {
    $searchpatient = isset($_POST['customer']) ? $_POST['customer'] : '';
    $searchlocation = isset($_POST['location']) ? $_POST['location'] : '';
    
    if (empty($searchlocation)) {
        $errmsg = "Please select a location.";
        $bgcolorcode = "failed";
    } elseif (empty($searchpatient)) {
        $errmsg = "Please enter a patient name, registration number, or visit code to search.";
        $bgcolorcode = "failed";
    } else {
        $errmsg = "Search completed successfully.";
        $bgcolorcode = "success";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inpatient Billing - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/ipbilling-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Legacy CSS for compatibility -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <!-- Legacy JavaScript -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script type="text/javascript" src="ckeditor1/ckeditor.js"></script>
    <?php include ("js/dropdownlistipbilling.php"); ?>
    <script type="text/javascript" src="js/autosuggestipbilling.js"></script>
    <script type="text/javascript" src="js/autocomplete_customeripbilling.js"></script>
</head>
<script>	
<?php 
if (isset($_REQUEST["ipbillnumber"])) { $ipbillnumbers = $_REQUEST["ipbillnumber"]; } else { $ipbillnumbers = ""; }
if (isset($_REQUEST["ippatientcode"])) { $ippatientcodes = $_REQUEST["ippatientcode"]; } else { $ipbillnumbers = ""; }
?>
	var ipbillnumberr;
	var ipbillnumberr = "<?php echo $ipbillnumbers; ?>";
	var ippatientcoder;
	var ippatientcoder = "<?php echo $ippatientcodes; ?>";
	//alert(refundbillnumber);
	if(ipbillnumberr != "") 
	{
		window.open("print_depositcollection_dmp4inch1.php?billnumbercode="+ipbillnumberr+"&&patientcode="+ippatientcoder+"","OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}				
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
					
//ajax to get location which is selected ends here




function cbsuppliername1()
{
	document.cbform1.submit();
}

function funcOnLoadBodyFunctionCall()
{ 
	//alert ("Inside Body On Load Fucntion.");
	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	funcCustomerDropDownSearch1(); //To handle ajax dropdown list.
	funcPopupOnLoad1();
}



</script>
<script type="text/javascript">


function disableEnterKey(varPassed)
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}

	if(key == 13) // if enter key press
	{
		//alert ("Enter Key Press2");
		return false;
	}
	else
	{
		return true;
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

function disableEnterKey()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}
	
	if(key == 13) // if enter key press
	{
		return false;
	}
	else
	{
		return true;
	}

}


function funcPrintReceipt1()
{
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}

</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
}
.bali
{
text-align:right;
}
</style>
</head>

<script>
function funcPopupOnLoad1()
{
<?php  
if (isset($_REQUEST["savedpatientcode"])) { $savedpatientcode = $_REQUEST["savedpatientcode"]; } else { $savedpatientcode = ""; }
if (isset($_REQUEST["savedvisitcode"])) { $savedvisitcode = $_REQUEST["savedvisitcode"]; } else { $savedvisitcode = ""; }
if (isset($_REQUEST["billnumber"])) { $billnumbers = $_REQUEST["billnumber"]; } else { $billnumbera = ""; }
if (isset($_REQUEST["loc"])) { $loc_get = $_REQUEST["loc"]; } else { $loc_get = ""; }
?>
var patientcodes = "<?php echo $_REQUEST['savedpatientcode']; ?>";
var visitcodes = "<?php echo $_REQUEST['savedvisitcode']; ?>";
var billnumbers = "<?php echo $_REQUEST['billnumber']; ?>";
var loc_get = "<?php echo $_REQUEST['loc']; ?>";
//alert(billnumbers);
	if(patientcodes != "") 
	{
		window.open("print_ipfinalinvoice1.php?locationcode="+loc_get+"&&patientcode="+patientcodes+"&&visitcode="+visitcodes+"&&billnumber="+billnumbers,"OriginalWindowA4",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}
}
</script>

<script src="js/datetimepicker_css.js"></script>

<body onLoad="return funcOnLoadBodyFunctionCall()">
    <!-- Loading Overlay -->
    <div id="imgloader" class="loading-overlay" style="display:none;">
        <div class="loading-content">
            <div class="loading-spinner">
                <i class="fas fa-spinner fa-spin"></i>
            </div>
            <p><strong>Processing Billing Request</strong></p>
            <p>Please be patient...</p>
        </div>
    </div>

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
        <span>Inpatient Billing</span>
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
                        <a href="activeinpatientlist.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Active Inpatient List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipaccountwiselist.php" class="nav-link">
                            <i class="fas fa-file-medical-alt"></i>
                            <span>IP Account Wise List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipadmissionlist_tat.php" class="nav-link">
                            <i class="fas fa-clock"></i>
                            <span>IP Admission TAT</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="ipbilling.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>IP Billing</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="internalreferallist.php" class="nav-link">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Internal Referral List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountreceivableentrylist.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Account Receivable</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer">
                <?php if (!empty($errmsg)): ?>
                    <div class="alert alert-<?php echo $bgcolorcode === 'success' ? 'success' : ($bgcolorcode === 'failed' ? 'error' : 'info'); ?>">
                        <i class="fas fa-<?php echo $bgcolorcode === 'success' ? 'check-circle' : ($bgcolorcode === 'failed' ? 'exclamation-triangle' : 'info-circle'); ?> alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Inpatient Billing</h2>
                    <p>Search and manage billing for inpatient services, deposits, and final invoices.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>
            <!-- Search Form Section -->
            <div class="search-form-section">
                <div class="form-header">
                    <i class="fas fa-search form-icon"></i>
                    <h3 class="form-title">Patient Billing Search</h3>
                </div>
                
                <div class="form-info">
                    <div class="info-item">
                        <strong>Current Location:</strong> 
                        <span class="location-name" id="ajaxlocation">
                            <?php
                            if ($location != '') {
                                $query12 = "select locationname from master_location where locationcode='$location' order by locationname";
                                $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res12 = mysqli_fetch_array($exec12);
                                echo $res1location = $res12["locationname"];
                            } else {
                                $query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res1 = mysqli_fetch_array($exec1);
                                echo $res1location = $res1["locationname"];
                            }
                            ?>
                        </span>
                    </div>
                </div>
                
                <form name="cbform1" method="post" action="ipbilling.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" class="form-select" onChange="ajaxlocationfunction(this.value);">
                                <?php
                                $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $locationname = $res1["locationname"];
                                    $locationcode = $res1["locationcode"];
                                ?>
                                    <option value="<?php echo $locationcode; ?>" <?php if($location != '' && $location == $locationcode) echo "selected"; ?>>
                                        <?php echo $locationname; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="customer" class="form-label">Patient Search</label>
                            <input name="customer" id="customer" class="form-input" 
                                   placeholder="Search by patient name, registration number, or visit code..." 
                                   autocomplete="off">
                            <input name="customercode" id="customercode" value="" type="hidden">
                            <input type="hidden" name="recordstatus" id="recordstatus">
                            <input type="hidden" name="billnumbercode" id="billnumbercode" value="<?php echo isset($billnumbercode) ? $billnumbercode : ''; ?>">
                        </div>
                        
                        <div class="form-group form-group-submit">
                            <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                            <button type="submit" name="Submit" class="submit-btn" onClick="return funcvalidcheck();">
                                <i class="fas fa-search"></i>
                                Search Patients
                            </button>
                            <button type="reset" name="resetbutton" class="btn btn-secondary">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Results Section -->
            <?php
            $colorloopcount = 0;
            $sno = 0;
            
            if (isset($_REQUEST["cbfrmflag1"])) { 
                $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; 
            } else { 
                $cbfrmflag1 = ""; 
            }

            if ($cbfrmflag1 == 'cbfrmflag1') {
                $searchpatient = $_POST['customer'];
                $searchlocation = $_POST['location'];
            ?>
                <!-- Billing Results Table -->
                <div class="results-section">
                    <div class="section-header">
                        <i class="fas fa-receipt"></i>
                        <h3>Inpatient Billing Results</h3>
                        <div class="export-actions">
                            <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                                <i class="fas fa-file-excel"></i>
                                Export to Excel
                            </button>
                        </div>
                    </div>
                    
                    <div class="table-container">
                        <table class="billing-table">
                            <thead>
                                <tr>
                                    <th class="serial-header">No.</th>
                                    <th class="type-header">Type</th>
                                    <th class="patient-header">Patient Name</th>
                                    <th class="reg-header">Reg No</th>
                                    <th class="ward-header">Ward</th>
                                    <th class="date-header">IP Date</th>
                                    <th class="visit-header">IP Visit</th>
                                    <th class="action-header">Notes</th>
                                    <th class="provider-header">Provider</th>
                                    <th class="account-header">Account</th>
                                    <th class="outstanding-header">Outstanding</th>
                                    <th class="status-header">Status</th>
                                    <th class="billing-header">Billing Action</th>
                                    <th class="approval-header">Credit Approval</th>
                                </tr>
                            </thead>
                            <tbody>
           <?php
		  
		  if($searchpatient != '')
		  { 
		  	$colorloopcount1=0;
		  	$sno1=0;
           $query34 = "select * from ip_bedallocation where locationcode='$searchlocation' and patientname like '%$searchpatient%' or patientcode like '%$searchpatient%' or visitcode like '%$searchpatient%'";
		   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   while($res34 = mysqli_fetch_array($exec34))
		   {
		   $patientname = $res34['patientname'];
		   $patientcode = $res34['patientcode'];
		   $visitcode = $res34['visitcode'];
		   $paymentstatus = $res34['paymentstatus'];
		   $creditapprovalstatus = $res34['creditapprovalstatus'];
		   $recordstatus = $res34['recordstatus'];
		   $wardno = $res34['ward'];

		   if($recordstatus=='transfered'){
			$query341 = "select * from ip_bedtransfer where locationcode='$searchlocation' and  patientcode = '$patientcode' and visitcode = '$visitcode' order by auto_number desc";
			$exec341 = mysqli_query($GLOBALS["___mysqli_ston"], $query341) or die(mysqli_error($GLOBALS["___mysqli_ston"]));   
			 $res41 = mysqli_fetch_array($exec341);
			$wardno = $res41['ward'];   
		   }
		   
		   
		   $query_1 = "select ward from master_ward where auto_number='$wardno'";
		   $exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res_1 = mysqli_fetch_array($exec_1);
		   $ward_name = $res_1['ward'];
		   
		   include ('ipcreditaccountreport3_ipcredit.php');
			$total = $overalltotal;
		  
		   $query71 = "select * from ip_discharge where locationcode='$searchlocation' and visitcode='$visitcode'";
		   $exec71 = mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $num71 = mysqli_num_rows($exec71);
		   if($num71 == 0)
		   {
		   $status = 'Active';
		   }
		  else
		   {
		     $res711 = mysqli_fetch_array($exec71);
			 if($res711['req_status']=='request')
		       $status = 'Active';
			 else
			   $status = 'Discharged';
		   }
		   
		   $query82 = "select * from master_ipvisitentry where locationcode='$searchlocation' and patientcode='$patientcode' and visitcode='$visitcode'";
		   $exec82 = mysqli_query($GLOBALS["___mysqli_ston"], $query82) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res82 = mysqli_fetch_array($exec82);
		   $date = $res82['consultationdate'];
		   $conslt_timedate = $res82['consultationtime'];
		   $accountname = $res82['accountfullname'];
		   $ipvist_autonumber = $res82['auto_number'];
		   $patientlocationcode = $res82['locationcode'];
		   $type = $res82['type'];
		   $subtype_ledger = $res82['accountname'];
		   
		   $query821 = "select * from ip_creditapproval where  patientcode='$patientcode' and visitcode='$visitcode' and recordstatus='approved'";
			$exec821 = mysqli_query($GLOBALS["___mysqli_ston"], $query821) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$creditnum = mysqli_num_rows($exec821);
		   
$query15 = "select accountname from master_accountname where auto_number = '$subtype_ledger'";

$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));

$res15 = mysqli_fetch_array($exec15);

$provider = $res15['accountname'];
		   if($type=='hospital')
		   {
			$type='H';   
		   }
		   if($type=='private')
		   {
			$type='P';   
		   }
		 
		   if($paymentstatus == '')
		   {
		   /* if($creditapprovalstatus == '')
		   { */
		   		$colorloopcount1 = $colorloopcount1 + 1;
			$showcolor1 = ($colorloopcount1 & 1); 
			if ($showcolor1 == 0)
			{
				//echo "if";
				$colorcode1 = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode1 = 'bgcolor="#ecf0f5"';
			}
			?>
			
                                <tr class="table-row">
                                    <td class="serial-cell"><?php echo $sno1 = $sno1 + 1; ?></td>
                                    <td class="type-cell"><?php echo htmlspecialchars($type); ?></td>
                                    <td class="patient-cell"><?php echo htmlspecialchars($patientname); ?></td>
                                    <td class="reg-cell"><?php echo htmlspecialchars($patientcode); ?></td>
                                    <td class="ward-cell"><?php echo htmlspecialchars($ward_name); ?></td>
                                    <td class="date-cell"><?php echo date("d/m/Y", strtotime($date))." ".$conslt_timedate; ?></td>
                                    <td class="visit-cell"><?php echo htmlspecialchars($visitcode); ?></td>
                                    <td class="action-cell">
                                        <button class="btn-action btn-notes" onclick="window.open('ipbilling_notes.php?ipvist_autonumber=<?=$ipvist_autonumber?>', '_blank', 'location=yes,height=570,width=700,scrollbars=yes,status=yes');" title="View Notes">
                                            <i class="fas fa-sticky-note"></i>
                                        </button>
                                    </td>
                                    <td class="provider-cell"><?php echo htmlspecialchars($provider); ?></td>
                                    <td class="account-cell"><?php echo htmlspecialchars($accountname); ?></td>
                                    <td class="outstanding-cell"><?php echo number_format($total,2,'.',','); ?></td>
                                    <td class="status-cell">
                                        <span class="status-badge status-<?php echo strtolower($status); ?>">
                                            <?php echo htmlspecialchars($status); ?>
                                        </span>
                                    </td>
                                    <td class="billing-cell">
                                        <?php if($creditapprovalstatus!='approved') { ?>
                                            <select name="invoice" id="invoice" class="billing-select" onChange="if (this.value) window.open(this.value, '_blank')">
                                                <option value="">Select Action</option>
                                                <option value="ipinteriminvoiceserver.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&menuid=<?php echo $menu_id; ?>">Interim</option>
                                                <option value="depositform1.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&menuid=<?php echo $menu_id; ?>">Redeposit</option>
                                                <option value="nhifprocessing.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&menuid=<?php echo $menu_id; ?>">NHIF</option>
                                                <option value="ipmiscbilling.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&menuid=<?php echo $menu_id; ?>">Misc Billing</option>
                                                <option value="ipfinalinvoice.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&menuid=<?php echo $menu_id; ?>">Final</option>
                                            </select>
                                        <?php } elseif($creditapprovalstatus=='approved' && $creditnum==0) { ?>
                                            <a href="ipinteriminvoiceserver.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&menuid=" class="btn-action btn-interim">Interim</a>
                                        <?php } elseif($creditnum>0) { ?>
                                            <a href="ipapprovedcreditform.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&menuid=<?php echo $menu_id; ?>" class="btn-action btn-finalize">Finalize</a>
                                        <?php } ?>
                                    </td>
                                    <td class="approval-cell">
                                        <?php if($status == 'Discharged' && $creditapprovalstatus!='approved' && $total>0) { ?>
                                            <a href="creditapprovalrequest.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&menuid=<?php echo $menu_id; ?>" class="btn-action btn-request">Request</a>
                                        <?php } elseif($status == 'Discharged' && $creditapprovalstatus=='approved' && $creditnum==0) { ?>
                                            <span class="status-badge status-pending">Sent for Approval</span>
                                        <?php } elseif($creditnum>0) { ?>
                                            <span class="status-badge status-approved">Approved</span>
                                        <?php } ?>
                                    </td>
                                </tr>
		  <?php
		  }
		  //}
		 }
		  }else
		  {
		  	$colorloopcount1=0;
		  	$sno1=0;
			$query34 = "select * from ip_bedallocation where locationcode='$searchlocation' and paymentstatus = '' ";
		   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   while($res34 = mysqli_fetch_array($exec34))
		   {
		   $patientname = $res34['patientname'];
		   $patientcode = $res34['patientcode'];
		   $visitcode = $res34['visitcode'];
		   $creditapprovalstatus = $res34['creditapprovalstatus'];
		   $recordstatus = $res34['recordstatus'];
			$wardno = $res34['ward'];
			
			 if($recordstatus=='transfered'){
			$query341 = "select * from ip_bedtransfer where locationcode='$searchlocation' and  patientcode = '$patientcode' and visitcode = '$visitcode' order by auto_number desc";
			$exec341 = mysqli_query($GLOBALS["___mysqli_ston"], $query341) or die(mysqli_error($GLOBALS["___mysqli_ston"]));   
			 $res41 = mysqli_fetch_array($exec341);
			$wardno = $res41['ward'];   
		   }
		   
			$query_1 = "select ward from master_ward where auto_number='$wardno'";
		   $exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res_1 = mysqli_fetch_array($exec_1);
		   $ward_name = $res_1['ward'];
		  include ('ipcreditaccountreport3_ipcredit.php');
			$total = $overalltotal;

		   $query71 = "select * from ip_discharge where  locationcode='$searchlocation' and visitcode='$visitcode'";
		   $exec71 = mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $num71 = mysqli_num_rows($exec71);
		   if($num71 == 0)
		   {
		    $status = 'Active';
		   }
		   else
		   {
		     $res711 = mysqli_fetch_array($exec71);
			 if($res711['req_status']=='request')
		       $status = 'Active';
			 else
			   $status = 'Discharged';
		   }
		   
		   $query82 = "select * from master_ipvisitentry where  locationcode='$searchlocation' and patientcode='$patientcode' and visitcode='$visitcode'";
		   $exec82 = mysqli_query($GLOBALS["___mysqli_ston"], $query82) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res82 = mysqli_fetch_array($exec82);
		   $date = $res82['consultationdate'];
		   $conslt_timedate = $res82['consultationtime'];
		   $ipvist_autonumber = $res82['auto_number'];
		   $accountname = $res82['accountfullname'];
		   $type=$res82['type'];
		   
		    $subtype_ledger = $res82['accountname'];
		   
			$query15 = "select accountname from master_accountname where auto_number = '$subtype_ledger'";

			$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res15 = mysqli_fetch_array($exec15);

			$provider = $res15['accountname'];
			if($type=='hospital')
			{
			$type='H';   
			}
			if($type=='private')
			{
			$type='P';   
			}
			
			
			$query821 = "select * from ip_creditapproval where  patientcode='$patientcode' and visitcode='$visitcode' and recordstatus='approved'";
			$exec821 = mysqli_query($GLOBALS["___mysqli_ston"], $query821) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$creditnum = mysqli_num_rows($exec821);


			$colorloopcount1 = $colorloopcount1 + 1;
			$showcolor1 = ($colorloopcount1 & 1); 
			if ($showcolor1 == 0)
			{
				//echo "if";
				$colorcode1 = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode1 = 'bgcolor="#ecf0f5"';
			}

			?>
			
                                <tr class="table-row">
                                    <td class="serial-cell"><?php echo $sno1 = $sno1 + 1; ?></td>
                                    <td class="type-cell type-private"><?php echo htmlspecialchars($type); ?></td>
                                    <td class="patient-cell"><?php echo htmlspecialchars($patientname); ?></td>
                                    <td class="reg-cell"><?php echo htmlspecialchars($patientcode); ?></td>
                                    <td class="ward-cell"><?php echo htmlspecialchars($ward_name); ?></td>
                                    <td class="date-cell"><?php echo date("d/m/Y", strtotime($date))." ".$conslt_timedate; ?></td>
                                    <td class="visit-cell"><?php echo htmlspecialchars($visitcode); ?></td>
                                    <td class="action-cell">
                                        <button class="btn-action btn-notes" onclick="window.open('ipbilling_notes.php?ipvist_autonumber=<?=$ipvist_autonumber?>', '_blank', 'location=yes,height=570,width=700,scrollbars=yes,status=yes');" title="View Notes">
                                            <i class="fas fa-sticky-note"></i>
                                        </button>
                                    </td>
                                    <td class="provider-cell"><?php echo htmlspecialchars($provider); ?></td>
                                    <td class="account-cell"><?php echo htmlspecialchars($accountname); ?></td>
                                    <td class="outstanding-cell"><?php echo number_format($total,2,'.',','); ?></td>
                                    <td class="status-cell">
                                        <span class="status-badge status-<?php echo strtolower($status); ?>">
                                            <?php echo htmlspecialchars($status); ?>
                                        </span>
                                    </td>
                                    <td class="billing-cell">
                                        <?php if($creditapprovalstatus!='approved') { ?>
                                            <select name="invoice" id="invoice" class="billing-select" onChange="if (this.value) window.open(this.value, '_blank')">
                                                <option value="">Select Action</option>
                                                <option value="ipinteriminvoiceserver.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&menuid=<?php echo $menu_id; ?>">Interim</option>
                                                <option value="depositform1.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&menuid=<?php echo $menu_id; ?>">Redeposit</option>
                                                <option value="nhifprocessing.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&menuid=<?php echo $menu_id; ?>">NHIF</option>
                                                <option value="ipmiscbilling.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&menuid=<?php echo $menu_id; ?>">Misc Billing</option>
                                                <option value="ipfinalinvoice.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&menuid=<?php echo $menu_id; ?>">Final</option>
                                            </select>
                                        <?php } elseif($creditapprovalstatus=='approved' && $creditnum==0) { ?>
                                            <a href="ipinteriminvoiceserver.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&menuid=" class="btn-action btn-interim">Interim</a>
                                        <?php } elseif($creditnum>0) { ?>
                                            <a href="ipapprovedcreditform.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&menuid=<?php echo $menu_id; ?>" class="btn-action btn-finalize">Finalize</a>
                                        <?php } ?>
                                    </td>
                                    <td class="approval-cell">
                                        <?php if($status == 'Discharged' && $creditapprovalstatus!='approved' && $total>0) { ?>
                                            <a href="creditapprovalrequest.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&menuid=<?php echo $menu_id; ?>" class="btn-action btn-request">Request</a>
                                        <?php } elseif($status == 'Discharged' && $creditapprovalstatus=='approved' && $creditnum==0) { ?>
                                            <span class="status-badge status-pending">Sent for Approval</span>
                                        <?php } elseif($creditnum>0) { ?>
                                            <span class="status-badge status-approved">Approved</span>
                                        <?php } ?>
                                    </td>
                                </tr>
		  <?php
		  }
		  }
           ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php } ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/ipbilling-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>

