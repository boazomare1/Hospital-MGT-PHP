<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedate = date('Y-m-d');
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$fromdate = date('Y-m-d');
$todate = date('Y-m-d');
$snocount = "";
$colorloopcount = "";
$totalcollection = 0;
$totalrevenue = 0;
$totalpercentage = 0;

// Handle form parameters
if(isset($_REQUEST['locationcode'])){ 
    $locationcode = $_REQUEST['locationcode']; 
} else { 
    $locationcode = ''; 
}

if(isset($_REQUEST['ADate1'])){ 
    $ADate1 = $_REQUEST['ADate1']; 
    $fromdate = $_REQUEST['ADate1']; 
} else { 
    $ADate1 = ''; 
    $fromdate = date('Y-m-d'); 
}

if(isset($_REQUEST['ADate2'])){ 
    $ADate2 = $_REQUEST['ADate2']; 
    $todate = $_REQUEST['ADate2']; 
} else { 
    $ADate2 = ''; 
    $todate = date('Y-m-d'); 
}

if(isset($_REQUEST['searchsuppliername1'])){ 
    $searchsuppliername = $_REQUEST['searchsuppliername1']; 
} else { 
    $searchsuppliername = ''; 
}

if(isset($_REQUEST['searchsubtypeanum1'])){ 
    $searchsubtypeanum1 = $_REQUEST['searchsubtypeanum1']; 
} else { 
    $searchsubtypeanum1 = ''; 
}

if(isset($_REQUEST['bytype'])){ 
    $bytype = $_REQUEST['bytype']; 
} else { 
    $bytype = ''; 
}

