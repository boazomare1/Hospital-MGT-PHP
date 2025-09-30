<?php
session_start();
include("includes/loginverify.php");
include("db/db_connect.php");
include ("includes/check_user_access.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
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

$query1 = "select employeecode from master_employee where status = 'Active' AND username like '%$username%'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query11" . mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1employeename = $res1["employeecode"];

if (isset($_REQUEST["cbfrmflag1"])) {
    $cbfrmflag1 = $_REQUEST["cbfrmflag1"];
} else {
    $cbfrmflag1 = "";
}

$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
if (isset($_REQUEST["canum"])) {
    $getcanum = $_REQUEST["canum"];
} else {
    $getcanum = "";
}
if (isset($_REQUEST["ward"])) {
    $ward12 = $_REQUEST["ward"];
} else {
    $ward12 = "";
}

if ($getcanum != '') {
    $query4 = "select * from master_supplier where auto_number = '$getcanum' and locationcode='$locationcode' ";
    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die("Error in Query4" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $res4 = mysqli_fetch_array($exec4);
    $cbsuppliername = $res4['suppliername'];
    $suppliername = $res4['suppliername'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inpatient Activity - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/inpatientactivity-modern.css?v=<?php echo time(); ?>">
    
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
        <span>Inpatient Activity</span>
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
                        <a href="inpatientactivity.php" class="nav-link active">
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
                    <h2><i class="fas fa-activity"></i> Inpatient Activity</h2>
                    <p>Track and monitor inpatient activities and patient care</p>
                </div>
                <div class="page-header-actions">
                    <button class="btn btn-primary" onclick="window.print()">
                        <i class="fas fa-print"></i> Print Report
                    </button>
                </div>
            </div>

            <!-- Search Form -->
            <div class="search-form-container">
                <form name="cbform1" method="post" action="inpatientactivity.php" class="search-form">
                    <div class="form-header">
                        <h3><i class="fas fa-search"></i> Search Parameters</h3>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ward">Ward</label>
                            <select name="ward" id="ward" class="form-control">
                                <option value="">Select Ward</option>
                                <?php
                                $query1 = "select * from master_ward where status <> 'deleted' order by wardname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $wardname = $res1["wardname"];
                                    $wardanum = $res1["auto_number"];
                                    if ($ward12 == $wardanum) {
                                        echo "<option value='$wardanum' selected>$wardname</option>";
                                    } else {
                                        echo "<option value='$wardanum'>$wardname</option>";
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
                            <i class="fas fa-search"></i> Search Activity
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Activity Cards -->
            <div class="activity-cards" id="activityContainer">
                <div class="activity-card">
                    <h4><i class="fas fa-user-plus"></i> New Admissions</h4>
                    <p>Track new patient admissions and registration</p>
                </div>
                
                <div class="activity-card">
                    <h4><i class="fas fa-user-minus"></i> Discharges</h4>
                    <p>Monitor patient discharges and discharge planning</p>
                </div>
                
                <div class="activity-card">
                    <h4><i class="fas fa-pills"></i> Medication</h4>
                    <p>Track medication administration and drug interactions</p>
                </div>
                
                <div class="activity-card">
                    <h4><i class="fas fa-stethoscope"></i> Procedures</h4>
                    <p>Monitor medical procedures and treatments</p>
                </div>
                
                <div class="activity-card">
                    <h4><i class="fas fa-user-md"></i> Consultations</h4>
                    <p>Track doctor consultations and specialist visits</p>
                </div>
                
                <div class="activity-card">
                    <h4><i class="fas fa-flask"></i> Lab Tests</h4>
                    <p>Monitor laboratory tests and results</p>
                </div>
            </div>

            <!-- Activity Results -->
            <?php if ($cbfrmflag1 == 'cbfrmflag1') { ?>
            <div class="data-table-section">
                <div class="data-table-header">
                    <h3><i class="fas fa-table"></i> Activity Results</h3>
                </div>
                
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Patient Name</th>
                                <th>Activity Type</th>
                                <th>Description</th>
                                <th>Date/Time</th>
                                <th>Staff</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 2rem;">
                                    <i class="fas fa-search" style="font-size: 2rem; color: #ccc; margin-bottom: 1rem;"></i>
                                    <p>Search for activity records using the form above</p>
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
    <script src="js/inpatientactivity-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
