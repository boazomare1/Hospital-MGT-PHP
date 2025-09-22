<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

ini_set('max_execution_time', 12000000); //120 seconds

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

// Handle supplier selection
if (isset($_REQUEST["canum"])) { 
    $getcanum = $_REQUEST["canum"]; 
} else { 
    $getcanum = ""; 
}

if ($getcanum != '') {
    $query4 = "select * from master_supplier where auto_number = '$getcanum'";
    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res4 = mysqli_fetch_array($exec4);
    $cbsuppliername = $res4['suppliername'];
    $suppliername = $res4['suppliername'];
}

// Handle search parameters
$searchpatientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
$searchpatient = isset($_POST['patient']) ? $_POST['patient'] : '';
$docnumber = isset($_POST['docnumber']) ? $_POST['docnumber'] : '';
$ADate1 = isset($_POST['ADate1']) ? $_POST['ADate1'] : $transactiondatefrom;
$ADate2 = isset($_POST['ADate2']) ? $_POST['ADate2'] : $transactiondateto;

// Handle status messages
if (isset($_REQUEST["st"])) { 
    $st = $_REQUEST["st"]; 
} else { 
    $st = ""; 
}

if ($st == '1') {
    $errmsg = "Success. Payment Entry Update Completed.";
    $bgcolorcode = 'success';
}

if ($st == '2') {
    $errmsg = "Failed. Payment Entry Not Completed.";
    $bgcolorcode = 'failed';
}

