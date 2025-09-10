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
$colorloopcount = "";

$docno = $_SESSION['docno'];

// Get default location
$query = "select * from master_location where status <> 'deleted' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);

$locationname = $res["locationname"];
$locationcode = $res["locationcode"];
$res12locationanum = $res["auto_number"];

// Get location for sort by location purpose
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
if ($location != '') {
    $locationcode = $location;
}

// Handle form submission
if (isset($_POST["frmflag1"])) { 
    $frmflag1 = $_POST["frmflag1"]; 
} else { 
    $frmflag1 = ""; 
}

if ($frmflag1 == 'frmflag1') {
    $patientcode = $_REQUEST["patientcode"];
    $patientname = $_REQUEST["patientname"];
    $accountname = $_REQUEST["accname"];
    $visitcode = $_REQUEST["visitcode"];
    $billdate = $_REQUEST["billdate"];
    $paymentmode = $_REQUEST["paymentmode"];
    $remarks = $_REQUEST["remarks"];
    $totalamount = $_REQUEST["totalamount"];
    
    // Validate required fields
    if (empty($patientcode) || empty($accountname) || empty($visitcode) || empty($totalamount)) {
        $errmsg = "Failed. All required fields must be filled.";
        $bgcolorcode = 'failed';
    } else {
        // Get location details
        $query1 = "select * from master_location where status <> 'deleted' and locationcode = '".$locationcode."'";
        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res1 = mysqli_fetch_array($exec1);
        $locationname = $res1["locationname"];
        
        // Generate document number
        $query2 = "SELECT * from master_transactionadvancedeposit order by auto_number desc limit 1";
        $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res2 = mysqli_fetch_array($exec2);
        
        if ($res2) {
            $lastdocno = $res2["docno"];
            $docnumber = intval(substr($lastdocno, 4)) + 1;
        } else {
            $docnumber = 1;
        }
        
        $docno = "ADV-" . $docnumber;
        
        // Insert advance deposit record
        $query3 = "INSERT INTO master_transactionadvancedeposit (docno, patientcode, patientname, accountname, visitcode, billdate, paymentmode, remarks, totalamount, locationcode, created_at, record_status, user_id, ip_address) VALUES ('$docno', '$patientcode', '$patientname', '$accountname', '$visitcode', '$billdate', '$paymentmode', '$remarks', '$totalamount', '$locationcode', '$updatedatetime', '1', '$username', '$ipaddress')";
        
        $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
        
        if ($exec3) {
            $errmsg = "Success. Advance Deposit Added.";
            $bgcolorcode = 'success';
        } else {
            $errmsg = "Failed. Could not add advance deposit.";
            $bgcolorcode = 'failed';
        }
    }
}

// Handle delete action
if (isset($_REQUEST["st"])) { 
    $st = $_REQUEST["st"]; 
} else { 
    $st = ""; 
}

if ($st == 'del') {
    $delanum = $_REQUEST["anum"];
    $query3 = "UPDATE master_transactionadvancedeposit set record_status = '0' where auto_number = '$delanum'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
    header("Location: advancedeposit.php?msg=deleted");
    exit();
}

if ($st == 'activate') {
    $delanum = $_REQUEST["anum"];
    $query3 = "UPDATE master_transactionadvancedeposit set record_status = '1' where auto_number = '$delanum'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
    header("Location: advancedeposit.php?msg=activated");
    exit();
}

