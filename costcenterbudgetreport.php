<?php
error_reporting(0);
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
$totalnetprofit = 0;
$searchsuppliername = "";
$res1username = '';

// Initialize variables
$errmsg = "";
$bgcolorcode = "";

$transactiondatefrom = date('Y-m-01');
$transactiondateto = date('Y-m-d');

ini_set('max_execution_time', 300);

// Handle form parameters
if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('m'); }
if (isset($_REQUEST["searchquarter"])) { $searchquarter = $_REQUEST["searchquarter"]; } else { $searchquarter = ""; }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = ""; }
if (isset($_REQUEST["searchyear1"])) { $searchyear1 = $_REQUEST["searchyear1"]; } else { $searchyear1 = ""; }
if (isset($_REQUEST["fromyear"])) { $fromyear = $_REQUEST["fromyear"]; } else { $fromyear = ""; }
if (isset($_REQUEST["toyear"])) { $toyear = $_REQUEST["toyear"]; } else { $toyear = ""; }
if (isset($_REQUEST["period"])) { $period = $_REQUEST["period"]; } else { $period = ""; }
if (isset($_REQUEST["cc_name"])) { $cc_name = $_REQUEST["cc_name"]; } else { $cc_name = ""; }
if (isset($_REQUEST["searchmonthto"])) { $searchmonthto = $_REQUEST["searchmonthto"]; } else { $searchmonthto = date('m'); }
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; $transactiondatefrom = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; $transactiondateto = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

