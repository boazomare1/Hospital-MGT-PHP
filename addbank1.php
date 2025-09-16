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

// Handle form submission
if (isset($_POST["frmflag1"])) { 
    $frmflag1 = $_POST["frmflag1"]; 
} else { 
    $frmflag1 = ""; 
}

if ($frmflag1 == 'frmflag1') {
    // Get next bank code
    $query1 = "SELECT bankcode FROM master_bank ORDER BY auto_number DESC LIMIT 1";
    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
    $rowcount1 = mysqli_num_rows($exec1);

    if ($rowcount1 == 0) {
        $bankcode = 'BNK00000001';
    } else {
        $res1 = mysqli_fetch_array($exec1);
        $res1bankcode = $res1["bankcode"];
        $bankcode = substr($res1bankcode, 3, 8);
        $bankcode = intval($bankcode) + 1;
        $bankcode = 'BNK' . str_pad($bankcode, 8, '0', STR_PAD_LEFT);
    }





    // Process form data
    $bankcode = $_REQUEST["bankcode"];
    $companyname = $_REQUEST["companyname"];
    $bankname = trim(strtoupper($_REQUEST["bankname"]));
    $contactpersonname = strtoupper($_REQUEST["contactpersonname"]);
    $contactpersonphone = $_REQUEST["contactpersonphone"];
    $branchname = trim(strtoupper($_REQUEST["branchname"]));
    $netbankinglogin = strtoupper($_REQUEST["netbankinglogin"]);
    $accountnumber = $_REQUEST["accountnumber"];
    $accounttype = $_REQUEST["accounttype"];
    $currentbalance = $_REQUEST["currentbalance"];
    $commissionpercentage = $_REQUEST["commissionpercentage"];
    $phonenumber = $_REQUEST["phonenumber"];
    $mobilenumber = $_REQUEST["mobilenumber"];
    $address = $_REQUEST["address"];
    $remarks = strtoupper($_REQUEST["remarks"]);
    $branchcode = strtoupper($_REQUEST["branchcode"]);
    $swiftcode = strtoupper($_REQUEST["swiftcode"]);
    $dateposted = $_REQUEST["dateposted"];
    $bankstatus = $_REQUEST["bankstatus"];
    $lastupdate = $updatedatetime;
    $lastupdateusername = $username;
    $lastupdateipaddress = $ipaddress;

    if($accountnumber == '') {
        $accountnumber = $bankcode;
    }
	

    // Check if account number already exists
    $query2 = "SELECT * FROM master_bank WHERE accountnumber = '$accountnumber'";
    $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
    $rowcount2 = mysqli_num_rows($exec2);

    if ($rowcount2 == 0) {
        $query1 = "INSERT INTO master_bank (bankcode, companyname, bankname, contactpersonname, contactpersonphone, 
                   branchname, netbankinglogin, accountnumber, accounttype, currentbalance, commissionpercentage, 
                   phonenumber, mobilenumber, address, remarks, bankstatus, branchcode, swiftcode, 
                   lastupdate, lastupdateusername, lastupdateipaddress) 
                   VALUES ('$bankcode','$companyname', '$bankname', '$contactpersonname', '$contactpersonphone', 
                   '$branchname', '$netbankinglogin', '$accountnumber', '$accounttype', '$currentbalance', '$commissionpercentage', 
                   '$phonenumber','$mobilenumber', '$address', '$remarks', '$bankstatus', '$branchcode', '$swiftcode', 
                   '$lastupdate', '$lastupdateusername', '$lastupdateipaddress')";

        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
        
        $errmsg = "Success. New Bank Added.";
        $bgcolorcode = 'success';
    } else {
        $errmsg = "Failed. Bank Account Number Already Exists.";
        $bgcolorcode = 'failed';
    }
} else {
    // Initialize form variables
    $bankcode = '';
    $bankname = '';
    $contactpersonname = '';
    $contactpersonphone = '';
    $branchname = '';
    $netbankinglogin = '';
    $accountnumber = '';
    $accounttype = '';
    $currentbalance = '';
    $commissionpercentage = '';
    $phonenumber = '';
    $mobilenumber = '';
    $address = '';
    $remarks = '';
    $branchcode = '';
    $swiftcode = '';
    $dateposted = '';
    $bankstatus = '';
    $lastupdate = $updatedatetime;
    $lastupdateusername = $username;
    $lastupdateipaddress = $ipaddress;
}



// Handle URL status messages
if (isset($_REQUEST["st"])) { 
    $st = $_REQUEST["st"]; 
} else { 
    $st = ""; 
}

if ($st == 'success') {
    $errmsg = "Success. New Bank Added.";
    $bgcolorcode = 'success';
}

if ($st == 'failed') {
    $errmsg = "Failed. Bank Account Number Already Exists.";
    $bgcolorcode = 'failed';
}

