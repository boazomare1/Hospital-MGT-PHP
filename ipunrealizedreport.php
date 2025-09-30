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
$colorloopcount = 0;

$locationcode1 = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';

$transactiondatefrom = isset($_REQUEST['ADate1']) ? $_REQUEST['ADate1'] : '';
$transactiondateto = isset($_REQUEST['ADate2']) ? $_REQUEST['ADate2'] : '';
$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';

if($transactiondatefrom == '') {
    $transactiondatefrom = '2022-01-01'; 
}
if($transactiondateto == '') {
    $transactiondateto = date('Y-m-d');
}

// Check if table exists and get unrealized report data
$tableExists = false;
$exec2 = null;
$sno = 0;
$totalAmount = 0;
$totalUnrealized = 0;

// Check if table exists
$checkTable = "SHOW TABLES LIKE 'billing_ip'";
$checkResult = mysqli_query($GLOBALS["___mysqli_ston"], $checkTable);
if(mysqli_num_rows($checkResult) > 0) {
    $tableExists = true;
    $query2 = "select * from billing_ip where date(recorddatetime) between '$transactiondatefrom' and '$transactiondateto' order by recorddatetime desc";
    if($location != '') {
        $query2 = "select * from billing_ip where locationcode='$location' and date(recorddatetime) between '$transactiondatefrom' and '$transactiondateto' order by recorddatetime desc";
    }
    if($type != '') {
        $query2 .= " and servicetype='$type'";
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
    <title>IP Unrealized Report - MedStar</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/ipunrealizedreport-modern.css?v=<?php echo time(); ?>">
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
        <span>IP Unrealized Report</span>
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
                        <a href="iptracking.php" class="nav-link">
                            <i class="fas fa-search-location"></i>
                            <span>IP Tracking</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipunrealizedreport.php" class="nav-link active">
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
                <!-- Alert messages will be displayed here -->
            </div>
            
            <div class="page-header">
                <div class="page-header-content">
                    <h2>📈 IP Unrealized Report</h2>
                    <p>Track unrealized revenue and pending collections</p>
                </div>
                <div class="page-header-actions">
                    <button class="btn btn-primary" onclick="refreshData()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </button>
                    <button class="btn btn-outline" onclick="exportToPDF()">
                        <i class="fas fa-file-pdf"></i> Export PDF
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
                            <label for="type">Type</label>
                            <select name="type" id="type" class="search-input">
                                <option value="">All Types</option>
                                <option value="Medicine" <?php echo ($type == 'Medicine') ? 'selected' : ''; ?>>Medicine</option>
                                <option value="Service" <?php echo ($type == 'Service') ? 'selected' : ''; ?>>Service</option>
                                <option value="Lab" <?php echo ($type == 'Lab') ? 'selected' : ''; ?>>Lab</option>
                                <option value="Radiology" <?php echo ($type == 'Radiology') ? 'selected' : ''; ?>>Radiology</option>
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
            
            <?php if ($tableExists && $exec2 && mysqli_num_rows($exec2) > 0) { ?>
            <div class="form-container">
                <div class="form-header">
                    <h3><i class="fas fa-chart-bar"></i> Summary</h3>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Total Records</label>
                        <div class="form-control" style="background: #f8fafc; font-weight: 600; color: #1e40af;">
                            <?php echo $sno; ?> Records
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Total Amount</label>
                        <div class="form-control" style="background: #f8fafc; font-weight: 600; color: #059669;">
                            ₹ <?php echo number_format($totalAmount, 2); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Unrealized Amount</label>
                        <div class="form-control" style="background: #f8fafc; font-weight: 600; color: #dc2626;">
                            ₹ <?php echo number_format($totalUnrealized, 2); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            
            <div class="data-table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Patient ID</th>
                            <th>Patient Name</th>
                            <th>Service Type</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Unrealized</th>
                            <th>Location</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!$tableExists) { ?>
                        <tr>
                            <td colspan="10" style="text-align: center; padding: 3rem;">
                                <div style="color: #64748b; font-size: 1.1rem;">
                                    <i class="fas fa-database" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                                    <h3>Table Not Found</h3>
                                    <p>The 'billing_ip' table does not exist in the database.</p>
                                    <p>Please contact your administrator to create the required table.</p>
                                </div>
                            </td>
                        </tr>
                        <?php } else if ($exec2 && mysqli_num_rows($exec2) == 0) { ?>
                        <tr>
                            <td colspan="10" style="text-align: center; padding: 3rem;">
                                <div style="color: #64748b; font-size: 1.1rem;">
                                    <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                                    <h3>No Records Found</h3>
                                    <p>No unrealized records found for the selected criteria.</p>
                                </div>
                            </td>
                        </tr>
                        <?php } else if ($exec2) {
                            $sno = 0;
                            while($res2 = mysqli_fetch_array($exec2)) {
                                $sno++;
                                $patientid = $res2['patientid'];
                                $patientname = $res2['patientname'];
                                $servicetype = $res2['servicetype'];
                                $description = $res2['description'];
                                $amount = $res2['amount'];
                                $unrealized = $res2['unrealized'];
                                $locationcode = $res2['locationcode'];
                                $recorddatetime = $res2['recorddatetime'];
                                
                                $totalAmount += $amount;
                                $totalUnrealized += $unrealized;
                                
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
                            <td>
                                <span class="badge badge-<?php echo ($servicetype == 'Medicine') ? 'success' : (($servicetype == 'Service') ? 'primary' : 'secondary'); ?>">
                                    <?php echo htmlspecialchars($servicetype); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($description); ?></td>
                            <td style="font-weight: 600; color: #059669;">₹ <?php echo number_format($amount, 2); ?></td>
                            <td style="font-weight: 600; color: #dc2626;">₹ <?php echo number_format($unrealized, 2); ?></td>
                            <td><?php echo htmlspecialchars($locationname); ?></td>
                            <td><?php echo date('d-m-Y', strtotime($recorddatetime)); ?></td>
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
    
    <script src="js/ipunrealizedreport-modern.js?v=<?php echo time(); ?>"></script>
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
