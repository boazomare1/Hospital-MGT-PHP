<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$companycode = $_SESSION["companycode"];
$docno = $_SESSION['docno'];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$designation1 = '';

// Handle form submission
if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1') {
    $designation = $_REQUEST["designation"];
    $designation = strtoupper($designation);
    $length = strlen($designation);
    
    if ($length <= 100) {
        $query2 = "select * from master_employeedesignation where designation = '$designation'";
        $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res2 = mysqli_num_rows($exec2);
        
        if ($res2 == 0) {
            $query1 = "insert into master_employeedesignation (designation, ipaddress, updatedatetime, username) 
            values ('$designation', '$ipaddress', '$updatedatetime', '$username')";
            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
            
            $errmsg = "Success. New Designation Added.";
            $bgcolorcode = 'success';
        } else {
            $errmsg = "Failed. Designation Already Exists.";
            $bgcolorcode = 'failed';
        }
    } else {
        $errmsg = "Failed. Only 100 Characters Are Allowed.";
        $bgcolorcode = 'failed';
    }
}

// Handle delete action
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del') {
    $delanum = $_REQUEST["anum"];
    $query3 = "update master_employeedesignation set status = 'deleted' where auto_number = '$delanum'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
    header("location:addemployeedesignation.php");
}

// Handle activate action
if ($st == 'activate') {
    $delanum = $_REQUEST["anum"];
    $query3 = "update master_employeedesignation set status = '' where auto_number = '$delanum'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
    header("location:addemployeedesignation.php");
}

