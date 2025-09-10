<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$locationcode1 = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
$ward = isset($_REQUEST['ward']) ? $_REQUEST['ward'] : '';
$ADate1 = isset($_REQUEST['ADate1']) ? $_REQUEST['ADate1'] : date('Y-m-d', strtotime('-1 month'));
$ADate2 = isset($_REQUEST['ADate2']) ? $_REQUEST['ADate2'] : date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bed Occupancy Detailed Report</title>
<!-- Modern CSS -->
<link href="css/bedoccupancy2-modern.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <!-- Modern Header -->
    <header class="hospital-header">
        <div class="hospital-title">MedStar Hospital Management</div>
        <div class="hospital-subtitle">Bed Occupancy Detailed Report</div>
    </header>

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
                        <a href="bedoccupancy2.php" class="nav-link active">
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
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">Bed Occupancy Detailed Report</h1>
                <p class="page-subtitle">Generate comprehensive detailed bed occupancy reports with patient information</p>
            </div>

            <!-- Filter Container -->
            <div class="filter-container">
                <div class="filter-header">
                    <i class="fas fa-filter"></i>
                    Report Filters
                </div>
                
                <form name="cbform1" method="post" action="bedoccupancy2.php">
                    <div class="filter-row">
                        <div class="filter-group">
                            <label for="ADate1">Date From</label>
                            <input name="ADate1" id="ADate1" class="form-control" value="<?php echo $ADate1; ?>" type="date" required>
                        </div>
                        <div class="filter-group">
                            <label for="ADate2">Date To</label>
                            <input name="ADate2" id="ADate2" class="form-control" value="<?php echo $ADate2; ?>" type="date" required>
                        </div>
                    </div>
                    
                    <div class="filter-row">
                        <div class="filter-group">
                            <label for="location">Location</label>
                            <select name="location" id="location" class="form-control" required>
                                <option value="">Select Location</option>
                                <?php
                                if ($location != '') {
                                    $query12 = "select locationcode, locationname from master_location where locationcode='$location' order by locationname";
                                    $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while ($res12 = mysqli_fetch_array($exec12)) {
                                        $selected = ($location == $res12["locationcode"]) ? "selected" : "";
                                        echo '<option value="'.$res12["locationcode"].'" '.$selected.'>'.$res12["locationname"].'</option>';
                                    }
                                } else {
                                    $query1 = "select locationcode, locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while ($res1 = mysqli_fetch_array($exec1)) {
                                        $selected = ($location == $res1["locationcode"]) ? "selected" : "";
                                        echo '<option value="'.$res1["locationcode"].'" '.$selected.'>'.$res1["locationname"].'</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="ward">Ward</label>
                            <select name="ward" id="ward" class="form-control">
                                <option value="">All Wards</option>
                                <?php
                                if ($location != '') {
                                    $queryWard = "select auto_number, ward from master_ward where locationcode = '$location' and recordstatus <> 'deleted' order by ward";
                                    $execWard = mysqli_query($GLOBALS["___mysqli_ston"], $queryWard) or die ("Error in QueryWard".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while ($resWard = mysqli_fetch_array($execWard)) {
                                        $selected = ($ward == $resWard["auto_number"]) ? "selected" : "";
                                        echo '<option value="'.$resWard["auto_number"].'" '.$selected.'>'.$resWard["ward"].'</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="btn-group">
                        <button type="submit" name="Submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                            Generate Report
                        </button>
                        <button type="reset" name="resetbutton" class="btn btn-secondary">
                            <i class="fas fa-undo"></i>
                            Reset
                        </button>
                        <button type="button" id="exportBtn" class="btn btn-success">
                            <i class="fas fa-download"></i>
                            Export
                        </button>
                        <button type="button" id="printBtn" class="btn btn-warning">
                            <i class="fas fa-print"></i>
                            Print
                        </button>
                    </div>
                    
                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                </form>
            </div>

            <!-- Report Results -->
            <?php
            if (isset($_REQUEST["cbfrmflag1"]) && $_REQUEST["cbfrmflag1"] == 'cbfrmflag1') {
                $fromdate = $_POST['ADate1'];
                $todate = $_POST['ADate2'];
                $locationcode1 = $_POST['location'];
                $ward = $_POST['ward'];
                
                echo '<div class="table-container">';
                echo '<div class="report-header">';
                echo '<h3>Bed Occupancy Detailed Report Results</h3>';
                echo '<p>Generated on ' . date('Y-m-d H:i:s') . ' | Date Range: ' . $fromdate . ' to ' . $todate . '</p>';
                echo '</div>';
                
                echo '<div class="report-content">';
                echo '<table class="modern-table">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Patient Code</th>';
                echo '<th>Patient Name</th>';
                echo '<th>Ward</th>';
                echo '<th>Admission Date</th>';
                echo '<th>Discharge Date</th>';
                echo '<th>Length of Stay</th>';
                echo '<th>Status</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                
                // Get location name
                $queryLocation = "select locationname from master_location where locationcode='$locationcode1'";
                $execLocation = mysqli_query($GLOBALS["___mysqli_ston"], $queryLocation);
                $resLocation = mysqli_fetch_array($execLocation);
                $locationName = $resLocation['locationname'];
                
                // Build query based on ward selection
                if ($ward == '') {
                    $query = "select ba.visitcode, ba.patientcode, ba.recorddate, ba.ward, mw.ward as wardname 
                              from ip_bedallocation ba 
                              left join master_ward mw on ba.ward = mw.auto_number 
                              where ba.locationcode='$locationcode1' 
                              and ba.recorddate between '$fromdate' and '$todate' 
                              and ba.recordstatus <> 'transfered'
                              order by ba.recorddate desc";
                } else {
                    $query = "select ba.visitcode, ba.patientcode, ba.recorddate, ba.ward, mw.ward as wardname 
                              from ip_bedallocation ba 
                              left join master_ward mw on ba.ward = mw.auto_number 
                              where ba.locationcode='$locationcode1' 
                              and ba.ward = '$ward' 
                              and ba.recorddate between '$fromdate' and '$todate' 
                              and ba.recordstatus <> 'transfered'
                              order by ba.recorddate desc";
                }
                
                $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
                
                while ($res = mysqli_fetch_array($exec)) {
                    $visitcode = $res['visitcode'];
                    $patientcode = $res['patientcode'];
                    $admissiondate = $res['recorddate'];
                    $wardname = $res['wardname'] ?: 'Unknown Ward';
                    
                    // Get patient details
                    $queryPatient = "select patientfullname, gender from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
                    $execPatient = mysqli_query($GLOBALS["___mysqli_ston"], $queryPatient);
                    $resPatient = mysqli_fetch_array($execPatient);
                    $patientname = $resPatient['patientfullname'] ?: 'Unknown Patient';
                    
                    // Check discharge status
                    $queryDischarge = "select recorddate from ip_discharge where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' and req_status = 'discharge'";
                    $execDischarge = mysqli_query($GLOBALS["___mysqli_ston"], $queryDischarge);
                    $resDischarge = mysqli_fetch_array($execDischarge);
                    
                    $dischargedate = $resDischarge['recorddate'] ?: '';
                    $status = $dischargedate ? 'Discharged' : 'Admitted';
                    
                    // Calculate length of stay
                    $lengthOfStay = 0;
                    if ($dischargedate) {
                        $admission = new DateTime($admissiondate);
                        $discharge = new DateTime($dischargedate);
                        $lengthOfStay = $admission->diff($discharge)->days;
                    } else {
                        $admission = new DateTime($admissiondate);
                        $today = new DateTime();
                        $lengthOfStay = $admission->diff($today)->days;
                    }
                    
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($patientcode) . '</td>';
                    echo '<td>' . htmlspecialchars($patientname) . '</td>';
                    echo '<td>' . htmlspecialchars($wardname) . '</td>';
                    echo '<td>' . date('Y-m-d', strtotime($admissiondate)) . '</td>';
                    echo '<td>' . ($dischargedate ? date('Y-m-d', strtotime($dischargedate)) : 'N/A') . '</td>';
                    echo '<td>' . $lengthOfStay . ' days</td>';
                    echo '<td><span class="status-badge ' . ($status == 'Discharged' ? 'discharged' : 'admitted') . '">' . $status . '</span></td>';
                    echo '</tr>';
                }
                
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                echo '</div>';
            } else {
                echo '<div class="report-content">';
                echo '<h3>Ready to Generate Report</h3>';
                echo '<p>Select your filters and click "Generate Report" to view detailed bed occupancy data.</p>';
                echo '</div>';
            }
            ?>
        </main>
    </div>

    <!-- Modern Footer -->
    <footer>
        <div class="footer-container">
            <p>&copy; <?php echo date('Y'); ?> MedStar Hospital Management System. All rights reserved.</p>
        </div>
    </footer>

    <!-- Modern JavaScript -->
    <script src="js/bedoccupancy2-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
