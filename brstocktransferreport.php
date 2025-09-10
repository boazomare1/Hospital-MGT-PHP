<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$docno = $_SESSION['docno'];
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');

// Initialize variables
$errmsg = "";
$bgcolorcode = "";
$ADate1 = isset($_REQUEST['ADate1']) ? $_REQUEST['ADate1'] : $transactiondatefrom;
$ADate2 = isset($_REQUEST['ADate2']) ? $_REQUEST['ADate2'] : $transactiondateto;
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
$data = '';
$status = '';
$searchsupplier = '';
$fromstore = isset($_REQUEST['fromstore']) ? $_REQUEST['fromstore'] : "";
$tostore = isset($_REQUEST['tostore']) ? $_REQUEST['tostore'] : "";

if ($location != '') {
    $locationcode = $location;
}

if (isset($_REQUEST["frmflag1"])) { 
    $frmflag1 = $_REQUEST["frmflag1"]; 
} else { 
    $frmflag1 = ""; 
}

// Handle form submission
if ($frmflag1 == 'frmflag1') {
    $ADate1 = $_REQUEST['ADate1'];
    $ADate2 = $_REQUEST['ADate2'];
    $location = $_REQUEST['location'];
    
    if (empty($ADate1) || empty($ADate2)) {
        $errmsg = "Please select both start and end dates.";
        $bgcolorcode = 'failed';
    } else {
        $errmsg = "Branch stock transfer report generated successfully.";
        $bgcolorcode = 'success';
    }
}

