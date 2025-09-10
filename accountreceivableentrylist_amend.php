<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$sno = 0;
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

// Initialize search parameters
$searchdocno1 = isset($_GET['searchdocno']) ? $_GET['searchdocno'] : '';
$searchaccount1 = isset($_GET['searchaccount']) ? $_GET['searchaccount'] : '';
$fromdate1 = isset($_GET['fromdate']) ? $_GET['fromdate'] : $transactiondatefrom;
$todate1 = isset($_GET['todate']) ? $_GET['todate'] : $transactiondateto;

/////////////// FOR DELETE //////////////
if (isset($_REQUEST["del"])) { $del = $_REQUEST["del"]; } else { $del = ""; }
if($del != ''){
    $tbl = $_REQUEST['tbl'];
    $doc = $_REQUEST['docno'];
    $query_del1 = "UPDATE `$tbl` SET transactionamount = '0', cashamount ='0', onlineamount='0',creditamount='0',chequeamount='0',cardamount='0',mpesaamount='0',fxamount='0',receivableamount='0' WHERE docno LIKE '$doc'";
    $exec_del1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_del1) or die ("Error in Query_del1".mysqli_error($GLOBALS["___mysqli_ston"]));

    $query2 = "UPDATE `excel_insurance_upload` SET `status`='0' WHERE `docno`='$doc'";
    $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
    
    $query21 = "UPDATE `tb` SET `transaction_amount`='0' WHERE `doc_number`='$doc'";
    $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
    
    // Update the appropriate table based on the source
    $query21 = "UPDATE `consultation_radiology` SET `paymentstatus`='completed' WHERE `docno`='$doc'";
    $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
    
    // Redirect to refresh the page
    header("Location: accountreceivableentrylist_amend.php");
    exit();
}
/////////////// FOR DELETE //////////////

if (isset($_REQUEST["search_type"])) { $search_type = $_REQUEST["search_type"]; } else { $search_type = "0"; }  
if (isset($_REQUEST["frmflag_upload"])) { $frmflag_upload = $_REQUEST["frmflag_upload"]; } else { $frmflag_upload = ""; }

///////////////////// EXCEL //////// UPLOAD ////////
$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);

$locationname = $res["locationname"];
$locationcode123 = $res["locationcode"];
$locationcode = $res["locationcode"];
$res12locationanum = $res["auto_number"];

$locationcode = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';

function readCSV($csvFile){
    $file_handle = fopen($csvFile, 'r');
    while (!feof($file_handle) ) {
        $line_of_text[] = fgetcsv($file_handle, 1024);
    }
    fclose($file_handle);
    return $line_of_text;
}

// Get total records count for summary - using actual existing tables
// First, let's check which tables exist and count them individually
$total_records = 0;

// Count consultation_radiology
$query_rad = "SELECT COUNT(*) as count FROM consultation_radiology WHERE paymentstatus = 'pending'";
$exec_rad = mysqli_query($GLOBALS["___mysqli_ston"], $query_rad);
if ($exec_rad) {
    $res_rad = mysqli_fetch_array($exec_rad);
    $total_records += $res_rad['count'];
}

// Count billing_paylaterradiology (if table exists)
$query_paylater = "SELECT COUNT(*) as count FROM billing_paylaterradiology WHERE paymentstatus = 'pending'";
$exec_paylater = mysqli_query($GLOBALS["___mysqli_ston"], $query_paylater);
if ($exec_paylater) {
    $res_paylater = mysqli_fetch_array($exec_paylater);
    $total_records += $res_paylater['count'];
}

// Count billing_paynowradiology (if table exists)
$query_paynow = "SELECT COUNT(*) as count FROM billing_paynowradiology WHERE paymentstatus = 'pending'";
$exec_paynow = mysqli_query($GLOBALS["___mysqli_ston"], $query_paynow);
if ($exec_paynow) {
    $res_paynow = mysqli_fetch_array($exec_paynow);
    $total_records += $res_paynow['count'];
}

// Count billing_externalradiology (if table exists)
$query_external = "SELECT COUNT(*) as count FROM billing_externalradiology WHERE paymentstatus = 'pending'";
$exec_external = mysqli_query($GLOBALS["___mysqli_ston"], $query_external);
if ($exec_external) {
    $res_external = mysqli_fetch_array($exec_external);
    $total_records += $res_external['count'];
}

