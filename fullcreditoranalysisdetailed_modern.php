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

// Initialize variables
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$total = '0.00';
$searchsuppliername = "";
$searchsuppliername1 = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount = "";
$range = "";
$totalamount = "0.00";
$totalamount30 = "0.00";
$total60 = "0.00";
$total90 = "0.00";
$total120 = "0.00";
$total180 = "0.00";
$total210 = "0.00";
$totalamount1 = "0.00";
$totalamount301 = "0.00";
$totalamount601 = "0.00";
$totalamount901 = "0.00";
$totalamount1201 = "0.00";
$totalamount1801 = "0.00";
$totalamount2101 = "0.00";
$totalamount2401 = "0.00";

// Handle form parameters
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

if (isset($_REQUEST["searchsuppliercode"])) { 
    $searchsuppliercode = $_REQUEST["searchsuppliercode"]; 
} else { 
    $searchsuppliercode = ""; 
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

if (isset($_REQUEST["range"])) { 
    $range = $_REQUEST["range"]; 
} else { 
    $range = ""; 
}

if (isset($_REQUEST["amount"])) { 
    $amount = $_REQUEST["amount"]; 
} else { 
    $amount = ""; 
}

if (isset($_REQUEST["cbfrmflag2"])) { 
    $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; 
} else { 
    $cbfrmflag2 = ""; 
}

if (isset($_REQUEST["frmflag2"])) { 
    $frmflag2 = $_REQUEST["frmflag2"]; 
} else { 
    $frmflag2 = ""; 
}

if (isset($_REQUEST["accountssub"])) { 
    $accountssubanum = $_REQUEST["accountssub"]; 
} else { 
    $accountssubanum = ""; 
}

// Initialize report data
$reportData = [];
$summaryData = [
    'total_amount' => 0,
    'total_balance' => 0,
    'total_30' => 0,
    'total_60' => 0,
    'total_90' => 0,
    'total_120' => 0,
    'total_180' => 0,
    'total_210' => 0
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Full Creditor Analysis Detailed - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/creditor-analysis-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date picker styles -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- Scripts -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    
    <!-- Autocomplete -->
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/autocomplete.css">
</head>
<body>
    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Full Creditor Analysis Detailed Report</p>
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
        <span>Full Creditor Analysis Detailed</span>
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
                    <li class="nav-item">
                        <a href="freeqtyvariancereport.php" class="nav-link">
                            <i class="fas fa-balance-scale"></i>
                            <span>Free Qty Variance</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="frontdesk.php" class="nav-link">
                            <i class="fas fa-desktop"></i>
                            <span>Front Desk Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="fullcreditoranalysisdetailed.php" class="nav-link">
                            <i class="fas fa-file-invoice"></i>
                            <span>Creditor Analysis</span>
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
                    <h2>Full Creditor Analysis Detailed</h2>
                    <p>Comprehensive analysis of creditor balances with aging buckets.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="exportToExcel()">
                        <i class="fas fa-download"></i> Export Excel
                    </button>
                    <button type="button" class="btn btn-outline" onclick="printReport()">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>

            <!-- Search Form Section -->
            <div class="search-form-section">
                <div class="search-form-header">
                    <i class="fas fa-search search-form-icon"></i>
                    <h3 class="search-form-title">Report Parameters</h3>
                </div>
                
                <form name="cbform1" method="post" action="fullcreditoranalysisdetailed.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="searchsuppliername" class="form-label">
                                <i class="fas fa-user"></i>
                                Search Supplier
                            </label>
                            <input name="searchsuppliername" type="text" id="searchsuppliername" 
                                   value="<?php echo htmlspecialchars($searchsuppliername); ?>" 
                                   class="form-input" autocomplete="off" placeholder="Type supplier name...">
                            <input name="searchsuppliernamehiddentextbox" id="searchsuppliernamehiddentextbox" value="" type="hidden">
                            <input name="searchaccountnameanum1" id="searchaccountnameanum1" value="" type="hidden">
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate1" class="form-label">
                                <i class="fas fa-calendar-alt"></i>
                                Date From
                            </label>
                            <div class="date-input-group">
                                <input name="ADate1" id="ADate1" class="form-input date-input" 
                                       value="<?php echo htmlspecialchars($ADate1); ?>" 
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
                                       value="<?php echo htmlspecialchars($ADate2); ?>" 
                                       readonly onKeyDown="return disableEnterKey()">
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')"
                                     class="date-picker-icon" alt="Select Date">
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <input type="hidden" name="searchsuppliercode" id="searchsuppliercode" value="<?php echo htmlspecialchars($searchsuppliercode); ?>">
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

            <?php
            if (isset($_REQUEST["cbfrmflag1"])) { 
                $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; 
            } else { 
                $cbfrmflag1 = ""; 
            }

            if ($cbfrmflag1 == 'cbfrmflag1') {
                $arraysupplier = $searchsuppliername;
                $arraysuppliername = $arraysupplier;
                $searchsuppliername = trim($arraysuppliername);
                $arraysuppliercode = trim($_REQUEST['searchsuppliercode']);
                $searchsuppliername = trim($searchsuppliername);
                
                if($searchsuppliername == '') { 
                    $arraysuppliercode = ''; 
                }

                if($arraysuppliercode == '') {
                    $query212 = "select * from master_accountname where accountssub='12' group by id";
                } else {
                    $query212 = "select * from master_accountname where id = '$arraysuppliercode' and accountssub='12' group by id";
                }

                $exec212 = mysqli_query($GLOBALS["___mysqli_ston"], $query212) or die ("Error in Query21" . mysqli_error($GLOBALS["___mysqli_ston"]));
                
                while ($res212 = mysqli_fetch_array($exec212)) {
                    $res21suppliername = $res212['accountname'];
                    $res21suppliercode = $res212['id'];

                    $query222 = "select * from master_accountname where id = '$res21suppliercode' and recordstatus <>'DELETED' ";
                    $exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query22" . mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res222 = mysqli_fetch_array($exec222);
                    $res22accountname = $res222['accountname'];
                    $id = $res222['id'];

                    if($res21suppliername != '') {
                        // Process purchase data for this supplier
                        $query1 = "select * from master_purchase where suppliercode = '$res21suppliercode' and recordstatus <> 'deleted' and billdate between '$ADate1' and '$ADate2' and companyanum = '$companyanum' group by billnumber order by billdate asc";
                        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
                        $num1 = mysqli_num_rows($exec1);
                        
                        if($num1 > 0) {
                            $supplierData = [
                                'supplier_name' => $res22accountname,
                                'supplier_code' => $res21suppliercode,
                                'transactions' => []
                            ];

                            while($res1 = mysqli_fetch_array($exec1)) {
                                $res1suppliername = $res1['suppliername'];
                                $res1suppliercode = $res1['suppliercode'];
                                $res1transactiondate = $res1['billdate'];
                                $res1billnumber = $res1['billnumber'];
                                $res2transactionamount1 = $res1['totalamount'];
                                $supplierbillnumber = $res1['supplierbillnumber'];

                                // Calculate payments and returns
                                $query3 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'PAYMENT' and recordstatus = 'allocated' and transactiondate between '$ADate1' and '$ADate2'";
                                $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res3 = mysqli_fetch_array($exec3);
                                $res3transactionamount = isset($res3['transactionamount1']) ? $res3['transactionamount1'] : 0;

                                // Calculate WHT
                                $wh_tax_value = 0;
                                $query222 = "select sum(wh_tax_value) as wh_tax_value from purchase_details where billnumber='$res1billnumber' and suppliercode = '$res1suppliercode' and entrydate between '$ADate1' and '$ADate2' group by billnumber";
                                $exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query222" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res222 = mysqli_fetch_array($exec222);
                                $wh_tax_value = isset($res222['wh_tax_value']) ? $res222['wh_tax_value'] : 0;

                                $res2transactionamount = $res2transactionamount1 - $wh_tax_value;

                                // Calculate returns
                                $res4return = 0;
                                $query4 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber = '$res1billnumber' and entrydate between '$ADate1' and '$ADate2'
                                          UNION ALL select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber IN (select mrnno from master_transactionpharmacy where billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$ADate1' and '$ADate2')";
                                $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($res4 = mysqli_fetch_array($exec4)) {
                                    $res4return += isset($res4['totalreturn']) ? $res4['totalreturn'] : 0;
                                }

                                $invoicevalue = $res2transactionamount - ($res3transactionamount + $res4return);

                                if($invoicevalue > 0) {
                                    // Calculate aging
                                    $t1 = strtotime($res1transactiondate);
                                    $t2 = strtotime($ADate2);
                                    $days_between = ceil(abs($t2 - $t1) / 86400);

                                    $aging_buckets = [
                                        '30' => 0,
                                        '60' => 0,
                                        '90' => 0,
                                        '120' => 0,
                                        '180' => 0,
                                        '210' => 0
                                    ];

                                    // Simplified aging calculation
                                    if($days_between <= 30) {
                                        $aging_buckets['30'] = $invoicevalue;
                                    } elseif($days_between <= 60) {
                                        $aging_buckets['60'] = $invoicevalue;
                                    } elseif($days_between <= 90) {
                                        $aging_buckets['90'] = $invoicevalue;
                                    } elseif($days_between <= 120) {
                                        $aging_buckets['120'] = $invoicevalue;
                                    } elseif($days_between <= 180) {
                                        $aging_buckets['180'] = $invoicevalue;
                                    } else {
                                        $aging_buckets['210'] = $invoicevalue;
                                    }

                                    $transactionData = [
                                        'grn_no' => $res1billnumber,
                                        'invoice_no' => $supplierbillnumber,
                                        'invoice_date' => $res1transactiondate,
                                        'invoice_amount' => $res2transactionamount,
                                        'balance_amount' => $invoicevalue,
                                        'days_between' => $days_between,
                                        'aging_buckets' => $aging_buckets
                                    ];

                                    $supplierData['transactions'][] = $transactionData;

                                    // Update summary totals
                                    $summaryData['total_amount'] += $res2transactionamount;
                                    $summaryData['total_balance'] += $invoicevalue;
                                    $summaryData['total_30'] += $aging_buckets['30'];
                                    $summaryData['total_60'] += $aging_buckets['60'];
                                    $summaryData['total_90'] += $aging_buckets['90'];
                                    $summaryData['total_120'] += $aging_buckets['120'];
                                    $summaryData['total_180'] += $aging_buckets['180'];
                                    $summaryData['total_210'] += $aging_buckets['210'];
                                }
                            }

                            if(!empty($supplierData['transactions'])) {
                                $reportData[] = $supplierData;
                            }
                        }
                    }
                }
            }
            ?>

            <?php if (!empty($reportData)): ?>
                <!-- Summary Cards -->
                <div class="summary-cards">
                    <div class="summary-card total-invoice">
                        <div class="summary-icon">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <div class="summary-content">
                            <h3><?php echo number_format($summaryData['total_amount'], 2, '.', ','); ?></h3>
                            <p>Total Invoice Amount</p>
                        </div>
                    </div>
                    
                    <div class="summary-card total-balance">
                        <div class="summary-icon">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                        <div class="summary-content">
                            <h3><?php echo number_format($summaryData['total_balance'], 2, '.', ','); ?></h3>
                            <p>Total Balance</p>
                        </div>
                    </div>
                    
                    <div class="summary-card aging-30">
                        <div class="summary-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="summary-content">
                            <h3><?php echo number_format($summaryData['total_30'], 2, '.', ','); ?></h3>
                            <p>0-30 Days</p>
                        </div>
                    </div>
                    
                    <div class="summary-card aging-60">
                        <div class="summary-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="summary-content">
                            <h3><?php echo number_format($summaryData['total_60'], 2, '.', ','); ?></h3>
                            <p>31-60 Days</p>
                        </div>
                    </div>
                    
                    <div class="summary-card aging-90">
                        <div class="summary-icon">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div class="summary-content">
                            <h3><?php echo number_format($summaryData['total_90'], 2, '.', ','); ?></h3>
                            <p>61-90 Days</p>
                        </div>
                    </div>
                    
                    <div class="summary-card aging-120">
                        <div class="summary-icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div class="summary-content">
                            <h3><?php echo number_format($summaryData['total_120'], 2, '.', ','); ?></h3>
                            <p>91-120 Days</p>
                        </div>
                    </div>
                    
                    <div class="summary-card aging-180">
                        <div class="summary-icon">
                            <i class="fas fa-ban"></i>
                        </div>
                        <div class="summary-content">
                            <h3><?php echo number_format($summaryData['total_180'], 2, '.', ','); ?></h3>
                            <p>121-180 Days</p>
                        </div>
                    </div>
                    
                    <div class="summary-card aging-210">
                        <div class="summary-icon">
                            <i class="fas fa-skull-crossbones"></i>
                        </div>
                        <div class="summary-content">
                            <h3><?php echo number_format($summaryData['total_210'], 2, '.', ','); ?></h3>
                            <p>180+ Days</p>
                        </div>
                    </div>
                </div>

                <!-- Report Section -->
                <div class="report-section">
                    <div class="report-header">
                        <div class="report-title-section">
                            <i class="fas fa-file-invoice report-icon"></i>
                            <h3 class="report-title">Creditor Analysis Report</h3>
                            <div class="report-period">
                                <span><?php echo date('d/m/Y', strtotime($ADate1)); ?> - <?php echo date('d/m/Y', strtotime($ADate2)); ?></span>
                            </div>
                        </div>
                        <div class="report-actions">
                            <button type="button" class="btn btn-outline btn-sm" onclick="toggleChartView()">
                                <i class="fas fa-chart-pie"></i> Chart View
                            </button>
                        </div>
                    </div>

                    <!-- Modern Data Table -->
                    <div class="modern-table-container">
                        <table class="modern-data-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Supplier Name</th>
                                    <th>GRN No</th>
                                    <th>Invoice No</th>
                                    <th>Invoice Date</th>
                                    <th>Invoice Amount</th>
                                    <th>Balance Amount</th>
                                    <th>0-30 Days</th>
                                    <th>31-60 Days</th>
                                    <th>61-90 Days</th>
                                    <th>91-120 Days</th>
                                    <th>121-180 Days</th>
                                    <th>180+ Days</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $rowCount = 0;
                                foreach ($reportData as $supplier): 
                                    foreach ($supplier['transactions'] as $transaction): 
                                        $rowCount++;
                                        $rowClass = ($rowCount % 2 == 0) ? 'even' : 'odd';
                                ?>
                                    <tr class="table-row <?php echo $rowClass; ?>">
                                        <td><?php echo $rowCount; ?></td>
                                        <td>
                                            <span class="supplier-name"><?php echo htmlspecialchars($supplier['supplier_name']); ?></span>
                                        </td>
                                        <td>
                                            <span class="grn-badge"><?php echo htmlspecialchars($transaction['grn_no']); ?></span>
                                        </td>
                                        <td><?php echo htmlspecialchars($transaction['invoice_no']); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($transaction['invoice_date'])); ?></td>
                                        <td>
                                            <span class="amount-badge invoice"><?php echo number_format($transaction['invoice_amount'], 2, '.', ','); ?></span>
                                        </td>
                                        <td>
                                            <span class="amount-badge balance"><?php echo number_format($transaction['balance_amount'], 2, '.', ','); ?></span>
                                        </td>
                                        <td>
                                            <span class="aging-badge aging-30"><?php echo number_format($transaction['aging_buckets']['30'], 2, '.', ','); ?></span>
                                        </td>
                                        <td>
                                            <span class="aging-badge aging-60"><?php echo number_format($transaction['aging_buckets']['60'], 2, '.', ','); ?></span>
                                        </td>
                                        <td>
                                            <span class="aging-badge aging-90"><?php echo number_format($transaction['aging_buckets']['90'], 2, '.', ','); ?></span>
                                        </td>
                                        <td>
                                            <span class="aging-badge aging-120"><?php echo number_format($transaction['aging_buckets']['120'], 2, '.', ','); ?></span>
                                        </td>
                                        <td>
                                            <span class="aging-badge aging-180"><?php echo number_format($transaction['aging_buckets']['180'], 2, '.', ','); ?></span>
                                        </td>
                                        <td>
                                            <span class="aging-badge aging-210"><?php echo number_format($transaction['aging_buckets']['210'], 2, '.', ','); ?></span>
                                        </td>
                                    </tr>
                                <?php 
                                    endforeach; 
                                endforeach; 
                                ?>
                            </tbody>
                            <tfoot>
                                <tr class="totals-row">
                                    <td colspan="5"><strong>Total:</strong></td>
                                    <td><strong><?php echo number_format($summaryData['total_amount'], 2, '.', ','); ?></strong></td>
                                    <td><strong><?php echo number_format($summaryData['total_balance'], 2, '.', ','); ?></strong></td>
                                    <td><strong><?php echo number_format($summaryData['total_30'], 2, '.', ','); ?></strong></td>
                                    <td><strong><?php echo number_format($summaryData['total_60'], 2, '.', ','); ?></strong></td>
                                    <td><strong><?php echo number_format($summaryData['total_90'], 2, '.', ','); ?></strong></td>
                                    <td><strong><?php echo number_format($summaryData['total_120'], 2, '.', ','); ?></strong></td>
                                    <td><strong><?php echo number_format($summaryData['total_180'], 2, '.', ','); ?></strong></td>
                                    <td><strong><?php echo number_format($summaryData['total_210'], 2, '.', ','); ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Chart Section (Hidden by default) -->
                <div class="chart-section" id="chartSection" style="display: none;">
                    <div class="chart-header">
                        <i class="fas fa-chart-pie chart-icon"></i>
                        <h3 class="chart-title">Aging Analysis Chart</h3>
                    </div>
                    <div class="chart-container">
                        <canvas id="agingChart"></canvas>
                    </div>
                </div>
            <?php elseif ($cbfrmflag1 == 'cbfrmflag1'): ?>
                <div class="no-results-message">
                    <i class="fas fa-file-invoice"></i>
                    <h3>No Data Found</h3>
                    <p>No creditor analysis data found for the selected criteria.</p>
                    <button type="button" class="btn btn-primary" onclick="resetForm()">
                        <i class="fas fa-undo"></i> Try Different Criteria
                    </button>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/creditor-analysis-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Chart.js for charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Autocomplete functionality -->
    <script type="text/javascript">
        $(document).ready(function(e) {
            $('#searchsuppliername').autocomplete({
                source: "ajaxsupplieraccount_new.php?accountssub=" + $("#accountssub").val() + "",
                matchContains: true,
                minLength: 1,
                html: true, 
                select: function(event, ui) {
                    var accountname = ui.item.value;
                    var accountid = ui.item.id;
                    $("#searchsuppliercode").val(accountid);
                },
            });	
        });

        function setaccountmainanum() {
            var accountssub = $("#accountssub").val();
            $('#searchsuppliername').autocomplete({
                source: "ajaxsupplieraccount_new.php?accountssub=" + accountssub + "",
                matchContains: true,
                minLength: 1,
                html: true, 
                select: function(event, ui) {
                    var accountname = ui.item.value;
                    var accountid = ui.item.id;
                    $("#searchsuppliercode").val(accountid);
                },
            });
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
            document.getElementById('ADate1').value = '<?php echo date('Y-m-d', strtotime('-1 month')); ?>';
            document.getElementById('ADate2').value = '<?php echo date('Y-m-d'); ?>';
        }
    </script>
</body>
</html>

