<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d');
$paymentreceiveddateto = date('Y-m-d');

// Initialize variables
$searchsuppliername = '';
$suppliername = '';
$cbsuppliername = '';
$cbcustomername = '';
$cbbillnumber = '';
$cbbillstatus = '';
$colorloopcount = '';
$sno = '';
$snocount = '';
$visitcode1 = '';
$total = '0.00';
$refexternal = 0;
$looptotalpaidamount = '0.00';
$looptotalpendingamount = '0.00';
$looptotalwriteoffamount = '0.00';
$looptotalcashamount = '0.00';
$looptotalcreditamount = '0.00';
$looptotalcardamount = '0.00';
$looptotalonlineamount = '0.00';
$looptotalchequeamount = '0.00';
$looptotaltdsamount = '0.00';
$looptotalwriteoffamount = '0.00';
$pendingamount = '0.00';
$accountname = '';
$rowtot1 = 0;
$rowtot2 = 0;
$rowtot3 = 0;
$holetotal1 = 0;

// Get form parameters
$accountname = isset($_REQUEST["accountname"]) ? $_REQUEST["accountname"] : "";
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';

$cbfrmflag1 = isset($_REQUEST["cbfrmflag1"]) ? $_REQUEST["cbfrmflag1"] : "";

if ($cbfrmflag1 == 'cbfrmflag1') {
    $paymentreceiveddatefrom = $_REQUEST['ADate1'];
    $paymentreceiveddateto = $_REQUEST['ADate2'];
}

$ADate1 = isset($_REQUEST["ADate1"]) ? $_REQUEST["ADate1"] : "";
$ADate2 = isset($_REQUEST["ADate2"]) ? $_REQUEST["ADate2"] : "";

// Revenue calculation variables
$res2consultationamount = 0;
$res8pharmacyitemrate = 0;
$res14labitemrate = 0;
$res15radiologyitemrate = 0;
$res16servicesitemrate = 0;
$res17pharmacyitemrate = 0;
$res18admissionfee = 0;
$res19ippackage = 0;
$res20bed = 0;
$res21nursing = 0;
$res22rmo = 0;
$res23lab = 0;
$res24radiology = 0;
$res25pharmacy = 0;
$res26services = 0;
$res27ambulance = 0;
$res28homecare = 0;
$res29privatedoctor = 0;
$res30miscbilling = 0;
$res31discount = 0;
$res32rebate = 0;
$res33others = 0;

