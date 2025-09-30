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
$transactiondatefrom = "2014-01-01";
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

$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Package Analysis - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/ippackageanalysis-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    
    <!-- Autocomplete -->
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js" type="text/javascript"></script>
    <link href="js/jquery-ui.css" rel="stylesheet">
    <script type="text/javascript" src="js/jquery-1.11.1.js"></script>
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
        <span>IP Package Analysis</span>
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
                        <a href="ipmedicineissuelist.php" class="nav-link">
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
                        <a href="ippackageanalysis.php" class="nav-link active">
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
                    <h2><i class="fas fa-chart-line"></i> IP Package Analysis</h2>
                    <p>Analyze and compare inpatient package performance and profitability</p>
                </div>
                <div class="page-header-actions">
                    <button class="btn btn-primary" onclick="generateAnalysisReport()">
                        <i class="fas fa-download"></i> Export Analysis
                    </button>
                    <button class="btn btn-primary" onclick="window.print()">
                        <i class="fas fa-print"></i> Print Report
                    </button>
                </div>
            </div>

            <!-- Search Form -->
            <div class="search-form-container">
                <form name="cbform1" method="post" action="ippackageanalysis.php" class="search-form">
                    <div class="form-header">
                        <h3><i class="fas fa-search"></i> Analysis Parameters</h3>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location">Location</label>
                            <select name="location" id="location" class="form-control">
                                <option value="">Select Location</option>
                                <?php
                                $query1 = "select * from master_location where status = '' order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $locationname = $res1["locationname"];
                                    $locationcode = $res1["locationcode"];
                                    if ($location == $locationcode) {
                                        echo "<option value='$locationcode' selected>$locationname</option>";
                                    } else {
                                        echo "<option value='$locationcode'>$locationname</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate1">Date From</label>
                            <input type="text" name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>" class="form-control date-picker" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2">Date To</label>
                            <input type="text" name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>" class="form-control date-picker" readonly>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Analyze Packages
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Package Analysis Cards -->
            <div class="package-analysis-cards">
                <div class="package-analysis-card">
                    <h4><i class="fas fa-chart-bar"></i> Revenue Analysis</h4>
                    <p>Analyze package revenue and profitability trends</p>
                </div>
                
                <div class="package-analysis-card">
                    <h4><i class="fas fa-users"></i> Patient Volume</h4>
                    <p>Track patient volume and package utilization rates</p>
                </div>
                
                <div class="package-analysis-card">
                    <h4><i class="fas fa-clock"></i> Performance Metrics</h4>
                    <p>Monitor package performance and efficiency metrics</p>
                </div>
                
                <div class="package-analysis-card">
                    <h4><i class="fas fa-balance-scale"></i> Cost Analysis</h4>
                    <p>Analyze package costs and profit margins</p>
                </div>
            </div>

            <!-- Analysis Charts -->
            <div class="analysis-charts">
                <div class="chart-container">
                    <h3>Package Revenue Trends</h3>
                    <div id="revenueChart" style="height: 300px; background: #f8f9fa; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #6c757d;">
                        <i class="fas fa-chart-area" style="font-size: 3rem;"></i>
                    </div>
                </div>
                
                <div class="chart-container">
                    <h3>Package Utilization</h3>
                    <div id="utilizationChart" style="height: 300px; background: #f8f9fa; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #6c757d;">
                        <i class="fas fa-chart-pie" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>

            <!-- Analysis Results -->
            <?php if ($cbfrmflag1 == 'cbfrmflag1') { ?>
            <div class="data-table-section">
                <div class="data-table-header">
                    <h3><i class="fas fa-table"></i> Package Analysis Results</h3>
                </div>
                
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Package Name</th>
                                <th>Revenue</th>
                                <th>Patients</th>
                                <th>Avg. Stay</th>
                                <th>Profit Margin</th>
                                <th>Utilization</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 2rem;">
                                    <i class="fas fa-search" style="font-size: 2rem; color: #ccc; margin-bottom: 1rem;"></i>
                                    <p>Search for package analysis data using the form above</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php } ?>

        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/ippackageanalysis-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
