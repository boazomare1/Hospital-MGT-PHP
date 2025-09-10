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
$searchpatient = isset($_REQUEST['customer']) ? $_REQUEST['customer'] : '';
$searchlocationcode = $location;

// Handle form submission
if (isset($_REQUEST["cbfrmflag1"]) && $_REQUEST["cbfrmflag1"] == 'cbfrmflag1') {
    $searchpatient = $_POST['customer'];
    $searchlocationcode = $_POST['location'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bed Transfer List</title>
<!-- Modern CSS -->
<link href="css/bedtransferlist-modern.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <!-- Modern Header -->
    <header class="hospital-header">
        <div class="hospital-title">MedStar Hospital Management</div>
        <div class="hospital-subtitle">Bed Transfer List</div>
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
                        <a href="bedoccupancy2.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Bed Occupancy 2</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="bedtransferlist.php" class="nav-link active">
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
                <h1 class="page-title">Bed Transfer List</h1>
                <p class="page-subtitle">Manage and track patient bed transfers across different wards</p>
            </div>

            <!-- Filter Container -->
            <div class="filter-container">
                <div class="filter-header">
                    <i class="fas fa-filter"></i>
                    Search Filters
                </div>
                
                <form name="cbform1" method="post" action="bedtransferlist.php">
                    <div class="filter-row">
                        <div class="filter-group">
                            <label for="location">Location</label>
                            <select name="location" id="location" class="form-control" required>
                                <option value="">Select Location</option>
                                <?php
                                $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $locationname = $res1["locationname"];
                                    $locationcode = $res1["locationcode"];
                                    $selected = ($location == $locationcode) ? "selected" : "";
                                    echo '<option value="'.$locationcode.'" '.$selected.'>'.$locationname.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="search-container">
                            <label for="customer">Patient Search</label>
                            <input name="customer" id="customer" class="search-input" value="<?php echo htmlspecialchars($searchpatient); ?>" placeholder="Enter patient name, code, or visit code..." autocomplete="off">
                            <i class="fas fa-search search-icon"></i>
                            <input name="customercode" id="customercode" value="" type="hidden">
                        </div>
                        
                        <div class="filter-group">
                            <button type="submit" name="Submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                                Search
                            </button>
                        </div>
                    </div>
                    
                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                </form>
            </div>

            <!-- Location Display -->
            <div id="ajaxlocation" class="location-display">
                <?php
                if ($location != '') {
                    $query12 = "select locationname from master_location where locationcode='$location' order by locationname";
                    $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res12 = mysqli_fetch_array($exec12);
                    echo '<strong>Location:</strong> ' . $res12["locationname"];
                } else {
                    $query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res1 = mysqli_fetch_array($exec1);
                    echo '<strong>Location:</strong> ' . $res1["locationname"];
                }
                ?>
            </div>

            <!-- Results Container -->
            <?php
            if (isset($_REQUEST["cbfrmflag1"]) && $_REQUEST["cbfrmflag1"] == 'cbfrmflag1') {
                echo '<div class="table-container">';
                echo '<div class="report-header">';
                echo '<h3>Bed Transfer List Results</h3>';
                echo '<p>Generated on ' . date('Y-m-d H:i:s') . ' | Location: ' . $searchlocationcode . '</p>';
                echo '</div>';
                
                echo '<div class="report-content">';
                echo '<table class="modern-table">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>No.</th>';
                echo '<th>Patient Name</th>';
                echo '<th>Reg No</th>';
                echo '<th>DOA</th>';
                echo '<th>IP Visit</th>';
                echo '<th>Ward</th>';
                echo '<th>Bed No</th>';
                echo '<th>Account</th>';
                echo '<th>Action</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                
                $sno = 0;
                $colorloopcount = 0;
                
                $query63 = "select * from ip_bedallocation where locationcode='$searchlocationcode' and (patientname like '%$searchpatient%' or patientcode like '%$searchpatient%' or visitcode like '%$searchpatient%') and recordstatus <> 'discharged' and recordstatus!='request'";
                $exec63 = mysqli_query($GLOBALS["___mysqli_ston"], $query63) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                
                while($res63 = mysqli_fetch_array($exec63)) {
                    $ward = $res63['ward'];
                    $bed = $res63['bed'];
                    $patientname = $res63['patientname'];
                    $patientcode = $res63['patientcode'];
                    $visitcode = $res63['visitcode'];
                    $date = $res63['recorddate'];
                    $accountname = $res63['accountname'];
                    $searchedlocationcode = $res63['locationcode'];
                    
                    // Handle transferred patients
                    if($res63['recordstatus']=='transfered'){
                        $querynw1 = "select visitcode,patientcode,recorddate,ward,bed from ip_bedtransfer where locationcode='$searchlocationcode' and patientcode = '$patientcode' and visitcode = '$visitcode' and recordstatus='' order by auto_number limit 0,1";
                        $execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Querynw1".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $resnw1=mysqli_num_rows($execnw1);
                        if($resnw1>0){
                            $getmw=mysqli_fetch_array($execnw1);
                            $ward = $getmw['ward'];
                            $bed = $getmw['bed'];
                        } else {
                            continue;
                        }
                    }
                    
                    // Get ward name
                    $query50 = "select * from master_ward where auto_number='$ward' and locationcode='$searchlocationcode' ";
                    $exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res50 = mysqli_fetch_array($exec50);
                    $wardname1 = $res50['ward'];
                    
                    // Get bed name
                    $query51 = "select * from master_bed where auto_number='$bed' and locationcode='$searchlocationcode' ";
                    $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res51 = mysqli_fetch_array($exec51);
                    $bedname = $res51['bed'];
                    
                    // Check if patient is still active
                    $query82 = "select * from master_ipvisitentry where patientcode='$patientcode' and locationcode='$searchlocationcode' and visitcode='$visitcode' and discharge not in ('completed')";
                    $exec82 = mysqli_query($GLOBALS["___mysqli_ston"], $query82) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res82 = mysqli_fetch_array($exec82);
                    $num82 = mysqli_num_rows($exec82);
                    
                    if($num82 > 0) {
                        $discharge = $res82['discharge'];
                        $sno++;
                        
                        echo '<tr>';
                        echo '<td>' . $sno . '</td>';
                        echo '<td>' . htmlspecialchars($patientname) . '</td>';
                        echo '<td>' . htmlspecialchars($patientcode) . '</td>';
                        echo '<td>' . date('Y-m-d', strtotime($date)) . '</td>';
                        echo '<td>' . htmlspecialchars($visitcode) . '</td>';
                        echo '<td>' . htmlspecialchars($wardname1) . '</td>';
                        echo '<td>' . htmlspecialchars($bedname) . '</td>';
                        echo '<td>' . htmlspecialchars($accountname) . '</td>';
                        echo '<td>';
                        echo '<div class="action-buttons">';
                        echo '<a href="bedtransfer.php?patientcode=' . $patientcode . '&visitcode=' . $visitcode . '&locationcode=' . $searchlocationcode . '" class="action-btn transfer">';
                        echo '<i class="fas fa-exchange-alt"></i> Transfer';
                        echo '</a>';
                        echo '<a href="viewpatientdetails.php?patientcode=' . $patientcode . '&visitcode=' . $visitcode . '" class="action-btn view">';
                        echo '<i class="fas fa-eye"></i> View';
                        echo '</a>';
                        echo '</div>';
                        echo '</td>';
                        echo '</tr>';
                    }
                }
                
                if ($sno == 0) {
                    echo '<tr>';
                    echo '<td colspan="9" class="no-results">';
                    echo '<i class="fas fa-search"></i>';
                    echo '<h3>No patients found</h3>';
                    echo '<p>Try adjusting your search criteria or check if the location is correct.</p>';
                    echo '</td>';
                    echo '</tr>';
                }
                
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                echo '</div>';
            } else {
                echo '<div class="report-content">';
                echo '<h3>Ready to Search</h3>';
                echo '<p>Select a location and enter patient details to view bed transfer list.</p>';
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
    <script src="js/bedtransferlist-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
