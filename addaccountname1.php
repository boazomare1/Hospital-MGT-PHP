<?php
// Modern PHP with strict error reporting and security headers
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

// Security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

// Initialize variables with proper validation
$username = isset($_SESSION["username"]) ? $_SESSION["username"] : '';
$companyanum = isset($_SESSION["companyanum"]) ? $_SESSION["companyanum"] : '';
$companyname = isset($_SESSION["companyname"]) ? $_SESSION["companyname"] : '';
$ipaddress = isset($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"] : '';
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$dummy = '';
$costcenteridsdb = array();

// CSRF Token generation
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(32));
}

// CSRF Token validation
function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && $_SESSION['csrf_token'] === $token;
}

// Input sanitization function
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Validate and sanitize form data
if (isset($_POST["frmflag1"]) && $_POST["frmflag1"] == 'frmflag1') {
    // CSRF Token validation
    if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
        $errmsg = "Security validation failed. Please try again.";
        $bgcolorcode = 'failed';
    } else {
        // Sanitize and validate inputs
        $accountname = sanitizeInput(isset($_POST["accountname"]) ? $_POST["accountname"] : '');
        $accountname = strtoupper($accountname);
        $length = strlen($accountname);
        
        $expirydate = sanitizeInput(isset($_POST['expirydate']) ? $_POST['expirydate'] : '');
        $recordstatus = sanitizeInput(isset($_POST['recordstatus']) ? $_POST['recordstatus'] : 'ACTIVE');
        $address = sanitizeInput(isset($_POST['address']) ? $_POST['address'] : '');
        $accountsmaintype = (int)(isset($_POST['accountsmaintype']) ? $_POST['accountsmaintype'] : 0);
        $accountssub = (int)(isset($_POST['accountssub']) ? $_POST['accountssub'] : 0);
        $paymenttype = '';
        $subtype = '';
        $misreport = 0;
        
        if($accountssub == 2) {
            $paymenttype = (int)(isset($_POST['paymenttype']) ? $_POST['paymenttype'] : 0);
        }
        
        $openingbalancecredit = (float)(isset($_POST['openingbalancecredit']) ? $_POST['openingbalancecredit'] : 0);
        $openingbalancedebit = (float)(isset($_POST['openingbalancedebit']) ? $_POST['openingbalancedebit'] : 0);
        
        $is_receivable = isset($_POST['is_receivable']) ? 1 : 0;
        
        $id = sanitizeInput(isset($_POST['id']) ? $_POST['id'] : '');
        $contact = sanitizeInput(isset($_POST['contact']) ? $_POST['contact'] : '');
        $phone = sanitizeInput(isset($_POST['phone']) ? $_POST['phone'] : '');
        $locationcode = (int)(isset($_POST['location']) ? $_POST['location'] : 0);
        $currency = sanitizeInput(isset($_POST['currency']) ? $_POST['currency'] : 'KSH');
        $fxrate = (float)(isset($_POST['fxrate']) ? $_POST['fxrate'] : 1.0);
        
        $grnbackdate = isset($_POST['grnbackdate']) ? 1 : 0;
        
        if(isset($_POST['iscapitation'])) {
            $iscapitation = 1;
            $capitationservicename = sanitizeInput(isset($_POST['capitationservicename']) ? $_POST['capitationservicename'] : '');
            $capitationservicecode = sanitizeInput(isset($_POST['capitationservicecode']) ? $_POST['capitationservicecode'] : '');
        } else {
            $iscapitation = 0;
            $capitationservicename = '';
            $capitationservicecode = '';
        }
        
        // Validation
        if($accountsmaintype == 0 || $accountssub == 0) {
            $errmsg = "Failed. Account Main and Account Sub must be selected.";
            $bgcolorcode = 'failed';
        } elseif(empty($accountname)) {
            $errmsg = "Failed. Account name is required.";
            $bgcolorcode = 'failed';
        } elseif(empty($id)) {
            $errmsg = "Failed. Account ID is required.";
            $bgcolorcode = 'failed';
        } elseif($length > 100) {
            $errmsg = "Failed. Account name cannot exceed 100 characters.";
            $bgcolorcode = 'failed';
        } else {
            // Use prepared statements for database queries
            $stmt = $GLOBALS["___mysqli_ston"]->prepare("SELECT locationname FROM master_location WHERE locationcode = ?");
            $stmt->bind_param("i", $locationcode);
            $stmt->execute();
            $stmt->bind_result($locationname);
            $stmt->fetch();
            $stmt->close();
            $cc_name = "";
            
            // Check if account name or ID already exists
            $stmt = $GLOBALS["___mysqli_ston"]->prepare("SELECT COUNT(*) as count FROM master_accountname WHERE (accountname = ? OR id = ?)");
            $stmt->bind_param("ss", $accountname, $id);
            $stmt->execute();
            $stmt->bind_result($res2);
            $stmt->fetch();
            $stmt->close();
            
            if ($res2 == 0) {
                if($accountssub == 2) {
                    $currency = "KSHS";
                    $fxrate = 1.0;
                    $stmt = $GLOBALS["___mysqli_ston"]->prepare("INSERT INTO master_subtype (maintype, subtype, subtype_ledger, ipaddress, recorddate, username, currency, fxrate) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("issssssd", $paymenttype, $accountname, $id, $ipaddress, $updatedatetime, $username, $currency, $fxrate);
                    $stmt->execute();
                    
                    $stmt = $GLOBALS["___mysqli_ston"]->prepare("SELECT auto_number FROM master_subtype WHERE subtype_ledger = ?");
                    $stmt->bind_param("s", $id);
                    $stmt->execute();
                    $stmt->bind_result($subtype);
                    $stmt->fetch();
                    $stmt->close();
                }
                
                // Insert new account name using prepared statement
                $stmt = $GLOBALS["___mysqli_ston"]->prepare("INSERT INTO master_accountname (accountname, recordstatus, paymenttype, subtype, expirydate, ipaddress, recorddate, username, address, accountsmain, accountssub, misreport, openingbalancecredit, openingbalancedebit, id, contact, locationcode, locationname, currency, fxrate, iscapitation, serviceitemcode, phone, is_receivable, cost_center, grn_backdate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssiisssssiiiddssiisssssss", $accountname, $recordstatus, $paymenttype, $subtype, $expirydate, $ipaddress, $updatedatetime, $username, $address, $accountsmaintype, $accountssub, $misreport, $openingbalancecredit, $openingbalancedebit, $id, $contact, $locationcode, $locationname, $currency, $fxrate, $iscapitation, $capitationservicecode, $phone, $is_receivable, $cc_name, $grnbackdate);
                
                if ($stmt->execute()) {
                    $stmt->close();
                    $errmsg = "Success. New Account Name Added Successfully.";
                    $bgcolorcode = 'success';
                    
                    if($accountssub == 2) {
                        $stmt = $GLOBALS["___mysqli_ston"]->prepare("SELECT auto_number FROM master_accountname WHERE id = ?");
                        $stmt->bind_param("s", $id);
                        $stmt->execute();
                        $stmt->bind_result($ledgeranum);
                        $stmt->fetch();
                        $stmt->close();
                        
                        $stmt = $GLOBALS["___mysqli_ston"]->prepare("UPDATE master_subtype SET ledger_anum = ? WHERE auto_number = ?");
                        $stmt->bind_param("ii", $ledgeranum, $subtype);
                        $stmt->execute();
                        $stmt->close();
                    }
                } else {
                    $stmt->close();
                    $errmsg = "Failed. Database error occurred.";
                    $bgcolorcode = 'failed';
                }
            } else {
                $errmsg = "Failed. Account Name or ID Already Exists.";
                $bgcolorcode = 'failed';
            }
        }
    }
}

