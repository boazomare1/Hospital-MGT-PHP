<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
ini_set('max_execution_time', 12000000); //120 seconds

// Search parameters
$searchpatientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
$searchpatient = isset($_POST['patient']) ? $_POST['patient'] : '';
$docnumber = isset($_POST['docnumber']) ? $_POST['docnumber'] : '';
$ADate1 = isset($_POST['ADate1']) ? $_POST['ADate1'] : $transactiondatefrom;
$ADate2 = isset($_POST['ADate2']) ? $_POST['ADate2'] : $transactiondateto;

// Handle URL status messages
if (isset($_REQUEST["st"])) { 
    $st = $_REQUEST["st"]; 
} else { 
    $st = ""; 
}

if ($st == '1') {
    $errmsg = "Success. Death notification updated successfully.";
    $bgcolorcode = 'success';
}

if ($st == '2') {
    $errmsg = "Failed. Death notification update failed.";
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
    <title>Death Notification List - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/death-notification-modern.css?v=<?php echo time(); ?>">
    
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
        <span>Death Notification List</span>
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
                        <a href="patientlist.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Patient List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="birthnotificationlist.php" class="nav-link">
                            <i class="fas fa-baby"></i>
                            <span>Birth Notifications</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="deathnotificationlist.php" class="nav-link">
                            <i class="fas fa-cross"></i>
                            <span>Death Notifications</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="medicalreports.php" class="nav-link">
                            <i class="fas fa-file-medical"></i>
                            <span>Medical Reports</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="sickleave.php" class="nav-link">
                            <i class="fas fa-calendar-times"></i>
                            <span>Sick Leave</span>
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
                    <h2>Death Notification List</h2>
                    <p>Search and manage death notification records for patients.</p>
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
                    <h3 class="search-form-title">Search Death Notifications</h3>
                </div>
                
                <form id="searchForm" name="cbform1" method="post" action="deathnotificationlist.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="patient" class="form-label">Patient Name</label>
                            <input type="text" name="patient" id="patient" class="form-input" 
                                   value="<?php echo htmlspecialchars($searchpatient); ?>" 
                                   placeholder="Enter patient name">
                        </div>
                        
                        <div class="form-group">
                            <label for="patientcode" class="form-label">Registration No</label>
                            <input type="text" name="patientcode" id="patientcode" class="form-input" 
                                   value="<?php echo htmlspecialchars($searchpatientcode); ?>" 
                                   placeholder="Enter registration number">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="docnumber" class="form-label">Document Number</label>
                            <input type="text" name="docnumber" id="docnumber" class="form-input" 
                                   value="<?php echo htmlspecialchars($docnumber); ?>" 
                                   placeholder="Enter document number">
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <input type="date" name="ADate1" id="ADate1" class="form-input" 
                                   value="<?php echo htmlspecialchars($ADate1); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <input type="date" name="ADate2" id="ADate2" class="form-input" 
                                   value="<?php echo htmlspecialchars($ADate2); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" id="searchBtn" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                            Search
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>

                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                </form>
            </div>

            <!-- Results Section -->
            <div class="results-section">
                <?php
                $colorloopcount = 0;
                $sno = 0;
                
                if (isset($_REQUEST["cbfrmflag1"])) { 
                    $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; 
                } else { 
                    $cbfrmflag1 = ""; 
                }

                if ($cbfrmflag1 == 'cbfrmflag1' || isset($_REQUEST['page'])) {
                    $table_name = 'death_notification';
                    $docno_col = 'docno';
                    $date_col = 'record_date';
                    $search_type = 'death';

                    // Pagination setup
                    $adjacents = 3;
                    
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
                    
                    if($page) {
                        $start = ($page - 1) * $limit;
                    } else {
                        $start = 0;
                    }
                    
                    if ($page == 0) $page = 1;
                    $prev = $page - 1;
                    $next = $page + 1;
                    $lastpage = ceil($total_pages/$limit);
                    $lpm1 = $lastpage - 1;
                    
                    // Pagination HTML
                    $pagination = "";
                    if($lastpage >= 1) {
                        $pagination .= "<div class=\"pagination\">";
                        
                        // Previous button
                        if ($page > 1) {
                            $pagination .= "<a href=\"$targetpage?page=$prev\" class=\"pagination-btn\">Previous</a>";
                        } else {
                            $pagination .= "<span class=\"pagination-btn disabled\">Previous</span>";
                        }
                        
                        // Pages
                        if ($lastpage < 7 + ($adjacents * 2)) {
                            for ($counter = 1; $counter <= $lastpage; $counter++) {
                                if ($counter == $page) {
                                    $pagination .= "<span class=\"pagination-btn current\">$counter</span>";
                                } else {
                                    $pagination .= "<a href=\"$targetpage?page=$counter\" class=\"pagination-btn\">$counter</a>";
                                }
                            }
                        } elseif($lastpage > 5 + ($adjacents * 2)) {
                            if($page < 1 + ($adjacents * 2)) {
                                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                                    if ($counter == $page) {
                                        $pagination .= "<span class=\"pagination-btn current\">$counter</span>";
                                    } else {
                                        $pagination .= "<a href=\"$targetpage?page=$counter\" class=\"pagination-btn\">$counter</a>";
                                    }
                                }
                                $pagination .= "<span class=\"pagination-ellipsis\">...</span>";
                                $pagination .= "<a href=\"$targetpage?page=$lpm1\" class=\"pagination-btn\">$lpm1</a>";
                                $pagination .= "<a href=\"$targetpage?page=$lastpage\" class=\"pagination-btn\">$lastpage</a>";
                            } elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                                $pagination .= "<a href=\"$targetpage?page=1\" class=\"pagination-btn\">1</a>";
                                $pagination .= "<a href=\"$targetpage?page=2\" class=\"pagination-btn\">2</a>";
                                $pagination .= "<span class=\"pagination-ellipsis\">...</span>";
                                
                                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                                    if ($counter == $page) {
                                        $pagination .= "<span class=\"pagination-btn current\">$counter</span>";
                                    } else {
                                        $pagination .= "<a href=\"$targetpage?page=$counter\" class=\"pagination-btn\">$counter</a>";
                                    }
                                }
                                
                                $pagination .= "<span class=\"pagination-ellipsis\">...</span>";
                                $pagination .= "<a href=\"$targetpage?page=$lpm1\" class=\"pagination-btn\">$lpm1</a>";
                                $pagination .= "<a href=\"$targetpage?page=$lastpage\" class=\"pagination-btn\">$lastpage</a>";
                            } else {
                                $pagination .= "<a href=\"$targetpage?page=1\" class=\"pagination-btn\">1</a>";
                                $pagination .= "<a href=\"$targetpage?page=2\" class=\"pagination-btn\">2</a>";
                                $pagination .= "<span class=\"pagination-ellipsis\">...</span>";
                                
                                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                                    if ($counter == $page) {
                                        $pagination .= "<span class=\"pagination-btn current\">$counter</span>";
                                    } else {
                                        $pagination .= "<a href=\"$targetpage?page=$counter\" class=\"pagination-btn\">$counter</a>";
                                    }
                                }
                            }
                        }
                        
                        // Next button
                        if ($page < $counter - 1) {
                            $pagination .= "<a href=\"$targetpage?page=$next\" class=\"pagination-btn\">Next</a>";
                        } else {
                            $pagination .= "<span class=\"pagination-btn disabled\">Next</span>";
                        }
                        
                        echo $pagination .= "</div>";
                    }
                ?>

                <!-- Data Table Section -->
                <div class="data-table-section">
                    <div class="data-table-header">
                        <i class="fas fa-list data-table-icon"></i>
                        <h3 class="data-table-title">Death Notification Records</h3>
                        <div class="table-info">
                            <span>Total Records: <?php echo $total_pages; ?></span>
                        </div>
                    </div>

                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
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
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $query2a = "select $docno_col as docno,patientcode,$date_col as date from $table_name where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and $docno_col like '%$docnumber%' and $date_col between '$ADate1' and '$ADate2' LIMIT $start , $limit";
                            $exec2a = mysqli_query($GLOBALS["___mysqli_ston"], $query2a) or die ("Error in Query2a".mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            while ($res2a = mysqli_fetch_array($exec2a)) {
                                $patientcode = $res2a['patientcode'];
                                $dnumber = $res2a['docno'];
                                $date = $res2a['date'];
                                
                                $query2 = "select * from master_customer where customercode like '$patientcode'";
                                $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                                
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
                                    if($dob != '0000-00-00') {
                                        $res2age = calculate_age($dob);
                                    } else {
                                        $res2age = '';
                                    }
                                    
                                    $res2gender = $res2['gender'];
                                    $res2nationalidnumber = $res2['nationalidnumber'];
                                    
                                    $colorloopcount++;
                                    ?>
                                    <tr>
                                        <td><?php echo $colorloopcount; ?></td>
                                        <td>
                                            <span class="reg-code-badge"><?php echo htmlspecialchars($res2customercode); ?></span>
                                        </td>
                                        <td>
                                            <span class="type-badge"><?php echo htmlspecialchars($res3paymenttype); ?></span>
                                        </td>
                                        <td><?php echo htmlspecialchars($res4subtype); ?></td>
                                        <td><?php echo htmlspecialchars($res2billtype); ?></td>
                                        <td><?php echo htmlspecialchars($res5accountname); ?></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($res2customername); ?></strong>
                                        </td>
                                        <td><?php echo htmlspecialchars($res2age); ?></td>
                                        <td>
                                            <?php if(($res2gender == 'MALE')||($res2gender == 'Male')): ?>
                                                <span class="gender-badge male">
                                                    <i class="fas fa-mars"></i> Male
                                                </span>
                                            <?php else: ?>
                                                <span class="gender-badge female">
                                                    <i class="fas fa-venus"></i> Female
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($res2nationalidnumber); ?></td>
                                        <td>
                                            <span class="user-badge"><?php echo htmlspecialchars($user); ?></span>
                                        </td>
                                        <td>
                                            <span class="date-badge"><?php echo date_format(date_create($date),'d-m-Y'); ?></span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="edit_death_notification.php?patientcode=<?php echo $res2customercode; ?>" 
                                                   class="action-btn edit" title="Edit Death Notification" target="_blank">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="action-btn view" 
                                                        onclick="viewDeathNotification('<?php echo htmlspecialchars($res2customercode); ?>')"
                                                        title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>
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
                <?php } ?>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/death-notification-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
