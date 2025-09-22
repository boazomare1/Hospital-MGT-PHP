<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$companycode = $_SESSION["companycode"];
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = '';

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

// Get financial year
$query31 = "select fromyear,toyear from master_financialyear where status = 'Active' order by auto_number desc";
$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
$res31 = mysqli_fetch_array($exec31);
$finfromyear = $res31['fromyear'];
$fintoyear = $res31['toyear'];

// Handle form submissions
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if (isset($_REQUEST["billnumber"])) { $billnumber = $_REQUEST["billnumber"]; } else { $billnumber = ""; }

if ($frmflag1 == 'frmflag1') {
    // Get expense main details
    $expensemainanum = $_REQUEST['expensemainanum'];
    $query1 = "select * from master_expensemain where auto_number = '$expensemainanum'";
    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res1 = mysqli_fetch_array($exec1);
    $expensemainname = $res1['expensemainname'];

    // Get expense sub details
    $expensesubanum = $_REQUEST['expensesubanum'];
    $query1 = "select * from master_expensesub where auto_number = '$expensesubanum'";
    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res1 = mysqli_fetch_array($exec1);
    $expensesubname = $res1['expensesubname'];

    // Get form data
    $expensedate = $_REQUEST['expensedate'];
    $expenseentrydate = $_REQUEST['expenseentrydate'];
    $expenseamount = $_REQUEST['expenseamount'];
    $expensemode = $_REQUEST['expensemode'];
    $chequenumber = $_REQUEST['chequenumber'];
    $bankname1 = $_REQUEST['bankname'];
    $banknamesplit = explode('|',$bankname1);
    $bankcode = $banknamesplit[0];
    $bankname = $banknamesplit[1];
    $chequedate = $_REQUEST['ADate1'];
    $remarks = $_REQUEST['remarks'];

    // Get company details
    $query3 = "select * from master_company where companystatus = 'Active'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res3 = mysqli_fetch_array($exec3);

    // Generate document number
    $paynowbillprefix = 'EE-';
    $paynowbillprefix1 = strlen($paynowbillprefix);
    $query2 = "select * from expensesub_details order by auto_number desc limit 0, 1";
    $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res2 = mysqli_fetch_array($exec2);
    $billnumber = $res2["docnumber"];
    $billdigit = strlen($billnumber);

    if ($billnumber == '') {
        $billnumbercode = 'EE-1';
        $openingbalance = '0.00';
    } else {
        $billnumber = $res2["docnumber"];
        $billnumbercode = substr($billnumber, $paynowbillprefix1, $billdigit);
        $billnumbercode = intval($billnumbercode);
        $billnumbercode = $billnumbercode + 1;
        $maxanum = $billnumbercode;
        $billnumbercode = 'EE-' . $maxanum;
        $openingbalance = '0.00';
    }

    $docnumber = $billnumbercode;
    $cashcoa = $_REQUEST['cashcoa'];
    $chequecoa = $_REQUEST['chequecoa'];
    $cardcoa = $_REQUEST['cardcoa'];
    $mpesacoa = $_REQUEST['mpesacoa'];
    $onlinecoa = $_REQUEST['onlinecoa'];
    $expenseentrycoa = $_REQUEST['paynowlabcode5'];
    $coaname = $_REQUEST['paynowlabcoa5'];
    $coacode = $_REQUEST['paynowlabcode5'];

    $transactiondate = $expenseentrydate;
    $transactionamount = $expenseamount;
    $transactionmode1 = $expensemode;
    $ipaddress = $ipaddress;
    $updatedate = $updatedatetime;

    // Set transaction details
    $transactiontype1 = $expensename;
    $transactionmodule1 = 'EXPENSE';
    $particulars1 = 'BY EXPENSE - ' . $expensename;

    $docno = $_SESSION['docno'];

    // Get location details
    $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname limit 0,1";
    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
    while ($res1 = mysqli_fetch_array($exec1)) {
        $locationname = $res1["locationname"];
        $locationcode = $res1["locationcode"];
    }

    // Initialize amounts
    $chequeamount = '0.00';
    $cashamount = '0.00';
    $onlineamount = '0.00';
    $cardamount = '0.00';
    $adjustmentamount = '0.00';

    // Handle different payment modes
    if ($expensemode == 'CHEQUE') {
        $chequeamount = $expenseamount;
        
        $query9 = "insert into expensesub_details (expensemainanum, expensemainname, expensesubanum, expensesubname, 
        transactiondate, particulars, transactionmode, transactiontype, transactionamount, ipaddress, 
        cashamount, onlineamount, chequeamount, adjustmentamount, cardamount, 
        updatedate, companyanum, companyname, transactionmodule, 
        chequenumber, bankname, chequedate, remarks, docnumber, expensecoa, username, locationcode, locationname, bankcode, expenseaccount) 
        values ('$expensemainanum', '$expensemainname', '$expensesubanum', '$expensesubname', 
        '$transactiondate', '$particulars1', '$transactionmode1', '$transactiontype1', '$transactionamount', '$ipaddress', 
        '$cashamount', '$onlineamount', '$chequeamount', '$adjustmentamount', '$cardamount', 
        '$updatedate', '$companyanum', '$companyname', '$transactionmodule1', 
        '$chequenumber', '$bankname', '$chequedate', '$remarks', '$docnumber', '$expenseentrycoa', '$username', '$locationcode', '$locationname', '$bankcode', '$coaname')";
        $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

        $query37 = "insert into paymentmodecredit(billnumber,billdate,ipaddress,username,cheque,chequecoa,accountname,accountcode,transactionamount,source)values('$docnumber','$transactiondate','$ipaddress','$username','$chequeamount','$chequecoa','$coaname','$coacode','$chequeamount','expenseentry')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    }

    if ($expensemode == 'CASH') {
        $cashamount = $expenseamount;

        $query9 = "insert into expensesub_details (expensemainanum, expensemainname, expensesubanum, expensesubname, 
        transactiondate, particulars, transactionmode, transactiontype, transactionamount, ipaddress, 
        cashamount, onlineamount, chequeamount, adjustmentamount, cardamount, 
        updatedate, companyanum, companyname, transactionmodule, 
        chequenumber, bankname, chequedate, remarks, docnumber, expensecoa, username, locationcode, locationname, bankcode, expenseaccount) 
        values ('$expensemainanum', '$expensemainname', '$expensesubanum', '$expensesubname', 
        '$transactiondate', '$particulars1', '$transactionmode1', '$transactiontype1', '$transactionamount', '$ipaddress', 
        '$cashamount', '$onlineamount', '$chequeamount', '$adjustmentamount', '$cardamount', 
        '$updatedate', '$companyanum', '$companyname', '$transactionmodule1', 
        '$chequenumber', '$bankname', '$chequedate', '$remarks', '$docnumber', '$expenseentrycoa', '$username', '$locationcode', '$locationname', '$bankcode', '$coaname')";
        $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

        $query37 = "insert into paymentmodecredit(billnumber,billdate,ipaddress,username,cash,cashcoa,accountname,accountcode,transactionamount,source)values('$docnumber','$transactiondate','$ipaddress','$username','$cashamount','$cashcoa','$coaname','$coacode','$cashamount','expenseentry')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    }

    if ($expensemode == 'ONLINE') {
        $onlineamount = $expenseamount;

        $query9 = "insert into expensesub_details (expensemainanum, expensemainname, expensesubanum, expensesubname, 
        transactiondate, particulars, transactionmode, transactiontype, transactionamount, ipaddress, 
        cashamount, onlineamount, chequeamount, adjustmentamount, cardamount, 
        updatedate, companyanum, companyname, transactionmodule, 
        chequenumber, bankname, chequedate, remarks, docnumber, expensecoa, username, locationcode, locationname, bankcode, expenseaccount) 
        values ('$expensemainanum', '$expensemainname', '$expensesubanum', '$expensesubname', 
        '$transactiondate', '$particulars1', '$transactionmode1', '$transactiontype1', '$transactionamount', '$ipaddress', 
        '$cashamount', '$onlineamount', '$chequeamount', '$adjustmentamount', '$cardamount', 
        '$updatedate', '$companyanum', '$companyname', '$transactionmodule1', 
        '$chequenumber', '$bankname', '$chequedate', '$remarks', '$docnumber', '$expenseentrycoa', '$username', '$locationcode', '$locationname', '$bankcode', '$coaname')";
        $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

        $query37 = "insert into paymentmodecredit(billnumber,billdate,ipaddress,username,online,onlinecoa,accountname,accountcode,transactionamount,source)values('$docnumber','$transactiondate','$ipaddress','$username','$onlineamount','$onlinecoa','$coaname','$coacode','$onlineamount','expenseentry')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    }

    if ($expensemode == 'CARD') {
        $cardamount = $expenseamount;

        $query9 = "insert into expensesub_details (expensemainanum, expensemainname, expensesubanum, expensesubname, 
        transactiondate, particulars, transactionmode, transactiontype, transactionamount, ipaddress, 
        cashamount, onlineamount, chequeamount, adjustmentamount, cardamount, 
        updatedate, companyanum, companyname, transactionmodule, 
        chequenumber, bankname, chequedate, remarks, docnumber, expensecoa, username, locationcode, locationname, bankcode, expenseaccount) 
        values ('$expensemainanum', '$expensemainname', '$expensesubanum', '$expensesubname', 
        '$transactiondate', '$particulars1', '$transactionmode1', '$transactiontype1', '$transactionamount', '$ipaddress', 
        '$cashamount', '$onlineamount', '$chequeamount', '$adjustmentamount', '$transactionamount', 
        '$updatedate', '$companyanum', '$companyname', '$transactionmodule1', 
        '$chequenumber', '$bankname', '$chequedate', '$remarks', '$docnumber', '$expenseentrycoa', '$username', '$locationcode', '$locationname', '$bankcode', '$coaname')";
        $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

        $query37 = "insert into paymentmodecredit(billnumber,billdate,ipaddress,username,card,cardcoa,accountname,accountcode,transactionamount,source)values('$docnumber','$transactiondate','$ipaddress','$username','$cardamount','$cardcoa','$coaname','$coacode','$cardamount','expenseentry')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    }

    if ($expensemode == 'ADJUSTMENT') {
        $adjustmentamount = $expenseamount;

        $query9 = "insert into expensesub_details (expensemainanum, expensemainname, expensesubanum, expensesubname, 
        transactiondate, particulars, transactionmode, transactiontype, transactionamount, ipaddress, 
        cashamount, onlineamount, chequeamount, adjustmentamount, cardamount, 
        updatedate, companyanum, companyname, transactionmodule, 
        chequenumber, bankname, chequedate, remarks, docnumber, expensecoa, username, locationcode, locationname, bankcode, expenseaccount) 
        values ('$expensemainanum', '$expensemainname', '$expensesubanum', '$expensesubname', 
        '$transactiondate', '$particulars1', '$transactionmode1', '$transactiontype1', '$transactionamount', '$ipaddress', 
        '$cashamount', '$onlineamount', '$transactionamount', '$adjustmentamount', '$cardamount', 
        '$updatedate', '$companyanum', '$companyname', '$transactionmodule1', 
        '$chequenumber', '$bankname', '$chequedate', '$remarks', '$docnumber', '$expenseentrycoa', '$username', '$locationcode', '$locationname', '$bankcode', '$coaname')";
        $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
    }

    // Check if entry was successful
    $query10 = "select * from expensesub_details where expensemainanum = '$expensemainanum' and expensesubanum = '$expensesubanum' and companyanum = '$companyanum' and updatedate = '$updatedate'";
    $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10 ".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res10 = mysqli_num_rows($exec10);

    if ($res10 != 0) {
        header("location:expenseentry2.php?st=1");
    }

    header("location:expenseentry2.php?st=1&&billnumber=$billnumbercode");
}

