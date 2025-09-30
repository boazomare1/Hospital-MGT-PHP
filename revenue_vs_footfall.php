<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
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
if (isset($_REQUEST['locationcode'])) { 
    $locationcode = $_REQUEST['locationcode']; 
} else { 
    $locationcode = ''; 
}

if (isset($_REQUEST['ADate1'])) { 
    $ADate1 = $_REQUEST['ADate1']; 
    $fromdate = $_REQUEST['ADate1']; 
} else { 
    $ADate1 = ''; 
    $fromdate = date('Y-m-d'); 
}

if (isset($_REQUEST['ADate2'])) { 
    $ADate2 = $_REQUEST['ADate2']; 
    $todate = $_REQUEST['ADate2']; 
} else { 
    $ADate2 = ''; 
    $todate = date('Y-m-d'); 
}

// Initialize report data
$reportData = [];
$totalFootfall = 0;
$totalRevenue = 0;
$averageValue = 0;

// Process form submission
if (isset($_POST['Submit'])) {
    // Build location filter
    if ($locationcode == '') {
        $locationcodenew = "and a.locationcode like '%%'";
    } else {
        $locationcodenew = "and a.locationcode = '$locationcode'";
    }
    
    // Get all subtypes
    $query1 = "select * from master_subtype where recordstatus <> 'deleted' and auto_number != '1'";
    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
    
    $snocount = 0;
    while ($res1 = mysqli_fetch_array($exec1)) {
        $subtypename = $res1['subtype'];
        $subtypeano = $res1['auto_number'];
        $subtype_ledger = $res1['subtype_ledger'];
        
        // Get visit count (footfall)
        $queryn211 = "select count(a.auto_number) as visitcount from master_visitentry as a JOIN master_subtype as b ON a.subtype = b.auto_number where a.consultationdate between '$ADate1' and '$ADate2' and a.billtype='PAY LATER' and b.subtype_ledger = '$subtype_ledger' $locationcodenew";
        $execn211 = mysqli_query($GLOBALS["___mysqli_ston"], $queryn211) or die ("Error in Query211" . mysqli_error($GLOBALS["___mysqli_ston"]));
        $res231 = mysqli_fetch_array($execn211);
        $visitcount = $res231['visitcount'];
        
        // Get total revenue
        $totamt = 0;
        $queryn2111 = "select sum(a.totalamount) as totamt from billing_paylater as a JOIN master_visitentry as b ON a.visitcode = b.visitcode where a.billdate between '$ADate1' and '$ADate2' and b.billtype='PAY LATER' and b.subtype = '$subtypeano' $locationcodenew";
        $execn2111 = mysqli_query($GLOBALS["___mysqli_ston"], $queryn2111) or die ("Error in Query2111" . mysqli_error($GLOBALS["___mysqli_ston"]));
        $res2311 = mysqli_fetch_array($execn2111);
        $totamt = $res2311['totamt'];
        
        // Calculate average value
        $averageValue = ($visitcount > 0) ? ($totamt / $visitcount) : 0;
        
        // Add to totals
        $totalFootfall += $visitcount;
        $totalRevenue += $totamt;
        
        $snocount++;
        
        // Store report data
        $reportData[] = [
            'sno' => $snocount,
            'provider' => $subtypename,
            'footfall' => $visitcount,
            'revenue' => $totamt,
            'average_value' => $averageValue,
            'subtype_ano' => $subtypeano,
            'subtype_ledger' => $subtype_ledger
        ];
    }
    
    // Calculate overall averages
    $overallAverageValue = ($totalFootfall > 0) ? ($totalRevenue / $totalFootfall) : 0;
}