// Handle status changes with proper validation
$st = isset($_GET["st"]) ? $_GET["st"] : '';
if ($st == 'del') {
    $delanum = (int)(isset($_GET["anum"]) ? $_GET["anum"] : 0);
    if ($delanum > 0) {
        $stmt = $GLOBALS["___mysqli_ston"]->prepare("UPDATE master_accountname SET recordstatus = 'DELETED' WHERE auto_number = ?");
        $stmt->bind_param("i", $delanum);
        $stmt->execute();
        $stmt->close();
    }
}
if ($st == 'activate') {
    $delanum = (int)(isset($_GET["anum"]) ? $_GET["anum"] : 0);
    if ($delanum > 0) {
        $stmt = $GLOBALS["___mysqli_ston"]->prepare("UPDATE master_accountname SET recordstatus = 'ACTIVE' WHERE auto_number = ?");
        $stmt->bind_param("i", $delanum);
        $stmt->execute();
        $stmt->close();
    }
}
if ($st == 'default') {
    $delanum = (int)(isset($_GET["anum"]) ? $_GET["anum"] : 0);
    if ($delanum > 0) {
        $stmt = $GLOBALS["___mysqli_ston"]->prepare("UPDATE master_accountname SET defaultstatus = '' WHERE cstid = ? AND cstname = ?");
        $stmt->bind_param("ss", $custid, $custname);
        $stmt->execute();
        $stmt->close();
        
        $stmt = $GLOBALS["___mysqli_ston"]->prepare("UPDATE master_accountname SET defaultstatus = 'DEFAULT' WHERE auto_number = ?");
        $stmt->bind_param("i", $delanum);
        $stmt->execute();
        $stmt->close();
    }
}
if ($st == 'removedefault') {
    $delanum = (int)(isset($_GET["anum"]) ? $_GET["anum"] : 0);
    if ($delanum > 0) {
        $stmt = $GLOBALS["___mysqli_ston"]->prepare("UPDATE master_accountname SET defaultstatus = '' WHERE auto_number = ?");
        $stmt->bind_param("i", $delanum);
        $stmt->execute();
        $stmt->close();
    }
}

