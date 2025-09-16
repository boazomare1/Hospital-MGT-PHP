<?php
session_start();
error_reporting(0);

include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

// Initialize totals
$totalamount1_final = 0;
$totalamount301_final = 0;
$totalamount601_final = 0;
$totalamount901_final = 0;
$totalamount1201_final = 0;
$totalamount1801_final = 0;
$totalamount2101_final = 0;
$totalamount2401_final = 0;

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

// Handle form submission
if (isset($_REQUEST["searchsuppliername1"])) { 
    $searchsuppliername1 = $_REQUEST["searchsuppliername1"]; 
} else { 
    $searchsuppliername1 = ""; 
}

if (isset($_REQUEST["searchsuppliername"])) { 
    $searchsuppliername = $_REQUEST["searchsuppliername"]; 
} else { 
    $searchsuppliername = ""; 
}

if (isset($_REQUEST["ADate1"])) { 
    $ADate1 = $_REQUEST["ADate1"]; 
} else { 
    $ADate1 = $transactiondatefrom; 
}

if (isset($_REQUEST["ADate2"])) { 
    $ADate2 = $_REQUEST["ADate2"]; 
} else { 
    $ADate2 = $transactiondateto; 
}

// Handle status messages
if (isset($_REQUEST["st"])) { 
    $st = $_REQUEST["st"]; 
} else { 
    $st = ""; 
}

if ($st == 'success') {
    $errmsg = "Success. Analysis completed.";
    $bgcolorcode = 'success';
} else if ($st == 'failed') {
    $errmsg = "Failed. Analysis could not be completed.";
    $bgcolorcode = 'failed';
}

// Get creditor analysis data
$creditorData = [];
$summaryData = [];

