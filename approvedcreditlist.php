<?php
// Enable strict error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session and include security files
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

// Set timezone
date_default_timezone_set('Asia/Calcutta');

// Security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

// Initialize variables with proper sanitization
$username = isset($_SESSION["username"]) ? $_SESSION["username"] : '';
$companyanum = isset($_SESSION["companyanum"]) ? $_SESSION["companyanum"] : '';
$companyname = isset($_SESSION["companyname"]) ? $_SESSION["companyname"] : '';
$docno = isset($_SESSION['docno']) ? $_SESSION['docno'] : '';

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

// Input sanitization function
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// CSRF Token generation
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(32));
}

// CSRF Token validation function
function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && $_SESSION['csrf_token'] === $token;
}

// Get default location using prepared statement
$stmt = mysqli_prepare($GLOBALS["___mysqli_ston"], "SELECT * FROM master_location WHERE status <> 'deleted' ORDER BY locationname LIMIT 1");
if ($stmt) {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $res = mysqli_fetch_array($result);
    mysqli_stmt_close($stmt);
    
    $locationname = isset($res["locationname"]) ? $res["locationname"] : '';
    $locationcode = isset($res["locationcode"]) ? $res["locationcode"] : '';
    $res12locationanum = isset($res["auto_number"]) ? $res["auto_number"] : '';
} else {
    $locationname = '';
    $locationcode = '';
    $res12locationanum = '';
}

// Get location for sort by location purpose
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
if ($location != '') {
    $locationcode = $location;
}

// Handle delete action with CSRF protection
if (isset($_REQUEST["st"])) { 
    $st = sanitizeInput($_REQUEST["st"]); 
} else { 
    $st = ""; 
}

if ($st == 'del') {
    // Validate CSRF token
    if (!isset($_REQUEST['csrf_token']) || !validateCSRFToken($_REQUEST['csrf_token'])) {
        die('CSRF token validation failed');
    }
    
    $delanum = sanitizeInput($_REQUEST["anum"]);
    
    // Use prepared statement for delete
    $stmt = mysqli_prepare($GLOBALS["___mysqli_ston"], "UPDATE ip_creditapproval SET recordstatus = 'deleted' WHERE auto_number = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $delanum);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location: approvedcreditlist.php?msg=deleted");
        exit();
    } else {
        $errmsg = "Error preparing delete statement";
    }
}

// Check for URL messages
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'deleted') {
        $errmsg = "Credit approval deleted successfully.";
        $bgcolorcode = 'success';
    }
}

// Get total count
$querynw1 = "select * from ip_creditapproval where recordstatus='approved' group by visitcode order by auto_number desc";
$execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$resnw1 = mysqli_num_rows($execnw1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Approved Credit List - MedStar Hospital Management System">
    <meta name="robots" content="noindex, nofollow">
    <title>Approved Credit List - MedStar Hospital</title>
    
    <!-- Preload critical resources -->
    <link rel="preload" href="css/approvedcreditlist-modern.css" as="style">
    <link rel="preload" href="js/approvedcreditlist-modern.js" as="script">
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/approvedcreditlist-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebApplication",
        "name": "MedStar Hospital Management System",
        "description": "Advanced Healthcare Management Platform - Approved Credit List",
        "url": "<?php echo $_SERVER['REQUEST_URI']; ?>",
        "applicationCategory": "BusinessApplication",
        "operatingSystem": "Web Browser"
    }
    </script>
