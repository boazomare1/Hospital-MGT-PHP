<?php
session_start();
include ("db/db_connect.php");
include ("includes/loginverify.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$registrationdate = date('Y-m-d');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$docno = $_SESSION['docno'];

$todaydate = isset($_REQUEST['ADate1']) ? $_REQUEST['ADate1'] : date("Y-m-d");
$time = strtotime($todaydate);
$month = date("m", $time);
$year = date("Y", $time);
$thismonth = $year . "-" . $month . "___";

// Initialize variables
$totalRevenue = 0;
$totalPatients = 0;
$totalConsultations = 0;
$totalLabTests = 0;
$totalRadiologyTests = 0;
$totalServices = 0;
$totalPharmacy = 0;
$totalIP = 0;

// Get location data
$query1 = "SELECT locationname FROM login_locationdetails WHERE username='$username' AND docno='$docno' GROUP BY locationname ORDER BY locationname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1: " . mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1location = $res1["locationname"];

// Calculate total cash amount
$totalcashamt = 0;

// Cash sales from billing_paynow
$querycashsales = "SELECT SUM(totalamount) as amount FROM billing_paynow WHERE billdate='$todaydate'";
$cashsalesex = mysqli_query($GLOBALS["___mysqli_ston"], $querycashsales) or die("Error in querycashsales: " . mysqli_error($GLOBALS["___mysqli_ston"]));
$cashres = mysqli_fetch_array($cashsalesex);
$cashamount = $cashres["amount"] ?: 0;

// Cash sales from billing_consultation
$querycashsalesop = "SELECT SUM(consultation) as amount FROM billing_consultation WHERE billdate='$todaydate'";
$cashsalesexip = mysqli_query($GLOBALS["___mysqli_ston"], $querycashsalesop) or die("Error in querycashsalesop: " . mysqli_error($GLOBALS["___mysqli_ston"]));
$cashresip = mysqli_fetch_array($cashsalesexip);
$cashamountop = $cashresip["amount"] ?: 0;

$newcasham = $cashamount + $cashamountop;

// Cash sales from billing_ip
$querycashsalesip = "SELECT SUM(totalamountuhx) as amount FROM billing_ip WHERE billdate='$todaydate' AND patientbilltype='PAY NOW'";
$cashsalesipex = mysqli_query($GLOBALS["___mysqli_ston"], $querycashsalesip) or die("Error in querycashsalesip: " . mysqli_error($GLOBALS["___mysqli_ston"]));
$cashresip = mysqli_fetch_array($cashsalesipex);
$cashamountip = $cashresip["amount"] ?: 0;

$totalRevenue = $newcasham + $cashamountip;

// Get patient counts
$querytotal = "SELECT customercode FROM master_customer WHERE registrationdate='$todaydate'";
$hospitalpatient = 0;
$totalPatients = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], $querytotal));

// Get consultation counts
$querymaster = "SELECT department FROM master_visitentry WHERE patientcode IN (SELECT customercode FROM master_customer WHERE registrationdate='$todaydate') AND consultationdate='$todaydate'";
$masterex = mysqli_query($GLOBALS["___mysqli_ston"], $querymaster);
$totalConsultations = mysqli_num_rows($masterex);

// Get lab test counts
$querylab = "SELECT COUNT(*) as count FROM billing_paynowlab WHERE billdate='$todaydate'";
$labex = mysqli_query($GLOBALS["___mysqli_ston"], $querylab);
$labres = mysqli_fetch_array($labex);
$totalLabTests = $labres['count'] ?: 0;

// Get radiology test counts
$queryrad = "SELECT COUNT(*) as count FROM billing_paynowradiology WHERE billdate='$todaydate'";
$radex = mysqli_query($GLOBALS["___mysqli_ston"], $queryrad);
$radres = mysqli_fetch_array($radex);
$totalRadiologyTests = $radres['count'] ?: 0;