// Process form submission
$showResults = false;
if(isset($_POST['Submit'])) {
    $showResults = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fill Rates Report - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/fillratesreport-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Autocomplete CSS -->
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <!-- Date Picker Scripts -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    
    <!-- Autocomplete Scripts -->
    <script type="text/javascript" src="js/autocomplete_subtype_fillrate.js"></script>
    <script type="text/javascript" src="js/autosuggestsubtype_fillrate.js"></script>
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
        <span>Reports</span>
        <span>→</span>
        <span>Fill Rates Report</span>
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
                    <li class="nav-item active">
                        <a href="fillratesreport.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Fill Rates Report</span>
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
                    <h2>Fill Rates Report</h2>
                    <p>Analyze pharmacy fill rates, approval percentages, and amendment statistics for better operational insights.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-download"></i> Export Excel
                    </button>
                </div>
            </div>

            <!-- Search Form Section -->
            <div class="search-form-section">
                <div class="search-form-header">
                    <i class="fas fa-search search-form-icon"></i>
                    <h3 class="search-form-title">Report Parameters</h3>
                </div>
                
                <form id="searchForm" name="cbform1" method="post" action="fillratesreport.php" class="search-form">
                    <div class="form-group">
                        <label for="locationcode" class="form-label">Location</label>
                        <select name="locationcode" id="locationcode" class="form-input">
                            <option value="">All Locations</option>
                            <?php
                            $query1 = "select * from master_location order by locationname";
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res1 = mysqli_fetch_array($exec1)) {
                                $locationname = $res1["locationname"];
                                $locationcode1 = $res1["locationcode"];
                                $selected = ($locationcode != '' && $locationcode == $locationcode1) ? 'selected' : '';
                                ?>
                                <option value="<?php echo $locationcode1; ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($locationname); ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group full-width">
                        <label class="form-label">Report Type</label>
                        <div class="radio-group">
                            <div class="radio-item">
                                <input type="radio" name="bytype" id="bytype1" value="0" <?php echo ($bytype == '0' || $bytype == '') ? 'checked' : ''; ?>>
                                <label for="bytype1">All Providers</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" name="bytype" id="bytype2" value="1" <?php echo ($bytype == '1') ? 'checked' : ''; ?>>
                                <label for="bytype2">Specific Provider</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="searchsuppliername1" class="form-label">Provider Search</label>
                        <input type="text" name="searchsuppliername1" id="searchsuppliername1" 
                               class="form-input" value="<?php echo htmlspecialchars($searchsuppliername); ?>" 
                               placeholder="Search Provider Here" autocomplete="off" 
                               <?php echo ($bytype == '0' || $bytype == '') ? 'readonly' : ''; ?>>
                        <input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">
                        <input name="searchsubtypeanum1" id="searchsubtypeanum1" value="<?php echo $searchsubtypeanum1; ?>" type="hidden">
                        <input type="hidden" name="searchpaymentcode" id="searchpaymentcode" value="<?php echo $bytype; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="ADate1" class="form-label">Date From</label>
                        <input name="ADate1" id="ADate1" class="form-input" 
                               value="<?php echo $fromdate; ?>" readonly="readonly" 
                               onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer; margin-left: 5px;"/>
                    </div>
                    
                    <div class="form-group">
                        <label for="ADate2" class="form-label">Date To</label>
                        <input name="ADate2" id="ADate2" class="form-input" 
                               value="<?php echo $todate; ?>" readonly="readonly" 
                               onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer; margin-left: 5px;"/>
                    </div>
                    
                    <div class="form-group full-width">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" name="Submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Generate Report
                        </button>
                        <button name="resetbutton" type="reset" id="resetbutton" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <?php if($showResults): ?>
            <!-- Report Results Section -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-chart-bar data-table-icon"></i>
                    <h3 class="data-table-title">Fill Rate Report Results</h3>
                </div>

                <?php if($bytype == '0'): ?>
                    <!-- All Providers Report -->
                    <?php
                    if($locationcode == ''){
                        $locationcodenew = "and locationcode like '%%'";
                        $locationcodenew1 = "and visitcode like '%OPV-%'";
                    } else {
                        $locationcodenew = "and locationcode = '$locationcode'";
                        
                        $query12 = "select auto_number from master_location where locationcode='$locationcode' order by locationname";
                        $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $res12 = mysqli_fetch_array($exec12);
                        $loctid = $res12["auto_number"];
                        $locationcodenew1 = "and visitcode like '%-$loctid'";
                    }
                    
                    $totdrugord = 0;
                    $totapproved = 0;
                    $totamended = 0;
                    $totissued = 0;
                    
                    $queryn21 = "
                    select count(auto_number) as drugordered,'0' as approved ,'0' as amended,'0' as issued  from master_consultationpharm where recorddate between '$ADate1' and '$ADate2' $locationcodenew
                    UNION ALL
                    select '0' as drugordered,count(auto_number) as approved,'0' as amended,'0' as issued   from master_consultationpharm where recorddate between '$ADate1' and '$ADate2' $locationcodenew and amendstatus='2'
                    UNION ALL 
                    select '0' as drugordered,'0' as approved,count(auto_number) as amended,'0' as issued from amendment_details where amenddate between '$ADate1' and '$ADate2' $locationcodenew1 and amendfrom='Pharmacy' and visitcode like 'OPV-%'
                    UNION ALL
                    select '0' as drugordered,'0' as approved,'0' as amended,count(auto_number) as issued  from master_consultationpharm where recorddate between '$ADate1' and '$ADate2' $locationcodenew and medicineissue='completed'	
                    ";
                    $execn21 = mysqli_query($GLOBALS["___mysqli_ston"], $queryn21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($res23 = mysqli_fetch_array($execn21)){
                        $totdrugord += $res23['drugordered'];
                        $totapproved += $res23['approved'];
                        $totamended += $res23['amended'];
                        $totissued += $res23['issued'];
                    }
                    
                    $approvedPercentage = $totdrugord > 0 ? ($totapproved / $totdrugord) * 100 : 0;
                    $amendedPercentage = $totdrugord > 0 ? ($totamended / $totdrugord) * 100 : 0;
                    $fillRatePercentage = $totdrugord > 0 ? ($totissued / $totdrugord) * 100 : 0;
                    ?>
                    
                    <!-- Summary Cards -->
                    <div class="report-summary">
                        <div class="summary-card">
                            <h3>Drugs Ordered</h3>
                            <div class="value"><?php echo number_format($totdrugord, 0, '.', ','); ?></div>
                        </div>
                        <div class="summary-card">
                            <h3>Approved</h3>
                            <div class="value"><?php echo number_format($totapproved, 0, '.', ','); ?></div>
                            <div class="percentage"><?php echo number_format($approvedPercentage, 2, '.', ','); ?>%</div>
                        </div>
                        <div class="summary-card">
                            <h3>Amended</h3>
                            <div class="value"><?php echo number_format($totamended, 0, '.', ','); ?></div>
                            <div class="percentage"><?php echo number_format($amendedPercentage, 2, '.', ','); ?>%</div>
                        </div>
                        <div class="summary-card">
                            <h3>Issued</h3>
                            <div class="value"><?php echo number_format($totissued, 0, '.', ','); ?></div>
                            <div class="percentage"><?php echo number_format($fillRatePercentage, 2, '.', ','); ?>%</div>
                        </div>
                    </div>

                    <!-- Detailed Table -->
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Metric</th>
                                <th>Drugs Ordered</th>
                                <th>Approved</th>
                                <th>Amended</th>
                                <th>Issued</th>
                                <th>Approved %</th>
                                <th>Amend %</th>
                                <th>Fill Rate %</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Total</strong></td>
                                <td><?php echo number_format($totdrugord, 0, '.', ','); ?></td>
                                <td><?php echo number_format($totapproved, 0, '.', ','); ?></td>
                                <td><?php echo number_format($totamended, 0, '.', ','); ?></td>
                                <td><?php echo number_format($totissued, 0, '.', ','); ?></td>
                                <td><?php echo number_format($approvedPercentage, 2, '.', ','); ?>%</td>
                                <td><?php echo number_format($amendedPercentage, 2, '.', ','); ?>%</td>
                                <td><?php echo number_format($fillRatePercentage, 2, '.', ','); ?>%</td>
                            </tr>
                        </tbody>
                    </table>

                <?php elseif($bytype == '1'): ?>
                    <!-- Provider-specific Report -->
                    <?php
                    if($locationcode == ''){
                        $locationcodenew = "and a.locationcode like '%%'";
                        $locationcodenew1 = "and a.visitcode like '%OPV-%'";
                    } else {
                        $locationcodenew = "and a.locationcode = '$locationcode'";
                        
                        $query12 = "select auto_number from master_location where locationcode='$locationcode' order by locationname";
                        $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $res12 = mysqli_fetch_array($exec12);
                        $loctid = $res12["auto_number"];
                        $locationcodenew1 = "and a.visitcode like '%-$loctid'";
                    }
                    
                    if($searchsuppliername != ''){
                        $query25 = "select auto_number,subtype from master_subtype where auto_number = '$searchsubtypeanum1'";
                    } else {
                        $query25 = "select auto_number,subtype from master_subtype";
                    }
                    $exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $hasData = false;
                    ?>
                    
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Provider</th>
                                <th>Drugs Ordered</th>
                                <th>Approved</th>
                                <th>Amended</th>
                                <th>Issued</th>
                                <th>Approved %</th>
                                <th>Amend %</th>
                                <th>Fill Rate %</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while($res25 = mysqli_fetch_array($exec25)) {
                                $searchsubtypeanum1 = $res25['auto_number'];
                                $searchsubtype = $res25['subtype'];
                                
                                $totdrugord = 0;
                                $totapproved = 0;
                                $totamended = 0;
                                $totissued = 0;
                                
                                $queryn21 = "
                                select count(a.patientvisitcode) as drugordered,'0' as approved ,'0' as amended,'0' as issued  from master_consultationpharm as a join master_visitentry as b on a.patientvisitcode=b.visitcode where a.recorddate between '$ADate1' and '$ADate2' $locationcodenew and b.subtype='$searchsubtypeanum1'
                                UNION ALL
                                select '0' as drugordered,count(a.patientvisitcode) as approved,'0' as amended,'0' as issued   from master_consultationpharm as a join master_visitentry as b on a.patientvisitcode=b.visitcode where a.recorddate between '$ADate1' and '$ADate2' $locationcodenew and a.amendstatus='2'  and b.subtype='$searchsubtypeanum1'
                                UNION ALL 
                                select '0' as drugordered,'0' as approved,count(a.visitcode) as amended,'0' as issued from amendment_details as a join master_visitentry as b on a.visitcode=b.visitcode  where a.amenddate between '$ADate1' and '$ADate2' $locationcodenew1 and a.amendfrom='Pharmacy' and a.visitcode like 'OPV-%' and b.subtype='$searchsubtypeanum1'
                                UNION ALL
                                select '0' as drugordered,'0' as approved,'0' as amended,count(a.patientvisitcode) as issued  from master_consultationpharm as a join master_visitentry as b on a.patientvisitcode=b.visitcode where a.recorddate between '$ADate1' and '$ADate2' $locationcodenew and a.medicineissue='completed'  and b.subtype='$searchsubtypeanum1'	
                                ";
                                $execn21 = mysqli_query($GLOBALS["___mysqli_ston"], $queryn21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($res23 = mysqli_fetch_array($execn21)){
                                    $totdrugord += $res23['drugordered'];
                                    $totapproved += $res23['approved'];
                                    $totamended += $res23['amended'];
                                    $totissued += $res23['issued'];
                                }
                                
                                if($totdrugord > 0){
                                    $hasData = true;
                                    $approvedPercentage = ($totapproved / $totdrugord) * 100;
                                    $amendedPercentage = ($totamended / $totdrugord) * 100;
                                    $fillRatePercentage = ($totissued / $totdrugord) * 100;
                                    ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($searchsubtype); ?></strong></td>
                                        <td><?php echo number_format($totdrugord, 0, '.', ','); ?></td>
                                        <td><?php echo number_format($totapproved, 0, '.', ','); ?></td>
                                        <td><?php echo number_format($totamended, 0, '.', ','); ?></td>
                                        <td><?php echo number_format($totissued, 0, '.', ','); ?></td>
                                        <td><?php echo number_format($approvedPercentage, 2, '.', ','); ?>%</td>
                                        <td><?php echo number_format($amendedPercentage, 2, '.', ','); ?>%</td>
                                        <td><?php echo number_format($fillRatePercentage, 2, '.', ','); ?>%</td>
                                    </tr>
                                    <?php
                                }
                            }
                            
                            if(!$hasData):
                            ?>
                            <tr>
                                <td colspan="8" class="no-data">
                                    <i class="fas fa-chart-line"></i>
                                    <h3>No Data Found</h3>
                                    <p>No fill rate data available for the selected criteria.</p>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/fillratesreport-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>