</head>
<body onLoad="funcPopupOnLoader()">
    <!-- Modern MedStar Hospital Management Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Advanced Healthcare Management Platform</p>
    </header>

    <!-- Navigation Breadcrumb -->
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Dashboard</a>
        <span>→</span>
        <span>Credit Management</span>
        <span>→</span>
        <span>Approved Credit List</span>
    </nav>

    <!-- Floating Menu Toggle -->
    <button class="floating-menu-toggle" id="mobileMenuToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Main Container with Sidebar -->
    <div class="main-container-with-sidebar" id="mainContainer">
        <!-- Left Sidebar -->
        <aside id="leftSidebar" class="left-sidebar">
            <div class="sidebar-header">
                <h3>🏥 MedStar</h3>
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="sidebar-nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="mainmenu1.php" class="nav-link">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountsmain.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Account Main Types</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountssub.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Account Sub Types</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountname1.php" class="nav-link">
                            <i class="fas fa-tags"></i>
                            <span>Account Names</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountstatement.php" class="nav-link">
                            <i class="fas fa-file-invoice"></i>
                            <span>Account Statement</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountreceivable.php" class="nav-link">
                            <i class="fas fa-hand-holding-usd"></i>
                            <span>Receivables</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountwiseoutstandingreport.php" class="nav-link">
                            <i class="fas fa-chart-pie"></i>
                            <span>Account Wise Outstanding</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="paylaterpaymententry.php" class="nav-link">
                            <i class="fas fa-credit-card"></i>
                            <span>Pay Later Payment Entry</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="approvedcreditlist.php" class="nav-link active">
                            <i class="fas fa-check-circle"></i>
                            <span>Approved Credit List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="expenses.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>Expenses</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="income.php" class="nav-link">
                            <i class="fas fa-dollar-sign"></i>
                            <span>Income</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addbank1.php" class="nav-link">
                            <i class="fas fa-university"></i>
                            <span>Bank Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="patientmanagement.php" class="nav-link">
                            <i class="fas fa-user-injured"></i>
                            <span>Patient Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="consultation.php" class="nav-link">
                            <i class="fas fa-stethoscope"></i>
                            <span>Consultation</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="labitems.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Items</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="radiology.php" class="nav-link">
                            <i class="fas fa-x-ray"></i>
                            <span>Radiology</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="employeemanagement.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Employee Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="departmentmanagement.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Department Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="rightsaccess.php" class="nav-link">
                            <i class="fas fa-shield-alt"></i>
                            <span>Employee Rights Access</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content">
            <!-- Success/Error Messages -->
            <?php if ($errmsg != ''): ?>
                <div class="alert alert-<?php echo ($bgcolorcode == 'success') ? 'success' : 'error'; ?>">
                    <i class="fas fa-<?php echo ($bgcolorcode == 'success') ? 'check-circle' : 'exclamation-triangle'; ?> alert-icon"></i>
                    <span><?php echo htmlspecialchars($errmsg); ?></span>
                </div>
            <?php endif; ?>
            
            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Approved Credit List</h2>
                    <p>Manage approved credit approvals for patients</p>
                </div>
                <div class="page-header-actions">
                    <span class="total-count">Total: <?php echo $resnw1; ?> records</span>
                </div>
            </div>
            
            <!-- Data Table Section -->
            <section class="data-table-section">
                <div class="data-table-header">
                    <span class="data-table-icon">📋</span>
                    <h3 class="data-table-title">Approved Credit Approvals</h3>
                </div>
                
                <!-- Data Table -->
                <div class="data-table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Patient Code</th>
                                <th>Patient Name</th>
                                <th>Visit Code</th>
                                <th>Account</th>
                                <th>Location</th>
                                <th>IP Date</th>
                                <th>Plan</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Data loop starts here
                            $sno = 0;
                            $query2 = "select * from master_location where status <> 'deleted' order by locationname";
                            $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res2 = mysqli_fetch_array($exec2)) {
                                $locationname = $res2["locationname"];
                                $locationcode = $res2["locationcode"];

                                $query1 = "select * from ip_creditapproval where recordstatus='approved' AND locationcode = '".$locationcode."' group by visitcode order by auto_number desc";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $patientcode = $res1['patientcode'];
                                    $visitcode = $res1['visitcode'];
                                    $patientname = $res1['patientname'];
                                    $account = $res1['accountname'];
                                    $locationcodeget = $res1['locationcode'];
                                    $locationnameget = $res1['locationname'];
                                    
                                    $query11 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
                                    $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res11 = mysqli_fetch_array($exec11);
                                    $ipdate = $res11['consultationdate'];
                                    
                                    $ipvist_autonumber = $res11['auto_number'];
                                    $planname = $res11['planname'];
                                    
                                    $query110 = "select smartap from master_planname where auto_number='$planname'";
                                    $exec110 = mysqli_query($GLOBALS["___mysqli_ston"], $query110) or die ("Error in Query110".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res110 = mysqli_fetch_array($exec110);
                                    $smartap = $res110['smartap'];
                                    
                                    $colorloopcount = $colorloopcount + 1;
                                    $sno = $sno + 1;
                                    ?>
                                    <tr>
                                        <td><?php echo $sno; ?></td>
                                        <td><?php echo htmlspecialchars($patientcode); ?></td>
                                        <td><?php echo htmlspecialchars($patientname); ?></td>
                                        <td><?php echo htmlspecialchars($visitcode); ?></td>
                                        <td><?php echo htmlspecialchars($account); ?></td>
                                        <td><?php echo htmlspecialchars($locationnameget); ?></td>
                                        <td><?php echo htmlspecialchars($ipdate); ?></td>
                                        <td><?php echo htmlspecialchars($smartap); ?></td>
                                        <td class="action-buttons">
                                            <a href="ip_creditapproval.php?patientcode=<?php echo urlencode($patientcode); ?>&visitcode=<?php echo urlencode($visitcode); ?>" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <a href="approvedcreditlist.php?st=del&anum=<?php echo $res1['auto_number']; ?>&csrf_token=<?php echo $_SESSION['csrf_token']; ?>" 
                                               class="btn btn-danger btn-sm" 
                                               onclick="return confirm('Are you sure you want to delete this credit approval?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/approvedcreditlist-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
