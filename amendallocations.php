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

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

//This include updatation takes too long to load for hunge items database.
include ("autocompletebuild_accounts.php");

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

if ($getcanum != '') {
    $query4 = "select * from master_supplier where auto_number = '$getcanum'";
    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res4 = mysqli_fetch_array($exec4);
    $cbsuppliername = $res4['suppliername'];
    $suppliername = $res4['suppliername'];
}

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

if ($cbfrmflag1 == 'cbfrmflag1') {
    $searchsuppliername = $_POST['searchsuppliername'];
    if ($searchsuppliername != '') {
        $arraysupplier = explode("#", $searchsuppliername);
        $arraysuppliername = $arraysupplier[0];
        $arraysuppliername = trim($arraysuppliername);
        $arraysuppliercode = $arraysupplier[1];
        
        $query1 = "select * from master_supplier where suppliercode = '$arraysuppliercode'";
        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res1 = mysqli_fetch_array($exec1);
        $supplieranum = $res1['auto_number'];
        $openingbalance = $res1['openingbalance'];
        
        $cbsuppliername = $arraysuppliername;
        $suppliername = $arraysuppliername;
    } else {
        $cbsuppliername = $_REQUEST['cbsuppliername'];
        $suppliername = $_REQUEST['cbsuppliername'];
    }
}

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

