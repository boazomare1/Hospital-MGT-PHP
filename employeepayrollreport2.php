<?php 
session_start();
$pagename = '';
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION['username'])) header ("location:index.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$sessionusername = $_SESSION['username'];
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$errmsg = '';
$bgcolorcode = "";
$colorloopcount = "";

$month = date('M-Y');

$query81 = "select * from master_company where auto_number = '$companyanum'";
$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
$res81 = mysqli_fetch_array($exec81);
$companycode = $res81['pinnumber'];
$companyname = $res81['employername'];

if (isset($_REQUEST["searchemployee"])) { 
    $searchemployee = $_REQUEST["searchemployee"]; 
} else { 
    $searchemployee = ""; 
}

if (isset($_REQUEST["searchmonth"])) { 
    $searchmonth = $_REQUEST["searchmonth"]; 
} else { 
    $searchmonth = date('M'); 
}

if (isset($_REQUEST["searchyear"])) { 
    $searchyear = $_REQUEST["searchyear"]; 
} else { 
    $searchyear = date('Y'); 
}

if (isset($_REQUEST["frmflag1"])) { 
    $frmflag1 = $_REQUEST["frmflag1"]; 
} else { 
    $frmflag1 = ""; 
}

if ($frmflag1 == 'frmflag1') {
    // Form processing logic here
}

if (isset($_REQUEST["st"])) { 
    $st = $_REQUEST["st"]; 
} else { 
    $st = ""; 
}

if ($st == 'success') {
    $errmsg = "";
} else if ($st == 'failed') {
    $errmsg = "";
}

$totalbenefit = "0.00";
$nettotalbenefit = "0.00";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Payroll Report - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/employeepayrollreport2-modern.css?v=<?php echo time(); ?>">
    
    <!-- Auto-suggest libraries -->
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
        <span>Employee Payroll Report</span>
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
                        <a href="vat.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            <span>VAT Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipamendser_pending.php" class="nav-link">
                            <i class="fas fa-cogs"></i>
                            <span>IP Service Pending</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="analyzerresults.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Results</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="analyzecomparison.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Analyze Comparison</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="employeepayrollreport2.php" class="nav-link">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Payroll Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="amend_pending_lab.php" class="nav-link">
                            <i class="fas fa-microscope"></i>
                            <span>Pending Lab</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="amend_pending_ippharmacy.php" class="nav-link">
                            <i class="fas fa-pills"></i>
                            <span>Pending Pharmacy</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="amend_pending_radiology.php" class="nav-link">
                            <i class="fas fa-x-ray"></i>
                            <span>Pending Radiology</span>
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
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2><i class="fas fa-money-bill-wave"></i> Employee Payroll Report</h2>
                    <p>Generate and view detailed employee payroll reports by year</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button class="btn btn-secondary" onclick="printPage()">
                        <i class="fas fa-print"></i> Print
                    </button>
                    <button class="btn btn-primary" onclick="exportToPDF()">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </button>
                </div>
            </div>

            <!-- Search Form Section -->
            <div class="search-form-section">
                <div class="search-form-header">
                    <i class="search-form-icon fas fa-search"></i>
                    <h3 class="search-form-title">Search Payroll Report</h3>
                </div>
                
                <div class="search-form-content">
                    <form id="searchForm" action="employeepayrollreport2.php" method="post" name="form1" onSubmit="return from1submit1()">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="searchemployee" class="form-label">Search Employee <span style="color: #dc2626;">*</span></label>
                                <div class="autosuggest-container">
                                    <input type="text" name="searchemployee" id="searchemployee" 
                                           value="<?php echo htmlspecialchars($searchemployee); ?>" 
                                           class="form-input" autocomplete="off" 
                                           placeholder="Enter employee name or code..." required>
                                    <input type="hidden" name="autobuildemployee" id="autobuildemployee">
                                    <input type="hidden" name="searchemployeecode" id="searchemployeecode">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="searchyear" class="form-label">Search Year <span style="color: #dc2626;">*</span></label>
                                <select name="searchyear" id="searchyear" class="form-select" required>
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
                            <button type="button" class="btn btn-secondary" onclick="resetForm()">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                            <button type="submit" class="submit-btn">
                                <i class="fas fa-search"></i> Generate Report
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <?php if($frmflag1 == 'frmflag1'): ?>
            <!-- Payroll Report Section -->
            <div class="payroll-report-section">
                <div class="report-header">
                    <h3><i class="fas fa-file-alt"></i> Payroll Employee Report</h3>
                    <div class="report-actions">
                        <a href="print_employeepayrollreportpdf.php?frmflag1=frmflag1&&searchmonth=<?php echo $searchmonth; ?>&&searchyear=<?php echo $searchyear; ?>&&searchemployee=<?php echo urlencode($searchemployee); ?>&&companycode=<?php echo $companycode; ?>" 
                           target="_blank" class="export-btn">
                            <i class="fas fa-file-pdf"></i> PDF
                        </a>
                        <a href="print_employeepayrollreportexl.php?frmflag1=frmflag1&&searchmonth=<?php echo $searchmonth; ?>&&searchyear=<?php echo $searchyear; ?>&&searchemployee=<?php echo urlencode($searchemployee); ?>&&companycode=<?php echo $companycode; ?>" 
                           target="_blank" class="export-btn">
                            <i class="fas fa-file-excel"></i> Excel
                        </a>
                    </div>
                </div>

                <!-- Company Information -->
                <div class="company-info">
                    <div class="company-info-grid">
                        <div class="info-item">
                            <span class="info-label">Employer's PIN</span>
                            <span class="info-value"><?php echo htmlspecialchars($companycode); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Employer's Name</span>
                            <span class="info-value"><?php echo htmlspecialchars($companyname); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Employee's Name</span>
                            <span class="info-value"><?php echo htmlspecialchars($searchemployee); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Report Year</span>
                            <span class="info-value"><?php echo htmlspecialchars($searchyear); ?></span>
                        </div>
                    </div>
                </div>

                <!-- Search Bar -->
                <div style="margin: 1.5rem; display: flex; gap: 1rem; align-items: center;">
                    <input type="text" id="searchInput" class="form-input" 
                           placeholder="Search payroll components..." 
                           style="flex: 1; max-width: 300px;">
                    <button type="button" class="btn btn-secondary" id="clearBtn">
                        <i class="fas fa-times"></i> Clear
                    </button>
                    <span id="searchResults" style="color: var(--text-secondary); font-size: 0.875rem;"></span>
                </div>

                <div class="payroll-table-container">
                    <table class="payroll-table" id="payrollTable">
                        <thead>
                            <tr>
                                <th>ED Description</th>
                                <?php 
                                $arraymonth1 = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
                                $monthcount1 = count($arraymonth1);
                                for($i1=1; $i1<=$monthcount1; $i1++):
                                    if($i1 < 10){
                                        $mno = '0'.$i1;
                                    } else {
                                        $mno = $i1;
                                    }
                                ?>
                                <th>PER <?= $mno; ?></th>
                                <?php endfor; ?>
                                <th>Y-T-D TOT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $query2 = "select employeecode, employeename from payroll_assign where status <> 'deleted' and employeename like '%$searchemployee%' group by employeename ORDER BY employeecode";
                            $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($res2 = mysqli_fetch_array($exec2)):
                                $res2employeecode = $res2['employeecode'];
                                $res2employeename = $res2['employeename'];
                                
                                $query1 = "select * from master_payrollcomponent where recordstatus <> 'deleted' order by typecode, auto_number";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($res1 = mysqli_fetch_array($exec1)):
                                    $componentanum = $res1['auto_number']; 
                                    $componentname = $res1['componentname'];
                                    $typecode = $res1['typecode'];
                                    
                                    $colorloopcount = $colorloopcount + 1;
                                    $showcolor = ($colorloopcount & 1); 
                                    if ($showcolor == 0) {
                                        $colorcode = 'bgcolor="#CBDBFA"';
                                    } else {
                                        $colorcode = 'bgcolor="#ecf0f5"';
                                    }
                            ?>
                            <tr class="component-row">
                                <td <?php echo $colorcode; ?>><?php echo htmlspecialchars($componentname); ?></td>
                                <?php
                                $ytdtot = '0';
                                $arraymonth = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
                                $monthcount = count($arraymonth);
                                for($i=0; $i<$monthcount; $i++):
                                    $searchmonthyear = $arraymonth[$i].'-'.$searchyear;
                                    $totalgrossper = 0;
                                    $totaldeduct = 0;
                                    $query3 = "select `$componentanum` as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
                                    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res3 = mysqli_fetch_array($exec3);
                                    $componentamount = $res3['componentamount'];
                                    if($componentamount > 0) {
                                        $ytdtot = $ytdtot + $componentamount;
                                    }
                                    if($typecode == 10){
                                        $totalgrossper = $totalgrossper + $componentamount; 
                                        $arraymonth1[$i] = $arraymonth1[$i]+$componentamount;
                                    } else { 
                                        $totaldeduct = $totaldeduct + $componentamount;
                                        $arraymonth2[$i] = $arraymonth2[$i]+$componentamount;
                                    }
                                    $res9grosspay = $totalgrossper;
                                ?>
                                <td class="amount-cell" <?php echo $colorcode; ?>>
                                    <?php if($componentamount > 0): ?>
                                        <?php echo number_format($componentamount, 2, '.', ','); ?>
                                    <?php endif; ?>
                                </td>
                                <?php endfor; ?>
                                <td class="amount-cell" <?php echo $colorcode; ?>>
                                    <strong><?= number_format($ytdtot, 2, '.', ','); ?></strong>
                                </td>
                            </tr>
                            <?php 
                                endwhile;
                            endwhile;
                            ?>
                            
                            <!-- Summary Rows -->
                            <tr class="gross-pay-row">
                                <td><strong>GROSS PAY</strong></td>
                                <?php for($j=0; $j<count($arraymonth1); $j++): ?>
                                <td class="amount-cell gross-pay-amount">
                                    <?= number_format($arraymonth1[$j], 2, '.', ','); ?>
                                </td>
                                <?php endfor; ?>
                                <td class="amount-cell" id="totalGross">
                                    <strong><?= number_format(array_sum($arraymonth1), 2, '.', ','); ?></strong>
                                </td>
                            </tr>
                            <tr class="deduction-row">
                                <td><strong>DEDUCTION</strong></td>
                                <?php for($k=0; $k<count($arraymonth2); $k++): ?>
                                <td class="amount-cell deduction-amount">
                                    <?= number_format($arraymonth2[$k], 2, '.', ','); ?>
                                </td>
                                <?php endfor; ?>
                                <td class="amount-cell" id="totalDeduction">
                                    <strong><?= number_format(array_sum($arraymonth2), 2, '.', ','); ?></strong>
                                </td>
                            </tr>
                            <tr class="net-pay-row">
                                <td><strong>NET PAY</strong></td>
                                <?php for($l=0; $l<count($arraymonth1); $l++): 
                                    $netpay = $arraymonth1[$l] - $arraymonth2[$l];
                                ?>
                                <td class="amount-cell net-pay-amount">
                                    <?= number_format($netpay, 2, '.', ','); ?>
                                </td>
                                <?php endfor; 
                                $totnetpay = ((array_sum($arraymonth1)) - (array_sum($arraymonth2)));
                                ?>
                                <td class="amount-cell" id="totalNet">
                                    <strong><?= number_format($totnetpay, 2, '.', ','); ?></strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Summary Section -->
                <div class="summary-section">
                    <div class="summary-grid">
                        <div class="summary-item">
                            <span class="summary-label">Total Gross Pay</span>
                            <span class="summary-value summary-gross" id="summaryGross">
                                <?= number_format(array_sum($arraymonth1), 2, '.', ','); ?>
                            </span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Total Deductions</span>
                            <span class="summary-value summary-deduction" id="summaryDeduction">
                                <?= number_format(array_sum($arraymonth2), 2, '.', ','); ?>
                            </span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Net Pay</span>
                            <span class="summary-value summary-net" id="summaryNet">
                                <?= number_format($totnetpay, 2, '.', ','); ?>
                            </span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Report Period</span>
                            <span class="summary-value"><?= $searchyear; ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/employeepayrollreport2-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy scripts for compatibility -->
    <script language="javascript">
        function process1backkeypress1() {
            if (event.keyCode==8) {
                event.keyCode=0; 
                return event.keyCode 
                return false;
            }
        }

        function captureEscapeKey1() {
            if (event.keyCode==8) {
                // Handle backspace key
            }
        }

        window.onload = function () {
            if (typeof AutoSuggestControl !== 'undefined' && document.getElementById("searchemployee")) {
                var oTextbox = new AutoSuggestControl(document.getElementById("searchemployee"), new StateSuggestions());
            }
        }
    </script>
</body>
</html>

