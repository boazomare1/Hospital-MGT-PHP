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

// Handle form submission
if (isset($_REQUEST["frmflag1"])) { 
    $frmflag1 = $_REQUEST["frmflag1"]; 
} else { 
    $frmflag1 = ""; 
}

if ($frmflag1 == 'frmflag1') {
    foreach($_REQUEST['employeecode'] as $key => $employeecode) {
        $employeecode = $_REQUEST['employeecode'][$key];
        $employeename = $_REQUEST['employeename'][$key];
        $employeename = strtoupper($employeename);
        $employeename = trim($employeename);
        $reports_daterange_option = $_REQUEST['reports_daterange_option'];
        $option_edit_delete = $_REQUEST['option_edit_delete'];
        $shift = $_REQUEST["shift"];
        
        $query2 = "select * from master_employee where employeecode = '$employeecode'";
        $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res2 = mysqli_num_rows($exec2);
        
        if ($res2 != 0) {
            $res2 = mysqli_fetch_array($exec2);
            $username1 = $res2['username'];
            
            $query1 = "update master_employee set employeename = '$employeename',shift = '$shift', lastupdate = '$updatedatetime', lastupdateusername = '$username', lastupdateipaddress = '$ipaddress', reports_daterange_option = '$reports_daterange_option', option_edit_delete = '$option_edit_delete' where employeecode = '$employeecode'";
            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
            
            // Delete existing rights and departments
            $query33 = "delete from master_employeerights where employeecode = '$employeecode' and mainmenuid NOT IN ('MM001','MM026') and submenuid=''";
            $exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
            
            $query333 = "delete from master_employeelocation where employeecode = '$employeecode'";
            $exec333 = mysqli_query($GLOBALS["___mysqli_ston"], $query333) or die ("Error in Query333".mysqli_error($GLOBALS["___mysqli_ston"]));
            
            $query77 = "delete from master_employeedepartment where employeecode = '$employeecode'";
            $exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
            
            // Get submenu IDs
            $q_submenu = array();
            $query_menu = "select submenuid from master_menusub where mainmenuid NOT IN ('MM001','MM026')";
            $exec_menu = mysqli_query($GLOBALS["___mysqli_ston"], $query_menu) or die ("Error in query_menu".mysqli_error($GLOBALS["___mysqli_ston"]));
            while($res_menu = mysqli_fetch_array($exec_menu)) {
                array_push($q_submenu, $res_menu['submenuid']);
            }
            $str_submenu = implode ("','", $q_submenu);
            
            $query33 = "delete from master_employeerights where employeecode = '$employeecode' and mainmenuid='' and submenuid IN ('$str_submenu')";
            $exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
            
            // Process main menu rights
            for ($i=0; $i<=1000; $i++) {
                if (isset($_REQUEST["cbmainmenu".$i])) { 
                    $cbmainmenu = $_REQUEST["cbmainmenu".$i]; 
                } else { 
                    $cbmainmenu = ""; 
                }
                
                if ($cbmainmenu != '') {
                    $query5 = "select * from master_menumain where auto_number = '$cbmainmenu'";
                    $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res5 = mysqli_fetch_array($exec5);
                    $res5mainmenuid = $res5['mainmenuid'];
                    
                    $query3 = "insert into master_employeerights (employeecode, username, mainmenuid, submenuid, lastupdate, lastupdateipaddress, lastupdateusername) values ('$employeecode', '$username1', '$res5mainmenuid', '', '$updatedatetime', '$ipaddress', '$username')";
                    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in query3".mysqli_error($GLOBALS["___mysqli_ston"]));
                }
            }
            
            // Process sub menu rights
            for ($i=0; $i<=1000; $i++) {
                if (isset($_REQUEST["cbsubmenu".$i])) { 
                    $cbsubmenu = $_REQUEST["cbsubmenu".$i]; 
                } else { 
                    $cbsubmenu = ""; 
                }
                
                if ($cbsubmenu != '') {
                    $query6 = "select * from master_menusub where auto_number = '$cbsubmenu'";
                    $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res6 = mysqli_fetch_array($exec6);
                    $res6submenuid = $res6['submenuid'];
                    
                    $query4 = "insert into master_employeerights (employeecode, username, mainmenuid, submenuid, lastupdate, lastupdateipaddress, lastupdateusername) values ('$employeecode', '$username1', '', '$res6submenuid', '$updatedatetime', '$ipaddress', '$username')";
                    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));
                }
            }
            
            // Process department rights
            for ($i=0; $i<=1000; $i++) {
                if (isset($_REQUEST["cbdepartment".$i])) { 
                    $cbdepartment = $_REQUEST["cbdepartment".$i]; 
                } else { 
                    $cbdepartment = ""; 
                }
                
                if ($cbdepartment != '') {
                    $query7 = "select * from master_department where auto_number = '$cbdepartment'";
                    $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res7 = mysqli_fetch_array($exec7);
                    $res7departmentname = $res7['department'];
                    
                    $query8 = "insert into master_employeedepartment (employeecode, username, departmentanum, department, lastupdate, lastupdateipaddress, lastupdateusername) values ('$employeecode', '$username1', '$cbdepartment', '$res7departmentname', '$updatedatetime', '$ipaddress', '$username')";
                    $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));
                }
            }
            
            // Process location rights
            for ($i=0; $i<=1000; $i++) {
                if (isset($_REQUEST["cblocation".$i])) { 
                    $cblocation = $_REQUEST["cblocation".$i]; 
                } else { 
                    $cblocation = ""; 
                }
                
                $storecode = $_REQUEST['storecode'];
                
                if ($cblocation != '') {
                    if($cblocation == $storecode) { 
                        $default = 'default'; 
                    } else { 
                        $default = ''; 
                    }
                    
                    $query1 = "select * from master_location where auto_number = '1'";
                    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res1 = mysqli_fetch_array($exec1);
                    $res1locationname = $res1['locationname'];
                    $res1locationcode = $res1['locationcode'];
                    
                    $query1 = "select * from master_store where storecode = '$cblocation'";
                    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res1 = mysqli_fetch_array($exec1);
                    $res1store = $res1['store'];
                    $res1storecode = $res1['storecode'];
                    
                    $query8 = "insert into master_employeelocation (employeecode, username, locationanum, locationname, locationcode, lastupdate, lastupdateipaddress, lastupdateusername, storecode, defaultstore) values ('$employeecode', '$username1', '1', '$res1locationname', '$res1locationcode', '$updatedatetime', '$ipaddress', '$username', '$res1storecode', '$default')";
                    $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));
                }
            }
        }
    }
    header ("location:editemployee_type.php?st=success");
}

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

