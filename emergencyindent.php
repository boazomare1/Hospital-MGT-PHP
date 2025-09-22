<?php
session_start();
error_reporting(0);
ini_set('max_execution_time', 0);
include ("db/db_connect.php");
include ("includes/loginverify.php");
include ("includes/check_user_access.php");

$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];  
$financialyear = $_SESSION["financialyear"];
$docno1 = $_SESSION['docno'];
$locationname=isset($_REQUEST['locationname'])?$_REQUEST['locationname']:'';
$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
$storecode=isset($_REQUEST['storecode'])?$_REQUEST['storecode']:'';
$store=isset($_REQUEST['store'])?$_REQUEST['store']:'';

$query = "select * from login_locationdetails where username='$username' and docno='$docno1' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
	
$locationname  = $res["locationname"];
$locationcode = $res["locationcode"];

$query018="select auto_number from master_location where locationcode='$locationcode'";
$exc018=mysqli_query($GLOBALS["___mysqli_ston"], $query018);
$res018=mysqli_fetch_array($exc018);
$location_auto = $res018['auto_number'];
$titlestr = 'EMERGENCY INDENT';

$query77 = "select job_title from master_employee where username = '$username'";
$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
$res77 = mysqli_fetch_array($exec77);
$job_title = $res77['job_title'];

// Handle form submission
if (isset($_REQUEST["frm1submit1"])) { 
    $frm1submit1 = $_REQUEST["frm1submit1"]; 
} else { 
    $frm1submit1 = ""; 
}

if ($frm1submit1 == 'frm1submit1') {
    if($username!='') {
        $docno = $_REQUEST['docno'];
        $location = $_REQUEST['location'];
        $status = $_REQUEST['status'];
        $remarks = $_REQUEST['remarks'];
        $priority = $_REQUEST['priority'];
        $purchasetype = $_REQUEST['purchasetype'];
        $lpotype = $_REQUEST['lpotype'];
        $currency = explode(',',$_REQUEST['currency']);
        $currency = $currency[1];
        $fxamount = $_REQUEST['fxamount'];
        $piemailfrom = $_REQUEST['piemailfrom'];
        $bamailfrom = $_REQUEST['bamailfrom'];
        $bamailcc = $_REQUEST['bamailcc'];
        $jobdescription = $_REQUEST['jobdescription'];
        
        // Generate document number
        $query3 = "select * from bill_formats where description = 'purchase_indent'";
        $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res3 = mysqli_fetch_array($exec3);
        $paynowbillprefix = $res3['prefix'];
        $paynowbillprefix1=strlen($paynowbillprefix);
        
        $query2 = "select * from purchase_indent order by auto_number desc limit 0, 1";
        $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res2 = mysqli_fetch_array($exec2);
        $billnumber = $res2["docno"];
        $billdigit=strlen($billnumber);
        
        if ($billnumber == '') {
            $billnumbercode =$paynowbillprefix."-".'1'."-".date('y')."-".$location_auto;
            $openingbalance = '0.00';
        } else {
            $billnumber = $res2["docno"];
            $maxcount=split("-",$billnumber);
            $maxcount1=$maxcount[1];
            $maxanum = $maxcount1+1;
            $billnumbercode = $paynowbillprefix ."-".$maxanum."-".date('y')."-".$location_auto;
            $openingbalance = '0.00';
        }
        
        $searchsuppliername = trim($_REQUEST['searchsuppliername']);
        $searchsuppliercode = trim($_REQUEST['searchsuppliercode']);
        $searchsupplieranum = trim($_REQUEST['searchsupplieranum']);
        
        // Process items
        for ($p=1;$p<=2000;$p++) {
            $medicinename = $_REQUEST['medicinename'.$p];
            
            if($purchasetype!='non-medical' && $purchasetype!='ASSETS') {
                $medicinecode = $_REQUEST['medicinecode'.$p];
                $pkgqty = $_REQUEST['pkgqty'.$p];
            } else {
                $medicinecode='';
                $pkgqty = '1';
            }
            
            $reqqty = str_replace(',','',$_REQUEST['reqqty'.$p]);
            $rate =str_replace(',','',$_REQUEST['rate'.$p]);
            $amount =str_replace(',','',$_REQUEST['amount'.$p]);
            
            if ($medicinename != "") {
                $query43="insert into purchase_indent(date,docno,medicinename,medicinecode,quantity,packagequantity,rate,amount,username,status,remarks,faremarks,companyanum,location,locationname,locationcode,storecode,storename,purchasetype,currency,fxamount,originalqty,originalamt,originalrate,suppliername,suppliercode,supplieranum,pimailfrom,bamailfrom,bamailcc,indent_memo,priority,job_title,lpo_type,indent_approval,approvalstatus,initial_approval)values('$dateonly','$billnumbercode','$medicinename','$medicinecode','$reqqty','$pkgqty','$rate','$amount','$username','$status','$remarks','$remarks','$companyanum','$location','".$locationname."','".$locationcode."','".$storecode."','".$store."','$purchasetype','$currency','$fxamount','$reqqty','$amount','$rate','$searchsuppliername','$searchsuppliercode','$searchsupplieranum','$piemailfrom','$bamailfrom','$bamailcc','$remarks','$priority','$job_title','$lpotype','approved','approved','1')";
                
                $exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
            }
        }
        
        $action='purchaseindent';
        header("location:emergencyindent.php?success=success");
        exit;
    } else {
        header("location:emergencyindent.php?success=Failed");
        exit;
    }
}

