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
$currentdate = date("Y-m-d");

// Initialize variables
$grandtotal = '0.00';
$searchcustomername = '';
$patientfirstname = '';
$visitcode = '';
$customername = '';
$cbcustomername = '';
$cbbillnumber = '';
$cbbillstatus = '';
$paymenttype = '';
$billstatus = '';
$res2loopcount = '';
$custid = '';
$visitcode1 = '';
$res2username = '';
$custname = '';
$colorloopcount = '';
$sno = '';
$customercode = '';
$totalsalesamount = '0.00';
$totalsalesreturnamount = '0.00';
$netcollectionamount = '0.00';
$netpaymentamount = '0.00';
$res2total = '0.00';
$cashamount = '0.00';
$cardamount = '0.00';
$chequeamount = '0.00';
$onlineamount = '0.00';
$total = '0.00';
$cashtotal = '0.00';
$cardtotal = '0.00';
$chequetotal = '0.00';
$onlinetotal = '0.00';

// Get form data
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
$billtype = isset($_REQUEST['billtype']) ? $_REQUEST['billtype'] : '';
$searchpatientcode = isset($_REQUEST['searchpatientcode']) ? $_REQUEST['searchpatientcode'] : '';
$searchvisitcode = isset($_REQUEST['searchvisitcode']) ? $_REQUEST['searchvisitcode'] : '';
$searchbillnumber = isset($_REQUEST['searchbillnumber']) ? $_REQUEST['searchbillnumber'] : '';
$transactiondatefrom = isset($_REQUEST['ADate1']) ? $_REQUEST['ADate1'] : date('Y-m-d', strtotime('-1 month'));
$transactiondateto = isset($_REQUEST['ADate2']) ? $_REQUEST['ADate2'] : date('Y-m-d');