// Handle success messages
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == '1') {
    $errmsg = "Success. Expense Payment Entry Updated.";
    $bgcolorcode = 'success';
}

// Generate document number for display
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);

$paynowbillprefix = 'EE-';
$paynowbillprefix1 = strlen($paynowbillprefix);
$query2 = "select * from expensesub_details order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docnumber"];
$billdigit = strlen($billnumber);

if ($billnumber == '') {
    $billnumbercode = 'EE-1';
    $openingbalance = '0.00';
} else {
    $billnumber = $res2["docnumber"];
    $billnumbercode = substr($billnumber, $paynowbillprefix1, $billdigit);
    $billnumbercode = intval($billnumbercode);
    $billnumbercode = $billnumbercode + 1;
    $maxanum = $billnumbercode;
    $billnumbercode = 'EE-' . $maxanum;
    $openingbalance = '0.00';
}

// Get financial integration codes
$query765 = "select * from master_financialintegration where field='cashexpenseentry'";
$exec765 = mysqli_query($GLOBALS["___mysqli_ston"], $query765) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res765 = mysqli_fetch_array($exec765);
$cashcoa = $res765['code'];

$query766 = "select * from master_financialintegration where field='chequeexpenseentry'";
$exec766 = mysqli_query($GLOBALS["___mysqli_ston"], $query766) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res766 = mysqli_fetch_array($exec766);
$chequecoa = $res766['code'];

