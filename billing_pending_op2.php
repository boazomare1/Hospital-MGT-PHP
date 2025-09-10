<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

$docno = $_SESSION['docno'];

// Initialize variables
$location = '';
$locationcode = '';
$locationname = '';
$searchcustomername = '';
$fromdate = date('Y-m-d');
$todate = date('Y-m-d');
$st = '';
$billautonumber = '';
$printbill = '';

// Get default location
$query = "select * from master_location where status <> 'deleted' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);

$locationname = $res["locationname"];
$locationcode = $res["locationcode"];
$res12locationanum = $res["auto_number"];

// Get location for search purpose
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : $locationcode;
if ($location != '') {
    $locationcode = $location;
}

// Handle form submission
if (isset($_POST["frmflag1"])) { 
    $frmflag1 = $_POST["frmflag1"]; 
} else { 
    $frmflag1 = ""; 
}

if ($frmflag1 == 'frmflag1') {
    $searchcustomername = $_REQUEST["searchcustomername"];
    $location = $_REQUEST["location"];
    $fromdate = $_REQUEST["ADate1"];
    $todate = $_REQUEST["ADate2"];
    
    $query1 = "select * from master_location where status <> 'deleted' and locationcode = '".$locationcode."'";
    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res1 = mysqli_fetch_array($exec1);
    
    $locationname = $res1["locationname"];
    
    if (empty($searchcustomername)) {
        $errmsg = "Please enter a customer name to search.";
        $bgcolorcode = 'failed';
    } else {
        $errmsg = "Search completed for billing pending records.";
        $bgcolorcode = 'success';
    }
}

// Handle status actions
if (isset($_REQUEST["st"])) { 
    $st = $_REQUEST["st"]; 
} else { 
    $st = ""; 
}

if (isset($_REQUEST["billautonumber"])) { 
    $billautonumber = $_REQUEST["billautonumber"]; 
} else { 
    $billautonumber = ""; 
}

if (isset($_REQUEST["printbill"])) { 
    $printbill = $_REQUEST["printbill"]; 
} else { 
    $printbill = ""; 
}

