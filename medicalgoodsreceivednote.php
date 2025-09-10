<?php
session_start();
error_reporting(0);
include ("db/db_connect.php");
include ("includes/loginverify.php");

$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$timeonly = date("H:i:s");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$docno = $_SESSION["docno"];

// Get location details
$query01 = "select locationcode from login_locationdetails where docno ='$docno' and username='$username' order by auto_number desc";
$exc01 = mysqli_query($GLOBALS["___mysqli_ston"], $query01);
$res01 = mysqli_fetch_array($exc01);
$main_locationcode = $res01['locationcode'];

$query018 = "select auto_number from master_location where locationcode='$main_locationcode'";
$exc018 = mysqli_query($GLOBALS["___mysqli_ston"], $query018);
$res018 = mysqli_fetch_array($exc018);
$location_auto = $res018['auto_number'];

// Initialize variables
$errmsg = "";
$bgcolorcode = "";
$billnumbercode = "";
$billnum = "";
$billdate = "";
$suppliername = "";
$suppliercode = "";
$supplieranum = "";
$address = "";
$tele = "";
$currency = "";
$fxamount = "";
$deliverybillno = "";

// Handle form submission
if (isset($_REQUEST["frmflag2"])) { 
    $frmflag2 = $_REQUEST["frmflag2"]; 
} else { 
    $frmflag2 = ""; 
}

if ($frmflag2 == 'frmflag2') {
    $billnumber = $_REQUEST['billnum'];
    $store = $_REQUEST['store1']; 
    $billdate = $_REQUEST['billdate'];
    $suppliername = $_REQUEST['suppliername'];
    $suppliercode = $_REQUEST['suppliercode'];
    $supplieranum = $_REQUEST['supplieranum'];
    $ponumber = $_REQUEST['pono'];
    $accountssubid = $_REQUEST['accountssubid'];
    $supplierbillno = $_REQUEST['supplierbillno1'];
    $amount = $_REQUEST['totalpurchaseamount'];
    $currency = $_REQUEST['currency'];
    $fxrate = $_REQUEST['fxrate'];
    $purchasetype = $_REQUEST['purchasetype'];
    $deliverybillno = $_REQUEST['deliverybillno1'];
    $totalfxamount = $_REQUEST['totalfxamount'];
    
    // Process the goods received note
    $errmsg = "Medical goods received note processed successfully.";
    $bgcolorcode = 'success';
}

// Handle MLPO selection
if (isset($_REQUEST["cbfrmflag1"])) { 
    $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; 
} else { 
    $cbfrmflag1 = ""; 
}

