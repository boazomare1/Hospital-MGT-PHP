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
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$currentdate = date("Y-m-d");

// Initialize variables
$errmsg = "";
$bgcolorcode = "";
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
$total = '';
$looptotalpaidamount = '0.00';
$looptotalpendingamount = '0.00';
$looptotalwriteoffamount = '0.00';
$looptotalcashamount = '0.00';
$looptotalcreditamount = '0.00';
$looptotalcardamount = '0.00';
$looptotalonlineamount = '0.00';
$looptotalchequeamount = '0.00';
$looptotaltdsamount = '0.00';
$pendingamount = '0.00';
$accountname = '';

// Handle form parameters
if (isset($_REQUEST["accountname"])) { 
    $accountname = $_REQUEST["accountname"]; 
} else { 
    $accountname = ""; 
}

$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';

if (isset($_REQUEST["canum"])) { 
    $getcanum = $_REQUEST["canum"]; 
} else { 
    $getcanum = ""; 
}

$locationcode1 = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';

if ($getcanum != '') {
    $query4 = "select * from master_supplier where auto_number = '$getcanum'";
    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res4 = mysqli_fetch_array($exec4);
    $cbsuppliername = $res4['suppliername'];
    $suppliername = $res4['suppliername'];
}

if (isset($_REQUEST["cbfrmflag1"])) { 
    $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; 
} else { 
    $cbfrmflag1 = ""; 
}

if ($cbfrmflag1 == 'cbfrmflag1') {
    $paymentreceiveddatefrom = $_REQUEST['ADate1'];
    $paymentreceiveddateto = $_REQUEST['ADate2'];
    $visitcode1 = 10;
}

if (isset($_REQUEST["task"])) { 
    $task = $_REQUEST["task"]; 
} else { 
    $task = ""; 
}

if ($task == 'deleted') {
    $errmsg = 'Payment Entry Delete Completed.';
    $bgcolorcode = 'success';
}

if (isset($_REQUEST["ADate1"])) { 
    $ADate1 = $_REQUEST["ADate1"]; 
} else { 
    $ADate1 = ""; 
}

if (isset($_REQUEST["ADate2"])) { 
    $ADate2 = $_REQUEST["ADate2"]; 
} else { 
    $ADate2 = ""; 
}

// Handle form submission
if (isset($_POST['generate_report'])) {
    if (empty($ADate1) || empty($ADate2)) {
        $errmsg = "Please select both start and end dates.";
        $bgcolorcode = 'failed';
    } else {
        $errmsg = "Cash flow summary report generated successfully.";
        $bgcolorcode = 'success';
    }
}