// Get location name for display
$locationName = 'All Locations';
if ($locationcode != '') {
    $query_location = "select locationname from master_location where locationcode = '$locationcode'";
    $exec_location = mysqli_query($GLOBALS["___mysqli_ston"], $query_location);
    if ($exec_location && mysqli_num_rows($exec_location) > 0) {
        $res_location = mysqli_fetch_array($exec_location);
        $locationName = $res_location['locationname'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revenue vs Footfall Report - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/revenue-footfall-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date picker styles -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- Scripts -->
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
        <span>Revenue vs Footfall Report</span>
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
                    <li class="nav-item">
                        <a href="assetregister.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Asset Register</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="fixedasset_upload.php" class="nav-link">
                            <i class="fas fa-upload"></i>
                            <span>Fixed Asset Upload</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="revenue_vs_footfall.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Revenue vs Footfall</span>
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
                    <h2>Revenue vs Footfall Report</h2>
                    <p>Analyze revenue performance against patient footfall by provider type.</p>
                </div>
                <div class="page-header-actions">
                    <div class="location-display">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Location: <strong><?php echo htmlspecialchars($locationName); ?></strong></span>
                    </div>
                    <?php if (!empty($reportData)): ?>
                        <button type="button" class="btn btn-secondary" onclick="exportToExcel()">
                            <i class="fas fa-download"></i> Export Excel
                        </button>
                        <button type="button" class="btn btn-outline" onclick="printReport()">
                            <i class="fas fa-print"></i> Print
                        </button>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Search Form Section -->
            <div class="search-form-section">
                <div class="search-form-header">
                    <i class="fas fa-search search-form-icon"></i>
                    <h3 class="search-form-title">Report Parameters</h3>
                </div>
                
                <form name="cbform1" method="post" action="revenue_vs_footfall.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="locationcode" class="form-label">
                                <i class="fas fa-map-marker-alt"></i>
                                Location
                            </label>
                            <select name="locationcode" id="locationcode" class="form-input">
                                <option value="">All Locations</option>
                                <?php
                                $query1 = "select * from master_location order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $locationname = $res1["locationname"];
                                    $locationcode1 = $res1["locationcode"];
                                ?>
                                    <option value="<?php echo $locationcode1; ?>" <?php if($locationcode!=''){if($locationcode == $locationcode1){echo "selected";}}?>><?php echo htmlspecialchars($locationname); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate1" class="form-label">
                                <i class="fas fa-calendar-alt"></i>
                                Date From
                            </label>
                            <div class="date-input-group">
                                <input name="ADate1" id="ADate1" class="form-input date-input" 
                                       value="<?php echo htmlspecialchars($fromdate); ?>" 
                                       readonly onKeyDown="return disableEnterKey()">
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')"
                                     class="date-picker-icon" alt="Select Date">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ADate2" class="form-label">
                                <i class="fas fa-calendar"></i>
                                Date To
                            </label>
                            <div class="date-input-group">
                                <input name="ADate2" id="ADate2" class="form-input date-input" 
                                       value="<?php echo htmlspecialchars($todate); ?>" 
                                       readonly onKeyDown="return disableEnterKey()">
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')"
                                     class="date-picker-icon" alt="Select Date">
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="Submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Generate Report
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <?php if (!empty($reportData)): ?>
                <!-- Summary Cards -->
                <div class="summary-cards">
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="summary-content">
                            <h3><?php echo number_format($totalFootfall, 0, '.', ','); ?></h3>
                            <p>Total Footfall</p>
                        </div>
                    </div>
                    
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="summary-content">
                            <h3><?php echo number_format($totalRevenue, 2, '.', ','); ?></h3>
                            <p>Total Revenue</p>
                        </div>
                    </div>
                    
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="summary-content">
                            <h3><?php echo number_format($overallAverageValue, 2, '.', ','); ?></h3>
                            <p>Average Value per Visit</p>
                        </div>
                    </div>
                    
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="summary-content">
                            <h3><?php echo count($reportData); ?></h3>
                            <p>Providers</p>
                        </div>
                    </div>
                </div>

                <!-- Report Section -->
                <div class="report-section">
                    <div class="report-header">
                        <div class="report-title-section">
                            <i class="fas fa-chart-bar report-icon"></i>
                            <h3 class="report-title">Revenue vs Footfall Analysis</h3>
                            <div class="report-period">
                                <span><?php echo date('d/m/Y', strtotime($fromdate)); ?> - <?php echo date('d/m/Y', strtotime($todate)); ?></span>
                            </div>
                        </div>
                        <div class="report-actions">
                            <button type="button" class="btn btn-outline btn-sm" onclick="toggleChartView()">
                                <i class="fas fa-chart-pie"></i> Chart View
                            </button>
                        </div>
                    </div>

                    <!-- Modern Data Table -->
                    <div class="modern-table-container">
                        <table class="modern-data-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Provider</th>
                                    <th>Footfall</th>
                                    <th>Revenue</th>
                                    <th>Avg. Value</th>
                                    <th>Performance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($reportData as $index => $data): 
                                    $row_class = ($index % 2 == 0) ? 'even' : 'odd';
                                    $performance = ($data['footfall'] > 0 && $data['revenue'] > 0) ? 'good' : (($data['footfall'] > 0 || $data['revenue'] > 0) ? 'moderate' : 'poor');
                                ?>
                                    <tr class="table-row <?php echo $row_class; ?>">
                                        <td><?php echo $data['sno']; ?></td>
                                        <td>
                                            <div class="provider-info">
                                                <span class="provider-name"><?php echo htmlspecialchars($data['provider']); ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="footfall-badge"><?php echo number_format($data['footfall'], 0, '.', ','); ?></span>
                                        </td>
                                        <td>
                                            <span class="revenue-badge"><?php echo number_format($data['revenue'], 2, '.', ','); ?></span>
                                        </td>
                                        <td>
                                            <span class="value-badge"><?php echo number_format($data['average_value'], 2, '.', ','); ?></span>
                                        </td>
                                        <td>
                                            <div class="performance-indicator performance-<?php echo $performance; ?>">
                                                <i class="fas fa-<?php echo $performance === 'good' ? 'check-circle' : ($performance === 'moderate' ? 'exclamation-circle' : 'times-circle'); ?>"></i>
                                                <span><?php echo ucfirst($performance); ?></span>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Chart Section (Hidden by default) -->
                <div class="chart-section" id="chartSection" style="display: none;">
                    <div class="chart-header">
                        <i class="fas fa-chart-pie chart-icon"></i>
                        <h3 class="chart-title">Revenue vs Footfall Chart</h3>
                    </div>
                    <div class="chart-container">
                        <canvas id="revenueFootfallChart"></canvas>
                    </div>
                </div>
            <?php elseif (isset($_POST['Submit'])): ?>
                <div class="no-results-message">
                    <i class="fas fa-chart-bar"></i>
                    <h3>No Data Found</h3>
                    <p>No revenue or footfall data found for the selected criteria.</p>
                    <button type="button" class="btn btn-primary" onclick="resetForm()">
                        <i class="fas fa-undo"></i> Try Different Criteria
                    </button>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/revenue-footfall-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Chart.js for charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Legacy JavaScript functions -->
    <script type="text/javascript">
        function disableEnterKey() {
            if (event.keyCode === 13) {
                return false;
            }
            return true;
        }
        
        function exportToExcel() {
            // TODO: Implement Excel export
            alert('Excel export will be implemented soon');
        }
        
        function printReport() {
            window.print();
        }
        
        function resetForm() {
            document.cbform1.reset();
            document.getElementById('ADate1').value = '<?php echo date('Y-m-d'); ?>';
            document.getElementById('ADate2').value = '<?php echo date('Y-m-d'); ?>';
        }
    </script>
</body>
</html>
