<?php
session_start();
$pagename = '';

// Security check
if (!isset($_SESSION['username'])) {
    header("location:index.php");
    exit;
}

include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$sessionusername = $_SESSION['username'];
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$errmsg = '';
$bgcolorcode = "";
$colorloopcount = "";

$month = date('M-Y');

// Get company details
$query81 = "select * from master_company where auto_number = '$companyanum'";
$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
$res81 = mysqli_fetch_array($exec81);
$companycode = $res81['companycode'];
$helbnumber = $res81['helbnumber'];
$employername = $res81['employername'];

// Get form parameters
$searchemployee = isset($_REQUEST["searchemployee"]) ? $_REQUEST["searchemployee"] : "";
$searchmonth = isset($_REQUEST["searchmonth"]) ? $_REQUEST["searchmonth"] : date('M');
$searchyear = isset($_REQUEST["searchyear"]) ? $_REQUEST["searchyear"] : date('Y');
$searchcomponent = isset($_REQUEST["searchcomponent"]) ? $_REQUEST["searchcomponent"] : "";
$frmflag1 = isset($_REQUEST["frmflag1"]) ? $_REQUEST["frmflag1"] : "";

// Status messages
$st = isset($_REQUEST["st"]) ? $_REQUEST["st"] : "";
if ($st == 'success') {
    $errmsg = "Report generated successfully.";
    $bgcolorcode = 'success';
} else if ($st == 'failed') {
    $errmsg = "Failed to generate report.";
    $bgcolorcode = 'error';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HELB Report - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/helbreport1-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date picker styles -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- AutoComplete styles -->
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <!-- JavaScript files -->
    <script type="text/javascript" src="js/autosuggestemployeereportsearch1.js"></script>
    <script type="text/javascript" src="js/autocomplete_jobdescription2.js"></script>
    <script type="text/javascript" src="js/disablebackenterkey.js"></script>
    <script src="js/datetimepicker1_css.js"></script>
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
            <span class="location-info">📍 Company: <?php echo htmlspecialchars($employername); ?></span>
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
        <a href="hr.php">👥 HR Management</a>
        <span>→</span>
        <span>HELB Report</span>
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
                        <a href="hr.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>HR Management</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="helbreport1.php" class="nav-link">
                            <i class="fas fa-file-invoice"></i>
                            <span>HELB Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="payroll.php" class="nav-link">
                            <i class="fas fa-calculator"></i>
                            <span>Payroll</span>
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
                    <div class="alert alert-<?php echo $bgcolorcode; ?>">
                        <i class="fas fa-<?php echo $bgcolorcode === 'success' ? 'check-circle' : ($bgcolorcode === 'error' ? 'exclamation-triangle' : 'info-circle'); ?> alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>HELB Report</h2>
                    <p>Generate monthly payroll return to Higher Education Loans Board (HELB).</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <a href="hr.php" class="btn btn-outline">
                        <i class="fas fa-users"></i> HR Management
                    </a>
                </div>
            </div>

            <!-- Search Form -->
            <div class="search-section">
                <div class="search-header">
                    <i class="fas fa-search search-icon"></i>
                    <h3 class="search-title">Search HELB Report</h3>
                </div>
                
                <form name="form1" id="form1" method="post" action="helbreport1.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="searchemployee" class="form-label">Search Employee</label>
                            <input type="hidden" name="autobuildemployee" id="autobuildemployee">
                            <input type="hidden" name="searchemployeecode" id="searchemployeecode">
                            <input type="text" name="searchemployee" id="searchemployee" 
                                   class="form-input" autocomplete="off" 
                                   value="<?php echo htmlspecialchars($searchemployee); ?>" 
                                   placeholder="Enter employee name..." />
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="searchmonth" class="form-label">Search Month</label>
                            <select name="searchmonth" id="searchmonth" class="form-select">
                                <?php if($searchmonth != ''): ?>
                                    <option value="<?php echo htmlspecialchars($searchmonth); ?>"><?php echo htmlspecialchars($searchmonth); ?></option>
                                <?php endif; ?>
                                <?php 
                                $arraymonth = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
                                $monthcount = count($arraymonth);
                                for($i=0; $i<$monthcount; $i++):
                                ?>
                                    <option value="<?php echo htmlspecialchars($arraymonth[$i]); ?>"><?php echo htmlspecialchars($arraymonth[$i]); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="searchyear" class="form-label">Search Year</label>
                            <select name="searchyear" id="searchyear" class="form-select">
                                <?php if($searchyear != ''): ?>
                                    <option value="<?php echo htmlspecialchars($searchyear); ?>"><?php echo htmlspecialchars($searchyear); ?></option>
                                <?php endif; ?>
                                <?php for($j=2010; $j<=date('Y'); $j++): ?>
                                    <option value="<?php echo $j; ?>"><?php echo $j; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Generate Report
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Report Results -->
            <?php 
            $totalamount = '0.00';
            if($frmflag1 == 'frmflag1'): 
                $searchmonthyear = $searchmonth.'-'.$searchyear; 
                $url = "frmflag1=$frmflag1&&searchmonth=$searchmonth&&searchyear=$searchyear&&companyanum=$companyanum&&searchemployee=$searchemployee";
            ?>
            <div class="report-section">
                <div class="report-header">
                    <i class="fas fa-file-invoice report-icon"></i>
                    <h3 class="report-title">Monthly Payroll Return to HELB</h3>
                </div>
                
                <!-- Report Information -->
                <div class="report-info">
                    <div class="info-grid">
                        <div class="info-item">
                            <label class="info-label">HELB Report</label>
                            <span class="info-value">Monthly Contribution Report</span>
                        </div>
                        <div class="info-item">
                            <label class="info-label">Employer's HELB Code</label>
                            <span class="info-value"><?php echo htmlspecialchars($helbnumber); ?></span>
                        </div>
                        <div class="info-item">
                            <label class="info-label">Employer's Name</label>
                            <span class="info-value"><?php echo htmlspecialchars($employername); ?></span>
                        </div>
                        <div class="info-item">
                            <label class="info-label">Month of Contribution</label>
                            <span class="info-value"><?php echo htmlspecialchars($searchyear.'-'.date('m', strtotime($searchmonth))); ?></span>
                        </div>
                    </div>
                </div>
                
                <!-- Report Table -->
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID NO</th>
                                <th>NAME</th>
                                <th>PAYROLL NO</th>
                                <th>AMOUNT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $totalamount = '0.00';
                            $query2 = "select a.employeecode as employeecode, a.employeename as employeename from details_employeepayroll a where a.employeename like '%$searchemployee%' and a.paymonth = '$searchmonthyear' and a.status <> 'deleted' group by a.employeecode";
                            $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            while($res2 = mysqli_fetch_array($exec2)):
                                $res2employeecode = $res2['employeecode'];
                                $res2employeename = $res2['employeename'];

                                $name = trim(preg_replace('/[^A-Za-z0-9 ]/', '', $res2employeename));
                                $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
                                $first_name = trim(preg_replace('#'.$last_name.'#', '', $name));

                                $query778 = mysqli_query($GLOBALS["___mysqli_ston"], "select employeecode from master_employee where employeecode = '$res2employeecode' and (payrollstatus = 'Active' or payrollstatus = 'Prorata')") or die ("Error in Query778".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $row778 = mysqli_num_rows($query778);
                                
                                if($row778 > 0):
                                    $query6 = "select * from master_employeeinfo where employeecode = '$res2employeecode'";
                                    $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res6 = mysqli_fetch_array($exec6);
                                    $passportnumber = $res6['passportnumber'];
                                    $payrollno = $res6['payrollno'];
                                    
                                    $colorloopcount = $colorloopcount + 1;
                                    $showcolor = ($colorloopcount & 1);
                                    $colorcode = ($showcolor == 0) ? 'even-row' : 'odd-row';
                                    
                                    $query1 = "select * from master_payrollcomponent where recordstatus <> 'deleted' and auto_number = '5' order by typecode, auto_number";
                                    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    
                                    while($res1 = mysqli_fetch_array($exec1)):
                                        $componentanum = $res1['auto_number'];
                                        $query3 = "select `$componentanum` as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
                                        $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        $res3 = mysqli_fetch_array($exec3);
                                        $componentamount = $res3['componentamount'];
                                        
                                        if($componentamount == 0) continue;
                                        $totalamount = $totalamount + $componentamount;
                            ?>
                            <tr class="<?php echo $colorcode; ?>">
                                <td class="id-cell"><?php echo htmlspecialchars($passportnumber); ?></td>
                                <td class="name-cell"><?php echo htmlspecialchars($first_name.' '.$last_name); ?></td>
                                <td class="payroll-cell"><?php echo htmlspecialchars($payrollno); ?></td>
                                <td class="amount-cell"><?php echo number_format($componentamount, 3); ?></td>
                            </tr>
                            <?php 
                                    endwhile;
                                endif;
                            endwhile;
                            ?>
                        </tbody>
                        <tfoot>
                            <tr class="total-row">
                                <td colspan="3" class="total-label">Total:</td>
                                <td class="total-amount"><?php echo number_format($totalamount, 3, '.', ','); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Export Actions -->
                <div class="export-actions">
                    <h4>Export Options</h4>
                    <div class="export-buttons">
                        <a href="print_helbreport1.php?<?php echo htmlspecialchars($url); ?>" class="btn btn-outline" target="_blank">
                            <i class="fas fa-file-pdf"></i> PDF Report
                        </a>
                        <a href="print_helbreportxl.php?<?php echo htmlspecialchars($url); ?>" class="btn btn-outline" target="_blank">
                            <i class="fas fa-file-excel"></i> Excel Report
                        </a>
                        <a href="print_helbreportcsv1.php?<?php echo htmlspecialchars($url); ?>" class="btn btn-outline" target="_blank">
                            <i class="fas fa-file-csv"></i> CSV File
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/helbreport1-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