// Get services counts
$queryservice = "SELECT COUNT(*) as count FROM billing_paynowservices WHERE billdate='$todaydate'";
$serviceex = mysqli_query($GLOBALS["___mysqli_ston"], $queryservice);
$serviceres = mysqli_fetch_array($serviceex);
$totalServices = $serviceres['count'] ?: 0;

// Get pharmacy counts
$querypharmacy = "SELECT COUNT(*) as count FROM billing_paynowpharmacy WHERE billdate='$todaydate'";
$pharmacyex = mysqli_query($GLOBALS["___mysqli_ston"], $querypharmacy);
$pharmacyres = mysqli_fetch_array($pharmacyex);
$totalPharmacy = $pharmacyres['count'] ?: 0;

// Get IP counts
$queryip = "SELECT COUNT(*) as count FROM billing_ip WHERE billdate='$todaydate'";
$ipex = mysqli_query($GLOBALS["___mysqli_ston"], $queryip);
$ipres = mysqli_fetch_array($ipex);
$totalIP = $ipres['count'] ?: 0;

// Calculate yesterday's date for comparison
$yesterdaydate = date('Y-m-d', strtotime($todaydate . ' -1 day'));

// Calculate percentage changes from yesterday
function calculatePercentageChange($today, $yesterday) {
    if ($yesterday == 0) {
        return $today > 0 ? 100 : 0;
    }
    return round((($today - $yesterday) / $yesterday) * 100, 1);
}

// Get yesterday's data for comparison
$queryyesterdayrevenue = "SELECT 
    (SELECT COALESCE(SUM(totalamount), 0) FROM billing_paynow WHERE billdate='$yesterdaydate') +
    (SELECT COALESCE(SUM(consultation), 0) FROM billing_consultation WHERE billdate='$yesterdaydate') +
    (SELECT COALESCE(SUM(totalamountuhx), 0) FROM billing_ip WHERE billdate='$yesterdaydate' AND patientbilltype='PAY NOW')
    as yesterday_revenue";
$yesterdayrevenueex = mysqli_query($GLOBALS["___mysqli_ston"], $queryyesterdayrevenue);
$yesterdayrevenueres = mysqli_fetch_array($yesterdayrevenueex);
$yesterdayRevenue = $yesterdayrevenueres['yesterday_revenue'] ?: 0;

$queryyesterdaypatients = "SELECT COUNT(*) as count FROM master_customer WHERE registrationdate='$yesterdaydate'";
$yesterdaypatientsex = mysqli_query($GLOBALS["___mysqli_ston"], $queryyesterdaypatients);
$yesterdaypatientsres = mysqli_fetch_array($yesterdaypatientsex);
$yesterdayPatients = $yesterdaypatientsres['count'] ?: 0;

$queryyesterdayconsultations = "SELECT COUNT(*) as count FROM master_visitentry WHERE consultationdate='$yesterdaydate'";
$yesterdayconsultationsex = mysqli_query($GLOBALS["___mysqli_ston"], $queryyesterdayconsultations);
$yesterdayconsultationsres = mysqli_fetch_array($yesterdayconsultationsex);
$yesterdayConsultations = $yesterdayconsultationsres['count'] ?: 0;

$queryyesterdaylab = "SELECT COUNT(*) as count FROM billing_paynowlab WHERE billdate='$yesterdaydate'";
$yesterdaylabex = mysqli_query($GLOBALS["___mysqli_ston"], $queryyesterdaylab);
$yesterdaylabres = mysqli_fetch_array($yesterdaylabex);
$yesterdayLabTests = $yesterdaylabres['count'] ?: 0;

$queryyesterdayrad = "SELECT COUNT(*) as count FROM billing_paynowradiology WHERE billdate='$yesterdaydate'";
$yesterdayradex = mysqli_query($GLOBALS["___mysqli_ston"], $queryyesterdayrad);
$yesterdayradres = mysqli_fetch_array($yesterdayradex);
$yesterdayRadiologyTests = $yesterdayradres['count'] ?: 0;

