<?php
error_reporting(0);
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

// Initialize variables
$errmsg = "";
$bgcolorcode = "";
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
$categoryid = isset($_REQUEST['categoryid']) ? $_REQUEST['categoryid'] : '';
$searchitem = isset($_REQUEST['searchitem']) ? $_REQUEST['searchitem'] : '';
$cbsuppliername = "";
$supplieranum = "";

// Handle form submissions
if (isset($_REQUEST["cbfrmflag2"])) { 
    $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; 
} else { 
    $cbfrmflag2 = ""; 
}

if (isset($_REQUEST["cbfrmflag1"])) { 
    $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; 
} else { 
    $cbfrmflag1 = ""; 
}

if (isset($_REQUEST["frmflag2"])) { 
    $frmflag2 = $_REQUEST["frmflag2"]; 
} else { 
    $frmflag2 = ""; 
}

// Handle supplier selection
if (isset($_REQUEST["canum"])) { 
    $getcanum = $_REQUEST["canum"]; 
} else { 
    $getcanum = ""; 
}

if ($getcanum != '') {
    $query4 = "select * from master_supplier where auto_number = '$getcanum'";
    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res4 = mysqli_fetch_array($exec4);
    $cbsuppliername = $res4['suppliername'];
    $supplieranum = $getcanum;
}

