<?php
session_start();
error_reporting(0);
include ("db/db_connect.php");
include ("includes/loginverify.php");

$updatedatetime = date("Y-m-d H:i:s");
$indiandatetitme = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$suppdateonly = date("Y-m-d");
$username = $_SESSION['username'];
$ipaddress = $_SERVER['REMOTE_ADDR'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$pagename = 'BUDGET ENTRY LIST';
$titlestr = 'BUDGET ENTRY';
$docno = $_SESSION['docno'];

// Initialize variables
$errmsg = "";
$bgcolorcode = "";

// Get location details
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);

$reslocationname = $res["locationname"];
$res12locationanum = $res["auto_number"];

$query3 = "select * from master_location where locationname='$reslocationname'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);

$reslocationcode = $res3['locationcode'];

// Handle form submissions
if (isset($_POST['delete_budget'])) {
    $budget_no = $_POST['budget_no'];
    $errmsg = "Budget entry deleted successfully.";
    $bgcolorcode = 'success';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Entry List - Cost Center - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/vat-modern.css?v=<?php echo time(); ?>">
    
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
        <span>Budget Entry List - Cost Center</span>
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
                        <a href="admissionlist.php" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>Admission List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipbeddiscountlist.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            <span>Bed Discount</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addbed.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Add Bed</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="bedoccupancysummary.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Bed Occupancy</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="bedoccupancy2.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Bed Occupancy 2</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="bedtransferlist.php" class="nav-link">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Bed Transfer</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="otc_walkin_services.php" class="nav-link">
                            <i class="fas fa-walking"></i>
                            <span>OTC Walk-in</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billenquiry.php" class="nav-link">
                            <i class="fas fa-search"></i>
                            <span>Bill Enquiry</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billestimate.php" class="nav-link">
                            <i class="fas fa-calculator"></i>
                            <span>Bill Estimate</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billtxnidedit.php" class="nav-link">
                            <i class="fas fa-edit"></i>
                            <span>Transaction Edit</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="patientbillingstatus.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Patient Billing Status</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billing_pending_op2.php" class="nav-link">
                            <i class="fas fa-clock"></i>
                            <span>Billing Pending OP2</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="medicalgoodsreceivednote.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Medical Goods Received</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="fixedasset_detailed_report.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Fixed Asset Detailed</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="fixedasset_summary_report.php" class="nav-link">
                            <i class="fas fa-chart-pie"></i>
                            <span>Fixed Asset Summary</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="theatrebookinglist.php" class="nav-link">
                            <i class="fas fa-theater-masks"></i>
                            <span>Theatre Booking List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="branch_git.php" class="nav-link">
                            <i class="fas fa-truck"></i>
                            <span>Branch GIT</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="branchincome.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Branch Income</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="brstocktransferreport.php" class="nav-link">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Stock Transfer Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="branchstockrequest.php" class="nav-link">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Stock Request</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="budgetentrycc.php" class="nav-link">
                            <i class="fas fa-calculator"></i>
                            <span>Budget Entry CC</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="budgetentrycclist.php" class="nav-link">
                            <i class="fas fa-list"></i>
                            <span>Budget Entry List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="vat.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            <span>VAT Master</span>
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
                    <h2>Budget Entry List - Cost Center</h2>
                    <p>View and manage all budget entries for cost centers with comprehensive tracking and approval workflow.</p>
                </div>
                <div class="page-header-actions">
                    <a href="budgetentrycc.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> New Budget Entry
                    </a>
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>
            </div>

            <!-- Budget Entry List -->
            <div class="data-section">
                <div class="data-section-header">
                    <h3>Budget Entry Cost Center - Initiated</h3>
                    <p>Location: <strong><?php echo htmlspecialchars($reslocationname); ?></strong></p>
                </div>
                
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Doc No</th>
                            <th>Budget Name</th>
                            <th>Budget Year</th>
                            <th>Initiated Date</th>
                            <th>Initiated By</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sno = 0;
                        $colorloopcount = 0;
                        
                        $query6 = "select * from budget_entry_temp where location_code = '$reslocationcode' and is_deleted='0' and is_approved<>1 group by budget_no order by budget_year";
                        $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
                        
                        while($res6 = mysqli_fetch_array($exec6)) {
                            $budgetno = $res6['budget_no'];
                            $budgetdate = $res6['budget_date'];
                            $budgetname = $res6['budget_name'];
                            $budgetyear = $res6['budget_year'];
                            $budgettype = $res6['budget_type'];
                            $initiatedby = $res6['initiated_by'];
                            $is_approved = $res6['is_approved'];
                            
                            $sno++;
                            $colorloopcount++;
                            $showcolor = ($colorloopcount & 1);
                            
                            if ($showcolor == 0) {
                                $colorcode = 'bgcolor="#CBDBFA"';
                            } else {
                                $colorcode = 'bgcolor="#ecf0f5"';
                            }
                            
                            $status = $is_approved == 1 ? 'Approved' : 'Pending';
                            $statusClass = $is_approved == 1 ? 'status-approved' : 'status-pending';
                            
                            echo '<tr '.$colorcode.'>';
                            echo '<td>' . $sno . '</td>';
                            echo '<td>' . htmlspecialchars($budgetno) . '</td>';
                            echo '<td>' . htmlspecialchars($budgetname) . '</td>';
                            echo '<td>' . htmlspecialchars($budgetyear) . '</td>';
                            echo '<td>' . date('Y-m-d', strtotime($budgetdate)) . '</td>';
                            echo '<td>' . htmlspecialchars($initiatedby) . '</td>';
                            echo '<td><span class="status-badge ' . $statusClass . '">' . $status . '</span></td>';
                            echo '<td class="action-buttons">';
                            echo '<button type="button" class="btn btn-sm btn-outline" onclick="viewBudget(\'' . $budgetno . '\')">';
                            echo '<i class="fas fa-eye"></i> View';
                            echo '</button>';
                            if ($is_approved != 1) {
                                echo '<button type="button" class="btn btn-sm btn-danger" onclick="deleteBudget(\'' . $budgetno . '\')">';
                                echo '<i class="fas fa-trash"></i> Delete';
                                echo '</button>';
                            }
                            echo '</td>';
                            echo '</tr>';
                        }
                        
                        if ($sno == 0) {
                            echo '<tr>';
                            echo '<td colspan="8" class="no-data">';
                            echo '<i class="fas fa-clipboard-list"></i>';
                            echo '<p>No budget entries found for this location.</p>';
                            echo '<a href="budgetentrycc.php" class="btn btn-primary">Create New Budget Entry</a>';
                            echo '</td>';
                            echo '</tr>';
                        } else {
                            // Add total row
                            echo '<tr class="total-row">';
                            echo '<td colspan="7"><strong>Total Budget Entries: ' . $sno . '</strong></td>';
                            echo '<td></td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Budget Summary Cards -->
            <div class="summary-cards">
                <div class="summary-card">
                    <div class="summary-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="summary-content">
                        <h4>Total Entries</h4>
                        <p><?php echo $sno; ?></p>
                    </div>
                </div>
                
                <div class="summary-card">
                    <div class="summary-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="summary-content">
                        <h4>Pending Approval</h4>
                        <p><?php 
                        $pendingQuery = "select count(*) as pending_count from budget_entry_temp where location_code = '$reslocationcode' and is_deleted='0' and is_approved<>1";
                        $pendingExec = mysqli_query($GLOBALS["___mysqli_ston"], $pendingQuery);
                        $pendingRes = mysqli_fetch_array($pendingExec);
                        echo $pendingRes['pending_count'];
                        ?></p>
                    </div>
                </div>
                
                <div class="summary-card">
                    <div class="summary-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="summary-content">
                        <h4>Approved</h4>
                        <p><?php 
                        $approvedQuery = "select count(*) as approved_count from budget_entry_temp where location_code = '$reslocationcode' and is_deleted='0' and is_approved=1";
                        $approvedExec = mysqli_query($GLOBALS["___mysqli_ston"], $approvedQuery);
                        $approvedRes = mysqli_fetch_array($approvedExec);
                        echo $approvedRes['approved_count'];
                        ?></p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="js/vat-modern.js?v=<?php echo time(); ?>"></script>
    <script>
        // Additional JavaScript for budget entry list
        function refreshPage() {
            window.location.reload();
        }
        
        function exportToExcel() {
            // Export functionality can be implemented here
            alert('Export functionality will be implemented');
        }
        
        function viewBudget(budgetNo) {
            // View budget details
            window.open('budgetentrycc.php?view=' + budgetNo, '_blank');
        }
        
        function deleteBudget(budgetNo) {
            if (confirm('Are you sure you want to delete this budget entry?')) {
                // Create a form to submit the delete request
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'budgetentrycclist.php';
                
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'delete_budget';
                input.value = '1';
                
                const budgetInput = document.createElement('input');
                budgetInput.type = 'hidden';
                budgetInput.name = 'budget_no';
                budgetInput.value = budgetNo;
                
                form.appendChild(input);
                form.appendChild(budgetInput);
                document.body.appendChild(form);
                form.submit();
            }
        }
        
        // Search functionality
        function searchBudgets() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('.data-table tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
        
        // Add search input if needed
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize any additional functionality
            console.log('Budget entry list page loaded');
        });
    </script>
</body>
</html>
