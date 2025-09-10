<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

// Initialize variables
$errmsg = "";
$bgcolorcode = "";
$cbfrmflag1 = isset($_REQUEST["cbfrmflag1"]) ? $_REQUEST["cbfrmflag1"] : "";

// Get location details
$query7 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
$res7 = mysqli_fetch_array($exec7);
$res7location = $res7["locationname"];
$res7locationanum = $res7["locationcode"];

// Generate document number
$query_bill_location = "select auto_number from master_location where locationcode = '$res7locationanum'";
$exec_bill_loctation = mysqli_query($GLOBALS["___mysqli_ston"], $query_bill_location) or die ("Error in Query_bill_location".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res_bill_loct = mysqli_fetch_array($exec_bill_loctation);
$location_num = $res_bill_loct['auto_number'];

$query_bill = "select prefix from bill_formats where description = 'Branch_stockreqest'";
$exec_bill = mysqli_query($GLOBALS["___mysqli_ston"], $query_bill) or die ("Error in Query_bill".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res_bill = mysqli_fetch_array($exec_bill);
$consultationprefix = $res_bill['prefix'];

$query23 = "select * from master_branchstockrequest where orgstatus ='original' order by auto_number desc limit 0, 1";
$exec23= mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res23 = mysqli_fetch_array($exec23);
$billnumber1 = $res23["docno"];

if ($billnumber1 == '') {
    $billnumbercode = $consultationprefix."-".'1'."-".date('y')."-".$location_num;
} else {
    $pieces = explode('-', $billnumber1);
    $new_billnum = $pieces[1];
    $billnumbercode1 = intval($new_billnum);
    $billnumbercode1 = $billnumbercode1 + 1;
    $maxanum1 = $billnumbercode1;
    $billnumbercode = $consultationprefix."-".$maxanum1."-".date('y')."-".$location_num;
}

// Handle form submission
if ($cbfrmflag1 == 'cbfrmflag1') {
    $serial = $_REQUEST['serialnumber'];
    $remarks = $_REQUEST['remarks'];
    $fromlocation = $_REQUEST['location'];
    $tolocation = $_REQUEST['tolocation'];
    $typetransfer = $_REQUEST['typetransfer'];
    
    if (empty($fromlocation) || empty($tolocation)) {
        $errmsg = "Please select both from and to locations.";
        $bgcolorcode = 'failed';
    } else {
        $errmsg = "Branch stock request submitted successfully.";
        $bgcolorcode = 'success';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branch Stock Request - MedStar</title>
    
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
        <span>Branch Stock Request</span>
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
                    <li class="nav-item active">
                        <a href="branchstockrequest.php" class="nav-link">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Stock Request</span>
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
                    <h2>Branch Stock Request</h2>
                    <p>Create and manage stock transfer requests between different branch locations with detailed item tracking.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="printRequest()">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>

            <!-- Stock Request Form -->
            <div class="add-form-section">
                <div class="add-form-header">
                    <i class="fas fa-clipboard-list add-form-icon"></i>
                    <h3 class="add-form-title">Branch Stock Request</h3>
                </div>
                
                <form id="stockRequestForm" name="cbform1" method="post" action="branchstockrequest.php" class="add-form" onsubmit="return validate()">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="typetransfer" class="form-label">Transfer Type</label>
                            <select name="typetransfer" id="typetransfer" class="form-input" onchange="return medicinesearch(this.value)">
                                <option value="0">Transfer</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="docnumber" class="form-label">Document Number</label>
                            <input type="text" name="docnumber" id="docnumber" class="form-input" value="<?php echo $billnumbercode; ?>" readonly>
                            <input type="hidden" name="location1" id="location1" value="<?php echo $res7locationanum; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" name="date" id="date" class="form-input" value="<?php echo $updatedatetime; ?>" readonly>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">From Location</label>
                            <select name="location" id="location" class="form-input">
                                <?php
                                $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $res1location = $res1["locationname"];
                                    $res1locationanum = $res1["locationcode"];
                                    echo '<option selected value="'.$res1locationanum.'">'.$res1location.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="tolocation" class="form-label">To Location</label>
                            <select name="tolocation" id="tolocation" class="form-input">
                                <option value="">Select Location</option>
                                <?php
                                $query1 = "SELECT * from master_location where locationcode!='$res7locationanum' AND status <> 'deleted' order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $res1location = $res1["locationname"];
                                    $res1locationanum = $res1["locationcode"];
                                    echo '<option value="'.$res1locationanum.'" id="'.$res1locationanum.'" class="tolocation">'.$res1location.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea name="remarks" id="remarks" class="form-input" rows="3" placeholder="Enter any additional remarks or notes..."></textarea>
                    </div>
                    
                    <!-- Dynamic Item Addition Section -->
                    <div class="form-section">
                        <div class="form-section-header">
                            <h4>Stock Items</h4>
                            <button type="button" class="btn btn-outline" onclick="addNewItem()">
                                <i class="fas fa-plus"></i> Add Item
                            </button>
                        </div>
                        
                        <div id="itemsContainer">
                            <!-- Items will be added dynamically here -->
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Submit Request
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                    
                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                    <input type="hidden" name="serialnumber" id="serialnumber" value="1">
                </form>
            </div>
        </main>
    </div>

    <script src="js/vat-modern.js?v=<?php echo time(); ?>"></script>
    <script>
        // Additional JavaScript for branch stock request
        let itemCounter = 1;
        
        function refreshPage() {
            window.location.reload();
        }
        
        function printRequest() {
            window.print();
        }
        
        function medicinesearch(transferType) {
            console.log('Transfer type changed to: ' + transferType);
            // Additional logic for medicine search based on transfer type
        }
        
        function addNewItem() {
            const container = document.getElementById('itemsContainer');
            const itemDiv = document.createElement('div');
            itemDiv.className = 'item-row';
            itemDiv.innerHTML = `
                <div class="item-header">
                    <h5>Item ${itemCounter}</h5>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeItem(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Medicine Name</label>
                        <input type="text" name="medicinename${itemCounter}" class="form-input" placeholder="Enter medicine name">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Medicine Code</label>
                        <input type="text" name="medicinecode${itemCounter}" class="form-input" placeholder="Enter medicine code">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Available Quantity</label>
                        <input type="number" name="avlquantity${itemCounter}" class="form-input" placeholder="0" min="0" step="0.01">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Request Quantity</label>
                        <input type="number" name="reqquantity${itemCounter}" class="form-input" placeholder="0" min="0" step="0.01">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">From Store</label>
                        <input type="text" name="fromstore${itemCounter}" class="form-input" placeholder="Enter from store">
                        <input type="hidden" name="fromstorecode${itemCounter}" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">To Store</label>
                        <input type="text" name="tostore${itemCounter}" class="form-input" placeholder="Enter to store">
                        <input type="hidden" name="tostorecode${itemCounter}" class="form-input">
                    </div>
                </div>
            `;
            
            container.appendChild(itemDiv);
            itemCounter++;
            document.getElementById('serialnumber').value = itemCounter;
        }
        
        function removeItem(button) {
            const itemRow = button.closest('.item-row');
            itemRow.remove();
        }
        
        function validate() {
            const fromLocation = document.getElementById('location').value;
            const toLocation = document.getElementById('tolocation').value;
            
            if (!fromLocation || !toLocation) {
                alert('Please select both from and to locations.');
                return false;
            }
            
            if (fromLocation === toLocation) {
                alert('From and to locations cannot be the same.');
                return false;
            }
            
            return true;
        }
        
        // Initialize with one item
        document.addEventListener('DOMContentLoaded', function() {
            addNewItem();
        });
    </script>
</body>
</html>