// Check for URL messages
if ($st == 'success') {
    if ($printbill == 'detailed') {
        $errmsg = "Detailed bill printed successfully.";
        $bgcolorcode = 'success';
    } elseif ($printbill == 'summary') {
        $errmsg = "Summary bill printed successfully.";
        $bgcolorcode = 'success';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Pending OP2 - MedStar</title>
    
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
        <span>Billing Pending OP2</span>
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
                    <li class="nav-item active">
                        <a href="billing_pending_op2.php" class="nav-link">
                            <i class="fas fa-clock"></i>
                            <span>Billing Pending OP2</span>
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
                    <h2>Billing Pending OP2</h2>
                    <p>Search and manage pending billing records for outpatient services.</p>
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
            <div class="add-form-section">
                <div class="add-form-header">
                    <i class="fas fa-search add-form-icon"></i>
                    <h3 class="add-form-title">Search Billing Paylater</h3>
                </div>
                
                <form id="searchForm" name="form1" method="post" action="billing_pending_op2.php" class="add-form">
                    <div class="form-group">
                        <label for="location" class="form-label">Location</label>
                        <select name="location" id="location" class="form-input" onchange="ajaxlocationfunction(this.value)">
                            <?php
                            $query1 = "select * from master_location where status <> 'deleted' order by locationname";
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res1 = mysqli_fetch_array($exec1)) {
                                $res1location = $res1["locationname"];
                                $res1locationcode = $res1["locationcode"];
                                $selected = ($location == $res1locationcode) ? "selected" : "";
                                echo '<option value="'.$res1locationcode.'" '.$selected.'>'.$res1location.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="searchcustomername" class="form-label">Customer Name</label>
                        <input type="text" name="searchcustomername" id="searchcustomername" class="form-input" value="<?php echo htmlspecialchars($searchcustomername); ?>" placeholder="Enter customer name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="ADate1" class="form-label">Date From</label>
                        <input type="date" name="ADate1" id="ADate1" class="form-input" value="<?php echo $fromdate; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="ADate2" class="form-label">Date To</label>
                        <input type="date" name="ADate2" id="ADate2" class="form-input" value="<?php echo $todate; ?>">
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search Pending Bills
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                    
                    <input type="hidden" name="frmflag1" value="frmflag1">
                </form>
            </div>

            <!-- Location Display -->
            <div id="ajaxlocation" class="location-display">
                <strong>📍 Current Location:</strong> <?php echo $locationname; ?>
            </div>

            <!-- Results Section -->
            <?php if ($frmflag1 == 'frmflag1' && !empty($searchcustomername)): ?>
            <div class="data-section">
                <div class="data-section-header">
                    <h3>Billing Pending Results</h3>
                    <p>Found pending billing records for: <strong><?php echo htmlspecialchars($searchcustomername); ?></strong></p>
                </div>
                
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Customer Name</th>
                            <th>Bill Number</th>
                            <th>Bill Date</th>
                            <th>Total Amount</th>
                            <th>Paid Amount</th>
                            <th>Pending Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sno = 0;
                        $totalBillAmount = 0;
                        $totalPaidAmount = 0;
                        $totalPendingAmount = 0;
                        
                        // Search for pending billing records
                        $query = "SELECT * FROM master_opbill WHERE customername LIKE '%$searchcustomername%' AND locationcode = '$locationcode' AND record_status = '1' AND (billdate BETWEEN '$fromdate' AND '$todate') ORDER BY billdate DESC";
                        $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
                        
                        while ($res = mysqli_fetch_array($exec)) {
                            $sno++;
                            $customername = $res['customername'] ?: 'N/A';
                            $billnumber = $res['billnumber'] ?: 'N/A';
                            $billdate = $res['billdate'] ?: 'N/A';
                            $totalamount = $res['totalamount'] ?: '0.00';
                            $paidamount = $res['paidamount'] ?: '0.00';
                            $pendingamount = $totalamount - $paidamount;
                            $status = $res['status'] ?: 'Pending';
                            $auto_number = $res['auto_number'];
                            
                            $totalBillAmount += floatval($totalamount);
                            $totalPaidAmount += floatval($paidamount);
                            $totalPendingAmount += floatval($pendingamount);
                            
                            // Determine status badge class
                            $statusClass = 'status-pending';
                            if (strtolower($status) == 'paid') {
                                $statusClass = 'status-active';
                            } elseif (strtolower($status) == 'cancelled') {
                                $statusClass = 'status-inactive';
                            } elseif (strtolower($status) == 'partial') {
                                $statusClass = 'status-warning';
                            }
                            
                            echo '<tr>';
                            echo '<td>' . $sno . '</td>';
                            echo '<td>' . htmlspecialchars($customername) . '</td>';
                            echo '<td>' . htmlspecialchars($billnumber) . '</td>';
                            echo '<td>' . date('Y-m-d', strtotime($billdate)) . '</td>';
                            echo '<td>₹ ' . number_format($totalamount, 2) . '</td>';
                            echo '<td>₹ ' . number_format($paidamount, 2) . '</td>';
                            echo '<td>₹ ' . number_format($pendingamount, 2) . '</td>';
                            echo '<td><span class="status-badge ' . $statusClass . '">' . ucfirst($status) . '</span></td>';
                            echo '<td class="action-buttons">';
                            echo '<a href="billing_pending_op2.php?st=success&billautonumber=' . $auto_number . '&printbill=summary" class="btn btn-info btn-sm">';
                            echo '<i class="fas fa-print"></i> Summary';
                            echo '</a>';
                            echo '<a href="billing_pending_op2.php?st=success&billautonumber=' . $auto_number . '&printbill=detailed" class="btn btn-warning btn-sm">';
                            echo '<i class="fas fa-file-alt"></i> Detailed';
                            echo '</a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        
                        if ($sno == 0) {
                            echo '<tr>';
                            echo '<td colspan="9" class="no-data">';
                            echo '<i class="fas fa-search"></i>';
                            echo '<p>No pending billing records found for the specified criteria.</p>';
                            echo '</td>';
                            echo '</tr>';
                        } else {
                            // Add total row
                            echo '<tr class="total-row">';
                            echo '<td colspan="4"><strong>Total Records: ' . $sno . '</strong></td>';
                            echo '<td><strong>₹ ' . number_format($totalBillAmount, 2) . '</strong></td>';
                            echo '<td><strong>₹ ' . number_format($totalPaidAmount, 2) . '</strong></td>';
                            echo '<td><strong>₹ ' . number_format($totalPendingAmount, 2) . '</strong></td>';
                            echo '<td colspan="2"></td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="data-section">
                <div class="data-section-header">
                    <h3>Ready to Search</h3>
                    <p>Enter customer name and select date range to search for pending billing records.</p>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <script src="js/vat-modern.js?v=<?php echo time(); ?>"></script>
    <script>
        // Additional JavaScript for billing pending op2
        function refreshPage() {
            window.location.reload();
        }
        
        function exportToExcel() {
            // Export functionality can be implemented here
            alert('Export functionality will be implemented');
        }
        
        function ajaxlocationfunction(locationcode) {
            // Location change functionality
            const locationDisplay = document.getElementById('ajaxlocation');
            if (locationDisplay) {
                locationDisplay.innerHTML = '<strong>📍 Current Location:</strong> Loading...';
            }
        }
        
        // Auto-print functionality for successful operations
        <?php if ($st == 'success' && $printbill == 'detailed'): ?>
        window.onload = function() {
            loadprintpage2('<?php echo $billautonumber; ?>');
        }
        <?php elseif ($st == 'success' && $printbill == 'summary'): ?>
        window.onload = function() {
            loadprintpage1('<?php echo $billautonumber; ?>');
        }
        <?php endif; ?>
        
        function loadprintpage1(banum) {
            var location = "<?php echo $location; ?>";
            window.open("print_paylater_summary.php?billautonumber="+banum+"","Window"+banum+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
        }
        
        function loadprintpage2(banum) {
            var location = "<?php echo $location; ?>";
            window.open("print_paylater_detailed.php?locationcode="+location+"&&billautonumber="+banum+"","Window"+banum+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
        }
    </script>
</body>
</html>