if ($ADate1 != '' && $ADate2 != '') {
    // Get supplier data
    $query212 = "SELECT suppliercode, suppliername FROM master_transactionpharmacy 
                 WHERE transactiondate BETWEEN '$ADate1' AND '$ADate2' 
                 AND transactiontype = 'PURCHASE' 
                 GROUP BY suppliername 
                 ORDER BY suppliername DESC";
    
    $exec212 = mysqli_query($GLOBALS["___mysqli_ston"], $query212) or die("Error in Query212: " . mysqli_error($GLOBALS["___mysqli_ston"]));
    
    while ($res212 = mysqli_fetch_array($exec212)) {
        $suppliercode = $res212['suppliercode'];
        $suppliername = $res212['suppliername'];
        
        // Get account details
        $query222 = "SELECT * FROM master_accountname WHERE id = '$suppliercode' AND recordstatus <> 'DELETED'";
        $exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die("Error in Query222: " . mysqli_error($GLOBALS["___mysqli_ston"]));
        $res222 = mysqli_fetch_array($exec222);
        
        if ($res222) {
            $accountname = $res222['accountname'];
            $accountcode = $res222['accountcode'];
            
            // Get purchase data
            $query1 = "SELECT * FROM master_purchase 
                       WHERE suppliercode = '$suppliercode' 
                       AND recordstatus <> 'deleted' 
                       AND billdate BETWEEN '$ADate1' AND '$ADate2' 
                       AND companyanum = '$companyanum' 
                       GROUP BY billnumber 
                       ORDER BY billdate ASC";
            
            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1: " . mysqli_error($GLOBALS["___mysqli_ston"]));
            
            $supplierTotal = 0;
            $supplierPayments = 0;
            $supplierReturns = 0;
            
            while ($res1 = mysqli_fetch_array($exec1)) {
                $billnumber = $res1['billnumber'];
                $billdate = $res1['billdate'];
                $billamount = $res1['totalamount'];
                
                // Get payment data
                $query3 = "SELECT SUM(transactionamount) as transactionamount1 
                           FROM master_transactionpharmacy 
                           WHERE suppliercode = '$suppliercode' 
                           AND billnumber = '$billnumber' 
                           AND transactiontype = 'PAYMENT' 
                           AND recordstatus = 'allocated' 
                           AND transactiondate BETWEEN '$ADate1' AND '$ADate2'";
                
                $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die("Error in Query3: " . mysqli_error($GLOBALS["___mysqli_ston"]));
                $res3 = mysqli_fetch_array($exec3);
                $paymentAmount = $res3['transactionamount1'] ?: 0;
                
                // Get return data
                $query4 = "SELECT SUM(subtotal) as totalreturn 
                           FROM purchasereturn_details 
                           WHERE suppliercode = '$suppliercode' 
                           AND grnbillnumber = '$billnumber' 
                           AND entrydate BETWEEN '$ADate1' AND '$ADate2'";
                
                $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die("Error in Query4: " . mysqli_error($GLOBALS["___mysqli_ston"]));
                $res4 = mysqli_fetch_array($exec4);
                $returnAmount = $res4['totalreturn'] ?: 0;
                
                $supplierTotal += $billamount;
                $supplierPayments += $paymentAmount;
                $supplierReturns += $returnAmount;
                
                // Calculate age analysis
                $daysDiff = (strtotime($ADate2) - strtotime($billdate)) / (60 * 60 * 24);
                $outstandingAmount = $billamount - $paymentAmount - $returnAmount;
                
                if ($outstandingAmount > 0) {
                    if ($daysDiff <= 30) {
                        $totalamount1_final += $outstandingAmount;
                    } elseif ($daysDiff <= 60) {
                        $totalamount301_final += $outstandingAmount;
                    } elseif ($daysDiff <= 90) {
                        $totalamount601_final += $outstandingAmount;
                    } elseif ($daysDiff <= 120) {
                        $totalamount901_final += $outstandingAmount;
                    } elseif ($daysDiff <= 180) {
                        $totalamount1201_final += $outstandingAmount;
                    } elseif ($daysDiff <= 210) {
                        $totalamount1801_final += $outstandingAmount;
                    } elseif ($daysDiff <= 240) {
                        $totalamount2101_final += $outstandingAmount;
                    } else {
                        $totalamount2401_final += $outstandingAmount;
                    }
                }
            }
            
            $creditorData[] = [
                'suppliercode' => $suppliercode,
                'suppliername' => $suppliername,
                'accountname' => $accountname,
                'totalamount' => $supplierTotal,
                'payments' => $supplierPayments,
                'returns' => $supplierReturns,
                'outstanding' => $supplierTotal - $supplierPayments - $supplierReturns
            ];
        }
    }
    
    // Prepare summary data
    $summaryData = [
        '0-30' => $totalamount1_final,
        '31-60' => $totalamount301_final,
        '61-90' => $totalamount601_final,
        '91-120' => $totalamount901_final,
        '121-180' => $totalamount1201_final,
        '181-210' => $totalamount1801_final,
        '211-240' => $totalamount2101_final,
        '240+' => $totalamount2401_final
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Full Creditor Analysis - Summary & Detailed - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/fullcreditoranalysis_summary_detailed-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker CSS -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- Date Picker Scripts -->
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
        <span>Full Creditor Analysis</span>
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
                        <a href="supplier1.php" class="nav-link">
                            <i class="fas fa-truck"></i>
                            <span>Suppliers</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="purchase1.php" class="nav-link">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Purchases</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="payment1.php" class="nav-link">
                            <i class="fas fa-credit-card"></i>
                            <span>Payments</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="fullcreditoranalysis_summary_detailed.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Creditor Analysis</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="reports1.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Reports</span>
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
                    <h2>Full Creditor Analysis - Summary & Detailed</h2>
                    <p>Comprehensive analysis of creditor accounts with age-wise outstanding amounts and detailed breakdowns.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportResults()">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>
            </div>

            <!-- Search Form Section -->
            <div class="search-form-section">
                <div class="search-form-header">
                    <i class="fas fa-search search-form-icon"></i>
                    <h3 class="search-form-title">Analysis Parameters</h3>
                </div>
                
                <form id="searchForm" name="cbform1" method="post" action="fullcreditoranalysis_summary_detailed.php" class="search-form">
                    <div class="form-group">
                        <label class="form-label">Supplier Name</label>
                        <input name="searchsuppliername" type="text" id="searchsuppliername" 
                               value="<?php echo htmlspecialchars($searchsuppliername); ?>" 
                               class="form-input" placeholder="Enter supplier name" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Date From</label>
                        <div class="date-input-group">
                            <input name="ADate1" id="ADate1" value="<?php echo $ADate1; ?>" 
                                   class="form-input date-input" readonly="readonly" />
                            <i class="fas fa-calendar-alt calendar-icon" onclick="javascript:NewCssCal('ADate1')"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Date To</label>
                        <div class="date-input-group">
                            <input name="ADate2" id="ADate2" value="<?php echo $ADate2; ?>" 
                                   class="form-input date-input" readonly="readonly" />
                            <i class="fas fa-calendar-alt calendar-icon" onclick="javascript:NewCssCal('ADate2')"></i>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-chart-line"></i> Generate Analysis
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <?php if (!empty($summaryData)): ?>
            <!-- Summary Cards Section -->
            <div class="summary-cards">
                <div class="summary-card">
                    <div class="summary-card-header">
                        <span class="summary-card-title">0-30 Days</span>
                        <i class="fas fa-calendar-day summary-card-icon"></i>
                    </div>
                    <div class="summary-card-amount amount-positive">₹<?php echo number_format($summaryData['0-30'], 2); ?></div>
                    <div class="summary-card-description">Current outstanding</div>
                </div>

                <div class="summary-card">
                    <div class="summary-card-header">
                        <span class="summary-card-title">31-60 Days</span>
                        <i class="fas fa-calendar-week summary-card-icon"></i>
                    </div>
                    <div class="summary-card-amount amount-positive">₹<?php echo number_format($summaryData['31-60'], 2); ?></div>
                    <div class="summary-card-description">Recent outstanding</div>
                </div>

                <div class="summary-card">
                    <div class="summary-card-header">
                        <span class="summary-card-title">61-90 Days</span>
                        <i class="fas fa-calendar-alt summary-card-icon"></i>
                    </div>
                    <div class="summary-card-amount amount-positive">₹<?php echo number_format($summaryData['61-90'], 2); ?></div>
                    <div class="summary-card-description">Moderate outstanding</div>
                </div>

                <div class="summary-card">
                    <div class="summary-card-header">
                        <span class="summary-card-title">91-120 Days</span>
                        <i class="fas fa-exclamation-triangle summary-card-icon"></i>
                    </div>
                    <div class="summary-card-amount amount-negative">₹<?php echo number_format($summaryData['91-120'], 2); ?></div>
                    <div class="summary-card-description">Overdue outstanding</div>
                </div>

                <div class="summary-card">
                    <div class="summary-card-header">
                        <span class="summary-card-title">121-180 Days</span>
                        <i class="fas fa-exclamation-circle summary-card-icon"></i>
                    </div>
                    <div class="summary-card-amount amount-negative">₹<?php echo number_format($summaryData['121-180'], 2); ?></div>
                    <div class="summary-card-description">Long overdue</div>
                </div>

                <div class="summary-card">
                    <div class="summary-card-header">
                        <span class="summary-card-title">181-210 Days</span>
                        <i class="fas fa-times-circle summary-card-icon"></i>
                    </div>
                    <div class="summary-card-amount amount-negative">₹<?php echo number_format($summaryData['181-210'], 2); ?></div>
                    <div class="summary-card-description">Critical overdue</div>
                </div>

                <div class="summary-card">
                    <div class="summary-card-header">
                        <span class="summary-card-title">211-240 Days</span>
                        <i class="fas fa-ban summary-card-icon"></i>
                    </div>
                    <div class="summary-card-amount amount-negative">₹<?php echo number_format($summaryData['211-240'], 2); ?></div>
                    <div class="summary-card-description">Severe overdue</div>
                </div>

                <div class="summary-card">
                    <div class="summary-card-header">
                        <span class="summary-card-title">240+ Days</span>
                        <i class="fas fa-skull-crossbones summary-card-icon"></i>
                    </div>
                    <div class="summary-card-amount amount-negative">₹<?php echo number_format($summaryData['240+'], 2); ?></div>
                    <div class="summary-card-description">Extreme overdue</div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Detailed Analysis Section -->
            <div class="analysis-results-section">
                <div class="analysis-results-header">
                    <div class="analysis-results-title">
                        <i class="fas fa-list"></i>
                        Detailed Creditor Analysis
                        <span class="results-count"><?php echo count($creditorData); ?></span>
                    </div>
                    <div class="analysis-results-actions">
                        <button type="button" class="btn btn-outline btn-sm" onclick="printResults()">
                            <i class="fas fa-print"></i> Print
                        </button>
                    </div>
                </div>

                <div class="data-table-container">
                    <table id="dataTable" class="data-table">
                        <thead>
                            <tr>
                                <th data-sortable="true" data-column="no">No.</th>
                                <th data-sortable="true" data-column="suppliercode">Supplier Code</th>
                                <th data-sortable="true" data-column="suppliername">Supplier Name</th>
                                <th data-sortable="true" data-column="accountname">Account Name</th>
                                <th data-sortable="true" data-column="totalamount">Total Amount</th>
                                <th data-sortable="true" data-column="payments">Payments</th>
                                <th data-sortable="true" data-column="returns">Returns</th>
                                <th data-sortable="true" data-column="outstanding">Outstanding</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($creditorData)) {
                                $counter = 1;
                                foreach ($creditorData as $creditor) {
                                    $outstandingClass = $creditor['outstanding'] > 0 ? 'amount-negative' : 'amount-positive';
                                    ?>
                                    <tr>
                                        <td><?php echo $counter++; ?></td>
                                        <td><?php echo htmlspecialchars($creditor['suppliercode']); ?></td>
                                        <td><?php echo htmlspecialchars($creditor['suppliername']); ?></td>
                                        <td><?php echo htmlspecialchars($creditor['accountname']); ?></td>
                                        <td class="amount-positive">₹<?php echo number_format($creditor['totalamount'], 2); ?></td>
                                        <td class="amount-positive">₹<?php echo number_format($creditor['payments'], 2); ?></td>
                                        <td class="amount-positive">₹<?php echo number_format($creditor['returns'], 2); ?></td>
                                        <td class="<?php echo $outstandingClass; ?>">₹<?php echo number_format($creditor['outstanding'], 2); ?></td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="action-btn view" onclick="viewSupplierDetails('<?php echo $creditor['suppliercode']; ?>')" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="action-btn print" onclick="printSupplierReport('<?php echo $creditor['suppliercode']; ?>')" title="Print Report">
                                                    <i class="fas fa-print"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="9" class="no-data">
                                        <div class="no-data-icon">
                                            <i class="fas fa-chart-line"></i>
                                        </div>
                                        <h3>No Creditor Data Found</h3>
                                        <p>No creditor analysis data available for the selected criteria.</p>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/fullcreditoranalysis_summary_detailed-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Additional JavaScript Functions -->
    <script type="text/javascript">
        function viewSupplierDetails(supplierCode) {
            console.log('Viewing supplier details:', supplierCode);
        }

        function printSupplierReport(supplierCode) {
            console.log('Printing supplier report:', supplierCode);
        }

        function exportResults() {
            console.log('Exporting results');
        }

        function printResults() {
            window.print();
        }
    </script>
</body>
</html>
