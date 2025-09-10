<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$docno = $_SESSION['docno'];

$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);

$locationname = $res["locationname"];
$locationcode = $res["locationcode"];
$res12locationanum = $res["auto_number"];

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }

$patientnameget = isset($_REQUEST['patientname']) ? $_REQUEST['patientname'] : '';
$patientcodeget = isset($_REQUEST['patientcode']) ? $_REQUEST['patientcode'] : '';
$visitcodeget = isset($_REQUEST['visitcode']) ? $_REQUEST['visitcode'] : '';
$fromdate = isset($_REQUEST['ADate1']) ? $_REQUEST['ADate1'] : '';
$todate = isset($_REQUEST['ADate2']) ? $_REQUEST['ADate2'] : '';

// Get pending lab consultations count
$querynw1 = "select * from ipconsultation_lab where labsamplecoll='pending' and paymentstatus = 'pending' group by patientvisitcode order by consultationdate desc";
$execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$resnw1 = mysqli_num_rows($execnw1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amend IP Doctor List - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/amendlistipdoctor-modern.css?v=<?php echo time(); ?>">
    
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
        <span>Amend IP Doctor List</span>
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
                        <a href="advancedeposit.php" class="nav-link">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Advance Deposit</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addalertmessage1.php" class="nav-link">
                            <i class="fas fa-bell"></i>
                            <span>Alert Messages</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ar_allocatedreport.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>AR Allocated Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="amendallocations.php" class="nav-link">
                            <i class="fas fa-edit"></i>
                            <span>Amend Allocations</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="doctorentrylist.php" class="nav-link">
                            <i class="fas fa-user-md"></i>
                            <span>Doctor Entry List</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="amendlistipdoctor.php" class="nav-link">
                            <i class="fas fa-stethoscope"></i>
                            <span>Amend IP Doctor</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="newpatient.php" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>New Patient</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="patientlist.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Patient List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="visitentry.php" class="nav-link">
                            <i class="fas fa-calendar-check"></i>
                            <span>Visit Entry</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer">
                <?php if ($st == 'success' && $billautonumber != ''): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle alert-icon"></i>
                        <span>Success! Bill Saved Successfully.</span>
                        <button class="btn btn-primary" onclick="loadprintpage1('<?php echo htmlspecialchars($billautonumber); ?>')">
                            <i class="fas fa-print"></i> Print Invoice
                        </button>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Amend IP Doctor List</h2>
                    <p>Search and manage inpatient doctor consultations that require amendments.</p>
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
                
                <form name="cbform1" method="post" action="amendlistipdoctor.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" class="form-input" onchange="ajaxlocationfunction(this.value);">
                                <?php
                                $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $locationname = $res1["locationname"];
                                    $locationcode = $res1["locationcode"];
                                    $selected = ($locationcode == $locationcode) ? 'selected' : '';
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
                                   value="<?php echo htmlspecialchars($patientnameget); ?>" 
                                   class="form-input" placeholder="Enter patient name..." autocomplete="off">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="patientcode" class="form-label">Patient Code</label>
                            <input name="patientcode" type="text" id="patientcode" 
                                   value="<?php echo htmlspecialchars($patientcodeget); ?>" 
                                   class="form-input" placeholder="Enter patient code..." autocomplete="off">
                        </div>
                        
                        <div class="form-group">
                            <label for="visitcode" class="form-label">Visit Code</label>
                            <input name="visitcode" type="text" id="visitcode" 
                                   value="<?php echo htmlspecialchars($visitcodeget); ?>" 
                                   class="form-input" placeholder="Enter visit code..." autocomplete="off">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <input name="ADate1" id="ADate1" type="date" 
                                   value="<?php echo htmlspecialchars($fromdate ?: $transactiondatefrom); ?>" 
                                   class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <input name="ADate2" id="ADate2" type="date" 
                                   value="<?php echo htmlspecialchars($todate ?: $transactiondateto); ?>" 
                                   class="form-input">
                        </div>
                    </div>

                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-search"></i>
                            Search
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetSearchForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <?php if (isset($_REQUEST["cbfrmflag1"]) && $_REQUEST["cbfrmflag1"] == 'cbfrmflag1'): ?>
            <!-- Data Table Section -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-table data-table-icon"></i>
                    <h3 class="data-table-title">IP Doctor Consultations</h3>
                    <div class="table-summary">
                        <span class="summary-item">
                            <i class="fas fa-users"></i>
                            <strong>Total Records:</strong> 
                            <span id="totalRecords">0</span>
                        </span>
                        <span class="summary-item">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Pending Labs:</strong> 
                            <span><?php echo $resnw1; ?></span>
                        </span>
                    </div>
                </div>

                <div class="table-container">
                    <table class="data-table" id="ipDoctorTable">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>IP Date</th>
                                <th>Patient Code</th>
                                <th>Visit Code</th>
                                <th>Patient Name</th>
                                <th>Account</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="ipDoctorTableBody">
                            <?php 
                            $colorloopcount = 0;
                            $sno = 0;
                            
                            if (isset($_REQUEST["cbfrmflag1"]) && $_REQUEST["cbfrmflag1"] == 'cbfrmflag1') {
                                $query1 = "SELECT a.patientcode as patientcode, a.patientvisitcode, a.patientname, a.accountname, a.consultationdate FROM ipprivate_doctor as a WHERE a.patientvisitcode NOT IN (SELECT visitcode FROM billing_ip WHERE 1) AND a.patientname LIKE '%$patientnameget%' AND a.patientcode LIKE '%$patientcodeget%' AND a.patientvisitcode LIKE '%$visitcodeget%' AND a.consultationdate BETWEEN '".$fromdate."' AND '".$todate."' GROUP BY a.patientvisitcode ORDER BY a.consultationdate DESC";
                                
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $num = mysqli_num_rows($exec1);
                                
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $patientcode = $res1['patientcode'];
                                    $visitcode = $res1['patientvisitcode'];
                                    $patientname = $res1['patientname'];
                                    $patientaccountname = $res1['accountname'];
                                    $consultationdate = $res1['consultationdate'];
                                    
                                    $colorloopcount = $colorloopcount + 1;
                                    $sno++;
                            ?>
                            <tr class="<?php echo ($sno % 2 == 0) ? 'even-row' : 'odd-row'; ?>" id="row_<?php echo $sno; ?>">
                                <td><?php echo $sno; ?></td>
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
                                    <div class="action-buttons">
                                        <a href="amendipdoctor.php?patientcode=<?php echo htmlspecialchars($patientcode); ?>&visitcode=<?php echo htmlspecialchars($visitcode); ?>" 
                                           class="action-btn amend" title="Amend Doctor Consultation">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="action-btn view" 
                                                onclick="viewPatientDetails('<?php echo htmlspecialchars($patientcode); ?>', '<?php echo htmlspecialchars($visitcode); ?>')"
                                                title="View Patient Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="action-btn print" 
                                                onclick="printConsultation('<?php echo htmlspecialchars($patientcode); ?>', '<?php echo htmlspecialchars($visitcode); ?>')"
                                                title="Print Consultation">
                                            <i class="fas fa-print"></i>
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

                <?php if ($sno == 0): ?>
                <div class="no-data-message">
                    <i class="fas fa-info-circle"></i>
                    <p>No IP doctor consultations found for the selected criteria.</p>
                    <p>Try adjusting your search parameters or date range.</p>
                </div>
                <?php endif; ?>

                <!-- Summary Footer -->
                <div class="table-summary-footer">
                    <div class="summary-stats">
                        <div class="stat-item">
                            <i class="fas fa-calendar-check"></i>
                            <span>Total Consultations: <strong><?php echo $sno; ?></strong></span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-clock"></i>
                            <span>Date Range: <strong><?php echo htmlspecialchars($fromdate); ?></strong> to <strong><?php echo htmlspecialchars($todate); ?></strong></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/amendlistipdoctor-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy Functions -->
    <script type="text/javascript">
        function loadprintpage1(banum) {
            var banum = banum;
            window.open("print_bill1_op1.php?billautonumber=" + banum + "", "Window" + banum + "", 'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
        }

        function ajaxlocationfunction(locationcode) {
            // AJAX function for location changes
            console.log('Location changed to:', locationcode);
        }

        // Update total records count
        document.addEventListener('DOMContentLoaded', function() {
            const totalRecords = document.getElementById('totalRecords');
            if (totalRecords) {
                const rows = document.querySelectorAll('#ipDoctorTableBody tr');
                totalRecords.textContent = rows.length;
            }
        });
    </script>
</body>
</html>

