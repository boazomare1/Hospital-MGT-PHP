<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$companycode = $_SESSION["companycode"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

// Handle form submissions
if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1') {
    $machine = $_REQUEST["machine"];
    $machine = trim($machine);
    $machine = ucwords($machine);
    $length = strlen($machine);
    $machineip = $_REQUEST["machineip"];
    $machinecode = $_REQUEST["machinecode"];
    $machineport = '';
    $is_analyzer = isset($_REQUEST["is_analyzer"]) ? $_REQUEST["is_analyzer"] : '0';
    
    if ($length <= 100) {
        $query2 = "select * from master_interfacemachine where machine = '$machine'";
        $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res2 = mysqli_num_rows($exec2);
        
        if ($res2 == 0) {
            $query1 = "insert into master_interfacemachine (machine, machineip, ipaddress, recorddate, username, machinecode, machineport, is_analyzer) 
            values ('$machine', '$machineip', '$ipaddress', '$updatedatetime', '$username', '$machinecode', '$machineport', '$is_analyzer')";
            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
            $errmsg = "Success. New Interface Machine Added.";
            $bgcolorcode = 'success';
            
            header('location:addinterfacemachine.php?st=1');
        } else {
            $errmsg = "Failed. Equipment Already Exists.";
            $bgcolorcode = 'error';
        }
    } else {
        $errmsg = "Failed. Only 100 Characters Are Allowed.";
        $bgcolorcode = 'error';
    }
}

// Handle status actions
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if ($st == 'del') {
    $delanum = $_REQUEST["anum"];
    $query3 = "update master_interfacemachine set recordstatus = 'deleted' where auto_number = '$delanum'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
    $errmsg = "Interface Machine Deleted Successfully.";
    $bgcolorcode = 'success';
}

if ($st == 'activate') {
    $delanum = $_REQUEST["anum"];
    $query3 = "update master_interfacemachine set recordstatus = '' where auto_number = '$delanum'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
    $errmsg = "Interface Machine Activated Successfully.";
    $bgcolorcode = 'success';
}

if($st == '1') {
    $errmsg = "Success. New Equipment Added.";
    $bgcolorcode = 'success';
}

if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry') {
    $errmsg = "Please Add Machine To Proceed For Billing.";
    $bgcolorcode = 'error';
}

// Generate machine code
$paynowbillprefix = 'IM-';
$paynowbillprefix1 = strlen($paynowbillprefix);
$query2 = "select * from master_interfacemachine order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$res2billnumber = $res2["machinecode"];
$billdigit = strlen($res2billnumber);

if ($res2billnumber == '') {
    $billnumber = 'IM-1';
    $openingbalance = '0.00';
} else {
    $res2billnumber = $res2["machinecode"];
    $billnumbercode = substr($res2billnumber, $paynowbillprefix1, $billdigit);
    $billnumbercode = intval($billnumbercode);
    $billnumbercode = $billnumbercode + 1;
    $maxanum = $billnumbercode;
    $billnumber = 'IM-' . $maxanum;
    $openingbalance = '0.00';
}

