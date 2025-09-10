<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }

// Get user location details
$query12 = " select * from login_locationdetails where username = '$username' "; 
$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
$res12 = mysqli_fetch_array($exec12);
$locationname = $res12["locationname"]; 
$locationcode = $res12["locationcode"];

// Get pending IP service consultations count
$querynw1 = "select * from ipconsultation_services where process='pending' and locationcode='$locationcode' and paymentstatus = 'pending' group by patientvisitcode order by consultationdate DESC";
			$execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$resnw1 = mysqli_num_rows($execnw1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Amend Service Pending - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/ipamendserpending-modern.css?v=<?php echo time(); ?>">
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
        <span>IP Amend Service Pending</span>
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
                        <a href="vat.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            <span>VAT Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="amend_pending_lab.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Pending Lab</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="amend_pending_ippharmacy.php" class="nav-link">
                            <i class="fas fa-pills"></i>
                            <span>Pending Pharmacy</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="amend_pending_radiology.php" class="nav-link">
                            <i class="fas fa-x-ray"></i>
                            <span>Pending Radiology</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="amend_pending_referral.php" class="nav-link">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Pending Referral</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="amend_pending_service.php" class="nav-link">
                            <i class="fas fa-cogs"></i>
                            <span>Pending Service</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="amendlistipdoctor.php" class="nav-link">
                            <i class="fas fa-user-md"></i>
                            <span>IP Doctor List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="listipmiscbilling.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>IP Misc Billing</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer">
                <?php if (isset($_GET['msg'])): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle alert-icon"></i>
                        <span><?php echo htmlspecialchars($_GET['msg']); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2><i class="fas fa-cogs"></i> IP Amend Service Pending</h2>
                    <p>Manage and update pending IP service consultations and processes</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button class="btn btn-secondary" onclick="printPage()">
                        <i class="fas fa-print"></i> Print
                    </button>
                    <button class="btn btn-primary" onclick="exportToCSV()">
                        <i class="fas fa-download"></i> Export CSV
                    </button>
                </div>
            </div>

            <!-- Search Form Section -->
            <div class="search-form-section">
                <div class="search-form-header">
                    <i class="search-form-icon fas fa-search"></i>
                    <h3 class="search-form-title">Search IP Service Consultations</h3>
                </div>
                
                <form id="searchForm" name="cbform1" method="post" action="ipamendser_pending.php">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location <span style="color: #dc2626;">*</span></label>
                            <select name="location" id="location" class="form-select" onchange="ajaxlocationfunction(this.value);" required>
           <?php
		   			$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
						 $locationname = $res1["locationname"];
						 $locationcode = $res1["locationcode"];
                                    $selected = ($location != '' && $location == $locationcode) ? 'selected' : '';
                                ?>
                                <option value="<?php echo htmlspecialchars($locationcode); ?>" <?php echo $selected; ?>>
                                    <?php echo htmlspecialchars($locationname); ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="patientname" class="form-label">Patient Name</label>
                            <input name="patientname" type="text" id="patientname" 
                                   value="<?php echo isset($_POST['patientname']) ? htmlspecialchars($_POST['patientname']) : ''; ?>" 
                                   class="form-input" autocomplete="off" placeholder="Enter patient name">
                        </div>
                        
                        <div class="form-group">
                            <label for="patientcode" class="form-label">Patient Code</label>
                            <input name="patientcode" type="text" id="patientcode" 
                                   value="<?php echo isset($_POST['patientcode']) ? htmlspecialchars($_POST['patientcode']) : ''; ?>" 
                                   class="form-input" autocomplete="off" placeholder="Enter patient code">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="visitcode" class="form-label">Visit Code</label>
                            <input name="visitcode" type="text" id="visitcode" 
                                   value="<?php echo isset($_POST['visitcode']) ? htmlspecialchars($_POST['visitcode']) : ''; ?>" 
                                   class="form-input" autocomplete="off" placeholder="Enter visit code">
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From <span style="color: #dc2626;">*</span></label>
                            <input name="ADate1" id="ADate1" type="date"
                                   value="<?php echo htmlspecialchars($transactiondatefrom); ?>" 
                                   class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To <span style="color: #dc2626;">*</span></label>
                            <input name="ADate2" id="ADate2" type="date"
                                   value="<?php echo htmlspecialchars($transactiondateto); ?>" 
                                   class="form-input" required>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <?php if (isset($_REQUEST["cbfrmflag1"]) && $_REQUEST["cbfrmflag1"] == 'cbfrmflag1'): ?>
            <!-- Data Table Section -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="data-table-icon fas fa-cogs"></i>
                    <h3 class="data-table-title">Pending IP Service Consultations</h3>
                    <div class="table-summary">
                        <div class="summary-item">
                            <i class="fas fa-calendar"></i>
                            <span>Date Range: <?php echo htmlspecialchars($_POST['ADate1']); ?> to <?php echo htmlspecialchars($_POST['ADate2']); ?></span>
                        </div>
                        <div class="summary-item">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Pending Consultations: <strong><?php echo $resnw1; ?></strong></span>
                        </div>
                    </div>
                </div>
                
                <!-- Search Bar -->
                <div style="margin-bottom: 1rem;">
                    <div style="display: flex; gap: 1rem; align-items: center;">
                        <input type="text" id="searchInput" class="form-input" 
                               placeholder="Search patient name, code, or visit code..." 
                               style="flex: 1; max-width: 300px;"
                               oninput="handleSearch(this.value)">
                        <button type="button" class="btn btn-secondary" onclick="clearSearch()">
                            <i class="fas fa-times"></i> Clear
                        </button>
                    </div>
                </div>

                <div class="table-container">
                    <table class="data-table" id="serviceTable" role="table" aria-label="IP Service Pending Consultations">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Consultation Date</th>
                                <th scope="col">Patient Code</th>
                                <th scope="col">Visit Code</th>
                                <th scope="col">Patient Name</th>
                                <th scope="col">Account</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="serviceTableBody">
                    <?php
                            if ($cbfrmflag1 == 'cbfrmflag1') {
                                $searchlocationcode = $_POST['location'];
                                $searchadate1 = $_POST['ADate1'];
                                $searchadate2 = $_POST['ADate2'];
                                $patientnameget = isset($_POST['patientname']) ? $_POST['patientname'] : '';
                                $patientcodeget = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
                                $visitcodeget = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';

	 $filter_qry = "";
                                if (trim($patientnameget) != "") {
                                    $filter_qry .= " and patientname LIKE '%" . $patientnameget . "%' ";
                                }
                                if (trim($patientcodeget) != "") {
	 	$filter_qry .= " and patientcode ='$patientcodeget' ";
	 }
                                if (trim($visitcodeget) != "") {
	 	$filter_qry .= " and patientvisitcode ='$visitcodeget' ";
	 }

			$colorloopcount = '';
			$sno = '';

                                $query1 = "select * from ipconsultation_services where process='pending' and locationcode='$searchlocationcode' and consultationdate between '$searchadate1'and '$searchadate2' $filter_qry group by patientvisitcode order by consultationdate DESC"; 
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

                                while ($res1 = mysqli_fetch_array($exec1)) {
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientname = $res1['patientname'];
                                    $patientaccountname = $res1['accountname'];
                                    $consultationdate = $res1['consultationdate'];
                                    $patientlocationcode = $res1['locationcode'];
                                    
                                    // Check if billing exists
                                    $query2 = "select sum(rows) as rows from (SELECT count(auto_number) AS rows FROM billing_ipcreditapproved WHERE visitcode = '$visitcode'
			UNION ALL 
                                    SELECT count(auto_number) AS rows FROM billing_ip WHERE visitcode = '$visitcode') as a";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2 = mysqli_fetch_array($exec2);
			$rows = $res2['rows'];
			
                                    if ($rows == 0) {
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
                                        $rowClass = ($showcolor == 0) ? 'even-row' : 'odd-row';
                                        $sno++;
                            ?>
                            <tr class="<?php echo $rowClass; ?>">
                                <td>
                                    <div class="serial-number">
                                        <?php echo $sno; ?>
                                    </div>
                                </td>
                                <td>
                                    <span class="date-badge">
                                        <?php echo htmlspecialchars($consultationdate); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="patient-code">
                                        <?php echo htmlspecialchars($patientcode); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="visit-code">
                                        <?php echo htmlspecialchars($visitcode); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="patient-info">
                                        <span class="patient-name"><?php echo htmlspecialchars($patientname); ?></span>
                                    </div>
                                </td>
                                <td>
                                    <span class="account-name">
                                        <?php echo htmlspecialchars($patientaccountname); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons" role="group" aria-label="Actions for patient <?php echo htmlspecialchars($patientname); ?>">
                                        <a href="ipamendservice.php?patientcode=<?php echo htmlspecialchars($patientcode); ?>&visitcode=<?php echo htmlspecialchars($visitcode); ?>&patientlocationcode=<?php echo htmlspecialchars($patientlocationcode); ?>" 
                                           class="action-btn amend" title="Amend Service Consultation" aria-label="Amend service consultation for <?php echo htmlspecialchars($patientname); ?>">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="action-btn view" 
                                                onclick="viewPatientDetails('<?php echo htmlspecialchars($patientcode); ?>', '<?php echo htmlspecialchars($visitcode); ?>')"
                                                title="View Patient Details" aria-label="View details for patient <?php echo htmlspecialchars($patientname); ?>">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="action-btn print" 
                                                onclick="printConsultation('<?php echo htmlspecialchars($patientcode); ?>', '<?php echo htmlspecialchars($visitcode); ?>')"
                                                title="Print Consultation" aria-label="Print consultation for <?php echo htmlspecialchars($patientname); ?>">
                                            <i class="fas fa-print"></i>
                                        </button>
                                        <button class="action-btn service" 
                                                onclick="viewServiceDetails('<?php echo htmlspecialchars($patientcode); ?>', '<?php echo htmlspecialchars($visitcode); ?>')"
                                                title="View Service Details" aria-label="View service details for <?php echo htmlspecialchars($patientname); ?>">
                                            <i class="fas fa-cogs"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php 
                                    }   
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($sno == 0): ?>
                <div class="no-data-message">
                    <i class="fas fa-info-circle"></i>
                    <p>No pending IP service consultations found for the selected criteria.</p>
                    <p>Try adjusting your search parameters or date range.</p>
                </div>
                <?php endif; ?>

                <!-- Summary Footer -->
                <div class="table-summary-footer">
                    <div class="summary-stats">
                        <div class="stat-item">
                            <i class="fas fa-cogs"></i>
                            <span>Total Consultations: <strong><?php echo $sno; ?></strong></span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-clock"></i>
                            <span>Date Range: <strong><?php echo isset($_POST['ADate1']) ? htmlspecialchars($_POST['ADate1']) : ''; ?></strong> to <strong><?php echo isset($_POST['ADate2']) ? htmlspecialchars($_POST['ADate2']) : ''; ?></strong></span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Pending Consultations: <strong><?php echo $resnw1; ?></strong></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/ipamendserpending-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>