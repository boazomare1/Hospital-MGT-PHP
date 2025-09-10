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
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$cbfrmflag1 = isset($_REQUEST['cbfrmflag1']) ? $_REQUEST['cbfrmflag1'] : '';
$docno = $_SESSION['docno'];

// Get location for sort by location purpose
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
if ($location != '') {
    $locationcode = $location;
}

// Get refund request count
$querynw1 = "select * from depositrefund_request where recordstatus = ''";
$execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$resnw1 = mysqli_num_rows($execnw1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit Refund Request List - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/depositrefundrequestlist-modern.css?v=<?php echo time(); ?>">
    
    <!-- Date picker styles -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- Auto-suggest styles -->
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
        <span>Deposit Refund Request List</span>
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
                        <a href="ipamendser_pending.php" class="nav-link">
                            <i class="fas fa-cogs"></i>
                            <span>IP Service Pending</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="analyzerresults.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Results</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="analyzecomparison.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Analyze Comparison</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="employeepayrollreport2.php" class="nav-link">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Payroll Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="viewapprovedrfplist.php" class="nav-link">
                            <i class="fas fa-file-contract"></i>
                            <span>Approved RFPs</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="depositrefundrequestlist.php" class="nav-link">
                            <i class="fas fa-undo"></i>
                            <span>Refund Requests</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="amend_pending_lab.php" class="nav-link">
                            <i class="fas fa-microscope"></i>
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
                    <h2><i class="fas fa-undo"></i> Deposit Refund Request List</h2>
                    <p>View and manage deposit refund requests for patients</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button class="btn btn-secondary" onclick="printPage()">
                        <i class="fas fa-print"></i> Print
                    </button>
                    <button class="btn btn-primary" onclick="exportToPDF()">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </button>
                </div>
            </div>

            <!-- Search Form Section -->
            <div class="search-form-section">
                <div class="search-form-header">
                    <h3><i class="fas fa-search"></i> Search Refund Requests</h3>
                </div>
                
                <form name="cbform1" method="post" action="depositrefundrequestlist.php" id="searchForm" class="search-form-content">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location *</label>
                            <select name="location" id="location" class="form-select" required>
                                <option value="">Select Location</option>
                                <?php
                                $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $res1location = $res1["locationname"];
                                    $res1locationanum = $res1["locationcode"];
                                    $selected = ($location != '' && $location == $res1locationanum) ? 'selected' : '';
                                    echo "<option value=\"$res1locationanum\" $selected>$res1location</option>";
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="patient" class="form-label">Patient Name</label>
                            <input name="patient" type="text" id="patient" class="form-input" 
                                   placeholder="Enter patient name..." autocomplete="off">
                        </div>
                        
                        <div class="form-group">
                            <label for="patientcode" class="form-label">Registration No</label>
                            <input name="patientcode" type="text" id="patientcode" class="form-input" 
                                   placeholder="Enter registration number..." autocomplete="off">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="visitcode" class="form-label">Visit Code</label>
                            <input name="visitcode" type="text" id="visitcode" class="form-input" 
                                   placeholder="Enter visit code..." autocomplete="off">
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From *</label>
                            <div class="date-input-group">
                                <input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>" 
                                       class="form-input" readonly required>
                                <i class="fas fa-calendar calendar-icon" onclick="NewCssCal('ADate1')"></i>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To *</label>
                            <div class="date-input-group">
                                <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>" 
                                       class="form-input" readonly required>
                                <i class="fas fa-calendar calendar-icon" onclick="NewCssCal('ADate2')"></i>
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

            <?php if ($cbfrmflag1 == 'cbfrmflag1'): ?>
            <!-- Refund Request List Section -->
            <div class="refund-list-section">
                <div class="refund-list-header">
                    <h3>
                        <i class="fas fa-undo"></i>
                        Deposit Refund Requests
                        <span class="refund-count"><?php echo $sno; ?></span>
                    </h3>
                    <div class="refund-list-actions">
                        <button class="btn btn-secondary" onclick="exportToExcel()">
                            <i class="fas fa-file-excel"></i> Excel
                        </button>
                        <button class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset Filters
                        </button>
                    </div>
                </div>

                <!-- Refund Table -->
                <div class="refund-table-container">
                    <table class="refund-table" id="refundTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Patient Code</th>
                                <th>Patient</th>
                                <th>Account</th>
                                <th>Location</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $colorloopcount = '';
                            $sno = '';
                            
                            $location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
                            $patient1 = isset($_REQUEST['patient']) ? $_REQUEST['patient'] : '';
                            $patientcode1 = isset($_REQUEST['patientcode']) ? $_REQUEST['patientcode'] : '';
                            $visitcode1 = isset($_REQUEST['visitcode']) ? $_REQUEST['visitcode'] : '';
                            $ADate1 = isset($_REQUEST['ADate1']) ? $_REQUEST['ADate1'] : '';
                            $ADate2 = isset($_REQUEST['ADate2']) ? $_REQUEST['ADate2'] : '';
                            $docno1 = isset($_REQUEST['docno']) ? $_REQUEST['docno'] : '';
                            
                            // First query for depositrefund_request
                            $query1 = "select * from depositrefund_request where recordstatus = '' and locationcode ='$location' and patientcode like '%$patientcode1%' and visitcode like '%$visitcode1%' and patientname like '%$patient1%' and docno like '%$docno1%' and recorddate between '$ADate1' and '$ADate2'";
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            if (mysqli_num_rows($exec1) > 0):
                                while ($res1 = mysqli_fetch_array($exec1)):
                                    $patientcode = $res1['patientcode'];
                                    $visitcode = $res1['visitcode'];
                                    $patientfullname = $res1['patientname'];
                                    $account = $res1['accountname'];
                                    $docno = $res1['docno'];
                                    $locationcodeget = $res1['locationcode'];
                                    $locationnameget = $res1['locationname'];
                                    $consultationdate = $res1['recorddate'];
                                    
                                    $colorloopcount = $colorloopcount + 1;
                                    $showcolor = ($colorloopcount & 1); 
                                    
                                    $query2 = "select visitcode from master_transactionip where visitcode = '$visitcode' and patientcode = '$patientcode'";
                                    $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $num2 = mysqli_num_rows($exec2);
                                    
                                    if ($num2 == 0):
                                        if ($showcolor == 0) {
                                            $colorcode = 'bgcolor="#CBDBFA"';
                                        } else {
                                            $colorcode = 'bgcolor="#ecf0f5"';
                                        }
                            ?>
                            <tr <?php echo $colorcode; ?> data-patientcode="<?php echo htmlspecialchars($patientcode); ?>">
                                <td class="refund-number"><?php echo $sno = $sno + 1; ?></td>
                                <td class="refund-patientcode"><?php echo htmlspecialchars($patientcode); ?></td>
                                <td class="refund-patient"><?php echo htmlspecialchars($patientfullname); ?></td>
                                <td class="refund-account"><?php echo htmlspecialchars($account); ?></td>
                                <td class="refund-location"><?php echo htmlspecialchars($locationnameget); ?></td>
                                <td class="refund-action">
                                    <a href="approvedepositrefund.php?patientcode=<?php echo urlencode($patientcode); ?>&visitcode=<?php echo urlencode($visitcode); ?>&docno=<?php echo urlencode($docno); ?>&menuid=<?php echo $menu_id; ?>" 
                                       class="approve-btn" data-patientcode="<?php echo htmlspecialchars($patientcode); ?>" 
                                       data-visitcode="<?php echo htmlspecialchars($visitcode); ?>" 
                                       data-docno="<?php echo htmlspecialchars($docno); ?>">
                                        <i class="fas fa-check"></i> Approve
                                    </a>
                                </td>
                            </tr>
                            <?php 
                                        endif;
                                    endwhile;
                            endif;
                            
                            // Second query for master_transactionadvancedeposit
                            $detailquery = "select patientcode,patientname,accountname,locationname,visitcode,docno from master_transactionadvancedeposit where recordstatus='' and refundstatus ='process' and locationcode = '$location' and patientcode like '%$patientcode1%' and visitcode like '%$visitcode1%' and patientname like '%$patient1%' and docno like '%$docno1%' and transactiondate between '$ADate1' and '$ADate2' group by patientcode order by auto_number desc";
                            $exedetail = mysqli_query($GLOBALS["___mysqli_ston"], $detailquery) or die("Error in detailquery".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $numrow = mysqli_num_rows($exedetail);
                            
                            if ($numrow > 0):
                                while ($resquery = mysqli_fetch_array($exedetail)):
                                    $patientcode = $resquery['patientcode'];
                                    $visitcode = $resquery['visitcode'];
                                    $patientfullname = $resquery['patientname'];
                                    $account = $resquery['accountname'];
                                    $docno = $resquery['docno'];
                                    $locationnameget = $resquery['locationname'];
                                    
                                    $colorloopcount = $colorloopcount + 1;
                                    $showcolor = ($colorloopcount & 1); 
                                    
                                    $query2 = "select visitcode from master_transactionip where visitcode = '$visitcode' and patientcode = '$patientcode'";
                                    $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $num2 = mysqli_num_rows($exec2);
                                    
                                    if ($num2 == 0):
                                        if ($showcolor == 0) {
                                            $colorcode = 'bgcolor="#CBDBFA"';
                                        } else {
                                            $colorcode = 'bgcolor="#ecf0f5"';
                                        }
                            ?>
                            <tr <?php echo $colorcode; ?> data-patientcode="<?php echo htmlspecialchars($patientcode); ?>">
                                <td class="refund-number"><?php echo $sno = $sno + 1; ?></td>
                                <td class="refund-patientcode"><?php echo htmlspecialchars($patientcode); ?></td>
                                <td class="refund-patient"><?php echo htmlspecialchars($patientfullname); ?></td>
                                <td class="refund-account"><?php echo htmlspecialchars($account); ?></td>
                                <td class="refund-location"><?php echo htmlspecialchars($locationnameget); ?></td>
                                <td class="refund-action">
                                    <a href="approvedepositrefund.php?patientcode=<?php echo urlencode($patientcode); ?>&list=1&docno1=<?php echo urlencode($docno); ?>" 
                                       class="approve-btn" data-patientcode="<?php echo htmlspecialchars($patientcode); ?>" 
                                       data-visitcode="<?php echo htmlspecialchars($visitcode); ?>" 
                                       data-docno="<?php echo htmlspecialchars($docno); ?>">
                                        <i class="fas fa-check"></i> Approve
                                    </a>
                                </td>
                            </tr>
                            <?php 
                                        endif;
                                    endwhile;
                            endif;
                            
                            if ($sno == 0):
                            ?>
                            <tr>
                                <td colspan="6" class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="fas fa-undo"></i>
                                    </div>
                                    <div class="empty-state-title">No Refund Requests Found</div>
                                    <div class="empty-state-description">
                                        There are currently no deposit refund requests matching your search criteria.
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Summary Section -->
                <div class="summary-section">
                    <div class="summary-grid">
                        <div class="summary-item">
                            <span class="summary-label">Total Refund Requests</span>
                            <span class="summary-value summary-pending"><?php echo $sno; ?></span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Selected Location</span>
                            <span class="summary-value">
                                <?php 
                                if ($location != '') {
                                    $query12 = "select locationname from master_location where locationcode='$location' order by locationname";
                                    $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res12 = mysqli_fetch_array($exec12);
                                    echo htmlspecialchars($res12["locationname"]);
                                } else {
                                    $query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res1 = mysqli_fetch_array($exec1);
                                    echo htmlspecialchars($res1["locationname"]);
                                }
                                ?>
                            </span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Date Range</span>
                            <span class="summary-value"><?php echo date('M d, Y', strtotime($ADate1)); ?> - <?php echo date('M d, Y', strtotime($ADate2)); ?></span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Generated By</span>
                            <span class="summary-value"><?php echo htmlspecialchars($username); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/depositrefundrequestlist-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy scripts for compatibility -->
    <script src="js/datetimepicker_css.js"></script>
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    
    <script language="javascript">
        function cbcustomername1() {
            document.cbform1.submit();
        }

        function pharmacy(patientcode, visitcode) {
            var patientcode = patientcode;
            var visitcode = visitcode;
            var url = "pharmacy1.php?RandomKey=" + Math.random() + "&&patientcode=" + patientcode + "&&visitcode=" + visitcode;
            window.open(url, "Pharmacy", 'width=600,height=400');
        }

        function disableEnterKey(varPassed) {
            if (event.keyCode == 8) {
                event.keyCode = 0; 
                return event.keyCode 
                return false;
            }
            
            var key;
            if (window.event) {
                key = window.event.keyCode;     //IE
            } else {
                key = e.which;     //firefox
            }

            if (key == 13) // if enter key press
            {
                return false;
            } else {
                return true;
            }
        }
    </script>
</body>
</html>