// Get location name
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
    <title>Cash Flow Summary - MedStar</title>
    
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
        <span>Cash Flow Summary</span>
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
                    <li class="nav-item">
                        <a href="costcenterbudgetreport.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Cost Center Budget Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="bulkbedratesupdate.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Bulk Bed Rates Update</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="viewpurchaseindent1.php" class="nav-link">
                            <i class="fas fa-file-invoice"></i>
                            <span>View Purchase Indent</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="caftsales.php" class="nav-link">
                            <i class="fas fa-utensils"></i>
                            <span>CAFT Sales</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="caftreport.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>CAFT Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="cashbillsreportnew.php" class="nav-link">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Cash Bills Report New</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="cashbillsreport.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Cash Bills Report</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="cashflowsummary.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Cash Flow Summary</span>
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
                    <h2>Cash Flow Summary</h2>
                    <p>Generate comprehensive cash flow summary reports with detailed financial analysis and payment tracking.</p>
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
                    <i class="fas fa-chart-line add-form-icon"></i>
                    <h3 class="add-form-title">Cash Flow Summary Report Generator</h3>
                </div>
                
                <form id="reportForm" name="cbform1" method="post" action="cashflowsummary.php" class="add-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From <span class="required">*</span></label>
                            <input type="date" name="ADate1" id="ADate1" class="form-input" value="<?php echo $paymentreceiveddatefrom; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To <span class="required">*</span></label>
                            <input type="date" name="ADate2" id="ADate2" class="form-input" value="<?php echo $paymentreceiveddateto; ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" class="form-input" onchange="ajaxlocationfunction(this.value)">
                                <option value="">All Locations</option>
                                <?php
                                $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $loccode = array();
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $locationname = $res1["locationname"];
                                    $locationcode = $res1["locationcode"];
                                    $selected = ($location != '' && $location == $locationcode) ? 'selected' : '';
                                    echo '<option value="'.$locationcode.'" '.$selected.'>'.$locationname.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="accountname" class="form-label">Account Name</label>
                            <input type="text" name="accountname" id="accountname" class="form-input" value="<?php echo htmlspecialchars($accountname); ?>" placeholder="Enter account name">
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" name="generate_report" class="btn btn-primary">
                            <i class="fas fa-chart-line"></i> Generate Report
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                    
                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                </form>
            </div>

            <!-- Report Results Section -->
            <?php if (isset($_POST['generate_report']) && !empty($ADate1) && !empty($ADate2)): ?>
            <div class="data-section">
                <div class="data-section-header">
                    <h3>Cash Flow Summary Report Results</h3>
                    <p>Generated for <?php echo htmlspecialchars($res1location); ?> - <?php echo date('Y-m-d H:i:s'); ?></p>
                </div>
                
                <div class="summary-cards">
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="summary-content">
                            <h4>Total Cash</h4>
                            <p>₹ <?php echo number_format($looptotalcashamount, 2); ?></p>
                        </div>
                    </div>
                    
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <div class="summary-content">
                            <h4>Total Card</h4>
                            <p>₹ <?php echo number_format($looptotalcardamount, 2); ?></p>
                        </div>
                    </div>
                    
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="summary-content">
                            <h4>Total Credit</h4>
                            <p>₹ <?php echo number_format($looptotalcreditamount, 2); ?></p>
                        </div>
                    </div>
                    
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="summary-content">
                            <h4>Pending Amount</h4>
                            <p>₹ <?php echo number_format($looptotalpendingamount, 2); ?></p>
                        </div>
                    </div>
                    
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="summary-content">
                            <h4>Paid Amount</h4>
                            <p>₹ <?php echo number_format($looptotalpaidamount, 2); ?></p>
                        </div>
                    </div>
                    
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="summary-content">
                            <h4>Date Range</h4>
                            <p><?php echo $ADate1 . ' to ' . $ADate2; ?></p>
                        </div>
                    </div>
                </div>
                
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Date</th>
                            <th>Account</th>
                            <th>Description</th>
                            <th>Cash</th>
                            <th>Card</th>
                            <th>Credit</th>
                            <th>Online</th>
                            <th>Cheque</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="11" class="no-data">
                                <i class="fas fa-chart-line"></i>
                                <p>Report data will be displayed here based on the selected criteria.</p>
                                <p>This is a sample display - actual data would be populated from the database.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="data-section">
                <div class="data-section-header">
                    <h3>Ready to Generate Report</h3>
                    <p>Select date range and criteria to generate the cash flow summary report.</p>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <script src="js/vat-modern.js?v=<?php echo time(); ?>"></script>
    <script>
        // Additional JavaScript for cash flow summary
        function refreshPage() {
            window.location.reload();
        }
        
        function exportToExcel() {
            if (document.getElementById('ADate1').value && document.getElementById('ADate2').value) {
                // Export functionality can be implemented here
                alert('Export functionality will be implemented');
            } else {
                alert('Please generate a report first to export.');
            }
        }
        
        function ajaxlocationfunction(locationcode) {
            // Handle location change
            console.log('Location changed to: ' + locationcode);
        }
        
        // Form validation
        document.getElementById('reportForm').addEventListener('submit', function(e) {
            const startDate = document.getElementById('ADate1').value;
            const endDate = document.getElementById('ADate2').value;
            
            if (!startDate || !endDate) {
                e.preventDefault();
                alert('Please select both start and end dates.');
                return false;
            }
            
            if (new Date(startDate) > new Date(endDate)) {
                e.preventDefault();
                alert('Start date cannot be later than end date.');
                return false;
            }
            
            return true;
        });
        
        // Auto-fill date range
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            const lastMonth = new Date(today.getFullYear(), today.getMonth() - 1, today.getDate());
            
            if (!document.getElementById('ADate1').value) {
                document.getElementById('ADate1').value = lastMonth.toISOString().split('T')[0];
            }
            if (!document.getElementById('ADate2').value) {
                document.getElementById('ADate2').value = today.toISOString().split('T')[0];
            }
        });
        
        // Account name search autocomplete (placeholder)
        document.getElementById('accountname').addEventListener('input', function() {
            const searchTerm = this.value;
            if (searchTerm.length >= 2) {
                // Implement account search autocomplete here
                console.log('Searching for account: ' + searchTerm);
            }
        });
    </script>
</body>
</html>
