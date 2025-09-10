<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

$docno = $_SESSION['docno'];

// Get default location
$query = "select * from master_location where status <> 'deleted' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);

$locationname = $res["locationname"];
$locationcode = $res["locationcode"];
$res12locationanum = $res["auto_number"];

// Get location for sort by location purpose
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
if ($location != '') {
    $locationcode = $location;
}

// Handle delete action
if (isset($_REQUEST["st"])) { 
    $st = $_REQUEST["st"]; 
} else { 
    $st = ""; 
}

if ($st == 'del') {
    $delanum = $_REQUEST["anum"];
    $query3 = "UPDATE ip_creditapproval set recordstatus = 'deleted' where auto_number = '$delanum'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
    header("Location: approvedcreditlist.php?msg=deleted");
    exit();
}

// Check for URL messages
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'deleted') {
        $errmsg = "Credit approval deleted successfully.";
        $bgcolorcode = 'success';
    }
}

// Get total count
$querynw1 = "select * from ip_creditapproval where recordstatus='approved' group by visitcode order by auto_number desc";
$execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$resnw1 = mysqli_num_rows($execnw1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Credit List - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/approvedcreditlist-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body onLoad="funcPopupOnLoader()">
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
        <span>Approved Credit List</span>
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
                        <a href="labitem1master.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Items</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="openingstockentry_master.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Opening Stock</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addward.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Wards</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountreceivableentrylist.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>Account Receivable</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="corporateoutstanding.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Corporate Outstanding</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountstatement.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Account Statement</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountsmain.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Accounts Main</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountssub.php" class="nav-link">
                            <i class="fas fa-chart-pie"></i>
                            <span>Accounts Sub Type</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="fixedasset_acquisition_report.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Fixed Asset Acquisition</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeinpatientlist.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Active Inpatient List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeusersreport.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Active Users Report</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="approvedcreditlist.php" class="nav-link">
                            <i class="fas fa-credit-card"></i>
                            <span>Approved Credit List</span>
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
                    <div class="alert alert-<?php echo $bgcolorcode === 'success' ? 'success' : 'info'; ?>">
                        <i class="fas fa-<?php echo $bgcolorcode === 'success' ? 'check-circle' : 'info-circle'; ?> alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Approved Credit List</h2>
                    <p>View and manage approved credit requests for inpatients.</p>
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

            <!-- Data Table Section -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-list data-table-icon"></i>
                    <h3 class="data-table-title">Approved Credit Records</h3>
                    <div class="record-count">
                        <span class="count-badge"><?php echo $resnw1; ?></span>
                        <span class="count-text">Total Records</span>
                    </div>
                </div>

                <!-- Search Bar -->
                <div style="margin-bottom: 1rem;">
                    <div style="display: flex; gap: 1rem; align-items: center;">
                        <input type="text" id="searchInput" class="form-input" 
                               placeholder="Search patient code, name, or visit code..." 
                               style="flex: 1; max-width: 300px;"
                               oninput="searchRecords(this.value)">
                        <button type="button" class="btn btn-secondary" onclick="clearSearch()">
                            <i class="fas fa-times"></i> Clear
                        </button>
                    </div>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>IP Date</th>
                            <th>Patient Code</th>
                            <th>Visit Code</th>
                            <th>Patient Name</th>
                            <th>Account</th>
                            <th>Location</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="creditTableBody">
                        <?php
                        $colorloopcount = '';
                        $sno = '';
                        $query2 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                        $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while ($res2 = mysqli_fetch_array($exec2)) {
                            $locationname = $res2["locationname"];
                            $locationcode = $res2["locationcode"];

                            $query1 = "select * from ip_creditapproval where recordstatus='approved' AND locationcode = '".$locationcode."' group by visitcode order by auto_number desc";
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res1 = mysqli_fetch_array($exec1)) {
                                $patientcode = $res1['patientcode'];
                                $visitcode = $res1['visitcode'];
                                $patientname = $res1['patientname'];
                                $account = $res1['accountname'];
                                $locationcodeget = $res1['locationcode'];
                                $locationnameget = $res1['locationname'];
                                
                                $query11 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
                                $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res11 = mysqli_fetch_array($exec11);
                                $ipdate = $res11['consultationdate'];
                                
                                $ipvist_autonumber = $res11['auto_number'];
                                $planname = $res11['planname'];
                                
                                $query110 = "select smartap from master_planname where auto_number='$planname'";
                                $exec110 = mysqli_query($GLOBALS["___mysqli_ston"], $query110) or die ("Error in Query110".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res110 = mysqli_fetch_array($exec110);
                                $smartap = $res110['smartap'];
                                
                                $colorloopcount = $colorloopcount + 1;
                                $sno = $sno + 1;
                                ?>
                                <tr id="idTR<?php echo $colorloopcount; ?>">
                                    <td>
                                        <span class="record-number"><?php echo $sno; ?></span>
                                    </td>
                                    <td>
                                        <span class="date-badge"><?php echo $ipdate; ?></span>
                                    </td>
                                    <td>
                                        <span class="patient-code-badge"><?php echo htmlspecialchars($patientcode); ?></span>
                                    </td>
                                    <td>
                                        <span class="visit-code-badge"><?php echo htmlspecialchars($visitcode); ?></span>
                                    </td>
                                    <td>
                                        <div class="patient-info">
                                            <span class="patient-name"><?php echo htmlspecialchars($patientname); ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="account-badge"><?php echo htmlspecialchars($account); ?></span>
                                    </td>
                                    <td>
                                        <span class="location-badge"><?php echo htmlspecialchars($locationnameget); ?></span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="ipapprovedcreditform.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&menuid=<?php echo $menu_id; ?>" 
                                               class="action-btn finalize" title="Finalize">
                                                <i class="fas fa-check-circle"></i>
                                            </a>
                                            <button class="action-btn delete" 
                                                    onclick="confirmDelete('<?php echo htmlspecialchars($patientcode); ?>', '<?php echo $sno; ?>', '<?php echo htmlspecialchars($visitcode); ?>')"
                                                    title="Delete">
                                                <i class="fas fa-trash"></i>
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

                <!-- Pagination -->
                <div id="paginationContainer" style="margin-top: 1rem; text-align: center;"></div>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/approvedcreditlist-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy JavaScript for compatibility -->
    <script type="text/javascript" src="js/disablebackenterkey.js"></script>
    <script type="text/javascript" src="js/jquery.min-autocomplete.js"></script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    
    <script>
    $(document).ready(function(){
        <?php  
        if (isset($_REQUEST["billnumber"])) { $billnumber = $_REQUEST["billnumber"]; } else { $billnumber = ""; }
        if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
        if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
        if (isset($_REQUEST["locationcode"])) { $locationcode = $_REQUEST["locationcode"]; } else { $locationcode = ""; }
        if (isset($_REQUEST["account"])) { $account = $_REQUEST["account"]; } else { $account = ""; }
        ?>
        var billnumber = "<?php echo $billnumber; ?>";
        var patientcode = "<?php echo $patientcode; ?>";
        var visitcode = "<?php echo $visitcode; ?>";
        var locationcode = "<?php echo $locationcode; ?>";
        var account = "<?php echo $account; ?>";
        
        if(billnumber != "" && account!='') {
            window.open("print_creditapproval.php?billnumber="+billnumber+"&&patientcode="+patientcode+"&&visitcode="+visitcode+"&&locationcode="+locationcode+"&&account="+account+"","OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
        } else if(billnumber != "" && account=='') {
            window.open("print_creditapproval.php?billnumber="+billnumber+"&&patientcode="+patientcode+"&&visitcode="+visitcode+"&&locationcode="+locationcode+"","OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
        }
    });

    <?php 
    if (isset($_REQUEST["billnumber"])) { $creditbillnumbers = $_REQUEST["billnumber"]; } else { $creditbillnumbers = ""; }
    if (isset($_REQUEST["patientcode"])) { $creditpatientcodes = $_REQUEST["patientcode"]; } else { $creditpatientcodes = ""; }
    if (isset($_REQUEST["visitcode"])) { $creditvisitcodes= $_REQUEST["visitcode"]; } else { $creditvisitcodes = ""; }
    ?>
    var creditbillnumber = "<?php echo $creditbillnumbers; ?>";
    var creditpatientcode = "<?php echo $creditpatientcodes; ?>";
    var creditvisitcode = "<?php echo $creditvisitcodes; ?>";
    
    if(creditvisitcode != "") {
        window.open("print_creditapproval.php?billnumber="+creditbillnumber+"&&patientcode="+creditpatientcode+"&&visitcode="+creditvisitcode,"OriginalWindowA25",
        'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25'); 
    }

    function funcDeleteipcredit(patientcode, sno, visitcode) {
        if(confirm("Are you sure to delete this Entry ?")) {
            var action = "deleteipcreditapproved";	
            var dataString = 'patientcode='+patientcode+'&&ddocno='+sno+'&&action='+action+'&&visitcode='+visitcode;
            if(sno!='') {		
                $.ajax({
                    type: "get",
                    url: "ipcreditapprovaldelete.php",
                    data: dataString,
                    cache: true,
                    success: function(html) {		
                        $('#idTR'+sno).hide();	
                        return false;
                    }			
                });		
            }
        } else {
            return false;
        }
    }

    function funcPopupOnLoader() {
        // Function called on page load
    }
    </script>
</body>
</html>