$svccount = isset($_GET["svccount"]) ? $_GET["svccount"] : '';
if ($svccount == 'firstentry') {
    $errmsg = "Please Add Account Name To Proceed For Billing.";
    $bgcolorcode = 'failed';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Add and manage account names for MedStar Hospital Management System">
    <meta name="robots" content="noindex, nofollow">
    <title>Account Name Management - MedStar Hospital</title>
    
    <!-- Preload critical resources -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" as="style">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" as="style">
    
    <!-- Modern CSS Framework -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/addaccountname1-modern.css?v=<?php echo time(); ?>">
    
    <!-- Date Picker Styles -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/autocomplete.css">
    
    <!-- Modern JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" integrity="sha256-lSjKY4/s1UMvivJgLcXjzCpnzqbGdCw7uQt2r4jqcjQ=" crossorigin="anonymous"></script>
    
    <!-- External JavaScript -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script type="text/javascript" src="js/jquery.min-autocomplete.js"></script>
    <script type="text/javascript" src="js/autoaccountanumsearch.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    
    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebApplication",
        "name": "MedStar Hospital Management System",
        "description": "Account Name Management for Hospital Billing System"
    }
    </script>
</head>
<body>
    <!-- Skip Link for Accessibility -->
    <a href="#main-content" class="skip-link">Skip to main content</a>
    
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
        <span>Account Management</span>
        <span>→</span>
        <span>Add Account Name</span>
    </nav>

    <!-- Mobile Menu Toggle -->
    <button id="mobileMenuToggle" class="mobile-menu-toggle">
        <i class="fas fa-bars"></i>
    </button>

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
                    <li class="nav-item active">
                        <a href="addaccountname1.php" class="nav-link">
                            <i class="fas fa-address-book"></i>
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
                        <a href="accountreceivableentry.php" class="nav-link">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Receivables</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountexpense.php" class="nav-link">
                            <i class="fas fa-credit-card"></i>
                            <span>Expenses</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountincome.php" class="nav-link">
                            <i class="fas fa-coins"></i>
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
                        <a href="addpatient1.php" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>Add Patient</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeinpatientlist.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Inpatient List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addconsultation1.php" class="nav-link">
                            <i class="fas fa-stethoscope"></i>
                            <span>Consultation</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="labitem1master.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Items</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addradiologytemplate.php" class="nav-link">
                            <i class="fas fa-x-ray"></i>
                            <span>Radiology</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addemployee1.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Employees</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="adddoctor1.php" class="nav-link">
                            <i class="fas fa-user-md"></i>
                            <span>Doctors</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addnurse1.php" class="nav-link">
                            <i class="fas fa-user-nurse"></i>
                            <span>Nurses</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="adddepartment1.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Departments</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main id="main-content" class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <h2>Account Name Master</h2>
                <p>Add new account names and manage chart of accounts for billing and financial management.</p>
            </div>
            <div class="page-header-actions">
                <button type="button" class="btn btn-secondary" onclick="window.location.reload()">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
            </div>
        </div>

        <!-- Alert Messages -->
        <?php if ($errmsg != "") { ?>
        <div class="alert alert-<?php echo ($bgcolorcode == 'success') ? 'success' : (($bgcolorcode == 'failed') ? 'error' : 'info'); ?>">
            <i class="fas fa-<?php echo ($bgcolorcode == 'success') ? 'check-circle' : (($bgcolorcode == 'failed') ? 'exclamation-triangle' : 'info-circle'); ?>"></i>
            <span><?php echo htmlspecialchars($errmsg); ?></span>
        </div>
        <?php } ?>

        <!-- Add New Account Form -->
        <div class="form-section">
            <div class="form-section-header">
                <i class="fas fa-plus-circle form-section-icon"></i>
                <h3 class="form-section-title">Add New Account</h3>
            </div>
            
            <form name="form1" id="form1" method="post" action="addaccountname1.php" onSubmit="return Process()" novalidate>
                <!-- CSRF Token -->
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="location" class="form-label">Select Location *</label>
                        <select name="location" id="location" class="form-select" required>
                            <option value="">Select Location</option>
                            <?php
                            $query50 = "select * from master_location where status <> 'deleted' order by locationname";
                            $exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die ("Error in Query50".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res50 = mysqli_fetch_array($exec50)) {
                                $locationname = $res50["locationname"];
                                $locationcode = $res50["locationcode"];
                                ?>
                                <option value="<?php echo $locationcode; ?>"><?php echo htmlspecialchars($locationname); ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="accountsmaintype" class="form-label">Account Main Type *</label>
                        <select name="accountsmaintype" id="accountsmaintype" class="form-select" onChange="return funcAccountsMainTypeChange1()" required>
                            <option value="">Select Type</option>
                            <?php
                            $query5 = "select * from master_accountsmain where recordstatus = '' order by accountsmain";
                            $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res5 = mysqli_fetch_array($exec5)) {
                                $res5accountsmainanum = $res5["auto_number"];
                                $res5accountsmain = $res5["accountsmain"];
                                ?>
                                <option value="<?php echo $res5accountsmainanum; ?>"><?php echo htmlspecialchars($res5accountsmain); ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="accountssub" class="form-label">Account Sub Type *</label>
                        <select name="accountssub" id="accountssub" class="form-select" onChange="return accountsearchanum()" required>
                            <option value="">Select Sub Type</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="paymenttype" class="form-label">Main Type</label>
                        <select name="paymenttype" id="paymenttype" class="form-select" onChange="return funcPaymentTypeChange1()">
                            <option value="">Select Type</option>
                            <?php
                            $query5 = "select * from master_paymenttype where recordstatus = '' order by paymenttype";
                            $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res5 = mysqli_fetch_array($exec5)) {
                                $res5anum = $res5["auto_number"];
                                $res5paymenttype = $res5["paymenttype"];
                                ?>
                                <option value="<?php echo $res5anum; ?>"><?php echo htmlspecialchars($res5paymenttype); ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id" class="form-label">ID *</label>
                        <input name="id" id="id" class="form-input" style="text-transform:uppercase" readonly required />
                    </div>

                    <div class="form-group">
                        <label for="accountname" class="form-label">Account Name *</label>
                        <input name="accountname" id="accountname" class="form-input" style="text-transform:uppercase" required />
                    </div>

                    <div class="form-group">
                        <label for="recordstatus" class="form-label">Account Status</label>
                        <select name="recordstatus" id="recordstatus" class="form-select" style="text-transform:uppercase">
                            <option value="ACTIVE">ACTIVE</option>
                            <option value="DELETED">INACTIVE</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="currency" class="form-label">Currency *</label>
                        <select name="currency" id="currency" class="form-select" required>
                            <option value="KSH" selected>Kshs</option>
                            <?php 
                            $query10 = "select * from master_currency where recordstatus != 'deleted'";
                            $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($res10 = mysqli_fetch_array($exec10)) {
                                $currencyid = $res10['auto_number'];
                                $currency = $res10['currency'];
                                ?>
                                <option value="<?php echo $currency; ?>"><?php echo htmlspecialchars($currency); ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="expirydate" class="form-label">Account Validity End</label>
                        <input type="text" name="expirydate" id="expirydate" class="form-input" value="<?php echo date('Y-m-d'); ?>" onFocus="return funcexpiry();" readonly />
                    </div>

                    <div class="form-group">
                        <label for="fxrate" class="form-label">FX Rate *</label>
                        <input type="text" name="fxrate" id="fxrate" class="form-input" value="1.00" style="text-transform:uppercase" required />
                    </div>

                    <div class="form-group">
                        <label for="openingbalancedebit" class="form-label">Opening Balance Debit</label>
                        <input type="text" name="openingbalancedebit" id="openingbalancedebit" class="form-input" />
                    </div>

                    <div class="form-group">
                        <label for="openingbalancecredit" class="form-label">Opening Balance Credit</label>
                        <input type="text" name="openingbalancecredit" id="openingbalancecredit" class="form-input" />
                    </div>

                    <div class="form-group">
                        <label for="address" class="form-label">Address</label>
                        <textarea name="address" id="address" class="form-textarea" style="text-transform:uppercase" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="contact" class="form-label">Contact</label>
                        <input type="text" name="contact" id="contact" class="form-input" style="text-transform:uppercase" />
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-input" style="text-transform:uppercase" />
                    </div>
                </div>

                <!-- Cost Center Section -->
                <div id="non_multicc">
                    <div class="form-group">
                        <label class="form-label">Cost Centers</label>
                        <div class="cost-center-grid">
                            <?php
                            $i = 0;
                            $j = 0;
                            $ccchk = '';
                            $query5 = "select * from master_costcenter where recordstatus <> 'deleted' order by name";
                            $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res5 = mysqli_fetch_array($exec5)) {
                                $ccid = $res5["auto_number"];
                                $ccname = $res5["name"];
                                $i = $i + 1;
                                $j = $j + 1;
                                if(in_array($ccid, $costcenteridsdb)) {
                                    $ccchk = "checked";
                                } else {
                                    $ccchk = "";
                                }
                                ?>
                                <div class="cost-center-item">
                                    <input type="checkbox" name="costcenter[]" id="costcenter<?= $j; ?>" <?php echo $ccchk; ?> value="<?php echo $ccid; ?>">
                                    <label for="costcenter<?= $j; ?>"><?php echo htmlspecialchars($ccname); ?></label>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Capitation Section -->
                <div class="form-group">
                    <div class="form-checkbox">
                        <input type="checkbox" name="iscapitation" id="iscapitation" value="1" onClick="displayService()">
                        <label for="iscapitation">Is Capitation</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="capitationservice" class="form-label" id="servtext" style="display: none;">Select Service</label>
                    <input type="text" name="capitationservice" id="capitationservice" class="form-input" style="display: none;" />
                    <input type="hidden" name="capitationservicecode" id="capitationservicecode" />
                    <input type="hidden" name="capitationservicename" id="capitationservicename" />
                </div>

                <!-- Additional Options -->
                <div class="form-group">
                    <div class="form-checkbox">
                        <input type="checkbox" name="is_receivable" id="is_receivable" value="1">
                        <label for="is_receivable">Is Receivable</label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-checkbox">
                        <input type="checkbox" name="grnbackdate" id="grnbackdate" value="1">
                        <label for="grnbackdate">GRN Back Date</label>
                    </div>
                </div>

                <div class="form-actions">
                    <input type="hidden" name="frmflag" value="addnew" />
                    <input type="hidden" name="frmflag1" value="frmflag1" />
                    <input type="hidden" name="scrollfunc" id="scrollfunc" value="getdata">
                    <input type="hidden" name="serialno" id="serialno" value="50">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Submit
                    </button>
                    <button type="reset" class="btn btn-secondary">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                </div>
            </form>
        </div>

        <!-- Chart of Accounts Search -->
        <div class="form-section">
            <div class="form-section-header">
                <i class="fas fa-search form-section-icon"></i>
                <h3 class="form-section-title">Chart of Accounts - Search</h3>
            </div>
            
            <div class="search-section">
                <div class="search-header">
                    <i class="fas fa-filter search-icon"></i>
                    <h4 class="search-title">Search Accounts</h4>
                </div>
                
                <div class="search-controls">
                    <input type="text" id="accountsearch" name="accountsearch" class="search-input" placeholder="Account Search" />
                    <input type="hidden" id="hiddenaccountsearch" name="hiddenaccountsearch" value="">
                    
                    <select name="accountsmaintype1" id="accountsmaintype1" class="search-select" onChange="return funcAccountsMainTypeChange()">
                        <option value="">Select Main Type</option>
                        <?php
                        $query5 = "select * from master_accountsmain where recordstatus = '' order by id";
                        $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while ($res5 = mysqli_fetch_array($exec5)) {
                            $res5accountsmainanum = $res5["auto_number"];
                            $res5accountsmain = $res5["accountsmain"];
                            ?>
                            <option value="<?php echo $res5accountsmainanum; ?>"><?php echo htmlspecialchars($res5accountsmain); ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    
                    <select name="accountssub1" id="accountssub1" class="search-select">
                        <option value="">Select Sub Type</option>
                    </select>
                    
                    <button type="button" id="accountsearchbutton" name="accountsearchbutton" class="search-button" onClick="return funcaccountsearch();">
                        <i class="fas fa-search"></i> Search
                    </button>
                    
                    <button type="button" class="export-button" onClick="return xcelcreation()">
                        <i class="fas fa-file-excel"></i>
                    </button>
                </div>
            </div>

            <table class="data-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Accounts Main</th>
                        <th>Code</th>
                        <th>Accounts Sub</th>
                        <th>ID</th>
                        <th>Account Name</th>
                        <th>Main Type</th>
                        <th>Sub Type</th>
                        <th>Cost Center</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody id='insertchartofaccounts'>
                    <!-- Search results will be inserted here via AJAX -->
                </tbody>
            </table>
        </div>

        <!-- Deleted Accounts -->
        <div class="form-section">
            <div class="form-section-header">
                <i class="fas fa-trash form-section-icon"></i>
                <h3 class="form-section-title">Deleted Accounts</h3>
            </div>
            
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Main Type</th>
                        <th>Account Name</th>
                        <th>Sub Type</th>
                        <th>Expiry Date</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query1 = "select * from master_accountname where recordstatus = 'deleted' order by paymenttype ";
                    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while ($res1 = mysqli_fetch_array($exec1)) {
                        $accountname = $res1["accountname"];
                        $auto_number = $res1["auto_number"];
                        $paymenttypeanum = $res1['paymenttype'];
                        $subtypeanum = $res1['subtype'];
                        $expirydate = $res1['expirydate'];
                        
                        $query2 = "select * from master_paymenttype where auto_number = '$paymenttypeanum'";
                        $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $res2 = mysqli_fetch_array($exec2);
                        $paymenttype = $res2['paymenttype'];
                        
                        $query3 = "select * from master_subtype where auto_number = '$subtypeanum'";
                        $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $res3 = mysqli_fetch_array($exec3);
                        $subtype = $res3['subtype'];
                        
                        $colorloopcount = $colorloopcount + 1;
                        $showcolor = ($colorloopcount & 1); 
                        $rowclass = ($showcolor == 0) ? 'even-row' : 'odd-row';
                    ?>
                    <tr class="<?php echo $rowclass; ?>">
                        <td class="modern-cell">
                            <a href="addaccountname1.php?st=activate&anum=<?php echo $auto_number; ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-check"></i> Activate
                            </a>
                        </td>
                        <td class="modern-cell"><?php echo htmlspecialchars($paymenttype); ?></td>
                        <td class="modern-cell"><?php echo htmlspecialchars($accountname); ?></td>
                        <td class="modern-cell"><?php echo htmlspecialchars($subtype); ?></td>
                        <td class="modern-cell"><?php echo $expirydate; ?></td>
                        <td class="modern-cell">
                            <a href="editaccountname1.php?st=edit&anum=<?php echo $auto_number; ?>" class="btn btn-outline btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/addaccountname1-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- PHP Generated JavaScript Functions -->
    <script language="javascript">
    function funcPaymentTypeChange1() {
        <?php 
        $query12 = "select * from master_paymenttype where recordstatus = ''";
        $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
        while ($res12 = mysqli_fetch_array($exec12)) {
            $res12paymenttypeanum = $res12["auto_number"];
            $res12paymenttype = $res12["paymenttype"];
            ?>
            if(document.getElementById("paymenttype").value=="<?php echo $res12paymenttypeanum; ?>") {
                document.getElementById("subtype").options.length=null; 
                var combo = document.getElementById('subtype'); 	
                <?php 
                $loopcount=0;
                ?>
                combo.options[<?php echo $loopcount;?>] = new Option ("Select Sub Type", ""); 
                <?php
                $query10 = "select * from master_subtype where maintype = '$res12paymenttypeanum' and recordstatus = ''";
                $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
                while ($res10 = mysqli_fetch_array($exec10)) {
                    $loopcount = $loopcount+1;
                    $res10subtypeanum = $res10['auto_number'];
                    $res10subtype = $res10["subtype"];
                    ?>
                    combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10subtype;?>", "<?php echo $res10subtypeanum;?>"); 
                    <?php 
                }
                ?>
            }
            <?php
        }
        ?>	
    }
    
    function funcAccountsMainTypeChange1() {
        <?php 
        $query12 = "select * from master_accountsmain where recordstatus = ''";
        $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
        while ($res12 = mysqli_fetch_array($exec12)) {
            $res12accountsmainanum = $res12["auto_number"];
            $res12accountsmain = $res12["accountsmain"];
            ?>
            if(document.getElementById("accountsmaintype").value=="<?php echo $res12accountsmainanum; ?>") {
                document.getElementById("accountssub").options.length=null; 
                var combo = document.getElementById('accountssub'); 	
                <?php 
                $loopcount=0;
                ?>
                combo.options[<?php echo $loopcount;?>] = new Option ("Select Sub Type", ""); 
                <?php
                $query10 = "select * from master_accountssub where accountsmain = '$res12accountsmainanum' and recordstatus = ''";
                $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
                while ($res10 = mysqli_fetch_array($exec10)) {
                    $loopcount = $loopcount+1;
                    $res10accountssubanum = $res10['auto_number'];
                    $res10accountssub = $res10["accountssub"];
                    ?>
                    combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10accountssub;?>", "<?php echo $res10accountssubanum;?>"); 
                    <?php 
                }
                ?>
            }
            <?php
        }
        ?>	
        
        if(document.getElementById("accountsmaintype").value == 6) {
            $('#non_multicc').hide();
            $('#multicc').show();
        } else {
            $('#non_multicc').show();
            $('#multicc').hide();
        }
    }
    
    function funcAccountsMainTypeChange() {
        <?php 
        $query12 = "select * from master_accountsmain where recordstatus = ''";
        $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
        while ($res12 = mysqli_fetch_array($exec12)) {
            $res12accountsmainanum = $res12["auto_number"];
            $res12accountsmain = $res12["accountsmain"];
            ?>
            if(document.getElementById("accountsmaintype1").value=="<?php echo $res12accountsmainanum; ?>") {
                document.getElementById("accountssub1").options.length=null; 
                var combo = document.getElementById('accountssub1'); 	
                <?php 
                $loopcount=0;
                ?>
                combo.options[<?php echo $loopcount;?>] = new Option ("Select Sub Type", ""); 
                <?php
                $query10 = "select * from master_accountssub where accountsmain = '$res12accountsmainanum' and recordstatus = ''";
                $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
                while ($res10 = mysqli_fetch_array($exec10)) {
                    $loopcount = $loopcount+1;
                    $res10accountssubanum = $res10['auto_number'];
                    $res10accountssub = $res10["accountssub"];
                    ?>
                    combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10accountssub;?>", "<?php echo $res10accountssubanum;?>"); 
                    <?php 
                }
                ?>
            }
            <?php
        }
        ?>	
    }
    
    function SelCurrency(val) {
        var val = val;
        <?php 
        $query1sub = "select * from master_subtype where recordstatus = ''";
        $exec1sub = mysqli_query($GLOBALS["___mysqli_ston"], $query1sub) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
        while ($res1sub = mysqli_fetch_array($exec1sub)) {
            $res1subanum = $res1sub["auto_number"];
            $res1subcurrency = $res1sub["currency"];
            $res1subfxrate = $res1sub["fxrate"];
            ?>
            if(val =="<?php echo $res1subanum; ?>") {
                document.getElementById("currency").value = "<?php echo $res1subcurrency; ?>";
                document.getElementById("fxrate").value = "<?php echo $res1subfxrate; ?>";
            }
            <?php
        }
        ?>
    }
    </script>
    
    <!-- Autocomplete Scripts -->
    <script type="text/javascript">
    $(document).ready(function(e) {
        $('#capitationservice').autocomplete({
            source:"autosearchservices.php",
            matchContains: true,
            minLength:1,
            html: true, 
            select: function(event,ui){
                var itemname=ui.item.itemname;
                var itemcode=ui.item.itemcode;
                $("#capitationservicecode").val(itemcode);
                $("#capitationservicename").val(itemname);
            },
        });	
    });

    $(function() {
        $('#accountsearch').autocomplete({
            source:'ajaxaccountnamesearch.php', 
            minLength:2,
            delay: 0,
            html: true, 
            select: function(event,ui){
                var saccountid=ui.item.saccountid;
                $('#hiddenaccountsearch').val(saccountid);	
            }
        });
    });
    </script>
</body>
</html>