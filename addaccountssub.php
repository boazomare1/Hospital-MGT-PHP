<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

$locationname  = $res["locationname"];
$locationcode = $res["locationcode"];

// Form submission handling
if (isset($_POST["frmflag1"])) { 
    $frmflag1 = $_POST["frmflag1"]; 
} else { 
    $frmflag1 = ""; 
}

if ($frmflag1 == 'frmflag1') {
    $accountsmain = $_REQUEST["accountsmain"];
    $id = $_REQUEST["id"];
    $accountssub = $_REQUEST["accountssub"];
    $shortname = $_REQUEST["shortname"];
    
    // Convert to uppercase and trim
    $id = strtoupper(trim($id));
    $accountssub = strtoupper(trim($accountssub));
    $shortname = strtoupper(trim($shortname));
    
    // Validation
    if (strlen($accountssub) <= 100 && strlen($shortname) <= 50 && strlen($id) <= 50) {
        // Check if sub type already exists
        $query2 = "SELECT * FROM master_accountssub WHERE id = '$id' AND recordstatus <> 'deleted'";
        $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res2 = mysqli_num_rows($exec2);
        
        if ($res2 == 0) {
            // Insert new sub type
            $query1 = "INSERT INTO master_accountssub (accountsmain, id, accountssub, shortname, ipaddress, recorddate, username) 
                       VALUES ('$accountsmain', '$id', '$accountssub', '$shortname', '$ipaddress', '$updatedatetime', '$username')";
            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
            $errmsg = "Success. New account sub type added.";
            $bgcolorcode = 'success';
        } else {
            $errmsg = "Failed. Sub type ID already exists.";
            $bgcolorcode = 'failed';
        }
    } else {
        $errmsg = "Failed. Text length exceeds limits.";
        $bgcolorcode = 'failed';
    }
}

// Delete handling
if (isset($_REQUEST["st"])) { 
    $st = $_REQUEST["st"]; 
} else { 
    $st = ""; 
}

if ($st == 'del') {
    $delanum = $_REQUEST["anum"];
    $query3 = "UPDATE master_accountssub SET recordstatus = 'deleted' WHERE auto_number = '$delanum'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
    $errmsg = "Success. Sub type deleted.";
    $bgcolorcode = 'success';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accounts Sub Type - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/addaccountssub-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            <span class="location-info">📍 Location: <?php echo htmlspecialchars($locationname); ?></span>
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
        <span>Accounts Sub Type</span>
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
                    <li class="nav-item active">
                        <a href="addaccountssub.php" class="nav-link">
                            <i class="fas fa-chart-pie"></i>
                            <span>Accounts Sub Type</span>
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
                    <h2>Accounts Sub Type Management</h2>
                    <p>Add, edit, and manage account sub-categories for financial reporting</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="resetForm()">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                    <button type="button" class="btn btn-primary" onclick="clearForm()">
                        <i class="fas fa-plus"></i> New Sub Type
                    </button>
                </div>
            </div>

            <!-- Success/Error Messages -->
            <?php if (!empty($errmsg)): ?>
                <div class="alert alert-<?php echo $bgcolorcode === 'success' ? 'success' : 'error'; ?> alert-dismissible">
                    <i class="fas fa-<?php echo $bgcolorcode === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                    <?php echo htmlspecialchars($errmsg); ?>
                    <button type="button" class="alert-close" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            <?php endif; ?>

            <!-- Add Account Sub Type Form -->
            <div class="form-section">
                <div class="form-header">
                    <h3><i class="fas fa-plus-circle"></i> Add New Account Sub Type</h3>
                </div>
                
                <form id="addAccountSubForm" method="post" action="addaccountssub.php" class="modern-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="accountsmain" class="form-label">Main Account Type *</label>
                            <select id="accountsmain" name="accountsmain" class="form-select" required>
                                <option value="">-- Select Main Account Type --</option>
                                <!-- Options will be loaded dynamically -->
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="id" class="form-label">Sub Type ID *</label>
                            <input type="text" id="id" name="id" class="form-input" required maxlength="50" placeholder="Enter sub type ID">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="accountssub" class="form-label">Sub Type Name *</label>
                            <input type="text" id="accountssub" name="accountssub" class="form-input" required maxlength="100" placeholder="Enter sub type name">
                        </div>
                        
                        <div class="form-group">
                            <label for="shortname" class="form-label">Short Name *</label>
                            <input type="text" id="shortname" name="shortname" class="form-input" required maxlength="50" placeholder="Enter short name">
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="frmflag1" value="frmflag1">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Sub Type
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Clear
                        </button>
                    </div>
                </form>
            </div>

            <!-- Existing Accounts Sub Types Data -->
            <div class="data-section">
                <div class="section-header">
                    <span class="section-icon">📋</span>
                    <h3 class="section-title">Existing Account Sub Types</h3>
                </div>

                <!-- Search and Filter Bar -->
                <div class="search-filter-bar">
                    <div class="search-section">
                        <input type="text" id="accountSearch" class="search-input" placeholder="Search sub types..." />
                        <button class="btn btn-secondary" id="searchBtn">🔍 Search</button>
                        <button class="btn btn-outline" id="clearSearchBtn">Clear</button>
                    </div>
                    <div class="filter-section">
                        <select id="mainAccountFilter" class="filter-select">
                            <option value="">All Main Account Types</option>
                            <!-- Options will be loaded dynamically -->
                        </select>
                        <select id="statusFilter" class="filter-select">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <!-- Data Table with Pagination -->
                <div class="table-container">
                    <table class="data-table" id="accountsTable">
                        <thead>
                            <tr>
                                <th>Main Type</th>
                                <th>Sub Type ID</th>
                                <th>Sub Type Name</th>
                                <th>Short Name</th>
                                <th>Created By</th>
                                <th>Date</th>
                                <th class="actions-column">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="accountsTableBody">
                            <!-- Data will be loaded here via JavaScript -->
                        </tbody>
                    </table>
                    
                    <!-- Pagination Controls -->
                    <div class="pagination-controls">
                        <div class="pagination-info">
                            <span id="paginationInfo">Showing 0 of 0 items</span>
                        </div>
                        <div class="pagination-buttons">
                            <button id="prevPage" class="btn btn-outline" onclick="previousPage()" disabled>← Previous</button>
                            <div class="page-numbers" id="pageNumbers">
                                <!-- Page numbers will be generated here -->
                            </div>
                            <button id="nextPage" class="btn btn-outline" onclick="nextPage()" disabled>Next →</button>
                        </div>
                        <div class="items-per-page">
                            <label for="itemsPerPage">Items per page:</label>
                            <select id="itemsPerPage" class="items-select">
                                <option value="5">5</option>
                                <option value="10" selected>10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/addaccountssub-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>



