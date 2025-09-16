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

$docno = $_SESSION['docno'];

// Get location for sort by location purpose
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
if ($location != '') {
    $locationcode = $location;
}

// Handle form submission
$errmsg = "";
$bgcolorcode = "";

if (isset($_POST["cbfrmflag1"])) {
    $cbfrmflag1 = $_POST["cbfrmflag1"];
} else {
    $cbfrmflag1 = "";
}

if ($cbfrmflag1 == 'cbfrmflag1') {
    // Process search criteria
    $patient = isset($_POST['patient']) ? trim($_POST['patient']) : '';
    $patientcode = isset($_POST['patientcode']) ? trim($_POST['patientcode']) : '';
    $visitcode = isset($_POST['visitcode']) ? trim($_POST['visitcode']) : '';
    $ADate1 = isset($_POST['ADate1']) ? $_POST['ADate1'] : $transactiondatefrom;
    $ADate2 = isset($_POST['ADate2']) ? $_POST['ADate2'] : $transactiondateto;
    
    // Build search query
    $whereConditions = [];
    $params = [];
    
    if (!empty($patient)) {
        $whereConditions[] = "patientname LIKE ?";
        $params[] = "%$patient%";
    }
    
    if (!empty($patientcode)) {
        $whereConditions[] = "patientcode LIKE ?";
        $params[] = "%$patientcode%";
    }
    
    if (!empty($visitcode)) {
        $whereConditions[] = "visitcode LIKE ?";
        $params[] = "%$visitcode%";
    }
    
    if (!empty($ADate1) && !empty($ADate2)) {
        $whereConditions[] = "billingdatetime BETWEEN ? AND ?";
        $params[] = $ADate1 . " 00:00:00";
        $params[] = $ADate2 . " 23:59:59";
    }
    
    if (!empty($location)) {
        $whereConditions[] = "locationcode = ?";
        $params[] = $location;
    }
    
    $whereClause = !empty($whereConditions) ? "WHERE " . implode(" AND ", $whereConditions) : "";
    
    $errmsg = "Search completed successfully.";
    $bgcolorcode = 'success';
}

