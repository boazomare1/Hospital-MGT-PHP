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

if (isset($_REQUEST["cbfrmflag1"])) { 
    $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; 
} else { 
    $cbfrmflag1 = ""; 
}

if (isset($_REQUEST["location"])) { 
    $location = $_REQUEST["location"]; 
} else { 
    $location = ""; 
}

// Get location options
$locationQuery = "SELECT DISTINCT locationcode, locationname FROM master_location WHERE recordstatus != 'deleted' ORDER BY locationname";
$locationExec = mysqli_query($GLOBALS["___mysqli_ston"], $locationQuery);

// Initialize variables
$totalPatients = 0;
$malePatients = 0;
$femalePatients = 0;
$totalWards = 0;
$patientData = [];

// Process search if form is submitted
if ($cbfrmflag1 == 'cbfrmflag1') {
    $colorloopcount = 0;
    $sno = 0;
    
    if($location == 'All') {
        $pass_location = "locationcode !=''";
    } else {
        $pass_location = "locationcode ='$location'";
    }	

    $querynw1 = "SELECT * FROM ip_bedallocation WHERE paymentstatus = '' AND creditapprovalstatus = '' AND $pass_location";
    $execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die("Error in Querynw1: " . mysqli_error($GLOBALS["___mysqli_ston"]));
    $totalPatients = mysqli_num_rows($execnw1);
    
    // Get patient data for display
    while ($resnw1 = mysqli_fetch_array($execnw1)) {
        $patientData[] = $resnw1;
        
        // Count by gender
        if (strtoupper($resnw1['gender']) == 'MALE' || strtoupper($resnw1['gender']) == 'M') {
            $malePatients++;
        } else {
            $femalePatients++;
        }
    }
    
    // Count unique wards
    $wardQuery = "SELECT COUNT(DISTINCT wardname) as wardcount FROM ip_bedallocation WHERE paymentstatus = '' AND creditapprovalstatus = '' AND $pass_location";
    $wardExec = mysqli_query($GLOBALS["___mysqli_ston"], $wardQuery);
    $wardResult = mysqli_fetch_array($wardExec);
    $totalWards = $wardResult['wardcount'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Current IP List - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/currentiplist-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker CSS -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- Date Picker Scripts -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    
    <!-- Autocomplete CSS -->
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
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
        <span>Current IP List</span>
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
                        <a href="patientregistration1.php" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>Patient Registration</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipadmission1.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>IP Admission</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="currentiplist.php" class="nav-link">
                            <i class="fas fa-list"></i>
                            <span>Current IP List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="discharge1.php" class="nav-link">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Discharge</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billing1.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Billing</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="reports1.php" class="nav-link">
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
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Current IP List</h2>
                    <p>View and manage current in-patient admissions across all locations and wards.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportIPList()">
                        <i class="fas fa-download"></i> Export
                    </button>
                    <button type="button" class="btn btn-outline" onclick="printIPList()">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>

            <!-- Summary Cards -->
            <?php if ($cbfrmflag1 == 'cbfrmflag1'): ?>
            <div class="summary-cards">
                <div class="summary-card">
                    <div class="summary-card-icon total">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="summary-card-number"><?php echo $totalPatients; ?></div>
                    <div class="summary-card-label">Total Patients</div>
                </div>
                <div class="summary-card">
                    <div class="summary-card-icon male">
                        <i class="fas fa-male"></i>
                    </div>
                    <div class="summary-card-number"><?php echo $malePatients; ?></div>
                    <div class="summary-card-label">Male Patients</div>
                </div>
                <div class="summary-card">
                    <div class="summary-card-icon female">
                        <i class="fas fa-female"></i>
                    </div>
                    <div class="summary-card-number"><?php echo $femalePatients; ?></div>
                    <div class="summary-card-label">Female Patients</div>
                </div>
                <div class="summary-card">
                    <div class="summary-card-icon ward">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="summary-card-number"><?php echo $totalWards; ?></div>
                    <div class="summary-card-label">Active Wards</div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Search Form Section -->
            <div class="search-section">
                <div class="search-header">
                    <i class="fas fa-search search-icon"></i>
                    <h3 class="search-title">Search Current IP Patients</h3>
                </div>
                
                <form id="searchForm" name="form1" method="post" action="currentiplist.php" class="search-form">
                    <div class="form-group">
                        <label class="form-label">Location</label>
                        <select name="location" id="location" class="form-select">
                            <option value="All" <?php echo ($location == 'All') ? 'selected' : ''; ?>>All Locations</option>
                            <?php
                            if ($locationExec) {
                                while ($locationRow = mysqli_fetch_array($locationExec)) {
                                    $selected = ($location == $locationRow['locationcode']) ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($locationRow['locationcode']) . "' $selected>" . htmlspecialchars($locationRow['locationname']) . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">From Date</label>
                        <input type="date" name="datefrom" id="dateFrom" class="form-input" 
                               value="<?php echo $transactiondatefrom; ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label">To Date</label>
                        <input type="date" name="dateto" id="dateTo" class="form-input" 
                               value="<?php echo $transactiondateto; ?>">
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>

                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1" />
                </form>
            </div>

            <!-- IP List Section -->
            <?php if ($cbfrmflag1 == 'cbfrmflag1'): ?>
            <div class="ip-list-section">
                <div class="ip-list-header">
                    <div class="ip-list-title">
                        <i class="fas fa-list"></i>
                        Current IP List
                        <span class="results-count"><?php echo $totalPatients; ?></span>
                    </div>
                    <div class="ip-list-actions">
                        <input type="text" id="tableSearch" placeholder="Search patients..." class="form-input" style="width: 200px;">
                    </div>
                </div>

                <div class="data-table-container">
                    <table id="dataTable" class="data-table">
                        <thead>
                            <tr>
                                <th data-sortable="true" data-column="no">No.</th>
                                <th data-sortable="true" data-column="location">Location</th>
                                <th data-sortable="true" data-column="patient">Patient Name</th>
                                <th data-sortable="true" data-column="age">Age</th>
                                <th data-sortable="true" data-column="gender">Gender</th>
                                <th data-sortable="true" data-column="regno">Reg. No.</th>
                                <th data-sortable="true" data-column="visitcode">Visit Code</th>
                                <th data-sortable="true" data-column="ipdate">IP Date</th>
                                <th data-sortable="true" data-column="kinname">Kin Name</th>
                                <th data-sortable="true" data-column="kincontact">Kin Contact</th>
                                <th data-sortable="true" data-column="ward">Ward</th>
                                <th data-sortable="true" data-column="bed">Bed</th>
                                <th data-sortable="true" data-column="subtype">SubType</th>
                                <th data-sortable="true" data-column="account">Account</th>
                                <th data-sortable="true" data-column="amount">Interm Amt</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($patientData)) {
                                $counter = 1;
                                foreach ($patientData as $patient) {
                                    $patientName = $patient['patientname'];
                                    $age = $patient['age'];
                                    $gender = $patient['gender'];
                                    $regno = $patient['patientcode'];
                                    $visitcode = $patient['visitcode'];
                                    $ipdate = date('d-m-Y', strtotime($patient['ipdatetime']));
                                    $kinname = $patient['kinname'];
                                    $kincontact = $patient['kincontact'];
                                    $wardname = $patient['wardname'];
                                    $bedname = $patient['bedname'];
                                    $subtype = $patient['subtype'];
                                    $account = $patient['account'];
                                    $interimamount = $patient['interimamount'];
                                    $locationname = $patient['locationname'];
                                    $auto_number = $patient['auto_number'];
                                    
                                    $genderClass = (strtoupper($gender) == 'MALE' || strtoupper($gender) == 'M') ? 'male' : 'female';
                                    ?>
                                    <tr>
                                        <td data-column="no"><?php echo $counter++; ?></td>
                                        <td data-column="location">
                                            <span class="location-info"><?php echo htmlspecialchars($locationname); ?></span>
                                        </td>
                                        <td data-column="patient">
                                            <div class="patient-name"><?php echo htmlspecialchars($patientName); ?></div>
                                            <div class="patient-id">ID: <?php echo htmlspecialchars($regno); ?></div>
                                        </td>
                                        <td data-column="age">
                                            <span class="patient-age"><?php echo htmlspecialchars($age); ?></span>
                                        </td>
                                        <td data-column="gender">
                                            <span class="patient-gender <?php echo $genderClass; ?>">
                                                <?php echo htmlspecialchars($gender); ?>
                                            </span>
                                        </td>
                                        <td data-column="regno">
                                            <span class="patient-id"><?php echo htmlspecialchars($regno); ?></span>
                                        </td>
                                        <td data-column="visitcode">
                                            <span class="patient-id"><?php echo htmlspecialchars($visitcode); ?></span>
                                        </td>
                                        <td data-column="ipdate">
                                            <div class="date-info"><?php echo $ipdate; ?></div>
                                        </td>
                                        <td data-column="kinname"><?php echo htmlspecialchars($kinname); ?></td>
                                        <td data-column="kincontact"><?php echo htmlspecialchars($kincontact); ?></td>
                                        <td data-column="ward">
                                            <span class="ward-info"><?php echo htmlspecialchars($wardname); ?></span>
                                        </td>
                                        <td data-column="bed">
                                            <span class="bed-info"><?php echo htmlspecialchars($bedname); ?></span>
                                        </td>
                                        <td data-column="subtype"><?php echo htmlspecialchars($subtype); ?></td>
                                        <td data-column="account"><?php echo htmlspecialchars($account); ?></td>
                                        <td data-column="amount">
                                            <span class="amount">₹<?php echo number_format($interimamount, 2); ?></span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="action-btn view" onclick="viewPatientDetails('<?php echo $auto_number; ?>')" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="action-btn edit" onclick="editPatient('<?php echo $auto_number; ?>')" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="action-btn print" onclick="printReceipt('<?php echo $auto_number; ?>')" title="Print Receipt">
                                                    <i class="fas fa-print"></i>
                                                </button>
                                                <button class="action-btn discharge" onclick="dischargePatient('<?php echo $auto_number; ?>')" title="Discharge">
                                                    <i class="fas fa-sign-out-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="16" class="no-data">
                                        <div class="no-data-icon">
                                            <i class="fas fa-bed"></i>
                                        </div>
                                        <h3>No Current IP Patients</h3>
                                        <p>No in-patients found for the selected criteria. Try adjusting your search parameters.</p>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/currentiplist-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy JavaScript Functions -->
    <script type="text/javascript">
        function process1enterkeypress1() {
            //alert ("Enter Key Press2");
            return false;
        }

        function process1backkeypress1() {
            //alert ("Back Key Press");
            if (event.keyCode == 8) {
                event.keyCode = 0; 
                return event.keyCode;
                return false;
            }
        }

        function disableEnterKey() {
            //alert ("Back Key Press");
            if (event.keyCode == 8) {
                event.keyCode = 0; 
                return event.keyCode;
                return false;
            }
        }

        function funcPrintReceipt1() {
            window.open("print_payment_receipt1.php", "OriginalWindow<?php echo $banum; ?>", 'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
        }
    </script>
</body>
</html>
