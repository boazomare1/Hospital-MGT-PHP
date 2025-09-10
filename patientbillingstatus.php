<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

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
$patient = '';
$patientcode = '';
$visitcode = '';

// Get default location
$query = "select * from master_location where status <> 'deleted' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);

$locationname = $res["locationname"];
$locationcode = $res["locationcode"];
$res12locationanum = $res["auto_number"];

// Get location for search purpose
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
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
    $patient = $_REQUEST["patient"];
    $patientcode = $_REQUEST["patientcode"];
    $visitcode = $_REQUEST["visitcode"];
    $location = $_REQUEST["location"];
    
    $query1 = "select * from master_location where status <> 'deleted' and locationcode = '".$locationcode."'";
    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res1 = mysqli_fetch_array($exec1);
    
    $locationname = $res1["locationname"];
    
    if (empty($patient) && empty($patientcode) && empty($visitcode)) {
        $errmsg = "Please enter at least one search criteria.";
        $bgcolorcode = 'failed';
    } else {
        $errmsg = "Search completed for patient billing status.";
        $bgcolorcode = 'success';
    }
}

// Handle delete action
if (isset($_REQUEST["st"])) { 
    $st = $_REQUEST["st"]; 
} else { 
    $st = ""; 
}

if ($st == 'del') {
    $delanum = $_REQUEST["anum"];
    $query3 = "UPDATE master_patientbilling set record_status = '0' where auto_number = '$delanum'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
    header("Location: patientbillingstatus.php?msg=deleted");
    exit();
}

if ($st == 'activate') {
    $delanum = $_REQUEST["anum"];
    $query3 = "UPDATE master_patientbilling set record_status = '1' where auto_number = '$delanum'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
    header("Location: patientbillingstatus.php?msg=activated");
    exit();
}

// Check for URL messages
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'deleted') {
        $errmsg = "Patient billing record deleted successfully.";
        $bgcolorcode = 'success';
    } elseif ($_GET['msg'] == 'activated') {
        $errmsg = "Patient billing record activated successfully.";
        $bgcolorcode = 'success';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Billing Status - MedStar</title>
    
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
        <span>Patient Billing Status</span>
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
                    <li class="nav-item active">
                        <a href="patientbillingstatus.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Patient Billing Status</span>
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
                    <h2>Patient Billing Status</h2>
                    <p>Search and view patient billing status and payment information for different locations.</p>
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
                    <h3 class="add-form-title">Search Patient Billing</h3>
                </div>
                
                <form id="searchForm" name="form1" method="post" action="patientbillingstatus.php" class="add-form">
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
                        <label for="patient" class="form-label">Patient Name</label>
                        <input type="text" name="patient" id="patient" class="form-input" value="<?php echo htmlspecialchars($patient); ?>" placeholder="Enter patient name">
                    </div>
                    
                    <div class="form-group">
                        <label for="patientcode" class="form-label">Registration No</label>
                        <input type="text" name="patientcode" id="patientcode" class="form-input" value="<?php echo htmlspecialchars($patientcode); ?>" placeholder="Enter registration number">
                    </div>
                    
                    <div class="form-group">
                        <label for="visitcode" class="form-label">Visit Code</label>
                        <input type="text" name="visitcode" id="visitcode" class="form-input" value="<?php echo htmlspecialchars($visitcode); ?>" placeholder="Enter visit code">
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search Billing Status
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
            <?php if ($frmflag1 == 'frmflag1' && (!empty($patient) || !empty($patientcode) || !empty($visitcode))): ?>
            <div class="data-section">
                <div class="data-section-header">
                    <h3>Patient Billing Status Results</h3>
                    <p>Found billing records for the specified search criteria</p>
                </div>
                
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Patient Name</th>
                            <th>Registration No</th>
                            <th>Visit Code</th>
                            <th>Bill Amount</th>
                            <th>Paid Amount</th>
                            <th>Balance</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sno = 0;
                        $totalBillAmount = 0;
                        $totalPaidAmount = 0;
                        $totalBalance = 0;
                        
                        // Build search query
                        $whereConditions = array();
                        $whereConditions[] = "locationcode = '$locationcode'";
                        $whereConditions[] = "record_status = '1'";
                        
                        if (!empty($patient)) {
                            $whereConditions[] = "patientname LIKE '%$patient%'";
                        }
                        if (!empty($patientcode)) {
                            $whereConditions[] = "patientcode LIKE '%$patientcode%'";
                        }
                        if (!empty($visitcode)) {
                            $whereConditions[] = "visitcode LIKE '%$visitcode%'";
                        }
                        
                        $whereClause = implode(' AND ', $whereConditions);
                        
                        // Search for patient billing records
                        $query = "SELECT * FROM master_patientbilling WHERE $whereClause ORDER BY recorddate DESC";
                        $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
                        
                        while ($res = mysqli_fetch_array($exec)) {
                            $sno++;
                            $patientname = $res['patientname'] ?: 'N/A';
                            $patientcode_display = $res['patientcode'] ?: 'N/A';
                            $visitcode_display = $res['visitcode'] ?: 'N/A';
                            $billamount = $res['billamount'] ?: '0.00';
                            $paidamount = $res['paidamount'] ?: '0.00';
                            $balance = $res['balance'] ?: '0.00';
                            $status = $res['status'] ?: 'Unknown';
                            $recorddate = $res['recorddate'] ?: 'N/A';
                            $auto_number = $res['auto_number'];
                            
                            $totalBillAmount += floatval($billamount);
                            $totalPaidAmount += floatval($paidamount);
                            $totalBalance += floatval($balance);
                            
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
                            echo '<td>' . htmlspecialchars($patientname) . '</td>';
                            echo '<td>' . htmlspecialchars($patientcode_display) . '</td>';
                            echo '<td>' . htmlspecialchars($visitcode_display) . '</td>';
                            echo '<td>₹ ' . number_format($billamount, 2) . '</td>';
                            echo '<td>₹ ' . number_format($paidamount, 2) . '</td>';
                            echo '<td>₹ ' . number_format($balance, 2) . '</td>';
                            echo '<td><span class="status-badge ' . $statusClass . '">' . ucfirst($status) . '</span></td>';
                            echo '<td>' . date('Y-m-d', strtotime($recorddate)) . '</td>';
                            echo '<td class="action-buttons">';
                            echo '<a href="patientbillingstatus.php?st=del&anum=' . $auto_number . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this billing record?\')">';
                            echo '<i class="fas fa-trash"></i> Delete';
                            echo '</a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        
                        if ($sno == 0) {
                            echo '<tr>';
                            echo '<td colspan="10" class="no-data">';
                            echo '<i class="fas fa-search"></i>';
                            echo '<p>No billing records found for the specified search criteria.</p>';
                            echo '</td>';
                            echo '</tr>';
                        } else {
                            // Add total row
                            echo '<tr class="total-row">';
                            echo '<td colspan="4"><strong>Total Records: ' . $sno . '</strong></td>';
                            echo '<td><strong>₹ ' . number_format($totalBillAmount, 2) . '</strong></td>';
                            echo '<td><strong>₹ ' . number_format($totalPaidAmount, 2) . '</strong></td>';
                            echo '<td><strong>₹ ' . number_format($totalBalance, 2) . '</strong></td>';
                            echo '<td colspan="3"></td>';
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
                    <p>Enter patient information and select a location to search for billing status.</p>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <script src="js/vat-modern.js?v=<?php echo time(); ?>"></script>
    <script>
        // Additional JavaScript for patient billing status
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
    </script>
</body>
</html>