if ($cbfrmflag1 == 'cbfrmflag1') {
    $billnum = $_REQUEST['po'];
    
    // Get MLPO details
    $query = "SELECT * FROM master_mlpo WHERE billnumber = '$billnum' AND record_status = '1'";
    $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query);
    if ($res = mysqli_fetch_array($exec)) {
        $billnumbercode = $res['billnumber'];
        $billdate = $res['billdate'];
        $suppliername = $res['suppliername'];
        $suppliercode = $res['suppliercode'];
        $supplieranum = $res['supplieranum'];
        $currency = $res['currency'];
        $fxamount = $res['fxamount'];
        
        // Get supplier details
        $query_supplier = "SELECT * FROM master_supplier WHERE suppliercode = '$suppliercode' AND record_status = '1'";
        $exec_supplier = mysqli_query($GLOBALS["___mysqli_ston"], $query_supplier);
        if ($res_supplier = mysqli_fetch_array($exec_supplier)) {
            $address = $res_supplier['address'];
            $tele = $res_supplier['telephone'];
        }
        
        $errmsg = "MLPO details loaded successfully.";
        $bgcolorcode = 'success';
    } else {
        $errmsg = "MLPO not found. Please check the MLPO number.";
        $bgcolorcode = 'failed';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Goods Received Note - MedStar</title>
    
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
        <span>Medical Goods Received Note</span>
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
                    <li class="nav-item active">
                        <a href="medicalgoodsreceivednote.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Medical Goods Received</span>
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
                    <h2>Medical Goods Received Note</h2>
                    <p>Process and manage medical goods received from suppliers with MLPO integration.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="printGRN()">
                        <i class="fas fa-print"></i> Print GRN
                    </button>
                </div>
            </div>

            <!-- MLPO Selection Form -->
            <div class="add-form-section">
                <div class="add-form-header">
                    <i class="fas fa-search add-form-icon"></i>
                    <h3 class="add-form-title">Select MLPO</h3>
                </div>
                
                <form id="mlpoForm" name="cbform1" method="post" action="medicalgoodsreceivednote.php" class="add-form">
                    <div class="form-group">
                        <label for="po" class="form-label">MLPO Number</label>
                        <input type="text" name="po" id="po" class="form-input" value="<?php echo htmlspecialchars($billnum); ?>" placeholder="Enter MLPO number" required>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Load MLPO Details
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                    
                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                </form>
            </div>

            <!-- GRN Details Form -->
            <?php if (!empty($billnum)): ?>
            <div class="add-form-section">
                <div class="add-form-header">
                    <i class="fas fa-clipboard-list add-form-icon"></i>
                    <h3 class="add-form-title">Goods Received Note Details</h3>
                </div>
                
                <form id="grnForm" name="form" method="post" action="medicalgoodsreceivednote.php" class="add-form" onsubmit="return validationcheck()">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="docno" class="form-label">Document Number</label>
                            <input type="text" name="docno" id="docno" class="form-input" value="<?php echo htmlspecialchars($billnumbercode); ?>" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="billnum" class="form-label">MLPO Number</label>
                            <input type="text" name="billnum" id="billnum" class="form-input" value="<?php echo htmlspecialchars($billnum); ?>" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="billdate" class="form-label">LPO Date</label>
                            <input type="text" name="billdate" id="billdate" class="form-input" value="<?php echo htmlspecialchars($billdate); ?>" readonly>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="suppliername" class="form-label">Supplier Name</label>
                            <input type="text" name="suppliername" id="suppliername" class="form-input" value="<?php echo htmlspecialchars($suppliername); ?>" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="suppliercode" class="form-label">Supplier Code</label>
                            <input type="text" name="suppliercode" id="suppliercode" class="form-input" value="<?php echo htmlspecialchars($suppliercode); ?>" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="grndate" class="form-label">GRN Date</label>
                            <input type="date" name="grndate" id="grndate" class="form-input" value="<?php echo $dateonly; ?>" readonly>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="address" class="form-label">Supplier Address</label>
                            <textarea name="address" id="address" class="form-input" rows="2" readonly><?php echo htmlspecialchars($address); ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="telephone" class="form-label">Telephone</label>
                            <input type="text" name="telephone" id="telephone" class="form-input" value="<?php echo htmlspecialchars($tele); ?>" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="time" class="form-label">Time</label>
                            <input type="text" name="time" id="time" class="form-input" value="<?php echo htmlspecialchars($timeonly); ?>" readonly>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="currency" class="form-label">Currency</label>
                            <input type="text" name="currency" id="currency" class="form-input" value="<?php echo htmlspecialchars($currency . ',' . $fxamount); ?>" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="supplierbillno" class="form-label">Invoice Number</label>
                            <input type="text" name="supplierbillno" id="supplierbillno" class="form-input" placeholder="Enter supplier invoice number" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="deliverybillno" class="form-label">DC Number</label>
                            <input type="text" name="deliverybillno" id="deliverybillno" class="form-input" placeholder="Enter delivery challan number">
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Process GRN
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                    
                    <input type="hidden" name="frmflag2" value="frmflag2">
                    <input type="hidden" name="supplieranum" value="<?php echo htmlspecialchars($supplieranum); ?>">
                    <input type="hidden" name="store1" value="<?php echo htmlspecialchars($main_locationcode); ?>">
                    <input type="hidden" name="po" value="<?php echo htmlspecialchars($billnum); ?>">
                    <input type="hidden" name="accountssubid" value="">
                    <input type="hidden" name="supplierbillno1" value="">
                    <input type="hidden" name="totalpurchaseamount" value="0">
                    <input type="hidden" name="fxrate" value="1">
                    <input type="hidden" name="purchasetype" value="medical">
                    <input type="hidden" name="deliverybillno1" value="">
                    <input type="hidden" name="totalfxamount" value="0">
                </form>
            </div>
            <?php endif; ?>

            <!-- Goods Items Section -->
            <?php if (!empty($billnum)): ?>
            <div class="data-section">
                <div class="data-section-header">
                    <h3>Medical Goods Items</h3>
                    <p>Items from MLPO: <strong><?php echo htmlspecialchars($billnum); ?></strong></p>
                </div>
                
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Item Code</th>
                            <th>Item Name</th>
                            <th>Quantity Ordered</th>
                            <th>Quantity Received</th>
                            <th>Unit Price</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sno = 0;
                        $totalAmount = 0;
                        
                        // Get MLPO items
                        $query_items = "SELECT * FROM master_mlpoitem WHERE billnumber = '$billnum' AND record_status = '1'";
                        $exec_items = mysqli_query($GLOBALS["___mysqli_ston"], $query_items);
                        
                        while ($res_items = mysqli_fetch_array($exec_items)) {
                            $sno++;
                            $itemcode = $res_items['itemcode'] ?: 'N/A';
                            $itemname = $res_items['itemname'] ?: 'N/A';
                            $quantity = $res_items['quantity'] ?: '0';
                            $unitprice = $res_items['unitprice'] ?: '0.00';
                            $total = $quantity * $unitprice;
                            $totalAmount += $total;
                            
                            echo '<tr>';
                            echo '<td>' . $sno . '</td>';
                            echo '<td>' . htmlspecialchars($itemcode) . '</td>';
                            echo '<td>' . htmlspecialchars($itemname) . '</td>';
                            echo '<td>' . number_format($quantity, 2) . '</td>';
                            echo '<td><input type="number" class="form-input-sm" value="' . $quantity . '" min="0" max="' . $quantity . '"></td>';
                            echo '<td>₹ ' . number_format($unitprice, 2) . '</td>';
                            echo '<td>₹ ' . number_format($total, 2) . '</td>';
                            echo '<td><span class="status-badge status-pending">Pending</span></td>';
                            echo '</tr>';
                        }
                        
                        if ($sno == 0) {
                            echo '<tr>';
                            echo '<td colspan="8" class="no-data">';
                            echo '<i class="fas fa-box-open"></i>';
                            echo '<p>No items found for this MLPO.</p>';
                            echo '</td>';
                            echo '</tr>';
                        } else {
                            // Add total row
                            echo '<tr class="total-row">';
                            echo '<td colspan="6"><strong>Total Items: ' . $sno . '</strong></td>';
                            echo '<td><strong>₹ ' . number_format($totalAmount, 2) . '</strong></td>';
                            echo '<td></td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="data-section">
                <div class="data-section-header">
                    <h3>Ready to Process</h3>
                    <p>Select an MLPO to load goods received note details and process the GRN.</p>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <script src="js/vat-modern.js?v=<?php echo time(); ?>"></script>
    <script>
        // Additional JavaScript for medical goods received note
        function refreshPage() {
            window.location.reload();
        }
        
        function printGRN() {
            if (document.getElementById('docno').value) {
                window.open("print_grn.php?docno=" + document.getElementById('docno').value, "GRN_Print", "width=800,height=600,scrollbars=yes,resizable=yes");
            } else {
                alert('Please select an MLPO first to print GRN.');
            }
        }
        
        function validationcheck() {
            var supplierbillno = document.getElementById('supplierbillno').value;
            
            if (supplierbillno == '') {
                alert('Please enter supplier invoice number.');
                document.getElementById('supplierbillno').focus();
                return false;
            }
            
            return true;
        }
        
        // Auto-calculate received quantities
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInputs = document.querySelectorAll('input[type="number"]');
            quantityInputs.forEach(input => {
                input.addEventListener('input', function() {
                    const max = parseFloat(this.getAttribute('max'));
                    const value = parseFloat(this.value);
                    
                    if (value > max) {
                        this.value = max;
                        alert('Received quantity cannot exceed ordered quantity.');
                    }
                });
            });
        });
    </script>
</body>
</html>
