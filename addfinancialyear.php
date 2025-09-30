<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

$totaldays1 = '';
$proratatotaldays1 = '';
$ADate1 = '';
$ADate2 = '';
$comments1 = '';

// Handle form submission
if (isset($_POST["frmflag1"])) { 
    $frmflag1 = $_POST["frmflag1"]; 
} else { 
    $frmflag1 = ""; 
}

if ($frmflag1 == 'frmflag1') {
    $fromyear = $_REQUEST['fromyear'];
    $toyear = $_REQUEST['toyear'];
    $comments = $_REQUEST['comments'];

    // Deactivate all existing financial years
    $query2 = mysqli_query($GLOBALS["___mysqli_ston"], "update master_financialyear set status = 'Inactive'") or die ("Error in Query2" . mysqli_error($GLOBALS["___mysqli_ston"]));

    // Insert new financial year
    $query1 = "insert into master_financialyear (fromyear, toyear, comments, ipaddress, updatedatetime, username, status) values ('$fromyear', '$toyear', '$comments', '$ipaddress', '$updatedatetime', '$username', 'Active')";
    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));

    $errmsg = "Success. Added Successfully.";
    $bgcolorcode = 'success';
    
    header("location:addfinancialyear.php?st=success");
}

// Handle URL status messages
if (isset($_REQUEST["st"])) { 
    $st = $_REQUEST["st"]; 
} else { 
    $st = ""; 
}

if ($st == 'success') {
    $errmsg = "Success. Financial Year Added Successfully.";
    $bgcolorcode = 'success';
} else if ($st == 'failed') {
    $errmsg = "Failed. Please try again.";
    $bgcolorcode = 'failed';
}

// Handle edit mode
if ($st == 'edit') {
    $editanum = $_REQUEST["anum"];
    $query3 = "select * from master_financialyear where auto_number = '$editanum'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $res3 = mysqli_fetch_array($exec3);
    
    $ADate1 = $res3['fromyear'];
    $ADate2 = $res3['toyear'];
    $comments1 = $res3['comments'];
}

// Get current active financial year
$query31 = "select * from master_financialyear where status = 'Active' order by auto_number desc";
$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31" . mysqli_error($GLOBALS["___mysqli_ston"]));
$res31 = mysqli_fetch_array($exec31);

$ADate11 = $res31['fromyear'];
$ADate21 = $res31['toyear'];
$auto_number = $res31['auto_number'];
$status = $res31['status'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Year Master - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/financial-year-modern.css?v=<?php echo time(); ?>">
    
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
        <span>Financial Year Master</span>
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
                    <li class="nav-item active">
                        <a href="addfinancialyear.php" class="nav-link">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Financial Year Master</span>
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
                    <h2>Financial Year Master</h2>
                    <p>Configure and manage financial year periods for accounting and reporting purposes.</p>
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

            <!-- Add Financial Year Form Section -->
            <div class="add-form-section">
                <div class="add-form-header">
                    <i class="fas fa-plus-circle add-form-icon"></i>
                    <h3 class="add-form-title">Add New Financial Year</h3>
                </div>
                
                <form name="form1" id="form1" method="post" action="addfinancialyear.php" class="add-form" onSubmit="return addward1process1()">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="fromyear" class="form-label">
                                <i class="fas fa-calendar-check"></i>
                                From Year
                            </label>
                            <div class="date-input-group">
                                <input type="text" 
                                       name="fromyear" 
                                       id="fromyear" 
                                       class="form-input date-input"
                                       value="<?php echo htmlspecialchars($ADate1); ?>" 
                                       readonly="readonly" 
                                       placeholder="Select start date">
                                <img src="images2/cal.gif" 
                                     onClick="javascript:NewCssCal('fromyear')" 
                                     class="date-picker-icon" 
                                     alt="Select Date">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="toyear" class="form-label">
                                <i class="fas fa-calendar-times"></i>
                                To Year
                            </label>
                            <div class="date-input-group">
                                <input type="text" 
                                       name="toyear" 
                                       id="toyear" 
                                       class="form-input date-input"
                                       value="<?php echo htmlspecialchars($ADate2); ?>" 
                                       readonly="readonly" 
                                       placeholder="Select end date">
                                <img src="images2/cal.gif" 
                                     onClick="javascript:NewCssCal('toyear')" 
                                     class="date-picker-icon" 
                                     alt="Select Date">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="comments" class="form-label">
                            <i class="fas fa-comment-alt"></i>
                            Comments
                        </label>
                        <textarea name="comments" 
                                  id="comments" 
                                  class="form-input textarea-input"
                                  rows="4" 
                                  placeholder="Enter any additional comments about this financial year..."><?php echo htmlspecialchars($comments1); ?></textarea>
                    </div>

                    <div class="form-actions">
                        <input type="hidden" name="frmflag" value="addnew" />
                        <input type="hidden" name="frmflag1" value="frmflag1" />
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="fas fa-save"></i>
                            Save Financial Year
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Current Financial Year Section -->
            <div class="current-year-section">
                <div class="current-year-header">
                    <i class="fas fa-calendar-check current-year-icon"></i>
                    <h3 class="current-year-title">Current Active Financial Year</h3>
                </div>

                <div class="current-year-card">
                    <?php if ($ADate11 && $ADate21): ?>
                        <div class="year-info">
                            <div class="year-period">
                                <span class="year-from">
                                    <i class="fas fa-play"></i>
                                    <?php echo htmlspecialchars($ADate11); ?>
                                </span>
                                <span class="year-separator">to</span>
                                <span class="year-to">
                                    <?php echo htmlspecialchars($ADate21); ?>
                                    <i class="fas fa-stop"></i>
                                </span>
                            </div>
                            <div class="year-status">
                                <span class="status-badge status-active">
                                    <i class="fas fa-check-circle"></i>
                                    <?php echo htmlspecialchars($status); ?>
                                </span>
                            </div>
                        </div>
                        <div class="year-actions">
                            <a href="addfinancialyear.php?st=edit&anum=<?php echo $auto_number; ?>" 
                               class="btn btn-outline btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="no-year-message">
                            <i class="fas fa-calendar-plus"></i>
                            <p>No active financial year found. Please add a new financial year above.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/financial-year-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
