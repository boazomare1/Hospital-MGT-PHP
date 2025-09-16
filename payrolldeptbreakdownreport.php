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

$pagename = '';

// Get default location
$query = "select * from master_company where auto_number = '$companyanum'";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);

$companycode = $res['pinnumber'];
$companyname = $res['employername'];

// Handle form submission
if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchbank"])) { $searchbank = $_REQUEST["searchbank"]; } else { $searchbank = ""; }
if (isset($_REQUEST["searchdept"])) { $searchdept = $_REQUEST["searchdept"]; } else { $searchdept = ""; }
if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1') {
    $searchmonthyear = $searchmonth.'-'.$searchyear; 
    $url = "frmflag1=$frmflag1&&searchmonth=$searchmonth&&searchyear=$searchyear&&searchemployee=$searchemployee&&searchdept=$searchdept";
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
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
    <title>Payroll Department Breakdown Report - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/payrolldeptbreakdownreport-modern.css">
    
    <!-- Existing Scripts -->
    <link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 
    <script type="text/javascript" src="js/autosuggestemployeereportsearch1.js"></script>
    <script type="text/javascript" src="js/autocomplete_jobdescription2.js"></script>
    <script type="text/javascript" src="js/disablebackenterkey.js"></script>
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
            <span class="location-info">Company: <?php echo htmlspecialchars($companyname); ?></span>
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
        <span>Payroll Department Breakdown Report</span>
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
                        <a href="payrolldeptbreakdownreport.php" class="nav-link">
                            <i class="fas fa-chart-pie"></i>
                            Payroll Department Breakdown
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="payrolldeptreport1.php" class="nav-link">
                            <i class="fas fa-money-bill-wave"></i>
                            Payroll Department Report
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
                    <h2>Payroll Department Breakdown Report</h2>
                    <p>Detailed breakdown of payroll components by department</p>
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
                <form name="form1" id="form1" method="post" action="payrolldeptbreakdownreport.php" onSubmit="return from1submit1()" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="searchemployee" class="form-label">Search Employee</label>
                            <input type="hidden" name="autobuildemployee" id="autobuildemployee">
                            <input type="hidden" name="searchemployeecode" id="searchemployeecode">
                            <input type="text" name="searchemployee" id="searchemployee" class="form-control" autocomplete="off" value="<?php echo $searchemployee; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="searchdept" class="form-label">Select Department</label>
                            <select name="searchdept" id="searchdept" class="form-control">
                                <?php if($searchdept != '') { ?>
                                    <option value="<?php echo $searchdept; ?>"><?php echo $searchdept; ?></option>
                                <?php } ?>
                                <option value="">ALL</option>
                                <?php
                                $query5 = "select department from master_payrolldepartment where recordstatus <> 'deleted' group by department order by department";
                                $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($res5 = mysqli_fetch_array($exec5)) {
                                    $departmentname = $res5['department'];
                                ?>
                                    <option value="<?php echo $departmentname; ?>"><?php echo $departmentname; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="searchmonth" class="form-label">Search Month</label>
                            <select name="searchmonth" id="searchmonth" class="form-control">
                                <?php if($searchmonth != '') { ?>
                                    <option value="<?php echo $searchmonth; ?>"><?php echo $searchmonth; ?></option>
                                <?php } ?>
                                <?php
                                $arraymonth = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
                                $monthcount = count($arraymonth);
                                for($i=0;$i<$monthcount;$i++) {
                                ?>
                                    <option value="<?php echo $arraymonth[$i]; ?>"><?php echo $arraymonth[$i]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="searchyear" class="form-label">Search Year</label>
                            <select name="searchyear" id="searchyear" class="form-control">
                                <?php if($searchyear != '') { ?>
                                    <option value="<?php echo $searchyear; ?>"><?php echo $searchyear; ?></option>
                                <?php } ?>
                                <?php
                                for($j=2010;$j<=date('Y');$j++) {
                                ?>
                                    <option value="<?php echo $j; ?>"><?php echo $j; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1">
                        <button type="submit" name="Search" class="btn btn-primary">
                            <i class="fas fa-search"></i> Submit
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
                    <h3 style="margin: 0; color: var(--medstar-primary);">Department Breakdown Report</h3>
                    <p style="margin: 0.5rem 0 0 0; color: var(--text-secondary);">
                        <strong>EMPLOYER'S PIN:</strong> <?php echo $companycode; ?> | 
                        <strong>EMPLOYER'S NAME:</strong> <?php echo $companyname; ?> | 
                        <strong>MONTH OF CONTRIBUTION:</strong> <?php echo $searchmonthyear; ?>
                    </p>
                </div>
                
                <?php
                $totalamount = '0.00';
                $query9 = "select departmentname from master_employee where departmentname like '%$searchdept%' group by departmentname order by employeecode";
                $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($res9 = mysqli_fetch_array($exec9)) {
                    $departmentname = $res9['departmentname'];
                ?>
                    <div style="margin-bottom: 2rem;">
                        <h4 style="color: var(--medstar-primary); margin-bottom: 1rem; padding: 1rem; background: var(--background-accent); border-radius: var(--border-radius-small);">
                            <?php echo $departmentname; ?>
                        </h4>
                        
                        <?php
                        $query2 = "select a.employeecode as employeecode, a.employeename as employeename from details_employeepayroll a JOIN master_employee b ON (a.employeecode = b.employeecode) where a.employeename like '%$searchemployee%' and a.paymonth = '$searchmonthyear' and b.departmentname = '$departmentname' and a.status <> 'deleted' and (b.payrollstatus = 'Active' or b.payrollstatus = 'Prorata') group by a.employeecode";
                        $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($res2 = mysqli_fetch_array($exec2)) {
                            $res2employeecode = $res2['employeecode'];
                            $res2employeename = $res2['employeename'];
                            
                            if($departmentname != '') { 
                                $colorloopcount = $colorloopcount + 1;
                        ?>
                            <div style="margin-bottom: 1.5rem; border: 1px solid var(--border-color); border-radius: var(--border-radius); overflow: hidden;">
                                <div style="background: var(--medstar-primary); color: white; padding: 1rem;">
                                    <h5 style="margin: 0;"><?php echo $res2employeename; ?> (<?php echo $res2employeecode; ?>)</h5>
                                </div>
                                
                                <table class="modern-table">
                                    <thead>
                                        <tr>
                                            <th>Component Description</th>
                                            <th>Monthly Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $totaldeduct = 0;
                                        $totalgrossper = 0;
                                        $query12 = "select auto_number as ganum, typecode, componentname from master_payrollcomponent where recordstatus <> 'deleted'";
                                        $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        while($res12 = mysqli_fetch_array($exec12)) {
                                            $ganum = $res12['ganum']; 
                                            $typecode = $res12['typecode'];
                                            $componentname = $res12['componentname'];
                                            
                                            $querygg = "select `$ganum` as res12value from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
                                            $execgg = mysqli_query($GLOBALS["___mysqli_ston"], $querygg) or die ("Error in Querygg".mysqli_error($GLOBALS["___mysqli_ston"]));
                                            $resgg = mysqli_fetch_array($execgg);
                                            $res12value = $resgg['res12value'];
                                            
                                            if($res12value > 0) {
                                                if($typecode == 10){
                                                    $totalgrossper = $totalgrossper + $res12value; 
                                                } else { 
                                                    $totaldeduct = $totaldeduct + $res12value; 
                                                }
                                        ?>
                                            <tr>
                                                <td><?php echo $componentname; ?></td>
                                                <td><?php echo number_format($res12value,2,'.',','); ?></td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                        $nettpay = $totalgrossper - $totaldeduct;
                                        $totalamount = $totalamount + $nettpay;
                                        ?>
                                        <tr style="background: var(--background-accent); font-weight: bold;">
                                            <td>Net Pay</td>
                                            <td><?php echo number_format($nettpay,2,'.',','); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                <?php } ?>
                
                <div style="background: var(--medstar-primary); color: white; padding: 1.5rem; border-radius: var(--border-radius); margin-top: 2rem;">
                    <h3 style="margin: 0; text-align: center;">
                        Total Department Payroll: <?php echo number_format($totalamount,2,'.',','); ?>
                    </h3>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

    <!-- Existing JavaScript -->
    <script language="javascript">
    function process1backkeypress1() {
        if (event.keyCode==8) {
            event.keyCode=0; 
            return event.keyCode 
            return false;
        }
    }

    window.onload = function () {
        var oTextbox = new AutoSuggestControl(document.getElementById("searchemployee"), new StateSuggestions());
    }
    </script>

    <!-- Modern JavaScript -->
    <script src="js/payrolldeptbreakdownreport-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>