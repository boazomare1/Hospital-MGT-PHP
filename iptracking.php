<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

$docno = $_SESSION['docno'];

// Get location for sort by location purpose
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
$transactiondatefrom = isset($_REQUEST['ADate1']) ? $_REQUEST['ADate1'] : $transactiondatefrom;
$transactiondateto = isset($_REQUEST['ADate2']) ? $_REQUEST['ADate2'] : $transactiondateto;

if($transactiondatefrom == '') {
    $transactiondatefrom = '2022-01-01'; 
}
if($transactiondateto == '') {
    $transactiondateto = date('Y-m-d');
}

// Check if table exists and get tracking data
$tableExists = false;
$exec2 = null;
$sno = 0;

// Check if table exists
$checkTable = "SHOW TABLES LIKE 'master_ipvisitentry'";
$checkResult = mysqli_query($GLOBALS["___mysqli_ston"], $checkTable);
if(mysqli_num_rows($checkResult) > 0) {
    $tableExists = true;
    $query2 = "select * from master_ipvisitentry where date(recorddatetime) between '$transactiondatefrom' and '$transactiondateto' order by recorddatetime desc";
    if($location != '') {
        $query2 = "select * from master_ipvisitentry where locationcode='$location' and date(recorddatetime) between '$transactiondatefrom' and '$transactiondateto' order by recorddatetime desc";
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
    <title>IP Tracking - MedStar</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/iptracking-modern.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
</head>
<body>
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Advanced Healthcare Management Platform</p>
    </header>
    
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
    
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Home</a>
        <span>→</span>
        <span>IP Tracking</span>
    </nav>
    
    <div id="menuToggle" class="floating-menu-toggle">
        <i class="fas fa-bars"></i>
    </div>
    
    <div class="main-container-with-sidebar">
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
                        <a href="ipdischargelist.php" class="nav-link">
                            <i class="fas fa-user-check"></i>
                            <span>IP Discharge List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdischargerequestlist.php" class="nav-link">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Discharge Requests</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="iptracking.php" class="nav-link active">
                            <i class="fas fa-search-location"></i>
                            <span>IP Tracking</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipunrealizedreport.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Unrealized Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="itemmapmultiple.php" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <span>Item Mapping</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        
        <main class="main-content">
            <div class="alert-container">
                <?php if($errmsg != "") { ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $errmsg; ?>
                </div>
                <?php } ?>
            </div>
            
            <div class="page-header">
                <div class="page-header-content">
                    <h2>📊 IP Tracking</h2>
                    <p>Track and monitor inpatient activities and movements</p>
                </div>
                <div class="page-header-actions">
                    <button class="btn btn-primary" onclick="refreshData()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </button>
                    <button class="btn btn-outline" onclick="printList()">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>
            
            <div class="search-container">
                <form method="post" action="">
                    <div class="search-row">
                        <div class="search-group">
                            <label for="ADate1">From Date</label>
                            <input type="text" id="ADate1" name="ADate1" class="search-input" value="<?php echo $transactiondatefrom; ?>" placeholder="Select from date">
                        </div>
                        <div class="search-group">
                            <label for="ADate2">To Date</label>
                            <input type="text" id="ADate2" name="ADate2" class="search-input" value="<?php echo $transactiondateto; ?>" placeholder="Select to date">
                        </div>
                        <div class="search-group">
                            <label for="location">Location</label>
                            <select name="location" id="location" class="search-input">
                                <option value="">All Locations</option>
                                <?php
                                $query1 = "select * from master_location where status='active' order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
                                while($res1 = mysqli_fetch_array($exec1)) {
                                    $selected = ($location == $res1['locationcode']) ? 'selected' : '';
                                    echo "<option value='{$res1['locationcode']}' $selected>{$res1['locationname']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="search-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="data-table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Patient ID</th>
                            <th>Patient Name</th>
                            <th>Admission Date</th>
                            <th>Location</th>
                            <th>Ward</th>
                            <th>Status</th>
                            <th>Last Updated</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!$tableExists) { ?>
                        <tr>
                            <td colspan="9" style="text-align: center; padding: 3rem;">
                                <div style="color: #64748b; font-size: 1.1rem;">
                                    <i class="fas fa-database" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                                    <h3>Table Not Found</h3>
                                    <p>The 'master_ipvisitentry' table does not exist in the database.</p>
                                    <p>Please contact your administrator to create the required table.</p>
                                </div>
                            </td>
                        </tr>
                        <?php } else if ($exec2 && mysqli_num_rows($exec2) == 0) { ?>
                        <tr>
                            <td colspan="9" style="text-align: center; padding: 3rem;">
                                <div style="color: #64748b; font-size: 1.1rem;">
                                    <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                                    <h3>No Records Found</h3>
                                    <p>No tracking records found for the selected date range.</p>
                                </div>
                            </td>
                        </tr>
                        <?php } else if ($exec2) {
                            $sno = 0;
                            while($res2 = mysqli_fetch_array($exec2)) {
                                $sno++;
                                $patientid = $res2['patientid'];
                                $patientname = $res2['patientname'];
                                $admissiondate = $res2['admissiondate'];
                                $locationcode = $res2['locationcode'];
                                $ward = $res2['ward'];
                                $status = $res2['status'];
                                $recorddatetime = $res2['recorddatetime'];
                                
                                // Get location name
                                $locationname = '';
                                if($locationcode != '') {
                                    $query3 = "select locationname from master_location where locationcode='$locationcode'";
                                    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3);
                                    if($res3 = mysqli_fetch_array($exec3)) {
                                        $locationname = $res3['locationname'];
                                    }
                                }
                        ?>
                        <tr>
                            <td><?php echo $sno; ?></td>
                            <td><?php echo htmlspecialchars($patientid); ?></td>
                            <td><?php echo htmlspecialchars($patientname); ?></td>
                            <td><?php echo date('d-m-Y', strtotime($admissiondate)); ?></td>
                            <td><?php echo htmlspecialchars($locationname); ?></td>
                            <td><?php echo htmlspecialchars($ward); ?></td>
                            <td>
                                <span class="badge badge-<?php echo ($status == 'Active') ? 'success' : 'secondary'; ?>">
                                    <?php echo htmlspecialchars($status); ?>
                                </span>
                            </td>
                            <td><?php echo date('d-m-Y H:i', strtotime($recorddatetime)); ?></td>
                            <td>
                                <button class="btn btn-outline btn-sm" onclick="viewDetails('<?php echo $patientid; ?>')">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-outline btn-sm" onclick="editRecord('<?php echo $patientid; ?>')">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                        <?php 
                            }
                        } ?>
                    </tbody>
                </table>
            </div>
            
            <div class="pagination-container">
                <div class="pagination-info">
                    Showing <?php echo $sno; ?> records
                </div>
                <div class="pagination-controls">
                    <button class="pagination-btn" disabled>
                        <i class="fas fa-chevron-left"></i> Previous
                    </button>
                    <button class="pagination-btn active">1</button>
                    <button class="pagination-btn" disabled>
                        Next <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </main>
    </div>
    
    <script src="js/iptracking-modern.js?v=<?php echo time(); ?>"></script>
    <script>
        $(document).ready(function() {
            $("#ADate1").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: 'c-100:c+10'
            });
            
            $("#ADate2").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: 'c-100:c+10'
            });
        });
    </script>
</body>
</html>