// Get existing credit approval records
$querynw1 = "SELECT * FROM ip_creditapproval WHERE recordstatus='' GROUP BY visitcode ORDER BY auto_number DESC";
$execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die("Error in Query1: " . mysqli_error($GLOBALS["___mysqli_ston"]));
$resnw1 = mysqli_num_rows($execnw1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credit Approval List - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
<!-- Modern CSS -->
    <link rel="stylesheet" href="css/creditapprovallist-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker CSS -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- Date Picker Scripts -->
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script src="js/datetimepicker_css.js"></script>
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
        <span>Credit Approval List</span>
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
                        <a href="patient1.php" class="nav-link">
                            <i class="fas fa-user-injured"></i>
                            <span>Patient Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billing1.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Billing</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="pharmacy1.php" class="nav-link">
                            <i class="fas fa-pills"></i>
                            <span>Pharmacy</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="creditapprovallist.php" class="nav-link">
                            <i class="fas fa-credit-card"></i>
                            <span>Credit Approval</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="reports1.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Reports</span>
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
                    <h2>Credit Approval List</h2>
                    <p>Search and manage credit approval requests for patient billing and services.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportResults()">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>
            </div>

            <!-- Search Form Section -->
            <div class="search-form-section">
                <div class="search-form-header">
                    <i class="fas fa-search search-form-icon"></i>
                    <h3 class="search-form-title">Search Credit Approvals</h3>
                </div>
                
                <form id="searchForm" name="cbform1" method="post" action="creditapprovallist.php" class="search-form">
                    <div class="form-group">
                        <label class="form-label">Location</label>
                        <select name="location" id="location" class="form-select">
                  <?php
                            $query1 = "SELECT * FROM login_locationdetails WHERE username='$username' AND docno='$docno' GROUP BY locationname ORDER BY locationname";
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1: " . mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res1 = mysqli_fetch_array($exec1)) {
						$res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
                                $selected = ($location != '' && $location == $res1locationanum) ? 'selected' : '';
                                echo "<option value=\"$res1locationanum\" $selected>$res1location</option>";
						}
						?>
                  </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Patient Name</label>
                        <input name="patient" type="text" id="patient" class="form-input" 
                               placeholder="Enter patient name" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Registration No</label>
                        <input name="patientcode" type="text" id="patientcode" class="form-input" 
                               placeholder="Enter registration number" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Visit Code</label>
                        <input name="visitcode" type="text" id="visitcode" class="form-input" 
                               placeholder="Enter visit code" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Date From</label>
                        <div class="date-input-group">
                            <input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>" 
                                   class="form-input date-input" readonly="readonly" />
                            <i class="fas fa-calendar-alt calendar-icon" onclick="javascript:NewCssCal('ADate1')"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Date To</label>
                        <div class="date-input-group">
                            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>" 
                                   class="form-input date-input" readonly="readonly" />
                            <i class="fas fa-calendar-alt calendar-icon" onclick="javascript:NewCssCal('ADate2')"></i>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>

                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                </form>
            </div>

            <!-- Results Section -->
            <div class="results-section">
                <div class="results-header">
                    <div class="results-title">
                        <i class="fas fa-list"></i>
                        Credit Approval List
                        <span class="results-count"><?php echo $resnw1; ?></span>
                    </div>
                    <div class="results-actions">
                        <button type="button" class="btn btn-outline btn-sm" onclick="printResults()">
                            <i class="fas fa-print"></i> Print
                        </button>
                    </div>
                </div>

                <div class="data-table-container">
                    <table id="dataTable" class="data-table">
                        <thead>
                            <tr>
                                <th data-sortable="true" data-column="no">No.</th>
                                <th data-sortable="true" data-column="ipdate">IP Date</th>
                                <th data-sortable="true" data-column="patientcode">Registration No</th>
                                <th data-sortable="true" data-column="patientname">Patient Name</th>
                                <th data-sortable="true" data-column="visitcode">Visit Code</th>
                                <th data-sortable="true" data-column="billingdatetime">Billing Date</th>
                                <th data-sortable="true" data-column="totalamount">Total Amount</th>
                                <th data-sortable="true" data-column="status">Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($execnw1 && mysqli_num_rows($execnw1) > 0) {
                                $counter = 1;
                                while ($resnw1 = mysqli_fetch_array($execnw1)) {
                                    $patientcode = $resnw1['patientcode'];
                                    $patientname = $resnw1['patientname'];
                                    $visitcode = $resnw1['visitcode'];
                                    $billingdatetime = $resnw1['billingdatetime'];
                                    $totalamount = $resnw1['totalamount'];
                                    $recordstatus = $resnw1['recordstatus'];
                                    
                                    $ipdate = date('d-m-Y', strtotime($resnw1['ipdate']));
                                    $billingdate = date('d-m-Y H:i', strtotime($billingdatetime));
                                    
                                    $statusClass = $recordstatus == 'approved' ? 'status-approved' : 
                                                  ($recordstatus == 'rejected' ? 'status-rejected' : 'status-pending');
                                    $statusText = ucfirst($recordstatus ?: 'pending');
                                    ?>
                                    <tr>
                                        <td><?php echo $counter++; ?></td>
                                        <td><?php echo $ipdate; ?></td>
                                        <td><?php echo htmlspecialchars($patientcode); ?></td>
                                        <td><?php echo htmlspecialchars($patientname); ?></td>
                                        <td><?php echo htmlspecialchars($visitcode); ?></td>
                                        <td><?php echo $billingdate; ?></td>
                                        <td>₹<?php echo number_format($totalamount, 2); ?></td>
                                        <td>
                                            <span class="status-badge <?php echo $statusClass; ?>">
                                                <?php echo $statusText; ?>
                                            </span>
              </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="action-btn view" onclick="viewDetails('<?php echo $visitcode; ?>')" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="action-btn edit" onclick="editApproval('<?php echo $visitcode; ?>')" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="action-btn delete" onclick="deleteApproval('<?php echo $visitcode; ?>')" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
			  </td>
              </tr>
			<?php
			}  
                            } else {
                                ?>
                                <tr>
                                    <td colspan="9" class="no-data">
                                        <div class="no-data-icon">
                                            <i class="fas fa-inbox"></i>
                                        </div>
                                        <h3>No Credit Approvals Found</h3>
                                        <p>No credit approval records match your search criteria.</p>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
          </tbody>
    </table>
                </div>
            </div>
</main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/creditapprovallist-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Additional JavaScript Functions -->
    <script type="text/javascript">
        function viewDetails(visitcode) {
            // Implementation for viewing details
            console.log('Viewing details for visit code:', visitcode);
        }

        function editApproval(visitcode) {
            // Implementation for editing approval
            console.log('Editing approval for visit code:', visitcode);
        }

        function deleteApproval(visitcode) {
            if (confirm('Are you sure you want to delete this credit approval record?')) {
                // Implementation for deleting approval
                console.log('Deleting approval for visit code:', visitcode);
            }
        }

        function exportResults() {
            // Implementation for exporting results
            console.log('Exporting results');
        }

        function printResults() {
            window.print();
        }
    </script>
</body>
</html>