if ($frmflag2 == 'frmflag2') {
    //For generating first code
    include ("transactioncodegenerate1pharmacy.php");

    $query2 = "select * from settings_approval where modulename = 'collection' and status <> 'deleted'";
    $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res2 = mysqli_fetch_array($exec2);
    $approvalrequired = $res2['approvalrequired'];
    if ($approvalrequired == 'YES') {
        $approvalstatus = 'PENDING';
    } else {
        $approvalstatus = 'APPROVED';
    }
    
    $query8 = "select * from master_supplier where auto_number = '$cbfrmflag2'";
    $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res8 = mysqli_fetch_array($exec8);
    $res8suppliername = $res8['suppliername'];
    
    $paymententrydate = $_REQUEST['paymententrydate'];
    $paymentmode = $_REQUEST['paymentmode'];
    $cashamount = $_REQUEST['cashamount'];
    $cardamount = $_REQUEST['cardamount'];
    $onlineamount = $_REQUEST['onlineamount'];
    $chequeamount = $_REQUEST['chequeamount'];
    $tdsamount = $_REQUEST['tdsamount'];
    $writeoffamount = $_REQUEST['writeoffamount'];
    $chequenumber = $_REQUEST['chequenumber'];
    $bankname = $_REQUEST['bankname'];
    $chequedate = $_REQUEST['chequedate'];
    $remarks = $_REQUEST['remarks'];
    
    $totalpayment = $cashamount + $cardamount + $onlineamount + $chequeamount + $tdsamount + $writeoffamount;
    
    if ($paymentmode == 'CHEQUE' && $chequenumber == '') {
        $errmsg = "If Payment By Cheque, Then Cheque Number Cannot Be Empty.";
        $bgcolorcode = 'error';
    } elseif ($paymentmode == 'CHEQUE' && $bankname == '') {
        $errmsg = "If Payment By Cheque, Then Bank Name Cannot Be Empty.";
        $bgcolorcode = 'error';
    } else {
        $fRet = confirm('Are you sure want to save this payment entry?');
        if ($fRet == true) {
            $pendingamounthidden = $_REQUEST['pendingamounthidden'];
            $varPendingAmount = $pendingamounthidden;
            
            if ($totalpayment > $varPendingAmount) {
                $errmsg = 'Payment Amount Is Greater Than Pending Amount. Entry Cannot Be Saved.';
                $bgcolorcode = 'error';
            } else {
                // Process the payment entry
                $query9 = "INSERT INTO master_transactionpaylater (transactiondate, docno, transactiontype, transactionamount, transactionmodule, patientname, patientcode, visitcode, accountname, doctorname, billstatus) VALUES ('$paymententrydate','$docno','$paymentmode','$totalpayment','$transactionmodule','$name3','$patientcode','$visitcode','$accountname','$doctorname','$billstatus')";
                $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
                
                header ("location:paylaterpaymententry.php?st=1");
                exit;
            }
        }
    }
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if ($st == '1') {
    $errmsg = "Success. Payment Entry Update Completed.";
    $bgcolorcode = 'success';
}
if ($st == '2') {
    $errmsg = "Failed. Payment Entry Not Completed.";
    $bgcolorcode = 'error';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amend Allocations - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/amendallocations-modern.css?v=<?php echo time(); ?>">
    
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
        <span>Amend Allocations</span>
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
                        <a href="advancedeposit.php" class="nav-link">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Advance Deposit</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addalertmessage1.php" class="nav-link">
                            <i class="fas fa-bell"></i>
                            <span>Alert Messages</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ar_allocatedreport.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>AR Allocated Report</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="amendallocations.php" class="nav-link">
                            <i class="fas fa-edit"></i>
                            <span>Amend Allocations</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="newpatient.php" class="nav-link">
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
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer">
                <?php if (!empty($errmsg)): ?>
                    <div class="alert alert-<?php echo $bgcolorcode === 'success' ? 'success' : ($bgcolorcode === 'error' ? 'error' : 'info'); ?>">
                        <i class="fas fa-<?php echo $bgcolorcode === 'success' ? 'check-circle' : ($bgcolorcode === 'error' ? 'exclamation-triangle' : 'info-circle'); ?> alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Amend Allocations</h2>
                    <p>Manage and modify payment allocations for outstanding balances and refunds.</p>
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

            <!-- Search Form Section -->
            <div class="search-form-section">
                <div class="search-form-header">
                    <i class="fas fa-search search-form-icon"></i>
                    <h3 class="search-form-title">Search Criteria</h3>
                </div>
                
                <form name="cbform1" method="post" action="amendallocations.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="searchsuppliername" class="form-label">Search Account</label>
                            <input name="searchsuppliername" type="text" id="searchsuppliername" 
                                   value="<?php echo htmlspecialchars($searchsuppliername); ?>" 
                                   class="form-input" placeholder="Enter account name..." autocomplete="off">
                            <input name="searchsuppliernamehiddentextbox" id="searchsuppliernamehiddentextbox" type="hidden" value="">
                            <input name="searchsupplieranum" id="searchsupplieranum" 
                                   value="<?php echo htmlspecialchars($supplieranum); ?>" type="hidden">
                        </div>
                        
                        <div class="form-group">
                            <label for="cbsuppliername" class="form-label">Account Name</label>
                            <input name="cbsuppliername" type="text" id="cbsuppliername" 
                                   value="<?php echo htmlspecialchars($cbsuppliername); ?>" 
                                   class="form-input" readonly>
                        </div>
                    </div>

                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-search"></i>
                            Search
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetSearchForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <?php if ($cbfrmflag1 == 'cbfrmflag1'): ?>
            <!-- Payment Entry Form Section -->
            <div class="payment-form-section">
                <div class="payment-form-header">
                    <i class="fas fa-credit-card payment-form-icon"></i>
                    <h3 class="payment-form-title">Payment Entry</h3>
                </div>
                
                <form name="form1" id="form1" method="post" action="amendallocations.php?cbfrmflag1=<?php echo $cbfrmflag1; ?>" class="payment-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="paymententrydate" class="form-label">Payment Date</label>
                            <input type="date" name="paymententrydate" id="paymententrydate" 
                                   value="<?php echo date('Y-m-d'); ?>" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="paymentmode" class="form-label">Payment Mode</label>
                            <select name="paymentmode" id="paymentmode" class="form-input" onchange="togglePaymentFields()">
                                <option value="">--Select Payment Mode--</option>
                                <option value="CASH">Cash</option>
                                <option value="CARD">Card</option>
                                <option value="ONLINE">Online</option>
                                <option value="CHEQUE">Cheque</option>
                                <option value="TDS">TDS</option>
                                <option value="WRITEOFF">Write Off</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="cashamount" class="form-label">Cash Amount</label>
                            <input type="number" name="cashamount" id="cashamount" 
                                   value="0.00" step="0.01" min="0" class="form-input" onchange="calculateTotal()">
                        </div>
                        
                        <div class="form-group">
                            <label for="cardamount" class="form-label">Card Amount</label>
                            <input type="number" name="cardamount" id="cardamount" 
                                   value="0.00" step="0.01" min="0" class="form-input" onchange="calculateTotal()">
                        </div>
                        
                        <div class="form-group">
                            <label for="onlineamount" class="form-label">Online Amount</label>
                            <input type="number" name="onlineamount" id="onlineamount" 
                                   value="0.00" step="0.01" min="0" class="form-input" onchange="calculateTotal()">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="chequeamount" class="form-label">Cheque Amount</label>
                            <input type="number" name="chequeamount" id="chequeamount" 
                                   value="0.00" step="0.01" min="0" class="form-input" onchange="calculateTotal()">
                        </div>
                        
                        <div class="form-group">
                            <label for="tdsamount" class="form-label">TDS Amount</label>
                            <input type="number" name="tdsamount" id="tdsamount" 
                                   value="0.00" step="0.01" min="0" class="form-input" onchange="calculateTotal()">
                        </div>
                        
                        <div class="form-group">
                            <label for="writeoffamount" class="form-label">Write Off Amount</label>
                            <input type="number" name="writeoffamount" id="writeoffamount" 
                                   value="0.00" step="0.01" min="0" class="form-input" onchange="calculateTotal()">
                        </div>
                    </div>

                    <div class="form-row" id="chequeFields" style="display: none;">
                        <div class="form-group">
                            <label for="chequenumber" class="form-label">Cheque Number</label>
                            <input type="text" name="chequenumber" id="chequenumber" 
                                   class="form-input" placeholder="Enter cheque number">
                        </div>
                        
                        <div class="form-group">
                            <label for="bankname" class="form-label">Bank Name</label>
                            <input type="text" name="bankname" id="bankname" 
                                   class="form-input" placeholder="Enter bank name">
                        </div>
                        
                        <div class="form-group">
                            <label for="chequedate" class="form-label">Cheque Date</label>
                            <input type="date" name="chequedate" id="chequedate" 
                                   class="form-input">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea name="remarks" id="remarks" class="form-input" 
                                      placeholder="Enter any additional remarks..." rows="3"></textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="totalpayment" class="form-label">Total Payment</label>
                            <input type="text" name="totalpayment" id="totalpayment" 
                                   value="0.00" class="form-input" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="pendingamounthidden" class="form-label">Pending Amount</label>
                            <input type="text" name="pendingamounthidden" id="pendingamounthidden" 
                                   value="<?php echo $totalbalance; ?>" class="form-input" readonly>
                        </div>
                    </div>

                    <div class="form-actions">
                        <input type="hidden" name="frmflag2" value="frmflag2">
                        <input type="hidden" name="cbfrmflag2" value="<?php echo $supplieranum; ?>">
                        <button type="submit" id="submitBtn" class="submit-btn">
                            <i class="fas fa-save"></i>
                            Save Payment Entry
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetPaymentForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Data Table Section -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-table data-table-icon"></i>
                    <h3 class="data-table-title">Outstanding Bills and Refunds</h3>
                </div>

                <div class="table-container">
                    <table class="data-table" id="amendAllocationsTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Select</th>
                                <th>Patient Name (Visit Code)</th>
                                <th>Bill Number</th>
                                <th>Bill Date</th>
                                <th>Bill Amount</th>
                                <th>Days After Bill</th>
                                <th>Net Payment</th>
                                <th>Last Payment Date</th>
                                <th>Days After Payment</th>
                                <th>Balance Amount</th>
                                <th>Adjustment Amount</th>
                                <th>Balance After Adjustment</th>
                            </tr>
                        </thead>
                        <tbody id="amendAllocationsTableBody">
                            <?php 
                            if ($cbfrmflag1 == 'cbfrmflag1') {
                                $sno = 0;
                                $totalbalance = 0;
                                
                                // Query for outstanding bills
                                $query1 = "SELECT * FROM master_transactionpaylater WHERE accountnameid = '$supplieranum' AND transactiontype = 'finalize' AND billnumber != '' AND recordstatus != 'deleted' ORDER BY transactiondate DESC";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $billnumber = $res1['billnumber'];
                                    $billdate = $res1['transactiondate'];
                                    $billtotalamount = $res1['transactionamount'];
                                    $name = $res1['patientname'];
                                    $visitcode = $res1['visitcode'];
                                    $doctorname = $res1['doctorname'];
                                    $accountname = $res1['accountname'];
                                    
                                    // Calculate days after bill date
                                    $billdateobj = new DateTime($billdate);
                                    $today = new DateTime();
                                    $daysafterbilldate = $today->diff($billdateobj)->days;
                                    
                                    // Get payment details
                                    $query2 = "SELECT SUM(transactionamount) as totalpayment FROM master_transactionpaylater WHERE billnumber = '$billnumber' AND transactiontype = 'PAYMENT' AND recordstatus = 'allocated'";
                                    $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res2 = mysqli_fetch_array($exec2);
                                    $netpayment = $res2['totalpayment'] ?: 0;
                                    
                                    $balanceamount = $billtotalamount - $netpayment;
                                    
                                    // Get last payment date
                                    $query3 = "SELECT MAX(transactiondate) as lastpaymentdate FROM master_transactionpaylater WHERE billnumber = '$billnumber' AND transactiontype = 'PAYMENT' AND recordstatus = 'allocated'";
                                    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res3 = mysqli_fetch_array($exec3);
                                    $lastpaymentdate = $res3['lastpaymentdate'] ?: '';
                                    
                                    if ($lastpaymentdate != '') {
                                        $lastpaymentdateobj = new DateTime($lastpaymentdate);
                                        $daysafterpaymentdate = $today->diff($lastpaymentdateobj)->days;
                                    } else {
                                        $daysafterpaymentdate = '';
                                    }
                                    
                                    $sno++;
                                    $totalbalance += $balanceamount;
                            ?>
                            <tr class="<?php echo ($sno % 2 == 0) ? 'even-row' : 'odd-row'; ?>">
                                <td><?php echo $sno; ?></td>
                                <td>
                                    <input type="checkbox" id="acknow<?php echo $sno; ?>" 
                                           value="<?php echo $billnumber; ?>" 
                                           onClick="updatebox('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $sno; ?>')">
                                </td>
                                <td>
                                    <div class="patient-info">
                                        <span class="patient-name"><?php echo htmlspecialchars($name); ?></span>
                                        <span class="visit-code">(<?php echo htmlspecialchars($visitcode); ?>)</span>
                                    </div>
                                    <input type="hidden" name="name[]" value="<?php echo htmlspecialchars($name); ?>">
                                    <input type="hidden" name="visitcode[]" value="<?php echo htmlspecialchars($visitcode); ?>">
                                    <input type="hidden" name="accountname[]" value="<?php echo htmlspecialchars($accountname); ?>">
                                    <input type="hidden" name="doctorname[]" value="<?php echo htmlspecialchars($doctorname); ?>">
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($billnumber); ?>
                                    <input type="hidden" name="billnum[]" value="<?php echo htmlspecialchars($billnumber); ?>">
                                </td>
                                <td><?php echo htmlspecialchars($billdate); ?></td>
                                <td class="amount-cell">
                                    <?php if ($billtotalamount != '0.00') echo number_format($billtotalamount, 2); ?>
                                    <input type="hidden" name="billamount" id="bill" value="<?php if ($billtotalamount != '0.00') echo $billtotalamount; ?>">
                                </td>
                                <td class="days-cell"><?php echo $daysafterbilldate; ?> Days</td>
                                <td class="amount-cell">
                                    <?php if ($netpayment != '0.00') echo number_format($netpayment, 2); ?>
                                </td>
                                <td><?php echo $lastpaymentdate ? htmlspecialchars($lastpaymentdate) : '-'; ?></td>
                                <td class="days-cell">
                                    <?php if ($daysafterpaymentdate != '') echo $daysafterpaymentdate.' Days'; ?>
                                </td>
                                <td class="amount-cell">
                                    <?php if ($balanceamount != '0.00') echo number_format($balanceamount, 2); ?>
                                </td>
                                <td>
                                    <input class="adjustment-input" type="text" name="adjamount[]" 
                                           id="adjamount<?php echo $sno; ?>" size="7" 
                                           onClick="checkboxcheck('<?php echo $sno; ?>')" 
                                           onKeyUp="balancecalc('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $sno; ?>')"
                                           placeholder="0.00">
                                </td>
                                <td>
                                    <input type="text" class="balance-input" name="balamount[]" 
                                           id="balamount<?php echo $sno; ?>" size="7" readonly="readonly">
                                </td>
                            </tr>
                            <?php 
                                }
                                
                                // Query for refunds
                                $query55 = "SELECT * FROM refund_paylater WHERE finalizationbillno IN (SELECT billnumber FROM master_transactionpaylater WHERE accountnameid = '$supplieranum' AND transactiontype = 'finalize' AND billnumber != '' AND recordstatus != 'deleted') AND billstatus = ''";
                                $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                $rows = mysqli_num_rows($exec55);
                                
                                if($rows > 0) {
                                    while($res55 = mysqli_fetch_array($exec55)) {
                                        $billno = $res55['billno'];
                                        $totalamount = $res55['totalamount'];
                                        $date = $res55['billdate'];
                                        $totalbalance += $totalamount;
                                        $sno++;
                            ?>
                            <tr class="<?php echo ($sno % 2 == 0) ? 'even-row' : 'odd-row'; ?> refund-row">
                                <td><?php echo $sno; ?></td>
                                <td>
                                    <input type="checkbox" id="acknow<?php echo $sno; ?>" 
                                           value="<?php echo $billnumber; ?>" 
                                           onClick="updatebox('<?php echo $sno; ?>','<?php echo $totalamount; ?>','<?php echo $sno; ?>')">
                                </td>
                                <td>
                                    <div class="patient-info">
                                        <span class="patient-name"><?php echo htmlspecialchars($name); ?></span>
                                        <span class="visit-code">(<?php echo htmlspecialchars($visitcode); ?>)</span>
                                    </div>
                                </td>
                                <td><?php echo htmlspecialchars($billno); ?></td>
                                <td><?php echo htmlspecialchars($date); ?></td>
                                <td class="amount-cell">-</td>
                                <td class="days-cell">-</td>
                                <td class="amount-cell">-</td>
                                <td>-</td>
                                <td class="days-cell">-</td>
                                <td class="amount-cell">
                                    <?php if ($totalamount != '0.00') echo number_format($totalamount, 2); ?>
                                </td>
                                <td>
                                    <input class="adjustment-input" type="text" name="adjamount[]" 
                                           id="adjamount<?php echo $sno; ?>" size="7" 
                                           onClick="checkboxcheck('<?php echo $sno; ?>')" 
                                           onKeyUp="balancecalc('<?php echo $sno; ?>','<?php echo $totalamount; ?>','<?php echo $sno; ?>')"
                                           placeholder="0.00">
                                </td>
                                <td>
                                    <input type="text" class="balance-input" name="balamount[]" 
                                           id="balamount<?php echo $sno; ?>" size="7" readonly="readonly">
                                </td>
                            </tr>
                            <?php 
                                    }
                                }
                            ?>
                            <tr class="total-row">
                                <td colspan="10" class="total-label">Total Balance</td>
                                <td class="total-amount"><?php echo number_format($totalbalance, 2); ?></td>
                                <td>
                                    <input type="text" name="totaladjamt" id="totaladjamt" 
                                           size="7" class="total-adjustment-input" readonly>
                                </td>
                                <td></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/amendallocations-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>