$queryyesterdayservices = "SELECT COUNT(*) as count FROM billing_paynowservices WHERE billdate='$yesterdaydate'";
$yesterdayservicesex = mysqli_query($GLOBALS["___mysqli_ston"], $queryyesterdayservices);
$yesterdayservicesres = mysqli_fetch_array($yesterdayservicesex);
$yesterdayServices = $yesterdayservicesres['count'] ?: 0;

$queryyesterdaypharmacy = "SELECT COUNT(*) as count FROM billing_paynowpharmacy WHERE billdate='$yesterdaydate'";
$yesterdaypharmacyex = mysqli_query($GLOBALS["___mysqli_ston"], $queryyesterdaypharmacy);
$yesterdaypharmacyres = mysqli_fetch_array($yesterdaypharmacyex);
$yesterdayPharmacy = $yesterdaypharmacyres['count'] ?: 0;

$queryyesterdayip = "SELECT COUNT(*) as count FROM billing_ip WHERE billdate='$yesterdaydate'";
$yesterdayipex = mysqli_query($GLOBALS["___mysqli_ston"], $queryyesterdayip);
$yesterdayipres = mysqli_fetch_array($yesterdayipex);
$yesterdayIP = $yesterdayipres['count'] ?: 0;

// Calculate percentage changes
$revenueChange = calculatePercentageChange($totalRevenue, $yesterdayRevenue);
$patientsChange = calculatePercentageChange($totalPatients, $yesterdayPatients);
$consultationsChange = calculatePercentageChange($totalConsultations, $yesterdayConsultations);
$labChange = calculatePercentageChange($totalLabTests, $yesterdayLabTests);
$radiologyChange = calculatePercentageChange($totalRadiologyTests, $yesterdayRadiologyTests);
$servicesChange = calculatePercentageChange($totalServices, $yesterdayServices);
$pharmacyChange = calculatePercentageChange($totalPharmacy, $yesterdayPharmacy);
$ipChange = calculatePercentageChange($totalIP, $yesterdayIP);

// Payment method breakdown
$querypayment = "SELECT 
    SUM(cashamount) as cash,
    SUM(cardamount) as card,
    SUM(onlineamount) as online,
    SUM(creditamount) as credit,
    SUM(chequeamount) as cheque
    FROM master_transactionpaynow WHERE transactiondate = '$todaydate'";

$paymentex = mysqli_query($GLOBALS["___mysqli_ston"], $querypayment);
$paymentres = mysqli_fetch_array($paymentex);

