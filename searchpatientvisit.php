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
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
$docno = $_SESSION['docno'];

$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

$patient = isset($_REQUEST['patient']) ? $_REQUEST['patient'] : '';
$patientcode = isset($_REQUEST['patientcode']) ? $_REQUEST['patientcode'] : '';
$visitcode = isset($_REQUEST['visitcode']) ? $_REQUEST['visitcode'] : '';

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

// Get total count for display
$colorloopcount = 0;
$sno = 0;

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

if ($cbfrmflag1 == 'cbfrmflag1' || isset($_REQUEST['page'])) {
    if(isset($_POST['patient'])){$_SESSION['servispatient'] = $_POST['patient']; } else { $_SESSION['servispatient'] = ''; }
    $searchpatient = $_SESSION['servispatient'];
    
    if(isset($_POST['patientcode'])){$_SESSION['servispatientcode'] = $_POST['patientcode'];} else { $_SESSION['servispatientcode'] = ''; }
    $searchpatientcode = $_SESSION['servispatientcode'];
    
    if(isset($_POST['visitcode'])){$_SESSION['servisvisitcode'] = $_POST['visitcode'];} else { $_SESSION['servisvisitcode'] = ''; }
    $searchvisitcode = $_SESSION['servisvisitcode'];
    
    if(isset($_POST['ADate1'])){$_SESSION['servisADate1'] = $_POST['ADate1'];} else { $_SESSION['servisADate1'] = ''; }
    $fromdate = $_SESSION['servisADate1'];
    
    if(isset($_POST['ADate2'])){$_SESSION['servisADate2'] = $_POST['ADate2'];} else { $_SESSION['servisADate2'] = ''; }
    $todate = $_SESSION['servisADate2'];
    
    if(isset($_POST['location'])){$_SESSION['servislocation'] = $_POST['location'];} else { $_SESSION['servislocation'] = ''; }
    $location = $_SESSION['servislocation'];
    
    // Get total count
    $reslocationanumm = $_REQUEST['location'];
    $query111 = "select patientcode, visitcode, billtype from master_visitentry where patientfullname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and locationcode like '%$reslocationanumm%' and consultationdate between '$fromdate' and '$todate' order by auto_number desc";
    $exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
    $total_records = mysqli_num_rows($exec111);
} else {
    $total_records = 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Patient Visits - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/patient-visit-search-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Legacy CSS for compatibility -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <!-- Legacy JavaScript -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/datetimepicker_css.js"></script>
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
        <span>Search Patient Visits</span>
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
                            <span>Patient Registration</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="searchpatientvisit.php" class="nav-link">
                            <i class="fas fa-search"></i>
                            <span>Search Visits</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="visit_entry.php" class="nav-link">
                            <i class="fas fa-calendar-plus"></i>
                            <span>New Visit</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="patient_list.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Patient List</span>
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
                <?php include ("includes/alertmessages1.php"); ?>
                <?php if (!empty($errmsg)): ?>
                    <div class="alert alert-<?php echo $st == '1' ? 'success' : ($st == '2' ? 'error' : 'info'); ?>">
                        <i class="fas fa-<?php echo $st == '1' ? 'check-circle' : ($st == '2' ? 'exclamation-triangle' : 'info-circle'); ?> alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Search Patient Visits</h2>
                    <p>Search and manage patient visit records with advanced filtering options.</p>
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
                
                <form name="cbform1" id="searchForm" method="post" action="searchpatientvisit.php" class="search-form">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" class="form-select" onchange="ajaxlocationfunction(this.value)">
                                <?php
                                $query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res = mysqli_fetch_array($exec)) {
                                    $locationname = $res["locationname"];
                                    $locationcode = $res["locationcode"];
                                    $selected = ($location != '' && $location == $locationcode) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $locationcode; ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($locationname); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="patient" class="form-label">Patient Name</label>
                            <input name="patient" type="text" id="patient" class="form-input" 
                                   value="<?php echo htmlspecialchars($patient); ?>" 
                                   placeholder="Enter patient name">
                        </div>
                        
                        <div class="form-group">
                            <label for="patientcode" class="form-label">Registration Number</label>
                            <input name="patientcode" type="text" id="patientcode" class="form-input" 
                                   value="<?php echo htmlspecialchars($patientcode); ?>" 
                                   placeholder="Enter registration number">
                        </div>
                        
                        <div class="form-group">
                            <label for="visitcode" class="form-label">Visit Code</label>
                            <input name="visitcode" type="text" id="visitcode" class="form-input" 
                                   value="<?php echo htmlspecialchars($visitcode); ?>" 
                                   placeholder="Enter visit code">
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <div class="date-input-group">
                                <input name="ADate1" id="ADate1" type="text" class="form-input date-input" 
                                       value="<?php echo $transactiondatefrom; ?>" readonly>
                                <i class="fas fa-calendar-alt date-picker-icon" onclick="NewCssCal('ADate1')" style="cursor:pointer"></i>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <div class="date-input-group">
                                <input name="ADate2" id="ADate2" type="text" class="form-input date-input" 
                                       value="<?php echo $transactiondateto; ?>" readonly>
                                <i class="fas fa-calendar-alt date-picker-icon" onclick="NewCssCal('ADate2')" style="cursor:pointer"></i>
                            </div>
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
            <?php if ($cbfrmflag1 == 'cbfrmflag1' || isset($_REQUEST['page'])): ?>
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-list data-table-icon"></i>
                    <h3 class="data-table-title">Patient Visit Results</h3>
                </div>
                
                <!-- Search Bar -->
                <div class="search-bar">
                    <input type="text" id="searchInput" class="search-input" 
                           placeholder="Search results..." 
                           oninput="searchPatientVisits(this.value)">
                    <button type="button" class="btn btn-secondary" onclick="clearSearch()">
                        <i class="fas fa-times"></i> Clear
                    </button>
                    <span class="row-count-display text-right"><?php echo $total_records; ?> records found</span>
                </div>
                
                <!-- Pagination -->
                <?php
                $adjacents = 3;
                $targetpage = $_SERVER['PHP_SELF'];
                $limit = 50;
                if(isset($_REQUEST['page'])){ $page=$_REQUEST['page'];} else { $page="";}
                if($page) 
                    $start = ($page - 1) * $limit;
                else
                    $start = 0;
                
                if ($page == 0) $page = 1;
                $prev = $page - 1;
                $next = $page + 1;
                $lastpage = ceil($total_records/$limit);
                $lpm1 = $lastpage - 1;
                
                $pagination = "";
                if($lastpage >= 1) {	
                    $pagination .= "<div class=\"pagination\">";
                    if ($page > 1) 
                        $pagination.= "<a href=\"$targetpage?page=$prev&location=$reslocationanumm\" style='color:#3b3b3c;'>previous</a>";
                    else
                        $pagination.= "<span class=\"disabled\" style='color:#3b3b3c;'>previous</span>";	
                    
                    if ($lastpage < 7 + ($adjacents * 2)) {	
                        for ($counter = 1; $counter <= $lastpage; $counter++) {
                            if ($counter == $page)
                                $pagination.= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";
                            else
                                $pagination.= "<a href=\"$targetpage?page=$counter&location=$reslocationanumm\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
                        }
                    } elseif($lastpage > 5 + ($adjacents * 2)) {
                        if($page < 1 + ($adjacents * 2)) {		
                            for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                                if ($counter == $page)
                                    $pagination.= "<span class=\"current\" style='margin:0 0 0 2px;' color:#3b3b3c;>$counter</span>";
                                else
                                    $pagination.= "<a href=\"$targetpage?page=$counter&location=$reslocationanumm\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
                            }
                            $pagination.= "...";
                            $pagination.= "<a href=\"$targetpage?page=$lpm1&location=$reslocationanumm\"style='margin:0 0 0 2px; color:#3b3b3c;'>$lpm1</a>";
                            $pagination.= "<a href=\"$targetpage?page=$lastpage&location=$reslocationanumm\"style='margin:0 0 0 2px; color:#3b3b3c;'>$lastpage</a>";		
                        } elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                            $pagination.= "<a href=\"$targetpage?page=1&location=$reslocationanumm\" style='margin:0 0 0 2px; color:#3b3b3c;'>1</a>";
                            $pagination.= "<a href=\"$targetpage?page=2&location=$reslocationanumm\" style='margin:0 0 0 2px; color:#3b3b3c;'>2</a>";
                            $pagination.= "...";
                            for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                                if ($counter == $page)
                                    $pagination.= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";
                                else
                                    $pagination.= "<a href=\"$targetpage?page=$counter&location=$reslocationanumm\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
                            }
                            $pagination.= "...";
                            $pagination.= "<a href=\"$targetpage?page=$lpm1&location=$reslocationanumm\" style='margin:0 0 0 2px; color:#3b3b3c;'>$lpm1</a>";
                            $pagination.= "<a href=\"$targetpage?page=$lastpage&location=$reslocationanumm\" style='margin:0 0 0 2px; color:#3b3b3c;'>$lastpage</a>";		
                        } else {
                            $pagination.= "<a href=\"$targetpage?page=1&location=$reslocationanumm\" style='margin:0 0 0 2px; color:#3b3b3c;'>1</a>";
                            $pagination.= "<a href=\"$targetpage?page=2&location=$reslocationanumm\" style='margin:0 0 0 2px; color:#3b3b3c;'>2</a>";
                            $pagination.= "...";
                            for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                                if ($counter == $page)
                                    $pagination.= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";
                                else
                                    $pagination.= "<a href=\"$targetpage?page=$counter&location=$reslocationanumm\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
                            }
                        }
                    }
                    
                    if ($page < $counter - 1) 
                        $pagination.= "<a href=\"$targetpage?page=$next&location=$reslocationanumm\" style='margin:0 0 0 2px; color:#3b3b3c;'>next</a>";
                    else
                        $pagination.= "<span class=\"disabled\" style='margin:0 0 0 2px; color:#3b3b3c;'>next</span>";
                }
                echo $pagination;
                ?>
                
                <!-- Data Table -->
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Print</th>
                            <th>Edit</th>
                            <th>Reg Code</th>
                            <th>Visit Code</th>
                            <th>OP Date</th>
                            <th>Patient Name</th>
                            <th>Type</th>
                            <th>Sub Type</th>
                            <th>Bill Type</th>
                            <th>Account Name</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>ID</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $reslocationanumm = $_REQUEST['location'];
                        $query2 = "select * from master_visitentry where patientfullname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and locationcode like '%$reslocationanumm%' and consultationdate between '$fromdate' and '$todate' order by auto_number desc LIMIT $start , $limit";
                        $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                        
                        while ($res2 = mysqli_fetch_array($exec2)) {
                            $res2customercode = $res2['patientcode'];
                            $scheme_id = $res2['scheme_id'];
                            $res2visitcode = $res2['visitcode'];
                            $res2customeranum = $res2['auto_number'];
                            $res2customername = $res2['patientfullname'];
                            $consultationdate = $res2['consultationdate'];
                            $user = $res2['username'];
                            $billtype = $res2['billtype'];
                            
                            if($billtype == "PAY LATER") {
                                $row8910 = 0;
                                $query892 = "select billno from billing_paylater where visitcode='$res2visitcode' and patientcode = '$res2customercode'";	
                                $exec892 = mysqli_query($GLOBALS["___mysqli_ston"], $query892) or die ("Error in Query892".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $row892 = mysqli_num_rows($exec892);
                                $row891 = $row8910 + $row892;
                            } else {
                                $row891 = 0;
                            }
                            
                            if($row891 == '0') {
                                if(1) {
                                    $query34 = "select * from master_customer where customercode='$res2customercode'";
                                    $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res34 = mysqli_fetch_array($exec34);
                                    $res2gender = $res34['gender'];
                                    $dob = $res34['dateofbirth'];
                                    $res2nationalidnumber = $res34['nationalidnumber'];
                                    $paymenttypeanum = $res2['paymenttype'];
                                    
                                    $today = new DateTime();
                                    $diff = $today->diff(new DateTime($dob));
                                    
                                    if ($diff->y) {
                                        $res2age = $diff->y . ' Years';
                                    } elseif ($diff->m) {
                                        $res2age = $diff->m . ' Months';
                                    } else {
                                        $res2age = $diff->d . ' Days';
                                    }
                                    
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
                                    
                                    $query_sc = "select * from master_planname where scheme_id = '$scheme_id'";
                                    $exec_sc = mysqli_query($GLOBALS["___mysqli_ston"], $query_sc) or die ("Error in query_sc".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res_sc = mysqli_fetch_array($exec_sc);
                                    $res5accountname = $res_sc['scheme_name'];
                                    
                                    $colorloopcount++;
                                    $sno++;
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo $sno; ?></td>
                                        <td class="text-center">
                                            <a href="print_opvisit_label.php?patientcode=<?php echo urlencode($res2customercode); ?>" 
                                               target="_blank" class="action-btn print" title="Print Label">
                                                <i class="fas fa-print"></i>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="editpatientvisit.php?patientcode=<?php echo urlencode($res2customercode); ?>&visitcode=<?php echo urlencode($res2visitcode); ?>&menuid=<?php echo $menu_id; ?>" 
                                               class="action-btn edit" title="Edit Visit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <span class="status-badge status-active"><?php echo htmlspecialchars($res2customercode); ?></span>
                                        </td>
                                        <td>
                                            <span class="status-badge status-pending"><?php echo htmlspecialchars($res2visitcode); ?></span>
                                        </td>
                                        <td><?php echo date('d/m/Y', strtotime($consultationdate)); ?></td>
                                        <td><?php echo htmlspecialchars($res2customername); ?></td>
                                        <td><?php echo htmlspecialchars($res3paymenttype); ?></td>
                                        <td><?php echo htmlspecialchars($res4subtype); ?></td>
                                        <td>
                                            <span class="status-badge <?php echo $res2billtype == 'PAY LATER' ? 'status-warning' : 'status-success'; ?>">
                                                <?php echo htmlspecialchars($res2billtype); ?>
                                            </span>
                                        </td>
                                        <td><?php echo htmlspecialchars($res5accountname); ?></td>
                                        <td><?php echo htmlspecialchars($res2age); ?></td>
                                        <td class="text-center">
                                            <?php if(($res2gender == 'MALE')||($res2gender == 'Male')): ?>
                                                <span class="gender-icon gender-male" title="Male">♂</span>
                                            <?php else: ?>
                                                <span class="gender-icon gender-female" title="Female">♀</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($res2nationalidnumber); ?></td>
                                        <td><?php echo htmlspecialchars($user); ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
                
                <!-- Pagination Bottom -->
                <?php echo $pagination; ?>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/patient-visit-search-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