// Age calculation function
function calculate_age($birthday) {
    $today = new DateTime();
    $diff = $today->diff(new DateTime($birthday));
    
    if ($diff->y) {
        return $diff->y . ' Years';
    } elseif ($diff->m) {
        return $diff->m . ' Months';
    } else {
        return $diff->d . ' Days';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Birth Notification List - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/birthnotificationlist-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker CSS -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- Auto Suggest CSS -->
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <!-- JavaScript Files -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script type="text/javascript" src="js/disablebackenterkey.js"></script>
    <script src="js/datetimepicker_css.js"></script>
</head>

<body onLoad="return funcCustomerDropDownSearch1();">
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
        <span>Birth Notification List</span>
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
                    <li class="nav-item">
                        <a href="drugcategoryissues.php" class="nav-link">
                            <i class="fas fa-pills"></i>
                            <span>Drug Category Issues</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="drug_instructions.php" class="nav-link">
                            <i class="fas fa-prescription-bottle-alt"></i>
                            <span>Drug Instructions</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="birthnotificationlist.php" class="nav-link">
                            <i class="fas fa-baby"></i>
                            <span>Birth Notifications</span>
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
                    <h2>Birth Notification List</h2>
                    <p>Search and manage birth notification records for patients.</p>
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
                    <h3 class="search-form-title">Search Birth Notifications</h3>
                </div>
                
                <form name="cbform1" method="post" action="birthnotificationlist.php" class="search-form" onKeyDown="return disableEnterKey()">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="patient" class="form-label">Patient Name</label>
                            <input name="patient" type="text" id="patient" value="<?php echo htmlspecialchars($searchpatient); ?>" 
                                   class="form-input" placeholder="Enter patient name" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="patientcode" class="form-label">Registration No</label>
                            <input name="patientcode" type="text" id="patientcode" value="<?php echo htmlspecialchars($searchpatientcode); ?>" 
                                   class="form-input" placeholder="Enter registration number" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="docnumber" class="form-label">Doc Number</label>
                            <input name="docnumber" type="text" id="docnumber" value="<?php echo htmlspecialchars($docnumber); ?>" 
                                   class="form-input" placeholder="Enter document number" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <div class="date-input-group">
                                <input name="ADate1" id="ADate1" value="<?php echo $ADate1; ?>" 
                                       class="form-input" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" 
                                     style="cursor:pointer" class="date-picker-icon" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <div class="date-input-group">
                                <input name="ADate2" id="ADate2" value="<?php echo $ADate2; ?>" 
                                       class="form-input" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" 
                                     style="cursor:pointer" class="date-picker-icon" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">&nbsp;</label>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Search
                                </button>
                                <button type="reset" class="btn btn-secondary">
                                    <i class="fas fa-undo"></i> Reset
                                </button>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                </form>
            </div>

            <!-- Results Section -->
            <?php
            $colorloopcount = 0;
            $sno = 0;
            
            if (isset($_REQUEST["cbfrmflag1"])) { 
                $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; 
            } else { 
                $cbfrmflag1 = ""; 
            }

            if ($cbfrmflag1 == 'cbfrmflag1' || isset($_REQUEST['page'])) {
                $table_name = 'birth_notification';
                $docno_col = 'docno';
                $date_col = 'record_date';
                $search_type = 'birth';
                ?>
                
                <div class="results-section">
                    <div class="results-header">
                        <i class="fas fa-list results-icon"></i>
                        <h3 class="results-title">Birth Notification Records</h3>
                        <div class="results-actions">
                            <?php 
                            $url = "ADate1=$ADate1&&ADate2=$ADate2&&cbfrmflag1=cbfrmflag1&&patient=$searchpatient&&patientcode=$searchpatientcode&&docnumber=$docnumber" 
                            ?>
                            <a href="print_birth_notification_list.php?<?php echo $url; ?>" target='_blank' class="btn btn-outline">
                                <i class="fas fa-file-pdf"></i> Print PDF
                            </a>
                        </div>
                    </div>

                    <div class="results-content">
                        <?php
                        // Pagination setup
                        $query111 = "select $docno_col as docno,patientcode from $table_name where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and $docno_col like '%$docnumber%' and $date_col between '$ADate1' and '$ADate2'";
                        $exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $total_pages = mysqli_num_rows($exec111);
                        
                        $targetpage = $_SERVER['PHP_SELF'];
                        $limit = 50;
                        if(isset($_REQUEST['page'])){ 
                            $page = $_REQUEST['page'];
                        } else { 
                            $page = "";
                        }
                        if($page) 
                            $start = ($page - 1) * $limit;
                        else
                            $start = 0;
                        
                        if ($page == 0) $page = 1;
                        $prev = $page - 1;
                        $next = $page + 1;
                        $lastpage = ceil($total_pages/$limit);
                        $lpm1 = $lastpage - 1;
                        
                        // Pagination display
                        $pagination = "";
                        if($lastpage >= 1) {	
                            $pagination .= "<div class=\"pagination\">";
                            if ($page > 1) 
                                $pagination.= "<a href=\"$targetpage?page=$prev\" class=\"pagination-link\">Previous</a>";
                            else
                                $pagination.= "<span class=\"pagination-disabled\">Previous</span>";	
                            
                            if ($lastpage < 7 + (3 * 2)) {
                                for ($counter = 1; $counter <= $lastpage; $counter++) {
                                    if ($counter == $page)
                                        $pagination.= "<span class=\"pagination-current\">$counter</span>";
                                    else
                                        $pagination.= "<a href=\"$targetpage?page=$counter\" class=\"pagination-link\">$counter</a>";					
                                }
                            } elseif($lastpage > 5 + (3 * 2)) {
                                if($page < 1 + (3 * 2)) {
                                    for ($counter = 1; $counter < 4 + (3 * 2); $counter++) {
                                        if ($counter == $page)
                                            $pagination.= "<span class=\"pagination-current\">$counter</span>";
                                        else
                                            $pagination.= "<a href=\"$targetpage?page=$counter\" class=\"pagination-link\">$counter</a>";					
                                    }
                                    $pagination.= "...";
                                    $pagination.= "<a href=\"$targetpage?page=$lpm1\" class=\"pagination-link\">$lpm1</a>";
                                    $pagination.= "<a href=\"$targetpage?page=$lastpage\" class=\"pagination-link\">$lastpage</a>";		
                                } elseif($lastpage - (3 * 2) > $page && $page > (3 * 2)) {
                                    $pagination.= "<a href=\"$targetpage?page=1\" class=\"pagination-link\">1</a>";
                                    $pagination.= "<a href=\"$targetpage?page=2\" class=\"pagination-link\">2</a>";
                                    $pagination.= "...";
                                    for ($counter = $page - 3; $counter <= $page + 3; $counter++) {
                                        if ($counter == $page)
                                            $pagination.= "<span class=\"pagination-current\">$counter</span>";
                                        else
                                            $pagination.= "<a href=\"$targetpage?page=$counter\" class=\"pagination-link\">$counter</a>";					
                                    }
                                    $pagination.= "...";
                                    $pagination.= "<a href=\"$targetpage?page=$lpm1\" class=\"pagination-link\">$lpm1</a>";
                                    $pagination.= "<a href=\"$targetpage?page=$lastpage\" class=\"pagination-link\">$lastpage</a>";		
                                } else {
                                    $pagination.= "<a href=\"$targetpage?page=1\" class=\"pagination-link\">1</a>";
                                    $pagination.= "<a href=\"$targetpage?page=2\" class=\"pagination-link\">2</a>";
                                    $pagination.= "...";
                                    for ($counter = $lastpage - (2 + (3 * 2)); $counter <= $lastpage; $counter++) {
                                        if ($counter == $page)
                                            $pagination.= "<span class=\"pagination-current\">$counter</span>";
                                        else
                                            $pagination.= "<a href=\"$targetpage?page=$counter\" class=\"pagination-link\">$counter</a>";					
                                    }
                                }
                            }
                            
                            if ($page < $counter - 1) 
                                $pagination.= "<a href=\"$targetpage?page=$next\" class=\"pagination-link\">Next</a>";
                            else
                                $pagination.= "<span class=\"pagination-disabled\">Next</span>";
                            
                            echo $pagination .= "</div>";		
                        }
                        ?>

                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Reg Code</th>
                                    <th>Type</th>
                                    <th>Sub Type</th>
                                    <th>Bill Type</th>
                                    <th>Account Name</th>
                                    <th>Patient Name</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>National ID</th>
                                    <th>User</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $query2a = "select $docno_col as docno,patientcode,$date_col as date from $table_name where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and $docno_col like '%$docnumber%' and $date_col between '$ADate1' and '$ADate2' LIMIT $start , $limit";
                                $exec2a = mysqli_query($GLOBALS["___mysqli_ston"], $query2a) or die ("Error in Query2a".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $num2a = mysqli_num_rows($exec2a);
                                
                                while ($res2a = mysqli_fetch_array($exec2a)) {
                                    $patientcode = $res2a['patientcode'];
                                    $dnumber = $res2a['docno'];
                                    $date = $res2a['date'];
                                    
                                    $query2 = "select * from master_customer where customercode like '$patientcode'";
                                    $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $num2 = mysqli_num_rows($exec2);
                                    
                                    while ($res2 = mysqli_fetch_array($exec2)) {
                                        $res2customercode = $res2['customercode'];
                                        $res2customeranum = $res2['auto_number'];
                                        $res2customername = $res2['customerfullname'];
                                        $paymenttypeanum = $res2['paymenttype'];
                                        $user = $res2['username'];
                                        
                                        $query3 = "select * from master_paymenttype where auto_number = '$paymenttypeanum'";
                                        $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        $res3 = mysqli_fetch_array($exec3);
                                        $res3paymenttype = $res3['paymenttype'];
                                        
                                        $subtypeanum = $res2['subtype'];
                                        $query4 = "select * from master_subtype where auto_number = '$subtypeanum'";
                                        $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        $res4 = mysqli_fetch_array($exec4);
                                        $res4subtype = $res4['subtype'];
                                        
                                        $res2billtype = $res2['billtype'];
                                        $accountnameanum = $res2['accountname'];
                                        $query5 = "select * from master_accountname where auto_number = '$accountnameanum'";
                                        $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        $res5 = mysqli_fetch_array($exec5);
                                        $res5accountname = $res5['accountname'];
                                        
                                        $dob = $res2['dateofbirth']; 
                                        if($dob != '0000-00-00'){
                                            $res2age = calculate_age($dob);
                                        } else {
                                            $res2age = '';
                                        }
                                        
                                        $res2gender = $res2['gender'];
                                        $res2nationalidnumber = $res2['nationalidnumber'];
                                        
                                        $colorloopcount = $colorloopcount + 1;
                                        ?>
                                        <tr>
                                            <td><?php echo $colorloopcount; ?></td>
                                            <td>
                                                <span class="patient-code"><?php echo htmlspecialchars($res2customercode); ?></span>
                                            </td>
                                            <td><?php echo htmlspecialchars($res3paymenttype); ?></td>
                                            <td><?php echo htmlspecialchars($res4subtype); ?></td>
                                            <td><?php echo htmlspecialchars($res2billtype); ?></td>
                                            <td><?php echo htmlspecialchars($res5accountname); ?></td>
                                            <td>
                                                <span class="patient-name"><?php echo htmlspecialchars($res2customername); ?></span>
                                            </td>
                                            <td><?php echo htmlspecialchars($res2age); ?></td>
                                            <td>
                                                <div class="gender-icon">
                                                    <?php if(($res2gender == 'MALE')||($res2gender == 'Male')): ?>
                                                        <i class="fas fa-mars" style="color: #3b82f6;"></i>
                                                    <?php else: ?>
                                                        <i class="fas fa-venus" style="color: #ec4899;"></i>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td><?php echo htmlspecialchars($res2nationalidnumber); ?></td>
                                            <td><?php echo htmlspecialchars($user); ?></td>
                                            <td><?php echo date_format(date_create($date),'d-m-Y'); ?></td>
                                            <td>
                                                <div class="action-buttons">
                                                    <?php if($search_type=='birth'): ?>
                                                        <a target="_blank" href="edit_birth_notification.php?dnum=<?= $dnumber ?>" 
                                                           class="action-btn edit" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php
            }
            ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/birthnotificationlist-modern.js?v=<?php echo time(); ?>"></script>
    
    <script language="javascript">
        function disableEnterKey() {
            if (event.keyCode==8) {
                event.keyCode=0; 
                return event.keyCode 
                return false;
            }
            
            var key;
            if(window.event) {
                key = window.event.keyCode;     //IE
            } else {
                key = e.which;     //firefox
            }
            
            if(key == 13) // if enter key press
            {
                return false;
            } else {
                return true;
            }
        }

        function refreshPage() {
            location.reload();
        }

        function exportToExcel() {
            const tables = document.querySelectorAll('.data-table');
            let csv = [];
            
            tables.forEach(table => {
                const rows = Array.from(table.querySelectorAll('tr'));
                rows.forEach(row => {
                    const cells = Array.from(row.querySelectorAll('th, td'));
                    const rowData = cells.map(cell => `"${cell.textContent.trim()}"`).join(',');
                    csv.push(rowData);
                });
            });
            
            const csvContent = csv.join('\n');
            const blob = new Blob([csvContent], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'birth_notification_list.csv';
            a.click();
            window.URL.revokeObjectURL(url);
        }
    </script>
</body>
</html>


