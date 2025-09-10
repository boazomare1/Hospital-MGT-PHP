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

// Initialize variables
$errmsg = "";
$bgcolorcode = "";
$todaydate = isset($_REQUEST['ADate1']) ? $_REQUEST['ADate1'] : date("Y-m-d");
$fromdate = isset($_REQUEST['ADate1']) ? $_REQUEST['ADate1'] : date("Y-m-d");
$todate = isset($_REQUEST['ADate2']) ? $_REQUEST['ADate2'] : date("Y-m-d");
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';

// Handle delete operation
if (isset($_REQUEST["st"])) { 
    $st = $_REQUEST["st"]; 
} else { 
    $st = ""; 
}

if ($st == 'del') {
    $delanum = $_REQUEST["anum"];
    $reason = $_REQUEST["reason"];
    
    $query2 = "select * from master_theatre_booking where auto_number = '$delanum' and approvalstatus in ('pending')";
    $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
    $num2 = mysqli_num_rows($exec2);
    
    if ($num2 > 0) {
        $query3 = "UPDATE master_theatre_booking SET recordstatus = 'deleted', cancel_reason = '$reason' WHERE auto_number = '$delanum'";
        $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
        $errmsg = "Theatre booking cancelled successfully.";
        $bgcolorcode = 'success';
    } else {
        $errmsg = "Booking not found or cannot be cancelled.";
        $bgcolorcode = 'failed';
    }
}

if ($st == 'success') {
    $errmsg = "Operation completed successfully.";
    $bgcolorcode = 'success';
}

// Handle form submission
if (isset($_REQUEST["cbfrmflag1"])) { 
    $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; 
} else { 
    $cbfrmflag1 = ""; 
}

