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

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $transactiondatefrom; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $transactiondateto; }
if (isset($_REQUEST["patientname1"])) { $patientname1 = $_REQUEST["patientname1"]; } else { $patientname1 = ''; }
if (isset($_REQUEST["patientcode1"])) { $patientcode1 = $_REQUEST["patientcode1"]; } else { $patientcode1 = ''; }
if (isset($_REQUEST["visitcode1"])) { $visitcode1 = $_REQUEST["visitcode1"]; } else { $visitcode1 = ''; }

// Get pending referral consultations count
$querynw1 = "select * from consultation_departmentreferal where consultation <>'completed' and paymentstatus = 'pending' group by patientvisitcode order by consultationdate desc";
$execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$resnw1 = mysqli_num_rows($execnw1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amend Pending Referral - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/amendpendingreferral-modern.css?v=<?php echo time(); ?>">
    
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
        <span>Amend Pending Referral</span>
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
            <div id="alertContainer"></div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2><i class="fas fa-exchange-alt"></i> Amend Pending Referral</h2>
                    <p>Manage and update pending referral consultations and results</p>
                </div>
                <div class="page-header-actions">
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
                    <h3 class="search-form-title">Search Referral Consultations</h3>
                </div>
                
                <form id="searchForm" name="cbform1" method="post" action="amend_pending_referral.php">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="patientname1" class="form-label">Patient Name</label>
                            <input name="patientname1" type="text" id="patientname1" 
                                   value="<?php echo htmlspecialchars($patientname1); ?>" 
                                   class="form-input" autocomplete="off" placeholder="Enter patient name">
                        </div>
                        
                        <div class="form-group">
                            <label for="patientcode1" class="form-label">Registration No</label>
                            <input name="patientcode1" type="text" id="patientcode1" 
                                   value="<?php echo htmlspecialchars($patientcode1); ?>" 
                                   class="form-input" autocomplete="off" placeholder="Enter registration number">
                        </div>
                        
                        <div class="form-group">
                            <label for="visitcode1" class="form-label">Visit Code</label>
                            <input name="visitcode1" type="text" id="visitcode1" 
                                   value="<?php echo htmlspecialchars($visitcode1); ?>" 
                                   class="form-input" autocomplete="off" placeholder="Enter visit code">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <input name="ADate1" id="ADate1" 
                                   value="<?php echo htmlspecialchars($ADate1); ?>" 
                                   class="form-input" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <input name="ADate2" id="ADate2" 
                                   value="<?php echo htmlspecialchars($ADate2); ?>" 
                                   class="form-input" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">&nbsp;</label>
                            <div style="display: flex; gap: 0.5rem; align-items: flex-end;">
                                <button type="button" onclick="setDate('ADate1', -7)" class="btn btn-outline">Last 7 Days</button>
                                <button type="button" onclick="setDate('ADate1', -30)" class="btn btn-outline">Last 30 Days</button>
                                <button type="button" onclick="setDate('ADate1', -90)" class="btn btn-outline">Last 90 Days</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <?php if (isset($_REQUEST["cbfrmflag1"]) && $_REQUEST["cbfrmflag1"] == 'cbfrmflag1'): ?>
            <!-- Data Table Section -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="data-table-icon fas fa-exchange-alt"></i>
                    <h3 class="data-table-title">Pending Referral Consultations</h3>
                    <div class="table-summary">
                        <div class="summary-item">
                            <i class="fas fa-calendar"></i>
                            <span>Date Range: <?php echo htmlspecialchars($ADate1); ?> to <?php echo htmlspecialchars($ADate2); ?></span>
                        </div>
                        <div class="summary-item">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Pending Referrals: <strong><?php echo $resnw1; ?></strong></span>
                        </div>
                    </div>
                </div>
                
                <div class="table-container">
                    <table class="data-table" id="referralTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Consultation Date</th>
                                <th>Patient Code</th>
                                <th>Visit Code</th>
                                <th>Patient Name</th>
                                <th>Account</th>
                                <th>Actions</th>
            </tr>
                        </thead>
                        <tbody id="referralTableBody">
			<?php
			$colorloopcount = '';
			$sno = '';

                            // Query for pending referral consultations - PAY NOW
			  $query1 = "select * from consultation_departmentreferal where patientcode like '%$patientcode1' and patientvisitcode like '%$visitcode1%' and patientname like '%$patientname1%' and consultation <>'completed' and consultationdate between '$ADate1' and '$ADate2' and paymentstatus = 'pending' and billtype = 'PAY NOW' group by patientvisitcode order by consultationdate DESC";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

                            while ($res1 = mysqli_fetch_array($exec1)) {
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientname = $res1['patientname'];
                                $patientaccountname = $res1['accountname'];
                                $consultationdate = $res1['consultationdate'];

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
                                    <div class="action-buttons">
                                        <a href="amendreferral.php?patientcode=<?php echo htmlspecialchars($patientcode); ?>&visitcode=<?php echo htmlspecialchars($visitcode); ?>&menuid=<?php echo $menu_id; ?>" 
                                           class="action-btn amend" title="Amend Referral Consultation">
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
                                        <button class="action-btn referral" 
                                                onclick="viewReferralDetails('<?php echo htmlspecialchars($patientcode); ?>', '<?php echo htmlspecialchars($visitcode); ?>')"
                                                title="View Referral Details">
                                            <i class="fas fa-exchange-alt"></i>
                                        </button>
                                    </div>
                                </td>
              </tr>
			<?php
                            }
                            
                            // Query for additional pending consultations - PAY LATER
                            $query11 = "select * from consultation_departmentreferal where patientcode like '%$patientcode1' and patientvisitcode like '%$visitcode1%' and patientname like '%$patientname1%' and consultationdate between '$ADate1' and '$ADate2' and billtype = 'PAY LATER' group by patientvisitcode order by consultationdate DESC";
                            $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            while ($res11 = mysqli_fetch_array($exec11)) {
			$patientcode = $res11['patientcode'];
			$visitcode = $res11['patientvisitcode'];
			$patientname = $res11['patientname'];
                                $patientaccountname = $res11['accountname'];
                                $consultationdate = $res11['consultationdate'];
                                
                                // Check if visit has overall payment
                                $query2 = "select * from master_visitentry where visitcode='$visitcode' and overallpayment <>'completed'";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num2 = mysqli_num_rows($exec2);

                                if($num2 > 0) {
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
                                    <div class="action-buttons">
                                        <a href="amendreferral.php?patientcode=<?php echo htmlspecialchars($patientcode); ?>&visitcode=<?php echo htmlspecialchars($visitcode); ?>&menuid=<?php echo $menu_id; ?>" 
                                           class="action-btn amend" title="Amend Referral Consultation">
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
                                        <button class="action-btn referral" 
                                                onclick="viewReferralDetails('<?php echo htmlspecialchars($patientcode); ?>', '<?php echo htmlspecialchars($visitcode); ?>')"
                                                title="View Referral Details">
                                            <i class="fas fa-exchange-alt"></i>
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
                    <p>No pending referral consultations found for the selected criteria.</p>
                    <p>Try adjusting your search parameters or date range.</p>
                </div>
                <?php endif; ?>

                <!-- Summary Footer -->
                <div class="table-summary-footer">
                    <div class="summary-stats">
                        <div class="stat-item">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Total Consultations: <strong><?php echo $sno; ?></strong></span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-clock"></i>
                            <span>Date Range: <strong><?php echo htmlspecialchars($ADate1); ?></strong> to <strong><?php echo htmlspecialchars($ADate2); ?></strong></span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Pending Referrals: <strong><?php echo $resnw1; ?></strong></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/amendpendingreferral-modern.js?v=<?php echo time(); ?>"></script>
    
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

        // Set date helper function
        function setDate(inputId, daysOffset) {
            const date = new Date();
            date.setDate(date.getDate() + daysOffset);
            const formattedDate = date.toISOString().split('T')[0];
            document.getElementById(inputId).value = formattedDate;
        }

        // Update total records count
        document.addEventListener('DOMContentLoaded', function() {
            const totalRecords = document.getElementById('totalRecords');
            if (totalRecords) {
                const rows = document.querySelectorAll('#referralTableBody tr');
                totalRecords.textContent = rows.length;
            }
        });
    </script>
</body>
</html>