// Get location details
$query11 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
$res11 = mysqli_fetch_array($exec11);
$res11location = $res11["locationname"];
$res11locationanum = $res11["locationcode"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branch Stock Transfer Report - MedStar</title>
    
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
        <span>Branch Stock Transfer Report</span>
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
                    <li class="nav-item active">
                        <a href="brstocktransferreport.php" class="nav-link">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Stock Transfer Report</span>
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
                    <h2>Branch Stock Transfer Report</h2>
                    <p>Generate comprehensive reports for stock transfers between branches with detailed tracking and analysis.</p>
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
                    <i class="fas fa-filter add-form-icon"></i>
                    <h3 class="add-form-title">Branch Stock Transfer Report</h3>
                </div>
                
                <form id="reportForm" name="form1" method="post" action="brstocktransferreport.php" class="add-form" onsubmit="return process1()">
                    <div class="form-group">
                        <label for="location" class="form-label">Location</label>
                        <select name="location" id="location" class="form-input" onchange="ajaxlocationfunction(this.value)">
                            <option value="">All Locations</option>
                            <?php
                            $query1 = "select * from master_location";
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res1 = mysqli_fetch_array($exec1)) {
                                $res1location = $res1["locationname"];
                                $res1locationanum = $res1["locationcode"];
                                $selected = ($location != '' && $location == $res1locationanum) ? "selected" : "";
                                echo '<option value="'.$res1locationanum.'" '.$selected.'>'.$res1location.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <input type="date" name="ADate1" id="ADate1" class="form-input" value="<?php echo $ADate1; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <input type="date" name="ADate2" id="ADate2" class="form-input" value="<?php echo $ADate2; ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                    
                    <input type="hidden" name="frmflag1" value="frmflag1">
                </form>
            </div>

            <!-- Stock Transfer Report Results -->
            <?php if ($frmflag1 == 'frmflag1' && !empty($ADate1) && !empty($ADate2)): ?>
            <div class="data-section">
                <div class="data-section-header">
                    <h3>Stock Transfer Report</h3>
                    <p>Date Range: <strong><?php echo date('Y-m-d', strtotime($ADate1)); ?></strong> to <strong><?php echo date('Y-m-d', strtotime($ADate2)); ?></strong></p>
                </div>
                
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Type</th>
                            <th>Doc No</th>
                            <th>From Location</th>
                            <th>From Store</th>
                            <th>To Location</th>
                            <th>To Store</th>
                            <th>Date</th>
                            <th>Item Name</th>
                            <th>Batch</th>
                            <th>Exp. Date</th>
                            <th>Transfer Qty</th>
                            <th>Cost</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $colorloopcount = '';
                        $loopcount = '';
                        $totamount = 0;
                        $location = isset($_REQUEST['location']) ? $_REQUEST['location'] : $res11locationanum;
                        
                        if ($location != '') {
                            $query66 = "select * from master_stock_transfer where tolocationcode = '".$location."' and entrydate BETWEEN '".$ADate1."' and '".$ADate2."'";
                        } else {
                            $query66 = "select * from master_stock_transfer where entrydate BETWEEN '".$ADate1."' and '".$ADate2."'";
                        }
                        
                        $exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
                        
                        while ($res66 = mysqli_fetch_array($exec66)) {
                            $colorloopcount = $colorloopcount + 1;
                            $showcolor = ($colorloopcount & 1);
                            
                            if ($showcolor == 0) {
                                $colorcode = 'bgcolor="#CBDBFA"';
                            } else {
                                $colorcode = 'bgcolor="#ecf0f5"';
                            }
                            
                            $loopcount = $loopcount + 1;
                            $docno = $res66['docno'];
                            $fromlocation = $res66['fromlocationcode'];
                            $tolocation = $res66['tolocationcode'];
                            $fromstore = $res66['fromstore'];
                            $tostore = $res66['tostore'];
                            $entrydate = $res66['entrydate'];
                            $itemname = $res66['itemname'];
                            $batch = $res66['batch'];
                            $expdate = $res66['expdate'];
                            $quantity = $res66['quantity'];
                            $cost = $res66['cost'];
                            $amount = $res66['amount'];
                            $typetransfer = $res66['typetransfer'];
                            
                            $totamount += $amount;
                            
                            // Get location names
                            $query_from_location = "select locationname from master_location where locationcode = '".$fromlocation."'";
                            $exec_from_location = mysqli_query($GLOBALS["___mysqli_ston"], $query_from_location);
                            $res_from_location = mysqli_fetch_array($exec_from_location);
                            $from_location_name = $res_from_location['locationname'] ?: 'N/A';
                            
                            $query_to_location = "select locationname from master_location where locationcode = '".$tolocation."'";
                            $exec_to_location = mysqli_query($GLOBALS["___mysqli_ston"], $query_to_location);
                            $res_to_location = mysqli_fetch_array($exec_to_location);
                            $to_location_name = $res_to_location['locationname'] ?: 'N/A';
                            
                            // Get store names
                            $query_from_store = "select store from master_store where storecode = '".$fromstore."'";
                            $exec_from_store = mysqli_query($GLOBALS["___mysqli_ston"], $query_from_store);
                            $res_from_store = mysqli_fetch_array($exec_from_store);
                            $from_store_name = $res_from_store['store'] ?: 'N/A';
                            
                            $query_to_store = "select store from master_store where storecode = '".$tostore."'";
                            $exec_to_store = mysqli_query($GLOBALS["___mysqli_ston"], $query_to_store);
                            $res_to_store = mysqli_fetch_array($exec_to_store);
                            $to_store_name = $res_to_store['store'] ?: 'N/A';
                            
                            echo '<tr '.$colorcode.'>';
                            echo '<td>' . $loopcount . '</td>';
                            echo '<td>' . htmlspecialchars($typetransfer) . '</td>';
                            echo '<td>' . htmlspecialchars($docno) . '</td>';
                            echo '<td>' . htmlspecialchars($from_location_name) . '</td>';
                            echo '<td>' . htmlspecialchars($from_store_name) . '</td>';
                            echo '<td>' . htmlspecialchars($to_location_name) . '</td>';
                            echo '<td>' . htmlspecialchars($to_store_name) . '</td>';
                            echo '<td>' . date('Y-m-d', strtotime($entrydate)) . '</td>';
                            echo '<td>' . htmlspecialchars($itemname) . '</td>';
                            echo '<td>' . htmlspecialchars($batch) . '</td>';
                            echo '<td>' . date('Y-m-d', strtotime($expdate)) . '</td>';
                            echo '<td class="text-right">' . number_format($quantity, 2) . '</td>';
                            echo '<td class="text-right">₹ ' . number_format($cost, 2) . '</td>';
                            echo '<td class="text-right">₹ ' . number_format($amount, 2) . '</td>';
                            echo '</tr>';
                        }
                        
                        if ($loopcount == 0) {
                            echo '<tr>';
                            echo '<td colspan="14" class="no-data">';
                            echo '<i class="fas fa-exchange-alt"></i>';
                            echo '<p>No stock transfer records found for the specified criteria.</p>';
                            echo '</td>';
                            echo '</tr>';
                        } else {
                            // Add total row
                            echo '<tr class="total-row">';
                            echo '<td colspan="13"><strong>Total Records: ' . $loopcount . '</strong></td>';
                            echo '<td class="text-right"><strong>₹ ' . number_format($totamount, 2) . '</strong></td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="data-section">
                <div class="data-section-header">
                    <h3>Ready to Generate Report</h3>
                    <p>Select date range and optional location to generate the branch stock transfer report.</p>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <script src="js/vat-modern.js?v=<?php echo time(); ?>"></script>
    <script>
        // Additional JavaScript for branch stock transfer report
        function refreshPage() {
            window.location.reload();
        }
        
        function exportToExcel() {
            if (document.getElementById('ADate1').value && document.getElementById('ADate2').value) {
                // Export functionality can be implemented here
                alert('Export functionality will be implemented');
            } else {
                alert('Please select date range first to export the report.');
            }
        }
        
        function ajaxlocationfunction(locationcode) {
            // Location change functionality
            console.log('Location changed to: ' + locationcode);
        }
        
        function process1() {
            if (document.form1.ADate1.value == "") {
                alert("Please select start date");
                document.form1.ADate1.focus();
                return false;
            }
            if (document.form1.ADate2.value == "") {
                alert("Please select end date");
                document.form1.ADate2.focus();
                return false;
            }
            return true;
        }
        
        function funcSelectFromStore() {
            // Store selection functionality
            console.log('Store selection initialized');
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
        });
    </script>
</body>
</html>