if ($cbfrmflag1 == 'cbfrmflag1') {
    $fromdate = $_REQUEST['ADate1'];
    $todate = $_REQUEST['ADate2'];
    $location = $_REQUEST['location'];
    
    $errmsg = "Theatre booking list filtered successfully.";
    $bgcolorcode = 'success';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Theatre Booking List - MedStar</title>
    
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
        <span>Theatre Booking List</span>
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
                    <li class="nav-item active">
                        <a href="theatrebookinglist.php" class="nav-link">
                            <i class="fas fa-theater-masks"></i>
                            <span>Theatre Booking List</span>
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
                    <h2>Theatre Booking List</h2>
                    <p>View and manage theatre bookings with comprehensive scheduling and status tracking.</p>
                </div>
                <div class="page-header-actions">
                    <a href="theatrebooking.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> New Booking
                    </a>
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>
            </div>

            <!-- Search Filter Form -->
            <div class="add-form-section">
                <div class="add-form-header">
                    <i class="fas fa-filter add-form-icon"></i>
                    <h3 class="add-form-title">View Theatre Booking</h3>
                </div>
                
                <form id="searchForm" name="cbform1" method="post" action="theatrebookinglist.php" class="add-form">
                    <div class="form-group">
                        <label for="location" class="form-label">Location</label>
                        <select name="location" id="location" class="form-input" onchange="ajaxlocationfunction(this.value)">
                            <option value="">Select Location</option>
                            <?php
                            $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res1 = mysqli_fetch_array($exec1)) {
                                $res1location = $res1["locationname"];
                                $res1locationanum = $res1["locationcode"];
                                $selected = ($location == $res1locationanum) ? "selected" : "";
                                echo '<option value="'.$res1locationanum.'" '.$selected.'>'.$res1location.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="ADate1" class="form-label">Date From</label>
                        <input type="date" name="ADate1" id="ADate1" class="form-input" value="<?php echo $fromdate; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="ADate2" class="form-label">Date To</label>
                        <input type="date" name="ADate2" id="ADate2" class="form-input" value="<?php echo $todate; ?>">
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                    
                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                </form>
            </div>

            <!-- Location Display -->
            <div id="ajaxlocation" class="location-display">
                <strong>📍 Current Location:</strong> 
                <?php
                if ($location != '') {
                    $query12 = "select locationname from master_location where locationcode='$location' order by locationname";
                    $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res12 = mysqli_fetch_array($exec12);
                    echo $res12["locationname"];
                } else {
                    $query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res1 = mysqli_fetch_array($exec1);
                    echo $res1["locationname"];
                }
                ?>
            </div>

            <!-- Theatre Booking List -->
            <div class="data-section">
                <div class="data-section-header">
                    <h3>Theatre Booking List</h3>
                    <p>Date Range: <strong><?php echo date('Y-m-d', strtotime($fromdate)); ?></strong> to <strong><?php echo date('Y-m-d', strtotime($todate)); ?></strong></p>
                </div>
                
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>Patient Code</th>
                            <th>Theatre</th>
                            <th>Ward</th>
                            <th>Procedure(s)</th>
                            <th>Side</th>
                            <th>Surgery Date</th>
                            <th>Surgeon(s)</th>
                            <th>Anaesthesist</th>
                            <th>Operation Status</th>
                            <th>Theatre Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query1 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $res1 = mysqli_fetch_array($exec1);
                        $res1location = $res1["locationname"]; 
                        $res1locationcode = $res1["locationcode"];
                        $patientlocationcode = $res1locationcode;
                        
                        $from_date_new = date('Y-m-d H:i:s', strtotime($fromdate));
                        $to_date_new = date('Y-m-d 23:59:59', strtotime($todate));
                        
                        $query2 = "select * from master_theatre_booking where locationcode='$patientlocationcode' and approvalstatus = 'Pending' and recordstatus <> 'deleted' and surgerydatetime between '$from_date_new' and '$to_date_new' and (theater_approvalstatus='' or theater_approvalstatus='Re-schedule') and starttime='0000-00-00 00:00:00' order by auto_number desc";
                        $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $num2 = mysqli_num_rows($exec2);
                        
                        while ($res2 = mysqli_fetch_array($exec2)) {
                            $bookingid = $res2['auto_number'];
                            $patientcode = $res2['patientcode'];
                            $visitcode = $res2['patientvisitcode'];
                            $theatrecode = $res2['theatrecode'];
                            $procedure_type = $res2['proceduretype'];
                            $side = $res2['side'];
                            $surgerydatetime = $res2['surgerydatetime'];
                            $surgeon = $res2['surgeon'];
                            $anaesthesist = $res2['anaesthesist'];
                            $operation_status = $res2['operation_status'];
                            $theater_approvalstatus = $res2['theater_approvalstatus'];
                            $ward = $res2['ward'];
                            
                            // Get patient name
                            $query_patient = "select patientname from master_patient where patientcode = '$patientcode'";
                            $exec_patient = mysqli_query($GLOBALS["___mysqli_ston"], $query_patient);
                            $res_patient = mysqli_fetch_array($exec_patient);
                            $patientname = $res_patient['patientname'] ?: 'N/A';
                            
                            // Get theatre name
                            $query_theatre = "select theatrename from master_theatre where theatrecode = '$theatrecode'";
                            $exec_theatre = mysqli_query($GLOBALS["___mysqli_ston"], $query_theatre);
                            $res_theatre = mysqli_fetch_array($exec_theatre);
                            $theatrename = $res_theatre['theatrename'] ?: 'N/A';
                            
                            // Determine status badge classes
                            $operationStatusClass = 'status-pending';
                            if (strtolower($operation_status) == 'completed') {
                                $operationStatusClass = 'status-active';
                            } elseif (strtolower($operation_status) == 'cancelled') {
                                $operationStatusClass = 'status-inactive';
                            }
                            
                            $theatreStatusClass = 'status-pending';
                            if (strtolower($theater_approvalstatus) == 'approved') {
                                $theatreStatusClass = 'status-active';
                            } elseif (strtolower($theater_approvalstatus) == 're-schedule') {
                                $theatreStatusClass = 'status-warning';
                            }
                            
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($patientname) . '</td>';
                            echo '<td>' . htmlspecialchars($patientcode) . '</td>';
                            echo '<td>' . htmlspecialchars($theatrename) . '</td>';
                            echo '<td>' . htmlspecialchars($ward) . '</td>';
                            echo '<td>' . htmlspecialchars($procedure_type) . '</td>';
                            echo '<td>' . htmlspecialchars($side) . '</td>';
                            echo '<td>' . date('Y-m-d H:i', strtotime($surgerydatetime)) . '</td>';
                            echo '<td>' . htmlspecialchars($surgeon) . '</td>';
                            echo '<td>' . htmlspecialchars($anaesthesist) . '</td>';
                            echo '<td><span class="status-badge ' . $operationStatusClass . '">' . ucfirst($operation_status) . '</span></td>';
                            echo '<td><span class="status-badge ' . $theatreStatusClass . '">' . ucfirst($theater_approvalstatus ?: 'Pending') . '</span></td>';
                            echo '<td class="action-buttons">';
                            echo '<a href="theatrebooking_edit.php?id=' . $bookingid . '" class="btn btn-info btn-sm">';
                            echo '<i class="fas fa-edit"></i> Edit';
                            echo '</a>';
                            echo '<button onclick="cancelBooking(' . $bookingid . ')" class="btn btn-warning btn-sm">';
                            echo '<i class="fas fa-times"></i> Cancel';
                            echo '</button>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        
                        if ($num2 == 0) {
                            echo '<tr>';
                            echo '<td colspan="12" class="no-data">';
                            echo '<i class="fas fa-theater-masks"></i>';
                            echo '<p>No theatre bookings found for the specified criteria.</p>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script src="js/vat-modern.js?v=<?php echo time(); ?>"></script>
    <script>
        // Additional JavaScript for theatre booking list
        function refreshPage() {
            window.location.reload();
        }
        
        function exportToExcel() {
            // Export functionality can be implemented here
            alert('Export functionality will be implemented');
        }
        
        function ajaxlocationfunction(locationcode) {
            // Location change functionality
            console.log('Location changed to: ' + locationcode);
        }
        
        function cancelBooking(bookingId) {
            const reason = prompt('Please enter cancellation reason:');
            if (reason && reason.trim() !== '') {
                if (confirm('Are you sure you want to cancel this booking?')) {
                    window.location.href = 'theatrebookinglist.php?st=del&anum=' + bookingId + '&reason=' + encodeURIComponent(reason);
                }
            } else if (reason !== null) {
                alert('Cancellation reason is required.');
            }
        }
        
        // Check theatre time functionality
        function checkTheatreTime() {
            // Theatre time checking functionality can be implemented here
            console.log('Checking theatre time...');
        }
    </script>
</body>
</html>
