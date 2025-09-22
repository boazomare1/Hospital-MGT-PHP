<?php
session_start();

$pagename = '';

//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.

if (!isset($_SESSION['username'])) header ("location:index.php");

include ("db/db_connect.php");
include ("includes/check_user_access.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$sessionusername = $_SESSION["username"];
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$errmsg = '';
$bgcolorcode = '';

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

if (isset($_REQUEST["frmflag1"])) { 
    $frmflag1 = $_REQUEST["frmflag1"]; 
} else { 
    $frmflag1 = ""; 
}

if (isset($_REQUEST["frmflag11"])) { 
    $frmflag11 = $_REQUEST["frmflag11"]; 
} else { 
    $frmflag11 = ""; 
}

$docno = $_SESSION['docno'];

// Get default location
$query = "select * from master_location where status <> 'deleted' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);

$locationname = $res["locationname"];
$locationcode = $res["locationcode"];
$res12locationanum = $res["auto_number"];

$employeeid = isset($_REQUEST['eid']) ? $_REQUEST['eid'] : '';

if ($employeeid != '') {
    $query1 = "select username from master_employee where status = 'Active' AND employeecode = '".$employeeid."'";
    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res1 = mysqli_fetch_array($exec1);
    $employeename = $res1["username"];
}

// Get location for sort by location purpose
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
if($location != '') {
    $locationcode = $location;
}

$loccountloop = isset($_REQUEST['locationcount']) ? $_REQUEST['locationcount'] : '';

// Handle form submission
if ($frmflag1 == 'frmflag1') {
    $employeeidget = isset($_REQUEST['employeeidget']) ? $_REQUEST['employeeidget'] : '';
    $employeenameget = isset($_REQUEST['employeenameget']) ? $_REQUEST['employeenameget'] : '';
    $employeeid = $employeeidget;
    $employeename = $employeenameget;

    // Delete existing employee location records
    $query4 = "DELETE FROM master_employeelocation WHERE employeecode = '".$employeeid."'";
    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

    // Get employee details
    $query5 = "select * from master_employee WHERE employeecode = '".$employeeid."'";
    $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res5 = mysqli_fetch_array($exec5);
    $empusername = $res5['username'];

    $emplocation = $_REQUEST['emplocation'];
    $query51 = "select * from master_location WHERE auto_number = '".$emplocation."'";
    $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res51 = mysqli_fetch_array($exec51);
    $loccode = $res51['locationcode'];
    $locname = $res51['locationname'];

    $storearray = $_REQUEST['store'];
    $storecode = $_REQUEST['storecode'];

    foreach ($storearray as $store) {
        if($store == $storecode) { 
            $default = 'default'; 
        } else { 
            $default = ''; 
        }
        
        $query23 = "INSERT INTO `master_employeelocation`(`employeecode`, `username`, `locationanum`, `locationname`, `locationcode`, `storecode`, `lastupdate`, `lastupdateipaddress`, `lastupdateusername`, `defaultstore`) 
        VALUES ('$employeeid','$empusername','$emplocation','$locname','$loccode','$store','$updatedatetime','$ipaddress','$sessionusername','$default')";
        
        $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
    }

    $errmsg = "Employee location and store assignments updated successfully.";
    $bgcolorcode = 'success';
}

// Get employee location data
$query34 = "select * from master_employeelocation where employeecode = '$searchemployeecode' group by locationanum";
$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die ("Error in Query34".mysqli_error($GLOBALS["___mysqli_ston"]));
$res34 = mysqli_fetch_array($exec34);

$locationanum = $res34['locationanum'];
$locationname = $res34['locationname'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee Location and Store - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/employee-location-modern.css?v=<?php echo time(); ?>">
    
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
        <span>Employee Management</span>
        <span>→</span>
        <span>Edit Employee Location & Store</span>
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
                        <a href="addemployee1.php" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>Add Employee</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="employee_list.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Employee List</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="editemployeelocationandstore.php" class="nav-link">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Employee Location & Store</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="employee_permissions.php" class="nav-link">
                            <i class="fas fa-key"></i>
                            <span>Employee Permissions</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="adddepartment1.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Departments</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addlocation.php" class="nav-link">
                            <i class="fas fa-map"></i>
                            <span>Locations</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addstore.php" class="nav-link">
                            <i class="fas fa-store"></i>
                            <span>Stores</span>
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
                    <h2>Edit Employee Location & Store</h2>
                    <p>Assign locations and stores to employees for proper access control and management.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="viewAllAssignments()">
                        <i class="fas fa-eye"></i> View All
                    </button>
                </div>
            </div>

            <!-- Employee Selection Section -->
            <div class="employee-selection-section">
                <div class="employee-selection-header">
                    <i class="fas fa-user-search employee-selection-icon"></i>
                    <h3 class="employee-selection-title">Select Employee to Edit</h3>
                </div>
                
                <form name="selectemployee" id="selectemployee" class="employee-selection-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="searchsuppliername" class="form-label">Employee Name</label>
                            <input name="searchsuppliername" type="text" id="searchsuppliername" 
                                   class="form-input" value="<?php echo htmlspecialchars($searchsuppliername); ?>" 
                                   placeholder="Type employee name to search..." autocomplete="off">
                            <input name="searchdescription" id="searchdescription" type="hidden" value="">
                            <input name="searchemployeecode" id="searchemployeecode" type="hidden" value="">
                            <input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">
                        </div>
                        <div class="form-group">
                            <button type="button" name="Submit" class="btn btn-primary" onClick="funcEmployeeSelect1(selectemployee)">
                                <i class="fas fa-search"></i> Search Employee
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="frmflag11" value="frmflag11" />
                </form>
            </div>

            <!-- Employee Assignment Section -->
            <?php if($frmflag11 == 'frmflag11' && !empty($employeeid)): ?>
            <div class="employee-assignment-section">
                <div class="employee-assignment-header">
                    <i class="fas fa-map-marker-alt employee-assignment-icon"></i>
                    <h3 class="employee-assignment-title">Assign Location & Stores</h3>
                    <div class="employee-info">
                        <span class="employee-name">👤 <?php echo htmlspecialchars($employeename); ?></span>
                        <span class="employee-code">ID: <?php echo htmlspecialchars($employeeid); ?></span>
                    </div>
                </div>
                
                <form name="form1" id="form1" method="post" action="editemployeelocationandstore.php" 
                      class="employee-assignment-form" onSubmit="return addward1process1()">
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="emplocation" class="form-label">Select Location</label>
                            <select name="emplocation" id="emplocation" class="form-input" onChange="FuncBranch(this.value)">
                                <?php if($locationanum != ''): ?>
                                    <option value="<?php echo $locationanum; ?>"><?php echo $locationname; ?></option>
                                <?php endif; ?>
                                <option value="">Select Location</option>
                                <?php
                                $query1 = "select locationname,locationcode,auto_number from master_location where status <> 'deleted' order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $incr = 0;
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $res1location = $res1["locationname"];
                                    $res1locationanum = $res1["locationcode"];
                                    $res1locationautonum = $res1["auto_number"];
                                    $incr = $incr + 1;
                                    ?>
                                    <option value="<?php echo $res1locationautonum; ?>"><?php echo $res1location; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="stores-section">
                        <div class="stores-header">
                            <h4><i class="fas fa-store"></i> Available Stores</h4>
                            <p>Select stores for this employee and mark one as default</p>
                        </div>
                        
                        <div class="stores-list" id="foo">
                            <?php
                            $sno = 0;
                            $query35 = "select * from master_store where location = '$locationanum'";
                            $exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die ("Error in Query35".mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            while($res35 = mysqli_fetch_array($exec35)) {
                                $store = $res35['store'];
                                $sanum = $res35['auto_number'];
                                $sno = $sno + 1;
                                
                                $query34 = "select * from master_employeelocation where employeecode = '$searchemployeecode' and storecode = '$sanum'";
                                $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die ("Error in Query34".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res34 = mysqli_fetch_array($exec34);
                                
                                $storecode = $res34['storecode'];
                                $default = $res34['defaultstore'];
                                ?>
                                <div class="store-item">
                                    <div class="store-checkbox">
                                        <input type="checkbox" name="store[]" id="store<?php echo $sno; ?>" 
                                               value="<?php echo $sanum; ?>" <?php if($storecode == $sanum) { echo "Checked"; } ?>>
                                        <label for="store<?php echo $sno; ?>">Assign</label>
                                    </div>
                                    <div class="store-radio">
                                        <input type="radio" name="storecode" id="storecode<?php echo $sno; ?>" 
                                               value="<?php echo $sanum; ?>" <?php if($default == 'default') { echo "Checked"; } ?>>
                                        <label for="storecode<?php echo $sno; ?>">Default</label>
                                    </div>
                                    <div class="store-name">
                                        <input type="text" readonly name="storename<?php echo $sno; ?>" 
                                               id="storename<?php echo $sno; ?>" value="<?php echo $store; ?>" 
                                               class="store-name-input">
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="Submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Assignment
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>

                    <input type="hidden" name="locationcount" value="<?php echo $incr; ?>">
                    <input type="hidden" name="employeeidget" value="<?php echo $employeeid; ?>">
                    <input type="hidden" name="employeenameget" value="<?php echo $employeename; ?>">
                    <input type="hidden" name="frmflag" value="addnew" />
                    <input type="hidden" name="frmflag1" value="frmflag1" />
                    <input type="hidden" name="frmflag11" value="" />
                </form>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/employee-location-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy JavaScript for autocomplete -->
    <script src="js/jquery-ui.min.js"></script>
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
            },
        });
    });
    </script>
</body>
</html>
