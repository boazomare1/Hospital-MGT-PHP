<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$tdno = 0;
$colorloopcount = "";

// Get employee details
$qryempcode1 = "SELECT employeename,employeecode FROM master_employee WHERE username= '$username'";
$execempcode1 = mysqli_query($GLOBALS["___mysqli_ston"], $qryempcode1) or die ("Error in qryempcode1".mysqli_error($GLOBALS["___mysqli_ston"]));
$resempcode1 = mysqli_fetch_array($execempcode1);

$searchsuppliername = $resempcode1["employeename"];
$searchemployeecode = $resempcode1["employeecode"];

// Handle form submissions
if (isset($_REQUEST["frmflag112"])) { 
    $frmflag112 = $_REQUEST["frmflag112"]; 
} else { 
    $frmflag112 = ""; 
}

if (isset($_REQUEST["frmflag1"])) { 
    $frmflag1 = $_REQUEST["frmflag1"]; 
} else { 
    $frmflag1 = ""; 
}

if (isset($_REQUEST["searchdescription"])) {   
    $searchdescription = $_REQUEST["searchdescription"]; 
} else { 
    $searchdescription = ""; 
}

if (isset($_REQUEST["radio_emp"])) { 
    $allemployees = $_REQUEST["radio_emp"];
} else {
    $allemployees = "";
}