if (isset($_REQUEST["selectemployeecode"])) { 
    $selectemployeecode = $_REQUEST["selectemployeecode"]; 
} else { 
    $selectemployeecode = ""; 
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee Type - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/employee-type-modern.css?v=<?php echo time(); ?>">
    
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
        <span>Edit Employee Type</span>
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
                    <li class="nav-item active">
                        <a href="editemployee_type.php" class="nav-link">
                            <i class="fas fa-user-edit"></i>
                            <span>Edit Employee Type</span>
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
                    <h2>Edit Employee Type</h2>
                    <p>Manage employee permissions and access rights by employee type.</p>
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
            
            <!-- Employee Type Selection -->
            <div class="selection-section">
                <div class="selection-header">
                    <i class="fas fa-user-cog selection-icon"></i>
                    <h3 class="selection-title">Select Employee Type</h3>
                </div>
                
                <form name="selectemployee" id="selectemployee" method="post" action="editemployee_type.php?st=edit" onSubmit="return funcEmployeeSelect1()" class="selection-form">
                    <div class="form-group">
                        <label for="selectemployeecode" class="form-label">Employee Type</label>
                        <select name="selectemployeecode" id="selectemployeecode" class="form-select">
                            <option value="">Select Employee Type To Edit</option>
                            <?php
                            $query21 = "select * from master_jobtitle where recordstatus <> 'deleted' order by jobtitle";
                            $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res21 = mysqli_fetch_array($exec21)) {
                                $jobtitleanum = $res21['auto_number'];
                                $jobtitle = $res21['jobtitle'];
                                ?>
                                <option value="<?php echo $jobtitle; ?>" <?php if($selectemployeecode == $jobtitle){ echo 'selected';} ?>><?php echo htmlspecialchars($jobtitle); ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                            Select Type
                        </button>
                    </div>
                </form>
            </div>
            
            <?php if ($selectemployeecode != ''): ?>
            <!-- Employee Edit Form -->
            <div class="edit-form-section">
                <div class="edit-form-header">
                    <i class="fas fa-users-cog edit-form-icon"></i>
                    <h3 class="edit-form-title">Employee Type Configuration</h3>
                    <p class="edit-form-subtitle">* Resets rights for all employees of this type</p>
                </div>
                
                <form name="form1" id="form1" method="post" action="editemployee_type.php" onKeyDown="return disableEnterKey()" onSubmit="return from1submit1()" class="edit-form">
                    
                    <!-- Employee List -->
                    <div class="employee-list-section">
                        <h4>Employees of this Type</h4>
                        <div class="employee-grid">
                            <?php
                            $query7 = "select * from master_employee where job_title = '$selectemployeecode'";
                            $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($res7 = mysqli_fetch_array($exec7)) {
                                $res7employeecode = $res7['employeecode'];
                                $res7employeename = $res7['employeename'];
                                $res7employeename = strtoupper($res7employeename);
                                $res7employeename = trim($res7employeename);
                                ?>
                                <div class="employee-card">
                                    <div class="employee-info">
                                        <span class="employee-code"><?php echo htmlspecialchars($res7employeecode); ?></span>
                                        <span class="employee-name"><?php echo htmlspecialchars($res7employeename); ?></span>
                                    </div>
                                    <input type="hidden" name="employeecode[]" value="<?php echo $res7employeecode; ?>">
                                    <input type="hidden" name="employeename[]" value="<?php echo $res7employeename; ?>">
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    
                    <!-- Shift Access -->
                    <div class="form-section">
                        <div class="section-header">
                            <h3>⏰ Shift Access</h3>
                        </div>
                        <div class="form-group">
                            <label for="shift" class="form-label">Shift Access</label>
                            <select name="shift" id="shift" class="form-select">
                                <option value="">SELECT ACCESS</option>
                                <option value="YES">YES</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Location Permissions -->
                    <div class="form-section">
                        <div class="section-header">
                            <h3>📍 Location Permissions</h3>
                        </div>
                        <div class="permissions-grid">
                            <?php
                            $query1 = "select * from master_store where recordstatus <> 'deleted' order by store";
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res1 = mysqli_fetch_array($exec1)) {
                                $res1storecode = $res1["storecode"];
                                $res1store = $res1["store"];
                                $res1storeanum = $res1["auto_number"];
                                ?>
                                <div class="permission-item">
                                    <label class="permission-label">
                                        <input type="checkbox" name="cblocation<?php echo $res1storeanum; ?>" value="<?php echo $res1storecode; ?>" <?php if($res1storeanum == 1) {echo 'checked';}?> class="permission-checkbox">
                                        <input type="radio" name="storecode" id="storecode<?php echo $res1storeanum; ?>" value="<?php echo $res1storecode; ?>" <?php if($res1storeanum == 1) { echo "Checked"; } ?> class="default-radio">
                                        <span class="permission-text"><?php echo htmlspecialchars($res1store); ?></span>
                                    </label>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    
                    <!-- Menu Permissions -->
                    <div class="form-section">
                        <div class="section-header">
                            <h3>📋 Menu Permissions</h3>
                            <button type="button" class="btn btn-secondary btn-sm" onclick="allmenucheck()">
                                <i class="fas fa-check-double"></i> Select All
                            </button>
                        </div>
                        
                        <div class="menu-permissions">
                            <?php
                            $checkedvalue1 = '';
                            $checkedvalue2 = '';
                            $query2 = "select * from master_menumain where mainmenuid NOT IN ('MM001','MM026') and status = '' order by mainmenuorder";
                            $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res2 = mysqli_fetch_array($exec2)) {
                                $res2anum = $res2['auto_number'];
                                $res2menuid = $res2['mainmenuid'];
                                $res2mainmenutext = $res2['mainmenutext'];
                                ?>
                                <div class="main-menu-item">
                                    <div class="main-menu-header">
                                        <label class="main-menu-label">
                                            <input class="mainmenucheck" id="<?php echo $res2anum; ?>" type="checkbox" name="cbmainmenu<?php echo $res2anum; ?>" <?php echo $checkedvalue1; ?> value="<?php echo $res2anum; ?>" onClick="submenucheck('<?php echo $res2anum; ?>')" class="main-menu-checkbox">
                                            <span class="main-menu-text"><?php echo htmlspecialchars($res2mainmenutext); ?></span>
                                        </label>
                                    </div>
                                    
                                    <div class="sub-menu-list">
                                        <?php
                                        $query3 = "select * from master_menusub where mainmenuid = '$res2menuid' and status = '' order by submenuorder";
                                        $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        while ($res3 = mysqli_fetch_array($exec3)) {
                                            $res3anum = $res3['auto_number'];
                                            $res3submenuid = $res3['submenuid'];
                                            $res3submenutext = $res3['submenutext'];
                                            ?>
                                            <div class="sub-menu-item">
                                                <label class="sub-menu-label">
                                                    <input class="submenucheck <?php echo $res2anum; ?>" type="checkbox" name="cbsubmenu<?php echo $res3anum; ?>" <?php echo $checkedvalue2; ?> value="<?php echo $res3anum; ?>" class="sub-menu-checkbox">
                                                    <span class="sub-menu-text"><?php echo htmlspecialchars($res3submenutext); ?></span>
                                                </label>
                                            </div>
                                            <?php
                                            $checkedvalue2 = '';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php
                                $checkedvalue1 = '';
                            }
                            ?>
                        </div>
                    </div>
                    
                    <!-- Department Permissions -->
                    <div class="form-section">
                        <div class="section-header">
                            <h3>🏢 Department Permissions</h3>
                        </div>
                        <div class="permissions-grid">
                            <?php
                            $checkedvalue3 = '';
                            $query7 = "select * from master_department where recordstatus <> 'deleted' order by auto_number";
                            $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res7 = mysqli_fetch_array($exec7)) {
                                $res7anum = $res7['auto_number'];
                                $res7department = $res7['department'];
                                
                                $query72 = "select * from master_employeedepartment where employeecode = '$selectemployeecode' and departmentanum = '$res7anum'";
                                $exec72 = mysqli_query($GLOBALS["___mysqli_ston"], $query72) or die ("Error in Query72".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res72 = mysqli_fetch_array($exec72);
                                $rowcount72 = mysqli_num_rows($exec72);
                                if ($rowcount72 > 0) {
                                    $checkedvalue3 = 'checked="checked"';
                                }
                                ?>
                                <div class="permission-item">
                                    <label class="permission-label">
                                        <input type="checkbox" name="cbdepartment<?php echo $res7anum; ?>" <?php echo $checkedvalue3; ?> value="<?php echo $res7anum; ?>" class="permission-checkbox">
                                        <span class="permission-text"><?php echo htmlspecialchars($res7department); ?></span>
                                    </label>
                                </div>
                                <?php
                                $checkedvalue3 = '';
                            }
                            ?>
                        </div>
                    </div>
                    
                    <!-- Additional Options -->
                    <div class="form-section">
                        <div class="section-header">
                            <h3>⚙️ Additional Options</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="reports_daterange_option" class="form-label">Report Date Range Option</label>
                                <select name="reports_daterange_option" id="reports_daterange_option" class="form-select">
                                    <option value="Show Date Range Option">Show Date Range Option</option>
                                    <option value="Hide Date Range Option">Hide Date Range Option</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="option_edit_delete" class="form-label">Edit & Delete Option</label>
                                <select name="option_edit_delete" id="option_edit_delete" class="form-select">
                                    <?php
                                    if (isset($res7username)) {
                                        $query1editdelete = "select * from master_employee where username = '$res7username'";
                                        $exec1editdelete = mysqli_query($GLOBALS["___mysqli_ston"], $query1editdelete) or die ("Error in Query1editdelete".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        $res1editdelete = mysqli_fetch_array($exec1editdelete);
                                        $option_edit_delete = $res1editdelete["option_edit_delete"];
                                        
                                        if ($option_edit_delete == 'Edit Delete Option Available' || $option_edit_delete == '') {
                                            echo '<option value="Edit Delete Option Available" selected="selected">Edit Delete Option Available</option>';
                                        }
                                        if ($option_edit_delete == 'Edit Delete Option Denied') {
                                            echo '<option value="Edit Delete Option Denied" selected="selected">Edit Delete Option Denied</option>';
                                        }
                                    }
                                    ?>
                                    <option value="Edit Delete Option Available">Edit Delete Option Available</option>
                                    <option value="Edit Delete Option Denied">Edit Delete Option Denied</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary" accesskey="s">
                            <i class="fas fa-save"></i>
                            Save Employee (Alt+S)
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i>
                            Reset
                        </button>
                    </div>
                    
                    <input type="hidden" name="frmflag1" value="frmflag1">
                    <input type="hidden" name="loopcount" value="1000">
                </form>
            </div>
            <?php endif; ?>
        </main>
    </div>
    
    <!-- Modern JavaScript -->
    <script src="js/employee-type-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
