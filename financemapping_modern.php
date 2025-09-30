<?php
session_start();
include ("db/db_connect.php");
include ("includes/loginverify.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$registrationdate = date('Y-m-d');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$docno = $_SESSION['docno'];

$todaydate = isset($_REQUEST['ADate1']) ? $_REQUEST['ADate1'] : date("Y-m-d");
$fromdate = isset($_REQUEST['ADate1']) ? $_REQUEST['ADate1'] : date("Y-m-d");
$todate = isset($_REQUEST['ADate2']) ? $_REQUEST['ADate2'] : date("Y-m-d");
$time = strtotime($todaydate);
$month = date("m", $time);
$year = date("Y", $time);

$thismonth = $year . "-" . $month . "___";

// Get location for sort by location purpose
$location = isset($_REQUEST['locationcode']) ? $_REQUEST['locationcode'] : '';
if ($location != '') {
    $locationcode = $location;
}

$errmsg = "";
$bgcolorcode = "";

// Handle form submission
if (isset($_REQUEST["frmflag1"])) { 
    $frmflag1 = $_REQUEST["frmflag1"]; 
} else { 
    $frmflag1 = ""; 
}

if ($frmflag1 == 'frmflag1') {
    for ($i = 1; $i <= 30; $i++) { 
        $ledger_id = $_REQUEST['ledger_id' . $i];
        $ledger_name = $_REQUEST['ledger_name' . $i];
        $acc_id = $_REQUEST['account_id' . $i];

        $date = date('Y-m-d H:i:s');
        
        $query_finance_check = "SELECT * FROM finance_ledger_mapping WHERE map_anum = '$acc_id'";
        $exec_finance_check = mysqli_query($GLOBALS["___mysqli_ston"], $query_finance_check) or die ("Error in query_finance_check" . mysqli_error($GLOBALS["___mysqli_ston"]));
        $check_rows = mysqli_num_rows($exec_finance_check);
        
        if ($check_rows > 0) {
            // Record exists - update
            $query_update = "UPDATE finance_ledger_mapping SET ledger_id='$ledger_id', ledger_name='$ledger_name', financetype='', user_id='$username', ip_address='$ipaddress', location_code='$locationcode' WHERE map_anum='$acc_id'";
            $exec_update = mysqli_query($GLOBALS["___mysqli_ston"], $query_update) or die ("Error in query_update" . mysqli_error($GLOBALS["___mysqli_ston"]));

            $bgcolorcode = 'success';	
            $errmsg = "Record Updated!";
            header("Location: financemapping.php?st=success");	
        } else {
            // Record doesn't exist - insert
            $query_insert = "INSERT INTO `finance_ledger_mapping`(`map_anum`, `financetype`, `ledger_id`, `ledger_name`, `created_at`, `updated_at`, `record_status`, `user_id`, `ip_address`, `location_code`) VALUES ($acc_id,'','$ledger_id','$ledger_name','$date','','','$username','$ipaddress','$locationcode')";
            $exec_insert = mysqli_query($GLOBALS["___mysqli_ston"], $query_insert) or die ("Error in query_insert" . mysqli_error($GLOBALS["___mysqli_ston"]));

            $bgcolorcode = 'success';	
            $errmsg = "Record Created!";
        }
    }
}

// Handle URL status messages
if (isset($_REQUEST["st"])) { 
    $st = $_REQUEST["st"]; 
} else { 
    $st = ""; 
}

if ($st == 'success') {
    $errmsg = "Success. Record Created.";
    if (isset($_REQUEST["cpynum"])) { 
        $cpynum = $_REQUEST["cpynum"]; 
    } else { 
        $cpynum = ""; 
    }
    if ($cpynum == 1) { // For first company
        $errmsg = "Success. New Record Created.";
    }
} else if ($st == 'failed') {
    $errmsg = "Failed. Please try again.";
}

// Get location information
if ($location != '') {
    $query12 = "select locationname from master_location where locationcode='$location' order by locationname";
    $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $res12 = mysqli_fetch_array($exec12);
    $res1location = $res12["locationname"];
} else {
    $query1 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $res1 = mysqli_fetch_array($exec1);
    $res1location = $res1["locationname"];
    $res1locationanum = $res1["locationcode"];
}

// Finance mapping array
$name_arr = array(
    '1' => 'Cash Sales',
    '2' => 'Cheque Collection', 
    '3' => 'Online Collection',
    '4' => 'Card Collection',
    '5' => 'Mpesa Collection',
    '6' => 'Consultation Bill',
    '7' => 'Lab Discount',
    '8' => 'Service Discount',
    '9' => 'Radiology Discount',
    '10' => 'Pharmacy Discount',
    '11' => 'Patient Deposits',
    '12' => 'IP Bed Charges',
    '13' => 'IP Admission Charge',
    '14' => 'IP MISC Billing',
    '15' => 'IP Discount',
    '16' => 'Purchase Control',
    '17' => 'Input VAT',
    '18' => 'Inventory Adjustment',
    '19' => 'Withholding Tax',
    '20' => 'NHIF REBATE',
    '21' => 'Ambulance',
    '22' => 'Hospital Revenue',
    '23' => 'Debtor Discount',
    '24' => 'Bank Charges',
    '25' => 'Nursing Charges',
    '26' => 'Branch GIT Control',
    '27' => 'Patient Refunds',
    '28' => 'Doctor Fee Costs',
    '29' => 'Consultation Fee Costs'
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Mapping - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/finance-mapping-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Autocomplete CSS -->
    <link rel="stylesheet" type="text/css" href="css/autocomplete.css">
    
    <!-- Legacy jQuery for autocomplete -->
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js"></script>
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
        <span>Finance Mapping</span>
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
                        <a href="labitem1master.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Items</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="openingstockentry_master.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Opening Stock</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addward.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Wards</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountreceivableentrylist.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>Account Receivable</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="corporateoutstanding.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Corporate Outstanding</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountstatement.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Account Statement</span>
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
                    <li class="nav-item">
                        <a href="fixedasset_acquisition_report.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Fixed Asset Acquisition</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeinpatientlist.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Active Inpatient List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeusersreport.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Active Users Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chartofaccounts_upload.php" class="nav-link">
                            <i class="fas fa-upload"></i>
                            <span>Chart of Accounts Upload</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chartaccountsmaindataimport.php" class="nav-link">
                            <i class="fas fa-database"></i>
                            <span>Chart of Accounts Main Import</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chartaccountssubdataimport.php" class="nav-link">
                            <i class="fas fa-database"></i>
                            <span>Chart of Accounts Sub Import</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addbloodgroup.php" class="nav-link">
                            <i class="fas fa-tint"></i>
                            <span>Blood Group Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addfoodallergy1.php" class="nav-link">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Food Allergy Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addgenericname.php" class="nav-link">
                            <i class="fas fa-pills"></i>
                            <span>Generic Name Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addpromotion.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            <span>Promotion Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addsalutation1.php" class="nav-link">
                            <i class="fas fa-user-tie"></i>
                            <span>Salutation Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="vat.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>VAT Master</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="financemapping.php" class="nav-link">
                            <i class="fas fa-map-marked-alt"></i>
                            <span>Finance Mapping</span>
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
                    <h2>Finance Mapping</h2>
                    <p>Configure finance ledger mappings for various transaction types and accounts.</p>
                </div>
                <div class="page-header-actions">
                    <div class="location-display">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Location: <strong><?php echo htmlspecialchars($res1location); ?></strong></span>
                    </div>
                </div>
            </div>

            <!-- Finance Mapping Form Section -->
            <div class="mapping-form-section">
                <div class="mapping-form-header">
                    <i class="fas fa-map-marked-alt mapping-form-icon"></i>
                    <h3 class="mapping-form-title">Finance Ledger Mapping</h3>
                </div>
                
                <form name="form1" action="financemapping.php" method="post" class="mapping-form" onSubmit="return process1()">
                    <input type="hidden" name="locationcode" id="locationcode" value="<?php echo $res1locationanum; ?>">
                    <input type="hidden" name="frmflag1" value="frmflag1" />
                    
                    <div class="mapping-grid">
                        <?php
                        $length = sizeof($name_arr); 
                        for ($i = 1; $i <= $length; $i++) { 
                            // Select ledger from db
                            $query_acc = "SELECT * FROM finance_ledger_mapping WHERE map_anum = '$i' AND record_status <> 'deleted'";
                            $exec_acc = mysqli_query($GLOBALS["___mysqli_ston"], $query_acc) or die ("Error in Query_acc" . mysqli_error($GLOBALS["___mysqli_ston"]));
                            $ledgername = '';
                            $ledgercode = '';
                            
                            while ($res_acc = mysqli_fetch_array($exec_acc)) {
                                $map_anum = $res_acc['map_anum'];
                                $ledgercode = $res_acc['ledger_id'];
                                $ledgername = $res_acc['ledger_name'];
                            }
                        ?>
                        <div class="mapping-item">
                            <div class="mapping-item-header">
                                <label class="mapping-label">
                                    <i class="fas fa-tag"></i>
                                    <?php echo htmlspecialchars($name_arr[$i]); ?>
                                </label>
                            </div>
                            <div class="mapping-input-group">
                                <div class="autocomplete-container">
                                    <input type="text" 
                                           id="ledger_name<?php echo $i; ?>" 
                                           name="ledger_name<?php echo $i; ?>" 
                                           class="form-input autocomplete-input"
                                           value="<?php echo htmlspecialchars($ledgername); ?>" 
                                           onkeypress="return auto(this.id)" 
                                           autocomplete="off"
                                           placeholder="Search for ledger account...">
                                    <i class="fas fa-search autocomplete-icon"></i>
                                </div>
                                <input type="hidden" 
                                       id="ledger_id<?php echo $i; ?>" 
                                       name="ledger_id<?php echo $i; ?>" 
                                       value="<?php echo htmlspecialchars($ledgercode); ?>">
                                <input type="hidden" 
                                       id="account_id<?php echo $i; ?>" 
                                       name="account_id<?php echo $i; ?>" 
                                       value="<?php echo $i; ?>">
                                <input type="hidden" 
                                       id="finance<?php echo $i; ?>" 
                                       name="finance<?php echo $i; ?>" 
                                       value="<?php echo htmlspecialchars($name_arr[$i]); ?>">
                            </div>
                        </div>
                        <?php } ?>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="fas fa-save"></i>
                            Save Mapping Configuration
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/finance-mapping-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy autocomplete functionality -->
    <script type="text/javascript">
        function auto(id) {
            var lastChar = id.replace("ledger_name", "");
            var el = '#' + id;
            
            $(el).autocomplete({    
                source: 'accountnamefinanceajaxall.php', 
                minLength: 1,
                delay: 0,
                html: true,
                change: function(event, ui) {
                    var account_id = ui.item.saccountid;
                    var account_auto = ui.item.saccountauto;
                    console.log(account_id);
                    $('#ledger_id' + lastChar).val(account_id);
                },
                select: function(event, ui) {
                    var account_id = ui.item.account_id;
                    $('#ledger_id' + lastChar).val(account_id);
                }
            }); 
        }
    </script>
</body>
</html>