// Check for URL messages
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'deleted') {
        $errmsg = "Advance deposit deleted successfully.";
        $bgcolorcode = 'success';
    } elseif ($_GET['msg'] == 'activated') {
        $errmsg = "Advance deposit activated successfully.";
        $bgcolorcode = 'success';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advance Deposit - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/advancedeposit-modern.css?v=<?php echo time(); ?>">
    
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
        <span>Advance Deposit</span>
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
                        <a href="patiententry.php" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>New Patient</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="patientlist.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Patient List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="visitentry.php" class="nav-link">
                            <i class="fas fa-calendar-check"></i>
                            <span>Visit Entry</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="advancedeposit.php" class="nav-link">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Advance Deposit</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billing.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Billing</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="payment.php" class="nav-link">
                            <i class="fas fa-credit-card"></i>
                            <span>Payment</span>
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
                    <h2>Advance Deposit</h2>
                    <p>Process advance deposits for patients with multiple payment options.</p>
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

            <!-- Add Form Section -->
            <div class="add-form-section">
                <div class="add-form-header">
                    <i class="fas fa-plus-circle add-form-icon"></i>
                    <h3 class="add-form-title">Add New Advance Deposit</h3>
                </div>
                
                <form id="depositForm" name="form1" method="post" action="advancedeposit.php" class="add-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" class="form-input" onchange="ajaxlocationfunction(this.value)">
                                <?php
                                $query1 = "select * from master_location where status <> 'deleted' order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $res1location = $res1["locationname"];
                                    $res1locationanum = $res1["locationcode"];
                                    $selected = ($location != '' && $location == $res1locationanum) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $res1locationanum; ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($res1location); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="patientcode" class="form-label">Patient Code</label>
                            <input type="text" name="patientcode" id="patientcode" class="form-input" 
                                   placeholder="Enter patient code" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="patientname" class="form-label">Patient Name</label>
                            <input type="text" name="patientname" id="patientname" class="form-input" 
                                   placeholder="Enter patient name" required>
                        </div>

                        <div class="form-group">
                            <label for="accname" class="form-label">Account Name</label>
                            <input type="text" name="accname" id="accname" class="form-input" 
                                   placeholder="Enter account name" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="visitcode" class="form-label">Visit Code</label>
                            <input type="text" name="visitcode" id="visitcode" class="form-input" 
                                   placeholder="Enter visit code" required>
                        </div>

                        <div class="form-group">
                            <label for="billdate" class="form-label">Bill Date</label>
                            <input type="date" name="billdate" id="billdate" class="form-input" 
                                   value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="paymentmode" class="form-label">Payment Mode</label>
                            <select name="paymentmode" id="paymentmode" class="form-input" required>
                                <option value="">--Select Payment Mode--</option>
                                <option value="Cash">Cash</option>
                                <option value="Cheque">Cheque</option>
                                <option value="Card">Card</option>
                                <option value="MPESA">MPESA</option>
                                <option value="Online">Online</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="totalamount" class="form-label">Total Amount</label>
                            <input type="number" name="totalamount" id="totalamount" class="form-input" 
                                   placeholder="0.00" step="0.01" min="0" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea name="remarks" id="remarks" class="form-input" rows="3" 
                                  placeholder="Enter any additional notes..."></textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit" id="submitBtn" class="submit-btn">
                            <i class="fas fa-save"></i>
                            Add Advance Deposit
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>

                    <input type="hidden" name="frmflag1" value="frmflag1">
                </form>
            </div>

            <!-- Data Table Section -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-list data-table-icon"></i>
                    <h3 class="data-table-title">Existing Advance Deposit Records</h3>
                </div>

                <!-- Search Bar -->
                <div style="margin-bottom: 1rem;">
                    <div style="display: flex; gap: 1rem; align-items: center;">
                        <input type="text" id="searchInput" class="form-input" 
                               placeholder="Search patient code, name, or visit code..." 
                               style="flex: 1; max-width: 300px;"
                               oninput="searchDeposits(this.value)">
                        <button type="button" class="btn btn-secondary" onclick="clearSearch()">
                            <i class="fas fa-times"></i> Clear
                        </button>
                    </div>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Document No</th>
                            <th>Patient Code</th>
                            <th>Patient Name</th>
                            <th>Account Name</th>
                            <th>Visit Code</th>
                            <th>Bill Date</th>
                            <th>Payment Mode</th>
                            <th>Total Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="depositTableBody">
                        <?php
                        $query1 = "SELECT * from master_transactionadvancedeposit where record_status <> '0' order by auto_number desc";
                        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $colorloopcount = 0;
                        
                        while ($res1 = mysqli_fetch_array($exec1)) {
                            $docno = $res1["docno"];
                            $auto_number = $res1["auto_number"];
                            $patientcode = $res1["patientcode"];
                            $patientname = $res1["patientname"];
                            $accountname = $res1["accountname"];
                            $visitcode = $res1["visitcode"];
                            $billdate = $res1["billdate"];
                            $paymentmode = $res1["paymentmode"];
                            $totalamount = $res1["totalamount"];
                            $colorloopcount++;
                            ?>
                            <tr>
                                <td><?php echo $colorloopcount; ?></td>
                                <td>
                                    <span class="docno-badge"><?php echo htmlspecialchars($docno); ?></span>
                                </td>
                                <td><?php echo htmlspecialchars($patientcode); ?></td>
                                <td><?php echo htmlspecialchars($patientname); ?></td>
                                <td><?php echo htmlspecialchars($accountname); ?></td>
                                <td><?php echo htmlspecialchars($visitcode); ?></td>
                                <td><?php echo htmlspecialchars($billdate); ?></td>
                                <td>
                                    <span class="payment-mode-badge payment-mode-<?php echo strtolower($paymentmode); ?>">
                                        <?php echo htmlspecialchars($paymentmode); ?>
                                    </span>
                                </td>
                                <td class="amount-cell text-success">
                                    <?php echo number_format($totalamount, 2); ?>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn delete" 
                                                onclick="confirmDelete('<?php echo htmlspecialchars($docno); ?>', '<?php echo $auto_number; ?>')"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <a href="advancedeposit_edit.php?st=edit&anum=<?php echo $auto_number; ?>" 
                                           class="action-btn edit" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="advancedeposit_print.php?docno=<?php echo $docno; ?>" 
                                           class="action-btn print" title="Print" target="_blank">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div id="paginationContainer" style="margin-top: 1rem; text-align: center;"></div>
            </div>

            <!-- Deleted Items Section -->
            <div class="deleted-items-section">
                <div class="deleted-items-header">
                    <i class="fas fa-archive deleted-items-icon"></i>
                    <h3 class="deleted-items-title">Deleted Advance Deposit Records</h3>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Actions</th>
                            <th>Document No</th>
                            <th>Patient Name</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody id="deletedDepositTableBody">
                        <?php
                        $query1 = "SELECT * from master_transactionadvancedeposit where record_status='0' order by auto_number desc";
                        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                        
                        while ($res1 = mysqli_fetch_array($exec1)) {
                            $docno = $res1["docno"];
                            $patientname = $res1["patientname"];
                            $totalamount = $res1["totalamount"];
                            $auto_number = $res1["auto_number"];
                            ?>
                            <tr>
                                <td>
                                    <button class="action-btn activate" 
                                            onclick="confirmActivate('<?php echo htmlspecialchars($docno); ?>', '<?php echo $auto_number; ?>')"
                                            title="Activate">
                                        <i class="fas fa-undo"></i> Activate
                                    </button>
                                </td>
                                <td>
                                    <span class="docno-badge"><?php echo htmlspecialchars($docno); ?></span>
                                </td>
                                <td><?php echo htmlspecialchars($patientname); ?></td>
                                <td class="amount-cell text-success">
                                    <?php echo number_format($totalamount, 2); ?>
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
    <script src="js/advancedeposit-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