// Count billing_ipradiology (if table exists)
$query_ip = "SELECT COUNT(*) as count FROM billing_ipradiology WHERE paymentstatus = 'pending'";
$exec_ip = mysqli_query($GLOBALS["___mysqli_ston"], $query_ip);
if ($exec_ip) {
    $res_ip = mysqli_fetch_array($exec_ip);
    $total_records += $res_ip['count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Receivable Entry List - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/accountreceivableentrylist-modern.css?v=<?php echo time(); ?>">
    
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
        <span>Account Receivable Entry List</span>
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
                        <a href="amendallocations.php" class="nav-link">
                            <i class="fas fa-edit"></i>
                            <span>Amend Allocations</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="doctorentrylist.php" class="nav-link">
                            <i class="fas fa-user-md"></i>
                            <span>Doctor Entry List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="amendlistipdoctor.php" class="nav-link">
                            <i class="fas fa-stethoscope"></i>
                            <span>IP Doctor List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="amend_pending_ippharmacy.php" class="nav-link">
                            <i class="fas fa-pills"></i>
                            <span>IP Pharmacy</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="amend_pending_lab.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Services</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="listipmiscbilling.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>IP Misc Billing</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="amend_pending_radiology.php" class="nav-link">
                            <i class="fas fa-x-ray"></i>
                            <span>Radiology</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer">
                <?php if ($errmsg != ""): ?>
                <div class="alert alert-error">
                    <i class="alert-icon fas fa-exclamation-circle"></i>
                    <span><?php echo htmlspecialchars($errmsg); ?></span>
                </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>💰 Account Receivable Entry List</h2>
                    <p>Manage and review all account receivable transactions and entries</p>
                </div>
                <div class="page-header-actions">
                    <button onclick="exportToCSV()" class="btn btn-primary">
                        <i class="fas fa-download"></i> Export CSV
                    </button>
                    <button onclick="printPage()" class="btn btn-secondary">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>

            <!-- Search Form Section -->
            <div class="search-form-section">
                <div class="search-form-header">
                    <i class="search-form-icon fas fa-search"></i>
                    <h3 class="search-form-title">Search & Filter Options</h3>
                </div>
                
                <form id="searchForm" method="GET" action="">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="searchdocno" class="form-label">Document Number</label>
                            <input type="text" id="searchdocno" name="searchdocno" class="form-input" 
                                   value="<?php echo htmlspecialchars($searchdocno1); ?>" 
                                   placeholder="Enter document number">
                        </div>
                        
                        <div class="form-group">
                            <label for="searchaccount" class="form-label">Account Name</label>
                            <input type="text" id="searchaccount" name="searchaccount" class="form-input" 
                                   value="<?php echo htmlspecialchars($searchaccount1); ?>" 
                                   placeholder="Enter account name">
                        </div>
                        
                        <div class="form-group">
                            <label for="fromdate" class="form-label">From Date</label>
                            <input type="date" id="fromdate" name="fromdate" class="form-input" 
                                   value="<?php echo htmlspecialchars($fromdate1); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="todate" class="form-label">To Date</label>
                            <input type="date" id="todate" name="todate" class="form-input" 
                                   value="<?php echo htmlspecialchars($todate1); ?>">
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <a href="accountreceivableentrylist_amend.php" class="btn btn-outline">
                            <i class="fas fa-refresh"></i> Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Data Table Section -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="data-table-icon fas fa-table"></i>
                    <h3 class="data-table-title">Account Receivable Entries</h3>
                    <div class="table-summary">
                        <div class="summary-item">
                            <i class="fas fa-list"></i>
                            <span>Total Records: <strong id="totalRecords"><?php echo $total_records; ?></strong></span>
                        </div>
                    </div>
                </div>
                
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Document No.</th>
                                <th>Account Name</th>
                                <th>Sub Type</th>
                                <th>Transaction Amount</th>
                                <th>Cash Amount</th>
                                <th>Online Amount</th>
                                <th>Credit Amount</th>
                                <th>Cheque Amount</th>
                                <th>Card Amount</th>
                                <th>M-Pesa Amount</th>
                                <th>FX Amount</th>
                                <th>Receivable Amount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="accountReceivableTableBody">
                            <?php
                            // Build comprehensive query using actual existing tables
                            // Start with consultation_radiology
                            $query = "SELECT 
                                'consultation_radiology' as source_table,
                                docno,
                                patientname as accountname,
                                'Radiology Consultation' as subtype,
                                radiologyitemrate as transactionamount,
                                radiologyitemrate as receivableamount,
                                consultationdate as transactiondate,
                                'pending' as recordstatus
                            FROM consultation_radiology 
                            WHERE paymentstatus = 'pending' 
                            AND (docno LIKE '%$searchdocno1%' OR '$searchdocno1' = '')
                            AND (patientname LIKE '%$searchaccount1%' OR '$searchaccount1' = '')
                            AND (consultationdate >= '$fromdate1' OR '$fromdate1' = '')
                            AND (consultationdate <= '$todate1' OR '$todate1' = '')";
                            
                            // Add billing_paylaterradiology if table exists
                            $check_paylater = mysqli_query($GLOBALS["___mysqli_ston"], "SHOW TABLES LIKE 'billing_paylaterradiology'");
                            if (mysqli_num_rows($check_paylater) > 0) {
                                $query .= " UNION ALL SELECT 
                                    'billing_paylaterradiology' as source_table,
                                    billnumber as docno,
                                    patientname as accountname,
                                    'Pay Later Radiology' as subtype,
                                    fxamount as transactionamount,
                                    fxamount as receivableamount,
                                    billdate as transactiondate,
                                    'pending' as recordstatus
                                FROM billing_paylaterradiology 
                                WHERE paymentstatus = 'pending'
                                AND (billnumber LIKE '%$searchdocno1%' OR '$searchdocno1' = '')
                                AND (patientname LIKE '%$searchaccount1%' OR '$searchaccount1' = '')
                                AND (billdate >= '$fromdate1' OR '$fromdate1' = '')
                                AND (billdate <= '$todate1' OR '$todate1' = '')";
                            }
                            
                            // Add billing_paynowradiology if table exists
                            $check_paynow = mysqli_query($GLOBALS["___mysqli_ston"], "SHOW TABLES LIKE 'billing_paynowradiology'");
                            if (mysqli_num_rows($check_paynow) > 0) {
                                $query .= " UNION ALL SELECT 
                                    'billing_paynowradiology' as source_table,
                                    billnumber as docno,
                                    patientname as accountname,
                                    'Pay Now Radiology' as subtype,
                                    radiologyitemrate as transactionamount,
                                    radiologyitemrate as receivableamount,
                                    billdate as transactiondate,
                                    'pending' as recordstatus
                                FROM billing_paynowradiology 
                                WHERE paymentstatus = 'pending'
                                AND (billnumber LIKE '%$searchdocno1%' OR '$searchdocno1' = '')
                                AND (patientname LIKE '%$searchaccount1%' OR '$searchaccount1' = '')
                                AND (billdate >= '$fromdate1' OR '$fromdate1' = '')
                                AND (billdate <= '$todate1' OR '$todate1' = '')";
                            }
                            
                            // Add billing_externalradiology if table exists
                            $check_external = mysqli_query($GLOBALS["___mysqli_ston"], "SHOW TABLES LIKE 'billing_externalradiology'");
                            if (mysqli_num_rows($check_external) > 0) {
                                $query .= " UNION ALL SELECT 
                                    'billing_externalradiology' as source_table,
                                    billnumber as docno,
                                    patientname as accountname,
                                    'External Radiology' as subtype,
                                    fxamount as transactionamount,
                                    fxamount as receivableamount,
                                    billdate as transactiondate,
                                    'pending' as recordstatus
                                FROM billing_externalradiology 
                                WHERE paymentstatus = 'pending'
                                AND (billnumber LIKE '%$searchdocno1%' OR '$searchdocno1' = '')
                                AND (patientname LIKE '%$searchaccount1%' OR '$searchaccount1' = '')
                                AND (billdate >= '$fromdate1' OR '$fromdate1' = '')
                                AND (billdate <= '$todate1' OR '$todate1' = '')";
                            }
                            
                            // Add billing_ipradiology if table exists
                            $check_ip = mysqli_query($GLOBALS["___mysqli_ston"], "SHOW TABLES LIKE 'billing_ipradiology'");
                            if (mysqli_num_rows($check_ip) > 0) {
                                $query .= " UNION ALL SELECT 
                                    'billing_ipradiology' as source_table,
                                    billnumber as docno,
                                    patientname as accountname,
                                    'IP Radiology' as subtype,
                                    fxamount as transactionamount,
                                    fxamount as receivableamount,
                                    billdate as transactiondate,
                                    'pending' as recordstatus
                                FROM billing_ipradiology 
                                WHERE paymentstatus = 'pending'
                                AND (billnumber LIKE '%$searchdocno1%' OR '$searchdocno1' = '')
                                AND (patientname LIKE '%$searchaccount1%' OR '$searchaccount1' = '')
                                AND (billdate >= '$fromdate1' OR '$fromdate1' = '')
                                AND (billdate <= '$todate1' OR '$todate1' = '')";
                            }
                            
                            $query .= " ORDER BY transactiondate DESC";
                            
                            $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query);
                            if (!$exec) {
                                // If the main query fails, try just the consultation_radiology table
                                $query_fallback = "SELECT 
                                    'consultation_radiology' as source_table,
                                    docno,
                                    patientname as accountname,
                                    'Radiology Consultation' as subtype,
                                    radiologyitemrate as transactionamount,
                                    radiologyitemrate as receivableamount,
                                    consultationdate as transactiondate,
                                    'pending' as recordstatus
                                FROM consultation_radiology 
                                WHERE paymentstatus = 'pending' 
                                AND (docno LIKE '%$searchdocno1%' OR '$searchdocno1' = '')
                                AND (patientname LIKE '%$searchaccount1%' OR '$searchaccount1' = '')
                                AND (consultationdate >= '$fromdate1' OR '$fromdate1' = '')
                                AND (consultationdate <= '$todate1' OR '$todate1' = '')
                                ORDER BY consultationdate DESC";
                                
                                $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query_fallback);
                                if (!$exec) {
                                    die("Error in fallback query: " . mysqli_error($GLOBALS["___mysqli_ston"]));
                                }
                            }
                            
                            $sno = 0;
                            $total_amount = 0;
                            while ($res = mysqli_fetch_array($exec)) {
                                $sno++;
                                $docno = $res["docno"];
                                $accountname = $res["accountname"];
                                $subtype = $res["subtype"];
                                $transactionamount = $res["transactionamount"];
                                $cashamount = "0.00"; // Not available in these tables
                                $onlineamount = "0.00"; // Not available in these tables
                                $creditamount = "0.00"; // Not available in these tables
                                $chequeamount = "0.00"; // Not available in these tables
                                $cardamount = "0.00"; // Not available in these tables
                                $mpesaamount = "0.00"; // Not available in these tables
                                $fxamount = "0.00"; // Not available in these tables
                                $receivableamount = $res["receivableamount"];
                                $recorddate = $res["transactiondate"];
                                $source_table = $res["source_table"];
                                
                                $total_amount += $receivableamount;
                                $row_class = $sno % 2 == 0 ? 'even-row' : 'odd-row';
                            ?>
                            <tr class="<?php echo $row_class; ?>">
                                <td>
                                    <span class="serial-number"><?php echo $sno; ?></span>
                                </td>
                                <td>
                                    <span class="docno-badge"><?php echo htmlspecialchars($docno); ?></span>
                                </td>
                                <td>
                                    <span class="account-name"><?php echo htmlspecialchars($accountname); ?></span>
                                </td>
                                <td>
                                    <span class="subtype-badge"><?php echo htmlspecialchars($subtype); ?></span>
                                </td>
                                <td class="amount-cell amount-positive">
                                    <?php echo number_format($transactionamount, 2); ?>
                                </td>
                                <td class="amount-cell amount-positive">
                                    <?php echo number_format($cashamount, 2); ?>
                                </td>
                                <td class="amount-cell amount-positive">
                                    <?php echo number_format($onlineamount, 2); ?>
                                </td>
                                <td class="amount-cell amount-positive">
                                    <?php echo number_format($creditamount, 2); ?>
                                </td>
                                <td class="amount-cell amount-positive">
                                    <?php echo number_format($chequeamount, 2); ?>
                                </td>
                                <td class="amount-cell amount-positive">
                                    <?php echo number_format($cardamount, 2); ?>
                                </td>
                                <td class="amount-cell amount-positive">
                                    <?php echo number_format($mpesaamount, 2); ?>
                                </td>
                                <td class="amount-cell amount-positive">
                                    <?php echo number_format($fxamount, 2); ?>
                                </td>
                                <td class="amount-cell amount-positive">
                                    <?php echo number_format($receivableamount, 2); ?>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn edit" 
                                                onclick="editEntry('<?php echo htmlspecialchars($docno); ?>', '<?php echo htmlspecialchars($source_table); ?>')"
                                                title="Edit Entry">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="action-btn delete" 
                                                onclick="deleteEntry('<?php echo htmlspecialchars($docno); ?>', '<?php echo htmlspecialchars($source_table); ?>')"
                                                title="Delete Entry">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <button class="action-btn print" 
                                                onclick="printEntry('<?php echo htmlspecialchars($docno); ?>')"
                                                title="Print Entry">
                                            <i class="fas fa-print"></i>
                                        </button>
                                        <button class="action-btn view" 
                                                onclick="viewEntry('<?php echo htmlspecialchars($docno); ?>', '<?php echo htmlspecialchars($source_table); ?>')"
                                                title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php 
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($sno == 0): ?>
                <div class="no-data-message">
                    <i class="fas fa-info-circle"></i>
                    <p>No account receivable entries found for the selected criteria.</p>
                    <p>Try adjusting your search parameters or date range.</p>
                </div>
                <?php endif; ?>

                <!-- Pagination Container -->
                <div id="paginationContainer" class="pagination-container"></div>

                <!-- Summary Footer -->
                <div class="table-summary-footer">
                    <div class="summary-stats">
                        <div class="stat-item">
                            <i class="fas fa-list"></i>
                            <span>Total Entries: <strong><?php echo $sno; ?></strong></span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-calendar"></i>
                            <span>Date Range: <strong><?php echo htmlspecialchars($fromdate1); ?></strong> to <strong><?php echo htmlspecialchars($todate1); ?></strong></span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Total Amount: <strong class="stat-number">$<?php echo number_format($total_amount, 2); ?></strong></span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/accountreceivableentrylist-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy Functions -->
    <script type="text/javascript">
        function viewEntry(docno, sourceTable) {
            // This would normally open a modal or navigate to a view page
            console.log('Viewing entry:', docno, 'from table:', sourceTable);
            alert('Viewing entry: ' + docno + ' from ' + sourceTable);
        }
        
        function editEntry(docno, sourceTable) {
            // This would normally open an edit form or navigate to an edit page
            console.log('Editing entry:', docno, 'from table:', sourceTable);
            alert('Editing entry: ' + docno + ' from ' + sourceTable);
        }
        
        function deleteEntry(docno, sourceTable) {
            if (confirm('Are you sure you want to delete this entry? This action cannot be undone.')) {
                // Create a form to submit the delete request
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'accountreceivableentrylist_amend.php';
                
                const delInput = document.createElement('input');
                delInput.type = 'hidden';
                delInput.name = 'del';
                delInput.value = '1';
                form.appendChild(delInput);
                
                const tblInput = document.createElement('input');
                tblInput.type = 'hidden';
                tblInput.name = 'tbl';
                tblInput.value = sourceTable;
                form.appendChild(tblInput);
                
                const docnoInput = document.createElement('input');
                docnoInput.type = 'hidden';
                docnoInput.name = 'docno';
                docnoInput.value = docno;
                form.appendChild(docnoInput);
                
                document.body.appendChild(form);
                form.submit();
            }
        }
        
        function printEntry(docno) {
            // This would normally open a print window or navigate to a print page
            console.log('Printing entry:', docno);
            alert('Printing entry: ' + docno);
        }
        
        function exportToCSV() {
            // This would normally export the table data to CSV
            console.log('Exporting to CSV...');
            alert('CSV export functionality will be implemented here');
        }
        
        function printPage() {
            window.print();
        }
        
        // Update total records count
        document.addEventListener('DOMContentLoaded', function() {
            const totalRecords = document.getElementById('totalRecords');
            if (totalRecords) {
                const rows = document.querySelectorAll('#accountReceivableTableBody tr');
                totalRecords.textContent = rows.length;
            }
        });
    </script>
</body>
</html>
