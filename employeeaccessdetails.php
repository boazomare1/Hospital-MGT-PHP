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

$pagename = '';

// Handle URL parameters
if (isset($_REQUEST["st"])) { 
    $st = $_REQUEST["st"]; 
} else { 
    $st = ""; 
}

if ($st == 'success') {
    $errmsg = "Success. Employee Updated.";
    $bgcolorcode = 'success';
} else if ($st == 'failed') {
    $errmsg = "Failed. Employee Already Exists.";
    $bgcolorcode = 'failed';
}

if (isset($_REQUEST["frmflag"])) {   
    $frmflag1 = $_REQUEST["frmflag"]; 
} else { 
    $frmflag1 = "55"; 
}

if (isset($_REQUEST["searchsuppliername"])) {  
    $searchsuppliername = $_REQUEST["searchsuppliername"]; 
} else { 
    $searchsuppliername = ""; 
}

if (isset($_REQUEST["searchdescription"])) {   
    $searchdescription = $_REQUEST["searchdescription"]; 
} else { 
    $searchdescription = ""; 
}

if (isset($_REQUEST["searchemployeecode"])) {  
    $searchemployeecode = $_REQUEST["searchemployeecode"]; 
} else { 
    $searchemployeecode = ""; 
}

if (isset($_REQUEST["searchemployeecode"])) { 
    $selectemployeecode = $_REQUEST["searchemployeecode"]; 
} else { 
    $selectemployeecode = ""; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Access Details - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- jQuery UI for autocomplete -->
    <script src="js/jquery-ui.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/employee-access-modern.css?v=<?php echo time(); ?>">
    
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
        <span>Employee Access Details</span>
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
                        <a href="editemployee_type.php" class="nav-link">
                            <i class="fas fa-user-edit"></i>
                            <span>Edit Employee Type</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="employeeaccessdetails.php" class="nav-link">
                            <i class="fas fa-user-shield"></i>
                            <span>Employee Access Details</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="user_rights.php" class="nav-link">
                            <i class="fas fa-key"></i>
                            <span>User Rights</span>
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
                    <h2>Employee Access Details</h2>
                    <p>View and manage employee access permissions and role assignments.</p>
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
            
            <!-- Employee Search Section -->
            <div class="search-section">
                <div class="search-header">
                    <i class="fas fa-search search-icon"></i>
                    <h3 class="search-title">Search Employee</h3>
                </div>
                
                <form name="selectemployee" id="selectemployee" method="post" action="employeeaccessdetails.php" onSubmit="return funcEmployeeSelect1()" class="search-form">
                    <div class="form-group">
                        <label for="searchsuppliername" class="form-label">Employee Name</label>
                        <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo htmlspecialchars($searchsuppliername); ?>" class="form-input" placeholder="Type employee name to search..." autocomplete="off">
                        <input name="searchdescription" id="searchdescription" type="hidden" value="">
                        <input name="searchemployeecode" id="searchemployeecode" type="hidden" value="">
                        <input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">
                        <input name="frmflag" id="frmflag" type="hidden" value="frmflag">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                            Search
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="clearSearch()">
                            <i class="fas fa-times"></i>
                            Clear
                        </button>
                    </div>
                </form>
            </div>
            
            <?php if($frmflag1 == 'frmflag'): ?>
            <!-- Employee Access Details Table -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-table data-table-icon"></i>
                    <h3 class="data-table-title">Employee Access Details</h3>
                    <div class="data-table-actions">
                        <a href="print_employeeaccessdetails.php?searchemployeecode=<?php echo htmlspecialchars($searchemployeecode); ?>" class="btn btn-outline btn-sm" target="_blank">
                            <i class="fas fa-file-excel"></i>
                            Export to Excel
                        </a>
                    </div>
                </div>
                
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Employee No.</th>
                                <th>Employee Name</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $selec = '';
                            $colorloopcount = 0;
                            
                            if($searchemployeecode != '') {
                                $query02 = "select * from master_employee where employeecode='$searchemployeecode' and status='Active'";
                            } else {
                                $query02 = "select * from master_employee where employeecode<>'' and employeename <>'' and status='Active'";
                            }
                            
                            $exe02 = mysqli_query($GLOBALS["___mysqli_ston"], $query02);
                            while($res02 = mysqli_fetch_array($exe02)) {
                                $employeename = $res02['employeename'];
                                $employeecode = $res02['employeecode'];
                                $role_id = $res02["role_id"];
                                
                                $qryemdetails1 = "SELECT role_name FROM master_role WHERE role_id='$role_id'";
                                $execempdetails1 = mysqli_query($GLOBALS["___mysqli_ston"], $qryemdetails1) or die ("Error in qryemdetails1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $resempdetails1 = mysqli_fetch_assoc($execempdetails1);
                                $role_name = $resempdetails1["role_name"];
                                
                                $colorloopcount = $colorloopcount + 1;
                                ?>
                                <tr>
                                    <td>
                                        <span class="sno-badge"><?php echo $colorloopcount; ?></span>
                                    </td>
                                    <td>
                                        <span class="employee-code-badge"><?php echo htmlspecialchars($employeecode); ?></span>
                                    </td>
                                    <td>
                                        <div class="employee-info">
                                            <span class="employee-name"><?php echo htmlspecialchars($employeename); ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="role-badge role-<?php echo strtolower(str_replace(' ', '-', $role_name)); ?>">
                                            <?php echo htmlspecialchars($role_name); ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    
                    <?php if($colorloopcount == 0): ?>
                    <div class="no-data">
                        <i class="fas fa-users"></i>
                        <h3>No Employees Found</h3>
                        <p>No employees match your search criteria.</p>
                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- Table Summary -->
                <div class="table-summary">
                    <div class="summary-item">
                        <i class="fas fa-users"></i>
                        <span>Total Employees: <strong><?php echo $colorloopcount; ?></strong></span>
                    </div>
                    <?php if($searchemployeecode != ''): ?>
                    <div class="summary-item">
                        <i class="fas fa-search"></i>
                        <span>Filtered by: <strong><?php echo htmlspecialchars($searchsuppliername); ?></strong></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>
    
    <!-- Modern JavaScript -->
    <script src="js/employee-access-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Autocomplete functionality -->
    <script>
    $(function() {
        $('#searchsuppliername').autocomplete({
            source: 'ajaxemployeenewsearch.php',
            minLength: 3,
            delay: 0,
            html: true,
            select: function(event, ui) {
                var code = ui.item.id;
                var employeecode = ui.item.employeecode;
                var employeename = ui.item.employeename;
                $('#searchemployeecode').val(employeecode);
                $('#searchsuppliername').val(employeename);
            }
        });
    });
    </script>
</body>
</html>
