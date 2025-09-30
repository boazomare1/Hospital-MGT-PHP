<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];   

$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');

$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';	
$locationcode1 = isset($_REQUEST['locationcodenew']) ? $_REQUEST['locationcodenew'] : '';

if(isset($_POST['ADate1'])){$fromdate = $_POST['ADate1'];}else{$fromdate=$transactiondatefrom;}
if(isset($_POST['ADate2'])){$todate = $_POST['ADate2'];}else{$todate=$transactiondateto;}

// Get location details
$query1 = "select locationname, locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1location = $res1["locationname"];
$res1locationanum = $res1["locationcode"];

// Check if table exists and get medicine issued list data
$tableExists = false;
$exec2 = null;
$sno = 0;

// Check if table exists
$checkTable = "SHOW TABLES LIKE 'ipmedicine_issue'";
$checkResult = mysqli_query($GLOBALS["___mysqli_ston"], $checkTable);
if(mysqli_num_rows($checkResult) > 0) {
    $tableExists = true;
    $query2 = "select * from ipmedicine_issue where date(updatedatetime) between '$fromdate' and '$todate' order by updatedatetime desc";
    if($location != '') {
        $query2 = "select * from ipmedicine_issue where locationcode='$location' and date(updatedatetime) between '$fromdate' and '$todate' order by updatedatetime desc";
    }
    $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2);
    if($exec2) {
        $sno = mysqli_num_rows($exec2);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicine Issued List - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/ipmedicineissuedlist-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/datetimepicker_css.js"></script>
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
            <span class="location-info">📍 Location: <?php echo htmlspecialchars($res1location); ?></span>
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
        <span>Medicine Issued List</span>
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
                        <a href="ipdischargelist.php" class="nav-link">
                            <i class="fas fa-list"></i>
                            <span>Discharge List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdischargerequestlist.php" class="nav-link">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Discharge Requests</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdischargelist_tat.php" class="nav-link">
                            <i class="fas fa-clock"></i>
                            <span>Discharge TAT</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdiscountlist.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            <span>% Discount List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdiscountreport.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Discount Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdocs.php" class="nav-link">
                            <i class="fas fa-file-alt"></i>
                            <span>IP Documents</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdrugconsumptionreport.php" class="nav-link">
                            <i class="fas fa-pills"></i>
                            <span>Drug Consumption Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdrugintake.php" class="nav-link">
                            <i class="fas fa-capsules"></i>
                            <span>Drug Intake</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipmedicinestatement.php" class="nav-link">
                            <i class="fas fa-prescription"></i>
                            <span>Medicine Statement</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="inpatientactivity.php" class="nav-link">
                            <i class="fas fa-activity"></i>
                            <span>Inpatient Activity</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipvisitentry_new.php" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>IP Visit Entry</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipcreditaccountreport.php" class="nav-link">
                            <i class="fas fa-credit-card"></i>
                            <span>Credit Account Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="iplabresultsviewlist.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Results View</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipmedicineissuelist.php" class="nav-link active">
                            <i class="fas fa-pills"></i>
                            <span>Medicine Issue List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeinpatientlistmedicine.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Active Inpatient List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ippackageanalysis.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Package Analysis</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addippackage.php" class="nav-link">
                            <i class="fas fa-plus"></i>
                            <span>Add IP Package</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ippackagereport.php" class="nav-link">
                            <i class="fas fa-file-alt"></i>
                            <span>Package Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="packageitems.php" class="nav-link">
                            <i class="fas fa-box"></i>
                            <span>Package Items</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ippackage_upload.php" class="nav-link">
                            <i class="fas fa-upload"></i>
                            <span>Package Upload</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div class="alert-container">
                <?php include ("includes/alertmessages1.php"); ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2><i class="fas fa-pills"></i> Medicine Issued List</h2>
                    <p>View and manage medicine issuance records</p>
                </div>
                <div class="page-header-actions">
                    <button class="btn btn-primary" onclick="exportToExcel()">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </button>
                    <button class="btn btn-primary" onclick="exportToPDF()">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </button>
                    <button class="btn btn-primary" onclick="printList()">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="search-container">
                <form method="post" class="search-form">
                    <div class="search-row">
                        <div class="search-group">
                            <label for="searchInput">Search</label>
                            <input type="text" id="searchInput" class="search-input" placeholder="Search by patient name, medicine, or ID...">
                        </div>
                        
                        <div class="search-group">
                            <label for="fromDate">From Date</label>
                            <input type="text" id="fromDate" name="ADate1" class="search-input" value="<?php echo $fromdate; ?>" readonly>
                        </div>
                        
                        <div class="search-group">
                            <label for="toDate">To Date</label>
                            <input type="text" id="toDate" name="ADate2" class="search-input" value="<?php echo $todate; ?>" readonly>
                        </div>
                        
                        <div class="search-group">
                            <label for="location">Location</label>
                            <select name="location" id="location" class="search-input">
                                <option value="">All Locations</option>
                                <?php
                                $query3 = "select * from master_location where status = '' order by locationname";
                                $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res3 = mysqli_fetch_array($exec3)) {
                                    $locationname = $res3["locationname"];
                                    $locationcode = $res3["locationcode"];
                                    $selected = ($location == $locationcode) ? 'selected' : '';
                                    echo "<option value='$locationcode' $selected>$locationname</option>";
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="search-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Search
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="clearFilters()">
                                <i class="fas fa-times"></i> Clear
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Data Table -->
            <div class="data-table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="selectAll" onchange="selectAll()">
                            </th>
                            <th>Patient Name</th>
                            <th>Medicine Name</th>
                            <th>Quantity</th>
                            <th>Issued Date</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!$tableExists) { ?>
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 3rem;">
                                <div style="color: #64748b; font-size: 1.1rem;">
                                    <i class="fas fa-database" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                                    <h3>Table Not Found</h3>
                                    <p>The 'ipmedicine_issue' table does not exist in the database.</p>
                                    <p>Please contact your administrator to create the required table.</p>
                                </div>
                            </td>
                        </tr>
                        <?php } else if ($exec2 && mysqli_num_rows($exec2) == 0) { ?>
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 3rem;">
                                <div style="color: #64748b; font-size: 1.1rem;">
                                    <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                                    <h3>No Records Found</h3>
                                    <p>No medicine issued records found for the selected date range.</p>
                                </div>
                            </td>
                        </tr>
                        <?php } else if ($exec2) { 
                            $rowCount = 0;
                            while ($res2 = mysqli_fetch_array($exec2)) {
                                $rowCount++;
                                $patientname = $res2["patientname"];
                                $medicinename = $res2["medicinename"];
                                $quantity = $res2["quantity"];
                                $issuedate = $res2["updatedatetime"];
                                $locationname = $res2["locationname"];
                                $status = $res2["status"];
                                $auto_number = $res2["auto_number"];
                                
                                $statusClass = ($status == '') ? 'success' : 'warning';
                                $statusText = ($status == '') ? 'Active' : 'Inactive';
                        ?>
                        <tr>
                            <td>
                                <input type="checkbox" value="<?php echo $auto_number; ?>">
                            </td>
                            <td><?php echo htmlspecialchars($patientname); ?></td>
                            <td><?php echo htmlspecialchars($medicinename); ?></td>
                            <td><?php echo htmlspecialchars($quantity); ?></td>
                            <td><?php echo date('d-m-Y H:i', strtotime($issuedate)); ?></td>
                            <td><?php echo htmlspecialchars($locationname); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo $statusClass; ?>">
                                    <?php echo $statusText; ?>
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-outline" onclick="viewDetails('<?php echo $auto_number; ?>')">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-outline" onclick="editRecord('<?php echo $auto_number; ?>')">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-outline" onclick="deleteRecord('<?php echo $auto_number; ?>')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php 
                            }
                            $sno = $rowCount;
                        } ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination-container">
                <div class="pagination-info">
                    Showing 1 to 10 of <?php echo $sno; ?> entries
                </div>
                <div class="pagination-controls">
                    <button class="pagination-btn" disabled>
                        <i class="fas fa-chevron-left"></i> Previous
                    </button>
                    <button class="pagination-btn active">1</button>
                    <button class="pagination-btn">2</button>
                    <button class="pagination-btn">3</button>
                    <button class="pagination-btn">
                        Next <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>

        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/ipmedicineissuedlist-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
