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
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

// Get location parameters
$locationcode1 = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';

// Get date parameters
$transactiondatefrom = isset($_REQUEST['ADate1']) ? $_REQUEST['ADate1'] : '';
$transactiondateto = isset($_REQUEST['ADate2']) ? $_REQUEST['ADate2'] : '';

if($transactiondatefrom == '') {
    $transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
}

if($transactiondateto == '') {
    $transactiondateto = date('Y-m-d');
}

// Status messages
$errmsg = '';
$bgcolorcode = '';

if (isset($_REQUEST["st"])) {
    $st = $_REQUEST["st"];
    if ($st == 'success') {
        $errmsg = "Report generated successfully.";
        $bgcolorcode = 'success';
    } else if ($st == 'failed') {
        $errmsg = "Failed to generate report.";
        $bgcolorcode = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Detailed Revenue Report - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/hospitalrevenuereportdetailed-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date picker styles -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- AutoComplete styles -->
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
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
        <span>Hospital Detailed Revenue Report</span>
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
                        <a href="hospitalrevenuereportdetailed.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Revenue Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="financial.php" class="nav-link">
                            <i class="fas fa-calculator"></i>
                            <span>Financial</span>
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
                    <div class="alert alert-<?php echo $bgcolorcode; ?>">
                        <i class="fas fa-<?php echo $bgcolorcode === 'success' ? 'check-circle' : ($bgcolorcode === 'error' ? 'exclamation-triangle' : 'info-circle'); ?> alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Hospital Detailed Revenue Report</h2>
                    <p>Generate comprehensive revenue reports with detailed breakdowns by location and date range.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <a href="reports.php" class="btn btn-outline">
                        <i class="fas fa-chart-bar"></i> All Reports
                    </a>
                </div>
            </div>

            <!-- Search Form -->
            <div class="search-section">
                <div class="search-header">
                    <i class="fas fa-search search-icon"></i>
                    <h3 class="search-title">Report Parameters</h3>
                    <div class="location-display" id="ajaxlocation">
                        <strong>Location: </strong>
                        <?php
                        if ($location != '') {
                            $query12 = "select locationname from master_location where locationcode='$location' order by locationname";
                            $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res12 = mysqli_fetch_array($exec12);
                            echo htmlspecialchars($res1location = $res12["locationname"]);
                        } else {
                            $query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res1 = mysqli_fetch_array($exec1);
                            echo htmlspecialchars($res1location = $res1["locationname"]);
                        }
                        ?>
                    </div>
                </div>
                
                <form name="cbform1" method="post" action="hospitalrevenuereportdetailed.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <div class="date-input-group">
                                <input name="ADate1" id="ADate1" value="<?php echo htmlspecialchars($transactiondatefrom); ?>" 
                                       class="form-input" readonly onKeyDown="return disableEnterKey()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" 
                                     class="date-picker-icon" alt="Select Date" />
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <div class="date-input-group">
                                <input name="ADate2" id="ADate2" value="<?php echo htmlspecialchars($transactiondateto); ?>" 
                                       class="form-input" readonly onKeyDown="return disableEnterKey()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" 
                                     class="date-picker-icon" alt="Select Date" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" onChange="ajaxlocationfunction(this.value);" class="form-select">
                                <option value="">Select Location</option>
                                <?php
                                $query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                
                                while ($res = mysqli_fetch_array($exec)) {
                                    $reslocation = $res["locationname"];
                                    $reslocationanum = $res["locationcode"];
                                    ?>
                                    <option value="<?php echo htmlspecialchars($reslocationanum); ?>" 
                                            <?php if($location != '' && $location == $reslocationanum) echo "selected"; ?>>
                                        <?php echo htmlspecialchars($reslocation); ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-actions">
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
            <?php if (!empty($location) || !empty($transactiondatefrom) || !empty($transactiondateto)): ?>
            <div class="report-section">
                <div class="report-header">
                    <i class="fas fa-file-invoice-dollar report-icon"></i>
                    <h3 class="report-title">Hospital Revenue Report</h3>
                    <div class="report-period">
                        <span class="period-label">Period:</span>
                        <span class="period-value"><?php echo htmlspecialchars($transactiondatefrom); ?> to <?php echo htmlspecialchars($transactiondateto); ?></span>
                    </div>
                </div>
                
                <!-- Revenue Summary Cards -->
                <div class="revenue-summary">
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="summary-content">
                            <h4>Total Revenue</h4>
                            <p class="summary-amount">$0.00</p>
                        </div>
                    </div>
                    
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="summary-content">
                            <h4>Total Patients</h4>
                            <p class="summary-amount">0</p>
                        </div>
                    </div>
                    
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fas fa-procedures"></i>
                        </div>
                        <div class="summary-content">
                            <h4>Total Procedures</h4>
                            <p class="summary-amount">0</p>
                        </div>
                    </div>
                    
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="summary-content">
                            <h4>Growth Rate</h4>
                            <p class="summary-amount">0%</p>
                        </div>
                    </div>
                </div>
                
                <!-- Revenue Breakdown Table -->
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Patient ID</th>
                                <th>Patient Name</th>
                                <th>Service</th>
                                <th>Department</th>
                                <th>Amount</th>
                                <th>Payment Status</th>
                                <th>Location</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Sample data - replace with actual database query -->
                            <tr class="even-row">
                                <td class="date-cell">2024-01-15</td>
                                <td class="id-cell">P001</td>
                                <td class="name-cell">John Doe</td>
                                <td class="service-cell">Consultation</td>
                                <td class="dept-cell">Cardiology</td>
                                <td class="amount-cell">$150.00</td>
                                <td class="status-cell">
                                    <span class="status-badge status-paid">Paid</span>
                                </td>
                                <td class="location-cell">Main Hospital</td>
                            </tr>
                            
                            <tr class="odd-row">
                                <td class="date-cell">2024-01-15</td>
                                <td class="id-cell">P002</td>
                                <td class="name-cell">Jane Smith</td>
                                <td class="service-cell">Lab Test</td>
                                <td class="dept-cell">Pathology</td>
                                <td class="amount-cell">$75.00</td>
                                <td class="status-cell">
                                    <span class="status-badge status-pending">Pending</span>
                                </td>
                                <td class="location-cell">Main Hospital</td>
                            </tr>
                            
                            <tr class="even-row">
                                <td class="date-cell">2024-01-16</td>
                                <td class="id-cell">P003</td>
                                <td class="name-cell">Bob Johnson</td>
                                <td class="service-cell">Surgery</td>
                                <td class="dept-cell">Surgery</td>
                                <td class="amount-cell">$2,500.00</td>
                                <td class="status-cell">
                                    <span class="status-badge status-paid">Paid</span>
                                </td>
                                <td class="location-cell">Main Hospital</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="total-row">
                                <td colspan="5" class="total-label">Total Revenue:</td>
                                <td class="total-amount">$2,725.00</td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Export Actions -->
                <div class="export-actions">
                    <h4>Export Options</h4>
                    <div class="export-buttons">
                        <button type="button" class="btn btn-outline" onclick="exportToPDF()">
                            <i class="fas fa-file-pdf"></i> PDF Report
                        </button>
                        <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                            <i class="fas fa-file-excel"></i> Excel Report
                        </button>
                        <button type="button" class="btn btn-outline" onclick="exportToCSV()">
                            <i class="fas fa-file-csv"></i> CSV File
                        </button>
                        <button type="button" class="btn btn-outline" onclick="printReport()">
                            <i class="fas fa-print"></i> Print Report
                        </button>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/hospitalrevenuereportdetailed-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>