// Handle success/failure messages
if (isset($_REQUEST["success"])) { 
    $success = $_REQUEST["success"]; 
} else { 
    $success = ""; 
}

if ($success == 'success') {
    $errmsg = "Emergency Indent Successfully Saved!";
    $bgcolorcode = 'success';
} elseif ($success == 'Failed') {
    $errmsg = "Failed to Save Emergency Indent. Please try again.";
    $bgcolorcode = 'failed';
} else {
    $errmsg = "";
    $bgcolorcode = '';
}

// Get default tax
if (isset($_REQUEST["defaulttax"])) { 
    $defaulttax = $_REQUEST["defaulttax"]; 
} else { 
    $defaulttax = ""; 
}

if ($defaulttax == '') {
    $_SESSION["defaulttax"] = '';
} else {
    $_SESSION["defaulttax"] = $defaulttax;
}

// Get document number for display
$query3 = "select * from bill_formats where description = 'purchase_indent'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = $res3['prefix'];
$paynowbillprefix1=strlen($paynowbillprefix);

$query2 = "select * from purchase_indent order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);

if ($billnumber == '') {
    $billnumbercode =$paynowbillprefix."-".'1'."-".date('y')."-".$location_auto;
    $openingbalance = '0.00';
} else {
    $billnumber = $res2["docno"];
    $maxcount=split("-",$billnumber);
    $maxcount1=$maxcount[1];
    $maxanum = $maxcount1+1;
    $billnumbercode = $paynowbillprefix ."-".$maxanum."-".date('y')."-".$location_auto;
    $openingbalance = '0.00';
}

// Get location and store details
$query = "select * from login_locationdetails where username='$username' and docno='$docno1' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);

$locationname  = $res["locationname"];
$locationcode = $res["locationcode"];

$query23 = "select * from master_employeelocation where username='$username' and defaultstore='default' and locationcode='".$locationcode."'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res23 = mysqli_fetch_array($exec23);
$res7storeanum = $res23['storecode'];

$query75 = "select * from master_store where auto_number='$res7storeanum'";
$exec75 = mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res75 = mysqli_fetch_array($exec75);
$store = $res75['store'];
$storecode = $res75['storecode'];

// Get email details
$query1mail = "select emailto,emailcc from master_email where recordstatus <> 'deleted' and module='Purchase Indent' order by auto_number desc";
$exec1mail = mysqli_query($GLOBALS["___mysqli_ston"], $query1mail) or die ("Error in Query1mail".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1mail = mysqli_fetch_array($exec1mail)) {
    $emailto = $res1mail["emailto"];
    $emailcc = $res1mail["emailcc"];
}

$query1mail = "select mei.email,me.jobdescription from master_employee me,master_employeeinfo mei where me.username='$username' and me.employeecode=mei.employeecode";
$exec1mail = mysqli_query($GLOBALS["___mysqli_ston"], $query1mail) or die ("Error in Query1mail".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1mail = mysqli_fetch_array($exec1mail)) {
    $useremail = $res1mail["email"];
    $jobdescription = $res1mail["jobdescription"];
}

