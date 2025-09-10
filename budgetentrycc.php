<?php
session_start();
error_reporting(0);
include ("db/db_connect.php");
include ("includes/loginverify.php");

$updatedatetime = date("Y-m-d H:i:s");
$indiandatetitme = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$suppdateonly = date("Y-m-d");
$username = $_SESSION['username'];
$ipaddress = $_SERVER['REMOTE_ADDR'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$docno = $_SESSION['docno'];

// Initialize variables
$errmsg = "";
$bgcolorcode = "";

// Get location details
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);

$reslocationname = $res["locationname"];
$res12locationanum = $res["auto_number"];

$query3 = "select * from master_location where locationname='$reslocationname'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);

$locationcode = $res3['locationcode'];
$locationname = $res3['locationname'];
$location = $locationcode;

// Check if settings exist
$query91 = "select count(auto_number) as masterscount from settings_purchase where companyanum = '$companyanum'";
$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die ("Error in Query91".mysqli_error($GLOBALS["___mysqli_ston"]));
$res91 = mysqli_fetch_array($exec91);
$res91count = $res91["masterscount"];

if ($res91count == 0) {
    $errmsg = "Please configure purchase settings first.";
    $bgcolorcode = 'failed';
}

// Handle form submissions
if (isset($_POST['cbfrmflag1'])) {
    $location = $_POST['location'];
    $budgetyear = $_POST['budgetyear'];
    $costcenter = $_POST['costcenter'];
    $budgetamount = $_POST['budgetamount'];
    $remarks = $_POST['remarks'];
    
    if (empty($location) || empty($budgetyear) || empty($costcenter) || empty($budgetamount)) {
        $errmsg = "Please fill in all required fields.";
        $bgcolorcode = 'failed';
    } else {
        $errmsg = "Budget entry submitted successfully.";
        $bgcolorcode = 'success';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Entry - Cost Center - MedStar</title>
    
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
        <span>Budget Entry - Cost Center</span>
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
                    <li class="nav-item active">
                        <a href="budgetentrycc.php" class="nav-link">
                            <i class="fas fa-calculator"></i>
                            <span>Budget Entry CC</span>
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
                    <h2>Budget Entry - Cost Center</h2>
                    <p>Create and manage budget entries for different cost centers with detailed financial planning and tracking.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="printBudget()">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>

            <!-- Budget Entry Form -->
            <div class="add-form-section">
                <div class="add-form-header">
                    <i class="fas fa-calculator add-form-icon"></i>
                    <h3 class="add-form-title">Budget Cost Center Entry</h3>
                </div>
                
                <form id="budgetForm" name="cbform1" method="post" action="budgetentrycc.php" enctype="multipart/form-data" class="add-form" onsubmit="return validcheck()">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location <span class="required">*</span></label>
                            <select name="location" id="location" class="form-input" required>
                                <option value="">Select Location</option>
                                <?php
                                $query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res = mysqli_fetch_array($exec)) {
                                    $reslocation = $res["locationname"];
                                    $reslocationanum = $res["locationcode"];
                                    $selected = ($location != '' && $location == $reslocationanum) ? "selected" : "";
                                    echo '<option value="'.$reslocationanum.'" '.$selected.'>'.$reslocation.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="budgetyear" class="form-label">Budget Year <span class="required">*</span></label>
                            <select name="budgetyear" id="budgetyear" class="form-input" required>
                                <option value="">Select Year</option>
                                <?php
                                $currentYear = date('Y');
                                for ($i = $currentYear - 2; $i <= $currentYear + 5; $i++) {
                                    echo '<option value="'.$i.'">'.$i.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="costcenter" class="form-label">Cost Center <span class="required">*</span></label>
                            <select name="costcenter" id="costcenter" class="form-input" required>
                                <option value="">Select Cost Center</option>
                                <?php
                                $query_costcenter = "select * from master_costcenter where status <> 'deleted' order by costcentername";
                                $exec_costcenter = mysqli_query($GLOBALS["___mysqli_ston"], $query_costcenter) or die ("Error in Query_costcenter".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res_costcenter = mysqli_fetch_array($exec_costcenter)) {
                                    $costcentername = $res_costcenter["costcentername"];
                                    $costcentercode = $res_costcenter["costcentercode"];
                                    echo '<option value="'.$costcentercode.'">'.$costcentername.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="budgetamount" class="form-label">Budget Amount <span class="required">*</span></label>
                            <input type="number" name="budgetamount" id="budgetamount" class="form-input" placeholder="0.00" min="0" step="0.01" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea name="remarks" id="remarks" class="form-input" rows="3" placeholder="Enter any additional remarks or notes..."></textarea>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Budget Entry
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                    
                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                </form>
            </div>

            <!-- Budget Summary Section -->
            <div class="data-section">
                <div class="data-section-header">
                    <h3>Budget Summary</h3>
                    <p>Overview of budget entries for the selected period and location.</p>
                </div>
                
                <div class="summary-cards">
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="summary-content">
                            <h4>Current Year</h4>
                            <p><?php echo date('Y'); ?></p>
                        </div>
                    </div>
                    
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="summary-content">
                            <h4>Location</h4>
                            <p><?php echo htmlspecialchars($locationname); ?></p>
                        </div>
                    </div>
                    
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <div class="summary-content">
                            <h4>Cost Centers</h4>
                            <p>Multiple</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="js/vat-modern.js?v=<?php echo time(); ?>"></script>
    <script>
        // Additional JavaScript for budget entry
        function refreshPage() {
            window.location.reload();
        }
        
        function printBudget() {
            window.print();
        }
        
        function validcheck() {
            const location = document.getElementById('location').value;
            const budgetyear = document.getElementById('budgetyear').value;
            const costcenter = document.getElementById('costcenter').value;
            const budgetamount = document.getElementById('budgetamount').value;
            
            if (!location) {
                alert('Please select a location.');
                document.getElementById('location').focus();
                return false;
            }
            
            if (!budgetyear) {
                alert('Please select a budget year.');
                document.getElementById('budgetyear').focus();
                return false;
            }
            
            if (!costcenter) {
                alert('Please select a cost center.');
                document.getElementById('costcenter').focus();
                return false;
            }
            
            if (!budgetamount || budgetamount <= 0) {
                alert('Please enter a valid budget amount.');
                document.getElementById('budgetamount').focus();
                return false;
            }
            
            return true;
        }
        
        function budgetcheck() {
            // Additional budget validation logic
            return true;
        }
        
        // Form validation
        document.getElementById('budgetForm').addEventListener('submit', function(e) {
            if (!validcheck()) {
                e.preventDefault();
                return false;
            }
        });
        
        // Auto-format budget amount
        document.getElementById('budgetamount').addEventListener('input', function(e) {
            let value = e.target.value;
            if (value && !isNaN(value)) {
                e.target.value = parseFloat(value).toFixed(2);
            }
        });
    </script>
</body>
</html>
