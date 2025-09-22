<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$username = $_SESSION['username'];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$companycode = $_SESSION["companycode"];
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = '';
$bgcolorcode = "";
$colorloopcount = "";

$month = date('M-Y');

// Get company information
$query81 = "select * from master_company where auto_number = '$companyanum'";
$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
$res81 = mysqli_fetch_array($exec81);
$companycode = $res81['companycode'];
$companyname = $res81['employername'];

// Handle form submissions
if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

// Handle success/failure messages
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'success') {
    $errmsg = "Report generated successfully!";
    $bgcolorcode = 'success';
} else if ($st == 'failed') {
    $errmsg = "Failed to generate report.";
    $bgcolorcode = 'error';
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
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/payroll-report-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Legacy CSS for autocomplete -->
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <!-- Legacy JavaScript -->
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
        <a href="employee_master.php">Employee Master</a>
        <span>→</span>
        <span>Payroll Report</span>
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
                        <a href="employee_master.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Employee Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="employeelist1.php" class="nav-link">
                            <i class="fas fa-list"></i>
                            <span>Employee List</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="employeepayrollreport1.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Payroll Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addemployeeinfo.php" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>Add Employee</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="editemployeeinfo1.php" class="nav-link">
                            <i class="fas fa-user-edit"></i>
                            <span>Edit Employee</span>
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
                        <i class="fas fa-<?php echo $bgcolorcode === 'success' ? 'check-circle' : 'exclamation-triangle'; ?> alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Employee Payroll Report</h2>
                    <p>Generate detailed payroll reports for employees with comprehensive breakdown.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportPayrollReport()">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>
            </div>
            
            <!-- Search Report Section -->
            <div class="search-container">
                <div class="section-header">
                    <i class="fas fa-search"></i>
                    <h3>Search Report</h3>
                </div>
                
                <form action="employeepayrollreport1.php" method="post" name="form1" onSubmit="return from1submit1()">
                    <div class="search-form">
                        <div class="search-input-group">
                            <label for="searchemployee" class="search-label">Employee Name</label>
                            <input type="hidden" name="autobuildemployee" id="autobuildemployee">
                            <input type="hidden" name="searchemployeecode" id="searchemployeecode">
                            <input type="text" name="searchemployee" id="searchemployee" autocomplete="off" 
                                   value="<?php echo htmlspecialchars($searchemployee); ?>" 
                                   class="search-input" placeholder="Type employee name...">
                        </div>
                        
                        <div class="search-input-group">
                            <label for="searchyear" class="search-label">Year</label>
                            <select name="searchyear" id="searchyear" class="form-select">
                                <option value="<?php echo $searchyear; ?>"><?php echo $searchyear; ?></option>
                                <?php 
                                for($j=2010;$j<=date('Y');$j++) {
                                    if($j != $searchyear) {
                                ?>
                                <option value="<?php echo $j; ?>"><?php echo $j; ?></option>
                                <?php 
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-actions">
                            <input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1">
                            <button type="submit" name="Search" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                                Generate Report
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="clearSearchForm()">
                                <i class="fas fa-times"></i>
                                Clear
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <?php if($frmflag1 == 'frmflag1'): ?>
            <!-- Payroll Report Section -->
            <div class="report-section">
                <div class="report-header">
                    <div class="report-title">
                        <i class="fas fa-chart-line"></i>
                        <h3>Payroll Employee Report</h3>
                    </div>
                    <div class="report-actions">
                        <button type="button" class="btn btn-outline btn-sm" onclick="printReport()">
                            <i class="fas fa-print"></i>
                            Print
                        </button>
                        <button type="button" class="btn btn-outline btn-sm" onclick="exportToPDF()">
                            <i class="fas fa-file-pdf"></i>
                            Export PDF
                        </button>
                    </div>
                </div>
                
                <!-- Report Information -->
                <div class="report-info">
                    <div class="info-item">
                        <i class="fas fa-building"></i>
                        <div class="info-content">
                            <label>Employer's Code:</label>
                            <span><?php echo htmlspecialchars($companycode); ?></span>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-industry"></i>
                        <div class="info-content">
                            <label>Employer's Name:</label>
                            <span><?php echo htmlspecialchars($companyname); ?></span>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-user"></i>
                        <div class="info-content">
                            <label>Employee's Name:</label>
                            <span><?php echo htmlspecialchars($searchemployee); ?></span>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-calendar"></i>
                        <div class="info-content">
                            <label>Report Year:</label>
                            <span><?php echo htmlspecialchars($searchyear); ?></span>
                        </div>
                    </div>
                </div>
                
                <!-- Payroll Data Table -->
                <div class="table-container">
                    <table class="payroll-table" id="payrollTable">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Month</th>
                                <?php 
                                $query1 = "select auto_number, componentname from master_payrollcomponent where recordstatus <> 'deleted' order by typecode, auto_number";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($res1 = mysqli_fetch_array($exec1)) {
                                    $componentname = $res1['componentname'];
                                ?>
                                <th><?php echo htmlspecialchars($componentname); ?></th>
                                <?php } ?>
                                <th>Gross Pay</th>
                                <th>Deduction</th>
                                <th>Notional Benefit</th>
                                <th>Net Pay</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $totalamount = '0.00';
                            $colorloopcount = 0;
                            $arraymonth = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
                            $monthcount = count($arraymonth);
                            
                            for($i=0;$i<$monthcount;$i++) {
                                $searchmonthyear = $arraymonth[$i].'-'.$searchyear;
                                $totalgrossper = 0;
                                $totaldeduct = 0;
                                
                                $query2 = "select employeecode, employeename from payroll_assign where status <> 'deleted' and employeename like '%$searchemployee%' group by employeename ORDER BY employeecode";
                                $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                                
                                while($res2 = mysqli_fetch_array($exec2)) {
                                    $res2employeecode = $res2['employeecode'];
                                    $res2employeename = $res2['employeename'];
                                    
                                    $colorloopcount = $colorloopcount + 1;
                            ?>
                            <tr>
                                <td><?php echo $colorloopcount; ?></td>
                                <td>
                                    <span class="month-badge">
                                        <?php echo date('F', strtotime($arraymonth[$i])); ?>
                                    </span>
                                </td>
                                <?php 
                                $query1 = "select * from master_payrollcomponent where recordstatus <> 'deleted' order by typecode, auto_number";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($res1 = mysqli_fetch_array($exec1)) {
                                    $componentanum = $res1['auto_number']; 

                                    $query3 = "select `$componentanum` as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
                                    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res3 = mysqli_fetch_array($exec3);
                                    $componentamount = $res3['componentamount'];
                                ?>
                                <td class="amount-cell">
                                    <?php if($componentamount > 0) { echo number_format($componentamount,0,'.',','); } ?>
                                </td>
                                <?php } ?>
                                
                                <?php
                                // Calculate gross pay and deductions
                                $query12 = "select auto_number as ganum, typecode from master_payrollcomponent where recordstatus <> 'deleted'";
                                $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($res12 = mysqli_fetch_array($exec12)) {
                                    $ganum = $res12['ganum'];
                                    $typecode = $res12['typecode'];
                                    
                                    $querygg = "select `$ganum` as res12value from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
                                    $execgg = mysqli_query($GLOBALS["___mysqli_ston"], $querygg) or die ("Error in Querygg".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $resgg = mysqli_fetch_array($execgg);
                                    $res12value = $resgg['res12value'];
                                    if($typecode == 10){
                                        $totalgrossper = $totalgrossper + $res12value; 
                                    } else { 
                                        $totaldeduct = $totaldeduct + $res12value; 
                                    }
                                }
                                $res9grosspay = $totalgrossper;
                                $res91deduction = $totaldeduct;
                                $totalbenefit = '0';
                                $res92nettpay = $res9grosspay - $res91deduction;
                                ?>
                                
                                <td class="amount-cell gross-pay">
                                    <?php if($res9grosspay > 0) { echo number_format($res9grosspay,0,'.',','); } ?>
                                </td>
                                <td class="amount-cell deduction">
                                    <?php if($res91deduction > 0) { echo number_format($res91deduction,0,'.',','); } ?>
                                </td>
                                <td class="amount-cell benefit">
                                    <?php if($totalbenefit > 0) { echo number_format($totalbenefit,0,'.',','); } ?>
                                </td>
                                <td class="amount-cell net-pay">
                                    <?php if($res92nettpay > 0) { echo number_format($res92nettpay-$totalbenefit,0,'.',','); } ?>
                                </td>
                            </tr>
                            <?php 
                                }
                            }
                            
                            if ($colorloopcount == 0):
                            ?>
                            <tr>
                                <td colspan="8" class="no-data">
                                    <i class="fas fa-inbox"></i>
                                    <h3>No Payroll Data Found</h3>
                                    <p>No payroll data found for the selected employee and year. Please check your search criteria.</p>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Report Summary -->
                <div class="report-summary">
                    <div class="summary-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Report Period: <strong><?php echo htmlspecialchars($searchyear); ?></strong></span>
                    </div>
                    <div class="summary-item">
                        <i class="fas fa-user"></i>
                        <span>Employee: <strong><?php echo htmlspecialchars($searchemployee); ?></strong></span>
                    </div>
                    <div class="summary-item">
                        <i class="fas fa-chart-bar"></i>
                        <span>Total Records: <strong><?php echo $colorloopcount; ?></strong></span>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>
    
    <!-- Modern JavaScript -->
    <script src="js/payroll-report-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy JavaScript for compatibility -->
    <script language="javascript">
        // Legacy functions preserved for compatibility
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
        
        function captureEscapeKey1() {
            if (event.keyCode==8) {
                // Handle escape key
            }
        }
        
        function from1submit1() {
            if(document.getElementById("searchemployee").value == "") {
                alert("Please Select Employee");
                document.getElementById("searchemployee").focus();
                return false;		
            }
            return true;
        }
        
        // Modern functions
        function refreshPage() {
            window.location.reload();
        }
        
        function clearSearchForm() {
            document.getElementById('form1').reset();
            document.getElementById('searchemployee').value = '';
            document.getElementById('searchyear').value = '<?php echo date('Y'); ?>';
        }
        
        function exportPayrollReport() {
            if (document.getElementById('payrollTable')) {
                // Create CSV content
                const table = document.getElementById('payrollTable');
                const rows = table.querySelectorAll('tbody tr');
                let csvContent = 'Month,Gross Pay,Deduction,Notional Benefit,Net Pay\n';
                
                rows.forEach(function(row) {
                    const cells = row.querySelectorAll('td');
                    if (cells.length > 1) { // Skip the "no data" row
                        const month = cells[1].textContent.trim();
                        const grossPay = cells[cells.length - 4].textContent.trim();
                        const deduction = cells[cells.length - 3].textContent.trim();
                        const benefit = cells[cells.length - 2].textContent.trim();
                        const netPay = cells[cells.length - 1].textContent.trim();
                        csvContent += `"${month}","${grossPay}","${deduction}","${benefit}","${netPay}"\n`;
                    }
                });
                
                // Download CSV
                const blob = new Blob([csvContent], { type: 'text/csv' });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'payroll_report_<?php echo $searchyear; ?>.csv';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                window.URL.revokeObjectURL(url);
            } else {
                alert('Please generate a report first before exporting.');
            }
        }
        
        function printReport() {
            if (document.getElementById('payrollTable')) {
                window.print();
            } else {
                alert('Please generate a report first before printing.');
            }
        }
        
        function exportToPDF() {
            alert('PDF export functionality would be implemented here using a library like jsPDF or similar.');
        }
    </script>
</body>
</html>
