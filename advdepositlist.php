<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$docno = $_SESSION['docno'];

// Get default location
$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$locationnameget = $res1["locationname"];
$locationcodeget = $res1["locationcode"];

// Check for form submission
$searchResults = array();
$totalDeposits = 0;
$totalBalance = 0;

if (isset($_POST['submit'])) {
    $searchpatientcode = $_POST['customercode'];
    $where = "";
    
    if($searchpatientcode != "") {
        $where = " where patientcode like '%$searchpatientcode%' ";
    }
    
    $query = "select patientname,patientcode,sum(transactionamount) amt from master_transactionadvancedeposit ".$where." group by patientcode order by auto_number desc";
    $exedetail = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die("Error in query".mysqli_error($GLOBALS["___mysqli_ston"]));
    
    while($resquery = mysqli_fetch_array($exedetail)) {
        $patientname = $resquery['patientname'];
        $patientcode = $resquery['patientcode'];
        $deposit_totalamt = $resquery['amt'];
        
        $deposit_bal_amt = $deposit_totalamt;
        $all_adjust_amt = 0;
        $all_refund_amt = 0;
        
        // Get adjustment amount
        $deposit_amt_bal_query = "SELECT sum(adjustamount) usedamt FROM `adjust_advdeposits` WHERE `patientcode` = '$patientcode'";
        $bal_exec = mysqli_query($GLOBALS["___mysqli_ston"], $deposit_amt_bal_query) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        if(mysqli_num_rows($bal_exec) > 0) {
            $bal_res = mysqli_fetch_array($bal_exec);
            $all_adjust_amt = $bal_res['usedamt'];
        }
        
        // Get refund amount
        $refund_amt_bal_query = "SELECT sum(amount) as refundamt from deposit_refund where patientcode = '$patientcode' and visitcode=''";
        $refund_bal_exec = mysqli_query($GLOBALS["___mysqli_ston"], $refund_amt_bal_query) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        if(mysqli_num_rows($refund_bal_exec) > 0) {
            $refund_bal_res = mysqli_fetch_array($refund_bal_exec);
            $all_refund_amt = $refund_bal_res['refundamt'];
        }
        
        $deposit_bal_amt = ($deposit_totalamt - ($all_adjust_amt + $all_refund_amt));
        
        $searchResults[] = array(
            'patientname' => $patientname,
            'patientcode' => $patientcode,
            'deposit_totalamt' => $deposit_totalamt,
            'deposit_bal_amt' => $deposit_bal_amt
        );
        
        $totalDeposits += $deposit_totalamt;
        $totalBalance += $deposit_bal_amt;
    }
} else {
    // Show all records by default
    $query = "select patientname,patientcode,sum(transactionamount) amt from master_transactionadvancedeposit group by patientcode order by auto_number desc";
    $exedetail = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die("Error in query".mysqli_error($GLOBALS["___mysqli_ston"]));
    
    while($resquery = mysqli_fetch_array($exedetail)) {
        $patientname = $resquery['patientname'];
        $patientcode = $resquery['patientcode'];
        $deposit_totalamt = $resquery['amt'];
        
        $deposit_bal_amt = $deposit_totalamt;
        $all_adjust_amt = 0;
        $all_refund_amt = 0;
        
        // Get adjustment amount
        $deposit_amt_bal_query = "SELECT sum(adjustamount) usedamt FROM `adjust_advdeposits` WHERE `patientcode` = '$patientcode'";
        $bal_exec = mysqli_query($GLOBALS["___mysqli_ston"], $deposit_amt_bal_query) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        if(mysqli_num_rows($bal_exec) > 0) {
            $bal_res = mysqli_fetch_array($bal_exec);
            $all_adjust_amt = $bal_res['usedamt'];
        }
        
        // Get refund amount
        $refund_amt_bal_query = "SELECT sum(amount) as refundamt from deposit_refund where patientcode = '$patientcode' and visitcode=''";
        $refund_bal_exec = mysqli_query($GLOBALS["___mysqli_ston"], $refund_amt_bal_query) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        if(mysqli_num_rows($refund_bal_exec) > 0) {
            $refund_bal_res = mysqli_fetch_array($refund_bal_exec);
            $all_refund_amt = $refund_bal_res['refundamt'];
        }
        
        $deposit_bal_amt = ($deposit_totalamt - ($all_adjust_amt + $all_refund_amt));
        
        $searchResults[] = array(
            'patientname' => $patientname,
            'patientcode' => $patientcode,
            'deposit_totalamt' => $deposit_totalamt,
            'deposit_bal_amt' => $deposit_bal_amt
        );
        
        $totalDeposits += $deposit_totalamt;
        $totalBalance += $deposit_bal_amt;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advance Deposit List - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/advdepositlist-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Autocomplete CSS -->
    <link href="autocomplete.css" rel="stylesheet">
    
    <!-- Autocomplete JavaScript -->
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js"></script>
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
        <span>Advance Deposit List</span>
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
                        <a href="ipadmissionsummaryreport.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>IP Admission Summary Report</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="advdepositlist.php" class="nav-link">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Advance Deposit List</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Advance Deposit List</h2>
                    <p>Search and manage advance deposits for patients with comprehensive balance tracking.</p>
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
            <div class="search-form-section">
                <div class="search-form-header">
                    <i class="fas fa-search search-form-icon"></i>
                    <h3 class="search-form-title">Patient Search</h3>
                </div>
                
                <form name="cbform1" method="post" action="advdepositlist.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="customer" class="form-label">Patient Search</label>
                            <input type="text" name="customer" id="customer" class="form-input" 
                                   placeholder="Search by First Name | Middle Name | Last Name | Date of Birth | Location | Mobile Number | National ID | Registration No" 
                                   autocomplete="off">
                            <small class="form-help">Use "|" symbol to skip sequence in search</small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="locationnameget" class="form-label">Current Location</label>
                            <input type="text" name="locationnameget" id="locationnameget" 
                                   value="<?php echo htmlspecialchars($locationnameget); ?>" 
                                   class="form-input" readonly>
                        </div>
                    </div>

                    <div class="form-actions">
                        <input type="hidden" name="customercode" id="customercode" value="">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" name="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search Deposits
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Results Section -->
            <div class="results-section">
                <div class="results-header">
                    <div class="results-title">
                        <i class="fas fa-list results-icon"></i>
                        <h3>Deposit Results</h3>
                        <span class="results-count">Total Records: <?php echo count($searchResults); ?></span>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="search-bar">
                    <input type="text" id="searchInput" class="form-input" 
                           placeholder="Search patient name, code, or amount..." 
                           oninput="searchTable(this.value)">
                    <button type="button" class="btn btn-secondary" onclick="clearSearch()">
                        <i class="fas fa-times"></i> Clear
                    </button>
                </div>

                <div class="table-container">
                    <table class="data-table" id="depositTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Patient Name</th>
                                <th>Patient Code</th>
                                <th>Total Deposit</th>
                                <th>Balance Amount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($searchResults) > 0): ?>
                                <?php foreach ($searchResults as $index => $result): ?>
                                    <tr>
                                        <td class="text-center"><?php echo $index + 1; ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($result['patientname']); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($result['patientcode']); ?></td>
                                        <td class="text-right amount-cell">
                                            <span class="amount-badge deposit-amount">
                                                <?php echo number_format($result['deposit_totalamt'], 2, '.', ','); ?>
                                            </span>
                                        </td>
                                        <td class="text-right amount-cell">
                                            <span class="amount-badge <?php echo $result['deposit_bal_amt'] >= 0 ? 'balance-positive' : 'balance-negative'; ?>">
                                                <?php echo number_format($result['deposit_bal_amt'], 2, '.', ','); ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="action-buttons">
                                                <a href="advdepositstmt.php?patientcode=<?php echo urlencode($result['patientcode']); ?>" 
                                                   class="action-btn statement" title="View Statement" target="_blank">
                                                    <i class="fas fa-file-alt"></i> Statement
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center no-records">
                                        <i class="fas fa-info-circle"></i> No Records Found
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Summary Section -->
                <?php if (count($searchResults) > 0): ?>
                <div class="summary-section">
                    <div class="summary-row">
                        <div class="summary-item">
                            <span class="summary-label">Total Deposits:</span>
                            <span class="summary-value deposit-total">
                                <?php echo number_format($totalDeposits, 2, '.', ','); ?>
                            </span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Total Balance:</span>
                            <span class="summary-value <?php echo $totalBalance >= 0 ? 'balance-positive' : 'balance-negative'; ?>">
                                <?php echo number_format($totalBalance, 2, '.', ','); ?>
                            </span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Total Patients:</span>
                            <span class="summary-value"><?php echo count($searchResults); ?></span>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/advdepositlist-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Autocomplete Script -->
    <script>
        $(function() {
            $('#customer').autocomplete({
                source: 'ajaxcustomernewserach.php',
                minLength: 3,
                delay: 0,
                html: true,
                select: function(event, ui) {
                    var code = ui.item.id;
                    var customercode = ui.item.customercode;
                    var accountname = ui.item.accountname;
                    $('#customercode').val(customercode);
                    $('#patientcode').val(customercode);
                },
            });
        });
    </script>
</body>
</html>