// Handle edit action
if($st == 'edit') {
    $editanum = $_REQUEST['anum'];
    $query3 = "select * from master_employeedesignation where auto_number = '$editanum'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res3 = mysqli_fetch_array($exec3);
    $designation1 = $res3['designation'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Designation Master - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/employee-designation-modern.css?v=<?php echo time(); ?>">
    
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
        <a href="employee_master.php">Employee Master</a>
        <span>→</span>
        <span>Employee Designation Master</span>
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
                        <a href="employee_master.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Employee Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addemployeeinfo.php" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>Add Employee</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addemployeecategory.php" class="nav-link">
                            <i class="fas fa-tags"></i>
                            <span>Employee Categories</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="addemployeedesignation.php" class="nav-link">
                            <i class="fas fa-id-badge"></i>
                            <span>Employee Designations</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="editemployee_type.php" class="nav-link">
                            <i class="fas fa-user-edit"></i>
                            <span>Edit Employee Type</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="employeeaccessdetails.php" class="nav-link">
                            <i class="fas fa-user-shield"></i>
                            <span>Employee Access Details</span>
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
                    <h2>Employee Designation Master</h2>
                    <p>Manage employee designations for organizational hierarchy and job titles.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportDesignations()">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>
            </div>
            
            <!-- Add New Designation Section -->
            <div class="form-section">
                <div class="section-header">
                    <i class="fas fa-plus-circle"></i>
                    <h3>Add New Designation</h3>
                </div>
                
                <form name="form1" id="form1" method="post" action="addemployeedesignation.php" onSubmit="return Process1()" class="designation-form">
                    <div class="form-group">
                        <label for="designation" class="form-label required">Designation Name</label>
                        <input type="text" name="designation" id="designation" value="<?php echo htmlspecialchars($designation1); ?>" class="form-input" placeholder="Enter designation name..." maxlength="100" required>
                        <small class="form-help">Maximum 100 characters allowed</small>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="frmflag" value="addnew">
                        <input type="hidden" name="frmflag1" value="frmflag1">
                        
                        <button type="submit" name="Submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            Add Designation
                        </button>
                        
                        <button type="reset" class="btn btn-secondary" onclick="clearForm()">
                            <i class="fas fa-undo"></i>
                            Clear
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Active Designations Section -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-list data-table-icon"></i>
                    <h3 class="data-table-title">Active Designations</h3>
                    <div class="data-table-actions">
                        <button type="button" class="btn btn-outline btn-sm" onclick="toggleSearch()">
                            <i class="fas fa-search"></i>
                            Search
                        </button>
                    </div>
                </div>
                
                <div class="search-container" id="searchContainer" style="display: none;">
                    <div class="search-box">
                        <input type="text" id="searchInput" placeholder="Search designations..." class="form-input">
                        <button type="button" class="search-btn" onclick="clearSearch()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                
                <div class="table-container">
                    <table class="data-table" id="designationsTable">
                        <thead>
                            <tr>
                                <th>Actions</th>
                                <th>Designation Name</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query1 = "select * from master_employeedesignation where status <> 'deleted' order by designation";
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $colorloopcount = 0;
                            
                            while ($res1 = mysqli_fetch_array($exec1)) {
                                $designation = $res1["designation"];
                                $auto_number = $res1["auto_number"];
                                
                                $colorloopcount = $colorloopcount + 1;
                                ?>
                                <tr>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="addemployeedesignation.php?st=del&&anum=<?php echo $auto_number; ?>" 
                                               onClick="return funcDeleteDesignation()" 
                                               class="btn-action btn-delete" 
                                               title="Delete Designation">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="designation-info">
                                            <span class="designation-name"><?php echo htmlspecialchars($designation); ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="editemployeedesignation.php?st=edit&&anum=<?php echo $auto_number; ?>" 
                                           class="btn-action btn-edit" 
                                           title="Edit Designation">
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                            
                            if ($colorloopcount == 0):
                            ?>
                            <tr>
                                <td colspan="3" class="no-data">
                                    <i class="fas fa-inbox"></i>
                                    <h3>No Designations Found</h3>
                                    <p>No active designations available. Add a new designation to get started.</p>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Table Summary -->
                <div class="table-summary">
                    <div class="summary-item">
                        <i class="fas fa-list"></i>
                        <span>Active Designations: <strong><?php echo $colorloopcount; ?></strong></span>
                    </div>
                </div>
            </div>
            
            <!-- Deleted Designations Section -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-trash data-table-icon"></i>
                    <h3 class="data-table-title">Deleted Designations</h3>
                    <div class="data-table-actions">
                        <span class="deleted-count"><?php 
                            $deletedQuery = "select count(*) as count from master_employeedesignation where status = 'deleted'";
                            $deletedExec = mysqli_query($GLOBALS["___mysqli_ston"], $deletedQuery);
                            $deletedCount = mysqli_fetch_array($deletedExec)['count'];
                            echo $deletedCount;
                        ?> deleted</span>
                    </div>
                </div>
                
                <div class="table-container">
                    <table class="data-table" id="deletedTable">
                        <thead>
                            <tr>
                                <th>Actions</th>
                                <th>Designation Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query1 = "select * from master_employeedesignation where status = 'deleted' order by designation";
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $deletedCount = 0;
                            
                            while ($res1 = mysqli_fetch_array($exec1)) {
                                $designation = $res1['designation'];
                                $auto_number = $res1["auto_number"];
                                $deletedCount++;
                                ?>
                                <tr class="deleted-row">
                                    <td>
                                        <div class="action-buttons">
                                            <a href="addemployeedesignation.php?st=activate&&anum=<?php echo $auto_number; ?>" 
                                               class="btn-action btn-activate" 
                                               title="Activate Designation">
                                                <i class="fas fa-undo"></i>
                                                Activate
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="designation-info">
                                            <span class="designation-name deleted"><?php echo htmlspecialchars($designation); ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge status-deleted">Deleted</span>
                                    </td>
                                </tr>
                                <?php
                            }
                            
                            if ($deletedCount == 0):
                            ?>
                            <tr>
                                <td colspan="3" class="no-data">
                                    <i class="fas fa-check-circle"></i>
                                    <h3>No Deleted Designations</h3>
                                    <p>All designations are currently active.</p>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    
    <!-- Modern JavaScript -->
    <script src="js/employee-designation-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
