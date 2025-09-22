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
$searchsubtypeanum1 = "";
$serpatientsearchaccount = "";
$searchsupplieranum = "";

//This include updatation takes too long to load for huge items database.
if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

if ($getcanum != '') {
    $query4 = "select * from master_supplier where auto_number = '$getcanum'";
    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res4 = mysqli_fetch_array($exec4);
    $cbsuppliername = $res4['suppliername'];
    $suppliername = $res4['suppliername'];
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if ($st == '1') {
    $errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2') {
    $errmsg = "Failed. Payment Entry Not Completed.";
}

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
    <title>Search Patient - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/patient-search-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Legacy CSS for compatibility -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    <link rel="stylesheet" type="text/css" href="css/autocomplete.css" />
    
    <!-- Legacy JavaScript -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    
    <!-- Autocomplete -->
    <script type="text/javascript" src="js/jquery-1.10.2.js"></script>
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    
    <!-- Subtype autocomplete -->
    <script type="text/javascript" src="js/autocomplete_subtype_new.js"></script>
    <script type="text/javascript" src="js/autosuggestsubtype_new.js"></script>
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
        <span>Search Patient</span>
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
                        <a href="patient_registration.php" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>Register Patient</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="searchpatient.php" class="nav-link">
                            <i class="fas fa-search"></i>
                            <span>Search Patient</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="patient_visit.php" class="nav-link">
                            <i class="fas fa-calendar-check"></i>
                            <span>Patient Visits</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="appointment.php" class="nav-link">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Appointments</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billing.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Billing</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer">
                <?php include ("includes/alertmessages1.php"); ?>
            </div>
            
            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Search Patient</h2>
                    <p>Search and manage patient records with advanced filtering options.</p>
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
                    <h3 class="search-form-title">Search Patient Details</h3>
                </div>
                
                <form name="cbform1" id="searchForm" method="post" action="searchpatient.php" class="search-form">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="patient" class="form-label">Patient Name</label>
                            <input name="patient" type="text" id="patient" class="form-input" 
                                   value="<?php echo htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : ''); ?>" 
                                   placeholder="Enter patient name">
                        </div>
                        
                        <div class="form-group">
                            <label for="patientcode" class="form-label">Registration No</label>
                            <input name="patientcode" type="text" id="patientcode" class="form-input" 
                                   value="<?php echo htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : ''); ?>" 
                                   placeholder="Enter registration number">
                        </div>
                        
                        <div class="form-group">
                            <label for="nationalid" class="form-label">National ID</label>
                            <input name="nationalid" type="text" id="nationalid" class="form-input" 
                                   value="<?php echo htmlspecialchars(isset($_POST['nationalid']) ? $_POST['nationalid'] : ''); ?>" 
                                   placeholder="Enter national ID">
                        </div>
                        
                        <div class="form-group">
                            <label for="phonenumber" class="form-label">Phone Number</label>
                            <input name="phonenumber" type="text" id="phonenumber" class="form-input" 
                                   value="<?php echo htmlspecialchars(isset($_POST['phonenumber']) ? $_POST['phonenumber'] : ''); ?>" 
                                   placeholder="Enter phone number">
                        </div>
                        
                        <div class="form-group">
                            <label for="searchsuppliername1" class="form-label">Search Subtype</label>
                            <input name="searchsuppliername1" type="text" id="searchsuppliername1" class="form-input" 
                                   value="<?php echo htmlspecialchars($searchsuppliername); ?>" 
                                   placeholder="Enter subtype">
                            <input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">
                            <input name="searchsubtypeanum1" id="searchsubtypeanum1" value="<?php echo htmlspecialchars($searchsubtypeanum1); ?>" type="hidden">
                        </div>
                        
                        <div class="form-group">
                            <label for="searchsuppliername" class="form-label">Search Account</label>
                            <input name="searchsuppliername" type="text" id="searchsuppliername" class="form-input" 
                                   value="<?php echo htmlspecialchars($searchsuppliername); ?>" 
                                   placeholder="Enter account name">
                            <input type="hidden" name="searchsuppliercode" id="searchsuppliercode" 
                                   value="<?php echo htmlspecialchars(isset($searchsuppliercode) ? $searchsuppliercode : ''); ?>" />
                            <input name="searchsupplieranum" type="hidden" id="searchsupplieranum" 
                                   value="<?php echo htmlspecialchars($searchsupplieranum); ?>">
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="button" id="resetBtn" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Results Section -->
            <?php if (isset($_REQUEST["cbfrmflag1"]) || isset($_REQUEST['page'])): ?>
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-users data-table-icon"></i>
                    <h3 class="data-table-title">Patient Search Results</h3>
                </div>
                
                <!-- Pagination Header -->
                <?php
                $colorloopcount = 0;
                $sno = 0;
                
                if (isset($_POST['patient'])) { $_SESSION['serpatient'] = $_POST['patient']; }
                if (isset($_POST['patientcode'])) { $_SESSION['serpatientcode'] = $_POST['patientcode']; }
                if (isset($_POST['nationalid'])) { $_SESSION['sernationalid'] = $_POST['nationalid']; }
                if (isset($_POST['phonenumber'])) { $_SESSION['serpatientpn'] = $_POST['phonenumber']; }
                if (isset($_POST['searchsubtypeanum1'])) { $_SESSION['serpatientsubtype'] = $_POST['searchsubtypeanum1']; }
                if (isset($_POST['searchsupplieranum'])) { $_SESSION['serpatientsearchaccount'] = $_POST['searchsupplieranum']; }
                
                $searchpatientcode = $_SESSION['serpatientcode'];
                $searchnationalid = $_SESSION['sernationalid'];
                $searchpatient = $_SESSION['serpatient'];
                $searchpatientpn = $_SESSION['serpatientpn'];
                $serpatientsubtype1 = $_SESSION['serpatientsubtype'];
                $serpatientsearchaccount = $_SESSION['serpatientsearchaccount'];
                
                // Pagination setup
                $adjacents = 3;
                
                // Build query based on search criteria
                if ($serpatientsubtype1 != "" && $serpatientsearchaccount != "") {
                    $query111 = "SELECT customerfullname from master_customer where customerfullname like '%$searchpatient%' and customercode like '%$searchpatientcode%' and nationalidnumber like '%$searchnationalid%' and subtype='$serpatientsubtype1' and planname='$serpatientsearchaccount' and status <> 'Deleted'";
                } elseif ($serpatientsubtype1 != "" && $serpatientsearchaccount == "") {
                    $query111 = "SELECT customerfullname from master_customer where customerfullname like '%$searchpatient%' and customercode like '%$searchpatientcode%' and nationalidnumber like '%$searchnationalid%' and subtype='$serpatientsubtype1' and status <> 'Deleted'";
                } elseif ($serpatientsubtype1 == "" && $serpatientsearchaccount != "") {
                    $query111 = "SELECT customerfullname from master_customer where customerfullname like '%$searchpatient%' and customercode like '%$searchpatientcode%' and nationalidnumber like '%$searchnationalid%' and planname='$serpatientsearchaccount' and status <> 'Deleted'";
                } elseif ($searchpatientpn == "" && $serpatientsubtype1 == "" && $serpatientsearchaccount == "") {
                    $query111 = "SELECT customerfullname from master_customer where customerfullname like '%$searchpatient%' and customercode like '%$searchpatientcode%' and nationalidnumber like '%$searchnationalid%' and status <> 'Deleted'";
                } elseif ($searchpatientpn != "") {
                    $query111 = "select customerfullname from master_customer where customerfullname like '%$searchpatient%' and customercode like '%$searchpatientcode%' and nationalidnumber like '%$searchnationalid%' and mobilenumber='$searchpatientpn' and status <> 'Deleted'";
                }
                
                $exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
                $total_pages = mysqli_num_rows($exec111);
                
                $targetpage = $_SERVER['PHP_SELF'];
                $limit = 50;
                if (isset($_REQUEST['page'])) { $page = $_REQUEST['page']; } else { $page = ""; }
                if ($page) {
                    $start = ($page - 1) * $limit;
                } else {
                    $start = 0;
                }
                
                if ($page == 0) $page = 1;
                $prev = $page - 1;
                $next = $page + 1;
                $lastpage = ceil($total_pages / $limit);
                $lpm1 = $lastpage - 1;
                
                // Pagination HTML
                $pagination = "";
                if ($lastpage >= 1) {
                    $pagination .= "<div class=\"pagination\">";
                    if ($page > 1) {
                        $pagination .= "<a href=\"$targetpage?page=$prev\" style='color:#3b3b3c;'>previous</a>";
                    } else {
                        $pagination .= "<span class=\"disabled\" style='color:#3b3b3c;'>previous</span>";
                    }
                    
                    if ($lastpage < 7 + ($adjacents * 2)) {
                        for ($counter = 1; $counter <= $lastpage; $counter++) {
                            if ($counter == $page) {
                                $pagination .= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";
                            } else {
                                $pagination .= "<a href=\"$targetpage?page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";
                            }
                        }
                    } elseif ($lastpage > 5 + ($adjacents * 2)) {
                        if ($page < 1 + ($adjacents * 2)) {
                            for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                                if ($counter == $page) {
                                    $pagination .= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";
                                } else {
                                    $pagination .= "<a href=\"$targetpage?page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";
                                }
                            }
                            $pagination .= "...";
                            $pagination .= "<a href=\"$targetpage?page=$lpm1\" style='margin:0 0 0 2px; color:#3b3b3c;'>$lpm1</a>";
                            $pagination .= "<a href=\"$targetpage?page=$lastpage\" style='margin:0 0 0 2px; color:#3b3b3c;'>$lastpage</a>";
                        } elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                            $pagination .= "<a href=\"$targetpage?page=1\" style='margin:0 0 0 2px; color:#3b3b3c;'>1</a>";
                            $pagination .= "<a href=\"$targetpage?page=2\" style='margin:0 0 0 2px; color:#3b3b3c;'>2</a>";
                            $pagination .= "...";
                            for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                                if ($counter == $page) {
                                    $pagination .= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";
                                } else {
                                    $pagination .= "<a href=\"$targetpage?page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";
                                }
                            }
                            $pagination .= "...";
                            $pagination .= "<a href=\"$targetpage?page=$lpm1\" style='margin:0 0 0 2px; color:#3b3b3c;'>$lpm1</a>";
                            $pagination .= "<a href=\"$targetpage?page=$lastpage\" style='margin:0 0 0 2px; color:#3b3b3c;'>$lastpage</a>";
                        } else {
                            $pagination .= "<a href=\"$targetpage?page=1\" style='margin:0 0 0 2px; color:#3b3b3c;'>1</a>";
                            $pagination .= "<a href=\"$targetpage?page=2\" style='margin:0 0 0 2px; color:#3b3b3c;'>2</a>";
                            $pagination .= "...";
                            for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                                if ($counter == $page) {
                                    $pagination .= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";
                                } else {
                                    $pagination .= "<a href=\"$targetpage?page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";
                                }
                            }
                        }
                    }
                    
                    if ($page < $counter - 1) {
                        $pagination .= "<a href=\"$targetpage?page=$next\" style='margin:0 0 0 2px; color:#3b3b3c;'>next</a>";
                    } else {
                        $pagination .= "<span class=\"disabled\" style='margin:0 0 0 2px; color:#3b3b3c;'>next</span>";
                    }
                    echo $pagination .= "</div>\n";
                }
                ?>
                
                <div class="data-table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center">Print</th>
                                <th class="text-center">Edit</th>
                                <th>Reg Code</th>
                                <th>Type</th>
                                <th>Sub Type</th>
                                <th>Bill Type</th>
                                <th>Account Name</th>
                                <th>Patient Name</th>
                                <th>Age</th>
                                <th class="text-center">Gender</th>
                                <th>National ID</th>
                                <th>Phone Number</th>
                                <th>User</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Build main query with same conditions
                            if ($serpatientsubtype1 != "" && $serpatientsearchaccount != "") {
                                $query2 = "SELECT * from master_customer where customerfullname like '%$searchpatient%' and customercode like '%$searchpatientcode%' and nationalidnumber like '%$searchnationalid%' and subtype='$serpatientsubtype1' and planname='$serpatientsearchaccount' and status <> 'Deleted' LIMIT $start , $limit";
                            } elseif ($serpatientsubtype1 != "" && $serpatientsearchaccount == "") {
                                $query2 = "SELECT * from master_customer where customerfullname like '%$searchpatient%' and customercode like '%$searchpatientcode%' and nationalidnumber like '%$searchnationalid%' and subtype='$serpatientsubtype1' and status <> 'Deleted' LIMIT $start , $limit";
                            } elseif ($serpatientsubtype1 == "" && $serpatientsearchaccount != "") {
                                $query2 = "SELECT * from master_customer where customerfullname like '%$searchpatient%' and customercode like '%$searchpatientcode%' and nationalidnumber like '%$searchnationalid%' and planname='$serpatientsearchaccount' and status <> 'Deleted' LIMIT $start , $limit";
                            } elseif ($searchpatientpn == "" && $serpatientsubtype1 == "" && $serpatientsearchaccount == "") {
                                $query2 = "SELECT * from master_customer where customerfullname like '%$searchpatient%' and customercode like '%$searchpatientcode%' and nationalidnumber like '%$searchnationalid%' and status <> 'Deleted' LIMIT $start , $limit";
                            } elseif ($searchpatientpn != "") {
                                $query2 = "SELECT * from master_customer where customerfullname like '%$searchpatient%' and customercode like '%$searchpatientcode%' and nationalidnumber like '%$searchnationalid%' and mobilenumber='$searchpatientpn' and status <> 'Deleted' LIMIT $start , $limit";
                            }
                            
                            $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $num2 = mysqli_num_rows($exec2);
                            
                            while ($res2 = mysqli_fetch_array($exec2)) {
                                $res2customercode = $res2['customercode'];
                                $res2customeranum = $res2['auto_number'];
                                $mobilenumber = $res2['mobilenumber'];
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
                                
                                $plannameanum = $res2['planname'];
                                $query6 = "select * from master_planname where auto_number = '$plannameanum'";
                                $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res6 = mysqli_fetch_array($exec6);
                                $res6planname = $res6['planname'];
                                $res5accountname = $res6['scheme_name'];
                                
                                $dob = $res2['dateofbirth'];
                                if ($dob != '0000-00-00') {
                                    $res2age = calculate_age($dob);
                                } else {
                                    $res2age = '';
                                }
                                
                                $res2gender = $res2['gender'];
                                $res2nationalidnumber = $res2['nationalidnumber'];
                                
                                $colorloopcount++;
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $colorloopcount; ?></td>
                                    <td class="text-center">
                                        <a href="print_registration_label.php?previouspatientcode=<?php echo urlencode($res2customercode); ?>" 
                                           target="_blank" class="action-btn print" title="Print Label">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a href="editpatient_new.php?patientcode=<?php echo urlencode($res2customercode); ?>&menuid=<?php echo $menu_id; ?>" 
                                           class="action-btn edit" title="Edit Patient">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="patient-code"><?php echo htmlspecialchars($res2customercode); ?></span>
                                    </td>
                                    <td>
                                        <span class="payment-type <?php echo strtolower($res3paymenttype); ?>">
                                            <?php echo htmlspecialchars($res3paymenttype); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($res4subtype); ?></td>
                                    <td><?php echo htmlspecialchars($res2billtype); ?></td>
                                    <td><?php echo htmlspecialchars($res5accountname); ?></td>
                                    <td>
                                        <span class="patient-name"><?php echo htmlspecialchars($res2customername); ?></span>
                                    </td>
                                    <td>
                                        <span class="patient-age"><?php echo htmlspecialchars($res2age); ?></span>
                                    </td>
                                    <td class="text-center">
                                        <?php if (($res2gender == 'MALE') || ($res2gender == 'Male')): ?>
                                            <i class="fas fa-mars gender-icon" style="color: #3498db;" title="Male"></i>
                                        <?php else: ?>
                                            <i class="fas fa-venus gender-icon" style="color: #e91e63;" title="Female"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($res2nationalidnumber); ?></td>
                                    <td><?php echo htmlspecialchars($mobilenumber); ?></td>
                                    <td><?php echo htmlspecialchars($user); ?></td>
                                    <td class="text-center">
                                        <a href="visitentry_op_new.php?patientcode=<?php echo urlencode($res2customercode); ?>" 
                                           class="action-btn visit" title="Create OP Visit">
                                            <i class="fas fa-plus"></i> OP Visit
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination Footer -->
                <div class="pagination-container">
                    <?php echo $pagination; ?>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/patient-search-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy JavaScript -->
    <script>
    $(document).ready(function(e) {
        $('#searchsuppliername').autocomplete({
            source:"ajaxaccount_search.php",
            matchContains: true,
            minLength:1,
            html: true, 
            select: function(event,ui){
                var accountname=ui.item.value;
                var accountid=ui.item.id;
                var accountanum=ui.item.anum;
                $("#searchsuppliercode").val(accountid);
                $("#searchsupplieranum").val(accountanum);
            },
        });
    });
    
    window.onload = function () {
        var oTextbox = new AutoSuggestControl1(document.getElementById("searchsuppliername1"), new StateSuggestions1());
    }
    </script>
</body>
</html>