$query767 = "select * from master_financialintegration where field='mpesaexpenseentry'";
$exec767 = mysqli_query($GLOBALS["___mysqli_ston"], $query767) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res767 = mysqli_fetch_array($exec767);
$mpesacoa = $res767['code'];

$query768 = "select * from master_financialintegration where field='cardexpenseentry'";
$exec768 = mysqli_query($GLOBALS["___mysqli_ston"], $query768) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res768 = mysqli_fetch_array($exec768);
$cardcoa = $res768['code'];

$query769 = "select * from master_financialintegration where field='onlineexpenseentry'";
$exec769 = mysqli_query($GLOBALS["___mysqli_ston"], $query769) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res769 = mysqli_fetch_array($exec769);
$onlinecoa = $res769['code'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Entry - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/expense-entry-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Legacy CSS for datepicker -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <!-- Legacy JavaScript -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script type="text/javascript" src="js/autocomplete_customer1.js"></script>
    <script type="text/javascript" src="js/autosuggest3.js"></script>
    <script type="text/javascript" src="js/expensefunction.js"></script>
    <script src="js/datetimepicker_css_fin.js"></script>
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
        <a href="financial_master.php">Financial Management</a>
        <span>→</span>
        <span>Expense Entry</span>
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
                        <a href="financial_master.php" class="nav-link">
                            <i class="fas fa-calculator"></i>
                            <span>Financial Management</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="expenseentry2.php" class="nav-link">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Expense Entry</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="income_entry.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Income Entry</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="expense_reports.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Expense Reports</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="payment_modes.php" class="nav-link">
                            <i class="fas fa-credit-card"></i>
                            <span>Payment Modes</span>
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
                    <div class="alert alert-<?php echo $bgcolorcode; ?>">
                        <i class="fas fa-<?php echo $bgcolorcode === 'success' ? 'check-circle' : 'exclamation-triangle'; ?> alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Expense Entry</h2>
                    <p>Record and manage expense transactions with multiple payment modes.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="printPreviousReceipt()">
                        <i class="fas fa-print"></i> Print Receipt
                    </button>
                </div>
            </div>
            
            <!-- Expense Entry Form -->
            <div class="form-section">
                <div class="section-header">
                    <i class="fas fa-money-bill-wave"></i>
                    <h3>Expense Entry Details</h3>
                    <span class="form-help">* Indicates mandatory fields</span>
                </div>
                
                <form name="form1" id="form1" method="post" action="expenseentry2.php" onSubmit="return paymententry1process1()">
                    <!-- Account Selection -->
                    <div class="form-group full-width">
                        <label for="paynowreferalcoa" class="form-label required">Expense Account</label>
                        <div class="account-selection">
                            <input type="text" name="paynowlabcoa5" id="paynowreferalcoa" class="form-input" 
                                   placeholder="Select expense account..." readonly>
                            <button type="button" onClick="javascript:coasearch('4')" class="btn btn-outline">
                                <i class="fas fa-search"></i>
                                Select Account
                            </button>
                        </div>
                        <input type="hidden" name="paynowlabtype5" id="paynowreferaltype">
                        <input type="hidden" name="paynowlabcode5" id="paynowreferalcode">
                        
                        <!-- Hidden COA values -->
                        <input type="hidden" name="cashcoa" value="<?php echo htmlspecialchars($cashcoa); ?>">
                        <input type="hidden" name="chequecoa" value="<?php echo htmlspecialchars($chequecoa); ?>">
                        <input type="hidden" name="mpesacoa" value="<?php echo htmlspecialchars($mpesacoa); ?>">
                        <input type="hidden" name="cardcoa" value="<?php echo htmlspecialchars($cardcoa); ?>">
                        <input type="hidden" name="onlinecoa" value="<?php echo htmlspecialchars($onlinecoa); ?>">
                    </div>
                    
                    <!-- Balance Display -->
                    <div class="balance-display" id="balanceSection" style="display: none;">
                        <div class="balance-info">
                            <i class="fas fa-wallet"></i>
                            <span>Available Balance:</span>
                            <span class="balance-amount" id="balanceAmount">0.00</span>
                        </div>
                    </div>
                    
                    <!-- Form Grid -->
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="docnumber" class="form-label">Document Number</label>
                            <input type="text" name="docnumber" id="docnumber" value="<?php echo htmlspecialchars($billnumbercode); ?>" 
                                   class="form-input readonly" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="expenseentrydate" class="form-label required">Entry Date</label>
                            <div class="date-input-container">
                                <input name="expenseentrydate" id="expenseentrydate" value="<?php echo date('Y-m-d'); ?>" 
                                       class="form-input datepicker-input" readonly>
                                <i class="fas fa-calendar-alt datepicker-icon" 
                                   onClick="javascript:NewCssCal('expenseentrydate','','','','','','past','<?= $finfromyear; ?>','<?= $fintoyear; ?>')"></i>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="expenseamount" class="form-label required">Expense Amount</label>
                            <div class="amount-input-container">
                                <span class="currency-symbol">$</span>
                                <input name="expenseamount" id="expenseamount" value="0.00" 
                                       class="form-input amount-input" placeholder="0.00">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="expensemode" class="form-label required">Payment Mode</label>
                            <select name="expensemode" id="expensemode" class="form-select" onchange="showPaymentFields()">
                                <option value="">SELECT</option>
                                <option value="CHEQUE">CHEQUE</option>
                                <option value="CASH">CASH</option>
                                <option value="ONLINE">ONLINE</option>
                                <option value="CARD">CARD</option>
                                <option value="ADJUSTMENT">ADJUSTMENT</option>
                            </select>
                        </div>
                        
                        <div class="form-group" id="chequeNumberGroup" style="display: none;">
                            <label for="chequenumber" class="form-label">Cheque Number</label>
                            <input name="chequenumber" id="chequenumber" class="form-input" placeholder="Enter cheque number">
                        </div>
                        
                        <div class="form-group">
                            <label for="bankname" class="form-label required">Account Name</label>
                            <select name="bankname" id="bankname" class="form-select">
                                <option value="">Select Account</option>
                                <?php 
                                $querybankname = "select id, accountname from master_accountname where accountssub IN ('9') and recordstatus <> 'deleted'";
                                $execbankname = mysqli_query($GLOBALS["___mysqli_ston"], $querybankname) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($resbankname = mysqli_fetch_array($execbankname)) {
                                ?>
                                <option value="<?php echo $resbankname['id'].'|'.$resbankname['accountname'];?>">
                                    <?php echo htmlspecialchars($resbankname['accountname']); ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        
                        <div class="form-group" id="chequeDateGroup" style="display: none;">
                            <label for="ADate1" class="form-label">Cheque Date</label>
                            <div class="date-input-container">
                                <input name="ADate1" id="ADate1" class="form-input datepicker-input" readonly>
                                <i class="fas fa-calendar-alt datepicker-icon" 
                                   onClick="javascript:NewCssCal('ADate1','','','','','','past','<?= $finfromyear; ?>','<?= $fintoyear; ?>')"></i>
                            </div>
                        </div>
                        
                        <div class="form-group full-width">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea name="remarks" id="remarks" class="form-textarea" 
                                      placeholder="Enter any additional remarks or notes..."></textarea>
                        </div>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="form-actions">
                        <input type="hidden" name="frmflag1" value="frmflag1">
                        <button type="submit" name="Submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Save Expense
                        </button>
                        <button type="reset" name="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i>
                            Reset Form
                        </button>
                        <button type="button" class="btn btn-outline" onclick="checkBalance()">
                            <i class="fas fa-wallet"></i>
                            Check Balance
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Help Section -->
            <div class="help-section">
                <div class="help-header">
                    <i class="fas fa-info-circle"></i>
                    <h3>Quick Help</h3>
                </div>
                <div class="help-content">
                    <div class="help-item">
                        <i class="fas fa-print"></i>
                        <div>
                            <strong>Print Receipts:</strong> Use the "Print Receipt" button to print previous expense entries.
                        </div>
                    </div>
                    <div class="help-item">
                        <i class="fas fa-chart-bar"></i>
                        <div>
                            <strong>Expense Reports:</strong> Go to Reports → Expense Report for detailed expense analysis.
                        </div>
                    </div>
                    <div class="help-item">
                        <i class="fas fa-wallet"></i>
                        <div>
                            <strong>Balance Check:</strong> Click "Check Balance" to view available cash balance before making entries.
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <!-- Modern JavaScript -->
    <script src="js/expense-entry-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy JavaScript for compatibility -->
    <script language="javascript">
        // Legacy functions preserved for compatibility
        function cbcustomername1() {
            document.cbform1.submit();
        }
        
        function disableEnterKey(varPassed) {
            if (event.keyCode == 8) {
                event.keyCode = 0; 
                return event.keyCode 
                return false;
            }
            
            var key;
            if(window.event) {
                key = window.event.keyCode;     //IE
            } else {
                key = e.which;     //firefox
            }
            
            if(key == 13) { // if enter key press
                return false;
            } else {
                return true;
            }
        }
        
        function process1backkeypress1() {
            if (event.keyCode == 8) {
                event.keyCode = 0; 
                return event.keyCode 
                return false;
            }
        }
        
        function disableEnterKey() {
            if (event.keyCode == 8) {
                event.keyCode = 0; 
                return event.keyCode 
                return false;
            }
            
            var key;
            if(window.event) {
                key = window.event.keyCode;     //IE
            } else {
                key = e.which;     //firefox
            }
            
            if(key == 13) { // if enter key press
                return false;
            } else {
                return true;
            }
        }
        
        function paymententry1process1() {
            if (document.getElementById("paynowreferalcode").value == "") {
                alert("Please Select an Account");
                document.getElementById("paynowreferalcode").focus();
                return false;
            }
            
            if (document.getElementById("expenseamount").value == "") {
                alert("Expense Amount Cannot Be Empty.");
                document.getElementById("expenseamount").focus();
                document.getElementById("expenseamount").value = "0.00"
                return false;
            }
            
            if (document.getElementById("expenseamount").value == "0.00") {
                alert("Expense Amount Cannot Be Empty.");
                document.getElementById("expenseamount").focus();
                document.getElementById("expenseamount").value = "0.00"
                return false;
            }
            
            if (isNaN(document.getElementById("expenseamount").value)) {
                alert("Expense Amount Can Only Be Numbers.");
                document.getElementById("expenseamount").focus();
                return false;
            }
            
            if (document.getElementById("expensemode").value == "") {
                alert("Please Select Expense Mode.");
                document.getElementById("expensemode").focus();
                return false;
            }
            
            if (document.getElementById("expensemode").value == "CHEQUE") {
                if(document.getElementById("chequenumber").value == "") {
                    alert("If Expense By Cheque, Then Cheque Number Cannot Be Empty.");
                    document.getElementById("chequenumber").focus();
                    return false;
                } else if (document.getElementById("ADate1").value == "") {
                    alert("If Expense By Cheque, Then Cheque Date Cannot Be Empty.");
                    document.getElementById("ADate1").focus();
                    return false;
                }
            }
            
            if (document.getElementById("bankname").value == "") {
                alert("Account Name Cannot Be Empty.");
                document.getElementById("bankname").focus();
                return false;
            }
            
            var varUserChoice; 
            varUserChoice = confirm('Are You Sure Want To Save This Entry?'); 
            
            if (varUserChoice == false) {
                alert("Entry Not Saved.");
                return false;
            }
        }
        
        function funcPrintReceipt1() {
            window.open("print_expense_receipt1.php?billnumber=<?php echo $billnumber; ?>","OriginalWindow1",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
        }
        
        function balances() {
            var balance = 0;
            var mode = document.getElementById("expensemode").value;
            
            if(mode == 'CASH'){
                <?php
                $querydcash = "SELECT SUM(cash) AS totalcash FROM paymentmodedebit";
                $execdcash = mysqli_query($GLOBALS["___mysqli_ston"], $querydcash) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                $resdcash= mysqli_fetch_array($execdcash);
                $debitcash = $resdcash['totalcash'];
                
                $queryccash = "SELECT SUM(cash) AS totalccash FROM paymentmodecredit";
                $execccash = mysqli_query($GLOBALS["___mysqli_ston"], $queryccash) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                $resccash= mysqli_fetch_array($execccash);
                $creditcash = $resccash['totalccash'];
                $balance = $debitcash - $creditcash;
                ?>
                
                var balance = '<?php echo number_format($balance,2,'.',','); ?>';
                document.getElementById("balanceSection").style.display = 'block';
                document.getElementById("balanceAmount").textContent = balance;
                
                if((document.getElementById("expenseamount").value) >= balance) { 
                    alert("The expense amount should be less than of balance amount"); 
                }
            } else {
                document.getElementById("balanceSection").style.display = 'none';
            }
        }
        
        function coasearch(varCallFrom) {
            var varCallFrom = varCallFrom;
            window.open("popup_coasearchexpense.php?callfrom="+varCallFrom,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
        }
        
        // Modern functions
        function refreshPage() {
            window.location.reload();
        }
        
        function printPreviousReceipt() {
            funcPrintReceipt1();
        }
        
        function checkBalance() {
            balances();
        }
        
        function showPaymentFields() {
            const mode = document.getElementById('expensemode').value;
            const chequeNumberGroup = document.getElementById('chequeNumberGroup');
            const chequeDateGroup = document.getElementById('chequeDateGroup');
            
            if (mode === 'CHEQUE') {
                chequeNumberGroup.style.display = 'block';
                chequeDateGroup.style.display = 'block';
            } else {
                chequeNumberGroup.style.display = 'none';
                chequeDateGroup.style.display = 'none';
            }
        }
    </script>
</body>
</html>