$machinecode = $billnumber;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interface Machine Management - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/interface-machine-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Legacy CSS for datepicker -->
    <link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- Legacy JavaScript -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
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
        <a href="mainmenu1.php">System Management</a>
        <span>→</span>
        <span>Interface Machine Management</span>
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
                        <a href="system_settings.php" class="nav-link">
                            <i class="fas fa-cogs"></i>
                            <span>System Settings</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="addinterfacemachine.php" class="nav-link">
                            <i class="fas fa-server"></i>
                            <span>Interface Machines</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="equipment_master.php" class="nav-link">
                            <i class="fas fa-tools"></i>
                            <span>Equipment Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="lab_equipment.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Equipment</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="device_configuration.php" class="nav-link">
                            <i class="fas fa-microchip"></i>
                            <span>Device Configuration</span>
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
                    <div class="alert alert-<?php echo $bgcolorcode; ?>">
                        <i class="fas fa-<?php echo $bgcolorcode === 'success' ? 'check-circle' : 'exclamation-triangle'; ?> alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Interface Machine Management</h2>
                    <p>Manage laboratory interface machines and equipment connections.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportMachineList()">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>
            </div>
            
            <!-- Add New Machine Section -->
            <div class="form-section">
                <div class="section-header">
                    <i class="fas fa-plus-circle"></i>
                    <h3>Add New Interface Machine</h3>
                    <span class="form-help">* Indicates mandatory fields</span>
                </div>
                
                <form name="form1" id="form1" method="post" action="addinterfacemachine.php" onSubmit="return addmachine1process1()">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="machinecode" class="form-label">Equipment Code</label>
                            <input type="text" name="machinecode" id="machinecode" value="<?php echo htmlspecialchars($machinecode); ?>" 
                                   class="form-input readonly" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="machine" class="form-label required">Equipment Name</label>
                            <input type="text" name="machine" id="machine" class="form-input" 
                                   placeholder="Enter equipment name..." maxlength="100" required>
                        </div>
                        
                        <div class="form-group checkbox-group">
                            <input type="checkbox" name="is_analyzer" id="is_analyzer" value="1" class="form-checkbox">
                            <label for="is_analyzer" class="checkbox-label">
                                <i class="fas fa-flask"></i>
                                Is Analyzer Equipment
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="frmflag" value="addnew">
                        <input type="hidden" name="frmflag1" value="frmflag1">
                        <input type="hidden" name="machineip" id="machineip" value="">
                        <button type="submit" name="Submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Add Machine
                        </button>
                        <button type="reset" name="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i>
                            Reset
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Existing Machines Section -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-server data-table-icon"></i>
                    <h3 class="data-table-title">Existing Interface Machines</h3>
                    <div class="data-table-actions">
                        <button type="button" class="btn btn-outline btn-sm" onclick="refreshMachines()">
                            <i class="fas fa-sync-alt"></i>
                            Refresh
                        </button>
                    </div>
                </div>
                
                <div class="table-container">
                    <table class="data-table" id="machinesTable">
                        <thead>
                            <tr>
                                <th>Actions</th>
                                <th>Equipment Code</th>
                                <th>Equipment Name</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $colorloopcount = 0;
                            $query1 = "select * from master_interfacemachine where recordstatus <> 'deleted' order by machine";
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            while ($res1 = mysqli_fetch_array($exec1)) {
                                $machine = $res1["machine"];
                                $machinecode = $res1["machinecode"];
                                $auto_number = $res1["auto_number"];
                                $machineport = $res1["machineport"];
                                $is_analyzer = $res1["is_analyzer"];
                                $colorloopcount++;
                            ?>
                            <tr>
                                <td class="actions-cell">
                                    <a href="addinterfacemachine.php?st=del&&anum=<?php echo $auto_number; ?>" 
                                       onClick="return funcDeletemachine('<?php echo htmlspecialchars($machine); ?>')"
                                       class="action-btn delete-btn" title="Delete Machine">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                                <td>
                                    <span class="machine-code"><?php echo htmlspecialchars($machinecode); ?></span>
                                </td>
                                <td>
                                    <span class="machine-name"><?php echo htmlspecialchars($machine); ?></span>
                                </td>
                                <td>
                                    <?php if ($is_analyzer == '1'): ?>
                                        <span class="type-badge analyzer">
                                            <i class="fas fa-flask"></i>
                                            Analyzer
                                        </span>
                                    <?php else: ?>
                                        <span class="type-badge interface">
                                            <i class="fas fa-server"></i>
                                            Interface
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="status-badge active">
                                        <i class="fas fa-check-circle"></i>
                                        Active
                                    </span>
                                </td>
                                <td class="actions-cell">
                                    <a href="editinterfacemachine.php?st=edit&&anum=<?php echo $auto_number; ?>" 
                                       class="action-btn edit-btn" title="Edit Machine">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php
                            }
                            
                            if ($colorloopcount == 0):
                            ?>
                            <tr>
                                <td colspan="6" class="no-data">
                                    <i class="fas fa-inbox"></i>
                                    <h3>No Machines Found</h3>
                                    <p>No interface machines have been added yet. Add your first machine above.</p>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Table Summary -->
                <div class="table-summary">
                    <div class="summary-item">
                        <i class="fas fa-server"></i>
                        <span>Total Machines: <strong><?php echo $colorloopcount; ?></strong></span>
                    </div>
                    <div class="summary-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Active Machines: <strong><?php echo $colorloopcount; ?></strong></span>
                    </div>
                </div>
            </div>
            
            <!-- Deleted Machines Section -->
            <?php
            $deletedcount = 0;
            $query1 = "select * from master_interfacemachine where recordstatus = 'deleted' order by machine";
            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
            $deletedcount = mysqli_num_rows($exec1);
            
            if ($deletedcount > 0):
            ?>
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-trash data-table-icon"></i>
                    <h3 class="data-table-title">Deleted Machines</h3>
                    <div class="data-table-actions">
                        <button type="button" class="btn btn-outline btn-sm" onclick="toggleDeletedSection()">
                            <i class="fas fa-eye"></i>
                            Toggle View
                        </button>
                    </div>
                </div>
                
                <div class="table-container" id="deletedSection">
                    <table class="data-table" id="deletedTable">
                        <thead>
                            <tr>
                                <th>Actions</th>
                                <th>Equipment Code</th>
                                <th>Equipment Name</th>
                                <th>Type</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($res1 = mysqli_fetch_array($exec1)) {
                                $machine = $res1['machine'];
                                $machinecode = $res1["machinecode"];
                                $auto_number = $res1["auto_number"];
                                $is_analyzer = $res1["is_analyzer"];
                            ?>
                            <tr>
                                <td class="actions-cell">
                                    <a href="addinterfacemachine.php?st=activate&&anum=<?php echo $auto_number; ?>" 
                                       class="action-btn activate-btn" title="Activate Machine">
                                        <i class="fas fa-undo"></i>
                                    </a>
                                </td>
                                <td>
                                    <span class="machine-code"><?php echo htmlspecialchars($machinecode); ?></span>
                                </td>
                                <td>
                                    <span class="machine-name"><?php echo htmlspecialchars($machine); ?></span>
                                </td>
                                <td>
                                    <?php if ($is_analyzer == '1'): ?>
                                        <span class="type-badge analyzer">
                                            <i class="fas fa-flask"></i>
                                            Analyzer
                                        </span>
                                    <?php else: ?>
                                        <span class="type-badge interface">
                                            <i class="fas fa-server"></i>
                                            Interface
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="status-badge deleted">
                                        <i class="fas fa-times-circle"></i>
                                        Deleted
                                    </span>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Deleted Summary -->
                <div class="table-summary">
                    <div class="summary-item">
                        <i class="fas fa-trash"></i>
                        <span>Deleted Machines: <strong><?php echo $deletedcount; ?></strong></span>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>
    
    <!-- Modern JavaScript -->
    <script src="js/interface-machine-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy JavaScript for compatibility -->
    <script language="javascript">
        // Legacy functions preserved for compatibility
        function addmachine1process1() {
            if (document.form1.machine.value == "") {
                alert("Please Enter Interface Machine Name.");
                document.form1.machine.focus();
                return false;
            }
            return true;
        }
        
        function funcDeletemachine(varmachineAutoNumber) {
            var varmachineAutoNumber = varmachineAutoNumber;
            var fRet;
            fRet = confirm('Are you sure want to delete this machine Type ' + varmachineAutoNumber + '?');
            
            if (fRet == true) {
                alert("Interface Machine Entry Delete Completed.");
                return true;
            }
            if (fRet == false) {
                alert("Interface Machine Entry Delete Not Completed.");
                return false;
            }
        }
        
        // Modern functions
        function refreshPage() {
            window.location.reload();
        }
        
        function refreshMachines() {
            window.location.reload();
        }
        
        function exportMachineList() {
            // Create CSV content
            const table = document.getElementById('machinesTable');
            const rows = table.querySelectorAll('tbody tr');
            let csvContent = 'Equipment Code,Equipment Name,Type,Status\n';
            
            rows.forEach(function(row) {
                const cells = row.querySelectorAll('td');
                if (cells.length > 1) { // Skip the "no data" row
                    const code = cells[1].textContent.trim();
                    const name = cells[2].textContent.trim();
                    const type = cells[3].textContent.trim();
                    const status = cells[4].textContent.trim();
                    csvContent += `"${code}","${name}","${type}","${status}"\n`;
                }
            });
            
            // Download CSV
            const blob = new Blob([csvContent], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'interface_machines.csv';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        }
        
        function toggleDeletedSection() {
            const section = document.getElementById('deletedSection');
            section.style.display = section.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</body>
</html>