// Process revenue calculations if form is submitted
if ($cbfrmflag1 == 'cbfrmflag1') {
    $cbcustomername = isset($_REQUEST["cbcustomername"]) ? $_REQUEST["cbcustomername"] : "";
    $customername = isset($_REQUEST["customername"]) ? $_REQUEST["customername"] : "";
    $cbbillnumber = isset($_REQUEST["cbbillnumber"]) ? $_REQUEST["cbbillnumber"] : "";
    $cbbillstatus = isset($_REQUEST["cbbillstatus"]) ? $_REQUEST["cbbillstatus"] : "";
    
    if ($location == 'All') {
        $pass_location = "locationcode !=''";
    } else {
        $pass_location = "locationcode ='$location'";
    }
    
    $transactiondatefrom = $_REQUEST['ADate1'];
    $transactiondateto = $_REQUEST['ADate2'];
    $fromdate = $_REQUEST['ADate1'];
    $todate = $_REQUEST['ADate2'];
    
    // Calculate consultation revenue
    $query1 = "select sum(billamount1) as billamount1 from (
        select sum(consultation) as billamount1 from billing_consultation where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'  
        UNION ALL
        select sum(totalamount) as billamount1 from billing_paylaterconsultation where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto' and accountname = 'CASH - HOSPITAL'
        ) as billamount";
    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res1 = mysqli_fetch_array($exec1);
    $res1consultationamount = $res1['billamount1'] ?: 0;

    // Credit consultation
    $query1 = "select SUM(totalamount) AS billamount1 from billing_paylaterconsultation where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto' and accountname != 'CASH - HOSPITAL' and visitcode in (select visitcode from master_visitentry)";
    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res1 = mysqli_fetch_array($exec1)) {
        $res1billamount = $res1['billamount1'] ?: 0;
        $res2consultationamount += $res1billamount;
    }

    // Refund consultation
    $query12 = "select sum(consultation) as consultation1 from refund_consultation where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'";
    $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res12 = mysqli_fetch_array($exec12);
    $res12refundconsultation = $res12['consultation1'] ?: 0;

    $query12c = "select sum(fxamount) as consultation1 from refund_paylaterconsultation where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'";
    $exec12c = mysqli_query($GLOBALS["___mysqli_ston"], $query12c) or die ("Error in Query12c".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res12c = mysqli_fetch_array($exec12c);
    $res12crefundconsultation = $res12c['consultation1'] ?: 0;

    $query121 = "select sum(consultationfxamount) as consultation1 from billing_patientweivers where $pass_location and entrydate between '$transactiondatefrom' and '$transactiondateto'";
    $exec121 = mysqli_query($GLOBALS["___mysqli_ston"], $query121) or die ("Error in Query121".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res121 = mysqli_fetch_array($exec121);
    $res12refundconsultation1 = $res121['consultation1'] ?: 0;

    $res12refundconsultation = $res12refundconsultation + $res12crefundconsultation + $res12refundconsultation1;
    $tot_consult = $res1consultationamount + $res2consultationamount - $res12refundconsultation;

    // Calculate pharmacy revenue
    $query9 = "select sum(amount1) as amount1 from (
        select sum(fxamount) as amount1 from billing_paynowpharmacy where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto' 
        UNION ALL
        select sum(amount) as amount1 from billing_paylaterpharmacy where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto' and accountname = 'CASH - HOSPITAL'
        ) as amount1";
    $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res9 = mysqli_fetch_array($exec9);
    $res9pharmacyitemrate = $res9['amount1'] ?: 0;

    // Credit pharmacy
    $query8 = "select SUM(fxamount) AS amount1 from billing_paylaterpharmacy where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto' and accountname != 'CASH - HOSPITAL' and patientvisitcode in (select visitcode from master_visitentry)";
    $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res8 = mysqli_fetch_array($exec8)) {
        $res8pharmacyamount = $res8['amount1'] ?: 0;
        $res8pharmacyitemrate += $res8pharmacyamount;
    }

    // External pharmacy
    $query17 = "select sum(amount) as amount1 from billing_externalpharmacy where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'";
    $exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query17".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res17 = mysqli_fetch_array($exec17);
    $res17pharmacyitemrate = $res17['amount1'] ?: 0;

    // Refund pharmacy
    $query21 = "select sum(amount) as amount1 from refund_paylaterpharmacy where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'";
    $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res21 = mysqli_fetch_array($exec21);
    $res21refundlabitemrate = $res21['amount1'] ?: 0;

    $query22 = "select sum(amount) as amount1 from refund_paynowpharmacy where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'";
    $exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res22 = mysqli_fetch_array($exec22);
    $res22refundlabitemrate = $res22['amount1'] ?: 0;

    $res21refundlabitemrate = $res21refundlabitemrate + $res22refundlabitemrate;
    $tot_pharmacy = $res9pharmacyitemrate + $res8pharmacyitemrate + $res17pharmacyitemrate - $res21refundlabitemrate;

    // Calculate lab revenue
    $query13 = "select sum(amount1) as amount1 from (
        select sum(fxamount) as amount1 from billing_paynowlab where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto' 
        UNION ALL
        select sum(amount) as amount1 from billing_paylaterlab where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto' and accountname = 'CASH - HOSPITAL'
        ) as amount1";
    $exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res13 = mysqli_fetch_array($exec13);
    $res13labitemrate = $res13['amount1'] ?: 0;

    // Credit lab
    $query14 = "select SUM(fxamount) AS amount1 from billing_paylaterlab where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto' and accountname != 'CASH - HOSPITAL' and patientvisitcode in (select visitcode from master_visitentry)";
    $exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in query14".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res14 = mysqli_fetch_array($exec14)) {
        $res14labamount = $res14['amount1'] ?: 0;
        $res14labitemrate += $res14labamount;
    }

    // External lab
    $query15 = "select sum(amount) as amount1 from billing_externallab where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'";
    $exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res15 = mysqli_fetch_array($exec15);
    $res15labitemrate = $res15['amount1'] ?: 0;

    // Refund lab
    $query23 = "select sum(amount) as amount1 from refund_paylaterlab where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'";
    $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res23 = mysqli_fetch_array($exec23);
    $res23refundlabitemrate = $res23['amount1'] ?: 0;

    $query24 = "select sum(amount) as amount1 from refund_paynowlab where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'";
    $exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res24 = mysqli_fetch_array($exec24);
    $res24refundlabitemrate = $res24['amount1'] ?: 0;

    $res23refundlabitemrate = $res23refundlabitemrate + $res24refundlabitemrate;
    $tot_lab = $res13labitemrate + $res14labitemrate + $res15labitemrate - $res23refundlabitemrate;

    // Calculate radiology revenue
    $query25 = "select sum(amount1) as amount1 from (
        select sum(fxamount) as amount1 from billing_paynowradiology where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto' 
        UNION ALL
        select sum(amount) as amount1 from billing_paylaterradiology where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto' and accountname = 'CASH - HOSPITAL'
        ) as amount1";
    $exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res25 = mysqli_fetch_array($exec25);
    $res25radiologyitemrate = $res25['amount1'] ?: 0;

    // Credit radiology
    $query26 = "select SUM(fxamount) AS amount1 from billing_paylaterradiology where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto' and accountname != 'CASH - HOSPITAL' and patientvisitcode in (select visitcode from master_visitentry)";
    $exec26 = mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die ("Error in query26".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res26 = mysqli_fetch_array($exec26)) {
        $res26radiologyamount = $res26['amount1'] ?: 0;
        $res26radiologyitemrate += $res26radiologyamount;
    }

    // External radiology
    $query27 = "select sum(amount) as amount1 from billing_externalradiology where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'";
    $exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query27".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res27 = mysqli_fetch_array($exec27);
    $res27radiologyitemrate = $res27['amount1'] ?: 0;

    // Refund radiology
    $query28 = "select sum(amount) as amount1 from refund_paylaterradiology where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'";
    $exec28 = mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die ("Error in Query28".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res28 = mysqli_fetch_array($exec28);
    $res28refundradiologyitemrate = $res28['amount1'] ?: 0;

    $query29 = "select sum(amount) as amount1 from refund_paynowradiology where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'";
    $exec29 = mysqli_query($GLOBALS["___mysqli_ston"], $query29) or die ("Error in Query29".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res29 = mysqli_fetch_array($exec29);
    $res29refundradiologyitemrate = $res29['amount1'] ?: 0;

    $res28refundradiologyitemrate = $res28refundradiologyitemrate + $res29refundradiologyitemrate;
    $tot_radiology = $res25radiologyitemrate + $res26radiologyitemrate + $res27radiologyitemrate - $res28refundradiologyitemrate;

    // Calculate services revenue
    $query30 = "select sum(amount1) as amount1 from (
        select sum(fxamount) as amount1 from billing_paynowservices where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto' 
        UNION ALL
        select sum(amount) as amount1 from billing_paylaterservices where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto' and accountname = 'CASH - HOSPITAL'
        ) as amount1";
    $exec30 = mysqli_query($GLOBALS["___mysqli_ston"], $query30) or die ("Error in Query30".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res30 = mysqli_fetch_array($exec30);
    $res30servicesitemrate = $res30['amount1'] ?: 0;

    // Credit services
    $query31 = "select SUM(fxamount) AS amount1 from billing_paylaterservices where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto' and accountname != 'CASH - HOSPITAL' and patientvisitcode in (select visitcode from master_visitentry)";
    $exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in query31".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res31 = mysqli_fetch_array($exec31)) {
        $res31servicesamount = $res31['amount1'] ?: 0;
        $res31servicesitemrate += $res31servicesamount;
    }

    // External services
    $query32 = "select sum(amount) as amount1 from billing_externalservices where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'";
    $exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query32".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res32 = mysqli_fetch_array($exec32);
    $res32servicesitemrate = $res32['amount1'] ?: 0;

    // Refund services
    $query33 = "select sum(amount) as amount1 from refund_paylaterservices where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'";
    $exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res33 = mysqli_fetch_array($exec33);
    $res33refundservicesitemrate = $res33['amount1'] ?: 0;

    $query34 = "select sum(amount) as amount1 from refund_paynowservices where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'";
    $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die ("Error in Query34".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res34 = mysqli_fetch_array($exec34);
    $res34refundservicesitemrate = $res34['amount1'] ?: 0;

    $res33refundservicesitemrate = $res33refundservicesitemrate + $res34refundservicesitemrate;
    $tot_services = $res30servicesitemrate + $res31servicesitemrate + $res32servicesitemrate - $res33refundservicesitemrate;

    // Calculate total revenue
    $total_revenue = $tot_consult + $tot_pharmacy + $tot_lab + $tot_radiology + $tot_services;
}

// Get location name for display
$res1location = '';
if ($location != '') {
    $query12 = "select locationname from master_location where locationcode='$location' order by locationname";
    $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res12 = mysqli_fetch_array($exec12);
    $res1location = $res12["locationname"];
} else {
    $query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res1 = mysqli_fetch_array($exec1);
    $res1location = $res1["locationname"];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Revenue Report - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/hospitalrevenuereport-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date picker styles -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- JavaScript files -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/datetimepicker_css.js"></script>
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
        <a href="reports.php">📊 Reports</a>
        <span>→</span>
        <span>Hospital Revenue Report</span>
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
                        <a href="reports.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Reports</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="hospitalrevenuereport.php" class="nav-link">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Revenue Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="financialreports.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Financial Reports</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Hospital Revenue Report</h2>
                    <p>Comprehensive revenue analysis and financial reporting for hospital operations.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="printReport()">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>

            <!-- Report Filter Form -->
            <div class="filter-section">
                <div class="filter-header">
                    <i class="fas fa-filter filter-icon"></i>
                    <h3 class="filter-title">Report Filters</h3>
                </div>
                
                <form name="cbform1" method="post" action="hospitalrevenuereport.php" class="filter-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label required">Date From</label>
                            <div class="input-group">
                                <input name="ADate1" id="ADate1" value="<?php echo htmlspecialchars($paymentreceiveddatefrom); ?>" 
                                       class="form-input" size="10" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <span class="input-icon" onClick="javascript:NewCssCal('ADate1')">
                                    <i class="fas fa-calendar-alt"></i>
                                </span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label required">Date To</label>
                            <div class="input-group">
                                <input name="ADate2" id="ADate2" value="<?php echo htmlspecialchars($paymentreceiveddateto); ?>" 
                                       class="form-input" size="10" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <span class="input-icon" onClick="javascript:NewCssCal('ADate2')">
                                    <i class="fas fa-calendar-alt"></i>
                                </span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" onChange="ajaxlocationfunction(this.value);" class="form-select">
                                <option value="All">All Locations</option>
                                <?php
                                $query01 = "select locationcode, locationname from master_location where status='' group by locationcode";
                                $exc01 = mysqli_query($GLOBALS["___mysqli_ston"], $query01);
                                while($res01 = mysqli_fetch_array($exc01)) {
                                    $selected = ($location == $res01['locationcode']) ? 'selected' : '';
                                    echo '<option value="' . htmlspecialchars($res01['locationcode']) . '" ' . $selected . '>' . htmlspecialchars($res01['locationname']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Generate Report
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Report Results -->
            <?php if ($cbfrmflag1 == 'cbfrmflag1'): ?>
            <div class="report-section">
                <div class="report-header">
                    <i class="fas fa-chart-line report-icon"></i>
                    <h3 class="report-title">Hospital Revenue Report</h3>
                    <p class="report-period">
                        From <?php echo date('d-M-Y', strtotime($ADate1)); ?> To <?php echo date('d-M-Y', strtotime($ADate2)); ?>
                        <?php if ($res1location): ?>
                            <span class="location-badge">📍 <?php echo htmlspecialchars($res1location); ?></span>
                        <?php endif; ?>
                    </p>
                </div>
                
                <!-- Revenue Summary Cards -->
                <div class="revenue-cards">
                    <div class="revenue-card consultation">
                        <div class="card-icon">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div class="card-content">
                            <h4>Consultation</h4>
                            <div class="card-amount"><?php echo number_format($tot_consult, 2, '.', ','); ?></div>
                        </div>
                    </div>
                    
                    <div class="revenue-card pharmacy">
                        <div class="card-icon">
                            <i class="fas fa-pills"></i>
                        </div>
                        <div class="card-content">
                            <h4>Pharmacy</h4>
                            <div class="card-amount"><?php echo number_format($tot_pharmacy, 2, '.', ','); ?></div>
                        </div>
                    </div>
                    
                    <div class="revenue-card lab">
                        <div class="card-icon">
                            <i class="fas fa-flask"></i>
                        </div>
                        <div class="card-content">
                            <h4>Laboratory</h4>
                            <div class="card-amount"><?php echo number_format($tot_lab, 2, '.', ','); ?></div>
                        </div>
                    </div>
                    
                    <div class="revenue-card radiology">
                        <div class="card-icon">
                            <i class="fas fa-x-ray"></i>
                        </div>
                        <div class="card-content">
                            <h4>Radiology</h4>
                            <div class="card-amount"><?php echo number_format($tot_radiology, 2, '.', ','); ?></div>
                        </div>
                    </div>
                    
                    <div class="revenue-card services">
                        <div class="card-icon">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <div class="card-content">
                            <h4>Services</h4>
                            <div class="card-amount"><?php echo number_format($tot_services, 2, '.', ','); ?></div>
                        </div>
                    </div>
                    
                    <div class="revenue-card total">
                        <div class="card-icon">
                            <i class="fas fa-calculator"></i>
                        </div>
                        <div class="card-content">
                            <h4>Total Revenue</h4>
                            <div class="card-amount"><?php echo number_format($total_revenue, 2, '.', ','); ?></div>
                        </div>
                    </div>
                </div>
                
                <!-- Detailed Revenue Table -->
                <div class="table-section">
                    <div class="table-header">
                        <h4>Detailed Revenue Breakdown</h4>
                        <div class="table-actions">
                            <button type="button" class="btn btn-sm btn-outline" onclick="exportToExcel()">
                                <i class="fas fa-file-excel"></i> Export Excel
                            </button>
                            <button type="button" class="btn btn-sm btn-outline" onclick="exportToPDF()">
                                <i class="fas fa-file-pdf"></i> Export PDF
                            </button>
                        </div>
                    </div>
                    
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Revenue Category</th>
                                    <th>Cash</th>
                                    <th>Credit</th>
                                    <th>External</th>
                                    <th>Refunds</th>
                                    <th>Net Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="category-cell">
                                        <i class="fas fa-user-md"></i>
                                        <span>Consultation</span>
                                    </td>
                                    <td class="amount-cell"><?php echo number_format($res1consultationamount, 2, '.', ','); ?></td>
                                    <td class="amount-cell"><?php echo number_format($res2consultationamount, 2, '.', ','); ?></td>
                                    <td class="amount-cell">-</td>
                                    <td class="amount-cell refund">-<?php echo number_format($res12refundconsultation, 2, '.', ','); ?></td>
                                    <td class="amount-cell total"><?php echo number_format($tot_consult, 2, '.', ','); ?></td>
                                </tr>
                                
                                <tr>
                                    <td class="category-cell">
                                        <i class="fas fa-pills"></i>
                                        <span>Pharmacy</span>
                                    </td>
                                    <td class="amount-cell"><?php echo number_format($res9pharmacyitemrate, 2, '.', ','); ?></td>
                                    <td class="amount-cell"><?php echo number_format($res8pharmacyitemrate, 2, '.', ','); ?></td>
                                    <td class="amount-cell"><?php echo number_format($res17pharmacyitemrate, 2, '.', ','); ?></td>
                                    <td class="amount-cell refund">-<?php echo number_format($res21refundlabitemrate, 2, '.', ','); ?></td>
                                    <td class="amount-cell total"><?php echo number_format($tot_pharmacy, 2, '.', ','); ?></td>
                                </tr>
                                
                                <tr>
                                    <td class="category-cell">
                                        <i class="fas fa-flask"></i>
                                        <span>Laboratory</span>
                                    </td>
                                    <td class="amount-cell"><?php echo number_format($res13labitemrate, 2, '.', ','); ?></td>
                                    <td class="amount-cell"><?php echo number_format($res14labitemrate, 2, '.', ','); ?></td>
                                    <td class="amount-cell"><?php echo number_format($res15labitemrate, 2, '.', ','); ?></td>
                                    <td class="amount-cell refund">-<?php echo number_format($res23refundlabitemrate, 2, '.', ','); ?></td>
                                    <td class="amount-cell total"><?php echo number_format($tot_lab, 2, '.', ','); ?></td>
                                </tr>
                                
                                <tr>
                                    <td class="category-cell">
                                        <i class="fas fa-x-ray"></i>
                                        <span>Radiology</span>
                                    </td>
                                    <td class="amount-cell"><?php echo number_format($res25radiologyitemrate, 2, '.', ','); ?></td>
                                    <td class="amount-cell"><?php echo number_format($res26radiologyitemrate, 2, '.', ','); ?></td>
                                    <td class="amount-cell"><?php echo number_format($res27radiologyitemrate, 2, '.', ','); ?></td>
                                    <td class="amount-cell refund">-<?php echo number_format($res28refundradiologyitemrate, 2, '.', ','); ?></td>
                                    <td class="amount-cell total"><?php echo number_format($tot_radiology, 2, '.', ','); ?></td>
                                </tr>
                                
                                <tr>
                                    <td class="category-cell">
                                        <i class="fas fa-cogs"></i>
                                        <span>Services</span>
                                    </td>
                                    <td class="amount-cell"><?php echo number_format($res30servicesitemrate, 2, '.', ','); ?></td>
                                    <td class="amount-cell"><?php echo number_format($res31servicesitemrate, 2, '.', ','); ?></td>
                                    <td class="amount-cell"><?php echo number_format($res32servicesitemrate, 2, '.', ','); ?></td>
                                    <td class="amount-cell refund">-<?php echo number_format($res33refundservicesitemrate, 2, '.', ','); ?></td>
                                    <td class="amount-cell total"><?php echo number_format($tot_services, 2, '.', ','); ?></td>
                                </tr>
                                
                                <tr class="total-row">
                                    <td class="category-cell">
                                        <i class="fas fa-calculator"></i>
                                        <span><strong>Grand Total</strong></span>
                                    </td>
                                    <td class="amount-cell total">
                                        <strong><?php echo number_format($res1consultationamount + $res9pharmacyitemrate + $res13labitemrate + $res25radiologyitemrate + $res30servicesitemrate, 2, '.', ','); ?></strong>
                                    </td>
                                    <td class="amount-cell total">
                                        <strong><?php echo number_format($res2consultationamount + $res8pharmacyitemrate + $res14labitemrate + $res26radiologyitemrate + $res31servicesitemrate, 2, '.', ','); ?></strong>
                                    </td>
                                    <td class="amount-cell total">
                                        <strong><?php echo number_format($res17pharmacyitemrate + $res15labitemrate + $res27radiologyitemrate + $res32servicesitemrate, 2, '.', ','); ?></strong>
                                    </td>
                                    <td class="amount-cell total refund">
                                        <strong>-<?php echo number_format($res12refundconsultation + $res21refundlabitemrate + $res23refundlabitemrate + $res28refundradiologyitemrate + $res33refundservicesitemrate, 2, '.', ','); ?></strong>
                                    </td>
                                    <td class="amount-cell total">
                                        <strong><?php echo number_format($total_revenue, 2, '.', ','); ?></strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/hospitalrevenuereport-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
