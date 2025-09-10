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

// Get pending lab consultations count for reference
$querynw1 = "select * from ipconsultation_lab where labsamplecoll='pending' and paymentstatus = 'pending' group by patientvisitcode order by consultationdate desc";
$execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$resnw1 = mysqli_num_rows($execnw1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List IP Misc Billing - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/listipmiscbilling-modern.css?v=<?php echo time(); ?>">
    
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
        <span>List IP Misc Billing</span>
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
                    <li class="nav-item">
                        <a href="amend_pending_ippharmacy.php" class="nav-link">
                            <i class="fas fa-pills"></i>
                            <span>Amend IP Pharmacy</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="amend_pending_lab.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Amend Pending Lab</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="listipmiscbilling.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>List IP Misc Billing</span>
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
                    <h2>List IP Misc Billing</h2>
                    <p>Search and manage miscellaneous billing records for IP patients.</p>
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
                
                <form name="cbform1" method="post" action="listipmiscbilling.php" class="search-form" onsubmit="return check();">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" class="form-input" onChange="ajaxlocationfunction(this.value);">
                                <?php
                                $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $locationname = $res1["locationname"];
                                    $locationcode = $res1["locationcode"];
                                    $selected = ($locationcode == $res12locationanum) ? 'selected' : '';
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
                    <h3 class="data-table-title">IP Misc Billing Records</h3>
                    <div class="table-summary">
                        <span class="summary-item">
                            <i class="fas fa-receipt"></i>
                            <strong>Total Records:</strong> 
                            <span id="totalRecords">0</span>
                        </span>
                        <span class="summary-item">
                            <i class="fas fa-clock"></i>
                            <strong>Date Range:</strong> 
                            <span><?php echo htmlspecialchars($fromdate); ?> to <?php echo htmlspecialchars($todate); ?></span>
                        </span>
                    </div>
                </div>

                <div class="table-container">
                    <table class="data-table" id="miscBillingTable">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Consultation Date</th>
                                <th>Patient Code</th>
                                <th>Visit Code</th>
                                <th>Patient Name</th>
                                <th>Doc No.</th>
                                <th>Account</th>
                                <th>Description</th>
                                <th>Rate</th>
                                <th>Units</th>
                                <th>Amount</th>
                                <th>Remarks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="miscBillingTableBody">
                            <?php 
                            $colorloopcount = 0;
                            $sno = 0;
                            
                            if (isset($_REQUEST["cbfrmflag1"]) && $_REQUEST["cbfrmflag1"] == 'cbfrmflag1') {
                                $query1 = "SELECT * FROM ipmisc_billing WHERE patientname LIKE '%$patientnameget%' AND patientcode LIKE '%$patientcodeget%' AND patientvisitcode LIKE '%$visitcodeget%' AND consultationdate BETWEEN '".$fromdate."' AND '".$todate."' and locationcode = '$locationcode'";
                                
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $num = mysqli_num_rows($exec1);
                                
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $patientcode = $res1['patientcode'];
                                    $visitcode = $res1['patientvisitcode'];
                                    $patientname = $res1['patientname'];
                                    $patientaccountname = $res1['accountname'];
                                    $consultationdate = $res1['consultationdate'];
                                    $docno = $res1['docno'];
                                    $billingaccountname = $res1['billingaccountname'];
                                    $description = $res1['description'];
                                    $rate = $res1['rate'];
                                    $units = $res1['units'];
                                    $amount = $res1['amount'];
                                    $auto_number = $res1['auto_number'];
                                    
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
                                    <span class="doc-number">
                                        <?php echo htmlspecialchars($docno); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="account-name">
                                        <?php echo htmlspecialchars($billingaccountname); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="description-text">
                                        <?php echo htmlspecialchars($description); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="rate-amount">
                                        ₹<?php echo number_format($rate, 2); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="units-count">
                                        <?php echo htmlspecialchars($units); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="total-amount">
                                        ₹<?php echo number_format($amount, 2); ?>
                                    </span>
                                </td>
                                <td>
                                    <input type="text" name="remarks-<?php echo $auto_number; ?>" 
                                           id="remarks-<?php echo $auto_number; ?>" 
                                           class="remarks-input" placeholder="Enter remarks...">
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn delete" 
                                                onclick="deleteRecord('<?php echo $auto_number; ?>', '<?php echo htmlspecialchars($patientcodeget); ?>', '<?php echo htmlspecialchars($visitcodeget); ?>', '<?php echo htmlspecialchars($patientnameget); ?>')"
                                                title="Delete Record">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <button class="action-btn view" 
                                                onclick="viewBillingDetails('<?php echo htmlspecialchars($patientcode); ?>', '<?php echo htmlspecialchars($visitcode); ?>')"
                                                title="View Billing Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="action-btn edit" 
                                                onclick="editBillingRecord('<?php echo $auto_number; ?>')"
                                                title="Edit Record">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="action-btn print" 
                                                onclick="printBillingRecord('<?php echo $auto_number; ?>')"
                                                title="Print Record">
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
                    <p>No IP misc billing records found for the selected criteria.</p>
                    <p>Try adjusting your search parameters or date range.</p>
                </div>
                <?php endif; ?>

                <!-- Summary Footer -->
                <div class="table-summary-footer">
                    <div class="summary-stats">
                        <div class="stat-item">
                            <i class="fas fa-receipt"></i>
                            <span>Total Records: <strong><?php echo $sno; ?></strong></span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-clock"></i>
                            <span>Date Range: <strong><?php echo htmlspecialchars($fromdate); ?></strong> to <strong><?php echo htmlspecialchars($todate); ?></strong></span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Location: <strong><?php echo htmlspecialchars($locationname); ?></strong></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/listipmiscbilling-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy Functions -->
    <script type="text/javascript">
        function cbcustomername1() {
            document.cbform1.submit();
        }

        function check() {
            var a = document.getElementById("patientcode").value;
            var b = document.getElementById("visitcode").value;
            var c = document.getElementById("patientname").value;
            
            if (a != "" || b != "" || c != "") {
                return true;
            } else {
                alert('Please enter at least one search criteria');
                return false;
            }
        }

        function ajaxlocationfunction(locationcode) {
            // AJAX function for location changes
            console.log('Location changed to:', locationcode);
        }

        function deletevalid(anum, patientcode, visitcode) {
            if (confirm('Are you sure you want to delete this record?')) {
                var remarks = document.getElementById('remarks-' + anum).value;
                if (remarks.trim() === '') {
                    alert('Please enter remarks before deleting');
                    return false;
                }
                
                // Encode remarks for URL
                var encodedRemarks = encodeURIComponent(remarks);
                window.location.href = 'listipmiscbilling.php?del=' + anum + '&remarks-' + anum + '=' + encodedRemarks + '&patientcode=' + patientcode + '&visitcode=' + visitcode;
            }
            return false;
        }

        // Update total records count
        document.addEventListener('DOMContentLoaded', function() {
            const totalRecords = document.getElementById('totalRecords');
            if (totalRecords) {
                const rows = document.querySelectorAll('#miscBillingTableBody tr');
                totalRecords.textContent = rows.length;
            }
        });
    </script>
</body>
</html>

