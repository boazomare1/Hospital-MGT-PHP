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

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }

$docno = $_SESSION['docno'];

$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);

$locationname = $res["locationname"];
$locationcode = $res["locationcode"];

// Handle form submission
if (isset($_REQUEST["transactiondatefrom"])) { $transactiondatefrom = $_REQUEST["transactiondatefrom"]; } else { $transactiondatefrom = date('Y-m-d', strtotime('-1 month')); }
if (isset($_REQUEST["transactiondateto"])) { $transactiondateto = $_REQUEST["transactiondateto"]; } else { $transactiondateto = date('Y-m-d'); }
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1') {
    $url = "frmflag1=$frmflag1&&transactiondatefrom=$transactiondatefrom&&transactiondateto=$transactiondateto";
}

if ($st == 'success') {
    $errmsg = "";
} else if ($st == 'failed') {
    $errmsg = "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>External Referral List - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/extreferrallist-modern.css">
    
    <!-- Existing Scripts -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
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
            <span class="welcome-text">Welcome, <?php echo htmlspecialchars($username); ?></span>
            <span class="location-info">Location: <?php echo htmlspecialchars($locationname); ?></span>
        </div>
        <div class="user-actions">
            <a href="logout.php" class="btn btn-outline btn-sm">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>

    <!-- Navigation Breadcrumb -->
    <nav class="nav-breadcrumb">
        <a href="index.php">🏠 Home</a>
        <span>→</span>
        <span>External Referral List</span>
    </nav>

    <!-- Floating Menu Toggle -->
    <div class="floating-menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
    </div>

    <!-- Main Container with Sidebar -->
    <div class="main-container-with-sidebar">
        <!-- Left Sidebar -->
        <div class="left-sidebar" id="leftSidebar">
            <div class="sidebar-header">
                <h3>Navigation</h3>
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            <nav class="sidebar-nav">
                <ul class="nav-list">
                    <li class="nav-item active">
                        <a href="extreferrallist.php" class="nav-link">
                            <i class="fas fa-external-link-alt"></i>
                            External Referral List
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php" class="nav-link">
                            <i class="fas fa-home"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="reports.php" class="nav-link">
                            <i class="fas fa-file-alt"></i>
                            Reports
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="referrals.php" class="nav-link">
                            <i class="fas fa-user-md"></i>
                            Referrals
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer">
                <?php include ("includes/alertmessages1.php"); ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>External Referral List</h2>
                    <p>View and manage external referral records</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-outline" onclick="printReport()">
                        <i class="fas fa-print"></i> Print
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-file-excel"></i> Export
                    </button>
                    <button type="button" class="btn btn-outline" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                </div>
            </div>

            <!-- Search Form Container -->
            <div class="search-form-container">
                <form name="cbform1" method="post" action="extreferrallist.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="transactiondatefrom" class="form-label">Date From</label>
                            <input type="date" name="transactiondatefrom" id="transactiondatefrom" class="form-control" value="<?php echo $transactiondatefrom; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="transactiondateto" class="form-label">Date To</label>
                            <input type="date" name="transactiondateto" id="transactiondateto" class="form-control" value="<?php echo $transactiondateto; ?>">
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1">
                        <button type="submit" name="Search" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="reset" class="btn btn-outline" onclick="clearForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <?php if($frmflag1 == 'frmflag1') { ?>
            <!-- Data Table Container -->
            <div class="data-table-container">
                <div style="padding: 1rem; background: var(--background-accent); border-bottom: 1px solid var(--border-color);">
                    <h3 style="margin: 0; color: var(--medstar-primary);">External Referral Records</h3>
                    <p style="margin: 0.5rem 0 0 0; color: var(--text-secondary);">
                        <strong>Location:</strong> <?php echo $locationname; ?> | 
                        <strong>Date Range:</strong> <?php echo $transactiondatefrom; ?> to <?php echo $transactiondateto; ?>
                    </p>
                </div>
                
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Referral Date</th>
                            <th>Patient Name</th>
                            <th>Referral Type</th>
                            <th>External Doctor</th>
                            <th>Hospital/Clinic</th>
                            <th>Status</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $colorloopcount = 0;
                        $totalamount = 0;
                        
                        $query1 = "select * from details_externalreferral where locationcode = '$locationcode' and transactiondate >= '$transactiondatefrom' and transactiondate <= '$transactiondateto' and status <> 'deleted' order by transactiondate desc";
                        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                        
                        while($res1 = mysqli_fetch_array($exec1)) {
                            $colorloopcount = $colorloopcount + 1;
                            $showcolor = ($colorloopcount & 1); 
                            
                            if ($showcolor == 0) {
                                $colorcode = 'bgcolor="#CBDBFA"';
                            } else {
                                $colorcode = 'bgcolor="#ecf0f5"';
                            }
                            
                            $referralautonumber = $res1['auto_number'];
                            $transactiondate = $res1['transactiondate'];
                            $patientname = $res1['patientname'];
                            $referraltype = $res1['referraltype'];
                            $externaldoctor = $res1['externaldoctor'];
                            $hospitalclinic = $res1['hospitalclinic'];
                            $status = $res1['status'];
                            $amount = $res1['amount'];
                            
                            $totalamount = $totalamount + $amount;
                        ?>
                            <tr>
                                <td><?php echo $colorloopcount; ?></td>
                                <td><?php echo date('d-M-Y', strtotime($transactiondate)); ?></td>
                                <td><?php echo htmlspecialchars($patientname); ?></td>
                                <td><?php echo htmlspecialchars($referraltype); ?></td>
                                <td><?php echo htmlspecialchars($externaldoctor); ?></td>
                                <td><?php echo htmlspecialchars($hospitalclinic); ?></td>
                                <td>
                                    <span class="status-badge <?php echo strtolower($status); ?>">
                                        <?php echo htmlspecialchars($status); ?>
                                    </span>
                                </td>
                                <td><?php echo number_format($amount, 2, '.', ','); ?></td>
                            </tr>
                        <?php } ?>
                        
                        <?php if($colorloopcount == 0) { ?>
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 2rem; color: var(--text-secondary);">
                                    <i class="fas fa-info-circle" style="font-size: 2rem; margin-bottom: 1rem; display: block;"></i>
                                    No external referral records found for the selected date range.
                                </td>
                            </tr>
                        <?php } else { ?>
                            <tr style="background: var(--medstar-primary); color: white; font-weight: bold;">
                                <td colspan="7"><strong>Total:</strong></td>
                                <td><strong><?php echo number_format($totalamount, 2, '.', ','); ?></strong></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php } ?>
        </div>
    </div>

    <!-- Existing JavaScript -->
    <script language="javascript">
    function cbcustomername1() {
        // Existing function logic
    }
    </script>

    <!-- Modern JavaScript -->
    <script src="js/extreferrallist-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>