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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Approval List - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/paymentapproval-modern.css?v=<?php echo time(); ?>">
    
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
        <span>Payment Approval List</span>
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
                        <a href="paymentapprovallist1.php" class="nav-link">
                            <i class="fas fa-credit-card"></i>
                            <span>Payment Approval</span>
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
                    <h2>Payment Approval List</h2>
                    <p>Manage and approve supplier payment transactions</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="resetForm()">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                    <button type="button" class="btn btn-primary" onclick="clearForm()">
                        <i class="fas fa-search"></i> New Search
                    </button>
                </div>
            </div>

            <!-- Search Form -->
            <div class="form-section">
                <div class="form-header">
                    <h3><i class="fas fa-search"></i> Search Payment Transactions</h3>
                </div>
                
                <form id="searchForm" class="modern-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="supplierSearch" class="form-label">Supplier Name</label>
                            <input type="text" id="supplierSearch" name="supplierSearch" class="form-input" placeholder="Enter supplier name...">
                        </div>
                        
                        <div class="form-group">
                            <label for="docnoSearch" class="form-label">Document Number</label>
                            <input type="text" id="docnoSearch" name="docnoSearch" class="form-input" placeholder="Enter document number...">
                        </div>
                        
                        <div class="form-group">
                            <label for="dateFrom" class="form-label">Date From</label>
                            <input type="date" id="dateFrom" name="dateFrom" class="form-input" value="<?php echo date('Y-m-d', strtotime('-2 month')); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="dateTo" class="form-label">Date To</label>
                            <input type="date" id="dateTo" name="dateTo" class="form-input" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn btn-primary" onclick="searchPayments()">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="clearForm()">
                            <i class="fas fa-times"></i> Clear
                        </button>
                    </div>
                </form>
            </div>

            <!-- Payment Transactions Data -->
            <div class="data-section">
                <div class="section-header">
                    <span class="section-icon">💳</span>
                    <h3 class="section-title">Payment Transactions</h3>
                </div>

                <!-- Search and Filter Bar -->
                <div class="search-filter-bar">
                    <div class="search-section">
                        <input type="text" id="paymentSearch" class="search-input" placeholder="Search payments..." />
                        <button class="btn btn-secondary" id="searchBtn">🔍 Search</button>
                        <button class="btn btn-outline" id="clearSearchBtn">Clear</button>
                    </div>
                    <div class="filter-section">
                        <select id="modeFilter" class="filter-select">
                            <option value="">All Payment Modes</option>
                            <option value="CHEQUE">Cheque</option>
                            <option value="CASH">Cash</option>
                            <option value="BANK TRANSFER">Bank Transfer</option>
                        </select>
                        <select id="statusFilter" class="filter-select">
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                        </select>
                    </div>
                </div>

                <!-- Data Table with Pagination -->
                <div class="table-container">
                    <table class="data-table" id="paymentsTable">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Date</th>
                                <th>Doc No</th>
                                <th>Mode</th>
                                <th>Instrument Number</th>
                                <th>Supplier Name</th>
                                <th>Bank Code</th>
                                <th>Bank Name</th>
                                <th>Account Number</th>
                                <th>Amount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="paymentsTableBody">
                            <!-- Data will be loaded here via JavaScript -->
                        </tbody>
                    </table>
                    
                    <!-- Pagination Controls -->
                    <div class="pagination-controls">
                        <div class="pagination-info">
                            <span id="paginationInfo">Showing 0 of 0 items</span>
                        </div>
                        <div class="pagination-buttons">
                            <button id="prevPage" class="btn btn-outline" disabled>← Previous</button>
                            <div class="page-numbers" id="pageNumbers">
                                <!-- Page numbers will be generated here -->
                            </div>
                            <button id="nextPage" class="btn btn-outline" disabled>Next →</button>
                        </div>
                        <div class="items-per-page">
                            <label for="itemsPerPage">Items per page:</label>
                            <select id="itemsPerPage" class="items-select">
                                <option value="5">5</option>
                                <option value="10">10</option>
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
    <script src="js/paymentapproval-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>

