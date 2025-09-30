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
$totalamount = "0.00";
$totalamount30 = "0.00";
$checktotal = 0;
$searchsuppliername = "";
$searchsuppliername1 = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount = "";
$range = "";
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
$totalamount90 = '0.00';
$totalamount2401 = 0;
$totalamount60 = 0;

// Final totals
$ftotalamount1 = 0;
$ftotalamount301 = 0;
$ftotalamount601 = 0;
$ftotalamount901 = 0;
$ftotalamount1201 = 0;
$ftotalamount1801 = 0;
$ftotalamount2101 = 0;
$ftotalamount2401 = 0;

// Aging bucket totals
$totalamount302 = 0;
$totalamount602 = 0;
$totalamount902 = 0;
$totalamount1202 = 0;
$totalamount1802 = 0;
$totalamount2102 = 0;
$totalamountgreater2 = 0;

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
    'total_suppliers' => 0,
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
    <title>Full Creditor Analysis Summary - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/creditor-summary-modern.css?v=<?php echo time(); ?>">
    
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
        <p class="hospital-subtitle">Full Creditor Analysis Summary Report</p>
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
        <span>Full Creditor Analysis Summary</span>
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
                    <li class="nav-item">
                        <a href="fullcreditoranalysisdetailed.php" class="nav-link">
                            <i class="fas fa-file-invoice"></i>
                            <span>Creditor Analysis Detailed</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="fullcredittoranalysissummary.php" class="nav-link">
                            <i class="fas fa-chart-pie"></i>
                            <span>Creditor Analysis Summary</span>
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
                    <h2>Full Creditor Analysis Summary</h2>
                    <p>Summary view of creditor balances with aging analysis by supplier.</p>
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
                
                <form name="cbform1" method="post" action="fullcredittoranalysissummary.php" class="search-form">
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
                $dotarray = explode("-", $paymentreceiveddateto);
                $dotyear = $dotarray[0];
                $dotmonth = $dotarray[1];
                $dotday = $dotarray[2];
                $paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

                $searchsuppliername1 = $_REQUEST['searchsuppliername'];
                $arraysuppliercode = '';
                $res1suppliername = '';
                $res1suppliercode = '';
                $res1transactiondate = '';

                if($searchsuppliername1 != '') {
                    $arraysuppliername = $_REQUEST['searchsuppliername'];
                    $searchsuppliername1 = trim($arraysuppliername);
                    $arraysuppliercode = $_REQUEST['searchsuppliercode'];
                    $query212 = "select * from master_accountname where id = '$arraysuppliercode' and accountssub='12' group by id";
                } else {
                    $query212 = "select * from master_accountname where accountssub='12' group by id";
                }

                $exec212 = mysqli_query($GLOBALS["___mysqli_ston"], $query212) or die ("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
                
                while($res212 = mysqli_fetch_array($exec212)) {
                    $res21suppliername = $res212['accountname'];
                    $res21suppliercode = $res212['id'];

                    $query222 = "select * from master_accountname where id = '$res21suppliercode' and recordstatus <>'DELETED' ";
                    $exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query22" . mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res222 = mysqli_fetch_array($exec222);
                    $res22accountname = $res222['accountname'];

                    if($res21suppliername != '') {
                        // Process purchase transactions
                        $query1 = "select * from master_transactionpharmacy where suppliercode = '$res21suppliercode' and (transactiontype = 'PURCHASE' or transactiontype = 'PAYMENT') and transactiondate between '$ADate1' and '$ADate2' group by suppliercode";
                        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
                        $num1 = mysqli_num_rows($exec1);
                        
                        while($res1 = mysqli_fetch_array($exec1)) {
                            $res1suppliername = $res1['suppliername'];
                            $res1suppliercode = $res1['suppliercode'];
                            $res1transactiondate = $res1['transactiondate'];
                            $res1billnumber = $res1['billnumber'];
                            $res2transactionamount = $res1['transactionamount'];

                            // Calculate purchase amount
                            $query2 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and transactiontype = 'PURCHASE' and transactiondate between '$ADate1' and '$ADate2'";
                            $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2" . mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res2 = mysqli_fetch_array($exec2);
                            $res2transactionamount1 = isset($res2['transactionamount1']) ? $res2['transactionamount1'] : 0;

                            // Calculate WHT
                            $wh_tax_value = 0;
                            $query222 = "select sum(wh_tax_value) as wh_tax_value from purchase_details where suppliercode = '$res1suppliercode' and entrydate between '$ADate1' and '$ADate2'";
                            $exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query222" . mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res222 = mysqli_fetch_array($exec222);
                            $wh_tax_value = isset($res222['wh_tax_value']) ? $res222['wh_tax_value'] : 0;
                            $res2transactionamount = $res2transactionamount1 - $wh_tax_value;

                            // Calculate payments
                            $query3 = "SELECT sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and transactiontype = 'PAYMENT' and recordstatus = 'allocated' and transactiondate between '$ADate1' and '$ADate2'";
                            $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3" . mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res3 = mysqli_fetch_array($exec3);
                            $res3transactionamount = isset($res3['transactionamount1']) ? $res3['transactionamount1'] : 0;

                            // Calculate returns
                            $res4return = 0;
                            $query4 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber IN (select mrnno from master_transactionpharmacy where transactiontype = 'PURCHASE' and suppliercode = '$res1suppliercode' and transactiondate between '$ADate1' and '$ADate2') UNION ALL select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber IN (select billnumber from master_transactionpharmacy where transactiontype = 'PURCHASE' and suppliercode = '$res1suppliercode' and transactiondate between '$ADate1' and '$ADate2')";
                            $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4" . mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($res4 = mysqli_fetch_array($exec4)) {
                                $res4return += isset($res4['totalreturn']) ? $res4['totalreturn'] : 0;
                            }

                            $invoicevalue = $res2transactionamount - ($res3transactionamount + $res4return);

                            // Process individual bills for aging
                            $query45122 = "select billnumber from master_purchase where suppliercode = '$res1suppliercode' and recordstatus <> 'deleted' and billdate between '$ADate1' and '$ADate2' and companyanum = '$companyanum' group by billnumber";
                            $exe45122 = mysqli_query($GLOBALS["___mysqli_ston"], $query45122);

                            while($res45122 = mysqli_fetch_array($exe45122)) {
                                $resbill = $res45122['billnumber'];
                                
                                $query451 = "select transactiondate,sum(transactionamount) as transactionamount,billnumber,mrnno from master_transactionpharmacy where billnumber='$resbill' and suppliercode = '$res1suppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'PURCHASE' group by billnumber";
                                $exec451 = mysqli_query($GLOBALS["___mysqli_ston"], $query451) or die ("Error in Query45" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                $num451 = mysqli_num_rows($exec451);

                                if($num451 > 0) {
                                    while($res451 = mysqli_fetch_array($exec451)) {
                                        $res451transactiondate = $res451['transactiondate'];
                                        $res451transactionamount1 = $res451['transactionamount'];
                                        $res451billnumber = $res451['billnumber'];
                                        $res451mrnno = $res451['mrnno'];

                                        // Calculate WHT for this bill
                                        $wh_tax_value = 0;
                                        $query222 = "select sum(wh_tax_value) as wh_tax_value from purchase_details where billnumber='$res451billnumber' and suppliercode = '$res1suppliercode' and entrydate between '$ADate1' and '$ADate2' group by billnumber";
                                        $exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query222" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                        $res222 = mysqli_fetch_array($exec222);
                                        $wh_tax_value = isset($res222['wh_tax_value']) ? $res222['wh_tax_value'] : 0;
                                        $res451transactionamount = $res451transactionamount1 - $wh_tax_value;

                                        // Calculate payments for this bill
                                        $query452 = "select sum(transactionamount) as transactionamount from master_transactionpharmacy where billnumber='$res451billnumber' and suppliercode = '$res1suppliercode' and transactiontype = 'PAYMENT' and recordstatus='allocated' and transactiondate between '$ADate1' and '$ADate2' group by billnumber";
                                        $exe452 = mysqli_query($GLOBALS["___mysqli_ston"], $query452);
                                        $res452 = mysqli_fetch_array($exe452);
                                        $totalpayment = isset($res452['transactionamount']) ? $res452['transactionamount'] : 0;

                                        // Calculate returns for this bill
                                        $returnamount451 = 0;
                                        $query652 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber IN (select mrnno from master_transactionpharmacy where billnumber = '$res451billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$ADate1' and '$ADate2') UNION ALL select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber = '$res451billnumber' and entrydate between '$ADate1' and '$ADate2'";
                                        $exe652 = mysqli_query($GLOBALS["___mysqli_ston"], $query652) or die("Error in query652" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                        while($res652 = mysqli_fetch_array($exe652)) {
                                            $returnamount451 += isset($res652['totalreturn']) ? $res652['totalreturn'] : 0;
                                        }

                                        if($snocount == 0) {
                                            $totalamount420 = $res451transactionamount - ($totalpayment + $returnamount451) + $openingbalance;
                                        } else {
                                            $totalamount420 = $res451transactionamount - ($totalpayment + $returnamount451);
                                        }

                                        $totalamount451 = $totalamount420;
                                        $t1 = strtotime("$ADate2");
                                        $t2 = strtotime("$res451transactiondate");
                                        $days_between = ceil(abs($t1 - $t2) / 86400);

                                        // Categorize by aging buckets
                                        if($days_between <= 30) {
                                            $totalamount302 = $totalamount302 + $totalamount451;
                                        } elseif(($days_between > 30) && ($days_between <= 60)) {
                                            $totalamount602 = $totalamount602 + $totalamount451;
                                        } elseif(($days_between > 60) && ($days_between <= 90)) {
                                            $totalamount902 = $totalamount902 + $totalamount451;
                                        } elseif(($days_between > 90) && ($days_between <= 120)) {
                                            $totalamount1202 = $totalamount1202 + $totalamount451;
                                        } elseif(($days_between > 120) && ($days_between <= 180)) {
                                            $totalamount1802 = $totalamount1802 + $totalamount451;
                                        } else {
                                            $totalamountgreater2 = $totalamountgreater2 + $totalamount451;
                                        }

                                        $totalamount451 = 0;
                                    }
                                }
                            }

                            // Add to totals
                            $totalamount1 = $totalamount1 + $res2transactionamount;
                            $totalamount301 = $totalamount301 + $invoicevalue;
                            $totalamount601 = $totalamount601 + $totalamount302;
                            $totalamount901 = $totalamount901 + $totalamount602;
                            $totalamount1201 = $totalamount1201 + $totalamount902;
                            $totalamount1801 = $totalamount1801 + $totalamount1202;
                            $totalamount2101 = $totalamount2101 + $totalamount1802;
                            $totalamount2401 = $totalamount2401 + $totalamountgreater2;

                            // Add to final totals
                            $ftotalamount1 = $ftotalamount1 + $res2transactionamount;
                            $ftotalamount301 = $ftotalamount301 + $invoicevalue;
                            $ftotalamount601 = $ftotalamount601 + $totalamount302;
                            $ftotalamount901 = $ftotalamount901 + $totalamount602;
                            $ftotalamount1201 = $ftotalamount1201 + $totalamount902;
                            $ftotalamount1801 = $ftotalamount1801 + $totalamount1202;
                            $ftotalamount2101 = $ftotalamount2101 + $totalamount1802;
                            $ftotalamount2401 = $ftotalamount2401 + $totalamountgreater2;

                            // Reset variables for next iteration
                            $res2transactionamount = 0;
                            $invoicevalue = 0;
                            $totalamount30 = 0;
                            $totalamount60 = 0;
                            $totalamount90 = 0;
                            $totalamount120 = 0;
                            $totalamount180 = 0;
                            $totalamount210 = 0;
                            $totalamount302 = 0;
                            $totalamount602 = 0;
                            $totalamount902 = 0;
                            $totalamount1202 = 0;
                            $totalamount1802 = 0;
                            $totalamount2102 = 0;
                            $totalamountgreater2 = 0;
                            $total60 = 0;
                            $total90 = 0;
                            $total120 = 0;
                            $total180 = 0;
                            $total210 = 0;
                        }
                    }

                    // Process journal entries
                    $query2 = "select sum(creditamount-debitamount) as creditamount,ledgername,entrydate,docno from master_journalentries where ledgerid='$res21suppliercode' and entrydate between '$ADate1' and '$ADate2' group by docno";
                    $exe2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2);

                    while($res2 = mysqli_fetch_array($exe2)) {
                        $creditamount = $res2['creditamount'];
                        $ledgername = $res2['ledgername'];
                        $entrydate = $res2['entrydate'];
                        $docno = $res2['docno'];

                        $t1 = strtotime($entrydate);
                        $t2 = strtotime($ADate2);
                        $days_between = ceil(abs($t2 - $t1) / 86400);

                        // Categorize journal entries by aging
                        if($days_between < 30) {
                            $totalamount30 = $totalamount30 + $creditamount;
                        } elseif($days_between > 30 && $days_between <= 60) {
                            $total60 = $total60 + $creditamount;
                        } elseif($days_between > 60 && $days_between <= 90) {
                            $total90 = $total90 + $creditamount;
                        } elseif($days_between > 90 && $days_between <= 120) {
                            $total120 = $total120 + $creditamount;
                        } elseif($days_between > 120 && $days_between <= 180) {
                            $total180 = $total180 + $creditamount;
                        } elseif($days_between > 180) {
                            $total210 = $total210 + $creditamount;
                        }

                        if($creditamount != '') {
                            $totalamount1 = $totalamount1 + $creditamount;
                            $totalamount301 = $totalamount301 + $creditamount;
                            $totalamount601 = $totalamount601 + $totalamount30;
                            $totalamount901 = $totalamount901 + $total60;
                            $totalamount1201 = $totalamount1201 + $total90;
                            $totalamount1801 = $totalamount1801 + $total120;
                            $totalamount2101 = $totalamount2101 + $total180;
                            $totalamount2401 = $totalamount2401 + $total210;

                            $ftotalamount1 = $ftotalamount1 + $creditamount;
                            $ftotalamount301 = $ftotalamount301 + $creditamount;
                            $ftotalamount601 = $ftotalamount601 + $totalamount30;
                            $ftotalamount901 = $ftotalamount901 + $total60;
                            $ftotalamount1201 = $ftotalamount1201 + $total90;
                            $ftotalamount1801 = $ftotalamount1801 + $total120;
                            $ftotalamount2101 = $ftotalamount2101 + $total180;
                            $ftotalamount2401 = $ftotalamount2401 + $total210;
                        }

                        // Reset variables
                        $res2transactionamount = 0;
                        $invoicevalue = 0;
                        $totalamount30 = 0;
                        $totalamount60 = 0;
                        $totalamount90 = 0;
                        $totalamount120 = 0;
                        $totalamount180 = 0;
                        $totalamount210 = 0;
                        $totalamount302 = 0;
                        $totalamount602 = 0;
                        $totalamount902 = 0;
                        $totalamount1202 = 0;
                        $totalamount1802 = 0;
                        $totalamount2102 = 0;
                        $total60 = 0;
                        $total90 = 0;
                        $total120 = 0;
                        $total180 = 0;
                        $total210 = 0;
                    }

                    // Process supplier debit transactions
                    $total_debit = 0;
                    $query5 = "SELECT * from supplier_debit_transactions where supplier_id = '$res21suppliercode' and date(created_at) between '$ADate1' and '$ADate2' order by created_at ASC";
                    $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5" . mysqli_error($GLOBALS["___mysqli_ston"]));

                    while($res5 = mysqli_fetch_array($exec5)) {
                        $res5docnumber = $res5['approve_id'];
                        $created_at = $res5['created_at'];
                        $ref_no = $res5['ref_no'];
                        $res5transactionamount = $res5['total_amount'];

                        $timestamp = strtotime($created_at);
                        $entrydate = date('Y-m-d', $timestamp);

                        $transactionamount = '0';
                        $query3 = "SELECT * from master_transactionpharmacy where docno = '$res5docnumber' and recordstatus = 'allocated'";
                        $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3" . mysqli_error($GLOBALS["___mysqli_ston"]));
                        while ($res3 = mysqli_fetch_array($exec3)) {
                            $transactionamount += $res3['transactionamount'];
                        }
                        $pending12 = $res5transactionamount - $transactionamount;

                        $t1 = strtotime($entrydate);
                        $t2 = strtotime($ADate2);
                        $days_between = ceil(abs($t2 - $t1) / 86400);

                        // Categorize debit transactions by aging
                        if($days_between <= 30) {
                            $totalamount30 = $totalamount30 - $pending12;
                        } elseif($days_between > 30 && $days_between <= 60) {
                            $total60 = $total60 - $pending12;
                        } elseif($days_between > 60 && $days_between <= 90) {
                            $total90 = $total90 - $pending12;
                        } elseif($days_between > 90 && $days_between <= 120) {
                            $total120 = $total120 - $pending12;
                        } elseif($days_between > 120 && $days_between <= 180) {
                            $total180 = $total180 - $pending12;
                        } elseif($days_between > 180) {
                            $total210 = $total210 - $pending12;
                        }

                        if($pending12 != '') {
                            $totalamount1 = $totalamount1 - $pending12;
                            $totalamount301 = $totalamount301 - $pending12;
                            $totalamount601 = $totalamount601 + $totalamount30;
                            $totalamount901 = $totalamount901 + $total60;
                            $totalamount1201 = $totalamount1201 + $total90;
                            $totalamount1801 = $totalamount1801 + $total120;
                            $totalamount2101 = $totalamount2101 + $total180;
                            $totalamount2401 = $totalamount2401 + $total210;

                            $ftotalamount1 = $ftotalamount1 - $pending12;
                            $ftotalamount301 = $ftotalamount301 - $pending12;
                            $ftotalamount601 = $ftotalamount601 + $totalamount30;
                            $ftotalamount901 = $ftotalamount901 + $total60;
                            $ftotalamount1201 = $ftotalamount1201 + $total90;
                            $ftotalamount1801 = $ftotalamount1801 + $total120;
                            $ftotalamount2101 = $ftotalamount2101 + $total180;
                            $ftotalamount2401 = $ftotalamount2401 + $total210;
                        }

                        // Reset variables
                        $res2transactionamount = 0;
                        $invoicevalue = 0;
                        $totalamount30 = 0;
                        $totalamount60 = 0;
                        $totalamount90 = 0;
                        $totalamount120 = 0;
                        $totalamount180 = 0;
                        $totalamount210 = 0;
                        $totalamount302 = 0;
                        $totalamount602 = 0;
                        $totalamount902 = 0;
                        $totalamount1202 = 0;
                        $totalamount1802 = 0;
                        $totalamount2102 = 0;
                        $total60 = 0;
                        $total90 = 0;
                        $total120 = 0;
                        $total180 = 0;
                        $total210 = 0;
                    }

                    // Display supplier row if there are any amounts
                    if($totalamount301 != 0 || $totalamount601 != 0 || $totalamount901 != 0 || $totalamount1201 != 0 || $totalamount1801 != 0 || $totalamount2101 != 0 || $totalamount2401 != 0) {
                        $snocount = $snocount + 1;
                        $colorloopcount = $colorloopcount + 1;
                        $showcolor = ($colorloopcount & 1);
                        $colorcode = ($showcolor == 0) ? 'bgcolor="#CBDBFA"' : 'bgcolor="#ecf0f5"';

                        $supplierData = [
                            'supplier_name' => $res21suppliername,
                            'total_balance' => $totalamount301,
                            'aging_30' => $totalamount601,
                            'aging_60' => $totalamount901,
                            'aging_90' => $totalamount1201,
                            'aging_120' => $totalamount1801,
                            'aging_180' => $totalamount2101,
                            'aging_210' => $totalamount2401
                        ];

                        $reportData[] = $supplierData;

                        // Update summary totals
                        $summaryData['total_suppliers']++;
                        $summaryData['total_balance'] += $totalamount301;
                        $summaryData['total_30'] += $totalamount601;
                        $summaryData['total_60'] += $totalamount901;
                        $summaryData['total_90'] += $totalamount1201;
                        $summaryData['total_120'] += $totalamount1801;
                        $summaryData['total_180'] += $totalamount2101;
                        $summaryData['total_210'] += $totalamount2401;
                    }

                    // Reset variables for next supplier
                    $totalamount1 = 0;
                    $totalamount301 = 0;
                    $totalamount601 = 0;
                    $totalamount901 = 0;
                    $totalamount1201 = 0;
                    $totalamount1801 = 0;
                    $totalamount2101 = 0;
                    $totalamount2401 = 0;
                }
            }
            ?>

            <?php if (!empty($reportData)): ?>
                <!-- Summary Cards -->
                <div class="summary-cards">
                    <div class="summary-card total-suppliers">
                        <div class="summary-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="summary-content">
                            <h3><?php echo $summaryData['total_suppliers']; ?></h3>
                            <p>Total Suppliers</p>
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
                            <i class="fas fa-chart-pie report-icon"></i>
                            <h3 class="report-title">Creditor Analysis Summary Report</h3>
                            <div class="report-period">
                                <span><?php echo date('d/m/Y', strtotime($ADate1)); ?> - <?php echo date('d/m/Y', strtotime($ADate2)); ?></span>
                            </div>
                        </div>
                        <div class="report-actions">
                            <button type="button" class="btn btn-outline btn-sm" onclick="toggleChartView()">
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
                                    <th>Supplier</th>
                                    <th>Total Balance</th>
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
                                    $rowCount++;
                                    $rowClass = ($rowCount % 2 == 0) ? 'even' : 'odd';
                                ?>
                                    <tr class="table-row <?php echo $rowClass; ?>">
                                        <td><?php echo $rowCount; ?></td>
                                        <td>
                                            <span class="supplier-name"><?php echo htmlspecialchars($supplier['supplier_name']); ?></span>
                                        </td>
                                        <td>
                                            <span class="amount-badge balance"><?php echo number_format($supplier['total_balance'], 2, '.', ','); ?></span>
                                        </td>
                                        <td>
                                            <span class="aging-badge aging-30"><?php echo number_format($supplier['aging_30'], 2, '.', ','); ?></span>
                                        </td>
                                        <td>
                                            <span class="aging-badge aging-60"><?php echo number_format($supplier['aging_60'], 2, '.', ','); ?></span>
                                        </td>
                                        <td>
                                            <span class="aging-badge aging-90"><?php echo number_format($supplier['aging_90'], 2, '.', ','); ?></span>
                                        </td>
                                        <td>
                                            <span class="aging-badge aging-120"><?php echo number_format($supplier['aging_120'], 2, '.', ','); ?></span>
                                        </td>
                                        <td>
                                            <span class="aging-badge aging-180"><?php echo number_format($supplier['aging_180'], 2, '.', ','); ?></span>
                                        </td>
                                        <td>
                                            <span class="aging-badge aging-210"><?php echo number_format($supplier['aging_210'], 2, '.', ','); ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="totals-row">
                                    <td colspan="2"><strong>Total:</strong></td>
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
                        <h3 class="chart-title">Aging Summary Chart</h3>
                    </div>
                    <div class="chart-container">
                        <canvas id="agingChart"></canvas>
                    </div>
                </div>
            <?php elseif ($cbfrmflag1 == 'cbfrmflag1'): ?>
                <div class="no-results-message">
                    <i class="fas fa-chart-pie"></i>
                    <h3>No Data Found</h3>
                    <p>No creditor analysis summary data found for the selected criteria.</p>
                    <button type="button" class="btn btn-primary" onclick="resetForm()">
                        <i class="fas fa-undo"></i> Try Different Criteria
                    </button>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/creditor-summary-modern.js?v=<?php echo time(); ?>"></script>
    
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
            // Get current URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            const formData = new FormData(document.querySelector('.search-form'));
            
            // Build export URL
            let exportUrl = 'print_fullcredittoranalysissummary.php?';
            exportUrl += 'cbfrmflag1=cbfrmflag1';
            exportUrl += '&ADate1=' + encodeURIComponent(formData.get('ADate1') || '');
            exportUrl += '&ADate2=' + encodeURIComponent(formData.get('ADate2') || '');
            exportUrl += '&searchsuppliercode=' + encodeURIComponent(formData.get('searchsuppliercode') || '');
            
            // Open export in new window
            window.open(exportUrl, '_blank');
            
            showAlert('Export initiated successfully!', 'success');
        }
        
        function printReport() {
            // Hide sidebar and other non-printable elements
            const sidebar = document.getElementById('leftSidebar');
            const floatingToggle = document.querySelector('.floating-menu-toggle');
            
            if (sidebar) sidebar.style.display = 'none';
            if (floatingToggle) floatingToggle.style.display = 'none';
            
            // Print
            window.print();
            
            // Restore elements
            if (sidebar) sidebar.style.display = '';
            if (floatingToggle) floatingToggle.style.display = '';
            
            showAlert('Print dialog opened.', 'info');
        }
        
        function resetForm() {
            const form = document.querySelector('.search-form');
            if (form) {
                form.reset();
                
                // Set default dates
                const today = new Date();
                const lastMonth = new Date();
                lastMonth.setMonth(today.getMonth() - 1);
                
                const dateFrom = document.getElementById('ADate1');
                const dateTo = document.getElementById('ADate2');
                
                if (dateFrom) {
                    dateFrom.value = lastMonth.toISOString().split('T')[0];
                }
                if (dateTo) {
                    dateTo.value = today.toISOString().split('T')[0];
                }
                
                showAlert('Form reset successfully!', 'info');
            }
        }
    </script>
</body>
</html>
