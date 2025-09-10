<?php
session_start();
include ("db/db_connect.php");
include ("includes/loginverify.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$registrationdate = date('Y-m-d');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$docno = $_SESSION['docno'];
$todaydate = isset($_REQUEST['ADate1']) ? $_REQUEST['ADate1'] : date("Y-m-d");
$time = strtotime($todaydate);
$month = date("m", $time);
$year = date("Y", $time);
$date = date('Y-m-d');
$cbfrmflag1 = isset($_REQUEST['cbfrmflag1']) ? $_REQUEST['cbfrmflag1'] : '';
$storecode1 = isset($_REQUEST['storecode1']) ? $_REQUEST['storecode1'] : '';
$colorloopcount = '';

$curryear = date('Y');
$selectedyear = isset($_REQUEST['year']) ? $_REQUEST['year'] : $curryear;
$sno = 0;

$totaldiffday = '';

$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);

$locationname = $res["locationname"];
$locationcode = $res["locationcode"];
$res12locationanum = $res["auto_number"];

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

if ($ADate1 != '' && $ADate2 != '') {
    $transactiondatefrom = $_REQUEST['ADate1'];
    $transactiondateto = $_REQUEST['ADate2'];
} else {
    $transactiondatefrom = date('Y-m-01');
    $transactiondateto = date('Y-m-t');
}

// Get location details
$locationdetails = "select locationcode, locationname from login_locationdetails where username='$username' and docno='$docno'";
$exeloc = mysqli_query($GLOBALS["___mysqli_ston"], $locationdetails);
$resloc = mysqli_fetch_array($exeloc);
$locationcode = $resloc['locationcode'];
$locationname = $resloc['locationname'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Consumption Report - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/monthlyconsumption-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Legacy CSS for compatibility -->
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
            <span class="location-info">📍 Location: <?php echo htmlspecialchars($locationname); ?></span>
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
        <span>Monthly Consumption Report</span>
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
                        <a href="automaticpi.php" class="nav-link">
                            <i class="fas fa-file-invoice"></i>
                            <span>Purchase Indent</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="monthlyconsumption.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Monthly Consumption</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="balancesheet.php" class="nav-link">
                            <i class="fas fa-balance-scale"></i>
                            <span>Balance Sheet</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addbank1.php" class="nav-link">
                            <i class="fas fa-university"></i>
                            <span>Bank Management</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer">
                <!-- Alerts will be displayed here -->
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Monthly Consumption Report</h2>
                    <p>Track and analyze monthly consumption patterns for inventory management.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-download"></i> Export
                    </button>
                    <button type="button" class="btn btn-primary" onclick="printReport()">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>

            <!-- Search and Filter Section -->
            <div class="search-filter-section">
                <div class="search-filter-header">
                    <i class="fas fa-search search-filter-icon"></i>
                    <h3 class="search-filter-title">Report Parameters</h3>
                </div>
                
                <form method="post" name="form1" action="monthlyconsumption.php" class="search-filter-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="storecode1" class="form-label">Store</label>
                            <select name="storecode1" id="storecode1" class="form-input" required>
                                <option value="">Select Store</option>
                                <?php
                                $query1 = "select * from master_store where status <> 'deleted' order by store";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $res1store = $res1["store"];
                                    $res1storecode = $res1["storecode"];
                                    $selected = ($storecode1 == $res1storecode) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $res1storecode; ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($res1store); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <input name="ADate1" id="ADate1" class="form-input" 
                                   value="<?php echo $transactiondatefrom; ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <input name="ADate2" id="ADate2" class="form-input" 
                                   value="<?php echo $transactiondateto; ?>" readonly>
                        </div>
                    </div>

                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Generate Report
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="clearForm()">
                            <i class="fas fa-undo"></i> Clear
                        </button>
                    </div>
                </form>
            </div>

            <!-- Consumption Report Section -->
            <?php if($cbfrmflag1 == 'cbfrmflag1') { ?>
            <div class="consumption-report-section">
                <div class="consumption-report-header">
                    <i class="fas fa-chart-bar consumption-report-icon"></i>
                    <h3 class="consumption-report-title">Consumption Report</h3>
                    <div class="report-summary">
                        <span class="summary-item">
                            <i class="fas fa-calendar"></i>
                            Period: <?php echo date('d/m/Y', strtotime($transactiondatefrom)); ?> - <?php echo date('d/m/Y', strtotime($transactiondateto)); ?>
                        </span>
                        <span class="summary-item">
                            <i class="fas fa-store"></i>
                            Store: <?php echo htmlspecialchars($storecode1); ?>
                        </span>
                    </div>
                </div>

                <div class="table-container">
                    <table class="consumption-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Item Code</th>
                                <th>Item Name</th>
                                <th>Generic Name</th>
                                <th>Batch</th>
                                <th>Total Stock</th>
                                <th>Total Consumption</th>
                                <th>Days</th>
                                <th>Daily Consumption</th>
                                <th>6 Months</th>
                                <th>2 Months</th>
                                <th>3 Months</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Your existing PHP logic for displaying consumption data goes here
                            // This is a placeholder for the actual data display
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="export-section">
                    <a href="monthlycons_xl.php?storecode=<?php echo $storecode1; ?>&location=<?php echo $locationcode; ?>&fromdate=<?php echo $ADate1; ?>&todate=<?php echo $ADate2; ?>" 
                       target="_blank" class="btn btn-outline">
                        <i class="fas fa-file-excel"></i> Export to Excel
                    </a>
                </div>
            </div>
            <?php } ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/monthlyconsumption-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy JavaScript for compatibility -->
    <script language="javascript">
    function disableEnterKey() {
        return false;
    }

    function clearForm() {
        document.getElementById('storecode1').value = '';
        document.getElementById('ADate1').value = '';
        document.getElementById('ADate2').value = '';
    }
    </script>
</body>
</html>      