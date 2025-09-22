<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$username = $_SESSION['username'];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$companycode = $_SESSION["companycode"];
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = '';
$bgcolorcode = "";
$colorloopcount = "";

$month = date('M-Y');

// Handle form submissions
if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchstatus"])) { $searchstatus = $_REQUEST["searchstatus"]; } else { $searchstatus = "Active"; }
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

// Handle bulk status update
if ($frmflag2 == 'frmflag2') {	
    $updatestatus = $_REQUEST['updatestatus'];
    $anumarray = $_REQUEST['anum'];	
    foreach($anumarray as $anum) {
        $query12 = "update master_employee set payrollstatus = '$updatestatus' where auto_number = '$anum'";
        $exec12 = mysqli_query($GLOBALS["___mysqli_ston"],$query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    header("location:employeelist1.php?st=success");
}

// Handle success/failure messages
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'success') {
    $errmsg = "Employee status updated successfully!";
    $bgcolorcode = 'success';
} else if ($st == 'failed') {
    $errmsg = "Failed to update employee status.";
    $bgcolorcode = 'error';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee List - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/employee-list-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Legacy CSS for autocomplete -->
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <!-- Legacy JavaScript -->
    <script type="text/javascript" src="js/autosuggestemployeereportsearch1.js"></script>
    <script type="text/javascript" src="js/autocomplete_jobdescription2.js"></script>
    <script type="text/javascript" src="js/disablebackenterkey.js"></script>
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
        <span>Employee List</span>
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
                        <a href="editemployeeinfo1.php" class="nav-link">
                            <i class="fas fa-user-edit"></i>
                            <span>Edit Employee</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="employeelist1.php" class="nav-link">
                            <i class="fas fa-list"></i>
                            <span>Employee List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addemployeecategory.php" class="nav-link">
                            <i class="fas fa-tags"></i>
                            <span>Employee Categories</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addemployeedesignation.php" class="nav-link">
                            <i class="fas fa-id-badge"></i>
                            <span>Employee Designations</span>
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
                    <h2>Employee List</h2>
                    <p>View and manage employee records with bulk status updates.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportEmployeeList()">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>
            </div>
            
            <!-- Search Employee Section -->
            <div class="search-container">
                <div class="section-header">
                    <i class="fas fa-search"></i>
                    <h3>Search Employees</h3>
                </div>
                
                <form name="form1" id="form1" method="post" action="employeelist1.php">
                    <div class="search-form">
                        <div class="search-input-group">
                            <label for="searchemployee" class="search-label">Employee Name or Code</label>
                            <input type="hidden" name="autobuildemployee" id="autobuildemployee">
                            <input type="hidden" name="searchemployeecode" id="searchemployeecode">
                            <input type="text" name="searchemployee" id="searchemployee" autocomplete="off" 
                                   value="<?php echo htmlspecialchars($searchemployee); ?>" 
                                   class="search-input" placeholder="Type employee name or code...">
                        </div>
                        
                        <div class="search-input-group">
                            <label for="searchstatus" class="search-label">Status</label>
                            <select name="searchstatus" id="searchstatus" class="form-select">
                                <option value="Active" <?php echo $searchstatus === 'Active' ? 'selected' : ''; ?>>Active</option>
                                <option value="Inactive" <?php echo $searchstatus === 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
                                <option value="Prorata" <?php echo $searchstatus === 'Prorata' ? 'selected' : ''; ?>>Prorata</option>
                            </select>
                        </div>
                        
                        <div class="form-actions">
                            <input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1">
                            <button type="submit" name="Search" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                                Search
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="clearSearchForm()">
                                <i class="fas fa-times"></i>
                                Clear
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Employee List Section -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-users data-table-icon"></i>
                    <h3 class="data-table-title">Employee List</h3>
                    <div class="data-table-actions">
                        <button type="button" class="btn btn-outline btn-sm" onclick="toggleBulkActions()">
                            <i class="fas fa-tasks"></i>
                            Bulk Actions
                        </button>
                        <button type="button" class="btn btn-outline btn-sm" onclick="selectAll()">
                            <i class="fas fa-check-square"></i>
                            Select All
                        </button>
                    </div>
                </div>
                
                <form name="form2" id="form2" method="post" action="employeelist1.php" onSubmit="return from1submit1()">
                    <div class="table-container">
                        <table class="data-table" id="employeeTable">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>
                                        <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll()">
                                    </th>
                                    <th>Payroll Number</th>
                                    <th>Employee Code</th>
                                    <th>Employee Name</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $totalamount = '0.00';
                                $query2 = "select * from master_employee where employeename like '%$searchemployee%' and payrollstatus = '$searchstatus' order by employeecode";
                                $exec2 = mysqli_query($GLOBALS["___mysqli_ston"],$query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $colorloopcount = 0;
                                
                                while($res2 = mysqli_fetch_array($exec2)) {
                                    $anum = $res2['auto_number'];
                                    $res2employeecode = $res2['employeecode'];
                                    $res2employeename = $res2['employeename'];
                                    $res2status = $res2['payrollstatus'];
                                    
                                    $query6 = "select * from master_employeeinfo where employeecode = '$res2employeecode' ";
                                    $exec6 = mysqli_query($GLOBALS["___mysqli_ston"],$query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res6 = mysqli_fetch_array($exec6);
                                    $payrollno = $res6['payrollno'];
                                    
                                    $query22 = "select employeecode from payroll_assign where employeecode = '$res2employeecode' group by employeecode";
                                    $exec22 = mysqli_query($GLOBALS["___mysqli_ston"],$query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res22 = mysqli_num_rows($exec22);
                                    
                                    if($res22 > 0) {
                                        $colorloopcount = $colorloopcount + 1;
                                        ?>
                                        <tr>
                                            <td><?php echo $colorloopcount; ?></td>
                                            <td>
                                                <input type="checkbox" name="anum[]" value="<?php echo $anum; ?>" class="employee-checkbox">
                                            </td>
                                            <td><?php echo htmlspecialchars($payrollno); ?></td>
                                            <td>
                                                <a href="editemployeeinfo1.php?searchemployeecode=<?php echo $res2employeecode; ?>&searchemployee=<?php echo urlencode($res2employeename); ?>" 
                                                   class="employee-link" title="Edit Employee">
                                                    <?php echo htmlspecialchars($res2employeecode); ?>
                                                </a>
                                            </td>
                                            <td><?php echo htmlspecialchars($res2employeename); ?></td>
                                            <td>
                                                <span class="status-badge status-<?php echo strtolower($res2status); ?>">
                                                    <?php echo htmlspecialchars($res2status); ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                
                                if ($colorloopcount == 0):
                                ?>
                                <tr>
                                    <td colspan="6" class="no-data">
                                        <i class="fas fa-inbox"></i>
                                        <h3>No Employees Found</h3>
                                        <p>No employees match your search criteria. Try adjusting your search parameters.</p>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Bulk Actions Section -->
                    <div class="bulk-actions" id="bulkActions" style="display: none;">
                        <div class="bulk-actions-content">
                            <div class="bulk-actions-info">
                                <i class="fas fa-info-circle"></i>
                                <span id="selectedCount">0 employees selected</span>
                            </div>
                            <div class="bulk-actions-form">
                                <div class="form-group">
                                    <label for="updatestatus" class="form-label">Update Status To:</label>
                                    <select name="updatestatus" id="updatestatus" class="form-select">
                                        <option value="">Select Status</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                        <option value="Prorata">Prorata</option>
                                    </select>
                                </div>
                                <div class="form-actions">
                                    <input type="hidden" name="frmflag2" id="frmflag2" value="frmflag2">
                                    <button type="submit" name="submit111" class="btn btn-primary">
                                        <i class="fas fa-save"></i>
                                        Update Selected
                                    </button>
                                    <button type="button" class="btn btn-secondary" onclick="clearSelection()">
                                        <i class="fas fa-times"></i>
                                        Clear Selection
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Table Summary -->
                    <div class="table-summary">
                        <div class="summary-item">
                            <i class="fas fa-users"></i>
                            <span>Total Employees: <strong><?php echo $colorloopcount; ?></strong></span>
                        </div>
                        <div class="summary-item">
                            <i class="fas fa-filter"></i>
                            <span>Filtered by: <strong><?php echo htmlspecialchars($searchstatus); ?></strong></span>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>
    
    <!-- Modern JavaScript -->
    <script src="js/employee-list-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy JavaScript for compatibility -->
    <script language="javascript">
        // Legacy functions preserved for compatibility
        function process1backkeypress1() {
            if (event.keyCode==8) {
                event.keyCode=0; 
                return event.keyCode 
                return false;
            }
        }
        
        window.onload = function () {
            var oTextbox = new AutoSuggestControl(document.getElementById("searchemployee"), new StateSuggestions());
        }
        
        function captureEscapeKey1() {
            if (event.keyCode==8) {
                // Handle escape key
            }
        }
        
        function from1submit1() {
            if(document.getElementById("updatestatus").value == "") {
                alert("Select Status");
                document.getElementById("updatestatus").focus();
                return false;
            }
            
            // Check if any employees are selected
            var checkboxes = document.querySelectorAll('.employee-checkbox:checked');
            if (checkboxes.length === 0) {
                alert("Please select at least one employee");
                return false;
            }
            
            return confirm('Are you sure you want to update the status of ' + checkboxes.length + ' employee(s)?');
        }
        
        // Modern functions
        function refreshPage() {
            window.location.reload();
        }
        
        function clearSearchForm() {
            document.getElementById('form1').reset();
            document.getElementById('searchemployee').value = '';
            document.getElementById('searchstatus').value = 'Active';
        }
        
        function exportEmployeeList() {
            // Create CSV content
            const table = document.getElementById('employeeTable');
            const rows = table.querySelectorAll('tbody tr');
            let csvContent = 'Payroll Number,Employee Code,Employee Name,Status\n';
            
            rows.forEach(function(row) {
                const cells = row.querySelectorAll('td');
                if (cells.length > 1) { // Skip the "no data" row
                    const payrollNo = cells[2].textContent.trim();
                    const empCode = cells[3].textContent.trim();
                    const empName = cells[4].textContent.trim();
                    const status = cells[5].textContent.trim();
                    csvContent += `"${payrollNo}","${empCode}","${empName}","${status}"\n`;
                }
            });
            
            // Download CSV
            const blob = new Blob([csvContent], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'employee_list.csv';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        }
        
        function toggleBulkActions() {
            const bulkActions = document.getElementById('bulkActions');
            bulkActions.style.display = bulkActions.style.display === 'none' ? 'block' : 'none';
        }
        
        function selectAll() {
            const checkboxes = document.querySelectorAll('.employee-checkbox');
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = !allChecked;
            });
            
            selectAllCheckbox.checked = !allChecked;
            updateSelectedCount();
        }
        
        function toggleSelectAll() {
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const checkboxes = document.querySelectorAll('.employee-checkbox');
            
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = selectAllCheckbox.checked;
            });
            
            updateSelectedCount();
        }
        
        function clearSelection() {
            const checkboxes = document.querySelectorAll('.employee-checkbox');
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = false;
            });
            
            selectAllCheckbox.checked = false;
            updateSelectedCount();
        }
        
        function updateSelectedCount() {
            const checkboxes = document.querySelectorAll('.employee-checkbox:checked');
            const count = checkboxes.length;
            const countElement = document.getElementById('selectedCount');
            
            countElement.textContent = count + ' employee(s) selected';
            
            // Show/hide bulk actions based on selection
            const bulkActions = document.getElementById('bulkActions');
            if (count > 0) {
                bulkActions.style.display = 'block';
            } else {
                bulkActions.style.display = 'none';
            }
        }
        
        // Add event listeners for checkboxes
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.employee-checkbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', updateSelectedCount);
            });
            
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', toggleSelectAll);
            }
        });
    </script>
</body>
</html>