$cashAmount = $paymentres['cash'] ?: 0;
$cardAmount = $paymentres['card'] ?: 0;
$onlineAmount = $paymentres['online'] ?: 0;
$creditAmount = $paymentres['credit'] ?: 0;
$chequeAmount = $paymentres['cheque'] ?: 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/newdashboard-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            <span class="location-info">📍 Location: <?php echo htmlspecialchars($res1location); ?> | Company: <?php echo htmlspecialchars($companyname); ?></span>
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
        <span>Dashboard</span>
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
                    <li class="nav-item active">
                        <a href="newdashboard.php" class="nav-link">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="patientregistration1.php" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>Patient Registration</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipadmission1.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>IP Admission</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billing1.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Billing</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="labitem1master.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="radiologyitem1master.php" class="nav-link">
                            <i class="fas fa-x-ray"></i>
                            <span>Radiology</span>
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
                <?php include ("includes/alertmessages1.php"); ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Dashboard Overview</h2>
                    <p>Real-time insights and analytics for your healthcare management system.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportDashboard()">
                        <i class="fas fa-download"></i> Export
                    </button>
                    <button type="button" class="btn btn-outline" onclick="printDashboard()">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>

            <!-- Date Filter Section -->
            <div class="date-filter-section">
                <div class="date-filter-content">
                    <span class="date-filter-label">View Date:</span>
                    <input type="date" id="dashboardDate" class="date-filter-input" value="<?php echo $todaydate; ?>">
                </div>
                <div class="date-filter-actions">
                    <span class="date-filter-info">Last updated: <?php echo date('H:i:s'); ?></span>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="summary-cards">
                <div class="summary-card">
                    <div class="summary-card-icon revenue">
                        <i class="fas fa-rupee-sign"></i>
                    </div>
                    <div class="summary-card-number">₹<?php echo number_format($totalRevenue, 0); ?></div>
                    <div class="summary-card-label">Total Revenue</div>
                    <div class="summary-card-change <?php echo $revenueChange >= 0 ? 'positive' : 'negative'; ?>">
                        <?php echo $revenueChange >= 0 ? '+' : ''; ?><?php echo $revenueChange; ?>% from yesterday
                    </div>
                </div>
                
                <div class="summary-card">
                    <div class="summary-card-icon patients">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="summary-card-number"><?php echo $totalPatients; ?></div>
                    <div class="summary-card-label">New Patients</div>
                    <div class="summary-card-change <?php echo $patientsChange >= 0 ? 'positive' : 'negative'; ?>">
                        <?php echo $patientsChange >= 0 ? '+' : ''; ?><?php echo $patientsChange; ?>% from yesterday
                    </div>
                </div>
                
                <div class="summary-card">
                    <div class="summary-card-icon consultations">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                    <div class="summary-card-number" data-metric="consultations"><?php echo $totalConsultations; ?></div>
                    <div class="summary-card-label">Consultations</div>
                    <div class="summary-card-change <?php echo $consultationsChange >= 0 ? 'positive' : 'negative'; ?>">
                        <?php echo $consultationsChange >= 0 ? '+' : ''; ?><?php echo $consultationsChange; ?>% from yesterday
                    </div>
                </div>
                
                <div class="summary-card">
                    <div class="summary-card-icon lab">
                        <i class="fas fa-flask"></i>
                    </div>
                    <div class="summary-card-number" data-metric="lab"><?php echo $totalLabTests; ?></div>
                    <div class="summary-card-label">Lab Tests</div>
                    <div class="summary-card-change <?php echo $labChange >= 0 ? 'positive' : 'negative'; ?>">
                        <?php echo $labChange >= 0 ? '+' : ''; ?><?php echo $labChange; ?>% from yesterday
                    </div>
                </div>
                
                <div class="summary-card">
                    <div class="summary-card-icon radiology">
                        <i class="fas fa-x-ray"></i>
                    </div>
                    <div class="summary-card-number" data-metric="radiology"><?php echo $totalRadiologyTests; ?></div>
                    <div class="summary-card-label">Radiology Tests</div>
                    <div class="summary-card-change <?php echo $radiologyChange >= 0 ? 'positive' : 'negative'; ?>">
                        <?php echo $radiologyChange >= 0 ? '+' : ''; ?><?php echo $radiologyChange; ?>% from yesterday
                    </div>
                </div>
                
                <div class="summary-card">
                    <div class="summary-card-icon services">
                        <i class="fas fa-tools"></i>
                    </div>
                    <div class="summary-card-number" data-metric="services"><?php echo $totalServices; ?></div>
                    <div class="summary-card-label">Services</div>
                    <div class="summary-card-change <?php echo $servicesChange >= 0 ? 'positive' : 'negative'; ?>">
                        <?php echo $servicesChange >= 0 ? '+' : ''; ?><?php echo $servicesChange; ?>% from yesterday
                    </div>
                </div>
                
                <div class="summary-card">
                    <div class="summary-card-icon pharmacy">
                        <i class="fas fa-pills"></i>
                    </div>
                    <div class="summary-card-number"><?php echo $totalPharmacy; ?></div>
                    <div class="summary-card-label">Pharmacy</div>
                    <div class="summary-card-change <?php echo $pharmacyChange >= 0 ? 'positive' : 'negative'; ?>">
                        <?php echo $pharmacyChange >= 0 ? '+' : ''; ?><?php echo $pharmacyChange; ?>% from yesterday
                    </div>
                </div>
                
                <div class="summary-card">
                    <div class="summary-card-icon ip">
                        <i class="fas fa-bed"></i>
                    </div>
                    <div class="summary-card-number" data-metric="ip"><?php echo $totalIP; ?></div>
                    <div class="summary-card-label">IP Admissions</div>
                    <div class="summary-card-change <?php echo $ipChange >= 0 ? 'positive' : 'negative'; ?>">
                        <?php echo $ipChange >= 0 ? '+' : ''; ?><?php echo $ipChange; ?>% from yesterday
                    </div>
                </div>
            </div>

            <!-- Financial Overview -->
            <div class="financial-cards">
                <div class="financial-card">
                    <div class="financial-card-header">
                        <div class="financial-card-title">
                            <i class="fas fa-money-bill-wave financial-card-icon"></i>
                            Cash Payments
                        </div>
                    </div>
                    <div class="financial-card-amount" data-payment="cash">₹<?php echo number_format($cashAmount, 2); ?></div>
                    <div class="financial-card-subtitle">Today's cash transactions</div>
                </div>
                
                <div class="financial-card">
                    <div class="financial-card-header">
                        <div class="financial-card-title">
                            <i class="fas fa-credit-card financial-card-icon"></i>
                            Card Payments
                        </div>
                    </div>
                    <div class="financial-card-amount" data-payment="card">₹<?php echo number_format($cardAmount, 2); ?></div>
                    <div class="financial-card-subtitle">Today's card transactions</div>
                </div>
                
                <div class="financial-card">
                    <div class="financial-card-header">
                        <div class="financial-card-title">
                            <i class="fas fa-mobile-alt financial-card-icon"></i>
                            Online Payments
                        </div>
                    </div>
                    <div class="financial-card-amount" data-payment="online">₹<?php echo number_format($onlineAmount, 2); ?></div>
                    <div class="financial-card-subtitle">Today's online transactions</div>
                </div>
                
                <div class="financial-card">
                    <div class="financial-card-header">
                        <div class="financial-card-title">
                            <i class="fas fa-handshake financial-card-icon"></i>
                            Credit Payments
                        </div>
                    </div>
                    <div class="financial-card-amount" data-payment="credit">₹<?php echo number_format($creditAmount, 2); ?></div>
                    <div class="financial-card-subtitle">Today's credit transactions</div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="charts-section">
                <div class="charts-header">
                    <div class="charts-title">
                        <i class="fas fa-chart-line"></i>
                        Analytics & Trends
                    </div>
                </div>
                
                <div class="charts-grid">
                    <div class="chart-container">
                        <canvas id="revenueChart"></canvas>
                    </div>
                    <div class="chart-container">
                        <canvas id="patientChart"></canvas>
                    </div>
                    <div class="chart-container">
                        <canvas id="paymentMethodChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <div class="quick-actions-header">
                    <div class="quick-actions-title">
                        <i class="fas fa-bolt"></i>
                        Quick Actions
                    </div>
                </div>
                
                <div class="quick-actions-grid">
                    <a href="patientregistration1.php" class="quick-action-card" data-action="patient-registration">
                        <div class="quick-action-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="quick-action-label">Patient Registration</div>
                    </a>
                    
                    <a href="ipadmission1.php" class="quick-action-card" data-action="ip-admission">
                        <div class="quick-action-icon">
                            <i class="fas fa-bed"></i>
                        </div>
                        <div class="quick-action-label">IP Admission</div>
                    </a>
                    
                    <a href="billing1.php" class="quick-action-card" data-action="billing">
                        <div class="quick-action-icon">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <div class="quick-action-label">Billing</div>
                    </a>
                    
                    <a href="labitem1master.php" class="quick-action-card" data-action="lab-management">
                        <div class="quick-action-icon">
                            <i class="fas fa-flask"></i>
                        </div>
                        <div class="quick-action-label">Lab Management</div>
                    </a>
                    
                    <a href="radiologyitem1master.php" class="quick-action-card" data-action="radiology">
                        <div class="quick-action-icon">
                            <i class="fas fa-x-ray"></i>
                        </div>
                        <div class="quick-action-label">Radiology</div>
                    </a>
                    
                    <a href="reports1.php" class="quick-action-card" data-action="reports">
                        <div class="quick-action-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div class="quick-action-label">Reports</div>
                    </a>
                </div>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/newdashboard-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
