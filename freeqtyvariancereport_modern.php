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
$sno = '';
$colorloopcount = '';
$searchemployeename = '';
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');

// Handle form parameters
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
if (isset($_REQUEST["cbfrmflag1"])) { 
    $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; 
} else { 
    $cbfrmflag1 = ""; 
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

$locationcode1 = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';

// Initialize report data
$reportData = [];
$totalPofree = 0;
$totalGrnfree = 0;
$totalVariance = 0;

// Process form submission
if ($cbfrmflag1 == 'cbfrmflag1') {
    $query31 = "SELECT pod.billnumber, pod.itemname, IF(pod.free IS NULL or pod.free = '', 0, pod.free) as pofree, IF(mrd.free IS NULL or mrd.free = '', 0, mrd.free) as grnfree, pod.suppliername FROM `purchaseorder_details` pod inner join materialreceiptnote_details mrd on pod.billnumber = mrd.ponumber where pod.billdate between '$ADate1' and '$ADate2' group by pod.billnumber, pod.itemcode order by pod.auto_number desc";
    
    $exe31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die("Error in Query31" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $num1 = mysqli_num_rows($exe31);
    
    $sno = 1;
    $colorloopcount = 0;
    
    while ($res31 = mysqli_fetch_array($exe31)) {
        $pobillnumber = $res31["billnumber"];
        $itemname = $res31["itemname"];
        $pofree = $res31["pofree"];
        $grnfree = $res31["grnfree"];
        $suppliername = $res31["suppliername"];
        $variance = $pofree - $grnfree;
        
        // Add to totals
        $totalPofree += $pofree;
        $totalGrnfree += $grnfree;
        $totalVariance += $variance;
        
        $colorloopcount++;
        $showcolor = ($colorloopcount & 1);
        $colorcode = ($showcolor == 0) ? 'even' : 'odd';
        
        // Store report data
        $reportData[] = [
            'sno' => $sno,
            'po_number' => $pobillnumber,
            'supplier_name' => $suppliername,
            'item_name' => $itemname,
            'po_free_qty' => $pofree,
            'grn_free_qty' => $grnfree,
            'variance_qty' => $variance,
            'row_class' => $colorcode
        ];
        
        $sno++;
    }
}

// Get location name for display
$locationName = 'All Locations';
if ($location != '') {
    $query12 = "select locationname from master_location where locationcode='$location' order by locationname";
    $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12" . mysqli_error($GLOBALS["___mysqli_ston"]));
    if ($exec12 && mysqli_num_rows($exec12) > 0) {
        $res12 = mysqli_fetch_array($exec12);
        $locationName = $res12["locationname"];
    }
} else {
    $query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
    if ($exec1 && mysqli_num_rows($exec1) > 0) {
        $res1 = mysqli_fetch_array($exec1);
        $locationName = $res1["locationname"];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Free Quantity Variance Report - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/free-qty-variance-modern.css?v=<?php echo time(); ?>">
    
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
        <span>Free Quantity Variance Report</span>
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
                    <li class="nav-item">
                        <a href="revenue_vs_footfall.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Revenue vs Footfall</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="freeqtyvariancereport.php" class="nav-link">
                            <i class="fas fa-balance-scale"></i>
                            <span>Free Qty Variance</span>
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
                    <h2>Free Quantity Variance Report</h2>
                    <p>Analyze variance between Purchase Order and Goods Received Note free quantities.</p>
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
                
                <form name="cbform1" method="post" action="freeqtyvariancereport.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">
                                <i class="fas fa-calendar-alt"></i>
                                Date From
                            </label>
                            <div class="date-input-group">
                                <input name="ADate1" id="ADate1" class="form-input date-input" 
                                       value="<?php echo htmlspecialchars($paymentreceiveddateto); ?>" 
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
                                       value="<?php echo htmlspecialchars($paymentreceiveddateto); ?>" 
                                       readonly onKeyDown="return disableEnterKey()">
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')"
                                     class="date-picker-icon" alt="Select Date">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="location" class="form-label">
                                <i class="fas fa-map-marker-alt"></i>
                                Location
                            </label>
                            <select name="location" id="location" class="form-input" onChange="ajaxlocationfunction(this.value);">
                                <?php
                                $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $locationname = $res1["locationname"];
                                    $locationcode = $res1["locationcode"];
                                ?>
                                    <option value="<?php echo $locationcode; ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>><?php echo htmlspecialchars($locationname); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
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
                            <i class="fas fa-file-invoice"></i>
                        </div>
                        <div class="summary-content">
                            <h3><?php echo count($reportData); ?></h3>
                            <p>Total Records</p>
                        </div>
                    </div>
                    
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <div class="summary-content">
                            <h3><?php echo number_format($totalPofree, 0, '.', ','); ?></h3>
                            <p>Total PO Free Qty</p>
                        </div>
                    </div>
                    
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="summary-content">
                            <h3><?php echo number_format($totalGrnfree, 0, '.', ','); ?></h3>
                            <p>Total GRN Free Qty</p>
                        </div>
                    </div>
                    
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                        <div class="summary-content">
                            <h3><?php echo number_format($totalVariance, 0, '.', ','); ?></h3>
                            <p>Total Variance</p>
                        </div>
                    </div>
                </div>

                <!-- Report Section -->
                <div class="report-section">
                    <div class="report-header">
                        <div class="report-title-section">
                            <i class="fas fa-balance-scale report-icon"></i>
                            <h3 class="report-title">Free Quantity Variance Analysis</h3>
                            <div class="report-period">
                                <span><?php echo date('d/m/Y', strtotime($ADate1)); ?> - <?php echo date('d/m/Y', strtotime($ADate2)); ?></span>
                            </div>
                        </div>
                        <div class="report-actions">
                            <button type="button" class="btn btn-outline btn-sm" onclick="toggleVarianceView()">
                                <i class="fas fa-chart-bar"></i> Chart View
                            </button>
                        </div>
                    </div>

                    <!-- Modern Data Table -->
                    <div class="modern-table-container">
                        <table class="modern-data-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>PO Number</th>
                                    <th>Supplier Name</th>
                                    <th>Item Name</th>
                                    <th>PO Free Qty</th>
                                    <th>GRN Free Qty</th>
                                    <th>Variance Qty</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($reportData as $data): ?>
                                    <tr class="table-row <?php echo $data['row_class']; ?>">
                                        <td><?php echo $data['sno']; ?></td>
                                        <td>
                                            <span class="po-number-badge"><?php echo htmlspecialchars($data['po_number']); ?></span>
                                        </td>
                                        <td><?php echo htmlspecialchars($data['supplier_name']); ?></td>
                                        <td><?php echo htmlspecialchars($data['item_name']); ?></td>
                                        <td>
                                            <span class="po-qty-badge"><?php echo number_format($data['po_free_qty'], 0, '.', ','); ?></span>
                                        </td>
                                        <td>
                                            <span class="grn-qty-badge"><?php echo number_format($data['grn_free_qty'], 0, '.', ','); ?></span>
                                        </td>
                                        <td>
                                            <span class="variance-badge variance-<?php echo $data['variance_qty'] > 0 ? 'positive' : ($data['variance_qty'] < 0 ? 'negative' : 'zero'); ?>">
                                                <?php echo number_format($data['variance_qty'], 0, '.', ','); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="variance-status variance-<?php echo $data['variance_qty'] > 0 ? 'positive' : ($data['variance_qty'] < 0 ? 'negative' : 'zero'); ?>">
                                                <i class="fas fa-<?php echo $data['variance_qty'] > 0 ? 'arrow-up' : ($data['variance_qty'] < 0 ? 'arrow-down' : 'equals'); ?>"></i>
                                                <span><?php echo $data['variance_qty'] > 0 ? 'Positive' : ($data['variance_qty'] < 0 ? 'Negative' : 'Zero'); ?></span>
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
                        <i class="fas fa-chart-bar chart-icon"></i>
                        <h3 class="chart-title">Variance Analysis Chart</h3>
                    </div>
                    <div class="chart-container">
                        <canvas id="varianceChart"></canvas>
                    </div>
                </div>
            <?php elseif ($cbfrmflag1 == 'cbfrmflag1'): ?>
                <div class="no-results-message">
                    <i class="fas fa-balance-scale"></i>
                    <h3>No Data Found</h3>
                    <p>No free quantity variance data found for the selected criteria.</p>
                    <button type="button" class="btn btn-primary" onclick="resetForm()">
                        <i class="fas fa-undo"></i> Try Different Criteria
                    </button>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/free-qty-variance-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Chart.js for charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Legacy JavaScript functions -->
    <script type="text/javascript">
        function ajaxlocationfunction(val) {
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("ajaxlocation").innerHTML = xmlhttp.responseText;
                }
            }
            
            xmlhttp.open("GET", "ajax/ajaxgetlocationname.php?loccode=" + val, true);
            xmlhttp.send();
        }
        
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

