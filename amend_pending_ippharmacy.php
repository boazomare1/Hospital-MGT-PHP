<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
$docno = $_SESSION['docno'];

if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ''; }
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $transactiondatefrom; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $transactiondateto; }
if (isset($_REQUEST["patientname1"])) { $patientname1 = $_REQUEST["patientname1"]; } else { $patientname1 = ''; }
if (isset($_REQUEST["patientcode1"])) { $patientcode1 = $_REQUEST["patientcode1"]; } else { $patientcode1 = ''; }
if (isset($_REQUEST["visitcode1"])) { $visitcode1 = $_REQUEST["visitcode1"]; } else { $visitcode1 = ''; }

// Get pending pharmacy consultations count
$querynw1 = "select * from master_consultationpharm where medicineissue='pending' and billing = '' group by patientvisitcode order by recorddate desc";
$execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$resnw1 = mysqli_num_rows($execnw1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amend Pending IP Pharmacy - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/amendpendingippharmacy-modern.css?v=<?php echo time(); ?>">
    
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
        <span>Amend Pending IP Pharmacy</span>
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
                    <li class="nav-item">
                        <a href="amendlistipdoctor.php" class="nav-link">
                            <i class="fas fa-stethoscope"></i>
                            <span>Amend IP Doctor</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="amend_pending_ippharmacy.php" class="nav-link">
                            <i class="fas fa-pills"></i>
                            <span>Amend IP Pharmacy</span>
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
                <?php include ("includes/alertmessages1.php"); ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Amend Pending IP Pharmacy</h2>
                    <p>Search and manage inpatient pharmacy prescriptions that require amendments.</p>
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
                
                <form name="cbform1" method="post" action="amend_pending_ippharmacy.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="patientname1" class="form-label">Patient Name</label>
                            <input name="patientname1" type="text" id="patientname1" 
                                   value="<?php echo htmlspecialchars($patientname1); ?>" 
                                   class="form-input" placeholder="Enter patient name..." autocomplete="off">
                        </div>
                        
                        <div class="form-group">
                            <label for="patientcode1" class="form-label">Registration No</label>
                            <input name="patientcode1" type="text" id="patientcode1" 
                                   value="<?php echo htmlspecialchars($patientcode1); ?>" 
                                   class="form-input" placeholder="Enter registration number..." autocomplete="off">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="visitcode1" class="form-label">Visit Code</label>
                            <input name="visitcode1" type="text" id="visitcode1" 
                                   value="<?php echo htmlspecialchars($visitcode1); ?>" 
                                   class="form-input" placeholder="Enter visit code..." autocomplete="off">
                        </div>
                        
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" class="form-input">
                                <option value="">Select Location</option>
                                <?php
                                $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $locationname = $res1["locationname"];
                                    $locationcode = $res1["locationcode"];
                                    $selected = ($locationcode == $location) ? 'selected' : '';
                                ?>
                                <option value="<?php echo htmlspecialchars($locationcode); ?>" <?php echo $selected; ?>>
                                    <?php echo htmlspecialchars($locationname); ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <input name="ADate1" id="ADate1" type="date" 
                                   value="<?php echo htmlspecialchars($ADate1); ?>" 
                                   class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <input name="ADate2" id="ADate2" type="date" 
                                   value="<?php echo htmlspecialchars($ADate2); ?>" 
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
                    <h3 class="data-table-title">Pending IP Pharmacy Prescriptions</h3>
                    <div class="table-summary">
                        <span class="summary-item">
                            <i class="fas fa-pills"></i>
                            <strong>Pending Pharmacy:</strong> 
                            <span><?php echo $resnw1; ?></span>
                        </span>
                        <span class="summary-item">
                            <i class="fas fa-users"></i>
                            <strong>Total Records:</strong> 
                            <span id="totalRecords">0</span>
                        </span>
                    </div>
                </div>

                <div class="table-container">
                    <table class="data-table" id="ipPharmacyTable">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>OP Date</th>
                                <th>Patient Code</th>
                                <th>Visit Code</th>
                                <th>Patient Name</th>
                                <th>Account</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="ipPharmacyTableBody">
                            <?php 
                            $colorloopcount = 0;
                            $sno = 0;
                            
                            if (isset($_REQUEST["cbfrmflag1"]) && $_REQUEST["cbfrmflag1"] == 'cbfrmflag1') {
                                $query1 = "select * from ipmedicine_prescription where medicineissue='pending' and patientcode like '%$patientcode1' and visitcode like '%$visitcode1%' and patientname like '%$patientname1%' and date between '$ADate1' and '$ADate2' and locationcode = '$location' group by visitcode order by auto_number desc";
                                
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $patientcode = $res1['patientcode'];
                                    $visitcode = $res1['visitcode'];
                                    $consultationdate = $res1['date'];
                                    
                                    $query21 = "select * from master_ipvisitentry where visitcode='$visitcode'";
                                    $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res21 = mysqli_fetch_array($exec21);
                                    $patientaccountname = $res21['accountfullname'];
                                    $patientname = $res21['patientfullname'];
                                    
                                    $query2 = "select * from master_ipvisitentry where visitcode='$visitcode' and overallpayment=''";
                                    $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $num2 = mysqli_num_rows($exec2);
                                    
                                    if ($num2 > 0) {
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
                                        <a href="amendippharmacy.php?patientcode=<?php echo htmlspecialchars($patientcode); ?>&visitcode=<?php echo htmlspecialchars($visitcode); ?>&menuid=<?php echo isset($menu_id) ? htmlspecialchars($menu_id) : ''; ?>" 
                                           class="action-btn amend" title="Amend Pharmacy Prescription">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="action-btn view" 
                                                onclick="viewPatientDetails('<?php echo htmlspecialchars($patientcode); ?>', '<?php echo htmlspecialchars($visitcode); ?>')"
                                                title="View Patient Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="action-btn print" 
                                                onclick="printPrescription('<?php echo htmlspecialchars($patientcode); ?>', '<?php echo htmlspecialchars($visitcode); ?>')"
                                                title="Print Prescription">
                                            <i class="fas fa-print"></i>
                                        </button>
                                        <button class="action-btn pharmacy" 
                                                onclick="viewPharmacyDetails('<?php echo htmlspecialchars($patientcode); ?>', '<?php echo htmlspecialchars($visitcode); ?>')"
                                                title="View Pharmacy Details">
                                            <i class="fas fa-pills"></i>
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
                    <p>No pending IP pharmacy prescriptions found for the selected criteria.</p>
                    <p>Try adjusting your search parameters or date range.</p>
                </div>
                <?php endif; ?>

                <!-- Summary Footer -->
                <div class="table-summary-footer">
                    <div class="summary-stats">
                        <div class="stat-item">
                            <i class="fas fa-pills"></i>
                            <span>Total Prescriptions: <strong><?php echo $sno; ?></strong></span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-clock"></i>
                            <span>Date Range: <strong><?php echo htmlspecialchars($ADate1); ?></strong> to <strong><?php echo htmlspecialchars($ADate2); ?></strong></span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Pending Pharmacy: <strong><?php echo $resnw1; ?></strong></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/amendpendingippharmacy-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy Functions -->
    <script type="text/javascript">
        function cbcustomername1() {
            document.cbform1.submit();
        }

        function disableEnterKey(varPassed) {
            if (event.keyCode == 8) {
                event.keyCode = 0;
                return event.keyCode;
                return false;
            }
            
            var key;
            if (window.event) {
                key = window.event.keyCode;
            } else {
                key = e.which;
            }

            if (key == 13) {
                return false;
            } else {
                return true;
            }
        }

        // Update total records count
        document.addEventListener('DOMContentLoaded', function() {
            const totalRecords = document.getElementById('totalRecords');
            if (totalRecords) {
                const rows = document.querySelectorAll('#ipPharmacyTableBody tr');
                totalRecords.textContent = rows.length;
            }
        });
    </script>
</body>
</html>



