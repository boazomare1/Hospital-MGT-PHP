<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-01');
$transactiondateto = date('Y-m-d');
$locationcode1 = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
$srwardanum = isset($_REQUEST['ward']) ? $_REQUEST['ward'] : '';
$includezeroballeg = isset($_POST["includezeroballeg"]) ? 1 : 0;
$total_hours = '00';
$total_minutes = '00';

// Check for form submission
if (isset($_REQUEST["cbfrmflag1"])) { 
    $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; 
} else { 
    $cbfrmflag1 = ""; 
}

if ($cbfrmflag1 == 'cbfrmflag1') {
    $fromdate = $_POST['ADate1'];
    $todate = $_POST['ADate2'];
    
    // Get total count for the report
    $querynw1 = "select * from ip_bedallocation where locationcode='$locationcode1' and recorddate between '$fromdate' and '$todate'";
    $execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Querynw1".mysqli_error($GLOBALS["___mysqli_ston"]));
    $resnw1 = mysqli_num_rows($execnw1);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Admission Summary Report - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/ipadmissionsummaryreport-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker CSS -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- Date Picker JavaScript -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
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
        <span>IP Admission Summary Report</span>
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
                        <a href="labitem1master.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Items</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="openingstockentry_master.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Opening Stock</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addward.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Wards</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountreceivableentrylist.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>Account Receivable</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="corporateoutstanding.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Corporate Outstanding</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountstatement.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Account Statement</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountsmain.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Accounts Main</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountssub.php" class="nav-link">
                            <i class="fas fa-chart-pie"></i>
                            <span>Accounts Sub Type</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="fixedasset_acquisition_report.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Fixed Asset Acquisition</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeinpatientlist.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Active Inpatient List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeusersreport.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Active Users Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chartofaccounts_upload.php" class="nav-link">
                            <i class="fas fa-upload"></i>
                            <span>Chart of Accounts Upload</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chartaccountsmaindataimport.php" class="nav-link">
                            <i class="fas fa-database"></i>
                            <span>Chart of Accounts Main Import</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chartaccountssubdataimport.php" class="nav-link">
                            <i class="fas fa-database"></i>
                            <span>Chart of Accounts Sub Import</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addbloodgroup.php" class="nav-link">
                            <i class="fas fa-tint"></i>
                            <span>Blood Group Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addfoodallergy1.php" class="nav-link">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Food Allergy Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addgenericname.php" class="nav-link">
                            <i class="fas fa-pills"></i>
                            <span>Generic Name Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addpromotion.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            <span>Promotion Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addsalutation1.php" class="nav-link">
                            <i class="fas fa-user-tie"></i>
                            <span>Salutation Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="vat.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>VAT Master</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="ipadmissionsummaryreport.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>IP Admission Summary Report</span>
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
                    <h2>IP Admission Summary Report</h2>
                    <p>Generate comprehensive reports for inpatient admissions with detailed analytics and statistics.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>
            </div>

            <!-- Search Form Section -->
            <div class="search-form-section">
                <div class="search-form-header">
                    <i class="fas fa-search search-form-icon"></i>
                    <h3 class="search-form-title">Search Criteria</h3>
                </div>
                
                <form name="cbform1" method="post" action="ipadmissionsummaryreport.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <div class="date-input-group">
                                <input type="text" name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>" 
                                       class="form-input date-input" readonly />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" 
                                     class="calendar-icon" alt="Calendar" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <div class="date-input-group">
                                <input type="text" name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>" 
                                       class="form-input date-input" readonly />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" 
                                     class="calendar-icon" alt="Calendar" />
                            </div>
                        </div>

                        <div class="form-group checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="includezeroballeg" id="includezeroballeg" value="1" 
                                       <?php if($includezeroballeg=='1') echo 'checked'; ?> />
                                <span class="checkmark"></span>
                                Exclude Renal
                            </label>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" class="form-input" onchange="ajaxlocationfunction(this.value)">
                                <option value="All">All Locations</option>
                                <?php
                                $query1 = "select * from master_location where status='' order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $locationname = $res1["locationname"];
                                    $locationcode = $res1["locationcode"];
                                    $selected = ($location != '' && $location == $locationcode) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $locationcode; ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($locationname); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="ward" class="form-label">Ward</label>
                            <select name="ward" id="ward" class="form-input">
                                <option value="">Select Ward</option>
                                <?php
                                $query11 = "select * from master_ward where recordstatus <> 'deleted'";
                                $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res11 = mysqli_fetch_array($exec11)) {
                                    $wardanum = $res11["auto_number"];
                                    $ward = $res11["ward"];
                                    $selected = ($srwardanum != '' && $srwardanum == $wardanum) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $wardanum; ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($ward); ?></option>
                                    <?php
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

            <!-- Report Results Section -->
            <?php if ($cbfrmflag1 == 'cbfrmflag1'): ?>
            <div class="report-results-section">
                <div class="report-header">
                    <div class="report-title">
                        <i class="fas fa-chart-bar report-icon"></i>
                        <h3>Admission Summary Report</h3>
                        <span class="report-count">Total Records: <?php echo $resnw1; ?></span>
                    </div>
                    <div class="report-actions">
                        <a href="print_ipadmissionsummaryxls.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $fromdate; ?>&&ADate2=<?php echo $todate; ?>&&locationcode=<?php echo $locationcode1; ?>&&ward=<?php echo $srwardanum; ?>&&includezeroballeg=<?php echo $includezeroballeg; ?>" 
                           class="btn btn-outline" target="_blank">
                            <i class="fas fa-file-excel"></i> Export to Excel
                        </a>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="search-bar">
                    <input type="text" id="searchInput" class="form-input" 
                           placeholder="Search patient name, code, visit code, or ward..." 
                           oninput="searchTable(this.value)">
                    <button type="button" class="btn btn-secondary" onclick="clearSearch()">
                        <i class="fas fa-times"></i> Clear
                    </button>
                </div>

                <div class="table-container">
                    <table class="data-table" id="admissionTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Location</th>
                                <th>Patient Name</th>
                                <th>Reg. No.</th>
                                <th>Gender</th>
                                <th>Age</th>
                                <th>Provider</th>
                                <th>Scheme Name</th>
                                <th>Visit Code</th>
                                <th>IP Date</th>
                                <th>DOA</th>
                                <th>Ward</th>
                                <th>Dis Status</th>
                                <th>Dis Date</th>
                                <th>Type</th>
                                <th>TAT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $colorloopcount = 0;
                            $sno = 0;
                            $valuesArray = array();
                            
                            if($locationcode1 == 'All') {
                                $locationcodenew = "locationcode like '%%'";
                            } else {
                                $locationcodenew = "locationcode = '$locationcode1'";
                            }
                            
                            if($srwardanum == '') {
                                $query1 = "select patientname,patientcode,visitcode,recorddate,docno,ward,recordstatus,leavingdate,recordtime from(select patientname,patientcode,visitcode,recorddate,docno,ward,recordstatus,leavingdate,recordtime from ip_bedallocation where $locationcodenew and recorddate between '$fromdate' and '$todate' and recordstatus in ('discharged','') 
                                union all select a.patientname,a.patientcode,a.visitcode,a.recorddate,a.docno,b.ward,b.recordstatus,b.leavingdate,null as recordtime from ip_bedallocation as a join ip_bedtransfer as b on( a.patientcode = b.patientcode and a.visitcode = b.visitcode) where a.$locationcodenew and a.recorddate between '$fromdate' and '$todate' and a.recordstatus not in ('discharged','') and b.recordstatus in ('discharged','') ) as e order by recorddate asc";
                            } else {
                                $query1 = "select patientname,patientcode,visitcode,recorddate,docno,ward,recordstatus,leavingdate,recordtime from(select patientname,patientcode,visitcode,recorddate,docno,ward,recordstatus,leavingdate,recordtime from ip_bedallocation where $locationcodenew and recorddate between '$fromdate' and '$todate' and recordstatus in ('discharged','') and ward = '$srwardanum'
                                union all select a.patientname,a.patientcode,a.visitcode,a.recorddate,a.docno,b.ward,b.recordstatus,b.leavingdate,null as recordtime from ip_bedallocation as a join ip_bedtransfer as b on( a.patientcode = b.patientcode and a.visitcode = b.visitcode) where a.$locationcodenew and a.recorddate between '$fromdate' and '$todate' and a.recordstatus not in ('discharged','') and b.recordstatus in ('discharged','') and b.ward = '$srwardanum' )as e order by recorddate asc";
                            }
                            
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            while($res1 = mysqli_fetch_array($exec1)) {
                                $patientname = $res1['patientname'];
                                $patientcode = $res1['patientcode'];
                                $visitcode = $res1['visitcode'];
                                $consultationdate = $res1['recorddate'];
                                $docnumber = $res1['docno'];
                                $ward = $res1['ward'];
                                $status = $res1['recordstatus'];
                                $iptime = $res1['recordtime'];
                                $ipdate = $res1['recorddate'];
                                
                                if($status == 'discharged') {
                                    $leavingdate = $res1['leavingdate'];
                                } else {
                                    $status = "not yet discharged";
                                    $leavingdate = '--';
                                }
                                
                                $query12 = "select * from master_ward where auto_number='$ward' ";
                                $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res12 = mysqli_fetch_array($exec12);
                                $wardname = $res12['ward'];
                                
                                $Querylab = mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
                                $execlab = mysqli_fetch_array($Querylab);
                                $patientage = $execlab['age'];
                                $patientgender = $execlab['gender'];
                                
                                $query2 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode' ";
                                $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res2 = mysqli_fetch_array($exec2);
                                $registrationdate = $res2['registrationdate'];
                                $consultationtime = $res2['consultationtime'];
                                $locationcode = $res2['locationcode'];
                                $account = $res2['accountname'];
                                $scheme_id = $res2['scheme_id'];
                                
                                $query4 = "select * from master_accountname where auto_number = '$account'"; 
                                $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                $res4 = mysqli_fetch_array($exec4);
                                $accountname = $res4['accountname'];
                                
                                $query41 = "select scheme_name from master_planname where scheme_id = '$scheme_id'"; 
                                $exec41 = mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die ("Error in Query41".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                $res41 = mysqli_fetch_array($exec41);
                                $scheme_name = $res41['scheme_name'];
                                
                                if($ipdate != '') {
                                    $diff = intval((strtotime($ipdate.' '.$iptime) - strtotime($registrationdate.' '.$consultationtime))/60);
                                    $hoursstay = intval($diff/60);
                                    $minutesstay = $diff%60;
                                    $hoursstay = abs($hoursstay);
                                    $minutesstay = abs($minutesstay);
                                    $los = $hoursstay.':'.$minutesstay;
                                    
                                    if($hoursstay >= '24') {
                                        list($hours, $minutes) = explode(':', $los);
                                        $total_seconds = ($hours * 3600) + ($minutes * 60);
                                        $days = floor($total_seconds / (60 * 60 * 24));
                                        $hours = floor(($total_seconds - ($days * 60 * 60 * 24)) / 3600);
                                        $minutes = floor(($total_seconds - ($days * 60 * 60 * 24) - ($hours * 3600)) / 60);
                                        $hours = abs($hours);
                                        $minutes = abs($minutes);
                                        $los = $days." Days ".$hours.":".$minutes;
                                    }
                                    
                                    $total_hours = $total_hours + $hoursstay;
                                    $total_minutes = $total_minutes + $minutesstay;
                                } else {
                                    $los = '';
                                }
                                
                                $searchValue = $patientcode;
                                if (in_array($searchValue, $valuesArray)) {
                                    $result = 'Revisit';
                                } else {
                                    $result = 'visit';
                                }
                                $valuesArray[] = $patientcode;
                                
                                $query211 = "select locationname from master_location where locationcode='$locationcode' ";
                                $exec211 = mysqli_query($GLOBALS["___mysqli_ston"], $query211) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res211 = mysqli_fetch_array($exec211);
                                $locationname = $res211['locationname'];
                                
                                if($wardname != 'RENAL' || $includezeroballeg != '1') {
                                    $colorloopcount = $colorloopcount + 1;
                                    $showcolor = ($colorloopcount & 1); 
                                    if ($showcolor == 0) {
                                        $colorcode = 'bgcolor="#CBDBFA"';
                                    } else {
                                        $colorcode = 'bgcolor="#ecf0f5"';
                                    }
                                    ?>
                                    <tr <?php echo $colorcode; ?>>
                                        <td class="bodytext31" valign="center" align="left">
                                            <div align="center"><?php echo $sno = $sno + 1; ?></div>
                                        </td>
                                        <td class="bodytext31" valign="center" align="left">
                                            <div align="center"><?php echo htmlspecialchars($locationname); ?></div>
                                        </td>
                                        <td class="bodytext31" valign="center" align="left">
                                            <div class="bodytext31" align="center"><?php echo htmlspecialchars($patientname); ?></div>
                                        </td>
                                        <td class="bodytext31" valign="center" align="left">
                                            <div align="center"><?php echo htmlspecialchars($patientcode); ?></div>
                                        </td>
                                        <td class="bodytext31" valign="center" align="left">
                                            <div align="center"><?php echo htmlspecialchars($patientgender); ?></div>
                                        </td>
                                        <td class="bodytext31" valign="center" align="left">
                                            <div align="center"><?php echo htmlspecialchars($patientage); ?></div>
                                        </td>
                                        <td class="bodytext31" valign="center" align="left">
                                            <div align="center"><?php echo htmlspecialchars($accountname); ?></div>
                                        </td>
                                        <td class="bodytext31" valign="center" align="left">
                                            <div align="center"><?php echo htmlspecialchars($scheme_name); ?></div>
                                        </td>
                                        <td class="bodytext31" valign="center" align="left">
                                            <div align="center">
                                                <a target="_blank" href="ipemrview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>" 
                                                   class="visit-link"><?php echo htmlspecialchars($visitcode); ?></a>
                                            </div>
                                        </td>
                                        <td class="bodytext31" valign="center" align="left">
                                            <div align="center"><?php echo htmlspecialchars($registrationdate); ?><?php echo htmlspecialchars($consultationtime); ?></div>
                                        </td>
                                        <td class="bodytext31" valign="center" align="left">
                                            <div align="center"><?php echo htmlspecialchars($ipdate); ?><?php echo htmlspecialchars($iptime); ?></div>
                                        </td>
                                        <td class="bodytext31" valign="center" align="left">
                                            <div align="center"><?php echo htmlspecialchars($wardname); ?></div>
                                        </td>
                                        <td class="bodytext31" valign="center" align="left">
                                            <div align="center"><?php echo htmlspecialchars(ucwords($status)); ?></div>
                                        </td>
                                        <td class="bodytext31" valign="center" align="left">
                                            <div align="center"><?php echo htmlspecialchars($leavingdate); ?></div>
                                        </td>
                                        <td class="bodytext31" valign="center" align="left">
                                            <div align="center"><?php echo htmlspecialchars($result); ?></div>
                                        </td>
                                        <td class="bodytext31" valign="center" align="left">
                                            <div align="center"><?php echo htmlspecialchars($los); ?></div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            
                            $total_minutes = ($total_hours * 60) + $total_minutes;
                            $minutes = $total_minutes % 60;
                            if ($minutes < 0) {
                                $minutes += 60;
                                $total_hours--;
                            }
                            $hours = floor($total_minutes / 60);
                            $total_time = sprintf("%d:%02d", $hours, $minutes);
                            
                            if($hours >= '24') {
                                list($hours, $minutes) = explode(':', $total_time);
                                $total_seconds = ($hours * 3600) + ($minutes * 60);
                                $days = floor($total_seconds / (60 * 60 * 24));
                                $hours = floor(($total_seconds - ($days * 60 * 60 * 24)) / 3600);
                                $minutes = floor(($total_seconds - ($days * 60 * 60 * 24) - ($hours * 3600)) / 60);
                                $total_time = $days." Days ".$hours.":".$minutes;
                            }
                            
                            $finaltime = $hours.":".$minutes;
                            $nofovisits = $sno;
                            list($hours, $minutes) = explode(":", $finaltime);
                            $total_minutes = ($hours * 60) + $minutes;
                            $average_time_minutes = $total_minutes / $nofovisits;
                            $average_hours = floor($average_time_minutes / 60);
                            $average_minutes = $average_time_minutes % 60;
                            $average_time = sprintf("%d:%02d", $average_hours, $average_minutes);
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Summary Section -->
                <div class="summary-section">
                    <div class="summary-row">
                        <div class="summary-item">
                            <span class="summary-label">Total TAT:</span>
                            <span class="summary-value"><?php echo $total_time; ?></span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Average TAT:</span>
                            <span class="summary-value"><?php echo $average_time; ?></span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Total Visits:</span>
                            <span class="summary-value"><?php echo $nofovisits; ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/ipadmissionsummaryreport-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>