// Handle delete action
if ($st == 'del') {
    $delanum = $_REQUEST["anum"];
    $query3 = "UPDATE master_bank SET bankstatus = 'Deleted' WHERE auto_number = '$delanum'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
    header("Location: addbank1.php?msg=deleted");
    exit();
}

// Handle URL messages
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'deleted') {
        $errmsg = "Bank deleted successfully.";
        $bgcolorcode = 'success';
    }
}



// Get next bank code for form display
$query1 = "SELECT bankcode FROM master_bank ORDER BY auto_number DESC LIMIT 1";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$rowcount1 = mysqli_num_rows($exec1);

if ($rowcount1 == 0) {
    $bankcode = 'BNK00000001';
} else {
    $res1 = mysqli_fetch_array($exec1);
    $res1bankcode = $res1["bankcode"];
    $bankcode = substr($res1bankcode, 3, 8);
    $bankcode = intval($bankcode) + 1;
    $bankcode = 'BNK' . str_pad($bankcode, 8, '0', STR_PAD_LEFT);
}





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Master - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/addbank1-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Alert Container -->
    <div id="alertContainer"></div>

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
        <span>Bank Master</span>
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
                        <a href="addaccountsmain.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Accounts Main</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountssub.php" class="nav-link">
                            <i class="fas fa-chart-pie"></i>
                            <span>Accounts Sub Type</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="addbank1.php" class="nav-link">
                            <i class="fas fa-university"></i>
                            <span>Bank Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="vat.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
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
                    <h2>Bank Master</h2>
                    <p>Manage bank accounts and financial institutions for your organization.</p>
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

            <!-- Data Table Section -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-list data-table-icon"></i>
                    <h3 class="data-table-title">Existing Bank Records</h3>
                </div>

                <!-- Search Bar -->
                <div style="margin-bottom: 1rem;">
                    <div style="display: flex; gap: 1rem; align-items: center;">
                        <input type="text" id="searchInput" class="form-input" 
                               placeholder="Search bank name, account number, or type..." 
                               style="flex: 1; max-width: 300px;"
                               oninput="searchBanks(this.value)">
                        <button type="button" class="btn btn-secondary" onclick="clearSearch()">
                            <i class="fas fa-times"></i> Clear
                        </button>
                    </div>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Bank Code</th>
                            <th>Bank Name</th>
                            <th>Account Number</th>
                            <th>Account Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="bankTableBody">
                        <?php
                        $query100 = "SELECT * FROM master_bank WHERE bankstatus = '' ORDER BY bankname";
                        $exec100 = mysqli_query($GLOBALS["___mysqli_ston"], $query100) or die ("Error in Query100".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $colorloopcount = 0;
                        
                        while ($res100 = mysqli_fetch_array($exec100)) {
                            $res100bankcode = $res100["bankcode"];
                            $res100bankname = $res100["bankname"];
                            $res100auto_number = $res100["auto_number"];
                            $res100accountnumber = $res100["accountnumber"];
                            $res100accounttype = $res100["accounttype"];
                            $colorloopcount++;
                            ?>
                            <tr>
                                <td><?php echo $colorloopcount; ?></td>
                                <td>
                                    <span class="bank-code-badge"><?php echo htmlspecialchars($res100bankcode); ?></span>
                                </td>
                                <td><?php echo htmlspecialchars($res100bankname); ?></td>
                                <td><?php echo htmlspecialchars($res100accountnumber); ?></td>
                                <td>
                                    <span class="account-type-badge">
                                        <?php echo htmlspecialchars($res100accounttype); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn delete" 
                                                onclick="confirmDelete('<?php echo htmlspecialchars($res100bankname); ?>', '<?php echo $res100auto_number; ?>')"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <a href="editbank1.php?bankcode=<?php echo $res100bankcode; ?>" 
                                           class="action-btn edit" title="Edit">
                                            <i class="fas fa-edit"></i>
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

            <!-- Add Form Section -->
            <div class="add-form-section">
                <div class="add-form-header">
                    <i class="fas fa-plus-circle add-form-icon"></i>
                    <h3 class="add-form-title">Add New Bank</h3>
                </div>
                
                <form id="bankForm" name="form1" method="post" action="addbank1.php" class="add-form">
                    <div class="form-group">
                        <label for="bankcode" class="form-label">Bank Code</label>
                        <input type="text" name="bankcode" id="bankcode" class="form-input" 
                               value="<?php echo $bankcode; ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="companyname" class="form-label">Company Name</label>
                        <input type="text" name="companyname" id="companyname" class="form-input" 
                               value="<?php echo htmlspecialchars($companyname); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="bankname" class="form-label">Bank Name</label>
                        <input type="text" name="bankname" id="bankname" class="form-input" 
                               value="<?php echo htmlspecialchars($bankname); ?>" 
                               placeholder="Enter bank name" required>
                    </div>

                    <div class="form-group">
                        <label for="branchname" class="form-label">Branch Name</label>
                        <input type="text" name="branchname" id="branchname" class="form-input" 
                               value="<?php echo htmlspecialchars($branchname); ?>" 
                               placeholder="Enter branch name" required>
                    </div>

                    <div class="form-group">
                        <label for="accountnumber" class="form-label">Account Number</label>
                        <input type="text" name="accountnumber" id="accountnumber" class="form-input" 
                               value="<?php echo htmlspecialchars($accountnumber); ?>" 
                               placeholder="Enter account number" required>
                    </div>

                    <div class="form-group">
                        <label for="accounttype" class="form-label">Account Type</label>
                        <select name="accounttype" id="accounttype" class="form-input" required>
                            <option value="">--Select Account Type--</option>
                            <option value="Savings" <?php echo ($accounttype == 'Savings') ? 'selected' : ''; ?>>Savings</option>
                            <option value="Current" <?php echo ($accounttype == 'Current') ? 'selected' : ''; ?>>Current</option>
                            <option value="Fixed Deposit" <?php echo ($accounttype == 'Fixed Deposit') ? 'selected' : ''; ?>>Fixed Deposit</option>
                            <option value="Recurring Deposit" <?php echo ($accounttype == 'Recurring Deposit') ? 'selected' : ''; ?>>Recurring Deposit</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="contactpersonname" class="form-label">Contact Person Name</label>
                        <input type="text" name="contactpersonname" id="contactpersonname" class="form-input" 
                               value="<?php echo htmlspecialchars($contactpersonname); ?>" 
                               placeholder="Enter contact person name">
                    </div>

                    <div class="form-group">
                        <label for="contactpersonphone" class="form-label">Contact Phone Number</label>
                        <input type="text" name="contactpersonphone" id="contactpersonphone" class="form-input" 
                               value="<?php echo htmlspecialchars($contactpersonphone); ?>" 
                               placeholder="Enter contact phone number">
                    </div>

                    <div class="form-group">
                        <label for="netbankinglogin" class="form-label">Net Banking Login ID</label>
                        <input type="text" name="netbankinglogin" id="netbankinglogin" class="form-input" 
                               value="<?php echo htmlspecialchars($netbankinglogin); ?>" 
                               placeholder="Enter net banking login ID">
                    </div>

                    <div class="form-group">
                        <label for="phonenumber" class="form-label">Phone Number</label>
                        <input type="text" name="phonenumber" id="phonenumber" class="form-input" 
                               value="<?php echo htmlspecialchars($phonenumber); ?>" 
                               placeholder="Enter phone number">
                    </div>

                    <div class="form-group">
                        <label for="mobilenumber" class="form-label">Mobile Number</label>
                        <input type="text" name="mobilenumber" id="mobilenumber" class="form-input" 
                               value="<?php echo htmlspecialchars($mobilenumber); ?>" 
                               placeholder="Enter mobile number">
                    </div>

                    <div class="form-group">
                        <label for="address" class="form-label">Address</label>
                        <textarea name="address" id="address" class="form-input" 
                                  placeholder="Enter bank address" rows="3"><?php echo htmlspecialchars($address); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="branchcode" class="form-label">Branch Code</label>
                        <input type="text" name="branchcode" id="branchcode" class="form-input" 
                               value="<?php echo htmlspecialchars($branchcode); ?>" 
                               placeholder="Enter branch code">
                    </div>

                    <div class="form-group">
                        <label for="swiftcode" class="form-label">Swift Code</label>
                        <input type="text" name="swiftcode" id="swiftcode" class="form-input" 
                               value="<?php echo htmlspecialchars($swiftcode); ?>" 
                               placeholder="Enter SWIFT code">
                    </div>

                    <div class="form-group">
                        <label for="currentbalance" class="form-label">Current Balance</label>
                        <input type="number" name="currentbalance" id="currentbalance" class="form-input" 
                               value="<?php echo htmlspecialchars($currentbalance); ?>" 
                               placeholder="Enter current balance" step="0.01">
                    </div>

                    <div class="form-group">
                        <label for="commissionpercentage" class="form-label">Commission Percentage</label>
                        <input type="number" name="commissionpercentage" id="commissionpercentage" class="form-input" 
                               value="<?php echo htmlspecialchars($commissionpercentage); ?>" 
                               placeholder="Enter commission percentage" step="0.01">
                    </div>

                    <div class="form-group">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea name="remarks" id="remarks" class="form-input" 
                                  placeholder="Enter any remarks" rows="2"><?php echo htmlspecialchars($remarks); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="bankstatus" class="form-label">Bank Status</label>
                        <select name="bankstatus" id="bankstatus" class="form-input">
                            <option value="" <?php echo ($bankstatus == '') ? 'selected' : ''; ?>>Active</option>
                            <option value="Deleted" <?php echo ($bankstatus == 'Deleted') ? 'selected' : ''; ?>>Deleted</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" id="submitBtn" class="submit-btn">
                            <i class="fas fa-save"></i>
                            Add Bank
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>

                    <input type="hidden" name="frmflag1" value="frmflag1">
                </form>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/addbank1-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>