// Handle form submission
if (isset($_POST['generate_report'])) {
    if (empty($cc_name)) {
        $errmsg = "Please select a cost center.";
        $bgcolorcode = 'failed';
    } else {
        $errmsg = "Cost center budget report generated successfully.";
        $bgcolorcode = 'success';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cost Center Budget Report - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/vat-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
        <span>Cost Center Budget Report</span>
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
                        <a href="admissionlist.php" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>Admission List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipbeddiscountlist.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            <span>Bed Discount</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addbed.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Add Bed</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="bedoccupancysummary.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Bed Occupancy</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="bedoccupancy2.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Bed Occupancy 2</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="bedtransferlist.php" class="nav-link">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Bed Transfer</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="otc_walkin_services.php" class="nav-link">
                            <i class="fas fa-walking"></i>
                            <span>OTC Walk-in</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billenquiry.php" class="nav-link">
                            <i class="fas fa-search"></i>
                            <span>Bill Enquiry</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billestimate.php" class="nav-link">
                            <i class="fas fa-calculator"></i>
                            <span>Bill Estimate</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billtxnidedit.php" class="nav-link">
                            <i class="fas fa-edit"></i>
                            <span>Transaction Edit</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="patientbillingstatus.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Patient Billing Status</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billing_pending_op2.php" class="nav-link">
                            <i class="fas fa-clock"></i>
                            <span>Billing Pending OP2</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="medicalgoodsreceivednote.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Medical Goods Received</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="fixedasset_detailed_report.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Fixed Asset Detailed</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="fixedasset_summary_report.php" class="nav-link">
                            <i class="fas fa-chart-pie"></i>
                            <span>Fixed Asset Summary</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="theatrebookinglist.php" class="nav-link">
                            <i class="fas fa-theater-masks"></i>
                            <span>Theatre Booking List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="branch_git.php" class="nav-link">
                            <i class="fas fa-truck"></i>
                            <span>Branch GIT</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="branchincome.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Branch Income</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="brstocktransferreport.php" class="nav-link">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Stock Transfer Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="branchstockrequest.php" class="nav-link">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Stock Request</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="budgetentrycc.php" class="nav-link">
                            <i class="fas fa-calculator"></i>
                            <span>Budget Entry CC</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="budgetentrycclist.php" class="nav-link">
                            <i class="fas fa-list"></i>
                            <span>Budget Entry List</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="costcenterbudgetreport.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Cost Center Budget Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="vat.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            <span>VAT Master</span>
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
                    <h2>Cost Center Budget Report</h2>
                    <p>Generate comprehensive budget reports for cost centers with detailed financial analysis and period-based filtering.</p>
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

            <!-- Report Filter Form -->
            <div class="add-form-section">
                <div class="add-form-header">
                    <i class="fas fa-chart-bar add-form-icon"></i>
                    <h3 class="add-form-title">Cost Center Budget Report</h3>
                </div>
                
                <form id="reportForm" name="cbform1" method="post" action="costcenterbudgetreport.php" class="add-form" onsubmit="return valid()">
                    <div class="form-group">
                        <label for="cc_name" class="form-label">Cost Center <span class="required">*</span></label>
                        <select id="cc_name" name="cc_name" class="form-input" required>
                            <option value="" selected="selected">Select Cost Center</option>
                            <?php
                            $query1 = "select * from master_costcenter where recordstatus <> 'deleted' order by name";
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res1 = mysqli_fetch_array($exec1)) {
                                $res1categoryname = $res1["name"];
                                $res1categoryname = strtoupper($res1categoryname);
                                $res1auto_number = $res1["auto_number"];
                                $selected = ($res1auto_number == $cc_name) ? 'selected' : '';
                                echo '<option value="'.$res1auto_number.'" '.$selected.'>'.$res1categoryname.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="period1" class="form-label">Period</label>
                        <select name="period" id="period1" class="form-input" onchange="funchangeperiod(this.value)">
                            <?php if($period != '') { ?>
                                <option value="<?php echo $period; ?>"><?php echo ucwords($period); ?></option>
                            <?php } else { ?>
                                <option value="">Select Period</option>
                            <?php } ?>
                            <option value="dates range">Date Range</option>
                            <option value="monthly">Monthly</option>
                            <option value="quarterly">Quarterly</option>
                            <option value="yearly">Yearly</option>
                        </select>
                    </div>
                    
                    <!-- Date Range Section -->
                    <div id="dateRangeSection" class="form-section" style="display: none;">
                        <div class="form-section-header">
                            <h4>Date Range Selection</h4>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="ADate1" class="form-label">From Date</label>
                                <input type="date" name="ADate1" id="ADate1" class="form-input" value="<?php echo $ADate1; ?>">
                            </div>
                            <div class="form-group">
                                <label for="ADate2" class="form-label">To Date</label>
                                <input type="date" name="ADate2" id="ADate2" class="form-input" value="<?php echo $ADate2; ?>">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Monthly Section -->
                    <div id="monthlySection" class="form-section" style="display: none;">
                        <div class="form-section-header">
                            <h4>Monthly Selection</h4>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="searchmonth" class="form-label">From Month</label>
                                <select name="searchmonth" id="searchmonth" class="form-input">
                                    <?php
                                    $months = [
                                        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                                        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                                        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                                    ];
                                    foreach ($months as $num => $name) {
                                        $selected = ($searchmonth == $num) ? 'selected' : '';
                                        echo '<option value="'.$num.'" '.$selected.'>'.$name.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="searchmonthto" class="form-label">To Month</label>
                                <select name="searchmonthto" id="searchmonthto" class="form-input">
                                    <?php
                                    foreach ($months as $num => $name) {
                                        $selected = ($searchmonthto == $num) ? 'selected' : '';
                                        echo '<option value="'.$num.'" '.$selected.'>'.$name.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quarterly Section -->
                    <div id="quarterlySection" class="form-section" style="display: none;">
                        <div class="form-section-header">
                            <h4>Quarterly Selection</h4>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="searchquarter" class="form-label">Quarter</label>
                                <select name="searchquarter" id="searchquarter" class="form-input">
                                    <option value="">Select Quarter</option>
                                    <option value="Q1" <?php echo ($searchquarter == 'Q1') ? 'selected' : ''; ?>>Q1 (Jan-Mar)</option>
                                    <option value="Q2" <?php echo ($searchquarter == 'Q2') ? 'selected' : ''; ?>>Q2 (Apr-Jun)</option>
                                    <option value="Q3" <?php echo ($searchquarter == 'Q3') ? 'selected' : ''; ?>>Q3 (Jul-Sep)</option>
                                    <option value="Q4" <?php echo ($searchquarter == 'Q4') ? 'selected' : ''; ?>>Q4 (Oct-Dec)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="searchyear" class="form-label">Year</label>
                                <select name="searchyear" id="searchyear" class="form-input">
                                    <option value="">Select Year</option>
                                    <?php
                                    $currentYear = date('Y');
                                    for ($i = $currentYear - 5; $i <= $currentYear + 2; $i++) {
                                        $selected = ($searchyear == $i) ? 'selected' : '';
                                        echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Yearly Section -->
                    <div id="yearlySection" class="form-section" style="display: none;">
                        <div class="form-section-header">
                            <h4>Yearly Selection</h4>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="fromyear" class="form-label">From Year</label>
                                <select name="fromyear" id="fromyear" class="form-input">
                                    <option value="">Select Year</option>
                                    <?php
                                    for ($i = $currentYear - 5; $i <= $currentYear + 2; $i++) {
                                        $selected = ($fromyear == $i) ? 'selected' : '';
                                        echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="toyear" class="form-label">To Year</label>
                                <select name="toyear" id="toyear" class="form-input">
                                    <option value="">Select Year</option>
                                    <?php
                                    for ($i = $currentYear - 5; $i <= $currentYear + 2; $i++) {
                                        $selected = ($toyear == $i) ? 'selected' : '';
                                        echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" name="generate_report" class="btn btn-primary">
                            <i class="fas fa-chart-bar"></i> Generate Report
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Report Results Section -->
            <?php if (isset($_POST['generate_report']) && !empty($cc_name)): ?>
            <div class="data-section">
                <div class="data-section-header">
                    <h3>Cost Center Budget Report</h3>
                    <p>Generated for selected cost center and period</p>
                </div>
                
                <div class="summary-cards">
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="summary-content">
                            <h4>Cost Center</h4>
                            <p><?php 
                            $ccQuery = "select name from master_costcenter where auto_number = '$cc_name'";
                            $ccExec = mysqli_query($GLOBALS["___mysqli_ston"], $ccQuery);
                            $ccRes = mysqli_fetch_array($ccExec);
                            echo htmlspecialchars($ccRes['name']);
                            ?></p>
                        </div>
                    </div>
                    
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="summary-content">
                            <h4>Period</h4>
                            <p><?php echo ucwords($period); ?></p>
                        </div>
                    </div>
                    
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="summary-content">
                            <h4>Status</h4>
                            <p>Generated</p>
                        </div>
                    </div>
                </div>
                
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Period</th>
                            <th>Budget Amount</th>
                            <th>Actual Amount</th>
                            <th>Variance</th>
                            <th>Variance %</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5" class="no-data">
                                <i class="fas fa-chart-bar"></i>
                                <p>Report data will be displayed here based on the selected criteria.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="data-section">
                <div class="data-section-header">
                    <h3>Ready to Generate Report</h3>
                    <p>Select cost center and period to generate the budget report.</p>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <script src="js/vat-modern.js?v=<?php echo time(); ?>"></script>
    <script>
        // Additional JavaScript for cost center budget report
        function refreshPage() {
            window.location.reload();
        }
        
        function exportToExcel() {
            if (document.getElementById('cc_name').value) {
                // Export functionality can be implemented here
                alert('Export functionality will be implemented');
            } else {
                alert('Please select a cost center first to export the report.');
            }
        }
        
        function funchangeperiod(periodValue) {
            // Hide all sections first
            document.getElementById('dateRangeSection').style.display = 'none';
            document.getElementById('monthlySection').style.display = 'none';
            document.getElementById('quarterlySection').style.display = 'none';
            document.getElementById('yearlySection').style.display = 'none';
            
            // Show relevant section based on selection
            switch(periodValue) {
                case 'dates range':
                    document.getElementById('dateRangeSection').style.display = 'block';
                    break;
                case 'monthly':
                    document.getElementById('monthlySection').style.display = 'block';
                    break;
                case 'quarterly':
                    document.getElementById('quarterlySection').style.display = 'block';
                    break;
                case 'yearly':
                    document.getElementById('yearlySection').style.display = 'block';
                    break;
            }
        }
        
        function valid() {
            const costCenter = document.getElementById('cc_name').value;
            const period = document.getElementById('period1').value;
            
            if (!costCenter) {
                alert('Please select a cost center.');
                document.getElementById('cc_name').focus();
                return false;
            }
            
            if (!period) {
                alert('Please select a period.');
                document.getElementById('period1').focus();
                return false;
            }
            
            return true;
        }
        
        // Initialize period sections on page load
        document.addEventListener('DOMContentLoaded', function() {
            const periodValue = document.getElementById('period1').value;
            if (periodValue) {
                funchangeperiod(periodValue);
            }
        });
    </script>
</body>
</html>