// Function to calculate age
function calculate_age($birth_date) {
    $birth_date = new DateTime($birth_date);
    $today = new DateTime();
    $age = $today->diff($birth_date);
    return $age->y;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emergency Indent - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/emergency-indent-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- jQuery UI for autocomplete -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/ui-lightness/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
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
        <span>Emergency Indent</span>
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
                        <a href="purchase_indent.php" class="nav-link">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Purchase Indent</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="emergencyindent.php" class="nav-link">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Emergency Indent</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="purchase_order_edit.php" class="nav-link">
                            <i class="fas fa-file-invoice"></i>
                            <span>Purchase Orders</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="vendor_master.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Vendor Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="inventory_master.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Inventory</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="reports.php" class="nav-link">
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
                    <h2>Emergency Indent</h2>
                    <p>Create urgent purchase indent requests for emergency medical supplies and equipment.</p>
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
            
            <!-- Emergency Indent Form -->
            <form id="emergencyIndentForm" name="emergencyIndentForm" method="post" action="emergencyindent.php" class="emergency-indent-form">
                <!-- Form Header -->
                <div class="form-header">
                    <i class="fas fa-exclamation-triangle form-header-icon"></i>
                    <h3 class="form-header-title">Emergency Indent Details</h3>
                </div>
                
                <div class="form-content">
                    <!-- Basic Information Grid -->
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="docno" class="form-label">Document Number</label>
                            <input type="text" name="docno" id="docno" class="form-input" 
                                   value="<?php echo $billnumbercode; ?>" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="date" class="form-label">Date</label>
                            <input type="text" name="date" id="date" class="form-input" 
                                   value="<?php echo $dateonly; ?>" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="store" class="form-label">Store</label>
                            <input type="text" name="store" id="store" class="form-input" 
                                   value="<?php echo htmlspecialchars($store); ?>" readonly>
                            <input type="hidden" name="storecode" id="storecode" value="<?php echo htmlspecialchars($storecode); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" name="location" id="location" class="form-input" 
                                   value="<?php echo htmlspecialchars($locationname); ?>" readonly>
                            <input type="hidden" name="locationcode" value="<?php echo htmlspecialchars($locationcode); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="purchasetype" class="form-label">Purchase Type *</label>
                            <select name="purchasetype" id="purchasetype" class="form-select" required onChange="handlePurchaseTypeChange()">
                                <option value="">Select Purchase Type</option>
                                <?php
                                $query16 = "select name from master_purchase_type where status <> 'deleted' and name<>'ASSETS' order by id";
                                $exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res16 = mysqli_fetch_array($exec16)) {
                                    $purchasetype = $res16["name"];
                                    ?>
                                    <option value="<?php echo htmlspecialchars($purchasetype); ?>"><?php echo htmlspecialchars($purchasetype); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="currency" class="form-label">Currency *</label>
                            <select name="currency" id="currency" class="form-select" required onChange="handleCurrencyChange()">
                                <?php
                                $query1currency = "select currency,rate from master_currency where recordstatus = '' ";
                                $exec1currency = mysqli_query($GLOBALS["___mysqli_ston"], $query1currency) or die ("Error in Query1currency".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1currency = mysqli_fetch_array($exec1currency)) {
                                    $currency = $res1currency["currency"];
                                    $rate = $res1currency["rate"];
                                    ?>
                                    <option value="<?php echo $rate.','.$currency; ?>"><?php echo htmlspecialchars($currency); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="fxamount" class="form-label">FX Rate</label>
                            <input type="text" name="fxamount" id="fxamount" class="form-input" 
                                   value="1" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="lpotype" class="form-label">LPO Type</label>
                            <select name="lpotype" id="lpotype" class="form-select">
                                <option value="">Select LPO Type</option>
                                <option value="CASH">CASH</option>
                                <option value="CREDIT" selected>CREDIT</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Supplier Section (Hidden by default) -->
                    <div class="supplier-section" id="supplierSection">
                        <div class="form-group">
                            <label for="searchsuppliername" class="form-label">Supplier Name</label>
                            <input type="text" name="searchsuppliername" id="searchsuppliername" class="form-input" 
                                   placeholder="Search supplier name..." autocomplete="off">
                            <input type="hidden" name="searchsuppliercode" id="searchsuppliercode">
                            <input type="hidden" name="searchsupplieranum" id="searchsupplieranum">
                        </div>
                    </div>
                </div>
            </form>
            
            <!-- Item Entry Section -->
            <div class="item-entry-section">
                <div class="item-entry-header">
                    <i class="fas fa-plus-circle item-entry-icon"></i>
                    <h3 class="item-entry-title">Add Items to Indent</h3>
                </div>
                
                <div class="item-entry-form">
                    <div class="item-form-grid">
                        <div class="item-form-group">
                            <label class="item-form-label">Item Description</label>
                            <input type="text" name="medicinename" id="medicinename" class="item-form-input" 
                                   placeholder="Enter item description..." autocomplete="off" onClick="clickmedicine()">
                            <input type="hidden" name="medicinecode" id="medicinecode">
                            <input type="hidden" name="medicinenamel" id="medicinenamel">
                        </div>
                        
                        <div class="item-form-group">
                            <label class="item-form-label">Available Qty</label>
                            <input type="text" name="avlqty" id="avlqty" class="item-form-input" readonly>
                        </div>
                        
                        <div class="item-form-group">
                            <label class="item-form-label">Required Qty</label>
                            <input type="text" name="reqqty" id="reqqty" class="item-form-input" 
                                   placeholder="Qty" autocomplete="off" onKeyUp="calculateAmount()">
                        </div>
                        
                        <div class="item-form-group">
                            <label class="item-form-label">Pack Size</label>
                            <input type="text" name="packsize" id="packsize" class="item-form-input" readonly>
                        </div>
                        
                        <div class="item-form-group">
                            <label class="item-form-label">Package Qty</label>
                            <input type="text" name="pkgqty" id="pkgqty" class="item-form-input" readonly>
                        </div>
                        
                        <div class="item-form-group">
                            <label class="item-form-label">Rate</label>
                            <input type="text" name="rate" id="rate" class="item-form-input" 
                                   placeholder="Rate" readonly onKeyUp="calculateAmount()">
                            <input type="hidden" name="fxrate" id="fxrate">
                        </div>
                        
                        <div class="item-form-group">
                            <label class="item-form-label">Amount</label>
                            <input type="text" name="amount" id="amount" class="item-form-input" readonly>
                        </div>
                        
                        <div class="item-form-group">
                            <button type="button" id="addItemBtn" class="btn btn-success">
                                <i class="fas fa-plus"></i> Add
                            </button>
                        </div>
                    </div>
                    
                    <input type="hidden" name="serialnumber" id="serialnumber" value="1">
                </div>
            </div>
            
            <!-- Items Table Section -->
            <div class="items-table-section">
                <div class="items-table-header">
                    <i class="fas fa-list items-table-icon"></i>
                    <h3 class="items-table-title">Items in Indent</h3>
                </div>
                
                <div class="items-table-container">
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Item Description</th>
                                <th>Required Qty</th>
                                <th>Pack Size</th>
                                <th>Package Qty</th>
                                <th>Rate</th>
                                <th>Amount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="itemsTableBody">
                            <!-- Items will be added dynamically -->
                        </tbody>
                    </table>
                    
                    <!-- Total Amount -->
                    <div class="summary-group">
                        <label class="summary-label">Total Amount</label>
                        <div class="summary-value total-amount" id="total">0.00</div>
                    </div>
                </div>
            </div>
            
            <!-- Summary Section -->
            <div class="summary-section">
                <div class="summary-header">
                    <i class="fas fa-info-circle summary-icon"></i>
                    <h3 class="summary-title">Indent Summary</h3>
                </div>
                
                <div class="summary-content">
                    <div class="summary-grid">
                        <div class="summary-group">
                            <label class="summary-label">Username</label>
                            <input type="text" name="username" class="form-input" value="<?php echo htmlspecialchars($username); ?>" readonly>
                        </div>
                        
                        <div class="summary-group">
                            <label class="summary-label">Status</label>
                            <input type="text" name="status" class="form-input" value="RFA">
                        </div>
                        
                        <div class="summary-group">
                            <label class="summary-label">Priority Level *</label>
                            <div class="priority-group">
                                <div class="priority-option">
                                    <input type="radio" name="priority" id="priority1" value="Critical" class="priority-radio priority-critical" checked>
                                    <label for="priority1" class="priority-label">Critical</label>
                                </div>
                                <div class="priority-option">
                                    <input type="radio" name="priority" id="priority2" value="High" class="priority-radio priority-high">
                                    <label for="priority2" class="priority-label">High</label>
                                </div>
                                <div class="priority-option">
                                    <input type="radio" name="priority" id="priority3" value="Medium" class="priority-radio priority-medium">
                                    <label for="priority3" class="priority-label">Medium</label>
                                </div>
                                <div class="priority-option">
                                    <input type="radio" name="priority" id="priority4" value="Low" class="priority-radio priority-low">
                                    <label for="priority4" class="priority-label">Low</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="summary-group" style="grid-column: 1 / -1;">
                            <label for="remarks" class="summary-label">Memo/Remarks *</label>
                            <textarea name="remarks" id="remarks" class="form-textarea" rows="3" 
                                      placeholder="Enter memo or remarks for this emergency indent..." required></textarea>
                        </div>
                    </div>
                    
                    <!-- Hidden inputs for email -->
                    <input type="hidden" name="piemailfrom" id="piemailfrom" value="<?php echo htmlspecialchars($useremail); ?>">
                    <input type="hidden" name="jobdescription" id="jobdescription" value="<?php echo htmlspecialchars($jobdescription); ?>">
                    <input type="hidden" name="bamailfrom" id="bamailfrom" value="<?php echo htmlspecialchars($emailto); ?>">
                    <input type="hidden" name="bamailcc" id="bamailcc" value="<?php echo htmlspecialchars($emailcc); ?>">
                    
                    <!-- Form Actions -->
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-success btn-large" id="saveIndent">
                            <i class="fas fa-save"></i> Save Emergency Indent
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Hidden form inputs -->
            <input type="hidden" name="frm1submit1" value="frm1submit1">
        </form>
    </main>
</div>

<!-- Modern JavaScript -->
<script src="js/emergency-indent-modern.js?v=<?php echo time(); ?>"></script>

<!-- Legacy JavaScript for compatibility -->
<script>
function clickmedicine() {
    var purchasetype = document.getElementById("purchasetype").value;
    if(purchasetype == '') {
        alert('Please Select Purchase Type');
        document.getElementById("purchasetype").focus();
        return false;
    }
    
    var currency = document.getElementById("currency").value;
    if(currency == '') {
        alert('Please Select currency');
        document.getElementById("currency").focus();
        return false;
    }
    
    var supplierCode = document.getElementById("searchsuppliercode").value;
    if(supplierCode == '') {
        alert('Please Select supplier');
        document.getElementById("searchsuppliername").focus();
        return false;
    }
    
    var lpotype = document.getElementById("lpotype").value;
    if(lpotype == '') {
        alert('Please Select LPO type');
        document.getElementById("lpotype").focus();
        return false;
    }
}

function calculateAmount() {
    var reqqty = document.getElementById("reqqty").value;
    var packsize = document.getElementById("packsize").value;
    var purchasetype = document.getElementById("purchasetype").value;
    var fxamount = document.getElementById("fxamount").value;
    var packvalue = packsize.substring(0, packsize.length - 1);
    
    var rt = document.getElementById("rate").value.replace(/[^0-9\.]+/g,"");
    document.getElementById("fxrate").value = parseFloat(fxamount * rt);
    var rate = document.getElementById("fxrate").value.replace(/[^0-9\.]+/g,"");
    
    rate = parseFloat(rate) / parseFloat(fxamount);
    
    if(reqqty != '') {
        reqqty = reqqty.replace(/[^0-9\.]+/g,"");
    }
    var amount = parseFloat(reqqty) * parseFloat(rate);
    document.getElementById("amount").value = formatMoney(amount.toFixed(2));
    
    var pkgqty = reqqty / packvalue;
    packvalue = parseInt(packvalue);
    if(reqqty < packvalue) {
        pkgqty = 1;
    }
    
    if(purchasetype != 'non-medical' && purchasetype != 'ASSETS') {
        document.getElementById("pkgqty").value = Math.round(pkgqty);
    } else {
        document.getElementById("pkgqty").value = Math.round(1);
    }
}

function formatMoney(number, places, thousand, decimal) {
    number = number || 0;
    places = !isNaN(places = Math.abs(places)) ? places : 2;
    
    thousand = thousand || ",";
    decimal = decimal || ".";
    var negative = number < 0 ? "-" : "",
        i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;
    return negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "");
}
</script>

</body>
</html>
