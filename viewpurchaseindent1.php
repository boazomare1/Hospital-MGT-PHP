<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

// Initialize variables
$errmsg = "";
$bgcolorcode = "";

// Handle form parameters
if (isset($_POST['ADate1'])) {
    $fromdate = $_POST['ADate1'];
} else {
    $fromdate = $transactiondatefrom;
}

if (isset($_POST['ADate2'])) {
    $todate = $_POST['ADate2'];
} else {
    $todate = $transactiondateto;
}

if (isset($_POST['docno'])) {
    $docno = $_POST['docno'];
} else {
    $docno = '';
}

// Handle form submission
if (isset($_POST['cbfrmflag1'])) {
    if (empty($fromdate) || empty($todate)) {
        $errmsg = "Please select both start and end dates.";
        $bgcolorcode = 'failed';
    } else {
        $errmsg = "Purchase indent search completed successfully.";
        $bgcolorcode = 'success';
    }
}

// Query for purchase indents
$query1 = "select * from purchase_indent where approvalstatus='partially' and (date between '$fromdate' and '$todate') and docno like '%$docno%' group by docno";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$resnw3 = mysqli_num_rows($exec1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Purchase Indent - MedStar</title>
    
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
        <span>View Purchase Indent</span>
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
                    <li class="nav-item">
                        <a href="budgetentrycclist.php" class="nav-link">
                            <i class="fas fa-list"></i>
                            <span>Budget Entry List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="costcenterbudgetreport.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Cost Center Budget Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="bulkbedratesupdate.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Bulk Bed Rates Update</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="viewpurchaseindent1.php" class="nav-link">
                            <i class="fas fa-file-invoice"></i>
                            <span>View Purchase Indent</span>
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
                    <h2>CEO Purchase Indents Approval</h2>
                    <p>View and manage purchase indents with comprehensive approval workflow and detailed tracking.</p>
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

            <!-- Search Filter Form -->
            <div class="add-form-section">
                <div class="add-form-header">
                    <i class="fas fa-file-invoice add-form-icon"></i>
                    <h3 class="add-form-title">Purchase Indent Search</h3>
                </div>
                
                <form id="searchForm" name="cbform1" method="post" action="viewpurchaseindent1.php" class="add-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="docno" class="form-label">Document Number</label>
                            <input type="text" name="docno" id="docno" class="form-input" value="<?php echo htmlspecialchars($docno); ?>" placeholder="Enter document number">
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <input type="date" name="ADate1" id="ADate1" class="form-input" value="<?php echo $fromdate; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <input type="date" name="ADate2" id="ADate2" class="form-input" value="<?php echo $todate; ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" name="cbfrmflag1" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Purchase Indent Results -->
            <div class="data-section">
                <div class="data-section-header">
                    <h3>Purchase Indent Results</h3>
                    <p>Found <strong><?php echo $resnw3; ?></strong> purchase indents matching your criteria</p>
                </div>
                
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Document No</th>
                            <th>Date</th>
                            <th>Department</th>
                            <th>Requested By</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sno = 0;
                        $colorloopcount = 0;
                        
                        // Reset the query result pointer
                        mysqli_data_seek($exec1, 0);
                        
                        while ($res1 = mysqli_fetch_array($exec1)) {
                            $sno++;
                            $colorloopcount++;
                            $showcolor = ($colorloopcount & 1);
                            
                            if ($showcolor == 0) {
                                $colorcode = 'bgcolor="#CBDBFA"';
                            } else {
                                $colorcode = 'bgcolor="#ecf0f5"';
                            }
                            
                            $docno = $res1['docno'];
                            $date = $res1['date'];
                            $department = isset($res1['department']) ? $res1['department'] : 'N/A';
                            $requestedby = isset($res1['requestedby']) ? $res1['requestedby'] : 'N/A';
                            $totalamount = isset($res1['totalamount']) ? $res1['totalamount'] : '0.00';
                            $approvalstatus = $res1['approvalstatus'];
                            
                            $statusClass = '';
                            $statusText = '';
                            
                            switch ($approvalstatus) {
                                case 'partially':
                                    $statusClass = 'status-pending';
                                    $statusText = 'Partially Approved';
                                    break;
                                case 'approved':
                                    $statusClass = 'status-approved';
                                    $statusText = 'Approved';
                                    break;
                                case 'rejected':
                                    $statusClass = 'status-rejected';
                                    $statusText = 'Rejected';
                                    break;
                                default:
                                    $statusClass = 'status-pending';
                                    $statusText = 'Pending';
                            }
                            
                            echo '<tr '.$colorcode.'>';
                            echo '<td>' . $sno . '</td>';
                            echo '<td>' . htmlspecialchars($docno) . '</td>';
                            echo '<td>' . date('Y-m-d', strtotime($date)) . '</td>';
                            echo '<td>' . htmlspecialchars($department) . '</td>';
                            echo '<td>' . htmlspecialchars($requestedby) . '</td>';
                            echo '<td class="text-right">₹ ' . number_format($totalamount, 2) . '</td>';
                            echo '<td><span class="status-badge ' . $statusClass . '">' . $statusText . '</span></td>';
                            echo '<td class="action-buttons">';
                            echo '<button type="button" class="btn btn-sm btn-outline" onclick="viewIndent(\'' . $docno . '\')">';
                            echo '<i class="fas fa-eye"></i> View';
                            echo '</button>';
                            if ($approvalstatus == 'partially') {
                                echo '<button type="button" class="btn btn-sm btn-primary" onclick="approveIndent(\'' . $docno . '\')">';
                                echo '<i class="fas fa-check"></i> Approve';
                                echo '</button>';
                            }
                            echo '</td>';
                            echo '</tr>';
                        }
                        
                        if ($sno == 0) {
                            echo '<tr>';
                            echo '<td colspan="8" class="no-data">';
                            echo '<i class="fas fa-file-invoice"></i>';
                            echo '<p>No purchase indents found for the specified criteria.</p>';
                            echo '<p>Try adjusting your search parameters or date range.</p>';
                            echo '</td>';
                            echo '</tr>';
                        } else {
                            // Add total row
                            echo '<tr class="total-row">';
                            echo '<td colspan="5"><strong>Total Records: ' . $sno . '</strong></td>';
                            echo '<td class="text-right"><strong>₹ ' . number_format(array_sum(array_column(mysqli_fetch_all($exec1, MYSQLI_ASSOC), 'totalamount')), 2) . '</strong></td>';
                            echo '<td colspan="2"></td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Summary Cards -->
            <div class="summary-cards">
                <div class="summary-card">
                    <div class="summary-icon">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <div class="summary-content">
                        <h4>Total Indents</h4>
                        <p><?php echo $resnw3; ?></p>
                    </div>
                </div>
                
                <div class="summary-card">
                    <div class="summary-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="summary-content">
                        <h4>Pending Approval</h4>
                        <p><?php 
                        $pendingQuery = "select count(*) as pending_count from purchase_indent where approvalstatus='partially' and (date between '$fromdate' and '$todate') and docno like '%$docno%'";
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
                        $approvedQuery = "select count(*) as approved_count from purchase_indent where approvalstatus='approved' and (date between '$fromdate' and '$todate') and docno like '%$docno%'";
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
        // Additional JavaScript for view purchase indent
        function refreshPage() {
            window.location.reload();
        }
        
        function exportToExcel() {
            // Export functionality can be implemented here
            alert('Export functionality will be implemented');
        }
        
        function viewIndent(docno) {
            // View indent details
            window.open('purchaseindentdetails.php?docno=' + docno, '_blank');
        }
        
        function approveIndent(docno) {
            if (confirm('Are you sure you want to approve this purchase indent?')) {
                // Create a form to submit the approval request
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'approvepurchaseindent.php';
                
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'docno';
                input.value = docno;
                
                const actionInput = document.createElement('input');
                actionInput.type = 'hidden';
                actionInput.name = 'action';
                actionInput.value = 'approve';
                
                form.appendChild(input);
                form.appendChild(actionInput);
                document.body.appendChild(form);
                form.submit();
            }
        }
        
        // Form validation
        document.getElementById('searchForm').addEventListener('submit', function(e) {
            const startDate = document.getElementById('ADate1').value;
            const endDate = document.getElementById('ADate2').value;
            
            if (!startDate || !endDate) {
                e.preventDefault();
                alert('Please select both start and end dates.');
                return false;
            }
            
            if (new Date(startDate) > new Date(endDate)) {
                e.preventDefault();
                alert('Start date cannot be later than end date.');
                return false;
            }
        });
        
        // Search functionality
        function searchIndents() {
            const searchTerm = document.getElementById('docno').value.toLowerCase();
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
        
        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Purchase indent view page loaded');
        });
    </script>
</body>
</html>