// Handle report generation
if ($frmflag2 == 'frmflag2') {
    $location = $_REQUEST['location'];
    $categoryid = $_REQUEST['categoryid'];
    $searchitem = $_REQUEST['searchitem'];
    
    if (empty($location)) {
        $errmsg = "Please select a location to generate the report.";
        $bgcolorcode = 'failed';
    } else {
        $errmsg = "Fixed asset detailed report generated successfully.";
        $bgcolorcode = 'success';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fixed Asset Detailed Report - MedStar</title>
    
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
        <span>Fixed Asset Detailed Report</span>
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
                    <li class="nav-item active">
                        <a href="fixedasset_detailed_report.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Fixed Asset Report</span>
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
                    <h2>Fixed Asset Detailed Report</h2>
                    <p>Generate comprehensive reports for fixed assets including depreciation and asset management.</p>
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
                    <h3 class="add-form-title">Fixed Asset - Detailed Book</h3>
                </div>
                
                <form id="reportForm" name="cbform1" method="post" action="fixedasset_detailed_report.php" class="add-form">
                    <div class="form-group">
                        <label for="location" class="form-label">Location</label>
                        <select name="location" id="location" class="form-input" onchange="ajaxlocationfunction(this.value)">
                            <option value="">Select Location</option>
                            <?php
                            $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res1 = mysqli_fetch_array($exec1)) {
                                $locationname = $res1["locationname"];
                                $locationcode = $res1["locationcode"];
                                $selected = ($location == $locationcode) ? "selected" : "";
                                echo '<option value="'.$locationcode.'" '.$selected.'>'.$locationname.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="categoryid" class="form-label">Category</label>
                        <select name="categoryid" id="categoryid" class="form-input">
                            <option value="">Select Category</option>
                            <?php
                            $query_category = "select * from master_category where status <> 'deleted' order by categoryname";
                            $exec_category = mysqli_query($GLOBALS["___mysqli_ston"], $query_category);
                            while ($res_category = mysqli_fetch_array($exec_category)) {
                                $categoryname = $res_category["categoryname"];
                                $categoryanum = $res_category["auto_number"];
                                $selected = ($categoryid == $categoryanum) ? "selected" : "";
                                echo '<option value="'.$categoryanum.'" '.$selected.'>'.$categoryname.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="searchitem" class="form-label">Search Item</label>
                        <input type="text" name="searchitem" id="searchitem" class="form-input" value="<?php echo htmlspecialchars($searchitem); ?>" placeholder="Enter item name or code">
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-chart-bar"></i> Generate Report
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                    
                    <input type="hidden" name="frmflag2" value="frmflag2">
                </form>
            </div>

            <!-- Report Results -->
            <?php if ($frmflag2 == 'frmflag2' && !empty($location)): ?>
            <div class="data-section">
                <div class="data-section-header">
                    <h3>Fixed Asset Detailed Report</h3>
                    <p>Location: <strong><?php echo htmlspecialchars($location); ?></strong> | 
                       Category: <strong><?php echo !empty($categoryid) ? 'Selected' : 'All'; ?></strong> | 
                       Search: <strong><?php echo !empty($searchitem) ? htmlspecialchars($searchitem) : 'All Items'; ?></strong></p>
                </div>
                
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Asset Code</th>
                            <th>Asset Name</th>
                            <th>Category</th>
                            <th>Purchase Date</th>
                            <th>Purchase Value</th>
                            <th>Current Value</th>
                            <th>Depreciation</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sno = 0;
                        $totalPurchaseValue = 0;
                        $totalCurrentValue = 0;
                        $totalDepreciation = 0;
                        
                        // Build query for fixed assets
                        $query_assets = "SELECT fa.*, mc.categoryname, ml.locationname 
                                        FROM master_fixedasset fa 
                                        LEFT JOIN master_category mc ON fa.categoryid = mc.auto_number 
                                        LEFT JOIN master_location ml ON fa.locationcode = ml.locationcode 
                                        WHERE fa.record_status = '1' AND fa.locationcode = '$location'";
                        
                        if (!empty($categoryid)) {
                            $query_assets .= " AND fa.categoryid = '$categoryid'";
                        }
                        
                        if (!empty($searchitem)) {
                            $query_assets .= " AND (fa.assetname LIKE '%$searchitem%' OR fa.assetcode LIKE '%$searchitem%')";
                        }
                        
                        $query_assets .= " ORDER BY fa.assetname";
                        
                        $exec_assets = mysqli_query($GLOBALS["___mysqli_ston"], $query_assets);
                        
                        while ($res_assets = mysqli_fetch_array($exec_assets)) {
                            $sno++;
                            $assetcode = $res_assets['assetcode'] ?: 'N/A';
                            $assetname = $res_assets['assetname'] ?: 'N/A';
                            $categoryname = $res_assets['categoryname'] ?: 'N/A';
                            $purchasedate = $res_assets['purchasedate'] ?: 'N/A';
                            $purchasevalue = $res_assets['purchasevalue'] ?: '0.00';
                            $currentvalue = $res_assets['currentvalue'] ?: '0.00';
                            $depreciation = $purchasevalue - $currentvalue;
                            $locationname = $res_assets['locationname'] ?: 'N/A';
                            $status = $res_assets['status'] ?: 'Active';
                            $auto_number = $res_assets['auto_number'];
                            
                            $totalPurchaseValue += floatval($purchasevalue);
                            $totalCurrentValue += floatval($currentvalue);
                            $totalDepreciation += floatval($depreciation);
                            
                            // Determine status badge class
                            $statusClass = 'status-active';
                            if (strtolower($status) == 'inactive') {
                                $statusClass = 'status-inactive';
                            } elseif (strtolower($status) == 'disposed') {
                                $statusClass = 'status-warning';
                            } elseif (strtolower($status) == 'maintenance') {
                                $statusClass = 'status-pending';
                            }
                            
                            echo '<tr>';
                            echo '<td>' . $sno . '</td>';
                            echo '<td>' . htmlspecialchars($assetcode) . '</td>';
                            echo '<td>' . htmlspecialchars($assetname) . '</td>';
                            echo '<td>' . htmlspecialchars($categoryname) . '</td>';
                            echo '<td>' . date('Y-m-d', strtotime($purchasedate)) . '</td>';
                            echo '<td>₹ ' . number_format($purchasevalue, 2) . '</td>';
                            echo '<td>₹ ' . number_format($currentvalue, 2) . '</td>';
                            echo '<td>₹ ' . number_format($depreciation, 2) . '</td>';
                            echo '<td>' . htmlspecialchars($locationname) . '</td>';
                            echo '<td><span class="status-badge ' . $statusClass . '">' . ucfirst($status) . '</span></td>';
                            echo '<td class="action-buttons">';
                            echo '<a href="fixedasset_edit.php?id=' . $auto_number . '" class="btn btn-info btn-sm">';
                            echo '<i class="fas fa-edit"></i> Edit';
                            echo '</a>';
                            echo '<a href="fixedasset_depreciation.php?id=' . $auto_number . '" class="btn btn-warning btn-sm">';
                            echo '<i class="fas fa-chart-line"></i> Depreciation';
                            echo '</a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        
                        if ($sno == 0) {
                            echo '<tr>';
                            echo '<td colspan="11" class="no-data">';
                            echo '<i class="fas fa-building"></i>';
                            echo '<p>No fixed assets found for the specified criteria.</p>';
                            echo '</td>';
                            echo '</tr>';
                        } else {
                            // Add total row
                            echo '<tr class="total-row">';
                            echo '<td colspan="5"><strong>Total Assets: ' . $sno . '</strong></td>';
                            echo '<td><strong>₹ ' . number_format($totalPurchaseValue, 2) . '</strong></td>';
                            echo '<td><strong>₹ ' . number_format($totalCurrentValue, 2) . '</strong></td>';
                            echo '<td><strong>₹ ' . number_format($totalDepreciation, 2) . '</strong></td>';
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
                    <h3>Ready to Generate Report</h3>
                    <p>Select location and optional filters to generate the fixed asset detailed report.</p>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <script src="js/vat-modern.js?v=<?php echo time(); ?>"></script>
    <script>
        // Additional JavaScript for fixed asset detailed report
        function refreshPage() {
            window.location.reload();
        }
        
        function exportToExcel() {
            if (document.getElementById('location').value) {
                // Export functionality can be implemented here
                alert('Export functionality will be implemented');
            } else {
                alert('Please select a location first to export the report.');
            }
        }
        
        function ajaxlocationfunction(locationcode) {
            // Location change functionality
            console.log('Location changed to: ' + locationcode);
        }
        
        // Assetize confirmation
        $(document).ready(function() {
            $('.executelink').click(function(){
                return confirm("Are you sure you want to Assetize?");
            });
        });
    </script>
</body>
</html>
