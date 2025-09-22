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
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
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

// Handle supplier selection
if (isset($_REQUEST["canum"])) { 
    $getcanum = $_REQUEST["canum"]; 
} else { 
    $getcanum = ""; 
}

if ($getcanum != '') {
    $query4 = "select * from master_supplier where auto_number = '$getcanum' and locationcode='$locationcode'";
    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res4 = mysqli_fetch_array($exec4);
    $cbsuppliername = $res4['suppliername'];
    $suppliername = $res4['suppliername'];
}

// Handle status messages
if (isset($_REQUEST["st"])) { 
    $st = $_REQUEST["st"]; 
} else { 
    $st = ""; 
}

if ($st == '1') {
    $errmsg = "Success. Payment Entry Update Completed.";
    $bgcolorcode = 'success';
} elseif ($st == '2') {
    $errmsg = "Failed. Payment Entry Not Completed.";
    $bgcolorcode = 'failed';
} else {
    $bgcolorcode = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search IP Visit - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/ip-visit-search-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker CSS -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- Date Picker Scripts -->
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
        <span>Patient Management</span>
        <span>→</span>
        <span>Search IP Visit</span>
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
                        <a href="addpatient1.php" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>Add Patient</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="patient_list.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Patient List</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="searchipvisit.php" class="nav-link">
                            <i class="fas fa-search"></i>
                            <span>Search IP Visit</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="searchopvisit.php" class="nav-link">
                            <i class="fas fa-search"></i>
                            <span>Search OP Visit</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addipvisitentry.php" class="nav-link">
                            <i class="fas fa-hospital"></i>
                            <span>Add IP Visit</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addopvisitentry.php" class="nav-link">
                            <i class="fas fa-stethoscope"></i>
                            <span>Add OP Visit</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addpatientadmission.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Patient Admission</span>
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
                    <h2>Search IP Visit Details</h2>
                    <p>Search and manage Inpatient (IP) visit records with advanced filtering options.</p>
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
                    <h3 class="search-form-title">Search IP Visit Records</h3>
                    <div class="location-display" id="ajaxlocation">
                        <span class="location-label">📍 Location:</span>
                        <span class="location-name">
                            <?php
                            if ($location != '') {
                                $query12 = "select locationname from master_location where locationcode='$location' order by locationname";
                                $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res12 = mysqli_fetch_array($exec12);
                                echo $res1location = $res12["locationname"];
                            } else {
                                $query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res1 = mysqli_fetch_array($exec1);
                                echo $res1location = $res1["locationname"];
                            }
                            ?>
                        </span>
                    </div>
                </div>
                
                <form name="cbform1" method="post" action="searchipvisit.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location *</label>
                            <select name="location" id="location" class="form-input" onChange="ajaxlocationfunction(this.value);">
                                <?php
                                $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $locationname = $res1["locationname"];
                                    $locationcode = $res1["locationcode"];
                                    ?>
                                    <option value="<?php echo $locationcode; ?>" <?php if($location != '') { if($location == $locationcode) { echo "selected"; } } ?>><?php echo $locationname; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="patient" class="form-label">Patient Name</label>
                            <input name="patient" type="text" id="patient" class="form-input" value="" placeholder="Enter patient name..." autocomplete="off">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="patientcode" class="form-label">Registration No</label>
                            <input name="patientcode" type="text" id="patientcode" class="form-input" value="" placeholder="Enter registration number..." autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="visitcode" class="form-label">Visit Code</label>
                            <input name="visitcode" type="text" id="visitcode" class="form-input" value="" placeholder="Enter visit code..." autocomplete="off">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <div class="date-input-wrapper">
                                <input name="ADate1" id="ADate1" class="form-input date-input" value="<?php echo $transactiondatefrom; ?>" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <i class="fas fa-calendar-alt date-picker-icon" onClick="javascript:NewCssCal('ADate1')"></i>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <div class="date-input-wrapper">
                                <input name="ADate2" id="ADate2" class="form-input date-input" value="<?php echo $transactiondateto; ?>" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <i class="fas fa-calendar-alt date-picker-icon" onClick="javascript:NewCssCal('ADate2')"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" name="Submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search Records
                        </button>
                        <button type="reset" name="resetbutton" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
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
                if(isset($_POST['location'])) { $_POST['location'] = $_POST['location']; }
                $searchlocationcode = $_POST['location'];
                if(isset($_POST['patient'])) { $_SESSION['ippatient'] = $_POST['patient']; }
                $searchpatient = $_SESSION['ippatient'];
                if(isset($_POST['patientcode'])) { $_SESSION['ippatientcode'] = $_POST['patientcode']; }
                $searchpatientcode = $_SESSION['ippatientcode'];
                if(isset($_POST['visitcode'])) { $_SESSION['ipvisitcode'] = $_POST['visitcode']; }
                $searchvisitcode = $_SESSION['ipvisitcode'];
                if(isset($_POST['ADate1'])) { $_SESSION['ipADate1'] = $_POST['ADate1']; }
                $fromdate = $_SESSION['ipADate1'];
                if(isset($_POST['ADate2'])) { $_SESSION['ipADate2'] = $_POST['ADate2']; }
                $todate = $_SESSION['ipADate2'];
            ?>
            
            <div class="results-section">
                <div class="results-header">
                    <i class="fas fa-list results-icon"></i>
                    <h3 class="results-title">IP Visit Records</h3>
                    <div class="results-info">
                        <span class="results-count">Found records matching your search criteria</span>
                    </div>
                </div>
                
                <!-- Pagination -->
                <div class="pagination-container">
                    <?php
                    // Pagination logic
                    $adjacents = 3;
                    $query111 = "select * from master_ipvisitentry where locationcode='$searchlocationcode' and patientfullname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and consultationdate between '$fromdate' and '$todate' order by auto_number desc";
                    $exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $total_pages = mysqli_num_rows($exec111);
                    
                    $targetpage = $_SERVER['PHP_SELF'];
                    $limit = 50;
                    if(isset($_REQUEST['page'])) { $page = $_REQUEST['page']; } else { $page = ""; }
                    if($page) 
                        $start = ($page - 1) * $limit;
                    else
                        $start = 0;
                    
                    if ($page == 0) $page = 1;
                    $prev = $page - 1;
                    $next = $page + 1;
                    $lastpage = ceil($total_pages/$limit);
                    $lpm1 = $lastpage - 1;
                    
                    $pagination = "";
                    if($lastpage >= 1) {
                        $pagination .= "<div class=\"pagination\">";
                        // Previous button
                        if ($page > 1) 
                            $pagination .= "<a href=\"$targetpage?page=$prev\" class=\"pagination-link\">Previous</a>";
                        else
                            $pagination .= "<span class=\"pagination-disabled\">Previous</span>";
                        
                        // Pages
                        if ($lastpage < 7 + ($adjacents * 2)) {
                            for ($counter = 1; $counter <= $lastpage; $counter++) {
                                if ($counter == $page)
                                    $pagination .= "<span class=\"pagination-current\">$counter</span>";
                                else
                                    $pagination .= "<a href=\"$targetpage?page=$counter\" class=\"pagination-link\">$counter</a>";
                            }
                        } elseif($lastpage > 5 + ($adjacents * 2)) {
                            if($page < 1 + ($adjacents * 2)) {
                                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                                    if ($counter == $page)
                                        $pagination .= "<span class=\"pagination-current\">$counter</span>";
                                    else
                                        $pagination .= "<a href=\"$targetpage?page=$counter\" class=\"pagination-link\">$counter</a>";
                                }
                                $pagination .= "<span class=\"pagination-ellipsis\">...</span>";
                                $pagination .= "<a href=\"$targetpage?page=$lpm1\" class=\"pagination-link\">$lpm1</a>";
                                $pagination .= "<a href=\"$targetpage?page=$lastpage\" class=\"pagination-link\">$lastpage</a>";
                            } elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                                $pagination .= "<a href=\"$targetpage?page=1\" class=\"pagination-link\">1</a>";
                                $pagination .= "<a href=\"$targetpage?page=2\" class=\"pagination-link\">2</a>";
                                $pagination .= "<span class=\"pagination-ellipsis\">...</span>";
                                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                                    if ($counter == $page)
                                        $pagination .= "<span class=\"pagination-current\">$counter</span>";
                                    else
                                        $pagination .= "<a href=\"$targetpage?page=$counter\" class=\"pagination-link\">$counter</a>";
                                }
                                $pagination .= "<span class=\"pagination-ellipsis\">...</span>";
                                $pagination .= "<a href=\"$targetpage?page=$lpm1\" class=\"pagination-link\">$lpm1</a>";
                                $pagination .= "<a href=\"$targetpage?page=$lastpage\" class=\"pagination-link\">$lastpage</a>";
                            } else {
                                $pagination .= "<a href=\"$targetpage?page=1\" class=\"pagination-link\">1</a>";
                                $pagination .= "<a href=\"$targetpage?page=2\" class=\"pagination-link\">2</a>";
                                $pagination .= "<span class=\"pagination-ellipsis\">...</span>";
                                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                                    if ($counter == $page)
                                        $pagination .= "<span class=\"pagination-current\">$counter</span>";
                                    else
                                        $pagination .= "<a href=\"$targetpage?page=$counter\" class=\"pagination-link\">$counter</a>";
                                }
                            }
                        }
                        
                        // Next button
                        if ($page < $counter - 1) 
                            $pagination .= "<a href=\"$targetpage?page=$next\" class=\"pagination-link\">Next</a>";
                        else
                            $pagination .= "<span class=\"pagination-disabled\">Next</span>";
                        echo $pagination .= "</div>";
                    }
                    ?>
                </div>
                
                <!-- Data Table -->
                <div class="data-table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Print</th>
                                <th>Edit</th>
                                <th>User Name</th>
                                <th>Reg Code</th>
                                <th>Visit Code</th>
                                <th>IP File No</th>
                                <th>OP Date</th>
                                <th>Patient Name</th>
                                <th>Type</th>
                                <th>Sub Type</th>
                                <th>Bill Type</th>
                                <th>Account Name</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>National ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query2 = "select * from master_ipvisitentry where locationcode='$searchlocationcode' and patientfullname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and consultationdate between '$fromdate' and '$todate' order by auto_number desc LIMIT $start , $limit";
                            $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $num2 = mysqli_num_rows($exec2);
                            
                            while ($res2 = mysqli_fetch_array($exec2)) {
                                $res2customercode = $res2['patientcode'];
                                $res2visitcode = $res2['visitcode'];
                                $res2customeranum = $res2['auto_number'];
                                $res2customername = $res2['patientfullname'];
                                $consultationdate = $res2['consultationdate'];
                                $username = $res2['username'];
                                
                                $query34 = "select * from master_customer where customercode='$res2customercode'";
                                $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res34 = mysqli_fetch_array($exec34);
                                $res2age = $res34['age'];
                                $res2gender = $res34['gender'];
                                $res2nationalidnumber = $res34['nationalidnumber'];
                                
                                $paymenttypeanum = $res2['paymenttype'];
                                $mrdno = $res2['mrdno'];
                                
                                $query3 = "select * from master_paymenttype where auto_number = '$paymenttypeanum'";
                                $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res3 = mysqli_fetch_array($exec3);
                                $res3paymenttype = $res3['paymenttype'];
                                
                                $subtypeanum = $res2['subtype'];
                                $scheme_id = $res2['scheme_id'];
                                $query4 = "select * from master_subtype where auto_number = '$subtypeanum'";
                                $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res4 = mysqli_fetch_array($exec4);
                                $res4subtype = $res4['subtype'];
                                $res2billtype = $res2['billtype'];
                                
                                $accountnameanum = $res2['accountname'];
                                $query5 = "select * from master_accountname where auto_number = '$accountnameanum'";
                                $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res5 = mysqli_fetch_array($exec5);
                                
                                $query_sc = "select * from master_planname where scheme_id = '$scheme_id'";
                                $exec_sc = mysqli_query($GLOBALS["___mysqli_ston"], $query_sc) or die ("Error in query_sc".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res_sc = mysqli_fetch_array($exec_sc);
                                $res5accountname = $res_sc['scheme_name'];
                                
                                $colorloopcount = $colorloopcount + 1;
                                $showcolor = ($colorloopcount & 1);
                                $colorcode = ($showcolor == 0) ? 'even' : 'odd';
                                ?>
                                <tr class="<?php echo $colorcode; ?>">
                                    <td><?php echo $colorloopcount; ?></td>
                                    <td>
                                        <a href="print_opvisit_label.php?patientcode=<?php echo $res2customercode; ?>" 
                                           target="_blank" class="action-btn print" title="Print">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="editipvisitentry.php?patientcode=<?php echo $res2customercode; ?>&visitcode=<?php echo $res2visitcode; ?>" 
                                           class="action-btn edit" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                    <td><?php echo htmlspecialchars($username); ?></td>
                                    <td>
                                        <span class="patient-code-badge"><?php echo htmlspecialchars($res2customercode); ?></span>
                                    </td>
                                    <td>
                                        <span class="visit-code-badge"><?php echo htmlspecialchars($res2visitcode); ?></span>
                                    </td>
                                    <td>
                                        <span class="ip-file-badge"><?php echo htmlspecialchars($mrdno); ?></span>
                                    </td>
                                    <td><?php echo $consultationdate; ?></td>
                                    <td class="patient-name"><?php echo htmlspecialchars($res2customername); ?></td>
                                    <td>
                                        <span class="type-badge"><?php echo htmlspecialchars($res3paymenttype); ?></span>
                                    </td>
                                    <td>
                                        <span class="subtype-badge"><?php echo htmlspecialchars($res4subtype); ?></span>
                                    </td>
                                    <td><?php echo htmlspecialchars($res2billtype); ?></td>
                                    <td><?php echo htmlspecialchars($res5accountname); ?></td>
                                    <td><?php echo htmlspecialchars($res2age); ?></td>
                                    <td>
                                        <span class="gender-badge gender-<?php echo strtolower($res2gender); ?>">
                                            <?php echo htmlspecialchars($res2gender); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($res2nationalidnumber); ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Bottom Pagination -->
                <div class="pagination-container pagination-bottom">
                    <?php echo $pagination; ?>
                </div>
            </div>
            <?php } ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/ip-visit-search-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy JavaScript -->
    <script>
    function ajaxlocationfunction(val) {
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("ajaxlocation").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "ajax/ajaxgetlocationname.php?loccode=" + val, true);
        xmlhttp.send();
    }
    
    function disableEnterKey() {
        var key;
        if(window.event) {
            key = window.event.keyCode;
        } else {
            key = e.which;
        }
        if(key == 13) {
            return false;
        } else {
            return true;
        }
    }
    </script>
</body>
</html>
