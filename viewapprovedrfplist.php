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

// Get RFP count
$query1 = "select * from purchase_rfqrequest where approvalstatus='approved' and grandapprovalstatus='' group by docno";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$resnw3 = mysqli_num_rows($exec1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved RFP List - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/viewapprovedrfplist-modern.css?v=<?php echo time(); ?>">
    
    <!-- Date picker styles -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
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
        <span>Approved RFP List</span>
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
                        <a href="vat.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            <span>VAT Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipamendser_pending.php" class="nav-link">
                            <i class="fas fa-cogs"></i>
                            <span>IP Service Pending</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="analyzerresults.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Results</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="analyzecomparison.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Analyze Comparison</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="employeepayrollreport2.php" class="nav-link">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Payroll Report</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="viewapprovedrfplist.php" class="nav-link">
                            <i class="fas fa-file-contract"></i>
                            <span>Approved RFPs</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="amend_pending_lab.php" class="nav-link">
                            <i class="fas fa-microscope"></i>
                            <span>Pending Lab</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="amend_pending_ippharmacy.php" class="nav-link">
                            <i class="fas fa-pills"></i>
                            <span>Pending Pharmacy</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="amend_pending_radiology.php" class="nav-link">
                            <i class="fas fa-x-ray"></i>
                            <span>Pending Radiology</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer">
                <?php include ("includes/alertmessages1.php"); ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2><i class="fas fa-file-contract"></i> Approved RFP List</h2>
                    <p>View and manage approved Request for Proposal (RFP) documents</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button class="btn btn-secondary" onclick="printPage()">
                        <i class="fas fa-print"></i> Print
                    </button>
                    <button class="btn btn-primary" onclick="exportToPDF()">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </button>
                </div>
            </div>

            <!-- RFP List Section -->
            <div class="rfp-list-section">
                <div class="rfp-list-header">
                    <h3>
                        <i class="fas fa-file-contract"></i>
                        Approved RFPs
                        <span class="rfp-count"><?php echo $resnw3; ?></span>
                    </h3>
                    <div class="rfp-list-actions">
                        <button class="btn btn-secondary" onclick="exportToExcel()">
                            <i class="fas fa-file-excel"></i> Excel
                        </button>
                        <button class="btn btn-secondary" onclick="resetFilters()">
                            <i class="fas fa-undo"></i> Reset Filters
                        </button>
                    </div>
                </div>

                <!-- Search and Filter Section -->
                <div class="search-filter-section">
                    <div class="search-filter-grid">
                        <div class="search-group">
                            <label for="searchInput" class="search-label">Search RFPs</label>
                            <input type="text" id="searchInput" class="search-input" 
                                   placeholder="Search by document number, user, or status...">
                        </div>
                        
                        <div class="search-group">
                            <label for="dateFrom" class="search-label">Date From</label>
                            <input type="date" id="dateFrom" class="search-input" 
                                   value="<?php echo $transactiondatefrom; ?>">
                        </div>
                        
                        <div class="search-group">
                            <label for="dateTo" class="search-label">Date To</label>
                            <input type="date" id="dateTo" class="search-input" 
                                   value="<?php echo $transactiondateto; ?>">
                        </div>
                        
                        <div class="search-actions">
                            <button type="button" class="btn btn-secondary" id="clearBtn">
                                <i class="fas fa-times"></i> Clear
                            </button>
                        </div>
                    </div>
                    
                    <div style="margin-top: 1rem;">
                        <span id="searchResults" style="color: var(--text-secondary); font-size: 0.875rem;">
                            Showing <?php echo $resnw3; ?> approved RFPs
                        </span>
                    </div>
                </div>

                <!-- RFP Table -->
                <div class="rfp-table-container">
                    <table class="rfp-table" id="rfpTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Date</th>
                                <th>From</th>
                                <th>DOC No</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $colorloopcount = '';
                            $sno = '';
                            
                            $triagedatefrom = date('Y-m-d', strtotime('-2 day'));
                            $triagedateto = date('Y-m-d');
                            
                            $query1 = "select * from purchase_rfqrequest where approvalstatus='approved' and grandapprovalstatus='' group by docno";
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            if (mysqli_num_rows($exec1) > 0):
                                while ($res1 = mysqli_fetch_array($exec1)):
                                    $date = $res1['date'];
                                    $user = $res1['username'];
                                    $status = $res1['status'];
                                    $docno = $res1['docno'];
                                    
                                    $colorloopcount = $colorloopcount + 1;
                                    $showcolor = ($colorloopcount & 1); 
                                    
                                    if ($showcolor == 0) {
                                        $colorcode = 'bgcolor="#CBDBFA"';
                                    } else {
                                        $colorcode = 'bgcolor="#ecf0f5"';
                                    }
                            ?>
                            <tr <?php echo $colorcode; ?> data-docno="<?php echo htmlspecialchars($docno); ?>">
                                <td class="rfp-number"><?php echo $sno = $sno + 1; ?></td>
                                <td class="rfp-date"><?php echo htmlspecialchars($date); ?></td>
                                <td class="rfp-user"><?php echo htmlspecialchars($user); ?></td>
                                <td class="rfp-docno"><?php echo htmlspecialchars($docno); ?></td>
                                <td>
                                    <span class="rfp-status <?php echo strtolower($status) === 'approved' ? 'approved' : 'pending'; ?>">
                                        <?php echo htmlspecialchars($status); ?>
                                    </span>
                                </td>
                                <td class="rfp-action">
                                    <a href="viewapprovedrfp.php?docno=<?php echo urlencode($docno); ?>" 
                                       class="view-btn" data-docno="<?php echo htmlspecialchars($docno); ?>">
                                        <i class="fas fa-eye"></i> VIEW
                                    </a>
                                </td>
                            </tr>
                            <?php 
                                endwhile;
                            else:
                            ?>
                            <tr>
                                <td colspan="6" class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="fas fa-file-contract"></i>
                                    </div>
                                    <div class="empty-state-title">No Approved RFPs Found</div>
                                    <div class="empty-state-description">
                                        There are currently no approved RFP documents to display.
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Summary Section -->
                <div class="summary-section">
                    <div class="summary-grid">
                        <div class="summary-item">
                            <span class="summary-label">Total Approved RFPs</span>
                            <span class="summary-value summary-approved"><?php echo $resnw3; ?></span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Date Range</span>
                            <span class="summary-value"><?php echo date('M d, Y', strtotime($transactiondatefrom)); ?> - <?php echo date('M d, Y', strtotime($transactiondateto)); ?></span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Last Updated</span>
                            <span class="summary-value"><?php echo date('M d, Y H:i', strtotime($updatedatetime)); ?></span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Generated By</span>
                            <span class="summary-value"><?php echo htmlspecialchars($username); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/viewapprovedrfplist-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy scripts for compatibility -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    
    <script language="javascript">
        function cbcustomername1() {
            document.cbform1.submit();
        }

        function pharmacy(patientcode, visitcode) {
            var patientcode = patientcode;
            var visitcode = visitcode;
            var url = "pharmacy1.php?RandomKey=" + Math.random() + "&&patientcode=" + patientcode + "&&visitcode=" + visitcode;
            window.open(url, "Pharmacy", 'width=600,height=400');
        }

        function disableEnterKey(varPassed) {
            if (event.keyCode == 8) {
                event.keyCode = 0; 
                return event.keyCode 
                return false;
            }
            
            var key;
            if (window.event) {
                key = window.event.keyCode;     //IE
            } else {
                key = e.which;     //firefox
            }

            if (key == 13) // if enter key press
            {
                return false;
            } else {
                return true;
            }
        }

        function printbillreport1() {
            window.open("print_collectionpendingreport1hospital.php?<?php echo $urlpath; ?>", "Window1", 'width=900,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
        }

        function printbillreport2() {
            window.location = "dbexcelfiles/CollectionPendingByPatientHospital.xls"
        }
    </script>
</body>
</html>