// Handle form submission
if (isset($_REQUEST["cbfrmflag1"]) && $_REQUEST["cbfrmflag1"] == 'cbfrmflag1') {
    $billtype = $_POST['billtype'];
    $searchpatientcode = $_POST['searchpatientcode'];
    $searchvisitcode = $_POST['searchvisitcode'];
    $searchbillnumber = $_POST['searchbillnumber'];
    $location = $_POST['location'];
    $transactiondatefrom = $_POST['ADate1'];
    $transactiondateto = $_POST['ADate2'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bill Enquiry Report</title>
<!-- Modern CSS -->
<link href="css/billenquiry-modern.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <!-- Modern Header -->
    <header class="hospital-header">
        <div class="hospital-title">MedStar Hospital Management</div>
        <div class="hospital-subtitle">Bill Enquiry Report</div>
    </header>

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
                        <a href="billenquiry.php" class="nav-link active">
                            <i class="fas fa-search"></i>
                            <span>Bill Enquiry</span>
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
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">Bill Enquiry Report</h1>
                <p class="page-subtitle">Search and view detailed bill information across different bill types</p>
            </div>

            <!-- Filter Container -->
            <div class="filter-container">
                <div class="filter-header">
                    <i class="fas fa-filter"></i>
                    Search Filters
                </div>
                
                <form name="cbform1" method="post" action="billenquiry.php">
                    <div class="filter-row">
                        <div class="filter-group">
                            <label for="billtype">Bill Type</label>
                            <select name="billtype" id="billtype" class="form-control" required>
                                <option value="">Select Type</option>
                                <option value="1" <?php if($billtype==1) echo 'selected'; ?>>OP (Outpatient)</option>
                                <option value="2" <?php if($billtype==2) echo 'selected'; ?>>IP (Inpatient)</option>
                                <option value="3" <?php if($billtype==3) echo 'selected'; ?>>Advance Deposit</option>
                                <option value="4" <?php if($billtype==4) echo 'selected'; ?>>Allocation</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="location">Location</label>
                            <select name="location" id="location" class="form-control" required>
                                <option value="">Select Location</option>
                                <?php
                                $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
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
                    </div>
                    
                    <div class="filter-row">
                        <div class="filter-group">
                            <label for="searchpatientcode">Registration No</label>
                            <input type="text" name="searchpatientcode" id="searchpatientcode" class="form-control" value="<?php echo htmlspecialchars($searchpatientcode); ?>" placeholder="Enter patient registration number">
                        </div>
                        
                        <div class="filter-group">
                            <label for="searchvisitcode">Visit No</label>
                            <input type="text" name="searchvisitcode" id="searchvisitcode" class="form-control" value="<?php echo htmlspecialchars($searchvisitcode); ?>" placeholder="Enter visit number">
                        </div>
                        
                        <div class="filter-group">
                            <label for="searchbillnumber">Bill No</label>
                            <input type="text" name="searchbillnumber" id="searchbillnumber" class="form-control" value="<?php echo htmlspecialchars($searchbillnumber); ?>" placeholder="Enter bill number">
                        </div>
                    </div>
                    
                    <div class="btn-group">
                        <button type="submit" name="Submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                            Search Bills
                        </button>
                        <button type="reset" name="resetbutton" class="btn btn-secondary">
                            <i class="fas fa-undo"></i>
                            Reset
                        </button>
                        <button type="button" id="exportBtn" class="btn btn-success">
                            <i class="fas fa-download"></i>
                            Export
                        </button>
                        <button type="button" id="printBtn" class="btn btn-warning">
                            <i class="fas fa-print"></i>
                            Print
                        </button>
                    </div>
                    
                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                </form>
            </div>

            <!-- Location Display -->
            <div id="ajaxlocation" class="location-display">
                <?php
                if ($location != '') {
                    $query12 = "select locationname,locationcode from master_location where locationcode='$location' order by locationname";
                    $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res12 = mysqli_fetch_array($exec12);
                    echo '<strong>Location:</strong> ' . $res12["locationname"];
                } else {
                    $query1 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res1 = mysqli_fetch_array($exec1);
                    echo '<strong>Location:</strong> ' . $res1["locationname"];
                }
                ?>
            </div>

            <!-- Results Container -->
            <?php
            if (isset($_REQUEST["cbfrmflag1"]) && $_REQUEST["cbfrmflag1"] == 'cbfrmflag1') {
                echo '<div class="table-container">';
                echo '<div class="report-header">';
                echo '<h3>Bill Enquiry Results</h3>';
                echo '<p>Generated on ' . date('Y-m-d H:i:s') . ' | Location: ' . $location . ' | Bill Type: ' . $billtype . '</p>';
                echo '</div>';
                
                echo '<div class="report-content">';
                echo '<table class="modern-table">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>S.No.</th>';
                echo '<th>Patient Name</th>';
                echo '<th>Reg.No</th>';
                echo '<th>Visit No</th>';
                echo '<th>Sub Type</th>';
                echo '<th>Account</th>';
                echo '<th>Bill No</th>';
                echo '<th>Bill Amount</th>';
                echo '<th>Bill Date</th>';
                echo '<th>Status</th>';
                echo '<th>Action</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                
                $sno = 0;
                $totalAmount = 0;
                
                // Build query based on bill type and search criteria
                $whereConditions = array();
                $whereConditions[] = "locationcode = '$location'";
                
                if ($searchpatientcode) {
                    $whereConditions[] = "patientcode LIKE '%$searchpatientcode%'";
                }
                if ($searchvisitcode) {
                    $whereConditions[] = "visitcode LIKE '%$searchvisitcode%'";
                }
                if ($searchbillnumber) {
                    $whereConditions[] = "billnumber LIKE '%$searchbillnumber%'";
                }
                
                $whereClause = implode(' AND ', $whereConditions);
                
                // Query based on bill type
                if ($billtype == 1) { // OP
                    $query = "SELECT * FROM master_opbill WHERE $whereClause ORDER BY recorddate DESC";
                } elseif ($billtype == 2) { // IP
                    $query = "SELECT * FROM master_ipbill WHERE $whereClause ORDER BY recorddate DESC";
                } elseif ($billtype == 3) { // Advance Deposit
                    $query = "SELECT * FROM master_advance WHERE $whereClause ORDER BY recorddate DESC";
                } elseif ($billtype == 4) { // Allocation
                    $query = "SELECT * FROM master_allocation WHERE $whereClause ORDER BY recorddate DESC";
                } else {
                    // All types - union query
                    $query = "SELECT *, 'OP' as bill_type FROM master_opbill WHERE $whereClause 
                              UNION ALL 
                              SELECT *, 'IP' as bill_type FROM master_ipbill WHERE $whereClause 
                              UNION ALL 
                              SELECT *, 'ADVANCE' as bill_type FROM master_advance WHERE $whereClause 
                              UNION ALL 
                              SELECT *, 'ALLOCATION' as bill_type FROM master_allocation WHERE $whereClause 
                              ORDER BY recorddate DESC";
                }
                
                $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
                
                while ($res = mysqli_fetch_array($exec)) {
                    $sno++;
                    $patientname = $res['patientname'] ?: 'N/A';
                    $patientcode = $res['patientcode'] ?: 'N/A';
                    $visitcode = $res['visitcode'] ?: 'N/A';
                    $subtype = $res['subtype'] ?: 'N/A';
                    $accountname = $res['accountname'] ?: 'N/A';
                    $billnumber = $res['billnumber'] ?: 'N/A';
                    $billamount = $res['billamount'] ?: '0.00';
                    $billdate = $res['recorddate'] ?: 'N/A';
                    $billstatus = $res['billstatus'] ?: 'Unknown';
                    $billtype_display = isset($res['bill_type']) ? $res['bill_type'] : $billtype;
                    
                    $totalAmount += floatval($billamount);
                    
                    // Determine status badge class
                    $statusClass = 'pending';
                    if (strtolower($billstatus) == 'paid') {
                        $statusClass = 'paid';
                    } elseif (strtolower($billstatus) == 'cancelled') {
                        $statusClass = 'cancelled';
                    } elseif (strtolower($billstatus) == 'partial') {
                        $statusClass = 'partial';
                    }
                    
                    // Determine bill type badge class
                    $billTypeClass = 'op';
                    if ($billtype_display == 'IP') {
                        $billTypeClass = 'ip';
                    } elseif ($billtype_display == 'ADVANCE') {
                        $billTypeClass = 'deposit';
                    } elseif ($billtype_display == 'ALLOCATION') {
                        $billTypeClass = 'allocation';
                    }
                    
                    echo '<tr>';
                    echo '<td>' . $sno . '</td>';
                    echo '<td>' . htmlspecialchars($patientname) . '</td>';
                    echo '<td>' . htmlspecialchars($patientcode) . '</td>';
                    echo '<td>' . htmlspecialchars($visitcode) . '</td>';
                    echo '<td><span class="bill-type-badge ' . $billTypeClass . '">' . $billtype_display . '</span></td>';
                    echo '<td>' . htmlspecialchars($accountname) . '</td>';
                    echo '<td>' . htmlspecialchars($billnumber) . '</td>';
                    echo '<td>₹ ' . number_format($billamount, 2) . '</td>';
                    echo '<td>' . date('Y-m-d', strtotime($billdate)) . '</td>';
                    echo '<td><span class="status-badge ' . $statusClass . '">' . ucfirst($billstatus) . '</span></td>';
                    echo '<td>';
                    echo '<div class="action-buttons">';
                    echo '<a href="viewbill.php?billnumber=' . $billnumber . '&billtype=' . $billtype . '" class="action-btn view">';
                    echo '<i class="fas fa-eye"></i> View';
                    echo '</a>';
                    echo '<a href="printbill.php?billnumber=' . $billnumber . '&billtype=' . $billtype . '" class="action-btn print">';
                    echo '<i class="fas fa-print"></i> Print';
                    echo '</a>';
                    echo '</div>';
                    echo '</td>';
                    echo '</tr>';
                }
                
                if ($sno == 0) {
                    echo '<tr>';
                    echo '<td colspan="11" class="no-results">';
                    echo '<i class="fas fa-search"></i>';
                    echo '<h3>No bills found</h3>';
                    echo '<p>Try adjusting your search criteria or check if the location and bill type are correct.</p>';
                    echo '</td>';
                    echo '</tr>';
                } else {
                    // Add total row
                    echo '<tr style="background: var(--gray-100); font-weight: bold;">';
                    echo '<td colspan="7">Total Bills: ' . $sno . '</td>';
                    echo '<td>₹ ' . number_format($totalAmount, 2) . '</td>';
                    echo '<td colspan="3"></td>';
                    echo '</tr>';
                }
                
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                echo '</div>';
            } else {
                echo '<div class="report-content">';
                echo '<h3>Ready to Search Bills</h3>';
                echo '<p>Select a bill type, location, and enter search criteria to view bill information.</p>';
                echo '</div>';
            }
            ?>
        </main>
    </div>

    <!-- Modern Footer -->
    <footer>
        <div class="footer-container">
            <p>&copy; <?php echo date('Y'); ?> MedStar Hospital Management System. All rights reserved.</p>
        </div>
    </footer>

    <!-- Modern JavaScript -->
    <script src="js/billenquiry-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