// Handle favorite updates
if ($frmflag112 == 'frmflag112') {
    $searchemployeecode = $_REQUEST['searchemployeecode'];	
    
    // Reset all favorites for this employee
    $query = "UPDATE master_employeerights SET is_fav='0' WHERE employeecode='$searchemployeecode'";
    $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));

    // Set selected items as favorites
    if (isset($_POST['menuid']) && isset($_POST['is_fav'])) {
        foreach($_POST['menuid'] as $key=>$value) {
            $menuid = $_POST['menuid'][$key];
            foreach($_POST['is_fav'] as $check => $value) {
                $is_fav = $_POST['is_fav'][$check];
                if($menuid == $is_fav) {
                    $queryupdatecumstock2 = "UPDATE master_employeerights SET is_fav='1' WHERE submenuid='$menuid' AND employeecode='$searchemployeecode'";
                    $execupdatecumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatecumstock2) or die ("Error in updateCumQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
                }
            }
        }
    }
    
    $errmsg = "Employee favorites updated successfully.";
    $bgcolorcode = 'success';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Favorites - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/employeefavorites-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Autocomplete CSS -->
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <!-- Autocomplete JS -->
    <script type="text/javascript" src="js/autocomplete_jobdescription2.js"></script>
    <script type="text/javascript" src="js/autosuggestjobdescription1.js"></script>
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
        <span>Employee Favorites</span>
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
                    <li class="nav-item active">
                        <a href="employeefavorites.php" class="nav-link">
                            <i class="fas fa-star"></i>
                            <span>Employee Favorites</span>
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
                    <h2>Employee Favorites Management</h2>
                    <p>Manage employee menu favorites and access permissions for different users.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <a href="employeeaccessinfo_xl.php?cbfrmflag1=cbfrmflag1&&searchemployeecode=<?php echo $searchemployeecode; ?>" class="btn btn-outline">
                        <i class="fas fa-download"></i> Export Excel
                    </a>
                </div>
            </div>

            <!-- Employee Search Form -->
            <div class="search-form-section">
                <div class="search-form-header">
                    <i class="fas fa-search search-form-icon"></i>
                    <h3 class="search-form-title">Employee Search</h3>
                </div>
                
                <form name="form1" method="post" action="employeefavorites.php" class="search-form">
                    <div class="form-group">
                        <label for="searchsuppliername" class="form-label">Employee Name</label>
                        <input type="text" name="searchsuppliername" id="searchsuppliername" 
                               class="form-input" value="<?php echo htmlspecialchars($searchsuppliername); ?>" 
                               readonly placeholder="Current Employee">
                        <input type="hidden" name="searchemployeecode" id="searchemployeecode" value="<?php echo $searchemployeecode; ?>">
                        <input type="hidden" name="searchdescription" id="searchdescription">
                        <input type="hidden" name="frmflag1" value="frmflag1">
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search Employee
                        </button>
                    </div>
                </form>
            </div>

            <!-- Employee Data Table -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-users data-table-icon"></i>
                    <h3 class="data-table-title">Employee Access Report</h3>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee Name</th>
                            <th>Designation</th>
                            <th>Username</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sno = 0;
                        $qryempcode = "SELECT employeecode FROM master_employeerights WHERE employeecode<>'' and employeecode = '$searchemployeecode' GROUP BY employeecode";
                        $execempcode = mysqli_query($GLOBALS["___mysqli_ston"], $qryempcode) or die ("Error in qryempcode".mysqli_error($GLOBALS["___mysqli_ston"]));

                        while($resempcode = mysqli_fetch_array($execempcode)) {
                            $empcode = $resempcode["employeecode"];
                            
                            // Get employee details
                            $qryemdetails = "SELECT employeename,jobdescription,username FROM master_employee WHERE employeecode='$empcode'";
                            $execempdetails = mysqli_query($GLOBALS["___mysqli_ston"], $qryemdetails) or die ("Error in qryemdetails".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $resempdetails = mysqli_fetch_assoc($execempdetails);

                            $empname = $resempdetails["employeename"];
                            $designation = $resempdetails["jobdescription"];
                            $username = $resempdetails["username"];

                            if($empname == "") {
                                $empname = "Unknown";
                            }

                            $colorloopcount = $colorloopcount + 1;
                            $sno++;
                            ?>
                            <tr>
                                <td><?php echo $sno; ?></td>
                                <td>
                                    <div class="employee-info">
                                        <span class="employee-name"><?php echo htmlspecialchars($empname); ?></span>
                                    </div>
                                </td>
                                <td>
                                    <span class="designation-badge"><?php echo htmlspecialchars(strtoupper($designation)); ?></span>
                                </td>
                                <td><?php echo htmlspecialchars($username); ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn expand" onclick="toggleEmployeeDetails(<?php echo $sno; ?>)">
                                            <i class="fas fa-chevron-down"></i> Show Details
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Employee Details Row -->
                            <tr id="employeeDetails<?php echo $sno; ?>" class="employee-details-row" style="display: none;">
                                <td colspan="5">
                                    <div class="employee-details-content">
                                        <div class="menu-permissions-section">
                                            <h4>Menu Permissions & Favorites</h4>
                                            
                                            <form method="post" action="employeefavorites.php" class="favorites-form">
                                                <input type="hidden" name="frmflag112" value="frmflag112">
                                                <input type="hidden" name="searchemployeecode" value="<?php echo $empcode; ?>">
                                                
                                                <div class="permissions-grid">
                                                    <?php
                                                    // Get sub menus which are in access
                                                    $qrysubmenucode = "SELECT submenuid,is_fav FROM master_employeerights WHERE employeecode='$empcode' AND submenuid<>'' ORDER BY submenuid"; 
                                                    $execsubmenucode = mysqli_query($GLOBALS["___mysqli_ston"], $qrysubmenucode) or die ("Error in qrysubmenucode".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                    $colorloopcount1 = 0;

                                                    while($ressubmenuname = mysqli_fetch_array($execsubmenucode)) {
                                                        $submenucode = $ressubmenuname["submenuid"];
                                                        $is_fav = $ressubmenuname["is_fav"];
                                                        
                                                        // Get submenu name
                                                        $qrysubmenuname = "SELECT submenutext FROM master_menusub WHERE submenuid='$submenucode' AND status<>'deleted'";
                                                        $execsubmenuname = mysqli_query($GLOBALS["___mysqli_ston"], $qrysubmenuname) or die ("Error in qrysubmenuname".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                        $ressubmenuname = mysqli_fetch_assoc($execsubmenuname);
                                                        $submenuname = $ressubmenuname["submenutext"];
                                                        
                                                        $colorloopcount1++;
                                                        ?>
                                                        <div class="permission-item">
                                                            <div class="permission-name">
                                                                <input type="hidden" name="menuid[]" value="<?php echo $submenucode; ?>">
                                                                <span><?php echo htmlspecialchars($submenuname); ?></span>
                                                            </div>
                                                            <div class="permission-favorite">
                                                                <label class="favorite-checkbox">
                                                                    <input type="checkbox" name="is_fav[]" value="<?php echo $submenucode; ?>" 
                                                                           <?php if($is_fav == '1') echo "checked"; ?>>
                                                                    <span class="checkmark"></span>
                                                                    <span class="favorite-label">Favorite</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                
                                                <div class="favorites-form-actions">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-save"></i> Update Favorites
                                                    </button>
                                                    <button type="button" class="btn btn-secondary" onclick="toggleEmployeeDetails(<?php echo $sno; ?>)">
                                                        <i class="fas fa-times"></i> Cancel
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
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
    <script src="js/employeefavorites-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>

